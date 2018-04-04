<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 需求管理控制器
 * 
 * 查看会员列表
 * 
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Demand extends Front_Controller {
	
	// --------------------------------------------------------------------
	public $cate_id;
	/**
	 * 构造函数
	 */
	public function __construct() {
        parent::__construct();
        $this->session->set_userdata('redirect', current_url());
        $this->load->model('demand_mdl');
        $this->load->model('corporation_mdl');
    }
	
	// --------------------------------------------------------------------
	
	/**
	 * 我的需求列表
	 */
    public function index($status=0){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        
        //搜索参数
        $data['keyword'] = $keyword = $this->input->get('keyword');
        if(isset($keyword) && $keyword!=""){
            $keyword = explode(" ",trim($keyword));
        }
        
        $customer_id = $this->session->userdata('user_id');
	    //分页
	    $this->load->library('pagination');
	    $config['per_page'] = 20; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    //判断如果没有页数默认一页
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    //偏移量
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    $config['base_url'] = site_url('member/demand/index').'/'.$status.'?keyword='.$data['keyword'];//路径配置
	    $data['total_rows'] = $config['total_rows'] = $this->demand_mdl->count_total($customer_id,$status,$keyword);//显示总条数
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 5; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config ['prev_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $this->pagination->initialize($config);//初始化配置
	    $data['page'] =  $this->pagination->create_links();//执行
        
	    //查询我的需求
	    $data['list'] = $this->demand_mdl->get_requirement($customer_id,$status,'a.*,c.id as cate_id,c.name',$config['per_page'],$offset,$keyword);

        //统计
        $data['all'] = $this->demand_mdl->count_total($customer_id,0);//全部
        $data['wait'] = $this->demand_mdl->count_total($customer_id,1);//待审核
        $data['pass'] =  $this->demand_mdl->count_total($customer_id,2);//通过
        $data['fail'] =  $this->demand_mdl->count_total($customer_id,3);//不通过
        $data['fall'] = $this->demand_mdl->count_total($customer_id,4);//下架
        $data['del'] = $this->demand_mdl->count_total($customer_id,5);//删除
        
        $data ['status'] = $status;
	    $data ['title'] = '供需管理';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header',$data );
	    $this->load->view ( 'demand/demand_my',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data); 
    }
    
    // --------------------------------------------------------------------
    
    function test(){
        $data = 1;
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'corporate/demand/demand_supply',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    /**
     * 填写需求
     */
    public function add_list(){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        //清空session
        $this->session->unset_userdata("demand_temp_image");
        
        $data['status'] = 0;
        
        $id = $this->input->get('id');
        if($id){
            $customer_id = $this->session->userdata('user_id');
            //查询我的需求
            $data['detail'] = $this->demand_mdl->get_details($id,$customer_id);
            if(empty($data['detail']['id'])){
                echo "<script>alert('需求不存在');history.back();</script>"; 
                exit;
            }
            
            //把图片路径存到session
            if($data['detail']['img_path']){
                $data['img'] = explode(';',trim($data['detail']['img_path'],';'));
                $this->session->set_userdata("demand_temp_image", $data['img']);
                $this->session->userdata("demand_temp_image");
            }
            $data['status'] = 1;
        }
        
        //查询顶级分类
	    $this->load->model('category_mdl');
	    $data['categorys'] = $this->category_mdl->get_child(0, 0);
        
        $data ['title'] = '供需管理';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'demand/demand_publish',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 添加需求数据
     */
    public function add_demand(){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        
            $img_path='';
            if (!empty($session = $this->session->userdata("demand_temp_image"))) {//保存session
                foreach ($session as $val){
                    $img_path .= $val.';';
                }
            }
            //清空session
            $this->session->unset_userdata("demand_temp_image");


            $this->demand_mdl->explain = $this->input->post('explain');
            $this->demand_mdl->title = $this->input->post('title');
            $this->demand_mdl->number = $this->input->post('number');
            $this->demand_mdl->unit = $this->input->post('unit');
            $this->demand_mdl->price_min = $this->input->post('price_min');
            $this->demand_mdl->price_max = $this->input->post('price_max');
            $this->demand_mdl->receiptdate = $this->input->post('receiptdate');
            $this->demand_mdl->effectdate = $this->input->post('effectdate');
            $this->demand_mdl->address = $this->input->post('address');
            $this->demand_mdl->needtax = $this->input->post('needtax');
            $this->demand_mdl->price_demand = $this->input->post('price_demand');
            $this->demand_mdl->m_price = $this->input->post('m_price');
            $this->demand_mdl->cate_id = $this->input->post('cate_id');
            
            $this->demand_mdl->province_id = $this->input->post('province_id');
            $this->demand_mdl->city_id = $this->input->post('city_id');
            $this->demand_mdl->district_id = $this->input->post('district_id');
            $this->demand_mdl->img_path = $img_path;
            $this->demand_mdl->app_id = $this->session->userdata("app_info")["id"];
            
            $status = $this->input->post('status');
            $id = $this->input->post('id');
            if($status){
                if($this->demand_mdl->edit($id)){
                    echo true;
                }else{
                    echo false;
                }
            }else{
                echo $this->demand_mdl->add_demand();
            }

    }
    
    // --------------------------------------------------------------------
    
    /**
     * 预览页面
     */
    public function demand_details($id){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        
        $customer = $this->session->userdata('user_id');
        $data['detail'] = $this->demand_mdl->get_details($id,$customer);
        if(empty($data['detail']['id'])){
            echo "<script>alert('需求不存在');history.back();</script>"; 
            exit;
        }
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        $data ['title'] = '供需管理';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'demand/demand_details',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    
    /**
     * 用户查看详情
     */
    public function demand_detail($id){
        $data['detail'] = $this->demand_mdl->get_details($id);
        if(empty($data['detail']['id'])){
            echo "<script>alert('需求不存在');history.back();</script>";
            exit;
        }
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        $data ['title'] = '供需管理';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header' ,$data);
        $this->load->view ( 'demand/demand_details',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * 添加换货信息
     */
    public function barter(){
       

        $barter["remark"] = $this->input->post('remark');
        $barter["contactuser"] = $this->input->post('contactuser');
        $barter["requirement_id"] = $this->input->post('requirement_id');
        $barter["customer_id"] = $this->session->userdata('user_id');
        
        if(preg_match("/^1[34578]\d{9}$/", $barter["contactuser"]) || preg_match("/^([0-9]{3,4}-)?[0-9]{7,8}$/", $barter["contactuser"])){}else{
            echo "请填写正确的联系方式";
            exit;
        }
        $row = $this->demand_mdl->add_barter($barter);
        if($row){
            echo "急速为您匹配换货商中，请耐心等待";
        }else{
            echo "换货失败";
        }
//         redirect('member/demand/demand_details/'.$barter["requirement_id"]);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 需求池列表
     */
    public function demand_list(){

        //排序
        $data['sort'] = $sort = $this->input->get('sort');
        
        //搜索参数
        $data['keyword'] = $keyword = $this->input->get('keyword');
        if(isset($keyword) && $keyword!=""){
            $keyword = explode(" ",trim($keyword));
        }
        
        $data['cateid'] = $cateid = $this->input->get('cateid');
        $cateids = array();
        //如果有筛选分类，查询子分类
        if($cateid){
            $this->load->model('goods_mdl');
            $cateids[] = $cateid;
            $row = $this->goods_mdl->get_sub_classification($cateid);
            foreach ($row as $v){
                $cateids[] = $v['id'];
            }
        }
        
        //查询分类名字
        $this->load->model('product_cat_mdl');
        if($cateid){
            $data['catename']  = $this->product_cat_mdl->get_cate($cateid)['name'];
        }else{
            $data['catename'] = "全部";
        }
       
   
        //查询顶级分类
        $this->load->model('category_mdl');
        $data['categorys'] = $this->category_mdl->get_child(0, 0);
        
        //分页
        $this->load->library('pagination');
        $config['per_page'] = 50; //每页显示几条
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        //判断如果没有页数默认一页
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        //偏移量
        $offset   = ($current_page - 1 ) * $config['per_page'];
        $config['base_url'] = site_url('member/demand/demand_list').'?cateid='.$cateid.'&keyword='.$data['keyword'].'&sort='.$data['sort'].'/';//路径配置
        $data['total_rows'] = $config['total_rows'] = $this->demand_mdl->count_total(null,2,$keyword,$cateids);//显示总条数
        $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
        $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
        $config['num_links'] = 5; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config ['prev_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
        $config ['next_link'] = '下一页';
        $config ['next_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $this->pagination->initialize($config);//初始化配置
        $data['page'] =  $this->pagination->create_links();//执行
        
        

        //查询我的需求
        $data['list'] = $this->demand_mdl->get_requirement(null,2,'a.*,b.corporation_name,b.status,c.id as cate_id,c.name,d.mobile,e.region_name as province,f.region_name as city,g.region_name as district',$config['per_page'],$offset,$keyword,$cateids,$sort);

        //选中分类的总额
        $data['classify_money'] = $this->demand_mdl->count_amount($cateids)['m_price'];
        //餐饮企业总额
        $data['restaurant_money'] = $this->get_sub_classification(189)['m_price'];
        //酒店总额
        $data['hotel_money'] = $this->get_sub_classification(1696)['m_price'];
        //其他总额
        $data['other_money'] = $this->demand_mdl->count_amount(0)['m_price'] - $data['hotel_money'] - $data['restaurant_money'];
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        
        $data ['title'] = '供需管理';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $data['search_type'] = 2;
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header',$data );
        $this->load->view ( 'demand/demand_list',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 统计金额
     */
    public function get_sub_classification($cateid){
        $this->load->model ( 'goods_mdl' );
        $catids[] = $cateid;
        $row = $this->goods_mdl->get_sub_classification($cateid);
        foreach ($row as $v){
            $catids[] = $v['id'];
        }
        return $this->demand_mdl->count_amount($catids);
    }
    
    // --------------------------------------------------------------------

    /**
     * 修改需求状态
     * @param $status 当前页面的状态
     * @param $state 要修改的状态
     */
    public function change($status,$id,$state){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        
        //搜索参数
        $data['keyword'] = $keyword = $this->input->get('keyword');
        if(isset($keyword) && $keyword!=""){
            $keyword = explode(" ",trim($keyword));
        }
        
        if(!is_numeric($status) || !is_numeric($state)){
            echo "<script>history.back();</script>";
            exit;
        }
        //修改
        $this->demand_mdl->change_status($id,$state,$this->session->userdata('user_id'));
        redirect('member/demand/index/'.$status.'?keyword='.$data['keyword']);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 删除图片
     */
    function del_img(){
        $id = (int)($this->input->post('id'));
        $key = $this->input->post('key');
        $val = $this->input->post('val');
        
        $customer_id = $this->session->userdata('user_id');
        //查询我的需求
        $data['detail'] = $this->demand_mdl->get_details($id,$customer_id);
        //判断需求是否存在
        if(empty($data['detail']['id'])){
            echo json_encode(array('status'=>'non_exist'));
            exit;
        }else{
            $img = explode(';',trim($data['detail']['img_path'],';'));
            
            $demand_temp_image = $this->session->userdata("demand_temp_image");
            $k = array_search($val, $demand_temp_image);
            
            if(is_int($k) && $demand_temp_image[$k] == $val && $img[$key] == $val ){
                
                //删除session
                unset($demand_temp_image[$key]);
                if(!empty($demand_temp_image)){
                    $this->session->set_userdata("demand_temp_image",$demand_temp_image);
                }else{
                    $this->session->set_userdata("demand_temp_image","");
                }
                
                //删除数据库
                $img_path='';
                unset($img[$key]);
                if ($img) {
                    foreach ($img as $v){
                        $img_path .= $v.';';
                    }
                }
                $row = $this->demand_mdl->img_update($id,$customer_id,$img_path);
                if($row){
                    file_exists($val)?unlink($val):"";
                    echo json_encode(array('status'=>'ok'));
                }else{
                    echo json_encode(array('status'=>'fail'));
                }

            }else{
                echo json_encode(array('status'=>'fail'));
            }
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     * ajax检查登录
     */
    function check_login(){
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            $url = $this->input->post('url');

            $this->session->set_userdata('redirect',$url);

            echo false;
        }else{
            echo true;
        }
    }
    
    
    // ---------------------------------------------------------------------
    
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
    
	//---------------------------------------------------------------------
	
	/**
	 * ckeditor上传图片
	 * 
	 */
	function editor_upload(){

	    $file['file'] = $_FILES['upload'];
	    $this->upload_file($file);
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 上传文件附件
	 * 
	 */
	function upload_file($file=null){
	    //判断是不是editor上传的图片
	    if($file){
	        $_FILES = $file;
	    }

        //判断上传图片有没有错误
        if($_FILES['file']['error']==0){
            //定义路径
            $save_path = 'demand/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $path = FCPATH . UPLOAD_PATH. "uploads/" . $save_path;
            
            if (! file_exists($path))
                mkdir($path,0755,true);//判断路径存在，不存在就创建
//                 error_log("mkdir back:".mkdirsByPath($path));


            $this->load->helper("ps_helper");
            //ci上传图片配置
            $config['file_name'] = $this->session->userdata('corporation_id') . '_' . date("YmdHis");
            $config['upload_path']      = $path;
            $config['allowed_types']    = 'jpg|png|jpeg|text|txt|pdf';
            $config['max_size']     = 1000;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file'))
            {
                $image_info = $this->upload->data();
                
                //如果是ckeditor插件上传执行这里
                if($file){
                    
                    $url =  base_url(UPLOAD_PATH."uploads/".$save_path.$image_info['file_name']);
                    $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
                    $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '')";
                    echo "<script>".$re."</script>";exit;
                    
                }else{//如果是需求发布执行下面
                    $all_images[] = "uploads/".$save_path.$image_info['file_name'];
                    if (!empty($session = $this->session->userdata("demand_temp_image"))) {//保存session
                        foreach ($session as $val){
                            $all_images[] = $val;
                        }
                    }

//                     session_write_close(); 
                    $this->session->set_userdata("demand_temp_image", $all_images);
                }
            }else{
              echo "上传失败";
            }
        }else{
            echo "上传失败";
        }
    }
    
    //---------------------------------------------------------------------
    
    //下载附件
    function download(){

        //处理附件
        $doc = array_filter(explode(';',$this->input->post('file_name')));
        $temp_zip = date('YmdHis').$this->session->userdata('user_id');
        $zip = new ZipArchive;
        /*
         $zip->open这个方法第一个参数表示处理的zip文件名。
         第二个参数表示处理模式，ZipArchive::OVERWRITE表示如果zip文件存在，就覆盖掉原来的zip文件。
         如果参数使用ZIPARCHIVE::CREATE，系统就会往原来的zip文件里添加内容。
         如果不是为了多次添加内容到zip文件，建议使用ZipArchive::OVERWRITE。
         使用这两个参数，如果zip文件不存在，系统都会自动新建。
         如果对zip文件对象操作成功，$zip->open这个方法会返回TRUE
         */
        if ($zip->open('uploads/'.$temp_zip.'.zip', ZipArchive::CREATE) === TRUE)
        {
            foreach($doc as $v){
            $zip->addFile($v,basename($v));//假设加入的文件名是image.txt，在当前路径下
            }
            $zip->close();
        }
        
        $file = $temp_zip.'.zip';//需要下载的文件
        $file_dir = 'uploads/';//文件路径
        $file=basename($file);
        $file=iconv("utf-8","gb2312","$file");
        $file_name = $file_dir.$file;
        $fp=fopen($file_name,"r+");//下载文件必须先要将文件打开，写入内存
        if(!file_exists($file_name)){//判断文件是否存在
        echo "文件不存在"; //如果不存在
        exit(); //直接退出
        } //如果存在，继续执行下载
        $file_size=filesize($file_name);//判断文件大小
        //返回的文件
        Header("Content-type: application/octet-stream");
        //按照字节格式返回
        Header("Accept-Ranges: bytes");
        //返回文件大小
        Header("Accept-Length: ".$file_size);
        //弹出客户端对话框，对应的文件名
        Header("Content-Disposition: attachment; filename=".$file_name);
        //防止服务器瞬时压力增大，分段读取
        $buffer=1024;
        while(!feof($fp)){
        $file_data=fread($fp,$buffer);
        echo $file_data;
        }
        //关闭文件
        fclose($fp);
        unlink('uploads/'.$temp_zip.'.zip');
    }
	
}