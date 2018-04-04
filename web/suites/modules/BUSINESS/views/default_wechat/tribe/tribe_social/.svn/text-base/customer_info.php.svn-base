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
.a_color{color:#00F;}
.customer_info_duihua:after {  
  content: '';
  position: absolute;
  width: 1px;
  height: 20px;
  background: #9B9B9B;
  right: 0;
  top: 15px;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>个人简介</span>
</div>
<?php }?>
<!-- 我的介绍 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="clans_my_introduce">

	<form action="<?php echo site_url('Circles/Update_Background');?> "method="post" enctype="multipart/form-data" id="form1">
	
    	<div class="tribe_shop_head clans_my_introduce_head">
    	<?php if( $customer_info['id'] == $this->session->userdata('user_id') ){ ?>
        	<input type="file" class="shop_img_input" name="file" onchange="background_img()" accept="image/*"> 
        <?php }?>
        <input type="hidden" name='status' value="1">
     
        	<img id="bg_img" src="<?php echo IMAGE_URL.$customer_info['bg_img']?>" alt="" onerror="this.src='images/bg_tribe_01.png'">

        	<div class="sanjiaoxing"></div>
        	
    	</div>
    	
	</form>

	<div class="tribe_shop_person clans_my_introduce_person">
		<!-- 三角形 -->
		<img src="images/clans_bg.png" alt="" class="clans_ntroduce_sanjiao">
		<!-- 头像 -->
		<?php 
		  $logo_avatar = $customer_info['brief_avatar'] ?  IMAGE_URL.$customer_info['brief_avatar'] : $customer_info['wechat_avatar'];
		  if(!$logo_avatar){//测试两个
		      $logo_avatar = "javascript:void(0);";
		  }
		?>
		<a href="<?php echo $logo_avatar?>">
			<img src="<?php echo $customer_info['brief_avatar'] ? IMAGE_URL.$customer_info['brief_avatar'] :$customer_info['wechat_avatar']?>" alt="" onerror="this.src='images/member_defult.png'" style="margin-top: -120px;">
		
			 <span class="clans_name"><?php echo $customer_info['customer_name']?></span> 
		</a>
		<?php if( $customer_info['id'] ==  $this->session->userdata('user_id') ){?>
			<a href="<?php echo site_url('Tribe_social/Edit_Info').'?tribe_id='.$customer_info['tribe_id'];?>" class="clans_edit_icon"><span class="icon-edit1"></span></a>
		<?php }?>
		<!-- <?php echo $customer_info["show_mobile"];?>
		<?php echo $customer_info["id"];?>
		<?php echo $customer_info["tribe_id"];?>
 -->
		<?php if($customer_info["show_mobile"] != 2 ){?>
				<a id="tel" class='tel_' href="tel:<?php echo $customer_info['mobile'];?>">
					<div class="clans_my_introduce_top" style="color:#5a69e0;">

						<i class="icon-phone1" style="color:#5a69e0;">
						
						</i>
						<span class="show_mobile_type" style="color:#00F"><?php echo $customer_info['mobile'];?></span>
						<span>

							<?php if( $customer_info['id'] ==  $this->session->userdata('user_id') ){?>
							<a href="javascript:;" item="2"  onclick="show_mobile(this)" style="font-size: 14px;">隐藏</a>
							<?php }?>
						</span>
					</div>
				</a> 
        <?php }else{?>
	   		<a id="tel" class='tel_' href="javascript:;">
	        <div class="clans_my_introduce_top" >
	        	<i class="icon-phone1"></i>
	        	<span class="show_mobile_type"><?php echo substr_replace($customer_info['mobile'],'****',3,4);?></span>

	        	<?php if( $customer_info['id'] ==  $this->session->userdata('user_id') ){?>
	        	<span><a href="javascript:;" item="1"  onclick="show_mobile(this)" style="font-size: 14px;">显示</a></span>
	        	<?php }?>
	        </div> 
	    	        <?php };?>
		<div class="clans_my_introduce_text">
			<span><?php echo trim($customer_info['merit'],'/')?></span>
		</div>
		<div class="clans_my_introduce_text01">
			<span><?php echo $customer_info['brief']?></span>
		</div>
		</a>
		 <?php 
		 if(count($album) > 0){ ?>
		       <!-- 相册 -->
        	    <div class="customer_info_photo">
        	    	<a href="<?php echo site_url("Tribe_social/Customer_Album").'/'.$customer_info['id'].'/'.$tribe_id;?>">
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
		 <?php  }else{ //没上传过相片
		 if( $customer_info['id'] ==  $this->session->userdata('user_id') ){ ?>
		     <a href="<?php echo site_url("Tribe_social/Customer_Album").'/'.$customer_info['id'].'/'.$tribe_id;?>"><em class="icon-roundadd roundadd_add_icon"></em><span style='color:#2fb2d0;'>马上添加图片</span> </a>
         <?php  }else{?>
		      <fieldset class="scheduler_border" onclick="jump();">
                <legend class="scheduler_border1" style="color: #dddddd;font-size: 13px;">对方暂无照片展示</legend>
              </fieldset>
		 <?php   }
          }?>
		 
	  
	</div>
  
 <?php if( false ){ //$tribe_list?> 
 
  <!-- 部落身份 -->
	<div class="clans_introduce_list_head">
		<a href="javascript:void(0);"> <span>部落身份</span> 
		</a>
	</div>
	
	<div>
		<ul class="my_activities_top" id="tribe_list">
		<?php foreach ( $tribe_list as $k=>$v ){?>
			<li <?php echo $k> 2 ? 'hidden': ''?>><a href="javascript:;">
					<div class="activities_nei_li">
						<div class="activities_nei_li_top">
							<i><img src="<?php echo IMAGE_URL.$v["logo"];?>"
								onerror="this.src='images/tmp_logo.jpg'"></i>
							<div class="activities_nei_li_xia">
								<h2><?php echo $v['name']?></h2>
								<p>
									<span><?php echo $v['role_name']?></span>
								</p>
							</div>
							<!-- <div class="tribe_add_apply_status"><span class='icon-get_into'></span></div> -->
						</div>

					</div>
			</a></li>
			<?php }?>
			<?php if( count($tribe_list) > 3){?>
			<div class="clans_my_introduce_more" id="load_tribe">
				<span onclick="load_tribe()">点击加载全部</span>
			</div>
			<?php }?>
		</ul>
	</div>
<?php }?>


 <!-- 社会身份 -->
 	<?php if( $customer_info['id'] == $this->session->userdata('user_id') ){ ?>
    	<div class="clans_introduce_list_head">
    		<a href="<?php  echo site_url('Tribe_social/Identity') ?>" style="width: 75%;"> 
    		<span>社会身份</span> <span>添加</span> </a>
    		<!-- 企业风采 -->
    		<a href="<?php echo site_url("Corporation_style/User_Topic").'/'.$customer_info['id'];?>" class="corporate_style">企业风采</a>
    	</div>
	<?php }else{?>
		<?php if( $identity_list ){?>
    	<div class="clans_introduce_list_head">
    		<a href="javascript:;"> 
    		<span>社会身份</span> </a>
    		<!-- 企业风采 -->
    		<a href="<?php echo site_url("Corporation_style/User_Topic").'/'.$customer_info['id'];?>" class="corporate_style">企业风采</a>
    	</div>
    	<?php }?>
	<?php }?>
	<div>
	
<?php if( $identity_list ){?>
		<ul class="my_activities_top" id="identity_list">
		<?php foreach ( $identity_list as $k=> $v ){?>
			<li <?php echo $k> 2 ? 'hidden': ''?>><a href="<?php echo $customer_info['id'] == $this->session->userdata('user_id') ? site_url('Tribe_social/Edit_Identity/'.$v['id']) :  'javascript:;'?>">
					<div class="activities_nei_li">
						<div class="activities_nei_li_top">
							<i class="clans_introduce_icon"><span class="<?php echo $v['type'] == 1 ? 'icon-building_' : ( $v['type'] == 2 ? 'icon-building_1' : 'icon-hammer')?>"></span></i>
							<div class="activities_nei_li_xia">
								<h2><?php echo $v['organization_name']?></h2>
								<p>
									<span><?php echo $v['organizationl_duties']?></span>
								</p>
							</div>
							<?php if( $customer_info['id'] == $this->session->userdata('user_id')){ ?>
							    <div class="tribe_add_apply_status">
									<span class='icon-get_into'></span>
								</div>
							<?php  }?>
							
						</div>

					</div>
			</a></li>
			<?php }?>
			
			<?php if( count($identity_list) > 3){?>
			<div class="clans_my_introduce_more" id="load_identity">
				<span onclick="load_identity()">点击加载全部</span>
			</div>
			<?php }?>
			
		</ul>
	</div>
<?php }?>
	<!-- 评价 -->
	<div class="clans_introduce_list_head">
		<a href="<?php echo site_url('Tribe_social/comment/'.$customer_info['id'])?>"> <span>评价</span> <span>我要评价</span>
		</a>
	</div>
	<?php if( $comment_list ) {?>
	<div>
		<ul class="my_activities_top" id="comment_list">
		<?php foreach ( $comment_list as $v ){?>
			<li id="<?php echo $v['id'].'cmt';?>"><a href="javascript:;">
					<div class="activities_nei_li">
						<div class="activities_nei_li_top">
							<i><img class="border-50" src="<?php echo $v['brief_avatar'] ? IMAGE_URL.$v['brief_avatar'] : $v['wechat_avatar']?>"
								onerror="this.src='images/member_defult.png'"></i>
							<div class="activities_nei_li_xia">
								<h2><?php echo $v['real_name'] ? $v['real_name'] : substr_replace($v['name'],'********',2,8) ?></h2>
								<p>
									<span><?php echo $v['organization_name'];?>&nbsp;&nbsp;<?php echo $v['organizationl_duties']?></span>
								</p>
								<p class="clans_criticism_text"><?php echo $v['content']?></p>
							</div>
							<?php if($v['from_customer_id'] == $this->session->userdata("user_id")){?>
							    <em class="icon-shanchu2 customer_info_shanchu" data-value="<?php echo $v['id'];?>"></em>
							<?php }?>
							<!-- <div class="tribe_add_apply_status"><span class='icon-get_into'></span></div> -->
						</div>
					</div>
			</a></li>
		<?php }?>
		
		<?php if( count($comment_list) >= $comment_limit){?>
			<div class="clans_my_introduce_more"  id="load_comment">
				<span onclick="load_comment()">点击查看更多</span>
			</div>
		<?php }?>
		</ul>
	</div>
	<?php }?>
	<!-- 推荐她成为易货的人 -->
	
	<?php if( $parent_info ){?>
    	<div class="clans_introduce_list_head">
    		<a href="javascript:void(0);"> <span>推荐Ta成为易货的人</span> <!-- <span>我要评价</span> -->
    		</a>
    	</div>
    	<div>
    		<ul class="my_activities_top">
    			<li><a href="javascript:;">
    					<div class="activities_nei_li">
    						<div class="activities_nei_li_top">
    							<i><img class="border-50" src="<?php echo $parent_info['brief_avatar'] ? IMAGE_URL.$parent_info['brief_avatar'] : $parent_info['wechat_avatar']?>" onerror="this.src='images/member_defult.png'"></i>
    							<div class="activities_nei_li_xia">
    								<h2><?php if($parent_info['real_name']){ echo $parent_info['real_name'];}else if(isset($parent_info['member_name'])){ echo $parent_info['member_name'];}else{  echo $mobile = substr_replace($parent_info['mobile'],'********',2,8);}?></h2>
    								<p>
    									<span><?php echo $parent_info['organization_name'];?>&nbsp;&nbsp;<?php echo $parent_info['organizationl_duties']?></span>
    								</p>
    								<!-- <p class="clans_criticism_text">敏锐的商业眼光</p> -->
    							</div>
    							<!-- <div class="tribe_add_apply_status"><span class='icon-get_into'></span></div> -->
    						</div>
    					</div>
    			</a></li>
    		</ul>
    	</div>
	<?php }?>
</div>

<div style="height:60px;"></div>



<!-- 弹窗   -->
  <div class="clans_ball">
      <div class="clans_ball_box">
         <ul>
             <li><a href="javascript:void(0);"><img src="images/duanxin.png" alt="" style="height: 40px;width: 40px;"><span>短信邀请</span></a></li>
            <?php 
            $mac_type = $this->session->userdata("mac_type");
            if(!$mac_type){?>
                <li><a href="javascript:void(0);"><img src="images/weixin.png" alt=""><span>微信好友</span></a></li>
            <?php  }?>
             
         </ul>
         <div class="clans_ball_box_btn"><span>取消</span></div>
      </div>
  </div>



<!-- 担保申请／点赞 -->
<div class="circle_add_apply_footer">
	<ul>
                      	   
		<li style="border-left: none;"><a href="javascript:;" class='corp_invite'><span class="icon-yaoqing" style="padding-right: 5px;"></span>邀请</a></li>
		<?php 
		$user_id = $this->session->userdata("user_id");
		if($customer_info['id'] != $user_id){?>
		   <li class="customer_info_duihua"><a href="<?php echo site_url("Webim/Control/chat/{$tribe_id}/{$customer_info['id']}");?>" ><span class="icon-huihua" style="padding-right: 5px;"></span>对话</a></li>
		<?php }?>
		<li><a href="javascript:upvote();" class="custom_button"><span class="<?php echo $upvote_info['is_upvote'] ? 'icon-goods1' : 'icon-dianzan'?> " style="padding-right: 5px;"></span><span id="upvote_message">点赞</span><span class="dianzan_num1"><?php echo $upvote_info['num'] ? $upvote_info['num'] : 0;?></span></a></li>
	</ul>
</div>


<script type="text/javascript">

function show_mobile(e)
{


	var staff_id = "<?php echo $customer_info['staff_id']?>";
	var customer_id = "<?php echo $this->session->userdata('user_id');?>";
	var url = '<?php echo site_url('Tribe/update_show_mobile');?>';
	var show_mobile = $(e).attr("item");
	var show_text = $(e).text();
	// alert(show_text);
	var ajax_html = $(e);
	$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
		if(show_text == '显示'){
			// alert(3333);
			// console.log(ajax_html.parent("span"));
			$(".tel_").attr("href","tel:<?php echo $customer_info['mobile'];?>");
			
			$(".show_mobile_type").attr("style","color:#00F");
			$(".show_mobile_type").html(" ");
			$(".show_mobile_type").html("<?php echo $customer_info['mobile'];?>");
			ajax_html.html("隐藏");
		}else{
			// alert(123);
			// cons1ole.log(ajax_html.parent("span"));
			$(".tel_").attr("href","javascript:;");
			$(".show_mobile_type").attr("style","");
			$(".show_mobile_type").html(" ");
			$(".show_mobile_type").html("<?php echo substr_replace($customer_info['mobile'],'****',3,4);?>");
			ajax_html.html("显示");
		}
		
	});

}


