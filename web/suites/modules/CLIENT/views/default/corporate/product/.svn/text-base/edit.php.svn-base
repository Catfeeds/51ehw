<style> 
.form-group input{height:27px;float:left;width:60px};
</style>
<script type="text/javascript">
<!--
var clickTimes = 0; //标记点击规格checkbox的点击次数
var createFlag = 0; //标记表头行是否已经创建
var tableflag = false;
val_boj = '';
var skuIDArray = new Array();
var skuNameArray = new Array();

Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};
Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

function skuClick(event, categoryID)
{
// 	alert(event);
	
	var is_check = false;
	var name = $('#sku_ul_'+categoryID).parent().prev('label').html()
	name = name.substr(0,name.length-1);
	
	$('#sku_ul_'+categoryID).find('input[type=checkbox]').each(function (){
		if ($(this).is(':checked')) { 
			is_check = true;
      }
    });
    
	 var a = skuIDArray.indexOf(categoryID);
	 var b = skuNameArray.indexOf(name);
	 del =false;
	 tableflag = false;
	
	 if(a == '-1' && is_check){ 
	 	 skuIDArray.push(categoryID);	
		 skuNameArray.push(name);	 
     }else if(!is_check){ 
//          alert('删除');
    	 del = true;
    	 skuIDArray.remove(categoryID);
    	 skuNameArray.remove(name);
     }
     
	 if(a== '-1'){ 
		 tableflag = false;
		 
     }else if((a >= 1 || !a) && !del){ 
        
    	 tableflag = true;
    	 
     }
     
      if(skuIDArray.length == 0 ){ 
         
    	 $('#sku_table_body tr').eq(0).remove();
    	 $('#sku_area').hide();
    	 if($("input[name='is_special_price']").val()==1){ 
        	 $('#tejia').show();
         }
    	 return;
     }else{ 
    	 $('#tejia').hide();
     }
      
     
	 event = event ? event : window.event;
     var eventSrc = event.srcElement ? event.srcElement : event.target;
     
	if ($(eventSrc).prop("checked")) {
		//点选一个规格值，将其值可编辑（span隐藏，input文本框显示）
		$("label", $(eventSrc).parent()).hide();
		$("input[type=text]", $(eventSrc).parent()).css("display", "inline");

		
	} else {
		//取消一个规格值，将其值可编辑（span显示，input文本框隐藏）
		$("label", $(eventSrc).parent()).css("display", "inline");
		$("input[type=text]", $(eventSrc).parent()).css("display", "none");


	}
	
	//判断是否可以建表
	checkTable(val_boj);
	
// 	alert(skuIDArray);
}

//修改SKU值
function changesku(obj,categoryid,id)
{
	var oldval = $(obj).parent().find("input[type=checkbox]").val();
	var val = $(obj).val().replace(/^\s/g, "").replace(/\s$/g, "");
	if(oldval != val)
	{
		$('#sku_table').find("td[id^='title_']").each(function(){
			//alert($(this).attr("id"));
			if($(this).attr("id") == "title_"+categoryid+"-"+id)
			{
				$(this).html($(obj).val());
			}
		});
		/*$('#sku_table').find("#title_"+categoryid+"-"+id).each(function(){
			$(this).html($(obj).val());
		});*/
		$(obj).parent().find("input[type=checkbox]").value=val;
		$(obj).parent().find("label").html(val);
	}
}


