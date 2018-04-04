
<style type="text/css">
@media screen and (min-width:414px) {
	.notice_word_big {
		width: 302px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
}

@media screen and (min-width:321px) {
	.notice_word_big {
		width: 203px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
}

@media screen and (max-width:320px) {
	.notice_word_big {
		width: 160px;
		display: inline-block;
		overflow: hidden;
		word-break: keep-all;
		white-space: nowrap;
		text-overflow: ellipsis;
		text-align: left;
	}
	.order_list .order_list_title .right_state {
		width: 93px;
		text-align: right;
	}
}

.order_list_title {
	position: relative;
}

.order_list .order_list_title .right_state {
	position: absolute;
	right: 0px;
}

.order_list .order_list_content img {
	object-fit: contain;
	float: left;
	text-align: center;
	font-size: 12px;
	color: #666;
	margin-left: 2px;
	display: block;
	background-color: #fff;
	width: 80px;
}
</style>
<div class="page clearfix">
	<div class="tabBox">
		<div class="bd">
			<ul>
                <!--全部订单 开始-->
                <div class="order_list">
                <?php if(count($orders)>0){
                foreach ($orders as $k=>$v):?>
                    <div class="order_list_title" >
                        <span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-shop"></em></span><span class="notice_word_big"><?php echo $v['corporation_name'];?></span>
                        <a href=""><span class="ml-20"></span></a>
                        <span class="notice-word-big right_state" id="order_message_<?php echo $v['id']?>">
                    <?php
                    switch ($v ['status']) {
                        case 1 :
                            echo '等待商家确认';
                            break;
                        case 2 :
                            echo '待付款';
                            break;
                        case 3 :
                           ;
                        case 4 :
                            echo '待发货';
                            break;
                        case 5 :
                            echo '待发货';
                            break;
                        case 6 :
                            echo '已发货';
                            break;
                            ; 
                        case 7 :
                            echo '已完成';
                            break;
                        case 8 :
                            ;
                            break;
                        case 9 :
                            echo '已完成';
                            break;
                        case 10 :
                            echo '已取消';
                            break;
                        case 11 :
                            echo '已退款';
                            break;
                        case 12 :
                            echo '已取消';
                            break;
                        case 13 :
                            echo '已存货';
                            break;
                        case 14 :
                            echo '已完成';
                            break;
                    }
                    ?></span>
                    
                    </div>
                    <!--订单号＋状态 结束-->
                    <!--商品内容列表 开始-->
                    <div class="order_list_content clearfix">
                       <div style="width: 100%;height: auto;overflow: hidden;position: relative;">
                       	  <a href="<?php echo site_url('member/order/detail/'.$v['id']);?>" style="width: 600px;display: inline-block;">
                        <?php if (isset($v['items']) && count($v['items']) > 0) :
                            foreach ($v['items'] as $item) :?>
                            <?php if($v['corporation_branch_id']){?>
                                 <img src="images/default_biao.jpg" width="64" height="87" onerror="this.src='images/default_biao.jpg'">
                            <?php }else{?>
                                 <img src="<?php echo IMAGE_URL.$item['goods_thumb'];?>" width="64" height="87"  onerror="this.src='images/default_img_b.jpg'">
                             <?php }?>
                            <?php endforeach; ?>
                            <?php if (count($v['items']) == 1) :?>
                             
                                 <span class="fn-14" style=" margin-left: 10px; text-align: left;  color: #333; position: absolute;">
                                 <?php echo $item['product_name'];?>
                                 </span>
                           
                            <?php endif;?>
                        <?php endif;?>
                        </a>
                       </div>
                        <div>
                            <!-- <p class="fn-14"><?php echo $item['product_name'];?></p> -->
                             <?php if(!$v['corporation_branch_id']){?>
                              <p class="fn-12 c9" style="float: left; font-size: 15px !important; color: #0E0E0E !important;">共<?php $quantity = '';foreach ($v['items'] as $val){ $quantity += $val['quantity'];} echo $quantity; ?>件商品</p>
                             <?php }?>
                            <p class="fn-14" style="float: right; font-size: 15px !important;">实付款：<?php echo floor($v['total_price']);?><span
                            style="font-size: 13px;"><?php echo strstr($v['total_price'],".");?></span><span
                            style="padding-left: 4px;">货豆</span>
                            </p>
                        </div>
					</div>
                    <!--商品列表 结束-->
                    <!--操作状态－已完成订单评价＋取消订单 开始-->
                    <?php  if(in_array($v['status'],array(7,9) ) ): ?>
                    	<?php if($v['comment_num'] <  $v['item_id_num']){?>
                   
                        <div class="order_list_handle">
                             <span><a href="<?php echo site_url('member/my_comment/product_comment/'.$v['id'].'/details') ?>" class="order_list_comment">评价</a></span>
                        </div>
                     	<?php }?>
                    
                    <?php elseif( in_array($v['status'],array(2)) ):?>
                   
                    <div class="order_list_handle" id="status_submit_<?php echo $v['id']?>">
                        <span><a href="<?php echo site_url('member/order/order_pay/'.$v['id'])?>" class="order_list_comment">去支付</a></span>
                        <span><a href="javascript:;" onclick="cancel(<?php echo $v['id']?>)" class="order_list_comment">取消订单</a></span>
                    </div>
                   
                    <?php elseif( in_array($v['status'],array(6)) ):?>
                    <div class="order_list_handle" id="status_submit_<?php echo $v['id']?>">
                        <span><a href="javascript:;" onclick="receive(<?php echo $v['id']?>)" class="order_list_comment">确定收货</a></span>
                    </div>
                     
                     <?php elseif( in_array($v['status'],array(1)) ):?>
                     <div class="order_list_handle" id="status_submit_<?php echo $v['id']?>">
                        <span><a href="javascript:;" onclick="cancel(<?php echo $v['id']?>)" class="order_list_comment">取消订单</a></span>
                    </div>
                    <?php endif;?>
                    
                    <!--操作状态 结束-->
                 <?php endforeach;?>
                </div>
                <!--order_list end-->
               
			</ul>
			<!--全部订单 结束-->
			
			<!-- 注释圈 -代码 -->
			<div class="pingjia_jilu">
				<p>显示 <?php if(count($orders) > 0) echo ($curr_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($curr_page*$per_page > $allorder) echo $allorder; else echo $curr_page*$per_page; ?> 条数据，共 <?php echo $allorder?> 条数据</p>
			</div>
			<div class="pingjia_showpage">
				<?php echo $pagination;?>
			</div>
			<?php }else{?>
            <!-- 我的订单为空时 -->
            <div style="text-align: center;padding-top: 150px;">
                <a href="javascript:void(0);"><span class="icon-iconfontchakandingdan" style="font-size: 110px;color:#ccc;"></span></a><br>
                <span style="font-size: 17px;color:#ccc;padding-top: 10px;display: block;">暂无相关订单</span>
            </div>
			<?php }?>
		</div>
	</div>
</div>

<div class="new_order-nav">
	<ul>
		<li <?php echo empty($statu) ? 'class="new_order-nav-active"' : ''; ?>>
		<a href="<?php echo site_url('member/order')?>">全部</a></li>
		<li <?php echo !empty($statu) && $statu == 1 ? 'class="new_order-nav-active"' : '';?>>
		<a href="<?php echo site_url('member/order/index/1')?>">待付款</a></li>
		<li <?php echo !empty($statu) && $statu == 6 ? 'class="new_order-nav-active"' : '';?>>
		<a href="<?php echo site_url('member/order/index/6')?>">待收货</a></li>
		<li <?php echo !empty($statu) && $statu == 4 ? 'class="new_order-nav-active"' : '';?>>
		<a href="<?php echo site_url('member/order/index/4')?>">已完成</a></li>
	</ul>
</div>


<!-- 顶部导航事件 -->
<script type="text/javascript">
  $(".new_order-nav ul li").on("touchstart",function(){
     var index = $(this).index();
     $(this).addClass('new_order-nav-active').siblings().removeClass("new_order-nav-active");
  })
</script>

<!-- 订单操作事件 -->
<script type="text/javascript">

var show_bullet_id = "<?php echo $bullet_set == 1? "skip_bullet":"pay_bullet";?>";



// 确认收货 - show
function receive( id ){
    $.ajax({ 
        url:'<?php echo site_url('order/order_message')?>',
        data:{ o_id:id },
        dataType:'json',
        type:'post',
        success:function(data){
            $("#pay_").text("确认收货");
            $('#pay_').attr('onclick','ok_receive("'+data.id+'")');
            $('#order_sn').text(data.order_sn);
            $('#price').text('M '+data.total_price);
            $(".color-bg").show();
            $("#"+show_bullet_id).show();
        }
    })
}

// 确认收货 - sure
function ok_receive( id ){
    var pass = $('input[name=pay_passwd]').val();
    var comurl = "<?php echo site_url('member/my_comment/product_comment').'/'?>";
    $.ajax({
        url:'<?php echo site_url('order/receive')?>',
        data:{pass:pass,id:id},
        dataType:'json',
        type:'post',
        success:function(data){
            if(data == 1){
                $(".color-bg").hide();
                $("#pay_bullet").hide();
                
                $('#order_message_'+id).text('订单完成');
                $('#status_submit_'+id).empty();
                
                html = '<span><a href="'+comurl+id+'/details" class="order_list_comment">评价</a></span>';
                $('#status_submit_'+id).append(html);
            }else if(data == 3){ 
                $(".black_feds").text("密码错误，请重新输入").show();
                setTimeout("prompt();", 1000);
            }else if(data == 2){
                $(".black_feds").text("订单错误").show();
                setTimeout("prompt();", 1000);
            }else{ 
            	$(".black_feds").text("服务器无响应").show();
                setTimeout("prompt();", 1000);
            }
        },
        error:function(){ 
        	$(".black_feds").text("操作失败").show();
            setTimeout("prompt();", 1000);
        }
    })
}

// 取消订单 - cancel
function cancel( id ){
	url = "<?php echo site_url('order/cancel_order')?>"
	 $.ajax({ 
        url:url,
        type:'post',
        data:{id:id},
        dataType:'json',
        success:function(data){ 
            if(data.is_ok){
            	$('#order_message_'+id).text('已取消');
            	$('#status_submit_'+id).remove();
            }else{
                $(".black_feds").text("操作失败").show();
                setTimeout("prompt();", 1000);
            }
        },
    })
}

</script>
