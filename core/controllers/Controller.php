<?php
/**
 * Created by PhpStorm.
 * User: bisikennadi
 * Date: 4/22/15
 * Time: 12:47 PM 
 * */

namespace core\controllers;

use core\models\User;
use core\models\ApiLog;
use core\utilities\Response;

class Controller
{
    var $api;
    var $response;
    var $user;
    var $api_log;

    function __construct()
    {
        $this->response = new Response();
        $this->user = new User();
        $this->api_log = new ApiLog();
    }

    function initialize($api, $user=null)
    {
        $this->api = $api;
        $this->user = $user;
        //$this->api_log->api_log_user_serialized = serialize(array('user_id'=>$user->user_id, 'user_auth_token'=>$user->user_auth_token));
        $this->api_log->api_log_get_serialized = serialize($api->getGet());
        $this->api_log->api_log_post_serialized = serialize($api->getPost());
        $this->api_log->api_log_files_serialized = serialize($api->getFiles());
        $this->api_log->api_log_server_serialized = serialize($api->getServer());
        $this->api_log->create();
    }
    function respond()
    {
        $this->api_log->api_log_response_serialized = serialize($this->response);
        $this->api_log->update();
        echo json_encode(array('success'=>$this->response->getStatus(),
            'data'=>$this->response->getData(),
            'messages'=>$this->response->getMessages()));
    }


}