<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Property extends Api_Controller {
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_mdl');
    }
    
    /**
     * 获取用户资产
     */
    public function index()
    {
        echo 'Property API';
    }
    
    public function getUserPropertyById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
    }
    
    public function getUserPropertyLogById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $user_id = $this->session->userdata('user_id');
    
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 检验参数
        $this->_check_prams($prams, array(
            'type'
        ));
        $type = $prams['type'];
        if(!in_array($type,array("3","1","2"))){ //授信 3 现金 2   货豆 1
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $relation_id = $this->session->userdata ( 'pay_relation' );
       
        $count_url = $this->url_prefix.'log/ajax_transaction_list/?status='.$type.'&page=&limit=&relation_id='.$relation_id;
        $total_info = json_decode($this->curl_get_result($count_url),true);
        $totalcount = count($total_info['log']);
       
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $url = $this->url_prefix.'log/ajax_transaction_list/?status='.$type.'&page='.$perPage.'&limit='.$currPage.'&relation_id='.$relation_id;
        $result = json_decode($this->curl_get_result($url),true);
        $log = $result['log'];
        if($log && count($log) > 0){
            foreach ($log as $key => $res) {
                $listdate[$key]["remark"] = isset($res["remark"]) ? $res["remark"]:"";
                $listdate[$key]["created_at"] = isset($res["created_at"])?$res["created_at"]:"";
                if($type == 3){//授信
                    $listdate[$key]["balance"] = isset($res["credit"])?$res["credit"]:"";
                }else if($type == 1){// 货豆
                    $listdate[$key]["balance"] = isset($res["amount"])?$res["amount"]:"";
                }else{//现金
                    $listdate[$key]["balance"] = isset($res["cash"])?$res["cash"]:"";
                }
                $listdate[$key]["customer_id"] = isset($res["customer_id"])?$res["customer_id"]:"";
                $listdate[$key]["corporation_name"] = isset($res["corporation_name"]) ? $res["corporation_name"] : "";
                $listdate[$key]["order_no"] = isset($res["order_no"])?$res["order_no"]:"";
                $listdate[$key]["type"] = isset($res["type"])?$res["type"]:"";
            }
            // 返回数据
            $return['data']['perpage'] = $perPage;
            $return['data']['currentpage'] = $currPage;
            $return['data']['totalcount'] = $totalcount;
            $return['data']['totalpage'] = $totalpage;
            $return['data']['listdate'] = $listdate;
        }
        else {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '无日志！'
            );
        }
        print_r(json_encode($return));
    }
    
    /**
     * 我的收益
     * @param unknown $url
     */
    public  function  Income(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $return['data'] = array(
            'url'=> site_url('Income'),
        );
        print_r(json_encode($return));
    }
    
    
    private function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    private function curl_post_result($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
}