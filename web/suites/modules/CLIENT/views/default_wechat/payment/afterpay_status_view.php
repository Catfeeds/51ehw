<div class="page clearfix">         
           
            <div class="afterpay_status">
                <ul>
                <?php switch ($status){
                	case 1:{?>
                	<!-- OK 状态 -->
                    <li>               
                        <h1 class="text-center">您的订单已支付成功！</h1>
                        <p class="text-center">支付时间：<span><?php echo $pay_date;?></span></p>
                        
                        <?php if( !empty($order) ):?>
                        <p class="text-center">您的订单号：<span><?php echo $order['order_sn'];?></span></p>
                        <a href="<?php echo site_url("member/order/detail/".$order['id']);?>" class="pay-style red-but">订单详情</a>
                        <?php else:?>
                            <a href="<?php echo site_url('Member/order');?>" class="pay-style red-but">订单列表</a>
                        <?php endif;?>
                        
                        <a href="<?php echo site_url('Home');?>" class="pay-style red-but">继续购物</a>
                    </li>
                    <?php break;
					}
					case 2:{?>
                    <!-- cancel 状态 -->
                    <li>               
                        <h1 class="text-center">您的订单支付已取消！</h1>
                        <?php if( !empty($order) ):?>
                            <p class="text-center">您的订单号：<span><?php echo $order['order_sn'];?></span></p>
                            <p class="text-center mb-40">您可以到订单页面再进行处理支付。</p>
                            <a href="<?php echo site_url("member/order/detail/".$order['id']);?>" class="pay-style red-but">处理订单</a>
                        <?php else:?>
                            <a href="<?php echo site_url('Member/order');?>" class="pay-style red-but">订单列表</a>
                        <?php endif;?>
                        <a href="<?php echo site_url('Home');?>" class="pay-style red-but">继续购物</a>
                    </li>
                    <?php break;
					}
					case 3:{?>
                    <!-- fail 状态 -->
                    <li>               
                        <h1 class="text-center mb-40">亲，您的订单出错了，请联系客服</h1>
                        <a href="tel:<?php echo $this->session->userdata('app_info')['cs_phone'];?>" class="pay-style red-but">联系客服</a>
                        <?php if( !empty($order) ):?>
                            <a href="<?php echo site_url("member/order/detail/".$order['id']);?>" class="pay-style red-but">处理订单</a>
                        <?php else:?>
                            <a href="<?php echo site_url('Member/order');?>" class="pay-style red-but">订单列表</a>
                        <?php endif;?>
                            <a href="<?php echo site_url('Home');?>" class="pay-style red-but">继续购物</a>
                    </li>
                    <?php break;
					}
                }?>
                </ul>
               
            </div><!--afterpay_status end-->
            
        </div><!--page end-->   