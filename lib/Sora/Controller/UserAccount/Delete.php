<?php
namespace Sora\Controller\UserAccount;

use \Sora\DB\Model;

class Delete extends \Sora\Controller\LoggedInBase {
    public function confirm(){
        $user = Model\UserAccount::findOrFail($this->user_account['id']);
        // 確認画面を表示
        $this->app->render(
            'UserAccount/Delete/confirm.html',
            ['user'=>$user]
        );
    }

    public function commit(){
        $app = $this->app;

        $error_list = [];
        // 同意チェック
        if($this->params('agree')!=='1'){
            $error_list['agree'] = '確認して、チェックボックスをONにしてください';
        }
        // ユーザー存在チェック
        $user = Model\UserAccount::findOrFail($this->user_account['id']);
        // パスワードチェック
        $password = $this->params('password');
        if(!$user->checkPassword($password)){
            $error_list['password'] = 'パスワードが間違っています';
        }

        // エラーがあるので、再度確認画面を表示
        if(!empty($error_list)){
            $app->render(
                'UserAccount/Delete/confirm.html',
                [
                    'form_values'=>$this->params(),
                    'error_list'=>$error_list
                ]
            );
            return;
        }
        // ユーザー削除実行
        $user->delete();
        $this->destorySession();
        // 完了画面へリダイレクト
        $app->redirect('/account/delete/done');
    }

    public function done(){
        $this->app->render('UserAccount/Delete/done.html');
    }
}
