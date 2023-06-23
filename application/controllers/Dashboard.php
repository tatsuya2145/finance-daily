<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['header_title'] = 'ダッシュボード | ' . $this->data['header_title'];
    }

    public function index()
    {
        $this->load->view('inc/header', $this->data);
        $this->load->view('inc/navbar');
        $this->load->view('dashboard');        
        $this->load->view('inc/preloader');
        $this->load->view('inc/footer');
    }
}
