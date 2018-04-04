<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>我的存酒</title>
<base href="<?php echo THEMEURL.'app/'; ?>" />
<meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<?php if($app_type):?>
<script type="text/javascript" src="js/<?php echo $app_type;?>.js" ></script>
<?php endif;?>
</head>
<body>
	<div class="ui-produktdetail pd" id="list">
       <!-- <div class="ui-produktdetail-title">
            <div class="ui-produkt-btn clearfix">
            	<ul class="ui-produkt-btn-ul">
                	<li class="pos_rel">
                    	<a href="<?php echo site_url('save_app/getSaveList/'.$userid."/".$sessionid);?>">
                        <div class="red-ring-ordersnumber"><?php echo $count["saveqty"];?></div>
                        我的存酒
                        </a>
                    </li>
                    <li><a href="<?php echo site_url('save_app/getUseList/'.$userid."/".$sessionid);?>">
					<div class="red-ring-ordersnumber"><?php echo $count["useqty"];?></div>
					消费记录
					</a></li>
                    <li><a href="<?php echo site_url('save_app/getGiftList/'.$userid."/".$sessionid);?>">
					<div class="red-ring-ordersnumber"><?php echo $count["giftqty"];?></div>
					赠送记录</a></li>
                </ul>
       		</div>
       </div>-->
        <ul class="ui-produktdetail-ul">
		<?php foreach($list as $item){?>
			<a onclick="goDetail(<?php echo $item["quantity"];?>,'<?php echo $item["name"];?>','<?php if($item['goods_thumb'] != ""){ echo base_url('uploads/'.$item['goods_thumb']);}else{ echo "images/default_bg.gif";}?>','<?php echo $item["productid"];?>')">
        	<li class="border-rulur-top border-rulur-bottom clearfix pos_rel md10">
            	<div class="red-ring-winenumber"><?php echo $item["quantity"];?></div>
            	<img src="<?php if($item['goods_thumb'] != ""){ echo IMAGE_URL.'uploads/'.$item['goods_thumb'];}else{ echo "images/default_bg.gif";}?>" width="100" height="100" alt=""/>
            	<h3><?php echo $item["name"];?></h3>
                <div class="icon-arrow-right"><img src="images/arrowright.png" width="40" height="40" alt=""/></div>
            </li>
			</a>
        <?php }?> 
        <?php if(count($list)==0){?>
        	<div  class="mt50" style="width:100%; text-align:center;">
				<h1 style="margin-bottom:20px; font-size:16px;">您暂时没有存酒</h1>
				
	 </div>
        <?php }?>  
           
       	</ul>
       
    </div>


	<div class="ui-produktdetail pd"  style="display: none;" id="detail">
        <ul class="ui-produktdetail-ul">
        	<li class="border-rulur-top border-rulur-bottom clearfix pos_rel md20">
            	<div class="red-ring-winenumber" id="detail_total">0</div>
            	<img src="images/pic01.jpg" width="100" height="100" alt="" id="detail_img"/>
            	<h3 id="detail_name"></h3>
            </li>  
       	</ul>
       <div class="ui-produkt-btn">
       		<span class="left"><a href="" id="gift_href">赠&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;送</a></span>
      	 	<span class="right"><a onclick="comfirmDo()">消&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费</a></span>
       </div>
    </div>

	 <div  class="mt50" style="width:100%; text-align:center;display:none;" id="use">
				<h1 style="margin-bottom:20px; font-size:16px;">请联系客服<a href="callPhone|*|15967368922">15967368922</a></h1>
				<h1 style="font-size:16px;">我们将会有专业客服人员为您安排！</h1>
	 </div>
</body> 
</html>

<script>
function goDetail(total,name,img,id)
{
	$("#list").hide();
	$("#detail").show();
	$("#detail_total").html(total);
	$("#detail_name").html(name);
	$("#detail_img").attr("src",img);
	$('#gift_href').attr("href","#gift|*|"+id+"|*|"+total+"|*|"+name);

	goToDetail();

}

function comfirmDo()
{

	if(confirm("是否确认消费此商品？"))
	{
		$("#detail").hide();
		$('#use').show();
		goToDetail();
	}
	
}

function back()
{
	if($('#list').is(':hidden') && $('#detail').is(':hidden')){
		$('#use').hide();
		$('#detail').show();
	}else if($('#use').is(':hidden') && $('#list').is(':hidden'))
	{
		$('#list').show();
		$('#detail').hide();
	}
	
}
</script>
