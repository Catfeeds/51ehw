<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * 
 * @author js-php-01
 * 我的分销 and 我的佣金
 */
class Order_Retail extends Api_Controller
{
    public $customer_id;
    public $name;
    public $nick_name;
    public $wechat_nickname;
    public function __construct()
    {
        parent::__construct();
        
        if( !$this->session->userdata('user_id') )
        { 
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //获取开店时间。
        $this->load->model('customer_shop_mdl');
        $shop_info = $this->customer_shop_mdl->load($this->session->userdata('user_id'));
        
        if( empty($shop_info) || $shop_info['status'] != 1)
        {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '互助店未生效'
            );
            print_r(json_encode($return));
            exit();
        
        }
        
        $this->load->model('Customer_mdl');
        $this->load->model('Order_rebate_mdl');
        
        $this->customer_id = $this->session->userdata ( 'user_id' );
        $this->name = $this->session->userdata ( 'user_name' );
        $this->nick_name = $this->session->userdata ( 'nick_name' );
        $this->wechat_nickname = $this->session->userdata ( 'wechat_nickname' );
    }
    
    
    public function index()
    {
        echo 'order_retail API';
    }
    
    /**
     * 我的分销
     * @type = 1本店，2一级，3二级。
     * @status = 1全部，2待付款，3待收货，4已完成
     */
    public function order()
    { 
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        //查询订单
        $customer_id = $this->session->userdata ( 'user_id' );
        
        //处理参数
        $type = $prams['type'];
        $status = $prams['status'];
        
        //分页参数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        
        switch ($type)
        {
            case 1:
                
                $rebate = 'rebate3'; //SQL字段 = 自己
                $rebaterate = 'rebaterate_3';
                $level_id_array = $customer_id;
                break;
                
            case 2:
                /**
                 * 获取所有下级的用户ID
                 */
                $level_id_array = $this->Customer_mdl->lower_level($customer_id);
                $rebate = 'rebate1'; //SQL字段 = 下级
                $rebaterate = 'rebaterate_1';
                break;
                
            case 3:
                
                //获取所有下级的用户ID
                $level_id_array = $this->Customer_mdl->two_level($customer_id);
                $rebate = 'rebate2'; //SQL字段 = 下下级
                $rebaterate = 'rebaterate_2';
                //在获取所有下下级用户ID
                break;
                
            default:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '255',
                    'errorMessage' => '类型参数错误'
                );
                print_r(json_encode($return));
                exit();
                
                break;
            }
        
            $order_status = '';
            //订单列表的状态
            switch ( $status )
            { 
                case 1: //全部
                    $order_status = '2,4,6,9,14';
                    break;
                case 2: //待付款
                    $order_status = '2';
                    break;
                case 3: //待收发货
                    $order_status = '4,6';
                    break;
                case 4: //已完成
                    $order_status = '9,14';
                    break;
                
            }
            
        
        
        if( !empty($level_id_array) && $type != 1)
        {
            $level_id_array = implode(array_column($level_id_array,'id'),',');
        
        }
        
        //列表
        $list = $this->Order_rebate_mdl->my_retail($rebate,$rebaterate,$order_status,$level_id_array,false,$perPage,$offset);
        
        //统计条数各个状态的
        $this->load->model('order_mdl');
        $count_num = $this->order_mdl->count_status_num( $level_id_array );
        
