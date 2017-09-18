<?php
namespace core\dao;

class UserDAO extends \core\dao\DAO
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->id_column = 'user_id';
        $this->model = '\core\model\User';
        $this->table_fields = array('user_fb_id', 'user_expires', 'user_oauth_token','user_country', 'user_min_age','user_issued_at', 'user_created_date');
        $this->visible_field = 'user_visible';
    }

}