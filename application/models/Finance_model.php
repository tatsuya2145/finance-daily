<?php

class finance_model extends CI_Model {

    public function get($category_id=null)
    {
        $sql = "SELECT * FROM  finances 
                INNER JOIN finance_amount_type_master ON finances.amount_type = finance_amount_type_master.amount_type 
                INNER JOIN finance_payment_type_master ON finances.payment_type_id = finance_payment_type_master.payment_type_id 
                WHERE finances.category_id = '$category_id'
                ORDER BY finance_date DESC";
        return $this->db->query($sql)
                        ->result_array();

        
    }

    public function fetch($finance_id)
    {
        $sql = "SELECT * FROM  finances 
                INNER JOIN finance_amount_type_master ON finances.amount_type = finance_amount_type_master.amount_type 
                INNER JOIN finance_payment_type_master ON finances.payment_type_id = finance_payment_type_master.payment_type_id 
                WHERE finances.finance_id = '$finance_id'
                ORDER BY finance_date DESC";
        return $this->db->query($sql)
                        ->row_array();
        
    }
    
    public function getSubTotal($category_id)
    {
        $sql = "SELECT *, 
                    (
                        SELECT IFNULL(SUM(amount), 0) FROM finances
                        WHERE amount_type = 1
                        AND payment_type_id = master.payment_type_id
                        AND category_id = '$category_id'
                    ) as income,
                    (
                        SELECT IFNULL(SUM(amount), 0) FROM finances
                        WHERE amount_type = 0
                        AND payment_type_id = master.payment_type_id
                        AND category_id = '$category_id'
                    ) as expense
        
                FROM `finance_payment_type_master` as master;";
        return $this->db
                        ->query($sql)
                        ->result_array();
    }

    public function getGrandTotal()
    {
        $sql = "SELECT *, 
                    (
                        SELECT IFNULL(SUM(amount), 0) FROM finances
                        WHERE amount_type = 1
                        AND payment_type_id = master.payment_type_id
                    ) as income,
                    (
                        SELECT IFNULL(SUM(amount), 0) FROM finances
                        WHERE amount_type = 0
                        AND payment_type_id = master.payment_type_id
                    ) as expense
        
                FROM `finance_payment_type_master` as master;";
        return $this->db
                        ->query($sql)
                        ->result_array();

    }

    public function getAmountType()
    {
        return $this->db
                        ->get('finance_amount_type_master')
                        ->result_array();
    }

    public function getPaymentType()
    {
        return $this->db
                        ->get('finance_payment_type_master')
                        ->result_array();
    }

    public function getCategory($category_id=null)
    {
        if($category_id != null)
        {
            $this->db->where('category_id',$category_id);
        }
        return $this->db
                        ->get('finance_category_master')
                        ->result_array();
    }

    public function getAutoCompleteWords()
    {
        $finance_titles = $this->db->select('finance_title')
                        ->distinct('finance_title')
                        ->get('finances')
                        ->result_array();

        $words = [];
        foreach($finance_titles as $row)
        {
            $words[] = [
                'label' => $row['finance_title']
            ];
        }

        return $words;
    }


    public function insert($data)
    {
        return $this->db->insert('finances',$data);
    }

    public function update($finance_id,$data)
    {
        $this->db->where('finance_id', $finance_id);
        return $this->db->update('finances',$data);
           
    }

    public function delete($finance_id)
    {
        $this->db->where('finance_id',$finance_id);
        return $this->db->delete('finances');
    }
    

}

/* End of file finance_model.php */
