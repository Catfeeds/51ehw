<?php

/**
 * 搜索
 *
 *
 */
class Search extends Front_Controller
{

    /**
     */
    function __construct()
    {
        parent::__construct();
    }
 
    /**
     * 搜索关键字
     */
    function index($key = 0)
    {
        $data = $this->input->post();
        if (isset($data['product'])) { // 搜索商品
            
            redirect("goods/search/0/" . $data['product'] );
        } elseif (isset($data['need'])) {
            redirect('member/demand/demand_list?cateid=0&keyword='.rawurlencode($data['need']).'&sort=1');
        } elseif (isset($data['enterprise'])) { // 搜索企业
            redirect('corporate/search/get_list/' . rawurlencode($data['enterprise']));
        }
    }
    
    function wechat_search(){
        $this->load->model('hot_keywords_mdl');
        //热门推荐
        $keywords = $this->hot_keywords_mdl->get_hot_keywords(100,1);
        
        foreach ($keywords as $key =>$val){
            if(empty($val['keyword']) ){//判断是否为空
               unset($keywords[$key]);
            }
            if(is_numeric($val['keyword'])){//判断是否为纯数字
                unset($keywords['hot_keywords'][$key]);
            }
           //如果strlen返回的字符长度和mb_strlen以当前编码计算的长度一致，可以判断是纯英文字符串。
           if(strlen($val['keyword']) == mb_strlen($val['keyword'])){
               unset($keywords[$key]);
           } 
           
        }
         
        $data['hot_keywords'] = array_slice($keywords,0,4);//数组切割，只要前面4个
        /* 记录浏览历史 */
        if (!empty($_COOKIE['history']))
        {
            $data['history'] = $history = explode(',', $_COOKIE['history']);
        }
        $data['title'] = '搜索';
        $data['null'] = true;
        $this->load->view('head', $data);
        $this->load->view('goods/search', $data);
        $this->load->view('foot', $data);
    }
    



    /**
     * 经纬度计算距离
     * @param unknown $lat1
     * @param unknown $lng1
     * @param unknown $lat2
     * @param unknown $lng2
     * @param string $miles
     * @return number
     */
    function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
        $radLat1 = $lat1 * pi() / 180;
        $radLat2 = $lat2 * pi() / 180;
    
