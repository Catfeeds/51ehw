
<div class="essay_share_details">
	<!-- 标题 -->
	<div class="essay_share_details_title">
		<span><?php echo $detail['title']?></span>
	</div>
	<!-- 时间／作者 -->
	<div class="essay_share_details_time">
		<span><?php echo $detail['create_at']?></span><a href="<?php echo site_url('Home')?>" class="essay_details_use">善活精英</a >
	</div>
	<!-- 文章内容 -->
	<div class="essay_share_details_main">
		<?php  echo $detail['content']; ?>
		<!-- 图片文字 -->
<!-- 	    <img src="images/default_img_s.jpg" onerror="this.src='images/default_img_s.jpg'"> -->
<!-- 	    <span>复古的风格的反馈结果的反馈结果的考试过了哦儿惹我惹我荛我日好二好尴尬过后你让我感觉腹背受敌疯狂的考试</span> -->
<!-- 	    <img src="images/default_img_s.jpg" onerror="this.src='images/default_img_s.jpg'"> -->
<!-- 	    <span>复古的风格的反馈结果的反馈结果的考试过了哦儿惹我惹我荛我日好二好尴尬过后你让我感觉腹背受敌疯狂的考试</span> -->
<!-- 	    <img src="images/default_img_s.jpg" onerror="this.src='images/default_img_s.jpg'"> -->
<!-- 	    <span>复古的风格的反馈结果的反馈结果的考试过了哦儿惹我惹我荛我日好二好尴尬过后你让我感觉腹背受敌疯狂的考试</span> -->
	</div>	
    <!-- 二维码 -->
    	<div class="essay_share_ma">
    	 <?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
    	  		<img id="invite" src="<?php echo base_url().'uploads/C/uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$code_parent.".png"?>" alt="" width="300">
    	  <?php }else{?>
    	  		<img id="invite" src="<?php echo IMAGE_URL.'uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$code_parent.".png"?>" alt="" width="300">
    	  <?php }?>
    		<p class="text-center">
    			让朋友扫一扫二维码，将主页分享给TA
    		</p>
    	</div>	

</div>


<script>
//分享
function share(){
	<?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
		window.location.href="<#share_article#>name=<?php echo $detail['title'];?>@logo=<?php echo base_url().'uploads/C/'.$detail['logo'];?>@desc=<?php echo $detail['desc'];?>@url=<?php echo site_url('shop/skipping')."?id=".$communal."&type=".$type."&parent=".base64_encode($code_parent)."&mark=".base64_encode(2);?>";
	  <?php }else{?>
	    window.location.href="<#share_article#>name=<?php echo $detail['title'];?>@logo=<?php echo IMAGE_URL.$detail['logo'];?>@desc=<?php echo $detail['desc'];?>@url=<?php echo site_url('shop/skipping')."?id=".$communal."&type=".$type."&parent=".base64_encode($code_parent)."&mark=".base64_encode(2);?>";
	  <?php }?>	
}
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<?php
if($this->session->userdata('app_info')['wechat_appid'] != NULL):
	$this->load->library("js_api_sdk");
    $this->js_api_sdk = new js_api_sdk();
	$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
	$signPackage = $this->js_api_sdk->GetSignPackage();
	?>
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
            'onMenuShareAppMessage',
          ]
    });
  
wx.ready(function(){

	 wx.onMenuShareAppMessage({
		 
		 });

	  // 2. 分享接口
	  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口

	    wx.onMenuShareAppMessage({
	      title: '<?php echo $detail['title'];?>',
	      desc: '<?php echo $detail['desc'];?>',
	      link: '<?php echo site_url('shop/skipping')."?id=".$communal."&time=".$time."&type=".$type."&parent=".base64_encode($code_parent)."&mark=".base64_encode(2);?>',
		 <?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
		  imgUrl: '<?php echo base_url().'uploads/C/'.$detail['logo'];?>',
		 <?php }else{?>
		  imgUrl: '<?php echo IMAGE_URL.$detail['logo'];?>',
		 <?php }?>	
	      
	      trigger: function (res) {
	        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
// 	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
// 	        alert('已分享');
	    	  //异步添加分享记录
	    	  $.ajax({
    	    	    url:'<?php echo site_url("Article/ajax_add_share") ?>',
    		  	    dataType:'json',
    		  	    type:'post',
    		  	    data:{
        		  	    <?php if($code_parent == base64_decode($parent)){ ?>
        		  	        parent: "<?php echo base64_encode(0)?>",//自己
        		  	    <?php }else{?>
          		  	  		parent: "<?php echo base64_encode($code_parent);?>",
    		  	    	<?php }?>
    		  	    	type :   "<?php echo $type;?>",
    		  	    	communal :   "<?php echo $communal;?>",
   		  	    	    time :   "<?php echo $time;?>"			
    		  		    },
    		  		success:function(data){
//    		 	        alert('记录分享成功');
        		  		},
    		  		error:function(){
//    		 	        alert('记录分享失败');
        		  		}
	    	  })
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
	   	  title: '<?php echo $detail['title'];?>',
		  link: '<?php echo site_url('shop/skipping')."?id=".$communal."&time=".$time."&type=".$type."&parent=".base64_encode($code_parent)."&mark=".base64_encode(2);?>',
		  <?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
		  imgUrl: '<?php echo base_url().'uploads/C/'.$detail['logo'];?>',
		  <?php }else{?>
		  imgUrl: '<?php echo IMAGE_URL.$detail['logo'];?>',
		  <?php }?>	
		 
	      trigger: function (res) {
	        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
// 	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
// 	        alert('已分享');
	    	  //异步添加分享记录
	    	  $.ajax({
    	    	    url:'<?php echo site_url("Article/ajax_add_share") ?>',
    		  	    dataType:'json',
    		  	    type:'post',
    		  	    data:{
    		  	    	<?php if($code_parent == base64_decode($parent)){ ?>
        		  	        parent: "<?php echo base64_encode(0)?>",//自己
        		  	    <?php }else{?>
          		  	  		parent: "<?php echo base64_encode($code_parent);?>",
    		  	    	<?php }?>
    		  	    	type :   "<?php echo $type;?>",
    		  	    	communal :   "<?php echo $communal;?>",
   		  	    	    time :   "<?php echo $time;?>"			
    		  		    },
    		  		success:function(data){
//    		 	        alert('记录分享成功');
        		  		},
    		  		error:function(){
//    		 	        alert('记录分享失败');
        		  		}
	    	  })
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
<?php
		 endif;
		?>