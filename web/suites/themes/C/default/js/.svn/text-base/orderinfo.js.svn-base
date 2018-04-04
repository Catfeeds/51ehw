var isConOpen=true;
var isPayTypeAndShipTypeOpen=false;
//自定义订单提交前检查条件
var isNewCon = false;


function clearSubmitError(obj)
{
   if(obj.parentNode.childNodes.length>0){
   if(obj.parentNode.lastChild.name=='errorInfo')
   {
     obj.parentNode.removeChild(obj.parentNode.lastChild);
   }
   }
}

//----------------------------收货人信息-------------------------------------
var label_consignee;

//显示地址信息表单
function showForm_consignee(obj)
{
   var isConOpen=true;
   isNewCon = true;
   label_consignee=g("part_consignee").innerHTML;
   showWaitInfo('正在读取收货人信息，请等待！',obj);
//   alert(base_url);
   $.ajax({ 
		 url:base_url+"/order_att/consignee_edit", 		 
		 type: 'POST',
		 data:{
		 'consignee': 'ddd'
//		 'province_id': $('input[name="province_id"]').val(),
//		 'city_id': $('input[name="city_id"]').val(),
//		 'district_id': $('input[name="district_id"]').val(),
//		 'email': $('#email').text(),
//		 'phone': $('#phone').text(),
//		 'mobile': $('#mobile').text(),
//		 'address': $('#address').text(),
//		 'postcode': $('#postcode').text()
		 },
         dataType: 'html',
         success: function(data){
			 alert(data);
		   clearWaitInfo();
//		   $('#part_consignee .o_show').remove();
		   $('#part_consignee').append(data);
		 }
	});	  
}

//保存地址信息
var consigneeIsSave = false;
var district_id;
function save_consignee(obj)
{
//	alert('dddfff');
	
	clearSubmitError(obj);
	if(check_con())
	{
//		alert('Sumbit');
//	   isConOpen=false;
//	   consigneeIsSave = true;
//	   district_id = $('#district_id option:selected').val();
//	   alert('ddd');
	   consignee_show();
////	   pay_and_ship_edit();
	}
}


//生成地址
function consignee_show()
{
  $.ajax({ 
	 url:base_url+"/order_att/consignee_save", 
	 data:{
	 'consignee': $('input[name="consignee"]').val(),
	 'province_id': $('#province_id option:selected').val(),
	 'city_id': $('#city_id option:selected').val(),
	 'district_id': $('#district_id option:selected').val(),
	 'email': $('input[name="email"]').val(),
	 'phone': $('input[name="phone"]').val(),
	 'mobile': $('input[name="mobile"]').val(),
	 'address': $('input[name="address"]').val(),
	 'postcode': $('input[name="postcode"]').val()
	 },
	 type: 'POST',
	 dataType: 'html',
	 success: function(data){
	   clearWaitInfo();
//	   $('#part_consignee .o_write').remove();
//	   $('#part_consignee').append(data);
	   $('#part_consignee').empty();
	   consignee_reload();
	   isNewCon = false;
//	   $('#part_consignee').append('sdfgsfsdfsd');
//	   $('#consignee_from').remove();
	 }
});
}

//重新加载提交订单时的收货地址
function consignee_reload()
{
	$.ajax({
		url:base_url+"/order_att/consignee_list",
		data:{},
		type: 'POST',
	 	dataType: 'html',
	 	success:function(data){
	 		$('#part_consignee').append(data);
	 	}
	});
}

//保存收货人信息时的检查
function check_con()
{
   var res=true;
   if(!check_addressName()){res=false;}
   if(!check_con_area()){res=false;}
   if(!check_address()){res=false;}
   if(!check_postcode()){res=false;}
   if(!check_phoneAndMob()){res=false;}
   if(!check_phone()){res=false;}
   if(!check_message()){res=false;}
   //if(!check_email()){res=false;}
   
   return res;
}

