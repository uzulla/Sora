<?php
namespace Sora\DB\View;

class TimeLine extends \Sora\DB\Base {

    static function get($limit=5,$offset=0){
        $post_list = static::table('post')
            ->join('user_account', 'post.user_account_id', '=', 'user_account.id')
            ->orderBy('post.id', 'desc')
            ->limit($limit+1)
            ->offset($offset)
            ->get([
                'post.id',
                'post.image_filename',
                'post.comment',
                'post.created_at',
                'user_account.login_id'
            ]);

        if(count($post_list)>$limit){
            array_pop($post_list);
            $next_exists=TRUE;
        }else{
            $next_exists=FALSE;
        }

        return [$post_list, $next_exists];
    }

}
