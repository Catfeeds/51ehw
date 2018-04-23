<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 9999;">51易货网</span>
<div class="container" hidden>
	<div class="purchase-finish-picture">
		<img src="images/purchase-finish.png" height="100" width="100" alt="">
	</div>
	<span class="purchase-finish-text">您已成功购买<span id="amount"></span>提货权
	</span>
	<div class="purchase-finish_button">
		<button
			onclick="window.location = '<?php echo site_url('customer/fortune')?>'">完成</button>
	</div>
</div>

<div id='cz'>
	<div class="purchaase">
		<ul>
			<li>购买方式：<span>现金余额</span></li>
			<li>购买数量：
				<input style='width: 200px;' type="text" name="m_credit" placeholder="可使用现金余额￥<?php echo isset($pay_detailed['cash']) ? $pay_detailed['cash'] : '0.00'?>"
				class="purchaase_input" onkeyup="value=value.replace(/[^\-?\d.]/g,'')" value="">
			</li>
		</ul>
	</div>
	<span class="purchaase_text">购买数量限额大于0，小于等于50000</span>
	
    <div class="purchaase_button">
    	<button type="button" onclick="checkSubmit()" class="custom_border">确定</button>
    </div>
    
</div>
	



<script>

function checkSubmit()
{	
	var show_bullet_id = "<?php echo $bullet_set == 1?"skip_bullet":"pay_bullet";?>";
	var cash = '<?php echo isset($pay_detailed['cash']) ? $pay_detailed['cash'] :'0.00'; ?>';
	var m_credit = $('input[name=m_credit]').val();
	var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
	
    if(m_credit == "" || !m_credit.match(str)){
		// 金额格式不正确
		$(".black_feds").text("请输入正确的充值金额").show();
    	setTimeout("prompt();", 3000);
	}else if(m_credit <= 0){
		// 购买低于限制
		$(".black_feds").text("购买数量不能小于等于0").show();
    	setTimeout("prompt();", 3000);
	}else if( m_credit > 50000){
		// 购买超出限制
		$(".black_feds").text("购买数量不能大于50000").show();
    	setTimeout("prompt();", 3000);
	}else if("<?php echo count($pay_detailed)?>" == 0){
		// 未有pay帐号
		$(".black_feds").text("未开通支付账号").show();
    	setTimeout("prompt();", 3000);
	}else if( show_bullet_id == "skip_bullet" ){
		// 未设置密码
        $("#"+show_bullet_id).show();
        $(".color-bg").show();
	}else if( m_credit > parseFloat(cash) ){
		// 现金金额不足
		message('现金余额不足','去充值',"location.href = '<?php echo site_url('charge/incharge')?>'");
    }else{
		// 支付框显示
        $('#order_sn_text').hide();
        $('#order_money_text').hide();
        $('#pay_').attr('onclick','ajax_submit()');
        $("#"+show_bullet_id).show();
        $(".color-bg").show();
    }
}

function ajax_submit(){ 
	
	var m_credit = $('input[name=m_credit]').val();
	var pass = $('input[name=pay_passwd]').val();
	$(".black_feds").text("正在充值，请稍候...").show();

	$.ajax({
	    url:"<?php echo site_url('charge/purchase_M')?>",
	    type:"post",
	    dataType:'json',
	    data:{m_credit:m_credit,pass:pass},
	    beforeSend:function(){     
	    	$("#pay_").css('background-color','#ccc');
	    	$("#pay_").text('支付中....');
	    	$("#pay_").attr('onclick','');
	    },
	    success:function(data){
	    	if(data){
				$(".black_feds").hide();
				show_prompt();
				$("#pay_").attr('onclick','checkSubmit()');
	            switch(data){
	            case 1:
	            	$('.container').show();
	            	$('#cz').hide();
	            	$('#amount').text(m_credit);

	                $(".color-bg").hide();
	                $("#pay_bullet").hide();
	                break;
	            case 2:
	           	    message('现金余额不足','去充值',"location.href = '<?php echo site_url('charge/incharge')?>'");
	                $("#pay_bullet").hide();
	                break;
	            case 3:
	        		$(".black_feds").text("未开通支付账号").show();
	            	setTimeout("prompt();", 3000);
	            	break;
	            case 4:
	            	
	        		$(".black_feds").text("密码错误，请重新输入").show();
	            	setTimeout("prompt();", 3000);
	            	break;
	            }
	        }else{ 
	    		$(".black_feds").text("充值失败请稍后再试").show();
	        	setTimeout("prompt();", 3000);
	        }    
	    },
	    error:function(){
	    	$(".black_feds").text("充值失败请稍后再试").show();
        	setTimeout("prompt();", 3000);
        	show_prompt();
			$("#pay_").attr('onclick','checkSubmit()');
	    },
	});

}

function message(text, buttom_text, url){
	$(".color-bg").show();
	$("#just_sure").show();
	$("#sure_test").text(text)
	$("#sure_submit").text(buttom_text);
	$("#sure_submit").attr('onclick',url);
}

</script>