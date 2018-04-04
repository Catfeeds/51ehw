<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>
<script type="text/javascript" src="js/jedate/jedate.js"></script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
        <li class="tCurrent"><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
        <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<!--内容开始-->
    <div class="Box manage_new_Box clearfix">
    	<div class="cmLeft manage_new_cmLeft">
          <div class="downTittle manage_new_downTittle menu_manage_downTittle">活动管理</div>
            <div class="cmLeft_down">
            	<ul>
				<li class="houtai_zijin_current"><a href="<?php echo site_url("corporate/activity/get_list");?>">拼团活动</a></li>
                <li ><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
			</ul>
            </div>
        </div>
        <!---->
          <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
        
            <div class="cmRight_tittle"><?php if( isset($status) ){ echo '活动详情'; }else if(isset($activity_id) ){echo '编辑活动';}else{echo '发布活动';}?></div>
            <div class="kehu_kehuguanli1_con01 clearfix">
            	<div class="kehu_kehuguanli1_con01_left">
                	<ul>
                        <li>商品 ID 名称 :</li>
                        <li>活动 :</li>
                        <li>拼团人数 :</li>
                        <li>拼团价 :</li>
                        <li>限购数量 :</li>
                        <li>活动起止时间 :</li>
                        <li>活动说明:</li>
                    </ul>
                </div>
                <form action="<?php echo isset($product_list) ? site_url('corporate/activity/add_activity_product') : site_url('corporate/activity/update_activity_product')?>" method="post">
                <div class="kehu_kehuguanli1_con01_right">
                	<ul>
                    	<li>
                        	 <select class="need-text5" id="unit" name="activity_product">
<!--                             <option value="">请选择</option> -->
                            <?php if(count($product_list) > 0 ):?>
                                <?php foreach ($product_list as $v):?>
                                    <option value="<?php echo $v['id']?>"><?php echo $v['id'].'&nbsp;&nbsp;'.$v['name']?></option>
                                <?php endforeach;?>
                            <?php elseif(count($activity) > 0):?>
                                 <option value="<?php echo $activity['product_id']?>"><?php echo $activity['id'].'&nbsp;&nbsp;'.$activity['name']?></option>
                            <?php endif;?>
                          </select>
                        </li>
                        
                        <li>
                            <select class="need-text5" id="unit" name="activity_name">
                                <option value="1">拼团</option>
                            </select>
                        </li>
                        <li class="dingwe"><input class="kehu_kehuguanli1_input" type="text" placeholder="请输入大于1的数字" name="menber_num" id="search_input" value="<?php echo isset($activity['menber_num']) ? $activity['menber_num'] : ''?>"> <span class="shop_managetips1" id="menber_num_message"></span></li>
                        <li class="dingwe">
                        	<input class="kehu_kehuguanli1_input" type="text" placeholder="" name="groupbuy_price" id="" value="<?php echo isset($activity['groupbuy_price']) ? $activity['groupbuy_price'] : ''?>"><span class="shop_managetips2">货豆 </span> <span style="right:-191px"class="shop_managetips1" id="groupbuy_price_message"></span></li>
                         <li class="dingwe" style="line-height:37px;">
                         <em style="margin-right:24px;"><span style="float:left; margin-left:5px;"> <input type="radio" value="0" name="set_limit" class="" <?php echo !isset($activity['set_limit']) || $activity['set_limit'] == 0?  'checked' : ''?>> 不限购</span><span style="float:left; margin:0 10px;">|</span><span style="float:left;"> <input type="radio" value="1" name="set_limit" class="" <?php echo isset($activity['set_limit']) && $activity['set_limit'] == 1 ? 'checked' :''?>> 限购</span></em>
                         <em><span><input style="width:155px;"class="kehu_kehuguanli1_input" name="least_purchase" type="text" value="<?php echo isset($activity['least_purchase']) ? $activity['least_purchase'] : ''?>" placeholder="请输入最少购买数量"></span><span style="margin:0 10px; float:left">~</span><span><input  style="width:155px;"class="kehu_kehuguanli1_input" name="most_purchase" type="text" value="<?php echo isset($activity['most_purchase']) ? $activity['most_purchase'] : ''?>" placeholder="请输入最多购买数量"></span></em>
                            <span style="position: absolute;top: 3px; width:175px;" class="shop_managetips1" id="xiangou_error"></span></li>
                        <li class="dingwe">
                        	<input class="zijin1_1_con01_input01" name="groupbuy_start_at" id="start_at" type="text" value="<?php echo isset($activity['start_time']) ? $activity['start_time'] : ''?>" placeholder="请选择"  readonly>
                            <span style="float:left; margin:0 10px; line-height:39px;">至</span>
                            <!--<label><input type="text" value="" class="zijin1_1_con01_input01" name="end_time" onClick="WdatePicker()" readonly></label>-->
                            <input class="zijin1_1_con01_input01 " name="groupbuy_end_at" id="end_at" type="text" value="<?php echo isset($activity['end_time']) ? $activity['end_time'] : ''?>" placeholder="请选择"  readonly>
                            
                        </li><span style="position:unset"class="shop_managetips1" id="time_message"></span>
                        <textarea style="float:left" rows="8" cols="50" name="remarks"><?php echo isset($activity['remarks']) ? $activity['remarks'] : ''?></textarea>
                      
                        </ul>
                    <input name="status" value ='0' hidden>
                    <?php if(isset($activity['id'])):?>
                        <input name="activity_id" value =<?php echo $activity['id']?> hidden>
                    <?php endif;?>
                    
                    <?php if(!isset($status)):?>
                   <div class="buy_bt">
                    <div class="buy_btn2"><a href="javascript:sub(1)" id="select_input">保存</a></div>
                    <div class="buy_btn2"><a href="javascript:sub(2)" id="reset">保存并提交审核</a></div>
                   </div>
                    <?php else:?>
                     <div class="buy_bt">
                    <div class="buy_btn2"><a href="<?php echo site_url('corporate/activity/get_list');?>" id="select_input">返回活动列表</a></div>
                  
                   </div>
                    <?php endif;?>
                </div>
                </form>
            </div> 
            
           
       
            </div>
         </div>
         
 <!--拼团样式-->        
<style>
.kehu_kehuguanli1_con01{ width:700px;}
.need-text5 {
		width: 266px;
		float:left;
		border: 1px solid #C8C8C8;
		outline: none;-webkit-appearance: none;
		border-radius: 0;
		background: #fff;
		color: #CACACA;
		background: url("images/needs_right_icon.png") no-repeat scroll right center transparent;
		text-indent:0.5em;
  }
  .kehu_kehuguanli1_input{float:left; text-indent:0px;}
   .dingwe{ position:relative; float:left}
   .dingwe em{ float:left; margin-right:10px;}
   .shop_managetips1{font-size: 14px; color: red; top:12px;}
   .shop_managetips2{ float:left; position:absolute;right:245px;font-size: 14px; color: #3e3e3e; top:12px;}
   .buy_bt{ width:400px; margin-left:7px;}
   .buy_btn2 {
	width:172px;
    height: 42px;
    line-height: 42px;
    text-align: center;
    border-radius: 2px;
    background: #72c312;
    margin-top: 26px;
	float:left; margin-right:28px;
}
 .buy_btn2 a{ color:#fff; display:block}
 .zijin1_1_con01_input01{ float:left; width:190px;}
 .xiang{ position:absolute; margin-left:-0px;}
 .kehu_kehuguanli1_con01 .kehu_kehuguanli1_con01_right{ width:550px; float:left}
 .kehu_kehuguanli1_con01_right li{width:550px;}
   </style>      
 <script src="jquery-1.11.3.js"></script> 
 <script type="text/javascript">
    jeDate({
		dateCell:"#start_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
	
	jeDate({
		dateCell:"#end_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
	
	function sub(status){ 
    	ok = true;
    	
    	$('.shop_managetips1').text('');
    	$('#time_message').text('');
    	var menber_num = $('input[name=menber_num]').val()
    	var groupbuy_price = $('input[name=groupbuy_price]').val();
    	var start_at = $('input[name=groupbuy_start_at]').val();
        var end_at = $('input[name=groupbuy_end_at]').val();
        var set_limit = $('input[name=set_limit]:checked').val();
        
        if(set_limit == 1){ 
        	
        	var least_purchase = $('input[name=least_purchase]').val();
        	var most_purchase = $('input[name=most_purchase]').val();
            var jixu = false;
        	if( (least_purchase == '' || least_purchase< 1 || !/^(-|\+)?\d+$/.test(least_purchase) ) && jixu==false ){ 
            	$('#xiangou_error').text('请正确输入最少购买数量');
            	ok = false;
            	jixu = true;
            }

        	if( (most_purchase == '' || most_purchase< 1 || !/^(-|\+)?\d+$/.test(most_purchase) ) && jixu==false){ 
            	$('#xiangou_error').text('请正确输入最多购买数量');
            	ok = false;
            	jixu = true;
            }
            
            if( least_purchase > most_purchase && jixu== false){ 
            	$('#xiangou_error').text('最少购买不能大于最大购买');
            	ok = false;
            	jixu = true;
            }
        }
        
    	if( menber_num== '' || menber_num <= 1 || !/^(-|\+)?\d+$/.test(menber_num)){
        	$('#menber_num_message').text('＊请输入大于1的数字');
        	ok = false;
        }

    	var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
    	if( groupbuy_price== '' || !groupbuy_price.match(str) || groupbuy_price < 0.01){
        	$('#groupbuy_price_message').text('*请输入正确的货豆数值');
        	ok = false;
        }
        
        if(end_at <= start_at){ 
            
        	$('#time_message').text('开始时间必须小于结束时间');
        	ok = false;
        }
        
        if(ok){
        	$('input[name=status]').val(status);
    	    $('form').submit();
        }
    }
</script>
