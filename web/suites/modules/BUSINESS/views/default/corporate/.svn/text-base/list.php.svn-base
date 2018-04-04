<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script>
//顶部菜单
//站点菜单
    (function($){
        $(document).ready(function(){
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script>


<?php $this->load->view('navigation_bar');?>

<div class="content_company clearfix">

<!-- content left -->
    <div class="ec_content_left">
        <p class="company_font">全部结果 &nbsp; > &nbsp; 共搜索到<?php echo count($corp);?>个企业</p>
        <!--分类下拉框-->
        <?php if(count($corp)>0): ?>
        <?php foreach ($corp as $corporate):?>
        <div class="companys_con">
            <h1><img src="<?php echo isset($corporate['img_url'])&&$corporate['img_url']!=''?IMAGE_URL.$corporate['img_url']:"images/logo310.png" ?>" width="310" height="310"></h1>
            <ul>
                <h2><?php echo $corporate['corporation_name'];?></h2>
                <h4>企业地址：<?php echo $corporate['province'].$corporate['city'].$corporate['district'];?></h4>
                <h6>会员等级：<?php switch ($corporate['grade']){
                        case 1 :
                            echo '易货店会员';
                        break;
                        case 2 :
                            echo '专卖店会员';
                        break;
                        case 3 :
                            echo '旗舰店会员';
                        break;
                }?></h6>
                <li>企业简介：<?php echo $corporate['description'];?>......<a href="<?php echo site_url('home/GoToShop/'.$corporate['id']);?>">[查看更多]</a></li>
            </ul>
        </div>
        <?php endforeach;?>
        <?php else: ?>
        <div class="result_none">没有您想要搜索的企业</div>
        <?php endif; ?>
    </div>
    <!-- end -->

    <!-- content right -->
    <a href="<?php echo site_url('home/GoToShop/42');?>">
   <!-- <div class="ec_content_right">
         <ul class="logo_one">
            <li class="logo_frient"><img src="images/logo2.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_two">
            <li class="logo_frient"><img src="images/logo5.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_one">
            <li class="logo_frient"><img src="images/logo2.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_two">
            <li class="logo_frient"><img src="images/logo5.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_one">
            <li class="logo_frient"><img src="images/logo2.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_two">
            <li class="logo_frient"><img src="images/logo5.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_one">
            <li class="logo_frient"><img src="images/logo2.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_two">
            <li class="logo_frient"><img src="images/logo5.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_one">
            <li class="logo_frient"><img src="images/logo2.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
        <ul class="logo_two">
            <li class="logo_frient"><img src="images/logo5.png"></li>
            <li class="logo_font">冠杰文化</li>
         </ul>
    </div>--></a>
    <!-- end -->
<!-- page -- >
<div class="pages">
    <ul>
        <p>共18条记录</p>
        <a href=""><li class="pageer">首页</li></a>
        <a href=""><li class="pageer">上一页</li></a>
        <a href=""><li>1</li></a>
        <a href=""><li>2</li></a>
        <a href=""><li>3</li></a>
        <a href=""><li>4</li></a>
        <a href=""><li>5</li></a>
        <a href=""><li class="pageer">下一页</li></a>
        <a href=""><li class="pageer pageer_other">尾页</li></a>
    </ul>
</div>
<!-- page end-->
<!-- footer 关键字-- >
<div class="footer_link">
    <h1>您是不是在找</h1>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
    <ul>
        <a href=""><li>东莞盈通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>盈通显卡</li></a>
        <a href=""><li>中通客车</li></a>
        <a href=""><li>普利司通</li></a>
        <a href=""><li>万事通</li></a>
        <a href=""><li>东莞盈通</li></a>
     </ul>
</div>
<!-- end -->
</div>


<!--<script src="js/jquery.min.js"></script>-->
<script>
    $pages = $(".pages").children().children("a");
    $pages.mouseover(function(){
       $(this).children().css("background","#ffedd9");
    }).mouseout(function(){
       $(this).children().css("background","#fff");
    })
    $link = $(".footer_link").children("ul").children();
    $link.mouseover(function(){
       $data = $(this).children().html();
        $(this).children().html("<u>"+$data+"</ul>");
    }).mouseout(function(){
         $(this).children().html($data);
    })
</script>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>