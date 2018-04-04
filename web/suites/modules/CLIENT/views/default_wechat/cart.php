<script type="text/javascript" src="js/ShoppingCart.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$(':radio[name="address_id"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="new")
		{
			if($('#consignee_from').length < 1)
			{
				showForm_consignee(this);
			}
		}else{
			if($('#consignee_from').length > 0)
			{
				$('#consignee_from').remove();
				isNewCon = false;
			}

		}
	});
	$(':radio[name="is_invoice"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="1"){
			$('#invoice_from').toggle('show');
		}else{
			$('#invoice_from').toggle('hidden');
		}
	});
});
//-->
 
<?php
if (isset($message) && $message != "") {
    echo "alert('" . $message . "')";
}
$count_cart = count($this->cart->contents());
?>
</script>
<div class="page clearfix">
	<div class="order_cart">
		<form action="<?php echo site_url("order") ?>" method="get" id="form" style="padding-bottom: 50px;">
		
		<?php
        if ($count_cart === 0) :
        ?>
		<!--购物车没有商品状态 开始  .group-cart和.footer需要display="none;" , .tips-none 需要display="block;"  -->
			<div class="tips-none">
				<em class="icon-gouwuche"></em>
				<p>购物车内暂无商品</p>
				<a href="<?php echo site_url('Home');?>" class="red-but">随便看看</a>
			</div>
		<?php 
		endif;
		?>
		<!--tips-none end-->
			<!--购物车没有商品状态 结束  .group-cart和.footer需要display="block; , .tips-none 需要display="none;" -->
			<!--购物车有商品状态 开始  .group-cart和.footer需要display="block; , .tips-none 需要display="none;" -->

			<!--店铺01 开始-->
			<!--新增店铺信息 开始-->
			<?php  
			$product = $this->cart->contents(); if (count($product) > 0) :?>
            <ul>

             <li>
				<label class="yCheckbox" style="margin-top: -10px;">
					<em class="checkbox_id choose_all" onclick="choose_all(this)"></em>
					<!--选中添加上面<em class="icon-roundcheckfill">，未选中取消class里面的icon-roundcheckfill-->
				</label>
				<span style="margin-left: 25px; line-height: 30px;"><span class="icon-shop" style="margin-right: 5px;"></span>全选</span>
			</li>

			<!--新增店铺信息 结束-->
			<?php
            $data['foot_set'] = 5;
            
                foreach ($product as $items) {
                    $cart[] = $items['corporation_id'];
                }
                array_multisort($cart, SORT_ASC, $product);
                
                $id = 0;
                $judge = 0;
                $i = 0;
                $total_qty = 0;
                foreach ($product as $key => $item) :
                    $id = $item['corporation_id'];
                if($item['corporation_id']==$id && $judge != $item['corporation_id']): ?>
             
             
             
				<li>
    				<label class="yCheckbox" style="margin-top: -10px;">
    					<em class="checkbox_id corp_<?php echo $item['corporation_id'] ?>" id="corp_<?php echo $item['corporation_id'] ?>" onclick="select_all(this,<?php echo $item['corporation_id'] ?>)"></em>
						<!--选中添加上面<em class="icon-roundcheckfill">，未选中取消class里面的icon-roundcheckfill-->
    				</label>
    				<span style="margin-left: 25px; line-height: 30px;"><span class="icon-shop" style="margin-right: 5px;"></span> <?php echo $item['corporation_name'] ?></span>
				</li>
			</ul>
			<ul class="order-list">
            <?php foreach ($product as $items): ?>
            <?php if($items['corporation_id']==$id): ?>
                <li style="<?php echo $items['product_status'] == 'no_sale' ? 'background-color:#EEE9E9;' :'' ?>">
                	<label class="yCheckbox">
                	    <?php if( $items['product_status'] == 'no_sale'): ?>
                		    <em></em>
                		<?php else:?>
                		    <em class="checkbox_id product_checkbox corp_<?php echo $items['corporation_id']?>" id="<?php echo $items['id'] ?>" onclick="product_radio(this,<?php echo $items['corporation_id']?>)"></em>
                		<?php endif;?>
                		<!--选中状态-->
    					<input type="hidden" class="selected_info" value="<?php echo $items['rowid'] ?>">
    					      
						<!--选中添加上面<em class="icon-roundcheckfill">，未选中取消class里面的icon-roundcheckfill-->
					</label>
					
    				<a class="link" href="<?php echo $items['product_status'] == 'no_sale' ? 'javascript:;' : site_url('Goods/detail/'.$items['id']) ?>">
    					<span class="goods_img">
    						<img src="<?php echo IMAGE_URL.$items['options']['goods_img'];?>" alt="<?php echo $items['name'];?>" onerror="this.src='images/default_img_b.jpg'">
    					</span>
    			    </a>
    					<div class="order_info">
    						<a href="<?php echo site_url('goods/detail/'.$items['product_id']); ?>"  style="margin: 0;"><h2><?php echo $items['name'];?></h2></a>
    						<p class="mm01_font1">
    						
                            <?php if(isset($items['sku_name'])&&$items['sku_name']!=null): ?>
                                <?php foreach ($items['sku_name'] as $sku_name): ?>
                                      <span><?php echo $sku_name ?></span>
                                <?php endforeach; ?>
                            <?php endif;?>
                            <span id="no_sale_messgae_<?php echo $items['id']?>"><?php echo $items['product_status'] == 'no_sale' ? '(商品失效)' :'' ?></span>
                            </p>
                            
                            <?php if( $items['product_status'] == 'no_sale'): ?>
                		    <p class="mm01_font2" style="position: relative;">
    						<a style=" position: absolute; width: 60%;height: 32px;"></a> 
    						
                    		<?php else:?>
                    	    <p class="mm01_font2" id="on_sale_<?php echo $items['id']?>">	 
                		 	<?php endif;?>
                		 		<a class="gouwuche_jian" href="javascript:jQuery.reduce('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id'] ?>,'<?php echo isset($items["cid"])?$items["cid"]:"" ?>');">－</a>
    							<input type="text" class="gouwuche_input" id="item_num<?php echo $items['id']; ?>"  value="<?php echo $items['qty'];?>" onblur="num_is_ok(this)" onkeyup="jQuery.modify('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id']?>,'<?php echo isset($items["sku_id"])&&$items["sku_id"]!=null?$items["sku_id"]:"" ?>','<?php echo isset($items["cid"])?$items["cid"]:"" ?>');"<?php echo $items['product_status'] == 'no_sale' ? 'readonly' :'' ?> >
    							<input type="hidden" class="gouwuche_input"  value="<?php echo $items['qty'];?>" id="qty_<?php echo $items['id']; ?>" readonly>
                                   
    							<a class="gouwuche_jia" href="javascript:jQuery.add('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id']?>,'<?php echo isset($items["sku_id"])&&$items["sku_id"]!=null?$items["sku_id"]:"" ?>','<?php echo isset($items["cid"])?$items["cid"]:"" ?>')">+</a>
    							<input type="hidden" id="item_num<?php echo $items['id'] ?>" value="<?php echo $items['qty'] ?>">
    							<input type="hidden" id="stock_<?php echo $items['id'] ?>" value="">
    							<input type="hidden" id="price_input_<?php echo $items['id'] ?>" value="<?php echo number_format($items['price'],2,'.','');?>">
    							
    							<?php echo $items['product_status'] == 'no_stock' ? '<span id="no_stock" style="color:red">&nbsp;库存不足</span>' :'' ?>
    							    
    						</p>
    						<p class="order_price"> <!-- 单价： --> </p>
    						<p class="order_price" id="price_<?php echo $items['id'] ?>"><?php echo number_format($items['price'],2,'.','');?></p>
    						<p class="order_price">&nbsp;货豆</p>
    					</div>
    			
    				<em class="remove_goods">X</em>
					<p class="delete_from_order">
						<a href="javascript:void(0);" onclick="login('<?php echo $items['rowid']; ?>',0,'<?php echo $items['cid'] ?>','<?php echo $items['id'] ?>');">
							<em class="icon-favorfill"></em> 移入收藏夹
						</a>
						<a href="javascript:void(0);" onclick="remove_product('<?php echo $items['rowid']; ?>','<?php echo $items['cid'] ?>');">
							<em class="">X</em> 删除
						</a>
					</p>
				</li>
        	     <?php $judge = $items['corporation_id'];?>
				 <?php endif; ?>
				 <?php endforeach; ?>
				  </ul>
				 <?php elseif($id!=$item['corporation_id']):$id=$item['corporation_id']; ?>
               
				 <?php endif;?>
                 <?php endforeach;?>
                 <?php endif;?>
			<!--orderList end-->
			<!--店铺01 结束-->

			<!--购物车没有商品状态 结束  .group-cart和.footer需要display="none;" -->
		</form>
		<input type="text" id="freight_total" hidden>
	</div>
	<!--order-cart end-->
	</div>
