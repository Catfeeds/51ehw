<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 会员背书控制器
 *
 * 查看会员列表
 *
 * @author Clark So
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Resource extends Front_Controller
{

    // --------------------------------------------------------------------

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('resource_mdl','resource');
    }

    // --------------------------------------------------------------------

    /**
     * 申请页
     */
    public function resource_list()
    {
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $corporation_id = $this->session->userdata('corporation_id');
        $data['type'] = $this->input->get('status');
        //删除session中未保存图片
        $certificate = FCPATH .UPLOAD_PATH. $this->session->userdata("certificate");
        $logo = FCPATH .UPLOAD_PATH. $this->session->userdata("logo");
        $ce = FCPATH .UPLOAD_PATH. $this->session->userdata("ce");
        $certificate!=FCPATH.UPLOAD_PATH&&file_exists($certificate)?unlink($certificate):'';
        $logo!=FCPATH.UPLOAD_PATH&&file_exists($logo)?unlink($logo):'';
        $ce!=FCPATH.UPLOAD_PATH&&file_exists($ce)?unlink($ce):'';
        $this->session->unset_userdata("certificate");
        $this->session->unset_userdata("logo");
        $this->session->unset_userdata("ec");
        
        //分页
        $this->load->library('pagination');
        $data['per_page'] = $config['per_page'] = 10; //每页显示几条
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        //判断如果没有页数默认一页
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        //偏移量
        $offset   = ($current_page - 1 ) * $config['per_page'];
        //查询数据库调用limit返回值（此处省略）
        $data['log'] = $this->resource->log($corporation_id,$data['type'],NULL,NULL,$config['per_page'],$offset);
        $config['base_url'] = site_url('corporate/resource/resource_list').'?/';//路径配置
        $config['total_rows'] = $this->resource->log($corporation_id,$data['type'],1);//显示总条数
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
        
        //查询记录
        $data['total'] = $this->resource->log($corporation_id,null,1);//总条数
        $data['audit'] = $this->resource->log($corporation_id,0,1);//审核中条数
        $data['pass'] = $this->resource->log($corporation_id,1,1);//已审核条数
        $data['fail'] = $this->resource->log($corporation_id,2,1);//审核不通过
        
        $data['status'] = 1;
        $data['title'] = "会员背书";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/shop_recite', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 详情页
     * @param int $resource_id
     * @param int $corporation_id 店铺id
     */
    public function detail($resource_id=0,$corporation_id=0)
    {
        //平台检测
        if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
             redirect("corporate/resource/detailh5/".$resource_id.'/'.$corporation_id);
            exit;
        }
        
        //判断是否传$resource_id
        if($resource_id==0 || $resource_id=="" || $corporation_id==0 || $corporation_id==''){
            echo "<script>history.back(-1)</script>";
            exit;
        }

        //详情
        $data['detail'] = $this->resource->log($corporation_id,null,null,$resource_id);
        if(empty($data['detail'])){
             redirect();
             exit;
        }
        //处理头衔
        $data['honor'] = explode(';',$data['detail']['title']);
        //处理推荐语
        $data['recommend_language'] = explode(';',$data['detail']['recommend_language']);
        
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        
        $data['title'] = "会员背书";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/shop_recite_details_page', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    public function detailh5($resource_id=0,$corporation_id=0)
    {
        // 平台检测
        if(!stristr($_SERVER['HTTP_USER_AGENT'],"Android") && !stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
           redirect("corporate/resource/detail/".$resource_id.'/'.$corporation_id);
            exit;
        }
        //判断是否传$resource_id
        if($resource_id==0 || $resource_id=="" || $corporation_id==0 || $corporation_id==''){
            echo "<script>history.back(-1)</script>";
            exit;
        }
    
        //详情
        $data['detail'] = $this->resource->log($corporation_id,null,null,$resource_id);
        if(empty($data['detail'])){
            redirect();
            exit;
        }
        //处理头衔
        $data['honor'] = explode(';',$data['detail']['title']);
        //处理推荐语
        $data['recommend_language'] = explode(';',$data['detail']['recommend_language']);
    
    
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
    
        $data['title'] = "会员背书";
        $data ['head_set'] = 3;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/recommendetail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    public function detailapp($resource_id=0,$corporation_id=0)
    {
        //判断是否传$resource_id
        if($resource_id==0 || $resource_id=="" || $corporation_id==0 || $corporation_id==''){
            echo "<script>history.back(-1)</script>";
            exit;
        }
        //详情
        $data['detail'] = $this->resource->log($corporation_id,null,null,$resource_id);
        if(empty($data['detail'])){
            redirect();
            exit;
        }
        //处理头衔
        $data['honor'] = explode(';',$data['detail']['title']);
        //处理推荐语
        $data['recommend_language'] = explode(';',$data['detail']['recommend_language']);
        
        
        //公告
        $app = $this->session->userdata('app_info');
        $this->load->model('content_mdl');
        $data['notice'] = $this->content_mdl->getList(0, 50, $app['id'], $key = '');
        
        $data['title'] = "会员背书";
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/recommendetailapp', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    /**
     * 背书预览
     * @param int $resource_id
     */
    function preview($resource_id=0){
            $corporation_id = $this->session->userdata('corporation_id');
            $this->detail($resource_id,$corporation_id);
    }

    
    // --------------------------------------------------------------------
    
    /**
     * 图片上传方法
     *
     * @param int $id
     * @param string $status
     */
    public function file_upload($status)
        {
            try {
    
                $this->load->helper("ps_helper");
    
                $customer_id = $this->session->userdata('user_id');
    
    
                $save_path = 'logo/' . date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 'product/' . $id . '/';
                                                                                                       // $path = UPLOADS.$save_path;
                $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
                error_log($path);
                if (! file_exists($path))
                    error_log("mkdir back:".mkdirsByPath($path));
    

                $config['file_name'] = $customer_id . '_' . date("YmdHis");
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['max_filename'] = '50';
                $this->load->library('upload');
    
                //图片
                if (! empty($_FILES))
                    $n = count($_FILES['file']['name']);
                else
                    $n = 0;

                
                if ($n) {
                        $images = array();
                        $this->upload->initialize($config);
                        
                        if ($this->upload->do_upload('file')) {
    
                            $uploaded = $this->upload->data();
                            $images['image_name'] = "uploads/" . $save_path . $uploaded['raw_name'];
                            $images['file'] = "uploads/" . $save_path . $uploaded['file_name'];
                            $images['file_ext'] = $uploaded['file_ext'];
                            $images['file_mime'] = $uploaded['file_type'];
                            $images['width'] = $uploaded['image_width'];
                            $images['height'] = $uploaded['image_height'];
                            $images['file_size'] = $uploaded['file_size'];
                            $images['original_name'] = $uploaded['orig_name'];
                            $images['client_name'] = $uploaded['client_name'];

                            //把文件路径保存session
                            switch ($status){
                            case 'certificate':
                                //如果替换上传图片就把上一次的图片删除
                                $cfe_session = $this->session->userdata("certificate");
                                if($cfe_session && file_exists($cfe_session)){
                                    unlink($cfe_session);
                                }
                                $this->session->set_userdata("certificate", $images['file']);
                                break;
                            case 'logo':
                                //如果替换上传图片就把上一次的图片删除
                                $logo_session = $this->session->userdata("logo");
                                if($logo_session && file_exists($logo_session)){
                                    unlink($logo_session);
                                }
                                $this->session->set_userdata("logo", $images['file']);
                                break;
                            case 'ce':
                                //如果替换上传图片就把上一次的图片删除
                                $ce_session = $this->session->userdata("ce");
                                if($ce_session && file_exists($ce_session)){
                                    unlink($ce_session);
                                }
                                $this->session->set_userdata("ce", $images['file']);
                                break;
                            }
                        } else {
                            error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                        }
    
                }
    
            } catch (Exception $e) {
                error_log($e);
            }
        }

        // --------------------------------------------------------------------
        
        /**
         * 添加会员背书申请
         *
         */
        public function add_apply()
        {
            // 判断用户是否登录
            if (! $this->session->userdata('user_in')) {
                redirect('customer/login');
                exit();
            }
            
            if( !$this->session->userdata("corporation_id") )
            {
                redirect('Corporation/home_page');
                exit();
            
            }
            
            $status = $this->input->post('status');//状态1添加2修改
            $id = $this->input->post('id');
            //处理头衔
            $honor_array = $this->input->post('recommend_honor');
            $honor = "";
            foreach ($honor_array as $v){
                $honor .= $v.';';
            }
            $this->resource->title = rtrim($honor,';');//头衔
            
            //处理推荐语
            $language_array = $this->input->post('recommend_language');
            $language = "";
            foreach ($language_array as $v){
                $language .= $v.';';
            }
            $this->resource->recommend_language = rtrim($language,';');//推荐语
            $this->resource->recommend_company = $this->input->post('name');//推荐单位
            $this->resource->recommend_name = $this->input->post('recommend_name');//背书人姓名
            $this->resource->recommend_content = $this->input->post('personal');//个人介绍
            $this->resource->company_brief = $this->input->post('recommend_company');//单位介绍
            
            //状态1添加2修改
            if($status==1){
                $this->resource->logo = $this->session->userdata("logo");//背书logo
                $this->resource->certificate = $this->session->userdata("certificate");//介绍人图片
                $this->resource->recommend_img = $this->session->userdata("ce");//推荐说明书
            }else{
                //如果有修改图片就拿session 如果无修改图片就拿回原图
                $logo = $this->input->post('logo');//背书logo
                $certificate = $this->input->post('certificate');//介绍人图片
                $ce = $this->input->post('ce');//推荐说明书图片
                
                if($logo){
                    $this->resource->logo = $this->session->userdata("logo");//背书logo
                }else{
                    $this->resource->logo = $this->input->post('logo_');//背书logo
                }
                
                if($certificate){
                    $this->resource->certificate = $this->session->userdata("certificate");//介绍人图片
                }else{
                    $this->resource->certificate = $this->input->post('certificate_');//介绍人图片
                }
                
                if($ce){
                    $this->resource->recommend_img = $this->session->userdata("ce");//推荐说明书图片
                }else{
                    $this->resource->recommend_img = $this->input->post('ce_');//推荐说明书图片
                }
            }
            $corporation_id = $this->session->userdata('corporation_id');

            $row = $this->resource->add($corporation_id,$status,$id);
            $this->session->unset_userdata('certificate',"");
            $this->session->unset_userdata('logo',"");
            $this->session->unset_userdata('ce',"");
            if($row){
                echo "<script>alert('申请成功');window.location='".site_url('corporate/resource/resource_list')."'</script>";
            }else{
                echo "<script>alert('申请失败');window.location='".site_url('corporate/resource/resource_list')."'</script>";
            }

        }
        
        /**
         * ajax操作会员背书状态
         * @param $approve_status 0取消审核，1上架，2申请审核，3下架
         */
        function ajax_operate(){
            // 判断用户是否登录
            if (! $this->session->userdata('user_in')) {
                $data = array('status'=>3);
                echo json_encode($data);
                exit();
            }else{
                $approve_status = $this->input->post('approve_status');
                $resource_id = $this->input->post('resource_id');
                $corporation_id = $this->session->userdata('corporation_id');
                if($resource_id==0 || $resource_id==""){
                    redirect();
                }
                switch ($approve_status){
                    case 0:
                        $approve_status = 4;
                        break;
                    case 1:
                        $approve_status = 3;
                        break;
                    case 2:
                        $approve_status = 0;
                        break;
                    case 3:
                        $approve_status = 4;
                        break;
                    case 4:
                        $approve_status = 0;
                        break;
                    default:
                        $data = array('status'=>2);
                        echo json_encode($data);
                        exit;
                        break;
                }
                //修改状态
                $result = $this->resource->operate($corporation_id,$resource_id,$approve_status);
                if($result == 1){
                    $data = array('approve_status'=>$approve_status,'status'=>1);
                    echo json_encode($data);
                    exit;
                }else{
                    $data = array('status'=>2);
                    echo json_encode($data);
                    exit;
                }
            }
            
        }
        
        /**
         * ajax删除背书
         * @param array $resource_array 背书id
         */
        function delects(){
            // 判断用户是否登录
            if (! $this->session->userdata('user_in')) {
                $data = array('status'=>3);
                echo json_encode($data);
                exit();
            }else{
                $corporation_id = $this->session->userdata('corporation_id');
                $resource_array = $this->input->post('id');
                $type = $this->input->post('type');
                $result = $this->resource->delects($corporation_id,$resource_array);
                //如果当前页数没有数据就返回上一页
                $total_rows= $this->resource->log($corporation_id,$type,1);//显示总条数
                $per_page = $this->input->post('per_page'); //每页显示几条
                $current_page = ceil($total_rows/$per_page);
                if(0 == $current_page)
                {
                    $current_page = 1;
                }
                
                if($result == 1){
                    $data = array('status'=>1);
                    echo json_encode($data);
                }else{
                    $data = array('status'=>2);
                    echo json_encode($data);
                }
            }
        }
        
        /**
         * 修改背书
         * @param array $resource_id 背书id
         */
        function edit(){
            // 判断用户是否登录
            if (! $this->session->userdata('user_in')) {
                redirect('customer/login');
                exit();
            }
            $corporation_id = $this->session->userdata('corporation_id');
            $resource_id = $this->input->get('id');
            $data['detail'] = $this->resource->log($corporation_id,null,null,$resource_id);
            
            //处理头衔
            $data['honor'] = explode(';',$data['detail']['title']);
            //处理推荐语
            $data['recommend_language'] = explode(';',$data['detail']['recommend_language']);
            
            $data['log'] = "";
            $data['total'] = "";//总条数
            $data['audit'] = "";//审核中条数
            $data['pass'] = "";//已审核条数
            $data['fail'] = "";//审核不通过
            
            $data['status'] = 2; 
            $data['title'] = "会员背书";
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('corporate/shop/shop_recite', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);

        }

}