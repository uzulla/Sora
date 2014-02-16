<?php
namespace Sora\Controller;

// すべてのコントローラクラスの基底
// Slimのインスタンスをインスタンス変数に保存する
class Base {
    protected $app;

    public function __construct(){
        $this->app = \Slim\Slim::getInstance();
        // login_idは頻繁に使う為、セッションに保存されていればビュー変数に登録しておく
        if(isset($_SESSION['login_id'])){
            $this->app->view()->appendData([
                'login_id' => $_SESSION['login_id']
            ]);
        }
        // クリックジャッキング対策
        $response = $this->app->response();
        $response['X-frame-options'] = 'DENY';
    }

    public function destorySession(){
        // セッション情報削除
        $_SESSION = [];
        // セッションクッキーも削除する
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 10000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // セッションを破壊する
        session_destroy();
    }

    public function rebuildSession(){
        session_regenerate_id();
        $_SESSION = [];
    }

    public function params($key=null){
        return $this->app->request->params($key);
    }
}
