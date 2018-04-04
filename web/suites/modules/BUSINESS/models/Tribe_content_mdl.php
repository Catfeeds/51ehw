<?php

/**
 * 订单核销
 *
 *
 */
class Tribe_content_mdl extends CI_Model
{
    function __construct()
    { 
        parent::__construct ();
    }
    
    /**
     * 查询公告列表
     */
    public function Load_List( $sift = array() )
    { 
        if( !$sift['where']['customer_id'] )
            return array();
       
        $this->db->select('tc.*');
        $this->db->from('tribe_content as tc');
        $this->db->where('tc.status',1);
        
        if( !empty( $sift['sql_status'] ) )
        {
            //只关联存在的部落公告
            $this->db->join('tribe_staff as ts','tc.tribe_id = ts.tribe_id');
            //51需求
            if(!is_array($sift['where']['tribe_id'])){
                
                $this->db->where( array('ts.customer_id' => $sift['where']['customer_id'], 'ts.status' => 2,'ts.tribe_id'=> $sift['where']['tribe_id'] ) );
           
            }else{//商会APP搜索部落公告需求
                if(!empty($sift['page']['offset'])){
                    $this->db->limit($sift['page']['limit'],$sift['page']['offset']);
                }else if(!empty($sift['page']['limit'])){
                    $this->db->limit($sift['page']['limit']);
                }
                $this->db->where( 'ts.status' ,2);
                if($sift['where']['tribe_id']){
                    $this->db->where_in('ts.tribe_id',$sift['where']['tribe_id']);
                }else{
                    $this->db->where_in('ts.tribe_id',0);
                }
                if(!empty($sift['like']['keyword'])){//关键词模糊搜索
                    $this->db->like("tc.title",$sift['like']['keyword']);
                }
                
            }
        }else{
            
            //全平台
            $this->db->where('tc.tribe_id',-1);
          
        }
        
        $this->db->group_by('tc.id');
        $this->db->order_by('tc.last_updated_time','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
    }
    
    
    
    /**
     * 查询公告详细
     */
    public function Load( $sift = array () )
    { 
        if( !$sift['where']['id'] )
            return array();
        
        $this->db->select('tc.*');
        $this->db->from('tribe_content as tc');
        $this->db->where('tc.id',$sift['where']['id']);
        if( !empty( $sift['where']['status'] ) )
        {
//             $this->db->where('ts.is_host',1);
            $this->db->where_in( 'tc.status',$sift['where']['status'] );
        }else{
        
            $this->db->where( array('tc.status' => 1) );
        }
        
        
        if( !empty( $sift['where']['tribe_id'] ) )
        { 
            $this->db->join('tribe_staff as ts','tc.tribe_id = ts.tribe_id');
            $this->db->where( array('ts.customer_id' => $sift['where']['customer_id'], 'ts.status' => 2,'ts.tribe_id'=> $sift['where']['tribe_id']) );
            
        }else{
            
            $this->db->where( array('tc.tribe_id'=>-1) );
        }
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }
    
    
   /**
    * 扩展方法-
    * 1.查询我加入过的部落中的公告
    * 2.或者是全平台公告
    * 3.或者是公开状态的公告
    * @date:2018年1月2日 下午5:44:15
    * @author: fxm
    * @param: variable
    * @return: 
    */
    public function Load_new_content( $sift = array() )
    { 
        
        //子查询条件，已加入过的部落
        $sql = " ( select t.id from 9thleaf_tribe_staff as ts 
                join 9thleaf_tribe as t on t.id = ts.tribe_id 
                where ts.customer_id = {$sift['where']['customer_id'] } and t.status = 2 and ts.status = 2 union select '-1' ) ";
        
        $this->db->select('tc.*,t.name as tr_name,t.logo');
        $this->db->from('tribe_content` as tc');
        $this->db->join('tribe as t','t.id = tc.tribe_id','left');
        $this->db->where("( tc.tribe_id in {$sql}",'',false);
        $this->db->or_where('display = 1 )');//公开或者未公开。
        $this->db->where('tc.status',1 );
        $this->db->where( '( tc.tribe_id = -1 or t.status = 2 )');
        
        //公告ID。
        if( !empty( $sift['where']['id'] ) )
        { 
            $this->db->where('tc.id',$sift['where']['id']);
        }
        
        $this->db->order_by('tc.last_updated_time','desc');
        $query = $this->db->get();
        
        if( !empty( $sift['sql_status'] ) && $sift['sql_status']  = 'result_array')
        { 
            return $query->result_array();
        }
        
        return $query->row_array();
        
    }
    
    // ---------------------------------------------------------------
    
    /**
     * 创建公告
     * @param array $parameter 数据集合
     */
    public function create($parameter){
        $this->db->set($parameter);
        $this->db->insert("tribe_content");
        return $this->db->insert_id();
    }
    

    /**
     * 删除公告
     * @param array $id 数据id
     */
    public function delete($id){
        $this->db->set("status", 3);
        $this->db->where("id",$id);
        $this->db->update("tribe_content");
        return $this->db->affected_rows();
    }
    // ---------------------------------------------------------------
    
