<link rel="stylesheet" type="text/css" href="js/styles/simditor.css" /><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/module.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/hotkeys.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/uploader.js"></script><!-- 富文本编辑器插件 -->
<script type="text/javascript" src="js/styles/simditor.js"></script><!-- 富文本编辑器插件 -->
<style>
    body{background-color:#f6f6f6}
    .release_pictures_top{ padding-right:0}
    .publish_notice_xia {margin-bottom: 0;}
</style>
    <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
    <form>
    <span id="table">
    <div class="container container_topd" style="padding-bottom: 70px;">
        <!--开始-->
        <div class="release_pictures_io">
            <div class="release_pictures_t">
                <input type="text" id="topic" class="search_opo" name="title" value="<?php echo $info?$info["title"]:null;?>" maxlength="35" placeholder="公告标题">
            </div>
            <div class="release_pictures_top">    
                <textarea class="example_top" id="editor" placeholder="请输入公告详情(1000字内)" autofocus></textarea>
                <textarea name="content" hidden></textarea>
            </div>
        </div>
        <!--公告封面图-->  
        <div class="publish_notice_xia">
            <h3>公告封面图</h3>
                <!--上传图片-->
            <div class="upload_pictures">
                <div class="upload_pictures_top">
                    <div class="stored_chong_xia_z">  
                        <div class="stored_chong_top">                
                            <div class="icon-zhaopianshangchuan">
                                <input type="file" name="title_img" onchange="previewImg(this,'#thubm')"> 
                                <h5 class="yijji">添加公告封面</h5>
                            </div>
                        </div>
                        <h2 class="stored_chong_h2"><img src="<?php echo $info?IMAGE_URL.$info["title_img"]:"images/tongming.png";?>" id="thubm"></h2>
                    </div>
                </div>  
            </div>
        </div>  
        
        <!-- 发布短信通知 -->
        <div class="publish_inform publish_inform_fabu"><a href="javascript:void(0);"><span>发布短信通知</span><input type="checkbox" name="on_off" value="1" <?php echo !empty($info["sendee_id"])?"checked":null;?> class="icon-kaiguan1 icon-kaiguan <?php echo !empty($info["sendee_id"])?"publish_inform_active icon-kaiguan":null;?>"></a></div>    

        <!-- 接收人员 -->
        <div class="publish_accept" <?php echo !empty($info["sendee_id"])?null:'style="display: none;"';?>><a href="javascript:void(0);" onclick="toggles();"><span>接收人员</span><em class='icon-right'></em></a></div>
        
        <!-- 是否公开 -->
        <div class="publish_inform publish_inform_gongkai" style="border-top: none;"><a href="javascript:void(0);"><span>是否公开</span><input type="checkbox" name="display" value="1" <?php echo !empty($info["display"]) ? "checked" :null;?> class="icon-kaiguan <?php echo !empty( $info['display'] ) ? 'publish_inform_active' : 'icon-kaiguan1' ?>"></a></div>    
    
        <a href="javascript:void(0)" class="circle_publish_jia custom_button" onclick="submitform();">保存</a> 
    </div>  
    
</span>

<?php $this->load->view('commerce/commerce_message_people');?>
</form>


<script type="text/javascript">
$(function(){
	//富文本编辑器
	toolbar = [ 'title', 'bold', 'italic', 'underline', 'strikethrough',
				'color','ol', 'ul', 'blockquote', 'code', 'table',
				'link', 'image', 'hr','indent', 'outdent' ];
	editor = new Simditor( {
		textarea : $('#editor'),
		placeholder : '请输入公告详情(1000字内)',
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


	<?php if($info){;?>
    var content = '<?php echo str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$info["content"]));?>';
    editor.setValue(content);
    
    $("#thubm").css("width","100%");
	$("#thubm").css("height","100%");
	$(".stored_chong_top .icon-zhaopianshangchuan").css("color","#fff");
	$(".stored_chong_top .icon-zhaopianshangchuan").css("background","rgba(0,0,0,0.4)");
	$(".yijji").html('重新上传公告封面');
	$(".yijji").css("color","#fff");
    <?php };?>

    // 点击发布短信通知
    $('.publish_inform_fabu a').on('click',function(){
		$(this).children('input').toggleClass('icon-kaiguan1'); 
        $(this).children('input').toggleClass('publish_inform_active');
		$(".publish_accept").toggle();
    })
})

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
			$(".yijji").html('重新上传公告封面');
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
    var title = $("input[name=title]").val();//标题
    var content = $("textarea[name=content]").text();//内容
    var title_img = $("#thubm").attr("src");
    var id = "<?php echo $info?$info["id"]:null;?>";//公告id
    //数据验证
    if(title.length < 1){
    	$(".black_feds").text('标题不能空').show();
		setTimeout("prompt();", 700); return;
    }else if(content.length < 1){
    	$(".black_feds").text('请输入公告详情').show();
		setTimeout("prompt();", 700); return;
    }else if(title_img == "images/tongming.png"){
    	$(".black_feds").text('请上传公告封面图').show();
		setTimeout("prompt();", 700); return;
    }
    //ajax提交表单
    $.ajax({
        url : "<?php echo site_url("tribe/ajax_save_notice");?>/"+id,
        type : "post",
        cache : false,
	    data: new FormData($('form')[0]),
	    processData: false,
	    contentType: false,
	    dataType:"json"
    }).done(function(res) {
        if(res["status"] != 2){
        	$(".black_feds").text('发布公告失败').show();
    		setTimeout("prompt();", 700); return;  
        } 
       location.href="<?php echo site_url("Tribe/tribe_announcements_view");?>";
	}).fail(function(res) {
    	$(".black_feds").text('发布公告失败').show();
		setTimeout("prompt();", 700); return;
	});
	
}

//接收人列表
function toggles(){
	$("#table").toggle();
	$("#SendeeList").toggle();
}
  
// 点击是否公开
    $('.publish_inform_gongkai a').on('click',function(){
        $(this).children('input').toggleClass('icon-kaiguan1'); 
        $(this).children('input').toggleClass('publish_inform_active');
    })  

</script>