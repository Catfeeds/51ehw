<?php
header("Content-type: text/html; charset=utf-8");
$CI = get_instance();
$CI->load->model('region_mdl', 'region');
$provinces   = $CI->region->provinces();
$province_selected = isset($province_selected)?$province_selected:"";
$citys = $CI->region->children_of(isset($province_selected)?$province_selected:"");
?>
<script  language="JavaScript">
<!--
<?php if(isset($dt['province_id'])){$province_selected = $dt['province_id'];}?>
<?php if(isset($province_selected)):?>
var province_selected = <?php echo (int)$province_selected?>;
<?php else:?>
var province_selected = 0;
<?php endif?>

<?php if(isset($city_selected)):?>
var city_selected = <?php echo (int)$city_selected?>;
<?php else:?>
var city_selected = 0;
<?php endif?>

<?php if(isset($district_selected)):?>
var district_selected = <?php echo (int)$district_selected?>;
<?php else:?>
var district_selected = 0;
<?php endif?>

$(document).ready(function() {

  var change_city2 = function(){
	  
	$.ajax({
	  url: '<?php echo site_url('order_att/select_children')?>',
	  data: {id:$('#province_id2').val()},
	  type: 'GET',
	  dataType: 'html',
	  success: function(data){
		city_json = eval('('+data+')');
		var city = document.getElementById('city_id2');
		city.options.length = 0;
		city.options[0] = new Option('城市', '');
		for(var i=0; i<city_json.length; i++){
            var len = city.length;
			city.options[len] = new Option(city_json[i].region_name, city_json[i].region_id);
			if (city.options[len].value == city_selected){
				city.options[len].selected = true;
			}
		}

	  }
	});
  }

  change_city2();//初始化城市

  $('#province_id2').change(function(){
     change_city2();
  });




});
</script>

