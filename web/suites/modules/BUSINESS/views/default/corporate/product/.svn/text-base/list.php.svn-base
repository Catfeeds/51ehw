<style>
table th{ line-height:normal}
table th{ line-height:normal;border:1px solid #dddddd; padding:10px 0; font-size:12px !important; }
.table1_1{ height:35px !important; background:#f6f6f6 !important;}
.search_2.manage_c_search_2{     margin: 3px 0;}
.cmRight_con.manage_c_cmRight_con table, .cmRight_con.manage_c_cmRight_con table a, .cmRight_con.manage_c_cmRight_con table p{ font-size:12px;}
.cmRight_con.manage_b_cmRight_con a{ font-size:13px;}
.huaznjj{ padding:0 15px; color:#dddddd !important;}
.cmRight_con.manage_a_cmRight_con ul li{ width:auto !important;margin: 0 0px 0 0;}
.cmRight_con.manage_c_cmRight_con .search_0{ height:50px; }
.search_1.manage_c_search_1{margin: 10px 0;}
.sdsda{ width:90px; margin:0 auto 0}
.sdsda a{ display:inline-block; float:left; width:35px; height:25px !important; line-height:25px !important; margin:5px;}
</style>
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li class="tCurrent"><a
			href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
			<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
        <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
	</ul>
</div>
<div class="Box manage_new_Box clearfix">
    <?php $this->load->view("corporate/navigation_goods");?><!-- 左侧导航栏 -->
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">全部商品</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px"><a
								href="<?php echo site_url('corporate/product/get_list');?>"
								<?php if(empty($types)&&$types=='')echo 'class="xcurrent"'; ?>>全部(<?php echo isset($all_count)?$all_count:'' ?>)</a><span class="huaznjj">|</span></li>
							<li><a
								href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/'.$type) ?>"
								<?php if(isset($types)&&$types=='sale')echo 'class="xcurrent"'; ?>>销售中(<?php echo isset($sale)?$sale:'' ?>)</a><span class="huaznjj">|</span></li>
							<li><a
								href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/'.$type) ?>"
								<?php if(isset($types)&&$types=='notsale')echo 'class="xcurrent"'; ?>>待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a><span class="huaznjj">|</span></li>
							<li><a
								href="<?php $type = 'not'; echo site_url('corporate/product/get_list/'.$type) ?>"
								<?php if(isset($types)&&$types=='not')echo 'class="xcurrent"'; ?>>已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="select1">
				<ul>
					<li><a href="<?php echo site_url("corporate/product/create");?>">添加</a></li>
					<li style="margin-right: 0"><a
						href="javascript:;" onclick=prompt(0,0,5);>删除</a></li>
				</ul>
				<ul style="margin-left: 7px ; width:auto;">
					<li style="margin-right: 0"><a href="javascript:;"
						onclick="prompt(1,0,1);">下架</a></li>
				</ul>
                 <div class="search_2 manage_fenlei_search_2 manage_c_search_2">
						<form
							action="<?php echo site_url('corporate/product/get_list') ?>"
							method="get" id="form_search">
							<div>
								<input type="text" class="search2_con manage_fenlei_search2_con"
									name="search_name"
									value="<?php echo isset($search)?$search:'' ?>" placeholder="搜索商品">
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:;" onclick="submit();">店内搜索</a>
							</div>
						</form>
					</div>
				<table width="910" height="34" border="1" cellpadding="0"
					cellspacing="0" class="table1_1">
					<tr class="tr1 manageC_tr">
						<th width="300px" style="text-align: left"><input type="checkbox"
							style="margin-right: 68px; margin-left: 15px"
							onclick="selectAll(this)">商品名称</th>
						<th width="76px">分类</th>
						<th width="102px">价格（货豆）</th>
						<th width="64px">总库存</th>
						<th width="100px">上下架</th>
						<th width="44px">排序</th>
						<th width="50px">收藏数</th>
						<th width="50px">销售量</th>
						<th width="122px">操作</th>
					</tr>
				</table>
				<form
					action="<?php echo site_url('corporate/product/product_sale') ?>"
					method="post" id="form1" name="form1">
					<?php foreach ($productList as $product):?>
					<table class="table_border">
						<tr class="tr1">
							<td colspan="9"
								style="text-align: left;background:#fff6eb;border:1px solid #dddddd;"><input
								type="checkbox" name="id[]"
								style="margin-right: 68px; margin-left: 15px"
								value="<?php echo $product['id']?>">商品ID : <?php echo $product['id']?> <span
								style="margin-left: 40px">商品编码：<?php echo $product['productnum']?></span>
								<span style="margin-left: 40px">上架时间：<?php echo $product['is_on_sale']== 1 ?$product['on_sale_at']:'未上架'; ?></span></td>
						</tr>
						<tr class="tr1">
							<th width="300px" style="text-align: left"><div class="tImg" style="float:none; display:inline-block;vertical-align:middle;">
							<?php if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){?>
							     <img alt="<?php echo $product['name'];?>"
										src="<?php echo $product['goods_thumb'] ? 'http://www.test51ehw.com/uploads/B/'.$product['goods_thumb']:'images/m_logo.jpg';?>">
							<?php }else{?>
							    <img alt="<?php echo $product['name'];?>"
										src="<?php echo $product['goods_thumb'] ? IMAGE_URL.$product['goods_thumb']:'images/m_logo.jpg';?>">
							<?php }?>
									
								</div>
								<p style="width: 146px;word-wrap: break-word; word-break: normal; line-height:normal; vertical-align:middle; "><?php echo $product['name']?></p></th>
							<th width="76px"><?php echo $product['cat_name']?></th>
							<th width="102px">
							 <?php if($product['cat_id'] != 104164){;?><!-- #共享服务分类104164 -->
                             <p style="margin-bottom:5px;">易货价<br><span style=" font-weight:bold;"><?php echo $product['vip_price']?></span></p><br>
                             <?php };?>
                             <?php if($product['tribe_price'] > 0){;?>
                                <p> 部落价<br><span style=" font-weight:bold;"><?php echo $product['tribe_price'];?></span></p>
                             <?php };?>
                             
                            
						</th>
							<th width="64px"><?php echo $product['cat_id'] != 104164?$product['stock']:"-";?></th><!-- #共享服务分类104164 -->
							<th width="100px">
						
						         <a href="javascript:void(0)"  onclick=prompt(<?php echo $product['is_on_sale'];?>,<?php echo $product['id'];?>,<?php echo $product['is_on_sale'];?>) style="color: #fca543; text-decoration: underline" id='<?php echo 'operation_'.$product['id'];?>'>
						         <?php switch ($product['is_on_sale']){
						             case 0:
						                 echo '申请上架';
						                 break;
					                 case 1:
		                                  echo '下架';
					                     break;
				                     case 2:
		                                  echo '取消申请';
				                         break;
			                         case 3:
		    		                     echo '上架';
			                             break;
		                             case 4:
		                                 echo '申请上架';
		                                 break;
						              }?>
						           </a><input type="hidden" id="<?php echo "commend_".$product['id'];?>" value="<?php echo $product['is_commend'];?>"><input type="hidden" id="<?php echo "is_on_sale_".$product['id'];?>" value="<?php echo $product['is_on_sale'];?>"><br> 
						         <a href="javascript:void(0)" style="color: #aeaeae; text-decoration: underline" id='<?php echo 'status_'.$product['id'];?>'>
						         状态：<?php switch ($product['is_on_sale']){
						             case 0:
						                 echo '下架';
						                 break;
					                 case 1:
		                                  echo '上架';
					                     break;
				                     case 2:
		                                  echo '审核中';
				                         break;
			                         case 3:
		    		                     echo '审核通过';
			                             break;
		                             case 4:
		                                 echo '审核不通过';
		                                 break;
						              }?>
						         </a>
							</th>
							<th width="44px"><?php echo $product['sequence']?></th>
							<th width="50px"><?php echo $product['fav_count']?></th>
							<th width="50px"><?php echo $product['sales_count']?></th>
							<th width="122px">
                            <div class="sdsda"><a id="<?php echo 'edit_'.$product['id']; ?>"
								href="<?php echo ($product['is_on_sale']==0 || $product['is_on_sale']==4)?site_url('corporate/product/edit/'.$product['id']):'javascript:void(0);';?>"
								style="color: #fff; background: #fca543;border-radius: 4px; text-decoration: underline">编辑</a>
                                <a
								href="javascript:;" onclick=prompt(0,<?php echo $product['id'] ?>,5); 
								style="color:#999999;background:#dddddd; border-radius: 4px; text-decoration: underline">删除</a>
                                <a
								href="<?php echo site_url("goods/detail/".$product['id']."/1");?>"
								target="_blank"
								style="color: #fff;background: #fca543; border-radius: 4px; text-decoration: underline">预览</a>
								
								<?php if($is_customer){?>
								    <a target="_blank" onclick="copypro(<?php echo $product['id'];?>);" style="color: #fff;background: #fca543; border-radius: 4px; text-decoration: underline">复制</a></div>
								<?php }?>
								</th>
						</tr>
					</table>
					<?php

endforeach 
    ;
    if (count($productList) === 0) {
        ?></form>
        <div class="result_null" style="margin-top:10px;">暂无内容，请点击上面添加按钮来添加产品</div>
				    
				<!--<table>
					<tr class="tr1">
						<td colspan="9" style="text-align: center">请点击上面添加按钮来添加产品。</td>
					</tr>
				</table>-->
						<?php
    }
    ?>

				<div class="jilu jilu2">
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
				<div class="showpage">
					<?php echo $pagination;?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

function copypro(id){
	if(confirm("确定复制该商品？")){
		$.ajax({
			url:'<?php echo site_url("goods/copyproduct/");?>/'+id,
			type: 'post',
			dataType: 'json',
			 success: function (data){
				 if(data['Result']){
		    		 alert('复制成功!商品ID为'+data['pro_id']);
			    	}else{
			    	 alert('复制失败，请重试!');
				    }
				 },
			 error:function(){
				 alert('网络错误，请重试!');
				 }	 
			});
		}
}

function submit(){
	$('#form_search').submit();
}

function hiding(){
	$('.dingdan4_3_tanchuang').css('display','none');
}
/**
 * 操作提示1
 * @param $status '产品状态0:上架 1:下架 2:取消上架 3:上架 4:上架' 
 */
function prompt($type,$id,$status){
    switch($status){
    case 0:
    	$('#prompt').text('确定要把该商品申请上架吗？');
        $('#sure').attr("onclick","is_nosale("+$type+","+$id+")");
    	break;
    case 1:
    	var id = new Array();
    	var i = 0;
    	var a = false;//临时判断使用
    	if($id){
            var is_commend = $("#commend_"+$id).val();
            if(is_commend==1 && $status==1){
                alert("推荐商品不能下架");return ;
                }
            id[i] = $id;
        }else{
        	$("input[name='id[]']").each(function () {
        	    	if($(this).is(":checked"))
        			{
        	    		var is_commend = $("#commend_"+$(this).val()).val();
        	    		var is_on_sale = $("#is_on_sale_"+$(this).val()).val();
        	    		if(is_on_sale==1){
            	            if(is_commend==1 && $status==1){
                	            a = true;
            	                }else{
            	                	id[i++] = $(this).val();
                	                }
        	    		}
        	    		
        			}
            });
        }
        if(a){
        	alert("推荐商品不能下架");
        	return;
            }else if(id == ''){
        	alert('请选择要下架的商品');
    	    return false;
        }
        
    	$('#prompt').text('确定要把该商品下架吗？');
        $('#sure').attr("onclick","is_nosale("+$type+","+$id+")");
    	break;
    case 2:
    	$('#prompt').text('确定要把该商品取消申请吗？');
        $('#sure').attr("onclick","is_nosale("+$type+","+$id+")");
    	break;
    case 3:
    	$('#prompt').text('确定要把该商品上架吗？');
        $('#sure').attr("onclick","is_nosale("+$type+","+$id+")");
    	break;
    case 4:
    	$('#prompt').text('确定要把该商品申请上架吗？');
        $('#sure').attr("onclick","is_nosale("+$type+","+$id+")");
    	break;
    case 5:
    	var id = new Array();
    	if($id){
    		id[0] = $id;
    	    }else{
    		var id = new Array();
        	var i = 0;
        	$("input[name='id[]']").each(function () {
        	    	if($(this).is(":checked"))
        			{
        	    		 id[i++] = $(this).val();
        			}
            });
    		}
    	if(id==''){
    		alert('请选择要删除的');
    		return;
    	}
    	$('#prompt').text('确定要把该商品删除吗？');
        $('#sure').attr("onclick","delects("+$id+")");
    	break;
    }
    $('.dingdan4_3_tanchuang').css('display','block');
}


/**
 * ajax 上架or下架
 * @param $status '产品状态0:申请上架 1:下架 2:取消申请 3:审核不通过 4:审核通过'
 */
function is_nosale($status,$id){
	var obj = $('#operation_'+$id);
	$('.dingdan4_3_tanchuang').css('display','none');
	var id = new Array();
	var i = 0;
    if($id){
        var is_commend = $("#commend_"+$id).val();
        if(is_commend==1 && $status==1){
            alert("推荐商品不能下架");return ;
            }
        id[i] = $id;
    }else{
    	$("input[name='id[]']").each(function () {
    	    	if($(this).is(":checked"))
    			{
    	    		    id[i++] = $(this).val();
    			}
        });
    }

//     if(id == ''){
//     	alert('请选择要下架的商品');
// 	    return false;
//     }else{
    	$.post('<?php echo site_url('corporate/product/product_nosale');?>',{id:id,status:$status},function (data){
            if(data > 0){
                if($id == 0){
                	alert('商品已下架');
                	$("input[name='id[]']").each(function () {
            	    	if($(this).is(":checked")){
            	    		id_product = $(this).val();
            	    		$('#edit_'+id_product).attr('href','<?php echo site_url("corporate/product/edit")?>'+'/'+id_product);
            	    		$('#operation_'+id_product).text('申请上架');
                			$('#status_'+id_product).text('状态：下架');
                			$('#operation_'+id_product).attr("onclick","prompt(0,"+id_product+",0)");
            			}
         	    	   });
                    }else{
                        switch ($status){
                        case 0:
                        	$('#edit_'+$id).attr('href','javascript:void(0);');
                        	$(obj).attr("onclick","prompt(2,"+$id+",2)");
                        	$(obj).text('取消申请');
                            $(obj).next().next().text('状态：审核中');
                            break;
                        case 1:
                            $('#edit_'+$id).attr('href','<?php echo site_url("corporate/product/edit")?>'+'/'+$id);
                     	    $(obj).attr("onclick","prompt(0,"+$id+",0)");
                        	$(obj).text('申请上架');
                            $(obj).next().next().text('状态：下架');
                            break;
                        case 2:
                        	$('#edit_'+$id).attr('href','<?php echo site_url("corporate/product/edit")?>'+'/'+$id);
                        	$(obj).attr("onclick","prompt(0,"+$id+",0)");
                        	$(obj).text('申请上架');
                            $(obj).next().next().text('状态：下架');
                            break;
                        case 3:
                        	$('#edit_'+$id).attr('href','javascript:void(0);');
                        	$(obj).attr("onclick","prompt(1,"+$id+",1)");
                        	$(obj).text('下架');
                            $(obj).next().next().text('状态：上架');
                            break;
                        case 4:
                        	$('#edit_'+$id).attr('href','javascript:void(0);');
                        	$(obj).attr("onclick","prompt(1,"+$id+",1)");
                        	$(obj).text('取消申请');
                            $(obj).next().next().text('状态：审核中');
                            
                            break;;
                         }
                    }
                
            }else{
                alert('操作失败');
                }
            });

// 		}
}

function selectAll(obj)
{
	var flag = $(obj).is(':checked');

	$("input[name='id[]']").each(function () {

		 $(this).prop("checked",flag);

      });
	//$(".selectAll").each(function(){$(this).prop("checked",flag);});
}

function noNumbers(e)

{

var keynum

var keychar

var numcheck

if(window.event) // IE

{

keynum = e.keyCode

}

else if(e.which) // Netscape/Firefox/Opera

{

keynum = e.which

}

keychar = String.fromCharCode(keynum);

//判断是数字,且小数点后面只保留两位小数

if(!isNaN(keychar)){

var index=e.currentTarget.value.indexOf(".");

if(index >= 0 && e.currentTarget.value.length-index >2){

return false;

}

return true;

}

//如果是小数点 但不能出现多个 且第一位不能是小数点

if("."== keychar ){

//if(e.currentTarget.value==""){

return false;

//}

/*if(e.currentTarget.value.indexOf(".") >= 0){

return false;

}*/

return true;

}

return false  ;

}

/**
 * ajax 批量删除
 * @param $id 商品id
 */
function delects($id){
	var id = new Array();
	if($id){
		id[0] = $id;
	}else{
		var id = new Array();
    	var i = 0;
    	$("input[name='id[]']").each(function () {
    	    	if($(this).is(":checked"))
    			{
    	    		 id[i++] = $(this).val();
    			}
        });
		}
// 	if(id!=''){
    $.post("<?php echo site_url('corporate/product/delete');?>",{id:id},function(data){
        if(data){
            window.location = "<?php echo site_url('corporate/product/get_list');?>";
            }
        });
// 	}else{
// 		alert('请选择要删除的');
// 		}
}

</script>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=hiding()>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->