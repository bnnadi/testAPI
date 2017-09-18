<?php
namespace core\dao;

class ApiLogDAO extends \core\dao\DAO
{
 
    function __construct()
    {
        parent::__construct();
        $this->table = 'api_logs';
        $this->id_column = 'api_log_id';
        $this->model = '\core\model\ApiLog';
        $this->table_fields = array('api_log_user_serialized', 'api_log_get_serialized', 'api_log_post_serialized','api_log_files_serialized','api_log_server_serialized','api_log_response_serialized');
        $this->visible_field = '';
    }

}
