<style type="text/css">
.tribe_my_share_list {min-height: auto;}
.tribe_my_share_list {padding: 0;}
.tribe_my_share {margin: 0 15px;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- 我的分享 -->
<div class="tribe_my_share">
    <div id="list" class="tribe_my_share_list" style="margin-bottom: 55px;">
        <ul >
        <?php if(isset($list) && count($list) >0){ 
           foreach ($list as $key =>$val ){
            ?> 
             <li>
                <a href="<?php echo site_url('Activity/Tribe_package/share_detail').'/'.$val['id'];?>">
                  <div class="tribe_my_share_title"><span><?php echo $val['title']; ?></span></div>
                  <div class="tribal_my_share_text">
                    <div class="tribal_my_share_box"><span><?php echo $val['desc']; ?></span></div>
                    <img src="images/tirbe_share_left.png" alt="">
                    <span class="icon-right tribe_my_share_go"></span>
                  </div>
                </a>
             </li>
          <?php } }?> 

        </ul>
    </div>   
    <!-- 新建分享链接 -->

   <a href="<?php echo site_url("Activity/Tribe_package/share_create")?>"  class="new_package_details_save">新建分享链接</a>



</div>



<script type="text/javascript">
var page = 1;
dropload = $('#contentop').dropload({
	 scrollArea : window,
	 loadDownFn : function(me){
		 $.post("<?php echo site_url("Activity/Tribe_package/ajax_share_list");?>",{page:page},function(data){
				if(data.List.length>0){
					 var result = '';
					 for(var i=0;i<data.List.length;i++){
						 var url = '<?php echo site_url('Activity/Tribe_package/share_detail');?>/'+data.List[i]['id'];
						 result += '<li>';
						 result += '<a href="'+url+'">';
						 result += '<div class="tribe_my_share_title"><span>'+data.List[i]['title']+'</span></div>';
						 result += '<div class="tribal_my_share_text">';
						 result += '<img src="images/tirbe_share_left.png" alt="">';
						 result += '<div class="tribal_my_share_box"><span>'+data.List[i]['desc']+'</span></div>';
						 result += '<span class="icon-right tribe_my_share_go"></span>';
						 result += '</div>';
						 result += '</a>';
						 result += '</li>';
						 }

					 $('#list').find("ul").append(result);
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



