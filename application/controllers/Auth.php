<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('auth_model');
        date_default_timezone_set("Asia/Tokyo");

        $this->data['header_title'] = 'ログイン | ' . $this->data['header_title'];
    }

    public function login()
    {
        // ログイン済みならリダイレクト
        if($this->session->userdata('admin_logged_in')) redirect("dashboard");

        // 認証フォームのvalidation
        $this->form_validation->set_rules(
            'login_id', 'ログインID', 'trim|required'
        );
        $this->form_validation->set_rules(
            'password', 'Password', 'trim|required'
        );


        $this->data['error_message'] = "";

        // 認証チェック
        if ($this->form_validation->run())
        {
            // login 可能か
            if ($this->auth_model->canLogin(set_value('login_id'), set_value('password')))
            {

                // ユーザーデータの取得
                $user_data = $this->auth_model->getUser(set_value('login_id'));
                // セッション発行
                $sess_data = array(
                    'user_id' => $user_data['user_id'],
                    'name' => $user_data['name'],
                    'admin_logged_in' => true,
                );
                $this->session->set_userdata($sess_data);
                
                redirect('dashboard');
            }
            // login 失敗
            else 
            {   
                $this->data['error_message'] = 'IDまたはパスワードが間違っています';
            }
        }

        // ログイン画面
        $this->load->view('inc/header',$this->data);
        $this->load->view('login');
        $this->load->view('inc/footer');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("auth/login");
    }
}