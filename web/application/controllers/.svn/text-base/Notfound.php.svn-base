<?php
/**
 *  找不到内容
 *
 *
 */
class Notfound extends Front_Controller {
	public function __construct() {
		parent::__construct ();
	}
	public function index() {
        $data['head_set'] = 3;
		$this->load->view ( 'head' , $data);
		$this->load->view ( '_header', $data );
		$this->load->view ( 'common/notfound_view' );
		$this->load->view ( '_footer' );
		$this->load->view ( 'foot' );
	}
}
?>