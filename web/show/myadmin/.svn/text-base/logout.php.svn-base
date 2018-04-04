<?php
header("Content-type: text/html; charset=utf-8");
session_start();
unset($_SESSION['admin']);
$str="提示：你已经退出登录";
$str.='<a href="index.php">点击这里返回</a>';
 	$str.=<<<eot
<script language="javascript" type="text/javascript">
location.href='index.php';
</script>
eot;
die($str);
?>