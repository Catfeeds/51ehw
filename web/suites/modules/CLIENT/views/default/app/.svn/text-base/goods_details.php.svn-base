<!DOCTYPE html>
<html lang="en">

<head>
<base href="<?php echo THEMEURL.'app/'; ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=640, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta name="format-detection" content="telephone=no" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/swiper3.08.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/swiper3.08.jquery.min.js"></script>
    <script type="text/javascript" src="js/TouchSlide.1.1.js"></script>
</head>

<body>
    <div class="container">
        <!--<div class="header">欢迎使用</div>-->
        <div class="page clearfix">
            <!--图片组 开始-->
            <div class="swiper-container">
                <div class="swiper-wrapper">
				<?php foreach($gallery as $g){?>
                    <div class="swiper-slide"><img src="<?php echo $g["file"]?>"/></div>
				<?php }?>
                   
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            <!--图片组 结束-->
            <!--产品标题组 开始-->
            <div class="product">
                <h1><?php echo $details['name'];?></h1>
                <p>【京东自营，正品速达】欧莱雅 彩妆+女士护肤【最高满199减100】 立即抢购！</p>
                <div class="line"></div>
                <lable class="item">市场价: <span class="red">￥ <?php echo $details['market_price'];?></span>
                </lable>
                <lable class="item">批发价: <span class="red">￥ <?php echo $details['price'];?></span>
                </lable>
                <div class="line"></div>
                <lable class="item">库存: <span><?php echo $details['stock']?>件</span>
                </lable>
                <lable class="item">销量: <span>件</span>
                </lable>
                <div class="line"></div>
                <lable class="item">选择:</lable>
                <div id="leftTabBox" class="tabBox">
                    <div class="hd">
                        <ul>
                            <li><a >数量</a>
                            </li>
                            <li><a >套餐</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bd">
                        <ul>
                            <li><lable class="item">商品总价: <span class="red">￥ 999.00</span></lable>
                            </li>
                            <li>
                                <span class="add-del">
                                <a class="btn-add"><span>-</span></a>
                                <input type="text" class="new-input" value="1" id="number" onblur="modify();">
                                <a class="btn-del"><span>+</span></a>
                            </span>
                            </li>

                        </ul>
                        <ul>
                            <li><a onclick="" class="choice selected">1个月</a>
                            </li>
                            <li><a class="choice">3个月</a>
                            </li>
                            <li><a class="choice">6个月</a>
                            </li>
                            <li><a class="choice">12个月</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
            <!--产品标题组 结束-->
        </div>
        <div class="footer nav">
            <ul class="nav-tab">
                <li><a class="button">收藏</a>
                </li>
                 <li><a class="button">购物车</a>
                 <li><a class="button bg-red">加入购物车</a>
                </li>
                 <li><a class="button">立即购买</a>
                  <li><a class="button">立即购买</a>
                   <li><a class="button">立即购买</a>
                </li>
            </ul>
        </div>
    </div>


</body>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
    });
</script>

<script type="text/javascript">
    TouchSlide({
        slideCell: "#leftTabBox"
    });
</script>

</html>