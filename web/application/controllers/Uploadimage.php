<?php
/**
 * 角色
 *
 *
 */
class uploadimage extends Front_Controller
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
		
  
  
    function index()
    {
        $upload_dir = '/uploads/fck/';


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
		  $site = $protocol. $_SERVER['HTTP_HOST'] .'/';

		  $sepext = explode('.', strtolower($_FILES['upload']['name']));

		  list($usec, $sec) = explode(" ", microtime());
		  $newname = (float)sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000);
		   $newImg_name =  $newname.".".end($sepext);

		  $path = $_SERVER['DOCUMENT_ROOT']. "/".$upload_dir . $this->session->userdata('app_info')["id"]."/";

		  if (! file_exists ( $path ))
				mkdirsByPath ( $path );
		  
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
    
	
    

}