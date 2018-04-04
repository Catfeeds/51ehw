<style type="text/css">
  .container {background: #f4f4f4;}
  .commerce_directory_search {margin-top: 5px;background: #fff;padding: 15px;-webkit-box-shadow: 3px 3px #B6B6B6;
    -moz-box-shadow: 3px 3px #B6B6B6;
    box-shadow: 0px 2px 4px 2px #B6B6B6;}
  .commerce_directory_search label {background: #efefef;color: #bfbfbf;}
  .commerce_directory_search label p span {color: #bfbfbf;}
  .commerce_directory_search label p input {color: #bfbfbf;}
  .commerce_directory_search label p input::-webkit-input-placeholder { color: #bfbfbf;}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- 陕西特产专区 -->
<div class="specialty_division" >
   <!-- 导航 -->
   <div class="specialty_division_nav">
      <ul>
          <li ><a href="javascript:void(0);" ><i>地区特产</i><em class="icon-unfold specialty_icon"></em></a></li>
          <li><a href="javascript:void(0);">最新发布</a></li>
          <li><a href="javascript:void(0);">销量</a></li>
      </ul>
   </div>
   <?php if($Nav){?>
         <div class="specialty_region_box" hidden>
             <!-- 一级地区分类 -->
           <div class="specialty_region_one">
             <ul >
             <?php 
                foreach ($Nav as $key =>$val){?>
                    <li><a href="javascript:void(0);"><?php echo $val['name'];?></a></li> 
             <?php   }
             ?>
             </ul>
           </div>
           <!-- 二级地区分类 -->
           <div class="specialty_region_two" hidden>
           
            <?php foreach ($Nav as $key =>$val){ ?>
              <ul>
            
            <?php foreach ($val['children'] as $key1 =>$val1){  ?>
                 <li><a href="javascript:void(0);" data-value ='<?php echo $val1['id'];?>'><?php echo $val1['name'];?></a></li>
            <?php }?>
              </ul>
            <?php }?>
           </div>
          </div>
       
  <?php }?>

  <form action="<?php echo site_url("Commerce/Outstanding/specialty/{$label_id}"); ?> " method="get" enctype="multipart/form-data" id="form1">
 
  <!-- 搜索框 -->
  <div class="commerce_directory_search">
    <label>
      <p><span class="icon-search"></span><input type="text" name = "search" class='product' value="<?php echo $search;?>" placeholder="商品名称"></p>
    </label>
  </div>
</form>

  <!-- 商品列表 -->
  <div class="specialty_division_goods" id="boxs">
    <ul id="boxs_trends">
    </ul>
  </div>
</div>


<script type="text/javascript">

var search = "<?php echo $search ? $search:'';?>";
var type = 0;
var parent_id = 0;
//下拉加载数据
var page = 1;//默认加载页数
dropload = $('#boxs').dropload({
    scrollArea : window,
	loadDownFn : function(me){
        var result = "";
        var label_id = "<?php echo $label_id;?>";
        var url = '<?php echo site_url("Commerce/get_SpecialtyProduct");?>';
        $.post(url,{page:page,"label_id":label_id,"type":type,"parent_id":parent_id,"search":search},function(data){
				if(data["Product"].length>0){
	            	image_url = "<?php echo IMAGE_URL;?>";
	                for(var i=0;i<data["Product"].length;i++){
	                	result +='<li >';
	                	result +='<a href="<?php echo site_url("Goods/detail")?>/'+data["Product"][i]['id']+'">';
	                	result +='<div>';
	                	result +='<img src="'+image_url+data["Product"][i]['file']+'" alt="">';
	                	result +='</div>';
	                	result +='<span class="essay-goods-title">'+data["Product"][i]['name']+'</span>';
	                	result +='</a>';
	                	result +='<div class="specialty_division_money">';
	                	result +='<p><span>￥ '+data["Product"][i]['vip_price']+'</span></p>';	//<s class="shichang_money">市场价：'+data["Product"][i]['market_price']+'</s>
	                
	                	result +='</div>';
	                	result +='</li>';
	                }
	                $("#boxs_trends").append(result);
	                page++;
	                me.resetload();
	            }else{
	            	// 锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
	            }
		
        },"json");
	}
});


  // 导航
  $('.specialty_division_nav ul li').on('click',function(){
    var index = $(this).index();
	
    if (index ==0) {
      if($(this).children('a').hasClass('specialty_division_active')){
    		$(this).children('a').removeClass('specialty_division_active');
   		 	$('.specialty_region_box').hide();
   			$('.commerce_directory_search').show();
   			$('.specialty_icon').addClass('icon-unfold');
			$('.specialty_icon').removeClass('icon-fold');
			
    		}else{
    			 $(this).children('a').addClass('specialty_division_active');
    			 $('.specialty_region_box').show();
    			 $('.commerce_directory_search').hide();
    			 $('.specialty_icon').addClass('icon-fold');
 	       	     $('.specialty_icon').removeClass('icon-unfold');
    			}
      
    } else{
     
   	 $(this).children('a').addClass('specialty_division_active');
	 $(this).siblings('li').children('a').removeClass('specialty_division_active');
     $('.specialty_icon').removeClass('icon-fold');
     $('.specialty_icon').addClass('icon-unfold');
     $('.specialty_region_box').hide();
     $('.commerce_directory_search').show();

     type = index;
     parent_id = 0;
     $("#boxs_trends").empty();
     page = 1;//默认第一页
     // 解锁
     dropload.unlock();
     dropload.noData(false);
     // 重置
     dropload.resetload();
    };
  })
 
  // 一级地区分类
  $('.specialty_region_one ul li').on('click',function(){
    $(this).children('a').addClass('specialty_region_active');
    $(this).siblings('li').children('a').removeClass('specialty_region_active');
    var index = $(this).index();
    $('.specialty_region_two ul li a').removeClass('specialty_region_two_active');
    $('.specialty_region_two ul').hide();
    $('.specialty_region_two ul').eq(index).show();
    $('.specialty_region_two').show();
  })
  // 二级地区分类
  $('.specialty_region_two ul li').on('click',function(){
    $(this).children('a').addClass('specialty_region_two_active');
    $(this).siblings('li').children('a').removeClass('specialty_region_two_active');
    $('.specialty_region_box').hide();
    $('.specialty_icon').addClass('icon-unfold');
    $('.specialty_icon').removeClass('icon-fold');
    $('.specialty_division_nav ul li a').removeClass('specialty_division_active');
    
    var text = $(this).children('a').text();
    $('.specialty_division_nav ul li').eq(0).children('a').find('i').text(text);
    console.log(text);
   
    parent_id = $(this).children("a").attr("data-value");
   
    $("#boxs_trends").empty();
    page = 1;//默认第一页
    // 解锁
    dropload.unlock();
    dropload.noData(false);
    // 重置
    dropload.resetload();
  })
</script>