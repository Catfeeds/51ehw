<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
    .container {background: #f8f8f8;}
    .class_icon span {color: #fff;font-size: 20px;position: absolute;right: 10px;top: 17px;}
    .active_nav {border-bottom: 2px solid #fed602;padding-bottom: 12px;color: #fed602;}
    .my-needs-nav {border-bottom: 1px solid #ddd;}
    .my-needs-nav ul li{width:50%;}
    .my-needs-nav ul li a {padding-right: 5px;padding-left: 5px;}
    .my-needs-nav ul li span {width: 10px;display: inline-block;color: #666;}
    .active_nav_span {color: #fed602!important;}
.my-needs-main{margin-top:0px}
</style>
<!-- 搜索 -->
<div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
     <!--javascript:void(window.history.back());-->
    <a href="<?php echo site_url('Member/requirement');?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form action="<?php echo site_url('member/requirement/search')?>" method="post" id="form_search" name="form_search" onsubmit="check_form();">
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:75%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;">
            <a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
            <input type="text" class="search_input" name="keyword" id="keyword" value="<?php if($keyword){ echo $keyword;}?>" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"  onpaste="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"   oncontextmenu ="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"   placeholder="<?php if($cate){ echo $cate_name;}else{echo '按标题搜索需求';}?>" required="" style="width:80%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;padding-left: 0;">
            <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a>
          </p> 
          <a href="<?php echo site_url("Member/requirement/classify?keyword=").$keyword;?>" class="class_icon"><span class="icon-class"></span></a>          

       </div>
  
</div>
 <div class="commodity_h50"></div>
 <?php if(!$show_list){
     if(count($demand_history) == 0 && count($cate_history) == 0){?>
          <!-- 暂无搜索历史 -->
 		  <div class="needs_list_not_search"><span>暂无搜索历史</span></div>
    
    <?php  }else{ if(count($demand_history)>0){?>
     <!-- 搜索历史 -->
     <div class="needs_list_history_search">
     <span>搜索历史</span>
      <span class="icon-shanchu2 needs-list-shanchu" onclick="del('keyword');"></span>
         <ul>
         <?php foreach ($demand_history as $key =>$val){ ?>
              <li> <a href="<?php echo site_url("member/requirement/search").'?keyword='.$val;?>" ><?php echo $val?></a></li>
         <?php }?>
         </ul>
      </div>   
 <?php }  if(count($cate_history)>0){?>
 <!-- 最近搜索的分类 -->
  <div class="needs_list_history_search"> 
    <span>最近搜索的分类</span><span class="icon-shanchu2 needs_list_search_shanchu" onclick="del('cate');"></span>
    <ul>
    <?php foreach ($cate_history as $key =>$val){ ?>
         <li><a href = "<?php echo site_url("member/requirement/search").'?cate='.$val['cate'];?>" ><?php echo $val['cate_name'];?></a></li>
    <?php }?>
    </ul>
 </div>   
<?php }}}?>
 </form>
 <?php if($show_list){ ?>
<!-- 我的需求 -->
<div class="my-needs">
   		 <!-- 标签 -->
   		 <?php if(false){?>
	     <div class="needs-list-label"> 
    		<span class='offer-details-text01' style="padding-left: 0;">已选择：<?php echo $cate_name;?></span>
         </div> 
         <?php }?>
         <!-- 刷选导航 
        <div class="my-needs-nav">
        	<ul>
        	    <li><a href="javascript:void(0);"  class="active_nav">发布时间</a><span class="icon-jiantou-copy active_nav_span first_span"></span><span class="icon-jiantou2 last_span"></span></li>
        	    <li><a href="javascript:void(0);">倒计时</a><span class="icon-jiantou-copy first_span01"></span><span class="icon-jiantou2 last_span01"></span></li>
        	</ul>
        </div>
        --> 
	<!-- 内容 --> 
	<div class="my-needs-main my-offer-main" id="main" style="/*padding-top: 45px !important*/">
	    <!-- 全部 -->
		<ul class="list">
		
		</ul>
		
	</div>
</div>
<?php }?>



<script type="text/javascript">

$(".needs-list-bt").parents('li').click(function(){
	window.location.href = $(this).children(".needs-list-bt").attr('href');
});

var length = $(".my-needs-nav ul li").length;
$(".my-needs-nav ul li").css("width",(100 / length) + "%");

$(".my-needs-nav ul li").on("click",function(){
	var index = $(this).index();
	$(this).find("a").addClass("active_nav").parent().siblings().find("a").removeClass("active_nav");
	$(".my-needs-main ul").eq(index).show().siblings().hide();
	// $(this).addClass('my-needs-nav-active-li').siblings().removeClass('my-needs-nav-active-li');
})

function bullet(){
	$(".black_feds").text("报价已截止！").show();
	setTimeout("prompt();", 2000);
}

function check_form(){
	document.form_search.submit();
}


function del(type){
	window.location.href = '<?php echo site_url('Member/requirement/del').'?type='?>'+type;
}

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
var cate_id = <?php if(empty($cate)){ echo '0';}else{echo $cate;}?>;
var _load = '<?php echo $show_list;?>';
var type = '';
dropload = $('#main').dropload({
	scrollArea : window,
	loadDownFn : function(me){
		if(_load){//搜索才加载
		 $.post("<?php echo site_url("Member/requirement/ajax_list");?>",{page:page,keyword:keyword,cate_id:cate_id,orderBy:type},function(data){
			 if(page == 5){
					// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
				 }
			 if(data.demandlist.length>0){
				 var result= '';
				 var errorimg = "this.src='images/default_img_s.jpg'";
				 var id = 0;
				 for(var i=0;i<data.demandlist.length;i++){
					 var url = '<?php echo site_url('member/requirement/addbarter')?>/'+data.demandlist[i]['id'];
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
					 if(page == 1){
						 if(keyword){
							 if(cate_id){
								 $(".dropload-noData").html("暂时还没有该分类的需求哦！");
								 }else{
									 $(".dropload-noData").html("暂时还没有您想要需求哦！");
									 }
							 }else{
								 if(cate_id){
									 $(".dropload-noData").html("暂时还没有该分类的需求哦！");
								   }else{
									   $(".dropload-noData").html("暂无更多需求");
									   }
								 }
						if(type == 'time_up' || type == 'time_down' ){
							$(".dropload-noData").html("暂时还没有进入倒计时的需求哦！");
							}
							
						 }else{
							 $(".dropload-noData").html("暂无更多需求");
							 }
					 $(".dropload-down").show();
	 	         }
		 },"json");
	   }
    }
});

var rank_type1 = 'generate_down';
$(".my-needs-nav ul li").eq(0).on("click",function(){
	$(".my-needs-nav ul li").eq(1).children('span').removeClass('active_nav_span');
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

var rank_type2 = '';
$(".my-needs-nav ul li").eq(1).on("click",function(){
	$(".my-needs-nav ul li").eq(0).children('span').removeClass('active_nav_span');
	if(rank_type2 != 'time_up'){
		rank_type2 = 'time_up';
		type = 'time_up';
		 $(".first_span01").addClass("active_nav_span");
         $(".last_span01").removeClass("active_nav_span");
		}else{
			rank_type2 = 'time_down';
			type = 'time_down';
			$(".first_span01").removeClass("active_nav_span");
		 	$(".last_span01").addClass("active_nav_span");
			}
	page = 1;//默认第一页
	 $('#main').find('.list').empty();
	 // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();

})




</script>


