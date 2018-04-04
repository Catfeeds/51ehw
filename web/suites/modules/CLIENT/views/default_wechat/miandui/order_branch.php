
<style type="text/css">
	.container {background-color: #f6f6f6!important;}
</style>


<div class="header" style="height:50px;">
           <div class="main_dui">
            <a href="javascript:history.back();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px; float:none; display:block;font-size: 20px;"></a>
            <div class="main_dui_top">
            <p class="title">订单分店</p>
            </div>  
           </div> 
</div>
 
<div class="stored_value">
     <div class="stored_value_div1"><a href="javascript:"><span>筛选日期</span><i class="icon-back"></i></a></div>
      
      <div class="order_branch">
        <ul id="hear" class="order_branch_top">
					<li class="action" style="border-bottom: 2px solid red;height: 43px;color:#06F0EC"><a href="javascript:void(0)"><samp>所有订单</samp></a></li>
					<li><a href="javascript:void(0)" ><samp>货豆订单</samp></a></li>
					<li><a href="javascript:void(0)" ><samp>储存卡订单</samp></a></li>
				</ul>
         <div class="order_branch_zhong" id="contentop">
           <ul class="order_branch_zhong_ul action">
              <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span></span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
               <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span>线上储存卡订单</span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
               <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span>线上储存卡订单</span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
           </ul>
         
         
         <ul class="order_branch_zhong_ul">             
               <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span>线上储存卡订单</span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
               <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span>线上储存卡订单</span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
           </ul>
           
           
           <ul class="order_branch_zhong_ul">
               <li>
                 <a href="#">
                  <div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>1234589656965</span></div><span>线上储存卡订单</span></div>
                  <div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>
                  <div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>10货豆</span></div><span></span></div>
                  <div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>买家昵称</span></div><span></span></div>
                 </a>
              </li>
           </ul>
         
         
         
         </div>   
      </div>


    <div class="order_branch_zhong_di">
     <a href="javascript:void(0)">销售额合计:100,000.00M</a>
    </div>

</div>


<script>
				$(function(){
					$("#hear li").click(function(){
						$(this).css({
							borderBottom: "2px solid red",
							height:"43px"
						}).siblings().css({
							borderBottom: "none",
							height:"43px"
						});
					});					
						
					$("#hear li").click(function(){
						$(this).addClass("action").siblings().removeClass("action");
						var index = $(this).index();
						$("#contentop ul").eq(index).css("display","block").siblings().css("display","none");
					});
				});
		</script>