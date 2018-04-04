<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include_once 'Common/Uri.php';
class Cart extends Front_Controller {
	
	/**
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->library ( 'cart' );
		$this->load->model("cart_mdl");
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 购物车
	 */
	public function index()
	{        
	    $customer_id = $this->session->userdata("user_id");//用户id
	    $time = date("Y-m-d H:i:s");
	    
	    $this->load->model("goods_mdl");
	    $this->load->model("tribe_mdl");
	    
	    //更新购物车
	    $cart = $this->cart->contents();
	    if($cart){
    	    $i = 0;
    	    $item = array();//购物车数组集合
    	    foreach ($cart as $v){
    	        $item[$i]["product_id"] = $v["product_id"];
    	        $item[$i]["sku_id"] = $v["sku_id"];
    	        $i++;
    	    }
    	    //获取购物车商品信息
    	    $product  = $this->goods_mdl->getShoppingCart($item);//购物车商品

    	    $ci_cart = array();//更新购物车数组->session
    	    foreach ($cart as $key => $val){
    	        $is_exist = false;//识别商品是否存在
                foreach ($product as $v){
                    //匹配商品
                    if($val["product_id"] == $v["id"] && $val["sku_id"] == $v["sku_id"]){
                        $tribeVIP = false;//默认不是部落会员
                        //判断是否登录。如果登录则查询此商品是否我的部落
                        if($customer_id){
                            //如果是预览则使用企业用户
                            $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落
                            if($MyTribe){
                                $MyTribe_id = array_column($MyTribe,"id");
                                $tribeVIP = $this->tribe_mdl->Whether_my_tribe($v["id"],$MyTribe_id);//查询商品是否属于我的部落
                            }
                        }
                        
                        if($v["is_special_price"] == 1 && $v['special_price_start_at'] <= $time && $v['special_price_end_at'] >= $time){//特价价格
                            $price = $v["special_price"];
                        }else if($tribeVIP){//部落价格
                            $price = $v["tribe_price"];
                        }else{//易货价
                            $price = $v["vip_price"];
                        }


                        if($v["is_delete"] != 0 || $v["is_on_sale"] != 1){ //商品是否有效
                            $ci_cart[] = array(
                                        "rowid" => $key,
                                        "status" => 0//状态：0无效1正常2已售罄3商品数量超过库存
                                        );
                        }else if($v["stock"] <= 0){//判断库存
                            $ci_cart[] = array(
                                "rowid" => $key,
                                "status" => 2//状态：0无效1正常2已售罄3商品数量超过库存
                                );
                        }else{//正常
                            $ci_cart[] = array(
                                        "rowid" => $key,
                                        "price" => $price,
                                        "name"  => $v["name"],
                                        "status" => 1,//状态：0无效1正常2已售罄3商品数量超过库存
                                        "stock" => $v["stock"]
                                        );
                        }
                        
                        
                        //更新购物车数据库
                        if($customer_id){
                            $product_id = $v["id"];
                            $sku_id = $v["sku_id"];
                            $data["vip_price"] = $price;
                            $data["product_name"] = $v["name"];
                            $data["img_goods"] = $v["goods_thumb"];
                            $data["quantity"] = $val["qty"];
                            $res = $this->cart_mdl->updateCart($customer_id,$product_id,$sku_id,$data);
                        }
                        
                        $is_exist = true;
                        break(1);
                    }
                }
                
                //判断商品是否存在,不存在则改变session状态
                if(!$is_exist){
                    $ci_cart[] = array(
                                "rowid" => $key,
                                "status" => 0//状态：0无效1正常2已售罄3商品数量超过库存
                                );
                }
    	    }
            //更新ci购物车
            $this->cart->update($ci_cart);

	    }
	    
	    //重新获取session购物车信息
	    //商品店铺归类
	    $product = array();
	    $cart = $this->cart->contents();
	    if($cart){
    	    foreach($cart as $k){
    	        $product[$k['corporation_id']]['corporation_name'] =  $k["corporation_name"];
    	        $product[$k['corporation_id']]['product'][] = $k; 
    	    }
	    }
	    $data["product"] = $product;
        $data['head_set'] = 2;//h5
        $data['title'] = '购物车';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('cart', $data);
        if( empty( $_GET['label_id'] ) )
        {
            $this->load->view('_footer', $data);
            
        }else{ 
            
            //商会进入购物车-foot脚。
            $data['choose_foot'] = 5;
            $data['label_id'] = $_GET['label_id'];
            $data['is_host'] = false;
            $this->load->model('App_label_mdl');
            $status = 'show_app_tribe_ids';
            $app_labe_info = $this->App_label_mdl->Load( $data['label_id'], $status );
             
            //商户脚部导航颜色写进session方便foot文件获取
            if(!empty($app_labe_info['color']))
            {
                $this->session->set_userdata("labe_foot_nav_color",$app_labe_info['color']);
            }
             
            if( $app_labe_info )
            {
                $app_labe_info['app_tribe_ids'] = '';
                
                $tribe_app_label_info = $this->App_label_mdl->Load_tribe_app_label( $data['label_id'] );
                 
                 
                if( $tribe_app_label_info )
                {
                    $app_tribe_id = '';
                     
                    foreach ($tribe_app_label_info as $key =>$val )
                    {
                        $app_tribe_id = trim($app_tribe_id,",");
                        if($val['tribe_ids'])
                        {
                            $app_tribe_id .= ','.$val['tribe_ids'];
                        }
                    }
            
                    if( !empty( $app_labe_info['tribe_id'] ) )
                    {
                        $app_tribe_id .= ','.$app_labe_info['tribe_id'];
                    }
            
                    $ids = $app_tribe_id ? explode(',',$app_tribe_id) : array();//字符串转数组
                    
                    if( $ids )
                    {
                        $app_labe_info['app_tribe_ids'] = array_unique($ids);
                        $app_labe_info['app_tribe_ids_string']  = $app_tribe_id;
                        //是否部落管理员。
                        $data['is_host'] = $this->tribe_mdl->ManagementTribe($customer_id,$app_labe_info['app_tribe_ids']);
                    }
                   
                }
            }
             
           
            $this->load->view('commerce/foot',$data);
            
            
            
        }
        $this->load->view('foot', $data);
    }
	
	
	// --------------------------------------------------------------
	
    
    
//     /**
//      * ajax减购物车
//      */
//     public function ajax_reduce() {
//         $product_id = $this->input->post ( 'pid' );
//         $sku_id = $this->input->post ('sku_id');
//         $customer_id = $this->session->userdata("user_id");//用户id
//         $quantity = $this->input->post("qty");
//         //如果不是数字默认1
//         if(!is_numeric($quantity) || $quantity < 1){
//             $quantity = 1;
//         }
        
//         //减购物车
//         if($customer_id){
//             // 购物车有就更新数量
//             $condition = $this->cart_mdl->load($customer_id, $product_id, $sku_id);
//             if($condition){
//                 $quantity = $condition["quantity"]-1;//数量
//                 if($quantity>0){
//                     $data["quantity"] = $quantity;
//                     $res = $this->cart_mdl->updateCart($customer_id,$product_id,$sku_id,$data);
//                 }else{
//                     echo json_encode(array("status"=>1,"message"=>"商品数量不能少于0"));exit;
//                 }
//             }else{
//                 echo json_encode(array("status"=>1,"message"=>"商品不存在或者已经下架"));exit;
//             }
    
//         }
    
//         $this->ci_updateCart($product_id,$sku_id,$quantity);//更新ci购物车
//         echo json_encode(array("status"=>2,"message"=>"成功"));exit;
    
//     }
    
