 
<form action="<?php echo site_url('member/address/save')?>" id="order_save" method="post">
    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 4;
            $this->load->view('customer/leftmenu',$data);
         ?>
    
		<div class="huankuan_cmRight">
        	<div class="huankuan_rTop">收货地址</div>
            <div class="kehufuwu_04_top2"><h4><?php echo $part_title;?></h4></div>
            <div class="gerenzhongxin_01_con clearfix">
            	<div class="gerenzhongxin_01_con_left">
                	<ul>
                    	<li><span>*</span>收货人姓名：</li>
                        <li><span>*</span>所在地：</li>
                        <li><span>*</span>具体地址：</li>
                        <li><span>*</span>邮编：</li>
                        <li><span>*</span>手机号码：</li>
                        <li>固定电话：</li>
                        <li>电子邮件：</li>
                    </ul>
                </div>
                
                <div class="gerenzhongxin_01_con_right">
                	<ul>
                    	<li><input id="consignee_addressName" name="consignee"   type="text" class="gerenzhongxin_01_con_input" placeholder="请填写收货人姓名" value="<?php echo $address['consignee'] ?>" required> <span class='state1'>&nbsp;<!-- 请填写收货人姓名--></span></li>
                        <li>   
                               <span id="consignee_arae" style="margin-left:0" >
                                <?php 
                                $data['province_selected'] = $address['province_id'];
                                $data['city_selected'] = $address['city_id'];
                                $data['district_selected'] = $address['district_id'];
                                ?>
                                <?php $this->load->view('widget/district_select',$data); ?>
                                </span>
                                <span class='state1' style="margin-left:0;">&nbsp;<!-- 请填写具体地址--></span>
                         </li>
                    	<li><input name="address" id="consignee_address" placeholder="请填写具体地址"  type="text" class="gerenzhongxin_01_con_input" value="<?php echo $address['address'] ?>"required><span class='state1'>&nbsp;<!-- 请填写具体地址--></span></li>
                        <li><input type="text"  name="postcode" value="<?php echo $address['postcode'] ?>" id="consignee_postcode" class="gerenzhongxin_01_con_input" placeholder="请填写邮政编码"required><span class='state1'>&nbsp;<!-- 请填写邮政编码--></span></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" placeholder="请填写手机号码" id="consignee_phone"   name="mobile" value="<?php echo $address['mobile'] ?>" required><span class='state1'>&nbsp;<!-- 请填写手机号码--></span></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" placeholder="请填写固定电话" id="consignee_message"  name="phone" value="<?php echo $address['phone'] ?>" ><span class='state1'>&nbsp;<!-- 请填写固定电话--></span></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" placeholder="请填写电子邮箱" id="consignee_email"  name="email" value="<?php echo $address['email'] ?>"><span class='state1'>&nbsp;<!-- 请填写电子邮箱--></span></li>
                        <input type="hidden" name="address_id" value="<?php echo $address['id'] ?>">
                        
                    </ul>
                    <div class="gerenzhongxin_01_xiugai_btn"><a id="sub">保存</a></div>
                </div>
                 
            </div>
            
        </div>



    </div>
</form> 
<script>
   $("#sub").click(function(){
	   var ok1=false;
	   var ok2=false;
	   var ok3=false;
	   var ok4=false;
	   var ok5=false;
	   var ok6=true;
	   var ok7=true;
	   //收货人
       if($('input[name="consignee"]').val()==''){
    	   $('input[name="consignee"]').next().text('请填写收货人姓名').removeClass('state1').addClass('state3');
       }else if(!/^[\u4e00-\u9fa5a-zA-Z]+$/.test($('input[name="consignee"]').val())){
    	   $('input[name="consignee"]').next().text('收货人格式不正确').removeClass('state1').addClass('state3');
       }else{                  
    	   $('input[name="consignee"]').next().text('').removeClass('state1').addClass('state4');
           ok1=true;
       }
	        
	   //具体地址
       if($('input[name="address"]').val()==''){
    	   $('input[name="address"]').next().text('请填写具体地址').removeClass('state1').addClass('state3');
       }else{                  
    	   $('input[name="address"]').next().text('').removeClass('state1').addClass('state4');
           ok2=true;
       }
	        
	   //邮政编码
	   	if($('input[name="postcode"]').val().search(/^[0-9][0-9]{5}$/)==-1){
	   		$('input[name="postcode"]').next().text('请填写邮政编码').removeClass('state1').addClass('state3');
	       }else{                  
	    	   $('input[name="postcode"]').next().text('').removeClass('state1').addClass('state4');
	           ok3=true;
	       }
	        
	   //手机号码
       	if(! /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|14[0-9])[0-9]{8}$/.test($('input[name="mobile"]').val())){
       		$('input[name="mobile"]').next().text('请填写手机号码').removeClass('state1').addClass('state3');
           }else{                  
        	   $('input[name="mobile"]').next().text('').removeClass('state1').addClass('state4');
               ok4=true;
           }
        
	        
	   //验证邮箱
  	   if($('input[name="email"]').val()!=''){
           if($('input[name="email"]').val().search(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/)==-1){
        	   $('input[name="email"]').next().text('请输入正确的EMAIL格式').removeClass('state1').addClass('state3');
           }else{                  
        	   $('input[name="email"]').next().text('').removeClass('state1').addClass('state4');
               ok5=true;
           }
  	   }else{
    		 ok5=true;
  	  	   }

       //地区
       if($('#city_id').val() == 1 || $('#city_id').val() == '' || $('#district_id').val() == ''  ){
          	//alert("请选择所在地");
    	   $('#consignee_arae').next().text('请选择地址').removeClass('state1').addClass('state3');
          	ok6 = false;
          }
       
       //验证邮箱
       if($('input[name="phone"]').val()){
           if(!/^((\+?86)|(\(\+86\)))?\d{3,4}-\d{7,8}(-\d{3,4})?$/.exec($('input[name="phone"]').val())){
        	   $('input[name="phone"]').next().text('电话号码不正确').removeClass('state1').addClass('state3');
        	   ok7=false;
           }else{
        	   $('input[name="phone"]').next().text('').removeClass('state1').addClass('state4');
               }
       }else{
    	   $('input[name="phone"]').next().text('').removeClass('state1').addClass('state4');
           }
       

       if(ok1 && ok2 && ok3 && ok4 && ok5 && ok6 && ok7){
	       $('form').submit();
	       }
	   });
</script>

<style>
<!--
.state1 {
	
}
.state3{
	color:red !important;
}
-->
</style>

