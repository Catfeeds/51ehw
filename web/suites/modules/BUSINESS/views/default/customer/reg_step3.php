<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<!-- <script type="text/javascript" src="js/diyUpload.js"></script>-->
<script type="text/javascript" src="js/Validform.js"></script>
<script type="text/javascript" src="js/select2.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme/select2.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<style>

#tagContent { }
.tagContent { display: none; }
#tagContent div.selectTag { display: block }
/*产品tab*/
#basic_tags li {float: left; list-style:none;}
#basic_tags li a {background:url(images/btn_show_tab_01.png) no-repeat 0 center;width: 150px; /*height: 35px;*/ overflow:hidden; display:block; color:#555;}
#basic_tags li a:hover{ color:#555;}
#basic_tags li.selectTag, #basic_tags li.selectTag a{background:url(images/btn_show_tab_02.png) no-repeat 0 center;width: 150px;/* height: 35px;*/display:block; color:#fea33b;}

</style>

   <!--内容 开始-->
    <div class="regsiter_02_con">
     <form action="<?php echo site_url('customer/save_3') ?>" method="post" id="form" name="form">
    	<div class="regsiter_02_con_top regsiter_03_con_top">企业用户认证信息完善
        	<!-- <div class="regsiter_03_con_topBtn"><a href="#">先随便逛逛</a></div> -->
        </div>
        <div class="regsiter_02_con_con clearfix">
        	<!--内容头部 开始-->

            <div class="clearfix">
            
                <div class="regsiter_02_left">
                    <ul>
                        <li><span class="regsiter_02_span">*</span>企业行业：</li>
                        <li><span class="regsiter_02_span">*</span>企业性质：</li>
                        <li><span class="regsiter_02_span">*</span>企业法人：</li>
                        <li><span class="regsiter_02_span">*</span>身份证号：</li>
                        <li><span class="regsiter_02_span">*</span>工商注册号：</li>
                    </ul>
                </div>
                <div class="regsiter_02_right dropdown regsiter_02_right2">
                    <ul>
                        <li>
                    
                        	   <select id="select2" style="width:274px; padding:0px;" name="Industrial_Info" class="form-control select2 dropdown_select03" placeholder="行业"  required >
                        	     <option value="">行业</option>
                        	   <?php if(isset($cor_ind) && count($cor_ind)>0): ?>
                        	   <?php foreach ($cor_ind as $ci): ?>
                        	       <option value="<?php echo $ci['id'] ?>" <?php echo isset($dt['Industrial_Info'])&&$dt['Industrial_Info']==$ci['id']?'selected':'' ?>><?php echo $ci['name'] ?></option>
                        	   <?php endforeach;?>
                        	   <?php endif;?>
                              
                        	   </select>

                        	<div id="error" style="width:100px;display:none;float:right;margin-right: 158px; margin-top: -3px; font-size:14px; color:red"></div>
                                <!-- <select class="dropdown_select03">
                                    <option>行业</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>-->
                            
                        </li>
                        <li>

                                <select class="dropdown_select03"  name="nature" id="nature" required>
                                    <option value="">性质</option>
                                    <?php if(isset($cor_type)&&count($cor_type)>0): ?>
                                    <?php foreach ($cor_type as $ct): ?>
                                        <option value="<?php echo $ct['id'] ?>" <?php echo isset($dt['nature'])&&$ct['id']==$dt['nature']?'selected':'' ?>><?php echo $ct['name'] ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <!-- <option>1</option>
                                    <option>2</option>
                                    <option>3</option>-->
                                </select>
                                <div id="error2" style="width:100px;display:none;float:right; margin-right: 258px; margin-top: 8px;font-size:14px; color:red"></div>

                        </li>
                        <li>
                        <input type="text"  class="regsiter_02_input" value="<?php echo isset($dt['legal_person'])?$dt['legal_person']:'' ?>" placeholder="请填写企业法人名称" name="legal_person" id="legal_person" >
                        <div id="error3" style="width:120px;display:none;float:right; margin-right: 238px; margin-top: 8px;font-size:14px; color:red"></div>
                        </li>
                        <li>
                        <input type="text" class="regsiter_02_input" value="<?php echo isset($dt['idcard'])?$dt['idcard']:'' ?>" placeholder="请填写企业法人身份证号码" name="idcard" id="idcard" >
                        <div id="error4" style="width:100px;display:none;float:right; margin-right: 258px; margin-top: 8px;font-size:14px; color:red"></div>
                        </li>
                        <li>
                        <input type="text" class="regsiter_02_input" value="<?php echo isset($dt['company_registration'])?$dt['company_registration']:'' ?>" placeholder="请填写企业工商注册号" name="company_registration" id="company_registration" >
                        <div id="error5" style="width:120px;display:none;float:right; margin-right: 238px; margin-top: 8px;font-size:14px; color:red"></div>
                        </li>
                    </ul>
                </div>
                
			</div>
            
            <!--内容头部 结束-->
        </div>
        <div class="regsiter_02_con_top regsiter_03_con_top">上传资料
        	<!-- <div class="regsiter_03_con_topBtn"><a href="#">先随便逛逛</a></div> -->
        </div>
            <div class="regsiter_wanshan_renzheng_con basicInformation_down">

              
              <!--修改认证内容tab2 开始-->
              <div class="renzheng_tab2" >
              <!--营业执照 开始-->               
              <div class="regsiter_renzheng_con">
                  <div class="regsiter_renzheng_left basicInformation_downLeft">营业执照：</div>
                  <div class="clearfix">
                  <div class="regsiter_renzheng_right clearfix">
                      <div class="renzheng_right_yingyezhizhao">
                      
                      <ul id="basic_tags">

                            <li class="selectTag">
                              <a onClick="selectTag('tagContent0',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 新版营业执照 </a>
                            </li>
                            <li>
                              <a onClick="selectTag('tagContent1',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 旧版营业执照</a>
                            </li>

                      </ul>
                      <div class="clearfix"></div><!--清除浮动-->
                          <!--<label class="yingyezhizhao_lable"><input type="radio" class="yingyezhizhao_radio" checked="checked">新版营业执照</label>
                          <label><input type="radio" class="yingyezhizhao_radio" ></label>-->
                          
                      <div id="tagContent">
               
                              <div class="tagContent selectTag" id="tagContent0">
                          
                              <!--选择新版营业执照显示以下内容 开始 默认显示新版-->
                              <div class="yingyezhizhao_new Business_license_new clearfix" style="display:block;position:relative;">
                              <p class="yingyezhizhao_p">请上传《营业执照》文件</p>
                              <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp  .png格式照片，大小不超过2M。<a class="Bussiness_license_example">查看示例</a></p>
                              <!--上传营业执照后显示图片div 未上传前display＝none-->
                              <br>
                              <span class="yingyezhizhao_span">新版需上传：法人营业执照（三证合一）</span>
                              <!--  -->
                              <div class="yingyezhizhao_img" style="display:block">
                                <a class="Business_license_img" id="new_img"><img src="images/Business_license_new.jpg" width="150" height="110" alt=""/></a>
                              </div>
                              
                              <div class="shangchuan_btn01" id="news" style="width:88px;line-height:10px;position:absolute;left:0;top:244px"><a href="javascript:;">更换文件</a></div>
                              <!--上传按钮-->
                              
                              
                              </div>
                              <!--选择新版营业执照显示内容 结束-->
                              
                              </div>
                              
                              <div class="tagContent" id="tagContent1">
                          
                            <!--选择新版营业执照显示以下内容 开始 默认隐藏旧版-->
                              <div class="yingyezhizhao_old" style="display:block;position:relative;">
                                  <p class="yingyezhizhao_p">请上传《营业执照》文件</p>
                                  <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp  .png格式照片，大小不超过2M。<a class="oldBusiness_example" onclick="oldbusiness();">查看示例</a></p>
                                  <!--上传营业执照后显示图片div 未上传前display＝none-->
                                  <br>
                                  <span class="yingyezhizhao_span">旧版需上传：营业执照、税务登记证、组织机构代码证</span>
                                  <div class="yingyezhizhao_img clearfix old_bussiness" >
                                  
                                      <ul id="old_img">
                                          <li><a class="tax_img" id="old1"><img src="images/Tax_registration.jpg" width="150" alt=""/></a></li>
                                          <li><a class="organization_img" id="old2"><img src="images/Organization_code.jpg" width="150" alt=""/></a></li>
                                          <li><a class="Business_license_img" id="old3"><img src="images/Business_license.jpg" width="150" alt=""/></a></li>
                                      </ul> 
                                  </div>
                                  <!--上传按钮-->
                                  <div class="shangchuan_btn01" id="olds" style="width:88px;line-height:10px;position:absolute;left:0;top:224px"><a ></a></div>
                                  <div class="shangchuan_btn01" id="olds2" style="width:88px;line-height:10px;position:absolute;left:180px;top:224px"><a ></a></div>
                                  <div class="shangchuan_btn01" id="olds3" style="width:88px;line-height:10px;position:absolute;left:360px;top:224px"><a ></a></div>
                                  
                            
                                  </div>
                                  <!--选择旧版营业执照显示内容 结束-->
                                  </div>

                     </div>
                      </div>   
                  </div>
                  </div>
              </div>
              <!--营业执照 结束-->
                   
              <!--法人身份证上传 开始-->
              <div class="regsiter_renzheng_con">
                  <div class="regsiter_renzheng_left basicInformation_downLeft">法人身份证复印件：</div>
                  <div class="clearfix">
                  <div class="regsiter_renzheng_right clearfix identity" style="display:block;position:relative;">
                      <p>请上传《法人身份证复印件》正反面文件</p>
                      <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .png格式照片，大小不超过2M。<a class="identity_example">查看示例</a></p>
                      <!--上传法人身份证复印件后显示图片div 未上传前display＝none-->                      
                      
                     <div class="yingyezhizhao_img clearfix" style="display:block">
                          <ul>
                              <li><a class="identity_img_front" id="idcard1"><img src="images/identity_front.jpg" width="150" height="110" alt=""/></a></li>
                              <li><a class="identity_img_opposite" id="idcard2"><img src="images/identity_opposite.jpg" width="150" height="110" alt=""/></a></li>
                          </ul>
                      </div>
                      <!--上传按钮-->
                      <div class="shangchuan_btn01" id="zheng" style="width:88px;line-height:10px;position:absolute;left:0;top:165px"><a ></a></div>
                      <div class="shangchuan_btn01 basicInformation_downUpdate" id="fan" style="width:88px;line-height:10px;position:absolute;left:180px;top:165px"><a ></a></div>
                      
                  </div>
                  </div>
                 
              </div>
              <!--法人身份证上传 结束-->
              
              <!--法人授权委托书 开始-->
              <div class="regsiter_renzheng_con">
                  <div class="regsiter_renzheng_left basicInformation_downLeft">法人授权委托书：</div>
                  <div class="clearfix">
                      <div class="regsiter_renzheng_right clearfix attorney" style="display:block;position:relative;">
                          <p>请上传《法人授权委托书》文件</p>
                          <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .png格式照片，大小不超过2M。<a class="attorney_example" onclick="attorney()">查看示例</a></p>
                          <!--上传法人授权委托书后显示图片div 未上传前display＝none-->

                              <div class="yingyezhizhao_img clearfix" style="display:block">
                                  <ul>
                                      <li><a class="attorney_img" id="proxy_img"><img src="images/Power_of_attorney.jpg" width="150" height="110" alt=""/></a></li>
                                  </ul>
                              </div>
                              <!--上传按钮-->
                              <div class="shangchuan_btn01" id="wts" style="width:88px;line-height:10px;position:absolute;left:0;top:165px"><a></a></div>

                      </div>
                  </div>
              </div>
              <!--法人授权委托书 结束-->

              <!--提交按钮 开始-->
            <div class="regsiter_02_btn renzheng_btn"><a href="javascript:;" id="submit" onclick="submit(this);">提交</a></div>
            <div id="error2" style="padding: 0px 0px 0px 700px;float: left;top: 1115px;width:100px;display:block;position:absolute;color:red"></div>
            <!--提交按钮 结束-->

              </div>
              </div>
              <!--修改认证内容tab2 结束-->
            </div>
    	 </form>
    	</div>
    </div>
    <!--内容 结束-->

    <!--弹窗提交提示 开始-->
    <div class="dingdan4_3_tanchuang" style="display:none" id="succ">
        <div class="dingdan4_3_tanchuang_con" >
            <div class="dingdan4_3_tanchuang_top" id="tip">请上传文件</div>
            <div class="dingdan4_3_tanchuang_top2" id="tip2">
                <p class="renzheng_tanchuang_p" id="tip3">请上传文件</p>
                <p></p>
            </div>
            <div class="dingdan4_3_tanchuang_btn" id="button">
                <div class="dingdan4_3_btn01"><a href="javascript:;" id="retu">返回</a></div>
               
            </div>

        </div>
    </div>
    <!--弹窗提交提示 结束-->

    
    
    <!--弹出层 fancybox_license_example 示例 开始-->
    <div class="fancybox_license_example" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Business_license_new.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
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
    
    <!--弹出层 fancybox_license_img 图片 开始-->
    <div class="fancybox_license_img" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Business_license.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_license_img">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_license_img 图片 结束--> 

	<!--弹出层 fancybox_identity_example 示例 开始-->
    <div class="fancybox_identity_example" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/identity_card.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_identity_example">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_identity_example 示例 结束--> 
    
    <!--弹出层 fancybox_identity_front 正面 开始-->
    <div class="fancybox_identity_front" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/identity_front.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_identity_front">返回</a>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    </div>
    <!--弹出层 fancybox_identity_front 正面 结束--> 

	<!--弹出层 fancybox_identity_opposite 正面 开始-->
    <div class="fancybox_identity_opposite" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/identity_opposite.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_identity_opposite">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_identity_opposite 正面 结束--> 

	<!--弹出层 fancybox_attorney_example 示例 开始-->
    <div class="fancybox_attorney_example" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Power_of_attorney.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
            
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_attorney_example" onclick="back_attorney();">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_attorney_example 示例 结束-->
    
    <!--弹出层 fancybox_attorney_img 图片 开始-->
    <div class="fancybox_attorney_img" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Power_of_attorney.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_attorney_img">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_attorney_img 图片 结束-->
    
    
    <!--旧版营业执照弹出层内容 开始-->
	<!--弹出层 fancybox_Tax_img 示例 开始-->
    <div class="fancybox_tax_img" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Tax_registration.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_tax_img">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_tax_img 示例 结束-->
    <!--弹出层 fancybox_organization_img 示例 开始-->
    <div class="fancybox_organization_img" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Organization_code.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_organization_img">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_organization_img 示例 结束-->
    <!--弹出层 fancybox_Business_license_img 示例 开始-->
    <div class="fancybox_Business_license_img" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<img src="images/Business_license.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_Business_license_img">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_Business_license_img 示例 结束-->
    
    
    <!--旧版营业执照示例弹出层内容fancybox_oldBusiness_example 开始-->
    <div class="fancybox_oldBusiness_example" style="display:none"> 
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
                <div class="fancybox-editCon clearfix">
                	<p style="font-size:20px">税务登记证</p>
                	<img src="images/Tax_registration.jpg" width="880" alt=""/>
                    <p style="font-size:20px">组织机构代码证</p>
                	<img src="images/Organization_code.jpg" width="880" alt=""/>
                    <p style="font-size:20px">营业执照证</p>
                	<img src="images/Business_license.jpg" width="880" alt=""/>
                </div>
              </div></div></div>
             <a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" style="width:auto">
                        <a href="javascript:;" class="fancybox_okay fancybox_back_oldBusiness_example" onclick="back_oldbus();">返回</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--旧版营业执照示例弹出层内容fancybox_oldBusiness_example 结束-->

