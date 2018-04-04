<?php
/**
 * 省市县
 *
 *
 */
class Shipping_mdl extends CI_Model
{
    /**
     *
     *
     * @return Region_Model
     */
    function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */
	function load($id)
	{
        if (!$id){
            return array();
        }
        $query = $this->db->get_where('shipping',array('id' => $id));
        if ($row = $query->row_array()){
            return $row;
        }
		return array();
	}

	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */
	function load_all()
	{
        $query = $this->db->get('shipping');

		return $query->result_array();
	}

}