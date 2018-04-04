<style>
.tribe_shop_footer ul li{width:25%}
.hot_circle_study_top {}
.hot_circle_study_gun {white-space: normal;width: 23.5rem;font-size: inherit;}
.hot_circle_study_gun li {margin-right: 0px;width: 7.5rem;height: 7.5rem;}
.hot_circle_study_gun li:nth-child(3n+1){ margin-right: 0.5rem;}
.hot_circle_study_gun li:nth-child(3n+2){ margin-right: 0.5rem;}
.hot_circle_study_gun li:nth-child(3n){ padding-left: 0;}
.circle_zhong_dl {margin-top: 1px;}
/*.circle_zhong_ul {opacity: 0;}*/
  .new_img_list {overflow: hidden;}
  .new_img_list li {float: left;width: 3rem!important;height: 3rem;border-bottom: none;margin-bottom: 5px;margin-left: 0.13rem;}
  .new_img_list_box {margin: 0 0.3rem 0 0.2rem;}
  .circle_zhong_ul_xia h2 samp {vertical-align: inherit;}
  .circle_zhong {padding-top: 0;border-top: 2px solid #eee;}
  .circle_zhong_ul li {border-bottom: none;}
  .detailed_comments_ul li {border-bottom: 1px solid #eeeeee!important;}
  .circle_zhong_ul li {width: auto;}
  .detailed_comments {padding-bottom: 0;}
  .circle_zhong_ul span:nth-child(1) .circle_zhong {border:none!important;}
  #sss{ height:170px;}
</style>
<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/format_time.js"></script><!-- 时间函数 -->

<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<?php if($me){?>
<div class="head_top">
   <div class="head_top_nei">
      <a href="javascript:history.back();" class=""><span class="icon-back"></span></a>
	<div class="search_circh" id="yanse"></div>
    <a href="<?php echo site_url('Corporation_style/Add_Topic')?>" class="icon-release" id="suos3"></a>
    </div>
</div>
<?php };?>
   <!--圈子内容-->
   <div class="container" >
     <div class="circle_neir" style="margin-top: 0px;">
     <div class="circle_li_xia_d">
	     <form action="<?php echo site_url('Circles/Update_Background');?> "method="post" enctype="multipart/form-data" id="form1">
	       	<div class="LUploader" id="demo1">
			<div id="sss">
				<img class="acc_imgin" src="<?php echo IMAGE_URL.$user_info["bg_img"];?>" onerror="this.src='images/bg_tribe_01.png'" >
			    <div class="acc_sc">
				<a href="javascript:;" class="tc acc_scicon"></a>
				<?php if($me){?>
				<input type="file" name="file" onchange="background_img()" class="ph08" />
				<input type="hidden" name='status' value="1">
				<?php }else{;?>
				<input disabled="true" class="ph08" />
				<?php };?>
				
				</div>
			</div>
	    	</div>
	    	<div class="circle_li_xia">
	        	<a href="javascript:void(0);" id="btni">
	            <img src="<?php echo $user_info["brief_avatar"]?IMAGE_URL.$user_info["brief_avatar"]:$user_info["wechat_avatar"];?>"  onerror="this.src='images/member_defult.png'"/>  
	            </a>
	             <span><?php echo $real_name;?></span>
	        </div>
	    </form>
    </div>  
	</div>
     <?php if( $me && $message_total > 0  ) {?>
     <div class="information_x">
		<a href="<?php echo site_url('Corporation_style/My_Message')?>">
       		<img src="<?php echo $user_info["brief_avatar"]?IMAGE_URL.$user_info["brief_avatar"]:$user_info["wechat_avatar"];?>"  onerror="this.src='images/member_defult.png'"/>
        	<span>您有<?php echo $message_total;?>条新消息<i class="icon-icon_go"></i></span>
		</a>
     </div>
     <?php }?>
     <div class="" style="margin-bottom:50px; margin-top:0; padding-top:0">
     <span id="list">
     <ul class="circle_zhong_ul" id="lists"><!-- 话题内容 --></ul>    
     </span>                                                                     
     </div>  
  </div>

  <!-- 该圈子还没有话题 -->
  <div class="circles_no" hidden>
    <span class="icon-huati"></span>
    <span>该圈子还没有话题快去发布第一个话题吧</span>
  </div>

  
  
	<!--通用删除评论-->     
	<div class="delete_pinglun" id="con" hidden>
    	<div class="delete_nei">
       		<ul>
			  <li class="delete_nei_t">
			    <a href="<?php //echo site_url('Circles/Add_Topic/1/?tribe_id='.$tribe_id)?>">发文字</a></li>
			  <li class="delete_nei_z">
			    <a href="<?php //echo site_url('Circles/Add_Topic/?tribe_id='.$tribe_id)?>">发图文</a></li>
			  <li class="delete_nei_b cancels">
			    <a href="javascript:void(0);" onclick="comment_hide();">取消</a></li>
			</ul>
    	</div>
	</div>  
      



<!--点击弹出弹窗-->
<script>
$(function () { 
	  var isPageHide = false; 
	  window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
	  }); 
	  window.addEventListener('pagehide', function () { 
	    isPageHide = true; 
	  }); 
})

