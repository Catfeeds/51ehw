
<div class="container" style="background-color: #e8e8e8">
	<!--container_ner开始-->
	<div class="container_ner">
		<div class="ner_s">
		    <a href="<?php echo site_url('log/transaction_list')?>" class="detailed" style="color: #fff; position: absolute; right:20px;top: 20px;font-size: 15px;">交易记录</a>
			<p class="yu">可用余额</p>
			<p class="qian"><?php echo  number_format( (isset($customer['M_credit']) ? $customer['M_credit'] : '0.00') + (isset($customer['credit']) ? $customer['credit'] : '0.00'),2 )?></p>
			<p class="yu" style='font-size: 10px'>(可用余额 = 货豆余额 + 授信可用额度)</p>
		</div>

		<div class="ner_x" style="height:160px">
			<ul>
			   <li><span class="ner_x_l">授信额度</span>
					<blockquote>
						<span class="ner_x_r1"> <?php echo isset($customer['credit']) ? $customer['credit'] : '0.00' ?></span>
					</blockquote></li>
				<li><span class="ner_x_l">货豆 </span>
					<blockquote>
						<span><?php echo isset($customer['M_credit']) ? $customer['M_credit'] : '0.00'?></span><span
							class="ner_x_r"><a
							href="<?php echo site_url('charge/purchase')?>">购买<span class="icon-right"></span></a></span>
					</blockquote></li>
				
				<li><span class="ner_x_l">现金</span>
					<blockquote>
						<span><?php echo isset($customer['cash']) ? $customer['cash'] : '0.00'?></span><span
							class="ner_x_r"><a
							href="<?php echo site_url('charge/incharge')?>">充值<span class="icon-right"></span></a></span>
					</blockquote></li>


			</ul>

		</div>
	</div>
</div>
