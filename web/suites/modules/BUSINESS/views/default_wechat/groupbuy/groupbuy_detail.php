<?php 
$signPackage = $this->js_api_sdk->getSignPackage();
?>
<style type="text/css">
.page {
	padding-top: 0px;
}

.footer {
	bottom: 0px;
}

.pintuan-wanfang ul li {
	float: left;
}

.pintuan-xuanze {
	margin: 5px 5px 5px 0px;
	float: left;
	text-align: center;;
	width: 25px;
	line-height: 25px;
	border-radius: 50%;
	background: #FECF0A;
}

.pintuan-yaoqing {
	margin: 5px 5px;
	float: left;
	text-align: center;;
	width: 25px;
	line-height: 25px;
	border-radius: 50%;
	background: #D5D5D5;
}

.pintuan-renshu {
	margin: 5px 10px 5px 17px;
	float: left;
	text-align: center;;
	width: 25px;
	line-height: 25px;
	border-radius: 50%;
	background: #D5D5D5;
}

.pintuan-shijian {
	padding-left: 10px;
	color: #FA6C32;
}

.pintuan-xianxia {
	font-size: 17px;
	color: #22AA1E;
	padding-right: 10px;
}

@media screen and (max-width:320px) {
	.pintuan-shijian {
		padding-left: 3px;
	}
	.pintuan-xianxia {
		padding-right: 0px;
	}
}

@media screen and (max-width:375px) {
    .groupbuy_detail_shijian {
        padding:10px 5px!important;
    }
    .pintuan-renshu {margin: 5px 6px 5px 0px; }
}

#total {
	font-size: 15px;
	font-weight: bold;
}

