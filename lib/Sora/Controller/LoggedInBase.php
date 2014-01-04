<?php
namespace Sora\Controller;

// ログイン中のルートはこのコントローラを継承する
// コンストラクタの中で、ユーザーがログインしているか確認し、ユーザー情報を保存する
class LoggedInBase extends \Sora\Controller\Base {
    protected $user_account;

    public function __construct(){
        parent::__construct();

        try{
            // ログインセッションが存在するか
            if(!isset($_SESSION['user_account_id'])){
                throw(new \Exception('Login session not found.'));
            }

            // セッション内のuser_account_idを元にDBをチェック
            $user = \Sora\DB\Model\UserAccount::find($_SESSION['user_account_id']);
            if(empty($user)){
                // 存在しないuser_account_idであり、異常なので消去。
                $_SESSION = [];
                throw(new \Exception('Session user not found'));
            }

            // 取得したユーザーアカウント情報を保持しておく
            $this->user_account = $user->toArray();

        }catch(\Exception $e){
            error_log($e->getMessage());
            // ログインしていない場合は、トップページにリダイレクトする
            $this->app->redirect('/');
        }
    }
}
