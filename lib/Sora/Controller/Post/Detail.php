<?php
namespace Sora\Controller\Post;

class Detail extends \Sora\Controller\Base {

    public function show ($post_id) {
        $login_id = (isset($_SESSION['login_id']))? $_SESSION['login_id']:null;
        list($post, $iine_list, $comment_list, $already_iine) = \Sora\Db\View\PostDetail::get($post_id, $login_id);
        $this->app->render(
            'Post/Detail/show.html',
            [
                'post'=>$post,
                'iine_list'=>$iine_list,
                'comment_list'=>$comment_list,
                'already_iine'=>$already_iine
            ]
        );
    }
}
