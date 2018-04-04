<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
   .container {background: #fff;}
</style>


<!-- 商会通知—接收人列表 -->

<div class="commerce_index">
	 <div class="commerce_choice_people">
      <div class="commerce_choice_nav">
        <ul>
            <li><a href="javascript:void(0);" class="commerce_choice_nav_active" onclick="navigation(1);">未读(<?php echo $unread_total;?>)</a></li>
            <li><a href="javascript:void(0);" onclick="navigation(2);">已读(<?php echo $read_total;?>)</a></li>
        </ul>
      </div>
      <!-- 列表 -->
  	<div class="commerce_choice_list" id="sort">
        <ul>
<!--             <li><a href="javascript:void(0);"><span class="commerce_yuan">峰</span><span class="commerce_notice_name">高峰</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><span class="commerce_yuan">峰</span><span class="commerce_notice_name">高峰</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><span class="commerce_yuan">峰</span><span class="commerce_notice_name">高峰</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><span class="commerce_yuan">峰</span><span class="commerce_notice_name">高峰</span></a></li> -->
<!--            <li><a href="javascript:void(0);"><span class="commerce_yuan">庆</span><span class="commerce_notice_name" style="letter-spacing: 0;">侯瑞庆</span></a></li> -->
<!--        	<li><a href="javascript:void(0);"><span class="commerce_yuan">庆</span><span class="commerce_notice_name" style="letter-spacing: 0;">侯瑞庆</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><span class="commerce_yuan">斌</span><span class="commerce_notice_name" >郭斌</span></a></li> -->
        </ul>
 	</div>
   </div>
</div>


<script type="text/javascript">
$(function(){
	$('.commerce_choice_nav ul li').on('click',function(){
		$(this).children('a').addClass('commerce_choice_nav_active');
		$(this).siblings('li').children('a').removeClass('commerce_choice_nav_active');
	})

	id = '<?php echo $id;?>';
	type = "<?php echo $type;?>";
	page = 1;
	dropload = $('#sort').dropload({
	    scrollArea : window,
		loadDownFn : function(me){
            $.post("<?php echo site_url("Commerce/ajax_notice_state");?>",{id:id,type:type,page:page},function(data){
                var result = "";
            	if(data['list'].length > 0){
                    for(var i=0;i<data["list"].length;i++){
                        var name = (data["list"][i]["real_name"]?data["list"][i]["real_name"]:data["list"][i]["member_name"]);
                        result += '<li><a href="javascript:void(0);"><span class="commerce_yuan">'+name.substr(0,1)+'</span><span class="commerce_notice_name" style="letter-spacing: 0;">'+name+'</span></a></li>';
                    }
                    $("#sort").children().append(result);
                    page++;
                    me.resetload();
            	}else{
                	// 锁定
                    me.lock();
                    // 无数据
                    me.noData();
                    me.resetload();
                }
            },"json")
		}
	});
})

	
//已读未读切换
function navigation(types){
	type = types;
	page = 1;
	$("#sort").children().empty();
	  // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();
}
</script>