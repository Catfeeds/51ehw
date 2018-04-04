

<div class="payment_page">
  <p><span>应付金额：</span><span>￥ <?php echo $pay_info['cash'] ?> 元</span></p>
  <p><span>交易名称：</span><span><?php echo $pay_info['transaction_name']?></span></p>
  <p><span>支付方式：</span><span>微信支付</span></p>

  <a href="<?php echo site_url('Charge/Cash_Shop')?>">立即支付</a>


  

</div> 