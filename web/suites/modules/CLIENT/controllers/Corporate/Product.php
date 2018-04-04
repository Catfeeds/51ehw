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
	}
	
    // --------------------------------------------------------------------

    /**
     * 新的LIST代码，中使用这段代码
     *
     * @param string $type
     *            类型
     */
	public function get_list($cateid = 0, $type = "",$allApp_id= "")
	{
	    
	    //验证权限
	    $corp_user = $this->session->userdata("corp_user");//识别是否店主
	    $power = $this->session->userdata("power");//权限
	    if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
	        echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
	    }
	    
        $this->load->model('product_mdl');
        // $customerInfo = $this->session->userdata('customerInfo');
        $appInfo = $this->session->userdata('appInfo');
        $mainsection_id = $this->input->get_post("mainsection_id");
        $section_id = $this->input->get_post("section_id");
        // $attr = $this->input->get_post("attr");
        // echo $cate;
        $data["types"] = $type;
        // $data ["page"] = $this->input->get_post ( "page" );
        $data["pagesize"] = 15;
        $data["order"] = $this->input->get_post("order");

        $search_name = $this->input->get('search_name');
        $data['search'] = $search_name;

        $pagecondition = "";
        $app_id = 0;
        $customer_id = 0;
        if (! empty($section_id)) {
            $pagecondition = "?section_id=" . $section_id;
        }

        // 判断是企业会员还是个人
        $customer_id = $this->session->userdata('user_id');
        
        
        // 获取企业资料
        $data['corporation'] = $this->corporation_mdl->load($customer_id);

        // $pagecondition = $pagecondition . "&order=" . $data ["order"];

        $config['uri_segment'] = 5;
        // echo $this->uri->segment($config['uri_segment'], 0);
        /*
         * if ($this->uri->segment ( $config ['uri_segment'], 0 )) {
         * $data ["page"] = $this->uri->segment ( $config ['uri_segment'], 0 ) / $data ["pagesize"] + 1;
         * } else {
         * if ($data ["page"] == "") {
         * $data ["page"] = 1;
         * }
         * }
         */
        $app = $this->session->userdata ( 'app_info' );
        $options = array();
        $options["order"] = $data["order"];
        $options["type"] = $data["types"];
        if($allApp_id==""){
            $options['conditions'] = array(
            // "p.customer_id" => $customer_id
            );
        }else{
            $options['conditions'] = array(
                // "p.app_id" => $app['id'],
                "p.app_id" =>$allApp_id,
                // "p.customer_id" => $customer_id
            );
        }
        if (! empty($search_name)) {
            $options['conditions']['p.name'] = $search_name;
        }
        /*
         * if ($mainsection_id != "") {
         * $options ["main_section"] = $mainsection_id;
         * }
         */
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数

        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $data["pagesize"];

        // 分页设置(网页版使用)
        $this->load->library('pagination');

        if (! empty($type)) {
            $config['base_url'] = site_url('corporate/product/get_list/0/' . $options["type"] . '/?');
        } else
            if (! empty($search_name)) {
                $config['base_url'] = site_url('corporate/product/get_list/?');
                $config['base_url'] .= '&search_name=' . $search_name;
            } else
                $config['base_url'] = site_url('corporate/product/get_list/?');
                // $config ['base_url'] .= '&order='.$data ["order"];
        $config['curr_page'] = $current_page;
        $config['suffix'] = $pagecondition;
        $config['total_rows'] = $this->product_mdl->count_products($options);
        $config['per_page'] = $data["pagesize"];
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 10;
        /*
         * $config ['full_tag_open'] = '';
         * $config ['full_tag_close'] = '';
         * $config ['num_tag_open'] = '';
         * $config ['num_tag_close'] = '';
         */
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        // $config ['next_tag_open'] = '';
        // $config ['next_tag_close'] = '';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        // $config ['prev_tag_open'] = '';
        // $config ['prev_tag_close'] = '';
        // $config['cur_tag_css'] = 'class="current"';
        $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        // print_r($data["pagination"]);

        // 查询产品
        // $count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);

        // echo $data ["pagesize"];
        // echo $data["page"];
        // exit();
        
        //商品数量不参与搜索条件
        $op['conditions'] = $options['conditions'];
        if(isset($search_name)){
            unset($op['conditions']['p.name']);
        }
        $data['all_count'] = $this->product_mdl->count_products($op);
        $op['type'] = 'not';
        $data['not'] = $this->product_mdl->count_products($op);
        $op['type'] = 'notsale';
        $data['notsale'] = $this->product_mdl->count_products($op);
        $op['type'] = 'sale';
        $data['sale'] = $this->product_mdl->count_products($op);

        $produtList = $this->product_mdl->find_products($options, $config['per_page'], $offset,0,1);
        $data["productList"] = $produtList;
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $data["pagesize"]);
        $data['page'] = $current_page;

        // 查询频道
        if ($app_id > 0) {} else
            if ($customer_id > 0) {
                $this->load->model('section_mdl');
                $data['sections'] = $this->section_mdl->load_tree($appInfo['id']);
            } else {
                // 平台列表
            }

        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/product/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 新建产品
     */
    public function create()
    {
        // 判断是企业会员还是个人
        $customer_id = $this->session->userdata('user_id');
        
        // 获取企业资料
        $data['corporation'] = $this->corporation_mdl->load($customer_id);
        $appInfo = $this->session->userdata('app_info');
        $options['conditions'] = array(
            "p.customer_id" => $customer_id
        );
        
        $op['conditions'] = $options['conditions'];
        $this->load->model('product_mdl');
        
        $this->load->model('category_mdl');
        $data['categorys'] = $this->category_mdl->get_child(0, 0);
        
        $data['all_count'] = $this->product_mdl->count_products($op);
        $op['type'] = 'not';
        $data['not'] = $this->product_mdl->count_products($op);
        $op['type'] = 'notsale';
        $data['notsale'] = $this->product_mdl->count_products($op);
        $op['type'] = 'sale';
        $data['sale'] = $this->product_mdl->count_products($op);
        
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
     */
    function edit($id = 0, $cid = 0)
    {
        //删除session未保出的图片
        $img =  $this->session->userdata("temp_image")!=null?$this->session->userdata("temp_image"):array();
        if(count($img)>0){
            foreach ($img as $v){
                $file = FCPATH.UPLOAD_PATH . $v["file"];
                file_exists($file)?unlink($file):'';
            }
        }
        
        $this->session->unset_userdata("temp_image");
        
        $this->load->model('product_mdl');
        if ($id != 0) {

            $data['editing'] = $this->product_mdl->load($id/*, $this->session->userdata('app_info')['id']*/);
            // print_r($data['editing']);exit;
            //print_r($this->session->userdata('app_info')['id']);

            if (! $data['editing']) {
                // return $this->show_message ( '无效ID:' . $id, 'product' );
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
        } else {
            $id = 0;
            // $cid = $this->input->get ( 'cid' );

            // 默认选中上次编辑的选项
            $last_choose = array(
                $cid,
                0,
                0,
                0,
                0,
                0,
                0,
                0
            );
            // if (!empty($_COOKIE['PS']['last_choose'])){
            // $last_choose = explode('|', $_COOKIE['PS']['last_choose']);
            // }

            $data['editing'] = array(

                'id' => null,
                'cat_id' => $last_choose[0],
                'name' => null,
                'short_name' => null,
                'url_alias' => null,
                'brand_id' => $last_choose[1],
                'weight' => null,
                'stock' => 10,
                'price' => null,
                'm_price' => null,
                'mix_m_price' => null,
                'mix_rmb_price' => null,
                'market_price' => null,
                'vip_price' => 0.00,
                'profits' => 0.00,
                'commission' => 0.00,
                'is_special_price' => 0,
                'special_price' => 0.00,
                'special_price_start_at' => null,
                'special_price_end_at' => null,
                'is_on_sale' => $last_choose[2],
                'is_new' => $last_choose[3],
                'is_hot' => $last_choose[4],
                'is_commend' => $last_choose[5],
                'is_vip' => $last_choose[6],
                'is_mc' => $last_choose[7],
                'in_wechat' => 0,
                'is_gift' => 0,
                'productnum' => null,
                'sales_count' => 0,
                'fav_count' => 0,

                'desc' => null,
                'short_desc' => null,

                'meta_title' => null,
                'meta_keywords' => null,
                'meta_desc' => null,

                'images' => array(),

                'attr_set_id' => $last_choose[6],
                'attr_list' => array()
            );

            $data['title'] = '添加商品';
        }
        
        // 品牌结果集，用于商品品牌选择
        $this->load->model('brand_mdl');
        $data['brands'] = $this->brand_mdl->find_brands(array(
            'order' => 'sort_order'
        ), 0, 0);

        // 查询
        $category = "";
        $this->load->model('category_mdl');
        $cat = $this->category_mdl->load($cid);
        $level = $cat['level'];//是否顶级
        $path =  $cat['path'];//路径
        
        $category = $cat["name"];
        while ($cat["parent_id"] != 0) {
            $cat = $this->category_mdl->load($cat["parent_id"]);

            $category = $cat["name"] . " > " . $category;
        }

        $data["category"] = $category;
        
        // 属性分组结果集，用于商品属性选择
        // $this->load->model ( 'attribute_set_mdl' );
        // $data ['attribute_sets'] = $this->attribute_set_mdl->find_attribute_sets ();

        // $this->load->model ( 'category_mdl' );
        // $data ['categorys'] = $this->category_mdl->find_all_categorys (0);

        // attr
        
        // $data['attributes'] = $this->build_attr_html($cid, $id);
        if($level == '1'){  //如果该分类是顶级就查顶级属性
            $data['attributes'] = $this->build_attr_html($cid, $id);
        }else{ 
            
            $this->load->model('product_cat_mdl');
            $path =  trim($path,',');
            $cat_row = $this->product_cat_mdl->get_top_cat($path);//根据路径得到顶级分类 
//             echo $this->db->last_query();
            $cid_array = array($cid,$cat_row['id']);
            $data['attributes'] = $this->build_attr_html($cid_array, $id);
//             $data['attributes'] = array_merge($this->build_attr_html($cid, $id),$this->build_attr_html($cat_row["id"], $id) );//顶级分类下的属性和最底层分类的属性合并
        }
        
//         $data['attributes'] = $this->build_attr_html($cid, $id);
        // 判断是企业会员还是个人
        $customer_id = $this->session->userdata('user_id');


        // 创建 编辑器
        $this->load->library('fckeditor');
        $this->fckeditor->BasePath = base_url() . 'fck/';
        $this->fckeditor->InstanceName = 'desc';
        $this->fckeditor->Height = '300';
        $this->fckeditor->ToolbarSet = 'Normal';
        $this->fckeditor->Value = $data['editing']['desc'];
        $data['fckeditor'] = $this->fckeditor->CreateHtml();
        
        $this->load->helper('ps_helper');
        // 获取企业资料
        $data['corporation'] = $this->corporation_mdl->load($customer_id);

        $this->load->model('image_mdl');

        $data['images'] = $this->image_mdl->findProductImages($id);
        
        // 计全部商品数量
        $data['all_count'] = $this->product_mdl->count_products();
        $op['type'] = 'not';
        $data['not'] = $this->product_mdl->count_products($op);
        $op['type'] = 'notsale';
        $data['notsale'] = $this->product_mdl->count_products($op);
        $op['type'] = 'sale';
        $data['sale'] = $this->product_mdl->count_products($op);
        
        //暂时注释---by tan
        //查询店铺物流模版
//         $this->load->model("logistics_mdl");
//         $data["logistics"] =    $this->logistics_mdl->getList($this->session->userdata("corporation_id"));

        
        // 查询频道
        $this->load->model('section_mdl');
        $data['sections'] = $this->section_mdl->get_list(0, - 1, 0, $this->session->userdata['corporation_id']);
        
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
    public function build_attr_html($attr_set_id, $productid)
    {
        // $attr_set_id = $this->input->post ( 'attr_set_id' );
        // $productid = $this->input->post ( 'id' );
//         $attr_set_id = ($attr_set_id) ? (int) $attr_set_id : 0;

        $this->load->model('attribute_mdl');
        $this->load->model('attribute_value_mdl');
        $this->load->model('sign_mdl');
        $attributes = $this->attribute_mdl->find_attrs_by_attr_set($attr_set_id);
//                 echo '<pre>';
//         print_r($attributes);
//         exit();

        foreach ($attributes as $key => $attribute) {

            $attributes[$key]['option_values_array'] = array();

            if ($attribute['attr_type'] == 'sku') {
                // SKU相关
                if (! empty($attribute['option_values'])) {
                    $attributes[$key]['option_values_array'] = explode(";", $attribute['option_values']);
                }

                // 需要补充完整
                $this->load->model('product_sku_mdl');
                $skuinfo = $this->product_sku_mdl->getSKUByProductid($productid);
//                 echo'<pre>';
//                 print_r($skuinfo);
//                 exit();
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
//                 echo '<pre>';
//                 var_dump($attributes);
            } else
//                 if ($attribute['attr_type'] == 'related') {
//                     // 关联
//                     $attributes[$key]['option_values_array'] = $this->sign_mdl->get_sign_for_selete($attribute['default_value']);
//                 } else {
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
//                 }
        }
//         echo '<pre>';
//         var_dump($attributes);
        return $attributes;
        
    }

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
                                                                                                   // $path = UPLOADS.$save_path;
            $path = FCPATH . UPLOAD_PATH."uploads/" . $save_path;
//             error_log($path);
            if (! file_exists($path))
                error_log("mkdir back:".mkdirsByPath($path));



            $config['file_name'] = $customer_id . '_' . date("YmdHis");
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');

            // 图片
            if (! empty($_FILES))
                $n = count($_FILES['file']['name']);
            else
                $n = 0;

//             $all_images = $this->session->userdata("temp_image");

//             if (empty($all_images)) {
//                 $all_images = array();
//             }

            if ($n) {

                foreach ($_FILES['file'] as $key => $val) :
                    for ($i = 0; $i < $n; $i ++) {
                        $_FILES['file' . $i][$key] = $val[$i];
                    }
                endforeach
                ;
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
//                         session_write_close();
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
                            }
                        }

                    } else {
                        error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }

                }

            }
        } catch (Exception $e) {
            error_log($e);
        }
    }
    
    // -------------------------------------------------------------------
    /**
     * 保存
     */
