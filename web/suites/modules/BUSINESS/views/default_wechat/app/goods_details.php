<!DOCTYPE html>
<script type="text/javascript"> base_url="<?php echo site_url();?>";</script>
<html lang="en">
<head>
<base href="<?php echo THEMEURL.'app/'; ?>" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<meta name="MobileOptimized" content="640">
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="format-detection" content="telephone=no" />
<title></title>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/swiper3.08.min.css">
<link rel="stylesheet" type="text/css" href="../css/fonts.css">
<link rel="stylesheet" type="text/css" href="css/fonts.css">
<link rel="stylesheet" type="text/css" href="css/iconfont2.css">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/swiper3.08.jquery.min.js"></script>
<script type="text/javascript" src="js/TouchSlide.1.1.js"></script>
</head>
<?php 
//识别是否是特价商品 
$special_price_item = false;
?>
<body>
	<div class="container">
        <div class="clearfix">
            <div class="swiper-container">
				<div class="swiper-wrapper">
                    <?php
                    $imgurl = "";
                    if (isset($gallery) && count($gallery) > 0) {
                        foreach ($gallery as $image) {
                            if ($image["is_base"] != 1) {} else {
                                $imgurl = $image['file'];
                            }
                            ?>
                    <div class="swiper-slide maximg_480">
						<img src="<?php echo IMAGE_URL.$image['file'];?>" alt="<?php echo $image['image_name'];?>" onerror="this.src='images/default_img_b.jpg'">
					</div>
					<?php
                        }
                    } else {
                        ?>
                    <div class="swiper-slide maximg_480">
						<img src="images/default_img_b.jpg" alt="51ehw" onerror="this.src='images/default_img_b.jpg'">
					</div>
                    <?php
                    }
                    ?>
                </div>
				<!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div><!--swiper-container end-->

			<div class="product">
				<h1><?php echo $details['name'];?></h1>
				<h2><?php echo $details['short_desc'];?></h2>
				<div style="float: right;">
                <?php if($details['latitude'] && $details['longitude'] && $city!=''){?>
                    <a href="javascript:latitude('<?php echo $details['latitude'];?>','<?php echo $details['longitude'];?>','<?php echo $details["address"] ?>');" style="float: left; color: #999999; font-size: 15px; margin-top: 0px;" class="icon-dingwei1">
						<span style="color: #999999; font-size: 15px;"><?php //echo $city?>导航</span>
					</a>
                <?php }else{?>
                <?php }?>
                </div>
				<input type="hidden" name="product_id" value="<?php echo $details['id'];?>">
				<input type="hidden" name="payment_id" value="2">
				<lable class="item" id="special_price_item" style="display:none;">
    				特<em style="opacity: 0;">隐藏</em>价:&nbsp;&nbsp;
    				<span style="font-size: 15px; font-weight: bold; color: red;" id="special_price"> <?php echo number_format($details['special_price'],2); ?>  </span>
				</lable>
				<lable class="item" id="product_price_item">
					易&nbsp;&nbsp;货&nbsp;&nbsp;价:&nbsp;&nbsp;
					<span class="red" id="product_price" style="color: #333333; font-size: 15px; font-weight: bold;"> <?php echo $details['vip_price'] == 0 ? "0":number_format($details['vip_price'], 2);?> </span>
				</lable>
				<?php if($details['market_price']){;?>
                <lable class="item" id="product_price_item">参考价<em style="opacity: 0;">&nbsp;&nbsp;&nbsp;</em>
                    <span class="red" id="product_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 5px;">
    					<?php echo $details['market_price'];?> 
                    </span>
                </lable>
                <?php };?>      
				<div class="line"></div>
				<lable class="item">库存: <span id="product_stock"><?php echo number_format($details['stock']);?>件</span>
				</lable>
				<div id="sku"></div>
				<input type="hidden" name="val_id" id="val_id" value="0" />
				<div class="line"></div>
				<lable class="item">数<em style="opacity: 0;">隐藏</em>量:</lable>
				<span class="add-del">
					<a href="javascript:jQuery.reduce('#item_num');" class="btn-del num_oper num_min">
						<span>－</span>
					</a>
					<input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1" onblur="jQuery.modify('#item_num');" onkeyup="jQuery.finishing('#item_num');"/>
					<a href="javascript:jQuery.add('#item_num')" class="btn-add num_oper num_plus">
						<span>+</span>
					</a>
					<input id="item_amount" type="hidden" value="<?php echo $details['stock'];?>" />
				</span>
				<!-- 小计 -->
				<lable class="item">小<em style="opacity: 0;">隐藏</em>计: &nbsp;&nbsp;
					<span class="red" id="total_price" style="color: #333333; font-size: 15px; font-weight: bold;"> <?php echo $details['vip_price'] == 0 ? "0":number_format($details['vip_price'], 2);?> </span>
				</lable>
				<p class="caution_tips" id="item-error" style="display: none;"></p>
				<!-- 运费 -->
				<lable class="item">运<em style="opacity: 0;">测试</em>费: &nbsp;&nbsp;<span class="red" id="freight" style="color: #333333;font-size: 15px;margin-left: 3px;"><?php echo $details['is_freight'] ? $details['default_freight'].' ' : '免运费'?></span></lable>


				  <!-- 店铺名 -->
                <div class="shop-name" style="border-top: none;">
                    <div class="shop-name-main" style="display:none;">
                    	<a href="javascript:enterCorporation();">
                            <span class="icon-shop shop-icon"> </span>
                            <span class="shop-name-text"><?php echo isset($corporate['corporation_name'])?$corporate['corporation_name']:"&nbsp;";?></span>
                            <span class="shop-name-into">进入店铺<span class="icon-right"></span></span>
                        </a>
                    </div>
                </div>


                <!-- 商品详情 猜你喜欢 导航 -->
                <div class="goods-live-nav">
                    <ul>
                        <li class="active-line">商品详情</li>
                       <!--  <li>猜你喜欢</li> -->
                    </ul>
                </div>

				<lable class="item">参数:</lable>
				<ul class="item-ifo">
					<li><?php foreach($product_attr_values as $v): ?>
                			<?php if($v['attr_type']!='related' && $v['attr_type']!='sku'):?>
					
					<li><?php echo $v['attr_name']?>：<?php echo $v['attr_value']?></li>
							<?php endif;?>
            			<?php endforeach; ?>
                </ul>
				<div class="line"></div>
				<lable class="item">描述:</lable>
				  <div><?php echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.IMAGE_URL,$details['desc']);?></div>
			</div>
			<!--product end-->
		</div>
		<!--page end-->
    </div>

