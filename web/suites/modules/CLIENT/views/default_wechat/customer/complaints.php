<section id="content" role="main">
	<div class="breadcrumb-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li><a href="<?php echo site_url("home")?>" title="Home">首页</a></li>
						<li><a href="<?php echo site_url('customer');?>" title="Blog">个人中心</a></li>
						<li class="active">在线投诉</li>
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
    
                <h2 class="h4">在线投诉</h2>
                <hr>
                <div class="xs-margin"></div>  
                <h2 class="h5">请填写以下内容：</h2>
                 
                      
                           <form action="<?php echo site_url('member/complain/save');?>" method="post" id="myform" enctype="multipart/form-data">
                            <div class="row">
                           <div class="col-md-6 col-sm-12 lg-margin">
                            <div class="form-group">
                                <label class="control-label" >投诉账号:</label>
                                <input name="username" type="text" class="form-control" value="<?php echo $customer['name'];?>" readOnly="true"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" >联系方式:</label>
                                <input name="contact" type="text" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" >联系邮箱:</label>
                                <input name="email" type="text" class="form-control" value="<?php echo $customer['email'];?>"/>
                            </div>
                             </div>
                             </div>
                             <div class="row">
                           <div class="col-md-8 col-sm-12 lg-margin">
                            <div class="form-group">
                                 <label class="control-label" >投诉事由:</label>
                                 <p>
                                     <label class="radio-inline custom-radio-wrapper">
                                            <span class="custom-radio-container">
                                                <input type="radio" name="complain_reason" value="1">
                                                <span class="custom-radio-icon"></span>
                                            </span><span>质量问题</span>
                                    </label>
                                    <label class="radio-inline custom-radio-wrapper">
                                        <span class="custom-radio-container">
                                            <input type="radio" name="complain_reason" value="2">
                                            <span class="custom-radio-icon"></span>
                                        </span><span>快递问题</span>
                                    </label>
                                    <label class="radio-inline custom-radio-wrapper">
                                        <span class="custom-radio-container">
                                            <input type="radio" name="complain_reason" value="3">
                                            <span class="custom-radio-icon"></span>
                                        </span><span>其他 </span>
                                            <input type="text" class="form-control radio-inline" style="width: 90px;" name="complain_reason_other" />
                                    </label>
                                    
                                 </p>
                            </div>
                            </div>
                               </div>
                                <div class="row">
                                   <div class="col-md-6 col-sm-12 lg-margin">
                                            <div class="form-group">
                                                 <label class="control-label" >事件描述:</label>
                                                  <textarea name="complain_desc" class="form-control min-height" cols="30" rows="6" placeholder="Your Message"></textarea>
                                            </div>
                                           <div class="form-group">
                                                 <label class="control-label" >相关图片:</label>
                                                 <input name="file[]" type="file">
                                                 
                                           </div>
                                           <hr>
                                           <div class="xs-margin"></div>
                                           <a onclick="checkform()" class="btn btn-custom btn-lg min-width">确定投诉</a>
                                    </div>
                               </div>
                               
                               
                               
                        </form>
                     
                </div>
         <?php $this->load->view('customer/leftmenu');?>
                  
                    
                   
                </div>
            </div>


			<!-- End .col-md-9 -->
					
               
		<!-- End .row -->
	
	<!-- End .container -->

	<div class="lg-margin2x"></div>
	<!-- space -->

</section>
<!-- End #content -->
<script type="text/javascript">
function checkform()
{

	if(check())
	{
		$("#myform").submit();
	}
}

function check()
{
	var check = true;
	var contact = $("input[name=contact]");
	var email = $("input[name=email]");
	var desc = $("textarea[name=complain_desc]");
	var reason = $(':radio[name="complain_reason"]:checked');
	var reason_other = $("input[name=complain_reason_other]");

	if(contact.val()=='')
	{
		check = false;
		alert('联系方式不能为空。');
		contact.focus();
		return false;
	}

	if(email.val()=='')
	{
		check = false;
		alert('联系邮箱不能为空。');
		email.focus();
		return false;
	}


	if(reason.val()==3 && reason_other.val()=="")
	{
		alert('请填写其他投诉事由。');
		reason_other.focus();
		return false;
	}

	if(desc.val()=='')
	{
		check = false;
		alert('描述不能为空。');
		desc.focus();
		return false;
	}

	return check;
}

</script>