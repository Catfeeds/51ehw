
<!--添加导航 预加载-->
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script><!--日期插件-->
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
<div style="position:relative">
<!-- 轮播图 -->
<div class="painting_banner1">
    <div class="fullSlide">
        <div class="bd">
        	<ul>
	  	    <?php foreach($banner_list as $v){;?>
                <li _src="url(<?php echo IMAGE_URL.$v["img_url"];?>)"><a href="<?php echo $v["url"] ?>" target="_blank"></a></li>
            <?php };?>
        	</ul>
        </div>
        <div class="hd1"><ul></ul></div>
        <span class="prev"></span>
        <span class="next"></span>
    </div>
</div>
<!-- 轮播图结束 -->
<div class="search-container" id="_j_index_search">
		<div class="search-group">
			<form id="hotelsearch" action="<?php echo site_url('goods/search');?>" method="post">
    			<div class="searchtab" id="_j_index_search_tab">
    				<ul class="clearfix">
    					<li class="tab-selected" data-index="0"><i></i>酒店</li>
    				</ul>
    				<div class="searchbar searchbar-hotel hide1"
    					id="_j_index_search_bar_hotel">
    					<div class="search-wrapper">
    						<div class="search-input">
    							<input name="sKeyWord" type="text" value="" placeholder="请输入目的地，关键词" id="_j_index_suggest_input_hotel" class="sKeyWord">
    						</div>
    						<div class="search-date" id="_j_check_in">
    							<input type="text" value="" placeholder="入住日期" onfocus="if(this.style.color == '') this.style.color='#ff7c05'" 
    							class="zijin1_1_con01_input01" name="start_time" onClick="WdatePicker()" readonly> <i class="icon-cal"></i>
    						</div>
    						<div class="search-date" id="_j_check_out">
    							<label><input type="text" value="" placeholder="离开日期" onfocus="if(this.style.color == '') this.style.color='#ff7c05'" 
    							class="zijin1_1_con01_input01" name="end_time" onClick="WdatePicker()" readonly></label> <i class="icon-cal"></i>
    						</div>
    					</div>
    					<div class="search-button" id="_j_index_suggest_btn_hotel">
    						<a id="search-hotel" role="button" href="javascript:void(0)"><i class="icon-search"></i></a>
    					</div>
    				</div>
    				<!--选择酒店级别弹窗开始-->
    				<div class="select-wrap" tabindex="2">
    					<div class="select-text" id="select-btn-show">酒店级别</div>
    					<div class="select-text" id="select-btn-hide">酒店级别</div>
    					<ul class="select-item" style="height:auto; max-height:300px;">
    					   <!-- <li>一星级</li><li>二星级</li><li>三星级</li><li>四星级</li><li>五星级</li> -->
    					<?php 
    					if( is_array($hotelRank) && $hotelRank!='' && count($hotelRank)>0){
    					    $hotelRank_list = $hotelRank;
    					    $hotelRank_value = '';
    					    foreach ($hotelRank_list as $v){
    					        if(substr($v['option_values'],strlen($v['option_values'])-1,1) == ';'){
    					            $hotelRank_value .= $v['option_values'];
    					        }else{
    					            $hotelRank_value .= $v['option_values'].';';
    					        }
    					    }
    					    $hotelRank_array = array_flip(array_flip(explode(';',$hotelRank_value)));
    					    foreach ($hotelRank_array as $v){
    					        if($v != ''){
    					        ?>
    					        <li>
    					        	<?php echo $v;?>
    					        </li>
    					    <?php }
    					    }
    					} ?>
    					</ul>
    				</div>
    				<!--选择酒店级别弹窗结束-->
    			</div>
			</form>
		</div>
	</div>
