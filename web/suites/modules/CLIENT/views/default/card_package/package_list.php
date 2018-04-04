<!--拼团样式-->
<style>
.table1.manage_b_table1 th { font-size: 14px;}
table th{border: 1px solid #ccc;}
.table1.manage_b_table1 th{ height:45px;}
.search_1.manage_c_search_1 ul li{ margin: 0 9px 0 0;}
.search_1.manage_c_search_1 ul{width: 807px !important;}
.dingdan4_3_btn01{margin-left:10px;}
.search_2.manage_c_search_2{margin:0px 0!important;}
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
				<li><a href="<?php echo site_url("corporate/activity/get_list");?>">拼团活动</a></li>
                <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
				
			</ul>
		</div>
	</div>
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">货包活动</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px"><a <?php echo empty($status)?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package");?>">全部(<?php echo $all;?>)</a></li>
							<li><a <?php echo $status==1?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/1");?>">未开始(<?php echo $not_start;?>)</a></li>
							<li><a <?php echo $status==2?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/2");?>">活动中(<?php echo $ing;?>)</a></li>
							<li><a <?php echo $status==3?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/3");?>">已过期(<?php echo $obsolete;?>)</a></li>
							<li><a <?php echo $status==6?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/6");?>">新建(<?php echo $new;?>)</a></li>
                            <li><a <?php echo $status==4?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/4");?>">审核中(<?php echo $wait;?>)</a></li>
                            <li><a <?php echo $status==5?"class='xcurrent'":null;?> href="<?php echo site_url("corporate/card_package/index/5");?>">审核失败(<?php echo $fail;?>)</a></li>
						</ul>
					</div>
					
				</div>
			</div>
                <div class="select1">
				<ul>
					<li><a href="<?php echo site_url("corporate/card_package/add_view");?>">添加</a></li>
				</ul>
                 <div style=" width:250px!important;" class="search_2 manage_fenlei_search_2 manage_c_search_2">
					    <form action="<?php echo site_url("corporate/card_package/");?>" method="get" id="form1">
							<div>
								<input style="width:150px;" type="text" class="search2_con manage_fenlei_search2_con"name="search_name"value="<?php echo $search;?>" placeholder="请输入货包名称" >
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:serach();" >店内搜索</a>
							</div>
					    </form>
					</div>
				<table width="910" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
				  
                    <tbody><tr class="tr1 manage_b_tr1">
                        <th width="76px">货包编号</th>
                        <th width="116px">货包名称</th>
                        <th width="108px">指定商品/品类</th>
                        <th width="134px">折扣/满减/现场礼包</th>
                        <th width="164px">有效日期</th>
                        <th width="76px">状态</th>
                        <th width="134px">操作</th>
                    </tr>
                    <?php if($list){?>
                    <?php foreach($list as $v){;?>   
                    <tr>
                        <th width="116px"><?php echo $v["package_sn"]?></th>
                        <th width="108px"><?php echo $v["name"]?></th>
                        <th width="134px"><?php echo $v["specified_type"]==1?"商品":"品类";?></th>
                        <th width="130px"><?php if($v['discount_type']==1){echo "折扣：".$v['discount'].'折';}else if($v['discount_type']==2){echo "满减：".'满'.$v['overtop_price'].'减'.$v['deduction_price'];}else{echo "现场礼包";};?></th>
                        <th width="154px"><?php echo $v["coupon_start_at"];?> 至 <?php echo $v["coupon_end_at"];?></th>
                        <th width="76px">
                        <?php switch ($v['status']){
                            case "0":
                                echo "新建";
                                break;
                            case "1":
                                echo "审核中";
                                break;
                            case "2":
                                echo "审核失败";
                                break;
                            case "3":
                                if($v["coupon_start_at"]>date("Y-m-d")){
                                    echo "未开始";
                                }else if($v["coupon_start_at"]<=date("Y-m-d") && $v["coupon_end_at"]>=date("Y-m-d")){
                                    echo "活动中";
                                }else if($v["coupon_end_at"]<date("Y-m-d")){
                                    echo "已过期";
                                }
                                break;
                        }?>
                        </th>
                       <th width="148px">
                       <?php if($v['status'] != 3){?>
                       <a href="<?php echo site_url("corporate/card_package/add_view/".$v["id"]);?>" style="color:#fe4101; text-decoration:underline; margin-right:32px;">编辑</a> <a href="javascript:;" onclick="approve(this,<?php echo $v["id"];?>,<?php echo $v['status'];?>)" style="color:#fe4101; text-decoration:underline">
                       <?php switch ($v['status']){
                            case "0":
                                echo "提交审核";
                                break;
                            case "1":
                                echo "取消审核";
                                break;
                            case "2":
                                echo "提交审核";
                                break;
                        }?>
                       </a> &nbsp;
                       <?php };?>
                       <a href="<?php echo site_url("corporate/card_package/detail").'/'.$v['id'];?>"  style="color:#fe4101;     display: inline-block;text-decoration:underline">查看详情</a></th>
                    </tr>
                    <?php };?>
                    <?php };?>
 
                    </tbody>
                </table>
                <?php if(!$list){?>
                <div class="result_null" style="margin-top:10px;">暂无内容，请点击上面添加按钮来添加产品</div>
                <?php };?>
				<!--<table>
					<tr class="tr1">
						<td colspan="9" style="text-align: center">请点击上面添加按钮来添加产品。</td>
					</tr>
				</table>-->
				<div class="jilu jilu2">
					<!-- <p>显示  到  条数据，共  条数据</p>-->
					<p>总共 <?php echo $total_rows;?> 条数据</p>
				</div>
				<div class="showpage" style="margin-right:30px;">
                    	<?php echo $page;?>
                </div>
			</div>
		</div>
	</div>
</div>
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

<script>
function serach(){
	if($("input[name=search_name]").val()){
		$("#form1").submit();
	}else{
	    alert("请输入商品名称");
	}
}

function approve(obj,id,status){
	$.post("<?php echo site_url('corporate/card_package/operate');?>",{id:id,status:status},function (data){
	    switch(data['status']){
	        case "1":
		        window.location.reload();
		        break;
	        case "2":
	            if(status == 1){
	                $(obj).attr("onclick","approve(this,"+id+",0)").text("提交审核");
	            }else{
	            	$(obj).attr("onclick","approve(this,"+id+",1)").text("取消审核");
	            }
		        break;
	        case "3":
	        	window.location.reload();
		        break;
	    }
	},'json');

}
</script>

