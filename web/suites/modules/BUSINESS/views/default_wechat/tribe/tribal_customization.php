<style>
    body{background-color:#fff}
    .stored_chong_h2 {height: auto!important;}
    .tribal_customization_top .stored_chong_xia_z {overflow: scroll!important;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>编辑部落资料</span>
</div>
<?php }?>
<form>
    <div class="container container_topd">
        <!--部落定制图片-->
        <div class="tribal_customization">
            <div class="tribal_customization_top">
            <!--上传图片-->
            <div class="upload_pictures">
                <div class="upload_pictures_top">
                    <div class="stored_chong_xia_z">  
                        <div class="stored_chong_top yincang">                
                            <div class="icon-zhaopianshangchuan">
                                <input type="file" name="<?php echo $type==2?"content_img1":"shop_img1";?>" onchange="previewImg(this,'#thubm')">
                                <?php if($type == 4):?>
                                    <h5 class="yijji">添加部落商城Banner图</h5>
                                <?php else:?>
                                <h5 class="yijji">添加部落定制图</h5>
                            <?php endif;?>
                            </div>
                        </div>
                        <h2 class="stored_chong_h2"><img src="<?php echo IMAGE_URL.($type == 2?$tribe["content_img"]:$tribe["shop_img"]);?>" id="thubm"></h2>
                    </div>
                </div>  
            </div>
            </div>
        </div>  
      
        <div class="tribal_customization_bottom">
            <a href="javascript:void(0);" onclick="ajax_submit(this);">保存</a>
            <a href="javascript:void(0);" class="tribal_customization_bottom_a">
                <input type="file" name="<?php echo $type==2?"content_img2":"shop_img2"; ?>" onchange="previewImg(this,'#thubm')"> 
                <h5 class="yijji">重新上传部落定制图</h5>
            </a>
        </div>
    </div>  
</form>
<script type="text/javascript">

$(".upload_pictures_top").css("height", $(window).height()-"110"+"px");
$(".tribal_customization_bottom_a").hide();
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
            $(".icon-zhaopianshangchuan").css("color","#fff");
			$(".yijji").css("color","#fff");
			$(".yijji").css("background","#000");
			$(".upload_pictures_top").css("border","none");
			$(".stored_chong_h2").css("position","inherit");
			$(".upload_pictures_top").css("height","");
			$(".tribal_customization").css("padding","0px 0px 60px 0px");
			$(".yincang").css("display","none");
			$(".tribal_customization_bottom_a").show();
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

/**
 * ajax修改部落信息
 */
function ajax_submit(obj){
	$(obj).removeAttr("onclick");
	var image = "<?php echo IMAGE_URL.($type == 2?$tribe["content_img"]:$tribe["shop_img"]);?>";
	var img = $("#thubm").attr("src");
    if(image != img){
        $.ajax({
            url : "<?php echo site_url("tribe/update");?>",
            type : "post",
            cache : false,
    	    data: new FormData($('form')[0]),
    	    processData: false,
    	    contentType: false,
    	    dataType:"json"
        }).done(function(res) {
            if(res["status"] == 1){
            	history.back();
            	$(obj).attr("onclick","ajax_submit(this)");
            }    
    	}).fail(function(res) {
    		document.location.reload(true);
    	});
    }else{
    	history.back();
    	$(obj).attr("onclick","ajax_submit(this)");
    }
    
}

	

</script>
