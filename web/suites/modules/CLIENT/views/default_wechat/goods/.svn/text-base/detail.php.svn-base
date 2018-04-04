<style type="text/css">.page{padding-top:0px;}.footer{bottom:0px;}</style>
    <div style="position:fixed;top:10px;left:10px;z-index: 9999;">
      <a href="javascript:history.back()" style="padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(0,0,0,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
      <a href="<?php echo site_url("cart");?>" class="cart" style="right:10px;"><span class="icon-gouwuche1" style="font-size: 20px;color:#fff;"></span>
      <span class="cart_num2">
      <?php 
    			$cartcount = 0;
    			foreach($this->cart->contents() as $items){
    			    $cartcount = $cartcount + $items['qty'];
    			}
    			if($cartcount>99){
    			    echo "99+";?><style type="text/css">.cart_num2{width:25px;}</style><?php 
    			}else{
    			    echo $cartcount;
    			}
    			?>
	  </span></a>
      <a href="javascript:void(0);" id="onMenuShareAppMessage" class="share" style="display: none;"><span class="icon-fenxiang" ></span></a>
    </div>
        <div class="page clearfix">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php 
    			//is_base:是否为主图，1为是，则首先显示
    			//商品无图片时显示默认图片
    			if(isset($gallery) && count($gallery)>0){
                    foreach ($gallery as $image){
						if($image["is_base"] == 1)
						{
						?>
                    <div class="swiper-slide maximg_480">
						<img src="<?php echo IMAGE_URL.$image['file'];?>"
							alt="<?php echo $image['image_name'];?>" onerror="this.src='images/default_img_b.jpg'">
					</div>
                    <?php } }?>
					<?php foreach ($gallery as $image){
						if($image["is_base"] != 1)
						{
						?>
                    <div class="swiper-slide maximg_480">
						<img src="<?php echo IMAGE_URL.$image['file'];?>"
							alt="<?php echo $image['image_name'];?>" onerror="this.src='images/default_img_b.jpg'">
					</div>
                    <?php } } } else{ ?>
                    <div class="swiper-slide maximg_480">
						<img src="images/default_img_b.jpg" alt="51ehw" onerror="this.src='images/default_img_b.jpg'">
					</div>
					<?php }?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div><!--swiper-container end-->

            <div class="product">
                <h1><?php echo $details['name'];?></h1>
                <h2><?php echo $details['short_desc'];?></h2>
				<input type="hidden" name="product_id" value="<?php echo $details['id'];?>">
				<input type="hidden" name="payment_id" value="2">
				<lable class="item" id="special_price_item" style="display:none;">特价&nbsp;&nbsp;
    				<span class="red" style="font-size: 15px;font-weight: bold;" id="special_price">
    					<?php echo number_format($details['special_price'],2); ?> 货豆
    				</span>
				</lable>

                <lable class="item" id="product_price_item">易货价<em style="opacity: 0;">&nbsp;&nbsp;&nbsp;</em>
                    <span class="red" id="product_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 5px;">
    					<?php echo number_format($details['vip_price'], 2);?> 货豆
                    </span>
                </lable>
                <?php if($details['market_price']){;?>
                <lable class="item" id="product_price_item">参考价<em style="opacity: 0;">&nbsp;&nbsp;&nbsp;</em>
                    <span class="red" id="product_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 5px;">
    					<?php echo $details['market_price'];?> 货豆
                    </span>
                </lable>
                <?php };?>      
                <lable style="float: right;margin-top:-30px;">
                <?php if($details['latitude'] && $details['longitude'] && $city!=''){?>
                <!-- 定位 -->
                <div class="detail_dingwei">
                	<!-- 腾讯 -->
                	<!-- <a href='http://apis.map.qq.com/uri/v1/geocoder?coord=<?php //echo $details['latitude'];?>,<?php //echo $details['longitude'];?>&referer=myapp' class="icon-dingwei1" style="font-size:18px;color:#999999;"> -->
                	<!-- 百度 -->
                	<a href='http://api.map.baidu.com/marker?location=<?php echo $details['latitude'];?>,<?php echo $details['longitude'];?>&title=<?php echo isset($details['address'])?$details['address']:'51易货网';?>&output=html' class="icon-dingwei1" style="font-size:18px;color:#999999;">
                		<span style="font-size:12px;color:#999999;text-overflow:ellipsis;"><?php //echo $city;?>导航</span>
                	</a>
                </div>
                <?php };?>
                <a href="javascript:add_to_fav(<?php echo $details['id'];?>)" style="float:right;">
                <?php if($fav){?>
                	<span id="xin" class="shoucang02 icon-xinshixin" style="font-size: 20px; color:#fe4101; padding-left: 10px;"></span>
                <?php }else{?>
                	<span id="xin" class="icon-shoucang1 shoucang02" style="font-size:20px;color:#6A6A6A;padding-left: 10px;"></span>
                <?php };?>
                </a>
                </lable>
                </lable>
                <div class="line"></div>
                <lable class="item">库存<em style="opacity: 0;">测试</em>&nbsp;&nbsp;<span id="product_stock" style="color: #333333;font-weight: bold;padding-left: 1px;"><?php echo number_format($details['stock']);?>件</span>
                </lable>
				<div id="sku"></div>
				<input type="hidden" name="val_id" id="val_id" value="0"/>
                  <!-- <div class="line"></div> -->
                <lable class="item detail-itme-num">数量</lable>
                <span class="add-del">
                    <a href="javascript:jQuery.reduce('#item_num');" class="btn-del num_oper num_min detail-jian-num"><span>－</span></a>
                    <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1" onblur="jQuery.modify('#item_num');" onkeyup="jQuery.finishing('#item_num');"/>
                    <a href="javascript:jQuery.add('#item_num')" class="btn-add num_oper num_plus"><span >+</span></a>
                    <input id="item_amount" type="hidden" value="<?php echo $details['stock'];?>"/>
                </span>
                <lable class="item detail-xiaoji-num">小计<em style="opacity: 0;">测试</em><span class="red" id="total_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left:8px;"><?php echo /*$details['vip_price'] == 0 ? 0:*/number_format($details['vip_price'],2);?> 货豆</span></lable>
                <p class="caution_tips" id="item-error" style="display:none;"></p>

                <lable class="item">运费<em style="opacity: 0;">测试</em><span class="red" id="freight" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 8px;"><?php echo $details['is_freight'] ? $details['default_freight'].' 货豆' : '免运费'?></span></lable>
               
                 <!-- 店铺名 -->
                <div class="shop-name">
                    <div class="shop-name-main">
                        <span class="icon-shop shop-icon"></span>
                        <span class="shop-name-text"><?php echo isset($corp_name)?$corp_name:"&nbsp;"?></span>
                        <a href="<?php echo site_url("home/GetShopGoods"."/".$details["corporation_id"]);?>"class="shop-name-into">进入店铺<span class="icon-right"></span></a>
                    </div>
                </div>


                <!-- 商品详情 猜你喜欢 导航 -->
                <div class="goods-live-nav">
                    <ul>
                        <li class="active-line">商品详情</li>
                       <!--  <li>猜你喜欢</li> -->
                    </ul>

                </div>


                <!-- 商品详情 -->
                <lable class="item">商品详情&nbsp;&nbsp;
                <div class="line2 pt10"></div>
                 <ul class="item-ifo">
                    <li>
                    <?php 
                        $res = array();
                        foreach($product_attr_values as $item) {
                            if(! isset($res[$item['attr_id']])) $res[$item['attr_id']] = $item;
                            else $res[$item['attr_id']]['attr_value'] .= ',' . $item['attr_value'];
                        }
                        
                        $product_attr_values = array_values($res);
                  	
                  	?>
                    <?php if(!empty($product_attr_values)):?>
                    <?php foreach($product_attr_values as $v): ?>
                    <?php if($v['attr_type']!='related' && $v['attr_type']!='sku'):?>
                    <li><?php echo $v['attr_name']?>：<?php echo $v['attr_value']?></li>
                    <?php endif;?>
                    <?php endforeach; ?>
                    <?php else:?>
                    <span><?php echo '暂无参数';?></span>
                    <?php endif;?>
                    </li>
                </ul>

                </lable>

                <!-- 猜你喜欢 -->
                <div>
                    

                    
                </div>




                <!-- <div class="line"></div> -->
                <lable class="item">商品图片:</lable>
                <div><?php echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.IMAGE_URL,$details['desc']);?></div>

            </div><!--product end-->

        </div><!--page end-->
         <div class="footer">
            <ul class="nav-tab">
                <li>
                	<a href="javascript:buy(<?php echo $details['id'];?>)" class="button bg-color">立即购买</a>
                </li>
                <li>
                	<a href="javascript:add_to_cart(<?php echo $details['id'];?>,this)" class="button bg-red">加入购物车</a>
                </li>
            </ul>
        </div>
    </div>