    // ----------------------------------------------------------------------
    
    /**
     * ajax更新购物车商品数量
     */
    public function ajax_updateCart(){
        $product_id = $this->input->post ('pid' );
        $sku_id = $this->input->post ('sku_id');
        $quantity = $this->input->post("qty");
        $customer_id = $this->session->userdata("user_id");//用户id
        //如果不是数字默认1
        if(!is_numeric($quantity) || $quantity < 1){
            $quantity = 1;
        }

        //减购物车
        if($customer_id){
            // 购物车有就更新数量，没有就添加数据库
            $condition = $this->cart_mdl->load($customer_id, $product_id, $sku_id);
            if($condition){
                if($quantity>0){
                    $data["quantity"] = $quantity;
                    $res = $this->cart_mdl->updateCart($customer_id,$product_id,$sku_id,$data);
                }else{
                    echo json_encode(array("status"=>1,"message"=>"商品数量不能少于0"));exit;
                }
            }else{
                echo json_encode(array("status"=>1,"message"=>"购物车没有此商品"));exit;
            }
            
        }
        
        $this->ci_updateCart($product_id,$sku_id,$quantity);//更新ci购物车
        echo json_encode(array("status"=>2,"message"=>"成功"));exit;
    }
    
    // ----------------------------------------------------------------------
    
    
    //更新ci购物车商品数量
    private function ci_updateCart($product_id,$sku_id,$quantity){
        $cart = $this->cart->contents();
        if($cart){
            foreach($cart as $rowid => $v){
                if($v['product_id'] == $product_id && $v["sku_id"] == $sku_id){
                    $data = array(
                        'rowid'  => $rowid,
                        'qty'    => $quantity
                    );
                    $this->cart->update($data);
                    break(1);
                }
            }
        }
    }
    
