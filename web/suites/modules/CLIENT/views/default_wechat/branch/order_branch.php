
<style type="text/css">
	.container {background-color: #f6f6f6!important;}
.stored_value_top{
	display:none;
}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- 
<div class="header" style="height:50px;">
           <div class="main_dui">
            <a href="javascript:history.back();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px; float:none; display:block;font-size: 20px;"></a>
            <div class="main_dui_top">
            <p class="title">订单分店</p>
            </div>  
           </div> 
</div>
  -->

<div class="stored_value" style="padding-top:0px;">
     <div class="stored_value_div1"><a href="javascript:show();"><span>筛选日期</span><i id='icons' class="icon-back"></i></a></div>
     <div class="stored_value_top">
         <div class="screening_time">
          <input type="date"  id="start_at" name="start_at"  class="time_text" value="" onchange="startChange();">
          <div>至</div>
          <input type="date"  id="end_at" name="end_at" class="time_text" value="" onchange="endChange();">
        </div>  
	</div>
      <div class="order_branch">
        <ul id="hear" class="order_branch_top">
					<li class="action" style="border-bottom: 2px solid red;height: 43px;color:#06F0EC"><a href="javascript:navigation('all')"><samp>所有订单</samp></a></li>
					<li><a href="javascript:navigation('credit')" ><samp>货豆订单</samp></a></li>
					<li><a href="javascript:navigation('card')" ><samp>储存卡订单</samp></a></li>
				</ul>
         <div class="order_branch_zhong" id="contentop">
           <ul class="order_branch_zhong_ul action" >
              
           </ul>
         </div>   
      </div>


    <div class="order_branch_zhong_di" >
    	<span id="total_price" >销售额合计:100,000.00M</span>
<!--      <a id="total_price" href="javascript:void(0)"></a> -->
    </div>

</div>


<script>
	var show_type = 'hide';
    //下拉加载数据
    var page = 1;
    var type = 'all'; 
    var start_at = $("#start_at").val();
    var end_at = $("#end_at").val();
    var is_first = true;//识别是否加载数据
    dropload = $('#contentop').dropload({
       	 domUp : {
             domClass   : 'dropload-up',
             domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
             domUpdate  : '<div class="dropload-update">↑释放更新</div>',
             domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
         },
         domDown : {
             domClass   : 'dropload-down',
             domRefresh : '<div class="dropload-refresh">↑上拉加载更多订单</div>',
             domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
             domNoData  : '<div class="dropload-noData">暂无更多订单</div>'
         },
        scrollArea : window,
        loadUpFn : function(me){
       		page = 1;
        	$.post("<?php echo site_url("Corporate/branch/ajax_branch_order");?>",{branch_id:<?php echo $branch['id'];?>,page:page,type:type,start_at:start_at,end_at:end_at},function(data){
        		var total_price  ="销售额合计:"+data.total_price+"M";
				$("#total_price").html(total_price);	
   			 	if(data.List.length>0){
     	   			 var result = '';
      				for(var i=0;i<data.List.length;i++){
      					result += '<li>';
      					result += '<a href="javascript:void(0);">';
      					result += '<div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>'+data.List[i]['order_sn']+'</span></div><span>';
						if(data.List[i]['order_type'] != '1' ){
							result += '线上储存卡订单</span></div>';
							}else{
								result += '</span></div>';
								}
      					result += '<div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>';
      					result += '<div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>'+data.List[i]['total_price']+'货豆</span></div><span></span></div>';
      					result += '<div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>'+data.List[i]['nick_name']+'</span></div><span></span></div>';
      					result += '</a>';
      					result += '</li>';
          				}
     				 $('#contentop ul').empty();
      				 $('#contentop').find(" ul").html(result);
        			 page++;
                     me.resetload();
                     me.unlock();
                     me.noData(false);
     	   			 }else{
      	   				me.resetload();
        	   			dropload.unlock();
          	            dropload.noData(false);
         	   			 }
          		},"json");
            },
    	loadDownFn : function(me){
    		$.post("<?php echo site_url("Corporate/branch/ajax_branch_order");?>",{branch_id:<?php echo $branch['id'];?>,page:page,type:type,start_at:start_at,end_at:end_at},function(data){
    			var total_price  ="销售额合计:"+data.total_price+"M";
				$("#total_price").html(total_price);	
     			if(data.List.length>0){
   	   			 var result = '';
    				for(var i=0;i<data.List.length;i++){
    					result += '<li>';
    					result += '<a href="javascript:void(0);">';
    					result += '<div class="order_branch_divk">订单号：<div class="order_branch_di_left"><span>'+data.List[i]['order_sn']+'</span></div><span>';
						if(data.List[i]['order_type'] != '1'  ){
							result += '线上储存卡订单</span></div>';
							}else{
								result += '</span></div>';
								}
    					result += '<div class="order_branch_divk">面对面支付<div class="order_branch_di_left"><span></span></div><span></span></div>';
    					result += '<div class="order_branch_divk">金额：<div class="order_branch_di_left"><span>'+data.List[i]['total_price']+'货豆</span></div><span></span></div>';
    					result += '<div class="order_branch_divk">买家：<div class="order_branch_di_left"><span>'+data.List[i]['nick_name']+'</span></div><span></span></div>';
						if(data.List[i]['order_type'] != '1' ){
							result += '<div class="order_branch_divk">储值卡名称：<div class="order_branch_di_left"><span>'+data.List[i]['savings_card_name']+'</span></div><span></span></div>';
							}
    					result += '</a>';
    					result += '</li>';
        				}
   				 $('#contentop').find(" ul").append(result);
      			  page++;
                  me.resetload();
   	   			 }else{
   	   	   			// 锁定
  	                me.lock();
  	                // 无数据
  	                me.noData();
  	                me.resetload();
   	   	   			 }
        		},"json");
        	}
    
    });

    function  navigation(types){
    	if(types !=  type){
  		    $("#contentop ul").empty();
    		$(this).addClass("action").siblings().removeClass("action");
    		type = types;
    		page = 1;//默认第一页
  		    // 解锁
            dropload.unlock();
            dropload.noData(false);
            // 重置
            dropload.resetload();
    	}
    }	
    function startChange(){
        var branch_time = '<?php echo substr ( $branch['created_at'], 0,10);?>';
        branch_time = new Date(branch_time.replace(/-/g,"/")); 
        var current_time =  $("#start_at").val();
        current_time =new Date(current_time.replace(/-/g,"/")); 
        var diff = current_time - branch_time;
        if(diff < 0 ){
        	$("#start_at").val('');
        	$(".black_feds").text("起始日期不能小于开店日期！").show();
    		setTimeout("prompt();", 2000);
            }
        var end_times = $("#end_at").val();
        if(end_times){
        	var start_times =  $("#start_at").val();
           	 $(".stored_value_top").hide();
            	$("#icons").attr("class",'icon-back');
            	$("#icons").css("-webkit-transform","rotate(180deg)");
            	show_type = 'hide';  
            	start_at =  start_times;
             	end_at  = end_times;
              page = 1;//默认第一页
              $("#contentop ul").empty();
      		// 解锁
              dropload.unlock();
              dropload.noData(false);
              // 重置
              dropload.resetload();
            }
        }
    function  endChange(){
   	 	var start_times =  $("#start_at").val();
   		var end_times = $("#end_at").val();
   	 	if(!start_times){
   	   	 	$("#end_at").val('');
   	   	 	$(".black_feds").text("请先选择起始日期！").show();
   			setTimeout("prompt();", 2000);
   			return;
   	   	 	}
        var start_time =new Date(start_times.replace(/-/g,"/"));
      	var end_time =new Date(end_times.replace(/-/g,"/"));  
     	var diff = start_time - end_time;
   	 	if(diff > 0 ){
   	   	 	$("#end_at").val('');
   	   	   	$(".black_feds").text("结束日期不能小于起始日期！").show();
   			setTimeout("prompt();", 2000);
   			return;
   	   	  }
      	$(".stored_value_top").hide();
      	$("#icons").attr("class",'icon-back');
      	$("#icons").css("-webkit-transform","rotate(180deg)");
      	show_type = 'hide';  
      	start_at =  start_times;
       	end_at  = end_times;
        page = 1;//默认第一页
        $("#contentop ul").empty();
		// 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
       
        }
    
    function show(){
        if(show_type == 'hide'){
        	$(".stored_value_top").show();
        	show_type = 'show';
        	$("#icons").attr("class",'icon-xiala');
        	$("#icons").css("-webkit-transform","none");
            }else{
            	$(".stored_value_top").hide();
            	show_type = 'hide'; 
            	$("#icons").attr("class",'icon-back');
            	$("#icons").css("-webkit-transform","rotate(180deg)");
                }
        }
    
    $(function(){
    	$("#hear li").click(function(){
    		$(this).css({
    			borderBottom: "2px solid red",
    			height:"43px"
    		}).siblings().css({
    			borderBottom: "none",
    			height:"43px"
    		});
    	});					
//     	$("#hear li").click(function(){
//     		$(this).addClass("action").siblings().removeClass("action");
//     		var index = $(this).index();
//     		$("#contentop ul").eq(index).css("display","block").siblings().css("display","none");
//     	});
    });
   

</script>