<!--page end-->

<!--footer end-->

<?php if ($count_cart > 0):?>
<div class="footer02"
	style="position: fixed; bottom: 50px; left: 0px; width: 100%;">
	<ul>
		<li
			style="float: left; width: 70%; background-color: #000000; height: 40px; color: #fff; line-height: 40px; text-align: center; font-size: 15px;">
			<div class="price-sum">
			    <p class="f16" id="total_freight" style="line-height: 22px; text-align:left;color:#ccc">
					<span>运费: 0 货豆</span>
				</p>
				
				<p class="f16" id="price_total" style="line-height: 22px;">
					<span>0</span>件总计: 0.00 货豆<span style="margin-left: 5px;"></span>
				</p>
			</div>
		</li>
		<li
			style="float: right; width: 30%; background-color: #fe4101; height: 40px; color: #fff; line-height: 40px; text-align: center; font-size: 15px;">
			<a href="javascript:submitform();" style="color: #fff;">去结算</a>
		</li>
	</ul>
</div>
<?php endif;?>

<script type="text/javascript">

$(document).ready(function(){
	//按删除按钮显示收藏、删除按钮
	$(".remove_goods").on("touchstart",function(e){
		var parent = e.target.parentNode;
	    $(".delete_from_order").animate({right:'-204px'},"fast");
	    $(parent).find(".delete_from_order").animate({right:'0px'},"fast");
		 $(".bg1").show();
		  $(".bg1").on("touchstart",function(){
	      $(".bg1").hide();
	      $(".delete_from_order").animate({right:'-204px'},"fast");
		});
	})
  

});


