<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tribe extends Api_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("tribe_mdl");
		$this->load->model("customer_mdl");
	}
	
	public function index()
	{
		echo 'Tribe API';
	}
	
	//---------部落首页接口------------
	
	/**
	 * 部落列表
	 */
	public function tribe_list(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
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
	    //我的部落
	    $mytribe = $this->tribe_mdl->MyTribe($user_id,1);
	    $return['data'] = $mytribe;
	    print_r(json_encode($return));
	}
	
	/**
	 * 部落首页  公告,部落,部落活动
	 * @param tribe_id
	 */
	public function Home(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		
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
		
		$tribe_id = isset($prams['tribe_id']) && $prams['tribe_id'] ? $prams['tribe_id']:0;
		
		if(!$tribe_id){
			$this->load->model('Tribe_content_mdl');
			$sift['where']['customer_id'] = $user_id;
			
			
			//部落公告
			$data = $this->Tribe_content_mdl->Load_List( $sift );
			if(!empty($data)){
				foreach ($data as $key =>$val){
					$list[$key]['id'] = $val['id'];
					$list[$key]['title'] = $val['title'];
					$list[$key]['content'] = $val['content'];
					$list[$key]['title_img'] = $val['title_img'];
					$list[$key]['url'] =  site_url("Tribe/announcement_detaile/").'/'.$val['id'].'/0/1';
				}
			}else{
				$list= $data;
			}
			//我的部落
			$mytribe = $this->tribe_mdl->MyTribe($user_id,1);
			
			//活动
			$this->load->model('Tribe_activity_mdl');
			// 	    $sift['return_row'] = true;
			$sift['page']['limit']  = 0;
			$sift['page']['offset']  = 4;
			$activities = $this->Tribe_activity_mdl->Load( $sift );
			
		    foreach ($activities as $key => $val){
		        unset($activities[$key]['content']);
		    }
			
			$return['data']['apply_info'] = $this->Tribe_activity_mdl->Load_Tribe_activity();
			
			
			//全平台+已经入的部落的最新一条活动记录
			$new_activity['where']['customer_id'] = $user_id;
			$new_activity['where']['type'] = 0;
			$return['data']['single_activity'] = $this->Tribe_activity_mdl->Load_new_activity( $new_activity );
			
			//全平台+已经入的部落的最新一条公告
			$announcement_sift['where']['customer_id'] = $user_id;
			$announcement_sift['sql_status'] = 'result_array';
			$data['announcement_list'] = $this->Tribe_content_mdl->Load_new_content( $announcement_sift );
			$return['data']['single_announcement'] = !empty( $data['announcement_list'][0] ) ? $data['announcement_list'][0] : array();
			
			
			$return['data']['single_topic'] = NULL;
			if($mytribe){
			    $topic['where']['tribe_id'] = array_column($mytribe, 'id');
			    $topic['where']['customer_id'] = $user_id;
			    $topic['return_row'] = true;
			    $this->load->model('Tribe_topic_mdl');
			    $return['data']['single_topic'] = $this->Tribe_topic_mdl->Load( $topic,true );
			    
			    if($return['data']['single_topic'] )
			    {
			        $return['data']['single_topic']['upvote_info']  =  $this->Tribe_topic_mdl->topic_upvote_member_name($return['data']['single_topic']['id']);
			    }
			}
			
			//查询新的部落消息通知
			$new_message = $this->tribe_mdl->Load_Tribe_Message( $user_id );
			$return['data']['single_message'] = NULL;
			if( $new_message )
			{
			   
			    $return['data']['single_message'] = $new_message;
			    $return['data']['single_message']['message'] =  str_replace( array('<!--','-->'),array('',''), $new_message['message'] );
			}
			
			
			//通知
			//         $this->load->model('Customer_message_mdl');
			//         $not_read = $this->Customer_message_mdl->Count_Num( $sift )['not_read'];
			//         $return['data']['not_read_message'] = $not_read;
		}else{
			$mytribe = $this->tribe_mdl->load( $tribe_id,$user_id );//查询部落
			if(!$mytribe){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '部落不存在'
				);
				print_r(json_encode($return));
				exit();
			}
			
			if($mytribe['tribe_staff_id'] && $mytribe['status'] == 2){
				
				$mytribe['bg_img'] = explode(';',$mytribe['bg_img']);
				$mytribe['bg_img'] = array_filter($mytribe['bg_img']);
				
				//部落内的公告
				$sift['where']['customer_id'] = $user_id;
				$sift['where']['tribe_id'] = $tribe_id;
				$sift['sql_status'] = true;
				
				//部落活动
				$this->load->model('Tribe_activity_mdl');
				$activities = $this->Tribe_activity_mdl->Load( $sift );
				foreach ($activities as $key => $val){
					$activities[$key]['tr_name'] = $mytribe['name'];
					$activities[$key]['logo'] = $mytribe['logo'];
				}
				
				
				$this->load->model('Tribe_content_mdl');
				$list = $this->Tribe_content_mdl->Load_List( $sift );
				foreach ($list as $key =>$val){
					$list[$key]['url'] = site_url("Tribe/announcement_detaile/").'/'.$val['id'].'/'.$tribe_id;
				}
			}else{
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '8',
						'errorMessage' => '尚未加入该部落'
				);
				print_r(json_encode($return));
				exit();
			}
		}
		
