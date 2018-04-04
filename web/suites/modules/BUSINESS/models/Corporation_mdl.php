<?php
/**
 *
 *
 *
 */
class Corporation_mdl extends CI_Model {

    
    var $customer_id;
    var $corporation_name;
    var $corporation_area;
    var $address;
    var $postcode;
    var $email;
    var $contact_name;
    var $contact_mobile;
    var $province_id;
    var $city_id;
    var $district_id;
    var $app_id;
    var $auto_order_amount;
    var $description;
    var $status;
    var $approval_status;
    var $approval_desc;
    var $img_url;
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 添加新公司
	 */
	function create() {

	    $this->db->set('customer_id',$this->customer_id);
	    $this->db->set('corporation_name',$this->corporation_name);
	    $this->db->set('corporation_area',$this->corporation_area);
	    $this->db->set('address',$this->address);
	    $this->db->set('postcode',$this->postcode);
	    $this->db->set('email',$this->email);
	    $this->db->set('contact_name',$this->contact_name);
	    $this->db->set('contact_mobile',$this->contact_mobile);
	        $this->db->set('province_id',$this->province_id);
	        $this->db->set('city_id',$this->city_id);
	        $this->db->set('district_id',$this->district_id);
	    $this->db->set("app_id",$this->app_id);
	    $this->db->set("auto_order_amount",100000);
	    if( isset($this->status) )
	        $this->db->set("status",$this->status);
	    if( isset($this->approval_status) )
	        $this->db->set('approval_status', $this->approval_status);
	    if( isset($this->approval_desc) )
	        $this->db->set('approval_desc', $this->approval_desc );
	    if( isset($this->img_url) )
	        $this->db->set('img_url', $this->img_url );
		$this->db->insert ( 'customer_corporation');

		return $this->db->insert_id();
	}

	function update() {

	    if(isset($this->customedescriptionr_id)){
	    $this->db->set('customer_id',$this->customer_id);
	    }
	    if(isset($this->corporation_name)){
	    $this->db->set('corporation_name',$this->corporation_name);
	    }
	    if(isset($this->corporation_area)){
	    $this->db->set('corporation_area',$this->corporation_area);
	    }
	    if(isset($this->address)){
	    $this->db->set('address',$this->address);
	    }
	    if(isset($this->postcode)){
	    $this->db->set('postcode',$this->postcode);
	    }
	    if(isset($this->email)){
	    $this->db->set('email',$this->email);
	    }
	    if(isset($this->contact_name)){
	    $this->db->set('contact_name',$this->contact_name);
	    }
	    if(isset($this->contact_mobile)){
	    $this->db->set('contact_mobile',$this->contact_mobile);
	    }
	    if(isset($this->status)){
	        $this->db->set('status',$this->status);
	    }
	    if(isset($this->province_id)){
	        $this->db->set('province_id',$this->province_id);
	    }
	    if(isset($this->city_id)){
	        $this->db->set('city_id',$this->city_id);
	    }
	    if(isset($this->district_id)){
	        $this->db->set('district_id',$this->district_id);
	    }
	    if(isset($this->approval_status)){
	        $this->db->set('approval_status',$this->approval_status);
	    }
	    if(isset($this->auto_order_amount)){
	        $this->db->set('auto_order_amount',$this->auto_order_amount);
	    }
	    if(isset($this->description)){
	        $this->db->set('description',$this->description);
	    }
	    if(isset($this->img_url) ){ 
	        $this->db->set('img_url',$this->img_url);
	    }
	    if(isset($this->deposit) ){
	        $this->db->set('deposit',$this->deposit);
	    }
	    if(isset($this->grade) )
	    { 
	        $this->db->set('grade',$this->grade);
	    }
	    $this->db->where('id',$this->corporation_id);


	    $res = $this->db->update ( 'customer_corporation');
        
	    return $res;
	}

	/**
	 *
	 */
	function load($customer_id){

		if (! $customer_id) {
			return array ();
		}
		$this->db->select('a.*,b.*');
		$this->db->from('customer_corporation as a');
		$this->db->join('corporation_detail as b','a.id = b.corporation_id','left outer');
		$this->db->where('a.customer_id',$customer_id);
		$query = $this->db->get();
		/*$query = $this->db->get_where ( 'customer_corporation', array (
				'customer_id' => $customer_id
		) );*/

		if ($row = $query->row_array ()) {
			return $row;
		}

		return array ();
	}

	function load_id($id){

	    if (! $id) {
	        return array ();
	    }

	    $this->db->select('cc.*,cd.Industrial_Info, cd.nature, cd.bus_licence_img, d.name as Industrial_Info_name, c.name as nature_name');
	    $this->db->from('customer_corporation as cc ');
	    $this->db->join('corporation_detail as cd','cc.id = cd.corporation_id','left');
	    $this->db->join('datadictionary as d','cd.Industrial_Info = d.id','left');
	    $this->db->join('datadictionary as c','cd.nature = c.id','left');
	    $this->db->where('cc.id',$id);
	    $query = $this->db->get();
       
	    if ($row = $query->row_array ()) {
	        return $row;
	    }

	    return array ();
	}

