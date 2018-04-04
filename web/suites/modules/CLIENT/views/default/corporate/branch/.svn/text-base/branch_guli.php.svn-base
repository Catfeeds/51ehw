   <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
       <?php $this->load->view('corporate/shop/Left_nav');?>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">添加分店管理员</div>
            <div class="stored_chongg">
               <ul class="stored_chong_ki">      
               <!-- stored_chong_ki_input -->       
                 <li class=""><span>分店名：</span><input type="text" class="n" name="branch_name" value="" placeholder="请输入店名称"></li>
                 <li class=""><span>分店地址：</span><input type="text" class="n" name="address" value="" placeholder="请输入分店地址"></li>
                 <li class="" style="height: initial;line-height: initial;"><span>负责人：</span><a href="javascript:void(0)" class="fuzenr_dianh">添加负责人</a><div style="padding-left: 9.1em;font-size: 14px;padding-top: 5px;">负责人可在51易货网公众号或APP中查看分店销售明细</div></li>
                 <li class="" style="display:none;"><span>负责人：</span><input type="text" class="n" name="owner_id" value="" ></li>
                 <li class=""><span>负责人电话：</span><input type="text" class="n" name="mobile" value=""  disabled></li>
                 <li class=""><span>负责人姓名：</span><input type="text" class="n" name="owner_name" value="" placeholder="请输入负责人姓名"></li>
               </ul>
               <div class="stored_chong_bottom" style="margin-top:100px;">
                 <a href="javascript:add_branch();" class="stored_chong_left">保存并生成二维码</a>
                 <a href="<?php echo site_url('Corporate/branch')?>" class="stored_chong_rigth">返回</a>
               </div>
               
            </div>  
         </div>
       <!--右边结束-->    
         </div>

    <!-- 弹框 -->
        <div class="alert_bg" hidden>
            <div class="alert" >
            <form >
                <h5>添加负责人<a href="javascript:close();"  ><span style="color:#fff;">x</span></a></h5>
                <div class="alert_er">
                    <ul>
                      <li><span>按手机添加</span><input input="text" placeholder="请输入对方手机号码" value="" name="check_mobile"></li>
                    </ul>
                    <a href="javascript:check_mobile();" ><h4>添加</h4></a>
                </div>
            </form>
            </div>
        
        </div>
        <!-- end -->
<script>
$(".fuzenr_dianh").click(function(){$(".alert_bg").show();})
//关闭添加窗口
function close(){
	$(".alert_bg").hide();
}
function check_mobile(){
	var check_mobile  = $("input[name='check_mobile']").val();
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	 if(check_mobile=='' || isNaN(check_mobile) || check_mobile.length!=11 || !partten_mobile.test(check_mobile)){
	       alert('请输入正确手机号');
	       return;
	    }
	 $.post("<?php echo site_url('corporate/branch/check_user') ?>",{mobile:check_mobile},function(data){
		 switch(data['status']){
		 case 'success':
			 $("input[name='mobile']").val(check_mobile);
			 var id = data['id'];
			 $("input[name='owner_id']").val(id);
			 $(".alert_bg").hide();
			 break;
		 case 'no_user':
			 alert('该用户不存在！');return;
			 break;
		 }
		 },'json');
}
function add_branch(){
	var branch_name = $("input[name='branch_name']").val();
	var address = $("input[name='address']").val();
	var owner_id = $("input[name='owner_id']").val();
	var owner_name = $("input[name='owner_name']").val();
	
	var partten =  /^[\u0391-\uFFE5A-Za-z]+$/;
	var re = new RegExp(partten);	 
	if(!branch_name){
		alert('请输入分店名！');return;
		}
	if(!address){
		alert('请输入分店地址！');return;
		}
	if(!owner_id){
		alert('请添加分店负责人！');return;
		}
	if(!owner_name){
		alert('请输入分店负责人姓名！');return;
		}
	if(!re.test(owner_name)){
		alert('负责人姓名只允许中文或英文！');return;
		}
	 $.post("<?php echo site_url('corporate/branch/ajax_edit') ?>",{owner_id:owner_id,owner_name:owner_name,address:address,name:branch_name},function(data){
		 switch(data['status']){
		 case 'success':
			 alert('保存成功！');
			 setTimeout(function(){
				 window.location.href = '<?php echo site_url('Corporate/branch')?>';
				 },2000);
			 return;
			 break;
		 case 'error':
			 alert('保存失败！');return;
			 break;
		 }
		 },'json');
}
</script>
     
