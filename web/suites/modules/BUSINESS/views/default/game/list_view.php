<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <base href="<?php echo base_url(); ?>" />
    <title>微商游戏</title>
</head>
<style>
        /* reset for html5 css3*/        body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td,section,article,aside,header,footer,nav,dialog,figure,hgroup{margin:0;padding:0;}
        table {border-collapse:collapse;border-spacing:0}
        h1,h2,h3,h4,h5,h6{font-size:100%;}
        ul,ol,li{list-style:none}
        em,i{font-style:normal}
        img{border:0;}
        input,img{vertical-align:middle;}
        input:focus{outline:none;}
        a{color:#444;text-decoration:none;}
        *{-webkit-tap-highlight-color: rgba(0,0,0,0);}    
    
    body{font-family:"microsoft yahei",sans-serif;font-size:12px;min-width:320px;line-height:1.5;color:#333;background:#fff;}
    .wrap{padding:0 0 50px 0;}
     .f-game ul{}
     .f-game li{border-bottom:1px dashed #dadad8;}
     .f-game li img{width: 100%; max-width: 100%; height: auto;}
    .f-info {padding:0 10px;}
     .f-info p{font-size: 16px; }
     .f-info h1{font-size: 18px;}
</style>
<body>
    <div class="wrap">
        <ul class="f-game">
            <li style="padding:0 0 30px 0;"><a href="<?php echo site_url('game/game/egg');?>"><img src="images/egg.jpg"/></a>
                <div class="f-info">
                    <h1>游戏玩法:</h1>
                    <P>用户只点击金蛋即可有机会得到丰富的礼品，一天一名用户只能参加一次</P>
                    <h1>奖品:</h1>
                    <p>1) 雪糕或小蛋糕</p>
                    <p>2) 20元MissKing餐厅现金卷</p>
                    <p>3) MissKing氨基酸洁面乳一瓶</p>
                    <p>4) MissKing面膜一盒及免费护理卷一张</p>
                    <h1>领奖方法:</h1>
                    <p>用户只需要拿着中奖的信息去前台领取即可。</p>
                </div>
            </li>
            <li style="padding:30px 0;"><a href="<?php echo site_url('game/game/qhb');?>"><img src="images/red.jpg"/></a>
                <div class="f-info">
                    <h1>游戏介绍:</h1>
                    <p>百分百免单游戏：抢红包</p>
                    <P>只限店内用户参加,每一张台只允许一张红包的中奖内容,免单金额只限游戏前已下单金额。</P>
                    <p>游戏时间：PM 13:00 与 PM 19:00 一共两场</p>
                    <h1>免单说明:</h1>
                    <p>红包一共10份</p>
                    <p>免单比例随机,举例:10张如一张台抢到80%免单剩余20%另外9张台继续分</p>
                    <h1>领奖方法:</h1>
                    <p>结账前提供红包信息给收银台即可</p>
                </div>
            </li>
            <li style="padding:30px 0;"><a href="<?php echo site_url('game/game/tiger');?>"><img src="images/tiger.jpg"/></a></li>
        </ul>
    </div>
   
    
</body>
</html>