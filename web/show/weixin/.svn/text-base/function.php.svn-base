<?php

function isluru($wecha_id, $cretime, $scontent)
{
    $path = str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__);
    include $path.'../moni/xiaobai.php';
    /* 此代码用来处理用户详细信息并输出 */
    /*
     * $xiaobai = getmessage($token, $cookie, $cookies); // 将用户消息转换成变量
     * $date_time = $xiaobai[0]["date_time"];
     * // var_dump($xiaobai);
     * $i = 0;
     * for (; $i <= 19; $i ++) {
     * if ($xiaobai[$i]["content"] == $scontent) {
     * break;
     * }
     * }
     * if ($i == 20 && $date_time) {
     * return 1;
     * }
     */
    // var_dump($xiaobai[$i]);
    // if ($date_time) {
    //$id = $account_info["id"];
    $account_info = sixi_api($wecha_id);
    $fakeid = $account_info["openid"];
    $nick_name = $account_info["nickname"];

	//error_log("dddddd".$nick_name);

    //$messageid = $xiaobai[$i]["id"];
    $content = $scontent;

    // 以下获取用户性别
    //$details = sixi($token, $fakeid, $cookie, $cookies);
    //parse_str($details);
    $sex = $account_info['sex'];//$gender;

    $img = gethead($account_info['headimgurl']);//gethead($token, $fakeid, $cookie);

    if (!$img){
        error_log("can not get image!");
    }

    $imgurl = makeimg($img, $fakeid . '_' . $messageid);

    $nick_name = bin2hex($nick_name);
    $sql = "UPDATE  `weixin_flag` SET  `nickname` =  '$nick_name',`avatar` = '$imgurl',`content` = '$content',`fakeid` = '$fakeid',`sex` = '$sex' WHERE `openid` = '$wecha_id'";
    error_log($sql);
	$db = mysql::getInstance();
	$data = $db->query($sql);
   // mysql_query($sql);

    /*
     * } else {
     * // var_dump(login($username,$pwd));
     *
     * $ver = new version();
     * $array = login($username, $pwd, '', '', $ver->hasplugs());
     * $cookie = $array[0];
     * $cookies = $array[1];
     * $token = $array[2];
     * $sql = "UPDATE `weixin_cookie` SET `cookie` = '$cookie',`cookies` = '$cookies',`token` = '$token' WHERE `id` = '1'";
     * mysql_query($sql);
     * return 1;
     * }
     */
}

function lurushake($wecha_id)
{
    $sql_flg = "SELECT * FROM  `weixin_flag` WHERE `openid` = '$wecha_id'";
	$db = mysql::getInstance();
	$q = $db->getRow($sql_flg);

    //$query_num = mysql_query($sql_flg);
    //$q = mysql_fetch_row($query_num);
    $nicheng = $q[4];
	//error_log("$$$$$$$$$$$$$$44".$nicheng);
    $avatar = $q[5];

    // 实例化一个memcache对象
    if (! empty($_SERVER['HTTP_APPNAME'])) {
        @$mem = memcache_init();
    } else
        if (class_exists("Memcache")) {
            @$mem = new Memcache();
            @$mem->connect('localhost', '11211');
        }
    if (! empty($mem)) {

        $path = str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__);
        include $path.'../wall/biaoqing.php';
        $shakeu = $mem->get(realpath("..") . 'shakeu' . $wecha_id);
        if (empty($shakeu)) {

            $memsql = realpath("..") . 'SELECT * FROM  `weixin_shake_toshake`';
            $key = substr(md5($memsql), 10, 8);

            // 从memcache服务器获取数据
            $data = $mem->get($key);
            $arrnum = count($data) + 1;
            $mem->set(realpath("..") . 'shakeu' . $wecha_id, $arrnum, MEMCACHE_COMPRESSED, 3600);
            $cachenick = pack('H*', $nicheng);
            $cachenick = emoji_unified_to_html(emoji_softbank_to_unified($cachenick));

            $addarr = array(
                'id' => 'new',
                'phone' => $cachenick,
                'wecha_id' => $wecha_id,
                'point' => 0,
                'avatar' => $avatar
            );
            array_push($data, $addarr);
            $mem->set($key, $data, MEMCACHE_COMPRESSED, 3600);
        }
    }
    $sql_shake = "replace  `weixin_shake_toshake` (`wecha_id`,`phone`,`point`,`avatar`) VALUES ('$wecha_id','$nicheng','0','$avatar')";
    //mysql_query($sql_shake);
	$db->query($sql_shake);

    $xuanze = "SELECT * FROM  `weixin_flag` WHERE  `openid` =  '{$wecha_id}'";
    //$chaxun = mysql_query($xuanze) or die(mysql_error());
    //$q = mysql_fetch_array($chaxun);
	$q = $db->getRow($xuanze,MYSQL_ASSOC);
    if ($q[nickname] == '') {
        return 1;
    }
}

