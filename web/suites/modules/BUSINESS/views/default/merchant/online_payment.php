<?php 

//  判断用户是否登录
if (! $this->session->userdata('user_in')) {
    redirect('customer/login');
    exit();
}
?>
<!--支付信息信息-->
<form action="<?php echo site_url('charge/merchant_changeSubmit');?>" method="post" target= "_blank" >
   <div class="home_page">
      <div class="type_xuanz">
         <div class="type_xuanz_top">
               <ul class="step-case" id="step"> 
                    <li class="s-finish"><a href="javascript:;"><span>① 店铺类型/类目选择</span><b class="b-l"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>② 填写公司信息</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>③ 上传资质</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>④ 等待审核</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-cur"><a href="javascript:;"><span>⑤ 网上缴费、店铺上线</span><b class="b-1"></b><b class="b-2"></b><b class="b-r"></b></a></li> 
                </ul>
       </div>
       <?php //var_dump($this->session->userdata('corporation_id')); ?>
       <div class="online_payment">
          
           
            <h3>应付金额: <span key="0">¥<?php echo $pay_info['cash']?></span></h3>
			<h3>交易名称: 购买<?php echo $pay_info['name']?></h3>
           
        
           <ul class="online_payment_ul">
             <li onclick="pay_type_attr(this)" class="active" item="2"><img src="images/weixinzhifu_xin.png"/></li>
             <li onclick="pay_type_attr(this)" item="1"><img src="images/zhufubao_xin.png"/></li>
             <li onclick="pay_type_attr(this)" item="3"><img src="images/yinlianzhifu_xin.png"/></li>
           </ul>
       
          <input type="hidden" name="payment_id">
          <input type="submit" name="sub" class="online_payment_ul_a" onclick="check_pay()" href="javascript:;" value="立即支付">
       </div>
        
  </div>
  </div>

</form>

<script>
 <!--点击切换-->
$(".online_payment_ul li").click(function(){

	$(this).siblings().removeClass("active");
    $(this).addClass("active");
    
})


  // 获取金额key
  var key = $(".online_payment h3 span").attr("key");
  // var index = acount.indexOf('¥');
  // acount = acount.substr(index+1);
  $("input[name='amount']").val(key);
  // 获取交易名称
  var consaction_name = $(".online_payment h3").eq(1).text();
  index =  consaction_name.indexOf("交易名称:");
  consaction_name = consaction_name.substring(index+6);
  $("input[name='consaction_name']").val(consaction_name);
  // 获取订单编号
  var order_no = $(".online_payment h3").eq(2).text();
  index =  order_no.indexOf("订单编号:");
  order_no = order_no.substr(index+6);
  $("input[name='order_no']").val(order_no);
  // 获取支付方式

  var pay_type = $(".active").attr("item");
  $("input[name='payment_id']").val(pay_type);
  function pay_type_attr(e)
  {
    pay_type = $(e).attr("item");
    $("input[name='payment_id']").val(pay_type);
  }
  function check_pay()
  {
    if(pay_type){
        // var url = '<?php echo site_url('merchant/pay_deposit');?>';
        // $.post(url,
        // {acount:acount,consaction_name:consaction_name,order_no:order_no,pay_type:pay_type},
        // function(res){
        //   console.log(res);
        // });
      }else{
        alert('请选择支付方式');
      }

  }






</script>       