    // ----------------------------------------------------------------------
    
	
// 	/**
// 	 *
// 	 * @param number $pid        	
// 	 * @param number $count        	
// 	 */
// 	public function add($pid = 0, $count = 1, $sku_id = 0 ,$type="pc") {
	    
// 	    $this->session->set_userdata('ref_from_url', current_url());
        
//         // 判断用户是否登录
//         if (! $this->session->userdata('user_in')) {
//             redirect('customer/login');
//             exit();
//         }
//         $status = $this->add_goods($pid, $count, $sku_id,$type);
//         //判断是否是h5立即购买
// 	    if($type == 'h5'){
// 	        switch ($status['message']) {
// 	            case 'ok':
// 	                $row_id = $status['rowid'];
// 	                redirect('order?item[]='.$row_id);
// 	                exit();
// 	                break;
// 	            case 'no_goods':
// 	                echo "<script>alert('商品已下架。');location.href='".site_url("home")."';</script>";
// 	                //                 redirect();
// 	                exit();
// 	                break;
// 	            case 'fail':
// 	                echo "<script>alert('添加失败');history.back(-1)</script>";
// 	                exit();
// 	                break;
// 	            default:
// 	                echo "<script>alert('网络出错');location.href='".site_url("home")."';</script>";
// 	                //                 redirect();
// 	                exit();
// 	                break;
// 	        }
// 	    }else{
// 	        switch ($status) {
// 	            case 'ok':
// 	                redirect('cart');
// 	                exit();
// 	                break;
// 	            case 'no_goods':
// 	                echo "<script>alert('商品已下架。');location.href='".site_url("home")."';</script>";
// 	                //                 redirect();
// 	                exit();
// 	                break;
// 	            case 'fail':
// 	                echo "<script>alert('添加失败');history.back(-1)</script>";
// 	                exit();
// 	                break;
// 	            default:
// 	                echo "<script>alert('网络出错');location.href='".site_url("home")."';</script>";
// 	                //                 redirect();
// 	                exit();
// 	                break;
// 	        }
	        
// 	    }
      
//     }
	
	// --------------------------------------------------------------
	