function doshenhe($cid)
{
	$db = mysql::getInstance();
    $sql_num = "SELECT * FROM  `weixin_wall_num` ";
	$q = $db->getRow($sql_num);
    //$query_num = mysql_query($sql_num);
    //$q = mysql_fetch_row($query_num);
    $num = $q[0];
    $sql_flg = "SELECT * FROM  `weixin_wall` WHERE `id` = '$cid'";
    //$query_num = mysql_query($sql_flg);
    //$q = mysql_fetch_row($query_num);
	$q = $db->getRow($sql_flg);
    $fakeid = $q[2];
    $content = $q[4];
    $datetime = $q[10];
    $sql2 = "UPDATE  `weixin_flag` SET `status` =  '2',`content` = '$content',`datetime`='$datetime' WHERE `fakeid` = '$fakeid' and `status` !=  '1'";
 
	//$query2 = mysql_query($sql2);
	$query2 = $db->query($sql2);
    $sql1 = "UPDATE  `weixin_wall` SET  `ret` =  '1',`num` = '$num',`status` =  '0' WHERE  `id` = '$cid'";
	error_log($sql1);
    $query1 = $db->query($sql1);
	//$query1 = mysql_query($sql1);
    if ($query1) {
        $sql_num = "UPDATE `weixin_wall_num` SET `num` = `num`+1";
		error_log($sql_num);
		$query_num = $db->query($sql_num);
        //$query_num = mysql_query($sql_num);
    }
    return 1;
}

function wq_lurupic($cretime)
{

    $path = str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__);
    include $path.'../moni/xiaobai.php';

    $xiaobai = getmessage($token, $cookie, $cookies); // 将用户消息转换成变
    $i = 0;
    for (; $i <= 19; $i ++) {
        if ($xiaobai[$i]["date_time"] == $cretime && $xiaobai[$i]["type"] == '2') {
            break;
        }
    }
    $type = $xiaobai[$i]["type"];
    if ($i == 20) {
        return 1;
    } else {
        if ($type == 2) {
            $fakeid = $xiaobai[$i]["fakeid"];
            $nick_name = $xiaobai[$i]["nick_name"];
            $messageid = $xiaobai[$i]["id"];
            $content = $xiaobai[$i]["content"];

            // 以下获取用户性别
            $details = sixi($token, $fakeid, $cookie, $cookies);
            parse_str($details);
            $sex = $gender;
            /* 获取结束 */
            $img = gethead($token, $fakeid, $cookie);
            $imgurl = makeimg($img, $fakeid . '_' . $messageid);
            /* 以下为获取图片 */
            $img = getimages($token, $messageid, $cookie);
            $picurl = makeimg($img, $messageid);

            // 以下为写入wall
            $sql = "INSERT INTO `weixin_wall` (`id`,`messageid`,`fakeid`,`num`,`content`,`nickname`,`avatar`,`ret`,`image`,`datetime`) VALUES (NULL,'0','{$fakeid} ','-1','此消息为图片','{$nick_name}','{$imgurl}','0','{$picurl}','0')";
            //mysql_query($sql);
			$db = mysql::getInstance();
		    $db->query($sql);
        } else {
            return 2;
        }
    }
}
?>