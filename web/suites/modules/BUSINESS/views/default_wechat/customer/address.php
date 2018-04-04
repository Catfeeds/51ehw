
 <div class="page clearfix"  style="padding-top: 0px;">
<?php if( isset($address) && count($address)>0){?>
	<?php foreach ($address as $k=>$v):?>
	<div style="border-bottom: 10px solid #F3F3F3;">
		<div style="margin: 0 10px; font-size: 13px; color: #333333;">
			<ul>
				<li>
					<div>
					<a href="javascript:choose_default('<?php echo $v['id'];?>')">
						<h2 style="margin-top: 6px;">
							<span><?php echo $v['consignee'];?></span><span style="padding-left: 20px;"><?php echo $v['mobile'];?></span>
						</h2>
						<p style="padding-top: 5px; border-bottom: 1px solid #DADADA; padding-bottom: 5px;" class="c9"><?php echo $v['address_for_name'];?> <?php echo $v['address'];?>&nbsp;&nbsp;&nbsp;<?php echo $v['postcode'];?></p>
					</a>
					</div>
					
					<div class="address_bts"
						style="margin-top: 10px; font-size: 14px; margin-bottom: 10px;">
						<a <?php echo $v['is_default']==1?"href=".($this->session->userdata('ref_from_url')?site_url($this->session->userdata('ref_from_url')):'javascript:void(0);'):"href='javascript:set_default(".$v['id'].")'";?>" style="color: #666666 !important;" class="icon_moren">
							<em class="<?php echo $v['is_default']==1?"icon-xuanzhong address_color":"icon-quan";?>" style="padding-right: 6px; font-size: 15px;">
							</em>设为默认地址
						</a>
						<a href="<?php echo site_url('member/address/edit/'.$v['id']);?>" class="eidt fn-right" style="padding-right: 25px; color: #666666 !important;">
						<em class="icon-bianji" style="padding-right: 6px;"></em>编辑</a>
						<a href="<?php echo site_url('member/address/del/'.$v['id']);?>" class="delete fn-right" style="padding-right: 25px; color: #666666 !important;">
						<em class="icon-shanchu" style="padding-right: 6px;"></em>删除</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<?php endforeach;?> 
	<!-- 添加收货地址 -->
	<div style="border-bottom: 1px solid #F3F3F3; line-height: 35px;">
		<a href="<?php echo site_url('member/address/add');?>" style="font-size: 13px; padding-left: 10px;">
    		<span>添加收货地址</span>	
    		<span class="icon-right" style="float: right; padding-right: 10px; padding-top: 10px; font-size: 15px;"></span>
		</a>
	</div>
<?php }else{ ?>

	<!-- 收货地址为空页 -->
	<div class="address_kong" style="text-align: center;">
		<span class="icon-xinfangdizhi c9"
			style="font-size: 100px; padding-top: 100px; display: block;"></span><br>
		<span class="c9"
			style="padding-top: 30px; display: block; font-size: 13px;">您还没有收货地址哦！</span>
		<div
			class="custom_button" style="text-align: center; line-height: 40px; background: #FED609; position: absolute; bottom: 5px; width: 94%; left: 50%; margin-left: -47%;">
			<a href="<?php echo site_url('member/address/add');?>"><span
				style="font-size: 15px;">新增地址</span></a>
		</div>
	</div>
<?php }?>
</div>
<!--page end-->

<script>
// 设置默认地址并回跳
function set_default($id){
	$(".black_feds").text("正在设置默认收货地址...").show();
    $.post("<?php echo site_url('member/address/set_default')?>",{id:$id},function(data){
        <?php if($ref_from_url = $this->session->userdata('ref_from_url')){?>
        window.location.replace("<?php echo $ref_from_url.$url_status;?>"+"address_id="+$id);
        <?php }else {?>
    	location.reload();
    	<?php };?>
    });
}
// 选择收货地址并回跳
function choose_default($id){
    <?php if($ref_from_url = $this->session->userdata('ref_from_url')){?>
    window.location.replace("<?php echo $ref_from_url.$url_status;?>"+"address_id="+$id);
	<?php }?>
}
</script>

<script type="text/javascript">
	$(".icon_moren").on("click",function(){
		$(".icon_moren em").attr('class','icon-quan');
		$(this).children().attr('class','icon-xuanzhong');
		$(this).children().addClass('address_color');
	})
</script>
