<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<style>
.need-text5 {
    width: 262px;
    float: left;
    border: 1px solid #C8C8C8;
    outline: none;
    -webkit-appearance: none;
    border-radius: 0;
    background: #fff;
    background: url(images/needs_right_icon.png) no-repeat scroll right center transparent;
    text-indent: 0.5em;
	margin-right:20px;
	color:#555555;
}
.dianpu_01_right ul li{ line-height:35px; overflow:hidden}
.condition{ margin-top:15px;}
.tips-box-r{ margin-bottom:10px;}
.dianpu_zhong{ margin-bottom:15px; margin-top:0px; line-height:35px;}
.dianpu_left ul li{ line-height:35px;}
.procureme{ width:755px;}
.dianpu_01_con01{ margin-left:30px;}


.webuploader-container { position:static;left: 0; top: 0; }
.webuploader-pick { position: relative; display: inline-block; cursor: pointer; background: #fe4101; padding: 0px 0px; color: #fff; text-align: center; border-radius: 3px; overflow: hidden; }
.webuploader-pick-hover { background: #fe4101; }
.webuploader-pick-disable { opacity: 0.6; pointer-events: none; }
.diyButton{ width:180px!important;}
.webuploader-container div{ width:126px !important; height:34px !important; line-height:34px;/*position:absolute; display:block;*/}
.result_null{ width:910px; margin:0px auto;}

.parentFileBox>.fileBoxUl>li>.diyCancel,
.parentFileBox>.diyButton{text-align: left; margin-left: 35px; } 
 #fileBox_WU_FILE_0{height: 150px;width:170px!important;float:left!important;margin-right: 6px;margin-left: 0px;padding:0px}
 #fileBox_WU_FILE_1{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_2{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_3{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 .cmRight_con.manage_a_cmRight_con ul li{ float:left!important;}
 .diyUploadHover{ width:170px!important;padding:0px!important; }
 .fileBoxUl li{ width:170px!important; float: left;}
.parentFileBox>.fileBoxUl>li:hover { -moz-box-shadow:none; -webkit-box-shadow: none; box-shadow:none; }
.procurement-text7{display:block!important;}
#cke_explain{width:698px!important; float: right;margin-right: 40px;position: relative;top: -30px;}
</style>
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
        <li class="tCurrent"><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
        <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
	</ul>
</div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">活动管理</div>
		<div class="cmLeft_down"> 
			<ul>
				<li><a href="<?php echo site_url("corporate/activity/get_list");?>">拼团活动</a></li>
                <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
				
			</ul>
		</div>
	</div>
	<form method="post" action="<?php echo site_url("corporate/card_package").(!empty($package)?'/edit':'/add');?>" class="demoform" id="form1">
	<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">添加货包活动</div>
          <div class="dianpu_01_con01 clearfix" id="recite_add">
               <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>货包名称:</li>
                        <li>指定商品/品类:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                   <input type="hidden" name="id" value="<?php echo !empty($package)?$package["id"]:null;?>">
                   <li class="dingwe"><input class="kehu_kehuguanli1_input" type="text" placeholder="请输入货包名称" name="name" id="search_input" value="<?php echo !empty($package)?$package["name"]:null;?>" ></li>
                     <li>
                            <select class="need-text5"  name="specified_type" onchange="specified();">
                                <option value="1"  <?php echo !empty($package) && $package["specified_type"]==1?"selected":null;?>>商品</option>
                                <option value="2"  <?php echo !empty($package) && $package["specified_type"]==2?"selected":null;?>>品类</option>
                            </select>
                            <select class="need-text5"  name="pid" <?php if(!empty($package)){echo $package["specified_type"]==1?null:"style='display: none'";}?>>
                                <?php foreach ($product as $p){?>
                                <option value="<?php echo $p["id"];?>"><?php echo $p["name"];?></option>
                                <?php };?>
                            </select>
                            <select class="need-text5"  name="cid" <?php echo !empty($package) && $package["specified_type"]==2?null:"style='display: none'";?>>
                                <?php foreach ($cate as $c){?>
                                <option value="<?php echo $c["id"];?>"><?php echo $c["name"];?></option>
                                <?php };?>
                            </select>
                            <span><a href="javascript:add();" style="color:#ff8801; text-decoration:underline">添加</a></span>
                        </li>
                        <div class="condition">
			<samp>已选条件:</samp> 
            <div class="tips-box-r" id="specifiedtype">
            <?php if(!empty($selected) && !empty($package)){?>
            <?php foreach ($selected as $v){;?>
            <div class="tips-content" id="<?php echo 'tips_'.$v['id'];?>"><?php echo $v["name"];?><small><a href="javascript:del(<?php echo $v["id"];?>);">x</a></small></div><span></span>
            <?php };?>
            <?php };?>
            </div>
			<input type="hidden"   name="sid" value="<?php if(!empty($selected) && !empty($package)){foreach ($selected as $v){echo $v['id'].',';}}?>">
			<div class="tips_wu" id="kong" <?php echo !empty($package)?"hidden":null?>><div class="tips-content">暂无选择任何条件!</div><span></span></div> 
         </div>
                    </ul>
                </div>
              </div>
              <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li style="margin-top:15px;">折扣/满减/现场礼包:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                   <li class="dingwe"></li>
                     <li >
                        <select class="need-text5"  name="discount_type" onchange="discounts();">
                            <option value="1"  <?php echo !empty($package) && $package["discount_type"]==1?"selected":null;?>>折扣</option>
                            <option value="2"  <?php echo !empty($package) && $package["discount_type"]==2?"selected":null;?>>满减</option>
                            <option value="3"  <?php echo !empty($package) && $package["discount_type"]==3?"selected":null;?>>现场礼包</option>
                        </select>
                        <div id="discount" <?php if(!empty($package)){echo $package["discount_type"]==1?null:"style='display: none'";}?>><input class="kehu_kehuguanli1_input"  type="number" placeholder="请输入大于1小于10的折扣数字" name="discount"  value="<?php echo !empty($package["discount"])?$package["discount"]:null;?>"></div>
                        <div id="full" <?php echo !empty($package) && $package["discount_type"]==2?null:"style='display: none'";?>> 
                    	 <span style=" margin-right:10px;">买满</span><input  class="zijin1_1_con01_input01" placeholder="请输入满额" name="overtop_price" value="<?php echo !empty($package["overtop_price"])?$package["overtop_price"]:null;?>" >
                        <span style="margin:0 5px;">减</span>
                        <input class="zijin1_1_con01_input01" placeholder="请输入减额" name="deduction_price" value="<?php echo !empty($package["deduction_price"])? $package["deduction_price"]:null;?>">
                        <span id="deduction_"></span>
                        </div>
                    </li>
                    </ul>
                </div>
              </div>
              
              <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>发放数量:</li>
                        <li>发放日期:</li>
                        <li>有效日期:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    <li class="dingwe" style="line-height:37px;">
                         <em style="margin-right:24px;"><span style="float:left; margin-left:5px;"> <input type="radio" value="1"  checked name="give_type" <?php echo !empty($package["give_type"]) && $package["give_type"]==1?"checked=checked":null;?>> 发放到每个用户的卡包</span><span style="float:left; margin:0 47px;">|</span><span style="float:left;"> <input type="radio" value="2" name="give_type" class="" <?php echo !empty($package["give_type"]) && $package["give_type"]==2?"checked=checked":null;?>> 领完即止</span></em>
                         <em><span><input style="width:155px;" class="kehu_kehuguanli1_input" name="number" type="text" value="<?php echo !empty($package["number"])?$package["number"]:null;?>" placeholder="请输入发放数量"></span></em>
                           </li>
                      <li>
                        	<input type="text" value="<?php echo !empty($package["grant_start_at"])?$package["grant_start_at"]:null;?>" class="zijin1_1_con01_input01" name="grant_start_at" onClick="WdatePicker()" readonly>
                            <span>－</span>
                            <label><input type="text" value="<?php echo !empty($package["grant_end_at"])?$package["grant_end_at"]:null;?>" class="zijin1_1_con01_input01" name="grant_end_at" onClick="WdatePicker()" readonly></label><span id="prompt"></span>
                        </li>  
                          <li>
                        	<input type="text" value="<?php echo !empty($package["coupon_start_at"])?$package["coupon_start_at"]:null;?>" class="zijin1_1_con01_input01" name="coupon_start_at" onClick="WdatePicker()" readonly>
                            <span>－</span>
                            <label><input type="text" value="<?php echo !empty($package["coupon_end_at"])?$package["coupon_end_at"]:null;?>" class="zijin1_1_con01_input01" name="coupon_end_at" onClick="WdatePicker()" readonly></label><span id="prompt"></span>
                        </li>        
                    </ul>
                </div>
              </div>
              
              <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l">详细说明：</div>
                 <div class="dianpu_zhong_r"><textarea  placeholder="请输入10-50字详细说明" name="describe"  id="describe" class="procureme"><?php echo !empty($package["describe"])?$package["describe"]:null;?></textarea><br><span id="company_" class="recite_tip"></span></div>
                <span class='state1' id="description_"></span>
              </div>
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>优惠券展示图:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                	<li style="width: 175px; height:150px;border: 1px solid #C4C4C4;"><img id="coupon_img" alt="" src="<?php echo !empty($package["coupon_image"])?IMAGE_URL.$package["coupon_image"]:null; ?>"></li>
                    </ul>
                    <span id="coupon_" class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                   <div id="coupon" style=" position:relative;"></div>  
                    <p style="margin-bottom:15px" class="dianpu_01_p01">图片大小不得超过105KB，尺寸为300x117</p>
                </div>
                </div>
                <input type="hidden" name="coupon_image" value="<?php echo !empty($package["coupon_image"])?$package["coupon_image"]:null; ?>">
                
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>详情页广告图 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                		<li style="width: 175px; height:150px;border: 1px solid #C4C4C4;"><img id="ad_img" src="<?php echo !empty($package["ad_image"])?IMAGE_URL.$package["ad_image"]:null; ?>"></li>
                    </ul>
                    <span id="ad_" class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                  <div id="ad" style=" position:relative;"></div>  
                    <p style="margin-bottom:15px" class="dianpu_01_p01">图片大小不得超过150KB，尺寸为300x161</p>
                </div>
                </div>
                <input type="hidden" name="ad_image" value="<?php echo !empty($package["ad_image"])?$package["ad_image"]:null; ?>">
                
                
                <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>其他属性:</li>
                    	
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                     <li class="dingwe">  
                        <input name="donation" type="checkbox" value="1" <?php echo !empty($package["donation"]) && $package["donation"]==1?"checked=checked":null;?>/><span style="margin-left:10px">可转赠其他用户</span>
                         &nbsp&nbsp&nbsp&nbsp
                        <input name="is_show" type="checkbox" value="1" <?php echo !empty($package["is_show"])?"checked=checked":null;?>/><span style="margin-left:10px">在货包列表显示</span>
                        </li>
                   
                    </ul>
                </div>
              </div>
                 <div>
                     <div class="dianpu_di1"> 
                    	<a onclick=sub(); class="dianpu_recite_btn1">提交审核</a>
                    </div>
                 
              </div> 
              </div>
              
      </div>
      </form>
</div>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang"style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div style="width: 300px;overflow: hidden;margin: 0px auto;">
              <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a> </div>  
              <div class="dingdan4_3_btn01" style="background:#ccc;">  <a id="re_message" href="javascript:void(0);" onclick="$('.dingdan4_3_tanchuang').hide()">取消</a></div>     
          </div>
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

<script type="text/javascript">

$('#coupon').diyUpload({
	url:'<?php echo site_url('corporate/card_package/uploads/1');?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	//单个图片大小(单位字节)
	fileSingleSizeLimit:131072,
	success:function( data ) {
	    $("input[name=coupon_image]").val(1);
		$coupon_image = $("#coupon").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#coupon_img').attr('src',$coupon_image);
		$('#coupon').next('div').remove();
	},
	error:function( err ) {
		console.info( err );	
	},
	fileNumLimit:1,
});

$('#ad').diyUpload({
	url:'<?php echo site_url('corporate/card_package/uploads/2');?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	//单个图片大小(单位字节)
	fileSingleSizeLimit:131072,
	success:function( data ) {
	    $("input[name=ad_image]").val(1);
		$coupon_image = $("#ad").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#ad_img').attr('src',$coupon_image);
		$('#ad').next('div').remove();
	},
	error:function( err ) {
		console.info( err );	
	},
	fileNumLimit:1,
});




function specified(){
    type = $("select[name=specified_type]").val();
    switch(type){
        case "1":
        	$("select[name=pid]").show();
            $("select[name=cid]").hide();
            break;
        case "2":
            $("select[name=pid]").hide();
            $("select[name=cid]").show();
            break;
        default:
            window.location.reload();
            break;
    }
    $("input[name=sid]").val("");
    $("#specifiedtype").empty();
    $("#kong").show();
}

//根据选中商品/品类显示不同select
function add(){
	type = $("select[name=specified_type]").val();
	sid = $("input[name=sid]").val();
    switch(type){
    case "1":
    	id = $("select[name=pid]").val();
    	if(sid.search(id+',') == -1){//判断是否已选择
            var text = $("select[name=pid]").find("option:selected").text();//获取选中的文本
    	}else{
    	    alert("已经存在");return;
        }
        break;
    case "2":
    	id = $("select[name=cid]").val();
    	if(sid.search(id+',') == -1){//判断是否已选择
           var text = $("select[name=cid]").find("option:selected").text();//获取选中的文本
    	}else{
    	    alert("已经存在");return;
        }
        break;
    default:
        window.location.reload();
        return ;
        break;
    }
    $("#kong").hide();
    $("input[name=sid]").val(sid+id+',');
    var html = '<div class="tips-content" id="tips_'+id+'">'+text+'<small><a href="javascript:del(\''+id+'\');">x</a></small></div><span></span>';
    $("#specifiedtype").append(html);

}

//移除选中
function del(id){
	sid = $("input[name=sid]").val();
	if(id){
		if(sid.search(id+',') == -1){	
		  window.location.reload();return ;
		}else{
    		$("#tips_"+id).next().remove();
            $("#tips_"+id).remove();
            sid = sid.replace(id+",","");//替换
            $("input[name=sid]").val(sid);
            if(!sid){
            	$("#kong").show();
            }
		}
	}
}

//根据选中折扣/满减/现场礼包显示不同input
function discounts(){
    type = $("select[name=discount_type]").val();
    switch(type){
        case "1":
        	$("#discount").show();
            $("#full").hide();
            break;
        case "2":
        	$("#discount").hide();
            $("#full").show();
            break;
        case "3":
        	$("#discount").hide();
            $("#full").hide();
            break;
        default:
            window.location.reload();
            break;
    }
}

//提交
function sub(){
	$('.recite_tip').text('');
    //验证货包名称
    var name = $("input[name=name]").val();
    if(!name){
        alert('请输入货包名称');
        return;
        }
	
	//验证sid
	var sid = $("input[name=sid]").val();
	if(!sid){
		alert('请选择指定商品/品类');
		return;
		}
	
	var discount_type = $("select[name=discount_type]").val();
	switch(discount_type){//折扣验证
	   case "1":
		   var discount = $("input[name=discount]").val();
		   var validate = /^[1-9]([.]{1}[0-9])?$/;
		   if(validate.test(discount)==false){
			  alert("请输入大于1小于10的折扣数字");
			   return;
		   }
		   break;
	   case "2"://满额验证
		   var overtop = $("input[name=overtop_price]").val();
		   var deduction = $("input[name=deduction_price]").val();
		   var validate = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
		   if(validate.test(overtop)==false || validate.test(deduction) == false){
				alert("请输入金额格式");
				return;
			}else if(Number(parseFloat(deduction).toFixed(2)) > Number(parseFloat(overtop).toFixed(2)) ){
	    		alert("买满金额必须大于等于减金额!");
	    		return;
	    	}
		   break; 
	   case "3"://现场礼包
		   break; 
	   default :
		   window.location.reload();
	       return;
		   break;
	}

	//验证发放数量
	give_type = $("input[name=give_type]:checked").val();
    if(give_type == 2){
        var validate = /^[1-9]\d*$/;
        number = $("input[name=number]").val();
        if(validate.test(number)==false){
			alert("请填写正确的数量");
			return ;
		}
    }

    //验证发放日期
    grant_start_at = $("input[name=grant_start_at]").val();
    grant_end_at = $("input[name=grant_end_at]").val();
    if(grant_start_at >= grant_end_at){
        alert("发放日期不能大于或者等于结束日期");
        return;
    }

    //验证过期日期
    coupon_start_at = $("input[name=coupon_start_at]").val();
    coupon_end_at = $("input[name=coupon_end_at]").val();
    if(coupon_start_at >= coupon_end_at){
        alert("开始日期不能大于或者等于有效日期");
        return;
    }

    //验证详细说明
    var describe = $("#describe").val();
    if(!describe || describe.length<10 || describe.length>50){
        alert('请输入10-50字详细说明');
        return;
        }
	
	//验证优惠卷展示图
	$coupon = $("input[name=coupon_image]").val();
    if(!$coupon){
        $("#coupon_").text("请上传优惠券展示图");
        return;
        }

    //验证广告图
    $ad = $("input[name=ad_image]").val();
    if(!$ad){
        $("#ad_").text("请上传广告图");
        return;
        }
    
	$("#form1").submit();
}



</script>

