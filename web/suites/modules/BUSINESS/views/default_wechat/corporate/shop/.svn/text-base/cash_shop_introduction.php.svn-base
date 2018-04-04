

<div class="immediate_payment">
  
  <div class="immediate_payment_img">
  	<img src="images/tribe_join_img.png" alt="">
  </div>

  <div class="name_ball" style="display:none;z-index:99" >
           <div class="name_ball_box">
               <div class="warrant_box" style="margin: 0 12%;">
               	   <span>店铺类型</span>
               	   <div class="cash_shop_introduction_input">
               	   
               	   <?php foreach ( $corp_product_list as $k=>$v ){?>
               	   <label>
               	   	 <p>
               	   	 	<input class="" type="radio" name="corp_type" value='<?php echo $k?>' >
               	   	 	<span><?php echo $v['name']?></span><span class='immediate_payment_num'>¥ <?php echo $v['cash']?></span>
               	   	 </p>
               	   	 </label>

               	   <?php } ?>
               	   </div>
                   <span class="icon-shopping ball_close_icon" onclick="ball_close_icon()"></span>
                   <a href="javascript:sub_corp_pay()<?php //echo site_url('Corporation/Shop_Pay')?>" class="warrant_box_ok">选择</a>
               </div>
           </div>

    </div>


  
  <div class="tribe_join">
  <!-- 立即支付 -->
          <a href="javascript:void(0);" onclick="ball_open();">立即开店</a>
    </div>
</div> 


<script type="text/javascript">

	function sub_corp_pay()
	{ 
		corp_type =  $("input[type='radio']:checked").val() ;
		
		if( !corp_type )
		{ 
			$(".black_feds").text('请选择店铺类型').show();
    		setTimeout("prompt();", 2000);
    		return;
		}

		window.location.href='<?php echo site_url('charge/Cash_Shop')?>/'+corp_type;
	}

	
    function ball_open() {
       $('.name_ball').show();
    }
    function ball_close_icon() {
       $('.name_ball').hide();
    }
    $('.cash_shop_introduction_input p').on('click',function(){
        
    	$('input[name=corp_type]').removeClass('immediate_payment_active');
    	$('input[name=corp_type]').removeClass('icon-check');
    	$(this).children('input').addClass('immediate_payment_active');
    	$(this).children('input').addClass('icon-check');
    	
    })

</script>