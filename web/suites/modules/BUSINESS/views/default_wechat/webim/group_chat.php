<style type="text/css">
	.container {background: #F1F1F1;}
</style>
<!-- 个人聊天 -->
<div class="personal_chat">
	<!-- 头部 -->
	<div class="personal_chat_head">
		<a href="javascript:history.back();" class="icon-fanhui"></a>
		<!-- <a href="javascript:void(0);" class="icon-icon_my_on"></a> -->
		<span><?php echo  $title;?></span>
	</div>

    <div class="personal_chat_box">
      <div class="personal_chat_list">
    	 <ul id="chat_wrap">
    	    <?php 
    	    //记录默认查出来的历史记录ID
    	    $hist_ids = '';
    	    if($Msg_list){
    	        $sort = array(
    	            'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
    	            'field'     => 'id',       //排序字段
    	        );
    	        $arrSort = array();
    	        foreach($Msg_list AS $uniqid => $row){
    	            foreach($row AS $key=>$value){
    	                $arrSort[$key][$uniqid] = $value;
    	            }
    	        }
    	        if($sort['direction']){
    	            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $Msg_list);
    	        }
    	        
    	       $error_defult_img = "this.src='images/member_defult.png'";
    	       $matter = '';
    	       $deviation = 0;
    	       foreach ($Msg_list as $key =>$val){
    	           $matter_str = '';
    	           $currt_tiem = strtotime($val['create_at']);
    	           $diff_time = $currt_tiem - $deviation;
    	           $deviation = $currt_tiem;
    	           $show = 'hidden';
    	           if(abs($diff_time) > 180 ){
    	               $show = '';
    	           }
    	           if($val['from_customer_id'] == $from_customer['id']){
    	               $matter_str .= '<li>';
    	               $matter_str .= '<div class="personal_chat_time" '.$show.'><span>'.substr($val['create_at'],0,16).'</span></div>';
    	               $matter_str .= '<div class="personal_chat_img fn-right"><img src="'.$from_customer['logo'].'" onerror="'.$error_defult_img.'" alt=""></div>';
    	               $matter_str .= '<span class="personal_chat_name_right">'.$from_customer['real_name'].'</span>';
    	               $matter_str .= '<em class="personal_chat_triangle_right"></em>';
    	               $matter_str .= '<div class="personal_chat_content fn-right">';
    	               if($val['message_type'] == 0){
    	                   $matter_str .= '<span>'.$val['message'].'</span>';
    	               }else if($val['message_type'] == 1){
    	                   $matter_str .= '<img src="'.IMAGE_URL.$val['message_url'].'" alt="">';
    	               }else if($val['message_type'] == 2){
    	                   $matter_str .= '<span><a href="'.$val['message_url'].'">'.$val['message_url'].'</a></span>';
    	               }
    	               $matter_str .= '</div>';
    	               $matter_str .= '</li>';
    	           }else{
    	               
    	            
    	              $matter_str .= '<li>';
    	              $matter_str .= '<div class="personal_chat_time" '.$show.'><span>'.substr($val['create_at'],0,16).'</span></div>';
    	              $matter_str .= '<div class="personal_chat_img"><img src="'.$val['Send_info']['logo'].'"  onerror="'.$error_defult_img.'" alt=""></div>	';
    	              $matter_str .= '<span class="personal_chat_name_left">'.$val['Send_info']['real_name'].'</span>';
    	              $matter_str .= '<em class="personal_chat_triangle_left"></em>';
    	              $matter_str .= '<div class="personal_chat_content">';
    	              if($val['message_type'] == 0){
    	                   $matter_str .= '<span>'.$val['message'].'</span>';
    	               }else if($val['message_type'] == 1){
    	                   $matter_str .= '<img src="'.IMAGE_URL.$val['message_url'].'" alt="">';
    	               }else if($val['message_type'] == 2){
    	                   $matter_str .= '<span><a href="'.$val['message_url'].'">'.$val['message_url'].'</a></span>';
    	               }
    	              $matter_str .= '</div>';
    	              $matter_str .= ' </li>';
    	           }
//     	       $matter = $matter_str.$matter;
    	       $matter .= $matter_str;
    	       $hist_ids  .= $val['id'].',';
    	       }
    	       echo  $matter;
    	    }?>
    	 </ul>
      </div>
    </div>
