<script>var base_url = "<?php echo site_url();?>";</script>
<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>
<script type="text/javascript"	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php 
if($this->session->userdata('app_info')['wechat_appid'] != NULL):
$this->load->library("js_api_sdk");
$this->js_api_sdk = new js_api_sdk();
$this->js_api_sdk->init($this->session->userdata('app_info')['wechat_appid'], $this->session->userdata('app_info')['wechat_appsecret']);
$signPackage = $this->js_api_sdk->GetSignPackage();
?>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
      debug: false,
      appId: '<?php echo $this->session->userdata('app_info')['wechat_appid'];?>',
      timestamp: '<?php echo $signPackage["timestamp"];?>',
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'onMenuShareTimeline',
      ]
  });
  wx.ready(function(){
	  wx.onMenuShareAppMessage({
	      title: '<?php echo $details['name'];?>',
	      desc: '我在51易货网发现了一款不错的商品，赶快来看看吧!',
	      link: '<?php echo site_url("Goods/detail").'/'.$details['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$details['goods_img'];?>',
	      trigger: function (res) {
// 	        alert('用户点击发送给朋友');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareTimeline({
	      title: '<?php echo $details['name'];?>',
	      link: '<?php echo site_url("Goods/detail").'/'.$details['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$details['goods_img'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareQQ({
	      title: '<?php echo $details['name'];?>',
	      desc:  '我在51易货网发现了一款不错的商品，赶快来看看吧!',
	      link: '<?php echo site_url("Goods/detail").'/'.$details['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$details['goods_img'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到QQ');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  wx.onMenuShareWeibo({
	      title: '<?php echo $details['name'];?>',
	      desc: '我在51易货网发现了一款不错的商品，赶快来看看吧!',
	      link: '<?php echo site_url("Goods/detail").'/'.$details['id'];?>',
	      imgUrl: '<?php echo IMAGE_URL.$details['goods_img'];?>',
	      trigger: function (res) {
// 	        alert('用户点击分享到微博');
	      },
	      complete: function (res) {
// 	        alert(JSON.stringify(res));
	      },
	      success: function (res) {
// 	        alert('已分享');
	      },
	      cancel: function (res) {
// 	        alert('已取消');
	      },
	      fail: function (res) {
// 	        alert(JSON.stringify(res));
	      }
	    });
	  });
</script>
<?php
		 endif;
		?>
<?php //购物车数量
$cartcount = 0;
foreach($this->cart->contents() as $items){
    $cartcount = $cartcount + $items['qty'];
}
?>
<style type="text/css">.page{padding-top:0px;}.footer{bottom:0px;}</style>
    <div style="position:fixed;top:10px;left:10px;z-index: 9999;">
        <a href="javascript:Goback()" style="padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(0,0,0,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
        <a href="<?php echo site_url("Cart");?>" class="cart" style="right:10px;"><span class="icon-gouwuche1" style="font-size: 20px;color:#fff;" ></span>
            <span class="cart_num2" id="GoodsCart"><?php if($cartcount>99){echo '99+<style type="text/css">.cart_num2{width:25px;}</style>';}else{ echo $cartcount;}?></span>
        </a>
    <a href="javascript:void(0);" id="onMenuShareAppMessage" class="share" style="display: none;"><span class="icon-fenxiang" ></span></a>
    </div>
    
    <div class="page clearfix">
        <!-- 商品图片开始 -->
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
        <!-- 商品图片结束 -->
    
        <div class="product">
            <h1><?php echo $details['name'];?></h1>
            <h2><?php echo $details['short_desc'];?></h2>
            
            <?php if($is_special){;?>
            <lable class="item" id="special_price_item" >特价&nbsp;&nbsp;
            	<span class="red" style="font-size: 15px;font-weight: bold;" id="special_price">
        		<?php echo number_format($details['special_price'],2); ?>货豆
            	</span>
            </lable>
            <?php }else if($tribeVIP){;?>
            <lable class="item" id="special_price_item" >部落价&nbsp;&nbsp;
            	<span class="red" style="font-size: 15px;font-weight: bold;" id="tribe_price">
        		<?php echo number_format($details['tribe_price'],2); ?>货豆
            	</span>
            </lable>
            <?php }; ?>
            
            <?php if($details['cat_id'] != 104164){;?><!-- 共享服务分类104164 -->
            <lable class="item" id="product_price_item">易货价<em style="opacity: 0;">&nbsp;&nbsp;&nbsp;</em>
                <span class="red" id="product_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 5px;">
                <?php if($is_special || $tribeVIP){?><!-- 如是特价or部落则有del -->
        		   <del><?php echo number_format($details['vip_price'], 2);?>货豆</del>
        		<?php }else{;?>
        		   <?php echo number_format($details['vip_price'], 2);?>货豆
        		<?php };?>
                </span>
            </lable>
            <?php };?>
            
            <?php if($details['market_price']){;?>
              <lable class="item" id="product_price_item">参考价<em style="opacity: 0;">&nbsp;&nbsp;&nbsp;</em>
                <span class="red" id="market_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 5px;">
            		<?php echo $details['market_price'];?>
                </span>
            </lable>
            <?php };?>    
              
            <lable style="float: right;margin-top:-30px;">
            <?php if($details['latitude'] && $details['longitude']){?>
            <!-- 定位 -->
            <div class="detail_dingwei">
                <!-- 百度 -->
            	<a href='http://api.map.baidu.com/marker?location=<?php echo $details['latitude'];?>,<?php echo $details['longitude'];?>&title=<?php echo isset($details['address'])?$details['address']:'51易货网';?>&output=html' class="icon-dingwei1" style="font-size:18px;color:#999999;">
            		<span style="font-size:12px;color:#999999;text-overflow:ellipsis;"><?php //echo $city;?>导航</span>
            	</a>
            </div>
            <?php };?>
            <!-- 商品收藏 -->
            <a href="javascript:add_to_fav(<?php echo $details['id'];?>)" style="float:right;">
                <?php if($fav){?>
                	<span id="xin" class="custom_color shoucang02 icon-xinshixin" style="font-size: 20px; color:#fe4101; padding-left: 10px;"></span>
                <?php }else{?>
                	<span id="xin" class="icon-shoucang1 shoucang02" style="font-size:20px;color:#6A6A6A;padding-left: 10px;"></span>
                <?php };?>
            </a>
            </lable>
        </lable>
        
        <div class="line"></div>
        <lable class="item"  <?php echo $details['cat_id'] == 104164?"style='display:none'":null; ?>>库存<!-- 共享服务分类104164 -->
            <em style="opacity: 0;">测试</em>&nbsp;&nbsp;
            <span id="stock" style="color: #333333;font-weight: bold;padding-left: 1px;"><?php echo number_format($details['stock']);?></span>
        </lable>
        
        <!-- SKU显示 -->
        <div id="sku">
        <?php  
        if($details['is_on_sale'] == 1 && $details['is_delete']==0 && $attr_sku && $skuinfo){
            $i=0;//默认选择第一个
            $html = "";
            foreach($attr_sku as $val){
                $html .= '<lable class="item">'.$val['attr_name'].'</lable>';
                $html .= '<div class="details_goods_list">';
                $html .= '<ul class="add_cart_size_list">';
                    foreach($val["sku_name"] as $k=>$v){
                        if($i==0){
                            $html .= '<input type="hidden" name="sku[]" value="'.$k.'">';//选中的sku
                        }
                        $html .= '<li '.($i==0?"class=active":"").' onclick="selectSKU(this,\''.$k.'\')">'.$v.'</li>';
                        $i++;
                    }
                $html .= '</ul>';
                $html .= '</div>';
                $i=0;
            }
            echo $html;
        }
        ?>  
        </div>
        <!-- SKU结束 -->

        
        <lable class="item detail-itme-num">数量</lable>
        <span class="add-del">
            <a href="javascript:void(0);" onclick="reduce();" class="btn-del num_oper num_min detail-jian-num"><span>－</span></a>
            <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1" onkeyup="modify();" />
            <a href="javascript:void(0);" onclick="add();" class="btn-add num_oper num_plus"><span >+</span></a>
        </span>
        
        <lable class="item detail-xiaoji-num">小计
            <em style="opacity: 0;">测试</em>
            <span class="red" id="total_price" style="color: #333333;font-size: 15px;font-weight: bold;padding-left:8px;">                
            <?php 
                if($is_special){//特价
                    echo number_format($details['special_price'], 2)."货豆";
                }else if($tribeVIP){//部落价
                    echo number_format($details['tribe_price'], 2)."货豆";
                }else{ //易货价
                    echo number_format($details['vip_price'], 2)."货豆";
                };
            ?>
            </span>
        </lable>
        
        <p class="caution_tips" id="item-error" style="display:none;"></p>
        <?php if(!$details["is_freight"]){;?>
        <lable class="item" <?php echo $details['cat_id'] == 104164?"style='display:none'":null; ?>>运费<em style="opacity: 0;">测试</em><!-- 共享服务分类104164 -->
        <span class="red" id="freight" style="color: #333333;font-size: 15px;font-weight: bold;padding-left: 8px;"><?php echo "免运费";?></span>
        </lable>
        <?php };?>
        
         <!-- 店铺名 -->
        <div class="shop-name" hidden><!-- 暂时隐藏 -->
            <div class="shop-name-main">
                <span class="icon-shop shop-icon"></span>
                <span class="shop-name-text"><?php echo $corporation["corporation_name"];?></span>
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
        

        <!-- <div class="line"></div> -->
        <lable class="item">商品图片:</lable>
        <div><?php echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.IMAGE_URL,$details['desc']);?></div>
        
        </div><!--product end-->
    
        </div><!--page end-->
             <div class="footer">
                <ul class="nav-tab" id="AddCart">
                    <li><a href="javascript:void(0);" onclick="add_to_cart(<?php echo $details['id'];?>,0,2);" class="button bg-color">立即购买</a></li>
                    <li><a href="javascript:void(0);" onclick="add_to_cart(<?php echo $details['id'];?>,0,1);" class="button bg-red custom_button">加入购物车</a></li>
                </ul>
            </div>
        </div>

        <!--分享-->
        <div id="mcover" onclick="document.getElementById('mcover').style.display='';" style="display: none;">
             <img src="images/share.png">
        </div>
<script type="text/javascript" src="js/ShoppingCart.js" /></script>
<script type="text/javascript">
$(function(){
	//判断是否符合条件才执行
	<?php  if($details['is_on_sale'] == 1 && $details['is_delete']==0 && $attr_sku && $skuinfo){ ?>
	skuinfo = JSON.parse('<?php echo json_encode($skuinfo);?>');//SKU信息集合
	process();
	<?php };?>

	//广告图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });

    //数量、套餐切换
    TouchSlide({
        slideCell: "#leftTabBox"
    });
});
  	
//验证item_num，返回数量 mode模式：'-'减法，'+'减法，默认加入购物车
function check_item_num(mode){
    var status = true;//默认成功
    var x=$("#item_num").val();//加入购物车数量
    var max = parseInt($('#stock').text());//获取库存数量
    var is_num = new RegExp("^[1-9]\\d*$").test(x);//验证数据类型
    if(is_num){
        if(mode=='-'){
        	x--;
            if(x <= 0){
                var content = "商品数量最少为1!"; 
                var status = false;
            }else{
            	jQuery("#item_num").val(x);
            }
        }else if(mode=='+'){
            x++;
            if(max < x){
                var content = "数量不能超过库存!"; 
                var status = false;
            }else{
            	jQuery("#item_num").val(x);
            }
        }else{
        	if(max < x){
        		$("#item_num").val(max)
                var content = "购买数量不能超过库存!"; 
                $(".black_feds").text(content).show();
            	setTimeout("prompt();", 600); 
                return max;
            }
        }

    }else{
    	var content = "请输入正确的数量!"; 
    	var status = false;
    }
    if(status){
        return x;
    }else{
    	$(".black_feds").text(content).show();
    	setTimeout("prompt();", 600); 
        return false;
    }
}


//数量减法
function reduce(){
	x = check_item_num("-");//验证item_num
    if (x) {
		<?php  if($details['is_on_sale'] == 1 && $details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>

    }
}

//数量加法
function add(){
	x = check_item_num("+");//验证item_num
    if (x) {
		<?php  if($details['is_on_sale'] == 1 && $details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>
    }
}

//输入item_num
function modify(){
	//验证item_num
	x = check_item_num();
	if(x){
		<?php  if($details['is_on_sale'] == 1 && $details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>
	}
}

//普通商品结算
function settlement(){
	<?php if ($is_special) {?>//特价
        var price = "<?php echo $details['special_price'];?>";
    <?php }else if($tribeVIP){;?>//部落价
        var price = "<?php echo $details['tribe_price'];?>";
    <?php }else{;?>//易货价
        var price = "<?php echo $details['vip_price'];?>";
    <?php };?>
	//验证item_num,数据不正确则默认1
	var item_num = check_item_num();
	if(!item_num){
	    var item_num = 1;
	}
	var total_price = price*item_num;//总价
	$("#total_price").html(formatCurrency(total_price)+"货豆");//总价显示

}

//加入购物车，pid商品id，sku_id，type:1加入购物车2立即购买
function add_to_cart(pid,sku_id,type)
{
	var qty = check_item_num();//验证item_num
	if(qty){
		add_cart(pid,qty,sku_id,type);
	}
}
</script>


<!-- sku操作开始 -->
<script>
//选择sku
function selectSKU(obj,attr_sku){
	$(obj).parent().find("li").removeClass();
	$(obj).addClass("active");
	$(obj).parent().find("input[name='sku[]']").val(attr_sku);
	process();
}

//sku处理
function process(){
	//拼接选中的sku集合
    var sku_val = "";
	$("input[name='sku[]']").each(function () {
        if(!sku_val){
            sku_val = $(this).val();
        }else{
        	sku_val += ":"+$(this).val();
        }
    });

    //循环匹配sku组合信息
	var html = "";
    jQuery.each(skuinfo, function(sku_id, val) {
        if(val["sku"]==sku_val){
		    var special_price = val['info']['special_price'];//特价
		    var tribe_price = val['info']['tribe_price'];//特价
		    var vip_price = val['info']['vip_price'];//易货价
		    $("#special_price").html(special_price);//特价显示
		    $("#tribe_price").html(tribe_price);//部落价显示
		    $("#product_price").html("<del>"+vip_price+"货豆</del>");//易货价显示

        	//是否特价
			<?php if ($is_special) {?>//特价
			    var price = special_price;
			    $("#special_price").html(special_price+'货豆');//特价显示
			    $("#product_price").html("<del>"+vip_price+"货豆</del>");//易货价显示
		    <?php }else if($tribeVIP){;?> //部落价
		        var price = tribe_price;
    		    $("#tribe_price").html(tribe_price+"货豆");//部落价显示
			<?php }else{;?>//易货价
			    var price = vip_price; 
			    $("#product_price").html(vip_price+"货豆");//易货价显示
			<?php };?>

			var stock = val['info']['stock'];//库存
			$("#stock").html(stock);//库存显示
			
			//验证item_num,数据不正确则默认1
			var item_num = check_item_num();
			if(!item_num){
			    var item_num = 1;
			}
			
			var total_price = price*item_num;//总价
			$("#total_price").html(formatCurrency(total_price)+"货豆");//总价显示
			

        	//判断库存
            if(val['info']['stock']>0){
				html += '<li><a href="javascript:void(0);" onclick="add_to_cart(<?php echo $details['id'];?>,'+sku_id+',2);" class="button bg-color">立即购买</a></li>';
                html += '<li><a href="javascript:void(0);" onclick="add_to_cart(<?php echo $details['id'];?>,'+sku_id+',1);" class="button bg-red">加入购物车</a></li>';
                $("#AddCart").html(html);//加入购物车操作显示
            }else{
                //缺货执行
            }
            
            return false;
        }
    }); 

}
function Goback(){
	if(window.history.length >1){
			window.history.back();
		}else{
			window.location.href = '<?php echo site_url("Home")?>';
		}
}

</script>
<!-- sku操作接结束 -->

