<?php
/**
 *
 * @author clarkso
 *
 */
class Shortmsg_log_mdl extends CI_Model {

    /**
     *
     */
    function __construct() {
        parent::__construct ();
    }

    //-----------------------------------------------

    /**
     * 新建记录
     * @param unknown $data
     */
    function create($log){
        $this->db->set ( 'created_at', date("Y-m-d H:i:s",time()) );
        $this->db->set ( 'mobile_number', $log ['mobile'] );
        $this->db->set ( 'content', $log ['content'] );
        $this->db->insert ( 'shortmsg_log' );
        return $this->db->insert_id();
    }

    function update($log){

        $this->db->set ( 'msg_type', $log ['msg_type'] );
        $this->db->set ( 'status', $log ['status'] );
        $this->db->set ( 'return_msg', $log ['return_msg'] );
        $this->db->where('id', $log ['id']);
        return $this->db->update ( 'shortmsg_log' );
    }
}
?>