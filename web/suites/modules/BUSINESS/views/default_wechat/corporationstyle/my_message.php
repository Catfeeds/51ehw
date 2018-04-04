
<!--  <link rel="stylesheet" type="text/css" href="css/animate.css"> -->

 <style>
   body{background: #f6f6f6;}
   .my_news {
     margin-top: 0px; 
	}
 </style>
  <div class="container container_topd">
    <div class="my_news">
      <ul class="my_news_ul">
      <?php if(count($list)){;?>
      <?php foreach($list as $v){;?>
              <li>
               <a href="javascript:void(0);" class="go_topic">
               <input type="hidden" value="28">
               <div class="my_news_ul_li">
                 <span><img src="<?php echo $v["brief_avatar"]?IMAGE_URL.$v["brief_avatar"]:$v['wechat_avatar'];?>" onerror="this.src='images/member_defult.png'">  </span>
                <div class="my_news_ul_nei">
                  <h2><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $v['form_customer_id'] != -1 ? ($v['real_name'] ? $v['real_name'] : $v['member_name']): '五一易货网'?></font></font></h2><h2>
                  <?php echo $v['type'] !=2 ? $v['content'] : '<i class="icon-not_praise"></i>'?>                
                  <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo substr($v['created_at'],10,6)?></font></font></p>
                </h2></div> 
                <?php if(explode(';', trim( $v['images'],';' ))[0]){?>
                                    <span><img src="<?php echo IMAGE_URL.explode(';', trim( $v['images'],';' ))[0]?>"> </span>
                 <?php };?>
                 </div> 
               </a>
            </li>
            
       <?php };?>
       <?php }else{;?>
       <span><center style="margin-top: 50px">暂无消息</center></span>
       <?php };?>
              
    </ul>
    </div>     
  </div>
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
