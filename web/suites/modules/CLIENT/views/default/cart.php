<?php 
    $product = $this->cart->contents();

    if(count($product)>0):
        
?>
<script type="text/javascript" src="js/ShoppingCart.js"></script>
    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">我的购物车</div>
        
        <div class="gouwuche_box_top2">
        	<ul>
            	<li class="dingdan2_current"><a href="javascript:;">1. 我的购物车</a></li>
                <li><span>></span></li>
                <li><a href="javascript:;">2. 核对订单信息</a></li>
                <li><span>></span></li>
                <li><a>3.成功提交订单</a></li>      
            </ul>
        </div>
        
        
        <form name="cartForm" id="CartForm" method="post" action="<?php echo site_url('order');?>">
        
        <div class="gouwuche_box_con">
        	<div class="gouwuche_box_con_top">
                <div class="gouwuche_box_con01">
                	<ul> 
                	    <li> <label style="margin-left:20px;"><input type="checkbox" onclick="choose_all(this)" id="All_choose" ><em style="margin-left:20px;">全选</em></label><span class="gouwuche_m01" style="width:468px;">商品信息</span></li>
                        <li><span class="gouwuche_m02">单价（货豆）</span></li>
                        <li><span class="gouwuche_m02">数量</span></li>
                        <li><span class="gouwuche_m02">小计（货豆）</span></li>
                        <li><span class="gouwuche_m02">操作</span></li>
                    </ul>
                </div>
                <!--店铺01 开始-->
                <!--选择店铺全选店铺开始 开始-->
               
                
                <?php 
                foreach( $product as $items){
                    $cart[] = $items['corporation_id'];
                
                }
                array_multisort($cart,SORT_ASC,$product);
                
                $id = 0;
                $judge = 0;
                $i=0;
                
                foreach($product as $key => $item):
                    $id = $item['corporation_id'];
                
                    if($item['corporation_id']==$id && $judge != $item['corporation_id']): ?>
               
                <div class="cart_store">
                	<ul>
                    	<li>
                        	<input type="checkbox" id="corp_<?php echo $item['corporation_id'] ?>" flag="i_<?php echo $i=$i+1 ?>[]" onclick="selectAll(this,<?php echo $item['corporation_id'] ?>,<?php echo $i ?>)"><span>店铺：<a><?php echo $item['corporation_name'] ?></a></span>
                        	
                        </li>
                    </ul>
                </div>
                <!--选择店铺全选店铺开始 结束-->
                <!--cart_border 开始-->
                <?php //endif;?>
                <?php foreach ($product as $items): ?>
                <?php if($items['corporation_id']==$id):?>
                <div class="cart_border">
				
                <div class="gouwuche_box_con02" id="cartpage_<?php echo $items["id"]?>" style="<?php echo $items['product_status'] == 'no_sale' ? 'background-color:#EEE9E9;' :'' ?>">
                	<ul id="product_info_<?php echo $items["id"] ?>">
                        <li>
                            <div class="gouwuche_selectAll">
                                <div class="gouwuche_checkbox">
                                    <input type="checkbox" <?php echo $items['product_status'] == 'no_sale' ? 'disabled=disabled' :'' ?> class="corp_<?php echo $item['corporation_id'] ?>" flag="item_<?php echo $items['corporation_id']; ?>[]"  name="item[]" id="<?php echo $items["id"]?>" value="<?php echo $items["rowid"]?>" onclick="selectthis(<?php echo $items['corporation_id'] ?>,<?php echo substr($items['id'],0,strpos($items['id'], '_') );?>)">
                                    <input type="hidden" style="display: none;" name="cid[]"  id="cid[]" value="<?php echo isset($items['cid'])?$items['cid']:"" ?>">
                                    <input type ="hidden" id="<?php echo $items['id'].'_';echo $items['corporation_id']?>" name="<?php echo $items["product_id"]?>" class="freight" value="<?php echo isset($items['freight']) ? $items['freight'] : '0.00'?>">
                                </div>
                                
                            </div>
                        </li>
						
                        <li>
                            <span class="gouwuche_mm01">
							<!--在svn上面复制下面的css落去log到，我会最后修改它 -->
								<style>
								.gouwuche_mm01_img a img{width:100%;}
								</style>
                               <span class="gouwuche_mm01_img"><a href="<?php echo site_url('goods/detail/'.$items['id']);?>"><img src="<?php echo IMAGE_URL.$items['options']['goods_img'];?>" alt=""></a></span>
                               <span class="gouwuche_mm01_font">
                                  <a href="<?php echo site_url('goods/detail/'.$items['id']);?>"><?php echo $items['name'];?></a>
                                  <p class="mm01_font1">
                                  <?php if(isset($items['sku_name'])&&$items['sku_name']!=null): ?>
                                      <?php foreach ($items['sku_name'] as $sku): ?>
                                      <span><?php echo $sku ?></span>
                                      <?php endforeach; ?>
                                     
                                      <?php endif;?>
                                      
                                      <span id="no_sale_messgae_<?php echo $items["id"] ?>"> <?php echo $items['product_status'] == 'no_sale' ? '(商品失效)' : ''?></span>
                                 
                                  </p>
                               </span>
                           </span>
                   		</li>
                        <li>
                   			<span class="gouwuche_mm02" id="item_price_<?php echo $items['id']; ?>"><?php echo $items['price'][0] =='.' ? '0'.$items['price'] :$items['price']?></span> 
                        </li>
                        <li id="on_sale_<?php echo $items["id"]?>" style="<?php echo $items['product_status'] == 'no_sale' ? 'position:relative;': '' ?>">
                        
                        <?php if( $items['product_status'] == 'no_sale'):?>
                            <div style="position: absolute;width: 120px;height: 85px;background: rgba(0,0,0,0.0); z-index: 9999999;"></div>
                        <?php endif;?>
                   			<span class="gouwuche_shuliang">
                            
                                    <a class="gouwuche_jian" href="javascript:jQuery.reduce('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id'] ?>,'<?php echo isset($items["cid"])?$items["cid"]:"" ?>');" >－</a>
									<input type="text" class="gouwuche_input" id="item_num<?php echo $items['id']; ?>" name="hidChange[<?php echo $items['id']; ?>]" value="<?php echo $items['qty'];?>" onblur="num_is_ok(this)" onkeyup="jQuery.modify('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id']?>,'<?php echo isset($items["sku_id"])&&$items["sku_id"]!=null?$items["sku_id"]:"" ?>','<?php echo isset($items["cid"])?$items["cid"]:"" ?>');" >
									<input type="hidden" class="gouwuche_input"  name="qty_<?php echo $items['product_id']?>" value="<?php echo $items['qty'];?>" id="qty_<?php echo $items['id']?>" readonly>
                                    <a class="gouwuche_jia" href="javascript:jQuery.add('<?php echo $items['id']; ?>','<?php echo $items['rowid']; ?>',<?php echo $items['corporation_id']?>,'<?php echo isset($items["sku_id"])&&$items["sku_id"]!=null?$items["sku_id"]:"" ?>','<?php echo isset($items["cid"])?$items["cid"]:"" ?>')">+</a>
                                    <input type ="hidden" id="stock_<?php echo $items['id'] ?>" value="" >
                                    <span id="tip_<?php echo $items['id'] ?>" style="<?php echo $items['product_status'] == 'no_stock' ? 'display;' :'display:none;' ?>color:red;width:120px;">商品数量超过库存！</span>
                            </span> 
                            
                        </li>
                        <li>
                   			<span class="gouwuche_mm02" id="item_totla_<?php echo $items['id']; ?>"><?php echo number_format($items['qty']*$items['price'], 2, '.', '');?></span> 
                        </li>
                        <li>
                   			<span class="gouwuche_mm03">
                            	<a onclick="deleteSelect('<?php echo $items['rowid']; ?>','<?php echo isset($items['cid'])?$items['cid']:"" ?>')">删除</a><br><br>
                               <!-- <a onclick="javascript:add_to_fav('<?php echo $items['id'];?>',this)">移到我的收藏</a>-->
                            </span> 
                        </li>
               
                        
                </ul>
				 </div>
				 </div>
				 <?php $judge = $items['corporation_id'];?>
				 <?php endif; ?>
				 <?php endforeach; ?>
				 <?php elseif($id!=$item['corporation_id']):$id=$item['corporation_id']; ?>

				 <?php endif;?>
                 <?php endforeach;?>
                
                <!--cart_border 结束-->
                <!--店铺01 结束-->
                <input type='hidden' name='total-product_id' value="">
                <!--结算 开始-->  
                <div class="gouwuche_box_con_down clearfix">
                    <span class="gouwuche_d01"><a href="javascript:deleteSelect()">删除选中商品</a></span>
                    <span class="gouwuche_d01"><a href="javascript:movetofav()">添加到我的收藏</a></span>
                  
                    
                    <span class="gouwuche_d03">
                    	<p id="producttotal">总商品金额：0.00 货豆</p>
						<p id="freight">+ 运费：0.00 货豆</p><br>
                        <p class="gouwuche_dd03" id="totalall">应付总额：0.00 货豆</p>
                        <div class="gouwuche_dd04"><a onclick="submitform();">提交订单</a></div>
                    </span>
                </div>
                <!--结算 结束-->
            </div>
            
        </div>
        </form>
        <input type="hidden" id="freight_total">
    </div>
    
