<script type="text/javascript" src="js/jquery.min.js"></script><!--基础库-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->





<script>
//顶部菜单
//站点菜单
    (function($){
        $(document).ready(function(){
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script>
<?php
//$json_string = file_get_contents(base_url("data/category.json"));
//?>
<script>
<?php
		$json_string = file_get_contents(base_url("data/category.json"));
		?>
var viewModel = <?php echo $json_string;?>;
</script>
<script>
$(document).ready(function(){
    //类目菜单
    ko.applyBindings(viewModel);
});

</script>

<!-- 21城市旗舰店 -->
    <!-- 头部开始 -->
    <div class="city_header">
        <div class="header_logo" style="margin-top: 52px;">
            <a href="javascript:void(0);" style="float: right;"><img src="images/flagship_store_shoucang.png" height="65" width="69" alt="点击收藏"></a>
            <a href="javascript:void(0);"><img src="images/flagship_store_logo.png" height="40" width="230" alt="冠杰.21城传媒"></a>
            <span style="display:inline-block;border: 1px solid #ccc;height:38px;margin-left: 20px;"></span>
            <em style="display: inline-block;margin-left: 20px;">
              <a href="javascript:void(0);"><span style="font-size:17px;color: #2A2A2A;">官方旗舰店</span></a><br>
              <a href="javascript:void(0);"><img src="images/flagship_store_guanzhu.png" height="18" width="59" alt="关注"></a>  
            </em>
        </div>
        <div class="header_nav" style="margin-top: 35px;">
            <ul>
                <li style="padding-left: 55px;"><a href="javascript:void(0);" style="color: red;">首页</a></li>
                <li><a href="javascript:void(0);">媒体广告</a</li>
                <li><a href="javascript:void(0);">餐饮娱乐</a</li>
                <li><a href="javascript:void(0);">衣食住行</a</li>
                <li><a href="javascript:void(0);">综合服务</a</li>
            </ul>
        </div>
    </div><!-- 头部结束 -->
    <!-- 广告图开始 -->
   <!-- <div>
        <img src="images/flagship_store_guanggaotu01.png" height="487" width="100%" alt=""> 
    </div> 广告图结束 -->
    <div class="fullSlide">
    <div class="painting_banner1">
    <div class="bd">
    <ul>
      <li _src="url(images/flagship_store_guanggaotu01.png)"></li>
      <li _src="url(images/flagship_store_guanggaotu02.png)"></li>
      <li _src="url(images/flagship_store_guanggaotu03.png)"></li>
    </ul>
   </div>
   <div class="hd1"><ul style="height: 30px;"></ul></div>
    <span class="prev"></span>
    <span class="next"></span>
   </div>
   </div>
    <!-- 内容开始01 -->
    <div class="flagship_store_main01">
        <div class="city_flagship_nav">
            <ul>
                <li><a href="javascript:void(0);"><img src="images/flagship_store_01.png" height="236" width="392" alt=""></li</a>
                <li style="padding-left: 5px;"><a href="javascript:void(0);"><img src="images/flagship_store_02.png" height="236" width="797" alt=""></a></li>
            </ul>
            <ul>
                <li><a href="javascript:void(0);"><img src="images/flagship_store_03.png" height="236" width="392" alt=""></a></li>
                <li style="padding-left: 3px;"><a href="javascript:void(0);"><img src="images/flagship_store_04.png" height="236" width="395" alt=""></a></li>
                <li style="padding-left: 3px;"><a href="javascript:void(0);"><img src="images/flagship_store_05.png" height="236" width="395" alt=""></a></li>
            </ul>
        </div>
        <div style="margin-top: 80px;">
            <span style="text-align: center;display: block;"><img src="images/flagship_store_time01.png" height="40" width="40" alt="" style="vertical-align: middle;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 45px;">限时秒杀</span></span>
            <span style="float: right;margin-top: -20px;">剩余时间:<span><s style="" class="flagship_time">4</s><s class="flagship_time">2</s>&nbsp;小时<s class="flagship_time">0</s><s class="flagship_time">1</s>&nbsp;分钟</s><s class="flagship_time">1</s><s class="flagship_time">7</s>&nbsp;秒</span>
        </div>
        <div style="text-align: center;">
            <span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">每天10点准时上新</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
        </div>

        <!-- 电子楼媒体广告开始 -->
        <div style="margin-top: 80px;">
            <ul>
                <li>
                    <a href="javascript:void(0);"><img src="images/flagship_store_06.png" height="527" width="574" alt="21城电梯楼宇媒体广告"></a>
                    <div style="float: right;margin-right: 215px;margin-top: 10px;">
                        <span style="font-size: 32px;color: #302D2E;font-weight: bolder;">21城电梯楼宇媒体广告</span><br>
                        <span class="flagship_guanggao_right" style="padding-top: 20px;display: inline-block;">媒体材质：亚克力、液晶、钢化玻璃</span><br>
                        <span class="flagship_guanggao_right">最早投放日：每周六定制发布</span><br>
                        <span class="flagship_guanggao_right">媒体规格：42cm*57cm、50cm*35cm</span><br>
                        <span class="flagship_guanggao_right">最短投放周期：1周</span><br>
                        <span class="flagship_guanggao_right">最小投放量：100部</span><br>
                        <span class="flagship_guanggao_right">人流量：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><span class="flagship_guanggao_right" style="margin-left: 60px;">关注度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <span class="flagship_guanggao_right">好评度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <s class="flagship_guanggao_right" style="margin-top: 35px;">原价：888元</s><br>
                        <span class="flagship_guanggao_right" style="margin-top: 24px;">秒杀价：<span style="color: #DC4A36;font-size: 20px;">8999 <span style="color: #DC4A36;font-size:15px;">提货权</span></span></span><br>
                        <button style="cursor: pointer;width:180px;height:50px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #DC4A36;margin-top: 30px; "><span style="color: white;font-size: 26px;">立即购买</span></button>
                    </div>
                </li>
                <li style="padding-top: 20px;">
                    <a href="javascript:void(0);"><img src="images/flagship_store_06.png" height="527" width="574" alt="21城电梯楼宇媒体广告"></a>
                    <div style="float: right;margin-right: 215px;margin-top: 10px;">
                        <span style="font-size: 32px;color: #302D2E;font-weight: bolder;">21城电梯楼宇媒体广告</span><br>
                        <span class="flagship_guanggao_right" style="padding-top: 20px;display: inline-block;">媒体材质：亚克力、液晶、钢化玻璃</span><br>
                        <span class="flagship_guanggao_right">最早投放日：每周六定制发布</span><br>
                        <span class="flagship_guanggao_right">媒体规格：42cm*57cm、50cm*35cm</span><br>
                        <span class="flagship_guanggao_right">最短投放周期：1周</span><br>
                        <span class="flagship_guanggao_right">最小投放量：100部</span><br>
                        <span class="flagship_guanggao_right">人流量：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><span class="flagship_guanggao_right" style="margin-left: 60px;">关注度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <span class="flagship_guanggao_right">好评度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <s class="flagship_guanggao_right" style="margin-top: 35px;">原价：888元</s><br>
                        <span class="flagship_guanggao_right" style="margin-top: 24px;">秒杀价：<span style="color: #DC4A36;font-size: 20px;">8999 <span style="color: #DC4A36;font-size:15px;">提货权</span></span></span><br>
                        <button style="cursor: pointer;width:180px;height:50px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #DC4A36;margin-top: 30px; "><span style="color: white;font-size: 26px;">立即购买</span></button>
                    </div>
                </li>
            </ul>
            
        </div> <!-- 电子楼媒体广告开始结束 -->
    </div><!-- 内容结束01 -->
    <!-- 内容开始02 -->
    <div class="flagship_store_main02">
        <!-- 天天特价 -->
        <div class="flagship_store_dayday">
            <div >
                <span style="text-align: center;display: block;padding-top: 70px;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 0px;">天天特价</span></span>
            </div>
            <div style="text-align: center;">
                <span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">每天好货超值推荐</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
            </div>
            <ul style="padding-top: 75px;padding-bottom: 140px;">
                <li>
                    <a href="javascript:void(0);"><img src="images/flagship_store_08.png" height="527" width="574" alt="21城电梯楼宇媒体广告"></a>
                    <div style="float: right;margin-right: 215px;margin-top: 10px;">
                        <span style="font-size: 32px;color: #302D2E;font-weight: bolder;">21城电梯楼宇媒体广告</span><br>
                        <span class="flagship_guanggao_right" style="padding-top: 20px;display: inline-block;">媒体材质：亚克力、液晶、钢化玻璃</span><br>
                        <span class="flagship_guanggao_right">最早投放日：每周六定制发布</span><br>
                        <span class="flagship_guanggao_right">媒体规格：42cm*57cm、50cm*35cm</span><br>
                        <span class="flagship_guanggao_right">最短投放周期：1周</span><br>
                        <span class="flagship_guanggao_right">最小投放量：100部</span><br>
                        <span class="flagship_guanggao_right">人流量：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><span class="flagship_guanggao_right" style="margin-left: 60px;">关注度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <span class="flagship_guanggao_right">好评度：<span style="color: #DC4A36;">＊＊＊＊＊</span></span><br>
                        <s class="flagship_guanggao_right" style="margin-top: 35px;">原价：888元</s><br>
                        <span class="flagship_guanggao_right" style="margin-top: 24px;">秒杀价：<span style="color: #DC4A36;font-size: 20px;">8999 <span style="color: #DC4A36;font-size:15px;">提货权</span></span></span><br>
                        <button style="cursor: pointer;width:180px;height:50px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #DC4A36;margin-top: 30px; "><span style="color: white;font-size: 26px;">立即购买</span></button>
                    </div>
                </li>
                <li></li>
            </ul>
        </div>
    </div><!-- 内容结束02 -->

    <!-- 内容开始03 -->
    <div class="flagship_store_main03">
        <!-- 单品秒杀 -->
            <div >
                <span style="text-align: center;display: block;padding-top: 70px;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 4px;">单品秒杀</span></span>
            </div>
            <div style="text-align: center;">
                <span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">每天10点准时上新</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
            </div>
            <ul style="padding-top: 60px;">
                <li>
                   <a href="javascript:void(0);"><img src="images/flagship_store_09.png" height="380" width="587" alt=""></a>
                   <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="color: #393939;display: inline-block;"><img src="images/flagship_store_time02.png" height="15" width="15" alt="" style="padding-right: 5px;vertical-align: middle;">仅剩<span>05天</span><span>17时</span><span>07分</span><span>26秒</span></span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
                <li style="padding-left: 20px;">
                    <a href="javascript:void(0);"><img src="images/flagship_store_10.png" height="380" width="587" alt=""></a>
                    <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="color: #393939;display: inline-block;"><img src="images/flagship_store_time02.png" height="15" width="15" alt="" style="padding-right: 5px;vertical-align: middle;">仅剩<span>05天</span><span>17时</span><span>07分</span><span>26秒</span></span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
            </ul>

            <!-- 聚划算 -->
            <div >
                <span style="text-align: center;display: block;padding-top: 70px;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 4px;">聚划算</span></span>
            </div>
            <div style="text-align: center;">
                <span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">每天10点准时上新</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
            </div>
            <ul style="padding-top: 60px;">
                <li>
                   <a href="javascript:void(0);"><img src="images/flagship_store_11.png" height="380" width="587" alt=""></a>
                   <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="top: 45px;height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
                <li style="padding-left: 20px;">
                    <a href="javascript:void(0);"><img src="images/flagship_store_12.png" height="380" width="587" alt=""></a>
                    <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="top: 45px;height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
            </ul>
    </div><!-- 内容结束03 -->

    <!-- 内容开始04 -->
    <div class="flagship_store_main04">
        <!-- 闪购 -->
        <div class="flagship_store_shangou">
           <div >
                <span style="text-align: center;display: block;padding-top: 70px;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 4px;">闪购</span></span>
            </div>
            <div style="text-align: center;">
                <span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">每天10点准时上新</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
            </div>
            <ul style="padding-top: 60px;">
                <li>
                   <a href="javascript:void(0);"><img src="images/flagship_store_13.png" height="380" width="587" alt=""></a>
                   <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="color: #393939;display: inline-block;"><img src="images/flagship_store_time02.png" height="15" width="15" alt="" style="padding-right: 5px;vertical-align: middle;">仅剩<span>05天</span><span>17时</span><span>07分</span><span>26秒</span></span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
                <li style="padding-left: 20px;">
                    <a href="javascript:void(0);"><img src="images/flagship_store_14.png" height="380" width="587" alt=""></a>
                    <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="color: #393939;display: inline-block;"><img src="images/flagship_store_time02.png" height="15" width="15" alt="" style="padding-right: 5px;vertical-align: middle;">仅剩<span>05天</span><span>17时</span><span>07分</span><span>26秒</span></span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
            </ul>
        </div>

        <!-- 买赠专区 -->
         <div class="flagship_store_shangou" style="padding-bottom: 100px;">
           <div >
                <span style="text-align: center;display: block;padding-top: 70px;"><span style="font-size: 32px;font-weight: bolder;padding-left: 5px;vertical-align: middle;margin-right: 9px;">买赠专区</span></span>
            </div>
            <div style="text-align: center;">
                <span style="display: inline-block;width:520px;border: 1px solid #E9E9E9;vertical-align: middle;"></span><span style="color: #535353;padding-left: 10px;padding-right: 10px;font-size: 16px;">数量有限 赠完为止</span><span style="display: inline-block;width:523px;border: 1px solid #E9E9E9;vertical-align: middle;"></span>
            </div>
            <ul style="padding-top: 60px;">
                <li>
                   <a href="javascript:void(0);"><img src="images/flagship_store_15.png" height="380" width="587" alt=""></a>
                   <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="top: 45px;height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
                <li style="padding-left: 20px;">
                    <a href="javascript:void(0);"><img src="images/flagship_store_16.png" height="380" width="587" alt=""></a>
                    <div style="margin-top: 40px;position: relative;" >
                       <span style="font-size: 22px;font-weight: bolder;">西风酒52度国花瓷30年西风酒52度国花瓷30年</span><br>
                       <span style="padding-top: 15px;;color: #E33D34;font-size: 24px;display: inline-block;">899<span style="font-size: 15px;padding-left: 5px;">提货权</span></span><s style="color: #A0A0A0;padding-left:15px;font-size: 15px; ">原价:999元</s>
                       <button style="top: 45px;height:50px;cursor: pointer;width:180px;background-color:#DC4A36;text-align: center;line-height: 50px;border: 1px solid #E43C36;position: absolute;left:310px;"><span style="color: white;font-size: 26px;">立即抢购</span></button>
                   </div>
                </li>
            </ul>
        </div>
    </div><!-- 内容结束04 -->

<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd1 ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".painting_banner1 .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});


</script>


    
   

