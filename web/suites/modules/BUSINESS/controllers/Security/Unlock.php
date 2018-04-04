<?php 
/**
 * 安全
 *
 *
 */
class Unlock extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	// --------------------------------------------------------------------
	
	/**
	 * 开锁
	 */
	public function gesture(){
		
		$data = array();
		
		$data['title'] = '支付解锁';
		$data['head_set'] = 3;
		$data['action'] = 'unlock';
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('security/unlock_security_view', $data);
		$this->load->view ( 'foot', $data );
		
	}
	
	// --------------------------------------------------------------------
	/**
	 * 设置锁
	 */
	public function set_gesture(){
		
		$data = array();
		
		$data['title'] = '解锁设置';
		$data['head_set'] = 3;
		$data['action'] = 'set_lock';
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('security/set_security_view', $data);
		$this->load->view ( 'foot', $data );
		
	}
	
}
?>