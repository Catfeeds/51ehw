<style type="text/css">
	.container {background: #F6F6F6;}
</style>



<!-- 我的 -->
<div class="mylist">
	<!-- 我的展示 -->
	<div class="mylist_head"><span>我的展示</span></div>
    <!-- 列表 -->
    <div class="mylist_list">
    	<ul>
    	    <li>
    	     <a href="<?php echo site_url("Tribe_social/Customer_Info/$customer_id?tribe_id=$tribe_id"); ?>">
    	     	<span class="icon-jieshao mylist_jieshao"></span>
    	     	<em>我的介绍</em>
    	     </a>
    	    </li>
    	    <li>
    	     <a href="<?php echo site_url("Tribe_social/Customer_Album") . '/' . $customer_id.'/'.$tribe_id; ?>">
    	     	<span class="icon-geren1 mylist_geren"></span>
    	     	<em>个人形象</em>
    	     </a>
    	    </li>
    	    <li>
    	     <a href="<?php echo site_url("Corporation_style/User_Topic/$customer_id"); ?>">
    	     	<span class="icon-qiye mylist_qiye"></span>
    	     	<em>企业形象</em>
    	     </a>
    	    </li>
    	</ul>
    </div>	

    <!-- 我的简易店 -->
    <div class="mylist_head"><span>我的简易店</span></div>
    <!-- 列表 -->
    <div class="mylist_list">
    	<ul>
    	    <li>
    	     <a href="<?php if(!$customer["idcard"] || !$shop){echo "javascript:mylist_ball_show();";}else{echo site_url("easyshop/product/personal_list?tribe_id=$tribe_id");};?>">
    	     	<span class="icon-shangpin1 mylist_shangpin"></span>
    	     	<em>我的商品</em>
    	     	<i><?php echo $producttotal;?></i>
    	     </a>
    	    </li>
    	    <li>
    	     <a href="<?php if(!$customer["idcard"] || !$shop){echo "javascript:mylist_ball_show();";}else{echo site_url('easyshop/order/order_list').'/'.$tribe_id.'/is_sell';};?>">
    	     	<div>
    	     	   <span class="icon-mai mylist_ma"></span>
    	     	   <?php if($orderstatus){?>
	     	   		<dd><?php echo $orderstatus;?></dd>
    	     	   <?php };?>
    	     	</div>
    	     	<em>我的订单（卖）</em>
    	     	<i><?php echo $OrderTotal;?></i>
    	     </a>
    	    </li>
    	    <li>
    	     <a href="<?php echo site_url('easyshop/order/order_list').'/'.$tribe_id?>">
    	     	<div>
    	     	  <span class="icon-mai1 mylist_mai"></span>
    	     	   <?php if($Buyersstatus){?>
	     	   		<dd><?php echo $Buyersstatus;?></dd>
    	     	   <?php };?>
    	     	</div>
    	     	<em>我的订单（买）</em>
    	     	<i><?php echo $BuyersTotal;?></i>
    	     </a>
    	    </li>
    	</ul>
    </div>	

    <!-- 设置 -->
    <div class="mylist_head"><span>设置</span></div>
    <!-- 列表 -->
    <div class="mylist_list">
    	<ul>
    	    <li>
    	     <a href="<?php echo site_url("Member/address");?>">
    	     	<span class="icon-dizhi mylist_dizhi"></span>
    	     	<em>收货地址</em>
    	     </a>
    	    </li>
    	</ul>
    </div>	

    <!-- 弹窗 -->
    <?php if(!$customer["idcard"]){;?>
    <div class="mylist_ball" hidden>
      <div class="mylist_ball_box">
         <img onclick="mylist_ball_close();" src="images/51h5-lose.png" alt="" class="mylist_ball_close">
         <div class="mylist_ball_text"><span>您尚未完成实名认证，无权限使用该功能</span></div>
         <a href="<?php echo site_url("Member/info/AuthenticationView");?>" class="mylist_ball_yes">马上认证</a>
         <a href="javascript:void(0);" onclick="mylist_ball_close();" class="mylist_ball_no">还不想认证</a>
      </div>
    </div> 
    <?php }else if(!$shop){;?>
    <div class="mylist_ball">
      <div class="mylist_ball_box">
         <img onclick="mylist_ball_close();" src="images/51h5-lose.png" alt="" class="mylist_ball_close">
         <div class="mylist_ball_text"><span>您的简易店尚未开通，是否马上激活使用</span></div>
         <a href="javascript:void(0);" onclick="ajax_CreateShop();"class="mylist_ball_yes">马上激活</a>
         <a href="javascript:void(0);" onclick="mylist_ball_close();" class="mylist_ball_no">还不想激活</a>
      </div>
    </div> 
    <?php };?>
</div>



<script type="text/javascript">
	//关闭弹窗
	function mylist_ball_close(){
		$('.mylist_ball').hide();
	}

	//关闭弹窗
	function mylist_ball_show(){
		$('.mylist_ball').show();
	}

	//AJAX创建简易店
	function ajax_CreateShop(){
		$.post("<?php echo site_url("easyshop/shop/ajax_CreateShop");?>",function(data){
			location.reload();return;
			if(data["status"] == "00"){
				mylist_ball_close();
				alert("激活成功");
			}else{
				location.reload();
			}
		},"json");
	}
</script>










