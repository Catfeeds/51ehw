<?php 
//表单验证类

//验证手机
function checkMobile($val){ 
    
	$patten = "/^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/";
	return preg_match($patten, $val);
} 


//验证时间2010-10-10 10:10:10
function validateDatetime($val){
    $patten = "/^(?:19|20)[0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:[0-2][1-9])|(?:[1-3][0-1])) (?:(?:[0-2][0-3])|(?:[0-1][0-9])):[0-5][0-9]:[0-5][0-9]$/";
    return preg_match($patten, $val);
}

//验证时间2010-10-10
function validateDate($val){
    $patten = "/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/";
    return preg_match($patten, $val);
}

/**
 * 验证是否数字
 */
function  validateInteger( $val )
{ 
    if ( $val && is_numeric( $val ) && strpos( $val,'.') == false )
    {
        return true;
    }
    
    return false;
}

/**
 * 验证必填，不能null和空格和数组
 */
function  validateRequired( $val )
{
    if ( !is_array($val) && (!empty(trim($val)) ||  $val === 0))
    {
        return true;
    }
    
    return false;
}

/**
 * func 验证中文姓名
 * @param $name
 * @return bool
 */
function isChineseName($name){
    if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,5}$/', $name)) {
        return true;
    } else {
        return false;
    }
} 



// ------------------------------验证身份证15、18位开始-----------------------------------------
/**
 * 验证身份证15、18位
 * @param unknown $idcard
 * @return boolean
 */
function checkIdCard($idcard){  
    // 只能是18位  
    if(strlen($idcard) !=18 && strlen($idcard) != 15){  
        return false;  
    }
    if(strlen($idcard) == 15){
        $idcard = idcard_15to18($idcard);
    }
    
    // 取出本体码  
    $idcard_base = substr($idcard, 0, 17);  
    // 取出校验码  
    $verify_code = substr($idcard, 17, 1);  
    // 加权因子  
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);  
    // 校验码对应值  
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');  
    // 根据前17位计算校验码  
    $total = 0;  
    for($i=0; $i<17; $i++){  
        $num = substr($idcard_base, $i, 1);
        if(is_numeric($num)){
            $total += substr($idcard_base, $i, 1)*$factor[$i];  
        }else{
            return false;
        }
        
    }  
    
    // 取模  
    $mod = $total % 11;  
  
    // 比较校验码  
    if($verify_code == $verify_code_list[$mod]){  
        return true;  
    }else{  
        return false;  
    }  
}  
// 将15位身份证升级到18位
function idcard_15to18($idcard){
    if(strlen($idcard)!=15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
            $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
        }else{
            $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
        }
    }
    $idcard=$idcard.idcard_verify_number($idcard);
    return $idcard;
}
// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base){
    if(strlen($idcard_base)!=17){
        return false;
    }
    //加权因子
    $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
    //校验码对应值
    $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
    $checksum=0;
    for($i=0;$i<strlen($idcard_base);$i++){
        $num = substr($idcard_base,$i,1);
        if(is_numeric($num)){
            $checksum += substr($idcard_base,$i,1) * $factor[$i];
        }else{
            return false;
        }
        
    }
    $mod=$checksum % 11;
    $verify_number=$verify_number_list[$mod];
    return $verify_number;
}
// ------------------------------验证身份证15、18位结束-----------------------------------------




?>