
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->

<!--我的收益开始-->
   <div class="order_query">
   <!--搜索框-->
     <div class="order_query_top">
        <div class="order_query_top_left">
           <span class="icon-search"></span>
        <form onsubmit="return search()" action="#" >
        <input type="search" value="" placeholder="请输入企业名称" name='corporation_name'>
        
        </form>
        </div>
        <a href="<?php echo site_url('Member/Info/My_Profit')?>" style="color:#fff; font-size:15px;height: 32.5px; line-height: 32.5px; margin-left: 10px;">明细</a>
     </div>
    
    <div class="profit_top">您当前身份：<span><?php echo $identity_info['identity_name']?></span>。获取更高分成比例，<a href="<?php echo site_url('Income/Identity?level='.$identity_info['level'])?>" id="test">点击立即升级</a></div>
    
    
     <div class="order_wei" id="list">
       <div class="order_wei_top">
       <dl class="profit_wei_dl">
         <dd>企业名称</dd>
         <dd>分成总额</dd>
         <dd></dd>
       </dl>
       <ul class="profit_wei_ul">
          
       </ul>
       </div>
     </div>
   </div>
  
 
<!--我的收益结束-->



<script type="text/javascript">



var page = 1;
var corporation_name = '';

function search()
{ 
	document.activeElement.blur();
	corporation_name = $('input[name=corporation_name]').val();
	
	$('.profit_wei_ul').empty();
	page = 1;//默认加载页数
	
	 // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();
    
    return false;
}



dropload = $('#list').dropload({
	 scrollArea : window,
	 loadDownFn : function(me){
		 $.post("<?php echo site_url("Income/My_Income");?>",{page:page,corporation_name:corporation_name},function(data){
			 	
				if(data.data.list.length>0)
				{
					 var list = data.data.list;
					 var result = '';
					 for(var i=0;i<list.length;i++)
    				 {
						 var url = '<?php echo site_url('Income/Detail_List');?>/'+list[i]['customer_id'];
    					 result += '<li>';
    					 result += '<dl class="profit_wei_ul_dl">';
    					 result += '<dd style="line-height:36px;"><h6>'+list[i].corporation_name+'</h6><p></p></dd>';
    					 result += '<dd>¥ '+list[i].rebate+'</dd>';
    					 result += '<dd> <a href='+url+'><span></span><span></span><span></span></a></dd>';
    					 result += '</dl>';
    					 result += '</li> ';
    				 }
    
    				 $('.profit_wei_ul').append(result);
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


