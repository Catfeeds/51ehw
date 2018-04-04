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
                        <p class="text-center">您已成功充值<span><?php echo $charge['amount'];?></span>元</p>
                        <a href="<?php echo site_url("customer/fortune");?>" class="pay-style red-but">完成</a>
                        
                    </li>
                    <?php break;
					}
					case 2:{?>
                    <!-- cancel 状态 -->
                    <li style="margin-top: 20px;">       
                        <span class="icon-ku" style="display: block;text-align: center;font-size: 90px;color: #FECF0A;"></span>     
                        <h1 class="text-center">充值取消</h1>
                        <p class="text-center mb-40">您可以随时继续充值</p>
                        <a href="<?php echo site_url("charge/incharge");?>" class="pay-style red-but">继续充值</a>
                        <a href="<?php echo site_url("customer/fortune");?>" class="pay-style red-but">返回我的资产</a>
                        <a href="<?php echo site_url("Home");?>" class="pay-style red-but">返回首页</a>
                    </li>
                    <?php break;
					}
					case 3:{?>
                    <!-- fail 状态 -->
                    <li style="margin-top: 20px;">               
                        <span class="icon-jiazaishibai" style="display: block;text-align: center;font-size: 90px;color: #FECF0A;"></span>
                        <h1 class="text-center mb-40">充值失败</h1>
                        <a href="tel:<?php echo $this->session->userdata('app_info')['cs_phone'];?>" class="pay-style red-but">联系客服</a>
                        <a href="<?php echo site_url("charge/incharge");?>" class="pay-style red-but">继续充值</a>
                        <a href="<?php echo site_url("customer/fortune");?>" class="pay-style red-but">返回我的资产</a>
                        <a href="<?php echo site_url("Home");?>" class="pay-style red-but">返回首页</a>
                    </li>
                    <?php break;
					}
                }?>
                </ul>
               
            </div><!--afterpay_status end-->
            
        </div><!--page end-->   