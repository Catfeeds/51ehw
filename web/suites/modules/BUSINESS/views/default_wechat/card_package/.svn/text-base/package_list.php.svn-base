
<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>

<div class="commodity_h50"></div>
<div class="commodity_record">
	<ul>
	   <?php if($package){;?>
	   <?php foreach ($package as $v){;?>
	    <li class="commodity_detail-list">
	       <a href="javascript:void(0);"> <?php //echo  site_url("corporate/card_package/details/".$v['id']);?>
	       	<div>
		      <img src="<?php echo IMAGE_URL.$v["coupon_image"];?>" alt="" onerror="this.src='images/discount_error.png'">
	       </div>
	       <div class="clicent_commodity_record_list">
              <a href="javascript:void(0);" onclick="receive(this,'<?php echo $v["id"];?>');" class="client_commodity_record_send custom_button">立即领取</a>
	       </div>
	       </a>
	    </li>
	    <?php };?>
	    <?php }else{;?>
	    <div class="client_commodity_block_not">
            	<span class="icon-kong client_block_icon"></span>
            	<span class="client_block_not_text">暂无可领取优惠券</span>
         </div>
	    <?php };?>
	</ul>
</div>	
<script>
//领取卡包
function receive(obj,id){
	if(!id){
		window.location.reload();
		return ;
		}
	$.post("<?php echo site_url("corporate/card_package/gain_package");?>",{id:id},function(data){
		   switch(data["status"]){
		       case 1:
			       window.location.reload();
			       break;
		       case 2:
		    	   alert("已经被抢光！");
		    	   window.location.reload();
			       break;
		       case 3:
		    	   $(obj).removeAttr("onclick").text("已领取");
			       break;
		       case 4:
		    	   alert("领取失败！");
		    	   window.location.reload();
			       break;
		       case 5:
		    	   alert("领取时间还没到！");
		    	   window.location.reload();
			       break;
		       case 6:
		    	   alert("领取时间结束！");
		    	   window.location.reload();
			       break;
		       case 7:
		    	   $(obj).removeAttr("onclick").text("已领取");
			       break;
		   }
		},"json");
}

</script>

