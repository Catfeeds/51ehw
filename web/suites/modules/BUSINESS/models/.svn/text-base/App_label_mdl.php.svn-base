<?php

/**
 *
 * 部落商会mdl
 *
 */

class  App_label_mdl extends CI_Model {
    
    
    function __construct() {
        parent::__construct ();
    }

    /**
     * 获取商会标签信息
     * int $id 标签ID
     */
    public function Load( $id = 0 , $status = '') 
    {
        $query = $this->db->get_where('app_label',array('id'=> $id) );
        return $query->row_array();
    }
    
    
    /**
     * 获取商会首页banner
     * int $id 标签ID
     */
    public function Load_Banner( $id = 0 )
    {
        $this->db->order_by('sort');
        $query = $this->db->get_where('app_label_banner',array('app_label_id'=> $id) );
        return $query->result_array();
    }
    
    /**
     * 获取商会首页中部导航
     * int $id 标签ID
     */
    public function Load_Nav( $id = 0 )
    { 
        $this->db->order_by('sort');
        $query = $this->db->get_where('app_label_nav',array('app_label_id'=> $id) );
        
        return $query->result_array();
    }

    
    /**
     * 获取商会2级标签
     * @param $id 一级标签
     */
    public function Load_tribe_app_label( $id = 0 )
    {
        $this->db->order_by('sort');
        $query = $this->db->get_where('tribe_app_label',array('app_label_id'=> $id) );
    
        return $query->result_array();
    }
    
    /**
     * 获取商会2级标签
     * @param $tribe_app_label_id 二级标签
     */
    public function Load_tribe_app_label_detail($tribe_app_label_id){
        $query = $this->db->get_where('tribe_app_label',array('id'=> $tribe_app_label_id) );
        return $query->row_array();
    }
    
    
    /**
     * 杰出商会
     */
    
    public function outstanding($limit= 0,$offset = 0){
        $this->db->select("t.id,t.name,t.logo,t.content");
        $this->db->from("outstanding as o");
        $this->db->join("tribe as t","o.tribe_id = t.id");
        $this->db->where("o.type",1);
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * app_label_member
     */
    public function load_label_member($label_id = 0){
        if($label_id == 0){
            return false;
        }
        $user_id  =  $this->session->userdata("user_id");//用户id
        $this->db->from("app_label_member");
        $this->db->where("customer_id",$user_id);
        $this->db->where("app_label_id",$label_id);
        return $this->db->get()->row_array();
    }
    public  function  create_label_member($data){
        $this->db->insert('app_label_member',$data);
        return $this->db->insert_id ();
    }
    
    /**
     * 获取商会推荐店铺
     * 默认获取5条数据
     */
    public function getRecomendedShop($label_id,$limit = 5){
        $this->db->from("app_label_recomended_shop as alrs");
        $this->db->where("alrs.label_id",$label_id);
        $this->db->where("alrs.status",0);
        $this->db->order_by("alrs.sort","ASC");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /**
     * 获取特产专区导航
     */
    //获取最顶级的的分类
    public function get_SpecialtyTopNav($label_id = 0){
        if($label_id){
            $this->db->where("app_label_id",$label_id);
        }
        $this->db->from("app_label_category");
        $this->db->where("level",1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //获取父级下的所有分类
    public function get_SpecialtyNav($parent_id){
        $this->db->from("app_label_category");
        $this->db->where("parent_id",$parent_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //获取特产商品 
    
    public function get_SpecialtyProduct($sift){
        
        
       if(!empty($sift['where']['type'])  && $sift['where']['type']== 2){
           $limit_sql = '';
          if(!empty($sift['page']['offset'])){
            
              $limit_sql = "LIMIT {$sift['page']['offset']},{$sift['page']['limit']}";
           
            }else if(!empty($sift['page']['limit'])){
                $limit_sql = " LIMIT {$sift['page']['limit']}";
            }
            $product = '';
            if(!empty($sift['search']['product'])){
                $product = " AND `p`.`name` LIKE '%{$sift['search']['product']}%'";
            }
            
            
            
          $sql= "SELECT `p`.*, `pi`.`file`,any_value(sale.salenum) as sales 
                FROM `9thleaf_app_label_category` as `alc` 
                JOIN `9thleaf_product` as `p` ON `alc`.`product_id` = `p`.`id` 
                LEFT JOIN `9thleaf_product_image` as `pi` ON `p`.`id` = `pi`.`product_id` AND `pi`.`is_base` = 1 
                LEFT JOIN (
                	SELECT  `oi`.`product_id`,sum(oi.quantity) as salenum  from 9thleaf_order_item as oi
                    LEFT JOIN `9thleaf_order` as `o` ON `oi`.`order_id` = `o`.`id` and `o`.`status` in(7,9,14) 
                    GROUP BY `oi`.`product_id`
                ) as sale on sale.product_id = p.id
                WHERE `alc`.`level` = 3 
                AND `alc`.`app_label_id` = {$sift['where']['label_id']}
                AND `p`.`is_on_sale` = 1 
                AND `p`.`is_delete` =0 
                AND `p`.`is_mc` =0 
                $product
                ORDER BY `sales` DESC 
                $limit_sql
                ";
          return $this->db->query($sql)->result_array();
        }
        
        $this->db->select("p.*,pi.file");
        $this->db->where("alc.level",3);
      
        $this->db->from("app_label_category as alc");
        
        if( $sift['where']['label_id']){
            $this->db->where("alc.app_label_id",$sift['where']['label_id']);
        }
        
        $this->db->join("product as p","alc.product_id = p.id");
        $this->db->join("product_image as pi","p.id = pi.product_id and pi.is_base = 1","LEFT");
        $this->db->where("p.is_on_sale",1);
        $this->db->where("p.is_delete",0);
        $this->db->where("p.is_mc",0);
        if(!empty($sift['search']['product'])){
            $this->db->like("p.name",$sift['search']['product']);
        }
        
        if(!empty($sift['page']['offset'])){
            $this->db->limit($sift['page']['limit'],$sift['page']['offset']);
        }else if(!empty($sift['page']['limit'])){
            $this->db->limit($sift['page']['limit']);
        }
        
        if(!empty($sift['where']['parent_id'])){
            $this->db->where("alc.parent_id",$sift['where']['parent_id']);
        }else{
            if(empty($sift['where']['type'])){
                $this->db->order_by("alc.sort","DESC");
                //不作处理
            }else if($sift['where']['type'] == 1){
                $this->db->order_by("p.on_sale_at","DESC");
            }
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
}