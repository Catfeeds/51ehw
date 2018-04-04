<link rel="stylesheet" type="text/css" href="js/styles/simditor.css" /><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/module.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/hotkeys.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/uploader.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/simditor.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/verification.js"></script><!-- 正则验证库 -->
<script type="text/javascript" src="js/Public.js"></script><!-- 正则验证库 -->
<style>
 body{background-color:#f6f6f6}
 .release_pictures_top{ padding-right:0}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>编辑活动</span>
</div>
<?php }?>
<form>
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="container container_topd" style="padding-bottom: 50px;">
    <!--开始-->
    <div class="release_pictures_io">
        <div class="release_pictures_t">
            <input type="text" id="topic" class="search_opo" name="name" value="<?php echo $activity?$activity["name"]:null;?>" maxlength="35" placeholder="活动标题">
        </div>
        <div class="release_pictures_top">    
            <textarea class="example_top" id="editor" placeholder="请输入活动详情(1000字内)" autofocus></textarea>
            <textarea name="content" hidden></textarea>
        </div>
    </div>
    <!--有效期-->
    <ul class="publish_notice_ul" >
        <li>
        <div class="publish_notice_ul_sh">
            <span class="zhong_lei">有效期</span>
            <div class="publish_notice_ul_zhong">
                <div class="zhong_fig"> 
                    <input value="<?php echo $activity?mb_substr($activity["start_time"],0,10):null;?>" class="" readonly name="start_time" id="appDate" placeholder="开始时间" type="text">
                    <samp>至</samp>
                    <input value="<?php echo $activity?mb_substr($activity["end_time"],0,10):null;?>" class="" readonly name="end_time" id="appDate1" placeholder="结束时间" type="text">
                </div>
            </div> 
        </div>
        </li>
    </ul>
    <!--活动封面图-->  
    <div class="publish_notice_xia" style="margin-bottom: 0;">
      <h3>活动封面图</h3>
    <!--上传图片-->
    <div class="upload_pictures">
        <div class="upload_pictures_top">
        <div class="stored_chong_xia_z">  
            <div class="stored_chong_top">                
            <div class="icon-zhaopianshangchuan">
                <input type="file" name="banner_img" onchange="previewImg(this,'#thubm')"> 
                <h5 class="yijji">添加活动封面</h5>
            </div>
            </div>
            <h2 class="stored_chong_h2"><img src="<?php echo $activity?IMAGE_URL.$activity["banner_img"]:"images/tongming.png";?>" id="thubm"></h2>
        </div>
        </div>  
    </div>
     </div> 
    <!-- 是否公开 -->
     <div class="publish_inform publish_inform_gongkai" style="border-top: none;"><a href="javascript:void(0);"><span>是否公开</span><input type="checkbox" name="display" value="1" <?php echo !empty($activity["display"]) ? "checked" :null;?> class="icon-kaiguan <?php echo !empty( $activity['display'] ) ? 'publish_inform_active' : 'icon-kaiguan1' ?>"></a></div>    
    
     
    <a href="javascript:void(0)" class="circle_publish_jia custom_button" onclick="submitform();">保存</a>
