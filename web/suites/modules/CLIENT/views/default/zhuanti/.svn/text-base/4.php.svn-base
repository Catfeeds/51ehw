<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script>
<!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script>
<!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script>
<!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script>
<!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script>
<!--banner图片切换-->

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
        <img src="images/guanggaowei8.png">
    </div>-->
<!-- <div class="housing_header clearfix">-->
<!-- 二手房展位 -->
<!--<p class="company_title_tj">西安房源精选</p>
        <div class="secondary">
        <?php //foreach ($goods as $key => $good):?>
            <a href="<?php //echo site_url('goods/detail/'.$good['id']);?>"
						title="<?php //echo $good['name'];?>"><ul <?php //echo $key%4==3&&$key!=0 ?"style='margin-right:0'":"" ?>>
                <div class="painting_img"><img src="<?php //echo base_url($good['image_name']."_270".$good['file_ext']);?>"></div>
                <li><?php //echo $good['name'];?></li>
                <li style="color: #c32d05; font-size: 16px">易货价: <?php //echo number_format($good['vip_price'],2);?> 货豆</li>
                <h3 class="h3_color">(0人)评价</h3>
            </ul></a>
            <?php //endforeach;?>
        </div>
        <!-- end -->
<!-- </div>-->
<div class="painting_banner1">
	<div class="bd">
		<ul>
			<li _src="url(images/banner4.jpg)"></li>
		</ul>
	</div>
</div>
<!--房屋筛选开始-->

<div class="housing_header2 clearfix">
	<div class="mr_frbox2">
		<div class="screening">
			<div class="screening_top" id="list">
				<h4>
					<a href="javascript:;">房屋筛选</a>
				</h4>
				<ul class="screening_ul">
				
				 <li><sub>价格:</sub><em class="em3">
    				 <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 1 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/4?'.$canshu.'price=1#list')?>">30万以下</a></span>
    				 <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 2 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/4?'.$canshu.'price=2#list')?>">30-70万</a></span>
    				 <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 3 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/4?'.$canshu.'price=3#list')?>">70-90万</a></span>
    				 <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 4 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/4?'.$canshu.'price=4#list')?>">90-120万</a></span>
    				 <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 5 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/4?'.$canshu.'price=5#list')?>">120万以上</a></span>
				 </em></li>
				
				
                <?php foreach ($classify as $k => $v){?>
                    <?php if($v['attr_type'] == 'radio'):?>
                        <li id="<?php echo $v['id']?>"><sub><?php echo $v['attr_name']?>:</sub>
                            <em class="em3 limit_">
                                <?php foreach ($v['option_values'] as $val):?>
            						    <span  class="number_2 <?php echo isset($_GET[$v['id']]) && $_GET[$v['id']] == "$val" ? 'fangzi' :'';?> "><a href="<?php echo site_url('goods/zhuanti/4/?'.$canshu.$v['id'].'='.$val.'&#list')?>"><?php echo $val;?></a></span> 
            						<?php endforeach;?>
                            </em>
                        </li>
                    <?php endif;?>
                <?php };?>
