<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AMAF32XHYjAc06pnSuyAyZU8Yatl1lj2"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script> 
<script type="text/javascript" src="js/Public.js"></script> 
<script type="text/javascript">

//H5持续获取地理位置
Latitude = "";
Longitude = "";

function get_location(){
	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
	    if(this.getStatus() == BMAP_STATUS_SUCCESS){
	        var mk = new BMap.Marker(r.point);
	        Latitude = r.point.lat;
	        Longitude = r.point.lng;
	    }else {
	    	    alert("无法获取当前位置");
	            // 锁定
	            dropload.lock();
	            // 无数据
	            dropload.noData();
	            dropload.resetload();
	       //无法获取地理位置信息
	    }
	},{enableHighAccuracy: true});
	var str = '<div class="dropload-load"><span class="loading"></span>加载中...</div>';
	$(".dropload-down").html(str);
	setTimeout(function(){
		 // 解锁
	    dropload.unlock();
	    dropload.noData(false);
	    // 重置
	    dropload.resetload();
		},3000);
	
}

</script>
<style type="text/css">
      .sousuo_text {position: absolute;right: 2%;color: #fff;font-size: 15px;top: 18px;}
      .recommend ul li {height: 35px!important;background: #eee!important;border-radius: 20px;}
      .result_em {float: none;}
      footer .footer-icon03 a { background-position: -190px -63px;}
      .result_title {height: 37px;margin-top: 5px;}
      .tribe_money {margin-top: 20px;}
</style>

<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
    <a href="javascript:history.back();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="<?php echo site_url('easyshop/product/tribe_search_goods') ?>" method="get" id="form_search" >
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:75%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;"><a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
          <input type="text" class="search_input" name="keyword" value="<?php echo isset($keyword)?$keyword:"" ?>" placeholder="请输入关键词"  style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;">
          </p>
          <span class="sousuo_text" onclick="$('#form_search').submit();">搜索</span> 
          <input type="hidden" value="<?php echo !empty($tribe_id)?$tribe_id:"";?>" name="tribe_id"> 
          <input type="hidden" value="<?php echo !empty($navigate)?$navigate:"1";?>" name="navigate" id="navigate"> 
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
                <li><a href="<?php echo site_url("search/wechat_search_goods?keyword=".$v['keyword']."&cate_id=0&tribe_id=$tribe_id");?>"><?php echo $v['keyword'];?></a></li>
                <?php };?>
                </ul>
            </div> 
            <?php  if(!empty($history)){?>
            <div class="history">
             <h5 style="font-size:15px;color:#585858;border-bottom:1px solid #e0e0e0;">搜索历史 <span><?php  if(!empty($history)){?><a href="<?php echo site_url("search/delete_cookie");?>" target="_self" class="icon-shanchu" style="color:#CDCDCD"><?php }?></a></span></h5> 
                <ul style="">
                <?php foreach ($history as $v){;?>
                    <li style="border-bottom:1px solid #EAEAEA;margin-bottom: 10px;"><a href="<?php echo site_url("search/wechat_search_goods?keyword=$v&tribe_id=$tribe_id");?>"style="margin-bottom:10px;display:inherit;color:#888888;padding-left: 10px;font-size: 13px;"><?php echo $v?></a></li>
                <?php };?>
                </ul>
            </div>
            <?php };?> 
          </span>
      <?php };?>
    <!--搜索 end-->  
    <!--分类搜索 end-->
    <?php if(isset($null)){?>
     <?php }else{?>
      <!--分类搜索 begin-->
    <div class="classify_box hide_classifyBox">
    	<ul style="padding-top: 5px;">
            <li style="width: 50%;font-size: 14px;">
            	<a onclick="sort(this,2)" >
                	<span>销量</span>  
                	<i  style="font-size: 12px;margin-left: 0px;"></i>             
                    <input type="hidden" name="sale" value="1">
                </a>
            </li>
            <li style="width: 50%;font-size: 14px;">
                <a onclick="sort(this,4)" >
                    <span>价格</span>
                    <i  style="font-size: 12px;margin-left: 0px;"></i>     
                    <input type="hidden" name="price" value="2">
                </a>
            </li>
        </ul>
    </div>
    <!--搜索结果（有数据显示） begin-->
    <div class="search_res" id="sort">
        <ul></ul>
    </div>
     <?php }?>
</div>





<script>
//下拉加载数据
var keyword = "<?php echo empty($keyword)? '':$keyword;?>";//关键词
var navigate = "<?php echo empty($navigate)? '':$navigate;?>";//1为商城2为部落
var tribe_id = "<?php echo empty($tribe_id)? '':$tribe_id;?>";//部落ID
var types = 5;//排序类型
var page = 1;//默认加载页数
dropload = $('#sort').dropload({
    scrollArea : window,
	loadDownFn : function(me){
	    // 加载数据
        var result = "";
        $.post("<?php echo site_url("easyshop/product/ajax_search_goods");?>",{keyword:keyword,type:types,page:page,navigate:navigate,tribe_id:tribe_id},function(data){
            if(data["status"]==1){//部落搜索商品需要登录
                window.location.href="<?php echo site_url("customer/login");?>";
                return;
            }
            if(data["productList"].length>0){
                var user_in_tribe = data['tribeids'];//用户所在的部落
                for(var i=0;i<data["productList"].length;i++){
                	
                	
                	result += '<a href="<?php echo site_url('easyshop/product/good_detail/}');?>/'+data["productList"][i]['id']+'?tribe_id='+tribe_id+'"><li class=" clearfix" style="">';
                	result += '<i class="result_img" style="width:100px;height: 100px;float: left;margin-right: 15px;"><img src="<?php echo IMAGE_URL;?>'+data["productList"][i]['img_path']+'" onerror="this.src=\'images/default_img_s.jpg\'"></i>';
                	result += '<em class="result_em"><p class="result_title">'+data["productList"][i]['product_name']+' '+data["productList"][i]['desc']+'</p>';
                	result += '<p class="tribe_money">价格: '+formatCurrency(data["productList"][i]['price'])+'</p></em></li></a>';

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
		   types=1;//销量
		   $(obj).attr("onclick","sort(this,2)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou2");
		   break;
	   case 2:
		   types=2;//销量
		   $(obj).attr("onclick","sort(this,1)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou-copy");
		   break;
	   case 3:
		   types=3;//价格
		   $(obj).attr("onclick","sort(this,4)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou2");
		   break;
	   case 4:
		   types=4;//价格
		   $(obj).attr("onclick","sort(this,3)").attr("class","classifyBox_current").find("i").attr("class","icon-jiantou-copy");
		   break;
	   default:
		   window.location.reload();return;
		   break;
	}
	if(type == 5 || type==6){
		if(!Latitude || !Longitude){
			get_location();
			}else{
				  // 解锁
			    dropload.unlock();
			    dropload.noData(false);
			    // 重置
			    dropload.resetload();
				}
		}else{
		  // 解锁
	    dropload.unlock();
	    dropload.noData(false);
	    // 重置
	    dropload.resetload();
	}
}


</script>