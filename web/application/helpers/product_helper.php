<?php


/**
 *  商品辅助函数库   
 */


/**
 * 计算运费
 * @param array $product 商品信息
 * @param number $qty 数量
 * @return Ambigous <number, unknown>
 */
function freight_count($product,$qty){

    $freight = 0; //运费
    //计算运费
    if(!empty($product['is_freight']) && $product['is_freight'] == 1){
        $default_freight =  $product['default_freight'];//默认价格 10
        $default_item =  $product['default_item'];//默认数量是多少 1
        $add_item  =  $product['add_item'];//每增加多少件 3
        $add_freight =  $product['add_freight'];//每增加X件+多少钱 10

        if($qty > $default_item ){
            $num = $qty - $default_item;//4
            $num_a = $num/$add_item;
            if(preg_match("/^[1-9][0-9]*$/",$num_a) ){ //如果是整数
                $freight = ($num_a*$add_freight)+$default_freight;
            }else{
                if($num_a < 1){
                    $freight = $default_freight+$add_freight;
                }else{
                    $num_a = intval($num_a);
                    $freight = ($num_a*$add_freight) + $add_freight+$default_freight;
                }
            }
        }else{
            $freight = $default_freight;
        }
    }

    return $freight;
}

/**
 * 开店费用
 * @date:2017年12月13日 上午11:00:20
 * @author: fxm
 * @param: variable
 * @return: array();
 */
function corporation_cash()
{ 
    $info[3] = array('cash'=>100000,'name'=>'旗舰店会员');
    $info[2] = array('cash'=>50000,'name'=>'专卖店会员');
    $info[1] = array('cash'=>10000,'name'=>'易货店会员');
    
    return $info;
}




