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
        $keyword = urldecode($keyword);
        //处理字符串
        $search = trim($keyword," ");
        $search  = str_replace("	","",$search);
        $search = preg_replace("/[\s]+/is"," ",$search);
        if(!$search){
            echo "<script>history.back(-1);</script>";exit;
        }
        
        $app = $this->session->userdata('app_info');
        
        $this->load->model ( 'corporation_mdl' );
        $data['corp'] = $this->corporation_mdl->search_shop($search,$app["id"]);
        
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
}
?>