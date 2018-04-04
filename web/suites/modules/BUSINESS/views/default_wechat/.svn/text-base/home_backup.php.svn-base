
<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>

<!-- 画廊相关css -->
<style type="text/css">
.main_visual{height:422px;overflow:hidden;position:relative;}
.main_image{height:422px;overflow:hidden;position:relative;}
.main_image ul{width:9999px;height:422px;overflow:hidden;position:absolute;top:0;left:0}
.main_image li{float:left;width:100%;height:422px;}
.main_image li span{display:block;width:100%;height:422px}
.main_image li a{display:block;width:100%;height:422px}
div.flicking_con{position:absolute;top:360px;left:50%;z-index:999;height:21px;}
div.flicking_con a{float:left;width:6px;height:6px;margin:0;padding:0;display:block;text-indent:-1000px;background: #ccc;border: 1px  solid #fff;margin-left: 10px;border-radius: 50%;}
div.flicking_con a:nth-child(1) {margin-left: 0!important;}
div.flicking_con a.on{background: #FDCF0C;border: 1px solid #FDCF0C;}
#btn_prev,#btn_next{z-index:11111;position:absolute;display:block;width:73px!important;height:74px!important;top:50%;margin-top:-37px;display:none;}
.icon_xiaoxi {position: fixed;right: 10px;top: 15px;z-index: 999;color: #fff;font-size: 25px;}
.info_dian {width: 10px;height: 10px;background: red;display: inline-block;border-radius: 50%;position: absolute;right: -2px;top: -4px;}
.nav_search {width: 58%;overflow: hidden;}
@media screen and (max-width:320px) {
  .nav_search {width: 55%;}
  .nav_sort {margin-right: 10px;}
}
.box_ball {position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,0.5);top: 0;z-index: 999;}
.forget-password {background: #fff;padding: 25px 20px 20px 20px;position: fixed;top: 0px;left: 10%;width: 80%;margin:0;z-index: 999;}
.password-text span {line-height: 25px;}

</style>

<!-- 画廊js -->
<script type="text/javascript">
$(document).ready(function(){

    $(".main_visual").hover(function(){
        $("#btn_prev,#btn_next").fadeIn()
    },function(){
        $("#btn_prev,#btn_next").fadeOut()
    });
    
    $dragBln = false;
    
    $(".main_image").touchSlider({
        flexible : true,
        speed : 200,
        btn_prev : $("#btn_prev"),
        btn_next : $("#btn_next"),
        paging : $(".flicking_con a"),
        counter : function (e){
            $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
        }
    });
    
    $(".main_image").bind("mousedown", function() {
        $dragBln = false;
    });
    
    $(".main_image").bind("dragstart", function() {
        $dragBln = true;
    });
    
    $(".main_image a").click(function(){
        if($dragBln) {
            return false;
        }
    });
    
    timer = setInterval(function(){
        $("#btn_next").click();
    }, 5000);
    
    $(".main_visual").hover(function(){
        clearInterval(timer);
    },function(){
        timer = setInterval(function(){
            $("#btn_next").click();
        },5000);
    });
    
    $(".main_image").bind("touchstart",function(){
        clearInterval(timer);
    }).bind("touchend", function(){
        timer = setInterval(function(){
            $("#btn_next").click();
        }, 5000);
    });
    
});
</script>

<!-- 画廊宽高按比例定义 -->
<script type="text/javascript">
if(window.location.toString().indexOf('pref=padindex') != -1){}
else{
    if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){ 
        if(window.location.href.indexOf("?mobile")<0){
            try{
            	if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
                    $(document).ready(function(){
                        var width = $(window).width();
                        $(".main_visual").css("height",360/(750/width));
                        $(".flicking_con").css("top",360/(750/width) - 30 );
                        $(".main_image").css("height",360/(750/width));
                        $(".main_image li span").css("height",360/(750/width));
                    })
                }
                else if(/iPad/i.test(navigator.userAgent)){}
                else{}
            }catch(e){}
        }
    }
}
</script>

<!-- 消息入口 -->
<a href="<?php echo site_url("Member/Message/MessageCenter");?>" class="icon-news icon_xiaoxi">
<?php if($Msg_status){ ?>
    <span class="info_dian"><span></span></span>
<?php }?>        
  
</a>

<div class="new_container">
	<!-- 滚动图 s-->
    <div class="main_visual">
        <div class="flicking_con" style="z-index: 1;">
    	<?php
    	if($adList != null && count($adList) > 0) {
    	    $i=1;
    	    foreach ($adList as $ad){
        ?>
    	       <a href="#"><?php echo $i;?></a>
		<?php 
    	       $i++;
    	    }
    	}
    	?>
        </div>
        <div class="main_image">
            <ul>
    	<?php
    	if($adList != null && count($adList) > 0) {
    	    foreach ($adList as $ad){
        ?>
                <li><a href="<?php echo $ad['url'];?>"><img src="<?php echo IMAGE_URL.$ad['img_url'];?>" alt="<?php echo $ad['title'];?>"></a></li>
        <?php 
    	    }
    	}
    	?>
            </ul>
            <!-- 绑定滑动事件按钮，勿删 -->
            <a href="javascript:;" id="btn_prev" ></a>
            <a href="javascript:;" id="btn_next" ></a>
    	</div>
        <!-- 
        <div class="flicking_con">
            <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a>
        </div>
        <div class="main_image">
            <ul>
                <li><a href="javascript(0);"><img src="images/20141206092732_4208.jpg" alt=""></a></li>
                <li><a href="javascript(0);"><img src="images/20141206093851_5791.jpg" alt=""></a></li>
                <li><a href="javascript(0);"><img src="images/20141206093912_0947.jpg" alt=""></a></li>
                <li><a href="javascript(0);"><img src="images/20141206092732_4208.jpg" alt=""></a></li>
                <li><a href="javascript(0);"><img src="images/20141206093851_5791.jpg" alt=""></a></li>
                <li><a href="javascript(0);"><img src="images/20141206093912_0947.jpg" alt=""></a></li>
            </ul>
            <a href="javascript:;" id="btn_prev" ></a><a href="javascript:;" id="btn_next" ></a>
        </div>
         -->
    </div>
	<!-- 滚动图结束 e-->
	
	<!-- 菜单 -->
	<div class="new_index_menu">
		<ul>
            <li class="menu_icon03"><a href="<?php echo site_url('Tribe')?>">互助部落</a></li>
			<li class="menu_icon01"><a class="menu_icon01" href="<?php echo site_url("navigation/project_Introduction_nav");?>">项目介绍</a></li>
			<li class="menu_icon02"><a href="<?php echo site_url("navigation/question_nav");?>">常见问题</a></li>
			<!-- <li class="menu_icon03"><a href="<?php // echo site_url("navigation/join_nav");?>">如何加入</a></li> -->
			<li class="menu_icon04"><a href="<?php echo site_url("navigation/cooperate_nav");?>">商务合作</a></li>
		</ul>
	</div>
	<!-- 菜单 e-->
	
	<!-- 内容列表 s-->
	<div class="new_index_main" >
		<ul>
         <!-- 需求池 -->
                <li> 
                <a href="javascript:void(0);" onclick="on_requirement()">
                    <img src="<?php echo THEMEURL.'images/requirement.png';?>" alt="需求信息">
                </a> 
                </li>
        <?php
            if (is_array($ad_apptype_list) && count($ad_apptype_list) > 0) {
            foreach ($ad_apptype_list as $apptype_list){

                    $url = $apptype_list['url'];
        ?>
			<li>
    			<a href="<?php echo site_url($url);?>">
    				<img src="<?php echo IMAGE_URL.$apptype_list["img_url"];?>" alt="<?php echo $apptype_list['title']?>">
    			</a>
			</li>
		<?php
            }
        } else {}
        ?>
		</ul>
	</div>
	<!-- 内容列表 e-->



    <!-- 体验劵 -->
    <div class="index_experience" style="display:none;">
      <a href="<?php echo site_url('Verification/experience_details')?>" class="index_experience_img">
         <img src="images/experience.png" alt="">
         <span>暂不使用</span>
      </a>
      <img src="images/index_close.png" alt="" class="index_close">
    </div>

	<!-- 底部 s-->
	<div style="height:10px;width:100%;background-color: #fff;">
		<span></span>
	</div>
	<!-- 底部 e-->


    <?php if(!$corp_status){?>
    <!-- 弹窗 -->
    <div class="box_ball" hidden></div>
       <div class="forget-password" hidden>
        <div class="password-text">
         <span id="success-text">抱歉，您需申请成为商家用户才能查看需求信息，有疑问请联系平台客服</span>
        </div>
        <a href="<?php echo site_url('home');?>" class = "password-button">取消</a> <a href='tel:4000029777' class = "password-button">拨打客服</a>
       </div>
   
    <?php }?>




</div>

<script type="text/javascript">
    var width = $(".flicking_con").width();
    $(".flicking_con").css("margin-left",- width/2);


    // 点击优惠券关闭按钮
    $(".index_close").on("click",function(){
        $(".index_experience").css("display","none");
    })


    // 获取弹窗的高度
    var box_height = $(".forget-password").height();
    var window_height = $(window).height();
    $(".forget-password").css("top",(window_height - box_height)/2);


    function on_requirement() {
        <?php   if(!$user_in){?>
            window.location.href =  "<?php echo site_url('member/requirement')?>";
        <?php }else{
        ?>
         window.location.href =  "<?php echo site_url('member/requirement')?>";
//         $(".box_ball").show();
//         $(".forget-password").show();
       <?php }?>
    }


</script>
<script type="text/javascript">
window.onpageshow = function(event){
if (event.persisted) {
window.location.reload();
}
}
</script>