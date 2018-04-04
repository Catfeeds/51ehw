
<div class="Box member_Box clearfix">
		<?php //个人中心左侧菜单  
            $data['left_menu'] = 5;
            $this->load->view('customer/leftmenu',$data);
         ?>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">安全设置</div>
		<!--首次修改支付密码 开始-->
		<div class="saveSet">
			<p>
				<span class="saveSet_n">登录密码</span> <span class="saveSet_t">＊登录51账号时需要输入的密码</span>
				<a href="<?php echo site_url('member/info/pwd_edit') ?>"
					class="saveSet_m">修改登录密码</a>
			</p>
			<p>
				<span class="saveSet_n">支付密码</span> <span class="saveSet_t">＊在账户资金变动及更改账户信息时需要输入的密码</span>
                <?php if(count($pay_account)>0&&isset($pay_account['pay_passwd'])&&$pay_account['pay_passwd']!=null): ?>
                <a
					href="<?php echo site_url('member/save_set/paypwd_update') ?>"
					class="saveSet_m">修改支付密码</a>
                <?php else: ?>
                <a
					href="<?php echo site_url('member/save_set/paypwd_set') ?>"
					class="saveSet_m">立即设置</a>
                <?php endif; ?>
            </p>
			<p>
				<span class="saveSet_n">绑定手机号</span> <span class="saveSet_t"
					style="color: #999;"><?php echo isset($customer['mobile'])&&$customer['mobile']!=null?"＊您绑定的手机号为".substr_replace($customer['mobile'],'* * * *',3,4):"您暂未绑定手机，请绑定" ?></span>
               <?php if(isset($customer['mobile'])&&$customer['mobile']!=null): ?>
                <a
					href="<?php echo site_url('member/save_set/change_mobile') ?>"
					class="saveSet_m">更换手机</a>
               <?php else: $this->session->set_userdata('mobile',1); $this->session->set_userdata('binding_mobile',1);?>
                <a
					href="<?php echo site_url('member/save_set/set_mobile') ?>"
					class="saveSet_m">绑定手机</a>
               <?php endif; ?>
            </p>
		</div>
		<!--首次修改支付密码 结束-->
	</div>



</div>