<script>

$(document).ready(function() {
	  /*$("#select2").select2({

      });*/
    
    
     $('#ind').click(function(){
 	    $('#select2').show();
 	    $('#ind').hide();
     });

     $('#select2').select2();
	
    
});


function selectTag(showContent,selfObj){
	// 操作标签 
	var tag = $('#basic_tags');
	var $Obj=$(selfObj.parentNode);
	if(showContent == 'tagContent1' ){    //旧
		$('#news').next('div').remove();
		$('#new_img').html('<img src="images/Business_license.jpg" width="150" alt=""/>');
		new_two();
	}else{ 
		if($('#olds').next('div').attr('id')!='olds2'){
		    $('#olds').next('div').remove();
		}
		if($('#olds2').next('div').attr('id')!='olds3'){
		    $('#olds2').next('div').remove();
		}
		$('#olds3').next('div').remove(); 
		$('#old_img').html('<li><a class="tax_img" id="old1"><img src="images/Tax_registration.jpg" width="150" alt=""/></a></li>'+
                '<li><a class="organization_img" id="old2"><img src="images/Organization_code.jpg" width="150" alt=""/></a></li>'+
                '<li><a class="Business_license_img" id="old3"><img src="images/Business_license.jpg" width="150" alt=""/></a></li>');                              //新
		old1_two();
		old2_two();
		old3_two();
    }
	//操作内容
	for(i=0; j=document.getElementById("tagContent"+i); i++){
		j.style.display = "none";
	}
	
	document.getElementById(showContent).style.display = "block";
	$Obj.siblings().removeClass('selectTag');
	$Obj.addClass('selectTag');
	
	
}

