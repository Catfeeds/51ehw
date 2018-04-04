<?php
/**
 * 分类下的商品
 *
 *
 */
class Category extends Front_Controller
{
	function __construct()
    {
        parent::__construct();		
    }
   
    // --------------------------------------------------------------------

    /**
	 * 分类列表
	 *
	 *
	 */	
    function index()
    {
       $data = array();
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/allsort.css'>";
	   $data['title'] = '全部分类';
		$data['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
	    $this->load->view('category/list',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
    }


    // --------------------------------------------------------------------

    /**
	 * 一级分类
	 *
	 *
	 */	
	function index_1()
	{
		//判断是否二级分类，否则跳转到首页
		$segments = $this->uri->uri_to_assoc();
		if (!empty($segments['cat_id'])){
		    $cat_id = (int)$segments['cat_id'];
			$this->load->model('category_mdl');
			$cat = $this->category_mdl->load($cat_id);		
			if (empty($cat)){
                redirect('home');
			    exit();
			}else if($cat['level'] != 1){
                redirect('home');
			    exit();
			}
		}else{
			redirect('home');
			exit();
		}

		$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/electronic.css' />";
	    $data['title'] = $cat['name'].'&nbsp;【行情  价格 评价 正品行货】';
		$data['cat'] = $cat;
		$data['nav_index'] = $cat['id']+1;

		$this->load->view('category/list_1',$data);
	}


    // --------------------------------------------------------------------

    /**
	 * 二级分类
	 *
	 *
	 */	
	function index_2()
	{
		$this->load->model('category_mdl');
		//判断是否二级分类，否则跳转到首页
		$segments = $this->uri->uri_to_assoc();
		if (!empty($segments['cat_id'])){
		    $cat_id = (int)$segments['cat_id'];
			$cat = $this->category_mdl->load($cat_id);		
			if (empty($cat)){
                redirect('home');
			    exit();
			}else if($cat['level'] != 2){
                redirect('home');
			    exit();
			}
		}else{
			redirect('home');
			exit();
		}

		$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/plist.css' />";
	    $data['title'] = $cat['name'].'&nbsp;【行情  价格 评价 正品行货】';
		$data['cat'] = $cat;
        
		//所属分类
		$data['parent'] = $this->category_mdl->load($cat['parent_id']);

		//该分类下的子分类
		$data['childs'] = $this->category_mdl->find_childs($cat['id']);

		//顶级菜单索引
		$data['nav_index'] = $cat['parent_id']+1;

        //本分类下的产品

		  //计算查询条件
		$options = array('order'=>null);
		if(!empty($segments['order'])){
			switch($segments['order']){
				case 'price_up' : $options['order'] = 'price_up';break;
				case 'price_down' : $options['order'] = 'price_down';break;
				case 'osa' : $options['order'] = 'osa';break;
				default : $options['order'] = null;
			}
		}
          //分类下属产品总数
		$this->load->model('product_mdl');
		$cat_ids = $this->category_mdl->find_sub_cat_ids($cat_id);
		$total = $this->product_mdl->count_products_by_category($cat_ids); 
		$data['total'] = $total;

		  //分页配置
		$this->config->set_item('enable_query_strings',FALSE) ;
        $config = $this->config->item('pagination');

		  //生成分页
        $this->load->library('pagination');
        $config['base_url'] = site_url('category/index_2/cat_id/'.$cat_id.'/page') . '/';
		$config['uri_segment'] = '6';
        if ($options['order']){
            $config['base_url'] = site_url('category/index_2/cat_id/'.$cat_id.'/order/'.$options['order'].'/page') . '/';
		    $config['uri_segment'] = '8';
		}
		$config['total_rows'] = $data['total'];
		$config['per_page'] = '15';	
		$this->pagination->initialize($config); 
		$data['pagination'] = $this->pagination->create_links();

           //offset
		if (!empty($segments['page']) && (int)$segments['page']>0){
            $page_offset = (int)$segments['page'];			
        } else {
            $page_offset = 0;
        }      
		$products = $this->product_mdl->find_products_by_category($cat_ids, $options, $config['per_page'],$page_offset);

          //添加商品主图信息
		foreach($products as $key => $product):			
			$this->load->model('image_mdl');	
			$product_base_image = $this->image_mdl->find_product_base_image((int)$product['id']);
			if (empty($product_base_image)){//如果没有建立主图，就从相册中取
				$product_images = $this->image_mdl->find_product_images((int)$product['id']);
				if (!empty($product_images)){
                    $product_base_image = $product_images[0];
				}else{
                    $product_base_image = array('image_name'=>'','file'=>'','file_ext'=>'');
				}
			}
			$products[$key]['base_image'] = $product_base_image;
		endforeach;
        $data['products'] = $products;

		$this->load->view('category/list_2',$data);
	}


    // --------------------------------------------------------------------

    /**
	 * 三级分类
	 *
	 *
	 */	
	function index_3()
	{
		//判断是否三级分类，否则跳转到首页
		$segments = $this->uri->uri_to_assoc();
		if (!empty($segments['cat_id'])){
		    $cat_id = (int)$segments['cat_id'];
			$this->load->model('category_mdl');
			$cat = $this->category_mdl->load($cat_id);		
			if (empty($cat)){
                redirect('home');
			    exit();
			}else if($cat['level'] != 3){
                redirect('home');
			    exit();
			}
		}else{
			redirect('home');
			exit();
		}
        
		$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/plist_a.css' />";
	    $data['title'] = $cat['name'].'&nbsp;【行情  价格 评价 正品行货】';
		$parent = $this->category_mdl->load($cat['parent_id']);
		$grandparent = $this->category_mdl->load($parent['parent_id']);
        
		//本分类
        $data['cat'] = $cat;

		//所属二级分类
		$data['parent'] = $parent;

		//所属一级分类
		$data['grandparent'] = $grandparent;

		//顶级菜单索引
		$data['nav_index'] = $parent['parent_id']+1;

		//本分类下的产品

          //计算查询条件
		$options = array('order'=>null);
		if(!empty($segments['order'])){
			switch($segments['order']){
				case 'price_up' : $options['order'] = 'price_up';break;
				case 'price_down' : $options['order'] = 'price_down';break;
				case 'osa' : $options['order'] = 'osa';break;
				default : $options['order'] = null;
			}
		}

		$this->load->model('product_mdl');
		$data['total'] = $this->product_mdl->count_products_by_category(array((int)$cat['id']),$options); 		
		
		  //分页配置
		$this->config->set_item('enable_query_strings',FALSE) ;
        $config = $this->config->item('pagination');
		  //生成分页
        $this->load->library('pagination');
        $config['base_url'] = site_url('category/index_3/cat_id/'.$cat_id.'/page') . '/';
		$config['uri_segment'] = '6';
        if ($options['order']){
            $config['base_url'] = site_url('category/index_3/cat_id/'.$cat_id.'/order/'.$options['order'].'/page') . '/';
		    $config['uri_segment'] = '8';
		}
		$config['total_rows'] = $data['total'];
		$config['per_page'] = '20';	
		$this->pagination->initialize($config); 
		$data['pagination'] = $this->pagination->create_links();
          //offset
		if (!empty($segments['page']) && (int)$segments['page']>0){
            $page_offset = (int)$segments['page'];			
        } else {
            $page_offset = 0;
        }      
		$products = $this->product_mdl->find_products_by_category(array((int)$cat['id']), $options, $config['per_page'],$page_offset);

        //添加商品主图信息
		foreach($products as $key => $product):			
			$this->load->model('image_mdl');	
			$product_base_image = $this->image_mdl->find_product_base_image((int)$product['id']);
			if (empty($product_base_image)){//如果没有建立主图，就从相册中取
				$product_images = $this->image_mdl->find_product_images((int)$product['id']);
				if (!empty($product_images)){
                    $product_base_image = $product_images[0];
				}else{
                    $product_base_image = array('image_name'=>'','file'=>'','file_ext'=>'');
				}
			}
			$products[$key]['base_image'] = $product_base_image;
		endforeach;
        $data['products'] = $products;		
		
		$this->load->view('category/list_3',$data);
	}
	
	//------------------------------------------------------------------------------------------------
	
	/**
	 * 显示列表
	 * @param unknown $id
	 * @param number $page
	 */
	function get_list($id, $page = 1){

		$data = array();

		// 广告图
		$this->load->model ( 'ad_mdl' );
		$data ['adList'] = $this->ad_mdl->getBySign ( 'LIST', $id );
		
		// 分类资料
		$this->load->model ( 'category_mdl' );
		$data['category'] = $this->category_mdl->load($id); 
		
		$data['title'] = $data['category']['name'];
		
		// 所有产品
		$this->load->model ( 'goods_mdl' );
		//$data ['products'] = $this->goods_mdl->get_lists (array($id));
		//$data ['product_count'] = $this->goods_mdl->get_lists_count (array($id));

		$data["page"] = $page;//$this->input->get_post("page");
		$data["pagesize"] = 32;
		$data["order"] = 'onsale_down';//$this->input->get_post("order");
		//分页设置
				
			
		$this->load->library('pagination');
		$config['base_url'] = site_url('category/get_list/'.$id);
		$config['suffix'] = "";//$pagecondition;
		$config['total_rows'] = $this->goods_mdl->get_count_with_condition($id);
		$config['uri_segment'] = 4;
		$config['per_page'] = 32;
		$config['curr_page'] = $data["page"];
		$config['num_links'] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<li>';
		$config['full_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE ;
		$config['last_link'] = FALSE ;
		$config['next_link'] = '';
		$config['next_tag_css'] = 'class="next-page"';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '';
		$config['prev_tag_css'] = 'class="prev-page"';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		//$config['cur_tag_css'] = 'class="current"';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:">';
		$config['cur_tag_close'] = '</a></li>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		//print_r($data["pagination"]);
			
		//查询产品
		//$count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);
		$produtList = $this->goods_mdl->get_lists_with_condition($data["pagesize"],($data["page"]-1)*$data["pagesize"],$id,array(),array("order"=>$data["order"]));
		//print_r($produtList);
		$data["products"] = $produtList;
		$data["totalcount"] = $config["total_rows"];
		$data["totalpage"] = ceil($config["total_rows"]/$data["pagesize"]);
		
		

		$this->load->view('head',$data);
		$this->load->view('_header');
		$this->load->view('goods/list',$data);
		$this->load->view('_footer', $data);
		$this->load->view('foot',$data);
	}
	
	//------------------------------------------------------------------------------------------------
}

?>