<!-- 定时消失黑色框提示 -->
<span class="black_feds" style="z-index: 999;"></span>
<script>
/**
 * 提示框隐藏js事件
 */
function prompt(){
	$(".black_feds").hide();
}
</script>

<script>
    //数量、套餐切换
    TouchSlide({
        slideCell: "#leftTabBox"
    });
</script>
    
<script>
    //广告图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });
</script>

<script>
//商品数量操作开始
jQuery.extend( {
    min : 1,  
    reg : function(x) {  
        jQuery('#item-error').html("");  
        jQuery('#item-error').hide();  
        return new RegExp("^[1-9]\\d*$").test(x);  
    },  
    amount : function(obj, mode) {  
        var x = jQuery(obj).val();  
        if (this.reg(parseInt(x))) {  
            if (mode) {  
                x++;  
            } else {  
                x--;  
            }
        } else {
			$(".black_feds").text("请输入正确的数量").show();
	    	setTimeout("prompt();", 2000); 
            jQuery(obj).val(1); 
        }  
        return x;  
    },  
    reduce : function(obj) {  
        var x = this.amount(obj, false);  
        if (parseInt(x) >= this.min) {  
            jQuery(obj).val(x);
            account(obj);
            count_freight(parseInt(x));
        } else { 
			$(".black_feds").text("购买数量不能小于1").show();
	    	setTimeout("prompt();", 2000);
            jQuery(obj).val(1);
        }  
    },  
    add : function(obj) {
        var x = this.amount(obj, true);  
        var max = jQuery('#item_amount').val();
        if (parseInt(x) <= parseInt(max)) { 
            jQuery(obj).val(x);
            account(obj);
            count_freight(parseInt(x));
        } else {
			$(".black_feds").text("购买数量不能大于库存").show();
	    	setTimeout("prompt();", 2000);
            jQuery(obj).val(max == 0 ? 1 : max);
        }
    },  
    modify : function(obj) {
    	if(!num_check()){
            account(obj);
            count_freight(parseInt(x));
    		return false;
    	}
        var x = jQuery(obj).val();
        var max = jQuery('#item_amount').val();
        var intx = parseInt(x);
        var intmax = parseInt(max);
        account(obj);
        count_freight(parseInt(x));
    },
    finishing : function(obj){
    	jQuery(obj).val(jQuery(obj).val().replace(/[^0-9]/ig,"")); // 禁止输入中文
        count_freight(parseInt(jQuery(obj).val().replace(/[^0-9]/ig,"")));
    }
});

