<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_model extends CI_Model 
{
    public function get($daily_date,$user_id)
    {        
        return $this->db
                        ->where('daily_date', $daily_date)
                        ->where('user_id', $user_id)
                        ->get('daily')
                        ->result_array();
    }

    public function fetch($uuid)
    {
        return $this->db
                        ->where('uuid',$uuid)
                        ->get('daily')
                        ->row_array();
    }

    //uuidがDBにある場合とない場合でinsertとupdateを分ける
    public function set($data)
    {
        $result = $this->db
                            ->where("uuid",$data["uuid"])
                            ->get("daily");
        if($result->num_rows() > 0)
        {
            
            return $this->db
                            ->where("uuid",$data["uuid"])
                            ->update("daily",$data);
        }
        
                    
        return $this->db->insert("daily",$data);

    }

    public function delete($uuid)
    {
        $this->db->where("uuid",$uuid);
        return $this->db->delete("daily");
    }
    
    public function search($word,$user_id)
    {
        $result = array();
        $sql  = "SELECT * FROM daily WHERE (daily.content LIKE '%$word%' OR daily.daily_title LIKE '%$word%') AND daily.user_id = '$user_id'";
        $sql .= " ORDER BY daily.daily_date ASC";

        $data = $this->db
                        ->query($sql)
                        ->result_array();

        foreach($data as $row)
        {
            if(!in_array($row["daily_date"],$result,true))
            {
                $result[] = $row["daily_date"];
            }

        }

        return $result;
    }

}

