<?php
namespace Sora\Controller\Admin\Page;

class Top extends \Sora\Controller\Base {
    public function index () {
        $this->app->render(
            'Admin/Page/Top/index.html',[]
        );
    }
}
