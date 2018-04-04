<?php

/* 第一步 微信公众平台登陆 */

/* 配置开始 */
header("content-Type: text/html; charset=utf-8");
/* 判断get到id没 */
$username = USER;
$pwd = PASS;
$siurl = UR; // 注意com后面不能带有斜线 上传后的地址
/* 配置结束 */
$xuanze = "SELECT * FROM  `weixin_cookie`";
$db = mysql::getInstance();
$array = $db->getRow($xuanze);
//$chaxun = mysql_query($xuanze) or die(mysql_error());
//$array = mysql_fetch_row($chaxun);

// $array=login($username,$pwd);
$cookie = $array[0];
$cookies = $array[1];
$token = $array[2];
// var_dump($cookie);
/*
 * 第二步 微信公众平台登陆函数获取
 * cookie cookies token
 * 以数组方式输出
 */
// var_dump($token);
// if($action == 'cj'){
// if(file_exists("cj.php"))
// {
// include './cj.php';
// }
// }
/**
 * 以前的函数，用于模拟登录
 * @param unknown $username
 * @param unknown $pwd
 * @param string $verify
 * @param string $codecookie
 */
function login($username, $pwd, $verify = '', $codecookie = '')
{
    return array();
}

function getimgver($username)
{
    $rand = time() . rand(100, 999);
    $url = "https://mp.weixin.qq.com/cgi-bin/verifycode?username=$username&r=" . $rand;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);
    list ($header, $body) = explode("\r\n\r\n", $output);
    preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches);
    $cookie = $matches[1][0];
    $cookie = str_replace(array(
        'Path=/',
        ' ; Secure; HttpOnly',
        '=;'
    ), array(
        '',
        '',
        '=;'
    ), $cookie);
    $imgcodeurl = makeimg($body, "code_" . $rand);

    return $imgcode = array(
        'imgcodeurl' => $imgcodeurl,
        'cookie' => $cookie
    );
}

function getmessage($token, $cookie, $cookies)
{
    $url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=20&day=7&token=$token&lang=zh_CN";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&token=$token&lang=zh_CN&pagesize=10&pageidx=0&type=0&groupid=0");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    // var_dump($output);//全部消息
    curl_close($ch);
    $u_msg = substr($output, (strpos($output, "{\"msg_item\":") + 14));
    $abc = substr($u_msg, (strpos($u_msg, "{\"msg_item\":[\":") + 1));
    // var_dump($u_msg);
    $b = array();
    $i = 0;
    foreach (explode('},{', $u_msg) as $u_msg) {
        $u_msg = preg_replace('/["]+/i', '', $u_msg);
        foreach (explode(',', $u_msg) as $u_msg) {
            list ($k, $v) = explode(':', $u_msg);
            $b[$i][$k] = $v;
        }
        $i ++;
    }

    return $b;
}
// var_dump(getmessage($token,$cookie,$cookies));//测试是否成功抓取最新一条消息

/* 第四步 微信公众平台获取用户详细信息 */
function sixi($token, $fakeid, $cookie, $cookies)
{
    $url = "https://mp.weixin.qq.com/cgi-bin/getcontactinfo";
    $post = "token=$token&lang=zh_CN&t=ajax-getcontactinfo&fakeid=$fakeid";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, $cookies); // 设置头信息的地方
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=20&day=7&token=$token&lang=zh_CN");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $output = curl_exec($ch);
    // var_dump($output);
    curl_close($ch);
    $deng = preg_replace('/[\{]+/i', '', $output);
    $deng = preg_replace('/[\}]+/i', '', $deng);
    $deng = preg_replace('/[\[]+/i', '', $deng);
    $deng = preg_replace('/[\]]+/i', '', $deng);
    $aaa = preg_replace('/["]+/i', '', $deng);
    $aaaq = str_replace(',', '&', $aaa);
    $aaaq = str_replace(':', '=', $aaaq);
    $aaaq = "?$aaaq";
    $ab = trim($aaaq);
    $bb = str_replace(" ", "", $ab);
    $bb = str_replace("\r\n", "", $bb);
    $bb = str_replace("\n", "", $bb);

    return $bb;
}

/* 第五步 微信公众平台获取用户头像 */
/*function gethead($token, $fakeid, $cookie)
{
    $url = "http://mp.weixin.qq.com/misc/getheadimg?token=" . $token . "&fakeid=" . $fakeid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, $cookies); // 设置头信息的地方
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, "http://mp.weixin.qq.com/cgi-bin/getmessage?t=wxm-message&token=" . $token . "&lang=zh_CN&count=50");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);
    // var_dump($output);
    $img = $output;
    return $img; // storge中的头像地址
}*/