//     function save()
//     {
//         $this->load->model ( 'customer_corporation_mdl' );
//         $type = $this->input->post('see');
        
//         // 保存后并继续编辑信号
//         $re_edit = $this->input->post('re_edit');

//         // 商品id
//         $id = $this->input->post('id');

//         $productnum = $this->input->post('productnum');

//         $customer_id = $this->session->userdata('user_id');

//         $all_images = $this->session->userdata("temp_image");

//         $corporation_id = $this->session->userdata['corporation_id'];
        
//         $flag = true;
//         $this->load->model('product_mdl');

//         if ($id == 0) {
//             $this->load->model('product_mdl');
//             $result = $this->product_mdl->checkProductNum($productnum, $this->session->userdata('app_info')['id']);

//             if (count($result) > 0) {
//                 $flag = false;
//             }
//         } else {
//             $result = $this->product_mdl->find_products(array(
//                 "conditions" => array(
//                     "p.productnum" => $productnum,
//                     "p.id !=" => $id,
//                     "p.app_id" => isset($this->customer_corporation_mdl->load($customer_id)['app_id'])?$this->customer_corporation_mdl->load($customer_id)['app_id']:$this->session->userdata('app_info')['id'],
// //                     "p.app_id" => $this->session->userdata('app_info')['id'],
//                     "p.customer_id" => $customer_id
//                 )
//             ));

