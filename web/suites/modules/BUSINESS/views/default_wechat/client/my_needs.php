<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- <div class="commodity_h50"></div> -->
<style>
 .my-needs-nav-active a{
	color: #fed602;
 }
 .container {background: #f8f8f8;}
</style>
<!-- 我的需求 -->
<div class="my-needs">
    <!-- 头部导航 -->
	<div class="my-needs-nav">
		<ul>

	    <li <?php echo $status == 0 ? 'class="my-needs-nav-active-li"':''?> ><a href="<?php echo site_url('member/requirement/my_req')?>" >全部</a></li>
	    <li <?php echo $status == 1 ? 'class="my-needs-nav-active-li"':''?>><a href="<?php echo site_url('member/requirement/my_req/1')?>">抢单中</a></li>
	    <li <?php echo $status == 2 ? 'class="my-needs-nav-active-li"':''?>><a href="<?php echo site_url('member/requirement/my_req/2')?>">已下架</a></li>
	    <li <?php echo $status == 3 ? 'class="my-needs-nav-active-li"':''?>><a href="<?php echo site_url('member/requirement/my_req/3')?>">审核中</a></li>
	    <li <?php echo $status == 4 ? 'class="my-needs-nav-active-li"':''?>><a href="<?php echo site_url('member/requirement/my_req/4')?>">审核不通过</a></li>

	</ul>
	</div>
	<div style="height: 45px;"></div>
	<!-- 内容 -->
	<div class="my-needs-main" id="main">
	   <ul class="list">
		</ul>
	</div>
</div>


<script type="text/javascript">
	$(".my-needs-nav ul li").on("click",function(){
		var index = $(this).index();
		// $(this).addClass("my-needs-nav-active").siblings().removeClass("my-needs-nav-active");
		$(this).find("a").addClass("my-needs-nav-active").parent().siblings().find("a").removeClass("my-needs-nav-active");
		$(".my-needs-main ul").eq(index).show().siblings().hide();
		$(this).addClass('my-needs-nav-active-li').siblings().removeClass('my-needs-nav-active-li');
	})

	var page = 1;
	var type = <?php echo $status;?>;
	dropload = $('#main').dropload({
		scrollArea : window,
		loadDownFn : function(me){
			 $.post("<?php echo site_url("Member/requirement/ajax_mylist");?>",{page:page,type:type},function(data){
				 if(data.list.length>0){
					 var result= '';
					 var errorimg = "this.src='images/default_img_s.jpg'";
					 var id = 0;
					 for(var i=0;i<data.list.length;i++){
						 var url = '<?php echo site_url('member/requirement/details')?>/'+data.list[i]['id'];
						 var img = "<?php echo base_url(),'uploads/B/';?>"+data.list[i]['img_path'];
						 result += '<li>'; 
						 result += '<a href="'+url+'">'; 
						 result += '<div class="my_needs_goods_img"><img src="'+img+'" onerror="'+errorimg+'" alt=""></div>'; 
						 result += '<div class="my_needs_goods_main"> '; 
						 switch (type){ 
						    case 0:
							    if(data.list[i]['status']['type'] == 1){
								    if(data.list[i]['status']['is_putaway'] == 1){
								    	result += '<span class="my-needs-li-tishi changdang">'+data.list[i]['status']['name']+'</span>'; 
									    }else{
									    	result += '<span class="my-needs-li-tishi shenhe-pass">'+data.list[i]['status']['name']+'</span>'; 
										    }
								    }
							    if(data.list[i]['status']['type'] == 2){
							    	result += '<span class="my-needs-li-tishi shenhe-ing">'+data.list[i]['status']['name']+'</span>'; 
								    }
							    if(data.list[i]['status']['type'] == 3){
							    	result += '<span class="my-needs-li-tishi shenhe-close">'+data.list[i]['status']['name']+'</span>'; 
								    }
							    break;
						    case 1:    
						    	result += '<span class="my-needs-li-tishi changdang">抢单中</span>'; 
						    	break;
						    case 2:
						    	result += '<span class="my-needs-li-tishi shenhe-pass">审核通过</span>'; 
							    break;
						    case 3:    
						    	result += '<span class="my-needs-li-tishi shenhe-ing">审核中</span>'; 
						    	break; 	
						    case 4:
						    	result += '<span class="my-needs-li-tishi shenhe-close">审核不通过</span>'; 
							    break;
						 }
						 result += '<span class="my-needs-li-title">'+data.list[i]['title']+'</span>'; 
						 result += '<span class="my-needs-li-time">发布时间'+data.list[i]['create_at']+'<span class="my-needs-li-num">已报价'+data.list[i]['total']+'人</span></span>';
						 result += '</div>'; 
						 result += '</a>'; 
						 result += ' </li>'; 
						 }
					 $('#main').find('.list').append(result);
					  var width_div = $(".my_needs_goods_img").width();
 					 $(".my_needs_goods_img").height(width_div);
					 page++;
		             me.resetload();
					 }else{
						 if(page ==1){
							 var result= '';
							 result += '<div style=" text-align: center;padding-top: 150px;">';
							 result += '<a href="javascript:void(0);"><span class="icon-iconfontchakandingdan" style="font-size: 110px;color:#ccc;"></span></a><br>';
							 result += '<span style="font-size: 17px;color:#ccc;padding-top: 10px;display: block;">暂无相关需求</span>';
							 result += '</div>';
							 $('#main').find('.list').append(result);
							 // 锁定
		 	                 me.lock();
		 	                 // 无数据
		 	                 me.noData();
		 	                 me.resetload();
			 	             $(".dropload-noData").hide();
							 }else{
									// 锁定
				 	                me.lock();
				 	                // 无数据
				 	                me.noData();
				 	                me.resetload();
				 	                $(".dropload-noData").html("暂无更多需求");
								 }
		 	         }
			 },"json");
	    }
	});


	
</script>


