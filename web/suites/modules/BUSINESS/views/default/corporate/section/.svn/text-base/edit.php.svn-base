    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">评价管理</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">商品管理</div>
		<div class="cmLeft_down manage_new_cmLeft-down">
			<ul>
				<li><a href="<?php echo site_url("corporate/product/create");?>">发布商品</a></li>
				<li><a href="<?php echo site_url('corporate/product/get_list');?>">全部商品(<?php echo isset($all_count)?$all_count:'' ?>)</a></li>
				<li><a href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">销售中(<?php echo isset($sale)?$sale:'' ?>)</a></li>
				<li><a href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a></li>
				<li><a href="<?php $type = 'not'; echo site_url('corporate/product/get_list/0/'.$type) ?>">已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
				<li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/section/get_list');?>">分类管理</a></li>
                 <li><a href="#">部落优惠商品</a></li>
				<!--<li><a href="#">售后管理</a></li>-->
			</ul>
		</div>
	</div>
	<div class="cmRight manage_new_cmRight">
		<div class="cmRight_tittle">新建分类</div>
		<form class="form-horizontal group-border-dashed"
							action="<?php echo site_url('corporate/section/save')?>"
							style="border-radius: 0px;" method="post" id="form" name="form">
		<div class="cmRight_con manage_new_cmRight_con">
			<ul>
				<li>
					<p>分类名称：</p> <input type="text" name="section_name" value="<?php echo isset($detail['section_name'])?$detail['section_name']:'' ?>" class="p1" required>
				</li>
				<li>
					<p>上级分类名称：</p> <select class="pSelect" name="pid_p">
						<option value="0">顶级分类</option>
						<?php foreach ($sections as $section):?>
						<option value="<?php echo $section['id'];?>" <?php echo isset($detail['pid'])&&$detail['pid']==$section['id']?'selected':'' ?>><?php echo $section['section_name'];?></option>
						<?php endforeach;?>
				</select>
				<input type="hidden" name="section_type" value="0">
				<input type="hidden" name="id" value="<?php echo isset($detail['id'])?$detail['id']:'' ?>">
				</li>
				<li>
					<p>排序：</p> <input type="text" name="sequence" class="p1" value="<?php echo isset($detail['sequence'])?$detail['sequence']:'' ?>">
				</li>

			</ul>
			<div class="PP">
				<div class="pp">
					<p></p>
					<input type="submit" value="保存" class="p2">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
