<section id="content" role="main">
	<div class="breadcrumb-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li><a href="<?php echo site_url("home");?>" title="Home">首页</a></li>
						<li><a href="<?php echo site_url('customer');?>" title="Member">个人中心</a></li>
						<li class="active">充值</li>
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
                    <h2 class="h4">充值</h2>
                     <hr>
                     <div class="xs-margin"></div> 
                     
                           <!-- <form name="charge" method="post" action="<?php echo site_url("charge/changeSubmit")?>">
                                 <div class="form-group">
                                    <label class="control-label" >输入充值金额:</label>
                                    <input type="text" name="amount" class="form-control" placeholder="" value="1000.00">
                                </div>
                                <div class="xs-margin"></div> 
                                <a onclick="checkSubmit()" class="btn btn-custom btn-lg min-width">立即充值</a>

                            </form>-->
                            
                            <form name="charge" method="post" action="<?php echo site_url("charge/changeSubmit")?>">
                               <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <a onclick="checkSubmit()" class="btn btn-custom btn-lg btn-block"><span style="clcor"></span>充1000送1000 <br>立即充值</a>
                                          <a onclick="checkSubmit()" class="btn btn-custom btn-lg btn-block"><span style="clcor"></span>充2000送2000 <br>立即充值</a>
                                            <a onclick="checkSubmit()" class="btn btn-custom btn-lg btn-block"><span style="clcor"></span>充5000送5000 <br>立即充值</a>
                                              <a onclick="checkSubmit()" class="btn btn-custom btn-lg btn-block"><span style="clcor"></span>充10000送10000 <br>立即充值</a>
                                                <a onclick="checkSubmit()" class="btn btn-custom btn-lg btn-block"><span style="clcor"></span>充20000送20000 <br>立即充值</a>
                                                 
                                                  
                                     </div>
                                </div>
                            </form>
                            <div class="lg-margin"></div>
                    
            </div>
            <?php $this->load->view('customer/leftmenu');?>
            
        </div>
    </div>
</section>






<script>
function checkSubmit()
{
	var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
	if(document.charge.amount.value == "" || !document.charge.amount.value.match(str))
	{
		alert("请输入正确的充值金额");
	}else if(document.charge.amount.value < 1)
	{
		alert('充值金额不能小于1元');
	}else if(document.charge.amount.value > 100000000)
	{
		alert('充值金额不能大于1亿元');
	}else
	{
		document.charge.submit();
	}
}
</script>
