<style type="text/css">
	.container {background: #fff!important;}
   .offer-details-where{padding-left:0px;padding-right:15px} 
   .offer-details-title {
    display: -webkit-box;
    overflow: hidden;
    text-align: left;
    height: 35px;
    line-height: 19px;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.offer-details-tishi {padding: 0;margin-left: 0px;}
.offer-details-name {padding-right: 15px;display: inline-block;}
.offer-details-main ul li:nth-child(1) {padding-top: 0;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- <div class="commodity_h50"></div> -->
 <div class="offer_details">
	<!-- 头部 -->
	<div class="offer-details-header" style="border-bottom: 1px solid #ddd;">
		<div class="shop-information-header">
		<ul>
		    <li class="shop-information-tu offer-details-img"><img src="<?php echo  base_url(),'uploads/B/'.$requirement['img_path'];?>" height="70" width="70" alt="" onerror="this.src='images/default_img_s.jpg'"></li>
		    <li>
		    	<span class="offer-details-title"><?php echo  $requirement['title'];?></span>
		    	<span class="offer-details-tishi 
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
		    	    echo 'shenhe-close';
		    	    ?>">审核不通过</span><?php
		    	}    
	    	     ?>
	    	    &nbsp;
	    	    <?php 
	    	    if($requirement['ispublish'] == 1 || $requirement['ispublish'] == 3){?>

	    	         <span></span><br>
	    	     <?php  }else{
	    	    switch ($requirement['status']) {
	    	        case 0: ?>
	    	         <span>已结束</span><br>
	    	     <?php   
	    	        break;
	    	        case 1: ?>
	    	       <span id="m">分</span><span id="s" >秒</span><br>
	    	     <?php    ;
	    	        break;
	    	        case 2:?>
	    	         <span id="h">小时</span><span id="m">分</span><br>
	    	     <?php        ;
	    	        break;
	    	        case 3:?>
	    	        <span>距结束</span>
	    	        <span id="d">天</span><span id="h">小时</span><br>
	    	     <?php        ;
	    	            break;
	    	     } }
		    	 if(!empty($requirement['contactuser'])){ ?>
		    	   <!--  <span class="offer-details-name"><?php echo $requirement['contactuser'];?></span> -->
		    	<?php }?>
		    	<?php if(!empty($requirement['corporation']['corporation_name'])){ ?>
		    	 <!--<span class="offer-details-where"><?php echo $requirement['corporation']['corporation_name'];?></span> -->
		    	<?php }?>
		    </li>
		</ul>
	   </div>
	</div>

		
	<!-- 内容 -->
	<div class="offer-details-main">
		<ul>
		    <li><span>分类:<span style="opacity: 0;">测试</span></span><span class="offer-details-text01"><?php echo $requirement['cate'];?></span><!-- <span class="offer-details-label"></span> --> </li>
		    <li><span>采购数量:</span><span class="offer-details-text01"><?php echo $requirement['p_count'];echo $requirement['unit'];?></span></li>
		    <li><span>期望价格:</span><span class="offer-details-text01"><?php echo  $requirement['m_price'];?>货豆/<?php echo  $requirement['unit'];?></span></li>
		     <li><span>需求总价:</span><span class="offer-details-text01"><?php echo $requirement['total_price']; ?>货豆</span></li>
		    <li><span>收货地:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo  $requirement['address'];?></span></li>
		    <li><span>收货日期:</span><span class="offer-details-text01"><?php echo  substr ( $requirement['receiptdate'], 0,10);?></span></li>
		    <li><span>报价须含:</span><span class="offer-details-text01">
		    <?php if($requirement['needtax'] != 0){ ?>税;
		    <?php }if($requirement['freight'] != 0){ ?>运费;
		    <?php   }if($requirement['needtax'] == 0 && $requirement['freight'] == 0){?> 
		        无
		   <?php }?> 
		          
		    </span></li>
		</ul>
		<?php 
		if($requirement['ispublish'] == 2){//审核通过
		    if($requirement['status'] == 0){//已过期?>
		        <a href="javascript:void(0);" style="background: #9e9d99;" class="offer-details-confirm custom_button">上架</a>
		 <?php    }else{ ?> 
		     <a href="javascript:putaway();" class="offer-details-confirm"><?php if($requirement['is_putaway'] == 0){?>上架<?php }else{?>下架<?php } ?></a>
		<?php } }
		if($requirement['ispublish'] == 3){//审核失败?>
		 <a href="<?php echo site_url('member/requirement/editrequirements?id='.$requirement['id'])?>" class="offer-details-confirm custom_button">重新编辑</a>
		<?php }?>
	</div>
	<?php if($requirement['total']>0){  ?>
	    <div class="offer-details-num"><span>已报价<?php echo $requirement['total']; ?>人</span></div>
	<?php }?>
	    <!--需求信息结束-->
		<div class="offer-details-main offer-details-main02" id="main">
    	<ul class="offer-details-main-ul02 list" hidden>
    	</ul>
	</div>
 </div>	

<script type="text/javascript">
//下拉加载数据
var page = 1;
var id = <?php echo $requirement['id']?>;
dropload = $('#main').dropload({
	scrollArea : window,
	loadDownFn : function(me){
		 $.post("<?php echo site_url("Member/requirement/ajax_barter_list");?>",{page:page,id:id},function(data){ 
			 if(data.list.length>0){
				 var p_count = <?php echo $requirement['p_count'];?> ;
				 var result= '';
				 var errorimg = "this.src='images/default_img_s.jpg'";

				 for(var i=0;i<data.list.length;i++){
					 var img = '<?php echo base_url()."uploads/B/"?>'+data.list[i]['accessory_url'];
					 if(page == 1){
						 if( i!=0){
							 result += '<hr style="border: 5px solid #f4f4f4;">';
							 }
						 }
					 result += '<li><span>报价人:<span style="opacity: 0;">测</span></span><span class="offer-details-text01">';
					 if(data.list[i]['corporation']['corporation_name'] == ''){
						 result += data.list[i]['contactuser']+'</span></li>';
						 }else{
							 result += data.list[i]['corporation']['corporation_name']+'&nbsp;'+data.list[i]['contactuser']+'</span></li>';
							 }
					 result += '<li><span>联系方式:</span><span class="offer-details-text01">'+data.list[i]['mobile']+'</span></li>';
					 result += '<li><span>联系邮箱:</span><span class="offer-details-text01">'+data.list[i]['email']+'</span></li>';
					 result += '<li><span>报价:<span style="opacity: 0;">测试</span></span><span class="offer-details-text01">'+data.list[i]['offer']+'货豆/<?php echo $requirement['unit']; ?></span></li>';
					 result += '<li><span>交货期:<span style="opacity: 0;">测</span></span><span class="offer-details-text01">'+data.list[i]['days']+'天</span></li>';
					 if(data.list[i]['remark']){
						result += '<li><span>补充说明:</span><span class="offer-details-text01">'+data.list[i]['remark']+'</span></li>';
						}else{
							result += '<li><span>补充说明:</span><span class="offer-details-text01">无</span></li>';
						}			
					 result += '<li><span>报价包含:</span><span class="offer-details-text01">';
					 if(data.list[i]['needtax'] != 0){
						 result += '税;';
							 }
					 if(data.list[i]['freight'] != 0){
						 result += '运费;';
							 }
					 if(data.list[i]['needtax'] == 0 && data.list[i]['freight'] == 0){
						 result += '无';
						 }
					 result += '</span></li>';
					 result += '<li>';
					 result += '<img height="80" width="80" style=" display: inline-block; margin-left: 80px;" src="'+img+'" onerror ='+errorimg+'>';
					 result += '</li>';    
					
					}
				 $('#main').find('.list').append(result);
				 $('#main').find('.list').show();
				 page++;
	             me.resetload();
					
				 }else{
					 if(page == 1){
							// 锁定
		 	                me.lock();
		 	                // 无数据
		 	                me.noData();
		 	                me.resetload();
		 	                <?php
		 	               if($requirement['ispublish'] == 2){
			 	            	  if($requirement['is_putaway'] == 1){
			 	           ?>
				 	          $(".dropload-noData").html("还没有人报价哦！");
				 	       <?php }else{?>
					 	      $(".dropload-noData").hide();
					 	   <?php } }else{?>
					 	      $(".dropload-noData").hide();
				 	       <?php } ?>
		 	               
						 }else{
								// 锁定
			 	                me.lock();
			 	                // 无数据
			 	                me.noData();
			 	                me.resetload();
			 	                $(".dropload-noData").html("暂无更多报价信息");
							 }
					 }
			 },"json");
        	}
        });

	function putaway(){
		$.ajax({
			url:'<?php echo site_url("member/requirement/putaway") ?>',
		    dataType:'json',
		    type:'get',
		    data:{ id:<?php echo $requirement['id'];?>,status:<?php echo $requirement['is_putaway'];?>
		    },
		    success:function(data){
		    	 if(data['Result']){
		    		 if(data['status'] == 1){
		    			    $(".black_feds").text("上架成功!").show();
		    				setTimeout("prompt();", 2000);
		    				setTimeout(function(){
		    					window.location.reload();
			    				},1000);
					    }
					 if(data['status'] == 0){
						 	$(".black_feds").text("下架成功!!").show();
		    				setTimeout("prompt();", 2000);
		    				setTimeout(function(){
		    					window.location.reload();
			    				},1000);
						}
			      }else{
			    	  if(data['status'] == 1){
			    		    $(".black_feds").text("上架失败，请重试!").show();
		    				setTimeout("prompt();", 2000);
		    			 	
					    }
			    	  if(data['status'] == 0){
			    		    $(".black_feds").text("下架失败，请重试!").show();
		    				setTimeout("prompt();", 2000);
						    }
				    	 }
			    },
			error:function(){
				$(".black_feds").text("网络错误，请重试!").show();
				setTimeout("prompt();", 2000);
				}   
			})
		
		}
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
        <?php 
        switch ($requirement['status']) {
        case 1: ?>
        document.getElementById("m").innerHTML = m + "分";
        document.getElementById("s").innerHTML = s + "秒";
        <?php    ;
        break;
        case 2:?>
        document.getElementById("h").innerHTML = h + "时";
        document.getElementById("m").innerHTML = m + "分";
        <?php        ;
        break;
        case 3:?>
        document.getElementById("d").innerHTML = d + "天";
        document.getElementById("h").innerHTML = h + "时";
        <?php ;
            break;
        }?>
    }
    setInterval(getRTime,1000);
</script>


