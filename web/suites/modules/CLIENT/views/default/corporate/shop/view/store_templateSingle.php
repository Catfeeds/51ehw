<!doctype html>
<html>
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
<META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT">
<title><?php echo $this->session->userdata('app_info')['app_name'];?> - <?php echo $title;?></title>
<base href="<?php echo THEMEURL; ?>" />
<meta name="keyword"
	content="<?php echo $this->session->userdata('app_info')['seo_keyword'];?>">
<meta name="description"
	content="<?php echo $this->session->userdata('app_info')['seo_description'];?>">
<link rel="stylesheet" href="css/jquery.fullPage.css">
<link rel="stylesheet" type="text/css" href="css/fancymain.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<link href="css/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>

<style>
.section { text-align: center; font: 50px "Microsoft Yahei"; color: #fff;}
.sectionPic01,.sectionPic02{ width:1200px; margin:0 auto;}
</style>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>
<!--<script src="js/jquery.fullPage.min.js"></script>-->
<script src="js/ajaxfileupload.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
	$.fn.fullpage({
		slidesColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
		anchors: ['page1', 'page2', 'page3', 'page4', 'page5'],
		navigation: true,
		

	});
});
</script>

<title>51易货网</title>
</head>

<body>
<!--页头编辑 开始-->
<div class="store_headEdit" style="position:fixed; top:0;">
    <div class="store_headEdit_con">
        <div class="headEdit_btnLeft">
            <ul>
                <!--<li><a href="#" class="btn_pageEdit">页面编辑</a><li>
                <li><a href="#" class="btn_templateSelect">模版选择</a></li>
                <li><a href="javascript:;" class="addFloorBtn " onclick="add();">添加楼层</a></li>-->
                <li><a href="javascript:;" class="btn_pageEdit " onclick="add();">添加楼层</a></li>
                <?php  if(isset($corporate['grade']) && $corporate['grade'] > 1 ):?>
                    <?php // if(isset($corporate['grade']) && $corporate['grade'] ==2 ):?>
                    <?php  if($this->session->userdata['corporation_id'] == 157 ):?>
                <li><a href="<?php echo site_url('flagship/select_flagship_temp');?>" class="btn_pageEdit ">旗舰店模板</a></li>
                <li><a href="<?php echo site_url('flagship/flagship_two_temp');?>" class="btn_pageEdit ">旗舰店模板二</a></li>
                    <?php endif;?>
               <?php  if($this->session->userdata['corporation_id'] == 150 ):?>
               <li><a href="<?php echo site_url('flagship/flagship_three_temp');?>" class="btn_pageEdit ">旗舰店模板三</a></li>
               <?php endif;?>
                <li><a href="<?php echo site_url('corporate/myshop/select_goods_temp');?>" class="btn_pageEdit ">模板二</a></li>
                <li><a href="<?php echo site_url('corporate/myshop/select_three_temp');?>" class="btn_pageEdit ">模板三</a></li>
                <?php endif;?>
            </ul>
        </div>
        <div class="headEdit_btnRight" style="margin-right:-100px;">
            <ul>
                <li><a onclick="javascript:resetTemplate()" class="btn_pageSave">重置</a></li>
                <li><a href="<?php echo site_url('corporate/myshop/TemplatePreview/1')?>" target="_blank" class="btn_pagePreview">预览</a></li>
                <li><a onclick="javascript:publishTemp()" class="btn_pageRelease">发布</a></li>
            </ul>
        </div>
    </div>
</div>
<!--页头编辑 结束-->

<div class="section" style="background-color:<?php echo isset($le_1['desc'])?$le_1['desc']:'' ?>;">
	
    <!--页头开始-->
    <div class="store_head">
      <div class="store_head_con">
        	<a href="<?php echo site_url()?>" class="logo_set" title="51易货网"><img alt="51易货网" src="images/eh_logo.jpg"></a>       
        	<span class="store_head_span">店铺名称</span>
<!--         	<span>旗舰店会员</span> -->
        	<div class="store_head_search clearfix">
                <div class="store_head_search01">
                    <input class="store_head_input" type="text" placeholder="搜索内容">
                    <a href="" class="search_total_station">搜全站</a>
                </div>
