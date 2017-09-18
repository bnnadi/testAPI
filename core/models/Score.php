<?php
namespace core\models;

use core\dao\ScoreDAO;

class Score extends Model
{
    var $score_id;
    var $score_uid;
    var $score_value;
    var $score_created_date;
    var $score_visible;

    function __construct()
    {
        parent::__construct();
        $this->dao = new ScoreDAO();
        $this->score_uid = 0;
        $this->score_value = '';
        $this->score_created_date = 0;

        $this->score_visible = 1;

        $this->create_success_message = 'Score successfully saved.';
        $this->update_success_message = 'Score successfully updated.';
        $this->create_failure_message = 'Score failed to be saved.';
        $this->update_failure_message = 'Score failed to be updated';
    }

    function getValidationMessages()
    {
        return $messages = [];
    }

    function create()
    {
        parent::create();
    }

    function getTopTen()
    {
        return $this->dao->getTopTen();
    }

    function getTodayScores()
    {
        return $this->dao->getTodayScores();
    }

    function getImproved()
    {
        return $this->dao->getTopTenImproved();
    }
}
