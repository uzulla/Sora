<?php
namespace Test\DB\View;

use \Sora\DB\View\PostDetail;

class PostDetailTest extends \Test\Base{
    public function testPostDetail(){
        list($post, $iine_list, $comment_list, $already_iine) = PostDetail::get(1);

        $this->assertNotEmpty($post);
        $this->assertCount(5,$post);
        $this->assertArrayHasKey('id', $post);
        $this->assertEquals(1, $post['id']);
        $this->assertArrayHasKey('image_filename', $post);
        $this->assertEquals(1, preg_match('/[a-zA-Z0-9]{16}\.(jpg|gif|png)/', $post['image_filename']));
        $this->assertArrayHasKey('comment', $post);
        $this->assertEquals('test comment', $post['comment']);
        $this->assertArrayHasKey('created_at', $post);
        $this->assertEquals(1, preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $post['created_at']));
        $this->assertArrayHasKey('login_id', $post);
        $this->assertEquals('user_id_1', $post['login_id']);

        $this->assertNotEmpty($iine_list);
        $this->assertCount(5,$iine_list);
        $this->assertArrayHasKey('login_id', $iine_list[0]);
        $this->assertEquals('user_id_1', $iine_list[0]['login_id']);

        $this->assertNotEmpty($comment_list);
        $this->assertCount(3,$comment_list);
        $this->assertArrayHasKey('login_id', $comment_list[0]);
        $this->assertArrayHasKey('comment', $comment_list[0]);
        $this->assertArrayHasKey('created_at', $comment_list[0]);

        $this->assertFalse($already_iine); // ユーザーID未指定なので、必ずFalse

        list($post, $iine_list, $comment_list, $already_iine) = PostDetail::get(1, 'user_id_1');
        $this->assertTrue($already_iine);
    }
}