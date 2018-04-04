<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->

<style type="text/css">
	.container {background:#f6f6f6;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
    <div class="search-header-top">
  		<a href="javascript:history.back()" class="icon-right"></a><span>排行榜</span>
	</div>
<?php }?>
<!-- 互助金额排行榜 -->
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
	</div>
	<!-- 列表 -->
		<div class="ranking_list_box" id="sort">
			<ul class="ranking_list_head">
			    <li>排名</li>
			    <li>姓名</li>
			    <li>企业名称</li>
			    <li><?php echo $name?></li>
			</ul>
			<ul class="ranking_list_main" id="list">
<!-- 			    <li><span>32</span><span>本人昵称</span><span>二哈征服世界集团</span><span>122</span></li> -->
<!-- 			    <li><span class="ranking_list01">1</span><span>柯基</span><span>柯基集团</span><span>654</span></li> -->
<!-- 			    <li><span class="ranking_list02">2</span><span>越狱兔</span><span>越狱集团</span><span>598</span></li> -->
<!-- 			    <li><span class="ranking_list03">3</span><span>加菲</span><span>千层面</span><span>654</span></li> -->
<!-- 			    <li><span>4</span><span>越狱兔</span><span>越狱集团</span><span>598</span></li> -->
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
        		    url:'<?php echo site_url('Tribe/Ranking_List')?>',
        		    type:'post',
        		    dataType:'json',
        		    data:{'type':'<?php echo $type?>','page':page,'time':time,'tribe_id':'<?php echo $tribe_id?>'},
        		    success:function(data)
        		    {
            		    //如果自己有排名
      		    	    if( data.user_info )
      		    	    {
//           		    	    alert(data.user_info.position); 
      		    	    	var my_html = '';
        		    	    my_html += '<li style="color: #ff7c00;"><span>'+data.user_info.position+'</span>'
       	 			        my_html += '<span>'+(data.user_info.real_name ? data.user_info.real_name : data.user_info.member_name)+'</span><span>'+(data.user_info.corporation_name ? data.user_info.corporation_name : '')+'</span><span>'+data.user_info.total+'</span></li>';

               	 			$('#list').append(my_html); 
               	 			
      		    	    }            		    
            		    if( data.list.length > 0 )
        			    {//列表中有自己

            		    	var html = '';
            		    	for( var i=0; i<data.list.length;i++)
       	 			        {
           	 			        html += '<li><span class="ranking_list0'+j+'">'+j+'</span>'
           	 			        html += '<span>'+(data.list[i].real_name ? data.list[i].real_name :data.list[i].member_name )+'</span><span>'+(data.list[i].corporation_name ? data.list[i].corporation_name : '')+'</span><span>'+data.list[i].total+'</span></li>';
                   	 			
             	 			    j++;
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