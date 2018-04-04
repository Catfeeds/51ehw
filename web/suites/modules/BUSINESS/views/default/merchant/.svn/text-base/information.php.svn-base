<style>
.error{ margin-left:0px; margin-right:10px;}
</style>
<!--填写公司信息-->
<?php 

//  判断用户是否登录
if (! $this->session->userdata('user_in')) {
    redirect('customer/login');
    exit();
}
?>
<script type="text/javascript" src="js/jquery.validate.merchant.js"></script>
<form id="form-step2" method="post">
     <div class="home_page">
        <div class="type_xuanz">
           <div class="type_xuanz_top">
                
                <ul class="step-case" id="step"> 
                     <li class="s-finish"><a href="javascript:;"><span>① 店铺类型/类目选择</span><b class="b-l"></b></a></li>
                     <li class="s-cur"><a href="javascript:;"><span>② 填写公司信息</span><b class="b-1"></b><b class="b-2"></b></a></li>
                     <li class="s-cur-next"><a href="javascript:;"><span>③ 上传资质</span><b class="b-1"></b><b class="b-2"></b></a></li>
                     <li><a href="javascript:;"><span>④ 等待审核</span><b class="b-1"></b><b class="b-2"></b></a></li>
                     <li><a href="javascript:;"><span>⑤ 网上缴费、店铺上线</span><b class="b-1"></b><b class="b-2"></b><b class="b-r"></b></a></li> 
                 </ul>
         </div>
         <div class="type_xuanz_zhong">店铺类型</div>
           <ul class="information_top">
              <li>
         
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">企业名称：</span></div>
                 <div class="information_right">
                  
                   <input class="information_right_input" type="text" name="corporation_name" value="<?php echo !empty( $corporation_info['corporation_name'] ) ? $corporation_info['corporation_name'] : ''; ?>" >
                 
                   <!-- <span>此选项为必填项</span> -->
                   <p>填写的公司名称必须与企业法人营业执照的公司名称一致</p>
                 </div>
              </li>
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">证照类型：</span></div>
                 <div class="information_right">
                    <dl class="information_right_dl">
                    	<?php if( isset( $corporation_info['license_type'] ) ){ ?>
                    	
                        <dd class="<?php echo  $corporation_info['license_type'] == 1 ? 'selectTag' : '' ?>" item="1" onclick="license_type_click(1)"> <a  href="javascript:void(0)">新版营业执照（三证合一）</a></dd>
                        <dd class="<?php echo  $corporation_info['license_type'] == 0 ? 'selectTag' : '' ?>" item="0" onclick="license_type_click(0)"><a  href="javascript:void(0)">旧版营业执照（三证三号）</a></dd>
                       
                      	<input type="hidden" name="license_type" value="<?php echo $corporation_info['license_type']  ?>" id="license_type_id">
                      <?php } else { ?>
                      
                      	<dd class="selectTag" onclick="license_type_click(1)"> <a  href="javascript:void(0)">新版营业执照（三证合一）</a></dd>
                        <dd onclick="license_type_click(0)"><a  href="javascript:void(0)">旧版营业执照（三证三号）</a></dd>
                       
                      	<input type="hidden" name="license_type" value="1" id="license_type_id">
                      
                      <?php }?>
                    </dl>
                   <p>此选项会影响到我司给商户开具的发票类型，请如实填写</p>
                 </div>
              </li>
              
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig" id="_zzh">营业执照注册号：</span></div>
                 <div class="information_right">
                     <input class="information_right_input" type="text" name="company_registration" value="<?php echo !empty( $corporation_info['company_registration'] ) ? $corporation_info['company_registration'] : ''; ?>" >
              
                   <!-- <span>注册号错误请重新输入</span> -->
                 </div>
              </li>
             <li>
                <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">营业执照所在地省市：</span></div>
                <div class="information_right">
                  <select class="information_select" id="province_" name="license_province_id">
                         <option value="0" >--省份--</option>
                         <?php foreach($province as $val){?>
                         
                         <?php if( !empty( $corporation_info['license_province_id'] ) && $val['region_id'] == $corporation_info['license_province_id']):?> 
                          <option selected="selected" value="<?php echo $val['region_id'];?>"><?php echo $val['region_name'];?></option> 
                         <?php else:?>
                          <option value="<?php echo $val['region_id'];?>"> <?php echo $val['region_name'];?></option> 
                         <?php endif;?>
                      
                        <?php }?>
                  </select> 
                
                 <select class="information_select" id="city_" name="license_city_id">
                        <?php if(!empty($corporation_info['licecse_city_id'])):?>
                          <?php foreach($city_one as $val):?>
                            <?php if( $val['region_id'] == $corporation_info['licecse_city_id'] ):?>

                              <option selected="selected" value="<?php echo $val['region_id'];?>" ><?php echo $val['region_name'];?></option> 
                            <?php else:?>
                              <option  value="<?php echo $val['region_id'];?>" value="<?php echo $val['region_id'];?>" ><?php echo $val['region_name'];?></option> 
                            <?php endif;?>
                          <?php endforeach;?>
                       <?php else:?>

                          <option value="0"  >--城市--</option> 
                       <?php endif;?>
                 </select> 
                </div>
             </li>
             <script type="text/javascript">
              // 获取省份id
             
               // 省份／市联动
               $("#province_").change(function(){
                 var province_id = $("#province_").val();
//                  if(province_id == 2){
//                     province_id = 52;
//                  }else if(province_id == 25){
//                     province_id = 321;
//                  }else if(province_id == 27){
//                     province_id = 343;
//                  }else if(province_id == 32){
//                     province_id = 349;
//                  }else if(province_id == 35){
//                     province_id = 397;
//                  }else if(province_id == 33){
//                     province_id = 395;
//                  }
                 url = '<?php  echo site_url('Corporation/city');?>';
               
                 // 发送post请求市级信息
                 $.post(
                   url,
                   {province_id:province_id},
                   function(res){
                    var html = '';
                    if(res.data){
                      $("#city_").html("");
                      $.each(res.data, function(i,n){
                          html += '<option value="'+n['region_id']+'">'+n['region_name']+'</option>';
                      });
                      $("#city_").append(html);
                    }
                 },'json');

               });
             </script>

              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">营业执照所在地详细地址：</span></div>
                 <div class="information_right">
                     <input class="information_right_input" type="text" name="license_address" value="<?php echo !empty( $corporation_info['license_address']) ? $corporation_info['license_address'] : ''; ?>">
                	 <p>省市不用填写，从省市后地址填写</p>
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">公司注册资本：</span></div>
                 <div class="information_right">
                   <input class="information_right_input1" type="text" name="Registered_Capital" value="<?php echo !empty( $corporation_info['Registered_Capital']) ? $corporation_info['Registered_Capital'] : ''; ?>">
                   <samp class="information_right_samp">万元(人民币)</samp>
                 </div>
              </li>

               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">营业执照经营范围：</span></div>
                 <div class="information_right">
                 
                  <textarea class="example_fu" name="license_range" id="xix" cols="" rows="" value="<?php echo !empty( $corporation_info['license_range'] ) ? $corporation_info['license_range'] : ''; ?>" placeholder="如”服装、饮食等”" oninput="show()" maxLength="200"><?php echo !empty( $corporation_info['license_range']) ? $corporation_info['license_range'] : ''; ?></textarea>
               
                  <div class="example_fu_dinwei"><i id="sp">0</i>/200</div>
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">营业执照有效期：</span></div>
                 <?php if(isset($corporation_info)):?>
                      <?php     
                        // 处理日期
                        $corporation_info['license_date_from'] = !empty($corporation_info['license_date_from']) ? date("Y-m-d",strtotime($corporation_info['license_date_from'])) : '';
                        $corporation_info['license_date_to'] = !empty($corporation_info['license_date_to']) ? date("Y-m-d",strtotime($corporation_info['license_date_to'])) : '';
                        $corporation_info['organization_date_from'] = !empty($corporation_info['organization_date_from']) ? date("Y-m-d",strtotime($corporation_info['organization_date_from'])) : '';
                        $corporation_info['organization_date_to'] = !empty($corporation_info['organization_date_to']) ? date("Y-m-d",strtotime($corporation_info['organization_date_to'])):'';

                      ?>
                 <div class="information_right">
                     <input onclick="WdatePicker()" id="start_ats1" name="license_date_from" value="<?php echo $corporation_info['license_date_from'] ? $corporation_info['license_date_from'] : ''; ?>" placeholder="请选择时间" readonly class="information_shijian">
                     <small class="information_small">至</small>
                    <input onclick="WdatePicker()" id="end_ats2" name="license_date_to" value="<?php echo $corporation_info['license_date_to'] ? $corporation_info['license_date_to'] : ''; ?>" placeholder="请选择时间" readonly class="information_shijian">
                 </div>
               <?php else:?>
                  <div class="information_right">
                      <input onclick="WdatePicker()" id="start_ats1" name="license_date_from" value="" placeholder="请选择时间" readonly class="information_shijian">
                      <small class="information_small">至</small>
                     <input onclick="WdatePicker()" id="end_ats2" name="license_date_to" value="" placeholder="请选择时间" readonly class="information_shijian">
                  </div>
               <?php endif;?>
              </li>
               <li class="xinbanhiden">
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">组织机构代码证编号：</span></div>
                 <?php if( isset($corporation_info['organization_code_num']) )
                 {
                     $organization_code_num = explode('-', $corporation_info['organization_code_num']);
                 }?>
                 <div class="information_right">
                  
                    <input class="information_right_ye" type="text" name="organization_code_num1" value="<?php echo isset($organization_code_num[0]) ? $organization_code_num[0] : ''; ?>">
                     <small class="information_small1">－</small>
                    <input class="information_right_ye1" type="text" id="organization_code_num2" name="organization_code_num2" value="<?php echo isset($organization_code_num[1]) ? $organization_code_num[1] : ''; ?>">
                 </div>
               
              </li>
              <li class="xinbanhiden">
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">组织机构代码证有效期：</span></div>
                 <div class="information_right">
                     <input onclick="WdatePicker()" id="start_at_no" name="organization_date_from" value="<?php echo !empty( $corporation_info['organization_date_from'] )? $corporation_info['organization_date_from'] : ''; ?>" placeholder="请选择时间" readonly class="information_shijian">
                     <small class="information_small">至</small>
                    <input onclick="WdatePicker()" id="end_at_no" name="organization_date_to" value="<?php echo !empty( $corporation_info['organization_date_to'] )? $corporation_info['organization_date_to'] : ''; ?>" placeholder="请选择时间" readonly class="information_shijian">
                 </div>
              
              </li>
               <li class="xinbanhiden">
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">税务登记证号：</span></div>
                 <div class="information_right">
                  
                   <input class="information_right_input" type="text" name="tax_number" value="<?php echo !empty( $corporation_info['tax_number'] ) ? $corporation_info['tax_number'] : ''; ?>">
                 
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">是否为一般纳税人：</span></div>
                 <div class="information_right">
                    <dl class="information_right_dl" >
                    <?php if(isset($corporation_info['is_taxplayer'])):?>
                        <?php if($corporation_info['is_taxplayer'] == 1):?>
                        <dd class="selectTag" item="1" onclick="taxplayer(this)"><a  href="javascript:void(0)">是</a></dd>
                        <dd  onclick="taxplayer(this)" item="0"><a  href="javascript:void(0)">否</a></dd>
                        <input type="hidden" name="is_taxplayer" value="<?php echo $corporation_info['is_taxplayer'] ? $corporation_info['is_taxplayer'] : 0; ?>" id="is_taxplayer_id">
                      <?php else:?>
                          <dd  item="1" onclick="taxplayer(this)"><a  href="javascript:void(0)">是</a></dd>
                        <dd class="selectTag" onclick="taxplayer(this)" item="0"><a  href="javascript:void(0)">否</a></dd>
                        <input type="hidden" name="is_taxplayer" value="<?php echo $corporation_info['is_taxplayer'] ? $corporation_info['is_taxplayer'] : 0; ?>" id="is_taxplayer_id">
                      <?php endif;?>
                    <?php else:?>
                        <dd class="selectTag" item="1" onclick="taxplayer(this)"><a  href="javascript:void(0)">是</a></dd>
                        <dd class="" onclick="taxplayer(this)" item="0"><a  href="javascript:void(0)">否</a></dd>
                        <input type="hidden" name="is_taxplayer" value="1" id="is_taxplayer_id">
                    <?php endif;?>
                    </dl>
                 </div>
              </li>
              <script type="text/javascript">
                var is_taxplayers = 1;
                function taxplayer(e){
                is_taxplayers = $(e).attr("item");
                // console.log(license_type);
                 $("#is_taxplayer_id").val(is_taxplayers);
                }
               

              </script>
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">法人代表归属地：</span></div>
                 <div class="information_right">
                  <?php if(isset($corporation_info)):?>
                   <select class="information_select_xiao" id="province_" name="legal_person_place"> 
                    <?php foreach($legal_person_place as $index => $val):?>
                      <?php if($corporation_info['legal_person_place'] == (intval($index)+1)):?>
                      <option selected="selected" value="<?php echo intval($index)+1;?>" ><?php echo $val;?></option>
                      <?php else:?>
                        <option  value="<?php echo intval($index)+1;?>"><?php echo $val;?></option>
                      <?php endif;?> 
                    <?php endforeach;?>

                   </select> 
                 <?php else:?>
                    <select class="information_select_xiao" id="province_" name="legal_person_place"> 
                     <?php foreach($legal_person_place as $index => $val):?>
                      
                       <option  value="<?php echo intval($index)+1;?>" ><?php echo $val;?></option>
                      
                      
                     <?php endforeach;?>

                    </select> 
                 <?php endif;?>
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">证件类型：</span></div>
                 <div class="information_right">
                   <h5 class="information_right_h5" name="idcord">身份证</h5>
                 </div>
              </li>
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">法人代表姓名：</span></div>
                 <div class="information_right">
                     <input class="information_right_input" type="text" name="legal_person" value="<?php echo !empty( $corporation_info['legal_person'] ) ? $corporation_info['legal_person'] : ''; ?>">
                 
                 </div>
              </li>
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">身份证号码：</span></div>
                 <div class="information_right">
                  
                   <input class="information_right_input" type="text" name="idcard" value="<?php echo !empty( $corporation_info['idcard'] ) ? $corporation_info['idcard'] : ''; ?>">
                
                 </div>
              </li>
           </ul>
          <div class="type_xuanz_zhong" style="margin-top:10px;">联系信息</div>
          <ul class="information_top">
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">联系人：</span></div>
                 <div class="information_right">
                 
                     <input class="information_right_input" type="text" name="contact_name" value="<?php echo !empty( $corporation_info['contact_name'] ) ? $corporation_info['contact_name'] : ''; ?>" placeholder="请输入联系人姓名">
                
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">联系人手机：</span></div>
                 <div class="information_right">
                  
                     <input class="information_right_input" type="text" name="contact_mobile" value="<?php echo !empty( $corporation_info['contact_mobile'] ) ? $corporation_info['contact_mobile'] : ''; ?>" placeholder="请输入联系人手机">
                    
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">联系人邮箱：</span></div>
                 <div class="information_right">
                   
                   <input class="information_right_input" type="text" name="email" value="<?php echo !empty( $corporation_info['email'] ) ? $corporation_info['email'] : ''; ?>" placeholder="请输入联系人邮箱">
                
                 </div>
              </li>
               <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">企业办公地址：</span></div>
                 <div class="information_right">
                  
                   <input class="information_right_input" type="text" name=address value="<?php echo !empty( $corporation_info['address'] )? $corporation_info['address'] : ''; ?>" placeholder="请填写详细地址">
               
                 </div>
              </li>
              <li>
                 <div class="information_left"><span class="information_xingxing">*</span><span class="information_xirig">企业固定电话：</span></div>
                 <?php  if(isset($corporation_info['tel_num'])){
                  $tel_num = explode('-',$corporation_info['tel_num']);

                 }?>
				 <div class="information_right">
                   <input class="information_right_dian" type="text" name="tel_num1" value="<?php echo isset($tel_num[0])?$tel_num[0]:'';?>" >
                   <input class="information_right_dianhua" type="text" name="tel_num2" value="<?php echo isset($tel_num[1])?$tel_num[1]:'';?>"  >
                   
                    <p>公司固定电话格式如：025-66996699</p>
                 </div>
              
              </li>
              <li>
                 <div class="information_left">邀请人：</div>
                 <div class="information_right">
                 
                   <input class="information_right_input" type="text" name="sponsor_mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" placeholder="请输邀请人"><span></span>
               
                    
                 </div>
              </li>

          </ul>
         
          <div class="type_xuanz_xia" style="margin: 40px 0 0 330px; background:none; width: auto; height: 50px; line-height: 50px;border-radius: 5px; ">
             <button style="cursor: pointer;font-size: 18px;color:#ffffff;text-align:center;line-height:50px;width:240px;background: #72c312;border-radius:5px;border-color:#72c312; float: left; margin-right:15px " >下一步，上传资质</button>
             <a style="color:#333333; float:left; margin-left:20px;" class="zizhi_wei_c" href="javascript:window.history.go(-1)">上一步</a>
         </div>
      
         
        </div>
    </div>
   </form> 
    
 <script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<script>
 <!--点击切换-->