/**
 * 统一检查购买数量
 */
function num_check(){
	var item_num = $('input[name="item_num"]');
	item_num.val(item_num.val().replace(/[^0-9]/ig,"")); // 禁止输入中文  
    var x = item_num.val();
    var max = jQuery('#item_amount').val();
    var intx = parseInt(x);  
    var intmax = parseInt(max);

    if (intx < 1) {
		$(".black_feds").text("购买数量不能小于1").show();
    	setTimeout("prompt();", 2000); 
    	item_num.val(1);
		return false;
    } else if (intx > intmax) {  
		$(".black_feds").text("购买数量不能大于库存").show();
    	setTimeout("prompt();", 2000);
    	item_num.val(max == 0 ? 1 : max);
		return false;
    }
    if (!RegExp("^[1-9]\\d*$").test((parseInt(x))) || document.getElementById("item_num").value.length==0) {  
    	item_num.val(1);  
		$(".black_feds").text("请输入正确的数量").show();
    	setTimeout("prompt();", 2000);
        return false;  
    }
    return true;
}

/**
 * 统一结算
 */
function account(obj){
    var x = jQuery(obj).val();
    <?php if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") && empty($skuinfo['skuinfo']) && empty($skuinfo['skulist']) && empty($skuinfo['skuitem'])){?>//判断是否特价商品
    $("#total_price").text(formatCurrency((special_price.replace(/,/g,"") * x).toFixed(2)) +" ");
	<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
	$("#total_price").text(formatCurrency(sku_special_offer *$(obj).val()) + " ");
	<?php }else{?>
	$("#total_price").text(formatCurrency((curr_price.replace(/,/g,"") * x).toFixed(2)) +" ");
	<?php };?>
}
//商品数量操作结束

var selectsku = new Array(); //选中的SKU
var skulist = new Array();//PRODUCT原来的SKU
var curr_stock = '<?php echo number_format($details['stock']);?>';
var curr_price = '<?php echo $details['vip_price'] == 0 ? "0":$details['vip_price'];?>';
var special_price = '<?php echo $details['special_price'] == 0 ? "0":number_format($details['special_price'],2);?>';//特价价格

function getShareInfo()
{
	window.location.href="<#name#>name=<?php echo $details['name'].'&img='.$details['goods_img'];?>";
}
function ShareInfo(){
	window.location.href="<#name#>name=<?php echo $details['name'].'&img='.$details['goods_img'].'&desc=我在51易货网发现了一款不错的商品，赶快来看看吧!';?>";
}
function selectSKU(obj,attr_id,sku_id)
{
	$(obj).addClass("active").siblings().removeClass();
	for(var i=0;i<skulist.length;i++)
	{
		if(attr_id == skulist[i])
		{
			selectsku[i] = attr_id+"-"+sku_id;
		}
	}
	setInfo();
}

var str="";
var skuprice = new Array();

<?php 
$sku_info = isset($skuinfo)?$skuinfo["skuinfo"]:array();
$sku_list = isset($skuinfo)?$skuinfo["skulist"]:array();

