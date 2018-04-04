<style>
.alert{
	background:none;
}
#code{
	text-align: center;
    padding-top: 20px;
/* 	background:none; */
	border:none;
}
#code img{
	display:block;
	margin: 0 auto;
}

</style>  

   <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
       <?php $this->load->view('corporate/shop/Left_nav');?>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">分店管理</div>
          <div class="stored_sh">
          <div class="stored_sh_li">
             <div class="stored_sh_li_ad">
               <a href="<?php echo site_url('Corporate/branch')?>" class="stored_de">分店管理</a><a href="<?php echo site_url('Corporate/branch/branch_report')?>">销售报表</a>
             </div> 
            <a class="stored_sh_rigth" href="<?php echo site_url("Corporate/branch/add_branch")?>">添加分店</a>
          
          </div>
            
            <div class="stored_zhong">
             
                <table width="909"  border="1" cellpadding="0" cellspacing="0" class="table_st">
				<tbody>
				 <tr class="tr1">
						<th width="140px">分店名</th>
						<th width="184px">分店地址</th>
						<th width="80px">分店负责人</th>
						<th width="100px">负责人电话</th>
						<th width="140px">分店创建时间</th>
						<th width="120px">分店营业额</th>
						<th width="130px">操作</th>
					</tr>
			    <!-- 分店开始 -->
			    <?php if(count($branch)>0){ 
			         foreach ($branch as $key =>$val){?>
			        <tr>
						<th width="140px"><?php echo $val['branch_name'];?></th>
						<th width="184px"><?php echo $val['address'];?></th>
						<th width="80px"><?php echo $val['owner_name'];?></th>
						<th width="100px"><?php echo $val['mobile'];?></th>
						<th width="140px"><?php echo $val['created_at'];?></th>
						<th width="120px"><?php echo $val['order_total_price'];?>货豆</th>
						<th width="130px">
						<?php if($val['order_total_price'] == 0){ ?>
						    	
								<?php if(!$val['is_host']){ ?>
									<a href="<?php echo site_url('Corporate/branch/edit_branch').'/'.$val['id'];?>" style="margin-right:8px;">编辑</a>
								    <a href="javascript:del(<?php echo $val['id'];?>);" style="margin-right:8px;">删除</a>
								<?php }else{ ?>
								      <a href="<?php echo site_url('Corporate/branch/edit_branch').'/'.$val['id'];?>" style="margin-right:15px;">编辑</a>
								<?php }?>
								
						<?php }else{ ?>
						    <a href="<?php echo site_url('Corporate/branch/edit_branch').'/'.$val['id'];?>" style="margin-right:15px;">编辑</a>
						<?php }?>
					
						<a href="javascript:codes(<?php echo $val['id'];?>,'<?php echo $val['branch_name'];?>');" style="color:#fe4a00;">查看二维码</a>
						</th>
					</tr>
			   <?php  }
			    }?>
				 <!-- 分店结束 -->	
				</tbody>
                </table>
                <div class="jilu">
                      <p>显示 <?php if(count($branch) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    	  </div>
                    <div class="showpage">
                    	<?php echo $page;?>
                    </div>
            </div>
          </div>  
         </div>
       <!--右边结束-->    
         </div>

	<div class="alert_bg" hidden>
            <div class="alert" >
                <div class="alert_er">
                	<div id="code" >
                	</div>	
                    <div class="stored_chong_bottom" >
                     <a id="download" download ='' class="stored_chong_left">下载</a>
                     <a href="javascript:close();"  class="stored_chong_rigth">取消</a>
                   </div>
                </div>
            </div>
        </div>

<script type="text/javascript" src="js/qrcode/qrcode_jquery.js"></script>
<script type="text/javascript" src="js/qrcode/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="js/qrcode/jquery.qrcode.function.js"></script>

<script type="text/javascript">

function codes(id,branch_name){
	
	$("#code").html('');
	var str = "<?php echo site_url("Member/order/branch_pay_view");?>/"+id;
    $("#code").qrcode({
        render : "canvas",   //设置渲染方式,table和canvas【推荐canvas】
        text : str,          //扫描二维码后显示的内容(如果是网址将跳向该链接网址)
        width : "200",       //二维码的宽度
        height : "200",      //二维码的高度
        background : "#fff", //二维码的后景色
        foreground : "#000", //二维码的前景色
        <?php if($logo){?>
        src: '<?php echo $logo;?>'      //二维码中间的图片
        <?php  }else{
              if(base_url() == 'http://www.test51ehw.com/'){?>
              src: 'http://www.test51ehw.com/logo.png'      //二维码中间的图片
              <?php }else{?>
              src: 'http://c.51ehw.com/logo.png'      //二维码中间的图片
              <?php }?>
      
        <?php  }?>
     
        
    });
    var canvas = $('#code').find("canvas").get(0);
    var url = canvas.toDataURL('image/jpeg');
    $("#download").attr('href', url).get(0);
    $("#download").attr('download', branch_name+'.jpeg');
	$('.alert_bg').show();
  };

function  del(id){

	$.ajax({ 
	   url:"<?php echo site_url('Corporate/branch/ajax_del')?>",
	   type:'post',
	   data:{id:id},
	   dataType:'json',
	   success:function(data){ 
	     alert(data.Message);
	     setTimeout(function(){
			window.location.reload();
		     },2000);
	   },
	})
}
function close(){
		$(".alert_bg").hide();
}
</script>


        
        


	