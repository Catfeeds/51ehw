    <style>
    
    .cmRight{ padding-bottom:0}
	.cmRight_con.manage_fenlei_cmRight_con .showpage{ margin-top:30px;}
    </style>

    <div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
                <!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
                <li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
                <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>订单中心 </a></li>
                <li ><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
                <li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
                <li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户中心</a></li>
                <li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
                <!--<li><a href="#">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
                <li class="kehu_current"><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
                <!--<li><a href="#">在线客服</a></li>-->
                <!--<li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
            </ul>
            <ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
        </div>

		<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">消息提醒</div>
		
		
		 <form  action="<?php echo site_url('Member/Message');?>"  method="get" id="form_search">
		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			  <div class="members_b1">
               <div class="nice_top_xiao"> 
               <span class="maing_left">类别：</span>
				 <div class="nice-select1 nice-select_b" name="nice-select">
                   <input  type="text" placeholder="不限" value="<?php echo !empty($url_get['type'] ) && !empty($type_list["{$url_get['type']}"]) ? $type_list["{$url_get['type']}"] : ''?>" readonly dir="rtl">
                   
                   <input name="type" id="type" type="hidden"  value="<?php echo !empty( $url_get['type'] ) ? $url_get['type'] : '' ?>" >
                        <ul>
                            <?php foreach ( $type_list as $k=>$v):?>
                                <li data-value="<?php echo $k ?>" class="type"><?php echo $v?></li>
