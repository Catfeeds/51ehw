<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * 切换端口调用数据
 *
 */
class Customer extends Account_Controller
{

    public $mem;
    public $customer_data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("customer_mdl");
        $this->load->model("pay_relation_mdl");
    }
   
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 我的资产接口
     */
    public function fortune(){ 
      
        $relation_id = $this->input->get('relation_id');
        $customer_id = $this->input->get('customer_id');
        if(!empty($relation_id) )
        {
            $this->load->model("Pay_relation_mdl", "Pay_relation");
            $this->Pay_relation->id = $relation_id;
            $result = $this->Pay_relation->load();
            
        }else if(!empty($customer_id) ){ 
            $this->load->model('pay_account_mdl');
            $result = $this->pay_account_mdl->load( $customer_id );
        }
        
        $time = date('Y-m-d H:i:s');
        
        if ($result) {
            if (! ($result['credit_start_time'] <= $time && $result['credit_end_time'] >= $time)) {
                $result['credit'] = '0.00';
            }
        }
        
        echo json_encode($result);
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 我的资产接口PC
     */
    public function property(){ 

        $relation_id = $this->input->get('relation_id');
        $per_page = $this->input->get('per_page');
        $offset = $this->input->get('offset');
        $status = $this->input->get('status');
        
        $time = date('Y-m-d H:i:s');
        $this->load->model("Pay_relation_mdl", "Pay_relation");
        $this->Pay_relation->id = $relation_id;
        $result = $this->Pay_relation->load();
        
        if ($result) {
            if (! ($result['credit_start_time'] <= $time && $result['credit_end_time'] >= $time)) {
                $result['credit'] = '0.00';
            }
        }
        
        if($status == ''){
            $this->load->model('customer_currency_log_mdl','customer_currency_log');
            $data['list']    = $this->customer_currency_log->load($relation_id, $per_page,$offset);//M卷日志
            $data['total_rows'] = $this->customer_currency_log->load_total($relation_id);
        }elseif ($status == 2){
            $this->load->model('Customer_money_log_mdl','customer_money_log');
            $data['list'] = $this->customer_money_log->load($relation_id,$per_page,$offset);//现金日志
            $data['total_rows'] = $this->customer_money_log->load_total($relation_id);
        }else if($status ==3 ) {
            $this->load->model('customer_credit_log_mdl','customer_credit_log');
            $data['list'] = $this->customer_credit_log->load($relation_id,$per_page,$offset);//现金日志
            $data['total_rows'] = $this->customer_credit_log->load_total($relation_id);
        }
        
        $data['customer'] = $result;
        print_r(json_encode($data));
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 修改用户支付密码
     */ 
    public function update_paypwd(){
        $this->load->model('pay_account_mdl');
        $user_id = $this->input->post("user_id");
        $paypassword = $this->input->post("paypassword");//新的密码
        $old_paypwd = $this->input->post("old_passwd");//原来的密码
        $this->pay_account_mdl->pay_passwd = $paypassword;
        $this->pay_account_mdl->old_passwd = $old_paypwd;
        $res = $this->pay_account_mdl->update($user_id);
        echo json_encode(array('status'=>$res));
    }
    
  
    //---------------------------------------------------------------------------------------------------
        /**
         * 添加新用户,同步3个数据库
         */
        public function save(){

            $name = $this->input->post('mobile');
            $mobile = $this->input->post('mobile');
            $nick_name = $this->input->post('Nickname');//昵称
            $password = $this->input->post('tbxRegisterPassword');
            $nickname = $this->input->post('nickname');//微信昵称
            $headimgurl = $this->input->post('headimgurl');//微信头像
            $openid = $this->input->post('openid');
            $app_id =$this->input->post('app_id');
            $parent_id =$this->input->post('parent_id');
            $sex =$this->input->post('sex');
            $phone =$this->input->post('phone');
            $email =$this->input->post('email');
            $birthday =$this->input->post('birthday');
            $registry_by = $this->input->post('registry_by');//PC || APP || wechat || H5
            $unionid = $this->input->post('unionid');
            $time = $this->input->post("time");
            $real_name = $this->input->post("real_name");//真实姓名

            $apptype = "";//app注册识别
            switch ($registry_by){
                //H5微信注册
                case 'wechat':
                    $name ="wechat:".$unionid;
                    break;
                case 'APP':
                    //标识app手机注册
                    $apptype = 'appmobile';
                    //当$name获取为空时，则为app微信注册则不传mobile参数改传name参数
                    if(empty($name)){
                        $name = $this->input->post('name');
                        //标识app微信注册
                        $apptype = 'appwechat';
                    }
                    break;
    
                case "PC":case "H5": case "advertisement_api" ://H5 PC 手机注册
                    $customer = $this->customer_mdl->check_mobile($mobile);//检查用户是否存在
                    if($customer){
                        $customer['status'] = 1;
                        echo json_encode($customer);//用户存在
                        exit;
                    }
                    break;
               default:
                    error_log("注册是来自:".$registry_by."端");
                    echo json_encode(array('status'=>'2'));//注册失败
                    break;
            }
     
            
            
            $removeEmoji = $this->removeEmoji($nickname);
            $nickname = $removeEmoji['nickname'];
            
            $removeEmoji = $this->removeEmoji($nick_name);
            $nick_name = $removeEmoji['nickname'];
            
            $removeEmoji = $this->removeEmoji($name);
            $name = $removeEmoji['nickname'];
            
            
            $this->customer_mdl->wechat_nickname = $nickname;
            $this->customer_mdl->wechat_avatar = $headimgurl;
            $this->customer_mdl->wechat_account = $unionid;
            $this->customer_mdl->openid = $openid;
            $this->customer_mdl->name = $name;
            $this->customer_mdl->mobile = $mobile;
            $this->customer_mdl->sex = $sex;
            $this->customer_mdl->parent_id = $parent_id;
            $this->customer_mdl->birthday = $birthday;
            $this->customer_mdl->email = $email;
            $this->customer_mdl->phone = $phone;
            $this->customer_mdl->password = $password;
            $this->customer_mdl->nick_name = $nick_name ? $nick_name : $mobile;
            $this->customer_mdl->app_id = $app_id;
            $this->customer_mdl->time = $time;
            $this->customer_mdl->registry_by = $registry_by;
            $this->customer_mdl->real_name = $real_name;
            //创建用户，同步3库数据
            $is_ok = false;//事务识别
            $this->db->trans_begin();//开启事务
          
            $customer_id = $this->customer_mdl->create();
            error_log ( "--------------A端创建用户error_log-----------开始--------------");
            error_log ( $this->db->last_query () );
            error_log ( "--------------A端创建用户error_log-----------结束--------------");
            if(!$customer_id){
                error_log ( "--------------A端创建用户----失败----------");
            }
            
            $pay_relation_id = 0;//默认支付id
            if($customer_id){
                $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
                $db2->trans_begin();//开启事务
                $row2 = $this->customer_mdl->synchro_create($customer_id);//创建用户
                error_log ( "--------------B端创建用户error_log-----------开始--------------");
                error_log ( $this->db->last_query () );
                error_log ( "--------------B端创建用户error_log-----------结束--------------");
                $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                $db3->trans_begin();//开启事务
                //判断C端更新信息是否包含parent_id app_id
                if($parent_id){
                    $this->customer_mdl->parent_id = 'C端';
                }
                $row3 = $this->customer_mdl->synchro_create($customer_id);//创建用户
                
                error_log ( "--------------C端创建用户error_log-----------开始--------------");
                error_log ( $this->db->last_query () );
                error_log ( "--------------C端创建用户error_log-----------结束--------------");
                
                if(($registry_by != 'APP' && empty($apptype) && $registry_by != 'wechat') || $apptype == "appmobile"){//app不是微信注册 || h5 || pc 注册才有支付账户
                    // 插入pay信息
                    $this->load->model('pay_account_mdl');
                    $this->load->model('pay_relation_mdl');
                    $this->pay_account_mdl->name = $name;
                    $this->pay_account_mdl->passwd = '';
                
                    //添加支付账号
                    $pay_account_id = $this->pay_account_mdl->createpay_account();
                    if ($pay_account_id) {
                        $this->pay_relation_mdl->id_pay = $pay_account_id;
                        $this->pay_relation_mdl->customer_id = $customer_id;
                        $pay_relation_id = $this->pay_relation_mdl->createpay_relation();
                        if($pay_relation_id){
                            $is_ok = true;
                        }
                    }
                }else{
                    $is_ok = true;
                }
                
                
                if(!$row2 || !$row3){
                    if(!$row2){
                        error_log ( "--------------B端创建用户----失败----------");
                    }
                    if(!$row3){
                        error_log ( "--------------C端创建用户----失败----------");
                    }
                  
                    
                    $is_ok = false;
                }


                
                if($is_ok){
                    //事务提交
                    $this->db->trans_commit();
                    $db2->trans_commit();
                    $db3->trans_commit();
                    
                    //当用户注册成功  通知B端处理当前用户是否存在上线 存在则向上线推送公众号消息
                    $url = $this->B_url_prefix.'Customer/sendTplParentMsg';
                    $send['user_id'] = $customer_id;
                    $this->curl_post_result($url,$send);
                    
                    if(($registry_by != 'wechat' && empty($apptype)) || $apptype == "appmobile"){//app不是微信注册 || h5 || pc 注册才有支付账户
                        echo json_encode(array('status'=>'3','customer_id'=>$customer_id,'pay_relation_id'=>$pay_relation_id));//注册成功
                    }else{//微信注册
                        echo json_encode(array('status'=>'3','customer_id'=>$customer_id));//注册成功
                    }
                }else{
                    //事务回滚
                    $this->db->trans_rollback();
                    $db2->trans_rollback();
                    $db3->trans_rollback();
                    echo json_encode(array('status'=>'2'));//注册失败
                    exit;
                }
 
            }else{
                    //事务回滚
                    error_log("A库错误：".$this->db->last_query());
                    $this->db->trans_rollback();
                    echo json_encode(array('status'=>'2'));//注册失败
                    exit;
            }
        }
    

    

    //---------------------------------------------------------------------------------------------------

    /**
     * 开启事务——创建支付账户
     */
    public function add_pay(){
        $customer_id = $this->input->post("customer_id");//用户id
        $name = $this->input->post("name");//用户名
        $password = $this->input->post("password");//登录密码
        $pay_passwd = $this->input->post("pay_passwd");//支付密码
        $this->db->trans_begin();//开启事务
        $row = $this->create_pay($customer_id,$name,$password,$pay_passwd);
        if($row){
            $this->db->trans_commit(); 
        }else{
            $this->db->trans_rollback();
        }
        echo json_encode(array("start"=>$row));
    }
    
    
   
  
  
   
    //---------------------------------------------------------------------------------------------------

    /**
     * 登录
     * @param string $name 用户名
     * @param string $password 密码
     */
    function check_customer()
    {
        $name = $this->input->post_get('tbxLoginNickname');
        //判断传输过来的密码是否已加密
        $is_md5 = $this->input->post_get('is_md5');
        if($is_md5 && $is_md5 == 'is_md5'){
            $password = $this->input->post_get('tbxLoginPassword');
        }else{
            $password = md5($this->input->post_get('tbxLoginPassword') );
          
        }
        $status = $this->input->post('status');
        
        $this->load->model('pay_relation_mdl');
        
        $this->customer_mdl->name = $name;
        $this->customer_mdl->password = $password;
        $_customer = $this->customer_mdl->check_customer();//查询用户信息
      
        //如果是验证码登录
        if( $status =='code')
        {
            $password = $_customer['password'];
        }
        
        if ( isset($_customer['password']) && $_customer['password'] == $password) {
            
            //支付账号
            $_customer['pay_relation'] = $this->pay_relation_mdl->load_id($_customer['id']);
    
            $this->customer_mdl->update_last_login($_customer['id']);//记录最后登录
            echo json_encode($_customer);//返回用户信息
        } else {
            echo false;
        }
        
    }
    
    
    //---------------------------------------------------------------------------------------------------
    /**
     * 更新最后登录时间
     */
    function  update_last_login(){
        $customer_id =$this->input->post('customer_id');
        $this->customer_mdl->update_last_login($customer_id);//查询用户信息
    }
    
    //---------------------------------------------------------------------------------------------------
  
    /**
     * 微信登录
     */
    function other_login(){
      
        $type =$this->input->post_get('type');
        $unionid =$this->input->post_get('unionid');
        $where = array(
                     $type . "_account" => $unionid
                );
        $_customer = $this->customer_mdl->load_by_where($where);
     
        if($_customer){
            echo json_encode($_customer);//返回用户信息
        }else{
            echo false;
        }
    }
    
   
    /**
     * 调用memcache
     */
     function load_memcached(){
         
    
        //连接MEMCACHED
        $this->mem = $this->tel_memcached();
        //获取session的user_key
        $user_key = $this->session->userdata('user_key');
    
        if($user_key){
            
            $val = $this->mem->get( $user_key );//查询信息是否存在
            if(!$val){
                //写入memcached 登录key值
                $val = $this->set_user_memcached();
            }
        }else{
            //写入memcached 登录key值
            $val = $this->set_user_memcached();
        }
        if(!$val){
            echo '写入失败';
            exit;
        }
        return $val['user_key'];
    }
    
   
    /**
     * 将用户信息写入memcache
     */
    function set_user_memcached(){
         
        $customer = $this->customer_data;
        $mem = $this->tel_memcached();
        
        if(count($customer) > 0 ){
            $key = md5($customer['nick_name'].rand(0,999999));
            if($customer['is_user']){
                $customer_data = array(
                    'user_name' => $customer['user_name'],
                    'user_id' => $customer['id'],
                    'nick_name' => $customer['nick_name'],
                    'img_avatar' => $customer['img_avatar'],
                    'is_active' => $customer['is_active'],
                    'unionid' => $customer['unionid'],
                    'openid' => $customer['openid'],
                    'mobile_exist' => $customer['mobile_exist'],
                    'is_user' =>$customer['is_user'],
                    'user_key' => $key,
                    'mobile' => $customer['mobile']
                );
            }else{
                $customer_data = array(
                    'nick_name' => $customer['nick_name'],
                    'img_avatar' => $customer['img_avatar'],
                    'unionid' => $customer['unionid'],
                    'openid' => $customer['openid'],
                    'is_user' =>$customer['is_user'],
                    'registry_by' => 'wechat',
                    'user_key' => $key
                );
            }
            
            if($mem->set($key,$customer_data,1800)){
                $this->session->set_userdata('user_key',$key);
                
                return $customer_data;
            }else{
            
                return false;
            }
    
        }else{
            return false;
        }
    }
    
    
    /**
     * 连接Memcached
     * @return Memcache
     */
   function tel_memcached(){
        $mem = new Memcached();
        
        if(!$mem->addServer('10.10.51.53',11211)){
            error_log("连接失败!");
            return false;
        }else{
            return $mem;
        }
    }
    /**
     * load Memcached  by key
     * @return Memcache
     */
    function load_Memcached_Key (){
        
        $key = $this->input->get('user_key');
        if(!$key){
            echo false;
        }
        //获取用户数据
        $mem = $this->tel_memcached();
        $data = $mem->get($key);
        echo json_encode($data);//返回用户信息
    }
   /**
     * APP微信登录 头像图片更新
     */
    function update(){
        $customer_id = $this->input->post('customer_id');
        $wechat_avatar = $this->input->post('wechat_avatar');
        $wechat_nickname = $this->input->post('wechat_nickname');
        $wechat_account = $this->input->post('wechat_account');
        $openid = $this->input->post('openid');
        $qq_account = $this->input->post('qq_account');
        $weibo_account = $this->input->post('weibo_account');
        $alipay_account = $this->input->post('alipay_account');
        $parent_id = $this->input->post('parent_id');
        $this->customer_mdl->wechat_avatar = $wechat_avatar;
        $this->customer_mdl->wechat_nickname = $wechat_nickname;
        $this->customer_mdl->wechat_account = $wechat_account;
        $this->customer_mdl->openid = $openid;
        $this->customer_mdl->qq_account = $qq_account;
        $this->customer_mdl->weibo_account = $weibo_account;
        $this->customer_mdl->alipay_account = $alipay_account;
//         $this->customer_mdl->parent_id = $parent_id;
        
        $is_ok = false;//事务识别
        $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        $db1->trans_begin();
        $row = $this->customer_mdl->update($customer_id);
        
        if($row){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();
            $row = $this->customer_mdl->update($customer_id);
           
            if($row){
                $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                $db3->trans_begin();
                $row = $this->customer_mdl->update($customer_id);
               
                if($row){
                    $is_ok = true;
                }
            }
        }
        
        if($is_ok){
            //事务提交
            $db1->trans_commit();
            $db2->trans_commit();
            $db3->trans_commit();
            echo json_encode(array('status'=>true));//成功
            exit;
        }else{
            //事务回滚
            $db1->trans_rollback();
            $db2->trans_rollback();
            $db3->trans_rollback();
            error_log($db1->last_query());
            error_log($db2->last_query());
            error_log($db3->last_query());
            echo json_encode(array('status'=>false));//失败
            exit;
        }
       
    }
    
    /**
     * 用户支付账号id
     */
    function get_pay_relation_id(){
      
        $customer_id = $this->input->post('customer_id');
        $data = $this->pay_relation_mdl->load_id($customer_id);
        echo json_encode($data);//返回用户支付账户ID信息
        
    }
    
//     function get_userinfo(){
//        $name = $this->input->get("name");
//        $info = $this->customer_mdl->load_by_name($name);
//        if($info){
//           echo '<pre>';
//           print_r($info);exit;
//        }
//     }
    
    //---------------------------------------------------------------------------------------------------
    
    function removeEmoji($nickname = '') {
    
        $clean_text = "";
    
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $nickname);
    
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
    
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
    
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
    
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        $return['nickname'] = $clean_text;
        return $return;
    }
    
   //-----------------------------------------------------------------------------------------------
    
    /**
     * 微信登录
     * @param string $unionid
     */
    public function wechat_code_login()
    {

        $access_token = $this->input->post("access_token");
        $access_token1 = $this->input->post("access_token1");
        $openid = $this->input->post("openid");
        $registry_by = $this->input->post("registry_by");//唯一识别
        
        if($access_token1){
            // 通过access_token和openid获取unionid
            $get_subscribe_info_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='. $access_token1 . '&openid=' . $openid . '&lang=zh_CN';
            $subscribe_res = file_get_contents($get_subscribe_info_url);
            $subscribe_obj = json_decode($subscribe_res, true);
        }
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res = file_get_contents($get_user_info_url);
      
        if($res){
            $user_obj = json_decode($res, true);
            $customer_all = $this->customer_mdl->load_by_wechat($user_obj['unionid']);//获取用户信息
         
            if($customer_all){//有注册
                // emoji表情截断
                $user_obj['nickname'] = preg_replace_callback('/./u', function (array $match) {
                    return strlen($match[0]) >= 4 ? '^' : $match[0];
                }, $user_obj['nickname']);
                
                //清除表情
                $removeEmoji = $this->removeEmoji($user_obj['nickname']);
                $user_obj['nickname'] = $removeEmoji['nickname'];
                
                //---开始---每次登陆都更新数据库中用户的微信头像和昵称信息 
                $update_info['customer_id'] = $customer_all['id'];
                $update_info['wechat_nickname'] = $user_obj['nickname'];
                $update_info['wechat_avatar'] = $user_obj['headimgurl'];
                $this->update_wechat($update_info);
                
                //将查询出来的用户的微信头像和昵称信息替换成最新的
                $customer_all['wechat_nickname'] = $user_obj['nickname'];
                $customer_all['wechat_avatar'] = $user_obj['headimgurl'];
                //---结束---

                $this->customer_mdl->update_last_login($customer_all['id']);//记录最后登录
                $customer_all['is_user'] =true;
                //支付账号
                $this->load->model('pay_relation_mdl');
                $customer_all['pay_relation'] = $this->pay_relation_mdl->load_id($customer_all['id']);
                
                if($registry_by=="wechat_c"){//如果是c端微信登录才写memcached
                    //memcached信息
                    $customer_all['nick_name'] =$user_obj['nickname'];
                    $customer_all['img_avatar'] = $user_obj['headimgurl'];
                    $customer_all['unionid'] = $user_obj['unionid'];
                    $customer_all['openid'] = $user_obj['openid'];
                    $customer_all['user_name'] =$customer_all['name'];
                    $customer_all['mobile_exist'] =  $customer_all['mobile'] != "" ? true : false;
                    $this->customer_data = $customer_all;
                    $user_key = $this->load_memcached();
                    echo json_encode($user_key);//返回memcached key值
                    exit;
                    
                }
                if($access_token1){
                    //是否关注公众号
                    $customer_all['wechat_subscribe'] = $subscribe_obj['subscribe'];
                }
                echo json_encode($customer_all);
            }else{//未注册
                
                if($registry_by=="wechat_c"){
                    
                    $customer = array(
                        'nick_name' => $user_obj['nickname'],
                        'img_avatar' => $user_obj['headimgurl'],
                        'unionid' => $user_obj['unionid'],
                        'openid' => $user_obj['openid'],
                        'is_user'=> false
                    );
                    $this->customer_data = $customer;
                    $user_key = $this->load_memcached();
                    echo json_encode($user_key);//返回memcached key值
                    exit;
                }
                
                $customer = array(
                    'wechat_nickname' => $user_obj['nickname'],
                    'wechat_avatar' => $user_obj['headimgurl'],
                    'unionid' => $user_obj['unionid'],
                    'openid' => $user_obj['openid'],
                    'is_user'=> false
                );
                if($access_token1){
                    //是否关注公众号
                    $customer['wechat_subscribe'] =$subscribe_obj['subscribe'];
                }
                echo json_encode($customer);//返回用户信息
            }
        }else{
            error_log("res:" . $res);
            echo false;
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    /**
     * 更新微信信息(A端内部方法调用)
     * wechat_nickname
     * wechat_avatar
     */
    private function update_wechat($data){
        $customer_id = $data['customer_id'];//用户ID
        $this->customer_mdl->wechat_avatar =$data['wechat_avatar'];//微信头像
        $this->customer_mdl->wechat_nickname = $data['wechat_nickname'];//微信昵称
        
        
        $is_ok = true;
        $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        $db1->trans_begin();
        $row1 = $this->customer_mdl->update($customer_id);
        if($row1){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();
            $row2 = $this->customer_mdl->update($customer_id);
        
        
            $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
            $db3->trans_begin();
           
            $row3 = $this->customer_mdl->update($customer_id);
        
            if($row2 && $row3){
                if($is_ok){
                    //事务提交
                    $db1->trans_commit();
                    $db2->trans_commit();
                    $db3->trans_commit();
                }else{
                    //事务回滚
                    $db1->trans_rollback();
                    $db2->trans_rollback();
                    $db3->trans_rollback();
                    error_log($db1->last_query());
                    error_log($db2->last_query());
                    error_log($db3->last_query());
                }
        
        
            }else{
                //事务回滚
                $db1->trans_rollback();
                $db2->trans_rollback();
                $db3->trans_rollback();
                error_log($db1->last_query());
                error_log($db2->last_query());
                error_log($db3->last_query());
            }
        
        }else{
            //事务回滚
            $db1->trans_rollback();
            error_log($db1->last_query());
        }
        
    }
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 绑定用户
     */
    function binding_mobile(){

        $mobile = $this->input->post('mobile');//手机
        $password = $this->input->post('password');//密码
        $nick_name = $this->input->post('nick_name');//昵称
        $unionid = $this->input->post('unionid');//unionid
        $wechat_avatar = $this->input->post('wechat_avatar');//头像
        $openid = $this->input->post('openid');//openid
        $app_id = $this->input->post('app_id');//app_id
        $registry_by = $this->input->post('registry_by');
        $time = $this->input->post('time');
        //查询判断是否存在用户
        $customer = $this->customer_mdl->load_by_mobile($mobile);
        if(!$customer){//不存在注册
            $this->db->trans_begin();//开启事务

            $this->customer_mdl->name = $mobile;
            $this->customer_mdl->mobile = $mobile;
            $this->customer_mdl->password = $password;
            $this->customer_mdl->nick_name = $nick_name ? $nick_name : $mobile;
            $this->customer_mdl->app_id = $app_id;
            $this->customer_mdl->registry_by = $registry_by;
    
            $this->customer_mdl->wechat_nickname =  $nick_name;
            $this->customer_mdl->wechat_account = $unionid;
            $this->customer_mdl->wechat_avatar = $wechat_avatar;
            $this->customer_mdl->img_avatar = $wechat_avatar;
            $this->customer_mdl->openid = $openid;
            $this->customer_mdl->app_id = $app_id;
            $this->customer_mdl->time = $time;
            
            $customer_id = $this->customer_mdl->create();
            // 插入成功
            if ($customer_id) {
                $row = $this->create_pay($customer_id,$mobile,$password);//创建支付用户
                if($row){
                        //同步创建用户
                        $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
                        $db2->trans_begin();//开启事务
                        $row2 = $this->customer_mdl->synchro_create($customer_id);//创建用户
                        if($row2){
                            $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                            $db3->trans_begin();//开启事务
                            $row3 = $this->customer_mdl->synchro_create($customer_id);//创建用户
                            if($row3){
                                //事务提交
                                $this->db->trans_commit();
                                $db2->trans_commit();
                                $db3->trans_commit();
                                $customer['id'] = $customer_id;
                            }else{
                                 //事务回滚
                                $this->db->trans_rollback();
                                $db2->trans_rollback();
                                $db3->trans_rollback();
                                echo json_encode(array('status'=>false));exit;//注册失败
                            }
                        }else{                          //事务回滚
                            $this->db->trans_rollback();
                            $db2->trans_rollback();
                            echo json_encode(array('status'=>false));exit;//注册失败
                        }
                }else{
                    $this->db->trans_rollback();
                    echo json_encode(array('status'=>false));exit;//注册失败
                }
            }else{
                $this->db->trans_rollback();//回滚
                echo json_encode(array('status'=>false));exit;
            }
    
        }else{//存在，整合用户
            $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
            $db1->trans_begin();
            $this->customer_mdl->wechat_nickname = $nick_name;
            $this->customer_mdl->wechat_account = $unionid;
            $this->customer_mdl->wechat_avatar = $wechat_avatar;
            $this->customer_mdl->openid = $openid;
            $this->customer_mdl->img_avatar = $wechat_avatar;
            $row = $this->customer_mdl->update($customer['id']);
            if($row){
                $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
                $db2->trans_begin();
                $row = $this->customer_mdl->update($customer['id']);
                if($row){
                    $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                    $db3->trans_begin();
                    $row = $this->customer_mdl->update($customer['id']);
                    if($row){
                        $is_ok = true;
                    }
                }
            }
            if(!empty($is_ok)){
                //事务提交
                $db1->trans_commit();
                $db2->trans_commit();
                $db3->trans_commit();
            }else{
                //事务回滚
                $db1->trans_rollback();
                $db2->trans_rollback();
                $db3->trans_rollback();
                error_log($db1->last_query());
                error_log($db2->last_query());
                error_log($db3->last_query());
                echo json_encode(array('status'=>false));//失败
                exit;
            }

        }
        
        $this->load->model('pay_relation_mdl');
        $this->customer_mdl->update_last_login($customer['id']);//记录最后登录
        $customer2 = $this->customer_mdl->load($customer['id']);//用户信息
        $customer2['pay_relation'] = $this->pay_relation_mdl->load_id($customer['id']);//支付账号
        $customer2['status'] = true;
        echo json_encode($customer2);//返回用户信息
        exit;

    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 创建支付账户
     * @param int $customer_id 用户id
     * @param string $name 用户名
     * @param string $password 用户密码
     * @param string $pay_passwd 支付密码
     */
    public function create_pay($customer_id,$name,$password='',$pay_passwd=null){
    
        // 插入pay信息
        $is_ok = false;
        $this->load->model('pay_account_mdl');
        $this->load->model('pay_relation_mdl');
    
        $this->pay_account_mdl->name = $name;
        $this->pay_account_mdl->passwd = $password;
        $this->pay_account_mdl->pay_passwd = $pay_passwd;
    
        //添加支付账号
        $pay_account_id = $this->pay_account_mdl->createpay_account();
        if ($pay_account_id) {
            $this->pay_relation_mdl->id_pay = $pay_account_id;
            $this->pay_relation_mdl->customer_id = $customer_id;
            $pay_relation_id = $this->pay_relation_mdl->createpay_relation();
            if($pay_relation_id){
                $is_ok = true;
            }
        }
        return $is_ok;
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 修改用户资料
     * 同步3个库
     */
    public function info_save(){
        
        $customer_id = $this->input->post("user_id");//用户id
        $this->customer_mdl->email = $this->input->post("email");//邮箱
        $this->customer_mdl->phone = $this->input->post('phone');//电话
        $this->customer_mdl->real_name = $this->input->post('real_name');//真实姓名
        $this->customer_mdl->nick_name = $this->input->post('nick_name');//昵称
        $this->customer_mdl->sex = $this->input->post('sex');//性别
        $this->customer_mdl->birthday = $this->input->post('birthday');//生日
        $this->customer_mdl->job = $this->input->post('job');//职业
        $name = $this->customer_mdl->name = $this->input->post('name');//用户名
        $this->customer_mdl->mobile = $this->input->post('mobile');//手机
        $this->customer_mdl->openid = $this->input->post('openid');//微信openid
        $this->customer_mdl->wechat_account = $this->input->post('unionid');//unionid
        $this->customer_mdl->wechat_avatar = $this->input->post('wechat_avatar');//微信头像
        $this->customer_mdl->wechat_nickname = $this->input->post('wechat_nickname');//微信昵称
        
        $this->customer_mdl->pay_passwd = $this->input->post('pay_passwd');//用户登录密码
        
        
        $is_ok = true;
        $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        $db1->trans_begin();
        $row1 = $this->customer_mdl->update($customer_id);
        if($row1){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();
            $row2 = $this->customer_mdl->update($customer_id);
            

            $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
            $db3->trans_begin();
            $row3 = $this->customer_mdl->update($customer_id);
            
            if($row2 && $row3){
                //查询判断用户名是否被修改，修改则同步支付用户
                if($name){
                    $user = $this->customer_mdl->load($customer_id);
                    if($user['name'] != $name){
                         $this->load->model('pay_account_mdl');
                         $this->pay_account_mdl->name = $name;
                         $row4 = $this->pay_account_mdl->update($customer_id);//修改支付账户name
                         if(!$row4){
                             $is_ok = false;
                         }
                    }

                }
                if($is_ok){
                    //事务提交
                    $db1->trans_commit();
                    $db2->trans_commit();
                    $db3->trans_commit();
                    echo json_encode(array('status'=>true));//成功
                    exit;
                }else{
                    //事务回滚
                    $db1->trans_rollback();
                    $db2->trans_rollback();
                    $db3->trans_rollback();
                    error_log($db1->last_query());
                    error_log($db2->last_query());
                    error_log($db3->last_query());
                    echo json_encode(array('status'=>false));//失败
                    exit;
                }


            }else{
                //事务回滚
                $db1->trans_rollback();
                $db2->trans_rollback();
                $db3->trans_rollback();
                error_log($db1->last_query());
                error_log($db2->last_query());
                error_log($db3->last_query());
                echo json_encode(array('status'=>false));//失败
                exit;
            }
            
        }else{
            //事务回滚
            $db1->trans_rollback();
            error_log($db1->last_query());
            echo json_encode(array('status'=>false));//失败
        }
        

    }
    
    //---------------------------------------------------------------------------------------------------
 
    /**
     * 获取用户信息 by id
     */
    public function load(){
        $cusotmer_id = $this->input->post('customer_id');//用户id
        $customer = $this->customer_mdl->load($cusotmer_id);
        echo json_encode($customer);
    }
    /**
     * 获取用户信息 by mobile
     */
    public function load_by_mobile(){
        $mobile = $this->input->post('mobile');//用户id
        $customer = $this->customer_mdl->load_by_mobile($mobile);
        echo json_encode($customer);
    }
    
    /**
     * 获取用户信息 load_by_where
     */
    public function load_by_where(){
        $type = $this->input->post('type');
        $data[$type] = $this->input->post($type);
        $customer = $this->customer_mdl->load_by_where($data);
       
        echo json_encode($customer);
    }
    
    /**
     * 检查密码
     */
    public function check_pwd(){
        $cusotmer_id = $this->input->post('customer_id');//用户id
        $password = $this->input->post('password');//用户密码
        $customer = $this->customer_mdl->check_pwd($password,$cusotmer_id);
        if($customer){
            echo json_encode(array('status'=>true));//成功
        }else{
            echo json_encode(array('status'=>false));//失败
        }
    }
    
    
    /**
     * 获取支付账户
     * 
     */
    public function load_pay_account(){
        $customer_id = $this->input->post("customer_id");
        $this->load->model('pay_account_mdl');
        $pay_account = $this->pay_account_mdl->load($customer_id);
        
        echo json_encode($pay_account);
    }
    
  
    //---------------------------------------------------------------------------------------------------
    /**
     * 忘记密码
     */
    public function forget_password(){
        $this->customer_mdl->password = $this->input->post('password');
        $mobile = $this->input->post('mobile');
        $res = $this->customer_mdl->forget_password($mobile);
        echo json_encode($res);
    }
    /**
     * 修改用户密码
     */
    public function update_pwd(){
        $customer_id = $this->input->post("customer_id");
        $password = $this->input->post("password");//新密码
        $row = $this->customer_mdl->update_pwd($customer_id,$password);
        if($row){
            echo json_encode(array('status'=>true));//成功
        }else{
            error_log($this->db->last_query());
            echo json_encode(array('status'=>false));//失败
        }

    }
    /**
     * 设置支付密码
     * 
     */
    public function setPayPassword(){
        $customer_id = $this->input->get_post("customer_id");
        $pay_passwd = $this->input->get_post("pay_passwd");
        $this->load->model('pay_account_mdl');
        $this->pay_account_mdl->pay_passwd = $pay_passwd;
        $res = $this->pay_account_mdl->update($customer_id);
        if($res){
            echo json_encode(array('status'=>true));//成功
        }else{
            echo json_encode(array('status'=>false));//失败
        }
    }

    
    /**
     * 修改支付密码判断新旧密码是否相同
     */
    public function getPayAccount(){
        $customer_id = $this->input->get_post("customer_id");
        $pay_passwd = $this->input->get_post("pay_passwd");
        $this->load->model('pay_account_mdl');
        $result = $this->pay_account_mdl->load( $customer_id );
        if(md5($pay_passwd) == $result['pay_passwd'] ){
            echo json_encode(array('status'=>true));//新旧支付密码相同
        }else{
            echo json_encode(array('status'=>false));//新旧支付密码不相同
        }
    }
    
    /**
     * 解绑
    */
    public function unbundling(){
        $customer_id = $this->input->get_post("customer_id");
        $mobile =  $this->input->get_post("mobile");
        $type =  $this->input->get_post("type");
        
        if(!empty($mobile)){
            $this->customer_mdl->name = $mobile;
        }
        if ($type == 'wechat') {
            if(empty($mobile)){
                //把解绑的微信账户name修改成当前时间戳，
                //防止以后再次绑定生成微信用户时用户名重复生成不了新用户而导致绑定不了
                $this->customer_mdl->name = 'wechat:UnBind'.time();
                $this->customer_mdl->mobile = "00000000000";
                $this->customer_mdl->parent = NULL;//上线信息清空
                $this->customer_mdl->is_valid = '0';//失效
            }
            $this->customer_mdl->wechat_account = '';
            $this->customer_mdl->wechat_nickname = '';
            $this->customer_mdl->wechat_avatar = '';
            $this->customer_mdl->openid = '';
            $content_type = '微信';
        }
        if ($type == 'qq') {
            $this->customer_mdl->qq_account = '';
            $this->customer_mdl->qq_nickname = '';
            $this->customer_mdl->qq_avatar = '';
            $content_type = 'QQ';
        }
        if ($type == 'weibo') {
            $this->customer_mdl->weibo_account = '';
            $this->customer_mdl->weibo_nickname = '';
            $this->customer_mdl->weibo_avatar = '';
            $content_type = '微博';
        }
        if ($type == 'alipay') {
            $this->customer_mdl->alipay_account = '';
            $this->customer_mdl->alipay_nickname = '';
            $this->customer_mdl->alipay_avatar = '';
            $content_type = '支付宝';
        }
        
        $is_ok = false;//事务识别
        $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        $db1->trans_begin();
        $row = $this->customer_mdl->update($customer_id);
        if($row){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();
            $row = $this->customer_mdl->update($customer_id);
        
            if($row){
                $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                $db3->trans_begin();
                $row = $this->customer_mdl->update($customer_id);
        
                if($row){
                    $is_ok = true;
                }
            }
        }
        
        if($is_ok){
            //事务提交
            $db1->trans_commit();
            $db2->trans_commit();
            $db3->trans_commit();
            echo json_encode(array('status'=>true));//成功
            exit;
        }else{
            //事务回滚
            $db1->trans_rollback();
            $db2->trans_rollback();
            $db3->trans_rollback();
            error_log($db1->last_query());
            error_log($db2->last_query());
            error_log($db3->last_query());
            echo json_encode(array('status'=>false));//失败
            exit;
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 把用户废除
     */
    public function AbolishUser(){
        $customer_id = $this->input->post("customer_id");
        $unionid =  $this->input->post("unionid");
        $type =  $this->input->post("type");
    
        $this->customer_mdl->mobile = "00000000000";
        if ($type == 'wechat') {
            if(empty($mobile)){
                //把解绑的微信账户name修改成当前时间戳，
                //防止以后再次绑定生成微信用户时用户名重复生成不了新用户而导致绑定不了
                $this->customer_mdl->name = 'wechat:UnBind'.time();
            }
            $this->customer_mdl->wechat_account = '';
            $this->customer_mdl->wechat_nickname = '';
            $this->customer_mdl->wechat_avatar = '';
            $this->customer_mdl->openid = '';
            $content_type = '微信';
        }
        if ($type == 'qq') {
            $this->customer_mdl->qq_account = '';
            $this->customer_mdl->qq_nickname = '';
            $this->customer_mdl->qq_avatar = '';
            $content_type = 'QQ';
        }
        if ($type == 'weibo') {
            $this->customer_mdl->weibo_account = '';
            $this->customer_mdl->weibo_nickname = '';
            $this->customer_mdl->weibo_avatar = '';
            $content_type = '微博';
        }
        if ($type == 'alipay') {
            $this->customer_mdl->alipay_account = '';
            $this->customer_mdl->alipay_nickname = '';
            $this->customer_mdl->alipay_avatar = '';
            $content_type = '支付宝';
        }
    
        $is_ok = false;//事务识别
        $db1 = $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        $db1->trans_begin();
        $row = $this->customer_mdl->AbolishUser($customer_id,$unionid);
        if($row){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();
            $row = $this->customer_mdl->AbolishUser($customer_id,$unionid);
    
            if($row){
                $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
                $db3->trans_begin();
                $row = $this->customer_mdl->AbolishUser($customer_id,$unionid);
    
                if($row){
                    $is_ok = true;
                }
            }
        }
    
        if($is_ok){
            //事务提交
            $db1->trans_commit();
            $db2->trans_commit();
            $db3->trans_commit();
            echo json_encode(array('status'=>true));//成功
            exit;
        }else{
            //事务回滚
            $db1->trans_rollback();
            $db2->trans_rollback();
            $db3->trans_rollback();
            error_log($db1->last_query());
            error_log($db2->last_query());
            error_log($db3->last_query());
            echo json_encode(array('status'=>false));//失败
            exit;
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    
    
    
    /**
     * 设置memcached
     */
    function set_memcached(){
        $data = $this->input->post();//内容
        $key  = $this->input->post("user_key");
        $mem = $this->tel_memcached();//连接memcached
        if(!$mem){
            echo false;
        }else if($mem->set($key,$data,time()+180000)){
            echo $key;//返回key
        }else{
            echo false;
        }
    }
    
    
    /**
     * 获取memcached
     */
    function get_memcached(){
        $key  = $this->input->post("user_key");
        $mem = $this->tel_memcached();//连接memcached
        $result = $mem->get( $key );
        if($result){
            echo json_encode($result);
        }else{
            echo false;
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 绑定银行卡
     */
    function add_card(){
        $customer_id = $this->input->post("customer_id");//用户名
        $this->customer_mdl->real_name = $this->input->post("real_name");//真实姓名
        $this->customer_mdl->identity = $this->input->post("identity");//身份证号码
        $this->customer_mdl->card_number = $this->input->post("card_number");//银行卡号
        $this->customer_mdl->address = $this->input->post("address");//地址
        $this->customer_mdl->bank = $this->input->post("bank");//银行信息
        $this->customer_mdl->branch = $this->input->post("branch");//所属支行
        $id = $this->customer_mdl->add_card($customer_id);//绑定
        if($id){
            echo $id;
        }else{
            echo false;
        }
    }
    
    /**
     * 更新银行卡
     */
    function save_card(){
        $customer_id = $this->input->post("customer_id");//用户名
        $this->customer_mdl->real_name = $this->input->post("real_name");//真实姓名
        $this->customer_mdl->identity = $this->input->post("identity");//身份证号码
        $this->customer_mdl->card_number = $this->input->post("card_number");//银行卡号
        $this->customer_mdl->address = $this->input->post("address");//地址
        $this->customer_mdl->bank = $this->input->post("bank");//银行信息
        $this->customer_mdl->branch = $this->input->post("branch");//所属支行
        $row = $this->customer_mdl->save_card($customer_id);//绑定
        if($row){
            echo true;
        }else{
            echo false;
        }
    }
    
    //------------------------------------------------------------------------------------------------
    
    /**
     * 查询用户银行卡信息
     */
    function load_card(){
        $customer_id = $this->input->post("customer_id");//用户名
        $result = $this->customer_mdl->load_card($customer_id);
        echo json_encode($result);
        
    }
    
    // -----------------------------------------------------------------------------------------------
    
    /**
     * 检查手机号码是否黑名单
     */
    public function check_blacklist(){
        $mobile = $this->input->post("mobile");//手机
        $this->load->model("customer_mdl");
        $row = $this->customer_mdl->check_blacklist($mobile);
        if($row){
            $result["status"] = true;
        }else{
            $result["status"] = false;
        }
        echo json_encode($result);
    }
    
    // --------------------------------------------------------------------------------------------------
    
    
    /**
     * 预注册，预绑定
     */
    function customer_pre(){
        
        $user_id = $this->input->post("user_id");//当前用户id
        $name = $this->input->post('name');
        $app_id =$this->input->post('app_id');
        $registry_by = $this->input->post('registry_by');//pre-wechat
        $time = $this->input->post("time");


        $this->customer_mdl->name = $name;
        $this->customer_mdl->nick_name = $name;
        $this->customer_mdl->mobile = $name;
        $this->customer_mdl->app_id = $app_id;
        $this->customer_mdl->time = $time;
        $this->customer_mdl->registry_by = $registry_by;
        $this->customer_mdl->password = md5("ehw888888");
        
        //创建用户，同步3库数据
        $is_ok = false;//事务识别
        $this->db->trans_begin();//开启事务
        
        $customer_id = $this->customer_mdl->create();//创建用户
        
        
        //预绑定
        $this->load->model("customer_pre_mdl");
        $is_pre = $this->customer_pre_mdl->check_customer($user_id);
        $data["customer_id"] = $user_id;
        $data["name"] = $name;
        $data["pre_customer_id"] = $customer_id;
        if($is_pre){
            $row = $this->customer_pre_mdl->update($user_id,$data);//更新
        }else{
            $row = $this->customer_pre_mdl->add($data);//添加
        }
        
        
        $pay_relation_id = 0;//默认支付id
        if($customer_id && $row){
            $db2 = $this->customer_mdl->db1 = $this->load->database('B',true);//切换B库
            $db2->trans_begin();//开启事务
            $row2 = $this->customer_mdl->synchro_create($customer_id);//创建用户
            
            $db3 = $this->customer_mdl->db1 = $this->load->database('C',true);//切换C库
            $db3->trans_begin();//开启事务
            $row3 = $this->customer_mdl->synchro_create($customer_id);//创建用户
        

            // 插入pay信息
            $this->load->model('pay_account_mdl');
            $this->load->model('pay_relation_mdl');
            $this->pay_account_mdl->name = $name;
    
            //添加支付账号
            $pay_account_id = $this->pay_account_mdl->createpay_account();
            if ($pay_account_id) {
                $this->pay_relation_mdl->id_pay = $pay_account_id;
                $this->pay_relation_mdl->customer_id = $customer_id;
                $pay_relation_id = $this->pay_relation_mdl->createpay_relation();
                if($pay_relation_id){
                    $is_ok = true;
                }
            }


            if(!$row2 || !$row3){
                $is_ok = false;
            }
        
            if($is_ok){
                //事务提交
                $this->db->trans_commit();
                $db2->trans_commit();
                $db3->trans_commit();
                echo json_encode(array('status'=>'3','customer_id'=>$customer_id,'pay_relation_id'=>$pay_relation_id));//注册成功
            }else{
                //事务回滚
                $this->db->trans_rollback();
                $db2->trans_rollback();
                $db3->trans_rollback();
                echo json_encode(array('status'=>'2'));//注册失败
                exit;
            }
        
        }else{
            //事务回滚
            error_log("A库错误：".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode(array('status'=>'2'));//注册失败
            exit;
        }
        
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 获取预绑定用户
     */
    public function get_customer_pre(){
        $customer_id = $this->input->post("customer_id");
        $this->load->model("customer_pre_mdl");
        $data = $this->customer_pre_mdl->check_customer($customer_id);
        echo json_encode($data);
    }
    
    // --------------------------------------------------------------------
    
    /**
    * @author JF
    * 2018年3月14日
    * 更新A库用户信息
    */
    function UpdateA(){
        $customer_id = $this->input->post("user_id");//用户id
        $this->customer_mdl->real_name = $this->input->post('real_name');//真实姓名
        $this->customer_mdl->idcard = $this->input->post('idcard');//身份证
        $this->customer_mdl->bankcard = $this->input->post('bankcard');//银行卡
        $this->customer_mdl->bankmobile = $this->input->post('bankmobile');//预留手机号码
        $this->customer_mdl->authenticationat = date("Y-m-d H:i:s");//认证时间
        $this->customer_mdl->db1 = $this->load->database('A',true);//切换A库
        
        $row = $this->customer_mdl->update($customer_id);
        if($row){
           $return = array(
                   "status" => "00",
                   "message" => "成功"
           );
        }else{
            $return = array(
                    "status" => "01",
                    "message" => "更新失败"
            );
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
    * @author JF
    * 2018年3月14日
    * 查询身份证
    */
    function CheckIdCard(){
        $idcard = $this->input->post("idcard");//身份证号
        $return = $this->customer_mdl->CheckIdCard($idcard);
        echo json_encode($return);
        
    }
    
}

?>