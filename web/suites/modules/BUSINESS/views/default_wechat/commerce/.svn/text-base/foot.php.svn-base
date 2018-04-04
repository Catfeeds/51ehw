<style type="text/css">
    .commerce_footer_nav ul li a em {color: black;font-size: 25px;display: inline-block;margin-top: 2px;}


</style>

<!-- 底部导航 -->
<div class="commerce_footer_nav">
	<ul>
		<li id = "foot_1">
    		<a href="<?php echo site_url('Commerce/index/'.$label_id)?>">
        		<!-- <img src="<?php //echo !empty($choose_foot) && $choose_foot == 1  ? 'images/commerce/index_02.png' : 'images/commerce/index_01.png'?>"> -->
                <em <?php echo  !empty( $choose_foot) && $choose_foot == 1  ? 'class="commerce_footer_active icon-shouyehui"' : 'class="icon-shouyehui"'?>  style="font-size: 24px;"></em>
        		<span <?php echo  !empty( $choose_foot) && $choose_foot == 1  ? 'class="commerce_footer_active"' : ''?>>首页</span>
    		</a>
		</li>
		
		<li id = "foot_2">
    		<a href="<?php echo site_url('Member/Message/MessageCenter/'.$label_id)?>">
        		<!-- <img src="<?php //echo  !empty( $choose_foot ) && $choose_foot == 2  ? 'images/commerce/xiaoxi_02.png' : 'images/commerce/xiaoxi_01.png'?>"> -->
                <em <?php echo  !empty( $choose_foot) && $choose_foot == 2  ? 'class="commerce_footer_active icon-xiaoxi"' : 'class="icon-xiaoxi"'?>></em>
        		<span <?php echo  !empty( $choose_foot) && $choose_foot == 2  ? 'class="commerce_footer_active"' : ''?>>消息</span>
    		</a>
    		</li>
    	<?php if($label_id!= 2){?>
    	    <li id = "foot_3">
        		<a href="javascript:void(0);" class="fabu_but">
        			<!-- <img src="<?php //echo  !empty( $choose_foot ) && $choose_foot == 3  ? 'images/commerce/fabu_02.png' : 'images/commerce/fabu_01.png'?>"> -->
                    <em <?php echo  !empty( $choose_foot) && $choose_foot == 3  ? 'class="commerce_footer_active icon-fabuok"' : 'class="icon-fabuok"'?>></em>
            		<span <?php echo  !empty( $choose_foot) && $choose_foot == 3  ? 'class="commerce_footer_active"' : ''?>>发布</span>
        		</a>
			</li>
    	    
    	<?php }else{ ?>
    	     <li id = "foot_3">
                <a href="javascript:void(0);" class="fabu_but">
                    <!-- <img src="<?php //echo  !empty( $choose_foot ) && $choose_foot == 3  ? 'images/commerce/fabu_02.png' : 'images/commerce/fabu_01.png'?>"> -->
                    <em <?php echo  !empty( $choose_foot) && $choose_foot == 3  ? 'class="commerce_footer_active icon-faxian"' : 'class="icon-faxian"'?>></em>
                    <span <?php echo  !empty( $choose_foot) && $choose_foot == 3  ? 'class="commerce_footer_active"' : ''?>>发现</span>
                </a>
        	</li>
    	<?php }?>	
		

       
		
		<li id = "foot_4">
    		<a href="<?php echo site_url('commerce/People/'.$label_id)?>">
        		<!-- <img src="<?php //echo  !empty( $choose_foot ) && $choose_foot == 4  ? 'images/commerce/renmai_02.png' : 'images/commerce/renmai_01.png'?> "> -->
                <em <?php echo  !empty( $choose_foot) && $choose_foot == 4  ? 'class="commerce_footer_active icon-renmai"' : 'class="icon-renmai_"'?> style="padding-left: 3px;"></em>
        		<span <?php echo  !empty( $choose_foot) && $choose_foot == 4  ? 'class="commerce_footer_active"' : ''?>>人脉</span>
    		</a>
		</li>
		
		<li id = "foot_5">
    		<a href="<?php echo site_url('commerce/Customer_Info/'.$label_id)?>">
        		<!-- <img src="<?php //echo  !empty( $choose_foot ) && $choose_foot == 5  ? 'images/commerce/my_02.png' : 'images/commerce/my_01.png'?>"> -->
                <em <?php echo  !empty( $choose_foot) && $choose_foot == 5  ? 'class="commerce_footer_active icon-wode"' : 'class="icon-wode-"'?>></em>
        		<span <?php echo  !empty( $choose_foot) && $choose_foot == 5  ? 'class="commerce_footer_active"' : ''?>>我的</span>
    		</a>
		</li>
	</ul>
