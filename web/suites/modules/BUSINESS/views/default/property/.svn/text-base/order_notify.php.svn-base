<style>
.dingdanzhongxin_01_con02_down .dingdanzhongxin_01_con02_down_btn{ margin-top:15px;}
.transformation_btn{ margin-left:90px;}

.pay_logo{ margin-left:25px;}
#basic_tags li {float: left; list-style:none;}
#basic_tags li a {background:url(images/btn_show_tab_01.png) no-repeat 0 center;width: 150px; /*height: 35px;*/ overflow:hidden; display:block; color:#555;}
#basic_tags li a:hover{ color:#555;}
#basic_tags li.selectTag, #basic_tags li.selectTag a{background:url(images/btn_show_tab_02.png) no-repeat 0 center;width: 150px;/* height: 35px;*/display:block; color:#fea33b;}
#tagContent { margin-left:70px;}
.tagContent { display: none; }
#tagContent div.selectTag { display: block }
.order_con{ height:auto;}
.order_con li { margin-right:20px;}
.regsiter_renzheng_right{ margin-left:60px; width:360px; float:none;}
.yingyezhizhao_img{ margin-top:0px;}
.yingyezhizhao_span{margin-top:0px; font-size:14px; color:#555555;}
.yingyezhizhao_span span{ color:#ff3600; margin:0 5px;}
</style>


           
           <div class="gouwuche_box">
            <div class="gouwuche_box_top" >支付确认</div>
           	   <div class="order_top">
                 <div class="order_top_nei">
                   <h5><img src="<?php echo $code == 1 ? 'images/gou_8.png' : 'images/fail.png'?>"></h5>
                   <p <?php echo $code == 1 ? '' : 'style=color:red'?> ><?php echo $message;?></p>
                 </div>
                 <ul>
                 <?php if( $code == 1):?>
                     <li><a href="<?php echo site_url("Member/order/detail/".$orderid)?>" class="order_top_nei_left">查看订单详情</a></li>
                     <li><a href="<?php echo site_url('Home')?>" class="order_top_nei_rigth">回首页看看</a></li>
                 <?php else:?>
                     <li><a href="<?php echo site_url('Member/order')?>" class="order_top_nei_left">订单列表</a></li>
                     <li><a href="<?php echo site_url('Home')?>" class="order_top_nei_rigth">回首页看看</a></li>
                 <?php endif;?>
                 </ul>
               
               </div> 
           </div>
           
        