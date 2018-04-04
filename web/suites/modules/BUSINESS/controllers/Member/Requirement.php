<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Requirement extends Front_Controller {
    public function __construct() {
        parent::__construct ();
        // 判断用户是否登录
        $this->session->set_userdata ( 'ref_from_url', current_url () ); // 统一使用ref_from_url
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit;
        }
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist") ) {
            $customer_id = $this->session->userdata("user_id");
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
    
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        $this->load->model('demand_mdl');
        $this->load->model('product_cat_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('customer_mdl');
        $this->load->model('customer_corporation_mdl');
        
        
    }
    
     
    /**
     * 精选推荐需求列表
     */
    
    public function  index(){
        
        $customer_id = $this->session->userdata('user_id');
        // var_dump($customer_id);
        $data['title'] = '需求信息';
        $data['back'] = 'home';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $cates = $this->input->get('data');

        $this->load->model('requirement_mdl');
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/index', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
    * 全部需求列表
    */
    public function all_demand()
    {
      $customer_id = $this->session->userdata('user_id');
      // var_dump($customer_id);
      $data['title'] = '需求信息';
      $data['back'] = 'home';
      $data['foot_set'] = 1;
      $data['head_set'] = 2;
      $cates = $this->input->get('data');

      $this->load->model('requirement_mdl');
      $this->load->view('head', $data);
      $this->load->view('_header', $data);
      $this->load->view('client/all_demand', $data);
      $this->load->view('_footer', $data);
      $this->load->view('foot', $data);
    }
    
    /**
     * 需求关键字，分类搜索
     */
    function search(){
        //关键词搜索
         $keyword = empty($this->input->get_post('keyword'))? null:$this->input->get_post('keyword');
         //去除空格
         $keyword = trim($keyword);
         //过滤特殊字符
         $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
         $data['keyword'] =  preg_replace($regex,"",$keyword); 
        
        //分类搜索
         $cate = $this->input->get_post('cate');
         if(!empty($cate)){
             $data['cate'] =$cate;
         }else{
             $data['cate'] = '';
         }
        
        if($data['keyword']){
            //搜索记录记录到数据库
            $info['customer_id'] = $this->session->userdata('user_id');
            $info['keyword'] = $data['keyword'];
            $info['type'] = 'keyword';
            $this->demand_mdl->add_demand_history($info);
            
            //关键字搜索写进session
            if (!empty($history = $this->session->userdata('demand_history'))){
                /* 记录浏览历史 */
                $exist = false;
                foreach ($history as $key ){
                    if($key == $data['keyword']){
                        $exist = true;
                    }
                }
                if(!$exist){
                  array_push($history, $data['keyword']);
                }
                $this->session->set_userdata('demand_history',$history);
            }else{
                $history = array();
                array_push($history, $data['keyword']);
                $this->session->set_userdata('demand_history',$history);
            }
        }else{
            //关键字搜索历史
            $history = $this->session->userdata('demand_history');
            $data['demand_history'] = empty($history)? array():$history;
        }
        
        //分类搜索历史
        $cate_history = $this->session->userdata('cate_history');
        $data['cate_history'] = empty($cate_history)? array():$cate_history;
       
        if($data['cate']){
            $infos = $this->session->userdata('search_index');
            if($data['cate'] == $infos['cate']){
                $data['cate_name'] = $infos['cate_name'];
                $data['cate'] = $infos['cate'];
               
            }else{
                $is_cate = false;
                foreach ($data['cate_history'] as $key =>$val){
                    if($val['cate'] ==  $data['cate']){
                        $is_cate = true;
                        $data['cate_name'] =$val['cate_name'];
                    }
                }
                if(!$is_cate){
                    $data['cate_name'] = '';
                    $data['cate'] = '';
                }
            } 
            
        }else{
            $data['cate_name'] = '';
            $data['cate'] = '';
        }
        
        if($data['keyword'] || $data['cate']){
            $data['show_list'] = true;
        }else{
            $data['show_list'] = false;
        }
        
        $data['title'] = '需求信息';
        $data['back'] = 'home';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/needs_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    
    /**
     * 选择分类搜索
     */
    function classify(){
        $keyword = $this->input->get_post('keyword');
       
        if(empty($keyword)){
            $data['keyword'] = '';
        }else{
            $data['keyword'] = $keyword;
        }
        
        $data['classify'] =  $this->demand_mdl->get_classify(0);
        $data['title'] = '分类筛选';
        $data['back'] = 'search';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/needs_search', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 选择分类跳板
     */
    function spring_board(){
        $search = $this->input->get_post("search_index");
        $cate = $this->input->get_post("cate");
        $data = array(
            "cate_name" =>$search,
            "cate" =>$cate
        );
        //记录进搜索历史
        $history = $this->session->userdata("cate_history");
       
        if(empty($history)){
            //第一次
            $indo['0'] = $data;
            $this->session->set_userdata("cate_history",$indo);
            
            //搜索记录记录到数据库
            $info['customer_id'] = $this->session->userdata('user_id');
            $info['cate_id'] = $cate;
            $info['type'] = 'cate';
            $this->demand_mdl->add_demand_history($info);
        }else{
            //不是第一次
            $status = false;
            foreach ($history as $key =>$val){
                if($val['cate'] == $cate){
                    $status = true;
                }
            }
            if(!$status){
                array_push($history, $data);
                $this->session->set_userdata("cate_history",$history);
                //搜索记录记录到数据库
                $info['customer_id'] = $this->session->userdata('user_id');
                $info['cate_id'] = $cate;
                $info['type'] = 'cate';
                $this->demand_mdl->add_demand_history($info);
            }
        }
        //记录当前搜索分类
        $this->session->set_userdata("search_index",$data);
        $url = site_url("Member/requirement/search?cate=".$cate);
        header("Location:" . $url);
    }
        
    /**
     * ajax 获取下级分类
     */
    function ajax_getlevel(){
        $id = $this->input->get_post('id');
        $level = $this->input->get_post('type');
        $release = $this->input->get_post('release');
        if(!empty($release)){
            $data['level'] = $this->demand_mdl->get_son_classify($id,$level,$release);
        }else{
            $data['level'] = $this->demand_mdl->get_son_classify($id,$level);
        } 
       
        echo json_encode($data);
    }
    
    
    
    /**
     * 异步加载搜索数据
     */
    function ajax_list(){
        //需求过期后自动变下架
        $this->demand_mdl->update_reqirements();
        
        $keyword = $this->input->get_post('keyword');
        $cate_id = $this->input->get_post('cate_id');
        $is_all = $this->input->get_post('is_all');
        
        $orderBy =  $this->input->get_post('orderBy');
        
        if($cate_id && $keyword){//优先级
            $keyword = '';
        }
        $page = $this->input->get_post('page');
        $pagesize = 6;
        if($page == 1){
            $page = 0;
        }else{
            $page   = ($page - 1 ) * $pagesize;
        }
       //处理分类
       if(!empty($cate_id)){
           $cate_info = $this->demand_mdl->get_classify_name($cate_id);
           $classify = $this->demand_mdl->get_son_classify($cate_id,$cate_info['level']);
         
           if(!empty($classify) && count($classify) > 0){
               $section['cate'] = $classify;
           }else{
               $section['cate'] = $cate_id;
           }
       }else{
           $section['cate'] = '';
       }
       $section['orderBy'] = $orderBy;
       $section['keyword'] = $keyword;
       $section['app_id'] = $this->session->userdata("app_info")["id"];
       $customer_id = $this->session->userdata('user_id');
        $this->load->model('label_mdl');
        $label = $this->label_mdl->get_customer_label($customer_id);//id,name
        // var_dump($label);
        $labels = [];
        foreach ($label as $val) {
            $labels[] = $val['id'];
        }
        
        $labels = implode(',', $labels);
        // echo $labels;
       if($is_all){
          $list = $this->demand_mdl->get_lists_for_search($section,$pagesize,$page,null,$is_all);
       }else{
          $list = $this->demand_mdl->get_lists_for_search($section,$pagesize,$page,$labels);
       }
       // echo $this->db->last_query();
       
       //一天 86400
       //一个小时 3600
       $day_time = time();//当前时间戳
       foreach ($list as $key =>$val){
          $_time =  strtotime($val['effectdate']);
          $difference = $_time -  $day_time;
         //大于一天
         if($difference > 86400){
             $list[$key]['remaining']  = $val['effectdate'];
             $list[$key]['status'] = 3;
         }
         //大于一个小时 小于一天
         if($difference > 3600 && $difference < 86400){
             $list[$key]['remaining']  = $val['effectdate'];
             $list[$key]['status'] = 2;
         }
         //小于一个小时
         if($difference < 3600){
             $list[$key]['status'] = 1;
             $list[$key]['remaining']  = $val['effectdate'];
         } 
         
         unset($list[$key]['effectdate']);
       }
//        echo '<pre>';
// print_r($list);exit;
//        echo  $this->db->last_query();exit;
       $data['demandlist'] = $list;
       echo  json_encode($data);exit;
    }
    
    
    /**
     * 
     * ajax 删除发布需求条件
     */
    function del(){
        $type = $this->input->get_post('type');
        if($type == 'keyword'){
            unset($_SESSION['demand_history']);
        }
        if($type == 'cate'){
            unset($_SESSION['cate_history']);
        }
      
        $url = site_url('member/requirement/search');
        header("location: $url");
    }
   
    
    /**
     * 
     * ajax 上架下架
     */
    function putaway(){
        //$id 为需求的ID
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        if($status == 0){
            $status = 1;//上架
        }else{
            $status = 0;//下架
        }
        $msg = array(
            'Result' => false,
            'status' =>$status
            
        );
        if ($id) {
            $affected = $this->demand_mdl->putRequirement($id,$status);
            if ($affected) {
                $msg = array(
                    'Result' => true,
                    'status' =>$status
                );
            }
        }
     
        echo json_encode($msg);
    }
    /**
     * 我的全部需求列表
     *
     */
    function my_req($type=0){
    
        if (!$this->session->userdata('user_in')) {
            redirect('customer/login');
        }
    
        $data['title'] = '我的需求列表';
        $data['back'] = 'member/info';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        if(empty($type)){
            $type = 0;
        }
        $data['status'] = $type;//0全部1抢单(上架)中2审核通过3审核中4审核失败5删除
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/my_needs', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    
        }
    
        
       function ajax_mylist(){
           //需求过期后自动变下架
           $this->demand_mdl->update_reqirements();
           
           $type =  $this->input->get_post('type');
           
           //获取用户ID
           $user_id = $this->session->userdata("user_id");
           $app_id = $this->session->userdata("app_info")["id"];
           
           $page = $this->input->get_post('page');
           $pagesize = 6;
           if($page == 1){
               $page = 0;
           }else{
               $page   = ($page - 1 ) * $pagesize;
           }
           
           $options['app_id'] = $app_id;
           $options['type'] = $type;//0全部1抢单(上架)中2审核通过3审核中4审核失败5删除
           $lists= $this->demand_mdl->getRequirementByid($user_id,$options,$pagesize,$page);
         
           //需求信息组装
           $list = array();
           foreach ($lists as $k =>$v){
           
               $list[$k]['id'] = $v['id'];
               $list[$k]['title'] = $v['title'];
               $list[$k]['img_path'] = $v['img_path'];
               $list[$k]['create_at'] = $v['create_at'];
               //需求的报价总人数
               $list[$k]['total'] = $v['total'];
               //对需求审核状态及是否上架状态处理
               //ispublish 1待审核2通过3不通过5删除
               //is_putaway 0未上架1上架
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
         
           $data['list'] = $list;
           echo  json_encode($data);exit;
       } 
        /**
         * 我的需求详情
         *
         */
        function details($id){
            
            //需求过期后自动变下架
            $this->demand_mdl->update_reqirements();
            
            //进入需求详情页  没有传入id 跳回上一页
            if (!$id) {
               echo "<script>alert('该需求不存在。');history.go(-1);</script>";
               exit;
            }
            if (!$this->session->userdata('user_in')) {
                redirect('customer/login');
                exit;
            }
            $user_id = $this->session->userdata("user_id");
            $app_id = $this->session->userdata("app_info")["id"];
            $req  = $this->demand_mdl->getrequirByid($id);
            if(empty($req)){
                echo "<script>alert('该需求不存在。');history.go(-1);</script>";
                exit;
            }
            if($req['create_by'] != $user_id){
                echo "<script>alert('您没有权限查看该需求！');history.go(-1);</script>";
                exit;
            }
            //处理分类
            $catelist = $this->demand_mdl->get_classify_name($req['cate_id']);
          
            $req['cate'] =  $catelist['name'];
          
            //处理收货地址，及拼接详细地址
            $province = $this->demand_mdl->get_name($req['province_id']);
            $city = $this->demand_mdl->get_name($req['city_id']);
            $district = $this->demand_mdl->get_name($req['district_id']);
            $address = $province['region_name'].'省'.$city['region_name'].'市'.$district['region_name'].$req['shippingaddress'];
            
            //获取当前详情页需求对应用户的公司名称
            $CorName =$this->demand_mdl->getCorporName($req['create_by']);
            $req['corporation'] =  count($CorName)>0? $CorName:array('id'=>'','corporation_name'=>'');;
            $req['address'] = $address;
            
            //一天 86400
            //一个小时 3600
            $day_time = time();//当前时间戳
            $_time =  strtotime($req['effectdate']);
            $difference = $_time -  $day_time;
            //大于一天
            if($difference > 86400){
                $req['status'] = 3;
            }
            //大于一个小时 小于一天
            if($difference > 3600 && $difference < 86400){
                $req['status'] = 2;
            }
            //小于一个小时
            if($difference < 3600){
                $req['status'] = 1;
            }
            //判断需求是否过期
            if($difference < 0 ){
                $req['status'] = 0;
            }
            
            $data['requirement'] = $req;
           
            $data['title'] = '我的需求详情';
            $data['back'] = 'member/info';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/needs_details', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
     
        
        /**
         * 异步获取报价人信息
         */
    
        function ajax_barter_list(){
            $id = $this->input->get_post("id");
            $page = $this->input->get_post('page');
            $pagesize = 6;
            if($page == 1){
                $page = 0;
            }else{
                $page   = ($page - 1 ) * $pagesize;
            }
            
            $app_id = $this->session->userdata("app_info")["id"];
            $options['app_id'] =$app_id;
            $lists = $this->demand_mdl->getBartersByRid($id,$options,$pagesize,$page);
         
            foreach ($lists as $k =>$v){
                //报价人的公司名称
                $Msg = $this->demand_mdl->getCorporName($v['customer_id']);
                if(empty($Msg)){
                    $customer =  $this->customer_mdl->load($v['customer_id']);
                    $lists[$k]['corporation'] = array('id'=>'','corporation_name'=>'');
                    $lists[$k]['contactuser'] = $customer['real_name']? $customer['real_name']:$customer['nick_name'];
                    $lists[$k]['mobile'] =$customer['mobile'];
                    $lists[$k]['email'] = $customer['email'];
                }else{
                    $lists[$k]['corporation'] = count($Msg)>0? $Msg:array('id'=>'','corporation_name'=>'');
                    $lists[$k]['contactuser'] = isset($Msg['contact_name'])?$Msg['contact_name']:'';
                    $lists[$k]['mobile'] = isset($Msg['mobile'])?$Msg['mobile']:'';
                    $lists[$k]['email'] = isset($Msg['email'])?$Msg['email']:'';
                }
               
                $lists[$k]['offer'] = $v['price'];
            }
          
            $data['list'] = $lists;
           
            echo json_encode($data);exit;
        }
        /**
         * 我的全部报价
         *
         */
        function offers(){
            
            //需求过期后自动变下架
            $this->demand_mdl->update_reqirements();
            
            if (!$this->session->userdata('user_in')) {
                redirect('customer/login');
            }
           
            $data['title'] = '我的报价';
            $data['back'] = 'member/info';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
           
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/my_offer', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
    
        }
    
        
        /**
         * 异步加载报价列表
         */
        function  ajax_offer_list(){
            $page = $this->input->get_post('page');
            $pagesize = 6;
            if($page == 1){
                $page = 0;
            }else{
                $page   = ($page - 1 ) * $pagesize;
            }
            
            $user_id = $this->session->userdata("user_id");
            $app_id = $this->session->userdata("app_info")["id"];
            $options['app_id'] =$app_id;
            //用户的所有报价
            $list = $this->demand_mdl->getBarterByid($user_id,$options,$pagesize,$page);
//             echo  '<pre>';
//             print_r($list);exit;
            $data['list'] =$list;
            echo json_encode($data);exit;
            
        }
        
    
        /**
         * 我的报价详情
         *
         */
        function offerdetails($requirement_id,$barter_id){
            $user_id = $this->session->userdata('user_id');
            //需求过期后自动变下架
            $this->demand_mdl->update_reqirements();
//             if (!$requirement_id) {
//                echo "<script>alert('该需求不存在。');history.go(-1);</script>";
//             }
        
            if (!$this->session->userdata('user_in')) {
                redirect('customer/login');
             }
             $req  = $this->demand_mdl->getrequirByid($requirement_id);
            
             //处理分类
             $catelist = $this->demand_mdl->get_classify_name($req['cate_id']);
             $req['cate'] =  $catelist['name'];
             
             //地址处理
             $province = $this->demand_mdl->get_name($req['province_id']);
             $city = $this->demand_mdl->get_name($req['city_id']);
             $district = $this->demand_mdl->get_name($req['district_id']);
             $address = $province['region_name'].'省'.$city['region_name'].'市'.$district['region_name'].$req['shippingaddress'];
             //获取公司
             $CorName =$this->demand_mdl->getCorporName($req['create_by']);
             $req['corporation'] =  count($CorName)>0?$CorName:array('id'=>'','corporation_name'=>'');
             $req['address'] = $address;
             
             //我的报价信息
             $lists= $this->demand_mdl->getbartByid($barter_id);
             $Msg = $this->demand_mdl->getCorporName($user_id);
             if(empty($Msg)){
                 $customer =  $this->customer_mdl->load($user_id);
                 $lists['corporation'] = array('id'=>'','corporation_name'=>'');
                 $lists['mobile'] = isset($customer['mobile'])?$customer['mobile']:'';
                 $lists['email'] = isset($customer['email'])?$customer['email']:'';
                 $lists['contactuser'] = $customer['real_name']? $customer['real_name']:$customer['nick_name'];
             }else{
                 $lists['corporation'] = count($Msg)>0? $Msg:array('id'=>'','corporation_name'=>'');
                 $lists['mobile'] = isset($Msg['mobile'])?$Msg['mobile']:'';
                 $lists['email'] = isset($Msg['email'])?$Msg['email']:'';
                 $lists['contactuser'] =  isset($Msg['contact_name'])?$Msg['contact_name']:'';
             }
             $lists['offer'] = $lists['price'];
             $data['requirement'] = $req;
             $data['list'] = $lists;
             $data['title'] = '我的报价详情';
             $data['back'] = 'member/info';
             $data['foot_set'] = 1;
             $data['head_set'] = 2;
              
             $this->load->view('head', $data);
             $this->load->view('_header', $data);
             $this->load->view('client/offer_details', $data);
             $this->load->view('_footer', $data);
             $this->load->view('foot', $data);
        }
        
        /**
         * 编辑审核失败需求
         * 
         */
        function editrequirements(){
            
            $id = $this->input->get('id');
            if(!$id){
                redirect('member/requirement');
            }
            $user_id = $this->session->userdata("user_id");
            
            $options['app_id'] = $this->session->userdata("app_info")["id"];
            $options['type'] = 0;
            
            //判断该用户是否有这个需求
            $idlist = $this->demand_mdl->getRequirementByid($user_id,$options);
            $exist = false;
            foreach ($idlist as $k =>$v){
                if($id ==$v['id']){
                    $exist = true;
                }
            }
            //存在这个需求
            if($exist){
                $reqlist =  $this->demand_mdl->getrequirByid($id);
                //若需求有上传图片，则把图片地址的;号去掉
                $reqlist['img_path'] = trim($reqlist['img_path'],';');
                $pro_name =  $this->demand_mdl->get_name($reqlist['province_id']);
                $city_name =  $this->demand_mdl->get_name($reqlist['city_id']);
                $district_name = $this->demand_mdl->get_name($reqlist['district_id']);
                $address = $pro_name['region_name'].'-'.$city_name['region_name'].'-'.$district_name['region_name'];
                //处理下时间
                $reqlist['effectdate'] = date("Y-m-d",strtotime($reqlist['effectdate']));
                $reqlist['receiptdate'] =date("Y-m-d",strtotime($reqlist['receiptdate']));
                //获取下分类名称
                //处理分类
                $catelist = $this->demand_mdl->get_classify_name($reqlist['cate_id']);
                $reqlist['cate'] =  $catelist['name'];
                $data['address'] =$address;
                $data['reqlist'] =$reqlist;
            }else{
            }
            $data['classify'] =  $this->demand_mdl->get_classify(0);
            $data['title'] = '编辑需求';
            $data['back'] = 'member/info';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
            $data['exist'] =$exist;

            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/edit_requirement', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
        /**
         * 更新编辑需求
         * session Conditions Dictionarys
         */
       function updaterequirement(){
           
           $user_id = $this->session->userdata("user_id");
           $_customer = $this->customer_mdl->load($user_id);
           $app_id = $this->session->userdata("app_info")["id"];
           $id = $this->input->get_post('id');
           
           $data['app_id'] = $app_id;
           $data['title'] = $this->input->get_post('title');
           $data['cate_id'] = $this->input->get_post('cateid');
           $data['p_count'] = $this->input->get_post('p_count');
           $data['m_price'] = $this->input->get_post('m_price');
           $data['total_price'] = $data['p_count'] * $data['m_price'];
           $data['unit'] = $this->input->get_post('unit');
           //处理JS只传年月日不传时分秒时间
           $time =date('H:i:s');
           $receiptdate = $this->input->get_post('receiptdate');
           $effectdate = $this->input->get_post('effectdate');
           $data['receiptdate']  = $receiptdate.' '.$time;
           $data['effectdate'] = $effectdate.' '.$time;
         
           $data['province_id'] = $this->input->get('province_id');
           $data['city_id'] = $this->input->get_post('city_id');
       
           $data['shippingaddress'] = $this->input->get_post('shippingaddress');
           $data['update_at'] = date('Y-m-d H:i:s');
           $data['update_by'] = $user_id;
           if($this->input->get_post('img_path')){
               $data['img_path'] = $this->input->get_post('img_path');
           }
           $tax = $this->input->get_post('tax');
           $freight = $this->input->get_post('freight');
           $data['needtax'] = empty($tax)?0:$tax;//0不含运费1含运费
           $data['freight'] = empty($freight)?0:$freight;//0不含税1含税
           $data['ispublish'] = 1;//需求状态改回审核中
           
           $status = $this->demand_mdl->updateRequirementByid($id,$data);
           
           $msg = array(
               'Result' => true
           );
           if(!$status){
               $msg = array(
                   'Result' => false
               );
               echo json_encode($msg);
               return;
           }
          
           echo json_encode($msg);
       }
        /**
         * 发布需求
         * session Conditions Dictionarys
         */
        
        function addrequirements(){
          
            $data['classify'] =  $this->demand_mdl->get_classify(0);
            foreach ($data['classify'] as $k => $v){
                $arrays = $this->demand_mdl->get_son_classify($v['id'],$v['level']);
                if(count($arrays)>0){
                    $data['classify'][$k]['child'] = true;
                }else{
                    $data['classify'][$k]['child'] = false;
                }
            }
            $data['title'] = '发布需求';
            $data['back'] = 'member/info';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/publish_needs', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
        function  addbarter($id){
          
            //处理需求信息
            $req  = $this->demand_mdl->getrequirByid($id);
            
            //处理分类
            $catelist = $this->demand_mdl->get_classify_name($req['cate_id']);
            $req['cate'] =  $catelist['name'];
            
            $province = $this->demand_mdl->get_name($req['province_id']);
            $city = $this->demand_mdl->get_name($req['city_id']);
            $district = $this->demand_mdl->get_name($req['district_id']);
            $address = $province['region_name'].'省'.$city['region_name'].'市'.$district['region_name'].$req['shippingaddress'];
            $CorName =$this->demand_mdl->getCorporName($req['create_by']);
            $req['corporation'] =  count($CorName)>0?$CorName:array('id'=>'','corporation_name'=>'');
            $req['address'] = $address;
            
            
            //一天 86400
            //一个小时 3600
            $day_time = time();//当前时间戳
            $_time =  strtotime($req['effectdate']);
            $difference = $_time -  $day_time;
            //大于一天
            if($difference > 86400){
                $req['status'] = 3;
            }
            //大于一个小时 小于一天
            if($difference > 3600 && $difference < 86400){
               $req['status'] = 2;
            }
            //小于一个小时
            if($difference < 3600){
                $req['status'] = 1;
            }
                 
          
            
            $data['requirement'] = $req;
            
            $user_id = $this->session->userdata('user_id');
            $app_id = $this->session->userdata("app_info")["id"];
            $options['app_id'] =$app_id;
            
            //判断该用户对于当前需求之前是否已经报价
            $idlist = $this->demand_mdl->getBarterByid($user_id,$options);
           
            $exist = false;
            foreach ($idlist as $k =>$v){
                if($id ==$v['requirement_id']){
                    $exist = true;
                    $barterid = $v['barter_id'];
                }
            }
            
            $barterlist = array();
            //当前需求已经报价
            if($exist){
                //报价人的公司名称
                $barterlist = $this->demand_mdl->getbartByid($barterid);
                $user_id = $this->session->userdata("user_id");
                $customer =  $this->customer_mdl->load($user_id);
                $Msg = $this->demand_mdl->getCorporName($user_id);
              
                $barterlist['corporation'] = count($Msg)>0?$Msg:array('id'=>'','corporation_name'=>'');
                if($Msg){
                    $barterlist['contactuser'] =empty($Msg['contact_name'])? $Msg['contact_mobile']:$Msg['contact_name'];
                    $barterlist['mobile'] = isset($Msg['mobile'])?$Msg['mobile']:'';
                    $barterlist['email'] = isset($Msg['email'])?$Msg['email']:'';
                }else{
                    $barterlist['contactuser'] =$customer['real_name']? $customer['real_name']:$customer['nick_name'];
                    $barterlist['mobile'] =$customer['mobile'];
                    $barterlist['email'] = $customer['email'];
                }
               
                $barterlist['offer'] = $barterlist['price'];
            }
            
            //判断是不是自己发布的需求
            if($user_id == $req['create_by'] ){
                $data['self'] =true;
            }else{
                $data['self'] =false;
            }
            
            $data['barterlist'] = $barterlist;
            $data['title'] = '需求详情';
            $data['back'] = 'member/requirement/search';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
             
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/needs_offer', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
        
        /**
         *
         * ajax addbarter
         */
        function ajax_addbarter(){
            
           
            
            $requirement_id = $this->input->get_post('requirement_id');
            $offer = $this->input->get_post('offer');
            $days = $this->input->get_post('days');
            $remark = $this->input->get_post('remark');
            $accessory_url = $this->input->get_post('img_url');
           
            $tax = $this->input->get_post('tax');
            $freight = $this->input->get_post('freight');
            
            $user_id = $this->session->userdata("user_id");
            $app_id = $this->session->userdata("app_info")["id"];
            $_customer = $this->customer_mdl->load($user_id);
            $corp= $this->customer_corporation_mdl->load( $user_id);
            $msg = array(
                'Result' => true,
                'Status' =>false,
                'Corp_Status' =>true
            );
           
            $barter['app_id'] = $app_id;
            // var_dump($requirement_id);
            //处理需求信息
            $req  = $this->demand_mdl->getrequirByid($requirement_id);
            //单价
            $barter['price'] = $offer;
            $offer = round($offer*$req['p_count'], 2);
            //总价
            $barter['offer'] = $offer;
            $barter['requirement_id'] = $requirement_id;
            $barter['days'] = $days;
            if($corp){
                $barter['contactuser'] = empty($corp['contact_name'])? $corp['contact_mobile']:$corp['contact_name'];
            }else{
                $barter['contactuser'] = $_customer['real_name']? $_customer['real_name']:$_customer['nick_name'];
            }
           
            $barter['customer_id'] = $user_id;
            $barter['remark'] = empty($remark)? '':$remark;
            $barter['accessory_url'] = empty($accessory_url)?'':$accessory_url;
            $barter['needtax'] = empty($tax)?0:$tax;//0不含运费1含运费
            $barter['freight'] = empty($freight)?0:$freight;//0不含税1含税
            
            
            $options['app_id'] = $app_id; 
            $options['state'] = 0;
            $barters  = $this->demand_mdl->getBartersByRid($requirement_id,$options);
            $cus_id = array();
            foreach ($barters as $k=>$v){
                $cus_id[$k] = $v['customer_id'];
            }
                       
            if(in_array($user_id,$cus_id)){
                echo json_encode($msg);
                return;
            }
          
            $id  = $this->demand_mdl->add_barter($barter);
            $msg['Status'] = true;
            if(!$id){
                $msg['Result'] = false;
                echo json_encode($msg);
                return;
            }
            echo json_encode($msg);
        }
        
        /**
         * 后台判断报价是否截止
         */
        function Timeout(){
            $id = $this->input->get('id');
            $data = $this->demand_mdl->getrequirByid($id);
            $nowtime = time();
            $time = strtotime($data['effectdate']);
            $Msg = array(
                'Result'=>false
            );
            if($time>$nowtime){
                $Msg = array(
                    'Result'=>true
                );
            }
            echo json_encode($Msg);
        }
        
      
      
       /**
        * 个人中心入口
        * 需求管理
        */
        function needs_manage(){
            $data['title'] = '需求管理';
            $data['back'] = 'member/info';
            $data['foot_set'] = 1;
            $data['head_set'] = 2;
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('client/needs_manage', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
       
     
        /**
         * ajax 发布需求
         */
        function ajax_addrequirement(){
            $user_id = $this->session->userdata("user_id");
           
            $p_count = $this->input->get_post('p_count');
            $m_price = $this->input->get_post('m_price');
            $this->demand_mdl->title = $this->input->get_post('title');
            $this->demand_mdl->cate_id = $this->input->get_post('cateid');
            $this->demand_mdl->p_count = $p_count;
            $this->demand_mdl->m_price = $m_price;
            //总价 = 数量*单价
            $this->demand_mdl->total_price = $p_count*$m_price;
            $this->demand_mdl->unit = $this->input->get_post('unit');
            //处理JS只传年月日不传时分秒时间
            $time =date('H:i:s');
            $receiptdate = $this->input->get_post('receiptdate');
            $effectdate = $this->input->get_post('effectdate');
            $this->demand_mdl->receiptdate = $receiptdate.' '.$time;
            $this->demand_mdl->effectdate = $effectdate.' '.$time;
            
            $this->demand_mdl->needtax = $this->input->get_post('tax');
            $this->demand_mdl->freight = $this->input->get_post('freight');
            $this->demand_mdl->province_id = $this->input->get_post('province_id');
            $this->demand_mdl->city_id = $this->input->get_post('city_id');
            $this->demand_mdl->district_id = $this->input->get_post('district_id');
            $this->demand_mdl->shippingaddress = $this->input->get_post('shippingaddress');
            $img_path = $this->input->get_post('img_path');
           
            if(!empty($img_path)){
                $this->demand_mdl->img_path = $img_path;
            }
            $this->demand_mdl->app_id = $this->session->userdata("app_info")["id"];
            $user_id = $this->session->userdata("user_id");
           
            $customer =  $this->customer_mdl->load($user_id);
            $msg['Corp_Status'] =true;
           
            $corp= $this->customer_corporation_mdl->load( $user_id);
            if($corp){
                $this->demand_mdl->contactuser =$corp['contact_name']? $corp['contact_name']:null;
                $this->demand_mdl->contactphone =$corp['contact_mobile'] ? $corp['contact_mobile']:null;
            }else{
               $this->demand_mdl->contactuser =$customer['real_name']? $customer['real_name']:$customer['nick_name'];
               $this->demand_mdl->contactphone =$customer['mobile'] ;
            }
            
            $id = $this->demand_mdl->add_demand();
            $msg['Result'] =true;
            if(!$id){
                $msg['Result'] =false;
                echo json_encode($msg);
                return;
            }
            echo json_encode($msg);
        }
        
        /**
         * 删除单张旧图片
         */
        function unlickimg(){
            $id = $this->input->get_post('id');
            $file = $this->input->get_post('file');
            $file = trim($file,';');
            $path = FCPATH.UPLOAD_PATH.$file;
            $msg = array(
                'Result'=>true,
                'status'=>false,
            );
         
            if (!unlink($path))
            {}
            else
            {
                $msg = array(
                'Result'=>true,
                'status'=>true,
                );
                $data['img_path'] = '';
                $this->demand_mdl->updateRequirementByid($id,$data);
            }
            echo json_encode($msg);
        }
        /**
         *单张图片上传
         *
         */
        public function images_upload()
        {
            $this->load->library('upload');
                $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
//                 $file_path = FCPATH . $save_path;
                $file_path = FCPATH .UPLOAD_PATH.$save_path;
                
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
                    
//                     $configs['image_library'] = 'gd2';
//                     $configs['source_image'] = $file_path.$uploaded['file_name'];
//                     $configs['new_image'] = $file_path.$uploaded['file_name'];
//                     $configs['create_thumb'] = false;//是否生成缩略图
//                     $configs['maintain_ratio'] = false;
//                     $configs['width']     = '100';//压缩宽度
//                     $configs['height']   = '100';//压缩高度
                     
//                     $this->load->library('image_lib');
//                     $this->image_lib->initialize($configs);
//                     if ( ! $this->image_lib->resize())
//                     {
//                         error_log("缩略图生成失败，原因：" . $this->image_lib->display_errors());
//                     }
                    $data['img_path'] = $save_path . $uploaded['file_name'];
                  
                    echo json_encode($data);
                } else {
                    echo json_encode('上传失败');
                }
        }
        /**
         *多张图片上传
         *
         */
        public function images_upload_batch()
        {
            $this->load->library('upload');
            $save_path = 'uploads/demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $file_path =FCPATH .UPLOAD_PATH.$save_path;
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
//                 if (!empty($image = $this->session->userdata("barter_image"))) {//保存session
//                     foreach ($image as $val){
//                         $barter_image[] = $val;
//                     }
//                 }
//                 $this->session->set_userdata("barter_image", $barter_image);
                echo json_encode($data);
            } else {
                echo json_encode('上传失败');
            }
        }

        public function customization_demand()
        {

          /**
           * 选择分类搜索
           */
            

            // var_dump($customer_id);
            //   $keyword = $this->input->get_post('keyword');
             
            //   if(empty($keyword)){
            //       $data['keyword'] = '';
            //   }else{
            //       $data['keyword'] = $keyword;
            //   }
              
              // $data['classify'] =  $this->demand_mdl->get_classify(0);
              $customer_id = $this->session->userdata('user_id');
              $this->load->model('label_mdl');
              $customer_label = $this->label_mdl->get_customer_label($customer_id);
              $data['label'] = $this->label_mdl->get_label();
              $data['customer_label_id'] = [];
              foreach($customer_label as $val){
                $data['customer_label_id'][] = $val['id'];
              }


              // var_dump($data['label']);
              // var_dump($data['customer_label_id']);
              $data['title'] = '定制需求';
              $data['back'] = 'search';
              $data['foot_set'] = 1;
              $data['head_set'] = 2;
          
          $this->load->view('head', $data);
          $this->load->view('_header', $data);
        $this->load->view('client/focus_demand', $data);
          $this->load->view('_footer', $data);
          $this->load->view('foot', $data);
        }
        
        // 精确推荐
        public function customization_requirement($cates='')
        {
          // $cates = $this->input->get('data')? $this->input->get('data') : $cates;
          
          $this->load->model('requirement_mdl');
          $requirement_info = $this->requirement_mdl->get_requirement_info($cates);
          // var_dump($requirement_info);
          echo json_encode($requirement_info);

        }

        // 保存重新
        public function save_customization_demand()
        {
          $cate_id = $this->input->get('cate_id');

          $cate_id = json_decode($cate_id,TRUE);

          $this->load->model('requirement_mdl');
          $result = $this->requirement_mdl->save_customization_demand($cate_id);
          echo json_encode($result);

        }

    /**
     * 精选推荐
     */
    function recommend_demand(){


        $data['title'] = '精选推荐';
        $data['back'] = 'search';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $customer_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : null;
        $this->load->model('label_mdl');
        $result = $this->label_mdl->follow_customer_label($customer_id);
        $labels = [];
        foreach($result as $val){
            $labels[] = $val['label_id'];
        }
        // 获取定制分类
        $this->load->model('requirement_mdl');

        // $cateids = $this->requirement_mdl->get_cates();
        // var_dump($cateids);
        // $cate_id = [];
        // foreach($cateids as $val){
        //   $cate_id[] = $val['cate_id'];
        // }
        // $data['total_num'] = $this->demand_mdl->count_total($customer_id,2,null,$cate_id,$labels);//总条数
        // echo $data['total_num'];

        // 获取需求数据
        // $this->load->model('demand_mdl');
        // $data['list'] = $this->demand_mdl->get_requirement(null,2,'a.');

        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/recommend_demand', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // 加载更多需求
    public function ajaxload_requirement()
    {

      $page = $this->input->post('page')? $this->input->post('page'): 1 ;

      $num = 15;
      $start_page = $num*($page-1);
      $return = array();
      $data = array();
      $customer_id = $this->session->userdata('user_id');
      $this->load->model('label_mdl');
      $label = $this->label_mdl->get_customer_label($customer_id);//id,name
      // var_dump($label);
      $labels = [];
      foreach ($label as $val) {
          $labels[] = $val['id'];
      }
      $this->load->model('demand_mdl');
      // $demandlist = $this->demand_mdl->get_requirement(null,1,'a.title,a.create_by,a.img_path,a.id,a.total_price,a.create_at',$num,$start_page,null, null, null,$labels );//title,img_path,id,total_price

      $labels = implode(',',$labels);
      $demandlist = $this->demand_mdl->get_requirement_by_label_time($num,$start_page ,$labels);
      $return['result'] = 1;
      $return['demandlist'] = $demandlist;

      echo json_encode($return);
    }

    // 测试
    public function test_ehw(){
      // $this->load->model('demand_mdl');
      //  $demandlist = $this->demand_mdl->get_requirement_by_label_time(); 
      //  var_dump($demandlist);    
      $this->load->model('label_mdl');
      $customer_id = $this->session->userdata('user_id');
      $label = $this->label_mdl->get_customer_label($customer_id);//id,name
      var_dump($label);
      // var_dump($label);
      $labels = [];
      foreach ($label as $val) {
         
           $labels[] = $val['id'];
      }
      var_dump($labels);
      $labels = implode(',', $lables);
      
      echo $labels; 
    }
}

