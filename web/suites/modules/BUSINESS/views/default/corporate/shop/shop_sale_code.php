<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                	<li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <!--<li><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>
                    <li><a href="<?php //echo site_url('corporate/myshop/ad_admin') ?>">广告管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>" >账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >实体消费二维码</a></li>
                    
                </ul>
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">实体消费二维码</div>
            <div id="code" class="sale_code"></div>
           		<div class="sale_code">
           		<p>已绑定商品：<?php echo isset($product_list['name']) ? $product_list['name'] : '暂无'?></p>
<!--             	<a href="" class="sale_code_btn">导出二维码</a> -->
            </div>
       </div>
  </div>
<script src="js/qrcode.js"></script>
  <script type="text/javascript">
 
$(function(){
	
	var str = "<?php echo isset($product_list['id']) ? site_url('corporate/sale/pay_view/'.$product_list['id'].'/'.$product_list['corporation_id']) : ''?>"
	$('#code').qrcode(str);
	
	$("#sub_btn").click(function(){
		$("#code").empty();
		var str = toUtf8($("#mytxt").val());
		
		$("#code").qrcode({
			render: "table",
			width: 200,
			height:200,
			text: str,
			
		});
	});
})
function toUtf8(str) { 
	var out, i, len, c;   
    out = "";   
    len = str.length;   
    for(i = 0; i < len; i++) {   
    	c = str.charCodeAt(i);   
    	if ((c >= 0x0001) && (c <= 0x007F)) {   
        	out += str.charAt(i);   
    	} else if (c > 0x07FF) {   
        	out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));   
        	out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));   
        	out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
    	} else {   
        	out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));   
        	out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
    	}   
    }   
    return out;   
}  
</script>