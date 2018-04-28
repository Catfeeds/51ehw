<?php
/**
 *
 *
 *
 */
class Customer_mdl extends CI_Model {
	var $name;
	var $email;
	var $password;
	var $dob;
	var $is_sendemail;
	var $password_auto;
	var $parent_id; 
	var $mobile;
	var $phone = null;
	var $birthday = null;
	var $sex = null;
	var $registry_by = 'web';
	var $nick_name;
	var $img_avatar;
	var $wechat_account;
	var $qq_account;
	var $weibo_account;
	var $alipay_account;
	var $safety_password;
	var $corporation_id = 0;
	var $privilege_id = 0;
	var $app_id;
	var $wechat_nickname;
	var $wechat_avatar;
	var $avatar;
    var $real_name;
    var $job;
    var $corporation_status;
    var $time;
    var $openid;
    var $db1;
    var $address;
    var $bank;
    var $card_number;
    var $identity;
    var $branch;
    var $is_valid;
    var $bankcard;
    var $bankmobile;
    var $authenticationat;
    var $idcard;
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 添加新客户。
	 */
	function create() {
	    
        $this->db->set('name', $this->name);
        $this->db->set('email', $this->email);
        if($this->password){
        $this->db->set('password', md5($this->password));
        }
        $this->db->set('registry_at', $this->time);
        $this->db->set('updated_at', $this->time);
        $this->db->set('last_login_at', $this->time);
        $this->parent_id?$this->db->set('parent_id', $this->parent_id):null;
        $this->db->set('mobile', $this->mobile);
        $this->db->set('phone', $this->phone);
        $this->db->set('birthday', $this->birthday);
        $this->db->set('sex', $this->sex);
        $this->db->set('registry_by', $this->registry_by);
        $this->avatar ? $this->db->set('avatar', $this->avatar) : null;
        $this->nick_name ? $this->db->set('nick_name', $this->nick_name) : null;
        $this->wechat_avatar ? $this->db->set('wechat_avatar', $this->wechat_avatar) : null;
        $this->wechat_nickname ? $this->db->set('wechat_nickname', $this->wechat_nickname) : null;
        $this->db->set('wechat_account', $this->wechat_account);
        $this->db->set('qq_account', $this->qq_account);
        $this->db->set('weibo_account', $this->weibo_account);
        $this->db->set('alipay_account', $this->alipay_account);
        $this->db->set('openid', $this->openid);
        $this->db->set('app_id', $this->app_id);
        
        if($this->real_name)
        {
            $this->db->set('real_name',$this->real_name);
        }
        $this->db->insert('customer');
        return $this->db->insert_id();
        
    }
    
    /**
     * 同步添加用户。
     */
    function synchro_create($id) {
	    $this->db1->set('id',$id);
	  
        $this->db1->set('name', $this->name);
        $this->db1->set('email', $this->email);
        if($this->password){
        $this->db1->set('password', md5($this->password));
        }
        $this->db1->set('registry_at', $this->time);
        $this->db1->set('updated_at', $this->time);
        $this->db1->set('last_login_at', $this->time);
        if($this->parent_id != 'C端'){//只添加AB端,C端不添加
            $this->db1->set('parent_id', $this->parent_id === NULL ? 0 : $this->parent_id);
            $this->db1->set('app_id', $this->app_id);
        }
        $this->db1->set('mobile', $this->mobile);
        $this->db1->set('phone', $this->phone);
        $this->db1->set('birthday', $this->birthday);
        $this->db1->set('sex', $this->sex);
        $this->db1->set('registry_by', $this->registry_by);
        $this->avatar ? $this->db1->set('avatar', $this->avatar) : null;
        $this->nick_name ? $this->db1->set('nick_name', $this->nick_name) : null;
        $this->wechat_avatar ? $this->db1->set('wechat_avatar', $this->wechat_avatar) : null;
        $this->wechat_nickname ? $this->db1->set('wechat_nickname', $this->wechat_nickname) : null;
        $this->db1->set('wechat_account', $this->wechat_account);
        $this->db1->set('qq_account', $this->qq_account);
        $this->db1->set('weibo_account', $this->weibo_account);
        $this->db1->set('alipay_account', $this->alipay_account);
        $this->db1->set('openid', $this->openid);
        if($this->real_name)
        {
            $this->db1->set('real_name',$this->real_name);
        }
        
        return $this->db1->insert('customer');
    }
    
//     /**
//      * 同步删除用户。
//      */
//     function synchro_delete($id,$module){
//         $db = $this->load->database($module,true);
//         $db->where("id",$id);
//         $db->delete("customer");
//         if($db->affected_rows()){
//             return true;
//         }else{
//             error_log ( $this->db->last_query () );
//             return false;
//         }
//     }
    
    
	// --------------------------------------------------------------------

