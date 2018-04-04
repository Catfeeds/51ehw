<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends Api_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ad_mdl');
        $this->load->model('attr_mdl');
        $this->load->model('sign_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('category_mdl');
        $this->load->model('hot_keywords_mdl');
        $this->load->model('product_sku_mdl');
    }

    public function index()
    {
        echo 'Products API';
    }
    /**
     * 根据条件获取产品列表
     * $section 分类array
     * $isparent
     */
    public function getListByConditions()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $attrs = isset($prams['filter']) ? $prams['filter'] : array();
        $section = isset($prams['section']) ? $prams['section'] : 0;
        $isparent = isset($prams['isparent']) ? $prams['isparent'] : 0;
        $corporation_id = isset($prams['corporation_id']) ? $prams['corporation_id'] : 0;
        
        // 经纬度求距离
        $longitude = isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $latitude = isset($prams["latitude"]) ? $prams["latitude"] : 0;
        
        $options = array();
        
        $options['order'] = $page['orderBy'];
        
        // 是否距离排序,产品要求如果排距离排序,等不显示没有坐标的产品
        $filterproduct = 0;
        if ($options['order'] == "distance_up") {
            $filterproduct = 1;
            $options['order'] = "near_distance";
            $options["location"]["longitude"] = $longitude;
            $options["location"]["latitude"] = $latitude;
        }
        
        if (isset($prams['is_vip']))
            $options['is_vip'] = $prams['is_vip'];
        
        if (isset($prams['is_mc']))
            $options['is_mc'] = $prams['is_mc'];
        
        $app_info = $this->session->userdata('app_info');
        
        // 取子分类
        if ($section != 0 && $section != "0") {
            $sections = explode(',', $section);
        } else {
            $sections = 0;
        }
        $sectionlist = array();
        if ($isparent != 0 && $isparent != "0") {
            
            foreach ($sections as $s) {
                $catelist = $this->category_mdl->get_childcatbyparent($s);
                foreach ($catelist as $cate) {
                    array_push($sectionlist, $cate["id"]);
                }
            }
        } else {
            $sectionlist = $sections;
        }
        
        // 设置查询字段
        $select = 'p.id,cat_id,p.name,price,market_price,vip_price,is_hot,is_new,is_vip,is_commend,goods_thumb,longitude,latitude';
        
        $totalcount = $this->goods_mdl->get_count_with_condition($sectionlist, $attrs, $options, array(), $app_info["id"], 0, 0, 0, $filterproduct/*,$sections*/); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数

        $listdata = $this->goods_mdl->get_lists_with_condition($perPage, $offset, $sectionlist, $attrs, $options, $select, array(), $app_info["id"],null,null,$corporation_id);

        foreach ($listdata as $key => $v) {
            $listdata[$key]["distance"] = $this->getDistance($latitude, $longitude, isset($v['latitude']) ? $v['latitude'] : 0, isset($v['longitude']) ? $v['longitude'] : 0) . "";
        }
      
        if(count($listdata) > 0){
            //距离排序
            //因为数据查出来后距离又重新计算一遍，可能是数据有点出入 ，所以重新排距离
            if($options['order'] == 'near_distance'){
                $sort = array(
                    'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => 'distance',       //排序字段
                );
                $arrSort = array();
                foreach($listdata as $k => $v){
                    foreach($v AS $key=>$value){
                        $arrSort[$key][$k] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $listdata);
                }
            }
        } 
        //-----互助店商品是否被添加处理开始
        $user_id = $this->session->userdata ( 'user_id' );
        if($user_id){
            $this->load->model('customer_shop_mdl','shop');
            $shop = $this->shop->load($user_id);
            if($shop){
                foreach ($listdata as $key => $val){
                    $exist = $this->shop->check_product($shop['id'],$val['id']);//检查是否已添加
                    if($exist){
                        $listdata[$key]['in_shop'] = true;
                    }else{
                        $listdata[$key]['in_shop'] = false;
                    }
                }
        
            }
        }
        //-----互助店商品是否被添加处理结束
        
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdata;
        
        print_r(json_encode($return));
    }

    // 获取产品详细
    public function getDetailsById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 检验参数
        $this->_check_prams($prams, array(
            'id'
        ));

        // 获取用户资料
        $id = $prams['id'];
        $goods = $this->goods_mdl->get_by_id($id);

        if ($goods) {
            $return['data'] = $goods;
        }

        print_r(json_encode($return));
    }

    // 获取多个商品信息
    public function getListByIdArray()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 检验参数
        $this->_check_prams($prams, array(
            'ids'
        ));

        $return['data'] = array(
            'listdate' => array()
        );

        $idsArray = explode(',', $prams['ids']);

        // 设置查询字段
        $select = 'p.id,name,price,is_hot,is_new,is_vip,is_commend,goods_thumb';

        $listdate = $this->goods_mdl->get_lists_with_condition(0, 0, 0, array(), array(), $select, $idsArray);

        // 返回数据
        $return['data']['listdate'] = $listdate;

        print_r(json_encode($return));
    }

    // 获取主页产品列表
    public function getListForIndex()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        foreach ($this->_get_cate_wine() as $v) {
            $cate_wine[] = $v['id'];
        }

        foreach ($this->_get_cate_tonic() as $v) {
            $cate_tonic[] = $v['id'];
        }
        $app_id = $this->session->userdata("app_info")["id"];
        // 设置查询字段
        $select = 'p.id,p.cat_id,p.name,p.price,p.market_price,p.vip_price,p.is_hot,p.is_new,p.is_vip,p.is_commend,p.goods_thumb';

        $return['data']['wine'] = $this->goods_mdl->get_lists_with_condition(3, 0, 0, array(), array(), $select, array(), $app_id);
        $return['data']['tonic'] = $this->goods_mdl->get_lists_with_condition(3, 0, 0, array(), array(), $select, array(), $app_id);

        print_r(json_encode($return));
    }

    // 获取筛选器
    public function getFilter()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 检验参数
        $this->_check_prams($prams, array(
            'type'
        ));

        switch ($prams['type']) {
            case 'wine':
                $listdata = $this->_get_cate_wine();
                break; // 酒类
            case 'tonic':
                $listdata = $this->_get_cate_tonic();
                break; // 补品
            default:
                $listdata = array(); // $listdata = array_merge($this->_get_cate_wine(),$this->_get_cate_tonic());
        }

        $cate = array();
        foreach ($listdata as $v) {
            $cate[] = array(
                'id' => $v['id'],
                'name' => $v['name']
            );
        }

        $cateid = isset($prams['cateid']) ? $prams['cateid'] : 0;

        $return['data']['type1'] = $cate;
        $return['data']['type2'] = $this->_get_sign_by($cateid, 2);
        $return['data']['type3'] = $this->_get_sign_by($cateid, 4);

        print_r(json_encode($return));
    }

    public function search()
    {
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $key = isset($prams['key']) ? $prams['key'] : "";
        
        if ($key == null || $key == "" || ctype_space($key)) {} else {
            $key_array = explode(" ", $key);
            foreach ($key_array as $keyword => $value) {
                $this->hot_keywords_mdl->add_hot_keywords('',$value,1);
            }
        }
        
        // 经纬度求距离
        $longitude = isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $latitude = isset($prams["latitude"]) ? $prams["latitude"] : 0;
        
        $cateid = isset($prams['cate_id']) ? $prams['cate_id'] : 0;
        $isparent = isset($prams['isparent']) ? $prams['isparent'] : 0;
        
        $options = array();
        
        $options['order'] = $page['orderBy'];
        $options['app_id'] = $this->session->userdata("app_info")["id"];
        $options['corporation_id'] = isset($prams["corporation_id"]) ? $prams["corporation_id"] : 0;
        
        // 设置只查询5km以内商品
        $options['distance'] = isset($prams['distance']) ? $prams['distance'] : 5000;
        // 是否显示无距离商品
        $options['have_distance'] = isset($prams['have_distance']) ? $prams['have_distance'] : false;
        
        if ($cateid) {
            $cates = explode(',', $cateid);
        } else {
            $cates = 0;
        }
        
        $catelist = array();
        if ($isparent != 0 && $isparent != "0") {
            foreach ($cates as $s) {
                $catel = $this->category_mdl->get_childcatbyparent($s);
                foreach ($catel as $cate) {
                    array_push($catelist, $cate["id"]);
                }
            }
        } else {
            $catelist = $cates;
        }
        
        if (isset($prams['is_vip'])){
            $options['is_vip'] = $prams['is_vip'];
        }
        
        if (isset($prams['is_mc'])){
            $options['is_mc'] = $prams['is_mc'];
        }
        $app_id = $this->session->userdata("app_info")["id"];
        
        // 设置查询字段
        $select = 'corporation_id,id,cat_id,name,sequence,hits,vip_price,market_price,vip_price,is_hot,is_new,is_vip,is_commend,goods_thumb,longitude,latitude';
        $totalcount = $this->goods_mdl->get_count_lists_for_search($catelist, $key, $options, $select, $longitude, $latitude);
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1;
        
        $listdate = $this->goods_mdl->get_lists_for_search($catelist, $key, $options, $select, $perPage, $offset, $longitude, $latitude);
        $list = array();
        $order = array();
        foreach ($listdate as $key => $v) {
            $list[$key] = $v;
            if (isset($v['latitude']) && $v['latitude'] != null && isset($v['longitude']) && $v['longitude'] != null) {
                $list[$key]["distance"] = $this->getDistance($latitude, $longitude, isset($v['latitude']) ? $v['latitude'] : 0, isset($v['longitude']) ? $v['longitude'] : 0);
            } else {
                $list[$key]["distance"] = 0;
            }
        }
        
        //-----互助店商品是否被添加处理开始
        $user_id = $this->session->userdata ( 'user_id' );
        if($user_id){
            $this->load->model('customer_shop_mdl','shop');
            $shop = $this->shop->load($user_id);
            if($shop){
                foreach ($list as $key => $val){
                    $exist = $this->shop->check_product($shop['id'],$val['id']);//检查是否已添加
                    if($exist){
                        $list[$key]['in_shop'] = true;
                    }else{
                        $list[$key]['in_shop'] = false;
                    }
                }
                
            }
        }
        //-----互助店商品是否被添加处理结束
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $list;
        $return['data']['app_id'] = $app_id;
        
        print_r(json_encode($return));
    }

    // 查询历史数据
    public function getHistoryList()
    {
        $viewhistory = "";
        if (isset($_COOKIE['viewhistory'])) {
            $viewhistory = $_COOKIE['viewhistory'];
            if (strrpos($viewhistory, $id . ",") >= 0) {
                $viewhistory = str_replace($id . ",", "", $viewhistory);
            }
            $viewhistory = $id . "," . $viewhistory;
        } else {
            $viewhistory = $id . ",";
        }
        // echo $viewhistory;
        setcookie("viewhistory", $viewhistory, time() + 3000, '/');
    }

    // /获取酒类分类
    private function _get_cate_wine()
    {
        // 酒类ID
        $wine_id = 418;

        $cate = $this->category_mdl->getByCond(array(
            "parent_id" => $wine_id
        ));

        if ($cate) {
            return $cate;
        }
        return array();
    }

    // /获取补品分类
    private function _get_cate_tonic()
    {
        // 补品类ID
        $tonic_id = 419;

        $cate[] = $this->category_mdl->load($tonic_id);

        if ($cate) {
            return $cate;
        }

        return array();
    }
    // 获取属性
    private function _get_sign_by($cate_id, $level)
    {
        return $this->sign_mdl->getFilterForApp($cate_id, $level);
    }

    // 取productsku
    public function getProductSKU()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 检验参数
        $this->_check_prams($prams, array(
            'pid'
        ));

        $pid = $prams['pid'];

        $detail = $this->goods_mdl->get_by_id($pid);

        if (empty($detail)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '错误：无此产品！'
            );
            print_r(json_encode($return));
            exit();
        }

        $attributes = $this->attr_mdl->find_attrs_by_attr_set($detail["cat_id"], "sku");

        foreach ($attributes as $key => $attribute) {
            // 需要补充完整
            $skuinfo = $this->product_sku_mdl->getSKUByProductid($pid);
            if ($skuinfo != null) {
                $attributes[$key]['default_value'] = $skuinfo;
            } else {
                $attributes[$key]['default_value'] = array();
            }
        }

        $return['data'] = $attributes;
        print_r(json_encode($return));
    }

    /**
     * 获取广告楼层
     */
    public function getADList()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $app_info = $this->session->userdata('app_info');
        $this->_check_prams($prams, array(
            'type'
        ));
        
        $result = $this->ad_mdl->getBySign($prams["type"], $app_info["id"]);
        error_log($this->db->last_query());
        foreach ($result as $key => $res) {
            $return['data'][$key]["url"] = $res["url"];
            $return['data'][$key]["title"] = $res["title"];
            $return['data'][$key]["imgurl"] =$res["img_url"];
//             if (strpos($res["img_url"], "uploads") >= 0) {
//                 $return['data'][$key]["imgurl"] = substr($res["img_url"], strpos($res["img_url"], "/"));
//             } else {
//                 $return['data'][$key]["imgurl"] = "uploads" . substr($res["img_url"], strpos($res["img_url"], "/"));
//             }
            // 暂时替换，待完善或删除
            if($res["url"] == "siteinfo/index/62"){
                $return['data'][$key]["url"] = "siteinfo/app_action/63";
            }
        }
        
        print_r(json_encode($return));
    }

    /**
     * 获取分类页
     */
    public function getSectionList()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        $this->load->model('product_cat_mdl');
        $data = $this->product_cat_mdl->getSectionList()['data'];
        foreach ($data as $k =>$v){
        
            $url = ltrim($v['img'],'uploads/');
            $data[$k]['img'] = $url;
        }
        
        $return['data'] =$data;
        print_r(json_encode($return));
    }

    /*
     * 首页获取楼层
     */
    public function getHomeSection()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 首页显示类目
        $hotel_id = 1696; // $_json["navData"][2]['id'];
        $painting_id = 100000; // $_json["navData"][6]['id'];
        $ad_id = "4324,4415"; // $_json["navData"][7]['id'];
        $name = array(
            "酒店住宿",
            "广告",
            "书画"
        );
        $img = array(
            "images/home_hotel.png",
            "images/home_ad.png",
            "images/home_painting.png"
        );
        $list = array(
            $hotel_id,
            $ad_id,
            $painting_id
        );
        for ($i = 0; $i < 3; $i ++) {
            $return['data'][$i]["id"] = $list[$i];
            $return['data'][$i]["name"] = $name[$i];
            $return['data'][$i]["cate_img"] = $img[$i];
            $return['data'][$i]["isparent"] = 1;
        }
        print_r(json_encode($return));
    }

    public function getListByCateid()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        // 检验参数
        $this->_check_prams($prams, array(
            'cateid'
        ));

        // 经纬度求距离
        $longitude = isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $latitude = isset($prams["latitude"]) ? $prams["latitude"] : 0;

        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );

        if (! $prams['cateid']) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }

        switch ($prams['cateid']) {
            case 1:
                {
                    $cat_id = array(
                        100000
                    ); // 字画
                    break;
                }
            case 2:
                {
                    $cat_id = array(
                        189
                    ); // 餐饮美食
                    break;
                }
            case 3:
                {
                    $cat_id = array(
                        '0' => '4324',
                        '1' => '4415'
                    ); // 广告
                    break;
                }
            case 4:
                {
                    $cat_id = array(
                        4484
                    ); // 房产
                    break;
                }
        }

        $totalcount = count($this->goods_mdl->get_goods_with_top_category($cat_id));
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1;
        
        $listdate = $this->goods_mdl->get_goods_with_top_category($cat_id, $perPage, $offset);
        $list = array();
        foreach ($listdate as $key => $v) {
            $list[$key] = $v;
            $list[$key]["distance"] = number_format($this->getDistance($latitude, $longitude, isset($v['latitude']) ? $v['latitude'] : 0, isset($v['longitude']) ? $v['longitude'] : 0), 2, '.', '');
        }

        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $list;

        print_r(json_encode($return));
    }

    /**
     * 热门关键词
     *
     * @param unknown $lat1
     * @param unknown $lng1
     * @param unknown $lat2
     * @param unknown $lng2
     * @param string $miles
     * @return number
     */
    public function getHotKeyword()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;

        // 检验参数
        // $this->_check_prams($prams,array('type'));
        $offset = isset($prams['offset'])?$prams['offset']:7;

        $keywords = $this->hot_keywords_mdl->get_hot_keywords(100,1);///数量 类型   1商品2部落
        
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
         
        $keywords = array_slice($keywords,0,$offset);//数组切割
        $return['data']['cateid'] = $keywords;

        print_r(json_encode($return));
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
    
    
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */