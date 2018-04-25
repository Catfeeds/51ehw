<?php
    if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
    
/**
* 产品管理控制器
* @author jiangfeng
*
*/
class Product extends Front_Controller {
    public $customer_id;
    public $tribe_id;
    
    /**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		//         判断用户是否登录
		// 判断用户是否登录
		if (! $this->session->userdata('user_in') )
		{
		    redirect('customer/login');
		    exit();
		}
		$this->load->model("Easyshop_mdl");
		$this->customer_id  = $this->session->userdata("user_id");
		$tribe_id = $this->input->get_post('tribe_id');
		
		if( $tribe_id && is_numeric( $tribe_id ) && strpos( $tribe_id,'.') == false)
		{
		    $this->load->model('tribe_mdl');
		    $tribe_info = $this->tribe_mdl->load( $tribe_id,$this->customer_id );
		    
		    if( !$tribe_info )
		    {
		        //部落不存在，或未通过。
		        echo "<script>history.back(-1);alert('部落不在，无法访问');</script>";exit;
		        
		    }else if( !$tribe_info["tribe_staff_id"] || $tribe_info['status'] != 2 )
		    {
		        //未加入该部落
		        echo "<script>history.back(-1);alert('未加入该部落，无法访问');</script>";exit;
		    }
		}else{
		    //未加入该部落
		    echo "<script>history.back(-1);alert('参数错误');</script>";exit;
		}
		
		$this->tribe_id = $tribe_id;
		$this->bg_img = $tribe_info['ts_bg_img'];
		$this->member_name = $tribe_info['member_name'];
		$this->tribe_name = $tribe_info['name'];
		$this->real_name = $tribe_info['real_name'];
		$this->tribe_staff_id = $tribe_info['tribe_staff_id'];
		$this->tribe_role_id = $tribe_info['tribe_role_id'];
		
		$this->load->model("tribe_mdl");
		$tribe = $this->tribe_mdl->ManagementTribe($this->customer_id,$tribe_id);
		$is_host = 0;
		if($tribe){
		    $is_host = 1;
		}
		
		$this->is_host = $is_host;
		$this->load->helper('format_time');
	}
	
	/**
	 * @author JF
	 * 2018年3月16日
	 * 发布产品页
	 */
	public function ReleaseGoodsView(){
	    $tribe_id = $this->tribe_id;
// 	    echo '11';exit;
	    $data['title'] = "发布产品";
// 	    $data['status'] = 0;
	    $data['tribe_id'] = $tribe_id;
	    $data['head_set'] = 2;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('easyshop/product/release_goods', $data);
	}
    
