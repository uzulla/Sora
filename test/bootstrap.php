<?php

// テスト用クラスのためのオートローダー
set_include_path("./");
spl_autoload_register(function($class) {
    $parts = explode('\\', $class);
    $parts[] = str_replace('_', DIRECTORY_SEPARATOR, array_pop($parts));
    $path = implode(DIRECTORY_SEPARATOR, $parts);
    $file = stream_resolve_include_path($path.'.php');
    if($file !== false) {
        require $file;
    }
});

// テスト用DBの設定
$db_settings = array(
    'driver' => 'sqlite',
    'database' => ":memory:",
);

// テスト用DBスキーマとダミーデータのSQL指定
define("TEST_SCHEMA_SQL", __DIR__."/../schema.sqlite3.sql");
define("TEST_FIXTURE_SQL", __DIR__."/fixture.sqlite3.sql");

require_once '../config.php';
