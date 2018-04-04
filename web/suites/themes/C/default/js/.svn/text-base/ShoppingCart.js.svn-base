
function changeBar(type,skuId,obj)
{
    var txtC=null;
    var change=0;
	txtC=$(obj).siblings('.qty');
    if(type=='+')
    {     
      change=1;
    }
    if(type=='-')
    {
      change=-1;
    }
    var num=parseInt(txtC.val());
    if(num+change<0)
    {
       alert('您输入的数字已经超出的最小值');
       return;
    }
    txtC.val(num+change);
    
    changeProductCount(skuId,txtC);
       
}

//更改商品数量
function changeProductCount(productId,obj)
{
   
   obj = $(obj);
   
   if(obj.val()==obj.next().val()){return;}
   
   //检测输入是否为数字
   if(!checknumber(obj.val())){showAlert_shoppingCart("您输入的格式不正确！",obj);obj.val(obj.next().val());return;}
   
   //判断为0的情况
   if(parseInt(obj.val())==0)
   {
      removeProductOnShoppingCart(productId,obj);
      return;
   }

   ajax_update(obj.prev().val(),obj.val(),obj);

}

//显示提示
function showAlert_shoppingCart(message,obj)
{
   alert(message);
}

//删除购物车中的商品
function removeProductOnShoppingCart(productId,obj,cid)
{
   //obj = $(obj);
	//confirm(productId);
   if(confirm('确定不购买该商品？'))
   {
      //alert(productId);
      setDelSku(obj,productId,cid); 
   }else{
      obj.val(obj.next().val());return;
   }
   
}
function removeProduct(productId,obj)
{
	
//	obj = $(obj).parent().parent().find('.qty');
	//obj = $(obj).parent().parent().prev().find('.qty');
//	alert(obj.val());
    removeProductOnShoppingCart(productId,obj);
}

function setDelSku(obj,skuId,cid)
{  
   var trObj=$('#'+obj);
   $(trObj).remove(); 
   ajax_update(skuId,0,null,cid);

}

//清空购物车
function clearCart()
{
   if(confirm('确定清空购物车吗？'))
   {
      $.ajax({
      url: base_url+'/cart/destroy',
      type: 'GET',
      dataType: 'html',
      success: function(data){ 
	    window.location.reload();
		//$('#CartTb tr.align_Center').remove();
      }
    });
   	alert('执行清空购物车');
   }
   return false;
}

//ajax
function ajax_update(rowid,qty,obj,cid,p_id,cor_id)
{
	$.ajax({
      url: base_url+'/cart/update',
      type: 'GET',
      data: {rowid:rowid,qty:qty,p_id:p_id,id:cid},
      dataType: 'json',
      success: function(data){
    	
    	$('#'+p_id+'_'+cor_id).val(data.freight);
    	
    	if(data.status == 1 && data.stock > 0)
		{
    		if( !$('#stock_'+p_id).val()  )
    		{ 
        		
        		$('#item_num'+p_id).val(data.qty);
    		}
        	$('#stock_'+p_id).val(data.stock);
        	
        	countofcart();
        	
		}else if (data.status == 2 ||  data.stock == 0){
			
			$('#'+p_id).attr("checked",false);
			$('#'+p_id).attr("disabled","false"); 
			$('#on_sale_'+p_id).css("position","relative");
			$('#on_sale_'+p_id).prepend('<div style="position: absolute;width: 120px;height: 85px;background: rgba(0,0,0,0.0); z-index: 9999999;"></div>');
			$('#no_sale_messgae_'+p_id).text('(商品失效)');
			$('#cartpage_'+p_id).css('background-color','#EEE9E9');
			
		}
    	
    	total();
    	
//    	$('#cartBottom_price').text(data);
    	 
//		if (obj){
//		  $(obj).next().val(qty);
//		  prices = obj.siblings('.single_price').val()*qty;
//		  $('#txt_subprice_'+rowid).text(prices+'元');
//		}
//    	 alert(data.qty);
//    	 if(data){ 
//    		 
//    		 recountTotal(cor_id);
//    	 }
       }
    });
	
}

//删除购物车
function aja_delete(rowid,cid){

	if(confirm('确定移除所选商品？'))
	{
		var rowids = new Array();
		var cids = new Array();

		rowids[0] = rowid;
      	cids[0] = cid;

        if(rowids[0]){
         $.post(base_url+'/cart/deleteSelect',{rowid:rowids,cid:cids},function (data){
     	    location.reload();
             })
    	}else{
    	    alert('请选择要删除的商品');
    	}
	}
}

//加入购物车
function add_cart(goodsid,qty,sku_id)
{
	$.ajax({
      url: base_url+'/cart/ajax_add',
      type: 'POST',
      data:{'pid':goodsid,'qty':qty,'sku_id':sku_id},
      dataType: 'html',
      success: function(data){
      data = jQuery.parseJSON(data);

	        switch (data['status']){
            case 'ok':
                alert('加入购物车成功');
                break;
            case 'no_goods':
                alert('商品已下架。');
                location.href=base_url+'/home';
                break;
            case 'fail':
                alert('添加失败。');
                break;
            case 'add_fail':
            	alert('添加失败。');
            	location.href=base_url+'/home';
            	break;
            default :
            	alert('服务器异常。');
                location.href=base_url+'/home';
                break;
        }
    	    
			window.location.reload(); 

      	}
    });
	

}

function removecart(productId,obj)
{
	obj = $(obj).parent().find('input[name="rowid"]');
	confirm(productId);
	if(confirm('确定不购买该商品？'))
	{
		$.ajax({
			url: base_url+'/cart/update/rowid/'+obj.val()+'/qty/'+0,
			type: 'GET',
			dataType: 'html',
			success: function(data){ 
				countofcart();
			}
		});
	}
}

function countofcart()
{
	$.ajax({
		url: base_url+'/cart/ajax_countcart',
		type: 'GET',
		dataType: 'html',
		success: function(data){ 
			
			$("#cart_count").html(data); 
		}
	});
	
}

function updateProductCount(id,qty,cid,p_id,cor_id)
{
	ajax_update(id,qty,null,cid,p_id,cor_id);
	
}

/**
 * h5删除购物车产品
 * @row_id
 * @qty
 */
function remove_product(row_id, qty,cid,p_id) {
	$.ajax({
		url : base_url + '/cart/update/rowid/' + row_id + '/qty/' + qty+'/p_id/'+p_id+'/id/'+cid,
		type : 'GET',
		dataType : 'html',
		success : function(data) {
			location.reload();
		}
	});
}

/**
 * h5移入收藏夹
 * @pid
 * @obj
 */
function add_to_favorite(rowid, obj,cid,pid) {

	$.ajax({
		url : base_url + '/member/fav/ajax_add',
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