<?php

/**
 *  M包
 *
 *
 */
class Package extends Front_Controller
{
    var $is_binding = true;//默认已经绑定
    function __construct()
    {
        parent::__construct();
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $url = site_url($_SERVER['PATH_INFO']);
            // 检查登录
            $customer_id = $this->session->userdata("user_id");
            if (!$customer_id) { 
                $this->session->set_userdata('ref_from_url', $url);
                redirect('third_signin/wechat');
                return;
            }else{
                // 微信用户绑定监测
                $customer_id = $this->session->userdata("user_id");//用户id
                $this->load->model("customer_mdl");
                $customer = $this->customer_mdl->load($customer_id);
                if (empty($customer['mobile'])) {
                    $this->is_binding = false;
                }
            }
        }else{
             redirect('home');
             return;
        }
        
        $this->load->model('package_mdl');
    }
  


    // -----------------------------------------------------------------------------------

    /**
     * 进入发送红包页面
     */
    public function index()
    {
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }

        $data['title'] = '51易货网';
        $data['head_set'] = 2;
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view('package/list_view',$data);
//         $this->load->view ( '_footer', $data );
//         $this->load->view ( 'foot', $data );
    }

    // ---------------------------------------------------------------------------------

    
    


    /**
     * 提交发送红包
     */
    function send_package()
    {
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }

        $num = $this->input->post('num');//发送数量
        $per_m = $this->input->post('per_m');//金额
        $desc = $this->input->post('desc');//留言
        $status = $this->input->post('status');//红包类型：1手气2普通
        $password = $this->input->post("password");//支付密码
        $customer_id = $this->session->userdata("user_id");//用户id
        $relation_id = $this->session->userdata ('pay_relation');//pay_relation表id
        $time = date('Y-m-d H:i:s');

        if(!preg_match("/(^[1-9][0-9]$)|(^[1-9]$)$/",$num) || !preg_match("/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/",$per_m) || strlen($password) < 6){
            echo json_encode(array("status"=>1,"message"=>"数据错误"));
        }

        $per_m = number_format($per_m,2,".","");
        if($status == 1){//普通
            $total = $per_m*$num;
        }else if($status == 2){//手气
            if(($per_m/$num)<0.01){
                echo json_encode(array("status"=>1,"message"=>"手气最少要0.01"));exit;
            }
            $total = $per_m;
        }else{
            echo json_encode(array("status"=>1,"message"=>"非法红包类型"));exit;
        }
        
        
        //调用接口处理数据
        $url = $this->url_prefix.'Customer/load_pay_account';
        $data_post['customer_id'] = $customer_id;
        $pay_account = json_decode($this->curl_post_result($url,$data_post),true);
        if($pay_account["pay_passwd"] != md5($password)){
            echo json_encode(array("status"=>3,"message"=>"请输入正确的支付密码！"));exit;
        }


        //开启事务
        $this->db->trans_begin();
        //分发红包
        $data['num'] = $num;
        $data['per_m'] = $per_m;
        $data['desc'] = $desc;
        $data['status'] = $status;
        $data['total'] = $total;
        $package_id = $this->package_mdl->send_package($customer_id, $data);//发送红包
        if( $package_id )
        { 
            //调用接口处理数据
            $url = $this->url_prefix.'Package/send_package';
            $data_post['relation_id'] = $relation_id;
            $data_post['customer_id'] = $customer_id;
            $data_post['total_price'] = $total;
            $data_post['package_id'] = $package_id;
            $data_post['app_id'] = $this->session->userdata('app_info')['id'];
            $error = json_decode($this->curl_post_result($url,$data_post),true);
            
            if($error['status'] == 1)
            { 
                $this->db->trans_commit();
                $this->session->set_userdata('my_package', $package_id);
                echo json_encode(array("id"=>$package_id,"status"=>2,"message"=>"发送成功"));
            }else{
                $this->db->trans_rollback();
                echo json_encode(array("status"=>4,"message"=>"发送失败"));

            }
        }else{
            $this->db->trans_rollback();
            echo json_encode(array("status"=>4,"message"=>"发送失败"));

        }
            
        

    }

    //------------------------------------------------------------------------------
    
    
    /**
     * 分享出去
     * @param int $package_id 红包id
     */
    function share($package_id)
    {
        //查询判断是否存在红包
        $package = $this->package_mdl->load($package_id);
        if(!$package){
            echo '<script type="text/javascript"> alert("红包不存在！"); history.back(); </script>';
            return ;
        }
        
        $pack_id = $this->session->userdata('my_package'); 
        if($pack_id){  
            $this->session->unset_userdata('my_package');
            //分享页面
            $data['package'] = $package;
            $data['title'] = '51易货网红包';
            $data['head_set'] = 2;
            $this->load->view ( 'head', $data );
            $this->load->view('package/share_view', $data);
            return;
        }
            
        $customer_id = $this->session->userdata("user_id");//用户id
        //判断是否绑定手机
        if(!$this->is_binding){
            $customer_id = $this->session->userdata("pre_customer_id");//预绑定id
            if(!$customer_id){
                redirect("package/enter_mobile/$package_id");//跳转输入手机
            }
        }

        //判断是否抽过红包
        $is_receive_red = $this->package_mdl->get_package($package_id, $customer_id);
        if(count($is_receive_red) > 0){
            $data['is_full'] = false;//识别我是否领取
            $data['getter'] = $this->package_mdl->get_package_list($package_id);//领取列表信息
            $view = "package/show_view";
        }else{
            //如果红包被抢满
            if($this->package_mdl->is_package_full($package_id) == 0){
                $data['is_full'] = true;//识别我是否领取
                $data['getter'] = $this->package_mdl->get_package_list($package_id);//领取列表信息
                $view = "package/show_view";
            }else{
                //判断是否绑定手机
                if(!$this->is_binding){
                    $url = site_url($_SERVER['PATH_INFO']);
                    $this->session->set_userdata('ref_from_url', $url);
                    redirect("package/enter_mobile/$package_id");//跳转输入手机
                }
                $view = "package/broken_view";
            }
        }
        $data['sender'] = $this->customer_mdl->load($package['originator']);//发送人信息
        
        $data['package'] = $package;
        $data['package_id'] = $package_id;
        $data['customer_id'] = $customer_id;
        $data['title'] = '51易货网红包';
        $data['head_set'] = 2;
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view($view,$data);

    }
    
    
    //------------------------------------------------------------------------------
    


