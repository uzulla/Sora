<?php
namespace Sora\Controller\UserAccount;

use \Sora\DB\Model;

class Auth extends \Sora\Controller\Base {
    public function login () {
        $app = $this->app;
        $form_values = $this->params();
        $user_account = Model\UserAccount::getByLoginIdAndPassowrd($form_values['login_id'], $form_values['password']);

        if( $user_account ){ //ログイン成功
            //安全のためにセッションを作り直す
            $this->rebuildSession();
            // ログインセッション作成
            $_SESSION['login_id'] = $user_account->login_id; // login_idをセッションに保存
            $_SESSION['user_account_id'] = $user_account->id; // user_accountテーブルにおける主キーをセッションに保存

            $app->redirect('/');
        }else{ // ログイン失敗
            $app->render('UserAccount/Auth/loginFail.html', ['form_values'=>$form_values]);
        }
    }

    public function logout () {
        $this->destorySession();
        $this->app->redirect('/');
    }
}
