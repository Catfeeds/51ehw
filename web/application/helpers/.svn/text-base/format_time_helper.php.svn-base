<?php 
   /**
 * 传入日期格式或时间戳格式时间，返回与当前时间的差距，如1分钟前，2小时前，5月前，3年前等 --
 * @param string or int $date 分两种日期格式"2013-12-11 14:16:12"或时间戳格式"1386743303"
 * @param int $type
 * @return string
 * @fxm
 * 待后续需要使用到格式时完善
 */
function format_time( $date = 0, $type = 2 ) 
{ //$type = 1为时间戳格式，$type = 2为date时间格式
    date_default_timezone_set('PRC'); //设置成中国的时区
    switch ($type) 
    {
        case 1:
            //$date时间戳格式
            $second = time() - $date;
            $minute = floor($second / 60) ? floor($second / 60) : 1; //得到分钟数
            
            if ($minute >= 60 && $minute < (60 * 24)) { //分钟大于等于60分钟且小于一天的分钟数，即按小时显示
                $hour = floor($minute / 60); //得到小时数
            } elseif ($minute >= (60 * 24) && $minute < (60 * 24 * 30)) { //如果分钟数大于等于一天的分钟数，且小于一月的分钟数，则按天显示
                $day = floor($minute / ( 60 * 24)); //得到天数
            } elseif ($minute >= (60 * 24 * 30) && $minute < (60 * 24 * 365)) { //如果分钟数大于等于一月且小于一年的分钟数，则按月显示
                $month = floor($minute / (60 * 24 * 30)); //得到月数
            } elseif ($minute >= (60 * 24 * 365)) { //如果分钟数大于等于一年的分钟数，则按年显示
                $year = floor($minute / (60 * 24 * 365)); //得到年数
            }
            break;
        case 2:
            //$date为字符串格式 2013-06-06 19:16:12
            $new_date = strtotime($date);
            
            $second = time() - $new_date;
            $minute = floor($second / 60) ? floor($second / 60) : 1; //得到分钟数
            
            if( $minute < 59 )
            {
                $time_minute = $minute;
            }
            else if ( $minute >= 60 && $minute < (60 * 24) ) //分钟大于等于60分钟且小于一天的分钟数，即按小时显示
            {   
                $hour = floor($minute / 60); //得到小时数
            } elseif( $minute >= (60 * 24) && $minute < (60 * 24 * 30) ) { //如果分钟数大于等于一天的分钟数，且小于一月的分钟数，则按天显示
                $day = floor($minute / ( 60 * 24) ); //得到天数
            }else if ( $minute >= (60 * 24 * 30) && $minute < (60 * 24 * 365) ){ 
                $month = floor($minute / (60 * 24 * 30) ); //得到月数
            }
            //超过一年就显示原来的时间格式。
            
                
//             if ($minute >= 60 && $minute < (60 * 24)) { //分钟大于等于60分钟且小于一天的分钟数，即按小时显示
//                 $hour = floor($minute / 60); //得到小时数
//             } elseif ($minute >= (60 * 24) && $minute < (60 * 24 * 30)) { //如果分钟数大于等于一天的分钟数，且小于一月的分钟数，则按天显示
//                 $day = floor($minute / ( 60 * 24)); //得到天数
//             } elseif ($minute >= (60 * 24 * 30) && $minute < (60 * 24 * 365)) { //如果分钟数大于等于一月且小于一年的分钟数，则按月显示
//                 $month = floor($minute / (60 * 24 * 30)); //得到月数
//             } elseif ($minute >= (60 * 24 * 365)) { //如果分钟数大于等于一年的分钟数，则按年显示
//                 $year = floor($minute / (60 * 24 * 365)); //得到年数
//             }
            break;
        default:
            break;
    }
    if( isset( $time_minute ) )
    {
        return $time_minute >= 1 ? $time_minute.'分钟前' : '刚刚';
    }
    elseif ( isset($day) ) {
        return $day == 1 ? '昨天' : $day. '天前';
    } else if( isset($hour) ){
        return $hour . '小时前';
    } else if ( isset( $month ) )
    { 
        return $month . '个月前';
    }else{ 
        return $date;
    }
    
//     if (isset($year)) {
//         return $year . '年前';
//     } elseif (isset($month)) {
//         return $month . '月前';
//     } elseif ( isset($day) ) {
//         return $day == 1 ? '昨天' : $day. '天前';
//     } elseif (isset($hour)) {
//         return $hour . '小时前';
//     } elseif (isset($minute)) {
//         return $minute . '分钟前';
//     }
}



/**
 * 
 * @param number $date
 * 格式化显示日期。
 */
function formatTime_( $date = 0 )
{ 

    date_default_timezone_set('PRC'); //设置成中国的时区
    $year = date('Y',strtotime($date) );//年
    $moon_sun = date('m-d',strtotime( $date) );//获取月，日；
     
    
    if( date('Y') == $year )
    {
        //判断是否本日。
        if( $moon_sun ==  date('m-d') )
        {
            return date('H:i',strtotime( $date ) );
    
        }else if( $moon_sun == date('m-d',strtotime('-1 day') ) )//判断是否昨天
        {
            return '昨天 '.date( 'H:i',strtotime( $date ) );
    
        }else{
            return date('m-d H:i',strtotime( $date ) );
        }
    
    }else{
        return $date;
    }
    
}
?>