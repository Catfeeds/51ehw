<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Return_repair extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
	}
	
    /**
     * 进入返修退货列表
     */
	public function index()
	{
	    $account_id = $this->session->userdata('user_id');
	    $this->load->model('faq_mdl');
	    $data['order'] = $this->faq_mdl->get_order($account_id);
	    $data['title'] = '返修退货';
	    //获取返修退换货资料
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header',$data);
	    $this->load->view('customer/repair_record',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data);
	}
	
	
    /**
     * 进入返修退货申请表
     */	
	public function apply($order_id)
	{
	    $account_id = $this->session->userdata('user_id');
	    $this->load->model('faq_mdl');
	    $data['order'] = $this->faq_mdl->get_order($account_id,$order_id);
	    $data['title'] = '返修退货申请表';
	    //获取返修退换货资料
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header',$data);
	    $this->load->view('customer/apply',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data);
	}
	
	
    /**
     * 进入返修退货记录列表
     * 未完成
     */	
	public function record()
	{
	    $data=1;
	    $data['title'] ='返修退货记录'; 
	    //获取返修退换货资料
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header',$data);
	    $this->load->view('customer/repair_record',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data);
	}
	
	/**
	 * 进入返修退货明细列表
	 * 未完成
	 */
	public function details()
	{
	    $data=1;
	    $data['title'] ='返修退货明细';
	    //获取返修退换货资料
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header',$data);
	    $this->load->view('customer/refund_details',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data);
	}
	
	/**
	 * 图片上传方法
	 *
	 * @param int $id
	 */
	public function file_upload() {
	    try {
	        	
	        $this->load->helper ( "ps_helper" );
	        	
	        $customer_id = $this->session->userdata ( 'user_id' );
	        	
	        // 商品图片缩略图尺寸
	        $sizes = array (
	            array (
	                '270',
	                '340'
	            ),
	            array (
	                '290',
	                '365'
	            ),
	            array (
	                '670',
	                '844'
	            )
	        );
	        	
	        $save_path = 'photos/' . date ( 'Y' ) . '/' . date ( 'm' ) . '/' . date ( 'd' ) . '/'; // 'product/' . $id . '/';
	        // $path = UPLOADS.$save_path;
	        $path = FCPATH . "uploads/" . $save_path;
	        if (! file_exists ( $path ))
	            mkdirsByPath ( $path );
	        	
	        $config ['file_name'] = $customer_id . '_' . date ( "YmdHis" );
	        $config ['upload_path'] = $path;
	        $config ['allowed_types'] = 'gif|jpg|png|jpeg';
	        $config ['max_size'] = '2000';
	        $config ['max_filename'] = '50';
	        $this->load->library ( 'upload' );
	        	
	        // 图片
	        if (! empty ( $_FILES ))
	            $n = count ( $_FILES ['file'] ['name'] );
	        else
	            $n = 0;
	        	
	        $all_images = $this->session->userdata ( "temp_image" );
	        	
	        if (count ( $all_images ) == 0) {
	            $all_images = array ();
	        }
	
	        if ($n) {
	
	            foreach ( $_FILES ['file'] as $key => $val ) :
	            for($i = 0; $i < $n; $i ++) {
	                $_FILES ['file' . $i] [$key] = $val [$i];
	            }
	            endforeach
	            ;
	            $images = array ();
	
	            for($j = 0; $j < $n; $j ++) {
	                	
	                $this->upload->initialize ( $config );
	                	
	                if ($this->upload->do_upload ( 'file' )) {
	
	                    $uploaded = $this->upload->data ();
	                    $images [$j] ['image_name'] = "uploads/" . $save_path . $uploaded ['raw_name'];
	                    $images [$j] ['file'] = "uploads/" . $save_path . $uploaded ['file_name'];
	                    $images [$j] ['file_ext'] = $uploaded ['file_ext'];
	                    $images [$j] ['file_mime'] = $uploaded ['file_type'];
	                    $images [$j] ['width'] = $uploaded ['image_width'];
	                    $images [$j] ['height'] = $uploaded ['image_height'];
	                    $images [$j] ['file_size'] = $uploaded ['file_size'];
	                    $images [$j] ['original_name'] = $uploaded ['orig_name'];
	                    $images [$j] ['client_name'] = $uploaded ['client_name'];
	
	                    $all_images [] = $images [$j];
	                } else {
	                    error_log ( "上传文件失败，原因：" . $this->upload->display_errors ( '<p>', '</p>' ) );
	                }
	            }
	        }
	        $this->session->set_userdata ( "temp_image", $all_images );
	    } catch ( Exception $e ) {
	        error_log ( $e );
	    }
	}
	
	
	
	public function save()
	{
	    $a= $this->session->userdata("temp_image");
	    echo "<pre>";
	    print_r($a);exit;
		$quantity = $this->input->post('quantity');
		$problem = $this->input->post('problem');
		$username = $this->input->post('name');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		
		$image_file = '';
		
		// 图片 初始化数据
		$save_path = 'repair/'.date("Ym").'/';
		$path = UPLOADS.$save_path;
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
		
		echo 111;exit;
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