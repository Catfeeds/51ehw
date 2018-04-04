

<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
  .container {background: #f6f6f6;}
  .circle_publish ul li{height:auto;position: relative;}
  .circle_publish ul li img{height:100%!important;width:100%!important;vertical-align:middle; border:none;object-fit: cover;}
  .circle_publish_span{width:70px;height:70px;display: block; float: left;}
  .circle_publish_time { position: absolute;left: 90px;bottom: 8px;width: 100%;padding-right: 105px;}
  .circle_publish_time span:nth-child(2) {width: 85%;padding-right: 0;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>发布公告</span>
</div>
<?php }?>

<!-- 发布活动 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="circle_publish" id="sort">
<ul id="my_announcement_top"></ul>
</div>  

<!-- 添加发布 -->
<?php if($administrator){?>
<a href="<?php echo site_url("tribe/announcement_view");?>" class="circle_publish_jia custom_button">发布公告</a>
<?php };?>
  

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
  
<script>
//下拉加载数据
var page = 1;//默认加载页数
dropload = $('#sort').dropload({
    scrollArea : window,
	loadDownFn : function(me){
        var result = "";
        var label_id = "<?php echo $label_id;?>";
        var keyword = "<?php echo $keyword; ?>";
        if(label_id){
            var url = '<?php echo site_url("Commerce/ajax_notice_list");?>';
        }else{
        	var url = '<?php echo site_url("tribe/ajax_announcements");?>';
        }
        $.post(url,{page:page,app_labe_id:label_id,keyword:keyword},function(data){
            if(data["announcement_list"].length>0){
            	image_url = "<?php echo IMAGE_URL;?>";
                for(var i=0;i<data["announcement_list"].length;i++){
                	result += '<li id="del_'+data["announcement_list"][i]["id"]+'">';
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
					if(!label_id){
            			if(data["announcement_list"][i]["status"] == 0){
                        	result += '<span style="color:#eebc3b;">待审核</span>';
            			}else if(data["announcement_list"][i]["status"] == 1){
            				result += '<span style="color:#72d27e;">已通过</span>';
                		}else if(data["announcement_list"][i]["status"] == 2){
                			result += '<span style="color:#ff0000;">不通过</span>';
                		}
					}
        			result += '</div>';
        			result += '</a>';
    				result += '<p class="circle_publish_time"><span>'+data["announcement_list"][i]["last_updated_time"]+'</span>';
    				if(label_id){
						result += '<a href="<?php echo site_url("commerce/notice_state");?>/'+data["announcement_list"][i]['id']+'"><span style="color:red;">'+data["announcement_list"][i]["unreadnum"]+'人未读</span></a>';
    				}else{
    					result += '<span><a href="javascript:void(0);" onclick="shanchu('+data["announcement_list"][i]['id']+');" style="padding-right:10px;"><i class="icon-shanchu2"></i>删除</a><i class="icon-bianji"></i><a href="<?php echo site_url("tribe/announcement_view");?>/'+data["announcement_list"][i]["id"]+'">编辑</a></span>';
    				}
					result += '</p></li>';
                }
                $("#my_announcement_top").append(result);
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


</script>


<script type="text/javascript">
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
            url:"<?php echo site_url("tribe/ajax_delete_notice");?>",
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