	/**
	 * 更新购物车商品数量
	 */
	function update() {
        $segments = $this->input->get();//$this->uri->uri_to_assoc();
        $rowid = $segments['rowid'];
        $qty = $segments['qty'];
        $cid = $segments['id'];
        $p_id = $segments['p_id'];
        $freight = 0; //运费
        $this->load->model('product_mdl');
        $product_id = substr($segments['p_id'],0,strpos($segments['p_id'],'_') );
        $sku_id = substr($segments['p_id'],strpos($segments['p_id'],'_')+1 );
        
        $product = $this->product_mdl->loadById($product_id);
        
            
        if( $sku_id == 0)
        {    //普通商品库存  -- 查询库存数量 足够=修改库存， 不够=返回最大库存
            $this->load->model('product_mdl');
            $product_info = $this->product_mdl->loadById($product_id);
            
            if($product_info['stock'] < $qty )
            { 
                $qty = $product_info['stock'];
            }
           
        }else{ 
            //操作SKU库存  -- 查询sku库存数量 足够=修改库存， 不够=返回最大库存
            $this->load->model("product_sku_mdl");
            $product_info = $this->product_sku_mdl->getSKUValue($sku_id);
            
            
            if( $product_info ){
                
                if( $product_info['stock'] < $qty )
                    $qty = $product_info['stock'];
            }else{ 
                $qty = 0;
                $result['status'] = 2;
                $cart = $this->session->userdata('cart_contents');
                $cart["$rowid"]['product_status'] = 'no_sale';
                $this->session->set_userdata('cart_contents',$cart);
                echo json_encode($result);
                exit();
            }
        }
        
        //失效商品
        if( $product['is_on_sale'] == 0 || $product['is_delete'] == 1  )
        {
            $result['status'] = 2;
            $cart = $this->session->userdata('cart_contents');
            $cart["$rowid"]['product_status'] = 'no_sale';
            $this->session->set_userdata('cart_contents',$cart);
            echo json_encode($result);
            exit();
        }
        
        
        if( $product ){
            
            //计算运费
            
            if($product['is_freight'] == 1){
                
                $default_freight =  $product['default_freight'];//默认价格 10
                $default_item =  $product['default_item'];//默认数量是多少 1
                $add_item  =  $product['add_item'];//每增加多少件 3
                $add_freight =  $product['add_freight'];//每增加X件+多少钱 10
            
                if($qty > $default_item ){
                    $num = $qty - $default_item;
                    $num_a = $num/$add_item;
                    if(is_int($num_a) ){ //如果是整型
                        $freight = ($num_a*$add_freight)+$default_freight;
                    }else{
            
                        if($num_a < 1){
                            $freight = $default_freight+$add_freight;
                        }else{
                            $num_a = intval($num_a);
                            $freight = ($num_a*$add_freight) + $add_freight+$default_freight;
                        }
                    }
                }else{
                    $freight = $default_freight;
                }
            }
        } 
        $customer_id = $this->session->userdata('user_id');
        if (isset($customer_id) ? $customer_id : 0 !== 0) {
            
            $cart = array(
                'quantity' => $qty,
                'freight' => $freight
            );

            if ($qty != 0) {
                $this->cart_mdl->updateCart($cid, $customer_id, $cart);
            } else {
                $this->cart_mdl->deleteCart($cid, $customer_id);
            }
        }
        
       
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty
        );
        
        $this->cart->update($data);
        
        
        //更新session购物车价格，数量
        if($qty > 0){
            $cart = $this->session->userdata('cart_contents');
            $cart["$rowid"]['freight'] = $freight;
            $cart["$rowid"]['product_status'] = "ok";
            
            $this->session->set_userdata('cart_contents',$cart);
        }
       
//         echo '<pre>';
//         var_dump($freight);
//         exit;
        $result['status'] = 1;
        $result['freight'] = $freight;
        $result['total'] = round($this->cart->total(), 2);
        $result['qty'] = $qty;
        $result['stock'] = $product_info['stock'];
        echo json_encode($result);
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 清空购物车
	 */
	function destroy() {
		$this->cart->destroy ();
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 移入收藏夹
	 */
	public function remove_fav(){
	    $customer_id = $this->session->userdata("user_id");//用户id
	    if(!$customer_id){
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '3',
	            'errorMessage' => '未登录'
	        );
	        echo json_encode($return);exit;
	    }
	    //接口-添加收藏夹
	    $url = PRODUCT_URL.'Api/Fav/add';
	    $post['product_id'] = $this->input->post("product_id");//商品id
	    $post['customer_id'] = $customer_id;
	    $result = json_decode($this->curl_post_result($url,$post),true);
	
	    if($result["responseMessage"]["messageType"] == "success"){
	
	
	        //             $this->ajax_delete();//删除购物车
	
	        $return['responseMessage'] = array(
	            'messageType' => 'success',
	            'errorType' => '5',
	            'errorMessage' => '成功'
	        );
	        echo json_encode($return);exit;
	    }else{
	        $return['responseMessage'] = array(
	            'messageType' => 'error',
	            'errorType' => '6',
	            'errorMessage' => '移除失败'
	        );
	        echo json_encode($return);exit;
	    }
	    //
	}
	
	
	// --------------------------------------------------------------
	
