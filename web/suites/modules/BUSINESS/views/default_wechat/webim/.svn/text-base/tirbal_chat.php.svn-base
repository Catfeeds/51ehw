<style type="text/css">
	.container {background: #F1F1F1;}
</style>


<!-- 部落聊天 -->
<div class="personal_chat">
	<!-- 头部 -->
	<div class="personal_chat_head">
		<a href="javascript:history.back();" class="icon-fanhui"></a>
		<a href="javascript:void(0);" class="icon-icon_my_on"></a>
		<span>西北部落</span>
	</div>

    <div class="personal_chat_box">
      <div class="personal_chat_list">
    	 <ul>
    	     <!-- 左边 -->
    	     <li>
    	     	<!-- 时间 -->
    	     	<div class="personal_chat_time"><span>2018.01.01 12:00</span></div>
    	     	<!-- 头像 -->
    	     	<div class="personal_chat_img"><img src="images/quanzi1.png" alt=""></div>	
                <!-- 姓名 -->
                <span class="personal_chat_name_left">柳飞先生</span>
    	     	<!-- 三角形 -->
    	     	<em class="personal_chat_triangle_left"></em>
    	     	<!-- 聊天内容 -->
    	     	<div class="personal_chat_content">
    	     		<span>阿福是帅哥...阿福是帅哥...阿福是帅哥...阿福是帅哥...阿福是帅哥...阿福是帅哥...</span>
    	     	</div>	
    	     </li>
    	     <!-- 左边 -->
    	     <li>
    	     	<!-- 时间 -->
    	     	<!-- <div class="personal_chat_time"><span>2018.01.01 12:00</span></div> -->
    	     	<!-- 头像 -->
    	     	<div class="personal_chat_img"><img src="images/quanzi1.png" alt=""></div>	
                <!-- 姓名 -->
                <span class="personal_chat_name_left">冼先生</span>
    	     	<!-- 三角形 -->
    	     	<em class="personal_chat_triangle_left"></em>
    	     	<!-- 聊天内容 -->
    	     	<div class="personal_chat_content">
    	     		<span>阿福是帅哥...阿福是帅哥...阿福是帅哥...</span>
    	     	</div>	
    	     </li>
    	     <!-- 右边 -->
    	     <li>
    	     	<!-- 时间 -->
    	     	<div class="personal_chat_time"><span>2018.01.01 12:00</span></div>
    	     	<!-- 头像 -->
    	     	<div class="personal_chat_img fn-right"><img src="images/pintuan02.png" alt=""></div>	
                <!-- 姓名 -->
                <span class="personal_chat_name_right">谭先生</span>
    	     	<!-- 三角形 -->
    	     	<em class="personal_chat_triangle_right"></em>
    	     	<!-- 聊天内容 -->
    	     	<div class="personal_chat_content fn-right">
    	     		<span>不用赞我，我会骄傲的！</span>
    	     	</div>	
    	     </li>
    	      <li>
    	     	<!-- 时间 -->
    	     	<div class="personal_chat_time"><span>2018.01.01 12:00</span></div>
    	     	<!-- 头像 -->
    	     	<div class="personal_chat_img fn-right"><img src="images/pintuan02.png" alt=""></div>	
                <!-- 姓名 -->
                <span class="personal_chat_name_right">谭先生</span>
    	     	<!-- 三角形 -->
    	     	<em class="personal_chat_triangle_right"></em>
    	     	<!-- 聊天内容 -->
    	     	<div class="personal_chat_content fn-right">
    	     		<img src="images/hongbao2.png" alt="">
    	     	</div>	
    	     </li>
    	 </ul>
      </div>
    </div>

    <!-- 输入框 -->
<div class="foot_bottom">
      <div class="search_gongg">
         <div class="foot_xia">
             <div id="form_article" contenteditable="true" onkeydown="myInput.listen(this, event);"></div>
         </div>   
            <span class="www send_t_btn icon-biaoqing" id="www"></span>
            <div class="personal_chat_uploading_img"><span class="icon-tupian"></span><input type="file" name="" class="icon-tupian"></div>
      </div>        
            <div class="page_emotion box_swipe" id="page_emotion">
			<dl id="list_emotion" class="list_emotion pt_10 yingc" hidden></dl><!-- 表情框 -->
			<dt><ol id="nav_emotion" class="nav_emotion yingc" hidden></ol></dt><!-- 分页提示点 -->
 </div>            
</div>





</div>
<script src="js/webiaoqin.js"></script>
<script>
	$(function(){
		var say = '说点什么...';
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
			
	$(".www").click(function(){
		if($(".yingc").css("display")=="none"){
		$(".yingc").show();
		}else{
		$(".yingc").hide();
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
   
   
   
  function add(){ 
	    var content = $.trim( $('#form_article').html() );
	   /* content=wxief._wxEmojiDetect(content);
        is_friend = ""*/
    	if( content == ''  ) {codefans('消息不能为空');return;}
    	if( is_friend < 2) {prompt();return;}
    	$('.send_t_btn1').attr('onclick','');	
	    var img = ''
        $.ajax({ 
            url:"",
            data:{id_from:id_from, id_to:id_to,content:content},
            type:'post',
            dataType:'json',
            success:function (data){
                if(data){ 
                     $('#form_article').html('');
                     $('.send_t_btn1').attr('onclick','add()');	
                	 message_list();
                }
            }
        })
    }  
</script>
<script type="text/javascript">
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