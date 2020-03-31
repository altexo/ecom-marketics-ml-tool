<?php
namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;
use App\User;

class MLQuestions 
{
    public $meli;
    public function __construct()
    {
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
    }
    
    public function getQuestionsByState($ml_token, $ml_user_id, $state){
        $params = array('access_token' => $ml_token,'seller_id'=> $ml_user_id ,'status' =>$state);
       
        return $this->meli->get('/questions/search', $params, true); 
    }

    public function getAllQuestions($ml_token, $ml_user_id, $state){
        $params = array('access_token' => $ml_token,'seller_id'=> $ml_user_id, 'status'=>$state);

        return $this->meli->get('/questions/search', $params, true); 
    }

    public function answeredQuestions(){
        return 202;
    }

    public function getQuestionDetails($ml_token, $question_id){
        $params = ['access_token'=> $ml_token];

        return $this->meli->get('questions/'.$question_id, $params, true);
    }

    public function respondQuestion($ml_token, $question_id , $text_message){
        $params = ['question_id'=> $question_id, 'text'=> $text_message];

        return $this->meli->post('answers?access_token='.$ml_token, $params);
    }
}
