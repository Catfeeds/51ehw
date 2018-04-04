<?php

/**
 * 商品
 *
 *
 */
class Rebate_mdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 查询app_id的分成比率
     * $sort = 2 //默认购物分成
     */
    function load( $sort = 2)
    {
        $query = $this->db->get_where('rebate', array(
//             'app_id' => $app_id,
            'sort' => $sort
        ));
        if ($row = $query->row_array()) {
            return $row;
        }
       
        return array();
    }
}