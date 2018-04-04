<?php
/**
 *
 *预录入用户个人形象  相册
 *
 */
class Tribe_staff_album_mdl extends CI_Model {
     
    function __construct() {
        parent::__construct ();
    }
 
    
    /**
     * 预录入用户个人简介主页
     * $limit   数量
     */
    public  function  get_albums($tribe_staff_id,$limit = 12){
        $this->db->select("sai.path");
        $this->db->where("sai.tribe_staff_id",$tribe_staff_id);
        $this->db->from("staff_album_img as sai");
        $this->db->join("staff_album as sa","sai.staff_album_id = sa.id");
        $this->db->order_by("sai.created_at","DESC");
        if($limit){
            $this->db->limit($limit);
            return  $this->db->get()->result_array();
        }else{
            return  $this->db->get()->num_rows();
        }
    }
    
    /**
     * 同步更新  将预录入的相册 同步到用户相册(默认不公开)
     * 
     */
    public function synchro_Update($customer_id,$tribd_id= 0){
        //查出当前用户下预录入的所有部落
        $staff_infos = $this->synchro_Get_Staff_Info($customer_id,$tribd_id);
        if($staff_infos){
            foreach ($staff_infos as $key => $val){
                // 查出某个族员下之前预录入的相册
                $albums = $this->synchro_Get_Staff_album($val['id']);//族员ID
                if($albums){
                    foreach ($albums as $k =>$v){
                        //查出某个相册的多少图片
                        $album_imgs = $this->load_ByAlbum_Id($v['id']);//预录入相册ID
                        if($album_imgs){
                            $this->db->trans_begin(); // 事物执行方法中的MODEL。
                            $is_ok = true;
                            //创建用户相册
                            $cus_album['customer_id'] = $customer_id;
                            $cus_album['tribe_staff_id'] = $v['tribe_staff_id'];
                            $cus_album['from_customer_id'] = $v['from_customer_id'];
                            $cus_album['created_at'] = $v['created_at'];
                            $cus_album['update_at'] = $v['update_at'];
                            $cus_album['remark'] = $v['remark'];
                            $cus_album['tribe_id'] = $v['tribe_id'];
                            $cus_ablum_id = $this->synchro_Create_Cus_album($cus_album);
                            if($cus_ablum_id){
                                //创建用户相册成功
                                foreach ($album_imgs as $ks =>$vs){
                                    $cus_album_img['customer_id'] = $customer_id;
                                    $cus_album_img['album_id'] = $cus_ablum_id;
                                    $cus_album_img['path'] = $vs['path'];
                                    $cus_album_img['created_at'] =$vs['created_at'];
                                    $Cus_album_img_id =  $this->synchro_Create_Cus_album_img($cus_album_img);
                                    if(!$Cus_album_img_id){
                                        //保留相册图片失败
                                        $is_ok = false;
                                    }else{
                                        //保留相册图片成功
                                    }
                                }
                                if($is_ok){
                                    //同步用户相册成功
                                    $this->db->trans_commit();
                                    //删除预录入用户相册及图片
                                    $this->del_AlbumByID($v['id']);
                                }else{
                                    //存在有某张图片不能保存成功
                                    $this->db->trans_rollback();
                                }
                            }else{
                                //创建用户相册失败
                                $this->db->trans_rollback();
                            }
                        }
                    }
                }
            }
        }
        
        //         echo '<pre>';
        //         echo $this->db->last_query();
        //         print_r($albums);exit;
    }
    
    /**
     * 查出某个用户下加入的所有部落
     */
    public function synchro_Get_Staff_Info($customer_id,$tribd_id){
        $this->db->select("ts.id");
        $this->db->from("tribe_staff as ts");
        $this->db->where("ts.customer_id",$customer_id);
        if($tribd_id){
            $this->db->where("ts.tribe_id",$tribd_id);
        }
        $this->db->where("ts.status",2);
        $this->db->where("ts.status",2);
        return $this->db->get()->result_array();
    }
    