</div>
<!--热门推荐开始-->       
    <div class="housing_header1 clearfix">
     <div class="mr_frbox1"> 
      <div class="tempWrap1">
          <h4><a href="#">热门推荐</a></h4> 
      </div>
     <ul>
       <li>
         <div class="mr_frbox1_ne">
           <h5><a href="<?php echo site_url('goods/detail/403');?>"><img src="images/jiu1.jpg"/></a></h5>
           <p class="mr_frbox1_ne1"><a href="<?php echo site_url('goods/detail/403');?>">西安喜来登大酒店</a></p>
           <p class="mr_frbox1_ne2">行政间住宿券 豪华套/标准套 含双早</p>
           <h6><span>1,650.00 </span><small><a href="<?php echo site_url('goods/detail/403');?>">详情 ></a></small></h6>
         </div>
       </li>
      <li>
         <div class="mr_frbox1_ne">
           <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193"><img src="images/jiu4.jpg"/></a></h5>
           <p class="mr_frbox1_ne1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">西安桃源假日酒店</a></p>
           <p class="mr_frbox1_ne2">【酒店/住宿】西安桃源假日酒店 四星级酒店服务 桃源酒店 大床房/标准间 无早 免费宽带</p>
           <h6><span>345.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">详情 ></a></small></h6>
         </div>
       </li>
       <li>
         <div class="mr_frbox1_ne">
           <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/1831"><img src="images/jiu5.jpg"/></a></h5>
           <p class="mr_frbox1_ne1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/1831">清水庄园</a></p>
           <p class="mr_frbox1_ne2">清水庄园占地400亩，环绕在3000亩的生态林中，这不仅仅是一个度假酒店，也不仅仅是一个有机农场，也不只是一个温泉SPA，他是一种生活方式</p>
           <h6><span>10,000.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/1831">详情 ></a></small></h6>
         </div>
       </li>
       <li>
         <div class="mr_frbox1_ne">
           <h5><a href="<?php echo site_url('goods/detail/1591');?>"><img src="images/jiu6.jpg"/></a></h5>
           <p class="mr_frbox1_ne1"><a href="<?php echo site_url('goods/detail/1591');?>">西安大唐西市酒店</a></p>
           <p class="mr_frbox1_ne2">五星级豪华服务 住宿/会议/休闲/娱乐</p>
           <h6><span>688.00 </span><small><a href="<?php echo site_url('goods/detail/1591');?>">详情 ></a></small></h6>
         </div>
       </li>
       <li>
         <div class="mr_frbox1_ne">
           <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322"><img src="images/jiu7.jpg"/></a></h5>
           <p class="mr_frbox1_ne1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">西安群贤莊园度假酒店</a></p>
           <p class="mr_frbox1_ne2">【酒店/住宿】西安群贤莊园度假酒店</p>
           <h6><span>6088.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">详情 ></a></small></h6>
         </div>
       </li>
     </ul>
   </div>
    </div> <!--热门推荐结束-->     
    
    <!--今日热卖开始-->
   <div class="housing_header1 clearfix">
      <div class="mr_frbox2"> 
       <div class="tempWrap1">
          <h4><a href="#">今日特卖</a></h4> 
      </div>
     <div class="tempWrap2">
       <ul>
          <li class="tempWrap2_nei">
            <div class="mr_frbox1_ne1">
                 <h5><a href="http://www.51ehw.com/goods/detail/2100"><img src="images/jiu2.jpg"/></a></h5>
                 <div class="mr_frbox1_rigth">
                    <h3><a href="http://www.51ehw.com/goods/detail/2100">西部王朝酒店</a></h3> 
                    <p>西部王朝酒店储值卡（1000元）</p>
                    <h6>1,000.00 </h6>
                    <span class="mr_frbox1_rigth_bo"><a href="http://www.51ehw.com/goods/detail/2100">查看详情</a></span>
                 </div>
            </div>
          </li>
         <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/403');?>"><img src="images/jiu10.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/403');?>">西安喜来登大酒店</a></p>
           <p class="mr_frbox1_2">行政间住宿券 豪华套/标准套 含双早</p>
           <h6><span>1,650.00 </span><small><a href="<?php echo site_url('goods/detail/403');?>">详情 ></a></small></h6>
           </div>
         </li>
         <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/1591');?>"><img src="images/jiu11.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/1591');?>">西安大唐西市酒店</a></p>
           <p class="mr_frbox1_2">五星级豪华服务 住宿/会议/休闲/娱乐</p>
           <h6><span>688.00 </span><small><a href="<?php echo site_url('goods/detail/1591');?>">详情 ></a></small></h6>
           </div>
         </li>
       </ul>
     
       <ul>
          <li class="tempWrap2_nei">
            <div class="mr_frbox1_ne1">
                 <h5><a href="http://www.51ehw.com/goods/detail/1831"><img src="images/jiu8.jpg"/></a></h5>
                 <div class="mr_frbox1_rigth">
                    <h3><a href="http://www.51ehw.com/goods/detail/1831">清水庄园</a></h3> 
                    <p>清水庄园占地400亩，环绕在3000亩的生态林中，这不仅仅是一个度假酒店，也不仅仅是一个有机农场，也不只是一个温泉SPA，他是一种生活方式</p>
                    <h6>10,000.00 </h6>
                    <span class="mr_frbox1_rigth_bo"><a href="http://www.51ehw.com/goods/detail/1831">查看详情</a></span>
                 </div>
            </div>
          </li>
         <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2191"><img src="images/jiu12.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2191">清水湾</a></p>
           <p class="mr_frbox1_2">【温泉洗浴】清水湾 乐汤汇 洗浴温泉酒店 卡/券</p>
           <h6><span>58.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2191">详情 ></a></small></h6>
           </div>
         </li>
         <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322"><img src="images/jiu13.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">西安群贤莊园度假酒店</a></p>
           <p class="mr_frbox1_2">【酒店/住宿】西安群贤莊园度假酒店</p>
           <h6><span>6088.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">详情 ></a></small></h6>
           </div>
         </li>
       </ul>     
     </div>
      
  </div>
   </div> <!--今日热卖结束--> 
   
   <!--国内热门酒店开始-->
    <div class="housing_header1 clearfix">
        <div class="mr_frbox2"> 
       <div class="tempWrap1">
          <h4><a href="#">国内热门酒店</a></h4> 
      </div>
      <div class="tempWrap2">
      <ul>
       <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/403');?>"><img src="images/jiu14.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/403');?>">西安喜来登大酒店</a></p>
           <p class="mr_frbox1_2">行政间住宿券 豪华套/标准套 含双早</p>
           <h6><span>1,650.00 </span><small><a href="<?php echo site_url('goods/detail/403');?>">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/1591');?>"><img src="images/jiu15.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/1591');?>">西安大唐西市酒店</a></p>
           <p class="mr_frbox1_2">五星级豪华服务 住宿/会议/休闲/娱乐</p>
           <h6><span>688.00 </span><small><a href="<?php echo site_url('goods/detail/1591');?>">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193"><img src="images/jiu16.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">西安桃源假日酒店</a></p>
           <p class="mr_frbox1_2">【酒店/住宿】西安桃源假日酒店 四星级酒店服务 桃源酒店 大床房/标准间 无早 免费宽带</p>
           <h6><span>345.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322"><img src="images/jiu17.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">西安群贤莊园度假酒店</a></p>
           <p class="mr_frbox1_2">【酒店/住宿】西安群贤莊园度假酒店</p>
           <h6><span>6088.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">详情 ></a></small></h6>
           </div>
         </li>
      </ul>
      <ul>
       <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/411');?>"><img src="images/jiu18.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/411');?>">天目温泉假日酒店</a></p>
           <p class="mr_frbox1_2">天目温泉假日酒店储值卡（3000元） 健身/游泳/住宿/温泉/餐饮/休闲/娱乐</p>
           <h6><span>3000.00 </span><small><a href="<?php echo site_url('goods/detail/411');?>">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193"><img src="images/jiu19.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">西安桃源假日酒店</a></p>
           <p class="mr_frbox1_2">【酒店/住宿】西安桃源假日酒店 四星级酒店服务 桃源酒店 大床房/标准间 无早 免费宽带</p>
           <h6><span>345.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2193">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322"><img src="images/jiu20.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">西安群贤莊园度假酒店</a></p>
           <p class="mr_frbox1_2">【酒店/住宿】西安群贤莊园度假酒店</p>
           <h6><span>6088.00 </span><small><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2322">详情 ></a></small></h6>
           </div>
         </li>
          <li class="tempWrap2_nei2">
           <div class="mr_frbox1_ne1">
            <h5><a href="<?php echo site_url('goods/detail/403');?>"><img src="images/jiu21.jpg"/></a></h5>
           <p class="mr_frbox1_1"><a href="<?php echo site_url('goods/detail/403');?>">西安喜来登大酒店</a></p>
           <p class="mr_frbox1_2">行政间住宿券 豪华套/标准套 含双早</p>
           <h6><span>1,650.00 </span><small><a href="<?php echo site_url('goods/detail/403');?>">详情 ></a></small></h6>
           </div>
         </li>
      </ul>
      
      </div>
      </div>
    </div>  <!--国内热门酒店结束-->
