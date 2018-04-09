<?php


class Autoscript extends Front_Controller{ 
    
    
    public function __construct() 
    {
        parent::__construct();
// 		echo "<meta charset='utf-8'>";
    }
    
    
    /**
     * 超时未支付，取消订单。
     * @date:2018年4月3日 下午2:31:11
     * @author: fxm
     * @param: variable
     * @return:
     */
    public function AutoCancelOrder()
    {
        $this->load->helper('easy_autoscript');
        AutoCancelOrder();//helper的方法。
    
    }
    
    public function AutoOrderReceipts()
    { 
        $this->load->helper('easy_autoscript');
        AutoOrderReceipts();
        
    }
}
