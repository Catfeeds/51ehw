/**
 * 公共验证类
 * 新建方法的同事请确保方法名不冲突
 */

//验证手机
function checkMobile(val){ 
	var patten = /^1[3|4|5|7|8][0-9]{9}$/;
	return patten.test(val);
} 

//验证金额
function validateMoney(val){
	var patten = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
	return patten.test(val);
}

//验证整数
function validateNum(val){
	var patten = /^[0-9]*[1-9][0-9]*$/;
	return patten.test(val);
}

//验证实数
function validateRealNum(val){
	var patten = /^-?\d+\.?\d*$/;
	return patten.test(val);
}

//验证小数，保留一位小数点
function validateNumdecimal(val){
	var patten = /^-?\d+\.?\d{0,1}$/;
	return patten.test(val);
}

//验证小数
function validateFloat(val){
	var patten = /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
	return patten.test(val);
}

//只能输入数字和字母
function validateNumOrLetter(val){
    var patten = /^[A-Za-z0-9]+$/;
    return patten.test(val);
}

//验证颜色
function validateColor(val){
	var patten =  /^#[0-9a-fA-F]{6}$/;
	return patten.test(val);
}

//验证URL
function validateUrl(val){ 
	var patten = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\*\+,;=]|:|@)|\/|\?)*)?$/i;
	return patten.test(val);
}

//验证空
function validateNull(val){
	return val.replace(/\s+/g, "").length !=0;
}
 
//验证时间2010-10-10
function validateDate(val){
	var patten = /^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/;
	return patten.test(val);
}

//验证时间2010-10-10 10:10:10
function validateDatetime(val){
	var patten = /^(?:19|20)[0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:[0-2][1-9])|(?:[1-3][0-1])) (?:(?:[0-2][0-3])|(?:[0-1][0-9])):[0-5][0-9]:[0-5][0-9]$/;
	return patten.test(val);
}
 
//只能输入数字、字母、下划线
function validateNumLetterLine(val){
    var patten =  /^[a-zA-Z0-9_]{1,}$/;
    return patten.test(val);
}

//检查是否为有效的真实姓名，只能含有中文或大写的英文字母 
function isValidTrueName(strName){ 
	var str = Trim(strName); 
	//判断是否为全英文大写或全中文，可以包含空格 
	var reg = /^[A-Z u4E00-u9FA5]+$/; 
	if(reg.test(str)){ 
		return false; 
	} 
	return true; 
} 

//检查email邮箱 
function isEmail(str){ 
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/; 
	return reg.test(str); 
}

//验证经度（保留6位小数）
function isLongitude(str){ 
	var reg =  /^[-\+]?((1[0-7]\d{1}|0?\d{1,2})\.\d{1,6}|180\.0{1,6})$/;
	return reg.test(str); 
}

//验证纬度（保留6位小数）
function isLatitude(str){ 
	var reg = /^[-\+]?([0-8]?\d{1}\.\d{1,6}|90\.0{1,6})$/;
	return reg.test(str); 
}

//验证中文名称
function isChinaName(name) {
 var pattern = /^[\u4E00-\u9FA5]{2,4}$/;
 return pattern.test(name);
}

//验证身份证 
function isCardNo(card) { 
 var pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/; 
 return pattern.test(card); 
} 



//银行卡号码检测
function luhnCheck(bankno) {
	if(bankno.length < 16 || bankno.length > 19){
		return false;
	}
  var lastNum = bankno.substr(bankno.length - 1, 1); //取出最后一位（与luhn进行比较）
  var first15Num = bankno.substr(0, bankno.length - 1); //前15或18位
  var newArr = new Array();
  for (var i = first15Num.length - 1; i > -1; i--) { //前15或18位倒序存进数组
      newArr.push(first15Num.substr(i, 1));
  }
  var arrJiShu = new Array(); //奇数位*2的积 <9
  var arrJiShu2 = new Array(); //奇数位*2的积 >9
  var arrOuShu = new Array(); //偶数位数组
  for (var j = 0; j < newArr.length; j++) {
      if ((j + 1) % 2 == 1) { //奇数位
          if (parseInt(newArr[j]) * 2 < 9) arrJiShu.push(parseInt(newArr[j]) * 2);
          else arrJiShu2.push(parseInt(newArr[j]) * 2);
      } else //偶数位
      arrOuShu.push(newArr[j]);
  }

  var jishu_child1 = new Array(); //奇数位*2 >9 的分割之后的数组个位数
  var jishu_child2 = new Array(); //奇数位*2 >9 的分割之后的数组十位数
  for (var h = 0; h < arrJiShu2.length; h++) {
      jishu_child1.push(parseInt(arrJiShu2[h]) % 10);
      jishu_child2.push(parseInt(arrJiShu2[h]) / 10);
  }

  var sumJiShu = 0; //奇数位*2 < 9 的数组之和
  var sumOuShu = 0; //偶数位数组之和
  var sumJiShuChild1 = 0; //奇数位*2 >9 的分割之后的数组个位数之和
  var sumJiShuChild2 = 0; //奇数位*2 >9 的分割之后的数组十位数之和
  var sumTotal = 0;
  for (var m = 0; m < arrJiShu.length; m++) {
      sumJiShu = sumJiShu + parseInt(arrJiShu[m]);
  }

  for (var n = 0; n < arrOuShu.length; n++) {
      sumOuShu = sumOuShu + parseInt(arrOuShu[n]);
  }

  for (var p = 0; p < jishu_child1.length; p++) {
      sumJiShuChild1 = sumJiShuChild1 + parseInt(jishu_child1[p]);
      sumJiShuChild2 = sumJiShuChild2 + parseInt(jishu_child2[p]);
  }
  //计算总和
  sumTotal = parseInt(sumJiShu) + parseInt(sumOuShu) + parseInt(sumJiShuChild1) + parseInt(sumJiShuChild2);

  //计算luhn值
  var k = parseInt(sumTotal) % 10 == 0 ? 10 : parseInt(sumTotal) % 10;
  var luhn = 10 - k;

  if (lastNum == luhn) {
//      $("#banknoInfo").html("luhn验证通过");
      return true;
  } else {
//      $("#banknoInfo").html("银行卡号必须符合luhn校验");
      return false;
  }
}


