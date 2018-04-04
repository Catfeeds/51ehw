<?php
/**
 * 搜索
 *
 *
 */
class Search extends Front_Controller {
    /**
     *
     */
    function __construct() {
        parent::__construct ();
    }

    public function index(){

    }

    public function get_list($keyword){        
        $app = $this->session->userdata('app_info');
        
        $this->load->model ( 'corporation_mdl' );
        $data['corp'] = $this->corporation_mdl->search_shop(urldecode($keyword),$app["id"]);
        
        $this->load->model('content_mdl');        
        $data['notice'] = $this->content_mdl->getList(0,50,$app['id']);

        $data['title'] = '企业搜索结果';
	    $data['keyword'] = urldecode($keyword);
	    $data['search_type'] = 3;

        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/list', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
   /**
	 * 根据条件搜索用户=企业的信息。
	 */
    public function Customer_Corp_Info()
    { 
        $name = $this->input->post('customer_name');
        $sift['where']['name'] = $name;
        $this->load->model('Corporation_mdl');
        $info = $this->Corporation_mdl->Customer_Corp_Info( $sift );
        
        $return['info'] = $info;
        
        echo json_encode( $return );
    }
}
?>