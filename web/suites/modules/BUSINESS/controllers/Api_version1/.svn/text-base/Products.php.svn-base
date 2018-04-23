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
        $this->load->model('product_cat_mdl');
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
        $long =  isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $lat = isset($prams["latitude"]) ? $prams["latitude"] : 0;
      
        //高德地图经纬度转百度经纬度
        $_info = $this->bd_encrypt($long,$lat);
        $longitude  = $_info['bd_lon'];
        $latitude = $_info['bd_lat'];
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
            $listdata[$key]["distance"]= $this->getDistance($latitude, $longitude, isset($v['latitude']) ? $v['latitude'] : 0, isset($v['longitude']) ? $v['longitude'] : 0) . "";
        }
       
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

//         foreach ($listdata as $key =>$val){
//             if($val['id'] != '1209'){
//                 unset($listdata[$key]);
//             }
//         }
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdata;
        
       
        print_r(json_encode($return));
    }

    //GCJ-02(火星，高德) 坐标转换成 BD-09(百度) 坐标
    //@param bd_lon 百度经度
    //@param bd_lat 百度纬度
   private function bd_encrypt($gg_lon,$gg_lat)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $gg_lon;
        $y = $gg_lat;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['bd_lon'] = $z * cos($theta) + 0.0065;
        $data['bd_lat'] = $z * sin($theta) + 0.006;
        return $data;
    }
    
    //BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
    //@param bd_lon 百度经度
    //@param bd_lat 百度纬度
    private function bd_decrypt($bd_lon,$bd_lat)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $bd_lon - 0.0065;
        $y = $bd_lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['gg_lon'] = $z * cos($theta);
        $data['gg_lat'] = $z * sin($theta);
        return $data;
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
                 $this->hot_keywords_mdl->add_hot_keywords(0,$value,1);
            }
        }
        
        // 经纬度求距离
        $long = isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $lat = isset($prams["latitude"]) ? $prams["latitude"] : 0;
        
        
        //高德地图经纬度转百度经纬度
        $_info = $this->bd_encrypt($long,$lat);
        $longitude  = $_info['bd_lon'];
        $latitude = $_info['bd_lat'];
        
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
            $return['data'][$key]["imgurl"] = $res["img_url"];
            if($prams["type"] == "APPACTIVITY"){
                $return['data'][$key]["act_start_time"] = $res["act_start_time"];
                $return['data'][$key]["act_end_time"] = $res["act_end_time"];
            }
            
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

        $type = $prams['type'];
        $this->load->model('product_cat_mdl');
        if(empty($type)){
            $data = $this->product_cat_mdl->getSectionList()['data'];
            foreach ($data as $k =>$v){
            
                $url = ltrim($v['img'],'uploads/');
                $data[$k]['img'] = $url;
            }
            $return['data'] =$data;
            print_r(json_encode($return));
        }else{
           
           $cat_info = $this->product_cat_mdl->getSectionList('new');
            //暂时数据库只录入三个层级分类
            $rank1 = array(); //顶级分类
            foreach ($cat_info as $key => $val){//筛选出顶级分类数据
                if($val['level'] == 0){
                    array_push($rank1, $val);
                }
            }
            $return['data']=$rank1;
            print_r(json_encode($return));
        }
    }
    /**
     * 获取分类页
     */
    public function getSectionListByID()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->_check_prams($prams, array(
            'id'
        ));
        $id= $prams['id'];
        $this->load->model('product_cat_mdl');
        $rank2 = $this->product_cat_mdl->getSectionListByID($id);
      
        $info = array();
        foreach ($rank2 as $key2 =>$val2){
            $rank3 =  $this->product_cat_mdl->getSectionListByID($val2['id']);
           
            foreach ($rank3 as $key3 =>$val3){
                if(!$val3['type']){
                    if($val3['link']){
                        if($key2 != 0){
                           if(!isset($info[$key2-1])){
                               $info[$key2-1]['cate_name'] = $val2['name'];
                               $info[$key2-1]['cate_list'][] = $val3;
                           }else{
                               $info[$key2]['cate_name'] = $val2['name'];
                               $info[$key2]['cate_list'][] = $val3;
                           } 
                         }else{
                             $info[$key2]['cate_name'] = $val2['name'];
                             $info[$key2]['cate_list'][] = $val3;
                         }
                    }
                }else{
                    if($val3['cat_id']){
                        if($key2 != 0){
                               if(!isset($info[$key2-1])){
                                   $info[$key2-1]['cate_name'] = $val2['name'];
                                   $info[$key2-1]['cate_list'][] = $val3;
                               }else{
                                   $info[$key2]['cate_name'] = $val2['name'];
                                   $info[$key2]['cate_list'][] = $val3;
                               } 
                             }else{
                                 $info[$key2]['cate_name'] = $val2['name'];
                                 $info[$key2]['cate_list'][] = $val3;
                             }
                    }
                }
            }
        }
     
        $return['data']=$info;
        print_r(json_encode($return));
    }
    
   
    /**特别声明  搜索综合接口
     * getListBySyn综合了(getListByConditions)跟(search)两个接口
     * cate_id 分类ID
     * keyword 关键词
     */   
  
    function getListBySyn(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
//             'totalpage' => 0,
//             'totalcount' => 0,
            'listdate' => array()
        );
        
