<style>
.dingdanzhongxin_01_con02_down .dingdanzhongxin_01_con02_down_btn{ margin-top:15px;}
.transformation_btn{ margin-left:90px;}

.pay_logo{ margin-left:25px;}
#basic_tags li {float: left; list-style:none;}
#basic_tags li a {background:url(images/btn_show_tab_01.png) no-repeat 0 center;width: 170px; /*height: 35px;*/ overflow:hidden; display:block; color:#555;}
#basic_tags li a:hover{ color:#555;}
#basic_tags li.selectTag, #basic_tags li.selectTag a{background:url(images/btn_show_tab_02.png) no-repeat 0 center;width: 170px;/* height: 35px;*/display:block; color:#fea33b;}
#tagContent { margin-left:70px;}
.tagContent { display: none; }
#tagContent div.selectTag { display: block }
.order_con{ height:auto;}
.order_con li { margin-right:20px;}
.regsiter_renzheng_right{ margin-left:60px; width:380px; float:none;}
.yingyezhizhao_img{ margin-top:0px;}
.yingyezhizhao_span{margin-top:0px; font-size:14px; color:#555555;}
.yingyezhizhao_span span{ color:#ff3600; margin:0 5px;}
   

</style>
<script src="js/qrcode.js"></script>

         <!--新的支付开始-->
           <div class="gouwuche_box" id="pay_index" >
            <div class="gouwuche_box_top" >支付确认</div>
           	<div class="order_con" style="display:dlock">
               <ul>
                 <li>
                      <span class="order_tit">订单号</span>：
                      <span class="order_num" style="color:#555;" id="order_sn"><?php echo $order_sn?></span>
                 </li>
                 <li>
                      <span class="order_tit">订单金额</span>：
                      <span class="order_num" id="price"><?php echo $total_price?> 货豆</span>  <span class="order_run">(余额：<?php echo round( $user_total_price,2 )?> 货豆)</span>
                 </li>
                 <li>
                      <span class="order_tit">手续费</span>：
                      <span class="order_num" id="commission"><?php echo $commission?> 元</span> <span class="order_run">(现金余额：<?php echo round( $cash,2 )?> 元)</span>
                 </li>
                 <!-- 有余额时候 start-->
                 <h3 style="font-weight:normal" id="pay_input" >
                     <li>
                          <span class="order_tit">支付密码</span>：
                          <span class="order_num"> 
                              <input value="" placeholder=" 请输入支付密码" name="pay_passwd" class="input-text1" type="password">
                          </span>
                          <a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay')?>" class="order_forgetCode">忘记密码？</a>
                     </li>
                     <li style="color:#c32d05; margin-left:150px;" id="pay_messgag" hidden>请输入支付密码</li><!-- 默认隐藏 -->
                 </h3>
                   <li hidden id='pass_message'><span class="payNum_tips">*密码错误，请重新输入</span></li>
              <?php if(!$show_m_pay):?>    
         
                 <!-- 余额不足时候 start-->
                 <h3 style="font-weight:normal;text-align: center; height: 0px; line-height: 0px;" id="not_cash_message" >
                     <li style="margin:30px 0;">
                          <span style="color:#fea33b;">余额不足，需输入支付密码后充值支付 <?php echo  $user_total_price >= $total_price ? round($pay_commission,2) : round(($total_price - $user_total_price) +$pay_commission,2)?> 元</span>
                     </li>
                 </h3>
                 <div class="dingdan4_3_btn01" style="background:#ccc;margin-left: 86px;margin-bottom: 20px; "><a href="javascript:history.back()">取消支付</a></div>
                 <div class="dingdan4_3_btn02" style="margin-bottom: 20px;"><a href="javascript:;" onclick="pay(<?php echo $order_id?>)" id="shouhuo">充值支付</a></div>
         
         <?php else:?>
				 <!-- 余额不足时候 end-->
				 
				  <div class="dingdan4_3_btn01" style="background:#ccc;margin-left: 86px;margin-bottom: 20px; "><a href="javascript:history.back()">取消支付</a></div>
                  <div class="dingdan4_3_btn02" style="margin-bottom: 20px;"><a href="javascript:;" onclick="pay(<?php echo $order_id?>)" id="shouhuo">确认支付</a></div>
         <?php endif;?>
				 
               </ul>
                  
                  
                  <div class="regsiter_renzheng_right clearfix" id="choose_pay" hidden>
                      <div class="renzheng_right_yingyezhizhao">
                      
                      <ul id="basic_tags">
                          	<li class="selectTag">
                              <a onClick="selectTag('tagContent0',this)" href="javascript:void(0)"><span class="pay_logo"><img src="images/wechat_payment.png" alt="微信" /></span></a>
                            </li>
                          
                            <li>
                              <a onClick="selectTag('tagContent1',this)" href="javascript:void(0)"> <span class="pay_logo"><img src="images/alipay_to.png" alt="支付宝" /></span></a>
                            </li>

                            <li>
                              <a onClick="selectTag('tagContent2',this)" href="javascript:void(0)"> <span class="pay_logo"><img src="images/yinlian_pay.jpg" alt="银联" /></span></a>
                            </li>
                          
                      </ul>
                      <div class="clearfix"></div><!--清除浮动-->
                          
                      <div id="tagContent">
                          <div class="tagContent selectTag" id="tagContent0">
                              <div class="yingyezhizhao_new Business_license_new" style="display:block;position:relative;">
<!--                                <p class="yingyezhizhao_span">微信扫码支付:<span>140.00</span>元</p> -->
                              <div class="yingyezhizhao_img" id="qrcode">
                              
<!--                              <img src="images/weipayimg.jpg" alt="扫码支持" title="扫一扫" /> -->
                              
                              </div>
                              </div>
                          </div>
                          <div class="tagContent" id="tagContent1">
                              <div class="yingyezhizhao_old" style="position:relative;">
                                  <div class="yingyezhizhao_img clearfix old_bussiness" > 
                                      <ul>
                                          <li style="margin-top:50px;">
                                              <a href="" target="_blank" id="alipay_link" onclick="$('.dingdan4_6_tanchuang').show()">
                                                  <img src="images/alipayimg2.png" alt="支持扫码" title="支持扫码" />
                                              </a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                          <div class="tagContent" id="tagContent2">
                              <div class="yingyezhizhao_old" style="position:relative;">
                                  <div class="yingyezhizhao_img clearfix old_bussiness" > 
                                      <ul>
                                          <li style="margin-top:50px;">
                                              <a href="" target="_blank" id="Acp_link" onclick="$('.dingdan4_6_tanchuang').show()">
                                                  <img src="images/alipayimg.png" alt="支持扫码" title="支持扫码" />
                                              </a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                     </div>
                      </div>   
                  </div>
             </div> 
           </div>
           
           
           <div class="gouwuche_box" id="pay_ok" hidden >
            <div class="gouwuche_box_top" >支付确认</div>
           	   <div class="order_top">
                 <div class="order_top_nei">
                   <h5><img src="images/gou_8.png"/></h5>
                   <p>支付成功</p>
                 </div>
                 <ul>
                   <li><a href="<?php echo site_url('Member/order/detail/'.$order_id)?>" class="order_top_nei_left">查看我的订单</a></li>
                   <li><a href="<?php echo site_url('Home')?>" class="order_top_nei_rigth">回首页看看</a></li>
                 </ul>
               
               </div> 
           </div>
           
           <div class="gouwuche_box" id="pay_no" hidden>
            <div class="gouwuche_box_top" >支付确认</div>
           	   <div class="order_top">
                 <div class="order_top_xia">
                   <h5><img src="images/fail.png"/></h5>
                   <p>支付失败，请稍后重试！</p>
                 </div>
                 <ul>
                   <li><a href="javascript:history.back()" class="order_top_nei_left">返回重试</a></li>
                   <li><a href="<?php echo site_url('Home')?>" class="order_top_nei_rigth">回首页看看</a></li>
                 </ul>
               
               </div> 
           </div>
           
            <!--通用操作 弹窗start-->
        <div class="dingdan4_6_tanchuang" style="display:none">
          <div class="dingdan4_3_tanchuang_con">
              <div class="dingdan4_3_tanchuang_top">支付中，请勿关闭页面</div>
              <div class="dingdan4_3_tanchuang_top2">
                  <p id='prompt'><img src="images/za1.png"/></p>
                  <div class="prompt_1">
                    <p>请您在新打开的页面进行支付，支付完成前请不要关闭该窗口。</p>
                    <em>
                    <div class="prompt_top"><a href="<?php echo site_url('Member/order/detail/'.$order_id)?>">已完成支付</a></div>
                    <div class="prompt_xia"><a href="<?php echo site_url('Member/faq')?>">支付遇到问题</a></div>
                    <span><a href="javascript:void(0);" id="return" onclick="$('.dingdan4_6_tanchuang').hide()">返回重选</a></span>
                    </em>
                  </div>
              </div>
          </div>
        </div>
        <!--通用操作 弹窗end-->

        <?php if( !empty($not_password) ):?>
    	    <div class="dingdan4_3_tanchuang" id='dingdan4_3_tanchuang_3' onclick="$('#dingdan4_3_tanchuang_3').hide()">
                  <div class="dingdan4_3_tanchuang_con">
                  <div class="dingdan4_3_tanchuang_top">您还没有设置支付密码,点击<a href ="<?php echo site_url('member/save_set/paypwd_set')?>" style="color:#fea33b">这里</a>去设置支付密码</div>
            </div>
        <?php endif;?>
	</div>
	
    <!--弹窗 结束-->
    <script>
    var Third_pay = 'Alipay'; 
    var pay_ok_html = '#pay_ok';
    var pay_no_html = '#pay_no';
    var body = '#pay_index';
    
    function pay( id ){
    	$('#pass_message').hide();
        var pass = $('input[name=pay_passwd]').val();
        
        if( !pass )
    	{
        	alert('请输入支付密码'); 
        	return;
    	}
        
    	
    	$.ajax({
            <?php if($show_m_pay):?>
                url:'<?php echo site_url('Order/pay_order')?>', //普通货豆支付
                data:{id:id, pass:pass},
            <?php else:?>
                url:'<?php echo site_url('Member/Order/wechat_pay')?>', //充值支付
                data:{id:id, pass:pass},
            <?php endif;?>
            
            dataType:'json',
            type:'post',
            beforeSend:function(){     

    	    },
            success:function(data){
                switch(data.status){
                    case 1:
                    	<?php if($show_m_pay):?>
                  	        $(pay_ok_html).show();
                  	        $(body).hide();
                        <?php else:?>
                            $('input[name=pay_passwd]').attr("disabled",true); 
                            $('#choose_pay').show();
                            $('#alipay_link').attr('href',base_url+"/Alipay/charge_pay/"+data.charge_id+'/1');
//                             $('#Acp_link').attr('href',base_url+"/Acppay/pay/charge_pay/"+data.charge_id+"/POR");
                             $('#Acp_link').attr('href',base_url+"/Acppay/Notify_url/charge_pay/"+data.charge_id+"/POR");
                        	wechat_code(data.charge_id);//显示充值方式-默认微信二维码
                        	is_ok( data.charge_id );
                            //window.location.href=base_url+"/Wechatpay/js_api_call/pay/"+data.charge_id+'/3';
                        <?php endif;?>
                        break;
                    case 2:
                    	alert("订单错误或已完成支付，请勿重复发起支付");
                        window.location.href=base_url+"/Member/order/";
                        break;
                    case 3:
                    	$('#pass_message').show();
                        break;
                    case 4:
                    	location.reload();  
                        break;
                    case 5:
                    	location.reload();  
                        break;
                    case 6:
                    	alert("该订单或已完成支付");
                        window.location.href=base_url+"/Member/order/detail/"+data.id;
                        break;
                    default:
                    	$(pay_no_html).show();
          	            $(body).hide();
                        break;
                }

            },
            error:function(){
            	alert('支付失败');

            }
        })
    }


    //获取支付二维码
    function wechat_code(id)
    {
        $.ajax({
            url:'<?php echo site_url('Wechatpay/Native_dynamic_qrcode/charge')?>'+'/'+id+'/2', //微信
            dataType:'json',
            type:'get',
            beforeSend:function(){     
            	
    	    },
            success:function(data){

            	if( data.code_url )
        		{
            		
                    var url = data.code_url;
            		//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
            		var qr = qrcode(10, 'M');
            		qr.addData(url);
            		qr.make();
            		var code=document.createElement('DIV');
            		code.innerHTML = qr.createImgTag();
            		var element=document.getElementById("qrcode");
            		element.appendChild(code);
        		}

            },
            error:function(){
            	alert("微信扫码获取失败,请选择支付宝支付");
            }
        })
    }
    </script>
  <script type=text/javascript>
function selectTag(showContent,selfObj){
	// 操作标签 
	var tag = $('#basic_tags');
	var $Obj=$(selfObj.parentNode);
	
	//操作内容
	for(i=0; j=document.getElementById("tagContent"+i); i++){
		j.style.display = "none";
	}
	
	document.getElementById(showContent).style.display = "block";
	$Obj.siblings().removeClass('selectTag');
	$Obj.addClass('selectTag');



	
}


function is_ok( charge_id ){ 
	$.ajax({ 
        url:"<?php echo site_url('Charge/charge_status')?>",
        data:{charge_id:charge_id},
        type:'post',
        dataType:'json',
        success:function (data){
            if(data){ 
            	$(pay_ok_html).show();
      	        $(body).hide();
            	
            }else{ 
            	setTimeout("is_ok('"+charge_id+"')",3000); 
            }
        }
	})

}

</script>
