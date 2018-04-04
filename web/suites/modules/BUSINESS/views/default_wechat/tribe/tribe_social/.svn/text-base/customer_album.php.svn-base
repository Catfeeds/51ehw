<style type="text/css">
  .circle_add_apply_footer ul li {position: relative;}
  .circle_add_apply_footer ul li a input {width: 100%;height: 100%;position: absolute;top: 0;left: 0px;z-index: 8;opacity: 0;}
  .img-box .upimg-div .z_file {position: fixed;bottom: 0;z-index: 9;height: 50px;width: 100%;left: 0;opacity: 0;}
  .upimg-div .up-section {width: 3rem;height: 3rem;}
  .icon_ball_box {    position: fixed;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.5);
    width: 100%;
    height: 100%!important;
    z-index: 99;
    display: table;}
    .icon_ball_box_span {display: table-cell;vertical-align: middle;color: #fff;font-size: 15px;}
    .dropload-load .loading {border: 2px solid #fff!important;height: 25px!important;width: 25px!important;border-bottom-color: transparent!important;}
	.tribe_new_time{ border-bottom:1px solid #ddd; padding:0 0 15px 0;margin:0 0.375rem}
	.tribe_photo_edit{ right:0;}
	.tribe_preson_show_time{ margin-top:15px;font-size: 15px;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<script type='text/javascript' src='js/jquery.form.js'></script>
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<!-- 个人展示 -->
<div class="tribe_preson_show">
  <div class="tribe_preson_show_head">
  <!-- 头部 -->
 <!--  <div class="tribe_preson_show_nav">
    <a href="javascript:history.go(-1);"><span class="icon-back"></span>返回</a>
    <span>个人展示</span>
  </div> -->
  <!-- 透明层 -->
  <div style="position: absolute;width: 100%;height: 100%;background: rgba(0,0,0,0.7);"></div>
  <!-- 背景图片 -->
  <img src="<?php echo IMAGE_URL.$bg_img?>" alt="" onerror="this.src='images/bg_tribe.jpg'">
  <!-- 名字／职位 -->
  <div class="tribe_preson_show_name"><span><?php echo $real_name;?></span></div>
  <!-- 图片数量 -->
  <div class="tribe_preson_show_num"><span class="icon-camera"></span><span>共<?php echo $albums_list_count;?>张图片</span></div>
  </div>


<div class="tribe_preson_show_footer footer_remarks">
  <ul>
      <li><a href="javascript:save_remark();" class="tribe_preson_show_save">保存</a></li>
      <li><a href="javascript:void(0);" class="tribe_preson_show_cancel tribe_ball_cancel">取消</a></li>
  </ul>
</div>


<!-- 取消／删除 -->
<div class="tribe_preson_show_footer footer_photo_edit">
  <ul>
      <li><a href="javascript:void(0);" class="footer_photo_edit_cancel tribe_ball_cancel">取消</a></li>
      <li><a href="javascript:delalbum();" class="footer_photo_edit_delete custom_button">删除</a></li>
  </ul>
</div>




<div id="album_box">
	  <!-- 显示的图片 -->
    <div class="tribe_preson_show_box" id="albums" >
    	
    </div>
    <!--  <aside class="mask works-mask">
      <div class="mask-content">
          <p class="del-p ">您确定要删除相片吗？</p>
          <p class="check-p"><span class="del-com  del-btn" flag="">确定</span><span class="wsdel-no">取消</span></p>
      </div>
   </aside> -->
</div>

<!-- 进度条 -->
<div class="icon_ball_box" style="display:none;">
  <div class="progress" >
    <div class="progress-bar progress-bar-striped" ><span class="percent">50%</span></div>
  </div>
</div>  
<!--  
<div class="dropload-load icon_ball_box" id="dropload-load" style="display: none;">
   <span class="icon_ball_box_span"><span class="loading"></span>上传中...</span>
</div>
-->
 <!-- 没有图片 -->
<div  id ="no-img" style="text-align: center;"><span style="color: #ddd;font-size: 15px;">暂无照片展示</span></div>


<!-- 弹窗 -->
<div class="tuichu_ball" hidden="" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>确定删除吗？</span></div>
         <div class="tuichu_ball_button">
           <a id="tuichu_sub" href="javascript:delalbum();">删除</a>
           <a href="javascript:void(0);" class="tribe_ball_cancel">取消</a>
         </div>      
      </div>
   </div>
 </div>


<?php 
//-------------------------------------------上传图片开始-------------------------------------------
if($show_button){
?>
<script>
var album_id = 0;
var page = 1;
var tribe_id = '<?php echo $tribe_id?>';
dropload = $('#album_box').dropload({
	  scrollArea : window,
	  loadDownFn : function(me){
		  var result = "";
		  $.post("<?php echo site_url("Tribe_social/loading_albums");?>",{page:page,id:'<?php echo $customer_id;?>',tribe_id:<?php echo $tribe_id;?>},function(data){
			
			  if(data['list'].length>0){
				  $("#no-img").css("display","none");
		   	    	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["list"].length;i++){
                    result += '<div class="tribe_preson_show_list">';
	                	result +='<div class="tribe_preson_show_time"><span class="icon-xiugai" style="display:none;"></span>';
                        result +='<span>'+data['list'][i]['remark']+'</span>';
                        if(tribe_id != data['list'][i]['tribe_id']) {
                            result +='<em>('+data['list'][i]['tribe_name']+'的公开照片)</em>';
                        }
	                	result +='</div><div class="show_my ball_show" >';
	                	result +='<ul data-am-widget="gallery" data-am-gallery="{ pureview: true }">';
	                	for(var k = 0;k < data['list'][i]['photo_list'].length;k++){
                      result +='<li>';
	                		result +='<img class="close-upimg" data-value="'+data["list"][i]['photo_list'][k]["id"]+'" src="'+image_url+data["list"][i]['photo_list'][k]["path"]+'">';
                      result +='<label class="ball_input"> <input type="checkbox" name="checkbox" value=""> </label>';
                      result +='</li>';
		                	}
	                	result +='</ul>';
	                	result +='</div>';
                    result +='<div class="tribe_new_time">';
                    result +='<span>'+data['list'][i]['created_at']+'</span>';
                      if(data['list'][i]['from_customer_id']){
                    result += '<span>由@';
                      if(data['list'][i]['corporation_name']){
                    result += data['list'][i]['corporation_name']+'，';
                      }
                      if(data['list'][i]['job']){
                    result += data['list'][i]['job']+'_';
                      }
                    result += data['list'][i]['real_name']+'上传添加</span>';
                    }
        			
                    if(tribe_id == data['list'][i]['tribe_id']) {
                        result +='<a href="<?php echo site_url('Tribe_social/edit_ablum');?>/'+data['list'][i]['photo_list'][0]['album_id']+'" class="tribe_photo_edit" style="right:40px;">修改</a>';
                        result +='<a href="javascript:void(0);" data-value ="'+data['list'][i]['photo_list'][0]['album_id']+'"  class="tribe_photo_edit del_btns">删除</a>';
                    }
        			
                    result +='</div>';
		                }
	                $('#albums').append(result);
	                $(".ball_show").delegate(".close-upimg","click",function(){
		                del_id = $(this).attr("data-value");
	                    $(".works-mask").show();
// 	                    var index = $(this).index();
	                  });
		             // 点击备注
	                $('.tribe_show_remarks').on('click',function(){
	                	album_id = $(this).attr("data-values");
	                  $('.footer_remarks').show();
	                })
                  // 点击删除
                  $('.del_btns').on('click',function(){
                	  del_album_id = $(this).attr("data-value");
                    $('.tuichu_ball').show();
//                     $(this).parents('.tribe_preson_show_time').siblings('.show_my').find('.ball_input').show();
                  })
	                // 点击取消
	                $(".tribe_ball_cancel").on('click',function(){
	                  $('.tuichu_ball').hide();
                    $('.ball_input').hide();
                    $("[name='checkbox']").removeAttr("checked");//取消全选   
                    del_id = new Array();
	                })
	                
	                $("[name='checkbox']").change(function() { 
	                	 var checked = $(this).prop("checked");//选择 
	                	 var value = $(this).parent().siblings(".close-upimg").attr("data-value");
	                	 var index = $.inArray(value,del_id);
	                	 if(checked){
	                           if(index >=0){//存在
	                             }else{//不存在
	                            	 del_id.push(value);
	                               }
			                }else{
			                	if(index >=0){//存在
			                		del_id.splice(index,1);
		                             }else{//不存在
			                             }
				                }
	                })
	                page++;
	                me.resetload();

                   $.getScript("js/amazeui.js");
			  }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
                    me.resetload();
                    $(".dropload-down").remove();
	            }
	        },"json");

	  }
});


// var del_id = new Array();
// function delimg(){
//	$.post("<?php echo site_url("Tribe_social/del_album_img");?>",{id:del_id},function(data){
// 		if(data.status){
// 				for(var k=0;k< del_id.length;k++){
// 				 	$("img[data-value="+del_id[k]+"]").parent("li").remove();
// 				}
// 				$(".works-mask").hide();
// 				$(".black_feds").text('删除成功').show();
// 	    		setTimeout("prompt();", 2000);
// 	    		setTimeout(function(){
// 				    	window.location.reload();
// 					    }, 2500);
// 			}else{
// 				$(".black_feds").text('删除失败').show();
// 	    		setTimeout("prompt();", 2000);
// 				}
// 	 },"json");
// }

</script>
 <!-- 底部按钮 -->
  <div class="circle_add_apply_footer tribe_show_but01">
  <ul>
    <li style="background:rgba(214,182,135,0.8);"><a href="<?php echo site_url("Tribe_social/Album_upload/{$tribe_id}/$customer_id");?>" class="corp_invite custom_button">上传图片</a></li>
  </ul>
</div>

<?php 
//-------------------------------------------上传图片结束-------------------------------------------
}else{ 
    //-------------------------------------------他人浏览相册开始-------------------------------------------
    ?>
<!-- 底部按钮 -->
<div class="circle_add_apply_footer tribe_show_but01">
  <ul>
    <li style="background:rgba(214,182,135,0.8);"><a href="<?php echo site_url("Tribe_social/Album_upload/{$tribe_id}/$customer_id");?>" class="corp_invite custom_button">帮他添加形象</a></li>
  </ul>
</div>
    
<script>
var from_customer = '<?php echo $this->session->userdata("user_id")?>';
var page = 1;
dropload = $('#album_box').dropload({
	  scrollArea : window,
	  loadDownFn : function(me){
		  var result = "";
		  $.post("<?php echo site_url("Tribe_social/loading_albums");?>",{page:page,id:'<?php echo $customer_id;?>',tribe_id:<?php echo $tribe_id;?>},function(data){
			  if(data['list'].length>0){
				  $("#no-img").css("display","none");
				  <?php if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){?>
				     image_url ="<?php echo 'http://www.test51ehw.com/uploads/B/'?>";
	   	    	  <?php }else{ ?>
		   	    	 image_url = "<?php echo IMAGE_URL;?>";
	   	          <?php } ?>
	                for(var i=0;i<data["list"].length;i++){
                	    
						if(from_customer == data['list'][i]['from_customer_id']){
							result +='<div class="tribe_preson_show_time"><span class="icon-xiugai" style="display:none;"></span>';
                            result +='<span>'+data['list'][i]['remark']+'</span>';
                            if("<?php echo $tribe_id;?>" != data['list'][i]['tribe_id']) {
                                result +='<em>('+data['list'][i]['tribe_name']+'的公开照片)</em>';
                            }
							
							result += '</div></div>';
						}else{
							result += '<div class="tribe_preson_show_time">';
							result += data['list'][i]['remark'];
							result += '</div>';
						}
    	            	result +='<div class="show_my">';
	                	result +='<ul data-am-widget="gallery" data-am-gallery="{ pureview: true }">';
	                	for(var k = 0;k < data['list'][i]['photo_list'].length;k++){
                        result +='<li>';
	                		result +='<img class="close-upimg" src="'+image_url+data["list"][i]['photo_list'][k]["path"]+'">';
                         result +='</li>';
		                	}
	                	result +='';
	                	result +='</ul>';
	                	result +='</div>';
	                	result +='<div class="tribe_new_time">';
                    result +='<span>'+data['list'][i]['created_at']+'</span>'; 
	                	  if(data['list'][i]['from_customer_id']){
							      result += '<span>由@';
							        if(data['list'][i]['corporation_name']){
								    result += data['list'][i]['corporation_name']+'，';
								      }
							        if(data['list'][i]['job']){
								    result += data['list'][i]['job']+'_';
								      }
							     result += data['list'][i]['real_name']+'上传添加</span>';
							       }

            	    if( data['list'][i]['from_customer_id'] == from_customer && "<?php echo $tribe_id;?>" == data['list'][i]['tribe_id'])
          			{
           	    	    result +='<a href="<?php echo site_url('Tribe_social/edit_ablum');?>/'+data['list'][i]['photo_list'][0]['album_id']+'" class="tribe_photo_edit" style="right:40px;">修改</a>';
                    	result +='<a href="javascript:void(0);" data-value ="'+data['list'][i]['photo_list'][0]['album_id']+'" class="tribe_photo_edit del_btns">删除</a>';
          			}
	                  result +='</div>';
		                }
	                $('#albums').append(result);
	                page++;
	                me.resetload();

                  $('.tribe_show_remarks').on('click',function(){
                  album_id = $(this).attr("data-values");
                  $('.footer_remarks').show();
                  })
                   // 点击删除
                  $('.del_btns').on('click',function(){
                	  del_album_id = $(this).attr("data-value");
                    $('.tuichu_ball').show();
                    $(this).parents('.tribe_preson_show_time').siblings('.show_my').find('.ball_input').show();
                  })
                   // 点击取消
	                $(".tribe_ball_cancel").on('click',function(){
	                  $('.tuichu_ball').hide();
                    $('.ball_input').hide();
                    $("[name='checkbox']").removeAttr("checked");//取消全选   
                    del_id = new Array();
	                })
                  var head = document.getElementsByTagName('head')[0];
                  var script = document.createElement('script');
                  script.src = 'js/amazeui.js';
                  script.type = 'text/javascript';
                  head.appendChild(script)
			  }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
                    me.resetload();
                    $(".dropload-down").remove();
	            }
	        },"json");
	  }
});
</script>

<?php
//-------------------------------------------他人浏览相册结束-------------------------------------------
    }
