<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

include_once 'Common/Uri.php';

class Goods extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('goods_mdl');
        $this->load->model('category_mdl');
        $this->load->model('hot_keywords_mdl');
        $this->load->helper('cookie');
    }

    // --------------------------------------------------------------------

    public function index()
    {
        redirect(site_url('goods/detail'));
    }
    // --------------------------------------------------------------------

    function getChildCateList($fcateid, $ffid, $fid, $valArray = array(), $result = array())
    {
        $this->load->model('sign_mdl');
        $childcate = $this->sign_mdl->getCateByParentCate($fcateid, $ffid);

        // print_r($valArray);
        foreach ($childcate as $cate) {
            if (array_key_exists($cate["cate_id"], $valArray)) {

                // print_r($this->getChildCateList($cate["cate_id"],$valArray['a_'.$cate["cate_id"]],$valArray));

                $result = $this->getChildCateList($fcateid, $cate["cate_id"], $valArray[$cate["cate_id"]], $valArray, $result);
            }
            // echo $cate["cate_id"];

            // print_r($subArray);
            $result[$cate["cate_id"]] = $this->sign_mdl->getByCondition(array(
                "cate_id" => $cate["cate_id"],
                "parent_id" => $fid
            ));
        }
        // print_r($result);
        return $result;
    }

    // --------------------------------------------------------------------

    // 商品筛选列表
    public function lists()
    {
        $cate = $this->input->get_post("cate");
        // $attr = $this->input->get_post("attr");
        // echo $cate;
        $data["page"] = $this->input->get_post("page");
        $data["pagesize"] = 15;
        $data["order"] = $this->input->get_post("order");

        $pagecondition = "?cate=" . $cate . "&order=" . $data["order"];

        $config['uri_segment'] = 3;
        // echo $this->uri->segment($config['uri_segment'], 0);
        if ($this->uri->segment($config['uri_segment'], 0)) {
            $data["page"] = $this->uri->segment($config['uri_segment'], 0) / $data["pagesize"] + 1;
        } else {
            if ($data["page"] == "") {
                $data["page"] = 1;
            }
        }

        $condAttr = array();
        $data['default_attr'] = "";
        // if($attr)
        // {
        // $attrs = explode(',', $attr);
        // foreach($attrs as $subattr)
        // {
        // $subattrval = str_replace('a_','',$subattr);
        // $data['default_attr'][$subattrval]=$this->input->get_post($subattr);
        // if($data['default_attr'][$subattrval] != null && $data['default_attr'][$subattrval] != "")
        // {
        // $condAttr[$subattrval] = $data['default_attr'][$subattrval];
        // $pagecondition = $pagecondition."&".$subattr."=".$data['default_attr'][$subattrval];
        // }

        // }
        // }

        // 类型
        $this->load->model('sign_mdl');
        $this->load->model('category_mdl');
        $mainCate = $this->category_mdl->getByCond(array(
            "is_leaf" => 1
        ));

        // print_r($mainCate);
        $data["mainCate"] = $mainCate;
        // print_r($cate);
        if ($mainCate) {
            if (! $cate) {
                $mainid = $mainCate[0]["id"];
            } else {
                $mainid = $cate;
            }

            $cates = $this->sign_mdl->getCateByMainCate($mainid);

            // print_r($cates);
            // $childcate = $this->getChildCateList($mainid,"0",$condAttr);

            $cateList = array();
            $data["catestr"] = "";
            foreach ($cates as $c) {
                // $data["catestr"] = $data["catestr"]."a_".$c["cate_id"].",";
                $data['default_attr'][$c["cate_id"]] = $this->input->get_post("a_" . $c["cate_id"]);
                if ($data['default_attr'][$c["cate_id"]] != null && $data['default_attr'][$c["cate_id"]] != "") {
                    $condAttr[$c["cate_id"]] = $data['default_attr'][$c["cate_id"]];
                    $pagecondition = $pagecondition . "&" . "a_" . $c["cate_id"] . "=" . $data['default_attr'][$c["cate_id"]];
                }

                $cateList[$c["cate_id"]] = $this->sign_mdl->getByCondition(array(
                    "cate_id" => $c["cate_id"]
                ));
            }

            $childcate = $this->getChildCateList($mainid, "0", "0", $condAttr);

            $data["cate"] = $cates;
            $data["cateList"] = $cateList;
            $data["selectCateList"] = $childcate;

            $data["default_maincateid"] = $mainid;

            // 分页设置
            $this->load->library('pagination');
            $config['base_url'] = site_url('goods/lists/');
            $config['suffix'] = $pagecondition;
            $config['total_rows'] = $this->goods_mdl->get_count_with_condition($mainid, $condAttr);
            $config['per_page'] = $data["pagesize"];
            $config['curr_page'] = $data["page"];
            $config['num_links'] = 10;
            $config['full_tag_open'] = '';
            $config['full_tag_close'] = '';
            $config['num_tag_open'] = '';
            $config['num_tag_close'] = '';
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="next"';
            $config['next_tag_open'] = '';
            $config['next_tag_close'] = '';
            $config['prev_link'] = '上一页';
            $config['prev_tag_css'] = 'class="prev"';
            $config['prev_tag_open'] = '';
            $config['prev_tag_close'] = '';
            // $config['cur_tag_css'] = 'class="current"';
            $config['cur_tag_open'] = '<a href="javascript:" class="ui-paging-current">';
            $config['cur_tag_close'] = '</a>';
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // print_r($data["pagination"]);

            // 查询产品
            // $count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);
            $produtList = $this->goods_mdl->get_lists_with_condition($data["pagesize"], ($data["page"] - 1) * $data["pagesize"], $mainid, $condAttr, array(
                "order" => $data["order"]
            ), 'p.id,p.name,market_price,price,goods_thumb');
            // print_r($produtList);
            $data["productList"] = $produtList;
            $data["totalcount"] = $config["total_rows"];
            $data["totalpage"] = ceil($config["total_rows"] / $data["pagesize"]);
        } else {
            redirect('home');
        }
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header');
        $this->load->view('goods/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 新的LIST代码，中使用这段代码
     *
     * @param string $type
     *            类型
     */
    public function getList($cateid = 0, $type = "")
    {
        if ($cateid == 0) {
            // exit ();
        }
        $customerInfo = $this->session->userdata('customerInfo');
        $appInfo = $this->session->userdata('appInfo');
        // $mainsection_id = $this->input->get_post ( "mainsection_id" );
        $section_id = $this->input->get_post("section_id");
        // $attr = $this->input->get_post("attr");
        // echo $cate;
        $data["type"] = $type;
        $data["page"] = $this->input->get_post("page");
        $data["pagesize"] = 15;
        $data["order"] = $this->input->get_post("order");

        $pagecondition = "";
        $app_id = 0;
        $customer_id = 0;
        if (! empty($section_id)) {
            $pagecondition = "?section_id=" . $section_id;
        }

        $this->load->model('section_mdl');
        $data['sections'] = $this->section_mdl->load_tree(0);

        // 判断是企业会员还是个人
        if ($appInfo != null && isset($appInfo["id"])) {
            $app_id = $appInfo["id"];
        } else
            if ($customerInfo != null && isset($customerInfo["id"])) {
                $customer_id = $customerInfo["id"];
            }

        $pagecondition = $pagecondition . "&order=" . $data["order"];

        $config['uri_segment'] = 5;
        // echo $this->uri->segment($config['uri_segment'], 0);
        if ($this->uri->segment($config['uri_segment'], 0)) {
            $data["page"] = $this->uri->segment($config['uri_segment'], 0) / $data["pagesize"] + 1;
        } else {
            if ($data["page"] == "") {
                $data["page"] = 1;
            }
        }
        $options = array();

        $options['cateids'] = $cateid;

        /*
         * if ($mainsection_id != "") {
         * $options ["main_section"] = $mainsection_id;
         * }
         */

        // 分页设置(网页版使用)
        $this->load->library('pagination');
        $config['base_url'] = site_url('goods/getList/');
        $config['suffix'] = $pagecondition;
        $config['total_rows'] = $this->goods_mdl->get_count_with_condition($cateid, array(), $options, null, $app_id, $customer_id, $section_id);
        $config['per_page'] = $data["pagesize"];
        $config['curr_page'] = $data["page"];
        $config['num_links'] = 10;
        $config['full_tag_open'] = '';
        $config['full_tag_close'] = '';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="next"';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="prev"';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        // $config['cur_tag_css'] = 'class="current"';
        $config['cur_tag_open'] = '<a href="javascript:" class="ui-paging-current">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        // print_r($data["pagination"]);

        // 查询产品
        // $count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);
        $options["order"] = $data["order"];
        // echo $data ["pagesize"];
        // echo $data["page"];
        // exit();

        $produtList = $this->goods_mdl->get_lists_with_condition($data["pagesize"], ($data["page"] - 1) * $data["pagesize"], $cateid, array(), $options, 'p.id,p.name,p.short_name,price,goods_thumb', null, $app_id, $customer_id, $section_id);
        // print_r($produtList);
        $data["productList"] = $produtList;
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $data["pagesize"]);

        // 查询频道
        if ($app_id > 0) {} else
            if ($customer_id > 0) {
                $this->load->model('section_mdl');
                $data['sections'] = $this->section_mdl->load_tree($app['id']);
            } else {
                // 平台列表
            }

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('goods/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

/**
     * 商品详情
     * @param number $id 商品id
     * @param number $code 识别是否预览1是0否
     * @param string $activity
     * @param number $activity_num 活动编号
     */
    public function detail($id = 0, $code = 0, $activity = null ,$activity_num = 0)
    {

        $this->load->model('content_mdl');
        $this->load->model('favourites_mdl');
        $this->load->model('attr_mdl');
        $this->load->model('customer_corporation_mdl');
        $this->load->model('order_comments_mdl');
        $this->load->model('product_sku_mdl');
        $this->load->model('demand_mdl');
        $this->load->model('resource_mdl', 'resource');
        $this->load->model('corporation_mdl');
        $this->load->model("tribe_mdl");
        $this->load->model("customer_browsing_history_mdl", "cbh");
        $this->load->model('groupbuy_mdl');

        $app = $this->session->userdata("app_info");
        $customer_id = $this->session->userdata("corp_customerid");
        if(!$customer_id){
            $customer_id = $this->session->userdata('user_id');
        }
        $time = date("Y-m-d H:i:s");//当前时间


        // 获取商品信息
        if($activity){//团购信息
            $select = "a.remarks,a.set_limit,a.least_purchase,a.most_purchase,";
            $data['details'] = $this->goods_mdl->get_by_id($id,$select,null,$activity);
            // nl2br函数处理数据库中未转译换行符
            $data['details']['remarks'] = nl2br(str_replace('\n','<br/>',str_replace('\r','<br/>',str_replace('\r\n','<br/>',$data['details']['remarks']))));
        }else {//普通商品信息

            $data["tribeVIP"] = false;//默认不是部落会员
            //判断是否登录，如果登录则查询商品是否属于我的部落，如果是则使用部落价格。
            if($customer_id){
                //如果是预览则使用企业用户
                $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落
                if($MyTribe){
                    $MyTribe_id = array_column($MyTribe,"id");
                    $data['details'] = $this->tribe_mdl->Whether_my_tribe($id,$MyTribe_id);//查询商品是否属于我的部落
                    if($data['details']){
                        $data["tribeVIP"] = true;//会员
                    }
                }
            }
            //不是部落会员执行
            if(!$data["tribeVIP"]){
                $data['details'] = $this->goods_mdl->load($id);//查询商品信息
            }
        }


        //判断商品是否存在
        if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){//pc
            if(!$data['details']){
                show_404();
            }
        }else{//h5
            if(!$data['details'] || $data['details']['is_on_sale'] != 1){
                redirect('goods/notexist');
                exit;
            }
            if($data['details']["cat_id"] == 104164 && !$data["tribeVIP"]){//共享服务分类104164
                redirect('goods/notexist/1');
                exit;
            }
        }

        //判断是否团购商品，并且登录
        if($activity=='groupbuy' && $data['details']['is_groupbuy'] && !$customer_id){
            $url = site_url("goods/detail/$id/$code/groupbuy");
            $this->session->set_userdata('redirect',$url);
            redirect('customer/login');
            exit();
        }
//         echo "<pre>";
// print_r($data['details']);exit;

        $data['gallery'] = $this->goods_mdl->get_gallery($id);// 商品图片
        $data['product_attr_values'] = $this->attr_mdl->find_product_attr_values($id);// 商品属性

        //sku处理数据 ---------------------------------------------------------------
        $sku = $this->product_sku_mdl->getProductSku($id);//获取商品sku信息
        $skuinfo = array();
        $array = array();
        if($sku){
            foreach ($sku as $v){
                $attr_sku = $v["id"]."_".$v["sku_id"];

                //属性->sku
                if(array_key_exists($v["id"],$array)){
                    if(!array_key_exists($attr_sku,$array[$v["id"]])){
                        $array[$v["id"]]["sku_name"][$attr_sku] = $v["sku_name"];
                    }
                }else{
                    $array[$v["id"]]["attr_name"] = $v["attr_name"];
                    $array[$v["id"]]["sku_name"] = array($attr_sku=>$v["sku_name"]);

                }

                //sku组合信息集
                if(array_key_exists($v["val_id"],$skuinfo)){
                    $skuinfo[$v["val_id"]]["sku"] .= ":".$attr_sku;
                }else{
                    $skuinfo[$v["val_id"]]["sku"] = $attr_sku;
                    $skuinfo[$v["val_id"]]["info"] = array(
                        "stock"=>$v["stock"],
                        "vip_price"=>$v["vip_price"],
                        "plus_no"=>$v["plus_no"],
                        "special_price"=>$v["special_price"],
                        "tribe_price"=>$v["tribe_price"]//部落价格
                    );
                }

            }
        }
        $data["attr_sku"] = $array;//属性->sku
        $data["skuinfo"] = $skuinfo;//sku信息集合
        //sku处理数据结束 ---------------------------------------------------------------


	    $data['fav'] = $this->favourites_mdl->_check_fav($customer_id,$id);// 查询商品收藏
        $data["corporation"] = $this->customer_corporation_mdl->getById($data['details']["corporation_id"]);// 店铺信息

	    //pc端执行
	    if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){
	        $data['cate'] = $this->category_mdl->load($data['details']['cat_id']);//商品分类
	        $data['advisory'] = $this->demand_mdl->get_advisory($id);// 查询留言咨询

            // 查询商品评价
            $data['comments'] = $this->order_comments_mdl->shop_commnet($id, 1); // 商品评价
            $data['all'] = $this->order_comments_mdl->all_commnet($id); // 全部评价
            $data['good'] = $this->order_comments_mdl->good_commnet($id); // 好评
            $data['in'] = $this->order_comments_mdl->in_commnet($id); // 中评
            $data['bad'] = $this->order_comments_mdl->bad_commnet($id); // 差评


            //机构推挤
            $data['recommend'] = $this->resource->log($data['details']["corporation_id"], 3);
            foreach ($data['recommend'] as $k => $v) {
                $data['recommend'][$k]['recommend_language'] = explode(';', $v['recommend_language']);
            }

            $data['introduction'] = $this->corporation_mdl->get_images($data['details']["corporation_id"]);//公司介绍
            $data['corp_amount'] = $this->customer_corporation_mdl->corp_amount($data['details']["corporation_id"]);// 累计销售金额
            $data['month_amount'] = $this->customer_corporation_mdl->corp_amount($data['details']["corporation_id"], 'month');// 近一个月销售额
        }



        //添加商品浏览记录
        if($customer_id){
            $history = $this->cbh->load_by_condition($data['details']['id']);
            if (empty($history['id'])) {
                $this->cbh->customer_id = $customer_id;
                $this->cbh->product_id = $data['details']['id'];
                $this->cbh->p_name = $data['details']['name'];
                $this->cbh->p_price = $data['details']['vip_price'];
                $this->cbh->cate_id = $data['details']['cat_id'];
                $this->cbh->goods_thumb = $data['details']['goods_thumb'];
                $this->cbh->create();
            }
        }

        //判断是否特价商品
        $data["is_special"] = false;
        if ($data['details']['special_price_start_at'] <= $time && $data['details']['special_price_end_at'] >= $time && $data['details']["is_special_price"] == 1) {
            $data["is_special"] = true;
        }

        $data['id'] = $id;//产品id
        $data['head_set'] = 4;//微信
        $data['foot_set'] = 1;
        $data['code'] = $code;//识别是否预览
        $this->load->view('head', $data);
        if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){//pc
             $this->load->view('_header');//H5不加载 
        }
        if($activity=='groupbuy' && $data['details']['is_groupbuy']){
            $data['buy_num'] = $activity_num;
            $order_state = array('4','6','7','9','11','14');//订单状态
            $data['check_group_order'] = $this->groupbuy_mdl->check_group($id, $order_state);
            $this->load->view('groupbuy/groupbuy_detail', $data);
        }else{
            $this->load->view('goods/detail', $data);
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
            $this->load->view('_footer', $data);
        }
        $this->load->view('foot', $data);



    }





    // --------------------------------------------------------------------

    //商品提示
    public function notexist($status = 0){
        switch($status){
            case 1:
                $data['content'] = '您没有权限购买此商品';
                break;
            default:
                $data['content'] = '此商品已下架';
                break;
        }
        $data['title'] = '提示';
        $data['back'] = 'member/info';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;

        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('client/solid_out', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    // --------------------------------------------------------------------

    public function detailapp($id = 0, $app = "android", $userid = 0, $sessionid = 0 , $version = "")
    {
        $this->load->model('content_mdl');
        $this->load->model('favourites_mdl');
        $this->load->model('attr_mdl');
        $this->load->model('customer_corporation_mdl');
        $this->load->model('order_comments_mdl');
        $this->load->model('product_sku_mdl');
        $this->load->model('demand_mdl');
        $this->load->model('resource_mdl', 'resource');
        $this->load->model('corporation_mdl');
        $this->load->model("tribe_mdl");
        $this->load->model("customer_browsing_history_mdl", "cbh");
        $this->load->model('groupbuy_mdl');


        $data["is_vip"] = 0;
        if ($userid != 0) {
            $this->load->model('customer_mdl');
            $user = $this->customer_mdl->get_by_condition(array(
                "id" => $userid
            ));
            if ($user && $user["is_vip"]) {
                $data["is_vip"] = 1;
            }
        }

        $data['app'] = $app;
        $data['details'] = $this->goods_mdl->get_by_id($id);
        //部落价
        $data["tribeVIP"] = false;//默认不是部落会员
        $customer_id = $this->session->userdata("corp_customerid");
        if(!$customer_id){
            $customer_id = $this->session->userdata('user_id');
        }
        //判断是否登录，如果登录则查询商品是否属于我的部落，如果是则使用部落价格。
        if($customer_id){
            $this->load->model("tribe_mdl");
            //如果是预览则使用企业用户
            $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落

            if($MyTribe){
                $MyTribe_id = array_column($MyTribe,"id");
               $goods = $this->tribe_mdl->Whether_my_tribe($id,$MyTribe_id);//查询商品是否属于我的部落
                if($goods){
                    $data['details'] =$goods;
                    $data["tribeVIP"] = true;//会员
                }
            }
        }


        //判断商品是否上架
        if($data['details']['is_on_sale'] != 1 ||  $data['details']["is_delete"] == 1){
            redirect('goods/notexist');
            exit;
        }

        if($data['details']["cat_id"] == 104164 && !$data["tribeVIP"]){//共享服务分类104164
            redirect('goods/notexist/1');
            exit;
        }

        if (! isset($data['details']['id']) && $data['details']['id'] == null) {
            redirect('nofound');
        }
        $data['gallery'] = $this->goods_mdl->get_gallery($data['details']['id']);
        $data['corporate'] = $this->corporation_mdl->load_id($data['details']['corporation_id']);

        // 商品位置定位
        if ($data['details']['longitude'] && $data['details']['latitude']) {
            // 转换腾讯经纬度
            $ip = $this->Convert_BD09_To_GCJ02($data['details']['latitude'], $data['details']['longitude']);
            $data['details']['latitude'] = $ip['lat'];
            $data['details']['longitude'] = $ip['lng'];

            // 逆解析地址
            $json_address = file_get_contents("http://apis.map.qq.com/ws/geocoder/v1/?location=" . $data['details']['latitude'] . "," . $data['details']['longitude'] . "&key=P2KBZ-JF6A5-XORIQ-QFTSG-CKQGS-XEBCK&get_poi=1");
            $address = (json_decode($json_address, true));

            if (isset($address['result']) && $address['result'] != '') {
                $data['city'] = mb_substr($address['result']['address_component']['province'], 0, - 1, 'utf-8') . mb_substr($address['result']['address_component']['city'], 0, - 1, 'utf-8');
            } else {
                $data['city'] = '';
            }
        }

        // 查询SKU
        $this->load->model('product_sku_mdl');
        $result = $this->product_sku_mdl->getSKUByProductid($id);
        $data['skuinfo'] = $result;

        // 截取attr数量
        if(isset($result['skuitem'])){
            $data['attr_name_array'] = array();
            foreach($result['skuitem'] as $k => $v){
                $data['attr_name_array'][$k] = $v['attr_name'];
            }
            $data['attr_name_array'] = array_merge(array_unique($data['attr_name_array']));
            $data['attr_count'] = count($data['attr_name_array']);
        }


        //如果是企业买家才算手续费--
        $this->load->model('Customer_corporation_mdl');
        $customer_id = $this->session->userdata('user_id');
        $corp_detaile = $this->Customer_corporation_mdl->load( $customer_id );

        //获取手续费比率
        if(!empty($corp_detaile)  && $corp_detaile['approval_status'] == 2){//判断企业是否审核通过，通过才收取手续费
            $data['rebate']  = isset($corp_detaile['commission_rate'])? ($corp_detaile['commission_rate']/100):0;
        }else{
            $data['rebate'] = 0;
        }
        $time = date("Y-m-d H:i:s");//当前时间
        //判断是否特价商品
        $data["is_special"] = false;
        if ($data['details']['special_price_start_at'] <= $time && $data['details']['special_price_end_at'] >= $time && $data['details']["is_special_price"] == 1) {
            $data["is_special"] = true;
        }

        // 商品属性
        $this->load->model('attr_mdl');

        $data['product_attr_values'] = $this->attr_mdl->find_product_attr_values((int) $id);
//         echo '<pre>';
//         print_r($data);exit;
        $this->load->view('app/goods_details_backup', $data);
    }

    // --------------------------------------------------------------------

    // 查询商品评价
    function comments()
    {
	    $product_id = $this->input->post("productid");//商品id
	    $status = $this->input->post("status");//0全部1好评2中评3差评
	    //验证数据
	    if(!$product_id || !in_array($status,array(0,1,2,3))){

	        echo json_encode(array());//数据错误
	        exit;
	    }
        switch ($status)
        {
            case 1://好评
                $sift['where']['product_score'] = array(4,5);
                break;
            case 2://中评
                $sift['where']['product_score'] = array(2,3);
                break;
            case 3://差评
                $sift['where']['product_score'] = array(1);
                break;
        }

        $sift['where']['product_id'] = $product_id;
        $this->load->model('order_comments_mdl');
        $data = $this->order_comments_mdl->Shop_Commnet_list( $sift );
        echo json_encode($data);

    }

    // --------------------------------------------------------------------

    // AJAX取数据
    function get_type()
    {
        $ftype = $this->input->get('ftype');
        $f_id = $this->input->get('f_id');
        $type = $this->input->get('type');
        $this->load->model('customer_mdl');
        $msg = array(
            'Result' => true
        );
        if ($name) {
            if ($this->customer_mdl->check_name($name)) {
                $msg = array(
                    'Result' => false
                );
            }
        }
        echo json_encode($msg);
    }

    // --------------------------------------------------------------------
//     private function getViewHistory()
//     {
//         if (isset($_COOKIE['viewhistory'])) {
//             $viewhistory = $_COOKIE['viewhistory'];
//             // echo $viewhistory;
//             $historys = explode(',', substr($viewhistory, 0, strlen($viewhistory) - 1));
//             $result = $this->goods_mdl->get_lists_with_condition(0, 0, 0, array(), array(), 'p.id,p.name,market_price,vip_price,goods_thumb', $historys);
//             $returnresult = array();
//             foreach ($historys as $h) {
//                 foreach ($result as $p) {
//                     if ($p["id"] == $h) {
//                         array_push($returnresult, $p);
//                         break;
//                     }
//                 }
//             }

//             return $returnresult;
//         } else {

//             return array();
//         }
//     }

    // --------------------------------------------------------------------

    /**
     * 旧的，有待废除
     * 搜索
     * 搜索分三种模式
     * 1、只有关键字模式：系统将显示分类列表，以及整个产品库查询
     * 2、只有分类模式：系统将忽略关键字内容，并且深度查询分类
     * 3、有关键字和有分类模式：系统将根据关键字和分类清晰定位数据，筛选显示属性
     *
     * @param $keyword 搜索关键字
     * @param $cateid 搜索类型
     * @param $parentid 只作用于android传isparent值
     */
    public function search_back($cateid = 0,$keyword = null,$corporation_id=0,$cateoffset=0)
    {
       if(!is_numeric($cateid)){
           show_404();
       }
        $options = array();

        $keyword = urldecode($keyword);


        $this->load->model('hot_keywords_mdl');
        $this->load->model('category_mdl', 'category');
        $this->load->model('goods_mdl', 'goods');


        //获取app_id
        $appInfo = $this->session->userdata('app_info');
        if ($appInfo != null && isset($appInfo["id"])) {
            $app_id = $appInfo["id"];
        } else{
            redirect('http://www.51ehw.com');
            exit;
        }

        //如果有搜索就记录，没有就查找最热门的3个关键词作为搜索条件
        if ($keyword == null || $keyword == "" || ctype_space($keyword)) {
            if($cateid==0){
                $hot_keywords = $this->hot_keywords_mdl->get_hot_keywords(3);
                foreach ($hot_keywords as $v) {
                    $keyword .= " " . $v['keyword'];
                }
            }
        } else {
            //记录热门搜索
            $keyword_array = explode(" ", $keyword);
            foreach ($keyword_array as $key => $value) {
                $this->hot_keywords_mdl->add_hot_keywords($value);
            }
        }



        if ($cateid == 0) { // 只有关键字模式
            $data['key_cate'] = $this->goods->get_categorys_with_keyword($keyword);
        }else{ //只有分类模式 or 有关键字和有分类模式
            //查询子分类
            $catids[] = $cateid;
            $row = $this->goods_mdl->get_sub_classification($cateid);
            foreach ($row as $v){
                $catids[] = $v['id'];
            }

        }
        $options['keywords'] = $keyword;
        $data['keyword'] = $keyword;

        //获取酒店专题页酒店等级
        $options['rank'] = $this->input->get("hotelrank");
        $section_id = $this->input->get_post("section_id");

        $data["pagesize"] = 100;//每页显示数量
        $data["order"] = $this->input->get_post("order");
        $pagecondition = "";
        $customer_id = 0;
        if (! empty($section_id)) {
            $pagecondition = "?section_id=" . $section_id;
        }
        $pagecondition = $pagecondition . "&order=" . $data["order"];

        $data["page"] = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        //判断如果没有页数默认一页
        if(0 == $data["page"])
        {
            $data["page"] = 1;
        }
        // 分页设置(网页版使用)
        $this->load->library('pagination');
        // 查询产品
        $options["order"] = $data["order"];



        //查询商品的总条数
        $product_total = $this->goods_mdl->get_count_with_condition(!empty($catids)?$catids:$cateid, array(), $options, null, $app_id, $customer_id, $section_id,$corporation_id);
        //查询商品信息
        $this->goods_mdl->mark = 'search';//商品搜索唯一识别
        $produtList = $this->goods_mdl->get_lists_with_condition($data["pagesize"], ($data["page"] - 1) * $data["pagesize"], !empty($catids)?$catids:$cateid, array(), $options, 'p.id,p.name,p.short_name,price,vip_price,m_price,goods_thumb,oc.comment_total', null, $app_id, $customer_id, $section_id,$corporation_id);


        //获取分类顶级id
        $this->load->model('product_cat_mdl');
        $qur_arr = $this->product_cat_mdl->get_cate($cateid);


        $qur = $this->db->query('select * from 9thleaf_product_cat where id ='.$cateid);
        $qur_arr = $qur->row_array();

        $path = '';
        $path =  trim(isset($qur_arr['path']),',');

        $this->load->model("product_cat_mdl");
        if($path !=''){
            $qur1_arr = $this->product_cat_mdl->get_top_cat($path);
             $data['isparent'] = $qur1_arr['parent_id'];
        }




        $pid = array();
        foreach ($produtList as $v){
            $pid[] = isset($v['id']);
        }

        //只有关键字模式执行
        if($cateid==0 && $keyword){
        //搜索关键词分类下的商品
        $product_cat_total = $this->goods_mdl->get_count_cat_total($keyword,'a.id',null,null,null,$app_id,$pid);
        }else{
            $product_cat_total=0;
        }


        //只有关键字模式执行
        if($cateid==0 && $keyword){
            $parameter = 'a.id, a.name, a.short_name, a.price, a.vip_price, a.m_price, a.goods_thumb, c.width, c.height, c.image_name, c.file_ext,oc.comment_total';
            //判断当前页数是搜索标题的最后一页执行
            if(ceil($product_total / $data["pagesize"])==$data['page']){
                //判断页面显示商品数是不是我要求的每页数量执行
                if(count($produtList)<$data["pagesize"]){
                    $cateoffset = $data["pagesize"]-count($produtList);
                    $cat_array = $this->goods_mdl->get_count_cat_total($keyword,$parameter,$cateoffset,null,1,$app_id,$pid);
                    foreach ($cat_array as $v){
                        $produtList[] = $v;
                    }
                }
            }else if(count($produtList)<$data["pagesize"]){//判断是否少于页面显示的条数
                $cat_array = $this->goods_mdl->get_count_cat_total($keyword,$parameter,$data["pagesize"],$cateoffset,1,$app_id,$pid);
                foreach ($cat_array as $v){
                    $produtList[] = $v;
                }
                $cateoffset = $cateoffset+$data["pagesize"];
            }
        }

        $config['total_rows'] = $product_total+$product_cat_total;
        $config['per_page'] = $data["pagesize"];
        $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
        $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
        $config['num_links'] = 3;
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_css'] = 'class="lPage"';
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        if($cateid==0){//只有关键字模式执行
            $config['base_url'] = site_url('goods/search').'/'.$cateid.'/'.$keyword.'/'.$corporation_id.'/'.$cateoffset.'?/';
        }else{ //只有分类模式 or 有关键字和有分类模式
            $config['base_url'] = site_url('goods/search').'/'.$cateid.'?isparent=/';
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();//执行分页


        $data["productList"] = $produtList;
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $data["pagesize"]);
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        // 查询频道
        if ($app_id > 0) {} else
            if ($customer_id > 0) {
                $this->load->model('section_mdl');
                $data['sections'] = $this->section_mdl->load_tree($app['id']);
            } else {
                // 平台列表
            }

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
//         print_r($data);exit;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('goods/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }


    // --------------------------------------------------------------------
  /**
     * 临时专题文件，迟点会删
     *
     * @param unknown $section_id
     */

    public function zhuanti($section_id = 1, $delete= 0)
    {

//         if($section_id !=3 ){
//                     新版本
            $this->load->model("goods_mdl");
            $this->load->model("category_mdl");
            $this->load->model('attribute_value_mdl');
            $this->load->model('ad_mdl');
            $cat_id = 0;
            $price_status = '';
            $canshu = '';
            $goods_list = true;
            if($delete){
                unset($_GET[$delete]);
            }


            foreach ($_GET as $k => $v){
                if($k != 'per_page'){
                    $canshu .= $k.'='.$v.'&';
                }
            }
            $data['canshu'] = $canshu;
            $price = array();
            $price_status = $this->input->get('price');
            //根据传参赋值
            switch ($section_id) {
                case 1:
                    {
                        $po_sign = "BOOKINDEX";
                        $cat_id = 100000; //书画
                        switch ($price_status){
                            case 1 :
                                $price['to_price'] = '5000';
                                $price['symbol'] = '<';
                                break;
                            case 2 :
                                $price['form_price'] = '5000';
                                $price['to_price'] = '20000';
                                break;
                            case 3 :
                                $price['form_price'] = '20000';
                                $price['to_price'] = '40000';
                                break;
                            case 4 :
                                $price['form_price'] = '40000';
                                $price['to_price'] = '60000';
                                break;
                            case 5 :
                                $price['to_price'] = '60000';
                                $price['symbol'] = '>';
                                break;
                        }

                        $data['title'] = '书画名家_名人字画_艺术收藏_51易货网';
                        $data['KeyWords'] = '书画名家,名人字画,中国书画网,装饰画国画字画,书画艺术收藏,51易货网,交换,以物易物';
                        $data['Description'] = '51易货网提供专业的名人字画，书画，国画，装饰画，无须花钱，用你所有，换你所需。书画、珠宝首饰、食品酒水、餐饮酒店等交易换购，汇集国内知名品牌，质量有保障，担保交易！';
                        $data['type'] = '书画';
                        break;
                    }
                case 2:
                    {
                        $po_sign = "FOODINDEX";
                        $cat_id = 189; //餐饮
                        $data['title'] = '高端餐饮_美食团购_茶馆_会馆_51易货网';
                        $data['KeyWords'] = '餐饮，美食团购，美食优惠券，高端餐饮，51易货网';
                        $data['Description'] = '51易货网提供专业高端餐饮、美食团购、美食优惠券，商务宴请无须花钱，用你所有，换你所需。珠宝首饰、食品酒水、餐饮酒店等交易换购，汇集国内知名品牌，质量有保障，担保交易！';
                        $data['type'] = '餐饮';
                        break;
                    }
                case 3:
                    {
                        $po_sign = "ADINDEX";//banner使用
                        $cat_id = 4324; //广告
                        $data['title'] = '广告资源权威交易平台_广告置换_冠杰广告_51易货网';
                        $data['KeyWords'] = '广告，广告价格，媒体资源，户外广告，单立柱广告，LED广告，电梯广告，广告置换，冠杰广告，西安广告公司';
                        $data['Description'] = '51易货网提供专业的户外媒体资源，户外广告，LED广告，电梯广告，无须花钱，用你所有，换你所需。51易货网提供珠宝首饰、食品酒水、餐饮酒店等交易换购，汇集国内知名品牌，质量有保障，担保交易！';
                        $data['type'] = '广告';
                        break;
                    }
                case 4:
                    {
                        $po_sign = "PLACEINDEX";
                        $cat_id = 4484; //房屋
                        switch ($price_status){
                            case 1 :
                                $price['to_price'] = '300000';
                                $price['symbol'] = '<';
                                break;
                            case 2 :
                                $price['form_price'] = '300000';
                                $price['to_price'] = '700000';
                                break;
                            case 3 :
                                $price['form_price'] = '700000';
                                $price['to_price'] = '900000';
                                break;
                            case 4 :
                                $price['form_price'] = '900000';
                                $price['to_price'] = '1200000';
                                break;
                            case 5 :
                                $price['to_price'] = '1200000';
                                $price['symbol'] = '>';
                                break;
                        }

                        $data['title'] = '西安房价_西安房地产_西安楼盘,楼市,新房,二手房_51易货网';
                        $data['KeyWords'] = '西安房产,西安楼市,楼盘,新房,西安房价,西安买房,二手房,51易货网,交换,以物易物';
                        $data['Description'] = '51易货网提供西安楼盘信息，为西安房市去库存、去产能，免费购房，底价购房，用你所有，换你所需。电话：400-0029-777';
                        $data['type'] = '房屋';
                        break;
                    }
                case 'hotel': //酒店
                    {
                        $po_sign = "HOTELINDEX";
                        $cat_id = 1696;
                        $data['title'] = '酒店_酒店预订_五星豪华酒店_酒店价格查询_51易货网';
                        $data['KeyWords'] = '51易货网,交换,以物易物，酒店，五星/豪华酒店，酒店预订，酒店价格查询，酒店置换';
                        $data['Description'] = '51易货网提供西安酒店预订、酒店报价查询信息，住酒店无须花钱，用你所有，换你所需。汇集国内知名品牌，质量有保障，担保交易！去库存、去产能请到51易货网。电话：400-0029-777';
                        //查询hotel页酒店级别
                        $attr_name = array('酒店级别','酒店等级','酒店星级');
                        $data['hotelRank'] = $this->attribute_value_mdl->getValueByArrtName($attr_name);
                        $data['type'] = '酒店';
                        break;
                    }
                default:
                    echo "<script>history.back(-1);</script>";return;
                    break;

            }

            //查询专题下的所有子级分类－公用
            $cat_ids = $this->category_mdl->get_childcatbyparent($cat_id);
            $cat_ids_string = '';

            if($cat_ids){
                foreach ($cat_ids as $v){
                    $cat_ids_string .= $v['id'].',';
                }
            }
            $cat_ids_string .= $cat_id;

            //查询列表－公用
            $data['classify'] = $this->goods_mdl->get_goods_with_top_category_array($cat_id);


            $app = $this->session->userdata("app_info");

            if($data['classify']){
                foreach ($data['classify'] as $k =>$v){
                    $data['classify'][$k]['option_values'] = explode(';',$v['option_values']);
                }
            }
            $attr_get = $this->input->get();


            //不需要分页参数参数搜索 //$attr_get 里只是属性才参与。
            if(isset($attr_get['per_page']) ){
                unset($attr_get['per_page']);
            }
            //不需要价格区间参与
            if(isset($attr_get['price']) ){
                unset($attr_get['price']);
            }

            //不需要价格区间参与
            if(isset($attr_get['s']) ){
                unset($attr_get['s']);
            }

            $search_val = $this->input->get('s');//搜索参数


            //分页
            $this->load->library('pagination');
            $config['per_page'] = 12;
            $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
            if(0 == $current_page)
            {
                $current_page = 1;
            }
            $offset   = ($current_page - 1 ) * $config['per_page'];

            //统计传过来的属性数量
            if($attr_get){

                $total_attr = count($attr_get);
                $attr_key= array();
                $attr_val= array();


                foreach ($attr_get as $k =>$v){ //把get过来的属性值 key 和 value 赋值。
                    $attr_key[] = $k;
                    $attr_val[] = $v;

                }

                if(!$attr_key || !$attr_val){
                    $data['goods_list'] = $this->goods_mdl->get_cat_property($cat_ids_string, null,$search_val,NULL,$price,$config['per_page'],$offset);
                    $data['total'] = $this->goods_mdl->get_cat_property($cat_ids_string, NULL,$search_val,1,$price);
                }else{
                    //根据属性attr_id 和名称统计属性中的商品
                    $attr_product = $this->attribute_value_mdl->count_list($attr_key,$attr_val,$search_val);

                    if(!$attr_product){ //如果没有该属性商品返回false;
                        $goods_list = false;
                    }

                    $product_string = "";
                    foreach ($attr_product as $v){
                        if($v['num']==$total_attr){//筛选出商品属性和传过来的属性对应的;
                            $product_string .= $v['product_id'].',';
                        }
                    }

                    if(!$product_string){ //否则返回false;
                        $goods_list = false;
                    }

                    if($goods_list){ //如果上面的属性和商品拥有的属性值对应，才查询。

                        $product_string = rtrim($product_string,',');
                        //查询我专题下的所有商品－公用count_list
                        $data['goods_list'] = $this->goods_mdl->get_cat_property($cat_ids_string, $product_string,$search_val,NULL,$price,$config['per_page'],$offset);
                        $data['total'] = $this->goods_mdl->get_cat_property($cat_ids_string, $product_string,$search_val,1,$price);

                    }else{
                        $data['goods_list'] = array();
                        $data['total'] = 0;
                    }
                }
            }else{

                $product_string = "";
                //查询我专题下的所有商品－公用count_list
                $data['goods_list'] = $this->goods_mdl->get_cat_property($cat_ids_string, $product_string,$search_val,NULL,$price,$config['per_page'],$offset);
                $data['total'] = $this->goods_mdl->get_cat_property($cat_ids_string, $product_string,$search_val,1,$price);

            }

            //处理自己的业务逻辑
            switch ($section_id) {
                case 1:
                    {   //书画
                        $attr_get['price'] = $this->input->get('price');
                        switch ($attr_get['price']){ //只是为了让前台显示选择的;
                            case 1 :
                                $attr_get['price'] = '5000以下';
                                break;
                            case 2 :
                                $attr_get['price'] = '5000-20000';
                                break;
                            case 3 :
                                $attr_get['price'] = '20000-40000';
                                break;
                            case 4 :
                                $attr_get['price'] = '40000-60000';
                                break;
                            case 5 :
                                $attr_get['price'] = '60000以上';
                                break;
                            default:
                                unset($attr_get['price']);
                                break;
                        }

                        break;
                    }
                case 2:
                    {

                        break;
                    }
                case 3:
                    {

                        break;
                    }
                case 4: //房屋
                    {
                        $attr_get['price'] = $this->input->get('price');
                        switch ($attr_get['price']){ //只是为了让前台显示选择的;
                            case 1 :
                                $attr_get['price'] = '30万以下';
                                break;
                            case 2 :
                                $attr_get['price'] = '30-70万';
                                break;
                            case 3 :
                                $attr_get['price'] = '70-90万以下';
                                break;
                            case 4 :
                                $attr_get['price'] = '90-120万';
                                break;
                            case 5 :
                                $attr_get['price'] = '120万以上';
                                break;
                            default:
                                unset($attr_get['price']);
                                break;
                        }
                        break;
                    }
            }
           if($search_val)
               $attr_get['s'] = $search_val;
    //         $data['shop_goods_list'] = $this->product_mdl->shop_classify_list($ids,$app_id,$config['per_page'],$offset);
            $config['base_url'] = site_url('goods/zhuanti/'.$section_id).'/?'.$canshu;

            $config['total_rows'] = $data['total'];
            $config['use_page_numbers']   = TRUE;
            $config['page_query_string']  = TRUE;
            $config['num_links'] = 3; //可以看到当前页后面的3页a连接
            $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
            $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
            $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
            $config['prev_tag_css'] = 'class="lPage"';
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['first_link'] = '<<';
            $config['last_link'] = '>>';
            $this->pagination->initialize($config);


            //banner列表
            $data ['banner_list'] = $this->ad_mdl->getBySign ( $po_sign, $app ["id"] );



            $data['cu_page'] = $current_page;
            $data['page'] =  $this->pagination->create_links();
            $data['attr_get'] = $attr_get;
            $data['per_page'] = $config['per_page'];
            //分页结束
    //         echo '<pre>';
    //         var_dump($data['classify']);
            //公告
            $app = $this->session->userdata('app_info');
            $this->load->model('content_mdl');
            $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');

            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('zhuanti/' . $section_id, $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);





    }

    /**
     * 后台店铺分类商品
     * @param number $id;
     * @param number $corporation_id;
     */

    public function shop_goods( $id = '155',$tem_id='2'){
        $this->load->model('template_mdl','tp');
        $this->load->model('section_mdl','section');
        $this->load->model('customer_corporation_mdl');
        $this->load->model('product_mdl');
        $cor_id = $this->session->userdata['corporation_id'];
        $app_id = $this->session->userdata('app_info')['id'];
        $this->product_mdl->corporation_id = $cor_id;
        $data['list'] = $this->tp->select_shop($cor_id,$tem_id);

        $data["corporation"] = $this->customer_corporation_mdl->getById($cor_id);

        $data['menu_list'] = $this->section->shop_classify_list($cor_id,true,$app_id);

        /*
         * 商品处理
         */
        $data['menu_list_all'] = $this->section->shop_classify_list($cor_id,false,$app_id);
//         echo'<pre>';
//         var_Dump($data['menu_list_all']);
        $data['cat_id'] = $this->_level($data['menu_list_all'],$id);
        $ids = array_column($data['cat_id'], 'id');
        $ids[] = $id;



        $data['corp_id'] = $cor_id;
        $data['tem_id'] = $tem_id;

        //分页
        $this->load->library('pagination');
        $config['per_page'] = 10;
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        $offset   = ($current_page - 1 ) * $config['per_page'];
        $data['shop_goods_list'] = $this->product_mdl->shop_classify_list($ids,$app_id,$config['per_page'],$offset);
        $config['base_url'] = site_url('goods/shop_goods/'.$id.'/'.$tem_id).'/?';
        $config['total_rows'] = count($this->product_mdl->shop_classify_list($ids,$app_id) );
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['num_links'] = 3; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_css'] = 'class="lPage"';
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';

        $this->pagination->initialize($config);


        $data['page'] =  $this->pagination->create_links();
        //分页结束

        $this->load->view ( 'head' );
        $this->load->view('shop_header', $data);
        $this->load->view('goods/shop_goods_list',$data);
        $this->load->view ( '_footer' );
        $this->load->view ( 'foot' );
    }

    /**
     * 查询分类下面所有的子菜单
     */
    function _level($arr, $pid=0,$level=0){
    static $tree =  array();
        foreach ($arr as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $tree[] = $v;

                $this->_level($arr,$v['id'],$level+1);

            }

        }
        return $tree;
    }

    /**
     * 旗舰店全部商品查看
     * @param number $cateid
     * @param number $corporation_id
     * @param string $keyword
     */
    public function flagship_shop($cateid = 0, $corporation_id=0,$keyword = null){
        $this->search($cateid, $keyword ,$corporation_id);
    }


    /**
     * 前台店铺分类商品
     * @param number $id;
     * @param number $corporation_id;
     */
    public function shop_class( $id=null ,$corporation_id=null,$temp_id = ''){
        if(empty($corporation_id) || $id==null || $temp_id == null){
            ?>
        <script type="text/javascript">
        <!--
            alert("分类不存在");
            history.back();
        //-->
        </script>

        <?php
        exit;
        }
        $this->load->model('template_mdl','tp');
        $this->load->model('section_mdl','section');
        $this->load->model('customer_corporation_mdl');
        $this->load->model('product_mdl');
        $app_id = $this->session->userdata('app_info')['id'];
        $cor_id = $corporation_id;
        $this->product_mdl->corporation_id = $cor_id;
        $data['list'] = $this->tp->select_shop($cor_id,$temp_id);
        $data["corporation"] = $this->customer_corporation_mdl->getById($cor_id);

        $data['menu_list'] = $this->section->shop_classify_list($cor_id,true,$app_id);

        /*
         * 商品处理
        */
        $data['menu_list_all'] = $this->section->shop_classify_list($cor_id,false,$app_id);
        $data['cat_id'] = $this->_level($data['menu_list_all'],$id);
        $ids = array_column($data['cat_id'], 'id');
        $ids[] = $id;

        $data['status'] = 'customer'; //客户访问
        $data['corp_id'] = $corporation_id;
        $data['tem_id'] = $temp_id;


        $this->load->library('pagination');
        $config['per_page'] = 10;
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        $offset   = ($current_page - 1 ) * $config['per_page'];
        $data['shop_goods_list'] = $this->product_mdl->shop_classify_list($ids,$app_id,$config['per_page'],$offset);
        $config['base_url'] = site_url('goods/shop_class/'.$id.'/'.$corporation_id.'/'.$temp_id).'/?';
        $config['total_rows'] = count($this->product_mdl->shop_classify_list($ids,$app_id) );
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['num_links'] = 3; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_css'] = 'class="lPage"';
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';

        $this->pagination->initialize($config);
        $data['page'] =  $this->pagination->create_links();


        $this->load->view ( 'head' );
        $this->load->view('shop_header', $data);
        $this->load->view('goods/shop_goods_list',$data);
        $this->load->view ( '_footer' );
        $this->load->view ( 'foot' );
    }

    /**
     * ajax发布留言咨询
     * status=1没有id,2没内容,3留言成功,4留言失败
     */
    public function add_advisory(){
        $this->load->model('demand_mdl');
        $user_id = $this->session->userdata('user_id');
        $this->demand_mdl->content = $this->input->post('content');
        $id = $this->input->post('id');
        if(!$id){
            echo json_encode(array('status'=>'1'));
            exit;
        }
        if(!$this->input->post('content')){
            echo json_encode(array('status'=>'2'));
            exit;
        }
        $row = $this->demand_mdl->add_advisory($user_id,$id);
        if($row){
            echo json_encode(array('status'=>'3'));
            exit;
        }else{
            echo json_encode(array('status'=>'4'));
            exit;
        }
    }


    /**
     * 百度经纬度转换腾讯经纬度
     */
    function Convert_BD09_To_GCJ02($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array('lng'=>$lng,'lat'=>$lat);
    }

    //专题页用的搜索方法-分类下搜索
    function Search_Type_Goods($cat_id,$search_val=null){
        $search_val =  urldecode($search_val);
        $this->load->model('goods_mdl');

        $cat_ids = $this->category_mdl->get_childcatbyparent($cat_id);
        $cat_ids_string = '';

        foreach ($cat_ids as $v){
            $cat_ids_string .= $v['id'].',';
        }
        $cat_ids_string .= $cat_id;

        $data["productList"] = $this->goods_mdl->get_cat_property($cat_ids_string,null,$search_val);
        $data['pagination'] = '';
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('goods/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    //将B端产品复制到C端

    //curl_post
    public function curl_pro_result( $url, $data ){
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec ( $ch );
        curl_close ( $ch );

        return($result);
    }

    public function curl_pro_get_result( $url){
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close ( $ch );
        return($result);
    }

    function getImgs($content,$order='ALL'){
        $pattern="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$content,$match);
        if(isset($match[1])&&!empty($match[1])){
            if($order==='ALL'){
                return $match[1];
            }
            if(is_numeric($order)&&isset($match[1][$order])){
                return $match[1][$order];
            }
        }
        return '';
    }

    function copyproduct($id){

        $this->load->model('goods_mdl');
        //link 指向C端customer控制器以便调用接口
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
            //测试
            $link = base_url().'index.php/_CLIENT/Customer/';
        }else{
            //正式
            $link = $this->config->item('c_url').'index.php/_CLIENT/Customer/';
        }
        //uploadlink 指向C端产品文件上传方法
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
            //测试
            $uploadlink = base_url().'index.php/_CLIENT/Uploadimage/img_upload';
        }else{
            //正式
            $uploadlink = $this->config->item('c_url').'index.php/_CLIENT/Uploadimage/img_upload';
        }

        $product = $this->goods_mdl->loadprotoc($id);

        unset($product['id']);//删除id
        //----删除运费
        unset($product['is_freight']);
        unset($product['default_item']);
        unset($product['default_freight']);
        unset($product['add_item']);
        unset($product['add_freight']);
        //----删除运费

        $customer_id = $this->session->userdata('user_id');
        //判断C端是否企业会员还是个人
        //连接指向C端查询用户是否企业方法
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
            //测试
            $links = base_url().'index.php/_CLIENT/Customer/is_corp?customer_id='.$customer_id;
        }else{
            //正式
            $links = $this->config->item('c_url').'index.php/_CLIENT/Customer/is_corp?customer_id='.$customer_id;
        }
        $crop = json_decode($this->curl_pro_get_result($links),true);
        $product['corporation_id'] = $crop['id'];

        $product_sku = $this->goods_mdl->loadskutoc($id);
        $product_img = $this->goods_mdl->loadimgtoc($id);

        $product_attr_val = $this->goods_mdl->loadattrtoc($id);

        $product['is_on_sale']= 0;// 产品设置下架(需在C端重新审核)

        $Msg = array(
            'Result' => false,
            'pro_id'=>null,
            'sku_id'=>null,
            'img_id'=>null,
            'attr_id'=>null,
            'sku_val_id'=>null,
        );
        $product['pro_key'] = 'projiami';//添加商品接口加密处理
        $imgstr = $product['desc'];//商品详情图片拿出来给上传图片用

        //测试
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
            $product['desc'] = str_replace("http://www.test51ehw.com/uploads/B/","http://www.test51ehw.com/uploads/C/",$product['desc']);
        }else{
            //正式
            $product['desc'] = str_replace("http://www.51ehw.com/uploads/B/","http://c.51ehw.com/uploads/C/",$product['desc']);
            $product['desc'] = str_replace("http://images.51ehw.com/B/","http://c.51ehw.com/uploads/C/",$product['desc']);
        }
        //插入商品
        
        $pro = json_decode($this->curl_pro_result($link.'insertpro',$product),true);

        $pro_id = $pro['pro_id'];
        //加载curl 调用C端的上传文件方法
        $this->load->library('copygoods');
        if($pro_id){
            //插入商品详情的图片
            $imginfo = $this->getImgs($imgstr);
            if($imginfo){
                $img_paths = array();
                //测试
                if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
                    foreach ($imginfo as $key =>$val){
                        $imglink =  str_replace("http://www.test51ehw.com/uploads/B/","",$val);
                        array_push($img_paths, $imglink);
                    }
                    $fck_upload = base_url().'index.php/_CLIENT/Uploadimage/fck_upload';
                }else{
                    //正式
                    foreach ($imginfo as $key =>$val){
                        $imglink =  str_replace("http://www.51ehw.com/uploads/B/","",$val);
                        $imglink =  str_replace("http://images.51ehw.com/B/","",$imglink);
                        array_push($img_paths, $imglink);
                    }
                    $fck_upload = $this->config->item('c_url').'index.php/_CLIENT/Uploadimage/fck_upload';
                }

                foreach ($img_paths as $key =>$val){
                    $img_path =FCPATH.UPLOAD_PATH.$val;
                    $this->copygoods->execUpload($img_path,$fck_upload,'image/jpg',$val);
                }
            }

            $attr_id = '';
            //插入商品属性
            if($product_attr_val){
                foreach ($product_attr_val as $kt => $vt){
                    unset($product_attr_val[$kt]['id']);
                    $product_attr_val[$kt]['product_id'] = $pro_id;
                }

                foreach ($product_attr_val as $kt => $vt){
                    $vt['pro_attr'] = 'proattrjiami';//添加商品pro_attr接口加密处理
                    $attr = json_decode( $this->curl_pro_result($link.'insertattr',$vt),true);
                    $attr_id .= $attr['attr_id'].',';
                }
            }

            //插入商品sku
            $sku_val_id = '';
            if(count($product_sku)>0){//是SKU商品
                $val_b = array();//放B端sku_value表ID
                $val_c =  array();//放C端sku_value表ID

                foreach ($product_sku as $k =>$v){
                    unset($product_sku[$k]['id']);
                    $product_sku[$k]['product_id'] =$pro_id ;
                    if($v['val_id']){
                        if(!in_array($v['val_id'],$val_b)){//判断是否已经有该参数，不需要重复的
                            array_push($val_b, $v['val_id']);//SKU详细内容ID组

                            $val_info = $this->goods_mdl->loadsku_valuetoc($v['val_id']);//获取B端SKU详细内容
                            unset($val_info['id']);//删除id
                            $val_info['pro_sku_val'] = 'skuvaljiami';//添加商品SKUval接口加密处理
                            $info_c = json_decode($this->curl_pro_result($link.'insertsku_val',$val_info),true);
                            //添加到C端SKU详细内容表
                            $val_c[$v['val_id']] = $info_c['sku_val_id'];
                            $sku_val_id .= $info_c['sku_val_id'].',';
                        }
                    }
                }

                if(count($val_c) > 0){
                    foreach ($product_sku as $kv =>$vv ){//将$product_sku里面B端val_id替换成C端的val_id
                        foreach ($val_c as $kc => $vc){
                            if($vv['val_id'] == $kc){
                                $product_sku[$kv]['val_id'] = $vc;
                            }
                        }

                    }
                }

                $sku =array();
                $sku_id ='';
                foreach ($product_sku as $k1 =>$v1){
                    $sku[$k1]['product_id'] =$v1['product_id'];
                    $sku[$k1]['attr_id'] =$v1['attr_id'];
                    $sku[$k1]['sku_id'] =$v1['sku_id'];
                    $sku[$k1]['val_id'] =$v1['val_id'];
                    $sku[$k1]['sku_name'] =$v1['sku_name'];
                }

                foreach ($sku as $key =>$val){
                    $val['pro_sku'] = 'skujiami';//添加商品SKU接口加密处理
                    //插入数据id
                    $msg = $this->curl_pro_result($link.'insertsku',$val);
                    $msgs = json_decode($msg,true);
                    $sku_id .= $msgs['sku_id'].',';
                }


            }

            //插入商品缩略图
            if(!empty($product['goods_thumb'])){
                $thumb_path = FCPATH.UPLOAD_PATH.$product['goods_thumb'];
                if(file_exists($thumb_path)){
                    $this->copygoods->execUpload($thumb_path,$uploadlink,'png',$product['goods_thumb']);
                }
            }
            //插入商品图片
            if(count($product_img)>0){

                foreach ($product_img as $k =>$v){
                    unset($product_img[$k]['id']);
                    $product_img[$k]['product_id']= $pro_id;
                    //图片绝对路径
                    $img_path =FCPATH.UPLOAD_PATH.$v['file'];

                    //判断图片是否存在
                    if(file_exists($img_path)){
                        $type = trim($v['file_ext'],',');
                        $this->copygoods->execUpload($img_path,$uploadlink,$type,$v['file']);
                    }else{
                        //如果数据库记录的图片不存在，则删除这条记录
                        // unset($product_img[$k]);
                    }

                }

                $img = array();
                $img_id ='';
                //插入数据id
                foreach ($product_img as $k1 =>$v1){
                    $img[$k1]['product_id'] =$v1['product_id'];
                    $img[$k1]['image_name'] =$v1['image_name'];
                    $img[$k1]['file'] =$v1['file'];
                    $img[$k1]['file_ext'] =$v1['file_ext'];
                    $img[$k1]['file_mime'] =$v1['file_mime'];
                    $img[$k1]['width'] =$v1['width'];
                    $img[$k1]['height'] =$v1['height'];
                    $img[$k1]['file_size'] =$v1['file_size'];
                    $img[$k1]['is_base'] =$v1['is_base'];
                    $img[$k1]['sort_order'] =$v1['sort_order'];
                    $img[$k1]['created_at'] =$v1['created_at'];
                    $img[$k1]['updated_at'] =$v1['updated_at'];
                    $img[$k1]['original_name'] =$v1['original_name'];
                    $img[$k1]['client_name'] =$v1['client_name'];

                }
                foreach ($img as $key => $val){
                    $val['pro_img'] = 'proimgjiami';//添加商品pro_img接口加密处理
                    $msg = $this->curl_pro_result($link.'insertimg',$val);
                    $msgs = json_decode($msg,true);
                    $img_id .= $msgs['img_id'].',';
                }

            }
            $Msg = array(
                'Result' => true,
                'pro_id'=>$pro_id,
                'sku_id'=>isset($sku_id)?$sku_id:null,
                'img_id'=>isset($img_id)?$img_id:null,
                'attr_id'=>isset($attr_id)?$attr_id:null,
                'sku_val_id'=>isset($sku_val_id)?$sku_val_id:null,
            );
            echo json_encode($Msg);
            return;
        }

        echo json_encode($Msg);

    }

    // -------------------------------------------------------------------

    /**
     * 搜索
     * 搜索分三种模式
     * 模式1：只有分类模式：系统将忽略关键字内容，并且深度查询分类
     * 模式2：关键字搜索商品+关键词搜索分类,并且深度查询分类模式：排序关键词商品－>分类商品，系统将显示分类列表，以及整个产品库查询，排除仅部落显示的商品
     * 模式3：有关键字和有分类,并且深度查询分类模式：系统将根据关键字和分类清晰定位数据，筛选显示属性
     * @param $cateid 分类id
     * @param $keyword 搜索关键字
     */
    public function search($cateid = 0,$keyword = null)
    {
        $keyword = urldecode($keyword);
        //判断是否非法操作
        if(!is_numeric($cateid) || $cateid<0){
            show_404();
            exit();
        }else{
            $cateid_array[] = $cateid;//分类id

            //拼接参数
            $sequence = $this->input->get('sequence');
            $data['sequence_url'] =  $sequence  ? explode("_",$sequence): '';
            $customer_id = $this->session->userdata("user_id");//用户id
            $this->sift_sequence( $data['sequence_url'] );


            $page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
            //判断如果没有页数默认一页
            if(0 == $page)
            {
                $page = 1;
            }
            $limit = 50;//每页显示数量
            $offset = ($page-1)*$limit;


        if(!empty($cateid) && empty($keyword)){//模式1
            $catid_array = $this->goods_mdl->get_son_cateid($cateid_array);//查询子分类id
            $productList = $this->goods_mdl->get_productOne($catid_array,$limit,$offset);//查询商品
            $productTotal = $this->goods_mdl->get_productOne($catid_array);//商品数量
        }else{
            $keyword_array = $this->_hot_keywords($keyword,1);//记录搜索关键词,如果没有则把最热门的3个关键词作为搜索
            if($cateid==0){//模式2
                $catid_array = $this->goods_mdl->get_class($keyword_array);//关键词查询分类
                if($catid_array){
                    $catid_array = $this->goods_mdl->get_son_cateid($catid_array);//查询子分类id
                }
                $productList = $this->goods_mdl->get_productTow($keyword_array,$catid_array,$limit,$offset);//查询商品
                $productTotal = $this->goods_mdl->get_productTow($keyword_array,$catid_array);//商品数量

            }else{//模式3
                $catid_array = $this->goods_mdl->get_son_cateid($cateid_array);//查询子分类id
                $productList = $this->goods_mdl->get_productThree($keyword_array,$catid_array,$limit,$offset);//查询商品
                $productTotal = $this->goods_mdl->get_productThree($keyword_array,$catid_array);//商品数量
            }

        }



            //分页
            $this->load->library('pagination');
            $config['total_rows'] = $productTotal;
            $config['per_page'] = $limit;
            $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
            $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
            $config['num_links'] = 3;
            $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
            $config['cur_tag_close'] = '</a>';
            $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
            $config['prev_tag_css'] = 'class="lPage"';
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;
            if($cateid>0 && empty($keyword)){//模式1
                $config['base_url'] = site_url('goods/search').'/'.$cateid.'?';
            }else{//模式2or模式3
                $config['base_url'] = site_url('goods/search').'/'.$cateid.'/'.$keyword.'?';
            }
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();//执行分页


            //公告
            $app = $this->session->userdata('app_info');
            $this->load->model('content_mdl');
            $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');

            $data['parameter_url'] = $config['base_url'];
            $data['productList'] = $productList;


            $data['keyword'] = $keyword;//搜索关键词
            $data['title'] = $this->session->userdata('app_info')['app_name'];
            $data['head_set'] = 3;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('goods/list', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);

        }
    }





    public function activity(){

        $data['title'] = '商品活动';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $this->load->view('active_index', $data);
    }

    //商品搜索筛选
    private function sift_sequence( $sequence )
    {
        //判断SQL字段
        if( $sequence && count($sequence>=2) )
        {
            $sequence_sql = array();
            $sequence_product = $sequence[1] == 'top' ? 'desc' : 'asc';

            switch ($sequence[0])
            {
                case 'price':
                    $sequence_sql = array('key'=>'vip_price','sequence'=>$sequence_product);
                    break;
                case 'comment':
                    $sequence_sql = array('key'=>'comment','sequence'=>$sequence_product);
                    break;
                case 'sales':
                    $sequence_sql = array('key'=>'sales','sequence'=>$sequence_product);
                    break;
            }

            if( $sequence_sql )
                $this->goods_mdl->sequence = $sequence_sql;

        }
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
        if ($keyword == '0' || $keyword && isset($keyword) && !empty($keyword) && $keyword != null && $keyword != "") {//有关键词
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

    // -----------------------------------------------------------------------

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */