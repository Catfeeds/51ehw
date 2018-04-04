<?php

class Hot_keywords_mdl extends CI_Model
{

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------
    
    /**
     * 插入搜索记录
     * @param int customer_id 用户id
     * @param varchar keyword 关键字
     * @param int $type 类型 1商品2部落
     */
    public function add_hot_keywords($customer_id,$keyword,$type){
        $time = date('Y-m-d H:i:s');
        
        $this->db->set('frequency',"frequency+1",false);
        $this->db->set('created_at', $time);
        $this->db->where('keyword',$keyword);
        $this->db->where("type",$type);
        $this->db->where("customer_id",$customer_id);
        $this->db->update('hot_keywords');
        $row = $this->db->affected_rows();

        if(!$row){
            $this->db->set('keyword', $keyword);
            $this->db->set('created_at', $time);
            $this->db->set("type",$type);
            $this->db->set("customer_id",$customer_id);
            $this->db->insert('hot_keywords');
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 获取最热门的搜索关键词
     * @param int $offset
     * @param int $type 类型 1商品2部落
     */
    public function get_hot_keywords($offset=3,$type){
        $this->db->select("keyword");
        //限制特殊字符输出
        $this->db->where(" keyword not like '%\%%'");
        $this->db->where(" keyword not like '%[%'");
        $this->db->where(" keyword not like '%]%'");
        $this->db->where(" keyword not like '%~%'");
        $this->db->where(" keyword not like '%!%'");
        $this->db->where(" keyword not like '%@%'");
        $this->db->where(" keyword not like '%#%'");
        $this->db->where(" keyword not like '%$%'");
        $this->db->where(" keyword not like '%^%'");
        $this->db->where(" keyword not like '%*%'");
        $this->db->where(" keyword not like '%&%'");
        $this->db->where(" keyword not like '%(%'");
        $this->db->where(" keyword not like '%)%'");
        $this->db->where(" keyword not like '%,%'");
        $this->db->where(" keyword not like '%.%'");
        $this->db->where(" keyword not like '%?%'");
        $this->db->where("type",$type);
        $this->db->order_by("frequency","desc")->limit($offset);
        $query = $this->db->get("hot_keywords");
        return $query->result_array();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 根据用户id查询搜索记录
     * @param int $customer_id 用户id
     * @param int $type 类型 1商品2部落
     * @param int $limit 显示数量
     */
    public function Mymemories($customer_id,$type,$limit){
        $this->db->select("keyword");
        $this->db->from("hot_keywords");
        $this->db->where("customer_id",$customer_id);
        $this->db->where("type",$type);
        $this->db->limit($limit);
        $this->db->order_by("created_at,frequency","desc");
        return $this->db->get()->result_array();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 根据用户id删除搜索记录
     * @param int $customer_id 用户id
     * @param int $type 类型 1商品2部落
     */
    public function del_memories($customer_id,$type){
        $this->db->where("type",$type);
        $this->db->where("customer_id",$customer_id);
        $this->db->delete("hot_keywords");
        return $this->db->affected_rows();
    }
}