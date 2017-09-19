<?php
namespace core\controllers;

use core\models\User;

/**
 * 
 * @var mixed
 */
class UserController extends Controller
{
    /**
     * index
     * @param mixed $parameter 
     * @return mixed 
     */
    function index($parameter = 0)
    {

        if ($this->api->isPost()) {

        } else {
            $user = new User();
            $users = array();
            if ($parameter > 0) {
                $read_user = $user->read($parameter);
                if (!empty($read_user))
                    $users = array($read_user);
            }
            else
                $users = $user->getAll();
            $data = array();
            foreach ($users AS $this_user) {
                $data_array = array(
                    'id'=>$this_user['user_id'],
                    'user_fb_id'=>$this_user['user_fb_id'],
                    'created_date'=>$this_user['user_created_date']
                );
                array_push($data, $data_array);
            }
            $this->response->addData('users', $data);
            $this->response->setStatus(true);
        }
    }

    function create($parameter = 0)
    {
        if ($this->api->isPost()) {
            $user = new User();

            $post_data = $this->api->getPost();
           
            $signed_data = $user->parse_signed_request(trim($post_data['signed_request']));

            if (is_null($signed_data)) {
                $this->response->setStatus(false);
                $this->response->addMessage('errors', 'create', 'Bad Signed JSON signature!');
                return;
            }

            $user->user_fb_id = $signed_data['user_id'];
            $user->user_oauth_token = $signed_data['oauth_token'];
            $user->user_expires = $signed_data['expires'];
            $user->user_issued_at = $signed_data['issued_at'];
            $user->user_country = $signed_data['user']['country'];
            $user->user_min_age = $signed_data['user']['age']["min"];
            $user->user_created_date = date('Y-m-d G:i:s', time());

            $user->create();
            $this->response->setStatus(true);
            $this->response->addData('user_id', $user->user_id);
            $this->response->addData('user_fb_id', $user->user_fb_id);
            $this->response->addData('user_oauth_token', $user->user_oauth_token);
            $this->response->addData('user_country', $user->user_country);
            $this->response->addData('user_min_age', $user->user_min_age);
            $this->response->addMessage('successes', 'create', 'User has been created.');
            
        }
    }

    function total($parameter=0)
    {
        if (!$this->api->isPost()) {
            $user = new User();
            $total = $user->count();
            $this->response->setStatus(true);
            $this->response->addData('total', $total);
            $this->response->addMessage('successes', 'total', 'Total number of users.');
        }
    }
}