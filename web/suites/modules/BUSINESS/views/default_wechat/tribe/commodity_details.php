<script>var base_url = "<?php echo site_url();?>";</script>
<!-- H5全局提示文本框 -->
<span class="black_feds" style="z-index: 999;">51易货网</span>
<script type="text/javascript"  src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<style type="text/css">.page{padding-top:0px;}.footer{bottom:0px;}</style>
    <div style="position:fixed;top:10px;left:10px;z-index: 9999;">
        <a href="javascript:Goback()" style="padding-top:7px;width: 35px;height: 35px;display:inline-block;background:rgba(0,0,0,0.4);border-radius: 50%;text-align: center;-webkit-transform: rotate(180deg);"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
    <a href="javascript:void(0);" id="onMenuShareAppMessage" class="share" style="display: none;"><span class="icon-fenxiang" ></span></a>
    </div>
    <div class="page clearfix">
      <!-- 商品图片开始 -->
        <div class="swiper-container">
            <div class="swiper-wrapper">    
            	<?php 
            	foreach ($data as $image){
            	        ?>
                <div class="swiper-slide maximg_480">
                    <img src="<?php echo IMAGE_URL.substr($image['img_path'],2);?>" alt="" onerror="this.src='images/default_img_b.jpg'">
                </div>
                <?php  }?>
              	
           </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div><!--swiper-container end-->
        <!-- 商品图片结束 -->
        <div class="product">
            <h1><?php echo $data['0']['product_name'];?></h1>
            <h2><?php echo $data['0']['desc'];?></h2>
            
            <lable class="item" id="special_price_item" >特价&nbsp;&nbsp;
                <span class="red" style="font-size: 15px;font-weight: bold;" id="special_price">
               <?php echo $data['0']['price'];?>元
                </span>
            </lable>              
        <lable class="item">库存&nbsp;&nbsp;<!-- 共享服务分类104164 -->
            <span id="stock" style="color: #333333;font-weight: bold;padding-left: 1px;"><?php echo $data['0']['stock'];?></span>
        </lable>    
        <lable class="item detail-itme-num" style="width:40px">数量</lable>
        <span class="add-del">
            <a href="javascript:void(0);" onclick="reduce();" class="btn-del num_oper num_min detail-jian-num"><span>－</span></a>
            <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1" onblur="modify();" />
            <a href="javascript:void(0);" onclick="add();" class="btn-add num_oper num_plus"><span >+</span></a>
        </span>
        
        <lable class="item detail-xiaoji-num">合计
            <span class="red" id="total_price" style="font-size: 15px;font-weight: bold;padding-left:8px;">       
            <?php echo $data['0']['price'];?></span><span> 元      
            </span>
        </lable>
      
		 <!-- <div class="line"></div> -->
        <lable class="item">商品图片:</lable>
        		<?php 
            	foreach ($data as $image){
            	?>
                <div class="commodity_details_img">
                    <img src="<?php echo IMAGE_URL.substr($image['img_path'],2);?>" alt="" onerror="this.src='images/default_img_b.jpg'">
                </div>
                <?php  }?>
        
        </div><!--product end-->
    
        </div><!--page end-->
             <div class="footer">
                <ul class="nav-tab" id="AddCart">
                    <li style="width:100%"><a href="javascript:void(0);" onclick="" class="button bg-color">立即购买</a></li>
                </ul>
            </div>
        </div>


<script type="text/javascript" src="js/ShoppingCart.js" /></script>
<script type="text/javascript">

    //广告图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        autoplay : 5000,
    });

   
            var stock = val['info']['stock'];//库存
            $("#stock").html(stock);//库存显示 
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

function add () {
	var price = <?php echo $data['0']['price'];?>;
	var stock = <?php echo $data['0']['stock'];?>;
	var item_num = document.getElementById('item_num').value;
	item_num = item_num * 1 +1;
	document.getElementById('item_num').value = item_num;
	if (item_num > stock) {
		document.getElementById('item_num').value = stock;
		var count = price * stock;
	} else {
		var count = price * item_num;
	}
	document.getElementById('total_price').innerText = count;
	
	
}

function reduce () {
	var price = <?php echo $data['0']['price'];?>;
	var item_num = document.getElementById('item_num').value;
	item_num = item_num * 1 -1;
	if (item_num < 1) {
		item_num = 1;
	}
	document.getElementById('item_num').value = item_num;
	var count = price * item_num;
	document.getElementById('total_price').innerText = count;
}

function modify () {
	var stock = <?php echo $data['0']['stock'];?>;
	var price = <?php echo $data['0']['price'];?>;
	var item_num = document.getElementById('item_num').value;
	var re = /^\+?[1-9][0-9]*$/;
    if (re.test(item_num) == false) {
    	document.getElementById('item_num').value = 1;
    }
    var pp = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
    if (pp.test(item_num) == true) {
    	document.getElementById('item_num').value = parseInt(item_num);
    	if (item_num > stock) {
    		document.getElementById('item_num').value = stock;
    	}
    }
    var item_num = document.getElementById('item_num').value;
    var count = price * item_num;
	document.getElementById('total_price').innerText = count;

    
}






</script>