//         $this->_check_prams($prams, array(
//             'cate_id'
//         ));
        $cat_id =isset($prams['cate_id'])? $prams['cate_id']:"";
        
        $tribe_id =isset($prams['tribe_id'])? $prams['tribe_id']:"";
        
        $keyword = isset($prams['keyword'])? $prams['keyword']:"";
        $orderBy = isset($page['orderBy'])? $page['orderBy']:"";
        // 经纬度求距离
        $long =  isset($prams["longitude"]) ? $prams["longitude"] : 0;
        $lat = isset($prams["latitude"]) ? $prams["latitude"] : 0;
        //企业ID
        $corporation_id = isset($prams['corporation_id']) ? $prams['corporation_id'] : 0;
        
        //高德地图经纬度转百度经纬度
        if($long && $lat){
            $_info = $this->bd_encrypt($long,$lat);
            $longitude  = $_info['bd_lon'];
            $latitude = $_info['bd_lat'];
        }else{
            $longitude = 0;
            $latitude = 0;
        }
        
        $this->load->model("goods_mdl");
       
        if(empty($orderBy)){
            $orderBy = 'sequence';//默认值
        }
        switch($orderBy){
            case "price_up"://价格
                $type = 7;
                break;
            case "price_down"://价格
                $type = 8;
                break;
            case "sale_count_up"://销量
                $type = 1;
                break;
            case "sale_count_down"://销量
                $type = 2;
                break;
            case "near_distance"://距离
                $type = 5;
                break;
            case "far_distance"://距离
                $type = 6;
                break;
            case "update_at"://新品
                $type = 9;
                break;
            case "sequence"://权重
                $type = 10;
                break;
        }
        
        switch ($type){
            case "1"://销量
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "2"://销量
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "5"://距离
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "6"://距离
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "7"://价格
                $this->goods_mdl->sequence = array("sequence"=>"asc");
                break;
            case "8"://价格
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "9"://新品
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
            case "10"://权重
                $this->goods_mdl->sequence = array("sequence"=>"desc");
                break;
        }
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
//         $totalpage = $perPage ? ceil($totalcount / $perPage) : 1;
        if($cat_id){
            $cate_id = explode(",",$cat_id);
            $catid_array = $this->goods_mdl->get_son_cateid($cate_id);//查询子分类id
            $search_type = false;
        }else{
            $catid_array = '';
            $search_type = true;
        }
        
      if(!$tribe_id){
          // 设置查询字段
          $productList = $this->goods_mdl->get_productApp($catid_array,$perPage,$offset,$type,$longitude,$latitude,$keyword,$search_type,$corporation_id);//查询商品
      }else{
          $keyword_array = array();
          $keyword_array[] = $keyword;
          $productList = $this->goods_mdl->get_productFour($tribe_id,$keyword_array,$perPage,$offset,$type,$longitude,$latitude);//查询商品
      }
     
        // 返回数据
        $return['data']['perpage'] = $perPage;
//         $return['data']['totalpage'] = $totalpage;
        $return['data']['currentpage'] = $currPage;
//         $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $productList;
        
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