<!--                                 <li data-value="1" class="type">系统通知</li> -->
<!--                                 <li data-value="2" class="type">订单通知</li> -->
<!--                                 <li data-value="3" class="type">我的资产</li> -->
<!--                                 <li data-value="4" class="type">部落通知</li> -->
                            <?php endforeach;?>
                        </ul>
                      </div>
                      <span>发送时间：</span>
                      <div class="nice-select1 nice-select_b" name="nice-select">
                   <input type="text" placeholder="不限" value="<?php echo !empty($url_get['time'] ) && !empty($time_list["{$url_get['time']}"]) ? $time_list["{$url_get['time']}"] : ''?>" readonly dir="rtl">
                   <input name="time" id="time" type="hidden"  value="<?php echo !empty( $url_get['time'] ) ? $url_get['time'] : '' ?>" >
                        <ul>
                          <li data-value="" class="time">不限</li>
                          <li data-value="1" class="time">一个星期</li>
                          <li data-value="2" class="time">一个月</li>
                          <li data-value="3" class="time">半年</li>
                        </ul>
                      </div>
                 </div>
                 <span class="zhutid">关键字：</span>
              <input  type="text" class="members_inl" name="search_name" value="<?php echo !empty($url_get['search_name']) ? $url_get['search_name'] : ''?>" placeholder="类别搜索">
              <a class="members_inl_b" href="javascript:;" onclick="submit();">查询</a>
              </div>
                <div class="select2 select_gf">
              <div class="haudong_top1">   
              
                <ul class="reminder_top_ul">
                     <h3>所有消息<span>(共<p id="total_num"><?php echo $total_num?><p>条，未读信息<p id="not_read_num"><?php echo $not_read_num?></p>条)</span></h3>
                        <li class="reminder_top_ul_top">
                      <dl>
                        <dd class="reminder_top_ul_dd10"><input type="checkbox" flag="All_Choose" onclick="All_Choose(this)"><span>全选</span></dd>
                        <dd class="reminder_top_ul_dd20">类别</dd>
                        <dd class="reminder_top_ul_dd40">主题</dd>
                        <dd class="reminder_top_ul_dd20">时间</dd>
                        <dd class="reminder_top_ul_dd10"><span class="mrijik">操作</span></dd>
                      </dl>
                     </li>

                     
                     	<?php if( $list ):?>
                     	<?php foreach ( $list as $k=>$v):?>
                         <li style="<?php echo $v['is_read'] == 1 ? 'background:#fff;' : 'background:#fafafa;' ?>" id="list_message_<?php echo $v['id']?>">
                          <dl>
                          	<input tyep="hidden" value="<?php echo $v['id']?>" >
                            <dd class="reminder_top_ul_dd10"><input type="checkbox" flag="message_list" onclick="" value="<?php echo $v['id']?>"></dd>
                            <dd class="reminder_top_ul_dd20 baincund">
                            <?php echo $v['is_read'] == 1 ? '<span style="margin-right:10px;"></span>' : '<span class="hongdian"></span>'?><?php echo $v['title']?>
                            <b class="icon-ananzuiconv265"></b><b class="icon-xiangshangjiantou" hidden></b></dd>
                            <dd class="reminder_top_ul_dd40"><?php echo $v['message']?></dd>
                            <dd class="reminder_top_ul_dd20"><?php echo $v['created_at']?></dd>
                            <dd class="reminder_top_ul_dd10"><a href="javascript:;" onclick="del_message(<?php echo $v['id']?>)">删除</a></dd>
                          </dl>
                           <div class="reminder_top_ul_div" hidden>
                            
                            <p> <?php echo $v['message']?></p>
                            <h6><?php echo $v['created_at']?></h6>
                            </div>
                         </li>
                         <?php endforeach;?>
                    
                     <?php else:?>
                     <!-- 没有消息 -->
                     <!--没有消息-->
            <div class="reminder_xia">
               <p>暂时没有收到消息</p>
            </div>

                     <?php endif;?>
                     <li class="reminder_top_ul_bottom">
                      
                       <span>全选</span>
                       <input type="checkbox"  flag="All_Choose" onclick="All_Choose(this)">
                       <a href="javascript:del_message()" >删除</a>
                     </li>
                     
                </ul>
              
				<!--<table width="910" border="1" cellpadding="0" cellspacing="0" class="reminder_top">
        <tbody>
          <tr class="reminder_top_nei">
            <th width="50px"><input type="checkbox" flag="" onclick=""></th>
            <th width="50px">类别</th>
            <th width="200px">主题</th>
            <th width="50px">时间</th>
            <th width="50px">操作</th>
          </tr>
          <tr class="reminder_top_xia">
            <th width="50px"><input type="checkbox" flag="" onclick=""></th>
            <th width="50px">互助部落</th>
            <th width="200px">已加入西北狼部落成功</th>
            <th width="50px">2017-05-17</th>
            <th width="50px"><a href="#">删除</a></th>
          </tr>
          
        <tr class="reminder_top_xia">
            <th width="50px"><input type="checkbox" flag="" onclick=""></th>
            <th width="50px">互助部落</th>
            <th width="200px">已加入西北狼部落成功</th>
            <th width="50px">2017-05-17</th>
            <th width="50px"><a href="#">删除</a></th>
          </tr>
          <tr class="reminder_top_xia">
            <th width="50px"><input type="checkbox" flag="" onclick=""></th>
            <th width="50px">订单状态</th>
            <th width="200px">你的订单：002879112145444已发货 </th>
            <th width="50px">2017-05-17</th>
            <th width="50px"><a href="#">删除</a></th> 
          </tr>
         <tr class="reminder_top_xia">
            <th width="50px"><input type="checkbox" flag="" onclick=""></th>
            <th width="50px">互助部落</th>
            <th width="200px">已加入西北狼部落成功</th>
            <th width="50px">2017-05-17</th>
            <th width="50px"><a href="#">删除</a></th>
          </tr>
          
        </tbody>
        </table>-->
                     </div>     
                    
			
                      
                    <div class="showpage" id="showpage">
                    	<?php echo $page;?>
                    </div>
                                        
			</div>
		</div>
		 </form>
        
	</div>

 	

    </div>

    
    	 <!--弹窗开始-->
     	<!--弹窗--><!--
<div class="dingdan4_3_tanchuang" style="display:block">
    <div class="dingdan4_3_tanchuang_con shouhuo_tanchuang_con">
        <div class="dingdan4_3_tanchuang_top2 shouhuo_tanchuang_top2">
            <p>点击确定后,您之前付款到易货网的 3000.00 元将直接到商家的帐户里,请务必收到货再确认!</p>
        </div>
        <div class="dingdan4_3_tanchuang_btn">
        	<div class="dingdan4_3_btn01 shouhuo_quxiao_btn"><a href="#">取消</a></div>
            <div class="dingdan4_3_btn02"><a href="#">确定</a></div>
        </div>
        
    </div>
</div>-->
     <!--弹窗结束-->
     
