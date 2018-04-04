<style type="text/css">
   .container {background: #f4f4f4;}
   .pl14 {padding-left: 14%;}
   .essay_icon {color: #808180;font-size: 13px;padding-left: 4px;}
   .display-block {display: block;}
   .color-red {color:#ff0000;}
   .font13 {font-size: 13px!important;}
   .essay_preview_head img {width: 20%;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- 店铺预览 -->
<div class="essay_preview">
	<!-- 头部 -->
	<div class="essay_preview_head">
	    <!-- 头像 -->
		<img src="<?php echo IMAGE_URL.$shop['logo']; ?>"  onerror="this.src='images/default_img_s.jpg'" alt="">
        <!-- 店铺名称 -->
		<span><?php echo  $shop['name']?></span>
	</div>

	<!-- 头部导航 -->
	<div class="essay_preview_nav">
		<ul>
		    <li style="width: 40%;" class="essay_active essay_classify"><a href="javascript:void(0);">商品分类<span class="icon-xiala icon-fold essay_icon"></span></a><span class="pl14">|</span></li>
		    <li style="width: 30%;" class="essay_issue"><a href="javascript:void(0);" onclick="navigation('new');">最新发布</a><span class="pl14">|</span></li>
		    <li style="width: 30%;" class="essay_sales"><a href="javascript:void(0);" onclick="navigation('sale');">销量</a></li>
		</ul>
	</div>
	
	<!-- 分类内容 -->
	<div class="essay_classify_list">
		<ul>
		    <li>
		    	<dl>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["9"]["id"]));?>',<?php echo  $classify["9"]["isparent"];?>)" ?>全部商品</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["0"]["id"]));?>',<?php echo  $classify["0"]["isparent"];?>)" >食品酒水</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["1"]["id"]));?>',<?php echo  $classify["1"]["isparent"];?>)" >营养保健</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["2"]["id"]));?>',<?php echo  $classify["2"]["isparent"];?>)">生活服务</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["3"]["id"]));?>',<?php echo  $classify["3"]["isparent"];?>)" >珠宝首饰</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["4"]["id"]));?>',<?php echo  $classify["4"]["isparent"];?>)" >户外活动</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["5"]["id"]));?>',<?php echo  $classify["5"]["isparent"];?>)" >房地产</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["6"]["id"]));?>',<?php echo  $classify["6"]["isparent"];?>)" >书画作品</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["7"]["id"]));?>',<?php echo  $classify["7"]["isparent"];?>)">广告</a></dd>
		    		<dd><a href="javascript:void(0);" onclick="selectnav('<?php echo base64_encode(serialize($classify["8"]["id"]));?>',<?php echo  $classify["8"]["isparent"];?>)" >汽车</a></dd>
		    	</dl>
		    </li>
		</ul>
	</div>

	<!-- 商品内容 -->
	<div class="essay_classify_main">
		<div class="product-recommend" id="product-recommend">
			<div class="essay" id="essay">
		     
    		</div>
    	</div>
    </div>	
 
<div class="essay_botton">
  <a href="javascript:void(0);"><span><?php echo  $shop['name']?>的店铺</span></a>
</div>



