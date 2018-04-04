<!-- 51易货网新版首页 -->
<script type="text/javascript" src="js/jquery-1.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>
<script type="text/javascript" src="js/jquery.glide.min.js"></script>
<style type="text/css">
	.container {background: #ededed;}
	::-webkit-input-placeholder {color: #ddd;}
	div.flicking_con{position:absolute;top:360px;left:50%;z-index:999;height:21px;}
    div.flicking_con a{float:left;width:6px;height:6px;margin:0;padding:0;display:block;text-indent:-1000px;background: #ccc;border: 1px  solid #fff;margin-left: 10px;border-radius: 50%;}
    div.flicking_con a:nth-child(1) {margin-left: 0!important;}
    div.flicking_con a.on{background: #FDCF0C;border: 1px solid #FDCF0C;}
    .slider {padding-bottom: 30px;background: #fff;border-bottom: 1px solid #bfbfbf;}
    .main_visual {overflow: hidden;}
    .main_visual{height:422px;overflow:hidden;position:relative;}
    .main_image{height:422px;overflow:hidden;position:relative;}
    .main_image ul{width:9999px;height:422px;overflow:hidden;position:absolute;top:0;left:0}
    .main_image li{float:left;width:100%;height:422px;}
    .main_image li span{display:block;width:100%;height:422px}
    .main_image li a{display:block;width:100%;height:422px}
    div.flicking_con{position:absolute;top:360px;left:50%;z-index:999;height:21px;}
    div.flicking_con a{float:left;width:6px;height:6px;margin:0;padding:0;display:block;text-indent:-1000px;background: #ccc;border: 1px  solid #fff;margin-left: 10px;border-radius: 50%;}
    div.flicking_con a:nth-child(1) {margin-left: 0!important;}
    div.flicking_con a.on{background: #FDCF0C;border: 1px solid #FDCF0C;}
    .new_index_main {margin-top: 7px;}
    .index_new_footer_01 a {background-position: -43px -184px;color: #efb336;}
</style>



	<!-- 滚动图 s-->
    <div class="main_visual">
        <div class="flicking_con">
    	  <?php
    	   if($adList != null && count($adList) > 0) {
    	     for($i=1;$i<=count($adList);$i++){
    	    ?>
    	      <a href="#" class=""><?php echo $i?></a>
   		  <?php  } }?>
   		
		</div>
        <div class="main_image">
            <ul style="overflow: visible;">
            	<?php
            	if($adList != null && count($adList) > 0) {
            	    foreach ($adList as $ad){
                ?>
                        <li><a href="<?php echo $ad['url'];?>"><img src="<?php  echo IMAGE_URL.$ad['img_url'];?>" alt="<?php echo $ad['title'];?>"></a></li>
                <?php 
            	    }
            	}
            	?>
            </ul>
            <!-- 绑定滑动事件按钮，勿删 -->
            <a href="javascript:;" id="btn_prev" style="width: 375px; overflow: visible;"></a>
            <a href="javascript:;" id="btn_next" style="width: 375px; overflow: visible;"></a>
    	</div>
    </div>
	<!-- 滚动图结束 e-->
<?php

// echo '<pre>';
// print_r($storey_list);exit;
?>
    <!-- 分类列表 -->
    <div class="slider">
	     <ul class="slides" id="slides">
		    <li class="slide">
			  <div class="classify_nav classify_third_nav">
	   	        <ul>
	   	        <?php 
	   	        foreach ($storey_list['Home_nav'] as $key =>$val){
	   	            $key++;
	   	              if($key%10 == 0 && $key!=0){?>
	   	              <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc'];?>"><span><?php echo $val['desc'];?></span></a></li>
    	   	       	</ul>
    	          </div>
    		    </li>
	   	        <?php  }elseif($key%10 == 1 && $key!=1){?>
    		    <li class="slide">
    			  <div class="classify_nav classify_third_nav">
    	   	        <ul> 
    	   	          <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc'];?>"><span><?php echo $val['desc'];?></span></a></li>
	   	            
	   	        <?php }else{ ?>
	   	          <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc'];?>"><span><?php echo $val['desc'];?></span></a></li>
	   	        <?php } }?>
	        	</ul>
	          </div>
		    </li>
		
	     </ul>
       </div>

	<!-- 每日推荐 -->
	<div class="index_new_recommend">
		<fieldset class="scheduler_border">
           <legend class="scheduler_border1">每日推荐</legend>
        </fieldset>
        <div class="index_new_recommend_text"><span>每日给你不一样的感受</span></div>

		<div class="slider slider_recommend" style="border-bottom: none;">
	     <ul class="slides" id="slides">
	      <li class="slide">
			  <div class="classify_nav_01">
	   	        <ul>
	     <?php 
	     $Daily_i=1;
	     foreach ($storey_list['Daily_recommend'] as $key =>$val){
	         if($Daily_i%3 == 0){?>
	             <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
	             </ul>
	          </div>
		  </li>
		  <?php if($Daily_i>=9){}else{?>
		         <li class="slide">
	 		  <div class="classify_nav_01">
        		 <ul>
		  <?php  } }else{?>
	            <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
	     <?php    }
	     $Daily_i++;
	     }?>
	    	 	</ul>
	       </div>
		</li>
	     </ul>
       </div>
	

        <!-- 需求池入口 s-->
    <div class="new_index_main" >
        <ul>
            <li> 
           <!--  
            <a href="<?php //echo site_url('member/requirement')?>" >
                <img src="<?php //echo THEMEURL.'images/requirement.png';?>" alt="需求信息">
            </a>
           --> 
           <a href="<?php echo $storey_list['demand']['link_path'] ?>" >
                <img src="<?php echo $storey_list['demand']['img_path'] ?>" alt="需求信息">
            </a>
            </li>
        </ul>
    </div>
    <!-- 需求池入口 e-->

    <!-- 精品专区 -->
    <div class="index_new_boutique">
       <div class="index_new_boutique-title">
		 <span class="index_new_left_xian"></span>
         <span class="index_new_left_text">精品专区</span>
	   </div>
	   <div class="index_new_boutique_goods">
	   	   <ul>
	   	   <?php foreach ($storey_list['Boutique'] as $key =>$val){ ?>
	   	        <li>
	   	          <a href="<?php echo $val['link_path'] ?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a>
	   	       </li>
	   	    <?php }?>
	   	   </ul>
	   </div>
    </div>
    
   <!-- 精品专区2  开始 --> 
   <?php 
   //楼层一
   if(count($storey_list['Boutique2']['seat_1'])>0){
       echo '<!--楼层一-->';
       $data['list'] = $storey_list['Boutique2']['seat_1'];
       $this->load->view('home_template', $data);
   }
   ?>
   <?php 
   //楼层二
   if(count($storey_list['Boutique2']['seat_2'])>0){
       echo '<!--楼层二-->';
       $data['list'] = $storey_list['Boutique2']['seat_2'];
       $this->load->view('home_template', $data);
   }
   ?>
   <?php 
   //楼层三
   if(count($storey_list['Boutique2']['seat_3'])>0){
       echo '<!--楼层三-->';
       $data['list'] = $storey_list['Boutique2']['seat_3'];
       $this->load->view('home_template', $data);
   }
   ?>
   <?php 
   //楼层四
   if(count($storey_list['Boutique2']['seat_4'])>0){
       echo '<!--楼层四-->';
       $data['list'] = $storey_list['Boutique2']['seat_4'];
       $this->load->view('home_template', $data);
   }
   ?>
   <?php 
   //楼层五
   if(count($storey_list['Boutique2']['seat_5'])>0){
       echo '<!--楼层五-->';
       $data['list'] = $storey_list['Boutique2']['seat_5'];
       $this->load->view('home_template', $data);
   }
   ?>
   <?php 
   //楼层六
   if(count($storey_list['Boutique2']['seat_6'])>0){
       echo '<!--楼层六-->';
       $data['list'] = $storey_list['Boutique2']['seat_6'];
       $this->load->view('home_template', $data);
   }
   ?>
        
  <!-- 精品专区2  结束 --> 
  
    <!-- 易货热卖 -->
    <div class="index_new_hot_buy">
    	<div class="index_new_hot_buy_head">
    		<fieldset class="scheduler_border">
             <legend class="scheduler_border1">易货热卖</legend>
            </fieldset>
            <div class="index_new_recommend_text"><span>一切美好也需要正确的打开方式</span></div>
    	</div>
    </div>
    <div class="index_new_hot_buy_goods">
        <ul>
        <?php if(count($storey_list['Hot_sale']) > 0){
            foreach ($storey_list['Hot_sale'] as $key =>$val){
                ?>
                 <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
                <?php 
            }
            
        }?>
        </ul>
    </div>

    <!-- 推荐店铺 -->
     <div class="index_new_hot_buy">
        <div class="index_new_hot_buy_head">
            <fieldset class="scheduler_border">
             <legend class="scheduler_border1">推荐店铺</legend>
            </fieldset>
            <div class="index_new_recommend_text"><span>一切美好也需要正确的打开方式</span></div>
        </div>
    </div>
    <div class="index_new_shop">
       <div class="index_new_shop_list01">
            <ul>
    <?php 
    
     if(count($storey_list['Shop_recommend']) > 0){
         foreach ($storey_list['Shop_recommend'] as $key =>$val){
             if($val['position'] < 4 ){ ?>
                 <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
           <?php   }
             if($val['position'] == 4){?>
                  <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
            </ul>
        </div>
        <div class="index_new_shop_list02">
            <ul>
     <?php } if($val['position'] > 4){?>
                 <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
     <?php  }  
             
         }
     }
     ?>
            </ul>
        </div>
    </div>

    <!-- 猜你喜欢 -->
    <div class="index_new_boutique-title">
         <a href="<?php echo site_url('Search/wechat_search_goods')?>">
            <span class="index_new_left_xian"></span>
            <span class="index_new_left_text">猜你喜欢</span>
            <span class="index_new_more"><i>更多</i><i class="icon-right"></i></span>
         </a>
    </div>
    <div class="index_new_love">
        <ul>
        <?php if(count($storey_list['Guess_like']) > 0){
            foreach ($storey_list['Guess_like'] as $key =>$val){?>
                <li><a href="<?php echo $val['link_path']?>"><img src="<?php echo $val['img_path']?>" alt="<?php echo $val['desc']?>"></a></li>
                
        <?php  }
        }?>
        </ul>
    </div>




<!-- 画廊js -->
<script type="text/javascript">
$(document).ready(function(){

    $(".main_visual").hover(function(){
        $("#btn_prev,#btn_next").fadeIn()
    },function(){
        $("#btn_prev,#btn_next").fadeOut()
    });
    
    $dragBln = false;
    
    $(".main_image").touchSlider({
        flexible : true,
        speed : 200,
        btn_prev : $("#btn_prev"),
        btn_next : $("#btn_next"),
        paging : $(".flicking_con a"),
        counter : function (e){
            $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
        }
    });
    
    $(".main_image").bind("mousedown", function() {
        $dragBln = false;
    });
    
    $(".main_image").bind("dragstart", function() {
        $dragBln = true;
    });
    
    $(".main_image a").click(function(){
        if($dragBln) {
            return false;
        }
    });
    
    timer = setInterval(function(){
        $("#btn_next").click();
    }, 5000);
    
    $(".main_visual").hover(function(){
        clearInterval(timer);
    },function(){
        timer = setInterval(function(){
            $("#btn_next").click();
        },5000);
    });
    
    $(".main_image").bind("touchstart",function(){
        clearInterval(timer);
    }).bind("touchend", function(){
        timer = setInterval(function(){
            $("#btn_next").click();
        }, 5000);
    });


    var width = $(".flicking_con").width();
    $(".flicking_con").css("margin-left",- width/2);
    
});
</script>
<!-- 画廊宽高按比例定义 -->
<script type="text/javascript">
if(window.location.toString().indexOf('pref=padindex') != -1){}
else{
    if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){ 
        if(window.location.href.indexOf("?mobile")<0){
            try{
            	if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
                    $(document).ready(function(){
                        var width = $(window).width();
                        $(".main_visual").css("height",360/(750/width));
                        $(".flicking_con").css("top",360/(750/width) - 20 );
                        $(".main_image").css("height",360/(750/width));
                        $(".main_image li span").css("height",360/(750/width));
                    })
                }
                else if(/iPad/i.test(navigator.userAgent)){}
                else{}
            }catch(e){}
        }
    }
}
</script>


<!-- 分类列表 -->
<script type="text/javascript">
      // 获取li的个数设置宽度
      var num = $(".classify_nav ul li").length;
      // alert(num);
      $(".classify_nav ul li").width((100/num + "%"));
      if (num>=5) {
      	$(".classify_nav ul li").width((20 + "%"));
      	// $(".classify_nav ul li").attr("style","width:20%");
      }
       else{
      	 $(".classify_nav ul li").width((100/num + "%"));
      };


      var glide = $('.slider').glide({
					autoplay:false,//是否自动播放 默认值 true如果不需要就设置此值
					animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效
					arrows:true, //是否显示左右导航器
					arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
					arrowMainClass: "slider-arrow",//滑块箭头公共类名
					arrowRightClass:"slider-arrow--right",//滑块右箭头类名
					arrowLeftClass:"slider-arrow--left",//滑块左箭头类名
					arrowRightText:">",//定义左右导航器文字或者符号也可以是类
					arrowLeftText:"<",

					nav:true, //主导航器也就是本例中显示的小方块
					navCenter:true, //主导航器位置是否居中
					navClass:"slider-nav",//主导航器外部div类名
					navItemClass:"slider-nav__item", //本例中小方块的样式
					navCurrentItemClass:"slider-nav__item--current" //被选中后的样式
				});	

			// 页面加载完后才显示图片
			$(document).ready(function(){
                  $('.slider').css("opacity",'1');

               })

	</script>

    <script type="text/javascript">
      // 屏幕4%的宽度给li的margin-bottom
      var width_window = $(window).width();
      $(".index_new_hot_buy_goods ul li").css("margin-bottom",((width_window - 8)* 0.04));

      
      $(window).scroll(function() {//滚动条滚动事件
        if($(document.body).scrollTop() > 32.5) {
            // $(".index_new_search_bg").show();
            $(".index_new_search_bg").fadeIn();
            // $(".index_new_search_bg").slideUp();

        }else {
            // $(".index_new_search_bg").hide();
            $(".index_new_search_bg").fadeOut();
            // $(".index_new_search_bg").slideDown();


        }
    })
       

    window.onload = function() { 
	  var height_louceng = $(".index_floor_list_01").height();
	    $(".index_floor_list_01 li").css("height",height_louceng);
	    $(".index_floor_list_02 li").css("height",height_louceng);
	    $(".index_floor_list_03 li").css("height",height_louceng);
	  }; 

    </script>






