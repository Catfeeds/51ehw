<?php
/**
 * 角色
 *
 *
 */
class Uploadimage extends Front_Controller
{
	/**
	 * 构造函数
	 *
	 * 登陆检验
	 */	
	function __construct()
    {
        parent::__construct();
	}
		
	
	/**
	 * 图片上传方法(B端产品详情中的图片复制到C端)
	 *
	 *
	 */
	public function fck_upload(){
	    //处理从B端传过来的图片及路径
	    //获取文件
	    $file = $_FILES['file'];
	    //获取图片路径
	    $img_name =$this->input->post();
	  
	    //处理图片路径
	    $path_array = explode('/',$img_name['name']);
	    unset($path_array[0]);
	    unset($path_array[3]);
	    
	    $savpath = implode('/',$path_array);
	    
	    //获取图片名称
	    $filename = $file['name'];
	   
	    $this->load->helper("ps_helper");
	    $save_path = $savpath.'/';
	    $path = FCPATH . UPLOAD_PATH."uploads/".$save_path;
	    error_log($path);
	    if (! file_exists($path))
	        error_log("mkdir back:".mkdirsByPath($path));
	    
	        
	        
	    $config['file_name'] = $filename;
	    $config['upload_path'] = $path;
	    $config['allowed_types'] = 'gif|jpg|png|jpeg';
	    $config['max_size'] = '2000';
	    $config['max_filename'] = '50';
	    $this->load->library('upload');
	    
	    if (! empty($_FILES)){
	        $n = count($_FILES['file']['name']);
	    }else{
	        $n = 0;
	    }
	    
	    if($n){
	       
	        $images = array();
	        foreach ($_FILES['file'] as $key => $val) :
	        for ($i = 0; $i < $n; $i ++) {
	            $_FILES['file' . $i][$key] = $val[$i];
	        }
	        endforeach
	        ;
	        for ($j = 0; $j < $n; $j ++) {
	           
	            $this->upload->initialize($config);
	            if ($this->upload->do_upload('file')) {
	                $uploaded = $this->upload->data();
	                $images[$j]['image_name'] = "uploads/" . $save_path . $uploaded['raw_name'];
	                $images[$j]['file'] = "uploads/" . $save_path . $uploaded['file_name'];
	                $images[$j]['file_ext'] = $uploaded['file_ext'];
	                $images[$j]['file_mime'] = $uploaded['file_type'];
	                $images[$j]['width'] = $uploaded['image_width'];
	                $images[$j]['height'] = $uploaded['image_height'];
	                $images[$j]['file_size'] = $uploaded['file_size'];
	                $images[$j]['original_name'] = $uploaded['orig_name'];
	                $images[$j]['client_name'] = $uploaded['client_name'];
	                
	            }else {
	              error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
	            }
	        }
	    }
	}
	
	
	/**
	 * 图片上传方法(B端产品图片复制到C端)
	 *
	 * 
	 */
	public function img_upload()
	{
	
	    //处理从B端传过来的图片及路径
	    //获取文件
	    $file = $_FILES['file'];
	    //获取图片路径
	    $img_name =$this->input->post();
	   
	    //处理图片路径
	    $path_array = explode('/',$img_name['name']);
	   
	    unset($path_array[0]);
	    unset($path_array[5]);
	
	    $savpath = implode('/',$path_array);
	
	    //获取图片名称
	    $filename = $file['name'];
	     
	    try {
	
	        $this->load->helper("ps_helper");
	        // 商品图片缩略图尺寸
	        $sizes = array(
	            array(
	                '270',
	                '270'
	            ),
	            array(
	                '290',
	                '365'
	            ),
	            array(
	                '670',
	                '844'
	            )
	        );
	
	        $count = count($sizes);//统计生成多少张缩略图
	
	        $save_path = $savpath.'/';
	    
	        $path = FCPATH . UPLOAD_PATH."uploads/".$save_path;
	       
	        error_log($path);
	        if (! file_exists($path))
	            error_log("mkdir back:".mkdirsByPath($path));
	
	            $config['file_name'] = $filename;
	            $config['upload_path'] = $path;
	            $config['allowed_types'] = 'gif|jpg|png|jpeg';
	            $config['max_size'] = '2000';
	            $config['max_filename'] = '50';
	            $this->load->library('upload');
	
	            // 图片
	            if (! empty($_FILES))
	                $n = count($_FILES['file']['name']);
	                else
	                    $n = 0;
	
	                    //             $all_images = $this->session->userdata("temp_image");
	
	                    //             if (empty($all_images)) {
	                    //                 $all_images = array();
	                    //             }
	
	                    if ($n) {
	
	                        foreach ($_FILES['file'] as $key => $val) :
	                        for ($i = 0; $i < $n; $i ++) {
	                            $_FILES['file' . $i][$key] = $val[$i];
	                        }
	                        endforeach
	                        ;
	                        $images = array();
	
	                        for ($j = 0; $j < $n; $j ++) {
	
	                            $this->upload->initialize($config);
	
	                            if ($this->upload->do_upload('file')) {
	
	                                $uploaded = $this->upload->data();
	                                $images[$j]['image_name'] = "uploads/" . $save_path . $uploaded['raw_name'];
	                                $images[$j]['file'] = "uploads/" . $save_path . $uploaded['file_name'];
	                                $images[$j]['file_ext'] = $uploaded['file_ext'];
	                                $images[$j]['file_mime'] = $uploaded['file_type'];
	                                $images[$j]['width'] = $uploaded['image_width'];
	                                $images[$j]['height'] = $uploaded['image_height'];
	                                $images[$j]['file_size'] = $uploaded['file_size'];
	                                $images[$j]['original_name'] = $uploaded['orig_name'];
	                                $images[$j]['client_name'] = $uploaded['client_name'];
	
	                                $all_images[] = $images[$j];
	                                if (!empty($this->session->userdata("temp_image"))) {
	                                    $session = $this->session->userdata("temp_image");
	                                    foreach ($session as $val){
	                                        $all_images[] = $val;
	                                    }
	                                }
	                                //                         session_write_close();
	                                $this->session->set_userdata("temp_image", $all_images);
	
	
	
	                                for($i=0;$i<$count;$i++){
	
	                                    $configs['image_library'] = 'gd2';
	                                    $configs['source_image'] = $images[$j]['file'];
	                                    $configs['new_image'] = $images[$j]['file'];
	                                    $configs['thumb_marker'] = '_'.$sizes[$i][0];
	                                    $configs['create_thumb'] = TRUE;
	                                    $configs['maintain_ratio'] = TRUE;
	                                    $configs['width']     = $sizes[$i][0];
	                                    $configs['height']   = $sizes[$i][1];
	
	                                    $this->load->library('image_lib');
	                                    $this->image_lib->initialize($configs);
	                                    if ( ! $this->image_lib->resize())
	                                    {
	                                        error_log("缩略图生成失败，原因：" . $this->image_lib->display_errors());
	                                    }
	                                }
	                            } else {
	                                error_log("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
	                            }
	
	                        }
	
	                    }
	    } catch (Exception $e) {
	        error_log($e);
	    }
	}
  
    function index()
    {
        $upload_dir = 'uploads/fck/';


		// HERE PERMISSIONS FOR IMAGE
		$imgsets = array(
		 'maxsize' => 5000,          // maximum file size, in KiloBytes (2 MB)
		 'maxwidth' => 2000,          // maximum allowed width, in pixels
		 'maxheight' => 2000,         // maximum allowed height, in pixels
		 'minwidth' => 10,           // minimum allowed width, in pixels
		 'minheight' => 10,          // minimum allowed height, in pixels
		 'type' => array('bmp', 'gif', 'jpg', 'jpe', 'png','jpeg')        // allowed extensions
		);

		$re = '';

		if(isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
		  $upload_dir = trim($upload_dir, '/') .'/';
		  $img_name = basename($_FILES['upload']['name']);
		 

		  // get protocol and host name to send the absolute image path to CKEditor
		  $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
		  $site = $protocol. $_SERVER['HTTP_HOST'] .'/'.UPLOAD_PATH;

		  $sepext = explode('.', strtolower($_FILES['upload']['name']));

		  list($usec, $sec) = explode(" ", microtime());
		  $newname = (float)sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000);
		   $newImg_name =  $newname.".".end($sepext);

		  $path = FCPATH .UPLOAD_PATH.$upload_dir . $this->session->userdata('app_info')["id"]."/";
		  if (! file_exists ( $path ))
				$this->mkdirsByPath ( $path );
		  
		  $uploadpath = $path.$newImg_name;       // full file path

		  
		  $type = end($sepext);       // gets extension
		  list($width, $height) = getimagesize($_FILES['upload']['tmp_name']);     // gets image width and height
		  $err = '';         // to store the errors

		  // Checks if the file has allowed type, size, width and height (for images)
		  if(!in_array($type, $imgsets['type'])) $err .= 'The file: '. $_FILES['upload']['name']. ' has not the allowed extension type.';
		  if($_FILES['upload']['size'] > $imgsets['maxsize']*1000) $err .= '\\n Maximum file size must be: '. $imgsets['maxsize']. ' KB.';
		  if(isset($width) && isset($height)) {
			if($width > $imgsets['maxwidth'] || $height > $imgsets['maxheight']) $err .= '\\n Width x Height = '. $width .' x '. $height .' \\n The maximum Width x Height must be: '. $imgsets['maxwidth']. ' x '. $imgsets['maxheight'];
			if($width < $imgsets['minwidth'] || $height < $imgsets['minheight']) $err .= '\\n Width x Height = '. $width .' x '. $height .'\\n The minimum Width x Height must be: '. $imgsets['minwidth']. ' x '. $imgsets['minheight'];
		  }

		  // If no errors, upload the image, else, output the errors
		// echo "<script>alert('ggg".$uploadpath."');</script>";
		  if($err == '') {
			if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
			  $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
			  $url = $site. $upload_dir . $this->session->userdata('app_info')["id"]."/".$newImg_name; //$img_name;
			 // $message = $img_name .' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 3, '.', '') .' KB \\n- Image Width x Height: '. $width. ' x '. $height;
			  $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '')";
			}
			else $re = 'alert('.$uploadpath.'"Unable to upload the file")';
		  }
		  else $re = 'alert("'. $err .'")';
		}
		echo "<script>$re;</script>";
    }
     
	
    /**
     * 功能：递归创建文件夹
     * 参数：$param 文件路径
     */
    function mkdirsByPath($param){
        if(! file_exists($param)) {
            $this->mkdirsByPath(dirname($param));
            @mkdir($param);
        }
        return realpath($param);
    }

}