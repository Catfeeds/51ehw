
<script language="JavaScript">
var pro_sum = <?php echo count($lists)?>;
var corp_sum = <?php echo count($corporation)?>;
// 无数据隐藏头部
$(function(){
	if(<?php echo count($lists)?>==0){
		$("#widget_submit").hide();
	}
	if(pro_sum==0){
		$("#fav_null").show();
		}
// 	if(corp_sum==0){
// 		$("#fav_null").show();
// 		}
	
})
function changewidget(){
	var show_font = $("#widget_submit").html()=="完成"?"编辑":"完成";
	$("#widget_submit").html(show_font);
	$(".brand_col_del").toggle();
}
// 头部导航右边按钮绑定事件
$("#widget_submit").on("touchstart",function(){
	changewidget();
})
//移除收藏夹商品
function del_fav(id)
{
	$(".black_feds").text("正在移除收藏夹商品...").show();
    $.ajax({
        url: "<?php echo site_url('member/fav/ajax_delete')?>",
        type: 'POST',
        data:{'id':id},
        dataType: 'json',
        success: function(data){
            if(data['Result']){
            	$(".black_feds").text("移除成功").show();
            	setTimeout("prompt();", 2000);
            	$("#fav_li_"+id).remove();
            	pro_sum--;
            	if(pro_sum==0){
            		$("#widget_submit").hide();
            		$("#fav_null").show();
            		changewidget();
                	}
            }else{
            	$(".black_feds").text("网络错误，请重新操作").show();
            	setTimeout("prompt();", 2000);
            }
        }
    });
}
//移除收藏夹店铺
function del_fav_cor(id)
{
	$(".black_feds").text("正在移除收藏夹店铺...").show();
    $.ajax({
        url: "<?php echo site_url('member/fav/ajax_delete_corp')?>",
        type: 'POST',
        data:{'id':id},
        dataType: 'json',
        success: function(data){
            if(data['Result']){
            	$(".black_feds").text("移除成功").show();
            	setTimeout("prompt();", 2000);
            	$("#fav_li_"+id).remove();
            	corp_sum--;
            	if(corp_sum==0){
            		$("#widget_submit").hide();
            		$("#fav_null").show();
            		changewidget();
            	}
            }else{
            	$(".black_feds").text("网络错误，请重新操作").show();
            	setTimeout("prompt();", 2000);
            }
        }
    });
}

$(".brand_col_img").parents('li').click(function(){
	window.location.href = $(this).children(".brand_col_img a").attr('href');
});


function action() {
    $(".goods-shop-nav-li01").addClass("active-line");
    $(".goods-shop-nav-li02").removeClass("active-line");
    $("#shop-show").css("display","none");
    $("#goods-show").css("display","block");
    if($("#widget_submit").html()=="完成"){
   	 changewidget();
        }
    if(pro_sum >0){
    	$("#fav_null").hide();
		$("#widget_submit").show();
	}else{
		$("#widget_submit").hide();
		$("#fav_null").show();
	}
}

function action02() {
    $(".goods-shop-nav-li02").addClass("active-line");
    $(".goods-shop-nav-li01").removeClass("active-line");
    $("#shop-show").css("display","block");
    $("#goods-show").css("display","none");
    if($("#widget_submit").html()=="完成"){
     	 changewidget();
          }
    if(corp_sum >0){
    	$("#fav_null").hide();
    	$("#widget_submit").show();
    }else{
		$("#widget_submit").hide();
		$("#fav_null").show();
	}
    
}

</script>

<div class="page clearfix">

	<div class="collection">

		
        <!-- 商品店铺 导航 -->
        <div class="goods-shop-nav">
            <ul>
                <li class="goods-shop-nav-li01 active-line" onclick="action() ">商品</li>
                <li class="goods-shop-nav-li02" onclick="action02() ">店铺</li>
            </ul>
        </div>

        <!-- 商品 -->
		<ul class="goods_collect_list" id="goods-show">
			<!--商品收藏 开始-->
			<?php if(count($lists)>0){?>
			<?php foreach ($lists as $k=>$v):?>
			<li id="fav_li_<?php echo $v['product_id'];?>">
				<div class="brand_col_img">
					<a href="<?php echo site_url('goods/detail/'.$v['product_id']);?>">
						<img alt="" src="<?php echo IMAGE_URL.$v['goods_thumb']; ?>" onerror="this.src='images/default_img_b.jpg'">
					</a>
				</div>

				<div class="brand_col_info">
					<p><?php echo $v['product_name'];?></p>
					<div class="fn-left">
						<p class="order_price">
							<span class="text_red">¥<?php echo $v['price'];?></span>
						</p>
					</div>
				</div>
				<a class="brand_col_del" onclick="javascript:del_fav('<?php echo $v['product_id'];?>');" style="display:none;">
					<em class="icon-shanchu"></em>
				</a>
			</li>
			
			<!--商品收藏 结束-->
			<?php endforeach;?>
            <?php  }?>
		 </ul>
			<!-- 暂无收藏 -->

		<!-- 店铺 -->
        <ul class="goods_collect_list" id="shop-show" style="display: none;">
			<!--店铺收藏 开始-->
			<?php if(count($corporation)>0){?>
			<?php foreach ($corporation as $k=>$v):?>
			<li id="fav_li_<?php echo $v['fid'];?>">
				<div class="brand_col_img">
					<a href="<?php echo site_url("home/GetShopGoods/".$v['id']);?>">
						<img alt="" src="<?php echo IMAGE_URL.substr($v['img_url'],2)?>" onerror="this.src='images/default_img_b.jpg'">
					</a>
				</div>

				<div class="brand_col_info">
					<p><?php echo $v['corporation_name']?></p>
					<div class="fn-left">
						<p class="order_price">
							<span class="text_red text_hui">
							<?php 
							// 会员等级
							switch ($v['grade']){
							    case 1 :
							        echo'易货店会员';
							        break;
							    case 2 :
							        echo'旗舰店会员';
							        break;
							    case 3 :
							        echo'专卖店会员';
							        break;
							    default:
							        echo'易货店会员';
							        break;
							}
							?>
							</span>
						</p>
					</div>
				</div>
				<a class="brand_col_del" onclick="javascript:del_fav_cor('<?php echo $v['fid'];?>');" style="display:none;">
					<em class="icon-shanchu"></em>
				</a>
			</li>
			
			<!--店铺收藏 结束-->
			<?php endforeach;?>
			 <?php }?>
		 </ul>
		</div>
		<!--collection end-->
    	<div id="fav_null" style="display:none;">
            		<span style="display: block;color: #535353;font-size: 15px;text-align: center;width:150px;height:150px;background:#ddd;border-radius: 50%;margin:20% auto 0 auto;"><em class="icon-xin" style="font-size: 120px;line-height: 140px;color:#fff;"></em></span>
            		<span style="display: block;color: #535353;font-size: 15px;text-align: center;margin-top: 10px">收藏夹空空达～</span>
            		<span style="display: block;color: #535353;font-size: 15px;text-align: center;margin-top: 5px">快去看看有兴趣的木有～</span>
            		<a href="<?php echo site_url('home');?>" class="yellow-but yellow-but-width">去逛逛</a>
            	</div>
   
	   <!--collection end-->

	
    
</div>
<!--page end-->



