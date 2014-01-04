テスト実行方法
============

#### 準備

事前にComposerなどでphpunitをインストールが必要です。

#### 全テスト実行

```
php ../vendor/bin/phpunit
```

#### 単テスト実行

```
php ../vendor/bin/phpunit Test/Controller/Page/TopTest.php
```

####ディレクトリ以下のテスト実行

```
php ../vendor/bin/phpunit Test/Controller/
```

> PHPUnit でディレクトリを指定した場合、`*Test.php`のファイルが再帰的に読み込まれ、実行されます。

> PHPUnitのドキュメント  
> http://phpunit.de/manual/3.8/ja/index.html


ファイル解説
===============

|ファイル名 | 概要|
|:-
| `phpunit.xml`| PHPUnit設定ファイル|
| `bootstrap.php`| `phpunit.xml`で指定された、テスト実行時に実行されるコード、lib以下のオートロードなど|
| `fixture.sqlite3.sql`| テスト時に投入されるダミーデータ|
| `Test`| テスト用クラスの集合|
| `Test\Base.php`| テスト用のベースクラス、初期化やユーティリティ関数など|
| `Test\*\*Test.php`| PHPUnitテスト定義|