<!--                  <li>售价:<em class="em1"><span><a href="#">不限</a></span> <span><a href="#">50万以下</a></span><span class="fangzi"><a href="#">50－100万</a></span> -->
					<!--                 <span><a href="#">100－150万</a></span><span><a href="#">150－200万</a></span><span><a href="#">200万以上</a></span> -->
					<!--                 </em>  -->
					<!--                 <em class="em2"><input type="text" value="" name="price_min" class="screening_in"><samp class="screening_samp">-</samp><input type="text" value="" name="price_max" class="screening_in1"><samp class="screening_span1"><a href="#">确定</a></samp></em> -->
					<!--                 </li>  -->
					<!--                  <li>面积:<em class="em1"><span><a href="#">不限</a></span> <span><a href="#">50平以下</a></span><span><a href="#">50－80平</a></span> -->
					<!--                 <span class="fangzi"><a href="#">80－100平</a></span><span><a href="#">100平以上</a></span> -->
					<!--                 </em> -->
					<!--                  <em class="em2"><input type="text" value="" name="price_min" class="screening_in"><samp class="screening_samp">-</samp><input type="text" value="" name="price_max" class="screening_in1"><samp class="screening_span1"><a href="#">确定</a></samp></em> -->
					<!--                 </li> -->
					<!--                  <li>房型:<em  class="em1"><span><a href="#">不限</a></span> <span><a href="#">一室</a></span><span><a href="#">二室</a></span> -->
					<!--                 <span class="fangzi"><a href="#">三室</a></span><span><a href="#">四室</a></span><span><a href="#">四室以上</a></span> -->
					<!--                 </em></li> -->
				</ul>
				<div class="screening_xia">
					<span>更多查找条件:</span>
					<?php foreach ($classify as $k => $v){?>
    					<?php if($v['attr_type'] == 'select'):?>
    						<div class="select-wrap1" tabindex="2">
                             <a href="javascript:void(0);">
        						<div class="select-text" id="select-btn-show" onclick="Select_Show(this)"><?php echo $v['attr_name']?></div>
        						<div class="select-text" id="select-btn-hide"><?php echo $v['attr_name']?></div>
                              </a>
        						<ul class="select-item1">
        						<?php foreach ($v['option_values'] as $val):?>
        							<li><a href="<?php echo site_url('goods/zhuanti/4/?'.$canshu.$v['id'].'='.$val.'#list')?>"><?php echo $val?></a></li>
        					    <?php endforeach;?>
        						</ul>
        					</div>
                           
        			    <?php endif;?>
				    <?php };?>
					<div id="search" class="search_1">
						<input name="searchword" id="btn" type="text" class="btn"
							placeholder="请输入关键词"> <strong><a href="javascript:search()"></a></strong>
					</div>
				</div>
			</div>
		</div>
		<div class="condition">
			<samp>已选条件:</samp> 
           <?php if(isset($attr_get) && $attr_get && count($attr_get) > 0):?>
               <?php foreach ($attr_get as $k=>$v):?>
                   <div class="tips-box-r">
				<div class="tips-content"><?php echo $v?><small id="chai"><a
						href="<?php echo site_url('goods/zhuanti/4/'.$k.'/?'.$canshu.'#list')?>">x</a></small>
				</div>
				<span></span>
			</div>
               <?php endforeach;?>
           
           <?php else:?>
             
             <div class="tips_wu" style="display: block">
				<div class="tips-content">暂无选择任何条件!</div>
				<span></span>
			</div> 
           <?php endif;?>
         </div>
	</div>
</div>
<!--房屋筛选结束-->
<!--房源信息-->
<div class="housing_header2 clearfix">
	<div class="mr_frbox2">
		<div class="housing">
			<div class="housing_top">
				<p>
					<samp>房源信息</samp>
					<em>共有<span><?php echo $total;?></span>套房屋信息
					</em>
				</p>
			</div>
			<ul>
           <?php foreach ($goods_list as $v){?>
             <li>
					<div class="housing_left">
						<strong class="strong_1"><a
							href="<?php echo site_url('goods/detail/'.$v['id'])?>"><img
								src="<?php echo IMAGE_URL.$v['goods_thumb']?>" /></a></strong>
						<div class="housing_left1">
							<h4>
								<a href="<?php echo site_url('goods/detail/'.$v['id'])?>"><?php echo $v['name']?></a>
							</h4>
							<p class="housing_left2">
								<em><?php echo str_replace(',',"&nbsp|&nbsp",$v['attr_value']);?></em>
							</p>
							<!--                    <p>繁华地段 恒宝路地铁房</p> -->
							<!--                    <h5><a href="#">冠杰21城传媒</a></h5> -->
						</div>
					</div>
					<div class="housing_right">
						<small> <?php echo ($v['vip_price']>=10000) ?   (floor(($v['vip_price']/10000)*10)/10).'万货豆' :substr($v['vip_price'],0,-3).'货豆'?> </small>
					</div>
				</li>
             <?php };?>
