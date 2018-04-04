<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>客户资料</title>
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
	<div class="padding34">
    	<form action="<?php echo site_url('save_app/customerdataforapp/'.$userid."/".$session);?>" method="post" name="search">
            <input name="username" type="text" value="<?php echo $username?>" placeholder="客户会员账号" id="searchkey" class="ui-search-bar"/>
            <div class="btn_search"><a onclick="javascript:document.search.submit()"><img src="images/icon_search.png" width="31" height="30" alt=""/></a></div>
        </form>    
    </div>
	<div class="ui-customer-data cd">
        <table width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
          <tr>
            <th width="10%">NO.</th>
            <th width="20%">会员账号</th>
            <th width="30%">消费金额</th>
            <th width="30%">分红金额</th>
			<th width="10%">分成推广</th>
			
          </tr>
		  <?php for($i=0;$i<count($result);$i++){?>
          <tr>
            <td width="10%"><?php echo $i+1?></td>
            <td width="20%"><font color="<?php echo $result[$i]['is_valid'] == 2?"2266ff":($result[$i]['is_valid'] == 1?"ff2200":"000000") ?>"><?php echo $result[$i]["name"]?></font></td>
            <td width="30%">￥<?php echo $result[$i]["total_price"]==null?0.00:$result[$i]["total_price"]?></td>
            <td width="30%">￥<?php echo $result[$i]["rebate"]==null?0.00:$result[$i]["rebate"]?></td>
			<td width="10%"><input type="text" class="text" size="3" name="rebate" value="<?php echo $result[$i]['parent_shared']?>" onchange="submitRebate(this.value,'<?php echo $result[$i]["id"]?>')"></td>
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
$(document).ready(function(){
	//focusblur
	jQuery.focusblur = function(focusid) {
		var focusblurid = $(focusid);
		var defval = focusblurid.val();
		focusblurid.focus(function(){
			var thisval = $(this).val();
			if(thisval==defval){
				$(this).val("");
			}
		});
		focusblurid.blur(function(){
			var thisval = $(this).val();
			if(thisval==""){
				$(this).val(defval);
			}
		});
		
	};
	/*下面是调用方法*/
	$.focusblur("#searchkey");
});

function submitRebate(val,id)
{
	
	$.post("<?php echo site_url('save_app/updateCustomerRebate')?>",{"userid":id,"rebate":val,"fuserid":'<?php echo $userid?>'},function(result){
    if(result == '"success"')
	{
		alert("修改成功！");
	}
	else if(result.indexOf("false_")>0)
	{

		alert("修改比率不能大于"+result.replace("false_","")+"%！");
	}else
	{
		alert("修改失败！");
	}
  });
	
}
</script>
</html>
