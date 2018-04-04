<?php

/**
 * 订单核销
 *
 *
 */
class Tribe_activity_mdl extends CI_Model
{
    function __construct()
    { 
        parent::__construct ();
    }
    
    /**
     * 查询活动列表
     */
    public function Load( $sift = array() )
    { 
        if( !$sift['where']['customer_id'] )
            return array();
       
            
        
        $this->db->from('tribe_activity as ta');
        $this->db->where('ta.status',1);
        if( !empty( $sift['sql_status'] ) )
        {
           
            $this->db->select('ta.*');
            $this->db->join('tribe_staff as ts',"ta.tribe_id = ts.tribe_id ");
            //51需求
            //全平台
            $this->db->where_in('ts.tribe_id',$sift['where']['tribe_id']);
            $this->db->where( array('ts.customer_id' => $sift['where']['customer_id'], 'ts.status' => 2 ) );
           
        }else{
            //全平台+已加入的
            $this->db->select('ta.*,any_value(t.name) as tr_name,any_value(t.logo) as logo');
            $this->db->join('tribe_staff as ts',"ta.tribe_id = ts.tribe_id and ts.status = 2",'left');
            $this->db->join('tribe as t','t.id = ta.tribe_id','left');
            
            //商会APP搜索部落活动需求
            if( !empty( $sift['sql_app'] )){
                if($sift['where']['tribe_id']){
                    $sift['where']['tribe_id'][] = '-1';
                    if(!empty($sift['where']['all_tribe_id'])){
                        $tribe_id = implode(',', $sift['where']['tribe_id']);
                        $all_tribe_id = implode(',', $sift['where']['all_tribe_id']);
                        $this->db->where("(ta.tribe_id in ({$tribe_id})  or ta.tribe_id in ({$all_tribe_id}) and ta.display = 1)");
                    }else{
                        $this->db->where_in('ta.tribe_id',$sift['where']['tribe_id']);
                    }
                    
                }else{
                   
                    if(!empty($sift['where']['all_tribe_id'])){
                        $sift['where']['all_tribe_id'][] = '-1';
                        $all_tribe_id = implode(',', $sift['where']['all_tribe_id']);
                        $this->db->where("ta.tribe_id in ({$all_tribe_id}) and ta.display = 1");
                    }else{
                        $this->db->where_in('ta.tribe_id','-1');
                    }
                }
            }else{
                $this->db->where("IF(ta.tribe_id != -1, ts.customer_id = {$sift['where']['customer_id']}, true)",'',false);
            }
            $this->db->group_by('ta.id');
        }
        
        if( empty( $sift['where']['type'] ) )
        {
            $this->db->where('ta.type',0);
        }else{
            $this->db->where('ta.type', $sift['where']['type']);
        }
        
        // $this->db->order_by('ta.update_at,ta.id','desc');
        $this->db->order_by('ta.update_at','desc');
        
        if( !empty( $sift['page']['limit'] ) )
        {
            $this->db->limit($sift['page']['limit'],$sift['page']['offset'] );
        }
        
        $query = $this->db->get();
      
        if( !empty( $sift['return_row'] ) )
            return $query->row_array();
        
        
        return $query->result_array();
        
    }
    
