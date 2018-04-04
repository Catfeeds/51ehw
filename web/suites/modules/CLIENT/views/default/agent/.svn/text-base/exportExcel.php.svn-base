<!-- 合伙人报表生成excel -->
<?php
header("Content-Type:text/html; charset=utf-8");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: text/xml");
header("Content-Type: application/force-download");
header("Content-Type: application/download");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");

$sale_type = ""; // 类型
$sub_total = 0; // 合计
$sub_rebate_1 = 0; // 分成
$sub_rebate = 0; // 合伙人分成
$total_price = 0;   //成交金额
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<base href="<?php echo THEMEURL; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="images/favicon.png">

<title></title>
</head>
<body>
	<table width="1200" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="table">
		<tbody>
<?php
if (isset($type) ? $type : '') {
    ?>
			<tr class="manage_b_table2">
				<th width="150">订单号</th>
				<th width="150px">商家名称</th>
				<th width="100px">时间</th>
				<th width="100px">分成类别</th>
				<th width="100px">成交金额</th>
				<th width="100px">可分成金额</th>
				<th width="100px">上线会员名称</th>
				<th width="100px">上线分成</th>
				<th width="100px">合伙人名称</th>
				<th width="100px">合伙人分成</th>
			</tr>
<?php
    if (count($content) > 0) :
        foreach ($content as $key => $v) :
            if ($v["rebate_type"] == 2)
                $sale_type = "销售分成";
            elseif ($v["rebate_type"] == 1)
                $sale_type = "会员分成";
            ?>
            <tr>
				<th width="150px">'<?php echo $v["order_sn"]?></th>
				<th width="150px"><?php echo $v["corporation_name"]?></th>
				<th width="100px"><?php echo $v["creat"]?></th>
				<th width="100px"><?php echo $sale_type?></th>
				<th width="100px"><?php echo $v["total_price"]?></th>
				<th width="100px"><?php echo $v["total"]?></th>
				<th width="100px"><?php echo $v["parent"]?></th>
				<th width="100px"><?php echo $v["rebate_1"]?></th>
				<th width="100px"><?php echo $v["nick_name"]?></th>
				<th width="100px"><?php echo $v["rebate"]?></th>
			</tr>
<?php
	        $sub_total += $v["total"];
	        $sub_rebate += $v["rebate"];
	        $sub_rebate_1 += $v["rebate_1"];
    	    $total_price += $v["total_price"];
        endforeach
        ;
     else :
        ?>
        	<tr>
				<th>暂无分成</th>
			</tr>
    <?php
    endif;
    $sub_total = $sub_total != null ? $sub_total : 0;
    $sub_rebate_1 = $sub_rebate_1 != null ? $sub_rebate_1 : 0;
    $sub_rebate = $sub_rebate != null ? $sub_rebate : 0;
    ?>
        	<tr class="manage_b_table2">
				<th width="150px">合计</th>
				<th width="150px"></th>
				<th width="100px"></th>
				<th width="100px"></th>
				<th width="100px"><?php echo isset($total_price)?$total_price:''; ?></th>
				<th width="100px"><?php echo isset($sub_total)?$sub_total:''; ?></th>
				<th width="100px"></th>
				<th width="100px"><?php echo isset($sub_rebate_1)?$sub_rebate_1:''; ?></th>
				<th width="100px"></th>
				<th width="100px"><?php echo isset($sub_rebate)?$sub_rebate:''; ?></th>
			</tr>
		</tbody>
	</table>
<?php
} else {
    ?>
        	<tr class="manage_b_table2">
        		<th width="150">商家名称</th>
        		<th width="100px">分成类别</th>
        		<th width="100px">提供分成总金额</th>
        		<th width="100px">上线会员名称</th>
        		<th width="100px">上线会员分成</th>
        		<th width="100px">合伙人名称</th>
        		<th width="100px">合伙人分成</th>
        	</tr>
<?php
    if (count($content) > 0) :
        foreach ($content as $key => $v) :
            if ($v["rebate_type"] == 2)
                $sale_type = "销售分成";
            elseif ($v["rebate_type"] == 1)
                $sale_type = "会员分成";
            ?>
        	<tr>
        		<th width="100px"><?php echo $v["corporation_name"]?></th>
        		<th width="100px"><?php echo $sale_type?></th>
        		<th width="100px"><?php echo $v["total"]?></th>
        		<th width="100px"><?php echo $v["parent"]?></th>
        		<th width="100px"><?php echo $v["rebate_1"]?></th>
        		<th width="100px"><?php echo $v["nick_name"]?></th>
        		<th width="100px"><?php echo $v["rebate"]?></th>
        	</tr>
<?php
    	    $sub_total += $v["total"];
    	    $sub_rebate += $v["rebate"];
    	    $sub_rebate_1 += $v["rebate_1"];
        endforeach
        ;
     else :
        ?>
        	<tr>
        		<th>暂无分成</th>
        	</tr>

    
    <?php
endif;
    $sub_total = $sub_total != null ? $sub_total : 0;
    $sub_rebate_1 = $sub_rebate_1 != null ? $sub_rebate_1 : 0;
    $sub_rebate = $sub_rebate != null ? $sub_rebate : 0;
    ?>
        	<tr class="manage_b_table2">
        		<th width="100px">合计</th>
        		<th width="100px"></th>
        		<th width="100px"><?php echo isset($sub_total)?$sub_total:''; ?></th>
        		<th width="100px"></th>
        		<th width="100px"><?php echo isset($sub_rebate_1)?$sub_rebate_1:''; ?></th>
        		<th width="100px"></th>
        		<th width="100px"><?php echo isset($sub_rebate)?$sub_rebate:''; ?></th>
        	</tr>
    	</tbody>
	</table>
    <?php
}
?>
</body>
</html>