<div id="foot_tag" style="opacity:0"></div>
    <!-- 输入框 -->
<div class="foot_bottom">
<form action="<?php site_url("Webim/Control");?>" method="post" enctype="multipart/form-data" id="form1"  >
      <div class="search_gongg">
         <div class="foot_xia">
             <div id="form_article" contenteditable="true" onkeydown=""></div>
         </div>   
            <span class="www send_t_btn icon-biaoqing" id="www"></span>
            <div class="personal_chat_uploading_img"><span class="icon-tupian"></span>
            <input type="file" name="file[]" id="file_img" onchange="selectImg('file_img')" multiple class="icon-tupian">
            <a href="javascript:void(0);" class="chat_send" onclick="chat_send();">发送</a>
            </div>
      </div>   
      <div class="page_emotion box_swipe" id="page_emotion">
			<dl id="list_emotion" class="list_emotion pt_10 yingc" hidden></dl><!-- 表情框 -->
			<dt><ol id="nav_emotion" class="nav_emotion yingc" hidden></ol></dt><!-- 分页提示点 -->
 	  </div>  
</form>          
</div>

</div>
<!-- 图片放大 -->
<div class="chat_ball">
  <div class="chat_ball_img integral_details"><img src=""></div>
</div>
<!-- 弹窗 -->
<div class="tuichu_ball" hidden="" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>重新发送信息？</span></div>
         <div class="tuichu_ball_button">
           <a href="javascript:cane(0);">取消</a>
           <a id="tuichu_sub" href="javascript:void(0);">确定</a>
         </div>      
      </div>
   </div>
 </div>
<script src="js/webiaoqin.js"></script>
<script type='text/javascript' src='js/exif.js'></script>  
<script>
var load_log_status = 0;
window.onscroll = function(e){
    //獲取网页的总高度
    var htmlHeight=document.body.scrollHeight||document.documentElement.scrollHeight;
    //獲取网页在浏览器中的可视高度
    var clientHeight=document.body.clientHeight||document.documentElement.clientHeight;
    //獲取浏览器滚动条的top位置
    var scrollTop=document.body.scrollTop||document.documentElement.scrollTop;
    //通过判断滚动条的top位置与可视网页之和与整个网页的高度是否相等来决定是否加载内容； 

   //
    
    if(load_log_status){
    	//滑动条接触到顶部0
    if(scrollTop < 30){
    	if(!is_loading){
        	if(allow_loading){
        		is_loading = 1;
            	loadingLog();
                }
            }


        }
    }
    //滑动条接触到底部  
    if(scrollTop+clientHeight==htmlHeight){  
    }                 
     
}
//是否允许触发下拉加载更多消息(默认允许)
var allow_loading = 1;
//是否正在拉取数据中(默认不是)
var is_loading = 0;
var Orientation = null;
var page = 1;//默认加载页数