	/**
	 * 查询该用户名是否存在。
	 */
	function check_name($name) {
		$query = $this->db->get_where ( 'customer', array (
				'name' => $name
		) );
		if ($row = $query->row_array ()) {
			return true;
		}
		return false;
	}
	//待与check_mobile整合
	function check_moblie($phone) {
		$query = $this->db->get_where ( 'customer', array (
				'mobile' => $phone
		) );
		if ($row = $query->row_array ()) {
			return true;
		}
		return false;
	}

	// --------------------------------------------------------------------
   
	/**
	 * 查询该邮箱是否存在
	 */
	function check_email($email) {
        $query = $this->db->get_where('customer', array(
            'email' => $email
        ));
        if ($row = $query->row_array()) {
            return true;
        }
        return false;
    }

	// --------------------------------------------------------------------

	/**
	 * 查询该手机是否存在。
	 */      
	function check_mobile($mobile) {
	    $query = $this->db->get_where ( 'customer', array (
	        'mobile' => $mobile
	    ) );
        return $query->row_array ();
	}

	// --------------------------------------------------------------------
    
	/**
	 * 查询该用户，返回用户信息
	 */
	function check_customer()
	{
        if($this->name){
            $this->db->where("name",$this->name);
            $this->db->or_where("mobile",$this->name);
            return $this->db->get('customer')->row_array();
        }

        return array();
    }

	// --------------------------------------------------------------------
	
    /**
     * 查询该用户，返回用户信息
     */
    function check_wechat_customer()
    {
        $result = $this->db->get_where('customer', array('wechat_account' => $this->wechat_account))->row_array();
        return $result;
    }
    
    // --------------------------------------------------------------------

	/**
	 * 查询该用户，返回用户信息
	 */
	function check_customer_with_mobile() {
		$result = $this->db->get_where ( 'customer', array (
				'name' => $this->name,
				'password' => md5 ( $this->password ),
		        'mobile' => $this->mobile
		) )->result_array ();
		if ($result && count ( $result ) > 0) {
			return $result [0];
		}

		return array ();
	}

	// --------------------------------------------------------------------

	/**
	 * load by id
	 */
	function load($id) {
	    if (! $id) {
	        return array ();
	    }

	    $query = $this->db->select('customer.*,pay_account.M_credit,pay_account.cash,pay_account.credit,pay_account.credit_start_time,pay_account.credit_end_time')
        ->join('pay_relation','customer.id=pay_relation.customer_id','left')
	    ->join('pay_account','pay_relation.id_pay = pay_account.id','left')
	    ->get_where ( 'customer', array ('customer.id' => $id) );

	    if ($row = $query->row_array ()) {
	        return $row;
	    }
	    return array();
	}

	// --------------------------------------------------------------------

	/**
	 * load by id
	 */
	function load_by_name($name) {
		if (! $name) {
			return array ();
		}

		$query = $this->db->get_where ( 'customer', array (
				'name' => $name
		) );

		if ($row = $query->row_array ()) {
			return $row;
		}

		return array ();
	}

	function load_by_mobile($mobile) {
	    if (! $mobile) {
	        return array ();
	    }

	    $query = $this->db->get_where ( 'customer', array (
	        'mobile' => $mobile
	    ) );

	    if ($row = $query->row_array ()) {
	        return $row;
	    }

	    return array ();
	}

	// --------------------------------------------------------------------