.groupbuy_detail_shijian {display: inline-block;color:#FFF6F3;background: #FA6C32;padding:10px 15px;}
</style>

    <!-- 头部 -->
	<div style="position:fixed;top:10px;left:10px;z-index: 9999;">
        <a href="javascript:history.back()" style="padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(0,0,0,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
        <a href="<?php echo site_url("/cart");?>" class="cart"><span class="icon-gouwuche1"></span>
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
          </span>
        </a>
        <a href="javascript:share();" id="onMenuShareAppMessage" class="share" ><span class="icon-fenxiang" ></span></a>
    </div>
    <!-- 画廊 -->
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
					<img src="<?php echo IMAGE_URL.$image['file'];?>" alt="<?php echo $image['image_name'];?>" onerror="this.src='images/default_img_b.jpg'">
				</div>
                <?php } }?>
				<?php foreach ($gallery as $image){
					if($image["is_base"] != 1)
					{
					?>
                <div class="swiper-slide maximg_480">
					<img src="<?php echo IMAGE_URL.$image['file'];?>" alt="<?php echo $image['image_name'];?>" onerror="this.src='images/default_img_b.jpg'">
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
			<lable class="item" id="special_price_item" style="display:none;">特<em style="opacity: 0;">文字</em>价:&nbsp;&nbsp;
				<span class="red" style="font-size: 15px;font-weight: bold;">
					<?php echo number_format($details['special_price'],2); ?> 货豆
				</span>
			</lable>

            <!-- 拼团 -->
            <div>
                <span style="font-size: 14px;color:#F66B32;"><?php echo $details['menber_num']?>人拼团价：<span style="font-size: 18px;" id="groupbuy_price"><?php echo $details['groupbuy_price']?></span>货豆／件</span>
            </div>  
             <lable class="item" id="product_price_item"><s>易&nbsp;&nbsp;货&nbsp;&nbsp;价:&nbsp;&nbsp;
                <span class="red" id="product_price" style="color: #333333;font-size: 15px;font-weight: bold;">
                    <?php echo number_format($details['vip_price'], 2);?> 货豆
                </span></s>
            </lable>
            <div class="line"></div>

             <!-- 拼团倒计时 -->
            <div style="font-size: 15px;">
                <span><span class="groupbuy_detail_shijian">活动剩余时间</span>
                <span><span class="pintuan-shijian" id="int_day">00</span>&nbsp;天&nbsp;<span class="pintuan-shijian" id="int_hour">00</span>&nbsp;时&nbsp;<span class="pintuan-shijian" id="int_minute" >00</span>&nbsp;分&nbsp;</span><span class="pintuan-shijian" id="int_second">00</span><span>&nbsp;秒&nbsp;</span></span>
            </div>

            <lable class="item">库<em style="opacity: 0;">文字</em>存: &nbsp;&nbsp;<span id="product_stock" style="color: #333333;"><?php echo number_format($details['stock']);?>件</span></lable>
            <?php if($details['set_limit'] == 1){?>
            <lable class="item">限<em style="opacity: 0;">文字</em>购: &nbsp;&nbsp;
                <span>
                <?php echo number_format(isset($details['least_purchase'])?$details['least_purchase']:1)." ~ ".number_format(isset($details['most_purchase'])?$details['most_purchase']:$details['stock']);?>件
                </span>
            </lable>
			<?php }?>
			<div id="sku"></div>
			<input type="hidden" name="val_id" id="val_id" value="0"/>
              <div class="line"></div>
            <lable class="item">数<em style="opacity: 0;">文字</em>量: &nbsp;&nbsp;<!-- <span class="red" id="total_price"> 1 件</span> --></lable>                
            <span class="add-del">
                <a href="javascript:jQuery.reduce('#item_num');" class="btn-del num_oper num_min"><span>－</span></a>
                <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="<?php echo $details['set_limit']==1?$details['least_purchase']:"1";?>" onblur="jQuery.modify('#item_num');" onkeyup="jQuery.finishing('#item_num');"/>
                <a href="javascript:jQuery.add('#item_num')" class="btn-add num_oper num_plus"><span >+</span></a>
                <input id="item_amount" type="hidden" value="<?php echo $details['stock'];?>"/><!-- 库存 -->
            </span>
            
            <lable class="item">小<em style="opacity: 0;">文字</em>计: &nbsp;&nbsp;<span id="total_price"><?php echo number_format($details['groupbuy_price'],2);?> 货豆</span></lable>
            <p class="caution_tips" id="item-error" style="display:none;"></p>
            
        </div>

         
        <!-- 拼团 商店 -->
        <?php if(isset($corporation['corporation_name']) && $corporation['corporation_name']!= ''){?>
        <div style="border-top: 5px solid #f6f6f6;">
            <div class="order_list_title" style="position: relative;padding: 10px 0;border-bottom: 1px solid #E8E8E8;">
              <span class="fn-left " style="padding-right: 10px;font-size: 15px;"><em class="icon-shop"></em></span><span style="font-size: 14px;"><?php echo $corporation['corporation_name'];?></span><a href="" style="font-size: 14px;color:#898989;position: absolute;right:0;">进入店铺<span class="icon-right" style="font-size: 17px;"></span></a> 
            </div>
            <div style="padding:10px 0;font-size: 14px;">
                <ul>
                    <a href="javascript:void(0);"><li style="display: inline-block;padding-right: 10px;"><span class="icon-xuanzhong" style="font-size: 17px;color:#22AA1E;padding-right: 10px;"></span><span>企业验证</span></li></a>
                    <a href="javascript:void(0);"><li style="display: inline-block;padding-right: 10px;"><span class="icon-xuanzhong" style="font-size: 17px;color:#22AA1E;padding-right: 10px;"></span><span>担保交易</span></li></a>
                    <a href="javascript:void(0);"><li style="display: inline-block;padding-right: 10px;"><span class="icon-xuanzhong pintuan-xianxia" ></span><span>线下门店</span></li></a>
                </ul>
            </div>
        </div>
		<?php }?>
			
        <div style="border-top: 5px solid #f6f6f6;">
            <!-- 拼团玩法 -->
            <div class="order_list_title" style="position: relative;border-bottom: 1px solid #E8E8E8;padding-bottom: 15px;margin:15px 20px 0 20px;">
              </span><span style="font-size: 14px;">拼团玩法</span><a href="<?php echo site_url("activity/groupbuy/group_rules")?>" style="font-size: 14px;color:#898989;position: absolute;right:0;">玩法详情<span class="icon-right" style="font-size: 17px;"></span></a> 
            </div>
            <div style="position: relative;padding:10px 20px;" class="pintuan-wanfang">
                <ul style="overflow: hidden;">
                   <li><div class="pintuan-xuanze">1</div><div style="float:left;"><p>选择商品</p><p>付款开团/参团</p></div></li>
                   <li style="width:120px;"><div class="pintuan-yaoqing">2</div><div style="float:left;"><p>邀请并等待好友</p><p>支付参团</p></div></li>
                   <li><div class="pintuan-renshu">3</div><div style="float:left;"><p>达到人数</p><p>顺利成团</p></div></li>
                </ul>
            </div>
        </div>
        
        <!-- 查看全部凑团 -->
        <div style="border-top: 1px solid #f6f6f6;margin: 0 20px;"></div>
        
		<div class="product" style="padding:0 20px;">
			<lable class="item" style="border-bottom: 1px solid #f6f6f6;padding-bottom: 5px;padding-top: 5px;">
				<?php echo $details['remarks'];?>
			</lable>
            <div style="text-align: center;border-bottom: 5px solid #f6f6f6;padding-bottom: 10px;;font-size: 15px;">
                  <a href="<?php echo site_url("activity/groupbuy")?>">更多精彩拼团<span class="icon-right" style="font-size: 20px;"></span></a>
                </div>
            <lable class="item">参数:&nbsp;&nbsp;
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
            <div class="line"></div>
            <lable class="item">描述:</lable>
            <div><?php echo $details['desc'];?></div>

        </div><!--product end-->

    </div><!--page end-->
    
    <!-- foot start -->
    <div class="footer">
    	<ul class="nav-tab">
    	<?php //echo "<pre>";print_r($check_group_order);exit;?>
    		<li><a href="<?php echo site_url("goods/detail/".$id)?>"
    			class="button bg-color">单独购买</a></li>
    		<li>
        		<?php if($details['groupbuy_end_at'] < date('Y-m-d H:i:s')):?>
        			<a id="groupbuy_buttom" class="button" style="background-color: #D5D5D5">团购已结束</a>
        		<?php else:?>
            		<?php if($check_group_order): ?>
        			<a href="<?php echo site_url("activity/groupbuy/group_detail?buy_num=".$check_group_order['buy_num']."&head_menber=".$check_group_order['head_menber'].'&productid='.$details['id']);?>" id="groupbuy_buttom" class="button bg-red">召集团友</a>
            		<?php else: ?>
        			<a onclick="javascript:groupbuy(<?php echo $details['id'];?>)" id="groupbuy_buttom" class="button bg-red"><?php echo isset($buy_num) && $buy_num!=0?"参团":"去开团";?></a>
            		<?php endif;?>
        		<?php endif;?>
    		</li>
    	</ul>
    </div>
    <!-- foot end -->
</div>
    
<!--分享-->
<div id="mcover" onclick="document.getElementById('mcover').style.display='';" style="display: none;">
     <img src="images/share.png">
</div>

<!-- 广告图 -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });
</script>

