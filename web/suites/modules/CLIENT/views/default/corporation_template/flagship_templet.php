<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="css/fancymain.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/guanjie_tem.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script src="js/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript" src="js/slick.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<link rel="stylesheet" type="text/css" href="css/slick.css"/>
<title>51易货网</title>
</head>

<style>
/* 店铺模版－多产品－Banner轮播图 */
.carousel{ width:100%;}
.bd { margin-left:-960px;}
.carousel ul.imageslist{width:7680px;}



</style>
<body>
    <!--页头编辑 开始-->
    
    
	<!--店铺头部 开始-->
	<?php if(isset($list['top']) || isset ($list['top-color']) ):?>
	<div class="guanjie_top  hover_it" style="position:relative; background:<?php echo isset ($list['top-color']) ? $list['top-color'][0]['desc'] : ''?>">
    	<div class="store_top_con"><a href='<?php echo isset($list['top']) ? $list['top'][0]['link_path'] : ''?>' id='top'><img src="<?php echo isset($list['top']) ? IMAGE_URL.$list['top'][0]['img_path'] : ''?>"  width=""height="100" alt=""/></a></div>
    </div>
     <?php endif;?>
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar clearfix hover_it" style="position:relative;">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style="background:#000000; z-index:99;">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:void(0)">全部分类<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">精品上衣</a></span><s style="display: block;"></s>
                                </h3> 
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu496">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">保暖裤装</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu141">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">百搭外套</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu931">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">新品围巾</a></span><s style="display: block;"></s>
                                </h3>
                                </li>
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li id='home' class="macth_liactive"><a href="<?php echo site_url('home/GoToShop/'.$corp)?>">首页</a></li>
                    <span id='top_shop_classify'><!-- <li><a href="javascript:;">媒体广告</a> --></li></span>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
		<!--编辑区 开始-->
        
        <!--编辑区 结束-->
    </div>
	<!--头部导航条 结束-->
    
    <!--Banner内容 开始-->
    <div class="carousel hover_it" style="position: relative;">
     
       <?php if(isset($list['carousel-img'] ) ):?>
       <div class="bd">
             <ul class="imageslist">
                <?php foreach ($list['carousel-img'] as $v):?>
                    <li><a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" /></a></li>
                <?php endforeach;?>	 
            </ul>  
              </div>
        <?php else:?> 
        <div class="bd">
            <ul class="imageslist">
                <li><a href="#"><img src="images/store_banner1920.png" /></a></li>
                <li><a href="#"><img src="images/store_banner1920.png" /></a></li>
                <li><a href="#"><img src="images/store_banner1920.png" /></a></li>
                <li><a href="#"><img src="images/store_banner1920.png" /></a></li>	 
            </ul> 
           </div>
        <?php endif;?>
            <div class="buttons">
                <a class="leftBtn"></a>
                <a class="rightBtn"></a>
            </div>
           
            <div class="bg"></div>
        <?php if(isset($list['carousel-img'] ) ):?>
            <div class="num">
                <?php for ($i = 0; $i<count( $list['carousel-img']); $i++ ):?>
                    <span <?php if($i == 0) echo "class='cur';"?>></span>
                <?php endfor;?>
            </div>
        <?php else:;?>
            <div class="num">
                <span class="cur"></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        <?php endif;?>
        
 
    </div>
    <script type="text/javascript" src="js/chuantong.js"></script>
    <script type="text/javascript">
        chuantong(300,4000,1920);
    </script>
    <!--Banner内容 结束--> 
    
	<!--冠杰店铺 midBanner 开始
    <div class="guanjie_midBanner">
    	<div class="guanjie_midBanner_con">
    		<img src="images/guanjie_midBanner.png" width="1200" alt=""/>
        </div>
    </div>-->
    <!--冠杰店铺 midBanner 结束-->
    <!--冠杰店铺 classify 开始-->
           <div class="guango">
               <img src="images/gg.jpg"/>           
             </div>
             <div class="clear"></div>
        <div class="guanjie_classify hover_it" style="position:relative;background:<?php echo isset($list['mid-color'][0]['desc']) ? $list['mid-color'][0]['desc'] :''?>">
        	<?php if(isset($list['central-img'] ) ):?>
        	<div class="guanjie_classify_con clearfix" >
                <ul>
                    <?php foreach( $list['central-img']  as $v):?>
                         <li><a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="300" height="129" alt=""/></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php endif;?>
        </div>
    
    <!--冠杰店铺 classify 结束-->
    <div id="page_body">
    <!--冠杰店铺 goodsBanner 开始-->  
    <?php if(isset($list['first']) || isset($list['first-layer-color']) ):?>
         <div class="guanjie_goodsBanner" style="background:<?php echo isset($list['first-layer-color']) ? $list['first-layer-color'][0]['desc']:''?>"><!--第一层-->
        	<div class="guanjie_goodsBanner_con clearfix">
            	<ul>
                	<li class=" hover_it" style="position:relative;" id="first_layer">
                    	<a href="<?php echo isset($list['first']) ? $list['first'][0]['link_path'] : ''?>"><img src="<?php echo isset($list['first']) ? IMAGE_URL.$list['first'][0]['img_path'] :''?>" width="1200" height="830"alt=""/></a>
                        
                    </li>
                </ul>
            </div>
        </div>
    <?php endif;?>
    <?php if(isset($floor) && count($floor) > 0):?>
        <?php foreach ( $floor as $k => $v):?>
            <div class="guanjie_goodsBanner" id="floor_<?php echo $v['id']?>" style="background:<?php echo isset($v['color']) ?  $v['color'] : ''?>"><!--清除浮动－使得尾部导航不浮动-->
            	<div class="guanjie_goodsBanner_con clearfix">
                	<ul>
                    	<li class=" hover_it" style="position:relative;" id="<?php echo 'floor_'.$i?>">
                        	<a href="<?php echo $v['link_path']?>"><img src="<?php echo !empty($v['img_path']) ? IMAGE_URL.$v['img_path'] : 'images/storeSingle_pic01.png'?>" width="1200" height="830"alt=""/></a>
                            
                        </li>
                    </ul>
                </div>
           </div>
       <?php endforeach;?>
  <?php endif;?>
    <!--冠杰店铺 goodsBanner 结束-->
    </div>
    <!--冠杰店铺 goods 开始-->
    <div class="guanjie_goods" style="background:<?php echo isset($list['foot-body-color']) ? $list['foot-body-color'][0]['desc'] : ''?>">
    	<div class="guanjie_goods_con clearfix">
        	<!--冠杰店铺 goods 搜索开始-
            <div class="guanjie_goods_search">
            	<div class="guanjie_search_box">
                	<input class="guanjie_input" type="text" placeholder="搜索内容">
                    <a href="" class="guanjie_search_btn">搜索</a>
                    <span>热门搜索：</span>
                    <span><a href="" class="guanjie_search_hot">二环内</a></span>
                    <span><a href="">三环内</a></span>
                    <span><a href="">高速路</a></span>
                    <span><a href="">机场</a></span>
                    <span><a href="">楼宇</a></span>
                    </span>
                </div>
            </div>
            冠杰店铺 goods 搜索结束-->
            <?php if(isset($list['end-img']) ):?>
            <!--冠杰店铺 recommend 推荐开始-->
            <div class="guanjie_recommend clearfix">
              <h2 class="guanjie_recommend_top hover_it" style="position:relative;"><?php echo isset($list['end-title']) ? $list['end-title'][0]['desc'] : ''?>
<!--               	<div class="editCon"> -->
<!--                     <div class="editBtnCon clearfix"> -->
<!--                         <a href="javascript:;" class="editBtn">编辑</a> -->
<!--                     </div> -->
<!--                 </div> -->
              </h2>
                               		<section id="features" class="blue">
			<div class="content">
			
				<div class="slider autoplay">
                    <?php foreach ($list['end-img'] as $v):?>
                    <div>
                        <h3>
                            <a href="<?php echo $v['link_path']?>">
                                <div class="image">
                                    <img src="<?php echo IMAGE_URL.$v['img_path']?>" width="280" height="280" alt=""/> 
                                </div>
                                <span class="recommend_ul_left">
                                    <h4><?php echo $v['desc']?></h4>
                                    <em><?php echo $v['vip_price'] ?></em>
                                </span>
                                <span class="recommend_ul_right">
    
                                </span>
                            </a>
                        </h3>
                            
                    </div>
                    <?php endforeach;?> 
                    
			</div>
		</section>
              </div>
              <!--冠杰店铺 recommend 推荐结束-->
              <?php endif;?>
            <!-- 商品部分 --> 
             
              <!--冠杰店铺 所有媒体 开始-->
              <div class="guanjie_media clearfix" id="guanjie_media">
                <h2 class="guanjie_recommend_top">商品
