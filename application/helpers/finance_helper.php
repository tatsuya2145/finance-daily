<?php


function recently($updated_at)
{   
    $current_time_date = new DateTime(date("Y-m-d G:i:s",time()));
    $update_time_date = new DateTime($updated_at);

    $days_diff = $current_time_date->diff($update_time_date)->format("%a");
    
    if($days_diff<=3)
    {
        return "<i class='fas fa-exclamation fa-lg data-bs-toggle='tooltip' data-bs-placement='top' title='３日以内に更新がありました' style='color:red;'></i>"; #３日以内の更新
    }
    elseif(3<$days_diff and $days_diff<=7)
    {
        return "<i class='fas fa-exclamation fa-lg data-bs-toggle='tooltip' data-bs-placement='top' title='一週間以内に更新がありました' style='color:gold;'></i>"; #１週間以内の更新
    }
}


