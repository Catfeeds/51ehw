<?php

/**
 * 根据前缀返回回调处理方法以及路径。
 * @date:2017年12月19日 下午3:34:50
 * @author: fxm
 * @param: variable
 * @return: array();
 */
function select_return_info( $key = 'COP' )
{
    $return['status'] = 0;

    if(  $key == 'COP' )
    {
        //开店。
        $return['function'] = 'after_cash_shop';
        $return['model'] = 'cash_shop_mdl';
        $return['return_url'] = 'Corporation/pay_notify/';
        $return['status'] = 1;
    }

    return $return;

}
 






