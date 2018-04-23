<style> 
.form-group input{height:27px;float:left;width:60px};
</style>
<script type="text/javascript">
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
		var str = '<thead class="no-border"><tr>';

		for(var i=0;i<skuNameArray.length;i++)
		{
			str = str+"<th>"+skuNameArray[i]+"</th>";
		}

		str +=	'<th style="display:none">价格</th><th>易货价</th><th>部落价</th><th>特价</th><th>库存</th><th class="text-right">商家编码</th></tr></thead><tbody class="no-border-x no-border-y sku_body" id="sku_table_body">';

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
					if(dval[j]["sku_key"] == idlist[i])
					{
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
		var temp_obj;
		for(var i=0;i<idlist.length;i++)
		{	
			if(!$('#'+idlist[i]).length)
			{

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

			str += '<td style="display:none"><input  class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["price"])+'" type="text">';//规格
			str += '<input id="'+id+'" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" type="hidden" name="skuids[]" value="'+id+'"/></td>';
			str += '<td><input name="sku_m_price[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["m_price"])+'" type="text"></td>';//易货价
			str += '<td><input name="sku_tribe_price[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["tribe_price"])+'" type="text"></td>';//部落价
			str += '<td><input name="sku_special_offer[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["special_offer"])+'" type="text"></td>';//特价
		    str += '<td><input name="skustore[]" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["store"])+'" class="input-mini" type="text" onblur="stocks();"></td>';//库存
			str += '<td class="text-right" style="width:120px;"><input name="skunum[]" class="input-mini" onkeyup="value=value.replace(/[^\\-?\\d.]/g,\'\')" value="'+(defaultval==""?"":defaultval["plus_no"])+'" type="text"></td>';//编号

			return str+'</tr>';
}

  
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
<script type="text/javascript" src="js/jedate/jedate.js"></script>
<script type="text/javascript" src="js/verification.js">//正则验证类
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
</script>

<style>
.webuploader-container{ top:-85px; left:161px;}  
.update_tips{top:-39px;}
.new_edit_box .p3{ text-align: left; width:auto;}
.new_edit_box .p2{ width:118px;}
.new_edit_box .weidu{ color:#fea33b; text-decoration:underline;}
</style>

<form method="post" action="<?php echo site_url("corporate/product/save"); ?>" name="product_form"  class="productform">
	<div class="Box manage_new_Box clearfix">
        <?php $this->load->view("corporate/navigation_goods");?><!-- 左侧导航栏 -->
		<div
			class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
			<div class="cmRight_tittle">发布产品</div>
			<div class="new_cmRight_con new_m_edit">
				<!--cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con-->
				<h2>1. 基本信息</h2>
				<p>
					<label>商品类目：</label> 
    				<span>
        				<?php echo $category;?>
        				<input name="id" id="id" type="hidden" value="<?php echo !empty($editing)?$editing['id']:null;?>" /> 
        				<input name="cat_id" id="cat_id" type="hidden" value="<?php echo $cid;?>" />
    				</span>
				</p>


				<p>
					<label>站内分类：</label> <span> <select data-placeholder="请点击选择分类" style="width: 350px;" multiple class="chzn-select" tabindex="8" name="section_id[]">
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
						<?php if(empty($editing['productnum'])){; ?>
                            <input type="text" name="productnum" class="p1" required  nullmsg="请输入商品编号！" value="">
							<span class="tishi" style="color:red" id="pronum"></span>
					    <?php }else{;?>
					    <?php echo $editing['productnum'];?>
					    <input type="hidden" name="productnum"   value="<?php echo $editing['productnum'];?>">
					    <?php };?>
					</div>
					<div class="new_edit_box">
						<label><span>*</span> 商品名称：</label> 
						<input type="text" name="name" class="p1" required   value="<?php echo !empty($editing['name'])?$editing['name']:null;?>" id="proname">
						<span class="tishi" style="color:red" id="nameerror"></span>
					</div>

					<div class="new_edit_box" <?php echo $cid==104164?"hidden":'';?> ><!-- #共享服务分类104164 -->
					   <label>易货价（提货权）：</label> <input type="text" name="vip_price" class="p1" value="<?php echo !empty($editing['vip_price'])?$editing['vip_price']:1;?>" >
					   <span class="tishi" style="color:red" id="vip_price"></span>
				   </div>
	
                    <?php if($mytribe){?>
                    <div class="new_edit_box">
                        <label>可享优惠的部落：</label>
                        <!-- 判断添加or更新，如果添加则默认全选部落 -->
                        <?php if(!empty($editing)){;?>
                            <input id="checkAllfres" type="checkbox" class="buoloudd" onclick="selectAll(this);" <?php echo count($mytribe)==count($tribe_id)?"checked":"";?>><span class="buoloudd_span">所有部落</span>
                            <?php foreach ($mytribe as $v){;?>
                            <input name="tribeid[]" type="checkbox" value="<?php echo $v["id"];?>" onclick="Radio();" class="buoloudd" <?php echo in_array($v["id"],$tribe_id)?"checked":"";?>><span class="buoloudd_span"><?php echo $v['name'];?></span>
                            <?php };?>
                        <?php }else{;?>
                            
                            <input id="checkAllfres" type="checkbox" class="buoloudd" onclick="selectAll(this);" checked><span class="buoloudd_span">所有部落</span>
                            <?php foreach ($mytribe as $v){;?>
                            <input name="tribeid[]" type="checkbox" value="<?php echo $v["id"];?>" onclick="Radio();" class="buoloudd" checked><span class="buoloudd_span"><?php echo $v['name'];?></span>
                            <?php };?>
                        <?php };?>
                    </div>
                    <?php };?>
                    <span class="tishi" style="color:red" id="tribeid"></span>
                    
                    <?php if($mytribe){?>
                    <div class="new_edit_box">
						<label>部落价（提货权）：</label> <input type="text" name="tribe_price" class="p1" value="<?php echo !empty($editing['tribe_price'])?$editing['tribe_price']:"";?>" >
                        <span class="tishi" style="color:red" id="tribe_price"></span>
                        <?php if($cid==104164){;?><!-- #共享服务分类104164 -->
                        /<input type="text" name="unit" class="p1"  placeholder="单位" style="width:50px;" value="<?php echo !empty($editing['unit'])?$editing['unit']:"";?>" >
					   <?php };?>
					</div>
					<?php };?>
					
					
	               <?php if($mytribe){?>
                   <div class="new_edit_box" <?php echo $cid==104164?"hidden":'';?> ><!-- #共享服务分类104164 -->
						<label>仅在部落中展示：</label>
                        <input style="width:15px;" type="checkbox" name="is_reveal" class="p1"  value="1" <?php echo !empty($editing['is_reveal'])?"checked":"";?>>
				        <i style="font-size:12px;color:#ff0000;">勾选后，商品只会在部落中展示</i>
					</div>
					<?php };?>


					<div class="new_edit_box">
                        <label>默认销售量：</label> 
                        <input type="text" name="sales_count" class="p1"  value="<?php echo !empty($editing['sales_count'])?$editing['sales_count']:0;?>">
                        <span class="tishi" style="color:red" id="sales_count"></span>
					</div>
					<div class="new_edit_box">
					   <label>默认收藏数：</label> <input type="text" name="fav_count" class="p1"   value="<?php echo !empty($editing['fav_count'])?$editing['fav_count']:0;?>">
					   <span class="tishi" style="color:red" id="fav_count"></span>
					</div>
				</div>
				<div id="attr_list">
									<?php foreach($attributes as $key => $attr) {;  ?>
									 <div class="new_edit_box <?php echo 'attr_set_'.$attr['attr_set_id'];?>">
						               <label style="vertical-align: top;"><?php echo $attr['attr_name'] ?>：</label>
						               <div class="edit_box_con">
											<?php echo build_attr_html ( $attr ['attr_type'], $attr ['id'], $attr ['option_values_array'], $attr ['default_value'] );?>	
										</div>
					                 </div> 
									<?php
										$skuflag = false;
										if ($attr ["attr_type"] == "sku" && !empty($attr['check']) ) {
											$skuflag = true;
// 											echo '<pre>';
// 											print_r($attr);
											?>
										<script>
										skuIDArray.push(<?php  echo $attr["id"];?>);
										</script>
					                    <script>
					                    skuNameArray.push('<?php echo $attr["attr_name"]?>');
					                    </script>
									<?php }?>
									<?php }; ?>
									<?php if(!empty($editing['attr_list'])){?>
		  					        <?php foreach($editing['attr_list'] as $attr) {; ?>
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
		  					         <?php }; ?>
		  					         <?php };?>

				</div>
                
				<!--sku表格 开始-->
				<div class="form-group cpMessage3" id="sku_area" style="display: none">
				<?php if($cid != 104164){?><!-- #共享服务分类104164 -->
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-9">
						<table id="sku_table" class="sku_tab"></table>
					</div>
				<?php };?>
				</div>
				
				<span class="tishi" style="color:red" id="sku_message"></span>
				
				<!--sku表格 结束-->
				
                
                
				<div class="new_edit_box" <?php echo $cid==104164?"hidden":'';?> ><!-- #共享服务分类104164 -->
					<label><span>*</span> 总库存：</label> <input type="text" name="stock" class="p1" value="<?php echo !empty($editing['stock'])?$editing['stock']:1;?>" >
				</div>

				
				
				<div class="new_edit_box" <?php echo $cid==104164?"hidden":'';?> ><!-- #共享服务分类104164 -->
					<label>是否设置特价：</label> <input type="checkbox" name="is_special_price" onclick="is_special(this)" class="p1"  value="<?php echo !empty($editing['is_special_price'])?$editing['is_special_price']:0;?>" <?php echo !empty($editing['is_special_price'])?'checked':"";?>>
				</div>
				<span id="tejia" <?php echo !empty($editing['is_special_price'])?'':"hidden";?>>
    				<div class="new_edit_box">
            		  <label>特价价格：</label><input type="text" name="special_price" class="p1" value="<?php echo !empty($editing['special_price'])?$editing['special_price']:'0.00';?>"  >
            		</div>
            		<span class="tishi" style="color:red" id="special_price"></span>
        		</span>
        		<span id="tejia_time" <?php if(empty($editing['is_special_price']) ){echo 'hidden';}?>>
            		<div class="new_edit_box">
                		<label>特价时间：</label>
                		<input class="datainp" name="special_price_start_at" id="start_at" type="text" value="<?php echo !empty($editing['special_price_start_at'])?$editing['special_price_start_at']:null;?>" placeholder="请选择"  readonly><input class="datainp" name="special_price_end_at" id="end_at" type="text" value="<?php echo !empty($editing['special_price_end_at'])?$editing['special_price_end_at']:date('Y-m-d H:i:s',strtotime("+1 day"));?>" placeholder="请选择"  readonly><br/>
                		<span class="tishi" style="color:red" id="time_interval"></span>
            		</div>
				</span>

				
				<?php if(!empty($editing['id']) && count($images) > 0){;?>
				<div class="new_edit_box clearfix">
					<label><span class="red">*</span>已有商品图片：</label>
					<div class="parentFileBox" style="margin-left:150px;">
						<ul class="fileBoxUl">
						<?php foreach ($images as $image){;?>
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

							<?php };?>
						</ul>
                        
					</div>
				</div>
				<?php };?>
                
				<div class="new_edit_box clearfix ">
					<label><span class="red">*</span>商品图片：</label>
					<!--图片上传 开始-->
					<div id="box">
					   <div class="update_tips">需要设置默认图片，请先保存商品，鼠标移至图片处即可设置。</div>
					   <div class="update_tips">图片最小不得小于100K，最大不得超过5M</div>
						<div id="test"></div>
					</div>
					<span class="tishi" style="color:red" id="update_image"></span>
				</div>
				
				<!-- 经纬度 -->
				<div class="new_edit_box">
					<label>地址：</label>
					<input style=" margin-left:9px;width:350px;" type="text" name="address" class="p1" oninput="region()" value="<?php echo !empty($editing['address'])?$editing['address']:null?>"><a target="_blank" id="baidu_api" <?php echo empty($editing['address'])?"hidden":null?>><span class="icon-coordinate" style="color: #fea33b"> </span></a>
				    <span class="tishi" style="color:red" id="address_"></span>
				</div>
				
					
                <div class="new_edit_box">
                    <label>地址经度：</label> 
                    <input id="longitude" type="text" name="longitude" class="p2" value="<?php echo !empty($editing['longitude'])?$editing['longitude']:null?>" >
                    <label class="p3">地址纬度：</label> 
                    <input id="latitude" type="text" name="latitude" class="p2" value="<?php echo !empty($editing['latitude'])?$editing['latitude']:null?>">
            		 <span><a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" class="weidu" target="_blank">经纬度查询工具</a></span>
                </div>
				<span class="tishi" style="color:red" id="long_and_lat"></span>
				
				<div class="new_edit_box">
					<label>简短描述：</label> 
					<input id="txtTitle" type="text" name="short_desc" class="p1" value="<?php echo !empty($editing['short_desc'])?$editing['short_desc']:null;?>" oninput="notifyTextLength();">
					当前已输入<span id="inputedWord" style="color:red"></span> 还可以输入<span id="inputtingWord" style="color:Red;"></span>
				</div>

				<div class="new_edit_box clearfix">
					<label>商品描述：</label>
					<span>(图片大小不超过2M)</span>
					<textarea class="ckeditor p1" name="desc" id="content"><?php echo !empty($editing['desc'])?$editing['desc']:null;?></textarea>
				</div>
				
				<div class="new_edit_box clearfix">
				<p>
                    <label>发布站点：</label>
                    <select  name="app_id" class="app_id_1">
                        <option value="1">本地站</option>
                        <option value="0" <?php echo empty($editing["app_id"])?"selected":"" ?>>全国站</option>
                    </select>
				</p>
				</div>
                

                <div class="new_edit_box clearfix" <?php echo $cid==104164?"hidden":'';?> ><!-- #共享服务分类104164 -->
                    <div class="yufei">运费设置：<span class="yufei_1 <?php echo empty($editing['is_freight']) ? '' : 'active02'; ?>"><input type="radio" checked="checked" value="1"name="is_freight" id="sub" onchange="change1();" <?php echo isset($editing['is_freight']) &&  $editing['is_freight'] == 1 ? 'checked' : ''?>>自定义运费</span>
                        <span class="yufei_2 <?php echo empty($editing['is_freight']) ? '' : 'active01'; ?>"><input type="radio" value="0" placeholder="请输入金额" name="is_freight" id="sub_2" onchange="change();" <?php echo !isset($editing['is_freight']) || $editing['is_freight'] == 0 ? 'checked' : ''?>>免运费</span>
                        <ul class="sub_1" <?php echo empty($editing['is_freight']) ? 'hidden' : ''; ?>>
                            <li>
                            <samp>默认运费：</samp>
                            <input id="" type="text" name="default_item"class="" value="<?php echo !empty($editing['default_item'] ) ? $editing['default_item'] :''?>" ><samp>件内,</samp>
                            <input id="" type="text" name="default_freight"class="" value="<?php echo !empty($editing['default_freight']) ? $editing['default_freight'] : '' ?>"><samp>元，每增加</samp>
                            <input id="" type="text" name="add_item"class="" value="<?php echo !empty( $editing['add_item'] ) ? $editing['add_item'] : ''?>"><samp>件，增加运费</samp>
                            <input id="" type="text" name="add_freight"class="" value="<?php echo !empty($editing['add_freight']) ? $editing['add_freight'] : ''?>"><samp>元</samp>
                            </li>
                        </ul>
                    </div>   
                </div>

  
  
				<h2>3. 推广相关</h2>
				<div class="new_edit_box">
					<label>是否上架：</label> <input type="checkbox" name="is_on_sale" class="p1" id="p1_1" value="<?php echo !empty($editing['is_on_sale'])?$editing['is_on_sale']:null;?>" checked>
				</div>
				<div class="new_edit_box">
					<label>Meta标题：</label> <input type="text" name="meta_title" class="p1" value="<?php echo !empty($editing['meta_title'])?$editing['meta_title']:null;?>">
				</div>
				<div class="new_edit_box">
					<label>Meta关键字：</label> <input type="text" name="meta_keywords" class="p1" value="<?php echo !empty($editing['meta_keywords'])?$editing['meta_keywords']:null;?>">
				</div>
				<div class="new_edit_box">
					<label>Meta描述：</label> <input type="text" name="meta_desc" class="p1" value="<?php echo !empty($editing['meta_desc'])?$editing['meta_desc']:null;?>">
				</div>


				<div class="save manage_b_save">
				<input type="hidden" value="1" name="type">
					<ul>
						<li >
                            <a id="btn_sub_on" onclick="sub(0);">保存</a>
                        </li>
						<li >
                        	<a id="btn_sub_see_on" onclick="sub(1);">保存并预览</a>
                        </li>
					</ul>
				</div>
			</div>
		</div>
	</div> 
</form>


<script type="text/javascript">
$(function(){
	//判断是更新还是创建
	productid = <?php echo !empty($editing['id'])?$editing['id']:0;?>;
	if(productid ){
		diyUpload = true;//识别是否有图片上传
	}else{
		diyUpload = false;//识别是否有图片上传
	}
	
	notifyTextLength();//字节,字符计算
	region();//加载地图
	
	//绑定事件
	<?php if(empty($editing['productnum'])){ ?>
	$('input[name=productnum]').blur(function(){
		checkProductNum();
	});

	$('input[name=name]').blur(function(){
		if($('input[name=name]').val())
		{
			$("#nameerror").hide("").hide();
		}else{
			$("#nameerror").html("请填写商品名称").show();
		}
		
	});
	<?php };?>

	//图片特效
	$('.fileBoxUl li').mouseover(function(e) {
        $(this).find('.fileBox_btn').show();
    }).mouseout(function(e){
    	$(this).find('.fileBox_btn').hide();
    });

	//商品类目特效
    $(".chzn-select").chosen(); 
	$(".chzn-select-deselect").chosen({allow_single_deselect:true});
});


	// -----------------------------------------------------------------------
//运费隐藏
function change() {
	$(".sub_1").hide()
	$(".yufei_2").addClass("active01");
	$(".yufei_1").addClass("active02");
	
	}
//运费显示
function change1() {
	$(".sub_1").show()
	$(".yufei_2").removeClass("active01");
	$(".yufei_1").removeClass("active02");
	}

//-----------------------------------------------------------------------	
	
	//部落全选
    function selectAll(obj)
    {
    	var flag = $(obj).is(':checked');
    	$("input[name='tribeid[]']").each(function () {
    		 $(this).prop("checked",flag);
        });
    }

	// -----------------------------------------------------------------------
	
	//部落单选
	function Radio(){
		var flag = true;//默认全部选中
	    $("input[name='tribeid[]']").each(function () {
	    	 if(!$(this).is(":checked")){
	    		 flag = false;
	    		 return ;
	    	 }
	    });
		$("#checkAllfres").prop("checked",flag);
	}
</script>
<script src="js/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace('content', {
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


//--------------------------------------------------------------------------------------------

//提交数据
function sub(type){
	$("input[name=type]").val(type);//预览保存还是保存
	$(".tishi").html("");//去除错误提示
	var ok = true;

	var productnum =$('input[name=productnum]').val();//商品编号
	var name =$('input[name=name]').val();//商品名称
	var vip_price =$('input[name=vip_price]').val();//易货价
	var tribe_price =$('input[name=tribe_price]').val();//部落价
	var sales_count =$('input[name=sales_count]').val();//销售量
	var fav_count =$('input[name=fav_count]').val();//收藏数
	var stock =$('input[name=stock]').val();//总库存
	var longitude =$('input[name=longitude]').val();//经度
	var latitude =$('input[name=latitude]').val();//维度
	var is_special_price = $("input[name='is_special_price']").val();//特价标识
	var special_price = $("input[name='special_price']").val();//普通特价
    var special_price_start_at = $("input[name='special_price_start_at']").val();//特价开始时间
    var special_price_end_at = $("input[name='special_price_end_at']").val();//特价结束时间
    var longitude = $("#longitude").val();//经度
    var latitude = $("#latitude").val();//纬度
    
    var is_tribeid = false;//识别是否选中部落
    $("input[name='tribeid[]']").each(function () {
        
      	 if($(this).is(":checked")){
       		is_tribeid = true;
      		 return ;
      	 }
     }); 


	if(!validateNull(productnum)){
		$("#pronum").html("请填写商品编号");
        ok = false;
	}

	if( !validateNull(name)){
		$("#nameerror").html("请填写商品名称");
        ok = false;
	}

  
	//判断是否sku产品
	if(!$("#sku_area").is(":hidden")){//是
		$('input[name="sku_m_price[]"]').each(function(){
			//检查表单内容
    		if(!validateMoney($(this).val())){
            	$("#sku_message").html('请填写正确的易货价');
            	ok = false;
            	return false;
            }

    		//判断部落价
    		if(is_tribeid){
    			sku_tribe_price = $(this).parent().next().children().val();//部落价
    			if(!validateMoney(sku_tribe_price)){
    				$("#sku_message").html('请填写正确的部落价');
                	ok = false;
                	return false;
    			}
    		}

    		//判断特价
    		if(is_special_price == 1){//是
    			sku_special_price = $(this).parent().next().next().children().val();//部落价
    			if(validateMoney(sku_special_price)){
    				if(parseFloat($(this).val()) < parseFloat(sku_special_price)){
                    	$("#sku_message").html('特价不能大于易货价');
                    	ok = false;
                    	return false;
                    }
    			}else{
    				$("#sku_message").html('请填写正确的特价');
                	ok = false;
                	return false;
    			}
    		}

    		//验证库存
    		skustore = $(this).parent().next().next().next().children().val();//库存
    		if(!validateNum(skustore)){
    			$("#sku_message").html('请填写正确的库存');
            	ok = false;
            	return false;
    		}

    		//验证编码
    		skunum = $(this).parent().next().next().next().next().children().val();//库存
    		if(!validateNumLetterLine(skunum)){
    			$("#sku_message").html('请填写正确商品编码');
            	ok = false;
            	return false;
    		}
    	});
	}else {//普通产品
		if(!validateMoney(vip_price)){
        	$("#vip_price").html('请填写正确的易货价');
        	ok = false;
		}

		//判断部落价
		if(is_tribeid){
			if(!validateMoney(tribe_price)){
				$("#tribe_price").html('请填写正确的部落价');
            	ok = false;
			}
		}
		
		//如果是特价
		if(is_special_price == 1){
        	if(validateMoney(special_price)){
                if(parseFloat(vip_price) < parseFloat(special_price)){
                	$("#special_price").html('特价不能大于易货价');
                	ok = false;
                }
            }else{
            	$("#special_price").html('请填写正确的特价');
            	ok = false;
            }
		}
    }

    //如果是特价
    if(is_special_price == 1){
        //验证特价时间
        if(validateDatetime(special_price_start_at) && validateDatetime(special_price_end_at)){
            if(special_price_end_at < special_price_start_at){
            	$('#time_interval').html('开始时间必须小于结束时间');
             	ok = false;
            }
        }else{
        	$("#time_interval").html('特价时间错误');
        	ok = false;
        }
    }

	//验证经纬度
    if(longitude || latitude){
        if(!isLongitude(longitude) && !isLatitude(latitude)){
        	$("#long_and_lat").html('请填写正确的经纬度');
        	ok = false;
        }
    }

    if(!diyUpload){
        $("#update_image").html('请上传图片');
    	ok = false;
    }


    //修改商品不检查商品编号
    if(!productid && ok){
        ok = checkProductNum();
    }

    //提交
    if(ok){
    	$(".productform").submit();
    }

}
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
	    if(data['status'] !=2 ){
	        alert('上传失败');
	    }else{
	    	diyUpload = true;
	    }

	},
	error:function( err ) {
		console.log( err );	
	},
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:10,
	fileSizeLimit:50000 * 1024,
	fileSingleSizeLimit:5000 * 1024,
	
});