function submitform(){

	if( $(".icon-roundcheckfill.product_checkbox").length > 0 ){
		
		$('#form').submit();
		
	}else{
		 $(".black_feds").text("请选择商品！").show();
	     	setTimeout("prompt();", 2000);
	}

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
//     num = num.substring(0,num.length-(4*i+3))+','+  
     num = num.substring(0,num.length-(4*i+3))+','+  
    num.substring(num.length-(4*i+3));  
    return (((sign)?'':'-') + num + '.' + cents);  
}


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
        	setTimeout("prompt();", 1000);
        }  
        return x;  
    },  
    reduce : function(obj,id,cor_id,cid) {

   	 var x = this.amount('#item_num'+obj, false);  
		var price = $('#item_price_'+obj).html();
		
      if (parseInt(x) >= this.min) {  
          jQuery('#item_num'+obj).val(x);  
		  $("#item_totla_"+obj).text((price * x).toFixed(2));
		  ajax_update(id,x,null,cid,obj,cor_id);

		  $('#tip_'+obj).html("");
          $('#tip_'+obj).hide();
      } else {  
    	  $(".black_feds").text("商品数量最少为"+this.min).show();
          setTimeout("prompt();", 1000);
      }  
//       recountTotal(cor_id);
      total();  
      $("#no_stock").text('');
       
    },  
    add : function(obj,id,cor_id,sku_id,cid) {
        
   	    var x = this.amount('#item_num'+obj, true);
     
		var price = $('#item_price_'+obj).html();
		ajax_update(id,x,null,cid,obj,cor_id);
		
		var max = $('#stock_'+obj).val();
		
		if( max ){
			
            if (parseInt(x)<=max) {
              
              jQuery('#item_num'+obj).val(x);  

            } else {
                
        	    $(".black_feds").text("商品数量已超过库存").show();
                setTimeout("prompt();", 1000);  
                jQuery('#item_num'+obj).val(max == 0 ? 1 : max);  
                jQuery('#item_num'+obj).focus();  
            } 
		}
		total(); 
		$("#no_stock").text('');
         
    },  
    modify : function(obj,id,cor_id,sku_id,cid) {  
        var x = $('#item_num'+obj).val();  
        if( !x )
        {
           return;
        } 
        var price = $('#price_'+obj).html();
        ajax_update(id,x,null,cid,obj,cor_id);
        var max = $('#stock_'+obj).val(); 

        if (isNaN(x)) {
            
            jQuery('#item_num'+obj).val(1);  
            jQuery('#item_num'+obj).focus();  
            return;  
        } 

        var intx = parseInt(x);  
        var intmax = parseInt(max);  
        
        if (intx < this.min) {  
            $(".black_feds").text("商品数量最少为"+this.min).show();
            setTimeout("prompt();", 1000);
            jQuery('#item-error').show();  
            jQuery('#item_num'+obj).val(this.min);  
            jQuery('#item_num'+obj).focus();  
			return;
        } else if (intx > intmax) {  
        	$(".black_feds").text("商品数量已超过库存").show();
        	setTimeout("prompt();", 1000);
            jQuery('#item-error').show();  
            $('#item_num'+obj).val(max == 0 ? 1 : max);  
            $('#item_num'+obj).focus();  
			return;
        } 
        total(); 
        
		$("#no_stock").text('');
    }
    
    
});