$('#select2').change('click',function(){
if($('#select2').val() == ''){
    $('#error').html("带*号为必填项");
    $('#error').show();
    $('#select2').css('border','1px solid red');
    $('#select2').on('click',function(){
    	$('#error').html("");
	    $('#error').hide();
	    $('#select2').css('border','1px solid #CCC');
	});
}
});
$('#select2').on('click',function(){
	$('#error').html("");
    $('#error').hide();
    $('#select2').css('border','1px solid #CCC');
});
$('#nature').blur('click',function(){
	if($('#nature').val() == ''){
	    $('#error2').html("带*号为必填项");
	    $('#error2').show();
	    $('#nature').css('border','1px solid red');
	    $('#nature').on('click',function(){
	    	$('#error2').html("");
		    $('#error2').hide();
		    $('#nature').css('border','1px solid #CCC');
		});
	}
	});
	$('#nature').on('click',function(){
		$('#error2').html("");
	    $('#error2').hide();
	    $('#nature').css('border','1px solid #CCC');
	});
$('#legal_person').blur('click',function(){
		if($('#legal_person').val() == ''){
		    $('#error3').html("带*号为必填项");
		    $('#error3').show();
		    $('#legal_person').css('border','1px solid red');
		    $('#legal_person').on('click',function(){
		    	$('#error3').html("");
			    $('#error3').hide();
			    $('#legal_person').css('border','1px solid #CCC');
			});
		}
		else if(!$('#legal_person').val().match(/^[\u4e00-\u9fa5]{2,4}$/i)){
			$('#error3').html("企业法人格式不正确");
		    $('#error3').show();
		    $('#legal_person').css('border','1px solid red');
		    $('#legal_person').on('click',function(){
		    	$('#error3').html("");
			    $('#error3').hide();
			    $('#legal_person').css('border','1px solid #CCC');
			});
	    }
		});
