
<div class="page clearfix">
	<form method="post" action="<?php echo site_url("order/save_snap"); ?>" name="order_form" id="order_form">
	<ul class="address_manage_new">
		<a href="<?php echo site_url('member/address/add/'.urlencode('member/address/get_address/'.$order_id));?>"
			class="add">
			<li class="add_address_btn_new  c"><i class="icon-add"></i> 添加新地址</li>
		</a>
         <?php foreach ($address as $k=>$v):?>
         <a class="selected_address">
			<li
			class="address_li <?php if ($v['is_default']): ?>active<?php endif;?>">
				<input type="radio" style="display: none;" name="address_id" value="<?php echo $v['id'];?>" class="check_address"> 
				<div class="address_info">
					<h2>
						<span class="name"><?php echo $v['consignee'];?></span><span><?php echo $v['mobile'];?></span>
					</h2>
					<p><?php echo $v['address_for_name'];?> <?php echo $v['address'];?></p>
					<p><?php echo $v['postcode'];?></p>
				</div> <em class="red_select"><i class="icon-check"></i></em>
			</li>
		</a>
        <?php endforeach;?> 
        <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
	<a class="gray-but" id="btn_save">保存地址</a>
            </ul>
	</form>
</div>
<!--page end-->
<script>
$("document").ready(function(){

	//选中地址
	$(".selected_address").click(function(){
		$(".address_li").removeClass("active");
		$(this).find("li").addClass("active");
		$(this).find("li").find(".check_address").attr("checked",'checked');
	});

	$('#btn_save').click(function(){
		$('#order_form').submit();
	});

	
});	
	
</script>