</div>



<div class="commerce_publish">
    <ul>
       <?php if( !empty( $is_host) ){?>
        <li><a href="<?php echo site_url('Commerce/Choose_Commerce/'.$label_id.'/3')?>" class="commerce_publish_active"><img src="images/commerce/activity.png"><i>发活动</i></a></li>
        <li class="height_80"><a href="<?php echo site_url('Commerce/Choose_Commerce/'.$label_id.'/2')?>" class="commerce_publish_opportunity"><img src="images/commerce/new.png"><i>发公告</i></a></li>
        <?php }?>
        <li class="height_80"><a href="<?php echo site_url('Commerce/Choose_Commerce/'.$label_id)?>" class="commerce_publish_dynamic"><img src="images/commerce/dynamic.png"><i>发动态</i></a></li>
        <li><a href="javascript:void(0);" class="commerce_publish_colse icon-guanbi1"></a></li>
    </ul>
</div>




<script type="text/javascript">

<?php 
$labe_foot_nav_color = $this->session->userdata("labe_foot_nav_color");
if($labe_foot_nav_color){?>
		    $(".commerce_footer_nav").css("background","<?php echo $labe_foot_nav_color;?>");
<?php  }?>



<?php if(!empty($choose_foot)){ ?>
var foot = <?php echo $choose_foot;?>;
$('.fabu_but').on('click',function(){
	<?php if($label_id == 2){ ?>
    	$('.fabu_but').children("em").addClass("commerce_footer_active");
        $('.fabu_but').children("span").addClass("commerce_footer_active");
		if($(this).parent("li").attr("id") == 'foot_3'){
			 window.location.href = "<?php echo site_url("Commerce/Seek/$label_id");?>";
		}
		return false;	
	<?php }?>
	    $('.commerce_publish').show();
	    // $(this).children("img").attr("src","images/commerce/fabu_02.png");
	    $('.fabu_but').children("em").addClass("commerce_footer_active");
	    $('.fabu_but').children("span").addClass("commerce_footer_active");
	
    switch (foot){
    case 1:
    	// $("#foot_1 a").children("img").attr("src","images/commerce/index_01.png");
        $("#foot_1 a").children("em").removeClass("commerce_footer_active");
    	$("#foot_1 a").children("span").removeClass("commerce_footer_active");
        break;
    case 2:
    	// $("#foot_2 a").children("img").attr("src","images/commerce/xiaoxi_01.png");
        $("#foot_2 a").children("em").removeClass("commerce_footer_active");
    	$("#foot_2 a").children("span").removeClass("commerce_footer_active");
        break;
    case 4:
        // $("#foot_4 a").children("img").attr("src","images/commerce/renmai_01.png");
        $("#foot_4 a").children("em").removeClass("commerce_footer_active");
    	$("#foot_4 a").children("span").removeClass("commerce_footer_active");
        break;
    case 5:
    	// $("#foot_5 a").children("img").attr("src","images/commerce/my_01.png");
        $("#foot_5 a").children("em").removeClass("commerce_footer_active");
    	$("#foot_5 a").children("span").removeClass("commerce_footer_active");
        break;
    }
})
<?php }?>
   
    $('.commerce_publish_colse').on('click',function(){
        $('.commerce_publish').hide();
        // $('.fabu_but').children("img").attr("src","images/commerce/fabu_01.png");
        $('.fabu_but').children("em").removeClass("commerce_footer_active");
        $('.fabu_but').children("span").removeClass("commerce_footer_active");
        switch (foot){
        case 1:
        	// $("#foot_1 a").children("img").attr("src","images/commerce/index_02.png");
            $("#foot_1 a").children("em").addClass("commerce_footer_active");
        	$("#foot_1 a").children("span").addClass("commerce_footer_active");
            break;
        case 2:
        	// $("#foot_2 a").children("img").attr("src","images/commerce/xiaoxi_02.png");
            $("#foot_2 a").children("em").addClass("commerce_footer_active");
        	$("#foot_2 a").children("span").addClass("commerce_footer_active");
            break;
        case 4:
        	// $("#foot_4 a").children("img").attr("src","images/commerce/renmai_02.png");
            $("#foot_4 a").children("em").addClass("commerce_footer_active");
        	$("#foot_4 a").children("span").addClass("commerce_footer_active");
            break;
        case 5:
        	// $("#foot_5 a").children("img").attr("src","images/commerce/my_02.png");
            $("#foot_5 a").children("em").addClass("commerce_footer_active");
        	$("#foot_5 a").children("span").addClass("commerce_footer_active");
            break;
        }
    })
</script>
