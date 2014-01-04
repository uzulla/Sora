<?php
namespace Sora\Controller\UserAccount;

class DeleteWithOutLogin extends \Sora\Controller\Base {
    public function done(){
        $this->app->render('UserAccount/Delete/done.html');
    }
}