//             if (count($result) > 0) {
//                 $flag = false;
//             }
//         }

//         if ($flag) {
//             // 基本信息
//             $fav_count = $this->input->post('fav_count');
//             $sales_count = $this->input->post('sales_count');
//             $cat_id = (int) ($this->input->post('cat_id'));
//             $name = $this->input->post('name');
//             $short_name = $this->input->post('short_name');
//             $url_alias = $this->input->post('url_alias');
//             $brand_id = $this->input->post('brand_id');
//             $weight = $this->input->post('weight');
//             $stock = $this->input->post('stock');
//             // $market_price = $this->input->post ( 'market_price' );
//             $price = $this->input->post('price');
//             $m_price = $this->input->post('m_price');
//             $mix_m_price = $this->input->post('mix_m_price');
//             $mix_rmb_price = $this->input->post('mix_rmb_price');
//             $vip_price = $this->input->post('vip_price');
//             $profits = $this->input->post('profits');

//             $commission = $this->input->post('commission');
//             $is_special_price = $this->input->post('is_special_price');
//             $special_price = $this->input->post('special_price');
//             $special_price_start_at = $this->input->post('special_price_start_at');
//             $special_price_end_at = $this->input->post('special_price_end_at');
//             $is_on_sale = $this->input->post('is_on_sale');
//             $is_new = $this->input->post('is_new');
//             $is_hot = $this->input->post('is_hot');
//             $is_commend = $this->input->post('is_commend');
//             $is_vip = $this->input->post('is_vip');
//             $is_mc = $this->input->post('is_mc');
//             $in_wechat = $this->input->post('in_wechat');
//             $is_gift = $this->input->post('is_gift');
//             $app_id = $this->input->post("app_id");
            
//             //运费
//             $is_freight = $this->input->post('is_freight'); //设置是否运费
//             $default_item = $this->input->post('default_item');//默认多少件内使用默认的运费
//             $default_freight = $this->input->post('default_freight');//默认运费
//             $add_item = $this->input->post('add_item');//每增加多少件
//             $add_freight = $this->input->post('add_freight');//每增加X件使用运费
            
            
//             // 描述
//             $short_desc = $this->input->post('short_desc');
//             $desc = $this->input->post('desc');

//             // meta
//             $meta_title = $this->input->post('meta_title');
//             $meta_keywords = $this->input->post('meta_keywords');
//             $meta_desc = $this->input->post('meta_desc');

//             $section_id = $this->input->post('section_id');

//             //error_log("section ids is:" . count($section_id) . $section_id);

//             // 图片
//             $main_image = $this->input->post('main_image');
//             // $del_images = $this->input->post('del_image');
//             $image_order = $this->input->post('image_order');

//             // 属性分组(已取消)
//             // $attr_set_id = $this->input->post ( 'attr_set_id' );

//             // 商品属性值
//             $attr_values = $this->input->post('attr_values');

//             $attr_values = ($attr_values) ? $attr_values : array();
            
            
//             /*
//              * $real_attr_values = array ();
//              * $this->load->model ( 'attribute_mdl' );
//              * foreach ( $attr_values as $key => $value ) {
//              * $attribute = '';
//              * $attribute = $this->attribute_mdl->load ( $key );
//              * if ($attribute ['attr_set_id'] == $attr_set_id) {
//              * $real_attr_values [$key] = $value;
//              * }
//              * }
//              */
//             // print_r($real_attr_values);
//             // exit();
//             // SKU相关的
//             $sku_ids = $this->input->post('skuids');
//             $skuprice = $this->input->post('skuprice');
//             $sku_m_price = $this->input->post('sku_m_price');
//             $sku_mix_m_price = $this->input->post('sku_mix_m_price');
//             $sku_mix_rmb_price = $this->input->post('sku_mix_rmb_price');
//             $skustore = $this->input->post('skustore');
//             $skunum = $this->input->post('skunum');
//             $sku_special_offer = $this->input->post('sku_special_offer');
// //             echo '<pre>';
// //             var_dump($_POST);
// //             exit;
            
//             //地址解析经纬度
//             $address = $this->input->post('address');
//             if($address){
//                 $url = "http://api.map.baidu.com/geocoder/v2/?address=$address&output=json&ak=8VUp1IbWAlMzjt4GoC5kuaf7";
//                 $json_address = (json_decode(file_get_contents($url),true));
// //                 $this->product_mdl->longitude = $json_address['result']['location']['lng'];
// //                 $this->product_mdl->latitude = $json_address['result']['location']['lat'];
//                 $this->product_mdl->address = $address;
//             }
//             // 加载表单验证类
//             // $this->load->library('validation');
//             $this->product_mdl->longitude = $this->input->post('longitude');
//             $this->product_mdl->latitude = $this->input->post('latitude');
//             // 设置表单数据规则
//             // $this->set_save_form_rules();

//             // 如果提交数据符合所设置的规则，则继续运行
//             // if (TRUE == $this->validation->run()){

//             // 把数据提交给模型
//             $this->product_mdl->productnum = $productnum;
//             $this->product_mdl->cat_id = $cat_id;
//             $this->product_mdl->name = $name;
//             $this->product_mdl->short_name = $short_name;
//             $this->product_mdl->url_alias = $url_alias;
//             $this->product_mdl->brand_id = $brand_id;
//             $this->product_mdl->weight = $weight;
//             $this->product_mdl->stock = $stock;
//             // $this->product_mdl->market_price = $market_price;
//             $this->product_mdl->price = $price;
//             if(isset($m_price))
//                 $this->product_mdl->m_price = $m_price;
//             $this->product_mdl->mix_m_price = $mix_m_price;
//             $this->product_mdl->mix_rmb_price = $mix_rmb_price;
//             $this->product_mdl->vip_price = $vip_price;
//             $this->product_mdl->profits = $profits;
//             $this->product_mdl->commission = $commission;
//             $this->product_mdl->is_special_price = $is_special_price;
//             if($is_special_price == 1){
//             $this->product_mdl->special_price = $special_price;
//             $this->product_mdl->special_price_start_at = $special_price_start_at;
//             $this->product_mdl->special_price_end_at = $special_price_end_at;
//             }
            
