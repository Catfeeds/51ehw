<style type="text/css">
    .container {background:#f6f6f6;}
	.tribe_search p {background-color: #fff;width:80%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;}
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
    .result_em {width: 70%;}
    .tribe_recommend_list ul li {border: none;}
    .result_em p {font-size: 13px;color: #666666;}
</style>
<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>

<!-- 部落搜索 -->
<div class="search-header tribe" name="">
    <a href="<?php echo site_url("home");?>" target="_self" class="icon-right tribe-icon-right"></a>
    <form  >
        <div class="nav_search tribe_search">
            <p>
                <a href="<?php echo site_url("Tribe/tribe_search");?>" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"><input type="text" class="search_input tribe_search_input" name="keywords"  placeholder="搜索部落" required=""></a>
            </p>
        </div>
    </form>
   <a href="<?php echo site_url("home");?>" target="_self" class="icon-icon_hone_off tribe-icon-hone"></a>
</div>

<!-- 广告图 -->
<div class="main_visual" style="margin-top: 50px;">
        <div class="flicking_con" style="z-index: 1; margin-left: -43px; top: 250px;">
                      <!--  <a href="#" class="on">1</a>
                       <a href="#" class="on">2</a>
                       <a href="#">3</a>
                       <a href="#">4</a>
                       <a href="#">5</a>
                       <a href="#">6</a> -->
                </div>
        <div class="main_image">
            <ul style="overflow: visible;">
                        <li><a href="<?php echo site_url('tribe/tirbe_banner_detail')?>"><img src="images/tirbe_banner.jpg" alt="互助部落"></a></li>
                        <li><a href="<?php echo site_url('tribe/tirbe_banner_detail')?>"><img src="images/tirbe_banner.jpg" alt="互助部落"></a></li>
                       <!--  <li><a href="&#9;http://www.51ehw.com/goods/detail/289"><img src="http://images.51ehw.com/B/uploads/51ehwad/20170321095809.jpg" alt="旅游"></a></li>
                        <li><a href="http://www.51ehw.com/goods/detail/1877"><img src="http://images.51ehw.com/B/uploads/51ehwad/20170321100258.jpg" alt="烧烤炉"></a></li>
                        <li><a href="search/wechat_search_goods?cate_id=1298&amp;isparent=1"><img src="http://images.51ehw.com/B/uploads/51ehwad/20170321100548.jpg" alt="茶叶"></a></li>
                        <li><a href="search/wechat_search_goods?cate_id=1023&amp;isparent=1"><img src="http://images.51ehw.com/B/uploads/51ehwad/20170321100642.jpg" alt="白酒"></a></li>
                        <li><a href="http://www.51ehw.com/goods/detail/2158"><img src="http://images.51ehw.com/B/uploads/51ehwad/20170321100819.jpg" alt="服装"></a></li> -->
            </ul>
            <!-- 绑定滑动事件按钮，勿删 -->
           <!--  <a href="javascript:;" id="btn_prev" style="width: 320px; overflow: visible;"></a>
            <a href="javascript:;" id="btn_next" style="width: 320px; overflow: visible;"></a> -->
        </div>
    </div>

<!-- 我的部落 -->
<?php if(count($mytribe)){;?>
<div class="my_tirbe">
    <p class="tirbe_title">我的部落</p>

    <!-- 我的部落 小于等于二个的时候这样显示 -->
    <?php if(count($mytribe)<3){;?>
    <div class="tribe_recommend_list">
    <ul>
        <?php foreach($mytribe as $v) { ?>
          <a href="<?php echo site_url("tribe/shop/".$v["id"]);?>">
          <li class="clearfix">
            <i class="tribe_recommend_img tribe_i_width"><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/default_img_s.jpg'"></i>
            <em class="result_em">
                <p class="pt10">
                  <span class="tribe_recommend_name"><?php echo $v["name"];?></span><span class="tribe_recommend_num" style="display:none;">会员数: <?php echo $v["total"];?>人</span>
                </p>
                <div class="tribe_recommend_text"><?php echo $v["content"];?></div>
            </em>
          </li>
          <span style="border-bottom: 1px solid #ddd;display: block;"></span>
          </a>
        <?php } ?>
        
    </ul>
    </div>
    <?php }else{;?>
    <!-- 我的部落 大于等于两个的时候这样显示 -->
    <div class="my_tirbe_list">
        <ul>
           <?php foreach($mytribe as $v) {; ?>
              <a href="<?php echo site_url("tribe/shop/".$v["id"]);?>">
              <li>
                <img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/default_img_s.jpg'">
                <span><?php echo $v["name"];?></span>
              </li>
              </a>
          <?php } ?>
        </ul>
    </div>
    <?php };?>

</div>
<?php };?>




<!-- 部落推荐 -->
<div class="tribe_recommend">
    <p class="tirbe_title">部落推荐</p>
    <?php foreach($hot_list as $v){;?>
    <div class="tribe_recommend_list">
    <ul>
        <a href="<?php echo site_url("tribe/shop/".$v["id"]);?>">
          <li class="clearfix">
            <i class="tribe_recommend_img tribe_i_width"><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/default_img_s.jpg'"></i>
            <em class="result_em">
                <p class="pt10">
                  <span class="tribe_recommend_name"><?php echo $v["name"];?></span><span class="tribe_recommend_num" style="display:none;">会员数: <?php echo $v["total"];?>人</span>
                </p>
                <div class="tribe_recommend_text"><?php echo $v["content"];?></div>
            </em>
          </li>
          <span style="border-bottom: 1px solid #ddd;display: block;"></span>
        </a>

    </ul>
    </div>
    <?php }; ?>
</div>



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
                        $(".flicking_con").css("top",400/(750/width) - 30);
                        $(".main_image").css("height",400/(750/width));
                        $(".main_image li span").css("height",400/(750/width));
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
   var width = $(".my_tirbe_list ul a").width();
   var mytribe_total = "<?php echo count($mytribe);?>";
   $(".my_tirbe_list ul").width(width*mytribe_total);
</script>

<Script>
function reurl(){
url = location.href;
var times = url.split("?t=");
if(times[1] != 1){
url += "?t=1";
self.location.replace(url);
}
}
onload=reurl
</script>


<script type="text/javascript">
   var width_img = $(document.body).width();
   $(".tribe_i_width").height((width_img - 20)* 0.24);
</script>





