
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
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">菜单编辑</div>

            <div class="dingdan_kehuguanli_top">

            	<div class="search_2 manage_fenlei_search_2">
                <!--	<div><input type="text" class="search2_con manage_fenlei_search2_con"></div>
                    <div class="search2_btn manage_fenlei_search2_btn"><a href="#">店内搜索</a></div>
              -->  </div>

               <div class="kehu_guanli2_btn"><a href="<?php echo site_url('corporate/myshop/menu_list') ?>">返回</a></div>

               </div>
            <!---->


            <div class="dianopu_03_con dianpu_03_bianji_con">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con menu_manage_cmRight_con bankuai_manage_cmRight_con dianpu_02_padding">


                    <div class="dianpu_02_con">
				 	<table width="910" height="100" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="198px">菜单名称</th>
                            <th width="370px">链接地址</th>
                            <th width="182px">排序</th>
                            <th width="182px">操作</th>
                    	</tr>
                    	<tr>
                            <th width="198px"><input type="text" value="<?php echo isset($dt['menu_name'])&&$dt['menu_name']!=''?$dt['menu_name']:'' ?>" class="dianpu_02_bianji_input" id="menu_name"></th>
                            <th width="370px"><input type="text" value="<?php echo isset($dt['url'])&&$dt['url']!=''?$dt['url']:'' ?>" class="dianpu_03_bianji_input" id="url"></th>
                            <th width="182px"><input type="text" value="<?php echo isset($dt['sequence'])&&$dt['sequence']!=''?$dt['sequence']:'' ?>" class="dianpu_02_bianji_input" id="sequence" ></th>
                            <th width="182px">
                            <input type="hidden" value="<?php echo isset($dt['id'])&& $dt['id']!=''?$dt['id']:'' ?>" id="id">
                            	<!--<a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>-->
                                <a href="javascript:void(0)" onclick="save();" style="color:#fca543; text-decoration:underline" id="saves">保存</a>
                            </th>
                    	</tr>

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

<script type="text/javascript">
<!--
function save(){

	   var menu_name = $('#menu_name').val();
	   var sequence = $('#sequence').val();
	   var url = $('#url').val();
	   var id = $('#id').val();

	   if(id){
	       	 data={sequence,menu_name,url,id};
	   }else{
		     data={sequence,menu_name,url};
	   }

	   $.ajax({
		    url:'<?php echo site_url('corporate/myshop/save_menu') ?>',
	        type:'post',
	        data:data,
	        beforeSend:function(){

		    },
		    success:function(data){

		        if(data == 'success'){
		        	$('#saves').html('保存成功');
		        	setTimeout(function(){
		        		$('#saves').html('保存');
			        },1000);
			    }else{
			    	$('#saves').html('保存成功');
			        setTimeout(function(){
			        	$('#saves').html('保存');
			        	location.href = "<?php echo site_url('corporate/myshop/menu_list') ?>";
				    },500);
				}
			 }
	   });

}
//-->
</script>
