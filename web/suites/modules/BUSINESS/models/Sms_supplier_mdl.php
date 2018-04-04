<?php
/**
 *
 * @author clarkso
 *
 */
class Sms_supplier_mdl extends CI_Model {

    /**
     *
     */
    function __construct() {
        parent::__construct ();
    }

    //-----------------------------------------------

    /**
     * 获取正在使用的供应商
     * @param int $type 类型1行业2营销
     */
    function get_in_use($type){
        $query = $this->db->get_where('sms_supplier',array('in_use' => 1,'type'=>$type));
        $row = $query->row_array();
        return $row;
    }
}
?>