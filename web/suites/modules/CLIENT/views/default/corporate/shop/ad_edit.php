
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
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">我的店铺</a></li>
    	</ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box clearfix">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">轮播图编辑</div>
            
            <div class="dingdan_kehuguanli_top">
                
            	<div class="search_2 manage_fenlei_search_2">
                <!--	<div><input type="text" class="search2_con manage_fenlei_search2_con"></div>
                    <div class="search2_btn manage_fenlei_search2_btn"><a href="#">店内搜索</a></div>
              -->  </div>
                
               <div class="kehu_guanli2_btn"><a href="<?php echo site_url('corporate/myshop/ad_admin') ?>">返回</a></div>
                
               </div>
            <!---->
            
            
            <div class="dianopu_03_con dianpu_03_bianji_con">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con menu_manage_cmRight_con bankuai_manage_cmRight_con dianpu_02_padding">
					
                    
                    <div class="dianpu_02_con">
				 	<table width="910" height="100" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="table">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="150px">轮播图片</th>
                            <th width="180px">广告位置</th>
                            <th width="200px">链接地址</th>
                            <th width="200px">标题</th>
                            <th width="130px">图片上传</th>
                            <th width="124px">排序</th>
                            <th width="182px">操作</th>
                    	</tr>
                    	<tr>
                    	<form action="<?php echo isset($ad['ad_id'])?site_url('corporate/myshop/img_url/'.$ad['ad_id']):site_url('corporate/myshop/img_url') ?>" method="post" id="form1" name="form" enctype="multipart/form-data">
                    	
                            <th width="150px"><img src="<?php echo isset($ad['img_url'])?IMAGE_URL.$ad['img_url']:''; ?>" class="lunbo_img" alt="" style="width:100px;height:70px;"/></th>
                            <th width="180px">
                                <select name="po_id" id="po_id">
                                    <?php if(isset($po) && count($po)>0):
                                          foreach ($po as $po):
                                    ?>
                                    <option value="<?php echo $po['po_id'] ?>" <?php if(isset($ad['po_id']) && $ad['po_id'] == $po['po_id']){echo 'selected';}else{echo '';} ?> ><?php echo $po['po_name'] ?></option>
                                    <?php endforeach; ?>
                                    <?php else:?>
                                    <?php endif;?>
                                </select>
                            </th>
                            <th width="200px"><input type="text" value="<?php echo isset($ad['url'])?$ad['url']:''; ?>" class="dianpu_03_bianji_input" style="width:150px" name="url" id="url"></th>
                            <th width="200px"><input type="text" value="<?php echo isset($ad['title'])?$ad['title']:''; ?>" class="dianpu_03_bianji_input" style="width:140px" name="title" id="title"></th>
                            <th width="130px">
                            <a href="javascript:void(0);" class="file">选择图片
                            <input type="file" name="img_url" >
                            </a><br>
                            <!-- <a href="javascript:void(0)" style="color:#fca543; text-decoration:underline" onclick = "javascript:upload()">上传</a>-->
                           
                            </th>
                            <th width="124px"><input type="text" value="<?php echo isset($ad['sort_order'])?$ad['sort_order']:''; ?>" id="so" name="sort_order" class="th1 manage_b_th1"></th>
                            <th width="182px">
                            	<!--<a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>-->
                            	<input type="hidden" value="<?php echo isset($ad['ad_id'])?$ad['ad_id']:''; ?>" id="ad_id">
                                <a href="javascript:void(0)" style="color:#fca543; text-decoration:underline" onclick = "javascript:upload()" id="saves">保存</a>
                            </th>
                    	</tr>
                    	 </form>
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


 <script language=javascript>
 

  function add(){
	  var tr = '';
	  var tr = '<tr>'+
          '<th width="34px"><input type="checkbox" name="checkbox"></th>'+
          '<th width="198px"><img src="" class="lunbo_img" alt=""/></th>'+
          '<th width="370px"><input type="text" name="url" value=""></th>'+
          '<th width="124px"><input type="text" value="" class="th1 manage_b_th1"></th>'+
          '<th width="182px">'+
          	//'<a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>'+
            //'<a href="#" style="color:#fca543; text-decoration:underline">删除</a>'+
          '</th>'+
          '</tr>';
      //alert(tr);
	  $('#table').append(tr);
  }

 /* function save(){
	   var title = $('#title').val();
	   var po_id = $('#po_id').val();
	   var sort_order = $('#so').val();
	   var url = $('#url').val();
	   var ad_id = $('#ad_id').val();
	   
	   if(ad_id){
	       	 data={title,po_id,sort_order,url,ad_id};
	   }else{
		     data={title,po_id,sort_order,url};
	   }

	   $.ajax({
		    url:'<?php echo site_url('corporate/myshop/save_ad') ?>',
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
			        setTimeout(function(){
			        	location.href = "<?php echo site_url('corporate/myshop/edit_ad') ?>/"+data;  
				    },500);
				}
			 }
	   });
	  
  }*/

  function upload(){
	   $('#form1').submit(); 
  }
  
  </script>
  
<style>
<!--
.file {
    position: relative;
    display: inline-block;
    background: #D0EEFF;
    border: 1px solid #99D3F5;
    border-radius: 4px;
    padding: 2px 10px;
    overflow: hidden;
    color: #1E88C7;
    text-decoration: none;
    text-indent: 0;
    line-height: 15px;
}
.file input {
    position: absolute;
    font-size: 15px;
    right: 0;
    top: 0;
    opacity: 0;
}
.file:hover {
    background: #72C312;
    border-color: #78C3F3;
    color: #004974;
    text-decoration: none;
}
-->
</style>
 
