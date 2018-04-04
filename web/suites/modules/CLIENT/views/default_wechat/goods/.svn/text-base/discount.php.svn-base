<div class="" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
    <a href="javascript:history.back()" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="" method="get" id="form_search" onsubmit="check_form();">
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:85%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;margin-right:15px;"><a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
          <input type="text" class="search_input" value="" onkeyup="search();" id="sou" placeholder="请输入关键词" required style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;"><a href="javascript:close();"  style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a></p>
       </div>
   </form>
</div>
<!--头部 end-->   
<div class="page clearfix">
<!--分类搜索 begin-->
<div class="classify_box hide_classifyBox">
	<ul style="margin-left: 15px;padding-top: 5px;">
      
        <li style="width: 35%;font-size: 14px;">
        	<a href="javascript:void(0);" onclick="sale(this);" class="classifyBox_current">
            	<span>销量</span>
                <i class="icon-jiantou-copy" style="font-size: 12px;margin-left: -1px;" id="sales"></i>
            </a>
        </li>
        <li style="width: 32%;font-size: 14px;">
            <a href="javascript:void(0);" onclick="price(this);">
                <span>价格</span>
                <i class="icon-jiantou-copy" style="font-size: 12px;margin-left: 0px;" id="prices"></i>
            </a>
        </li>
         <li style="width: 32%;font-size: 14px;">
        	<a href="javascript:void(0);" onclick="distance(this);" id="range">
            	<span>距离</span>
                <i class="icon-jiantou-copy" style="font-size: 12px;margin-left: 0px;" id="distances"></i>
            </a>
        </li>
    </ul>
</div>
<!--分类搜索 end-->

<div class="search_res">
    <ul id="loadmore">
    <!--搜索结果（有数据显示） begin-->
    <?php if($goods){?>
    <?php foreach ($goods as $v){;?>
    <a href="<?php echo site_url("goods/detail/".$v["id"]);?>">
    	<li class="clearfix" style="">
        	<i class="result_img" style="width:100px;height: 100px;float: left;margin-right: 15px;"><img src="<?php echo !empty($v['goods_thumb'])?(IMAGE_URL.$v['goods_thumb']):'images/default_img_s.jpg' ?>" ></i>
            <em class="result_em">
                <p class="result_title"><?php echo $v["name"];?></p>
                <p  style="padding-top: 20px" class=vip_price><?php echo $v["vip_price"].'劵'?></p>
                <p class="min"></p>
                <p class="sales" ><?php //echo $v["sales_count"];?></p>
                <p class="longitude" hidden><?php echo $v["longitude"];?></p>
                <p class="latitude" hidden><?php echo $v["latitude"];?></p>
            </em>
        </li>
     </a>
     <?php };?>
     <?php };?>
    <!--搜索结果（有数据显示） end-->
    <!--搜索结果（无数据显示） begin-->
      <li class=" clearfix" style="text-align:center;padding-top: 60px;color:#999;border:none; <?php echo $goods?'display:none':'display:black';?>" id="not_goods">
        <span class="icon-chakandingdan" style="font-size: 100px;"></span><br>
        <span style="display: inline-block;padding-top: 20px;font-size: 15px;">抱歉，没有找到商品</span>
      </li>
    <!--搜索结果（无数据显示） end-->
    </ul>
</div>

</div>

<script>
//搜索
function search(){
	var search_val = $("#sou").val();
	$("#loadmore a").hide();
	var result = $(".result_title:contains('"+search_val+"')").parents("a").show();
    number = result.length;//搜索结果条数


	//距离搜索判断商品是否有设置地址。没有就隐藏
	if($("#range").hasClass("classifyBox_current")){
		$(".min").each(function(){
            if(!$(this).text()){
                $(this).parents("a").hide();
            }
		});
	}

	//根据搜索结果显示隐藏样式
	if(number){
		$("#not_goods").hide();
	}else{
		$("#not_goods").show();
	}
}

//清空搜索
function close(){
	$("#sou").val("");
	search();
}

