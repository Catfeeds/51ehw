<?php
/**
 * 
 *
 *
 */
class Customer_address_mdl extends CI_Model
{

	var $customer_id;
    
	var $address_name;

	var $consignee;

	var $invoice_head;
    
    var $province_id;

	var $city_id;

	var $district_id;

	var $address;

	var $postcode;
	
	var $fax;
	
	var $email;

	var $remark;

	var $is_default;

	var $mobile;

	var $phone;
	
	function __construct()
    {
        parent::__construct();
    }
    
    //查询默认送货地址
     function load($customer_id)
    {
        if (!$customer_id){
            return array();
        }

        $query = $this->db->get_where('customer_address',array('customer_id' => $customer_id,'is_default' => 1));
        $row = $query->row_array();
        
        if ($row = $query->row_array()){
        	$province = $this->get_name($row['province_id']);
        	$city = $this->get_name($row['city_id']);
        	$district = $this->get_name($row['district_id']);
        	$row['address_for_name'] = $province.'省'.$city.'市'.$district;
            return $row;
        }
        
        return array();
    }
    
    //查询送货地址详细
    function load_by_id($id)
    {
    	if (!$id){
    		return array();
    	}
    
    	$query = $this->db->get_where('customer_address',array('id' => $id));
    	error_log($this->db->last_query());
    	if ($row = $query->row_array()){
    		$province = $this->get_name($row['province_id']);
    		$city = $this->get_name($row['city_id']);
    		$district = $this->get_name($row['district_id']);
    		$row['address_for_name'] = $province.'省'.$city.'市'.$district;
    		return $row;
    	}
    
    	return array();
    }
    
    //收货地址
    public function load_by_customer($id,$customer_id)
    {
        $query = $this->db->get_where('customer_address', array(
            'customer_id' => $customer_id,
            'id' => $id
        ));
        $row = $query->row_array();
        
        $province = $this->get_name($row['province_id']);
        $city = $this->get_name($row['city_id']);
        $district = $this->get_name($row['district_id']);
        $row['address_for_name'] = $province . '省' . $city . '市' . $district;
        
        return $row;
    }
    
    //某用户下所有收货地址
    function load_all($customer_id , $limit = 0 , $offset = 0)
    {
        if (! $customer_id) {
            return array();
        }
        
        if ($limit)
            $this->db->limit($limit);
        if ($offset)
            $this->db->offset($offset);
        
        $this->db->order_by('is_default', 'DESC');
        $this->db->order_by('updated_at', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        
        $query = $this->db->get_where('customer_address', array(
            'customer_id' => $customer_id
        ));
        
        $result = array();
        foreach ($query->result_array() as $k => $v) {
            $result[$k] = $v;
            $province = $this->get_name($v['province_id']);
            $city = $this->get_name($v['city_id']);
            $district = $this->get_name($v['district_id']);
            $result[$k]['address_for_name'] = $province . '省' . $city . '市' . $district;
            $result[$k]['province_name'] = $province;
            $result[$k]['city_name'] = $city;
            $result[$k]['district_name'] = $district;
        }
        
        return $result;
    }
    
    /**
     * 总数
     *
     *
     */
    function count_address($customer_id)
    {
    	$this->db->where('customer_id',$customer_id);
    	return $this->db->count_all_results('customer_address');
    }
    
  
    /**
     * 区域名
     *
     * @return array
     */
    
    function get_name($id)
    {
    	if (!$id){
    		return '未知';
    	}
    	$this->db->select('region_name');
    	$query = $this->db->get_where('region',array('region_id' => $id));
    
    	if ($row = $query->row_array()){
    		return $row['region_name'];
    	}
    	return "未知";
    }

	// --------------------------------------------------------------------


    // --------------------------------------------------------------------

    /**
     * 添加收货地址
     * @param number $is_default
     */
	public function create($is_default=1)
    { 
		$datetime = date('Y-m-d H:i:s');
        $this->db->set('customer_id', $this->customer_id);
		$this->db->set('is_default', $is_default);
		$this->db->set('address_name', $this->address_name);
		$this->db->set('consignee', $this->consignee);
		$this->db->set('phone', $this->phone);
		$this->db->set('mobile', $this->mobile);
		$this->db->set('invoice_head', $this->invoice_head);
		$this->db->set('province_id', $this->province_id);
		$this->db->set('city_id', $this->city_id);
		$this->db->set('district_id', $this->district_id);
		$this->db->set('address', $this->address);
		$this->db->set('postcode', $this->postcode);
		$this->db->set('fax', $this->fax);
		$this->db->set('email', $this->email);
		$this->db->set('remark', $this->remark);
		$this->db->set('created_at', $datetime);
		$this->db->set('updated_at', $datetime);
		$this->db->insert('customer_address');

	             
        return $this->db->insert_id();
    }
    
    /**
     * 更新收货地址
     * @param unknown $user_id
     */
    public function update($id,$user_id)
    {
        $datetime = date('Y-m-d H:i:s');
		$this->db->set('address_name', $this->address_name);
		$this->db->set('consignee', $this->consignee);
		$this->db->set('phone', $this->phone);
		$this->db->set('mobile', $this->mobile);
		$this->db->set('invoice_head', $this->invoice_head);
		$this->db->set('province_id', $this->province_id);
		$this->db->set('city_id', $this->city_id);
		$this->db->set('district_id', $this->district_id);
		$this->db->set('address', $this->address);
		$this->db->set('postcode', $this->postcode);
		$this->db->set('fax', $this->fax);
		$this->db->set('email', $this->email);
		$this->db->set('remark', $this->remark);
		$this->db->set('updated_at', $datetime);

		$this->db->where('id', $id);
        $this->db->where('customer_id', $user_id);

        return $this->db->update('customer_address');
    }
    
    
    
	/**
	 * 删除
	 *
	 *
	 */			
    function delete($id,$customer_id)
    { 
		$this->db->where('customer_id', $customer_id);
		$this->db->where('id', $id);
        return $this->db->delete('customer_address'); 
    }

	 /**
	 * 设置默认地址
	 *
	 *
	 */
	function set_default($id,$customer_id,$is_default)
    {
		if($is_default){
			$this->db->set('is_default', 1);
			$this->db->where('id', $id);
			$this->db->update('customer_address');

			$this->db->set('is_default', 0);
			$this->db->where('customer_id', $customer_id);
			$this->db->where_not_in('id', $id);
			$this->db->update('customer_address');
		}else{
			$this->db->set('is_default', 0);
			$this->db->where('id', $id);
			$this->db->update('customer_address');
		}

		return true;
    }
}