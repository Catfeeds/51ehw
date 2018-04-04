<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/guanjie_tem.css" rel="stylesheet" type="text/css">

<title>51易货网</title>
</head>

<body>
 	<!--公用页头开始-->
    
	<!--公用页头 结束-->
    
	<!--店铺头部 开始-->
	<div class="guanjie_top">
    	<div class="guanjie_top_con"><img src="./corporation_template/C_42/images/guanjjie_topBanner.png" width="1200" height="110" alt=""/></div>
	</div>
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar clearfix">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style="background:#000000;">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="">全部分类<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
<!--                                 <h3> -->
                                    <!-- <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">精品上衣</a></span><s style="display: block;"></s> -->
<!--                                 </h3>  -->
                            </li>

                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li class="macth_liactive"><a href="<?php echo site_url('home/GoToShop/42');?>">首页</a></li>
                    <span id='top_shop_classify'><!-- <li><a href="">媒体广告</a> --></li></span>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
    </div> 
	<!--头部导航条 结束-->
	<!--冠杰店铺 midBanner 开始-->
    <div class="guanjie_midBanner">
    	<div class="guanjie_midBanner_con">
    		<img src="./corporation_template/C_42/images/guanjie_midBanner.png" width="1200" height="900" alt=""/>
        </div>
    </div>
    <!--冠杰店铺 midBanner 结束-->
    <!--冠杰店铺 classify 开始-->
    <div class="guanjie_classify">
    	<div class="guanjie_classify_con">
            <ul>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_classify01.png" width="300" height="129" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_classify02.png" width="300" height="129" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_classify03.png" width="300" height="129" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_classify04.png" width="300" height="129" alt=""/></a></li>
            </ul>
        </div>
    </div>
    <!--冠杰店铺 classify 结束-->
    <!--冠杰店铺 goodsBanner 开始-->  
    <div class="guanjie_goodsBanner"><!--清除浮动－使得尾部导航不浮动-->
    	<div class="guanjie_goodsBanner_con clearfix">
        	<ul>
            	<li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner01.png" width="1200" height="830"alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner02.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner03.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner04.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner05.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner06.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner07.png" width="1200" height="830" alt=""/></a></li>
                <li><a href=""><img src="./corporation_template/C_42/images/guanjie_bBanner08.png" width="1200" height="830" alt=""/></a></li>
            </ul>
        </div>
    </div>
    <!--冠杰店铺 goodsBanner 结束-->
    <!--冠杰店铺 goods 开始-->
    <div class="guanjie_goods">
    	<div class="guanjie_goods_con clearfix">
        	<!--冠杰店铺 goods 搜索开始-->
<!--             <div class="guanjie_goods_search"> -->
<!--             	<div class="guanjie_search_box"> -->
<!--                 	<input class="guanjie_input" type="text" placeholder="搜索内容"> -->
<!--                     <a href="" class="guanjie_search_btn">搜索</a> -->
<!--                     <span>热门搜索：</span> -->
<!--                     <span><a href="" class="guanjie_search_hot">二环内</a></span> -->
<!--                     <span><a href="">三环内</a></span> -->
<!--                     <span><a href="">高速路</a></span> -->
<!--                     <span><a href="">机场</a></span> -->
<!--                     <span><a href="">楼宇</a></span> -->
<!--                     </span> -->
<!--                 </div> -->
<!--             </div> -->
            <!--冠杰店铺 goods 搜索结束-->
            <!--冠杰店铺 recommend 推荐开始-->
            <div class="guanjie_recommend">
              <h2 class="guanjie_recommend_top">易货推荐</h2>
               <ul class="guanjie_reccommend_ul clearfix">
                   <li>
                       <a href="">
                          <img src="./corporation_template/C_42/images/guanjie_goods01.png" width="280" height="280" alt=""/> 
                          <span class="recommend_ul_left">
                              <h4>北大街十字国美电器城</h4>
                              <em>63800.00</em>
                          </span>
                          <span class="recommend_ul_right"><a href=""></a></span>
                       </a>
                   </li>
                   <li>
                       <a href="">
                          <img src="./corporation_template/C_42/images/guanjie_goods02.png" width="280" height="280" alt=""/> 
                          <span class="recommend_ul_left">
                              <h4>新城广场青少年宫LED</h4>
                              <em>63800.00</em>
                          </span>
                          <span class="recommend_ul_right"><a href=""></a></span>
                       </a>
                   </li>
                   <li>
                       <a href="">
                          <img src="./corporation_template/C_42/images/guanjie_goods03.png" width="280" height="280" alt=""/> 
                          <span class="recommend_ul_left">
                              <h4>广丰国际</h4>
                              <em>63800.00</em>
                          </span>
                          <span class="recommend_ul_right"><a href=""></a></span>
                       </a>
                   </li>
                   <li style="margin-right:0;">
                       <a href="">
                          <img src="./corporation_template/C_42/images/guanjie_goods04.png" width="280" height="280" alt=""/> 
                          <span class="recommend_ul_left">
                              <h4>机场T2到达厅</h4>
                              <em>63800.00</em>
                          </span>
                          <span class="recommend_ul_right"><a href=""></a></span>
                       </a>
                   </li>
               </ul>
              </div>
              <!--冠杰店铺 recommend 推荐结束-->
              
              <!--冠杰店铺 所有媒体 开始-->
              <div class="guanjie_media clearfix">
                <h2 class="guanjie_recommend_top">所有商品
