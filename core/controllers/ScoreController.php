<?php

namespace core\controllers;

use core\models\User;
use core\models\Score;

class ScoreController extends Controller
{
    function index($parameter = 0)
    {
        if (!$this->api->isPost()) {
            $score = new Score();
            $scores = array(); 

            if ($parameter > 0) {
                $read_score = $score->read($parameter);
                if (!empty($read_score))
                    $scores = array($read_score);
            } else {
                $scores = $score->getAll();
            }

            $data = array();

            foreach ($scores AS $this_score) {
                $data_array = array(
                    'id'=>$this_score['score_id'],
                    'user_id'=>$this_score['score_uid'],
                    'score'=>$this_score['score_value'],
                    'created_date'=>$this_score['score_created_date']
                );
                array_push($data, $data_array);
            }

            $this->response->addData('scores', $data);
            $this->response->setStatus(true);
        }
    }

    function create($parameter = 0)
    {
        if ($this->api->isPost()) {
            $post_data = $this->api->getPost();
            if (is_null($post_data)) {
                $this->response->setStatus(false);
				$this->response->addMessage('errors', 'score', 'Missing user_score parameter.');
            }
            $score = new Score();
            $user = new User();
            if ($parameter > 0) {
                $read_user = $user->read($parameter);
                if (!empty($read_user)) {
                    $score->score_uid = $read_user['user_id'];
                    $score->score_value = $post_data['user_score'];
                    $score->score_created_date =  date('Y-m-d G:i:s', time());
                    $score->create();
                    $this->response->setStatus(true);
                    $this->response->addData('score_id', $score->score_id);
                    $this->response->addData('score_uid', $score->score_uid);
                    $this->response->addData('score_value', $score->score_value);
                    $this->response->addData('score_created_date', $score->score_created_date);
                    $this->response->addMessage('successes', 'create', 'Score has been created.');
                }
                    
            }
        }
    }

    function topPlayers($parameter = 0)
    {
        if (!$this->api->isPost()) {
            $score = new Score();
            $scores = $score->getTopTen();

            $data = array();
            
            foreach ($scores AS $this_score) {
                $data_array = array(
                    'id'=>$this_score['score_id'],
                    'user_id'=>$this_score['score_uid'],
                    'score'=>$this_score['score_value'],
                    'created_date'=>$this_score['score_created_date']
                );
                array_push($data, $data_array);
            }
            
            $this->response->addData('scores', $data);
            $this->response->setStatus(true);
        }
    }

    function topImporved($parameter = 0)
    {
        if (!$this->api->isPost()) {
            
            
        }
    }

    function todayScores()
    {
        if (!$this->api->isPost()) {
            $score = new Score();
            $scores = $score->getTodayScores();

            $data = array();
            
            foreach ($scores AS $this_score) {
                $data_array = array(
                    'id'=>$this_score['score_id'],
                    'user_id'=>$this_score['score_uid'],
                    'score'=>$this_score['score_value'],
                    'created_date'=>$this_score['score_created_date']
                );
                array_push($data, $data_array);
            }
            
            $this->response->addData('scores', $data);
            $this->response->setStatus(true);
            
        }
    }
}