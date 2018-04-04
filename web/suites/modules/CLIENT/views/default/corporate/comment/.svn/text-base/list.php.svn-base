<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>       
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <div class="Box manage_new_Box clearfix">
    	<div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">咨询评价</div>
            <div class="cmLeft_down">
            	<ul>
                    <li <?php echo isset($types) && $types > 0?'':'class="houtai_zijin_current"'; ?>><a href="<?php echo site_url('corporate/comment/get_list').'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>">全部评价(<?php echo $allcount ?>)</a></li>
                    <li <?php echo isset($types) && $types == 1?'class="houtai_zijin_current"':''; ?>><a href="<?php $type=1; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="not2">未回复(<?php echo $noreplycount ?>)</a></li>
                    <li <?php echo isset($types) && $types == 2?'class="houtai_zijin_current"':''; ?>><a href="<?php $type=2; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="have2">已回复(<?php echo $replycount ?>)</a></li>
                    <li><a href="<?php echo site_url('corporate/comment/product_ask');?>">商品咨询(<?php echo $askcount;?>)</a></li>
                </ul>
                
            </div>
        </div>
        <!---->
          <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
        
            <div class="cmRight_tittle">评价查询</div>
            <div class="kehu_kehuguanli1_con01 clearfix">
                <form action="<?php echo site_url('corporate/comment/get_list'); ?>" method="get" name="form" id="form">
            	<div class="kehu_kehuguanli1_con01_left">
                	<ul>
                    	<li>商品名称：</li>
                        <li>商品ID：</li>
                        <!-- <li>SKU ID：</li> -->
                        <li>评价时间：</li>
                        <li>评价关键字：</li>
                        <li>用户昵称：</li>
                        <li>评价等级：</li>
                        <li>是否回复：</li>
                        <li>订单编号：</li>
                        
                    </ul>
                </div>
                <div class="kehu_kehuguanli1_con01_right">
                	<ul>
                    	<li><input class="kehu_kehuguanli1_input" type="text" value="<?php echo !empty($search['product_name'])?$search['product_name']:''; ?>" name="product_name"></li>
                        <li><input class="kehu_kehuguanli1_input" type="text" value="<?php echo !empty($search['product_id'])?$search['product_id']:''; ?>" name="product_id"></li>
                        <!-- <li><input class="kehu_kehuguanli1_input" type="text" value="" name="sku_id"></li> -->
                    	<li>
                        	<input type="text" value="<?php echo !empty($search['start_time'])?$search['start_time']:''; ?>" class="zijin1_1_con01_input01" name="start_time" onClick="WdatePicker()" readonly>
                            <span>至</span>
                            <label><input type="text" value="<?php echo !empty($search['end_time'])?$search['end_time']:''; ?>" class="zijin1_1_con01_input01" name="end_time" onClick="WdatePicker()" readonly></label><span id="prompt"></span>
                        </li>
                        <li><input class="kehu_kehuguanli1_input" type="text" value="<?php echo !empty($search['content'])?$search['content']:''; ?>" name="content"></li>
                        <li><input class="kehu_kehuguanli1_input" type="text" value="<?php echo !empty($search['username'])?$search['username']:''; ?>" name="username"></li>
                    	<li>
                       
                        	<span class="sel_01 tuikuanchaxun_sel">
                            <span class="sel_02">
                        	<select  class="zijin1_1_select" name="product_score">
                            	<option value="" <?php echo !empty($search['product_score']) && $search['product_score']==''?'selected':''; ?>>请选择</option>
                                <option value="0" <?php echo !empty($search['product_score']) && $search['product_score']==0?'selected':''; ?>>全部</option>
                                <option value="1" <?php echo !empty($search['product_score']) && $search['product_score']==1?'selected':''; ?>>一颗星</option>
                                <option value="2" <?php echo !empty($search['product_score']) && $search['product_score']==2?'selected':''; ?>>两颗星</option>
                                <option value="3" <?php echo !empty($search['product_score']) && $search['product_score']==3?'selected':''; ?>>三颗星</option>
                                <option value="4" <?php echo !empty($search['product_score']) && $search['product_score']==4?'selected':''; ?>>四颗星</option>
                                <option value="5" <?php echo !empty($search['product_score']) && $search['product_score']==5?'selected':''; ?>>五颗星</option>
                            </select>
                            </span>
                            </span>
                         
                        </li>
                        <li>
                        
                        	<span class="sel_01 tuikuanchaxun_sel">
                            <span class="sel_02">
                        	<select  class="zijin1_1_select" name="reply" >
                            	<option value='' <?php echo !empty($search['reply']) && $search['reply']==''?'selected':''; ?>>请选择</option>
                                <option value="1" <?php echo !empty($search['reply']) && $search['reply']==1?'selected':''; ?>>是</option>
                                <option value="2" <?php echo !empty($search['reply']) && $search['reply']==2?'selected':''; ?>>否</option>
                            </select>
                            </span>
                            </span>
                       
                        </li>
                        <li><input class="kehu_kehuguanli1_input" type="text" value="<?php echo !empty($search['order_sn'])?$search['order_sn']:''; ?>" name="order_sn"></li>
                        
                    </ul>
                    <div class="buy_btn"><a href="javascript:void(0)" id="select">查询</a></div>
                    <div class="buy_btn"><a href="javascript:void(0)" id="reset">重置</a></div>
                </div>
                </form>
            </div>
            <br><br>
            
            
            
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con pingjia_01_height">
            
              <!---->
              <div class="dingdanguanli_01_top02">
                  <ul>
                      <li <?php echo isset($types) && $types > 0?'':'class="dingdanguanli_01_top02_current"'; ?>><a href="<?php echo site_url('corporate/comment/get_list').'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>">全部(<?php echo $allcount ?>)</a></li>
                      <li <?php echo isset($types) && $types == 1?'class="dingdanguanli_01_top02_current"':''; ?>><a href="<?php $type=1; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="not">未回复(<?php echo $noreplycount ?>)</a><input type="hidden" value="<?php echo $noreplycount; ?>" id="notc"></li>
                      <li <?php echo isset($types) && $types == 2?'class="dingdanguanli_01_top02_current"':''; ?>><a href="<?php $type=2; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!empty($search['product_score'])?$search['product_score']:'').'&reply='.(!empty($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="have">已回复(<?php echo $replycount ?>)</a><input type="hidden" value="<?php echo $replycount; ?>" id="havec"></li>
                  </ul>
              </div>
                
              <!--评价_有内容-->
              <div class="pingjia_01_con" style="display:block">
              <?php
                  if(count($comments)>0):
                  foreach ($comments as $cm):
              ?>
              <div class="pingjia_01_con01 clearfix" style="margin-top:30px">
                  <!--内容头部-->
                  <div class="pingjia_01_top01">
                      <span>订单编号：<?php echo $cm['order_sn']; ?></span>
                      <span class="p_starts">评分：
                      			<em class="startss">
                                <?php
                                     switch ($cm['product_score'])
                                     {
                                         case 1 :
                                             echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                         break;
                                         case 2 :
                                             echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                         break;
                                         case 3 :
                                             echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                         break;
                                         case 4 :
                                             echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                         break;
                                         case 5 :
                                             echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>
                                                   <a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                         break;
                                     }
                                ?>
                                </em>
                      </span>
                      <span class="p_timer">评价时间：<?php echo $cm['create_at']; ?></span>
                      <?php //echo !empty($cm['plus_no'])?'<span>SKU ID:'.$cm['plus_no'].'</span>':''; ?> 
                </div>
                  <div class="pingjia_01_top02">
                      <span >用户昵称：<?php echo $cm['name'] ?></span>
                      
                      <span class="p_name">商品名称：<?php echo $cm['product_name'] ?></span>
                  </div>
                  <div class="pingjia_01_top03">
                      <span>评论： <?php echo $cm['content'] ?></span>
                      <input type="hidden" value="<?php echo $cm['id'] ?>">
                      <?php 
                      echo isset($cm['reply_by']) && $cm['reply_by'] != ''?
                      '<div class="pingjia_01_huifu"><span>回复：'.$cm['reply_content'] .'</span></div>':
                      '<div class="pingjia_01_huifu">
                          <input type="text" class="pingjia_01_huifu_input" name="reply_content" value="">
                          <div class="pingjia_01_huifu_btn"><a href="javascript:void(0)" onclick="reply(this)">回复</a></div>
                      </div>'; 
                     ?>
                     <br>
                     <?php
                     /*echo isset($cm['status']) && $cm['status'] > 0 ?
                     '<div class="pingjia_01_huifu">
                     <div class="pingjia_01_huifu_btn"><a href="javascript:void(0)" >已通过</a></div>
                     </div>':
                     '<div class="pingjia_01_huifu">
                     <div class="pingjia_01_huifu_btn"><a href="javascript:void(0)" onclick="examine(this)" >通过</a></div>
                     </div>';*/
                     ?>
                     
                  </div>
                  <!---->
              </div>
               <!---->
             <?php
                  endforeach;
                  else :
             ?>
             
              <!--评价_无内容-->
            <div class="pingjia_01_con" >
            	<div class="pingjia_01_con01 clearfix pingjia_01_none">
                	<span>暂无内容</span>
                </div>
            </div>
            <!---->
            
            <?php
                  endif;
            ?>
              

             <!--<div class="jilu"><p>显示 1 到 3 条数据，共 3 条数据</p></div>-->
             <div class="jilu jiluLeft">
					<p>显示 <?php 
					//echo ($page - 1)*$pagesize + 1;
					if($totalcount<=0){echo '0';}else{echo ($page - 1)*$pagesize + 1;}
					?> 到 <?php
					//echo $page*$pagesize;
					if($totalcount<$page*$pagesize){echo $totalcount;}else{echo $page*$pagesize;}
					?> 条数据，共 <?php 
					echo $totalcount;
					?> 条数据</p>
				</div>
             <div class="showpage showpage_right">
                <?php echo $pagination;?>
             </div>
                    
            </div>
           
            
         </div>
         <!--cmRight_con-->
         </div>
         <!--cmRight-->
         </div>
         <!--Box-->

