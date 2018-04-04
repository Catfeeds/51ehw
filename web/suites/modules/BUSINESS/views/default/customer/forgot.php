<!DOCTYPE html>
<html>
    <head>
        <title>重置密码</title>
        <base href="<?php echo THEMEURL; ?>" />
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <link href="css/base.css" rel="stylesheet" type="text/css"/>
        <link href="css/public.css" rel="stylesheet" type="text/css"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="css/login.css" rel="stylesheet" type="text/css"/>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
    </head>
    <body>
        <?php $this->load->view('_header');?>
        <!-- head-top E -->
        <div class="ui-bd w980">
            <div class="ui-login">
                <div class="ui-login-title">
                    <h3>重置密码</h3>
                </div>
                <div class="ui-login-bd fn-clear">
                    <div class="ui-get-password">
                        <div class="ui-form-item">
                            <label class="ui-title-login">新 密 码<b>:</b></label>
                            <input type="text" class="text" placeholder="">
                        </div>
                        <div class="ui-form-item">
                            <label class="ui-title-login">确认新密码<b>:</b></label>
                            <input  type="text" class="text" placeholder="">
                        </div>
                        <div class="ui-main-login-but">
                            <button type="submit" class="btn-determine">确&nbsp;&nbsp;&nbsp;定</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php $this->load->view('_footer');?>
    </body>
</html>