var user_id = "<?php echo $user_info["id"];?>";
var customer_id = "<?php echo $customer_id;?>";
var page = 1;//默认加载页数
dropload = $('#list').dropload({
    scrollArea : window,
	loadDownFn : function(me){
        
		var result = "";
		$.post("<?php echo site_url("corporation_style/Topic_List");?>",{user_id:user_id,page:page},function(data){
			if(data["topic_list"].length>0){
				for(var i=0;i<data["topic_list"].length;i++){
					var image_url = "<?php echo IMAGE_URL; ?>";
					var avatar = (data["topic_list"][i]["brief_avatar"]?image_url+data["topic_list"][i]["brief_avatar"]:data["topic_list"][i]["wechat_avatar"]);//头像
					var name = (data["topic_list"][i]["real_name"]?data["topic_list"][i]["real_name"]:(data["topic_list"][i]["member_name"]?data["topic_list"][i]["member_name"]:data["topic_list"][i]["name"]));
					var content = data["topic_list"][i]["content"]?data["topic_list"][i]["content"]:'';
					var upvote_num = (data["topic_list"][i]["upvote_info"]?data["topic_list"][i]["upvote_info"].length:0);
					var comment_num = (data["topic_list"][i]["comment"]?data["topic_list"][i]["comment"].length:0);
		    		result += '<span id="topic_'+data["topic_list"][i]["id"]+'">';
					result += '<div class="circle_zhong">';
					result += '<ul class="circle_zhong_ul">';
					result += '<li id="topic_content_'+data["topic_list"][i]["id"]+'">';
					result += '<div class="circle_zhong_ul_li">';
					result += '<div class="circle_zhong_ul_top">'; 
					result += '<a href="javascript:void(0);"><i><img src="'+avatar+'" onerror="this.src=\'images/member_defult.png\'"></i></a>';
					result += '<div class="circle_zhong_ul_xia">';
					result += '<a href="javascript:void(0);">';
					result += '<div class="circle_zhong_dd">';
					result += '<h2><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+name+'</font></font></span><samp><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data['topic_list'][i]["organization_name"]?data['topic_list'][i]["organization_name"]:"")+(data['topic_list'][i]["organizationl_duties"]?','+data['topic_list'][i]["organizationl_duties"]:"")+'</font></font></samp></h2>';
					result += '</div>';
					result += '<p>';
					result += '<span id="create_time"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["created_at"])+'</font></font></span>';
		    		result += '</p>';
					result += '</a>';
					result += '</div>';
					result += '</div>';
					result += '<div class="circle_zhong_ul_neirong" id="box">';
					result += '<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["content"]?data["topic_list"][i]["content"]:"")+'</font></font></p>';
					result += '</div>';
					result += '</div>';  

					//图片
					if(data["topic_list"][i]["images"]){
						var image = data["topic_list"][i]["images"].trim(';', 'right').split(";");
		    			result += '<div class="new_img_list_box">';
		    			result += '<ul data-am-widget="gallery" class="new_img_list am-no-layout" data-am-gallery="{ pureview: true }">';
		    			for(var n=0;n<image.length;n++){
		        			result += '<li>';
		        			result += '<a href="'+image_url+image[n]+'">';
		        			result += '<img src="'+image_url+image[n]+'">';
		        			result += '</a>'; 
		        			result += '</li>';
		    			} 
		    			result += '</ul>';  
		    			result += '</div>';  
					}
					
					  
					result += '<dl class="circle_zhong_dl">';
					result += '<dd><span><i class="icon-not_praise';
					//判断我是否点赞
					if(upvote_num){
		    			for(var n=0; n< data["topic_list"][i]["upvote_info"].length; n++){
							if(data["topic_list"][i]["upvote_info"][n]["customer_id"] == customer_id){
								result += ' icon-already_praised1 bounceIn';
							}
		        		}
					}
					result += '"  id="upvote_'+(data["topic_list"][i]["id"])+'" onclick="upvote('+(data["topic_list"][i]["id"])+')"><span class="zan_num"><font style="vertical-align: inherit;"><font id="upvote_num_'+(data["topic_list"][i]["id"])+'" style="vertical-align: inherit;">'+upvote_num+'</font></font></span></i></span></dd>';
					result += '<dd><a href="<?php echo site_url("corporation_style/Comment");?>/'+data["topic_list"][i]["id"]+'"><span><i class="icon-comment1" style="vertical-align: text-bottom;"></i><span class="comment_num"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+comment_num+'</font></font></span></span></a></dd>';
					if(data["topic_list"][i]["corp_id"]){
		          		result += '<dd><a href="<?php echo site_url("Home/GetShopGoods");?>/'+data["topic_list"][i]["corp_id"]+'"><span><i class="icon-shop" style="vertical-align: text-bottom;"></i><span class="comment_num">店铺</span></span></a></dd>';
					}
					//删除
					if(data["topic_list"][i]["customer_id"] == customer_id ){
					result += '<dd><a href="javascript:Delete_Topic('+data["topic_list"][i]["id"]+');"><span><i class="icon-delete"></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">删除</font></font></span></a></dd>';
					};
					
					result += '</dl>';
					
					//点赞
					if(upvote_num){
		    			result += '<div class="dianzan_name">';
		    			result += '<i class="icon-not_praise icon-already_praised1 circles_dianzan"></i>';
		    			result += '<span><font style="vertical-align: inherit;" class="upvote_user_'+data["topic_list"][i]["id"]+'">';
		    			for(var n=0; n< data["topic_list"][i]["upvote_info"].length; n++){
							result += '<span id="upvote_user_'+(data["topic_list"][i]["upvote_info"][n]["customer_id"])+'_'+data["topic_list"][i]["id"]+'">';
		        			if(n){
		        				result += ",";
		        			}
		    				result += (data["topic_list"][i]["upvote_info"][n]['real_name']?data["topic_list"][i]["upvote_info"][n]['real_name']:(data["topic_list"][i]["upvote_info"][n]['member_name']?data["topic_list"][i]["upvote_info"][n]['member_name']:data["topic_list"][i]["upvote_info"][n]['name']))+'</span>';
		        		}
		    			result += '</font></span><span class="douhao" style="display:none"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">，</font></font></span>';
		    			result += '</div>';
					}
					result += '</li>';
					result += '</ul>';
					result += '</div>';
					
					//评论
					if(comment_num){
		    			result += '<div class="detailed_comments">';
		    			for(var n=0; n < data["topic_list"][i]["comment"].length; n++){
		        			var form_name = (data["topic_list"][i]["comment"][n]["real_name"]?data["topic_list"][i]["comment"][n]["real_name"]:(data["topic_list"][i]["comment"][n]["member_name"]?data["topic_list"][i]["comment"][n]["member_name"]:data["topic_list"][i]["comment"][n]["name"]));//回复人名字
		        			result += '<ul class="detailed_comments_ul">';
		        			result += '<i class="icon-pinglun1" style="position: absolute;left: 7%;font-size: 14px;color: #69719e;top: 15px;"></i>';    
		        			result += '<li id="comment_90"><div class="detailed_comments_ul_nei">';
		        			result += '<a href="javascript:void(0);"><i class=""><img src="'+(data["topic_list"][i]["comment"][n]["brief_avatar"]?image_url+data["topic_list"][i]["comment"][n]["brief_avatar"]:data["topic_list"][i]["comment"][n]["wechat_avatar"])+'" onerror="this.src=\'images/member_defult.png\'"></i></a>';
		        			result += '<div class="detailed_comments_r">';
		        			if(data["topic_list"][i]["comment"][n]["customer_id"] != customer_id){
		        				result += '<a href="<?php echo site_url("corporation_style/Comment");?>/'+data["topic_list"][i]["id"]+'/'+data["topic_list"][i]["comment"][n]["id"]+'/'+form_name+'" >';
		        			}else{
		        				result += '<a href="javascript:void(0);">';
			        		}
		        			result += '<h2><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+form_name+'</font></font></span></h2><span class="circles_pinlun_time"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["comment"][n]["created_at"])+'</font></font></span>';
		        			result += '<h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["comment"][n]["parent_id"] > 0?"回复"+(data["topic_list"][i]["comment"][n]["to_real_name"]?data["topic_list"][i]["comment"][n]["to_real_name"]:(data["topic_list"][i]["comment"][n]["to_member_name"]?data["topic_list"][i]["comment"][n]["to_member_name"]:data["topic_list"][i]["comment"][n]["to_name"]))+"：":"")+ (data["topic_list"][i]["comment"][n]["content"])+'</font></font></h3>';
		        			result += '</a></div>';
		        			result += '</div></li></ul>';
		    			}
		    			result += '</div>';
					};
					result += '</span>';
				}

				$.getScript("js/amazeui.js");
				$("#lists").append(result);
				page++;
                me.resetload();
			}else{
				// 无数据
				me.lock();// 锁定
                me.noData();
                me.resetload();
                $('.dropload-noData').hide();
			}
		},"json"); 
	}
});

