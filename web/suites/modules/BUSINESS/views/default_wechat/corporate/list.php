
<div class="shop-information">
	<!-- 商家信息 start -->
	<div class="shop-information-header">
		<ul>
		    <li class="shop-information-tu"><img src="<?php echo isset($corporation['img_url'])&&$corporation['img_url']!=''?IMAGE_URL.$corporation['img_url']:'images/preterm_logo.png' ?>"
		     	height="70" width="70" alt="" onerror="this.src='images/default_img_s.jpg'"></li>
		    <li class="shop-information-test">
		    	<span class="shop-title"><?php echo isset($corporation['corporation_name'])?$corporation['corporation_name']:"" ?></span><br>
		    	<span class="shop-num">店铺号：<?php echo isset($corporation['id'])?$corporation['id']:"0" ?></span><br>
		    	<span class="shop-huiyuan"><?php echo $corporation["gradeshow"]?></span>
		    </li>
		</ul>
		<div class="shop-all-remove">
			<a href="<?php echo site_url("home/GoToShopH5/".$corporation['id']);?>" class="shop-xinxi"><span class="icon-xinxi shop-wangdianhao"></span>商家信息</a>
			<a href="javascript:void(0);" onclick=fav_corporation(<?php echo isset($corporation['id'])?$corporation['id']:"0" ?>) class="shop-remove"><span class="icon-like shop-like"></span><span class="shop-guanzhi-text">已关注</span></a>
		</div>
	</div>
	<!-- 商家信息 end -->
	
	<!-- 间隔线 -->
	<div class="shop-information-line"></div>
	
	<!-- 排序条件 start-->
	<div class="classify_box hide_classifyBox">
		<ul style="margin-left: 15px; padding-top: 5px;">
			<li style="width: 33.3%; font-size: 14px;">
    			<a id="new" >
        			<span>新品</span>
    				<!--删除新品箭头 <i class="icon-jiantou-copy" style="font-size: 12px; margin-left: -1px;"></i> -->
    				<input type="hidden" name="new" value="2">
    			</a>
			</li>
			<li style="width: 33.3%; font-size: 14px;">
    			<a id="sale">
        			<span>销量</span>
        			<!--删除销量箭头 <i class="icon-jiantou-copy" style="font-size: 12px; margin-left: 0px;"></i>-->
        			<input type="hidden" name="sale" value="2">
    			</a>
			</li>
			<li style="width: 33.3%; font-size: 14px;">
				<a id="price">
        			<span>价格</span>
    				<i class="icon-jiantou-copy" style="font-size: 12px; margin-left: 0px;"></i>
    				<input type="hidden" name="price" value="2">
    			</a>
			</li>
		</ul>
	</div>
	<!-- 排序条件 end-->
	
	<div class="search_res">
        <ul id="loadmore">
            <?php if(isset($productList)&&count($productList)>0): ?>
            <!--搜索结果（有数据显示） begin-->
            <?php foreach ($productList as $p): ?>
            <a href="<?php echo site_url('goods/detail').'/'.$p['id'];?>">
            	<li class=" clearfix" style="">
                	<i class="result_img" style="width:100px;height: 100px;float: left;margin-right: 15px;"><img src="<?php echo isset($p['goods_thumb'])&&$p['goods_thumb']!=null?(IMAGE_URL.$p['goods_thumb']):'' ?>" onerror="this.src='images/default_img_s.jpg'"></i>
                    <em class="result_em">
                        <p  class="result_title"><?php echo $p['name']?></p>
                        <p  style="padding-top: 20px"><?php echo $p['vip_price'].'货豆'?></p>
                        <!-- <p class="min"></p> -->
                    </em>
                </li>
             </a>
            <?php endforeach; ?>
            <!--搜索结果（有数据显示） end-->
            <?php else: ?>
            
            <!--搜索结果（无数据显示） begin-->
        	<li class=" clearfix" style="text-align:center;"><?php echo isset($keyword)?"无更多".$keyword."商品":"无更多商品" ?></li>
            <!--搜索结果（无数据显示） end-->
            <?php endif; ?>
        
        </ul>
        <!-- 发送后提示 -->
         <ul id="load"><h5 class="jiazai" style="display:none;text-align:center;line-height:20px;color:#c3c3c3">加载中...</h5></ul>
	</div>
</div>



<!-- 滚动分页判断执不执行,限定下拉刷新时间 -->
<input type="hidden" id="panduan" value="1">
<!-- 分页 -->
<input type="hidden" id="limit" value="2">
<!-- 条件判断 -->
<input type="hidden" id="order" value="">

<script type="text/javascript">


  window.onload = function () {

var u = navigator.userAgent;
if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
   
   $(document).ready(function(){
  $(".search_input").focus(function(){
    $("footer").css("display","none");
  });
  $(".search_input").blur(function(){
    $("footer").css("display","block");
  });
});

} else if (u.indexOf('iPhone') > -1) {//苹果手机
     $(".page").css("position","fixed");
     $(".page").css("top","50px");
     $(".page").css("bottom","0px");
     $(".page").css("padding-top","0");
     $(".page").css("padding-bottom","0");
     $(".page").css("width","100%");
     $(".page").css("overflow","scroll");


} else if (u.indexOf('Windows Phone') > -1) {//winphone手机

}
}

 


