<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
  .container {background: #f6f6f6;}
  .activities_neirong_xia {margin-right: 17px;}
  .my_activities_xia dd a {text-align: right;padding-right: 17px;display: inline-block;}
  .my_activities_top li {border-bottom:5px solid #f6f6f6;}
  .activities_nei_li_top i img {border: 1px solid #ddd;}
  .my_activities_xia i {font-size: 15px;vertical-align: inherit;}
  .my_activities_xia dd {text-align: right;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>活动管理列表</span>
</div>
<?php }?>
<span id="sort">
    <ul class="my_activities_top" id="my_activities_top"></ul>
</span>
<!-- 添加发布 -->
<a href="<?php echo site_url("tribe/publish_events_view");?>" class="circle_publish_jia custom_button">发布活动</a>

<!-- 弹窗 -->
<div class="tuichu_ball" hidden="" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>确认删除吗？</span></div>
         <div class="tuichu_ball_button">
           <a id="tuichu_sub" href="javascript:void(0);" onclick="del()">确定</a>
           <a href="javascript:void(0);" class="tribe_ball_cancel">取消</a>
         </div>      
      </div>
   </div>
 </div>



<script type="text/javascript">
    //下拉加载数据
    var page = 1;//默认加载页数
	dropload = $('#sort').dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
	        var result = "";
	        $.post("<?php echo site_url("tribe/Ajax_Activity_management");?>",{page:page},function(data){
	            if(data["activity_list"].length>0){
	            	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["activity_list"].length;i++){
	                	result += '<li id="del_'+data["activity_list"][i]["id"]+'">';
	                	result += '<div class="activities_nei_li">';
	                	result += '<div class="activities_nei_li_top">'; 
	                	result += '<a href="javascript:;"><i><img src="'+image_url+data["activity_list"][i]['logo']+'" onerror="this.src=\'images/tmp_logo.jpg\'"></i></a>';
	                	result += '<div class="activities_nei_li_xia">';
	                	result += '<a href="javascript:;">';
	                	result += '<div class="tirbe_active_box_title">';
	                	result += '<h2>'+data["activity_list"][i]['tribe_name']+'</h2>';
	                	// result += '<span style="color:#eebc3b;">待审核</span>';
	                	if(data["activity_list"][i]["status"] == 0){
                    	result += '<span style="color:#eebc3b;">待审核</span>';
        			    }else if(data["activity_list"][i]["status"] == 1){
        				result += '<span style="color:#72d27e;">已通过</span>';
            		    }else if(data["activity_list"][i]["status"] == 2){
            			result += '<span style="color:#ff0000;">不通过</span>';
            		    }
	                	result += '</div>';
	                	result += '<p><span>'+data["activity_list"][i]['update_at']+'</span></p>';
	                	result += '</a>';
	                	result += '</div>';
	                	result += '</div>';
	                	result += '<div class="activities_neirong">';
	                	result += '<a href="<?php echo site_url("tribe/activity_detaile");?>/'+data["activity_list"][i]['id']+'">';
	                	result += '<div class="activities_neirong_xia">';
	                	result += '<p>'+data["activity_list"][i]['name']+'</p>' 
                		result += '<img src="'+image_url+data["activity_list"][i]['banner_img']+'">';  
	                	result += '</div>';
	                	result += '</a>';  
	                	result += '</div>';
	                	result += '<dl class="my_activities_xia">';
	                	result += '<dd><a href="javascript:void(0);" onclick="shanchu('+data["activity_list"][i]['id']+');"><span><i class="icon-shanchu2"></i>删除</span></a><a href="<?php echo site_url("tribe/publish_events_view");?>/'+data["activity_list"][i]['id']+'"><span><i class="icon-bianji"></i>编辑</span></a></dd>';
	                	result += '</dl>';
	                	result += '</div>';
	                	result += '</li>';
	                }
	                $("#my_activities_top").append(result);
	                page++;
	                me.resetload();
	            }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
	            }
	        },"json");
    	}
	});

    function shanchu($id) {
       $('.tuichu_ball').show();
       //获取点击删除活动的对象id
       id = $id;
       that = "del_"+$id;
    }
    // 点击取消
	$(".tribe_ball_cancel").on('click',function(){
	  $('.tuichu_ball').hide();
	})
	//点击删除
	function del() {		
		$('.tuichu_ball').hide();
		$.ajax({
			type:"post",
			url:"<?php echo site_url("tribe/ajax_delete_activity");?>",
			data:{"id":id},
			dataType:"json",
			success:function(date){
				if(date.status == 2) {
					$('#'+that).remove();	
				}
			}
		})
	}
</script>
        
        
                                                                               
