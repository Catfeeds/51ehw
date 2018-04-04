<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- <div class="commodity_h50"></div> -->
<!-- 我的需求 -->
<div class="my-needs">
	<!-- 内容 -->
	<div class="my-needs-main my-offer-main" id="main">
	    <!-- 全部 -->
		     <ul class="list">
		     </ul>
	</div>
</div>
<script type="text/javascript">
	$(".my-needs-nav ul li").on("click",function(){
		var index = $(this).index();
		$(this).addClass("my-needs-nav-active").siblings().removeClass("my-needs-nav-active");
		$(".my-needs-main ul").eq(index).show().siblings().hide();
	})
	
//下拉加载数据
var page = 1;

	dropload = $('#main').dropload({
		scrollArea : window,
		loadDownFn : function(me){
			 $.post("<?php echo site_url("Member/requirement/ajax_offer_list");?>",{page:page},function(data){
				 if(data.list.length>0){
					 var result = '';
					 var errorimg = "this.src='images/default_img_s.jpg'";
					 for(var i=0;i<data.list.length;i++){
						 var img = "<?php echo base_url(),'uploads/B/';?>"+data.list[i]['img_path'];
						 var url = '<?php echo site_url('member/requirement/offerdetails')?>/'+data.list[i]['requirement_id']+'/'+data.list[i]['barter_id'];
						 result += '<li>';
					     result += '<a href="'+url+'">';
						 result += '<div class="my_needs_goods_img" style="width: 25%;"><img src="'+img+'" onerror="'+errorimg+'" alt=""></div>';
						 result += '<div class="my_needs_text">';
						 result += '<span class="my-needs-li-title">'+data.list[i]['title']+'</span>';
						 result += '<span class="my-needs-li-money">我报的总价:'+data.list[i]['offer']+'货豆</span>';
						 result += ' <span class="my-needs-li-time">报价时间:'+data.list[i]['create_at']+'</span>';
						 result += '</div>	';
						 result += '</a>';
						 result += '</li>';
						 }
					     $('#main').find('.list').append(result);  
					     page++;
			             me.resetload();
					 }else{
		 	                if(page == 1){
		 	                	var result = '';
								result += ' <div style="text-align: center;padding-top: 150px;">';
								result += ' <a href="javascript:void(0);"><span class="icon-iconfontchakandingdan" style="font-size: 110px;color:#ccc;"></span></a><br>';
								result += ' <span style="font-size: 17px;color:#ccc;padding-top: 10px;display: block;">暂无相关报价</span>';
								result += ' </div>';
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
								   $(".dropload-noData").html("没有更多的报价信息！");
								  }
						 }
				 
			 },"json");
		}
	});

</script>


