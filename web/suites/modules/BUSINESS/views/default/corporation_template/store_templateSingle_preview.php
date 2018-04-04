
<link href="css/store.css" rel="stylesheet" type="text/css">
 <!--<link rel="stylesheet" href="css/jquery.fullPage.css">-->
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>
<!--<script src="js/jquery.fullPage.min.js"></script>-->
<script>
$(document).ready(function() {
	$.fn.fullpage({
		slidesColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
		anchors: ['page1', 'page2', 'page3', 'page4', 'page5'],
		navigation: true
	});
});
</script>
<style>
.section { text-align: center; font: 50px "Microsoft Yahei"; color: #fff;}
.sectionPic02{height:100px;}
.sectionPic01,.sectionPic02{ width:100%; margin:0 auto;}
.store_top_con{height:100px; position:absolute; left:50%; margin-left:-960px; overflow:hidden;} 
</style>

    
   
    
    <!--单品内容 开始-->

    <div class="sectionPic02 hover_it" style="position:relative;">
        <div class="store_top_con">
			 <a href="<?php echo isset($banner_url)?$banner_url:""?>"><img src="<?php echo isset($banner_img)? IMAGE_URL.$banner_img:'images/store_topBanner.png'?>" width="" height="100" alt=""/></a> 
        </div>
	 </div>
	<!--头部导航条 结束-->
  
</div>

	
	<?php foreach($levelList as $level){?>
	<div class="section">
		<div class="sectionPic01 hover_it" style="position:relative;">
	    	<a href="<?php echo $level["link_path"]?>"><img src="<?php echo isset($level["img_path"])&& $level["img_path"] !=""?IMAGE_URL.$level['img_path']:'images/storeSingle_pic01.png'?>" width="1200" alt=""/></a>
	    </div>
	</div>
	<?php }?>
   
    <!--单品内容 结束-->
    
    <!--页尾banner 开始-->
    <!--<div class="store_endBanner storeLess_endBanner">
    	<div class="store_endBanner_con"><a href=""><img src="images/storeSingle_endBanner.png" width="1200" height="250" alt=""/></a></div>
    </div>-->
    <!--页尾banner 结束-->
    