$('#legal_person').on('click',function(){
			$('#error3').html("");
		    $('#error3').hide();
		    $('#legal_person').css('border','1px solid #CCC');
		});
$('#idcard').blur('click',function(){
	var idcard=$("#idcard").val()
	var bo=/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?$/.test(idcard);
	var year = idcard. substr(6,4);
	var month = idcard. substr(10,2);
	var day = idcard. substr(12,2);
	if($('#idcard').val() == ''){
	    $('#error4').html("带*号为必填项");
	    $('#error4').show();
	    $('#idcard').css('border','1px solid red');
	    $('#idcard').on('click',function(){
	    	$('#error4').html("");
		    $('#error4').hide();
		    $('#idcard').css('border','1px solid #CCC');
		});
	}else if(bo==false||month>12||day>31){
		//$("#idcard").val('');
		$("#nian").val('');
		$("#yue").val('');
		$("#ri").val('');
		$('#error4').html("身份证错误");
	    $('#idcard').css('border','1px solid red');
	    $('#error4').show();
	    $('#idcard').on('click',function(){
	    	$('#error4').html("");
	    	$('#idcard').css('border','1px solid #CCC');
		    $('#error4').hide();
		});
	}
	});
$('#idcard').on('click',function(){
		$('#error4').html("");
	    $('#error4').hide();
	    $('#idcard').css('border','1px solid #CCC');
	});
$('#company_registration').blur('click',function(){
	if($('#company_registration').val() == ''){
	    $('#error5').html("带*号为必填项");
	    $('#error5').show();
	    $('#company_registration').css('border','1px solid red');
	    $('#company_registration').on('click',function(){
	    	$('#error5').html("");
		    $('#error5').hide();
		    $('#company_registration').css('border','1px solid #CCC');
		});
	}
	/*else if($('#company_registration').val().length!=14||isNaN($('#company_registration').val())){
		 $('#error5').html("工商注册号格式不正确");
		    $('#error5').show();
		    $('#company_registration').css('border','1px solid red');
		    $('#company_registration').on('click',function(){
		    	$('#error5').html("");
			    $('#error5').hide();
			    $('#company_registration').css('border','1px solid #CCC');
			});
    }*/
	});
$('#company_registration').on('click',function(){
		$('#error5').html("");
	    $('#error5').hide();
	    $('#company_registration').css('border','1px solid #CCC');
	});


