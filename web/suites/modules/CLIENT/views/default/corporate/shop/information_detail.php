<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->





<script>
//顶部菜单
//站点菜单
    (function($){
        $(document).ready(function(){
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script>




<style>
/*.eh_navbar .macth_xv_categorys .macth_xv_cat_catlist{display:block;}
    .macth_xv_navlist .macth_xv_menu{padding-left: 180px;}
    .macth_xv_categorys{display: block}
    .macth_xv_categorys .macth_xv_cat_catlist{display: block;min-height: 435px;}*/
</style>


<?php $this->load->view('navigation_bar');?>

    <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top1"><p>公司简介</p></div>
           <div class="introduction_con">
            <div class="introduction_connei">
              <div class="introduction_connei_l1">
               <p><?php foreach ($image as $v){if($v['type']=='description'){echo htmlentities($v['description']);}}?></p>
              </div>
              <div class="introduction_connei_r2"><img src="<?php foreach ($image as $v){if($v['type']=='picture'){echo $v['image_name'];}}?>"/></div>
            </div>
           </div>
       </div>
    </div>
    <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top1"><p>企业实力展示</p></div>
           <div class="gong_enterprise">
             <ul>
               <?php foreach ($image as $v){?>
               <?php if($v['type']=='ce'){?>
               <li><img src="<?php echo $v['image_name'];?>"/></li>
               <?php };?>
<!--                <li><img src="images/gongshi.jpg"/></li> -->
<!--                <li><img src="images/gongshi.jpg"/></li> -->
<!--                <li><img src="images/gongshi.jpg"/></li> -->
               <?php };?>
             </ul>
           </div>
       </div>
    </div>
     <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top1"><p>领导关怀</p></div>
           <div class="gong_enterprise1">  
           <img class="mr_freft prev" src="images/mfrL3.jpg" width="12" height="23">
           <img class="mr_frert next" src="images/mfrR3.jpg" width="12" height="23">
          <div class="tempWrap">
          <div class="gong_enterprise2">
             <ul>
                <?php foreach ($image as $v){?>
                <?php if($v['type']=='solicitude'){?>
               <li><img src="<?php echo $v['image_name'];?>"/><span><?php echo htmlentities($v['title']);?></span></li>
               <?php };?>
<!--                <li><img src="images/gongshi.jpg"/><span>公司人力资源部组织开展了培训活动</span></li> -->
<!--                <li><img src="images/gongshi.jpg"/><span>公司北京展览演出</span></li> -->
<!--                <li><img src="images/gongshi.jpg"/><span>公司篮球友谊赛</span></li> -->
<!--                <li><img src="images/gongshi.jpg"/><span>交流学习促班建 凝聚合力谋发展</span></li> -->
<!--                <li><img src="images/gongshi.jpg"/><span>交流学习促班建 凝聚合力谋发展</span></li> -->
               <?php };?>
             </ul>
           </div>  
          </div> 
       </div>
       </div>
    </div>
    
    
    
    
    
 
<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript">
<!-------左右切换轮播---------->
$(".gong_enterprise1").slide({
	titCell:"",
	mainCell:".tempWrap ul",
	autoPage:true,
	effect:"leftLoop",
	autoPlay:true,
	vis:4
});
</script>