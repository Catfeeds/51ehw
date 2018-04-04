<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Navigation extends Front_Controller
{
    
    /**
     * 首页导航栏－项目介绍、常见问题、如何加入、商务合作
     */
    public function __construct()
    {
        parent::__construct();
        
    }
    
    /**
     * 精英头条
     */
    public function elite_Line_nav($type = ''){
        
        $data['head_set'] = 2;
        $data['title'] = "精英头条";
        $data['navigation_project_img'] = 'images/project.jpg';
        $data['navigation_money_img'] = 'images/make_money.jpeg';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation', $data);
    }
    public function ajax_elite(){
        $page = $this->input->get_post('page');
        $pagesize = 6;
        if($page == 1){
            $page = 0;
        }else{
            $page   = ($page - 1 ) * $pagesize;
        }
        $this->load->model('Content_mdl');
        $list= $this->Content_mdl->get_list_bychannelnName('精英头条',$pagesize,$page);
        $data['list'] = $list;
        echo json_encode($data);
    }
    public function  elite_detail($id = 0){
      
        $this->load->model('Content_mdl');
        $data['list']= $this->Content_mdl->get_elite_detail($id);
        $data['head_set'] = 2;
        $data['title'] = "精英头条";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation_elite_detail', $data);
    }
    
    
    /**
     * 项目介绍
     */
    public function project_Introduction_nav($type = '')
    {
        $data['head_set'] = 2;
        $data['title'] = "项目介绍";
        $data['navigation_img'] = 'images/project.jpg';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation', $data);
        if($type == 'app'){
        }else{
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    /**
     * 常见问题
     */
    public function question_nav($type = '')
    {
        $data['head_set'] = 2;
        $data['title'] = "常见问题";
        $data['navigation_img'] = 'images/question.png';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation', $data);
        if($type != 'app'){
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    /**
     * 如何加入
     */
    public function join_nav($type = '')
    {
        $data['head_set'] = 2;
        $data['title'] = "如何加入";
        $data['navigation_img'] = 'images/join.jpg';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation', $data);
        if($type != 'app'){
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    /**
     * 商务合作
     */
    public function cooperate_nav($type = '' ,$err = 0)
    {
        $data['head_set'] = 2;
        $data['title'] = "商务合作";
        
        // 企业性质
        $this->load->model('corporation_mdl');
        $data['cor_type'] = $this->corporation_mdl->corporation_type();
        
        $data['navigation_img'] = 'images/cooperate_head.png';
        $data['type_name'] = $type;
        $data['err'] = $err;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('navigation', $data);
        if($type != 'app'){
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    /**
     * 商务合作保存方法
     */
    public function cooperate_save()
    {
        // 获取上一次session记录的数据
        $_list = $this->session->userdata('list');
        
        $_mobile = isset($_list['mobile']) ? $_list['mobile'] : "";
        $_corporation_name = isset($_list['corporation_name']) ? $_list['corporation_name'] : "";
        $_corporation_type = isset($_list['corporation_type']) ? $_list['corporation_type'] : "";
        $_applicant_name = isset($_list['applicant_name']) ? $_list['applicant_name'] : "";
        $_applicant_duty = isset($_list['applicant_duty']) ? $_list['applicant_duty'] : "";
        $_coo_direction = isset($_list['coo_direction']) ? $_list['coo_direction'] : "";
        $_type_name = isset($_list['type_name']) ? $_list['type_name'] : "";
        
        $mobile = trim($this->input->post('mobile'));
        $corporation_name = trim($this->input->post('corporation_name'));
        $corporation_type = trim($this->input->post('nature_id'));
        $applicant_name = trim($this->input->post('applicant_name'));
        $applicant_duty = trim($this->input->post('applicant_duty'));
        $coo_direction = trim($this->input->post('coo_direction'));
        $type_name = trim($this->input->post('type_name'));
        
        // 数据完整性检查
        if (in_array('', $_POST)) {
            redirect("navigation/cooperate_nav/" . $type_name . "/4");
        }
        
        // 表单提交数据
        $list = array(
            "mobile" => $mobile,
            "corporation_name" => $corporation_name,
            "applicant_name" => $applicant_name,
            "applicant_duty" => $applicant_duty,
            "coo_direction" => $coo_direction,
            "type_name" => $type_name,
            "corporation_type" => $corporation_type
        );
        
        // 在session记录表单提交的数据
        $this->session->set_userdata('list', $list);
        
        // 对比2次数据一致性，一致不允许通过
        //只有session保存list才能判断
        if ($_mobile == $mobile && $_corporation_name == $corporation_name && $_applicant_name == $applicant_name && $_type_name == $type_name && $_coo_direction == $coo_direction && $_applicant_duty == $applicant_duty && $corporation_type == $_corporation_type) {
            redirect("navigation/cooperate_nav/" . $type_name . "/3");
        }
        
        $this->load->model("corporation_cooperation_mdl", "corporation_coo");
        $user_id = $this->session->userdata("user_id");
        
        //用户登录
        //与数据库中的记录数据比较记录是否有重复
        if($user_id){
            $querys = $this->corporation_coo->getrecordsbyid($user_id);
            if(count($querys)>0){
                foreach ($querys as $k => $v){
                    if($_corporation_name ==$v['corporation_name'] && $_corporation_type ==$v['corporation_type'] && $_applicant_name == $v['applicant_name'] && $_applicant_duty == $v['applicant_duty'] && $_coo_direction == $v['coo_direction'] && $_mobile ==$v['mobile']){
                        redirect("navigation/cooperate_nav/" . $type_name . "/5");
                    }
                }
            }
            //游客
        }else{
            if($_corporation_name){
                $querys = $this->corporation_coo->getrecordsbyname($_corporation_name);
                if(count($querys)>0){
                    foreach ($querys as $k => $v){
                        //当存在记录重复
                        if($_corporation_name ==$v['corporation_name'] && $_corporation_type ==$v['corporation_type'] && $_applicant_name == $v['applicant_name'] && $_applicant_duty == $v['applicant_duty'] && $_coo_direction == $v['coo_direction'] && $_mobile ==$v['mobile']){
                            $datetime = time();
                            $times = strtotime($v['created_at']);
                            $time = $times - $datetime;
                            //当$time<1000 即合作申请间隔少于1秒
                            if($time<1000){
                                redirect("navigation/cooperate_nav/" . $type_name . "/5");
                            }
                        }
                    }
                }
            }
        
        }
        
        $this->corporation_coo->customer_id = $user_id ? $user_id : 0;
        $this->corporation_coo->mobile = $mobile;
        $this->corporation_coo->corporation_name = $corporation_name;
        $this->corporation_coo->corporation_type = $corporation_type;
        $this->corporation_coo->applicant_name = $applicant_name;
        $this->corporation_coo->applicant_duty = $applicant_duty;
        $this->corporation_coo->coo_direction = $coo_direction;
        
        if ($this->corporation_coo->create()) {
            redirect("navigation/cooperate_nav/" . $type_name . "/1");
        } else {
            redirect("navigation/cooperate_nav/" . $type_name . "/2");
        }
    }
}
?>