function submit(o){

	var Industrial_Info = $('#select2').val();
	var nature = $('#nature').val();
	var legal_person = $('#legal_person').val();
	var idcard = $('#idcard').val();
	var company_registration = $('#company_registration').val();

		var idcard=$("#idcard").val()
		var bo=/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X)?$/.test(idcard);
		var year = idcard. substr(6,4);
		var month = idcard. substr(10,2);
		var day = idcard. substr(12,2);

	if($('#select2').val() == ''){
	    $('#error').html("带*号为必填项");
	    $('#error').show();
	    $('#select2').css('border','1px solid red');
	    $('#select2').on('click',function(){
	    	$('#error').html("");
		    $('#error').hide();
		    $('#select2').css('border','1px solid #CCC');
		});
    }else if($('#nature').val() == ''){
	    $('#error2').html("带*号为必填项");
	    $('#nature').css('border','1px solid red');
	    $('#error2').show();
	    $('#nature').on('click',function(){
	    	$('#error2').html("");
	    	$('#nature').css('border','1px solid #CCC');
		    $('#error2').hide();
		});
    }else if($('#legal_person').val() == ''){
	    $('#error3').html("带*号为必填项");
	    $('#legal_person').css('border','1px solid red');
	    $('#error3').show();
	    $('#legal_person').on('click',function(){
	    	$('#error3').html("");
	    	$('#legal_person').css('border','1px solid #CCC');
		    $('#error3').hide();
		});
    }else if(!$('#legal_person').val().match(/^[\u4e00-\u9fa5]{2,4}$/i)){
		$('#error3').html("企业法人格式不正确");
	    $('#error3').show();
	    $('#legal_person').css('border','1px solid red');
	    $('#legal_person').on('click',function(){
	    	$('#error3').html("");
		    $('#error3').hide();
		    $('#legal_person').css('border','1px solid #CCC');
		});
    }else if($('#idcard').val() == ''){
	    $('#error4').html("带*号为必填项");
	    $('#idcard').css('border','1px solid red');
	    $('#error4').show();
	    $('#idcard').on('click',function(){
	    	$('#error4').html("");
	    	$('#idcard').css('border','1px solid #CCC');
		    $('#error4').hide();
		});
    }else if($('#company_registration').val() == ''){
	    $('#error5').html("带*号为必填项");
	    $('#company_registration').css('border','1px solid red');
	    $('#error5').show();
	    $('#company_registration').on('click',function(){
	    	$('#error5').html("");
	    	$('#company_registration').css('border','1px solid #CCC');
		    $('#error5').hide();
		});
    }/*else if($('#company_registration').val().length!=14||isNaN($('#company_registration').val())){
		 $('#error5').html("工商注册号格式不正确");
		    $('#error5').show();
		    $('#company_registration').css('border','1px solid red');
		    $('#company_registration').on('click',function(){
		    	$('#error5').html("");
			    $('#error5').hide();
			    $('#company_registration').css('border','1px solid #CCC');
			});
    }*/else if(bo==false||month>12||day>31){

		$("#nian").val('');
		$("#yue").val('');
		$("#ri").val('');
		$('#error4').html("身份证错误");
	    $('#idcard').css('border','1px solid red');
	    $('#error4').show();
	    $('#idcard').on('click',function(){
	    	$('#error4').html("");
	    	$('#idcard').css('border','1px solid #CCC');
		    $('#error4').hide();
		});
		}else{
                     $.ajax({
                 	    url:"<?php echo site_url('customer/check_poto') ?>",
                 	    type:"post",
                 	    beforeSend:function(){
                	    	 $(o).html('提交中...');
                     	},
                     	success:function(data){
                     	    if(data == 1){
                      	       $('#tip3').html('请上传营业执照');
                      	       $('#succ').show();
                        	   $(o).html('提交');
                         	}else if(data == 2){
                         		$('#tip3').html('请上传第一张旧营业执照');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else if(data == 3){
                         		$('#tip3').html('请上传第二张旧营业执照');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else if(data == 4){
                         		$('#tip3').html('请上传第三张旧营业执照');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else if(data == 5){
                         		$('#tip3').html('请上传身份证正面照');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else if(data == 6){
                         		$('#tip3').html('请上传身份证反面照');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else if(data == 7){
                         		$('#tip3').html('请上传法人授权委托书');
                        	    $('#succ').show();
                        	    $(o).html('提交');
                            }else{
                            	$('#form').submit();
                                $(o).html('提交');
                            }
                        },
                     });


    }
	
}

function eg(){
	$('#dialog').show();
	$('#dialog2').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
}

$('#close').click(function(){
	$('#dialog').hide();
	$('#dialog2').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
});
function eg2(){
	$('#dialog2').show();
	$('#dialog').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
}

$('#close2').click(function(){
	$('#dialog').hide();
	$('#dialog2').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
});
function eg3(){
	$('#dialog3').show();
	$('#dialog').hide();
	$('#dialog2').hide();
	$('#dialog4').hide();
}

$('#close3').click(function(){
	$('#dialog').hide();
	$('#dialog2').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
});

$('#retu').click(function(){
	$('#succ').hide();
	$('#tip3').html('请上传文件');
});

function oeg(){
	$('#dialog4').show();
	$('#dialog3').hide();
	$('#dialog').hide();
	$('#dialog2').hide();
}

$('#close4').click(function(){
	$('#dialog').hide();
	$('#dialog2').hide();
	$('#dialog3').hide();
	$('#dialog4').hide();
});

   
</script>

<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script>
/* 
*	jQuery文件上传插件,封装UI,上传处理操作采用Baidu WebUploader;
*	@Author 黑爪爪;
*/
(function( $ ) {
	
    $.fn.extend({
		/*
		*	上传方法 opt为参数配置;
		*	serverCallBack回调函数 每个文件上传至服务端后,服务端返回参数,无论成功失败都会调用 参数为服务器返回信息;
		*/
        diyUpload:function( opt, serverCallBack ) {
 			if ( typeof opt != "object" ) {
				alert('参数错误!');
				return;	
			}
			
			var $fileInput = $(this);
			var $fileInputId = $fileInput.attr('id');
			
			//组装参数;
			if( opt.url ) {
				opt.server = opt.url; 
				delete opt.url;
			}
			
			if( opt.success ) {
				var successCallBack = opt.success;
				delete opt.success;
			}
			
			if( opt.error ) {
				var errorCallBack = opt.error;
				delete opt.error;
			}
			
			//迭代出默认配置
			$.each( getOption( '#'+$fileInputId ),function( key, value ){
					opt[ key ] = opt[ key ] || value; 
			});
			
			if ( opt.buttonText ) {
				opt['pick']['label'] = opt.buttonText;
				delete opt.buttonText;	
			}
			
			var webUploader = getUploader( opt );
			
			if ( !WebUploader.Uploader.support() ) {
				alert( ' 上传组件不支持您的浏览器！');
				return false;
       		}
			
			//绑定文件加入队列事件;
			webUploader.on('fileQueued', function( file ) {
				createBox( $fileInput, file ,webUploader);
			
			});
			
			//进度条事件
			webUploader.on('uploadProgress',function( file, percentage  ){
				var $fileBox = $('#fileBox_'+file.id);
				var $diyBar = $fileBox.find('.diyBar');	
				$diyBar.show();
				percentage = percentage*100;
				showDiyProgress( percentage.toFixed(2), $diyBar);
				
			});
			
			//全部上传结束后触发;
			webUploader.on('uploadFinished', function(){
				$fileInput.next('.parentFileBox').children('.diyButton').remove();
			});
			//绑定发送至服务端返回后触发事件;
			webUploader.on('uploadAccept', function( object ,data ){
				if ( serverCallBack ) serverCallBack( data );
			});
			
			//上传成功后触发事件;
			webUploader.on('uploadSuccess',function( file, response ){
				var $fileBox = $('#fileBox_'+file.id);
				var $diyBar = $fileBox.find('.diyBar');	
				$fileBox.removeClass('diyUploadHover');
				$diyBar.fadeOut( 1000 ,function(){
					$fileBox.children('.diySuccess').show();
				});
				if ( successCallBack ) {
					successCallBack( response );
				}	
			});
			
			//上传失败后触发事件;
			webUploader.on('uploadError',function( file, reason ){
				var $fileBox = $('#fileBox_'+file.id);
				var $diyBar = $fileBox.find('.diyBar');	
				showDiyProgress( 0, $diyBar , '上传失败!' );
				var err = '上传失败! 文件:'+file.name+' 错误码:'+reason;
				if ( errorCallBack ) {
					errorCallBack( err );
				}
			});
			
			//选择文件错误触发事件;
			webUploader.on('error', function( code ) {
				var text = '';
				switch( code ) {
					case  'F_DUPLICATE' : text = '该文件已经被选择了!' ;
					break;
					case  'Q_EXCEED_NUM_LIMIT' : text = '上传文件数量超过限制!' ;
					break;
					case  'F_EXCEED_SIZE' : text = '文件大小超过限制!';
					break;
					case  'Q_EXCEED_SIZE_LIMIT' : text = '所有文件总大小超过限制!';
					break;
					case 'Q_TYPE_DENIED' : text = '文件类型不正确或者是空文件!';
					break;
					default : text = '未知错误!';
 					break;	
				}
            	alert( text );
        	});
        }
    });
	
	//Web Uploader默认配置;
	function getOption(objId) {
		/*
		*	配置文件同webUploader一致,这里只给出默认配置.
		*	具体参照:http://fex.baidu.com/webuploader/doc/index.html
		*/
		return {
			//按钮容器;
			pick:{
				id:objId,
				label:"选择图片"
			},
			//类型限制;
			accept:{
				title:"Images",
				extensions:"gif,jpg,jpeg,bmp,png",
				mimeTypes:"image/*"
			},
			//配置生成缩略图的选项
			thumb:{
				width:170,
				height:150,
				// 图片质量，只有type为`image/jpeg`的时候才有效。
				quality:70,
				// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
				allowMagnify:false,
				// 是否允许裁剪。
				crop:true,
				// 为空的话则保留原有图片格式。
				// 否则强制转换成指定的类型。
				type:"image/jpeg"
			},
			//文件上传方式
			method:"POST",
			//服务器地址;
			server:"",
			//是否已二进制的流的方式发送文件，这样整个上传内容php://input都为文件内容
			sendAsBinary:false,
			// 开起分片上传。 thinkphp的上传类测试分片无效,图片丢失;
			chunked:true,
			// 分片大小
			chunkSize:512 * 1024,
			//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
			fileNumLimit:50,
			fileSizeLimit:5000 * 1024,
			fileSingleSizeLimit:500 * 1024
		};
	}
	
	//实例化Web Uploader
	function getUploader( opt ) {

		return new WebUploader.Uploader( opt );;
	}
	
	//操作进度条;
	function showDiyProgress( progress, $diyBar, text ) {
		
		if ( progress >= 100 ) {
			progress = progress + '%';
			text = text || '上传完成';
		} else {
			progress = progress + '%';
			text = text || progress;
		}
		
		var $diyProgress = $diyBar.find('.diyProgress');
		var $diyProgressText = $diyBar.find('.diyProgressText');
		$diyProgress.width( progress );
		$diyProgressText.text( text );
	
	}
	
	//取消事件;	
	function removeLi ( $li ,file_id ,webUploader) {
		webUploader.removeFile( file_id );
		if ( $li.siblings('li').length <= 0 ) {
			$li.parents('.parentFileBox').remove();
		} else {
			$li.remove();
		}
		
	}
	
	//创建文件操作div;	
	function createBox( $fileInput, file, webUploader ) {

		var file_id = file.id;
		var $parentFileBox = $fileInput.next('.parentFileBox');
		
		//添加父系容器;
		if ( $parentFileBox.length <= 0 ) {
			
			var div = '<div class="parentFileBox"> \
						<ul class="fileBoxUl"></ul>\
					</div>';
			$fileInput.after( div );
			$parentFileBox = $fileInput.next('.parentFileBox');
		
		}
		
		//创建按钮
		if ( $parentFileBox.find('.diyButton').length <= 0 ) {
			
			var div = '<div class="diyButton"> \
						<a class="diyStart" href="javascript:void(0)" style="background-color:#72C312;">开始上传</a> \
						<a class="diyCancelAll" href="javascript:void(0)" style="background-color:#72C312;">全部取消</a> \
					</div>';
			$parentFileBox.append( div );
			var $startButton = $parentFileBox.find('.diyStart');
			var $cancelButton = $parentFileBox.find('.diyCancelAll');
			
			//开始上传,暂停上传,重新上传事件;
			var uploadStart = function (){
				webUploader.upload();
				$startButton.text('暂停上传').one('click',function(){
						webUploader.stop();
						$(this).text('继续上传').one('click',function(){
								uploadStart();
						});
				});
			}
				
			//绑定开始上传按钮;
			$startButton.one('click',uploadStart);
			
			//绑定取消全部按钮;
			$cancelButton.bind('click',function(){
				var fileArr = webUploader.getFiles( 'queued' );
				$.each( fileArr ,function( i, v ){
					removeLi( $('#fileBox_'+v.id), v.id, webUploader );
				});
			});
		
		}
			
		//添加子容器;
		var li = '<li id="fileBox_'+file_id+'" class="diyUploadHover"> \
					<div class="viewThumb"></div> \
					<div class="diyCancel"></div> \
					<div class="diySuccess"></div> \
					<div class="diyFileName">'+file.name+'</div>\
					<div class="diyBar"> \
							<div class="diyProgress"></div> \
							<div class="diyProgressText">0%</div> \
					</div> \
				</li>';
				
		$parentFileBox.children('.fileBoxUl').html( li );
		
		//父容器宽度;
		var $width = 180;
		var $maxWidth = $fileInput.parent().width();
		$width = $maxWidth > $width ? $width : $maxWidth;
		$parentFileBox.width( $width );
		
		var $fileBox = $parentFileBox.find('#fileBox_'+file_id);

		//绑定取消事件;
		var $diyCancel = $fileBox.children('.diyCancel').one('click',function(){
			removeLi( $(this).parent('li'), file_id, webUploader );	
		});
		
		if ( file.type.split("/")[0] != 'image' ) {
			var liClassName = getFileTypeClassName( file.name.split(".").pop() );
			$fileBox.addClass(liClassName);
			return;	
		}
		
		//生成预览缩略图;
		webUploader.makeThumb( file, function( error, dataSrc ) {
			if ( !error ) {	
				$fileBox.find('.viewThumb').append('<img src="'+dataSrc+'" >');
			}
		});	
	}
	
	//获取文件类型;
	function getFileTypeClassName ( type ) {
		var fileType = {};
		var suffix = '_diy_bg';
		fileType['pdf'] = 'pdf';
		fileType['zip'] = 'zip';
		fileType['rar'] = 'rar';
		fileType['csv'] = 'csv';
		fileType['doc'] = 'doc';
		fileType['xls'] = 'xls';
		fileType['xlsx'] = 'xls';
		fileType['txt'] = 'txt';
		fileType = fileType[type] || 'txt';
		return 	fileType+suffix;
	}
	
})( jQuery );

</script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
<script type="text/javascript"> $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
</script>
<script type="text/javascript">
<!--
$('#news').diyUpload({
	url:'<?php echo site_url('customer/upload_charter');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#news").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#new_img').html('<img src="'+datasrc+'" width="150" height="110"  alt=""/>');
	    $('#news').next('div').remove();	  
	    new_two();
		$('#news').show();
	},
	error:function( err ) {
		console.info( err );
		new_two();	
	},
	buttonText : '上传文件',
	thumb:{
		width:170,
		height:150,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"},
});

$('#olds').diyUpload({

	url:'<?php echo site_url('customer/upload_old');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#olds").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#old1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#olds').next('div').remove();	  
	    old2_two();
	    $('#olds').show();
	},
	error:function( err ) {
		console.info( err );
		old2_two();	
	},
	buttonText : '上传文件',
	thumb:{
		width:170,
		height:150,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"}
});
$('#olds2').diyUpload({

	url:'<?php echo site_url('customer/upload_old2');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#olds2").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#old2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#olds2').next('div').remove();	  
	    old2_two();
	    $('#olds2').show();
	},
	error:function( err ) {
		console.info( err );
		old2_two();	
	},
	buttonText : '上传文件',
	thumb:{
		width:170,
		height:150,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"}
});
$('#olds3').diyUpload({

	url:'<?php echo site_url('customer/upload_old3');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#olds3").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#old3').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#olds3').next('div').remove();	  
	    old2_two();
	    $('#olds3').show();
	},
	error:function( err ) {
		console.info( err );
		old2_two();	
	},
	buttonText : '上传文件',
	thumb:{
		width:170,
		height:150,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"}
});
$('#zheng').diyUpload({

	url:'<?php echo site_url('customer/upload_idcard');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#zheng").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#idcard1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#zheng').next('div').remove();	  
	    idcard1_two();
	    $('#zheng').show();
	},
	error:function( err ) {
		console.info( err );
		idcard1_two();	
	},
	buttonText : '身份证正面',
	thumb:{
		width:170,
		height:150,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {
		extensions :"image,jpeg,jpg,bmp,png"
			}
});
$('#fan').diyUpload({

	url:'<?php echo site_url('customer/upload_idcard_back');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#fan").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#idcard2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#fan').next('div').remove();	  
	    idcard2_two();
	    $('#fan').show();
	},
	error:function( err ) {
		console.info( err );
		idcard2_two();	
	},
	buttonText : '身份证反面',
	thumb:{
		width:100,
		height:100,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},
	addButton :{

		},
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"}
});
$('#wts').diyUpload({

	url:'<?php echo site_url('customer/upload_wts');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#wts").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#proxy_img').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#wts').next('div').remove();	  
	    proxy_two();
		$('wts').show();
	},
	error:function( err ) {
		console.info( err );
		proxy_two();	
	},
	buttonText : '上传文件',
	thumb:{
		width:100,
		height:100,
		// 图片质量，只有type为`image/jpeg`的时候才有效。
		quality:70,
		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
		allowMagnify:false,
		// 是否允许裁剪。
		crop:true,
		// 为空的话则保留原有图片格式。
		// 否则强制转换成指定的类型。
		type:"image/jpeg"
	},

	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	fileSizeLimit:2097152,
	fileSingleSizeLimit:2097152,
	accept: {extensions :"image,jpeg,jpg,bmp,png"}
});


