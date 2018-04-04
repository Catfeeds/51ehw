<?php
/**
 *
 *
 */
class Corporation_detail_mdl extends CI_Model {
	var $name;
	var $email;
	var $password;
	var $dob;
	var $is_sendemail;
	var $password_auto;
	var $parent_id;
	var $mobile = null;
	var $phone = null;
	var $birthday = null;
	var $sex = null;
	var $registry_by = 'web';
	var $nick_name;
	var $img_avatar;
	var $wechat_account;
	var $qq_account;
	var $weibo_account;
	var $safety_password;
	var $corporation_id = 0;
	var $privilege_id = 0;
	var $company_establish;
	var $nature;
	var $Industrial_Info;
    var $bus_licence_img;
    var $regist_date;
     
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	
	/**
	 * 根据参数添加。
	 * @date:2017年12月8日 下午5:07:18
	 * @author: fxm
	 * @param: $data array();
	 * @return:
	 */
	public function create_corporation_detail( $data = array() )
	{
	    if( !empty( $data )  && is_array( $data ) )
	    {
	        return $this->db->insert('corporation_detail',$data);
	    }
	
	    return false;
	}
	/**
	 * 添加新铺店详请
	 */
	function create() {
        $this->db->set('corporation_id', $this->corporation_id);
        $this->db->set('Industrial_Info', $this->Industrial_Info);
        $this->db->set('nature', $this->nature);
        $this->db->set('legal_person', $this->legal_person);
        $this->db->set('idcard', $this->idcard);
        $this->db->set('company_registration', $this->company_registration);
        $this->db->set('bus_licence_img', $this->bus_licence_img);
        $this->db->set('idcard_img', $this->idcard_img);
        $this->db->set('proxy_img', $this->proxy_img);
        $this->db->set('regist_date', date('Y-m-d H:i:s'));
        
        $res = $this->db->insert('corporation_detail');
        
        error_log($this->db->last_query());
        
        return $res;
    }

    
	function update() {
        if (isset($this->Industrial_Info))
            $this->db->set('Industrial_Info', $this->Industrial_Info);
        if (isset($this->nature))
            $this->db->set('nature', $this->nature);
        if (isset($this->legal_person))
            $this->db->set('legal_person', $this->legal_person);
        if (isset($this->idcard))
            $this->db->set('idcard', $this->idcard);
        if (isset($this->company_registration))
            $this->db->set('company_registration', $this->company_registration);
        if (isset($this->bus_licence_img))
            $this->db->set('bus_licence_img', $this->bus_licence_img);
        if (isset($this->idcard_img))
            $this->db->set('idcard_img', $this->idcard_img);
        if (isset($this->proxy_img))
            $this->db->set('proxy_img', $this->proxy_img);
        if (isset($this->industry_qua))
            $this->db->set('industry_qua', $this->industry_qua);
        if (isset($this->entry_requirements))
            $this->db->set('entry_requirements', $this->entry_requirements);
        if (isset($this->organization_code_image))
            $this->db->set('organization_code_image', $this->organization_code_image);
        if (isset($this->tax_images))
            $this->db->set('tax_images', $this->tax_images);
        if (isset($this->company_size))
            $this->db->set('company_size', $this->company_size);
        if (isset($this->company_wechat))
            $this->db->set('company_wechat', $this->company_wechat);
        if (isset($this->company_web))
            $this->db->set('company_web', $this->company_web);
        if (isset($this->Registered_Capital))
            $this->db->set('Registered_Capital', $this->Registered_Capital == "" ? 0 : $this->Registered_Capital);
        if (isset($this->company_establish))
            $this->db->set('company_establish', $this->company_establish == "" ? 0 : $this->company_establish);
        if (isset($this->regist_date))
            $this->db->set('regist_date', $this->regist_date); 
        
        $this->db->where('corporation_id', $this->corporation_id);
        $res = $this->db->update('corporation_detail');
        
        error_log($this->db->last_query());
        
        return $res;
    }

	// --------------------------------------------------------------------

	function load($corporation_id){
        if (! $corporation_id) {
            return array();
        }
        $this->db->select('a.*,b.name as ind,c.name as nat');
        $this->db->from('corporation_detail as a');
        $this->db->join('datadictionary as b', 'a.Industrial_Info = b.id', 'left outer');
        $this->db->join('datadictionary as c', 'a.nature = c.id', 'left outer');
        $this->db->where('corporation_id', $corporation_id);
        $query = $this->db->get();
        
        if ($row = $query->row_array()) {
            return $row;
        }
        
        return array();
    }

    // add_corporation_detail($corporation_id,$Industrial_Info);
    // 新增店铺详情
    public function add_corporation_detail($corporation_id,$Industrial_Info)
    {
        if($corporation_id && $Industrial_Info){

            // 查询是否存在店铺详情
            $this->db->where('corporation_id', $corporation_id);
            $info = $this->db->get('corporation_detail')->row_array();
            if($info){
                $this->db->where('corporation_id', $corporation_id);
                $this->db->set('Industrial_Info', $Industrial_Info);
                $this->db->update('corporation_detail');
                return $this->db->affected_rows();
            }else{
                $regist_date = date('Y-m-d');
                $this->db->set('corporation_id', $corporation_id);
                $this->db->set('regist_date', $regist_date);
                $this->db->set('Industrial_Info', $Industrial_Info);
                $this->db->insert('corporation_detail');
                // echo $this->db->last_query();
                return $this->db->affected_rows();
            }

        }
    }

    // 更新店铺详情
    public function update_corporation_detail( $data = array() , $corporation_id = 0 )
    {
        
        if( is_array( $data ) && $corporation_id )
        {
            $this->db->where('corporation_id', $corporation_id );
            $this->db->set($data);
            $this->db->update('corporation_detail');
            return $this->db->affected_rows();
        }
        
    }

	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------
	
	

	// --------------------------------------------------------------------
	
	

	// --------------------------------------------------------------------


}