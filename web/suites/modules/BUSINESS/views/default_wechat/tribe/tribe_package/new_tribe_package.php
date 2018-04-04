
<style type="text/css">
    .tribe_prize_record_list ul li span i:nth-child(1) {color:#69719e;}
    .tribe_prize_record_list ul li span i:nth-child(2) {font-size:12px;color:#999999;}
    .tribe_prize_record_list ul li {border-bottom: 1px solid #ddd;}
    .tribe_receiving_text p {border-bottom: none;margin-top: 0;color: #666;}
    .tribe_receiving_text {margin-top: 35px;}
</style>

<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>
<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php 
if($this->session->userdata('app_info')['wechat_appid'] != NULL):
$this->load->library("js_api_sdk");
$this->js_api_sdk = new js_api_sdk();
$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
$signPackage = $this->js_api_sdk->GetSignPackage();
?>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
      debug: false,
      appId: '<?php echo $this->session->userdata('app_info')['wechat_appid'];?>',
      timestamp: '<?php echo $signPackage["timestamp"];?>',
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'onMenuShareTimeline',
      ]
  });
  wx.ready(function(){
	  wx.onMenuShareAppMessage({
	      title: '<?php echo $package['tribe_package_name'];?>',
	      desc: '<?php echo $package['tribe_package_desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$package['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$package['image'];?>',
	      trigger: function (res) {
// 	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareTimeline({
	      title: '<?php echo $package['tribe_package_name'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$package['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$package['image'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareQQ({
	      title: '<?php echo $package['tribe_package_name'];?>',
	      desc: '<?php echo $package['tribe_package_desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$package['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$package['image'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到QQ');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareWeibo({
	      title: '<?php echo $package['tribe_package_name'];?>',
	      desc: '<?php echo $package['tribe_package_desc'];?>',
	      link: '<?php echo site_url('Activity/Tribe_package/receive').'/'.$package['id']?>',
	      imgUrl: '<?php echo IMAGE_URL.$package['image'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到微博');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  });
  
</script>
<?php
		 endif;
		?>
<!-- 新部落货包 -->
<div class="new_tribe_package">

<?php 
//是易货会员并且绑定了手机
if($mobile_exist){
    //领取了货包
    if($gain_package_status){
?>
<!-- 状态二：领取货包后 -->
	<div class="package_scene_two" >
    <!-- 货包详情 -->
    <div class="new_package_details">
       <div class="new_package_details_left">
           <p><?php echo  $package['tribe_package_name']?></p>
           <p><?php echo  $package['tribe_package_desc']?></p>
           <p><?php echo  $package['start_date'].' - '.$package['valid_date']?></p>
       </div>
       <div class="new_package_details_right"><span>免费</span></div>
    </div>
    <!-- 获取货包状态 -->
    <div class="new_package_get_status">
        <p>恭喜您获得<?php echo  $package['gift_name']?></p>
        <p>请详细填写收货地址，我们会尽快安排给你发货！</p>
    </div>
<?php if($gain_package_info &&  $gain_package_info['type'] == 1){ //收货地址已确认?>
    <!-- 填写收货地址 -->
    <div class="new_tribe_package_address">
      <div class="new_package_address_title"><span>填写收货地址</span></div>
      <p><input type="text" placeholder="姓名" value="<?php echo $gain_package_info['name']; ?>" disabled></p>
      <p><input type="number" placeholder="手机号码" value="<?php echo $gain_package_info['mobile'];?>" disabled></p>
      <p><input type="text" placeholder="详细地址，如省、市、街道、楼牌等" value="<?php echo $gain_package_info['address']; ?>" disabled></p>
      <div class="tribe_receiving_text">
        <p><span>注：</span>1、本次活动由[51易货]提供支持；</p>   
        <p> 2、平台客服人员在确认领取之后的三个工作日之内与您核实信息并发出快递，请保持手机畅通；</p>  
        <p> 3、详情可咨询：400-0029-777；</p>  
        <p> 4、欢迎您加入51易货网，祝您生活愉快！</p>    
      </div>
    </div>
    <!-- 确认领取并进入部落看看 -->
    <div class="new_tribe_package_but" style="margin: 30px 15px 10px 15px;"><a href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>">领取成功进入部落看看</a></div>
<?php }else{ //收货地址未确认 ?>
<!-- 填写收货地址 -->
    <div class="new_tribe_package_address">
      <div class="new_package_address_title"><span>填写收货地址</span></div>
<?php
//要区分是新用户还是旧用户领取
$package_mobile = $this->session->userdata("package_mobile");//新用户在货包进行绑定
if($package_mobile){//新用户 ?>
    <p><input type="text" id="adres_name" placeholder="姓名" value="<?php if($address_info && $address_info['consignee']){echo $address_info['consignee'];}?>" ></p>
    <p><input type="number" id="adres_mobile" placeholder="手机号码" value="<?php  if($package_mobile){echo $package_mobile;}?>"></p>
    <p><input type="text" id="adress" placeholder="详细地址，如省、市、街道、楼牌等" value="<?php  if($address_info && $address_info['address_for_name']){echo $address_info['address_for_name'].$address_info['address'];}?>"></p>
<?php }else{//旧用户 ?>
    <p><input type="text" id="adres_name" placeholder="姓名" value="<?php if($address_info && $address_info['consignee']){echo $address_info['consignee'];}?>"></p>
    <p><input type="number" id="adres_mobile" placeholder="手机号码" value="<?php  if($address_info && $address_info['mobile']){echo $address_info['mobile'];}?>"></p>
    <p><input type="text"  id="adress" placeholder="详细地址，如省、市、街道、楼牌等" value="<?php  if($address_info && $address_info['address_for_name']){echo $address_info['address_for_name'].$address_info['address'];}?>"></p>
<?php } ?>
      <div class="tribe_receiving_text">
        <p><span>注：</span>1、本次活动由[51易货]提供支持；</p>   
        <p> 2、平台客服人员在确认领取之后的三个工作日之内与您核实信息并发出快递，请保持手机畅通；</p>  
        <p> 3、详情可咨询：400-0029-777；</p>  
        <p> 4、欢迎您加入51易货网，祝您生活愉快！</p>    
      </div>
    </div>
    <!-- 确认领取并进入部落看看 -->
    <div class="new_tribe_package_but" style="margin: 30px 15px 10px 15px;"><a  href="javascript:void(0);"  onclick="sub_address();">确认领取并进入部落看看</a></div>
<?php }?>
	</div>
<?php 
    }else{
        //货包领完了
        if(!$gain_package_time){
?>
<div class="package_scene_two" >
      <!-- 货包详情 -->
    <div class="new_package_details">
       <div class="new_package_details_left">
           <p><?php echo  $package['tribe_package_name']?></p>
           <p><?php echo  $package['tribe_package_desc']?></p>
           <p><?php echo  $package['start_date'].' - '.$package['valid_date']?></p>
       </div>
       <div class="new_package_details_right"><span>免费</span></div>
    </div>
      <!-- 获取货包状态 -->
    <div class="new_package_get_status">
        <!-- 领不到 -->
        <p>很抱歉，来晚了，货包已过期</p>
      
      
    </div>
</div>
<?php             
        }
        //货包过期了
        else if(!$gain_package_num){
?>
 <div class="package_scene_two" >
      <!-- 货包详情 -->
    <div class="new_package_details">
       <div class="new_package_details_left">
           <p><?php echo  $package['tribe_package_name']?></p>
           <p><?php echo  $package['tribe_package_desc']?></p>
           <p><?php echo  $package['start_date'].' - '.$package['valid_date']?></p>
       </div>
       <div class="new_package_details_right"><span>免费</span></div>
    </div>
      <!-- 获取货包状态 -->
    <div class="new_package_get_status">
        <!-- 领不到 -->
        <p>很抱歉，来晚了，货包已领完</p>
    </div>
</div>     
<?php 
        }else if(isset($sub_package_info) && count($sub_package_info) >0){
        //未领取货包
        //领取货包页面
?> 
 <!-- 状态一：领取货包 -->
 <div class="package_scene_one">
   <!-- 货包图片 -->
   <div class="new_tribe_package_img"><img src="<?php echo IMAGE_URL.$package['image'];?>"></div>   
   <!-- 好友／货包名 -->
   <div class="new_tribe_package_name">
       <p>您的好友“<?php echo  $share_user['wechat_nickname'] ? $share_user['wechat_nickname'] : $mobile = substr_replace($share_user['mobile'],'********',2,8);?>”</p>
       <p>发出<?php echo  $package['tribe_package_name']?>，快去抢吧</p>
   </div>
   <!-- 免费领取按钮 -->
   <div class="new_tribe_package_but"><a href="javascript:sub_package_info();">免费领取</a></div>
</div> 
<?php   
         }
    }
}else{
//是易货微信会员没绑定手机
?>
<!-- 状态一：领取货包 -->
 <div class="package_scene_one">
   <!-- 货包图片 -->
   <div class="new_tribe_package_img"><img src="<?php echo IMAGE_URL.$package['image'];?>"></div>   
   <!-- 好友／货包名 -->
   <div class="new_tribe_package_name">
       <p>您的好友“<?php echo  $share_user['wechat_nickname'] ? $share_user['wechat_nickname'] : $mobile = substr_replace($share_user['mobile'],'********',2,8);?>”</p>
       <p>发出<?php echo  $package['tribe_package_name']?>，快去抢吧</p>
   </div>
   <!-- 手机号码／短信验证码 -->
   <div class="new_tribe_package_input">
       <p><em class="icon-phone1"></em><input name="mobile" type="tel" value="" maxlength="11" placeholder="请输入手机号码"></p>
       <p><em class="icon-lock"></em><input name="mobile_code" type="tel" value="" placeholder="请输入短信验证码"><input type="button" class="new_package_verification" value="获取验证码" id="get_mobile_code" onclick="settime();" style="color: rgb(252, 176, 69);" /></p>
   </div>
   <!-- 免费领取按钮 -->
   <div class="new_tribe_package_but"><a id="gain_package" href="javascript:void(0);">免费领取</a></div>
</div> 

<?php  
}
?>
    <!-- 看看小伙伴的手气 -->
    <div class="tribe_prize_record">
        <div class="tribe_record_title">
            <fieldset class="scheduler_border">
              <legend class="scheduler_border1">看看小伙伴的手气</legend>
            </fieldset>
        </div>
        <div class="new_tribe_package_peoper"><span>(已领<?php echo $surplus_num;?>/<?php echo $package['quanity']?>个)</span></div>
        <!-- 列表 -->
        <div class="tribe_prize_record_list" style="display: block">
             <?php if(count($gain_package_list) >0){ ?>
                   <ul>
             <?php 
             foreach ($gain_package_list as $key => $val){
                 ?>
               <li>
                <img src="<?php echo $val['wechat_avatar']?>" onerror="this.src='images/member_defult.png'" alt="">
                <span><i><?php echo $val['wechat_nickname']? $val['wechat_nickname']:"五一易货网会员"?></i><i><?php echo $val['place_at']?></i></span>
                <div class="new_tribe_package_text">
                	<span><?php echo $val['reply'];?></span>
                	<?php  if(!empty($val['crop_id'])){ ?>
                	    <a href="<?php echo site_url('Home/GetShopGoods').'/'.$val['crop_id'];?>"><em class="icon-dianpu"></em>进入店铺</a>
                	<?php }?>
                </div>
               </li>
             <?php  } ?>
              </ul>
            <?php  }else{ ?>
            <!-- 状态：没人领取 -->
            <div style="text-align: center;margin-top: 5px;" >还没有人领取哦！赶紧领取吧！！</div>
            <?php }?>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/verificationCode.js"></script>
<script type="text/javascript">
// 发送验证码
 
function settime() { 
        //获取验证码js
        var type = 255;
        var mobile = $("input[name='mobile']").val();
        if(!mobile){
            $(".black_feds").text("请输入手机号码！").show();
            setTimeout("prompt();", 2000);
            return;
            }
        var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
        //验证手机
        if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
            $(".black_feds").text("请输入正确手机号").show();
            setTimeout("prompt();", 2000);
            return;
            }
        send_code(type,mobile);
          } 
function send_code(type,mobile){
	 $(".black_feds").text("正在发送验证码...").show();
	 $.ajax({
			url: '<?php echo  site_url("Customer/ajax_send");?>'+'/'+type,
			type: 'POST',
			data:{'mobile':mobile},
			dataType: 'html',
			success: function(data){
				$('#get_mobile_code').attr("disabled",true);
				$(".black_feds").hide();
				$('#get_mobile_code').css('color','#262626');
				$('#get_mobile_code').val('重新发送(90s)');
				$(".black_feds").text(data).show();
				setTimeout("prompt();", 2000);
				setTimeout(remainTime,1000);
			},
	    error:function(){
			$(".black_feds").text("网络出错，请重试！").show();
			setTimeout("prompt();", 2000);
			return;
		}
	});
}

      // 点击免费领取
      $('#gain_package').on('click',function(){

    	  var mobile = $("input[name='mobile']").val();
          if(!mobile){
              $(".black_feds").text("请输入手机号码！").show();
              setTimeout("prompt();", 2000);
              return;
              }
          var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
          //验证手机
          if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
              $(".black_feds").text("请输入正确手机号").show();
              setTimeout("prompt();", 2000);
              return;
              }
          
         var mobile_code = $("input[name='mobile_code']").val();
         if(!mobile_code){
            $(".black_feds").text("请输入短信验证码！").show();
            setTimeout("prompt();", 2000);
            return;
            }

         $.ajax({
  			url: '<?php echo  site_url("Activity/Tribe_package/gain_package");?>',
  			type: 'POST',
  			data:{'mobile':mobile,share_id:<?php echo $package['id'];?>,yzm:mobile_code,package_id:<?php echo $package['tribe_package_id']?>},
  			dataType: 'json',
  			success: function(data){
  				$(".black_feds").text(data.Message).show();
  				setTimeout("prompt();", 2000);
  				setTimeout(function(){
  					window.location.reload();
  					}, 2000);
  				
  			},
  	    error:function(){
  			$(".black_feds").text("网络出错，请重试！").show();
  			setTimeout("prompt();", 2000);
  			return;
  		}
      });
         
      })
function sub_address(){
    	  var share_id = <?php echo $package['id'];?>;
    	  var name = $("#adres_name").val();
    	  var parten = /^\s*$/ ; 
    	  if(parten.test(name)){
    		  $(".black_feds").text("真实姓名不能为空！").show();
  			  setTimeout("prompt();", 2000);
  			  return;
        	  }
  		  if(!name){
  			$(".black_feds").text("请输入真实姓名！").show();
  			setTimeout("prompt();", 2000);
  			return;
  			}
    	  var mobile = $("#adres_mobile").val();
    	  if(!mobile){
  			$(".black_feds").text("请输入手机号码！").show();
  			setTimeout("prompt();", 2000);
  			return;
  	    	}
  		 var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
  		 if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
  			$(".black_feds").text("请输入正确手机号").show();
  			setTimeout("prompt();", 2000);
  			return;
  			}
   		var adres = $("#adress").val();
  		if(!adres){
  			$(".black_feds").text("请输入详细地址").show();
  			setTimeout("prompt();", 2000);
  			return;
  			}
  		if(!share_id){
  			$(".black_feds").text("保存数据错误,请刷新页面重新填写").show();
  			setTimeout("prompt();", 2000);
  			return;
  			}  
  		$.ajax({
			url: '<?php echo  site_url("Activity/Tribe_package/confirm_to_receive");?>',
			type: 'POST',
			data:{address:adres,share_id:<?php echo $package['id'];?>,real_name:name,mobile:mobile},
			dataType: 'json',
			success: function(data){
				if(data['status'] == 2){
					$(".black_feds").text("正在进入<?php echo $tribe['name'];?>").show();
					setTimeout("prompt();", 2000);
					setTimeout(function(){
						window.location.href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>";
						}, 2200);
					}else{
						$(".black_feds").text(data.Message).show();
						setTimeout("prompt();", 2000);
						return;
						}
			},
	    error:function(){
			$(".black_feds").text("网络出错，请重试！").show();
			setTimeout("prompt();", 2000);
			return;
		}
			});
          }


 <?php if(isset($sub_package_info) && count($sub_package_info) >0){ ?>
     function sub_package_info(){
    	 $.ajax({
  			url: '<?php echo  site_url("Activity/Tribe_package/gain_pack_staff")."/".$sub_package_info['tribe_package_id']."/json/".$sub_package_info['user_id']."/".$sub_package_info['mobile']."/".$sub_package_info['share_id'];?>',
  			type: 'GET',
  			dataType: 'json',
  			success: function(data){
  						$(".black_feds").text(data.Message).show();
  						setTimeout("prompt();", 2000);
  						setTimeout(function(){
							window.location.reload();
  	  						},2200);
  						return;
  			},
  	    error:function(){
  			$(".black_feds").text("网络出错，请重试！").show();
  			setTimeout("prompt();", 2000);
  			return;
  		}
  			});
         }
 <?php }?>
          
</script>