<!--                   <ul class="guanjie_media_ul"> -->
<!--                             <li><a href="javascript:;">销量</a></li> -->
<!--                             <li><a href="javascript:;">价格</a></li> -->
<!--                             <li><a href="javascript:;" class="guanjie_media_liCurrent">好评度</a></li> -->
<!--                             <li><a href="javascript:;">上架时间</a></li> -->
<!--                         </ul> -->
                 </h2><!--所有媒体头部 结束-->
                 <ul class="guanjie_media_goods clearfix" id='guanjie_media_goods'>

                 </ul><!--多媒体商品 结束-->
                 <!--多媒体分页 开始-->
                 <div class="media_showpage">
<!--                     <span>共171条纪录</span> -->
<!--                     &nbsp;<a class="cpage">1</a>&nbsp;<a href="javascript:;">2</a>&nbsp;<a href="javascript:;">3</a>&nbsp;<a href="javascript:;">4</a>&nbsp;<a href="javascript:;" class="lPage">下一页</a>&nbsp;&nbsp;<a href="javascript:;">&gt;&gt;</a>  -->
                </div><!--多媒体分页 结束-->
                </div>
                <!--冠杰店铺 所有媒体 结束-->
        </div>
    </div>
    <!--冠杰店铺 goods 开始-->
    </div>
    
	
        
    <!--弹出层 fancybox-top 编辑仅图片 头部banner开始-->
    
    <!--弹出层 fancybox-top 编辑仅图片 头部banner结束--> 

	<!--弹出层 fancybox0 编辑轮播图banner 开始-->
    
    <!--弹出层 fancybox0 编辑轮播图banner 结束-->
    
    <!--弹出层 fancybox1 编辑分类图片 开始-->
    
    <!--弹出层 fancybox1 编辑分类图片 结束-->
    
    <!--弹出层 fancybox2 编辑楼层图片 开始-->
    
    <!--弹出层 fancybox2 编辑楼层图片 结束-->
    
    <!--弹出层 fancybox_color 编辑背景颜色 开始-->
    
    <!--弹出层 fancybox_color 编辑背景颜色 结束-->
    
    <!--弹出层 fancybox3 编辑产品标题 开始-->
   
    <!--弹出层 fancybox3 编辑产品标题 结束-->
    
    <!--弹出层 fancybox4 编辑 开始-->
    
    <!--弹出层 fancybox4 编辑 结束--> 
    <!--弹出层 fancybox5 编辑删除 开始-->
    
<!--弹出层 fancybox5 删除 结束--> 
</body>


