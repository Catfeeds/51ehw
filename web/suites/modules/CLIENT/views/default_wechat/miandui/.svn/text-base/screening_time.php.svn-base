
<style type="text/css">
	.container {background-color: #fff!important;}
</style>


<div class="header" style="height:50px;">
           <div class="main_dui">
            <a href="javascript:history.back();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px; float:none; display:block;font-size: 20px;"></a>
            <div class="main_dui_top">
            <p class="title">筛选时间</p>
            </div>  
           </div> 
</div>
 
<div class="stored_value">
     <div class="screening_time">
      <input type="date"  id="datePicker" placeholder="请选择日期" class="time_text" value="">
      <div>至</div>
      <input type="date"  id="datePicker1" placeholder="请选择日期"class="time_text" value="">
    </div>  
</div>
<script>
		$(function(){
					$("#hear li").click(function(){
						$(this).css({
							borderBottom: "2px solid red",
							height:"43px"
						}).siblings().css({
							borderBottom: "none",
							height:"43px"
						});
					});					
						
					$("#hear li").click(function(){
						$(this).addClass("action").siblings().removeClass("action");
						var index = $(this).index();
						$("#contentop ul").eq(index).css("display","block").siblings().css("display","none");
					});
				});
</script>
<script>

$("#datePicker").on("input",function(){
   if($(this).val().length>0){
   $(this).addClass("full");
}
else{
  $(this).removeClass("full");
  }
 });
 
 $("#datePicker1").on("input",function(){
   if($(this).val().length>0){
   $(this).addClass("full");
}
else{
  $(this).removeClass("full");
  }
 });
</script>