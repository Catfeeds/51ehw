<?php
class Rotate_game extends Front_Controller {



	public function __construct() {
		parent::__construct ();
		// error_reporting(E_ALL);
		if (! $this->session->userdata ( 'user_in' )) {
			$this->session->set_flashdata ( 'ref_from_url', current_url() );
			redirect ( 'customer/login' );
			exit ();
		}
	}
	
	
	public function index(){
		$data['title'] = "转盘游戏";
		$this->load->view('game/rotate/game_start_view', $data);
		//echo $data['title'];
	}
	
	public function result($money){

		$data['title'] = "转盘游戏公布结果";
		$data['money'] = $money;
		$this->load->view('game/rotate/game_result_view', $data);
		//echo $data['title'];
	}
}
?>