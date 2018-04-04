<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->




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


<?php $this->load->view('navigation_bar');?>

    <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top"><p>背书单位简介</p></div>
           <div class="introduction_con">
            <h4><?php echo $detail['recommend_company'];?></h4>
            <div class="introduction_connei">
              <div class="introduction_connei_l">
               <p><?php echo $detail['company_brief'];?></p>
              </div>
              <div class="introduction_connei_r"><img src="<?php echo $detail['logo']?IMAGE_URL.$detail['logo']:"images/store_newarrival01.png";?>"/></div>
            </div>
           </div>
       </div>
    </div>



    <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top"><p>背书人简介</p></div>
            <div class="introduction_con">
              <div class="endorser">
              <span class="qis"><img src="<?php echo $detail['certificate']?IMAGE_URL.$detail['certificate']:"images/store_newarrival01.png";?>"/></span>
              <div class="endorser_right">
                 <div class="endorser_right_top">
                  <div class="endorser_right_top1"><strong><?php echo $detail['recommend_name'];?></strong><samp></samp></div>
                  <div class="endorser_right_top2">
                  <?php foreach ($honor as $v):?>
                   <span><?php echo $v;?></span>
                  <?php endforeach;?>
                  </div>
                  <div class="endorser_right_top2">
                   <p><?php echo $detail['recommend_content']?></p>
                  </div>
                 </div>

              </div>
              </div>
            </div>
       </div>
    </div>

    <div class="endorsement clearfix">
       <div class="introduction">
          <div class="introduction_top"><p>背书语</p></div>
            <div class="introduction_con">
                  <h4>推荐语</h4>
                  <ul>
                  <?php foreach ($recommend_language as $v):?>
                   <li><span></span><a href="javascript:void(0);"><?php echo $v;?></a></li>
                   <?php endforeach;?>
                  </ul>
                   <div class="introduction_connei_r1"><img src="<?php echo $detail['recommend_img']?IMAGE_URL.$detail['recommend_img']:"images/store_newarrival01.png";?>"/></div>
            </div>
       </div>
    </div>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>