//ajax 点赞 or 取消
function upvote(id){
	var real_name = "<?php echo $real_name;?>";
	var upvote_num = $("#upvote_num_"+id).text();//点赞人数
	$.post("<?php echo site_url("corporation_style/Add_Upvote");?>",{obj_id:id},function(data){
		if(data["status"]){
			if(data["type"]==1){//取消赞
				$("#upvote_"+id).attr("class","icon-not_praise");
				$("#upvote_num_"+id).text((upvote_num*1-1*1));//点赞人数
				if(upvote_num == 1){
					$("#topic_content_"+id).children('.dianzan_name').remove();
				}else{
					$("#upvote_user_"+customer_id+'_'+id).remove();//删除点赞人名称
				}
			}else{//点赞
				$("#upvote_"+id).attr("class","icon-not_praise icon-already_praised1 bounceIn");
				$("#upvote_num_"+id).text((upvote_num*1+1*1));//点赞人数
				if(upvote_num > 0){
					real_name = ','+real_name;
					$(".upvote_user_"+id).append('<span id="upvote_user_'+customer_id+'_'+id+'">'+real_name+'</span>');
				}else{
					result = '<div class="dianzan_name">';
					result += '<i class="icon-not_praise icon-already_praised1 circles_dianzan"></i>';
					result += '<span>';
					result += '<font style="vertical-align: inherit;" class="upvote_user">';
					result += '<span id="upvote_user_'+customer_id+'_'+id+'">';
					result += real_name;
					result += '</span>';
					result += '</font>';
					result += '</span>';
					result += '<span class="douhao" style="display:none">';
					result += '<font style="vertical-align: inherit;"></font>';
					result += '</span>';
					result += '</div>';
					$("#topic_content_"+id).append(result);
				}
				
			}
		}else{//操作失败
			alert("网络异常，请稍后再试");
			location.reload();
		}
	},"json");
}

