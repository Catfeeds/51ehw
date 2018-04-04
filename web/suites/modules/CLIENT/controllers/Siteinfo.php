<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Siteinfo extends Front_Controller {
	
	/**
	 */
	public function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------
	
	
	public function index($file_name){
	    $data['file_name'] = $file_name;
	    $data['title'] = $this->session->userdata('app_info')['app_name'];
	    $this->load->view('head',$data);
	    $this->load->view('_header');

	    if(file_exists(FCPATH.UPLOAD_PATH."uploads/action/".$file_name.".php")){
	    	$this->load->view('action',$data);

	    }else{
	    	$this->load->view('siteinfo',$data);
	    }
	    $this->load->view('_footer');
	    $this->load->view('foot');
	    
	}

	   public function app_action($file_name){
            $data['file_name'] = $file_name;
            $data['title'] = $this->session->userdata('app_info')['app_name'];
           // $this->load->view('head',$data);
            //$this->load->view('_header');
            if(file_exists(FCPATH.UPLOAD_PATH."uploads/action/".$file_name.".php")){
               $this->load->view('action',$data);


            }else{
                $this->load->view('siteinfo',$data);
			}
            //$this->load->view('_footer');
            //$this->load->view('foot');

        }

// 	public function contact(){
	     
// 	    $data['title'] = '联系我们';
	     
// 	    $this->load->view('head',$data);
// 	    $this->load->view('_header',$data);
// 	    $this->load->view('foot/footer_detail_contact',$data);
// 	    $this->load->view('_footer',$data);
// 	    $this->load->view('foot',$data);
	     
// 	}
	
// 	public function enter(){
	
// 	    $data['title'] = '商家入驻';
	    
// 	    $this->load->view('head',$data);
// 	    $this->load->view('_header',$data);
// 	    $this->load->view('foot/footer_detail_enter',$data);
// 	    $this->load->view('_footer',$data);
// 	    $this->load->view('foot',$data);
	
// 	}
	
// 	public function flink(){
	
// 	    $data['title'] = '友情链接';
	
// 	    $this->load->view('head',$data);
// 	    $this->load->view('_header',$data);
// 	    $this->load->view('foot/footer_detail_flink',$data);
// 	    $this->load->view('_footer',$data);
// 	    $this->load->view('foot',$data);
	
// 	}
	
// 	public function market(){
	
// 	    $data['title'] = '友情链接';
	
// 	    $this->load->view('head',$data);
// 	    $this->load->view('_header',$data);
// 	    $this->load->view('foot/footer_detail_market',$data);
// 	    $this->load->view('_footer',$data);
// 	    $this->load->view('foot',$data);
	
// 	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */