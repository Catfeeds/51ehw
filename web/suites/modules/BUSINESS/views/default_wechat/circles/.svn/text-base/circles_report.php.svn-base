

 <style>
   body{background: #f6f6f6;}
 </style>
 <?php  $mac_type = $this->session->userdata("mac_type");
 if(isset($mac_type) && $mac_type =='APP' ){?>
     <div class="header new_index_nav" name="top" >
        <a href="javascript:history.back()" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
        <p class="title">举报</p>
  	</div>
  <?php }?>
  <!--header end-->
  <div class="container container_topd" 
  <?php 
  $mac_type = $this->session->userdata("mac_type");
  if($mac_type){ 
      echo 'style="margin-top: 50px;"';
  }?>
  >
      <div class="report_top">
         <ul class="report_top_ul" id="shouhou">
             <li class="on"><i class="icon-choose"></i>欺诈</li> 
             <li><i class="icon-choose icon-not_choose"></i>色情</li> 
             <li><i class="icon-choose icon-not_choose"></i>违法犯罪</li> 
             <li><i class="icon-choose icon-not_choose"></i>不实信息</li> 
             <li><i class="icon-choose icon-not_choose"></i>未经授权的文章内容</li> 
             <li><i class="icon-choose icon-not_choose"></i>侵权(冒充他人，侵犯名誉等)</li>   
         </ul> 
         <div class="report_top_ul_tt" onclick='report_sub();'>
             举报
       </div>
      </div>     
  </div>


<script>
var message = '欺诈';

 $(".report_top_ul li").on("click",function()
 {
	  
	  $(this).addClass("on").siblings().removeClass("on");
	  $(this).find("i").removeClass("icon-not_choose").parent().siblings().find("i").addClass("icon-not_choose");
	  message = $(this).text();
})

function report_sub()
{ 

	 $('.report_top_ul_tt').removeAttr('onclick');
	 
	 $.ajax({ 
		url:'<?php echo site_url('Circles/Add_Complaints')?>',
		type:'post',
		dataType:'json',
		data:{'message':message,'id':<?php echo $obj_id?>,'tribe_id':<?php echo $tribe_id?>},
		success:function (data)
		{

			$(".black_feds").text( data.message ).show();
			setTimeout("prompt();", 2000);
			
			
			if( data.status )	
			{
				window.setTimeout("window.history.go(-1)", 1000);   
        		return;
			}

			$('.report_top_ul_tt').attr("onclick",'report_sub()');

		},
		error:function()
		{
			$(".black_feds").text( '举报失败' ).show();
			setTimeout("prompt();", 2000);
			$('.report_top_ul_tt').attr("onclick",'report_sub()');
		}
			
	})

	
}


</script>	
