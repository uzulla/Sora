<?php
namespace Sora\Controller\Page;

class TimeLine extends \Sora\Controller\Base {
    public function show ($page_num) {
        $offset = POST_PER_PAGE*($page_num-1);
        list($post_list, $next_page_exists) = \Sora\DB\View\TimeLine::get(POST_PER_PAGE, $offset);
        $this->app->render(
            'Page/TimeLine/show.html',
            [
                'post_list'=>$post_list,
                'page_num'=>$page_num,
                'next_page_exists'=>$next_page_exists
            ]
        );
    }
}