//全选
function choose_all(obj)
{ 

	var iam = $(obj);
    
    if( iam.hasClass('icon-roundcheckfill') )
    {
    	$('.checkbox_id').removeClass('icon-roundcheckfill');
    	$('.checkbox_id').next().removeAttr('name');
		
    }else{
    	$('.checkbox_id').addClass('icon-roundcheckfill');
    	$('.checkbox_id').next().attr('name','item[]');
		
    }
	

    total();
}

//店铺全选
function select_all(obj,id){
	var iam = $(obj);
	var product_obj = $('.corp_'+id);
	var checkbox_obj = $('.checkbox_id');
	
	 if( iam.hasClass('icon-roundcheckfill') )
	 {
    	$('.corp_'+id).removeClass('icon-roundcheckfill');
    	$('.choose_all').removeClass('icon-roundcheckfill');
    	$(product_obj).next().removeAttr('name');
     }else{
    	$('.corp_'+id).addClass('icon-roundcheckfill');
    	$(product_obj).next().attr('name','item[]');
     }

	 total();
	 
	 //判断是否全部选中
	 if( $(".checkbox_id.icon-roundcheckfill").length == ( checkbox_obj.length-1 )   )
	 { 
		 $('.choose_all').addClass('icon-roundcheckfill');
	 }else{ 
		 $('.choose_all').removeClass('icon-roundcheckfill');
	 }
	
	 
}

//单选
function product_radio(obj,id){
	var iam = $(obj);
	var corp_product_num = $('.corp_'+id).length - 1;
	var corp_product_obj = $('.corp_'+id);
	var checkbox_obj = $('.checkbox_id');
	
	 if( iam.hasClass('icon-roundcheckfill') )
	 {
    	$(iam).removeClass('icon-roundcheckfill');
    	$(iam).removeClass('icon-roundcheckfill');
    	$(iam).next().removeAttr('name');
    	
     }else{
    	$(iam).addClass('icon-roundcheckfill');
    	$(iam).next().attr('name','item[]');
     }
	 total();

	 //判断店铺是否需要店铺全选
	 if( $(".corp_"+id+".icon-roundcheckfill").length == corp_product_num && !$('#corp_'+id).hasClass('icon-roundcheckfill') )
	 { 
		 $('#corp_'+id).addClass('icon-roundcheckfill');
	 }else{ 
		 $('#corp_'+id).removeClass('icon-roundcheckfill');
	 }

		//判断是否全部选中
	 if( $(".checkbox_id.icon-roundcheckfill").length == ( checkbox_obj.length-1 )   )
	 { 
		 $('.choose_all').addClass('icon-roundcheckfill');
	 }else{ 
		 $('.choose_all').removeClass('icon-roundcheckfill');
	 }
	 

	 
}

