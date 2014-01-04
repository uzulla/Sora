<?php
namespace Sora\Controller\UserAccount;

use \Sora\DB\Model;

class SignUp extends \Sora\Controller\Base {

    public function form () {
        $this->app->render(
            'UserAccount/SignUp/form.html',
            ['form_values'=>$this->params()]
        );
    }

    public function confirm () {
        $form_values = $this->params();
        $error_list = static::validate($form_values);
        if( !empty($error_list) ){
            // 入力チェックにNG項目あり
            $this->app->render(
                'UserAccount/SignUp/form.html',
                ['form_values'=>$form_values, 'error_list'=>$error_list]
            );
        }else{
            // 入力チェックOK
            $this->app->render(
                'UserAccount/SignUp/confirm.html',
                ['form_values'=>$form_values]
            );
        }
    }

    public function commit () {
        $app = $this->app;
        $form_values = $this->params();
        $error_list = static::validate($form_values);
        if( !empty($error_list) ){
            $app->render(
                'UserAccount/SignUp/form.html',
                ['form_values'=>$form_values, 'error_list'=>$error_list]
            );
        }else{
            $user = new Model\UserAccount;
            $user->setPasswordByPlain($form_values['password']);
            $user->login_id = $form_values['login_id'];
            $user->save();
            $app->redirect('/account/signup/done');
        }
    }

    public function done () {
        $this->app->render('UserAccount/SignUp/done.html');
    }

    private static function validate($form_values){
        $error_list = [];

        // login_id
        $user = Model\UserAccount::firstByAttributes(['login_id'=>$form_values['login_id']]);
        if( !empty($user) ){
            $error_list['login_id'] = 'すでにそのログインIDは利用されています、別のものを利用してください';
        }
        if( mb_strlen($form_values['login_id'])==0 ){
            $error_list['login_id'] = 'ログインIDが入力されていません';
        }
        if(!preg_match("/\A[a-z0-9]+\z/u", $form_values['login_id'])){
            $error_list['login_id'] = 'ログインIDに利用できない文字がふくまれています';
        }
        if( mb_strlen($form_values['login_id'])>16 ){
            $error_list['login_id'] = 'ログインIDが長すぎます、最大16文字です';
        }

        // password
        if( mb_strlen($form_values['password'])==0 ){
            $error_list['password'] = 'パスワードが入力されていません';
        }
        if( $form_values['password']!==$form_values['password_check'] ){
            $error_list['password_check'] = 'パスワードとパスワード（確認）が一致しません';
        }

        // agree
        if( !isset($form_values['agree']) || $form_values['agree']!=='1' ){
            $error_list['agree'] = '規約に同意してください';
        }

        return $error_list;
    }

}
