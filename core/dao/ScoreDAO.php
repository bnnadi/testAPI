<?php
namespace core\dao;

class ScoreDAO extends \core\dao\DAO
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'scores';
        $this->id_column = 'score_id';
        $this->model = '\core\model\Score';
        $this->table_fields = array('score_uid', 'score_value', 'score_created_date');
        $this->visible_field = 'score_visible';
    }

    function getTopTen()
	{
		$query = "SELECT * FROM {$this->table} ORDER BY {$this->table}.score_value DESC LIMIT 10";
		$params = array();
		$scores = $this::getConnection()->query($query, $params);
		return $scores;
	}

    function getTodayHighScore()
	{
		$query = "SELECT score_uid, MAX(score_value) AS hiscore, DATE(score_created_date) AS sdate FROM {$this->table} WHERE {$this->table}.score_created_date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
		$params = array();
		$scores = $this::getConnection()->query($query, $params);
		return $scores;
    }

    function getPastHighScore($day)
    {
		$query = "SELECT score_uid, MAX(score_value) AS hiscore, DATE(score_created_date) AS sdate FROM {$this->table} WHERE {$this->table}.score_created_date > DATE_SUB(CURDATE(), INTERVAL :day DAY)";
		$params = array(':day'=>$day);
		$scores = $this::getConnection()->query($query, $params);
		return $scores;
    }
    
    function getTodayScores()
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->table}.score_created_date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
		$params = array();
		$scores = $this::getConnection()->query($query, $params);
		return $scores;
    }

}