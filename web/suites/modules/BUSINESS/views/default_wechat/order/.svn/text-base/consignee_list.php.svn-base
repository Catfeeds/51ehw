<?php foreach ($address as $k=>$v):?>
<td class="product-code"><input type="radio" name="address_id"
	value="<?php echo $v['id'];?>"
	<?php if($v['is_default']) echo "checked"?>></td>
<td class="product-name-col">
	<figure>
		<a href="#"><strong><?php echo $v['consignee'];?></strong><span><?php echo $v['address_for_name'].$v['address'];?></span></a>
	</figure>
</td>
<td class="product-code"><?php echo $v['phone'];?></td>
<td class="product-price-col"><?php echo $v['mobile'];?></td>
<td>
	<div class="custom-quantity-input">
		<a href="">编辑</a> &nbsp;<a href="">删除</a>
	</div>
</td>
<td><a href="#" class="close-button"></a></td>
<?php endforeach;?>  

