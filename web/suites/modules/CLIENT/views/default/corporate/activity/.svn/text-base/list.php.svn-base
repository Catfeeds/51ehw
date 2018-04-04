<!--拼团样式-->
<style>
.table1.manage_b_table1 th { font-size: 14px;}
table th{border: 1px solid #ccc;}
.table1.manage_b_table1 th{ height:45px;}
.dingdan4_3_btn02{ margin-left:270px;}
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
				<li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/activity/create_activity');?>">发布活动</a></li>
				<li><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
			</ul>
		</div>
	</div>
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">拼团明细</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			
                 <div class="select1">
				<ul>
					<li><a href="javascript:history.back()">返回活动列表</a></li>
				</ul>  
				<table width="910" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                        <th width="76px">活动号</th>
                        <th width="116px">拼团号</th>
                        <th width="108px">下单账号</th>
                        <th width="134px">下单时间</th>
                        <th width="120px">拼团状态</th>
                        <th width="134px">查看</th>
                     </tr>
                     <?php if(count($list) >0 ):?>
                         <?php foreach ($list as $v):?>                    
                             <tr>
                                <th width="116px"><?php echo $v['activity_num']?></th>
                                <th width="108px"><?php echo $v['buy_num']?></th>
                                <th width="134px"><?php echo $v['name']?></th>
                                <th width="130px"><?php echo $v['place_at']?></th>
                                <th width="124px">
                                    <?php if($v['status'] == 1): echo '拼团成功'; elseif($v['status'] == '0' && $v['enddate']>date('Y-m-d H:i:s')): echo '拼团中'; else: echo'拼团失败'; endif;?>
                                </th>
                                <th width="178px"><a href="<?php echo site_url('corporate/order/get_list')?>" style="color:#fca543; text-decoration:underline">订单明细</a>
                                </th>
                              </tr>
                          <?php endforeach;?>
                    </table>
                     <?php else:?>
                    </table>
        <div class="result_null" style="margin-top:10px;">暂无用户参加该活动</div>
        <?php endif;?>
				<!--<table>
					<tr class="tr1">
						<td colspan="9" style="text-align: center">请点击上面添加按钮来添加产品。</td>
					</tr>
				</table>-->
				
				<div class="showpage">
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	document.getElementById("tanchu").onclick=function(){
		document.getElementById("dingdan4_3_tanchuang").style.display="block";
		}
</script>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang"style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'>活动已提交审核</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->