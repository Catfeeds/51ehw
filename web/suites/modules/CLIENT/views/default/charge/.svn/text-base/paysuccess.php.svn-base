<!DOCTYPE html>
<html>
<head>
        <title>充值完成</title>
        <base href="<?php echo THEMEURL; ?>" />
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <link href="css/base.css" rel="stylesheet" type="text/css"/>
        <link href="css/public.css" rel="stylesheet" type="text/css"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="css/cart.css" rel="stylesheet" type="text/css"/>
        <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
        <script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
		<script type="text/javascript" src="js/jqnav.js" ></script>
<script type="text/javascript">    

</script>
</head>
<body>
<?php $this->load->view('_header');?>  

        <!-- head-top E -->
        <div class="ui-bd w980">
        	<?php if($payment_id == 1){?>
            <div class="ui-pay-success">
       <ul>
           <li class="ui-success-title fn-clear"><i></i><strong><?php echo $message?></strong></li>
           <li class="ui-success-list"><label>支付方式：</label>快银支付</li>
           <li class="ui-success-list"><label>充值单号：</label><?php echo $order_id;?></li>
           
           <li class="ui-success-but">
               <a href="<?php echo site_url('goods/lists');?>" class="ui-shop-to but buy-dakelight">继续购物</a>
           </li>
       </ul>
   </div>   
            <?php }else{ ?>

      
            <div class="ui-pay-success">
			   <ul>
				   <li class="ui-success-title fn-clear"><i></i><strong><?php echo $message;?></strong></li>
				   <li class="ui-success-list"><label>支付方式：</label>支付宝支付</li>
				   <li class="ui-success-list"><label>充值单号：</label><?php echo $orderid;?></li>
				   
				   <li class="ui-success-but">
					   <a href="<?php echo site_url('goods/lists');?>" class="ui-shop-to but buy-dakelight">继续购物</a>
				   </li>
			   </ul>
		   </div>   

		<?php }?>
			
			
        </div>
		
<?php $this->load->view('_footer');?>
    </body>
</html>

