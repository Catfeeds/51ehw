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
        <span>配送范围与运费</span>
    </div>
    <div class="fn-clear m-top10">
        <?php $this->load->view('helper/leftmenu');?>
        <!--中心内容 S-->
<div class="ui-main-right fn-right">
    <div class="ui-member-title">
        <h3>配送范围与运费</h3>
    </div>
    <div class="ui-member-box ui-help-con">
        <p><strong>一、500以上免运费</strong></p>
        <p>
            非特殊说明，万家欢购全场单笔满500元免运费；不足500元，每笔订单需支付不同的配送费，订单不限瓶数。
        </p>
        <p><strong>二、包装及礼品说明</strong></p>
        <p>
            为保证货品安全，每瓶产品都采用安全包装，以确保在运输途中不会因挤压等原因造成破损。酒杯暂时无法安全运送至深圳以外地区，请其它地区会员暂时不要选择酒杯。
            由于您所订购产品属于瓶装易碎品且含有酒精，国家规定不能航空运输，我们会安排陆路运输尽快安全稳妥送至您指定的送货地点，广东1-2天，江苏省、浙江省2-4天，其他各省、区、直辖市等3-5天左右。
        </p>
        <p><strong>二、运费说明</strong></p>
        <p>
            运费收费标准：（以下运费标准自2012年7月20日起开始执行）
        </p>
        <div class="ui-tit-table">
        <table cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
                <col width="7%">
                <col width="33%">
                <col width="20%">
                <col width="30%">
                <col width="10%">
            </colgroup>
            <tbody>
                <tr>
                    <th>
                        地区</th>
                    <th>
                        省份/城市/自治区</th>
                    <th>
                        普通会员和vip全体会员</th>
                    <th>
                        悦酒大使和皇家大使</th>
                    <th>
                        货到付款</th>
                </tr><tr align="center"><td>一区</td><td>北京市、上海市、天津市、广东省、四川省、浙江省、江苏省</td><td>10元/单（订单金额≥150元免运费）</td><td rowspan="3">免运费</td><td>免费</td></tr><tr align="center"><td>二区</td><td>陕西省、山西省、辽宁省、福建省、广西壮族自治区、湖北省、山东省、山西省、河南省、河北省、湖南省、安徽省、重庆市、黑龙江省、吉林省、江西省</td><td>15元/单（订单金额≥200元免运费）</td><td>免费</td></tr><tr align="center"><td>三区</td><td>新疆维吾尔自治区、西藏自治区、贵州省、内蒙古自治区、甘肃省、青海省、海南省、云南省、宁夏回族自治区</td><td>15元/单（订单金额≥200元免运费）</td><td>不支持</td></tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
<!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>