</script>

<script>

// 当前企业是否收藏
var is_favourites = "<?php echo isset($is_favourites)?$is_favourites:0;?>";

/**
 * 初始化
 */
$(function(){
	// 页面脚部去除多余空白初始化
	$(".page").css("padding-bottom","0px");
	// 关注按钮初始化
	if(is_favourites == 1){
		$(".shop-guanzhi-text").html("已关注");
	}else{
		$(".shop-guanzhi-text").html("未关注");
    	$(".shop-remove").addClass("shop-active02-color");
	}
	//搜索导航初始化
	$(".search_input").attr("placeholder","搜索店内商品");
	$(".search_input").attr("action","<?php echo site_url("home/GetShopGoods/".$corporation['id'])?>");
})

/**
 * 关注/取消关注店铺操作
 */
function fav_corporation(corporation_id){
	<?php if(!$this->session->userdata('user_in')):
		 $url = site_url($_SERVER['PATH_INFO']);
	     $this->session->set_userdata("redirect",$url);?>
		window.location.href="<?php echo site_url("Customer/login");?>";
	<?php else:?>
	if(corporation_id != 0){
    	if(is_favourites==0){
            $.ajax({
                url: base_url+'/Member/fav/store_corporation',
                type: 'POST',
                data:{'pid':corporation_id},
                dataType: 'html',
                success: function(data){
                	$(".shop-remove").toggleClass("shop-active02-color");
            		$(".shop-guanzhi-text").html("已关注");
            		// 是否关注，全局可以使用判断
            		is_favourites = 1;
            		$(".black_feds").text(data).show();
                	setTimeout("prompt();", 2000);
                }
            });
    	}else{
            $.ajax({
                url: base_url+'/Member/fav/unfavorite_corporation',
                type: 'POST',
                data:{'corporation_id':corporation_id},
                dataType: 'json',
                success: function(data){
                    if(data["Result"]==true){
                    	$(".shop-remove").toggleClass("shop-active02-color");
                		$(".shop-guanzhi-text").html("未关注");
                		// 是否关注，全局可以使用判断
                		is_favourites = 0;
                    }
            		$(".black_feds").text(data["message"]).show();
                	setTimeout("prompt();", 2000);
                }
            });
    	}
	}
    <?php endif;?>
}

/**
 * 获取商家商品信息事件
 */
function order(search_index,limit,condition){
	// 定义页显示行数
	var page = 15;
	var corporation_id = "<?php echo $corporation['id'];?>";
	$.ajax({
        url:"<?php echo site_url('home/GetShopGoods')."/".$corporation['id']; ?>",
        type:"post",
        data:{search_index:search_index,limit:limit,page:page,order:condition,corporation_id:corporation_id},
        beforeSend:function(){
        	$('#load').children('h5').html("加载中...");
        	$('#load').children('h5').show();
        },
        success:function(data){
        	var data = jQuery.parseJSON(data);
        	var url = "<?php echo site_url("goods/detail")."/";?>";
        	var errorimg= "this.src='images/default_img_s.jpg'";
            var html = '';
            if( data["productList"].length>0){
                for(var i=0;i<data["productList"].length;i++){
            		var img = "<?php echo IMAGE_URL; ?>/"+data["productList"][i]["goods_thumb"];
                    if(data["productList"][i]["goods_thumb"] != null && data["productList"][i]["goods_thumb"]!=""){
                		var img = "<?php echo IMAGE_URL; ?>/"+data["productList"][i]["goods_thumb"];
                    }else{
                		var img = "images/default_img_s.jpg";
                    }
    	            html += "<a href='"+url+data["productList"][i]["id"]+"'><li class='clearfix' style=''><i class='result_img' style='width:100px;height: 100px;float: left;margin-right: 15px;'><img src='"+img+"' onerror='+errorimg+'></i><em class='result_em'><p class='result_title'>"+data["productList"][i]["name"]+"<p>"+data["productList"][i]["vip_price"]+"货豆</p><p class='min'></p></p></em></li></a>";
                }
            }else{
            	html ="<li class=' clearfix' style='text-align:center;'>无更多" + search_index + "商品</li>";
            	setTimeout(function(){ $('#load').children('h5').hide(); $('#loadmore').html(html); },500);
            }
            setTimeout(function(){ $('#panduan').val(1); $('#load').children('h5').hide(); $('#loadmore').html(html); },500);
        },
        error:function(){
        	$('#panduan').val(1);
        	$('#load').children('h5').html("加载失败！");
        	$('#load').children('h5').show();
        },
    });
}

/**
 * 下拉加载商品事件
 */
