<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Section extends Front_Controller {
	
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
		$this->load->model ( 'customer_mdl' );
		$this->load->model ( 'corporation_mdl' );
	}
	
	/**
	 * 获得列表
	 */
	public function get_list() {
		$customer_id = $this->session->userdata ( 'user_id' );
		$corporation_id = $this->session->userdata ( 'corporation_id' );
		// 获取企业资料
		$data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
		
		$app_info = $this->session->userdata ( 'app_info' );
		
		$this->load->model ( 'section_mdl' );
		$this->load->model ( 'product_mdl' );
		
		$data ['sections'] = $this->section_mdl->get_list ( 0, $app_info["id"], 0, $corporation_id );
		
		//数量
		$data ['all_count'] = $this->product_mdl->count_products ();
		$op['type'] = 'not';
		$data ['not'] = $this->product_mdl->count_products ($op);
		$op['type'] = 'notsale';
		$data ['notsale'] = $this->product_mdl->count_products ($op);
		$op['type'] = 'sale';
		$data ['sale'] = $this->product_mdl->count_products ($op);
		
		$data ['title'] = "分类列表";
		
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/section/list', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	/**
	 * 添加频道
	 */
	public function add($id=0) {
		$corporation_id = $this->session->userdata ( 'corporation_id' );
		$customer_id = $this->session->userdata ( 'user_id' );
		$this->load->model ( 'corporation_mdl' );
		$this->load->model ( 'section_mdl' );
		$this->load->model ( 'product_mdl' );

		// 获取企业资料
		$data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
		
		$app_info = $this->session->userdata ( 'app_info' );
		
		$data ['sections'] = $this->section_mdl->get_list ( 0, $app_info["id"], 0, $corporation_id ,$id);
		
		if($id > 0)
		    $data ['detail'] = $this->section_mdl->load($id);
		
		$data ['all_count'] = $this->product_mdl->count_products ();
		$op['type'] = 'not';
		$data ['not'] = $this->product_mdl->count_products ($op);
		$op['type'] = 'notsale';
		$data ['notsale'] = $this->product_mdl->count_products ($op);
		$op['type'] = 'sale';
		$data ['sale'] = $this->product_mdl->count_products ($op);
		
		$data ['title'] = "新建分类";
// 		print_r($this->cart->contents());exit;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/section/edit', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------------------
	
	public function delete($id=0){
	    
	    $this->load->model( 'section_mdl' );
	    $corporation_id = $this->session->userdata('corporation_id');
	    $app_info = $this->session->userdata('app_info');
	    
	    $data ['sections'] = $this->section_mdl->get_list ( 0, $app_info["id"], 0, $corporation_id,0,$id );
	    //$this->db->trans_strict(FALSE);
        //$this->db->trans_begin();
        //修改要删改对象的下一级
        if(count($data['sections'])>0){
        foreach ($data['sections'] as $s){
            $data ['sec'] = $this->section_mdl->load($s['pid']);
            $condition ['pid'] = $data ['sec']['pid'];
            $condition ['fpath'] = $data ['sec']['fpath'] ;
            $update_child = $this->section_mdl->update($s['id'],$condition);
        }
        }else{
            $update_child = true;
        }
	    if($update_child){
	        //修改fpath中存在自己id的
	        $data ['sections_two'] = $this->section_mdl->get_list ( $id, $app_info["id"], 0, $corporation_id );
	        //print_r($data['sections']);exit;
	        if(count($data['sections_two'])>0){
	        foreach ($data['sections_two'] as $s){
	            $data ['sec_two'] = $this->section_mdl->load($s['pid']);
	            //echo $data ['sec']['fpath'];exit;
	            $conditions ['fpath'] = $data ['sec_two']['fpath'] . $s ['pid'] .',';
	            $result = $this->section_mdl->update($s['id'],$conditions);
	           }
	        }else{
	               $result = true;
	           }
	       if($result){
	            $res = $this->section_mdl->delete($id);
	            if($res){
	                if ($this->db->trans_status() === TRUE) {
	                    $this->db->trans_commit();
	                    $data ['message'] = '删除成功！';
	                    $data ['url'] = site_url ( 'corporate/section/get_list' );
	                    
	                    $this->load->view ( "redirect_view", $data );
	                    return;
	                } else {
	                    //$this->db->trans_rollback();
	                    //@todo 异常处理部分
	                    $data ['message'] = '删除失败！';
	                    $data ['url'] = site_url ( 'corporate/section/get_list' );
	                
	                    $this->load->view ( "redirect_view", $data );
	                    return;
	                }
	            }
	            else{
	                //$this->db->trans_rollback();
	                $data ['message'] = '删除失败！';
	                $data ['url'] = site_url ( 'corporate/section/get_list' );
	            
	                $this->load->view ( "redirect_view", $data );
	                return;
	            }
	        }else{
	            //$this->db->trans_rollback();
	            $data ['message'] = '删除失败！';
	            $data ['url'] = site_url ( 'corporate/section/get_list' );
	                 
	            $this->load->view ( "redirect_view", $data );
	            return;
	        }
	    }else{
	        //$this->db->trans_rollback();
	        $data ['message'] = '删除失败！';
	        $data ['url'] = site_url ( 'corporate/section/get_list' );
	             
	        $this->load->view ( "redirect_view", $data );
	        return;
	    }
	           /* if ($this->db->trans_status()) {
	                $this->db->trans_commit();
	                $data ['message'] = '删除成功！';
	                $data ['url'] = site_url ( 'corporate/section/get_list' );
	                 
	                $this->load->view ( "redirect_view", $data );
	                return;
	            } else {
	                $this->db->trans_rollback();
	                //@todo 异常处理部分
	                $data ['message'] = '删除失败！';
	                $data ['url'] = site_url ( 'corporate/section/get_list' );
	                
	                $this->load->view ( "redirect_view", $data );
	                return;
	            }*/
    	
	    
	}
	
	/**
	 * 保存
	 */
	public function save() {
		$app_info = $this->session->userdata ( 'app_info' );
		
		$corporation_id = $this->session->userdata ( 'corporation_id' );
		
		$data ['app_id'] = $app_info ['id'];
		$id = $this->input->post ( "id" );
		if ($id > 0) {
			$data ['id'] = $this->input->post ( "id" );
			$data ['section_name'] = $this->input->post ( "section_name" );
			
			$data ['sequence'] = $this->input->post ( "sequence" );
			$data ['section_type'] = $this->input->post ( "section_type" );
			
			if (( int ) $data ['section_type'] === 0) {
				$data ['pid'] = $this->input->post ( "pid_p" );
			} else {
				$data ['pid'] = $this->input->post ( "pid_c" );
			}
			
			$this->load->model ( 'section_mdl' );
			
			// 查询PID的资料
			if ($data ['pid'] != 0) {
				$parentsection = $this->section_mdl->load ( $data ['pid'] );
				$data ["fpath"] = $parentsection ["fpath"] . $data ['pid'] . ",";
				
			} else {
				$data ["fpath"] = ",0,";
			}
			
			$res = $this->section_mdl->update ( $id, $data );
			
			if($res){
			    $data ['sections'] = $this->section_mdl->get_list ( $id, $app_info["id"], 0, $corporation_id );
			    if(count($data['sections'])>0){
    			    foreach ($data['sections'] as $s){
    			        $data ['sec'] = $this->section_mdl->load($s['pid']);
    			        $condition ['fpath'] = $data ['sec']['fpath'] . $s ['pid'] .',';
    			        //echo $condition['fpath'];exit;
    			        $result = $this->section_mdl->update($s['id'],$condition);
    			    }
    			    if($result){
            			$data ['message'] = '保存成功！';
            			$data ['url'] = site_url ( 'corporate/section/get_list' );
            			
            			$this->load->view ( "redirect_view", $data );
            			return;
    			    }else{
    			        $data ['message'] = '保存失败！';
    			        $data ['url'] = site_url ( 'corporate/section/add/'.$id );
    			         
    			        $this->load->view ( "redirect_view", $data );
    			        return;
			        }
			    }else{
			        $data ['message'] = '保存成功！';
			        $data ['url'] = site_url ( 'corporate/section/get_list' );
			         
			        $this->load->view ( "redirect_view", $data );
			        return;
			    }
			}else{
			    $data ['message'] = '保存失败！';
			    $data ['url'] = site_url ( 'corporate/section/add/'.$id );
			    	
			    $this->load->view ( "redirect_view", $data );
			    return;
			}
		} else {
			
			$data ['section_name'] = $this->input->post ( "section_name" );
			$data ['sequence'] = $this->input->post ( "sequence" )!=null?$this->input->post ( "sequence" ):0;
			$data ['app_id'] = $app_info ['id'];
			$data ['section_type'] = $this->input->post ( "section_type" );
			$data ['corporation_id'] = $corporation_id;
			
			if (( int ) $data ['section_type'] === 0) {
				$data ['pid'] = $this->input->post ( "pid_p" );
			} else {
				$data ['pid'] = $this->input->post ( "pid_c" );
			}
			$this->load->model ( 'section_mdl' );
			
			// 查询PID的资料
			if ($data ['pid'] != 0) {
				$parentsection = $this->section_mdl->load ( $data ['pid'] );
				$data ["fpath"] = $parentsection ["fpath"] . $data ['pid'] . ",";
			} else {
				$data ["fpath"] = ",0,";
			}
			
			$id = $this->section_mdl->insert ( $data );
			if($id){
    			$data ['message'] = '录入成功！';
    			$data ['url'] = site_url ( 'corporate/section/get_list' );
    			
    			$this->load->view ( "redirect_view", $data );
    			return;
			}else{
			    $data ['message'] = '录入失败！';
			    $data ['url'] = site_url ( 'corporate/section/add');
			    	
			    $this->load->view ( "redirect_view", $data );
			    return;
			}
		}
	}
}