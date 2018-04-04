<?php
class Game extends Front_Controller {
	
	public function __construct() {
		parent::__construct ();
		// error_reporting(E_ALL);
		if (! $this->session->userdata ( 'user_in' )) {
			$this->session->set_flashdata ( 'ref_from_url', site_url('game/game/game_list') );
			redirect ( 'customer/login' );
			exit ();
		}
	}
	
	public function game_list(){
		
		$this->load->view('game/list_view');
		
	}
	
	public function egg(){
		
		$this->load->view('game/egg_game_view');
		
	}
	
	public function qhb(){
		
		$this->load->view('game/qhb_game_view');
		
	}
	
	public function qhb2(){
		
		$this->load->view('game/qhb2_game_view');
		
	}

	public function tiger(){
		$gamelist = array("1,1,2","1,1,3","1,2,1","1,2,2","1,2,3","1,3,1","1,3,2","1,3,3","2,1,1","2,1,2","2,1,4","2,2,1","2,2,3","2,3,1","2,3,2","2,3,3","3,1,1","3,1,2","3,1,3","3,2,1","3,2,2","3,2,3","3,3,1","3,3,2","3,3,3");
		$data["gamenum"] = $gamelist[rand(0,24)];
		$this->load->view('game/tiger/tigergame',$data);
		
	}

	
	public function egg_data(){

		$prize_arr = array(
				'0' => array('id'=>0,'prize'=>'MissKing面膜一盒及免费护理卷一张','v'=>3),
				'1' => array('id'=>1,'prize'=>'MissKing氨基酸洁面乳一瓶','v'=>5),
				'2' => array('id'=>2,'prize'=>'20元MissKing餐厅现金卷一张','v'=>10),
				'3' => array('id'=>3,'prize'=>'雪糕或小蛋糕一份','v'=>82),
		);
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		//print_r($arr);
		
		$rid = $this->getRand($arr); //根据概率获取奖项id
		$res['msg'] = ($rid==6)?0:1;
		$res['prize'] = $prize_arr[$rid-1]['prize']; //中奖项
		echo json_encode($res);exit;
	}

	//计算概率
	function getRand($proArr) {
		$result = '';
	
		//概率数组的总概率精度
		$proSum = array_sum($proArr);
	
		//概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset ($proArr);
	
		return $result;
	}
}