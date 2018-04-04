
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
<?php if(count($List) < 2){?>
<style>
 #none{
	margin-top: 230px;
}
 #pag{
	margin-top: 230px;
}
</style>
<?php }?>
<style>
.up{
	color:red !improtant;
}
.down{
	color:green !improtant;
}
.sort{
	text-align:center;
}
</style>
<div class="Box member_Box clearfix">
	<?php  $this->load->view('tribe/left_nav');?>

	<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">部落推荐商品</div>
		 <form  action="<?php echo site_url('tribe/products') ?>"  method="get" id="form_search">
		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			  <div class="members_b">
              <input  type="text" class="members_in" name="search_name" value="<?php echo isset($search)?$search:'' ?>" placeholder="请输入搜索关键字 (商品名称或店铺名称)">
               <input  type="text" class="members_in" name="search_id" value="<?php echo isset($product_id)?$product_id:'' ?>" placeholder="精确搜索商品ID" style="width:120px;">
              <a href="javascript:;" onclick="submit();">查询</a>
              </div>
                <div class="select2">
                <div class="nice_top">
				 <div class="nice-select1" name="nice-select">
                   <input name="times" id="times" type="text" placeholder="显示全部时间" value="<?php echo isset($times)?$times:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">显示全部</li>
                          <li data-value="2">近7天内</li>
                          <li data-value="3">近一个月内</li>
                          <li data-value="4">3个月内</li>
                          <li data-value="5">半年内</li>
                          <li data-value="6">1年内</li>
                        </ul>
                      </div>
                      
                      <div class="nice-select1" name="nice-select">
                   <input name="status" id="status" type="text" placeholder="审核状态" value="<?php echo isset($status)?$status:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">全部</li>
                          <li data-value="2">未上架</li>
                          <li data-value="3">已上架</li>
                        </ul>
                      </div>
                 </div>
              <div class="haudong_top1">   
				<table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1">
        <tbody>
          <tr class="tr3 manage_b_tr1">
            <th width="100px">商品ID</th>
            <th width="100px">分类</th>
            <th width="140px">商品名称</th>
            <th width="140px">店铺名称</th>
            <th width="100px">价格</th>
            <th width="100px">部落价</th>
            <th width="80px"> 商品状态<br>（平台）</th>
            <!-- <th width="80px">上架<br>（推荐）</th> -->
            <th width="60px">排序</th>
            <th width="90px">上架时间</th>
            
          </tr>
          <?php if(isset($List) && count($List) >0){ 
            foreach ($List as $key => $val){?>
                <tr class="tr3 "> 
                	<th width="100px"><?php echo $val['product_id']; ?></th>
                    <th width="100px"><?php echo $val['cat_name']; ?></th>
                    <th width="140px"><?php echo $val['name']; ?></th>
                    <th width="140px"><?php echo $val['corporation_name']; ?></th>
                    <th width="100px"><?php echo $val['vip_price']; ?></th>
                    <th width="100px"><?php echo number_format($val['tribe_price'], 2, '.', ''); ?></th>
                    <!-- <th width="80px">已上架</th> -->
                    <th width="80px">
                      <?php if($val['status']==0){echo '未上架';}else{echo '已上架';}; ?>
                    </th>
                    <!-- <th width="80px"><?php 
                            switch ($val['status']){
                                case '1'://商品已上架
                                    ?>
                                    <a href="javascript:void(0);" onclick="edit(<?php echo $val['product_id'];?>,<?php echo isset($val['id'])? $val['id']:0;?>,2);" class="down">下架</a>
                                    <br>(状态:已上架) 
                                    <?php 
                                    break;
                                case '2'://商品未上架
                                    ?>
                                    <a href="javascript:void(0);" onclick="edit(<?php echo $val['product_id'];?>,<?php echo isset($val['id'])? $val['id']:0;?>,1);" class="up">上架</a>
                                    <br>(状态:下架)
                                    <?php 
                                    break;
                                case '': ?>
                                    <a href="javascript:void(0);" onclick="edit(<?php echo $val['product_id'];?>,<?php echo isset($val['id'])? $val['id']:0;?>,1);" class="up">上架</a>
                                        <br>(状态:下架)
                          <?php    break;
                            }
                    ?></th> -->
                    <th width="60px"><input type="text" value="<?php echo $val['sort'];?>"  class="sort" size="3"  id="sort<?php echo $val['id'];?>"  onblur="myblur(<?php echo $val['id'];?>,<?php echo $val['id'];?>);"></th>
                    <th width="90px"><?php echo $val['on_sale_at']; ?></th>
          		</tr>
          <?php } }?>
           
        </tbody>
      </table>
                     </div>     
                    
				<div class="jilu jilu2" id="none">
					<!-- <p>显示 <?php  echo ($page - 1)*$pagesize + 1;?> 到 <?php echo $page*$pagesize;?> 条数据，共 <?php echo $totalcount;?> 条数据</p>-->
					<p>显示 <?php
    // echo ($page - 1)*$pagesize + 1;
    if ($totalcount <= 0) {
        echo '0';
    } else {
        echo ($page - 1) * $pagesize + 1;
    }
    ?> 到 <?php
    // echo $page*$pagesize;
    if ($totalcount < $page * $pagesize) {
        echo $totalcount;
    } else {
        echo $page * $pagesize;
    }
    ?> 条数据，共 <?php
    echo $totalcount;
    ?> 条数据</p>
				</div>
				<div class="showpage" style="margin-right:30px;" id="pag">
				<?php echo $pagination;?>
                    	                </div>
                                        
			</div>
		</div>
		 </form>
	</div>