<!--              <li> -->
				<!--                <div class="housing_left"> -->
				<!--                  <strong class="strong_1"><a href="#"><img src="images/fab.jpg"/></a></strong> -->
				<!--                  <div class="housing_left1"> -->
				<!--                    <h4><a href="#">莱安中心   西安市   商业办公楼</a></h4> -->
				<!--                    <p class="housing_left2"><em>莱安中心</em><em>2室 2厅</em><em>48平 </em><em>朝南</em></p> -->
				<!--                    <p>繁华地段 恒宝路地铁房</p> -->
				<!--                    <h5><a href="#">冠杰21城传媒</a></h5> -->
				<!--                  </div> -->
				<!--                </div>  -->
				<!--                 <div class="housing_right"> -->
				<!--                   <small> 550万 </small> -->
				<!--                 </div>  -->
				<!--              </li> -->
				<!--              <li> -->
				<!--                <div class="housing_left"> -->
				<!--                  <strong class="strong_1"><a href="#"><img src="images/fab.jpg"/></a></strong> -->
				<!--                  <div class="housing_left1"> -->
				<!--                    <h4><a href="#">莱安中心   西安市   商业办公楼</a></h4> -->
				<!--                    <p class="housing_left2"><em>莱安中心</em><em>2室 2厅</em><em>48平 </em><em>朝南</em></p> -->
				<!--                    <p>繁华地段 恒宝路地铁房</p> -->
				<!--                    <h5><a href="#">冠杰21城传媒</a></h5> -->
				<!--                  </div> -->
				<!--                </div>  -->
				<!--                 <div class="housing_right"> -->
				<!--                   <small> 550万 </small> -->
				<!--                 </div>  -->
				<!--              </li> -->
				<!--              <li> -->
				<!--                <div class="housing_left"> -->
				<!--                  <strong class="strong_1"><a href="#"><img src="images/fab.jpg"/></a></strong> -->
				<!--                  <div class="housing_left1"> -->
				<!--                    <h4><a href="#">莱安中心   西安市   商业办公楼</a></h4> -->
				<!--                    <p class="housing_left2"><em>莱安中心</em><em>2室 2厅</em><em>48平 </em><em>朝南</em></p> -->
				<!--                    <p>繁华地段 恒宝路地铁房</p> -->
				<!--                    <h5><a href="#">冠杰21城传媒</a></h5> -->
				<!--                  </div> -->
				<!--                </div>  -->
				<!--                 <div class="housing_right"> -->
				<!--                   <small> 550万 </small> -->
				<!--                 </div>  -->
				<!--              </li> -->
				<!--              <li> -->
				<!--                <div class="housing_left"> -->
				<!--                  <strong class="strong_1"><a href="#"><img src="images/fab.jpg"/></a></strong> -->
				<!--                  <div class="housing_left1"> -->
				<!--                    <h4><a href="#">莱安中心   西安市   商业办公楼</a></h4> -->
				<!--                    <p class="housing_left2"><em>莱安中心</em><em>2室 2厅</em><em>48平 </em><em>朝南</em></p> -->
				<!--                    <p>繁华地段 恒宝路地铁房</p> -->
				<!--                    <h5><a href="#">冠杰21城传媒</a></h5> -->
				<!--                  </div> -->
				<!--                </div>  -->
				<!--                 <div class="housing_right"> -->
				<!--                   <small> 550万 </small> -->
				<!--                 </div>  -->
				<!--              </li> -->
			</ul>
			<div style="width: 1200px; overflow: hidden;">
				<div class="pingjia_jilu" style="margin-left: 30px">
					<p>显示 <?php if(count($goods_list) > 0) echo ($cu_page -1)*$per_page + 1; else echo '0';?> 到 <?php if($cu_page*$per_page > $total) echo $total; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total?> 条数据</p>
				</div>
				<div class="pingjia_showpage" style="margin-right: 30px">
                    	<?php echo $page;?>
                    	  
