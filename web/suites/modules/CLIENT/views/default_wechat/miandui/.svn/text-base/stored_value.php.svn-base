<style>
.button{
    height: 30px;
    width: 40%;
    background-color: #FECF0A;
    text-align: center;
    margin-top: 24px;
    line-height: 30px;
    font-size: 16px;
    color: #373422;
    display: inline-block;
}
  
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:1;}
.tribe_index_nav_left {position:fixed;top:15px;left:10px;z-index: 9999;padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(0,0,0,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);}
</style>
<script>
var card_info = {};
</script>
<div id="card_list" hidden>
   <div>
  <a href="javascript:show_index();" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
</div>
     <div class="swiper-container">
                <div class="swiper-wrapper">
                  
                    
                </div>
                <div class="swiper-pagination"></div>
            </div>
   
    <div class="header" style="height:50px; display:none;">
               <div class="main_dui">
                <a href="javascript:show_index();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px; float:none; display:block;font-size: 20px;"></a>
                <div class="main_dui_top">
                <p class="title">使用储值卡</p>
                </div>
<!--                 <a href="javascript:" class="detailed_t" id="widget_submit" >说明</a>            -->
               </div> 
    </div>
    <?php if( $card_list ){?>
    <div class="stored_value">
       <ul class="stored_value_ul">
           <?php foreach ( $card_list as $v ){
           
           
             $v['sj_remaining_card_amount'] = $v['remaining_card_amount'];
             
             if( $v['level_two_show_card_amount'] < $v['remaining_card_amount'] && $v['level'] == 2 )
             { 
                 $v['sj_remaining_card_amount'] = $v['level_two_show_card_amount'];
             }
         
             if( $v['sj_remaining_card_amount'] > 0 ){      
             ?>
                 
           <li class="card_list" id="card_<?php echo $v['id']?>" onclick="Choose_Card('<?php echo $v['id']?>')">
             <a href="javascript:;">
               <h2 class="stored_ul_h2"><span class="stored_ul_h2_left"><?php echo $v['card_name']?></span><span class="stored_ul_h2_rigth">点击使用</span></h2>
               <div class="stored_ul_div">
        
                 
                 <h3>余额<strong><?php echo $v['sj_remaining_card_amount']?></strong>货豆</h3>
                 
                 <p><?php $day =  diffBetweenTwoDays(date('Y-m-d'), $v['end_time'] ); echo $day ? '还有'.$day.'天过期' : '24小时以内过期' ?><span>有效期至：<?php echo $v['end_time']?></span></p>
               </div>
             </a>      
           </li>
           
           <script>
               card_info[<?php echo $v['id']?>] = <?php echo json_encode($v) ?>
           </script>
           <?php } } ?>
       </ul>
    </div>
    <?php }?>
</div>
<div class="color-bg" hidden ></div>
<div class="h5-forget2"  id="show_message" hidden >
		<div class="h5-lose" onclick="$('#show_message').hide();$('.color-bg').hide()">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
		<div class="forget2-password">
			<div class="password-text">
				
				<div style="margin-top: 5px;">
					<span class="float-left">支付密码：</span><input type="password" value="" class="mima-forget" name="pay_password">
				</div>
			</div>
			<a href="javascript:void(0);" class="password-button" id="pay_sub" style="background-color:#fe4d52;color:#ffffff">确定支付</a>
			<div>
				<a href="javascript:void(0);" class="no-monery" id="wechat_pay" hidden>没有余额，用微信支付</a>
				<a href="<?php echo site_url("member/info/paypwd_edit")?>" class="no-mima">忘记密码</a>
			</div>
		</div>
	</div>
	
	<div class="h5-forget2"  style="height:150px;"id="error_message" hidden >
		<div class="h5-lose" onclick="javascript:location.reload();">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
		
		<div class="forget2-password">
			<div class="password-text">
				
				<div style="margin-top: 5px;">
					<span class="">支付失败</span>
				</div>
			</div>
			<a href="javascript:location.reload();" class="password-button"  style="background-color:#fe4d52;color:#ffffff">重新支付</a>
			
		</div>
	</div>

<script type="text/javascript">

if( $('.card_list').length > 0 )
{

// console.log( $('.card_list').eq(0).attr('id').split('_')[1] );
Choose_Card( $('.card_list').eq(0).attr('id').split('_')[1]  );

}else{ 
	
	$('#choose_card').parent().remove();
}

if( $('.stored_value_ul').find('li').length == 0 )
{ 
	$('.stored_value_ul').remove();
}

function show_index()
{
	$('#pay_code').show();
	$('#card_list').hide();	
}


function Choose_Card(id)
{ 
	var card_name = $('#card_'+id).children('a').children('h2').children('span').eq(0).html();
	var html_id = $(this).attr('id');
	var card_title = '点击使用';
	
	if( card_id == id )
	{ 
		$('#choose_card_name').html('储值卡:');
		$('#remaining_card_amount').html('请选择<i class="icon-back"></i>');
		
		card_id = 0;
		card_pay_amount = 0;
		
	}else{ 
		
		$('.stored_value_ul li:not(#card_'+id+')').children('a').children('h2').children('span').html(card_title);
		card_id = id
		card_title = '点击取消';
		$('#choose_card_name').html(card_info[card_id]['card_name']);
		$('#remaining_card_amount').html('余额：'+card_info[card_id]['sj_remaining_card_amount']+'<i class="icon-back"></i>');
		
	}
	
	$('#card_'+id).children('a').children('h2').children('span').eq(1).html(card_title);
	$('#pay_code').show();
	$('#card_list').hide();	
	card_message();
	
}



$('#pay_sub').on('click',sub_pay_order);


function sub_pay_order()
{ 
	 
	var pay_password = $('input[name=pay_password]').val();
	if( !pay_password )
	{  
		$(".black_feds").text('请输入支付密码').show();
    	setTimeout("prompt();", 2000);
		return;
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Member/order/branch_code_pay')?>',
		data:{'branch_id':'<?php echo $branch_id?>','price':pay_price,'card_pay_amount':card_pay_amount,'card_buy_id':card_id,'pay_password':pay_password},
		type:'post',
		dataType:'json',
		beforeSend:function()
        { 
		    $('#pay_sub').unbind();
        },
    	
		success:function(data) 
		{ 
			$('#pay_sub').on('click',sub_pay_order);
			
			if( !data.status )
			{ 
				$('.h5-forget2').hide();
				$('#error_message').show();
				return;
			}

			
			$(".black_feds").text(data.message).show();
            setTimeout("prompt();", 2000);
            
			
			if( data.status == 1 )
			{
				var url = '<?php echo site_url('Member/order/detail')?>/'+data.data.order_id;
				window.setTimeout("window.location.href='"+url+"'", 1000);   
				return;
				
			}else if( data.status == 2 )
			{ 
        		  if(confirm("货豆余额不足，立刻去充值？"))
        		  {
        			  window.location.href = '<?php echo site_url('Charge/purchase')?>';
        		  }
			}

			
		},
		error:function()
		{ 
			$('#pay_sub').on('click',sub_pay_order);
			$(".black_feds").text('服务器异常，请稍后再试').show();
	    	setTimeout("prompt();", 2000);
			return;
		}
	})
}





</script>