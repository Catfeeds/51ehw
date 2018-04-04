<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 前台控制器基类
 *
 * @package 9thleaf
 *
 * @subpackage core
 * @category core
 * @author Clark So
 *
 * @link 全称Ninth Leaf Frontend Controller
 */
abstract class Front_Controller extends CI_Controller
{
    var $url_prefix;
    
    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->helper('url');
        $this->url_prefix = base_url().'index.php/_ACCOUNT/'; //接口前缀地址
        
        $app_info = array();
        
        //动态切换移动端OR电脑端
        if($this->isMobile()){
            $theme = "default_wechat";//手机
            define('ISMOBILE','wechat');
        }else{
            $theme = "default";//电脑
            define('ISMOBILE','pc');
        }
        $this->load->switch_theme($theme);
        
        //动态切换
        switch(strtoupper(SUITE)){
            case "ACCOUNT":
                $module =  "A";
                break;
            case "BUSINESS":
                $module =  "B";
                break;
            case "CLIENT":
                $module =  "C";
                break;
        }
        $this->load->database($module);
        define('THEMEURL',  base_url().'suites/themes/'.$module.'/'.$theme.'/'); //css || js
        define('UPLOAD_PATH','uploads/'.$module.'/'); //上传路径
        define('IMAGE_URL', 'http://test51ehw.9-leaf.com/uploads/'.$module.'/');//图片显示路径
//         define('IMAGE_URL', 'http://localhost/51ehw/web/uploads/'.$module.'/');//图片显示路径
        // 判断是否第一次进入
        if (!$this->session->userdata('app_info') == null || $this->session->userdata('app_info')['site_url'] !== base_url()) {
           
            
            $this->load->model('appinfo_mdl');
            $countapp = $this->appinfo_mdl->get_all("id,app_name,site_url,admin_url,region_id,letter");
            $this->session->set_userdata('app', $countapp); 
           
            $app_info = $this->appinfo_mdl->get_app_info(base_url());
            // 如果没有找到分站，直接进入原始首页
            if (count($app_info) == 0) {
                $app_info = $this->appinfo_mdl->load(0);
                redirect($app_info['site_url']);
                return;
            }

            $app_id = $app_info['id'];
            $this->session->set_userdata('app_info', $app_info);
        }
	 //判断是否站点或者端口切换
 $user_key = $this->input->get("user_key");
        if($user_key){
            //接口获取用户信息
            $url = $this->url_prefix.'Customer/get_memcached';
            $post['user_key']=$user_key;
            $_customer = json_decode($this->curl_post_result($url,$post),true);
//            if($_customer){//把用户资料写session
	   if(isset($_customer['type'])  && $_customer['type'] == 'exchange'){//PC首页切换站点
                $customer = array(
                    'user_in' => true,
                    'user_name' => $_customer['user_name'],
                    'user_id' => $_customer['user_id'],
                    'is_vip' => $_customer['is_vip'],
                    'is_active' => $_customer['is_active'],
                    'user_last_login' => $_customer['user_last_login'],
                    'corporation_id' => $_customer['corporation_id'],
                    'privilege_id' => $_customer['privilege_id'],
                    'openid' => $_customer['openid'],
                    'pay_relation' => $_customer['pay_relation'],
                    'corporation_status' => $_customer['corporation_status'],
                    'approval_status' => $_customer['approval_status']
                );
                 $this->session->set_userdata($customer);
	//	$this->load->model('cart_mdl');
          //      $this->cart_mdl->reinit($customer['user_id']);
            }
        }

        // 写入操作日志
//error_log($_SERVER["REMOTE_ADDR"]);
        $this->load->model('action_log_mdl');
        $account_info = $this->session->userdata('account_info');
        $this->action_log_mdl->create(array(
            'id_account' => $account_info == null ? 0 : $account_info['id'],
            'from_url' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'current_url' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'created_at' => date('Y-m-d H:i:s'),
            'user_agent' => !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'server_name' => $_SERVER['SERVER_NAME'],
            'request_uri' => str_replace("/index.php", "", $_SERVER['REQUEST_URI'])
        ));
/*	if('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == "http://xiangyang.51ehw.com/")
	{
	  redirect("http://www.51ehw.com/coming_soon.html");
	}
*/
        // error_log ($_SERVER['REQUEST_URI']);
        // error_log (str_replace("/ebrun/web/index.php","",$_SERVER['REQUEST_URI']));
    }

    /**
     * 弹出窗
     *
     * @param unknown $msg
     * @param string $returnurl
     * @param string $auto
     * @param string $type
     */
    public function showMessage($msg, $returnurl = '', $auto = TRUE, $type = TRUE)
    {
        // 判断是否有返回路径
        if ($returnurl == '') {
            $returnurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
        } else {
            if (strpos($returnurl, 'history.') === false) {
                $returnurl = strpos($returnurl, 'http') !== false ? $returnurl : site_url($returnurl);
            }
        }
        $this->load->view('message', array(
            'msg' => $msg,
            'returnurl' => $returnurl,
            'auto' => $auto,
            'type' => $type
        ));
        // echo $this->output->get_output();
        // exit();
    }
    
    /**
     * 动态切换移动端OR电脑端
     * @return boolean
     */
    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
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
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }


    public function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami&port_source='.strtoupper(SUITE) );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    //curl_post
    public function curl_post_result( $url, $data ){
        $data['key'] = 'jiami';
        $data['port_source'] = strtoupper(SUITE);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
    
        return($result);
        
    }
}



/**
 * ACCOUNT接口控制器基类
 *
 * @package 9thleaf
 *
 * @subpackage core
 * @category core
 * @author fxm
  
 */