<!--分享-->
<div id="mcover" onclick="document.getElementById('mcover').style.display='';" style="display: none;">
     <img src="images/share.png">
</div>

<script type="text/javascript" src="js/ShoppingCart.js" /></script>

<script>
    //广告图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });
</script>

<script type="text/javascript">
    //数量、套餐切换
    TouchSlide({
        slideCell: "#leftTabBox"
    });
</script>

<script type="text/javascript">
// 商品数量操作开始
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
            jQuery(obj).val(1);
			$(".black_feds").text("请输入正确的数量！").show();
	    	setTimeout("prompt();", 2000);
	    	return;
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
            jQuery(obj).val(1);
			$(".black_feds").text("购买数量不能小于1").show();
	    	setTimeout("prompt();", 2000);
	    	return;
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
            jQuery(obj).val(max == 0 ? 1 : max);
			$(".black_feds").text("购买数量不能大于库存").show();
	    	setTimeout("prompt();", 2000);
	    	return;
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

//运费计算
function count_freight(num){
	var is_freight = <?php echo isset($details['is_freight'])?$details['is_freight']:0;?>;// 是否设置了运费
	var default_freight = <?php echo isset($details['default_freight'])?$details['default_freight']:0;?>;// 默认价格 10
	var default_item = <?php echo isset($details['default_item'])?$details['default_item']:1;?>;// 默认数量是多少 1
	var add_item  = <?php echo isset($details['add_item'])?$details['add_item']:1?>;// 每增加多少件 3
	var add_freight = <?php echo isset($details['add_freight'])?$details['add_freight']:1?>;// 每增加X件+多少钱 10

	if(is_freight!="1"){
		return true;
	}

	if(num > default_item ){ 
		var num = num - default_item;
	    var num_a = num/add_item;
	    if( isInteger(num_a) ){
		    //如果是整型
		    var freight = parseFloat(num_a) * parseFloat(add_freight) + parseFloat(default_freight);
		}else{ 
			if(num_a < 1){
				var freight = parseFloat( default_freight ) + parseFloat( add_freight );
		    }else{ 
		    	var freight = ( parseInt(num_a) * parseFloat(add_freight) ) + parseFloat( add_freight ) + parseFloat( default_freight );
			}
		}
		freight = freight.toFixed(2);

	    if(isInteger(freight) ){ 
		    $('#freight').text(freight+'.00 货豆');
	    }else{ 
		   $('#freight').text(freight+' 货豆');
	    }
		freight = freight.toFixed(2);
    }else{ 
    	$('#freight').text(default_freight+' 货豆');
    }
}

