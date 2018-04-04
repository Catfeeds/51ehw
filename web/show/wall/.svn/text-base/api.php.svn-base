<?php

@header("Content-type: text/html; charset=utf-8");
include ('biaoqing.php');
include ("db.php");
$lastid = $_REQUEST['lastid'];

$num = $lastid + 1;


$sql1 = "SELECT * FROM  `weixin_wall` where `num` = '$num' limit 1 ";


//$query1 = mysqli_query($link,$sql1) or die(mysql_error());
//$q = mysql_fetch_row($query1);
$db = mysql::getInstance();
$q = $db->getRow($sql1);

/*
if ($q == '' || $q == NULL) {
    for ($num = $num + 1; $q == ''; $num ++) {
        $sql1 = "SELECT * FROM  `weixin_wall` where `num` = '$num' limit 1 ";
       // $query1 = mysqli_query($link,$sql1);
        //$q = mysql_fetch_row($query1);
		$q = $db->getRow($sql1);

        // 当最大值是停止循环
       // $result = mysqli_query($link,'select num from `weixin_wall_num`');
       // $row = mysqli_fetch_array($result, MYSQL_ASSOC);
		$row = $db->getRow('select num from `weixin_wall_num`',MYSQL_ASSOC);

        $maxid = $row["num"];
		//echo "aaaaaa".$xuanzezu[22];
        if ($maxid <= $num) {
            if ($xuanzezu[22]) {
		 for (; $q[0] == '';) {
                    $conut = rand(1, $num - 1);
					
                    $sql1 = "SELECT * FROM  `weixin_wall` where `num` = '$conut' limit 1 ";
					//echo $sql1;
                   // $query1 = mysqli_query($link,$sql1);
                    //$q = mysqli_fetch_row($query1);

					$q = $db->getRow($sql1);
                    $q[3] = $lastid;
                }
	       
            }
            break;
        }

    }
}*/

if (count($q) > 0) {
    $q[5] = pack('H*', $q[5]);
    $q = emoji_unified_to_html(emoji_softbank_to_unified($q));
    $id = isset($q[0])?$q[0]:0;
    $fakeid = isset($q[2])?$q[2]:0;
    $num = isset($q[3]) ? $q[3] : 0;
    $content = isset($q[4]) ? $q[4] : "";
    $content = biaoqing($content);
    $nickname = isset($q[5]) ? $q[5] : "";
    $avatar = isset($q[6]) ? $q[6] : "";
    $ret = isset($q[7]) ? $q[7] : "";
    $image = isset($q[9]) ? $q[9] : "";
    if (isset($q[3]) && $q[3]) {
        @$msg = array(
            data => array(
                array(
                    "id" => $id,
                    "fakeid" => $fakeid,
                    "num" => $num,
                    "content" => $content,
                    "nickname" => $nickname,
                    "avatar" => $avatar,
                    "image" => $image
                )
            ),
            ret => 1
        );
        echo $msg = json_encode($msg);
    }
    if (! isset($q[3]) || ! $q[3]) {
        @$msg = array(
            data => array(),
            ret => 0
        );
        echo $msg = json_encode($msg);
    }
}

?>
