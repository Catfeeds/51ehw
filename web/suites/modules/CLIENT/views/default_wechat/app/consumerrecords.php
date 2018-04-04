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
</head>
<body>
	<!--<div class="ui-produktdetail pd">
        <div class="ui-produktdetail-title m0a">
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
       </div>
       </div>-->
       <div class="ui-customer-data cd">
        <table width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
          <tr>
            <th width="40%">消费商品</th>
            <!--<th width="40%">消费地址</th>-->
            <th width="30%">消费数量</th>
            <th width="30%">时间</th>
          </tr>
          <?php foreach($list as $item){?>
          <tr>
            <td width="40%"><?php echo $item["name"];?></td>
            <!--<td width="40%"><?php echo $item["username"];?></td>-->
            <td width="30%"><?php echo $item["quantity"];?></td>
            <td width="30%"><?php echo $item["transferdate"];?></td>
          </tr>
         <?php }?>
          
       </table>
    </div>
    
</body> 
<script language="javascript">
$(document).ready(function(){ //这个就是传说的ready   
	$(".stripe tr").mouseover(function(){   
	   //如果鼠标移到class为stripe的表格的tr上时，执行函数   
	  $(this).addClass("over");}).mouseout(function(){   
			//给这行添加class值为over，并且当鼠标一出该行时执行函数   
			$(this).removeClass("over");}) //移除该行的class   
  $(".stripe tr:even").addClass("alt");   
	//给class为stripe的表格的偶数行添加class值为alt
  });   
</script>  
<script type="text/javascript">
</html>