	/**
	 * 异步加入购物车
	 */
	public function ajax_add() {

	    
        $product_id = $this->input->post ( 'pid' );
        $sku_id = $this->input->post ('sku_id');
        $qty = $this->input->post ( 'qty' );
        $type = $this->input->post ( 'type' );//类型1加入购物侧2立即购买
        //如果不是数字默认1
        if(!is_numeric($qty) || $qty < 1){
            $qty = 1;
        }
        $customer_id = $this->session->userdata("user_id");//用户id
        $time = date("Y-m-d H:i:s");
        
        //立即购买，检查登录
        if($type == 2){
            if(!$customer_id){
                $this->session->set_userdata("ref_from_url",site_url("Goods/detail/$product_id"));
                $return = array(
                    'status' => '3',
                    'errorMessage' => '未登录'
                );
                print_r(json_encode($return));
                exit();
            }
        }
        
        $this->load->model("customer_corporation_mdl");
        $this->load->model('goods_mdl');
        $this->load->model('tribe_mdl');
        

        //查询商品信息
        if($product_id && $sku_id){
            $product = $this->goods_mdl->get_id_sku($product_id,$sku_id);
        }else{
            $product = $this->goods_mdl->load($product_id);
        }

        if(!$product){
            $return = array(
                'status' => '1',
                'errorMessage' => '商品不存在或者已经下架'
            );
            print_r(json_encode($return));
            exit();
        }


        // 店铺信息
        $corporation = $this->customer_corporation_mdl->getById($product["corporation_id"]);
        
        //判断是否特价
        if ($product['special_price_start_at'] <=  $time && $product['special_price_end_at'] >= $time && $product['is_special_price']) {
             $price = $product["special_price"];
        } else { // 不是特价执行
            $is_tribeVIP = false;//默认不是部落会员
            if($customer_id){
                //查询商品是否属于我的部落，如果是则使用部落价格。
                $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落
                if($MyTribe){
                    $MyTribe_id = array_column($MyTribe,"id");
                    $is_tribeVIP = $this->tribe_mdl->Whether_my_tribe($product_id,$MyTribe_id);//查询商品是否属于我的部落
                    if($is_tribeVIP){//部落价
                        $price = $product["tribe_price"];
                    }
                }
            }
            
            if(!$is_tribeVIP){//易货价
                $price = $product["vip_price"];
            }
            
        }

        
        //购物车添加数据库
        if($customer_id){
            
            // 购物车有就更新数量，没有就添加数据库
            $condition = $this->cart_mdl->load($customer_id, $product_id, $sku_id);
            if($condition){
                $data["img_goods"] = $product["goods_thumb"];
                $data["stock"] = $product["stock"];
                $data["sku"] = (!empty($product["sku"])?$product["sku"]:"");
                $data["product_name"] = $product['name'];
                $data["vip_price"] = $price;
                $data["quantity"] = $condition["quantity"]+$qty;//数量
                $res = $this->cart_mdl->updateCart($customer_id,$product_id,$sku_id,$data);
            }else{
                $cart = array(
                    'customer_id' => $customer_id,
                    'product_id'=> $product_id,
                    'quantity' => $qty,//购买数量
                    'vip_price' => $price,
                    'product_name' => $product['name'],
                    'sku_id' => $sku_id,
                    'corporation_name'=>$corporation["corporation_name"],
                    'sku' => (!empty($product["sku"])?$product["sku"]:""),
                    'stock' => $product["stock"],
                    'img_goods' => $product["goods_thumb"]
                );
                $res = $this->cart_mdl->add($cart);
            }
           
        }
    
        //保存ci购物车
        $data = array(
            'corporation_id' => $product["corporation_id"],
            'id' => $product_id.'_' .$sku_id,
            'product_id'=> $product_id,
            'qty' => $qty,//购买数量
            'price' => $price,
            'name' => $product['name'],
            'sku_id' => $sku_id,
            'corporation_name'=>$corporation["corporation_name"],
            'status' => 1,//状态：0无效1正常2已售罄3商品数量超过库存
            'stock' => $product["stock"],//商品库存
            'sku' => (!empty($product["sku"])?$product["sku"]:""),
            'options'=>array("goods_img"=>$product["goods_thumb"])
        );
        $rowid = $this->cart->insert($data);

        
        //统计购物车总数
        $cartcount = 0;
        foreach($this->cart->contents() as $items){
            $cartcount = $cartcount + $items['qty'];
        }
        
        $return = array(
            'rowid' => $rowid,
            'cartcount' => $cartcount,
            'status' => '2',
            'errorMessage' => 'success'
        );
        print_r(json_encode($return));exit;
    
    }

	
	// --------------------------------------------------------------
	