abstract class Account_Controller extends CI_Controller
{
    var $B_url_prefix;
    var $C_url_prefix;
    
    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        $app_info = array();
        $module = 'A';
        $this->load->database($module);
        $this->B_url_prefix = base_url().'index.php/_BUSINESS/'; //接口前缀地址
        $this->C_url_prefix = base_url().'index.php/_CLIENT/'; //接口前缀地址

//         define('THEMEURL',  base_url().'suites/themes/'.$module.'/'.$theme.'/'); //css || js
//         define('UPLOAD_PATH','uploads/'.$module.'/'); //上传路径
//         define('IMAGE_URL', 'http://c.test51ehw.com/'.UPLOAD_PATH);//图片显示路径
       
        
        //TOKEN验证类
        //TODO::测试
        $key = $this->input->get_post('key');
        if( $key != 'jiami' )
        {
            exit();
        }

	 $port_source = $this->input->get_post('port_source');
        $source = '';
        if( $port_source )
        { 
            switch ($port_source)
            { 
                case 'CLIENT':
                    $source = 1;
                    break;
                case 'BUSINESS':
                    $source = 2;
                    break;
               
            }
            
        }
        
        define('PORT_SOURCE', $source); //来源
        //禁止错误输出
       // error_reporting(0);
    }
    
    public function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    public function curl_post_result( $url, $data ){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
    
        return($result);
    
    }
}
/**
 * 手机端API控制器基类
 *
 * @package
 *
 * @subpackage core
 * @category core
 * @author Muke
 * @link
 *
 */
abstract class Api_Controller extends CI_Controller
{

    var $t;

    var $s;

    var $p;

    var $n;

    var $return;
    
    var $url_prefix;
   
    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('common');
        $this->load->library('session');
        $this->url_prefix = base_url().'index.php/_ACCOUNT/'; //接口前缀地址
        
       
        //动态切换移动端OR电脑端
        if($this->isMobile()){
//             $theme = "default_wechat";//手机
            define('ISMOBILE','wechat');
        }else{
//             $theme = "default";//电脑
            define('ISMOBILE','pc');
        }
//         $this->settings->load('site');
//         $this->load->switch_theme(setting('site_theme'));
//         define('THEMEURL', base_url() . 'templates/' . setting('site_theme') . '/');
        
        //动态切换
        switch(strtoupper(SUITE)){
            case "ACCOUNT":
                $module =  "A";
                break;
            case "BUSINESS":
                $module =  "B";
                break;
            case "CLIENT":
                $module =  "C";
                break;
        }

        $this->load->database($module);
        define('THEMEURL',  base_url().'suites/themes/'.$module.'/default_wechat/'); //css || js
        define('UPLOAD_PATH','uploads/'.$module.'/'); //上传路径
        define('IMAGE_URL', 'http://test51ehw.9-leaf.com/uploads/'.$module.'/');//图片显示路径
//         define('IMAGE_URL', 'http://c.51ehw.com/'.UPLOAD_PATH);//图片显示路径
        
        if ($this->session->userdata('app_info') == null || $this->session->userdata('app_info')['site_url'] !== base_url()) {
            $this->load->model('app_info_mdl');
            $app_info = $this->app_info_mdl->get_app_info(base_url());
            if (count($app_info) == 0) {
                $app_info = $this->app_info_mdl->load(0);
                redirect($app_info['site_url']);
                return;
            }

            $app_id = $app_info['id'];
            $this->session->set_userdata('app_info', $app_info);
            // exit();
        }

        // 定义返回值格式
        $this->return['responseMessage'] = array(
            'messageType' => null,
            'errorType' => null,
            'errorMessage' => null
        );
        //$this->return['data'] = array();

        // 获取客户端提交参数
        $this->t = $this->input->post('t', 0);
        $this->s = $this->input->get_post('s', 0);
        $this->p = json_decode($this->input->get_post('p', 0), true);
        $page = json_decode($this->input->get_post('n', 0), true);

        // print_r($page);

        if (isset($page['perPage'])) {
            if (! $page['perPage'])
                $page['perPage'] = 0;
        } else {
            $page['perPage'] = 0;
        }

        if (isset($page['currPage'])) {
            if (! $page['currPage']) {
                $page['currPage'] = 1;
            } else {
                $page['currPage'] = $page['currPage'] + 0;
            }
        } else {
            $page['currPage'] = 1;
        }

        if (isset($page['orderBy'])) {
            if (! $page['orderBy'])
                $page['orderBy'] = '';
        } else {
            $page['orderBy'] = '';
        }

        $this->n = $page;

        $this->_check_token();

        /*
         * if($this->s != null && $this->s != "")
             * {
             * echo "tttt";
             * @session_id($this->s);
             * @session_start();
             * }
         */
    }

    // token验证
    private function _check_token()
    {
        $this->return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => null,
            'errorMessage' => null
        );
    }

    // session验证
    private function _check_session()
    {
        $this->return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => null,
            'errorMessage' => null
        );
    }

    // 检验参数
    public function _check_prams($params, $needparams)
    {
        if (! $params) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        if (! is_array($params)) {
            $params[] = $params;
        }

        if (! is_array($needparams)) {
            $needparams[] = $needparams;
        }
        foreach ($needparams as $v) {

            if (! in_array($v, array_keys($params))) {
                $return = $this->return;
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '1',
                    'errorMessage' => '缺少参数'
                );
                print_r(json_encode($return));
                exit();
            }
        }
    }
    
    
    /**
     * 动态切换移动端OR电脑端
     * @return boolean
     */
    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
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
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
    
}

?>