$(window).scroll(function () {
	<?php if(isset($productList) && count($productList)>0): ?>
    if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
        var limit = $('#limit').val();
	    var search = $("input[name='search_index']").val();
	    if($('#panduan').val()==1){
	    	$('#panduan').val(0);
	    	var order = $('#order').val();
	    	onsearch(search,limit,order);
	    }
    }
    <?php endif; ?>
});
function onsearch(search_index,limit,condition){
	// 定义刷新加载行数
    var page = 15;
	var corporation_id = "<?php echo $corporation['id'];?>";
    if(condition!=null){
    	var data = {search_index:search_index,limit:limit,page:page,corporation_id:corporation_id,order:condition};
    }
    else{
        var data = {search_index:search_index,limit:limit,page:page,corporation_id:corporation_id};
    }
    $.ajax({
        url:"<?php echo site_url('home/GetShopGoods')."/".$corporation['id']; ?>",
        type:"post",
        data:data,
        beforeSend:function(){
        	$('#load').children('h5').html("加载中...");
        	$('#load').children('h5').show();
        },
        success:function(data){
        	limit++;
            var data = jQuery.parseJSON(data);
            var url = "<?php echo site_url("goods/detail")."/";?>";
            if( data.productList.length>0){
            	var errorimg= "this.src='images/default_img_s.jpg'";
                var html = '';
                for(var i=0;i<data.productList.length;i++){
                	var img = "<?php echo IMAGE_URL; ?>/"+data.productList[i]['goods_thumb'];
                	km="";
                	html += '<a href="'+url+data['productList'][i]["id"]+'"><li class=" clearfix" style=""><i class="result_img" style="width:100px;height: 100px;float: left;margin-right: 15px;"><img src="'+img+'" onerror='+errorimg+'></i><em class="result_em"><p  style=""class="result_title">'+data['productList'][i]['name']+'<p  style="padding-top: 20px">'+data['productList'][i]['vip_price']+'货豆</p><p class="min">'+km+'</p></p></em></li></a>';
                    }
                setTimeout(function(){
                	$('#panduan').val(1);
                	$('#load').children('h5').hide();
                	$('#limit').val(limit);
                	$('#loadmore').append(html);
                },500);
                
            }else{
            	html ='<li class=" clearfix" style="text-align:center;">无更多'+search_index+'商品</li>';
            	setTimeout(function(){
                	$('#load').children('h5').hide();
                	$('#loadmore').append(html);
                },500);
            }
        },
        error:function(){
        	$('#panduan').val(1);
        	$('#load').children('h5').html("加载失败！");
        	$('#load').children('h5').show();
        },
    });
}

/**
 * 排序操作事件
 */
//按新品高低查询
$('#new').click(function(){

	// 亮灯控制
	$('#distance').attr('class','');
	$('#sale').attr('class','');
	$('#new').attr('class','');
	$('#price').attr('class','');
	$('#new').attr('class','classifyBox_current');
	// 点击排序重新定位页码
	if($('#limit').val()>2){
		$('#limit').val(2);
	}
	// 搜索关键词
    var search_index = $("input[name='search_index']").val();
    // 页显示数量
    var page = 15;
    // 商品显示
    var condition = 'onsale_down';// 登记排序方式
    $('#order').val(condition);
	$('#loadmore').find('*').remove();
    $('#load').children('h5').show();
    order(search_index,0,condition);
    
});
//按销量高低查询
$('#sale').click(function(){
	
	// 亮灯控制
	$('#distance').attr('class','');
	$('#sale').attr('class','');
	$('#new').attr('class','');
	$('#price').attr('class','');
	$('#sale').attr('class','classifyBox_current');
	// 点击排序重新定位页码
	if($('#limit').val()>2){
		$('#limit').val(2);
	}
	// 搜索关键词
    var search_index = $("input[name='search_index']").val();
    // 页显示数量
    var page = 15;
    // 商品显示
	var condition = 'sale_count_down';// 登记排序方式
	$('#order').val(condition);
 	$('#loadmore').find('*').remove();
	$('#load').children('h5').show();
	order(search_index,0,condition);
	
});
//按价格高低查询
$('#price').click(function(){
	// 相关icon定义
	var icon = $('#price').find('i');
	var iconin = $('#price').find('input[name="price"]');
	// 亮灯控制
	$('#distance').attr('class','');
	$('#sale').attr('class','');
	$('#new').attr('class','');
	$('#price').attr('class','');
	$('#price').attr('class','classifyBox_current');
	// 点击排序重新定位页码
	if($('#limit').val()>2){
		$('#limit').val(2);
	}
	// 搜索关键词
    var search_index = $("input[name='search_index']").val();
    // 页显示数量
    var page = 15;
    // 操作方式选择
	if(iconin.val()==1){
		icon.attr('class','icon-jiantou-copy');// 修改icon指向
		iconin.val(2);// 登记icon指向
		var condition = 'vip_price_down';// 登记排序方式
		$('#order').val(condition);
 		$('#loadmore').find('*').remove();
		$('#load').children('h5').show();
		order(search_index,0,condition);
	}else{
		icon.attr('class','icon-jiantou2');
		iconin.val(1);
		var condition = 'vip_price_up';
		$('#order').val(condition);
 		$('#loadmore').find('*').remove();
		$('#load').children('h5').show();
		order(search_index,0,condition);
	}
});

</script>