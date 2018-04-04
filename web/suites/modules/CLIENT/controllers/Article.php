<?php 
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

    include_once 'Common/Uri.php';
    
class Article extends Front_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_mdl');
        $this->load->model('Customer_mdl');
        //         判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
    }
    
    
    
    //好文列表
    public function index()
    {
        //关键词搜索
        $keyword = $this->input->get_post('search_index');
        
        if(isset($keyword) && $keyword!=""){
            $keyword = trim($keyword," ");
        }
        
        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        //无刷新加载数据
        if($is_ajax){
            $page = $this->input->get_post('page');
            $pagesize  = $this->input->get_post('limit');
           
            $page   = ($page - 1 ) * $pagesize;
        }else{
            $pagesize = 12;
            $page = 0;
        }
        
        $data['list'] =  $this->article_mdl->get_list($keyword,$pagesize,$page);
       
        foreach ($data['list'] as $key =>$val){
            //处理时间 年-月-日
            $data['list'][$key]['create_at'] = date("Y-m-d",strtotime($val['create_at']));
            //64位加密处理
            $data['list'][$key]['id'] = base64_encode($val['id']);
        }
       
        //分享链接参数
        //上线ID
        $user_id = $this->session->userdata ( 'user_id' );
        $data['parent'] = !empty($user_id)? base64_encode($user_id):base64_encode(0);;
        
       
        $data['head_set'] = 4;
        $data['foot_set'] = 1;
        
        if($is_ajax){
            $data['limit'] = $page + 1;
            echo json_encode($data);
        }else{
            $this->load->view ( 'head',$data);
            $this->load->view ( '_header',$data );
            $this->load->view ( 'mutual_assistance/essay_share',$data);
            $this->load->view ( '_footer',$data);
            $this->load->view ( 'foot',$data);
        }
      
    }
    
    //好文详情页
    
    public function detail()
    {
        $parent  = base64_decode($this->input->get('parent'));
        $communal  = base64_decode($this->input->get('communal'));
       
        $customer = $this->Customer_mdl->load($parent);
       
        //拼接分享二维码数据
        $data['year']=(int)substr($customer["registry_at"],0,4);
        $data['month']=(int)substr($customer["registry_at"],5,2);
        $data['day']=(int)substr($customer["registry_at"],8,2);
        $data['code_parent'] = $parent;//上线的二维码
        
       $data['detail']= $this->article_mdl->get_article($communal);
       //先把内容的图片过滤掉，然后截取300长度字符串   因为这段字符串包含有HTML标签  所以要把HTML标签去掉
       $data['detail']['desc'] = strip_tags(preg_replace("/<img.*?>/si","",$data['detail']['content']));
       $data['detail']['desc'] =  str_replace('&nbsp;','',$data['detail']['desc']);
       $data['detail']['desc'] =  substr($data['detail']['desc'],0,150);
       $data['detail']['desc'] = preg_replace("/[\s]{2,}/","", $data['detail']['desc']);
     
       //分享连接参数配置
       $user_id = $this->session->userdata ( 'user_id' );//自己
       $data['type'] = base64_encode(1);
       $data['parent'] = base64_encode($user_id);
       $data['communal'] = base64_encode($communal);
       $time = date('Y-m-d H:i:s');
       $data['time'] = base64_encode($time);
       
       $data['title'] = '善活精英';
       $data['head_set'] = 4;
       $data['foot_set'] = 1;
       $data['article'] = true;
       
       $this->load->view ( 'head',$data);
//        $this->load->view ( '_header',$data );
       $this->load->view ( 'mutual_assistance/essay_share_details',$data);
       $this->load->view ( '_footer',$data);
       $this->load->view ( 'foot',$data);
        
    }
    
    /**
     * 微信分享
     * 异步写入分享记录
     */
    function ajax_add_share(){
        $parent = base64_decode($this->input->get_post('parent'));
        $type = base64_decode($this->input->get_post('type'));
        $communal = base64_decode($this->input->get_post('communal'));
        $time = base64_decode($this->input->get_post('time'));
     
        //记录分享
        $id= $this->article_mdl->add_share($parent,$type,$communal,$time);
     
        $data = array(
            "id"=>$id
        );
        
        echo json_encode($data);
    }
    
    
    
    
    
    
    
}