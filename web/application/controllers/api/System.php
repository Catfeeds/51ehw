<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends Api_Controller {

	public function __construct()
	{
		parent::__construct();

	}


	// 读取服务器链接、接口版本数据
	public function versionControl()
	{
		$prams = $this->p;
		$return = $this->return;
		
	    //检验参数
	    $this->_check_prams($prams,array('version','type'));
	    
	    $select = '' ;
	    $version_num = $prams['version'] ;
	    $type = $prams['type'] == "android" ? 1 : 2 ;
	    $this->load->model("app_version_mdl");
	    $info = $this->app_version_mdl->get_by_version_num($select ,$version_num ,$type);

	    $return['data'] = $info;
	    print_r(json_encode($return));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */