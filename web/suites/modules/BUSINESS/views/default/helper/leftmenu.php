<!--中心导航 S-->
        <div class="ui-main-left fn-left">
            <div class="ui-title-01"><img src="images/help.png"/> </div>
            <div class="ui-personal-nav">
                <div class="ui-menu-tit">新手指南</div>
                <ul class="fn-clear">
                    <li <?php if($this->uri->segment(3)=='member') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/member')?>">成为会员</a></li>
                    <li <?php if($this->uri->segment(3)=='process') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/process')?>">购物流程</a></li>
                    <li <?php if($this->uri->segment(3)=='intergral') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/intergral')?>">积分制度</a></li>
                </ul>
                <div class="ui-menu-tit">支付方式</div>
                <ul class="fn-clear">
                    <li <?php if($this->uri->segment(3)=='cod') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/cod')?>">货到付款</a></li>
                    <li <?php if($this->uri->segment(3)=='payonline') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/payonline')?>">在线支付</a></li>
                    <li <?php if($this->uri->segment(3)=='invoice') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/invoice')?>">发票制度</a></li>
                </ul>

                <div class="ui-menu-tit">合作加盟</div>
                <ul class="fn-clear">
                    <li <?php if($this->uri->segment(3)=='generalize') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/generalize')?>">推广方式</a></li>
                    <li <?php if($this->uri->segment(3)=='profit') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/profit')?>">盈利模式</a></li>
                    <li <?php if($this->uri->segment(3)=='balance') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/balance')?>">如何结算</a></li>
                </ul>
                <div class="ui-menu-tit">物流配送</div>
                <ul class="fn-clear">
                    <li <?php if($this->uri->segment(3)=='shipping') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/shipping')?>">500以上免运费</a></li>
                    <li <?php if($this->uri->segment(3)=='delivery') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/delivery')?>">配送范围</a></li>
                </ul>
                <div class="ui-menu-tit">服务保障</div>
                <ul class="fn-clear">
                    <li <?php if($this->uri->segment(3)=='security') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/security')?>">100%正品</a></li>
                    <li <?php if($this->uri->segment(3)=='returning') echo 'class="active"';?>><a href="<?php echo site_url('helper/detail/returning')?>">15天无理由退货</a></li>
                </ul>
            </div>
        </div>
        <!--中心导航 e-->