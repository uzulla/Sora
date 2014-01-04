<?php
namespace Test\Controller\Page;

class TopTest extends \Test\Base{
    public function testTopPage(){
        $dom = $this->req_dom('/');
        $this->assertEquals('Sora', $dom->find('title', 0)->text);
        $this->assertCount(1, $dom->find('input[value=ログイン]'));
        $this->assertCount(5, $dom->find('div.timeline_cell'));
        $this->assertEquals('/page/2', $dom->find('ul.pagination li.active a', 0)->getAttribute('href'));
    }

    public function testLoggedInTopPage(){
        // ログイン中の動作を確認するために、セッションをダミー作成
        $_SESSION[] = [];
        $_SESSION['user_account_id'] = 1;
        $_SESSION['login_id'] = 'user_id_1';

        $dom = $this->req_dom('/');
        $this->assertEquals('Sora', $dom->find('title', 0)->text);

        $this->assertCount(0, $dom->find('input[value=ログイン]'));
        $this->assertContains('user_id_1', $dom->find('li.dropdown a', 0)->text);

        $this->assertCount(5, $dom->find('div.timeline_cell'));
        $this->assertEquals('/page/2', $dom->find('ul.pagination li.active a', 0)->getAttribute('href'));

        // ダミーセッション削除
        $_SESSION[] = [];
    }
}