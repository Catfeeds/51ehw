   <?php //储蓄卡头部菜单导航  
        $data['head_menu'] =  !$status ? 2 : 3 ;
        $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle"><?php echo !$status ? '我是销售商' : '我是承兑商'; ?></div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul> 
            	   <?php if( !$status ){?>
                       <li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">查看线上储值卡</a></li>
                       <li><a href="<?php echo site_url('Corporate/Savings_card/Apply_View')?>">申请储值卡</a></li>
                   <?php }else{?>
                        <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>"  >全部</a></li>
                        <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/1')?>"  >待审核</a></li>
                        <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/2')?>"  >已通过</a></li> 
                        <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/3')?>"  >已拒绝</a></li>
                 
                   <?php }?>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh"><?php echo !$status ? '销售授权管理' : '承兑商查看销售商'; ?></div>
          <div class="stored_sh">
          <div class="stored_sh_li">
             <div class="stored_sh_li_p">
               <p><span>线上储值卡名称：</span><?php echo !empty($detaile) ? $detaile['card_name'] : ''?></p>
               <p><span>储值卡总额：</span><?php echo !empty($detaile) ? $detaile['card_amount'] : ''?> 货豆</p>
               <p><span>销售已授：</span><?php echo !empty($detaile) ? number_format($detaile['card_amount'] - $detaile['card_remaining'],2,".","") : ''?> 货豆</p>
               <p><span>储值卡授权余额：</span><?php echo !empty($detaile) ? $detaile['card_remaining'] : ''?> 货豆</p>
             
             </div> 
            <a class="stored_sh_rig" href="javascript:history.back();">返回</a>
            <?php if( !$status ){?>
            <a class="stored_sh_rigth" href="<?php echo !empty($detaile) && $detaile['card_remaining'] > 0 ? site_url('Corporate/Savings_card/Sales_Card_View/'.$detaile['id']) : "javascript:alert('授权余额不足')"?>">销售授权</a>
            <?php }?>
            
          </div>
            <?php if( $list ){?>
            <div class="stored_zhong">
             
                <table width="909"  border="1" cellpadding="0" cellspacing="0" class="table_st">
				<tbody>
                    <tr class="tr1">
						<th width="173px">销售授权日期</th>
						<th width="150px">账户名</th>
						<th width="100px">昵称</th>
						<th width="100px">销售授权额度</th>
						<th width="200px">授权期限</th>
						<th width="80px">操作</th>
						<th width="80px">备注</th>
					</tr>
					 <?php foreach ( $list as $v ){?>
                         <tr>
    						<th width="173px"><?php echo $v['created_at']?></th>
    						<th width="150px"><?php echo $v['name']?></th>
    						<th width="100px"><?php echo $v['nick_name']?></th>
    						<th width="100px"><?php echo $v['card_amount']?></th>
    						
    						<th width="200px"><?php echo $v['start_time']?> 至 <?php echo $v['end_time']?> </th>
    						<th width="80px"><a href="<?php echo site_url('Corporate/Savings_card/Card_Consume_Detaile/'.$v['id'].'/'.$status);?>">查看详情</a></th>
    						<th width="80px"></th>
    					</tr>
                    <?php }?>
                    
				</tbody>
                </table>
            </div>
            
            <?php }else{?>
      			<div class="result_null" style="margin-top:10px;" >暂无授权记录</div>    
     	    <?php }?>	
     	    
     	     <div class="pingjia_showpage" style="margin-right:30px">
            		<?php  echo  $pagination;?>
            </div>
          </div>  
         </div>
       <!--右边结束-->    
         </div>




	