<!--                     	<a href="#" class="lPage">上一页</a> -->
					<!--                         <a href="#">1</a> -->
					<!--                         <a href="#">2</a> -->
					<!--                         <a class="cpage">3</a> -->
					<!--                         <a href="#">4</a> -->
					<!--                         <a href="#">5</a> -->
					<!--                         <a href="#">6</a> -->
					<!--                         <a href="#">7</a> -->
					<!--                         <a href="#">8</a> -->
					<!--                         <span>…</span> -->
					<!--                         <a href="#" class="lPage">下一页</a> -->
				</div>
			</div>
		</div>
	</div>
	<!--房源结束-->
	<!--点击换页开始-->
	<!--  <div class="lian">
      <ul class="lzhong_4">
        <li style="display:none"><a  class="previous"href="#">上一页</a></li>
        <li style="display:none"><a  class="page" href="#">前页</a></li>
        <li><a class="linkOn">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">8</a></li>
        <li><a href="#">9</a></li>
        <li><a  class="next"href="#">下一页</a></li>
        <li><a  class="page1" href="#">末页</a></li>
        <span class="page2">共100页</span>
      </ul>
     </div> -->
	<!--点击换页结束-->


	<div class="side" style="display:none; ">
		<ul>
			<li><a href="javascript:void(0);"><div class="sidebox">
						<samp class="icon-gouwuche"></samp>
						<span>购物车</span>
					</div></a><i class="yaun">2</i></li>
			<li><a href="javascript:void(0);"><div class="sidebox">
						<samp class="icon-dingdan"></samp>
						<span>下订单</span>
					</div></a></li>
			<li><a href="javascript:void(0);"><div class="sidebox">
						<samp class="icon-zaixiankefu"></samp>
						<span>在线客服</span>
					</div></a></li>
			<li style="border: none;"><a href="javascript:goTop();"
				class="sidetop"><samp class="icon-fanhuidingbu"></samp></a></li>
		</ul>
	</div>
	<!--添加导航 后加载-->
	<script type="text/javascript" src="js/navbar.js"></script>
	<!--painting_banner1图片切换-->
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
	<script>/*select按钮*//*选择楼龄级别*/

	function Select_Show(obj){
		
		if($(obj).parent('a').next().css('display')=='none' ){ 
			$(obj).parent('a').next().show();	
	    }else{ 
	    	$(obj).parent('a').next().hide();
		}
	}
	/*
$('.select-wrap1 #select-btn-show').on('click', function(){
	$(".select-wrap1 #select-btn-show").hide();
	$(".select-wrap1 #select-btn-hide").show();
	$(".select-wrap1 .select-item1").show();
});
$('.select-wrap1 #select-btn-hide').on('click', function(){
	$(".select-wrap1 #select-btn-hide").hide();
	$(".select-wrap1 #select-btn-show").show();
	$(".select-wrap1 .select-item1").hide();
});
/*item*/
// $('.select-wrap1 .select-item1>li').on('click', function(){
// 	var index=$(this).index();
// 	index++;
// 	$(".select-wrap1 #select-btn-show").show();
// 	$(".select-wrap1 #select-btn-hide").hide();
// 	$(".select-wrap1 .select-item1").hide();
// 	$(".select-wrap1 .select-text").html($(this).html());
// 	function test(){/*改变字体颜色开始*/
//     $(".select-wrap1 #select-btn-show").css("color","#ff7c05");
//      }
//      $(document).ready(function(){
//     test();
//     });/*改变字体颜色结束*/
// });
// /*失去焦点*/
// $(".select-wrap1").on('blur',function(){
// 	$(".select-wrap1 #select-btn-show").show();
// 	$(" .select-wrap1 #select-btn-hide").hide();
// 	$(".select-wrap1 .select-item1").hide();
// });
// </script> 
	<script>/*select按钮*//*选择朝向级别*/
// $('.select-wrap2 #select-btn-show').on('click', function(){
// 	$(".select-wrap2 #select-btn-show").hide();
// 	$(".select-wrap2 #select-btn-hide").show();
// 	$(".select-wrap2 .select-item1").show();
// });
// $('.select-wrap2 #select-btn-hide').on('click', function(){
// 	$(".select-wrap2 #select-btn-hide").hide();
// 	$(".select-wrap2 #select-btn-show").show();
// 	$(".select-wrap2 .select-item1").hide();
// });
// $('.select-wrap2 .select-item1>li').on('click', function(){
// 	var index=$(this).index();
// 	index++;
// 	$(".select-wrap2 #select-btn-show").show();
// 	$(".select-wrap2 #select-btn-hide").hide();
// 	$(".select-wrap2 .select-item1").hide();
// 	$(".select-wrap2 .select-text").html($(this).html());
//     function test(){/*改变字体颜色开始*/
//     $(".select-wrap2 #select-btn-show").css("color","#ff7c05");
//      }
//      $(document).ready(function(){
//     test();
//     });/*改变字体颜色结束*/
// });
// /*失去焦点*/
// $(".select-wrap2").on('blur',function(){
// 	$(".select-wrap2 #select-btn-show").show();
// 	$(".select-wrap2 #select-btn-hide").hide();
// 	$(".select-wrap2 .select-item1").hide();
// });
// </script> 
	<script>/*select按钮*//*选择楼层级别*/
