<?php

/**
 * 搜索
 *
 *
 */
class search extends Front_Controller
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
            
            redirect("goods/search/0/" . $data['product']);
        } elseif (isset($data['need'])) {
            redirect('member/demand/demand_list?cateid=0&keyword='.$data['need'].'&sort=1');
        } elseif (isset($data['enterprise'])) { // 搜索企业
            redirect('corporate/search/get_list/' . rawurlencode($data['enterprise']));
        }
    }
    
    function wechat_search(){
        $this->load->model('hot_keywords_mdl');
        //热门推荐
        $data['hot_keywords'] = $this->hot_keywords_mdl->get_hot_keywords(4);
        
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
    
    function wechat_search_goods(){
        $this->load->model('category_mdl');
        $_cate_id = $this->input->get_post('cate_id');
        $isparent = $this->input->get_post('isparent');
        
        if(base64_encode(base64_decode($_cate_id)) == $_cate_id && !is_numeric($_cate_id)){
            $cate_id = unserialize(base64_decode($_cate_id));
        }
        else{
            $cate_id = $_cate_id;
        }

        // 取子分类1
        if ($cate_id != 0 && $cate_id != "0") {
            $cate_ids = explode(',', $cate_id);
        } else {
            $cate_ids = 0;
        }
        $cate_idlist = array();
        if ($isparent != 0 && $isparent != "0") {
            foreach ($cate_ids as $s) {
                $catelist = $this->category_mdl->get_childcatbyparent($s);
                foreach ($catelist as $cate) {
                    array_push($cate_idlist, $cate["id"]);
                }
            }
        } else {
            $cate_idlist = $cate_ids;
        }
        // 取子分类2
//         if ($cate_id != 0 && $cate_id != "0") {
//             $cate_ids = explode(',', $cate_id);
//         } else {
//             $cate_ids = 0;
//         }
//         $cate_idlist = $cate_ids;
//         if ( $isparent != "0" && $cate_idlist != "0") {
//             foreach ($cate_ids as $s) {
//                 $catelist = $this->category_mdl->get_childcatbyparent($s);
//                 foreach ($catelist as $cate) {
//                     array_push($cate_idlist, $cate["id"]);
//                 }
//             }
//         }
        
        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        $options = array();
        
        $keyword = $this->input->get_post('search_index');

        /* 记录浏览历史 */
        if (!empty($_COOKIE['history']))
        {
            $data['history'] = $history = explode(',', $_COOKIE['history']);
            if(stripos($_COOKIE['history'].',',$keyword.',')===false){
                array_unshift($history, $keyword); //入栈
                while (count($history) > 12) //大于容器容量
                {
                    array_pop($history); //出栈
                }
                setcookie('history', implode(',', $history), time() + 3600 * 24 * 30);
            }
        }
        else
        {
            setcookie('history', $keyword, time() + 3600 * 24 * 30);
        }
        
        $this->load->model('hot_keywords_mdl');
        if ( $keyword == null || $keyword == "" || ctype_space($keyword)) {} else {
            $key_array = explode(" ",$keyword);
            foreach ( $key_array as $key =>$value){
                $this->hot_keywords_mdl->add_hot_keywords($value);
            }
        }
        $data["recommend"] = $this->input->get_post("recommend");
        $data["order"] = $this->input->get_post("order");
        $this->load->model('category_mdl', 'category');
        $this->load->model('goods_mdl', 'goods');
        
        // 没有输入关键字
        if ($keyword == null || $keyword == "") {} else {
            // 没有选分类
           /* if ($cateid == 0) {
                $data['key_cate'] = $this->goods->get_categorys_with_keyword($keyword);
            } else {}*/
            $options['keywords'] = $keyword;
        }
        // 没有输入order
        if ($data["order"] == null || $data["order"] == "") {} else {
            $options["order"] = $data["order"];
        }
        // 没有输入关键字
        if ($data["recommend"] == null || $data["recommend"] == "") {} else {
            $options["recommend"] = $data["recommend"];
        }
        
        $data['keyword'] = $keyword;
        
        $appInfo = $this->session->userdata('appInfo');
        $section_id = $this->input->get_post("section_id");
        //无刷新加载数据
        if($is_ajax){
            $data["pagesize"] = $this->input->get_post('page');
            $data["page"] = $this->input->get_post('limit');
            if(0 == $data["page"])
            {
                $data["page"] = 1;
            }
            $offset   = ($data["page"] - 1 ) * $data["pagesize"];
            
        }else{
            $data["pagesize"] = 15;
            $data["page"] = 1;
        }

        $app_Info = $this->session->userdata('app_info');
        $customer_id = 0;

        $options["order"] = $data["order"];
        //取消显示搜索总条数
        $data['distance_total'] = $this->goods->get_count_with_condition($cate_idlist, array(), $options, null, $app_Info['id'], $customer_id, $section_id,0,'distance');
        if($is_ajax){
            // 如果是查看距离
            if ($options["order"] == 'near_distance' || $options["order"] == 'far_distance') {
                //H5经纬度反馈
                $lat1 = $this->input->get_post('lat1');
                $lng1 = $this->input->get_post('lng1');
                if($lat1!='' && $lng1!=''){
                    $latitude = $this->get_latitude_cookie();
                    if(count($latitude)!=0){
                        $options["location"] = array(
                            'longitude' => $latitude['longitude'],
                            'latitude' => $latitude['latitude']
                        );
                    }else{
                        $gpsConversion = "http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x=$lng1&y=$lat1";
                        $json = (json_decode(file_get_contents($gpsConversion), true));
                        $options["location"] = array(
                            'longitude' => base64_decode($json['x']),
                            'latitude' => base64_decode($json['y'])
                        );
                        $this->set_latitude_cookie($options["location"]['longitude'],$options["location"]['latitude']);
                    }
                }else{
                    // IP获取经纬度
                    $ip = $this->getIP();
                    if ($ip == '::1') {
                        $url = "http://api.map.baidu.com/location/ip?ak=8VUp1IbWAlMzjt4GoC5kuaf7&coor=bd09ll";
                    } else {
                        $url = "http://api.map.baidu.com/location/ip?ak=8VUp1IbWAlMzjt4GoC5kuaf7&ip=".$ip."&coor=bd09ll";
                    }
                    $json = (json_decode(file_get_contents($url), true));
                    $options["location"] = array(
                        'longitude' => $json['content']['point']['x'],
                        'latitude' => $json['content']['point']['y']
                    );
                }
            }
            $produtList = $this->goods->get_lists_with_condition($data["pagesize"], $offset, $cate_idlist, array(), $options, 'p.id,p.name,p.short_name,p.longitude,p.latitude,vip_price,price,m_price,goods_thumb,short_desc', null, $app_Info['id'], $customer_id, $section_id);
        } else {
            $produtList = $this->goods->get_lists_with_condition($data["pagesize"], ($data["page"] - 1) * $data["pagesize"], $cate_idlist, array(), $options, 'p.id,p.name,p.short_name,vip_price,price,m_price,goods_thumb,short_desc', null, $app_Info['id'], $customer_id, $section_id);
        }
        $data["productList"] = $produtList;
        
        if (! empty($_cate_id) & $_cate_id != '') {
            $data['foot_icon'] = 2;
        } else 
            if (! empty($data["order"]) && $data["order"] = "updated_at_down") {
                $data['foot_icon'] = 3;
            }
        
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        
        // 无刷新加载数据
        if ($is_ajax) {
            $data['limit'] = $data["page"] + 1;
            // 如果是查看距离
            if ($options["order"] == 'near_distance' || $options["order"] == 'far_distance') {
                $data['longitude'] = $options["location"]['longitude'];
                $data['latitude'] = $options["location"]['latitude'];
            }
            echo json_encode($data);
        } else {
            $this->load->view('head', $data);
            $this->load->view('goods/search', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    /*
     * 分类搜索
     */
    function wechat_searchClassify(){
        $this->load->model('product_cat_mdl');
        $app = $this->session->userdata('app_info');
        $classifl = $this->product_cat_mdl->getSectionList();
        $data['classifl'] = $classifl['data'];
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
}