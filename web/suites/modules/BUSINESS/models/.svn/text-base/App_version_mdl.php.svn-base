<?php
/**
 * 接口版本控制类
 * @author PHP-09
 *
 */
class App_version_mdl extends CI_Model {
    
    function __construct() {
        parent::__construct ();
    }
    
    /**
     * 根据版本号查询版本信息
     */
    public function get_by_version_num( $select = 'av.*' , $version_num = "" ,$type = 1,$app_label_id = 0)
    {
        if ($version_num != "") {
            $this->db->where("version_num", $version_num);
        }
        if ($select != 'av.*') {
            $select .= ',av.*';
        }

        $this->db->select($select);
        $this->db->from('app_version as av');
        $this->db->where("type", $type);
        if($app_label_id){
            $this->db->where("app_label_id", $app_label_id);
        }
	    $this->db->order_by('av.version_num','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    
    /**
     * 获取标签ID
     */
    public function getIDBylabel_sn($label_sn){
        $this->db->select("id");
        $this->db->from('app_label');
        $this->db->where("label_sn",$label_sn);
        return $this->db->get()->row_array();
    }
    
    /**
     * 商会APP
     * 通过标签编号 获取绑定的相关部落信息
     * number $label_sn
     */
    
    public  function get_tribe_label_sn($label_sn){
        
        $this->db->select("tal.tribe_id");
        $this->db->from('app_label as al');
        $this->db->join("tribe_app_label as tal","tal.app_label_id = al.id");
        $this->db->where("al.label_sn",$label_sn);
        return $this->db->get()->result_array();
    }
    
}