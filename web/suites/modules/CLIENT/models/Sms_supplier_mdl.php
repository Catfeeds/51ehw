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
     *
     */
    function get_in_use(){
        $query = $this->db->get_where('sms_supplier',array('in_use' => 1));
        $row = $query->row_array();
        error_log($this->db->last_query());
        return $row;
    }
}
?>