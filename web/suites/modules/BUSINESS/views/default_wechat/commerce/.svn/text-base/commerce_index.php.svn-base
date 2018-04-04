<style type="text/css">
.recommended_tribe_top li {border-top: none;border-bottom: 1px solid #d6d6d6;}
.my_tribe {padding: 20px 0 0px 0;}
.my_tribe p {color: #bfbfbf;}
.tribal_index_zhiding input {background: #fabe00;color: #fff;border-radius: 4px;padding: 4px 0px;width: 67.5px;}
.tribe_tuijian_box {margin-top: 5px;}
.scheduler_border {border-top: 1px dashed #dadada;margin: 5px 0px !important;}
.scheduler_border1 {color: #a7a7a7;font-size: 14px;font-weight: normal;}
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
.commerce_look_more_actvie {-webkit-transform: rotate(315deg);-moz-transform: rotate(315deg);-ms-transform: rotate(315deg);transform: rotate(180deg);}
</style>
<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>

<!-- 商会首页 -->

<div class="commerce_index">
    <!-- 轮播图片 -->
    <?php if( count( $app_label_banner) == 1 ){?>
        <!-- 一张图片的时候 -->
    <div class="banner_one_img">
        <?php foreach ( $app_label_banner as $v ) {?>
         <a href="<?php echo $v['link']?>"><img src="<?php echo IMAGE_URL.$v['banner_path']?>" alt="" ></a>
        <?php }?>
    </div>
    <?php }else{?>
    <div class="main_visual">
        <div class="flicking_con">
        <?php foreach ( $app_label_banner as $k=>$v ) {?>
            <a href="#" class="on"></a>
        <?php }?>
        </div>
        <div class="main_image" >
            <ul>
            <?php foreach ( $app_label_banner as $v ) {?>
                <li><a href="<?php echo $v['link']?>"><img src="<?php echo IMAGE_URL.$v['banner_path']?>" alt="" ></a></li>
             <?php }?>
            </ul>
            <!-- 绑定滑动事件按钮，勿删 -->
            <a href="javascript:;" id="btn_prev" style="width: 320px; overflow: visible;"></a>
            <a href="javascript:;" id="btn_next" style="width: 320px; overflow: visible;"></a>
        </div>
    </div>

      <?php }?>

    <div class="commerce_head">
        <!-- <img src="images/commerce_bg.png"> -->
        <!-- 搜索框 -->
        <a href="<?php echo site_url('Commerce/search_tribe/'.$label_id)?>">
        <div class="commerce_head_box">
            <!--  <form method="get" action="<?php //echo  site_url("Tribe/tribe_announcements_view/$label_id")?>" id="form1" style="width: 100%;"> -->
                <label>
                    <p>
                        <span class="icon-search"></span><input type="search" placeholder="搜索部落" name='keyword'>
                    </p>
                </label> 
    <!--            <a href="javascript:void(0);" class="icon-scan saomiao_icon"></a> -->
             <!-- </form> -->
        </div>
        </a>
    </div>
    <!-- 最新公告 -->
    <div class="commerce_notice">
        <div class="commerce_notice_top commerce_notice_bian">
            <a href="<?php echo site_url("Tribe/tribe_announcements_view/$label_id")?>"> <span class="icon-horn commerce_notice_icon"></span>
                <h4>最新公告</h4>
                <div id="commerce_notice_top_nei">
                    <ul class="commerce_notice_xia" style="margin-top: 0px;">
                        <?php if ( !empty( $announcement_list) ) {?>
                        <?php foreach ( $announcement_list as $v ){?>
                          <li><span>NEW</span><?php echo $v['title']?></li> 
                        <?php }?>
                        <?php }else{;?>
                         <li style="text-align:center;"><span>暂&nbsp无&nbsp公&nbsp告</span></li> 
                        <?php };?>
                    </ul>
                </div> <span class="commerce_notice_more"><em></em><em></em><em></em></span>
            </a>
        </div>
    </div>
    
    <?php if( $nav_info ) {?>
    <!-- 中间导航 -->
    <div class="commerce_nav">
        <ul>
            <?php 
            foreach ( $nav_info as $v ){?>
                    <li><a href="<?php echo $v['link'];?>"><img src="<?php echo IMAGE_URL.$v['image']?>"><span><?php echo $v['name']?></span></a></li>
            <?php }?>
            
        </ul>
        <!-- 商会名录入口 -->
        <?php if($label_id == 2){?><!-- 只有秦商商会才显示 -->
        <div class="commerce_name_go"><a href="http://www.51ehw.com/index.php/_BUSINESS/Commerce/Commerce_label_list/2"><img src="images/commerce/commerce_name.png" alt=""></a></div>
    	<?php }?>
    </div>
    <?php }?>
    
    <!-- 全球秦商十大好项目揭晓 -->
    <?php if($label_id == 2){?><!-- 只有秦商商会才显示 -->
    <div class="commerce_xiangmu_go"><a href="http://www.51ehw.com/index.php/_BUSINESS/Notice/shijia/2"><img src="images/commerce/commerce_xiangmu01.png" alt=""></a></div>
    <?php }?>

    <!-- 陕西土特产 -->
    <?php if($label_id == 2){?><!-- 只有秦商商会才显示 -->
    <div class="commerce_xiangmu_go"><a href="<?php echo  site_url("Commerce/Outstanding/specialty/{$label_id}");?>"><img src="images/commerce/specialty.png" alt=""></a></div>
    
    <?php if(!empty($RecomendedShop)){?>
    <!-- 后台获取 -->
    <div class="commerce_xiangmu_go">
        <div class="specialty_box">
        <?php foreach ($RecomendedShop as $key => $value){
              if($key == 0){?>
                <div class="specialty_box_left"><a href="<?php echo site_url("Home/GetShopGoods/{$value['shop_id']}")?>"><img src="<?php echo IMAGE_URL.$value['shop_img'];?>" alt=""  onerror="this.src='images/commerce/specialty_01.png'"></a></div>
                <div class="specialty_box_right">
                <ul>
        <?php }else if ($key == 4) {?>
                    <li><a href="<?php echo site_url("Home/GetShopGoods/{$value['shop_id']}")?>"><img src="<?php echo IMAGE_URL.$value['shop_img'];?>" alt="" onerror="this.src='images/commerce/specialty_05.png'"></a></li>
               </ul>
               </div>
        <?php }else{?>
                <li><a href="<?php echo site_url("Home/GetShopGoods/{$value['shop_id']}")?>"><img src="<?php echo IMAGE_URL.$value['shop_img'];?>" alt="" onerror="this.src='images/commerce/specialty_0<?php echo $key+1;?>.png'"></a></li>
        <?php }
              }?>
        </div>
    </div>
    <?php }?>
    <!-- 后台获取 -->
    <?php }?>

    <!-- 新闻资讯 -->
    <?php if( !empty($laws_regulations) || !empty($industry_news) ):?>
    <div class="my_tribe">
        <div class="gray-text">
            <span>新</span><span>闻</span><span>资</span><span style="border-right: 1px solid;">讯</span><span style="opacity: 0;"><i></i></span>
        </div>
        <p>News and information</p>
    </div> 
    <div class="news_information">
        <?php if($laws_regulations && $industry_news):?>
            <a href="<?php echo site_url('tribe/news_information/1').'/'.$label_id;?>">
                <img src="images/fagui_icon.png" alt=""><span>政策法规</span>
            </a>
            <a href="<?php echo site_url('tribe/news_information/2').'/'.$label_id;?>">
                <img src="images/dongtai_icon.png" alt=""><span>行业动态</span>
            </a>
        <?php elseif($laws_regulations):?>
            <a href="<?php echo site_url('tribe/news_information/1').'/'.$label_id;?>">
                <img src="images/fagui_icon.png" alt=""><span>政策法规</span>
            </a>
        <?php elseif($industry_news):?>
            <a href="<?php echo site_url('tribe/news_information/2').'/'.$label_id;?>">
                <img src="images/dongtai_icon.png" alt=""><span>行业动态</span>
            </a>
        <?php endif;?>
    </div>
    <?php endif;?>




    <!-- 我的商会 -->
    <div class="my_tribe">
        <div class="gray-text">
            <span>我</span><span>的</span><span>商</span><span>会</span><span><i><?php echo count( $mytribe ) ?></i></span>
        </div>
        <p>Chamber of Commerce</p>
    </div> 
<?php if( !empty( $mytribe ) ){ ?>
   
    <div class="recommended_tribe">
        <ul class="recommended_tribe_top">
            <?php foreach ( $mytribe as $k=>$v ){?>
            <li <?php echo $k >=3 ? 'hidden' : ''?> >
                <a href="<?php echo site_url("Tribe/home/".$v['id'].'/'.$label_id);?>"> 
                    <i><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i>
                    <div class="recommended_tribe_rigth">
                        <div class="tribal_index_zhiding">
                            <h2><?php echo $v['name']?></h2>
                            <input class="divcss custom_button"  data='<?php echo $v['id'];?>' value="<?php echo $v['sort'] ? '取消置顶':'置顶';?>" type="button">
<!--                            <input class="divcss" data="42" value="置顶" type="button"> -->
                        </div>
                        <div class="tribe_tuijian_box">
                            <p><?php echo strip_tags($v['content'])?></p>
                        </div>
                    </div>
                </a>
            </li>
            <?php }?>
        </ul>
    </div>


    <?php if( count( $mytribe) > 3 ){?>
    <fieldset class="scheduler_border commerce_look_more">
        <legend class="scheduler_border1">
            <span>查 看 更 多 </span><img src="images/commerce/more_icon.png"
                width="10" height="10" style="display: inline-block;">
        </legend>
    </fieldset>
    <?php }?>
    
<?php }else{?>
     <!-- 您还未加入商会 -->
    <div class="commerce_index_not"><span>您还未加入商会</span></div>
    
<?php }?>

<!-- 活动列表 -->
<?php if( $activities_list ){?>
<ul class="my_activities_top">

<?php foreach ( $activities_list as $v ):?>
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="<?php echo site_url('Tribe/home/'.$v['tribe_id'].'/'.$label_id)?>"><i><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <h2><?php echo $v['tribe_name'] ?></h2>
                    <p><span><?php echo $v['update_at']?></span></p>
                    </a>
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
        </div>
    </li>
<?php endforeach;?>
</ul>
<?php } ?> 


</div>

<?php if( $label_id == 1 ){?>
<a href="<?php echo site_url('Commerce/subscribe/'.$label_id)?>" onclick="" class="all_guanzhu">
  <img src="images/gongshang_logo.png" alt="">
</a>

<script type="text/javascript">

$(function(){ 

	$('.all_guanzhu').eq(1).remove();
})
</script>

<?php }?>


<script type="text/javascript">


function AutoScroll(obj){ 
$(obj).find("ul:first").animate({ 
marginTop:"-24px" 
},500,function(){ 
$(this).css({marginTop:"0px"}).find("li:first").appendTo(this); 
}); 
} 
$(document).ready(function(){ 
setInterval('AutoScroll("#commerce_notice_top_nei")',3000); 
}); 

// 点击查看更多
$(".commerce_look_more").on("click",function(){
    
      if($(this).find('span').text() == '查 看 更 多 ')
      {
          $(".commerce_look_more span").text("收 起 ");
          $('.recommended_tribe_top li:gt(2)').show();
          $('.commerce_look_more img').addClass('commerce_look_more_actvie');
      }else{
          $('.recommended_tribe_top li:gt(2)').hide();
          $(".commerce_look_more span").text("查 看 更 多 ");
           $('.commerce_look_more img').removeClass('commerce_look_more_actvie');
      }
})


$(".divcss").click(function () {
    var id =$(this).attr('data');
    $.ajax({
        url: '<?php echo  site_url("Tribe/sort_tribe");?>',
        type: 'POST',
        data:{'id':id},
        dataType: 'json',
        success: function(data){
            $(".black_feds").text(data.message).show();
            setTimeout("prompt();", 2000);
            setTimeout(function(){
                window.location.href ="<?php echo site_url("Commerce/index/".$label_id).'?rf_id='.rand(1000,9999);?>";
                }, 2200);
        },
        error:function(){
            $(".black_feds").text("网络出错，请重试！").show();
            setTimeout("prompt();", 2000);
            return;
        }
     });
    return false;
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
                        $(".main_image ul").css("height",360/(750/width));  
                        $(".flicking_con").css("top",360/(750/width) - 15);
                        $(".main_image").css("height",360/(750/width));
                        $(".main_image li span").css("height",360/(750/width));
                        $('.banner_one_img').css("height",360/(750/width));
                    })
                }
                else if(/iPad/i.test(navigator.userAgent)){}
                else{}
            }catch(e){}
        }
    }
}
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
<script type="text/javascript">
 var footer_nva_length = $(".tribe_shop_footer ul li").length;
 $(".tribe_shop_footer ul li").css("width",(100/footer_nva_length)+"%");    
 var width = $(".flicking_con").width();
 $(".flicking_con").css("margin-left",- width/2);


  $(window).scroll(function() {
    
    if($(document).scrollTop() > 100) {

        <?php 
        $labe_foot_nav_color = $this->session->userdata("labe_foot_nav_color");
        if($labe_foot_nav_color){?>
            $(".commerce_head_box").css("background","<?php echo $labe_foot_nav_color;?>");
        <?php  }else{?>
            $('.commerce_head_box').css('background','#61c3d0');
        <?php  }?>
     

    }else {
     $('.commerce_head_box').css('background','none');


    }

  })

  var window_width = $(document).width();
  $('.specialty_box_right ul li').css('margin-top',(window_width*0.02)+1);

</script>
