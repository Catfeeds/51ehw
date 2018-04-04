<div class="top2 manage_fenlei_top2">
    	<ul>

    		<li class="tCurrent"><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>

</div>
<div class="Box member_Box clearfix">
        <div class="cmLeft">
        	<div class="cmLeft_top">
            	<p class="cmLeft1"><?php echo $corporation['corporation_name'];?></p>
                <div class="cmLeft2">
                <!-- 旗舰店会员 -->
                <?php
                    switch ($corporation['grade']){
                        case 1 :
                            echo '易货店会员';
                        break;
                        case 2 :
                            echo '专卖店会员';
                        break;
                        case 3 :
                            echo '旗舰店会员';
                        break;
                    }
                ?>
                </div>
                <!--<p style="font-size:14px; margin-top:10px"><?php echo $corporation['expired_date'];?>到期</p>
                <div class="cmLeft3">续费会员</div>-->
                <div class="dian_f">
                <p style="margin-top:20px; font-size:16px; line-height:24px; overflow:hidden;">
				<span class="cmLeft2_1">货豆：</span>  <span class="cmLeft2_r"><?php echo  number_format( (isset($pay_info['M_credit']) ? $pay_info['M_credit'] : '0.00'),2 )?></span></p>
				<p style="font-size:16px; line-height:24px"><span class="cmLeft2_1">财富：</span> <span class="cmLeft2_r">￥<?php echo  isset($pay_info['cash']) ? $pay_info['cash'] : '0.00' ?></span></p>
                <div class="cmLeft-line"></div>
                <p style="font-size:16px; "><span class="cmLeft2_1">保证金：</span> <span class="cmLeft2_r">￥<?php echo $corporation['deposit'];?></span></p>
                </div>
				<!--
                  <div class="dian_f">
                <p style="margin-top:20px; font-size:16px; line-height:24px; overflow:hidden;">
				<span class="cmLeft2_4">分公司：</span>  <span class="cmLeft2_r">西安</span></p>
				<p style="font-size:16px; line-height:24px"><span class="cmLeft2_5">合伙人：</span> <span class="cmLeft2_r">西安旅游业协会</span></p>
                <div class="cmLeft-line"></div>
                <p style="font-size:16px; "><span class="cmLeft2_6">上线会员：</span> <span class="cmLeft2_r">陈雷</span></p>
                </div> -->
                <div class="cmLeft4"><a href="<?php echo site_url('home/GoToShop/'.$corporation['id']); ?>">我的店铺</a></div>
                <div class="cmLeft4"><a href="<?php echo site_url('member/property/get_list'); ?>">资产账号</a></div>
                <!--<div class="cmLeft5">管理店铺</div>-->
            </div>
            <!--<div class="cmLeft_down">
            	<p class="cmLeft1" style="font-family:Microsoft YaHei">我的授信</p>
                <div class="cmLeft3">申请额度</div>
                <p style="margin-top:20px; font-size:16px; line-height:24px">授权总额度：<br>
				￥0.00</p>
                <p style="margin-top:10px; font-size:16px; line-height:24px">
                已使用额度：<br>
				￥0.00</p>
                <p style="margin-top:10px; font-size:16px; line-height:24px">
                本期应还额度：<br>
				￥0.00</p>
                <p style="margin-top:15px; color:#ff0101">还款期限：-</p>
                <div class="cmLeft-line"></div>
                <div class="cmLeft4">立即还款</div>
                <div class="cmLeft5">还款记录</div>
            </div>-->
        </div>
        <div class="cmRight">

            	<table width="969" height="419" border="1" cellpadding="0" cellspacing="0" class="table3">
                	<tbody><tr class="f20"><th colspan="8">企业会员</th></tr>
                    <tr style="background:#ffe3c4">
                                <th width="25%">会员卡种类</th>
                                <th width="25%">会员费</th>
                                <th width="25%">易货手续费率</th>
                                <th width="25%">质量保证金</th>

                            </tr>

                            <tr>
                                <th>旗舰店会员</th>
                                <th>10万</th>
                                <th>3%</th>
                                <th>5%</th>
                            </tr>
                            <tr>
                                <th>专卖店会员</th>
                                <th>5万</th>
                                <th>4%</th>
                                <th>5%</th>
                            </tr>
                            <tr>
                                <th>易货店会员</th>
                                <th>1万履约保证金</th>
                                <th>5%</th>
                                <th>5%</th>
                            </tr>


                    </tbody></table>



             <!--  <div class="cmRight_down">企业会员</div>-->

   <!-- <div class="houtaishouye_box clearfix">
    <div class="houtaishouye_con">
	<p class="houtaishouye_p" >以下是您未处理的任务清单</p>
    <ul class="houtaishouye_ul clearfix ">
    	<li>
            <p><?php //echo $count_wait_dispatch?></p>
            <div class="houtaishouye_a"><a href="<?php //echo site_url('corporate/order/get_list/wait_dispatch')?>">待发货订单</a></div>
        </li>
        <li>
            <p><?php //echo $count_wait_comments;?></p>
            <div class="houtaishouye_a"><a href="<?php //echo site_url('corporate/comment/get_list/1');?>">待处理评价</a></div>
        </li>
        <li class="houtaishouye_li">
        	<p>19</p>
            <div class="houtaishouye_a"><a href="#">库存预警商品</a></div>
        </li>
        <li>
            <p>19</p>
            <div class="houtaishouye_a"><a href="#">审批未通过商品</a></div>
        </li>
        <li>
            <p><?php //echo $count_wait_product;?></p>
            <div class="houtaishouye_a"><a href="<?php //echo site_url('corporate/product/get_list/0/notsale');?>">等待上架商品</a></div>
        </li>
        <li class="houtaishouye_li">
        	<p>19</p>
            <div class="houtaishouye_a"><a href="#">申请退/换订单</a></div>
        </li>
    </ul>
</div>
</div>-->

        </div>
    </div>