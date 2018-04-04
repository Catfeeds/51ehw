
<div class="binding">
   <div class="dialog">
       <div id="search">
        <input name="searchword" id="btn" type="text" class="btn" value="搜索关键词" onfocus="if(this.value=='搜索关键词')this.value=''; this.style.color ='#333';" onblur="if(this.value == ''){this.value='搜索关键词'; this.style.color ='#999999';}" style="color: rgb(153, 153, 153);">
        </div>
      <ul>
         <li class="dialog_li ">
           <em><span class="dialog_min"><img src="images/chatting/qq1.jpg"title=""></span><span class="dialog_min1">易墨轩</span></em>
           <samp>2</samp>
         </li>
        <li class="dialog_li">
            <em><span class="dialog_min"><img src="images/chatting/chatting2.png"title=""></span><span class="dialog_min1">小小的衣橱</span></em>
             <samp>2</samp>
        </li>
        <li class="dialog_li">
             <em><span class="dialog_min"><img src="images/chatting/qq1.jpg"title=""></span><span class="dialog_min1">易墨轩</span></em>
        </li>
      
      </ul>  
   
   </div>
   
 
<div class="system_chatting1">
  <div class="im-header1">
  <em> <a href="#" class="im-logo" target="_blank" id="shopLogo"><img src="images/chatting/gaungao.jpg"title=""> </a> </em>
    <span class="im-chat-object" id="logoTitle"><a href="#">51易货网系统客服</a></span>
    <div class="im-btn-area" id="win_title">
        <a href="#" id="j_chatClose" class="im-btn-close" title="关闭"><img src="images/chatting/chattingx.png"title=""></a>
    </div>
</div> 
  <div class="im-content1">
    <div class="im-chat-window clearfix">
       <div class="im-chat-window_top" id="im-chat-window_top">
        <div class="service_top">
          <div class="talk_recordbox">
				<div class="user"><img src="images/chatting/gaungao.jpg"title=""> </div>
				<div class="talk_recordtextbg"></div>
				<div class="talk_recordtext">
                <em>
                <span class="talk_timel">陕西二十一城广告文化传媒有限公司</span>
                <span class="talk_time">2014-09-15 15:06</span>
                </em>
				<h3>欢迎光临西安冠杰文化媒体有限公司，客服小张即将为您服务，请稍等</h3>
				</div>
			</div>
            </div>
            <div class="service_bottom">
            <div class="talk_recordboxme">
				<div class="user"><img src="images/chatting/chatting2.png"title=""> </div>
				<div class="talk_recordtextbg"></div>
				<div class="talk_recordtext">
			    <em>
                <span class="talk_timel">张小小</span>
                <span class="talk_time">2014-09-15 15:06</span>
                </em>
				<h3>欢迎光临西安冠杰文化媒体有限公司，客服小张即将为您服务，请稍等</h3>
				</div>
			</div>
              <div class="talk_recordboxme">
				<div class="user"><img src="images/chatting/chatting2.png"title=""> </div>
				<div class="talk_recordtextbg"></div>
				<div class="talk_recordtext">
			    <em>
                <span class="talk_timel">张小小</span>
                <span class="talk_time">2014-09-15 15:06</span>
                </em>
				<h3>欢迎光临西安冠杰文化媒体有限公司，客服小张即将为您服务，请稍等</h3>
				</div>
			</div>
            </div>
            </div>
       
       <div class="im-edit-area" id="im-edit-area">
        <div class="im-edit-toolbar">
            <em><a href="javascript:void(0);" class="emotion" title="选择表情" id="expressionButton"></a><span>表情</span></em>
            <em><input type="file" value="" id='file' name="imgOne"  onchange="preImg(this.id,'imgPre');" style="display:none;"/>
           <span onclick="file.click();" class="ball-head-portrait-button">
           <a href="javascript:void(0);" class="im-icon-pic" title="贴图"></a> </span> 
            <span class="im-txt" id="sendImageButton">图片</span>  </em>
        </div>
         <div class="problem">
          <textarea class="input"  id="saytext"  name="saytext" placeholder="请说明您要咨询的问题……"></textarea>
          </div>
          <div class="problem1">
          <p>
             <span class="im-btn-l"><a href="javascript:void(0);">关闭</a></span>
             <span class="im-btn-r"><a href="javascript:void(0);">发送</a></span>
          </p>
          </div>
        </div>
    </div> 
    <div class="im-right-sidebar"> 
       <h4>客户信息</h4>
      <div class="im-right-sidebar_t" style="display:block">
       <p>联系人：张大大</p>
        <p>联系电话：18412014774 </p>
      </div>
      <div class="im-right-sidebar_r" style="display:none">
        <h5><img src="images/chatting/gaungao.jpg"/></h5>
        <h6>陕西二十一城广告文化传媒有限公司</h6>
        <p><span>联系人：</span><samp>张大大</samp></p>
        <p><span>联系电话：</span><samp>18412014774</samp></p>
        <p><span>联系地址：</span><samp>陕西省杨凌示范区渭惠路1010号</samp></p>
        <div class="get_into">
        <a href="#">进入店铺</a>
      </div>
      </div>
  </div>
</div>
</div>
</div>












<script  src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.qqFace.js"></script>
<script type="text/javascript">
$(function(){
	$('.emotion').qqFace({
		id : 'facebox', 
		assign:'saytext', 
		path:'images/arclist/'	//表情存放的路径
	});
	$(".im-btn-r").click(function(){
		var str = $("#saytext").val();
		$("#im-chat-window_top").html(replace_em(str));
	});
});
//查看结果
function replace_em(str){
	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>');
	str = str.replace(/\[em_([0-9]*)\]/g,'<img src="images/arclist/$1.gif" border="0" />');
	return str;
}
</script>
<script>
	
	$(".dialog li").on("click", function() {
		var index = $(this).index();
		$(this).addClass("active").siblings().removeClass("active");
	
	})
</script>