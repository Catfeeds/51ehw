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
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		$this->load->model('demand_mdl');
		$this->load->model ( 'corporation_mdl' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 供需管理列表
	 * 带分页功能
	 */
	public function get_list(){
	    $corporation_id = $this->session->userdata('corporation_id');
	    //获取企业信息
	    $data['corporation'] = $this->corporation_mdl->load($this->session->userdata('user_id'));
	    //分页
	    $this->load->library('pagination');
	    $config['per_page'] = 5; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    //判断如果没有页数默认一页
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $app_id = $this->session->userdata("app_info")["id"];
	    //偏移量
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    //查询供需列表
	    $data['demand'] = $this->demand_mdl->get_demand($corporation_id,$config['per_page'],$offset,$app_id);
	    $config['base_url'] = site_url('corporate/demand/get_list').'?/';//路径配置
	    $config['total_rows'] = $this->demand_mdl->total($corporation_id,$app_id);//显示总条数
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
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
	    
	    $data ['title'] = '供需管理';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/demand/demand_supply',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot'); 
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * ajax回复咨询
	 * 
	 */
	function add_reply(){
	    $advisory_id = $this->input->post('advisory_id');
	    $this->demand_mdl->content = $this->input->post('content');
	    echo $this->demand_mdl->add_reply($this->session->userdata('user_id'),$advisory_id);
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 获取需求信息
	 * 带分页功能
	 * @param int $status 全部＝0，待审核＝1，通过＝2，不通过＝3，下架＝4
	 */
	function get_requirement($status=0,$search_val=null){
	    $customer_id = $this->session->userdata('user_id');
	    //搜索
	    $data ['search_val'] = $this->demand_mdl->search_val = $search_val?urldecode($search_val):$this->input->post('search_val');
    
	    //获取企业信息
	    $data['corporation'] = $this->corporation_mdl->load($this->session->userdata('user_id'));
	    //分页
	    $this->load->library('pagination');
	    $config['per_page'] = 5; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    //判断如果没有页数默认一页
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $app_id = $this->session->userdata("app_info")["id"];
	    //偏移量
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    //查询需求列表
	    $data['requirement'] = $this->demand_mdl->get_requirement($customer_id,$status,$config['per_page'],$offset,null,$data ['search_val'],$app_id);
	    $config['base_url'] = site_url('corporate/demand/get_requirement').'/'.$status.'/'.urlencode($data ['search_val']).'?/';//路径配置
	    $config['total_rows'] = $this->demand_mdl->requirement_total($customer_id,$status,null,$data ['search_val'],$app_id);//显示总条数
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
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

	    //查询全部需求
	    $data['total'] = $this->demand_mdl->requirement_total($customer_id,null,null,null,$app_id);
	    //查询待审核条数
	    $data['behind'] = $this->demand_mdl->requirement_total($customer_id,1,null,null,$app_id);
	    //查询通过条数
	    $data['pass'] = $this->demand_mdl->requirement_total($customer_id,2,null,null,$app_id);
	    //查询未通过条数
	    $data['no'] = $this->demand_mdl->requirement_total($customer_id,3,null,null,$app_id);
	    //查询下架条数
	    $data['off'] = $this->demand_mdl->requirement_total($customer_id,4,null,null,$app_id);

	    $data ['status'] = $status;
	    $data ['title'] = '需求信息';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/demand/demand_requirement',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot');
	}
	
	//---------------------------------------------------------------------
	/**
	 * 加载发布需求页面
	 */
	function demand_release(){
	    if($this->session->userdata("demand_temp_image")){
    	    $img = $this->session->userdata("demand_temp_image");
    	    if(count($img)>0){
    	        foreach ($img as $v){
    	            $v = FCPATH . $v;
    	            file_exists($v)?unlink($v):'';
    	        }
    	    }
	    }
	    $this->session->unset_userdata("demand_temp_image");
	    
	    //获取企业信息
	    $data['corporation'] = $this->corporation_mdl->load($this->session->userdata('user_id'));
	    //查询顶级分类
	    $this->load->model('category_mdl');
	    $data['categorys'] = $this->category_mdl->get_child(0, 0);

	    $data ['title'] = '发布需求';
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/demand/demand_release',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot');
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
	 * 发布需求信息
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
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path))
                mkdir($path,0755,true);//判断路径存在，不存在就创建
