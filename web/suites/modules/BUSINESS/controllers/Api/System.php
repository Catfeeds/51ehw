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
	    $info = $this->app_version_mdl->get_by_version_num($select, '2.5.6', $_type);
       
	    $return['data']['version'] = '2.5.7';
	    $return['data']['rewrite'] = $info["rewrite"];//1:需要重装,0不需要重装
	    $return['data']['forceupdate'] = $info["forceupdate"];//1:需要重装,0不需要重装
	    $return['data']['showupdate'] = $info["showupdate"];//0不提示更新1提示更新
		$return['data']['url'] = "http://a.app.qq.com/o/simple.jsp?pkgname=com.nineleaf.yhw";
		print_r(json_encode($return));
	}
	
	
	
	public function update_version()
	{
	    $prams = $this->p;
	    $return = $this->return;
	    
	    //商会APP处理
	    $tag = json_decode($this->input->get_post('t', 0), true);
	    $label_sn = isset($tag["label_sn"])?$tag["label_sn"]:0;
	    $label_id = 0;
	    $this->load->model("app_version_mdl");
	    if($label_sn){
	        $label_info = $this->app_version_mdl->getIDBylabel_sn($label_sn);
	        if($label_info){
	            $label_id = $label_info['id'];
	            $this->session->set_userdata("label_sn",$label_sn);
	            $this->session->set_userdata("label_id",$label_id);
	        }
	    }
	   
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
	    $info = $this->app_version_mdl->get_by_version_num('', '', $_type,$label_id);
	    $return['data']['version'] = $info["version_num"];
	    $_info = $this->app_version_mdl->get_by_version_num($select, $version_num, $_type,$label_id);
	    $return['data']['rewrite'] = $_info["rewrite"];//1:需要重装,0不需要重装
	    $return['data']['forceupdate'] = $_info["forceupdate"];//1:需要重装,0不需要重装
	    $return['data']['showupdate'] = $_info["showupdate"];//0不提示更新1提示更新
	    if(!$label_sn){
	        $return['data']['url'] = "http://a.app.qq.com/o/simple.jsp?pkgname=com.nineleaf.yhw";
	    }else{
	        $return['data']['url'] = !empty($_info['app_download_url']) ? $_info['app_download_url']:'';
	    }
	    
	    print_r(json_encode($return));
	}
	
    // 读取服务器链接、接口版本数据
	public function versionControl()
	{
		$prams = $this->p;
		$return = $this->return;
		
	    //检验参数
	    $this->_check_prams($prams,array('version','type'));
	    $this->load->model("app_version_mdl");
	    $tag = json_decode($this->input->get_post('t', 0), true);
	    $label_sn = isset($tag["label_sn"])?$tag["label_sn"]:0;
	    
	    $label_id = 0;
	    if($label_sn){
	        $label_info = $this->app_version_mdl->getIDBylabel_sn($label_sn);
	        if(!$label_info){
	            $return['responseMessage'] = array(
	                'messageType' => 'error',
	                'errorType' => '8',
	                'errorMessage' => ''
	            );
	            $return['data'] = $label_info;
	            print_r(json_encode($return));
	            exit;
	        }
	        $label_id = $label_info['id'];
	        $this->session->set_userdata("label_sn",$label_sn);
	        $this->session->set_userdata("label_id",$label_id);
	    }
	    $select = '' ;
	    $version_num = $prams['version'];
	    $type = $prams['type'] == "android" ? 1 : 2 ;
	    
	    //接口文件使用当前版本的接口
	    $info = $this->app_version_mdl->get_by_version_num($select ,$version_num ,$type,$label_id);
	   
	    //获取最新版本信息，修改返回版本号，以便ios判断APP是否需要更新
	    $list = $this->app_version_mdl->get_by_version_num('' ,'' ,$type,$label_id);
	   
	    $info['version_num'] =  $list['version_num'];
	    //系统图片文件地址
	    $info['system_img_url'] = base_url().'suites/themes/B/default_wechat/';
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
	        }
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

	    $img_url = array("home_recommended.png","home_help.png","home_joined.png","home_joint_work.png");
	    $font = array("项目介绍","常见问题","如何加入","商务合作");
	    $url = array("project_Introduction_nav/app","question_nav/app","join_nav/app","cooperate_nav/app");
