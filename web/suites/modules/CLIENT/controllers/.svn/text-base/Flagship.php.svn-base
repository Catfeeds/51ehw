<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'Common/Uri.php';
/**
 * 品牌
 *
 *
 */
class Flagship extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	// --------------------------------------------------------------------
	
	/**
	 * 
	 */
	function verify(){ 
	    if (! $this->session->userdata('user_in') ) {
	        redirect('customer/login');
	        exit();
	    }
	    $this->load->model('corporation_mdl', 'cp');
	    $corporate = $this->cp->load_id($this->session->userdata['corporation_id'] );
	    
	    if($corporate['grade'] != 2){
	        redirect('corporate/myshop/get_shop');
	        exit();
	    }
	  
// 	    if( $this->session->userdata['corporation_id'] != 157 ){ 
// 	        redirect('corporate/myshop/get_shop');
// 	        exit();
// 	    }
	}
	/**
	 * 旗舰店
	 */
	function index() { 
	    $id_corporation = $this->input->post('corp');//店铺id
	    $cateid = 0;
	    $options['corporation_id'] = $id_corporation;
	    $options["order"] = $this->input->get_post("order");
	    $app_id = $this->session->userdata('app_info')['id'];
	    
	    $customer_id = 0;
	    $section_id = 0; 
	    
	    $this->load->model('section_mdl');
	    $this->load->model('goods_mdl');
        //查询全部分类
	    $data['shop_classify'] = $this->section_mdl->shop_classify_list($id_corporation,true,$app_id);
	    //查询顶级分类
	    $data['top_shop_classify'] = $this->section_mdl->shop_classify_list($id_corporation,true,$app_id,5);
        //查询店铺商品
        $data['produtList'] = $this->goods_mdl->get_lists_with_condition(20, 0,$cateid, array(), $options, 'p.id,p.name,p.short_name,vip_price,goods_thumb', null, $app_id, $customer_id, $section_id,$id_corporation);
        //统计店铺商品数
        $data['total_rows'] = $this->goods_mdl->get_count_with_condition($cateid, array(), array(), null, $app_id, $customer_id, $section_id,$id_corporation);
        //店铺id
//         echo $data['total_rows'];
        $data['corp_id'] = $id_corporation;
        echo json_encode($data);
	}
	
	/**
	 * 旗舰店头部分类
	 */
	function top_shop_classify(){
	    //$corporation_id = $this->session->userdata['corporation_id'];//店铺id
	    $corporation_id = $this->input->post('corporation_id');
	    $section_id = $this->input->post('section_id');
	    $app_id = $this->session->userdata('app_info')['id'];
	    $this->load->model('product_mdl');
	    $this->load->model('section_mdl','section');
	    $this->product_mdl->corporation_id = $corporation_id;
	    
	    $data['menu_list_all'] = $this->section->shop_classify_list($corporation_id,false,$app_id);
	    $data['cat_id'] = $this->_level($data['menu_list_all'],$section_id);
	    
	    $ids = array_column($data['cat_id'],'id');
	    $ids[] = $section_id;
	   
	    $data['produtList'] = $this->product_mdl->shop_classify_list($ids,$app_id,20,0);
	   
	    $data['total'] = $this->product_mdl->shop_classify_list($ids,$app_id,'','',true);
	    $data['corp_id'] = $corporation_id;
//  	    $data['total_rows'] = 21;
	    echo json_encode($data);
	}
	
	/**
	 * 查询分类下面所有的子菜单
	 */
	public function _level($arr, $pid=0,$level=0){
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
	 * ajax 分页
	 */
	function pagination(){
	    $this->load->model('goods_mdl');
	    $this->load->model('product_mdl');
	    $this->load->model('section_mdl','section');
	    $corporation_id = $this->input->post('corp');//店铺id
	    $app_id = $this->session->userdata('app_info')['id'];
	    $section_id = $this->input->post('section');
	    $options["order"]='';
	    $page = $this->input->post('page');
	   
	    if($section_id){ 
	        $data['menu_list_all'] = $this->section->shop_classify_list($corporation_id,false,$app_id);
	        $data['cat_id'] = $this->_level($data['menu_list_all'],$section_id);
	        $ids = array_column($data['cat_id'],'id');
	        $ids[] = $section_id;
	        $this->product_mdl->corporation_id = $corporation_id;
	        $produtList = $this->product_mdl->shop_classify_list($ids,$app_id,20,($page-1)*20);
	        
	    }else{
            
	        $produtList = $this->goods_mdl->get_lists_with_condition(20,($page-1)*20 , 0, array(), $options, 'p.id,p.name,p.short_name,price,vip_price,m_price,goods_thumb', null, $app_id, 0, null,$corporation_id);
	    }
	    echo json_encode($produtList);
	}
	

	/**
	 * 旗舰店添加楼层
	 */
    public function add_template()
    {
        $this->verify();
        $cor_id = $this->session->userdata['corporation_id'];
        $level = 'floor_';//$this->input->post('level'); //添加楼层成功后修改key 类似 level_id  id = 刚添加楼层的ID
        $this->load->model('template_mdl', 'tp');
        $this->tp->corporation_id = $cor_id;
        $this->tp->template_id = 4; //旗舰店id
        // $this->tp->temp_key = $level;

        $id = $this->tp->create();
        $floor = $level.$id;
        
        if( $id ){ //添加成功后修改key值
            $this->tp->temp_key = $floor;
            $res = $this->tp->update($id);
            if ($res) {
                echo json_encode($id);
            } else {
                echo 0;
            }
        }
    }
	
    /**
     * 查询旗舰店编辑模板
     */
    public function select_flagship_temp(){ 
        $this->verify();
        $corp_id = $this->session->userdata['corporation_id'];
        $this->load->model('template_mdl', 'tp');
        $data['list'] = $this->tp->select_goods_temp($corp_id,'4');
        $data['floor'] = $this->tp->select_flagship_floor( $corp_id , 'floor');
        $data['corp'] = $corp_id;
        $data['title'] = '旗舰店模板编辑';
//         echo'<pre>';
//         var_Dump($data['list']);
        $this->load->view ( 'head' ,$data);
       
        $this->load->view('corporate/shop/view/flagship_templet',$data);
    }
    
    /**
     * 旗舰店预览效果
     */
    public function flagship_temp(){ 
        $this->verify();
        $this->load->model('customer_corporation_mdl');
        $this->load->model('template_mdl', 'tp');
        $corp_id = $this->session->userdata['corporation_id'];
        $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
        $data['list'] = $this->tp->select_shop($corp_id,'4');
        $data['floor'] = $this->tp->select_flagship_floor( $corp_id , 'floor');
        $data['title'] = '旗舰店模板预览';
        if(isset($data['list']['layer-color']) ){    
            foreach ($data['list']['layer-color'] as $k => $v){ 
                foreach ($data['floor'] as $key => $val){
                    if($v['temp_key'] == 'layer-color_'.$val['id']){
                        $data['floor'][$key]['color'] = $v['desc'];
                    
                    }
                }
            }
        }
//         echo '<pre>';
//         var_Dump($data['floor']);
        $data['corp'] = $corp_id;
        $this->load->view ( 'head' ,$data);
        $this->load->view('shop_header', $data);
        $this->load->view ( 'corporation_template/flagship_templet',$data);
        $this->load->view ( '_footer' );
        $this->load->view ( 'foot' );
    }
   
    /**
     * 发布
     */
    function issue_flagship_temp(){
        $this->verify();
        $this->load->helper('file');
        $corp_id = $this->session->userdata['corporation_id'];
        $this->load->model('customer_corporation_mdl');
        $this->load->model('template_mdl', 'tp');
        $data['list'] = $this->tp->select_shop($corp_id,'4');
        $data['floor']= $this->tp->select_flagship_floor( $corp_id , 'floor');
        $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
        $data['title'] = '旗舰店';
        $data['corp'] = $corp_id;
        if(isset($data['list']['layer-color']) ){
            foreach ($data['list']['layer-color'] as $k => $v){ 
                foreach ($data['floor'] as $key => $val){
                    if($v['temp_key'] == 'layer-color_'.$val['id']){
                        $data['floor'][$key]['color'] = $v['desc'];
                    
                    }
                }
            }
        }
        $this->load->view ( 'corporation_template/flagship_templet',$data);
        //$path = "corporation_template/C_" . $corp_id . '/images/';
        
        $save_path = FCPATH . UPLOAD_PATH .'./uploads/corporation_template/C_' . $corp_id . '';
        if (!file_exists($save_path) ) {
            
            mkdir($save_path, 0777,true);
            
        }
        $content = $this->output->get_output();

        if ( !write_file($save_path . '/index.php', $content) )
            {
                echo false;
            }else{
                $this->load->model('customer_corporation_mdl');
                $this->customer_corporation_mdl->updateTemplate($corp_id, '4', $save_path);
                echo true;
            }
              
       }
       
     //----------------------------------旗舰店二
       /**
        * 编辑旗舰店模板二 
        */
       function flagship_two_temp(){ 
           $this->verify();
           $corp_id = $this->session->userdata['corporation_id'];
           $this->load->model('template_mdl', 'tp');
           $data['list'] = $this->tp->select_goods_temp($corp_id,'5');
           $data['corp'] = $corp_id;
           $data['title'] = '旗舰店模板编辑';
//            echo '<pre>';
//            var_Dump($data);
           
           //view 
           $this->load->view ( 'head' ,$data);
           $this->load->view('corporate/shop/view/flagship_two_templet');
           
       }
       
       
       /**
        * 预览旗舰店二 
        */
       function inspect_flagship_two_temp(){ 
        //预览    
        
           $this->verify();
           $this->load->model('customer_corporation_mdl');
           $this->load->model('template_mdl', 'tp');
           $corp_id = $this->session->userdata['corporation_id'];
           $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
           $data['list'] = $this->tp->select_shop($corp_id,'5');
          
           $data['title'] = '旗舰店模板预览';
           
           $data['corp'] = $corp_id;
           $data['status'] = 1;
//            echo '<pre>';
//            var_Dump($data['list']);
           $this->load->view ( 'head' ,$data);
           $this->load->view('_header', $data);
           $this->load->view ( 'corporation_template/flagship_two_templet',$data);
           $this->load->view ( '_footer' );
           $this->load->view ( 'foot' );
           
           
        
       }
       
       
       /**
        * 发布旗舰店模板二
        */
       function issue_flagship_two_temp(){ 
           $this->verify();
           $this->load->helper('file');
           $this->load->model('customer_corporation_mdl');
           $this->load->model('template_mdl', 'tp');
           $corp_id = $this->session->userdata['corporation_id'];
           $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
           $data['list'] = $this->tp->select_shop($corp_id,'5');
           
           $data['title'] = '旗舰店模板预览';
            
           $data['corp'] = $corp_id;
           //            echo '<pre>';
           //            var_Dump($data['list']);
           
           $this->load->view ( 'corporation_template/flagship_two_templet',$data);
           $save_path = FCPATH . UPLOAD_PATH .'./uploads/corporation_template/C_' . $corp_id . '';
           if (!file_exists($save_path) ) {
           
               mkdir($save_path, 0777,true);
           
           }
           $content = $this->output->get_output();
           
           if ( !write_file($save_path . '/index.php', $content) )
           {
               echo false;
           }else{
               $this->load->model('customer_corporation_mdl');
               $this->customer_corporation_mdl->updateTemplate($corp_id, '5', $save_path);
               echo true;
           }
       }
       //-------------------------------------旗舰店二结束
       
       
       //-------------------------------------旗舰店三开始
       
       //编辑页面
       function flagship_three_temp(){ 
           $this->verify();
           $corp_id = $this->session->userdata['corporation_id'];
           $app_id = $this->session->userdata('app_info')['id'];
           $this->load->model('section_mdl', 'section');
           $this->load->model('template_mdl', 'tp');
           $data['list'] = $this->tp->select_goods_temp($corp_id,'6');
//            echo '<pre>';
//            var_dump($data['list']);
           $data['corp'] = $corp_id;
           $data['title'] = '旗舰店模板编辑';
           $data['menu_list'] = $this->section->shop_classify_list($corp_id,true,$app_id);
           $this->load->view ( 'head' ,$data);
           $this->load->view('corporate/shop/view/flagship_three_templet');
            
       }
       
       //预览页面
       function inspect_flagship_three_temp(){ 
           

           $this->verify();
           $this->load->model('customer_corporation_mdl');
           $this->load->model('template_mdl', 'tp');
           $this->load->model('section_mdl', 'section');
           $app_id = $this->session->userdata('app_info')['id'];
           $corp_id = $this->session->userdata['corporation_id'];
           $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
           
           $data['list'] = $this->tp->select_shop($corp_id,'6');
           $data['menu_list'] = $this->section->shop_classify_list($corp_id,true,$app_id);
          
           $data['title'] = '旗舰店模板预览';
            
           $data['corp'] = $corp_id;
           $data['status'] = 1;
           $this->load->view ( 'head' ,$data);
           $this->load->view('shop_header', $data);
           $this->load->view ( 'corporation_template/flagship_three_templet',$data);
           $this->load->view ( '_footer' );
           $this->load->view ( 'foot' );
           
       }
       
       //发布功能
       function issue_flagship_three_temp(){ 
           $this->verify();
           $this->load->helper('file');
           $this->load->model('customer_corporation_mdl');
           $this->load->model('template_mdl', 'tp');
           $this->load->model('section_mdl', 'section');
           $corp_id = $this->session->userdata['corporation_id'];
           $app_id = $this->session->userdata('app_info')['id'];
           $data["corporation"] = $this->customer_corporation_mdl->getById($corp_id);
           $data['list'] = $this->tp->select_shop($corp_id,'6');
           $data['menu_list'] = $this->section->shop_classify_list($corp_id,true,$app_id);
           $data['title'] = '旗舰店模板预览';
           
           $data['corp'] = $corp_id;
           //            echo '<pre>';
           //            var_Dump($data['list']);
            
           $this->load->view ( 'corporation_template/flagship_three_templet',$data);
           $save_path = FCPATH . UPLOAD_PATH .'./uploads/corporation_template/C_' . $corp_id . '';
           if (!file_exists($save_path) ) {
                
               mkdir($save_path, 0777,true);
                
           }
           $content = $this->output->get_output();
            
           if ( !write_file($save_path . '/index.php', $content) )
           {
               echo false;
           }else{
               $this->load->model('customer_corporation_mdl');
               $this->customer_corporation_mdl->updateTemplate($corp_id, '6', $save_path);
               echo true;
           }
       }
       //-------------------------------------旗舰店三结束
}