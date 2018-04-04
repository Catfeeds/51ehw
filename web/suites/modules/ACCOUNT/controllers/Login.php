<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// require_once(dirname(__FILE__) . '/../config/configurations.php');
    // ------------------------------------------------------------------------

/**
 * C端
 *
 *
 */
class Login extends Account_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_mdl');
    }


    
    // ------------------------------------------------------------

     
     
     
     
     
     /**
      * 生成二维码
      */
     public function generateBarcode($userid)
     {
         //根据用户时间生成二维码
         $this->load->model("customer_mdl");
         $customer = $this->customer_mdl->load($userid);
         $year=(int)substr($customer["registry_at"],0,4);
         $month=(int)substr($customer["registry_at"],5,2);
         $day=(int)substr($customer["registry_at"],8,2);
     
         $data = site_url('customer/registration/' . $userid);
         $size = '400x400';
         $logo = './logo.png'; // 中间那logo图
     
         // 生成二维码
         include dirname(BASEPATH) . "/phpqrcode/qrlib.php";
         $errorCorrectionLevel = "L";
         $matrixPointSize = "6";
         //文件不存在创建
         if(!file_exists('./'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day )){
             mkdir('./'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day, 0777,true);
         }
     
         $filename = '/'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day . '/'.$userid . '.png';
         $margin = 1;
         QRcode::png($data, dirname(BASEPATH) . $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
         // $png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
     
         // $QR = imagecreatefrompng($png);
     
         $QR = imagecreatefromstring(file_get_contents("." . $filename));
     
         if ($logo !== FALSE) {
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
     
         // header('Content-type: image/png');
         imagepng($QR, './'.$filename);
     
         imagedestroy($QR);
     }
    
}
?>