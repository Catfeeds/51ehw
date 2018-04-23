<?php
/**
 * 
 
 * M卷操作日志
 */
class Customer_currency_log_mdl extends CI_Model {
    public $openid;
    
	function __construct() {
		parent::__construct ();
	}

	
	/**
	 * 
	 * 获取提货权操作记录数
	 */
    public function count_currency_log($customer_id){
        $this->db->from('customer_currency_log as l');
        $this->db->join('pay_relation as r','l.relation_id = r.id');
	    $this->db->where('r.customer_id',$customer_id);
        return $this->db->count_all_results();
    }
	
	/**
	 * 
	 * 添加M卷日志
	 */
	public function add_log( $data ){ 
	    $this->db->set('relation_id', $data['relation_id']);
	    $this->db->set('id_event', $data['id_event']);
	    $this->db->set('created_at', date('Y-m-d H:i:s'));
	    $this->db->set('remark', $data['remark']);
	    $this->db->set('app_id',  $this->session->userdata('app_info')['id']);
	    $this->db->set('amount', $data['amount']);
	    $this->db->set('beginning_balance',$data['beginning_balance']);
	    $this->db->set('ending_balance', $data['ending_balance']);
	    $this->db->set('state',$data['status']);
	    $this->db->set('type', $data['type']);
	    if(isset($data['order_no']) )
	       $this->db->set('order_no', $data['order_no']);
	    if(isset($data['customer_id']) )
	        $this->db->set('customer_id', $data['customer_id']);
	    $this->db->insert('customer_currency_log');
	    $log_id = $this->db->insert_id();
	    return $log_id;
	}
	
	
	/**
	 * 批量添加日志
	 */
	public function bath_add_log($data){ 
	    return $this->db->insert_batch('customer_currency_log', $data);
	    
	}
	/**
	 * M卷交易日志
	 */
	public function load($customer_id, $limit = 0, $offset = 0){
	    if ($limit)
	        $this->db->limit ( $limit );
	    if ($offset)
	        $this->db->offset ( $offset );
	    $this->db->select('l.*, c.name, cc.corporation_name');
	    $this->db->from('customer_currency_log as l');
	    $this->db->join('pay_relation as r','l.relation_id = r.id');
	    $this->db->join('customer_corporation as cc','l.customer_id = cc.customer_id','left');
	    $this->db->join('customer as c','l.customer_id = c.id','left');
	    $this->db->where('r.customer_id',$customer_id);
	    $this->db->order_by('l.id','desc');
	    $result = $this->db->get()->result_array();
// 	    echo $this->db->last_query();
	    return $result;
	}
	
	/**
	 * 添加一张充值M卷的订单
	 */
	public function create_charge_currency( $data ){ 
	    $this->db->set('charge_no', $data['charge_no']);
	    $this->db->set('amount', $data['amount']);
	    $this->db->set('create_date', date('Y-m-d H:i:s') );
	    $this->db->set('customer_id', $data['customer_id']);
	    $this->db->insert('charge_currency');
	    return $this->db->insert_id();
	}
	
	/**
	 * 查询M卷订单号是否存在，存在返回true
	 */
	function check_charge_sn( $charge_no )
	{
	    $this->db->select('id');
	    $query = $this->db->get_where('charge_currency', array(
	        'charge_no' => $charge_no
	    ));
	    if ($query->row_array()) {
	        return true;
	    } else {
	        return false;
	    }
	}
	
	/**
	 * 某个人的最新的交易日志
	 */
	public function load_last( $pay_relation_id ){
	    $this->db->select('*');
	    $this->db->from('customer_currency_log ');
        $this->db->where('relation_id',$pay_relation_id);
        $this->db->order_by('id','desc');
	    $result = $this->db->get()->row_array();
// 	    var_Dump($pay_relation_id);
	    return $result;
	    
	}
	
	/**
	 * M卷交易日志
	 */
	public function load_total($customer_id){
	    $this->db->select('l.id');
	    $this->db->from('customer_currency_log as l');
	    $this->db->join('pay_relation as r','l.relation_id = r.id');
	    $this->db->join('customer_corporation as cc','l.customer_id = cc.customer_id','left');
	    $this->db->join('customer as c','l.customer_id = c.id','left');
	    $this->db->where('r.customer_id',$customer_id);
	    return $this->db->count_all_results();
	   
	}
	
