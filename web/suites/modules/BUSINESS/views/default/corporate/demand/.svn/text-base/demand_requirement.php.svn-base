
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
		<li class="tCurrent"><a href="<?php echo site_url('corporate/demand/get_list');?>">供需管理</a></li>
        <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li> 
	</ul>
</div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
             <!--<div class="manage_logo cmLeft_top">
			<img src="<?php //echo $corporation['img_url']?site_url($corporation['img_url']):'images/m_logo.jpg'; ?>" alt="">
		</div>-->
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">供需管理</div>
		<div class="cmLeft_down">
			<ul>
                <li><a href="<?php echo site_url("corporate/demand/demand_release") ?>">发布需求</a></li>
				<li><a href="<?php echo site_url('corporate/demand/get_list');?>">供应信息</a></li>
                <li class="houtai_zijin_current"><a href="<?php echo site_url("corporate/demand/get_requirement") ?>">需求信息</a></li>
				<!--<li><a href="#">售后管理</a></li>-->
			</ul>
		</div>
	</div>
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">全部商品</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px"><a id="all"  href="<?php echo site_url("corporate/demand/get_requirement/0/$search_val") ?>">全部(<?php echo $total;?>)</a></li>
                            <li><a id="behind" href="<?php echo site_url("corporate/demand/get_requirement/1/$search_val") ?>">待审核(<?php echo $behind;?>)</a></li>
                            <li><a id="pass" href="<?php echo site_url("corporate/demand/get_requirement/2/$search_val") ?>">通过(<?php echo $pass;?>)</a></li>
                            <li ><a id="no" href="<?php echo site_url("corporate/demand/get_requirement/3/$search_val") ?>">未通过(<?php echo $no;?>)</a></li>
                            <li><a id="off" href="<?php echo site_url("corporate/demand/get_requirement/4/$search_val") ?>">下架(<?php echo $off;?>)</a></li>
						</ul>
					</div>
					<div class="search_2 manage_fenlei_search_2 manage_c_search_2">
						<form
							action="<?php echo site_url("corporate/demand/get_requirement").'/'.$status ?>"
							method="post" id="form_search">
							<div>
								<input type="text" class="search2_con manage_fenlei_search2_con"
									name="search_val"
									value="<?php echo $search_val ?>">
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:;" onclick="submit();">店内搜索</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="select1">
				<ul>
					<li><a href="<?php echo site_url("corporate/demand/demand_release") ?>">发布需求</a></li>
				</ul>
				<table width="910" height="34" border="1" cellpadding="0"
					cellspacing="0" class="table1_1">
					<tr class="tr1 manageC_tr">
						<th width="254px" style="text-align: left"><span
							style="margin-right: 68px; margin-left: 15px"
							></span>商品名称</th>
						<th width="140px">所属行业</th>
						<th width="150px">期望价格</th>
						<th width="76px">需求数量</th>
						<th width="94px">状态</th>
						<th width="180px">备注</th>
						<th width="78px">操作</th>
					</tr>
				</table>
				<?php if(!empty($requirement)){?>
                <?php foreach ($requirement as $v){;?>
				    <table class="table_border">
						<tbody><tr class="tr1">
							<td colspan="9" style="text-align: left; background: #ffe3c4; border: 1px solid #fea33b;"><span  style="margin-right: 68px; margin-left: 15px" ></span>需求ID :  <?php echo $v['id']?>  <span style="margin-left: 40px">需求厂商：<?php echo $v['corporation_name'];?></span>
								<span style="margin-left: 40px">地区：<?php echo $v['shippingaddress']?></span></td>
						</tr>
						<tr class="tr1">
							<th width="254px"><!--<div class="tImg1">
									<img src="images/biu.jpg">
								</div>-->
								<p style="width: 130px;word-wrap: break-word; word-break: normal; "><?php echo $v['title'];?></p></th>
							<th width="140px"><?php echo $v['name']?></th>
							<th width="150px" style="text-align: left; padding-left: 10px"><?php echo $v['min_vip_price'].'~'.$v['max_vip_price']?></th>				
							<th width="76px"><?php echo $v['unit']?></th>
                            <th width="94px">
                            <?php switch ($v['ispublish']){
                                case 1:
                                    echo "待审批";
                                    break;
                                case 2:
                                    echo "已审批";
                                    break;
                                case 3:
                                    echo "审批不通过";
                                    break;
                                case 4:
                                    echo "下架";
                                    break;
                                default:
                                    echo "暂无信息";
                                    break;
                            }?>
                            </th>
							<th width="180px"><?php echo $v['remark'];?></th>
							<th width="78px"><a id="edit_650" href="javascript:void(0);" style="color:#aeaeae; text-decoration: underline" onclick="operation(<?php echo $v['id'];?>,<?php echo $v['ispublish'];?>)">
							<?php switch ($v['ispublish']){
                                case 1:
                                    echo "取消审批";
                                    break;
                                case 2:
                                    echo "下架";
                                    break;
                                case 3:
                                    echo "申请审批";
                                    break;
                                case 4:
                                    echo "申请审批";
                                    break;
                            }?>
							</a><br> <a href="javascript:void(0);" onclick="del(<?php echo $v['id']?>);" style="color: #fca543; text-decoration: underline">删除</a><br> </th>
						</tr>
					</tbody></table>
				<?php };?>
				<?php }else{;?>
				        <div class="result_null" style="margin-top:10px; ">暂无内容，请点击上面添加按钮来添加产品</div>
				<?php };?>


                   
        
			
                 <div class="showpage">
                <?php echo $page;?>
				</div>
			</div>
		</div>   
	</div>  
</div>
<script>
$(function (){
    switch(<?php echo (int)$status; ?>){
    case 1:
        $('#behind').addClass('xcurrent');
        break;
    case 2:
    	$('#pass').addClass('xcurrent');
        break;
    case 3:
    	$('#no').addClass('xcurrent');
        break;
    case 4:
    	$('#off').addClass('xcurrent');
        break;
    default:
    	$('#all').addClass('xcurrent');
        break;
    }
});
function submit(){
	$('#form_search').submit();
}

function hiding(){
	$('.dingdan4_3_tanchuang').css('display','none');
}

//ajax 修改操作状态
function operation(id,status){
	switch(status){
	case 1:
		status = 4;
		break;
	case 2:
		status = 4;
		break;
	case 3:
		status = 1;
		break;
	case 4:
		status = 1;
		break;
	}
	$.post('<?php echo site_url("corporate/demand/edite_requirement") ?>',{id:id,status:status},function(data){
		if(data){
			alert('操作成功');
			window.location.reload();
			}else{
			    alert('操作失败');
			    window.location.reload();
				}
	})
}

//ajax 删除
function del(id){
	$.post('<?php echo site_url("corporate/demand/del") ?>',{id:id},function(data){
		if(data){
			alert('删除成功');
			window.location.reload();
			}else{
			    alert('删除失败');
			    window.location.reload();
				}
	})
}




</script>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->