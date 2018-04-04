<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Hx_short_message 
{

    private  $USERNAME = "";

    private  $PASSWD = "";

    private  $URL = "";


    public function __construct($username, $passwd, $url){

        $this->USERNAME = $username;
        $this->PASSWD = md5($passwd);
        $this->URL = $url;
    }

    /**
     * 发送信息
     * @param string $phonenum 手机号码
     * @param string $content 内容
     */
    function send($phonenum, $content)
    {
        $url = $this->URL ."?action=send&userid=&account=".$this->USERNAME."&password=".$this->PASSWD."&mobile=".$phonenum."&content=".urlencode($content)."&sendTime=&extno";
        $returns = file_get_contents($url);
        return $returns;
    }

//     public function get_status($phonenum)
//     {
//         //$signal = md5($PASSWD . $USERNAME);
//     }

//     /**
//      * 取剩余条数
//      * @param unknown $phonenum
//      * @param unknown $content
//      */
//     public function get_last_count($phonenum, $content)
//     {
//        /* $signal = md5($this->PASSWD . $this->USERNAME);
//         $messagenum = $phonenum . getMillisecond();
//         $url = $this->URL . "mm/?uid=" . $this->USERNAME . "&pwd=" . $signal . "&mobile=" . $phonenum . "&mobileids=" . $messagenum . "&content=" . $content;
//         $returns = file_get_contents($url);
//         */
//     }

//     /**
//      * 获取毫秒
//      *
//      * @return number
//      */
//     function getMillisecond()
//     {
//         list ($t1, $t2) = explode(' ', microtime());
//         return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
//     }

    /**
     * 随机多位
     * @param $n 随机值大小
     */
    function random($n){
        $min = 1*pow(10, ($n - 1));
        $max = 1*pow(10, ($n)) - 1;
        return rand($min, $max);
    }
}