//判断是否可以建表
function checkTable(defaultval)
{
//     val_boj = defaultval;
	
// 	alert(defaultval);
	var tableArray =new Array();
	var tableIDArray =new Array();
	var tflag = true;

	
	for(var i=0;i<skuIDArray.length;i++)
	{
		if(tableArray[i] == null)
		{
			tableArray[i] = new Array();
			tableIDArray[i] = new Array();
		}
		var flag = false;
		var l = 0;
		$('#sku_ul_'+skuIDArray[i]).find('input[type=checkbox]').each(function () { //循环该分类下SKU
			if ($(this).prop("checked")) { 
				   tableArray[i].push($(this).parent().find('input[type=text]').val());//获取选中的SKU名字赋值
				   tableIDArray[i].push(skuIDArray[i]+'-'+l); //519-1;//
				   
					flag = true;
                }else
				{
					for(var j=0;j<tableArray[i].length;j++)
					{
						if(tableArray[i][j] == $(this).val()){
							//alert("ddd"+j);
							tableArray[i].splice(j,1);
							tableIDArray[i].splice(j,1);
						//tableIDArray[i][j].remove();
						//alert("tt"+j);
						//tableIDArray[i].removeByIndex(j);
						//tableArray[i].removeByIndex(j);
						break;
						}
					}
				}
				l++;
		});
		
		tflag = tflag && flag;
	}
	
	if(tflag && !tableflag)
	{
		$('#sku_area').show();
		tableflag = true;
		//可以建表
		
		//表头
		var str = '<thead class="no-border">'+
                       '<tr>';

				for(var i=0;i<skuNameArray.length;i++)
				{
					str = str+"<th>"+skuNameArray[i]+"</th>";
				}
		
					str =	str + '<th style="display:none">价格</th><th>易货价</th><th>特价</th><th>库存</th><th class="text-right">商家编码</th>'+
						'</tr>'+
					'</thead>'+
					'<tbody class="no-border-x no-border-y sku_body" id="sku_table_body">';

		 //内容
		 var idlist = doExchange(tableIDArray,"_");
		 var valuelist = doExchange(tableArray,"|*|");

		if(defaultval != "" )
		{
			 //有数据需要回填
			 var dval = JSON.parse(defaultval);
			 for(var i=0;i<valuelist.length;i++)
			{
				 var val = "";
				 for(var j=0;j<dval.length;j++)
				 {
// 					 alert(dval[j]["sku_key"]+"!!!"+idlist[i]);
					if(dval[j]["sku_key"] == idlist[i])
					{
						//alert("aldjflaslf");
						val = dval[j];
						break;
					}
				 }
				 
				str = str+getRow(idlist[i],valuelist[i],val);
				
			 }
		}
		else
		{

			for(var i=0;i<valuelist.length;i++)
			{
				 str = str+getRow(idlist[i],valuelist[i],"");
			}
		}
		
		 str = str +"</tbody>";

		$('#sku_table').html(str);

	}
	else if(!tflag && tableflag){
		
		//删除表
		$('#sku_area').hide();
		
		 tableflag = false;//记得重置变量，不然需要重新建表时不执行建表。
	}else
	{
		var idlist = doExchange(tableIDArray,"_");
		var valuelist = doExchange(tableArray,"|*|");
		
		// 减
		$("#sku_table").find("input[type=hidden]").each(function(){
			var flag = false;
			for(var i=0;i<idlist.length;i++)
			{
				if($(this).val() == idlist[i])
				{
					flag = true;
					break;
				}
			}
			if(!flag)
			{
				//删除
				$(this).parent().parent().remove();
			
			}

			//alert($(this).val());
		});

		//加
// 		alert(idlist);
		var temp_obj;
		for(var i=0;i<idlist.length;i++)
		{
// 			alert(idlist[i]);
// 			alert($('#'+idlist[i]).length)
			if(!$('#'+idlist[i]).length)
			{
				//alert("1111111");
// 				alert(getRow(idlist[i],valuelist[i],""));
				if(temp_obj)
				{
					temp_obj.after(getRow(idlist[i],valuelist[i],""));
				}else
				{
					temp_obj =  $("#sku_table tr").eq(1);
					temp_obj.before(getRow(idlist[i],valuelist[i],""));
					temp_obj =  $("#sku_table tr").eq(1);
				}
				
				
			}
			else
			{
// 				alert($('#id_'+idlist[i]).parents("tr"));
				temp_obj = $('#'+idlist[i]).parents("tr");
				
			}
			//var row = $("#sku_table").find("tr").eq(i);

		}
		
	}
}

//递归
function doExchange(doubleArrays,flag){
		var len=doubleArrays.length;
		if(len>=2){
			var len1=doubleArrays[0].length;
			var len2=doubleArrays[1].length;
			var newlen=len1*len2;
			var temp=new Array(newlen);
			var index=0;
			for(var i=0;i<len1;i++){
				for(var j=0;j<len2;j++){
					temp[index]=doubleArrays[0][i]+flag+
						doubleArrays[1][j];
					index++;
				}
			}
			var newArray=new Array(len-1);
			for(var i=2;i<len;i++){
				newArray[i-1]= doubleArrays[i];
			}
			newArray[0]=temp;
			return doExchange(newArray,flag);
		}
		else{
			return doubleArrays[0];
		}
	}

//行内容
function getRow(id,val,defaultval)
{

			var names = val.split("|*|");
			var ids = id.split("_");
			
			var str = "";
			str = str+"<tr>";
			for(var j=0;j<names.length;j++)
			{
				str = str+"<td style='width:100px;' class='title' id='title_"+ids[j]+"'>"+names[j]+"</td>";
			}

			str = str+'<td style="display:none"><input name="skuprice[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["price"])+'" type="text"><input id="'+id+'" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" type="hidden" name="skuids[]" value="'+id+'"/></td>'+
				'<td><input name="sku_m_price[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["m_price"])+'" type="text"></td>'+
				'<td><input name="sku_special_offer[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["special_offer"])+'" type="text"></td>'+
				'<td style="display:none"><input name="sku_mix_rmb_price[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["mix_rmb_price"])+'" type="text"><input name="sku_mix_m_price[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')"  value="'+(defaultval==""?"":defaultval["mix_m_price"])+'" type="text"></td>'+
                      '<td><input name="skustore[]" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["store"])+'" class="input-mini" type="text" onblur="stockpile();"></td>'+
                      '<td class="text-right" style="width:120px;"><input name="skunum[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["plus_no"])+'" type="text"></td>';

			return str+'</tr>';
}
//-->
  
function formatCurrency(num) {  
    num = num.toString().replace(/\$|\,/g,'');  
    if(isNaN(num))     
        num = "0";  
    sign = (num == (num = Math.abs(num)));  
    num = Math.floor(num*100+0.50000000001);  
    cents = num%100;  
    num = Math.floor(num/100).toString();  
    if(cents<10)  
    cents = "0" + cents;  
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)  
    num = num.substring(0,num.length-(4*i+3))+','+  
    num.substring(num.length-(4*i+3));  
    return (((sign)?'':'-') + num + '.' + cents);  
}
</script>


<div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
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
    <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>
<script type="text/javascript" src="js/jedate/jedate.js"></script>

