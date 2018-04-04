
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">实体消费</div>
                <div class="sale_code">
                    <p>
                    	<label>绑定商品：</label>
                        <span> 
                            <select data-placeholder="请点击选择商品" class="sale_select" >
                            	<?php if(count ($product_list) >0 ):?>
                            	   <?php foreach ($product_list as $v):?>
                            	       <option <?php echo $v['is_mc'] == 1 ? 'selected="selected"' : ''?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                            	   <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </span> 
                    </p>
                    <a href="javascript:;" onclick="add()"class="sale_code_btnSave">保存</a>
<!--                     <a href="javascript:;" class="sale_code_btnCancel">取消</a> -->
                </div>
            </div>
        </div>
<script>
function add(){ 
	var id = $('.sale_select').find("option:selected").val();
	$.ajax({ 
		url:"<?php echo site_url('corporate/sale/related_product')?>",
		data:{product_id:id},
		type:'post',
		dataType:'json',
		success:function(data){
			if(data){ 
				alert('绑定成功');
			}else{ 
				alert('绑定失败');
			}
		}
    })
}
</script>