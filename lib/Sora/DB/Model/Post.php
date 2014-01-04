<?php
namespace Sora\DB\Model;

use \Sora\DB\Model;

class Post extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'post';

    static function findOrFailWithUserAccountId($post_id, $user_account_id){
        $post = static::findOrFail($post_id);
        if($post->user_account_id != $user_account_id){
            throw new \Exception('This post is not yours.');
        }
        return $post;
    }

    public function delete(){
        try{
            \Sora\DB\Base::begin();
            // コメントを削除する
            Model\Comment::where('post_id', '=', $this->id)->delete();
            // いいね！を削除する
            Model\Iine::where('post_id', '=', $this->id)->delete();
            // ポスト画像を削除する
            @unlink(POST_IMAGE_DIR.'/'.$this->image_filename);
            // 投稿自体を削除する
            parent::delete();
            \Sora\DB\Base::commit();
        }catch(\Exception $e){
            error_log("file:".$e->getFile()." line:".$e->getLine()." message:".$e->getMessage());
            \Sora\DB\Base::rollback();
            throw $e;
        }
    }
}
