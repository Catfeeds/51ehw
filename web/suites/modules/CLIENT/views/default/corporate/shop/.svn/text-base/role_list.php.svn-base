
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">评价管理</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">我的店铺</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box clearfix">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">角色管理</div>
            
            <div class="dianopu_03_con">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con menu_manage_cmRight_con bankuai_manage_cmRight_con dianpu_02_padding">
					
                    <div class="select1">
                        <ul>
                            <li><a href="<?php echo site_url('corporate/myshop/add_role') ?>">添加账号</a></li>
                            <li style="margin-right:0"><a href="#"> 批量删除</a></li>
                        </ul>
                    </div>
                    <div class="dianpu_02_con">
				 	<table width="910" height="300" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="34px"><input type="checkbox"></th>
                            <th width="694px">角色</th>
                            <th width="182px">操作</th>
                    	</tr>
                    	<?php 
                    	if(isset($list) && count($list)>0):
                        foreach ($list as $ls):
                    	?>
                    	<tr>
                            <th width="34px"><input type="checkbox" value="<?php echo isset($ls['id'])?$ls['id']:'' ?>"></th>
                            <th width="694px"><?php echo isset($ls['name'])?$ls['name']:'' ?></th>
                            <th width="182px">
                            	<a href="<?php echo site_url('corporate/myshop/edit_role/'.$ls['id']) ?>" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>
                    	<?php endforeach; ?>
                    	<?php else: ?>
                    	<tr>
                            <th width="34px"></th>
                            <th width="694px">暂无角色</th>
                            <th width="182px">
                                
                            </th>
                    	</tr>
                    	<?php endif;?>
                    	
                    	<!-- <tr>
                            <th width="34px"><input type="checkbox"></th>
                            <th width="694px">编辑</th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>
                    	<tr>
                            <th width="34px"><input type="checkbox"></th>
                            <th width="694px">客服</th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>
                        <tr>
                            <th width="34px"><input type="checkbox"></th>
                            <th width="694px">仓管</th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>-->
                    </table>
                    <!--<div class="baocun_btn menu_manage_baocun_btn bankuai_manage_baocun_btn dianpu_02_margin"><a href="#">保存</a></div>-->
             </div>
             
                    
                    
       </div>
       </div>
                    
          </div>          
                    
       </div>

<!--弹窗-->
<div class="danchuang">
    <div class="dc_con">
    	<div class="dc_top">
        	<select class="sle">
               <option style="width:200px">1</option>
               <option style="width:200px">2</option>
               <option style="width:200px">3</option>
               <option style="width:200px">4</option>
               <option style="width:200px">5</option>
              </select>
              <h1 style="float:right">标题</h1>
              
              <p style="margin-top:50px">示图</p>
        </div>
        <div class="dc_img"></div>
        <div class="dc_btn">
        	<div class="dc_btn_01"><a href="#">保存</a></div>
            <div class="dc_btn_02"><a href="#">关闭</a></div>
        </div>
    </div>
</div>
