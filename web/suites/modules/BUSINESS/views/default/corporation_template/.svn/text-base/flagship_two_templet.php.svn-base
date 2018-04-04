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
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->
<link rel="stylesheet" type="text/css" href="css/slick.css"/>
<title>51易货网</title>
</head>

<style>

.banner{ height:435px;margin:0px auto; overflow:hidden;}
/* fullSlide */
.fullSlide{width:100%;position:relative;height:435px; overflow:hidden;}
.fullSlide .bd{margin:0 auto;position: absolute;z-index:0;overflow:hidden; margin-left:-960px; left:50%;}
.fullSlide .bd ul{width:100% !important;}
.fullSlide .bd li{width:100% !important;height:435px;overflow:hidden;text-align:center;background:#fff center 0 no-repeat;}
.fullSlide .bd li a{display:block;height:435px;}
.fullSlide .hd1{width:100%;position:absolute;z-index:1;bottom:0;left:0;height:30px;line-height:30px;}
.fullSlide .hd1 ul{text-align:center;}
.fullSlide .hd1 ul li{cursor:pointer; display:inline-flex;zoom:1;width:10px;height:10px;margin:1px;overflow:hidden;background:#fff; border-radius:10px;line-height:999px;}
.fullSlide .hd1 ul .on{border:2px solid #fff;background:none; line-height:999px;}
.fullSlide .prev,.fullSlide .next{display:block;position:absolute;z-index:1;top:50%;margin-top:-30px;left:10%;z-index:1;width:40px;height:60px;background:url(../../images/slider-arrow.png) -126px -137px #000 no-repeat;cursor:pointer;filter:alpha(opacity=50);opacity:0.5;display:none;}
.fullSlide .next{left:auto;right:10%;background-position:-6px -137px;}
.vertisement1{ width:1200px; margin:30px auto; height:60px; }
.macth_xv_categorys{ background:none;}
.macth_xv_nav li.macth_liactive a{ background:#ff8800;}
.macth_xv_categorys .macth_xv_cat_title .macth_cat_name a .icon-arrowdown { position: absolute; font-size: 19px; top: 8px; right:0;}
.icon-arrowdown{position: absolute;font-size: 26px; /*top: 2px;*/ right:0; z-index:88;  font-weight:normal !important;transform:rotate(90deg); float: right;}
/*店铺模版_多产品－头部*/
.store_head{ width:100%; min-width:1200px; height:122px; }
.store_head_con{ width:1200px; height:122px; margin:0 auto;}
.store_head_con span{ display:inline-block;  margin:50px 0 0 50px; font-size:16px; color:#555; float:left; }
.store_head_span{ margin-right:50px;}
.store_head_con a.logo_set{float: left; height: 64px; width: 160px; margin-top:20px;}
.store_head_search{ width:555px; height:37px; float:right; margin-right:6px; margin-top:38px;}
.store_head_search01{ width:460px; height:37px; background:#fea33b; position:relative; float:left;}
.store_head_input{ width:370px; height:33px; border:none; outline:none; text-indent:5px; top:2px; left:2px; position:absolute; font-size:14px;}
.search_total_station{background:＃fea33b; width:88px; height:33px; display:inline-block; position:absolute; right:0; top:2px; text-align:center; line-height:33px; color:#fff; font-size:16px;}
.search_total_station:hover{ color:#fff;}
.store_head_search02{ font-size:16px; width:90px; height:37px; background:#252525; float:right; text-align:center; line-height:37px;}
.store_head_search02 a{ color:#fff;}
.store_head_search02 a:hover{ color:#fff;}
.store_top{ width:100%;  height:100px; }
.store_top_con{height:100px; position:absolute; left:50%; margin-left:-960px; overflow:hidden;} 
.store_top_con img{ width:100%;}
.store_nav{ width:100%; min-width:1200px; height:36px; line-height:36px; background:#fea33b;}
.media_top_nei_zhong_t em{ margin-left:0px;}
.media_top_nei_zhong_t2 em{ margin-left:4px;}
.media_top_nei_zhong_t1 em{ margin-left:4px;}
.guanjie_top{ height:auto; background:#ffffff;overflow:hidden;}
</style>

</head>

<body>
<!--导航 开始-->
	<!--店铺头部 开始-->
	<div class="guanjie_top">
    	<div class="guanjie_top_nei">
          <div class="guanjie_top_nei_top">
    	<a href='<?php echo isset($list["top"]['0']['link_path']) ? $list["top"]['0']['link_path'] : ''?>'><img src="<?php echo isset($list['top']['0']['img_path']) ? IMAGE_URL.$list['top']['0']['img_path']: 'images/store_topBanner.png';?>" width='1920' height='181' alt=""/></a>
          </div>
          <div class="guanjie_top_neit1">
<!--           <p><a href="javascript:;"><i class="icon-yixihuan"></i>收藏本店</a></p> -->
          </div>
          
        </div>
	
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar1 clearfix" style=" <?php echo isset($list['column-color']['0']['desc']) ? 'background:'.$list['column-color']['0']['desc'] : '' ?>">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style=" background:none">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:;">本店所有商品<b class="icon-select"></b></a></h2>
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
                         <li id='home' class="macth_liactive">
                            <a href="<?php echo isset($status) ? site_url('flagship/inspect_flagship_two_temp') : site_url('home/GoToShop/'.$corp)?>">首页</a>
                         </li>
                    <span id='top_shop_classify'><!-- <li><a href="javascript:;">媒体广告</a> --></li></span>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
    </div> 
    
    <!--轮播图-->
        <div class="fullSlide">
    <div class="painting_banner1">
    <div class="bd">
   
    <a href="<?php echo isset($list["carousel-img"]['0']['link_path']) ? $list["carousel-img"]['0']['link_path'] : ''?>" >
        <img src="<?php echo isset($list["carousel-img"]['0']['img_path']) ? IMAGE_URL.$list["carousel-img"]['0']['img_path'] : 'images/store_banner1920.png'  ?>"  height="435" width="1920">
    </a>
    
   </div>
   </div>
   </div>
    <div class="guanjie_top_conx" id="media_bottom">
      <div class="guanjie_top_conx_l">
      <div style="position:relative;">
       <div id="background-img-one" style="position: absolute;top: 0px;">
          <img src="<?php echo isset($list['background-img-one']['0']['img_path']) ? IMAGE_URL.$list['background-img-one']['0']['img_path']: '';?>" width='1920' height='891'alt=""/> 
      </div>
        <div class="guanjie_top_conx_b1">
          <ul>
           <li>
           <a  class="dingwei4"href="<?php echo isset($list['time-one']['0']['link_path']) ? $list['time-one']['0']['link_path']: '';?>">
           <img src="<?php echo isset($list['time-one']['0']['img_path']) ? IMAGE_URL.$list['time-one']['0']['img_path']: 'images/store_banner1200.png';?>" width="1200" height="436"/></a>
           
           <div class="guanjie_top_conx_b1_n dingwei">
             <div id="countbox1" class="countbox">
            <div id="days1">0
            </div>
            <div class="days_text1"></div>
            <div id="hours1">0
            </div> 
            <div class="hours_text1"></div>
            <div id="mins1">0
            </div>
             <div class="mins_text1"></div>
            <div id="secs1">0
            </div> 
            <div class="secs_text1"></div>
          </div>
<!--              <p>古丽兰 18K金钻石戒指</p> -->
<!--            <p class="juan4"><em><span class="juan">11495</span><samp class="juan1">货豆</samp></em><em style="margin-top:5px;"><span class="juan3">11495</span><samp class="juan2">货豆</samp></em></p> -->
<!--              <h6><a href="http://www.51ehw.com/goods/detail/1181">立即购买</a></h6> -->
           </div>
           </li>
             <li>
           <a  class="dingwei4"href="<?php echo isset($list['time-two']['0']['link_path']) ? $list['time-two']['0']['link_path']: '';?>">
           <img src="<?php echo isset($list['time-two']['0']['img_path']) ? IMAGE_URL.$list['time-two']['0']['img_path']: 'images/store_banner1200.png';?>" width="1200" height="436"/></a>
           
<!--            <p><a  class="dingwei2"href="http://www.51ehw.com/goods/detail/363"></a></p> -->
<!--            <p><a class="dingwei3"href="http://www.51ehw.com/goods/detail/267"></a></p> -->
           <div class="guanjie_top_conx_b1_n dingwei1">
             <div id="countbox2" class="countbox">
    <div id="days2">0
    </div> 
    <div class="days_text1"></div>
    <div id="hours2">0
    </div>
      <div class="hours_text1"></div>
    <div id="mins2">0
    </div>
     <div class="mins_text1"></div>
    <div id="secs2">0
    </div>
     <div class="secs_text1"></div>
  </div>
             <p></p>
            <!--   <h6 style="margin-top:25px;"><a href="http://www.51ehw.com/goods/detail/363">立即购买</a></h6> -->
           </div>
           </li>
          </ul>
        </div> 
        </div>
        <div style="position: relative; width: 100%; height:2450px;" id="bg_two">
         <div id="background-img-two" style="position: absolute;top: 0px;">
          <img src="<?php echo isset($list['background-img-two']['0']['img_path']) ? IMAGE_URL.$list['background-img-two']['0']['img_path']: '';?>"width='1920' height='2450'alt=""/> 
      </div>
      <div class="media_top" style="position:absolute; left:50%; margin-left:-600px;">
      <div class="media_top_nei">
         <ul>
              <?php if(isset($list['product']) ):?>
                  <?php foreach ($list['product'] as $v):?>
                  <li class="media_top_to"><a href="<?php echo $v['link_path']?>"> <img src="<?php echo isset($v['img_path']) ? IMAGE_URL.$v['img_path']: 'images/storeSingle_pic01.png' ?>"/ width="582px" height="358px"></a></li>
                  <?php endforeach;?>
              <?php endif;?>
              
          <?php if(isset($list['product-mid']) ):?>
              <?php foreach ($list['product-mid'] as $v):?>
              <li class="media_top_to1"><a href="<?php echo $v['link_path']?>"> <img src="<?php echo isset($v['img_path']) ? IMAGE_URL.$v['img_path']: 'images/hotSale_pic1.png' ?>" width="381px" height="285px"></a></li>
              <?php endforeach;?>
          <?php endif;?>
         </ul>
        </div>
        
        <div class="media_top_nei_zhong">
          <h5 style="position:relative" > <img src="<?php echo isset($list['title-img-one']['0']['img_path']) ? IMAGE_URL.$list['title-img-one']['0']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px" /></h5>
          <?php if(isset($list['mid-product'])):?> 
          <ul>
              <?php foreach ($list['mid-product'] as $v):?>
              <li>
                  <span><a href="<?php echo $v['link_path']?>"><img src="<?php echo isset($v['img_path']) ? IMAGE_URL.$v['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                  <p class="zhong_t1"><?php echo $v['desc']?></p>
                  <div class="media_top_nei_zhong_t">
                     <h6><?php echo $v['brief_statement']?></h6> 
                     <em>狂欢价：<samp>M <?php echo $v['vip_price']?></samp></em>
                    <p class="zhong_t2"> <a href="<?php echo $v['link_path']?>">加入购物车></a></p>
                  </div>
              </li>
              <?php endforeach;?>
          </ul>
          <?php endif;?>
        </div>
        
        <div class="media_top_nei_zhong2">
          <h5 style="position:relative"> <img src="<?php echo isset($list['title-img-two']['0']['img_path']) ? IMAGE_URL.$list['title-img-two']['0']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px" /></h5>
              <?php if(isset($list['menu-product'])):?>
                <ul>
                    <?php foreach ($list['menu-product'] as $v):?>
                        <li>
                          <span><a href="<?php echo $v['link_path']?>"><img src="<?php echo isset($v['img_path']) ? IMAGE_URL.$v['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                          <p class="zhong_t1"><?php echo $v['desc']?></p>
                          <div class="media_top_nei_zhong_t2">
                             <h6><?php echo $v['brief_statement']?></h6> 
                             <em>狂欢价：<samp>M <?php echo $v['vip_price']?></samp></em>
                            <p class="zhong_t2"><a href="<?php echo $v['link_path']?>">加入购物车></a></p>
                          </div>
                        </li>
                    <?php endforeach;?>
                </ul>
             <?php endif;?>
        </div>
        
        <div class="media_top_nei_zhong1">
          <h5 style="position:relative" > <img src="<?php echo isset($list['title-img-three']['0']['img_path']) ? IMAGE_URL.$list['title-img-three']['0']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px" /></h5>
              <?php if(isset($list['end-product'])):?>      
                <ul>
                    <?php foreach ($list['end-product'] as $v):?>
                    <li>
                      <span><a href="<?php echo $v['link_path']?>"><img src="<?php echo isset($v['img_path']) ? IMAGE_URL.$v['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                      <p class="zhong_t1"><?php echo $v['desc']?></p>
                      <div class="media_top_nei_zhong_t1">
                         <h6><?php echo $v['brief_statement']?></h6> 
                         <em>狂欢价：<samp>M <?php echo $v['vip_price']?></samp></em>
                        <p class="zhong_t2"> <a href="<?php echo $v['link_path']?>">加入购物车></a></p>
                      </div>
                    </li>
                    <?php endforeach;?>
                </ul>
              <?php endif;?>
        </div>
        
      </div>
      </div>
      <div style="position:relative; height:1550px;">
        <div id="background-img-three" style="position: absolute;top: 0px;">
          <img src="<?php echo isset($list['background-img-three']['0']['img_path']) ? IMAGE_URL.$list['background-img-three']['0']['img_path']: '';?>"width='1920' height='1550'alt=""/> 
      </div>
       <div class="media_bottom"  style="height:auto; position:absolute; margin-left:-600px; left:50%;">
         <div class="lib_Tab">
          <div class="lib_Tab_top">
            <h5>所有商品</h5>
            
          </div>
         </div>  
         <div class="lib_Contentbox"> 
           <div class="lib_Contentbox_to">
          <dl id="guanjie_media_goods" >
            <dd>
              <div class="lib_Contentbox_nei">
                <span><a href="#"><img src="images/culture/culture_top14.jpg"></a></span>
                <h5><samp>省政府前</samp><samp class="samp_1"></samp><samp>新城广场青少年宫LED</samp></h5>
                <p>¥5000.00</p>
                 <ul>
                   <li>
                    <a class="nei_top"href="#">购买</a>
                   </li>
                    <li>
                    <a class="nei_top1"href="#">关注</a>
                   </li>
                 </ul>
              </div>
            </dd>
           
          </dl>
 </div>
 </div>
   <div class="media_showpage"></div>
       </div>
       </div>
  </div>      
    </div>
  
 
    </div>
<!--导航 结束-->

</body>
</html>

<!--添加导航 后加载-->
<!----banner图片轮播------>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".painting_banner1 .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});



</script>

<script type="text/javascript">
    function getRTime(){
        var time = "<?php echo isset($list['time-one']['0']['desc']) ? str_replace('-','/',$list['time-one']['0']['desc']): '';?>"
        var EndTime= new Date(time);
        var NowTime = new Date();
        var t =EndTime.getTime() - NowTime.getTime();
    

        var d=Math.floor(t/1000/60/60/24);
        var h=Math.floor(t/1000/60/60%24);
        var m=Math.floor(t/1000/60%60);
        var s=Math.floor(t/1000%60);

        document.getElementById("days1").innerHTML = d + "";
        document.getElementById("hours1").innerHTML = h + "";
        document.getElementById("mins1").innerHTML = m + "";
        document.getElementById("secs1").innerHTML = s + "";
    }
    setInterval(getRTime,1000);
	
	
	
	function getRTime1(){
		var time1 = "<?php echo isset($list['time-two']['0']['desc']) ? str_replace('-','/',$list['time-two']['0']['desc']): '';?>"
        var EndTime= new Date(time1);
        var NowTime = new Date();
        var t =EndTime.getTime() - NowTime.getTime();
    

        var d=Math.floor(t/1000/60/60/24);
        var h=Math.floor(t/1000/60/60%24);
        var m=Math.floor(t/1000/60%60);
        var s=Math.floor(t/1000%60);

		document.getElementById("days2").innerHTML = d + "";
        document.getElementById("hours2").innerHTML = h + "";
        document.getElementById("mins2").innerHTML = m + "";
        document.getElementById("secs2").innerHTML = s + "";
    }
    setInterval(getRTime1,1000);
	
	
	
	function setTab(name,cursel,n){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?"hover":"";
  con.style.display=i==cursel?"block":"none";
 }
}

    $(function (){

    	
        var html = '';
        var classify = '';
        var top_classify= '';
        var page = '';
    	$.post('<?php echo site_url('flagship');?>',{corp:<?php echo $corp;?>},function(data){
    	    data = jQuery.parseJSON(data);
    	   
    	    //商品
    	    for(var i=0;i<data['produtList'].length;i++){
        	    
                    html += '<dd>';
        	   
        	    	html += '<div class="lib_Contentbox_nei">';
            	    
                    html += '<span><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'"><img src="<?php echo IMAGE_URL?>'+data['produtList'][i]['goods_thumb']+'"></a></span>';
                    html += '<h5><samp>'+data['produtList'][i]['name']+'</samp></h5>' ;
                    html += '<p>M '+data['produtList'][i]['vip_price']+'</p>';
                    html +='<ul>';

                    html +='<li>';
                    html +='<a class="nei_top"href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'">购买</a>';
                    html +='</li><li>';
//                     html +='<a class="nei_top1"href="#">关注</a></li>';
//                     html +='<li><a href="javascript:;">对比</a></li>';
                    html +=' </ul> </div>';
                    html +='</dd>';
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
    	        page +='<a id=page_'+i+' href="javascript:void(0);" class="cpage" onclick="pagination('+i+','+pageNum+',1);">'+i+'</a>&nbsp;';
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

        		//ajax 分页
		//status 0上一页1选择页2下一页
		function pagination(page,total,status,section){
			if(section == '') var section = '';
			$('#next').show();
	    	$('#previous').show();
			switch(status){
			case 0:
				$('#next').show();
				$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2,'+section+')');
				if(page==1){
					 $('#previous').hide();
					 break;
					}
				$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0,'+section+')');
				break;
			case 1:
		 		if(total==page){
					 $('#next').hide();
					 $('#previous').show();
					}else if(page==1){
						$('#previous').hide();
						$('#next').show();
						}
		 		$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0,'+section+')');
		 		$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2,'+section+')');
				break;
			case 2:
				$('#previous').show();
				$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0,'+section+')');
		 		if(total==page){
				 $('#next').hide();
				 break;
				}
				$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2,'+section+')');
				break;
			}

			var html = '';
			$.post('<?php echo site_url('flagship/pagination');?>',{page:page,corp:<?php echo $corp;?>,section:section},function(data){
			    data = jQuery.parseJSON(data);
			    
	    			    for(var i=0;i<data.length;i++){
	                	    
	    			    	 html += '<dd>';
	    		        	   
	    	        	    	html += '<div class="lib_Contentbox_nei">';
	    	            	    
	    	                    html += '<span><a href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'"><img src="<?php echo IMAGE_URL?>'+data[i]['goods_thumb']+'"></a></span>';
	    	                    html += '<h5><samp>'+data[i]['name']+'</samp></h5>' ;
	    	                    html += '<p>M '+data[i]['vip_price']+'</p>';
	    	                    html +='<ul>';

	    	                    html +='<li>';
	    	                    html +='<a class="nei_top"href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'">购买</a>';
	    	                    html +='</li><li>';
// 	    	                    html +='<a class="nei_top1"href="#">关注</a></li>';
//	    	                     html +='<li><a href="javascript:;">对比</a></li>';
	    	                    html +=' </ul> </div>';
	    	                    html +='</dd>';
	                            }
	    			    $('#guanjie_media_goods').html(html);
				});
			$('.cpage').css('background','');
			$('#page_'+page).css('background','#ccc');
			}

	    //分类
		function top_shop_classify(section_id,corporation_id,obj,page,total,status){
			
			location.hash = 'media_bottom';
			var html = '';
			$('.macth_liactive').removeClass('macth_liactive');
			$(obj).addClass('macth_liactive');
			$('.guanjie_top_conx_b1').hide();
			$('.media_top').hide();
			$('#page').hide();
			$('#bg_two').hide();
// 			$('#bg_three').hide();
			$.post("<?php echo site_url('flagship/top_shop_classify');?>",{section_id:section_id,corporation_id:corporation_id},function(data){
				data = jQuery.parseJSON(data);
				
	    	    //商品
	    	    if(data['produtList'].length>0){
	    	    	 for(var i=0;i<data['produtList'].length;i++){
	    	        	    
	                     html += '<dd>';
	         	   
	         	    	html += '<div class="lib_Contentbox_nei">';
	             	    
	                     html += '<span><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'"><img src="<?php echo IMAGE_URL?>'+data['produtList'][i]['goods_thumb']+'"></a></span>';
	                     html += '<h5><samp>'+data['produtList'][i]['name']+'</samp></h5>' ;
	                     html += '<p>M '+data['produtList'][i]['vip_price']+'</p>';
	                     html +='<ul>';

	                     html +='<li>';
	                     html +='<a class="nei_top" href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'">购买</a>';
	                     html +='</li><li>';
// 	                     html +='<a class="nei_top1" href="javascript:;" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
//	                      html +='<li><a href="javascript:;">对比</a></li>';
	                     html +=' </ul> </div>';
	                     html +='</dd>';
	         	    }
		         	    
	    	    	var page = '';
		          	if(data['produtList'].length>=20){ 
		          		 //分页显示
		          	    page += '<span id="page">';
		        	    page +='<span>共'+data['total']+'条纪录</span>&nbsp';
		        	    var pageNum = Math.ceil(data['total']/20);//页数
		        	    
		        	    if(pageNum !== 1){
		        	    page +='<a href="javascript:void(0);" class="lPage" id="previous" >上一页</a>&nbsp;';
		        	    }
		        	    for(var i=1;i<=pageNum;i++){
		        	        page +='<a id=page_'+i+' href="javascript:void(0);" class="cpage" onclick="pagination('+i+','+pageNum+',1,'+section_id+');">'+i+'</a>&nbsp;';
		        	    }
		        	    if(pageNum !== 1){
		               	page +='<a href="javascript:void(0);" class="lPage" id="next" onclick="pagination(2,'+pageNum+',2,'+section_id+');">下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		        	    }
		               	page += '</span>';
		               	
		                $('.media_showpage').html(page);   
			        }
	        	    $('#guanjie_media_goods').html(html);
	        	    }else{
	            	    
	            	    html +='<li class="result_none" style=" width: 1180px;padding-bottom: 20px;background:none;">暂无商品</li>';
	        	    	$('#guanjie_media_goods').html(html);
	            	    }
				});
			}

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
    </script>