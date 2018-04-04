
<!--交易详情开始-->
   <div class="transaction">
      <div class="transaction_top">
        <span class="transaction_span"><img src="<?php echo isset($order_info['img_url']) ? IMAGE_URL.$order_info['img_url']:'images/51_logo.png' ?>" onerror="this.src='images/51_logo.png'"/></span>
        <div class="transaction_top_rigth">
          <p><?php echo $order_info['corporation_name']?></p>
        </div>
      </div>
       <div class="transaction_sh">
          <h1>￥ <?php echo $rebate_total;?></h1>
          <p>分成总额</p>
       </div>
      <ul class="transaction_wei">
         <li>
            <div class="transaction_wei_top">
              <div class="transaction_wei_left">订单编号</div>
              <div class="transaction_wei_right">
                 <p><?php echo $order_info['order_sn']?></p>
              </div>
            </div>
         </li>
         <li>
            <div class="transaction_wei_top">
              <div class="transaction_wei_left">订单类型</div>
              <div class="transaction_wei_right">
                 <p>交易订单</p>
              </div>
            </div>
         </li>
          <li>
            <div class="transaction_wei_top">
              <div class="transaction_wei_left">交易时间</div>
              <div class="transaction_wei_right">
                 <p><?php echo $order_info['place_at']?></p>
              </div>
            </div>
         </li>
          <li>
            <div class="transaction_wei_top">
              <div class="transaction_wei_left">订单总额</div>
              <div class="transaction_wei_right">
                 <p><?php echo $order_info['total_price']?> </p>
              </div>
            </div>
         </li>
         <?php if( $rebate_list ){?>
         <li>
            <div class="transaction_wei_top">
              <div class="transaction_wei_left">分成详情</div>
              <div class="transaction_wei_right">
              <?php foreach ($rebate_list as $v ){?>
                  <p><span class="transaction_tigth_left"><?php echo $v['name']?>手续费收益：</span><span class="transaction_tigth_right">￥ <?php echo $v['rebate']?></span></p>
              <?php }?>
              </div>
            </div>
         </li>
      	 <?php }?>
      </ul>
   
   </div>




<!--交易详情结束-->