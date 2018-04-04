<?php 
    function GetTime($type=null){
        switch ($type){
            case "today"://今天
                $data['start_at'] = date("Y-m-d 00:00:00");
                $data['ent_at'] = date("Y-m-d 23:59:59");
                break;
            case "yesterday"://昨天
                $data['start_at'] = date("Y-m-d 00:00:00",strtotime("-1 day"));
                $data['ent_at'] = date("Y-m-d 23:59:59",strtotime("-1 day"));
                break;
            case "week"://本周
                $data['start_at'] = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")));
                $data['ent_at'] = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));
                break;
            case "lastweek"://上周
                $data['start_at'] = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));
                $data['ent_at'] = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y")));
                break;
            case "month"://本月
                $data['start_at'] = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
                $data['ent_at'] = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));
                break;
            case "lastmonth"://上月
                $data['start_at'] = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
                $data['ent_at'] = date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y")));
                break;
            case 'six_months'://半年内
                $now = time();
                $time = strtotime('-4 month', $now);
                $data['start_at'] = date('Y-m-d 00:00:00', mktime(0, 0,0, date('m', $time), 1, date('Y', $time)));
                $data['ent_at'] = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', $now)+1, date('t', $now)-1, date('Y', $now)));
                break;
            case "year"://本年
                $data['start_at'] = date("Y-01-01 00:00:00");
                $data['ent_at'] = date("Y-12-31 23:59:59");
                break;
            case "lastyear":
                $data['start_at'] = date("Y-01-01 00:00:00", strtotime("-1 year"));
                $data['ent_at'] = date("Y-12-31 23:59:59", strtotime("-1 year"));
                break;
            default:
                $data['start_at'] = NULL;
                $data['ent_at'] = NULL;
                break;
        }
        return $data;
    }
?>