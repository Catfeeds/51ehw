<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 
 * 
 * 商家设置活动
 * 
 *
 */
class Activity extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		//判断是否商家
		if(!$this->session->userdata('corporation_id')){
		    echo "<script>history.back(-1);</script>";return ;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取活动列表
	 */
	public function get_list($status = null){
    	$this->load->model('activity_record_mdl');
    	$corporation_id = $this->session->userdata('corporation_id');
    	
    	//---统计每个状态的条数-开始
        //未开始
        $not_begin_sift['status'] = array(1);
        $not_begin_sift['count'] = true;
        $not_begin_sift['start_time'] = '>';
        $data['not_begin'] = $this->activity_record_mdl->load($corporation_id,$not_begin_sift);
        
        //活动中
        $begin_sift['status'] = array(1);
        $begin_sift['count'] = true;
        $begin_sift['end_time'] = '>';
        $data['begin'] = $this->activity_record_mdl->load($corporation_id,$begin_sift);
        
        //已过期
        $overdue_sift['status'] = array(1);
        $overdue_sift['count'] = true;
        $overdue_sift['end_time'] = '<';
        $data['overdue'] = $this->activity_record_mdl->load($corporation_id,$overdue_sift);
     
        //新建
        $add_sift['status'] = array(2);
        $add_sift['count'] = true;
        $data['add'] = $this->activity_record_mdl->load($corporation_id,$add_sift);
        
        //审核中
        $approve_sift['status'] = array(3);
        $approve_sift['count'] = true;
        $data['count_approve'] = $this->activity_record_mdl->load($corporation_id,$approve_sift);
        
        //全部
        $count_sift['count'] = true;
        $data['activity_total'] = $this->activity_record_mdl->load($corporation_id,$count_sift);
    	//--统计每个状态的条数-结束
    	
    	
    	//---根据状态判断拼装查询条件-- //开始
    	switch ($status){ 
    	    case 'not_begin'://未开始
    	        $sift['status'] = array(1);
    	        $sift['start_time'] = '>';
    	        break;
    	    case 'begin': //活动中
    	        $sift['status'] = array(1);
    	        $sift['end_time'] = '>';
    	        break;
    	    case 'overdue': //已过期
    	        $sift['status'] = array(1);
    	        $sift['end_time'] = '<';
    	        break;
    	    case 'add': //新建
    	        $sift['status'] = array(2);
    	        break;
	        case 'approve': //审核中
	            $sift['status'] = array(3);
	            break;
    	    default: //全部
    	        $sift = array();
    	        break;
    	}
    	if(  $this->input->get('search_name') )
    	    $sift['search_name'] = $this->input->get('search_name');
    	    
    	//---根据状态判断拼装查询条件--//结束

    	
    	//---分页 -开始
    	$this->load->library('pagination');
    	$config['per_page'] = 2;
    	$current_page = ($this->input->get('per_page') );  //获取当前分页页码数
    	if(0 == $current_page)
    	{
    	    $current_page = 1;
    	}
    	$offset   = ($current_page - 1 ) * $config['per_page'];
    	
    	$data['activity_product_list'] = $this->activity_record_mdl->load($corporation_id,$sift,$offset,$config['per_page']);
//     	echo $this->db->last_query();
    	$config['base_url'] = site_url('corporate/activity/get_list').'/';
    	$sift['count'] = true;
    	$config['total_rows'] = $this->activity_record_mdl->load($corporation_id,$sift);
    	$config['use_page_numbers']   = TRUE;
    	$config['page_query_string']  = TRUE;
    	$config['num_links'] = 3; //可以看到当前页后面的3页a连接
    	$config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
    	$config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
    	$config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
    	$config['prev_tag_css'] = 'class="lPage"';
    	$config['next_link'] = '下一页';
    	$config['next_tag_css'] = 'class="lPage"';
    	$config['first_link'] = '<<';
    	$config['last_link'] = '>>';
    	$config['base_url'] .= $status.'/?';
    	if( $this->input->get('search_name') )
    	    $config['base_url'] .= 'search_name='.$this->input->get('search_name');
    	$this->pagination->initialize($config);
    	$data['base_url'] = $status ? '/'.$status.'/' :'';
    	$data['base_url'] .= $current_page ? '?&per_page='.$current_page : '';
    	$data['total_rows'] = $config['total_rows'];
    	$data['per_page'] = $config['per_page'];
    	$data['cu_page'] = $current_page;
    	$data['page'] =  $this->pagination->create_links();
    	//--分页 -结束
    	
    	
    	$data ['title'] = $this->session->userdata ( 'app_info' )['app_name'];
    	$data ['head_set'] = 4;
    	$data ['status'] = $status;
    	$this->load->view ( 'head', $data );
    	$this->load->view ( '_header', $data );
    	$this->load->view ( 'corporate/activity/get_list', $data );
    	$this->load->view ( '_footer', $data );
    	$this->load->view ( 'foot', $data );
	}
	
	/**
	 * 发布活动页面 && 详情页面
	 */
	public function create_activity($activity_id = null, $status= null ){ 
	    $this->load->model('activity_record_mdl');
	    $corporation_id = $this->session->userdata('corporation_id');
	    
	    if($activity_id && !$status){ //修改信息
    	    $sift['id'] = $activity_id;
    	    $sift['status'] = array(2,4);
    	    $sift['row'] = true;
    	    $data['activity'] = $this->activity_record_mdl->load($corporation_id,$sift);
    	}elseif($status){ 
    	    $sift['id'] = $activity_id;
    	    $sift['row'] = true;
    	    $data['activity'] = $this->activity_record_mdl->load($corporation_id,$sift);
    	}else{
	       //查询已上架可以设置为拼团的商品列表
	        $data['product_list'] = $this->activity_record_mdl->add_groupbuy_product($corporation_id);
// 	        echo $this->db->last_query();
// 	        var_Dump($data['product_list']);
	    }
	    
	    //---统计每个状态的条数-开始
	    //未开始
	    $not_begin_sift['status'] = array(1);
	    $not_begin_sift['count'] = true;
	    $not_begin_sift['start_time'] = '>';
	    $data['not_begin'] = $this->activity_record_mdl->load($corporation_id,$not_begin_sift);
	    
	    //活动中
	    $begin_sift['status'] = array(1);
	    $begin_sift['count'] = true;
	    $begin_sift['end_time'] = '>';
	    $data['begin'] = $this->activity_record_mdl->load($corporation_id,$begin_sift);
	    
	    //已过期
	    $overdue_sift['status'] = array(1);
	    $overdue_sift['count'] = true;
	    $overdue_sift['end_time'] = '<';
	    $data['overdue'] = $this->activity_record_mdl->load($corporation_id,$overdue_sift);
	     
	    //新建
	    $add_sift['status'] = array(2);
	    $add_sift['count'] = true;
	    $data['add'] = $this->activity_record_mdl->load($corporation_id,$add_sift);
	    
	    //审核中
	    $approve_sift['status'] = array(3);
	    $approve_sift['count'] = true;
	    $data['count_approve'] = $this->activity_record_mdl->load($corporation_id,$approve_sift);
	    
	    //全部
	    $count_sift['count'] = true;
	    $data['activity_total'] = $this->activity_record_mdl->load($corporation_id,$count_sift);
	    //--统计每个状态的条数-结束
	    
	    
	    $data ['title'] = $this->session->userdata ( 'app_info' )['app_name'];
	    $data ['head_set'] = 4;
	    $data ['activity_id'] = $activity_id;
	    $data ['status'] = $status;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ( 'corporate/activity/create', $data );
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}

	/**
	 * 设置商品为拼团活动
	 */
	public function add_activity_product(){ 
	    $product_id = $this->input->post('activity_product');
	    $corporation_id = $this->session->userdata('corporation_id');
	    $this->load->model('activity_record_mdl');
	    //首先查询商品是否可以设置为拼团商品
        $is_groupbuy = $this->activity_record_mdl->add_groupbuy_product($corporation_id,$product_id);

	    if($is_groupbuy){
	    
    	    //商品ID
    	    $this->input->post('activity_product') != '' ? $this->activity_record_mdl->product_id = $this->input->post('activity_product') : exit;
    	    //拼团人数
    	    $this->input->post('menber_num') != '' && $this->input->post('menber_num') > 1? $this->activity_record_mdl->menber_num = $this->input->post('menber_num') : exit;
            //拼团价格
    	    $this->input->post('groupbuy_price') != '' ? $this->activity_record_mdl->groupbuy_price = $this->input->post('groupbuy_price') : exit;
    	    //开始时间
    	    $this->input->post('groupbuy_start_at') != '' ? $this->activity_record_mdl->start_time = $this->input->post('groupbuy_start_at') : exit;
    	    //结束时间
    	    $this->input->post('groupbuy_end_at') != '' ? $this->activity_record_mdl->end_time = $this->input->post('groupbuy_end_at') : exit;
    	    //活动说明
    	    $this->activity_record_mdl->remarks = $this->input->post('remarks');
    	    //状态
    	    $this->input->post('status') == '1' ? $this->activity_record_mdl->status = 2 : $this->activity_record_mdl->status = 3;
    	    //活动编号
    	    $this->activity_record_mdl->activity_num = $corporation_id.date('YmdHis'); //活动编号
    	    //活动类型
    	    $this->activity_record_mdl->type = 1;
    	    //店铺ID
    	    $this->activity_record_mdl->corporation_id = $corporation_id;
    	    //限购状态
    	    $this->activity_record_mdl->set_limit = $this->input->post('set_limit');
    	    //是否设置了限购
    	    if($this->input->post('set_limit') == 1){ 
    	        //最少购买多少
    	        $this->input->post('least_purchase') != '' ? $this->activity_record_mdl->least_purchase = $this->input->post('least_purchase') : exit;
    	        //最多购买多少
    	        $this->input->post('most_purchase') != '' ?  $this->activity_record_mdl->most_purchase = $this->input->post('most_purchase') : exit;
    	       
    	        $this->input->post('least_purchase') > $this->input->post('most_purchase') ? exit : '';
    	    }
    	        
    	    
    	    
    	    $row = $this->activity_record_mdl->add_approve_activity();
    	    
    	    if($row){
    	        echo '<meta charset="utf-8">';
    	        echo "<script type='text/javascript'>
                        alert('成功发布');
                        window.location.href='".site_url('corporate/activity/get_list')."';
                    </script> ";
    	    }
 
	    }else{ 
	        echo '<meta charset="utf-8">';
	        echo "<script type='text/javascript'>
                    alert('该商品已申请');
                    window.location.href='".site_url('corporate/activity/create_activity')."';
                </script> ";
	    }
	}
	
	//某个拼团的明细-订单列表
	public function activity_order_list($activity_num){ 
	    $corporation_id = $this->session->userdata('corporation_id');
	    $this->load->model('activity_record_mdl');
	    $data['list'] = $this->activity_record_mdl->activity_order_list($corporation_id,$activity_num);
	    
	    $data ['title'] = $this->session->userdata ( 'app_info' )['app_name'];
	    $data ['head_set'] = 4;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ( 'corporate/activity/list', $data );
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}
	
	//修改活动信息
	public function update_activity_product(){ 
	    $this->load->model('activity_record_mdl');
	    //店铺ID
	    $corporation_id = $this->session->userdata('corporation_id');
	    //活动ID
        $id = $this->input->post('activity_id');
        $id ? $this->activity_record_mdl->id = $id : exit;
	    //商品ID
	    $this->input->post('activity_product') != '' ? $this->activity_record_mdl->product_id = $this->input->post('activity_product') : exit;
	    //拼团人数
	    $this->input->post('menber_num') != '' && $this->input->post('menber_num') > 1? $this->activity_record_mdl->menber_num = $this->input->post('menber_num') : exit;
	    //拼团价格
	    $this->input->post('groupbuy_price') != '' ? $this->activity_record_mdl->groupbuy_price = $this->input->post('groupbuy_price') : exit;
	    //开始时间
	    $this->input->post('groupbuy_start_at') != '' ? $this->activity_record_mdl->start_time = $this->input->post('groupbuy_start_at') : exit;
	    //结束时间
	    $this->input->post('groupbuy_end_at') != '' ? $this->activity_record_mdl->end_time = $this->input->post('groupbuy_end_at') : exit;
	    //活动说明
	    $this->activity_record_mdl->remarks = $this->input->post('remarks');
	    //状态
	    $this->input->post('status') == '1' ? $this->activity_record_mdl->status = 2 : $this->activity_record_mdl->status = 3;
	    //活动类型
	    $this->activity_record_mdl->type = 1;
	    //店铺ID
	    $this->activity_record_mdl->corporation_id = $corporation_id;
	    //限购状态
	    $this->activity_record_mdl->set_limit = $this->input->post('set_limit');
	    //是否设置了限购
	    if($this->input->post('set_limit') == 1){
	        //最少购买多少
	        $this->input->post('least_purchase') != '' ? $this->activity_record_mdl->least_purchase = $this->input->post('least_purchase') : exit;
	        //最多购买多少
	        $this->input->post('most_purchase') != '' ?  $this->activity_record_mdl->most_purchase = $this->input->post('most_purchase') : exit;
            
	        $this->input->post('least_purchase') > $this->input->post('most_purchase') ? exit : '';
	    }
	    
	    $row = $this->activity_record_mdl->update_approve_activity();
	   
	    if($row){
	        echo '<meta charset="utf-8">';
	        echo "<script type='text/javascript'>
                        alert('修改成功');
                        window.location.href='".site_url('corporate/activity/get_list')."';
                    </script> ";
	    }
	}
	
	/**
	 * 提交审核
	 */
	public function update_activity_status(){ 
	    $this->load->model('activity_record_mdl');
	    $corporation_id = $this->session->userdata('corporation_id');
	    $id = $this->input->post('id');
	    
	    $status = false;//申请失败
	    
	    if($id){
	        
	        //查询判断是否可以审核
	        $sift['id'] = $id;
	        $sift['status'] = array(1,2,4);
	        $sift['row'] = true;
	        $is_activity = $this->activity_record_mdl->load($corporation_id,$sift);
	        
	        if($is_activity){ 
	            $this->activity_record_mdl->id = $id;
	            $row = $this->activity_record_mdl->update_approve_status();
	            
	            if($row)
	                $status = 1;//申请成功
                    
	        }else{ 
	            $status = 3;//正在审核中
	        }

	    }else{ 
	        $status = 2;//空参数
	    }
	    
	    echo json_encode($status);
	}
	
	/**
	 * 结束活动
	 */
	public function end_activity(){ 
	    //方法过程
	    //1.店主传所有活动中的ID -- 2."谨慎起见" 然后where_in 查询是否是该店主的活动并且是未结束的活动 -- 3.如果查出来的条数和用户传过来的条数一致  4.执行批量修改为已结束
        
	    //1.店主传过来的活动ID
	    $status = false;
	    $id_array = $this->input->post('id');
	    $corporation_id = $this->session->userdata('corporation_id');
	    
	    //2.查询
	    $this->load->model('activity_record_mdl');
	    $begin_sift['id_array'] = $id_array;
	    $begin_sift['status'] = array(1);
        $begin_sift['end_time'] = '>';
        $count_begin = $this->activity_record_mdl->load($corporation_id,$begin_sift);
//         echo $this->db->last_query();
//        echo '<pre>';
//        var_Dump($id_array);exit;

        //3.条数一致
        if(count($id_array) == count($count_begin) ){
             
            $this->load->model('product_mdl');
            $this->load->model('groupbuy_mdl');
            foreach ($id_array as $key=>$v){
                 
                $data[$key]['id'] = $v;
                $data[$key]['end_time'] = date('Y-m-d H:i:s');
                
                $product_data[$key]['id'] = $count_begin[$key]['product_id'];
                $product_data[$key]['groupbuy_end_at'] = date('Y-m-d H:i:s');
                $product_data[$key]['is_groupbuy'] = 0;
                
                $groupbuy_data[$key]['activity_num'] = $count_begin[$key]['activity_num'];
                $groupbuy_data[$key]['enddate'] = date('Y-m-d H:i:s');
            }
            
            
            //修改记录结束表时间
            $row = $this->activity_record_mdl->update_batch($data);
            
            //修改商品结束表时间
            $up_activity_product = $this->product_mdl->uodate_bath_activity_status($product_data);
            
            //修改团购表结束时间 --可能没有记录(没人下过单)
            $up_groupbuy = $this->groupbuy_mdl->bath_update_groupbuy($groupbuy_data);
            
            if($row && $up_activity_product){
                $status = 1;//修改成功
            }
        }else{ 
            $status = 2;//请选择正确的活动
        }
	    
        echo json_encode($status);
	}
}