</div>

<script>	
function myblur(id,name){
	var id_name = 'sort'+name;
	var sort =  window.document.getElementById(id_name).value;
	var reg = /^[0-9]+.?[0-9]*$/;
	if(reg.test(sort)){
		$.ajax({
			 url:'<?php echo site_url('Tribe/ajax_sort_product');?>',
			 type:'post',
			 async: false,      //ajax同步  
			 data:{id:id,sort:sort
		        },
		        success:function(data){},
		        error:function(){}
			});
		}else{
		alert("请输入整数！");
		}
}


function edit(product_id,id,type){

	if(type == 1){
		var remin_str = "确定上架该商品？";
	}else{
		var remin_str = "确定下架该商品？";	
	}
	if(confirm(remin_str)){
    	 $.ajax({
    		 url:'<?php echo site_url('Tribe/ajax_edit_product');?>',
    	        type:'post',
    	        async: false,      //ajax同步  
    	        dataType:"json",
    	        data:{id:id,type:type
    		        },
    	        success:function(data){
	          	      if(type == 1){
		          	      if(data.Result == true){
			          	    	 location.reload();
			          	      }else{
				          	    	 alert("上架失败！");
				          	      }
		          	        }else{
		          	        	 if(data.Result == true){
		          	        		 location.reload();
			          	        	 }else{
				          	          alert("下架失败！");
			          	        	 }
		          	        }
    		        },
    	        error:function(){
    		        }
    		});
	}	
	
}
<?php $this->load->helper("ps");?>
function submit(){
  <?php if(!CheckTribePower("/Tribe/products")):?>
     history.back();
     alert('对不起你暂无权限');
  <?php endif;?>
	$('#form_search').submit();
}
$('[name="nice-select"]').click(function(e){
	$('[name="nice-select"]').find('ul').hide();
	$(this).find('ul').show();
	e.stopPropagation();
});
$('[name="nice-select"] li').hover(function(e){
	$(this).toggleClass('on');
	e.stopPropagation();
});
$('[name="nice-select"] li').click(function(e){
	var val = $(this).text();
	var dataVal = $(this).attr("data-value");
	$(this).addClass('bg-color').siblings().removeClass('bg-color');
	 /*$(this).addClass("on").siblings("on").removeClass("on");*/
	$(this).parents('[name="nice-select"]').find('input').val(val);
	$('[name="nice-select"] ul').hide();
	e.stopPropagation();
	$('#form_search').submit();
});
$(document).click(function(){
	$('[name="nice-select"] ul').hide();
	
});
</script>
