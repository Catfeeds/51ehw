<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Shop extends Api_Controller
{
   
    
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('order');
        $this->load->model('customer_shop_mdl','shop');
        $this->load->model('product_mdl','product');
        $this->load->model('customer_mdl');
        $this->load->model('charge_mdl','charge');
        $this->load->model('article_mdl');
        
    }
    
    
    public function index()
    {
        echo 'Shop API';
    }
    
    
    public function show(){
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata ( 'user_id' );
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $shop = $this->shop->load($user_id);
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        if($shop){
            $return['data']['message'] = '成为我们互助店一员，一个是加盟费的收益和5%手续费收益！';
        }
        print_r(json_encode($return));
    }
    public function create(){
        $prams = $this->p;
        $return = $this->return;
    
        $user_id = $this->session->userdata ( 'user_id' );
         
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
         
        $shop = $this->shop->load($user_id);
         
        if($shop){
            if(!$shop['status']){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '9',
                    'errorMessage' => '您开通的互助店已经在审核了，请耐心等候！'
                );
                print_r(json_encode($return));
                exit();
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '您已经开通互助店了，无需重复购买！'
                );
            }
            print_r(json_encode($return));
            exit();
        }
         
        $customer = $this->customer_mdl->load($user_id);
        $parent_id = empty($customer['parent_id']) ? NULL:$customer['parent_id'];//上线ID
        if($parent_id){//有上线
            $_customer = $this->customer_mdl->load($parent_id);//获取上线用户信息
            $_parent_id = empty($_customer['parent_id']) ? NULL:$_customer['parent_id'];//上上线ID
             
        }else{
            $_parent_id = NULL;//没有上线,那上上线ID也肯定没有呀
        }
         
        $this->shop->name = $customer['name'];
        $this->shop->logo = $customer['wechat_avatar'];
        $this->shop->app_id = $this->session->userdata("app_info")["id"];
        $id = $this->shop->create();
    
        if($id){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
             
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '新建互助店失败'
            );
        }
        print_r(json_encode($return));
    }
    
    

    
    
    /**
     * 编辑互助店
     */
    public function update(){
        $prams = $this->p;
        $return = $this->return;
        
        
        // 检验参数
        $this->_check_prams($prams, array(
            'name'
        ));
        
        $user_id = $this->session->userdata ( 'user_id' );
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $name = $prams['name'];
        $this->shop->name = $name;
        $status = $this->shop->update($user_id);
        if(!$status){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '编辑失败！'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 获取互助店信息
     * 如 店铺头像 店铺名称 店铺介绍
     */
    public function get_Shop(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata ( 'user_id' );
       
        if ($user_id == null || $user_id == "") {
           $return['responseMessage'] = array(
               'messageType' => 'error',
               'errorType' => '5',
               'errorMessage' => '用户未登录'
           );
           print_r(json_encode($return));
           exit();
        }
        
        $shop = $this->shop->load($user_id);
       
        if(!$shop){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '用户尚未注册互助店！'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['data']['shopid'] = base64_encode($shop['id']);
        $return['data']['parent_id'] = $shop['customer_id'];  //用户ID
        $return['data']['logo'] = $shop['logo'];    //互助店LOGO
        $return['data']['name'] = $shop['name'];  //互助店店名称
        
        //获取时间今日时间区间
        $this->load->helper("time");
        $time = GetTime('today');
        //累计收入
        if($total = $this->shop->my_income($user_id)["total"]){}else{
            $total = '0.00';
        }

        //今天收入
        if($today_total = $this->shop->my_income($user_id,$time["start_at"],$time["ent_at"])["total"]){}else{
            $today_total = '0.00';
        }
        $return['data']['today_earning'] = $today_total;     //今日收入
        $return['data']['total_earning'] = $total;     //累计收入
        
        print_r(json_encode($return));
        
    }
    
    
    public function getCode(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata ( 'user_id' ); 
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $shop = $this->shop->load($user_id);
        if(!$shop){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '您还不是互助店用户哦！'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['data']['name'] = $shop['name']; //互助店名称
        $return['data']['url'] = site_url('Shop/skipping').'?parent='.base64_encode($user_id).'&mark='.base64_encode(5);
        $return['data']['logo'] =$shop['logo'];    //互助店LOGO
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取好文列表
     */
    public function get_ArticleList(){
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
        
        $user_id = $this->session->userdata ( 'user_id' ); //购买人登录id
        
        //关键词搜索
        $keyword = isset($prams['keyword'])?$prams['keyword']:'';
       
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //获取好文
        $this->load->model('article_mdl');
        
        $totalcount = count($this->article_mdl->get_listcount($keyword));
        
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        //默认20条
        if(empty($perPage)){
            $perPage = 20;
        }
        $data =  $this->article_mdl->get_list($keyword,$perPage, $offset);
        
        foreach ($data as $k =>$v){
           unset($data[$k]['content']);//删除文章内容
        }
        foreach ($data as $key =>$val){
            $data[$key]['logo']  = $val['logo'];//IMAGE_URL.$val['logo'];
            $data[$key]['parent'] = $user_id;
            $data[$key]['url'] =site_url('shop/skipping').'?id='.base64_encode($val['id']).'&type='.base64_encode(1).'&parent='.base64_encode($user_id).'&mark='.base64_encode(2);
        }
        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $data;
      
        print_r(json_encode($return));
        
    }
    
    
    /**
     * 添加商品/好文阅读记录
     */
    public function add_read(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'type',
            'communal_id'
        ));
        
        $user_id = $this->session->userdata ( 'user_id' );
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
       
        
        $type =  $prams['type'];//好文1 商品2
        $communal =  $prams['communal_id'];//商品/好文ID
        
        $this->load->model('article_mdl');
        //记录阅读
        $id = $this->article_mdl->add_read($user_id,$type,$communal);
        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => $id
        );
        print_r(json_encode($return));
    }
    
    public function add_share(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata ( 'user_id' );
        // 检验参数
        $this->_check_prams($prams, array(
            'type',
            'communal_id'
        ));
        
        $type =  $prams['type'];//好文1 商品2
        $communal =  $prams['communal_id'];//商品/好文ID
        
        //记录分享
        $id= $this->article_mdl->add_share(0,$type,$communal);
        //获取该分享记录信息
        $query = $this->article_mdl->get_sharetime($id,$type);
          
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => $id
        );
        //返回分享时间
        $return['data']['time']= base64_encode($query['created_at']);
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 添加互助店商品
     */
    public function add_product(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'pro_id',
            'type' //添加 1 删除2
        ));
        $user_id = $this->session->userdata ( 'user_id' );
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $shop = $this->shop->load($user_id);
        if(!$shop){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '10',
                'errorMessage' => '您还没开通互助店哦！'
            );
            print_r(json_encode($return));
            exit;
        }
        $pro_id =  $prams['pro_id'];//商品ID
        $type =  $prams['type'];//商品ID
        
        if($type == 1){
            $pro = $this->product->load($pro_id);
            if(!$pro){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '该商品不存在！'
                );
                print_r(json_encode($return));
                exit;
            }
            if($pro['is_on_sale'] != 1){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '该商品还没上架！'
                );
                print_r(json_encode($return));
                exit;
            }
            
            $pro_info['shop_id'] = $shop['id'];
            $pro_info['product_id'] = $pro_id;
            $id  = $this->shop->add_product($pro_info);
            
            if(!$id){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '添加商品失败！'
                );
                print_r(json_encode($return));
                exit;
            }
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => $id
            );
            print_r(json_encode($return));
        }else{
           //删除商品
           $shop_pro =  $this->shop->check_product($shop['id'],$pro_id);
           if(!$shop_pro){
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '9',
                   'errorMessage' => '您还没添加过该商品哦！'
               );
               print_r(json_encode($return));
               exit;
           }
        if($shop_pro['status'] == '2' ){//当该商品已发布不能删除
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '12',
                   'errorMessage' => '该商品已经发布了哦！不可取消！'
               );
               print_r(json_encode($return));
               exit;
           }
           if( $shop_pro['status'] == '1'){//当该商品已发布不能删除
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '13',
                   'errorMessage' => '该商品已经选定了哦！不可取消！'
               );
               print_r(json_encode($return));
               exit;
           }
           
          $query =  $this->shop->del_product($shop_pro['id']);
           if($query){
               $return['responseMessage'] = array(
                   'messageType' => 'success',
                   'errorType' => '0',
                   'errorMessage' => ''
               );
           }else{
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '11',
                   'errorMessage' => '删除失败！'
               );
           }
           print_r(json_encode($return));
        }
        
    }
    /**
     * 获取互助店商品
     */
    public function get_ShopProducts(){
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
       
        $status = isset($prams['status'])?$prams['status']:0;
        
        $user_id = $this->session->userdata ( 'user_id' );
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $shop = $this->shop->load($user_id);
        $totalcount = count($this->shop->get_product($status,$shop['id']));
     
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        if($status){//已选定
            $product_list = $this->shop->get_product($status,$shop['id']);
        }else{
            $product_list = $this->shop->get_product($status,$shop['id'],$perPage,$offset);
        }
      
//         foreach ($product_list as $key =>$val){
//             $product_list[$key]['parent'] = $user_id;
//             $product_list[$key]['url'] = site_url('shop/skipping').'?id='.base64_encode($val['id']).'&type='.base64_encode(2).'&parent='.base64_encode($user_id);
//         }
      
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $product_list;
        
        
        print_r(json_encode($return));
        
    }
    
    
    
    public function edit_product(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
      
//         $product_list =array(
//             'id'=>1,
//             'sequence' => 10
//         );
//         $product_list =array(
//             'id'=>1,
//             'status' => 0:1:2
//         );
        
       //编辑商品排序/发布/下架/删除
       $this->_check_prams($prams, array(
           'product_list',
           'type'
           ));
       
       $user_id = $this->session->userdata ( 'user_id' );
       $shop = $this->shop->load($user_id);
       
       $list = $prams['product_list']; //需要更新的数组
      
       $type = $prams['type']; //操作类型
       $datetime = date('Y-m-d H:i:s');
       switch ($type){
           //未选定  
           case 'uncertain':
               foreach ($list as $key =>$val ){
                   $list[$key]['status'] = 0 ;
                   $list[$key]['update_at'] =$datetime;
               }
               $this->shop->update_product($list);
               break;
           //已选定
           case 'preview':
               foreach ($list as $key =>$val ){
                   $list[$key]['status'] = 1 ;
                   $list[$key]['update_at'] =$datetime;
               }
               $this->shop->update_product($list);
               break;
           //发布   
           case 'sale_up':
               $num = 200;
               foreach ($list as $key =>$val ){
                   $list[$key]['sequence'] = $num;
                   $list[$key]['status'] = 2 ;
                   $list[$key]['update_at'] =$datetime;
                   $num --;
               }
               $this->shop->update_product($list);
               break;
           //删除    
           case 'delete':
               foreach ($list as $key =>$val ){
                   $this->shop->del_product($val['id']);
               }
               break;
       }
       $return['responseMessage'] = array(
           'messageType' => 'success',
           'errorType' => '0',
           'errorMessage' => ''
       );
       print_r(json_encode($return));
    }
    
    /**
     * 购买互助店资格
     */
    
    public function pay_Shop(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array('order_source','payment_id'));
        
     
        $payment_id = isset($prams["payment_id"]) ? $prams["payment_id"] : 0;
        $order_source =  $prams['order_source'] == "ios" ? 4 : 3; // 订单来源
        
        $user_id = $this->session->userdata ( 'user_id' ); //购买人登录id
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
       
        
       $shop = $this->shop->load($user_id);
       
       $this->load->model('Config_mdl');
       $msg = $this->Config_mdl->get_ByName('shop_price');//获取开通互助店金额
       $price = $msg['value']; //购买互助店资格金额
       
       if($shop){
           if($shop['status'] == 1){//已经开通互助店了
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '6',
                   'errorMessage' => '您已经开通互助店了！'
               );
               print_r(json_encode($return));
               exit;
           }
       }
        
        //生成现金购买记录
        $charge_data["payment_id"] = $payment_id;//微信支付
        $charge_data['order_source'] = $prams['order_source'] == "ios" ? 4 : 3; // 订单来源
        $charge_data['customer_id'] = $user_id; // 用户id
        $charge_data['type'] = 0; //前台充值
        $charge_data['status'] = 0; //未支付
        $charge_data['amount'] = $price ;
        $charge_data['source'] = 1 ; //互助店购买标识
        $time = date('Y-m-d H:i:s');
        $charge_data['create_date'] = $time; //生成流水号时间    
        
        $is_ok = false;
        // 生成流水号
        do {
            $charge_data['chargeno'] = get_order_sn();
        
            if ($this->charge->load_byChangeNum( $charge_data['chargeno'] ) ) {
                $order_exist = true;
            } else {
                $new_charge_id = $this->charge->create($charge_data);
                if($new_charge_id){
                    $is_ok = true;
                }
                $order_exist = false;
            }
        } while ($order_exist); // 如果是流水号重复则重新提交数据
        
        if(!$is_ok){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '生成订单失败!'
            );
            print_r(json_encode($return));
            exit;
        }
       
        $data['name'] = '互助店资格购买';
        $data['price'] = $price;
        $data['order_sn'] = 'HZD'.$charge_data['chargeno'];  //返回流水号
   
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        $return['data'] = $data;
        print_r(json_encode($return));
        
    }



    /**
     * 下线分享统计
     */
    public function share_total(){
        
        // 获取参数
        $return = $this->return;
        $page = $this->n;
        $prams = $this->p;
        // 检验参数
        $this->_check_prams($prams, array('type'));
        
        $limit = $page['perPage']; // 每页记录数
        $offset = ($page['currPage']-1)*$limit; // 偏移量
        $type =$prams["type"];//识别日期
        $customer_id = $this->session->userdata("user_id");//用户id

        //登录验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }

        //获取时间区间
        $this->load->helper("time");
        $time = GetTime($type);
       
        $return['data']['list'] = $this->shop->share_total($customer_id,$time["start_at"],$time["ent_at"],$limit,$offset);//查询下线分享阅读次数 
       
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        echo json_encode($return);
        
    }
    
    //--------------------------------------------------------------
    
    /**
     * 分享排行榜统计
     */
    public function share_list(){
        // 获取参数
        $return = $this->return;
        $page = $this->n;
        $prams = $this->p;
        // 检验参数
        $this->_check_prams($prams, array('type'));
        
        $customer_id = $this->session->userdata("user_id");//用户id
        //登录验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        $limit = $page['perPage']; // 每页记录数
        $offset = ($page['currPage']-1)*$limit; // 偏移量
        $type =$prams["type"];//识别日期

        //获取时间区间
        $this->load->helper("time");
        $time = GetTime($type);

        $return['data']['list'] = $this->shop->share_list($time["start_at"],$time["ent_at"],$limit,$offset);//查询排行榜
        $return['data']['my_ranking'] = $this->shop->my_share($customer_id,$time["start_at"],$time["ent_at"]);//查询自身排行榜

        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        echo json_encode($return);
    }
    
    //--------------------------------------------------------------
    
    /**
     * 推广统计
     */
    public function spread(){
        // 获取参数
        $return = $this->return;
        $prams = $this->p;
        $page = $this->n;
        // 检验参数
        $this->_check_prams($prams, array('type'));
        $limit = $page['perPage']; // 每页记录数
        $offset = ($page['currPage']-1)*$limit; // 偏移量
        
        $customer_id = $this->session->userdata("user_id");//用户id
        //登录验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }

        switch($prams["type"]){
            case 1://已读
                $return['data']['list'] = $this->shop->spread($customer_id,1,false,$limit,$offset);
                break;
            case 2://已注册
                $return['data']['list'] = $this->shop->spread($customer_id,2,false,$limit,$offset);
                break;
            case 3://已消费
                $return['data']['list'] = $this->shop->spread($customer_id,3,false,$limit,$offset);
                break;
            case 4://店主
                $return['data']['list'] = $this->shop->spread($customer_id,4,false,$limit,$offset);
                break;
            default:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '参数错误'
                );
                print_r(json_encode($return));
                exit();
                break;
        }

        
        $return['data']['reader_total'] = $this->shop->spread($customer_id,1,true);//读者数量
        $return['data']['member_total'] = $this->shop->spread($customer_id,2,true);//注册数量
        $return['data']['active_total'] = $this->shop->spread($customer_id,3,true);//消费数量
        $return['data']['vip_total'] = $this->shop->spread($customer_id,4,true);//店主数量

        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        
        print_r(json_encode($return));
        exit();
    }
    
    public function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    //--------------------------------------------------------------
    
    
    
    //curl_post
    public function curl_post_result( $url, $data ){
        $data['key'] = 'jiami';
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
    
        return($result);
    
    }
}