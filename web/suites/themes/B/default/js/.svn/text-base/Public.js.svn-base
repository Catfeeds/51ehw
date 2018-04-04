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

/**
 * 匹配出图片img标签（即匹配出所有图片）
 * @param str
 * @returns {Array}
 */
function match_img(str){
	var result = new Array();
	result[1] = "";
	
	//思路分两步：作者（yanue）.
	//1，匹配出图片img标签（即匹配出所有图片），过滤其他不需要的字符
	//2.从匹配出来的结果（img标签中）循环匹配出图片地址（即src属性）

	//匹配图片（g表示匹配所有结果i表示区分大小写）
	var imgReg = /<img.*?(?:>|\/>)/gi;
	//匹配src属性
	var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
	var arr = str.match(imgReg);
	if(arr){
    	for (var i = 0; i < arr.length; i++) {
    		str = str.replace(arr[i],'');
    		if(i == 0){
    			var src = arr[0].match(srcReg);
                //获取图片地址
                if(src[1]){
                	result[1] = src[1];
                }
    		}
    	}
	}
	
    str = str.replace(/<\/?[^>]*>/g,''); //过滤html标签
    str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
    str = str.replace(/ /ig,'');//去掉 
    result[0] =str;
	return result;
}