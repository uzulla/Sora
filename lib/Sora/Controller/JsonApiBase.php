<?php
namespace Sora\Controller;

class JsonApiBase extends \Sora\Controller\LoggedInBase {

    public function __construct(){
        parent::__construct();
        // XSS対策
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            error_log('Require HTTP_X_REQUESTED_WITH header');
            $this->app->halt(400, 'Require HTTP_X_REQUESTED_WITH header');
        }
    }

    public function setResponseJson($data, $status_code=200){
        $response = $this->app->response();
        $response['Content-Type'] = 'application/json; charset=UTF-8';
        $response['Pragma'] = 'no-cache';
        $response['Cache-Control'] = 'no-store';
        $response['X-Content-Type-Options'] = 'nosniff';
        $response->status($status_code);
        $response->body(json_encode($data,  JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP));
    }
}