<!-- 预加载js事件 -->
<script>
$(document).ready(function(){
	// 小计计算
	jQuery.account('#item_num');
})
</script>

<!-- 购买数量操作 -->
<script>
jQuery.extend( {
	groupbuy_price : $("#groupbuy_price").html(),
    min : <?php echo $details['set_limit'] == 1 ? $details['least_purchase']:"1";?>,
    max : <?php echo $details['set_limit'] == 1 && $details['most_purchase'] < $details['stock'] ? $details['most_purchase'] : $details['stock'];?>,
    reg : function(x) {
       jQuery('#item-error').html("");
       jQuery('#item-error').hide();
       return new RegExp("^[1-9]\\d*$").test(x);
    },
    amount : function(obj, mode) {
        // 增减操作
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
        // 减少
        var x = this.amount(obj, false);
        jQuery(obj).val(x);
    	if(!num_check()){
            this.account(obj);
            return false;
    	}
        this.account(obj);
    	//count_freight(parseInt(x));
    },
    add : function(obj) {
        // 增加
        var x = this.amount(obj, true);
        jQuery(obj).val(x);
        if(!num_check()){
        	this.account(obj);
            return false;
        }
        this.account(obj);
		//count_freight(parseInt(x));
    },
    modify : function(obj) {
        // 输入
    	if(!num_check()){
            this.account(obj);
            return false;
    	}
        this.account(obj);
		//count_freight(parseInt(x));
    },
    account : function(obj){
        // 小计计算
        var x = jQuery(obj).val();
    	$("#total_price").text(formatCurrency((this.groupbuy_price.replace(/,/g,"") * x).toFixed(2)) +" 货豆");
    },
    finishing : function(obj){
    	// 禁止输入中文
		jQuery(obj).val(jQuery(obj).val().replace(/[^0-9]/ig,""));
		//count_freight(parseInt(jQuery(obj).val().replace(/[^0-9]/ig,"")));
    }
});

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
    var min = <?php echo $details['set_limit'] == 1 ? $details['least_purchase'] : "1";?>;// 最少
    var stock = <?php echo $details['stock'];?>;// 库存
    var set_limit = <?php echo isset($details['set_limit']) ? $details['set_limit'] : "0";?>;// 是否限购
    var limit = <?php echo isset($details['most_purchase']) ? $details['most_purchase'] : "1";?>;// 限购数量
	var item_num = $('input[name="item_num"]');// 购买数量
    var contrast_type = "库存";// 提示文字
    var shownum = parseInt(stock);// 显示购买数量
    var x = item_num.val();
    var intx = parseInt(x);  
    var intmin = parseInt(min);
    var intlimit = parseInt(limit);
    var intstock = parseInt(stock);
    
	item_num.val(item_num.val().replace(/[^0-9]/ig,"")); // 禁止输入中文  
    
    if (intx < intmin) {  
		$(".black_feds").text("购买数量不能小于限购数量").show();
    	setTimeout("prompt();", 2000);
    	item_num.val(intmin);
		return false;
    } else if (intx < 1) {
		$(".black_feds").text("购买数量不能小于1").show();
    	setTimeout("prompt();", 2000); 
    	item_num.val(min);
		return false;
    } else if ( (set_limit == 1 && intx > intlimit) || intx > intstock) {
        if( set_limit == 1 && intx > intlimit){
        	contrast_type = "限购数量";
        	shownum = intlimit;
		}
		$(".black_feds").text("购买数量不能大于" + contrast_type).show();
    	setTimeout("prompt();", 2000);
    	item_num.val(shownum);
		return false;
    }
    if (!RegExp("^[1-9]\\d*$").test((parseInt(x))) || document.getElementById("item_num").value.length==0) {  
    	item_num.val(min);  
		$(".black_feds").text("请输入正确的数量").show();
    	setTimeout("prompt();", 2000);
        return false;  
    }
    return true;
}
</script>

