<?php
namespace Sora\Controller\Post;

use \Sora\DB\Model;

class Upload extends \Sora\Controller\LoggedInBase {

    public function form(){
        $this->app->render('Post/Upload/form.html');
    }

    public function save(){
        $app = $this->app;

        //バリデーション
        $error_list = [];

        $form_values = $this->params();
        $comment = $form_values['comment'];
        if(mb_strlen($comment)>1000){
            $error_list['comment'] = 'コメントは1000文字以下にしてください';
        }

        // ファイルがアップロードされているか確認
        if( isset($_FILES['pic']) && mb_strlen($_FILES['pic']['tmp_name'])>0 ){
            $pic = $_FILES['pic'];
            if($pic['size'] < POST_IMAGE_MAX_FILE_SIZE){ //ファイルサイズは5Mbyte以下が必要
                // ファイルを解析し、どのような画像フォーマットか確認
                $image_info = getimagesize($pic['tmp_name']);
                $type = $image_info[2]; // $image_info[2]には、画像の形式が入ります。
                //アップロードされた画像が、Jpeg,PNG,GIFいずれかであるか確認
                if( $type!=IMAGETYPE_JPEG && $type!=IMAGETYPE_GIF && $type!=IMAGETYPE_PNG ){
                    $error_list['pic'] = 'Jpeg、PNG、GIF以外の形式はアップロードできません';
                }
            }else{
                $error_list['pic'] = '画像サイズは'.(POST_IMAGE_MAX_FILE_SIZE/(1024*1024)).'Mbyte未満にしてください';
            }
        }else{
            $error_list['pic'] = '画像ファイルがセットされていません';
        }

        if(!empty($error_list)){ // エラーがあるのでフォームを再表示
            $app->render(
                'Post/Upload/form.html',
                [
                    'error_list'=>$error_list,
                    'form_values'=>$form_values
                ]
            );
            return;
        }

        // 投稿保存処理を開始
        $file_suffix = static::$imagetype_list[$type]; // ファイルの拡張子を決める
        $random_id = static::generateRandomStr(16); // ファイル名のために16文字のランダムな文字列を生成する
        $pic_file_name = "{$random_id}.{$file_suffix}"; // 保存する画像ファイル名
        $pic_file_path = POST_IMAGE_DIR."/".$pic_file_name; // 画像ファイル保存先

        // 同名のファイルがないか確認。非常に低い発生確率なのでリトライせずエラーとします。
        if(file_exists($pic_file_path)){
            throw( new \Exception('pic_file_path exists'));
        }
        // アップロードされたファイルを公開ディレクトリに移動
        move_uploaded_file($pic['tmp_name'], $pic_file_path);

        try{
            $post = new Model\Post;
            $post->user_account_id = $this->user_account['id'];
            $post->image_filename = $pic_file_name;
            $post->comment = $comment;
            $post->save();
        }catch(\Exception $e){
            unlink($pic_file_path); // 登録に失敗したので、ファイルを削除
            throw $e;
        }

        $app->redirect('/');
    }

    // IMAGETYPE_***と対応するファイルの拡張子の配列
    static $imagetype_list = [
        IMAGETYPE_JPEG=>'jpg',
        IMAGETYPE_GIF=>'gif',
        IMAGETYPE_PNG=>'png'
    ];

    // ランダムな文字列を生成
    static function generateRandomStr($len = 8){
        $char_list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random_str = "";
        for($i = 0; $i < $len; $i++){
            $random_str .= $char_list{ rand(0, strlen($char_list) - 1) };
        }
        return $random_str;
    }
}
