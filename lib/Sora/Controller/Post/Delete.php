<?php
namespace Sora\Controller\Post;

use \Sora\DB\Model;

class Delete extends \Sora\Controller\LoggedInBase {

    public function confirm(){
        $post_id = $this->params('post_id');
        $post = Model\Post::findOrFailWithUserAccountId($post_id, $this->user_account['id']);
        // 確認画面を表示
        $this->app->render('Post/Delete/form.html',['post'=>$post]);
    }

    public function commit(){
        $post_id = $this->params('post_id');
        // 指定postが実在し、自分の投稿かチェック、問題なければ削除
        Model\Post::findOrFailWithUserAccountId($post_id, $this->user_account['id'])->delete();
        // 完了画面へリダイレクト
        $this->app->redirect('/post/delete/done');
    }

    public function done(){
        $this->app->render('Post/Delete/done.html');
    }
}