$special_price_start_at = isset($details['special_price_start_at'])?$details['special_price_start_at']:'0000-00-00 00:00:00';
$special_price_end_at = isset($details['special_price_start_at'])?$details['special_price_end_at']:'0000-00-00 00:00:00';
if(date ('Y-m-d H:i:s')>=$special_price_start_at && date ('Y-m-d H:i:s')<=$special_price_end_at){  $special_price_item = true;//判断是否特价?>
	$("#product_price").css("font-size","14px");
	$("#special_price_item").show();
	$("#product_price_item").css("text-decoration","line-through");
	$('#total_price').html((special_price*$('#item_num').val()).toFixed(2)+" ");
<?php
}
foreach($sku_list as $key=>$list):
?>
skuprice[<?php echo $key;?>] = ['<?php echo $list["sku_key"]?>',<?php echo $list["store"];?>,<?php echo $list["m_price"];?>,<?php echo $list["val_id"];?>,<?php echo $list["special_offer"];?>];
<?php
endforeach;

$sku_item = isset($skuinfo)?$skuinfo["skuitem"]:array();
$items = "";
$k = 0;
foreach($sku_item as $v):
  if($items != $v["attr_id"]):
	$k = 0;
	if($items !=""):
?>
	   str = str+'</ul></div>';
<?php
	endif; 
	$items = $v["attr_id"];
?>

 skulist.push('<?php echo $v["attr_id"]?>');
 str = str+'<lable class="item"><?php echo $v["attr_name"]?>: </lable>'+
 '<div>'+
	 '<ul class="add_cart_size_list">';
	  <?php if($k==0){?>
		selectsku.push('<?php echo $v["attr_id"]."-".$v["sku_id"]?>');
	  <?php }?>
   <?php endif;?>
		 str = str+'<li <?php if($k==0){echo 'class="active"';}?> onclick="selectSKU(this,\'<?php echo $v["attr_id"]?>\',\'<?php echo $v["sku_id"];?>\')"><?php echo $v['sku_name']?></li>';

	 
<?php 
$k++;
endforeach;
if(count($sku_item)>0)
{?>
	str = str + '</ul></div>';
<?php } ?>

$('#sku').html(str);
setInfo();

function setInfo()
{
	var item = "";
	for(var i=0;i<selectsku.length;i++)
	{
		item = item+selectsku[i]+"_";
	}
	for(var i=0;i<skuprice.length;i++)
	{
		if(skuprice[i][0]+"_" == item)
		{
			$("#product_price").html((formatCurrency(skuprice[i][2]))+" ");
			$("#product_stock").html(skuprice[i][1]);
			$('#val_id').val(skuprice[i][3]);
			$('#item_amount').val(skuprice[i][1]);
			curr_stock = formatCurrency(skuprice[i][1]);
			curr_price = formatCurrency(skuprice[i][2]);
			sku_special_offer = skuprice[i][4];
			<?php if( $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") ): $special_price_item = true;//判断是否特价?>
			$("#special_price_item").show();
	    	$("#product_price_item").css("text-decoration","line-through");
			$('#total_price').html((formatCurrency(skuprice[i][4]*$('#item_num').val())) +" ");
	    	$('#special_price').html(formatCurrency(skuprice[i][4]) +" ");
			<?php else:?>
			$('#total_price').html((formatCurrency(skuprice[i][2]*$('#item_num').val())) +" ")
			<?php endif;?>
			break;
		}
	}
    var x = $('input[name="item_num"]').val();
    var max = jQuery('#item_amount').val();
    if (parseInt(x) > parseInt(max)) {
		$(".black_feds").text("购买数量不能大于库存").show();
    	setTimeout("prompt();", 2000);
        $('input[name="item_num"]').val(max == 0 ? 1 : max);
        x = $('input[name="item_num"]').val();
        <?php if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") && empty($skuinfo['skuinfo']) && empty($skuinfo['skulist']) && empty($skuinfo['skuitem'])){?>//判断是否特价商品
        $("#total_price").text(formatCurrency((special_price.replace(/,/g,"") * x).toFixed(2)) +" ");
    	<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
    	$("#total_price").text(formatCurrency(sku_special_offer * x) + " ");
    	<?php }else{?>
    	$("#total_price").text(formatCurrency((curr_price.replace(/,/g,"") * x).toFixed(2)) +" ");
    	<?php };?>
    }
}

