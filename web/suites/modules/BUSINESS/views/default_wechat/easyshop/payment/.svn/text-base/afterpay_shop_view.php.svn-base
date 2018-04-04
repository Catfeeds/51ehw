<style type="text/css">
    .container {background:#EEEEEE!important; }
</style>
<div class="page clearfix" style="background: #EEEEEE!important;padding-top: 60px;">         
           
            <div class="afterpay_status" style="background:#EEEEEE!important;">
                <ul>
                <?php switch ($status){
                	case 1:{?>
                	<!-- OK 状态 -->
                    <li style="margin-top: 20px;">      
                        <span class="icon-roundcheck" style="display: block;text-align: center;font-size: 90px;color: #FECF0A;"></span>                 
                        <h1 class="text-center"></h1>
                        <p class="text-center">你已成功支付开店费用，客服会在24小时内联系您。如有疑问，请致电400-0029-777</p>
                        <a href="<?php echo site_url("Home");?>" class="pay-style red-but">返回首页</a>
                        
                    </li>
                    <?php break;
					}
					case 2:{?>
                    <!-- cancel 状态 -->
                    <li style="margin-top: 20px;">       
                        <span class="icon-ku" style="display: block;text-align: center;font-size: 90px;color: #FECF0A;"></span>     
                        <h1 class="text-center">支付取消</h1>
                        <p class="text-center mb-40">您可以随时继续支付</p>
                        <a href="<?php echo site_url("Corporation/shop_benefits");?>" class="pay-style red-but">返回重选</a>
                        <a href="<?php echo site_url("Home");?>" class="pay-style red-but">返回首页</a>
                    </li>
                    <?php break;
					}
					case 3:{?>
                    <!-- fail 状态 -->
                    <li style="margin-top: 20px;">               
                        <span class="icon-jiazaishibai" style="display: block;text-align: center;font-size: 90px;color: #FECF0A;"></span>
                        <h1 class="text-center mb-40">支付失败</h1>
                        <a href="tel:<?php echo $this->session->userdata('app_info')['cs_phone'];?>" class="pay-style red-but">联系客服</a>
                        <a href="<?php echo site_url("charge/Cash_Shop");?>" class="pay-style red-but">继续支付</a>
                        <a href="<?php echo site_url("Home");?>" class="pay-style red-but">返回首页</a>
                    </li>
                    <?php break;
					}
                }?>
                </ul>
               
            </div><!--afterpay_status end-->
            
        </div><!--page end-->   