//保存用户信息时的检查
function check_info()
{
   var res=true;
   if(!check_con_area()){res=false;}
   if(!check_address()){res=false;}
   if(!check_postcode()){res=false;}
   if(!check_phoneAndMob()){res=false;}
   if(!check_phone()){res=false;}
   if(!check_message()){res=false;}
   if(!check_email()){res=false;}
   
   return res;
}
//检查收货人姓名
function check_addressName()
{  
   removeAlert('addressName_empty');
   removeAlert('addressName_ff');
   
   var pNode=g('consignee_addressName').parentNode;
   if(isEmpty('consignee_addressName')){showAlert('收货人姓名不能为空！',pNode,'addressName_empty');return false;}
   if(!/^[\u4e00-\u9fa5a-zA-Z]+$/.test(g('consignee_addressName').value)){showAlert('收货人姓名格式不正确！',pNode,'addressName_ff');return false;}
   return true;
}
//检查省市区
function check_con_area()
{
   removeAlert('area_check');
   var pNode=g('district_id').parentNode;
   if(g('district_id').value=='-22' || g('district_id').value=='' || g('district_id').value=='1')
   {
      showAlert('地区信息不完整！',pNode,'area_check')
      return false;
   }
   return true;
}
//检查收货人地址
function check_address()
{  
   removeAlert('address_empty');
   removeAlert('address_ff');
   
   var pNode=g('consignee_address').parentNode;
   if(isEmpty('consignee_address')){showAlert('收货地址不能为空！',pNode,'address_empty');return false;}
   //if(!is_forbid(g('consignee_address').value)){showAlert(ffAlertTxt,pNode,'address_ff');return false;}
   return true;
}
//检查邮政编码
function check_postcode()
{ 
   removeAlert('postcode_empty');
   removeAlert('postcode_ff');
   var pNode=g('consignee_postcode').parentNode;
   if(isEmpty('consignee_postcode')){showAlert('邮编不能为空',pNode,'postcode_empty');return false;}
   if(g('consignee_postcode').value!=''){   
   var myReg=/(^\s*)\d{6}(\s*$)/;
   if(!myReg.test(g('consignee_postcode').value)){showAlert('邮编格式不正确',pNode,'postcode_ff');return false;}
   }
   return true;
}
//检查联系电话
function check_phone()
{  
   removeAlert('phone_ff');
   
   var pNode=g('consignee_phone').parentNode;
   //var myReg=/((\d+)|^((\d+)|(\d+)-(\d+)|(\d+)-(\d+)-(\d+)-(\d+))$)/;
   //if(!isEmpty('consignee_phone') && !myReg.test(g('consignee_phone').value)){showAlert('固定电话格式不正确',pNode,'phone_ff');return false;}
    //if(!isEmpty('consignee_phone') && !myReg.test(g('consignee_phone').value)){showAlert('固定电话格式不正确',pNode,'phone_ff');return false;}
   return true;
}
//检查手机号
function check_message()
{  
   removeAlert('message_ff');
   if(g('consignee_message').value!=''){
   var pNode=g('consignee_message').parentNode;
   var myReg=/^0{0,1}(13[0-9]|15[0-9]|18[0-9]|14[0-9])[0-9]{8}$/;
   if(!myReg.test(g('consignee_message').value)){showAlert('手机号格式不正确',pNode,'message_ff');return false;}
   }
   return true;
}
//检查电话和手机是否都填写了
function check_phoneAndMob()
{
   removeAlert('phone_empty');
   var pNode=g('consignee_phone').parentNode;
   if(isEmpty('consignee_phone') && isEmpty('consignee_message')){showAlert('固定电话和手机号码请至少填写一项！',pNode,'phone_empty');return false;}
   return true;
}
//检查Email
function check_email()
{  
   var iSign='email';
   removeAlert(iSign+'_ff');
   if(g('consignee_'+iSign).value!=''){
   var pNode=g('consignee_'+iSign).parentNode;
   var myReg=/(^\s*)\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*(\s*$)/;
   if(!myReg.test(g('consignee_'+iSign).value)){showAlert('电子邮件格式不正确',pNode,iSign+'_ff');return false;}
   }
   return true;
}
//保存地址信息
var consigneeIsSave = false;
var district_id;
function savePart_consignee(obj)
{
   clearSubmitError(obj);
   if(check_con())
   {
	   isConOpen=false;
	   consigneeIsSave = true;
	   district_id = $('#district_id option:selected').val();
	   consignee_show();
	   pay_and_ship_edit();
   }
}

