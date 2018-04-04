<!DOCTYPE html>
<html>
<head>
    <title>帮助中心</title>
    <base href="<?php echo THEMEURL; ?>" />
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/public.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="css/cart.css" rel="stylesheet" type="text/css"/>
    <link href="css/member.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
    <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
</head>
<body>
<?php $this->load->view('_header');?>
<!-- head-top S -->
<div class="ui-bd w980">
    <div class="ui-crumb">你所在的位置：
        <a href="<?php echo site_url('helper/detail/1')?>">帮助中心</a> ＞
        <span>成为会员</span>
    </div>
    <div class="fn-clear m-top10">
        <!--中心导航 S-->
        <div class="ui-main-left fn-left">
            <div class="ui-title-01"><img src="images/help.png"/> </div>
            <div class="ui-personal-nav">
                <div class="ui-menu-tit">新手指南</div>
                <ul class="fn-clear">
                    <li class="active"><a href="<?php echo site_url('helper/detail/1')?>">成为会员</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">购物流程</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">积分制度</a></li>
                </ul>
                <div class="ui-menu-tit">支付方式</div>
                <ul class="fn-clear">
                    <li><a href="<?php echo site_url('helper/detail/1')?>">货到付款</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">在线支付</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">发票制度</a></li>
                </ul>

                <div class="ui-menu-tit">合作加盟</div>
                <ul class="fn-clear">
                    <li><a href="<?php echo site_url('helper/detail/1')?>">推广方式</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">盈利模式</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">如喝结算</a></li>
                </ul>
                <div class="ui-menu-tit">物流配送</div>
                <ul class="fn-clear">
                    <li><a href="<?php echo site_url('helper/detail/1')?>">500以上免运费</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">配送范围</a></li>
                </ul>
                <div class="ui-menu-tit">服务保障</div>
                <ul class="fn-clear">
                    <li><a href="<?php echo site_url('helper/detail/1')?>">100%正品</a></li>
                    <li><a href="<?php echo site_url('helper/detail/1')?>">15天无理由退货</a></li>
                </ul>
            </div>
        </div>
        <!--中心导航 e-->
        <!--中心内容 S-->
        <div class="ui-main-right fn-right">
            <div class="ui-member-title">
                <h3>成为会员</h3>
            </div>
            <div class="ui-member-box">
                sadas
            </div>
        </div>
        <!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>