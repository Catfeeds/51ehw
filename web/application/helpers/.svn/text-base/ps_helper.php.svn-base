<?php

/**
 * 信息提示方式：1
 * 带多行导航链接,不带自动跳转.
 *
 * @param string $message
 * @param array $gotos
 */
function show_message1($message)
{
	$CI = get_instance();
	
	$comefrom = current_url();

	$CI->session->set_flashdata('message', array('content' => $message, 'level' => $level, 'comefrom' => $comefrom));
	
	redirect($comefrom);
}

/**
 * 信息提示方式：2
 * 带自动跳转
 *
 * @param string $message
 * @param string $goto
 */
function show_message2($message, $goto, $level = 1)
{

	$CI = get_instance();
	
	$comefrom = current_url();

	$CI->session->set_flashdata('message', array('content' => $message, 'level' => $level, 'comefrom' => $comefrom));
	
	redirect($goto);
}

/**
 * 返回当前 query string.
 *
 * @return string
 */
function query_string()
{
    return $_SERVER['QUERY_STRING'];
}

/**
 * 把当前 QUERY_STRING分解成数组
 *
 * @return array
 */
function query_string_to_array()
{
    $params = array();
    $query_string = explode('&', query_string());
    foreach ($query_string as $string){
        if (strpos($string, '=')){
            list($key, $value) = explode('=', $string);
            $params[$key] = $value;
        }
    }
    return $params;
}


/**
 * 序列化文本域内容
 * 
 * 
 */
function serial_save($text) 
{
    $texts = explode("\n",$text);
	$arr = array();
	foreach($texts as $value):
		if(!empty($value))
		$arr[] = $value;
	endforeach;
	$str = implode(',',$arr);
	return $str;	
}

function sreial_show($text)
{
    $texts = explode(",",$text);
	$arr = array();
	foreach($texts as $value):
		if(!empty($value))
		$arr[] = $value;
	endforeach;
	$str = implode("\n",$arr);
	return $str;	
}

/**
 * 限制字符串长度,中文字节理解成一个字符
 * 
 */

function char_limit1($str,$val)
{
	
	$CI = & get_instance();
	if (function_exists('mb_internal_encoding'))
	{
		mb_internal_encoding($CI->config->item('charset'));
	}
    return (mb_strlen($str)>$val) ? mb_substr($str,0,$val) : $str ;    
}

/**
 * 限制字符串长度
 * 
 */
function char_limit2($str,$val)
{
    return (strlen($str)>$val) ? substr($str,0,$val) : $str ;    
}

/**
 * 
 * 
 */

function char_limit3($str,$val)
{
	$CI = & get_instance();
	if (function_exists('mb_internal_encoding'))
	{
		mb_internal_encoding($CI->config->item('charset'));
	}
    return (mb_strlen($str)>$val) ? mb_substr($str,0,$val).'...' : $str ;    
}

/**
 * 限制数值的最高值
 * 
 * 
 */

function num_limit($num,$val)
{
	if(!is_numeric($num)){
		return 0;
	}
    return ((float)$num >(float)$val) ? $val : $num;
}


/**
 * 功能：递归创建文件夹
 * 参数：$param 文件路径
 */
function mkdirsByPath($param){
	if(! file_exists($param)) {
		mkdirsByPath(dirname($param));
		@mkdir($param);
	}
	return realpath($param);
}

/**
 * 功能：删除非空目录 
 */