// 		$this->load->model("tribe_mdl");
// 		$tribe = $this->tribe_mdl->get_MyTribe($user_id);//查询我创建的部落
// 		$return['data']['tribe_create_status'] = $tribe?$tribe["status"]:0;//0未创建1待审核2通过3不通过
		
		
		$return['data']['announcement'] = $list;
		$return['data']['tribe'] = $mytribe;
		$return['data']['activities'] = $activities;
		print_r(json_encode($return));
	}
	
	/**
	 * 推荐部落列表
	 */
	public function  recommended_tribe_list(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$tribe_list = $this->tribe_mdl->hot_tribe( $user_id );//查询推介部落
		foreach ($tribe_list as $key => $val){
			$bg_img = explode(';',$val['bg_img']);
			$bg_img = array_filter($bg_img);
			$tribe_list[$key]['bg_img'] = $bg_img;
		}
		
		$return['data'] = $tribe_list;
		print_r(json_encode($return));
	}
	
	/**
	 * 置顶部落
	 */
	public function  sort_tribe(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    $label_id = $this->session->userdata("label_id");
	    
	    $tribe_id  = isset($prams['tribe_id']) ?$prams['tribe_id'] :0;
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    if(!$tribe_id){
	        //我的部落
    	     if($label_id){
    	           $this->load->model("App_label_mdl");
    	           //将二级标签下部落全部拿出来堆放在一起方便进行处理
    	           $label_infos = $this->App_label_mdl->Load_tribe_app_label($label_id);//获取标签信息
    	           $app_tribe_id = '';
    	           foreach ($label_infos as $key =>$val ){
    	               $app_tribe_id = trim($app_tribe_id,",");
    	               $app_tribe_id .= ','.$val['tribe_ids'];
    	           }
    	           $ids = explode(',',$app_tribe_id);//字符串转数组
    	           $app_tribe_ids = array_unique($ids);
    	           $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
    	       }else{
    	           //我的部落
    	           $mytribe = $this->tribe_mdl->MyTribe($customer_id,1);
    	       }
	        $return['data'] = $mytribe;
	        print_r(json_encode($return));
	        exit;
	    }
	    $sort_info = $this->tribe_mdl->load_tribe_sort($customer_id,$tribe_id);
	     
	    if(!$sort_info){//没有则添加
	        $this->tribe_mdl->add_tribe_sort($customer_id,$tribe_id);
	        //1;//置顶
	        $row = $this->tribe_mdl->sort_tribe(1,$customer_id,$tribe_id);
	        if($row){
	            $return['responseMessage'] = array(
	                'messageType' => 'success',
	                'errorType' => '0',
	                'errorMessage' => '置顶成功'
	            );
	        }else{
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '6',
	                'errorMessage' => '置顶失败'
	            );
	        }
	        print_r(json_encode($return));
	        exit;
	    }
	    
	    
	    if($sort_info['sort'] == 0){
	        $sort = 1;//置顶
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '6',
	            'errorMessage' => '置顶失败'
	        );
	    }else{
	        $sort = 0;//取消置顶
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '7',
	            'errorMessage' => '取消置顶失败'
	        );
	    }
	    $row = $this->tribe_mdl->sort_tribe($sort,$customer_id,$tribe_id);
	
	    if($row){
	        if($sort){
	            $return['responseMessage'] = array(
	                'messageType' => 'success',
	                'errorType' => '0',
	                'errorMessage' => '置顶成功'
	            );
	          
	        }else{
	            $return['responseMessage'] = array(
	                'messageType' => 'success',
	                'errorType' => '0',
	                'errorMessage' => '取消置顶成功'
	            );
	        }
	        
	      
	       if($label_id){
	           $this->load->model("App_label_mdl");
	           //将二级标签下部落全部拿出来堆放在一起方便进行处理
	           $label_infos = $this->App_label_mdl->Load_tribe_app_label($label_id);//获取标签信息
	           $app_tribe_id = '';
	           foreach ($label_infos as $key =>$val ){
	               $app_tribe_id = trim($app_tribe_id,",");
	               $app_tribe_id .= ','.$val['tribe_ids'];
	           }
	           $ids = explode(',',$app_tribe_id);//字符串转数组
	           $app_tribe_ids = array_unique($ids);
	           $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
	       }else{
	           //我的部落
	           $mytribe = $this->tribe_mdl->MyTribe($customer_id,1);
	       }
	       $return['data'] = $mytribe;
	       
	    }
	    
	   print_r(json_encode($return));
	}
	
	/**
	 * 部落详情
	 */
	public function tribe_detail(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		$tribe_id  = $prams['tribe_id'];
		$tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
		if(!$tribe_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '部落不存在'
			);
			print_r(json_encode($return));
			exit();
		}
		//更新用户最新浏览部落时间
		$customer_id = $this->session->userdata("user_id");//用户id
		
		$sort_info = $this->tribe_mdl->load_tribe_sort($customer_id,$tribe_id);
		if(!$sort_info){
		    $this->tribe_mdl->add_tribe_sort($customer_id,$tribe_id);
		}
		$this->tribe_mdl->record_tribe_time($customer_id,$tribe_id);
		
		$bg_img = explode(';',$tribe_info['bg_img']);
		$bg_img = array_filter($bg_img);
		$tribe_info['bg_img'] = array();
		foreach ($bg_img as $key => $val){
			array_push($tribe_info['bg_img'], $val);
		}
		
		
		$tribe_info['show_home'] = 0;
		$tribe_detail = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if($tribe_detail){
		    $tribe_info['show_home'] = 1;
		}
		
		$return['data'] = $tribe_info;
		print_r(json_encode($return));
	}
	
	
	
	/**
	 * 部落商城商品
	 */
	
	public  function  tribe_product(){
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
		$this->_check_prams($prams, array(
				'tribe_id',
				'type'  //排序类型1全部商品价格DESC2最新3共享服务4全部商品价格ASC
		));
		$tribe_id  = $prams['tribe_id'];
		$type  = $prams['type'];
		
		if(!in_array($type,array(1,2,3,4))){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '4',
					'errorMessage' => '排序参数有误'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$appid = $this->session->userdata("app_info")['id'];//分站点id
		$totalcount =  $this->tribe_mdl->loading_goods($tribe_id,$appid,0,0,$type,true);
		
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
		
		$listdate = $this->tribe_mdl->loading_goods($tribe_id,$appid,$perPage,$offset,$type);//商品列表
		
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] =$listdate;
		
		print_r(json_encode($return));
	}
	
	/**
	 * 搜索某部落下的商品
	 */
	public function search_product(){
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
		$this->_check_prams($prams, array(
				'tribe_id',
				'keyword'
		));
		
		$tribe_id = $prams['tribe_id'];
		$keyword = $prams['keyword'];
		$appid = $this->session->userdata("app_info")['id'];//分站点id
		
		$keyword_array = array();
		$keyword_array[] = $keyword;
		
		$this->load->model("goods_mdl");
		
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		$type = 1;//销量
		$totalcount = $this->goods_mdl->get_productFour($tribe_id,$keyword_array,0,0,$type,0,0);
		
		$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
		
		$productList = $this->goods_mdl->get_productFour($tribe_id,$keyword_array,$perPage,$offset,$type,0,0);//查询商品
		
		// 返回数据
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] = $productList;
		
		print_r(json_encode($return));
	}
	
	/**
	 * 部落公告
	 */
	public function Announcement_list(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		//         $this->_check_prams($prams, array(
		//             'tribe_id'
		//         ));
		$tribe_id = isset($prams['tribe_id']) ? $prams['tribe_id']:0;
		$user_id = $this->session->userdata('user_id');
		///查询公告
		$sift['where']['customer_id'] = $user_id;
		if($tribe_id){
			$sift['where']['tribe_id'] = $tribe_id;
			$sift['sql_status'] =  true ;
		}else{
			$sift['sql_status'] = false;
		}
		$this->load->model('Tribe_content_mdl');
		$announcement_list = $this->Tribe_content_mdl->Load_List( $sift );
		
		foreach ($announcement_list as $key =>$val){
			if($tribe_id){
				$announcement_list[$key]['url'] = site_url("Tribe/announcement_detaile/").'/'.$val['id'].'/'.$tribe_id;
			}else{
				$announcement_list[$key]['url'] = site_url("Tribe/announcement_detaile/").'/'.$val['id'];
			}
			
		}
		$return['data'] =$announcement_list;
		print_r(json_encode($return));
	}
	
	
	/**
	 * 部落活动
	 */
	public  function Activity_list(){
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
		//        // 检验参数
		//        $this->_check_prams($prams, array(
		//            'tribe_id'
		//        ));
				$tribe_id = isset($prams['tribe_id']) ? $prams['tribe_id']:0;
				
				$this->load->model('Tribe_activity_mdl');
				$user_id = $this->session->userdata("user_id");//用户id
				if($tribe_id){
					$sift['where']['tribe_id'] = $tribe_id;
					$sift['sql_status'] = true;
				}
				$sift['where']['customer_id'] = $user_id;
				$totalcount = count($list = $this->Tribe_activity_mdl->Load( $sift ));// 获取总记录数
				
				
				$perPage = $page['perPage']; // 每页记录数
				$currPage = $page['currPage']; // 当前页
				$offset = ($currPage - 1) * $perPage; // 偏移量
				$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
				
				$sift['page']['limit']  = $perPage;
				$sift['page']['offset']  = $offset;
				$listdate = $this->Tribe_activity_mdl->Load( $sift );
				
				// 返回数据
				$return['data']['perpage'] = $perPage;
				$return['data']['currentpage'] = $currPage;
				$return['data']['totalcount'] = $totalcount;
				$return['data']['totalpage'] = $totalpage;
				$return['data']['listdate'] = $listdate;
				
				print_r(json_encode($return));
	}
	
	/**
	 * 检查部落活动 返回跳转连接 跳到H5
	 */
	public function check_activity(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id'
		));
		$id  = $prams['id'];
		
		$user_id = $this->session->userdata("user_id");//用户id
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		$sift['where']['id'] = 0 == $id ? 0 : $id;
		$sift['where']['customer_id'] = $user_id;
		$this->load->model('Tribe_activity_mdl');
		
		$activity_info = $this->Tribe_activity_mdl->Load_Activity( $sift );
		
		if(!$activity_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '该活动不存在'
			);
			print_r(json_encode($return));
			exit();
		}
		//是否公开
		if($activity_info['display'] == 0){
		    
		    if ( $activity_info && $activity_info['tribe_id'] != -1 )
		    {
		        //查询是否有资格参加
		        $tr_info = $this->tribe_mdl->is_tribe_customer( $activity_info['tribe_id'], $user_id );
		        if( !$tr_info )
		        {
		            $return['responseMessage'] = array(
		                'messageType' => 'error',
		                'errorType' => '5',
		                'errorMessage' => '您尚未加入该部落，无法查看该部落中的活动'
		            );
		            print_r(json_encode($return));
		            exit();
		        }
		    }
		}
		
		$return['data']['url']= site_url("Tribe/activity_detaile")."/".$activity_info['id'].'?mac_type=APP';
		print_r(json_encode($return));
	}
	
	
	/**
	 * 部落成员列表
	 */
	public function tribe_memberList(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];
		$like['keyword'] = isset($prams['keyword']) ? $prams['keyword']:'';
		$user_id = $this->session->userdata("user_id");//用户id
		
		$user_info = $this->tribe_mdl->load_members_list( $tribe_id, $user_id );//查询部落
		
		if(!$user_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '您尚未加入该部落，无法查看该部落中的成员信息'
			);
			print_r(json_encode($return));
			exit();
		}
		//部落角色
		$tribe_duties_list = $this->tribe_mdl->load_members_duties( $tribe_id,$like );
		
		//成员
		$list = $this->tribe_mdl->load_members_list( $tribe_id,0,$like );
		
		$new_list = array();
		
		$is_Manager = 1;//是否管理员
		$number = 1;//记录条数
		$Manager = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//管理员
		
		$is_Manager = 0;
		$Member = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//部落成员
		
		if($Manager || $Member){
		    $is_Manager = 1;
		}
		//我
		$user['id']= '0';
		$user['total']= '1';
		$user['role_name']= '我';
		$info =array(
				'id' => $user_info['id'],
				'customer_id' => $user_info['customer_id'],
				'corp_status' =>$user_info['approval_status'],
				'corp_id' => $user_info['corp_id'],
				'corporation_name' => $user_info['corporation_name'],
				'duties' => $user_info['duties'],
				'logo' =>!empty($user_info['brief_avatar']) ? IMAGE_URL.$user_info['brief_avatar']:$user_info['wechat_avatar'],
		        'is_host' => $user_info['is_host'],
		        'tribe_manager_id' => $user_info['tribe_manager_id'],
		        'remain' => $is_Manager,
		);
		if($user_info['real_name']){
			$info['member_name'] =  $user_info['real_name'];
		}else if($user_info['member_name']){
			$info['member_name'] = $user_info['member_name'];
		}else{
			$info['member_name'] = $user_info['mobile'];
		}
		
		$user['list'][]= $info;
		$new_list[] = $user;
		
		if($tribe_duties_list && count($tribe_duties_list) > 0){
		    //处理数据
		    foreach ($tribe_duties_list as $key => $val )
		    {
		        foreach ( $list as $k=>$v)
		        {
		            if( $val['id'] == $v['tribe_role_id'] ) //有角色
		            {
		                	
		                $lists['id'] =  $v['id'];
		                $lists['customer_id'] =  $v['customer_id'];
		                $lists['corp_id'] =  $v['corp_id'];
		                $lists['corp_status'] =  $v['approval_status'];//'企业审核 0:未绑定 1:审核中 2:通过 3:不通过'
		                if($v['real_name'] ){
		                    $lists['member_name'] =  $v['real_name'];
		                }else if($v['member_name']){
		                    $lists['member_name'] = $v['member_name'];
		                }else{
		                    $lists['member_name'] = substr_replace($v['mobile'],'********',2,8);
		                }
		                $lists['corporation_name'] =  $v['corporation_name'];
		                $lists['duties'] =  $v['duties'];
		                if(!empty($v['brief_avatar'])){
		                    $lists['logo'] = IMAGE_URL.$v['brief_avatar'];
		                }else{
		                    $lists['logo'] = $v['wechat_avatar'];
		                }
		                $lists['is_host'] =  $v['is_host'];
		                $lists['tribe_manager_id'] =  $v['tribe_manager_id'];
		                	
		                //邀请状态
		                if(!empty( $_COOKIE['invite_dx_Customer_'.$v['mobile']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['mobile']])){
		                    $lists['invite_dx'] = "1";
		                }else{
		                    $lists['invite_dx'] = "0";
		                }
		                if(!empty( $_COOKIE['invite_dx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['id']])){
		                    $lists['invite_dx'] = "1";
		                }else{
		                    $lists['invite_dx'] = "0";
		                }
		                if(!empty( $_COOKIE['invite_wx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_wx_Corp_'.$v['id']])){
		                    $lists['invite_wx'] = "1";
		                }else{
		                    $lists['invite_wx'] = "0";
		                }
		                	
		                //                    $remain_guarantee_price = $v['remain_guarantee_price']/10000;
		                //                    $v['remain_guarantee_price'] = $remain_guarantee_price."";
		                $tribe_duties_list[$key]['list'][] = $lists;
		            }
		        }
		        $new_list[] = $tribe_duties_list[$key];
		    }
		    
		    
		}
		
		foreach ( $list as $k=>$v){
		    if(!$v['tribe_role_id'] || $v['tribe_role_id'] == NULL){
		            //没有角色的人
		           
		            $infos['id'] =  $v['id'];
		            $infos['customer_id'] =  $v['customer_id'];
		            $infos['corp_id'] =  $v['corp_id'];
		            $infos['corp_status'] =  $v['approval_status'];//'企业审核 0:未绑定 1:审核中 2:通过 3:不通过'
		            if($v['real_name'] ){
		                $infos['member_name'] =  $v['real_name'];
		            }else if($v['member_name']){
		                $infos['member_name'] = $v['member_name'];
		            }else{
		                $infos['member_name'] = substr_replace($v['mobile'],'********',2,8);
		            }
		            $infos['corporation_name'] =  $v['corporation_name'];
		            $infos['duties'] =  $v['duties'];
		            if(!empty($v['brief_avatar'])){
		                $infos['logo'] = IMAGE_URL.$v['brief_avatar'];
		            }else{
		                $infos['logo'] = $v['wechat_avatar'];
		            }
		            $infos['is_host'] =  $v['is_host'];
		            $infos['tribe_manager_id'] =  $v['tribe_manager_id'];
		            //邀请状态
		            if(!empty( $_COOKIE['invite_dx_Customer_'.$v['mobile']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['mobile']])){
		                $infos['invite_dx'] = "1";
		            }else{
		                $infos['invite_dx'] = "0";
		            }
		            if(!empty( $_COOKIE['invite_dx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['id']])){
		                $infos['invite_dx'] = "1";
		            }else{
		                $infos['invite_dx'] = "0";
		            }
		            if(!empty( $_COOKIE['invite_wx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_wx_Corp_'.$v['id']])){
		                $infos['invite_wx'] = "1";
		            }else{
		                $infos['invite_wx'] = "0";
		            }
		            $member[] = $infos ;
		    }
		}
		
		if(isset($member) && count($member) > 0){
		    $no_role['id']= '0';
		    $no_role['total']= count($member);
		    $no_role['role_name']= '部落成员';
		    $no_role['list'] = $member;
		    $new_list[] = $no_role;
		}
		
		$return['data'] = $new_list;
		print_r(json_encode($return));
	}
	
	
	/**
	 * 搜索部落成员
	 * @param int tribe_id  部落ID
	 * @param str keyword  关键字
	 */
	public function search_member(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'keyword'
		));
		$tribe_id = $prams['tribe_id'];
		$keyword = $prams['keyword'];
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if(!$user_id || $user_id == ''){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$user_info = $tribe_id ? $this->tribe_mdl->load_members_list( $tribe_id, $user_id ) : 0;//查询部落
		
		if( !$user_info )
		{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '您不是该部落成员'
			);
			print_r(json_encode($return));
			exit();
		}
		$like['member_name'] =$keyword;
		$tribe_duties_list = $this->tribe_mdl->load_members_duties( $tribe_id,$like );
		
		$list = $this->tribe_mdl->load_members_list( $tribe_id,0,$like );
		
	   
		if($tribe_duties_list && count($tribe_duties_list) > 0){
		    //处理数据
		    foreach ($tribe_duties_list as $key => $val )
		    {
		        	
		        foreach ( $list as $k=>$v)
		        {
		            if( $val['id'] == $v['tribe_role_id'] )
		            {
		                $lists['id'] =  $v['id'];
		                $lists['customer_id'] =  $v['customer_id'];
		                $lists['corp_id'] =  $v['corp_id'];
		                	
		                $lists['corp_status'] =  $v['approval_status'];//'企业审核 0:未绑定 1:审核中 2:通过 3:不通过'
		                //                        $lists['corp_status'] =  $v['corp_status'];//是否冻结
		                if($v['real_name'] ){
		                    $lists['member_name'] =  $v['real_name'];
		                }else if($v['member_name']){
		                    $lists['member_name'] = $v['member_name'];
		                }else{
		                    $lists['member_name'] = substr_replace($v['mobile'],'********',2,8);
		                }
		                	
		                $lists['corporation_name'] =  $v['corporation_name'];
		                $lists['duties'] =  $v['duties'];
		                if(!empty($v['brief_avatar'])){
		                    $lists['logo'] = IMAGE_URL.$v['brief_avatar'];
		                }else{
		                    $lists['logo'] = $v['wechat_avatar'];
		                }
		                	
		                //邀请状态
		                if(!empty( $_COOKIE['invite_dx_Customer_'.$v['mobile']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['mobile']])){
		                    $lists['invite_dx'] = "1";
		                }else{
		                    $lists['invite_dx'] = "0";
		                }
		                if(!empty( $_COOKIE['invite_dx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['id']])){
		                    $lists['invite_dx'] = "1";
		                }else{
		                    $lists['invite_dx'] = "0";
		                }
		                if(!empty( $_COOKIE['invite_wx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_wx_Corp_'.$v['id']])){
		                    $lists['invite_wx'] = "1";
		                }else{
		                    $lists['invite_wx'] = "0";
		                }
		                	
		                $tribe_duties_list[$key]['list'][] = $lists;
		            }
		    
		        }
		    }
		}
		
		foreach ( $list as $k=>$v){
		    if(!$v['tribe_role_id'] || $v['tribe_role_id'] == NULL){
		        //没有角色的人
		        $infos['id'] =  $v['id'];
		        $infos['customer_id'] =  $v['customer_id'];
		        $infos['corp_id'] =  $v['corp_id'];
		        $infos['corp_status'] =  $v['approval_status'];//'企业审核 0:未绑定 1:审核中 2:通过 3:不通过'
		        if($v['real_name'] ){
		            $infos['member_name'] =  $v['real_name'];
		        }else if($v['member_name']){
		            $infos['member_name'] = $v['member_name'];
		        }else{
		            $infos['member_name'] = substr_replace($v['mobile'],'********',2,8);
		        }
		        $infos['corporation_name'] =  $v['corporation_name'];
		        $infos['duties'] =  $v['duties'];
		        if(!empty($v['brief_avatar'])){
		            $infos['logo'] = IMAGE_URL.$v['brief_avatar'];
		        }else{
		            $infos['logo'] = $v['wechat_avatar'];
		        }
		         
		        //邀请状态
		        if(!empty( $_COOKIE['invite_dx_Customer_'.$v['mobile']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['mobile']])){
		            $infos['invite_dx'] = "1";
		        }else{
		            $infos['invite_dx'] = "0";
		        }
		        if(!empty( $_COOKIE['invite_dx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_dx_Corp_'.$v['id']])){
		            $infos['invite_dx'] = "1";
		        }else{
		            $infos['invite_dx'] = "0";
		        }
		        if(!empty( $_COOKIE['invite_wx_Customer_'.$v['id']]) || !empty( $_COOKIE['invite_wx_Corp_'.$v['id']])){
		            $infos['invite_wx'] = "1";
		        }else{
		            $infos['invite_wx'] = "0";
		        }
		        $member[] = $infos ;
		    }
		}
		
		if(isset($member) && count($member) > 0){
		    $no_role['id']= '0';
		    $no_role['total']= count($member);
		    $no_role['role_name']= '部落成员';
		    $no_role['list'] = $member;
		    $tribe_duties_list[] = $no_role;
		}
		
		
		$return['data'] = $tribe_duties_list;
		print_r(json_encode($return));
	}
	
	
	/**
	 * 部落成员详情
	 */
	public function  member_detail(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
		));
		
		$tribe_id = $prams['tribe_id'];
		$tribe_staff_id = isset($prams['tribe_staff_id']) ? $prams['tribe_staff_id']:0;
		$user_id = $this->session->userdata("user_id");//用户id
		
		if(!$user_id || $user_id == ''){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$tribe_info = $tribe_id ? $this->tribe_mdl->load($tribe_id,$user_id) : 0;//查询部落
		
		if(!$tribe_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '部落不存在'
			);
			print_r(json_encode($return));
			exit();
		}else if(!$tribe_info['tribe_staff_id'] || $tribe_info['status'] != 2 ){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '您不是该部落成员，无法访问'
			);
			print_r(json_encode($return));
			exit();
		}
		
		if($tribe_staff_id){
			$user_info = $this->tribe_mdl->load_tribe_staff( $tribe_id, $tribe_staff_id );
		}else{
			$user_info = $this->tribe_mdl->load_tribe_staff( $tribe_id, $tribe_info['tribe_staff_id'] );
		}
		$customer =  $this->customer_mdl->load($user_id);
		if($customer['real_name']){
			$user_info['member_name'] =  $customer['real_name'];
		}
		if(!$user_info['brief_avatar']){
			$user_info['logo_avatar'] =  $user_info['wechat_avatar'];
		}else{
			$user_info['logo_avatar'] =  IMAGE_URL.$user_info['brief_avatar'];
		}
		unset($user_info['wechat_avatar']);
		unset($user_info['brief_avatar']);
		
		$return['data'] = $user_info;
		print_r(json_encode($return));
	}
	
	
	
	//curl_post
	public function curl_do_result( $url, $data ){
		$data['key'] = 'jiami';
		$data['port_source'] = strtoupper(SUITE);
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
	
	/**
	 * 申请加入部落
	 */
	public function apply_view(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if(!$user_id || $user_id == ''){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$url = $this->url_prefix.'Customer/load';
		$post['customer_id']=$user_id;
		$customer = json_decode($this->curl_do_result($url,$post),true);
	
		//判断是否绑定手机
		if (!$customer["mobile"] )
		{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '用户未绑定收手机号码'
			);
			print_r(json_encode($return));
			exit;
		}
		$tribe_id = $prams['tribe_id'];
		$tribe = $this->tribe_mdl->check_My_apply($tribe_id,$user_id);//查询部落
		
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '部落不存在'
			);
			print_r(json_encode($return));
			exit;
		}
		
		$parent_id = $this->session->userdata("Invite_Code_Inviter");
		$authority = 0;
		if($parent_id){
		    //验证上线是否是管理员或部落族长
		    $authority = $this->tribe_mdl->ManagementTribe($parent_id,$tribe_id);
		}
		if($tribe["tribe_staff_id"] && $tribe["status"] ==1 || $tribe["tribe_staff_id"] && $tribe["status"] == 2){
		    if($tribe["status"] == 1){
		        $return['responseMessage'] = array(
		            'messageType' => 'error',
		            'errorType' => '8',
		            'errorMessage' => '您已经申请过了！工作人员正在审核'
		        );
		    }else{
		        $return['responseMessage'] = array(
		            'messageType' => 'error',
		            'errorType' => '9',
		            'errorMessage' => '您已经加入该部落，无需重复申请！'
		        );
		    }
		    print_r(json_encode($return));
		    exit;
		}
		
		if($tribe["tribe_staff_id"] ){
		    $_update['id'] =  $tribe['tribe_staff_id'];
		    $_update["is_agree"] = 1;
		    if($authority){
                $_update["status"] = 2;
		    }else{
		        $_update["status"] = 1;
		    }
		    $aff = $this->tribe_mdl->update_member($_update,$tribe['id']);
		}else{
		    $mobile = $this->session->userdata("mobile");//用户id
		    //通过手机验证成员信息
		    $staff_info =  $this->tribe_mdl->verify_tribe_user($tribe['id'],$mobile);
		    if($staff_info){
		        $update['add'] = true;
		        $update['id'] = $staff_info['id'];
		        $update['customer_id'] = $user_id;
		        $aff =  $this->tribe_mdl->update_member($update,$tribe['id']);
	            //同步部落身份信息
	            $staff_idenity =  $this->tribe_mdl->load_staff_idenity($mobile);
	            if($staff_idenity){
	                foreach ($staff_idenity as $key =>$val){
	                    $this->tribe_mdl->del_staff_idenity($val['id']);
	                    unset( $staff_idenity[$key]['id']);
	                    unset( $staff_idenity[$key]['mobile']);
	                    unset( $staff_idenity[$key]['created_at']);
	                    $staff_idenity[$key]['customer_id'] = $user_id;
	                }
	                $this->load->model('Customer_identity_mdl');
	                $this->Customer_identity_mdl->add_idenity_batch($staff_idenity);
	            }
	            ///同步部落预录入的相册个人形象
	            $this->load->model('Tribe_staff_album_mdl');
	            $this->Tribe_staff_album_mdl->synchro_Update($user_id,$tribe['id']);
	            
	            $num = 3;//提示改成3次
	            $this->tribe_mdl->update_tips($num,$mobile);
		    }else{
		        //添加。
		        $_data["customer_id"] = $user_id;
		        $_data["tribe_id"] = $tribe['id'];
		        $_data["mobile"] = $customer["mobile"];
		        
		        if($authority){
		            $_data["status"] = 2;
		        }else{
		            $_data["status"] = 1;
		        }
		        
		        //新增。
		        $_data["member_name"] = $mobile;
		        $_data['is_agree'] = 1;
		        $ts_id = $this->tribe_mdl->add_staff($_data);
		    }
		}
		
		$return['responseMessage'] = array(
		    'messageType' => 'success',
		    'errorType' => '0',
		    'errorMessage' => '申请加入部落成功！'
		);
		print_r(json_encode($return));
		
	}
	
	
	/**
	 * 微信分享
	 * @param str type    Cust 邀请注册   Corp  邀请认证企业
	 */
	public function wx_share(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'type'
		));
		$type = $prams['type'];
		$tribe_id =isset($prams['tribe_id']) ? $prams['tribe_id']:0 ;
		$from_customer_id = $this->session->userdata("user_id");//用户id
		if(!$from_customer_id || $from_customer_id == ''){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		if(!$tribe_id){
		    $return['responseMessage'] = array(
		        'messageType' => 'error',
		        'errorType' => '1',
		        'errorMessage' => '缺少参数'
		    );
		    print_r(json_encode($return));
		    exit();
		}
		
		//部落成员ID
		$id =isset($prams['id']) ? $prams['id']:0 ;
		if($id){
		    //处理邀请限制
		    if(!empty( $_COOKIE['invite_wx_Customer_'.$id]) || !empty( $_COOKIE['invite_wx_Corp_'.$id])){
		        $return['responseMessage'] = array(
		            'messageType' => 'error',
		            'errorType' => '13',
		            'errorMessage' => '3天内不可重复邀请'
		        );
		        print_r(json_encode($return));
		        exit();
		    }
		    setcookie('invite_wx_Customer_'.$id,1, time()+3600*24*3,'/');
		    setcookie('invite_wx_Corp_'.$id,1, time()+3600*24*3,'/');
		}
		
		$Cus_info = $this->customer_mdl->load($from_customer_id);
		$invite_info = $this->tribe_mdl->load($tribe_id,$from_customer_id);//查询部落
		
		$name = $Cus_info['real_name'] ? $Cus_info['real_name']:$invite_info['member_name'];
		
		$path = "部落";
		if( !is_numeric(strpos($invite_info['name'], $path))){
		    $tribe_name = "【".$invite_info['name']."】部落";
		}else{
		    $tribe_name = "【".$invite_info['name']."】";
		}
		
		if($type == 'Cust'){
			//配置长连接
			//            $url_long = site_url('Login/code_login/'.$tribe_id.'?in_id='.$from_customer_id);
			//            //转化短连接
			//            $this->load->helper("message");
			//            $req = json_decode( Message_LongToShort_result($url_long),true)[0];
			//            $return['data']['url'] = $req['url_short'];
		    $return['data']['title'] = '【'.$name.'】邀请您加入'.$tribe_name;;
		    $return['data']['desc'] = '部落互助，资源共享，'.$invite_info['name'].'诚意邀请您加入';
			$return['data']['url'] = site_url('Login/code_login/'.$tribe_id.'?in_id='.$from_customer_id);
		}else if($type == 'Corp'){
		    $return['data']['title'] = $name.'邀请您上51易货网开店';
		    $return['data']['desc'] = '填写资料，开店可享更多特权。';
			$return['data']['url'] = site_url('Navigation/cooperate_nav');
		}else{
			$return['data']['url'] = '';
		}
		print_r(json_encode($return));
	}
	
	
	
	/**
	 * 邀请加入部落  邀请认证
	 * type  Customer 加入部落 Corp = 加入企业
	 * send_type   1:邀请部落成员列表中的成员 2：填写手机邀请
	 */
	
	public function  invite(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		$send_type = $prams['send_type'];
		
		if(!$send_type || !in_array($send_type, array(1,2))){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '12',
					'errorMessage' => '邀请类型参数错误'
			);
			print_r(json_encode($return));
			exit();
		}
		if($send_type == 1){
			// 检验参数
			$this->_check_prams($prams, array(
					'tribe_id',
					'type',
					'tribe_staff_id'
			));
			$tribe_staff_id = $prams['tribe_staff_id'];
			$type = $prams['type'];
			
			//处理邀请限制
			if(!empty( $_COOKIE['invite_dx_'.$type.'_'.$tribe_staff_id])){
			    $return['responseMessage'] = array(
			        'messageType' => 'error',
			        'errorType' => '13',
			        'errorMessage' => '3天内不可重复邀请'
			    );
			    print_r(json_encode($return));
			    exit();
			}
		}else{
			// 检验参数
			$this->_check_prams($prams, array(
					'tribe_id',
					'mobile'
			));
			$mobile = $prams['mobile'];
			$type = 'Customer';
			
			//处理邀请限制
			if(!empty( $_COOKIE['invite_dx_'.$type.'_'.$mobile])){
			    $return['responseMessage'] = array(
			        'messageType' => 'error',
			        'errorType' => '13',
			        'errorMessage' => '3天内不可重复邀请'
			    );
			    print_r(json_encode($return));
			    exit();
			}
		}
		
		$tribe_id = $prams['tribe_id'];
		
		$sms_type = isset($prams['sms_type']) ? $prams['sms_type']:0;
		
		$from_customer_id = $this->session->userdata("user_id");//用户id
		if(!$from_customer_id || $from_customer_id == ''){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//邀请人
		$from_info = $this->tribe_mdl->load($tribe_id,$from_customer_id);
		if(!$from_info['tribe_staff_id'] || !$from_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '您不是该部落成员无法邀请'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		
		
		if($from_info['real_name']){
			$real_name = $from_info['real_name'];
		}else if($from_info['member_name']){
			$real_name = $from_info['member_name'];
		}else{
			$real_name =$from_info['mobile'];
		}
		$corp_name = $from_info['real_corp_name'] ?$from_info['real_corp_name']:'';
		if($send_type == 1){
			//查询受邀请人信息
			$to_info = $this->tribe_mdl->load_tribe_staff( $tribe_id,$tribe_staff_id );
			if(!$to_info){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '受邀人不是该部落成员'
				);
				print_r(json_encode($return));
				exit();
			}
			if(empty($to_info['mobile'])){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '8',
						'errorMessage' => '未知受邀请人手机号码无法邀请'
				);
				print_r(json_encode($return));
				exit();
			}
			
			$mobile = $to_info['mobile'];
		}
		else{
			$this->load->model('customer_mdl');
			$mobile_info = $this->customer_mdl->load_by_mobile($mobile);
			//              if($this->customer_mdl->check_mobile($mobile)){
			//                  $return['responseMessage'] = array(
			//                      'messageType' => 'error',
			//                      'errorType' => '13',
			//                      'errorMessage' => '该手机号码易货网平台注册了'
			//                  );
			//                  print_r(json_encode($return));
			//                  exit();
			//              }
		}
		
		//加载短信类
		 $this->load->helper("message");
		if($send_type == 1){
			//配置长连接
// 			$url_long = "http://www.51ehw.com/index.php/_BUSINESS/Login/code_login/".$tribe_id."?in_id=".$from_customer_id;
			// 			$url_long = site_url('Login/code_login/'.$tribe_id.'?in_id='.$from_customer_id);
			//转化短连接
		
// 			$req = json_decode(  Message_LongToShort_result($url_long),true)[0];
		
			$param['customer_id'] = $from_customer_id;
			$param['resource'] = "Login/code_login/".$tribe_id."?in_id=".$from_customer_id.'&in_tp=code';
			$req = json_decode(  ToConect($param),true);
			$content = "hi~{$to_info['member_name']}，这是您认识的{$real_name}。点击进入：".$req['url_short']." 退订回N【51易货网】";
// 			$content = "尊敬的{$to_info['member_name']}，{$corp_name}{$real_name}诚意邀请您加入{$to_info['name']}，充分展示您的个人形象和企业风采，与业内精英互动交流，还有更多专属特权等着您，快快来参加吧。".$req['url_short']."退订回N【51易货网】";
		}else{
			//配置长连接
// 			$url_long = "http://www.51ehw.com/index.php/_BUSINESS/Login/code_login/".$tribe_id."?in_id=".$from_customer_id;
			// 			$url_long = site_url('customer/registration/'.$from_customer_id.'?tribe_id='.$tribe_id);
			//转化短连接
// 			$req = json_decode( Message_LongToShort_result($url_long),true)[0];

			$param['customer_id'] = $from_customer_id;
			$param['resource'] = "Login/code_login/".$tribe_id."?in_id=".$from_customer_id.'&in_tp=code';
			$req = json_decode(  ToConect($param),true);
			
			$tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
			
			$user_tribe_info = $this->tribe_mdl->verify_tribe_user( $tribe_id, $mobile );
			if($user_tribe_info && $user_tribe_info['customer_id']){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '9',
						'errorMessage' => '该手机号用户已经加入部落了'
				);
				print_r(json_encode($return));
				exit();
			}
			//首先判断邀请用户是否已经注册的了
			if($mobile_info){
				$invite_name = $mobile_info['real_name'] ? $mobile_info['real_name']:$mobile;
			}else{
				$user_tribe_info = $this->tribe_mdl->verify_tribe_user( $tribe_id, $mobile );
				if($user_tribe_info){  //预录入用户
					$invite_name = $user_tribe_info['member_name'] ? $user_tribe_info['member_name']:$mobile;
				}else{//新用户
					$invite_name = $mobile;
				}
			}
			$content = "hi~{$invite_name}，这是您认识的{$real_name}。点击进入：".$req['url_short']." 退订回N【51易货网】";
