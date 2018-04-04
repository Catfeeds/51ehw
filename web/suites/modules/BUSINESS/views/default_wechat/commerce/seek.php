<style type="text/css">
  .container {background: #f4f4f4;}
  .circle_publish ul li {height: auto;position: relative;margin-bottom: 0;}
  .circle_publish_time {position: absolute;left: 90px;bottom: 8px;width: 100%;padding-right: 105px;}
  .circle_publish ul li img {height: 100%!important;width: 100%!important;vertical-align: middle;border: none;object-fit: cover;}
  .circle_publish_span {width: 70px;height: 70px;display: block;float: left;}
  .my_activities_top li {border-bottom: 1px solid #dddddd;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->

<!-- 发现 -->
<div class="find">
   <!-- 导航 -->
   <div class='find_nav'>
     <ul>
         <li><a href="javascript:void(0);" class="find_nav_active">动态</a></li>
         <li><a href="javascript:void(0);">活动</a></li>
     </ul>
   </div>
   <div>
     <!-- 动态 -->
     <div class="find_trends" id ="boxs">
        <div class="circle_publish">
           <ul id ="boxs_trends">
            </ul>
     </div>
     <!-- 活动 -->
       <div class="my_activities" hidden>
          <ul class="my_activities_top" id ="boxs_activities">
           
         
        </ul>
      </div>
     </div>
   </div>
</div>

<script type="text/javascript">

var type = 0;
//下拉加载数据
var page = 1;//默认加载页数
dropload = $('#boxs').dropload({
    scrollArea : window,
	loadDownFn : function(me){
        var result = "";
        var label_id = "<?php echo $label_id;?>";
        if(type == 0){
        	var url = '<?php echo site_url("Commerce/ajax_notice_list");?>';
            }else{
            	var url = '<?php echo site_url("Commerce/ajax_activity_list");?>';
                }
        $.post(url,{page:page,app_labe_id:label_id},function(data){
			if(type == 0){
				if(data["announcement_list"].length>0){
	            	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["announcement_list"].length;i++){
	                	result += '<li>';
	                	result += '<a href="<?php echo site_url("tribe/announcement_detaile/");?>/'+data["announcement_list"][i]["id"]+'/'+data["announcement_list"][i]["tribe_id"];
	                	<?php if($label_id){?>
						result += '/0">';
						<?php }else{ ?>
						result += '/1">';
						<?php }?>
	                	result += '<span class="circle_publish_span">';
	                	result += '<img src="'+image_url+data["announcement_list"][i]["title_img"]+'" onerror="this.src=\'images/member_defult.png\'">';
	                	result += '</span>';
	                	result += '<div class="circle_publish_right">';
	                	result += '<p class="circle_publish_title">'+data["announcement_list"][i]["title"]+'</p>';
	                	result += '</div>';
	                	result += '</a>';
	                	result += '<p class="circle_publish_time">';
	                	result += '<span>'+data["announcement_list"][i]["last_updated_time"]+'</span>';
	                	result += '<a href="<?php echo site_url("commerce/notice_state");?>/'+data["announcement_list"][i]['id']+'">';
	                	result += '<span style="color:red;">'+data["announcement_list"][i]["unreadnum"]+'人未读</span>';
	                	result += '</a>';
	                	result += '</p>';
	                	result += '</li>';
	                }
	                $("#boxs_trends").append(result);
	                page++;
	                me.resetload();
	            }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
	            }
		}else{
    			if(data["activity_list"].length>0){
                	image_url = "<?php echo IMAGE_URL;?>";
                    for(var i=0;i<data["activity_list"].length;i++){
                    	result += '<li>';
                    	result += '<div class="activities_nei_li">';
                    	result += '<div class="activities_nei_li_top"> ';
                    	result += '<i><img src="'+image_url+data["activity_list"][i]["tribe_logo"]+'" onerror="this.src=\'images/tmp_logo.jpg\'"></i>';
                    	result += '<div class="activities_nei_li_xia">';
                    	result += '<h2>'+data["activity_list"][i]["tribe_name"]+'</h2>';
                    	result += '<p><span>'+data["activity_list"][i]["created_at"]+'</span></p>';
                    	result += '</div>';
                    	result += '</div>';
                    	result += '<div class="activities_neirong">';
                    	result += '<a href="<?php echo site_url('Tribe/activity_detaile/');?>/'+data["activity_list"][i]["id"]+'">';
                    	result += '<div class="activities_neirong_xia">';
                    	result += '<p>'+data["activity_list"][i]["name"]+'</p>';
                    	result += '<img src="'+image_url+data["activity_list"][i]["banner_img"]+'" >';
                    	result += '</div>';
                    	result += ' </a>  ';
                    	result += ' </div>';
                    	result += ' </div>';
                    	result += ' </li>';
                    }
                    $("#boxs_activities").append(result);
                    page++;
                    me.resetload();
                }else{
                	// 锁定
                    me.lock();
                    // 无数据
                    me.noData();
                    me.resetload();
                }
			}
        },"json");
	}
});


$('.find_nav ul li').on('click',function(){
    $(this).children('a').addClass('find_nav_active');
    $(this).siblings('li').children('a').removeClass('find_nav_active');
    var index = $(this).index();
    if (index == 0) {
      type = 0;
      $("#boxs_activities").empty();
      $('.circle_publish').show();
      $('.my_activities').hide();
    } else{
      type = 1;
      $("#boxs_trends").empty();
      $('.circle_publish').hide();
      $('.my_activities').show();
    };
    page = 1;//默认第一页
    // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();


    
  })
</script>