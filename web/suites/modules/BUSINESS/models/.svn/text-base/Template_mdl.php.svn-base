<?php
/**
 * 商品
 *
 *
 */
class Template_mdl extends CI_Model {

	var $orderitem_id;
	var $product_score;
	var $service_score;
	var $content;
	var $start_time;
	var $end_time;
    var $corporation_id;
    var $desc;
    var $link_path;
    var $pic;
    var $template_id; 
    var $brief_statement;
	function __construct() {
		parent::__construct ();
	} 
	
	// -------------------------------------------------------------------
	
    /**
     * 创建店铺模板
     */
	function create(){
	    
	    if(isset($this->corporation_id))
	       $this->db->set('corporation_id',$this->corporation_id);
	    if(isset($this->template_id))
	       $this->db->set('template_id',$this->template_id);
	    if(isset($this->brief_statement))
	        $this->db->set('brief_statement',$this->brief_statement);
	    if(isset($this->temp_key))
		{
	       $this->db->set('temp_key',$this->temp_key);
		}
	    if(isset($this->img_path))
	       $this->db->set('img_path',$this->img_path);
	    if(isset($this->desc))
	        $this->db->set('desc',$this->desc);
	    if(isset($this->link_path))
	       $this->db->set('link_path',$this->link_path);
	    if(isset($this->pic) && is_numeric($this->pic) ) 
	       $this->db->set('vip_price',$this->pic);
	    
	    
	    $res = $this->db->insert('corporation_template_set');
	    
	    return $this->db->insert_id();
	    
	}
	
	function update($id){

	    if(isset($this->corporation_id))
	       $this->db->set('corporation_id',$this->corporation_id);
	    if(isset($this->template_id))
	       $this->db->set('template_id',$this->template_id);
	    if(isset($this->temp_key))
	       $this->db->set('temp_key',$this->temp_key);
	    if(isset($this->img_path))
	       $this->db->set('img_path',$this->img_path);
	    if(isset($this->desc))
	        $this->db->set('desc',$this->desc);
	    if(isset($this->link_path))
	       $this->db->set('link_path',$this->link_path);
	    if(isset($this->pic) && is_numeric($this->pic) )
	        $this->db->set('vip_price',$this->pic);
	    if(isset($this->brief_statement))
	        $this->db->set('brief_statement',$this->brief_statement);
	    $this->db->where('id',$id);
	     
	    $res = $this->db->update('corporation_template_set');

		//echo $this->db->last_query();
	     
	    return $res;
	     
	}

	// --------------------------------------------------------------------
	
    /**
     * 获取店铺模板
     */
	function load($cor_id,$key,$t_id=''){
	    
	    $this->db->where('corporation_id',$cor_id);
	    if($t_id!='')
	       $this->db->where('template_id',$t_id);
	    if($key!='')
	        $this->db->where('temp_key',$key);
	    
	    $res = $this->db->get('corporation_template_set');
	    
	    if($r = $res->row_array())
	        return $r;
	    else return array();
	    
	}
	
	/**
	 * 获取店铺模板id
	 */
	function loader($id){
	     
	    $this->db->where('id',$id);
	     
	    $res = $this->db->get('corporation_template_set');
	     
	    if($r = $res->row_array())
	        return $r; 
	    else return array();
	     
	}
	
	// -------------------------------------------------------------------
	
    function get_list($cor_id,$key,$t_id){
       
        $this->db->where('corporation_id',$cor_id);
        if($key !=''){
            $this->db->not_like('temp_key',$key);
            $this->db->where('temp_key != "level_1"');
        }
        $this->db->where('template_id',$t_id);
        $this->db->order_by('temp_key','asc');
        
        $query = $this->db->get('corporation_template_set');
        
        if($res = $query->result_array()){
            return $res;
        }
        else return array();
        
    }
	
	// -------------------------------------------------------------------
	
    /**
     * 删除模板
     */
    function delete($id, $key='', $cor_id='',$tem_id=''){
        if($id!='')
            $this->db->where('id',$id);
        if($key!='')
            $this->db->where('temp_key',$key);
        if($cor_id !='')
            $this->db->where('corporation_id', $cor_id);
        if($tem_id != '')
            $this->db->where('template_id', $tem_id);
        $res = $this->db->delete('corporation_template_set');
        
        return $res;
    }

	/**
	 * 显示店铺商品模板
	 */
	// --------------------------------------------------------------------
	function select_shop( $cor_id, $tem_id){ 
	    $list['data'] = $this->get_list($cor_id,'',$tem_id);
	    
	    foreach ($list['data'] as $v){
	    
	        $string = explode('_',$v['temp_key']);
	        $key = $string[0];
	        $data['list'][$key][] = $v;
	    }
	    if(isset( $data['list'] ) ){
	       return $data['list'];
	    }else{ 
	        return array();
	    }
	}

    /**
     * 显示编辑店铺商品模板
     */
	// --------------------------------------------------------------------
	function select_goods_temp( $cor_id, $tem_id ){ 
	    
	    $data['data'] = $this->get_list($cor_id,'',$tem_id);
	    if( $data['data'] ){
    	    foreach ($data['data'] as $v){
    	        $data['list'][$v['temp_key']] = $v;
    	    }
    	    
    	    return $data['list'];
	    }
	}

    
	/**
	 * 旗舰店楼层
	 */
	// --------------------------------------------------------------------
	function select_flagship_floor( $corp_id, $floor){ 
	    $this->db->where('corporation_id',$corp_id);
	    $this->db->where('template_id','4'); //旗舰店模板id
	    $this->db->like('temp_key',$floor);
	    return $this->db->get('corporation_template_set')->result_array();
	    
	    
	}
   

	
	// --------------------------------------------------------------------



	
	// --------------------------------------------------------------------
	/**
	 * 统计未评价的条数
	 */

    
    /**
     * 统计全部评价
     */

	
	// --------------------------------------------------------------------
	
    /**
     * 私有崡数
     */
	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

}