<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<div class="commerce_index" style="padding-bottom:0px;">
	  <div class="commerce_directory">
	   <form action="<?php echo site_url("Commerce/search_tribe").'/'.$label_id;?>" method="post"  onsubmit="return form_submit()" target="nm_iframe">
       <!-- 搜索会员 -->
       <div class="commerce_directory_search">
          <label>
            <p><span class="icon-search"></span><input type="text" placeholder="请输入商会名称" id="word" value=""></p>
          </label>
       </div>
        </form>
       </div>
   <iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe>  
	<div class="recommended_tribe prominent_commerce_box" id="search">
		<ul class="recommended_tribe_top" >
			
		</ul>
	</div> 
</div>       

<script>
var search = false;
var word = '';
var page = 1;//默认加载页数
dropload = $('#search').dropload({
	 scrollArea : window,
 	 loadDownFn : function(me){
 	 	 if(search){
 	 		  var result = "";
 	 		  var error_img = "this.src='images/tmp_logo.jpg'";
	  	      $.post("<?php echo site_url("Commerce/ajax_search_tribe");?>",{id:<?php echo $label_id?>,param:word,page,page},function(data){
    	  	    	 if(data["list"].length > 0){
    	  	    		 for(var i=0;i<data["list"].length;i++){
        	  	    		var link = '<?php echo site_url("Tribe/Home");?>/'+data["list"][i]['id']+'<?php echo '/'.$label_id?>';
        	  	    		var img  = '<?php echo IMAGE_URL;?>'+data["list"][i]['logo'];  
     	  	    			result += "<li>";
     	  	    			result += "<a href='"+link+"'>";
     	  	    			result += "<i><img src='"+img+"' onerror="+error_img+"></i>";
     	  	    			result += "<div class='recommended_tribe_rigth'>";
     	  	    			result += "<div class='tribal_index_zhiding'>";
     	  	    			result += "<h2>"+data["list"][i]['name']+"</h2>";
     	  	    			result += "</div>";
     	  	    			result += "<div class='tribe_tuijian_box'>";
     	  	    			result += "<p>"+data["list"][i]['content']+"</p>";
     	  	    			result += "</div>";
     	  	    			result += "</div>";
     	  	    			result += "</a>";
     	  	    			result += "</li>";
        	  	    		 }
    	  	    		$('.recommended_tribe_top').append(result);
     	  	    		page++;
    	                me.resetload();
    	  	    	 }else{
        	  	    	 if(page == 1){
        	  	    		 // 锁定
              	              me.lock();
              	                // 无数据
              	              me.noData();
                              me.resetload();
                              $(".dropload-down").show();
                              $(".dropload-noData").text("搜索不到相关商会");
            	  	    	 
            	  	    	 }else{
                 	  	    	  // 锁定
                	              me.lock();
                	                // 无数据
                	              me.noData();
                                  me.resetload();
                                  $(".dropload-down").show();
                                  $(".dropload-noData").text("没有更多商会了");
                	  	    	 }
        	  	    	 }
		  	    },"json");
 	 	 	 }else{
 	 	 	 	// 锁定
  	            me.lock();
  	            // 无数据
  	            me.noData();
  	            me.resetload();
    	        $(".dropload-down").hide();
 	 	 	 	 }
	 	}
});


function form_submit(){
	word = $("#word").val();
	if(word){
		page = 1
		search = true;
		$(".recommended_tribe_top").empty();
		 // 解锁
	    dropload.unlock();
	    dropload.noData(false);
	    // 重置
	    dropload.resetload();
		}else{
			page = 1
			search = false;
			$(".recommended_tribe_top").empty();
			// 锁定
			dropload.lock();
            // 无数据
			dropload.noData();
			dropload.resetload();
			$(".dropload-down").hide();
			}
	return false;
}


</script>