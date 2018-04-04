
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
/*#btn_prev{background:url(../images/hover_left.png) no-repeat left top;left:100px;}
#btn_next{background:url(../images/hover_right.png) no-repeat right top;right:100px; }*/
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
                        $(".main_visual").css("height",560/(750/width));
                        $(".flicking_con").css("top",560/(750/width) - 30 );
                        $(".main_image").css("height",560/(750/width));
                        $(".main_image li span").css("height",560/(750/width));
                    })
                }
                else if(/iPad/i.test(navigator.userAgent)){}
                else{}
            }catch(e){}
        }
    }
}
</script>

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
		
            <li class="menu_icon05"><a href="<?php echo site_url("navigation/elite_Line_nav");?>">精英头条</a></li>
			<!-- <li class="menu_icon01"><a class="menu_icon01" href="<?php //echo site_url("navigation/project_Introduction_nav");?>">项目介绍</a></li> -->
			<li class="menu_icon02"><a href="<?php echo site_url("navigation/question_nav");?>">常见问题</a></li>
			<!--  <li class="menu_icon03"><a href="<?php //echo site_url("navigation/join_nav");?>">如何加入</a></li> -->
			<li class="menu_icon03"><a href="<?php echo site_url("Member/Advertisement");?>">广告任务</a></li>
			<li class="menu_icon04"><a href="<?php echo site_url("navigation/cooperate_nav");?>">商务合作</a></li>
            <!--<li class="menu_icon06"><a href="javascript:void(0);">信用卡开卡</a></li>  -->
		</ul>
	</div>
	<!-- 菜单 e-->
	
	<!-- 内容列表 s-->
	<div class="new_index_main" >
		<ul>
        <?php
            if (is_array($ad_apptype_list) && count($ad_apptype_list) > 0) {
            foreach ($ad_apptype_list as $apptype_list){
                // 换成序列号
                if (strstr($apptype_list['url'], 'cate_id=')) {
                    $num1 = strpos($apptype_list['url'], 'cate_id=');
                    $url = substr($apptype_list['url'], $num1 + 8);
                    $num2 = strpos($url, '&');
                    $id = substr($url, 0, $num2);
                    $xlid = base64_encode(serialize($id));
                    $url = site_url(str_replace($id, $xlid, $apptype_list['url']));
                } else {
                    $url = $apptype_list['url'];
                }
        ?>
            
			<li>
    			<a href="<?php echo $url;?>">
    				<img src="<?php echo IMAGE_URL.$apptype_list["img_url"]?>" alt="<?php echo $apptype_list['title']?>">
    			</a>
			</li>
		<?php
            }
        } else {}
        ?>
		</ul>
	</div>
	<!-- 内容列表 e-->
	
	<!-- 底部 s-->
	<div style="height:10px;width:100%;background-color: #fff;">
		<span></span>
	</div>
	<!-- 底部 e-->
</div>

<script type="text/javascript">
    var width = $(".flicking_con").width();
    $(".flicking_con").css("margin-left",- width/2);
</script>
