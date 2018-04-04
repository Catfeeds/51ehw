  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
      <?php //储蓄卡头部菜单导航  
        $data['head_menu'] = !$status ? 2 : 1;
        $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle"><?php echo $title?></div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul>
            	    <?php if(!$status){ //销售方?>
                        <li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">查看线上储值卡</a></li>
                    	<li><a href="<?php echo site_url('Corporate/Savings_card/Apply_View')?>">申请储值卡</a></li>
                	<?php }else{ //购买方?>
                    	<li><a href="<?php echo site_url('Corporate/Savings_card/My_List')?>">我的线上储值卡</a></li>
    				    <li class="houtai_zijin_current"><a href="javascript:history.go(0)">使用授权管理</a></li>
                	<?php }?>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh"><?php echo $title?></div>
            <div class="stored_chongg">
               <ul class="stored_chong_ull">
                 <li><span>手机号：</span><a href="javascript:;" class="stored_chong_ul_a" id="buluo">请选择<i hidden>[更改]</i></a></li>
                 <li><span>用户名：</span><spam id='customer_name'></spam></li>
                 <li><span>昵称：</span><spam id='nick_name'></spam></li>
                 <li><span>线上储值卡名称：</span><?php echo $detaile['card_name']?></li>
                 <li><span>线上储值卡期限：</span><?php echo $detaile['start_time']?> 至 <?php echo $detaile['end_time']?> </li>
                 <li><span>储值卡余额：</span><?php echo $detaile['card_remaining']?> 券</li>
                 <li class="stored_chong_ull_li"><span>授权金额：</span><input type="text" class="n" name="card_amount" value="" onkeyup="if(isNaN(value))execCommand('undo')" placeholder="请输入授权金额"></li>
                 <li class="stored_chong_ull_li"><span>有效期：</span><input type="text" value="" class="stored_input" name="start_time" onclick="WdatePicker()" readonly=""><samp class="stored_input_samp">至</samp><input type="text" value="" class="stored_input" name="end_time" onclick="WdatePicker()" readonly=""></li>
              	 
               </ul>
          
               
               <div class="stored_chong_bottom">
                 <a href="javascript:;" class="stored_chong_left" onclick="sub_card()">确认授权</a>
                 <a href="javascript:history.back()" class="stored_chong_rigth1">返回</a>
               </div>
               
            </div>  
            
            
            
            <div class="tribal_goods" id="tribal_goods" style="display: none;">
        <div class="tribal_goods_top" style="width:400px; height:180px; margin-left:-200px; margin-top:-90px;">
        <h1>搜索账号<i class="huisr" style="font-size:26px; text-align:right; float:right; margin-right:8px; cursor:pointer; margin-top:-3px; font-weight:normal">x</i></h1>
         <div class="tribal_goods_zhong">
            <ul style="width:330px;">
               <li><span style="text-align:left">按手机号搜索</span></li>
              <li><input type="tel" class="n" name="mobile" value="" style="border:1px solid #fe4a00;" onkeyup="value=value.replace(/[^0-9]/g,'')"><a class="tribal_goods_a" href="javascript:;" onclick="search_customer()">搜索</a></li>
          	<p style="margin-left: 48px;color: red; font-size: 13px" id="search_message"></p>
            </ul>
         </div>
        </div>
    </div>

            
            
            
         </div>
       <!--右边结束-->    
         </div>



     


<script>
var customer_id = '';
/**
 * 搜索手机号码。
 */
function search_customer()
{ 
	var mobile = $('input[name=mobile]').val();
	$('#search_message').text('');
	if( !mobile )
	{ 
		$('#search_message').text('请输入手机号码');
		return;
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Corporate/Savings_card/Mobile_Customer_Info')?>/'+mobile,
		data:{},
		type:'get',
		dataType:'json',
		success:function(data)
		{
			if( data.data )
			{   
				if( data.status == 2 )
				{ 
					$('#search_message').text('不能授权给自己');
					return;
				}
				customer_id = data.data.id;
	            $('#buluo').html(data.data.mobile+'<i>[更改]</i>');
	            $('#customer_name').text(data.data.name);
	            $('#nick_name').text(data.data.nick_name);
				$("#tribal_goods").css("display","none")
				
			}else{ 
				
				$('#search_message').text('用户不存在');
			}
			
		},
		
	})
}

function sub_card()
{ 
	var card_amount  = $('input[name=card_amount]').val();
	var card_remaining = <?php echo $detaile['card_remaining']?>;
	var start_time =  $('input[name=start_time]').val();
	var end_time =  $('input[name=end_time]').val();

	
	if( !customer_id )
	{ 
		alert('请选择需要授权的用户');
		return;
	}
	
	if( !card_amount )
	{
		 alert('请输入授权金额');
		 return;
		 
	}else if( card_amount > card_remaining )
	{ 
		alert('授权金额不能大于储值卡余额');
		return;
	}

	if( !start_time || !end_time )
	{ 
		alert('请选择有效期');
		return;
		
	}else if( ( start_time < '<?php echo $detaile['start_time']?>' || start_time > '<?php echo $detaile['end_time']?>') || ( end_time > '<?php echo $detaile['end_time']?>' || end_time < '<?php echo $detaile['start_time']?>') )
	{ 
		alert('有效期不在储值卡期限内,请选择正确的日期');
		return;
	}

	$.ajax({ 
		<?php if( !$status ){ //一级使用授权?>
			
		url:'<?php echo site_url('Corporate/Savings_card/Sales_Add_Card')?>',
		data:{'start_time':start_time,'end_time':end_time,'card_amount':card_amount,'customer_id':customer_id,'card_id':'<?php echo $detaile['id']?>'},
	    
		<?php }else{ //二级使用授权?>
		    
	    url:'<?php echo site_url('Corporate/Savings_card/My_Authorize_Card')?>',
		data:{'start_time':start_time,'end_time':end_time,'card_amount':card_amount,'customer_id':customer_id,'buy_id':'<?php echo $detaile['id']?>'},
		<?php }?>
		
	    type:'post',
		dataType:'json',
		beforeSend:function()
        { 
			$('.stored_chong_left').text('确认授权中.....');
            $('.stored_chong_left').css('background','#dddddd');
            $('.stored_chong_left').removeAttr('onclick');
        },
    	complete:function()
    	{ 
    		$('.stored_chong_left').text('确认授权');
            $('.stored_chong_left').css('background','#72c312');
            $('.stored_chong_left').attr('onclick','sub_card()');
    	},
		success:function(data)
		{
			alert(data.message);
			
			if( data.status == 1)
			{ 
				$('.stored_chong_left').removeAttr('onclick');
				window.setTimeout("window.history.back();", 1000);   
			}

			if( data.status == 2)
			{   
				$('.stored_chong_left').removeAttr('onclick');
				window.setTimeout("location.reload();", 1000);   
			}
			
		},
		error:function()
		{
			alert('服务器异常，请稍后再试');
		}
		
	})
}
	
	<!--点击弹窗-->
	$("#buluo").click(function() {
	   $('input[name=mobile]').val('');	
	   $('#search_message').text('');
	   $("#tribal_goods").css("display","block")
	   })

   $(".huisr").click(function() {
	   $("#tribal_goods").css("display","none")
   })

		
</script>

	