<script>
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
            alert("请输入正确的数量！"); 
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
           alert("商品数量最少为" + this.min + "！");   
        }  

        total();
    },  
    add : function(obj,id,cor_id,sku_id,cid) { 
        var x = this.amount('#item_num'+obj, true);
         
		var price = $('#item_price_'+obj).html();
		ajax_update(id,x,null,cid,obj,cor_id);
		
		var max = $('#stock_'+obj).val();
		
		if( max ){
			
            if (parseInt(x)<=max) {
                jQuery('#item_num'+obj).val(x);  
    			$("#item_totla_"+obj).text((price * x).toFixed(2));
    			var freight = $('#freight_'+obj).val();
    			

            } else {
                  
                $('#tip_'+obj).html("商品数量超过库存！");
                $('#tip_'+obj).show();
                jQuery(obj).val(max == 0 ? 1 : max);  
                jQuery(obj).focus();  
            } 
		}
		total();
    },  
    modify : function(obj,id,cor_id,sku_id,cid) {
        
        var x = $('#item_num'+obj).val(); 
        if( !x )
        {
           return;
        } 
        
        if (isNaN(x) || x == 0) {
            
            jQuery('#item_num'+obj).val(1);  
            
            return;  
        }

        var price = $('#item_price_'+obj).html();
        ajax_update(id,x,null,cid,obj,cor_id);
        var max = $('#stock_'+obj).val(); 
        var freight = $('#freight_'+obj).val();
		
          
        var intx = parseInt(x);  
        var intmax = parseInt(max);  
        $("#item_totla_"+obj).text((price * x).toFixed(2));
        if (intx < this.min) {  
            jQuery('#item-error').html("<i class=\"ico\"></i>商品数量最少为" + this.min  
                    + "！");  
            jQuery('#item-error').show();  
            jQuery(obj).val(this.min);  
            jQuery(obj).focus();  
			return;
        } else if (intx > intmax) { 
           
            jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");  
            jQuery('#item-error').show();  
            $("#item_totla_"+obj).text((price * max).toFixed(2));
            $('#item_num'+obj).val(max == 0 ? 1 : max);  
            $('#item_num'+obj).focus();  
			return;
        } 

        total();
// 		$("#total_price").text("￥ "+(curr_price * x).toFixed(2));
    }  
    
}); 

