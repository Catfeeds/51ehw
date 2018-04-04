var isConOpen = true;
var isPayTypeAndShipTypeOpen = false;
// 自定义订单提交前检查条件
var isNewCon = false;

function clearSubmitError(obj) {
	if (obj.parentNode.childNodes.length > 0) {
		if (obj.parentNode.lastChild.name == 'errorInfo') {
			obj.parentNode.removeChild(obj.parentNode.lastChild);
		}
	}
}

// ----------------------------收货人信息-------------------------------------
var label_consignee;

// 显示地址信息表单
function showForm_consignee(obj) {
	var isConOpen = true;
	isNewCon = true;
	label_consignee = g("part_consignee").innerHTML;
	showWaitInfo('正在读取收货人信息，请等待！', obj);
	// alert(base_url);
	$.ajax({
		url : base_url + "/order_att/consignee_edit",
		type : 'POST',
		data : {
			'consignee' : 'ddd'
		},
		dataType : 'html',
		success : function(data) {
			clearWaitInfo();
			$('#part_consignee').append(data);
		}
	});
}

// 保存地址信息
var consigneeIsSave = false;
var district_id;
function save_consignee(obj) {
	clearSubmitError(obj);
	if (check_con()) {
		consignee_show();
	}
}

// 生成地址
function consignee_show() {
	$.ajax({
		url : base_url + "/order_att/consignee_save",
		data : {
			'consignee' : $('input[name="consignee"]').val(),
			'province_id' : $('#province_id option:selected').val(),
			'city_id' : $('#city_id option:selected').val(),
			'district_id' : $('#district_id option:selected').val(),
			'email' : $('input[name="email"]').val(),
			'phone' : $('input[name="phone"]').val(),
			'mobile' : $('input[name="mobile"]').val(),
			'address' : $('input[name="address"]').val(),
			'postcode' : $('input[name="postcode"]').val()
		},
		type : 'POST',
		dataType : 'html',
		success : function(data) {
			clearWaitInfo();
			$('#part_consignee').empty();
			consignee_reload();
			isNewCon = false;
		}
	});
}

// 重新加载提交订单时的收货地址
function consignee_reload() {
	$.ajax({
		url : base_url + "/order_att/consignee_list",
		data : {},
		type : 'POST',
		dataType : 'html',
		success : function(data) {
			$('#part_consignee').append(data);
		}
	});
}

// 保存收货人信息时的检查
function check_con() {
	var res = true;
	if (!check_addressName()) {
		res = false;
	}
	if (!check_con_area()) {
		res = false;
	}
	if (!check_address()) {
		res = false;
	}
	if (!check_postcode()) {
		res = false;
	}
	if (!check_phoneAndMob()) {
		res = false;
	}
	if (!check_phone()) {
		res = false;
	}
	if (!check_message()) {
		res = false;
	}
	if (!check_email()) {
		res = false;
	}

	return res;
}

