<?php
namespace Sora\DB\View;

class PostDetail extends \Sora\DB\Base {

    static function get($post_id, $login_id=null){

        $post = static::table('post')
            ->join('user_account', 'post.user_account_id', '=', 'user_account.id')
            ->where('post.id', $post_id)
            ->get([
                'post.id',
                'post.image_filename',
                'post.comment',
                'post.created_at',
                'user_account.login_id'
            ])[0];

        $iine_list = static::table('iine')
            ->join('user_account', 'iine.user_account_id', '=', 'user_account.id')
            ->where('iine.post_id', $post_id)
            ->get([
                'user_account.login_id'
            ]);

        $comment_list = static::table('comment')
            ->join('user_account', 'comment.user_account_id', '=', 'user_account.id')
            ->where('comment.post_id', $post_id)
            ->get([
                'user_account.login_id',
                'comment.id',
                'comment.comment',
                'comment.created_at'
            ]);

        $already_iine = false;
        if(!is_null($login_id)){
            // 自分がいいね！しているかチェック
            foreach($iine_list as $iine){
                if($iine['login_id']===$login_id){
                    $already_iine = true;
                }
            }
        }

        return [$post, $iine_list, $comment_list, $already_iine];
    }

}