<style>
.webuploader-container{ top:-85px; left:161px;}  
.update_tips{top:-39px;}
.new_edit_box .p3{ text-align: left; width:auto;}
.new_edit_box .p2{ width:118px;}
.new_edit_box .weidu{ color:#fea33b; text-decoration:underline;}
</style>

<form method="post"
	action="<?php echo site_url("corporate/product/save"); ?>"
	name="product_form" enctype="multipart/form-data" class="productform">
	<input type="hidden" name="see" value="0">
	<div class="Box manage_new_Box clearfix">
		<div class="cmLeft manage_new_cmLeft">
			<div class="downTittle manage_new_downTittle menu_manage_downTittle">商品管理</div>
			<div class="cmLeft_down">
				<ul>
				<li class="houtai_zijin_current"><a href="<?php echo site_url("corporate/product/create");?>">发布商品</a></li>
				<li><a href="<?php echo site_url('corporate/product/get_list');?>">全部商品(<?php echo isset($all_count)?$all_count:'' ?>)</a></li>
				<li><a href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">销售中(<?php echo isset($sale)?$sale:'' ?>)</a></li>
				<li><a href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a></li>
				<li><a href="<?php $type = 'not'; echo site_url('corporate/product/get_list/0/'.$type) ?>">已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
				<li><a href="<?php echo site_url('corporate/section/get_list');?>">分类管理</a></li>
				<!--<li><a href="#">售后管理</a></li>-->
				</ul>
			</div>
		</div>
		<div
			class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
			<div class="cmRight_tittle">发布产品</div>
			<div class="new_cmRight_con new_m_edit">
				<!--cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con-->
				<h2>1. 基本信息</h2>
				<p>
					<label>商品类目：</label> <span>
				<?php echo $category;?>
				<input name="re_edit" id="re_edit" type="hidden" value="0"> <input
						name="id" id="id" type="hidden"
						value="<?php echo $editing['id']?>" /> <input name="cat_id"
						id="cat_id" type="hidden" value="<?php echo $editing['cat_id']?>" />
					</span>
				</p>



				<p>
					<label>站内分类：</label> <span> 
					<select data-placeholder="请点击选择分类" style="width: 350px;" multiple class="chzn-select" tabindex="8" name="section_id[]">
						<?php
						$temp = "";
						$flag = false;
						foreach ( $sections as $section ) {
							
							if ($temp == "" || ($temp != "" && $section ["pid"] == 0)) {
								if ($temp != "" && $flag) {
									echo "</optgroup>";
								}
								$temp = $section ["fpath"];
								$flag = false;
								foreach ( $sections as $s ) {
									if (strpos ( $s ["fpath"], $temp . "," ) === 0) {
										$flag = true;
										break;
									}
								}
								if ($flag) {
									
									?>
													<optgroup label="<?php echo $section["section_name"]?>">
													<?php }else{?>
														<option value="<?php echo $section["id"]?>"
									<?php if(isset($editing['section_ids']) && (strpos($editing["section_ids"],",".$section["id"].",")===0 || strpos($editing["section_ids"],",".$section["id"].",")>0)){ echo "selected";} ?>><?php echo $section["section_name"]?></option>
													<?php
								}
							} else {
								?>
														<option value="<?php echo $section["id"]?>"
									<?php if(isset($editing['section_ids']) && (strpos($editing["section_ids"],",".$section["id"].",")===0 || strpos($editing["section_ids"],",".$section["id"].",")>0)){ echo "selected";} ?>><?php echo $section["section_name"]?></option>
													<?php
							}
							
							?>
													
													
						<?php
						}
						?>	
                              </optgroup>
					</select>
					</span><a href="<?php echo site_url("corporate/section/add");?>"
						class="btn_addchannel">添加新分类</a>
				</p>

				<div class="line" style="margin: 60px 0 30px 0"></div>

				<h2>2. 商品信息</h2>
				<div class="cpMessage">
					<div class="new_edit_box">
						<label><span>*</span> 商品编号：</label> 
						<?php if($editing['productnum']==""): ?>
						<input type="text"
							name="productnum" class="p1" required datatype="*"
							nullmsg="请输入商品编号！" value="<?php echo $editing['productnum'];?>">
							<span class="tishi" style="color:red" id="pronum"></span>
					    <?php else:?>
					    <?php echo $editing['productnum'];?>
					    <input type="text" name="productnum"  hidden value="<?php echo $editing['productnum'];?>">
					    <?php endif;?>
					</div>
					<div class="new_edit_box">
						<label><span>*</span> 商品名称：</label> <input type="text" name="name"
							class="p1" required datatype="*" nullmsg="请输入商品名称！"
							value="<?php echo $editing['name'];?>" id="proname">
							<span class="tishi" style="color:red" id="nameerror"></span>
					</div>
					<div class="new_edit_box">
						<label>换货价货豆：</label> <input type="text" name="vip_price"
							class="p1" value="<?php echo !empty($editing['vip_price'])?$editing['vip_price']:1;?>" datatype="/^\d+(\.\d+)?$/">
					<span class="tishi" style="color:red" id="vip_price_message"></span></div>
					<!-- <div class="new_edit_box">
						<label>零售价货豆：</label> <input type="text" name="m_price" class="p1"
							 datatype="/^\d+(\.\d+)?$/" value="<?php echo !empty($editing['m_price'])?$editing['m_price']:1;?>">
					</div>-->

					<div class="new_edit_box">
						<label>默认销售量：</label> <input type="text" name="sales_count"
							class="p1"  datatype="n"
							value="<?php echo !empty($editing['sales_count'])?$editing['sales_count']:0;?>">
					</div>
					<div class="new_edit_box">
						<label>默认收藏数：</label> <input type="text" name="fav_count"
							class="p1"  datatype="n"
							value="<?php echo !empty($editing['fav_count'])?$editing['fav_count']:0;?>">
					</div>
					<div class="new_edit_box"></div>


          

				</div>

				<div class="line"></div>
				<div id="attr_list">
									<?php foreach($attributes as $key => $attr) :  ?>
									 <div class="new_edit_box <?php echo 'attr_set_'.$attr['attr_set_id'];?>">
						               <label style="vertical-align: top;"><?php echo $attr['attr_name'] ?>：</label>
						               <div class="edit_box_con">
											<?php
										echo build_attr_html ( $attr ['attr_type'], $attr ['id'], $attr ['option_values_array'], $attr ['default_value'] );
										
										?>	
										</div>
					                 </div> 
									<?php
										$skuflag = false;
										if ($attr ["attr_type"] == "sku" && !empty($attr['check']) ) {
											$skuflag = true;
// 											echo '<pre>';
// 											var_Dump($attr);
											?>
										<script>
										skuIDArray.push(<?php  echo $attr["id"];?>);
										</script>
					                    <script>
					                    skuNameArray.push('<?php echo $attr["attr_name"]?>');
					                    </script>
									<?php }?>
									<?php endforeach; ?>
		  					        <?php foreach($editing['attr_list'] as $attr) : ?>
							         <div class="form-group <?php echo 'attr_set_'.$editing['attr_set_id'];?>">
											<label class="col-sm-3 control-label"><?php echo $attr['attr_name'] ?></label>
											<div class="col-sm-6">
									<?php
										if ($attr ['attr_type'] != 'checkbox') {
// 											echo build_attr_html ( $attr ['attr_type'], $attr ['id'], $attr ['option_values_array'], $attr ['attr_value'] );
										} else {
											echo build_attr_html ( $attr ['attr_type'], $attr ['id'], $attr ['option_values_array'], $attr ['attr_values'] );
										}
										?>	
								            </div>
									 </div>
		  					         <?php endforeach; ?>

				</div>

				<!--表格 开始-->
				<div class="form-group cpMessage3" id="sku_area"
					style="display: none">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-9">
						<table id="sku_table" class="sku_tab">
							<!-- <thead class="no-border sku_thead">
								<tr>
									<th>颜色分类</th>
									<th>净含量</th>
									<th>价格</th>
									<th>数量</th>
									<th class="text-right" style="width:120px;">商家编码</th>
								</tr>
							</thead>
							<tbody class="no-border-x no-border-y sku_body" id="sku_table_body">

							</tbody>-->
						</table>
					</div>
				</div>

				<!--表格 结束-->
				<!--商品sku 结束-->

				<div class="new_edit_box">

					<label><span>*</span> 总库存：</label> <input type="text" name="stock"
						class="p1" value="<?php echo $editing['stock'];?>" datatype="n">


				</div>
				<div class="new_edit_box">
					<label>是否设置特价：</label> <input type="checkbox" name="is_special_price" onclick="is_special(this)" class="p1"  value="<?php echo $editing['is_special_price'];?>" <?php echo $editing['is_special_price']?'checked':"";?>>
				</div>
				<span id="tejia" <?php if(!$editing['is_special_price'] ){echo 'hidden';}?>>
				<div class="new_edit_box">
        		<label>特价价格：</label><input type="text" name="special_price" class="p1" value="<?php echo $editing['special_price'];?>" datatype="/^\d+(\.\d+)?$/" >
        		</div><br/><span class="tishi" style="color:red" id="special"></span></span>
        		<span id="tejia_time" <?php if(!$editing['is_special_price'] ){echo 'hidden';}?>>
        		<div class="new_edit_box">
        		<label>特价时间：</label><input class="datainp" name="special_price_start_at" id="start_at" type="text" value="<?php echo $editing['special_price_start_at'];?>" placeholder="请选择"  readonly><input class="datainp" name="special_price_end_at" id="end_at" type="text" value="<?php echo $editing['special_price_end_at']?$editing['special_price_end_at']:date('Y-m-d H:i:s',strtotime("+1 day"));?>" placeholder="请选择"  readonly>
        		<br/><span class="tishi" style="color:red" id="time_interval"></span>
        		</div>
				</span>
				
				<?php if($editing['id'] != 0 && count($images) > 0):?>
				<div class="new_edit_box clearfix">
					<label><span class="red">*</span>已有商品图片：</label>
					<div class="parentFileBox" style="margin-left:150px;">
						<ul class="fileBoxUl">
						<?php foreach ($images as $image):?>
							<li id="fileBox_<?php echo $image['id'];?>" class="diyUploadHover">
								<div class="viewThumb">
									<img src="<?php echo IMAGE_URL.$image['file']?>">
								</div>
                                
                                    
								<div class="diyCancel" onclick="diyCancel(this,<?php echo $editing['id'] ?>)"><input type="hidden" value="<?php echo $image['id']; ?>"><input type="hidden" value="<?php echo $image['image_name'];?>"><input type="hidden" value="<?php echo $image['id']; ?>"><input type="hidden" value="<?php echo $image['file_ext'];?>"></div>
								<div class="diySuccess"></div>
								<div class="diyFileName"><?php echo $image['original_name'].$image['file_ext'];?></div>
                                <!--设置默认图片按钮 开始-->
                          		<div class="fileBox_btn" hidden><a class="fileBox_btnImg <?php echo $image['is_base']==1?"flieBox_btnDefault":"" ?>" onclick="setIsbase(this,<?php echo $image['id'] ?>)"><?php echo $image['is_base']==1?"当前为默认图片":"设置为默认图片" ?></a></div><!--当显示为当前默认图片 调用class flieBox_btnDefault 的样式-->
                                <!--设置默认图片按钮 结束-->
							</li>

							<?php endforeach;?>
						</ul>
                        
					</div>
				</div>
				<?php endif;?>
                
				<div class="new_edit_box clearfix ">

					<label><span class="red">*</span>商品图片：</label>
					<!--图片上传 开始-->

					<div id="box">
					   <div class="update_tips">需要设置默认图片，请先保存商品，鼠标移至图片处即可设置。</div>
					   <div class="update_tips">图片最小不得小于100K，最大不得超过5M</div>
						<div id="test"></div>
						
					</div>
					<!--<div id="demo">
                        <div id="as" ></div>
                    </div>-->
					<!--图片上传 结束-->



				</div>
				<!-- 经纬度 -->
				<div class="new_edit_box">
					<label>地址：</label><input style=" margin-left:9px;" type="text" name="address" class="p1" oninput="region()" value="<?php echo !empty($editing['address'])?$editing['address']:null?>"><a target="_blank" id="baidu_api" <?php echo empty($editing['address'])?"hidden":null?>><span class="icon-coordinate" style="color: #fea33b"> </span></a>
				    <span class="tishi" style="color:red" id="address_"></span>
				</div>
				
					
                 <div class="new_edit_box">
					<label>地址经度：</label> <input id="longitude" type="text" name="longitude"
						class="p2" value="<?php echo !empty($editing['longitude'])?$editing['longitude']:null?>" oninput="">
                     <label class="p3">地址纬度：</label> <input id="latitude" type="text" name="latitude"
						class="p2" value="<?php echo !empty($editing['latitude'])?$editing['latitude']:null?>" oninput="">
						 <span><a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" class="weidu" target="_blank">经纬度查询工具</a></span>
				</div>
				<span class="tishi" style="color:red" id="long_and_lat"></span>
				<div class="new_edit_box">
					<label>简短描述：</label> <input id="txtTitle" type="text" name="short_desc"
						class="p1" value="<?php echo $editing['short_desc'];?>" oninput="notifyTextLength();">
						 当前已输入<span id="inputedWord" style="color:red"></span> 还可以输入<span id="inputtingWord" style="color:Red;"></span>
				</div>

				<div class="new_edit_box clearfix">
					<label>商品描述：</label>
					<span>(图片大小不超过2M)</span>
					<textarea class="ckeditor p1" name="desc" id="content">
							<?php echo $editing['desc'];?></textarea>
				</div>
				
				<div class="new_edit_box clearfix">
				<p>
					<label>发布站点：</label>
					<select  name="app_id" class="app_id_1">
					   <option value="1">本地站</option>
					   <option value="0" <?php echo isset($editing["app_id"])&&$editing["app_id"]==0?"selected":"" ?>>全国站</option>
					
					</select>
				</p>
				</div>
                
                <div class="new_edit_box clearfix">
                    <div class="yufei">运费设置：<span class="yufei_1"><input type="radio"  value="1"name="is_freight" id="sub" onchange="change1();" <?php echo !empty($editing["logistics_id"])?"checked":""; ?>>自定义运费</span>
                    <span class="yufei_2"><input type="radio" value="0" placeholder="请输入金额" name="is_freight" id="sub_2" onchange="change();" <?php echo !empty($editing["logistics_id"])?"":"checked"; ?>>免运费</span>
                    <div class="sub_1">
                        <?php if($logistics){?>
                        <p>
                        <label>使用以下模板：</label>
                        <select  name="logistics_id" class="app_id_1">
                        <?php foreach ($logistics as $v){;?>
                        <option <?php echo (!empty($editing["logistics_id"]) && $v["id"]==$editing["logistics_id"])?"selected":""?> value="<?php echo $v["id"]?>"><?php echo $v["name"]?></option>
                        <?php };?>
                        </select>
                        </p>
                        <?php };?>
                    <span><a href="<?php echo site_url("Corporate/Logistics/logistics_list");?>" style="color:#fe4104">模版管理</a></span>
                   	</div>
                    </div>
                </div>
                
				<div class="line"></div>

				<h2>3. 推广相关</h2>

				<div class="new_edit_box">
					<label>是否上架：</label> <input type="checkbox" name="is_on_sale"
						class="p1" id="p1_1" value="<?php echo $editing['is_on_sale'];?>" checked>
				</div>
				<div class="new_edit_box">
					<label>Meta标题：</label> <input type="text" name="meta_title"
						class="p1" value="<?php echo $editing['meta_title'];?>">
				</div>
				<div class="new_edit_box">
					<label>Meta关键字：</label> <input type="text" name="meta_keywords"
						class="p1" value="<?php echo $editing['meta_keywords'];?>">
				</div>
				<div class="new_edit_box">
					<label>Meta描述：</label> <input type="text" name="meta_desc"
						class="p1" value="<?php echo $editing['meta_desc'];?>">
				</div>


				<div class="save manage_b_save">
					<ul>
						<li <?php if(!isset($editing['id']) && !$editing["id"]!=0):?>style="background:#ccc"<?php endif;?>>
                        	<a id="btn_sub" <?php if(!isset($editing['id']) && !$editing["id"]!=0):?> style="display: none"<?php endif;?>>保存</a>
                            <a id="btn_sub_on" <?php if(!isset($editing['id']) && !$editing["id"]!=0):?> style="cursor:default;"<?php endif;?>>保存</a>
                        </li>
						<li <?php if(!isset($editing['id']) && !$editing["id"]!=0):?>style="background:#ccc"<?php endif;?>>
                        	<a id="btn_sub_see" <?php if(!isset($editing['id']) && !$editing["id"]!=0):?>style="display: none"<?php endif;?>>保存并预览</a>
                        	<a id="btn_sub_see_on" <?php if(!isset($editing['id']) && !$editing["id"]!=0):?> style="cursor:default;"<?php endif;?>>保存并预览</a>
                        </li>
					</ul>
				</div>
			</div>
		</div>
	</div> 
</form>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">
	function change() {
		$(".sub_1").hide()
		$(".yufei_2").addClass("active01");
		$(".yufei_1").addClass("active02");
		
		}
	function change1() {
		$(".sub_1").show()
		$(".yufei_2").removeClass("active01");
		$(".yufei_1").removeClass("active02");
		}

	$(function(){ 
		var is_freight = "<?php echo !empty($editing["logistics_id"]) ?>";
		if(is_freight){ 
			change1();
		}else{ 
			change();
		}
	})
</script>

<script>
CKEDITOR.replace('content', {
        //"filebrowserImageUploadUrl": "assets/plugins/ckeditor/plugins/imgupload/imgupload.php"
        //"filebrowserImageUploadUrl": "<?php echo THEMEURL;?>../../js/ckeditor/plugins/image/imgupload.php"

		"filebrowserImageUploadUrl": "<?php echo site_url('uploadimage');?>"
    });


CKEDITOR.on('instanceReady', function (ev) {
    var editor = ev.editor,
        dataProcessor = editor.dataProcessor,
        htmlFilter = dataProcessor && dataProcessor.htmlFilter;

    // Out self closing tags the HTML4 way, like <br>.
    dataProcessor.writer.selfClosingEnd = '>';

    // Make output formatting behave similar to FCKeditor
    var dtd = CKEDITOR.dtd;
    for (var e in CKEDITOR.tools.extend({}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent)) {
        dataProcessor.writer.setRules(e,
            {
                indent: true,
                breakBeforeOpen: true,
                breakAfterOpen: false,
                breakBeforeClose: !dtd[e]['#'],
                breakAfterClose: true
            });
    }

    // Output properties as attributes, not styles.
    htmlFilter.addRules(
    {
        elements:
        {
            $: function (element) {
                // Output dimensions of images as width and height
                if (element.name == 'img') {
                    var style = element.attributes.style;
                    delete element.attributes.style;
                }

                if (!element.attributes.style)
                    delete element.attributes.style;

                return element;
            }
        },

        attributes:
            {
                style: function (value, element) {
                    // Return #RGB for background and border colors
//                     return convertRGBToHex(value);
                }
            }
    });
});

$('#btn_sub').click(function(){
	$(".tishi").html("");
	ok = true;
	$('input[name="see"]').val('0');
	$('#time_interval').html('');
	$("#special").html('');
	$('#vip_price_message').html('');
	var vip_price = $("input[name='vip_price']").val();
	if(vip_price <= 0){ 
		$('#vip_price_message').html('请填写正确的价格');
		$("input[name='vip_price']").focus();
		ok = false;
	}
	//checkProductNum();
	
    //如果是特价
    if($("input[name='is_special_price']").val()==1 && $('#sku_area').is(":hidden")){
    	var special_price = $("input[name='special_price']").val();
    	var start_at = $("input[name='special_price_start_at']").val();
    	var end_at = $("input[name='special_price_end_at']").val();
    	var vip_price = $("input[name='vip_price']").val();
    	
    	if(special_price<=0){
        	$("#special").html('特价商品不能小于0');
        	$("input[name=special_price]").focus();
        	ok = false;
        }
//     	alert(special_price);
//     	alert(vip_price);
    	if(parseFloat(special_price) > parseFloat(vip_price) ){
        	$("#special").html('特价商品必须小于换货价');
        	$("input[name=special_price]").focus();
        	ok = false;
        }

    	if(end_at < start_at){
    		$('#time_interval').html('开始时间必须小于结束时间');
    		$("input[name='special_price_start_at']").focus();
    		ok = false;
        }
    }
    if($("#longitude").val() || $("#latitude").val()){
        if($("#longitude").val().search(/^(((\d|[1-9]\d|1[1-7]\d|0)\.\d{0,15})|(\d|[1-9]\d|1[1-7]\d|0{1,3})|180\.0{0,15}|180)$/)==-1 || $("#latitude").val().search(/^([0-8]?\d{1}\.\d{0,15}|90\.0{0,15}|[0-8]?\d{1}|90)$/)==-1){
        	$("#long_and_lat").html('请填写正确的经纬度');
        	ok = false;
            }
    }

    
	if($("input[name=address]").val()){
		if($("input[name=address]").val().search(/^(?=.*?[\u4E00-\u9FA5])[\d\u4E00-\u9FA5]+/)==-1){
        	$("#address_").html('请填写正确的地址');
        	ok = false;
            }
		}

    if(!ok){ 
    	onsubmit=function(){ 
    		return false;
    	}
   }else{ 
	   onsubmit=function(){ 
      		return true;
      	}
   }
});


$(".productform").Validform({
	btnSubmit:"#btn_sub",
	tiptype:2,
	ajaxPost:false
});

$('#btn_sub_see').click(function(){
	$(".tishi").html("");
	$('input[name="see"]').val('1');
    if($('input[name="productnum"]').val()==null){
    	$('input[name="productnum"]').focus();
        }
    else if($('input[name="name"]').val()==null){
    	$('input[name="name"]').focus();
        }
    else if($("input[name='is_special_price']").val()==1 && $('#sku_area').is(":hidden")){
        
        var special_price = $("input[name='special_price']").val();
    	var start_at = $("input[name='special_price_start_at']").val();
    	var end_at = $("input[name='special_price_end_at']").val();
    	var vip_price = $("input[name='vip_price']").val();
    	
    	if(special_price<=0){
    		$("#special").html('特价商品不能小于0');
        	$("input[name=special_price]").focus();
        	ok = false;
        	return;
        	}
    	
    	if(parseFloat(special_price) > parseFloat(vip_price) ){
        	$("#special").html('特价商品必须小于换货价');
        	$("input[name=special_price]").focus();
        	ok = false;
        	return;
        	}

    	if(end_at < start_at){
    		$('#time_interval').html('开始时间必须小于结束时间');
    		$("input[name='special_price_start_at']").focus();
    		ok = false;
        	return;
        }
    	$(".productform").submit();
    }else if($("input[name=address]").val()){
		if($("input[name=address]").val().search(/^(?=.*?[\u4E00-\u9FA5])[\d\u4E00-\u9FA5]+/)==-1){
        	$("#address_").html('请填写正确的地址');
        	ok = false;
        	return ;
            }
	}else if($("#longitude").val() || $("#latitude").val()){
        if($("#longitude").val().search(/^(((\d|[1-9]\d|1[1-7]\d|0)\.\d{0,15})|(\d|[1-9]\d|1[1-7]\d|0{1,3})|180\.0{0,15}|180)$/)==-1 || $("#latitude").val().search(/^([0-8]?\d{1}\.\d{0,15}|90\.0{0,15}|[0-8]?\d{1}|90)$/)==-1){
    	$("#long_and_lat").html('请填写正确的经纬度');
    	ok = false;
    	return;
        }
    }else{ 
            $(".productform").submit();
    }
});

<?php if($editing['productnum']==""): ?>
$('input[name=productnum]').blur(function(){
	checkProductNum();
});

$('input[name=name]').blur(function(){
	if($('input[name=name]').val()!="")
	{
		checkProductNum();
		$("#nameerror").hide();
	}
	else 
	{
		$("#nameerror").html("请填写商品名称");
        $("#nameerror").show();
	}
	
});
<?php endif;?>
$("#btn_sub_on").click(function(){
	$(".tishi").html("");
	var ok = true;
	if($('input[name=productnum]').val()=="")
    {
		$("#pronum").html("请填写商品编号");
        $("#pronum").show();
        ok = false;
	}
	if( $('#proname').val()=="")
    {
		$("#nameerror").html("请填写商品名称");
        $("#nameerror").show();
        ok = false;
	}


    //如果是特价
    if($("input[name='is_special_price']").val()==1 && $('#sku_area').is(":hidden")){
    	var special_price = $("input[name='special_price']").val();
    	var start_at = $("input[name='special_price_start_at']").val();
    	var end_at = $("input[name='special_price_end_at']").val();
    	var vip_price = $("input[name='vip_price']").val();
    	if(special_price<=0){
        	$("#special").html('特价商品不能小于0');
        	$("input[name=special_price]").focus();
        	ok = false;
        	}
    	
    	if(parseFloat(special_price) > parseFloat(vip_price) ){
    		$("#special").html('特价商品必须小于换货价');
    		$("input[name=special_price]").focus();
        	ok = false;
        	}

    	if(end_at < start_at){
    		$('#time_interval').html('开始时间必须小于结束时间');
    		$("input[name='special_price_start_at']").focus();
        	ok = false;
        	}
    }

	if($("input[name=address]").val()){
		if($("input[name=address]").val().search(/^(?=.*?[\u4E00-\u9FA5])[\d\u4E00-\u9FA5]+/)==-1){
        	$("#address_").html('请填写正确的地址');
        	ok = false;
            }
		}
	
    if($("#longitude").val() || $("#latitude").val()){
        if($("#longitude").val().search(/^(((\d|[1-9]\d|1[1-7]\d|0)\.\d{0,15})|(\d|[1-9]\d|1[1-7]\d|0{1,3})|180\.0{0,15}|180)$/)==-1 || $("#latitude").val().search(/^([0-8]?\d{1}\.\d{0,15}|90\.0{0,15}|[0-8]?\d{1}|90)$/)==-1){
        	$("#long_and_lat").html('请填写正确的经纬度');
        	ok = false;
        }
    }

    
    
    
	if(ok)
	{
		checkProductNum();
		$("#nameerror").hide();
	}
	
});
$("#btn_sub_see_on").click(function(){
	$(".tishi").html("");
	var ok = true;
	if($('input[name=productnum]').val()==null && $('input[name=productnum]').val()=="")
    {
		$("#pronum").html("请填写商品编号");
        $("#pronum").show();
        ok = false;
	}
	if( $('#proname').val()=="")
    {
		$("#nameerror").html("请填写商品名称");
        $("#nameerror").show();
        ok = false;
	}

	if($("input[name=address]").val()){
		if($("input[name=address]").val().search(/^(?=.*?[\u4E00-\u9FA5])[\d\u4E00-\u9FA5]+/)==-1){
        	$("#address_").html('请填写正确的地址');
        	ok = false;
            }
		}
	
	if($("#longitude").val() || $("#latitude").val()){
        if($("#longitude").val().search(/^(((\d|[1-9]\d|1[1-7]\d|0)\.\d{0,15})|(\d|[1-9]\d|1[1-7]\d|0{1,3})|180\.0{0,15}|180)$/)==-1 || $("#latitude").val().search(/^([0-8]?\d{1}\.\d{0,15}|90\.0{0,15}|[0-8]?\d{1}|90)$/)==-1){
        	$("#long_and_lat").html('请填写正确的经纬度');
        	ok = false;
        }
	}
	
	if(ok)
	{
		checkProductNum();
		$("#nameerror").hide();
	}
});


</script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
<script type="text/javascript"> $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
</script>
<script type="text/javascript">



/*

* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;

* 其他参数同WebUploader

*/


$('#test').diyUpload({
	url:'<?php echo site_url('corporate/product/file_upload');?>',
	type:'post',
	success:function( data ) {
		console.info( data );
		
	},
	error:function( err ) {
		console.info( err );	
	},
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:10,
	fileSizeLimit:50000 * 1024,
	fileSingleSizeLimit:5000 * 1024,
});

$('#as').diyUpload({
	url:'<?php echo site_url('corporate/product/file_upload');?>',
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	},
	buttonText : '选择文件',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:50,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});


