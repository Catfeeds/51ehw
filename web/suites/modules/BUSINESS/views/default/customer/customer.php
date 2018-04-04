    
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>


    

    <div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
                <!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
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
                <li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li  class="kehu_current"><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
                <!--<li><a href="javascript:;">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
            	<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
                <!--<li><a href="javascript:;">在线客服</a></li>-->
                <!--<li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
            </ul>
            <ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
        </div>
        
        <div class="huankuan_cmRight clearfix">
        <form name="customersearch" method="get" action="<?php echo site_url('customer/customerdata/'.$level."/".$fid);?>">
        	<div class="huankuan_rTop">我的客户</div>
            <div class="kehu_rCon04 clearfix">
            	<label class="kehu_rCon04_lable">客户注册日期：
                	<div class="kehu_rCon04_inp">
                        <input type="text" class="kehu_rCon04_input2" name="begindate" value="<?php echo $begindate;?>" onClick="WdatePicker()" readonly>
                        <span>&nbsp;至 </span>
                        <input  type="text" class="kehu_rCon04_input3" name="enddate" value="<?php echo $enddate?>" onClick="WdatePicker()" readonly>
                    </div>
                </label>
                <label class="kehu_rCon04_lable">客户会员账号:   <input class="kehu_rCon04_input" name="username" type="text" value="<?php echo $username?>"></label>
                <label class="kehu_rCon04_lable">客户联系电话：  <input class="kehu_rCon04_input" name="phone" type="text" value="<?php echo $phone;?>"></label>
                <div class="kehu_rCon04_btn"><a id="sub">开始查询</a></div>           
            </div>
        </form>
            
            <div class="kehu_wode_con">
            	<div class="kehu_wode_con01">
                	<ul>
                    	<li>序号</li>
                        <li style="width:185px">会员账号</li>
                        <li>会员ID</li>
                        <li>注册日期</li>
                        <li>登录次数</li>
                        <li>消费金额</li>
                        <li>分红金额</li>
                    </ul>
                </div>
                <?php if($result && count($result>0)){ 
								foreach($result as $key=>$c)
							{
								?>
                <div class="kehu_wode_con01 kehu_wode_con02">
                	<ul>
                	
                    	<li><?php echo ($key+1);?></li>
                        <li style="width:185px"><?php echo $c["name"];?></li>
                        <li><?php echo $c["customer_id"];?></li>
                        <li><?php  $datetime=strtotime($c["registry_at"]); if($datetime>0){echo date('Y-m-d',abs(strtotime($c["registry_at"])));}else{echo '待定';};?></li>
                        <li><?php echo $c["login_count"]?></li>
                        <li>￥ <?php echo $c["total_price"]==null? "0.00":  $c["total_price"];?></li>
                        <li>￥ <?php echo $c["rebate"]==null?"0.00":$c["rebate"];?> </li>
                        <!-- <li><?php  ?></li> -->
                        <!--<li style="width:90px !important; border-right:0"><a href="<?php echo site_url('customer/customerDataDetail/'.$level.'/'.$c["id"])?>" class="btn btn-custom btn-xs">查看</a></li>
                       -->
                    </ul>
                </div>
                 <?php }}else{?>
                        <center>暂无下级记录</center>
                        <?php }?>
            </div>
           <div class="pingjia_jilu" style="margin-left:30px">
                    	<p>显示 <?php if(count($result) > 0) echo ($cu_page -1)*$per_page + 1; else echo '0';?> 到 <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                
                    </div>
                    <div class="pingjia_showpage" style="margin-right:30px">
                    	<?php echo $page;?>
                    	      
                    </div>
        </div>
    </div>


<script>
   $('#sub').click(function(){
	    $('form').submit();
	   });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>

