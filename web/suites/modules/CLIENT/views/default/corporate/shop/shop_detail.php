<style>
<!--
.parentFileBox{top:30px;display:block;float:left;margin-bottom:40px;}
.webuploader-pick{ background:#fe4101;}
.webuploader-container div{width:86px;}
-->
</style><script src="js/ckeditor/ckeditor.js"></script>
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
						<a class="diyStart" href="javascript:void(0)" style="background-color:#fe4101;">开始上传</a> \
						<a class="diyCancelAll" href="javascript:void(0)" style="background-color:#fe4101;">取消操作</a> \
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
    <script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="js/Validform.js"></script>
    <!--分类头部 结束 -->       
<link rel="stylesheet" href="css/jquery.fullPage.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<script type="text/javascript" src="js/jquery.easie.js"></script>
<!-- <script type="text/javascript" src="js/my.js"></script>-->
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<?php if(isset($detail['bus_licence_img'])&&!strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1): ?>
<style>
<!--
#tagContent { }
.tagContent { display: block; }
#tagContent div.selectTag { display: block }
-->
</style>
<?php elseif(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1):?>
<style>
<!--
#tagContent { }
.tagContent { display: block; }
#tagContent div.selectTag { display: block }
-->
</style>
<?php else:?>
<script type=text/javascript>
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
</script>
<!-- 认证状态tab切换js -->
<style>
<!--
#tagContent { }
.tagContent { display: none; }
#tagContent div.selectTag { display: block }
-->
</style>

<?php endif;?>
<script>
$(function(){
  $(".renzheng_tab ul li").eq(0).click(function(){
	  $(".renzheng_tab1").show().siblings().hide();
	  
	  $(".renzheng_tab ul li a").css("color","#555")
	  $(this).children().css("color","#fe4101");
	  })
  $(".renzheng_tab ul li").eq(1).click(function(){
	  $(".renzheng_tab2").show().siblings().hide();
	  
	  $(".renzheng_tab ul li a").css("color","#555")
	  $(this).children().css("color","#fe4101");
	  })
	  
})
</script>
<style>
/*产品tab*/
#basic_tags li {float: left; list-style:none;}
#basic_tags li a {background:url(images/btn_show_tab_01.png) no-repeat 0 center;width: 150px; /*height: 35px;*/ overflow:hidden; display:block; color:#555;}
#basic_tags li a:hover{ color:#555;}
#basic_tags li.selectTag, #basic_tags li.selectTag a{background:url(images/btn_show_tab_02.png) no-repeat 0 center;width: 150px;/* height: 35px;*/display:block; color:#fe4101;}

</style>
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
<?php $province_selected = $detail['province_id'];?>
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
	  url: '<?php echo site_url('order_att/select_children/parent_id')?>'+'/'+$('#province_id2').val(),
	  type: 'GET',
	  dataType: 'html',
	  data:{id:$('#province_id2').val()},
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

//-->
</script>
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">店铺信息</div>
            <form action="<?php echo site_url('corporate/myshop/save_shop') ?>" method="post" name="form" id="form1">
            <div class="dianpu_01_con01 clearfix">
            <input type="hidden" name="id" value="<?php echo isset($detail['id'])?$detail['id']:'' ?>">
            	<div class="dianpu_left">
                	<ul>
                    	<li>企业名称 :</li>
<!--                         <li>店铺名称 :</li> -->
                        <li>店铺图标 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    	<li><input class="dianpu_01_input1" type="text" value="<?php echo isset($detail['corporation_name'])?$detail['corporation_name']:'' ?>" readonly style="border:none"></li>
<!--                         <li class="dianpu-xiugai"><div class="dianpu-xiugai1"><span>美好生活馆</span><a class="dianpu-xiugai-lei" id="dianpu-xiugai-lei">修改</a></div> -->
                        <div class="dianpu-xiugai-sh"><input class="dianpu_01_input1" type="text" name="contact_name" placeholder="请输入企业名称"><a class="dianpu-xiugai-lei" id="queding">确定</a><a class="dianpu-xiugai-rgth">取消</a></div>
                            
                        </li>
                        <li id="img" ><img src="<?php echo isset($detail['img_url'])&&$detail['img_url']!=''?IMAGE_URL.$detail['img_url']:'images/logo310.png' ?>" width="150" height="150" alt=""/style="border:1px solid #c0c0c0"></li>
                        
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过100KB,尺寸为 150x150</p>
                    <div class="dianpu_01_btn01" id="test" style="width:100px;line-height:10px;left:0;top:0px"><div ><a href="javascript:;" ></a></div></div>
                </div>
                <!---->
                <div class="dianpu_left">
                	<ul>
                    	<li>联系人 :</li>
                        <li>联系手机 :</li>
                        <li>联系邮箱 :</li>
                        <li>企业所在地 :</li>
                        <li>企业地址 :</li>
                        <li></li>
                        <li>自动接单金额 :</li>
                        <li>公司邮编 :</li>
                        <li>企业行业 :</li>
                        <li>企业性质 :</li>
                        <li>企业法人 :</li>
                        <li>身份证号 :</li>
                        <li>工商注册号 :</li>
                        <li>易入需求 :</li>
                        <li>成立年份 :</li>
                        <li>公司规模 :</li>
                        <li>注册资本 :</li>
                        <li>公司网址 :</li>
                        <li>微信号 :</li>
<!--                         <li>二维码 :</li> -->
                    </ul>
                </div>
                <div class="dianpu_01_right dropdown basicInformation_right">
                	<ul>
                    	<li><input class="dianpu_01_input" type="text" name="contact_name" value="<?php echo isset($detail['contact_name'])?$detail['contact_name']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="contact_mobile" value="<?php echo isset($detail['contact_mobile'])?$detail['contact_mobile']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" placeholder="" name="email" value="<?php echo isset($detail['email'])?$detail['email']:"" ?>"></li>
                        <li>
                                <select class="regsiter_03_select01 dropdown_select01 dropdown_select01_basic" id="province_id2">
                                    <option value="" >省份</option>
	                                <?php foreach($provinces as $key => $province): ?>
	                                <option value="<?php echo $province['region_id']; ?>" <?php if($province['region_id']==$province_selected){echo 'selected';}?> ><?php echo $province['region_name']; ?></option>
	                                <?php endforeach; ?>
                                </select>
                                <select class="regsiter_03_select02 dropdown_select01 dropdown_select01_basic" id="city_id2">
                                    
                                </select>
                        </li>
                        <li>
                                <?php 
                                    $data['province_selected'] = $detail['province_id'];
                                    $data['city_selected'] = $detail['city_id'];
                                    $data['district_selected'] = $detail['district_id'];
                                ?>
								<?php $this->load->view('widget/district_select',$data); ?>
                            
                        </li>
                        <li><input type="text" name="address" oninput="region()" class="regsiter_02_input" value="<?php echo isset($detail['address'])?$detail['address']:"" ?>" placeholder="请输入具体地址"><a target="_blank" id="baidu_api" ><span class="icon-coordinate" style="color: #fe4101"> </span></a></li>
                        <li>
                        	<input type="text" class="regsiter_02_input" name="auto_order_amount" value="<?php echo isset($detail['auto_order_amount'])?$detail['auto_order_amount']:"0.00" ?>">
                            <span class="shop_managetips">提示:当金额小于设置值时,卖家无需点击接单按钮,买家可直接付款</span>
                        </li>
                        <li><input type="text" class="regsiter_02_input" name="postcode" value="<?php echo isset($detail['postcode'])?$detail['postcode']:"" ?>"></li>
                        <li>
                                <select class="dropdown_select03 dropdown_select03_basic" name="Industrial_Info" id="Industrial_Info">
                                    <option value="0">行业</option>
                                    <?php if(count($cor_ind)>0): ?>
                                    <?php foreach ($cor_ind as $c): ?>
                                    <option value="<?php echo $c['id'] ?>" <?php echo isset($detail['Industrial_Info'])&&$detail['Industrial_Info']==$c['id']?'selected':'' ?>><?php echo $c['name'] ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                        </li>
                        <li>
                            
                                <select class="dropdown_select03 dropdown_select03_basic" name="nature" id="nature">
                                    <option value="0">性质</option>
                                    <?php if(count($cor_type)>0): ?>
                                    <?php foreach ($cor_type as $c): ?>
                                    <option value="<?php echo $c['id'] ?>" <?php echo isset($detail['nature'])&&$detail['nature']==$c['id']?'selected':'' ?>><?php echo $c['name'] ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                           
                        </li>
                        <li><input type="text" class="dianpu_01_input" placeholder="请填写企业账号负责人姓名" readonly style="border:none" name="legal_person" value="<?php echo isset($detail['legal_person'])?$detail['legal_person']:"" ?>"></li>
                        <li><input type="text" class="dianpu_01_input" placeholder="请填写企业账号负责人身份证号码" readonly style="border:none" name="idcard" value="<?php echo isset($detail['idcard'])?$detail['idcard']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" placeholder="请填写企业工商注册号" readonly style="border:none" name="company_registration" value="<?php echo isset($detail['company_registration'])?$detail['company_registration']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="entry_requirements" value="<?php echo isset($detail['entry_requirements'])?$detail['entry_requirements']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="company_establish" value="<?php echo isset($detail['company_establish'])?$detail['company_establish']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="company_size" value="<?php echo isset($detail['company_size'])?$detail['company_size']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="Registered_Capital" value="<?php echo isset($detail['Registered_Capital'])?$detail['Registered_Capital']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="company_web" value="<?php echo isset($detail['company_wechat'])?$detail['company_web']:"" ?>"></li>
                        <li><input class="dianpu_01_input" type="text" name="company_wechat" value="<?php echo isset($detail['company_wechat'])?$detail['company_wechat']:"" ?>"></li>
                       <!--  <li style="height:auto"><img id="QR_code" src=<?php echo isset($detail['QR_code'])&&$detail['QR_code']!=null?IMAGE_URL.$detail['QR_code']:"images/dianpuguanli_erweima.png" ?> width="150" height="150" alt=""/></li> -->
                    </ul>
                    <!-- <p class="dianpu_01_p01">图片大小不能超过100KB,尺寸为 150x150</p>
                    <div class="dianpu_01_btn01"><a href="javascript:;">上传图片</a></div>-->
                    <div class="dianpu_01_btn02"><a onclick="submit();">保存</a></div>
                 </form>
                </div>
       		</div>
            <div class="dianpu_01_con02">
              <div class="cmRight_tittle">认证资料</div>
              
              <!--认证tab 开始-->
              <div class="renzheng_tab">
                   <ul>
                       <li><a href="javascript:;" class="renzhengTab_current">认证状态</a></li>
                       <li><a href="javascript:;">修改认证</a></li>
                   </ul>
              </div>
              <!--认证tab 结束-->
              
              <div class="regsiter_wanshan_renzheng_con basicInformation_down">
               
              <!--认证状态内容tab1 开始-->
              <div class="renzheng_tab1">
              	 <!--认证状态 成功显示样式-->
              	 <?php if(isset($detail['approval_status'])&&$detail['approval_status']==2):?>
                 <div class="renzhengTab_con01" >
              	 	<p style="float:left">认证状态：<span class="renzhengTab1_span">已认证</span></p>
                 </div>
                 <?php elseif(isset($detail['approval_status'])&&$detail['approval_status']==3): //approval_status为2表示重新认证失败?>
                 <!--认证状态 失败＋原因显示样式-->
                 <div class="renzhengTab_con02" >
                     <p style="float:left">认证状态：<span class="renzhengTab1_span">认证失败</span></p><br><br>
                     <p style="float:left">失败原因：<span class="renzhengTab1_span"style="color:#fe4101"><?php echo isset($detail['approval_desc'])?$detail['approval_desc']:"" ?></span></p>
                 </div>
                 <?php elseif(isset($detail['approval_status'])&&$detail['approval_status']==1): //approval_status为0表示重新认证审核中?>
                 <!--认证状态 审核中显示样式-->
                 <div class="renzhengTab_con03" >
              	 	<p style="float:left">认证状态：<span class="renzhengTab1_span">审核中...</span></p>
                 </div>
                 <?php endif; ?>
              </div>
              <!--认证状态内容tab1 结束-->
              
              <!--修改认证内容tab2 开始-->
              <div class="renzheng_tab2" hidden>
              <!--营业执照 开始-->               
              <div class="regsiter_renzheng_con">
                  <div class="regsiter_renzheng_left basicInformation_downLeft">营业执照：</div>
                  <div class="clearfix">
                  <div class="regsiter_renzheng_right clearfix">
                      <div class="renzheng_right_yingyezhizhao">
                      
                      <ul id="basic_tags">
                       <?php if(isset($detail['bus_licence_img'])&&!strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1): ?>
                          	<li class="selectTag">
                              <a onClick="selectTag('tagContent0',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 新版营业执照 </a>
                            </li>
                          
                        <?php elseif(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1): ?>
                            <li class="selectTag">
                              <a onClick="selectTag('tagContent1',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 旧版营业执照</a>
                            </li>
                        <?php else:?>
                            <li class="selectTag">
                              <a onClick="selectTag('tagContent0',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 新版营业执照 </a>
                            </li>
                            <li>
                              <a onClick="selectTag('tagContent1',this)" href="javascript:void(0)"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 旧版营业执照</a>
                            </li>
                        <?php endif;?>
                      </ul>
                      <div class="clearfix"></div><!--清除浮动-->
                          <!--<label class="yingyezhizhao_lable"><input type="radio" class="yingyezhizhao_radio" checked="checked">新版营业执照</label>
                          <label><input type="radio" class="yingyezhizhao_radio" ></label>-->
                          
                      <div id="tagContent">
                      <?php if(isset($detail['bus_licence_img'])&&!strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1){ ?>
                          <div class="tagContent selectTag" id="tagContent0">
                          
                              <!--选择新版营业执照显示以下内容 开始 默认显示新版-->
                              <div class="yingyezhizhao_new Business_license_new" style="display:block;position:relative;">
                              <p class="yingyezhizhao_p">请上传《营业执照》文件</p>
                              <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="Bussiness_license_example">查看示例</a></p>
                              <!--上传营业执照后显示图片div 未上传前display＝none-->
                              <br>
                               <span class="yingyezhizhao_span">新版需上传：法人营业执照（三证合一）</span>
                              <!--  -->
                            
                              <div class="yingyezhizhao_img" >
                              <a href="<?php echo isset($detail['bus_licence_img']) && !strpos($detail['bus_licence_img'],';')?IMAGE_URL.$detail['bus_licence_img']:'' ?>" target="_blank">
                              <img src="<?php echo isset($detail['bus_licence_img']) && !strpos($detail['bus_licence_img'],';')?IMAGE_URL.$detail['bus_licence_img']:'' ?>" width="150" height="120" alt="" />
                              </a>
                              </div>
                              <!-- <div class="shangchuan_btn01" id="news" style="width:88px;line-height:10px;position:absolute;left:0;top:215px"><a href="javascript:;">更换文件</a></div>-->
                             
                              <!--上传按钮-->
                              
                             
                              </div>
                              <!--选择新版营业执照显示内容 结束-->
                              
                          </div>
                      <?php }elseif(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==1){ ?>
                          <div class="tagContent" id="tagContent1">
                          
                            <!--选择新版营业执照显示以下内容 开始 默认隐藏旧版-->
                              <div class="yingyezhizhao_old" style="position:relative;">
                                  <p class="yingyezhizhao_p">请上传《营业执照》文件</p>
                                  <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="oldBusiness_example" onclick="oldbusiness();">查看示例</a></p>
                                  <!--上传营业执照后显示图片div 未上传前display＝none-->
                                 <br>
                                 <span class="yingyezhizhao_span">旧版需上传：营业执照、税务登记证、组织机构代码证</span>
                                  <div class="yingyezhizhao_img clearfix old_bussiness" > 
                                      <ul>
                                          <li>
                                          <?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')): ?>
                                          <a href="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.strstr($detail['bus_licence_img'],';',1);}else{echo '';} ?>" target="_blank">
                                          <img src="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.strstr($detail['bus_licence_img'],';',1);}else{echo '';} ?>" width="150" height="120" alt="" />
                                          </a>
                                          <?php endif;?>
                                          </li>
                                          <li>
                                          <?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')): ?>
                                          <a href="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.strstr(substr(strstr($detail['bus_licence_img'],';'),1),';',1);}else{echo '';} ?>" target="_blank">
                                          <img src="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.strstr(substr(strstr($detail['bus_licence_img'],';'),1),';',1);}else{echo '';} ?>" width="150" height="120" alt="" />
                                          </a>
                                          <?php endif;?>
                                          </li>
                                          <li>
                                          <?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')): ?>
                                          <a href="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.substr(strrchr($detail['bus_licence_img'],';'),1);}else{echo '';} ?>" target="_blank">
                                          <img src="<?php if(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')){echo IMAGE_URL.substr(strrchr($detail['bus_licence_img'],';'),1);}else{echo '';} ?>" width="150" height="120" alt="" />
                                          </a>
                                          <?php endif;?>
                                          </li>
                                      </ul>
                                  </div>
                                  <!--上传按钮-->
                                  <!-- <div class="shangchuan_btn01" id="olds" style="width:88px;line-height:10px;position:absolute;left:0;top:235px"><a ></a></div>
                                  <div class="shangchuan_btn01" id="olds2" style="width:88px;line-height:10px;position:absolute;left:180px;top:235px"><a ></a></div>
                                  <div class="shangchuan_btn01" id="olds3" style="width:88px;line-height:10px;position:absolute;left:360px;top:235px"><a ></a></div>-->
                                  
                        
                              </div>
                              <!--选择旧版营业执照显示内容 结束-->
                          </div>
                          <?php }else{?>
                              <div class="tagContent selectTag" id="tagContent0">
                          
                              <!--选择新版营业执照显示以下内容 开始 默认显示新版-->
                              <div class="yingyezhizhao_new Business_license_new clearfix" style="display:block;position:relative;">
                              <p class="yingyezhizhao_p">请上传《营业执照》文件</p>
                              <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="Bussiness_license_example">查看示例</a></p>
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
                                  <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="oldBusiness_example" onclick="oldbusiness();">查看示例</a></p>
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
                          
                          <?php }?>
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
                      <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="identity_example">查看示例</a></p>
                      <!--上传法人身份证复印件后显示图片div 未上传前display＝none-->                      
                      <?php if(isset($detail['idcard_img'])&&$detail['approval_status']==1): ?>
                       
                      <div class="yingyezhizhao_img clearfix" style="display:block">
                            <ul>
                           
                                <li>
                                <?php if(isset($detail['idcard_img'])): ?>
                                <a href="<?php if(isset($detail['idcard_img'])&&strpos($detail['idcard_img'],';')){echo IMAGE_URL.strstr($detail['idcard_img'],';',1);}else{echo '';} ?>" target="_blank">
                                <img src="<?php if(isset($detail['idcard_img'])&&strpos($detail['idcard_img'],';')){echo IMAGE_URL.strstr($detail['idcard_img'],';',1);}else{echo '';} ?>" width="150" height="120" alt="" />
                                </a>
                                <?php endif;?>
                                </li>
                                <li>
                                <?php if(isset($detail['idcard_img'])): ?>
                                <a href="<?php if(isset($detail['idcard_img'])&&strpos($detail['idcard_img'],';')){echo IMAGE_URL.substr(strrchr($detail['idcard_img'],';'),1);}else{echo '';} ?>" target="_blank">
                                <img src="<?php if(isset($detail['idcard_img'])&&strpos($detail['idcard_img'],';')){echo IMAGE_URL.substr(strrchr($detail['idcard_img'],';'),1);}else{echo '';} ?>" width="150" height="120" alt="" />
                                </a>
                                <?php endif;?>
                                </li>
                            </ul>
                    </div>
                      <!--上传按钮-->
                      <!-- <div class="shangchuan_btn01" id="idcard" style="width:88px;line-height:10px;position:absolute;left:0;top:185px"><a ></a></div>
                      <div class="shangchuan_btn01 basicInformation_downUpdate" id="idcardback" style="width:88px;line-height:10px;position:absolute;left:180px;top:185px"><a ></a></div>-->
                     <?php else: ?> 
                     <div class="yingyezhizhao_img clearfix" style="display:block">
                          <ul>
                              <li><a class="identity_img_front" id="idcard1"><img src="images/identity_front.jpg" width="150" height="110" alt=""/></a></li>
                              <li><a class="identity_img_opposite" id="idcard2"><img src="images/identity_opposite.jpg" width="150" height="110" alt=""/></a></li>
                          </ul>
                      </div>
                      <!--上传按钮-->
                      <div class="shangchuan_btn01" id="idcard" style="width:88px;line-height:10px;position:absolute;left:0;top:165px"><a ></a></div>
                      <div class="shangchuan_btn01 basicInformation_downUpdate" id="idcardback" style="width:88px;line-height:10px;position:absolute;left:180px;top:165px"><a ></a></div>
                      
                     <?php endif;?>
                      
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
                          <p>复印件请务必加盖组织机构公章,支持.jpg .jpeg .bmp .gif .png格式照片，大小不超过2M。<a class="attorney_example" onclick="attorney()">查看示例</a></p>
                          <!--上传法人授权委托书后显示图片div 未上传前display＝none-->
                          <?php if(isset($detail['proxy_img'])&&$detail['approval_status']==1): ?>
                              
                              <div class="yingyezhizhao_img" >
                              <?php if(isset($detail['proxy_img'])): ?>
                              <a href="<?php echo isset($detail['proxy_img'])?$detail['proxy_img']:'' ?>" target="_blank">
                                  <img src="<?php echo isset($detail['proxy_img'])?$detail['proxy_img']:'' ?>" width="150" height="110" alt=""/>
                              </a>
                              <?php endif;?>
                              </div>
                            <!--上传按钮-->
                                <!-- <div class="shangchuan_btn01" id="proxy" style="width:88px;line-height:10px;position:absolute;left:0;top:185px"><a></a></div>-->
                          <?php else: ?>
                              <!--上传按钮-->
                             
                          
                              <div class="yingyezhizhao_img clearfix" style="display:block">
                                  <ul>
                                      <li><a class="attorney_img" id="proxy_img"><img src="images/Power_of_attorney.jpg" width="150" height="110" alt=""/></a></li>
                                  </ul>
                              </div>
                              <!--上传按钮-->
                              <div class="shangchuan_btn01" id="proxy" style="width:88px;line-height:10px;position:absolute;left:0;top:165px"><a></a></div>
                         <?php endif; ?>
                      </div>
                  </div>
              </div>
              <!--法人授权委托书 结束-->
              <?php if(isset($detail['bus_licence_img'])&&!strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==0): ?>

                <?php elseif(isset($detail['bus_licence_img'])&&strpos($detail['bus_licence_img'],';')&&$detail['approval_status']==0):?>
                
                <?php else:?>
              <!--提交按钮 开始-->
              <div class="regsiter_02_btn basicInformation_downBtn"><a href="javascript:sub(this);">提交</a></div>
              <span id="er" style="float:left;margin: -35px 0px 0px 600px;color:red;display:none"></span>
              <!--提交按钮 结束-->
              <?php endif;?>
              </div>
              <!--修改认证内容tab2 结束-->
              </div>
               
            </div>
          </div>          
                    
       </div>


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

    <div class="dingdan4_3_tanchuang" <?php if(isset($types)&&$types==10){echo 'style="display:show"';}elseif(isset($types)&&$types==11){echo 'style="display:show"';}else{echo 'style="display:none"';} ?>>
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">温馨提示</div>
          <div class="dingdan4_3_tanchuang_top2">
          <?php if(isset($types)&&$types==10): ?>
              <p>您的资料已提交成功，</p>
              <p>我们会在2～3个工作日内给您答复，请耐心等候。</p>
          <?php elseif(isset($types)&&$types==11): ?>
               <p>您的资料已保存成功，</p>
               <p>请返回页面。</p>
          <?php endif; ?>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
                        <div class="dingdan4_3_btn01" style=" float:right; margin-right:20px;"><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">确定</a></div>
                        
          </div>
          
      </div>
	</div>
    
    
    
    <div class="dingdan4_3_tanchuang" id="sure1" style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">修改店铺名称 <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
      <div class="dingdan4_3_tanchuang_top2">
          <p>你的店铺名称修改申请已提交审核</p>
          <p>客服将在24小时内为您进行处理</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn" style="padding-top:20px; height:50px">
          <div class="dingdan4_3_btn02" style="margin:0px auto; float:none;"><a href="javascript:void(0);" id="sure" onclick="">确定</a></div>       
      </div>
  </div>
</div>
 <script>
 </script>
  <script type="text/javascript">
<!--
/*

* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;

* 其他参数同WebUploader

*/

//上传店铺图片
$('#test').diyUpload({
	
	url:'<?php echo site_url('corporate/myshop/file_upload');?>',
	type:'post',
	beforeSend:function(){
		$('#test').hide();
	},
	success:function( data ,status) {
		console.info( data );
		if(data){
		    $('#img').html('<img src="'+data.img_url+'" width="150" height="150" alt=""/>');
		    $('#QR_code').attr('src',data.QR_code);
		    $('#test').next('div').remove();	  
		    test_two();
		    $('#test').show();
		}
	},
	error:function( err ) {
		console.info( err );
		test_two();
		$('#test').show();	
	},
	buttonText : '上传图片',
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
	fileSizeLimit:10240000,
	fileSingleSizeLimit:10240000,
	accept: {extensions :"image,jpeg,jpg,bmp,png"},
});
//新营业照
$('#news').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/1');?>',
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
	buttonText : '更换文件',
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
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/2');?>',
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
	buttonText : '更换文件',
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
$('#olds2').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/3');?>',
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
	buttonText : '更换文件',
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
$('#olds3').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/4');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#olds3").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#old3').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
	    $('.parentFileBox').remove();
	    old3_two();
	    $('#olds3').show();
	},
	error:function( err ) {
		console.info( err );
		old3_two();	
	},
	buttonText : '更换文件',
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

