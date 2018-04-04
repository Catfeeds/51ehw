<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Corporation extends Front_Controller {
	
	// ------------------------------------------------------------
	/**
	 */
	public function __construct() {
		parent::__construct ();
	}
	
	// ------------------------------------------------------------
	
	/**
	 */
	public function index() {
		// $this->load->view('customer/info');
		redirect ( site_url ( 'member/info' ) );
	}
	
	// ------------------------------------------------------------
	
	/**
	 */
	public function login($err_msg = 0) {
		// 判断是否微信浏览器
		if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
			// redirect('third_signin/wechat');
			
			header ( 'Location: ' . MAINURL . 'index.php/third_signin/wechat' );
		}
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$data ['title'] = '客户登录';
		if ($err_msg != 0) {
			switch ($err_msg) {
				default :
					$data ['err_msg'] = "用户名密码错误";
			}
		} else {
			$data ['err_msg'] = "";
		}
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/login', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 生成二维码
	 */
	public function generateBarcode($userid) {
		$data = site_url ( 'customer/registration/' . $userid );
		$size = '400x400';
		$logo = './logo.png'; // 中间那logo图
		                      
		// 生成二维码
		include dirname ( BASEPATH ) . "/phpqrcode/qrlib.php";
		$errorCorrectionLevel = "L";
		$matrixPointSize = "6";
		
		$filename = '/uploads/userinfo/' . $userid . '.png';
		$margin = 1;
		QRcode::png ( $data, dirname ( BASEPATH ) . $filename, $errorCorrectionLevel, $matrixPointSize, $margin );
		// $png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
		
		// $QR = imagecreatefrompng($png);
		
		$QR = imagecreatefromstring ( file_get_contents ( "." . $filename ) );
		
		if ($logo !== FALSE) {
			$logo = imagecreatefromstring ( file_get_contents ( $logo ) );
			
			$QR_width = imagesx ( $QR );
			$QR_height = imagesy ( $QR );
			
			$logo_width = imagesx ( $logo );
			$logo_height = imagesy ( $logo );
			
			$logo_qr_width = $QR_width / 6;
			$scale = $logo_width / $logo_qr_width;
			$logo_qr_height = $logo_height / $scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			
			imagecopyresampled ( $QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height );
		}
		
		// header('Content-type: image/png');
		imagepng ( $QR, 'uploads/userinfo/' . $userid . '.png' );
		
		imagedestroy ( $QR );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 我的消息
	 */
	public function mymessage() {
		$this->load->view ( 'customer/mymessage' );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 验证名字是否已存在 ajax
	 */
	function check_name() {
		$name = $this->input->get ( 'tbxRegisterNickname' );
		$this->load->model ( 'customer_mdl' );
		$msg = array (
				'Result' => true 
		);
		if ($name) {
			if ($this->customer_mdl->check_name ( $name )) {
				$msg = array (
						'Result' => false 
				);
			}
		}
		
		echo json_encode ( $msg );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 注册生成验证码
	 */
	function yzm_img() {
		$this->load->helper ( 'captcha' );
		code ();
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 检查注册验证码是否准确
	 */
	function _check_yzm() {
		session_start ();
		$Verifier = $this->input->post ( 'tbxVerifier' );
		if ($_SESSION ['verify'] == $Verifier) {
			//
		} else {
			// echo "ddd";
			$data ["error"] = "验证码错误！";
			$this->load->view ( 'customer/findPwd' );
			exit ();
		}
		return;
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 验证邮箱是否已存在 ajax
	 */
	function check_email() {
		$email = $this->input->get ( 'tbxRegisterEmail' );
		$this->load->model ( 'customer_mdl' );
		$msg = array (
				'Result' => true 
		);
		if ($email) {
			if ($this->customer_mdl->check_email ( $email )) {
				$msg = array (
						'Result' => false 
				);
			}
		}
		
		echo json_encode ( $msg );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 保存注册信息
	 */
	function save() {
		// $this->_check_yzm();
		if (isset ( $_COOKIE ['inviteid'] )) {
			$this->customer_mdl->parent_id = $_COOKIE ['inviteid'];
		}
		
		$name = $this->input->post ( 'tbxRegisterNickname' );
		$password = $this->input->post ( 'tbxRegisterPassword' );
		$mobile = $this->input->post ( 'contact_mobile' );
		
		$this->load->library ( 'validation' );
		$this->set_save_form_rules ();
		
		if (TRUE == $this->validation->run ()) {
			
			//新增企业数据
			$this->load->model ( 'corporation_mdl' );
			
			$data = array(
					'customer_id' => 0,
					'corporation_name' => $this->input->post ( 'corporation_name' ),
					'corporation_area' => $this->input->post ( 'corporation_area' ),
					'address' => $this->input->post ( 'address' ),
					'postcode' => $this->input->post ( 'postcode' ),
					'email' => $this->input->post ( 'email' ),
					'contact_name' => $this->input->post ( 'contact_name' ),
					'contact_mobile' => $this->input->post ( 'contact_mobile' )
			);
			$corporation_id = $this->corporation_mdl->create ($data);
			
			//新增会员数据
			$this->load->model ( 'customer_mdl' );
			$this->customer_mdl->name = $name;
			$this->customer_mdl->mobile = $mobile;
			$this->customer_mdl->password = $password;
			$this->customer_mdl->nick_name = $name;
			$this->customer_mdl->corporation_id = $corporation_id;
			$this->customer_mdl->privilege_id = 1;
			$this->customer_mdl->create ();
			$customer_id = $this->db->insert_id ();
			
			$customer = array (
					'user_name' => $name,
					'user_id' => $customer_id,
					'is_vip' => 0,
					'promo_name' => $name,
					'user_last_login' => '',
					'corporation_id' => $corporation_id,
					'privilege_id' => 1,
					'user_in' => TRUE 
			);
			
			// 生成二维码图片
			$this->generateBarcode ( $customer_id );
			
			if (isset($step) && $step == 1) {
				
				$this->adding_do ( $name );
			} else {
				
				$this->session->set_userdata ( $customer );
				
				$refUrl = $this->session->flashdata ( 'ref_from_url' );
				if ($refUrl) {
					redirect ( $refUrl );
				} else {
					redirect ( 'corporate/info' );
				}
			}
		} else {
			if (isset ( $inviteid )) {
				
				$this->load->view ( 'customer/adding' );
			} else {
				redirect ( 'customer/registration' );
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 注册验证规则
	 */
	function set_save_form_rules() {
		$rules ['tbxRegisterNickname'] = 'required|min_length[4]|max_length[20]|alpha_dash';
		$rules ['tbxRegisterPassword'] = 'required|min_length[6]|max_length[16]|alpha_dash';
		$rules ['contact_mobile'] = 'required||min_length[11]|max_length[11]';
		$this->validation->set_rules ( $rules );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 登出
	 */
	function logout() {
		$this->session->sess_destroy ();
		redirect ( 'home' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 登录
	 */
	function check_customer() {
		// $this->_check_yzm1();
		$name = $this->input->post ( 'tbxLoginNickname' );
		$password = $this->input->post ( 'tbxLoginPassword' );
		
		$this->load->model ( 'customer_mdl' );
		$this->customer_mdl->name = $name;
		$this->customer_mdl->password = $password;
		$_customer = $this->customer_mdl->check_customer ();
		if ($_customer) {
			$customer = array (
					'user_name' => $_customer ['name'],
					'user_id' => $_customer ['id'],
					'user_in' => TRUE,
					'is_vip' => $_customer ['is_vip'],
					'is_active' => $_customer ['is_active'],
					'user_last_login' => $_customer ['last_login_at'],
					'corporation_id' => $_customer ['corporation_id'],
					'privilege_id' => $_customer ['privilege_id'] 
			);
			$this->session->set_userdata ( $customer );
			
			$this->customer_mdl->update_last_login ( $_customer ['id'] );
			
			$this->session->set_userdata ( $customer );
			
			$this->load->model ( 'cart_mdl' );
			$this->cart_mdl->reinit ( $_customer ['id'] );
			
			$redir = $this->session->userdata ( 'redirect' );
			if ($redir !== NULL) {
				$this->session->unset_userdata ( 'redirect' );
				redirect ( $redir );
			}
			redirect ( 'member/info' );
		} else {
			redirect ( 'customer/login/1' );
		}
	}
	
	// ------------------------------------------------------------
	
	/**
	 *
	 * @param number $id        	
	 */
	public function registration($id = 0) {
		if ($id) {
			// 保存链接地址
			setcookie ( "inviteid", $id, time () + 10000, '/' );
		}
		$data ['title'] = '客户注册';
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/register', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 */
	public function info() {
		$this->load->model ( 'customer_mdl' );
		
		$data ['info'] = array (); // = $this->customer_mdl->load($this->session->get_userdata('user_id'));
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/info', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 客户列表
	 *
	 * @param number $level        	
	 * @param number $fid        	
	 */
	public function customerdata($level = 0, $fid = 0) {
		if ($level < 0 || $level > 5) {
			$this->showMessage ( "找不到所需页面！", site_url ( 'customer/customerdata' ), true, true );
		} else {
			if ($level > 0 && $fid == 0) {
				$this->showMessage ( "参数错误！", site_url ( 'customer/customerdata' ), true, true );
			} else {
				if ($level == 0) {
					$fid = $this->session->userdata ( 'user_id' );
				}
				
				$this->load->model ( 'customer_mdl' );
				$data ["begindate"] = $this->input->get_post ( "begindate" );
				$data ["enddate"] = $this->input->get_post ( "enddate" );
				$data ["username"] = $this->input->get_post ( "username" );
				$data ["phone"] = $this->input->get_post ( "phone" );
				$like = array ();
				$condition = array ();
				if ($data ["begindate"] && $data ["begindate"] != "") {
					$condition ["registry_at >="] = $data ["begindate"];
				}
				if ($data ["enddate"] && $data ["enddate"] != "") {
					$condition ["registry_at <="] = $data ["enddate"];
				}
				if ($data ["username"] && $data ["username"] != "") {
					$like ["name"] = $data ["username"];
				}
				if ($data ["phone"] && $data ["phone"] != "") {
					$like ["phone"] = $data ["phone"];
				}
				$data ["fid"] = $fid;
				$data ["level"] = $level;
				$data ["result"] = $this->customer_mdl->getChildList ( $level, $fid, $condition, $like, "M" );
				
				$total_price = 0;
				
				foreach ( $data ["result"] as $result ) {
					$total_price += $result ['total_price'];
				}
				$data ["total_price"] = $total_price;
				
				// 年显示
				
				$data ["result_y"] = $this->customer_mdl->getChildList ( $level, $fid, $condition, $like );
				
				$total_price_y = 0;
				
				foreach ( $data ["result_y"] as $result ) {
					$total_price_y += $result ['total_price'];
				}
				$data ["total_price_y"] = $total_price_y;
			}
		}
		$data ['title'] = "我的家族";
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/customer', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	/**
	 *
	 * @param number $level        	
	 * @param unknown $id        	
	 */
	public function customerDataDetail($level = 0, $id) {
		if ($id) {
			// 判斷用戶是否可以查詢
			if ($this->checkUser ( $level, $id )) {
				$this->load->model ( "order_mdl" );
				$data ["period"] = $this->input->get_post ( 'period' );
				$data ["status"] = $this->input->get_post ( 'status' );
				$data ["page"] = $this->input->get_post ( 'page' );
				$data ["pagesize"] = 5;
				$data ["id"] = $id;
				$data ["level"] = $level;
				if (! $data ["page"]) {
					$data ["page"] = 1;
				}
				
				// 查詢用戶數據
				$data ['user'] = $this->customer_mdl->load ( $id );
				$data ['user'] ['childcount'] = $this->customer_mdl->countChild ( $id );
				$data ['user'] ['salecount'] = $this->order_mdl->count_orders ( $id );
				
				// 查詢用戶消費數據
				$data ["saledata"] = $this->customer_mdl->getCustomerSaleData ( $id, array (), false );
				$data ["saledata_month"] = $this->customer_mdl->getCustomerSaleData ( $id, array (
						"place_at >=" => strtotime ( "-30 day" ) 
				), false );
				$data ["childdata"] = $this->customer_mdl->getCustomerSaleData ( $id, array (), true );
				$data ["childdata_month"] = $this->customer_mdl->getCustomerSaleData ( $id, array (
						"place_at >=" => strtotime ( "-30 day" ) 
				), true );
				
				// 单订信息
				$condition = array ();
				if ($data ["period"]) {
					$condition = array (
							"place_at>=",
							strtotime ( "-30 day" ) 
					);
				}
				if ($data ["status"]) {
					$condition = array (
							"status",
							$data ["status"] 
					);
				}
				
				// echo $data["page"];
				$data ["order"] = $this->order_mdl->get_customer_orders ( $id, "order_sn,place_at,b.product_id,c.name,quantity,b.price,a.status,a.id,a.total_product_price,c.goods_thumb", $condition, $data ["pagesize"], ($data ["page"] - 1) * $data ["pagesize"] );
				
				$pagecondition = "?period=" . $data ["period"] . "&status=" . $data ["status"];
				$this->load->library ( 'pagination' );
				$config ['base_url'] = site_url ( 'goods/vip/' );
				$config ['suffix'] = $pagecondition;
				$config ['total_rows'] = $this->order_mdl->count_orders ( $id, $condition );
				$config ['per_page'] = $data ["pagesize"];
				$config ['curr_page'] = $data ["page"];
				$config ['num_links'] = 10;
				$config ['full_tag_open'] = '';
				$config ['full_tag_close'] = '';
				$config ['num_tag_open'] = '';
				$config ['num_tag_close'] = '';
				$config ['first_link'] = FALSE;
				$config ['last_link'] = FALSE;
				$config ['next_link'] = '下一页';
				$config ['next_tag_css'] = 'class="next"';
				$config ['next_tag_open'] = '';
				$config ['next_tag_close'] = '';
				$config ['prev_link'] = '上一页';
				$config ['prev_tag_css'] = 'class="prev"';
				$config ['prev_tag_open'] = '';
				$config ['prev_tag_close'] = '';
				// $config['cur_tag_css'] = 'class="current"';
				$config ['cur_tag_open'] = '<a href="javascript:" class="ui-paging-current">';
				$config ['cur_tag_close'] = '</a>';
				$this->pagination->initialize ( $config );
				$data ['pagination'] = $this->pagination->create_links ();
				$data ['head_set'] = 3;
				$this->load->view ( 'head', $data );
				$this->load->view ( '_header', $data );
				$this->load->view ( 'customer/datadetails', $data );
				$this->load->view ( '_footer', $data );
				$this->load->view ( 'foot', $data );
			} else {
				$this->showMessage ( "参数错误！", site_url ( 'customer/customerdata' ), true, true );
			}
		} else {
			$this->showMessage ( "参数错误！", site_url ( 'customer/customerdata' ), true, true );
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 *
	 * @param unknown $level        	
	 * @param unknown $id        	
	 * @return boolean
	 */
	public function checkUser($level, $id) {
		return true;
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 *
	 * @param string $msg        	
	 */
	public function forgot($msg = "") {
		$data ["error"] = $msg;
		$this->load->view ( 'customer/findPwd', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 */
	public function getPW() {
		$this->_check_yzm ();
		$this->load->model ( 'customer_mdl' );
		$username = $this->input->post ( "username" );
		$email = $this->input->post ( "email" );
		$data ["error"] = "";
		
		if ($username && $email) {
			$email = trim ( $email );
			$password = rand ( 100000, 999999 );
			$condition = array (
					"name" => $username,
					"email" => $email,
					"is_active" => "0" 
			);
			$user = $this->customer_mdl->get_by_condition ( $condition );
			if ($user) {
				$c = $this->customer_mdl->update_pwd ( $user ["id"], $password );
				if ($c > 0) {
					$this->load->library ( 'email' );
					
					$this->email->from ( '2190311733@qq.com', 'Administrator' );
					$this->email->to ( $user ["email"] );
					
					$this->email->subject ( '重置密码邮件（请勿回复此邮件）' );
					// $this->email->header("Content-type:text/html; charset=utf-8");
					$this->email->message ( '尊敬的' . $this->session->userdata ( 'app_info' )['app_name'] . '客户：<br/> ' . $username . '，您好！<br/> 您的密码已被重置，您的新密码是：' . $password . '<br/> 温馨提示：<br/> 1、如果您想修改您的安全邮箱，请登录账号管理里面的【个人资料】进行修改。<br/> 2、本邮件为系统自动发出，请勿回复。<br/> =============================================================== <br/> ' . $this->session->userdata ( 'app_info' )['app_name'] . '<br/> 敬启' );
					
					try {
						$this->email->send ();
					} catch ( Exception $e ) {
						echo $e;
					}
					
					$data ["error"] = "密码已重置成功,请查收EMAIL!";
					$data ['head_set'] = 3;
					$data ['foot_set'] = 1;
					$this->load->view ( 'head', $data );
					$this->load->view ( '_header', $data );
					$this->load->view ( 'customer/findPwd', $data );
					$this->load->view ( '_footer', $data );
					$this->load->view ( 'foot', $data );
				}
			} else {
				$data ["error"] = "会员名或电子邮件错误！";
				$data ['head_set'] = 3;
				$data ['foot_set'] = 1;
				$this->load->view ( 'head', $data );
				$this->load->view ( '_header', $data );
				$this->load->view ( 'customer/findPwd', $data );
				$this->load->view ( '_footer', $data );
				$this->load->view ( 'foot', $data );
			}
		} else {
			$data ["error"] = "数据缺失错误！";
			$data ['head_set'] = 3;
			$data ['foot_set'] = 1;
			$this->load->view ( 'head', $data );
			$this->load->view ( '_header', $data );
			$this->load->view ( 'customer/findPwd', $data );
			$this->load->view ( '_footer', $data );
			$this->load->view ( 'foot', $data );
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 */
	public function address() {
		$data = array ();
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/address' );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 */
	public function complaints() {
		$data = array ();
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/complaints' );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	// public function myfav()
	// {
	// $this->load->view('customer/myfav');
	// }
	
	// --------------------------------------------------------------------
	
	/**
	 * 邀请朋友
	 */
	public function invite() {
		$data ['title'] = "我的二维码";
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/invite' );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 安全设置
	 */
	public function safety_setting() {
		$data ['title'] = "安全设置";
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/safety_setting' );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 提成
	 */
	public function rebate() {
		$userid = $this->session->userdata ( 'user_id' );
		if ($userid) {
			$this->load->model ( "order_mdl" );
			$this->load->model ( "balance_mdl" );
			
			$totallist = $this->order_mdl->get_cutomer_rebate_list ( array (
					"agentid" => $userid 
			) );
			$hadpay = $this->balance_mdl->getBalanceByCustomer ( $userid );
			$waitingpay = $this->balance_mdl->getBalanceByCustomerForNoPay ( $userid );
			
			$data ["totalcount"] = 0;
			if ($totallist && count ( $totallist ) > 0) {
				$data ["totalcount"] = $totallist [0] ["rebate_1"];
			}
			
			if ($hadpay != 0) {
				$data ["hadpay"] = $hadpay ["balancetotal"] == null ? 0 : $hadpay ["balancetotal"];
			} else {
				$data ["hadpay"] = 0;
			}
			
			if ($waitingpay != 0) {
				$data ["waitingpay"] = $waitingpay ["balancetotal"] == null ? 0 : $waitingpay ["balancetotal"];
			} else {
				$data ["waitingpay"] = 0;
			}
			
			$data ["nopay"] = $data ["totalcount"] - $data ["hadpay"] - $data ["waitingpay"];
			// print_r($data);
			$data ['head_set'] = 3;
			$data ['foot_set'] = 1;
			$this->load->view ( 'head', $data );
			$this->load->view ( '_header', $data );
			$this->load->view ( 'customer/rebate', $data );
			$this->load->view ( '_footer', $data );
			$this->load->view ( 'foot', $data );
		} else {
			redirect ( 'customer/login' );
		}
	}
	
	// ------------------------------------------------------------
	
	/**
	 */
	public function rebate_do() {
		$data ['customerid'] = $this->session->userdata ( 'user_id' );
		if ($data ['customerid']) {
			$data ['balancetotal'] = urlencode ( $this->input->post ( 'total' ) );
			$data ['bankname'] = urlencode ( $this->input->post ( 'bankname' ) );
			$data ['banksubname'] = urlencode ( $this->input->post ( 'banksubname' ) );
			$data ['bankaccount'] = urlencode ( $this->input->post ( 'bankaccount' ) );
			$data ['realname'] = urlencode ( $this->input->post ( 'realname' ) );
			
			// $data["create_time"] = time();
			$this->load->model ( "balance_mdl" );
			$this->load->model ( "order_mdl" );
			
			$totallist = $this->order_mdl->getCutomerRebateList ( array (
					"agentid" => $data ['customerid'] 
			) );
			$hadpay = $this->balance_mdl->getBalanceByCustomer ( $data ['customerid'] );
			
			$waitingpay = $this->balance_mdl->getBalanceByCustomerForNoPay ( $data ['customerid'] );
			
			$totalcount = 0;
			if ($totallist && count ( $totallist ) > 0) {
				$totalcount = $totallist [0] ["rebate_1"];
			}
			
			if ($hadpay != 0) {
				$hadpay = $hadpay ["balancetotal"] == null ? 0 : $hadpay ["balancetotal"];
			} else {
				$hadpay = 0;
			}
			
			if ($waitingpay != 0) {
				$waitingpay = $waitingpay ["balancetotal"] == null ? 0 : $waitingpay ["balancetotal"];
			} else {
				$waitingpay = 0;
			}
			
			if ($totalcount - $hadpay - $waitingpay > 0 && $totalcount - $hadpay - $waitingpay > $data ['balancetotal']) {
				$id = $this->balance_mdl->create ( $data );
				if ($id) {
					$data ["totalcount"] = $totalcount;
					$data ["hadpay"] = $hadpay;
					$data ["nopay"] = $totalcount - $hadpay - $waitingpay;
					$data ["message"] = "结算申请成功";
					$data ["result"] = true;
					$data ["waitingpay"] = $waitingpay;
				} else {
					$data ["message"] = "结算申请失败";
					$data ["result"] = false;
					$data ["totalcount"] = $totalcount;
					$data ["hadpay"] = $hadpay;
					$data ["nopay"] = $totalcount - $hadpay - $waitingpay;
					$data ["waitingpay"] = $waitingpay;
				}
			} else {
				$data ["message"] = "不需要结算或结算金额太多！";
				$data ["result"] = false;
				$data ["totalcount"] = $totalcount;
				$data ["hadpay"] = $hadpay;
				$data ["nopay"] = $totalcount - $hadpay - $waitingpay;
				$data ["waitingpay"] = $waitingpay;
			}
		}
		
		$this->load->view ( 'customer/rebate', $data );
	}
	
	// ------------------------------------------------------------
	
	/**
	 * 财富页
	 */
	public function fortune() {
		$account_id = $this->session->userdata ( 'user_id' );
		$data ['customerid'] = $account_id;
		/*
		 * if ($account_id) {
		 * $this->load->model ( "order_mdl" );
		 * $this->load->model ( "balance_mdl" );
		 *
		 * $data ['totalsum'] = $this->order_mdl->sum_cutomer_rebate_list ( $account_id );
		 * }
		 */
		
		$this->load->model ( "customer_mdl", "customer" );
		$data ['customer'] = $this->customer->load ( $account_id );
		
		$data ['title'] = '我的财富';
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/rebate', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// ------------------------------------------------------------
	
	/**
	 */
	public function faq() {
		$data = array ();
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/faq' );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */