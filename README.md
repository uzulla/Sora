Sora
====

写真をアップロードして「いいね！」したり、コメントをつけたりできるウェブサービスのサンプル

(某件で使う予定でしたがボツになったので供養）


SCREEN SHOT
========

トップページ（未ログイン）
![SS](doc/img/top.png)

サインアップ
![SS](doc/img/signup.png)

タイムライン
![SS](doc/img/timeline.png)

投稿
![SS](doc/img/post.png)

詳細画面
![SS](doc/img/detail.png)

退会
![SS](doc/img/unregister.png)

管理者用画面
![SS](doc/img/admin.png)

SETUP
=====

```
$ composer install
$ sqlite3 sqlite.db < schema.sqlite3.sql
$ cd htdocs
$ php -S 127.0.0.1:8888

open http://127.0.0.1:8888/
```
