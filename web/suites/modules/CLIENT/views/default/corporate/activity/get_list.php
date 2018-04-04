<!--拼团样式-->
<style>
.table1.manage_b_table1 th { font-size: 14px;}
table th{border: 1px solid #ccc;}
.table1.manage_b_table1 th{ height:45px;}
.search_1.manage_c_search_1 ul li{ margin: 0 9px 0 0;}
.search_1.manage_c_search_1 ul{width: 807px !important;}
.dingdan4_3_btn01{margin-left:10px;}
</style>
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
        <li class="tCurrent"><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
        <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
	</ul>
</div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">活动管理</div>
		<div class="cmLeft_down"> 
			<ul>
				<!--<li><a href="<?php //echo site_url('corporate/activity/create_activity');?>">发布活动</a></li>-->
				<li class='houtai_zijin_current' ><a href="<?php echo site_url('corporate/activity/get_list');?>">拼团活动<!--(<?php //echo $activity_total?>)--></a></li>
				<li><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
           </ul>
		</div>
	</div>
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">拼团活动</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px"><a <?php echo !$status ? "class='xcurrent'" :'' ?> href="<?php echo site_url('corporate/activity/get_list');?>">全部(<?php echo $activity_total?>)</a></li>
							<li><a <?php echo $status == 'not_begin'? "class='xcurrent'" :'' ?> href="<?php echo site_url('corporate/activity/get_list/not_begin');?>">未开始(<?php echo $not_begin;?>)</a></li>
							<li><a <?php echo $status == 'begin'? "class='xcurrent'" :'' ?>href="<?php echo site_url('corporate/activity/get_list/begin');?>">活动中(<?php echo $begin;?>)</a></li>
							<li><a <?php echo $status == 'overdue'? "class='xcurrent'" :'' ?>href="<?php echo site_url('corporate/activity/get_list/overdue');?>">已过期(<?php echo $overdue;?>)</a></li>
                            <li><a <?php echo $status == 'add'? "class='xcurrent'" :'' ?>href="<?php echo site_url('corporate/activity/get_list/add');?>">新建(<?php echo $add?>)</a></li>
                            <li><a <?php echo $status == 'approve'? "class='xcurrent'" :'' ?>href="<?php echo site_url('corporate/activity/get_list/approve');?>">审核中(<?php echo $count_approve?>)</a></li>
						</ul>
					</div>
					<div style=" width:250px!important;" class="search_2 manage_fenlei_search_2 manage_c_search_2">
					    <form action="<?php echo site_url('corporate/activity/get_list'.$base_url); ?>" method="get">
							<div>
								<input style="width:150px;" type="text" class="search2_con manage_fenlei_search2_con"name="search_name"value="<?php echo isset($_GET['search_name']) ?  $_GET['search_name'] : '' ?>" placeholder="请输入商品名称">
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:;"  onclick="sub()">店内搜索</a>
							</div>
					    </form>
					</div>
				</div>
			</div>
                <div class="select1">
				<ul>
					<li><a href="<?php echo site_url('corporate/activity/create_activity')?>">添加</a></li>
					<?php if(!isset($status) || $status == 'begin'):?>
                        <li style="margin-right: 0;"><a href="javascript:delects();">结束活动</a></li>
                    <?php endif;?>
				</ul>
    
				<table width="910" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
				  
                    <tr class="tr1 manage_b_tr1">
                        <th width="76px"><input type="checkbox" style="margin-right:8px; margin-left: -15px" onclick="selectAll(this)">商品 ID</th>
                        <th width="116px">商品名称</th>
                        <th width="108px">拼团价格</th>
                        <th width="134px">开始时间</th>
                        <th width="134px">截至时间</th>
                        <th width="76px">状态</th>
                        <th width="134px">操作</th>
                    </tr>
                       
                    <?php if( count($activity_product_list) > 0):?>
				        <?php foreach ($activity_product_list as $v):?>
                            <tr>
                                <th width="116px">
                                
                                <?php if( $v['end_time'] > date('Y-m-d H:i:s') && $v['status'] == 1 && $v['start_time'] < date('Y-m-d H:i:s')):?>
                                    <input type="checkbox" style="margin-right:8px; margin-left: -52px; margin-top:10px;" class="sift" value="<?php echo $v['id']?>" onclick="sift(this)">
                                <?php else:?>
                                    <input type="checkbox" disabled style="margin-right:8px; margin-left: -52px; margin-top:10px;">
                                <?php endif;?>
                                <?php echo $v['product_id']?></th>
                                
                                <th width="108px"><?php echo $v['name']?></th>
                                <th width="134px"><?php echo $v['groupbuy_price']?></th>
                                <th width="130px"><?php echo $v['start_time']?></th>
                                <th width="124px"><?php echo $v['end_time']?></th>
                                
                                <?php if($v['status'] == 1): ?>
                                    <?php if($v['start_time'] > date('Y-m-d H:i:s') ):?>
                                    <th width="76px">未开始</th>
                                    <?php elseif( $v['end_time'] > date('Y-m-d H:i:s') ):?>
                                    <th width="76px">活动中</th>
                                    <?php elseif($v['end_time'] < date('Y-m-d H:i:s')):?>
                                    <th width="76px">已结束</th>
                                    <?php endif;?>
                                    <th width="178px"><a href="<?php echo site_url('corporate/activity/activity_order_list/'.$v['activity_num'])?>" style="color:#fe4101; text-decoration:underline">查看拼团明细</a>
                                    <a href="<?php echo site_url('corporate/activity/create_activity/'.$v['id'].'/1')?>" style="color:#fe4101; text-decoration:underline">查看活动明细</a></th>
                                <?php elseif ($v['status'] == 2):?>
                                    <th width="76px">新建</th>
                                    <th width="178px"><a href="<?php echo site_url('corporate/activity/create_activity/'.$v['id'])?>" style="color:#fe4101; text-decoration:underline; margin-right:32px;">编辑</a> <a href="javascript:;" onclick="approve(<?php echo $v['id']?>,this)"  style="color:#fe4101; text-decoration:underline" >提交审核</a></th>
                                <?php elseif ($v['status'] == 3):?>
                                    <th width="76px">审核中</th>
                                    <th width="178px"><a href="<?php echo site_url('corporate/activity/create_activity/'.$v['id'].'/1')?>" style="color:#fe4101; text-decoration:underline">查看活动明细</a></th>
                                <?php elseif ($v['status'] == 4):?>
                                    <th width="76px">审核不通过</th>
                                    <th width="178px"><a href="<?php echo site_url('corporate/activity/create_activity/'.$v['id'])?>" style="color:#fe4101; text-decoration:underline; margin-right:32px;">编辑</a> <a href="javascript:;" onclick="approve(<?php echo $v['id']?>,this)"  style="color:#fe4101; text-decoration:underline" >重新提交审核</a></th>
                                <?php else:?>
                                    <th width="178px"><a href="<?php echo site_url('corporate/activity/activity_order_list')?>" style="color:#fe4101; text-decoration:underline"></a></th>
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                    </table>
                    <?php else:?>
                    </table>
        <div class="result_null" style="margin-top:10px;">暂无内容，请点击上面添加按钮来添加产品</div>
        <?php endif;?>
				<!--<table>
					<tr class="tr1">
						<td colspan="9" style="text-align: center">请点击上面添加按钮来添加产品。</td>
					</tr>
				</table>-->
				<div class="jilu jilu2">
					<!-- <p>显示  到  条数据，共  条数据</p>-->
					<p>显示 <?php if(count($activity_product_list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
				</div>
				<div class="showpage" style="margin-right:30px;">
                    	<?php echo $page;?>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

</script>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang"style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div style="width: 300px;overflow: hidden;margin: 0px auto;">
              <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a> </div>  
              <div class="dingdan4_3_btn01" style="background:#ccc;">  <a id="re_message" href="javascript:void(0);" onclick="$('.dingdan4_3_tanchuang').hide()">取消</a></div>     
          </div>
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

<script language="javascript" type="text/javascript" >
function approve(id,obj){
	$('#sure').attr('onclick',"$('.dingdan4_3_tanchuang').hide()");
	$('#prompt').text('');
    $.post("<?php echo site_url('corporate/activity/update_activity_status')?>",{id:id},function(data){
        switch(data){ 
            case 1 :
                $('.dingdan4_3_tanchuang').show();
                $('#prompt').text('活动已提交审核');
                $(obj).prevAll().remove();
                $(obj).parent().prev().text('审核中');
                $(obj).parent().append('<a href="<?php echo site_url('corporate/activity/create_activity')?>/'+id+'/1" style="color:#fe4101; text-decoration:underline">查看活动明细</a>');
                $(obj).remove();
                break;
            case 2 :
            	$('.dingdan4_3_tanchuang').show();
                $('#prompt').text('请选择需要审核的商品');
                break;
            default:
            	$('.dingdan4_3_tanchuang').show();
                $('#prompt').text('申请审核失败或已经提交申请');
                break;
        }
      },'json');
}

function selectAll(obj)
{
	
	
	var flag = $(obj).is(':checked');
    
	$(".sift").each(function () {
	    
		 $(this).prop("checked",flag);
		 
		 if($(this).is(":checked"))
			{
			 a = true;
			}
    });
    

}

function sift(obj){ 
	a = false;
	if($(obj).is(":checked"))
	{
	 a = true;
	}
}

function delects(){ 
	
	$('#prompt').text();
	$('.dingdan4_3_tanchuang').show();

    if( typeof(a)   ==   "undefined" || a.length == 0){
    	$('#prompt').text('请选择活动');
    	$('#sure').attr('onclick',"$('.dingdan4_3_tanchuang').hide()");
    	
    }else{
    	$('#prompt').text('确定结束选中的活动吗？');
    	$('#sure').attr('onclick',"end_activity()");
    	
    }
}

function end_activity(){ 
	
	var id = new Array();
	var i = 0;
    	$(".sift").each(function () {
	    	if($(this).is(":checked"))
			{
	    		 id[i++] = $(this).val();
			}
        });
		
    $.post("<?php echo site_url('corporate/activity/end_activity')?>",{id:id},function(data){
        if(data == 1){ 
        	$('#prompt').text();
        	$('.dingdan4_3_tanchuang').show();
        	$('#prompt').text('操作成功');
        	$('#sure').attr('onclick',"window.location.reload();");
        	$('#re_message').attr('onclick',"window.location.reload();");
        }else if(data == 2){ 
            	$('#prompt').text();
            	$('.dingdan4_3_tanchuang').show();
            	$('#prompt').text('请选择正确的活动');
            	$('#sure').attr('onclick',"$('.dingdan4_3_tanchuang').hide()");
            }else{ 
                	$('#prompt').text();
                	$('.dingdan4_3_tanchuang').show();
                	$('#prompt').text('操作失败');
                	$('#sure').attr('onclick',"$('.dingdan4_3_tanchuang').hide()");
            }
      },'json');
}

function sub(){ 
    $('form').submit();
    }
</script>