<script>
    var corp = "<?php echo $corp;?>"
    $('.int_left').click(function(){
        $arr = $('.guanjie_reccommend_ul').children().length;
        $ther = $('.guanjie_reccommend_ul');
        $counts = ($arr - 4) * -300;
        if(parseInt($ther.css('left'))==0){
            $str = 0;
        }
        var i =0;
        i = parseInt($str)-300;
        $ther.attr('ok',i)
        $str = $ther.attr('ok');
        
        if($str==$counts){
            $ther.attr('ok',parseInt($str))
            $('.int_left').hide();
            $('.guanjie_reccommend_ul').animate({left:"-=300px"},500);
            return false;
        }
        if($str<0){
            $('.int_right').show();
        }else{
            $('.int_right').hide();
        }
        $('.guanjie_reccommend_ul').animate({left:"-=300px"},500);
    })
    $('.int_right').click(function(){
        $son = $('.guanjie_reccommend_ul').attr('ok');
        $counts = ($arr - 4) * -300;
        var i =0;
        i = parseInt($son)+300;
        $ther.attr('ok',i)
        $str = $ther.attr('ok');
        if($str==0){
            $('.int_right').hide();
            $('.guanjie_reccommend_ul').animate({left:"+=300px"},500);
            return false;
        }
        if($son!=$counts){
            $('.int_left').show();
        }else{
            $('.int_left').hide();
        }
        $('.guanjie_reccommend_ul').animate({left:"+=300px"},500);
    })
	
	//点击编辑按钮－js
	
	function edit(key){ 
    	arr=key.split('_');
     	duibi = arr[0];
     	
    	if(duibi == 'top'){ 
        	$('#biaoshi li span').text('图片尺寸：1920X110');
        }else if(duibi == 'central-img'){ 
        	$('#biaoshi li span').text('图片尺寸：300X129');
        }else if(duibi == 'carousel-img'){ 
        	$('#biaoshi li span').text('图片尺寸：1200X500');
        }else{ 
        	$('#biaoshi li span').text('图片尺寸：1200X830');
        }
    	$('#biaoshi input[name=tem_key]').val(key);
    	$('.fancybox-top').show();
    }
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back-top').click(function(){
		$('.fancybox-top').hide();
	});
	
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back1').click(function(){
		$('.fancybox1').hide();
	});
	//点击分类图片 编辑背景颜色按钮，弹出层内容
	$('.guanjie_classify .addFloorBtn').click(function(){
		$('.fancybox_color').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back_color').click(function(){
		$('.fancybox_color').hide();
	});
	
	//点击楼层图片编辑按钮，弹出层内容
	$('.guanjie_goodsBanner_con .editBtn').click(function(){
		$('.fancybox2').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back2').click(function(){
		$('.fancybox2').hide();
	});
	
	//点击产品标题 编辑按钮，弹出层内容
	$('.guanjie_recommend_top .editBtn').click(function(){
		
		$('.fancybox3').show();
	});

    //删除  
    function show_del(id){$('.fancybox5').show(); $('input[name=del_id]').val(id) }
	//隐藏
	function hide_del(){ $('.fancybox5').hide(); }
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back3').click(function(){
		$('.fancybox3').hide();
	});
	
	//点击产品带价格 编辑按钮，弹出层内容
	function edit_goods(key){ 
		$('#biaoshi_2 li input[name=tem_key]').val(key);
		$('.fancybox4').show();
	}

	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back4').click(function(){
		$('.fancybox4').hide();
	});

	 //关注商品
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

   

    $(function (){
        var html = '';
        var classify = '';
        var top_classify= '';
        var page = '';
    	$.post('<?php echo site_url('flagship');?>',{corp:corp},function(data){
    	    data = jQuery.parseJSON(data);
    	   
    	    //商品
    	    for(var i=0;i<data['produtList'].length;i++){
        	    if(i%5==4){
                    html += '<li style="margin-right:0;">';
        	    }else{
        	    	html += '<li>';
            	    }
                    html += '<a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">';
                    html += '<img src="<?php echo IMAGE_URL;?>'+data['produtList'][i]['image_name']+'_270'+data['produtList'][i]['file_ext']+'" width="206" height="206" alt=""/>' ;
                    html += '<p id="name">'+data['produtList'][i]['name']+'</p>';
                    html +='<span class="media_goods_pirce">¥'+data['produtList'][i]['vip_price']+'</span>';
//                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
                    html +='</a>';
                    html +='<ul class="media_goods_btn">';
                    html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">购买</a></li>';
                    html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
//                     html +='<li><a href="javascript:;">对比</a></li>';
                    html +='</ul>';
                    html +='</li>';
        	    }
    	    //全部分类
    	    for(var i=0;i<data['shop_classify'].length;i++){
                classify += '<li class="macth_xvitem" data-bind="attr:{data-submenu-id:$data.id}" data-submenu-id="speedMenu517">';
                classify += '<h3>'
                classify += '<span></span><span class="macth_xvh3_a"><a href="javascript:;" onclick="top_shop_classify('+data['shop_classify'][i]['id']+','+data['corp_id']+')" class="">'+data['shop_classify'][i]['section_name']+'</a></span><s style="display: block;"></s>'
                classify += '</h3>' 
                classify += '</li>'
    	    }

      	  //顶级分类
    	    for(var i=0;i<data['top_shop_classify'].length;i++){
                top_classify += '<li onclick="top_shop_classify('+data['top_shop_classify'][i]['id']+','+data['corp_id']+',this)"><a href="javascript:;" >'+data['top_shop_classify'][i]['section_name']+'</a></li>';
    	    }
    	   //分页显示
      	    page += '<span id="page">';
    	    page +='<span>共'+data['total_rows']+'条纪录</span>&nbsp';
    	    var pageNum = Math.ceil(data['total_rows']/20);//页数
    	    if(pageNum !== 1){
    	    page +='<a href="javascript:void(0);" class="lPage" id="previous" >上一页</a>&nbsp;';
    	    }
    	    for(var i=1;i<=pageNum;i++){
    	        page +='<a href="javascript:void(0);" class="cpage" onclick="pagination('+i+','+pageNum+',1);">'+i+'</a>&nbsp;';
    	    }
    	    if(pageNum !== 1){
           	page +='<a href="javascript:void(0);" class="lPage" id="next" onclick="pagination(2,'+pageNum+',2);">下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    	    }
           	page += '</span>';
           	
            $('.media_showpage').html(page);   
    	    $('#top_shop_classify').html(top_classify);
    	    $('.macth-dropdown-menu').html(classify);
    	    $('#guanjie_media_goods').html(html);
        	});

        	
    });

    //分类
	function top_shop_classify(section_id,corporation_id,obj,page,total,status){
		location.hash = 'guanjie_media';
		var html = '';
		$('.macth_liactive').removeClass('macth_liactive');
		$(obj).addClass('macth_liactive');
		$('.guanjie_midBanner').hide();
		$('.guanjie_classify').hide();
		$('.guanjie_goodsBanner').hide();
		$('.guanjie_recommend').hide();
		$('.guango').hide();
		$('#page').hide();
		$.post("<?php echo site_url('flagship/top_shop_classify');?>",{section_id:section_id,corporation_id:corporation_id},function(data){
			data = jQuery.parseJSON(data);
    	    //商品
    	    if(data['produtList'].length>0){
        	    for(var i=0;i<data['produtList'].length;i++){
            	    if(i%5==4){
                        html += '<li style="margin-right:0;">';
            	    }else{
            	    	html += '<li>';
                	    }
                        html += '<a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">';
                        html += '<img src="<?php echo IMAGE_URL;?>'+data['produtList'][i]['goods_thumb']+'" width="206" height="206" alt=""/>' ;
                        html += '<p id="name">'+data['produtList'][i]['name']+'</p>';
                        html +='<span class="media_goods_pirce">¥'+data['produtList'][i]['vip_price']+'</span>';
    //                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
                        html +='</a>';
                        html +='<ul class="media_goods_btn">';
                        html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">购买</a></li>';
                        html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
    //                     html +='<li><a href="javascript:;">对比</a></li>';
                        html +='</ul>';
                        html +='</li>';
            	    }
          	  
        	    $('#guanjie_media_goods').html(html);
        	    }else{
            	    
            	    html +='<li class="result_none" style=" width: 1180px;padding-bottom: 20px;background:none;">暂无商品</li>';
        	    	$('#guanjie_media_goods').html(html);
            	    }
			});
		}

	//ajax 分页
	//status 0上一页1选择页2下一页
	function pagination(page,total,status){
		
		
    	$('#next').show();
    	$('#previous').show();
		switch(status){
		case 0:
			$('#next').show();
			$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
			if(page==1){
				 $('#previous').hide();
				 break;
				}
			$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
			break;
		case 1:
	 		if(total==page){
				 $('#next').hide();
				 $('#previous').show();
				}else if(page==1){
					$('#previous').hide();
					$('#next').show();
					}
	 		$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
	 		$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
			break;
		case 2:
			$('#previous').show();
			$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
	 		if(total==page){
			 $('#next').hide();
			 break;
			}
			$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
			break;
		}

		var html = '';
		$.post('<?php echo site_url('flagship/pagination');?>',{page:page,corp:corp},function(data){
		    data = jQuery.parseJSON(data);
		    
    			    for(var i=0;i<data.length;i++){
                	    if(i%5==4){
                            html += '<li style="margin-right:0;">';
                	    }else{
                	    	html += '<li>';
                    	    }
                            html += '<a href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'/'+corp+'">';
                            html += '<img src="<?php echo IMAGE_URL;?>'+data[i]['goods_thumb']+'" width="206" height="206" alt=""/>' ;
                            html += '<p id="name">'+data[i]['name']+'</p>';
                            html +='<span class="media_goods_pirce">¥'+data[i]['vip_price']+'</span>';
        //                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
                            html +='</a>';
                            html +='<ul class="media_goods_btn">';
                            html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'/'+corp+'">购买</a></li>';
                            html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data[i]['id']+')">关注</a></li>';
        //                     html +='<li><a href="javascript:;">对比</a></li>';
                            html +='</ul>';
                            html +='</li>';
                            }
    			    $('#guanjie_media_goods').html(html);
			});
		}
</script>
</html>