<script type="text/javascript">
<!--
$(function(){
	$('#select').on('click',function(){
		$("#prompt").text("");
		start_time = $("input[name=start_time]").val();
		end_time = $("input[name=end_time]").val();
		if(start_time || end_time){
		    if(start_time && end_time){
		        if(end_time<=start_time){
		        	$("#prompt").text("结束时间必须大于开始时间");
		        	return;
			        }
			    }else{
			    	$("#prompt").text("请选择时间区间");
			    	return ;
				    }
			}
	    $('#form').submit(); 
	});
	$('#reset').on('click',function(){
		document.getElementById("form").reset(); 
    });
});
//提示
function tishi(){
	if(confirm("确定要回复吗?")){
		return true;
    }else{
        return false;
    }
}
function reply(o){
	var reply_content = $(o).parent().parent().children('input').val();
	var id = $(o).parent().parent().parent().children('input').val();
	var nocount = $('#notc').val();
	var count = $('#havec').val();
	if(!reply_content){
		alert("请填写回复内容");
		return ;
		}
	if(tishi()){
		$.ajax({
		    url:'<?php echo site_url('corporate/comment/reply') ?>',
		    type:'post',
		    data:{reply_content:reply_content,id:id,},
		    beforeSend:function(){
		        $(o).html("回复中...");
			},
			success:function(data,status){

			    if(data == 1){
			    	nocount --;count ++;
			    	$(o).parent().parent().parent().children('input').next().children().hide();
			    	$(o).parent().parent().parent().children('input').next().html('<span>回复：'+ reply_content +'</span>');
			    	$('#not').html('未回复('+nocount+')');
			    	$('#have').html('已回复('+count+')');
			    	$('#not2').html('未回复('+nocount+')');
			    	$('#have2').html('已回复('+count+')');

			    	$('#notc').val(nocount);
				    $('#havec').val(count);

			    	setTimeout(function(){
				    	$(o).html("回复");
					},1000);
				}else{
				    alert('回复失败');
				}
			    
			}
			
		});
		}else{
		    return;
			}
}

function examine(o){

/*    var id = $(o).parent().parent().parent().children('input').val();

	$.ajax({
	    url:'<?php echo site_url('corporate/comment/examine') ?>',
        type:'post',
        data:{id:id},
        beforeSend:function(){
            $(o).html("审核中...");
        },
        success:function(data,status){
            if(data == 1){
            	$(o).parent().html('<div class="pingjia_01_huifu_btn">'+
                    	'<a href="javascript:void(0)" >已通过</a></div>');
            	setTimeout(function(){
            		$(o).html("通过");
                });
            }else{
                alert('审核未通过');
            }
        },
	});*/
	
}

//-->
</script>
