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
        <a href="<?php echo site_url('helper')?>">帮助中心</a> ＞
        <span>积分制度</span>
    </div>
    <div class="fn-clear m-top10">
        <?php $this->load->view('helper/leftmenu');?>
        <!--中心内容 S-->
        <div class="ui-main-right fn-right">
            <div class="ui-member-title">
                <h3>积分制度</h3>
            </div>
            <div class="ui-member-box ui-help-con">
                <p><strong>一、<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>积分制度</strong></p>
                <p class="p20">您在<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>购物消费，或参加活动等，即可获得<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>的积分。积分可以在<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>网站购物消费、兑换积分商城礼品并可用于升级到<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>VIP悦酒会会员，享受各种专属礼遇。</p>
                <p><strong>二、积分的种类</strong></p>
                <p class="p20">
                    <strong>累积积分</strong><br/>
                    1. 您在<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>累积的总积分，包括已经使用的积分。<br/>
                    2. 累积积分用来衡量会员等级的升降（包括升级到<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>VIP悦酒会会员）。<br/>
                    <strong>可用积分</strong><br/>
                    1. 您的总积分里，可以实际使用的部分。即您的账户总积分扣除已经使用的积分。

                </p>
                <p><strong>三、积分获取</strong></p>
                <p class="p20"><strong>购买商品</strong><br>
                    a) 购买商品会自动累积积分，消费人民币1元获取1分<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>积分（￥1.00 = 1分）。<br>
                    b) 参与积分的金额以最终实际支付的订单金额为主，折扣券、礼品卡和<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>账户所抵用的金额不参与积分。<br>
                    c) 购买礼品卡和充值<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>账户时所消费的金额参与积分。<br>
                    d) 实际支付的运费可参与积分。<br>
                    e) 自2012年7月4日起，<br>
                    在线支付的订单，当订单状态为“已发货”时，24小时内发放订单和活动时赠送的积分；<br>
                    货到付款、POS机支付的订单，当订单状态为“配送完成”时，24小时内发放订单和活动时赠送的积分。<br>
                    f) 如您签收后进行了退货处理，积分也将在退货处理完毕后自动从账号扣除。如果您的退货积分已经被使用，则会从退货的款项里扣除相应金额(100积分=1元人民币)。
                </p>
                <p class="p20"><strong>推荐朋友</strong><br>
                    a) 推荐朋友成为<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>会员，您的朋友进行消费，您即可获得积分。<br>
                    b) 您的积分额度为“被推荐者”使用PASS升级后一年内购物消费积分的50%。比如，您推荐的朋友使用PASS升级后一年内购买商品获得1000积分，您可同时获得500积分；您的朋友参加活动获取的积分，不计入您可获取的积分范围。<br>
                    c) 您获得的积分，将会在“被推荐者”积分产生后的30天内自动添加到您的账户。
                </p>
                <p class="p20"><strong>市场活动</strong><br>
                    a) 参加单独的市场活动，可享受双倍积分或额外积分。请随时关注。
                </p>
                <p><strong>四、积分的使用</strong></p>
                <p class="p20">
                    您可以采取以下几种方式，使用<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>积分：<br/>
                    <strong>购买商品</strong><br/>
                    积分可用来购买商品时抵扣相应的金额，100分<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>积分等值于1元人民币。<br/>
                    <strong>兑换礼品</strong><br/>
                    积分可用来兑换积分商城的精美礼品 <br/>
                    <strong>会员升级</strong><br/>
                    积分累计和新增积分到特定数额，即可自动提升会员等级。具体参考<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>VIP俱乐部悦酒会规则。不同等级会员，可在<?php echo $this->session->userdata ( 'app_info' )['app_name'];?>享受不同优惠。
                </p>
                <p><strong>五、积分有效期</strong></p>
                <p class="p20">
                    1．每年获取的积分有效期为当年至下一年12月31日24:00，逾期积分自动清零。即<?php echo date('y');?>年1月1日0:00至<?php echo date('y');?>年12月31日24:00获取的全部积分，有效期至<?php echo date('y') + 1;?>年12月31日24:00，以此类推。<br/>
                    2．所有<?php echo date('y') - 1;?>年12月31日24:00前获取的积分，将在<?php echo date('y');?>年12月31日24:00过期失效，系统将进行清零处理。您可在<?php echo date('y');?>年12月30日24:00点前，通过登录<?php echo $this->session->userdata ( 'app_info' )['site_url'];?>申请将此部分积分延期至<?php echo date('y')+1;?>年3月31日24:00。
                </p>
                <p><strong>六、声明条款</strong></p>
                <p class="p20">
                    1. <?php echo $this->session->userdata ( 'app_info' )['app_name'];?>对积分制度拥有解释权。<br/>
                    2. <?php echo $this->session->userdata ( 'app_info' )['app_name'];?>对积分规则（包括积分的获取和使用条款），保留单方便更改的权利。
                </p>
            </div>
        </div>
        <!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>