    

    <div class="Box member_Box clearfix">
         <?php //个人中心左侧菜单  
            $data['left_menu'] = 3;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight">
        	<div class="huankuan_rTop">我的优惠劵</div> 
             <div class="coupon">
                  <ul>
                      <li class="hover" onclick="coupon(this,'not_used')">未使用</li>
                      <li onclick="coupon(this,'used')">已使用</li>
                      <li onclick="coupon(this,'overdue')">已过期</li>
                  </ul>
                
                </div>
            <!-- 未使用开始 -->    
			<div class="gerenzhongxin_03_con01" id="not_used" style="width:930px;">
              <div class="coupon_top"><!-- 未使用 -->
                 <ul style="text-align: center;">
                 <?php if($not_used){?>
                 <?php foreach ($not_used as $v){?>
                    <li>
                     <p><img src="<?php echo IMAGE_URL.$v["coupon_image"];?>"/></p>
                     <div class="coupon_top_nei">
                     <a href="<?php echo site_url("search/discount_goods/".$v["id"]);?>">立即使用</a>
<!--                      <span class="sahngchu"><a href="#"><img src="images/sahngchu.png"/></a></span> -->
                   </div>
                   </li>
                 <?php };?>
                 <?php }else{;?>
                 你还没有优惠券！
                 <?php };?>
                 </ul>
              </div>
            </div>
            <!-- 未使用结束 -->
            
            
            <!-- 已使用开始 -->
            <div class="gerenzhongxin_03_con01" id="used"style="width:930px;display:none;">
              <div class="coupon_top"><!-- 已使用 -->
                 <ul style="text-align: center;">
                 <?php if($used){?>
                 <?php foreach ($used as $v){?>
                    <li>
                     <p><img src="<?php echo IMAGE_URL.$v["coupon_image"];?>"/></p>
                     <div class="coupon_top_nei">
<!--                      <span class="sahngchu"><a href="#"><img src="images/sahngchu.png"/></a></span> -->
                   </div>
                   </li>
                 <?php };?>
                 <?php }else{;?>
                 你还没使用过优惠券！
                 <?php };?>
                 </ul>
              </div>
            </div>
            <!-- 已使用结束 -->
            
            
            <!-- 已过期开始 -->
            <div class="gerenzhongxin_03_con01" id="overdue" style="width:930px;display:none;">
              <div class="coupon_top"><!-- 已过期 -->
                 <ul style="text-align: center;">
                 <?php if($overdue){?>
                 <?php foreach ($overdue as $v){?>
                    <li>
                     <p><img src="<?php echo IMAGE_URL.$v["coupon_image"];?>"/></p>
                     <div class="coupon_top_nei">
<!--                      <span class="sahngchu"><a href="#"><img src="images/sahngchu.png"/></a></span> -->
                   </div>
                   </li>
                 <?php };?>
                 <?php }else{;?>
                 没有过期的优惠券！
                 <?php };?>
                 </ul>
              </div>
            </div>
            <!-- 已过期结束 -->
            
        </div>
    </div>
    
    <script>
    
    //根据状态切换内容
    function coupon(obj,status){
        $(".gerenzhongxin_03_con01").hide();
        $(".hover").removeClass();
        $(obj).addClass("hover");
        
        switch(status){
            case "not_used":
                $("#not_used").show();
                break;
            case "used":
            	$("#used").show();
                break;
            case "overdue":
            	$("#overdue").show();
                break;
        }
    }
    </script>


