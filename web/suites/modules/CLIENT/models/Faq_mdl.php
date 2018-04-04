<?php
/**
 * 常见问题
 *
 *
 */
class Faq_mdl extends CI_Model
{


    
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

        $query = $this->db->get_where('faq',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------


    /**
	 * 查询常见问题
	 *
	 *
	 */	
	function find_faqs($count=0, $offset=0,$options = array())
	{

		if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
        $this->db->select('id,title');

		$this->db->order_by('created_at','desc');

		$query = $this->_query_orders($options);

        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }

        return $rows;
	}
	
	
	/**
	 * 获取订单信息
	 *
	 *
	 */
	function get_order($account_id,$order_id='')
	{
        $this->db->select('A.order_sn,B.product_name,A.place_at,A.id,D.file,B.quantity');
        $this->db->from('order A');
        $this->db->join('order_item B', 'A.id = B.order_id','left');
        $this->db->join('product C', 'B.product_id = C.id','left');
        $this->db->join('product_image D', 'C.id = D.product_id ','left');
        $this->db->where('A.customer_id',$account_id);
        $this->db->where('D.is_base','1');
        $status = array(7,8,9);//可以申请退货状态
        $this->db->where_in('A.status',$status);
        
        if(!empty($order_id)){
            $this->db->where('A.id',$order_id);
        }
        $query = $this->db->get();
//         echo $this->db->last_query();exit;
        if($query->result_array()){
            return $query->result_array();
        }else{
            return null;
        }
	}
	
    // --------------------------------------------------------------------

    /**
	 * 私有函数
	 *
	 *
	 */
	function _query_orders($options)
    {
        $this->db->from('faq');
		
        return $this->db->get();
    }
    
    // --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_orders($options = null)
	{		
		$this->db->select('COUNT(DISTINCT(id)) as total');       
        $query = $this->_query_orders($options);
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}

    // --------------------------------------------------------------------

}