//             $this->product_mdl->is_freight = $is_freight;
//             if($is_freight == 1){ //运费
//                 $this->product_mdl->default_item = $default_item;
//                 $this->product_mdl->default_freight = $default_freight;
//                 $this->product_mdl->add_item = $add_item;
//                 $this->product_mdl->add_freight = $add_freight;
//             }
//             $this->product_mdl->is_on_sale = $is_on_sale;
//             $this->product_mdl->is_new = $is_new;
//             $this->product_mdl->is_hot = $is_hot;
//             $this->product_mdl->is_commend = $is_commend;
//             $this->product_mdl->is_vip = $is_vip;
//             $this->product_mdl->is_mc = $is_mc;
//             $this->product_mdl->in_wechat = $in_wechat;
//             $this->product_mdl->is_gift = $is_gift;

//             $this->product_mdl->short_desc = $short_desc;
//             $this->product_mdl->desc = $desc;

//             $this->product_mdl->meta_title = $meta_title;
//             $this->product_mdl->meta_keywords = $meta_keywords;
//             $this->product_mdl->meta_desc = $meta_desc;
//             $this->product_mdl->section_ids = ($section_id != null && $section_id != "") ? "," . implode(",", $section_id) . "," : "";
//             $this->product_mdl->customer_id = $customer_id;
//             $this->product_mdl->corporation_id = $corporation_id;
//             $this->product_mdl->sales_count = $sales_count;
//             $this->product_mdl->fav_count = $fav_count;
//             //echo (count($all_images) > 0 && $all_images != null) ;exit;
//             if (count($all_images) > 0 && $all_images != null) {
//                 $this->product_mdl->goods_img = $all_images[0]['file'];
//                 $this->product_mdl->goods_thumb = $all_images[0]['file'];
//             }

//             // $this->product_mdl->attr_set_id = $attr_set_id;
//             if($app_id){
//                 $this->product_mdl->app_id = isset($this->customer_corporation_mdl->load($customer_id)['app_id'])?$this->customer_corporation_mdl->load($customer_id)['app_id']:$this->session->userdata('app_info')['id'];
// //                 $this->product_mdl->app_id = $this->session->userdata('app_info')['id'];
//             }else{
//                 $this->product_mdl->app_id = "0";
//             }
            
//             $this->load->model('image_mdl');
//             $this->load->model('attribute_value_mdl');
//             $this->load->model('attribute_mdl');
//             // 将本次所选的下拉类型数据保存到cookie，以备下次提供默认选择
//             // setcookie ( 'PS[last_choose]', $cat_id . '|' . $brand_id . '|' . $is_on_sale . '|' . $is_new . '|' . $is_hot . '|' . $is_commend . '|' . $is_mc, gmtime () + 86400 );

//             // 更新
//             if ($id) {

//                 // $old_pro = $this->product_mdl->load ( $id, $this->session->userdata ( 'app_info' )['id'] );

//                 // $new_pro = $this->product_mdl->load ( $id, $this->session->userdata ( 'app_info' )['id'] );

//                 // 属性值
//                 // if ($old_pro ['attr_set_id'] != $new_pro ['attr_set_id']) {
//                 // $this->attribute_value_mdl->delete_old ( $id );
//                 // }

//                 foreach ($attr_values as $key => $value) :

//                     $attribute = $this->attribute_mdl->load($key);
                    
//                     switch ($attribute['attr_type']) {

//                         case 'text':

//                         case 'textarea':

//                         case 'radio':

//                         case 'radio':
//                         case 'related':
//                         case 'select':
//                             if (empty($value[0])) {
//                                 $this->attribute_value_mdl->delete($key, $id);
//                             } else {

//                                 $this->attribute_value_mdl->product_id = $id;
//                                 $this->attribute_value_mdl->attr_id = $key;
//                                 $this->attribute_value_mdl->attr_value = $value[0];
//                                 if ($this->attribute_value_mdl->is_exist($key, $id)) {
//                                     $this->attribute_value_mdl->update($key, $id);
//                                 } else {
//                                     $this->attribute_value_mdl->create();
//                                 }
//                             }
//                             break;

//                         case 'checkbox':
// //                             echo '<pre>';
// //                             var_Dump($value);exit;
//                             $this->attribute_value_mdl->delete($key, $id, $value);
// //                             echo $this->db->last_query();
//                             $this->attribute_value_mdl->product_id = $id;
//                             $this->attribute_value_mdl->attr_id = $key;
//                             foreach ($value as $value1) :
//                                 $this->attribute_value_mdl->attr_value = $value1;
//                                 if (! $this->attribute_value_mdl->is_exist1($value1,$key,$id) && $value1 != '') {
//                                     $this->attribute_value_mdl->create();
//                                 }
//                             endforeach
//                             ;
//                     }
//                 endforeach
//                 ;

//                 $total_stock = 0;
//                 // 如果有SKU修改SKU内容 
//                 if ($sku_ids && count($sku_ids) > 0) {
//                     $this->load->model('product_sku_mdl');
//                     $skuTotlaList = $this->product_sku_mdl->getSKUByProductid($id);
                    
//                     $skuList = $skuTotlaList["skulist"];
                    
//                     foreach ($skuList as $skus) {
//                         $flag = false;
//                         foreach ($sku_ids as $key => $sid) {
//                             if ($sid == $skus["sku_key"]) {
//                                 $flag = true;
//                                 // 修改
//                                 $data = array(
//                                     "stock" => empty($skustore[$key]) ?'0':$skustore[$key],
//                                     //"price" => $skuprice[$key],
//                                     "price" => 0,
//                                     "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
//                                     "m_price" => empty($sku_m_price[$key]) ?'0.00':$sku_m_price[$key],
//                                     //"mix_m_price" => $sku_mix_m_price[$key],
//                                     "mix_m_price" => 0,
//                                     //"mix_rmb_price" => $sku_mix_rmb_price[$key],
//                                     "mix_rmb_price" => 0,
//                                     "plus_no" => empty($skunum[$key]) ?'0' : $skunum[$key]
//                                 );
                                
//                                 if ($key == 0) {
//                                     $this->product_mdl->price = $skuprice[$key];
//                                 }
                                
//                                 $this->product_sku_mdl->updateSKUValue($skus["val_id"], $data);

//                                 $ids = explode("_", $sid);
                                
//                                 foreach ($ids as $i) {
//                                     $cate_sku = explode("-", $i);
                                
//                                     $skuname = $this->input->post($i);
//                                     $sku_name[] = array(
                                        
//                                         "product_id" => $id,
//                                         "attr_id" => $cate_sku[0],
//                                         "sku_id" => $cate_sku[1],
//                                         "sku_name" => $skuname
//                                     );
                                    
// //                                     $this->product_sku_mdl->create($data);
//                                 }
                               
                                
//                                 $total_stock = $total_stock + $skustore[$key];
                                
//                             }
//                         }
                       
//                         if (! $flag) {
                            
//                             // 删除
//                             $this->product_sku_mdl->deleteByValID($skus["val_id"]);
//                             $this->product_sku_mdl->deleteSkuVal($skus["val_id"]);
// //                             echo $this->db->last_query();
//                         }
//                     }

