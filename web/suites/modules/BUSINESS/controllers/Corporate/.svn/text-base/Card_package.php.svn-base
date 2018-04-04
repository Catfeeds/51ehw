<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Card_package extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
    var $is_binding = true;//默认已经绑定
    
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
		    $this->session->set_userdata ( 'ref_from_url', current_url () );
			redirect ( 'customer/login' );
			exit ();
		}

	
		// 微信用户绑定监测
	    $customer_id = $this->session->userdata("user_id");//用户id
	    $this->load->model("customer_mdl");
	    $customer = $this->customer_mdl->load($customer_id);
	    if (empty($customer['mobile'])) {
	        $url = site_url($_SERVER['PATH_INFO']);
	        $this->session->set_userdata("ref_from_url",$url);
	        $this->is_binding = false;
	    }

		$this->load->model("card_package_mdl");
	} 
	
	/**
	 * 货包列表
	 * pc端
	 */
	public function index($status=null){
	    
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
	        redirect('home');
	        return;
	    }
	    
	    //判断是否pc和商家
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	    
	    }
	    
	    $serach = $this->input->get("search_name");//搜索条件
	    
	    //统计
	    $data["all"] = count($this->card_package_mdl->get_package());//全部
	    $data["not_start"] = count($this->card_package_mdl->get_package(null,1));//未开始
	    $data["ing"] = count($this->card_package_mdl->get_package(null,2));//活动中
	    $data["obsolete"] = count($this->card_package_mdl->get_package(null,3));//已过期
	    $data["wait"] = count($this->card_package_mdl->get_package(null,4));//审核中
	    $data["fail"] = count($this->card_package_mdl->get_package(null,5));//审核失败
	    $data["new"] = count($this->card_package_mdl->get_package(null,6));//新建
	    
	    //---分页 -开始
	    $this->load->library('pagination');
	    $config['per_page'] = 15;
	    $current_page = ($this->input->get('per_page') );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    $data["list"] = $this->card_package_mdl->get_package(null,$status,$serach,$offset,$config['per_page']);
	    if($serach){
	        $config['base_url'] = site_url('corporate/card_package').'?search_name='.$serach.'&/';//路径配置
	    }else{
	       $config['base_url'] = site_url('corporate/card_package').'/index/'.$status.'?/';//路径配置
	    }
	    $sift['count'] = true;
        $data["total_rows"] = $config['total_rows'] = count($this->card_package_mdl->get_package(null,$status,$serach));
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config ['prev_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $this->pagination->initialize($config);//初始化配置
	    $data['page'] =  $this->pagination->create_links();//执行
	    //--分页 -结束
	    
	    

	    $data["search"] = $serach;
	    $data["status"] = $status;
	    $data ['head_set'] = 4;
	    $data ['title'] = "货包列表";
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ( 'card_package/package_list', $data );
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}
	
	
	/**
	 * 修改添加or修改货包页面
	 */
	public function add_view($id=0) {
	    //判断是否pc和商家
	    $corporation = $this->session->userdata("corporation_id");
	    
	    if( !$corporation )
	    {
	        redirect('Corporation/home_page');
	        exit();
	         
	    }
	    
	    @$this->session->unset_userdata ( 'ad' );
	    @$this->session->unset_userdata ( 'coupon' );
	    
	    if($id){
	       $data["package"] = $this->card_package_mdl->get_package($id);//货包信息
           if($data["package"]){
               $data["selected"] = $this->card_package_mdl->Selected($id,$data["package"]['specified_type']);//选中的商品
           }else{
               echo "<script>history.back(-1);</script>";return ;
	       }
	    }
	    
	    $this->load->model("product_mdl");
	    $this->load->model("product_cat_mdl");
	    $data["product"] = $this->product_mdl->load_goodsList($corporation);//店铺商品

	    $data["cate"] = $this->product_cat_mdl->getStoreclassification();//店铺商品分类
	    
	    $data ['head_set'] = 4;
	    $data ['title'] = $id?"修改货包":"添加货包";
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'card_package/add_package', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	/**
	 * 添加卡包
	 */
	public function add() {
	    //判断是否pc和商家
	   
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	    
	    }
	    
	    $customer_id = $this->session->userdata("user_id");
	    $ad = $this->session->userdata('ad');
	    $coupon = $this->session->userdata('coupon');
	    
	    if(!$ad || !$coupon){//验证图片
	        echo '<script>history.back(-1);alert("数据错误");</script>';exit;
	    }

	    //生成流水号
	    $this->load->helper('order');
	    $exist = false;
	    do {
	        $package_sn = get_order_sn ();
	        $exist = $this->card_package_mdl->get_package_sn($package_sn);//查询流水号
	    } while ( $exist ); // 如果是订单号重复则重新提交数据
	    $this->card_package_mdl->package_sn = $package_sn;

	    
        $this->card_package_mdl->name = $this->input->post("name");
        $specified_type = $this->input->post("specified_type");//类型：1商品2品类
        if( in_array($specified_type,array(1,2))){//类型
            $this->card_package_mdl->specified_type = $specified_type;
        }else{
            echo '<script>history.back(-1);alert("数据错误");</script>';exit;
        }
        
        $discount_type = $this->card_package_mdl->discount_type = $this->input->post("discount_type");//优惠方式：1折扣2满减3现场礼包
        switch($discount_type){//验证优惠方式
            case "1":
                $this->card_package_mdl->discount = $this->input->post("discount");//折扣
                break;
            case "2":
                $overtop_price = $this->input->post("overtop_price");//金额要求
                $deduction_price = $this->input->post("deduction_price");//优惠金额
                if(($overtop_price-$deduction_price) < 0){
                    echo '<script>history.back(-1);alert("数据错误");</script>';exit;
                }
                $this->card_package_mdl->overtop_price = $overtop_price;
                $this->card_package_mdl->deduction_price = $deduction_price;
                break;
            case "3":
                break;
            default:
                echo '<script>history.back(-1);alert("数据错误");</script>';exit;
                break;
        }
        
        $give_type = $this->card_package_mdl->give_type = $this->input->post('give_type');//发送方式
        switch($give_type){//验证发送方式
            case "1":
                break;
            case "2":
                 $this->card_package_mdl->number = $this->input->post("number");//发放数量
                break;
            default:
                echo '<script>history.back(-1);alert("数据错误");</script>';exit;
                break;
        }
        
        $this->card_package_mdl->grant_start_at = $this->input->post("grant_start_at");//发放开始日期
        $this->card_package_mdl->grant_end_at = $this->input->post("grant_end_at");//发放过期日期
        $this->card_package_mdl->coupon_start_at = $this->input->post("coupon_start_at");//优惠有效日期
        $this->card_package_mdl->coupon_end_at = $this->input->post("coupon_end_at");//优惠过期日期
        $this->card_package_mdl->describe = $this->input->post("describe");//说明
        $this->card_package_mdl->coupon_image = $coupon;//优惠券图片
        $this->card_package_mdl->ad_image = $ad;//广告图
        $this->card_package_mdl->donation = $this->input->post("donation")?1:2;//转赠：1可以2不可以
        $this->card_package_mdl->is_show = $this->input->post("is_show")?$this->input->post("is_show"):0;//转赠：0不显示1显示
        $this->card_package_mdl->is_activity = $this->input->post("is_activity")?$this->input->post("is_activity"):0;//转赠：0不活动1活动
        $this->card_package_mdl->status = 1;//状态

        if($this->input->post("sid")){//验证已选条件
            $sid = explode(",",trim($this->input->post("sid"),","));
        }else{
            echo '<script>history.back(-1);alert("数据错误");</script>';exit;
        }

        //开启事务
        $this->db->trans_begin();
        if(!$coupon){
            echo "<script>history.back(-1);alert('请上传优惠券展示图');</script>";exit;
        }
        if(!$ad){
            echo "<script>history.back(-1);alert('请上传广告图');</script>";exit;
        }
        $package_id = $this->card_package_mdl->add();//添加卡包

        $i = 0;
        if(!empty($package_id)){//添加货包关联信息
            if($sid){
                foreach ($sid as $v){
                    $array["package_id"] = $package_id;
                    switch($specified_type){
                        case "1":
                            $array["product_id"] = $v;
                            break;
                        case "2":
                            $array["cate_id"] = $v;
                            break;
                        default:
                            echo '<script>history.back(-1);alert("数据错误");</script>';return;
                            break;
                    }
                    $data[$i++] = $array;
                }
            $row = $this->card_package_mdl->increase($data);
            }
            $row1 = $this->card_package_mdl->add_accredit($package_id,$customer_id);//添加授权
            if(!empty($row) && $row1){
                $this->db->trans_commit();//提交
                echo "<script>window.location.href='".site_url("corporate/card_package")."';alert('添加成功');</script>";exit;
            }else{
                $this->db->trans_rollback();//回滚
                echo "<script>history.back(-1);alert('操作失败');</script>";exit;
            }
            
        }else{
            $this->db->trans_rollback();//回滚
            echo "<script>history.back(-1);alert('操作失败');</script>";exit;
        }
	}
	
	/**
	 * 修改卡包内容
	 */
	public function edit(){
	    //判断是否pc和商家
	    
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	         
	    }
        $ad = $this->session->userdata('ad');
        $coupon = $this->session->userdata('coupon');
	    
	    $id = $this->input->post("id");
        if(!$id){
            echo '<script>history.back(-1);</script>';exit;
        }
	    
        $this->card_package_mdl->name = $this->input->post("name");
        $specified_type = $this->card_package_mdl->specified_type = $this->input->post("specified_type");//类型：1商品2品类
        if($specified_type==1 || $specified_type==2){//验证类型
            $this->card_package_mdl->specified_type= $specified_type;
        }else{
            echo '<script>history.back(-1);alert("数据错误");</script>';exit;
        }
        
        $discount_type = $this->card_package_mdl->discount_type = $this->input->post("discount_type");//优惠方式：1折扣2满减
        switch($discount_type){
            case "1":
                $this->card_package_mdl->discount = $this->input->post("discount");//折扣
                break;
            case "2":
                $this->card_package_mdl->overtop_price = $this->input->post("overtop_price");//金额要求
                $this->card_package_mdl->deduction_price = $this->input->post("deduction_price");//优惠金额
                break;
            case "3":
                break;
             default:
                 echo '<script>history.back(-1);</script>';exit;
                 break;
        }
        
        $give_type = $this->card_package_mdl->give_type = $this->input->post('give_type');//发送方式
        if($give_type == 2){
            $this->card_package_mdl->number = $this->input->post("number");//发放数量
        }
        
        $this->card_package_mdl->grant_start_at = $this->input->post("grant_start_at");//发放开始日期
        $this->card_package_mdl->grant_end_at = $this->input->post("grant_end_at");//发放过期日期
        $this->card_package_mdl->coupon_start_at = $this->input->post("coupon_start_at");//优惠有效日期
        $this->card_package_mdl->coupon_end_at = $this->input->post("coupon_end_at");//优惠过期日期
        $this->card_package_mdl->describe = $this->input->post("describe");//说明
        $this->card_package_mdl->coupon_image = $coupon;//优惠券图片
        $this->card_package_mdl->ad_image = $ad;//广告图
        $this->card_package_mdl->donation = $this->input->post("donation")?1:2;//转赠：1可以2不可以

        $this->card_package_mdl->is_show = $this->input->post("is_show")?$this->input->post("is_show"):0;//转赠：0不显示1显示
        $this->card_package_mdl->is_activity = $this->input->post("is_activity")?$this->input->post("is_activity"):0;//转赠：0不活动1活动
        $this->card_package_mdl->status = 1;//状态

        if($this->input->post("sid")){
            $array2 = explode(",",trim($this->input->post("sid"),","));
        }else{
            echo '<script>history.back(-1);</script>';exit;
        }

        //开启事务
        $this->db->trans_begin();

        $row1 = $this->card_package_mdl->save($id);//执行更新
        $selected = $this->card_package_mdl->Selected($id,$specified_type);//查选中的商品或者分类
        $array1 = array();
        foreach ($selected as $v){
            $array1[] = $v['id'];
        }
        //筛选要设置优惠的分类或者商品
        $sid = array_diff($array2,$array1);
        
        //筛选不设置优惠的分类或者商品
        $del_id = array_diff($array1,$array2);

        if($del_id){
            $row2 = $this->card_package_mdl->del($id,$del_id);
        }else{
            $row2 = true;
        }


        $i = 0;
        if($sid){//判断是否设置优惠的分类或者商品
            foreach ($sid as $v){
                $array["package_id"] = $id;
                switch($specified_type){
                    case "1":
                        $array["product_id"] = $v;
                        break;
                    case "2":
                        $array["cate_id"] = $v;
                        break;
                    default:
                        echo '<script>history.back(-1);</script>';exit;
                        break;
                }
                $data[$i++] = $array;
            }
            $row3 = $this->card_package_mdl->increase($data);
        }else{
            $row3 = true;
        }
        

        if($row2 && $row3){
            $this->db->trans_commit();//提交
            echo "<script>window.location.href='".site_url("corporate/card_package")."';alert('修改成功');</script>";exit;
        }else{
            $this->db->trans_rollback();//回滚
            echo "<script>history.back(-1);alert('操作失败');</script>";exit;
        }
            

	}
	
	/**
	 * 商家卡包详情
	 */
	public function detail($id=0){
	    $mac_type = $this->input->get_post("mac_type");
	    if(isset($mac_type)){//APP
	        $data['mac_type'] = $mac_type;
	        $data['package'] = $this->card_package_mdl->get_package($id);
	    }else{//web
	        $data['mac_type'] = '';
	        //判断是否pc和商家 || 是否有id
	        if (!$this->session->userdata("corporation_id") || !$id) {
	            echo "<script>history.back(-1);</script>";return ;
	        }
	        $data['package'] = $this->card_package_mdl->get_package($id);
	        if(!$data['package']){
	            echo "<script>history.back(-1);</script>";exit;
	        }
	    }
	   
	    $data["selected"] = $this->card_package_mdl->Selected($id,$data["package"]['specified_type']);//选中的商品
	    $data["receivetotal"] = $this->card_package_mdl->receive_total($id,array(1,2));//统计已经领取
	    $data['use'] = $this->card_package_mdl->receive_total($id,array(1));//统计已经使用
	    $data['accredit'] = $this->card_package_mdl->get_authorize($id,1);//授权列表
	    $data['situation'] = $this->card_package_mdl->situation($id);//卡包领取情况
	    $data['number'] = $this->card_package_mdl->SurplusPackage($id,4);//统计卡包剩余数量
		$data ['head_set'] = 4;
		$data ['title'] = '货包详情';
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
        $this->load->view ( 'card_package/package_details', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	    
	}
	

	/**
	 * 上传图片
	 * @param int 状态：1优惠券图片2广告图片
	 */
	public function uploads($status){
	    
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	         
	    }
	    
	    if($status == 1){
	        $a = 'coupon';//session变量
	    }else if($status == 2){
	        $a = 'ad';//session变量
	    }
        //判断上传图片有没有错误
        if($_FILES['file']['error']==0){
            //定义路径
            $save_path = 'package/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path))
                mkdir($path,0755,true);//判断路径存在，不存在就创建
//                 error_log("mkdir back:".mkdirsByPath($path));


            $this->load->helper("ps_helper");
            //ci上传图片配置
            $config['file_name'] = $this->session->userdata('corporation_id') . '_' . date("YmdHis");
            $config['upload_path']      = $path;
            $config['allowed_types']    = 'jpg|png|jpeg';
            $config['max_size']     = 1000;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $image_info = $this->upload->data();
                $all_images = "uploads/".$save_path.$image_info['file_name'];
                $this->session->set_userdata($a, $all_images);
            }else{
              echo "上传失败";
            }
        }else{
            echo "上传失败";
        }
    }
	
	/**
	 * ajax更新状态
	 */
    public function operate(){
        $status = $this->input->post('status');//状态
        $id = $this->input->post('id');//id
        if($status === "0" || $status == 2){
            $this->card_package_mdl->status = 1;
        }else if($status == 1){
            $this->card_package_mdl->status = 0;
        }else{
            $json = array('status' => "1");//非法操作
            echo json_encode($json);
            exit;
        }
        
        $row = $this->card_package_mdl->save($id);
        if($row){
            $json = array('status' => "2");//成功
        }else{
            $json = array('status' => "3");//失败
        }
        echo json_encode($json);
    }
    
    
    /**
     * 添加授权
     */
    public function authorize(){
        //判断是否pc和商家
        if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	    
	    }
        
        $mobile = $this->input->post('mobile');//授权手机
        $p_id = $this->input->post('id');//货包id
        if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
            $json = array('status'=>'1');//不是手机
            echo json_encode($json);exit;
        }else if(!$p_id){
            $json = array('status'=>'6');//数据错误
            echo json_encode($json);exit;
        }
        $this->load->model('customer_mdl');
        //查询判断用户是否存在
        $customr = $this->customer_mdl->load_by_name($mobile);
        if($customr){
            $data = $this->card_package_mdl->check_authorize($p_id,$customr['id']);
            if($data){//状态改成授权
                if($data['status'] == 1){
                    $json = array('status'=>'3');//已经授权
                    echo json_encode($json);exit;
                }else{
                    $row = $this->card_package_mdl->edit($data['id'],1);//更改授权
                    if($row){
                        $json = array('status'=>'4');//成功
                        echo json_encode($json);exit;
                    }else{
                        $json = array('status'=>'5');//失败
                        echo json_encode($json);exit;
                    }
                }
            }else{//添加授权
                $row = $this->card_package_mdl->add_accredit($p_id,$customr['id']);
                $json = array('status'=>'4');//失败
                echo json_encode($json);exit;
            }
        }else{
            $json = array('status'=>'2');//用户不存在
            echo json_encode($json);exit;
        }
    }
    
    
    /**
     * ajax 更新授权状态
     */
    public function up_authorize(){
        $customer_id = $this->input->post("customerid");//用户id
        $p_id = $this->input->post("pid");//货包id
        if(!$customer_id || !$p_id){
            $json = array('status'=>'1');//非法操作
            echo json_encode($json);exit;
        }
        
        //查询判断是否存在数据
        $data = $this->card_package_mdl->check_authorize($p_id,$customer_id);
        if($data){
            $row = $this->card_package_mdl->edit($data['id'],2);
            if($row){
                $json = array('status'=>'2');//成功
                echo json_encode($json);exit;
            }else{
                $json = array('status'=>'1');//失败
                echo json_encode($json);exit;
            }
        }else{
            $json = array('status'=>'1');//非法操作
            echo json_encode($json);exit;
        }
        
    }
    
    
    // -------------------------------------------------------------------
    
    
    /**
     * 我的卡包
     */
    public function my_package(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        
        $customer_id = $this->session->userdata('user_id');

        $packageAll = $this->card_package_mdl->my_package_all($customer_id,array(1,2));//我领取过的所有优惠券
        //领取发送所有人的优惠券（已领取的不能领取）
        $p_array = array_column($packageAll,"p_id");//已经领取的优惠券id
        $package = $this->card_package_mdl->not_obtained_package($p_array);//获取发送所有人未领取的优惠券
        if($package){
            foreach ($package as $k => $v){
                $cart[$k]['p_id'] = $v['id'];
                $cart[$k]['sender_id'] = $v['customer_id'];
                $cart[$k]['customer_id'] = $customer_id;
                $cart[$k]['created_at'] = date("Y-m-d H:i:s");
                $cart[$k]['status'] = 2;
            }
            $row = $this->card_package_mdl->aad_package($cart);//领取优惠券
        }
            
        //查询我的卡包
        $data['used'] = $this->card_package_mdl->package($customer_id,1);//已经使用
        $data['not_used'] = $this->card_package_mdl->package($customer_id,2);//未使用
       
        $data['overdue'] = $this->card_package_mdl->package($customer_id,3);//过期
        $data['head_set'] = 3;
        $data["title"] = "我的卡包";
        $this->load->view ( 'head', $data );
        if(!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){//pc
            $this->load->view ( '_header', $data );
        }
        $this->load->view ( 'card_package/package_view', $data );
        if(!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){//pc
            $this->load->view ( '_footer', $data );
            $this->load->view ( 'foot', $data );
        }
    }
    

    // -------------------------------------------------------------------
    
    
    /**
     * 待领取优惠券列表
     */
    public function package(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        $customer_id = $this->session->userdata('user_id');//用户id
        $p_array = $this->card_package_mdl->my_package_all($customer_id,array(1,2));//查询未使用的优惠券
        $p_array = array_column($p_array,"p_id");//未使用的优惠券id
        $data["package"] = $this->card_package_mdl->not_obtained($p_array);//查询未领取的优惠券

        $data['head_set'] = 3;
        $data["title"] = "优惠券";
        $this->load->view ( 'head', $data );
        $this->load->view ( 'card_package/package_list', $data );
    }
    
    
    // -------------------------------------------------------------------
    
    
    /**
     * 点击领取卡包
     * @param int $p_id 卡包id
     */
    public function gain_package(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        $customer_id = $this->session->userdata('user_id');
        $p_id = $this->input->post("id");//卡包id
        //查询卡包并且判断是否存在
        $package = $this->card_package_mdl->get_card_package($p_id,true);
        if($package){
            //判断是否已经领取
            //判断发放时间
            $row = $this->card_package_mdl->receive($p_id,$customer_id);
            if($row){
                $json = array("status"=>1);//已经领取
                echo json_encode($json);return;
            }else if($package["grant_start_at"] > date("Y-m-d")){
                $json = array("status"=>5);//领取时间还没到
                echo json_encode($json);return;
            }else if($package["grant_end_at"] < date("Y-m-d")){
                $json = array("status"=>6);//卡包发放结束
                echo json_encode($json);return;
            }else{
                $this->db->trans_begin();//开启事务
                $row1 = $this->card_package_mdl->subduction($p_id,1);//扣除卡包数量
                if(!$row1){
                    $this->db->trans_rollback();//回滚
                    $json = array("status"=>2);//数量不足
                    echo json_encode($json);return;
                }
                //领取卡包
                $data[0]['p_id'] = $package['id'];
                $data[0]['sender_id'] = $package['customer_id'];
                $data[0]['customer_id'] = $customer_id;
                $data[0]['created_at'] = date("Y-m-d H:i:s");
                $data[0]['status'] = 2;
                $row2 = $this->card_package_mdl->aad_package($data);//领取
                if($row1){
                    $this->db->trans_commit();//提交
                    $json = array("status"=>3);//领取成功
                    echo json_encode($json);return;
                }else{
                    $this->db->trans_rollback();//回滚
                    $json = array("status"=>4);//领取失败
                    echo json_encode($json);return;
                }
            }
        }else{
                $json = array("status"=>4);//领取失败
                echo json_encode($json);return;
        }
        
    }
    
    
    // -------------------------------------------------------------------
    /**
     * (领取卡包 领取优惠券 H5 APP都能领取使用)
     */
   public  function  Receive($p_id=0){
       if(!$p_id){
           echo "<script>history.back(-1);</script>";exit;
       }
       $data['mac_type'] = $this->input->get_post("mac_type");//是否APP访问
       $customer_id = $this->session->userdata('user_id');
       $package = $this->card_package_mdl->check_package($p_id);//查询是否已领取货包详情(package的状态)
       $data['status'] = true;//默认已领取
       if(!$package){
           $data['status'] = false;//未领取
           $package = $this->card_package_mdl->get_card_package($p_id,true);//查询货包审核状态详情(package)
       }
       if(!$package){//货包不存在
           echo "<script>history.back(-1);alert('优惠券不存在');</script>";exit;
       }
       $data['package'] = $package;
       $data['head_set'] = 3;
       $data['title'] = "卡包详情";
       $this->load->view ( 'head', $data );
       $this->load->view ( 'card_package/package_receive', $data );
   }
    
    /**
     * (卡包 H5不能领取 提示要到app领取  使用则APP跟H5都能使用)
     * 卡包详情
     * @param int $p_id 卡包id  $index 首页推荐标记  $mac_type APP访问标记
     */
    public function details($p_id=0,$status=0,$index=0){
        $index = $this->input->get_post("index");//是否首页推荐
        $mac_type = $this->input->get_post("mac_type");//是否APP访问
        
        if(empty($mac_type)){
            //判断是否绑定手机
            if(!$this->is_binding){
                redirect('member/binding/binding_mobile');exit;
            }
            
            if(!$p_id){
                echo "<script>history.back(-1);</script>";exit;
            }
            if(!empty($index)){
                $data["index"] =$index;//H5首页推荐
                $data['package'] = $this->card_package_mdl->check_package($p_id);//查询是否已领取货包详情(package的状态)
                $data["status"] = 1;
                if(!$data['package']){
                    $data["status"] = 0;
                    $data['package'] =$this->card_package_mdl->get_card_package($p_id,true);//查询货包审核状态详情(package)
                }
            }else{//峰哥写的逻辑
                $data["index"] =false;//非H5首页推荐
                if($status==1){//已经领取查询的详情
                    $customer_id = $this->session->userdata('user_id');
                    $data['package'] = $this->card_package_mdl->receive($p_id,$customer_id,true);
                    if( $data['package']){// by tan
                        $data['package'] = $this->card_package_mdl->check_package($p_id);//查询是否已领取货包详情(package的状态)
                    }
                    $data["status"] = 1;
                }else{//未领取查询的详情
                    $data['package'] = $this->card_package_mdl->get_card_package($p_id,true);
                    $data["status"] = 0;
                }
                if(!$data['package']){
                    echo "<script>history.back(-1);</script>";exit;
                }
            }
            $data['mac_type'] = false;
        }else{
            $data['mac_type'] = true;
            if(!empty($index)){
                $data["index"] =$index;//APP首页推荐
            }else{
                $data["index"] =false;//非APP首页推荐
            }
            $data['package'] = $this->card_package_mdl->check_package($p_id);//查询是否已领取货包详情(package的状态)
           
            $data["status"] = 1;
            if(!$data['package']){
                $data["status"] = 0;
                $data['package'] =$this->card_package_mdl->get_card_package($p_id,true);//查询货包审核状态详情(package)
            }
         
        }
       if(!$data['package']){//货包不存在
           redirect("Home");exit;
       }
//         echo '<pre>';
//         print_r($data['package']);exit;
        $data['head_set'] = 3;
        $data['title'] = "卡包详情";
        $this->load->view ( 'head', $data );
        $this->load->view ( 'card_package/package_detail', $data );
    }
    
   

    // ---------------------------------------------------------------------
    
    
    /**
     * 授权我的卡包列表
     */
    public function accredit(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        $customer_id = $this->session->userdata('user_id');
        $data["package"] = $this->card_package_mdl->accredit($customer_id);//查询授权我的卡包
        $data['head_set'] = 3;
        $data['title'] = "发送卡包";
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'card_package/package_accredit_list', $data );
    }
    
    
    // ---------------------------------------------------------------------
    
    
    /**
     * 进入发送卡包
     * @param int $id 卡包id
     */
    public function send_view($id=0){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        $data["package"] = $this->card_package_mdl->get_card_package($id,true);
        if(!$data["package"]){
            echo "<script>history.back(-1);alert('卡包不存在');</script>";exit;
        }
        $data['title'] = "发送卡包";
        $this->load->view ( 'head', $data );
        $this->load->view ( 'card_package/package_send', $data );
    }
    
    
    // ---------------------------------------------------------------------
    
    /**
     * 执行发卡包
     */
    public function send(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        
        $number = $this->input->post("number");
        $id = $this->input->post("id");//卡包id
        $customer_id = $this->session->userdata('user_id');
        if(!$id || $number<1){
            echo "<script>history.back(-1);</script>";exit ;
        }
        //查询判断卡包是否有权限发送
        $package = $this->card_package_mdl->accredit($customer_id,$id);
        if($package){
            $data = array();
            $time = date("Y-m-d H:i:s");
            for($i=0;$i<$number;$i++){
                $data[$i]['p_id'] = $id;
                $data[$i]['sender_id'] = $customer_id;
                $data[$i]['created_at'] = $time;
                $data[$i]['status'] = 4;
            }
            $this->db->trans_begin();//开启事务
            
            $row1 = $this->card_package_mdl->subduction($id,$number);//扣除优惠券数量
            if(!$row1){
                $this->db->trans_rollback();
                echo "<script>history.back(-1);alert('优惠券数量不足');</script>";return ;
            }
            $row2 = $this->card_package_mdl->aad_package($data);//发送
            if($row2){//发送成功
                $this->db->trans_commit();
                $unix = strtotime($time);//把时间转换为时间戳
                $data["id"] = $id;
                $data["headline"] = $package["name"];
                $data["desc"] = $package["describe"];
                $data["url"] = site_url("corporate/card_package/obtain_package/".$id."/".$customer_id."/".$unix);//分享链接
                $this->load->view ( 'head', $data );
                $this->load->view ( 'card_package/share_view', $data );
            }else{
                $this->db->trans_rollback();
                echo "<script>history.back(-1);alert('发送失败');</script>";return ;
            }
        }else{
            echo "<script>history.back(-1);alert('没权限');</script>";return ;
        }
    }
    
    // ---------------------------------------------------------------------


    /**
     * 抢卡包
     * @param $id 卡包id
     * @param $sender_id 卡包发送人id
     * @param $unix 卡包发送时间
     * @param $statu 状态识别领取还是跳转拆卡页面
     */
    public function obtain_package($id=0,$sender_id=0,$unix=0,$statu=0){
        $customer_id = $this->session->userdata('user_id');
        //判断是否绑定手机
        if(!$this->is_binding){
            $customer_id = $this->session->userdata("pre_customer_id");//预绑定id
            if(!$customer_id){
                redirect("Corporate/card_package/enter_mobile/$id/$sender_id/$unix");//跳转输入手机
            }
        }
        
        $created_at = date("Y-m-d H:i:s", $unix);
        $send_total = $this->card_package_mdl->send_num($id,$sender_id,$created_at);//发送卡包总数

        
        //查询卡包并且判断是否存在
        if($created_at){
            //判断是否已领取
            $row = $this->card_package_mdl->receive($id,$customer_id);
            if($row){
                $unix = strtotime($row["created_at"]);
                redirect("corporate/card_package/obtain_package_detail/{$id}/{$row['sender_id']}/{$unix}");//已经领取直接跳转
                return ;
            }else{
                if($statu){//领取
                    $row = $this->card_package_mdl->obtain_package($customer_id,$id,$sender_id,$created_at);//领取卡包
                    redirect("corporate/card_package/obtain_package_detail/{$id}/{$sender_id}/{$unix}");//已经领取直接跳转
                }else{
                    //判断是否领取完
                    $number = $this->card_package_mdl->Complete_progress($id,$sender_id,$created_at,array(1,2));//领取人数
                    if($send_total==$number){//已经领取完成直接跳转
                        redirect("corporate/card_package/obtain_package_detail/{$id}/{$sender_id}/{$unix}");//已经领取完成直接跳转
                    }else{//跳转拆卡包页面
                        if(!$this->is_binding){
                            $this->session->set_userdata ( 'ref_from_url', current_url () );
                            redirect("Corporate/card_package/enter_mobile/$id/$sender_id/$unix");//跳转输入手机
                        }
                        $package = $this->card_package_mdl->get_card_package($id);//优惠券信息
                        $data['sender'] = $this->customer_mdl->load($sender_id);//发送人信息
                        $data['package'] = $package;
                        $data["title"] = "领取货包";
                        $data["url"] = site_url("corporate/card_package/obtain_package/{$id}/{$sender_id}/{$unix}/1");//领取完毕跳转
                        $this->load->view("head",$data);
                        $this->load->view("card_package/open_package",$data);
                    }
                }
                return;
            }
        }else{
            echo "<script>history.back(-1);alert('卡包不存在');</script>";return ;
        }
    }
    
    // ---------------------------------------------------------------------

    /**
     * 卡包领取详情
     * @param int $id 卡包id
     * @param int $send_id 发送人id
     * @param int $unix 发送时间戳
     */
    public function obtain_package_detail($id=0,$sender_id=0,$unix=0){
        $customer_id = $this->session->userdata("user_id");
        //判断是否绑定手机
        if(!$this->is_binding){
            $pre_customer_id = $this->session->userdata("pre_customer_id");//预绑定id
            if($pre_customer_id){
                $customer_id = $pre_customer_id;
            }
        }
        
        $created_at = date("Y-m-d H:i:s",$unix);//转换成2000-01-01 11:00:00格式
        $package = $this->card_package_mdl->get_card_package($id);//优惠券信息
        $data["total"] = $this->card_package_mdl->send_num($id,$sender_id,$created_at);//卡包总数
        if(!$package || !$data["total"]){
            echo "<script>history.back(-1);alert('卡包不存在');</script>";return ;
        }
        
        $data["user"] = $this->card_package_mdl->obtain_package_detail($id,$sender_id,$created_at);//领取用户
        $user_total = count($data["user"]);//领取人数
        
        //判断是否已领取
        $data["is_receive"] = false;//识别是否领取
        $data['is_full'] = false;//是否是否领取完成
        $row = $this->card_package_mdl->receive($id,$customer_id);//查询我当前用户是否领取
        $data["is_use"] = $row["status"]==1?true:false;//是否核销
        if($row){
            $data["is_receive"] = true;
        }else if($data["total"] == $user_total){
            $data['is_full'] = true;
        }else{
            redirect("corporate/card_package/obtain_package/{$id}/{$sender_id}/{$unix}");//领取
        }

        $data["id"] = $row["id"];
        $data['sender'] = $this->customer_mdl->load($sender_id);//发送人信息
        $data["package"] = $package;
        $data["title"] = "货包详情";
        $this->load->view ('head', $data );
        $this->load->view ('card_package/package_obtain_detail', $data );
    }
    
    // ---------------------------------------------------------------------
    
    /**
     * 我的发放记录
     */
    public function send_record(){
        //判断是否绑定手机
        if(!$this->is_binding){
            redirect('member/binding/binding_mobile');exit;
        }
        $customer_id = $this->session->userdata('user_id');
        $data["package"] = $this->card_package_mdl->send_record($customer_id);
        $data['head_set'] = 3;
        $data['title'] = "发放记录";
        $this->load->view ( 'head', $data );
        $this->load->view ( 'card_package/package_send_record', $data );
    }
    
    
    // ------------------------------------------------------------------------
    
    
    /**
     * ajax转赠卡包
     * 因为是分享朋友圈的时候触发，无论成功失败都没有返回值
     * @param int $id 卡包id
     */
    public function give($id){
        $customer_id = $this->session->userdata('user_id');//用户id
        //查询判断卡包是否存在并且是否可以转赠
        $package = $this->card_package_mdl->package($customer_id,2,$id);
        if($package && $package["donation"]==1){
            $row = $this->card_package_mdl->update($package["d_id"]);//转赠优惠券
        }
    }
    
    
    // ------------------------------------------------------------------------
    

    /**
     * 卡包核销
     */
    function sure_verification($id=0){
        $customer_id = $this->session->userdata('user_id');
        $data["title"]= "优惠券核销";
        
        if(in_array($customer_id,array(6770,6765,4175,2933,5413,7335,4456,7267,8049,7394,6538))){
            $row = $this->card_package_mdl->sure_verification($id);
            if($row){
                $data['status'] = "1";//核销成功
                $this->load->view("head",$data);
                $this->load->view("card_package/package_verification",$data);
            }else{
                $data['status'] = "2";//核销失败
                $this->load->view("head",$data);
                $this->load->view("card_package/package_verification",$data);
            }
        }else{
            $data['status'] = "3";//权限不足
            $this->load->view("head",$data);
            $this->load->view("card_package/package_verification",$data);
        }
        
        
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * 进入分享页面
     * @param int $type 类型:1转赠
     * @param int $p_id 货包id
     */
    public function share($type,$p_id,$sender_id=null,$unix=null){
        $customer_id = $this->session->userdata('user_id');
        if($type==1){
            //查询判断卡包是否存在并且是否可以转赠
            $package = $this->card_package_mdl->package($customer_id,2,$p_id);
            if(!$package || $package["donation"] != 1){
                echo "<script>history.back(-1);alert('转赠失败！');</script>";exit;
            }
            $data["id"] = $p_id;
            $data["headline"] = $package["name"];
            $data["desc"] = $package["describe"];
            $unix = strtotime($package["created_at"]);//把时间转换为时间戳
            $data["url"] = site_url("corporate/card_package/obtain_package/".$p_id."/".$package["sender_id"]."/".$unix);//分享链接
        }else{
            echo "<script>history.back(-1);</script>";exit;
        }
        $data["type"] = $type;
        $this->load->view ( 'head', $data );
        $this->load->view ( 'card_package/share_view', $data );
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * 输入手机
     * @param $id 卡包id
     * @param $sender_id 卡包发送人id
     * @param $unix 卡包发送时间
     */
    public function enter_mobile($id=0,$sender_id=0,$unix=0){
        

        //验证数据
        if(!$id || $id < 1){
            echo '<script>history.back(-1);</script>';
        }
        //判断是否绑定手机
        if($this->is_binding){
            redirect("Corporate/card_package/obtain_package/$id/$sender_id/$unix/0");//已经被绑定直接领取
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
        
        $url = site_url("Corporate/card_package/obtain_package/$id/$sender_id/$unix/1");
        $this->session->set_userdata('ref_from_url', $url);
        
        $data["id"] = $id;
        $data['title'] = '51易货网';
        $data['head_set'] = 2;
        $this->load->view ( 'head', $data );
        $this->load->view('card_package/enter_mobile',$data);
//         $this->load->view ( '_footer', $data );
//         $this->load->view ( 'foot', $data );
    }
    
//---------优惠券静态模板加载部分接口-----------------------------------------------------------
    /**
     * H5端后生成静态文件
     */
    public function siteinfo($activity_id){
        $activity_info = $this->card_package_mdl->load_activity($activity_id);
        if(!$activity_info){
            redirect("Home");
        }
        $today = time();
        $start = strtotime($activity_info['activity_start_time']);
        $end = strtotime($activity_info['activity_end_time']);
        if($start > $today ){
            echo '<script>
                 alert("活动还没开始!");
                 window.location.href ="'.site_url("Home").'"
                  </script>';
            exit;
        }else if($end < $today){
            echo '<script>
                 alert("活动已结束!");
                 window.location.href ="'.site_url("Home").'"
                  </script>';
            exit;
        }


        $data['url'] = $activity_info['activity_temp_path'];
	    $data['title'] = '';

	    if(file_exists(FCPATH.UPLOAD_PATH.$data['url']."/ticket_discount.html")){
	    	$this->load->view('card_package/action',$data);
	    }else{
	    	redirect("Home");
	    }
	   
	}
	
	/**
	 * 
	 */
	public function Activity_Api(){
	    $activity_id = $this->input->get_post("id");//活动ID
	    if(!$activity_id){
	        $return['data'] = array(
	            "status"=>1,
	            "Message"=>'参数错误'
	        );
	        echo json_encode($return);
	        exit;
	    }
	    $user_id = $this->session->userdata("user_id");
	    //查询活动信息
	    $activity_info = $this->card_package_mdl->load_activity($activity_id);
	   
	    if(!$activity_info){
	        $return['data'] = array(
	            "status"=>2,
	            "Message"=>'活动不存在'
	        );
	        echo json_encode($return);
	        exit;
	    }
	    //查询活动绑定的优惠券信息
	    $activity_packageInfo = $this->card_package_mdl->load_activity_package($activity_id);
	  
	    if(!$activity_packageInfo){
	        $return['data'] = array(
	            "status"=>3,
	            "Message"=>'该活动还没绑定任何优惠券或商品'
	        );
	        echo json_encode($return);
	        exit;
	    }
	    $time = time();
	    foreach ($activity_packageInfo as $key =>$val){
	        $Package_Id_array = json_decode($val['coupon_item'],true);
	     
	        $Product_url = json_decode($val['product_item'],true);
	        $PackageInfos = $this->card_package_mdl->load_byPackage_Sn($Package_Id_array);
	       
	        if(count($PackageInfos) >0){
	            $coupon_item =[];
	            foreach ($Package_Id_array as $i  =>$v){
	                foreach ($PackageInfos as $ks => $vs){
	                    if($v == $vs['package_sn'] ){
	                        $coupon['package_sn'] = $v;
	                        
	                        $user_package = $this->card_package_mdl->loadByPackage_Sn($v,$user_id);//查询是否已领取货包详情(package的状态)
	                        
	                        //status 1立即领取 2开抢时间3立即使用4今日抢完5已使用
	                        	            
	                        if($user_package && in_array($user_package['status'], array(1,2))){
	                            if($user_package['status']==1){//已使用
	                                $coupon['status'] = 5;
	                            }else if($user_package['status']==2){//未使用
	                                $coupon['status'] = 3;
	                            }
	                        }else{
	                            $number = $this->card_package_mdl->SurplusPackage($vs['id'],4);//统计卡包剩余数量
	                            $end_time = strtotime($vs['grant_end_at']);
	                            if($end_time >= $time){//没过期
	                               if($number['not_number'] >0 ){//库存足够 可以领取
	                                   $start_time = strtotime($vs['grant_start_at']);
	                                   if($start_time <= $time){//到了可以领取的时间
	                                       $coupon['status'] = 1;
	                                   }else{
	                                       $coupon['status'] = 2;
	                                   }
	                               }else{//库存不足
	                                   $coupon['status'] = 4;
	                               }
	                           }else{//已过期
	                               $coupon['status'] = 4;
	                           }
	                        }
	                      
	                        $coupon['start_time'] = date("Y/m/d",strtotime($vs['grant_start_at']));
// 	                        $coupon['start_time_stamp'] = strtotime($vs['grant_start_at']);
	                        $coupon['url'] = site_url("Corporate/card_package/Receive")."/".$vs['id'];
	                        $coupon_item[$i]=$coupon;
	                    }
	                }
	            }
	            if(date('Y-m-d') == $val['model_date']){
	                $model['active'] =1;
	            }else{
	                $model['active'] =0;
	            }
	            
	            $model['model'] = $val['model'];
	            $model['display'] = $val['display'];
// 	            $model['model_date'] =$val['model_date'];
	            $model['coupon_item'] =$coupon_item;
	            $model['product_item'] =$Product_url;
	        }
	        $item[] = $model;
	    }
	    $data['item'] =$item;
	  
	    echo json_encode($data);

	}
	
    
//-----------------------------------------------------------------------------------------    

}