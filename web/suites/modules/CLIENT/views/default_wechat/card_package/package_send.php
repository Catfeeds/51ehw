
<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>

<div class="commodity_detail">
	<div>
		<a href="<?php echo site_url("card_package/commodity/commodity_detail");?>"><img src="<?php echo IMAGE_URL.$package["coupon_image"]?>" alt=""></a>
	</div>	
    <form method="post" action="<?php echo site_url("corporate/card_package/send");?>" onsubmit="return check();">
	<div class="commodity_send_num" >
		<span>货包数量：</span>
		<input type="hidden" name="id" value="<?php echo $package["id"];?>" >
		<input type="text" name="number" value="" onkeyup='this.value=this.value.replace(/\D/gi,"")'>
		<span class="commodity_send_num_right">个</span>
	</div>
    <div class="commodity_detail_send commodity_send_bt">
    	<button style="font-size:17px;">发出货包</button>
    </div>	
    </form>
<div class="commodity_send_text">
	<span>未领取的货包，将于24小时后发起退回</span>
</div>
</div>	
<script>
    function check(){
        var number = $("input[name=number]").val();
        var regular = /^[1-9]\d*$/;
        if(regular.test(number)){
            return true;
        }else{
            alert("请输入正确的货包数量");
            return false;
        }
    }
</script>