function new_two(){
    $('#news').diyUpload({
    	url:'<?php echo site_url('customer/upload_charter');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#news").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#new_img').html('<img src="'+datasrc+'" width="150" height="110"  alt=""/>');
    	    $('#news').next('div').remove();	  
    	    new_two();
    		$('#news').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		new_two();	
    	},
    	buttonText : '上传文件',
    	thumb:{
    		width:170,
    		height:150,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"},
    });
}

function old1_two(){
    $('#olds').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_old');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#olds").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#old1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#olds').next('div').remove();	  
    	    old1_two();
    	    $('#olds').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		old1_two();	
    	},
    	buttonText : '上传文件',
    	thumb:{
    		width:170,
    		height:150,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"}
    });
}

function old2_two(){
    $('#olds2').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_old2');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#olds2").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#old2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#olds2').next('div').remove();	  
    	    old2_two();
    	    $('#olds2').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		old2_two();	
    	},
    	buttonText : '上传文件',
    	thumb:{
    		width:170,
    		height:150,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"}
    });
}

function old3_two(){
    $('#olds3').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_old3');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#olds3").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#old3').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#olds3').next('div').remove();	  
    	    old3_two();
    	    $('#olds3').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		old3_two();	
    	},
    	buttonText : '上传文件',
    	thumb:{
    		width:170,
    		height:150,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"}
    });
}

