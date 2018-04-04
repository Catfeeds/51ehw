<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'Common/Uri.php';
/**
 * 互助店
 *
 *
 */
class Shop extends Front_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_shop_mdl','shop');
        $this->load->model('Customer_mdl');
        $this->load->model('article_mdl');
        //         判断用户是否登录
        if (! $this->session->userdata('user_in')) {
              //类型  好文或商品
            $type = $this->input->get("type");
            //好文ID或商品ID
            $communal = $this->input->get("id");
            //上线ID
            $parent = $this->input->get("parent");
            //分享时间
            $time = $this->input->get("time");
            $mark = $this->input->get("mark");
            $shopid = $this->input->get("shopid");
            $enctpye = $this->input->get("enctpye");
            $back_url = current_url().'?';
            
            if($enctpye){
                $this->session->set_userdata("enctpye",$enctpye);//
            }
            if(!empty($mark)){
                $back_url .='mark='.$mark;
                    $shop = $this->shop->load(base64_decode($parent));
                    if(!$shop){
                        $h_url = site_url("Home");
                        redirect($h_url);
                        //该上线不是互助店用户，
                    }
                    $this->session->set_userdata("inviteid",base64_decode($parent));//
                    
                    //获取上线的站点赋给下线
                    $url = $this->url_prefix.'Customer/load?';
                    $data['customer_id'] = base64_decode($parent);
                    $_customer = json_decode($this->curl_post_result($url,$data),true);
                    $this->session->set_userdata("inviteid_appid",$_customer['app_id']);//
                    if(base64_decode($mark) == 5 ){//区分二维码跟其它分享
                        $this->session->set_userdata("inviteid_type","code");
                    }else{
                        $this->session->set_userdata("inviteid_type","shop");
                    }
            }
            
            
            
            if(!empty($type)){
                $back_url .='&type='.$type;
            }
            if(!empty($communal)){
                $back_url .='&id='.$communal;
            }
            if(!empty($parent)){
                $back_url .='&parent='.$parent;
            }
            if(!empty($time)){
                $back_url .='&time='.$time;
            }
            if(!empty($enctpye)){
                $back_url .='&enctpye='.$enctpye;
            }
            $this->session->set_userdata('ref_from_url', $back_url);
            redirect('customer/login');
            exit();
        }
    }
    
    
    public function index()
    {
        $user_id = $this->session->userdata ( 'user_id' );
        $shop = $this->shop->load($user_id);
        $enctpye = $this->session->userdata ( 'enctpye' );
        if($shop){
            if(!$shop['status']){//审核中
                redirect('shop/check_shop');exit;
            }else{//已审核
                if($enctpye){
                    redirect('shop/infoh5');exit;
                }else{
                    redirect('shop/info');exit;
                }
               
            }
        }
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'mutual_assistance/essay_shop',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
      
    }
    
    public function check_shop(){
        $enctpye = $this->session->userdata ( 'enctpye' );
        $user_id = $this->session->userdata ( 'user_id' );
        $shop = $this->shop->load($user_id);
        if($shop['status']){
            if($enctpye){
                redirect('shop/infoh5');exit;
            }else{
                redirect('shop/info');exit;
            }
            
        }
        
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'mutual_assistance/essay_dredge',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    public function infoh5(){

        $app_id = $this->session->userdata('app_info')['id'];
        
        $shop_id = base64_decode($this->input->get('shopid'));
        $order = $this->input->get_post("order");
       
        //获取分类
        $this->load->model('category_mdl');
        $this->load->model('goods_mdl', 'goods');
        $_cate_id = $this->input->get_post('cate_id');
        $isparent = $this->input->get_post('isparent');
       
        if($order || $_cate_id){
            $shop_id = $this->session->userdata("shopid");
            $shop = $this->shop->shop_load($shop_id);
        }else{
            if($shop_id){
                //分享
                $shop = $this->shop->shop_load($shop_id);
                if(!$shop){
                    show_404();
                }
                $this->session->set_userdata("shopid",$shop_id);
            }else{
                $user_id = $this->session->userdata ( 'user_id' );
                $shop = $this->shop->load($user_id);
                $this->session->set_userdata("shopid",$shop['id']);
                if(!$shop){
                    redirect('shop');exit;
                }
                $data['parent'] = base64_encode($user_id);
            }
        }
        
        $data["order"] = $order;
         
        if(base64_encode(base64_decode($_cate_id)) == $_cate_id && !is_numeric($_cate_id)){
            $cate_id = unserialize(base64_decode($_cate_id));
             
        }
        else{
            $cate_id = $_cate_id;
        
        }
       
        if(empty($_cate_id)){
            $cate_id = '';
        }
        // 取子分类1
        if ($cate_id != 0 && $cate_id != "0") {
            $cate_ids = explode(',', $cate_id);
        } else {
            $cate_ids = 0;
        }
     
    
      
        $cate_idlist = array();
        if ($isparent != 0 && $isparent != "0") {
            foreach ($cate_ids as $s) {
                 
                $catelist = $this->category_mdl->get_childcatbyparent($s);
                 
                foreach ($catelist as $cate) {
                    array_push($cate_idlist, $cate["id"]);
                }
            }
        } else {
             
            $cate_idlist = $cate_ids;
        }
        
         
        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        $options = array();
        //店铺预览无关键字搜索
        //$options['keywords'] = '';
        
        
        // 没有输入order
        if ($data["order"] == null || $data["order"] == "") {
            $data["type"] ='all';
        } else {
            $options["order"] = $data["order"];
            $data["type"] =$data["order"];
        }
        
        //无刷新加载数据
        if($is_ajax){
            $page = $this->input->get_post('page');
            $pagesize  = 6;
            $page   = ($page - 1 ) * $pagesize;
        }else{
            $data["pagesize"] = 6;
            $data["page"] = 0;
        }
       
        if($is_ajax){
            $data['produtList'] = $this->goods->get_shop_pro_lists($pagesize,$page,$cate_idlist,  $options, 'p.id,p.name,p.short_name,p.sequence,vip_price,price,m_price,goods_thumb,short_desc',$app_id,$shop['id']);
            foreach ($data['produtList'] as $key =>$val){
                $data['produtList'][$key]['int_price'] = substr_replace($val['vip_price'], '', strpos($val['vip_price'], '.'));
                $data['produtList'][$key]['dec_price'] =  substr($val['vip_price'], -2);
            }
            echo json_encode($data);
            exit;
        }else{
            $data['produtList'] = $this->goods->get_shop_pro_lists($data["pagesize"],  $data["page"], $cate_idlist,  $options, 'p.id,p.name,p.short_name,p.sequence,vip_price,price,m_price,goods_thumb,short_desc',$app_id,$shop['id']);
            foreach ($data['produtList'] as $key =>$val){
                $data['produtList'][$key]['int_price'] = substr_replace($val['vip_price'], '', strpos($val['vip_price'], '.'));
                $data['produtList'][$key]['dec_price'] =  substr($val['vip_price'], -2);
            }
        }
        //互助店信息
        $data['shop'] = $shop;
         
        //获取分类名称
        $this->load->model('product_cat_mdl');
        $classify  = $this->product_cat_mdl->getSectionList();
        $data['classify'] = $classify['data'];
        
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        $this->load->view ( 'head',$data);
//         $this->load->view ( '_header',$data );
        $this->load->view ( 'mutual_assistance/essay_preview_h5',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
        
        
    }
    public function  info(){
        $shop_id = base64_decode($this->input->get('shopid'));
        if($shop_id){
            //分享
            $shop = $this->shop->shop_load($shop_id);
            if(!$shop){
                show_404();
            }
        }else{
            $user_id = $this->session->userdata ( 'user_id' );
            $shop = $this->shop->load($user_id);
            if(!$shop){
                redirect('shop');exit;
            }
            $data['parent'] = base64_encode($user_id);
        }
        //互助店信息
        $data['shop'] = $shop;
       
        //获取分类名称
        $this->load->model('product_cat_mdl');
        $classify  = $this->product_cat_mdl->getSectionList();
        $data['classify'] = $classify['data'];
        
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'mutual_assistance/essay_preview',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
        
    }
    //异步加载互助店商品
    public function ajax_shop_pro_list(){
        $app_id = $this->session->userdata('app_info')['id'];
        //获取分类
        $this->load->model('category_mdl');
        $this->load->model('goods_mdl', 'goods');
        $_cate_id = $this->input->get_post('cate_id');
        $isparent = $this->input->get_post('isparent');
        $shopid = $this->input->get_post('shopid');
        $order = $this->input->get_post("order");
        
        if(base64_encode(base64_decode($_cate_id)) == $_cate_id && !is_numeric($_cate_id)){
            $cate_id = unserialize(base64_decode($_cate_id));
        }
        else{
            $cate_id = $_cate_id;
        
        }
         
        if(empty($_cate_id)){
            $cate_id = '';
        }
        // 取子分类1
        if ($cate_id != 0 && $cate_id != "0") {
            $cate_ids = explode(',', $cate_id);
        } else {
            $cate_ids = 0;
        }
         
        $cate_idlist = array();
        if ($isparent != 0 && $isparent != "0" && is_array($cate_ids)) {
            foreach ($cate_ids as $s) {
                 
                $catelist = $this->category_mdl->get_childcatbyparent($s);
                foreach ($catelist as $cate) {
                    array_push($cate_idlist, $cate["id"]);
                }
            }
        } else {
             
            $cate_idlist = $cate_ids;
        }
        $options = array();
        //店铺预览无关键字搜索
        //$options['keywords'] = '';
        
        
        // 没有输入order
        if ($order == null || $order == "") {
        } else {
            $options["order"] = $order;
        }
        
        //无刷新加载数据
     
        $page = $this->input->get_post('page');
        $pagesize  = $this->input->get_post('limit');
        $pagesize = 6;
        if($page == 1){
            $page = 0;
        }else{
            $page   = ($page - 1 ) * $pagesize;
            }
        
             
        
        $data['produtList'] = $this->goods->get_shop_pro_lists($pagesize, $page, $cate_idlist,  $options, 'p.id,p.name,p.short_name,p.sequence,vip_price,price,m_price,goods_thumb,short_desc',$app_id,$shopid);
        foreach ($data['produtList'] as $key =>$val){
            $data['produtList'][$key]['int_price'] = substr_replace($val['vip_price'], '', strpos($val['vip_price'], '.'));
            $data['produtList'][$key]['dec_price'] =  substr($val['vip_price'], -2);
        }
        echo json_encode($data);
    }
    //下载APP
    public function download(){
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(strpos($agent , 'android')){
            //android
            $download_link = 'http://app.qq.com/#id=detail&appid=1105483007';
        }else{
            //ios
            $download_link = 'itunes.apple.com/cn/app/id1190200919?mt=8';
        }
        
        $data['link'] = $download_link;
        
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'mutual_assistance/shop_download',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
        
    }
    
    public function  skipping(){
        $user_id = $this->session->userdata ( 'user_id' );
      
        $mark = base64_decode($this->input->get("mark"));
        $enctpye = $this->input->get("enctpye");
        if($enctpye){
            $this->session->set_userdata("enctpye",$enctpye);//
        }
        //5二维码  2好文  3商品  4店铺
        if(!in_array($mark, array(5,2,3,4))){
            show_404();//链接非法
        }
       
        if($mark == 2){
            if(empty($user_id)){
                redirect('customer/login');exit;
            }
        }
        //类型  好文或商品
        $type = base64_decode($this->input->get("type"));
        //好文ID或商品ID
        $communal = base64_decode($this->input->get("id"));
        //上线ID
        $parent = base64_decode($this->input->get("parent"));
        
        //分享时间
        $time = base64_decode($this->input->get("time"));
       
        $shop = $this->shop->load($parent);
        if(!$shop){
            //该上线不是互助店用户，
            $h_url = site_url("Home");
            redirect($h_url);
          
        }
     
        //二维码 
        if($mark == 5){
            
            //二维码间上线ID更新
            if(!empty($user_id)){//已登录已注册
                $userinfo = $this->Customer_mdl->load($user_id);
                //判断is_active是否为0
                if(!$userinfo['is_active']){
                    //更新上线ID信息
                    $this->Customer_mdl->update_parent($user_id,$parent);
                }else{
                    //is_active为1
                    if($userinfo['parent_id'] == 0){//没有上线ID
                        //更新上线ID信息
                        $this->Customer_mdl->update_parent($user_id,$parent);
                    }
                }
                
                redirect('Member/info');//个人中心
                exit;
            }
            //未注册 ，正常逻辑跳去绑定手机注册
            $url = site_url('Customer/registration').'?id='.$parent;
            redirect($url);exit;
        }
        //店铺
        if($mark == 4){
            
            if($parent == $user_id ){//自己浏览互助店
                $url = site_url('shop');
                redirect($url);exit;
            }
            $userinfo = $this->Customer_mdl->load($user_id);
            if(!$userinfo['change_parent']){
                //判断is_active是否为0
                if(!$userinfo['parent_id']){
                    //更新上线ID信息
                    $this->Customer_mdl->update_parent($user_id,$parent);
                }
            }
            $url = site_url('shop/infoh5').'?shopid='.base64_encode($shop['id']);
            redirect($url);exit;
        }
        
        //2好文  3商品
        if($mark==2 || $mark==3 ){
            //没有好文ID或商品ID  类型  好文或商品
            if(!$type || !$communal){
                show_404();//链接非法
            }
         
            //先检查用户是否已阅读
            $aff =  $this->article_mdl->check_read($type,$communal);
            
            //$user_id 等于 $parent  互助店主自己阅读，不能算 分享出去被人阅读
            if($user_id == $parent){
              
                $parent = 0;  //没人分享给自己看
                //自己阅读不需要判断分享时间$time
                //没有阅读
                if(!$aff){
                    //记录阅读
                    $this->article_mdl->add_read($parent,$type,$communal,$time);
                }
                
                if($mark == 2){//好文
                    $url = site_url('Article/detail').'?parent='.base64_encode($user_id).'&communal='.base64_encode($communal);
                    redirect($url);
                }else{//商品
                    $shop = $this->shop->load($user_id);
                    $pro_info = $this->shop->check_product_ById($shop['id'],$communal);
                    $url = site_url('Goods/detail').'/'.$pro_info['product_id'];
                  
                    redirect($url);
                }
            
            }else{
                //判断是否存在上线用户信息
                $parent_customer = $this->Customer_mdl->load($parent);
                $sharetime = strtotime($time);
                if(!$sharetime){//判断分享时间
                    show_404();//链接非法
                }
                
                if(!$parent_customer){//不存在上线用户信息
//                    show_404();
                    //链接非法
                    $h_url = site_url("Home");
                    redirect($h_url);
                }
                //没有阅读
                if(!$aff){
                    //记录阅读
                    $this->article_mdl->add_read($parent,$type,$communal,$time);
                }
               
                //分享阅读
                if($user_id != $parent){
                    //获取当前用户信息
                    $_customer = $this->Customer_mdl->load($user_id);
                    if(!$_customer['change_parent']){
                        //判断is_active是否为0
                        if(!$_customer['parent_id']){
                            //更新上线ID信息
                            $this->Customer_mdl->update_parent($user_id,$parent);
                        }
                       
                    }
                }
                
                if($mark == 2){//好文
                    
                    $url = site_url('Article/detail').'?parent='.base64_encode($parent).'&communal='.base64_encode($communal);
                    redirect($url);
                }else{//商品
                    $shop = $this->shop->load($parent);
                    $pro_info = $this->shop->check_product_ById($shop['id'],$communal);
                    $url = site_url('Goods/detail').'/'.$pro_info['product_id'];
                    redirect($url);
                }
            
            }
        }
        
        
        
    }
    
    
}