<!--                 <div class="store_head_search02"><a href="">搜本店</a></div> -->
            </div>
      </div>
    </div> 
	<!--页头 结束-->
    
    <!--店铺头部 开始-->
	<div class="store_top hover_it" style="position:relative;">
    	<div class="store_top_con"><a href=""><img  id="banner" src="<?php echo isset($banner['id'])?IMAGE_URL.$banner['img_path']:'images/store_topBanner.png' ?>" width="" height="100" alt=""/></a>
    	<input type="hidden" id="banner_id" value="<?php echo isset($banner['id'])?$banner['id']:'' ?>"></div>
        <!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn">编辑</a></div>
        </div>
        <!--编辑区 结束-->
	</div>
    <!--店铺头部 结束-->
    
	<!--头部导航条 开始-->
    <div class="eh_navbar clearfix">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu">
                <!--左侧导航 start-->
                
                <!--中间导航 start-->
               
                <!--中间导航 end-->
            </div>
        </div>
    </div> 
    
    <div class="sectionPic02 hover_it" style="position:relative;">
    	<a href="javascript:;"><img id="img_head" src="<?php echo isset($le_1['img_path'])?IMAGE_URL.$le_1['img_path']:'images/store_banner1200.png' ?>" width="1200" alt=""/>
    	<input type="hidden" id="level1_id" value="<?php echo isset($le_1['id'])?$le_1['id']:'' ?>"></a>

    	<!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix">
                <a href="javascript:;" class="editBtn">编辑</a>
            </div>
        </div>
        <!--编辑区 结束-->    
    </div>
	<!--头部导航条 结束-->
  
</div>



<div id="page_body">
    <?php if(isset($level) && count($level)>0): ?>
    <?php foreach ($level as $l): ?>
    <div class="section" style="background-color:<?php echo $l['desc']?>">
    
    	<div class="sectionPic01 hover_it" style="position:relative;">
        	<a href="javascript:;"><img id="<?php echo isset($l['id'])?'l'.$l['id']:''?>" src="<?php echo isset($l['img_path'])?IMAGE_URL.$l['img_path']:'images/storeSingle_pic01.png' ?>" width="1200" alt=""/></a>
        	<!--编辑区 开始-->
            <div class="editCon">
                <div class="editBtnCon clearfix single_editBntCon">
                    <a href="javascript:;" class="editBtn" >编辑<input type="hidden" value="<?php echo isset($l['id'])?$l['id']:''?>"><input type="hidden" value="level_<?php echo isset($l['id'])?$l['id']:''?>"></a>
                    <a href="javascript:;" class="deleteBtn">删除</a>
                </div>
            </div>
            <!--编辑区 结束-->    
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <!-- <div class="section" style=" background: #fff;" >
    
    	<div class="sectionPic01 hover_it" style="position:relative;" id="model">
        	<a href="javascript:;"><img id="" src="images/storeSingle_pic01.png" alt=""/></a>
        	<!--编辑区 开始
            <div class="editCon">
                <div class="editBtnCon clearfix single_editBntCon">
                    <!-- <a href="javascript:;" class="editBtn" >编辑<input type="hidden" value="2"><input type="hidden" value="level_2"></a>
                    <a href="javascript:;" class="deleteBtn">删除</a>
                </div>
            </div>
            <!--编辑区 结束 
        </div>
    </div>-->
    <?php endif; ?>

    
</div>



