<style type="text/css">
    .ner_x {padding-left: 0;border-bottom: 1px solid #ddd;}
	.ner_x ul li {padding-left: 25px;}
	.container {background:#f6f6f6;}
	.ner_x ul li .ner_x_r a {border: 1px solid #ffd600;border-radius: 5px;}

</style>


<div class="container" style="background-color: #e8e8e8">
	<!--container_ner开始-->
	<div class="container_ner">
		<div class="ner_s custom_button">
		    <a href="<?php echo site_url('log/transaction_list')?>" class="detailed" style="color: #fff; position: absolute; right:20px;top: 20px;font-size: 15px;">交易记录</a>
			<p class="yu">可用提货权</p>
			<p class="qian"><?php echo  number_format( (isset($customer['M_credit']) ? $customer['M_credit'] : '0.00') + (isset($customer['credit']) ? $customer['credit'] : '0.00'),2 )?></p>
			<p class="yu" style='font-size: 10px'>(可用提货权＝提货权＋担保额度＋易呗额度)</p>
		</div>

		<div class="ner_x" style="height:105px">
			<ul>
<!-- 			   <li><span class="ner_x_l">授信额度</span> -->
<!-- 					<blockquote> -->
						<span class="ner_x_r1"> <?php // echo isset($customer['credit']) ? $customer['credit'] : '0.00' ?></span>
<!-- 					</blockquote></li> -->
				<li><span class="ner_x_l">提货权 </span>
					<blockquote>
						<span><?php echo isset($customer['M_credit']) ? $customer['M_credit'] : '0.00'?></span><span
							class="ner_x_r"><a
							href="<?php echo site_url('charge/purchase')?>">购买</a></span>
					</blockquote></li>
				
				<li><span class="ner_x_l">现金</span>
					<blockquote>
						<span><?php echo isset($customer['cash']) ? $customer['cash'] : '0.00'?></span><span
							class="ner_x_r"><a
							href="<?php echo site_url('charge/incharge')?>">充值</a></span>
					</blockquote></li>


			</ul>
		</div>

        <?php //if( !empty($is_corp) ):?>
    		<div class="ner_x" style="margin-top: 10px;">
    			<ul>
    				
    				
    				
    				<li><span class="ner_x_l">担保额度</span>
    					<blockquote>
    						<span><?php echo !$is_guarantee && $guarantee_total > 0 ? $guarantee_total : '0.00'?></span>
    						<?php if( $is_guarantee ):?>
    						<span class="ner_x_r"><a href="<?php echo site_url('Credit/Choose_tribe')?>">申请</a></span>
    						<?php endif;?>
    					</blockquote>
    				</li>
    				<li><span class="ner_x_l">易呗 </span>
    					<blockquote>
    						<span class="ner_x_r">
    						
    						<a href="<?php echo site_url('Credit')?>">申请</a>
    						
    						</span>
    					</blockquote>
					</li>
    				
    			</ul>
    		</div>
		<?php //endif;?>
	</div>
</div>


<!-- 弹窗 -->
    <div class="name_ball" style="display: none;">
           <div class="name_ball_box">
               <div class="warrant_box">
               	   <span>担保额度</span>
               	   <span>500,000</span>
               	   <div class="warrant_box_input">
               	   	<label><input type="checkbox"><span>同意并遵守 </span></label><a href="javascript:void(0);">51易货担保规则</a>
               	   </div>
               	   <a href="javascript:void(0);" class="warrant_box_ok">同意</a>
               	   <p>担保人:<em>猫, 狗, 老鼠</em></p>
               	   <p>部&nbsp;&nbsp;&nbsp;落:<em>51易货网</em></p>
               	   <p>有效期:<em>2017/12/07 - 2018/12/03</em></p>
                   <span class="icon-shopping ball_close_icon" onclick="ball_close_icon()"></span>
               </div>
           </div>
    </div>

    <script type="text/javascript">
        function ball_close_icon() {
          $('.name_ball').hide();
        }


    </script>