function total(){ 
	
	var obj_all = $('input[type=checkbox][name="item[]"]');
	var total_price = 0.00;
	
	for(j = 0; j<obj_all.length; j++){ 
	    
		if( obj_all[j].checked ){ 
			var id = obj_all[j].id;
			
			//所有选中商品的总价
			 total_price +=  $('#item_price_'+id).text() * $('#item_num'+id).val();
			
		}
	}

	$('#producttotal').html("总商品金额："+total_price.toFixed(2)+" 货豆");
	$('#totalall').html("应付总额："+(total_price ).toFixed(2)+" 货豆");
}
//删除购物车
function deleteSelect(rowid,cid)
{ 
	if(confirm('确定移除所选商品？'))
	{
		var rowids = new Array();
		var cids = new Array();
		var i = 0;
		if(rowid){
			rowids[0] = rowid;
			if(cid){
	      		  cids[i] = cid;
	      	}
		}else{
        	 $("input[name='item[]']:checked").each(function(){
        		  rowids[i] = $(this).val();
        		  cid = $(this).next('input').val();
        		  if(cid){
        		  cids[i] = cid;
        		  }
        		  i++;
              });
		}

        if(rowids[0]){
         $.post(base_url+'/cart/deleteSelect',{rowid:rowids,cid:cids},function (data){
     	    location.reload();
             })
    	}else{
    	    alert('请选择要删除的商品');
    	}
	}
}


