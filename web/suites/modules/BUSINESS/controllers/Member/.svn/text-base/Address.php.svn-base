<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Address extends Front_Controller {

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
            $customer_id = $this->session->userdata('user_id');
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        $this->load->model('customer_address_mdl', 'address');
    }
    
    // 收货地址界面
    public function index( $is_order_check = 0)
    {
        // 是否为订单跳转选择地址
        $data['is_order_check'] = $is_order_check;
        if($is_order_check == 0){
            $this->session->unset_userdata('ref_from_url');
        }else{
            $ref_from_url = $this->session->userdata('ref_from_url');
            $data['ref_from_url'] = $ref_from_url;
            $data['url_status'] = $is_order_check==2?"?":"&"; // url拼接类型，order：&，groupbuy_order：？
        }

        $this->load->library('pagination');
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            $config['per_page'] = 100; // 每页显示几条
        } else {
            $config['per_page'] = 3; // 每页显示几条
        }
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $config['per_page'];
        $data['address'] = $this->address->load_all($this->session->userdata('user_id'), $config['per_page'], $offset);
        $config['base_url'] = site_url('member/address') . '?/';
        $config['total_rows'] = $this->address->count_address($this->session->userdata('user_id'));
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">'; // “当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>'; // “当前页”链接的关闭标签。
        $config['prev_link'] = '上一页'; // 你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_css'] = 'class="lPage"';
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        
        $this->pagination->initialize($config);
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['cu_page'] = $current_page;
        $data['page'] = $this->pagination->create_links();
        
        if(isset($ref_from_url) && $ref_from_url!=""){
            $data['back'] = $ref_from_url;
        } else {
            $data['back'] = 'member/info';
        }
        $data['title'] = '我的收货地址';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view ( '_header', $data );
        $this->load->view('customer/address', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // 添加收货地址
    public function add($status = 0)
    {
        if ($status && isset($_SERVER['HTTP_REFERER'])) {
            $this->session->set_userdata('ref_from_url', $_SERVER['HTTP_REFERER']);
        } else if (!$this->session->userdata('ref_from_url')){
            $this->session->set_userdata('ref_from_url', site_url('member/address'));
        }
        $path = $this->input->get('path');
        $this->edit(0, $path);
    }
    
    // 修改收货地址
    public function edit($id = 0, $path = "")
    {
        if ($id) {
            $data['part_title'] = '修改收货地址';
            
            $data['address'] = $this->address->load_by_customer($id, $this->session->userdata('user_id'));
            
            if ($data['address']) {
                
                $data['head_set'] = 3;
                $data['foot_set'] = 1;
                $data['title'] = '地址管理';
                $data['back_path'] = $path;
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('customer/address_edit', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot', $data);
            } else {
                redirect('member/address');
            }
        } else {
            $data['part_title'] = '新增收货地址';
            $data['address'] = array(
                'id' => null,
                'province_id' => null,
                'city_id' => null,
                'district_id' => null,
                'consignee' => null,
                'postcode' => null,
                'address' => null,
                'mobile' => null,
                'phone' => null,
                'email' => null
            );
            
            $data['title'] = '地址管理';
            
            $data['back_path'] = $path;
            $data['head_set'] = 3;
            $data['foot_set'] = 1;
           
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('customer/address_edit', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    // 保存收货地址
    public function save()
    {
        $address_id = $this->input->post('address_id');
        $consignee = $this->input->post('consignee');
        $province_id = $this->input->post('province_id');
        $city_id = $this->input->post('city_id');
        $district_id = $this->input->post('district_id');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $mobile = $this->input->post('mobile');
        $address = $this->input->post('address');
        $postcode = $this->input->post('postcode');
        $back_path = $this->input->post('back_path');
        
        $customer_id = $this->session->userdata('user_id');
        
        $this->address->customer_id = $customer_id;
        $this->address->consignee = $consignee;
        $this->address->phone = $phone;
        $this->address->mobile = $mobile;
        $this->address->province_id = $province_id;
        $this->address->city_id = $city_id;
        $this->address->district_id = $district_id;
        $this->address->address = $address;
        $this->address->postcode = $postcode;
        $this->address->email = $email;
        
        if ($address_id) {
            // 更新
            if ($this->address->update($address_id, $customer_id)) {
                if ($back_path != "") {
                    redirect(urldecode($back_path));
                } else {
                    redirect('member/address');
                }
            }
        } else {
            $is_default = 0;//是否默认收货地址
            
            //查询判断是否第一次创建收货地址，如果是则默认
            $addressNum = $this->address->count_address($customer_id);
            if($addressNum<1){
                $is_default = 1;
            }
            
            // 新增
            if ($this->address->create($is_default)) {
                if ($back_path != "") {
                    $back_path;
                    redirect(urldecode($back_path));
                } elseif ($this->session->userdata('ref_from_url')) {
                    $url = $this->session->userdata('ref_from_url');
                    redirect($url);
                } else {
                    redirect('member/address');
                }
            }
        }
        
        redirect('member/address');
    }
    
    // 删除收货地址
    public function del($id = 0)
    {
        if (! $id) {
            redirect('member/address');
            exit();
        }
        if ($this->address->delete($id, $this->session->userdata('user_id'))) {
            redirect('member/address');
        }
    }

    /**
     * 设置默认收货地址
     *
     * @param int $id            
     */
    public function set_default()
    {
        $id = $this->input->post('id');
        $result = $this->address->set_default($id, $this->session->userdata('user_id'), 1);
        echo json_encode($result);
    }
    
    // --------------------------------------------------------------
    
    /**
     * 获取地址返回
     *
     * @param unknown $order_id            
     */
    public function get_address($order_id)
    {
        $data['address'] = $this->address->load_all($this->session->userdata('user_id'));
        $data['order_id'] = $order_id;
        $data['title'] = '选择地址';
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/address_change_view', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    public function ajax_save()
    {
        $address_id = $this->input->post('address_id');
        $data["consignee"] = $this->input->post('consignee');
        $data["province_id"] = $this->input->post('province_id');
        $data["city_id"] = $this->input->post('city_id');
        $data["district_id"] = $this->input->post('district_id');
        $data["email"] = $this->input->post('email');
        $data["phone"] = $this->input->post('phone');
        $data["mobile"] = $this->input->post('mobile');
        $data["address"] = $this->input->post('address');
        $data["postcode"] = $this->input->post('postcode');
        
        $customer_id = $this->session->userdata('user_id');
        
        $this->address->customer_id = $customer_id;
        $this->address->consignee = $data["consignee"];
        $this->address->phone = $data["phone"];
        $this->address->mobile = $data["mobile"];
        $this->address->province_id = $data["province_id"];
        $this->address->city_id = $data["city_id"];
        $this->address->district_id = $data["district_id"];
        $this->address->address = $data["address"];
        $this->address->postcode = $data["postcode"];
        $this->address->email = $data["email"];
        
        if ($address_id) {
            // 更新
            if ($this->address->update($address_id, $customer_id)) {
                $data["errorcode"] = 0;
            } else {
                $data["errorcode"] = 1;
            }
        } else {
            // 新增
            $address_id = $this->address->create(0);
            $data["errorcode"] = 0;
            if ($address_id > 0) {
                $data["id"] = $address_id;
            } else {
                $data["errorcode"] = 1;
            }
        }
        
        print_r(json_encode($data));
    }
}