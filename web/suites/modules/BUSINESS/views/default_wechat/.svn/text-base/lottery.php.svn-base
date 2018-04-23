<!-- 返回 -->
<?php 
$mac_type = $this->session->userdata("mac_type");
if(empty($mac_type)){
   $link = 'http://m.dev.wezchina.com/vote/1255aba0-1dde-11e8-90c8-4d0fbafef8b8';
   if(base_url() ==  'http://www.51ehw.com/'){
      $link = 'http://m.qqxqs.com/vote/396bb4f0-2b31-11e8-89be-09ee32e68284';
   }
  ?>
   <div style="position:fixed;top:15px;left:15px;z-index: 9999;">
       <a href="<?php echo $link; ?>" style="padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(255,255,255,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
   </div>            
<?php }?>
<style type="text/css">
  .lottery_num_a {
    border-radius: 15px;
    overflow: hidden;
    background: -webkit-linear-gradient(left,#af874b,#c6a876,#b0894e);
    background: -o-linear-gradient(left,#af874b,#c6a876,#b0894e);
    background: -mos-linear-gradient(left,#af874b,#c6a876,#b0894e);
    background: -moz-linear-gradient(left,#af874b,#c6a876,#b0894e);
    background: linear-gradient(left,#af874b,#c6a876,#b0894e);
    padding: 3px 9px;
    margin-left: 10px;
    color: #80440b;
    
}
</style>
<!-- 抽奖 -->
<div class="lottery">
	<!-- 头部 -->
	<div><img src="images/lottery/lottery_head.png" alt=""></div>
    <!-- 内容 -->
    <div class="lottery_main">
    	<!-- 中间轮播 -->
    	<div class="lottery_lunbo">
          <div class="lottery_lunbo_box">
              <a href="javascript:void(0);">
                  <span class="icon-horn lottery_icon"></span>
                  <div id="tribal_notice_top_nei">
                      <ul class="lottery_lunbo_box_xia">
                      </ul>
                  </div>
              </a>
          </div>
      </div>
      <!-- 倒计时 -->
	  <div class="count_time">
	  	<span>距离下次投票抽奖还有</span><em id="d" style="display: none;"></em><em id="h">00</em>时<em id="m">00</em>分<em id="s">00</em>秒
	  </div>
 
      <!-- 大转盘 -->
      <div class="lottery_turntable">
      	<div class="lottery_turntable_num"><span>您还剩<em id="lottery_num"><?php echo $Lottery['total_num'];?></em>次抽奖机会</span>

<?php
       $mac_type = $this->session->userdata("mac_type");
       if($mac_type && $mac_type == 'APP'){
           $Package_link = '<#MyPackage#>';
       }else{
           $Package_link = site_url('Corporate/card_package/my_package');
       }?>
       
      <a class="lottery_num_a" href="<?php echo $Package_link; ?>">奖券入口</a>
        </div>
        
        <div class="turntable-tob">
          <div class="turntable-nei"> 
        <div class="turntablenei">
		<div class="turnplate" style="background-image:url(images/lottery/turntable1.png);background-size:100% 100%;">
			<canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
			<img class="pointer" src="images/lottery/turntable2.png">
		</div>
        </div>
        </div>
        </div>


      </div>

      <!-- 活动规则 -->
      <div class="lottery_rule">
      	 <div class="lottery_rule_title"><fieldset><legend>活动规则</legend></fieldset></div>
         <div class="lottery_rule_en"><span>ACTIVITY RULES</span></div>
      	 <p>1、在指定微信公众号（51易货网，陕西省秦商联合会）、全球秦商APP的投票完成页面，参与抽奖活动。</p>
         <p>2、用户每完成1次有效投票，均可获得1次抽奖机会（每个小时可投10个不同的项目，每天最多可投240票，每天最多可获得240次抽奖机会）</p>
      </div>
     
      <!-- 奖品清单 -->
      <div class="lottery_pizze">
      	<div class="lottery_rule_title"><fieldset><legend>奖品清单</legend></fieldset></div>
        <div class="lottery_rule_en"><span>EVENT PRIZES</span></div>
        <!-- <p class="lottery_pizze_img"><span>即时抽奖奖品</span></p> -->
        <p class="lottery_pizze_title">转盘大奖</p>
        <p>iPhone X</p>
        <p>价值888元长安客西凤酒藏品级一瓶</p>
        <p>价值488元长安客西凤酒帝享一瓶</p>
        <p>188元、288元长安客西凤酒专属现金券</p>
      </div>
      <!-- 现金券使用说明 -->
      <div class="lottery_rule">
         <div class="lottery_rule_title"><fieldset style='width:162px;'><legend>现金券使用说明</legend></fieldset></div>
         <div class="lottery_rule_en"><span>INSTRUCTIONS FOR USE</span></div>
         <p>1、现金券仅适用于51易货网平台商家“陕西丝路长安客酒业有限公司”；</p>
         <p>2、现金券的面额有188元和288元，使用期限截止到：2018年5月31日，逾期作废；</p>
         <p>3、现金券可抵扣商品的相应价格，每消费一款商品就可以使用一张，并且不可以叠加使用；</p>
         <p>4、现金券不找零、不兑换现金、不另开发票，持现金券购买的商品不支持退货；</p>
         <p>5、现金券之相关事宜，陕西丝路长安客酒业有限公司在法律允许范围内保留最终解释权。</p>
      </div>
       <!-- 温馨提示 -->
       <div class="lottery_prompt">
         <p>温馨提示</p>
         <p>【长安客·西凤酒】属于预售商品，买家须提前支付商品款项（差价）才能完成订单交易，并于5月31日后统一安排发货。</p>
       </div>
      <!-- *本活动最终解释权归活动方所有 -->
      <div class="lottery_copyright"><span>*本活动最终解释权归活动方所有</span></div>


    </div>

    
    <!-- 中奖弹窗 -->
    <div class="lottery_ball" hidden>
     <div class="lottery_ball_box">
        <!-- 谢谢参与 -->
       <div class="lottery_pizee_no" hidden>
       	  <img src="images/lottery/pizze_no.png" alt="">
       	  <a href="javascript:void(0);" class="icon-guanbi" onclick="lottery_close();"></a>
       </div>
       <!-- 中奖 直接领取 -->
       <div class="lottery_pizz_yes" hidden>
           <div class="lottery_pizz_yes_box">
             <!-- 背景图 -->
             <img src="images/lottery/pizze_bg.png" alt="">
             <!-- 金币图 -->
             <img src="images/lottery/pizze_jinbi.png" class="lottery_pizze_jinbi" alt="">
             <!-- 优惠劵图 -->
             <img src="images/lottery/pizze_50.png" class="lottery_ball_pizze_img" alt="">
             <!-- 文案 -->
             <span class="lottery_ball_pizze_text">仅限在51易货APP下单购买长安客西凤酒时使用</span>
           </div>
           <div class="lottery_pizze_get"><a href="javascript:void(0);" onclick="gather();">点击领取</a></div>
           <div class="lottery_pizz_yes_close"><a href="javascript:void(0);" class="icon-guanbi" onclick="lottery_close_01();"></a></div>
       </div>
       <!-- 中奖 要输入手机号码和验证码领取 -->
       <div class="lottery_pizz_yes_condition" hidden>
         <div class="lottery_pizz_yes">
           <div class="lottery_pizz_yes_box">
             <!-- 背景图 -->
             <img src="images/lottery/pizze_bg.png" alt="">
             <!-- 金币图 -->
             <img src="images/lottery/pizze_jinbi.png" class="lottery_pizze_jinbi" alt="">
             <!-- 优惠劵图 -->
             <img src="images/lottery/pizze_50.png" class="lottery_ball_pizze_img" alt="">
             <!-- 文案 -->
             <span class="lottery_ball_pizze_text">仅限在51易货APP下单购买长安客西凤酒时抵扣</span>
           </div>
           <div class="lottery_ball_input">
             <p><input type="tel" id ="code_mobile" placeholder="请输入手机号"></p>
             <p>
              <input type="tel"  id ="mobile_code"  placeholder="验证码">
              <input type="button" onclick="send_valitaty();" id="get_mobile_code" value="获取"> <!-- 获取验证码用忘记密码页面的功能。 -->
             </p>
           </div> 
       </div>
       <div class="lottery_pizze_get01"><a href="javascript:void(0);" onclick="gather();">点击领取</a></div>
       <div class="lottery_pizz_yes_close"><a href="javascript:void(0);" class="icon-guanbi" onclick="lottery_close_02();"></a></div>
       </div> 

     </div>
    </div> 



</div>
<script type="text/javascript">
var mobile = <?php echo $mobile;?>;
</script>
<script src="js/verification.js"></script><!-- js验证类 -->
<script src="js/turntable.js"></script>
<script src="js/awardrotate.js"> </script>
<script type="text/javascript">
function send_valitaty(){
	 var  mobile = $("#code_mobile").val();
	 if(!mobile || mobile == ''){
		 $(".black_feds").text('请输入正确的手机号').show();
   		  setTimeout("prompt();", 2000);
	   	  return ;
			  }else{
				  if(!checkMobile(mobile)){
					 $(".black_feds").text('请输入正确的手机号').show();
		   		  setTimeout("prompt();", 2000);
			      return ;
				  }
      }
	 $(".black_feds").text("正在发送验证码...").show();
	 $.ajax({
			url: '<?php echo  site_url("Customer/ajax_send");?>'+'/'+255,
			type: 'POST',
			data:{'mobile':mobile},
			dataType: 'html',
			success: function(data){
				$('#get_mobile_code').attr("disabled",true);
				$(".black_feds").hide();
				$('#get_mobile_code').val('90s');
				$(".black_feds").text(data).show();
				setTimeout("prompt();", 2000);
				setTimeout(remainTime1,1000);
			},
	    error:function(){
			$(".black_feds").text("网络出错，请重试！").show();
			setTimeout("prompt();", 2000);
			return;
		}
	});
}
/**
 * 验证码按钮倒计时js
 * 验证码按钮id：get_mobile_code
 */
function remainTime1(){
	var times =  $('#get_mobile_code').val().replace(/[^0-9]/ig,"");
	if(times < 1){
		$('#get_mobile_code').val('获取');
		$('#get_mobile_code').attr("disabled",false); 
	}else{
		times -= 1;
		$('#get_mobile_code').val(''+ times +'s');
		setTimeout(remainTime1,1000);
	}
}


function gather(){
	 if(mobile){
		 var url = '<?php echo site_url('Activity/Lottery/gain_package')?>';
         $.ajax({
        	async : false,
        	url : url,
        	type : "POST",
        	dataType:"json",
        	data:{"award_id":award_id},
        	success:function(data){
        		$(".black_feds").text(data.msg).show();
    			setTimeout("prompt();", 2000);
    			if(data.status == 3 || data.status == 1){

    				setTimeout(function(){
    					        <?php 
    		        			$mac_type = $this->session->userdata("mac_type");
    		        			if($mac_type && $mac_type == 'APP'){?>
   		        			     window.location.href = "<#MyPackage#>";
    		        			<?php  }else{?>
    		        			    window.location.href = "<?php echo site_url('Corporate/card_package/my_package')?>";
    		        			<?php }?>
        				}, 2200);
    			}
    			return ;
        	},
        	error:function(){
        		  $(".black_feds").text('网络出错，请重试！').show();
        		  setTimeout("prompt();", 2000);
        		  return ;
        	}
         })
	 }else{
		 var  code_mobile = $("#code_mobile").val();
    	 var  mobile_code = $("#mobile_code").val();
    	 var url = '<?php echo site_url('Activity/Lottery/bingdingLottery')?>';

 		if(!code_mobile || code_mobile == ''){
			 $(".black_feds").text('请输入正确的手机号').show();
	   		  setTimeout("prompt();", 2000);
		   	  return ;
 			  }else{
 				  if(!checkMobile(code_mobile)){
  					 $(".black_feds").text('请输入正确的手机号').show();
			   		  setTimeout("prompt();", 2000);
				      return ;
 				  }
			if(!mobile_code){
				 $(".black_feds").text('请输入验证码').show();
		   		  setTimeout("prompt();", 2000);
			      return ;
				}	
 		 }
         $.ajax({
        	async : false,
        	url : url,
        	type : "POST",
        	dataType:"json",
        	data:{"code_mobile":code_mobile,"mobile_code":mobile_code,"award_id":award_id},
        	success:function(data){
        		$(".black_feds").text(data.msg).show();
    			setTimeout("prompt();", 2000);
        		if(data.status == 3 || data.status == 1){
    				setTimeout(function(){
						window.location.href = "<?php echo site_url('Corporate/card_package/my_package')?>";
        				}, 2200);
    			}
    			return ;
        	},
        	error:function(){
        		  $(".black_feds").text('网络出错，请重试！').show();
        		  setTimeout("prompt();", 2000);
        		  return ;
        	}
         })
	 }
	  }
  // 中间轮播
  function AutoScroll(obj){ 
     $(obj).find("ul:first").animate({ 
       marginTop:"-24px" 
     },500,function(){ 
     $(this).css({marginTop:"0px"}).find("li:first").appendTo(this); 
     }); 
  } 
  $(document).ready(function(){ 
       setInterval('AutoScroll("#tribal_notice_top_nei")',3000); 
  }); 

  // 倒计时
  function getRTime(){
      var dateTime = '<?php echo $limit_date;?>';
      dateTime = dateTime.replace(/-/g,"/");
      var EndTime = new Date(dateTime);
      var NowTime = new Date();
      var t = EndTime.getTime() - NowTime.getTime();
//       alert(t);
      var m= Math.floor(t/1000/60%60);
      var s= Math.floor(t/1000%60);
      document.getElementById("h").innerHTML = "00";
      
	  if(m < 0 && s < 0){
		   clearInterval(timer);
	       document.getElementById("m").innerHTML = '00';
	       document.getElementById("s").innerHTML = '00';
		}else{
		      document.getElementById("m").innerHTML = m;
		      document.getElementById("s").innerHTML = s;
			}

    }
    var timer = setInterval(getRTime,1000);

    // 关闭弹窗
    function lottery_close() {
      $('.lottery_ball').hide();
      $('.lottery_pizee_no').hide();
    }
    function lottery_close_01() {
      $('.lottery_ball').hide();
      $('.lottery_pizz_yes').hide();
    }
    function lottery_close_02() {
      $('.lottery_ball').hide();
      $('.lottery_pizz_yes_condition').hide();
    }
    
	//抽奖信息
	function getLotteryList(){
		   var url = '<?php echo site_url("Activity/Lottery/getLotteryList");?>';
		   $.post(url,{data:'',},function(data){
			   var result = "";
			   if(data["list"].length>0){
				   for(var i=0;i<data["list"].length;i++){
						result +='<li><span>恭喜';
						result += data["list"][i]['mobile'];
						result +='</span><span>';
						result += data["list"][i]['award'];
						result +='</span></li>';
					   }
				   }
			   $(".lottery_lunbo_box_xia").append(result);	
			   },"json");
		}
	getLotteryList();
	stochastic_url = '<?php echo site_url("Activity/Lottery/stochastic");?>';
</script>