//选择产品移到收藏
function movetofav($id)
{
	<?php if(!$this->session->userdata('user_in')):?>
	alert('您还未登录，请先登录。');
	<?php else:?>
	if(confirm('添加到我的收藏？'))
	{
		id = new Array()
		var i = 0;
    	if($id){
        	id[0] = $id;
    	}else{
        	 $("input[name='item[]']:checked").each(function(){
        		  var array_id = $(this).attr("id").split('_');	
        		  id[i++] = array_id[1];
        		  
      		    
              });
    	}
    	if(id[0]){
        	$.post("<?php echo site_url('member/fav/batch_add');?>",{id:id},function (data){
     		   switch (data){
     		   case 'ok':
         		   alert('收藏成功');
     	 		   break;
     		   case 'fail':
         		   alert('收藏失败');
      			  break;
     		   case 'exists':
         		   alert('收藏已存在');
     	 		   break;
     		   }
            });
        }else{
            alert('请选择要收藏的商品');
            return;
            }
	}
	<?php endif;?>
}

function choose_all(obj)
{ 

	chebox_obj = $('input[type=checkbox]');
   
    for(i=0;i<chebox_obj.length;i++){

    	if(chebox_obj[i].getAttribute("disabled")  !== 'disabled'){
        	
    		chebox_obj[i].checked = obj.checked;
        }
    	
    }
    
    total();
}

function selectAll(obj,id,i)
{

    if($("input[flag='i_"+i+"[]']").is(":checked")){
        
    	
    	$("input[flag='i_"+i+"[]']").prop("checked",true);
    }


	var flag = $(obj).is(':checked');

	$("input[flag='item_"+id+"[]']").each(function () {
	    
	    
		if( $(this).attr("disabled")  !== 'disabled'){
			
			$(this).prop("checked",flag);
        }
		 

      });

    //处理是否需要全选---start
	
	//获取全部
	var all_checkbox = $('input[type=checkbox]:not(:disabled)').length - 1;
    
	//获取全部选中的数量 
	var all_choose_checkbox = $('input[type=checkbox]:checked').length;

	//判断是否全部被选中
	if( all_checkbox == all_choose_checkbox && $('#All_choose').prop('checked') == false )
	{
		 $('#All_choose').prop('checked',true); 
	}else{ 
		$('#All_choose').prop('checked',false); 
	}
	
	//处理是否需要全选---end
    
    total();

}

function selectthis(corp_id,p_id){

	//处理是否需要选中店铺---start
	var corp_product = $('.corp_'+corp_id).length;
	var corp_choose_product = $('.corp_'+corp_id+':checked').length;

    if( corp_choose_product == corp_product && $('#corp_'+corp_id).prop('checked') == false)
	{
		$('#corp_'+corp_id).prop('checked', true);
	}else{
		$('#corp_'+corp_id).prop('checked', false);
	}
	//处理是否需要选中店铺---end


    
	//处理是否需要全选---start
	
	//获取全部
	var all_checkbox = $('input[type=checkbox]:not(:disabled)').length - 1;

	//获取全部选中的数量 
	var all_choose_checkbox = $('input[type=checkbox]:checked').length;

	//判断是否全部被选中
	if( all_checkbox == all_choose_checkbox && $('#All_choose').prop('checked') == false )
	{
		 $('#All_choose').prop('checked',true); 
	}else{ 
		$('#All_choose').prop('checked',false); 
	}
	
	//处理是否需要全选---end
	total();
}

