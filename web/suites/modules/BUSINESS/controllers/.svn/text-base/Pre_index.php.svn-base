<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
    class Pre_index extends Front_Controller {

        /**
         *
         */
        public function __construct() {
            parent::__construct ();
        }



        // --------------------------------------------------------------------

        /**
         *
         */
        public function index() {

            if($this->session->userdata ( "user_id" )){
                redirect('home');
                return;
            }




            $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $clientkeywords = array(
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'opera mobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );

            // if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
            /*if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", $userAgent) && strpos($userAgent, 'ipad') === false || strpos($userAgent, 'micromessenger') !== false) {
                redirect('home');
            }else{*/
                $this->load->view ( 'pre_index' );
            //}
        }
    }
    ?>