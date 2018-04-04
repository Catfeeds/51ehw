<!DOCTYPE html>
<html>
<head>
    <title>客户资料</title>
    <base href="<?php echo THEMEURL; ?>" />
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/public.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="css/cart.css" rel="stylesheet" type="text/css"/>
    <link href="css/member.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
    <link href="css/.css" rel="stylesheet" type="text/css"/>
    <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
	<script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
	<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
	
</head>
<body>
<!-- head-top S -->
<?php $this->load->view('_header');?>
<!-- head-top E -->
<div class="ui-bd w980">
    <div class="ui-crumb">你所在的位置：
        <a href="<?php echo site_url('customer');?>">个人中心</a> ＞

        <span>客户资料</span>
    </div>
    <div class="fn-clear m-top10">
        <?php $this->load->view('customer/leftmenu');?>
        <!--中心内容 S-->
        <div class="ui-main-right fn-right">
            <div class="ui-member-title">
                <h3>客户资料</h3>
            </div>

            <div class="ui-member-box">
               <!--2014-01-07增加 S-->
			   <form name="customersearch" method="post" action="<?php echo site_url('customer/customerdata/'.$level."/".$fid);?>">
                <div class="ui-button-caption fn-clear">
                    <div class="ui-form-width">
                        <span>客户注册日期：</span>
                        <input type="text" class="text4" name="begindate" value="<?php echo $begindate;?>" onClick="WdatePicker()" readonly>
                        <span class="ui-margin-left">至</span>
                        <input  type="text" class="text4" name="enddate" value="<?php echo $enddate?>" onClick="WdatePicker()" readonly>

                    </div>
                    <div class="ui-caption-mtop ui-form-width">
                        <span>客户会员账号：</span>
                        <input class="text" name="username" type="text" value="<?php echo $username?>">
                        <span class="ui-margin-left">客户联系电话：</span>
                        <input class="text" name="phone" type="text" value="<?php echo $phone;?>">
                        <span class="ui-margin-left"></span>
                        <input type="submit" name="btnSelect" value="查 询" class="ui-button-inquiry">

                    </div>
                </div>
			    </form>
                <!--2014-01-07增加 E-->
                <div class="ui-tit-table">
                    <table>

                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>会员账号</th>
                                <th>注册日期</th>
                                <!--<th>登陆次数</th>-->
                                <th>消费金额</th>
                                <th>分红金额</th>
                                <!--<th>是否有客户</th>-->
                                <th>分成推广</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php if($result && count($result>0)){ 
								foreach($result as $key=>$c)
							{
								?>
                            <tr>
                                <td><?php echo ($key+1);?></td>
                                <td>
								<font color="<?php echo $c['is_valid'] == 2?"2266ff":($c['is_valid'] == 1?"ff2200":"000000") ?>">
									<?php echo $c["name"];?>
                                </font>
                                </td>
                                <!--<td><?php echo $c["id"];?></td>-->
                                <td><?php echo $c["registry_at"];?></td>
                                <!--<td> <?php echo $c["login_count"]?>次 </td>-->
                                <td>￥ <?php echo $c["total_price"]==null? "0.00":  $c["total_price"];?></td>
                                <td>￥ <?php echo $c["rebate"]==null?"0.00":$c["rebate"];?> </td>
                                <!--<td><strong class=""><?php if($c["childid"] && $c["childid"]>0){?><a href="<?php echo site_url("customer/customerdata/".($level+1)."/".$c["id"])?>">是</a><?php }else{?>否<?php }?></strong></td>-->
                                <td><input name="shared" type="text" maxlength="2" size="2" value="<?php echo $c["parent_shared"];?>" onchange="submitRebate(this.value,'<?php echo $c["id"]?>')">%</td>
                            </tr>
                            <?php }}else{?>
							<tr>
                                <td colspan="9">暂无下级记录</td>
                            </tr>
							<?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>
<script>
function submitRebate(val,id)
{
	
	$.post("<?php echo site_url('customer/updateCustomerRebate')?>",{"userid":id,"rebate":val},function(result){
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
