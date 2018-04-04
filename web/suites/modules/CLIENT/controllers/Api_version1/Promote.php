<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promote extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		echo 'Order API';
	}

	public function generateBarcode($userid)
	{
		$filename='/uploads/userinfo/'.$userid.'.png';
		//echo file_exists(".".$filename);
		if(file_exists(".".$filename))
		{
			$data = MAINURL.'index.php/customer/registration/'.$userid;
			//echo $data;
			$size = '400x400';
			$logo = substr(MAINLOGO,1,strlen(MAINLOGO));	// 中间那logo图
			

			//生成二维码
			include dirname(BASEPATH)."/phpqrcode/qrlib.php";
			$errorCorrectionLevel="L";
			$matrixPointSize="6";

			
			
			
			$margin=1;
			QRcode::png($data,dirname(BASEPATH). $filename, $errorCorrectionLevel, $matrixPointSize, $margin);

			// 通过google api生成未加logo前的QR图，也可以自己使用RQcode类生成
			//$png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
			
			//$QR = imagecreatefrompng($png);
			
			 $QR = imagecreatefromstring(file_get_contents(".".$filename));


			
			if($logo !== FALSE)
			{
				$logo = imagecreatefromstring(file_get_contents($logo));
				
				$QR_width = imagesx($QR);
				$QR_height = imagesy($QR);
				
				$logo_width = imagesx($logo);
				$logo_height = imagesy($logo);
				
				$logo_qr_width = $QR_width / 6;
				$scale = $logo_width / $logo_qr_width;
				$logo_qr_height = $logo_height / $scale;
				$from_width = ($QR_width - $logo_qr_width) / 2;
				
				imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
			}

			//header('Content-type: image/png');
			imagepng($QR,'uploads/userinfo/'.$userid.'.png');

			imagedestroy($QR);
		}
		
		redirect("..".$filename);
	}
	
}