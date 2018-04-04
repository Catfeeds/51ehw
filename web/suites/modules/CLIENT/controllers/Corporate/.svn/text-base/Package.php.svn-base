<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Package extends Front_Controller {
	
	// --------------------------------------------------------------------
	
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
		$this->load->model("cart_package_mdl");
	}
	
	/**
	 * 修改添加or修改货包页面
	 */
	public function add_view($id=0) {
	    if($id){
	       $data = $this->cart_package_mdl->get_package($id);
	    }
	    $data ['head_set'] = 4;
	    $data ['title'] = $id?"修改货包":"添加货包";
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
// 		$this->load->view ( 'corporate/order/list', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	/**
	 * 添加or修改
	 */
	public function add() {
	    $id = $this->input->post("id");
	    $id = 1;
	    if(!$id){
    	    //生成流水号
    	    $this->load->helper('order');
    	    $exist = false;
    	    do {
    	        $package_sn = get_order_sn ();
    	        $exist = $this->cart_package_mdl->get_package_sn($package_sn);//查询流水号
    	    } while ( $exist ); // 如果是订单号重复则重新提交数据
    	    $this->cart_package_mdl->package_sn = $package_sn;
	    }
	    
        $this->cart_package_mdl->name = $this->input->post("name");
        $specified_type = $this->cart_package_mdl->specified_type = $this->input->post("specified_type");//类型：1商品2品类
        $discount_type = $this->cart_package_mdl->discount_type = $this->input->post("discount_type");//优惠方式：1折扣2满减
        switch($discount_type){
            case "1":
                $this->cart_package_mdl->discount = $this->input->post("discount");//折扣
                break;
            case "2":
                $this->cart_package_mdl->overtop_price = $this->input->post("overtop_price");//金额要求
                $this->cart_package_mdl->deduction_price = $this->input->post("deduction_price");//优惠金额
                break;
        }
        $this->cart_package_mdl->number = $this->input->post("number");//发放数量
        $this->cart_package_mdl->grant_start_at = $this->input->post("grant_start_at");//发放开始日期
        $this->cart_package_mdl->grant_end_at = $this->input->post("grant_end_at");//发放过期日期
        $this->cart_package_mdl->coupon_start_at = $this->input->post("coupon_start_at");//优惠有效日期
        $this->cart_package_mdl->coupon_end_at = $this->input->post("coupon_end_at");//优惠过期日期
        $this->cart_package_mdl->describe = $this->input->post("describe");//说明
        $this->cart_package_mdl->coupon_image = $this->input->post("coupon_image");//优惠卷图片
        $this->cart_package_mdl->ad_image = $this->input->post("ad_image");//广告图
        $this->cart_package_mdl->donation = $this->input->post("donation");//转赠：1可以2不可以
        
        

        //开启事务
        $this->db->trans_begin();
        if($id){//更新
            $row1 = $this->cart_package_mdl->save($id);
            $row2 = $this->cart_package_mdl->del($id);

            if($row1 && $row2){
                $package_id = $id;
            }
        }else{//添加
            $package_id = $this->cart_package_mdl->add();
        }

        $i = 0;
        $sid = $this->input->post("sid");
        $sid = "1,2,3";
        if($sid && !empty($package_id)){//添加货包关联信息
            $sid = explode(",",trim($sid,","));
            foreach ($sid as $v){
                $array["package_id"] = $package_id;
                switch($specified_type){
                    case "1":
                        $array["product_id"] = $v;
                        break;
                    case "2":
                        $array["cate_id"] = $v;
                        break;
                    default:
                        echo "错误";exit;
                        echo '<script>history.back(-1);alert("数据错误");</script>';return;
                        break;
                }
                $data[$i++] = $array;
            }


            $row = $this->cart_package_mdl->increase($data);

            if($row){
                $this->db->trans_commit();//提交
            }else{
                $this->db->trans_rollback();//回滚
                echo "失败1";exit;
            }
            
        }else{
            $this->db->trans_rollback();//回滚
            echo "失败2";exit;
        }
	}
	

}