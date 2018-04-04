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
     * @param varchar keyword 关键字
     * @param int 类型 1商品2部落
     */
    public function add_hot_keywords($customer_id,$keyword,$type){
        $time = date('Y-m-d H:i:s');
        
        $this->db->set('frequency',"frequency+1",false);
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
//             echo $this->db->last_query();exit;
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
    
}