function jump(){
	window.location.href="<?php echo site_url("Tribe_social/Customer_Album").'/'.$customer_info['id'].'/'.$tribe_id;?>";
}

$(".customer_info_shanchu").on('click',function(){
	var com_id = $(this).attr("data-value");
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Del_Comment')?>',
		data:{"com_id":com_id},
		type:'post',
		dataType:'json',
		success:function(data) 
		{ 
			$(".black_feds").text(data.Msg).show();
			setTimeout("prompt();", 2000); 
			if( data.status)
			{ 
				setTimeout(function(){
					$("#"+com_id+'cmt').remove();
					}, 2100); 
			}
		},
		error:function()
		{
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
})

$('.corp_invite').on('click',function(){

    
    var ts_id = '<?php echo !empty($_GET['ts_id']) ? $_GET['ts_id'] : 0?>';
    
    if( !ts_id )
    { 
        return;
    }
        
    $('.clans_ball').show();
    $('.clans_ball_box ul li').eq(0).show();
    $('.clans_ball_box ul li').eq(1).show();
    var url = '<?php echo site_url('Tribe/Invite_View/Corp/'.$tribe_id)?>/'+ts_id;
    
    $('.clans_ball_box ul li').eq(0).children('a').attr('id',"sendID"+ts_id);
    $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('Corp',"+ts_id+");");
    $('.clans_ball_box ul li').eq(1).children('a').attr('href',url+'/1');
    var wx_status = getCookie(ts_id,'wx');
    var dx_status = getCookie(ts_id,'dx');
    if(dx_status){
   	 $('.clans_ball_box ul li').eq(0).hide();
        }
    if(wx_status){
    	$('.clans_ball_box ul li').eq(1).hide();
        }
    if(dx_status && wx_status){
   	 $('.clans_ball').hide();
    	caution();
        }
})
  
$('.clans_ball').on('click',function(){ 
	   $('.clans_ball').hide()
})
function caution(){
	   $(".black_feds").text("3天内不可重复邀请").show();
		setTimeout("prompt();", 2000);
	   }
function getCookie(ts_id,type){
	    var Customer = false;
	    var Corp = false;
	    var Cookie_Customer ='invite_'+type+'_Customer_'+ts_id;
		var arr,reg= new RegExp("(^| )"+Cookie_Customer+"=([^;]*)(;|$)");
		if(arr=document.cookie.match(reg)){
			Customer = true;
		}
		var  Cookie_Corp = 'invite_'+type+'_Corp_'+ts_id;
		var Carr,Creg= new RegExp("(^| )"+Cookie_Corp+"=([^;]*)(;|$)");
		if(Carr=document.cookie.match(Creg)){
			Corp =  true;
			}
		if(Corp || Customer){
			return true;
			}
  }
function ajax_submit(flag,ts_id)
{
	var type = flag;
	var tribe_id = '<?php echo $tribe_id?>';
 var tribe_staff = ts_id;

	if( type && tribe_id && tribe_staff )
	{ 
	    $.ajax({ 
		    url:'<?php echo site_url('Tribe/Invite')?>',
		    type:'post',
		    dataType:'json',
		    data:{'type':type,'tribe_id':tribe_id,'tribe_staff':tribe_staff},
		    beforeSend:function()
            { 
		    	$(".black_feds").text("短信发送中....").show();
//             	document.getElementById('sub').style.background='#ccc';
// 	        	document.getElementById('sub').text='短信发送中....';
		    	$('.clans_ball_box ul li').eq(0).children('a').attr('href',"");
            },
		    success:function(data)
		    {

		    	$(".black_feds").text(data.message).show();
 	        setTimeout("prompt();", 2000);
 	        setTimeout(function(){
     	        window.location.reload();
     	        }, 2200);
				
			},
		    error:function()
		    {
		    	$(".black_feds").text("发送失败,请稍后再试").show();
		        setTimeout("prompt();", 2000);  
   		        $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('Corp',"+tribe_staff+");"); 
		        return;
		    }
	    })	
	}else{
		
		$(".black_feds").text("参数错误").show();
        setTimeout("prompt();", 2000);   
        return false;
	}
}

var num_upvote = <?php echo $upvote_info['num'] ? $upvote_info['num'] : 0 ;?>;

function upvote()
{
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Fabulous')?>',
		data:{'from_customer_id':<?php echo $customer_id?>,'customer_id':<?php echo $customer_info['id']?>},
		type:'post',
		dataType:'json',
		success:function(data) 
		{ 
			if( data.status == 1 )
			{ 
	            data.data.type == 1 ? num_upvote -=1 : num_upvote +=1;
	            var class_name = data.data.type == 1 ? 'icon-dianzan' : 'icon-goods1';
	            $('.dianzan_num1').text(num_upvote);
	            
	            $('#upvote_message').prev('span').attr('class',class_name);
			}
			console.log(num_upvote);
		},
		error:function()
		{
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
}

var page = 2;
//查看更多的评论
function load_comment()
{ 
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Load_Comment')?>',
		data:{'customer_id':<?php echo $customer_info['id']?>,'page':page},
		type:'post',
		dataType:'json',
		success:function(data) 
		{ 
			
			var html = '';
			var img_path = '<?php echo IMAGE_URL?>';

			if( data.data.list.length > 0 )
			{
    			for(var i= 0;i<data.data.list.length; i++)
    			{ 
        			var name = data.data.list[i]['real_name'];
        			
        			if( !name )
        			{ 
        				var name = data.data.list[i]['name'].substring(0,2)+"********"+data.data.list[i]['name'].substring(10,11);
        			}
            		
        			var organization_name = data.data.list[i]['organization_name'];
        			var organizationl_duties = data.data.list[i]['organizationl_duties'];
    				html+='<li><a href="javascript:;">'
    				html+='<div class="activities_nei_li">'
    				html+='<div class="activities_nei_li_top">'
    				html+='<i><img class="border-50" src='+( data.data.list[i]['brief_avatar'] ? img_path+data.data.list[i]['brief_avatar'] : data.data.list[i]['wechat_avatar'] )+' onerror="this.src=\'images/member_defult.png\'"></i>'
    				html+='<div class="activities_nei_li_xia">'
    				html+='<h2>'+name+'</h2>'
    				html+='<p><span>'+(organization_name ? organization_name : '')+'&nbsp;&nbsp;'+(organizationl_duties ? organizationl_duties : '')+'</span></p>'
    				html+='<p class="clans_criticism_text">'+data.data.list[i]['content']+'</p>'
    				html+='</div></div></div></a></li>'
    			}
    			
    			page++;
    			
    			$('#load_comment').before(html);

    			if( data.data.list.length < <?php echo $comment_limit ?>)
    			{ 
    				$('#load_comment span').text('全部加载完毕');
    				$('#load_comment span').removeAttr('onclick');
    			}
    			
			}else{ 
				
				$('#load_comment span').text('全部加载完毕');
				$('#load_comment span').removeAttr('onclick');
			}


			
		},
		error:function()
		{
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
}

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




function background_img()
{ 

    
        $.ajax({
            url: '<?php echo site_url('Tribe_social/Upload_Avatar');?>',
            type: 'POST',
            cache: false,
            dataType:'json',
            data: new FormData( $('#form1')[0] ),
            processData: false,
            contentType: false,
            
        }).done(function(data) 
        {
        	if( data.status )
        	{
            	$('#bg_img').attr('src',data.data);
        		$(".black_feds").text('更换成功').show();
        		setTimeout("prompt();", 2000); 
        		return;
        	}

        	$(".black_feds").text('更换失败').show();
    		setTimeout("prompt();", 2000); 
           	return false;
           	
        	
        }).fail(function(res) 
        {
        	$(".black_feds").text('网络异常，请稍后再试').show();
    		setTimeout("prompt();", 2000); 
           	return false;
        	
        });
        
}





</script>








