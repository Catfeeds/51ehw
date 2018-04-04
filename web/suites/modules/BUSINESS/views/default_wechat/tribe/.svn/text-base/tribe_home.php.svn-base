<style type="text/css">
	/*广告图样式*/
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
    .my_activities {margin-bottom: 50px;}
    .banner_one_img {overflow: hidden;}
    .banner_one_img a img {height: 100%;width: 100%;object-fit: cover;}
    .cart_num1 {position: absolute;right: 20%;top: 5px;width: auto;min-width: 14px;}
    .tribe_shop_footer ul li {width: 20%;}
</style>
<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
  <a href="<?php echo !$label_id ? site_url('Tribe') : site_url("Commerce/index/$label_id")?>" class="tribe_index_nav_home" style="right:60px;"><span class="icon-icon_hone_off" style="font-size: 21px;color:#fff;"></span></a>
  <?php if($is_manage){;?>
  <a href="<?php echo site_url("Tribe/managingtribes/{$tribe["id"]}");?>" class="tribe_index_nav_home"><span class="icon-tianjiabula1" style="font-size: 21px;color:#fff;"></span></a>
  <?php };?>
</div>

<?php if( $tribe["bg_img"]  ){?>
<!-- 广告图 -->


   <?php if( count($tribe["bg_img"]) == 1 ){?>
        <!-- 一张图片的时候 -->
    <div class="banner_one_img">
       <?php foreach ( $tribe["bg_img"] as $k=>  $v ){ ?>
             <a href="javascript:;"><img src="<?php echo IMAGE_URL.$v?>" alt="<?php echo $k?>" onerror="this.src='images/tribe_banner.png'"></a>
                <?php } ?>
    </div>
    <?php }else{?>
<div class="main_visual">
        <div class="flicking_con" style="z-index: 1;">
            <?php foreach ( $tribe["bg_img"] as $k=>  $v ){?>
                       <a href="#" class="on"><?php echo $k?></a>
            <?php } ?>
                       
        </div>
        <div class="main_image">
            <ul style="overflow: visible;">
                <?php foreach ( $tribe["bg_img"] as $k=>  $v ){ ?>
                    <li><a href="javascript:;"><img src="<?php echo IMAGE_URL.$v?>" alt="<?php echo $k?>" onerror="this.src='images/tribe_banner.png'"></a></li>
                <?php } ?>
                    </ul>
            <!-- 绑定滑动事件按钮，勿删 -->
            <a href="javascript:;" id="btn_prev" style="width: 320px; overflow: visible;"></a>
            <a href="javascript:;" id="btn_next" style="width: 320px; overflow: visible;"></a>
        </div>
    </div>

      <?php }?>



<?php }else{?>

	<!-- 广告图 -->
    <div class="banner_one_img">
             <a href="javascript:;"><img src="" alt="images/essary_head.png" onerror="this.src='images/essary_head.png'"></a>
    </div>
<?php }?>


	<?php if( $announcement_list ){?>
    <!--部落公告-->
    <div class="tribal_notice tribal_notice_yan">
        <div class="tribal_notice_top">
        <a href="<?php echo site_url('Tribe/announcement/'.$tribe_id)?>">
            <h4><span class="icon-horn"></span>公告</h4>
            <div id="tribal_notice_top_nei">
               <ul class="tribal_notice_xia">
               <?php foreach( $announcement_list as $v ){?>
                   <li><span>NEW</span><?php echo $v['title']?></li> 
               <?php }?>
                 
               </ul>
            </div>
            <h6 class="icon-more1"></h6>
        </a>
        </div>
      </div>
      <?php }?>
      
      