// 			$content = "尊敬的{$invite_name}，{$corp_name}{$real_name}诚意邀请您加入{$tribe_info['name']}，充分展示您的个人形象和企业风采，与业内精英互动交流，还有更多专属特权等着您，快快来参加吧。".$req['url_short']."退订回N【51易货网】";
		}
		
		if( $type == 'Corp')
		{
		    $param['customer_id'] = $from_customer_id;
		    $param['resource'] = 'Navigation/cooperate_nav';
		    $req = json_decode(  ToConect($param),true);
		    
		    $content = "尊敬的{$to_info['member_name']}，{$real_name}诚邀请您进行企业认证，尊享更多专属特权，让易货更有保证。点击进入：".$req['url_short']." 退订回N【51易货网】";
// 			$content = "尊敬的{$to_info['member_name']}，{$corp_name}{$real_name}诚意邀请您进行企业认证，尊享更多专属特权，让更多的企业家们认识您企业的品牌和产品！".$req['url_short']."退订回N【51易货网】";
		}
		
		
		//发送短信
		$source = 4;//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
		$sms = send_message($mobile,0,$content,2,$source);
		$sms = json_decode($sms,true);
		
		if(  $sms["returnstatus"] == "00")
		{
		    if($send_type == 1){
		        //3天内只能对一个人邀请一次。
		        setcookie('invite_dx_'.$type.'_'.$tribe_staff_id,1, time()+3600*24*3,'/');
		    }else{
		        //3天内只能对一个人邀请一次。
		        setcookie('invite_dx_'.$type.'_'.$mobile,1, time()+3600*24*3,'/');
		    }
		   
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '邀请信息发送成功'
			);
		}else{
		    $return['responseMessage'] = array(
		        'messageType' => 'error',
		        'errorType' => '13',
		        'errorMessage' => '邀请信息发送失败'
		    );
		}
		
		if($sms_type){
		    $return['data'] = $sms;
		}
		print_r(json_encode($return));
	}
	
	/**
	 * 扫描部落邀请二维码
	 */
	public function Sweep_Invite_Code(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'code_url'
	    ));
	    $code_url = $prams['code_url'];
	    
	    $user_id = $this->session->userdata("user_id");//用户id
	    if ($user_id == null || $user_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    $link = 'Conect/n';
	    if(!is_numeric(strpos($code_url, $link))){
	          $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '参数有误'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    //截取二维码短连接
	    $key = substr($code_url,strpos($code_url,'Conect/')+9);
	  
	    $this->load->model("Conect_mdl");
	    $list = $this->Conect_mdl->load($key);
	    
	    if(!$list){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '9',
	            'errorMessage' => '二维码已失效'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    
	    $url_long = $list['url_long'];
	    //解析数据库长连接
	    $key_str = substr($url_long,strpos($url_long,'code_login/'));
	    $key_str = str_replace(array("?", "=", "&"), "/", $key_str);
	    $key_array =  explode('/',$key_str);
	    $tribe_id = $key_array[1];
	    $parent_id = $key_array[3];
	    
	    $this->session->set_userdata("Invite_Code_Inviter",$parent_id);
	    //验证上线是否是管理员或部落族长
// 	    $authority = $this->tribe_mdl->ManagementTribe($parent_id,$tribe_id);
// 	    if($authority){
// 	     }

	    $staff_info  = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id,0);
	    
	    $return['data']['mobile'] = $this->session->userdata("mobile");
	    $return['data']['tribe_id'] = $tribe_id;
	    $return['data']['real_name'] = $this->session->userdata("real_name") ? $this->session->userdata("real_name"):$this->session->userdata("wechat_nickname");
	    
	    if(!$staff_info){
	        $return['data']['status'] = 0;
	        print_r(json_encode($return));
	        exit;
	    }
	    
	    switch ($staff_info['status'])
	    {
	        case 1:
	            $return['data']['status'] = 1;
	            break;
	        case 2:
	            $return['data']['status'] = 2;
	            break;
	        default:
	            $return['data']['status'] = 0;
	            break;
	    }
	    print_r(json_encode($return));
	}	
	
	/**
	 * 二维码加入部落流程
	 */
	public function  Apply_Tribe(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    
	    $user_id = $this->session->userdata("user_id");//用户id
	    if ($user_id == null || $user_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id',
	        'mobile',
	        'mobile_vertify',
	        'real_name',
	    ));
	    
	    $tribe_id = $prams['tribe_id'];
	    $mobile = $prams['mobile'];
	    $mobile_vertify = $prams['mobile_vertify'];
	    $real_name = $prams['real_name'];
	    
	    $verfity_yzm = $this->session->userdata('verfity_yzm_255');
	    
	    if($mobile_vertify == $mobile_vertify){
	        //验证部落信息
	        $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
	        if(!$tribe_info){
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '4',
	                'errorMessage' => '部落不存在'
	            );
	            print_r(json_encode($return));
	            exit;
	        }
	        
	       $parent_id = $this->session->userdata("Invite_Code_Inviter");
	       if(!$parent_id){
	           $return['responseMessage'] = array(
	               'messageType' => 'error',
	               'errorType' => '6',
	               'errorMessage' => '邀请人信息错误'
	           );
	           print_r(json_encode($return));
	           exit;
	       }

	       //验证上线是否是管理员或部落族长
	       $authority = $this->tribe_mdl->ManagementTribe($parent_id,$tribe_id);
	       
	       
	       //判断下填写的手机号码是否已注册
	       $post['mobile'] = $mobile;
	       $url = $this->url_prefix.'Customer/load_by_mobile';
	       $customer = json_decode($this->curl_post_result($url,$post),true);
	       if($customer ){
	           //手机号已注册
	           
	           if(empty($customer['wechat_account'])){
	               //手机号未绑定微信
	               //进行绑定微信
	               $update['nick_name'] = $this->session->userdata('wechat_nickname');
	               $update['Nickname'] = $this->session->userdata('wechat_nickname');
	               $update['user_id'] = $customer['id'];
	               $update['mobile'] = $mobile;
	               $update['real_name'] = $real_name;//真会姓名
	               $update['openid'] = $this->session->userdata('openid');
	               $update['unionid'] = $this->session->userdata('unionid');
	               $update['wechat_avatar'] = $this->session->userdata('wechat_avatar');
	               $update['wechat_nickname'] = $this->session->userdata('wechat_nickname');
	               $url = $this->url_prefix.'Customer/info_save';
	               $is_binding = json_decode($this->curl_post_result($url,$update),true);
	               
	               //发送绑定成功信息
	               $this->load->model('Customer_message_mdl',"Message");
	               //模板
	               $Msg_info['template_id']= 4;
	               //标题
	               $Msg_info['name']= '账号绑定';
	               $Msg_info['customer_id']= $update['user_id'];
	               $Msg_info['obj_id'] = 0;
	               $Msg_info['type'] = 1;
	               $Msg_info['parameter']['name'] = $real_name;
	               $this->Message->Create_Message($Msg_info);
	               
	               
	               //绑定成功后把当前的微信号账户废除掉
	               $info['customer_id'] = $user_id;
	               $info['type'] = 'wechat';
	               //接口-
	               $url = $this->url_prefix.'Customer/unbundling';
	               json_decode($this->curl_post_result($url,$info),true);
	               
	               //重新登录用户  重新写session
	                
	               //加载用户支付账户信息写入session
	               $p_data =array();
	               $p_data['customer_id'] = $customer['id'];
	               $url = $this->url_prefix.'Customer/get_pay_relation_id?';
	               $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
	               
	               $this->load->helper("session");
	               $this->load->model("customer_mdl");
	               $user_info = $this->customer_mdl->load($customer['id']);
	               $user_info['pay_relation'] = $pay_data;
	               set_customer($user_info,"other");
	               
	               
	               //处理完用户信息后
	               //现在处理加入部落的逻辑
	               
	               //同步所有的部落的真实姓名
	               $this->tribe_mdl->update_tribe_member_name($real_name,$customer['id']);
	               
	               //判断部落是否需要审核
	               if($tribe_info['staff_status']){
                    ///要审核
                     $data['status'] = 1;
                    }else{
                     $data['status'] = 2;
                    }
                    if($authority){
                        $data['status'] = 2;
                    }
                    $ts_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$customer['id'],0);//检查我是否存在部落
                    if(!$ts_info){
                        //没有当前用户申请加入部落记录 by customer_id
                        //通过手机验证成员信息
                        $staff_info =  $this->tribe_mdl->verify_tribe_user($tribe_id,$mobile);
                        if($staff_info){
                            //存在信息  则当前用户是预录入用户
                            $add['add'] = true;
                            $add['id'] = $staff_info['id'];
                            $add['customer_id'] = $customer['id'];
                            $aff =  $this->tribe_mdl->update_member($add,$$tribe_id);
                            
                            if($aff){
                                //同步部落身份信息
                                $staff_idenity =  $this->tribe_mdl->load_staff_idenity($mobile);
                                if($staff_idenity){
                                    foreach ($staff_idenity as $key =>$val){
                                        $this->tribe_mdl->del_staff_idenity($val['id']);
                                        unset( $staff_idenity[$key]['id']);
                                        unset( $staff_idenity[$key]['mobile']);
                                        unset( $staff_idenity[$key]['created_at']);
                                        $staff_idenity[$key]['customer_id'] = $customer['id'];
                                    }
                                    $this->load->model('Customer_identity_mdl');
                                    $this->Customer_identity_mdl->add_idenity_batch($staff_idenity);
                                }
                                ///同步部落预录入的相册个人形象
                                $this->load->model('Tribe_staff_album_mdl');
                                $this->Tribe_staff_album_mdl->synchro_Update($customer['id'],$tribe_id);
                                
                                $num = 3;//提示改成3次
                                $this->tribe_mdl->update_tips($num,$mobile);
                            }
                        }else{
                            //加入部落
                            $data["customer_id"] = $customer['id'];
                            $data["tribe_id"] = $tribe_id;
                            $data["mobile"] = $mobile;
                            $data["member_name"] = $real_name;
                            $aff = $this->tribe_mdl->add_staff($data);
                        }
                        
                        if($aff){
                            $return['responseMessage'] = array(
                                'messageType' => 'success',
                                'errorType' => '0',
                                'errorMessage' => '申请成功'
                            );
                        }else{
                            $return['responseMessage'] = array(
                                'messageType' => 'error',
                                'errorType' => '7',
                                'errorMessage' => '申请失败'
                            );
                            print_r(json_encode($return));
                        }
                        print_r(json_encode($return));
                        exit;
                    }
	               
	           }else{
	               //手机号绑定了微信
	               $return['responseMessage'] = array(
	                   'messageType' => 'error',
	                   'errorType' => '7',
	                   'errorMessage' => '该手机已绑定了微信'
	               );
	               print_r(json_encode($return));
	               exit;
	           }
	       }else{
	           //手机号未注册
	           //进行注册绑定
	           $post['tbxRegisterPassword'] = 'ehw888888';
	           $post['real_name'] = $real_name;
	           $post['nickname'] = $this->session->userdata('wechat_nickname');
	           $post['Nickname'] = $this->session->userdata('wechat_nickname');
	           $post['unionid'] = $this->session->userdata('unionid');
	           $post['headimgurl'] = $this->session->userdata('wechat_avatar');
	           $post['openid'] = $this->session->userdata('openid');
	           $post['registry_by'] = "APP";
	           $post['app_id'] = $this->session->userdata("app_info")["id"];
	           $post['time'] = date("Y-m-d H:i:s");
	           $post['module'] = "B";
	           $post['parent_id'] = $parent_id;
	           $url = $this->url_prefix.'Customer/save';
	           $user = json_decode($this->curl_post_result($url,$post),true);
	           
               //绑定成功后把当前的微信号账户废除掉
               $info['customer_id'] = $user_id;
               $info['type'] = 'wechat';
               //接口-
               $url = $this->url_prefix.'Customer/unbundling';
               json_decode($this->curl_post_result($url,$info),true);
               
               
               //加载用户支付账户信息写入session
               $p_data =array();
               $p_data['customer_id'] = $user['id'];
               $url = $this->url_prefix.'Customer/get_pay_relation_id?';
               $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
                
               $this->load->helper("session");
               $this->load->model("customer_mdl");
               $user_info = $this->customer_mdl->load($user['id']);
               $user_info['pay_relation'] = $pay_data;
               set_customer($user_info,"other");
	               
               
               //加入部落
               $data["customer_id"] = $user['id'];
               $data["tribe_id"] = $tribe_id;
               $data["mobile"] = $mobile;
               $data["member_name"] = $real_name;
               $aff = $this->tribe_mdl->add_staff($data);
               
               if($aff){
                    $return['responseMessage'] = array(
                        'messageType' => 'success',
                        'errorType' => '0',
                        'errorMessage' => '申请成功'
                    );
                }else{
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '7',
                        'errorMessage' => '申请失败'
                    );
                    print_r(json_encode($return));
                }
                print_r(json_encode($return));
                exit;
	       }
	        
	    }else{
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '验证码错误'
	        );
	    }
	    print_r(json_encode($return));
	}
	
	/**
	 * 邀请二维码
	 */
	public function Create_Invite_Code(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id'
	    ));
	    $tribe_id = $prams['tribe_id'];
	    
	    $user_id = $this->session->userdata("user_id");//用户id
	    if ($user_id == null || $user_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    $tribe = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id);
	    if(!$tribe){
	        $return = array(
	            "Status"=>3,
	            'Msg' =>'您不是该部落成员无法邀请'
	        );
	        echo json_encode($return);
	        exit;
	    }
	    
	    $this->load->helper("message");
	    $param['customer_id'] = $user_id;
	    $param['resource'] = "Login/code_login/$tribe_id?in_id=$user_id&in_tp=code";
	   
	   
	    //部落首领或管理员
	    $req = json_decode(ToConect($param,'_BUSINESS','n',2),true);
	    if(!empty($req['key'])){
	        $this->load->model("Conect_mdl");
	        $this->Conect_mdl->Del_CodeLink($req['key']);
	    }
	    $return['data']['url_short'] =$req['url_short'];
	    echo json_encode($return);
	}
	
	
	
	/**
	 * 部落活动报名--临时使用
	 */
	public function  signup_tribe(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		// 检验参数
		$this->_check_prams($prams, array(
				'apply_id'
		));
		
		$apply_id = $prams['apply_id'];
		
		//查看活动是否存在 && 是否报名
		$sift['where']['customer_id'] = $user_id;
		$sift['where']['id'] = 0 == $apply_id ? 0 : $apply_id;
		$this->load->model('Tribe_activity_mdl');
		$activity_info = $this->Tribe_activity_mdl->Load_Activity( $sift );
		
		if( $activity_info )
		{
			$tribe_info = $this->tribe_mdl->get_MyTribe( $user_id );
			if(!$tribe_info){
				if( $activity_info["start_time"] < date("Y-m-d H:i:s") )
				{
					if( $activity_info["end_time"] > date("Y-m-d H:i:s") )
					{
						
						$data['activity_id'] = $apply_id;
						$data['customer_id'] = $user_id;
						$row = $this->Tribe_activity_mdl->Add_Activity_Staff( $data );
						
						if( $row )
						{
							$return['responseMessage'] = array(
									'messageType' => 'success',
									'errorType' => '0',
									'errorMessage' => '您的消息我们已经收到,稍后我们的客服人员会与您取得联系。咨询电话400-0029-777'
							);
						}
						
					}else{
						$return['responseMessage'] = array(
								'messageType' => 'error',
								'errorType' => '8',
								'errorMessage' => '申请已结束'
						);
						print_r(json_encode($return));
						exit();
					}
					
				}else{
					$return['responseMessage'] = array(
							'messageType' => 'error',
							'errorType' => '7',
							'errorMessage' => '申请未开始'
					);
					print_r(json_encode($return));
					exit();
				}
			}else{
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '6',
						'errorMessage' => '每个人只能创建一个部落，您已创建了部落'
				);
				print_r(json_encode($return));
				exit();
			}
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '活动不存在'
			);
			print_r(json_encode($return));
			exit();
		}
		
		print_r(json_encode($return));
	}
	
	
	//----------------------------------部落圈子--------------------------
	/**
	 * 检查是否有新消息
	 */
	public function check_message(){
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$tribe_id  = $prams['tribe_id'];
		
		$sift['where']['to_customer_id'] =$user_id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['is_read'] = 1;
		
		$this->load->model('customer_mdl');
		$user_info = $this->customer_mdl->load($user_id);
		if(empty($user_info['brief_avatar'])){
			$return['data']['logo_avatar'] = $user_info['wechat_avatar'];
		}else{
			$return['data']['logo_avatar'] =  IMAGE_URL.$user_info['brief_avatar'];
		}
		
		$this->load->model('Tribe_message_mdl');
		$return['data']['message_num'] =  $this->Tribe_message_mdl->Not_Read_Num( $sift )['not_read_num'];
		print_r(json_encode($return));
	}
	
	
	/**
	 * 消息列表
	 */
	public function message_list(){
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$tribe_id  = $prams['tribe_id'];
		
		$type  = isset($prams['type'])? $prams['type']:'new_meaagse';
		
		$sift['where']['to_customer_id'] = $user_id;
		$sift['where']['tribe_id'] = $tribe_id;
		
		$this->load->model('Tribe_message_mdl');
		if($type == 'new_meaagse'){
			$sift['where']['is_read'] =  1 ;//未读
			$list = $this->Tribe_message_mdl->Load( $sift );
			//更新为已读
			$sift['set']['is_read'] = 2;
			$this->Tribe_message_mdl->Update( $sift );
			if(count($list) > 0){
				foreach ($list as $key =>$val){
					if(empty($val['brief_avatar'])){
						$list[$key]['logo_avatar'] = $val['wechat_avatar'];
					}else{
						$list[$key]['logo_avatar'] = IMAGE_URL.$val['brief_avatar'];
					}
					$list[$key]['images'] = explode(';', trim( $val['images'],';' ))[0];
					//判断回复内容中是否含有图片
					$Imgs = $this->getImgs($val['topic_content']);
					//当没有图片时
					if(!$Imgs){
						//
						$list[$key]['simple_topic_content'] = $val['topic_content'];
					}else{
						$list[$key]['simple_topic_content'] = NULL;
					}
					
					
					unset($list[$key]['brief_avatar']);
					unset($list[$key]['wechat_avatar']);
					unset($list[$key]['test']);
				}
			}
			$return['data'] = $list;
		}else{
			$page = $this->n;
			$return['data'] = array(
					'perpage' => 0,
					'currentpage' => 0,
					'totalpage' => 0,
					'totalcount' => 0,
					'listdate' => array()
			);
			
			$sift['where']['is_read'] =  2 ;//历史
			
			$perPage = $page['perPage']; // 每页记录数
			$currPage = $page['currPage']; // 当前页
			$offset = ($currPage - 1) * $perPage; // 偏移量
			
			$totalcount = count($this->Tribe_message_mdl->Load( $sift ));
			$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
			$sift['page']['limit']  = $perPage;
			$sift['page']['offset']  = $offset;
			$list = $this->Tribe_message_mdl->Load( $sift );
			
			if(count($list) > 0){
				foreach ($list as $key =>$val){
					if(empty($val['brief_avatar'])){
						$list[$key]['logo_avatar'] = $val['wechat_avatar'];
					}else{
						$list[$key]['logo_avatar'] = IMAGE_URL.$val['brief_avatar'];
					}
					$list[$key]['images'] = explode(';', trim( $val['images'],';' ))[0];
					//判断回复内容中是否含有图片
					$Imgs = $this->getImgs($val['topic_content']);
					//当没有图片时
					if(!$Imgs){
						//
						$list[$key]['simple_topic_content'] = $val['topic_content'];
					}else{
						$list[$key]['simple_topic_content'] = NULL;
					}
					
					
					unset($list[$key]['brief_avatar']);
					unset($list[$key]['wechat_avatar']);
					unset($list[$key]['test']);
				}
			}
			
			// 返回数据
			$return['data']['perpage'] = $perPage;
			$return['data']['currentpage'] = $currPage;
			$return['data']['totalcount'] = $totalcount;
			$return['data']['totalpage'] = $totalpage;
			$return['data']['listdate'] = $list;
		}
		print_r(json_encode($return));
	}
	
	//获取内容中的图片
	private function getImgs($content,$order='ALL'){
		$pattern="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
		preg_match_all($pattern,$content,$match);
		if(isset($match[1])&&!empty($match[1])){
			if($order==='ALL'){
				return $match[1];
			}
			if(is_numeric($order)&&isset($match[1][$order])){
				return $match[1][$order];
			}
		}
		return '';
	}
	
	/**
	 * 清空历史消息
	 */
	public function del_history_message(){
		$prams = $this->p;
		$return = $this->return;
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$tribe_id  = $prams['tribe_id'];
		
		$sift['where']['to_customer_id'] = $user_id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['is_read'] = 2;
		
		$this->load->model('Tribe_message_mdl');
		
		//删除
		$row = $this->Tribe_message_mdl->Delete( $sift );
		if($row){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '清空成功'
			);
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '清空失败'
			);
		}
		print_r(json_encode($return));
	}
	
	/**
	 * 圈子话题
	 *
	 * @param   type     tirbe_topic 部落话题   my_topic  我发布的话题
	 */
	public function  circle_topic_list(){
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
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$type  = isset($prams['type'])? $prams['type']:'tirbe_topic';
		
		$tribe_id  = $prams['tribe_id'];
		$tribe_info = $this->tribe_mdl->load( $tribe_id,$user_id);
		if(!$tribe_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '部落不存在'
			);
			print_r(json_encode($return));
			exit();
		}else if(!$tribe_info["tribe_staff_id"] || $tribe_info['status'] != 2 ){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '未加入该部落'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['customer_id'] = $user_id;
		
		$this->load->model('Tribe_topic_mdl');
		if($type == 'tirbe_topic'){
			$totalcount = count($this->Tribe_topic_mdl->Load( $sift ));
			$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
			$sift['page']['limit']  = $perPage;
			$sift['page']['offset']  = $offset;
			$list = $this->Tribe_topic_mdl->Load( $sift );
		}else if($type == 'my_topic'){
			$totalcount = count($this->Tribe_topic_mdl->My_Topic_List( $sift ));
			$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
			$sift['page']['limit']  = $perPage;
			$sift['page']['offset']  = $offset;
			$list = $this->Tribe_topic_mdl->My_Topic_List( $sift );
		}else{
			$return['data'] = null;
			print_r(json_encode($return));
			exit;
		}
		if(count($list) > 0){
			foreach ($list as $key =>$val){
				$bg_img = explode(';',$val['images']);
				$bg_img = array_filter($bg_img);
				$list[$key]['images'] = $bg_img;
				
				if($val['real_name']){
					$list[$key]['member_name'] =  $val['real_name'];
				}
				
				if(empty($val['brief_avatar'])){
					$list[$key]['logo_avatar'] = $val['wechat_avatar'];
				}else{
					$list[$key]['logo_avatar'] = IMAGE_URL.$val['brief_avatar'];
				}
				unset($list[$key]['brief_avatar']);
				unset($list[$key]['wechat_avatar']);
				$upvote_info =  $this->Tribe_topic_mdl->topic_upvote_member_name($val['id']);
				if(count($upvote_info) > 0){
					foreach ($upvote_info as $k => $v){
						if($v['real_name']){
							$upvote_info[$k]['member_name'] = $v['real_name'];
						}
					}
				}
				
				//                echo '<pre>';
				//                print_r($upvote_info);exit;
				$list[$key]['upvote_info'] = array();
				if(count($upvote_info) > 0){
					$list[$key]['upvote_info'] =$upvote_info;
				}
				
			}
		}
		
		// 返回数据
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] = $list;
		print_r(json_encode($return));
		
	}
	
	/**
	 * 是否是圈主(义工委)
	 */
	public function  check_tribe_owner(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		// 检验参数
		$this->_check_prams($prams, array(
				"tribe_id",
		));
		$tribe_id = $prams['tribe_id'];//部落ID
		if(!$tribe_id){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '参数不能为空'
			);
			print_r(json_encode($return));
			exit();
		}
		//查询是否是义工委管理
		$this->load->model("tribe_mdl");
		$tribe = $this->tribe_mdl->ManagementTribe($user_id,$tribe_id);
		$return['data']['status'] = false;
		if($tribe){
			$return['data']['status'] = true;
		}
		print_r(json_encode($return));
	}
	/**
	 * 发布话题
	 */
	public function  save_topic(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		// 检验参数
		$this->_check_prams($prams, array(
				"tribe_id",
				"content",
		));
		$tribe_id = $prams['tribe_id'];//部落ID
		$content = $prams['content'];//内容
		$sort = isset($prams['sort']) ? $prams['sort']:0;//是否置顶
		$images = '';//保存图片路径
		
		//邀请人
		$info = $this->tribe_mdl->load($tribe_id,$user_id);
		if(!$info['tribe_staff_id'] || !$info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '您尚未加入该部落,发布失败'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->library('upload');
		// 图片 初始化数据
		$save_path = "uploads/teibe_".$tribe_id.'/topic/';
		$path = FCPATH.UPLOAD_PATH. $save_path;
		
		if ( !file_exists( $path ) )
		{
			mkdir(iconv("UTF-8", "GBK", $path),0777,true);
		}
		if(count($_FILES) > 0){
			$count=count($_FILES["file"]["name"]);//页面取的默认名称
			for($i=0;$i<$count;$i++){
				$field_name = $_FILES["file"]['name'][$i]. '_' . $i;
				$_FILES[$field_name] = array(
						'name' => $_FILES["file"]['name'][$i],
						'size' => $_FILES["file"]['size'][$i],
						'type' => $_FILES["file"]['type'][$i],
						'tmp_name' => $_FILES["file"]['tmp_name'][$i],
						'error' => $_FILES["file"]['error'][$i]
				);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2097152';
				$config['file_name'] = $user_id. '_' . date("YmdHis");
				
				$this->upload->initialize($config);
				if ($this->upload->do_upload($field_name)) {
					$uploaded = $this->upload->data();
					$images .= $save_path . $uploaded['file_name'].';';
				}
			}
		}
		$this->load->model('Tribe_topic_mdl');
		
		//允许多个话题置顶  18 0126
		if($sort == 1){
// 			//取消以前的旧置顶
// 			$sift['where']['sort'] = 1;
// 			$sift['set']['sort'] = 0;
// 			$sift['where']['tribe_id'] = $tribe_id;
// 			$this->Tribe_topic_mdl->Update( $sift );
			
			$data['sort'] = 1;
		}
		
		$data['images'] = $images;
		$data['tribe_id'] = $tribe_id;
		$data['content'] = $content;
		$data['customer_id'] = $user_id;
		$id = $this->Tribe_topic_mdl->Create( $data );
		
		$return['responseMessage'] = array(
				'messageType' => 'error',
				'errorType' => '6',
				'errorMessage' => '发布失败'
		);
		if($id){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '发布成功'
			);
		}
		print_r(json_encode($return));
	}
	
	
	/**
	 * 话题详情
	 */
	public function   topic_detail(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id'
		));
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['id'] = $topic_id;
		$sift['where']['customer_id'] = $user_id;
		$sift['return_row'] = true;
		$this->load->model('Tribe_topic_mdl');
		$topic_detaile = $this->Tribe_topic_mdl->Load( $sift );
		
		$bg_img = explode(';',$topic_detaile['images']);
		$bg_img = array_filter($bg_img);
		$topic_detaile['images'] = $bg_img;
		
		
		if(empty($topic_detaile['brief_avatar'])){
			$topic_detaile['logo_avatar'] = $topic_detaile['wechat_avatar'];
		}else{
			$topic_detaile['logo_avatar'] = IMAGE_URL.$topic_detaile['brief_avatar'];
		}
		
		if($topic_detaile['real_name']){
			$topic_detaile['member_name'] =  $topic_detaile['real_name'];
		}
		
		$upvote_info =  $this->Tribe_topic_mdl->topic_upvote_member_name($topic_id);
		if(count($upvote_info) > 0){
			foreach ($upvote_info as $k => $v){
				if($v['real_name']){
					$upvote_info[$k]['member_name'] = $v['real_name'];
				}
			}
		}
		$topic_detaile['upvote_info'] = $upvote_info;
		$return['data'] = $topic_detaile;
		print_r(json_encode($return));
	}
	
	
	/**
	 * 话题评论列表
	 */
	public function topic_comment_list(){
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
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id'
		));
		
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		
		$sift['where']['obj_id'] = $topic_id;
		$sift['where']['type'] = 1;
		$sift['where']['tribe_id'] = $tribe_id;
		
		$this->load->model('Tribe_comment_mdl');
		
		$totalcount = count($this->Tribe_comment_mdl->Load( $sift ));
		
		$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
		$sift['page']['limit'] = $perPage;
		$sift['page']['offset'] = $offset;
		
		$list =  $this->Tribe_comment_mdl->Load( $sift );
		foreach ($list as $key =>$val){
			if(empty($val['brief_avatar'])){
				$list[$key]['logo_avatar'] = $val['wechat_avatar'];
			}else{
				$list[$key]['logo_avatar'] = IMAGE_URL.$val['brief_avatar'];
			}
			unset($list[$key]['brief_avatar']);
			unset($list[$key]['wechat_avatar']);
		}
		// 返回数据
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] = $list;
		print_r(json_encode($return));
	}
	
	/**
	 * 话题置顶
	 */
	public function sort_topic(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id',
				'sort'
		));
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		$sort = $prams['sort'];
		if(!in_array($sort, array(0,1))){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '置顶参数错误'
			);
			print_r(json_encode($return));
			exit();
		}
		//查询是否是义工委管理
		$this->load->model("tribe_mdl");
		$tribe = $this->tribe_mdl->ManagementTribe($user_id,$tribe_id);
		
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model('Tribe_topic_mdl');
		$sift_A['where']['tribe_id'] = $tribe_id;
		$sift_A['where']['id'] = $topic_id;
		$sift_A['set']['sort'] = $sort;
		$this->load->model('Tribe_topic_mdl');
		$row = $this->Tribe_topic_mdl->update( $sift_A );
		if($sort == 1){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '置顶成功'
			);
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '0',
					'errorMessage' => '取消置顶成功'
			);
		}
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '操作失败'
			);
		}
		print_r(json_encode($return));
	}
	
	
	/**
	 * 话题点赞/话题取消点赞
	 */
	public function upvote_topic(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id'
		));
		
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		$this->load->model('Tribe_topic_mdl');
		$sift_A['where']['tribe_id'] = $tribe_id;
		$sift_A['where']['id'] = $topic_id;
		$this->load->model('Tribe_topic_mdl');
		$topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift_A );
		
		if( $topic_detaile )
		{
			$sift['where']['obj_id'] = $topic_id;
			$sift['where']['customer_id'] = $user_id;
			$sift['where']['type'] = 1;
			$this->load->model('Tribe_upvote_mdl');
			
			if( $this->Tribe_upvote_mdl->Load( $sift ) )
			{
				//删除点赞
				$row = $this->Tribe_upvote_mdl->Del( $sift );
				if($row){
					$return['responseMessage'] = array(
							'messageType' => 'success',
							'errorType' => '0',
							'errorMessage' => '取消点赞成功'
					);
				}else{
					$return['responseMessage'] = array(
							'messageType' => 'success',
							'errorType' => '7',
							'errorMessage' => '操作失败'
					);
				}
				
			}else{
				//添加
				$row = $this->Tribe_upvote_mdl->Create( $sift['where'] );
				$type = 2;
				
				if( $row )
				{
					$return['responseMessage'] = array(
							'messageType' => 'success',
							'errorType' => '0',
							'errorMessage' => '点赞成功'
					);
					
					//推送消息
					$messgae_data['to_customer_id'] =  $topic_detaile['customer_id'];
					$messgae_data['form_customer_id'] = $user_id;
					$messgae_data['tribe_id'] = $tribe_id;
					$messgae_data['obj_id'] = $topic_id;
					$messgae_data['content_obj_id'] = $row;
					$messgae_data['type'] = 2;
					$this->load->model('Tribe_message_mdl');
					$this->Tribe_message_mdl->Create( $messgae_data );
				}else{
					$return['responseMessage'] = array(
							'messageType' => 'success',
							'errorType' => '8',
							'errorMessage' => '操作失败'
					);
				}
				
			}
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '话题不存在'
			);
		}
		print_r(json_encode($return));
		
	}
	
	/**
	 * 举报话题
	 */
	public function add_topic_complaint(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id',
				'content'
		));
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		$content = $prams['content'];
		
		$data['obj_id'] = $topic_id;
		$data['content'] = $content;
		$data['customer_id'] = $user_id;
		$data['tribe_id'] = $tribe_id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['id'] = $data['obj_id'];
		$this->load->model('Tribe_topic_mdl');
		$topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift );
		
		$return['responseMessage'] = array(
				'messageType' => 'error',
				'errorType' => '6',
				'errorMessage' => '举报失败'
		);
		
		if( $topic_detaile )
		{
			$_data['obj_id'] = $topic_id;
			$_data['customer_id'] = $user_id;
			$is_complaints = $this->Tribe_topic_mdl->topic_is_complaints( $_data['obj_id'],$_data['customer_id']);
			if($is_complaints){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '您已经举过报该话题了'
				);
				print_r(json_encode($return));
				exit();
			}
			
			$this->db->insert('tribe_complaints',$data);
			
			if( $this->db->insert_id() )
			{
				$return['responseMessage'] = array(
						'messageType' => 'success',
						'errorType' => '0',
						'errorMessage' => '举报成功'
				);
			}
			
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '该话题不存在，无法举报'
			);
		}
		
		print_r(json_encode($return));
		exit();
	}
	/**
	 * 评论话题
	 */
	public function  add_topic_comment(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id',
				'content'
		));
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		$content = $prams['content'];
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//查询话题。
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['id'] = $topic_id;
		$this->load->model('Tribe_topic_mdl');
		$topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift );
		if($topic_detaile){
			//添加评论
			$data['content'] = $content;
			$data['tribe_id'] = $tribe_id;
			$data['obj_id'] = $topic_id;
			$data['customer_id'] = $user_id;
			$this->load->model('Tribe_comment_mdl');
			
			$id = $this->Tribe_comment_mdl->Create( $data );
			
			if($id){
				$return['responseMessage'] = array(
						'messageType' => 'success',
						'errorType' => '0',
						'errorMessage' => '评论成功'
				);
				//推送消息
				$messgae_data['to_customer_id'] =$topic_detaile['customer_id'];
				$messgae_data['form_customer_id'] = $user_id;
				$messgae_data['tribe_id'] = $tribe_id;
				$messgae_data['obj_id'] = $topic_id;
				$messgae_data['content'] = $content;
				$messgae_data['content_obj_id'] = $id;
				$messgae_data['type'] = 1;
				$this->load->model('Tribe_message_mdl');
				$this->Tribe_message_mdl->Create( $messgae_data );
			}else{
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '评论失败'
				);
			}
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '话题不存在'
			);
		}
		print_r(json_encode($return));
	}
	
	
	/**
	 * 删除评论
	 */
	public function del_comment(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'comment_id',
		));
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		$comment_id = $prams['comment_id'];
		
		$sift['where']['id'] = $comment_id;
		$sift['where']['customer_id'] = $user_id;
		$sift['set']['is_delete'] = 1;
		
		$this->load->model('Tribe_comment_mdl');
		$row = $this->Tribe_comment_mdl->Update( $sift );
		if($row){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '删除成功'
			);
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '删除失败'
			);
		}
		print_r(json_encode($return));
	}
	
	/**
	 * 删除话题
	 */
	public function  del_topic(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'topic_id'
		));
		$tribe_id = $prams['tribe_id'];
		$topic_id = $prams['topic_id'];
		
		$user_id = $this->session->userdata("user_id");//用户id
		
		if ($user_id == null || $user_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$sift['where']['id'] = $topic_id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['customer_id'] = $user_id;
		$sift['set']['status'] = 0;
		
		$this->load->model('Tribe_topic_mdl');
		$row = $this->Tribe_topic_mdl->Update( $sift );
		
		if($row){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '删除成功'
			);
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '删除失败'
			);
		}
		print_r(json_encode($return));
	}
	
	
	//-------------排行榜---------------------
	
	/**
	 * 排行榜
	 * @param int  tribe_id 部落ID
	 * @param str  type   Help 互助排行 Contribute 贡献排行  Guarantee 担保排行  Profit 收益排行  Credit 授信排行
	 */
	public function ranking_list(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		$page = $this->n;
		$return['data'] = array(
				'perpage' => 0,
				'currentpage' => 0,
				'totalpage' => 0,
				'totalcount' => 0,
				'listdate' => array()
		);
		
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id',
				'type'
		));
		$tribe_id = $prams['tribe_id'];
		$type = $prams['type'];
		
		$staff_info = $this->tribe_mdl->load($tribe_id,$customer_id);
		
		if(!$staff_info['tribe_staff_id'] || !$staff_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '11',
					'errorMessage' => '您不是该部落成员无法查看排行榜'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		//获取时间区间
		$this->load->helper("time");
		$time = isset($prams['time'])? $prams['time']:"";
		$time = GetTime($time);
		
		
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		
		
		switch ($type)
		{
			case 'Help': //互助排行
				$this->load->model('Order_mdl');
				$_info = $this->Order_mdl->Tribal_Members_Consumption($tribe_id,$customer_id,null,null,$time);
				if($_info){
					$user_info['position'] = $_info['position'];
					// 				$user_info['id'] = $_info['id'];
					if($_info['real_name']){
						$user_info['member_name'] = $_info['real_name'];
					}else{
						$user_info['member_name'] = $_info['member_name'];
					}
					$user_info['corporation_name'] =$staff_info['real_corp_name'];
					$user_info['total'] = $_info['total'];
				}else{
					$user_info['position'] = '-';
					if($staff_info['real_name']){
						$user_info['member_name'] = $staff_info['real_name'];
					}else{
						$user_info['member_name'] = $staff_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = "0";
				}
				
				$totalcount = count($this->Order_mdl->Tribal_Members_Consumption($tribe_id,null,0,0,$time)); // 获取总记录数
				$listdate = $this->Order_mdl->Tribal_Members_Consumption($tribe_id,null,$perPage,$offset,$time);
				break;
			case 'Contribute': //贡献排行
				$this->load->model('Order_mdl');
				$_info = $this->Order_mdl->Corp_Total_Sales( $tribe_id,$customer_id,null,null,$time );
				if($_info){
					$user_info['position'] = $_info['position'];
					// 				$user_info['id'] = $_info['id'];
					if($_info['real_name']){
						$user_info['member_name'] = $_info['real_name'];
					}else{
						$user_info['member_name'] = $_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = $_info['total'];
				}else{
					$user_info['position'] = '-';
					if($staff_info['real_name']){
						$user_info['member_name'] = $staff_info['real_name'];
					}else{
						$user_info['member_name'] = $staff_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = "0";
					
				}
				$totalcount = count($this->Order_mdl->Corp_Total_Sales( $tribe_id,null,0,0,$time ));// 获取总记录数
				$listdate = $this->Order_mdl->Corp_Total_Sales( $tribe_id,null,$perPage,$offset,$time );
				
				break;
			case 'Guarantee': //担保排行
				$this->load->model('Guarantee_request_mdl');
				$_info = $this->Guarantee_request_mdl->Ranking_list($tribe_id,$customer_id,null,null,$time);
				
				if($_info){
					$user_info['position'] = $_info['position'];
					// 				$user_info['id'] = $_info['id'];
					if($_info['real_name']){
						$user_info['member_name'] = $_info['real_name'];
					}else{
						$user_info['member_name'] = $_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = $_info['total'];
				}else{
					$user_info['position'] = '-';
					if($staff_info['real_name']){
						$user_info['member_name'] = $staff_info['real_name'];
					}else{
						$user_info['member_name'] = $staff_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = "0";
				}
				$totalcount = count($this->Guarantee_request_mdl->Ranking_list($tribe_id,null,0,0,$time));// 获取总记录数
				$listdate = $this->Guarantee_request_mdl->Ranking_list($tribe_id,null,$perPage,$offset,$time);
				break;
			case 'Profit': //收益排行
				$this->load->model('Tribe_mdl');
				$_info = $this->Tribe_mdl->Rebate_Ranking_list( $tribe_id,$customer_id,null,null,$time );
				if($_info){
					$user_info['position'] = $_info['position'];
					// 				$user_info['customer_id'] = $_info['customer_id'];
					if($_info['real_name']){
						$user_info['member_name'] = $_info['real_name'];
					}else{
						$user_info['member_name'] = $_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = $_info['total'];
				}else{
					$user_info['position'] = '-';
					if($staff_info['real_name']){
						$user_info['member_name'] = $staff_info['real_name'];
					}else{
						$user_info['member_name'] = $staff_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = "0";
				}
				$totalcount = count($this->Tribe_mdl->Rebate_Ranking_list( $tribe_id,null,0,0,$time ));// 获取总记录数
				$listdate = $this->Tribe_mdl->Rebate_Ranking_list( $tribe_id,null,$perPage,$offset,$time );
				break;
			case 'Credit': //授信排行
			default:
				$this->load->model('Credit_mdl');
				$_info = $this->Credit_mdl->Ranking_List($tribe_id,null,null,$time,$customer_id);
				if($_info){
					$user_info['position'] = $_info['position'];
					if($_info['real_name']){
						$user_info['member_name'] = $_info['real_name'];
					}else{
						$user_info['member_name'] = $_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = $_info['total'];
				}else{
					$user_info['position'] = '-';
					if($staff_info['real_name']){
						$user_info['member_name'] = $staff_info['real_name'];
					}else{
						$user_info['member_name'] = $staff_info['member_name'];
					}
					$user_info['corporation_name'] = $staff_info['real_corp_name'];
					$user_info['total'] = "0";
					
				}
				$totalcount = count($this->Credit_mdl->Ranking_List($tribe_id,0,0,$time));// 获取总记录数
				$listdate = $this->Credit_mdl->Ranking_List($tribe_id,$perPage,$offset,$time);
				//授信
				break;
				
		}
		
		$list = array();
		foreach ($listdate as $key =>$val){
			// 	    if(isset($val['id'])){
			// 	        $list[$key]['id'] = $val['id'];
			// 	    }
			// 	    if(isset($val['customer_id'])){
			// 	        $list[$key]['customer_id'] = $val['customer_id'];
			// 	    }
				if($val['real_name']){
					$list[$key]['member_name'] = $val['real_name'];
				}else{
					$list[$key]['member_name'] = $val['member_name'];
				}
				$list[$key]['corporation_name'] = $val['corporation_name'];
				$list[$key]['total'] = $val['total'];
		}
		
		$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
		
		// 返回数据
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] = $list;
		$return['data']['user_info'] = $user_info;
		
		print_r(json_encode($return));
	}
	
	// --------------------------------------------------------
	
	/**
	 * 管理部落
	 */
	public function managingtribes(){
	    // 获取参数
	    $prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
		    'tribe_id',
		));
		
		$tribe_id = $prams['tribe_id'];
		$customer_id = $this->session->userdata("user_id");//用户id
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		//-----管理员权限开始--------
		$tribe_owner = 0;
		$tribes = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);
	    if($tribes){
	        $tribe_owner = 1;
	    }
	    $tribe['tribe_owner'] = $tribe_owner;
	    //-----管理员权限结束--------
	    
		$return['data']['tribe'] = $tribe;//部落资料
		print_r(json_encode($return));
	}
	
	/**
	 * 管理部落列表
	 */
	public function managingtribeList(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	   
	    $tribe_ids = array();
	    $label_id = $this->session->userdata("label_id");
	    if($label_id){
	        $tribe_ids = $this->get_app_tribe_ids($label_id);
	    }
	    $customer_id = $this->session->userdata("user_id");//用户id
	    
	    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_ids);
	    $audit_list = array();
	    $unaudit_list = array();
	    foreach ($tribe as $key =>$val){
	        if($val['status'] == 2){
	            $audit_list[] = $val;
	        }else{
	            $unaudit_list[] = $val;
	        }
	    }
	    $type = !empty($prams['type']) ? $prams['type']:0;
	    if( $type === 'manager'){
	        $return['data'] = $audit_list;
	    }else{
	        $return['data'][] = $audit_list;
	        $return['data'][] = $unaudit_list;
	    }
	   
	   
	    print_r(json_encode($return));
	}
	
	
	/**
	 * 添加族员权限
	 */
	public function set_member_role(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id',
	        'customer_id',
	        'manager_id',///权限ID
	    ));
	    $tribe_id = $prams["tribe_id"];//部落id
	    $customer_id = $this->session->userdata("user_id");//用户id
	    
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    //查询判断我是否属于部落义工委
	    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
	    if(!$tribe){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '6',
	            'errorMessage' => '权限不足'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $member_customer_id = $prams["customer_id"];//族员用户id
	    $manager_id = $prams["manager_id"];//族员用户id
	    if(!is_numeric($manager_id)){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '9',
	            'errorMessage' => '权限类型错误'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	   
	    $update['tribe_id'] = $tribe_id;
	    $update['customer_id'] = $member_customer_id;
	    $update['tribe_manager_id'] = $manager_id;
	    
	    $aff = $this->tribe_mdl->update_manager_role($update);
	    if($aff){
			$return['responseMessage'] = array(
					'messageType' => 'success',
					'errorType' => '0',
					'errorMessage' => '操作成功'
			);
		}else{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '3',
					'errorMessage' => '操作失败'
			);
		}
		print_r(json_encode($return));
	    
	}
	
	
	/**
	 *检查是否拥有管理员权限
	 */
	public function check_manager(){
	    $prams = $this->p;
	    $return = $this->return;
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id'
	    ));
	    $tribe_id = $prams["tribe_id"];//部落id
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $is_manager = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//是否是管理员
	    $return['responseMessage'] = array(
	        'messageType' => 'success',
	        'errorType' => '0',
	        'errorMessage' => '操作成功'
	    );
	    $return['is_manager'] = 1;
	    if(!$is_manager){
	        $return['is_manager'] = 0;
	    }
	    print_r(json_encode($return));
	}
	
	/**
	 * 检查部落名称是否存在
	 */
	public  function check_tribe_name(){
	    
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'name'
	    ));
	     
	    $customer_id = $this->session->userdata("user_id");//用户id
	    
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $name = $prams["name"];
	    $tribe = $this->tribe_mdl->check_name($name);
	    
	    $return['responseMessage'] = array(
	        'messageType' => 'success',
	        'errorType' => '0',
	        'errorMessage' => '部落名可以使用'
	    );
	    $tribe_info = NULL;
	    if($tribe){
	        $tribe_info = $this->tribe_mdl->get_tribe($tribe['id']);
	        if($tribe["customer_id"] != $customer_id){
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '7',
	                'errorMessage' => '部落已经存在'
	            );
	             $tribe_info = NULL;
	        }
	        if($tribe['status'] != 3){
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '8',
	                'errorMessage' => '部落已经存在'
	            );
	             $tribe_info = NULL;
	        }
	    }
	    $return['data']['tribe']= $tribe_info;
	    print_r(json_encode($return));
	}
	
	
	/**
	 * 管理部落成员列表
	 */
	public function  manager_list(){
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
	    $this->_check_prams($prams, array(
	        'tribe_id'
	    ));
	    
	    
	    $customer_id = $this->session->userdata("user_id");//用户id
	     
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $tribe_id = $prams["tribe_id"];//部落id
	    
	    $tribe_manager = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);//是否是义工委
	   
	    if(!$tribe_manager){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '权限不足'
            );
            print_r(json_encode($return));
            exit();
	    }
	    
	    $type = isset($prams["type"]) ? $prams["type"]:'general';//成员类型   manager 管理员   普通成员  general
	    
	    $perPage = $page['perPage']; // 每页记录数
	    $currPage = $page['currPage']; // 当前页
	    $offset = ($currPage - 1) * $perPage; // 偏移量
	    
	    $totalcount = count($this->tribe_mdl->get_manager_list($tribe_id,$type)); // 获取总记录数
	    $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
	    
	    
	    $list = $this->tribe_mdl->get_manager_list($tribe_id,$type,$perPage,$offset);
	    if($list){
	        foreach ($list as $key =>$val){
	            $logo = !empty($val['brief_avatar']) ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];
	            if(!$logo){
	                $logo = IMAGE_URL.$val['logo'];
	            }
	            
	            $list[$key]['corporation_name'] = $val['corporation_name'] ? $val['corporation_name']:$val['staff_corporation_name'];
	            unset($list[$key]['staff_corporation_name']);
	            unset($list[$key]['brief_avatar']);
	            unset($list[$key]['wechat_avatar']);
	            $list[$key]['logo'] = $logo;
	        }
	         
	    }
	   
	    // 返回数据
	    $return['data']['perpage'] = $perPage;
	    $return['data']['currentpage'] = $currPage;
	    $return['data']['totalcount'] = $totalcount;
	    $return['data']['totalpage'] = $totalpage;
	    $return['data']['listdate'] = $list;
	    
	    print_r(json_encode($return));
	    
	}
	
	
	/**
	 * 退出部落
	 */
	public function quit_tribe(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id',
	    ));
	    $customer_id = $this->session->userdata("user_id");//用户id
	     
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $tribe_id = $prams["tribe_id"];//部落id
	    
	    $tribe_detail = $this->tribe_mdl->get_tribe($tribe_id);
	    if(!$tribe_detail){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '部落不存在'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    $staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$customer_id,0);
	    if(!$staff_info){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '6',
	            'errorMessage' => '非法访问'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    $this->db->trans_begin(); // 事物执行方法中的MODEL。
	    $tribe_manager = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);
	    
	    if($tribe_manager){//如果是创建者退出部落则先把义工委权限给其它管理员
	        $is_Manager = 1;//是否管理员
	        $number = 1;//记录条数
	        $Manager = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//管理员
	    
	        $Manager_customer_id = 0;//需要转移义工委权限的ID
	        if($Manager){
	            $Manager_customer_id = $Manager[0]['customer_id'];
	        }else {
	            $is_Manager = 0;
	            $Member = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//部落成员
	            
	            if(!$Member){
	                //既没有管理员也没有部落成员
	                $aff = $this->tribe_mdl->del_tribe($tribe_id);
	                $row = $this->tribe_mdl->del_staff($staff_info['id']);
	               
	                if($aff){
	                    $return['responseMessage'] = array(
	                        'messageType' => 'success',
	                        'errorType' => '0',
	                        'errorMessage' => '操作成功'
	                    );
	                    $this->db->trans_commit();
	                    //删除聊天室
	                    $this->HuanXinGroupHandle($tribe_id,$customer_id,'delete');
	                }else{
	                    $this->db->trans_rollback();
	                    $return['responseMessage'] = array(
	                        'messageType' => 'error',
	                        'errorType' => '8',
	                        'errorMessage' => '操作失败'
	                    );
	                    print_r(json_encode($return));
	                    exit();
	                }
	                print_r(json_encode($return));
	                exit;
	            }
	            
	            $Manager_customer_id = $Member[0]['customer_id'];
	        }
	         
	        if(!$Manager_customer_id){
	            $this->db->trans_rollback();
	            $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '7',
	            'errorMessage' => '操作失败'
	             );
	            print_r(json_encode($return));
	            exit();
	        }
	    
	        //转移义工委权限
	        $rows = $this->tribe_mdl->set_host($tribe_id,$Manager_customer_id);
	        if(!$rows){
	            $this->db->trans_rollback();
	            $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '8',
	            'errorMessage' => '操作失败'
	             );
	            print_r(json_encode($return));
	            exit();
	            
	        }
	    }
	   
	    $aff = $this->tribe_mdl->del_staff($staff_info['id']);
	    
	    if(!$aff){
	        $this->db->trans_rollback();
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '9',
	            'errorMessage' => '操作失败'
	             );
	            print_r(json_encode($return));
	            exit();
	    }
	   
	    $this->db->trans_commit();
	    $return['responseMessage'] = array(
	        'messageType' => 'success',
	        'errorType' => '0',
	        'errorMessage' => '操作成功'
	    );
	    //退出聊天室
	    $this->HuanXinGroupHandle($tribe_id,$customer_id,'exit');
	    print_r(json_encode($return));
	}
	
	
	// ----------------------------------------------------------------------------
	//获取商会下所有的部落ID
	private  function get_app_tribe_ids(){
	    $label_id = $this->session->userdata("label_id");
	
	    $this->load->model('App_label_mdl');
	    $status = 'show_app_tribe_ids';
	    $app_labe_info = $this->App_label_mdl->Load( $label_id, $status );
	
	    //将二级标签下部落全部拿出来堆放在一起方便进行处理
	    $label_infos = $this->App_label_mdl->Load_tribe_app_label($label_id);//获取标签信息
	    $app_tribe_id = '';
	    foreach ($label_infos as $key =>$val ){
	        $app_tribe_id = trim($app_tribe_id,",");
	        if($val['tribe_ids']){
	            $app_tribe_id .= ','.$val['tribe_ids'];
	        }
	
	    }
	
	    if( $app_labe_info['tribe_id'] )
	    {
	        $app_tribe_id .= ','.$app_labe_info['tribe_id'];
	    }
	
	    $ids = explode(',',$app_tribe_id);//字符串转数组
	    $app_tribe_ids = array_unique($ids);
	
	    return $app_tribe_ids;
	}
	// ----------------------------------------------------------------------------
	
	/**
	 * 创建
	 */
	public function create(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'name',
				'content',
				'region',
				'industry',
				'source'
		));
		
		$name = $prams["name"];//部落名称
		$content = $prams["content"];//简介
		$region = $prams["region"];//省份-城市
		$industry = $prams["industry"];//行业
		$source = $prams["source"];//来源3安卓4ios
		$datetime = date("Y-m-d H:i:s");
		$customer_id = $this->session->userdata("user_id");//用户id
		$corporation_id = $this->session->userdata("corporation_id");//企业id
		$customer_name = $this->session->userdata('customer_name');//真实姓名
		$corporation_name = $this->session->userdata('corporation_name');//企业名称
		$mobile = $this->session->userdata("mobile");//手机号码
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//查询判断我是否属于部落义工委
// 		$is_ruler = $this->tribe_mdl->get_MyTribe($customer_id);
// 		if($is_ruler){
// 			$return['responseMessage'] = array(
// 					'messageType' => 'error',
// 					'errorType' => '6',
// 					'errorMessage' => '你是管理者，不能创建部落'
// 			);
// 			print_r(json_encode($return));exit;
// 		}
		
		
		//判断是否绑定手机
		if(!$mobile){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '您还没绑定手机'
			);
			print_r(json_encode($return));exit;
		}
		
		//地址处理
		$region = explode("-",$region);
		if(count($region) == 2){
			$provice = $region[0];
			$city = $region[1];
		}else{
			$region = null;
		}
		
		
		if(mb_strlen($name) < 1 || mb_strlen($name) > 10 || !$region || !$industry || !array_key_exists("logo",$_FILES) ){ //|| !array_key_exists("shop_img",$_FILES)
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '参数错误'
			);
			print_r(json_encode($return));exit;
		}
		
		
		//查询名称是否存在
		$is_exists = $this->tribe_mdl->check_name($name);
		if($is_exists){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '9',
					'errorMessage' => '部落名称已经被使用'
			);
			print_r(json_encode($return));exit;
		}
		
		//循环上传图片
		$this->load->helper("uploads");
		$images = array();
		foreach ($_FILES as $k => $v){
			$images[$k] = file_upload("uploads/tribe/images/",null,null,$k);
			if(!$images){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '10',
						'errorMessage' => '上传图片失败'
				);
				print_r(json_encode($return));exit;
			}
		}
		
		if(!empty($images["shop_img"])){
		    $shop_img = "uploads/tribe/images/".$images["shop_img"]["file_name"];
		}else{
		    $shop_img = '';
		}
		
		$this->db->trans_begin();//事务
		$parameter = array(
				"name" => $name,
				"shop_img" => $shop_img,
				"content" => $content,
				"logo" => "uploads/tribe/images/".$images["logo"]["file_name"],
				"provice" => $provice,
				"city" => $city,
				"industry" => $industry,
				"created_at" => $datetime,
				"source" => $source,
				"customer_id" => $customer_id
		);
		$tribe_id = $this->tribe_mdl->create($parameter);//添加部落
		if(!$tribe_id){
			$this->db->trans_rollback();
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '11',
					'errorMessage' => '创建部落失败'
			);
			print_r(json_encode($return));exit;
		}
		
		$parameter = array(
				"customer_id" => $customer_id,
				"grade" => ($corporation_id?2:1),
				"member_name" => $customer_name,
				"is_host" => 1,//义工委为1
				"corporation_name" => $corporation_name,
				"tribe_id" => $tribe_id,
				"provice" => $provice,
				"city" => $city,
				"mobile" => $mobile,
		        "status" => 2,
				"created_at" => $datetime,
				"industry" => $industry
		);
		$row = $this->tribe_mdl->add_staff($parameter);//添加成员
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '11',
					'errorMessage' => '创建部落失败'
			);
			print_r(json_encode($return));exit;
		}
		$this->db->trans_commit();
		print_r(json_encode($return));
	}
	
	// ---------------------------------------------------------------
	
	/**
	 * 设置部落成员加入是否需要审核
	 */
	function update_staff_join(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id',
	        'staff_status'
	    ));
	    $tribe_id = $prams['tribe_id'];
	    $staff_status = $prams['staff_status'];//族员是否需要审核0否1是'
	    
	    $customer_id = $this->session->userdata("user_id");//用户id
	    
	    $param["staff_status"] = $staff_status?1:0;
	    $param["update_at"] = date("Y-m-d H:i:s");
	    $row = $this->tribe_mdl->save($tribe_id,$customer_id,$param);
	    if($row){
	        $return['responseMessage'] = array(
	            'messageType' => 'success',
	            'errorType' => '0',
	            'errorMessage' => '设置成功'
	        );
	    }else{
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '设置失败'
	        );
	    }
	    echo json_encode($return);
	}
	
	// ---------------------------------------------------------------
	/**
	 * 修改部落资料
	 */
	function update(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$this->_check_prams($prams, array(
		    'tribe_id',
		));
		$tribe_id = $prams["tribe_id"];//部落id
		
		$region = !empty($prams["region"])?$prams["region"]:null;//地区
		$content = !empty($prams["content"])?$prams["content"]:null;//简介
		$industry = !empty($prams["industry"])?$prams["industry"]:null;//行业
		$name = !empty($prams["name"])?$prams["name"]:null;//部落名称
		$datetime = date("Y-m-d H:i:s");
		$customer_id = $this->session->userdata("user_id");//用户id
		
		$this->load->helper("uploads");
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//审核不通过重新填写执行
		if($tribe["status"] == 3){
			$parameter["status"] = 1;
			$parameter["content"] = $content;
			if($name){
				$tribe = $this->tribe_mdl->check_name($name);
				if($tribe && $tribe["customer_id"] != $customer_id){
					$return['responseMessage'] = array(
							'messageType' => 'error',
							'errorType' => '7',
							'errorMessage' => '部落已经存在'
					);
					print_r(json_encode($return));
					exit();
				}else{
					$parameter["name"] = $name;
				}
			}
		}
		
		//如果有商城背景图片上传执行
		if(array_key_exists("shop_img",$_FILES) && $_FILES["shop_img"]["error"] == 0){
			$images = file_upload("uploads/tribe/images/",null,null,"shop_img");
			if(!$images){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '8',
						'errorMessage' => '上传图片失败'
				);
				print_r(json_encode($return));
				exit();
			}else{
				$parameter["shop_img"] = "uploads/tribe/images/".$images["file_name"];
			}
		}
		
		//如果有logo上传执行
		if(array_key_exists("logo",$_FILES) && $_FILES["logo"]["error"] == 0){
			$images = file_upload("uploads/tribe/images/",null,null,"logo");
			if(!$images){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '8',
						'errorMessage' => '上传图片失败'
				);
				print_r(json_encode($return));
				exit();
			}else{
				$parameter["logo"] = "uploads/tribe/images/".$images["file_name"];
			}
		}
		
		
		//如果有地区修改执行
		if($region){
			$region = explode("-",$region);
			if(count($region) == 2){
				$provice = $region[0];
				$city = $region[1];
				
				$parameter["provice"] = $provice;
				$parameter["city"] = $city;
			}else{
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '9',
						'errorMessage' => '地址错误'
				);
				print_r(json_encode($return));
				exit();
			}
		}
		
		//如果有简介修改执行
		if($content){
			if( mb_strlen($content) < 1 ){//|| mb_strlen($content) > 150
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '10',
						'errorMessage' => '简介参数错误'
				);
				print_r(json_encode($return));
				exit();
			}
			$parameter["content"] = $content;
		}
		
		//如果有简介图片上传执行
		if((array_key_exists("content_img1",$_FILES) && $_FILES["content_img1"]["error"] == 0) || (array_key_exists("content_img2",$_FILES) && $_FILES["content_img2"]["error"] == 0)){
			if(array_key_exists("content_img1",$_FILES)){
				$images = file_upload("uploads/tribe/images/",null,null,"content_img1");
			}else{
				$images = file_upload("uploads/tribe/images/",null,null,"content_img2");
			}
			if(!$images){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '8',
						'errorMessage' => '上传图片失败'
				);
				print_r(json_encode($return));
				exit();
			}else{
				$parameter["content_img"] = "uploads/tribe/images/".$images["file_name"];
			}
		}
		
		//如果有行业修改执行
		if($industry){
			$parameter["industry"] = $industry;
		}
		
		$parameter["update_at"] = $datetime;
		$row = $this->tribe_mdl->save($tribe_id,$parameter);//更新部落
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '11',
					'errorMessage' => '更新失败'
			);
			print_r(json_encode($return));
			exit();
		}
		print_r(json_encode($return));
		
	}
	
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 申请部落列表
	 */
	public function apply_list(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		$page = $this->n;
		// 检验参数
		$this->_check_prams($prams, array(
				'keyword',
		        'tribe_id'
		));
		
		$tribe_id = $prams['tribe_id'];//部落id
		$keyword = $prams["keyword"];//关键词
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		$limit = $page['perPage']; // 每页记录数
		$page = $page['currPage']; // 当前页
		if(0 == $page){
			$page = 1;
		}
		$offset = ($page-1)*$limit;//偏移量
		$return["data"]["apply_list"] = $this->tribe_mdl->tribe_member_list($tribe_id,$keyword,null,null,null,null,null,$limit,$offset,"list",array($customer_id));//查询申请列表
		echo json_encode($return);
		
	}
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 族员信息
	 */
	public function Family_member(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_staffId',
		        'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];//部落id
		$tribe_staffId = $prams["tribe_staffId"];//部落族员id
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		//查询族员信息
		$staff_info = $this->tribe_mdl->load_tribe_staff($tribe_id,$tribe_staffId);
		if(!$staff_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '不存在此族员'
			);
			print_r(json_encode($return));
			exit();
		}
		$return["data"]["staff_info"] = $staff_info;
		echo json_encode($return);
		
		
	}
	
	// ----------------------------------------------------------------------------
	/**
	 * 环信即时通讯 部落聊天室退出及添加成员  默认添加聊天室成员
	 *
	 */
	private function HuanXinGroupHandle($tribe_id = 0,$customer_id = 0,$type = "join"){
	    //删除聊天室成员
	    include_once FCPATH.'application/libraries/Easemob.php';
	    if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/' || base_url()=='http://test51ehw.9-leaf.com/'){
               //测试
               $parm['client_id'] = 'YXA6bZRHEG0eEeeyLoGg_S8Sfg';
               $parm['client_secret'] = 'YXA66J5F_NoG2GZ_8fcQRLNLxSdHqlI';
               $parm['org_name'] = '1141170719115422';
               $parm['app_name'] = 'tribebox-test';
                
           }else{
               //正式
               $parm['client_id'] = 'YXA60WhJsAsdEeiqD-e_-6s4uw';
               $parm['client_secret'] = 'YXA6T3McYmkmiIB5cM8pJBhF3JHXVBc';
               $parm['org_name'] = '1162180206115305';
               $parm['app_name'] = '51web';
           }
	    $h = new Easemob($parm);
	     
	    $this->load->model('Chat_message_mdl','chat');
	    $Channel = $this->chat->loadChannelById(0,$tribe_id);
	    if($Channel){
	        if($type == 'delete'){
	            //删除群组
	            $h->deleteGroup($Channel['huanxin_group_id']);
	            return;
	        }
	        
	        $Channel_id = $Channel['id'];
	        $member = $this->chat->getChannelMember($Channel_id,$customer_id);
	        if($type == 'join'){//添加聊天室成员
	            if($member){
	            }else{
	                $this->chat->addChannelMember($Channel_id,$Channel['huanxin_group_id'],$customer_id);//本地服务器添加
	                //判断当前用户是否在环信聊天室
	                $huanxin_member_info =  $h->getGroupUsers($Channel['huanxin_group_id']);
	                $huanxin_GroupMember = array();
	                $huanxin_GroupOwner = 0;
	                foreach ($huanxin_member_info['data'] as $key =>$val){
	                    //获取环信聊天室上的成员
	                    if(!empty($val['member'])){
	                        $huanxin_GroupMember[] =  $val['member'];
	                    }
	                    //环信聊天室的拥有者
	                    if(!empty($val['owner'])){
	                        $huanxin_GroupOwner =  $val['owner'];
	                    }
	                }
	                //当没有成员  或当前用户不存在聊天室内 则添加
	                if(!$huanxin_GroupMember || !in_array($customer_id, $huanxin_GroupMember)){
	                    $h->addGroupMember($Channel['huanxin_group_id'],$customer_id);
	                }
	            }
	        }else{//删除聊天室成员
	            if($member){
	                //删除聊天室成员
	                $this->chat->delChannelMember($member['id']);
	                $h->deleteGroupMember($Channel['huanxin_group_id'],$customer_id);
	            }
	        }
	    }
	}
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 族员审核
	 */
	function staff_audit(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'staff_id',
				"status",
		        'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];//部落id
		$staff_id = $prams["staff_id"];
		$status = $prams["status"];//状态：2同意3拒绝
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//验证参数
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if($staff_id < 1 || !in_array($status,array(2,3)) || !$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '参数错误'
			);
			print_r(json_encode($return));
			exit();
		}
		$tribe_info = $this->tribe_mdl->get_tribe_customet_info($staff_id);//查询组员信息
		if(!$tribe_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '族员不存在此部落'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$parameter = array(
				"status" => $status,
				"id" => $staff_id,
				"update_at" => date("Y-m-d H:i:s")
		);
		
		$row = $this->tribe_mdl->update_member($parameter,$tribe_id);//更新
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '审核失败'
			);
		}else{
		    //发送短信
		    $this->load->helper("message");
		    $mobile = $tribe_info['mobile'];
		    
		    $this->load->model("Customer_mdl");
		    $customer = $this->Customer_mdl->load_by_mobile($mobile);
		    
		    $param['customer_id'] = $customer['id'];
		  
			if($status == 2){
			    $param['resource'] = "Tribe/home/{$tribe_id}";
			    $req = json_decode(  ToConect($param),true);
			    $content = "欢迎加入".$tribe['name']."，快点去认识一下部落的其他成员，寻找自己的合作伙伴，点击进入：".$req['url_short']." 退订回N【51易货网】";
			    
			    //加入聊天室
			    $this->HuanXinGroupHandle($tribe_id,$tribe_info['customer_id'],"join");
			    
// 				$content = "欢迎加入".$tribe['name']."，快点去认识一下部落的其他成员，寻找自己的合作伙伴，如有问题，请致电客服电话：4000029777 退订回N【51易货网】";
			}elseif($status == 3){
			    $param['resource'] = "Tribe/tribe_detail/{$tribe_id}";
			    $req = json_decode(  ToConect($param),true);
			    $content = "您加入的部落审核不通过，点击查看：".$req['url_short']." 详情请咨询：4000029777 退订回N【51易货网】";
			}
			
			$source = 4;//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
			$sms = send_message($mobile,0,$content,2,$source);
		}
		echo json_encode($return);exit;
	}
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 活动管理列表
	 */
	function Activity_management(){
	    $prams = $this->p;
		$return = $this->return;
		$page = $this->n;
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		// 检验参数
		$this->_check_prams($prams, array(
		    'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];//部落id
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model('Tribe_activity_mdl');
		
		$limit = $page["perPage"];
		$page = $page["currPage"];//页数
		if(0 == $page)
		{
			$page = 1;
		}
		$offset = ($page-1)*$limit;//偏移量
		
		$return["data"]["activity_list"] = $this->Tribe_activity_mdl->tribe_activity($tribe_id,$customer_id,$limit,$offset);//查询我的部落活动列表
		echo json_encode($return);exit;
	}
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 活动详情
	 */
	public function activity_detaile(  ){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id'
		));
		
		$id = $prams["id"];//活动Id
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model('Tribe_activity_mdl');
		
		$sift['where']['id'] = 0 == $id ? 0 : $id;
		$sift['where']['customer_id'] = $customer_id;
		$activity_info = $this->Tribe_activity_mdl->Load_Activity( $sift );
		
		
		//验证活动是否存在
		if(!$activity_info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '活动不存在'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$activity_info["content"] = $activity_info["content"];
		$return["data"]['activity_info'] = $activity_info;
		echo json_encode($return);exit;
		
	}
	
	// ----------------------------------------------------------------------------
	
	/**
	 * 发布活动 or 修改活动
	 */
	function save_activity(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id',
				"name",
				"content",
				"start_time",
				"end_time",
		        'tribe_id'
		));
		
		$tribe_id = $prams['tribe_id'];//部落id
		$id = $prams["id"];//活动id
		$name = $prams["name"];//活动名称
		$content =  str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$prams["content"]));//内容
		$start_time = $prams["start_time"];//开始时间
		$end_time = $prams["end_time"];//结束时间
		$customer_id = $this->session->userdata("user_id");//用户id
		$datetime = date("Y-m-d H:i:s");
		
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->helper("uploads");
		$this->load->helper("verification_helper");
		$this->load->model("tribe_activity_mdl");
		
		
		//验证参数
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!strlen($name) || !$content || !validateDate($start_time) || !validateDate($end_time) || !$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '数据错误'
			);
			print_r(json_encode($return));
			exit();
		}
		$tribe_id = $tribe["id"];//部落id
		
		
		if($id){
			$activity = $this->tribe_activity_mdl->tribe_activity_info($id,$tribe_id);//查询活动
			if(!$activity){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '更新的活动不存在'
				);
				print_r(json_encode($return));
				exit();
			}
		}
		
		
		//上传图片
		if(!empty($_FILES["banner_img"]) && $_FILES["banner_img"]["error"] == 0){
			$images = file_upload("uploads/tribe_content/images/",null,null,"banner_img");
		}else{
			if($id){
				$images["file_name"] = str_replace("uploads/tribe_content/images/","",$activity["banner_img"]);
			}else{
				$images = null;
			}
			
		}
		if(!$images){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '上传图片失败'
			);
			echo json_encode($return);exit;
		}
		$parameter["banner_img"] = "uploads/tribe_content/images/".$images["file_name"];
		$parameter["name"] = $name;
		$parameter["content"] = $content;
		$parameter["start_time"] = $start_time;
		$parameter["end_time"] = $end_time." 23:59:59";
		$parameter["tribe_id"] = $tribe_id;
		$parameter["update_at"] = $datetime;
		$parameter["created_at"] = $datetime;
		$parameter["status"] = 0;
		
		if(isset($prams["display"]) && $prams["display"] == 0 || isset($prams["display"]) && $prams["display"] == 1 ){
		    	$parameter["display"] = $prams["display"];
		}
		
		if($id){
			$row = $this->tribe_activity_mdl->update($parameter,$id,$tribe_id);//更新发布
		}else{
			$row = $this->tribe_activity_mdl->create($parameter);//添加发布
		}
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '发布失败'
			);
			print_r(json_encode($return));exit();
		}
		
		print_r(json_encode($return));
	}
	
	// -------------------------------------------------------------------------------
	
	/**
	 * ajax获取公告管理
	 */
	function announcements(){
	    $prams = $this->p;
		$return = $this->return;
		$page = $this->n;
		
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		// 检验参数
		$this->_check_prams($prams, array(
		    'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];//部落id
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model('tribe_content_mdl');
		
		$limit = $page["perPage"];
		$page = $page["currPage"];//页数
		if(0 == $page)
		{
			$page = 1;
		}
		$offset = ($page-1)*$limit;//偏移量
		$return["data"]["announcement_list"] = $this->tribe_content_mdl->load_announcements_list($customer_id,$tribe_id,$limit,$offset);//查询我的部落活动列表
		
		echo json_encode($return);exit;
	}
	
	// -------------------------------------------------------------------------------
	
	/**
	 * 公告详情
	 */
	public function announcement_detaile(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id',
		        'tribe_id'
		));
		
		$tribe_id = $prams['tribe_id'];//部落id
		$id = $prams["id"];//公告id
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model("tribe_content_mdl");
		
		//查询公告
		$sift['where']['customer_id'] = $customer_id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['where']['id'] = $id;
		$sift['where']['status'] = array(0,1,2);
		$info = $this->tribe_content_mdl->Load( $sift );
		
		if(!$info){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '公告不存在'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model("Tribe_read_mdl");
		//查询判断是否已经阅读，如果无则添加
		$row = $this->Tribe_read_mdl->check_read($customer_id,$id,1);
		if(!$row && $info["status"] == 1){
		    $parameter = array(
		        "customer_id" => $customer_id,
		        "type" => 1,
		        "tribe_id" => $tribe_id,
		        "obj_id" => $id
		    );
		    $this->Tribe_read_mdl->create($parameter);
		}
		
		
		
		$info["content"] = $info["content"];
		$return["data"]["info"] = $info;
		echo json_encode($return);exit;
		
	}
	
	// -------------------------------------------------------------------------------
	
	/**
	 * 发布公告 or 修改公告
	 */
	function save_notice(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id',
				'title',
				"content",
		        "sendee_id",
		        'tribe_id'
		));
		
		$tribe_id = $prams['tribe_id'];//部落id
		$id = $prams["id"];
		$title = $prams["title"];//活动名称
		$content = str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$prams["content"]));//内容
		
		$datetime = date("Y-m-d H:i:s");
		$customer_id = $this->session->userdata("user_id");//用户id
		
		$this->load->helper("uploads");
		$this->load->model("tribe_content_mdl");
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		//验证数据是否符合要求
		if(!strlen($title) || !$content ){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '参数错误'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '10',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		
		if($id){
			//查询公告
			$sift['where']['customer_id'] = $customer_id;
			$sift['where']['tribe_id'] = $tribe_id;
			$sift['where']['id'] = $id;
			$sift['where']['status'] = array(0,1,2);
			//部落信息
			$this->load->model('Tribe_content_mdl');
			$info = $this->Tribe_content_mdl->Load( $sift );//查询公告
			if(!$info){
				$return['responseMessage'] = array(
						'messageType' => 'error',
						'errorType' => '7',
						'errorMessage' => '公告不存在'
				);
				print_r(json_encode($return));
				exit();
			}
		}
		
		//处理接收人数据
		$sendee_id = $prams['sendee_id'];
		$sendee_ids = null;
		if(is_array($sendee_id)){
		    $sendee_id = array_unique($sendee_id);
		    foreach ($sendee_id as $v){
		        if($v && is_numeric($v)){
		            $sendee_ids .= ",".$v;
		        }
		    }
		    $sendee_ids = trim($sendee_ids,",");
		} 
		
		
		//上传图片
		if(!empty($_FILES["title_img"]) && $_FILES["title_img"]["error"] == 0){
			$images = file_upload("uploads/tribe_content/images/",null,null,"title_img");
		}else{
			if($id){
				$images["file_name"] = str_replace("uploads/tribe_content/images/","",$info["title_img"]);
			}else{
				$images = null;
			}
			
		}
		if(!$images){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '8',
					'errorMessage' => '上传图片失败'
			);
			print_r(json_encode($return));
			exit();
		}
		$parameter["title_img"] = "uploads/tribe_content/images/".$images["file_name"];
		$parameter["title"] = $title;
		$parameter["content"] = str_replace("'","&acute;",$content);
		$parameter["tribe_id"] = $tribe_id;
		$parameter["last_updated_time"] = $datetime;
		$parameter["create_time"] = $datetime;
		$parameter["status"] = 0;
		$parameter['sendee_id'] = $sendee_ids;
		
		if(isset($prams["display"]) && $prams["display"] == 0 || isset($prams["display"]) && $prams["display"] == 1 ){
		    $parameter["display"] = $prams["display"];
		}
		
		if($id){
			$row = $this->tribe_content_mdl->update($id,$tribe_id,$parameter);//更新公告
		}else{
			$row = $this->tribe_content_mdl->create($parameter);//发布公告
		}
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '9',
					'errorMessage' => '发布失败'
			);
		}
		
		print_r(json_encode($return));
		exit();
		
	}
	
	/**
	 * 获取圈子管理列表
	 */
	function topic_list(){
	    $prams = $this->p;
		$return = $this->return;
		$page = $this->n;
		$customer_id = $this->session->userdata("user_id");//用户id
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		// 检验参数
		$this->_check_prams($prams, array(
		    'tribe_id'
		));
		$tribe_id = $prams['tribe_id'];//部落id
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->model('tribe_topic_mdl');
		$limit = $page["perPage"];
		$page = $page["currPage"];//页数
		if(0 == $page)
		{
			$page = 1;
		}
		$offset = ($page-1)*$limit;//偏移量
		
		$TopicList = $this->tribe_topic_mdl->ManageTopicList($tribe_id,$limit,$offset);//查询我的部落活动列表
		foreach($TopicList as $key => $val){
			$bg_img = explode(";", $val["images"]);
			$bg_img = array_filter($bg_img);
			$TopicList[$key]["images"] = $bg_img;
		}
		$return["data"]["TopicList"] = $TopicList;
		echo json_encode($return);exit;
	}
	
	/**
	 * 控制显示手机号码
	 */
	public function updateShowMobile(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'show_mobile',
	        'tribe_staff_id'
	    ));
	    
	    $customer_id = $this->session->userdata("user_id");//用户id
	    //1显示 2隐藏
	    $show_mobile = $prams['show_mobile'];//部落id
	    $staff_id = $prams['tribe_staff_id'];
	   
	    if($show_mobile !=1 && $show_mobile !=2){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '4',
	            'errorMessage' => '参数错误'
	        );
	        print_r(json_encode($return));
	        exit;
	    }
	    
	    $res = $this->tribe_mdl->update_show_mobile_status($show_mobile,$staff_id,$customer_id);
	    if(!$res){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '更新失败'
	        );
	    }
	    $return['responseMessage'] = array(
	        'messageType' => 'success',
	        'errorType' => '0',
	        'errorMessage' => '更新成功'
	    );
	    print_r(json_encode($return));
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 义工委删除话题
	 */
	public function Delete_Topic(){
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'id',
		        'tribe_id'
		));
		
		$tribe_id = $prams['tribe_id'];//部落id
		$id = $prams["id"];//话题id
		$customer_id = $this->session->userdata("user_id");//用户id
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		//查询判断我是否属于部落义工委
		$tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
		if(!$tribe){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '权限不足'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$sift['where']['id'] = 0==$id?-1:$id;
		$sift['where']['tribe_id'] = $tribe_id;
		$sift['set']['status'] = 0;
		
		$this->load->model('Tribe_topic_mdl');
		$row = $this->Tribe_topic_mdl->Update( $sift );
		if(!$row){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '删除失败'
			);
		}
		echo json_encode($return);exit;
		
	}
	
	
	
	/**
	 * 更换圈子背景图片
	 */
	public function Update_Background()
	{
		// 获取参数
		$prams = $this->p;
		$return = $this->return;
		// 检验参数
		$this->_check_prams($prams, array(
				'tribe_id'
		));
		
		$tribe_id = $prams["tribe_id"];//部落id
		$customer_id = $this->session->userdata("user_id");//用户id
		
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$tribe_info = $this->tribe_mdl->load( $tribe_id,$customer_id );
		if( !$tribe_info || !$tribe_info["tribe_staff_id"] || $tribe_info['status'] != 2)
		{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '未加入此部落'
			);
			print_r(json_encode($return));
			exit();
			
		}
		$tribe_staff_id = $tribe_info['tribe_staff_id'];
		
		if( !empty( $_FILES['file'] ) )
		{
			$this->load->helper("uploads_helper");
			$file = "uploads/teibe_".$tribe_id.'/background/';
			$img = file_upload($file,date("YmdHis").rand(0,999999));
			if($img){
				$images = $file.$img['file_name'];
				$data['bg_img'] = $images;
				$data['id'] = $tribe_info['tribe_staff_id'];
				$row = $this->tribe_mdl->update_member( $data );
			}
		}
		
		if( empty( $row ) )
		{
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '7',
					'errorMessage' => '更改背景失败'
			);
			print_r(json_encode($return));
			exit();
		}
		
		echo json_encode( $return );exit;
	}
	
	
	/**
	 * 富文本编辑器上传图片
	 */
	function editor_uploads(){
		// 获取参数
		$return = $this->return;
		
		$customer_id = $this->session->userdata("user_id");//用户id
		if ($customer_id == null || $customer_id == "") {
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '5',
					'errorMessage' => '用户未登录'
			);
			print_r(json_encode($return));
			exit();
		}
		
		$this->load->helper("uploads_helper");
		$file = "uploads/fck/images";
		$image = file_upload($file);
		if(!$image){
			$return['responseMessage'] = array(
					'messageType' => 'error',
					'errorType' => '6',
					'errorMessage' => '上传图片失败'
			);
			print_r(json_encode($return));
			exit();
		}
		$return["data"]["file_path"] = IMAGE_URL.$file."/".$image["file_name"];
		echo json_encode($return);
	}
	
	
	//------------个人形象开始------------------
	
	/**
	 * 个人形象
	 */

	function  album_info(){
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
	    $this->_check_prams($prams, array(
	        'tribe_id',
	        'user_id'
	    ));
	    
	    $user_id = $this->session->userdata("user_id");//用户id
	    if ($user_id == null || $user_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    
	    $tribe_id = $prams["tribe_id"];//部落id
	    $customer_id = $prams["user_id"];//用户id
	    
	    $this->load->model('Customer_mdl');
	    $customer = $this->Customer_mdl->load($customer_id);
	    
	    $mobile = substr_replace($customer['mobile'],'********',2,8);
	    
	    $return['data']['real_name'] = $customer['real_name'] ? $customer['real_name']:$mobile;
	    $return['data']['bg_img'] = $customer['bg_img'];
	    $this->load->model('Customer_album_mdl');
	    //获取用户相册相片数
	    $albums_list = $this->Customer_album_mdl->load_albums($customer_id,$tribe_id);
	    $return['data']['albums_list_count'] = count($albums_list);
	    
	    $this->load->model("tribe_mdl");
	    
	    $all = $this->Customer_album_mdl->load_albums_list($customer_id,$tribe_id);
	    $totalcount = 0;
	    if($all){
	        // 获取总记录数
	        foreach ($all as $k => $v){
	            $all_photo = $this->Customer_album_mdl->load_ByAlbum_Id($v['id']);
	            if($all_photo){
	                $totalcount ++;
	            }
	        }
	    }
	   
				
		$perPage = $page['perPage']; // 每页记录数
		$currPage = $page['currPage']; // 当前页
		$offset = ($currPage - 1) * $perPage; // 偏移量
		$totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
		
	    //获取用户相册
	    $albums_list = $this->Customer_album_mdl->load_albums_list($customer_id,$tribe_id,$perPage,$offset);
	    $albums =array();
	    if(count($albums_list) > 0){
	        foreach ($albums_list as $k => $val){
	            $photo = $this->Customer_album_mdl->load_ByAlbum_Id($val['id']);
	            if(count($photo) > 0){
	                $list = array(
	                    'corporation_name'=>'',
	                    'job'=>'',
	                    'real_name'=>'',
	                );
	                $list['album_id'] = $val['id'];
	                $list['is_show'] = $val['is_show'];
	                $list['tribe_id'] = $val['tribe_id'];
	                $list['created_at'] = $val['created_at'];
	                $list['remark'] = empty($val['remark']) ? "":$val['remark'];
	                $list['from_customer_id'] = $val['from_customer_id'];
	                $list['tribe_name'] = '';
	                if($val['tribe_id'] != $tribe_id){
	                    $tribe_detail = $this->tribe_mdl->get_tribe($val['tribe_id']);
	                     $list['tribe_name'] = $tribe_detail['name'];
	                }
	                
	                if($val['from_customer_id']){
	                    $crop_info = $this->Customer_album_mdl->get_crop_info($val['from_customer_id'],$tribe_id);
	                     
	                    $this->load->model('Customer_mdl');
	                    $customer_info = $this->Customer_mdl->load($val['from_customer_id']);
	                    $list['job'] = $customer_info['job'];
	                    $list['real_name'] = $customer_info['real_name'];
	                    if($crop_info){
	                        $list['corporation_name'] = $crop_info['corporation_name'];
	                    }
	                }
	                 
	                $list['photo_list'] = $photo;
	                $albums[]= $list;
	            }
	        }
	    }
	    // 返回数据
	    $return['data']['perpage'] = $perPage;
	    $return['data']['currentpage'] = $currPage;
	    $return['data']['totalcount'] = $totalcount;
	    $return['data']['totalpage'] = $totalpage;
	    $return['data']['listdate'] = $albums;
	    
	    print_r(json_encode($return));
	}
	
	/**
	 *  删除相册
	 *
	 */
	public function del_album(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    $page = $this->n;
	 
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'album_id',
	    ));
	     
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    $album_id = $prams["album_id"];//相册ID
	   
	    $this->load->model('Customer_album_mdl');
	
	    $Album_info = $this->Customer_album_mdl->load_album($album_id);
	    if(!$Album_info){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '6',
	            'errorMessage' => '相册不存在'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    $aff = $this->Customer_album_mdl->del_AlbumByID($album_id);
	    if($aff){
	        $return['responseMessage'] = array(
	            'messageType' => 'success',
	            'errorType' => '0',
	            'errorMessage' => '删除成功'
	        );
	        $return['status'] = true;
	    }else{
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '7',
	            'errorMessage' => '删除失败'
	        );
	    }
	  print_r(json_encode($return));
	       
	}
	
	
	/**
	 * 上传相册
	 */
	function upload_album(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	    
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'tribe_id',
	        'user_id'
	    ));
	    
	    $year = date("Y",time());
	    $month = date("m",time());
	    $day = date("d",time());
	    
	    $tribe_id = $prams["tribe_id"];//相册人ID
	    $customer_id = $prams["user_id"];//相册人ID
	    $from_customer_id = empty($prams["from_customer_id"]) ? 0:$prams["from_customer_id"];//他人上传ID
	    $remark = empty($prams["remark"]) ? '':$prams["remark"];//备注
	    $is_show = empty($prams["is_show"]) ? 0:$prams["is_show"];//备注
	   
	  
	    if( !empty( $_FILES['file'] ) )
	    {
	        $this->load->model('Customer_album_mdl');
	        $created_at = date("Y-m-d H:i:s",time());
	        //成员ID
	        $this->load->model('Tribe_mdl');
	        $Ts_Info = $this->Tribe_mdl->Customer_Ts_Info($customer_id,$tribe_id);
	        $post['tribe_staff_id'] =  $Ts_Info['staff_id'];
	        $post['created_at'] = $created_at;
	        $post['tribe_id'] = $tribe_id;
	        $post['customer_id'] = $customer_id;
	        $post['is_show'] =  $is_show;
	        if($remark){
	            $post['remark'] =  $remark;
	        }
	        if($from_customer_id){
	            $post['from_customer_id'] = $from_customer_id;
	        }
	        
	        $album_id =$this->Customer_album_mdl->create_Album($post);
	        if(!$album_id){
	            error_log($this->db->last_query());
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '8',
	                'errorMessage' => '发布失败'
	            );
	            print_r(json_encode($return));
	            exit;
	        }
	        // 图片 初始化数据
	        $save_path = "uploads/album/$customer_id/$year/$month/$day/";
	        
	        $path = FCPATH.UPLOAD_PATH. $save_path;
	        
	        if ( !file_exists( $path ) )
	        {
	            mkdir($path,0777,true);
	        }
	        
	        $this->load->library('upload');
	        
	        if(count($_FILES) > 0){
	            $count=count($_FILES["file"]["name"]);//页面取的默认名称
	            for($i=0;$i<$count;$i++){
	                $field_name = $_FILES["file"]['name'][$i]. '_' . $i;
	                $_FILES[$field_name] = array(
	                    'name' => $_FILES["file"]['name'][$i],
	                    'size' => $_FILES["file"]['size'][$i],
	                    'type' => $_FILES["file"]['type'][$i],
	                    'tmp_name' => $_FILES["file"]['tmp_name'][$i],
	                    'error' => $_FILES["file"]['error'][$i]
	                );
	                $config['upload_path'] = $path;
	                $config['allowed_types'] = 'gif|jpg|png|jpeg';
	                $config['max_size'] = '2097152';
	                $config['file_name'] = date("YmdHis").rand(0,999999);
	        
	                $this->upload->initialize($config);
	                if ($this->upload->do_upload($field_name)) {
	                    $img = $this->upload->data();
	                    $image['customer_id']= $customer_id;
	                    $image['album_id'] = $album_id;
	                    $image['path']= $save_path.$img['file_name'];
	                    $image['created_at']= $created_at;
	                    $images[]= $image;
	                }
	            }
	            //添加数据
	            $id = $this->Customer_album_mdl->Create( $images );
	            if($id){
	                $return['responseMessage'] = array(
	                    'messageType' => 'success',
	                    'errorType' => '0',
	                    'errorMessage' => '发布成功'
	                );
	                $return['tribe_name'] = '';
	                if($is_show){
	                    $tribe_detail = $this->tribe_mdl->get_tribe($tribe_id);
	                    $return['tribe_name'] = $tribe_detail['name'];
	                }
	                $return['corporation_name'] ='';
	                $return['job'] ='';
	                $return['real_name'] ='';
	                if($from_customer_id){
	                    $crop_info = $this->Customer_album_mdl->get_crop_info($from_customer_id,$tribe_id);
	                    
	                    $this->load->model('Customer_mdl');
	                    $customer_info = $this->Customer_mdl->load($from_customer_id);
	                    $return['job'] = $customer_info['job'];
	                    $return['real_name'] = $customer_info['real_name'];
	                    if($crop_info){
	                        $return['corporation_name'] = $crop_info['corporation_name'];
	                    }
	                }
	               
	            }else{
	                error_log($this->db->last_query());
	                $return['responseMessage'] = array(
	                    'messageType' => 'error',
	                    'errorType' => '10',
	                    'errorMessage' => '发布失败'
	                );
	            }
	        }else{
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '9',
	                'errorMessage' => '发布失败'
	            );
	        }
	        
	    }else{
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '7',
	            'errorMessage' => '发布失败'
	        );
	    }
	    print_r(json_encode($return));
	}
	
	
	
	
	/**
	 * 编辑个人形象
	 */
	public  function edit_album(){
	    // 获取参数
	    $prams = $this->p;
	    $return = $this->return;
	     
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if ($customer_id == null || $customer_id == "") {
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '5',
	            'errorMessage' => '用户未登录'
	        );
	        print_r(json_encode($return));
	        exit();
	    }
	     
	    // 检验参数
	    $this->_check_prams($prams, array(
	        'album_id',
// 	        'del_ablum',
	        'remark',
	    ));
	    
	    $album_id = $prams["album_id"];//相册ID
	    $del_ablum = isset($prams["del_ablum"]) ? $prams["del_ablum"]:array();//删除ID数组
	    $remark = $prams["remark"];//备注
	  
	    $this->load->model('Customer_album_mdl');
	    $ablum  =  $this->Customer_album_mdl->load_album($album_id);
	    if(!$ablum){
	        $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '7',
	                'errorMessage' => '相册不存在'
	            );
	        echo json_encode($return);
	        exit;
	    }
	    
        if($del_ablum){//删除操作图片
            $this->Customer_album_mdl->del_AlbumByImgID($del_ablum);
        }  
	        
	    $image = array();
	    $images = array();
	     
	    $year = date("Y",time());
	    $month = date("m",time());
	    $day = date("d",time());
	    $created_at = date("Y-m-d H:i:s");
	    
	    $id = false;
	    if( !empty( $_FILES['file'] ) )
	    {
	        // 图片 初始化数据
	        $save_path = "uploads/album/$customer_id/$year/$month/$day/";
	         
	        $path = FCPATH.UPLOAD_PATH. $save_path;
	         
	        if ( !file_exists( $path ) )
	        {
	            mkdir($path,0777,true);
	        }
	        
	        $this->load->library('upload');
	        
	        $count=count($_FILES["file"]["name"]);//页面取的默认名称
	        for($i=0;$i<$count;$i++){
	            $field_name = $_FILES["file"]['name'][$i]. '_' . $i;
	            $_FILES[$field_name] = array(
	                'name' => $_FILES["file"]['name'][$i],
	                'size' => $_FILES["file"]['size'][$i],
	                'type' => $_FILES["file"]['type'][$i],
	                'tmp_name' => $_FILES["file"]['tmp_name'][$i],
	                'error' => $_FILES["file"]['error'][$i]
	            );
	            $config['upload_path'] = $path;
	            $config['allowed_types'] = 'gif|jpg|png|jpeg';
	            $config['file_name'] = date("YmdHis").rand(0,999999);
	             
	            $this->upload->initialize($config);
	            if ($this->upload->do_upload($field_name)) {
	                $img = $this->upload->data();
	                $image['customer_id']= $customer_id;
	                $image['album_id'] = $album_id;
	                $image['path']= $save_path.$img['file_name'];
	                $image['created_at']= $created_at;
	                $images[]= $image;
	            }
	        }
	        
	        //添加数据
	        $id = $this->Customer_album_mdl->Create( $images );
	    }
	        
        $update['id'] = $album_id;
        $update['remark'] = $remark;
        if(isset($prams["is_show"])){
            $update['is_show'] =$prams['is_show'];
        }else{
            $update['is_show'] =$ablum['is_show'];
        }
        $update['update_at'] =$created_at;
        $update_aff = $this->Customer_album_mdl->update($update);
	    
        $return['responseMessage'] = array(
            'messageType' => 'error',
            'errorType' => '7',
            'errorMessage' => '发布失败'
        );
        
        if($id ||  $update_aff){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '发布成功'
            );
            $return['tribe_name'] = '';
            if($update['is_show']){
                $tribe_detail = $this->tribe_mdl->get_tribe($ablum['tribe_id']);
                $return['tribe_name'] = $tribe_detail['name'];
            }
            
            $return['corporation_name'] ='';
            $return['job'] ='';
            $return['real_name'] ='';
            if($ablum['from_customer_id']){
                $crop_info = $this->Customer_album_mdl->get_crop_info($ablum['from_customer_id'],$ablum['tribe_id']);
                 
                $this->load->model('Customer_mdl');
                $customer_info = $this->Customer_mdl->load($ablum['from_customer_id']);
                $return['job'] = $customer_info['job'];
                $return['real_name'] = $customer_info['real_name'];
                if($crop_info){
                    $return['corporation_name'] = $crop_info['corporation_name'];
                }
            }
        }
        
        print_r(json_encode($return));
}
	

    public function album_detail(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $customer_id = $this->session->userdata("user_id");//用户id
        if ($customer_id == null || $customer_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 检验参数
        $this->_check_prams($prams, array(
            'album_id',
        ));
        $album_id = $prams["album_id"];//相册ID
        
        $this->load->model('Customer_album_mdl');
        $album_detail  =  $this->Customer_album_mdl->load_album($album_id);
        
        if(!$album_detail){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '相册不存在'
            );
            print_r(json_encode($return));
            exit();
        }
       
        $photo_list = $this->Customer_album_mdl->load_ByAlbum_Id($album_id);
      
        $album ['id'] = $album_id;
        $album ['customer_id'] = $album_detail['customer_id'];
        $album ['from_customer_id'] = $album_detail['from_customer_id'];
        $album ['created_at'] = $album_detail['created_at'];
        $album ['remark'] = $album_detail['remark'];
        $album ['is_show'] = $album_detail['is_show'];
        $album ['tribe_id'] = $album_detail['tribe_id'];
        $album ['photo_list'] = $photo_list;
        
        $return['data'] = $album;
        print_r(json_encode($return));
    }

	
	//------------个人形象结束------------------
}