<script>
function submit(){
	$('#form_search').submit();
}
$('[name="nice-select"]').click(function(e){
	$('[name="nice-select"]').find('ul').hide();
	$(this).find('ul').show();
	e.stopPropagation();
});
$('[name="nice-select"] li').hover(function(e){
	$(this).toggleClass('on');
	e.stopPropagation();
});
$('[name="nice-select"] li').click(function(e){
	
	var val = $(this).text();
	
	var dataVal = $(this).attr("data-value");
	
	//判断选择了什么。
	if( $(this).hasClass('type') )
	{ 
		$('#type').val(dataVal);
	}else{ 
		$('#time').val(dataVal);
	}
// 	$(this).addClass('bg-color').siblings().removeClass('bg-color');
	 /*$(this).addClass("on").siblings("on").removeClass("on");*/
// 	$(this).parents('[name="nice-select"]').find('input').val(val);
	$('[name="nice-select"] ul').hide();
	e.stopPropagation();
	$('#form_search').submit();
});
$(document).click(function(){
	$('[name="nice-select"] ul').hide();
	
});

function del_message( id )
{ 
	
	ids = [];
	
	if( id )
	{
		ids.push( id );
	}else{
	
    	$('input[type=checkbox][flag=message_list]:checked').each(function()
    	{ 
    		ids.push($(this).val()); 
    		
    	}); 
	}
	if( ids.length == 0 )
	{
		alert('请选择需要删除的消息'); 
		return;
	}

	$.ajax
	({ 
		url:'<?php echo site_url('Member/Message/Del_Message')?>',
		type:'post',
		dataType:'json',
		data:{'ids':ids},
		success:function( data )
		{ 
			if( data.status )
			{
				 location.reload();
// 				var not_read_num = 0;
// 				//删除
// 				for(var i=0 ;i<ids.length;i++)
// 				{
		            
					
// 					if( $('#list_message_'+ids[i]).children('dl').children('.baincund').find('span').hasClass('hongdian') )
// 					{
// 						not_read_num++;
// 					}
// 					$('#list_message_'+ids[i]).remove();
// 				}

// 				var not_read_num = parseInt($('#not_read_num').text()) - not_read_num;
// 		        var total_num = parseInt($('#total_num').text()) - ids.length ;
		        
// 		        $('#total_num').text( total_num )
// 		        $('#not_read_num').text( not_read_num )

		        
		        

// 		        if( total_num <= 0 )
// 		        {
// 			        alert(123);
// 			         $('.reminder_top_ul_bottom').remove();
// 		        }
				
			}else{
				alert('删除失败'); 
			}
		},
		error:function()
		{
			alert('删除失败');
		}
	})
	
}

function All_Choose( obj )
{
	if( obj.checked )
	{
		$('input[type=checkbox]').prop("checked",true);
		return;
	}
	$('input[type=checkbox]').prop("checked",false);
}

$('input[type=checkbox][flag=message_list]').click(function()
{ 
	if( !$(this).prop('checked') && $('input[type=checkbox][flag="All_Choose"]').prop('checked') )
	{ 
		$('input[type=checkbox][flag="All_Choose"]').prop("checked",false);
	}
}); 

</script>
    
  <script>
  $(function(){
	  
	$('.baincund').click(function(e){//给d1绑定一个点击事件;
	
       if($(this).parent('dl').next('.reminder_top_ul_div').is(':hidden'))
       {
	       $(this).parent('dl').next('.reminder_top_ul_div').show();
           $(this).find('.icon-ananzuiconv265').hide(); 
           $(this).find('.icon-xiangshangjiantou').show();   

           if( $(this).find('span').hasClass('hongdian') )    
           {
               var hong = $(this).find('span');
               id =  $(this).parent('dl').children('input').val();
               $.ajax
           	   ({ 
           	       url:'<?php echo site_url('Member/Message/Read')?>'+'/'+id,
           		   type:'get',
           		   dataType:'json',
           		   success:function(data)
           		   {
               		   if( data.status )
               		   {
                   		   $(hong).removeClass('hongdian');
               		       $(hong).css('margin-right','10px');
               		       $(hong).parent().parent().parent('li').css('background','#fff');
						   var not_read_num = parseInt($('#not_read_num').text());
						   not_read_num = not_read_num - 1;
						   $('#not_read_num').text( not_read_num );
						   
						   if( not_read_num != 0 )
						   {
							   $('#head_not_read').text( not_read_num );
							   
						   }else{
						       $('#youjian').remove();
						   }
               		       
               		   }
           		   },
           		   error:function(){}
           	   })
           }
       }else{
    	   $(this).parent('dl').next('.reminder_top_ul_div').hide();
           $(this).find('.icon-ananzuiconv265').show(); 
		   $(this).find('.icon-xiangshangjiantou').hide(); 
       }
                
 });
});
  </script>  
   
