<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/style_v2.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>

<style>
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
.need-text5 {width: 274px;border: 1px solid #C8C8C8;outline: none;-webkit-appearance: none;border-radius: 0;background: #fff;color: #CACACA;padding-left: 10px;background: url("images/needs_right_icon.png") no-repeat scroll right center transparent;}
.procurement-time02 {padding-left: 0px;}
.needs_publish_tijiao {width: 170px;height: 40px;background: #6DC310;margin-top: 25px;margin-left: 160px;color: #fff;border: 1px solid #6DC310; border-radius: 3px;display: block;line-height: 40px;text-align: center; }
.bainse{margin-right:229px; margin-top:11px; color:#C3482C; float:right;}
#demo .parentFileBox {width: 590px!important;}
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
    <form method="post" action="<?php echo site_url('corporate/information/edit');?>" id="form">
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">公司介绍<span style=" margin-left:30px;">审核状态：<?php switch(!empty($image[0]['status'])?$image[0]['status']:0){case '0':echo '通过';break;case 1:echo '审核中';break;case 2:echo '不通过';break;}?></span></div>
           
          <div class="dianpu_01_con01 clearfix" id="recite_add">
               <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>公司名称:</li>
                        <li>公司图标:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    	<li><span style="height:43px; line-height:43px; display:block; overflow:hidden;"><?php echo $corporation['corporation_name']?></span></li>
                        <li id="img" ><img id="logo_img" src="<?php echo IMAGE_URL.$corporation['img_url']?>" width="150" height="150" alt=""/></li>
                    </ul>
                </div>
              </div>
              <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l"><samp>＊</samp>公司简介：</div>
                 <div class="dianpu_zhong_r"><textarea  placeholder="(必填，不少于100字，不多于500字)" name="description"  class="procureme"><?php foreach ($image as $v){if($v['type']=='description'){echo $v['description'];}}?></textarea><br><span id="company_" class="recite_tip"></span></div>
                <span class='state1' id="description_"></span>
              </div>
              
              <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li><samp>＊</samp>公司图片 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <li id="img" ><img id='picture_img' src="<?php foreach ($image as $v){if($v['type']=='picture'){echo $picture = $v['image_name'];}}?>" width="250" height="154" alt=""/></li>
                        <input type="hidden" name="picture" value="<?php if(isset($picture)){echo $picture;}?>">
                        <span class='state1' id="picture_"></span>
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过274KB,尺寸为 390x240，图片格式支持 .jpeg / .jpg / .png / .gif </p><span id='picture_' class="recite_tip"></span>
                    
                    <!-- 上传图片按钮 -->
                  <div id="picture" style=" position:relative;"></div>
                </div>
                </div>
                 <div class="dianpu_zhong">
<!--                  <div class="dianpu_zhong_l">个人介绍：</div> -->
<!--                  <div class="dianpu_zhong_r"><textarea placeholder="(必填，不少于100字，不多于500字)" name="personal" class="procureme"></textarea><span id="personal" class="recite_tip"></span></div> -->
              </div>
                <?php $number=0;foreach($image as $v){if($v['type']=='ce'){$number++;}}?>
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>企业实力展示 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <input type="hidden" name="ce" value="">
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过128KB,尺寸为 260x186，图片格式支持 .jpeg / .jpg / .png / .gif </p>
                    <span id="ce_" class="recite_tip"></span>
                    <!-- 上传图片按钮 -->
                       <span  class="be1">最多可以上传4张</span>
                   <div id="ce" style=" position:relative;"></div>
                </div>
                <input type="text" value="<?php echo $number;?>" id="number" hidden>
                    <?php if($number>0){?>
                    <label><span class="red">*</span>已有商品图片：</label>
                    <div class="new_edit_box clearfix">
                    <div style="margin-left:144px;">
                        <?php foreach ($image as $val){;?>
                        <?php if($val['type']=='ce'){?>
                        <div style="float:left;" class="parentFileBox" id="<?php echo $val['type'].'_'.$val['id']?>">
                            <ul class="fileBoxUl">
                            <li id="fileBox" class="diyUploadHover" style="border: none; width:170px!important; float:left!important;">
                            <div class="viewThumb"> <img src="<?php echo $val['image_name'];?>"> </div>  
                            <div class="diyCancel" onclick="del_img(<?php echo $val['id']?>,'<?php echo $val['type']?>')"></div>
                            <div class="diySuccess"></div>
                            <div class="diyFileName"></div>
                            </li>  
                            </ul>
                        </div>
                        <?php };?>
                        <?php };?>
                    </div>
                    </div>
                    <?php };?>

                
                </div>
                
                <div class="dianpu_ls dianpu_ls1">
                <div class="dianpu_left">
                	<ul>
                    	<li>领导关怀 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul style="margin-right:-47px;">
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_1' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==1){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                            <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(1)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                                        
                        </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_2' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==2){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                           <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(2)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                        </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_3' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==3){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                           <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(3)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                        </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_4' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==4){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                             <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(4)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                        </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_5' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==5){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                            <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(5)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                        </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_6' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==6){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>
                           <!--编辑区 开始-->
                           <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="solicitude(6)">编辑</a>
                              </div>
                        <!--编辑区 结束-->
                        </li>
                        <input type="hidden" name="ce" value="">
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过107KB,尺寸为 250x174，图片格式支持 .jpeg / .jpg / .png / .gif  <span style="color:#c23126; font-size:14px;">最多可以上传6张</span> </p>
                  
                </div>
                </div>
                 <div>
                     <div class="dianpu_di"> 
                        <input type="hidden" value="0" name="status" >
                        <a onclick=location.reload(); class="dianpu_recite_btn_grey">重置</a> 
                        <a onclick=sub(0); class="dianpu_recite_btn">提交</a>
                    	<a onclick=sub(1); class="dianpu_recite_btn">提交并预览</a>
                    </div>
                 
              </div> 
              </div>
              
              </div>
              </div>
              </form>
</body>

  <!--弹出层 fancybox-top 编辑仅图片 开始-->
    <form  id="solicitude" method="post" action="<?php echo site_url('corporate/information/file_upload/solicitude') ?>" target='frameFile' enctype="multipart/form-data">
        <div class="fancybox-top" style="display:none"> 
            <div id="fancybox-loading" style="display: none;"><div></div></div>
            <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
            <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
                <!--弹窗头部 开始-->
                <div class="fancybox-head">编辑商品  <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
                <!--弹窗头部 结束-->
                <div id="fancybox-outer">
                  <div id="fancybox-content" class="fancybox_con">
                  <div>
                  <div id="inline1" class="fancybox-inline1" >
                    <div class="fancybox-editCon clearfix">
                        <div class="fancybox-editCon-left">
                            <ul>
                                <li>上传商品图片：</li>
                                <li>例子：</li>
                            </ul>
                        </div>
                        <div class="fancybox-editCon-right">
                            <ul id="biaoshi_1">
                            <li><input type="file" id="file" name="file"><span class="">图片尺寸：250X174</span></li>
                                <li><p>
                                <input class="jindao" type="text"name=title placeholder="例子：陕西晋商商会">
                                <input type="text" name="number" style="display:none">
                                </p></li>
                            </ul>
                        </div>
                    </div>
                  </div></div></div>
                  <!--弹窗尾部 开始-->
                  <div id="fancybox-title" class="fancybox-title-inside">
                      <div id="fancybox-title-inside">
                        <div class="fancybox-btn">
                            <a href="javascript:;" class="fancybox_back fancybox_back-top">取消</a>
                            <a href="javascript:;" class="fancybox_okay" id="sure">确定</a>
                        </div>
                      </div>
                  </div>
                  <!--弹窗尾部 结束-->
              </div>
            </div>
        </div>
    </form>
    <iframe  name='frameFile' style="display:none"></iframe>
    <!--弹出层 fancybox-top 编辑仅图片 结束--> 

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

$('#picture').diyUpload({
	url:'<?php echo site_url('corporate/information/file_upload/picture') ?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:1,
	//单个图片大小(单位字节)
	fileSingleSizeLimit:280576,
	success:function( data ) {
		console.info( data );
		if(data){
		$picture = $("#picture").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#picture_img').attr('src',$picture);
		$('input[name=picture]').val($picture);
		$('#picture').next('div').remove();
		}
	},
	error:function( err ) {
		console.info( err );	
	}
	
});



$('#ce').diyUpload({
	url:'<?php echo site_url('corporate/information/file_upload/ce') ?>',
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:check_number(),
	//单个图片大小(单位字节)
	fileSingleSizeLimit:131072,
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

//检查图片张数
function check_number(){
	var number = $("#number").val();
	if(number>=4){
		return -1;
		}else{
			  return 4-number;
			}
	
}

</script>

<script type="text/javascript">
	//隐藏提示框
	function hiding(){
		$("#danchuang").hide();
		$('#prompt').text("");
		$("#sure").attr('href','javascript:void(0)');
		}
</script>

<script>
   //点击领导关怀编辑按钮，弹出层仅编辑图片内容
	function solicitude(key){
		$("#sure").attr("onclick","sure("+key+")");
		$('.fancybox-top').show();
    }

	//确定上传领导关怀图片
	function sure(key){
		file_name = $("#file").val();
		title = $("input[name=title]").val();
		
		if(file_name && title){
			$("input[name=number]").val(key);
			$("#solicitude").submit();
			var interval = setInterval(function(){
			image_path = $("iframe").contents().find("body").html();
				if(image_path){ 
					clearInterval(interval); 
					$("#solicitude_"+key).attr("src",image_path);//显示图片
					//清除input上传图片记录
		 			$("#file").val("");//
		 			image_path = $("iframe").contents().find("body").html("");
		 			$("input[name=title]").val("");
		 			$('.fancybox-top').hide();
				} 
			 }, 500);

			
		}else{
		    alert('请填写相关内容');
			}
	}

	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back-top').click(function(){
		$("#file").val("");
		$("input[name=name]").val("");
		$('.fancybox-top').hide();
	});
	
	//点击弹出层取消fancybox_back按钮，弹出层内容消失
	$('.icon-guanbi').click(function(){
		$('.fancybox-top').hide();
	});


	//提交数据
	function sub(status){
		if(confirm('确定提交吗？')){
	    $(".state1").text("");
		var ok = true;
    	    //表单验证
    		description = $("textarea[name=description]").val();
    		picture_img = $("input[name=picture]").val();
    		$("input[name=status]").val(status);
    		if(!description || description.length<100 || description.length>500){
    			$("#description_").css('color','red').text("请填写100～500字数");
    			ok = false;
    			}
    		if(!picture_img){
    			$("#picture_").css('color','red').text("请上传图片");
    			ok = false;
    			}
    	    if(ok){
    	    	   $("#form").submit();
    	    }
		}
	}

	//删除图片
	function del_img(id,type){
		  if(confirm('确定删除吗？')){
		       $.post("<?php echo site_url('corporate/information/del_img');?>",{id:id,type:type},function(data){
		    	    if(data){
			    	    $("#"+type+'_'+id).remove();
			    	    number = $("#number").val();
			    	    $("#number").val(number-1);
			    	    alert('删除成功');
						$('#ce').diyUpload({
			    			url:'<?php echo site_url('corporate/information/file_upload/ce') ?>',
			    			//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
			    			fileNumLimit:4-(number-1),
			    			//单个图片大小(单位字节)
			    			fileSingleSizeLimit:102400,
			    			success:function( data ) {
			    				console.info( data );
			    			},
			    			error:function( err ) {
			    				console.info( err );	
			    			}
						  });
						  
			    	    }else{
			    	        alert('删除失败');
				    	    }
			       });
		  }else{
// 			   alert('on');
			  
		  }
		}

	function information_check_number(){
		var number= $("#number").val()*1+1*1;
		$("#number").val(number);
		if(!(4-number)){
			number = -1;
			}else{
				number = (4-number);
				}
		$('#ce').diyUpload({
			url:'<?php echo site_url('corporate/information/file_upload/ce') ?>',
			//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
			fileNumLimit:number,
			//单个图片大小(单位字节)
			fileSingleSizeLimit:102400,
			success:function( data ) {
				console.info( data );
			},
			error:function( err ) {
				console.info( err );	
			}
		  });
		}


</script>
</html>