    /**
     * 查出某个族员下之前预录入的相册
     * @param unknown $data
     */
    public function synchro_Get_Staff_album($tribe_staff_id){
        $this->db->select("sa.*");
        $this->db->from("staff_album as sa");
        $this->db->join("staff_album_img sai","sa.id = sai.staff_album_id");
        $this->db->where("sa.tribe_staff_id",$tribe_staff_id);
        $this->db->group_by("sa.id");
        //查出多少个需要同步的相册
        return $this->db->get()->result_array();
    }
    
    /**
     * 同步创建注册用户的相册
     * @param unknown $data
     */
    public function synchro_Create_Cus_album($data){
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("created_at",$data['created_at']);
        $this->db->set("tribe_staff_id",$data['tribe_staff_id']);
        $this->db->set("customer_id",$data['customer_id']);
        $this->db->set("remark",$data['remark']);
        $this->db->set("from_customer_id",$data['from_customer_id']);
        $this->db->set("is_show",0);
        $this->db->insert('customer_album');
        return $this->db->insert_id();
    }
    
    /**
     * 同添加用户相册图片
     */
    public function  synchro_Create_Cus_album_img($data){
        $this->db->set("created_at",$data['created_at']);
        $this->db->set("customer_id",$data['customer_id']);
        $this->db->set("path",$data['path']);
        $this->db->set("album_id",$data['album_id']);
        $this->db->insert('customer_album_img');
        return $this->db->insert_id();
    }
    
    /**
     * 加载相册
     */
    public function load_albums($tribe_staff_id,$limit=0,$offset = 0){
      
       $this->db->where('tribe_staff_id',$tribe_staff_id);
       $this->db->from('staff_album');
       if($offset){
           $this->db->limit($limit,$offset);
       }elseif($limit){
           $this->db->limit($limit);
       }
       $this->db->order_by("created_at","DESC");
       return  $this->db->get()->result_array();
    }
    
    public  function  load_ByAlbum_Id($staff_album_id){
        $this->db->where("staff_album_id",$staff_album_id);
        $this->db->from('staff_album_img');
        $this->db->order_by("created_at","DESC");
        return  $this->db->get()->result_array();
    }
    
    
    /**
     * 获取某个相册
     */
    public function load_staff_album($id){
        if(!$id){
            echo false;
        }
       
        $this->db->where("id",$id);
        $this->db->from("staff_album");
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
        $is_ok = false;
        $this->db->trans_begin(); // 事物执行方法中的MODEL。
        $this->db->where("id",$id);
        $this->db->delete("staff_album");
        $aff1 = $this->db->affected_rows();
        error_log($this->db->last_query());
        if($aff1){
            $this->db->where("staff_album_id",$id);
            $aff2 = $this->db->delete("staff_album_img");
            error_log($this->db->last_query());
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
        $this->db->delete("staff_album_img");
        $aff = $this->db->affected_rows();
        return  $aff;
    }
    
    
    /**
     * 创建关联记录
     */
    public  function create_Album($data){
      
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("created_at",$data['created_at']);
        $this->db->set("tribe_staff_id",$data['tribe_staff_id']);
        
        if(!empty($data['remark'])){
            $this->db->set("remark",$data['remark']);
        }
        $this->db->set("from_customer_id",$data['from_customer_id']);
        $this->db->insert('staff_album');
        return $this->db->insert_id();
    }
    
   
   
    /**
     * 获取用户相册   个人相册主页
     */
    
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
            $this->db->set("tribe_staff_id",$data[0]['tribe_staff_id']);
            $this->db->set("path",$data[0]['path']);
            $this->db->set("created_at",$data[0]['created_at']);
            $this->db->set("staff_album_id",$data[0]['staff_album_id']);
            $this->db->insert('staff_album_img');
            return $this->db->insert_id();
        }else{
            $this->db->insert_batch('staff_album_img',$data);
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
        $this->db->set("update_at",$data['update_at']);
        $this->db->update('staff_album');
        return $this->db->affected_rows();
    }
    
    
}