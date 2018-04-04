<?php 
if(empty($label_app)){
	//只出现在微信浏览器
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
	//是否全局显示关注公众号LOGO
	    $user_id = $this->session->userdata("user_id");
	if(!$user_id){
	    //未登录
	    echo '<a href="javascript:void(0);" onclick="go_subscribe();" class="all_guanzhu"><img src="images/Group 7.png" alt=""></a>';
	}else{
	    $wechat_subscribe = $this->session->userdata("wechat_subscribe");
	    //未关注
	    if(!$wechat_subscribe || $wechat_subscribe == '0'){
	        $load = 1;
	        echo '<a href="javascript:void(0);" onclick="go_subscribe();" class="all_guanzhu"><img src="images/Group 7.png" alt=""></a>';
	    }
	  }
}

}?>
<script type="text/javascript">
$(function(){
	$('.float_btn').hide();//默认隐藏全部的文字
	$(".float_menu").click(function(){
		var span = $(this).find("span");
		if(span.hasClass("float_open")){
			$('.float_btn').hide();//默认隐藏全部的文字
			span.removeClass("float_open").addClass("float_close");
			  $(".float_menu").addClass("icon-guanbi");
			$(".float_btn").removeClass("float_open").addClass("float_close");
			$(".float_menu").removeClass("icon-guanbi").addClass("icon-jiahao");
		}else{
			$('.float_btn').show();//显示全部的文字
			span.removeClass("float_close").addClass("float_open");
			   $(".float_menu").addClass("icon-jiahao");
			$(".float_btn").removeClass("float_close").addClass("float_open");
			$(".float_menu").removeClass("icon-jiahao").addClass("icon-guanbi");
			
		}
	});
});

function  go_subscribe(){
	<?php
	echo 'window.location.href="'.site_url('Third_signin/subscribe').'"';
	?>
	
}

</script>
<script type="text/javascript" src="js/swipeslider.min.js"></script>
<script>

$(window).load(function() {
	$('#full_feature').swipeslider();
	$('#content_slider').swipeslider({
	transitionDuration: 600,
	autoPlayTimeout: 10000,
	sliderHeight: '300px'
	});
	$('#responsiveness').swipeslider();
	$('#customizability').swipeslider({
	transitionDuration: 1500, 
	autoPlayTimeout: 4000, 
	timingFunction: 'cubic-bezier(0.38, 0.96, 0.7, 0.07)',
	sliderHeight: '30%'});
});

function menu2(){
	if($('#other_nav').is(":hidden")){
		$('.other_nav').show()
	}else{
		$('.other_nav').hide()
	}
}

</script>

<!--浮动层－全网导航 end-->
<script>
    //广告图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });
</script>

	</body>
</html>