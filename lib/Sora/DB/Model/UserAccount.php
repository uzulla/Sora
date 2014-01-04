<?php
namespace Sora\DB\Model;

class UserAccount extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'user_account';

    public function setPasswordByPlain($password){
        $this->hashed_password = static::generatePasswordHash($password);
    }

    private static function generatePasswordHash($str){
        $salt = static::generateRandomStr(PASSWORD_SALT_LENGTH);
        return $salt.static::stretchSha256($salt.$str, PASSWORD_STRETCH_TIMES);
    }

    // ランダムな文字列を生成する
    static function generateRandomStr($len = 8){
        $char_list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random_str = "";
        for($i = 0; $i < $len; $i++){
            $random_str .= $char_list{ rand(0, strlen($char_list) - 1) };
        }
        return $random_str;
    }

    static function getByLoginIdAndPassowrd($login_id, $password){
        $user = static::firstByAttributes(['login_id'=>$login_id]);
        if(empty($user)){ // ログインIDがみつからない
            return FALSE;
        }
        if($user->checkPassword($password)){
            return $user;
        }else{
            return FALSE;
        }
    }

    public function checkPassword($password){
        // 保存されているハッシュから、salt文字列をとりだし
        $salt = substr($this->hashed_password, 0, PASSWORD_SALT_LENGTH);
        // saltを用いて入力パスワードをハッシュ化し
        $hashed_input_password = $salt.static::stretchSha256($salt.$password, PASSWORD_STRETCH_TIMES);
        // ハッシュが一致するか確認
        return ($this->hashed_password === $hashed_input_password) ? TRUE : FALSE;
    }

    private static function stretchSha256($str, $times){
        for($i=0;$i<$times;$i++){
            $str = hash('sha256', $str);
        }
        return $str;
    }

    public function delete(){
        try{
            \Sora\DB\Base::begin();
            // コメントを削除する
            Comment::where('user_account_id', $this->id)->delete();
            // いいね！を削除する
            Iine::where('user_account_id', $this->id)->delete();
            // ユーザーのポストをすべて取得
            Post::where('user_account_id', $this->id)->delete();
            // ユーザーアカウントを削除する
            parent::delete();
            \Sora\DB\Base::commit();
        }catch (\Exception $e){
            error_log("file:".$e->getFile()." line:".$e->getLine()." message:".$e->getMessage());
            \Sora\DB\Base::rollback();
            throw $e;
        }
    }
}
