<?php 
	include("dbhelper.php");

    $db = mysql::getInstance();

	$xuanze=" SELECT * FROM `weixin_flag` where `openid` = 'os7WCw-aQ3GECu-j2kud4rw9PDw8'";


	$data = $db->getRow($xuanze,MYSQL_ASSOC);
	
	//$xuanzezu=mysqli_fetch_row($chaxun);
	//$huati=$xuanzezu[0];//话题内容不用修改

	//print_r($xuanzezu);
	echo $data["verify"];
	print_r($data);
   // $link->close();  
?>