function add_to_cart(pid,pname,imgurl,cor_id,cor_name)
{
	if(!num_check()){
		return false;
	}	
	//获取sku信息放置于购物车内存
	var attr_sku = new Array();
	<?php
    if (isset($attr_count) && $attr_count > 0) {
        $attr_sku = '';
        foreach ($attr_name_array as $k => $v) {
    ?>
		attr_sku = attr_sku + '<?php echo $v;?>:'+($(".active:eq("+<?php echo $k;?>+")").html())+";";
    <?php 
        }
    }
	?>
	var pid = <?php echo $details['id']?>;
	var pname = '<?php echo $details['name'];?>';
	var imgurl = '<?php echo $imgurl?>';
	var cor_id = <?php echo isset($corporate['id'])&&$corporate['id']!=null?$corporate['id']:0 ?>;
	var cor_name = '<?php echo isset($corporate['corporation_name'])&&((string)$corporate['corporation_name'])!==""?$corporate['corporation_name']:"" ?>';
	var txtC=$('input[name="item_num"]');
	var qty = parseInt(txtC.val());
	var sku_id = 0;
	var is_freight = "<?php echo $details['is_freight'] ? "1" : "0"?>";
	var freight = is_freight == 0 ? 0 : count_freight(qty);
	if($('#val_id').val() != 0){
		sku_id = $('#val_id').val();
	}
	var commission_rate = <?php echo $rebate?>;
	<?php if($special_price_item){?>//特价商品期间传商品特价价格
    window.location.href="<#add_to_cart#>id=" + pid + "&qty=" + qty+"&price="+special_price+"&pname="+pname+"&imgurl="+imgurl+"&&val_id="+sku_id+"&cor_id="+cor_id+"&cor_name="+cor_name+"&attr_sku="+attr_sku+"&freight="+freight+"&commission_rate="+commission_rate;
    <?php }else{?>//传正常商品价格
    window.location.href="<#add_to_cart#>id=" + pid + "&qty=" + qty+"&price="+curr_price+"&pname="+pname+"&imgurl="+imgurl+"&&val_id="+sku_id+"&cor_id="+cor_id+"&cor_name="+cor_name+"&attr_sku="+attr_sku+"&freight="+freight+"&commission_rate="+commission_rate;
	<?php }?>
}

function buy(pid,pname,imgurl,cor_id,cor_name)
{
	if(!num_check()){
		return false;
	}
	//获取sku信息放置于购物车内存
	var attr_sku = new Array();
	<?php
    if (isset($attr_count) && $attr_count > 0) {
        $attr_sku = '';
        foreach ($attr_name_array as $k => $v) {
    ?>
			attr_sku = attr_sku + '<?php echo $v;?>:'+($(".active:eq("+<?php echo $k;?>+")").html())+";";
    <?php 
        }
    }
	?>
	var pid = <?php echo $details['id']?>;
	var pname = '<?php echo $details['name'];?>';
	var imgurl = '<?php echo $imgurl?>';
	var cor_id = <?php echo isset($corporate['id'])&&$corporate['id']!=null?$corporate['id']:0 ?>;
	var cor_name = '<?php echo isset($corporate['corporation_name'])&&((string)$corporate['corporation_name'])!==""?$corporate['corporation_name']:"null" ?>';
	var txtC=$('input[name="item_num"]');
	var qty = parseInt(txtC.val());
	var sku_id = 0;
	var is_freight = "<?php echo $details['is_freight'] ? "1" : "0"?>";
	var freight = is_freight == 0 ? 0 : count_freight(qty);
	if($('#val_id').val() != 0){
		sku_id = $('#val_id').val();
	}
	 var commission_rate = <?php echo $rebate?>;
	 <?php if($special_price_item){?>//特价商品期间传商品特价价格
	 if(sku_id){
			window.location.href="<#buy#>id=" + pid + "&qty=" + qty+"&pname="+pname+"&imgurl="+imgurl+"&price="+sku_special_offer+"&val_id="+sku_id+"&cor_id="+cor_id+"&cor_name="+cor_name+"&attr_sku="+attr_sku+"&freight="+freight+"&commission_rate="+commission_rate;
		}else{
			window.location.href="<#buy#>id=" + pid + "&qty=" + qty+"&pname="+pname+"&imgurl="+imgurl+"&price="+special_price+"&val_id="+sku_id+"&cor_id="+cor_id+"&cor_name="+cor_name+"&attr_sku="+attr_sku+"&freight="+freight+"&commission_rate="+commission_rate;
		}
    <?php }else{?>//传正常商品价格
    window.location.href="<#buy#>id=" + pid + "&qty=" + qty+"&pname="+pname+"&imgurl="+imgurl+"&price="+curr_price+"&val_id="+sku_id+"&cor_id="+cor_id+"&cor_name="+cor_name+"&attr_sku="+attr_sku+"&freight="+freight+"&commission_rate="+commission_rate;
    <?php }?>
}