        //不在SQL做计算佣金
        foreach ($list as $key => $val)
        { 
            if( !in_array($val['status'],array(9,14)) && $val['rebate'] && $val['commission'] > 0)
            { 
                $list[$key]['rebaterate'] = ($val['rebate']/100) * $val['commission'];
            }
        }
        $count_data = $this->Order_rebate_mdl->my_retail($rebate,$rebaterate,$order_status,$level_id_array,true);
        $totalcount = $count_data['total_num'];
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $return['responseMessage']['messageType'] = 'success';
        $return['responseMessage']['errorType'] = '0';
        $return['responseMessage']['errorMessage'] = '';
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
//         $return['data']['totalcount'] = $totalcount;
//         $return['data']['totalpage'] = $totalpage;
        $return['data']['order_total_price'] = $count_data['order_total_price'];
        $return['data']['total_rebaterate'] = $count_data['total_rebaterate']; //已完成状态才传值
        $return['data']['all_num'] = $count_num['stay_pay_num']+$count_num['receiving_num']+$count_num['ok_num'];
        $return['data']['stay_pay_num'] = $count_num['stay_pay_num'];
        $return['data']['receiving_num'] = $count_num['receiving_num'];
        $return['data']['ok_num'] = $count_num['ok_num'];
        $return['data']['list'] = $list;
//         echo '<pre>';
//         var_Dump($return);
        print_r(json_encode($return));
        exit();
    }
   
    /**
     * 我的佣金包含（货豆佣金，现金佣金）
     */
    public function my_commission()
    { 
         // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $type = $prams['type'] == 1 ? 1 : 2;
        
        //未收货初始化数组
        $not_receive['total'] = 0;
        $not_receive['list'][1] = 0; //一级
        $not_receive['list'][2] = 0; //二级
        $not_receive['list'][3] = 0; //本店
        
        //已收货初始化数组
        $receive['total'] = 0;
        $receive['list'][1] = 0; //一级
        $receive['list'][2] = 0; //二级
        $receive['list'][3] = 0; //本店
        
        //审核通过初始化数组
        $accomplish['total'] = 0;
        $accomplish['list'][1] = 0; //一级
        $accomplish['list'][2] = 0; //二级
        $accomplish['list'][3] = 0; //本店
        
        $customer = array(); //初始化ID
        
        $customer_id = $this->session->userdata ( 'user_id' );
        
        //下线ID
        $one_level_id = $this->Customer_mdl->lower_level($customer_id);
        
        //如果有下线
        if( $one_level_id )
        {
            //下标1代表是一级
            $customer[1] = implode(array_column($one_level_id,'id'),',');
        
            //查询下下线ID
            $two_level_id = $this->Customer_mdl->two_level($customer_id);
        
            //如果有下下线
            if( $two_level_id )
            {
                //下标2代表是二级
                $customer[2] = implode(array_column($two_level_id,'id'),',');
            }
        
        }
        //下标3代表是自己
        $customer[3] = $customer_id;
        
        //处理货豆
        if ($type == 1)
        { 
            $rebate_type = 2; //会员消费货豆
            
            //未收货处理
            $not_receive_data = $this->Order_rebate_mdl->not_receive_commission( $customer );
            foreach ( $not_receive_data as $k=>$v )
            { 
                if (!empty($v['rebaterate']) )
                {
                    $not_receive['list'][$v['level']] = round($v['rebaterate'],2);
                    $not_receive['total'] += $v['rebaterate'];
                }
            }
           
            $return['data']['not_receive'] = $not_receive;
            
        }else{ 
            
            //处理现金
            $rebate_type = 1;
        }
        
        //公用--区域--开始
        
        //已经收货处理
        $receive_data = $this->Order_rebate_mdl->receive_commission( $customer,false, $rebate_type );
       
        foreach ( $receive_data as $k => $v)
        {
            if (!empty($v['rebaterate']) )
            {
                $receive['list'][$v['level']] = round($v['rebaterate'],2);
                $receive['total'] += $v['rebaterate'];
            }
        }
        
        //审核通过
        $accomplish_data = $this->Order_rebate_mdl->receive_commission( $customer, true, $rebate_type );
        
        foreach ( $accomplish_data as $k => $v)
        {
            if (!empty($v['rebaterate']) )
            {
                $accomplish['list'][$v['level']] = round($v['rebaterate'],2);
                $accomplish['total'] += $v['rebaterate'];
            }
        }
        
        
        $return['data']['receive'] = $receive;
        $return['data']['accomplish'] = $accomplish;
        
        $return['responseMessage']['messageType'] = 'success';
        $return['responseMessage']['errorType'] = '0';
        $return['responseMessage']['errorMessage'] = '';
        
//         echo '<pre>';
//         var_Dump($return);
        print_r(json_encode($return));
        exit();
        
        //公用--区域--结束
    }
    
    //-------------------------------------------------------------
    
    /**
     * 统计合计收益
     */
    public function profit(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        // 检验参数
        $this->_check_prams($prams, array('type'));
        
        $limit = $page['perPage']; // 每页记录数
        $offset = ($page['currPage']-1)*$limit; // 偏移量
        $type =$prams["type"];//识别日期
        
        $customer_id = $this->session->userdata("user_id");//用户id
        
        //获取时间区间
        $this->load->helper("time");
        $time = GetTime($type);
        
        
        $return["data"]["list"] = $this->Order_rebate_mdl->profit($customer_id,$limit,$offset,$time["start_at"],$time["ent_at"]);//收益合计(我的下线给我的收入)
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        echo json_encode($return);
    }
    
    //-------------------------------------------------------------
    
    

    /**
     * 下线排行榜
     */
    public function sd_ranking_list()
    { 
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $time_type = $prams['type'];
        
        //分页参数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $this->load->helper ('time');
        $time = GetTime( $time_type ); //array();
        
        //列表
        $list = $this->Customer_mdl->sd_ranking_list( $time,$perPage,$offset );
        $user_info = $this->Customer_mdl->sd_ranking_list( $time,null,null,$this->customer_id ); //数据库
        
        if( !$user_info )
        {
            $user_info = array(
                'ranking' => '无',
                'id' => $this->customer_id,
                'name' => $this->name,
                'nick_name' => $this->nick_name,
                'wechat_nickname'=>$this->wechat_nickname,
                'one_level' => 0,
                'two_level' => 0,
                'total' => 0
            );
        }
        
        $return['data']['list'] = $list;
        $return['data']['my_ranking'] = $user_info;
        $return['responseMessage']['messageType'] = 'success';
        $return['responseMessage']['errorType'] = '0';
        $return['responseMessage']['errorMessage'] = '';
//         echo $this->db->last_query();
//         echo '<pre>';
//         var_Dump($return);
        print_r(json_encode($return));
        exit();
    }

    
    /**
     * 收益排行榜
     */
    public function profit_ranking_list()
    { 
        //接收参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        //分页参数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        
        //代表 1上级，2上上级，3自己。
        $customer= array(1,2,3);
        
        
        //根据参数获取时间
        $time_type = $prams['type'];
        $this->load->helper ( 'time' );
        $time = GetTime( $time_type ); //array();
        
        $list = $this->Order_rebate_mdl->profit_ranking_list( $customer, $time, $perPage,$offset );
        $user_info = $this->Order_rebate_mdl->profit_ranking_list( $customer, $time, null,null, $this->customer_id);
        
        if( !$user_info )
        { 
            //本人排名
            $user_info = array(
                'ranking' => '无',
                'customer_id' => $this->customer_id,
                'name' => $this->name,
                'nick_name' => $this->nick_name,
                'rebate' => 0,
                'wechat_nickname' => $this->wechat_nickname
            );
            
        }
        
        $return['data']['list'] = $list;
        $return['data']['my_ranking'] = $user_info;
        $return['responseMessage']['messageType'] = 'success';
        $return['responseMessage']['errorType'] = '0';
        $return['responseMessage']['errorMessage'] = '';
       
//         echo $this->db->last_query();
        
        print_r(json_encode($return));
        exit();
        
    }
    
    //----------------------------------------------------------------
    
    /**
     * 收入统计
     */
    public function income(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        // 检验参数
        $this->_check_prams($prams, array('type'));
        
        $limit = $page['perPage']; // 每页记录数
        $offset = ($page['currPage']-1)*$limit; // 偏移量
        $type =$prams["type"];//识别日期
        
        $customer_id = $this->session->userdata("user_id");//用户id
        
        //获取时间区间
        $this->load->helper("time");
        $time = GetTime($type);
        
        //根据时间段查询收入列表
        $return["data"]["list"] = $this->Order_rebate_mdl->income($customer_id,$limit,$offset,$time["start_at"],$time["ent_at"]);
        //根据时间段查询总收入
        if($total = $this->customer_shop_mdl->my_income($customer_id,$time["start_at"],$time["ent_at"])["total"]){}else{
            $total = '0.00';
        }
        $return["data"]["total"] = $total;

        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        print_r(json_encode($return));

    }
    
}