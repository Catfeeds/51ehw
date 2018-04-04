<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Corporation extends Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_corporation_mdl');
    }

    public function index()
    {
        echo 'corporation API';
    }
    /**
     * 根据corporation id获取企业基本信息
     */
    public function getSimpleinfoById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'corporation_id'
        ));
        
        $this->load->model('goods_mdl');
        $this->load->model('resource_mdl');
        $user_id = $this->session->userdata("user_id");
        $corporation_id = $prams['corporation_id'];

        // 店铺基本信息
        $corporation = $this->customer_corporation_mdl->getById($corporation_id);
        // 企业信息校检
        if(isset($corporation['id'])){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '企业信息不存在'
            );
            print_r(json_encode($return));
        } 
        
        // 累计销售金额 - 供应等级
        $corp_amount = $this->customer_corporation_mdl->corp_amount($corporation_id);
        $return['data']['corp_amount'] = $this->corporationAmount($corp_amount['total_price'],1);
        // 近一个月销售额 － 交易勋章
        $month_amount = $this->customer_corporation_mdl->corp_amount($corporation_id, 'month');
        $return['data']['month_amount'] = $this->corporationAmount($month_amount['total_price'],2);
        // grade － 企业等级
        $return['data']['corporationGrade'] = $this->corporationGrade($corporation['grade']);
        // 会员背书
        $return['data']['recommend'] = "";
        $recommend = $this->resource_mdl->log($corporation_id, 3);
        if(count($recommend)>0){
            foreach ($recommend as $k => $v){
                $return['data']['recommend'][$k]['id']= $v['id'];
                $return['data']['recommend'][$k]['logo']= $v['logo'];
            }
        }else{
            $return['data']['recommend']= array(
            );
        }
        
        
        if($user_id == null || $user_id == ""){
            $return['data']['is_favourites'] = false;
        }else{
            $_check = $this->goods_mdl->check($user_id,$corporation_id);
            if(isset($_check['id'])){
                $return['data']['is_favourites'] = true;
            }else{
                $return['data']['is_favourites'] = false;
            }
        }
        
        $return['data']['corporation'] = $corporation;
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取店铺收藏列表
     */
    public function getfavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        $user_id = $this->session->userdata("user_id");
        
        // 检查登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }

        $this->load->model("favourites_mdl");
        
        // 获取总记录数
        $totalcount = $this->favourites_mdl->count_corporation_Favourites($user_id);
        $perPage = isset($page['perPage']) ? $page['perPage'] : 20; // 每页记录数
        $currPage = isset($page['currPage']) ? $page['currPage'] : 1; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数

        $listdate = $this->favourites_mdl->fav_corp_list($user_id,$perPage,$offset);

        // grade － 企业等级
        foreach ($listdate as $k => $v){
            $listdate[$k]['corporationGrade'] = $this->corporationGrade($v['grade']);
        }
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;

        print_r(json_encode($return));
    }
    
    /**
     * 收藏店铺
     */
    public function addfavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'corporation_id'
        ));

        $this->load->model('goods_mdl');
        $corporation_id = $prams['corporation_id'];
        $user_id = $this->session->userdata("user_id");
        
        // 检查登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $_check = $this->goods_mdl->check($user_id,$corporation_id);
        if($_check){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '该店铺您已经收藏了'
            );
            print_r(json_encode($return));
            exit;
        }
        
        $res = $this->goods_mdl->add_corporation($user_id,$corporation_id);
        if($res){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '网络错误，操作失败'
            );
        }
        print_r(json_encode($return));
    }
    
    /**
     * 取消收藏
     */
    public function deletefavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
