<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/pgwslider.js"></script><!--轮播图-->
<script type="text/javascript" src="js/jquery.easing.min.js"></script><!--供需走马灯效果-->
<script type="text/javascript" src="js/jquery.easy-ticker.min.js"></script><!--供需走马灯效果-->
<script type="text/javascript" src="js/jquery.nav.js"></script><!--楼层tab-->
<script type="text/javascript" src="js/jquery.SuperSlide.js"></script><!--楼层tab-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--轮播图-->
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
<script>
    $(function(){
        //头部搜索切换
        $('#search_hd .search_input').on('input propertychange',function(){
            var val = $(this).val();
            if(val.length > 0){
                $('#search_hd .pholder').hide(0);
            }else{
                var index = $('#search_bd li.selected').index();
                $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            }
        })
        $('#search_bd li').click(function(){
            var index = $(this).index();
            $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            $('#search_hd .search_input').eq(index).show().siblings('.search_input').hide(0);
            $(this).addClass('selected').siblings().removeClass('selected');
            $('#search_hd .search_input').val('');
        });
    })
</script>
<script type="text/javascript">
    //轮播图
$(document).ready(function(){
	$(document).ready(function() {
    	$('.pgwSlider').pgwSlider();

	});
});
</script>
<script type="text/javascript">
    //供需走马灯效果
$(document).ready(function(){

	var dd = $('.vticker').easyTicker({
		direction: 'up',
		easing: 'easeInOutBack',
		speed: 'slow',
		interval: 5000,
		height: 'auto',
		visible: 6,
		mousePause: 0,
		controls: {
			up: '.up',
			down: '.down',
			toggle: '.toggle',
			stopText: 'Stop !!!'
		}
	}).data('easyTicker');

});
</script>
<script>
    //楼层效果
$(function() {
	$('#nav').onePageNav({
		scrollThreshold: 0.1,
		filter: ':not(.eh_lou)'
	});

	$(window).scroll(function(){
		if($(window).scrollTop() > 800){
			$('#nav').fadeIn();
		} else {
			$('#nav').fadeOut();
		}
	});
});

</script>


<style>
/*.eh_navbar .macth_xv_categorys .macth_xv_cat_catlist{display:block;}*/
</style>

<?php $this->load->view('navigation_bar');?>

<div class="eh_banner clearfix">
    <ul class="pgwSlider">
    <?php foreach ($adList as $v):?>
        <li> <a href="" target="_blank"> <img src="<?php echo $v['img_url']?>"></a> </li>
    <?php endforeach;?>
<!--         <li> <a href="" target="_blank"> <img src="images/eh_b_02.jpg"></a> </li> -->
<!--         <li> <a href="" target="_blank"> <img src="images/eh_b_03.jpg"></a> </li> -->
<!--         <li> <a href="" target="_blank"> <img src="images/eh_b_04.jpg"></a> </li> -->
<!--         <li> <a href="" target="_blank"> <img src="images/eh_b_05.jpg"></a> </li> -->
    </ul>