	/**
	 * 搜索企业
	 */
	public function search_shop( $search_shop='',$app_id=null ){
	    $this->db->select('a.*,b.region_name as province,c.region_name as city,d.region_name as district');
	    $this->db->from("customer_corporation a");
	    $this->db->join('region as b','a.province_id = b.region_id','left outer');
	    $this->db->join('region as c','a.city_id = c.region_id','left outer');
	    $this->db->join('region as d','a.district_id = d.region_id','left outer');
	    if( $search_shop) {        
	        $searchs = explode(" ",$search_shop);
	        foreach ($searchs as $search){
	           $this->db->or_like('a.corporation_name',$search,"both",false );
	        }
	    }
	    if($app_id)
	        $this->db->where('a.app_id',$app_id);
	    $query = $this->db->where('a.approval_status',2)->where('a.status',1)->get();
// 	    echo $this->db->last_query();
	    return $query->result_array();
	}



	// --------------------------------------------------------------------

	/**
	 * 更新数据
	 */
	public function save(){

	    $this->db->set('corporation_name',$this->corporation_name);
	    $this->db->set('corporation_area',$this->corporation_area);
	    $this->db->set('address',$this->address);
	    $this->db->set('postcode',$this->postcode);
	    $this->db->set('email',$this->email);
	    //$this->db->set('contact_name',$this->contact_name);
	    $this->db->set('contact_mobile',$this->contact_mobile);

	    $this->db->where('id',$this->id);
	    $res = $this->db->update('customer_corporation');
	    if($res){
	        return 1;
	    }else{
	        return 0;
	    }

	}

	function save_img($id){
	    if(!$id){
	        return array();
	    }
	    if(isset($this->img_url))
	        $this->db->set('img_url',$this->img_url);
	    if(isset($this->QR_code))
	        $this->db->set('QR_code',$this->QR_code);
	    $this->db->where('customer_id',$id);

	    $res = $this->db->update('customer_corporation');
	    if($res){
	        return 1;
	    }else{
	        return 0;
	    }
	}

	/**
	 * 企业性质
	 */
	function corporation_type(){

	    $this->db->where('type',2);

	    $query = $this->db->get('datadictionary');

	    if($res = $query->result_array()){
	        return $res;
	    }
	    return array();

	}

	/**
	 * 行业
	 */
	function cor_ind_info(){

	    if(isset($search_name))
	        $this->db->like('name',$search_name);

	    $this->db->where('type',1);

	    $query = $this->db->get('datadictionary');

	    if($res = $query->result_array()){
	        return $res;
	    }
	    return array();

	}
	
	/**
	 * 合伙人的商家
	 */
	function getagentcorporate($agentid){
	    
	    if (! $agentid) {
	        return array ();
	    }
	    $query = $this->db->get_where("customer_corporation",array(
	        "agent_id" => $agentid
	    ));
	    if($row=$query->result_array()){
	        return $row;
	    }
	    return array();
	}
	
	/**
	 * 根据店铺id查询图片
	 * @param $corp_id 店铺id
	 */
	public  function get_images($corp_id){
	    $this->db->select('id,corporation_id,image_name,type,title,number');
	    $query = $this->db->where('corporation_id',$corp_id)->get('corporation_image');
	    return $query->result_array();
	}
	
	/**
	 * 根据店铺id查询图片
	 * @param $corp_id 店铺id
	 */
	public  function get_images_temp($corp_id){
	    $query = $this->db->where('corporation_id',$corp_id)->get('corporation_image_verify');
	    return $query->result_array();
	}
	
	
	/**
	 * 添加公司介绍图片
	 */
	public function add_images($array){
	    $this->db->insert_batch('corporation_image_verify', $array);
	}
	
	/**
	 * 更新公司介绍图片
	 */
	public function update_images($array,$where){
	    $this->db->where('corporation_id',$this->corporation_id);
	    $this->db->where($where);
	    $this->db->update('corporation_image_verify', $array);
	    return $this->db->affected_rows();
	}
	
	/**
	 * 删除图片
	 */
	public function del_img($corp_id,$id,$type){
	    $this->db->where('id',$id);
	    $this->db->where('corporation_id',$corp_id);
	    $this->db->where('type',$type);
	    return $this->db->delete('corporation_image_verify');
	}
	
	// -------------------------------------------------------------------------------------------------------
	/**
	 * 根据企业id查询企业信息
	 * @param int $id 企业id
	 * @return multitype:|unknown
	 */
	public function load_corp_info($id){ 
	    if (! $id) {
	        return array ();
	    }
	    $query = $this->db->get_where("customer_corporation",array(
	        "id" => $id
	    ));
	    return $query->row_array();

	}
	
	// -------------------------------------------------------------------------------------------------------
	
	
	/**
	 * 根据用户id获取店铺信息
	 * @param int $customer_id
	 */
	public function load_corporation_info($customer_id){
	    $query = $this->db->get_where("customer_corporation",array(
	        "customer_id" => $customer_id
	    ));
	    return $query->row_array();
	}
	


}