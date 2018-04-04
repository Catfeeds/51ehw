
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!--企业订单查询开始-->
   <div class="order_query">
   <!--搜索框-->
     <div class="order_query_top">
        <div class="order_query_top_left">
           <span class="icon-search"></span>
           <form onsubmit="return sift_search()" action="#" >
               <input type="search" value="" placeholder="输入订单编号" name="order_sn">
           </form>
        </div>
     </div>
     <!--搜索框-->  
     
    <div class="order_query_sh">
       <div class="order_query_sh_left"><a href="#"><img src="<?php echo isset($corp_info['img_url']) ? IMAGE_URL.$corp_info['img_url']:'images/51_logo.png' ?>" onerror="this.src='images/51_logo.png'"/></a></div>
       <div class="order_query_sh_right">
         <h2><a href="#"><?php echo isset($corp_info) ? $corp_info['corporation_name'] : ''?></a><span>加盟时间：<?php echo  !empty($corp_info['approval_date']) ? date('Y-m-d',strtotime($corp_info['approval_date'] ) ) : ''?></span></h2>
         <ul class="order_query_ul">
         <?php foreach ( $identity_info['rebaterate_description'] as $v ){ if( $v['name'] != '合伙金') {?>
          <li><a href="javascript:void(0);"><p class="order_query_ul_left"><?php echo $v['name']?></p><p class="order_query_ul_right"><?php echo is_numeric( $v['rebaterate'] ) ? $v['rebaterate'].'%' : $v['rebaterate'] ?></p></a></li>
<!--           <li class="on"><a href="javascript:void(0);"><p class="order_query_ul_left">手续费收入</p><p class="order_query_ul_right">16%</p></a></li> -->
         <?php } }?>
         </ul>
       </div>
    </div>
   
   <div class="order_shijian">
     <div class="order_shijian_left">订单时间段：</div>
      <div class="order_shijian_zhong">
       <input onclick="WdatePicker()" id="effectdate" name="start_time" value="" placeholder="请选择时间" readonly="" class="order_shijian_zhong_in">
        <span class="order_shijian_zhong_span">--</span>
       <input onclick="WdatePicker()" id="receiptdate" name="end_time" value="" placeholder="请选择时间" readonly="" class="order_shijian_zhong_in">
      </div>
     <a href="javascript:;" class="order_shijian_zhong_a" onclick="sift_search(1)">搜索</a>
   </div>
   
     <div class="order_wei" id="content">
       <div class="order_wei_top" style="display:block;">
       <dl class="order_wei_dl">
         <dd>订单编号</dd>
         <dd>角色</dd>
         <dd>分成比例</dd>
         <dd>分成小计</dd>
       </dl>
       <ul class="order_wei_ul" id="list">
          
       </ul>
       </div>
     </div>
   </div>
  
  <div class="order_query_di">
    <a href="javascript:void(0);">总计分成收益</a>
    <a href="javascript:void(0);">¥ <?php echo $total_rebate ? $total_rebate : 0;?></a>
  </div>
  
<!--企业订单查询结束-->
<script>

<!--点击切换-->
$(function(){
	var l=0;
// 	$('.order_query_ul li').hover(function(){
// 		$(this).siblings().removeClass('on');
// 		$(this).addClass('on');
// 		var i=$(this).index();	
// 		var index = $(".order_query_ul li").index($(this));
// 		$(".order_wei_top").hide();
// 		$(".order_wei_top").eq(index).show();
// 	});	

})

	var page = 1;
	var order_sn = '';
	var start_time = $('input[name=start_time]').val();
	var end_time = $('input[name=end_time]').val();

	
    function sift_search(type)
    { 
        
    	document.activeElement.blur();
    	order_sn = $('input[name=order_sn]').val();
    	start_time = $('input[name=start_time]').val();
    	end_time = $('input[name=end_time]').val();

    	if( start_time && end_time )
        { 
    		if ( start_time > end_time )
            { 
            	$(".black_feds").text('开始时间不能大于结束时间').show();
        		setTimeout("prompt();", 2000); 
        		return;
            }
           
        }
        
    	$('#list').empty();
    	page = 1;//默认加载页数
    	
    	 // 解锁
        dropload.unlock();
        dropload.noData(false);
        // 重置
        dropload.resetload();

        return false;
    }
   
	dropload = $('#content').dropload({
		 scrollArea : window,
		 loadDownFn : function(me){
			 $.post("<?php echo site_url("Income/My_Income_Detail");?>",{page:page,start_time:start_time,end_time:end_time,order_sn:order_sn,obj_id:'<?php echo $obj_id?>'},function(data){
				 	
					if(data.data.list.length>0)
					{
						 var list = data.data.list;
						 var result = '';
						 
						 for(var i=0;i<list.length;i++)
	    				 {
		    				 
		    				 var r = list[i].rebaterate *100;

		    				
		    				 r = r.toFixed(0);
		    				 
// 		    				 if( r.indexOf(".") > -1 )
// 		    				 { 
// 		    					 r = r.replace('.','');
// 		    				 }
		    				 
		    				
						     result += '<li><a href='+'<?php echo site_url('Income/Order_Detail') ?>'+'/'+list[i].order_sn+'>';
	    					 result += '<dl class="order_wei_ul_dl">';
	    					 result += '<dd><h6>'+list[i].order_sn+'</h6><p>'+list[i].create_date+'</p></dd>';
                 			 result += '<dd>'+list[i].name+'</dd>';
	    					 result += '<dd><h6>'+r+'%</h6></dd>';
	    					 result += '<dd>¥ '+list[i].rebate+'</dd>';
	    					 result += '</dl>';
	    					 result += '</a></li> ';
	    				 }
	    
	    				 $('#list').append(result);
	          			  page++;
	                      me.resetload();
	                      
				     }else{
					     
	    				 // 锁定
	                     me.lock();
	                     // 无数据
	                     me.noData();
	                     me.resetload();
					 }
			 },'json');
		 }
	});
	
		



</script>