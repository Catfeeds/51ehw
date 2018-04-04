<form action="<?php echo site_url('member/address/save')?>"
	id="order_save" method="post" class="fValidator-form" parsley-validate novalidate>
	<div class="page clearfix">
		<div class="add_address_form_new">
			<ul>
				<li class="form-group"><label for="addressee_name">姓名</label>
					<p>
						<input type="text" name="consignee" id="addressee_name" class="form-control" parsley-trigger="change" required value="<?php echo $address['consignee'];?>">
					</p></li>
				<li class="form-group"><label for="mobile">手机号码</label>
					<p  class="clearfix">
						<input type="phone" name="mobile" id="mobile"
							onkeyup="this.value=this.value.replace(/\D/g,'')"
							onafterpaste="this.value=this.value.replace(/\D/g,'')" required class="form-control" parsley-trigger="change"  value="<?php echo $address['mobile'];?>">
					</p></li>
                    <?php
					$data ['province_selected'] = $address ['province_id'];
					$data ['city_selected'] = $address ['city_id'];
					$data ['district_selected'] = $address ['district_id'];?>
                    <?php $this->load->view('widget/district_select',$data); ?>
                    
                    <li class="form-group"><label>街道</label>
					<p class="tarea">
						<textarea name="address" id="address" required class="form-control" parsley-trigger="change"><?php echo $address['address'];?></textarea>
					</p></li>
				<li class="form-group"><label for="postcode">邮编</label>
					<p>
						<input type="text" name="postcode" id="postcode" class="form-control" parsley-trigger="change" required value="<?php echo $address['postcode'];?>">
					</p></li>
			</ul>
			<div class="pt10">
			<input type="hidden" name="address_id" value="<?php echo $address['id'];?>">
			<input type="hidden" name="back_path" value="<?php echo $back_path;?>">
				<a class="gray-but custom_border" id="btn_save"
					onclick="on_submit();">保存地址</a>
			</div>
		</div>

	</div>
	<!--page end-->
</form>
<script>
function on_submit(){
	var ok1 = true;
	if($('#order_save').parsley().validate()){
		if(!$('input[name=consignee]').val().match(/^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/)){
			 alert('请填写正确姓名');
			 ok1 = false;
		}
		else if(!$('input[name=postcode]').val().match(/^[0-9][0-9]{5}$/)){
			 alert('请填写正确邮编');
			 ok1 = false;
		}
		else if(!$('input[name=mobile]').val().match(/^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/)){
			 alert('请填写正确手机');
			 ok1 = false;
		}
		else if($('#province_id').val()=="-1"){
			 alert('省份不能为空');
			 ok1 = false;
		}
		else if($('#city_id').val()=="-11"){
			 alert('城市不能为空');
			 ok1 = false;
		}
		else if( $('#district_id').val()=="-22"){
			 alert('区域不能为空');
			 ok1 = false;
		}
//         alert($('#city_id').val());
		if(ok1){
			  $('#order_save').submit();
		}
	}
}
																														
</script>