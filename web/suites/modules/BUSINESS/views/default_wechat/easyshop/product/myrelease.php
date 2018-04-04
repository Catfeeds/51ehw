<style type="text/css">
	.container {background: #F6F6F6;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->

<!-- 我的发布 -->
<div class="myrelease">
   <div class="myrelease_list">
       <ul>
       </ul>
   </div> 
   <!-- 备注 -->
   <div class="myrelease_remarks"><span>备注：商品只能发布到一个部落，需要发布到平台请请联系客服开通正式企业，客服电话：</span><a href="tel:400-002-9777">400-002-9777</a></div>
</div>
<div class="myrelease_get"><a href="javascript:void(0);">发布商品</a></div>

<!-- 弹窗 -->
 <div class="tuichu_ball" hidden>
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>是否删除该产品？</span></div>
         <div class="tuichu_ball_button">
           <a href="javascript:cane(0);">取消</a>
           <a id = 'tuichu_sub' href="javascript:void();" >确定</a>
         </div>      
      </div>
   </div>
 </div> 
 
 
<!--订单加载 -->
<script type="text/javascript">
var page = 1;//默认第一页
dropload = $('.myrelease').dropload({
	  scrollArea : window,
	  loadDownFn : function(me){
		  $.post("<?php echo site_url("Easyshop/product/load_new_product?tribe_id={$tribe_id}");?>",{page:page},function(data){
			  if(data.list.length>0){
				  image_url = "<?php echo IMAGE_URL;?>";
				  var result = "";
				  for(var i=0;i<data.list.length;i++){
					  result += '<li>';
					  result += '<div class="myrelease_time">';
					  result += '<span>创建时间：'+data['list'][i]['created_at']+'</span>';
					  result += '</div>';
    				  result += '<a href="<?php echo site_url("Easyshop/product/easyshop_product_detail");?>/'+data["list"][i]["id"]+'/?tribe_id='+data['tribe_id']+'">';
        	          result += '<div class="myrelease_list_left"><img src="'+(data["list"][i]["img_path"]?image_url+data["list"][i]["img_path"]:"images/default_img_s.jpg")+'"></div>';
        	          result += '<div class="myrelease_list_right">';
        	          result += '<div>';
        	          result += '<span>'+data['list'][i]['product_name'] +' '+data['list'][i]['desc']+'</span>';
            	      result += '</div>';
            	      result += '<div>';
            	      result += '<em>￥ '+data['list'][i]['price']+'</em>';
            	      result += '<i>库存 '+data['list'][i]['stock']+'</i></span>';
            	      result += '</div></div></a>';
            	      result += '<div class="myrelease_status">';
            	      result += '<a href="javascript:void(0);" onclick="down_up('+data["list"][i]["id"]+')" id="'+'id'+data["list"][i]["id"]+'" >'+data["list"][i]["on_sale"]+'</a>';
            	      result += '<a href="javascript:void(0);" onclick="quit('+data["list"][i]["id"]+')">删除</a>';
            	      result += '</div>';
            	      result += '</li>';
				   }
				  $(".myrelease_list ul").append(result);
				  page++;
	              me.resetload();
			    }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
					$(".dropload-noData").html("没有更多的数据了");
	            }
			  },"json");
		  }
});

	//提示框
    function quit(id){
    	$("#tuichu_sub").attr('onclick','quit_sub('+id+')')
    	$(".tuichu_ball").show();
    }
    
    function cane(){
    	$('.tuichu_ball').hide();
    }

	function quit_sub(id){
		$.ajax({
			url: '<?php echo site_url('Easyshop/product/del_product/?tribe_id='.$tribe_id)?>',
            type: 'post',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                switch(data.Type)
                {
                    case 0:
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text("没有此商品").show();
                        setTimeout("prompt();", 2000);
                        break;
                    case 1:
                    	setTimeout(function (){
                            window.location.href = '<?php echo site_url('Easyshop/product/personal_list/?tribe_id='.$tribe_id);?>';
                             }, 1600);
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text("删除成功").show();
                        break;
                    case 2:
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text("已有订单，删除失败").show();
                        setTimeout("prompt();", 1600);
                        break;
                    default:
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text("删除失败").show();
                        setTimeout("prompt();", 2000);
                        return false;
                 }
               },
            error:function (data) {
              $('.tuichu_ball').hide();
              $(".black_feds").text("网络错误，请重试").show();
              setTimeout("prompt();", 2000);
              return false;
                }
			});
	}

	function down_up (obj) {
		var id = 'id'+obj;
		var  atext = document.getElementById(id);
		var label_data = atext.innerHTML;
		$.ajax({
			url: '<?php echo site_url('Easyshop/product/down_up_product/?tribe_id='.$tribe_id)?>',
			type: 'post',
			dataType: 'json',
			data: {'id': obj,label_data:label_data},
			success: function (data) {
				console.log(data['is_on_sale']);

				if (data['is_on_sale'] == '0') {
					var manager = '下架成功';
				} else if (data['is_on_sale'] == '1') {
					var manager = '上架成功';
				} else {
					var manager = '操作失败';
				}
				
				switch(data.Type)
                {
                    case 0:
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text("商品信息错误").show();
                        setTimeout("prompt();", 1800);
                        break;
                    case 1:
                    	if (data['is_on_sale'] == '0') {
        					atext.innerHTML = '上架';
        				} else if (data['is_on_sale'] == '1') {
        					atext.innerHTML = '下架';
        				} else {
        					atext.innerHTML = atext.innerHTML;
        				}
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text(manager).show();
                        setTimeout("prompt();", 1800);
                        break;
                    default:
                    	$('.tuichu_ball').hide();
                        $(".black_feds").text(manager).show();
                        setTimeout("prompt();", 1800);
                        return false;
                 }
            },
            error:function (data) {
            	$('.tuichu_ball').hide();
                $(".black_feds").text("网络错误，请重试").show();
                setTimeout("prompt();", 2000);
                return false;
            }
		});
	}
	
</script>