	/**
	 * 拼凑推送消息数据 
	 */
	public function result_message( $data ){ 
	    
	    if(  ( !empty($this->openid  ) ) && $data['relation_id'] != '-1'){
	        
            $this->load->model('pay_relation_mdl');
            $this->pay_relation_mdl->id = $data['relation_id'];
            $pay_info = $this->pay_relation_mdl->load();
	        
            if( count( $pay_info ) == 0 )
                return false;
	                 
	        switch ( $data['id_event'] ){
	             
	            case 66: //充值提货权
	                $data_message['status'] = 1;
	                $data_message['first'] = '您好，提货权已成功充值到账。'; //模板头部说明
	                $data_message['keyword1'] = $pay_info['name']; //账号
	                $data_message['keyword2'] = $data['amount']. ' 提货权'; //账号
	                $data_message['keyword3'] = '五一易货网现金余额'; //途径
	                $data_message['keyword4'] = date('Y-m-d H:i:s'); //时间
	                $data_message['remark'] = '提货权余额：'.($data['ending_balance']).'\n感谢您的使用。';//底部说明
	                 
	                //H5和电脑的连接不一样
	                if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
	                    $data_message['url']  = site_url('customer/fortune');
	                }else{
	                    $data_message['url']  = site_url('member/property/get_list');
	                }
	                break;
	                 
	            case 58://购物支出
                case 60://红包支出
	                $data_message['status'] = 2;
	                $data_message['first'] = '尊敬的客户：您的五一易货网账户发生了一笔消费支出，请确认是否是您本人消费。'; //模板头部说明
	                $data_message['keyword1'] = !empty($data['order_no']) ? $data['order_no'] : '无'; //订单号
	                $data_message['keyword2'] = $data['amount']. ' 提货权'; //消费提货权
	                $data_message['keyword3'] = $data['remark']; //途径
	                $data_message['keyword4'] = $pay_info['name']; //账号
	                $data_message['keyword5'] = date('Y-m-d H:i:s'); //途径
	                $data_message['remark'] = '提货权余额：'.($data['ending_balance']).'\n亲，如您在购物体验中遇到疑问请联系客服。';//底部说明
	                //H5和电脑的连接不一样
	                if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
	                    $url  = site_url('log/transaction_list');
	                }else{
	                    $url  = site_url('member/property/get_list');
	                }
	                
	                $data_message['url'] = !empty($data['order_no']) ? site_url('member/order/detail/'.$data['order_id']) : $url;
	                break;
	                
	            case 59://红包收入    
	            case 62://收入通知
	                $data_message['status'] = 3;
	                $data_message['first'] = '尊敬的客户：您的五一易货网账户发生了一笔提货权收入。'; //模板头部说明
	                $data_message['keyword1'] = $data['amount']. ' 提货权'; //收入提货权
	                $data_message['keyword2'] = $data['remark']; //收入途径
	                $data_message['keyword3'] = !empty($data['order_no']) ? $data['order_no'] : '无'; //订单号
	                $data_message['keyword4'] = date('Y-m-d H:i:s'); //时间
	                $data_message['remark'] = '提货权余额：'.($data['ending_balance']).'\n亲，如您在购物体验中遇到疑问请联系客服。';//底部说明
	                //H5和电脑的连接不一样
	                if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
	                    $url  = site_url('log/transaction_list');
	                }else{
	                    $url  = site_url('member/property/get_list');
	                }
	                $data_message['url'] = $url;
	                break;
	               
	        }
	        
	        if( !empty($data_message['status'] ) )
	            $this->wechat_message($data_message);
	    }
	}
	
	/**
	 * 微信消息推送
	 * 
	 */
	private  function wechat_message( $data = array() ){ 
	    
        $this->load->library('Wechat_message');
        $this->wechat_message->status = $data['status'];
        $this->wechat_message->openid = $this->openid;
        $this->wechat_message->app_id = $this->session->userdata('app_info')['wechat_appid'];
        $this->wechat_message->appsecret = $this->session->userdata('app_info')['wechat_appsecret'];
        $this->wechat_message->web_url  = $this->session->userdata('app_info')['site_url'];
        
        //模板消息 -- 默认
        $message = array(
            'first'=>array('value'=>urlencode( $data['first'] ),'color'=>"#000000"),
            'keyword1'=>array('value'=>urlencode( $data['keyword1'] ),'color'=>'#000000'),
            'keyword2'=>array('value'=>urlencode( $data['keyword2'] ),'color'=>'#000000'),
            'keyword3'=>array('value'=>urlencode( $data['keyword3'] ),'color'=>'#000000'),
            'keyword4'=>array('value'=>urlencode( $data['keyword4'] ),'color'=>'#000000'),
            'remark' => array('value'=>urlencode( $data['remark'] ),'color'=>'#000000')
        );
        
        switch ( $data['status'] ){ 
             case 2:
                 $message['keyword5']  = array('value'=>urlencode( $data['keyword5'] ),'color'=>'#000000');
             break;
        }
        
        $this->wechat_message->sendtpl_msg($data['url'],$message);
   }
}