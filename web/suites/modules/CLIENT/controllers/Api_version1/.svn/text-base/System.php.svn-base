<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends Api_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('region_mdl');
	    $this->load->model('content_mdl');
	    $this->load->model("app_info_mdl");
	}


	public function index()
	{
		echo 'System API';
	}

	//获取地区
	public function getAllRegion()
	{
		//获取参数
		$prams = $this->p;
		$return = $this->return;
		
		print_r(json_encode($return));
	}
	//根据父级获取地区
	public function getRegionById()
	{
		//获取参数
		$prams = $this->p;
		$return = $this->return;

		//检验参数
// 		$this->_check_prams($prams,array('orderid'));

		$region_id = isset($prams['region_id'])?$prams['region_id']:1;
		$return['data'] = array(
				'listdate'=>array()
		);

		$return['data']['listdate'] = $this->region_mdl->children_of((int)$region_id);
		
		print_r(json_encode($return));
	}

	//获取详细地区
	public function getRegionWithAddress()
	{
		//获取参数
		$prams = $this->p;
		$return = $this->return;

		//检验参数
		$this->_check_prams($prams,array('city_id','district_id'));

		$province_id = isset($prams['province_id'])?$prams['province_id']:1;
		$return['data'] = array(
				'province'=>array(),
				'city'=>array(),
				'district'=>array()
		);

		$return['data']['province'] = $this->region_mdl->children_of((int)$province_id);
		$return['data']['city'] = $this->region_mdl->children_of((int)$prams['city_id']);
		$return['data']['district'] = $this->region_mdl->children_of((int)$prams['district_id']);
		
		print_r(json_encode($return));
	}

    public function getVersion()
	{
		$prams = $this->p;
		$return = $this->return;
		
		// 检验参数
		$type = isset($prams["mactype"])?$prams["mactype"]:"android";
        $select = isset($prams["select"])?$prams["select"]:"";
        $version_num = isset($prams["version_num"])?$prams["version_num"]:"";
		
        if ($type == 'android') {
            $_type = 1;
        } else {
            $_type = 2;
        }
        
        // 获取版本数据
	    $this->load->model("app_version_mdl");
	    $info = $this->app_version_mdl->get_by_version_num($select, $version_num, $_type);

	    $return['data']['version'] = $info["version_num"];
	    $return['data']['rewrite'] = $info["rewrite"];//1:需要重装,0不需要重装
	    $return['data']['showupdate'] = $info["showupdate"];//0不提示更新1提示更新
		$return['data']['url'] = "http://a.app.qq.com/o/simple.jsp?pkgname=com.nineleaf.yhw";
		print_r(json_encode($return));
	}
	public function getallVersion()
	{
	    $prams = $this->p;
	    $return = $this->return;
	    
	    $this->load->model("app_version_mdl");
	    $info = $this->app_version_mdl->getallversionmessage();
	    print_r(json_encode($return));
	}
	// 读取服务器链接、接口版本数据
	public function versionControl()
	{
		$prams = $this->p;
		$return = $this->return;
		
	    //检验参数
	    $this->_check_prams($prams,array('version','type'));
	    
	    $select = '' ;
	    $version_num = $prams['version'];
	    $type = $prams['type'] == "android" ? 1 : 2 ;
	    $this->load->model("app_version_mdl");
	    
	    //接口文件使用当前版本的接口
	    $info = $this->app_version_mdl->get_by_version_num($select ,$version_num ,$type);
	    //获取最新版本信息，修改返回版本号，以便ios判断APP是否需要更新
	    $list = $this->app_version_mdl->get_by_version_num('' ,'' ,$type);
	    $info['version_num'] =  $list['version_num'];
	    //系统图片文件地址
	    $info['system_img_url'] = base_url().'suites/themes/C/default_wechat/';
	    $return['data'] = $info;
	    print_r(json_encode($return));
	}

	//获取帮助
	public function getHelp(){

	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;

	    //检验参数
	    //$this->_check_prams($prams,array('id'));
	    $app = $this->session->userdata('app_info');

	    $return['data'] = array('title'=>array());

	    $return['data']['title'] = $this->content_mdl->getApphelp($app['id'],4);
	    foreach($return['data']['title'] as $key => $r){
	       $return['data']['title'][$key]['url'] =  base_url('uploads/siteinfo/'.$r['id'].'.html');
	    }
	    print_r(json_encode($return));
	}

	//获取帮助页面
	/*public function getHelpbyid(){

	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;

	    //检验参数
	    $this->_check_prams($prams,array('id'));
	    $data['id'] = $prams['id'];

	    $return['data'] = base_url('uploads/siteinfo/'.$data['id'].'.html');
	    print_r(json_encode($return));
	    //include();
	}*/

	//获取站点信息
	public function getAppInfo(){

	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;

	    //检验参数
	    //$this->_check_prams($prams,array('id'));

	    $app_info = $this->app_info_mdl->getAll("",-1,"","",true);
	    
	   
	    if(count($app_info)>0){
	        
	        //C端分站点暂时屏蔽
	        $web = array(
	            'http://www.test51ehw.com/',
	            'http://localhost/51ehw/web/'
	        );
	        foreach ($app_info as $key => $v){
	            if( !in_array(base_url(), $web)){
	                if($v['app_name'] !='全国站' || $v['id'] != 0){
	                    unset($app_info[$key]);
	                }
	            }
	        }
	        
	       
	        $more_info = array();
	        foreach ($app_info as $key => $v){
	            $customer["app"][$key]["id"] = $v["id"];
	            $customer["app"][$key]["app_name"] = $v["app_name"];
	            $customer["app"][$key]["letter"] = isset($v["letter"])?$v["letter"]:"";
	            $customer["app"][$key]["site_url"] = isset($v["site_url"])?$v["site_url"]:"";

	            if($v["parent_id"]==0){
	               $customer["app"][$key]["city_name"] = $v["region_name"];
	            }else{
	               $customer["app"][$key]["city_name"] = $v["region_name"]."市";
	            }
                if (! isset($v["region_name"]) || $v["region_name"] == NULL) {
                    $customer["app"][$key]["city_name"] = "";
                }
                $more_info= $customer["app"][$key];//只要一个就好
               
	        }
	        $more_info['app_name'] = '全国站2';
	        array_push($customer["app"], $more_info);
	    }

	    $return['data'] = $customer;

	    print_r(json_encode($return));
	}

	//热门站点
	public function gethotAppInfo(){

	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;

	    //检验参数
	    //$this->_check_prams($prams,array('id'));

	    $app_info = $this->app_info_mdl->getAll("",-1,"","",true,false);
	    if(count($app_info)>0){
	        foreach ($app_info as $key => $v){
				if($key<12)//最多只取１２	条数据
				{
    	            $customer["app"][$key]["id"] = $v["id"];
    	            $customer["app"][$key]["app_name"] = $v["app_name"];
    	            $customer["app"][$key]["letter"] = $v["letter"];
    	            $customer["app"][$key]["site_url"] = $v["site_url"];
    	            if($v["parent_id"]==0){
    	                $customer["app"][$key]["city_name"] = $v["region_name"];
    	            }else{
    	                $customer["app"][$key]["city_name"] = $v["region_name"]."市";
    	            }
				}
	        }
	    }
	    if($customer){
	        $return['data'] = $customer;
	    }else{
	        $return['responseMessage'] = array('messageType'=>'error','errorType'=>'2','errorMessage'=>'当前数据库无热门站点');
	    }

	    print_r(json_encode($return));

	}

	//获取首页二级导航
	public function gethelpMenu(){
	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    $img_url = array("home_elite.png","home_help.png","home_ad.png","home_joint_work.png");
// 	    $img_url = array("home_recommended.png","home_help.png","home_ad.png","home_joint_work.png");
// 	    $img_url = array("home_recommended.png","home_help.png","home_joined.png","home_joint_work.png");
// 	    $font = array("项目介绍","常见问题","广告任务","商务合作");
	    $font = array("精英头条","常见问题","广告任务","商务合作");
	    $url = array("elite_Line_nav/app","question_nav/app","join_nav/app","cooperate_nav/app");
	    $H5img_url = array("cooperate_head.png","question.png","join.png","cooperate.png");
	    $_menu = array($img_url,$font,$url,$H5img_url);
	    for($i=0;$i<4;$i++){
	            $return['data'][$i]['img_url']="images/icons/".$_menu[0][$i];
	            $return['data'][$i]['font']=$_menu[1][$i];
	            $return['data'][$i]['url']=site_url("navigation/".$_menu[2][$i]);
	            $return['data'][$i]['H5img_url']="images/".$_menu[3][$i];
	            if($_menu[1][$i] == '广告任务'){
	                $return['data'][$i]['class_name']= 'com.diabin.xcross.app.DelegateActivity';
	            }
	    }
	    print_r(json_encode($return));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */