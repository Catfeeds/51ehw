<script type="text/javascript" src="js/common.js" ></script>
<script type="text/javascript" src="js/orderinfo.js" ></script>
<script language="JavaScript"> 
<!--
var base_url = '<?php echo site_url();?>';
$(document).ready(function() {
	$(':radio[name="address_id"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="new")
		{
			if($('#consignee_from').length < 1)
			{
				showForm_consignee(this);
			}
		}else{
			if($('#consignee_from').length > 0)
			{
				$('#consignee_from').remove();
				isNewCon = false;
			}
			
		}
	});
	$(':radio[name="is_invoice"]').change(function(obj){
		if($(':radio[name="address_id"]:checked').val()=="1")
		{
			$('#invoice_from').toggle('show');
		}else{
			$('#invoice_from').toggle('hidden');
		}
	});
});

function clickAddress(obj)
{
	document.order_save.address_id.value = $(obj).val();

}

function new_address(){
	
	$('#consignee_addressName').val("");
	$('#consignee_postcode').val("");
	$('#consignee_address').val("");
	$('#consignee_message').val("");
	$('#consignee_phone').val("");

	$('#addaddress').show();

}

function save_consignee()
{
	if(check_con())
	{
		var province = $('#province_id').find("option:selected").text()+'省';
		var city = $('#city_id').find("option:selected").text()+'市';
	    var district = $('#district_id').find("option:selected").text();
	    
		
		var form = $('#addressform').serialize();
		
		$.post("<?php echo site_url('member/address/ajax_save')?>",form,function(result){
			
			var data = JSON.parse(result);
			    
			if(data["errorcode"]==0)
			{
				var str = '<div class="dingdan2_con02">'+
                			'<ul>'+
                    			'<li>'+
									'<div class="gouwuche_selectAll dingdan2_selectAll">'+
										'<div class="gouwuche_checkbox">'+
											'<input type="radio" name="address_id" value="'+data["id"]+'"  onclick="clickAddress(this)">'+
										'</div>'+
									'</div>'+
								'</li>'+
							
								'<li><span>所在地:'+province+city+district+'</span><br/><span>街道地址:'+data["address"]+'</span></li>'+
								'<li><span class="gouwuche_m02">'+data["postcode"]+'</span></li>'+
								'<li><span class="gouwuche_m02">'+data["consignee"]+'</span></li>'+
								'<li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;">'+data["phone"]+'</span></li>'+
								'<li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;">'+data["mobile"]+'</span></li>'+
							'</ul>'+
						'</div>';
				$('#addresslist').append(str);

				alert("新建收货地址成功！");
				$('#addaddress').hide();
			}
			else
			{
				alert("新建收货地址失败！");
			}
		});

	}
}