<!--弹出层 fancybox-top 编辑头部图片 开始-->
<div class="fancybox-top" style="display:none"> 
    <div id="fancybox-loading" style="display: none;"><div></div></div>
    <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
    <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
        <!--弹窗头部 开始-->
        <div class="fancybox-head">编辑商品</div>
        <!--弹窗头部 结束-->
        <div id="fancybox-outer">
          <div id="fancybox-content" class="fancybox_con">
          <div style="width:auto;height:auto;overflow: auto;position:relative;">
          <div id="inline1" class="fancybox-inline1" >
            <div class="fancybox-editCon clearfix">
                <div class="fancybox-editCon-left">
                    <ul>
                        <li>上传商品图片：</li>
                        <li>商品链接地址：</li>
                    </ul>
                </div>
                <div class="fancybox-editCon-right">
                    <ul>
                        <li><!--  <a href="javascrip:;" class="fancybox-update">选择图片</a><span class="fancybox-singleSpan">图片尺寸: 1920X100 </span>--><input type="file" id="file1" name="file"><span class="">图片尺寸: 1920X100 </span></li>
                        <li><input class="fancybox-input" type="text" placeholder="链接须以http://开头,不允许添加51易货网外的链接" id="link_path"><input type="hidden" id="banner_1" value="banner_1"></li>
                    </ul>
                </div>
            </div>
          </div></div></div>
          <!--弹窗尾部 开始-->
          <div id="fancybox-title" class="fancybox-title-inside">
              <div id="fancybox-title-inside">
                <div class="fancybox-btn">
                    <a href="javascript:;" class="fancybox_back fancybox_back-top">取消</a>
                    <a href="javascript:upload();" class="fancybox_okay">确定</a>
                </div>
              </div>
          </div>
          <!--弹窗尾部 结束-->
      </div>
    </div>
</div>
<!--弹出层 fancybox-top 编辑仅图片 结束--> 


<!--弹出层 fancybox5 编辑删除 开始-->
<div class="fancybox5" style="display:none"> 
    <div id="fancybox-loading" style="display: none;"><div></div></div>
    <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
    <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
        <!--弹窗头部 开始-->
        <div class="fancybox-head">温馨提示</div>
        <!--弹窗头部 结束-->
        <div id="fancybox-outer">
          <div id="fancybox-content" class="fancybox_con">
          <div style="width:auto;height:auto;overflow: auto;position:relative;">
          <div id="inline1" class="fancybox-inline1" >
            <div class="fancybox-editCon clearfix">
                <p class="fancybox-delete">您真的要删除此内容吗？可以在新建楼层处重新添加喔！</p>
          </div></div></div>
          <!--弹窗尾部 开始-->
          <div id="fancybox-title" class="fancybox-title-inside">
              <div id="fancybox-title-inside">
                <div class="fancybox-btn" id="level_del">
                    <a href="javascript:;" class="fancybox_back fancybox_back5">取消</a>
                    <a href="javascript:;" class="fancybox_okay" onclick = "deleted(this);">确定</a>
                </div>
              </div>
          </div>
          <!--弹窗尾部 结束-->
      </div>
    </div>
</div>
</div>
<!--弹出层 fancybox5 删除 结束--> 

<!--弹出层 fancybox6 编辑仅图片 开始-->
<div class="fancybox6" style="display:none"> 
    <div id="fancybox-loading" style="display: none;"><div></div></div>
    <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
    <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
        <!--弹窗头部 开始-->
        <div class="fancybox-head">编辑商品</div>
        <!--弹窗头部 结束-->
        <div id="fancybox-outer">
          <div id="fancybox-content" class="fancybox_con">
          <div style="width:auto;height:auto;overflow: auto;position:relative;">
          <div id="inline1" class="fancybox-inline1" >
            <div class="fancybox-editCon clearfix">
                <div class="fancybox-editCon-left">
                    <ul>
                        <li>上传商品图片：</li>
                        <!-- <li>更改背景颜色：</li>-->
                        <li>商品链接地址：</li>
                    </ul>
                </div>
                <div class="fancybox-editCon-right">
                    <ul>
                        <li><!-- <a href="javascript:void(0);" class="fancybox-update">选择图片--> <input type="file" id="file" name="file" class="file"><!-- </a>--><span class="">图片尺寸：1200X810</span></li>
                        <!-- <li><input class="fancybox-input" type="text" placeholder="请输入十六进制颜色值：例子 #FEA33B" id="color"></li>-->
                        <li><input class="fancybox-input" type="text" placeholder="链接须以http://开头,不允许添加51易货网外的链接" id="link"></li>
                    </ul>
                </div>
            </div>
          </div></div></div>
          <!--弹窗尾部 开始-->
          <div id="fancybox-title" class="fancybox-title-inside">
              <div id="fancybox-title-inside" >
                <div class="fancybox-btn" id="level_sub">
                    <a href="javascript:;" class="fancybox_back fancybox_back6">取消</a>
                    <a href="javascript:;" class="fancybox_okay" onclick="level_1(this);">确定</a>
                </div>
              </div>
          </div>
          <!--弹窗尾部 结束-->
      </div>
    </div>
