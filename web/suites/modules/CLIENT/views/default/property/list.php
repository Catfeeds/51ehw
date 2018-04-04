<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="css/reset.css" rel="stylesheet" type="text/css"> 注释-->
<link href="css/theme/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/theme/style.css" rel="stylesheet" type="text/css">
<link href="css/theme/style_v2.css" rel="stylesheet" type="text/css">
<title>51易货网</title>
</head>

<body>

	<div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 2;
            $this->load->view('customer/leftmenu',$data);
         ?>

         <!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" display:block">
        	<div class="huankuan_rTop" style="display:block">货豆余额纪录</div>
            <div class="huankuan_rTop_1" style="display:none">授信纪录</div>
            <div class="huankuan_rTop_2" style="display:none">现金余额</div>
            <div class="huankuan_rTop_3" style="display:none">现金转货豆</div>
            <div class="dd">
            <div class="huankuan_rCon01">
            	<ul>
                	<li class="<?php echo !$status || $status == 3? 'huankuan_rCon01_current' :''?>"><a href="<?php echo site_url('member/property/get_list/')?>" id="collect_shop" >货豆余额 </a></li>
                    <li class="huankuan_line"></li>
                    <li class ="<?php echo $status == 2 ? 'huankuan_rCon01_current' :''?>"><a  href="<?php echo site_url('member/property/get_list/2')?>" id="collect_shops">现金余额</a></li>
                    <li class ="<?php echo $status == 4 ? 'huankuan_rCon01_current' :''?>"><a  href="<?php echo site_url('member/property/get_list/4')?>" id="collect_shops">线上储值卡</a></li>
                </ul>
                <dl>
                  <dd class=""><a href="javascript:void(0);" onClick="show()" id="cash">现金转货豆</a></dd>
                  <dd><a href="<?php echo site_url('member/property/pay_index')?>"  id="cash1">充值</a></dd>
                </dl>
            </div>
            <div class="kehuguanli_con_top clearfix" style="display:block">
                <?php if(!$status || $status == 3):?>
                     <ul>
                         <li class="<?php echo !$status? 'huankuan_rCon01_current' :''?>"><a href='<?php echo site_url('member/property/get_list')?>' id="detailed_1">查看货豆明细</a></li>
                         <li class ="<?php echo $status == 3 ? 'huankuan_rCon01_current' :''?>"><a href='<?php echo site_url('member/property/get_list/3')?>' id="detailed_2">查看授信明细</a></li>
                     </ul>
                <?php endif;?>
                
                   <div class="kehuguanli_con02" style="display:block">
                      <?php if(!$status || $status == 3):?>
                      <h5><span>货豆可用余额：</span><span class="con02_l"><?php echo  number_format( (isset($customer['M_credit']) ? $customer['M_credit'] : '0.00') + (isset($customer['credit']) ? $customer['credit'] : '0.00'),2 )?></span>   <em>(<span>货豆实际余额：</span><span class="con02_l"><?php echo isset($customer['M_credit']) ? $customer['M_credit'] : '0.00'?> </span><span>授信额度：</span><span class="con02_l"><?php echo isset($customer['credit']) ? $customer['credit'] : '0.00' ?></span>)</em></h5>
                     <?php elseif( $status == 2):?>
                      <h5><span>现金可用余额：</span><span class="con02_l"><?php echo number_format( (isset($customer['cash']) ? $customer['cash'] : '0.00') ,2)?></span></h5>
                     <?php endif;?>
                     
                    <?php if(!$status || $status == 2){?>
                    <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1" style=" border-top:none">
                    	<tr class="tr2 manage_b_tr1">
                        <th width="202px">时间</th>
                        <th width="202px">存入</th>
                        <th width="202px">支出</th>
                        <th width="303px">备注</th>
                    </tr>
                    <?php if(count($list) > 0):?>
                        <?php foreach ($list as $v):?>
                             <tr class="tr3 manage_b_tr1">
                                 <th width="202px"><?php echo $v['created_at']?></th>
                                     <th width="202px"><?php echo $v['type'] == 1 ? (isset($v['amount']) ? $v['amount'] : $v['cash']) :'-'?></th>
                                     <th width="202px"><?php echo $v['type'] == 2 ? (isset($v['amount']) ? $v['amount'] : $v['cash']) :'-'?></th>
                              <th width="303px"><?php echo $v['remark']?><?php echo !empty($v['order_no'] )  ? '订单号：'.$v['order_no'] :''?><?php echo !empty($v['charge_no']) ? '订单号：'.$v['charge_no'] :''?></th>
                             </tr>
                         <?php endforeach;?>
                    <?php endif;?>
                    </table>
                    
                    <?php }else if( $status == 3 ){?>
                      
                      
                    <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1" style=" border-top:none">
                    	<tr class="tr2 manage_b_tr1">
                        <th width="152px">授信时间</th>
                        <th width="152px">开始时间</th>
                        <th width="152px">结束时间</th>
                        <th width="152px">授信金额</th>
                        <th width="303px">备注</th>
                    </tr>
                    <?php if(count($list) > 0):?>
                        <?php foreach ($list as $v):?>
                             <tr class="tr3 manage_b_tr1">
                                <th width="152px"><?php echo $v['created_at']?></th>
                                <th width="152px"><?php echo $v['credit_start_time']?></th>
                                <th width="152px"><?php echo $v['credit_end_time']?></th>
                                <th width="152px"><?php echo $v['credit']?></th>
                                <th width="303px"><?php echo $v['remark']?></th>
                             </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    
                    </table>
                   
                   <?php }else{?>
                   
                       <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1" style=" border-top:none">
                    	<tr class="tr2 manage_b_tr1">
                        <th width="152px">时间</th>
                        <th width="120px">收入</th>
                        <th width="120px">支出</th>
                        <th width="300px">备注</th>
                       
                    </tr>
                    <?php if(count($list) > 0):?>
                        <?php foreach ($list as $v):?>
                             <tr class="tr3 manage_b_tr1">
                                <th width="152px"><?php echo $v['created_at']?></th>
                               	<th width="120px"><?php echo $v['type'] == 1 ? $v['card_amount'] :'-'?></th>
                                <th width="120px"><?php echo $v['type'] == 2 ? $v['card_amount']:'-'?></th>
                                <th width="300px"><?php echo $v['remarks']?></th>
                               
                             </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    
                    </table>
                   	
                   <?php }?>
                   
                    </div>
                </div>
                <div class="pingjia_jilu" style="margin-left:30px">
                     <p>显示 <?php if(count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo '0';?> 到 <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                </div>
                <div class="pingjia_showpage" style="margin-right:30px">
                    	<?php echo $page;?>
                    	  
<!--                     	<a href="#" class="lPage">上一页</a> -->
<!--                         <a href="#">1</a> -->
<!--                         <a href="#">2</a> -->
<!--                         <a class="cpage">3</a> -->
<!--                         <a href="#">4</a> -->
<!--                         <a href="#">5</a> -->
<!--                         <a href="#">6</a> -->
<!--                         <a href="#">7</a> -->
<!--                         <a href="#">8</a> -->
<!--                         <span>…</span> -->
<!--                         <a href="#" class="lPage">下一页</a> -->
                        
               </div>
                <!--  
                <div class="kehuguanli_con_top_1" style="display:none;">
                   <div class="kehuguanli_con04" style="display:none">
                      <h5><span>现金可用余额：</span><span class="con02_l">158678.00</span></h5>
                    <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1" style=" border-top:none">
                    	<tr class="tr2 manage_b_tr1">
                        <th width="202px">时间</th>
                        <th width="202px">存入</th>
                        <th width="202px">支出</th>
                        <th width="303px">备注</th>
                    </tr>
                     <tr class="tr3 manage_b_tr1">
                         <th width="202px">2015-10-1 14:48:00</th>
                         <th width="202px">2000.00</th>
                         <th width="202px">－</th>
                         <th width="303px">销售收入订单号：2325654222</th>
                     </tr>
                     <tr class="tr3 manage_b_tr1">
                         <th width="202px">2015-10-1 14:48:00</th>
                         <th width="202px">2000.00</th>
                         <th width="202px">－</th>
                         <th width="303px">购买订单号：5566999955514</th>
                     </tr>
                    </table>
                    </div>
                </div>
                -->
                    </div>
                    </div> <!--货豆余额纪录结束-->
                      <!--现金转货豆开始-->
                    <div class="huankuan_cmRight_1" style="display:none">
                        <div class="huankuan_rTop_4" style="display: block">现金转货豆</div>
                        <div class="huankuan_rTop_6" style="display: none">转换成功</div>
                        <div class="transformation" style="display:dlock">
                     <ul>
                       <li><span>现金账号余额：</span><span class="yan_r"><?php echo isset($customer['cash']) ? $customer['cash'] :'0.00'?></span></li>
                       <li class="yan_l"><span>货豆实际余额：</span><span class="yan_r"><?php echo isset($customer['M_credit']) ? $customer['M_credit'] :'0.00'?></span></li>
                       <li class="yan_l"><span>转货豆金额：</span><span class=""> <input type="text" onkeyup="value=value.replace(/[^\-?\d.]/g,'')"  value="" placeholder=" 请输入金额" name="charge_m" class="input-text1"></span></li>
                        购买数量限额大于0，小于等于50000
                     </ul>
            <div class="transformation_btn">
          <div class="transformation_btn01" style="background:#ccc;"><a href='<?php echo site_url('member/property/get_list')?>'>取消</a></div>
          <div class="transformation_btn02"><a href="javascript:void(0);" id="determine_1">确定</a></div>       
      </div>
                 </div>
                 <div class="transformation_1" style="display:none">
                   <span><img src='images/success1.png' ></span>
                   <h5>转换成功</h5>
                   <p><a href="<?php echo site_url('member/property/get_list')?>">点击查看我的资产</a></p>
                 </div>
            </div>  <!--现金转货豆结束-->
                    
             <div class="huankuan_cmRight_2" style=" display:none">
            <div class="huankuan_rTop_5" style="display: block">充值</div>
           
            </div>
        </div>
    </div>
 <!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang"style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'>本操作为不可逆操作，请确认是否需要把现金转成货豆</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗start-->
<div class="dingdan4_5_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">输入支付密码</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'><input type="password" value="" placeholder="输入支付密码" name="pay_password" class="input-text1"><span><a href="<?php echo site_url('customer/forget_password')?>">忘记密码？</a></span></p>
          <span hidden id='pass_message' style="margin-right:200px;" class="payNum_tips">*密码错误，请重新输入</span>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn03" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
          <div class="dingdan4_3_btn04"><a href="javascript:void(0);" onclick="ajax_submit()">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

  <!--验证支付密码是否存在－-><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" hidden id='dingdan4_3_tanchuang_3' onclick="$('#dingdan4_3_tanchuang_3').hide()">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">您还没有设置支付密码,点击<a href ="<?php echo site_url('member/save_set/paypwd_set')?>" style="color:#fea33b">这里</a>去设置支付密码</div>
        </div>
	</div>
    <!--弹窗 结束-->
</body>
</html>
<script>
// $("#collect_shops").click(function(){
// 	    $(".kehuguanli_con_top_1").css("display","block");
// 	    $(".kehuguanli_con_top").css('display','none'); 
// 	    $("#collect_shop").parent().removeClass();
// 		$(".huankuan_rTop").hide()
// 		$(".huankuan_rTop_1").hide()
// 	    $(".huankuan_rTop_2").show()
// 		$(".huankuan_rTop_3").hide()
// 		$(".kehuguanli_con04").show()
// 	    $("#collect_shops").parent().addClass("huankuan_rCon01_current");
// 		});
// 	$("#collect_shop").click(function(){
// 	    $(".kehuguanli_con_top_1").css("display","none");
// 	    $(".kehuguanli_con_top").css('display','block');
// 	    $("#collect_shops").parent().removeClass();
// 		$(".huankuan_rTop").show()
// 	    $(".huankuan_rTop_2").hide()
// 		$(".huankuan_rTop_1").hide()
// 	    $("#collect_shop").parent().addClass("huankuan_rCon01_current"); 
// 		});
	
// 	$("#detailed_2").click(function(){
// 	    $(".kehuguanli_con03").css("display","block");
// 	    $(".kehuguanli_con02").css('display','none'); 
// 	    $("#detailed_1").parent().removeClass();
// 		$(".huankuan_rTop").hide()
// 	    $(".huankuan_rTop_1").show()
// 	    $("#detailed_2").parent().addClass("huankuan_rCon01_curren1");
// 		});	
// 	$("#detailed_1").click(function(){
// 	    $(".kehuguanli_con03").css("display","none");
// 		 $(".kehuguanli_con02").css('display','block'); 
// 		$(".huankuan_rTop").show()
// 	    $(".huankuan_rTop_1").hide()
// 	    $("#detailed_2").parent().removeClass();
// 	    $("#detailed_1").parent().addClass("huankuan_rCon01_curren1");
// 		});	
		
	$("#sure").click(function(){
			$(".huankuan_cmRight").hide()
			$(".huankuan_cmRight_1").show()
			$('.dingdan4_3_tanchuang').hide();
			$('.huankuan_rTop_4').show();
		});	
		
	$("#cash").click(function(){
			$('.dd').hide();
		
		});	
// 	$("#cash1").click(function(){
// 		    $(".huankuan_cmRight").hide()
// 			$(".huankuan_cmRight_1").hide()
// 		   $(".huankuan_cmRight_2").show()
// 			$('.dingdan4_3_tanchuang').hide();
// 			$('.huankuan_rTop_4').show();
// 		});	
		<!--转货豆金额：-->
		
	$("#determine_1").click(function(){
		$('input[name=pay_password]').val('');
		var cash = '<?php echo isset($customer['cash']) ? $customer['cash'] :'0.00'?>';
		var m_credit = $('input[name=charge_m]').val();

		var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
		if(m_credit == "" || !m_credit.match(str))
		{
			alert('请输入正确的充值金额');
		}else if(m_credit < 0.01){
			alert('购买数量必须大于0');
		}else if( m_credit > 50000){ 
			alert('购买数量不能大于50000');
		}else if("<?php echo count($customer)?>" == 0){
			alert('未开通支付账号');
		}else if( '<?php echo $customer['pay_passwd']?>' ==  '' ){ 
			$('#dingdan4_3_tanchuang_3').show();
	    }else if( m_credit > parseFloat(cash) ){ 
	        alert('现金余额不足');
	    }else{ 
			$('#pass_message').hide();
			$('.dingdan4_5_tanchuang').show();
		}
// 		
		});

	function ajax_submit(){ 
		var m_credit = $('input[name=charge_m]').val();
		var pass = $('input[name=pay_password]').val();
		
		$.post("<?php echo site_url('charge/purchase_M')?>",{m_credit:m_credit,pass:pass},function(data){
			if(data){ 
	            switch(data){ 
	            case 1:
	                $('input[name=charge_m]').val('');
	                $('.huankuan_rTop_4').hide();
	        		$('.huankuan_rTop_6').show();
	        		$('.transformation').hide();
	        		$('.dingdan4_5_tanchuang').hide();
	        		$('.transformation_1').show();
	                break;
	            case 2:
	           	    alert('现金余额不足');
	                break;
	            case 3:
	            	alert('未开通支付账号');
	            	break;
	            case 4:
	            	$('#pass_message').show();
	            	break;
	            }
	        }else{ 
	      	  alert('充值失败请稍后再试','确定',"$('.purchaase_failure').hide()");
	        }    
		},"json");
	}
	
	$(".dingdan4_3_btn03").on("click",function(){
		$('.dingdan4_5_tanchuang').hide();
		$('.huankuan_rTop_4').show();
		$('.huankuan_rTop_6').hide();
		$('.transformation').show();
		})
		
// 	$("#sure_1").click(function(){
// 		$('.huankuan_rTop_4').hide();
// 		$('.huankuan_rTop_6').show();
// 		$('.transformation').hide();
// 		$('.dingdan4_5_tanchuang').hide();
// 		$('.transformation_1').show();
// 		});	


   

			
	
		
</script>
<script>
	 function show(){ 
	$('#dingdan4_3_tanchuang').show();
     }
	$(".dingdan4_3_btn01").on("click",function(){
		$('.dingdan4_3_tanchuang').hide();
		$(".dd").show()
		$('.huankuan_rTop_3').hide();
		})
</script>