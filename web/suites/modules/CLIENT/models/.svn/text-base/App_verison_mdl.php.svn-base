<?php
/**
 * 接口版本控制类
 * @author PHP-09
 *
 */
class App_verison_mdl extends CI_Model {
    
    function __construct() {
        parent::__construct ();
    }
    
    /**
     * 根据版本号查询版本信息
     */
    public function get_by_version_num( $select = 'av.*' , $version_num = "" ,$type = 1)
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
	    $this->db->order_by('av.version_num','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
//         echo $this->db->last_query();exit;
        return $query->row_array();
    }
}