	/**
	 * 异步显示购物车
	 */
	public function ajax_showcart() {
		$this->load->view ( 'ajax_cart' );
	}
	
	// --------------------------------------------------------------
	
    /**
     * AJAX删除购物车
     */
    function ajax_delete(){
        $pid = $this->input->post('pid');
        $rowid = $this->input->post('rowid');
        $customer_id = $this->session->userdata('user_id');

        // 删除购物车（数据库）
        if ($customer_id) {
            foreach ($pid as $v) {
                list($product_id,$sku_id) = explode("_",$v);
                $this->cart_mdl->deleteCart($customer_id,$product_id,$sku_id);
            }
        }

        // 删除购物车（session）
        foreach ($rowid as $v) {
            $data = array(
                'rowid' => $v,
                'qty' => 0
            );
            $this->cart->update($data);
        }
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 获取购物车商品总数
	 */
	public function ajax_countcart() {
        $cartcount = 0;
        foreach ($this->cart->contents() as $items) {
            $cartcount = $cartcount + $items['qty'];
        }
        echo $cartcount;
    }
	
	// -------------------------------------------------------------
	
	
	/**
	 * 查询商品库存
	 */
	public function check_stock($status=''){
        $msg = array(
            "stock" => null
        );
        if ($status == 1) {
            $this->load->model("product_mdl");
            $product = $this->product_mdl->load($this->input->get_post("val_id"), $this->session->userdata("app_info")["id"]);
            if ($product != null)
                $msg = array(
                    "stock" => $product['stock']
                );
        } elseif ($status == 2) {
            $this->load->model("product_sku_mdl");
            $sku = $this->product_sku_mdl->getSKUValue($this->input->get_post("val_id"));
            if ($sku != null)
                $msg = array(
                    "stock" => $sku["stock"]
                );
        }
        echo json_encode($msg);
    }
	
	
	/**
	 * 批量删除购物车
	 */
	function deleteSelect(){
        $cid = $this->input->post('cid');
        $rowid = $this->input->post('rowid');
        $qty = 0;
        
        $customer_id = $this->session->userdata('user_id');
        
        // 删除购物车（数据库）
        if (isset($customer_id) ? $customer_id : 0 !== 0 && $cid[0]) {
            foreach ($cid as $v) {
                $cart = array(
                    'quantity' => $qty
                );
                
                $this->cart_mdl->deleteCart($v, $customer_id);
            }
        }
        
        // 删除购物车（session）
        foreach ($rowid as $v) {
            $data = array(
                'rowid' => $v,
                'qty' => $qty
            );
            $this->cart->update($data);
        }
    }
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */