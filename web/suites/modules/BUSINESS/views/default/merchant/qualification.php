<link rel="stylesheet" type="text/css" href="css/fancybox.css">

<style>

.stored_chong_yichu span {
    background: rgba(0,0,0,0.5);
    height: 30px;
    line-height: 30px;
    padding-left: 30px;
    float: left;
    padding-right: 22px;
}
#fancybox-wrap{z-index: 9999999;}
</style>
<!--填写公司信息 -->
<?php 
if(isset($imgs) && $corporation_info['license_type'] == 1){
  $img = $imgs;
  // var_dump($oimg);
}
?>

<script type="text/javascript" src="js/jquery.validate.merchant.js"></script>

     <div class="home_page">
        <div class="type_xuanz">
           <div class="type_xuanz_top">
               <ul class="step-case" id="step"> 
                    <li class="s-finish"><a href="javascript:;"><span>① 店铺类型/类目选择</span><b class="b-l"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>② 填写公司信息</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-cur"><a href="javascript:;"><span>③ 上传资质</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-cur-next"><a href="javascript:;"><span>④ 等待审核</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li><a href="javascript:;"><span>⑤ 网上缴费、店铺上线</span><b class="b-1"></b><b class="b-2"></b><b class="b-r"></b></a></li> 
                </ul>
         </div>
   
   
         <div class="type_xuanz_zhong">店铺类型<span>(所有资质必须清晰可辨并 加盖贵司红章/彩章（即在资质复印件上 加盖贵司自己的红章，再扫描或拍照上传；若上传原件，也需加盖公章)</span></div>
             <ul class="zizhi_top">
                 <h5 class="zizhi_top_h5">公司基本资料（特殊格式支持JPG、GIF、JPEG、PNG，图片大小不超过1M</h5>
                 <li>
                 <div class="zizhi_left">证照类型：</div>
                 <div class="zizhi_right">
                    <dl class="zizhi_right_dl">
                      <!-- o表示旧版，1表示新版 -->
                        <dd class="<?php echo $corporation_info['license_type'] == 1 ? 'selectTag' : '' ?>" item="1"><a  href="javascript:void(0)">新版营业执照（三证合一）</a></dd>
                        <dd class="<?php echo $corporation_info['license_type'] == 0 ? 'selectTag' : '' ?>" item="0"  ><a  href="javascript:void(0)">旧版营业执照（三证三号）</a></dd>
                        <input type="hidden" id="license_type_id" name="license_type" value="">
                    </dl>
                 </div>
                 <span class="zizhi_right_dl_span">旧版营业执照还需填写税务登记证、组织机构代码</span>
              </li>
             </ul>
          
          <?php if( $corporation_info['license_type'] == 1 ){?>
          
          <form id="form-step3" method="post" action="<?php echo site_url("corporation/save_credential");?>" enctype="multipart/form-data">
            <div class="zizhi_yin">
             <ul class="zizhi_zhong">
                <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>统一社会信用代码证复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_licence')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                           <div class="stored_chong_top_lo" id="stored_chong_top_lo1">
                            <p class="icon-shangchuan"></p>
                            <!-- 企业营业执照 -->
                           <input type="file" accept="image/*"  id="thubm_xiao1" name="bus_licence_img" onchange="previewImg(this,'#thubm')"> 
                           <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao1.click();">重新上传</span> <!-- <!-- <span class="stored_chong_shangchu">删除</span> --> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['bus_licence_img'] ) ? IMAGE_URL.$corporation_info['bus_licence_img'] : 'images/tongming.png';?>" id="thubm" flag='bus_licence_img'>
                     </h2>
                    </div>
                </li>
                <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>法人身份证正反面复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_card')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <?php 
                  
                   
                   ?>
                     <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                          <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao2" name="idcard_img1" onchange="previewImg(this,'#thubm_1')"> 
                           <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao2.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['card_front'] ) ? IMAGE_URL.$corporation_info['card_front'] : 'images/tongming.png';?>" id="thubm_1" flag='idcard_img1'>
                     </h2>
                    </div>
                   
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                           <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao3" name="idcard_img2" onchange="previewImg(this,'#thubm_2')"> 
                            <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao2.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['card_back'] ) ? IMAGE_URL.$corporation_info['card_back'] : 'images/tongming.png';?>" id="thubm_2" flag='idcard_img2'>
                  	 </h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>行业资质<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_industry')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                            <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao4" name="industry_qua" onchange="previewImg(this,'#thubm_3')"> 
                             <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao4.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                         <img src="<?php echo !empty( $corporation_info['industry_qua'] ) ? IMAGE_URL.$corporation_info['industry_qua'] : 'images/tongming.png';?>" id="thubm_3" flag='industry_qua'>
                     </h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>平台授权委托书<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_platform')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                          <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao5" name="proxy_img" onchange="previewImg(this,'#thubm_4')"> 
                            <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao5.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                         <img src="<?php echo !empty( $corporation_info['proxy_img'] ) ? IMAGE_URL.$corporation_info['proxy_img'] : 'images/tongming.png';?>" id="thubm_4" flag='proxy_img'>
                     </h2>
                    </div>
                </li>
             </ul>
            
            <div class="zizhi_wei">
            <p>
              <label><input type="checkbox" checked="checked" class="zizhi_wei_input" value="1" id="choose1" name="choose"><a target=_blank style="font-size:16px;"href="<?php echo site_url("merchant/agreement");?>">同意并遵守<span class="zizhi_wei_span">《51易货企业入驻协议》</span></a></label>
            </p>
                <button style="cursor: pointer;font-size: 18px;color:#ffffff;text-align:center;line-height:50px;width:200px;background: #128cc3;border-radius:5px;border-color:#128cc3; margin-right:20px;" >提交审核</button>
            
              <!-- <a class="zizhi_wei_b" href="<?php echo site_url("merchant/to_examine");?>">提交审核</a> -->
              <a class="zizhi_wei_c" href="javascript:window.history.go(-1)">上一步</a>
            
            </div>
         </div>
