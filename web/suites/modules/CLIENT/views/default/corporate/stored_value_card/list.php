   <?php //储蓄卡头部菜单导航  
            $data['head_menu'] = 2;
            $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">我是销售商</div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">查看线上储值卡</a></li>
                	<li><a href="<?php echo site_url('Corporate/Savings_card/Apply_View')?>">申请储值卡</a></li>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">线上储值卡</div>
          <div class="stored_sh">
          <div class="stored_sh_li">
            <h2 class="stored_sh_h2">我是销售商</h2>
            <a class="stored_sh_span" href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>">切换至我是承兑商</a>
            <a class="stored_sh_rigth" href="<?php echo site_url('Corporate/Savings_card/Apply_View')?>">线上储值卡申请</a>
          </div>
            
            <?php if( $list ) {?>
            <div class="stored_zhong">
                <table width="909"  border="1" cellpadding="0" cellspacing="0" class="table_st">
				<tbody>
                    <tr class="tr1">
						<th width="140px">线上储值卡名称</th>
						<th width="100px">承兑商</th>
						<th width="100px">总额度</th>
						<th width="100px">余额</th>
						<th width="200px">有效期</th>
						<th width="80px">审核状态</th>
						<th width="80px">操作</th>
<!--                         <th width="80px">备注</th> -->
					</tr>
					<?php foreach ( $list as $v ){?>
					
                         <tr>
    						<th width="140px"><?php echo $v['card_name']?></th>
    						<th width="100px"><?php echo $v['corporation_name']?></th>
    						<th width="100px"><?php echo $v['card_amount']?></th>
    						<th width="100px"><?php echo $v['card_remaining']?></th>
    						<th width="200px"><?php echo $v['start_time']?> 至 <?php echo $v['end_time']?></th>
    						<th width="80px"><?php echo $v['status'] == 1 ? '通过' : ( $v['status'] == 2 ? '未通过' : '审核中');?></th>
    						
							<th width="80px">
    							<?php if( $v['status'] == 1 ){?>
    								<a class="stored_zhong_a" href="<?php echo site_url('Corporate/Savings_card/Sales_Authorization/'.$v['id'])?>">销售授权</a>
    							<?php }?>
							</th>
    						
                            <!-- <th width="80px"><?php //echo $v['remarks']?></th> -->
    					</tr>
					<?php }?>
                    
                    
				</tbody>
                </table>
            </div>
            <?php }else{?>
      			<div class="result_null" style="margin-top:10px;" >暂无内容，请点击上面添加按钮来添加产品</div>    
     		 <?php }?>
 		       
                <div class="pingjia_showpage" style="margin-right:30px">
            		<?php  echo  $pagination;?>
                </div>
     		 
          </div>  
         </div>
       <!--右边结束-->    
         </div>




	