function loadingLog(){
    // 加载菜单一的数据
   var result = "";
   $.post("<?php echo site_url("Webim/Control/getChatlog");?>",{'Channel_id':Channel_id,page:page,"hist_ids":'<?php echo $hist_ids;?>'},function(data){
    if(data["list"].length>0){
    	 var matter = '';
    	 var img_url = '<?php echo IMAGE_URL?>';
    	 var deviation = 0;
        for(var i=0;i<data["list"].length;i++){
        	var result_str = ''; 
        	var stamp = Date.parse(data["list"][i]['create_at']);
	    	var diff = deviation - stamp;
	    	deviation = stamp;
	    	var show = 'hidden';
	    	if(diff > 180000){
	    		show = '';
		    	}
           if(data["list"][i]['from_customer_id'] == '<?php echo $from_customer['id'] ?>'){
               
        	   result_str += '<li>';
        	   result_str += '<div class="personal_chat_time" '+show+'><span>'+data["list"][i]['create_at'].substr(0,16)+'</span></div>';
        	   result_str += '<div class="personal_chat_img fn-right"><img src="<?php echo $from_customer['logo'];?>" onerror="'+error_defult_img+'" alt=""></div>	';
        	   result_str += '<span class="personal_chat_name_right"><?php echo $from_customer['real_name'];?></span>';
    	            	   result_str += '<em class="personal_chat_triangle_right"></em>';
    	            	   result_str += '<div class="personal_chat_content fn-right">';
      	            	    if(data["list"][i]['message_type'] == 0){
      	            	    	result_str += '<span>'+data["list"][i]['message']+'</span>';
          	            	    }else if(data["list"][i]['message_type'] == 1){
          	            	    	result_str += '<img src="'+img_url+data["list"][i]['message_url']+'" alt="">';
              	            	    }else if(data["list"][i]['message_type'] == 2){
              	            	    	result_str += '<span><a href="'+data["list"][i]['message_url']+'">'+data["list"][i]['message_url']+'</a></span>';
                  	            	    }
        	            	  result_str += '</div>	';
        	            	  result_str += '  </li>';
        	               }else{
        	            	   result_str += '<li>';
        	            	   result_str += '<div class="personal_chat_time" '+show+'><span>'+data["list"][i]['create_at'].substr(0,16)+'</span></div>';
        	            	   result_str += '<div class="personal_chat_img"><img src="'+data['list'][i]['Send_info']['logo']+'"  onerror="'+error_defult_img+'" alt=""></div>	';
        	            	   result_str += '<span class="personal_chat_name_left">'+data['list'][i]['Send_info']['real_name']+'</span>';
        	            	   result_str += '<em class="personal_chat_triangle_left"></em>';
        	            	   result_str += '<div class="personal_chat_content">';
        	            	    if(data["list"][i]['message_type'] == 0){
        	            	    	result_str += '<span>'+data["list"][i]['message']+'</span>';
            	            	    }else if(data["list"][i]['message_type'] == 1){
            	            	    	result_str += '<img src="'+img_url+data["list"][i]['message_url']+'" alt="">';
                	            	    }else if(data["list"][i]['message_type'] == 2){
                	            	    	result_str += '<span><a href="'+data["list"][i]['message_url']+'">'+data["list"][i]['message_url']+'</a></span>';
                    	            	    }
        	            	    result_str += '</div>';
        	            	    result_str += ' </li>';
            	               }
    	               matter = result_str+matter;
    	                }
	                page++;
	                $('#chat_wrap li').eq(0).before(matter);
	                is_loading = 0;
// 	                slide(times);
	            }else{
	            	allow_loading = 0;
	            	var last_second = $('#chat_wrap li').eq(1).children('.personal_chat_time').find("span").html();
	            	var last_one = $('#chat_wrap li').eq(0).children('.personal_chat_time').find("span").html();
	            	last_second = Date.parse(last_second);
	            	last_one = Date.parse(last_one);
	            	var diff_time = last_second - last_one;
	            	if(diff_time > 180000){
		            	}else{
		            		$('#chat_wrap li').eq(1).children('.personal_chat_time').hide();
			            	}
	            	$('#chat_wrap li').eq(0).children('.personal_chat_time').show();
	            }
	        },"json");
}


$(function(){
	var say = '';
	if ($("#form_article").html() === "") {
		$("#form_article").html(say);
		$(".yingc").hide();
	}
	
	$("#form_article").click(function(){
		$(".yingc").hide();
        if($("#form_article").html() == say){
           	$("#form_article").html("");
        }
    });
    $("#page_emotion  dd").click(function(){
        $("#form_article").html( $("#form_article").html().replace(say, '') );
    });
});

// $("#form_article").keydown(function(event){
// 	if(event.which === 13){
// 		event.preventDefault();
// 		var content = $.trim( $('#form_article').html() );
// 		if( content == ''  ) {
// 			$(".black_feds").text("消息不能为空").show();
// 			setTimeout("prompt();", 2000);
// 			return;
// 		}
// 		sendText();
// 		}
// 	});

// 发送
function chat_send() {
	var content = $.trim( $('#form_article').html() );
   if( content == ''  ) {
			$(".black_feds").text("消息不能为空").show();
			setTimeout("prompt();", 2000);
			return;
		}
		sendText();
		$('.chat_send').hide();
		$('.foot_bottom').css('position','fixed');
};
$('#form_article').on('input propertychange',function(){
  var num = $(this).html().length;
  if (num > 0) {
  	$('.chat_send').show();
  } else{
  	$('.chat_send').hide();
  };
});


