<?php
namespace Sora\Controller\Page;

class Top extends \Sora\Controller\Base {
    public function index () {
        list($post_list, $next_page_exists) = \Sora\DB\View\TimeLine::get(POST_PER_PAGE);
        if(isset($_SESSION['login_id'])){
            $template = 'Page/TimeLine/show.html';
        }else{
            $template = 'Page/Top/index.html';
        }
        $this->app->render(
            $template,
            [
                'post_list'=>$post_list,
                'page_num'=>1,
                'next_page_exists'=>$next_page_exists
            ]
        );
    }
}
