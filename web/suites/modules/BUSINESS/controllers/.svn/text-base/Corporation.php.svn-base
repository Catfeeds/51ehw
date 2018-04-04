<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Corporation extends Front_Controller {
	
	// ------------------------------------------------------------
	/**
	 */
	public function __construct() {
		parent::__construct ();
		
		
		if ( ! $this->session->userdata('user_in') ) {
		    $this->session->set_userdata('ref_from_url', current_url());
		    redirect('customer/login');
		    exit();
		}
	}
	
	
	/**
	 * PC-开店流程必经检测。
	 * @date:2017年12月8日 下午2:53:33
	 * @author: fxm
	 * @param: variable
	 * @return:
	 */
	private function is_authenticate()
	{
	     
	     
	    $result['corp_info'] = array();
	    $result['status'] = false; //1未申请过，2已申请过单资料不完善。
	    $result['module_url'] = '';
	     
	    $this->load->model('corporation_mdl');
	    $customer_id = $this->session->userdata('user_id');
	    $corp_info = $this->corporation_mdl->load($customer_id);
	     
	    //如果是员工不让注册。
	    if( $this->session->userdata("is_staff") )
	    {
	        redirect("Corporate/info/staff_prompt");
	        exit();
	    }
	     
	    if ( empty( $corp_info ) )
	    {
	        // 	        	        redirect('customer/save_step2');    // 未注册企业帐号或者后台删除
	        $result['status'] = 1;
	        $result['redirect'] = 'corporation/shop_choose';
	
	    } elseif ( $corp_info['approval_status'] == null || $corp_info['approval_status'] == 0 ) //// 未绑定
	    {
	        $result['status'] = 2;
	        $result['corp_info'] = $corp_info;
	        $result['redirect'] = 'corporation/shop_choose';
	
	    } else if( $corp_info['approval_status'] == 3 ) //未通过
	    {
	        $result['status'] = 3;
	        $result['corp_info'] = $corp_info;
	        $result['redirect'] = 'corporation/to_examine';
	         
	    } else if ( $corp_info['approval_status'] == 1 ) //审核中
	    {
	        $result['status'] = 4;
	        $result['corp_info'] = $corp_info;
	        $result['redirect'] = 'corporation/to_examine';
	         
	    }else if( $corp_info['approval_status'] == 2 && !$corp_info['is_paied'] ) {  //审核通过 未支付保证金。
	
	        $result['status'] = 5;
	        $result['corp_info'] = $corp_info;
	        $result['redirect'] = 'corporation/to_examine';
	         
	    }else if( !$this->session->userdata ( 'corporation_id' ) )
	    {
	        $url = site_url('Home');
	        echo "<meta charset='utf-8'>
	        <script>alert('请重新登录后，店铺生效')
	        window.location.href='{$url}';
	        </script>";
	        exit();
	
	    }else{
	        
	        //店铺审核通过，已缴纳保证金。
	        $result['status'] = 6;
	        $result['corp_info'] = $corp_info;
	        $result['redirect'] = 'Corporate/info';
	        
	         
// 	        redirect('Corporate/info');
// 	        exit();
	    }
	    
	    return $result;
	     
	    }
	// ------------------------------------------------------------
	
	/**
	 * 显示店铺状态。
	 */
	 public function verify_corp()
	 { 
	     $result = $this->is_authenticate();
	     
	     if( !in_array($result['status'],array( 6 ) ) )
	     {
             redirect($result['redirect']);
             exit();
	     }
	     
	     $status = $result['corp_info']['status'];
	     
	     if( !$status )
	     { 
	         $message = '店铺未生效，请联系客服：400-0029-777';
	         
	     }else if ( $status == 2)
	     { 
	         $message = '店铺已被冻结，请联系客服：400-0029-777';
	         
	     }else { 
	         
	         $this->session->set_userdata( 'corporation_status',$status );
	         redirect($result['redirect']);
	     }
	     
	     
	     $data['title'] = $message;
	     $this->load->view('head', $data);
	     $this->load->view('_header', $data);
	     $this->load->view('customer/reg_step_succ', $data);
	     $this->load->view('_footer', $data);
	     $this->load->view('foot', $data);
	     
	 }
	 
	/**
	 * 开店介绍页面-H5
	 * @date:2017年12月8日 下午2:46:14
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	
	public function shop_benefits()
	{
	    
	    // 微信用户绑定监测
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile") ) {
	        // 如果没有写手机
	        $this->session->set_userdata('ref_from_url', current_url());
	        redirect('member/binding/binding_mobile');
	        return;
	    
	    }
	    
	    $this->load->helper('product');
	    $data['corp_product_list']  = corporation_cash(); //开店类型
	   
	    $data ['title'] = '开店介绍';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ('corporate/shop/cash_shop_introduction');
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}
	
	/**
	 * H5-发起支付选择页面。
	 * @date:2017年12月8日 下午2:52:49
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function shop_pay()
	{
	    
	    $data['pay_info']['cash'] = 10000;
	    $data['pay_info']['transaction_name'] = '缴费开店';
	    $data ['title'] = '缴费开店';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ('corporate/shop/cash_shop_pay');
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}
	
	
	/**
	 * 商家入驻首页
	 * @date:2017年12月12日 下午4:14:29
	 * @author: fxm
	 * @param: variable
	 * @return: view
	 */
	public function home_page()
	{
	    $result = $this->is_authenticate();//检测。
	    
	    if( !in_array($result['status'],array( 1 ) ) )
	    {
	        redirect($result['redirect']);
	        exit();
	    }
	    $data ['title'] = '商家入驻';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	
	    // 初始进入页面限定
	       
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/home_page', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 入驻须知
	 * @date:2017年12月12日 下午4:17:03
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function arrival_guide()
	{
	    
	    $this->load->model('content_mdl');
	    $sift['where']['channel_name'] = '商家入驻';//数量不多就用中文做where条件了。
	    $channel = $this->content_mdl->get_channel($sift);
	     
	     
	    // 获取商家入驻资讯
	    if(!empty( $channel['id']) )
	    {
	        $content_info = $this->content_mdl->get_merchant_content( $channel['id'] );
	         
	    }
	    $data['content_list'] = !empty( $content_info ) ? $content_info : array() ;
	    $data ['title'] = '入驻须知';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/arrival_guide', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	/**
	 * 入驻要求-咨询页面。
	 * @date:2017年12月13日 上午10:53:48
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */

	public function description( $content_id = 0 )
	{ 
	    //TODO::未完成-不清楚显示需求。
	    
	    // 获取商家入驻频道
	    $this->load->model('content_mdl');
	    $sift['where']['channel_name'] = '商家入驻';//数量不多就用中文做where条件了。
	    $channel = $this->content_mdl->get_channel($sift);
	    
	    
	    // 获取商家入驻资讯
	    if( empty( $channel['id']) ) 
	    {
	        echo '<meta charset="utf-8">
                        <script type="text/javascript">
                            alert("暂无数据");
                            history.back();
                        </script>';
            exit();
	        
	    }
	    
	    $content_info = $this->content_mdl->get_merchant_content( $channel['id'] );
	     
	    
	    if( empty( $content_info ) )
	    { 
	         echo '<meta charset="utf-8">
                        <script type="text/javascript">
                            alert("暂无数据");
                            history.back();
                        </script>';
            exit();
	    }
	    
	    $new_content_info = array_column($content_info, NULL,'id');
	    $data['content_info'] = !empty( $new_content_info[$content_id] ) ?  $new_content_info[$content_id] :$content_info[0];
	    
	    $data['content_id'] = !empty( $new_content_info[$content_id] ) ? $content_id : $content_info[0]['id'];
	    $data['content_list'] = $content_info;
	    $data ['title'] = '商家入驻要求';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/rule_page', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	    
	}
	
	
	
   
	
	/**
	 * PC-开店选择。
	 * @date:2017年12月8日 下午3:11:18
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function shop_choose()
	{ 

	   
        $result = $this->is_authenticate();//检测。
        
        if( in_array($result['status'],array( 1,2,3 ) ) )
        { 
            
            //获取开店选择。
            $this->load->helper('product');
            $data['cash_corp_info'] = corporation_cash();
           
            $data['corporation_info'] = $result['corp_info'];
            $data['cor_ind'] = $this->corporation_mdl->cor_ind_info();
            $data ['title'] = '入驻须知';
            $data ['head_set'] = 2;
            $data ['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('merchant/industry', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
            
        }else { 
            
            redirect($result['redirect']);
        }
	}
	
	
	/**
	 * PC-填写公司资料。
	 * @date:2017年12月8日 下午4:33:06
	 * @author: fxm
	 * @param: $Industrial_Info 行业ID  $grade 店铺等级
	 * @return: view
	 */
	public function information( $Industrial_Info = '',$grade = '' )
	{ 
	   
	   
	    //验证行业，店铺等级参数。
	    $this->load->helper('verification');
	    $this->load->helper('product');
	    
	    $corporation_choose = corporation_cash();
	   
	    if( !validateInteger( $Industrial_Info ) || !array_key_exists( $grade, $corporation_choose ) )
	    {
	        redirect('corporation/shop_choose');
	        exit();
	    }
	    
	    $result = $this->is_authenticate();//检测。
	    
	   
	    if( !in_array( $result['status'],array( 1,2,3 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	    
	    
	    $customer_id = $this->session->userdata('user_id');
	    $cash = $corporation_choose[$grade]['cash'];
	    
	    //1.参数验证-是否修改  || 2.添加。
	    do { 
	        
	        $is_true = true;
	         
	        if( !empty ( $result['corp_info'] ) ) 
	        { 
	            
	            if( $result['corp_info']['grade'] != $grade || $result['corp_info']['deposit'] != $cash )
    	        {
    	            //更新等级和保证金。
    	            $this->corporation_mdl->grade = $grade;
    	            $this->corporation_mdl->deposit = $cash;
    	            $this->corporation_mdl->corporation_id = $result['corp_info']['id'];
    	            $is_true = $this->corporation_mdl->update();
    	        }
    	        
    	        if( $result['corp_info']['Industrial_Info'] != $Industrial_Info )
    	        {
    	            //更新行业。
    	            $this->load->model('Corporation_detail_mdl');
    	            $this->Corporation_detail_mdl->Industrial_Info = $Industrial_Info;
    	            $this->Corporation_detail_mdl->corporation_id = $result['corp_info']['id'];
    	            $this->Corporation_detail_mdl->update();
    	        }
    	        
	        }else{
	            
	            //生成店铺。
	            $is_true = false;
	            
	            //事物开一下，保持detail 和 corp 表数据一致。
	            $this->db->trans_begin();
	            
	            $corp_insert['grade'] =  $grade;
	            $corp_insert['deposit'] =  $cash;
	            $corp_insert['customer_id'] =  $customer_id;
	            $corp_insert['app_id'] =  $this->session->userdata("app_info")["id"];
	            $this->load->model('customer_corporation_mdl');
	            $corp_id = $this->customer_corporation_mdl->create( $corp_insert );
	            
	            if( $corp_id )
	            {
	                //添加corp_detaile 行业信息。
	                $corp_detail['corporation_id'] = $corp_id;//店铺ID
	                $corp_detail['Industrial_Info'] = $Industrial_Info;//行业ID
	                $this->load->model('Corporation_detail_mdl');
	                $corp_detail_id = $this->Corporation_detail_mdl->create_corporation_detail($corp_detail);
	                
	                if( $corp_detail_id )
	                {
	                   $this->db->trans_commit();
	                   $is_true = true;
	                }
	            }
	            
	            if( !$is_true )
	            { 
	                $this->db->trans_rollback();
	            }
	            
	        }
	        
	        
	    }while(0);
	   
	  
	    if( !$is_true )
	    { 
	        //'选择失败，请重试';
	        redirect('corporation/shop_choose');
	        exit;
	    }
	    
	    
	    // 获取省份信息
	    $this->load->model('region_mdl');
	    $data['province'] = $this->region_mdl->provinces();
	    $customer_id = $this->session->userdata('user_id');
	    
	    $data['corporation_info'] = $result['corp_info'];
       
      
	        if(isset($data['corporation_info']['license_province_id']) )
	        {
	            $this->load->model('region_mdl');
	            $data['city_one'] = $this->region_mdl->get_city($data['corporation_info']['license_province_id']);
	           
	        }
	    
	    // 定义法人归属地
	    $data['legal_person_place'] = ['中国大陆', '港澳', '台湾','外籍'];
	    
	    // 获取邀请人
	    if( !empty( $data['corporation_info']['agent_customer_id'] ) )
	    {
	        $agent_customer_id = $data['corporation_info']['agent_customer_id'];
	        $this->load->model('customer_mdl');
	        $customer_info = $this->customer_mdl->load( $agent_customer_id );
	        $data['mobile'] = !empty( $customer_info['mobile'] ) ? $customer_info['mobile'] : '';
	    }
	    
	   
	    $data ['title'] = '公司信息';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/information', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	    
	}
	
	/**
	 * 保存公司资料
	 */
	public function save_corp_info()
	{
	    
	    $result = $this->is_authenticate();//检测。
	    
	    if( !in_array( $result['status'],array( 2,3 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	    
	    $step2_data = $_POST;
	    $date = date('Y-m-d H:i:s');
	    $corporation_id = $result['corp_info']['id'];//店铺id
	    $data['legal_person'] = $step2_data['legal_person'];//法人
	    $data['idcard'] = $step2_data['idcard'];//身份证号码
	    $data['company_registration'] = $step2_data['company_registration'];//工商注册号
	    $data['Registered_Capital'] = $step2_data['Registered_Capital'];//公司注册资本
	    $data['license_type'] = $step2_data['license_type'];//证照类型0:旧版；1:新版
	    
	    if( isset( $data['license_type'] ) && $data['license_type'] == 0  )
	    { 
	        $data['organization_code_num'] = $step2_data['organization_code_num1'].'-'.$step2_data['organization_code_num2'];//组织机构编号
	        $data['organization_date_from'] = $step2_data['organization_date_from'];//组织机构代码证有效开始期
	        $data['organization_date_to'] = $step2_data['organization_date_to'];//组织机构代码证有效结束期
	        $data['tax_number'] = $step2_data['tax_number'];//税务登记证号
	    }
	    $data['license_province_id'] = $step2_data['license_province_id'];//营业执照所在省份ID
	    $data['licecse_city_id'] = $step2_data['license_city_id'];//营业执照所在城市
	    $data['license_address'] = $step2_data['license_address'];//执照详细地址
	    $data['license_range'] = $step2_data['license_range'];//营业执照经营范围
	    $data['license_date_from'] = $step2_data['license_date_from'];//执照有效开始日期
	    $data['license_date_to'] = $step2_data['license_date_to'];//执照有效结束日期
	    $data['is_taxplayer'] = $step2_data['is_taxplayer'];//是否为一般纳税人0:否；1:是
	    $data['legal_person_place'] = $step2_data['legal_person_place'];//法人代表归属地，1-大陆；2-港澳；3-台湾；4-外籍
	    $data['updated_at'] = $date;
	    // 将信息存入店铺详情
	    $this->load->model('corporation_detail_mdl');
	
	    $affect_rows = $this->corporation_detail_mdl->update_corporation_detail($data,$corporation_id);
	    
	    if( !$affect_rows )
	    { 
	        echo json_encode(['code'=>0]);
	        exit;
	    }
	
	    // 将信息保存到店铺表
	    $data_customer['contact_name'] = $step2_data['contact_name'];//联系人
	    $data_customer['contact_mobile'] = $step2_data['contact_mobile'];//联系人手机
	    $data_customer['email'] = $step2_data['email'];//邮箱
	    $tel_num1 = $step2_data['tel_num1'];//区号
	    $tel_num2 = $step2_data['tel_num2'];//电话
	    $data_customer['tel_num'] = $tel_num1.'-'.$tel_num2;//区号-电话
	    $data_customer['corporation_name'] = $step2_data['corporation_name'];//企业名称
	    $data_customer['address'] = $step2_data['address'];//企业所在地
	    $data_customer['tel_num_extension'] = 0;//企业分机号，可选
	    $data_customer['updated_at'] = $date;
	    
	    // 获取邀请人用户id
	    if( $step2_data['sponsor_mobile'] )
	    {
	        $this->load->model('customer_mdl');
	        $res = $this->customer_mdl->load_by_mobile( $step2_data['sponsor_mobile'] );
	        if( $res['id'] )
	        {
	            $data_customer['agent_customer_id'] = $res['id'];
	        }
	    }
	    
	    $this->load->model('customer_corporation_mdl');
	    $affect_rows = $this->customer_corporation_mdl->update_customer_corporation($data_customer,$corporation_id);
	
	    if( !$affect_rows )
	    {
	        echo json_encode(['code'=>0]);
	        exit;
	    }
	    
	    echo json_encode(['code'=>1]);
	
	    // echo json_encode(['code'=>1,'step2_data'=>$step2_data]);
	}
	
	
	/**
	 * 上传资质页面
	 */
	public function qualification()
	{
	    $result = $this->is_authenticate();//检测。
	    
	    if( !in_array( $result['status'],array( 2,3 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	    
	    $data['corporation_info'] = $result['corp_info'];
	   
	    //处理身份证正反面。
	    if ( $data['corporation_info']['idcard_img'] )
	    { 
	        $card_info = explode(';', trim( $data['corporation_info']['idcard_img'],';' ) );
	        
	    }
	   
	    $data['corporation_info']['card_front'] = !empty( $card_info[0] ) ? $card_info[0] : '' ;
	    $data['corporation_info']['card_back']  = !empty( $card_info[1] ) ? $card_info[1] : '' ;
	    
	    $data ['title'] = '上传资质';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/qualification', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	/**
	 * 上传证件。
	 */
	public function save_credential()
	{
	    
	    $result = $this->is_authenticate();//检测。
	     
	    if( !in_array( $result['status'],array( 2,3 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	    
        $this->load->helper("ps_helper");
        $this->load->library('upload');
       
        // 图片 初始化数据
        $save_path = 'uploads/myshop/' . $result['corp_info']['id'] . '/detail/';
        $path = FCPATH.UPLOAD_PATH. $save_path;
        
        //新建文件夹。
        if ( !file_exists($path) )
        {
            mkdirsByPath($path);//创建文件
        }
  
        //配置
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['max_filename'] = '50';
    
        foreach ( $_FILES as $key => $val )
        {
            if( !empty( $val['name'] ) ) 
            {
                $config['file_name'] = $key;
                
                $this->upload->initialize($config);
               
                if( $this->upload->do_upload("{$key}") )
                {
                    $img = $this->upload->data();
                
                    $images[$key] = $save_path.$img['file_name'];
                }
            }
        }
        
       //上传图片-数据处理。
	    //如果有上传图片。
        if( !empty( $images['idcard_img1'] ) || !empty( $images['idcard_img2'] ) )
        { 
            //处理身份证正反面。
            $card_info = !empty( $result['corp_info']['idcard_img'] ) ? explode(';', trim( $result['corp_info']['idcard_img'],';' ) ) : array();
             
            if( isset( $card_info[0] ) )
            {
                $card_front = $card_info[0];
            }
            
            if( isset( $card_info[1] ) )
            {
                $card_back = $card_info[1];
            }
        }
	   
	    //身份证正面。
	    if( !empty( $images['idcard_img1'] ) ) 
	    { 
	        $card_front = $images['idcard_img1'];
	        unset($images['idcard_img1']);
	        
	    }
	    //身份证反面。
	    if( !empty( $images['idcard_img2'] ) )
	    {
	       $card_back  = $images['idcard_img2'];
	       unset($images['idcard_img2']);
	    }
	    
	    $this->load->model('Corporation_detail_mdl');
	    
	    //处理对应的数据，不要根据网页的name直接传模型做处理。
	    if( !empty( $images ) )
	    {
	        
	        
    	    foreach ( $images as $k => $v ) 
    	    { 
    	       $this->Corporation_detail_mdl->$k = $v;
    	    }
    	    
    	    //拼接身份证路径。
    	    if( !empty( $card_front ) )
    	    {
    	        $this->Corporation_detail_mdl->idcard_img = $card_front.';'.$card_back;
    	    }
    	    
	    }
	    
	    $this->Corporation_detail_mdl->regist_date = date('Y-m-d H:i:s');
	    $this->Corporation_detail_mdl->corporation_id = $result['corp_info']['id'];
	    $res = $this->Corporation_detail_mdl->update();
	   
	    //资料完善成功，更新为审核中状态
	    $this->corporation_mdl->approval_status = 1;//审核中
	    $this->corporation_mdl->status = 0;//未生效。
	    $this->corporation_mdl->corporation_id = $result['corp_info']['id'];
	    $row = $this->corporation_mdl->update();
	    
	    
	    redirect('corporation/to_examine');
	    
	
	}
	
	
	// 等待审核
	public function to_examine()
	{
	    $result = $this->is_authenticate();//检测。
	    if( !in_array( $result['status'],array( 3,4,5 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	    
	    $data['approval_status'] = $result['corp_info']['approval_status'];
	    $data['approval_desc'] = $result['corp_info']['approval_desc'];
	    
	    if($data['approval_status'] == 0){
	        $data ['title'] = '未绑定';
	    }elseif($data['approval_status'] == 1){
	        $data ['title'] = '等待审核';
	    }elseif($data['approval_status'] == 2){
	        $data ['title'] = '恭喜您！审核已通过';
	    }else{
	        $data ['title'] = '店铺暂未审核通过';
	    }
	     
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/to_examine', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	
	// 缴纳保证金
	public function online_payment()
	{
	    $result = $this->is_authenticate();//检测。
	    
	    if( !in_array( $result['status'],array( 5 ) ) )
	    {
	        redirect($result['redirect']);
	    }
	       
	    $this->load->helper('product');
	    $product_list = corporation_cash();
	    
	    $data['pay_info'] = $product_list[$result['corp_info']['grade']];
	    
	   
	
	    $data ['title'] = '网上缴费／店铺上线';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('merchant/online_payment', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	
	/**
	 * 通用保证金支付成功以后返回的通知页面。
	 * $charge_id //预留充值ID。
	 * $status = 0;//预留
	 */
	public function pay_notify( $status = 1, $charge_id = 0 )
	{ 
	     
	    if( $status == 2 )
	    { 
	        $data["message"] = '支付失败,联系客服 400-0029-777';
	        
	    }else if ( $status == 3 )
	    { 
	        $data["message"] = '验证失败,联系客服 400-0029-777';
	        
	    }else{ 
	        $data["message"] = '开店成功，请重新登录后生效';
	    }
	    
	    
	    $data["code"] = $status;
	    $data["orderid"] = $charge_id;
	    $data ['title'] = '支付结果';
	    $data ['head_set'] = 3;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view('merchant/pay_notify',$data);
	    $this->load->view ( 'foot', $data );
	}
	
	/**
	 * 邀请人校验
	 */
	public function ajax_check_mobile()
	{
	    $mobile = $this->input->post('mobile');
	
	    if($mobile){
	        $this->load->model('customer_mdl');
	        $result = $this->customer_mdl->load_by_mobile($mobile);
	
	        if($result){
	            echo json_encode(['code'=> 1, 'msg' => '通过']);
	        }else{
	            echo json_encode(['code'=> 0, 'msg' => '邀请人必须是51易货网注册用户']);
	        }
	    }
	
	
	}
	
	// 查找市级信息
	function city()
	{
	    $province_id = $this->input->post('province_id');
	    if(isset($province_id) && $province_id != ''){
	        $this->load->model('region_mdl');
	        $city = $this->region_mdl->get_city($province_id);
	        echo json_encode(['code'=>1, 'data'=>$city]);
	    }
	}
	
	
	/**
	 * 支付开店金额成功后，完善资料页面。
	 * @date:2017年11月7日 下午4:51:15
	 * @author: fxm
	 * @return: view
	 */
// 	public function Edit_Corp_Info()
// 	{
// 	    if ( !$this->session->userdata('user_in') )
// 	    {
// 	        redirect('customer/login');
// 	        exit();
// 	    }
	     
// 	    $customer_id = $this->session->userdata('user_id');
	     
// 	    $sift['where']['customer_id'] = $customer_id;
// 	    $this->load->model('Cash_shop_mdl');
// 	    $cash_shop_info = $this->Cash_shop_mdl->Load( $sift );
	     
// 	    //是否有开店记录。
// 	    if( $cash_shop_info )
// 	    {
// 	        $data['status'] = $cash_shop_info['status'];//根据状态显示不同的页面。
// 	        $data['cas_shop_id'] = $cash_shop_info['id'];
// 	        $data['title'] = '完善资料';
// 	        $data['head_set'] = 2;
// 	        $datas['foot_set'] = 1;
// 	        $this->load->view ( 'head', $data );
// 	        $this->load->view ( '_header', $data );
// 	        // 	        $this->load->view ( 'customer/rebate', $data );
// 	        $this->load->view ( '_footer', $data );
// 	        $this->load->view ( 'foot', $data );
	         
// 	    }else{
	
// 	        echo "<script>history.back(-1);alert('暂无记录，如支付成功，请稍后再试');</script>";exit;
// 	        //暂无记录，如支付成功，请稍后再试。
// 	    }
	     
// 	}
	
	/**
	 * 开店-完善资料。
	 * @date:2017年11月7日 下午4:43:08
	 * @author: fxm
	 * @param: array post键值对数据
	 * @return: json
	 */
// 	public function Update_Cash_Shop()
// 	{
// 	    //接收信息。
// 	    $corporation_name = $this->input->post('corporation_name');//店铺名称
// 	    $contact = $this->input->post('contact');//联系人姓名
// 	    $mobile = $this->input->post('mobile');//手机号码。
	     
// 	    do{
// 	        //验证登录。
// 	        if ( !$this->session->userdata('user_in') )
// 	        {
// 	            $return = array('status'=>255,'message' => '您的登录信息过期');
// 	            break;
// 	        }
	         
// 	        $customer_id = $this->session->userdata('user_id');//用户登录ID
// 	        $this->load->helper('verification');//加载正则验证方法。
	         
// 	        if( !$corporation_name || !$contact || !checkMobile( $mobile ) )
// 	        {
// 	            $return = array('status'=>254,'message' => '参数错误');
// 	            break;
// 	        }
	         
// 	        //查询充值成功后写入开店记录的信息。
// 	        $sift['where']['customer_id'] = $customer_id;
// 	        $sift['where']['status'] = 0;
// 	        $this->load->model('Cash_shop_mdl');
// 	        $cash_shop_info = $this->Cash_shop_mdl->Load( $sift );
	         
// 	        if( !$cash_shop_info  || empty( $cash_shop_info['corporation_id'] ) )
// 	        {
// 	            $return = array('status'=>3,'message' => '您无权更新');
// 	            break;
// 	        }
	         
// 	        //更新店铺资料。
// 	        $this->load->model('Corporation_mdl');
// 	        $this->Corporation_mdl->corporation_name = $corporation_name;
// 	        $this->Corporation_mdl->contact_name = $contact;
// 	        $this->Corporation_mdl->contact_mobile = $mobile;
// 	        $this->Corporation_mdl->corporation_id = $cash_shop_info['corporation_id'];
// 	        $row = $this->Corporation_mdl->update();
	         
// 	        if( !$row )
// 	        {
// 	            $return = array('status'=>2,'message' => '更新失败');
// 	            break;
// 	        }
	         
// 	        //更新记录为--已完善资料。
// 	        $set_data['set']['status'] = 1;
// 	        $set_data['where']['id'] = $cash_shop_info['id'];
// 	        $set_data['where']['customer_id'] = $cash_shop_info['customer_id'];
// 	        $shop_row = $this->Cash_shop_mdl->Update( $set_data );
	
// 	        if( !$shop_row )
// 	        {
// 	            $return = array('status'=>2,'message' => '更新失败');
// 	            break;
// 	        }
	         
// 	        $return = array('status'=>1,'message' => '更新成功');
	         
// 	    }while(0);
	     
	
// 	    echo json_encode( $return );
// 	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */