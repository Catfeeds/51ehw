    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li class="tCurrent" ><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<!--内容开始-->
    <div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">客户管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/customer/get_list');?>">客户列表</a></li>
                </ul>
            </div>
        </div>
        
                <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">客户列表</div>
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con" style="height:auto;">
            	<div class="dingdan_kehuguanli_top">
            	<div class="search_2 manage_fenlei_search_2">
                	<form action="<?php echo site_url('corporate/customer/get_list/');?>" method='get'>
                	   <div><input type="text" class="search2_con manage_fenlei_search2_con" name="customer_name"></div>
                    </form>
                    <div class="search2_btn manage_fenlei_search2_btn"><a href="javascript:sub()">店内搜索</a></div>
                </div>
                </div>
                <!--  
                <div class="select1">
                	<ul>
                    	<li><a href="#">添加</a></li>
                        <li style="margin-right:0"><a href="#">批量删除</a></li>
                    </ul>
                </div>
                -->
                <div class="kehuguanli_con01">
                    <table width="910" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                    	
                        <th width="76px">ID</th>
                        <th width="116px">姓名</th>
                        <th width="108px">登录账号</th>
                        <th width="134px">消费总额</th>
                        <th width="130px">登录时间</th>
                        <th width="134px">注册时间</th>
                        <th width="178px">操作</th>
                    </tr>
                    <?php if(count($list) > 0):?>   
                        <?php foreach ($list as $v):?>
                            <tr>
                            	
                                <th width="72px"><?php echo $v['id']?></th>
                                <th width="116px"><?php echo $v['nick_name']?></th>
                                <th width="108px"><?php echo $v['name']?></th>
                                <th width="134px"> ￥<?php echo $v['price']?> </th>
                                <th width="130px"><?php echo substr($v['last_login_at'],'0','10')?><br><?php echo substr($v['last_login_at'],'10');?></th>
                                <th width="134px"><?php echo substr($v['registry_at'],'0','10')?><br><?php echo substr($v['registry_at'],'10')?></th>
                                <th width="178px">
                                	<!--  <a href="#" style="color:#fca543; margin-right:40px; text-decoration:underline">编辑</a>-->
                                    <a href="<?php echo site_url('corporate/customer/customer_consume_list/'.$v['id'])?>" style="color:#fca543; text-decoration:underline">消费记录</a>
                                </th>
                            </tr>
                        <?php endforeach;?>   
                    <?php else: ?>
                    <table width="910" height="50" class="result_null" style="margin-top:10px">
                    <tr>
                        <th>暂无内容</th>
                    </tr>  
                    </table>
                    <?php endif;?>   
                    </table>
                </div>
                    
                    
                    
                    <div class="jilu jiluLeft">
                    
                    	<p>显示 <?php if(count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    </div>
                    <div class="showpage" style="margin-right:30px;">
                    	<?php echo $page;?>
                    	<!--  
                    	<a href="#" class="lPage">上一页</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a class="cpage">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <span>…</span>
                        <a href="#" class="lPage">下一页</a>
                        -->
                    </div>
                </div>
        </div>
         </div>
         </div>
    </div>

<!--内容结束-->
<script>
function sub(){ 

	$('form').submit();
}
</script>

