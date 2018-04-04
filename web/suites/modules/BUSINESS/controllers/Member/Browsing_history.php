<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Browsing_history extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        
		// 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {
            $customer_id = $this->session->userdata("user_id");
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        $this->load->model("customer_browsing_history_mdl", "cbh");
    }

    /**
     * 浏览记录首页
     */
    public function index()
    {}

    /**
     * 浏览记录列表
     */
    public function getList()
    {
        $customer_id = $this->session->userdata('user_id');
        $select = "c.id,c.customer_id,c.product_id,c.cate_id as cat_id,c.p_name as product_name,c.p_price as price,c.created_at,c.goods_thumb";
        $data['lists'] = $this->cbh->get_lists_with_condition(null, null, $select);

        $data['title'] = '浏览记录';
        $data['foot_set'] = 1;
        $data['head_set'] = 9;
        $data['back'] = "member/info";
        $data['submit_type'] = "history";
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        // H5弹窗
        if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
            $data['question'] = '确定清空浏览记录？';
            $this->load->view('widget/bullet', $data);
        }
        $this->load->view('customer/browsing_history', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * ajax删除浏览记录
     * 不传product_id则清空浏览记录
     */
    public function ajax_delete()
    {
        $product_id = $this->input->get('product_id');
        $msg = array(
            'Result' => false
        );
        if ($this->cbh->delete(isset($product_id)?$product_id:'')) {
            $msg = array(
                'Result' => true
            );
        }
        echo json_encode($msg);
    }
}