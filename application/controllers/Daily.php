<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends App_Controller 
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('daily');
        $this->load->model(array('Daily_model'=>'daily'));
        $this->data['header_title'] = '日記 | ' . $this->data['header_title'];

    }

    public function entry()
    {
        $from           = date('Y-m-d',strtotime('-1 month'));
        $to             =  date('Y-m-d');
        $word           = '';
        $is_filled_only = 0;
        
        if(!empty($this->input->post())){
            $from           = $this->input->post('from');
            $to             = $this->input->post('to');
            $word           = trim($this->input->post('word'));
            $is_filled_only = $this->input->post('is_filled_only');
        }
        
        $user_id    = $this->session->userdata('user_id');
        $serach     = $this->daily->search($word,$user_id);
        
        //$fromから$toまでの日付をkeyにし、記入されたデータの有無でvalueを0と1で分けた配列を$dataとして作成
        $data = [];
        for($date = $from; $date <= $to; $date = date('Y-m-d', strtotime($date . ' +1 day')))
        {
            $data[$date] = 0; 
        }

        foreach(array_flip($serach) as $key => $value)
        {
            if(isset($data[$key]))
            {
                $data[$key] = 1; 
            }
        }


        $this->data['from'] = $from;
        $this->data['to'] = $to;
        $this->data['word'] = $word;
        $this->data['data'] = $data;
        $this->data['is_filled_only'] = $is_filled_only;

        $this->load->view('inc/header', $this->data);
        $this->load->view('inc/navbar');
        $this->load->view('inc/preloader');
        $this->load->view('daily/entry');
        $this->load->view('inc/footer');    
    }


    public function modal()
    {
        $date       = $this->input->post('daily_date');
        $user_id    = $this->session->userdata('user_id');
        $this->data['date'] = $date;
        $this->data['data'] = $this->daily->get($date,$user_id);
        $response['date']           = $date;
        $response['formated_date']  = date('n月j日', strtotime($date)) . '(' . weekName($date) . ')' ;
        $response['modal']          = $this->load->view('daily/modal', $this->data, true);
        echo json_encode($response);
    }

    public function execute()
    {
        $data = array(
            'user_id'     =>  $this->session->userdata('user_id'),
            'daily_date'  =>  $this->input->post('daily_date'),
            'daily_title' =>  $this->input->post('daily_title'),
            'content'     =>  $this->input->post('content'),
            'uuid'        =>  $this->input->post('uuid'),
        );
    
        $response['result'] = $this->daily->set($data);

        echo json_encode($response);
    }

    public function delete()
    {
        $uuid = $this->input->post('uuid');

        $response['result'] = $this->daily->delete($uuid);

        echo json_encode($response);

    }

    public function getArticles()
    {
        $date       = $this->input->post('daily_date');
        $user_id    = $this->session->userdata('user_id');
        $response['articles'] = $this->daily->get($date,$user_id);
        echo json_encode($response);
        
    }

    public function fetchArticle()
    {
        $uuid = $this->input->post('uuid');
        $response['article'] = $this->daily->fetch($uuid);
        echo json_encode($response);
    }

    

}

    /* End of file Controllername.php */
