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
				<li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/My_List')?>">我的线上储值卡</a></li>
				<?php if( $detaile['level'] == 1 ){?>
				<li><a href="<?php echo site_url('Corporate/Savings_card/My_Authorize_View/'.$detaile['id'])?>">使用授权管理</a></li>
				<?php }?>
			
			</ul>
		</div>
	</div>
	<!--左边结束-->
	<!--右边-->
	<div class="stored_top">
		<div class="stored_top_sh">使用详情</div>
		<div class="stored_sh">
			<div class="stored_sh_li">
				<div class="stored_sh_li_p">
					<h2 class="stored_sh_li_h2">使用详情</h2>
					<p>
						<span>线上储值卡名称：</span><?php echo $detaile['card_name']?>
					</p>
					<p>
						<span>授权总额：</span><?php echo $detaile['card_amount']?>货豆</p>
               <?php if( $detaile['parent_id'] != 0 ){?>
               <p>
						<span>授权余额：</span><?php echo $detaile['remaining_card_amount']?> 货豆</p>
               <?php }?>
               <p>
						<span>实际余额：</span><?php echo $detaile['parent_id'] == 0 ? $detaile['remaining_card_amount'] : $detaile['level_two_show_card_amount']?>货豆</p>
				</div>
<!-- 				<a class="stored_sh_rig" href="#">返回</a> -->

			</div>
            <?php if( $list ){?>
            <div class="stored_zhong">

				<table width="800" border="1" cellpadding="0" cellspacing="0"
					class="table_st">
					<tbody>
						<tr class="tr1">
							<th width="150px">使用时间</th>
							<th width="150px">使用账号</th>
							<th width="120px">支出金额</th>
							<th width="120px">授权余额</th>
							<th width="120px">实际余额</th>
							<th width="150px">使用门店</th>
						</tr>

						<?php foreach ( $list as $v ){?>
						<tr>
							<th width="150px"><?php echo $v['created_at']?></th>
							<th width="150px"><?php echo $v['name']?></th>
							<th width="120px"><?php echo $v['card_amount']?></th>
							<th width="120px"><?php echo $v['level'] == 2 ? $v['card_remaining'] : '-'?></th>
							
							<th width="120px"><?php echo $v['parent_card_remaining']?></th>
							
							
							<th width="150px"><?php echo $v['branch_name']?></th>
							
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
            <?php }else{?>
      			<div class="result_null" style="margin-top: 10px;" >暂无使用记录。</div>
      		<?php } ?>
          		<div class="pingjia_showpage" style="margin-right:30px">
                    		<?php  echo  $pagination;?>
                </div>
		</div>
		
	</div>
	<!--右边结束-->
</div>