//公共统计方法。
function total(){ 

	var obj_all = $('.checkbox_id');

	var total_price = 0.00;
    var total_num = 0;
	
	for(j = 0; j<obj_all.length; j++){ 

	   if( $(obj_all[j]).hasClass('icon-roundcheckfill') && $(obj_all[j]).hasClass('product_checkbox') )
	   {
	       var id = $(obj_all[j]).attr('id');
	       var price = $(obj_all[j]).parent().parent().find('#price_'+id).text();
	       var num = $(obj_all[j]).parent().parent().find('#item_num'+id).val();

	       total_num += parseInt(num);
	       
	       total_price += parseFloat(price) * parseInt(num);
	   }
	}

	total_num = total_num ? total_num : 0;
	$('#price_total').html("<span>"+total_num+"</span >件总计: <span id='total_m'>"+formatCurrency(total_price)+"</span> 货豆");
}


/**
 * 实时查询商品库存
 */
function check_stock(obj,id,status){
	$.ajax({
		url:"<?php echo site_url("corporate/product/check_stock"); ?>/"+status,
	    type:"get",
	    data:{val_id:id},
	    success:function(data){
		    var data = jQuery.parseJSON(data);
	        $("#stock_"+obj).val(data.stock);
		}
    });
}

/**
 * 未登录跳转到登录
 */
function login(rowid, obj,cid,pid){
	
	<?php if(!$this->session->userdata("user_id")):?>
	$(".black_feds").text("请登陆").show();
	setTimeout("prompt();", 5000);  
    window.location.href = "<?php echo site_url('customer/login');?>";
	<?php else:?>
	$.ajax({
		url:"<?php echo site_url("member/fav/ajax_check"); ?>",
		type : 'POST',
		data : {
			'id' : pid
		},
		dataType : 'html',
		success : function(data) {
			if(data=='true'){
				$(".black_feds").text("收藏夹已存在该商品").show();
				setTimeout("prompt();", 5000);  
			}else{
				add_to_favorite(rowid, obj, cid, pid);
			}
		}
	});
	<?php endif;?>
}


// function count_freight(product_id_array,freight){ 
	
// 	var nary = product_id_array.sort();
// 	var yanzheng = [];
// 	for(var i=0;i<product_id_array.length;i++){
		
//     	if (nary[i]==nary[i+1]){

//     		var is_recur = verify_recur( yanzheng,nary[i]) 
    		
//     		if(is_recur == false){
//             	var total_freight = 0;
//             	var id = nary[i];
//             	var price = 0;
//             	var qty = 0;
           	    
//             	is_null = $("input[name="+nary[i]+"]").val();
//             	if(is_null > 0){
//             		var again_total = true;
//             		obj = $("input[name="+nary[i]+"][checked='checked']");
//             		obj_qty = $("input[name=qty_"+nary[i]+"][checked='checked']").prev();
//             		for(j=0;j<obj.length;j++){
//             			qty += parseInt(obj_qty.eq([j]).val() );//其中某一id相同商品的数量
//             			price += parseFloat(obj.eq([j]).val() );//运费
            			
//             	     }
//         //     		alert(parseFloat(obj.val()));
//     //         	    alert(qty);alert(price);
//             		total_freight = $('#freight_total').val(); //100  20 
//             		total_freight = (total_freight - price); //100 - 20 
// //             		$('#freight_total').val(total_freight); //80
            		
//             	    $.ajax({
//            			url: "<?php // echo site_url('cart/freight_count')?>/"+id+'/'+qty,
//             			type: 'GET',
//             			async:false,
//             			dataType: 'html',
//             			success: function(data){ 
//                 			total_freight = parseFloat(data) + parseFloat(total_freight);
//             				$('#freight_total').val(total_freight);
            				
//             			    aa = total_freight;
//             			}
//             		});
//             	}
//         	}
//     		yanzheng.push(id);
//     	}
//     }
// 	if(!again_total){
// 		f_total = freight;
// 	    $('#total_freight span').html('运费：'+freight+' 货豆');
//     }else{
//     	f_total = aa;
// 	    $('#total_freight span').html('运费：'+aa+' 货豆'); 
//     }
// }

function verify_recur(array,element) {
    for (var i = 0; i < array.length; i++) {
        if (array[i] == element) {
            return true;
        }
    }
    return false;

}

function num_is_ok( obj )
{ 
	var x = $(obj).val();
	if (!x)
	{ 
		$(obj).val(1);
		total();
	}
}
</script>

<style type="text/css">
	.mm01_font1 {margin-top:18px;}
</style>