?>

<script type="text/javascript">
  $("#show_my").delegate(".close-upimg","click",function(){
    $(".works-mask").show();

    var index = $(this).index();
    
  });


  function save_remark(){
		var remark =  $("input[data-values="+album_id+"]").val();
		$.post("<?php echo site_url("Tribe_social/update_Album_remark");?>",{id:album_id,remark:remark},function(data){
			if(data.status){
				$(".black_feds").text('修改成功').show();
	    		setTimeout("prompt();", 2000);
	   		    $('.footer_remarks').hide();
				}else{
					$(".black_feds").text('修改失败').show();
		    		setTimeout("prompt();", 2000);
					}
			},"json");
		}
  var del_album_id = 0;
  function delalbum(){
	$(".tuichu_ball").hide();
  	$.post("<?php echo site_url("Tribe_social/del_album");?>",{id:del_album_id},function(data){
  		if(data.status){
//   				for(var k=0;k< del_id.length;k++){
//   				 	$("img[data-value="+del_id[k]+"]").parent("li").remove();
//   				}
  				$(".works-mask").hide();
  				$(".black_feds").text('删除成功').show();
  	    		setTimeout("prompt();", 2000);
  	    		setTimeout(function(){
  				    	window.location.reload();
  					    }, 2500);
  			}else{
  				$(".black_feds").text('删除失败').show();
  	    		setTimeout("prompt();", 2000);
  				}
  	 },"json");
  }