</form>



<?php }else{?>




<form id="form-step4" method="post" action="<?php echo site_url("corporation/save_credential");?>" enctype="multipart/form-data">     
         <div class="zizhi_yin" >
             <ul class="zizhi_zhong">
                <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>企业营业执照副本复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_licence_jiu')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                           <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  accept="image/*"  id="thubm_xiao6" name="bus_licence_img" onchange="previewImg(this,'#thubm_5')"> 
                           <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao6.click();">重新上传</span>
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                         <img src="<?php echo !empty( $corporation_info['bus_licence_img'] ) ? IMAGE_URL.$corporation_info['bus_licence_img'] : 'images/tongming.png';?>" id="thubm_5" flag="bus_licence_img">
                     </h2>
                    </div>
                </li>
                <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>组织机构代码证复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_organization')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                           <div class="stored_chong_top_lo" id="stored_chong_top_los">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao8" name="organization_code_image" onchange="previewImg(this,'#thubm_7')"> 
                         <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao8.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['organization_code_image'] ) ? IMAGE_URL.$corporation_info['organization_code_image'] : 'images/tongming.png';?>" id="thubm_7" flag='organization_code_image'>
                    </h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>税务登记证复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_registration')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                           <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao9" name="tax_images" onchange="previewImg(this,'#thubm_8')"> 
                           <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao9.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['tax_images'] ) ? IMAGE_URL.$corporation_info['tax_images'] : 'images/tongming.png';?>" id="thubm_8" flag='tax_images'>
                  	</h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>法人身份证正反面复印件<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_card')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                          <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao7" name="idcard_img1" onchange="previewImg(this,'#thubm_6')"> 
                          <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao7.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['card_front'] ) ? IMAGE_URL.$corporation_info['card_front'] : 'images/tongming.png';?>" id="thubm_6" flag='idcard_img1'>
                  	</h2>
                    </div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                            <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao10" name="idcard_img2" onchange="previewImg(this,'#thubm_9')"> 
                         <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao10.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['card_back'] ) ? IMAGE_URL.$corporation_info['card_back'] : 'images/tongming.png';?>" id="thubm_9" flag='idcard_img2'>
                  	</h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>行业资质<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_industry')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                          <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao11" name="industry_qua" onchange="previewImg(this,'#thubm_10')"><h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao11.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                         <img src="<?php echo !empty( $corporation_info['industry_qua'] ) ? IMAGE_URL.$corporation_info['industry_qua'] : 'images/tongming.png';?>" id="thubm_10" flag='industry_qua'>
                    </h2>
                    </div>
                </li>
                 <li>
                   <div class="zizhi_zhong_left"><samp class="zizhi_zhong_samp">*</samp>平台授权委托书<span>(<i class="zizhi_zhong_cha" onclick="fb_showimg('fb_platform')">查看范本</i>，需加盖公司主体红章)</span></div>
                   <div class="stored_chong_xia_z">  
                      <div class="stored_chong_top">                
                            <div class="stored_chong_top_lo">
                            <p class="icon-shangchuan"></p>
                           <input type="file" accept="image/*"  id="thubm_xiao12" name="proxy_img" onchange="previewImg(this,'#thubm_11')"> 
                        <h5 class="yijji">上传</h5>
                           <div class="stored_chong_yichu">
                            <span onclick="thubm_xiao12.click();">重新上传</span><!-- <span class="stored_chong_shangchu">删除</span> -->
                           </div>
                           </div>
                       </div>
                     <h2 class="stored_chong_h2">
                     	<img src="<?php echo !empty( $corporation_info['proxy_img'] ) ? IMAGE_URL.$corporation_info['proxy_img'] : 'images/tongming.png';?>" id="thubm_11" flag='proxy_img'>
                  	 </h2>
                    </div>
                </li>
             </ul>
            <div class="zizhi_wei">
              <p>
                <label id="agreements"><input type="checkbox" checked="checked" class="zizhi_wei_input" value="1" id="choose1" name="choose"><a target=_blank style=" font-size:16px;" href="<?php echo site_url("merchant/agreement");?>">同意并遵守<span class="zizhi_wei_span">《51易货企业入驻协议》</span></a></label>
              </p>

                <button style="cursor: pointer;font-size: 24px;color:#ffffff;text-align:center;line-height:60px;width:200px;background: #128cc3;border-radius:3px;border-color:#128cc3; margin-right:20px;" >提交审核</button>
            
             <a class="zizhi_wei_c" href="javascript:history.go(-1);">上一步</a>
            </div>
         </div>
       </div>
    </div>
</form>


<?php }?>


<script type="text/javascript">
  
  var license_type = $(".selectTag").attr("item");
  url = '<?php echo site_url('merchant/save_examine');?>';
  function submit_examine()
  {
    $.post(url,
      {license_type:license_type},
      function(res){
        console.log(res);
      },'json');
  }
</script>

<!--弹出层 fancybox_license_example 示例 开始-->
    <div class="fancybox_license_example" style=" display:none;"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">企业营业执照示例</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
                  <div style="width:auto;height:auto;overflow: auto;position:relative;">
                      <div id="inline1" class="fancybox-inline1 fancybox-inline1_basic" >
                      
                        <div class="fancybox-editCon clearfix"><!--企业营业执照示例-->
                          <img src="images/Business_license_new.jpg" width="880" alt=""/ id="fb_img">
                       </div>
                  </div>
              </div>
              </div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_license_example">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_license_example 示例 结束-->
    

  
<script>

//范本图片路径

var img = new Array();
img['fb_card'] = 'images/identity_card.jpg';//身份证
img['fb_licence'] = 'images/Business_license_new.jpg';//新版营业执照
img['fb_licence_jiu'] = 'images/Business_license.png';
img['fb_industry'] = 'images/industry_qualification.jpg';//行业资质
img['fb_platform'] = 'images/Power_of_attorney.jpg';//平台授权委托书示例
img['fb_organization'] = 'images/organization.jpg';//组织机构代码证
img['fb_registration'] = 'images/Tax_registration.jpg';//税务登记证



function fb_showimg(value)
{ 
	$('#fb_img').attr('src',img[value]);
	$('.fancybox_license_example').show();
}

 <!--点击切换-->

