

<?php 
//是否隐藏底部文件 1:隐藏；else:显示
if (isset($foot_set) && $foot_set === 1) {
    
}else{?>
<!-- 旧版修改于2017-07-14 -->
	<!--<footer>
		<ul>
		    <li class="footer-icon01"><a href="<?php // echo site_url('/home'); ?>" class="">首页</a></li>
		    <li class="footer-icon02"><a href="<?php // echo site_url('search/wechat_searchClassify');?>" class="">分类</a></li>
		    <li class="footer-icon03"><a href="<?php // echo site_url('search/wechat_search_goods?order=updated_at_up')?>" class="">最新</a></li>
		    <li class="footer-icon03"><a href="<?php // echo site_url('search/wechat_search_goods?order=updated_at_down&recommend=new')?>" class="">最新</a></li>
		    <li class="footer-icon04"><a href="<?php // echo site_url('cart');?>" class="">购物车</a></li>
		    <span style="float:left;" class="cart_num1">
		    <?php 
    			//$cartcount = 0;
    			//foreach($this->cart->contents() as $items){
    			//   $cartcount = $cartcount + $items['qty'];
    			//}
    			//if($cartcount>99){
    			 //   echo "99+";?><style type="text/css">.cart_num1{width:25px;}</style>
    		<?php 
    			//}else{
    			//    echo $cartcount;
    			//}
    			?>
	  		</span>
		    <li class="footer-icon05"><a href="<?php echo site_url('member/info');?>" class="">我的</a></li>
		</ul>
	</footer> 底部结束 -->
	
	 <!-- 底部导航栏 -->
    <footer>
        <ul>
            <li class="index_new_footer_01"><a href="<?php echo site_url('home'); ?>" class="">首页</a></li>
            <li class="index_new_footer_02"><a href="<?php echo site_url('search/wechat_searchClassify');?>" class="">分类</a></li>
            <li class=""><a href="<?php echo site_url('Tribe')?>" class="">部落</a></li>
            <li class="index_new_footer_04"><a href="<?php echo site_url('cart');?>" class="">购物车</a></li>
            <span style="float:left;" class="cart_num1">
            <?php 
    			$cartcount = 0;
    			foreach($this->cart->contents() as $items){
    			   $cartcount = $cartcount + $items['qty'];
    			}
    			if($cartcount>99){
    			    echo "99+";?><style type="text/css">.cart_num1{width:25px;}</style>
    		<?php 
    			}else{
    			    echo $cartcount;
    			}
    			?>      
            </span>
            <li class="index_new_footer_05"><a href="<?php echo site_url('member/info');?>" class="">我的</a></li>
        </ul>
        <a href="<?php echo site_url('Tribe')?>" class="index_new_footer_buluo"><img src="images/buluo_icon_01.png" alt=""></a>
    </footer>
<!-- 51易货网新版首页 结束 -->

<?php }?>
  </div><!-- container结束 -->

<?php 
//判断底部导航亮键位置
switch (isset($foot_icon)?$foot_icon:''){
    case 1:{
        ?>
        <style type="text/css">
            footer .footer-icon01 a {
                background-position: -21px -63px;  
            }
        </style>
        <?php
        break;
    }
    case 2:{
        ?>
        <style type="text/css">
            footer .footer-icon02 a {
                background-position: -105px -63px;  
            }
        </style>
        <?php
        break;
    }
    case 3:{
        ?>
        <style type="text/css">
            footer .footer-icon03 a {
                background-position: -192px -63px;  
            }
        </style>
        <?php
        break;
    }
    case 4:{
        ?>
        <style type="text/css">
            footer .footer-icon04 a {
                background-position: -272px -63px;  
            }
        </style>
        <?php
        break;
    }
    case 5:{
        ?>
        <style type="text/css">
            footer .footer-icon05 a {
                background-position: -363px -63px;  
            }
        </style>
        <?php
        break;
    }
}
?>