// function recountTotal(ids,o)
// {

// 	var total = 0;
// 	var freight = 0;
// 	var product = [];
// 	$("input[flag='item_"+ids+"[]']").each(function () {
// 		if( !$(this).is(':checked') ){ 
// 			id = $(this).attr("id");
// 		    qty_id = id.substring(id.indexOf("_")+1);
// 			$(this).nextAll('input[class=freight]').removeAttr("checked");
// 			$('#qty_'+qty_id).removeAttr("checked");	
// 		}else{ 
// 			id = $(this).attr("id");
// 			qty_id = id.substring(id.indexOf("_")+1);
// 			freight += parseFloat( $(this).nextAll('input[class=freight]').val() );

		    
// 			product.push( $(this).nextAll('input[class=freight]').attr("name") );
// 			$('#qty_'+qty_id).attr("checked",'checked');
// 			$(this).nextAll('input[class=freight]').attr("checked",'checked');
			
// 			total = total+$('#'+id.replace("item_","item_price_")).html()*$('#'+id.replace("item_","item_num")).val();
// 		}
		
//     });
   
	
// 	$('#freight_total').val(freight);
// // alert(product);
// // 	alert(ccc( product,444) );

// 	var nary=product.sort();
//     var yanzheng = [];
// 	for(var i=0;i<product.length;i++){
		
//     	if (nary[i]==nary[i+1]){
    		    
//  		    var is_recur = verify_recur( yanzheng,nary[i]) 
    		
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
// //             		alert(parseFloat(obj.val()));
// //             	    alert(qty);
// //             		alert(price);
//             		total_freight = $('#freight_total').val(); //100  20 
//             		total_freight = (total_freight - price); //100 - 20 
// //             		$('#freight_total').val(total_freight); //80
            		
//             	    $.ajax({
            			url: "<?php echo site_url('cart/freight_count')?>/"+id+'/'+qty,
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
    
//       if(!again_total){
//           var f_total = freight;
// 	      $('#freight').html('+ 运费：'+freight+' 货豆');
//       }else{
//     	  var f_total = aa;
//     	  $('#freight').html('+ 运费：'+aa+' 货豆'); 
//       }
// 	  $('#producttotal').html("总商品金额："+total.toFixed(2)+" 货豆");
// 	  $('#totalall').html("应付总额："+(total + parseFloat(f_total) ).toFixed(2)+" 货豆");
	  
// 	  if($(o).attr("cehcked")){
// 	  $(o).next().attr("checked");
// 	  }
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
/**
 * 购物车商品
 */
function submitform(){
	
	if($('input[name="item[]"]').is(':checked')){
		var ok = true;
    	$('input[name="item[]"]:checked').each(function(){
    		
    	    var id = $(this).attr("id");
    	    if(parseInt($('#item_num'+id).val())>parseInt($('#stock_'+id).val())){
    	        $('#tip_'+id).html("商品数量超过库存！");
    	        $('#tip_'+id).show();
    	        ok = false;
    		}
    	});
    	
    	if(ok){
    		$('#CartForm').submit();
        }
	}else{
		alert('请选择商品')
    }
}


// 针对个别浏览器默认选择上次选择checkbox问题
$(function(){
	$("input").attr("checked",false);
})

</script>
	
	 <?php else:?>
                
                 
<!--空购物车-->
<div class="gouwuche_box">
    <div class="gouwuche_box_top">我的购物车</div>
    <div class="nogoods" >
      <div class="nogoods_top">
        <img src="images/nogoods.png"/>
        <span>您的购物车空空的～<a href="<?php echo site_url('Home')?>">快去易货吧</a></span>
      </div>
    </div>
</div>
    <?php endif; ?>
  