function latitude(latitude,longitude,address){
	if(latitude=='')
	{
		latitude = 0;
	}
	if(longitude=='')
	{
		longitude = 0;
	}
	window.location.href="<#latlogitude#>latitude=" + latitude + "&longitude=" + longitude + "&address="+address;
}

/** 
 * 将数值四舍五入(保留2位小数)后格式化成金额形式 
 * 
 * @param num 数值(Number或者String) 
 * @return 金额格式的字符串,如'1,234,567.45' 
 * @type String 
 */  
function formatCurrency(num) {  
    num = num.toString().replace(/\$|\,/g,'');  
    if(isNaN(num))  
        num = "0";  
    sign = (num == (num = Math.abs(num)));  
    num = Math.floor(num*100+0.50000000001);  
    cents = num%100;  
    num = Math.floor(num/100).toString();  
    if(cents<10)  
    cents = "0" + cents;  
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)  
    num = num.substring(0,num.length-(4*i+3))+','+  
    num.substring(num.length-(4*i+3));  
    return (((sign)?'':'-') + num + '.' + cents);  
}

/**
 * 运费计算
 */
function count_freight(num){
	var is_freight = "<?php echo $details['is_freight']?>";// 是否设置了运费
	var default_freight = "<?php echo $details['default_freight']?>";// 默认价格 10
	var default_item = "<?php echo $details['default_item']?>";// 默认数量是多少 1
	var add_item  = "<?php echo $details['add_item']?>";// 每增加多少件 3
	var add_freight = "<?php echo $details['add_freight']?>";// 每增加X件+多少钱 10

	if(is_freight!="1"){
		return true;
	}
	
	if(num > default_item ){
		var num = num - default_item;
	    var num_a = num/add_item;
	    if( isInteger(num_a) ){ //如果是整型 
		    var freight = parseInt(num_a)*parseFloat(add_freight)+parseFloat(default_freight);
		}else{ 
			if(num_a < 1){
				var freight = parseFloat(default_freight)+ parseFloat(add_freight);
		    }else{ 
		    	var freight = ( parseInt(num_a)*parseFloat(add_freight) ) + parseFloat(add_freight)+parseFloat(default_freight);
			}
		}
		freight = freight.toFixed(2);

	    if(isInteger(freight) ){ 
		    $('#freight').text(freight+'.00 ');
	    }else{ 
		   $('#freight').text(freight+' ');
	    }
	    return freight;
    }else{ 
    	$('#freight').text(default_freight+' ');
        return default_freight;
    }
}

//是否正整数
function isInteger(number){
	return number > 0 && String(number).split('.')[1] == undefined
}

/**
 * 进入店铺
 */
function enterCorporation(){
	var corporation_id = "<?php echo $details['corporation_id'];?>";
	window.location.href="<#enterCorporation#>corporation_id=" + corporation_id;
}
</script>

</html>