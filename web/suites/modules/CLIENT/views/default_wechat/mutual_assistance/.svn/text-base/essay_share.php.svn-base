<style type="text/css">
    .container {background:#F1F1F1;}
	.essay_nav_search {padding-top: 10px;margin-left:0px;background: #fff;
    padding-bottom: 10px;}
	.essay_nav_search p {background-color: #fff;width:90%;border:1px solid #8F8F8F;border-radius:3px;margin:-2px auto;padding-left:10px;}
	.essay_nav_search p a {color:#ACACAC;font-size:15px;}
	.search_input {width:85%;color:#606060;height:34px;background-color: #fff;border: none;font-size: 15px;}
</style>


<!-- 搜索框 -->
<form action="<?php echo site_url('article');?>" method="get" id="form_search" onsubmit="check_form();" style="position: fixed;width: 100%;z-index: 999;">
    <div class="essay_nav_search">
        <p>
         <a href="javascript:void(0);" class="icon-sousuo"></a>
         <input class="search_input" type="text" name="search_index" value="" placeholder="搜索您想找的好文" required="">
         <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;">
         <img src="images/search_close.png" height="15" width="15" alt=""></a>
        </p>              
    </div>
</form>

<!-- 好文列表 -->
<div class="essay_share search_res">
	<ul id="loadmore">
	<?php if(isset($list) &&  count($list) > 0){?>
	<?php foreach ($list as $key =>$val){?>
	    <li>
	        <a href="<?php echo site_url('shop/skipping').'?id='.$val['id'].'&type='.base64_encode(1).'&parent='.$parent.'&mark='.base64_encode(2);?>">
	    	<p>
	    	  <span class="essay_share_title"><?php echo $val['title']?></span>
	          <span class="essay_share_text"><i>分享<?php echo $val['share_times'];?>次</i><i class="essay_share_pl10">阅读<?php echo $val['read_times'];?>次</i><i class="essay_share_pl10"><?php echo $val['create_at'];?></i></span>	
	    	</p>
	        <img src="<?php echo IMAGE_URL.$val['logo']?>" onerror="this.src='images/default_img_s.jpg'">
	        <?php if($val['status'] != 0){ ?>
	            <img src="images/haowen.png" onerror="this.src='images/default_img_s.jpg'" class="essay_share_over">
	        <?php }?>
	    	
	    	</a>
	    </li>
	 <?php } }else{?>
	   <li class=" clearfix" style="text-align:center;padding-top: 60px;color:#999;border:none;">
        <span class="icon-chakandingdan" style="font-size: 100px;"></span><br>
        <span style="display: inline-block;padding-top: 20px;font-size: 15px;">抱歉，暂时还没有好文哦！</span>
       </li>   
	 <?php }?>  
	</ul>
    <!-- 发送后提示 -->
     <ul id="load"><h5 class="jiazai" style="display:none;text-align:center;line-height:20px;color:#c3c3c3">加载中...</h5> </ul>
    <!-- 滚动分页判断执不执行 -->
    <input type="hidden" id="gundong" value="1">
</div>
<!-- 分页 -->
<input type="hidden" id="page" value="2">
<input type="hidden" id="limit" value="12">
<script type="text/javascript">
//监控滚动方法
$(window).scroll(function () {
    <?php if(isset($list) && count($list)>0): ?>
    if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
        var page = $('#page').val();
        var search = $("input[name='search_index']").val();
        
        if($('#gundong').val()==1){
            $('#gundong').val(0);
            onsearch(search,page);
        }
    }
    <?php endif; ?>
});


//滚动分页查询
function onsearch(search_index,page){
    var limit = $('#limit').val();
    $.ajax({
        url:"<?php echo site_url('Article') ?>",
        type:"post",
        data:{keyword:search_index,limit:limit,page:page},
        beforeSend:function(){
        	$('#load').children('h5').html("加载中...");
        	$('#load').children('h5').show();
        },
        success:function(data){
        	page++;
            $('#page').val(page);
            var data = jQuery.parseJSON(data);
            
            if( data.list.length>0){
            	var errorimg= "this.src='images/default_img_s.jpg'";
                var html = '';
                for(var i=0;i<data.list.length;i++){
                	var img = "<?php echo IMAGE_URL; ?>"+data['list'][i]['logo'];
                	var url ="<?php echo site_url("shop/skipping");?>?id="+data["list"][i]["id"]+"&type=<?php echo base64_encode(1);?>&parent=<?php echo $parent?>&mark=<?php echo base64_encode(2);?>"; 
                    html += '<li><a href="'+url+'"><p><span class="essay_share_title">'+data["list"][i]["title"]+'</span><span class="essay_share_text"><i>分享'+data["list"][i]["share_times"]+'次</i><i class="essay_share_pl10">阅读'+data["list"][i]["read_times"]+'次</i><i class="essay_share_pl10">'+data["list"][i]["create_at"]+'</i></span></p><img src="'+img+'" onerror='+errorimg+'>';
                    if(data["list"][i]["status"] != 0){
                        html +=  '<img src="images/haowen.png" onerror='+errorimg+' class="essay_share_over">'  ;
                    }    
                    html += '</a></li>';
                    }
                setTimeout(function(){
                	$('#gundong').val(1);
                	$('#load').children('h5').hide();
                	$('#limit').val(limit);
                	$('#loadmore').append(html);
                },500);
                
            }else{
            	html ='<li class=" clearfix" style="text-align:center;">无更多好文</li>';
            	setTimeout(function(){
                	$('#load').children('h5').hide();
                	$('#loadmore').append(html);
                },500);
            }
        },
        error:function(){
        	$('#gundong').val(1);
        	$('#load').children('h5').html("加载失败！");
        	$('#load').children('h5').show();
        },
    });
    
}
</script>