$(".www").click(function(){
	$('.chat_send').show();
	if($(".yingc").css("display")=="none"){
	$(".yingc").show();
	$('#form_article').css('min-height','42px');
	}else{
	$(".yingc").hide();
	$('#form_article').css('min-height','22px');
	}
});
	
 
　var page_emotion = $(".page_emotion");
	$(function (){
	$("#www").click(function (event) {
		showDiv();//调用显示DIV方法
		$(document).one("click", function () 
		{//对document绑定一个影藏Div方法
		$(page_emotion).hide();
		$(".yingc").hide();
	});
			event.stopPropagation();//阻止事件向上冒泡
	});
	$(page_emotion).click(function (event) {
 
	event.stopPropagation();//阻止事件向上冒泡
		});
		});
　function showDiv(){
  $(page_emotion).fadeIn();
   }
</script>
<script type="text/javascript">
slide();
function  slide(tag){
	if(tag){
		$('html, body').animate({scrollTop: $('#'+tag).offset().top}, 1000);
		}else{
			setTimeout(function(){
				load_log_status = 1;
			},2000);
			$('html, body').animate({scrollTop: $('#foot_tag').offset().top}, 1000);
			}
	
}
function sendText(parms,send){

	if(!parms){
		var obj = $.trim($("#form_article").html());
		}else{
			if(!send){
				var cont = 'javascript:sendText('+parms+',"send")';
				$("#tuichu_sub").attr("href",cont);
				$('.tuichu_ball').show();
				return false;
				}else{
					$('.tuichu_ball').hide();
					$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
					var obj = $('#'+parms+'<?php echo 'Text'.$from_customer['id'];?>').html();
					}
			}
// 	if(!parms){
// 		var obj = $.trim($("#form_article").html());
// 		}else{
//			$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
//			var obj = $('#'+parms+'<?php echo 'Text'.$from_customer['id'];?>').html();
// 			}

	var msg_type = 0 ; 
	var timestamp = Date.parse(new Date());
	var reTag = /<(?:.|\s)*?>/g;
	var TextReg = /[\u4e00-\u9fa5]/g;
	if(!parms){
		if(obj.indexOf("http:")>-1||obj.indexOf("https:")>-1){
			if(TextReg.test(obj)){
				msg_type = 0;
				obj = obj.replace(/<[^>]+>/g,"");
				}else{
					msg_type = 2;
					obj = obj.replace(reTag,"");
					}
			}
    }else{
    	if(obj.indexOf("http:")>-1||obj.indexOf("https:")>-1){
    		if(TextReg.test(obj)){
    			msg_type = 0;
    			obj = obj.replace(/<[^>]+>/g,"");
			}else{
				msg_type = 2;
				obj = obj.replace(reTag,"");
				}
			}
		}
	 $.ajax({ 
		    url:'<?php echo site_url('Webim/Control/sendText')?>',
		    type:'post',
		    dataType:'json',
		    data:{'content':obj,"Channel_id":Channel_id,'msg_type':msg_type,"tribe_id":'<?php echo $tribe_id;?>',"group_id":'<?php echo $group_id;?>'},
		    beforeSend:function()
      		{ 
		    	var myDate = new Date();//获取系统当前时间
		    	var stamp = Date.parse(myDate);
		    	var diff = stamp - current_interval;
		    	current_interval = stamp;
		    	var show = 'hidden';
		    	if(diff > 180000){
		    		show = '';
			    	}
		    	var dtime = timeDate();
		    	var result = '';
		    	result += '<li id ="'+timestamp+'<?php echo $from_customer['id'];?>">';
		    	result += '<div class="personal_chat_time"'+show+'><span>'+dtime+'</span></div>';
		    	result += '<div class="personal_chat_img fn-right"><img src="<?php echo $from_customer['logo'];?>" onerror="'+error_defult_img+'"  alt=""></div>	';
		    	result += '<span class="personal_chat_name_right"><?php echo $from_customer['real_name'];?></span>';
		    	result += '<em class="personal_chat_triangle_right"></em>';
		    	result += '<div class="personal_chat_content fn-right">';
		    	if(msg_type == 2){
		    		result += '<span><a  id ="'+timestamp+'<?php echo 'Text'.$from_customer['id'];?>"  href="'+obj+'">'+obj+'</a></span>';
			    	}else{
			    		result += '<span id ="'+timestamp+'<?php echo 'Text'.$from_customer['id'];?>">'+obj+'</span>';
				    	}
		    	result += '</div>';
		    	var href = 'javascript:sendText('+timestamp+')';
		    	result += '<a href="'+href+'" id ="'+timestamp+'fail"  class="icon-tishi1 chat_tishi_right send_fail" hidden ></a>';
		    	result += '</li>';
				$("#chat_wrap").append(result);
				$("#form_article").html('');
				slide();
				
      		},
		    success:function(data)
		    {
			    if(data.status == 5){
			    	console.log("发送成功");
				    }else{
				    	console.log("发送失败");
				    	$('#'+timestamp+'fail').show();
					    }
			},
		    error:function()
		    {
		    	console.log("发送失败");
		    	$('#'+timestamp+'fail').show();
			    return;
		    }
	    })	
}