//         $this->_check_prams($prams, array(
//             'ids'
//         ));

        $ids = isset($prams['ids'])?$prams['ids']:"";
        $fav_id = isset($ids)?explode(",", $ids):"";
        $corporation_id  = isset($prams['corporation_id'])?$prams['corporation_id']:"";
        // 检验参数
        if(empty($ids) && empty($corporation_id)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '却少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $user_id = $this->session->userdata("user_id");
        
        // 检查登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->load->model("favourites_mdl");
        
        if($corporation_id){
            $res = $this->favourites_mdl->del_fav_corp_id($corporation_id);
        }else{
            $res = $this->favourites_mdl->del_fav_corp($fav_id);
        }

        if($res){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '网络错误，操作失败'
            );
        }
        print_r(json_encode($return));
    }
    
    
    /**
     * 获取企业供应等级（1）、交易勋章（2）
     * @param number $amount
     * @param number $type
     */
    private function corporationAmount($amount = 0,$type = 1)
    {
        $result = array();
        if($type == 1){
            if($amount<500){
                $img_url = "images/huan1.png";
                $img_amount = 1;
            }else if($amount >=500 && $amount<5000){
                $img_url = "images/huan1.png";
                $img_amount = 2;
            }else if($amount >=5000 && $amount<20000){
                $img_url = "images/huan1.png";
                $img_amount = 3;
            }else if($amount >=20000 && $amount<50000){
                $img_url = "images/huan1.png";
                $img_amount = 4;
            }else if($amount >=50000 && $amount<100000){
                $img_url = "images/huan1.png";
                $img_amount = 5;
            }else if($amount >=100000 && $amount<200000){
                $img_url = "images/zhuan.png";
                $img_amount = 1;
            }else if($amount >=200000 && $amount<500000){
                $img_url = "images/zhuan.png";
                $img_amount = 2;
            }else if($amount >=500000 && $amount<1200000){
                $img_url = "images/zhuan.png";
                $img_amount = 3;
            }else if($amount >=1200000 && $amount<3000000){
                $img_url = "images/zhuan.png";
                $img_amount = 4;
            }else if($amount >=3000000 && $amount<8000000){
                $img_url = "images/zhuan.png";
                $img_amount = 5;
            }else if($amount >=8000000 && $amount<20000000){
                $img_url = "images/huan.png";
                $img_amount = 1;
            }else if($amount >=20000000 && $amount<50000000){
                $img_url = "images/huan.png";
                $img_amount = 2;
            }else if($amount >=50000000 && $amount<150000000){
                $img_url = "images/huan.png";
                $img_amount = 3;
            }else if($amount >=150000000 && $amount<500000000){
                $img_url = "images/huan.png";
                $img_amount = 4;
            }else if($amount>500000000){
                $img_url = "images/huan.png";
                $img_amount = 5;
            }
        }else{
            $img_url = "images/xuz.png";
            if($amount<10000){
                $img_amount = 1;
            }else if($amount >=10000 && $amount<50000){
                $img_amount = 2;
            }else if($amount >=50000 && $amount<200000){
                $img_amount = 3;
            }else if($amount >=200000 && $amount<500000){
                $img_amount = 4;
            }else if($amount >=500000 ){
                $img_amount = 5;
            }
        }
        $result["img_url"] = $img_url;
        $result["img_amount"] = $img_amount;
        return $result;
    }
    
    /**
     * 企业等级
     * @param number $grade
     */
    private function corporationGrade($grade = 1)
    {
        switch ($grade){
            case 1 :
                $result = '易货店会员';
                break;
            case 2 :
                $result = '旗舰店会员';
                break;
            case 3 :
                $result = '专卖店会员';
                break;
            default:
                $result = '易货店会员';
                break;
        }
        return $result;
    }
    
    /**
     * 获取企业背书列表
     */
    public function getRecommendLists(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'corporation_id'
        ));
        $corporation_id = $prams['corporation_id'];
        // 企业ID
        $corporation = $this->customer_corporation_mdl->getById($corporation_id);
    
        // 企业信息校检
        if(isset($corporation['id'])){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '企业信息不存在'
            );
            print_r(json_encode($return));
            exit;
        }
        // 会员背书
        $this->load->model('resource_mdl');
        $recommend = $this->resource_mdl->log($corporation_id, 3);
        foreach ($recommend as $k => $v){
            $return['data'][$k]['id'] = $v['id'];
            $return['data'][$k]['recommend_company'] = $v['recommend_company'];
            $return['data'][$k]['logo'] = $v['logo'];
        }
        print_r(json_encode($return));
    }
    /**
     * 获取企业背书详情
     */
    public function getRecommenddetail(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'resource_id',
            'corporation_id'
        ));
        $this->load->model('resource_mdl');
    
        $resource_id = $prams['resource_id'];
        $corporation_id = $prams['corporation_id'];
    
        $return['data']=$this->resource_mdl->log($corporation_id,null,null,$resource_id);
        if($return['data']){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
    
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '背书信息不存在'
            );
            print_r(json_encode($return));
            exit;
        }
        print_r(json_encode($return));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */