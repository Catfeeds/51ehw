<style type="text/css">
	.container {background: #fff!important;}
	.offer-details-title {display: -webkit-box;overflow: hidden;text-align: left;height: 35px;line-height: 19px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
	.offer-details-tishi {padding: 0;margin-left: 0px;}
</style>
<!-- <div class="commodity_h50"></div> -->
 <div class="offer_details">
	<!-- 头部 -->
	<div class="offer-details-header" style="border-bottom: 1px solid #ddd;">
		<div class="shop-information-header">
		<ul>
		    <li class="shop-information-tu offer-details-img"><img src="<?php echo base_url(),'uploads/B/'.$requirement['img_path'];?>" height="70" width="70" alt="" onerror="this.src='images/default_img_s.jpg'"></li>
		    <li>
		    	<span class="offer-details-title"><?php echo $requirement['title'];?></span><span class="offer-details-tishi 
		    	<?php 
		    	if($requirement['ispublish'] == 2){
	    	            if($requirement['is_putaway'] == 1){
	    	                echo 'changdang';
	    	                ?>">抢单中</span><?php 
	    	            }else{
	    	                echo 'shenhe-pass';
	    	                ?>">审核通过</span><?php
	    	            } 
		    	}    
		    	
		    	if($requirement['ispublish'] == 1){
		    	    echo 'shenhe-ing';
		    	    ?>">审核中</span><?php
		    	}
		    	if($requirement['ispublish'] == 3){
		    	    echo 'shenhe-ing';
		    	    ?>">审核失败</span><?php
		    	}    
	    	     ?>
	    	     
		    	</span>
		    	<span>距结束</span>
		    	<span id="d" style="display: none;">天</span><span id="h">小时</span><span id="m">分</span><span id="s" style="display:none;">秒</span></span><br>
		    	<span class="offer-details-name"><?php echo $requirement['contactuser'];?></span>
		    	<span class="offer-details-where"><?php echo $requirement['corporation']['corporation_name'];?></span>
		    	<!--  <span id="d" style="display: none;">天</span><span id="h">小时</span><span id="m">分</span><span id="s" style="display:none;">秒</span></span><br>
		    	<span class="offer-details-name"><?php // echo $requirement['contactuser'];?></span>
		    	<span class="offer-details-where"><?php // echo $requirement['corporation']['corporation_name'];?></span>-->
		    </li>
		</ul>
	   </div>
	</div>
	<!-- 倒计时 -->
	<!-- <div class="offer-details-time">
		<span class="icon-time"></span><span id="d">天</span><span id="h">小时</span><span id="m">分</span><span id="s">秒</span></span>
	</div> -->

	<!-- 内容 -->
	<div class="offer-details-main">
		<ul>
		    <li style="padding-top: 0;"><span>分类:<span style="opacity: 0;">测试</span></span><span class='offer-details-text01'><?php echo $requirement['cate']?></span></li>
		    <li><span>采购数量:</span><span class="offer-details-text01"><?php echo $requirement['p_count'];echo $requirement['unit'];?></span></li>
		    <li><span>期望价格:</span><span class="offer-details-text01"><?php echo $requirement['m_price']; ?>货豆/<?php echo $requirement['unit']; ?></span></li>
		    <li><span>需求总价:</span><span class="offer-details-text01"><?php echo $requirement['total_price']; ?>货豆</span></li>
		    <li><span>收货地:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo $requirement['address']; ?></span></li>
		    <li><span>收货日期:</span><span class="offer-details-text01"><?php echo substr ( $requirement['receiptdate'], 0,10); ?></span></li>
		    <li><span>报价须含:</span><span class="offer-details-text01">
		     <?php if($requirement['needtax'] != 0){ ?>税;
		    <?php }if($requirement['freight'] != 0){ ?>运费;
		    <?php   }if($requirement['needtax'] == 0 && $requirement['freight'] == 0){?> 
		        无
		   <?php }?> 
		    </span></li>
		</ul>
	</div>
	<div class="offer-details-num"><span>已报价<?php echo $requirement['total'];?>人</span></div>
	<div class="offer-details-main">
	    
		<ul class="offer-details-main-ul02">
		    <li style="padding-top: 0;"><span>报价人:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo empty($list['corporation']['corporation_name'])? '':$list['corporation']['corporation_name'].'&nbsp;';?><?php echo $list['contactuser']; ?></span></li>
		    <li><span>联系方式:</span><span class="offer-details-text01"><?php echo $list['mobile']; ?></span></li>
		    <li><span>联系邮箱:</span><span class="offer-details-text01"><?php echo $list['email']; ?></span></li>
		    <li><span>报价:<span style="opacity: 0;">测试</span></span><span class="offer-details-text01"><?php echo $list['offer']; ?>货豆/<?php echo $requirement['unit']; ?></span></li>
		    <li><span>交货期:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo $list['days']; ?>天</span></li>
		    <li><span>补充说明:</span><span class="offer-details-text01"><?php echo empty($list['remark']) ? '无':$list['remark']; ?></span></li>
		    <li><span>报价包含:</span><span class="offer-details-text01">
		    <?php if($list['needtax'] != 0){ ?>税;
		    <?php }if($list['freight'] != 0){ ?>运费;
		    <?php   }if($list['needtax'] == 0 && $list['freight'] == 0){?> 
		        无
		   <?php }?> 
		    </span></li>
		    <li>
		    <img height="80" width="80" style=" display: inline-block; margin-left: 80px;" src="<?php echo base_url(),'uploads/B/'.$list['accessory_url']?>" onerror ="this.src='images/default_img_s.jpg'">
		    </li>
		</ul>
	</div>

 	
 </div>	

<script type="text/javascript">
    function getRTime(){
         var dateTime = '<?php echo $requirement['effectdate']?>';
         dateTime = dateTime.replace(/-/g,"/");
         var EndTime = new Date(dateTime);
        var NowTime = new Date();
        var t =EndTime.getTime() - NowTime.getTime();
    

        var d=Math.floor(t/1000/60/60/24);
        var h=Math.floor(t/1000/60/60%24);
        var m=Math.floor(t/1000/60%60);
        var s=Math.floor(t/1000%60);

        document.getElementById("d").innerHTML = d + "天";
        document.getElementById("h").innerHTML = h + "时";
        document.getElementById("m").innerHTML = m + "分";
        document.getElementById("s").innerHTML = s + "秒";

    }
    setInterval(getRTime,1000);
</script>


