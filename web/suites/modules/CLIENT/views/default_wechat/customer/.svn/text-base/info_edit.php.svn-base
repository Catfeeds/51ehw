<section id="content" role="main">
	<div class="breadcrumb-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li><a href="<?php echo site_url("home")?>" title="Home">首页</a></li>
						<li><a href="<?php echo site_url('customer');?>" title="Member">个人中心</a></li>
						<li class="active">修改个人信息</li>
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
                <h2 class="h4">修改个人信息</h2>
                      <hr>
                    <div class="xs-margin"></div>  
                <div class="row">
               <div class="col-md-6 col-sm-12 lg-margin">
                    
                    
                      <form action="<?php echo site_url('member/info/info_save')?>" id="order_save" method="post">
                          <div class="form-group">
                            <label class="control-label">性别:</label>
                            <p>
                            <label class="radio-inline custom-radio-wrapper">
                                    <span class="custom-radio-container">
                                        <input type="radio" name="sex" value="1" <?php echo $customer['sex']?'checked':'';?>>
                                        <span class="custom-radio-icon"></span>
                                    </span><span>男</span>
                                </label>
                            <label class="radio-inline custom-radio-wrapper">
                                    <span class="custom-radio-container">
                                        <input type="radio" name="sex" value="0" <?php echo $customer['sex']?'':'checked';?>>
                                        <span class="custom-radio-icon"></span>
                                    </span><span>女</span>
                            </label>
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >生日:</label>
                            <input type="text" name="birthday" class="form-control" placeholder="" value="<?php echo $customer['birthday'];?>">
                        </div>
                         <div class="form-group">
                            <label class="control-label">职业:</label>
                            <input type="text" name="job" class="form-control" placeholder="" value="<?php echo $customer['job'];?>">
                        </div>
                         <div class="form-group">
                            <label class="control-label">详细地址:<span class="required">*</span></label>
                            <p>
                               <span id="consignee_arae">
                                <?php 
                                $data['province_selected'] = $address['province_id'];
                                $data['city_selected'] = $address['city_id'];
                                $data['district_selected'] = $address['district_id'];
                                ?>
                                <?php $this->load->view('widget/district_select',$data); ?>
                                </span>
                            </p>
                            <textarea name="address" id="consignee_address" class="form-control min-height" cols="30" rows="6" placeholder="Your Message" onblur="check_address()" ><?php echo $address['address'] ?></textarea>
                        </div>
                         <div class="form-group">
                            <label class="control-label">邮政编码:<span class="required">*</span></label>
                            <input type="text" onblur="check_postcode()" name="postcode" value="<?php echo $address['postcode'] ?>" id="consignee_postcode" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">手机号码:<span class="required">*</span></label>
                            <input type="text" id="consignee_message" onblur="check_message()" name="mobile" value="<?php echo $customer['mobile'] ?>" class="form-control" placeholder="">
                        </div>
                         <div class="form-group">
                            <label class="control-label">固定电话:</label>
                            <input type="text" id="consignee_phone"  onblur="check_phone()" name="phone" value="<?php echo $customer['phone'] ?>" class="form-control" placeholder="">
                        </div>
                         <div class="form-group">
                            <label class="control-label">电子邮箱:</label>
                            <input type="text" id="consignee_email" onblur="check_email()" name="email" value="<?php echo $customer['email'] ?>" class="form-control" placeholder="">
                        </div>
                         <hr>
                        <div class="xs-margin"></div>
                         <a onclick="save_info(this);" class="btn btn-lg btn-custom-5">保存个人资料</a>
                      </form>   
                    </div>
                </div>
                
            </div>
             <?php $this->load->view('customer/leftmenu');?>
        </div>
    </div>
	
</section>