function idcard1_two(){
    $('#zheng').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_idcard');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#zheng").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#idcard1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#zheng').next('div').remove();	  
    	    idcard1_two();
    	    $('#zheng').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		idcard1_two();	
    	},
    	buttonText : '身份证正面',
    	thumb:{
    		width:170,
    		height:150,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {
    		extensions :"image,jpeg,jpg,bmp,png"
    			}
    });
}

function idcard2_two(){
    $('#fan').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_idcard_back');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#fan").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#idcard2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#fan').next('div').remove();	  
    	    idcard2_two();
    	    $('#fan').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		idcard2_two();	
    	},
    	buttonText : '身份证反面',
    	thumb:{
    		width:100,
    		height:100,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    	addButton :{
    
    		},
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"}
    });
}

function proxy_two(){
    $('#wts').diyUpload({
    
    	url:'<?php echo site_url('customer/upload_wts');?>',
    	success:function( data ) {
    		console.info( data );
    		var datasrc = $("#wts").next('div').children('ul').children('li').children('div').children('img').attr('src');
    		$('#proxy_img').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
    		$('#wts').next('div').remove();	  
    	    proxy_two();
    		$('wts').show();
    	},
    	error:function( err ) {
    		console.info( err );
    		proxy_two();	
    	},
    	buttonText : '上传文件',
    	thumb:{
    		width:100,
    		height:100,
    		// 图片质量，只有type为`image/jpeg`的时候才有效。
    		quality:70,
    		// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
    		allowMagnify:false,
    		// 是否允许裁剪。
    		crop:true,
    		// 为空的话则保留原有图片格式。
    		// 否则强制转换成指定的类型。
    		type:"image/jpeg"
    	},
    
    	chunked:true,
    	// 分片大小
    	chunkSize:512 * 1024,
    	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
    	fileNumLimit:1,
    	fileSizeLimit:2097152,
    	fileSingleSizeLimit:2097152,
    	accept: {extensions :"image,jpeg,jpg,bmp,png"}
    });
}

