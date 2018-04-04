<style type="text/css">
    .result_em {float: none;}
    footer .footer-icon03 a {background-position: -192px -63px;}
</style>


<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
    <a href="<?php echo site_url('home')?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="<?php echo site_url('search/wechat_search_goods') ?>" method="get" id="form_search" >
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:85%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;margin-right:15px;"><a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
          <input type="text" class="search_input" name="keyword" value="<?php echo isset($keyword)?$keyword:"" ?>" placeholder="请输入关键词" required style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;"><a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a></p>
          <input type="hidden" value="<?php echo isset($cateid)?$cateid:"" ?>" name="cate_id">   
       </div>
   </form>
</div>
<!--头部 end-->   
<div class="page clearfix">
      <?php if(!empty($hot_keywords)){;?>
          <span>
            <div class="recommend" style="margin-top: 0px;">
                <h5 style="font-size:15px;color:#585858;">热门推荐</h5>
                <ul>
                <?php foreach ($hot_keywords as $v){;?>
                <li><a href="<?php echo site_url("search/wechat_search_goods?search_index=".$v['keyword']);?>"><?php echo $v['keyword'];?></a></li>
                <?php };?>
                </ul>
            </div> 
            <?php  if(!empty($history)){?>
            <div class="history">
             <h5 style="font-size:15px;color:#585858;border-bottom:1px solid #e0e0e0;">搜索历史 <span><?php  if(!empty($history)){?><a href="<?php echo site_url("search/delete_cookie");?>" target="_self" class="icon-shanchu" style="color:#CDCDCD"><?php }?></a></span></h5> 
                <ul style="">
                <?php foreach ($history as $v){;?>
                    <li style="border-bottom:1px solid #EAEAEA;margin-bottom: 10px;"><a href="<?php echo site_url("search/wechat_search_goods?search_index=$v");?>"style="margin-bottom:10px;display:inherit;color:#888888;padding-left: 10px;font-size: 13px;"><?php echo $v?></a></li>
                <?php };?>
                </ul>
            </div>
            <?php };?> 
          </span>
      <?php };?>
    <!--搜索 end-->
    
    <!--分类搜索 begin-->
    <?php if(isset($keyword)){?>
    <div class="classify_box hide_classifyBox">
    	<ul style="padding-top: 5px;">
            <li style="width: 33.3%;font-size: 14px;">
            	<a onclick="sort(this,2)" class="classifyBox_current">
                	<span>销量</span>  
                	<i class="icon-jiantou2" style="font-size: 12px;margin-left: 0px;"></i>             
                    <input type="hidden" name="sale" value="1">
                </a>
            </li>
            <li style="width: 33.3%;font-size: 14px;">
                <a onclick="sort(this,4)" >
                    <span>价格</span>
                    <i  style="font-size: 12px;margin-left: 0px;"></i>     
                    <input type="hidden" name="price" value="2">
                </a>
            </li>
             <li style="width: 33.3%;font-size: 14px;">
            	<a onclick="sort(this,6)">
                	<span>距离</span>
                	<i  style="font-size: 12px;margin-left: 0px;"></i> 
                    <input type="hidden" name="distance" value="">
                </a>
            </li>
        </ul>
    </div>
    <?php };?>
    <!--分类搜索 end-->
    
    <!--搜索结果（有数据显示） begin-->
    <div class="search_res" id="sort">
        <ul></ul>
    </div>

</div>

<script>
//H5持续获取地理位置
Latitude = "";
Longitude = "";

if (navigator.geolocation)
{
    navigator.geolocation.watchPosition(showPosition);
}
function showPosition(position)
{
    Latitude = position.coords.latitude;//纬度
    Longitude = position.coords.longitude;//经度
}
</script>


<script>
//下拉加载数据
var keyword = "<?php echo $keyword;?>";
var cateid = "<?php echo $cateid;?>";
var types = 1;//排序类型
var page = 1;//默认加载页数
dropload = $('#sort').dropload({
    scrollArea : window,
	loadDownFn : function(me){
	    // 加载数据
        var result = "";
        $.post("<?php echo site_url("search/ajax_search_goods");?>",{keyword:keyword,cateid:cateid,type:types,page:page,Latitude:Latitude,Longitude:Longitude},function(data){
            if(data["productList"].length>0){
                for(var i=0;i<data["productList"].length;i++){
                	result += '<a href="<?php echo site_url('goods/detail');?>/'+data["productList"][i]['id']+'"><li class=" clearfix" style="">';
                	result += '<i class="result_img" style="width:100px;height: 100px;float: left;margin-right: 15px;"><img src="<?php echo IMAGE_URL;?>'+data["productList"][i]['goods_thumb']+'" onerror="this.src=\'images/default_img_s.jpg\'"></i>';
                	result += '<em class="result_em"><p class="result_title">'+data["productList"][i]['name']+'</p>';
                	result += '<p style="padding-top: 20px">'+data["productList"][i]['vip_price']+'</p>';
                	if(types==5 || types==6){
             		   result += '<p class="min">'+parseInt(data["productList"][i]['distance']/1000)+'Km</p>';
                	}  
                } 
                $("#sort").find("ul").append(result);    
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

//排序切换
function sort(obj,type){
	page = 1;
	$("#sort").find("ul").empty();
	$(".icon-jiantou2").removeClass("icon-jiantou2");$(".icon-jiantou-copy").removeClass("icon-jiantou-copy");$(".classifyBox_current").removeClass("classifyBox_current");//移除特效
	switch(type){
	   case 1:
		   types=1;
		   $(obj).attr("onclick","sort(this,2)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou2");
		   break;
	   case 2:
		   types=2;
		   $(obj).attr("onclick","sort(this,1)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou-copy");
		   break;
	   case 3:
		   types=3;
		   $(obj).attr("onclick","sort(this,4)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou2");
		   break;
	   case 4:
		   types=4;
		   $(obj).attr("onclick","sort(this,3)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou-copy");
		   break;
	   case 5:
		   types=5;
		   $(obj).attr("onclick","sort(this,6)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou2");
		   break;
	   case 6:
		   types=6;
		   $(obj).attr("onclick","sort(this,5)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou-copy");
		   break;
	   default:
		   window.location.reload();return;
		   break;
	}
	
	//判断是否距离排序，如果是则判断是否能获取到当前经纬度
	if(types==5 || types==6){
		if(!Latitude || !Longitude){
		   alert("无法获取当前位置");
           // 锁定
           dropload.lock();
           // 无数据
           dropload.noData();
           dropload.resetload();
		   return;
		}
	}
	
    // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();
}

</script>