</div>
<!--弹出层 fancybox6 编辑仅图片 结束--> 

<!--弹出层 fancybox7 编辑仅图片 开始-->
<div class="fancybox7" style="display:none"> 
    <div id="fancybox-loading" style="display: none;"><div></div></div>
    <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
    <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
        <!--弹窗头部 开始-->
        <div class="fancybox-head">编辑商品</div>
        <!--弹窗头部 结束-->
        <div id="fancybox-outer">
          <div id="fancybox-content" class="fancybox_con">
          <div style="width:auto;height:auto;overflow: auto;position:relative;">
          <div id="inline1" class="fancybox-inline1" >
            <div class="fancybox-editCon clearfix">
                <div class="fancybox-editCon-left">
                    <ul>
                        <li>上传商品图片：</li>
                        <!--  <li>更改背景颜色：</li>-->
                        <li>商品链接地址：</li>
                    </ul>
                </div>
                <div class="fancybox-editCon-right">
                    <ul>
                        <li><!-- <a href="javascript:void(0);" class="fancybox-update">选择图片--><input type="file" id="file2" name="file2" class="file" value="选择图片"><!-- </a>--><span class="">图片尺寸：1200X500</span></li>
                        <!-- <li><input class="fancybox-input" type="text" placeholder="请输入十六进制颜色值：例子 #FEA33B" id="col"></li>-->
                        <li><input class="fancybox-input" type="text" placeholder="链接须以http://开头,不允许添加51易货网外的链接" id="link_p"></li>
                    </ul>
                </div>
            </div>
          </div></div></div>
          <!--弹窗尾部 开始-->
          <div id="fancybox-title" class="fancybox-title-inside">
              <div id="fancybox-title-inside">
                <div class="fancybox-btn">
                    <a href="javascript:;" class="fancybox_back fancybox_back7">取消</a>
                    <a href="javascript:;" class="fancybox_okay" onclick="header(this);">确定</a>
                </div>
              </div>
          </div>
          <!--弹窗尾部 结束-->
      </div>
    </div>
</div>
<!--弹出层 fancybox7 编辑仅图片 结束--> 

