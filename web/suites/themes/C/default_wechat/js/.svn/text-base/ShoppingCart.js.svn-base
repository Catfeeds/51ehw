function changeBar(type, skuId, obj) {
	var txtC = null;
	var change = 0;
	txtC = $(obj).siblings('.qty');
	if (type == '+') {
		change = 1;
	}
	if (type == '-') {
		change = -1;
	}
	var num = parseInt(txtC.val());
	if (num + change < 0) {
		alert('您输入的数字已经超出的最小值');
		return;
	}
	txtC.val(num + change);

	changeProductCount(skuId, txtC);

}

// 更改商品数量
function changeProductCount(productId, obj) {

	obj = $(obj);

	if (obj.val() == obj.next().val()) {
		return;
	}

	// 检测输入是否为数字
	if (!checknumber(obj.val())) {
		showAlert_shoppingCart("您输入的格式不正确！", obj);
		obj.val(obj.next().val());
		return;
	}

	// 判断为0的情况
	if (parseInt(obj.val()) == 0) {
		removeProductOnShoppingCart(productId, obj);
		return;
	}

	ajax_update(obj.prev().val(), obj.val(), obj);

}

// 显示提示
function showAlert_shoppingCart(message, obj) {
	alert(message);
}

// 删除购物车中的商品
function removeProductOnShoppingCart(productId, obj) {
	obj = $(obj);
	if (confirm('确定不购买该商品？')) {
		// alert(objhtml());
		setDelSku(obj, productId);
	} else {
		return;
	}

	location.reload();

}
function removeProduct(productId, obj) {

	// obj = $(obj).parent().parent().find('.qty');
	obj = $(obj).parent().parent().prev().find('.qty');
	// alert(obj.val());
	removeProductOnShoppingCart(productId, obj);
}

function setDelSku(obj, skuId) {
	var trObj = obj.parent().parent();
	// alert(trObj.html());
	$(trObj).remove();
	ajax_update(obj.prev().val(), 0)
}

// 清空购物车
function clearCart() {
	if (confirm('确定清空购物车吗？')) {
		// $.ajax({
		// url: base_url+'/cart/destroy',
		// type: 'GET',
		// dataType: 'html',
		// success: function(data){
		// $('#CartTb tr.align_Center').remove();
		// }
		// });
		alert('执行清空购物车');
	}
	return false;
}

// ajax
function ajax_update(rowid,qty,obj,cid,p_id,cor_id) {
	
	$.ajax({
		url: base_url+'/Cart/update',
		type : 'GET',
		data: {rowid:rowid,qty:qty,p_id:p_id,id:cid},
		dataType: 'json',
		success : function(data) {
			
			$('#freight'+p_id).val(data.freight);//运费
	    	
	    	$('#'+p_id+'_'+cor_id).val(data.freight);
	    	
	    	if(data.status == 1 && data.stock > 0)
			{
	    		if( !$('#stock_'+p_id).val()  )
	    		{ 
	        		$('#item_num'+p_id).val(data.qty);
	    		}
	        	$('#stock_'+p_id).val(data.stock);
	        	
	        	countofcart();
	        	
			}else if (data.status == 2 || data.stock == 0){
				
				$('#'+p_id).removeAttr("onclick");
				$('#'+p_id).attr("class",'');
				$('#'+p_id).parent().parent('li').css('background-color','#EEE9E9');
				$('#on_sale_'+p_id).css("position","relative");
				$('#on_sale_'+p_id).prepend('<a style=" position: absolute; width: 60%;height: 32px;"></a>');
				$('#no_sale_messgae_'+p_id).text('(商品失效)');
//				
				
			}
	    	
	    	total();

		}
	});
}

// 加入购物车
function add_cart(goodsid, qty) {
	$.ajax({
		url : base_url + '/Cart/ajax_add',
		type : 'POST',
		data : {
			'pid' : goodsid,
			'qty' : qty
		},
		dataType : 'html',
		success : function(data) {
			alert(data);
			countofcart();
		}
	});
	// alert(base_url);
}

function removecart(productId, obj) {
	obj = $(obj).parent().find('input[name="rowid"]');
	if (confirm('确定不购买该商品？')) {
		alert(base_url + '/Cart/update/rowid/' + obj.val() + '/qty/' + 0);
		$.ajax({
			url : base_url + '/Cart/update/rowid/' + obj.val() + '/qty/' + 0,
			type : 'GET',
			dataType : 'html',
			success : function(data) {
				countofcart();
			}
		});
	}
}

function countofcart() {
	$.ajax({
		url : base_url + '/Cart/ajax_countcart',
		type : 'GET',
		dataType : 'html',
		success : function(data) {
			$("#cart_count").html(data);
		}
	});

}

// -------------------------------------------以下是阿苏写的函数，以上有空全部删除-------------------------------------
/**
 * 删除购物车产品
 * @row_id
 * @qty
 */
function remove_product(rowid, cid) {
	
	if(confirm('确定移除所选商品？'))
	{
		var rowids = new Array();
		var cids = new Array();

		rowids[0] = rowid;
      	cids[0] = cid;

        if(rowids[0]){
         $.post(base_url+'/Cart/deleteSelect',{rowid:rowids,cid:cids},function (data){
     	    location.reload();
             })
    	}else{
    	    alert('请选择要删除的商品');
    	}
	}
}


/**
 * 移入收藏夹
 * @pid
 * @obj
 */
function add_to_favorite(rowid, obj,cid,pid) {
	$.ajax({
		url : base_url + '/Member/fav/ajax_add',
		type : 'POST',
		data : {
			'pid' : pid
		},
		dataType : 'html',
		success : function(data) {
			remove_product(rowid, obj,cid);
		}
	});

}