function gethead($url)
{
    $ch = curl_init();
    error_log($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //curl_setopt($ch, CURLOPT_REFERER, "https://cp.9-leaf.com/");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
    $output = curl_exec($ch);
    curl_close($ch);
    // var_dump($output);
    $img = $output;
    return $img; // storge中的头像地址
}

// var_dump(gethead($token,"135825155",$cookie));
/* 第六步 微信公众平台获取用户图片 */
function getimages($token, $messageid, $cookie)
{
    $url = "https://mp.weixin.qq.com/cgi-bin/getimgdata?token=$token&msgid=$messageid&mode=large&source=&fileId=0";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=20&day=7&token=" . $token . "&lang=zh_CN");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $images = $output;
    return $images;
}
// var_dump(getimages($token,$messageid,$cookie));
/* 新增时间戳 */
function datetime($token, $cookie, $cookies)
{
    $url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=20&day=7&token=$token&lang=zh_CN";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&token=$token&lang=zh_CN&pagesize=10&pageidx=0&type=0&groupid=0");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    // var_dump($output);//全部消息
    curl_close($ch);
    $u_msg = substr($output, (strpos($output, "{\"msg_item\":") + 13));
    $abc = substr($u_msg, (strpos($u_msg, "{\"msg_item\":[\":") + 1));
    $u = stripos($abc, "}");
    $aaaa = substr($abc, 0, $u);
    // var_dump($aaaa);
    $u_m = str_replace(',', '&', $aaaa);
    $u_m = str_replace("\"", "", $u_m);
    $u_m = str_replace(":", "=", $u_m);
    $u_m = "?$u_m";
    // $u_m=substr($u_m,(strpos($u_m,"?")+1));
    parse_str($u_m);
    // var_dump(1);
    $date = $date_time;
    return $date;
}

// var_dump(datetime($token,$cookie,$cookies));
/**
 * 写入图片
 * @param unknown $img
 * @param unknown $name
 * @return string
 */
function makeimg($img, $name)
{
    /* 以下为获取头像 */
    // exit('a');
    // exit(dirname(dirname(__FILE__)).'/head/'.$name);
    $filename = "{$name}.jpg"; // 要生成的图片名字
    $jpg = $img; // 得到post过来的二进制原始数据
                 // 以下为sae的sotrage
    $domain = '/head/';
    /*
     * $filename = $filename;
     * $file_contents = $jpg;
     * $s = new SaeStorage();
     * $s->write($domain, $filename ,$file_contents);
     * $imgurl=$s->getUrl($domain, $filename );
     */
    $filename = dirname(dirname(__FILE__)) . $domain . "{$name}.jpg";
    error_log($filename);
    $fp = fopen($filename, "w");
    if ($fp) {
        fwrite($fp, $jpg);
        fclose($fp);
    }
    $imgurl = $domain . "{$name}.jpg";
    // exit($imgurl);
    /* 获取结束 */
    return $imgurl;
}

/**
 * 微信http请求获取用户详细信息
 * @param $OPENID String 微信的openid
 * @return array 用户详细信息
 */
function sixi_api($OPENID = '')
{
    $access_token = get_access_token();

    //$OPENID = 'oHplgwKWJBMvTZSkXn_fEBolq09A'; // OPENID:用户在当前公众号的openid

    // 获取用户基本信息
    error_log($access_token);
    $get_userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$OPENID}&lang=zh_CN";

    $userinfo_res = file_get_contents($get_userinfo_url);
	error_log($userinfo_res);
    $userinfo_json_obj = json_decode($userinfo_res, true);
    //error_log($userinfo_res);
    $userinfo = $userinfo_json_obj['access_token'];
   error_log(json_encode($userinfo)); 
   /*
     * eg:
     * {"subscribe":1,"openid":"oHplgwKWJBMvTZSkXn_fEBolq09A","nickname":"🐳Alam","sex":1,"language":"zh_CN","city":"汕头","province":"广东","country":"中国",
     * "headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/ZFyBjFtnADn8US20Ovo89gqz0CV2kLn7bVqIAb8updrMpua4vpB7wicDXc9QKOwprpKtGWjkRKK89ZkdOd9aKwiarCq8DBic59W\/0",
     * "subscribe_time":1473789412,"remark":"","groupid":0,"tagid_list":[]}
     */
    return $userinfo_json_obj;
}

/**
 * 获取access_token方法，定时刷新
 */
function get_access_token()
{
    // 启动session
    session_start();
    $last_token_recordtime = $_SESSION['token_recordtime'];

    if (date('Y-m-d H:i:s', strtotime("-7200 second")) > $last_token_recordtime) {
        // WECHAT_APPID\WECHAT_APPSECRET 常量 暂时定义
        define("WECHAT_APPID", "wxa05e0970ca30515a");
        define("WECHAT_APPSECRET", "3d84852e5aa33c8dd2e9c9d5da8ad2ae");
	//define("WECHAT_APPID", "wx304db9b2a6f5133b");
        //define("WECHAT_APPSECRET", "90c2253c2c79033798f4c8dcbb67a94a");

        $APPID = WECHAT_APPID; // WECHAT_APPID:公众号在微信的appid
        $APPSECRET = WECHAT_APPSECRET; // WECHAT_APPSECRET:公众号在微信的唯一凭证密钥

        // 获取access_token eg:rq9PDsYIJhIdL1ksKQtLNsdn5d4RfxiWsRq2KbN14MBc0vOEI1j8qjwElJSyNfbGaSc2lIpi5QmeHbFZTpXbwonlILOkQDc3qKyIPkVmoDPukHZtle9duamLSxrV8W5RRCJcAHAMXE
        $get_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$APPSECRET}";

        // 解析json，截取公众号的access_token
        $token_res = file_get_contents($get_token_url);
        $token_json_obj = json_decode($token_res, true);
        $access_token = $token_json_obj['access_token'];
        $token_recordtime = date('Y-m-d H:i:s');

        // 记录token与当前时间
        $_SESSION['access_token'] = $access_token;
        $_SESSION['token_recordtime'] = $token_recordtime;
    } else {
        $access_token = $_SESSION['token_recordtime'];
    }

    return $access_token;
}

?>
