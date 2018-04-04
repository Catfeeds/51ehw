  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <?php $this->load->view('corporate/shop/Left_nav');?>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">销售报表</div>
          <div class="stored_sh">
          <div class="stored_sh_li">
             <div class="stored_sh_li_ad">
               <a href="<?php echo site_url('Corporate/branch')?>" >分店管理</a><a href="<?php echo site_url('Corporate/branch/branch_report')?>" class="stored_de">销售报表</a>
             </div>        
          </div>
          <form action="<?php echo site_url("Corporate/branch/branch_report");?>"  method="get" id="form_search">
            <div class="stored_sh_li_bao">
               <ul class="stored_sh_li_bao_ul">
                 <li>分店筛选：
                 <select name="branch_id" id="branch_id" class="stored_sh_li_bao_inp">
                   <option selected="" value="0">全部</option>
                   <?php if(count($branch_info)>0){
                       foreach ($branch_info as $key =>$val){
                            if($branch_id){
                                if($val['id'] ==  $branch_id){?>
                                      <option selected="" value="<?php echo $val['id']; ?>"><?php echo $val['branch_name'];?></option>
                              <?php   }else{?>
                                   <option value="<?php echo $val['id']; ?>"><?php echo $val['branch_name'];?></option>
                           <?php   }
                            }else{?>
                               <option value="<?php echo $val['id']; ?>"><?php echo $val['branch_name'];?></option>
                   <?php } 
                       } }?>
                   
                  
                </select>
                </li>
                
                <li>
                <span>消费时间：</span>
                <input type="text" value="<?php if(isset($grant_start_at)){ echo $grant_start_at;}?>" class="stored_input1" name="grant_start_at" onclick="WdatePicker()" readonly>
                <samp class="stored_input_samp1">至</samp>
                <input type="text" value="<?php if(isset($grant_end_at)){ echo $grant_end_at;}?>" class="stored_input1" name="grant_end_at" onclick="WdatePicker()" readonly>
                </li>
               <li style=" margin-right:0"><a class="stored_sh_cha" href="javascript:sub();">查询</a><a class="stored_sh_dao" href="<?php echo site_url("Corporate/branch/excel_order")?>">导出EXCL</a></li>
               </ul>
            <p class="stored_sh_li_bao_ul_p">筛选结果消费总额：<?php echo $sum_price;?>货豆</p>
            </div>
         </form>
            <div class="stored_zhong">
             
                <table width="850"  border="1" cellpadding="0" cellspacing="0" class="table_st">
				<tbody>
                    <tr class="tr1">
						<th width="160px">消费时间</th>
						<th width="120px">消费金额(货豆)</th>
						<th width="305px">消费账号</th>
						<th width="120px">消费昵称</th>
						<th width="140px">消费分店</th>
						
					</tr>
                 	<?php foreach ($order as $key =>$val){?>
                 	    <tr>
    					    <th width="160px"><?php echo $val['pay_time'];?></th>
    						<th width="120px"><?php echo $val['total_price'];?></th>
    						<th width="305px"><?php echo $val['name'];?></th>
    						<th width="120px"><?php echo $val['nick_name'];?></th>
    						<th width="140px"><?php echo $val['branch_name'];?></th>
						</tr>
                 	<?php }?>
                  
				</tbody>
                </table>
            </div>
             <div class="jilu">
                      <p>显示 <?php if(count($order) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    	  </div>
                    <div class="showpage">
                    	<?php echo $page;?>
                    </div>
    
          </div>  
         </div>
       <!--右边结束-->    
         </div>


<script>
function sub(){
// 	$branch_id = $("select[name='branch_id']").val();
	var grant_start_at = $("input[name='grant_start_at']").val();
	var grant_end_at = $("input[name='grant_end_at']").val();
	if(grant_start_at){
		
		if(!grant_end_at){
			alert("请选择截止日期！");return;
			}
		if(grant_start_at > grant_end_at){
			alert("开始日期不能大于截止日期！");return;
			}
		}else{
			if(grant_end_at){
				alert("请选择开始日期！");return;
				}
			}

	console.log(grant_start_at);
	console.log(grant_end_at);
	$('#form_search').submit();
}
</script>

	