<?php if( $activities_list ){?>
 <!--我的活动开始-->
<div class="my_activities">
    <ul class="my_activities_top">
    <?php foreach ( $activities_list as $v ) {?>
        <li>
            <div class="activities_nei_li">
                <div class="activities_nei_li_top"> 
                    <i><img src="<?php echo IMAGE_URL.$tribe["logo"];?>" onerror="this.src='images/default_img_s.jpg'"></i>
                    <div class="activities_nei_li_xia">
                    
                        <h2><?php echo $tribe['name']?></h2>
                        <p><span><?php echo $v['update_at']?></span></p>
                    
                    </div>
                </div>
                <div class="activities_neirong">
                    <a href="<?php echo site_url('Tribe/activity_detaile/'.$v['id']);?>">
                        <div class="activities_neirong_xia">
                        <p><?php echo $v['name']?></p> 
                        <img src="<?php echo IMAGE_URL.$v['banner_img']?>"/>
                        </div>
                    </a>  
                </div>
<!--                 <dl class="my_activities_xia"> -->
<!--                     <dd><span class="dianzan-text"><i class="icon-fabulous_off dianzan-icon icon-fabulous_on"></i>点赞</span></dd> -->
<!--                     <dd><a href="#"><span><i class="icon-message"></i>评论</span></a></dd> -->
<!--                     <dd><a href="#"><span><i class="icon-report"></i>举报</span></a></dd> -->
<!--                 </dl> -->
            </div>
        </li>
        <?php } ?>
	</ul>
</div>
<!--我的活动结束-->
<?php } ?>

   <!-- 底部导航 -->
   <div class="container-center tribe_shop_footer">
            <ul>
            <li class="footer-icon01"><a href="javascript:void(0)" class="cf tribe_shop_footer_active"><span class="icon-shouye_ cf tribe_shop_footer_active"></span>首页</a></li>
            <li class="footer-icon02"><a href="<?php echo site_url('Tribe/shop/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-shangcheng_"></span>商城</a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Circles/index/'.$label_id.'?tribe_id='.$tribe_id)?>" class=""><span class="icon-quanzi_"></span>圈子</a></li>
            <li class="footer-icon03" style="position: relative;"><a href="<?php echo site_url('Webim/Control/chatList/'.$tribe_id)?>" class=""><span class="icon-xiaoxi2"></span>消息<em class="cart_num1" id ='huanxin_chatNum' hidden>0</em></a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Tribe/Members_List/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-zuyuan_"></span>族员</a></li>
            </ul>
    </div>
<?php if($real_name){//没有真实姓名?>
     <!-- 填写真实弹窗 -->
    <div class="name_ball" style="z-index:99">
           <div class="name_ball_box">
               <div class="name_ball_box_main">
                  <span>真 实 姓 名</span>
                  <span>填写真实姓名, 让沟通更加方便</span>
                  <input type="text" id="my_real_name" placeholder="真实姓名, 必填">
                  <a href="javascript:update_real();">保存</a>
               </div>
           </div>
      </div>
<?php }?>

<?php 
$user_id = $this->session->userdata("user_id");
if($user_id){?>
<script>
$.ajax({
    url:'<?php echo site_url("Webim/Control/getNotReadCount/{$tribe_id}")?>',
    type:'post',
    dataType:'json',
    data:{},
    success:function(data)
    {
   	  console.log("获取未读消息成功");
   	  var MsgCount = data.MsgCount;
      if(MsgCount > 0){
        if(MsgCount >= 99){
            MsgCount = '99+';   
        }
        $("#huanxin_chatNum").html(MsgCount);
        $("#huanxin_chatNum").show();
      }
     	
    },
    error:function()
    {
        console.log("获取未读消息失败");
    }
})
</script>
<?php }?>

<script>
function update_real(){
	var my_real_name = $("#my_real_name").val();
	$.ajax({
		url:'<?php echo site_url('Customer/update_real_name')?>',
		type:'post',
		dataType:'json',
		data:{real_name:my_real_name},
		success:function( data ){
			$(".black_feds").text(data.msg).show();
			setTimeout("prompt();", 2000); 
			if(data.status){
				setTimeout(function(){
					$(".name_ball").hide();
					window.location.reload();
					}, 2300); 
				}
			},
		error:function( data ){
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
			}	
		});
}


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


 $(".dianzan-icon").on("click",function(){
   	 $(this).toggleClass('icon-fabulous_off');
   	 $(this).parents('.dianzan-text').toggleClass('dianzan-color');
   })
</script>
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
                        $(".main_visual").css("height",400/(750/width)); 
                        $(".main_image ul").css("height",400/(750/width));  
                        $(".flicking_con").css("top",400/(750/width) - 20);
                        $(".main_image").css("height",400/(750/width));
                        $(".main_image li span").css("height",400/(750/width));
                        $('.banner_one_img').css("height",400/(750/width));
                    })
                }
                else if(/iPad/i.test(navigator.userAgent)){}
                else{}
            }catch(e){}
        }
    }
}
</script>

<script type="text/javascript">
 var width = $(".flicking_con").width();
 $(".flicking_con").css("margin-left",- width/2);
</script>




