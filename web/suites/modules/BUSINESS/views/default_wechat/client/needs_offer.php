<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<style type="text/css">
	.container {background: #fff!important;}
	.webuploader-element-invisible {display: none;margin-top: 10px;}
	#demo {display: inline-block; width: 100%}
	#as { border-radius: 4px;margin-left: 75px;display: inline-block;float: right;}
	.needs-offer-button-text {float: right;}
	.parentFileBox {display: block;margin-bottom: 0px;text-align: center;margin:44px auto;}
	.parentFileBox li {display: inline-block;float: left;width: 190px;border-bottom: none!important;}
	.diyButton {display: inline-block;}
	.fileBoxUl{width: 190px;margin: 0px auto;}
	.fujian{ position: absolute; left: 10px;}
	.needs-offer-button-text{ position: absolute; right: 10px;}
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
    .h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
    .h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
    .forget-password {width: 265px;margin: 30px auto;text-align: center;}
    .password-text span {line-height: 30px;font-size: 16px;color: #333;}
    .password-text textarea { border: 1px solid #ddd; height: 60px; width: 90%;resize: none;outline: none;padding: 5px;}
    .password-button {height: 40px;width: 100%;background-color: #FECF0A;text-align: center;margin-top: 17px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}
    .no-mima {float: right;margin-top: 25px;color: #000000;}
    #textbeen {font-size:18px}
    @media screen and (max-width:320px) {
      .h5-forget {width: 270px!important;margin-left: -135px!important;}
      .password-button {width: 90%!important;}
      .no-mima {margin-right: 16px;}
      .publish-needs-input {width:50%!important;}
    }
   .diyStart{padding: 4px;background: #ffd600;border-radius: 4px;}
   .diyCancelAll{padding: 4px;background: #ffd600;border-radius: 4px;}
   .offer-details-name{padding-right:15px;display: inline-block;}
   .offer-details-where{padding-left:0px;padding-right:15px} 
   .offer-details-title {display: -webkit-box;overflow: hidden;text-align: left;height: 35px;line-height: 19px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
   .offer-details-tishi {padding:0;margin-left: 0px;}
   .publish-needs-input { width: 56%;float: none;text-align: left;}
   .offer-details-main02 {border-top: none;}
   .offer-details-main ul li:nth-child(1) {padding-top: 0;}
 .box_ball {display:none; position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,0.5);top: 0;}
   .reminder { 
   	display:none;
    background: #fff;
    padding: 25px 20px 20px 20px;
    position: fixed;
    top: 30%;
    left: 10%;
    width: 80%;
    margin: 0;}

	
	


</style>

<!-- <div class="commodity_h50"></div> -->
 <div class="offer_details">
	<!-- 头部 -->
	<div class="offer-details-header" style="border-bottom: 1px solid #ddd;">
		<div class="shop-information-header">
		<ul>
		    <li class="shop-information-tu offer-details-img"><img src="<?php echo base_url().'uploads/B/'.$requirement['img_path']; ?>" height="70" width="70" alt="" onerror="this.src='images/default_img_s.jpg'"></li>
		    <li>
		    	<span class="offer-details-title"><?php echo $requirement['title'];?></span>
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
		    	    echo 'shenhe-ing';
		    	    ?>">审核失败</span><?php
		    	}    
		    	
	    	     ?>
	    	     &nbsp;

	    	    <?php 
	    	    switch ($requirement['status']) {



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
	    	    }
	    	     if(!empty($requirement['contactuser'])){ ?>
		    	  <!--  <span class="offer-details-name"><?php echo $requirement['contactuser'];?></span> -->
		    	<?php }?>
		    	<?php if(!empty($requirement['corporation']['corporation_name'])){ ?>
		    	<!-- <span class="offer-details-where"><?php //echo $requirement['corporation']['corporation_name'];?></span> -->
		    	<?php }?>
		    </li>
		</ul>
	   </div>
	</div>

		


	<!-- 内容 -->
	<div class="offer-details-main">
		<ul>
		   <li><span>分类:<span style="opacity: 0;">测试</span></span><span class="offer-details-text01"><?php echo $requirement['cate']?></span><!-- <span class="offer-details-label"></span> --></li>
		    <li><span>采购数量:</span><span class="offer-details-text01"><?php echo $requirement['p_count'];echo $requirement['unit'];?></span></li>
		    <li><span>期望价格:</span><span class="offer-details-text01"><?php echo $requirement['m_price']; ?>货豆/<?php echo $requirement['unit']; ?></span></li>
		    <li><span>需求总价:</span><span class="offer-details-text01"><?php echo $requirement['total_price']; ?>货豆</span></li>
		    <li><span>收货地:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo $requirement['address']; ?></span></li>
		    <li><span>收货日期:</span><span class="offer-details-text01"><?php echo substr ( $requirement['receiptdate'], 0,10); ?></span></li>
		    <li><span>报价含:<span style="opacity: 0;">测</span></span><span class="offer-details-text01">
		     <?php if($requirement['needtax'] != 0){ ?>税; 
		    <?php }if($requirement['freight'] != 0){ ?> 运费;
		    <?php }if($requirement['needtax'] == 0 && $requirement['freight'] == 0){?>
		        无
		     <?php }?>      
		    </span></li>
		</ul>
	</div>
	<?php if(!$self){  if($barterlist){
	    if($requirement['total']>0){?>
	        <div class="offer-details-num"><span>已报价<?php echo $requirement['total']; ?>人</span></div>
	   <?php } ?>
	    
	    <div class="offer-details-main offer-details-main02">
		<ul class="offer-details-main-ul02">
		    <li><span>报价人:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo empty($barterlist['corporation']['corporation_name'])? '':$barterlist['corporation']['corporation_name'].'&nbsp;';?><?php echo $barterlist['contactuser']; ?></span></li>
		    <li><span>联系方式:</span><span class="offer-details-text01"><?php echo $barterlist['mobile']; ?></span></li>
		    <li><span>联系邮箱:</span><span class="offer-details-text01"><?php echo $barterlist['email']; ?></span></li>
		    <li><span>报价:<span style="opacity: 0;">测试</span></span><span class="offer-details-text01"><?php echo $barterlist['offer']; ?>货豆/<?php echo $requirement['unit']; ?></span></li>
		    <li><span>交货期:<span style="opacity: 0;">测</span></span><span class="offer-details-text01"><?php echo $barterlist['days']; ?>天</span></li>
		    <li><span>补充说明:</span><span class="offer-details-text01"><?php echo empty($barterlist['remark'])? '无':$barterlist['remark']; ?></span></li>
		    <li><span>报价含:<span style="opacity: 0;">测</span></span><span class="offer-details-text01">
		    <?php if($barterlist['needtax'] != 0){ ?>税; 
		    <?php }if($barterlist['freight'] != 0){ ?> 运费;
		     <?php }if($barterlist['needtax'] == 0 && $barterlist['freight'] == 0){?>
		        无
		     <?php }?>         
		    </span></li>
		     <li>
		    <img height="80" width="80" style=" display: inline-block; margin-left: 80px;" src="<?php echo base_url().'uploads/B/'.$barterlist['accessory_url']?>" onerror ="this.src='images/default_img_s.jpg'">
		    </li>
		</ul>
	</div>
	    
	<?php }else{?>
	<div style="padding: 10px;font-size: 14px;background: #F1F1F1;"><span>填写报价信息</span></div>
	<div class="publish-needs-main offer-details-main02">
		<ul class="offer-details-main-ul02 border-none">
		    <li><span>我的报价：</span><input type="text" value="" id="offer" class="publish-needs-input" style="margin-left: 5px;"><span class="fn-right">货豆/<?php echo $requirement['unit']; ?></span></li>
		     <li class="needs-offer-qita"><span>报价含（可不选）:</span>
				<a href="javascript:changeval(1);"><i class="icon-round icon-roundcheck"></i>运费</a>
				<a href="javascript:changeval(2);"><i class="icon-round icon-roundcheck"></i>税</a>
				<input type="hidden" value="0" id="freight"><input type="hidden" value="0" id="tax">
		    </li>
		    <li><span>交货期：<span style="opacity: 0;">测</span></span><input  id="days" type="text" value="" class="publish-needs-input" style="margin-left: -18px;"><span class="fn-right">天</span></li>
		    

		    <li><span class="fujian">产品图片:<span style="opacity: 0;">测试</span></span>
		        
                  <div id="demo">
                    <div id="as">
                    </div>
             </div>
                 
            </li> 
            <li><span>补充说明（可不填）:</span><input type="text" value="" placeholder="请输入说明内容" id="remark" class="publish-needs-input" style="margin-left: 20px;font-size: 14px;"></li>
		   		    </li>
		   	<li style="border-bottom: none;"> <span class="needs-offer-button-text" style="width: 100%;text-align: right;color:#F19923;">可上传产品,公司资质证书或产品图片,提升报价品质</span></li>	    

		</ul>
	</div>

	<div class="maintenance-label-bt">
      <a href="javascript:addbartesub();" class="maintenance-label-confirm">确定报价</a>
    </div>
<?php } }?>
    
   
<!-- 弹窗 -->
    <div class="box_ball"></div>
       <div class="reminder">
        <div class="password-text">
         <span id="success-text">抱歉，您需申请成为商家用户才能查看需求信息，有疑问请联系平台客服</span>
        </div>
        <a href="<?php echo site_url('home');?>" class = "password-button">取消</a> <a href='tel:4000029777' class = "password-button">拨打客服</a>
       </div>

 	
 </div>	

 <script type="text/javascript">
$(".needs-offer-button").on("click",function(){
$(".ball-header-status-li").css("display","block");
})

$(".needs-offer-qita a").on("click",function(){
  $(this).addClass("on").siblings().removeClass("on");
  $(this).find("i").toggleClass('icon-round');
  $(this).find("i").toggleClass('needs-offer-qita-active');
  })

$('#been').on('click',function(){
	$(".been").css("display","none");
})  
$('#success').on('click',function(){
	$(".success").css("display","none");
})  
 </script>

 <script type="text/javascript">  

function back(){
	window.history.go(-1);
} 

function changeval(v){
	if(v == 1){
		var freight = document.getElementById("freight");
		if(freight.value ==1){
			freight.value = 0;
		}else{
			freight.value = 1;
			}
		}
	if(v == 2){
		var tax = document.getElementById("tax");
		if(tax.value ==1){
			tax.value = 0;
			}else{
				tax.value = 1;
				}
	}
	
}

/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/
var img_path = '';
$('#as').diyUpload({
	url:'<?php echo site_url("member/requirement/images_upload_batch") ?>',//corporate/demand/upload_file
	success:function( data ) {
		$(".webuploader-element-invisible").attr("disabled",'true');
		console.info( data );
		img_path = data.img_path;
	},
	error:function( err ) {
		console.info( err );	
	},
	buttonText : '选择上传图片',
	chunked:true,
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:3,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:2097152,
	accept: {}
});


function addbartesub(){
	var status = false;
    $.ajax({
    	url:'<?php echo site_url('member/requirement/Timeout') ?>',
    	dataType:'json',
	    type:'get',
	    async: false,
	    data:{ id:<?php echo $requirement['id']?>},
	    success:function(data){
		    	if(data['Result']){
		    		status = true;
			    	}else{
						 $(".black_feds").text("报价已截止!！").show();
							setTimeout("prompt();", 2000);
					     	return;
				    	}
		    },
	    error:function(){
	    	$(".black_feds").text("网络错误，请重试!").show();
			setTimeout("prompt();", 2000);
    		return;
		    }
        }); 
	if(status){
		var requirement_id = <?php echo $requirement['id']?>;
		var offer = document.getElementById("offer").value;
		var days = document.getElementById("days").value;
		var remark = document.getElementById("remark").value;
		var freight = document.getElementById("freight").value;
		var tax = document.getElementById("tax").value;
		
		if(isNaN(offer) || offer<=0){
			 $(".black_feds").text("请填写正确的报价！").show();
				setTimeout("prompt();", 2000);
		     	return;
			}
		var r= /^[+-]?[1-9]?[0-9]*\.[0-9]*$/;
		if(r.test(offer)){
			if(offer.toString().split(".")[1].length >2){
				 $(".black_feds").text("报价只允许保存到小数点后两位！").show();
					setTimeout("prompt();", 2000);
			     	return;
				}
			}
		if(isNaN(days) || days<=0){
			 $(".black_feds").text("请填写正确的交货天数！").show();
				setTimeout("prompt();", 2000);
		     	return;
			}
		if(img_path == ''){
			$(".black_feds").text("请填上传产品图片！").show();
			setTimeout("prompt();", 2000);
	     	return;
			}
		$.ajax({
			url:'<?php echo site_url('member/requirement/ajax_addbarter') ?>',
			dataType:'json',
		    type:'post',
		    data:{ requirement_id:requirement_id,offer:offer,days:days,remark:remark,tax:tax,freight:freight,img_url:img_path
		    },
		    success:function(data){
			    if(data['Corp_Status']){
			    	if(data['Result']){
			    		 if(data['Status']){
			    			 $(".black_feds").text("您的报价已提交成功!").show();
			    			 setTimeout("prompt();", 2000);
			    			 setTimeout(function(){
			    				 window.location.href="<?php echo site_url("Member/requirement");?>";
				    			 }, 1000);
				    		 }else{
				    			 $(".black_feds").text("您已经报价过该需求了!!").show();
				    				setTimeout("prompt();", 2000);
				    	    		return;
					    		 }
				    	}else{
		    			 $(".black_feds").text("报价失败，请重试!!").show();
		    				setTimeout("prompt();", 2000);
		    	    		return;
					    }
				    }else{//抱歉，您需申请成为商家用户才能查看需求信息，有疑问请联系平台客服
				    	$(".box_ball").show(); 
				    	$(".reminder").show();
					    }
			    },
			error:function(){
				 $(".black_feds").text("网络错误，请重试!").show();
	 				setTimeout("prompt();", 2000);
	 	    		return;
				}   
	        });

		
		}
	
	
}
</script>  

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
        <?php 
        $nowtime = time();
        $time = strtotime($requirement['effectdate']);
        if($time > $nowtime){
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
    	    	     <?php        ;
    	    	            break;
    	    	    }
        }else{?>
            document.getElementById("d").innerHTML = "0天";
            document.getElementById("h").innerHTML = "0时";
            document.getElementById("m").innerHTML = "0分";
            document.getElementById("s").innerHTML = "0秒";
		<?php }?>	
    }
    setInterval(getRTime,1000);
</script>