<form name="form1" method="post"
	action="<?php echo site_url('customer/save_2')?>"  id="register-form">
	<!--内容 开始-->
	<div class="regsiter_02_con">
		<div class="regsiter_02_con_top regsiter_03_con_top">
			注册成功
			<div class="regsiter_03_con_topBtn">
				<a href="<?php echo site_url('home');?>">先随便逛逛</a>
			</div>
		</div>


		<div class="regsiter_02_con_con clearfix">

			<h4 class="regsiter_03_h4">企业用户请完善下列信息</h4>
			<div class="regsiter_03_con01">
				<h4 class="regsiter_03_h4_2">为什么要成为51易货企业用户？加入它有什么“特权”？</h4>
				<p>
					<span class="regsiter_03_span">No1</span>加入51易货网，用自有商品/服务来“采购”企业经营过程中所需的商品/服务。降低现金采购量，减轻企业资金压力。
				</p>
				<p>
					<span class="regsiter_03_span">No2</span>加入51易货网，轻松解决企业间的三角债。不再受三角债困扰，增加企业竞争力。
				</p>
				<p>
					<span class="regsiter_03_span">No3</span>加入51易货网，库存不再是压力。通过易货贸易盘活企业过剩产能和库存商品，让企业甩掉包袱，轻松上阵。
				</p>
				<p>
					<span class="regsiter_03_span">No4</span>51易货网企业会员能够在易货消费生态圈内，使用自有的商品/服务解决衣、食、住、行、生产、经营。真正实现：生产资料不花钱，员工福利不花钱，接待应酬不花钱，旅行住宿不花钱，换房换车不花钱，广告推广不花钱，法律服务不花钱
				</p>
				<p>51易货网，热忱欢迎您的加入！</p>
			</div>
			<h4 class="regsiter_03_h4_3">企业用户请完善下列信息</h4>
			<!--注册输入框 开始-->

			<div class="clearfix">
				<div class="regsiter_02_left  regsiter_02_bottom">
					<ul>
						<li><span class="regsiter_02_span">*</span>企业名称：</li>
						<li><span class="regsiter_02_span">*</span>企业所在地：</li>
						<li><span class="regsiter_02_span">*</span>企业地址：</li>
						<li></li>
						<li><span class="regsiter_02_span">*</span>企业邮编：</li>
						<li><span class="regsiter_02_span">*</span>企业邮箱：</li>
						<li><span class="regsiter_02_span">*</span>店铺管理员：</li>
						<li><span class="regsiter_02_span">*</span>店铺联系方式：</li>
					</ul>
				</div>
				<div class="regsiter_02_right dropdown">
					<ul>
						<li><input type="text" class="regsiter_02_input" value="<?php echo isset($dt['corporation_name'])?$dt['corporation_name']:'' ?>"
							placeholder="营业执照上的企业全称" name="cor_name" id="corname" required>
							<div class="rtips" id="error" style="width:200px;display:none;float:right;margin-top: -3px;margin-right: 158px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>
						</li>
						
						<li id="corarea" class="clearfix">
								<select class="regsiter_03_select01 dropdown_select01 dropdown_select01_basic" id="province_id2" required>
                                    <option value="" >省份</option>
	                                <?php foreach($provinces as $key => $province): ?>
	                                <option value="<?php echo $province['region_id']; ?>" <?php if($province['region_id']==$province_selected){echo 'selected';}?> ><?php echo $province['region_name']; ?></option>
	                                <?php endforeach; ?>
                                </select>
                                <select class="regsiter_03_select02 dropdown_select01 dropdown_select01_basic" id="city_id2" style="margin-right: 0;">
                                    
                                </select>
							<div class="rtips"  id="error1" style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>	
						</li>
						
					
						<li  id="adr" class="clearfix">
						        <?php 
						        if(isset($dt['province_id']))
                                $data['province_selected'] = $dt['province_id'];
						        if(isset($dt['city_id']))
                                $data['city_selected'] = $dt['city_id'];
						        if(isset($dt['district_id']))
                                $data['district_selected'] = $dt['district_id'];
                                ?>
                                  <?php if(isset($data)){$this->load->view('widget/district_select',$data);}else{$this->load->view('widget/district_select');} ?>
						
						</li>
						
						<li>
						<input style="margin-top:0;" name="address" type="text" class="regsiter_02_input00" value="<?php if(isset($dt['address']) && $dt['address']!=''){echo $dt['address'];}else{echo '';} ?>"
							placeholder="具体街道位置" id="specific_address" <?php if(isset($dt['address']) && $dt['address']!=''){echo '';}else{echo 'required';} ?>>
						<div class="rtips"  id="error2"  style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>	
						</li>
						
						<li><input type="text" class="regsiter_02_input" id="postcode" value="<?php echo isset($dt['postcode'])?$dt['postcode']:'' ?>" name="postcode" required>
						<div class="rtips"  id="error3" style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>
						</li>
						<li><input type="email" id="email" class="regsiter_02_input" value="<?php echo isset($dt['email'])?$dt['email']:'' ?>" name="email"  required>
						<div class="rtips"  id="error4" style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>
						</li>
						<li><input type="text" class="regsiter_02_input" value="<?php echo isset($dt['contact_name'])?$dt['contact_name']:'' ?>"
							placeholder="请填写企业账号负责人姓名" id="rename" name="contact_name" required>
							<div class="rtips"  id="error5" style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>
						</li>
						<li><input type="text" class="regsiter_02_input" value="<?php echo isset($dt['contact_mobile'])?$dt['contact_mobile']:'' ?>"
							placeholder="请填写企业账号负责人手机号码" id="phone" name="contact_mobile" required>
							<div class="rtips"  id="error6" style="width:200px;display:none;float:right;margin-right: 158px; margin-top: -3px;color:#ffa043; font-size:14px; height:39px; line-height:39px;"></div>
						</li>
					</ul>
				</div>
			</div>
			<div align="center">
				<input type="button" onclick="sub();" id="binding" value="确认绑定" class="regsiter_02_btn" style="width:274px; margin-left:110px;" />
			</div>
			<!--注册输入框 结束-->
		</div>
	</div>
	<!--内容 结束-->
</form>

