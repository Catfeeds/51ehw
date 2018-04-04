<style>
    body{background-color:#fff}
    .tribal_avatar {padding-top: 30px;}
    .set_tribe_input {border-bottom: 1px solid #ddd;margin: 30px 12% 0 12%;}
    .set_tribe_input input {text-align: left;}
    .select-value {height: auto;line-height: normal;}
    .new_tribe_input {border-bottom: none!important;display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: box;}
    .set_tribe_input span {font-size: 15px;color: #666;display: inline-block;vertical-align: sub;}
    .new_tribe_input input {box-sizing: border-box;box-flex: 1;-webkit-box-flex: 1;-moz-box-flex: 1;-ms-flex: 1;width: 100%;display: block;border-bottom: 1px solid #ddd;padding-bottom: 0;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>创建部落</span>
</div>
<?php }?>
    <form method="post" action="<?php echo !empty($tribe)?site_url("tribe/update"):site_url("tribe/create");?>" enctype="multipart/form-data">
     <?php if(!empty($tribe)){;?>
     <input type="hidden" name="tribe_id" value="<?php echo $tribe_id;?>" >
     <?php };?>
     <!-- 第一步 -->
     <div class="tribal_avatar"  id="next_step1">
        <div class="tribal_avatar_top">
            <h3>部落名称</h3>
            <div class="set_tribe_input">
              <input type="text" name="name" value="<?php echo !empty($tribe)?$tribe["name"]:null;?>" placeholder="填写部落名称，不超过10个字"  maxlength="10" required="required"  onkeyup="this.value=this.value.replace(/\s/g,'')">
            </div>
        </div>
     </div>
     <!-- 第二步 -->
    <div class="tribal_avatar_top tribal_avatar" id="next_step2" hidden>
        <h3>部落头像</h3>
        <div class="tribal_avatar_top_sh">
            <!--上传图片-->
            <div class="upload_pictures">
                <div class="upload_pictures_top">
                    <div class="stored_chong_xia_z">  
                        <div class="stored_chong_top">                
                            <div class="icon-zhaopianshangchuan">
                                <input type="file" name="logo" onchange="previewImg(this,'#thubm')" accept="image/*" multiple> 
                            </div>
                        </div>
                        <h2 class="stored_chong_h2"><img src="<?php echo !empty($tribe)?IMAGE_URL.$tribe["logo"]:"images/tongming.png";?>" id="thubm"></h2>
                    </div>
                </div>  
            </div>
          <p class="tribal_avatar_top_p">添加一张有代表性的图片作为部落头像</p>
        </div>
    </div> 
    
     
    
    <!-- 第三步 -->
    <div class="tribal_avatar" id="next_step3" hidden>
        <!-- 所属行业 -->
        <div class="set_tribe_input new_tribe_input">
            <span>行业：</span>
            <input type="text" name="industry" value="<?php echo !empty($tribe)?$tribe["industry"]:null;?>" placeholder="请填写所属行业" required="required">
        </div>
        <!-- 地区 -->
        <div class="set_tribe_input new_tribe_input">
            <span>地区：</span>
            <input type="text" class="select-value" name="region" placeholder="请选择地区" value="<?php echo !empty($tribe)?$tribe["provice"]."-".$tribe["city"]:null;?>" required="required">
        </div>
        <!-- 简介 -->
        <div class="set_tribe_jianjie">
            <p>简介</p><textarea name="content" maxlength="" class="wordNumber_text" placeholder="请填写部落简介"><?php echo !empty($tribe)?$tribe["content"]:null;?></textarea>
            <!-- <span id="wordNumber" class="set_tribe_jianjie_num">150</span> -->
        </div>
    </div>





    <!-- 按钮 -->
    <div class="tribal_avatar_bottom">
      <ul class="tribal_avatar_bottom_ul">
        <li><a class="tribal_avatar_top_a" href="javascript:void(0);" onclick="next_step(1);" id="next_step">下一步</a></li>
        <!-- <li><a class="tribal_avatar_top_a" href="#">提交申请</a></li> -->
        <li><a class="tribal_avatar_bottom_a" href="javascript:void();" id="back" onclick="history.back();">返回</a></li>
      </ul>
    </div>
    <!-- 页数 -->
    <div class="tribal_avatar_dibu" id="page">1/3</div>
    </form>



<script src="js/liandong.js"></script>
<script type="text/javascript">
//检测输入内容字数的变化
$(".wordNumber_text").on("input propertychange",function(){
    var t = 150 - $(this).val().length;
    $("#wordNumber").text(t);
})


//图片上传预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();
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
            $(input).parents(".icon-zhaopianshangchuan").css("color","#fff").css("background","rgba(0,0,0,0.4)");
            //上传部落图片
            if(obj == "#thubm01"){
            	$("#yijji").css("color","#fff").html('重新上传部落封面');
            }
            
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

//---------------------------------------------------------

//下一步
function next_step(number){
	switch(number){
    	case 1:
    		var name = $("input[name=name]").val();
    		if(name){
        		$.post("<?php echo site_url("tribe/ajax_check_name/".(!empty($tribe)?$tribe["id"]:null));?>",{name:name},function(data){
        		    if(data["status"] != 2){
        		    	$(".black_feds").text('该部落名称已被使用').show();
        		    	setTimeout("prompt();", 600); 
        		    }else{
        		    	next(number);
        		    }
        		},"json")
    		}else{
    			$(".black_feds").text('请填写部落名称').show();
		    	setTimeout("prompt();", 600); 
    		}
    		break;
    	case 2:
        	var image = $("#thubm").attr("src");
        	if(image == "images/tongming.png"){
        		$(".black_feds").text('请上传部落头像').show();
		    	setTimeout("prompt();", 600); 
        	}else{
		    	next(number);
		    }
        	break;
    	case 3:
    		var region = $("input[name=region]").val();
    		var industry = $("input[name=industry]").val();
    		var content = $("textarea[name=content]").val();
    	    if(!region || !industry){
    	    	$(".black_feds").text('请填写相关信息').show();
		    	setTimeout("prompt();", 600); 
    	    }else{
    	    	next(number);
    	    }
        	break;
	}

}
//下一步->附属方法
function next(number){
	if(number == 3){
		 $("form").submit();return;
	}
	
	if(number == 2){
		$("#next_step").text("提交申请");
	}else{
		$("#next_step").text("下一步");
	}
	
	$(".tribal_avatar").hide();
    $("#next_step"+(number*1+1*1)).show();
    $("#next_step").attr("onclick",'next_step('+(number*1+1*1)+')');
    $("#back").attr("onclick",'Goback('+number+')');
    $("#page").text((number*1+1*1)+"/3");//页数
}

//返回
function Goback(number){
	$("#next_step").text("下一步");
	if(number == 0){
		history.back();
		return;
	}
	$(".tribal_avatar").hide();
    $("#next_step"+number).show();
    $("#next_step").attr("onclick",'next_step('+number+')');
    $("#back").attr("onclick",'Goback('+(number-1)+')');
    $("#page").text(number+"/3");//页数

}

// ---------------------------------------------------------


</script>