//-------------------------提交订单信息-----------------
function check_submit()
{
   var res=true;
   if(!check_submit_isClose())
   {
      res=false;
   }
   return res;
}
function check_submit_isClose()
{
	var errInfo="";
	var address = $('input[name="address_id"]').val();
	if(address =="new"||address=="")
	{
		errInfo="请添加一个收货地址";
		alert(errInfo);
		return false;
	}
	return true;
}




//提交订单
function submitOrder()
{
	order_data = {};
	//收货地址id
	var address_id = $("input[name=address_id]:checked").val();
	
	//判断是否有收货地址
	if(address_id !=0)
    {
		if( product_data == '')
		{ 
			alert('无订单提交');
			return;
		}
		
//		var customer_remark = $("textarea[name=customer_remark]").val();//交易备注
		var remark =  $('textarea');
		var customer_remark = new Array();
		
		//留言（店铺id_内容）
		for ( var i = 0; i<remark.length; i++ )
		{
			var j = $(remark[i]).attr('class').substr(7);
		    customer_remark[i] = j+'_'+$(remark[i]).val();
		}
		
		
		
		//获取使用的优惠券
		var package_id = new Array();//卡包id
		var i = 0;
		$(".select-coupon").each(function(){
			if($(this).val() > 0){
				package_id[i] = $(this).val();
				i++;
			}
		});
		
		
		$.ajax({
			url:base_url+'/order/save',
			type:'post',
			data:{"product_data":product_data,"customer_remark":customer_remark,"address_id":address_id,"package_id":package_id},
			dataType:"json",
			beforeSend:function(){     
				$('#order_submit_status').text('结算中...');
				$('#order_submit_status').css('background','#ccc');
				$('#order_submit_status').attr("href",'javascript:void(0)'); 
    	    },
			success:function(data){
				
				switch (data['type']){
				case 'ok'://成功
					var total_price = data.total_product_price+'';
					
					if( total_price.indexOf('.') == -1 )
				    { 
						total_price = total_price+'.00'
				    }
					
					for(i=0;i<data.order_id.length; i++ )
					{ 
						order_data[data.order_id[i]] = {};
						order_data[data.order_id[i]]['order_id'] = data.order_id[i];
					}
					
//					if( data.cart_list )
//					{
//						card_choose_html(data.cart_list,data.corp_order_info,total_price);
//					}
					
					
					$('#pay_view').show();
					$('#all_order_price').text('M '+total_price);
					$('#pay_').attr('onclick','all_order_pay()');
					$('#M_pay_parice').children('span').html('M券支付：M '+total_price);
//					location.href = base_url+'/order/orderfinish?new_order_id='+data['new_order_id']+'&status='+data['status'];
					break;
				case 'fail'://订单生成失败执行
					alert('订单生成失败');
					location.href= base_url+"/cart";
					break;
				case 'stale'://特价超时
					$('#prompt').text('订单内有商品特价,该活动已结束，你是否确定原价购买？');
					$("#teshi").show();
					break; 
				case 'not_found_address'://缺少地址执行
					location.href= base_url+"/member/address/add?path="+base_url+"/cart";
					break;
				case 'invalid':
					 alert('订单内有商品已下架或库存不足，请重新下单');
					 window.location.reload();
					 break;
				case 'couponexpired':
					alert('订单内使用的优惠券过期，请重新下单');
					window.location.reload();
					break;
				default://未知问题执行
					alert('网络错误');
					window.location.reload();
					break;
				}
//				
//				$('#order_submit_status').text('提交订单');
//				$('#order_submit_status').css('background','#72c312');
//				$('#order_submit_status').attr("href",'javascript:submitOrder()'); 
				
			},
			error:function() {
				alert('网络连接超时');
				location.reload();
			}
		});

	   }else{
		  alert("请添加或选择一个收货地址！");
	   }
  
}