//                     //需要需改的sku_name值
//                     if(isset($skuname)){
//                         $sku_name_data = $this->array_unique_fb($sku_name); //去除重复后
                        
//                         foreach ($sku_name as $sku_name_value){ 
//                             $this->product_sku_mdl->update_sku($sku_name_value);
//                         }
//                     }
// //                     echo $this->db->last_query();
//                     foreach ($sku_ids as $key => $sid) {
//                         $flag = false;
//                         foreach ($skuList as $skus) {
//                             if ($sid == $skus["sku_key"]) {
//                                 $flag = true;
//                             }
//                         }

//                         if (! $flag) {
//                             // 新增
//                             $data = array(
//                                 "stock" => empty($skustore[$key]) ?'0':$skustore[$key],
//                                 //"price" => $skuprice[$key],
//                                 "price" => 0,
//                                 "m_price" => empty($sku_m_price[$key]) ?'0.00':$sku_m_price[$key],
//                                 //"mix_m_price" => $sku_mix_m_price[$key],
//                                 "mix_m_price" => 0,
//                                 "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
//                                 //"mix_rmb_price" => $sku_mix_rmb_price[$key],
//                                 "mix_rmb_price" => 0,
//                                 "plus_no" => empty($skunum[$key]) ? '0' : $skunum[$key]
//                             );
//                             $valid = $this->product_sku_mdl->create_value($data);
//                             $total_stock = $total_stock + $skustore[$key];
//                             if ($key == 0) {
//                                 $this->product_mdl->price = $skuprice[$key];
//                             }
//                             // 拆分

//                             $ids = explode("_", $sid);
                            
//                             foreach ($ids as $i) {
//                                 $cate_sku = explode("-", $i);

//                                 $skuname = $this->input->post($i);
//                                 $data = array(
//                                     "val_id" => $valid,
//                                     "product_id" => $id,
//                                     "attr_id" => $cate_sku[0],
//                                     "sku_id" => $cate_sku[1],
//                                     "sku_name" => $skuname
//                                 );
//                                 $this->product_sku_mdl->create($data);
//                             }
//                         }
//                     }

//                     $this->product_mdl->stock = $total_stock;
//                 }else{  //用户没有提交SKU值过来->代表是要把SKU全删除或者没有SKU->查询商品是否有SKU->如果有就全删了->没有代表没有SKU。不操作;
//                     $this->load->model('product_sku_mdl');
//                     $skuTotlaList = $this->product_sku_mdl->getSKUByProductid($id);
//                     $skuList = $skuTotlaList["skulist"];
//                     if(count ($skuTotlaList) > 0){
//                         foreach ($skuList as $skuList_v){ 
//                             $this->product_sku_mdl->deleteByValID($skuList_v["val_id"]);
//                             $this->product_sku_mdl->deleteSkuVal($skuList_v["val_id"]);
//                         }
//                     }
//                 }

//                 // echo $this->product_mdl->price;
//                 // exit();
//                 $this->product_mdl->update($id);

//                 // 继续编辑
//                 // if($re_edit){
//                 $this->session->set_userdata('productid', $id);
//                 $return["ResultMessage"] = array(
//                     "resultcode" => "success",
//                     "resultmessage" => "商品编辑重复！"
//                 );
//                 $return["data"] = $id;

//                 // 添加新商品
//             } else {
//                 $id = $this->product_mdl->create();
                
//                 if($id){}else{
//                     $return["ResultMessage"] = array(
//                         "resultcode" => "success",
//                         "resultmessage" => "录入失败！"
//                     );
//                     $data['message'] = '录入失败！';
//                     $data['url'] = site_url('corporate/product/create');
                    
//                     $this->load->view("redirect_view", $data);
//                     return;
//                 }

//                 // 属性值
//                 foreach ($attr_values as $key => $value) :
//                     foreach ($value as $value1) :
//                         if (! empty($value1)) {
//                             $this->attribute_value_mdl->product_id = $id;
//                             $this->attribute_value_mdl->attr_id = $key;
//                             $this->attribute_value_mdl->attr_value = $value1;
//                             $this->attribute_value_mdl->create();
//                         }
//                     endforeach
//                     ;
//                 endforeach
//                 ;

//                 $total_stock = 0;
//                 // 如果有SKU修改SKU内容
//                 if ($sku_ids && count($sku_ids) > 0) {
//                     // echo "gggg";
//                     // print_r($sku_ids);
//                     $this->load->model('product_sku_mdl');
//                     foreach ($sku_ids as $key => $sid) {
//                         $data = array(
//                             "stock" => $skustore[$key]==""?0:$skustore[$key],
//                             //"price" => $skuprice[$key]==""?0:$skuprice[$key],
//                             "m_price" => $sku_m_price[$key]==""?0:$sku_m_price[$key],
//                             //"mix_m_price" => $sku_mix_m_price[$key]==""?0:$sku_mix_m_price[$key],
//                             //"mix_rmb_price" => $sku_mix_rmb_price[$key]==""?0:$sku_mix_rmb_price[$key],
//                             "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
//                             "plus_no" => $skunum[$key]
//                         );
//                         $valid = $this->product_sku_mdl->create_value($data);
//                         if ($key == 0) {
//                             $this->product_mdl->price = $skuprice[$key];
//                         }
//                         // 拆分

//                         $sids = explode("_", $sid);
//                         foreach ($sids as $i) {
//                             $cate_sku = explode("-", $i);
//                             $skuname = $this->input->post($i);
//                             $data = array(
//                                 "val_id" => $valid,
//                                 "product_id" => $id,
//                                 "attr_id" => $cate_sku[0],
//                                 "sku_id" => $cate_sku[1],
//                                 "sku_name" => $skuname
//                             );
//                             $this->product_sku_mdl->create($data);
//                         }
//                     }

// //                     $this->product_mdl->stock = $total_stock;
// //                     $this->product_mdl->update($id);
//                 }

//                 // if ($re_edit){
//                 $this->session->set_userdata('productid', $id);
//                 $return["ResultMessage"] = array(
//                     "resultcode" => "success",
//                     "resultmessage" => "商品编号重复！"
//                 );
//                 $return["data"] = $id;

//                 // show_message2('"商品(ID:'.$newly_one['id'].')" 已保存!', 'product/edit/id/'.$newly_one['id']);
//                 // }else{
//                 // //echo '保存成功!';
//                 // show_message2('保存成功!', 'product');
//                 // }
//             }
//             /*
//              * 处理图片保存
//              */
//             $this->load->model('image_mdl');
//             $condition = $this->image_mdl->findProductImages($id);
//             $is_base = '';
//             if($condition != null){
//                 foreach ($condition as $c){
//                     if($c['is_base']==1)
//                         $is_base = 1;
//                 }
//             }

//             error_log(count($all_images));
//             if (isset($all_images) && count($all_images) > 0 && isset($all_images[0]['file'])) {

