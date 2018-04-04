<?php
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>编辑部落</span>
</div>
<?php }?>
<style>
 body{background-color:#f6f6f6 }
 .container{background-color: transparent;}
 .edit_tribe_sh_ul_top_left{ display: block;}
 .edit_tribe_sh {margin-bottom: 0;}
 .more_til {right: 20px;bottom: 5px;}
  .tribe_jianjie_text {padding-bottom: 25px;}
</style>
    <form>
    <div class="container container_topd">
      <!--编辑部落-->
      <div class="edit_tribe">
         <div class="edit_tribe_top" hidden>
           <!--上传图片-->
          <div class="upload_pictures">
            <div class="upload_pictures_top">
                 <div class="stored_chong_xia_z">  
              <div class="stored_chong_top">                
               <div class="icon-zhaopianshangchuan">
               <input type="file" name="shop_img" onchange="previewImg(this,'#thubm')"> 
               <h5 class="yijji">轻触修改封面</h5></div>
               </div>
                <h2 class="stored_chong_h2"><img src="<?php echo $tribe?IMAGE_URL.$tribe["shop_img"]:"images/tribe_shop_default.png";?>" id="thubm"></h2>
                </div>
            </div>  
          </div>
         </div>  
        <!--部落头像-->
        <ul class="edit_tribe_sh">
        <li class="edit_tribe_sh_l">
            <a href="#">
                <input class="edit_tribe_sh_input" type="file" name="logo" onchange="previewImg(this,'#thubm1')"> 
                <div class="edit_tribe_sh_ul_top">
                    <span class="edit_tribe_sh_ul_top_left">部落头像</span>
                    <div class="edit_tribe_sh_ul_zhong">
                        <div class="edit_tribe_sh_ul_zhong_left">
                            <span class="edit_span_top"><img src="<?php echo $tribe?IMAGE_URL.$tribe["logo"]:"images/default_img_logo.jpg";?>" id="thubm1" ></span>
                        </div>
                    </div>
                    <i class="icon-right"></i>
                </div>
            </a>
        </li>
        </ul>
        <ul class="edit_tribe_sh" style="margin-bottom: 10px;">
            <li>
            <a href="javascript:void(0);">
            <div class="edit_tribe_sh_ul_top">
                <span class="edit_tribe_sh_ul_top_left">部落名称</span>
                <div class="edit_tribe_sh_ul_zhong">
                    <div class="edit_tribe_sh_ul_zhong_left">
                        <span><?php echo $tribe["name"];?></span>
                    </div>
                </div>
            </div>
            </a>
            </li>
             <li>
                <a href="<?php echo site_url("tribe/tribe_edit_view/3");?>">
                <div class="edit_tribe_sh_ul_top">
                    <span class="edit_tribe_sh_ul_top_left">所属行业</span>
                    <div class="edit_tribe_sh_ul_zhong">
                        <div class="edit_tribe_sh_ul_zhong_left"><span><?php echo $tribe["industry"];?></span></div>
                    </div>
                   <i class="icon-right"></i>
                </div>
                </a>
            </li>
             <li>
                <a href="javascript:void(0);">
                <div class="edit_tribe_sh_ul_top">
                    <span class="edit_tribe_sh_ul_top_left">部落地区</span>
                    <div class="edit_tribe_sh_ul_zhong">
                        <div class="edit_tribe_sh_ul_zhong_left">
                            <input type="text" class="select-value" name="region" value="<?php echo $tribe["provice"]."-".$tribe["city"];?>">
                        </div>
                    </div>
                    <i class="icon-right"></i>
                </div>
                </a>
            </li>
        </ul>  
          
          
        <ul class="edit_tribe_sh" style="margin-bottom: 10px;">
            <li>
                <a href="<?php echo site_url("tribe/tribe_edit_view/2");?>">
                    <div class="edit_tribe_sh_ul_top">
                        <span class="edit_tribe_sh_ul_top_left">部落简介定制图</span>
                        <div class="edit_tribe_sh_ul_zhong">
                            <div class="edit_tribe_sh_ul_zhong_left"><span><?php echo $tribe["content_img"]?"已上传":"未上传"; ?></span></div>
                        </div>
                        <i class="icon-right"></i>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url("tribe/tribe_edit_view/4");?>">
                    <div class="edit_tribe_sh_ul_top">
                        <span class="edit_tribe_sh_ul_top_left">部落商城Banner图</span>
                        <div class="edit_tribe_sh_ul_zhong">
                            <div class="edit_tribe_sh_ul_zhong_left"><span><?php echo $tribe["shop_img"]?"已上传":"未上传"; ?></span></div>
                        </div>
                        <i class="icon-right"></i>
                    </div>
                </a>
            </li>
            
        </ul>
        <ul class="edit_tribe_sh">
            <li style="height: auto;">
              <a href="<?php echo site_url("tribe/tribe_edit_view/1");?>">
                <div class="edit_tribe_sh_ul_top">
                  <span class="edit_tribe_sh_ul_top_left">部落简介</span>
                   <div class="edit_tribe_sh_ul_zhong"></div>
                       <i class="icon-right"></i>
                   </div>
              </a>
              <div class="tribe_jianjie_text"><span style="margin-left: 0;" class="identity_zhong_p"><?php echo $tribe["content"];?></span></div>  
            </li>
        </ul>
      
        </div>
    </div> 
    </form> 
<script src="js/liandong.js"></script>
<script type="text/javascript">
$(function () { 
	//ios返回刷新
	var isPageHide = false; 
	window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      	window.location.reload(); 
	    } 
	}); 
	window.addEventListener('pagehide', function () { 
    	isPageHide = true; 
	}); 
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
			$(".yijji").css("color","#fff");
        }
        reader.readAsDataURL(input.files[0]);
        if(obj == "#thubm"){//封面
        	ajax_submit(1);
        }else if(obj == "#thubm1"){//logo
        	ajax_submit(2);
        }
        
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
function ajax_submit(type){
    $.ajax({
        url : "<?php echo site_url("tribe/update");?>",
        type : "post",
        cache : false,
	    data: new FormData($('form')[0]),
	    processData: false,
	    contentType: false,
	    dataType:"json"
    }).done(function(res) {
        if(res["status"] != 1){
//         	document.location.reload(true);
        }    
	}).fail(function(res) {
// 		document.location.reload(true);
	});
}

