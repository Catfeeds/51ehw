<style>
  .gerenzhongxin_01_con{ width:584px ;}
  .gerenzhongxin_01_con_right{ width:auto;}
  .gerenzhongixn_01_btn{ width:172px;}
</style>

<div class="Box member_Box clearfix">
	    <?php //个人中心左侧菜单  
            $data['left_menu'] = 1;
            $this->load->view('customer/leftmenu',$data);
        ?>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">个人信息</div>
		<div class="gerenzhongxin_01_con clearfix">
			<div class="gerenzhongxin_01_con_left">
				<ul>
					<li>用户等级：</li>
					<li>会员账号：</li>
					<li>昵称：</li>
					<li>性别：</li>
					<li>生日：</li>
					<li>职业：</li>
					<li>电子邮件：</li>
					<li>真实姓名：</li>
					<li><span>*</span>手机号码：</li>
					<li>固定电话：</li>
				</ul>
			</div>

			<div class="gerenzhongxin_01_con_right">
				<ul>
					<li><?php echo $customer['is_vip']?'VIP用户':'普通用户';?></li>
					<li><?php echo $customer['name'];?></li>
					<li><?php echo $customer['nick_name'];?></li>
					<li><?php
    if ($customer['sex'] === NULL) {
        echo '未选择';
    } else {
        switch ((int) $customer['sex']) {
            case 0:
                echo '女';
                break;
            case 1:
                echo '男';
                break;
            default:
                echo '未选择';
                break;
        }
    }
    ?></li>
					<li><?php echo substr($customer['birthday'],0,11);?></li>
					<li><?php echo $customer['job'];?></li>
					<li><?php echo $customer['email'];?></li>
					<li><?php echo $customer['real_name'];?></li>
					<li><?php echo $customer['mobile'];?><?php echo $customer['mobile']!=null?'<a href="'.site_url('member/save_set/change_mobile') .'" class="saveSet_m">更换手机</a>':'<a href="'.site_url('member/save_set/set_mobile').'" class="saveSet_m">绑定手机</a>' ?></li>
					<li><?php echo $customer['phone'];?></li>
				</ul>
			</div>
		</div>
		<div class="gerenzhongixn_01_btn">

			<div class="gerenzhongxin_01_btn01" style="margin-right: 0">
				<a href="<?php echo site_url('member/info/info_edit');?>">修改个人资料</a>
			</div>
		</div>

	</div>



</div>


