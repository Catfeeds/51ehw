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
        <span>100%保证正品</span>
    </div>
    <div class="fn-clear m-top10">
        <?php $this->load->view('helper/leftmenu');?>
        <!--中心内容 S-->
<div class="ui-main-right fn-right">
    <div class="ui-member-title">
        <h3>100%保证正品</h3>
    </div>
    <div class="ui-member-box ui-help-con">
        <p><strong>正品保障 假一赔十</strong></p>
        <p>
            万家欢购承诺遵守商业道德，诚信为本、依法经营，接受会员监督。万家欢购所售酒品均为100%原装进口酒品，可以根据用户要求提供卫检证书等资料。绝不在酒类商品的质量、规格、技术标准等方面欺骗、误导会员。如果您发现从万家欢购购买的进口葡萄酒，并非原装进口，即可假一赔十。
        </p>
        <p><strong>15天无理由退换货</strong></p>
        <p>
            万家欢购所售酒品，均为100%原装进口酒品，并可提供发票。万家欢购将严格遵守国家三包法规，针对所售商品履行更换和退货的义务。万家欢购所售的酒品，符合基本退货规则的前提下，自签收之日起30日内，均可以申请退换货。
        </p>
        <p><strong>恒温恒湿仓 专业配送</strong></p>
        <p>
            万家欢购在全国有5大恒温恒湿仓，以最佳温度和湿度存储每一瓶葡萄酒。我们采用贴心防震包装，能有效起到防碎、避震的作用，全程给予葡萄酒最好的呵护；我们严谨选择当地最佳物流合作伙伴，确保运输途中损耗降至最低，让您的酒品安全送达。
        </p>
    </div>
</div>
<!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>