<script type="text/javascript">
	function get_product($id){
		 window.location.href="<#product_id#>id="+$id;
		}
	// 点击头部导航
	$(".essay_preview_nav ul li").on("click",function(){
		$(this).addClass('essay_active').siblings().removeClass('essay_active');
	})
	// 点击商品分类
	$(".essay_classify").on("click",function(){
		$(".essay_classify_list").toggleClass('display-block');
		$(".essay_icon").toggleClass('icon-xiala');
	})
	$(".essay_classify_list ul li dl dd").on("click",function(){
		$(this).children().addClass('color-red').parent().siblings().children().removeClass('color-red');
		$(".essay_classify_list").removeClass('display-block');
		$(".essay_icon").addClass('icon-xiala');
	})
	$(".essay_issue").on("click",function(){
		$(".essay_classify_list").removeClass('display-block');
		$(".essay_icon").addClass('icon-xiala');
	})
	$(".essay_sales").on("click",function(){
		$(".essay_classify_list").removeClass('display-block');
		$(".essay_icon").addClass('icon-xiala');
	})
	
	//下拉加载数据
	var page = 1;
	var is_first = true;//识别是否加载数据
	var type = '';
	var cate_id = '';
	var isparent = '';
	dropload = $('#product-recommend').dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
    	    // 加载菜单一的数据
    	    if(is_first){
    	        var result = "";
    	        var errorimg= 'this.src="images/default_img_s.jpg"';
    	        $.post("<?php echo site_url("shop/ajax_shop_pro_list");?>",{page:page,order:type,cate_id:cate_id,isparent:isparent,shopid:<?php echo $shop['id']?>},function(data){
    	            if(data.produtList.length>0){
    	                for(var i=0;i<data.produtList.length;i++){
    	                	var img = "<?php echo IMAGE_URL; ?>"+data.produtList[i]['goods_thumb'];
    	                	var url = "javascript:get_product("+data['produtList'][i]['id']+");";
    	                	result += '<a href="'+url+'">';
    	                	result += '<div class="good-img"><img src="'+img+'" onerror='+errorimg+' alt=""></div>';
    	                	result += '<div class="good-text-bg">';
    	                	result += '<span class="essay-goods-title">'+data.produtList[i]["name"]+'</span>';
    	                	result += '<span class="essay-goods-monery">￥'+data.produtList[i]['int_price'];
    	                	result += '<span class="font13">.'+data.produtList[i]['dec_price'];
    	                	result += '</span></span>';
    	                	result += '</div></a>';
    	                }
    	                $('#product-recommend').find('.essay').append(result);
    	                var width = $("#essay .good-img").width();
                        $("#essay .good-img").height(width); 
    	                $("#product-recommend").show();
    	                page++;
    	                me.resetload();
    	            }else{
    	            	$(".essay_botton").css("position","fixed");
    	            		if(page == 1){//第一次默认排序没有商品
	    	            		result += '<div class=" clearfix" style="text-align:center;padding-top: 60px;color:#999;border:none;">';
		    	            	result += '<span class="icon-chakandingdan" style="font-size: 100px;"></span><br>';
		    	            	result += ' <span style="display: inline-block;padding-top: 20px;font-size: 15px;">抱歉，暂时还没有任何商品哦！</span> </div>';
		    	            	$('#product-recommend').find('.essay').append(result);
		    	            	// 锁定
		    	                me.lock();
		    	                // 无数据
		    	                me.noData();
		    	                me.resetload();
		    	                $(".dropload-noData").hide();
	    	            	}else{ 
								if(page == 1){
									 //第一次其它排序没有商品
		    	            		result += '<div class=" clearfix" style="text-align:center;padding-top: 60px;color:#999;border:none;">';
    		    	            	result += '<span class="icon-chakandingdan" style="font-size: 100px;"></span><br>';
    		    	            	result += ' <span style="display: inline-block;padding-top: 20px;font-size: 15px;">抱歉，暂时还没有任何商品哦！</span> </div>';
    		    	            	$('#product-recommend').find('.essay').append(result);
    		    	            	// 锁定
    		    	                me.lock();
    		    	                // 无数据
    		    	                me.noData();
    		    	                me.resetload();
    		    	                $(".essay_botton").css("position","relative");
    		    	                $(".dropload-noData").hide();
								}else{
									// 锁定
    		    	                me.lock();
    		    	                // 无数据
    		    	                me.noData();
    		    	                me.resetload();
										
										}	
		    	            	
		    	            	}
    	            }
    	        },"json");
    	    }
    
    	}
	});
	function  navigation(types){
		if(types == 1){
			type = 'new';
			}
		if(types == 2){
			type = 'sale';
			}
		page = 1;//默认第一页
		cate_id = '';
		isparent = '';
        $("#product-recommend").find(".essay").empty();
        // 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
		}

    function selectnav(cate,parent){
    	cate_id = cate;
    	isparent = parent;
    	type = '';
    	page = 1;//默认第一页
    	$("#product-recommend").find(".essay").empty();
  	    // 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
        }

    
<?php if(isset($parent)){ ?>
//分享
function share(){
	 window.location.href="<#share_shop#>name=<?php echo $shop['name'];?>的互助店@desc=刚刚在51乐赚看到一间不错的店铺，好东西要一起分享，快来看看吧!@url=<?php echo site_url('shop/skipping')."?parent=".$parent."&mark=".base64_encode(4)."&enctpye=mobile";?>";
}
<?php }?>


 var width = $("#essay .good-img").width();
 $("#essay .good-img").height(width);  
 $(".dropload-down").css("margin-bottom","25px");
  

		
</script>