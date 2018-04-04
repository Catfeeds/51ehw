<style type="text/css">
	.container {background: #f6f6f6;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<!-- 订单通知 -->
<div class="order_inform" id="order_inform">
         <ul class="list">
         </ul>
</div>

<script type="text/javascript">
  var height = $(".order_inform_text").height();
  var height_icon = $(".order_inform_icon").height();
  $(".order_inform_icon").css('top',(height - height_icon) * 0.5 + 3);



	//下拉加载数据
	var page = 1;
	dropload = $('#order_inform').dropload({
	    scrollArea : window,
    	loadDownFn : function(me){
    		var result = "";
    		var type = <?php echo  $type;?>;
    		$.post("<?php echo site_url("Member/Message/ajax_list");?>",{type:type,page:page},function(data){
    			if(data.list.length>0){
    				for(var i=0;i<data.list.length;i++){
    					result +='<li>';
    					result +=' <div class="order_inform_time"><span>'+data.list[i]['created_at']+'</span></div>';
    					if(type == 2){//订单消息
    						result +='<div onclick="Jump_order();" class="order_inform_main">';
    					}else{
        					result +='<div class="order_inform_main">';
    					}
    					result +=' <div class="order_inform_title"><span>'+data.list[i]['title']+'</span></div> ';
    					result +=' <div class="order_inform_text">';
    				
    					if(data.list[i]['template_id'] == 10){
    						var message = data.list[i]['message'];
        					var str1 = message.replace(/<!--/g,' ');
        					var str2 = str1.replace(/-->/g,' ');
        					result +='<span>'+str2+'</span>';
        					}else{
        						result +='<span>'+data.list[i]['message']+'</span>';
            					}
    					if(type == 2){
    						result +='<span class="icon-right order_inform_icon"></span>';
        					}
    					result +='</div>';
    					result +='</div>';
    					result +='</li>';
        				}

   				$('#order_inform').find('.list').append(result);
                for (var i = 0; i < $(".order_inform ul li").length; i++) {
                    var height = $(".order_inform ul li").eq(i).find('.order_inform_text').height();
                    $(".order_inform ul li").eq(i).find('.order_inform_text').children(".order_inform_icon").css("top",(height - 8)/2);
                };
				page++;
                me.resetload();
                
        		}else{
        			// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
	                $(".dropload-noData").text  ('暂无更多消息');
	                }
        	},"json");
	}
	});

function  Jump_order(){
	window.location.href = '<?php echo site_url('Member/order');?>';
} 


</script>



