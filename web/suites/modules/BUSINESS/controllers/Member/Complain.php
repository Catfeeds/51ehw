<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
	}
	
	public function index()
	{
		//获取用户资料
		$customer_id = $this->session->userdata('user_id');
		
        //获取用户资料
        $this->load->model("customer_mdl");
        $data['customer'] = $this->customer_mdl->load($customer_id);
		
		$data['foot_set'] = 1;
        $data['head_set'] = 3;
        $data['title'] = '投诉维权';
        
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/complaints',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	} 
	
	public function save()
	{
		$username = $this->input->post('username');
		$contact = $this->input->post('contact');
		$email = $this->input->post('email');
		$complain_reason = $this->input->post('complain_reason');
		$complain_reason_other = $this->input->post('complain_reason_other');
		$complain_desc = $this->input->post('complain_desc');
		
		$image_file = '';
		
		// 图片 初始化数据
		$save_path = 'uploads/complain/'.date("Ym").'/';
		$path = FCPATH . UPLOAD_PATH.$save_path;
		
		$this->_mkdirsByPath($path);
		$config['file_name']  = date("YmdHis");
		$config['upload_path']  = $path ;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '300';
		$config['max_filename'] = '10';
		$this->load->library('upload');
		
		// 图片 添加
		if(!empty($_FILES))
		{
			$n = count($_FILES['file']['name']);
				
		}else{
			$n = 0;
		}
		if($n)
		{
		
			foreach($_FILES['file'] as $key => $val): 
			for($i=0;$i<$n;$i++){
				$_FILES['file'.$i][$key] = $val[$i];
			}
			endforeach;
			$images = array();
			for($j=0;$j<$n;$j++){
				$this->upload->initialize($config);
				if($this->upload->do_upload('file'.$j)){
		
					$uploaded = $this->upload->data();
					$images[$j]['image_name'] = $save_path.$uploaded['raw_name'];
					$images[$j]['file'] = $save_path.$uploaded['file_name'];
					$images[$j]['file_ext'] = $uploaded['file_ext'];
					$images[$j]['file_mime'] = $uploaded['file_type'];
					$images[$j]['width'] = $uploaded['image_width'];
					$images[$j]['height'] = $uploaded['image_height'];
					$images[$j]['file_size'] = $uploaded['file_size'];
				}
			}
			// 记录新增图片数据
			if (!empty($images[0]['image_name'])){
				$image_file_array = array();
				foreach($images as $image)
				{
					$image_file_array[]=$image['file'];
					
				}
				$image_file = implode(',',$image_file_array);
			}
		}
		
		
		$this->db->set('customer_id', $this->session->userdata('user_id'));
		$this->db->set('customer_name', $username);
		$this->db->set('contact', $contact);
		$this->db->set('email', $email);
		$this->db->set('complain_reason', $complain_reason);
		if($complain_reason==3)
			$this->db->set('complain_reason_other', $complain_reason_other);
		$this->db->set('complain_desc', $complain_desc);
		$this->db->set('image', $image_file);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->insert('complain');
		
		$html = '<script type="text/javascript">';
		$html .= 'alert("感谢您的反馈，您的投诉我们将会跟进处理。");location.href="'.site_url('member/info').'"';
		$html .= '</script>';
		header("Content-type: text/html; charset=utf-8");
		echo $html;
	}
	
	/**
	 * 功能：递归创建文件夹
	 * 参数：$param 文件路径
	 */
	private function _mkdirsByPath($param){
		if(! file_exists($param)) {
			$this->_mkdirsByPath(dirname($param));
			@mkdir($param);
		}
		return realpath($param);
	}
	
}