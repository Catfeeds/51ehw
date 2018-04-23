<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->

<style>
.macth_xv_categorys{ background:none;}
.macth_xv_nav li.macth_liactive a{ background:none;}
.macth-dropdown-menu{ display:none;}
.macth_xv_categorys .macth_xv_cat_catlist{ border:none}
.macth_xv_nav li a{ background:url(images/culture/biao.png) no-repeat left; display:block}
</style>



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
<?php
//$json_string = file_get_contents(base_url("data/category.json"));
//?>
<script>
<?php
		$json_string = file_get_contents(base_url("data/category.json"));
		?>
var viewModel = <?php echo $json_string;?>;
</script>
<script>
$(document).ready(function(){
    //类目菜单
    ko.applyBindings(viewModel);
});

</script>



<style>
/*.eh_navbar .macth_xv_categorys .macth_xv_cat_catlist{display:block;}
    .macth_xv_navlist .macth_xv_menu{padding-left: 180px;}
    .macth_xv_categorys{display: block}
    .macth_xv_categorys .macth_xv_cat_catlist{display: block;min-height: 435px;}*/
</style>

<!--导航 开始-->
    
	<!--店铺头部 开始-->
	<div class="guanjie_top">
    	<div class="guanjie_top_nei">
          <div class="guanjie_top_neit">
            <div class="guanjie_top_neit1">
            <span class="logo_t"><a href="http://www.51ehw.com/index.php/home/GoToShop/157"><img src="images/culture/culture_logo.png"/></a></span>
            <em><p class="gun">冠杰广告旗舰店</p><p><a href="javascript:;"><img src="images/culture/culture_t.png"/>收藏本店</a></p></em>
            <em><span class="gun_z"><img src="images/culture/culture_t5.png"/></span></em>
            <em><span class="gun_z1"><img src="images/culture/culture_t6.png"/></span></em>
            </div>
          </div>
        
        </div>
	
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar1 clearfix">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style=" background:none">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:;">本店所有商品<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
<!--                                 <h3> -->
                                    <!-- <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">精品上衣</a></span><s style="display: block;"></s> -->