</div>
<!--轮播结束 eh_banner end-- >
<div class="eh_sr_box clearfix">
   <div class="eh_supply_con">
        <div class="eh_supply">
           <h1>最新供货信息<span class="more"><a href="<?php echo site_url('supply')?>">更多</a></span></h1>
        </div>
        <div class="vticker line">
            <ul>
				<?php if($newarrival != null && count($newarrival)>0){
					     foreach($newarrival as $p){
					?>
                <li>
                <a target="_blank"><span class="brand" style="width:70;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $p["corp_name"]?></span></a>
                <a target="_blank"><span class="brand" style="width:70;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $p["cate_name"]?></span></a>
                <a href="<?php echo site_url('goods/detail/'.$p["id"])?>"><span class="title" style="width:250px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $p["name"]?></span></a>
                <span class="right" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $p["on_sale_at"]!=null?substr($p["on_sale_at"],0,10):"";?></span>
                </li>
				<?php }//endfor
					}//end if?>

            </ul>
       </div>
   </div>
    <div class="eh_req_con">
        <div class="eh_req">
           <h1>最新需求信息<span class="more"><a href="<?php echo site_url('requirement/more_require') ?>">更多</a></span>
           <?php if($this->session->userdata('corporation_id') > 0 && $this->session->userdata('corporation_status')==1):?>
           <span class="release"><a href="<?php echo site_url('requirement/pub_require') ?>">发布需求</a><b>|</b></span>
           <?php endif;?>
           </h1>
        </div>
        <div class="vticker mtd">
            <ul>
            <?php if(count($requires)>0): ?>
            <?php foreach ($requires as $re): ?>
             <li><a href="<?php echo site_url('requirement/more_require') ?>"><span class="brand"><?php echo $re['corporation_name'] ?></span></a><a href="<?php echo site_url('requirement/more_require') ?>"><span class="title"><?php echo $re['p_content'] ?></span></a><span class="right"><?php echo date('Y-m-d',strtotime($re['create_at'])) ?></span></li>
            <?php endforeach; ?>
            <?php else: ?>
             <li><a href="javascript:;"><span class="brand"></span></a><a href=""><span class="title">暂无需求</span></a><span class="right"></span></li>
            <?php endif; ?>
            </ul>
        </div>
   </div>
 </div>  <!--供需 eh_sr_box end-->

<!-- -------begin preview-------- -->
<?php
    if(count($data)>0){
        echo "<ul id='nav'>";
        for($i=1;$i<=count($data);$i++){
            echo "<li><a class='f".$i."' href='#f".$i."'>".$i."F</a></li>";
        }
        echo "<li><a class='eh_lou' href='#top'>顶</a></li>";
        echo "</ul>";
    }
?>