</div>  
</form>
<input  value="" id="flag" hidden><!-- 防止提交成功返回继续编辑 -->
<script type="text/javascript">
$(function () {
	//防止提交成功返回继续编辑
	var flag = $("#flag").val();
	if(flag){
		history.back();return;
	}
	
	//时间插件
	var currYear = (new Date()).getFullYear();	
	var opt={};
	opt.date = {preset : 'date'};
	opt.datetime = {preset : 'datetime'};
	opt.time = {preset : 'time'};
	opt.default = {
		theme: 'android-ics light', //皮肤样式
        display: 'modal', //显示方式 
        mode: 'scroller', //日期选择模式
		dateFormat: 'yyyy-mm-dd',
		lang: 'zh',
		showNow: true,
		nowText: "今天",
        startYear: currYear - 10, //开始年份
        endYear: currYear + 10 //结束年份
	};
  	$("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
    $("#appDate1").mobiscroll($.extend(opt['date'], opt['default']));
  	var optDateTime = $.extend(opt['datetime'], opt['default']);
  	var optTime = $.extend(opt['time'], opt['default']);
    $("#appDateTime").mobiscroll(optDateTime).datetime(optDateTime);
    $("#appTime").mobiscroll(optTime).time(optTime);


    //富文本编辑器
	toolbar = [ 'title', 'bold', 'italic', 'underline', 'strikethrough',
				'color','ol', 'ul', 'blockquote', 'code', 'table',
				'link', 'image', 'hr','indent', 'outdent' ];
	editor = new Simditor( {
		textarea : $('#editor'),
		placeholder : '请输入活动详情(1000字内)',
		toolbarFloat: true,
		toolbarFloatOffset:0,
		imageButton:['upload'],
		pasteImage : true,
		toolbar : toolbar,  //工具栏
		upload : {
			url : '<?php echo site_url("tribe/editor_uploads");?>', //文件上传的接口地址
			params: null, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
			fileKey: 'file', //服务器端获取文件数据的参数名
			connectionCount: 3,
			leaveConfirm: '正在上传文件'
		}
	});

	<?php if($activity){;?>
        // var content = '<?php //echo preg_replace("/\n\r/","",$activity["content"]);?>';
        var content = '<?php echo str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$activity["content"]));?>';
        editor.setValue(content);
        
        $("#thubm").css("width","100%");
        $("#thubm").css("height","100%");
        $(".stored_chong_top .icon-zhaopianshangchuan").css("color","#fff");
        $(".stored_chong_top .icon-zhaopianshangchuan").css("background","rgba(0,0,0,0.4)");
        $(".yijji").html('重新上传活动封面');
        $(".yijji").css("color","#fff");
	<?php };?>


	

});


//封面上传图片预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader(),
            img = new Image();       
        reader.onload = function (e) {
            if(input.files[0].size>40307200){//图片大于300kb则压缩
                img.src = e.target.result;
                img.onload=function(){
                    $(obj).attr('src', compress(img));
                }
            }else{
                $(obj).attr('src', e.target.result);
            }
			$("#thubm").css("width","100%");
			$("#thubm").css("height","100%");
			$(".stored_chong_top .icon-zhaopianshangchuan").css("color","#fff");
			$(".stored_chong_top .icon-zhaopianshangchuan").css("background","rgba(0,0,0,0.4)");
			$(".yijji").html('重新上传活动封面');
			$(".yijji").css("color","#fff");
        }
        reader.readAsDataURL(input.files[0]);
        return 1;
    }  
}


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
    console.log(ndata.length)
    canvas.width = canvas.height = 0;
    return ndata;
}

//提交表单
function submitform(){
    $("textarea[name=content]").text(editor.getValue());//富文本编辑器赋值
    var today = TodayDate();//获得当前日期
    var name = $("input[name=name]").val();//标题
    var start_time = $("input[name=start_time]").val();//开始时间
    var end_time = $("input[name=end_time]").val();//结束时间
    var content = $("textarea[name=content]").text();//内容
    var banner_img = $("#thubm").attr("src");
    var activity_id = "<?php echo $activity?$activity["id"]:'';?>";//活动id


    //数据验证
    if(name.length < 1){
    	$(".black_feds").text('标题不能空').show();
		setTimeout("prompt();", 700); return;
    }else if(content.length < 1){
    	$(".black_feds").text('请输入活动详情').show();
		setTimeout("prompt();", 700); return;
    }else if(!validateDate(start_time) || !validateDate(end_time)){
    	$(".black_feds").text('请选择开始和结束时间').show();
		setTimeout("prompt();", 700); return;
    }else if(end_time > today ){
    	$(".black_feds").text('结束时间须大于等于发布活动的日期').show();
		setTimeout("prompt();", 700); return;
    }else if(start_time > end_time ){
    	$(".black_feds").text('结束时间必须大于开始时间').show();
		setTimeout("prompt();", 700); return;
    }else if(banner_img == "images/tongming.png"){
    	$(".black_feds").text('请上传活动封面图').show();
		setTimeout("prompt();", 700); return;
    }
    //ajax提交表单
    $.ajax({
        url : "<?php echo site_url("tribe/ajax_save_activity");?>/"+activity_id,
        type : "post",
        cache : false,
	    data: new FormData($('form')[0]),
	    processData: false,
	    contentType: false,
	    dataType:"json"
    }).done(function(res) {
        if(res["status"] != 2){
        	$(".black_feds").text('发布活动失败').show();
    		setTimeout("prompt();", 700); return;  
        } 
        $("#flag").val(1);//防止提交成功返回继续编辑
		location.href="<?php echo site_url("Tribe/Activity_management_view");?>/";
	}).fail(function(res) {
    	$(".black_feds").text('发布活动失败').show();
		setTimeout("prompt();", 700); return;
	});
	
}
 
 // 点击是否公开
    $('.publish_inform_gongkai a').on('click',function(){
        $(this).children('input').toggleClass('icon-kaiguan1'); 
        $(this).children('input').toggleClass('publish_inform_active');
    }) 

</script>