//储值卡的JS。
function card_choose_html(obj,corp_order_info,order_total_price)
{ 
	
	console.log(order_data);
	var html = '';
	var card_info = {};
	
	var card_pay_amount_info = {};
	
	for( var i in obj )
	{ 
		html += '<li class="choose_card_list"><span>线上储值卡支付：</span>';
		html += '<select style="width: 150px;" class="card_choose" id="card_corp_'+i+'">';
		html += '<option value=0>请选择</option>';
		
		var result = obj[i];
		
		for(j = 0; j<obj[i].length; j++)
		{ 
			card_info[result[j]['id']] = result[j];
			html += '<option value='+result[j]['id']+'>'+result[j]['card_name']+'</option>';
		}
		html += '</select>';
		html += '</li>';
	}
	$('.payNum_ul li').eq(0).after(html);
	
	
	//绑定储值卡的事件。、】
	$(".card_choose").on("change", function()
	{
		 var id = $("option:selected",this).val();
		 var remaining_card_amount = 0; //记录卡余额。
		 var card_pay_amount = 0; //记录选中储值卡支付金额。
		 var card_pay_amount_total = 0;//记录储值卡支付总额额。
		 
		
	     var corp_attr_id = $("option:selected",this).parent('select').attr('id'); //获取那个select 的id。
	     var corporation_id = corp_attr_id.split('_')[2];//店铺ID。
	     card_pay_amount_info[corporation_id] = 0;//记录每个店铺使用的储值卡金额。
	     
	     //初始化数组对象。。
	     order_data[corp_order_info[corporation_id]['order_id']]['card_pay_amount'] = 0;
	     order_data[corp_order_info[corporation_id]['order_id']]['card_buy_id'] = 0;
	     
	     $('#'+corp_attr_id).parent().find('.card_pay_amount').remove();
	     
		 if( card_info[id]  )
	     {	
			 remaining_card_amount = card_info[id]['remaining_card_amount'];
			 
			 if( card_info[id]['level'] == 2 )
			 {
				 if(  parseFloat(card_info[id]['level_two_show_card_amount']) <  parseFloat( card_info[id]['remaining_card_amount'] ) )
				 { 
					 remaining_card_amount = card_info[id]['level_two_show_card_amount'];
				 }
			 } 
	         
			 //默认支付的金额。
			 card_pay_amount = remaining_card_amount;
		     
			 //如果储值卡余额足以支付该店铺的订单则显示该订单总额。
		     if( parseFloat( remaining_card_amount) >=  parseFloat( corp_order_info[corporation_id]['total_price'] ) )
		     { 
		         card_pay_amount = corp_order_info[corporation_id]['total_price'];
		     }
		     
		     //并把使用储值卡的金额记录进去。
		     card_pay_amount_info[corporation_id] = card_pay_amount;
		     
		     //形成数组对象，传值后端支付。
		     order_data[corp_order_info[corporation_id]['order_id']]['card_pay_amount'] = card_pay_amount;
		     order_data[corp_order_info[corporation_id]['order_id']]['card_buy_id'] = id;
		     
		     //添加显示支付储值卡金额。
		     $('#'+corp_attr_id).parent().append('<span class="card_pay_amount">支付金额：'+card_pay_amount+'</span>');
		     
		  }
		 
		  //统计总共卡使用了多少。
	      for ( x in card_pay_amount_info )
    	  { 
	     	 card_pay_amount_total += parseFloat( card_pay_amount_info[x] );
	      }
	     
		 //支付总额 - 使用储蓄卡支付总额 = 最终要支付的M券。
		  var m_price = parseFloat(order_total_price) - parseFloat(card_pay_amount_total);
	     
		  //判断是否整数，不是浮点数则追加.00
	      if( m_price == parseInt(m_price) )
	      { 
	    	 m_price += '.00';
	      }
	      $('#M_pay_parice').children('span').html('M券支付：'+m_price);
	     
	      console.log(order_data);
	})
			
	
}





//收货地址检查并提交
function save_address(obj)
{
	
	clearSubmitError(obj);
	if(check_con())
	{
		$('form').submit();
	}
}

//用户资料检查并提交
function save_info(obj)
{
	
	clearSubmitError(obj);
	if(check_info())
	{
		$('form').submit();
	}
	
//	alert('ddddd');
}