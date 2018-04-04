<style type="text/css">
   .choice-labe-xuan {padding: 10px 20px;}
   .choice-labe-xuan-queding {display: inline-block;margin: 10px 0 0 0;background: #ffd600;padding: 5px 10px;border: 1px solid #ffd600;}
   .choice-labe-xuan-title {text-align: center;font-size: 15px;  }
   .choice-labe-xuan-title span{text-align: center;font-size: 15px; padding: 10px 0px; display: block;}
   .choice-labe-xuan span {height: 27px;line-height: 27px;border: 1px solid #ffd600;float: left;padding: 0 8px;background: #fff; margin-top: 2px; border-radius: 4px;margin: 10px;}
   .choice-labe-xuan-active {height: 27px;line-height: 27px;border: 1px solid #ffd600;float: left;padding: 0 8px;background: #ffd600!important; margin-top: 2px; border-radius: 4px;}
   #loadmore a span:hover{
	    background: #ffd600;
   }  
</style>

<!-- <div class="commodity_h50"></div> -->
<!--       <a href="javascript:void(0);" class="choice-labe-xuan-queding">确定</a> -->

      <div class="choice-labe-xuan-title">
      		<div id="loadmore">
          <?php if(count($Dictionary)>0){
              foreach ($Dictionary as $k =>$v){ ?>
                  <a href ="<?php echo site_url('member/requirement/add_Dictionarysession/'.$v['id']);?>"><span ><?php echo $v['name'];?></span></a>
            <?php  }
          }?>
      	  </div>
     	 <!-- 发送后提示 -->
         <ul id="load"><h5 class="jiazai" style="display:none;text-align:center;line-height:20px;color:#c3c3c3">加载中...</h5> </ul>
         <ul id="nomore"><h5 class="jiazai" style="display:none;text-align:center;line-height:20px;color:#c3c3c3">无更多数据</h5> </ul>
         <!-- 滚动分页判断执不执行 -->
         <input type="hidden" id="panduan" value="1">
      </div>

<!-- 分页 -->
<input type="hidden" id="limit" value="2">
<!-- nums做判断，防止一秒内多次获取相同数据-->
<input type="hidden" id="nums" value="0">
<!-- 条件判断 -->






<script type="text/javascript">
$(".choice-labe-xuan span").on("click",function(){
    $(this).addClass("choice-labe-xuan-active").siblings('').removeClass("choice-labe-xuan-active");
   })
$(window).scroll(function () {
	
	<?php if(isset($Dictionary) && count($Dictionary)>0){?>
    if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
        var limit = $('#limit').val();
        var nums = $('#nums').val();
	    if($('#panduan').val()==1){
		    if(nums != limit){
		    	onsearch(limit);
		    	$('#nums').val(limit);
			    }
            }
         if($('#panduan').val()==0){
        	 $('#nomore').children('h5').show();
        	 setTimeout(function(){
              	$('#nomore').children('h5').hide();
              },1200);
                    }
	    	
    }
    <?php }else{ ?>
    <?php }?>
});


function onsearch(limit){
    var page = 20;
    $.ajax({
        url:"<?php echo site_url('member/requirement/chioces') ?>",
        type:"post",
        data:{limit:limit,page:page},
        beforeSend:function(){
        	$('#load').children('h5').html("加载中...");
        	$('#load').children('h5').show();
        },
        success:function(data){
        	limit++;
        	var sorces = jQuery.parseJSON(data);
            var url = "<?php echo site_url('member/requirement/add_Dictionarysession').'/';?>";
            
            if( sorces.Dictionary.length>0){
                var html = '';
                for(var i=0;i<sorces.Dictionary.length;i++){
                	html += '<a href ="'+url+sorces['Dictionary'][i]["id"]+'"><span >'+sorces['Dictionary'][i]["name"]+'</span></a>';
                    }
                setTimeout(function(){
                	$('#panduan').val(1);
                	$('#load').children('h5').hide();
                	$('#limit').val(limit);
                	$('#loadmore').append(html);
                },500);
                
            }else{
            	$('#load').children('h5').hide();
            	$('#nomore').children('h5').show();
            	$('#panduan').val(0);
            	setTimeout(function(){
                	$('#nomore').children('h5').hide();
                },1000);
            }
        },
        error:function(){
        	$('#panduan').val(1);
        	$('#load').children('h5').html("加载失败！");
        	$('#load').children('h5').show();
        },
    });
    
}
   
   
   
</script>

