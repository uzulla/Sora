<?php
namespace Sora\Route;

use \Sora\Controller;

class Base {

    static function registrationRoute($app=null){
        if(is_null($app)){
            $app = \Slim\Slim::getInstance();
        }

        // multi-part時、slimはrequest->params()系がつかえなくなり、
        // それを参照しているcsrf guardが動作しなくなるので、オフにする必要がある。
        $app->add(new \Slim\Extras\Middleware\CsrfGuard(SLIM_CSRF_DEFENDER_KEY_NAME));

        $app->error(function (\Exception $e) use ($app) {
            error_log("file:".$e->getFile()." line:".$e->getLine()." message:".$e->getMessage());
            $app->render('error.html');
        });

        $app->get('/', function () {
            (new Controller\Page\Top())->index();
        });

        $app->map('/account/signup/form', function () {
            (new Controller\UserAccount\SignUp())->form();
        })->via('GET','POST');

        $app->post('/account/signup/confirm', function () {
            (new Controller\UserAccount\SignUp())->confirm();
        });

        $app->post('/account/signup/commit', function () {
            (new Controller\UserAccount\SignUp())->commit();
        });

        $app->get('/account/signup/done', function () {
            (new Controller\UserAccount\SignUp())->done();
        });

        $app->post('/account/auth/login', function () {
            (new Controller\UserAccount\Auth())->login();
        });

        $app->get('/account/auth/logout', function () {
            (new Controller\UserAccount\Auth())->logout();
        });

        $app->get('/post/upload/form', function () {
            (new Controller\Post\Upload())->form();
        });

        $app->post('/post/upload/save', function () {
            (new Controller\Post\Upload())->save();
        });

        $app->get('/detail/:post_id', function ($post_id) {
            (new Controller\Post\Detail())->show($post_id);
        });

        $app->get('/page/:page_num', function ($page_num) {
            (new Controller\Page\TimeLine())->show($page_num);
        });

        $app->post('/post/iine/set', function () {
            (new Controller\Post\IineApi())->set_iine();
        });

        $app->post('/post/iine/unset', function () {
            (new Controller\Post\IineApi())->unset_iine();
        });

        $app->post('/post/comment/save', function () {
            (new Controller\Post\Comment())->save();
        });

        $app->post('/post/comment/delete', function () {
            (new Controller\Post\Comment())->delete();
        });

        $app->post('/post/delete/confirm', function () {
            (new Controller\Post\Delete())->confirm();
        });

        $app->post('/post/delete/commit', function () {
            (new Controller\Post\Delete())->commit();
        });

        $app->get('/post/delete/done', function () {
            (new Controller\Post\Delete())->done();
        });

        $app->get('/account/delete/confirm', function () {
            (new Controller\UserAccount\Delete())->confirm();
        });

        $app->post('/account/delete/commit', function () {
            (new Controller\UserAccount\Delete())->commit();
        });

        $app->get('/account/delete/done', function () {
            (new Controller\UserAccount\DeleteWithOutLogin())->done();
        });
    }
}