//	    $H5img_url = array("cooperate_head.png","question.png","join.png","cooperate.png");
// 	    $H5img_url = array("home_xin.jpg","home_nian.jpg","home_kuai.jpg","home_le.jpg");
	    $H5img_url = array("home_recommended.png","home_help.png","home_joined.png","home_joint_work.png");
	    $_menu = array($img_url,$font,$url,$H5img_url);
	    for($i=0;$i<4;$i++){
          
	        $return['data'][$i]['img_url']="images/icons/".$_menu[0][$i];
	        //新年快乐 by system_image_url
	        //$return['data'][$i]['H5img_url']="images/".$_menu[3][$i];
	        //正常情况
	        $return['data'][$i]['H5img_url']="images/icons/".$_menu[3][$i];
	        
	        $return['data'][$i]['font']=$_menu[1][$i];
	        $return['data'][$i]['url']=site_url("navigation/".$_menu[2][$i]);
	        
	    }
	  
	    print_r(json_encode($return));
	}
	
	
	/**
	 * 白名单
	 */
	public function get_WhiteList(){
	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    
	    $label_id = $this->session->userdata("label_id");
	    
	    $return['data'] = array(
	        'www.sxfic.com',
	        'www.micorcmsapi.onndu.com',
	        'www.m.qqxqs.com',
	        'www.2017.qqxqs.com',
	        'www.mp.weixin.qq.com',
	        'www.embazqsh.com',
	        'www.embazqsh.com',
	        'www.test51ehw.9-leaf.com',
	        'www.51ehw.com',
	    );
	    
	    if($label_id){
	        $this->load->model('App_label_mdl');
	        $Nav_info  = $this->App_label_mdl->Load_Nav($label_id);
	        
	        if($Nav_info){
	            foreach ($Nav_info as $k =>$v){
	                $tempu =parse_url($v['link']);
	                if(!empty($tempu['host'])){
	                    $url  = $tempu['host'];
	                    if(!in_array($url, $return['data'])){
	                        $return['data'][] = $url;
	                    }
	                }
	            }
	        }
	    }
	    
	    print_r(json_encode($return));
	}
	
	
	
	//APP首页改版接口
	
	public function getHomeTheme(){
	    //获取参数
	    $prams = $this->p;
	    $return = $this->return;
	    
	    //检验参数
	    //1首页导航 2每日推荐 3精品专区 4精品专区2-1 5精品专区2-2 6精品专区2-3 7易货热卖 8推荐店铺 9猜你喜欢
	    
	    $this->load->model("App_homeplate_mdl",'App');
	    $list = $this->App->getList();
	    $data_info = array(
	        "Home_nav"=>array(),
	        "Daily_recommend"=>array(),
	        "Boutique"=>array(),
	        "Boutique2"=>array(),
	        "Hot_sale"=>array(),
	        "Shop_recommend"=>array(),
	        "Guess_like"=>array(),
	    );
	    
	
	    //组装精品专区2里面的层级数据(数据库限制最多6个区域)
	    $seat_1 = array();//精品专区2第一块
	    $seat_2 = array();//精品专区2第二块
	    $seat_3 = array();//精品专区2第三块
	    $seat_4 = array();//精品专区2第四块
	    $seat_5 = array();//精品专区2第五块
	    $seat_6 = array();//精品专区2第六块
	    
	    $num = 1;
	    //先组装整个首页需要的数据
	    foreach ($list as $key =>$val){
// 	        if($val['level_id'] != 4){//没有模板的 不返回模板相关字段
// 	            unset($list[$key]['temp_id']);
// 	            unset($list[$key]['seat']);
// 	            unset($list[$key]['position']);
// 	        }
	        if($val['level_name'] != '推荐店铺'){//不是推荐店铺楼层 不返回corporation_id字段
	            unset($list[$key]['corporation_id']);
	        }
	        
	        if($val['level_name'] == '中间导航'){
	            if(!empty($val['img_path']) && !empty($val['link_path'])){
	                array_push($data_info['Home_nav'], $list[$key]);
	            }
	           
	        }
	        if($val['level_name'] == '每日推荐'){
	            array_push($data_info['Daily_recommend'], $list[$key]);
	        }
	        if($val['level_name'] == '精品专区'){
	            if($num<=3){
	                //暂时只限制输出3个
	                array_push($data_info['Boutique'], $list[$key]);
	                $num ++;
	            }
	        }
	        //----------------精品专区2------------------------
	        if($val['level_name'] == '区域一'){
	            array_push($seat_1, $list[$key]);
	        }
	        if($val['level_name'] == '区域二'){
	            array_push($seat_2, $list[$key]);
	        }
	        if($val['level_name'] == '区域三'){
	            array_push($seat_3, $list[$key]);
	        }
	      
	        if($val['level_name'] == '区域四'){
	            array_push($seat_4, $list[$key]);
	        }
	        if($val['level_name'] == '区域五'){
	            array_push($seat_5, $list[$key]);
	        }
	        if($val['level_name'] == '区域六'){
	            array_push($seat_6, $list[$key]);
	        }
	        //-----------------精品专区2------------------------
	        if($val['level_name'] == '易货热卖'){
	            array_push($data_info['Hot_sale'], $list[$key]);
	        }
	        if($val['level_name'] == '推荐店铺'){
	            array_push($data_info['Shop_recommend'], $list[$key]);
	        }
	        if($val['level_name'] == '猜你喜欢'){
	            array_push($data_info['Guess_like'], $list[$key]);
	        }
	    }
	 
	    if(!empty($seat_1)){
	      $seat_1 =   $this->array_Sort("SORT_ASC","position",$seat_1);
	    }
	    if(!empty($seat_2)){
	        $seat_2 =   $this->array_Sort("SORT_ASC","position",$seat_2);
	    }
	    if(!empty($seat_3)){
	        $seat_3 =   $this->array_Sort("SORT_ASC","position",$seat_3);
	    }
	    if(!empty($seat_4)){
	        $seat_4 =   $this->array_Sort("SORT_ASC","position",$seat_4);
	    }
	    if(!empty($seat_5)){
	        $seat_5 =   $this->array_Sort("SORT_ASC","position",$seat_5);
	    }
	    if(!empty($seat_6)){
	        $seat_6 =   $this->array_Sort("SORT_ASC","position",$seat_6);
	    }
	    $data_info['Boutique2']['seat_1'] = $seat_1;//精品专区2第1块
	    $data_info['Boutique2']['seat_2'] = $seat_2;//精品专区2第2块
	    $data_info['Boutique2']['seat_3'] = $seat_3;//精品专区2第3块
	    $data_info['Boutique2']['seat_4'] = $seat_4;//精品专区2第4块
	    $data_info['Boutique2']['seat_5'] = $seat_5;//精品专区2第5块
	    $data_info['Boutique2']['seat_6'] = $seat_6;//精品专区2第6块
	    
	    $return['data'] = $data_info;
	    $demand = $this->App->get_demand_logo();
	    if($demand){
	        $return['data']['demand_img_url'] = $demand['img_path'];
	    }else{
	        $return['data']['demand_img_url'] = '';
	    }
	    
	    echo json_encode($return);
	}
	

	
	
	/**
	 * 对数组元素进行排序
	 * $sort_type  排序 SORT_DESC 降序；SORT_ASC 升序
	 * $field  排序参数（int）
	 * $sort_array 数组
	 * return array
	 */
	private function array_Sort($sort_type = 'SORT_ASC',$field,$sort_array){
	    $sort = array(
	        'direction' => $sort_type, 
	        'field'     => $field,      
	    );
	    $arrSort = array();
	    foreach($sort_array as $k => $v){
	        foreach($v AS $key=>$value){
	            $arrSort[$key][$k] = $value;
	        }
	    }
	    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $sort_array);
	    return $sort_array;
	}
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */