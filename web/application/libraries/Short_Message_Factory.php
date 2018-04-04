<?php

/**
 * 发送短信工厂
 * @author clarkso
 *
 */
require_once "Short_Message.php";

class Short_Message_Factory
{

    public function __construct(){
    }

    /**
     * 返回实例对象
     *
     * @param array $supplier
     * @return
     *
     */
    public function get_message($supplier)
    {
        require_once $supplier['supplier_class'] . '.php';
        return new $supplier['supplier_class']($supplier['supplier_account_name'],$supplier['supplier_account_passwd'],$supplier['supplier_api_url']);
    }

    //------------------------------------------------------

    /**
     * 随机多位
     * @param $n 随机值大小
     */
    function random($n)
    {
        //根据时间戳和微秒数获取随机数
        $time = microtime();
        $time = str_replace(array("."," "), "", $time);
        $start = rand(1, 6);
        $mobile_code = substr($time, $start, $n);
        return $mobile_code;
    }
//     function random($n){
//         $min = 1*pow(10, ($n - 1));
//         $max = 1*pow(10, ($n)) - 1;
//         echo  rand($min, $max);
//     }
}