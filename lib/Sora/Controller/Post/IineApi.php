<?php
namespace Sora\Controller\Post;

use \Sora\DB\Model;

class IineApi extends \Sora\Controller\JsonApiBase {
    public function set_iine(){
        $post = Model\Post::findOrFail($this->params('post_id'));
        $iine = Model\Iine::firstByAttributes(['post_id'=>$post->id, 'user_account_id'=>$this->user_account['id']]);
        if(empty($iine)){
            $iine = new Model\Iine;
            $iine->post_id = $post->id;
            $iine->user_account_id = $this->user_account['id'];
            $iine->save();
        }

        // response json
        $this->setResponseJson([
            'status' => 'ok',
            'login_id' => $this->user_account['login_id']
        ]);
    }

    public function unset_iine(){
        $post_id = $this->params('post_id');
        Model\Iine::firstByAttributes(['post_id'=>$post_id, 'user_account_id'=>$this->user_account['id']])->delete();
        // response json
        $this->setResponseJson([
            'status' => 'ok',
            'login_id' => $this->user_account['login_id']
        ]);
    }
}