        $a = $radLat1 - $radLat2;
        $b = $lng1 * pi() / 180 - $lng2 * pi() / 180;
    
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * 6378137; // EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }
    /*
     * 分类搜索
     */
    function wechat_searchClassify(){
        $this->load->model('product_cat_mdl');
        $app = $this->session->userdata('app_info');
        $classifl = $this->product_cat_mdl->getSectionList();
        $data['classifl'] = $classifl['data'];
        foreach ($data['classifl'] as $k =>$v){
            
            $url = ltrim($v['img'],'uploads/');
            $data['classifl'][$k]['img'] = $url;
        }
        
        $data['title'] = $app["app_name"];
        $data['head_set'] = 5;
		$data['foot_icon'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('classify', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 删除搜索记录
     */
    function delete_cookie(){
        setcookie('history','',time()-3600);
        $url = site_url('search/wechat_search');
        header("location: $url");
    }
    
    /**
     * 获取移动端IP地址
     * @return string
     */
    function getIP()
    {
        $ip = getenv('REMOTE_ADDR');
        $ip_ = getenv('HTTP_X_FORWARDED_FOR');
        if (($ip_ != "") && ($ip_ != "unknown")) {
            $ip = $ip_;
        }
        return $ip;
    }
    
    /**
     * 获取cookie经纬度
     * @return array
     */
    function get_latitude_cookie(){
        $latitude = array(); 
        if (isset($_COOKIE['latitude'])) {
            $latitude = array(
                'longitude' => $_COOKIE['longitude'],
                'latitude' => $_COOKIE['latitude']
            );
        }
        return $latitude;
    }
    
    /**
     * 经纬度set入cookie，有效时间1h
     * @param number $longitude
     * @param number $latitude
     */
    function set_latitude_cookie($longitude=0,$latitude=0){
        setcookie("longitude", $longitude, time()+3600, '/');
        setcookie("latitude", $latitude, time()+3600, '/');
    }
    
    
    /**
     * 优惠卷使用的商品
     */
    public function discount_goods($p_id){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            $this->session->set_userdata ( 'redirect', current_url () );
            redirect ( 'customer/login' );
            exit ();
        }
        
        // 判断是否绑定手机
        if ($this->isMobile()) {
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($this->session->userdata("user_id"));
            if(!empty($customer['mobile'])){
                $this->session->set_userdata("mobile_exist",true);
            }else{
                redirect('member/binding/binding_mobile');
            }
        
        }
        
        $customer_id = $this->session->userdata ( 'user_id' );
        if(!is_numeric($p_id)){
            echo "数据异常";exit;
        }
//         $app_id = $this->session->userdata('app_info')['id'];//分站点id
        
        //获取当前设备经纬度
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false){//H5
            $ip = $this->getIP();
            if ($ip == '::1') {
                $url = "http://api.map.baidu.com/location/ip?ak=8VUp1IbWAlMzjt4GoC5kuaf7&coor=bd09ll";
            } else {
                $url = "http://api.map.baidu.com/location/ip?ak=8VUp1IbWAlMzjt4GoC5kuaf7&ip=".$ip."&coor=bd09ll";
            }
            $json = (json_decode(file_get_contents($url), true));
        
            $data['lng'] = $json['content']['point']['x'];
            $data['lat'] = $json['content']['point']['y'];
        }

        //获取优惠卷可以使用的商品
        $this->load->model("card_package_mdl");
        $data["goods"] = $this->card_package_mdl->discount_goods($p_id,$customer_id);

        $data['head_set'] = 3;
        $this->load->view('head', $data);
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false){//PC
            $this->load->view('_header', $data);
        };
        
        $this->load->view('goods/discount', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    //-------------------------------------------------------------------
    
    /**
     * 进入搜索商品页面
     */
    function wechat_search_goods(){
        $cateid = $this->input->get_post("cate_id");//分类id
        $keyword = $this->input->get_post("keyword");//搜索关键词
        $data['keyword'] = $keyword;//搜索关键词
        $data["cateid"] = $cateid;//分类id
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('goods/search', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    
    }
    
    //-------------------------------------------------------------------
    
    /**
     * h5搜索
     * 搜索分四种模式
     * 模式1：只有分类模式：系统将忽略关键字内容，并且深度查询分类
     * 模式2：关键字搜索商品+关键词搜索分类,并且深度查询分类模式：排序关键词商品－>分类商品，系统将显示分类列表，以及整个产品库查询
     * 模式3：有关键字和有分类,并且深度查询分类模式：系统将根据关键字和分类清晰定位数据，筛选显示属性
     * 模式5：没有任何关键词和分类，查询整个商品。
     */
    function ajax_search_goods(){
    
        $cateid = $this->input->get_post("cateid");//分类id
        $keyword = $this->input->get_post("keyword");//搜索关键词
        $type = $this->input->get_post("type");//类型
        $longitude = $this->input->get_post("Longitude");//经度
        $latitude = $this->input->get_post("Latitude");//纬度
        $customer_id = $this->session->userdata("user_id");//用户id
    
    
    	//判断是否非法操作
	    if($cateid<0){
	        $data["productList"] = array();
	        $data["status"] = 2;//搜索参数错误
	        echo json_encode($data);exit;
	    }else{
	        if($cateid==0){
	        }else{
	            $cate_id = explode(",",$cateid);
	            foreach ($cate_id as $v){
	                if(is_numeric($v)){
	                    $cateid_array[] = $v;
	                }else{
	                    $data["productList"] = array();
	                    $data["status"] = 2;//搜索参数错误
	                    echo json_encode($data);exit;
	                }
	            }
	        }
	    }

        $this->load->model("goods_mdl");
        
        $limit = 5;//显示条数
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        $offset = ($page-1)*$limit;//偏移量

        	
        switch ($type){
            case "1"://销量
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "2"://销量
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "3"://评论
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "4"://评论
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "5"://距离
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "6"://距离
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
        }
        
        if(!empty($cateid_array) && empty($keyword)){//模式1
            $catid_array = $this->goods_mdl->get_son_cateid($cateid_array);//查询子分类id
            $productList = $this->goods_mdl->get_productOne($catid_array,$limit,$offset,$type,$longitude,$latitude);//查询商品
        }else if(empty($cateid) && empty($keyword) ){//模式5
            $productList = $this->goods_mdl->get_productFives($limit,$offset);//查询商品
            
        }else{
            $keyword_array = $this->_hot_keywords($keyword,1);//记录搜索关键词,如果没有则把最热门的3个关键词作为搜索
            if($cateid==0){//模式2
                $catid_array = $this->goods_mdl->get_class($keyword_array);//关键词查询分类
                if($catid_array){
                    $catid_array = $this->goods_mdl->get_son_cateid($catid_array);//查询子分类id
                }
                $productList = $this->goods_mdl->get_productTow($keyword_array,$catid_array,$limit,$offset,$type,$longitude,$latitude);//查询商品
                
            }else{//模式3
                $catid_array = $this->goods_mdl->get_son_cateid($cateid_array);//查询子分类id
                $productList = $this->goods_mdl->get_productThree($keyword_array,$catid_array,$limit,$offset,$type,$longitude,$latitude);//查询商品
            }

        }

        $data['productList'] = $productList;
        echo json_encode($data);

    
    }
    
    
/**
     * 记录搜索关键词
     * ajax_search_goods的私有方法
     * @param string $keyword 关键词
     * @param int $type 记录类型 1商品2部落
     */
    private function _hot_keywords($keyword,$type){
        //检查有无搜索关键词，如果有则记录热门搜索，没有把最热门的3个关键词作为搜索
        $this->load->model('hot_keywords_mdl');
        $customer_id = $this->session->userdata("user_id");//用户id
        $keyword = trim($keyword);
        $keyword_array = array();//搜索的关键词
        if ($keyword == 0 || $keyword && isset($keyword) && !empty($keyword) && $keyword != null && $keyword != "") {//有关键词
            $keywords = explode(" ", $keyword);
            foreach ($keywords as $key => $value) {
                if($value || $value == 0){
                    $this->hot_keywords_mdl->add_hot_keywords($customer_id,$value,$type);//添加记录
                    $keyword_array[] = $value;
                }
            }
            $keyword_array = array_merge(array_unique($keyword_array));//搜索关键词去处重复
        } else {//没有关键词
            $keywords = $this->hot_keywords_mdl->get_hot_keywords(3,$type);//搜索的关键词
            foreach ($keywords as $v) {
                $keyword .= " ".$v['keyword'];
                $keyword_array[] = $v['keyword'];
            }
    
        }
        return $keyword_array;
    }
}