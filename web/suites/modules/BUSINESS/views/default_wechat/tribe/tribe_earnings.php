<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<style type="text/css">
	.container {background:#f6f6f6;}
</style>

<!-- 我的收益 -->
<div class="ranking_list">
	<!-- 导航 -->
	<div class="ranking_list_nav">
		<ul>
		   <li class="ranking_list_nav_active" id="all">全部</li>
		    <li id="today">今日</li>
		    <li id="yesterday">昨日</li>
		    <li id="week">本周</li>
		    <li id="lastweek">上周</li>
		    <li id="month">本月</li>
		    <li id="lastmonth">上月</li>
		    <li id="year">本年</li>
		</ul>
		<span class="tribe_earnings_pay" id="total_rebate"></span>
	</div>

	<!-- 我的收益 列表 -->
	<div class="tribe_earnings_list" id="sort">
		<ul id="list">
		   
		    
		</ul>
	</div>

	


</div>

<script type="text/javascript">

    var time = 'all';

	$(".ranking_list_nav ul li").on("click",function(){
		time = $(this).attr('id');
		$(this).addClass("ranking_list_nav_active ").siblings().removeClass("ranking_list_nav_active ");
		$('#list').empty();
		page = 1;//默认加载页数
		j = 1;//初始化
		 // 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();
        
	})
	
    	var page = 1;//默认加载页数
	    var j = 1;
    	//下拉加载数据
    	dropload = $('#sort').dropload({
    		scrollArea : window,
    	    loadDownFn : function(me){
        	    //加载菜单一的数据
        		$.ajax({ 
        		    url:'<?php echo site_url('Member/Info/My_Profit_Data')?>',
        		    type:'post',
        		    dataType:'json',
        		    data:{'page':page,'time':time},
        		    success:function(data)
        		    {
            		    //选项收益总额。
            		    if( page == 1)
            		    {
                		    var total_rebate = data.total_rebate ? data.total_rebate : 0
                		    $('#total_rebate').html('已收益: '+total_rebate+'元');
            		    }
            		    //如果自己有排名
      		    	    var html = '';
        		    	if(data.list.length>0)
        		    	{
            		    	for(var i =0;i<data.list.length; i++)
            		    	{
                		    	
                		    	html += ' <li> '
            		    		html += ' <p class="tribe_earnings_text01"><span class="earnings_text01">'+data.list[i].corporation_name+'</span><span class="earnings_text02">+'+data.list[i].rebate+' 元</span><span class="earnings_text03">'+data.list[i].total_price+'元</span></p>'
                			    html += ' <p class="tribe_earnings_text02"><span class="earnings_text04">'+data.list[i].create_date+'</span><span class="earnings_text05">手续费分成</span><span class="earnings_text06">服务总费</span></p>'	
                			    html += ' </li>';	
            		    	}
           		    	    page++;
       	 			        $('#list').append(html); 
        				    
    	                    me.resetload();
        			    }else{
        				    
        			    	//锁定
        	                me.lock();
        	                // 无数据
        	                me.noData();
        	                me.resetload();
        			    }
        			},
        		    error:function(){
            		    
            		    //锁定
    	                me.lock();
    	                // 无数据
    	                me.noData();
    	                me.resetload();
        		    },
        		    
        		})
        
        	}
    	});
</script>