function diyCancel(o,pid){

	var id=$(o).children().val();
	var file_name=$(o).children().next().val();
	var file_ext=$(o).children().next().next().next().val();

    $.ajax({
        url:'<?php echo site_url('corporate/product/image_unlink');?>',
        type:'post',
        data:{
              img_id:id,
              img_url:file_name,
              img_ext:file_ext,
              pid:pid
        },
        success:function(data){
            if(data==true){
                $(o).parent().remove();
            }else if(data==0){
            	$(o).parent().remove();
            }
        },
    });
}



/**
 * 设置默认图片
 */
function setIsbase(e,id){

	$.ajax({
	    url:"<?php echo site_url('corporate/product/set_isbase') ?>",
	    type:"get",
	    data:{id:id},
	    success:function(data){
	        if(data==1){
	            $(e).parent().parent().parent().find('.flieBox_btnDefault').html("设置为默认图片");
	            $(e).html("当前为默认图片");
	            $(e).parent().parent().parent().find('.flieBox_btnDefault').removeClass('flieBox_btnDefault');
	            $(e).addClass('flieBox_btnDefault');
		    }
		},
	});
}

/**
 * 商品总库存 
 */
function stock(){
    var stock = '';
	if($('input[name="skustore[]"]').length>0){
    	$('input[name="skustore[]"]').each(function(){
        	if($(this).val() !='')
     		   stock = eval(parseInt($(this).val())+stock);
    	});
	}else{
	    stock = $("input[name=stock]").val();
	}
	
	$('input[name=stock]').val(stock);
}

