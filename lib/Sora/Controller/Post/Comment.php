<?php
namespace Sora\Controller\Post;

use \Sora\DB\Model;

class Comment extends \Sora\Controller\LoggedInBase {

    public function save(){
        $post_id = $this->params('post_id');
        $comment_text = $this->params('comment');

        $post = Model\Post::findOrFail($post_id);
        // commentを作成
        $comment = new Model\Comment;
        $comment->post_id = $post->id;
        $comment->user_account_id = $this->user_account['id'];
        $comment->comment = $comment_text;
        $comment->save();
        // 詳細画面へ戻す
        $this->app->redirect('/detail/'.$post_id);
    }

    public function delete(){
        $comment_id = $this->params('comment_id');
        $post_id = $this->params('post_id');
        Model\Comment::findOrFail($comment_id)->delete();
        // 詳細画面へ戻す
        $this->app->redirect('/detail/'.$post_id);
    }
}
