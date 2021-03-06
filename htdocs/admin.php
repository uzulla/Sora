<?php
register_shutdown_function(
    function(){
        $e = error_get_last();
        if( $e['type'] == E_ERROR ||
            $e['type'] == E_PARSE ||
            $e['type'] == E_CORE_ERROR ||
            $e['type'] == E_CORE_WARNING ||
            $e['type'] == E_COMPILE_ERROR ||
            $e['type'] == E_COMPILE_WARNING ){
            echo '致命的なエラーが発生しました。';
            if(defined('DEBUG') && DEBUG===TRUE){
                echo "<pre>\n";
                echo "Error type:\t {$e['type']}\n";
                echo "Error message:\t {$e['message']}\n";
                echo "Error file:\t {$e['file']}\n";
                echo "Error line:\t {$e['line']}\n";
            }
        }
    }
);

require_once '../config.php';

$app = new \Slim\Slim([
    'templates.path' => TEMPLATES_DIR_PATH,
    'view' => new \Slim\Views\Twig(),
    'log.enabled' => true,
    'debug' => DEBUG
]);

// admin.php全体にDigest認証をかけます
$app->add(new \Slim\Extras\Middleware\HttpDigestAuth(
    [ADMIN_USER_NAME => ADMIN_PASSWORD]
));

$app->get('/', function () {
    (new \Sora\Controller\Admin\Page\Top())->index();
});

$app->get('/UserAccount/CSV/download', function () {
    (new \Sora\Controller\Admin\UserAccount\Csv())->download();
});

$app->run();

