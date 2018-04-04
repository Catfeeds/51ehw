<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class navigation extends Front_Controller
{
    
    /**
     * 首页导航栏－项目介绍、常见问题、如何加入、商务合作
     */
    public function __construct()
    {
        parent::__construct();
        
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
    
    public function cooperate_save()
    {
        $mobile = $this->input->post('mobile');
        $corporation_name = $this->input->post('corporation_name');
        $corporation_type = $this->input->post('nature_id');
        $applicant_name = $this->input->post('applicant_name');
        $applicant_duty = $this->input->post('applicant_duty');
        $coo_direction = $this->input->post('coo_direction');
        $type_name = $this->input->post('type_name');
        
        $this->load->model("corporation_cooperation_mdl","corporation_coo");
        
        $this->corporation_coo->customer_id=$this->session->userdata("user_id")?$this->session->userdata("user_id"):0;
        $this->corporation_coo->mobile=$mobile;
        $this->corporation_coo->corporation_name=$corporation_name;
        $this->corporation_coo->corporation_type=$corporation_type;
        $this->corporation_coo->applicant_name=$applicant_name;
        $this->corporation_coo->applicant_duty=$applicant_duty;
        $this->corporation_coo->coo_direction=$coo_direction;
        
        if($this->corporation_coo->create()){
            redirect("navigation/cooperate_nav/".$type_name."/1");
        }else{
            redirect("navigation/cooperate_nav/".$type_name."/2");
        }
    }
}
?>