<script>
$(document).ready(function() {
    $('#province_id').blur(function(){
        
        $('#province_id').attr('required',true);
        $('#city_id').attr('required',true);
        $('#district_id').attr('required',true);
        
        if($('#province_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
            $("#error2").show(); 
        } 
        else if($('#city_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error2").show(); 
        }
        else if( $('#district_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>区域不能为空</i>');
            $("#error2").show(); 
        }
        else if($('#specific_address').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>街道不能为空</i>');
            $("#error2").show();
        }
        else{
            $("#error2").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error2").show();
        } 
    });
    $('#specific_address').blur(function(){
        
        if($('#province_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
            $("#error2").show(); 
         } 
        else if($('#city_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error2").show(); 
        }
        else if( $('#district_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>区域不能为空</i>');
            $("#error2").show(); 
        }
        else if($('#specific_address').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>街道不能为空</i>');
            $("#error2").show();
        }
         else{
            $("#error2").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error2").show();
        }  
    });
    
    $('#city_id').blur(function(){
        
        $('#province_id').attr('required',true);
        $('#city_id').attr('required',true);
        $('#district_id').attr('required',true);
        
        if($('#province_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
            $("#error2").show(); 
        } 
        else if($('#city_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error2").show(); 
        }
        else if( $('#district_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>区域不能为空</i>');
            $("#error2").show(); 
        }
        else if($('#specific_address').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>街道不能为空</i>');
            $("#error2").show();
        }
        else{
            $("#error2").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error2").show();
        }
	});
	
    $('#district_id').blur(function(){
    	
        $('#province_id').attr('required',true);
        $('#city_id').attr('required',true);
        $('#district_id').attr('required',true);
        
        if($('#province_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
            $("#error2").show(); 
        } 
        else if($('#city_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error2").show(); 
        }
        else if( $('#district_id').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>区域不能为空</i>');
            $("#error2").show(); 
        }
        else if($('#specific_address').val()==""){
            $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>街道不能为空</i>');
            $("#error2").show();
        }
        else{
            $("#error2").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error2").show();
    	}
    });

    $('#city_id2').blur(function(){
    	
        $('#province_id').attr('required',true);
        $('#city_id').attr('required',true);
        $('#district_id').attr('required',true);
        
        if($('#city_id2').val()==""){
            $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error1").show(); 
        }
        else if($('#province_id2').val()==""){
            $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
            $("#error1").show(); 
        }
        else{
            $("#error1").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error1").show();
        }
    });

    $('#province_id2').blur(function(){
        if($('#province_id2').val()==""){
                $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
                $("#error1").show(); 
        }
        else if($('#city_id2').val()==""){
            $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
            $("#error1").show(); 
        } 
        else{
            $("#error1").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error1").show();
        } 
    });
    $('#corname').blur(function(){
        if($('#corname').val()==""){
            $("#error").html('<span><img src="images/rw.png" width="18"></span><i>企业名称不能为空</i>');
            $("#error").show(); 
        }
        else if( /[^\u4E00-\u9FA5]/.test($('#corname').val()) ){
            $("#error").html('<span><img src="images/rw.png" width="18"></span><i>企业名称只能为中文</i>');
            $("#error").show();
        }
        else{
            $("#error").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error").show();
        } 
    });
    
    $('#postcode').blur(function(){
        if($('#postcode').val()==""){
            $("#error3").html('<span><img src="images/rw.png" width="18"></span><i>邮编不能为空</i>');
            $("#error3").show();
        }
        else if(! /^[0-9][0-9]{5}$/.test($('#postcode').val())){
            $("#error3").html('<span><img src="images/rw.png" width="18"></span><i>邮编格式不正确</i>');
            $("#error3").show();  
        }
        else{
            $("#error3").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error3").show();
        } 
    });

    $('#email').blur(function(){
        //针对不同浏览器，1、谷歌，2、safari
        var email1 = $('#email').val().replace('。','.');
        //var email2 =  email1;//.replace(/[^A-Za-z0-9/@/.]/ig,"，");
        $('#email').val('');
        $('#email').val(email1);
        if($('#email').val()==""){
            $("#error4").html('<span><img src="images/rw.png" width="18"></span><i>邮箱不能为空</i>');
            $("#error4").show();
        }
        //else if(!/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test($('#email').val())){
        else if(! /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))){2,6}$/i.test($('#email').val())){
            $("#error4").html('<span><img src="images/rw.png" width="18"></span><i>邮箱格式不正确</i>');
            $("#error4").show();
        }
        else{
            $("#error4").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error4").show();
        }
    });

    $('#rename').blur(function(){
        if($('#rename').val()==""){
            $("#error5").html('<span><img src="images/rw.png" width="18"></span><i>联系人不能为空</i>');
            $("#error5").show();
        }
        else if(!$("#rename").val().match(/^[\u4e00-\u9fa5]{2,4}$/i)){
            $("#error5").html('<span><img src="images/rw.png" width="18"></span><i>联系人格式不正确</i>');
            $("#error5").show();
        }
        else{
            $("#error5").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error5").show();
        }
    });

    $('#phone').blur(function(){
        if($('#phone').val()==""){
            $("#error6").html('<span><img src="images/rw.png" width="18"></span><i>手机不能为空</i>');
            $("#error6").show();
        }
        else if(! /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/.test($('#phone').val())){
            $("#error6").html('<span><img src="images/rw.png" width="18"></span><i>手机格式不正确</i>');
            $("#error6").show();
        }
        else{
            $("#error6").html('<span><img src="images/rr.png" width="18"></span><i></i>');
            $("#error6").show();
        } 
    });
});


function sub(){
    if($('#corname').val()==""){
        $("#error").html('<span><img src="images/rw.png" width="18"></span><i>企业名称不能为空</i>');
        $("#error").show(); 
    }
    else if( /[^\u4E00-\u9FA5]/.test($('#corname').val()) ){
        $("#error").html('<span><img src="images/rw.png" width="18"></span><i>企业名称只能为中文</i>');
        $("#error").show();
    }
    else{
        $("#error").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error").show();
    } 
    
    if($('#province_id2').val()==""){
        $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
        $("#error1").show(); 
    }
    else if($('#city_id2').val()==""){
        $("#error1").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
        $("#error1").show(); 
    }
    else{
        $("#error1").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error1").show();
    }
       
    if($('#province_id').val()==""){
        $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>省份不能为空</i>');
        $("#error2").show(); 
    }
    else if($('#city_id').val()==""){
        $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>城市不能为空</i>');
        $("#error2").show(); 
    }
    else if( $('#district_id').val()==""){
        $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>区域不能为空</i>');
        $("#error2").show(); 
    }
    else if($('#specific_address').val()==""){
        $("#error2").html('<span><img src="images/rw.png" width="18"></span><i>街道不能为空</i>');
        $("#error2").show();
    }
    else{
        $("#error2").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error2").show();
    }
      
    if($('#postcode').val()==""){
        $("#error3").html('<span><img src="images/rw.png" width="18"></span><i>邮编不能为空</i>');
        $("#error3").show();
    }
    else if(! /^[0-9][0-9]{5}$/.test($('#postcode').val())){
        $("#error3").html('<span><img src="images/rw.png" width="18"></span><i>邮编格式不正确</i>');
        $("#error3").show();  
    }
    else{
        $("#error3").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error3").show();
    }
     
    if($('#email').val()==""){
        $("#error4").html('<span><img src="images/rw.png" width="18"></span><i>邮箱不能为空</i>');
        $("#error4").show();
    }
    //else if(! /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test($('#email').val())){
    else if(! /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))){2,6}$/i.test($('#email').val())){
        $("#error4").html('<span><img src="images/rw.png" width="18"></span><i>邮箱格式不正确</i>');
        $("#error4").show();  
    }
    else{
        $("#error4").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error4").show();
    } 
    
    if($('#rename').val()==""){
        $("#error5").html('<span><img src="images/rw.png" width="18"></span><i>联系人不能为空</i>');
        $("#error5").show();
    }
    else if(!$("#rename").val().match(/^[\u4e00-\u9fa5]{2,4}$/i)){
        $("#error5").html('<span><img src="images/rw.png" width="18"></span><i>联系人格式不正确</i>');
        $("#error5").show();
    }
    else{
        $("#error5").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error5").show();
    } 
    
    if($('#phone').val()==""){
        $("#error6").html('<span><img src="images/rw.png" width="18"></span><i>手机不能为空</i>');
        $("#error6").show();
    }
    else if(! /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9])[0-9]{8}$/.test($('#phone').val())){
        $("#error6").html('<span><img src="images/rw.png" width="18"></span><i>手机格式不正确</i>');
        $("#error6").show();
    }
    else{
        $("#error6").html('<span><img src="images/rr.png" width="18"></span><i></i>');
        $("#error6").show();
    }
    
    var yes = ( !$('#corname').val()=="" && !/^\d.*$/.test( $('#corname').val() ) && !$('#city_id2').val()=="" && !$('#province_id2').val()=="" && !$('#province_id').val()=="" && !$('#city_id').val()=="" && !$('#district_id').val()=="" && !$('#specific_address').val()=="" && !$('#postcode').val()=="" && !(! /^[0-9][0-9]{5}$/.test($('#postcode').val())) && !$('#email').val()=="" && !(! /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test($('#email').val())) && !$('#rename').val()=="" && !(!$("#rename").val().match(/^[\u4e00-\u9fa5]{2,4}$/i)) && !$('#phone').val()=="" && !(! /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/.test($('#phone').val())));
    
    if( yes == true ){
        $('#binding').attr("onclick","");
    	$('#register-form').submit();
    }

}

</script>