    /**
     * 更新公告
     * @param number $id 公告id
     * @param number $tribe_id 部落id
     * @param array $parameter 数据集合
     */
    public function update($id,$tribe_id,$parameter){
        $this->db->set($parameter);
        $this->db->where("id",$id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->update("tribe_content");
        return $this->db->affected_rows();
    }
    
    // ---------------------------------------------------------------
    
    /**
     * 查询我管理的部落公告列表
     * @param number $customer_id 用户id
     * @param number $tribe_id 部落id
     * @param number $limit 
     * @param number $offset
     */
    public function load_announcements_list($customer_id,$tribe_id,$limit,$offset){
        $this->db->select("a.id,a.title,a.last_updated_time,a.title_img,a.tribe_id,a.create_time,a.status");
        $this->db->from("tribe_content as a");
        $this->db->join("tribe_staff as b","b.tribe_id = a.tribe_id");
        $this->db->where("a.tribe_id",$tribe_id);
        $this->db->where("b.customer_id",$customer_id);
        $this->db->where("a.status !=",3);
        
        
        // $this->db->order_by("a.id","desc");
        $this->db->order_by("a.last_updated_time","desc");
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /**
     * 查询加入的部落公告 
     * @$tribe_ids = 部落ID 数组，返回的内容限制在这些部落中。
     */
    public function Load_Tribe_Content( $customer_id = 0, $tribe_ids = array() )
    { 
        if( !$customer_id || !$tribe_ids )
            return array();
             
        
        $this->db->select('tc.*');
        $this->db->from('tribe_content as tc');
        $this->db->where('tc.status',1);
        $this->db->join('tribe_staff as ts','tc.tribe_id = ts.tribe_id');
        $this->db->where( array('ts.customer_id' => $customer_id, 'ts.status' => 2 ) );
        $this->db->where_in('tc.tribe_id',$tribe_ids);
        $this->db->group_by('tc.id');
        $this->db->order_by('tc.last_updated_time','desc');
        $query = $this->db->get();
        $result = $query->result_array();
    
        return $result;
    }
    
    
    /**
     * 获取单条公告未读人数
     */
    public  function getNoticeUnreadCount($id){
        $this->db->select('tc.*,(count(distinct(ts.id))-count(distinct(tr.id))) as unreadnum');
        $this->db->from('tribe_content as tc');
        $this->db->where('tc.status',1);
        $this->db->join('tribe_staff as ts','tc.tribe_id = ts.tribe_id');
        $this->db->join("tribe_read as tr","tc.id = tr.obj_id and tr.type = 1 and tr.customer_id = ts.customer_id","left");
        $this->db->where('ts.status',2 );
        $this->db->where('tc.id',$id);
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    /**
     * 查询加入的部落公告列表（含统计）
     * @param array $tribe_ids = 部落ID 数组
     * @param string $keyword 关键词
     */
    public function Load_Notice($tribe_ids , $limit=0, $offset=0, $keyword = false)
    {

            $this->db->select('tc.*,(count(distinct(ts.id))-count(distinct(tr.id))) as unreadnum');
            $this->db->from('tribe_content as tc');
            $this->db->where('tc.status',1);
            $this->db->join('tribe_staff as ts','tc.tribe_id = ts.tribe_id');
            $this->db->join("tribe_read as tr","tc.id = tr.obj_id and tr.type = 1 and tr.customer_id = ts.customer_id","left");
            $this->db->where( array('ts.status' => 2 ) );
            $this->db->where_in('tc.tribe_id',$tribe_ids);
            $this->db->like("title",$keyword);
            $this->db->group_by('tc.id');
            $this->db->order_by('tc.last_updated_time','desc');
            $this->db->limit($limit,$offset);
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
    }
    
    /**
    * @author JF
    * 2017年11月28日
    * 查询已读公告人员
    * @param number $id 公告id
    */
    function read($id,$limit=0,$offset=0){
        if(!$id){
            return array();
        }
        $this->db->select("any_value(a.member_name) as member_name,b.customer_id,c.real_name");
        $this->db->from("tribe_staff as a");
        $this->db->join("tribe_read as b","a.customer_id = b.customer_id");
        $this->db->join("customer as c","b.customer_id = c.id","left");
        $this->db->where("b.obj_id",$id);
        $this->db->where("a.status",2);
        $this->db->group_by("b.id");
        if($limit){
            $this->db->limit($limit,$offset);
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->num_rows();
        }
    }
    
    /**
    * @author JF
    * 2017年11月28日
    * 查询未读公告人员
    * @param number $id 公告id
    */
    function unread($id,$limit=0,$offset=0){
        if(!$id){
            return array();
        }
        //查询已读用户
        $this->db->select("customer_id");
        $Readingusers = $this->db->get_where("tribe_read",array("obj_id"=>$id))->result_array();
        $Readingusers = array_column($Readingusers, "customer_id");
        
        
        //查询未读用户
        $this->db->select("b.member_name,b.customer_id,c.real_name");
        $this->db->from("tribe_content as a");
        $this->db->join("tribe_staff as b","a.tribe_id = b.tribe_id and b.status = 2");
        $this->db->join("customer as c","b.customer_id = c.id","left");
        $this->db->where("a.id",$id);
        if($Readingusers){
            $this->db->where_not_in("(b.customer_id",$Readingusers,false);
            $this->db->or_where("b.customer_id IS NULL)");
        }else{
            $this->db->or_where("b.customer_id IS NULL");
        }
        
        
        if($limit){
            $this->db->limit($limit,$offset);
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->num_rows();
        }
    }
    
    
    
    
    
    
    
}