/**
 * 点击拆红包，获取红包
 * @param int $package_id 红包id
 */
function get_package($package_id){

        $data['title'] = '51易货网';
        $customer_id = $this->session->userdata("user_id");//用户id
        $pay_relation_id = $this->session->userdata ('pay_relation');
        
        //判断是否绑定手机
        if(!$this->is_binding){
            $customer_id = $this->session->userdata("pre_customer_id");//预绑定id
            $pay_relation_id = $this->session->userdata("pre_pay_relation");//预绑定支付信息
            if(!$customer_id){
                redirect("package/enter_mobile/$package_id");//跳转输入手机
            }
        }


        //查询红包信息
        $red_detail = $this->package_mdl->load($package_id);
        if(!$red_detail){
            echo "<script>alert('非法操作！');history.back();</script>";
            return ;
        }
        //判断是否抽过红包
        $is_receive_red = $this->package_mdl->get_package($package_id, $customer_id);

        if(!$is_receive_red){
        //开启事务
            $this->db->trans_begin();

            //领取红包
            $row_package = $this->package_mdl->get_one_package($package_id, $customer_id);

            if( $row_package )
            { 
                
                $myreceive_red = $this->package_mdl->get_package($package_id, $customer_id);//查询我领取的红包
                
                $data_post['promoter_customer_id'] = $red_detail['originator'];
                $data_post['total_price'] = $myreceive_red["amount"];
                $data_post['relation_id'] = $pay_relation_id;
                $data_post['package_id'] = $package_id;
                $data_post['app_id'] = $this->session->userdata ('app_info')['id'];
                $url = $this->url_prefix.'Package/get_package';
                $pay_status = json_decode($this->curl_post_result($url,$data_post),true);
                
                if( $pay_status['status'] )
                { 
                    $status = 1;
                    $this->db->trans_commit();
                    
                   
                }
            }
         
            if( empty($status) ){ 
                
                $this->db->trans_rollback();
                    
            }
        }
        redirect(site_url('package/share/' . $package_id));

    }
    
    // ---------------------------------------------------------------------------------
    
    /**
     * 输入手机号码
     * @package $id 货包or红包id
     */
    function enter_mobile($id=0){

        //验证数据
        if(!$id || $id < 1){
            echo '<script>history.back(-1);</script>';
        }
        //判断是否绑定手机
        if($this->is_binding){
            redirect(site_url('package/share/' . $id));
        }
        
        $customer_id = $this->session->userdata("user_id");//用户id
        //接口--获取预绑定账户
        $post["customer_id"] = $customer_id;
        $url = $this->url_prefix.'Customer/get_customer_pre';
        $pre_customer = json_decode($this->curl_post_result($url,$post),true);
        $data["mobile"] = "";
        if($pre_customer){
            $data["mobile"] = $pre_customer["name"];
        }
        
        $url = site_url("Package/get_package/$id");
        $this->session->set_userdata('ref_from_url', $url);

        $data["id"] = $id;
        $data['title'] = '51易货网';
        $data['head_set'] = 2;
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view('package/enter_mobile',$data);

    }


   

}