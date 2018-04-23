    <div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li><a href="<?php echo site_url('member/property/get_list')?>">我的资产</a></li>
                <!-- <li ><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
                <li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
                <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>订单中心 </a></li>
                <li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
                <li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
                <li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户中心</a></li>
                <li  ><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li ><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
                <!--<li><a href="#">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
            	<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li ><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
                <!--<li><a href="#">在线客服</a></li>-->
                <!--<li class="kehu_current"><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
            </ul>
        </div>

		<div class="huankuan_cmRight">
        	<div class="huankuan_rTop">返修/退换货</div>
            <div class="huankuan_rCon01">
            	<ul>
                	<li ><a href="<?php echo site_url('member/return_repair')?>">申请返修/退换货</a></li>
                    <li class="huankuan_line"></li>
                    <li><a href="<?php echo site_url("member/return_repair/record");?>">返修/退换记录</a></li>
                    <li class="huankuan_line"></li>
                    <li class="huankuan_rCon01_current"><a href="<?php echo site_url("member/return_repair/details");?>">退款明细</a></li>
                </ul>
            </div>
            <!--右边按钮-->
            <div class="kehufuwu_03_btn"><a href="#">联系客服</a></div>
            <!--表格内容-->
            <div class="kehufuwu_03_con">
            	<table width="910" height="200" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1 kehufuwu_03_table">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="80px">服务单号</th>
                            <th width="122px">订单编号</th>
                            <th width="274px">订单商品</th>
                            <th width="154px">退款明细</th>
                            <th width="110px">退款申请时间</th>
                            <th width="86px">退款状态</th>
                            <th width="82px">操作</th>
                    	</tr>
                    	<tr class="kehufuwu_03_table_tr">
                            <th>10001</th>
                            <th>134202933428</th>
                            <th class="kehufuwu_03_table_th03">
                       	    <img src="images/shili.jpg" width="88" alt=""/>
                            <p class="kehufuwu_03_p03">Midea/美的 FS506全智能电饭煲 电饭锅 预约 正品带发票 全国联保</p>
                            </th>
                            <th>
                            	<span>退款金额： ￥300.00</span><br>
                            	<span>退还提货权：0</span>
                            </th>
                            <th class="kehufuwu_03_th05_span">
                            	<span>2015-10-17</span><br>
                            	<span>10:54:49</span>
                            </th>
                            <th>已完成</th>
                             <th><a href="#" style="color:#fca543; text-decoration:underline">查看</a></th>
                    	</tr>
                    </table>
            </div>
            
        </div>



    </div>