//                  foreach ( $all_images as $images ){
//                     $img[] = $images['original_name'];
//                  }
//                  array_multisort($img,SORT_ASC,$all_images);
//                 foreach ($all_images as $key => $image) :
//                     $this->image_mdl->product_id = $id;
//                     $this->image_mdl->image_name = $image['image_name'];
//                     $this->image_mdl->file = $image['file'];
//                     $this->image_mdl->file_ext = $image['file_ext'];
//                     $this->image_mdl->file_mime = $image['file_mime'];
//                     $this->image_mdl->width = $image['width'];
//                     $this->image_mdl->height = $image['height'];
//                     $this->image_mdl->file_size = $image['file_size'];
//                     $this->image_mdl->is_base = 0;
//                     $this->original_name = $image['original_name'];
//                      if ($key==0 && $is_base!=1){
//                         $this->image_mdl->is_base = 1 ;
//                      }

//                     $res = $this->image_mdl->create();
//                 endforeach
//                 ;
//                 // endforeach
//                 // ;
//                 //$this->session->unset_userdata("temp_image");
//             }

//             $this->session->unset_userdata("temp_image");

//             if($type==1){
//                 redirect('/goods/detail/'.$id.'/1');
//             }else{
//             $data['message'] = '录入成功！';
//             $data['url'] = site_url('corporate/product/get_list');
//             $this->load->view("redirect_view", $data);
//             return;
//             }
//         } else {
//             $return["ResultMessage"] = array(
//                 "resultcode" => "success",
//                 "resultmessage" => "商品编号重复！"
//             );
//             $data['message'] = '商品编号重复！';
//             $data['url'] = site_url('corporate/product/create');

//             $this->load->view("redirect_view", $data);
//             return;
//         }
//         if($type==1){
//             redirect('goods/detail/'.$id.'/1');
//         }else{
//         $data['message'] = '录入成功！';
//         $data['url'] = site_url('corporate/product/get_list');

//         $this->load->view("redirect_view", $data);
//         return;
//         }