    public function addproduct () {
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
//         print_r($corp_user);exit;
        $power = $this->session->userdata("power");//权限\
        if(!$corp_user && !strpos($power,"/Corporate/product/edit,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        $corporation_id = $this->session->userdata('corporation_id');//企业id
        
        if( !$corporation_id )
        {
            redirect('Corporation/home_page');
            exit();
            
        }
    }
    
    
    /**
     *
     * 上传相册图片
     */
    public function upload_album(){
        
        $data_post = $this->input->post();
        
        //判断价格是否为整数
        if (!is_numeric($data_post['price']) || strpos($data_post['price'], '-') || $data_post['price'] == '0') {
            return;
        }
        //判断是否为正整数
        if (!is_numeric($data_post['inventory']) || strpos($data_post['inventory'],'.') !==false || strpos($data_post['inventory'],'-') !==false) {
            return;
        }
        
        //用户ID
        $customer_id = $this->session->userdata("user_id");
        //部落ID
        $tribe_id = $this->tribe_id;
        //简易店ID
        $easyshop_id= $this->session->userdata("Easyshop_id");
        $image = array();
        $images = array();
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
        $files =  $data_post['file'];
        if($files)
        {
            
            $this->load->model('Easyshop_mdl');
            $created_at = date("Y-m-d H:i:s",time());
            $post['easy_corp_id'] = $easyshop_id;
            $post['tribe_id'] = $tribe_id;
            //标题
            $post['product_name'] = $data_post['title'];
            //描述
            $post['desc'] = $data_post['describe'];
            //价格
            $post['price'] = $data_post['price'];
            //库存
            $post['stock'] = $data_post['inventory'];
            $post['is_on_sale'] = '0';
            $post['remarks'] = '';
            $post['sort'] = '0';
            $post['created_at'] = $post['update_at'] = $created_at;
            
            //开启事务
            $this->db->trans_start();
            
            $product_id =$this->Easyshop_mdl->create_easy_product($post);
            
            //判断是否保存数据，未成功，事务回滚
            if ($product_id == false) {
                echo '未插入简易店产品!';
                $this->db->trans_rollback();
                return;
            }
          
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
            // 图片 初始化数据
            $save_path = "./uploads/easy_product/$year/$month/$day/";
            
            $path = FCPATH.UPLOAD_PATH. $save_path;
            
            if ( !file_exists( $path ) )
            {
                mkdir($path,0777,true);
            }
            $multip = array();
            //记录该上传的图片  避免重复上传
            //处理要上传的图片写入文件夹  不需要的的则不处理
            foreach ($img_add as $key => $val){
                foreach ($files as $k => $v){
                    if($val == $v['pic_sign']){
                        if(!in_array($key, $multip)){
                            $pic = $v['pic'];
                            $temp = explode('.',$v['pic_name'])[1];
                            //处理64位
                            $base64    = substr(strstr($pic, ","), 1);
                            $image_res = base64_decode($base64);
                            $pic_path = $save_path.date("YmdHis").rand(0,999999).'.'.$temp;
                            $res = file_put_contents(FCPATH.UPLOAD_PATH.$pic_path ,$image_res);
                            if($res){
                                $image['product_id']= $product_id;
                                $image['pic_rank'] = '0';
                                $image['path']= $pic_path;
                                $image['type']= '0';
                                $images[]= $image;
                                $multip[] = $key;
                            }
                        }
                    }
                }
            }
            if ($images['0']) {
                $images['0']['type'] = '1';
            }
            
            //添加图片数据
            $id = $this->Easyshop_mdl->create_img( $images );
            
            //判断是否保存数据，未成功，事务回滚
            if ($id == false) {
                echo '未保存简易店图片!';
                $this->db->trans_rollback();
                return;
            }
            
            //关闭事务
            $this->db->trans_complete();
            
            //事务错误报告
            if ($this->db->trans_status() === FALSE)
            {
                log_message('error','trans error!');
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            
            $return['status'] = $id ? true : false;
            echo json_encode($return);
        }else{
            $return['status'] = false;
            echo json_encode($return);
        }
    }
    
    /*
     * 
     * 个人发布的商品页面
     */
    public function personal_list () {
        $this->load->model('Easyshop_mdl');
        //部落ID
        $tribe_id = $this->tribe_id;
        //简易店ID
        $easyshop_id= $this->session->userdata("Easyshop_id");

        $data['tribe_id'] = $tribe_id;
        $data['title'] = "我发布的";
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('easyshop/product/myrelease', $data);
    }
    
    /*
     * 
     * 下拉刷新数据
     * 
     */
    public function load_new_product () {
        //部落ID
        $tribe_id = $this->tribe_id;
        //简易店ID
        $easyshop_id= $this->session->userdata("Easyshop_id");
        $page = $this->input->post("page");//页数s
        if(0 == $page)
        {
            $page = 1;
        }
        $limit = 5;//每页显示的数量
        $offset = ($page-1)*$limit;//偏移量 
        $this->load->model('Easyshop_mdl');
        $easyshop_personal_product = $this->Easyshop_mdl->personal_product_select($easyshop_id,$tribe_id,$limit,$offset);
        
        foreach ($easyshop_personal_product as $key => $value) {
            if (ceil($value['price']) == $value['price']) {
                $value['price'] = intval($value['price']);
            } else {
                $value['price'] = $value['price'];
            }
            $img_data = $this->Easyshop_mdl->img_data($value['id']);
            if (empty($img_data)) {
                $value['img_path'] = null;
            } else {
                $value['img_path'] = $img_data['0']['path'];
                $value['img_path'] = substr($value['img_path'],2);
            }
            if ($value['is_on_sale'] == '0') {
                $value['on_sale'] = '上架';
            } elseif ($value['is_on_sale'] == '1') {
                $value['on_sale'] = '下架';
            } else {
                $value['on_sale'] = $value['is_on_sale'];
            }
            $easyshop_personal_product[$key] = $value;
        }
        $data['list'] = $easyshop_personal_product;
        $data['tribe_id'] = $tribe_id;      
        echo json_encode($data);
    }
    
    /*
     * 
     * 商品详情
     */
    public function easyshop_product_detail($product_id)
    {
        $this->load->model('Easyshop_mdl');
        $data = $this->Easyshop_mdl->producy_detail($product_id);
        $product_img = $this->Easyshop_mdl->img_data($product_id);
        $data['img_data'] = $product_img;
        echo json_encode($data);
    }
    
    /*
     * 
     * 删除商品
     */
    public function del_product () {
        $easyshop_id= $this->session->userdata("Easyshop_id");
        $id = $this->input->post();
        if (empty($id)) {
            $return = array(
                'Type'=>0,
                'Msg'=>'没有此商品',
            );
            echo json_encode($return);
            exit();
        } else {
            $id = $id['id'];
        }
        $update_data = array(
            'is_on_sale' => '3',
            'sort' => '0',
        );
        $is_order_data = $this->db->where('product_id',$id)->from('easy_order')->get()->result_array();
        if (empty($is_order_data)) {
            $this->db->where('id',$id)->where('easy_corp_id',$easyshop_id)->update('easy_product',$update_data);
            $update_status = $this->db->affected_rows();
            if (empty($update_status)) {
                $return = array(
                    'Type'=>4,
                    'Msg'=>'删除数据失败',
                );
                echo json_encode($return);
                exit();
            } else {
                $return = array(
                    'Type'=>1,
                    'Msg'=>'删除成功',
                );
            }
        } else {
            $return = array(
                'Type'=>2,
                'Msg'=>'已有订单，删除失败',
            );
        }
        echo json_encode($return);
    }
    
    /*
     * 
     * 下架商品
     */
    public function down_up_product () {
        $easyshop_id= $this->session->userdata("Easyshop_id");
        $post_data = $this->input->post();
        if (empty($post_data)) {
            $return = array(
                'Type'=>0,
                'Msg'=>'商品信息错误',
            );
            echo json_encode($return);
            exit();
        }
        $id = $post_data['id'];
        $label_data= $post_data['label_data'];
        
        if ($label_data == '上架') {
            $update_data = array(
                'is_on_sale' => '1'
            );
        } elseif ($label_data== '下架') {
            $update_data = array(
                'is_on_sale' => '0'
            );
        } else {
            $update_data = array(
                'is_on_sale' => '0'
            );
        }
        $this->db->where('id',$id)->where('easy_corp_id',$easyshop_id)->update('easy_product',$update_data);
        $update_status = $this->db->affected_rows();
        if (empty($update_status)) {
            $return = array(
                'Type'=>2,
                'Msg'=>'操作失败',
            );
        } else {
            $is_on_sale= $update_data['is_on_sale'];
            $return = array(
                'Type'=>1,
                'is_on_sale' => $is_on_sale,
                'Msg'=>'操作成功',
            );
        }
        echo json_encode($return);
    }
    
    /*
     *
     * 部落搜索商品页面
     */
    public function tribe_search_goods () {
        $data['keyword'] = $this->input->get_post("keyword");//搜索关键词
        $data['tribe_id'] = $this->input->get_post("tribe_id");//部落id
        $data['navigate'] = $this->input->get_post("navigate");//1为商城2为部落
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('tribe/tribe_goods_search', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * h5搜索五种模式
     * 模式1：简单的搜索商品名称。
     * 模式2：没有任何关键词和分类，查询整个商品。
     */
    function ajax_search_goods(){
        $tribe_id = $this->input->get_post("tribe_id");//部落id
        $keyword = $this->input->get_post("keyword");//搜索关键词
        $keyword = trim($keyword);//移除字符串2侧的空格
        $type = $this->input->get_post("type");//类型
        $navigate= $this->input->get_post("navigate");//1为商城2为部落
        $customer_id = $this->session->userdata("user_id");//用户id
        //             print_r($keyword);exit;
        
        $this->load->model("tribe_mdl");
        $this->load->model("product_mdl");
        $this->load->model("goods_mdl");
        
        //查询我加入的部落
        $tribe_list = $this->tribe_mdl->Customer_Tribe_List($customer_id);
        $tribeids = array_column($tribe_list,"id");
        
        //判断部落
        if($tribe_id){
            //判断是否有登录
            if(!$customer_id){
                $data["status"] = 1;
                echo json_encode($data);exit;
            }
            //判断我是否属于此部落,如果不属于则登录
            $is_tribe = $this->tribe_mdl->is_tribe_customer($tribe_id,$customer_id);//查询我是否属于此部落
            if(!in_array($tribe_id,$tribeids)){
                $data["status"] = 1;
                echo json_encode($data);exit;
            }
        } else {
            //部落不存在
            $data["status"] = 0;
            echo json_encode($data);exit;
        }
        
        $limit = 20;//显示条数
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        $offset = ($page-1)*$limit;//偏移量
        
        //1为商城 ，2为部落
        if ($navigate == '1') {
            switch ($type){
                case "1"://销量
                    $productList = $this->product_mdl->tribe_search_list('0','1',$keyword,$offset,$limit);
                    break;
                case "2"://销量
                    $productList = $this->product_mdl->tribe_search_list('0','2',$keyword,$offset,$limit);
                    break;
                case "3"://价格
                    $productList = $this->product_mdl->tribe_search_list('0','3',$keyword,$offset,$limit);
                    break;
                case "4"://价格
                    $productList = $this->product_mdl->tribe_search_list('0','4',$keyword,$offset,$limit);
                    break;
                case "5"://权重
                    $productList = $this->product_mdl->tribe_search_list('0','5',$keyword,$offset,$limit);
                    break;
                default:
                    $productList = $this->product_mdl->tribe_search_list('0','6',$keyword,$offset,$limit);
                    break;
            }
        } else {
            switch ($type){
                case "1"://销量
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'1',$keyword,$offset,$limit);
                    break;
                case "2"://销量
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'2',$keyword,$offset,$limit);
                    break;
                case "3"://价格
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'3',$keyword,$offset,$limit);
                    break;
                case "4"://价格
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'4',$keyword,$offset,$limit);
                    break;
                case "5"://权重
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'5',$keyword,$offset,$limit);
                    break;
                default:
                    $productList = $this->product_mdl->tribe_search_list($tribe_id,'6',$keyword,$offset,$limit);
                    break;
            }
        }
        $data['productList'] = $productList;
        $data["status"] = 3;//搜索无异常
        $data["tribeids"] = $tribeids;//我加入部落的id
        echo json_encode($data);
    }
    
    /*
     *
     * 商品详情
     */
    public function good_detail ($id) {
        if (empty($id)) {
            return;
        }
        $tribe_id = $this->tribe_id;
        $this->load->model("product_mdl");
        $data['data'] = $this->product_mdl->goods_img_detail($id);
        if (empty($data['data']['0'])) {
            return;
        }
        $data['goods_id'] = $id;
        $data['tribe_id'] = $tribe_id;
        $this->load->view('head', $data);
        $this->load->view('tribe/commodity_details', $data);
    }
    
    
    
    
    
    
	
	
	
}
