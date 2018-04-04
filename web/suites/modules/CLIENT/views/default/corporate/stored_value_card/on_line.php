      <?php //储蓄卡头部菜单导航  
            $data['head_menu'] = 3;
            $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">我是承兑商</div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul> 
            	    <li <?php echo !$status ? 'class="houtai_zijin_current"' : ''?> ><a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>"  >全部</a></li>
                    <li <?php echo $status == 1 ? 'class="houtai_zijin_current"' : ''?>><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/1')?>"  >待审核</a></li>
                    <li <?php echo $status == 2 ? 'class="houtai_zijin_current"' : ''?>><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/2')?>"  >已通过</a></li> 
                    <li <?php echo $status == 3 ? 'class="houtai_zijin_current"' : ''?>><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/3')?>"  >已拒绝</a></li>
             
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">线上储值卡</div>
          <div class="stored_sh">
          <div class="stored_sh_li">
            <h2 class="stored_sh_h2">我是承兑商</h2>
            <a class="stored_sh_span" href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">切换至我是销售商</a>
            <a class="stored_sh_rigth" href="<?php echo site_url('Corporate/branch')?>">分店管理</a>
          </div>
            
           
            <div class="stored_zhong">
              <ul class="stored_zhong_neo">
                    <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>" <?php echo !$status ? 'class="stored_bian"' : ''?> >全部</a></li>
                    <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/1')?>" <?php echo $status == 1 ? 'class="stored_bian"' : ''?> >待审核授权</a></li>
                    <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/2')?>" <?php echo $status == 2 ? 'class="stored_bian"' : ''?> >已通过的授权</a></li> 
                    <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/3')?>" <?php echo $status == 3 ? 'class="stored_bian"' : ''?>>已拒绝的授权</a></li>
              </ul>
            
                <?php if( $list ){?>
                <table width="909"  border="1" cellpadding="0" cellspacing="0" class="table_st">
				<tbody>
                    <tr class="tr1">
						<th width="140px">线上储值卡名称</th>
						<th width="125px">申请日期</th>
						<th width="125px">审核日期</th>
						<th width="100px">授权额度</th>
						<th width="100px">申请人账号</th>
						<th width="100px">申请人昵称</th>
						<th width="120px">申请人企业名</th>
						<th width="70px">状态</th>
                        <th width="80px">操作</th>
                        
					</tr>
					<?php foreach ( $list as $v ){?>
                     <tr>
						<th width="140px"><?php echo $v['card_name']?></th>
						<th width="125px"> <?php echo $v['created_at']?> </th>
						<th width="125px"> <?php echo $v['check_at'] ? $v['check_at'] : '-'?> </th>
						<th width="100px"><?php echo $v['card_amount']?></th>
						<th width="100px"><?php echo $v['name']?></th>
						<th width="100px"><?php echo $v['nick_name']?></th>
						<th width="120px"><?php echo $v['corporation_name']?></th>
						
						<th width="70px">
							<?php echo $v['status'] == 1 ? '通过' : ( $v['status'] == 2 ? '未通过' : '审核中');?>
						</th>
						
						<th width="80px">
							<?php if( $v['status'] == 0 ){?>
								<a class="stored_zhong_a" href="<?php echo site_url('Corporate/Savings_card/Convert_Apply_View/'.$v['id'])?>">审核</a>
							<?php }else if ( $v['status'] == 1 ){ ?>
							    <a class="stored_zhong_a" href="<?php echo site_url('Corporate/Savings_card/Sales_Authorization/'.$v['id'].'/1')?>">查看</a>
							<?php }?>
						</th>
						
                        
					</tr>
                    <?php }?>
                    
				</tbody>
                </table>
                <?php }else{?>
      			<div class="result_null" style="margin-top:10px;" >暂无内容</div>    
      		<?php }?>
            </div>
                <div class="pingjia_showpage" style="margin-right:30px">
                		<?php  echo  $pagination;?>
                </div>
          </div>  
         </div>
       <!--右边结束-->    
         </div>




	