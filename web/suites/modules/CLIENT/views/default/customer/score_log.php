<section id="content" role="main">
	<div class="breadcrumb-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li><a href="<?php echo site_url();?>" title="Home">首页</a></li>
						<li><a href="<?php echo site_url('customer');?>" title="Blog">个人中心</a></li>
						<li class="active">我的积分记录</li>
					</ul>
				</div>
				<!-- End .col-md-12 -->
			</div>
			<!-- End .row -->
		</div>
		<!-- End .container -->
	</div>
	<!-- End .breadcrumb-container -->

	<div class="container">
		<div class="row">

			<div class="col-md-9 col-md-push-3 col-sm-8 col-sm-push-4 padding-left-larger">
                    <h2 class="h4">获得积分记录</h2>
                    <hr>
                    <div class="xs-margin"></div>   
                   <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th class="table-title">事件</th>
                                    <th class="table-title">积分数额</th>
                                    <th class="table-title">发生时间</th>
                                    <th class="table-title">备注</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($score_logs as $item):?>
                                <tr>
                                    <td class="product-code"><?php echo $item['event_id'];?></td>
                                    <td class="product-code"><?php echo $item['score'];?></td>
                                    <td class="product-code"><?php echo $item['log_date'];?></td>
                                    <td class="product-code"><?php echo $item['remark'];?></td>
                                </tr>
                                <?php endforeach;
                                if (count($score_logs) == 0) {
                                	?>
                                	
                                <tr>
                                    <td class="product-code" colspan=4>暂时没有积分获得记录，努力加油吧！</td>
                                </tr>
                                	<?php
                                }
                                ?>
                            </tbody>
                        </table>
					<div class="md-margin"></div>   
                     <h2 class="h4">已用积分记录</h2>
                    <hr>
                    <div class="xs-margin"></div>   
                      <table class="table cart-table">
                            
                            <thead>
                                <tr>
                                    <th class="table-title">事件</th>
                                    <th class="table-title">积分数额</th>
                                    <th class="table-title">发生时间</th>
                                    <th class="table-title">备注</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($score_used_logs as $item):?>
                                <tr>
                                    <td class="product-code"><?php echo $item['event_id'];?></td>
                                    <td class="product-code"><?php echo $item['score'];?></td>
                                    <td class="product-code"><?php echo $item['log_date'];?></td>
                                    <td class="product-code"><?php echo $item['remark'];?></td>
                                </tr>
                                <?php endforeach;
                                if (count($score_used_logs) == 0) {
                                	?>
                                	
                                <tr>
                                    <td class="product-code" colspan=4>暂时没有积分使用记录，去换购商品！</td>
                                </tr>
                                	<?php
                                }?>
                            </tbody>
                        </table>   
           
           
        </div>
        <!--中心内容 E-->
			
			<!-- End .col-md-9 -->
					<?php $this->load->view('customer/leftmenu');?>
                </div>
		<!-- End .row -->
	</div>
	<!-- End .container -->

	<div class="lg-margin2x"></div>
	<!-- space -->

</section>
<!-- End #content -->