/**
 * 检查商品编号
 */
function checkProductNum(){
	var ProductNum = $("input[name='productnum']").val();
	//alert((ProductNum!=null && ProductNum!=""))
	if(ProductNum!=null && ProductNum!=""){
	$.ajax({
	    url:"<?php echo site_url("corporate/product/checkProductNum")?>",
	    type:"get",
	    data:{productnum:ProductNum},
	    success:function(data){
		    data = jQuery.parseJSON(data);
	        if(data.flag==false)
		    {
	            $("#pronum").html("商品编号重复");
	            $("#pronum").show();
	            $("#btn_sub").parent().css("background-color","#717174");
	            $("#btn_sub_see").parent().css("background-color","#717174");
	            $("#btn_sub_see").hide();
	            $("#btn_sub_see_on").show();
	            $("#btn_sub").hide();
	            $("#btn_sub_on").show();
	            //return false;
		    }
		    else
			{
		    	$("#pronum").html("");
	            $("#pronum").hide();
	            $("#btn_sub").parent().css("background-color","#72c312");
	            $("#btn_sub_see").parent().css("background-color","#72c312");
	            $('#btn_sub_on').hide();
	            $("#btn_sub").show();
	            $("#btn_sub_see").show();
	            $("#btn_sub_see_on").hide();
			}
		   
		}
	});
	}else{
		$("#pronum").html("请填写商品编号");
        $("#pronum").show();
	}
}

