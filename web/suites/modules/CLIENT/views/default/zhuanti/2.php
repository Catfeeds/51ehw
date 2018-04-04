<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->
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


<!--<div class="painting_banner">
        <img src="images/meishi56.png">
    </div>
    <div class="beverage_top clearfix">
        <p class="company_title_tj">餐饮美食</p>
        <div class="outdoor_designs">

        <?php //foreach ($goods as $key => $good):?>
            <a href="<?php //echo site_url('goods/detail/'.$good['id']);?>"
						title="<?php //echo $good['name'];?>"><ul <?php //echo $key!=0&&$key%4==3?"style='margin-right:0'":"" ?>>
                <div class="painting_img"><img src="<?php //echo base_url($good['image_name']."_270".$good['file_ext']);?>"></div>
                <li><?php //echo $good['name'];?></li>
                <li style="color: #c32d05; font-size: 16px">易货价: <?php //echo number_format($good['vip_price'],2);?> 货豆</li>
                <h3 class="h3_color">(0人)评价</h3>
            </ul></a>
            <?php //endforeach;?>
        </div>
    </div>-->
    
    <div class="painting_banner1">
    <div class="bd">
    <ul>
      <li _src="url(images/banner5.jpg)"></li>
    </ul>
   </div>
   </div>
       <!--搜索开始-->
      <div class="housing_header1 clearfix">
     <div class="adsearch ad">
         <div id="search">
      
        <input name="search_canyin" id="btn" type="text" class="btn" value="请输入关键词" onfocus="if(this.value=='请输入关键词')this.value=''; this.style.color ='#333';" onblur="if(this.value == ''){this.value='请输入关键词'; this.style.color ='#cecece';}" style="color: rgb(206, 206, 206);">
        <span><a href="javascript:search()"></a></span> </div>
        
        </div> 
        </div><!--搜索结束-->
         <!--今日特卖开始-->
      <div class="housing_header1 clearfix">
        <div class="mr_frbox3"> 
       <div class="aurant">
                <keyword><span><img src="images/caiyin.png"/></span><source>今日特卖</source></keyword>
              </div>
      <div class="estaurant">
      <ul>
       <li class="estaurant_nei2">
           <div class="emr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/1010');?>"><img src="images/cait.jpg"/></a></h5>
           <p class="emr_frbox1_1"><a href="<?php echo site_url('goods/detail/1010');?>">德豪堡</a></p>
           <p class="emr_frbox1_3">餐饮美食 自助 德豪堡国际自助美食 午/晚用餐券（69元）</p>
            <div class="chakan"><a href="<?php echo site_url('goods/detail/1010');?>">查看详情</a></div>
           </div>
         </li>
          <li class="estaurant_nei2">
           <div class="emr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/441');?>"><img src="images/cait1.jpg"/></a></h5>
           <p class="emr_frbox1_1"><a href="<?php echo site_url('goods/detail/441');?>">苏浙会馆</a></p>
           <p class="emr_frbox1_3">餐饮/美食 苏浙会馆1000元储值卡 上海菜</p>
            <div class="chakan"><a href="<?php echo site_url('goods/detail/441');?>">查看详情</a></div>
           </div>
         </li>
          <li class="estaurant_nei2">
           <div class="emr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/288');?>"><img src="images/cait2.jpg"/></a></h5>
           <p class="emr_frbox1_1"><a href="<?php echo site_url('goods/detail/288');?>">鑫华府</a></p>
           <p class="emr_frbox1_3">餐饮美食 高端餐饮顶级食府 鑫华府餐饮储值卡（1000元） 国宴极品菜系</p>
            <div class="chakan"><a href="<?php echo site_url('goods/detail/288');?>">查看详情</a></div>
           </div>
         </li>
          <li class="estaurant_nei2">
           <div class="emr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/447');?>"><img src="images/cait3.jpg"/></a></h5>
           <p class="emr_frbox1_1"><a href="<?php echo site_url('goods/detail/447');?>">渝老道</a></p>
           <p class="emr_frbox1_3">餐饮美食/火锅/干锅 渝老道火锅餐饮储值卡1000元</p>
            <div class="chakan"><a href="<?php echo site_url('goods/detail/447');?>">查看详情</a></div>
           </div>
         </li> 
           <li class="estaurant_nei">
            <div class="emr_frbox1_ne1">
               <h5><a href="<?php echo site_url('goods/detail/271');?>"><img src="images/cait4.jpg"/></a></h5>
               <div class="estaurant_nei_left">
                <p class="emr_frbox1_4"><a href="<?php echo site_url('goods/detail/271');?>">平壤银畔</a></p>
                <p class="emr_frbox1_5">餐饮/美食 朝鲜菜 中朝国宴 平壤银畔馆储值卡（5000元）</p>
               </div>
                 <div class="chakan_1"><a href="<?php echo site_url('goods/detail/271');?>">查看详情</a></div>
            </div>
         </li>
        <li class="estaurant_nei">
            <div class="emr_frbox1_ne1">
               <h5><a href="<?php echo site_url('goods/detail/390');?>"><img src="images/cait5.jpg"/></a></h5>
               <div class="estaurant_nei_left">
                <p class="emr_frbox1_4"><a href="<?php echo site_url('goods/detail/390');?>">悦庭国菜美食家</a></p>
                <p class="emr_frbox1_5">餐饮/美食 悦庭国菜储值卡（1000元） 粤菜</p>
               </div>
                 <div class="chakan_1"><a href="<?php echo site_url('goods/detail/390');?>">查看详情</a></div>
            </div>
         </li>
      </ul>
      </div>
      </div>
    </div> <!--今日特卖结束-->
    <!--商家推荐开始-->
     <div class="housing_header1 clearfix">
       <div class="aurant">
              <keyword><span><img src="images/caiyin.png"/></span><source>商家推荐</source></keyword>
         </div>
       <div class="estaurant1">
          <ul>
            <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="http://www.51ehw.com/goods/detail/2145"><img src="images/cait12.jpg"/></a></h5>
                 <h6><a href="http://www.51ehw.com/goods/detail/2145">牛儿源</a></h6>
                 <p>餐饮美食/火锅/干锅 牛儿源鲜切牛肉火锅储值卡（ 4000元/张）</p>
                  <div class="chakan_2"><a href="http://www.51ehw.com/goods/detail/2145">查看详情</a></div>
            </div>  
          </li>
           <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="<?php echo site_url('goods/detail/1001');?>"><img src="images/cait7.jpg"/></a></h5>
                 <h6><a href="<?php echo site_url('goods/detail/1001');?>">江南茶馆</a></h6>
                 <p>江南韵茶馆储值卡 休闲/养生/茶馆</p>
                  <div class="chakan_2"><a href="<?php echo site_url('goods/detail/1001');?>">查看详情</a></div>
            </div>  
          </li>
          <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="<?php echo site_url('goods/detail/1271');?>"><img src="images/cait8.jpg"/></a></h5>
                 <h6><a href="<?php echo site_url('goods/detail/1271');?>">山西会馆</a></h6>
                 <p>餐饮美食 山西会馆 晋菜</p>
                  <div class="chakan_2"><a href="<?php echo site_url('goods/detail/1271');?>">查看详情</a></div>
            </div>  
          </li>
           <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="<?php echo site_url('goods/detail/441');?>"><img src="images/cait9.jpg"/></a></h5>
                 <h6><a href="<?php echo site_url('goods/detail/441');?>">苏浙会馆</a></h6>
                 <p>餐饮/美食 苏浙会馆1000元储值卡 上海菜</p>
                  <div class="chakan_2"><a href="<?php echo site_url('goods/detail/441');?>">查看详情</a></div>
            </div>  
          </li>
           <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="<?php echo site_url('goods/detail/288');?>"><img src="images/cait10.jpg"/></a></h5>
                 <h6><a href="<?php echo site_url('goods/detail/288');?>">鑫华府</a></h6>
                 <p>餐饮美食 高端餐饮顶级食府 鑫华府餐饮储值卡（1000元） 国宴极品菜系</p>
                  <div class="chakan_2"><a href="<?php echo site_url('goods/detail/288');?>">查看详情</a></div>
            </div>  
          </li>
          <li class="estaurant_nei3">
               <div class="emr_frbox1_ne1">
                 <h5><a href="<?php echo site_url('goods/detail/447');?>"><img src="images/cait11.jpg"/></a></h5>
                 <h6><a href="<?php echo site_url('goods/detail/447');?>">渝老道</a></h6>
                 <p>餐饮美食/火锅/干锅 渝老道火锅餐饮储值卡1000元</p>
                  <div class="chakan_2"><a href="<?php echo site_url('goods/detail/447');?>">查看详情</a></div>
            </div>  
          </li>
          </ul>     
           </div>    
            </div>   <!--商家推荐结束-->
<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script><!----banner图片轮播------>
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

function search(){ 
	var url = "<?php echo site_url('goods/Search_Type_Goods/189').'/'?>"+$('#btn').val();
	window.location= url;
}
</script>