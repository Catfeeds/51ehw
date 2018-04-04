<?php 

// 判断用户是否登录
if (! $this->session->userdata('user_in')) {
    redirect('customer/login');
    exit();
}
?>
<!--填写公司信息 -->

     <div class="home_page">
        <div class="type_xuanz1">
           <div class="type_xuanz_top">
                <ul class="step-case" id="step"> 
                    <li class="s-finish"><a href="javascript:;"><span>① 店铺类型/类目选择</span><b class="b-l"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>② 填写公司信息</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-finish"><a href="javascript:;"><span>③ 上传资质</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-cur"><a href="javascript:;"><span>④ 等待审核</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li class="s-cur-next"><a href="javascript:;"><span>⑤ 网上缴费、店铺上线</span><b class="b-1"></b><b class="b-2"></b><b class="b-r"></b></a></li> 
                </ul>
         </div>
        <div class="to_examine">
         <!--等待审核-->
         <!-- <?php echo $approval_status?> -->
         <?php if($approval_status == 1):?>
          <div class="to_examine_sh to_examine">
            <h6 class="icon-shijian"></h6>    
            <p class="to_examine_p">请耐心等待3-6个工作日</p>
            <p class="to_examine_p">成功开通后会有短信提醒</p>
            <a class="to_examine_a" href="<?php echo site_url("home/index");?>">回到首页</a>
          </div> 
        <?php elseif($approval_status == 3):?>
          <!--等待审核（失败）--> 
          <div class="to_examine_sh to_examine">
            <h6 class="icon-shibai"></h6>    
            <p class="to_examine_p">您申请的店铺暂未审核通过</p>
            <p class="to_examine_ph">问题：<?php echo isset($approval_desc) ? $approval_desc : '管理员忘记了写审核不通过原因' ;?></p>
            <a class="to_examine_a" href="<?php echo site_url("corporation/information");?>">继续完善资料</a>
          </div> 
        <?php elseif($approval_status == 2):?>
           <!--等待审核（成功）--> 
           <div class="to_examine_sh to_examine">
            <h6 class="icon-chenggong1"></h6>    
            <p class="to_examine_ph">恭喜您！审核已通过，快去缴费开通店铺吧</p>
            <a class="to_examine_a" href="<?php echo site_url("corporation/online_payment");?>">马上缴纳保证金</a>
          </div> 
        <?php endif;?>
        </div> 
    </div>
    </div>
    