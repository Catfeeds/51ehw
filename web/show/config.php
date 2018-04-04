<?php
@header("Content-type: text/html; charset=utf-8");

define("TOKEN", "ninthleaf"); //配置API，不要改
define("Web_ROOT",'http://www.51ehw.com/show'); //改成你的域名地址，最后不要带/
$weixin_name='51易货网现场微信互动大屏幕';//这里可以配置你的微信公众账号名字，你也可以改下面的源码
$xiaobai_wxh = '51易货网';//微信帐号（wall前台显示）
        /***采集微信公众平台密码配置***/
//define("USER", "wyehw@qq.com");//公众平台账号 不能带空格
//define("PASS", "mm7758258");//公众平台密码  不能带空格
define("USER", "2293729051@qq.com");//公众平台账号 不能带空格
define("PASS", "mm7758258");//公众平台密码  不能带空格
$screenpaw = "admin";//进入微信大屏幕的密码

define("UR", Web_ROOT);
$url=Web_ROOT.'/moni/xiaobai.php';//不用修改、这个填写你的1.php这个文件的地址
$weixin_wxq=Web_ROOT.'/wall/';//不用修改、这里填写你的互动大屏幕的地址
/*链接数据库*/
$dbname = "show_test";//数据库的名称

$appid = "wxa05e0970ca30515a";//"wx304db9b2a6f5133b";//"wx9b8bd6c3da712dda";
$appsecret = "3d84852e5aa33c8dd2e9c9d5da8ad2ae";//"90c2253c2c79033798f4c8dcbb67a94a";//"deb5dc2e8c597ff1dfc0a9417b6837d2";

/*设置数据库信息*/
//已弃用
$host = "125.88.168.50";//数据库的服务器地址，一般无需更改
$port = "3306";//数据库的端口号
$user = "showuser";//数据库的用户名
$pwd = "show123qwe";//数据库的密码

/*接着调用mysql_connect()连接服务器*/
//$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
//$link = @mysqli_connect($host,$user,$pwd,$dbname);
//if(!$link) {
//           die("Connect Server Failed: " . mysqli_error($link));
//          }
/*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
/*if(!mysql_select_db($dbname,$link)) {
           die("Select Database Failed: " . mysql_error($link));
          }*/
//mysqli_query($link,"SET NAMES UTF8");
//以上连接数据库

$xuanze="SELECT * FROM  `weixin_wall_config`";
//$chaxun=mysqli_query($link, $xuanze) or die(mysqli_error($link));
//$xuanzezu=mysqli_fetch_row($chaxun);
$db = mysql::getInstance();
$xuanzezu= $db->getRow($xuanze,MYSQL_NUM);
$huati=$xuanzezu[0];//话题内容不用修改
$huanying1=$xuanzezu[1];
$huanying2=$xuanzezu[2];
?>
