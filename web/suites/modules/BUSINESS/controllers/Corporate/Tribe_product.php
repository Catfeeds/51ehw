<?php 
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @author feng
 *
 */
class Tribe_product extends Front_Controller
{
    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct ();
        // 判断用户是否登录
        if (! $this->session->userdata ( 'user_in' )) {
            redirect ( 'customer/login' );
            exit ();
        }
        $this->load->model("Product_tribe_mdl");
    }

    // ----------------------------------------------------------------------------------
    
    /**
     * 部落产品
     * @param string $keywork 搜索关键词
     * @param int $status 状态：0全部1销售中2待发布3已经售罄
     */
    public function index($keywork=null,$status=0){
        $keywork = urldecode($keywork);
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/tribe_product,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        $corporation_id = $this->session->userdata("corporation_id");
        //员工则使用店主id，店主则使用自身id
        if($corp_user){
            $customer_id = $this->session->userdata("user_id");
        }else{
           $customer_id = $this->session->userdata("corp_customer_id");
        }
        

        $this->load->model("tribe_mdl");
        $this->load->model("product_mdl");
        
        
        //加入的部落
        $data["mytribe"] = $this->tribe_mdl->MyTribe($customer_id);
        if(!$data["mytribe"]){
            echo "<script>alert('对不起，您还没加入过任何部落！');history.back(-1);</script>";exit;
        }
        $tribeids = array_column($data["mytribe"],"id");

        // 分页设置(网页版使用)
        $limit = 10;
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        if (0 == $current_page || !is_numeric($current_page)) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $limit;
        $data['product'] = $this->Product_tribe_mdl->get_list($corporation_id,$tribeids,$limit,$offset,null,$keywork,$status);//查询部落产品
        $this->load->library ( 'pagination' );
        $config['uri_segment'] = 5;
        if($status){
            $config['base_url'] = site_url('Corporate/tribe_product/index/'.$keywork.'/'.$status.'／?');
        }else{
            $config['base_url'] = site_url('Corporate/tribe_product/index/'.$keywork.'/?');
        }
        $config['curr_page'] = $current_page;
        $config['suffix'] = "";
        $config['total_rows'] = count($this->Product_tribe_mdl->get_list($corporation_id,$tribeids,null,null,null,$keywork,$status));
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 10;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['start'] =  $offset+1;
        $data['end'] =  ($offset+$limit<$config['total_rows'])?$offset+$limit:$config['total_rows'];
        $data['totalcount'] = $config['total_rows'];
        
        //部落产品统计
        $data['sales'] = 0;//销售中
        $data['wait'] = 0;//待发布
        $data['out'] = 0;//售罄
        $product_all = $this->Product_tribe_mdl->get_list($corporation_id,$tribeids,10);
        foreach($product_all as $v){
            if($v["is_on_sale"] == 1){
                $data['sales'] += 1;
            }
            
            if(in_array($v["is_on_sale"],array(0,3))){
                $data['wait'] += 1;
            }
            
            if($v["stock"] == 0 && $v["is_on_sale"] == 1){
                $data['out'] = 1;
            }

        }
        $data['all'] = count($product_all);//全部
        
        
        //商品管理拦统计
        $data['all_count'] = $this->product_mdl->getgoodsList($corporation_id,0,0);//全部
        $data['not'] = $this->product_mdl->getgoodsList($corporation_id,0,0,'not');//已售罄
        $data['notsale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"notsale");//待发布
        $data['sale'] = $this->product_mdl->getgoodsList($corporation_id,0,0,"sale");//销售中
        $data['types'] = "tribe_discount";//导航栏样式
        
        
        $data['status'] = $status;//状态
        $data['keywork'] = $keywork;//关键词
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/tribal_goods/tribal_goods', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);

    }
    
    // ----------------------------------------------------------------------------------
    
    /**
     * ajax修改优惠部落
     */
    public function Modify_tribal_goods(){
        $productid = $this->input->post("productid");//产品id(数组)
        $tribeid = $this->input->post("tribeid");//部落id(数组)
        
        if(!is_array($productid) && !is_array($tribeid) ){
            echo json_encode(array('status'=>1,'errormessage'=>'参数错误'));exit;
        }
        
        $corporation_id = $this->session->userdata("corporation_id");
        $customer_id = $this->session->userdata("user_id");
        
        $this->load->model("tribe_mdl");
        
        //验证部落
        $tribeid = array_unique($tribeid);//去处重复数据
        $mytribe = $this->tribe_mdl->MyTribe($customer_id);//加入的部落
        $tribeids = array_column($mytribe,"id");
        foreach ($tribeid as $v){
            if(!in_array($v,$tribeids)){
                echo json_encode(array('status'=>2,'errormessage'=>'并未加入id:'.$v.'的部落'));exit;
            }
        }


        //验证商品
        $p_num = $this->Product_tribe_mdl->get_list($corporation_id,$tribeids,null,null,$productid);//查询部落产品
        if(count($p_num) != count($productid)){
            echo json_encode(array('status'=>3,'errormessage'=>'产品不存在'));exit;
        }
        
        $this->db->trans_begin();
        //部落删除部落
        foreach($productid as $product_id){
            $product_tribe = $this->Product_tribe_mdl->get_TribeProduct($product_id);//查询商品所属的部落
            if($product_tribe){
                    foreach ($product_tribe as $k => $v){
                        if(in_array($v["tribe_id"],$tribeid)){
                            $tribeid = array_flip($tribeid);
                            unset($tribeid[$v["tribe_id"]]);
                            $tribeid = array_flip($tribeid);
                        }else{
                            $result = $this->Product_tribe_mdl->del($product_id,$v["tribe_id"]);
                            if(!$result){
                                $this->db->trans_rollback();
                                echo json_encode(array('status'=>1,'errormessage'=>'删除部落失败'));exit;
                            }
                        }
                    }

            }
            
            //添加部落
            if($tribeid){
                $tribeid = array_unique($tribeid);//去处重复数据
                sort($tribeid);
                foreach ($tribeid as $v){
                    if(in_array($v,$tribeids)){
                        $data = array(
                            'product_id'=>$product_id,
                            'tribe_id'=>$v,
                        );
                        $result = $this->Product_tribe_mdl->add($data);//商品创建部落信息
                        if(!$result){
                            $this->db->trans_rollback();
                            echo json_encode(array('status'=>1,'errormessage'=>'商品创建部落信息失败'));exit;
                        }
                    }
                }
            }
        }
        $this->db->trans_commit();
        echo json_encode(array('status'=>5,'errormessage'=>'success'));exit;//成功

    }

}