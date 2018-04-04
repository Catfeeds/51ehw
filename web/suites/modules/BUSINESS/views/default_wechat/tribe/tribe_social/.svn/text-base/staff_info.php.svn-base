<style type="text/css">
.my_activities_top li {border-bottom: 1px solid #d4d4d4;}
.activities_nei_li_top i img {border-radius: 5px;width: 100%;}
.activities_nei_li_xia h2 span {font-size: 12px;color: #999999;padding-left: 10px;margin-right: 0;}
.activities_nei_li_xia p span {display: block;overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis;color: #a0a0a0;font-size: 15px;}
.activities_nei_li_xia h2 {color: #333;}
.activities_nei_li_xia p {margin-top: 10px;}
.activities_nei_li {padding: 10px 10px 15px 10px;}
.tribe_shop_person {bottom: auto;margin-top: -45px;margin-bottom: 20px;}
.my_activities_top a {display: block;}
.activities_nei_li_top, .activities_nei_li_xia {height: auto;}
.tribe_shop_person img {border: 2px solid #fff;width: 84px!important;height: 84px!important;}
.clans_my_introduce {margin-bottom:0!important;}
.tribe_shop_head{ position:relative}
.shop_img_input{width:100%;height:100%;position:absolute;top:0;opacity:0;left:0;background: none;border: none;outline: none;resize: none;-webkit-tap-highlight-color:rgba(255,255,255,0);}
.tribe_shop_head img{object-fit: cover;z-index:2}
.sanjiaoxing{position: absolute;bottom: 0;left: 0;width: 100%;height: 0;float: left;border-bottom: 30px solid #fff;border-left: 179px solid transparent;border-right: 179px solid transparent;z-index: 0;}
.clans_my_introduce_text span {padding-left:0!important;}
.clans_my_introduce_text01 {text-align: center;}
.clans_my_introduce_text01 span {padding-left:0!important;}
.clans_my_introduce_top{font-size:15px;color:#333333; margin-top:15px;}
.clans_my_introduce_top i{ vertical-align:middle; font-size:20px; color:#999999; display:inline-block}
.clans_introduce_list_head {position: relative;}
.corporate_style {width: 20%!important;position: absolute;right: 15px;top: 0;font-size: 15px;color: #64a4bd;text-align: right;display: inline-block!important;}
.roundadd_add_icon {font-size: 15px;color: #2fb2d0;padding-right: 5px;}
</style>

<!-- 我的介绍 -->
<div class="clans_my_introduce">
    	<div class="tribe_shop_head clans_my_introduce_head">
        <input type="hidden" name='status' value="1">
        	<img id="bg_img" src="" alt="" onerror="this.src='images/tribe_bu_bg.png'">
        	<div class="sanjiaoxing"></div>
        	
    	</div>
	<div class="tribe_shop_person clans_my_introduce_person">
		<!-- 三角形 -->
		<img src="images/clans_bg.png" alt="" class="clans_ntroduce_sanjiao">
		<!-- 头像 -->
		<a href="javascript:void(0);">
			<img src="" alt="" onerror="this.src='images/member_defult.png'" style="margin-top: -120px;"> <span class="clans_name"><?php echo $staff_info['member_name']?></span> 
		</a>
		<?php if($staff_info["show_mobile"] != 2){?>
		<a href="tel:<?php echo $staff_info['mobile'];?>" ><div class="clans_my_introduce_top" style="color:#5a69e0;"><i class="icon-phone1" style="color:#5a69e0;"></i><?php echo $staff_info['mobile']?></div></a>
		<?php }else{;?>
		<div class="clans_my_introduce_top"><i class="icon-phone1"></i><?php echo $staff_info['mobile']?></div>
		<?php };?>
		
		
		
		 <?php 
		 if(count($album) > 0){ ?>
		       <!-- 相册 -->
        	    <div class="customer_info_photo">
        	    	<a href="<?php echo site_url("Tribe_social/staff_album").'/'.$staff_info['id'];?>">
        	    	 <ul>
        	    	     <li>
        	    	     <?php foreach ($album as $val){ ?>
        	    	     <?php if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){?>
        	    	     	   <img src="<?php echo 'http://www.test51ehw.com/uploads/B/'.$val['path'];?>">
        	    	     <?php }else{ ?>
        	    	           <img src="<?php echo  IMAGE_URL.$val['path'];?>">
        	    	     <?php } ?>
        	    	     <?php }?>
<!--         	    	       <img src="images/pintuan02.png"> -->
<!--         	    	       <img src="images/20141206092732_4208.jpg"> -->
<!--         	    	       <img src="images/20141206093912_0947.jpg"> -->
<!--         	    	       <img src="images/active_img.jpg"> -->
<!--         	    	       <img src="images/classify_goods04.png"> -->
<!--         	    	       <img src="images/pintuan02.png"> -->
<!--         	    	       <img src="images/pintuan02.png"> -->
<!--         	    	       <img src="images/pintuan02.png"> -->
        	    	     </li>
        	    	</ul>
        	    	</a>
        	    </div>	
		 <?php  }else{ //没上传过相片?>
		      <fieldset class="scheduler_border" onclick="jump();">
                <legend class="scheduler_border1" style="color: #dddddd;font-size: 13px;">对方暂无照片展示</legend>
              </fieldset>
		 <?php  
          }?>
	</div>
	
	<?php if(count($idenity_info) > 0){ ?>
 <!-- 社会身份 -->
	<div class="clans_introduce_list_head">
		<a href="javascript:;"> 
		<span>社会身份</span> </a>
	</div>
	<ul class="my_activities_top" id="identity_list">
	<?php foreach ( $idenity_info as $k=> $v ){?>
		<li ><a href="javascript:void(0);">
				<div class="activities_nei_li">
					<div class="activities_nei_li_top">
						<i class="clans_introduce_icon"><span class="<?php echo $v['type'] == 1 ? 'icon-building_' : ( $v['type'] == 2 ? 'icon-building_1' : 'icon-hammer')?>"></span></i>
						<div class="activities_nei_li_xia">
							<h2><?php echo $v['organization_name']?></h2>
							<p>
								<span><?php echo $v['organizationl_duties']?></span>
							</p>
						</div>
					</div>
				</div>
		</a></li>
		<?php }?>
	</ul>
	<?php }else{ ?>
	    <div class="clans_introduce_list_head" style="padding-top: 25px;">
    		 <fieldset class="scheduler_border" >
            	<legend class="scheduler_border1" style="color: #dddddd;font-size: 13px;">暂无身份信息</legend>
            </fieldset>
		</div>
	<?php }?>
	
	</div>


<div style="height:60px;"></div>



<script type="text/javascript">
function jump(){
	window.location.href="<?php echo site_url("Tribe_social/staff_album").'/'.$staff_info['id'];?>";
}
$('.corp_invite').on('click',function(){

    
    var ts_id = '<?php echo !empty($_GET['ts_id']) ? $_GET['ts_id'] : 0?>';
    
    if( !ts_id )
    { 
        return;
    }
        
    $('.clans_ball').show();
    var url = '<?php echo site_url('Tribe/Invite_View/Corp/'.$staff_info['tribe_id'])?>/'+ts_id;
    

    $('.clans_ball_box ul li').eq(0).children('a').attr('href',url);
    var status = getCookie(ts_id);
	   if(status){
		   $('.clans_ball_box ul li').eq(1).children('a').attr('href','javascript:caution();');
		   }else{
			   $('.clans_ball_box ul li').eq(1).children('a').attr('href',url+'/1');
			   }
  
})
  
$('.clans_ball').on('click',function(){ 
	   $('.clans_ball').hide()
})


function load_identity()
{
	$('#identity_list').children('li:gt(2)').show();
	$('#load_identity').remove();
}

function load_tribe()
{
	$('#tribe_list').children('li:gt(2)').show();
	$('#load_tribe').remove();
}


$(function () { 
	  var isPageHide = false; 
	  window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
	  }); 
	  window.addEventListener('pagehide', function () { 
	    isPageHide = true; 
	  }); 
})








</script>



