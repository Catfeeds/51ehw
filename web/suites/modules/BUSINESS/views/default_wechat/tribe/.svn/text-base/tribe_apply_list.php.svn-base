<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
  .container {background: #f6f6f6;}
  .my_activities_top li {border-bottom: 1px solid #d4d4d4;}
  .activities_nei_li_top i img {border-radius: 5px;}
  .activities_nei_li_xia h2 span {font-size: 12px;color: #999999;padding-left: 10px;margin-right: 0;}
  .activities_nei_li_xia p span {display: block;overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis;color:#333333;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>申请列表</span>
</div>
<?php }?>
<!-- 搜索框 -->
<p class="tribe_add_apply_search">
    <a href="javascript:void(0);">
        <i class="icon-sousuo"></i>
        <input type="text" name="keyword" value="" placeholder="请输入姓名或企业名" onkeyup="search();">
    </a>
</p>

<div id="sort">
    <ul class="my_activities_top" id="my_activities_top"></ul>
</div>


<script type="text/javascript">
    //下拉加载数据
    var page = 1;//默认加载页数
    var keyword = null;//关键词
	dropload = $('#sort').dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
	        var result = "";
	        $.post("<?php echo site_url("tribe/Ajax_apply_list");?>",{page:page,keyword:keyword},function(data){
	            if(data["apply_list"].length>0){
	            	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["apply_list"].length;i++){
		                	if(data["apply_list"][i]["real_name"]){
								var name = data["apply_list"][i]["real_name"];
		                	}else if(data["apply_list"][i]["member_name"]){
			                	var name = data["apply_list"][i]["member_name"];
		                	}else{
								var name = data["apply_list"][i]["mobile"];
		                	}
    	                	result += '<li onclick="location.href=\'<?php echo site_url("tribe/Family_member");?>/'+data["apply_list"][i]['id']+'\'">';
    	                	result += '<div class="activities_nei_li">';
    	                	result += '<div class="activities_nei_li_top">'; 
    	                	result += '<a href="javascript:;"><i><img src="'+image_url+data["apply_list"][i]['wechat_avatar']+'" onerror="this.src=\'images/tmp_logo.jpg\'"></i></a>';
    	                	result += '<div class="activities_nei_li_xia">';
    	                	result += '<a href="javascript:;">';
    	                	result += '<h2>'+name+'<span>'+(data["apply_list"][i]["corp_name"]?data["apply_list"][i]["corp_name"]:"");+'</span></h2>';
    	                	result += '<p><span></span></p>';
    	                	result += '</a>';
    	                	result += '</div>';
    	                	if(data["apply_list"][i]["status"] == 1){
    	                        result += '<div class="tribe_add_apply_status"><span style="color: #fff;background: #72d27e;border-radius: 5px;">待审核</span></div>';
    	                    }else if(data["apply_list"][i]["status"] == 2){
    	                    	result += '<div class="tribe_add_apply_status"><span>已添加</span></div>';
    	                    }else if(data["apply_list"][i]["status"] == 3){
    	                    	result += '<div class="tribe_add_apply_status"><span style="color:#ff0000;">审核不通过</span></div>';
    	                    }
    	                	result += '</div>';
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


    //ajax搜索
    function search(){
    	keyword = $("input[name=keyword]").val();
    	$("#my_activities_top").empty();
    	page = 1;//默认第一页
        // 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
    }
</script>