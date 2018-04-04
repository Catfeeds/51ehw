<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/pgwslider.js"></script><!--轮播图-->
<script type="text/javascript" src="js/jquery.easing.min.js"></script><!--供需走马灯效果-->
<script type="text/javascript" src="js/jquery.easy-ticker.min.js"></script><!--供需走马灯效果-->
<script type="text/javascript" src="js/jquery.nav.js"></script><!--楼层tab-->
<script type="text/javascript" src="js/jquery.SuperSlide.js"></script><!--楼层tab-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--轮播图-->

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
<script>
    $(function(){
        //头部搜索切换
        $('#search_hd .search_input').on('input propertychange',function(){
            var val = $(this).val();
            if(val.length > 0){
                $('#search_hd .pholder').hide(0);
            }else{
                var index = $('#search_bd li.selected').index();
                $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            }
        })
        $('#search_bd li').click(function(){
            var index = $(this).index();
            $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            $('#search_hd .search_input').eq(index).show().siblings('.search_input').hide(0);
            $(this).addClass('selected').siblings().removeClass('selected');
            $('#search_hd .search_input').val('');
        });
    })
</script>
<script type="text/javascript">
    //轮播图
$(document).ready(function(){
	$(document).ready(function() {
    	$('.pgwSlider').pgwSlider();

	});
});
</script>
<script type="text/javascript">
    //供需走马灯效果
$(document).ready(function(){

	var dd = $('.vticker').easyTicker({
		direction: 'up',
		easing: 'easeInOutBack',
		speed: 'slow',
		interval: 5000,
		height: 'auto',
		visible: 6,
		mousePause: 0,
		controls: {
			up: '.up',
			down: '.down',
			toggle: '.toggle',
			stopText: 'Stop !!!'
		}
	}).data('easyTicker');

});
</script>
<script>
    //楼层效果
$(function() {
	$('#nav').onePageNav({
		scrollThreshold: 0.1,
		filter: ':not(.eh_lou)'
	});

	$(window).scroll(function(){
		if($(window).scrollTop() > 800){
			$('#nav').fadeIn();
		} else {
			$('#nav').fadeOut();
		}
	});
});

</script>



<style>
/*.eh_navbar .macth_xv_categorys .macth_xv_cat_catlist{display:block;}
    .macth_xv_navlist .macth_xv_menu{padding-left: 180px;}
    .macth_xv_categorys{display: block}
    .macth_xv_categorys .macth_xv_cat_catlist{display: block;min-height: 435px;}*/
</style>

<?php $this->load->view('navigation_bar');?>


<div class="eh_banner clearfix">
  <div class="banner">
    <div class="fullSlide">
	<div class="bd">
		<ul>
          <?php foreach ($adList as $v):?>
              <li _src="url(<?php echo IMAGE_URL.$v['img_url']?>)"><a href="<?php echo $v["url"] ?>" target="_blank"></a></li>
              <?php endforeach;?>
		</ul>
	</div>
	<div class="hd1"><ul></ul></div>
	<span class="prev"></span>
	<span class="next"></span>
    </div><!--fullSlide end-->
      <!--------暂时不要这个首页轮播------------->
     <!--<ul class="pgwSlider">-->
    <?php foreach ($adList as $v):?>
        <li> <a href="<?php echo $v["url"] ?>" target="_blank"> <img src="<?php echo IMAGE_URL.'../'.$v['img_url']?>"></a> </li>
    <?php endforeach;?>

    <!--</ul>-->
    <!--------暂时不要这个首页轮播------------->
</div>
</div>

<?php

if(file_exists(FCPATH.UPLOAD_PATH."uploads/siteinfo/homeplate_".$this->session->userdata('app_info')["id"].".html"))
{
	include(FCPATH.UPLOAD_PATH."uploads/siteinfo/homeplate_".$this->session->userdata('app_info')["id"].".html");
}else
{
    include (FCPATH.UPLOAD_PATH."uploads/siteinfo/homeplate_0.html");
	

}?>

 <script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript" src="js/jquery.tabs.js"></script>
<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<script type="text/javascript">
//版块tabs
$(function(){
	//$("img[original]").lazyload({placeholder:"images/eh_logo.jpg" });
    $("img[original]").lazyload({effect: "fadeIn"});
	$('.eh_floor_box').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box2').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box3').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box4').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box5').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box6').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box7').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box8').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box9').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box10').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
	//部分区域图片延迟加载
	function lazyloadForPart(container) {
		container.find('img').each(function () {
			var original = $(this).attr("original");
			if (original) {
				$(this).attr('src', original).removeAttr('original');
			}
		});
	}
});
</script>

<!--首页轮播图-->
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".fullSlide").slide({

    titCell: ".hd1 ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".fullSlide .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});

</script>