$('#idcard').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/5');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#idcard").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#idcard1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#idcard').next('div').remove();	  
	    idcard1_two();
	    $('#idcard').show();
	},
	error:function( err ) {
		console.info( err );
		idcard1_two();	
	},
	buttonText : '更换正面',
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
$('#idcardback').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/6');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#idcardback").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#idcard2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#idcardback').next('div').remove();	  
	    idcard2_two();
	    $('#idcardback').show();
	},
	error:function( err ) {
		console.info( err );
		idcard2_two();	
	},
	buttonText : '更换反面',
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

$('#proxy').diyUpload({
    
	url:'<?php echo site_url('corporate/myshop/authenticate_img/7');?>',
	success:function( data ) {
		console.info( data );
		var datasrc = $("#proxy").next('div').children('ul').children('li').children('div').children('img').attr('src');
		$('#proxy_img').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
		$('#proxy').next('div').remove();	  
	    proxy_two();
		$('proxy').show();
	},
	error:function( err ) {
		console.info( err );
		proxy_two();	
	},
	buttonText : '更换文件',
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
function test_two(){
	$('#test').diyUpload({
		
		url:'<?php echo site_url('corporate/myshop/file_upload');?>',
		type:'post',
		beforeSend:function(){
			$('#test').hide();
		},
		success:function( data ,status) {
			console.info( data );
			if(data){
			    $('#img').html('<img src="'+data.img_url+'" width="150" height="150" alt=""/>');
			    $('#test').next('div').remove();	  
			    test_two();
			    $('#test').show();
			}
		},
		error:function( err ) {
			console.info( err );
			test_two();
			$('#test').show();	
		},
		buttonText : '上传图片',
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
		fileSizeLimit:10240000,
		fileSingleSizeLimit:10240000,
		accept: {extensions :"image,jpeg,jpg,bmp,png"},
	});
}
function new_two(){
	$('#news').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/1');?>',
		success:function( data ) {
			console.info( data );
			var datasrc = $("#news").next('div').children('ul').children('li').children('div').children('img').attr('src');
			$('#new_img').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
			$('#news').next('div').remove();	  
		    new_two();
			$('#news').show();
			
		},
		error:function( err ) {
			console.info( err );
			new_two();	
		},
		buttonText : '更换文件',
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
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/2');?>',
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
		buttonText : '更换文件',
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
function old2_two(){
	$('#olds2').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/3');?>',
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
		buttonText : '更换文件',
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

function old3_two(){
	$('#olds3').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/4');?>',
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
		buttonText : '更换文件',
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
function idcard1_two(){
	$('#idcard').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/5');?>',
		success:function( data ) {
			console.info( data );
			var datasrc = $("#idcard").next('div').children('ul').children('li').children('div').children('img').attr('src');
			$('#idcard1').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
			$('#idcard').next('div').remove();	  
		    idcard1_two();
		    $('#idcard').show();
		},
		error:function( err ) {
			console.info( err );
			idcard1_two();	
		},
		buttonText : '更换正面',
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
function idcard2_two(){
	$('#idcardback').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/6');?>',
		success:function( data ) {
			console.info( data );
			var datasrc = $("#idcardback").next('div').children('ul').children('li').children('div').children('img').attr('src');
			$('#idcard2').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
			$('#idcardback').next('div').remove();	  
		    idcard2_two();
		    $('#idcardback').show();
		},
		error:function( err ) {
			console.info( err );
			idcard2_two();	
		},
		buttonText : '更换反面',
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
function proxy_two(){
	$('#proxy').diyUpload({
	    
		url:'<?php echo site_url('corporate/myshop/authenticate_img/7');?>',
		success:function( data ) {
			console.info( data );
			var datasrc = $("#proxy").next('div').children('ul').children('li').children('div').children('img').attr('src');
			$('#proxy_img').html('<img src="'+datasrc+'" width="150" height="110" alt=""/>');
			$('#proxy').next('div').remove();	  
		    proxy_two();
			$('proxy').show();
		},
		error:function( err ) {
			alert(err);
			console.info( err );
			proxy_two();	
		},
		buttonText : '更换文件',
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

$('#test').children().next().css('width','100px');
$('#news').children().next().css('width','100px');

function submit(){
	
	var province_id = $("#province_id").val();
	var city_id = $("#city_id").val();
	var address = $("input[name=address]").val();
	if(province_id && city_id && address){
	 	$('#form1').submit();
	}else{
		alert('请填写正确的地址');
	}

}

function sub(o){
    $.ajax({
        url:"<?php echo site_url('customer/check_poto') ?>",
        type:"post",
        beforeSend:function(){
    	 $(o).html('提交中...');
    	},
    	success:function(data){
    	    if(data == 1){
    	       $('#er').html('请上传营业执照');
    	       $('#er').show();
    	   $(o).html('提交');
     	}else if(data == 2){
     		$('#er').html('请上传第一张旧营业执照');
    	    $('#er').show();
    	    $(o).html('提交');
        }else if(data == 3){
     		$('#er').html('请上传第二张旧营业执照');
    	    $('#er').show();
    	    $(o).html('提交');
        }else if(data == 4){
     		$('#er').html('请上传第三张旧营业执照');
    	    $('#er').show();
    	    $(o).html('提交');
        }else if(data == 5){
     		$('#er').html('请上传身份证正面照');
    	    $('#er').show();
    	    $(o).html('提交');
        }else if(data == 6){
     		$('#er').html('请上传身份证反面照');
    	    $('#er').show();
    	    $(o).html('提交');
        }else if(data == 7){
     		$('#er').html('请上传法人授权委托书');
    	    $('#er').show();
    	    $(o).html('提交');
        }else{
        	document.location = 'index.php/corporate/myshop/authenticate_save';
            $(o).html('提交');
            $('#er').hide();
        }
    },
    });
}


//-->
</script>   
<script>

      $("#dianpu-xiugai-lei").on("click",function(){
		$('.dianpu-xiugai-sh').show();
		 $('.dianpu-xiugai1').hide();
		})
		$('.icon-guanbi').click(function(){
			 $('#sure1').hide();
			
			})
	$('#sure').click(function(){
			 $('#sure1').hide();
			
			})
	$('#queding').click(function(){
			 $('#sure1').show();
			
			})
	$('.dianpu-xiugai-rgth').click(function(){
			 $('.dianpu-xiugai-sh').hide();
			  $('.dianpu-xiugai1').show();
			
			})							
		
	//点击企业营业执照Bussiness_license示例，弹出层仅编辑标题内容
	$('.Bussiness_license_example').click(function(){
		$('.fancybox_license_example').show();
	});
	//点击取消fancybox_back_license按钮，弹出层内容消失
	$('.fancybox_back_license_example').click(function(){
		$('.fancybox_license_example').hide();
	});
	
	//点击企业营业执照Bussiness_license图片，弹出层仅编辑标题内容
	/*$('.Business_license_img').click(function(){
		$('.fancybox_license_img').show();
	});
	//点击取消fancybox_back_license按钮，弹出层内容消失
	$('.fancybox_back_license_img').click(function(){
		$('.fancybox_license_img').hide();
	});*/
	
	//点击法人身份证dentity示例，弹出层仅编辑标题内容
	$('.identity .identity_example').click(function(){
		$('.fancybox_identity_example').show();
	});
	//点击取消fancybox_back_identity按钮，弹出层内容消失
	$('.fancybox_back_identity_example').click(function(){
		$('.fancybox_identity_example').hide();
	});


    //点击身份证identity_front图片正面，弹出层仅编辑标题内容
	/*$('.identity .identity_img_front').click(function(){
		$('.fancybox_identity_front').show();
	});
	//点击取消fancybox_back_identity按钮，弹出层内容消失
	$('.fancybox_back_identity_front').click(function(){
		$('.fancybox_identity_front').hide();
	});
	
	//点击身份证identity_opposite图片反面，弹出层仅编辑标题内容
	$('.identity .identity_img_opposite').click(function(){
		$('.fancybox_identity_opposite').show();
	});
	//点击取消fancybox_back_identity按钮，弹出层内容消失
	$('.fancybox_back_identity_opposite').click(function(){
		$('.fancybox_identity_opposite').hide();
	});*/
	
	//点击授权书attorney_example示例，弹出层仅编辑标题内容
	//$('.attorney_example').click(function(){
	function attorney(){
		$('.fancybox_attorney_example').show();
	}
	//});
	//点击取消fancybox_back_attorney_example按钮，弹出层内容消失
	//$('.fancybox_back_attorney_example').click(function(){
	function back_attorney(){
		$('.fancybox_attorney_example').hide();
	}
	//});
	
	//点击授权书Bussiness_attorney_img图片，弹出层仅编辑标题内容
	/*$('.attorney .attorney_img').click(function(){
		$('.fancybox_attorney_img').show();
	});
	//点击取消fancybox_back_attorney_img按钮，弹出层内容消失
	$('.fancybox_back_attorney_img').click(function(){
		$('.fancybox_attorney_img').hide();
	});*/

	//点击旧版营业执照税务证	
	//点击税务登记证fancybox_Tax_img图片，弹出层内容
	/*$('.old_bussiness').click(function(){
		$('.fancybox_tax_img').show();
	});
	//点击取消fancybox_back_tax_img按钮，弹出层内容消失
	$('.fancybox_back_tax_img').click(function(){
		$('.fancybox_tax_img').hide();
	});
	//点击组织代码机构证fancybox_organization_img图片，弹出层内容
	$('.old_bussiness .organization_img').click(function(){
		$('.fancybox_organization_img').show();
	});
	//点击取消fancybox_back_organization_img按钮，弹出层内容消失
	$('.fancybox_back_organization_img').click(function(){
		$('.fancybox_organization_img').hide();
	});
	//点击旧版营业执照证fancybox_Business_license_img图片，弹出层内容
	$('.old_bussiness .Business_license_img').click(function(){
		$('.fancybox_Business_license_img').show();
	});
	//点击取消fancybox_back_Business_license_img按钮，弹出层内容消失
	$('.fancybox_back_Business_license_img').click(function(){
		$('.fancybox_Business_license_img').hide();
	});*/
	
	
	//点击旧版营业执照示例fancybox_oldBusiness_example
	//点击税务登记证fancybox_oldBusiness_example图片，弹出层内容
	//$('.oldBusiness_example').click(function(){
	function oldbusiness(){
		$('.fancybox_oldBusiness_example').show();
	}
	//});
	//点击取消fancybox_back_tax_img按钮，弹出层内容消失
	//$('.fancybox_back_oldBusiness_example').click(function(){
	function back_oldbus(){
		$('.fancybox_oldBusiness_example').hide();
	}
	//});
</script>
<script>
//地图显示
function region(){
	var province = $("#province_id").find("option:selected").text();
	var city = $("#city_id").find("option:selected").text();
	var district = $("#district_id").find("option:selected").text();
	var address = $("input[name=address]").val();
    if(province=='省份' || city=='城市' || address==''){
        $("#baidu_api").hide();
    	}else{
    		$("#baidu_api").show();
    		if(district=='县/区'){
    			$("#baidu_api").attr("href","http://api.map.baidu.com/geocoder?address="+province+city+address+"&output=html&src=yourCompanyName|yourAppName");
    			}else{
    				$("#baidu_api").attr("href","http://api.map.baidu.com/geocoder?address="+province+city+district+address+"&output=html&src=yourCompanyName|yourAppName");
    				}
    }
}
</script>

