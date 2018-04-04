<style type="text/css">
.container {background: #d6d6d6;}
._citys { width: 100%; display: inline-block;background: #fff;position: relative; }
._citys span { display:none; color: #56b4f8; height: 15px; width: 15px; line-height: 15px; text-align: center; border-radius: 3px; position: absolute; right: 10px; top: 10px; border: 1px solid #56b4f8; cursor: pointer; }
._citys0 { width: 100%; height: 34px; display: inline-block; border-bottom: 2px solid #56b4f8; padding: 0; margin: 0; }
._citys0 li { display: inline-block; line-height: 34px; font-size: 15px; color: #888; width: 80px; text-align: center; cursor: pointer; }
.citySel { background-color: #56b4f8; color: #fff !important; }
._citys1 { width: 100%; display: inline-block; padding: 10px 0; }
._citys1 a { width: 30%; height: 35px; display: inline-block; background-color: #f5f5f5; color: #666; margin-left: 2.5%; margin-top: 3px; line-height: 35px; text-align: center; cursor: pointer; font-size: 13px; overflow: hidden; }
._citys1 a:hover { color: #fff; background-color: #56b4f8; }
.AreaS { background-color: #56b4f8 !important; color: #fff !important; }
#city{ width: 90%;padding: 0 0px 0 0;border: 1px solid #fff;background: none;outline: none;float: right;text-align: right;font-size: 15px;}
#PoPy{ width:100% !important; left:0px !important;}


</style>

<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>
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
<?php // echo  '<pre>';
// var_dump($gain_package_status);exit;?>
<!-- 部落活动 -->
<div class="tribe_active">
    <!-- 头部 -->
    <div class="tribe_active_head">
     	<img src=" <?php echo IMAGE_URL.$package['image'];?>" alt="">
       <!--  <img src="images/tirbe_active_head.png" alt=""> -->
    </div>
<?php if($gain_package_status){ //已领取 
   ?>
      <!-- 收货信息 s-->
    <div   id="fill_Message_part" >
        <div class="tribe_receiving">
            <div class="tribe_receiving_gongxi"><img src="images/tirbe_active_text01.png" alt=""></div>    
             <div class="tribe_receiving_prize"><span><?php echo $package['gift_name'];?></span></div>
            <!-- 填写收货人信息 -->
            <div class="tribe_receiving_information">
                <span class="tribe_receiving_information_title">请详细填写收货人信息，我们尽快安排给您发货！</span>
                <?php if($gain_package_info['name']){ ?>
                     <!-- 收货人： -->
               		 <div class="tribe_receiving_information_box">
                    <span style="padding-left: 7px;">收 货 人：</span><p><input type="text" id="adres_name" value="<?php echo $gain_package_info['name'] ?>" disabled placeholder="(请输入真实姓名)"></p>
                	</div>
                <?php  }else{ ?>
                     <!-- 收货人： -->
               		 <div class="tribe_receiving_information_box">
                    <span style="padding-left: 7px;">收 货 人：</span><p><input type="text" id="adres_name" value="" placeholder="(请输入真实姓名)"></p>
                	</div>
                 <?php }?>
                <?php if($gain_package_info['name']){ ?>
                     <!-- 联系电话： -->
                    <div class="tribe_receiving_information_box">
                        <span>联系电话：</span><p><input type="text" id="adres_mobile" disabled value="<?php echo $gain_package_info['mobile'] ?  $gain_package_info['mobile']:''; ?>" placeholder=""></p>
                    </div>
                <?php  }else{ ?>
                     <!-- 联系电话： -->
                    <div class="tribe_receiving_information_box">
                        <span>联系电话：</span><p><input type="text" id="adres_mobile"  value="" placeholder=""></p>
                    </div>
                <?php }?>
               
                <?php if($gain_package_info['address']){ ?>
                       <!-- 详细地址： -->
                <div class="tribe_receiving_information_box">
                    <span>详细地址：</span><p><input type="text" id="adres" disabled value="<?php echo $gain_package_info['address'];?>" placeholder="(请输入详细收货地址)"></p>
                </div>
                <?php }else{ ?>
                 <!-- 所在地区： -->
                <div class="tribe_receiving_information_box">
                    <span>所在地区：</span><p><span class="icon-right fn-right" style="padding-top: 2px;color: #666;"></span><input type="button" id="city" value="请选择"></p>
                </div>
                 <!-- 详细地址： -->
                <div class="tribe_receiving_information_box">
                    <span>详细地址：</span><p><input type="text" id="adres" value="" placeholder="(请输入详细收货地址)"></p>
                </div>
                 <?php  }?>
             
            </div>

            <div class="tribe_receiving_text">
               <p><span> * 注：</span>1、本次活动由【51易货网】提供支持；</p>   
               <p> 2、平台客服人员会在确认领取之后的三个工作日之内与您核实信息并发出快递，请保持手机畅通；</p>  
               <p> 3、详情可咨询：400-0029-777；</p>  
               <p> 4、欢迎您加入51易货网，祝您生活愉快！</p>    
            </div>
			<?php if($gain_package_info['type'] == 2){?>
			     <!-- 确认领取并进入部落 -->
            <a href="javascript:sub_address();" class="tribe_active_ok">确认领取并进入部落看看</a>
			<?php }else{ ?>
			 <!-- 确认领取并进入部落 -->
             <a href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>" class="tribe_active_ok">进入部落看看</a>
			<?php }?>
          
        </div>
    </div> <!-- 收货信息 e  -->      
<?php  }else if($mobile_exist){//已绑定手机 
        if( isset($return['status'])  && $return['status'] == 6  || isset($return['status'])  && $return['status'] == 11  ||  isset($return['status']) &&  $return['status'] == 12){
            ?>
     <div  id="gain_package_part">
        <!-- 奖品领取 -->
        <div class="tribe_active_prize">
            <div class="tribe_active_prize_main">
                <!-- 奖品 -->
                <div class="tribe_prize_sku">
                    <div class="prize_sku_box">
                        <div class="prize_sku_box_text">
                            <span><?php echo  $package['tribe_package_name']?></span>
                            <span><?php echo  $package['tribe_package_desc']?></span>
                        </div>
                        <i>免费</i>
                    </div>
                    <p>有效期至<?php echo  $package['valid_date']?></p>
                </div>
           <?php if($return['status'] == 12){ //填写真实姓名 ?>
              <!-- 请输入您的真实姓名 -->
                <div class="tribe_information_main">
              	<p class="tribe_active_num"><input type="text" name="mobile_real_name" value="" placeholder="请输入您的真实姓名" ></p> 
               </div>
              <div class="tribe_free_get"><a href="javascript:gain();">免费领取</a></div>
           <?php }else{ ?>
             <!-- 输入信息 -->
             <div class="tribe_information_main">
              <!-- 请输入您的手机号码   -->
              <p class="tribe_active_num"><input type="text" name="_mobile" value="" disabled placeholder="请输入您的手机号码" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")'></p> 
              <!-- 请输入您的真实姓名 -->
              <p class="tribe_active_num"><input type="text" name="_real_name" value="" placeholder="请输入您的真实姓名"  disabled></p> 
              <!-- 请输入验证码  -->
              <div class="tribe_active_code">
                <p><input type="text" name="mobile_vertify"  id="_captcha" value="" disabled placeholder="请输入验证码" onkeyup='this.value=this.value.replace(/\D/gi,"")'></p>
                <!--  <a id="get_mobile_code" href="javascript:void(0);">点击获取验证码</a>-->
                <input type="button" id="_get_mobile_code" disabled value="点击获取验证码" style="background: none;color: #fff;border: none;margin-top: 8px;font-size: 12px;margin-left: 5px;">
              </div>    
            </div>
           <!-- 免费领取 -->
         <div class="tribe_free_get"><a href="javascript:void(0);">免费领取</a></div>
           <?php }?>     
         </div>
     </div>
     
     <?php if(isset($return['status'])  && $return['status'] != 12){ ?>
          <!-- 提示弹窗 -->
         <div class="tribal_active_ball" >
            <div class="tribal_active_ball_main">
                <div class="tribal_active_ball_text">
                    <!-- 关闭 -->
                    <?php if( isset($return['status'])  && $return['status'] == 6){ ?>
                        <!--  <i class="icon-guanbi"></i> -->
                         <?php if(strpos($tribe['name'],'部落')){
                                $name  = str_replace('部落', '', $tribe['name']);
                             ?>
                             <span>正在进入【<?php echo $name;?>】部落</span>
                        <?php }else{ ?>
                            <span>正在进入【<?php echo $tribe['name'];?>】部落</span>
                       <?php  }?>
                        <span>审核中请耐心等待......</span>
                        <span>更多活动敬请关注【51易货网】</span>   
                    <?php }else{ ?>
                        <!--  <i class="icon-guanbi"></i> -->
                        <span>审核未通过，领取失败！</span>
                        <span>更多活动敬请关注【51易货网】</span>   
                     <?php }?> 
    
                </div>    
            </div>
         </div>
      <?php  }?>
     
<?php }else {?>
    <!-- 领取 s -->
    <div  id="gain_package_part">
    <!-- 奖品领取 -->
    <div class="tribe_active_prize">
        <div class="tribe_active_prize_main">
            <!-- 奖品 -->
            <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span><?php echo  $package['tribe_package_name']?></span>
                        <span><?php echo  $package['tribe_package_desc']?></span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至<?php echo  $package['valid_date']?></p>
            </div>
              <div class="tribe_free_get" style="background: #aaa;"><a href="javascript:void(0);"   style="font-size: 14.5px;color: #fff;"   >很抱歉，您来晚了，货包已经领完了！</a></div>
          </div>
      	<div class="tribe_free_get" style="position: inherit;margin: auto; width: 83%;margin-top: 30px;"><a href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>"   style="font-size: 14.5px;"   >进入部落</a></div>
    </div>
<?php } }else{  //未领取?>
<!-- 领取 s -->
    <div  id="gain_package_part">
    <!-- 奖品领取 -->
    <div class="tribe_active_prize">
        <div class="tribe_active_prize_main">
            <!-- 奖品 -->
            <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span><?php echo  $package['tribe_package_name']?></span>
                        <span><?php echo  $package['tribe_package_desc']?></span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至<?php echo  $package['valid_date']?></p>
            </div>
         
         <?php 
         //可领取
         if($gain_package_surplus){?>
              <!-- 输入信息 -->
             <div class="tribe_information_main">
              <!-- 请输入您的手机号码   -->
              <p class="tribe_active_num"><input type="text" name="mobile" value="" placeholder="请输入您的手机号码" maxlength="11" onkeyup='this.value=this.value.replace(/\D/gi,"")'></p> 
              <!-- 请输入您的真实姓名 -->
              <p class="tribe_active_num"><input type="text" name="real_name" value="" placeholder="请输入您的真实姓名" ></p> 
              <!-- 请输入验证码  -->
              <div class="tribe_active_code">
                <p><input type="text" name="mobile_vertify"  id="captcha" value="" placeholder="请输入验证码" onkeyup='this.value=this.value.replace(/\D/gi,"")'></p>
                <!--  <a id="get_mobile_code" href="javascript:void(0);">点击获取验证码</a>-->
                <input type="button" id="get_mobile_code" value="点击获取验证码" style="background: none;color: #fff;border: none;margin-top: 8px;font-size: 12px;margin-left: 5px;">
              </div>    
            </div>
            <!-- 免费领取 -->
         <div class="tribe_free_get"><a href="javascript:gain_pack();">免费领取</a></div>
         </div>
     </div>
         <?php }else{//已领取完 ?>
            <div class="tribe_free_get" style="background: #aaa;"><a href="javascript:void(0);"   style="font-size: 14.5px;color: #fff;"   >很抱歉，您来晚了，货包已经领完了！</a></div>
          </div>
      	<div class="tribe_free_get" style="position: inherit;margin: auto; width: 83%;margin-top: 30px;"><a href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>"   style="font-size: 14.5px;"   >进入部落</a></div>
    </div>
        <?php  }?>
<?php }?>
  
<!-- 看看领包记录 -->
    <div class="tribe_prize_record">
        <div class="tribe_record_title">
            <fieldset class="scheduler_border">
              <legend class="scheduler_border1">看看领包记录</legend>
            </fieldset>
        </div>
        <!-- 列表 -->
        <div class="tribe_prize_record_list">
            <ul>
            <?php if(count($gain_package_list) >0){
                foreach ($gain_package_list as $key => $val){
                ?>
                 <li><img src="<?php echo $val['wechat_avatar']?>" onerror="this.src='images/member_defult.png'" alt=""><span><i><?php echo $val['wechat_nickname']? $val['wechat_nickname']:"五一易货网会员"?></i><!-- <i>158.00元</i> --></span><span><?php echo $val['place_at']?></span></li>
            <?php   }  }else{?>
               <div style="text-align: center;margin-top: 5px;">还没有人领取哦！赶紧领取吧！！</div>
            <?php }?>
            </ul>
        </div>
    </div>

</div><!-- 领取 e -->



</div>
<script type="text/javascript" src="js/verificationCode.js"></script>
<script type="text/javascript">
$("#city").click(function (e) {
    SelCity(this,e);
});
</script>

<script type="text/javascript">
var show_status = 2;
$(".tribe_prize_record_list").show();
    $(".tribe_record_title").on("click",function(){
        if(show_status == 1){
        	show_status = 2
            $(".tribe_prize_record_list").show();
            }else{
            	show_status = 1
                $(".tribe_prize_record_list").hide();
                }
    	
    })
  $(".icon-guanbi").click(function(){
			window.location.href="<?php echo site_url("Home")?>";
	  });
    //获取验证码js
    $("#get_mobile_code").click(function(){
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
    	var get_code_id = "#get_mobile_code";
       
        send_code(type,mobile);
    	
    })
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
 <?php if(isset($return['status']) && $return['status'] == 12){ ?>
 function gain(){
		var mobile_real_name = $("input[name='mobile_real_name']").val();
		if(!mobile_real_name){
			$(".black_feds").text("请输入真实姓名！").show();
			setTimeout("prompt();", 2000);
			return;
			}
		 $.ajax({
				url: '<?php echo  site_url("Activity/Tribe_package/package_add_staff");?>',
				type: 'POST',
				data:{'mobile':<?php echo  $apply['mobile'];?>,member_name:mobile_real_name,tribe_id:<?php echo  $apply['tribe_id'];?>},
				dataType: 'json',
				success: function(data){
					$(".black_feds").text(data.Message).show();
					setTimeout("prompt();", 2000);
					if(data.status == 2){
						setTimeout(function(){
							window.location.reload();
							}, 2000);
						}
				},
		    error:function(){
				$(".black_feds").text("网络出错，请重试！").show();
				setTimeout("prompt();", 2000);
				return;
			}
		});
	}
 <?php }?>


function   gain_pack(){
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
	var yzm = $("#captcha").val();
	if(!yzm){
		$(".black_feds").text("请输入验证码").show();
		setTimeout("prompt();", 2000);
		return;
		}
	var real_name = $("input[name='real_name']").val();
	if(!real_name){
		$(".black_feds").text("请输入真实姓名").show();
		setTimeout("prompt();", 2000);
		return;
		}
	 $.ajax({
			url: '<?php echo  site_url("Activity/Tribe_package/gain_package");?>',
			type: 'POST',
			data:{'mobile':mobile,share_id:<?php echo $package['id'];?>,real_name:real_name,yzm:yzm,package_id:<?php echo $package['tribe_package_id']?>},
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

	
}  

function sub_address(){
	var share_id = <?php echo $package['id'];?>;
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
	var name = $("#adres_name").val();
	if(!name){
		$(".black_feds").text("请输入真实姓名").show();
		setTimeout("prompt();", 2000);
		return;
		}
	var adres = $("#adres").val();
	if(!adres){
		$(".black_feds").text("请输入详细地址").show();
		setTimeout("prompt();", 2000);
		return;
		}
	var city = $("#city").val();
	if(!city){
		$(".black_feds").text("请选择所在地区").show();
		setTimeout("prompt();", 2000);
		return;
		}
	var load_address = city+adres;
	if(!load_address){
		$(".black_feds").text("地址信息错误").show();
		setTimeout("prompt();", 2000);
		return;
		}
	if(!share_id){
		$(".black_feds").text("保存失败,请刷新页面重新填写").show();
		setTimeout("prompt();", 2000);
		return;
		}
	 $.ajax({
			url: '<?php echo  site_url("Activity/Tribe_package/confirm_to_receive");?>',
			type: 'POST',
			data:{address:load_address,share_id:<?php echo $package['id'];?>,real_name:name,mobile:mobile},
			dataType: 'json',
			success: function(data){
				if(data['status'] == 2){
					$(".black_feds").text("保存信息成功！").show();
					setTimeout("prompt();", 2000);
					window.location.href="<?php echo site_url('Tribe/home').'/'.$package['tribe_id'];?>";
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
</script>