</script>

<!-- 上传图片 -->
<script type="text/javascript">
  var delParent;
var defaults = {
  fileType         : ["JPG",'jpg',"png","PNG","jpeg","JEPG"],   // 上传文件的类型
  fileSize         : 1024 * 1024 * 3                  // 上传文件的大小 10M
};


function upload_img(id)
{   
  
    var obj = $('#'+id);
    var file = document.getElementById(id);
    var file_n = parseInt(id.split('_')[1])+1;
    $('#'+id).hide();
    
    var imgContainer = $(obj).parents(".z_photo"); //存放图片的父亲元素
    var fileList = file.files; //获取的图片文件
    
    var input = $(obj).parent();//文本框的父亲元素
    var imgArr = [];
    //遍历得到的图片文件
    var numUp = imgContainer.find(".up-section").length;
    
    var totalNum = numUp + fileList.length;  //总的数量
    if(fileList.length > 9 || totalNum > 9 ){
      alert("上传图片数目不可以超过9个，请重新选择");  //一次选择上传超过5个 或者是已经上传和这次上传的到的总数也不可以超过5个
    }
    else if(numUp < 9){
      fileList = validateUp(fileList);
      if(!fileList){//文件类型不允许上传
          return false;
          }
      for(var i = 0;i<fileList.length;i++){
        console.log(fileList[i]['name']);
        
       var imgUrl = window.URL.createObjectURL(fileList[i]);
           imgArr.push(imgUrl);
       var flag = fileList[i]['name']+fileList[i]['size'];
           Add(flag);
           flag = flag.replace('.',"");
       
       var $section = $("<section class='up-section z_file_lo loading' id="+flag+">");
       
           imgContainer.prepend($section);
       var $span = $("<span class='up-span'>");
           $span.appendTo($section);

          //点击弹出删除图片
         var $img0 = $("<div class='close-upimg' flag="+fileList[i]['name']+fileList[i]['size']+"></div>").on("click",function(event){
            event.preventDefault();
          event.stopPropagation();
          $(".works-mask").show();
          delParent = $(obj).parent();
            $('.del-com').attr('flag',$(this).attr('flag') );
        });   
        $img0.attr("src","img/a7.png").appendTo($section);

         var $img = $("<img class='up-img1 up-opcity' style='display:none;'>");
             $img.attr("src",imgArr[i]);
             $img.appendTo($section);
         var $p = $("<p class='img-name-p'>");
             $p.html(fileList[i].name).appendTo($section);
         var $input = $("<input id='taglocation' name='taglocation' value='' type='hidden'>");
             $input.appendTo($section);
         var $input2 = $("<input id='tags' name='tags' value='' type='hidden'/>");
             $input2.appendTo($section);
             
          
       }
    }
    html = '<input type="file" name="file[]" id="file_'+file_n+'" class="file" value="" onchange="upload_img(\'file_'+file_n+'\')" multiple="multiple" />';
    $('#test').append(html);

    var progress = $(".progress"); 
    var progress_box = $('.icon_ball_box');
    var progress_bar = $(".progress-bar");
    var percent = $('.percent');

    $('#form1').ajaxSubmit({
  	    url: '<?php echo site_url("Tribe_social/upload_Album")?>',
    	type: 'POST',
    	//cache: false,
    	//data: new FormData( $('#form1')[0] ),
  	  	//processData: false,
      	//contentType: false,
    	dataType:  'json', //数据格式为json 
  		beforeSend: function() { //开始上传 
  			progress.show();
        progress_box.show();
  			var percentVal = '0%';
  			progress_bar.width(percentVal);
  			percent.html(percentVal);
  		},
  		uploadProgress: function(event, position, total, percentComplete) { 
  			var percentVal = percentComplete + '%'; //获得进度 
  			progress_bar.width(percentVal); //上传进度条宽度变宽 
  			percent.html(percentVal); //显示上传进度百分比 
  		},
  		success: function(data) {
  			if( data.status )
  	    	{ 
  	    		$(".black_feds").text('上传成功').show();
  	    		setTimeout("prompt();", 2000);

  			    setTimeout(function(){
  			         $(".up-section").removeClass("loading");
  			       $(".up-img1").removeClass("up-opcity");
  			     },300);
  			     numUp = imgContainer.find(".up-section").length;
  			     
  			    if(numUp >= 9){
  			      $(obj).parent().hide();
  			    
  			    }
  			    setTimeout(function(){
  			    	window.location.reload();
  				    }, 2200);
  	    		
  	    	}else{ 
  	    		$(".black_feds").text('上传失败，请重试').show();
  	    		setTimeout("prompt();", 2000);
  	    	}
  	  	},
  	  	error:function(xhr){ //上传失败 
  	  	  	$("#dropload-load").hide();
  	     	$(".black_feds").text('上传失败，请重试').show();
  	 		setTimeout("prompt();", 2000);
  	  	}
        });

    return false;
    $.ajax({
        url: '<?php echo site_url("Tribe_social/upload_Album")?>',
        type: 'POST',
        cache: false,
        dataType:'json',
        data: new FormData( $('#form1')[0] ),
        processData: false,
        contentType: false,
        beforeSend:function(){
	      $(".progress").show();
          $('.progress_box').show();
		},
		uploadProgress: function(event, position, total, percentComplete) { 
			alert(percentComplete);
			return false;
  			var percentVal = percentComplete + '%'; //获得进度 
  			progress_bar.width(percentVal); //上传进度条宽度变宽 
  			percent.html(percentVal); //显示上传进度百分比 
  		}, 
    }).done(function(data) 
    {
        
   	    $(".progress").hide();
        $('.progress_box').hide();
    	if( data.status )
    	{ 
    		$(".black_feds").text('上传成功').show();
    		setTimeout("prompt();", 2000);

		    setTimeout(function(){
		         $(".up-section").removeClass("loading");
		       $(".up-img1").removeClass("up-opcity");
		     },300);
		     numUp = imgContainer.find(".up-section").length;
		     
		    if(numUp >= 9){
		      $(obj).parent().hide();
		    
		    }
		    setTimeout(function(){
		    	window.location.reload();
			    }, 2200);
    		
    	}else{ 
    		$(".black_feds").text('上传失败，请重试').show();
    		setTimeout("prompt();", 2000);
    	}
    }).fail(function(res) 
    {
   	    $("#dropload-load").hide();
    	$(".black_feds").text('上传失败，请重试').show();
		setTimeout("prompt();", 2000);
    });
    
   	return false;

    
}


