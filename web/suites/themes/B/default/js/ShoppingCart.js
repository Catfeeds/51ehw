
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
    	
//    	$('#cartBottom_price').text(data);
    	 countofcart();
//		if (obj){
//		  $(obj).next().val(qty);
//		  prices = obj.siblings('.single_price').val()*qty;
//		  $('#txt_subprice_'+rowid).text(prices+'元');
//		}
    	 
    	 if(data){ 
    		 
    		 recountTotal(cor_id);
    	 }
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

// -----------------------------------------------------------

//加入购物车，pid商品id，qty购买数量，sku_id，类型1加入购物车2立即购买
function add_cart(pid,qty,sku_id,type)
{
	$.post(base_url+'/Cart/ajax_add',{pid:pid,qty:qty,sku_id:sku_id,type:type},function (data){
		if(data['status']==1){
			window.location.reload();
		}else if(data['status']==3){//未登录
			location.href=base_url+'/customer/login';
		}else if(type==1){
			var cartcount = data["cartcount"];
			if(cartcount > 99){
				var cartcount = '99+';
			}
			$("#cart_count").html(cartcount);
			alert('加入购物车成功');
		}else{
			location.href=base_url+'/Order?item[]='+data['rowid'];
		}
	},"json");
}

//-----------------------------------------------------------

//收藏商品 pid:商品id
function add_to_fav(pid)
{
	$.post(base_url+"/Member/fav/ajax_add",{'pid':pid},function(data){
		switch(data["status"]){
		  case 0:
			  window.location.href=account_url+"customer/login";
			  break;
		  case 1:case 3:case 5:
			  window.location.reload();
			  break;
		  case 2:
			  $("#fav").text("收藏商品");
			  break;
		  case 4:
			  $("#fav").text("取消收藏");
			  break;
		}
	},"json");
}

//-----------------------------------------------------------

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

//-----------------------------------------------------------

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