<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>
<script>/*select按钮*//*选择酒店级别*/
$('#select-btn-show').on('click', function(){
	$("#select-btn-show").hide();
	$("#select-btn-hide").show();
	$(".select-item").show();
});
$('#select-btn-hide').on('click', function(){
	$("#select-btn-hide").hide();
	$("#select-btn-show").show();
	$(".select-item").hide();
   document.getElementById("select-btn-show").style.color = "#ff7c05";/*改变选择酒店级别字体颜色*/

});
/*item*/
$('.select-item>li').on('click', function(){
	var index=$(this).index();
	index++;
	$("#select-btn-show").show();
	$("#select-btn-hide").hide();
	$(".select-item").hide();
	$(".select-text").html($(this).html());
   document.getElementById("select-btn-show").style.color = "#ff7c05";/*改变选择酒店级别字体颜色*/

});
/*失去焦点*/
$(".select-wrap").on('blur',function(){
	$("#select-btn-show").show();
	$("#select-btn-hide").hide();
	$(".select-item").hide();
});
</script>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd1 ul",

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
<script type="text/javascript">
$(function () {
    $("#search-hotel").click(function(){
    	var start_time = $("input[name=start_time]").val();
    	var end_time = $("input[name=end_time]").val();
    	var rank = $.trim($("#select-btn-show").html());
    	var keyword = $("input[name=sKeyWord]").val();
    	if(rank=='酒店级别' && keyword==''){
    		$("input[name=sKeyWord]").css("border-color","#ff7c05");
    		$("input[name=sKeyWord]").css("width","294px");/*改变目的地、关键字输入框字体颜色*/
    	}else{
    		//$('#hotelsearch').attr('action', "<?php //echo site_url('goods/search_with_attrs');?>"  + "/1696/" + (keyword!=''?keyword+'/':'null/') 
//     				+ "?rank="+(rank!='酒店级别'?encodeURI(rank):'')+"&start_time=" + start_time + "&end_time="+end_time);
    		$('#hotelsearch').attr('action', "<?php echo site_url('goods/search');?>"  + "/1696/" + (keyword!=''?keyword+'/':'') 
    				+ "?hotelrank="+(rank!='酒店级别'?encodeURI(rank):'')+"&start_time=" + start_time + "&end_time="+end_time);
    		$("#hotelsearch").submit();
    	}
 	});
});





</script>