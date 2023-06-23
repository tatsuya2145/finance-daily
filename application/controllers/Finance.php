<?php

defined('BASEPATH') or exit('No direct script access allowed');

class finance extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('finance');
        $this->load->model(array('finance_model'=>'finance'));
        $this->data['header_title'] = '家計簿 | ' .$this->data['header_title'];
    }
    
    public function entry()
    {   
        $category_id = null;
        if($this->input->post())
        {
            $category_id = $this->input->post('category_id');
        }

        $this->data['finances']      = $this->finance->get($category_id);
        $this->data['amount_types']  = $this->finance->getAmountType();
        $this->data['payment_types'] = $this->finance->getPaymentType();
        $this->data['categories']    = $this->finance->getCategory();
        $this->data['sub_total']     = $this->finance->getSubTotal($category_id);
        $this->data['grand_total']   = $this->finance->getGrandTotal();
        $this->data['category_id']   = $category_id;
        $this->load->view('inc/header',$this->data);
        $this->load->view('inc/navbar');
        $this->load->view('inc/preloader');
        $this->load->view('finance/entry');
        $this->load->view('inc/footer');
        
    }

    public function detail()
    {
        $finance_id = $this->input->post('finance_id');
        $response['data'] = $this->finance->fetch($finance_id);
        echo json_encode($response);
    }

    public function add()
    {   

        $this->load->library('form_validation');
        $this->form_validation->set_rules('finance_date' , '日付', 'trim|required');
        $this->form_validation->set_rules('payment_type' , '種類', 'trim|required');
        $this->form_validation->set_rules('amount_type' , '収支', 'trim|required');                
        $this->form_validation->set_rules('finance_title' , 'タイトル', 'trim|required');
        $this->form_validation->set_rules('amount', '金額', 'trim|required|is_numeric');
    
        $validation = $this->form_validation->run();

        if($validation)
        {
            $data = [
                'finance_date'    => $this->input->post('finance_date'),
                'payment_type_id' => $this->input->post('payment_type'),
                'amount_type'     => $this->input->post('amount_type'),
                'finance_title'   => $this->input->post('finance_title'),
                'amount'          => $this->input->post('amount'),
                'description'     => $this->input->post('description'),
                'category_id'     => $this->input->post('category_id')
            ];
            $result['result'] = $this->finance->insert($data);
        }

        $response['validate'] = $validation;

        echo json_encode($response);
    }

    public function delete()
    {

        $finance_id = $this->input->post('finance_id');
        $response['result'] = $this->finance->delete($finance_id);
        echo json_encode($response);
    }


    public function update()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('finance_date' , '日付', 'trim|required');
        $this->form_validation->set_rules('payment_type' , '種類', 'trim|required');
        $this->form_validation->set_rules('amount_type' , '収支', 'trim|required');                
        $this->form_validation->set_rules('finance_title' , 'タイトル', 'trim|required');
        $this->form_validation->set_rules('amount', '金額', 'trim|required|is_numeric');

        $validation = $this->form_validation->run();
        
        if($validation)
        {   
            $finance_id = $this->input->post('finance_id');
            $data = [
                'finance_date'    => $this->input->post('finance_date'),
                'payment_type_id' => $this->input->post('payment_type'),
                'amount_type'     => $this->input->post('amount_type'),
                'finance_title'   => $this->input->post('finance_title'),
                'amount'          => $this->input->post('amount'),
                'description'     => $this->input->post('description')
            ];
            
            $response['result'] = $this->finance->update($finance_id,$data);
            
        }
        $response['validate'] = $validation;

        echo json_encode($response);

    }
    
    
}   
