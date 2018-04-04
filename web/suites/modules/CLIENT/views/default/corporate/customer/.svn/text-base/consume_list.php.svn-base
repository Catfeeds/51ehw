<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link href="css/swiper3.08.min.css" rel="stylesheet" type="text/css">
<!--<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">-->
<title>51易货网</title>
</head>

<body>

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
            <div class="cmRight_tittle">消费记录</div>
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con" style="height:auto;">
            	<div class="dingdan_kehuguanli_top">
            	<div class="search_2 manage_fenlei_search_2">
                    <form action="<?php echo site_url('corporate/customer/customer_consume_list/'.$customer_id).'/';?>" method='get'>	
                    	<div><input type="text" class="search2_con manage_fenlei_search2_con" name="product_name"></div>
                        <div class="search2_btn manage_fenlei_search2_btn"><a href="javascript:sub();">店内搜索</a></div>
                    </form>
                </div>
                
                <div class="kehu_guanli2_btn"><a href="<?php echo site_url('corporate/customer/get_list');?>">返回</a></div>
                
                </div>
                
                
                <div class="kehuguanli_con01">
                    <table width="910"  border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                    	<th width="34px">序号</th>
                        <th width="444px">商品名称</th>
                        <th width="78px">数量</th>
                        <th width="118px">消费金额</th>
                        <th width="134px">购买时间</th>
                    </tr>
                    <?php if(count($list > 0)):?>
                        <?php foreach ($list as $v):?>  
                           <?php @$k ++;?>
                           <tr>
                            	<th width="34px"><?php echo $k;?></th>
                                <th width="444px"><?php echo $v['name']?></th>
                                <th width="78px"><?php echo $v['quantity']?></th>
                                <th width="118px">￥<?php echo $v['price']?></th>
                                <th width="202px"><?php echo $v['place_at']?></th>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                    <table width="910" height="50" class="result_null" style="margin-top:10px">
                    <tr>
                        <th>暂无消费记录</th>
                    </tr>  
                    </table> 
                    <?php endif;?>
                    </table>
                </div>
                    
                    
                    
                    <div class="jilu">
                    
                    
                    	<p>显示 <?php if(count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    </div>
                    
                    <div class="showpage">
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
        <!---->
         </div>
         </div>
    </div>

</body>
</html>
<script>
function sub(){ 

	$('form').submit();
}
</script>