    /**
     * 活动报名记录
     */
    public function Add_Activity_Staff( $data )
    { 
         //添加tribe_activity_staff表。
	    $this->db->insert('tribe_activity_staff',$data);
	    return $this->db->insert_id();
    }
    
    
    /**
     * 活动记录+报名记录
     */
    public function Load_Activity( $sift = array() )
    { 
        $this->db->select('ta.*,tas.id as register');
        $this->db->from('tribe_activity as ta');
        $this->db->join('tribe_activity_staff as tas',"ta.id = tas.activity_id and tas.customer_id = {$sift['where']['customer_id']}",'left');
        $this->db->where('ta.id',$sift['where']['id']);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 查询公告详细
     */
    public function Detaile( $sift = array () )
    { 
        if( !$sift['where']['id'] )
            return array();
        
        $this->db->from('tribe_activity');
        $this->db->where('id',$sift['where']['id']);
        $this->db->where('status',1);
        $query = $this->db->get();
        $row = $query->row_array();
        
        return $row;
    }
    
    /**
     * 特殊需求
     */
    public function Load_Tribe_activity()
    { 
        $this->db->from('tribe_activity');
        $this->db->where('tribe_id',-2);
        $this->db->where('status',1);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        
        $row = $query->row_array();
        
        return $row;
    }
    
    // --------------------------------------------------------------
    
    /**
     * 查询我加入的部落的活动列表
     * @param number $customer_id 用户Id
     * @param number $tribe_id 部落id
     */
    function tribe_activity($tirbe_id,$customer_id,$limit=0,$offset=0){

        $this->db->select('ta.*,t.name as tribe_name,t.logo');
        $this->db->from('tribe_activity as ta');
        $this->db->join('tribe_staff as ts',"ta.tribe_id = ts.tribe_id ");
        $this->db->join('tribe as t','t.id = ts.tribe_id');
        $this->db->where( array('ts.customer_id' => $customer_id, 'ts.status' => 2 ) );
        $this->db->where('t.status',2);            
        $this->db->where('ta.status !=',3);
        $this->db->where('ta.type',0);

        if( is_array( $tirbe_id ) )
        {
            $this->db->where_in('t.id',$tirbe_id);
        
        }else{
        
            $this->db->where('t.id',$tirbe_id);
        }
        
        $this->db->group_by('ta.id');
        // $this->db->order_by('ta.update_at,ta.id','desc');
        $this->db->order_by('ta.update_at','desc');
        
        if( $limit )
        {
            $this->db->limit( $limit, $offset );
        }
        
        $query = $this->db->get();
  
        if( $limit )
        {
            return $query->result_array();
        }
        return $query->row_array();   
    }

    /**
     * 查询政策法规/行业动态 (当条件为全平台和公开时无论是否加入此部落都显示)
     * @param $tribe_id_type    作为数组时以部落ID查询，否则以活动ID查询详情
     * @param $type             1:政策法规 2:行业动态    
     */
    public function news_information($tribe_id_type=[],$type=1,$limit=0,$offset=0){
        $customer_id = $this->session->userdata('user_id');
        $this->db->select('ta.*,t.name as tr_name,t.logo');
        $this->db->from('tribe_activity as ta');
        $this->db->join('tribe as t','t.id = ta.tribe_id','left');
        $this->db->where('ta.status',1);
        $this->db->order_by('ta.update_at','desc');

        if($limit){
            $this->db->limit( $limit, $offset );
        }

        if( is_array($tribe_id_type) ){
            array_push($tribe_id_type,-1);
            $this->db->group_start();
            $this->db->group_start();
            $this->db->join('tribe_staff as ts',"ts.customer_id ='$customer_id' and ta.tribe_id = ts.tribe_id",'left');
            $this->db->where_in('ta.tribe_id',$tribe_id_type);
            $this->db->where('t.status',2);
            $this->db->where('ts.status',2);
            $this->db->group_end();
            $this->db->or_where('ta.tribe_id',-1);  // 全平台
            $this->db->or_where('ta.display',1);    // 公开
            $this->db->group_end();
            $this->db->where('ta.type',$type);
            $query = $this->db->get()->result_array();
            return $query;
        }else{
            $this->db->where('ta.id',$tribe_id_type);
            $query = $this->db->get()->row_array();
            return $query;
        }
    }
    
    // --------------------------------------------------------------
    
    /**
     * 发布部落活动
     * @param array $parameter 数据集合
     */
    function create($parameter){ 
        $this->db->set($parameter);
        $this->db->insert("tribe_activity");
        return $this->db->insert_id();
    }
    

    /**
     * 删除部落活动
     * @param array $id 部落id
     */
    function delete($id){
        $this->db->set("status",3);
        $this->db->where("id",$id);
        $this->db->update("tribe_activity");
        return $this->db->affected_rows();
    }
    // --------------------------------------------------------------
    
    /**
     * 更新部落活动
     * @param array $parameter 数据集合
     * @param number $id 活动id
     * @param number $tribe_id 部落id
     */
    function update($parameter,$id,$tribe_id){
        $this->db->set($parameter);
        $this->db->where("id",$id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->update("tribe_activity");
        return $this->db->affected_rows();
    }
    
    // --------------------------------------------------------------
    
    /**
     * 查询部落活动
     * @param number $id 活动id
     * @param number $tribe_id 部落id
     */
    function tribe_activity_info($id,$tirbe_id){
        $query = $this->db->get_where("tribe_activity",array('id' => $id,'tribe_id'=> $tirbe_id ));
        return $query->row_array();
    }
    
    
    /**
     * 扩展方法-
     * 1.查询我加入过的部落中的活动
     * 2.或者是全平台活动
     * 3.或者是公开状态的活动
     * @date:2018年1月2日 下午5:44:15
     * @author: fxm
     * @param: variable
     * @return:
     */
    public function Load_new_activity( $sift = array() )
    {
    
        //子查询条件，已加入过的部落
        $sql = " ( select t.id from 9thleaf_tribe_staff as ts
        join 9thleaf_tribe as t on t.id = ts.tribe_id
        where ts.customer_id = {$sift['where']['customer_id'] } and t.status = 2 and ts.status = 2 union select '-1' ) ";
    
        $this->db->select('ta.*,t.name as tr_name,t.logo');
        $this->db->from('tribe_activity` as ta');
        $this->db->join('tribe as t','t.id = ta.tribe_id','left');
        $this->db->where("( ta.tribe_id in {$sql}",'',false);
        $this->db->or_where('display = 1 ) ');//公开或者未公开。
        if(empty( $sift["is_host"])){
            $this->db->where('ta.status',1);
        }
        $this->db->where( '( ta.tribe_id = -1 or t.status = 2 )');
        
        if(isset($sift['where']['type'])){
            $this->db->where('ta.type',$sift['where']['type']);
        }
        //公告ID。
        if( !empty( $sift['where']['id'] ) )
        {
            $this->db->where('ta.id',$sift['where']['id']);
        }
    
        // $this->db->order_by('ta.id','desc');
        $this->db->order_by('ta.update_at','desc');
        $query = $this->db->get();
    
//         echo $this->db->last_query();
        if( !empty( $sift['sql_status'] ) && $sift['sql_status']  = 'result_array')
        {
            return $query->result_array();
        }
    
        return $query->row_array();
    
    }
    
    
    
}