//-->
</script>
<style>
<!--
.parentFileBox{top:20px;display:block;float:left;margin-bottom:40px;}
.webuploader-pick{ background:#72C312;}
.webuploader-container div{width:86px;}
-->
</style>

<script>

	//点击企业营业执照Bussiness_license示例，弹出层仅编辑标题内容
	$('.Bussiness_license_example').click(function(){
		$('.fancybox_license_example').show();
	});
	//点击取消fancybox_back_license按钮，弹出层内容消失
	$('.fancybox_back_license_example').click(function(){
		$('.fancybox_license_example').hide();
	});
	
	
	//点击法人身份证dentity示例，弹出层仅编辑标题内容
	$('.identity .identity_example').click(function(){
		$('.fancybox_identity_example').show();
	});
	//点击取消fancybox_back_identity按钮，弹出层内容消失
	$('.fancybox_back_identity_example').click(function(){
		$('.fancybox_identity_example').hide();
	});

	function attorney(){
		$('.fancybox_attorney_example').show();
	}

	function back_attorney(){
		$('.fancybox_attorney_example').hide();
	}

	function oldbusiness(){
		$('.fancybox_oldBusiness_example').show();
	}

	function back_oldbus(){
		$('.fancybox_oldBusiness_example').hide();
	}
	//});
</script>
