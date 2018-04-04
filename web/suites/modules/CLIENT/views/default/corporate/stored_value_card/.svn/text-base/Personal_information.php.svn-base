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
				<li class="houtai_zijin_current">
					<a href="<?php echo site_url('Corporate/Savings_card/My_List')?>">我的线上储值卡</a>
				</li>
				
			</ul>
		</div>
	</div>
	<!--左边结束-->
	<!--右边-->
	<div class="stored_top">
		<div class="stored_top_sh">储值卡信息</div>
		<div class="stored_sh">
			<?php if( $list ){?>
    			<div class="stored_zhong">
    
    				<table width="909" border="1" cellpadding="0" cellspacing="0"
    					class="table_st">
    					<tbody>
    						<tr class="tr1">
    							<th width="140px">线上储值卡名称</th>
    							<th width="100px">销售商</th>
    							<th width="100px">承兑商</th>
    							<th width="180px">授权有效期</th>
    							<th width="100px">授权总额</th>
    							<th width="80px">授权余额</th>
    							<th width="80px">实际余额</th>
    							<th width="180px">操作</th>
    						</tr>
    						<?php foreach ( $list as $v ){?>
    						
        						<tr>
        							<th width="140px"><?php echo $v['card_name']?></th>
        							<th width="100px"><?php echo $v['sales_name']?></th>
        							<th width="100px"><?php echo $v['convert_name']?></th>
        							<th width="180px"><?php echo $v['start_time']?> 至 <?php echo $v['end_time']?> 
        							<?php  if( $v['end_time'] >= date('Y-m-d') )
        							{ 
        							    $day = diffBetweenTwoDays( $v['end_time'], date('Y-m-d') );
        							    
        							    if( $day == 0)
        							    { 
        							        echo '今天过期';
        							    }else{ 
        							        echo '还剩'.$day.'天过期';
        							    }
        							}else{ 
        							    echo '已过期';
        							}
        							
        							?>
        							
        							</th>
        							<th width="100px"><?php echo $v['card_amount']?></th>
        							<th width="80px"><?php echo $v['parent_id'] == 0 ? '-' : $v['remaining_card_amount']?></th>
        							<th width="80px"><?php echo $v['parent_id'] == 0 ? $v['remaining_card_amount'] : $v['level_two_show_card_amount']?></th>
        							<th width="180px">
            							<a href="<?php echo site_url('Corporate/Savings_card/Card_Consume_List/'.$v['id'])?>" style="margin: 0 5px;">我的使用明细</a>
            							<?php if( $v['parent_id'] == 0 ){?>
            								<a href="<?php echo site_url('Corporate/Savings_card/My_Authorize_View/'.$v['id'])?>" style="margin: 0 5px;">使用授权管理</a>
            							<?php }?>
        							</th>
        						</tr>
    
    						<?php }?>
    					</tbody>
    				</table>
    			</div>
			<?php }else{?>
				<div class="result_null" style="margin-top: 10px;">暂无储值卡。</div>
			<?php }?>
				<div class="pingjia_showpage" style="margin-right:30px">
                		<?php  echo  $pagination;?>
                </div>
		</div>
	</div>
	<!--右边结束-->
</div>