<div class="eh_floor">
<base href="<?php echo THEMEURL; ?>" />
	<?php if (!empty($data)){?>
		<?php foreach ($data as $key=>$val){?>
			<?php $f=$key+1;?>
			<div id="f<?php echo $f;?>">
				<div class="eh_floor_box<?php if($f>1){echo $f;}?> eh_floor_con clearfix">
					<div class="title"><h1>F<?php echo $f;?><i>•</i></h1><span><?php echo $val['level_name'];?></span></div>
					
						<!-- tag -->
						<ul class="tab_menu">
    					<?php foreach ($val['M'] as $m_k=>$m){?>
    							<?php if (array_keys($val['M'])[0]==$m_k){?>
    								<li class="current"><?php echo isset($m['category_name'])?$m['category_name']:"";?></li>
    							<?php }?>
    					<?php }?>
						<?php if($val['level_morelink'] != null && $val['level_morelink'] != ""){?>
    								<li><a href="<?php echo $val['level_morelink'];?>" style="color:#fea23b">更多</a></li>
    					<?php }?>
						</ul>
						
						<!-- tag_box -->
						<div class="tab_box">
						<?php foreach ($val['M'] as $m_k=>$m){?>
							<div <?php if (array_keys($val['M'])[0]!=$m_k){echo "class='hide'";}?>>
								<?php 
								    switch (intval($val['level_temp'])){
								        
								        case 1:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".(isset($m[0]['link_path'])?$m[0]['link_path']:"")." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original='".(isset($m[0]['img_path'])?IMAGE_URL.$m[0]['img_path']:"")."'></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".(isset($m[1]['link_path'])?$m[1]['link_path']:"")." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".(isset($m[1]['img_path'])?IMAGE_URL.$m[1]['img_path']:"")."></a>";
								            echo "<a target='_blank' href=".(isset($m[2]['link_path'])?$m[2]['link_path']:"")." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".(isset($m[2]['img_path'])?IMAGE_URL.$m[2]['img_path']:"")."></a>";
								            echo "<a target='_blank' href=".(isset($m[3]['link_path'])?$m[3]['link_path']:"")." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".(isset($m[3]['img_path'])?IMAGE_URL.$m[3]['img_path']:"")."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w480'>";
								            echo "<a target='_blank' href=".(isset($m[4]['link_path'])?$m[4]['link_path']:"")." title='' class='eh_item w479'><img width='479' height='401' alt='' original=".(isset($m[4]['img_path'])?IMAGE_URL.$m[4]['img_path']:"")."></a>";
								            echo "</div>";
								        }break;
    								        
								        case 2:{
								            echo "<div class='eh_floor_left w481'>";
								            echo "<a target='_blank' href=".(isset($m[0]['link_path'])?$m[0]['link_path']:"")." title='' class='eh_item lb w479'><img width='479' height='401' alt='' original=".(isset($m[0]['img_path'])?IMAGE_URL.$m[0]['img_path']:"")."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".(isset($m[1]['link_path'])?$m[1]['link_path']:"")." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".(isset($m[1]['img_path'])?IMAGE_URL.$m[1]['img_path']:"")."></a>";
								            echo "<a target='_blank' href=".(isset($m[2]['link_path'])?$m[2]['link_path']:"")." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".(isset($m[2]['img_path'])?IMAGE_URL.$m[2]['img_path']:"")."></a>";
								            echo "<a target='_blank' href=".(isset($m[3]['link_path'])?$m[3]['link_path']:"")." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".(isset($m[3]['img_path'])?IMAGE_URL.$m[3]['img_path']:"")."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w239'>";
								            echo "<a target='_blank' href=".(isset($m[4]['link_path'])?$m[4]['link_path']:"")." title='' class='eh_item w238'><img width='238' height='401' alt='' original=".(isset($m[4]['img_path'])?IMAGE_URL.$m[4]['img_path']:"")."></a>";
								            echo "</div>";
								        }break;
    								        
								        case 3:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w479'><img width='479' height='401' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w480'>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 4:{
								            echo "<div class='eh_floor_left w481'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w239'><img width='239' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w239'><img width='239' height='401' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w239'>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 5:{
								            echo "<div class='eh_floor_left w241'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w239'><img width='239' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w720'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w239'>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 6:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w480'>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[6]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[6]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 7:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w480'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w480'>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[6]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[6]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 8:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w240'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w720'>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[6]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[6]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 9:{
								            echo "<div class='eh_floor_left w240'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w238'><img width='238' height='401' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w720'>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w479'><img width='479' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w240'>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[6]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[6]['img_path']."></a>";
								            echo "</div>";
								        }break;
								        
								        case 10:{
								            echo "<div class='eh_floor_left w241'>";
								            echo "<a target='_blank' href=".$m[0]['link_path']." title='' class='eh_item lb w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[0]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[1]['link_path']." title='' class='eh_item lb w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[1]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_center w720'>";
								            echo "<a target='_blank' href=".$m[2]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[2]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[3]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[3]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[4]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[4]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[5]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[5]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[6]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[6]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[7]['link_path']." title='' class='eh_item w239'><img width='239' height='200' alt='' original=".IMAGE_URL.$m[7]['img_path']."></a>";
								            echo "</div>";
								            
								            echo "<div class='eh_floor_right w239'>";
								            echo "<a target='_blank' href=".$m[8]['link_path']." title='' class='eh_item w238'><img width='238' height='200' alt='' original=".IMAGE_URL.$m[8]['img_path']."></a>";
								            echo "<a target='_blank' href=".$m[9]['link_path']." title='' class='eh_item w238'><img width='238' height='200' alt='' original=".IMAGE_URL.$m[9]['img_path']."></a>";
								            echo "</div>";
								        }break;
								    }
								?>	
							</div>
						<?php }?>
						</div>
					
				</div>
			</div>
			
		<?php }?>
	<?php }?>

	<!---------end preview---------->

 <script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript" src="js/jquery.tabs.js"></script>
<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<script type="text/javascript">
//版块tabs
$(function(){
	//$("img[original]").lazyload({placeholder:"images/eh_logo.jpg" });
    $("img[original]").lazyload({effect: "fadeIn"});
	$('.eh_floor_box').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box2').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box3').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box4').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box5').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box6').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box7').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box8').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box9').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
    $('.eh_floor_box10').Tabs({
		event:'click',
		callback:lazyloadForPart
	});
	//部分区域图片延迟加载
	function lazyloadForPart(container) {
		container.find('img').each(function () {
			var original = $(this).attr("original");
			if (original) {
				$(this).attr('src', original).removeAttr('original');
			}
		});
	}
});
</script>

