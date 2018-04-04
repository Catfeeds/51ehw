	<style type="text/css">
       .footer-height {width: 100%; height:50px; background:#eee;display: none;}
       @media screen and (max-width:320px) {
        .footer-height {display: block;}
       }
    </style>
    <div class="container" style="background-color: #EEEEEE">
        <div class="station_form">
        	<p><a href="javascript:void(0);" class="icon-sousuo custom_color"></a><input type="text" oninput="search()" value="" placeholder="请输入站点名称或字母" id="search">  </p>
        </div>
        <span id="cover">
        <!-- 定位站点 -->
        <div class="station_positioning">
        	<span>定位站点</span></br>
        	<a  class="station_positioning_name custom_color"></a>
        </div>
         <!-- 最近访问站点 -->
<!--         <div class="station_addressing"> -->
<!--         	<span>最近访问站点</span><br> -->
<!--         </div>  -->
<!--         <div class="station_addressing_name" > -->
<!--           <ul> -->
<!--         	 <li>沧州</li> -->
<!--         	 <li>广州</li> -->
<!--         	 <li>佛山</li> -->
<!--           </ul>	 -->
<!--         </div> -->
        <p class="station_hot"><span>热门站点</span></p>
        <div class="station_hot_name" >
          <ul>
        	 <a href="http://www.51ehw.com"><li>全国</li></a>
<!--         	 <a href="http://www.xian51ehw.com/index.php/home"><li>西安</li></a> -->
<!--         	 <li>广州</li> -->
          </ul>	
<!--            <ul> -->
<!--         	 <li>深圳</li> -->
<!--         	 <li>南京</li> -->
<!--         	 <li>杭州</li> -->  
<!--           </ul>	 -->
<!--            <ul> -->
<!--         	 <li>天津</li> -->
<!--         	 <li>苏州</li> -->
<!--         	 <li>无锡</li> -->
<!--           </ul>	 -->
<!--            <ul> -->
<!--         	 <li>佛山</li> -->
<!--         	 <li>东莞</li> -->
<!--         	 <li>宁波</li> -->
<!--           </ul>	 -->
        </div> 
		<!-- 所有站点 -->
        <div class="station_all">
        	<span>所有站点</span></br>
        	<span class="station_all_text ">各站点所售商品不同，请选择您的送达站点</span>
        </div>
        </span>
        <!--  <div class="station_all_ul"> 
        	   <ul>
        	   <span class="station_all_span">A</span>
        	     <li>鞍山</li>
        	     <li>安庆</li>
        	     <li>安阳</li>
        	   </ul>        
        	    <ul>
        	     <span class="station_all_span">B</span>
        	     <li>北京</li>
        	     <li>保定</li>
        	     <li>滨州</li>
        	    </ul>   
        </div>-->
        <!-- 分站点内容 start -->    
        <div id="letter" ></div>
        <div class="sort_box" style="margin-bottom: 50px;">
        <?php foreach ($app_info as $v){?>
           <div class="sort_list">
               <a href="<?php echo $v['site_url']."index.php/home"?>"><div class="num_name"><?php echo $v['app_name']?></div></a>
           </div>
           <?php if(mb_substr($v['app_name'],0,-1)==$address){$url = $v['site_url'];}?>
        <?php };?>
        
        <?php echo '<script>;$(".station_positioning_name").text("全国").attr("href","http://www.51ehw.com/");</script>';//if(!empty($url)){echo '<script>;$(".station_positioning_name").text("'.$address.'").attr("href","'.$url.'");</script>';}else{echo '<script>;$(".station_positioning_name").text("全国").attr("href","http://www.51ehw.com/");</script>';}?>
<!--           <div class="initials"> -->
<!--               <ul> -->
<!--                   <li class="icon-fanhuidingbu"></li> -->
<!--               </ul> -->
<!--           </div> -->
       </div>
       <!-- 分站点内容 end -->
       
    </div>   
    <div class="footer-height"></div>
</body>
<script src="js/zepto.js"></script>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.charfirst.pinyin.js"></script>
<script type="text/javascript" src="js/sort.js"></script>
</html>
<script>
//ajax 搜索
function search(){
    var search_val = $("#search").val();
    var html = "";
    $.post("<?php echo site_url("situs/wechat/search");?>",{search_val:search_val},function(data){
            //如果没有值显示隐藏部分
            if(search_val==""){
              for(var i=0;i<data.length;i++){
            		html += '<div class="sort_list"><a href="'+data[i]['site_url']+'"><div class="num_name">'+data[i]['app_name']+'</div></a></div>'; 
                	} 
              $(".sort_box").html(html);
              sequence();
              $("#cover").show();  
            }else{
            	//有结果执行
            	if(data.length>0){
                	for(var i=0;i<data.length;i++){
                		html += '<div class="sort_list"><a href="'+data[i]['site_url']+'"><div class="num_name">'+data[i]['app_name']+'</div></a></div>'; 
                    	}
                	$(".sort_box").html(html);    
                	sequence();  
                	$("#cover").hide();   	
            	}else{//没有结果执行 
                    html += '<div class="station_sousuo_no"><img src="images/station_sousuo.png" height="154" width="154" alt=""><span class="station_sousuo_no_text">暂未开通您要查找的站点</span><br><span>请重新输入站点名称或字母</span></div>';
                    $(".sort_box").html(html);
                    $("#cover").hide();  
                	}
                }
        },'json');
}

//插件自带
function sequence(){ 
	//重新加载排序
    var Initials=$('.initials');
    var LetterBox=$('#letter');
    initials();
    $(".initials ul li").click(function(){
        var _this=$(this);
        var LetterHtml=_this.html();
        LetterBox.html(LetterHtml).fadeIn();

        Initials.css('background','rgba(185,185,185,0.6)');
        
        setTimeout(function(){
            Initials.css('background','rgba(185,185,185,0)');
            LetterBox.fadeOut();
        },1000);

        var _index = _this.index()
        if(_index==0){
            $('html,body').animate({scrollTop: '0px'}, 300);//点击第一个滚到顶部
        }else if(_index==27){
            var DefaultTop=$('#default').position().top;
            $('html,body').animate({scrollTop: DefaultTop+'px'}, 300);//点击最后一个滚到#号
        }else{
            var letter = _this.text();
            if($('#'+letter).length>0){
                var LetterTop = $('#'+letter).position().top;
                $('html,body').animate({scrollTop: LetterTop-85+'px'}, 300);
            }
        }
    })
    
    var windowHeight=$(window).height();
    var InitHeight=windowHeight-85;
    Initials.height(InitHeight);
    var LiHeight=InitHeight/32;
    Initials.find('li').height(LiHeight);
}
</script>