<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/style_v2.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>

<style>
.webuploader-container { position:static;left: 0; top: 0; }
.webuploader-pick { position: relative; display: inline-block; cursor: pointer; background: #72c312; padding: 0px 0px; color: #fff; text-align: center; border-radius: 3px; overflow: hidden; }
.webuploader-pick-hover { background: #72c312; }
.webuploader-pick-disable { opacity: 0.6; pointer-events: none; }
.diyButton{ width:180px!important;}
.webuploader-container div{ width:126px !important; height:34px !important; line-height:34px;/*position:absolute; display:block;*/}
.result_null{ width:910px; margin:0px auto;}
</style>
</head>
<body>
 <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
<!--     		<li><a href="">首页</a></li> -->
<!--     		<li><a href="">商品管理</a></li> -->
<!--     		<li><a href="">订单管理</a></li> -->
<!--     		<li><a href="">客户管理</a></li> -->
<!--     		<li ><a href="">评价管理</a></li> -->
<!--     		<li class="tCurrent"><a href="">店铺管理</a></li> -->
    		<li ><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                	<li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <!--<li><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>" >账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>-->
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale_code') ?>" >实体消费二维码</a></li>
                </ul>
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">会员背书</div>
            <form class="demoform" action="<?php echo site_url('corporate/resource/add_apply') ?>" method="post" name="form" id="form1">
            <input type="hidden" name="status" value="<?php echo $status;?>"/>
            <input type="hidden" name="id" value="<?php echo $status==2?$detail['id']:'';?>">
            <input type="hidden" name="logo_" value="<?php echo $status==2?$detail['logo']:"";?>">
            <input type="hidden" name="certificate_" value="<?php echo $status==2?$detail['certificate']:"";?>">
            <input type="hidden" name="ce_" value="<?php echo $status==2?$detail['recommend_img']:"";?>">
            <div class="dianpu_01_con01 clearfix" <?php if($status==1){echo "style=display:none";}else{echo "style=display:block";} ?>  id="recite_add">
               <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>推荐单位名称 :</li>
                        <li>推荐单位图标 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    	<li><input class="dianpu_01_input" type="text" value="<?php echo $status==2?$detail['recommend_company']:"";?>" name="name" placeholder="例子：陕西晋商商会"><span id="name_" class="recite_tip"></span></li>
                        <li id="img" ><img id="logo_img" src="<?php echo $status==2?IMAGE_URL.$detail['logo']:"";?>" width="200" height="250" alt=""/></li>
                         <input type="hidden" name="logo" value="">
                    </ul>
                    <p  class="dianpu_01_p01">图片大小不能超过200KB,尺寸为 250x250，图片格式支持 .jpeg / .jpg / .png</p><span id='logo_' class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                <div id="logo" style=" position:relative;"></div>
                </div>
              </div>
              <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l">单位介绍：</div>
                 <div class="dianpu_zhong_r"><textarea  placeholder="(必填，不少于100字，不多于500字)" name="recommend_company"  class="procureme"><?php echo $status==2?$detail['company_brief']:"";?></textarea><br><span id="company_" class="recite_tip"></span></div>
              </div>
                <!---->
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>背书人图片 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <li id="img" ><img id='certificate_img' src="<?php echo $status==2?IMAGE_URL.$detail['certificate']:"";?>" width="250" height="320" alt=""/></li>
                        <input type="hidden" name="certificate" value="">
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过250KB,尺寸为 250x320，图片格式支持 .jpeg / .jpg / .png</p><span id='certificate_' class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                    <div id="certificate" style=" position:relative;"></div>
                </div>
                </div>
                
                
                <!---->
                
                <!--<div class="dianpu_left">
                	<ul>
                        <li>推荐语01 :</li>
                        <li>推荐语02 :</li>
                        <li>推荐语03 :</li> 
                    </ul>
                </div>-->
                <!--<div class="dianpu_01_right dropdown basicInformation_right">
                	<ul>
                        <li class='recommend'><input   class="dianpu_01_input" type="text" name="recommend_one" value=""  onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：21城公司是我们的会员单位"><span id='one' class="recite_tip"></span></li>
                        <li class='recommend'><input   class="dianpu_01_input" type="text" name="recommend_tow" value=""  onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：21城公司是我们的会员单位"><span id='tow' class="recite_tip"></span></li>
                        <li class='recommend'><input   class="dianpu_01_input" type="text" name="recommend_three" value="" onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：21城公司是我们的会员单位"><span id='three' class="recite_tip"></span></li>
                    </ul>
                    <div>
                    	<!--进入会员背书时，只有提交和重置的按钮-->
                    	<!--<a class="dianpu_recite_btn">新建</a>-->
                        <!--<a onclick=refresh(); class="dianpu_recite_btn_grey">重置</a>
                        <a onclick=sub(); class="dianpu_recite_btn">提交</a>
                        <!--<a class="dianpu_recite_btn_grey">隐藏</a>-->
                    <!--</div>
                 
                </div>-->
              <div class="dianpu_wei">
                  <div class="dianpu_wei_1">
                   <span>背书人姓名:</span>
                  <input   class="dianpu_02_input" type="text" name="recommend_name"  value="<?php echo $status==2?$detail['recommend_name']:"";?>"  onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：张三">
                  </div><span id="recommend_name" class="recite_tip"></span>
                  <span id="honor">
                  <?php if(!empty($honor)):?>
                  <?php foreach ($honor as $k=>$v):?>
                  <div class="dianpu_wei_1">
                   <span>头衔0<?php echo $k+1;?>:</span>
                   <input   class="dianpu_02_input" type="text" name="recommend_honor[]"  value="<?php echo $v;?>"  onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：全球秦商会会长">   
                   <!--  <small onclick=del_honor(this);>删除头衔</small> -->
                  </div>
                  <?php endforeach;?>
                  <?php else :?>
                  <div class="dianpu_wei_1">
                   <span>头衔01:</span>
                   <input   class="dianpu_02_input" type="text" name="recommend_honor[]"   onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：全球秦商会会长">   
                   <!--  <small onclick=del_honor(this);>删除头衔</small> -->
                  </div>
                  <?php endif;?>
                  </span>
                  <div class="dianpu_wei_2">
                    <samp class="dianpu_wei_let"><a href="javascript:void(0);" onclick="add_honor(this)">点击添加头衔</a></samp><samp class="dianpu_wei_rig" hidden>最多添加5个头衔</samp>
                  </div>
                  <span id="honor_" class="recite_tip"></span>
              </div>
                 
                 <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l">个人介绍：</div>
                 <div class="dianpu_zhong_r"><textarea placeholder="(必填，不少于100字，不多于500字)" name="personal" class="procureme"><?php echo $status==2?$detail['recommend_content']:"";?></textarea><span id="personal" class="recite_tip"></span></div>
              </div>
                
              <div class="dianpu_wei">
              <span id="language">
              <?php if(!empty($recommend_language)):?>
              <?php foreach ($recommend_language as $k=>$v):?>
                  <div class="dianpu_wei_1">
                   <span>推荐语0<?php echo $k+1;?>:</span>
                  <input   class="dianpu_02_input" type="text" name="recommend_language[]"  value="<?php echo $v;?>" onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：21城公司是我们的会员单位">
                  </div>
              <?php endforeach;?>
              <?php else :?>  
                  <div class="dianpu_wei_1">
                  <span>推荐语01:</span>
                  <input   class="dianpu_02_input" type="text" name="recommend_language[]"   onkeyup="value=value.replace(/[[^;]/g,'')" placeholder="例子：21城公司是我们的会员单位">
                  </div> 
              <?php endif;?> 
              </span>
                  <div class="dianpu_wei_2">
                    <samp class="dianpu_wei_let"><a href="javascript:void(0);" onclick="add_recommend_language(this)">点击添加推荐语01</a></samp><samp class="dianpu_wei_rig" hidden>最多添加5个推荐语</samp>
                  </div>
                  <span id="language_" class="recite_tip"></span>
               </div>
                
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>推荐说明书拍照 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <li id="img" ><img id='ce_img' src="<?php echo $status==2?IMAGE_URL.$detail['recommend_img']:"";?>" width="250" height="320" alt=""/></li>
                        <input type="hidden" name="ce" value="">
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过250KB,尺寸为 250x320，图片格式支持 .jpeg / .jpg / .png</p><span id='ce_' class="recite_tip"></span>
                    <span id="ce_" class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                    <div id="ce" style=" position:relative;"></div>
                </div>
                </div>
                 <div>
                     <div class="dianpu_di"> 
                        <a onclick=refresh(); class="dianpu_recite_btn_grey">取消</a> 
                        <a onclick=sub(); class="dianpu_recite_btn">提交</a>
<!--                     	<a class="dianpu_recite_btn">预览</a> -->
                    </div>
              </div> 
              </div>
              </form>
              
              <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con" id="recite_list" <?php if($status==1){echo "style=display:block";}else{echo "style=display:none";} ?>>
              <div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px"><a  id="type_1000" href="<?php echo site_url('corporate/resource/resource_list');?>">全部(<?php echo $total?>)</a></li>
							<li><a id="type_0" href="<?php echo site_url('corporate/resource/resource_list?status=0');?>">审核中(<?php echo $audit;?>)</a></li>
							<li><a id="type_1" href="<?php echo site_url('corporate/resource/resource_list?status=1');?>">已审核(<?php echo $pass;?>)</a></li>
							<li style="width:137px;"><a id="type_2" href="<?php echo site_url('corporate/resource/resource_list?status=2');?>">审核不通过(<?php echo $fail;?>)</a></li>
						</ul>
					</div>

				</div>
			</div>
            
            
             <div class="select1">
            <ul>
					<li><a href="javascript:add_show();">添加</a></li>
					<li style="margin-right: 0;"><a href="javascript:delects();">删除</a></li>
				</ul>
                </div>
                <!--内容01 开始-->
              <div class="cmRight_tittle"  style="margin:50px 0 30px 0; display:none">提交纪录</div>
              <table width="910" height="34" border="0" cellpadding="0" cellspacing="0" class="recite_tab">
                  <tr class="tr1" >
                      <th width="446px"><input type="checkbox"
							style="margin-right:8px; margin-left: -311px"
							onclick="selectAll(this)">背书单位名称</th>
                      <th width="130px">上传日期</th>
                      <th width="130px">审核状态</th>
                      <th width="200px">操作</th>
                      <!--<th width="200px">审核意见</th>
                      <th width="80px">详情</th>-->
                  </tr>
              </table>
              <?php if(!empty($log)){ ?>
              <?php foreach ($log as $k => $v):?>	
              <table width="910" height="50" border="0" cellpadding="0" cellspacing="0" class="recite_tab2">
                  <tr>
                      <th width="446px" style=" padding:10px 0;"><?php //echo $v['recommend_company'];?>
                      <input type="checkbox"style=" margin-left: 15px; float:left; margin-top:30px;" name='id[]' value="<?php echo $v['id'];?>" onclick="select(this)">
                      <div class="tImg"><img alt=""src="<?php echo $v['logo']?IMAGE_URL.$v['logo']:"images/m_logo.jpg";?>"> </div><p style="width: 310px;word-wrap: break-word; word-break: normal; text-align:left; float:left;"><?php echo $v['recommend_company'];?></p>
                     </th>
                      </th>

         <th width="130px"><?php echo substr($v['updated_at'],0,11);?></th>
                      <th width="130px" class="recite_state">
                      <span onclick="operate(this,<?php echo $v['approve_status'];?>,<?php echo $v['id']?>)">
                      <?php switch($v['approve_status']){
                          case 0:
                              echo "取消审核";
                              break;
                          case 1:
                              echo "上架";
                              break;
                          case 2:
                              echo "申请审核";
                              break;
                          case 3:
                              echo "下架";
                              break;
                          case 4:
                              echo "申请审核";
                              break;
                      }?>
                      </span>
                      <br/>
                      <span>
                      <?php switch($v['approve_status']){
                          case 0:
                              echo "状态：审核中";
                              break;
                          case 1:
                              echo "状态：审核通过";
                              break;
                          case 2:
                              echo "状态：审核不通过";
                              break;
                          case 3:
                              echo "状态：已上架";
                              break;
                          case 4:
                              echo "状态：下架";
                              break;
                      }?>
                      </span>
                      </th>
                      <!--<th width="150px"><?php //echo $v['approve_date'];?></th>
                      <th width="200px"><?php //echo $v['proposal'];?></th>
                      <th width="200px">
                         <a href="<?php //echo site_url('corporate/resource/detail').'/'.$v['id'];?>" style="color:#fca543; text-decoration:underline">详情</a> 
                      </th> -->
                      
                      <th width="200px">
                      <a href="
                      <?php echo site_url('corporate/resource/edit').'?id='.$v['id']; ?>"style="color: #fca543; text-decoration: underline;margin:0 15px;">编辑</a>
					  <a href="javascript:delects(<?php echo $v['id']?>);" style="color: #aeaeae; text-decoration: underline;margin:0 15px;">删除</a>
				      <a href="<?php echo site_url('corporate/resource/preview').'/'.$v['id'];?>"target="_blank"style="color: #fca543; text-decoration: underline;margin:0 15px;">预览</a></th>
                  </tr>
              </table>
              <?php endforeach;?>
              <div class="showpage">
              <?php echo $page;?>
              </div>
              <?php }else{;?>
              <!--无结果时候显示-->
              <div class="result_null">暂无内容</div>
              <?php };?>
            </div>
           
			
              </div>
              </div>
</body>

<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" style="display:none" id="danchuang">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

<script type="text/javascript">
/*
* diy上传插件
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/

$('#certificate').diyUpload({
	url:'<?php echo site_url('corporate/resource/file_upload/certificate') ?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	//单个图片大小(单位字节)
	fileSingleSizeLimit:256000,
	success:function( data ) {
		console.info( data );
		if(data){
		$certificate = $("#certificate").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#certificate_img').attr('src',$certificate);
		$('input[name=certificate]').val($certificate);
		$('#certificate').next('div').remove();
		}
	},
	error:function( err ) {
		console.info( err );	
	}
});

$('#logo').diyUpload({
	url:'<?php echo site_url('corporate/resource/file_upload/logo') ?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	//单个图片大小(单位字节)
	fileSingleSizeLimit:204800,
	success:function( data ) {
		console.info( data );
		if(data){
		$logo = $("#logo").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#logo_img').attr('src',$logo);
		$('input[name=logo]').val($logo);
		$('#logo').next('div').remove();
		}
	},
	error:function( err ) {
		console.info( err );	
	}
});


$('#ce').diyUpload({
	url:'<?php echo site_url('corporate/resource/file_upload/ce') ?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	//单个图片大小(单位字节)
	fileSingleSizeLimit:256000,
	success:function( data ) {
		console.info( data );
		if(data){
		$logo = $("#ce").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#ce_img').attr('src',$logo);
		$('input[name=ce]').val($logo);
		$('#ce').next('div').remove();
		}
	},
	error:function( err ) {
		console.info( err );	
	}
});
</script>

<script type="text/javascript">
$(function(){
	<?php if(isset($type)):?>
	$("#type_"+<?php echo $type==""?1000:$type;?>).addClass('xcurrent');
	<?php endif;?>
});
//提交
function sub(){
	$(".recite_tip").text("");
	ok1 = true;ok2 = true;ok3 = true;ok4 = true;ok5 = true;ok6 = false;ok7 = true;ok8=false;ok9=true;
	$name = $('input[name=name]').val();
	$logo = $('input[name=logo]').val();
	$certificate = $('input[name=certificate]').val();
	$ce = $('input[name=ce]').val();
	$logo_ = $('input[name=logo_]').val();
	$certificate_ = $('input[name=certificate_]').val();
	$ce_ = $('input[name=ce_]').val();
    $recommend_company = $("textarea[name=recommend_company]").val();
    $recommend_name = $('input[name=recommend_name]').val();
    $personal = $('textarea[name=personal]').val();
//     $honor = $("input[name='recommend_honor[]']").eq(0).val();
//     $language = $("input[name='recommend_language[]']").eq(0).val();
    

    //验证单位
	if($name==''){
		ok1 = false;
	    $('#name_').text('请填写单位名称。');
	}
    //验证单位图片
	if($logo!='' || $logo_!=''){}else{
		ok2 = false;
		$('#logo_').text('请上传单位图片。');
		}
    //验证单位证书
	if($certificate!='' || $certificate_!=''){}else{
			ok3 = false;
			$('#certificate_').text('请上传单位证明书。');
			}
	//验证单位介绍
	if($recommend_company==''){
		ok4 = false;
		$('#company_').text('请填写单位介绍。');
	}else if($recommend_company.length<100){
		ok4 = false;
		$('#company_').text('单位介绍不能少于100字。');
	}else if($recommend_company.length>500){
		ok4 = false;
		$('#company_').text('单位介绍不能多于500字。');
	}
	//验证背书人姓名
	if($recommend_name==''){
		ok5 = false;
		$('#recommend_name').text('请填写背书人姓名');
		}

	//验证头衔
	$("input[name='recommend_honor[]']").each(function(){
		if($(this).val()){
		    ok6=true;
		    return false;
			}
		});
	if(ok6){}else{
		$('#honor_').text('至少填写一个头衔');
		}
	
    //验证个人介绍
	if($personal==''){
		ok7 = false;
		$('#personal').text('请填写个人介绍。');
	}else if($personal.length<100){
		ok7 = false;
		$('#personal').text('个人介绍不能少于100字。');
	}else if($personal.length>500){
		ok7 = false;
		$('#personal').text('个人介绍不能多于500字。');
	}
	//验证推荐语
	$("input[name='recommend_language[]']").each(function(){
		if($(this).val()){
		    ok8=true;
		    return false;
			}
		});
	if(ok8){}else{
		$('#language_').text('至少填写一个推荐语。');
		}

	//验证推荐说明书
	if($ce!='' || $ce_!=''){}else{
		ok9 = false;
	    $('#ce_').text('请上传推荐说明书。');
	    }


    if(ok1 && ok2 && ok3 && ok4 && ok5 && ok6 && ok7 && ok8 && ok9){
        $('#form1').submit();
        }

}

    //重置
    function refresh(){
    	window.location.href="<?php echo site_url('corporate/resource/resource_list');?>"
    }
    
    //显示添加，隐藏列表
    function add_show(){
    	$("#recite_add").show();
    	$("#recite_list").hide();
    }

    //添加头衔
    function add_honor(obj){
    	var honor_total = $("input[name='recommend_honor[]']").length;
    	if(honor_total<5){
    		var html = '<div class="dianpu_wei_1"><span>头衔0'+(honor_total+1*1)+':</span><input   class="dianpu_02_input" type="text" name="recommend_honor[]"   onkeyup="value=value.replace(/[[^;]/g,"")" placeholder="例子：全球秦商会会长"><small onclick="del_honor()">删除头衔</small></div>';
    	    $("#honor").append(html);
    		}else{
    			$(obj).parent().next().show();
        		}
    }
    
    //删除头衔
	function del_honor(){
		$("input[name='recommend_honor[]']:last").parent().remove();
		}

	//添加推荐语
	function add_recommend_language(obj){
		var language_total = $("input[name='recommend_language[]']").length;
		if(language_total<5){
    		var html = '<div class="dianpu_wei_1"><span>推荐语0'+(language_total+1*1)+':</span><input   class="dianpu_02_input" type="text" name="recommend_language[]"  onkeyup="value=value.replace(/[[^;]/g,"")" placeholder="例子：21城公司是我们的会员单位"><small onclick="del_recommend_language()">删除推荐语</small></div>';
    	    $("#language").append(html);
    		}else{
    		    $(obj).parent().next().show();
        		}
		}
	//删除推荐语
	function del_recommend_language(){
		$("input[name='recommend_language[]']:last").parent().remove();
		}

	//操作审核状态
	function operate(obj,approve_status,resource_id){
		$.ajax({  
			url:'<?php echo site_url('corporate/resource/ajax_operate');?>',
			data:{
				approve_status:approve_status,
				resource_id:resource_id
				},  
			type:'post',    
			dataType:'json',  
			success:function(data) {  

			    if(data['status'] == 1){
			    	switch (approve_status){
					case 0:
						$(obj).attr('onclick','operate(this,4,'+resource_id+')').text('申请审核');
						$(obj).next().next().text('状态：下架');
						break;
					case 1:
						$(obj).attr('onclick','operate(this,0,'+resource_id+')').text('下架');
						$(obj).next().next().text('状态：上架');
						break;
					case 2:
						$(obj).attr('onclick','operate(this,0,'+resource_id+')').text('取消审核');
						$(obj).next().next().text('状态：审核中');
						break;
					case 3:
						$(obj).attr('onclick','operate(this,2,'+resource_id+')').text('申请审核');
						$(obj).next().next().text('状态：下架');
						break;
					case 4:
						$(obj).attr('onclick','operate(this,0,'+resource_id+')').text('取消审核');
						$(obj).next().next().text('状态：审核中');
						break;
					}
				 }else if(data['status'] == 2){
					 alert('操作失败');
					 location.reload();
					 }else if(data['status'] == 3){
						 alert('请登陆');
						 location.reload();
						 }
			},  
			error : function() {  

			}  
			});
	}

	//多选
	function selectAll(obj)
	{
		var flag = $(obj).is(':checked');
		$("input[name='id[]']").each(function () {
			 $(this).prop("checked",flag);
	      });
	}

	//单选
	function select(obj){
		var flag = $(obj).is(':checked');
		$(obj).prop("checked",flag);
		}

	//删除前的确认
	function delects($id){
		if($id){}else{
			$id ="";
		}
		$("#danchuang").show();
		$('#prompt').text('确定要把该商品删除吗？');
		$("#sure").attr('href','javascript:_delects('+$id+')');

		}
	<?php if(isset($type)):?>
	//执行删除
	function _delects ($id){
		hiding();
		var id = new Array();
		if($id){
			id[0] = $id;
		}else{
	    	var i = 0;
	    	$("input[name='id[]']").each(function () {
	    	    	if($(this).is(":checked"))
	    			{
	    	    		 id[i++] = $(this).val();
	    			}
	        });
			}
		if(id.length>0){
		var type = "<?php echo $type;?>";//当前类型，例如查看未通过的
		var per_page  = "<?php echo $per_page;?>";
		$.post("<?php echo site_url('corporate/resource/delects');?>",{id:id,type:type,per_page:per_page},function(data){
			data = $.parseJSON(data);
		    if(data['status']==1){
 		    	location.href="<?php echo site_url('corporate/resource/resource_list?/&per_page=');?>"+data;
			    }else if(data['status']==2){
				    alert('操作失败');
				    location.reload();
				    }else if(data['status']==3){
					    alert('请登录');
					    location.reload();
					    }
		})
		}else{
		    alert('请选择要删除的背书');
		    return;
			}

		}
	<?php endif;?>

	//隐藏提示框
	function hiding(){
		$("#danchuang").hide();
		$('#prompt').text("");
		$("#sure").attr('href','javascript:void(0)');
		}




</script>
</html>