<!--                                 </h3>  -->
                            </li>

                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                 <ul class="macth_xv_nav">
                        <li><a href="http://www.51ehw.com/index.php/home/GoToShop/157" style="width:160px; text-align:center">首页</a></li>
                        <li><a href="javascript:;" style="width:190px; text-align:center">媒体广告</a></li>
                        <li><a href="javascript:;" style="width:190px; text-align:center">餐饮娱乐</a></li>
                        <li><a href="javascript:;" style="width:190px; text-align:center">衣食住行</a></li>
                        <li><a href="javascript:;" style="width:190px; text-align:center">综合服务</a></li>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
    </div> 
    
    <!--轮播图-->
        <div class="painting_banner1">
      <div class="bd">
        <ul>
          <li _src="url(images/culture/culture_top1.jpg)"></li>
        </ul>
      </div>
    </div>
    
    <div class="guanjie_top_cone clearfix">
       <div class="guanjie_top_cone_n">
         <h5><img src="images/culture/culture_top27.jpg"/></h5>
        <ul>
          <li>
            <h6><img src="images/culture/culture_t8.png"/></h6>
            <div style="margin-left:13px;">
            <span><a href="javascript:;">点击领取</a></span>
            <p class="p_bott">满19元使用</p>
            <p>限量3000张</p>
            </div>
          </li>
            <li>
            <h6><img src="images/culture/culture_t9.png"/></h6>
              <div style="margin-left:26px;">
            <span><a href="#">点击领取</a></span>
            <p class="p_bott">满19元使用</p>
            <p>限量3000张</p>
            </div>
          </li>
            <li>
            <h6><img src="images/culture/culture_t10.png"/></h6>
              <div style="margin-left:28px;">
            <span><a href="javascript:;">点击领取</a></span>
            <p class="p_bott">满19元使用</p>
            <p>限量3000张</p>
            </div>
          </li>
            <li>
            <h6><img src="images/culture/culture_t11.png"/></h6>
              <div style="margin-left:37px;">
            <span><a href="javascript:;">点击领取</a></span>
            <p class="p_bott">满19元使用</p>
            <p>限量3000张</p>
            </div>
          </li>
        
         </ul>
       </div>
    </div>
    
    <div class="guanjie_top_conx">
      <div class="guanjie_top_conx_l">
        <div class="guanjie_top_conx_b">
          <a href="javascript:;"><img src="images/culture/culture_t1.png"/></a>
        </div>
        <div class="guanjie_top_conx_b1">
          <ul>
           <li>
           <img src="images/culture/culture_top6.jpg"/>
            <p><a  class="dingwei4"href="<?php echo site_url('goods/detail/1215');?>"></a></p>
           <div class="guanjie_top_conx_b1_n dingwei">
             <h5></h5>
             <p>古丽兰 18K金钻石戒指</p>
             <p class="juan4"><em><span class="juan">11495</span><samp class="juan1">提货权</samp></em><em style="margin-top:5px;"><span class="juan3">11495</span><samp class="juan2">提货权</samp></em></p>
             <h6><a href="<?php echo site_url('goods/detail/1215');?>">立即购买</a></h6>
           </div>
           </li>
             <li>
           <img src="images/culture/culture_top8.jpg"/>
           <p><a  class="dingwei2"href="<?php echo site_url('goods/detail/363');?>"></a></p>
           <p><a class="dingwei3"href="<?php echo site_url('goods/detail/267');?>"></a></p>
           <div class="guanjie_top_conx_b1_n dingwei1">
             <h5></h5>
             <p>古丽兰 18K金钻石戒指</p>
             <p class="juan4"><em><span class="juan">11495</span><samp class="juan1">提货权</samp></em><em style="margin-top:5px;"><span class="juan3">11495</span><samp class="juan2">提货权</samp></em></p>
             <h6><a href="javascript:;">立即购买</a></h6>
           </div>
           </li>
          </ul>
        </div> 
         <div class="guanjie_top_gu">
     <img src="images/culture/culture_top5.jpg"/>
      </div> 
      <div class="media_top">
      <div class="media_top_nei">
         <ul>
          <li><a href="javascript:;"> <img src="images/culture/culture_top9.jpg"/ width="582px" height="358px"></a></li>
          <li><a href="javascript:;"> <img src="images/culture/culture_top10.jpg"/width="582px" height="358px"></a></li>
          <li><a href="javascript:;"> <img src="images/culture/culture_top11.jpg"/width="381px" height="285px"></a></li>
          <li><a href="javascript:;"> <img src="images/culture/culture_top12.jpg"/width="381px" height="285px"></a></li>
          <li><a href="javascript:;"> <img src="images/culture/culture_top13.jpg"/width="381px" height="285px"></a></li>
         
         </ul>
        </div>
        
        <div class="media_top_nei_zhong">
          <h5> <img src="images/culture/culture_t2.png"/></h5>
            <ul>
            <li>
              <span><a href="<?php echo site_url('goods/detail/604');?>"><img src="images/culture/culture_top14.jpg"/></a></span>
              <p class="zhong_t1"> 市政府北与三环绕城高速交汇西北角</p>
              <div class="media_top_nei_zhong_t">
                 <h6>可视距离：50米至300米</h6> 
                 <em>周五狂欢价：<samp>M500000</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/604');?>">加入购物车></a></p>
              </div>
            </li>
            <li>
              <span><a href="<?php echo site_url('goods/detail/603');?>"><img src="images/culture/culture_top15.jpg"/></a></span>
              <p class="zhong_t1"> 市政府北与三环绕城高速交汇西北角</p>
              <div class="media_top_nei_zhong_t">
                 <h6>可视距离：50米至300米</h6> 
                 <em>周五狂欢价：<samp>M600000</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/603');?>">加入购物车></a></p>
              </div>
            </li>
             <li>
              <span><a href="<?php echo site_url('goods/detail/523');?>"><img src="images/culture/culture_top16.jpg"/></a></span>
              <p class="zhong_t1"> 南二环与西二环西南角单立柱高炮</p>
              <div class="media_top_nei_zhong_t">
                 <h6>可视距离：50米至300米</h6> 
                 <em>周五狂欢价：<samp>M380000</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/523');?>">加入购物车></a></p>
              </div>
            </li>
            <li>
              <span><a href="<?php echo site_url('goods/detail/587');?>"><img src="images/culture/culture_top17.jpg"/></a></span>
              <p class="zhong_t1"> 电子二路与太白南路交汇处</p>
              <div class="media_top_nei_zhong_t">
                 <h6>可视距离：50米至300米</h6> 
                 <em>周五狂欢价：<samp>M210000</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/587');?>">加入购物车></a></p>
              </div>
            </li>
            
            </ul>
        </div>
        
        <div class="media_top_nei_zhong2">
          <h5> <img src="images/culture/culture_t3.png"/></h5>
            <ul>
            <li>
              <span><a href="<?php echo site_url('goods/detail/1235');?>"><img src="images/culture/culture_top18.jpg"/></a></span>
              <p class="zhong_t1"> 首饰 18K金手链 礼品</p>
              <div class="media_top_nei_zhong_t2">
                 <h6>首饰 18K金手链 礼品</h6> 
                 <em>周五狂欢价：<samp>M1630</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/1235');?>">加入购物车></a></p>
              </div>
            </li>
            <li>
              <span><a href="<?php echo site_url('goods/detail/1231');?>"><img src="images/culture/culture_top19.jpg"/></a></span>
              <p class="zhong_t1">首饰 钻石吊坠+项链 0.81g</p>
              <div class="media_top_nei_zhong_t2">
                 <h6>首饰 钻石吊坠+项链 0.81g</h6> 
                 <em>周五狂欢价：<samp>M7700</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/1231');?>">加入购物车></a></p>
              </div>
            </li>
             <li>
              <span><a href="<?php echo site_url('goods/detail/1181');?>"><img src="images/culture/culture_top20.jpg"/></a></span>
              <p class="zhong_t1">古丽兰 18K金钻石戒指</p>
              <div class="media_top_nei_zhong_t2">
                 <h6> 古丽兰推崇完美的切工</h6> 
                 <em>周五狂欢价：<samp>M11883</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/1181');?>">加入购物车></a></p>
              </div>
            </li>
             <li>
              <span><a href="<?php echo site_url('goods/detail/1209');?>"><img src="images/culture/culture_top21.jpg"/></a></span>
              <p class="zhong_t1">首饰 钻石吊坠+项链</p>
              <div class="media_top_nei_zhong_t2">
                 <h6>首饰 钻石吊坠+项链</h6> 
                 <em>周五狂欢价：<samp>M7750</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/1209');?>">加入购物车></a></p>
              </div>
            </li>
            <li>
              <span><a href="<?php echo site_url('goods/detail/1211');?>"><img src="images/culture/culture_top22.jpg"/></a></span>
              <p class="zhong_t1">首饰 千足金挂坠（葫芦形）</p>
              <div class="media_top_nei_zhong_t2">
                 <h6>首饰 千足金挂坠（葫芦形）</h6> 
                 <em>周五狂欢价：<samp>M980</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/1211');?>">加入购物车></a></p>
              </div>
            </li>
            
            </ul>
        </div>
        
        <div class="media_top_nei_zhong1">
          <h5> <img src="images/culture/culture_t4.png"/></h5>
            <ul>
            <li>
              <span><a href="<?php echo site_url('goods/detail/374');?>"><img src="images/culture/culture_top23.jpg"/></a></span>
              <p class="zhong_t1">太奥广场 精装公寓</p>
              <div class="media_top_nei_zhong_t1">
                 <h6>房屋面积：46.92㎡ 五套房源</h6> 
                 <em>周五狂欢价：<samp>M351,290</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/374');?>">加入购物车></a></p>
              </div>
            </li>
            <li>
              <span><a href="<?php echo site_url('goods/detail/373');?>"><img src="images/culture/culture_top24.jpg"/></a></span>
              <p class="zhong_t1">莱安中心 </p>
              <div class="media_top_nei_zhong_t1">
                 <h6>曲江会展中心北门正对面</h6> 
                 <em>周五狂欢价：<samp>M8，366，935</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/373');?>">加入购物车></a></p>
              </div>
            </li>
             <li>
              <span><a href="<?php echo site_url('goods/detail/523');?>"><img src="images/culture/culture_top25.jpg"/></a></span>
              <p class="zhong_t1">都市之窗</p>
              <div class="media_top_nei_zhong_t1">
                 <h6> 金属拉丝机身混合硬盘</h6> 
                 <em>周五狂欢价：<samp>M3,399</samp></em>
                <p class="zhong_t2"> <a href="<?php echo site_url('goods/detail/367');?>">加入购物车></a></p>
              </div>
            </li>
            
            
            </ul>
        </div>
        
      </div>
    
  </div>      
    </div>
  
 
    </div>
<!--导航 结束-->

    <div class="activity_theme clearfix">
       
      </div>
   
    
   
   
    
  
 
<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>
<!----banner图片轮播------>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".painting_banner1 .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});



</script>
