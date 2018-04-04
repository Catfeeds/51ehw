<?php
/**
 * 解析短连接控制器
 */

class Conect extends Front_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Conect_mdl");
    }
    
    /**
     * 部落短信邀请
     * @param str $url_key
     */
    public function t($url_key = 0){
        if(!$url_key){
            show_404();
            exit;
        }
       
        $list = $this->Conect_mdl->load($url_key);
        if(!$list){
            show_404();
            exit;
        }
        if(!is_numeric(strpos($list['url_short'], 'Conect/t/'))){
            show_404();
            exit;
        }
        $url = $list['url_long'];
        redirect($url);
    }
    
    /**
     * 部落扫码邀请
     * @param str $url_key
     */
    public  function n($url_key = 0){
        if(!$url_key){
            show_404();
            exit;
        }
       
        $list = $this->Conect_mdl->load($url_key);
        if(!$list){
            echo "<script>alert('二维码已失效');
                 window.location.href = '".site_url('Home').
                 "';</script>";
            exit;
        }
        if(!is_numeric(strpos($list['url_short'], 'Conect/n/'))){
            show_404();
            exit;
        }
        $url = $list['url_long'];
        redirect($url);
    }
    
    
}