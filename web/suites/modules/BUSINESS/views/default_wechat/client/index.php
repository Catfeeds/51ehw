<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
    .container {background: #f8f8f8;}
    .class_icon span {color: #fff;font-size: 20px;position: absolute;right: 10px;top: 17px;}
    .forget-password {background: #fff;padding: 25px 20px 20px 20px;position: fixed;top: 0px;left: 10%;width: 80%;margin:0;z-index: 999;}
    .password-text span {line-height: 25px;}
    .box_ball {position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,0.5);top: 0;z-index: 999;}
    .my-needs-nav {border-bottom: 1px solid #ddd;}
	.my-needs-nav ul li{ font-size:15px;}
    .my-needs-nav ul li a { display:block;color:#999999;}
    .my-needs-nav ul li span {width: 10px;display: inline-block;color: #333333; padding-left:9px;}
    .active_nav_span {color: #fed602!important;}
    .my-needs-main{margin-top:47px}
</style>
<!-- 搜索 -->
<div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
    <a href="<?php echo site_url('home');?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="<?php echo site_url('member/requirement/search')?>" method="post" id="form_search" name="form_search" onsubmit="check_form();">
       <div class="nav_search" style="padding-top: 10px;margin-left:20px;">
          <p style="background-color: #fff;width:90%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;">
         	<a href="<?php echo site_url("Member/requirement/search");?>">
            <span href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></span>
            <input type="text" class="search_input" name="keyword" id="keyword" value=""   placeholder="按标题搜索需求" required="" style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;padding-left: 0;">
          	</a>  
            <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a>
          </p> 
           <!--<a href="<?php //echo site_url("Member/requirement/classify?keyword=")?>" class="class_icon"><span class="icon-class"></span></a>  -->     


       </div>
  
</div>
 <div class="commodity_h50"></div>
<!-- 刷选导航 -->

 <div class="my-needs-nav" style="padding-bottom: 45px;">
 	<ul>
     <li style="width:30%"><a href="<?php echo site_url("Member/requirement/classify?keyword=")?>" style="color:#333333" >分类选择<span class="icon-fenlei1" ></span></a></li>
         <li style="width:25%"><a href="javascript:void(0);" class="active_nav">精选推荐</a></li>
	     <li style="width:25%"><a href="<?php echo site_url("Member/requirement/all_demand")?>">需求总价</a></li> 
         <li style="width:20%"><a href="<?php echo site_url("Member/requirement/customization_demand");?>"><span style="padding-left:0" class="icon-dingzhi"></span></a></li> 
 	</ul>
</div> 


<!--<div class="my-needs-nav" style="padding-bottom: 45px;">
 	<ul>
         <li><a href="javascript:void(0);">精选推荐</a></li>
	    <li><a href="javascript:void(0);"  class="active_nav">发布时间</a><span class="icon-jiantou-copy active_nav_span first_span"></span><span class="icon-jiantou2 last_span"></span></li> 
	    <li><a href="javascript:void(0);">倒计时</a><span class="icon-jiantou-copy first_span01"></span><span class="icon-jiantou2 last_span01"></span></li> 
 	</ul>
</div> -->

<!-- 我的需求 -->
<div class="my-needs">
  <!--标签切换-->
<!--   <div class="classification_top">
   <ul class="classification_ul">
       <li><a href="#">精选推荐</a></li>
       <li><a href="#">需求总价</a></li>
       <li><a href="#">发布时间</a></li>
       <li><a href="#"></a></li>
   </ul>
  </div> -->
   		<!--  标签 
   	
	     <div class="needs-list-label"> 
    		<span class='offer-details-text01' style="padding-left: 0;">已选择：<?php // echo $cate_name;?></span>
         </div> -->
        
	<!-- 内容 --> 
	<div class="my-needs-main my-offer-main" id="main">
	    <!-- 全部 -->
		<ul class="list" >
			<!-- <?php //foreach($list as $val):?>
				<li>
					<div>
						<div><a ><img src="<?php //echo $val['img_path'];?>"></a></div>
						<div>
							<span><?php //echo $val['title'];?></span>
							<span>总价：<?php //echo $val['total_price'];?>券</span>
						</div>
					</div>
				</li>
			<?php //endforeach;?> -->
		</ul>
		
	</div>

</div>

<script type="text/javascript">



//停止倒计时
function StopFunc(name){
	clearInterval(name);
}

//倒计时
var Timer =  function (id,time){
 	var dateTime = time;
 	dateTime = dateTime.replace(/-/g,"/");
 	var EndTime = new Date(dateTime);
	this.EndTime = EndTime.getTime();
	//this.time =Math.floor((EndTime - NowTime) / 1000); //倒数的时间
	this.flag = id+'Timer';//定时器名字
	this.name = 'timer'+id;
}

Timer.prototype.start = function () {
	 var self = this;
	
	 self.flag = setInterval(
			 function () {
				 var NowTime = new Date();
				 var diff = self.EndTime - NowTime.getTime();
				 if(diff < 0){
					 StopFunc(self.flag);
					 document.getElementById(self.name).innerHTML = '0分0秒';
					 }
				 var m =Math.floor(diff/1000/60%60);//分
				 var s =Math.floor(diff/1000%60);//秒
				 document.getElementById(self.name).innerHTML = m+'分'+s+'秒';
				 }, 1000);
	 }


//下拉加载数据
var page = 1;
var keyword = $("#keyword").val();
var cate_id = '';
var type = '';
dropload = $('#main').dropload({
	scrollArea : window,
	loadDownFn : function(me){
		
		 $.post("<?php echo site_url("Member/requirement/ajax_list");?>",{page:page,keyword:keyword,cate_id:cate_id,orderBy:type},function(data){
			 if(data.demandlist.length>0){
				 var result= '';
				 var errorimg = "this.src='images/default_img_s.jpg'";
				 for(var i=0;i<data.demandlist.length;i++){
					 var cus_id = '<?php echo $this->session->userdata("user_id");?>';
					 if(cus_id == data.demandlist[i]['create_by']){
						 var url = '<?php echo site_url('member/requirement/details')?>/'+data.demandlist[i]['id'];
						 }else{
							 var url = '<?php echo site_url('member/requirement/addbarter')?>/'+data.demandlist[i]['id'];
							 }
					 var img = "<?php echo base_url(),'uploads/B/';?>"+data.demandlist[i]['img_path'];
					 result += '<li>';
					 result += '<a href="'+url+'">';
					 result += '<div class="my_needs_goods_img" style="width: 25%;"><img src="'+img+'" onerror="'+errorimg+'" alt=""></div>';
					 result += '<div class="my_needs_text">';
					 result += '<span class="my-needs-li-title">'+data.demandlist[i]['title']+'</span>';
					 result += '<span class="my-needs-li-money">总价:'+data.demandlist[i]['total_price']+'</span>';
					 result += '<!--<span class="my-needs-li-time">';
					 if(data.demandlist[i]['status']==1)//小于1小时
					  {
						 result += '<span id="timer'+data.demandlist[i]['id']+'"></span>';
					  }
					 if(data.demandlist[i]['status']==2)//大于一个小时 小于一天
					 {
						 var NowTime = new Date();
						 var dateTime = data.demandlist[i]['remaining'];
						 dateTime = dateTime.replace(/-/g,"/");
						 var EndTime = new Date(dateTime);
						 var diff = EndTime.getTime() - NowTime.getTime();
						 var h =Math.floor(diff/1000/60/60%24);//时
						 var m =Math.floor(diff/1000/60%60);//分
					 	 result += '<span>'+h+'时'+m+'分</span>';
					 }
					 if(data.demandlist[i]['status']==3)//大于一天
					 {
						 var NowTime = new Date();
                         var dateTime = data.demandlist[i]['remaining'];
						 dateTime = dateTime.replace(/-/g,"/");
						 var EndTime = new Date(dateTime);
						 var diff =EndTime.getTime() - NowTime.getTime();
						 var d =Math.floor(diff/1000/60/60/24);//天
						 var h =Math.floor(diff/1000/60/60%24);//时
// 						 var m =Math.floor(diff/1000/60%60);//分
						 result += '<span>'+d+'天'+h+'时</span>';
					 }
					 result += '<span class="my-needs-li-num">'+data.demandlist[i]['total']+'人已报价</span>';
					 result += '</span> --> ';
					 result += '</div>';
					 result += '</a>';
					 result += '</li>';
					 }
				 $('#main').find('.list').append(result);
				 var width_div = $(".my_needs_goods_img").width();
 			     $(".my_needs_goods_img").height(width_div);
 			     
				 page++;
	             me.resetload();
	            
				 for(var i=0;i<data.demandlist.length;i++){
					 if(data.demandlist[i]['status']==1){//开启定时器
						 var timer = new  Timer(data.demandlist[i]['id'],data.demandlist[i]['remaining']);
						 timer.start();
						 }
					 }
				 }else{
						// 锁定
	 	                me.lock();
	 	                // 无数据
	 	                me.noData();
	 	                me.resetload();
	 	                $(".dropload-noData").html("暂无更多需求");
		 	            $(".dropload-down").show();
	 	         }
		 },"json");
	}
});

</script>
<script type="text/javascript">

    var length = $(".my-needs-nav ul li").length;
    $(".my-needs-nav ul li").css("width",(100 / length) + "%");

	$(".my-needs-nav ul li").on("click",function(){
		var index = $(this).index();
		$(this).find("a").addClass("active_nav").parent().siblings().find("a").removeClass("active_nav");
		$(".my-needs-main ul").eq(index).show().siblings().hide();
		// $(this).addClass('my-needs-nav-active-li').siblings().removeClass('my-needs-nav-active-li');
	})
    
    var rank_type1 = 'generate_down';
    
	$(".my-needs-nav ul li").eq(9).on("click",function(){

		$(".my-needs-nav ul li").eq(9).children('span').removeClass('active_nav_span');
		if(rank_type1 == 'generate_down' ){
			    rank_type1 = 'generate_up';
			    type = 'generate_up';
			    $(".first_span").addClass("active_nav_span");
	            $(".last_span").removeClass("active_nav_span");
			}else{
				 rank_type1 = 'generate_down';
				 type = 'generate_down';
				$(".first_span").removeClass("active_nav_span");
			 	$(".last_span").addClass("active_nav_span");
				}
		page = 1;//默认第一页
		 $('#main').find('.list').empty();
		
		 // 解锁
	    dropload.unlock();
	    dropload.noData(false);
	    // 重置
	    dropload.resetload();

	})

	// $(".my-needs-nav ul li").eq(100).on("click",function(){

	// 	$(".my-needs-nav ul li").eq(100).children('span').removeClass('active_nav_span');
	// 	if(rank_type1 == 'generate_down' ){
	// 		    rank_type1 = 'generate_up';
	// 		    type = 'generate_up';
	// 		    $(".first_span").addClass("active_nav_span");
	//             $(".last_span").removeClass("active_nav_span");
	// 		}else{
	// 			 rank_type1 = 'generate_down';
	// 			 type = 'generate_down';
	// 			$(".first_span").removeClass("active_nav_span");
	// 		 	$(".last_span").addClass("active_nav_span");
	// 			}
	// 	page = 1;//默认第一页
	// 	 $('#main').find('.list').empty();
		
	// 	 // 解锁
	//     dropload.unlock();
	//     dropload.noData(false);
	//     // 重置
	//     dropload.resetload();

	// })

 //    var rank_type2 = '';
	// $(".my-needs-nav ul li").eq(1).on("click",function(){
	// 	$(".my-needs-nav ul li").eq(0).children('span').removeClass('active_nav_span');
	// 	if(rank_type2 != 'time_up'){
	// 		rank_type2 = 'time_up';
	// 		type = 'time_up';
	// 		 $(".first_span01").addClass("active_nav_span");
	//          $(".last_span01").removeClass("active_nav_span");
	// 		}else{
	// 			rank_type2 = 'time_down';
	// 			type = 'time_down';
	// 			$(".first_span01").removeClass("active_nav_span");
	// 		 	$(".last_span01").addClass("active_nav_span");
	// 			}
	// 	page = 1;//默认第一页
	// 	 $('#main').find('.list').empty();
	// 	 // 解锁
	//     dropload.unlock();
	//     dropload.noData(false);
	//     // 重置
	//     dropload.resetload();

	// })


</script>






