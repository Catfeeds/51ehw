<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Score_log extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{
		//$this->info();
	}
	
	public function get_list(){
	    
	    //判断用户是否登录
	    if (!$this->session->userdata('user_in')){
	        redirect('customer/login');
	        exit();
	    }
	    
		$customer_id = $this->session->userdata('user_id');
		$this->load->model('score_log_mdl');
		$data['score_logs'] = $this->score_log_mdl->get_list($customer_id, 1);
		$data['score_used_logs'] = $this->score_log_mdl->get_list($customer_id, 0);
        $data['head_set'] = 3;
		$this->load->view ( 'head' );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/score_log', $data);
		$this->load->view ( '_footer' );
		$this->load->view ( 'foot' );
		
	}
	
	
	/**
	 * 提供查看设置比率对应角色。--临时。
	 */
	public function Show_Rebate_List( $status = 'Rebate' ) 
	{ 
        $this->db->select('c.name,cc.app_id,c.parent_id,c.id,c.name,cr.*,rt.config');
        $this->db->from('customer_rebate as cr');
        $this->db->join('rebate_template as rt','cr.template_id = rt.template_id');
        $this->db->join('customer as c','c.id = customer_id');
        $this->db->join('customer_corporation as cc','c.id = cc.customer_id');
        $query = $this->db->get();
        
        $list = array(); 
        $customer_rebate_info = $query->result_array();
        
       
        if( $customer_rebate_info )
        { 
            //总公司 -- 一定有。
            $this->load->model('Config_mdl');
            $ehw_info = $this->Config_mdl->get_config('ehw_id');
            
            if( $ehw_info['value'] )
            {
                $this->ehw_id = $ehw_info['value'];
            }
            
            
            foreach ( $customer_rebate_info as $k => $v )
            { 
                $list[$k]['customer_name'] = $v['name'];
                $this->parent_id = $v['parent_id'];
                $this->customer_id = $v['customer_id'];
                $this->app_id = $v['app_id'];
                
                //将模板比率JSON转成数组。
                $role_ratio = array_column( json_decode( htmlspecialchars_decode( $v['config'] ),true ),NULL,'role_id' );
                
                //角色对应对象的数据。key=角色ID
                $role_obj= json_decode( $v['config_data'] ,true );
                
                $role_info = $this->Set_Role( $role_obj );
                
               
                $list[$k]['rebate_info'] = $this->Rebate_Obj( $role_ratio, $role_info, $role_obj );
//                 echo '<pre>';
//                 var_dump($list[$k]['rebate_info']);
//                 exit;
               
            }
        }
        
       
        //视图。
        $data['list'] = $list;
        $this->load->view('cheshi/rebate_info',$data);
    }
	
	
	/**
	 * 不可控角色赋值。
	 */
	private function Set_Role( $customer_id = 0 )
	{ 
	    
	    $role_info = array();
	    
	    
        //查询角色。
        $query = $this->db->get('rebate_role');
        $result = $query->result_array();
        
        $role_info =  array_column($result,NULL,'role_id' );
	    
	    
	   return $role_info;
	    
	}
	
	/**
	 * 无限层分成-将 （角色+对象+比率） 合并起来，最终调用计算方法，返回完整结果。
	 * @$role_ratio = 角色，比率。
	 * @$role_obj =  角色，对象。
	 *
	 */
	private function Rebate_Obj( &$role_ratio = array(), $role_info = array(), $role_obj =array() )
    {
     
        $this->load->model('customer_mdl');
        $this->load->model('App_info_mdl');
        //查看是否有下级,如果下级存在就是虚拟角色.
        foreach ( $role_ratio as $key => $val )
        {
            $k = $val['role_id'];//角色ID。
            
           
            if(  $k == 1 && !empty( $this->parent_id ) )//1上级角色ID
            {
                
                $parent_info = $this->customer_mdl->load( $this->parent_id );
                
                @$role_obj[1]['obj_name'] = $parent_info['name'];
                 
                //上上级ID
                @$parent_parent_id = $parent_info['parent_id'];
            }
            
            //2 = 上级角色ID
            if(  $k == 2   && !empty( $parent_parent_id ) )
            {
                $parent_parent_info = $this->customer_mdl->load( $parent_parent_id );
                $role_obj[2]['obj_name'] = $parent_parent_info['name'];
                
            }
            
            //分公司
            if( $k == 4 )
            {
                $app_info = $this->App_info_mdl->load( $this->app_id );
            
                if( $app_info['customer_id'] )
                {
                    $role_obj[4]['obj_name'] = '分公司分成用户id：'.$app_info['customer_id'];
                }
            }
             
            //总公司
            if(  $k == 5  && !empty( $this->ehw_id ) )
            { 
                $role_obj[5]['obj_name'] = '易货网分成用户id：'.$this->ehw_id;
            } 
            
            //担保人。
            if( $k == 8 )
            { 
                //担保人列表
                $this->load->model('Guarantee_request_mdl');
                $guarantee_list = $this->Guarantee_request_mdl->guarantee_detail( $this->customer_id );
                
                if( $guarantee_list )
                {
                    $role_ratio[8]['children'] = $guarantee_list;
                    $role_obj[8]['obj_name'] = '担保人存在';
                }
                
            }
            
            $role_ratio[$k]['role_name'] = isset( $role_info[$k]['name']) ? $role_info[$k]['name'] : '找不到角色';
            
            
            if( isset( $val['children'] ) && !isset( $val['obj_name'] ) )
            {
                $role_ratio[$k]['obj_name'] = '虚拟角色';
                //格式化子类数据。key = 角色id。
                $role_ratio[$k]['children'] = array_column( $val['children'], null ,'role_id');
            
                //递归。
                $this->Rebate_Obj($role_ratio[$k]['children'], $role_info, $role_obj );
                
            }else{ 
                
                $role_ratio[$k]['obj_name'] = isset( $role_obj[$k]['obj_name'] ) ? $role_obj[$k]['obj_name'] : '找不到对象';
            }
          
        }
         
       
	     
	    return $role_ratio;
	}
	
	
	/**
	 * 数据转移-临时。
	 */
	public function Old_Change_Rebate()
	{ 
	    
	    //从旧的分成记录中查看需要重新分成的订单ID。
	    $this->db->select('o.*');
	    $this->db->from('order_rebate as o_r');
	    $this->db->join('order as o','o.id=o_r.orderid');
	    $this->db->where('o_r.is_transfer',0);
	    $this->db->group_by('o.id');
	    $query = $this->db->get();
	   
	    //需要重新分成的订单。
	    $rebate_list = $query->result_array();
	    
	    if( $rebate_list )
	    {
    	    $this->db->trans_begin();
    	    
    	    foreach ( $rebate_list as $k => $v )
    	    { 
    	        $this->load->model('order_rebate_mdl');
    	        $order_rebate = $this->order_rebate_mdl->order_rebate($v);
    	        
    	        if( $order_rebate )
    	        { 
    	            //将旧数据处理为已经转移。
    	            $this->db->set('is_transfer',1);
    	            $this->db->where('orderid',$v['id']);
    	            $this->db->update('order_rebate');
    	            
    	            $row = $this->db->affected_rows();
    	        }
    	        
    	        if( empty( $row ) )
    	        { 
    	            echo '有数据处理失败，回滚。';
    	            $this->db->trans_rollback(); //事物回滚
    	            exit();
    	        }
    	    }
    	    
    	    echo '处理完成';
    	    $this->db->trans_commit(); //提交事物
    	    
	    }else{ 
	        echo '暂无数据处理';
	    }
	}
	
	
	/**
	 * 旧数据中需要设置比率的用户ID。
	 */
	
	public function Old_Rebate_Customer()
	{ 
	    $this->db->select('o.customer_id');
	    $this->db->from('order_rebate as o_r');
	    $this->db->join('order as o','o.id=o_r.orderid');
	    $this->db->group_by('o.customer_id');
	    $query = $this->db->get();
	    $rebate_list = $query->result_array();
	    
	    echo '<pre>';
	    var_dump($rebate_list);
	}
}
?>