//是否正整数
function isInteger(number){
	return number > 0 && String(number).split('.')[1] == undefined
}

/** 
 * 将数值四舍五入(保留2位小数)后格式化成金额形式 
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
    $("#total_price").text(formatCurrency((special_price.replace(/,/g,"") * x).toFixed(2)) +" 货豆");
	<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
	$("#total_price").text(formatCurrency(sku_special_offer *$(obj).val()) + " 货豆");
	<?php }else{?>
	$("#total_price").text(formatCurrency((curr_price.replace(/,/g,"") * x).toFixed(2)) +" 货豆");
	<?php };?>
}
// 商品数量操作结束

var selectsku = new Array(); //选中的SKU
var skulist = new Array();//PRODUCT原来的SKU
var curr_stock = '<?php echo number_format($details['stock']);?>';
var curr_price = '<?php echo $details['vip_price'] == 0 ? "0":number_format($details['vip_price'], 2);?>';
var special_price = '<?php echo $details['special_price'] == 0 ? "0":number_format($details['special_price'],2);?>';//特价价格

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
if(date ('Y-m-d H:i:s')>=$special_price_start_at && date ('Y-m-d H:i:s')<=$special_price_end_at){?>

	$("#product_price").css("font-size","14px");
	$("#special_price_item").show();
	$("#product_price_item").css("text-decoration","line-through");
	$('#total_price').html((special_price*$('#item_num').val()).toFixed(2)+" 货豆");
	
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
 str = str+'<lable class="item"><?php echo $v["attr_name"]?> </lable>'+
 '<div class="details_goods_list">'+
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
			$("#product_price").html('<b>'+formatCurrency((skuprice[i][2]).toFixed(2))+" 货豆"+'</b>');
			$("#product_stock").html(skuprice[i][1]);
			$('#val_id').val(skuprice[i][3]);
			$('#item_amount').val(skuprice[i][1]);
			curr_stock = formatCurrency(skuprice[i][1]);
			curr_price = formatCurrency(skuprice[i][2]);
			special_price = special_price;
			sku_special_offer = skuprice[i][4];
			
			<?php if( $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") ):?>
			$("#special_price_item").show();
	    	$("#product_price_item").css("text-decoration","line-through");
			$('#total_price').html(formatCurrency((skuprice[i][4]*$('#item_num').val()).toFixed(2))+" 货豆");
	    	$('#special_price').html(formatCurrency(skuprice[i][4]) + " 货豆");
	    	<?php else:?>
	    	$('#total_price').html(formatCurrency((skuprice[i][2]*$('#item_num').val()).toFixed(2))+" 货豆")
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
        $("#total_price").text(formatCurrency((special_price.replace(/,/g,"") * x).toFixed(2)) +" 货豆");
    	<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
    	$("#total_price").text(formatCurrency(sku_special_offer * x) + " 货豆");
    	<?php }else{?>
    	$("#total_price").text(formatCurrency((curr_price.replace(/,/g,"") * x).toFixed(2)) +" 货豆");
    	<?php };?>
    }
}

//加入购物车
function add_to_cart(pid,obj)
{
	if(!num_check()){
		return false;
	}
	if(document.getElementById("item_num").value.length==0){
		$(".black_feds").text("请输入正确的数量").show();
    	setTimeout("prompt();", 2000);
    	return;
	}
	if($("#product_stock").html().replace(/[^0-9]/ig,"") == 0){
		$(".black_feds").text("商品库存不足").show();
    	setTimeout("prompt();", 2000);
    	return;
	}
	var sku_id = 0;
    txtC=$('input[name="item_num"]');
    qty = parseInt(txtC.val());
    sku_id = 0;
    if($('#val_id').val() != 0){
    	sku_id = $('#val_id').val();
    }
    add_cart_forh5(pid,qty,sku_id);
}

//加入购物车
function add_cart_forh5(goodsid,qty,sku_id)
{
	$.ajax({
      url: "<?php echo site_url('cart/ajax_add')?>",
      type: 'POST',
      data:{'pid':goodsid,'qty':qty,'sku_id':sku_id},
      dataType: 'html',
      success: function(data){
      	data = jQuery.parseJSON(data);
          	switch (data['status']){
                case 'ok':
                    var num = qty+Number($(".cart_num2").html());
                    $(".cart_num2").text(num);
            		$(".black_feds").text("加入购物车成功").show();
                	setTimeout("prompt();", 2000);
                    break;
                case 'on_goods':
            		$(".black_feds").text("商品已下架").show();
                	setTimeout("prompt();", 2000);
                    break;
                case 'fail':
            		$(".black_feds").text("添加失败").show();
                	setTimeout("prompt();", 2000);
                    break;
                case 'add_fail':
            		$(".black_feds").text("添加失败").show();
                	setTimeout("prompt();", 2000);
                	break;
                default :
        			$(".black_feds").text("网络异常").show();
            		setTimeout("prompt();", 2000);
                    break;
            }
//     		window.location.reload();
		}
    });
}

//添加到收藏夹
function add_to_fav(pid)
{
	<?php if(!$this->session->userdata('user_in')):?>
	$(".black_feds").text("您还未登录，请先登录。").show();
	setTimeout("prompt();", 2000);
	return false;
	<?php else:?>
	$.ajax({
	      url: "<?php echo site_url('member/fav/ajax_add');?>",
	      type: 'POST',
	      data:{'pid':pid},
	      dataType: 'html',
	      success: function(data){
				switch(data){
				case 'del_ok':
					$('#xin').attr('class','icon-shoucang1 shoucang02').attr('style','font-size:20px;color:#6A6A6A;padding-left: 10px;');
					break;
				case 'del_fail':
					$(".shoucang02").addClass("icon-xinshixin");
				    $(".shoucang02").css("color","#fe4101");
					break;
				case 'add_ok':
					$(".shoucang02").removeClass("icon-shoucang1");
					$(".shoucang02").addClass("icon-xinshixin");
				    $(".shoucang02").css("color","#fe4101");
					break;
				case 'add_fail':
					$('#xin').attr('class','icon-shoucang1 shoucang02').attr('style','font-size:20px;color:#6A6A6A;padding-left: 10px;');
					break;
				case 'fail':
					$(".black_feds").text("操作失败").show();
			    	setTimeout("prompt();", 2000);
			    	return false;
					break;
				}
	      	}
	    });
    <?php endif;?>
}

//购买
function buy(pid)
{
	if(!num_check()){
		return false;
	}
	if($("#product_stock").html().replace(/[^0-9]/ig,"") == 0){
		$(".black_feds").text("商品库存不足").show();
    	setTimeout("prompt();", 2000);
    	return;
	}
	txtC=$('input[name="item_num"]');
	qty = parseInt(txtC.val());

	window.location.href="<?php echo site_url('cart/add');?>/" + pid + "/" + qty + "/" + $('#val_id').val()+"/h5";
}


// 商品详情 猜你喜欢
 $(".goods-live-nav ul li").on("touchstart",function(){
    var index = $(this).index();
    $(this).addClass("active-line").siblings().removeClass("active-line");




 })






</script>