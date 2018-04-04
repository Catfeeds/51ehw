<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<script type="text/javascript" src="js/Public.js"></script><!-- 公共类 -->
<style type="text/css">
  .circle_zhong_ul li:last-child {border-bottom: none;}
  .circle_zhong_dl {padding: 0 15px;border-bottom: 1px solid #d8d8d8;}
  .circle_zhong_dl dd:nth-child(1) {margin-left: 0;}
  .circle_zhong_dl dd:nth-child(2) {text-align: right;}
  .circle_zhong_dl dd {width: 50%;}
  .circle_zhong_dl i {vertical-align: text-bottom;}
  .circle_zhong_dl span {color: #888888;}
</style>
<!-- 圈子管理 -->
<div class="circle_zhong" style="margin-bottom:50px; margin-top:0; padding-top:0" id="sort">
    <ul class="circle_zhong_ul" id="list"></ul>
</div>

<aside class="mask works-mask" id="prompt" style="display: none;">
    <div class="mask-content">
     	<p class="del-p "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;" id="message">您确定要删除话题吗？</font></font></p>
		<p class="check-p"><span class="del-com wsdel-ok" flag="images.jpeg10538"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;" id="sub" onclick="">确定</font></font></span><span class="wsdel-no"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;" onclick='$("#prompt").hide();'>取消</font></font></span></p>
	</div>
</aside>

<script type="text/javascript">
    //下拉加载数据
    var page = 1;//默认加载页码
	dropload = $('#sort').dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
	        var result = "";
	        $.post("<?php echo site_url("tribe/ajax_topic_list");?>",{page:page},function(data){
	            if(data["TopicList"].length>0){
	            	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["TopicList"].length;i++){
	                	result += '<li id="topic_'+data["TopicList"][i]["id"]+'">';
	                	result += '<div class="circle_zhong_ul_li">';
	                	result += '<div class="circle_zhong_ul_top">'; 
	                	result += '<a href="<?php echo site_url("Tribe/Members_Info");?>/'+data['TopicList'][i]["tribe_id"]+'/'+data['TopicList'][i]["staff_id"]+'"><i><img src="'+image_url+data["TopicList"][i]["wechat_avatar"]+'" onerror="this.src=\'images/member_defult.png\'"></i></a>';
	                	result += '<div class="circle_zhong_ul_xia">';
	                	result += '<a href="<?php echo site_url("Home/GetShopGoods");?>/'+data['TopicList'][i]["corp_id"]+'">';
	                	result += '<div class="circle_zhong_dd"><h2><span>'+data["TopicList"][i]["name"]+'</span><samp>'+(data["TopicList"][i]["approval_status"] == 2 && data["TopicList"][i]["corp_status"] == 1?data["TopicList"][i]["corporation_name"]:"")+'</samp></h2></div>';
	                	result += '<p><span>'+getDateDiff(data["TopicList"][i]["created_at"]);+'</span>'+(data["TopicList"][i]["approval_status"] == 2 && data["TopicList"][i]["corp_status"] == 1?"<span class=\"quanzi_shop\"><em class=\"icon-shop2\"></em>店铺</span>":"")+'</p>';
	                	result += '</a>';
	                	result += '</div>';
	                	result += '</div>';
	                	result += '<div class="circle_zhong_ul_neirong" id="box_28">';
	                	result += '<div><a href="javascript:void(0);">';
	                	result += '<p>'+data["TopicList"][i]["content"]+'</p></a>';
	                	result += '</div>';
	                	result += '<a href="javascript:void(0);"></a>';
	                	result += '</div>';
	                	result += '</div>';
	                	result += '<div class="hot_circle_study_top">';
	                	result += '<ul data-am-widget="gallery" class="hot_circle_study_gun am-no-layout" data-am-gallery="{ pureview: true}">';
						for(var j=0;j<data["TopicList"][i]["images"].length;j++){
							if(data["TopicList"][i]["images"][j]){
	                			result += '<li><a href="javascript:void(0);"><img src="'+image_url+data["TopicList"][i]["images"][j]+'" data-am-pureviewed="1"></a></li>';
							}
						}
						result += '</ul>';
	                	result += '</div>';
	                	result += '<dl class="circle_zhong_dl">';
	                	result += '<dd><a href="javascript:void(0);"><span><i class="icon-jubao"></i>举报('+data["TopicList"][i]["quantity"]+')</span></a></dd>';
	                	result += '<dd><a href="javascript:void(0);" onclick="prompt('+data["TopicList"][i]["id"]+')"><span><i class="icon-shanchu2"></i>删除</span></a></dd>';
	                	result += '</dl>';
	                	result += '</li>';
	                }
	                $("#list").append(result);
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

    //提示
	function prompt(id){
		$("#sub").attr("onclick",'Del_Topic("'+id+'")');
		$("#prompt").show();
	}
    

    //删除圈子话题
	function Del_Topic(id){
		$.post("<?php echo site_url("tribe/Del_Topic");?>",{id,id},function(data){
			location.reload();return;
		},"json");
	}

    
</script>
        
        
                                                                               