function validateUp(files){
  
  var arrFiles = [];//替换的文件数组
  for(var i = 0, file; file = files[i]; i++){
    
    //获取文件上传的后缀名
    var newStr = file.name.split("").reverse().join("");
    if(newStr.split(".")[0] != null){
        var type = newStr.split(".")[0].split("").reverse().join("");
        console.log(type+"===type===");
        if(jQuery.inArray(type, defaults.fileType) > -1){
          // 类型符合，可以上传
          if (file.size >= defaults.fileSize) {
//             alert('您这个"'+ file.name +'"文件大小过大'); 
//             $('.icon_ball_box').hide(); 
          } else {
            // 在这里需要判断当前所有文件中
            arrFiles.push(file);  
          }
        }else{
          alert('您这个"'+ file.name +'"上传类型不符合');
          $('.icon_ball_box').hide(); 
          return false;
        }
      }else{
        alert('您这个"'+ file.name +'"没有类型, 无法识别'); 
        $('.icon_ball_box').hide(); 
        return false;
      }
  }
  
  
  return arrFiles;
}


function Add( file_name )
{ 
  var Cts = $('input[name=add_img]').val();
  
    $('input[name=add_img]').val( Cts+file_name+"," );

  
}

$(".z_photo").delegate(".close-upimg","click",function(){
    $(".works-mask").show();
//      delParent = $(this).parent();
//    alert($(this).attr('flag'));
    
});
  
$(".wsdel-ok").click(function(){
  
  $(".works-mask").hide();
  var file_name =  $(this).attr('flag');
  var html_id = file_name.replace('.',"");
  $('#'+html_id).remove(); //emove();
  var Cts = $('input[name=add_img]').val();
  var rep = file_name+",";
  $('input[name=add_img]').val( ( $('input[name=add_img]').val() ).replace(rep,"") );

  
});

$(".wsdel-no").click(function(){
  $(".works-mask").hide();
});






var JM = function(){
    //设置rem单位
    var html = document.documentElement;
    html.style.width = 100+"%";
    html.style.height = 100+"%";
    html.style.overflowX = "hidden";
    function xX(){
        var screenW = html.clientWidth;
        html.style.fontSize = 0.1 * screenW + "px";
    }
    window.onresize = function(){
        xX();
    };
    xX();
}(); 

</script>


















