    <?php if(isset($dt['status'])&&$dt['status']==2): ?>
    <div class="audit_header">
        <div class="audit_top">
            <ul>
                <li>您的企业已被冻结</li>
                <li>目前状态:<span>冻结企业</span></li>
                <!-- <li>失败原因:<?php echo isset($message)?$message:'' ?></li>-->
            </ul>
            <a href="<?php echo site_url("Home") ?>"><h1 class="fanhui_indexs">返回首页</h1></a>
            <!-- <a href="<?php echo site_url('customer/save_step3') ?>"><h1>重新填写资料</h1></a>-->
        </div>
    </div>
    <?php else: ?>
    <div class="audit_header">
        <div class="audit_top">
            <ul>
                <li>您的注册资料已经提交</li>
                <li>目前状态:<span>审核失败</span></li>
                <li>失败原因:<?php echo isset($message)?$message:'' ?></li>
            </ul>
            <a href="<?php echo site_url("Home") ?>"><h1 class="fanhui_indexs">返回首页</h1></a>
            <a href="<?php echo site_url('customer/save_step2') ?>"><h1>重新填写资料</h1></a>
        </div>
    </div>
    <?php endif; ?>  

