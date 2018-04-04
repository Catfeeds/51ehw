<?php foreach ( $list as $v ){ ?>
	
	<br/>分成用户：<?php echo $v['customer_name'].'<br/>'?>
	
	<?php echo Rebate_Obj ( $v['rebate_info'] )?>
		

	
<?php }?>


<?php 

/**
	 * 无限层分成-将 （角色+对象+比率） 合并起来，最终调用计算方法，返回完整结果。
	 * @$role_ratio = 角色，比率。
	 * @$role_obj =  角色，对象。
	 *
	 */

	function Rebate_Obj( $role_ratio = array(), &$html='' )
    {
     
       
        //查看是否有下级,如果下级存在就是虚拟角色.
        foreach ( $role_ratio as $k => $val )
        {

            $val['level'] = $val['level']+1;
            
            $text = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $val['level']);
            $html .= "<br/>
            {$text}分成角色：{$val['role_name']}<br/>
            {$text}分成比率：{$val['rebate']}<br/>
    		{$text}分成对象：{$val['obj_name']}<br/>
    		";
        	
    		
            if( isset( $val['children'] ) )
            {
                //递归。
                if( $k != 8 )
                {
                    Rebate_Obj($val['children'],$html );
                }
                
            }
           
        }
         
       
	     
	    return $html;
	}

?>