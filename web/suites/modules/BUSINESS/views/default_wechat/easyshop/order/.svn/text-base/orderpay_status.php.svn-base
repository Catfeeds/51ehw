<div class="page clearfix">         
           
        <div class="afterpay_status">
            <ul>
            <?php switch ($status){
            	
				case 2:{?>
                <!-- cancel 状态 -->
                <li>               
                    <h1 class="text-center">您的订单支付已取消！</h1>
                    <p class="text-center">您的订单号：<span><?php echo $charge['obj_no'];?></span></p>
                    <!-- <p class="text-center mb-40">您可以的订单页面再进行处理支付。</p> -->
                    <a href="<?php echo site_url("Easyshop/order/detail/".$order['tribe_id'].'/'.$order['id']);?>" class="pay-style red-but">处理订单</a>
                    <a href="<?php echo site_url("home");?>" class="pay-style red-but">继续购物</a>
                </li>
                <?php break;
				}
				case 3:{?>
                <!-- fail 状态 -->
                <li>               
                    <h1 class="text-center mb-40">亲，您的订单出错了，请联系客服</h1>
                    <a href="tel:<?php echo $this->session->userdata('app_info')['cs_phone'];?>" class="pay-style red-but">联系客服</a>
                    <a href="<?php echo site_url("Easyshop/order/detail/".$order['tribe_id'].'/'.$order['id']);?>" class="pay-style red-but">处理订单</a>
                    <a href="<?php echo site_url("home");?>" class="pay-style red-but">继续购物</a>
                </li>
                <?php break;
				}
            }?>
            </ul>
           
        </div>
            
</div>