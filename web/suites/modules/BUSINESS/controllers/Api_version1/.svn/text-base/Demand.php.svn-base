<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Demand extends Api_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('demand_mdl');
        $this->load->model('customer_mdl');
        $this->load->model('customer_address_mdl');
        //需求过期后自动变下架
        //$this->demand_mdl->update_reqirements();
        
    }   
    
    public function index()
    {
        echo 'Demand API';
    }
    
    
    
   /**
	 * 获取需求信息
	 * @param int $status 全部＝null，待审核＝1，通过＝2，不通过＝3，下架＝4
	 * @param string $select
	 * @param $keyword 关键词(标签)
	 */
    
    public function getRequirementList(){
         
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
        $user_id = $this->session->userdata("user_id");
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        //需求过期后自动变下架
        $this->demand_mdl->update_reqirements();
        
     
        $app_id = $this->session->userdata("app_info")["id"];
        //关键词搜索
        $keyword = isset($prams['keyword'])?$prams['keyword']:'';
        
        
        //排序
        $orderBy = isset($prams['orderBy'])?$prams['orderBy']:'';
        $options['orderBy'] = $orderBy;
        $options['keyword'] = $keyword;
        if($keyword){
            //搜索记录记录到数据库
            $info['customer_id'] = $this->session->userdata('user_id');
            $info['keyword'] = $keyword;
            $info['type'] = 'keyword';
            $this->demand_mdl->add_demand_history($info);
            
            //关键字搜索写进session
            if (!empty($history = $this->session->userdata('demand_history'))){
                /* 记录浏览历史 */
                $exist = false;
                foreach ($history as $key ){
                    if($key == $keyword){
                        $exist = true;
                    }
                }
                if(!$exist){
                    array_push($history, $keyword);
                }
                $this->session->set_userdata('demand_history',$history);
            }else{
                $history = array();
                array_push($history, $keyword);
                $this->session->set_userdata('demand_history',$history);
            }
        }
        $return['data']['cate_name'] ='';
         //分类精确搜索
        $cateid  =isset($prams['cateid'])?$prams['cateid']:"";
        $options['cate'] = $cateid;
        if($cateid){
            $cate_info = $this->demand_mdl->get_classify_name($cateid);
            $classify = $this->demand_mdl->get_son_classify($cateid,$cate_info['level']);
            if(!empty($classify) && count($classify) > 0){
                $options['cate'] = $classify;
            }else{
                $options['cate'] = $cateid;
            }
            
            $classify  = $this->demand_mdl->get_classify_name($cateid);
            //记录进搜索历史
            $historys = $this->session->userdata("cate_history");
            if(empty($historys)){
                //第一次
                $indo['0'] = $classify;
                $this->session->set_userdata("cate_history",$indo);
            
                //搜索记录记录到数据库
                $info['customer_id'] = $this->session->userdata('user_id');
                $info['cate_id'] = $cateid;
                $info['type'] = 'cate';
                $this->demand_mdl->add_demand_history($info);
            }else{
                //不是第一次
                $status = false;
                foreach ($historys as $key =>$val){
                    if($val['id'] == $cateid){
                        $status = true;
                    }
                }
                if(!$status){
                    array_push($historys, $classify);
                    $this->session->set_userdata("cate_history",$historys);
                    //搜索记录记录到数据库
                    $info['customer_id'] = $this->session->userdata('user_id');
                    $info['cate_id'] = $cateid;
                    $info['type'] = 'cate';
                    $this->demand_mdl->add_demand_history($info);
                }
            }
            
            $return['data']['cate_name'] =$classify['name'];
        }
        //分站点
        $options['app_id'] = $this->session->userdata("app_info")["id"];
    
        $totalcount = count($this->demand_mdl->get_count_with_condition($options)); // 获取总记录数
         
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
    
        $list = array();
        //获取信息列表
        $listdate = $this->demand_mdl->get_lists_for_search($options,$perPage, $offset);
       
       
         
        // 返回数据
//         $return['data']['app_id'] = $app_id;
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $listdate;
         
        print_r(json_encode($return));
    }
    
    /**
     * 获取搜索历史
     */
    public function get_history(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $return['data']['keyword_history'] =  $this->session->userdata('demand_history');
        $return['data']['cate_history'] = $this->session->userdata('cate_history');
        print_r(json_encode($return));
    }
    
    /**
     * 删除搜索历史
     */
    public function del_history(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams,array('type'));
        
        $type = $prams['type'];
        if($type == 'keyword'){
            unset($_SESSION['demand_history']);
        }
        if($type == 'cate'){
            unset($_SESSION['cate_history']);
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取我的需求信息
     * 
     */
    public function getMyRequirements(){
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
        
        $user_id = $this->session->userdata("user_id");
        $app_id = $this->session->userdata("app_info")["id"];
        $_customer = $this->customer_mdl->load($user_id);
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        //需求过期后自动变下架
        $this->demand_mdl->update_reqirements();
        
        $options['app_id'] =$app_id;
        $options['type'] = isset($prams['type'])?$prams['type']:0;//0全部1抢单(上架)中2审核通过3审核中4审核失败5删除
        
        $totalcount = $this->demand_mdl->getRequirementCountsByid($user_id,$options); // 获取总记录数
       
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        //条件获取
        $lists = $this->demand_mdl->getRequirementByid($user_id,$options,$perPage,$offset);
        $list= array();
        foreach ($lists as $k =>$v){
              
                   $list[$k]['id'] = $v['id'];
                   $list[$k]['title'] = $v['title'];
                   $list[$k]['create_at'] = $v['create_at'];
                   $list[$k]['img_path'] = $v['img_path'];
                   $list[$k]['total'] =$v['total'];
                   $list[$k]['days'] =$v['total'];
                   
                   switch ($v['ispublish']){
                       case 1:
                           $list[$k]['status']['type'] =2;
                           $list[$k]['status']['ispublish'] =1;
                           $list[$k]['status']['is_putaway'] =0;
                           $list[$k]['status']['name'] ='审核中';
                           break;
                       case 2:case 4:
                           if($v['is_putaway'] ==1){
                               $list[$k]['status']['type'] =1;
                               $list[$k]['status']['ispublish'] =2;
                               $list[$k]['status']['is_putaway'] =1;
                               $list[$k]['status']['name'] ='抢单中';
                           }else{
                               $list[$k]['status']['type'] =1;
                               $list[$k]['status']['ispublish'] =2;
                               $list[$k]['status']['is_putaway'] =0;
                               $list[$k]['status']['name'] ='审核通过';
                           }
                           break;
                       case 3:
                           $list[$k]['status']['type'] =3;
                           $list[$k]['status']['ispublish'] =3;
                           $list[$k]['status']['is_putaway'] =0;
                           $list[$k]['status']['name'] ='审核不通过';
                           break;
                       case 5:
                           $list[$k]['status']['type'] =4;
                           $list[$k]['status']['ispublish'] =5;
                           $list[$k]['status']['is_putaway'] =0;
                           $list[$k]['status']['name'] ='已删除';
                           break;
                   }
                   
        }
            
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $list;
        $return['data']['app_id'] = $app_id;
       
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取我的报价信息
     *
     */
    public function getMyBarter(){
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
        
        $user_id = $this->session->userdata("user_id");
        $app_id = $this->session->userdata("app_info")["id"];
        $_customer = $this->customer_mdl->load($user_id);
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $options['app_id'] =$app_id;
        //获取我的报价数量
        $totalcount = $this->demand_mdl->getBarterCountsByid($user_id,$options); // 获取总记录数
       
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $list = $this->demand_mdl->getBarterByid($user_id,$options,$perPage,$offset);
      
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $list;
        $return['data']['app_id'] = $app_id;
       
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取单条需求信息
     *
     */
    public function getRequirementByid(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams,array('id'));
        $user_id = $this->session->userdata("user_id");
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $id = $prams['id'];
        $lists  = $this->demand_mdl->getrequirByid($id);
        
      
        $_customer = $this->customer_mdl->load($lists['create_by']);
        $app_id = $this->session->userdata("app_info")["id"];
        
        
        //查询当前需信息用户之前是否已经报价
        $options['app_id'] = $app_id;
        $barters  = $this->demand_mdl->getBartersByRid($id,$options);
      
        $cus_id = array();
        foreach ($barters as $k=>$v){
            $cus_id[$k] = $v['customer_id'];
        }
     
        $list= array();
        //该需求用户不曾报价过
        $list['quote'] = 0;
        if(in_array($user_id,$cus_id)){
            foreach ($barters as $k1 => $v1){
                if($v1['customer_id']==$user_id){
                    //该需求用户已经报价过
                    $list['quote'] = $v1['id'];
                }
            }
        }
     
        $list['title'] = $lists['title'];
        $list['contactuser'] = $lists['contactuser'];
        $list['p_count'] = $lists['p_count'];
        $list['m_price'] = $lists['m_price'];
        $list['total_price'] = $lists['total_price'];
        $list['total'] = $lists['total'];
//         $list['receiptdate'] = substr ( $lists['receiptdate'], 0,10);
        $list['receiptdate'] =  $lists['receiptdate'];
        $list['create_by'] = $lists['create_by'];
        $list['effectdate'] = $lists['effectdate'];
        $list['img_path'] = $lists['img_path'];
        $list['needtax'] = $lists['needtax'];
        $list['freight'] = $lists['freight'];
        $list['unit'] = $lists['unit'];
        $list['province'] = $this->demand_mdl->get_name($lists['province_id']);
        $list['city'] = $this->demand_mdl->get_name($lists['city_id']);
        $list['district'] = $this->demand_mdl->get_name($lists['district_id']);
        $list['shippingaddress'] = $lists['shippingaddress'];
        
        $list['new_address'] = $list['province']['region_name'].'省'.$list['city']['region_name'].'市'.$list['district']['region_name'].$lists['shippingaddress'];
        
        $list['corporation'] = empty($this->demand_mdl->getCorporName($lists['create_by']))? "":$this->demand_mdl->getCorporName($lists['create_by'])['corporation_name'];
        
        //运营要求先隐藏
//         $list['corporation'] = '';
//         $list['contactuser'] = '';
        //分类id获取组装处理
        
        //处理分类
        $catelist = $this->demand_mdl->get_classify_name($lists['cate_id']);
        $list['cate_id'] =  $lists['cate_id'];
        $list['cate'] =  $catelist['name'];
        switch ($lists['ispublish']){
            case 1:
                $list['status']['type'] =2;
                $list['status']['ispublish'] =1;
                $list['status']['is_putaway'] =0;
                $list['status']['name'] ='审核中';
                break;
            case 2:
                if($lists['is_putaway'] ==1){
                    $list['status']['type'] =1;
                    $list['status']['ispublish'] =2;
                    $list['status']['is_putaway'] =1;
                    $list['status']['name'] ='抢单中';
                }else{
                    $list['status']['type'] =1;
                    $list['status']['ispublish'] =2;
                    $list['status']['is_putaway'] =0;
                    $list['status']['name'] ='审核通过';
                }
                break;
            case 3:
                $list['status']['type'] =3;
                $list['status']['ispublish'] =3;
                $list['status']['is_putaway'] =0;
                $list['status']['name'] ='审核不通过';
                break;
            case 5:
                $list['status']['type'] =4;
                $list['status']['ispublish'] =5;
                $list['status']['is_putaway'] =0;
                $list['status']['name'] ='已删除';
                break;
        }
        
        $return['data'] = $list;
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取单条报价信息
     *
     */
    public function getBarterByid(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams,array('id'));
        $user_id = $this->session->userdata("user_id");
        $_customer = $this->customer_mdl->load($user_id);
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $id = $prams['id'];
        //获取报价信息
        $lists  = $this->demand_mdl->getbartByid($id);
        $Msg = $this->demand_mdl->getCorporName($user_id);
        //获取单位
        $req = $this->demand_mdl->getrequirByid($lists['requirement_id']);
        $list= array();
        if($Msg){
            $list['real_name'] = $Msg['contact_name'];
            $list['mobile'] = $Msg['mobile'];
            $list['contactuser'] = $Msg['contact_name'];
            $list['email'] = $Msg['email'];
        }else{
            $list['real_name'] = $_customer['real_name']? $_customer['real_name']:$_customer['nick_name'];
            $list['mobile'] = $_customer['mobile'];
            $list['contactuser'] = $_customer['real_name']? $_customer['real_name']:$_customer['nick_name'];
            $list['email'] = $_customer['email'];
        }
        
        $list['remark'] = isset($lists['remark'])? $lists['remark']:"";
        $list['unit'] = $req['unit'];
        $list['days'] =  isset($lists['days'])? $lists['days']:"";
        $list['needtax'] =$lists['needtax'];
        $list['freight'] =$lists['freight'];
      
        $list['offer'] =  $lists['price'];
        $list['accessory_url'] = isset($lists['accessory_url'])? $lists['accessory_url']:'';
        $list['corporation'] = empty($this->demand_mdl->getCorporName($lists['customer_id']))? "":$this->demand_mdl->getCorporName($lists['customer_id'])['corporation_name'];
        
        $return['data'] = $list;
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取多条报价信息
     *
     */
    
    public function getBartersByid(){
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
        $this->_check_prams($prams,array('id'));
        $app_id = $this->session->userdata("app_info")["id"];
        $user_id = $this->session->userdata("user_id");
        $_customer = $this->customer_mdl->load($user_id);
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $id = $prams['id'];
        $options['app_id'] =$app_id;
        $totalcount = $this->demand_mdl->getOffererTotal($id,$options);
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        //获取单位
        $req = $this->demand_mdl->getrequirByid($id);
      
        $list =  $this->demand_mdl->getBartersByRid($id,$options,$perPage, $offset);
        foreach ($list as $k =>$v){
            //报价人的公司名称
            $Msg = $this->demand_mdl->getCorporName($v['customer_id']);
            $list[$k]['offer'] = $v['price'];
           
            if($Msg){
                $list[$k]['corporation'] = $Msg['corporation_name'] ? $Msg['corporation_name']:'';
                $list[$k]['contactuser'] = $Msg['contact_name'];
                $list[$k]['mobile'] = isset($Msg['mobile'])?$Msg['mobile']:'';
                $list[$k]['email'] = isset($Msg['email'])?$Msg['email']:'';
                $list[$k]['real_name'] =$Msg['contact_name'];
            }else{
                $_customers = $this->customer_mdl->load($v['customer_id']);
                $list[$k]['email'] = isset($_customers['email'])?$_customers['email']:'';
                $list[$k]['real_name'] = $_customers['real_name']? $_customers['real_name']:$_customers['nick_name'];
                $list[$k]['mobile'] = $_customers['mobile'];
                $list[$k]['contactuser'] = $_customers['real_name']? $_customers['real_name']:$_customers['nick_name'];
                $list[$k]['corporation'] = '';
            }
            $list[$k]['unit'] =$req['unit'];
            unset($list[$k]['tax_freight']);
        }
        
       
        ///返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['unit'] = $req['unit'];
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $list;
        $return['data']['app_id'] = $app_id;
       
        print_r(json_encode($return));
        
    }
    
    /**
     * 获取顶级分类
     *
     */
    public function getTopLevels(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
         
        $Levels = $this->demand_mdl->get_classify(0);
        foreach ($Levels as $k => $v){
            $return['data'][$k]['cateid'] = $v['id'];
            $return['data'][$k]['name'] = $v['name'];
            $return['data'][$k]['level'] = $v['level'];
            $arrays = $this->demand_mdl->get_son_classify($v['id'],$v['level']);
            if(count($arrays)>0){
                $return['data'][$k]['child'] = true;
            }else{
                $return['data'][$k]['child'] = false;
            }
        }
      
        print_r(json_encode($return));
    }
     
    
   /**
    * 获取单位
    */
    function get_unit(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $return['data']['unit'] = array("千克","斤","件","吨","包","份","箱","栋","套");
        print_r(json_encode($return));
    }
    /**
     * 获取下级分类
     */
    public function getNextLevels(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
         
        // 检验参数
        $this->_check_prams($prams,array('cateid','level'));
        $parentid = $prams['cateid'];
        $level =  $prams['level'];
        $type =  isset($prams['type'])? $prams['type']:false;
        if($type){
            $Levels = $this->demand_mdl->get_son_classify($parentid,$level,$type);
        }else{
            $Levels = $this->demand_mdl->get_son_classify($parentid,$level);
        }
       
        
        foreach ($Levels as $k => $v){
            $return['data'][$k]['cateid'] = $v['id'];
            $return['data'][$k]['name'] = $v['name'];
            $return['data'][$k]['level'] = $v['level'];
            $arrays = $this->demand_mdl->get_son_classify($v['id'],$v['level']);
            if(count($arrays)>0){
                $return['data'][$k]['child'] = true;
            }else{
                $return['data'][$k]['child'] = false;
            }
           
        }
       
        print_r(json_encode($return));
    }
    
   
   
    
    /**
     * 
     * 需求上架下架
     */
    public function putRequirement(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams,array(
            'requirement_id',
            'status'
            
        ));
        $user_id = $this->session->userdata("user_id");
        $app_id = $this->session->userdata("app_info")["id"];
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        //分站点
        $options['app_id'] = $this->session->userdata("app_info")["id"];
        $options['type'] = 0;
        $requirement_id = $prams['requirement_id'];
        $idlist = $this->demand_mdl->getRequirementByid($user_id,$options);
        $exist = false;
        foreach ($idlist as $k =>$v){
            if($requirement_id ==$v['id']){
                $exist = true;
            }
        }
        if($exist == false){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '操作失败，需求信息不对应'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $status = $prams['status'];
        $effect = $this->demand_mdl->putRequirement($requirement_id,$status);
        
        if($effect){
            if($status){
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '',
                    'errorMessage' => '上架成功'
                );
                print_r(json_encode($return));
                exit();
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '',
                    'errorMessage' => '下架成功'
                );
                print_r(json_encode($return));
                exit();
            }
        }else{
            if($status){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '2',
                    'errorMessage' => '上架失败'
                );
                print_r(json_encode($return));
                exit();
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '2',
                    'errorMessage' => '下架失败'
                );
                print_r(json_encode($return));
                exit();
            }
        }
        
    }
    
    
    
    
    
    /**
     * 发布需求
     * 
     */
    public function addrequirement(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams,array(
            'title',
            'cateid',
            'p_count',
            'm_price',
            'unit',
            'effectdate',
            'receiptdate',
            'province_id',
            'city_id',
            'district_id',
            'shippingaddress',
            
        ));
        $user_id = $this->session->userdata("user_id");
      
      
        $_customer = $this->customer_mdl->load($user_id);
        $app_id = $this->session->userdata("app_info")["id"];
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $this->demand_mdl->app_id = $app_id;
        $this->demand_mdl->title = $prams['title'];
        $this->load->model('Customer_corporation_mdl');
        $corp = $this->Customer_corporation_mdl->load($user_id);
        if($corp){
            $this->demand_mdl->contactuser = $corp['contact_name'];
            $this->demand_mdl->contactphone = $corp['contact_mobile'];
        }else{
             $this->demand_mdl->contactuser = $_customer['real_name']? $_customer['real_name']:$_customer['nick_name'];
             $this->demand_mdl->contactphone =$_customer['mobile'] ;
        }
       
        $this->demand_mdl->cate_id = $prams['cateid'];
        $this->demand_mdl->p_count = $prams['p_count'];
        $this->demand_mdl->m_price = $prams['m_price'];
        $this->demand_mdl->unit = $prams['unit'];
        
        $time =date('H:i:s');
        $receiptdate = $prams['receiptdate'];
        $effectdate = $prams['effectdate'];
        $this->demand_mdl->effectdate = $effectdate.' '.$time;
        $this->demand_mdl->receiptdate = $receiptdate.' '.$time;
        
        $this->demand_mdl->province_id = $prams['province_id'];
        $this->demand_mdl->city_id = $prams['city_id'];
        $this->demand_mdl->district_id = $prams['district_id'];
        $this->demand_mdl->shippingaddress = $prams['shippingaddress'];
      
        $this->demand_mdl->needtax = $prams['needtax'];
        $this->demand_mdl->freight = $prams['freight'];
      
        //--------图片----------
        $this->load->library('upload');
        $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file_path = FCPATH.UPLOAD_PATH.$save_path;
        //判断路径存在，不存在就创建
        if (! file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        
        $config['upload_path'] = $file_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2097152';
        $config['file_name'] = $this->session->userdata('user_id') . '_' . date("YmdHis");
        
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploaded = $this->upload->data();
            $img_path = $save_path . $uploaded['file_name'];
        
        } else {
            $img_path = '';
        }
        $this->demand_mdl->img_path = $img_path;
        //--------图片----------
        
        $id = $this->demand_mdl->add_demand();
        if(!$id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '需求发布失败，请重新发布！'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '',
            'errorMessage' => '需求发布成功！'
        );
        print_r(json_encode($return));
    }
    /**
     * 更新需求信息
     */
    public function updaterequirement(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams,array(
            'requirement_id',
            'title',
            'cateid',
            'p_count',
            'm_price',
            'unit',
            'effectdate',
            'receiptdate',
            'province_id',
            'city_id',
            'district_id',
            'shippingaddress',
            
        ));
        $user_id = $this->session->userdata("user_id");
        $_customer = $this->customer_mdl->load($user_id);
        $app_id = $this->session->userdata("app_info")["id"];
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        //分站点
        $options['app_id'] = $app_id;
        $options['type'] = 0;
        $requirement_id = $prams['requirement_id'];
        $idlist = $this->demand_mdl->getRequirementByid($user_id,$options);
        $exist = false;
        foreach ($idlist as $k =>$v){
            if($requirement_id ==$v['id']){
                $exist = true;
            }
        }
        if($exist == false){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '操作失败，需求信息不对应'
            );
            print_r(json_encode($return));
            exit();
        }
        $thislist =  $this->demand_mdl->getrequirByid($requirement_id);
        if($thislist['ispublish'] == 2){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '需求已审核通过，无法修改'
            );
            print_r(json_encode($return));
            exit();
        }
        $data['app_id'] = $app_id;
        $data['title'] = $prams['title'];
        $data['contactphone'] = $_customer['mobile'];
        $data['cate_id'] = $prams['cateid'];
        $data['p_count'] = $prams['p_count'];
        $data['m_price'] = $prams['m_price'];
        $data['total_price'] = round($prams['p_count']* $prams['m_price'],2);
        $data['unit'] = $prams['unit'];
        $time =date('H:i:s');
        $receiptdate = $prams['receiptdate'];
        $effectdate = $prams['effectdate'];
        $data['effectdate'] = $effectdate.' '.$time;
        $data['receiptdate'] = $receiptdate.' '.$time;
        $data['province_id'] = $prams['province_id'];
        $data['city_id'] = $prams['city_id'];
        $data['district_id'] = $prams['district_id'];
        $data['shippingaddress'] = $prams['shippingaddress'];
        $data['update_at'] = date('Y-m-d H:i:s');
        $data['update_by'] = $user_id;
        $data['ispublish'] = 1;//需求状态改回审核中
        
        //处理是否判断上传图片流是否存在默认存在(安卓特殊处理)
        $img_upload = isset($prams['img_upload']) ? $prams['img_upload']:true;//默认处理图片流
        
        if($img_upload){
            //--------图片----------
            $this->load->library('upload');
            $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $file_path = FCPATH.UPLOAD_PATH.$save_path;
            //判断路径存在，不存在就创建
            if (! file_exists($file_path)) {
                mkdir($file_path, 0777, true);
            }
            $config['upload_path'] = $file_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2097152';
            $config['file_name'] = $this->session->userdata('user_id') . '_' . date("YmdHis");
            
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) {
                $uploaded = $this->upload->data();
                $data['img_path'] = $save_path . $uploaded['file_name'];
            
            }
            //--------图片----------
        }
        if(isset($prams['needtax'])){
            if($prams['needtax'] == 1 || $prams['needtax'] == 0){
                $data['needtax'] = $prams['needtax'];
            }
        }
        if(isset($prams['freight'])){
            if($prams['freight'] == 1 || $prams['freight'] == 0){
                $data['freight'] = $prams['freight'];
            }
        }
        $status = $this->demand_mdl->updateRequirementByid($requirement_id,$data);
        
        if(!$status){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '更新失败'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '',
            'errorMessage' => '更新成功！'
        );
        print_r(json_encode($return));
        
        
    }
    
    /**
     * 获取省级
     */
    public function getRegionProvince()
    {
        //获取参数
        $prams = $this->p;
        $return = $this->return;
        $return['data']= $this->demand_mdl->getprovince();
        
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取下级区域
     * 
     */
    public function getRegionChild()
    {
        //获取参数
        $prams = $this->p;
        $return = $this->return;
    
        //检验参数
 		$this->_check_prams($prams,array('id'));
 		
        $region_id = $prams['id'];
        $return['data'] = $this->demand_mdl->getchild($region_id);
       
        print_r(json_encode($return));
    }
    
    
    /**
     *添加换货需求信息 
     *
     */
    public function addbarter(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->_check_prams($prams,array(
            'offer',
            'requirement_id',
            'days',
            'offer'
        ));
        $user_id = $this->session->userdata("user_id");
        $app_id = $this->session->userdata("app_info")["id"];
        $_customer = $this->customer_mdl->load($user_id);
        $this->load->model('Customer_corporation_mdl');
        $corp = $this->Customer_corporation_mdl->load($user_id);
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $requirement_id = $prams['requirement_id'];
        $barter['app_id'] = $app_id;
        $req  = $this->demand_mdl->getrequirByid($requirement_id);
        //单价
        $barter['price'] = $prams['offer'];
        //总价
        $barter['offer'] = round($prams['offer']*$req['p_count'], 2);
        $barter['requirement_id'] = $requirement_id;
        $barter['days'] = $prams['days'];
        if($corp){
            $barter['contactuser'] = empty($corp['contact_name'])?$corp['contact_name']:$corp['contact_mobile'];
        }else{
             $barter['contactuser'] = $_customer['real_name']? $_customer['real_name']:$_customer['nick_name'];
        }
        
        $barter['customer_id'] = $user_id;
        $barter['remark'] = empty($prams['remark'])? '':$prams['remark'];
        $barter['needtax'] = empty($prams['needtax'])?0:$prams['needtax'];
        $barter['freight'] = empty($prams['freight'])?0:$prams['freight'];
        //--------图片----------
        $this->load->library('upload');
        $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file_path = FCPATH.UPLOAD_PATH.$save_path;
        //判断路径存在，不存在就创建
        if (! file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        
        $config['upload_path'] = $file_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2097152';
        $config['file_name'] = $this->session->userdata('user_id') . '_' . date("YmdHis");
        
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploaded = $this->upload->data();
            $accessory_url = $save_path . $uploaded['file_name'];
            
        } else {
            $accessory_url = '';
        }
        $barter['accessory_url'] = $accessory_url;
        //--------图片----------
        
        $options['app_id'] = $app_id;
        $options['state'] = 0;
        $barters  = $this->demand_mdl->getBartersByRid($barter['requirement_id'],$options);
        $cus_id = array();
        foreach ($barters as $k=>$v){
            $cus_id[$k] = $v['customer_id'];
        }
         
        if(in_array($user_id,$cus_id)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '你已经报价过该需求了!'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        $id  = $this->demand_mdl->add_barter($barter);
        if(!$id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '报价提交失败，请重新提交！'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '',
            'errorMessage' => '报价提交成功！'
        );
        print_r(json_encode($return));
    }
    /**
     *维护更新报价信息
     *
     */
    public function updatebarter(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->_check_prams($prams,array(
            'barter_id',
            'offer',
            'days'
        ));
        $user_id = $this->session->userdata("user_id");
        $app_id = $this->session->userdata("app_info")["id"];
        $_customer = $this->customer_mdl->load($user_id);
        $barter_id = $prams['barter_id'];
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $options['app_id'] = $app_id;
        $list = $this->demand_mdl->getbarterwithid($user_id,$options);
        
        $exist = false;
        foreach ($list as $k =>$v){
            if($barter_id ==$v['id']){
                $exist = true;
            }
        }
        if($exist == false){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '操作失败，报价信息不对应'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $barterlist = $this->demand_mdl->getbartByid($barter_id);
        if($barterlist['state']){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '报价已审核通过，无法修改'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $barter['app_id'] = $app_id;
        $barter['offer'] = $prams['offer'];
        $barter['days'] = $prams['days'];
        $barter['remark'] = empty($prams['remark'])? $barterlist['remark']:$prams['remark'];
        $barter['accessory_url'] = empty($prams['accessory_url'])?$barterlist['accessory_url']:$prams['accessory_url'];
        if(empty($prams['tax_freight'])){
            //0不含运费和税
            $barter['needtax'] =  $barterlist['needtax'];
            $barter['freight'] =  $barterlist['freight'];
        }else{
            switch ($prams['tax_freight']) {
                case 1:
                    //1含运费
                    $barter['needtax'] = 0;
                    $barter['freight'] = 1;
                    break;
                case 2:
                    //2含税
                    $barter['needtax'] = 1;
                    $barter['freight'] = 0;
                    break;
                case 3:
                    //3含税含运费
                    $barter['needtax'] = 1;
                    $barter['freight'] = 1;
                    break;
            }
        }
        
        $status = $this->demand_mdl->updatebartByid($barter_id,$barter);
        if(!$status){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '更新失败'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '',
            'errorMessage' => '更新成功！'
        );
        print_r(json_encode($return));
    }
    /**
     *单张图片上传
     *
     */  
     public function images_upload()
    {
        $return = $this->return;
    
        $this->load->library('upload');
        $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file_path = FCPATH.UPLOAD_PATH.$save_path;
        //判断路径存在，不存在就创建
        if (! file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        
        $config['upload_path'] = $file_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2097152';
        $config['file_name'] = $this->session->userdata('user_id') . '_' . date("YmdHis");
        
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploaded = $this->upload->data();
            $data['img_path'] = $save_path . $uploaded['file_name'];
            $return['data']['img_path']= $data['img_path'];
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '上传失败'
            );
        }
//         echo $this->upload->display_errors('<p>', '</p>');
//         exit;
        print_r(json_encode($return));
    }
   
    
    /**
     *批量图片上传
     *
     */
    public function images_upload_batch(){
        $return = $this->return;
    
        $this->load->library('upload');
        $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file_path = FCPATH . $save_path;
    
        if (! file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $field = 'file';
        $count=count($_FILES["$field"]["name"]);//页面取的默认名称
    
        $return = array();
        for($i=0;$i<$count;$i++){
            // Give it a name not likely to already exist!
            $pseudo_field_name = '_psuedo_' . $field . '_' . $i;
            $_FILES[$pseudo_field_name] =   array('name' => $_FILES[$field]['name'][$i],
                'size' => $_FILES[$field]['size'][$i],
                'type' => $_FILES[$field]['type'][$i],
                'tmp_name' => $_FILES[$field]['tmp_name'][$i],
                'error' => $_FILES[$field]['error'][$i]
            );
           
    
            $config['upload_path'] = $file_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2097152';
            $config['file_name'] = $this->session->userdata('user_id') . '_' . date("YmdHis");
    
            $this->upload->initialize($config);
            if ($this->upload->do_upload($pseudo_field_name)) {
                $uploaded = $this->upload->data();
    
                $data['img_path'] = $save_path . $uploaded['file_name'];
                $return['data'][] = $data['img_path'];
            } else {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '3',
                    'errorMessage' => '上传失败'
                );
                $return['falsefile'] = $_FILES[$pseudo_field_name];
                break;
            }
        }
        print_r(json_encode($return));
    }
    
}