function sendImg(blob,parms,send){
	if(parms){
		if(!send){
			var cont = 'javascript:sendImg('+blob+','+parms+',"send")';
			$("#tuichu_sub").attr("href",cont);
			$('.tuichu_ball').show();
			return false;
			}else{
				$('.tuichu_ball').hide();
				$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
				var blob = $('#'+parms+'<?php echo $from_customer['id'];?>img').attr("src");
				}
		$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
		var blob = $('#'+parms+'<?php echo $from_customer['id'];?>img').attr("src");
		}
// 	if(parms){
//		$('#'+parms+'<?php echo $from_customer['id'];?>').hide();
//		var blob = $('#'+parms+'<?php echo $from_customer['id'];?>img').attr("src");
// 		}
	var timestamp = Date.parse(new Date());
	$.ajax({ 
	    url:'<?php echo site_url('Webim/Control/sendImage')?>',
	    type:'post',
	    dataType:'json',
	    data:{'blob':blob,"Channel_id":Channel_id,"tribe_id":'<?php echo $tribe_id;?>',"group_id":'<?php echo $group_id;?>'},
	    beforeSend:function()
  		{ 
	    	var myDate = new Date();//获取系统当前时间
	    	var stamp = Date.parse(myDate);
	    	var diff = stamp - current_interval;
	    	current_interval = stamp;
	    	var show = 'hidden';
	    	if(diff > 180000){
	    		show = '';
		    	}
	    	var dtime = timeDate();
	    	var result = '';
	    	result += '<li id ="'+timestamp+'<?php echo $from_customer['id'];?>">';
	    	result += '<div class="personal_chat_time"'+show+'><span>'+dtime+'</span></div>';
	    	result += '<div class="personal_chat_img fn-right"><img src="<?php echo $from_customer['logo'];?>" onerror="'+error_defult_img+'" alt=""></div>';
	    	result += '<em class="personal_chat_triangle_right"></em>';
	    	result += '<div class="personal_chat_content fn-right">';
	    	result += '<img id ="'+timestamp+'<?php echo $from_customer['id'];?>img" src="'+blob+'" alt="">';
	    	result += '</div>';
	    	var href = 'javascript:sendImg(300,'+timestamp+')';
	    	result += '<a href="'+href+'" id ="'+timestamp+'fail"  class="icon-tishi1 chat_tishi_right send_fail" hidden ></a>';
	    	result += '</li>';
			$("#chat_wrap").append(result);
			slide();
  		},
	    success:function(data)
	    {
	    	 if(data.status == 5){
			    	console.log("发送成功");
				    }else{
				    	console.log("发送失败");
				    	$('#'+timestamp+'fail').show();
				    	 return;
					    }
	    	
		},
	    error:function()
	    {
	    	console.log("发送失败");
	    	$('#'+timestamp+'fail').show();
		    return;
	    }
    })	
}

