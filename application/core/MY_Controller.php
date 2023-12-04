<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Core_Controller extends CI_Controller
{
    protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->data['header_title'] = 'Tsystem';

    }

} 


class App_Controller extends Core_Controller
{
    
    protected $response;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('auth_model');
        date_default_timezone_set('Asia/Tokyo');

        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect('auth/login');
        }


    }
}