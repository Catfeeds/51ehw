<style type="text/css">
    .container {background: #f8f8f8;}
    .search-header {background-color: #1A1A1A;height:50px;width:100%;text-align: center;color: #fff;line-height: 55px;}
    .search-header a {-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;position: absolute;left: 0;margin-left:10px;margin-top:18px;}
    .search-header span  { font-size: 14px;padding: 2px 15px;}
    .active_color {color:#ffd600;}
    .search_but {text-align: center;}
    .search_but a{color:#fed602;}
    .search_but a span {padding-right: 5px;}
</style>
 <!-- 搜索分类 -->
 <div id="box">
    <!-- 分类 -->
    <div class="needs_search_list"  id="gaine1">
      <div class="search-header">
          <a href="javascript:void(history.back())" class="icon-right"></a>
       <span>分类</span>
      </div>
      <div class="needs_list_search">
         <ul>
         <li class="search_but"><a href="<?php echo site_url("Member/requirement/all_demand")?>" ><span class="icon-fuli"></span>查询全部</a></li>
             <?php if(count($classify) > 0){
                    foreach ($classify as $key => $val){?>
                         <li><a href="javascript:void(0);" onclick="renascence('<?php echo $val['id'] ?>','<?php echo $val['level'] ?>','<?php echo $val['name'];?>');"><span><?php echo $val['name'];?></span></a></li>
             <?php }  }?>   
            
         </ul>
      </div>
    </div>

</div>

<script type="text/javascript">
  $(".needs_list_search ul li").on("click",function(){
      $(this).children('a').addClass('active_color');
      $(this).siblings('li').children('a').removeClass('active_color');
  })


function removebox(type){
	  var name = '#gaine'+type;
	  var type_num = parseInt(type)-1;
	  var box_id = '#gaine'+type_num;
	  if($(box_id).length>0){
		  <?php if(isset($page_type)){
		      ?>
		  $(name).hide();
		  <?php }else{?>
		  $(name).remove();
		  <?php }?>
		  $(box_id).show();
	  }else{
		  <?php if(isset($page_type)){
		      ?>
		  $(name).hide();
		  <?php }else{?>
		  $(name).remove();
		  <?php }?>
		  removebox(type_num); 
		  }
}
function choose(id,title){
	window.location.href = '<?php echo site_url("Member/requirement/spring_board?cate=")?>'+id+'&search_index='+title;
}  
  
function  renascence(id,type,name){
	  var search_id = id; 
	  var title = name;
	  var _title = "'"+name+"'";
	  var num = parseInt(type)+1;
	  var box_id = 'gaine'+num;
	  $.post("<?php echo site_url("Member/requirement/ajax_getlevel");?>",{id:id,type:type},function(data){
		  if(data.level.length > 0){
			  var result =  '';
			  result += '<div class="needs_search_list" id="'+box_id+'">';
			  result += '<div class="search-header">';
			  result += '<a href="javascript:void(0);" onclick="removebox('+num+');" class="icon-right"></a><span>'+title+'</span>';
			  result += '</div>';
			  result += '<div class="needs_list_search">';
			  result += '<ul>';
		      result += '<li class="search_but"><a href="javascript:void(0);" onclick="choose('+search_id+','+_title+');"><span class="icon-fuli"></span>查询全部</a></li>';
			  for(var i=0;i<data.level.length;i++){
				  var id = data.level[i]['id'];
				  var level = data.level[i]['level'];
				  var name = "'"+data.level[i]['name']+"'";
				  result += '<li><a href="javascript:renascence('+id+','+level+','+name+');"><span>'+data.level[i]['name']+'</span></a></li>';
				  }
			  result += '</ul>';
			  result += '</div>';
			  result += '</div>';
		      $("#box").append(result);
		      $("#box").find('.needs_search_list').hide();
		      $("#"+box_id).show();
		      //滑动
			  $('html, body').animate({scrollTop:0}, 'slow');
			  }else{
// 				  $(".black_feds").text("没有有更多的下级分类了").show();
// 	    			setTimeout("prompt();", 2000);
// 	    			return;
				  choose(search_id,title);
				  }
	  
	  },"json");
	  }


</script>