//-------------------------------------------------------------------------------------------

//删除图片
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

//-------------------------------------------------------------------------------------------

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

//-------------------------------------------------------------------------------------------

//sku计算商品总库存
function stocks(){

    var stock = '';
	if($('input[name="skustore[]"]').length>0){
    	$('input[name="skustore[]"]').each(function(){
        	if($(this).val() !=''){
     		   stock = eval(parseInt($(this).val())+stock);
        	}
    	});
	}else{
	    stock = $("input[name=stock]").val();
	}
	
	$('input[name=stock]').val(stock);
}

//-------------------------------------------------------------------------------------------

/**
 * 检查商品编号
 */
function checkProductNum(){
	var flag = false;//状态识别
	var ProductNum = $("input[name='productnum']").val();
	//alert((ProductNum!=null && ProductNum!=""))
	if(ProductNum){
    	$.ajax({
    	    url:"<?php echo site_url("corporate/product/checkProductNum")?>",
    	    type:"get",
    	    async:false,
    	    data:{productnum:ProductNum},
    	    success:function(data){
    		    data = jQuery.parseJSON(data);
    	        if(data.flag==false){
    	            $("#pronum").html("商品编号重复");
    	            $("#pronum").show();
    	            $("#btn_sub").parent().css("background-color","#717174");
    	            $("#btn_sub_see").parent().css("background-color","#717174");
    	            flag =  false;
    		    }else{
    		    	$("#pronum").html("").hide();
    	            $("#btn_sub").parent().css("background-color","#72c312");
    	            $("#btn_sub_see").parent().css("background-color","#72c312");
    	            flag =  true;
    			}
    		   
    		}
    	});
	}else{
		$("#pronum").html("请填写商品编号");
        $("#pronum").show();
        var flag =  false;
	}
	return flag;


}

//-------------------------------------------------------------------------------------------

//设置or取消特价
function is_special(obj){
	var html = "";
	var statu = $(obj).is(":checked");
	if(statu && $('#sku_area').is(":hidden")){
		$('#tejia').show();
		$('#tejia_time').show();
	}else{
		$('#tejia').toggle();
		$('#tejia_time').toggle();
	}

	if(statu){
		$("input[name='is_special_price']").val(1);
	}else{
		$("input[name='is_special_price']").val(0);
	}

}

//-------------------------------------------------------------------------------------------

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

// -------------------------------------------------------------------------------------------

//字节,字符计算
function notifyTextLength() {
	var matchWords;
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

//-------------------------------------------------------------------------------------------
</script>

<script type="text/javascript">
//初始化时间插件
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





