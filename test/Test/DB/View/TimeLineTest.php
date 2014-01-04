<?php
namespace Test\DB\View;

use \Sora\DB\View\TimeLine;

class TimeLineTest extends \Test\Base{
    public function testTimeLine(){
        list($post_list, $next_exists) = TimeLine::get();
        $this->assertCount(5, $post_list); // default limit

        list($post_list, $next_exists) = TimeLine::get(3);
        $this->assertCount(3, $post_list);
        $this->assertTrue($next_exists);

        list($post_list, $next_exists) = TimeLine::get(9999);
        $this->assertFalse($next_exists);

        list($post_list, $next_exists) = TimeLine::get(2);
        list($first_post_list, $next_exists) = TimeLine::get(1,0);
        list($second_post_list, $next_exists) = TimeLine::get(1,1);

        $this->assertEquals($post_list[0], $first_post_list[0]);
        $this->assertNotEquals($post_list[0], $second_post_list[0]);
        $this->assertEquals($post_list[1], $second_post_list[0]);
    }
}