// 封面上传图片预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader(),
            img = new Image();       
        reader.onload = function (e) {
            console.log(input.files[0].size);
            if(input.files[0].size>2048000){//图片大于2M则压缩
//                 img.src = e.target.result;
//                 img.onload=function(){
//                     $(obj).attr('src', compress(img));
//                 }
				alert('上传的图片不能超过2M');
            }else{
              $(obj).attr('src', e.target.result);
              $(input).siblings(".icon-shangchuan").hide();
         $(input).siblings(".yijji").hide();
         $(input).parents().children('.stored_chong_h2').show();
          var A = false;//移动到input上
          var B = false;//移动到div
         $(input).on('mouseenter',function(){
          A = true;
          $(input).parents().children('.stored_chong_yichu').show();
          $(input).parents().children('.stored_chong_yichu').on('mouseenter',function(){
            B = true;
              $(input).parents().children('.stored_chong_yichu').show();
            
          });
          $(input).parents().children('.stored_chong_yichu').on('mouseleave',function(){
            B = false;
              $(input).parents().children('.stored_chong_yichu').hide();
            
          });   
         })
        $(input).on('mouseleave',function(){
           A = false;
            $(input).parents().children('.stored_chong_yichu').hide(); 
           })
 
        if(!B && !A){
            $(input).parents().children('.stored_chong_yichu').hide();
            }else{
              $(input).parents().children('.stored_chong_yichu').show();
      }
            }
//       $(".stored_chong_shangchu").click('mouseenter',function(){
//          $(this).parents(".stored_chong_top").siblings(".stored_chong_h2").hide();
//          $(this).parents(".stored_chong_top_lo").children(".icon-shangchuan").show();
//          $(this).parents(".stored_chong_top_lo").children(".yijji").show();
//        })
        }
        reader.readAsDataURL(input.files[0]);
        return 1;
    }  
}

$("form").submit(function(e){
	  
	  if( !$('#choose1').is(':checked') )
	  { 
		  alert('请勾选51易货企业入驻协议');
		  return false;
	  }
	  
	  if( !$('input[name=bus_licence_img]').val() && $('img[flag=bus_licence_img]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }

	  <?php if( !$corporation_info['license_type'] ) { //旧版?>
		  
	  if( !$('input[name=organization_code_image]').val() && $('img[flag=organization_code_image]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }

	  if( !$('input[name=tax_images]').val() && $('img[flag=tax_images]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }
	  <?php }?>

	  if( !$('input[name=idcard_img1]').val() && $('img[flag=idcard_img1]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }

	  if( !$('input[name=idcard_img2]').val() && $('img[flag=idcard_img2]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }

	  if( !$('input[name=industry_qua]').val() && $('img[flag=industry_qua]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }

	  if( !$('input[name=proxy_img]').val() && $('img[flag=proxy_img]').attr('src') == 'images/tongming.png' )
	  { 
		  alert('带*号为必上传项');
		  return false;
	  }
	 
});
	
//压缩图片函数
function compress(img) {
    var initSize = img.src.length;
    var width = img.width;
    var height = img.height;
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
    var ratio;
    if ((ratio = width * height / 4000000)>1) {
        ratio = Math.sqrt(ratio);
        width /= ratio;
        height /= ratio;
    }else {
        ratio = 1;
    }
    canvas.width = width;
    canvas.height = height;
    //铺底色
    ctx.fillStyle = "#fff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0, width, height);
    //进行最小压缩
    var ndata = canvas.toDataURL("image/jpeg", 0.1);
    // console.log(ndata.length)
    canvas.width = canvas.height = 0;
    return ndata;
}


$.extend($.validator.messages, {
      required: "此选项为必选项",
      remote: "请修正此字段",
      email: "请输入有效的电子邮件地址",
      url: "请输入有效的网址",
      date: "请输入有效的日期",
      dateISO: "请输入有效的日期 (YYYY-MM-DD)",
      number: "请输入有效的数字",
      digits: "只能输入数字",
      creditcard: "请输入有效的信用卡号码",
      equalTo: "你的输入不相同",
      extension: "请输入有效的后缀",
      maxlength: $.validator.format("最多可以输入 {0} 个字符"),
      minlength: $.validator.format("最少要输入 {0} 个字符"),
      rangelength: $.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),
      range: $.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),
      max: $.validator.format("请输入不大于 {0} 的数值"),
      min: $.validator.format("请输入不小于 {0} 的数值")
  });


 




  <!--点击显示弹窗-->
// $(".zizhi_zhong_cha").click('mouseenter',function(){
//   $(this).parents().children('.fancybox_license_example').show();
// })
<!--点击隐藏弹窗-->
$(".fancybox_okay").click('mouseenter',function(){
  $(this).parents().children('.fancybox_license_example').hide();
})
</script>       