/**
 * liandong.js文件调用
 * 确定选择地区
 */
function mPickerconfirm(){
	ajax_submit();
}


(function($){
  $.fn.moreText = function(options){
    var defaults = {
      maxLength:50,
      mainCell:".identity_zhong_p",
      openBtn:'展开',
      closeBtn:'收起'
    }
    return this.each(function() {
      var _this = $(this);
      
      var opts = $.extend({},defaults,options);
      var maxLength = opts.maxLength;
      var TextBox = $(opts.mainCell,_this);
      var openBtn = opts.openBtn;
      var closeBtn = opts.closeBtn;
      
      var countText = TextBox.html();
      var newHtml = '';
      if(countText.length > maxLength){
        newHtml = countText.substring(0,maxLength)+'...<span class="more_til">'+openBtn+'<i class="icon-xiala1"></i></span>';
      }else{
        newHtml = countText;
      }
      TextBox.html(newHtml);
      TextBox.on("click",".more_til",function(){
        if($(this).text()==openBtn){
          TextBox.html(countText+' <span class="more_til">'+closeBtn+'<i class="icon-04"></i></span>');
        }else{
          TextBox.html(newHtml);
        }
      })
    })
  }
})(jQuery);
$(function(){
  $(".tribe_jianjie_text").moreText({
    maxLength: 50, //默认最大显示字数，超过...
    mainCell: '.identity_zhong_p' //文字容器
  });
})


</script>
