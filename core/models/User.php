<?php
namespace core\models;

use core\dao\UserDAO;

class User extends Model
{
    var $user_id;
    var $user_fb_id;
    var $user_expires;
    var $user_oauth_token;
    var $user_created_date;
    var $user_visible;

    function __construct()
    {
        parent::__construct();
        $this->dao = new UserDAO();
        $this->user_id = 0;
        $this->user_fb_id = 0;
        $this->user_expires = '';
        $this->user_oauth_token = '';
        $this->user_country = '';
        $this->user_min_age = 0;
        $this->user_issued_at = 0;
        $this->user_created_date = 0;
        $this->user_visible = 1;

        
        $this->create_success_message = 'User successfully saved.';
        $this->update_success_message = 'User successfully updated.';
        $this->create_failure_message = 'User failed to be saved.';
        $this->update_failure_message = 'User failed to be updated';
    }

    function create()
    {
        parent::create();
    }

    function count()
    {
        return $this->dao->countAll();
    }

    function parse_signed_request($signed_request)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
        
        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
        
        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, FB_APP_SECRET, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }
        
        return $data;
    }
  
    function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    function getValidationMessages()
    {

        return $messages = [];
    }

    
}