function  selectImg(obj){
	var file = document.getElementById(obj);
	var files = file.files; //获取的图片文件
    if(files.length == 1){
    	var fileImg = files[0];
		if (!/image\/\w+/.test(fileImg.type)) {  
			   alert("请确保文件为图像类型");  
	       return false;  
	    } 

		 EXIF.getData(fileImg, function() {  
			    Orientation = EXIF.getTag(this, 'Orientation');
			  })
		 //创建一个文件读取的工具类
	    var reader = new FileReader(); 
	    //这里利用了闭包的特性，来保留文件名
	    (function(x,y){
	        reader.onload = function (e) {
	        //调用压缩文件的方法，具体实现逻辑见下面
	        getBase64Image(this.result);
	        }  
		 })() 
	   //告诉文件读取工具类读取那个文件
	   reader.readAsDataURL(fileImg);   
	  }else{
		  for(var i =0;i<files.length;i++){ 
				var fileImg = files[i]; //获取的图片文件
				if (!/image\/\w+/.test(fileImg.type)) {  
					   alert("请确保文件为图像类型");  
			       return false;  
			    } 
				 //创建一个文件读取的工具类
			    var reader = new FileReader(); 
			    //这里利用了闭包的特性，来保留文件名
			    (function(x,y){
			        reader.onload = function (e) {
			        //调用压缩文件的方法，具体实现逻辑见下面
			        getBase64Image(this.result);
			        }  
				 })() 
			   //告诉文件读取工具类读取那个文件
			   reader.readAsDataURL(fileImg);   
				}   
		  }
	
}

function getBase64Image(src) {
	   // 创建一个 Image 对象
	   var image = new Image();
	   image.src = src;
	   // 绑定 load 事件处理器，加载完成后执行
	   image.onload = function() {
	   // 获取 canvas DOM 对象
	   var canvas = document.createElement("canvas");
	   // 获取 canvas的 2d 画布对象,
	   var ctx = canvas.getContext("2d");
	   // canvas清屏，并设置为上面宽高
	   ctx.clearRect(0, 0, canvas.width, canvas.height);
	   if(Orientation && Orientation != 1){
	       switch(Orientation){
	           case 6:     // 旋转90度
	               canvas.width = image.height;    
	               canvas.height = image.width;    
	               ctx.rotate(Math.PI / 2);
	               // (0,-imgHeight) 从旋转原理图那里获得的起始点
	               ctx.drawImage(this, 0, -image.height, image.width, image.height);
	               break;
	           case 3:     // 旋转180度
	               ctx.rotate(Math.PI);    
	               ctx.drawImage(this, -image.width, -image.height, image.width, image.height);
	               break;
	           case 8:     // 旋转-90度
	               canvas.width = image.height;    
	               canvas.height = image.width;    
	               ctx.rotate(3 * Math.PI / 2);    
	               ctx.drawImage(this, -image.width, 0, image.width, image.height);
	               break;
	       }
	   }else{
			// 重置canvas宽高
		   canvas.width = image.width;
		   canvas.height = image.height;
		   // 将图像绘制到canvas上
		   ctx.drawImage(image, 0, 0, image.width, image.height);
	   }
	   //生成64位blob
	   var blob = canvas.toDataURL("image/jpeg");
	   //发送图片信息	
	   sendImg(blob);
	   };
}
</script>
<script type="text/javascript">
      // 图片放大
      $(".chat_ball").hide();
      $("#chat_wrap").on("click",'.personal_chat_content img',function(){ 	
      	var img_src = $(this)[0].src;
      	$(".chat_ball").show();
      	$('.chat_ball img')[0].src = img_src;
      });

      $(".chat_ball").on("click",function(){
      	$(".chat_ball").hide();
      })
   
  $('#form_article').blur(function(){
     $('.foot_bottom').css('position','fixed');
  });

  $('#form_article').on('click',function(){
    $('.foot_bottom').css('position','absolute');
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


 
    function cane() {
    	$('.tuichu_ball').hide();
    }

</script>

<!-- 判断安卓手机和苹果手机 -->
<script language="javascript">
window.onload = function () {
var u = navigator.userAgent;
if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
// alert("安卓手机");
} else if (u.indexOf('iPhone') > -1) {//苹果手机
// alert("苹果手机");
   var editor = document.getElementById('form_article');
     document.body.onload = function(){
     editor.focus();
   }

} else if (u.indexOf('Windows Phone') > -1) {//winphone手机
// alert("winphone手机");
}
}
</script>
