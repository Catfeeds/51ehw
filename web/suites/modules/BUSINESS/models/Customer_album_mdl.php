<?php
/**
 *
 *个人形象  相册
 *
 */
class Customer_album_mdl extends CI_Model {
     
    function __construct() {
        parent::__construct ();
    }
 

    
    /**
     * 获取用户相册   个人简介主页
     * $limit   数量
     */
    public  function  load_albums($user_id = 0,$tribe_id = 0,$limit = 0,$offset =0 ){
        if(!$user_id){
            return false;
        }
        
        $sql = "(select  a.* from(
                	SELECT a.*
                	FROM 9thleaf_customer_album_img as a
                	JOIN 9thleaf_customer_album as b ON a.album_id = b.id
                	WHERE a.customer_id = $user_id
                	and b.tribe_id is null
                	GROUP BY a.id
                	ORDER BY a.created_at  DESC 
                	) as a
                )
                union
                (select  b.* from(
                	SELECT a.*
                	FROM 9thleaf_customer_album_img as a
                	JOIN 9thleaf_customer_album as b ON a.album_id = b.id
                	JOIN 9thleaf_tribe_staff as ts ON ts.id = b.tribe_staff_id and ts.status =2
                	WHERE a.customer_id = $user_id
                	AND (b.tribe_id = $tribe_id or b.tribe_id != $tribe_id and b.is_show = 1)
                	GROUP BY a.id
                	ORDER BY a.created_at  DESC
                	) as b
                )
                ";
       
        $sql .= "ORDER BY created_at  DESC ";
        if($limit){
            $sql .= "limit $limit";
        }
        $query =  $this->db->query($sql);
        return  $query->result_array();
    }
    
    /**
     * 修改备注
     */
    public function update_Album_remark($id,$remark){
        if(!$id || !$remark){
            echo false;
        }
        $customer_id = $this->session->userdata('user_id');
        
        $this->db->set("remark",$remark);
        $this->db->where("id",$id);
        $this->db->where("customer_id or from_customer_id = $customer_id ");
        $this->db->update("customer_album");
        $aff = $this->db->affected_rows();
        return  $aff;
    }
    
    /**
     * 获取单张相片
     */
    public function load_AlbumByImgID($id){
        if(!$id){
            echo false;
        }
        $this->db->from("customer_album_img");
        if(is_array($id)){
            $this->db->where_in("id",$id);
            return  $this->db->get()->result_array();
        }else{
            $this->db->where("id",$id);
            return  $this->db->get()->row_array();
        }
    }
    
    /**
     * 获取某个相册
     */
    public function load_album($id){
        if(!$id){
            echo false;
        }
       
        $this->db->where("id",$id);
        $this->db->from("customer_album");
        $query = $this->db->get()->row_array();
        return  $query;
    }
    
    /**
     * 删除相册
     */
    public function del_AlbumByID($id){
        if(!$id){
            echo false;
        }
        $customer_id = $this->session->userdata('user_id');
        $is_ok = false;
        $this->db->trans_begin(); // 事物执行方法中的MODEL。
        $this->db->where("id = $id and customer_id or id = $id and from_customer_id = $customer_id ");
        $this->db->delete("customer_album");
        $aff1 = $this->db->affected_rows();
        
        if($aff1){
            $this->db->where("album_id",$id);
            $aff2 = $this->db->delete("customer_album_img");
            if($aff2){
                $is_ok = true;
            }
        }
        if($is_ok){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }
        return  $is_ok;
    }
    
    /**
     * 删除
     */
    public function del_AlbumByImgID($id){
        if(!$id){
            echo false;
        }
        $this->db->where_in("id",$id);
        $this->db->delete("customer_album_img");
        $aff = $this->db->affected_rows();
        return  $aff;
    }
    
    /**
     * 检查是否有关联记录
     */
    public function check_Album(){
        $created_at= date("Y-m-d",time());
        $customer_id = $this->session->userdata('user_id');
        $this->db->from("customer_album");
        $this->db->where("customer_id",$customer_id);
        $this->db->where("created_at",$created_at);
        return  $this->db->get()->row_array();
    } 
    
    /**
     * 创建关联记录
     */
    public  function create_Album($data){
      
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("created_at",$data['created_at']);
        $this->db->set("tribe_staff_id",$data['tribe_staff_id']);
        if(!empty($data['customer_id'])){//存在用户ID则是已注册会员  不存在则是预录入用户
            $this->db->set("customer_id",$data['customer_id']);
        }
        if(!empty($data['remark'])){
            $this->db->set("remark",$data['remark']);
        }
        
        if(!empty($data['from_customer_id'])){
            $this->db->set("from_customer_id",$data['from_customer_id']);
        }
        if(!empty($data['is_show'])){
            $this->db->set("is_show",$data['is_show']);
        }
        $this->db->insert('customer_album');
        return $this->db->insert_id();
    }
    
    /**
     * 查询关联相册  album_id
     */
    public  function load_ByAlbum_Id($album_id){
        if(!$album_id){
            echo false;
        }
        $this->db->from("customer_album_img as img");
        $this->db->where("img.album_id",$album_id);
        $this->db->order_by("created_at","DESC");
        return  $this->db->get()->result_array();
    }
    
    /**
     * 获取用户上传的图片总数
     */
    public function load_album_img($customer_id,$tribe_id=0){
        if(!$customer_id){
            return false;
        }
        $this->db->select("a.*");
        $this->db->from("customer_album_img as a");
        $this->db->where("a.customer_id",$customer_id);
        if($tribe_id){
            $this->db->join("customer_album as b","a.album_id = b.id and a.customer_id = b.customer_id");
            $this->db->join('tribe_staff as ts',"b.customer_id = ts.customer_id  and ts.status = 2 ");
            $this->db->where("(b.tribe_id = $tribe_id or b.tribe_id is NULL or b.tribe_id != $tribe_id and b.is_show = 1)");
        }
        $this->db->group_by('a.id');
        $this->db->order_by("created_at","DESC");
        return  $this->db->get()->result_array();
    }
   
    /**
     * 获取用户相册   个人相册主页
     * 
     * $type   仅获取关联的ID  album_id
     */
    public  function load_albums_list($user_id = 0,$tribe_id,$limit = 0,$offset =0 ){
        if(!$user_id){
            return false;
        }
        
        $sql = "(select DISTINCT a.* from(
                    SELECT b.*, null as tribe_name
                    FROM 9thleaf_customer_album as b 
                    WHERE b.customer_id = $user_id
                    and b.tribe_id is null
                    ORDER BY b.created_at  DESC
                    ) as a
                    )
                union
                    (select  b.* from(
                    SELECT b.*,t.name as tribe_name
                    FROM 9thleaf_customer_album as b 
                    JOIN 9thleaf_tribe_staff as ts ON ts.id = b.tribe_staff_id and ts.status =2
                    JOIN 9thleaf_tribe as t ON b.tribe_id = t.id
                    WHERE b.customer_id = $user_id
                    AND (b.tribe_id = $tribe_id or b.tribe_id != $tribe_id and b.is_show = 1)
                    GROUP BY b.id
                    ORDER BY b.created_at  DESC
                    ) as b
                )";
        $sql .= " ORDER BY created_at  DESC ";
        if($offset){
            $sql .= "limit $offset,$limit";
        }else if($limit){
            $sql .= "limit $limit";
        }
       
        $query =  $this->db->query($sql);
        return  $query->result_array();
                
    }
    
    public function  get_crop_info($from_customer_id,$tribe_id){
        $this->db->select("cc.corporation_name,c.job,c.real_name,ts.corporation_name as tribe_corporation_name,ts.duties as duties,ts.member_name");
        $this->db->from("customer as c");
        $this->db->where("c.id",$from_customer_id);
        $this->db->join("customer_corporation as cc","c.id = cc.customer_id","LEFT");
        $this->db->join("tribe_staff as ts","ts.customer_id = c.id and ts.tribe_id = $tribe_id and ts.status = 2  ","LEFT");
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    
    /**
     * 插入上传的图片
     */
    public  function Create($data){
      
        if(!$data){
            echo false;
        }
        if(count($data)  == 1){
          
            $this->db->set("customer_id",$data[0]['customer_id']);
            $this->db->set("path",$data[0]['path']);
            $this->db->set("created_at",$data[0]['created_at']);
            $this->db->set("album_id",$data[0]['album_id']);
            $this->db->insert('customer_album_img');
            return $this->db->insert_id();
        }else{
            $this->db->insert_batch('customer_album_img',$data);
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }
        
    }
    
    
    /**
     * 更新编辑相册
     */
 
    public function update($data){
        if(empty($data['id'])){
            echo false;
        }
        $this->db->where("id",$data['id']);
        $this->db->set("remark",$data['remark']);
        $this->db->set("is_show",$data['is_show']);
        $this->db->set("update_at",$data['update_at']);
        $this->db->update('customer_album');
        return $this->db->affected_rows();
    }
    
    
}