//-->
</script>
    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">结算中心</div>
        <div class="gouwuche_box_top2">
        	<ul>
            	<li><a href="<?php echo site_url("cart");?>">1. 我的购物车</a></li>
                <li><span>></span></li>
                <li class="dingdan2_current"><a href="javascript:;">2. 核对订单信息</a></li>
                <li><span>></span></li>
                <li><a>3.成功提交订单</a></li>      
            </ul>
        </div>
		
        <div class="dingdan2_con">
            <div class="dingdan2_con01"><a href="javascript:new_address();">新建收货地址</a></div>
			<!--新增收货地址内容开始-->
			<form name="addressform" method="post" id="addressform">
            <div class="xinzeng_01" id="addaddress" style="display:none">
            	<p class="xinzeng_p">新增收货地址</p>
                <div class="gerenzhongxin_01_con clearfix xinzeng_con">
            	<div class="gerenzhongxin_01_con_left xinzeng_con_left">
                	<ul>    	
                        <li><span>*</span>收货人姓名：</li>
                        <li><span>*</span>所在地：</li>
                        <li><span>*</span>邮编：</li>
                        <li><span>*</span>收货地址：</li>
                        <li><span>*</span>手机号码：</li>
                        <li>固定电话：</li>
                    </ul>
                </div>
                
                <div class="gerenzhongxin_01_con_right">
                	<ul>
                    	<li>
							<input type="text" class="gerenzhongxin_01_con_input" id="consignee_addressName" name="consignee"  onblur="check_addressName()">
                        </li>
                        <li> 
							<?php 
							$data['province_selected'] ='';
							$data['city_selected'] = '';
							$data['district_selected'] = '';
							?>
							<?php $this->load->view('widget/district_select',$data); ?>
						</li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_postcode" onblur="check_postcode()" name="postcode"  value=""></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_address" name="address" onblur="check_address()" value=""></li>
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_message" onblur="check_message()" name="mobile" 　value=""></li> 
                        <li><input type="text" class="gerenzhongxin_01_con_input" id="consignee_phone"  onblur="check_phone()" name="phone"　value=""></li>
                    </ul>
                    <div class="gerenzhongxin_01_xiugai_btn"><a onclick="save_consignee(this);">保存</a></div>
                </div>
            </div>
            </div>
			</form>
            <!--新增收货地址内容结束-->
            <p>收货人信息</p>
			<div id="addresslist" class="clearfix">
			<div class="dingdan2_con02 clearfix">
				<?php
				$default_address = 0;
				foreach ($address as $k=>$v){;?>
				
                	<ul class="clearfix">
                    	<li>
                            <div class="gouwuche_selectAll dingdan2_selectAll">
                                <div class="gouwuche_checkbox">
                                    <input type="radio" name="address_id" value="<?php echo $v['id'];?>" <?php if($v['is_default']){ echo "checked"; $default_address = $v['id'];}?> onclick="clickAddress(this)">
                                </div>
                            </div>
                        </li>
                        <li>
                            <span><?php echo '所在地:'.$v['address_for_name'];?></span><br/>
                            <span><?php echo '街道地址: '.$v['address'];?></span>
                        </li>
                        <li><span class="gouwuche_m02"><?php echo $v['postcode'];?></span></li>
                        <li><span class="gouwuche_m02"><?php echo $v['consignee'];?></span></li>
                        <li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;"><?php echo $v['phone'];?></span></li>
                        <li style="width:auto;"><span class="gouwuche_m02" style="width:130px; text-align:center;"><?php echo $v['mobile'];?></span></li>
                    </ul>
				
				<?php };?>
				</div>
			</div>
				
            <!--<p class="dingdan2_p">支付方式</p>
            <div class="dingdan2_con02">
                	<ul>
                    	<li>
                            <div class="gouwuche_selectAll dingdan2_selectAll">
                                <div class="gouwuche_checkbox">
                                    <input type="checkbox" value="true">
                                </div>
                            </div>
                        </li>
                        <li><span>现金支付</span></li>
                    </ul>
            </div>-->
			<form action="<?php echo site_url('order/save')?>" id="order_save" method="post" name="order_save">
			<input type="hidden" name="address_id" value="<?php echo $default_address?>"/>
            <div class="dingdan2_con03">
            	<div class="dingdan2_con03_top" style="border-bottom: none;">
                	<ul>
                        <li class="dingdan2_con03_li">商品信息</li>
                        <li>单价（货豆）</li>
                        <li>数量</li>
                        <li>小计（货豆）</li>
                    </ul>
                </div>
            
            <!--选择店铺全选店铺开始 结束-->
            <!--cart_border 开始-->
            <div class="cart_border">
            <?php foreach($itemarray as $items){; ?>
            <!--店铺01 开始-->
            <!--选择店铺全选店铺开始 开始-->
            <div class="cart_store">
                <ul>
                    <li>
                        <span>店铺：<a><?php echo $items["corporation_name"];?></a></span>
                    </li>
                </ul>
            </div>
            <input type="hidden" name="item[]" value="<?php echo $items["rowid"];?>"/>
            <div class="dingdan2_con03_con">
                <ul>
                    <li class="dingdan2_con03_con_li">
                        <span class="gouwuche_mm01">
                           <span class="gouwuche_mm01_img"><a href="<?php echo site_url('goods/detail/'.$items['product_id']);?>"><img src="<?php echo IMAGE_URL.$items['goods_thumb'];?>" alt=""></a></span>
                           <span class="gouwuche_mm01_font">
                              <a href="<?php echo site_url('goods/detail/'.$items['product_id']);?>" target="_blank">
                                    <?php echo $items['product_name']; ?>
                              </a>
                              <p class="mm01_font1">
                                <?php if(isset($items['sku_value'])){; ?>
                                      <span><?php echo $items['sku_value']; ?></span>
                                <?php };?>
                              </p>
                           </span>
                       </span>
                    </li>
                    <li class="dingdan2_con03_juzhong" id="price"><?php echo $items['price'][0] =='.' ? '0'.$items['price'] :$items['price']?></li>
                    <li class="dingdan2_con03_juzhong"><?php echo $items['qty']; ?></li>
                    <li class="dingdan2_con03_juzhong"><?php echo $items['subtotal']; ?></li>
            </ul>
            </div>
            <?php };?>
        </div>
        <!--cart_border 结束-->
        <!--店铺01 结束-->

        <!--备注结算 开始-->
        <div class="gouwuche_box_con_down dingdan2_down">    
            <!--添加备注 开始-->
            <p class="cart_textaP">交易备注：（为避免订单纠纷，备注填写前，请先和供货商商议）</p>
            <textarea class="cart_texta" name="customer_remark"></textarea>
            <!--添加备注 结束-->
    
            <span class="gouwuche_d03">
                <p>总商品金额：<?php echo number_format($total_product_price, 2, '.', '');?> 货豆</p>
                <!--<p><span>- 货豆：</span>    0</p>-->
                <p>配送运费：<?php echo $freight;?> 货豆</p>
                <p class="gouwuche_dd03 gouwuche_dd05">应付总额（含运费）：<strong><?php echo number_format($total_product_price+$freight, 2, '.', '');?></strong> 货豆</p>
                <p class="gouwuche_dd03 gouwuche_dd05">应付手续费（现金）：<strong><?php echo number_format($commission, 2, '.', '');?></strong>  元&nbsp;&nbsp;&nbsp;</p>
                
                <div class="gouwuche_dd03"><a href="javascript:void(0)" onclick="$('#shouxu_message').show()" >点击查看手续费说明</a></div>
                <div class="gouwuche_dd04"><a href="javascript:submitOrder();" id="order_submit_status">去结算</a></div>
            </span>
        </div>
        <!--备注结算 结束-->
        
        </div>
		</form>
		</div>
		</div>
        
		  <div class="gouwuche_box_con">   
          </div>
            
        </div>
        
    </div>
    
    <!--新增支付流程－输入支付密码－弹窗 开始--><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" hidden>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">支付确认</div>
          <div class="dingdan4_3_tanchuang_top2">
              <ul class="payNum_ul">
              	<li><span class="pay_left">订单号：</span><span>2016030100101</span></li>
                <li><span class="pay_left">订单数量：</span><span>200</span></li>
                <li><span class="pay_left">订单金额：</span><span>M 10,000.00</span></li>
                <li><span class="pay_left">支付密码：</span><span><input type="text" placeholder="请输入支付密码" class="payNum_input"></span><a class="payNum_forget">忘记密码？</a></li>
                <li hidden><span class="payNum_tips">*密码错误，请重新输入</span></li>
              </ul>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc; "><a href="">取消支付</a></div>
              <div class="dingdan4_3_btn02"><a href="">确认支付</a></div>
          </div>
          
      </div>
	</div>
    <!--新增支付流程－输入支付密码－弹窗 结束-->
    
    <!--有待商家确认－弹窗 开始--><!--默认隐藏-->
	<div class="dingdan4_3_tanchuang" id="shouxu_message" hidden>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">关于手续费的说明</div>
          <div class="dingdan4_3_tanchuang_top2">
              <p style="text-align:left; margin-left:28px;">51易货网本着真诚的为各位参与易货的企业服务的态度，为了更好的为企业会员们提供易货服务，<br/>
              维持平台正常运营，现将易货手续费修正为采购方承担，具体易货手续费按会员类型确定。</p>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn02" style="margin-left: 265px;"><a href="javascript:void(0)" onclick="$('#shouxu_message').hide()">关闭</a></div>
          </div>
          
      </div>
	</div>
    <!--有待商家确认－弹窗 结束-->
    
    <!--通用操作 弹窗start-->
    <div class="dingdan4_3_tanchuang" style="display:none" id="teshi">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">温馨提示</div>
          <div class="dingdan4_3_tanchuang_top2">
              <p id='prompt'></p>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
              <div class="dingdan4_3_btn02"><a href="javascript:sure();" >确定</a></div>  
                 
          </div>
      </div>
    </div>
    <!--通用操作 弹窗end-->
    
    <script>
    //特价恢复原价确定继续购买
    function sure(){
    	submitOrder();
    }

    //隐藏弹窗
    function hiding(){
    	$("#prompt").text("");
    	$("#teshi").hide();
        }
    </script>



  