//删除话题
function Delete_Topic(id){
	$.post("<?php echo site_url("corporation_style/Delete_Topic");?>",{id:id},function(data){
		if(data["status"]){//删除成功
			$(".black_feds").text("删除成功").show();
			setTimeout("prompt();", 2000);
			$("#topic_"+id).remove();
		}else{
			location.reload();
		}

		
	},"json");
}

//图片预览插件
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

//更换背景图
function background_img()
{ 

    
        $.ajax({
            url: '<?php echo site_url('Tribe_social/Upload_Avatar');?>',
            type: 'POST',
            cache: false,
            dataType:'json',
            data: new FormData( $('#form1')[0] ),
            processData: false,
            contentType: false,
            
        }).done(function(data) 
        {
        	if( data.status )
        	{
            	$('#bg_img').attr('src',data.data);
        		$(".black_feds").text('更换成功').show();
        		setTimeout("prompt();", 2000); 
        		return;
        	}

        	$(".black_feds").text('更换失败').show();
    		setTimeout("prompt();", 2000); 
           	return false;
           	
        	
        }).fail(function(res) 
        {
        	$(".black_feds").text('网络异常，请稍后再试').show();
    		setTimeout("prompt();", 2000); 
           	return false;
        	
        });
        
}


String.prototype.trim = function (char, type) {
	  if (char) {
	    if (type == 'left') {
	      return this.replace(new RegExp('^\\'+char+'+', 'g'), '');
	    } else if (type == 'right') {
	      return this.replace(new RegExp('\\'+char+'+$', 'g'), '');
	    }
	    return this.replace(new RegExp('^\\'+char+'+|\\'+char+'+$', 'g'), '');
	  }
	  return this.replace(/^\s+|\s+$/g, '');
	};
</script>
