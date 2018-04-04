<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Package extends Api_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("card_package_mdl",'package');
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($user_id);
        if (empty($customer['mobile'])) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '用户尚未绑定手机,请绑定手机！'
            );
            print_r(json_encode($return));
            exit();
        }
    }
    
    
    public function index(){
        echo 'Package API';
    }
   
    /**
     * 获取我的优惠券(货包)
     * type 1已使用 2未使用 3已过期
     */
    public function My_package(){
        
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
         
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        // 检验参数
        $this->_check_prams($prams,array('type'));//1used 2 not_used 3overdue
        $type = $prams['type'];
        if(!in_array($type, array("1","2","3"))){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '参数错误'
            );
            print_r(json_encode($return));
            exit();
        }
        $user_id = $this->session->userdata('user_id');
        $packageAll = $this->package->my_package_all($user_id,array(1,2));//我领取过的所有优惠券
        
        $p_array = array_column($packageAll,"p_id");//已经领取的优惠券id
        $package = $this->package->not_obtained_package($p_array);//获取发送所有人未领取的优惠券
        if($package){
            foreach ($package as $k => $v){
                $cart[$k]['p_id'] = $v['id'];
                $cart[$k]['sender_id'] = $v['customer_id'];
                $cart[$k]['customer_id'] = $user_id;
                $cart[$k]['created_at'] = date("Y-m-d H:i:s");
                $cart[$k]['status'] = 2;
            }
            $row = $this->package->aad_package($cart);//领取优惠券
        }
        $totalcount  = count($this->package->package($user_id,$type));//数量
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        //查询我的卡包
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $this->package->package($user_id,$type,0,$perPage, $offset);
     
        print_r(json_encode($return));
    } 
    
   /**
    * 优惠券(货包)详情
    */

    public function detail(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
       $this->_check_prams($prams,array('id'));
       $user_id = $this->session->userdata('user_id');
       $id = $prams['id'];
       $package = $this->package->receive($id,$user_id,true);//查询详情
       $return['data']['package'] = $package;
       
       print_r(json_encode($return));
        
    }
    /**
     * 核销现场货包
     */
    public function verify_package(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $this->_check_prams($prams,array('id'));
        $id = $prams['id'];
        $user_id = $this->session->userdata('user_id');
        
        $package = $this->package->check_package($id,true);
        if(!$package){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '货包不存在！'
            );
            print_r(json_encode($return));
            exit();
        }
      
        if($package['status'] == '1' || $package['status'] == 1){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '已核销！无重复操作！'
            );
            print_r(json_encode($return));
            exit;
        }
        //通过店铺ID判断用户是否有权限核销
        $this->load->model('Customer_corporation_mdl');
        //店铺信息
        $_corporation = $this->Customer_corporation_mdl->corp_load($package['corporation_id']);//店铺管理员ID
       
        if($user_id != $_corporation['customer_id']){//判断用户是否是店铺管理员
        
        $this->load->model('Corporation_staff_mdl');
        //判断是否是企业员工
        $staff = $this->Corporation_staff_mdl->get_corp_staff($user_id,$package['corporation_id']);
        
        if(!$staff){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '11',
                'errorMessage' => '您还不是该店铺员工哦！'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //获取用户在店铺的管理权限
        $authority = $this->Corporation_staff_mdl->get_staff_authority($package['corporation_id'],$user_id);
         
        if(!$authority){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '12',
                'errorMessage' => '您还没有分配到任何权限，请跟店铺管理员联系'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //将获取出来的权限字符串进行处理成数组
        foreach ($authority as $key => $val){
            $authority_arr[$key] = $val['url'];
        }
        
        //判断用户是否是店铺管理员
        //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
        $authority_str = '/Corporate/order/get_list';
        
        //判断用户是否拥有处理订单的权限  corporation_module表    订单的权限的权限为3
        if(!in_array($authority_str, $authority_arr)){
             $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '核销失败,权限不足！'
            );
            print_r(json_encode($return));
            exit();
            }
        }
        $row = $this->package->sure_verification($id);
        if($row){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '核销成功！'
            );
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '核销失败！'
            );
        }
  
        print_r(json_encode($return));
    }
    /**
     * 获取适用商品优惠券(货包)的商品
     */
    public function package_goods(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $this->_check_prams($prams,array('package_id'));
        $package_id = $prams['package_id'];
        $user_id = $this->session->userdata('user_id');
        
        $package_goods = $this->package->discount_goods($package_id,$user_id);//查询详情
        
        $totalcount  = count($package_goods);//数量
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $this->package->discount_goods($package_id,$user_id,$perPage, $offset);//查询详情
        print_r(json_encode($return));
        
    }
    /**
     * 领取优惠券(货包)
     */
    
    public function  gain_package(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $this->_check_prams($prams,array('package_id'));
        $user_id = $this->session->userdata('user_id');
        $package_id = $prams['package_id'];
        //查询卡包并且判断是否存在
        $package = $this->package->get_card_package($package_id,true);
        if($package){
            $row = $this->package->receive($package_id,$user_id);
            if($row){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '5',
                    'errorMessage' => '领取失败,已经领取过该货包了！'
                );
                print_r(json_encode($return));
                exit;
            }else if($package["grant_start_at"] > date("Y-m-d")){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '领取失败,领取时间还没到！'
                );
                print_r(json_encode($return));
                exit;
            }else if($package["grant_end_at"] < date("Y-m-d")){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '领取失败,领取时间已结束！'
                );
                print_r(json_encode($return));
                exit;
            }else{
                $this->db->trans_begin();//开启事务
                $row1 = $this->package->subduction($package_id,1);//扣除卡包数量
                if(!$row1){
                    $this->db->trans_rollback();//回滚
                   $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '领取失败,货包数量不足！'
                );
                print_r(json_encode($return));
                exit;
                }
                //领取卡包
                $data[0]['p_id'] = $package['id'];
                $data[0]['sender_id'] = $package['customer_id'];
                $data[0]['customer_id'] = $user_id;
                $data[0]['created_at'] = date("Y-m-d H:i:s");
                $data[0]['status'] = 2;
                $row2 = $this->package->aad_package($data);//领取
                if($row1){
                    $this->db->trans_commit();//提交
                    $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '0',
                    'errorMessage' => '领取成功！'
                     );
                }else{
                    $this->db->trans_rollback();//回滚
                     $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '3',
                        'errorMessage' => '领取失败!'
                        );
                }
            }
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '领取失败,货包不存在！'
            );
        }
        print_r(json_encode($return));
    }
    /**
     * 处理APP使用优惠券下单总金额处理
     * 
     * 获取下单的商品信息以及使用的优惠券ID
     * product_info  array(array("id"=>"","qty"=>"","sku_id"=>""))
     */
    public function manage_package_order(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $this->_check_prams($prams,array('product_info','package_id'));
        $product_info = $prams['product_info'];
        $package_id = $prams['package_id'];
        $user_id = $this->session->userdata('user_id');
      
        $zong = 0;//优惠卷统计使用
        $deduction_price = 0;//优惠金额
        $this->load->model("product_mdl");
        foreach ($product_info as $key=> $val){
            $product = $this->product_mdl->product_info($val['id']);
            $price = $product['vip_price'];
           
            $product_tribe = $this->check_tribe($val['id']);
            if($product_tribe){
                $price = $product_tribe['tribe_price'];
            }
        
            $date = date("Y-m-d H:i:s");
          
            // sku商品
            if(!empty($val["sku_id"])){
                $this->load->model('product_sku_mdl');
                $sku = $this->product_sku_mdl->getSKUValue($val["sku_id"]);
            }
            
            // 实时检查是否有特价 - 有特价执行
            if ($product['special_price_end_at'] > $date && $product['special_price_start_at'] < $date && isset($product['is_special_price'])) {
                if(!empty($val["sku_id"])){
                    $price = $sku['special_offer'];
                }else{
                    $price = $product['special_price'];//商品特价
                }
            }
            
            $p_info = $this->package->goods_coupons($val['id'],$user_id,$package_id);//卡包信息
            if($p_info){//判断此商品是否有权使用此优惠卷
                switch ($p_info[0]['discount_type']){
                    case 1://折扣运算
                        $deduction_price += ($price*(int) $val["qty"]-$price*(int) $val["qty"]*$p_info[0]['discount']/10);//优惠金额
                        break;
                    case 2://满减运算
                        $zong += $price*(int) $val["qty"];//总额
                       
                        if($zong >= $p_info[0]["overtop_price"]){//判断是否买满
                            $deduction_price = $p_info[0]["deduction_price"];//优惠金额
                        }
                        break;
                }
            }
        }
        $deduction_price = strpos($deduction_price,'.') ? substr_replace($deduction_price, '', strpos($deduction_price, '.') + 3) : $deduction_price;
        $return['data']['deduction_price'] = $deduction_price;
        print_r(json_encode($return));
        
    }
    
    
    /**
     * 检查是否我的部落
     * @param int $pid 商品id
     */
    private function check_tribe($pid){
        $product = array();
        $customer_id = $this->session->userdata("user_id");//用户id
        //判断是否属于我的部落，如果是则使用部落价格。
        $tribe_discount = 1;//默认部落折扣
        $this->load->model("tribe_mdl");
        $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落
        if($MyTribe){
            $MyTribe_id = array();
            foreach ($MyTribe as $v){
                $MyTribe_id[] = $v["id"];
            }
            $product = $this->tribe_mdl->Whether_my_tribe($pid,$MyTribe_id);//查询商品是否属于我的部落
        }
        return $product;//折扣
    }
    
    /**
     * 获取商品优惠券(货包)
     */
    public function  get_goods_packages(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $this->_check_prams($prams,array('product_info'));
        //  product_info为数组  array(array('qty'=>'','product_id'=>1414,'price_total'=>150),array('qty'=>'','product_id'=>1416,'price_total'=>222));
        $product_info = $prams['product_info'];
        $id_info = array();
        foreach ($product_info as $key =>$val){
           $product_info[$key]['price_total'] = $val['qty']*$val['price_total'];
           array_push($id_info, $val['product_id']);
           unset( $product_info[$key]['qty']);
        }
        $totalcount  = count($this->coupons($id_info,$product_info));//数量
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $this->coupons($id_info,$product_info,$perPage, $offset);//可用优惠券
        
        print_r(json_encode($return));
    }
    
    /**
     * 获取订单相关的优惠券
     * @param array $pid 商品id
     * @param array $goods_price 商品总价格 (array[0]=array("product_id"=>"11","price_total"=>"2000"))
     */
    private function coupons($pid,$goods_price,$perPage = 0, $offset = 0){
        $customer_id = $this->session->userdata("user_id");//用户id
        //订单商品相关的优惠券
        $this->load->model('card_package_mdl');
        //查询订单可以使用的优惠券
        $package  = $this->card_package_mdl->goods_coupons($pid,$customer_id,0,$perPage,$offset);
      
        if($package){
           
            //筛选出符合要求得优惠券
            $package_array = array();//记录筛选成功优惠券
            foreach ($package as $key=>$val){
                foreach ($goods_price as $k=>$v){
                    if($val['discount_type']==1){//折扣
                        unset($package[$key]['product_id']);
                        $package_array[] = $package[$key];
                    }else if($val['discount_type']==2 && $val['overtop_price'] <= $v["price_total"]){//满减
                        unset($package[$key]['product_id']);
                        $package_array[] = $package[$key];
                    }
                }
            }
            if($package_array){
                return $this->unique_arr($package_array);//优惠券信息
            }
        }
        return array();
    }
    
    /**
     * 优惠券临时方法
     * 去除二维数组重复
     * @param unknown $array2D
     * @param string $stkeep
     * @param string $ndformat
     * @return unknown
     */
    function unique_arr($array2D,$stkeep=false,$ndformat=true)
    {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if($stkeep) $stArr = array_keys($array2D);
    
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if($ndformat) $ndArr = array_keys(end($array2D));
    
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v){
            $v = join(",",$v);
            $temp[] = $v;
        }
    
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp);
    
        //再将拆开的数组重新组装
        foreach ($temp as $k => $v)
        {
            if($stkeep) $k = $stArr[$k];
            if($ndformat)
            {
                $tempArr = explode(",",$v);
                foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
            }
            else $output[] = explode(",",$v);
        }
        $info = array();
        foreach ($output as $key =>$val){
            array_push($info, $val);
        }
        return $info;
    }
    
}