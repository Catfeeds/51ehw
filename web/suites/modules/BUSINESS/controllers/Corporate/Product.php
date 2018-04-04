<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 * 产品管理控制器
 *
 * 包含增删改查产品以及产品附属的图片、SKU等属性管理
 *
 * @author Clark So
 * @copyright Copyright © 2010-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Product extends Front_Controller {

	// --------------------------------------------------------------------

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		$this->load->model ( 'customer_mdl' );
		$this->load->model ( 'corporation_mdl' );
		$this->load->model ( 'customer_corporation_mdl' );
		$this->load->model ( 'product_mdl' );
	}
	
    // --------------------------------------------------------------------

    /**
     * 商品列表
     * @param string $type 类型:sale销售中，notsale待发布,not已售罄 (默认全部)
     */
	public function get_list($type=null)
	{
	    
	    //验证权限
	    $corp_user = $this->session->userdata("corp_user");//识别是否店主
	    $power = $this->session->userdata("power");//权限
	    if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
	        echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
	    }
	    
        $corporation_id = $this->session->userdata("corporation_id");//企业id
        
        if( !$corporation_id )
        {
            redirect('Corporation/home_page');
            exit();
        
        }
        
        $customer_id = $this->session->userdata('user_id');
        $appInfo = $this->session->userdata('appInfo');
        $data["types"] = $type;//类型
        $data['search'] = $search_name = $this->input->get('search_name');//搜索关键词


        //判断C端是否企业会员还是个人
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
            //测试
            $link = base_url().'index.php/_CLIENT/Customer/is_corp?customer_id='.$customer_id;
        }else{
            //正式
            $link = $this->config->item('c_url').'index.php/_CLIENT/Customer/is_corp?customer_id='.$customer_id;
        }
        $msg = $this->curl_get_result($link);
        $Msg = json_decode($msg,true);
        $status = $Msg['status'];
        if($status){
            $is_customer = true;
        }else{
            $is_customer = false;
        }
        $data['is_customer'] =$is_customer;
        
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        $data["pagesize"] = 15;//显示条数
        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $data["pagesize"];
        // 分页设置(网页版使用)
        $this->load->library('pagination');
        if (! empty($type)) {
            $config['base_url'] = site_url('corporate/product/get_list/' . $type . '/?');
        } else{
            if (! empty($search_name)) {
                $config['base_url'] = site_url('corporate/product/get_list/?');
                $config['base_url'] .= '&search_name=' . $search_name;
            } else{
                $config['base_url'] = site_url('corporate/product/get_list/?');
            }
        }
        $config['uri_segment'] = 5;
        $config['curr_page'] = $current_page;
        $config['suffix'] = FALSE;
        $config['total_rows'] = $this->product_mdl->getgoodsList($corporation_id,0,0,$type,$search_name);
        $config['per_page'] = $data["pagesize"];
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 10;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $current_page;

        $data['all_count'] = $this->product_mdl->getgoodsList($corporation_id,0,0);//全部
        $data['not'] = $this->product_mdl->getgoodsList($corporation_id,0,0,'not');//已售罄
        $data['notsale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"notsale");//待发布
        $data['sale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"sale");//销售中

        $data["productList"] = $this->product_mdl->getgoodsList($corporation_id,$config['per_page'],$offset,$type,$search_name);//商品列表
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $data["pagesize"]);

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/product/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 新建产品，选择分类
     */
    public function create()
    {
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        $corporation_id = $this->session->userdata('corporation_id');

        if( !$corporation_id )
        {
            redirect('Corporation/home_page');
            exit();
        
        }
        
        $this->load->model('category_mdl');

        //判断是否有权限设置共享服务商品
        $corporation = $this->corporation_mdl->load_corp_info($corporation_id);//查询企业信息
        if(!$corporation['is_service']){
            $data['categorys'] = $this->category_mdl->get_child(0,0,104164);//查询分类  #共享服务分类104164
        }else{
            $data['categorys'] = $this->category_mdl->get_child(0,0);//查询分类
        }
        
        //左侧导航栏
        $data['all_count'] = $this->product_mdl->getgoodsList($corporation_id,0,0);//全部
        $data['not'] = $this->product_mdl->getgoodsList($corporation_id,0,0,'not');//已售罄
        $data['notsale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"notsale");//待发布
        $data['sale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"sale");//销售中
        $data['types'] = "create_product";

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/product/create', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

    /**
     * ajax获取分类
     */
    function getChildCategory()
    {
        $id = $this->input->post('id');
        $this->load->model('category_mdl');
        $result = $this->category_mdl->get_child(0, $id);
        print_r(json_encode($result));
    }
    
    /**
     * 发布商品页面搜索商品分类
     */
    function getChildCatename(){
        $name = $this->input->get_post("cate_name");
        
        $this->load->model('category_mdl');
        $result = $this->category_mdl->getchildbyname($name);
        $res = "";
        if (count($result) > 0) {
            foreach ($result as $k => $r) {
                $parent_id = explode(",", $r["path"]);
                if (count($parent_id) > 0) {
                    foreach ($parent_id as $key => $p) {
                        $catename = $this->category_mdl->load($p);
                        if (! empty($catename)) {
                            $res[$k][] = $catename;
                        }
                    }
                }
            }
        }
        $data = array(
            "list" => $res
        );
        print_r(json_encode($data));
    }
    
    // --------------------------------------------------------------------


    /**
     * 编辑商品
     * @param int $id 商品id
     * @param int $cid 分类id
     */
    function edit($id = 0, $cid = 0)
    {
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/edit,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
    
        $corporation_id = $this->session->userdata('corporation_id');//企业id
    
        if( !$corporation_id )
        {
            redirect('Corporation/home_page');
            exit();
        
        }
        
        //删除session未保存的图片
        $img =  $this->session->userdata("temp_image")?$this->session->userdata("temp_image"):array();
        if(count($img)>0){
            foreach ($img as $v){
                $v = FCPATH . $v;
                file_exists($v)?unlink($v):'';
            }
            $this->session->unset_userdata("temp_image");
        }
        
        $this->load->model('category_mdl');
        $this->load->model('product_cat_mdl');
        $this->load->model("product_tribe_mdl");
        $this->load->model('image_mdl');
        $this->load->model('section_mdl');
        $this->load->model("tribe_mdl");
        $this->load->helper('ps_helper');
        
        $corporation = $this->corporation_mdl->load_corp_info($corporation_id);//查询企业信息
        if($cid==104164){#共享服务分类104164
            if(!$corporation['is_service']){//判断是否有权限设置共享服务商品
                echo "<script>history.back(-1);</script>";exit;
            }
        }

        $data['tribe_id'] = array();//部落id
        if ($id != 0) {//更新
            $data['editing'] = $this->product_mdl->load($id);
            if (! $data['editing']) {
                show_404();
            }
            $cid = $data['editing']["cat_id"];
    

            // 预备处理商品属性
            $attr_list = array();
            foreach ($data['editing']['attr_list'] as $key => $attr) {
                $attr_list[$attr['id']]['id'] = $attr['id'];
                $attr_list[$attr['id']]['attr_name'] = $attr['attr_name'];
                $attr_list[$attr['id']]['attr_type'] = $attr['attr_type'];
                $attr_list[$attr['id']]['option_values'] = $attr['option_values'];
                $attr_list[$attr['id']]['attr_value'] = $attr['attr_value'];
                $attr_list[$attr['id']]['option_values_array'] = $attr['option_values_array'];
                if ($attr['attr_type'] == 'checkbox') {
                    $attr_list[$attr['id']]['attr_values'][] = $attr['attr_value'];
                }
            }
            $data['editing']['attr_list'] = $attr_list;
            $data['title'] = '编辑商品(ID:' . $data['editing']['id'] . ')';
            
            $data['images'] = $this->image_mdl->findProductImages($id);//查询商品图片
            
            //查询产品所属部落
             $goodstribe = $this->product_tribe_mdl->get_TribeProduct($id);
             $tribe_id = array_column($goodstribe,"tribe_id");
             $data['tribe_id'] = $tribe_id;

        } else {//创建
            $id = 0;
            $data['title'] = '添加商品';
        }

        $cat = $this->category_mdl->load($cid);//查询分类
        if(!$cat){
            echo "<script>history.back(-1);</script>";exit;
        }

        //查询属性
        $path =  trim($cat['path'],',');//分类路径
        if($cat['level'] == '1'){  //如果该分类是顶级就查顶级属性
            $data['attributes'] = $this->build_attr_html($cid, $id);
        }else{
            $cat_row = $this->product_cat_mdl->get_top_cat($path);//根据路径得到顶级分类
            $cid_array = array($cid,$cat_row['id']);
            $data['attributes'] = $this->build_attr_html($cid_array, $id);
        }

        //查询商品类目
        $category = $cat["name"];
        while ($cat["parent_id"] != 0) {
            $cat = $this->category_mdl->load($cat["parent_id"]);
            $category = $cat["name"] . " > " . $category;
        }
        $data["category"] = $category;
    
        // 创建 编辑器
        $this->load->library('fckeditor');
        $this->fckeditor->BasePath = base_url() . 'fck/';
        $this->fckeditor->InstanceName = 'desc';
        $this->fckeditor->Height = '300';
        $this->fckeditor->ToolbarSet = 'Normal';
        $this->fckeditor->Value = !empty($data['editing']['desc'])?$data['editing']['desc']:null;
        $data['fckeditor'] = $this->fckeditor->CreateHtml();
    
        //左侧导航栏
        $data['all_count'] = $this->product_mdl->getgoodsList($corporation_id,0,0);//全部
        $data['not'] = $this->product_mdl->getgoodsList($corporation_id,0,0,'not');//已售罄
        $data['notsale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"notsale");//待发布
        $data['sale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"sale");//销售中
        $data['types'] = "create_product";
    
        // 查询频道
        $data['sections'] = $this->section_mdl->get_list(0, - 1, 0, $this->session->userdata['corporation_id']);
        
        
        $data["mytribe"] = $this->tribe_mdl->MyTribe($corporation['customer_id']);//加入的部落
        
        
        $data['cid'] = $cid;//分类id
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/product/edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 商品属性生成 ajax(已不需要AJAX取)
     */
    private function build_attr_html($attr_set_id, $productid)
    {
        
    
        $this->load->model('attribute_mdl');
        $this->load->model('attribute_value_mdl');
        $this->load->model('sign_mdl');
        $this->load->model('product_sku_mdl');
        $attributes = $this->attribute_mdl->find_attrs_by_attr_set($attr_set_id);
        $skuinfo = $this->product_sku_mdl->getSKUByProductid($productid);//选中的sku
        foreach ($attributes as $key => $attribute) {
    
            $attributes[$key]['option_values_array'] = array(); 
            if ($attribute['attr_type'] == 'sku') {
                // SKU相关
                if (! empty($attribute['option_values'])) {
                    $attributes[$key]['option_values_array'] = explode(";", $attribute['option_values']);
                }
    

                $attributes[$key]['check'] = '';
                if ($skuinfo != null) {
                    foreach ($skuinfo['skuitem'] as $val){
                        if($val['attr_id']==$attributes[$key]['id']){
                            $attributes[$key]['check'] = true;
                        }
                    }
                    $attributes[$key]['default_value'] = $skuinfo;
                } else {
                    $attributes[$key]['default_value'] = array();
                }
//                                 echo '<pre>';
//                                 print_r($attributes);exit;
            } else{
                if ($attribute['attr_type'] == 'related') {
                    // 关联
                    $attributes[$key]['option_values_array'] = $this->sign_mdl->get_sign_for_selete($attribute['default_value']);
                } else {
                    // 除关联外
                    // 取DEFAULT值
                    if ($attribute['attr_type'] == 'checkbox') {
                        // 返回数组
                        if ($productid != null && $productid != '') {
                            $default_attr = $this->attribute_value_mdl->findByProductAttr($productid, $attribute['id']);
                        } else {
                            $default_attr = array();
                        }
    
                        $attributes[$key]['default_value'] = $default_attr;
//                         print_r($attributes[$key]['default_value']);exit;
                    } else {
                        if ($productid != null && $productid != '') {
                            // 返回数值
                            $default_attr = $this->attribute_value_mdl->findByProductAttr($productid, $attribute['id']);
                            if ($default_attr != null) {
                                $attributes[$key]['default_value'] = $default_attr[0]["attr_value"];
                                
                            }
                        }
                    }
                    if (! empty($attribute['option_values'])) {
                        $attributes[$key]['option_values_array'] = explode(";", $attribute['option_values']);
                    }
                }
            }
        }
//                 echo '<pre>';
//                 print_r($attributes);exit;
        return $attributes;
    
    }
    
// ----------------------------------------------------------------------------------

    /**
     * 图片上传方法
     *
     * @param int $id
     */
    public function file_upload()
    {
        try {

            $this->load->helper("ps_helper");

            $customer_id = $this->session->userdata('user_id');

            // 商品图片缩略图尺寸
            $sizes = array(
                array(
                    '270',
                    '270'
                ),
                array(
                    '290',
                    '365'
                ),
                array(
                    '670',
                    '844'
                )
            );
            $count = count($sizes);//统计生成多少张缩略图

            $save_path = 'photos/' . date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 'product/' . $id . '/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (!file_exists($path)){
                mkdirsByPath($path);//创建文件
            }

            $config['file_name'] = $customer_id . '_' . date("YmdHis");
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            // 图片
            if (! empty($_FILES)){
                $n = count($_FILES['file']['name']);
            }else{
                $n = 0;
            }

            if ($n) {

                foreach ($_FILES['file'] as $key => $val){
                    for ($i = 0; $i < $n; $i ++) {
                        $_FILES['file' . $i][$key] = $val[$i];
                    }
                }

                $images = array();

                for ($j = 0; $j < $n; $j ++) {

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {

                        $uploaded = $this->upload->data();
                        $images[$j]['image_name'] = "uploads/" . $save_path . $uploaded['raw_name'];
                        $images[$j]['file'] = "uploads/" . $save_path . $uploaded['file_name'];
                        $images[$j]['file_ext'] = $uploaded['file_ext'];
                        $images[$j]['file_mime'] = $uploaded['file_type'];
                        $images[$j]['width'] = $uploaded['image_width'];
                        $images[$j]['height'] = $uploaded['image_height'];
                        $images[$j]['file_size'] = $uploaded['file_size'];
                        $images[$j]['original_name'] = $uploaded['orig_name'];
                        $images[$j]['client_name'] = $uploaded['client_name'];

                        $all_images[] = $images[$j];
                        if (!empty($this->session->userdata("temp_image"))) {
                            $session = $this->session->userdata("temp_image");
                            foreach ($session as $val){
                                $all_images[] = $val;
                            }
                        }

                        $this->session->set_userdata("temp_image", $all_images);

                        for($i=0;$i<$count;$i++){

                            $configs['image_library'] = 'gd2';
                            $configs['source_image'] = FCPATH .UPLOAD_PATH.$images[$j]['file'];//原图
                            $configs['new_image'] = FCPATH .UPLOAD_PATH.$images[$j]['file'];//原图的生成的图片，全路径或者相对路径
                            $configs['thumb_marker'] = '_'.$sizes[$i][0];
                            $configs['create_thumb'] = TRUE;
                            $configs['maintain_ratio'] = TRUE;
                            $configs['width']     = $sizes[$i][0];
                            $configs['height']   = $sizes[$i][1];

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($configs);
                            if ( ! $this->image_lib->resize())
                            {
                                error_log("缩略图生成失败，原因：" . $this->image_lib->display_errors());
                                echo json_encode(array('status'=>'1',"message"=>'缩略图生成失败'));exit;
                            }
                        }
                        
                        echo json_encode(array('status'=>'2',"message"=>'上传成功'));exit;
                    } else {
                        
                        error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                        echo json_encode(array('status'=>'1',"message"=>'上传文件失败'));exit;
                    }

                }

            }
        } catch (Exception $e) {
            error_log($e);
            echo json_encode(array('status'=>'1',"message"=>'没有上传文件'));exit;
        }
    }

    // ---------------------------------------------------------------------------------------------------------------
    
    /**
     * 新建产品or修改产品
     */
    public function save(){
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        $this->load->model("tribe_mdl");
        $this->load->model('image_mdl');
        $this->load->model('attribute_value_mdl');
        $this->load->model('attribute_mdl');
        $this->load->model("product_tribe_mdl");
        $this->load->model('product_sku_mdl');
        $this->load->model("product_tribe_mdl");

        $customer_id = $this->session->userdata('user_id');//用户id
        $all_images = $this->session->userdata("temp_image");//上传的图片
        $corporation_id = $this->session->userdata('corporation_id');//企业id
        $appid = $this->session->userdata("app_info")['id'];
        
        if( !$corporation_id )
        {
            redirect('Corporation/home_page');
            exit();
        
        }
        
        //查询加入的部落
        $mytribe = $this->tribe_mdl->MyTribe($customer_id);
        
        $fav_count = $this->input->post('fav_count');//默认收藏数
        $sales_count = $this->input->post('sales_count');//默认销售量
        $cat_id = $this->input->post('cat_id');//分类id
        $name = $this->input->post('name');//商品名称
        $stock = $this->input->post('stock');//总库存
        $vip_price = $this->input->post('vip_price');//易货价
        $is_on_sale = $this->input->post('is_on_sale');//是否上架
        $app_id = $this->input->post("app_id")?$appid:0;//发布站点
        $is_reveal = $this->input->post("is_reveal")?1:0;//是否部落显示1是，默认否
        $tribeid = $this->input->post("tribeid");//部落id
        $tribe_price = $mytribe?$this->input->post("tribe_price"):0;//部落价格
        $product_id = $this->input->post('id');//产品id
        $productnum = $this->input->post('productnum');//产品编码
        $short_desc = $this->input->post('short_desc');//简短描述
        $desc = $this->input->post('desc');//商品描述
        $meta_title = $this->input->post('meta_title');//Meta标题
        $meta_keywords = $this->input->post('meta_keywords');//Meta关键字
        $meta_desc = $this->input->post('meta_desc');//Meta描述
        $section_id = $this->input->post('section_id');//判断
        $attr_values = $this->input->post('attr_values');//属性集合
        $address = $this->input->post('address');//地址
        $longitude = $this->input->post('longitude');//经度
        $latitude = $this->input->post('latitude');//维度
        $type = $this->input->post('type');//类型
        $unit = $this->input->post('unit');//单位

        //运费
        $is_freight = $this->input->post('is_freight'); //设置是否运费
        $default_item = $this->input->post('default_item');//默认多少件内使用默认的运费
        $default_freight = $this->input->post('default_freight');//默认运费
        $add_item = $this->input->post('add_item');//每增加多少件
        $add_freight = $this->input->post('add_freight');//每增加X件使用运费
        
        // SKU相关的
        $sku_ids = $this->input->post('skuids');//skuid集合
        $sku_m_price = $this->input->post('sku_m_price');//sku价格集合
        $skustore = $this->input->post('skustore');//sku库存集合
        $skunum = $this->input->post('skunum');//sku编码集合
        $sku_special_offer = $this->input->post('sku_special_offer');//sku特价集合
        $sku_tribe_price = $this->input->post('sku_tribe_price');//sku部落价集合
        
        //特价
        $special_price = $this->input->post('special_price');//特价价格
        $is_special_price = $this->input->post('is_special_price');//是否设置特价
        $special_price_start_at = $this->input->post('special_price_start_at');//特价开始时间
        $special_price_end_at = $this->input->post('special_price_end_at');//特价结束时间
        

        $datetime = date("Y-m-d H:i:s");



        //如果有sku,重新计算总库存
        if ($sku_ids) {
            $stock = 0;
            //循环添加sku信息
            foreach ($sku_ids as $key => $sid) {
                $stock += !empty($skustore[$key])?$skustore[$key]:0;
            }
        }
        
        //查询企业信息
        $corporation = $this->corporation_mdl->load_corp_info($corporation_id);
        
        //判断是否有权限设置共享服务商品
        if($cat_id==104164){#共享服务分类104164
            if(!$corporation['is_service']){//判断是否有权限设置共享服务商品
                echo "<script>history.back(-1);</script>";exit;
            }
            
            //如共享服务默认参数
            $vip_price = 0;//易货价
            $is_reveal = 1;//是否部落显示1是，默认否
            $stock = 999999;//库存
            $special_price = 0;//是否特价
            $is_freight = 0;//是否设置运费
            
        }
        
        
        //数据集合
        $productdata['fav_count'] = $fav_count;//默认收藏数
        $productdata['sales_count'] = $sales_count;//默认销售量
        $productdata['name'] = $name;//商品名称
        $productdata['stock'] = $stock;//总库存
        $productdata['vip_price'] = $vip_price;//易货价
        $productdata['is_on_sale'] = $is_on_sale?2:0;//是否上架
        $productdata['app_id'] = $app_id;//发布站点
        $productdata['is_reveal'] = $is_reveal;//是否部落显示1是，默认否
        $productdata['tribe_price'] = $tribe_price?$tribe_price:0;//部落价格
        $productdata['productnum'] = $productnum;//产品编码
        $productdata['short_desc'] = $short_desc;//简短描述
        $productdata['desc'] = $desc;//商品描述
        $productdata['meta_title'] = $meta_title;//Meta标题
        $productdata['meta_keywords'] = $meta_keywords;//Meta关键字
        $productdata['meta_desc'] = $meta_desc;//Meta描述
        $productdata['section_ids'] = $section_id?"," . implode(",", $section_id) . "," : 0;//频道
        $productdata['address'] = $address;//地址
        $productdata['longitude'] = $longitude?$longitude:null;//经度
        $productdata['latitude'] = $latitude?$latitude:null;//维度
        $productdata['updated_at'] = $datetime;//更新时间
        $productdata["unit"] = $unit;//单位
        if(!empty($all_images[0]['file'])){
            $productdata['goods_thumb'] = $all_images[0]['file'];//图片
            $productdata['goods_img'] = $all_images[0]['file'];//图片
        }
        $productdata["customer_id"] = $customer_id;//发布者id
        if(!$product_id){
            $productdata['created_at'] = $datetime;//创建时间
            $productdata["corporation_id"] = $corporation_id;//企业id
            $productdata['cat_id'] = $cat_id;//分类id
        }
        //运费
        $productdata['is_freight'] = $is_freight; //设置是否运费
        if($productdata['is_freight']){
            $productdata['default_item'] = $default_item;//默认多少件内使用默认的运费
            $productdata['default_freight'] = $default_freight;//默认运费
            $productdata['add_item'] = $add_item;//每增加多少件
            $productdata['add_freight'] = $add_freight;//每增加X件使用运费
        }
        //特价
        $productdata['is_special_price'] = $is_special_price?1:0;//是否设置特价
        $productdata['special_price'] = $special_price;//特价价格
        if($productdata['is_special_price']){
            $productdata['special_price_start_at'] = $special_price_start_at;//特价开始时间
            $productdata['special_price_end_at'] = $special_price_end_at;//特价结束时间
        }
        
        $this->db->trans_begin();//开启事务
        $flag = true;//识别商品是否需要添加到product_tribe列表
        if($product_id){//更新
            
            //更新产品
            $result = $this->product_mdl->save($product_id,$productdata);
            if(!$result){
                $this->db->trans_rollback();
                echo "更新产品失败";exit;
            }
            

            //删除产品属性
            $result = $this->attribute_value_mdl->delete_attr($product_id);
            if(!$result){
                $this->db->trans_rollback();
                echo "删除产品属性失败";exit;
            }
            
            
            //删除商品sku_val
            $result = $this->product_sku_mdl->del_product_sku_val($product_id);
            if(!$result){
                $this->db->trans_rollback();
                echo "删除sku_val失败";exit;
            }
    
            //删除商品sku
            $result = $this->product_sku_mdl->del_product_sku($product_id);
            if(!$result){
                $this->db->trans_rollback();
                echo "删除sku失败";exit;
            }
            
            //部落删除部落
            $product_tribe = $this->product_tribe_mdl->get_TribeProduct($product_id);//查询商品所属的部落
            if($product_tribe){
                if($tribeid){
                    foreach ($product_tribe as $k => $v){
                        if(in_array($v["tribe_id"],$tribeid)){
                            $tribeid = array_flip($tribeid);
                            unset($tribeid[$v["tribe_id"]]);
                            $tribeid = array_flip($tribeid);
                        }else{
                            $result = $this->product_tribe_mdl->del($product_id,$v["tribe_id"]);
                            if(!$result){
                                $this->db->trans_rollback();
                                echo "删除部落失败";exit;
                            }
                        }
                    }
                    if(!$tribeid){
                        $flag = false;
                    }
                }else{
                    $result = $this->product_tribe_mdl->del($product_id);
                    if(!$result){
                        $this->db->trans_rollback();
                        echo "删除商品所有部落失败";exit;
                    }
                }
            }

        }else{//创建
            //添加产品图片
            if (!$all_images) {
                echo "添加图片不存在";exit;
            }

            $product_id = $this->product_mdl->add($productdata);//添加产品
            if(!$product_id){
                $this->db->trans_rollback();
                echo "添加产品失败";exit;
            }
        }
        
        //如果有sku
        if ($sku_ids) {
            //循环添加sku信息
            foreach ($sku_ids as $key => $sid) {
                $skudata = array(
                    "stock" => !empty($skustore[$key])?$skustore[$key]:0,
                    "m_price" => !empty($sku_m_price[$key])?$sku_m_price[$key]:0,
                    "special_offer" => !empty($sku_special_offer[$key]) ?$sku_special_offer[$key]:'0.00',
                    "plus_no" => $skunum[$key],
                        "tribe_price"=>($sku_tribe_price[$key]?$sku_tribe_price[$key]:0)
                );
                $val_id = $this->product_sku_mdl->create_value($skudata);//添加9thleaf_product_sku_value
                if(!$val_id){
                    $this->db->trans_rollback();
                    echo "添加9thleaf_product_sku_value失败";exit;
                }
        
        
                $attr_array = explode("_", $sid);
                foreach ($attr_array as $attrid_skuid){
                    $skuname = $this->input->post($attrid_skuid);
                    list($attr_id,$sku_id) = explode("-", $attrid_skuid);
                    $data = array(
                        "val_id" => $val_id,//skuid
                        "product_id" => $product_id,//产品id
                        "attr_id" => $attr_id,//属性id
                        "sku_id" => $sku_id,//9thleaf_product_attr的option_values分割的第几个
                        "sku_name" => $skuname//属性名。
                    );
                    $row = $this->product_sku_mdl->create($data);//添加9thleaf_product_sku
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "添加9thleaf_product_sku失败";exit;
                    }
                }

            }
        }
        
        
        //如果有属性，则添加属性
        if($attr_values){
            foreach ($attr_values as $key => $value){
                $attr = array_filter($value);
                if(!$attr){
                    continue;
                }
                 
                $attribute = $this->attribute_mdl->load($key);//查询属性信息
                if(!$attribute){
                    continue;
                }
            
                foreach($attr as $v){
                    $data = array(
                        'product_id'=>$product_id,
                        'attr_id'=>$key,
                        'attr_value'=>$v
                    );
                    $result = $this->attribute_value_mdl->create($data);//添加产品属性
                    if(!$result){
                        $this->db->trans_rollback();
                        echo "添加product_attr_value失败";exit;
                    }
                }
            }
        }
        
        //判断是否已经加入部落
        if($mytribe){
            //如果添加产品填写部落价or有选择部落都添加商品部落列表，修改则必须有添加选中部落才添加列表
            if($tribeid){
                
                $tribeid = array_unique($tribeid);//去处重复数据
                sort($tribeid);
                $tribeids = array_column($mytribe,"id");
                foreach ($tribeid as $v){
                    if(in_array($v,$tribeids)){
                        $data = array(
                            'product_id'=>$product_id,
                            'tribe_id'=>$v,
                            'status'=>2
                        );
                        $result = $this->product_tribe_mdl->add($data);//商品创建部落信息
                        if(!$result){
                            $this->db->trans_rollback();
                            echo "商品创建部落信息失败";exit;
                        }
                    }
                }
            }else if($tribe_price > 0 && $flag){
                $data = array(
                    'product_id'=>$product_id,
                    'status'=>2
                );
                $result = $this->product_tribe_mdl->add($data);//商品创建部落信息
                if(!$result){
                    $this->db->trans_rollback();
                    echo "商品创建部落信息失败";exit;
                }
            }
        }
       
        //如果有图片，则添加图片
        if($all_images){
            foreach ($all_images as $key => $image){
                $data = array(
                    'product_id'=>$product_id,
                    'image_name'=>$image['image_name'],
                    'file'=>$image['file'],
                    'file_ext'=>$image['file_ext'],
                    'file_mime'=>$image['file_mime'],
                    'width'=>$image['width'],
                    'height'=>$image['height'],
                    'file_size'=>$image['file_size'],
                    'created_at'=>$datetime,
                    'updated_at'=>$datetime
                );
            
               $default_img = $this->image_mdl->check_prodcut_default($product_id);//检查是否已经有默认图片了
               if($default_img){
                   $data['is_base'] = 0;
               }else{
                   if (!$key){
                       $data['is_base'] = 1;
                   }else{
                       $data['is_base'] = 0;
                   }
               }
                
            
                $result = $this->image_mdl->create($data);//添加产品图片
                if(!$result){
                    $this->db->trans_rollback();
                    echo "图片添加失败";exit;
                }
            }
            $this->session->unset_userdata("temp_image");//删除session
        }
        
        
        $this->db->trans_commit();
        
        if($type){
            redirect('/goods/detail/'.$product_id.'/1');
        }else{
            $data['message'] = '录入成功！';
            $data['url'] = site_url('corporate/product/get_list');
            $this->load->view("redirect_view", $data);
            return;
        }
        

    }

    // --------------------------------------------------------------------

    /**
     * 删除产品
     *
     * @param unknown $id
     */
    public function delete()
    {
        $id = $this->input->post()['id'];


        $res = $this->product_mdl->delete($id, $this->session->userdata('app_info')['id']);
        echo $res;

    }

    /**
     * 删除图片
     */
    public function image_unlink()
    {
        $id = $this->input->post('img_id');
        $img_url = $this->input->post('img_url');
        $img_ext = $this->input->post('img_ext');
        $pid = $this->input->post('pid');


        $this->load->model('image_mdl');
        $res = $this->image_mdl->delete($id);
        if($res){
                $condition = $this->image_mdl->findProductImages($pid);
                $is_base = '';
                if($condition != null){
                    foreach ($condition as $key => $c){
                        if($c['is_base']==1)
                            $is_base = 1;
                    }
                }
                if($is_base!=1){
                    foreach ($condition as $key => $c){
                        if($key==0){
                            $this->image_mdl->update_is_base($c['id']);
                        }
                    }
                }
                echo true;

        }else  echo false;
    }

    /**
     * 商品上架
     */
    public function product_sale()
    {
        $cd = $this->input->post();


        $this->product_mdl->is_on_sale = 1;

        for ($i = 0; $i < count($cd['id']); $i ++) {
            $res = $this->product_mdl->is_on_sale($cd['id'][$i]);
        }
        if ($res) {
            redirect('corporate/product/get_list');
        } else {
            redirect('corporate/product/get_list');
        }
    }

    /**
     * 商品上架 or 下架
     * @param 商品id
     * @param $status '产品状态0:下架 1:上架 2:申请上架 3:审核通过 4:审核不通过'
     */
    public function product_nosale()
    {

        $id = $this->input->post()['id'];
        $status = $this->input->post('status');
        switch ($status){
            case 0:
                $status = 2;
                break;
            case 1:
                $status = 0;
                break;
            case 2:
                $status = 0;
                break;
            case 3:
                $status = 1;
                break;
            case 4:
                $status = 2;
                break;
        }

        $data = array();
        foreach ($id as $v=>$k){
            $data[$v]['id'] = $k;
            $data[$v]['is_on_sale'] = $status;
            $data[$v]['on_sale_at'] = date('Y-m-d H:i:s');
        }
        $res = $this->product_mdl->is_on_sale($data);
        echo $res;
    }

    //  -------------------------------------------------------------------
    
    /**
     * 设置默认图片
     */
    public function set_isbase(){

        $id = $this->input->get('id');//图片id

        $this->load->model('image_mdl');
        $res = $this->image_mdl->update_is_base($id);
        echo $this->db->last_query();exit;

        echo $res;
    }
    
    //  -------------------------------------------------------------------
    
    /**
     * ajax检查商品编号
     */
    public function checkProductNum(){
        
        $productnum = $this->input->get('productnum');//编号
        $result = $this->product_mdl->checkProductNum($productnum, $this->session->userdata('app_info')['id']);
        $data = array('flag' => true);
        if (count($result) > 0) {
            $data = array(
            'flag' => false,
            );
        }
        echo json_encode($data);
    }
    
    //  -------------------------------------------------------------------
    
    /**
     * 查询商品库存
     */
    public function check_stock($status=''){
    
        $msg = array(
            "stock" => null
        );
        if($status==1)
        {
            $product = $this->product_mdl->load($this->input->get_post("val_id"),$this->session->userdata("app_info")["id"]);
            if($product!=null)
                $msg = array(
                    "stock" => $product['stock']
                );
        }
        elseif($status==2)
        {
            $this->load->model("product_sku_mdl");
            $sku = $this->product_sku_mdl->getSKUValue($this->input->get_post("val_id"));
            if($sku!=null)
                $msg = array(
                    "stock" => $sku["stock"]
                );
        }
        echo json_encode($msg);
    }
    

	//二维数组去掉重复值,并保留键值

	function array_unique_fb($array2D){

	    foreach ($array2D as $k=>$v){

	        $v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串

	        $temp[$k]=$v;

	    }

	    $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组   

	    foreach ($temp as $k => $v){

	        $array=explode(',',$v); //再将拆开的数组重新组装

	        //下面的索引根据自己的情况进行修改即可

	        $temp2[$k]['product_id'] =$array[0];

	        $temp2[$k]['attr_id'] =$array[1];

	        $temp2[$k]['sku_id'] =$array[2];

	        $temp2[$k]['sku_name'] =$array[3];

	    }

	    return $temp2;

	}
	
	//将B端产品复制到C端
	
	//curl_get
	public function curl_get_result( $url ){
	    $curl = curl_init();
	    curl_setopt ($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($curl);
	    curl_close($curl);
	    return($result);
	}

}
?>