function deldir($dir) 
{
    $dh=opendir($dir);
    while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
            $fullpath=$dir."/".$file;
            if(!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    if(rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}


/**
 * 功能：两个数组并集 
 */
function array_and($array1=array(), $array2=array()) 
{
   $res = array();   //结果数组
   $res = $array1;   //直接将数组1赋值给结果数组
      
   $arr2 = array_diff($array2,$array1);
   
   $res = array_merge($res , $arr2);

   return is_array($res) ? $res : array();
}

/**
 * 功能：检查权限 
 */

function admin_priv($priv_str)
{   
	$CI = & get_instance();
	$action_list = $CI->session->userdata('account_info')['action_list'];
    if (strpos(',' . $action_list . ',', ',' . $priv_str . ',') === false)
    {                
        return false;
    }  
	
    return true;
}


/**
 * 获得当前格林威治时间的时间戳
 *
 * @return  integer
 */
function gmtime()
{
    return (time() - date('Z'));
}


/**
 * 动态创建属性列表
 *
 * @return  string
 */
function build_attr_html($arrt_type,$attr_id,$option_values = array(),$default_value ='')
 {
	 $html = '';

     switch($arrt_type){

		case     'text': $html = '<input  class="form-control" size="20"                            name="attr_values['.$attr_id.'][]"  type="text" value="'.$default_value.'" 
		                  >'; 
						  break;

		 case 'textarea': $html = '<textarea rows="4" cols="80" name="attr_values['.$attr_id.'][]" class="  
		                  form-control
		                  " >'.$default_value.'</textarea>';       break;

		 case    'radio': foreach($option_values as $value):
			              $html .= ($default_value != $value) ?
			                      '<input  size="20"  name="attr_values['.$attr_id.'][]" type="radio" value="'.$value.'"  >'.$value :
			                      '<input  size="20"  name="attr_values['.$attr_id.'][]" type="radio" value="'.$value.'"  checked="checked">'.$value.'' ;
		                  endforeach;
						  $html .='<input style="width: 20px;" size="20"      
						           type="radio"   name="attr_values['.$attr_id.'][]" value="">不选';
		                  break;
		                 
		 case 'checkbox':
		               if($default_value){
		                   $default_value = array_column($default_value, 'attr_value');
		               }else{ 
		                   $default_value = array('');
		               }
		               foreach($option_values as $value):
		                  $html .= in_array($value,$default_value) ?
			                     '<input style="width: 20px;" size="20"  name="attr_values['.$attr_id.'][]" type="checkbox" value="'.$value.'" checked="true" >'.$value:
			                     '<input style="width: 20px;" size="20"  name="attr_values['.$attr_id.'][]" type="checkbox" value="'.$value.'"  >'.$value;

		                  endforeach;
						  $html .='<input style="width: 20px;" size="20"      
						           type="hidden"   name="attr_values['.$attr_id.'][]" value="">';
		                   break;

		 case   'select': $html .= '<select name="attr_values['.$attr_id.'][]"        
		                  class="form-control"><option value="">请选择...</option>';
		                  foreach($option_values as $value) : 
		                  $html .= ($default_value != $value) ?
							  '<option value="'.$value.'">'.$value.'</option>':
							  '<option value="'.$value.'" selected="selected" >'.$value.'</option>';
		                  endforeach;
		                  $html .='</select>'; break;
         case   'related': $html .= '<select name="attr_values['.$attr_id.'][]"
		                  class="form-control"><option value="">请选择...</option>';
		                  foreach($option_values as $value)
		                  {
		                  	$html .= ($default_value != $value['id']) ? 
		                  		'<option value="'.$value['id'].'" >'.$value['name'].'</option>':
		                  		'<option value="'.$value['id'].'" selected="selected" >'.$value['name'].'</option>';
		                  }
		                  $html .='</select>'; break;
		case   'sku':  
						$html .= '<ul class="spec-color" id="sku_ul_'.$attr_id.'">';

                        $skuinfo = $default_value["skuinfo"];
						$skulist = $default_value["skulist"];

						foreach($option_values as $key=> $value):

							$checked = "";
							$name = "";
							
							foreach($skuinfo as $info)
							{
								if($info["attr_id"] == $attr_id && $info["sku_id"] == $key)
								{
									$checked = "checked";
									$name = $info["sku_name"];
									break;
								}
							}

			              $html .= '<li><input  name="sku_attr_values['.$attr_id.'][]" onclick="skuClick(event,\''.$attr_id.'\')" type="checkbox" value="'.($name == ""?$value:$name).'"  '.$checked.'>';
			               if($checked == "")
							{
						   $html .='<label  style="display: inline;">'.$value.'</label>'.
                                  '<input name="'.$attr_id.'-'.$key.'" type="text" class="input-mini" onblur="changesku(this,\''.$attr_id.'\',\''.$key.'\')" style="display: none; width:60px; height:26px;" value="'.$value.'"></li>';
						   }else
							{
							 $html .='<label  style="display: none;" >'.$name.'</label>'.
                                  '<input name="'.$attr_id.'-'.$key.'" type="text" class="input-mini" onblur="changesku(this,\''.$attr_id.'\',\''.$key.'\')" style="display: inline; width:60px; height:26px;" value="'.$name.'"></li>';
						   }

		                  endforeach;
						  $html .='</ul>' ;
						 if($skulist != null)
						 {
						     
						   $html .="<script>$(document).ready(function() {checkTable('".json_encode($skulist)."');});</script>";
						 }
// 						 echo '<pre>';
// 						 var_Dump($skulist);
						  //$html .='<input style="width: 20px;" size="20"      
						   //        type="hidden"   name="attr_values['.$attr_id.'][]" value="">';
		              break;

	 }
	 return $html;
 }
 
 
 /**
 * @author JF
 * 2017年12月27日
 * 验证部落权限
 * @param string $url 模块url
 */
 function CheckTribePower($url,$tribe_id = 0 ){
    $CI = & get_instance();
    
   
    //如果单独传某个部落进来验证，判断之前的session id 如果不一致才进行重新查询分配权限，不传则使用原session。
    if( $tribe_id && $CI->session->userdata("tribe_id") != $tribe_id )
    { 
        
        //重新查询权限。
        $customer_id = $CI->session->userdata("user_id");//用户id
        $CI->load->model("tribe_power_mdl");
        $tribe = $CI->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//查询管理的部落
        
       
        if(!$tribe || $tribe["status"] != 2)
            return false;
        
        
            $CI->load->model("tribe_power_mdl");
        
            //查询权限并且设置权限session
            if( $tribe["is_host"] )
            {
                $powerlist = $CI->tribe_power_mdl->PowerList();
            }else{
                $powerlist = $CI->tribe_power_mdl->TribePower($tribe["tribe_manager_id"]);
            }
             
        
          
            $power = null;
            foreach ($powerlist as $v){
                $power .= ",".$v["url"].",";
            }
            $CI->session->set_userdata("tribe_id",$tribe_id);
            $CI->session->set_userdata("tribe_power",$power);
        
    }
    
    $tribe_id = $CI->session->userdata("tribe_id");//部落id
    $power = $CI->session->userdata("tribe_power");//权限
   
    if(!$tribe_id || strpos($power,",".$url.",") === false ){
        return false;
    }
    return true;
 }