//设置or取消特价
function is_special(obj){
	var html = "";
	var statu = $(obj).is(":checked");
	if(statu && $('#sku_area').is(":hidden")){
		$('#tejia').show();
		$('#tejia_time').show();
		}else{
			
			if($(obj).is(":checked"))
			    $('#tejia_time').show();
			else
				$('#tejia_time').hide();
			    $('#tejia').hide();
		}

	if(statu){
		
		$("input[name='is_special_price']").val(1);
		}else{
			$("input[name='is_special_price']").val(0);
			
		}

}
</script>
<script>
$(function(){
	stock();
	notifyTextLength();
	$('.fileBoxUl li').mouseover(function(e) {
        $(this).find('.fileBox_btn').show();
    }).mouseout(function(e){
    	$(this).find('.fileBox_btn').hide();
    });

    $("input[name='skustore[]']").blur(function(){
        stock();
    });
    region();//加载地图
    if( $('#sku_area').is(":visible") ){
        $('#tejia').hide();
    }
});
function stockpile(){ 
	stock();
}


//地图显示
function region(){
	var address = $("input[name=address]").val();
    if(address==""){
        $("#baidu_api").hide();
    	}else{
    	    $("#baidu_api").show();
    	    $("#baidu_api").attr("href","http://api.map.baidu.com/geocoder?address="+address+"&output=html&src=yourCompanyName|yourAppName");
    	}
}

var matchWords;
function notifyTextLength() {
	
    var inputNum = document.getElementById("txtTitle").value.replace(/[^\x00-\xff]/g, "**").length; //得到输入的字节数
    if (inputNum <= 160) {
        matchWords = document.getElementById("txtTitle").value.length;
        document.getElementById("inputedWord").innerHTML = inputNum + "字节," + matchWords + "字符";
        document.getElementById("inputtingWord").innerHTML = (160 - inputNum) + "字母,"+(Math.round(((160-inputNum)/2)-0.5))+"汉字";
    }
    if (inputNum > 160) {
            document.getElementById("txtTitle").value = document.getElementById("txtTitle").value.substring(0, matchWords);  //如果超过255字节，就截取到255字节
        }
       
}
</script>

<script type="text/javascript">
    jeDate({
		dateCell:"#start_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
	
	jeDate({
		dateCell:"#end_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
	
</script>