<!--                   <ul class="guanjie_media_ul"> -->
<!--                             <li><a href="">销量</a></li> -->
<!--                             <li><a href="">价格</a></li> -->
<!--                             <li><a href="" class="guanjie_media_liCurrent">好评度</a></li> -->
<!--                             <li><a href="">上架时间</a></li> -->
<!--                         </ul> -->
                 </h2><!--所有媒体头部 结束-->
                 <ul class="guanjie_media_goods clearfix" id='guanjie_media_goods'>

                 </ul><!--多媒体商品 结束-->
                 <!--多媒体分页 开始-->
                 <div class="media_showpage">
<!--                     <span>共171条纪录</span> -->
<!--                     &nbsp;<a class="cpage">1</a>&nbsp;<a href="">2</a>&nbsp;<a href="">3</a>&nbsp;<a href="">4</a>&nbsp;<a href="" class="lPage">下一页</a>&nbsp;&nbsp;<a href="">&gt;&gt;</a>  -->
                </div><!--多媒体分页 结束-->
                </div>
                <!--冠杰店铺 所有媒体 结束-->
            
        </div>
    </div>
    <!--冠杰店铺 goods 开始-->
    </div>

</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
	//收藏量与销售量切换内容js
	$(".rankingList_top_current").mouseover(function(){
		$(".rankingList_top_current").css("background","#ccc");
		$("#sales").css("background","#fff");
		$("#rankingList_one").show();
		$("#rankingList_two").hide();
	})
	$("#sales").mouseover(function(){
		$("#sales").css("background","#ccc");
		$(".rankingList_top_current").css("background","#fff");
		$("#rankingList_two").show();$("#rankingList_one").hide();
	})
	
    $(function (){
        var html = '';
        var classify = '';
        var top_classify= '';
        var page = '';
    	$.post('<?php echo site_url('flagship');?>',{id_corporation:42},function(data){
    	    data = jQuery.parseJSON(data);
    	    //商品
    	    for(var i=0;i<data['produtList'].length;i++){
        	    if(i%5==4){
                    html += '<li style="margin-right:0;">';
        	    }else{
        	    	html += '<li>';
            	    }
                    html += '<a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/42">';
                    html += '<img src="<?php echo site_url();?>/../'+data['produtList'][i]['image_name']+'" width="206" height="206" alt=""/>' ;
                    html += '<p id="name">'+data['produtList'][i]['name']+'</p>';
                    html +='<span class="media_goods_pirce">¥'+data['produtList'][i]['m_price']+'</span>';
//                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
                    html +='</a>';
                    html +='<ul class="media_goods_btn">';
                    html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/42">购买</a></li>';
                    html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
//                     html +='<li><a href="">对比</a></li>';
                    html +='</ul>';
                    html +='</li>';
        	    }
    	    //全部分类
    	    for(var i=0;i<data['shop_classify'].length;i++){
                classify += '<li class="macth_xvitem" data-bind="attr:{data-submenu-id:$data.id}" data-submenu-id="speedMenu517">';
                classify += '<h3>'
                classify += '<span></span><span class="macth_xvh3_a"><a href="<?php echo site_url('goods/shop_goods');?>/'+data['shop_classify'][i]['id']+'" data-bind="text:$data.title" class="">'+data['shop_classify'][i]['section_name']+'</a></span><s style="display: block;"></s>'
                classify += '</h3>' 
                classify += '</li>'
    	    }

      	  //顶级分类
    	    for(var i=0;i<data['top_shop_classify'].length;i++){
                top_classify += '<li><a href="<?php echo site_url('goods/shop_goods');?>/'+data['top_shop_classify'][i]['id']+'">'+data['top_shop_classify'][i]['section_name']+'</a></li>';
    	    }
    	   //分页显示
    	    page +='<span>共'+data['total_rows']+'条纪录</span>&nbsp';
    	    var pageNum = parseInt(data['total_rows']/15+1);
    	    for(var i=1;i<=pageNum;i++){
    	        page +='<a href="<?php echo site_url('goods/flagship_shop/0/42');?>" class="cpage">'+i+'</a>&nbsp;';
    	    }
           	page +='<a href="<?php echo site_url('goods/flagship_shop/0/42');?>" class="lPage">下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

            $('.media_showpage').html(page);   
    	    $('#top_shop_classify').html(top_classify);
    	    $('.macth-dropdown-menu').html(classify);
    	    $('#guanjie_media_goods').html(html);
        	});

        	
    });
	function add_to_fav(pid)
	{
		<?php if(!$this->session->userdata('user_in')):?>
		alert('您还未登录，请先登录。');
		<?php else:?>
		$.ajax({
		      url: base_url+'/member/fav/ajax_add',
		      type: 'POST',
		      data:{'pid':pid},
		      dataType: 'html',
		      success: function(data){
					alert(data);
		      	}
		    });
	    <?php endif;?>
	}
</script>
</html>
