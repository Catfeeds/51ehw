<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends Front_Controller
{

    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     */
    public function index()
    {
        $app = $this->session->userdata('app_info');


        $this->load->model('ad_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('requirement_mdl');
        $this->load->model('content_mdl');
        $this->load->model('demand_mdl');
        $this->load->model('product_cat_mdl');
        
        $data['demand'] = $app['id'];
        $app_id = $this->session->userdata("app_info")["id"];
        
        // 广告图
        if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
            $data['adList'] = $this->ad_mdl->getBySign('APPINDEX', $app['id']);
        }
        else {
            $data['adList'] = $this->ad_mdl->getBySign('INDEX', $app['id']);
        }
        $data['newarrival'] = $this->goods_mdl->getRequirementList(0, 20, 0); // $app ['id'] ); 临时处理

        //新首页商品大类
        $data['ad_apptype_list'] = $this->ad_mdl->getBySign ( 'APPTYPE', $app["id"] );
        
        // 最新产品
        $data ['newarrival'] = $this->goods_mdl->new_arrival ( $app ['id'] );
        
        // 品牌推广图
        $data ['ad_brand_list'] = $this->ad_mdl->getBySign ( 'BRAND', $app ["id"] );
        
        // 需求列表
        //$data['requires'] = $this->requirement_mdl->getList($status = '', $search_name = '', $beginTime = '', $endTime = '', $assort = '', 0, 50);
        
        // 公告列表
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        // 供应列表
        //$data['newarrival'] = $this->goods_mdl->getRequirementList(0, 50, 0, $key);
        // 供应信息轮播
        $data['supply']['diet'] = $this->goods_mdl->latestproduct(189,$app_id);//餐饮
        $data['supply']['liquor'] = $this->goods_mdl->latestproduct(1023,$app_id);//酒类
        $data['supply']['painting'] = $this->goods_mdl->latestproduct(100000,$app_id);//书画
        // 需求信息轮播
        $data['diet'] = array();//$this->demand_mdl->latestdemand(189,$app_id);//餐饮
        $data['liquor'] = array();//$this->demand_mdl->latestdemand(1023,$app_id);//酒类
        $data['painting'] = array();//$this->demand_mdl->latestdemand(100000,$app_id);//书画
        
        $this->session->set_userdata('redirect',current_url());
        
        //$data['title'] = $app["app_name"];
        $data['head_set'] = 5;
		$data['foot_icon'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('home', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

	/**
	*首頁預覽所用
	*/

	 public function hometemplatepreview(){

       $app = $this->session->userdata('app_info');

        $this->load->model('ad_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('requirement_mdl');
        $this->load->model('content_mdl');
        $data["app_id"] = $app['id'];

        // if ($app_id > 0) {
        // 广告图
        $data['adList'] = $this->ad_mdl->getBySign('INDEX', $app['id']);
        $data['newarrival'] = $this->goods_mdl->getRequirementList(0, 20, 0); // $app ['id'] ); 临时处理
        $data['requires'] = $this->requirement_mdl->getList($status = '', $search_name = '', $beginTime = '', $endTime = '', $assort = '', 0, 50);
        // 公告列表
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        // 供应列表
        $data['newarrival'] = $this->goods_mdl->getRequirementList(0, 50, 0, $key);

		//樓層數據
		$this->load->model("home_template_set_mdl");
            $res=$this->home_template_set_mdl->get_display_list(0,$app['id']);

            $floordata =array();
            if (! empty($res)) {
            foreach ($res as $key => $val) {
                $floordata[$val['level_id']]['id'] = $val['level_id'];
                $floordata[$val['level_id']]['level_name'] = $val['level_name'];
                $floordata[$val['level_id']]['level_temp'] = $val['level_temp'];
                $floordata[$val['level_id']]['level_morelink'] = $val['level_morelink'];
                
                if (strlen($val['temp_key']) <= 2) {
                    $floordata[$val['level_id']]['M'][$val['temp_key']]['category_name'] = $val['desc'];
                } else {
                    $floordata[$val['level_id']]['M'][substr($val['temp_key'], 0, 2)][] = array(
                        'id' => $val['id'],
                        'temp_key' => $val['temp_key'],
                        'img_path' => $val['img_path'],
                        'desc' => $val['desc'],
                        'link_path' => $val['link_path']
                    );
                }

			//exit();

            }
            $floordata = array_values($floordata);
        }
        unset($res);
        
        $data["data"] = $floordata;
			

        $data['title'] = $app["app_name"];
        $data['head_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('homepreview', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);

    }

    // --------------------------------------------------------------------

    /**
     *
     * @param unknown $app_id
     */
    public function redirectOther($app_id)
    {
        $this->session->set_userdata('app_info', null);
        $this->load->model('app_info_mdl');
        $app_info = $this->app_info_mdl->load($app_id);
        $site_url = $app_info["site_url"];
        redirect($site_url);
    }

    // --------------------------------------------------------------------

    /**
     * 进入各店铺首页
     * @param 企业ID $corporationid
     */
    public function GoToShop($corporationid)
    {
        if ($corporationid > 0) {
            // 查询店表的模板
            $this->load->model('customer_corporation_mdl');
            $data["corporation"] = $this->customer_corporation_mdl->getById($corporationid);
            $app_info = $this->session->userdata('app_info');
            // 判断分站点
//             if ($app_info['id']) {
//                 if ($data["corporation"]['app_id'] == $app_info['id']) {} else {
//                     $app = $this->app_info_mdl->get_situs_list($data['corporation']['app_id']);
//                     header("Location: " . $app['site_url'] . "home/GoToShop/$corporationid");
//                     return;
//                 }
//             }
            
            $data['title'] = $data["corporation"]['corporation_name'] . '-店铺首页';
            if ($data["corporation"]['template_url'] != "") {
                $this->load->view('head', $data);
                if ($corporationid == 157) {
                    $this->load->view('_header', $data);
                } else {
                    $this->load->view('shop_header', $data);
                }
                // 判断新路径下是否有主页
                if (file_exists("uploads/corporation_template/C_$corporationid")) {
                    $this->load->view('../../uploads/corporation_template/C_' . $corporationid . "/index.php"); // 新版主页
                } else if(file_exists("corporation_template/C_$corporationid")){
                    $this->load->view('../../corporation_template/C_' . $corporationid . "/index.php"); // 旧版主页
                } else{
                    $this->customer_corporation_mdl->updateTemplate($corporationid, $template_id = null, $save_path = null);
                    redirect(site_url("home/GoToShop/$corporationid"));
                }
                $this->load->view('_footer');
                $this->load->view('foot');
            } else {
                $options = array();
                
                $pagecondition = "";
                $data["page"] = ($this->input->get_post('per_page', true));
                $data["pagesize"] = 15;
                $data["order"] = $this->input->get_post("order");
                $cateid = 0;
                $app_id = 0;
                $customer_id = 0;
                $section_id = 0;
                if (0 == $data["page"]) {
                    $data["page"] = 1;
                }
                $offset = ($data["page"] - 1) * $data["pagesize"];
                
                $this->load->model('goods_mdl');
                $data['key_cate'] = $this->goods_mdl->get_categorys_with_corp($corporationid);
                
                $pagecondition = $pagecondition . "&order=" . $data["order"];
                
                $config['uri_segment'] = 4;
                if ($this->uri->segment($config['uri_segment'], 0)) {
                    $data["page"] = $this->uri->segment($config['uri_segment'], 0) / $data["pagesize"] + 1;
                } else {
                    if ($data["page"] == "") {
                        $data["page"] = 1;
                    }
                }
                
                /*
                 * if ($mainsection_id != "") {
                 * $options ["main_section"] = $mainsection_id;
                 * }
                 */
                $options['corporation_id'] = $corporationid;
                // 分页设置(网页版使用)
                $this->load->library('pagination');
                $config['base_url'] = site_url('home/GoToShop/' . $corporationid . '/?');
                $config['suffix'] = $pagecondition;
                $config['total_rows'] = $this->goods_mdl->get_count_with_condition($cateid, array(), $options, null, $app_id, $customer_id, $section_id, $corporationid);
                $config['per_page'] = $data["pagesize"];
                $config['curr_page'] = $data["page"];
                $config['num_links'] = 10;
                $config['use_page_numbers'] = TRUE;
                $config['page_query_string'] = TRUE;
                $config['next_link'] = '下一页';
                $config['next_tag_css'] = 'class="lPage"';
                $config['prev_link'] = '上一页';
                $config['prev_tag_css'] = 'class="lPage"';
                $config['first_link'] = '<<';
                $config['last_link'] = '>>';
                $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
                $config['cur_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                
                // 查询产品
                // $count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);
                $options["order"] = $data["order"];
                // echo $data ["pagesize"];
                // echo $data["page"];
                // exit();
                
                $produtList = $this->goods_mdl->get_lists_with_condition($data["pagesize"], $offset, $cateid, array(), $options, 'p.id,p.name,p.short_name,m_price,vip_price,goods_thumb', null, $app_id, $customer_id, $section_id, $corporationid);
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
                
                $data['head_set'] = 3;
                $data['corp'] = $corporationid;
                
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('corporate/common_temp', $data);
                $this->load->view('_footer', $data);
                // $this->load->view('foot');
            }
        } else {
			redirect (site_url());
        }
    }
    
    public function edit(){
       /* if (! admin_priv ( 'product_manage' )) {
			return show_message2 ( '你没有此项操作的权限!', 'product' );
		}*/
		$params = $this->uri->uri_to_assoc ();
		if (! empty ( $params ['id'] ) && $params ['id'] > 0) {
			$id = $params ['id'];
			$this->load->model ( 'product_mdl' );
			$data ['editing'] = $this->product_mdl->load ( $id, $this->session->userdata ( 'app_info' )['id'] );

			$cid = $data ['editing'] ["cat_id"];

			if (! $data ['editing']) {
				return show_message2 ( '无效ID:' . $id, 'product' );
			}

			// 预备处理商品属性
			$attr_list = array ();
			foreach ( $data ['editing'] ['attr_list'] as $key => $attr ) {
				$attr_list [$attr ['id']] ['id'] = $attr ['id'];
				$attr_list [$attr ['id']] ['attr_name'] = $attr ['attr_name'];
				$attr_list [$attr ['id']] ['attr_type'] = $attr ['attr_type'];
				$attr_list [$attr ['id']] ['option_values'] = $attr ['option_values'];
				$attr_list [$attr ['id']] ['attr_value'] = $attr ['attr_value'];
				$attr_list [$attr ['id']] ['option_values_array'] = $attr ['option_values_array'];
				if ($attr ['attr_type'] == 'checkbox') {
					$attr_list [$attr ['id']] ['attr_values'] [] = $attr ['attr_value'];
				}
			}
			$data ['editing'] ['attr_list'] = $attr_list;

			$data ['header_text'] = '编辑商品(ID:' . $data ['editing'] ['id'] . ')';
		} else {
			$id = 0;
			$cid = $this->input->get ( 'cid' );

			// 默认选中上次编辑的选项
			$last_choose = array (
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

			$data ['editing'] = array (

					'id' => null,
					'cat_id' => $last_choose [0],
					'name' => null,
					'short_name' => null,
					'url_alias' => null,
					'brand_id' => $last_choose [1],
					'weight' => null,
					'stock' => null,
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
					'is_on_sale' => $last_choose [2],
					'is_new' => $last_choose [3],
					'is_hot' => $last_choose [4],
					'is_commend' => $last_choose [5],
					'is_vip' => $last_choose [6],
					'is_mc' => $last_choose [7],
					'in_wechat' => 0,
					'is_gift' => 0,

					'desc' => null,
					'short_desc' => null,

					'meta_title' => null,
					'meta_keywords' => null,
					'meta_desc' => null,

					'images' => array (),

					'attr_set_id' => $last_choose [6],
					'attr_list' => array ()
			);

			$data ['header_text'] = '添加商品';
		}

		// 品牌结果集，用于商品品牌选择
		$this->load->model ( 'brand_mdl' );
		$data ['brands'] = $this->brand_mdl->find_brands ( array (
				'order' => 'sort_order'
		), 0, 0 );


		// 查询
		$category = "";
		$this->load->model ( 'category_mdl' );
		$cat = $this->category_mdl->load ( $cid );
		$category = 0;
		while ( 0 != 0 ) {
			$cat = $this->category_mdl->load ( $cat ["parent_id"] );

			$category = $cat ["name"] . " > " . $category;
		}

		$data ["category"] = $category;

		// 属性分组结果集，用于商品属性选择
		// $this->load->model ( 'attribute_set_mdl' );
		// $data ['attribute_sets'] = $this->attribute_set_mdl->find_attribute_sets ();

		// $this->load->model ( 'category_mdl' );
		// $data ['categorys'] = $this->category_mdl->find_all_categorys (0);

		// attr
		//$data ['attributes'] = $this->build_attr_html ( $cid, $id );

		// print_r($data ['attributes']);
		// exit();
		//查询频道
		$this->load->model ( 'section_mdl' );
		$data ['sections'] = $this->section_mdl->get_tree_list(-1,$this->session->userdata ( 'app_info' )['id'],0);


		// 创建 编辑器
		// $this->load
		/*$this->fckeditor->BasePath = base_url () . 'fck/';
		$this->fckeditor->InstanceName = 'desc';
		$this->fckeditor->Height = '300';
		$this->fckeditor->ToolbarSet = 'Normal';
		$this->fckeditor->Value = $data ['editing'] ['desc'];
		$data ['fckeditor'] = $this->fckeditor->CreateHtml ();*/
        
//         print_r($data);exit;
        $this->load->view('head',$data);
        $this->load->view('_header', $data);
        $this->load->view('widget/edit', $data);
        $this->load->view('_footer',$data);
        //$this->load->view('foot');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
