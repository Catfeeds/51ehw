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
        <span>货到付款</span>
    </div>
    <div class="fn-clear m-top10">
        <?php $this->load->view('helper/leftmenu');?>
        <!--中心内容 S-->
<div class="ui-main-right fn-right">
    <div class="ui-member-title">
        <h3>货到付款</h3>
    </div>
    <div class="ui-member-box ui-help-con">
        <p><strong>货到付款</strong></p>

        <p>配送员送货上门，客户收单验货后，直接将货款交给配送员的一种结算方式。</p>

    </div>
</div>
<!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>