var license_type = $("input[name=license_type]").val();//选择类型
license_type_click(license_type);

$('.information_right_dl dd').click(function(){
	$(this).siblings().removeClass('selectTag');
	$(this).addClass('selectTag');
	
});	


function license_type_click(license_types){

    $("input[name=license_type]").val(license_types);

	if( license_types == 1 )
	{
		$('#_zzh').text('统一社会信用代码：');
		$('.xinbanhiden').hide();
	}else{ 
		$('.xinbanhiden').show();
		$('#_zzh').text('营业执照注册号：');
	}
}
                 
<!--字数限制-->
//控制字数
function show(){
    var tarea=document.getElementById("xix");
    var maxlength=200;
    var length=tarea.value.length;
    var count=maxlength-length;
    var sp=document.getElementById("sp");
        sp.innerHTML=length;
		if(count<=20){
		sp.style.color="red"; 
		 }else{
    	 sp.removeAttribute("style");
     }
  }

</script>   
<script type="text/javascript">
  //增加身份证验证
  function isIdCardNo(num) {
      var factorArr = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1);
      var parityBit = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
      var varArray = new Array();
      var intValue;
      var lngProduct = 0;
      var intCheckDigit;
      var intStrLen = num.length;
      var idNumber = num;
      // initialize
      if ((intStrLen != 15) && (intStrLen != 18)) {
          return false;
      }
      // check and set value
      for (i = 0; i < intStrLen; i++) {
          varArray[i] = idNumber.charAt(i);
          if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
              return false;
          } else if (i < 17) {
              varArray[i] = varArray[i] * factorArr[i];
          }
      }
      if (intStrLen == 18) {
          //check date
          var date8 = idNumber.substring(6, 14);
          if (isDate8(date8) == false) {
              return false;
          }
          // calculate the sum of the products
          for (i = 0; i < 17; i++) {
              lngProduct = lngProduct + varArray[i];
          }
          // calculate the check digit
          intCheckDigit = parityBit[lngProduct % 11];
          // check last digit
          if (varArray[17] != intCheckDigit) {
              return false;
          }
      }
      else {        //length is 15
          //check date
          var date6 = idNumber.substring(6, 12);
          if (isDate6(date6) == false) {
              return false;
          }
      }
      return true;
  }

    $.validator.addMethod("isMobile", function(value, element) {
         var length = value.length;
         var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
         return this.optional(element) || (length == 11 && mobile.test(value));
     }, "请正确填写您的手机号码");
 
    // 身份证号码验证
    $.validator.addMethod("isIdCardNo", function(value, element) { 

        
      var length = value.length;
//       isIDCard=/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/;
      isIDCard= /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
      return this.optional(element) || (length == 18 && isIDCard.test(value));   
    }, "请输入正确的身份证号码。");  

    // 校验不能为空字符串
    $.validator.addMethod("Notnull", function(value, element) { 
      var length = value.length;
       var reg = /\S/;
      return this.optional(element) || (length != 0  && reg.test(value));
      // return this.optional(element) || isIdCardNo(value);    
    }, "不能为空字符串");      

    // 校验金额
    $.validator.addMethod("money", function(value, element) { 
       
      var length = value.length;
       var amount = /(^[1-9]\d*(\.\d{1,2})?$)|(^0(\.\d{1,2})?$)/;;
      return this.optional(element) || (amount.test(value));
      // return this.optional(element) || isIdCardNo(value);    
    }, "请按正确的金额格式输入(保留两位小数)");  

    $.validator.addMethod("names", function(value, element) { 
       var length = value.length;
       var contents = /^[\da-zA-Z_\u4e00-\u9f5a]{4,30}$/;
      return this.optional(element) || (length != 0  && contents.test(value));
      // return this.optional(element) || isIdCardNo(value);    
    }, "用户名为4-30个字符"); 

     $.validator.methods.compareDate = function(value, element, param) {
            //var startDate = jQuery(param).val() + ":00";补全yyyy-MM-dd HH:mm:ss格式
            //value = value + ":00";
            
            var startDate = jQuery(param).val();
           
            var date1 = startDate ;//new Date(Date.parse(startDate.replace("-", "/")));
            var date2 = value; //new Date(Date.parse(value.replace("-", "/")));
            return date1 < date2;
    };

    $.validator.addMethod("nums", function(value, element) {  
        var num = /^[A-Za-z0-9]+$/;         
         return this.optional(element) || idcode.test(value);       
    }, "只能输入数字字母");  


  $("#form-step2").validate({
      groups:{
           username1:"organization_code_num1 organization_code_num2"
       },
       errorPlacement:function(error,element) {
           if (element.attr("name") == "organization_code_num1" || element.attr("name") == "organization_code_num2")   
               error.insertAfter("#organization_code_num2");
           else    
               error.insertAfter(element);
       },
       
        groups:{
           username2:"license_date_from license_date_to"
       },
       errorPlacement:function(error,element) {
           if (element.attr("name") == "license_date_from" || element.attr("name") == "license_date_to")   
               error.insertAfter("#end_ats2");
           else    
               error.insertAfter(element);
       },
        groups:{
           username3:"organization_date_from organization_date_to"
       },
       errorPlacement:function(error,element) {
           if (element.attr("name") == "organization_date_from" || element.attr("name") == "organization_date_to")   
               error.insertAfter("#organization_date_to");
           else    
               error.insertAfter(element);
       },
      groups:{
           username4:"tel_num1 tel_num2"
       },
       errorPlacement:function(error,element) {
           if (element.attr("name") == "tel_num1" || element.attr("name") == "tel_num2")   
               error.insertAfter("#tel_nums");
           else    
               error.insertAfter(element);
       },
    rules:{
      corporation_name:{
        required:true,
        // Notnull:true,
        // minlength: 4
        names:true,
      },
      company_registration:{
        required:true,
//         digits:true
      
      },
      license_province_id:{
        required:true
      },
      license_city_id:{
        required:true,
      },
      license_address:{
        required:true,
        Notnull:true,
      },
      Registered_Capital:{
        required:true,
        money:true,
      },
      license_range:{
        required:true,
        Notnull:true,
      },


      license_date_from :{
        required:true

      },
      license_date_to :{
        required:true,
        compareDate: "#start_ats1"
      },

	  organization_code_num1 :{
        required:true
       
      },
      organization_code_num2 :{
        required:true
        
      },
      
      organization_date_from :{
        required:true,
       
      },
      organization_date_to :{
        required:true,
        compareDate: "#start_at_no"
      },
      tax_number :{
        required:true,
         digits:true
      },
      legal_person_place :{
        required:true,
        Notnull:true,
      },
      legal_person :{
        required:true,
        Notnull:true,
      },
      idcard :{
        required:true,
        isIdCardNo:true,
        // minlength:18,
        // maxlength:18,
      },
      contact_name :{
        required:true,
        Notnull:true,
      },
      contact_mobile :{
        required:true,
        isMobile:true,
      },
      email :{
        required:true,
        email: true
      },
      address :{
        required:true,
        Notnull:true,
      },
      tel_num1 :{
        required:true,
        digits:true
      },
      tel_num2 :{
        required:true,
        digits:true
      },
      // agent_customer_id:{
      //   isMobile:true,
        // remote:{
        //   url:'<?php //echo site_url();?>',
        //   type:'post',
        //   dataType:"json",
        //   data:{
        //     inviter_id:function(){
        //       return $("input[name='agent_customer_id']").val();
        //     }
        //   }
        // }
      // }
  
    },
    messages:{
      corporation_name:{
        required:"请输入企业名称",
        Notnull:'请输入企业名称',
        minlength:'企业名称不能小于4个字符'
        
      },
      company_registration:{
        required:"请输入营业执照注册号",
//         digits:'输入的营业执照注册号必须是数字'
        
      },
      license_province_id:{
        required: "不能为空",
      },
      license_city_id:{
        required: "不能为空",
      }, 
      license_address:{
        required: "请输入地址",
        Notnull:'请输入地址'
      },  
      Registered_Capital:{
        required: "请输入注册资本",
        number:'必须输入合法的数字',
        min:'最小不能小于1',
      },  
      license_range:{
        required: "请输入营业执照经营范围",

      }, 
      license_date_from:{
        required: "开始时间不能为空",
      },
      license_date_to:{
        required: "结束时间不能为空",
        compareDate: "结束日期必须大于开始日期!"
      },
       organization_code_num1 :{
        required:'请输入组织机构代码证编号',
         digits:'请输入组织机构代码证编号'
      },
       organization_code_num2 :{
        required:'请输入组织机构代码证编号',
        digits:'请输入组织机构代码证编号'
      },
      organization_date_from :{
        required:'开始时间不能为空',
        
      },
      organization_date_to :{
        required:'结束时间不能为空',
        compareDate: "结束日期必须大于开始日期!"
      },
      tax_number :{
        required:'请输入税务登记证号',
        digits:'请输入税务登记证号'
      },
      legal_person_place :{
        required:'请输入法人代表归属地',
      },
      legal_person :{
        required:'请输入法人代表姓名',
      },
      idcard :{
        required:'请输入身份证号码',
        isIdCardNo:'请输入正确的身份证号码',
        // isIdCardNo:'请输入正确的身份证号码。',
        // minlength:'请输入正确的身份证号码。',
        // maxlength:'请输入正确的身份证号码。',
      },
      contact_name :{
        required:'请输入联系人',
      },
      contact_mobile :{
        required:'请输入手机号码',
        isMobile:' 请输入正确的手机号码'
      },
      email :{
        required:'联系人邮箱不能为空',
        email: '您输入的邮件格式不正确'
      },
      address :{
        required:'请输入企业办公地址',
      },
      tel_num1 :{
        required:'请输入企业固定电话',
        digits:"请输入企业固定电话"
      },
      tel_num2 :{
        required:'请输入企业固定电话',
        digits:"请输入企业固定电话"
      },
      // agent_customer_id:{
      //   isMobile:'请输入正确的手机号码'
      // }

                                          
    },
    onkeyup:false,
    focusCleanup:false,
    success:"valid",
    submitHandler:function(form){

      merchant_save(form);// merchant_save(form)方法 用来处理抛送请求的哦
      
    }
  });

  // merchant_save(form)方法 用来处理抛送请求的哦
  function merchant_save(form)
  {
    var mobile = $("input[name='sponsor_mobile']").val();
    $("input[name='sponsor_mobile']").next().html("");
	
    if( mobile )
    {   
        $.post(
        '<?php echo site_url('corporation/ajax_check_mobile');?>',
        {mobile:mobile},
        function(data){
            
          if ( data.code == 0 )
          {
            $("input[name='sponsor_mobile']").next().html(data.msg);
			 return;
          }
          sub_corp(form);
          
        },'json');
        
        return;
    }
        
	sub_corp(form);
}


  function sub_corp(form)
  { 
	  var data = $(form).serialize();
      console.log(data);
      // 证照类型
  
      url = '<?php echo site_url("Corporation/save_corp_info");?>';
  
      $.post(url, data, function(result){

      	console.log(result);
        if(result.code == 0)
        {
      	  	alert('保存失败,刷新后重新填写'); 
            setTimeout("location.reload()", 1000); 
            return;
        }else if(result.code == 1){
         
          window.location.href="<?php echo site_url("corporation/qualification");?>";
        }
      }, 'JSON');
  }
</script>

