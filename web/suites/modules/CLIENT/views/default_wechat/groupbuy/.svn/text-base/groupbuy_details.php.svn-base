<?php 
$user_id = $this->session->userdata('user_id');
$signPackage = $this->js_api_sdk->getSignPackage();
?>

<style type="text/css">
  .container {background: #F3F3F3!important;}
  @media screen and (max-width:320px) {
  .groupbuy_details_player {
    width: 39%!important;
  }
}
</style>
  <!-- 拼团详情页 开始 -->
    <div style="">
        <div style="background: #F3F3F3;text-align: center;">
        <span style="padding: 15px 0;display: inline-block;"><span class="icon-tuandui" style="font-size: 25px;color: #FECF0A;vertical-align:middle;"></span><span style="color: #383838;font-size: 15px;padding-left: 10px;">快来入团吧</span></span>
        </div>
        
        <section style="background:#fff;border-bottom: 1px solid #DEDFDE;">
            <div style="padding-bottom: 0px;margin: 10px 10px 0 10px;background:#fff;border-bottom: 1px solid #DEDFDE;">
                <div class="good_list clearfix" style="margin-bottom: -15px;">
                    <div class="fn-left relative">
                    <a href="<?php echo site_url('goods/detail/'.$product['id'].'/0/groupbuy');?>" style="width: 100%;display: -webkit-inline-flex;display: inline-flex;overflow-x: scroll; margin-bottom: 10px;"><img style="border: 1px solid #ccc;padding:1px;" src="<?php echo IMAGE_URL.$product['goods_thumb']?>" width="62" height="83" onerror="this.src='images/default_img_b.jpg'" class="good_list_img" onerror="this.src='images/default_img_s.jpg'">
                    <p class="fn-14 goods_list_text"><?php echo $product['name']?></p>
                    </a>
                    <p class="fn-14" style="float: left;font-size: 16px!important;margin-left: 90px;margin-top: -60px;"> 数量：<?php echo $qty['quantity']?><span style="font-size: 13px;"></span></p>
                    <p class="fn-14" style="float: left;font-size: 16px!important;margin-left: 90px;margin-top: -40px;">单价：<?php echo $product['groupbuy_price']?><span style="font-size: 13px;"></span><span style="font-size: 12px!important;padding-left: 4px;">货豆</span>&nbsp;</p>
                 
                    <p class="fn-12 c9" style="float: right;font-size: 13px!important;color: #707070!important;margin-top: -45px;border:1px solid #9D9D9D;padding:0px 8px;"><?php echo $product['menber_num']?>人团</p>
                    </div> 
                </div>
            </div>
        </section>
        
        <div style="text-align: center;background:#F3F3F3;padding:20px 0;">
        <?php if(count($member) < $product['menber_num']){;?>
            <?php if($product['groupbuy_end_at'] > date("Y-m-d H:i:s")){?>
            <span style="font-size: 15px;color:#262626;">还差<span><?php echo $product['menber_num']-count($member);?></span>人，下一位会是你吗？</span>
            <?php }else{ ?>
            <span style="font-size: 15px;color:#262626;">拼团失败，系统将会在24小时内退货豆到您的51易货网账户</span>
            <?php };?>
        <?php }else{?>
        <span style="font-size: 15px;color:#262626;">哞哞在积极安排发货，请注意查收</span>
        <?php };?>
        <div style="margin-top: 15px;">
        <span style="display: inline-block;font-size: 15px;color:#262626;">剩余&nbsp;<span><span class="flagship_time" id="int_day"  style="background:#D5D5D5;border-radius: 2px;padding:0 2px;">00</span>&nbsp;天&nbsp;<span class="flagship_time" id="hour"  style="background:#D5D5D5;border-radius: 2px;padding:0 2px;">00</span>&nbsp;时&nbsp;<span class="flagship_time" id="min" style="background:#D5D5D5;border-radius: 2px;padding:0 2px;">00</span>&nbsp;分&nbsp;</span><span class="flagship_time" id="miao" style="background:#D5D5D5;border-radius: 2px;padding:0 2px;">00</span><span>&nbsp;秒&nbsp;结束</span></span>
        </div>
        </div>


    <!-- 人员列表 -->
    <div style="background:#fff;">
       <!-- 团员  -->
        <?php //print_r($member);?>
        <?php $i=0;$a=0;foreach ($member as $v){?>
            <?php if($v['customer_id'] == $product['head_menber'] || $v['customer_id']==$user_id){;?><!-- 只显示团长和自己 -->
            <div style="position: relative;padding:10px;border-bottom: 1px solid #D5D5D5;font-size: 16px;color:#5B5B5B;">
            <?php if($v['customer_id'] == $product['head_menber']){?><!-- 团长标志 -->
            <span class="icon-tubiao27" style="color:#FED824;position: absolute;top: 0px;left:25px;"></span>
            <?php }else{$a = 1;};?>
            <img src="<?php echo $v['wechat_avatar']?$v['wechat_avatar']:"images/head.png"; ?>" alt="" style="display: inline-block;border: 1px solid #ccc;border-radius: 50%;width:45px;height: 45px;" onerror="this.src='images/default_img_s.jpg'"><span style="padding-left: 10px;"><?php echo mb_substr($v['wechat_nickname'],0,1);?>**</span>
            <span style="position: absolute;right:10px;top: 25px;"><span><?php echo $v['place_at']?></span><span> &nbsp;<?php echo $v['customer_id'] == $product['head_menber']?'开团':"入团";?></span></span>
            </div>
            <?php $i++;};?>
        <?php };?>
       

        <?php foreach ($member as $v){?>
            <?php if($v['customer_id'] != $product['head_menber'] && $v['customer_id']!=$user_id && $i<$product['menber_num']){;?><!-- 随机显示团员除团长和自己（不能超过团总数） -->
            <div style="position: relative;padding:10px;border-bottom: 1px solid #D5D5D5;font-size: 16px;color:#5B5B5B;">
              <img src="<?php echo $v['wechat_avatar']?$v['wechat_avatar']:"images/head.png"; ?>" alt="" style="display: inline-block;border: 1px solid #ccc;border-radius: 50%;width:45px;height: 45px;" onerror="this.src='images/default_img_s.jpg'">
              <span style="padding-left: 10px;">
              <?php echo $v['wechat_nickname']?mb_substr($v['wechat_nickname'],0,1).'**':substr($v['name'],0,3).'****'.substr($v['name'],-3); ?></span>
             <span style="position: absolute;right:10px;top: 25px;"><span><?php echo $v['place_at']?></span><span> &nbsp;<?php echo $v['customer_id'] == $product['head_menber']?'开团':"入团";?></span></span>
            </div>
            <?php $i++;};?>
        <?php };?>

    </div>

     <!-- 更多精彩拼团 -->
       <div style="padding: 15px 10px;position: relative;font-size: 15px;color:#2F2F2F;border-bottom: 1px solid #E4E4E4;background:#fff;margin-top: 10px;">
         <a href="<?php echo site_url('activity/groupbuy');?>"><span>更多精彩拼团</span><span style="position: absolute;right:10px;top:11px;"><span>全部</span><span class="icon-right" style="font-size: 20px;"></span></span></a>
       </div>


    <!-- 拼团底部 -->
    <div style="position: fixed;bottom:0;width:100%;">
      <ul>

            <?php if($product['groupbuy_end_at'] > date("Y-m-d H:i:s")){?><!-- 不过期 -->
            
                <?php if(count($member) < $product['menber_num']){?><!-- 团不满 -->
                    <?php if($a || $product['head_menber'] == $user_id){;?><!-- 已参团 -->
                    <a href="javascript:void(0);" ><li style="display: inline-block;width:29%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;">开团</li></a>
                    <a href="javascript:share();"  ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">召集团友</li></a>
                    <a href="javascript:void(0);" ><li style="display: inline-block;width:40%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;" class="groupbuy_details_player">已参团</li></a>
                    <?php }else{;?><!-- 未参团 -->
                    <a href="<?php echo site_url('activity/groupbuy/groupbuy_confirm').'/'.$product['id']."/0";?>" ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">开团</li></a>
                    <a href="javascript:share();"  ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">召集团友</li></a>
                    <a href="<?php echo site_url("activity/groupbuy/groupbuy_confirm").'/'.$product['id'].'/'.$product['buy_num'];?>" ><li style="display: inline-block;width:40%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;" class="groupbuy_details_player">参团</li></a>
                    <?php };?>

                <?php }else{ ?><!-- 团满 -->
                    <?php if($a || $product['head_menber'] == $user_id){;?>
                    <a href="javascript:void(0);" ><li style="display: inline-block;width:29%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;">开团</li></a>
                    <?php }else{;?>
                    <a href="<?php echo site_url('activity/groupbuy/groupbuy_confirm').'/'.$product['id']."/0";?>" ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">开团</li></a>
                    <?php };?>
                    <a href="javascript:share();" ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">召集团友</li></a>
                    <a href="javascript:void(0);" ><li style="display: inline-block;width:40%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;" class="groupbuy_details_player">已满团</li></a>
                <?php };?>
                
            <?php }else{;?><!-- 已过期 -->
                  <a href="javascript:void(0);" ><li style="display: inline-block;width:29%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;">开团</li></a>
                  <a href="javascript:share();" ><li style="display: inline-block;width:29%;background:#FECF0A;text-align: center;line-height: 50px;font-size: 15px;">召集团友</li></a>
                  <a href="javascript:void(0);" ><li style="display: inline-block;width:40%;background:#ccc;text-align: center;line-height: 50px;font-size: 15px;" class="groupbuy_details_player">团购已结束</li></a>
            <?php };?>    
      </ul>
    </div>


  </div> <!-- 拼团详情页 结束 -->

<div id="mcover" onclick="document.getElementById('mcover').style.display='';" style="display: none;">
     <img src="images/share.png">
</div>



    <!-- 倒计时 -->
<script>
<?php 
$start = strtotime($product['groupbuy_start_at']);
$end = strtotime($product['groupbuy_end_at']);
?>;







    function countdown() {
        var time_start = new Date().getTime(); //设定当前时间
    	var time_end =  "<?php echo $end*1000;?>"; //设定目标时间
    	// 计算时间差 
    	
    	var time_distance = time_end - time_start; 
    	if(time_start >= time_end){
        	window.location.reload();
        	return;
        	}
//     	alert(time_distance);
    	// 天
    	var int_day = Math.floor(time_distance/86400000) 
    	time_distance -= int_day * 86400000; 
    	// 时
    	var int_hour = Math.floor(time_distance/3600000) 
    	time_distance -= int_hour * 3600000; 
    	// 分
    	var int_minute = Math.floor(time_distance/60000) 
    	time_distance -= int_minute * 60000; 
    	// 秒 
    	var int_second = Math.floor(time_distance/1000) 
    	// 时分秒为单数时、前面加零 
    	if(int_day < 10){ 
    		int_day = "0" + int_day; 
    	} 
    	if(int_hour < 10){ 
    		int_hour = "0" + int_hour; 
    	} 
    	if(int_minute < 10){ 
    		int_minute = "0" + int_minute; 
    	} 
    	if(int_second < 10){
    		int_second = "0" + int_second; 
    	} 

//     	alert(int_day+'天'+int_hour+'时'+int_minute+'分'+int_second+'秒');
    	document.getElementById("int_day").innerHTML=int_day;
        document.getElementById("hour").innerHTML=int_hour;
        document.getElementById("min").innerHTML=int_minute;
        document.getElementById("miao").innerHTML=int_second;
    }
    <?php if($end > time()){?>
    setInterval("countdown()", 900);
    <?php };?>

    function share(){
        $("#mcover").show();
        }
</script>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
    });


wx.ready(function(){

	  // 2. 分享接口
	  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口

	    wx.onMenuShareAppMessage({
	      title: '<?php echo "51易货网拼团";?>',
	      desc: '<?php echo $product['name'];?>',
	      link: '<?php echo site_url('activity/groupbuy/group_detail')."?buy_num=".$product['buy_num']."&head_menber=".$product['head_menber']."&productid=".$product['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$product['goods_thumb'];?>',
	      trigger: function (res) {
	        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
// 	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
// 	    alert('已注册获取“发送给朋友”状态事件');


	  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口

	    wx.onMenuShareTimeline({
		  title: '<?php echo "51易货网拼团";?>',
	      link: '<?php echo site_url('activity/groupbuy/group_detail')."?buy_num=".$product['buy_num']."&head_menber=".$product['head_menber']."&productid=".$product['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$product['goods_thumb'];?>',
	      trigger: function (res) {
	        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
// 	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
// 	    alert('已注册获取“分享到朋友圈”状态事件');
});


</script>

