<?php
    // 储蓄卡头部菜单导航
    $data['head_menu'] = 1;
    $this->load->view('corporate/stored_value_card/head', $data);
?>
<!--左边-->
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">我是购买方</div>
		<div class="cmLeft_down cmLeft_downww">
			<ul>
				<li><a href="<?php echo site_url('Corporate/Savings_card/My_List')?>">我的线上储值卡</a></li>
				<li class="houtai_zijin_current"><a href="javascript:history.go(0)">使用授权管理</a></li>
			</ul>
		</div>
	</div>
	<!--左边结束-->
	<!--右边-->
	<div class="stored_top">
		<div class="stored_top_sh">使用授权</div>
		<div class="stored_sh">
			<div class="stored_sh_li">
				<div class="stored_sh_li_p">
					<h2 class="stored_sh_li_h2">使用授权</h2>
					<p>
						<span>线上储值卡名称：</span><?php echo $detaile['card_name']?>
					</p>
					<p>
						<span>储值卡总额：</span><?php echo $detaile['card_amount']?> 货豆
					</p>
					<p>
						<span>已授：</span><?php echo $detaile['authorize_amount'] ? $detaile['authorize_amount'] : 0?> 货豆
					</p>
					<p>
						<span>已用：</span><?php echo $detaile['card_amount'] - $detaile['remaining_card_amount']?> 货豆
					</p>
					<p>
						<span>储值卡授权余额：</span><?php echo $detaile['remaining_card_amount'] ?>货豆
					</p>
				</div>
				<a class="stored_sh_rig" href="<?php echo site_url('Corporate/Savings_card/My_List')?>">返回</a> 
				<a class="stored_sh_rigth" href="<?php echo $detaile['remaining_card_amount'] > 0 ? site_url('Corporate/Savings_card/My_Card_Authorize_View/'.$detaile['id']) : "javascript:alert('授权余额不足')"?>">使用授权</a>
			</div>
			<?php if( $list ){?>
    			<div class="stored_zhong">
    
    				<table width="909" border="1" cellpadding="0" cellspacing="0"
    					class="table_st">
    					<tbody>
    						<tr class="tr1">
    							<th width="140px">授权日期</th>
    							<th width="100px">账户名</th>
    							<th width="100px">昵称</th>
    							<th width="100px">授权额度</th>
    							<th width="200px">授权期限</th>
    							<th width="80px">已用</th>
    							<th width="80px">备注</th>
    							<th width="80px">操作</th>
    						</tr>
    						<?php foreach ( $list as $v ){?>
        						<tr>
        							<th width="140px"><?php echo $v['created_at']?></th>
        							<th width="100px"><?php echo $v['name']?></th>
        							<th width="100px"><?php echo $v['nick_name']?></th>
        							<th width="100px"><?php echo $v['card_amount']?></th>
        							<th width="200px"><?php echo $v['start_time']?> 至 <?php echo $v['end_time']?></th>
        							<th width="80px"><?php echo $v['card_amount'] - $v['remaining_card_amount']?></th>
        							<th width="80px"><?php echo $v['remarks']?></th>
        							<th width="80px"><a href="<?php echo site_url('Corporate/Savings_card/Card_Consume_List/'.$v['id'].'/1')?>">查看详情</a></th>
        						</tr>
    						<?php }?>
    
    						
    
    					</tbody>
    				</table>
    			</div>
			<?php }else{?>
				<div class="result_null" style="margin-top: 10px;" >暂无授权记录，请点击右上角使用授权按钮来授权</div>
			<?php }?>
		</div>
		<div class="pingjia_showpage" style="margin-right:30px">
                		<?php  echo  $pagination;?>
                </div>
	</div>
	<!--右边结束-->
</div>