// $('.select-wrap3 #select-btn-show').on('click', function(){
// 	$(".select-wrap3 #select-btn-show").hide();
// 	$(".select-wrap3 #select-btn-hide").show();
// 	$(".select-wrap3 .select-item1").show();
// });
// $('.select-wrap3 #select-btn-hide').on('click', function(){
// 	$(".select-wrap3 #select-btn-hide").hide();
// 	$(".select-wrap3 #select-btn-show").show();
// 	$(".select-wrap3 .select-item1").hide();
// });
// /*item*/
// $('.select-wrap3 .select-item1>li').on('click', function(){
// 	var index=$(this).index();
// 	index++;
// 	$(".select-wrap3 #select-btn-show").show();
// 	$(".select-wrap3 #select-btn-hide").hide();
// 	$(".select-wrap3 .select-item1").hide();
// 	$(".select-wrap3 .select-text").html($(this).html());
// 	function test(){/*改变字体颜色开始*/
//     $(".select-wrap3 #select-btn-show").css("color","#ff7c05");
//      }
//      $(document).ready(function(){
//     test();
//     });/*改变字体颜色结束*/
// });
// /*失去焦点*/
// $(".select-wrap3").on('blur',function(){
// 	$(".select-wrap3 #select-btn-show").show();
// 	$(".select-wrap3 #select-btn-hide").hide();
// 	$(".select-wrap3 .select-item1").hide();
// });

</script>

	<!--选择隐藏显示-->
	<script>
  $("#chai").click(function(){
		$('.tips-box-r').show();
		$('.tips_wu').hide();
		});
</script>

	<!--右侧固定菜单-->
	<script type="text/javascript">
$(document).ready(function(){
	$(".side ul li").hover(function(){
		$(this).find(".sidebox").stop().animate({"width":"150px"},200).css({"opacity":"1","filter":"Alpha(opacity=100)","background":"#72c312"})	
	},function(){
		$(this).find(".sidebox").stop().animate({"width":"54px"},200).css({"opacity":"0.8","filter":"Alpha(opacity=80)","background":"#000"})	
	});
});
//回到顶部
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
	<script>
//搜索
function search(){
	var search_val = $("#btn").val();
	if(search_val){
		}else{
			alert('请输入关键词');}
}

function search(){ 
	window.location = "<?php echo site_url('goods/zhuanti/4/?'.$canshu.'s=/')?>"+$('#btn').val();
    $('#btn').val();
}

$(function(){ 

	$('.limit_').each(function(){
        $leng = $(this).children('span').length;
        
    if($leng>11){
        if($(this).children('span').hasClass('fangzi')){
            $(this).children('span').show();
            $(this).parent().append('<em class="em5"><input type="button" value="收起" class="" id="em4"><i class="icon-xiangshangjiantou"></i></em> ');
        }else{
            $(this).parent().append('<em class="em5"><input type="button" value="更多" class="" id="em4"><i class="icon-select"></i></em> ');
            for(var i = 0;i<$leng;i++){
                $(this).children('span').eq(i+11).hide();
            }
        }
    }
   })

    $('.em5').click(function(){
    	
    	if($(this).children('input').val() =='更多'){
    	    $(this).children('input').val('收起');
    	    $(this).children('i').removeClass().addClass("icon-xiangshangjiantou");
    	    $(this).prev().children('span').show();
    	}else{
    	    $leng = $(this).prev().children('span').length;
    	    if($leng>11){
    	        for(var i = 0;i<$leng;i++){
    	            $(this).prev().children('span').eq(i+11).hide();
    	        }
    	    }
    	    $(this).children('i').removeClass().addClass("icon-select");
    	    $(this).children('input').val('更多');
        }
    })
})
</script>