//销量排序
function sale(obj){
	//页面显示处理
	$(".classifyBox_current").removeClass("classifyBox_current");
	$(obj).addClass("classifyBox_current");
	$(".min").text("");
	
	var asc = this.asc = !!this.asc ? -this.asc : -1;//记录当前排序
    if(asc===1){
        $("#sales").attr("class","icon-jiantou-copy");
    }else{
    	$("#sales").attr("class","icon-jiantou1");
        }
	//转成数组排序
    var arr = $.makeArray($("#loadmore a"));
    //条数大于1才排序
    if(arr.length>1){
        arr.sort(function(a,b){             
            var a1 = $(a).show().find("li em .sales").text(),
                b1 = $(b).show().find("li em .sales").text(); 
            if(asc===1){
                return b1-a1;
            }else{
            	return a1-b1;
                }
        });
        //排序完成循环追加html
        $("#loadmore a").each(function(i,n){
        n.outerHTML = arr[i].outerHTML;
        });
    }else{
    	$(arr).show();
        }
    search();//排序完成配合搜索
}


//价格排序
function price(obj){
	//页面显示处理
	$(".classifyBox_current").removeClass("classifyBox_current");
	$(obj).addClass("classifyBox_current");
	$(".min").text("");

	var asc = this.asc = !!this.asc ? -this.asc : -1;//记录当前排序
    if(asc===1){
    	$("#prices").attr("class","icon-jiantou-copy");
    }else{
    	$("#prices").attr("class","icon-jiantou1");
        }
    
	//转成数组排序
    var arr = $.makeArray($("#loadmore a"));
    //条数大于1才排序
    if(arr.length>1){
        arr.sort(function(a,b){             
        var a1 = $(a).show().find("li em .vip_price").text().replace("劵",""),
            b1 = $(b).show().find("li em .vip_price").text().replace("劵",""); 
        if(asc===1){
            return b1-a1;
        }else{
        	return a1-b1;
            }
        });
        //排序完成循环追加html
        $("#loadmore a").each(function(i,n){
        n.outerHTML = arr[i].outerHTML;
        });
    }else{
    	$(arr).show();
        }
    search();//排序完成配合搜索
}


//距离排序
function distance(obj){
	//页面显示处理
	$(".classifyBox_current").removeClass("classifyBox_current");
	$(obj).addClass("classifyBox_current");

	//当前经纬度
	var lng1 = "<?php echo $lng;?>";
	var lat1 = "<?php echo $lat;?>";
	
	var asc = this.asc = !!this.asc ? -this.asc : -1;//记录当前排序
    if(asc===1){
    	$("#distances").attr("class","icon-jiantou-copy");
    }else{
    	$("#distances").attr("class","icon-jiantou1");
        }
    
	//转成数组排序
    var arr = $.makeArray($("#loadmore a"));
    //条数大于1才排序，否则根据此商品有无经纬度进行隐藏显示
    if(arr.length>1){
        arr.sort(function(a,b){    
            var lng2 = $(a).find("li em .longitude").text(),//经度
                lat2 = $(a).find("li em .latitude").text(); //纬度
            var lng3 = $(b).find("li em .longitude").text(),//经度
                lat3 = $(b).find("li em .latitude").text(); //纬度
    
            //如果此商品有经纬度就计算我们之间距离并且排序，没有就隐藏！
            a1 = lng2 && lat2?GetDistance(lat1,lat1,lat2,lng2):-1;
            b1 = lng3 && lat3?GetDistance(lat1,lat1,lat3,lng3):-1;
            if(a1==-1){
            	$(a).hide();
            }else{
            	$(a).find("li em .min").text(parseInt(a1)+" km").show();
            }
            
            if(b1==-1){
            	$(b).hide();
            }else{
            	$(b).find("li em .min").text(parseInt(b1)+" km").show();
                }
    
            if(asc===1){
                return b1-a1;
            }else{
            	return a1-b1;
                }
          });
        //排序完成循环追加html
        $("#loadmore a").each(function(i,n){
            n.outerHTML = arr[i].outerHTML;
        });
    }else{
        lng2 = $(arr).find("li em .longitude").text(),//经度
        lat2 = $(arr).find("li em .latitude").text(); //纬度
        a1 = lng2 && lat2?GetDistance(lat1,lat1,lat2,lng2):-1;
        if(a1==-1){
        	$(arr).hide();
        }else{
        	$(arr).find("li em .min").text(parseInt(a1)+" km").show();
        }
    }
    search();//排序完成配合搜索
}

/**
 * 计算距离
 */
function rad(d)
{
return d * Math.PI / 180.0;
}
function GetDistance( lat1,  lng1,  lat2,  lng2)
{
	var radLat1 = rad(lat1);
	var radLat2 = rad(lat2);
	var a = radLat1 - radLat2;
	var  b = rad(lng1) - rad(lng2);
	var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) +
	Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
	s = s *6378.137 ;// EARTH_RADIUS;
	s = Math.round(s * 10000) / 10000;
	return s;
}

</script>










