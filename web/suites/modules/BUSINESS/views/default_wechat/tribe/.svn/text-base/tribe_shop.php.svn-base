<?php $_GET['type'] = !empty($_GET['type']) ? $_GET['type'] : 1?>
<style type="text/css">
  .nav_search a {color: #fff;font-size: 19px;}
  .essay_classify_fuwu {margin-top: -30px;margin-bottom: 15px;}
  .essay_classify_fuwu_list {border-bottom: 0px solid #ddd;padding: 5px;}
  .essay_classify_fuwu_list a {overflow: hidden;display: block;width: 100%;}
  .essay_classify_fuwu_list_text {float: left;width: 75%;padding-left: 5px;}
  .essay_classify_fuwu_list_img {width: 25%;float: left;overflow: hidden;}
  .essay_classify_fuwu_list_img img {display: block;height: 100%;width:100%;}
  .essay_classify_fuwu_list_text .essay-goods-monery {margin: 10px 5px 0px 5px;}
  .essay_classify_fuwu_list_text .essay-goods-title {margin: 10px 0px 10px 0px;}
  #corporationstyle li {list-style: none;}
  .circle_zhong_ul_xia h2 {width: auto;height: auto;line-height: 1;-webkit-line-clamp: inherit;}
  .post_name {font-size: 12px!important}
  .new_img_list {overflow: hidden;}
  .new_img_list li {float: left;width: 3rem;height: 3rem;border-bottom: none;margin-bottom: 5px;margin-left: 0.13rem;}
  .new_img_list_box {margin: 0 0.3rem 0 0.2rem;}
  .circle_zhong_ul_xia h2 samp {vertical-align: inherit;}
  .circle_zhong {border-top: 5px solid #eee;}
  .detailed_comments {padding-bottom: 0;}
  .circle_zhong_ul li {border-bottom: none;}
  .tribe_shop_footer ul li {width: 20%;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<script src="js/amazeui.js"></script><!-- 图片预览插件 -->
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<style type="text/css">
  body {font-family:.PingFang-SC-Light;}
	.recommend {margin-bottom: 0;padding-bottom: 0;}
	.page {padding-bottom: 0;}
  .search-header {background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;z-index: 999;}
  .essay_classify_main {margin: 0px;margin-top: 50px;}
  .tribe_shop_footer {width: 100%;height: 50px;position: fixed;bottom: 0;background-color: #FEFEFE;border-top: 1px solid #ddd;}
  /*.essay_preview_nav ul li {width: 50%;}*/
  .cart_num1 {position: absolute;right: 20%;top: 5px;width: auto;min-width: 14px;}
  .tribe_goods_box {float: left;width: 49%;border: 1px solid #eee;box-sizing: border-box;margin-left: 1%;margin-top: 1px;background: #fff;margin-bottom: 1%;}
  .tribe_goods_box a {width: 100%;margin-left: 0;margin-bottom: 0;border: none;margin-top: 0;}
  .tribe_goods_box .good-text-bg {overflow: hidden;width: 100%;}
  .nav_search {position: relative;padding-top: 10px;margin-left:0px;}
  .tribe_sousuo {width: auto!important;color: #fff;position: absolute;right: 10%;top: 12px;font-size: 15px!important;padding-left: 0!important;}
  .essay_preview_nav {position: fixed;top: 50px;width: 100%;bottom: auto;border-top: 0;z-index: 9;}
  .head_top .icon-release {position: fixed;bottom: 35px;right: 15px;}
  .dropload-down {height: 48px;}
</style>

<!-- 部落搜索 -->
<div class="search-header">
    <a href="javascript:Goback()" target="_self"  class="icon-right" style="-webkit-transform: rotate(180deg);color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="<?php echo site_url('easyshop/product/tribe_search_goods') ?>" method="get" id="form_search" >
       <div class="nav_search">
          <p style="background-color: #fff;width:65%;margin-left: 10%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;margin-left: 12%;">
          <a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;">
          <input type="text" class="search_input" name="keyword" id="keyword" value="" placeholder="搜索您想找的商品" required="" style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;padding-left:0;">
          </a>
          </p>
          <input type="button" class="tribe_sousuo" value="搜索" onclick="search();">
          <?php
            $mac_type = $this->session->userdata("mac_type");
            if(isset($mac_type) && $mac_type =='APP' ){ ?>
          <a href="<#returnHomeController#>" target="_self" class="icon-icon_hone_off tribe-icon-hone"></a>
          <?php }else{?>
            <a href="<?php echo !$label_id ? site_url('home') : site_url('Commerce/index/'.$label_id);?>" target="_self" class="icon-icon_hone_off tribe-icon-hone"></a>
          <?php }?>
          <input type="hidden" value="<?php echo $tribe_id;?>" name="tribe_id">
          <input type="hidden" value="" name="navigate" id="navigate">
       </div>
   </form>
</div>
<div style="height:50px;"></div>

  <!-- 头部导航 -->
  <div class="essay_preview_nav tribe_shop_nav">
    <ul>
        <li class="essay_classify"><input type="button" onclick="navigation(this,1);" id="essay_active_d" class="essay_active_a" value="商城" >
        <li class="essay_sales"><input type="button" onclick="navigation(this,2);" id="essay_active_e" class="essay_active_a" value="部落" >
        <li class="essay_sales"><input type="button" onclick="navigation(this,3);" id="essay_active_f" class="essay_active_a" value="企业展示" >
    </ul>
  </div>




<div class="essay_preview" id="ceshi">
  <!-- 导航 -->
  <div class="tribal_new_nav" hidden><!-- onclick="barnavigation(this,2);" -->
    <a href="<?php echo $type == 2?"javascript:history.back(-1);":site_url('Tribe/shop/'.$tribe_id.'/'.$label_id);?>" id="tribal_new_nav_active1" class="<?php echo  $_GET['type'] == 1  ? 'tribal_new_nav_active' : '' ?>" >部落商城</a>
    <a href="<?php echo site_url('Tribe/shop/'.$tribe_id.'/'.$label_id.'?type=2');?>" id="tribal_new_nav_active2"  class="<?php echo  $_GET['type'] == 2  ? 'tribal_new_nav_active' : '' ?>">企业展示</a>
  </div>
  <span id="Mall" >
  <!-- 头部 -->
  <div class="tribe_shop_head" hidden>
        <img src="<?php echo IMAGE_URL.$tribe["shop_img"]?>" alt="" onerror="this.src='images/tribe_shop_default.png'">
  </div>
  <div class="tribe_shop_person" hidden>
     <!-- 头像 -->
     <img src="<?php echo IMAGE_URL.$tribe["logo"]?>" alt="" onerror="this.src='images/default_img_s.jpg'">
     <span><?php echo $tribe["name"]?></span>
     <a href="<?php echo site_url("tribe/home/$tribe_id/$label_id");?>" class="tribe_shop_a"><span class="icon-tribal_profile"></span></a>
  </div>

    <!-- 推荐商品内容 -->
    <div class="essay_classify_main" id="recommend" hidden>
        <div class="product-recommend">
          <div class="essay">
            <?php foreach($goods as $v){; ?>
              <a href="<?php echo site_url("Goods/detail/".$v["id"]);?>">
                <div class="good-img"><img src="<?php echo IMAGE_URL.$v["goods_thumb"];?>" onerror="this.src='images/default_img_s.jpg'"></div>
                <div class="good-text-bg">
                   <span class="essay-goods-title"><?php echo $v['name'];?></span>
                   <span class="essay-goods-monery"><?php echo $v["tribe_price"];?></span>
                </div>
            </a>
            <?php }; ?>
        </div>
      </div>
    </div>

    <!-- 排序商品内容 -->
    <div class="essay_classify_main essay_classify_fuwu" id="sort" >
        <div class="product-recommend">
            <div class="essay essay_classify_fuwu_main" id="style"></div>
        </div>
    </div>

    <!-- 服务 -->
    <div class="essay_classify_main essay_classify_fuwu" id="service" hidden>
      <div class="product-recommend">
          <div class="essay_classify_fuwu_main">
            <?php foreach($goods as $v){; ?>
            <div class="essay_classify_fuwu_list">
              <a href="<?php echo site_url("Goods/detail/".$v["id"]);?>">
                <div class="essay_classify_fuwu_list_img"><img src="<?php echo IMAGE_URL.$v["goods_thumb"];?>" onerror="this.src='images/default_img_s.jpg'"></div>
                <div class="essay_classify_fuwu_list_text">
                   <span class="essay-goods-title"><?php echo $v['name'];?></span>
                   <span class="essay-goods-monery">部落价：<?php echo $v["vip_price"];?></span>
                </div>
              </a>
            </div>
            <?php }; ?>
        </div>
      </div>
    </div>
    <div style="height:50px;opacity: 0;"></div>
    <!-- 底部导航 -->
    <div class="container-center tribe_shop_footer">
         <ul>
            <li class="footer-icon01"><a href="<?php echo site_url('Tribe/home/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-shouye_"></span>首页</a></li>
            <li class="footer-icon02"><a href="<?php echo site_url('Tribe/shop/'.$tribe_id.'/'.$label_id)?>" class="cf tribe_shop_footer_active"><span class="icon-shangcheng_ cf tribe_shop_footer_active"></span>商城</a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Circles/index/'.$label_id.'?tribe_id='.$tribe_id)?>" class=""><span class="icon-quanzi_"></span>圈子</a></li>
            <li class="footer-icon03" style="position: relative;"><a href="<?php echo site_url('Webim/Control/chatList/'.$tribe_id);?>" class=""><span class="icon-xiaoxi2"></span>消息<em class="cart_num1" id ='huanxin_chatNum' hidden>0</em></a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Tribe/Members_List/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-zuyuan_"></span>族员</a></li>
        </ul>
    </div>
</span>
<div class="head_top" style="top:80px;display:none;">
        <a href="<?php echo site_url("Corporation_style/Add_Topic");?>" class="icon-release" id="suos3"></a>
</div>
<!-- 企业形象 -->
<span id="corporationstyle">
<span id="topic_list"><!-- 企业形象内容 --></span></span>
</div>

<!-- 弹窗 -->
 <div class="tuichu_ball" hidden>
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text" id="tuichu_ball_text"><span>确定要置顶该商品吗？</span></div>
         <div class="tuichu_ball_button">
           <a href="javascript:cane(0);">取消</a>
           <a id = 'tuichu_sub' href="javascript:void();" >确定</a>
         </div>      
      </div>
   </div>
 </div> 

</body>
</html>
<?php 
$user_id = $this->session->userdata("user_id");
if($user_id){?>
<script>
$.ajax({
    url:'<?php echo site_url("Webim/Control/getNotReadCount/{$tribe_id}")?>',
    type:'post',
    dataType:'json',
    data:{},
    success:function(data)
    {
   	  var MsgCount = data.MsgCount;
      if(MsgCount > 0){
        if(MsgCount >= 99){
          MsgCount = '99+'; 
        }
        $("#huanxin_chatNum").html(MsgCount);
        $("#huanxin_chatNum").show();
      }
     	
    },
    error:function()
    {
        console.log("获取未读消息失败");
    }
})
</script>
<?php }?>

<script type="text/javascript">
//navigation方法中的type参数
navigate = 1;
$(function () { 
	  //IOS返回不刷新问题
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
  var width = $(".good-img").width();
  var width_window = $(window).width();
  $(".good-img").height(width);
  $(".essay_classify_fuwu_list_img").height(width_window * 0.24);
	var customer_id = "<?php echo $customer_id;?>";
	var tribe_id = "<?php echo $tribe_id;?>";
	//下拉加载数据
	var types = 1;//排序类型
	var page = 1;//默认加载页数
	var class_sort = '#sort';//排序
	var url = "<?php echo site_url("tribe/loading_goods_mall");?>";

	dropload = $(class_sort).dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
			if (types == 3) {
				url = "<?php echo site_url("corporation_style/Topic_List");?>";
				}else if(types == 2) {
					url = "<?php echo site_url("tribe/loading_goods");?>";
					}else{
						url = "<?php echo site_url("tribe/loading_goods_mall");?>";
						}
// 			console.log('url='+url);
    	    // 加载菜单一的数据
    	        var result = "";
    	        $.post(url,{tribe_id:tribe_id,type:types,page:page},function(data){
    	        	console.log(555);
    	        	switch(types)
    	        	{
    	        	    case 3:
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
			            			result += '<a href="<?php echo site_url("Corporation_style/User_Topic"); ?>/'+(data["topic_list"][i]["customer_id"])+'"><i><img src="'+avatar+'" onerror="this.src=\'images/member_defult.png\'"></i></a>';
			            			result += '<div class="circle_zhong_ul_xia">';
			            			result += '<a href="<?php echo site_url("Corporation_style/User_Topic"); ?>/'+(data["topic_list"][i]["customer_id"])+'">';
			            			result += '<div class="circle_zhong_dd">';
			            			result += '<h2><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+name+'</font></font></span><samp><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data['topic_list'][i]["organization_name"]?data['topic_list'][i]["organization_name"]:"")+(data['topic_list'][i]["organizationl_duties"]?','+data['topic_list'][i]["organizationl_duties"]:"")+'</font></font></samp></h2>';
			            			result += '<!--<span class="zhidingd">已顶置</span>-->';
			            			result += '</div>';
			            			result += '<p>';
			            			result += '<span id="create_time"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["created_at"])+'</font></font></span>';
			            			result += '</p>';
			            			result += '</a>';
			            			result += '</div>';
			            			result += '</div>';
			            			result += '<div class="circle_zhong_ul_neirong" id="box">';
			            			result += '<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+content+'</font></font></p>';
			            			result += '</div>';
			            			result += '</div>';  
			            			//图片
			            			if(data["topic_list"][i]["images"]){
			                			var image_url = "<?php echo IMAGE_URL; ?>";
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
			    	        			for(var n=0; n< upvote_num; n++){
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
			    	        			for(var n=0; n< upvote_num; n++){
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
			            		$("#topic_list").append(result);
			            		$.getScript("js/amazeui.js");
			            		page++;
		    	                me.resetload();
		    	                me.unlock();// 解锁
			            	}else{
		    	                // 无数据
		    	                me.noData();
		                        me.resetload();
		                        $('.dropload-noData').hide();
			            	}
    	        	        break;
    	        	    case 2:
    	        	    	if(data["list"].length>0){
            	            	image_url = "<?php echo IMAGE_URL;?>";
            	                for(var i=0;i<data["list"].length;i++){
                	                if(types == 2){
                	                	switch(data['limit'])
                	                	{
                	                	    case 1:
                	                	    	result += '<div class="tribe_goods_box" id="'+data["list"][i]["id"]+'">';
                        	                  	result += '<a href="<?php echo site_url('easyshop/product/good_detail');?>/'+data["list"][i]["id"]+'?tribe_id='+tribe_id+'">';
                        	                    result += '<div class="good-img"><img src="'+(data["list"][i]["img_path"]?image_url+data["list"][i]["img_path"]:"images/default_img_s.jpg")+'"></div></a>';
                        	                    result += '<div class="good-text-bg">';
                        	                    result += '<span class="essay-goods-title">'+data["list"][i]["product_name"]+'</span>';
                        	                    result += '<span class="essay-goods-monery">'+data["list"][i]["price"]+'</span>';
                        	                    result += '<input type="button" value="'+data["list"][i]['stick']+'" onclick="stick('+data["list"][i]["id"]+')" id="'+'id'+data["list"][i]["id"]+'" class="tribe_goods_top"></div>';
                        	                    result += '</div>';
                	                	        break;
                	                	    case 0:
                	                	    	result += '<a href="<?php echo site_url('easyshop/product/good_detail');?>/'+data["list"][i]["id"]+'?tribe_id='+tribe_id+'">';
                        	                    result += '<div class="good-img"><img src="'+(data["list"][i]["img_path"]?image_url+data["list"][i]["img_path"]:"images/default_img_s.jpg")+'"></div>';
                        	                    result += '<div class="good-text-bg">';
                        	                    result += '<span class="essay-goods-title">'+data["list"][i]["product_name"]+'</span>';
                        	                    result += '<span class="essay-goods-monery">'+data["list"][i]["price"]+'</span></div></a>';  
                	                	        break;
                	                	}
                	               }
            	                }
            	                $('#style').attr("class","essay").append(result);
            	                var width = $("#style .good-img").width();
                                $("#style .good-img").height(width);
            	                page++;
            	                me.resetload();
            	            }else{
            	            	// 锁定
            	                me.lock();
            	                // 无数据
            	                me.noData();
                                me.resetload();
                                $(".dropload-noData").html("没有更多的数据了");
            	            }
    	        	        break;
    	        	    default:
    	        	    	if(data["list"].length>0){
        	        	    	console.log(111);
            	            	image_url = "<?php echo IMAGE_URL;?>";
            	                for(var i=0;i<data["list"].length;i++){
            	                	result += '<div class="essay_classify_fuwu_list">';
            	                    result += '<a href="<?php echo site_url("Goods/detail");?>/'+data["list"][i]["id"]+'">';
            	                    result += '<div class="essay_classify_fuwu_list_img"><img src="'+(data["list"][i]["goods_thumb"]?image_url+data["list"][i]["goods_thumb"]:"images/default_img_s.jpg")+'" ></div>';
            	                    result += '<div class="essay_classify_fuwu_list_text">';
            	                    result += '<span class="essay-goods-title">'+data["list"][i]["name"]+'</span>';
            	                    result += '<span class="essay-goods-monery">'+data["list"][i]["tribe_price"]+'</span>';
            	                    result += '</div>';
            	                    result += '</a>';
            	                    result += '</div>';
                	                }
            	                $('#style').attr("class","essay").append(result);
            	                var width = $("#style .good-img").width();
                                $("#style .good-img").height(width);
                                console.log(222);
            	                page++;
            	                me.resetload();
            	            }else{
            	            	// 锁定
            	                me.lock();
            	                // 无数据
            	                me.noData();
                                me.resetload();
                                $(".dropload-noData").html("没有更多的数据了");
            	            }
    	        	}
    	        },"json");
    	}

	});

	//商品导航切换
	function navigation(obj,type){
		$('#essay_active_d').attr("disabled",true); 
		$('#essay_active_e').attr("disabled",true); 
		$('#essay_active_f').attr("disabled",true); 
		$("#style").empty();
		navigate = type;
		//特效
		$(".essay_preview_nav ul li").siblings().children('a').removeClass('essay_active_a');
		$(obj).parent().children('a').addClass('essay_active_a');
	    types = type;
	    if(type == "3"){
	        url = "<?php echo site_url("corporation_style/Topic_List");?>";
	        class_sort = '#topic_list';
	        $(".head_top").show();
			$("#tribal_new_nav_active1").removeClass('tribal_new_nav_active');
	    	$(".essay_preview_nav ul li").siblings().children('a').removeClass('essay_active_a');
	    	$(".essay_preview_nav ul li").eq(2).children('a').addClass('essay_active_a');
	        $("#corporationstyle").show();
			$("#Mall").hide();
	    }else if(type == '2') {
	    	url = "<?php echo site_url("tribe/loading_goods");?>";
	    	$(".head_top").hide();
	    	$("#tribal_new_nav_active2").removeClass('tribal_new_nav_active');
	    	$("#corporationstyle").hide();
			$("#Mall").show();
	    }else {
	    	url = "<?php echo site_url("tribe/loading_goods_mall");?>";
	    	$(".head_top").hide();
	    	$("#tribal_new_nav_active2").removeClass('tribal_new_nav_active');
	    	$("#corporationstyle").hide();
			$("#Mall").show();
		}
// 		alert(111);
		page = 1;//默认第一页
	    // 解锁
	    dropload.unlock();
	    dropload.noData(false);
	    // 重置
	    dropload.resetload();
	    setTimeout(function(){
	 	    $('#essay_active_d').attr("disabled",false); 
	 		$('#essay_active_e').attr("disabled",false); 
	 		$('#essay_active_f').attr("disabled",false); 
	    },300);
	    
	}	

//置顶部落商品
function stick (id) {
	var obj_stick = 'id'+id;
	var obj_value = document.getElementById(obj_stick).value;
	if (obj_value == '置顶') {
		document.getElementById("tuichu_ball_text").innerHTML = '确定置顶该商品？';
	} else {
		document.getElementById("tuichu_ball_text").innerHTML = '确定取消置顶该商品？';
	}
	$("#tuichu_sub").attr('onclick','quit_sub('+id+')');
	$(".tuichu_ball").show();
}

function cane(){
	$('.tuichu_ball').hide();
}

//提交置顶数据
function quit_sub(id) {
	var ee = 'id'+id;
	var div_data = document.getElementById(id);
	var  label_data = document.getElementById(ee).value;
	$.ajax({
		url: '<?php echo site_url('tribe/up_product')?>',
        type: 'post',
        dataType: 'json',
        data: {'id': id,'label_data': label_data,'tribe_id':tribe_id},
        success: function (data) {
            switch(data.Type)
            {
                case 0:
                	$('.tuichu_ball').hide();
                    $(".black_feds").text("商品信息错误").show();
                    setTimeout("prompt();", 2000);
                    break;
                case 1:
                	$("#style").prepend(div_data);
                	$('.tuichu_ball').hide();
                	document.getElementById(ee).value = '已置顶';
                    break;
                case 2:
                    if (data.last_up_id == '0') {
                    	$("#style").prepend(div_data);
                    }else {
                    	var last_up_data = document.getElementById(data.last_up_id);
                        $(div_data).insertAfter(last_up_data);
                    }
                	$('.tuichu_ball').hide();
                	document.getElementById(ee).value = '置顶';
                    break;
                default:
                	$('.tuichu_ball').hide();
                    $(".black_feds").text("操作失败").show();
                    setTimeout("prompt();", 2000);
                    return false;
             }
           },
        error:function (data) {
          $('.tuichu_ball').hide();
          $(".black_feds").text("网络错误，请重试").show();
          setTimeout("prompt();", 2000);
          return false;
            }
		});
}

//头部导航切换
function barnavigation(obj,type){
	//特效
	if(type ==1 ){
		$(".head_top").hide();
		$("#tribal_new_nav_active2").removeClass('tribal_new_nav_active');
	}else{
		$(".head_top").show();
		$("#tribal_new_nav_active1").removeClass('tribal_new_nav_active');
    	$(".essay_preview_nav ul li").siblings().children('a').removeClass('essay_active_a');
    	$(".essay_preview_nav ul li").eq(2).children('a').addClass('essay_active_a');
	}
	$(obj).addClass('tribal_new_nav_active');
	if(type == 1){
		$("#corporationstyle").hide();
		$("#Mall").show();
	}else{
		$("#corporationstyle").show();
		$("#Mall").hide();
		var page = 1;//默认加载页数
		dropload = $('#topic_list').dropload({
		    scrollArea : window,
	    	loadDownFn : function(me){
                me.lock();// 锁定
	    		var result = "";
	            $.post("<?php echo site_url("corporation_style/Topic_List");?>",{tribe_id:tribe_id,page:page},function(data){
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
	            			result += '<a href="<?php echo site_url("Corporation_style/User_Topic"); ?>/'+(data["topic_list"][i]["customer_id"])+'"><i><img src="'+avatar+'" onerror="this.src=\'images/member_defult.png\'"></i></a>';
	            			result += '<div class="circle_zhong_ul_xia">';
	            			result += '<a href="<?php echo site_url("Corporation_style/User_Topic"); ?>/'+(data["topic_list"][i]["customer_id"])+'">';
	            			result += '<div class="circle_zhong_dd">';
	            			result += '<h2><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+name+'</font></font></span><samp><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data['topic_list'][i]["organization_name"]?data['topic_list'][i]["organization_name"]:"")+(data['topic_list'][i]["organizationl_duties"]?','+data['topic_list'][i]["organizationl_duties"]:"")+'</font></font></samp></h2>';
	            			result += '<!--<span class="zhidingd">已顶置</span>-->';
	            			result += '</div>';
	            			result += '<p>';
	            			result += '<span id="create_time"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+(data["topic_list"][i]["created_at"])+'</font></font></span>';
//	    	        			result += '<span class="quanzi_shop"><em class="icon-shop2"></em><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">店铺</font></font></span>';
	            			result += '</p>';
	            			result += '</a>';
	            			result += '</div>';
	            			result += '</div>';
	            			result += '<div class="circle_zhong_ul_neirong" id="box">';
	            			result += '<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">'+content+'</font></font></p>';
	            			result += '</div>';
	            			result += '</div>';  

	            			//图片
	            			if(data["topic_list"][i]["images"]){
	                			var image_url = "<?php echo IMAGE_URL; ?>";
//	             				var image = data["topic_list"][i]["images"].split(";");
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
	    	        			for(var n=0; n< upvote_num; n++){
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
	    	        			for(var n=0; n< upvote_num; n++){
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

	            		
	            		$("#topic_list").append(result);
	            		$.getScript("js/amazeui.js");

	            		page++;
    	                me.resetload();
    	                me.unlock();// 解锁
	            	}else{
    	                // 无数据
    	                me.noData();
                        me.resetload();
                        
                        $('.dropload-noData').hide();
	            	}
	            },"json"); 
	    	    
	    	}
		});

		 
	}
}

//ajax 点赞 or 取消
function upvote(id){
	var real_name = "<?php echo $real_name;?>";
	var upvote_num = $("#upvote_num_"+id).text();//点赞人数
	$("#upvote_"+id).removeAttr("onclick");
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
			$("#upvote_"+id).attr("onclick",'upvote('+id+')');
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
barnavigation($('#navigation'+'<?php echo $_GET['type']?>'),<?php echo $_GET['type'] ?>);

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

function search(){
	var action_data =  document.getElementById("form_search").action;
	document.getElementById("navigate").value = navigate;
	if (navigate == '3') {
		return false;
	}else if(navigate == '1') {
		document.getElementById("form_search").action = "<?php echo site_url('Search/wechat_search_goods') ?>";
		$('#form_search').submit();
		var tribe_id = "<?php echo $tribe_id;?>";
	} else {
		action_data = "<?php echo site_url('easyshop/product/tribe_search_goods') ?>";
		$('#form_search').submit();
		var tribe_id = "<?php echo $tribe_id;?>";
	}
	
}

function Goback(){
	if(window.history.length >1){
			window.history.back();
		}else{
			window.location.href = '<?php echo site_url("Home")?>';
		}
}

</script>