<script>

	//点击头部top banner编辑按钮，弹出层仅编辑图片内容
	$('.store_top .editBtn').click(function(){
		$('.fancybox-top').show();
	});
	//点击取消fancybox_back-top按钮，弹出层内容消失
	$('.fancybox_back-top').click(function(){
		$('.fancybox-top').hide();
	});
	

	
	//点击轮播图banner编辑按钮，弹出层编辑轮播图内容
	$('.carousel .editBtn').click(function(){
		$('.fancybox0').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back0').click(function(){
		$('.fancybox0').hide();
	});

	
	
	//点击右侧删除按钮，弹出层删除温馨提示内容
	$('.productfloor_right .deleteBtn,.sectionPic01 .deleteBtn').click(function(){
		DelW(this);
	});

    function DelW(o){
    	var html = '确定<p><input type="hidden" value="'+$(o).prev().children().val()+'"></p>';
		$('#level_del').children().next('a').html(html);
		$('.fancybox5').show();
    }
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back5').click(function(){
		$('#level_del').children().next('a').html('确定');
		$('.fancybox5').hide();
	});
	

	
	//点击单品店铺商品图片编辑按钮，弹出层编辑图片背景颜色链接地址内容
	$('.sectionPic01 .editBtn').click(function(){
			EditWin(this);
	});

	function EditWin(o){
		var html = '确定<p><input type="hidden" value="'+$(o).children().val()+'"><input type="hidden" value="'+$(o).children().next().val()+'"></p>';
		$('#level_sub').children().next('a').html(html);
		$('.fancybox6').show();
	}
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back6').click(function(){
		$('#level_sub').children().next('a').html('确定');
		$('.fancybox6').hide();
	});
	
	//点击单品店铺商品图片编辑按钮，弹出层编辑图片背景颜色链接地址内容
	$('.sectionPic02 .editBtn').click(function(){
		$('.fancybox7').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back7').click(function(){
		$('.fancybox7').hide();
	});

	function add(){
		
	    if($('#page_body').children().length<10 && $('#page_body').children().length>=0){
	    //var level = 'level_'+($('#page_body').children().length+1);
		var html = '';
    	    $.ajax({
    	        url:'<?php echo site_url('corporate/myshop/add_template') ?>',
    	        type:'post',
    	        //data:{level:level},
    	        success:function(data){
        	        	var html='<div class="section" >'+
    		             '<div class="sectionPic01 hover_it" style="position:relative;">'+
    		             '<a href=""><img id="l'+data+'"  src="images/storeSingle_pic01.png" width="1200" alt=""/></a>'+
    		             '<!--编辑区 开始-->'+
    		             '<div class="editCon">'+
    		             '<div class="editBtnCon clearfix single_editBntCon">'+
    	                 '<a href="javascript:;" class="editBtn" onclick="EditWin(this);">编辑<input type="hidden" value="'+data+'"><input type="hidden" value="level_'+data+'"></a>'+
    	                 '<a href="javascript:;" class="deleteBtn" onclick="DelW(this)">删除</a>'+
    	                 '</div>'+
    	                 '</div>'+
    	                 '<!--编辑区 结束-->'+   
    	                 '</div>'+
    	                 '</div>';
    	            	$('#page_body').append(html);
    	            	//alert($('#page_body').html());
   	            	 $(window).resize(); 
    		    },
    		});

	    }else{
	        alert('模板不能超过10个');
		}
        
    }

    function upload(){ 
    	if ($("#file1").val().length > 0) {
    		
            ajaxFileUpload();
        }
        else {
            alert("请选择图片");
        }
        
    }

    
    
    function ajaxFileUpload() {
    	var link_path = $('#link_path').val();
        var banner_1 = $('#banner_1').val();
        var id = $('#banner_id').val();
        if(link_path != '')
            if(!(/^http:\/\/(.*?)51ehw.com(.*?)$/.test( link_path ))){
            	alert('请输入正确的链接地址');
             	  return;
         	}
     	
        if(id){ var data = {link_path:link_path,banner_1:banner_1,id:id,};}
        else {var data = {link_path:link_path,banner_1:banner_1,};}
        //$.ajaxSetup ({ cache: false }); 
        $.ajaxFileUpload
        (
            {
            	url:'<?php echo site_url('corporate/myshop/upload_1')?>', //用于文件上传的服务器端请求地址 等待后台处理
                type: 'post',
                //data: { Id: '123', name: 'lunis' }, //此参数非常严谨，写错一个引号都不行
                secureuri: false, //一般设置为false
                fileElementId: 'file1', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                data:data,
                dataType: 'json', //返回值类型 一般设置为json
                success: function (data, status)  //服务器成功响应处理函数
                {
                   // alert(data);
                    //if(status == 'success'){
                    
                        $("#banner").attr("src", data.img_path);
                        
                        if(data.id){
                            $('#banner_id').val(data.id);    
                        }
                        $('.fancybox-top').hide();
                    //}
                    //alert("你请求的Id是" + data.Id + "     " + "你请求的名字是:" + data.name);
                    if (typeof (data.error) != 'undefined') {
                        if (data.error != '') {
                            alert(data.error);
                        } else {
                            alert(data.msg);
                        }
                    }
                },
                error: function (data, status, e)//服务器响应失败处理函数
                {
                    alert(e);
                }
            }
        )
        return false;
    }

    function header(o){

    	if ($("#file2").val().length > 0) {
        
    	var link_path = $('#link_p').val();
    	var level = 'level_1';
    	var id = $('#level1_id').val();
    	var color = $('#col').val();
    	if(link_path != '')
            if(!(/^http:\/\/(.*?)51ehw.com(.*?)$/.test( link_path )) ){
            	alert('请输入正确的链接地址');
             	  return;
         	}
    	if(id){ var data = {link_path:link_path,level:level,id:id,color:color};}
        else {var data = {link_path:link_path,level:level,color:color};}
    	$.ajaxFileUpload
        (
            {
            	url:'<?php echo site_url('corporate/myshop/upload_head')?>', //用于文件上传的服务器端请求地址 等待后台处理
                type: 'post',
                //data: { Id: '123', name: 'lunis' }, //此参数非常严谨，写错一个引号都不行
                secureuri: false, //一般设置为false
                fileElementId: 'file2', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                data:data,
                dataType: 'json', //返回值类型 一般设置为json
                success: function (data, status)  //服务器成功响应处理函数
                {
                    //alert(status);
                    //if(status == 'success'){
                    
                        $("#img_head").attr("src", data.img_path);
                        $("#img_head").parent().parent().parent().css('background-color',data.color);
                        if(data.id){
                            $('#level1_id').val(data.id);
                        }                       
                        $('.fancybox7').hide();
                    //}
                    //alert("你请求的Id是" + data.Id + "     " + "你请求的名字是:" + data.name);
                    if (typeof (data.error) != 'undefined') {
                        if (data.error != '') {
                            alert(data.error);
                        } else {
                            alert(data.msg);
                        }
                    }
                },
                error: function (data, status, e)//服务器响应失败处理函数
                {
					alert(e);
                    //alert("jjjj");
                }
            }
        )
        return false;
    	}else{
    		alert("请选择图片");
        }
    	
    }

    function level_1(o){
       
    	if ($("#file").val().length > 0) {
        
    	var link_path = $('#link').val();
    	var id = $(o).children('p').children('input').val();
    	var level = $(o).children('p').children('input').next().val();
    	var color = $('#color').val();
    	if(link_path != '')
            if(!(/^http:\/\/(.*?)51ehw.com(.*?)$/.test( link_path ))){
            	alert('请输入正确的链接地址');
             	  return;
         	}
    	$.ajaxFileUpload
        (
            {
            	url:'<?php echo site_url('corporate/myshop/upload_level')?>', //用于文件上传的服务器端请求地址 等待后台处理
                type: 'post',
                //data: { Id: '123', name: 'lunis' }, //此参数非常严谨，写错一个引号都不行
                secureuri: false, //一般设置为false
                fileElementId: 'file', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                data:{link_path:link_path,id:id,level:level,color:color},
                dataType: 'json', //返回值类型 一般设置为json
                success: function (data, status)  //服务器成功响应处理函数
                {
                    //alert(status);
                    //if(status == 'success'){
                    
                        $("#l"+data.id+"").attr("src", data.img_path);
                        $('#model').remove();
                        $("#l"+data.id+"").parent().parent().parent().css('background-color',data.color);
                        $('.fancybox6').hide();
                    //}
                    //alert("你请求的Id是" + data.Id + "     " + "你请求的名字是:" + data.name);
                    if (typeof (data.error) != 'undefined') {
                        if (data.error != '') {
                            alert(data.error);
                        } else {
                            alert(data.msg);
                        }
                    }
                },
                error: function (data, status, e)//服务器响应失败处理函数
                {
                    alert(e);
                }
            }
        )
        return false;
    	}else{
    		alert("请选择图片");
        }
    	
    }

    function deleted(o){
        
    	var id = $(o).children('p').children('input').val();
    	$.ajax({
    	    url:"<?php echo site_url('corporate/myshop/deleted_temp') ?>",
    	    type:"post",
    	    data:{id:id},
    	    success:function(data){
    	        if(data){
    	            $("#l"+data).parent().parent().parent().remove();
    	            $('.fancybox5').hide();
    	            $(window).resize(); 
        	    }
        	}
        });
    }

	function publishTemp()
	{
		$.post("<?php echo site_url('corporate/myshop/Template/1')?>","",function(data){
		
			alert(data);
		});
	}

	function resetTemplate()
	{
		if(confirm("是否重置该模板?重置后,所有内容将会掉失!!"))
		{
			window.location = "<?php echo site_url('corporate/myshop/ResetTemplate')?>";
		}
	}
    
</script>

<style>
/*.fancybox-update {
    position: relative;
    display: inline-block;
    overflow: hidden;

}
.fancybox-update .file {
    position: absolute;
    font-size: 15px;
    right: 10px;
    top: 0;
    opacity: 0;
	height: 37px;
}*/
</style>

</body>
</html>