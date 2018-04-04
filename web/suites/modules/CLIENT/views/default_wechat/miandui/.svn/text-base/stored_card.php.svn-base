
<style type="text/css">
	.container {background-color: #fff!important;}
</style>

 
<div class="stored_value" id="pay_code" style="padding-top:0px;">
    <!--<div class="stored_value_div"><a href="javascript:">您即将向</a></div>-->
    <ul class="stored_zhong_ul">
      <li class="stored_zhong_ul_g">
       <a href="javascript:;">
        <div class="stored_zhong_ul_top">
          <span><img src="<?php echo $corp_info['img_url'] ? IMAGE_URL.$corp_info['img_url'] : 'images/no_logo.png'?>" onerror="this.src='images/no_logo.png'" /></span><!-- images/tmp_logo.jpg -->
         <div class="stored_zhong_ul_zhong">
           <h2><?php echo $corp_info['corporation_name']?></h2>
         <!--  <dl class="stored_zhong_dl">
              <dd class="icon-xinshixin"></dd>
              <dd class="icon-xinshixin"></dd>
              <dd class="icon-xinshixin"></dd>
              <dd class="icon-xinshixin"></dd>
              <dd class="icon-shoucang1"></dd>
           </dl>-->
         </div>
       <!-- <div class="stored_zho_div"><i class="icon-back"></i></div>-->
        </div>
       </a>
      </li>
      <li>
       <a href="javascript:;">
        <div class="stored_zhong_ul_top">
          <h2>消费金额:</h2>
         <div class="stored_zhong_ul_zhong">
          <input name="pay_price" oninput="card_message()" onkeyup="if(isNaN(value))execCommand('undo')" placeholder="请输入支付金额" style="width: 100%; border: none; background: none; font-size: 14px;" type="text">
         </div>
         <div class="stored_zhong_ul_wei">货豆</div>
        </div>
       </a>
      </li>
      
        <li>
       <a href="javascript:;" id="choose_card">
        <div class="stored_zhong_ul_top">
         <h2 id="choose_card_name">储值卡:</h2>
         <div class="stored_zhong_ul_zhong">
          <h3></h3>
         </div>
         <div class="stored_zhong_ul_wei" id="remaining_card_amount">请选择<i class="icon-back"></i></div>
        </div>
       </a>
      </li>
      
      <span id="card_message" hidden>储值卡余额不足，需额外支付<span style="color:red;" id="m_price">200</span>货豆</span>
     
    </ul>


    <div class="stored_zhong_ul_di">
     <a href="javascript:;" onclick="pay_message()">确认支付</a>
    </div>

</div>



<script type="text/javascript">
var card_id = 0;
var card_pay_amount = 0;
var pay_price = 0;

$('#choose_card').on('click',function()
{ 
	$('#pay_code').hide();
	$('#card_list').show();
	
// 	if( $('.stored_value_ul').find('li').length > 0 )
// 	{ 
		
// 		$('.stored_value_ul li').each(function(){ 
// 			if( $(this).attr('id') !== 'card_'+card_id )
// 			{ 
// 				alert(card_id);
// 			}
// 		});
// 	}
})

function pay_message()
{ 
	
	

	if( !pay_price )
	{ 
		$(".black_feds").text("请填写支付金额").show();
        setTimeout("prompt();", 1000);
		return;
	}
	
	$('.color-bg').show();
	
	$('input[name=pay_password]').val('');
	$('#show_message').show();
// 	$('#show_message').find('span').text(message);
}

function card_message()
{ 
	pay_price = $('input[name=pay_price]').val();
	$('#card_message').hide();
	var message = '';
	
	if( card_info[card_id] )
	{ 
		card_pay_amount = card_info[card_id]['sj_remaining_card_amount'];
		
		if( parseFloat( card_info[card_id]['sj_remaining_card_amount'] ) < parseFloat(  pay_price )  )
		{ 
			$('#card_message').show();
			var m_price = parseFloat( pay_price ) - parseFloat( card_info[card_id]['sj_remaining_card_amount'] );
			$('#m_price').text(m_price);
		
		}else{ 
			card_pay_amount = pay_price;
			$('#card_message').hide();
		}
		
		
	}
}

</script>





