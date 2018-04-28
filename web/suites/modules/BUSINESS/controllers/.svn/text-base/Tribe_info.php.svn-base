<?php
/** 
 * 部落-我的
 * 
 */
class Tribe_info extends Front_Controller
{
    private $customer;
    private $tribe_id;
    private $tribe_name;
    function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('ref_from_url', current_url());
        //判断登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        
        $this->customer_id  = $this->session->userdata("user_id");
        $tribe_id = $this->input->get_post('tribe_id');
        
        
        if( $tribe_id && is_numeric( $tribe_id ) && strpos( $tribe_id,'.') == false)
        {
            $this->load->model('tribe_mdl');
            $tribe_info = $this->tribe_mdl->load( $tribe_id,$this->customer_id );
        
            if( !$tribe_info )
            {
                //部落不存在，或未通过。
                echo "<script>history.back(-1);alert('部落不在，无法访问');</script>";exit;
        
            }else if( !$tribe_info["tribe_staff_id"] || $tribe_info['status'] != 2 )
            {
                //未加入该部落
                echo "<script>history.back(-1);alert('未加入该部落，无法访问');</script>";exit;
            }
            $this->tribe_name = $tribe_info["name"];
        }else{
            //未加入该部落
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }
        
        $this->tribe_id = $tribe_id;

        
        //调用接口处理
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $this->session->userdata("user_id");
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        $this->customer = $customer;
        
        // 判断是否微信浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            if(!empty($customer['mobile'])){
                $this->session->set_userdata("mobile_exist",true);
            }else{
                redirect('member/binding/binding_mobile');
            }
            
        }
    }
    
    /**
    * @author JF
    * 2018年3月30日
    * 我的
    */
    function my(){
        $customer_id = $this->session->userdata("user_id");//用户id
        $tribe_id = $this->input->get_post("tribe_id");
        $this->load->model('Easyshop_mdl');
        $this->load->model("easyshop_order_mdl");
        $this->load->model("easyshop_mdl");
        $customer = $this->customer;
        
        if($customer["idcard"]){
            //查询简易店铺
            $shop = $this->Easyshop_mdl->Load($customer_id);
            if($shop){
                //查询创建的产品数量
                $producttotal = $this->easyshop_mdl->personal_product_select($shop["id"],$tribe_id);
                //查询卖家最后一张订单
                $LastOrder = $this->easyshop_order_mdl->LastOrder($shop["id"],$tribe_id);
                if($LastOrder){
                    switch ($LastOrder["status"]){
                        case "1":
                            $orderstatus = "待支付";  
                            break;
                        case "2":
                            $orderstatus = "待发货";  
                            break;
                        case "3":
                            $orderstatus = "已发货";
                            break;
                        case "4":case "5":
                            $orderstatus = "已完成";
                            break;
                        case "6":
                            $orderstatus = "订单取消";
                            break;
                        case "7":
                            $orderstatus = "已退款";
                            break;
                    }
                }
                //销售订单总数
                $OrderTotal = $this->easyshop_order_mdl->SalesOrder($shop["id"],$tribe_id);
                
            }
        }
        
        //查询买家最后一张订单
        $BuyersLastOrder = $this->easyshop_order_mdl->BuyersLastOrder($customer_id,$tribe_id);
        if($BuyersLastOrder){
            switch ($BuyersLastOrder["status"]){
                case "1":
                    $Buyersstatus = "待支付";
                    break;
                case "2":
                    $Buyersstatus = "待发货";
                    break;
                case "3":
                    $Buyersstatus = "已发货";
                    break;
                case "4":case "5":
                    $Buyersstatus = "已完成";
                    break;
                case "6":
                    $Buyersstatus = "订单取消";
                    break;
                case "7":
                    $Buyersstatus = "已退款";
                    break;
            }
        }
        
        //买家订单总数
        $BuyersTotal = $this->easyshop_order_mdl->BuyersOrder($customer_id,$tribe_id);
        
        $data["producttotal"] = !empty($producttotal)?$producttotal:0;
        $data["orderstatus"] = !empty($orderstatus)?$orderstatus:null;
        $data["Buyersstatus"] = !empty($Buyersstatus)?$Buyersstatus:null;
        $data["LastOrder"] = !empty($LastOrder)?$LastOrder:array();
        $data["OrderTotal"] = !empty($OrderTotal)?$OrderTotal:0;
        $data["BuyersLastOrder"] = !empty($BuyersLastOrder)?$BuyersLastOrder:array();
        $data["BuyersTotal"] = !empty($BuyersTotal)?$BuyersTotal:0;
        $data["shop"] = !empty($shop)?$shop:array();
        $data['customer'] = $customer;
        $data["tribe_id"] = $this->tribe_id;
        $data["customer_id"] = $customer_id;
        $data['title'] = $this->tribe_name;
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/memberinfo.php', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    

}