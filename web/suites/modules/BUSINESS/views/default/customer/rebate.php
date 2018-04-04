<!DOCTYPE html>
<html>
<head>
    <title>回扣结算</title>
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
<!-- head-top S -->
<?php $this->load->view('customer/_header');?>
<!-- head-top E -->
<div class="ui-bd w980">
    <div class="ui-crumb">你所在的位置：
        <a href="<?php echo site_url('customer');?>">个人中心</a> ＞

        <span>回扣结算</span>
    </div>
    <div class="fn-clear m-top10">
        <!--中心导航 S-->
        <?php $this->load->view('customer/leftmenu');?>
        <!--中心导航 e-->
        <!--中心内容 S-->
        <div class="ui-main-right fn-right">
            <div class="ui-member-title">
                <h3>回扣结算</h3>
            </div>
            <div class="ui-member-box">
                <div class="ui-proportion">
                    <div class="ui-form-item">
                        <label class="title">回扣比例<b>:</b></label>
                        <input type="text" class="text">
                    </div>
                    <div class="ui-form-item">
                        <label class="title">已有客户<b>:</b></label>
                        <input type="text" class="text">
                    </div>
                </div>
                <div class="ui-proportion-info fn-clear">
                    <div class="ui-tit-table">
                        <table>

                            <thead>
                                <tr>
                                    <th>商城积分</th>
                                    <th>回扣总额</th>
                                    <th>已结算金额</th>
                                    <th>未结算金额</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>500000<br/>（不可结算）</td>
                                    <td>￥ 500000.00</td>
                                    <td>￥ 500000.00</td>
                                    <td><strong>￥ 500000.00</strong></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ui-settlement-box">
                    <div class="ui-settlement-title">
                        <h3>结算金额</h3>
                    </div>
                    <div class="ui-settlement-form">
                        <div class="ui-form-item">
                            <label class="title">输入结算金额<b>:</b></label>
                            <input type="text" class="text">
                        </div>
                        <div class="ui-form-item">
                            <label class="title">操作账户<b>:</b></label>
                            <input type="text" class="text">
                        </div>
                        <div class="ui-form-item">
                            <label class="title">真实姓名<b>:</b></label>
                            <input type="text" class="text">
                        </div>
                        <div class="ui-form-item">
                            <label class="title">身份证号码<b>:</b></label>
                            <input type="text" class="text">
                        </div>
                        <div class="ui-settlement-but">
                            <a href="#" class="ui-shop-checkout but buy-dakelight">确定结算</a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <!--中心内容 E-->

    </div>

</div>
<?php $this->load->view('_footer');?>
</body>
</html>