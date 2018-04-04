
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
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li ><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                	<li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>
                    <!--<li ><a href="<?php echo site_url('corporate/myshop/ad_admin') ?>">广告管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>">账户管理</a></li>
                   <!-- <li><a href="<?php echo site_url('corporate/myshop/role') ?>">角色管理</a></li>-->
                   <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                   <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale_code') ?>" >实体消费二维码</a></li>
                </ul>
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">菜单设置</div>
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con menu_manage_cmRight_con bankuai_manage_cmRight_con dianpu_02_padding">

                    <div class="select1">
                        <ul>
                            <li><a href="<?php echo site_url('corporate/myshop/add_menu') ?>">添加</a></li>
                            <li style="margin-right:0"><a href="javascript:void(0)" onclick = "batch_del();"> 批量删除</a></li>
                        </ul>
                    
                    </div>
                    <div class="dianpu_02_con">
                    <form action="<?php echo site_url('corporate/myshop/batch_menu_del') ?>" method="post" name="form" id="form">
				 	<table width="910"  border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="table">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="34px"><input type="checkbox" onclick="if(this.checked==true) { checkAll(); } else { clearAll(); }"></th>
                            <th width="196px">菜单名称</th>
                            <th width="370px">链接地址</th>
                            <th width="124px">排序</th>
                            <th width="182px">操作</th>
                    	</tr>
                    	<?php if(isset($list) && count($list)>0): ?>
                    	<?php foreach ($list as $ls): ?>
                    	<tr style="height:44px;">
                            <th width="34px"><input type="checkbox" value="<?php echo isset($ls['id'])?$ls['id']:'' ?>" name="checkbox[]"></th>
                            <th width="196px"><?php echo isset($ls['menu_name'])?$ls['menu_name']:'' ?></th>
                            <th width="370px"><?php echo isset($ls['url'])?$ls['url']:'' ?></th>
                            <th width="124px"><input type="text" value="<?php echo isset($ls['sequence'])?$ls['sequence']:'' ?>" class="th1 manage_b_th1" readonly></th>
                            <th width="182px">
                            	<a href="<?php echo site_url('corporate/myshop/edit_menu/'.$ls['id']) ?>" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="javascript:void(0)" onclick="deleted(this);" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>
                    	<?php endforeach; ?>
                    	<?php else: ?>
                        <table width="910" height="50" class="result_null" style="margin-top:10px">
                        <tr>
                            <th>暂无菜单</th>
                        </tr>  
                        </table>
                    	
                    	<?php endif; ?>
                    	
                    	<!-- <tr>
                            <th width="34px"><input type="checkbox"></th>
                            <th width="196px">电脑周边</th>
                            <th width="370px">http://www.51ehw.com/index.html</th>
                            <th width="124px"><input type="text" value="3" class="th1 manage_b_th1"></th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>-->
                    </table>
                    </form>
                    <!-- <div class="baocun_btn menu_manage_baocun_btn bankuai_manage_baocun_btn dianpu_02_margin"><a href="#">保存</a></div>-->
             </div>
             
                    
                    
       </div>
                    
          </div>          
                    
       </div>

<!--弹窗
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
</div>-->
       
<script type="text/javascript">
<!--
function deleted(o){
	  
	  var id = $(o).parent().prev().prev().prev().prev().children().val();

	  $.ajax({
		  url:'<?php echo site_url('corporate/myshop/menu_del') ?>',  
		  type:'post',
		  data:{id:id,},
		  success:function(data){
			    if(data == 1){
			    	$(o).parent().parent().remove(); 
			    	var rows = document.getElementById("table").rows.length; 
				  	if(rows <= 1){
				  	      var tr = '';
					  	  var tr = '<tr>'+
    					            '<th width="34px"></th>'+
    					            '<th width="198px"></th>'+
    					            '<th width="370px">暂无菜单</th>'+
    					            '<th width="124px"></th>'+
    					            '<th width="182px">'+
    					           '</tr>';
				           $('#table').append(tr);
					} 
				}
	      },
  });
}

function batch_del(){
	$('#form').submit();
}

//全选
    function checkAll() {
    	var el = document.getElementsByTagName('input');
    	var len = el.length;
    	for(var i=0; i<len; i++) {
    	if((el[i].type=="checkbox")) {
    	el[i].checked = true;
    	}
    	}
    } 

    function clearAll() {
    	var el = document.getElementsByTagName('input');
    	var len = el.length;
    	for(var i=0; i<len; i++) {
    	if((el[i].type=="checkbox")) {
    	el[i].checked = false;
    	}
    	}
    } 

//-->
</script>

