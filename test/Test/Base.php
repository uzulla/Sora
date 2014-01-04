<?php
namespace Test;

class Base extends \PHPUnit_Framework_TestCase{
    protected $app;

    public function __construct() {
        parent::__construct();
    }

    // 各テストの前に実行されます。
    protected function setUp(){
        $PDO = \Sora\DB\Base::connection()->getPdo();
        $schema_sql = file_get_contents(TEST_SCHEMA_SQL);
        $PDO->exec($schema_sql);
        $text_fixture_sql = file_get_contents(TEST_FIXTURE_SQL);
        $PDO->exec($text_fixture_sql);

        $app = new \Slim\Slim([
            'templates.path' => TEMPLATES_DIR_PATH,
            'view' => new \Slim\Views\Twig(),
            'log.enabled' => true,
            'debug' => DEBUG
        ]);

        \Sora\Route\Base::registrationRoute($app);

        $this->app = $app;
    }

    // Slim\Mockを利用した結果をPHPHtmlParser\Domで返します
    public function req_dom($path = '/', $method = 'GET', $input='',$option = []){
        $html = $this->req($path, $method, $input, $option);
        $dom = new \PHPHtmlParser\Dom;
        $dom->load($html);
        return $dom;
    }

    // Slim\Mockを利用して、仮想的なレスポンスを取得します
    public function req($path = '/', $method = 'GET', $input='',$option = []){
        // 出力をOBにキャプチャする
        ob_start();
        // Mockを生成、実行
        \Slim\Environment::mock(array_merge([
            'REQUEST_METHOD'  => $method,
            'PATH_INFO'       => $path,
            'slim.input'      => $input,
            'SCRIPT_NAME'     => '',
            'QUERY_STRING'    => '',
            'SERVER_NAME'     => 'localhost',
            'SERVER_PORT'     => 80,
            'ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'ACCEPT_LANGUAGE' => 'ja,en;q=0.7,zh;q=0.3',
            'ACCEPT_CHARSET'  => 'UTF-8',
            'USER_AGENT'      => 'PHP UnitTest',
            'REMOTE_ADDR'     => '127.0.0.1',
            'slim.url_scheme' => 'http',
            'slim.errors'     => @fopen('php://stderr', 'w')
        ], $option));
        $this->app->run();
        // OBを返却しオフに
        return ob_get_clean();
    }
}