// 保存用户信息时的检查
function check_info() {
	var res = true;
	if (!check_con_area()) {
		res = false;
	}
	if (!check_address()) {
		res = false;
	}
	if (!check_postcode()) {
		res = false;
	}
	if (!check_phoneAndMob()) {
		res = false;
	}
	if (!check_phone()) {
		res = false;
	}
	if (!check_message()) {
		res = false;
	}
	if (!check_email()) {
		res = false;
	}

	return res;
}
// 检查收货人姓名
function check_addressName() {
	removeAlert('addressName_empty');
	removeAlert('addressName_ff');

	var pNode = g('consignee_addressName').parentNode;
	if (isEmpty('consignee_addressName')) {
		showAlert('收货人姓名不能为空！', pNode, 'addressName_empty');
		return false;
	}
	return true;
}
// 检查省市区
function check_con_area() {
	removeAlert('area_check');
	var pNode = g('consignee_arae').parentNode;
	if (g('district_id').value == '-22') {
		showAlert('地区信息不完整！', pNode, 'area_check')
		return false;
	}
	return true;
}
// 检查收货人地址
function check_address() {
	removeAlert('address_empty');
	removeAlert('address_ff');

	var pNode = g('consignee_address').parentNode;
	if (isEmpty('consignee_address')) {
		showAlert('收货地址不能为空！', pNode, 'address_empty');
		return false;
	}
	return true;
}
// 检查邮政编码
function check_postcode() {
	removeAlert('postcode_ff');
	if (g('consignee_postcode').value != '') {
		var pNode = g('consignee_postcode').parentNode;
		var myReg = /(^\s*)\d{6}(\s*$)/;
		if (!myReg.test(g('consignee_postcode').value)) {
			showAlert('邮编格式不正确', pNode, 'postcode_ff');
			return false;
		}
	}
	return true;
}
// 检查联系电话
function check_phone() {
	removeAlert('phone_ff');

	var pNode = g('consignee_phone').parentNode;
	return true;
}
// 检查手机号
function check_message() {
	removeAlert('message_ff');
	if (g('consignee_message').value != '') {
		var pNode = g('consignee_message').parentNode;
		var myReg = /(^\s*)(((\(\d{3}\))|(\d{3}\-))?13\d{9}|1\d{10})(\s*$)/;
		if (!myReg.test(g('consignee_message').value)) {
			showAlert('手机号格式不正确', pNode, 'message_ff');
			return false;
		}
	}
	return true;
}
// 检查电话和手机是否都填写了
function check_phoneAndMob() {
	removeAlert('phone_empty');
	var pNode = g('consignee_phone').parentNode;
	if (isEmpty('consignee_phone') && isEmpty('consignee_message')) {
		showAlert('固定电话和手机号码请至少填写一项！', pNode, 'phone_empty');
		return false;
	}
	return true;
}
// 检查Email
function check_email() {
	var iSign = 'email';
	removeAlert(iSign + '_ff');
	if (g('consignee_' + iSign).value != '') {
		var pNode = g('consignee_' + iSign).parentNode;
		var myReg = /(^\s*)\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*(\s*$)/;
		if (!myReg.test(g('consignee_' + iSign).value)) {
			showAlert('电子邮件格式不正确', pNode, iSign + '_ff');
			return false;
		}
	}
	return true;
}
// 保存地址信息
var consigneeIsSave = false;
var district_id;
function savePart_consignee(obj) {
	clearSubmitError(obj);
	if (check_con()) {
		isConOpen = false;
		consigneeIsSave = true;
		district_id = $('#district_id option:selected').val();
		consignee_show();
		pay_and_ship_edit();
	}
}

// -------------------------提交订单信息-----------------
function check_submit() {
	var res = true;
	if (!check_submit_isClose()) {
		res = false;
	}
	return res;
}
function check_submit_isClose() {
	var errInfo = "";
	var address = $('input[name="address_id"]').val();
	if (address == "new" || address == "") {
		errInfo = "请添加一个收货地址";
		alert(errInfo);
		return false;
	}
	return true;
}

function submitOrder(obj,status) {
	if ($('#address_id').val()) {
		var item = new Array();
		var i = 0;
		$("input[name='item[]']").each(function() {
			item[i++] = $(this).val();
		});
		var customer_remark = $("#customer_remark").val();// 交易备注
		var address_id = $('#address_id').val();
		$('#order_submit_status').text('结算中...');
		$('#order_submit_status').parent('div').css('background','#ccc');
		$('#order_submit_status').attr("href",'javascript:void(0)'); 
		
		$.ajax({
			url : base_url + '/order/save',
			type : 'post',
			data : {
				"item" : item,
				"customer_remark" : customer_remark,
				"address_id" : address_id,
				"status":status
			},
			dataType : "html",
			success : function(data) {
				data = JSON.parse(data);
				switch (data['type']) {
				case 'ok':// 成功
					location.href = base_url
							+ '/order/orderfinish?new_order_id='
							+ data['new_order_id'] + '&status='
							+ data['status'] + '&order_sn='
							+ data['order_sn'];
					break;
				case 'fail':// 订单生成失败执行
					alert('订单生成失败');
					location.href = base_url + "/cart";
					break;
				case 'stale':// 特价超时
					var sure_text = '订单内有商品特价,该活动已结束，你是否确定原价购买？';
					sure_bullet(sure_text);
//					$('#prompt').text('订单内有商品特价,该活动已结束，你是否确定原价购买？');
//					$("#teshi").show();
					break;
				case 'stock':// 超过库存执行
					alert(data['p_name'] + '商品超过总库存');
					location.href = base_url + "/cart";
					break;
				case 'not_found_address':// 缺少地址执行
					location.href = base_url + "/member/address/add?path="
							+ base_url + "/cart";
					break;
				default:// 未知问题执行
					location.href = base_url + "/home";
					break;
				}

			},
			error:function() {
				alert('网络连接超时');
				location.reload();
			}
		}); 
	} else {
		$(".black_feds").text("请先添加收货地址").show();
		setTimeout("prompt();", 3000);
		return;
	}
}

//收货地址检查并提交
function save_address(obj) {
	if (check_con()) {
		$('form').submit();
	}
}

//用户资料检查并提交
function save_info(obj) {
	clearSubmitError(obj);
	if (check_info()) {
		$('form').submit();
	}
}