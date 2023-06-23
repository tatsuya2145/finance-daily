<?php

function menuActive($uri)
{
    return uri_string() == $uri ? 'active' : '';
}

function hasSubmenuActive($uri)
{
    return strpos(site_url(uri_string()),$uri) !== false ? 'active' : '';
}

function hasSubmenuExpanded($uri)
{
    return strpos(site_url(uri_string()),$uri) !== false ? 'true' : 'false';
}

function hasSubmenuShow($uri)
{
    return strpos(site_url(uri_string()),$uri) !== false ? 'show' : '';
}

function weekName($date, $weekLabel = "")
{
    $week = ['日', '月', '火', '水', '木', '金', '土'];
    $week_num = date("w", strtotime($date));
    return $week[$week_num] . $weekLabel;
}

function dateFormat($date, $format = "Y/m/d", $withWeek = false, $weekLabel = "")
{
    $return = date($format, strtotime($date));
    if($withWeek)
    {
        $return .= "(" . weekName($date, $weekLabel) . ")";
    }

    return $return;
}
