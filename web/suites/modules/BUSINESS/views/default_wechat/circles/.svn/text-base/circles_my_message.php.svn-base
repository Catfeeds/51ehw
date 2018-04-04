
<!--  <link rel="stylesheet" type="text/css" href="css/animate.css"> -->

<?php
$mac_type = $this->session->userdata("mac_type");
if(!$mac_type){?>
<style>
.my_news{
margin-top:0px;	
}
</style>
<?php }?>
 <style>
   body{background: #f6f6f6;}
 </style>
  <div class="container container_topd">
    <div class="my_news">
    
      <ul class="my_news_ul">
  <?php  if( count( $list ) > 0 ) {
         foreach ( $list as $v ){?>
            <li>
               <a href="javascript:;" class="go_topic">
               <input type="hidden" value="<?php echo $v['obj_id']?>">
               <div class="my_news_ul_li">
                 <span><img src="<?php echo $v['wechat_avatar']?>"  onerror="this.src='images/member_defult.png'"/>  </span>
                <div class="my_news_ul_nei">
                  <h2><?php echo $v['form_customer_id'] != -1 ? ($v['real_name'] ? $v['real_name'] : $v['member_name']): '五一易货网'?><h2>
                  <input type="hidden" value="<?php echo $v['form_customer_id']?>" name ="form_customer_id">
                  <input type="hidden" value="<?php echo $v['content_obj_id']?>" name ="content_obj_id">
                  <?php echo $v['type'] !=2 ? $v['content'] : '<i class="icon-not_praise"></i>'?>
                  
                  <p><?php echo formatTime_($v['created_at'])?></p>
                
                </div> 
                <?php if( $v['images'] ){  ?>
                    <span><img src="<?php echo IMAGE_URL.explode(';', trim( $v['images'],';' ))[0]?>"/> </span>
                <?php }?>
              </div> 
               </a>
            </li>
        <?php } } else{?>
        
        
      </ul>
      
          <span><center>暂无消息</center></span>
          
      <?php } ?>
      
    </div>     
  </div>


    <!--通用底部滑出框-->     
     <div class="delete_pinglun" id="con" hidden>
        <div class="delete_nei">
          <ul>
              <li class="delete_nei_t">
              <a href="javascript:;">立即回复</a>
              </li>
              <li class="delete_nei_z">
              <!-- <a href="" onclick="" id="del_btn">发图文</a>-->
               <a href="javascript:;">查看详情</a>
             </li>
             <li class="delete_nei_b cancels">
              <a href="javascript:void(0);" onclick="$('#con').hide()">取消</a>
            </li>
          </ul>
        </div>
     </div>   
     
   <?php if( $status != 1 && count( $list ) > 0 ) {?>
   <!--底部清空-->
 	<div class="bottom_kong" onclick="del()"><i class="icon-shanchu"></i>清空</div>
   <?php }?>
 <!--修改背景颜色-->
 <script>
 $(function()
 {
	 
	 var tribe_id = <?php echo $tribe_id?>;
     var d = document.getElementById("leftTabBox");
     d.style.backgroundColor = "#f6f6f6";

    $('.go_topic').on("click",function()
    {
        if( $(this).find('input[name=form_customer_id]').val() == -1 )
            return;
        
		$('#con').show();
		var obj_id = $(this).children().val();
		$('.delete_nei_z').children('a').attr('href','<?php echo site_url('Circles/Topic_Detaile')?>/'+obj_id+'/?tribe_id='+tribe_id);
		if( $(this).find('i').length >0 )
			
		{
			$('.delete_nei_t').hide();
		}else{ 
// 			&to_name=朱八&parent_id=17&to_customer_id=2365
			var to_name = $(this).find('h2').eq(0).text();
			var to_customer_id = $(this).find('input[name=form_customer_id]').val();
			var content_obj_id = $(this).find('input[name=content_obj_id]').val();
			
			var url = '&to_name='+to_name+'&content_obj_id='+content_obj_id+'&to_customer_id='+to_customer_id+'';
			$('.delete_nei_t').children('a').attr('href','<?php echo site_url('Circles/Comment')?>/'+obj_id+'/?tribe_id='+tribe_id+url);
			
			$('.delete_nei_t').show();
		}
		
    });

   
 })
 
  function del()
  { 
        $.ajax({ 
            url:'<?php echo site_url('Circles/Delete_Message/?tribe_id='.$tribe_id)?>',
            type:'get',
            dataType:'json',
            success:function(data)
            {
                if(data.status)
                { 
                    $('.bottom_kong').remove();
                    $('.my_news_ul').empty();
                    $('.my_news').append('<span><center>暂无消息</center></span>');
                }
            	$(".black_feds").text(data.message).show();
            	setTimeout("prompt();", 2000); 
            
			},
            error:function()
            {
            	$(".black_feds").text('网络异常,请稍后再试').show();
            	setTimeout("prompt();", 2000); 
            }
        })
    }
 </script>