//         // 对提交的数据不符合表单验证规则情况的处理
//         // }else{
//         // show_message2('数据插入失败!', 'product/edit');
//         // }
//     }
    
    
    function save(){
        $this->load->model('product_mdl');
        $this->load->model ( 'customer_corporation_mdl' );
        $this->load->model('image_mdl');
        $this->load->model('attribute_value_mdl');
        $this->load->model('attribute_mdl');
        $this->load->model('product_sku_mdl');
        //暂时注释---by tan
      //  $this->load->model("logistics_mdl");

        //session信息
        $customer_id = $this->session->userdata('user_id');//用户id
        $all_images = $this->session->userdata("temp_image");//图片信息
        $corporation_id = $this->session->userdata['corporation_id'];//店铺id
        
        // 基本信息
        $type = $this->input->post('see');//是否预览  
        $id = $this->input->post('id');// 商品id
        $productnum = $this->input->post('productnum');//商品编号
        $fav_count = $this->input->post('fav_count');//收藏数
        $sales_count = $this->input->post('sales_count');//默认销售量
        $cat_id = (int) ($this->input->post('cat_id'));//分类id
        $name = $this->input->post('name');//商品名称
        $short_name = $this->input->post('short_name');//短名称
        $url_alias = $this->input->post('url_alias');//URL别名
        $brand_id = $this->input->post('brand_id');//品牌ID
        $weight = $this->input->post('weight');//重量
        $stock = $this->input->post('stock');//库存
        $price = $this->input->post('price');
        $m_price = $this->input->post('m_price');//零售价
        $mix_m_price = $this->input->post('mix_m_price');//混合Ｍ币
        $mix_rmb_price = $this->input->post('mix_rmb_price');//混合现金
        $vip_price = $this->input->post('vip_price');//换货价
        $profits = $this->input->post('profits');//利润
        $commission = $this->input->post('commission');//佣金
        $is_special_price = $this->input->post('is_special_price');//是否特价
        $special_price = $this->input->post('special_price');//特价
        $special_price_start_at = $this->input->post('special_price_start_at');//特价日期开始
        $special_price_end_at = $this->input->post('special_price_end_at');//特价日期结束
        $is_on_sale = $this->input->post('is_on_sale');//上架状态
        $is_new = $this->input->post('is_new');//是否新品，0表示否，1表示是，默认是
        $is_hot = $this->input->post('is_hot');//是否热销
        $is_commend = $this->input->post('is_commend');//是否推荐
        $is_vip = $this->input->post('is_vip');//是否上架VIP
        $is_mc = $this->input->post('is_mc');//是否MC区
        $in_wechat = $this->input->post('in_wechat');//是否微信中显示
        $is_gift = $this->input->post('is_gift');//是否赠品
        $section_id = $this->input->post('section_id');
        $address = $this->input->post('address');//地址
        $logistics_id = $this->input->post('logistics_id');//运费模版id
        $is_freight = $this->input->post('is_freight');//判断运费

        //选择全国站还是本地站
        $app_id = $this->input->post("app_id");//0本地1全国
        if($app_id){
            $corpinfo_appid = $this->customer_corporation_mdl->load($customer_id)['app_id'];//查询店铺信息
            $this->product_mdl->app_id = $corpinfo_appid;
        }else{
            $this->product_mdl->app_id = "0";
        }
        
        // 描述
        $short_desc = $this->input->post('short_desc');//简短描述
        $desc = $this->input->post('desc');//详细描述
        
        // meta
        $meta_title = $this->input->post('meta_title');//Meta标题
        $meta_keywords = $this->input->post('meta_keywords');//Meta关键字
        $meta_desc = $this->input->post('meta_desc');//Meta描述
        
        // 图片
        $main_image = $this->input->post('main_image');
        $image_order = $this->input->post('image_order');
        
        // 商品属性值
        $attr_values = $this->input->post('attr_values');
        $attr_values = ($attr_values) ? $attr_values : array();
        
        // SKU相关的
        $sku_ids = $this->input->post('skuids');//sku
        $skuprice = $this->input->post('skuprice');
        $sku_m_price = $this->input->post('sku_m_price');//sku价格
        $sku_mix_m_price = $this->input->post('sku_mix_m_price');//混合M币价
        $sku_mix_rmb_price = $this->input->post('sku_mix_rmb_price');//sku混合现金价
        $skustore = $this->input->post('skustore');//sku库存
        $skunum = $this->input->post('skunum');//sku编码
        $sku_special_offer = $this->input->post('sku_special_offer');//sku特价

        //判断是否设置运费
        //暂时注释---by tan
//         if($logistics_id && $is_freight){//是
//             $logistics = $this->logistics_mdl->getList($corporation_id,$logistics_id);
//             if($logistics){
//                 $this->product_mdl->logistics_id = $logistics_id;
//             }
//         }else{//否
//             $this->product_mdl->logistics_id = NULL;
//         }
        
        $this->product_mdl->logistics_id = NULL;

        // 把数据提交给模型
        $this->product_mdl->address = $address;
        $this->product_mdl->longitude = $this->input->post('longitude');//经度
        $this->product_mdl->latitude = $this->input->post('latitude');//纬度
        $this->product_mdl->productnum = $productnum;
        $this->product_mdl->cat_id = $cat_id;
        $this->product_mdl->name = $name;
        $this->product_mdl->short_name = $short_name;
        $this->product_mdl->url_alias = $url_alias;
        $this->product_mdl->brand_id = $brand_id;
        $this->product_mdl->weight = $weight;
        $this->product_mdl->stock = $stock;
        $this->product_mdl->price = $price;
        if(isset($m_price)){
            $this->product_mdl->m_price = $m_price;
        }
        $this->product_mdl->mix_m_price = $mix_m_price;
        $this->product_mdl->mix_rmb_price = $mix_rmb_price;
        $this->product_mdl->vip_price = $vip_price;
        $this->product_mdl->profits = $profits;
        $this->product_mdl->commission = $commission;
        $this->product_mdl->is_special_price = $is_special_price;
        if($is_special_price == 1){
            $this->product_mdl->special_price = $special_price;
            $this->product_mdl->special_price_start_at = $special_price_start_at;
            $this->product_mdl->special_price_end_at = $special_price_end_at;
        }
        

        $this->product_mdl->is_on_sale = $is_on_sale;
        $this->product_mdl->is_new = $is_new;
        $this->product_mdl->is_hot = $is_hot;
        $this->product_mdl->is_commend = $is_commend;
        $this->product_mdl->is_vip = $is_vip;
        $this->product_mdl->is_mc = $is_mc;
        $this->product_mdl->in_wechat = $in_wechat;
        $this->product_mdl->is_gift = $is_gift;
        
        $this->product_mdl->short_desc = $short_desc;
        $this->product_mdl->desc = $desc;
        
        $this->product_mdl->meta_title = $meta_title;
        $this->product_mdl->meta_keywords = $meta_keywords;
        $this->product_mdl->meta_desc = $meta_desc;
        $this->product_mdl->section_ids = ($section_id != null && $section_id != "") ? "," . implode(",", $section_id) . "," : "";
        $this->product_mdl->customer_id = $customer_id;
        $this->product_mdl->corporation_id = $corporation_id;
        $this->product_mdl->sales_count = $sales_count;
        $this->product_mdl->fav_count = $fav_count;
        if (count($all_images) > 0 && $all_images != null) {
            $this->product_mdl->goods_img = $all_images[0]['file'];
            $this->product_mdl->goods_thumb = $all_images[0]['file'];
        }
        

        $flag = true;//识别是否编号重复
        //查询判断编号是否重复
        $productcode = $this->product_mdl->checkProductNum($productnum);//查询商品编号
        if ($id>0) {
            if ($productcode[0]["corporation_id"] != $corporation_id || count($productcode)>1) {
                $flag = false;
            }
        } else {
            if (count($productcode)>0) {
                $flag = false;
            }
        }
        

        if ($flag) {
            // 更新
            if ($id) {
                //属性处理
                foreach ($attr_values as $key => $value){
                    $attribute = $this->attribute_mdl->load($key);
                    switch ($attribute['attr_type']) {
                        case 'text':
                        case 'textarea':
                        case 'radio':
                        case 'related':
                        case 'select':
                            if (empty($value[0])) {
                                $this->attribute_value_mdl->delete($key, $id);//删除属性
                            } else {
                                $this->attribute_value_mdl->product_id = $id;
                                $this->attribute_value_mdl->attr_id = $key;
                                $this->attribute_value_mdl->attr_value = $value[0];
                                $this->attribute_value_mdl->is_exist($key, $id);
                                //判断属性，有就更新，无创建
                                if ($this->attribute_value_mdl->is_exist($key, $id)) {
                                    $this->attribute_value_mdl->update($key, $id);
                                } else {
                                    $this->attribute_value_mdl->create();
                                }
                            }
                        break;
                        case 'checkbox':
                            $this->attribute_value_mdl->delete($key, $id, $value);
                            $this->attribute_value_mdl->product_id = $id;
                            $this->attribute_value_mdl->attr_id = $key;
                            foreach ($value as $value1){
                                $this->attribute_value_mdl->attr_value = $value1;
                                if (! $this->attribute_value_mdl->is_exist1($value1,$key,$id) && $value1 != '') {
                                    $this->attribute_value_mdl->create();
                                }
                            }
                        break;
                    }
                }
        
                

                $total_stock = 0;
                //sku处理
                if ($sku_ids && count($sku_ids) > 0) {
                    
                    $skuTotlaList = $this->product_sku_mdl->getSKUByProductid($id);//根据商品id查询相关的sku
                    $skuList = $skuTotlaList["skulist"];
    
                    foreach ($skuList as $skus) {
                        $flag = false;
                        foreach ($sku_ids as $key => $sid) {
                            if ($sid == $skus["sku_key"]) {
                                $flag = true;
                                // 修改
                                $data = array(
                                    "stock" => empty($skustore[$key]) ?'0':$skustore[$key],
                                    //"price" => $skuprice[$key],
                                    "price" => 0,
                                    "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
                                    "m_price" => empty($sku_m_price[$key]) ?'0.00':$sku_m_price[$key],
                                    //"mix_m_price" => $sku_mix_m_price[$key],
                                    "mix_m_price" => 0,
                                    //"mix_rmb_price" => $sku_mix_rmb_price[$key],
                                    "mix_rmb_price" => 0,
                                    "plus_no" => empty($skunum[$key]) ?'0' : $skunum[$key]
                                );
    
                                if ($key == 0) {
                                    $this->product_mdl->price = $skuprice[$key];
                                }
    
                                $this->product_sku_mdl->updateSKUValue($skus["val_id"], $data);
    
                                $ids = explode("_", $sid);
    
                                foreach ($ids as $i) {
                                    $cate_sku = explode("-", $i);
    
                                    $skuname = $this->input->post($i);
                                    $sku_name[] = array(
    
                                        "product_id" => $id,
                                        "attr_id" => $cate_sku[0],
                                        "sku_id" => $cate_sku[1],
                                        "sku_name" => $skuname
                                    );
                                }
                                 
                                $total_stock = $total_stock + $skustore[$key];
                            }
                        }
                         
                        if (! $flag) {
                            // 删除
                            $this->product_sku_mdl->deleteByValID($skus["val_id"]);
                            $this->product_sku_mdl->deleteSkuVal($skus["val_id"]);
                        }
                    }
    
                    //需要需改的sku_name值
                    if(isset($skuname)){
                        $sku_name_data = $this->array_unique_fb($sku_name); //去除重复后
    
                        foreach ($sku_name as $sku_name_value){
                            $this->product_sku_mdl->update_sku($sku_name_value);
                        }
                    }
                    //                     echo $this->db->last_query();
                    foreach ($sku_ids as $key => $sid) {
                        $flag = false;
                        foreach ($skuList as $skus) {
                            if ($sid == $skus["sku_key"]) {
                                $flag = true;
                            }
                        }
    
                        if (! $flag) {
                            // 新增
                            $data = array(
                                "stock" => empty($skustore[$key]) ?'0':$skustore[$key],
                                //"price" => $skuprice[$key],
                                "price" => 0,
                                "m_price" => empty($sku_m_price[$key]) ?'0.00':$sku_m_price[$key],
                                //"mix_m_price" => $sku_mix_m_price[$key],
                                "mix_m_price" => 0,
                                "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
                                //"mix_rmb_price" => $sku_mix_rmb_price[$key],
                                "mix_rmb_price" => 0,
                                "plus_no" => empty($skunum[$key]) ? '0' : $skunum[$key]
                            );
                            $valid = $this->product_sku_mdl->create_value($data);
                            $total_stock = $total_stock + $skustore[$key];
                            if ($key == 0) {
                                $this->product_mdl->price = $skuprice[$key];
                            }
                            // 拆分
    
                            $ids = explode("_", $sid);
    
                            foreach ($ids as $i) {
                                $cate_sku = explode("-", $i);
    
                                $skuname = $this->input->post($i);
                                $data = array(
                                    "val_id" => $valid,
                                    "product_id" => $id,
                                    "attr_id" => $cate_sku[0],
                                    "sku_id" => $cate_sku[1],
                                    "sku_name" => $skuname
                                );
                                $this->product_sku_mdl->create($data);
                            }
                        }
                    }
    
                    $this->product_mdl->stock = $total_stock;
                }else{  //用户没有提交SKU值过来->代表是要把SKU全删除或者没有SKU->查询商品是否有SKU->如果有就全删了->没有代表没有SKU。不操作;
                    
                    $skuTotlaList = $this->product_sku_mdl->getSKUByProductid($id);
                    $skuList = $skuTotlaList["skulist"];
                    if(count ($skuTotlaList) > 0){
                        foreach ($skuList as $skuList_v){
                            $this->product_sku_mdl->deleteByValID($skuList_v["val_id"]);
                            $this->product_sku_mdl->deleteSkuVal($skuList_v["val_id"]);
                        }
                    }
                }
        
                $this->product_mdl->update($id);//更新商品信息
   
            } else {// 添加新商品
                //判断是否上传图片
                if(!$all_images){
                     $return["ResultMessage"] = array(
                        "resultcode" => "success",
                        "resultmessage" => "请上传商品图片！"
                    );
                    $data['message'] = '请上传商品图片！';
                    $data['url'] = site_url('corporate/product/create');
            
                    $this->load->view("redirect_view", $data);
                    return;
                }
                
                $id = $this->product_mdl->create();
                if(!$id){
                    $return["ResultMessage"] = array(
                        "resultcode" => "success",
                        "resultmessage" => "录入失败！"
                    );
                    $data['message'] = '录入失败！';
                    $data['url'] = site_url('corporate/product/create');
            
                    $this->load->view("redirect_view", $data);
                    return;
                }
            
                // 属性值
                foreach ($attr_values as $key => $value){
                    foreach ($value as $value1) {
                        if (! empty($value1)) {
                            $this->attribute_value_mdl->product_id = $id;
                            $this->attribute_value_mdl->attr_id = $key;
                            $this->attribute_value_mdl->attr_value = $value1;
                            $this->attribute_value_mdl->create();
                        }
                    }
                }
            
                $total_stock = 0;
                // 如果有SKU修改SKU内容
                if ($sku_ids && count($sku_ids) > 0) {
                    
                    foreach ($sku_ids as $key => $sid) {
                        $data = array(
                            "stock" => $skustore[$key]==""?0:$skustore[$key],
                            "m_price" => $sku_m_price[$key]==""?0:$sku_m_price[$key],
                            "special_offer" => empty($sku_special_offer[$key]) ? '0.00' : $sku_special_offer[$key],
                            "plus_no" => $skunum[$key]
                        );
                        $valid = $this->product_sku_mdl->create_value($data);//创建sku商品信息（价格，库存等）
                        if ($key == 0) {
                            $this->product_mdl->price = $skuprice[$key];
                        }
                        // 拆分
            
                        $sids = explode("_", $sid);
                        foreach ($sids as $i) {
                            $cate_sku = explode("-", $i);
                            $skuname = $this->input->post($i);
                            $data = array(
                                "val_id" => $valid,
                                "product_id" => $id,
                                "attr_id" => $cate_sku[0],
                                "sku_id" => $cate_sku[1],
                                "sku_name" => $skuname
                            );
                            $this->product_sku_mdl->create($data);
                        }
                    }
                }
            
 
                $this->session->set_userdata('productid', $id);
                $return["ResultMessage"] = array(
                    "resultcode" => "success",
                    "resultmessage" => "商品编号重复！"
                );
                $return["data"] = $id;
            

            }
            
            /*
             * 处理图片保存
             */
            
            $condition = $this->image_mdl->findProductImages($id);//查询图片
            $is_base = '';
            if($condition != null){
                foreach ($condition as $c){
                    if($c['is_base']==1)
                        $is_base = 1;
                }
            }
            //判断如果有上传图片则创建
            if (isset($all_images) && count($all_images) > 0 && isset($all_images[0]['file'])) {

                foreach ( $all_images as $images ){
                    $img[] = $images['original_name'];
                }
                array_multisort($img,SORT_ASC,$all_images);
                foreach ($all_images as $key => $image){
                $this->image_mdl->product_id = $id;
                $this->image_mdl->image_name = $image['image_name'];
                $this->image_mdl->file = $image['file'];
                $this->image_mdl->file_ext = $image['file_ext'];
                $this->image_mdl->file_mime = $image['file_mime'];
                $this->image_mdl->width = $image['width'];
                $this->image_mdl->height = $image['height'];
                $this->image_mdl->file_size = $image['file_size'];
                $this->image_mdl->is_base = 0;
                $this->original_name = $image['original_name'];
                if ($key==0 && $is_base!=1){
                    $this->image_mdl->is_base = 1 ;
                }

                $res = $this->image_mdl->create();//创建图片
                }
            }
            $this->session->unset_userdata("temp_image");

            if($type==1){//预览
                redirect('/goods/detail/'.$id.'/1');return;
            }else{
                $data['message'] = '录入成功！';
                $data['url'] = site_url('corporate/product/get_list');
                $this->load->view("redirect_view", $data);
                return;
            }
        } else {
            $return["ResultMessage"] = array(
                "resultcode" => "success",
                "resultmessage" => "商品编号重复！"
            );
            $data['message'] = '商品编号重复！';
            $data['url'] = site_url('corporate/product/create');
        
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

        $this->load->model('product_mdl');

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
                file_exists($img_url.$img_ext)?unlink($img_url.$img_ext):'';
                file_exists($img_url.'_270'.$img_ext)?unlink($img_url.'_270'.$img_ext):'';
                file_exists($img_url.'_290'.$img_ext)?unlink($img_url.'_290'.$img_ext):'';
                file_exists($img_url.'_670'.$img_ext)?unlink($img_url.'_670'.$img_ext):'';
                $this->load->model('image_mdl');
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

        $this->load->model('product_mdl');

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
        $this->load->model('product_mdl');
        $data = array();
        foreach ($id as $v=>$k){
            $data[$v]['id'] = $k;
            $data[$v]['is_on_sale'] = $status;
            $data[$v]['on_sale_at'] = date('Y-m-d H:i:s');
        }
        $res = $this->product_mdl->is_on_sale($data);
        echo $res;
    }

    /**
     * 设置默认图片
     */
    public function set_isbase(){

        $id = $this->input->get('id');

        $this->load->model('image_mdl');
        $res = $this->image_mdl->update_is_base($id);

        echo $res;
    }
    
    public function checkProductNum(){
        
        $productnum = $this->input->get('productnum');
        $this->load->model('product_mdl');
        $result = $this->product_mdl->checkProductNum($productnum, $this->session->userdata('app_info')['id']);
        $data = array('flag' => true);
        if (count($result) > 0) {
            $data = array(
            'flag' => false,
            );
        }
        echo json_encode($data);
    }
    
    /**
     * 查询商品库存
     */
    public function check_stock($status=''){
    
        $msg = array(
            "stock" => null
        );
        if($status==1)
        {
            $this->load->model("product_mdl");
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

}
?>