//                 error_log("mkdir back:".mkdirsByPath($path));


            $this->load->helper("ps_helper");
            //ci上传图片配置
            $config['file_name'] = $this->session->userdata('corporation_id') . '_' . date("YmdHis");
            $config['upload_path']      = $path;
            $config['allowed_types']    = 'gif|jpg|png|jpeg|text|zip|rar|doc|text|ppt|ptf';
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
                    
                }else{//如果是发布执行下面
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
    
    /**
     * ajax 添加发布信息
     *
     */
    function add_demand(){
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
        $this->demand_mdl->product_name = $this->input->post('product_name');
        $this->demand_mdl->number = $this->input->post('number');
        $this->demand_mdl->kg = $this->input->post('kg');
        $this->demand_mdl->price_min = $this->input->post('price_min');
        $this->demand_mdl->price_max = $this->input->post('price_max');
        $this->demand_mdl->receiptdate = $this->input->post('receiptdate');
        $this->demand_mdl->effectdate = $this->input->post('effectdate');
        $this->demand_mdl->address = $this->input->post('address');
        $this->demand_mdl->contacts = $this->input->post('contacts');
        $this->demand_mdl->mobile = $this->input->post('mobile');
        $this->demand_mdl->remarks = $this->input->post('remarks');
        $this->demand_mdl->price_demand = $this->input->post('price_demand');
        $this->demand_mdl->type = $this->input->post('type');
        $this->demand_mdl->product_class = $this->input->post('product_class');
        $this->demand_mdl->describe = $this->input->post('describe');
        $this->demand_mdl->img_path = $img_path;
        $this->demand_mdl->app_id = $this->session->userdata("app_info")["id"];
        
        echo $this->demand_mdl->add_demand();
        
    }
    
    //---------------------------------------------------------------------
    
    /**
     * ajax 更改审核状态
     */
    function edite_requirement(){
        $requirement_id = $this->input->post('id');
        $this->demand_mdl->ispublish = $this->input->post('status');
        echo $this->demand_mdl->edite_requirement($requirement_id);
    }
    
    //---------------------------------------------------------------------
    
    /**
     * ajax 删除发布需求
     */
    function del(){
        $requirement_id = $this->input->post('id');
        echo $this->demand_mdl->del($requirement_id);
    }
    
    //-------------------------------------------------------------------
    
    /**
     * 查询更多需求
     */
    function demand_more($search_val=null,$cate_array=null){ 
        $this->load->model('category_mdl');

        //搜索
        $data ['search_val']  = $search_val = urldecode($search_val);

        //分页
	    $this->load->library('pagination');
	    $config['per_page'] = 5; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    //判断如果没有页数默认一页
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $app_id = $this->session->userdata("app_info")["id"];
	    //偏移量
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    //查询所有供需
	    $data['requirement'] = $this->demand_mdl->get_requirement(null,2,$config['per_page'],$offset,$cate_array,$search_val,$app_id);

	    if(is_array($cate_array)){
	       $config['base_url'] = site_url('corporate/demand/cate_search').'/'.$this->cate_id.'/'.urlencode($data ['search_val']).'?/';//路径配置
	    }else{
	       $config['base_url'] = site_url('corporate/demand/demand_more').'/'.urlencode($data ['search_val']).'?/';//路径配置
	    }
	    $config['total_rows'] = $this->demand_mdl->requirement_total(null,2,$cate_array,$search_val,$app_id);//显示总条数
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
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


	    //查询需求的所有分类
	    $cate = $this->demand_mdl->get_requirement(null,2,null,null,null,null);
	    $cate_all = array();
	    foreach ($cate as $v){
	        if($v['parent_id']==0){
	            $cate_all[] = $v['cate_id'];
	        }else{
	           $cate_all[] = $v['cate_id'];
	        }
	    }
	    $data['categorys'] = $this->category_mdl->categroy_deamnd(array_unique($cate_all));
	    
	    //公告
	    $app = $this->session->userdata('app_info');
	    $this->load->model('content_mdl');
	    $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
	    
	    //下拉框
	    $data['cate_id'] = $this->cate_id;
	    
        $data['title'] = '更多需求';
        $data['head_set'] = 1;
        $data['foot_set'] = '';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/demand/demand_more', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    //-------------------------------------------------------------------
    
    /**
     * 筛选分类＋搜索
     */
    function cate_search($cate_id,$search_val=null){
        $this->cate_id = $cate_id;
        $cate_array = $this->demand_mdl->subordinate($cate_id);
        $this->demand_more($search_val,$cate_array);
    }
    
    //-------------------------------------------------------------------
    
    /**
     * 供需详情
     */
    function demand_details($id){
        $data['details'] = $this->demand_mdl->get_details($id);
        
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        
        $data['title'] = '供需详情';
        $data['head_set'] = 1;
        $data['foot_set'] = '';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/demand/demand_details', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
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

     function pintuan(){

     	// $data['title'] = '拼团';
        $data['head_set'] = 5;
        $data['foot_set'] = 1;

        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('pintuan/pintuan_details', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
}