	/**
	 * load by id
	 */
	function load_by_wechat($unionid = 0) {
		if (!$unionid) {
			return array ();
		}

		$query = $this->db->get_where ( 'customer', array (
				'wechat_account' => $unionid
		) );

		if ($row = $query->row_array ()) {
			error_log ( $this->db->last_query () );
			return $row;
		}
		error_log ( $this->db->last_query () );

		return array ();
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * load by where
	 * @param unknown $where
	 */
	function load_by_where($where){
		if (! $where) {
			return array ();
		}
		$query = $this->db->get_where ( 'customer', $where);

		if ($row = $query->row_array ()) {
		    error_log ( $this->db->last_query () );
		    return $row;
		}
		error_log ( $this->db->last_query () );
		return array ();
	}
	
	// --------------------------------------------------------------------
	
	
	/**
	 * 更新客户信息。
	 * 同步3个库
	 * @param int $id 用户id
	 */
	function update($id) {
		$datetime = date ( 'Y-m-d H:i:s' );

		if ($this->name)
		    $this->db1->set ( 'name', $this->name );

		if ($this->email)
			$this->db1->set ( 'email', $this->email );
		
		if (isset($this->real_name))
		    $this->db1->set ( 'real_name', $this->real_name );
		
		if ($this->mobile)
			$this->db1->set ( 'mobile', $this->mobile );

		if ($this->phone)
			$this->db1->set ( 'phone', $this->phone );

		if (isset ( $this->sex ))
			$this->db1->set ( 'sex', $this->sex );
		
		if (isset ( $this->job ))
		$this->db1->set ( 'job', $this->job );

		if (isset ( $this->nick_name ))
			$this->db1->set ( 'nick_name', $this->nick_name );

		if (isset ( $this->img_avatar ))
			$this->db1->set ( 'img_avatar', $this->img_avatar );

		if (isset ( $this->wechat_account ))
			$this->db1->set ( 'wechat_account', $this->wechat_account );
		
        if (isset($this->qq_account))
            $this->db1->set('qq_account', $this->qq_account);
        
        if (isset($this->weibo_account))
            $this->db1->set('weibo_account', $this->weibo_account);
        
        if (isset($this->alipay_account))
            $this->db1->set('alipay_account', $this->alipay_account);
        
        if ($this->birthday)
            $this->db1->set('birthday', $this->birthday);

		if(isset($this->corporation_id)&&isset($this->corporation_status)){
		    $this->db1->set('corporation_id',$this->corporation_id);
		    $this->db1->set('corporation_status',$this->corporation_status);
		}

		if(isset($this->pay_passwd))
		    $this->db1->set('pay_passwd',$this->pay_passwd);

		if(isset($this->wechat_nickname))
		    $this->db1->set('wechat_nickname',$this->wechat_nickname);
		
		if(isset($this->wechat_avatar))
		    $this->db1->set('wechat_avatar',$this->wechat_avatar);
		
		if(isset($this->openid))
		    $this->db1->set('openid',$this->openid);
		    
	    if(isset($this->is_valid))
	        $this->db1->set('is_valid',$this->is_valid);
	    
        if(isset($this->idcard)){
            $this->db1->set('idcard',$this->idcard);
        }
        
        if(isset($this->bankcard)){
            $this->db1->set('bankcard',$this->bankcard);
        }
        
        if(isset($this->bankmobile)){
            $this->db1->set('bankmobile',$this->bankmobile);
        }
        
        if(isset($this->authenticationat)){
            $this->db1->set('authenticationat',$this->authenticationat);
        }
		
		$this->db1->set ( 'updated_at', $datetime );

		$this->db1->where ( 'id', $id );
		
		$this->db1->update ( 'customer' );
		error_log($this->db1->last_query());
		return $this->db1->affected_rows();
	}
	
	//----------------------------------------------------


	/**
	 * 更新客户信息。
	 * 同步3个库
	 * @param int $id 用户id
	 */
	function AbolishUser($id,$unionid) {
        $datetime = date ( 'Y-m-d H:i:s' );
	    $this->db1->set ( 'name', $this->name );
		$this->db1->set ( 'email', $this->email );
	    $this->db1->set ( 'real_name', $this->real_name );
		$this->db1->set ( 'mobile', $this->mobile );
		$this->db1->set ( 'phone', $this->phone );
		$this->db1->set ( 'sex', $this->sex );
		$this->db1->set ( 'job', $this->job );
		$this->db1->set ( 'nick_name', $this->nick_name );
		$this->db1->set ( 'img_avatar', $this->img_avatar );
		$this->db1->set ( 'wechat_account', $this->wechat_account );
        $this->db1->set('qq_account', $this->qq_account);
        $this->db1->set('weibo_account', $this->weibo_account);
        $this->db1->set('alipay_account', $this->alipay_account);
        $this->db1->set('birthday', $this->birthday);
	    $this->db1->set('wechat_nickname',$this->wechat_nickname);
	    $this->db1->set('wechat_avatar',$this->wechat_avatar);
	    $this->db1->set('openid',$this->openid);
		$this->db1->set ( 'updated_at', $datetime );
		$this->db1->where ( 'id !=', $id );
		$this->db1->where("wechat_account",$unionid);
		$this->db1->update ( 'customer' );
		return $this->db1->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * 查询密码是否正确。
	 * @param string $password 密码
	 * @param int $id 用户id
	 */
	function check_pwd($password,$id) {
		$query = $this->db->get_where ( 'customer', array (
				'password' => md5 ( $password ),
		        'id'=>$id
		) );
		return $row = $query->row_array ();
	}

	// --------------------------------------------------------------------

	/**
	 * 更改用户密码。
	 * @param int $id 用户id
	 * @param string $pwd 用户密码
	 */
	function update_pwd($id, $pwd) {
		$this->db->set ( 'password', md5 ( $pwd ) );
		$this->db->where ( 'id', $id );
		return $this->db->update ( 'customer' );
// 		return $this->db->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * 更新最后登录时间
	 */
	function update_last_login($customer_id) {
		$datetime = date ( 'Y-m-d H:i:s' );
		$this->db->set ( 'last_login_at', $datetime );
		$this->db->where ( 'id', $customer_id );
		return $this->db->update ( 'customer' );
	}

	// 查询注册用户数量
	public function get_counts() {
		// $this->db->from('customer');
		return $this->db->count_all_results ( 'customer' );
	}
	public function getChildList($level = 0, $fid = 0, $condition = array(), $like = array(), $order_type = 'Y') {
		if ($condition) {
			$this->db->where ( $condition );
		}
		if ($like) {

			$this->db->like ( $like );
		}
		if ($order_type === 'Y') {
			$place_at = date ( 'Y' ) . '-01-01';
		} else if ($order_type === 'M') {
			$place_at = date ( 'Y-m' ) . '-01';
		}

		$this->db->select ( "a.*,b.total_price,b.rebate" . ($level + 1) . " as rebate" . ", b.count_order as count_order, c.id as childid" );
		$this->db->from ( "customer as a" );
		$join_order_table = "(select sum(total_product_price) as total_price,sum(rebate_1) as rebate1,sum(rebate_2)  as rebate2,sum(rebate_3) as rebate3,sum(rebate_4) as rebate4,sum(rebate_5) as rebate5, count(total_product_price) as count_order,customer_id from 9thleaf_order as a ,9thleaf_order_rebate as b where a.id = b.orderid and status= 9 and a.place_at > '" . $place_at . "' group by  customer_id) as b";
		$this->db->join ( $join_order_table, "a.id = b.customer_id", "left" );
		$this->db->where ( "a.parent_id", $fid );
		$this->db->join ( "(select id,parent_id  from 9thleaf_customer) as c", "a.id=c.parent_id", "left" );
		$this->db->order_by ( "total_price", "desc" );
		$query = $this->db->get ();

		if ($row = $query->result_array ()) {
			return $row;
		}

		return array ();
	}

	// 查詢用戶的下級數量
	public function countChild($userid) {
		$this->db->from ( "customer" );
		$this->db->where ( "parent_id", $userid );
		return $this->db->count_all_results ();
	}
	public function getChileArray($id) {
		$this->db->from ( "customer" );
		$this->db->where ( "parent_id", $id );
		$childs = $this->db->get ()->result_array ();
		$cstr = array ();
		foreach ( $childs as $c ) {
			array_push ( $cstr, $c ["id"] );
		}
		return $cstr;
	}

	// 查詢用戶消費總額
	public function getCustomerSaleData($userid, $condition, $childflag) {
		if ($userid) {
			$child = array ();
			if ($childflag) {

				$child = $this->getChileArray ( $userid );
			}

			$this->db->select ( "sum(quantity) as qty,sum(b.price) as price" );
			$this->db->from ( "order as a" );
			$this->db->join ( "order_item as b", "a.id = b.order_id" );
			$this->db->join ( "product as c", "b.product_id = c.id" );
			if ($childflag && $child != NULL) {
				$this->db->where_in ( "a.customer_id", $child );
			} else {
				$this->db->where ( "a.customer_id", $userid );
			}

			if ($condition) {
				$this->db->where ( $condition );
			}
			$query = $this->db->get (); // ->result_array();
			                            // echo $condition;
			                            // echo $this->db->last_query();
			                            // exit;

			if ($row = $query->result_array ()) {
				return $row;
			}

			return array ();
		}
	}
	public function get_by_condition($where = array(), $select = '') {
		if (! empty ( $select ))
			$this->db->select ( $select );
		$this->db->where ( $where );
		$this->db->from ( "customer" );

		$details = $this->db->get ()->row_array ();

		return $details;
	}

	// ---------------------------------------------------------------------------

	/**
	 * 更新信用
	 *
	 * @param unknown $userid
	 * @param unknown $total
	 */
	public function update_Credit($userid, $total) {


	    $this->db->select("id_pay");
	    $this->db->from('pay_relation');
	    $this->db->where("customer_id", $userid);
	    $query = $this->db->get();
	    $id = $query->row_array();

		//if ($total > 0)
		$this->db->set ( 'M_credit', "`M_credit`-" . $total, false );
		$this->db->where ( 'id', $id['id_pay'] );
		$this->db->where ( 'M_credit  >=', $total );

		$this->db->update ( 'pay_account' );

		$res = $this->db->affected_rows();

		return $res;
	}

	// ------------------------------------------------------------

	/**
	 * 更新信用
	 *
	 * @param unknown $userid
	 * @param unknown $total
	 */
	public function charge_credit($userid, $total) {
		if ($total > 0)
			$this->db->set ( 'credit', "`credit` + " . $total, false );
		$this->db->where ( 'id', $userid );

		return $this->db->update ( 'customer' );
	}

	// ------------------------------------------------------------

	/**
	 * 通过微信ID搜索客户
	 *
	 * @param unknown $openid
	 */
	public function find_by_wechatopenid($openid) {
		// TODO:不知为何不能使用wechat_account查询，有待排查问题！
		$query = $this->db->get_where ( 'customer', array (
				'name' => 'wechat:' . $openid
		) );
		// error_log ( $this->db->last_query () );
		$row = $query->row_array ();
		return $row;
	}
	
	// ------------------------------------------------------------

	/**
	 * 查找是否有上级
	 *
	 * @param unknown $user_id
	 */
	public function get_parent($user_id) {
		$query = $this->db->get_where ( 'customer', array (
				'id' => $user_id
		) );
		// error_log ( $this->db->last_query () );
		$row = $query->row_array ();
		return $row ['parent_id'];
	}

	/**
	 * 更新我爸！
	 *
	 * @param unknown $user_id
	 * @param unknown $parent_id
	 */
	public function update_parent($user_id, $parent_id) {
		$this->db->set ( "parent_id", $parent_id );
		$this->db->where ( "id", $user_id );
		$this->db->update ( "customer" );
	}

	/**
	 * 激活我自己
	 */
	public function active_account($customer_id) {
		$this->db->set ( "is_active", 1 );
		$this->db->where ( "id", $customer_id );
		$this->db->update ( "customer" );
	}

	/**
	 * 客户管理-客户列表 -铭
	 *
	 * @param $corporation_id --店铺-公司ID
	 * @param $corporation_id --店铺-公司ID
	 * @param $num --
	 *        	每页显示条数
	 * @param $customer_name --
	 *        	客户名称 搜索。
	 */
	public function get_list($corporation_id, $offset, $num, $customer_name) {
		$this->db->select ( "sum(O.total_price) as price,C.id,customer_id,nick_name,name,registry_at,last_login_at" );
		$this->db->from ( "order as O" );
		$this->db->join ( 'customer C', 'O.customer_id = C.id', 'left' );
		$this->db->where ( "O.corporation_id",$corporation_id );
		$this->db->where_in ( "O.status",array(7,9,14) );
		$this->db->like ( 'C.nick_name', $customer_name );
		$this->db->group_by ( 'O.customer_id' );
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		$result = $query->result_array ();
	    return $result;
	}

	/**
	 * 统计总条数
	 *
	 * @param $corporation_id --店铺-公司ID
	 * @param $customer_name --客户名称-搜索。
	 */
	public function count_customer($corporation_id, $customer_name) {
// 		$this->db->select ( "C.id" );
// 		$this->db->from ( "order as O" );
// 		$this->db->join ( 'customer C', 'O.customer_id = C.id', 'left' );
// 		$this->db->where ( "O.corporation_id = 1" );
// 		$this->db->like ( 'C.nick_name', $customer_name );
// 		$this->db->group_by ( 'O.customer_id' );
        $query = $this->db->query("select count(*) as num from (SELECT C.id FROM (`9thleaf_order` as O) LEFT JOIN `9thleaf_customer` C ON `O`.`customer_id` = `C`.`id` WHERE O.status in (7,9,14) and `O`.`corporation_id` = $corporation_id AND `C`.`nick_name` LIKE '%$customer_name%' GROUP BY `O`.`customer_id`) as A");

        $result = $query->row_array();
		return $result['num'];
	}

	/**
	 * 客户的消费记录
	 *
	 * @param $customer_id --客户ID
	 * @param $offset --偏移量
	 * @param $num --每页显示条数
	 * @param $product_name --消费商品名称搜索
	 */
	public function customer_consume_list($customer_id, $offset, $num, $product_name,$corporation_id) {
		$this->db->select ( 'OI.id, P.name, OI.quantity, (OI.quantity * OI.price) as price ,O.place_at' );
		$this->db->from ( 'product P, order_item OI, order O' );
		$this->db->where ( 'O.customer_id =' . $customer_id . ' and O.id = OI.order_id and OI.product_id = P.id' );
		$this->db->where_in ( "O.status",array(7,9,14) );
		$this->db->where("O.corporation_id",$corporation_id);
		$this->db->like ( 'P.name', $product_name );
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		return $query->result_array ();
	}

	/**
	 * 统计客户的消费记录
	 *
	 * @param $customer_id --客户ID
	 * @param $product_name --消费商品名称搜索
	 */
	public function count_consume_list($customer_id, $product_name,$corporation_id) {
		$this->db->select ( 'OI.id' );
		$this->db->from ( 'product P, order_item OI, order O' );
		$this->db->where ( 'O.customer_id =' . $customer_id . ' and O.status in (7,9,14) and O.id = OI.order_id and OI.product_id = P.id' );
		$this->db->where("O.corporation_id",$corporation_id);
		$this->db->like ( 'P.name', $product_name );
		
		return $this->db->count_all_results();
	}

	/**
	 * 查询某个客户||用户的M卷
	 * @param $customer_id --客户||用户 ID
	 */
    public function M_money( $customer_id ){
        $this->db->select('M_credit')->from('pay_relation PR, pay_account PA')->where('PR.customer_id ='.$customer_id.' and PR.id_pay = PA.id');
        $query = $this->db->get();
        return $query->row_array();
    }

	/**
	 * 查询未入企业号的用户
	 */
	function get_cor_list($phone){

	    $this->db->select('id,name,nick_name,mobile,phone,is_valid');
	    $this->db->where('corporation_id = 0');
	    $this->db->where('is_valid = 1');
	    $this->db->where('mobile',$phone);
	    $this->db->or_where('phone',$phone);
	    $query = $this->db->get('customer');

	    return $query->result_array();

	}


	/**
	 * 查询属于我公司的用户
	 */
	function get_my_cus($cor_id,$count='',$offset=''){
	    if(!$cor_id){
	        return array();
	    }

	     $this->db->limit ( ( int ) $count, ( int ) $offset );
	    $this->db->select(' c.id,c.name,c.nick_name,c.mobile,c.is_valid,c.privilege_id,corporation_status,corporation_remark ');
	    $this->db->from('customer as c');
	    //$this->db->join('role as r','c.privilege_id=r.id','left outer');
	    $this->db->where('corporation_id',$cor_id);
	    $this->db->where('id != '.$this->cus_id);

	    $query = $this->db->get();

	    if($res = $query->result_array()){
	        return $res;
	    }
	    return array();

	}
	function get_my_cuscount($cor_id){
	    if(!$cor_id){
	        return array();
	    }

	        $this->db->select(' c.id,c.name,c.nick_name,c.mobile,c.is_valid,c.privilege_id,corporation_status,corporation_remark ');
	        $this->db->from('customer as c');
	        $this->db->where('corporation_id',$cor_id);
	        $this->db->where('id != '.$this->cus_id);

	        $query = $this->db->get();

	        if($res = $query->result_array()){
	            return count($res);
	        }
	        return array();

	}

	/**
	 * 修改我的企业用户
	 */
	function cor_user_save($id=''){

	    if(isset($this->privilege_id))
	        $this->db->set('privilege_id',$this->privilege_id);
	    if(isset($this->corporation_status))
	        $this->db->set('corporation_status',$this->corporation_status);
	    if(isset($this->corporation_remark))
	        $this->db->set('corporation_remark',$this->corporation_remark);

	    $this->db->where('id',$id);

	    return $res = $this->db->update('customer');
	}


	/**
	 * 删除我管理的用户
	 */
	function del_user($id){

	    $this->db->set('corporation_id',0);
	    $this->db->set('corporation_status',0);
	    $this->db->set('privilege_id',0);
	    $this->db->set('corporation_remark',null);

	    $this->db->where('id',$id);

	    $res = $this->db->update('customer');

	    return $res;

	}

	//------------------------------------------------------------------------

	/**
	 * 删除用户（整合用户时采用）
	 * @param unknown $id
	 */
	function delete($id){

	    $this->db->where('id',$id);

	    $res = $this->db->delete('customer');

	    return $res;
	}

	//------------------------------------------------------------------------

    /**
     *
     * @param unknown $id
     * @param unknown $mobile
     */
	function bind_mobile($id, $mobile){


	    $this->db->set('mobile',$mobile);
	    $this->db->set('name',$mobile);
	    $this->db->set('password',md5($mobile));

	    $this->db->where('id',$id);

	    $res = $this->db->update('customer');

	    return $res;
	}

	/**
	 * 忘记密码
	 */
	public function forget_password($name){

	    $this->db->set('password',$this->password);
	    $this->db->where('name',$name);
	    $query = $this->db->update('customer');
	    return $query;

	}

    /**
     * 查询该企业所属的用户ID
     */
	public function customer_corp( $corp_id ){
	    if (! $corp_id) {
	        return array ();
	    }

	    $query = $this->db->get_where ( 'customer', array (
	        'corporation_id' => $corp_id
	    ) );

	    if ($row = $query->row_array ()) {
	        return $row;
	    }

	    return array ();
	}
	
	/**
	 * 根据查询用户id信息
	 */
	public function get_customer_info(){
	    $query = $this->db->where('id',$this->session->userdata('user_id'))->get('customer');
	    return $query->row_array();
	}
	


	//-------------------------------------------------------
	
	/**
	 * 绑定银行卡（C端使用）
	 * @param int $customer_id 用户id
	 */
	public function add_card($customer_id){
	    $this->db->set("bank",$this->bank);
	    $this->db->set("address",$this->address);
	    $this->db->set("card_number",$this->card_number);
	    $this->db->set("identity",$this->identity);
	    $this->db->set("name",$this->real_name);
	    $this->db->set("customer_id",$customer_id);
	    $this->db->set("status",1);
	    $this->db->set("created_at",date("Y-m-d H:i:s"));
	    $this->db->set("branch",$this->branch);
	    $this->db->insert("customer_bank");
	    return $this->db->insert_id();
	}
	
	//-------------------------------------------------------
	
	/**
	 * 更新银行卡（C端使用）
	 * @param int $customer_id 用户id
	 */
	public function save_card($customer_id){
	    $this->db->set("bank",$this->bank);
	    $this->db->set("address",$this->address);
	    $this->db->set("card_number",$this->card_number);
	    $this->db->set("identity",$this->identity);
	    $this->db->set("name",$this->real_name);
	    $this->db->set("status",1);
	    $this->db->set("created_at",date("Y-m-d H:i:s"));
	    $this->db->set("branch",$this->branch);
	    $this->db->where("customer_id",$customer_id);
	    $this->db->update("customer_bank");
	    return $this->db->affected_rows();

	}
	
	//-------------------------------------------------------
	
	/**
	 * 根据用户id查询银行卡信息（C端使用）
	 * @param int $customer_id 用户id
	 */
	public function load_card($customer_id){
	    $query = $this->db->get_where("customer_bank",array("customer_id"=>$customer_id));
	    return $query->row_array();
	}
	
	//---------------------------------------------------------
	
	/**
	 * 检查黑名单
	 */
    public function check_blacklist($mobile){
        $query = $this->db->get_where("blacklist",array("mobile"=>$mobile));
        return $query->num_rows();
    }
    
    /**
    * @author JF
    * 2018年3月14日
    * 根据身份证号查询用户
    * @param string $idcard 身份证号
    */
    function CheckIdCard($idcard){
        $this->db->from("customer");
        $this->db->where("idcard",$idcard);
        $query = $this->db->get();
        return $query->row_array();
    }

}