<!-- 开团 -->
<script>
function groupbuy(pid){
	if(!num_check()){
		jQuery.account('#item_num');
        return false;
	}
<?php if($this->session->userdata("user_id")):?>
	var item_num = $('input[name="item_num"]').val();
	window.location.href="<?php echo site_url("activity/groupbuy/groupbuy_confirm/".$id."/".$buy_num );?>/" + item_num + "/";
<?php else:
    $this->session->set_userdata('ref_from_url',current_url());
?>
	window.location.href="<?php echo site_url("customer/login");?>";
<?php endif;?>
}
</script>

<!-- 倒计时js事件 -->
<script>
<?php 
$start = strtotime($details['groupbuy_start_at']);
$end = strtotime($details['groupbuy_end_at']);
?>;
    function countdown() {
        var time_start = new Date().getTime(); //设定当前时间
    	var time_end =  "<?php echo $end*1000;?>"; //设定目标时间
    	// 计算时间差 
    	
    	var time_distance = time_end - time_start; 
    	if(time_start >= time_end){
        	window.location.reload();
        	return;
        	}
    	// 天
    	var int_day = Math.floor(time_distance/86400000) 
    	time_distance -= int_day * 86400000; 
    	// 时
    	var int_hour = Math.floor(time_distance/3600000) 
    	time_distance -= int_hour * 3600000; 
    	// 分
    	var int_minute = Math.floor(time_distance/60000) 
    	time_distance -= int_minute * 60000; 
    	// 秒 
    	var int_second = Math.floor(time_distance/1000) 
    	// 时分秒为单数时、前面加零 
    	if(int_day < 10){ 
    		int_day = "0" + int_day; 
    	} 
    	if(int_hour < 10){ 
    		int_hour = "0" + int_hour; 
    	} 
    	if(int_minute < 10){ 
    		int_minute = "0" + int_minute; 
    	} 
    	if(int_second < 10){
    		int_second = "0" + int_second; 
    	}

    	document.getElementById("int_day").innerHTML=int_day;
        document.getElementById("int_hour").innerHTML=int_hour;
        document.getElementById("int_minute").innerHTML=int_minute;
        document.getElementById("int_second").innerHTML=int_second;
    }
    <?php if($end > time()){?>
    setInterval("countdown()", 900);
    <?php };?>

    function share(){
        $("#mcover").show();
    }
</script>
    
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: '<?php echo $signPackage["timestamp"];?>',
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
        // 所有要调用的 API 都要加到这个列表中
        'onMenuShareTimeline',
        'onMenuShareAppMessage'
      ]
});

wx.ready(function(){

    // 2. 分享接口
    // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口

    wx.onMenuShareAppMessage({
        title: '<?php echo "51易货网拼团";?>',
        desc: '<?php echo $details['name'];?>',
        link: '<?php echo site_url('goods/detail').'/'.$details['id'].'/0/groupbuy';?>',
        imgUrl: '<?php echo IMAGE_URL.$details['goods_thumb'];?>',
        trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
        // alert('用户点击发送给朋友');
        },
        success: function (res) {
        // alert('已分享');
        },
        cancel: function (res) {
        	// alert('已取消');
        },
        fail: function (res) {
        alert(JSON.stringify(res));
        }
    });
    // alert('已注册获取“发送给朋友”状态事件');

	// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口

    wx.onMenuShareTimeline({
        title: '<?php echo "51易货网拼团";?>',
        link: '<?php echo site_url('goods/detail').'/'.$details['id'].'/0/groupbuy';?>',
        imgUrl: '<?php echo IMAGE_URL.$details['goods_thumb'];?>',
        trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
        // alert('用户点击分享到朋友圈');
        },
        success: function (res) {
        // alert('已分享');
        },
        cancel: function (res) {
        // alert('已取消');
        },
        fail: function (res) {
        alert(JSON.stringify(res));
        }
    });
    // alert('已注册获取“分享到朋友圈”状态事件');
    
});
</script>    