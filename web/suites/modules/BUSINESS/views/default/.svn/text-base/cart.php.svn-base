<style>.gouwuche_mm01_img a img{width:100%;}</style>
<?php if(count($product)>0){; ?>
    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">我的购物车</div>
        
        <div class="gouwuche_box_top2">
        	<ul>
            	<li class="dingdan2_current"><a href="javascript:;">1. 我的购物车</a></li>
                <li><span>></span></li>
                <li><a href="javascript:;">2. 核对订单信息</a></li>
                <li><span>></span></li>
                <li><a>3.成功提交订单</a></li>      
            </ul>
        </div>

        <form name="cartForm" id="CartForm" method="get" action="<?php echo site_url('order');?>">
        <div class="gouwuche_box_con">
            <div class="gouwuche_box_con_top">
                <div class="gouwuche_box_con01">
                	<ul> 
                	    <li> <label style="margin-left:65px;"><em style="margin-left:20px;"></em></label><span class="gouwuche_m01" style="width:468px;">商品信息</span></li>
                        <li><span class="gouwuche_m02">单价（货豆）</span></li>
                        <li><span class="gouwuche_m02">数量</span></li>
                        <li><span class="gouwuche_m02">小计（货豆）</span></li>
                        <li><span class="gouwuche_m02">操作</span></li>
                    </ul>
                </div>
                
                <?php  foreach($product as $corporationid => $item){; ?>
                <!--店铺信息开始-->
                <div class="cart_store">
                	<ul>
                    	<li>
                        	<input type="checkbox" onclick="selectCorp(this,<?php echo $corporationid; ?>)" id="<?php echo "corp_".$corporationid; ?>" name="corp_name[]"><span>店铺：<a><?php echo $item['corporation_name'] ?></a></span>
                        </li>
                    </ul>
                </div>
                <!--店铺信息结束-->
                
                <!-- 商品信息开始 -->
                <?php foreach ($item["product"] as $items){;?>
                <div class="cart_border">
                <div class="gouwuche_box_con02"  style="<?php echo $items['status']==0 || $items['status']==2?'background-color:#EEE9E9':"";?>">
                	<ul>
                        <li>
                            <div class="gouwuche_selectAll">
                                <?php if($items['status'] == 1){;?>
                                <div class="gouwuche_checkbox">
                                    <input type="checkbox"    class="<?php echo "item_".$items['corporation_id'];?>" name='item[]'  onclick="selectthis(<?php echo $items['corporation_id'] ?>)" value="<?php echo $items['rowid'];?>">
                                    <input type="hidden"  value="<?php echo $items['id'];?>"><!-- 商品id_skuid : 1550_2 -->
                                </div>
                                <?php }?>
                            </div>
                        </li>
            			
                        <li>
                            <span class="gouwuche_mm01">
                               <span class="gouwuche_mm01_img"><a href="<?php echo site_url("goods/detail/{$items['product_id']}");?>"><img src="<?php echo IMAGE_URL.$items['options']['goods_img'];?>" alt=""></a></span>
                               <span class="gouwuche_mm01_font">
                                  <a href="<?php echo site_url("goods/detail/{$items['product_id']}");?>"><?php echo $items['name'];?></a>
                                  <p class="mm01_font1">
                                    <span><?php echo $items['sku'];?></span>
                                  </p>  
                               </span>
                           </span>
                   		</li>
                        <li>
                   			<span class="gouwuche_mm02" id="<?php echo "unit_price_".$items["product_id"]."_".$items["sku_id"]?>"><?php echo number_format($items['price'], 2, '.', '');?></span> 
                        </li>
                   			<span class="gouwuche_mm03"><a onclick="deleteSelect('<?php echo $items['rowid']; ?>','<?php echo $items['id'];?>')">删除</a></span> 
                        </li>
                        <li>
                   			<span class="gouwuche_shuliang" >                   			        
           			            <?php if($items["status"]){;?>
                                <a class="gouwuche_jian" href="javascript:void(0);"  onclick="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>','-')" >－</a>
        						<input type="text" id="<?php echo "item_num_".$items["product_id"]."_".$items["sku_id"]?>" name="item_num[]" class="gouwuche_input"   value="<?php echo $items['qty'];?>"  onkeyup="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>')">
                                <a class="gouwuche_jia" href="javascript:void(0);" onclick="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>','+')">+</a>
                                <input type="hidden" id ="<?php echo "stock_".$items["product_id"]."_".$items["sku_id"]?>" value="<?php echo $items['stock'];?>" ><!-- 库存 -->
                                <?php };?>
                                <!-- 提示语 -->
                                <span  id="<?php echo "tip_".$items["product_id"]."_".$items["sku_id"]?>" style="color:red;width:120px;"><?php if($items['status'] == 0){echo "(商品失效)";}elseif($items['status'] == 2){echo "已售罄";}elseif($items['qty'] > $items['stock']){echo "商品数量超过库存";}?></span>
                   			</span> 
                        </li>
                        <li>
                   			<span class="gouwuche_mm02" id="<?php echo "subtotal_".$items["product_id"]."_".$items["sku_id"]?>"><?php echo number_format($items['qty']*$items['price'], 2,'.','');?></span> 
                        </li>
                </ul>
            	 </div>
            	 </div>
            	 <?php }; ?>
            	 <!-- 商品信息结束 -->
                 <?php }; ?>

                <!--结算 开始-->  
                <div class="gouwuche_box_con_down clearfix">
                    <span class="gouwuche_d01"><a href="javascript:deleteSelect()">删除选中商品</a></span>
<!--                     <span class="gouwuche_d01"><a href="javascript:movetofav()">移入收藏夹</a></span> -->
                    <span class="gouwuche_d03">
                        <p class="gouwuche_dd03" id="total">商品总额(不含运费)：0.00货豆</p>
                        <div class="gouwuche_dd04"><a onclick="submitform();">提交订单</a></div>
                    </span>
                </div>
                <!--结算 结束-->
            </div>
        </div>
        </form>
    </div>
    
<script type="text/javascript" src="js/Public.js"></script><!-- js公共类 -->   
<script>
//验证item_num，返回数量 mode模式：'-'减法，'+'减法，默认加入购物车
function check_item_num(pid,sku_id,mode){
    var status = true;//默认成功
    var x=$('#item_num_'+pid+'_'+sku_id).val();//加入购物车数量
    jQuery('#item_num_'+pid+'_'+sku_id).val(x.replace(/\D|^0/g,''));   
    var max = parseInt($('#stock_'+pid+'_'+sku_id).val());//获取库存数量
    var is_num = new RegExp("^[1-9]\\d*$").test(x);//验证数据类型
    if(is_num){
        if(mode=='-'){
        	x--;
            if(x <= 0){
                var content = "商品数量最少为1"; 
                var status = false;
            }else{
            	if(max < x){
            		x = max;
                }
            	jQuery('#item_num_'+pid+'_'+sku_id).val(x);
            }
        }else if(mode=='+'){
            x++;
            if(max < x){
            	var content = "最多只能购买"+max+"个"; 
                var status = false;
            }else{
            	jQuery('#item_num_'+pid+'_'+sku_id).val(x);
            }
        }else{
        	if(max < x){
                jQuery('#item_num_'+pid+'_'+sku_id).val(max);
                $("#tip_"+pid+'_'+sku_id).html("最多只能购买"+max+"个");
                return max;
            }
        }

    }else{
    	var content = "请输入正确的数量"; 
    	var status = false;
    }
    if(status){
    	$("#tip_"+pid+'_'+sku_id).html("");
        return x;
    }else{
        $("#tip_"+pid+'_'+sku_id).html(content);
        return false;
    }
}



/**
 * 数量加法，减法，输入
 * mode 1加法2减法3输入
 */
function quantity(obj,pid,sku_id,mode){
	var qty = check_item_num(pid,sku_id,mode);//验证item_num
    if (qty) {
    	if(mode=='-' || mode=='+'){
    		$(obj).removeAttr("onclick");
        }
    	
    	$.post("<?php echo site_url('Cart/ajax_updateCart');?>",{pid:pid,qty:qty,sku_id:sku_id},function (data){
    		if(data['status']==1){
    			window.location.reload();
    		}else if(data['status']==2){
        		//执行成功
    			total(pid,sku_id);
    	    	if(mode=='-' || mode=='+'){
    	    		$(obj).attr("onclick",'quantity(this,'+pid+','+sku_id+',"'+mode+'")');
    	        }
    		}
    	},"json");
    }
}



//店铺全选 id:店铺id
function selectCorp(obj,id){

	$("input[type='checkbox']").not($(obj)).prop("checked",false);
	var flag = $(obj).is(':checked');
	$(".item_"+id).prop("checked",flag);

	total();
}

//商品选择 corp_id:店铺id
function selectthis(corp_id){
	
	$("input[type='checkbox']").not($(".item_"+corp_id)).prop("checked",false);
	//处理是否需要选中店铺---start
	var corp_product = $(".item_"+corp_id).size();
	var corp_choose_product = $(".item_"+corp_id+":checked").size();

    if( corp_choose_product == corp_product && $('#corp_'+corp_id).prop('checked') == false)
	{
		$('#corp_'+corp_id).prop('checked', true);
	}else{
		$('#corp_'+corp_id).prop('checked', false);
	}
	//处理是否需要选中店铺---end

	total();
}


//合计 pid:商品id
function total(pid,sku_id){

	if(pid){
        //单个商品合计
    	var num = $('#item_num_'+pid+'_'+sku_id).val();//数量
    	var unit_price = $("#unit_price_"+pid+'_'+sku_id).text();
    	var subtotal = formatCurrency(num*unit_price);//商品小计
    	$("#subtotal_"+pid+'_'+sku_id).text(subtotal);
	}

	//订单合计
	var total = "0.00";
	var obj_all = $('input[name="item[]"]:checked');
	$(obj_all).each(function(){
	    var product_sku = $(this).next().val();
    	var num = $('#item_num_'+product_sku).val();//数量
    	var unit_price = $("#unit_price_"+product_sku).text();
    	total = total*1+(num*unit_price);
	});
	total = formatCurrency(total);//商品总额
    $("#total").text("商品总额(不含运费)："+total+"货豆");//总额：商品＋运费

}



//删除购物车 rowid:ci购物车id,ids:商品id
function deleteSelect(rowid,ids)
{ 
	if(confirm('确定移除所选商品？'))
	{
		var rowids = new Array();
		var pid = new Array();
		var i = 0;
		if(rowid){
			rowids[0] = rowid;
			pid[0] = ids;
		}else{
            $("input[name='item[]']:checked").each(function(){
                rowids[i] = $(this).val();
                pid[i] = $(this).val();
                i++;
            });
		}


        if(rowids[0] && pid[0]){
            $.post("<?php echo site_url('cart/ajax_delete');?>",{rowid:rowids,pid:pid},function (data){
                location.reload();
            })
    	}else{
    	    alert('请选择要删除的商品');
    	}
	}
}



//提交订单
function submitform(){
	
	if($('input[name="item[]"]').is(':checked')){
		var ok = true;
    	$('input[name="item[]"]:checked').each(function(){
    		
    	    var id = $(this).next().val();
    	    if(parseInt($('#item_num'+id).val())>parseInt($('#stock_'+id).val())){
    	        $('#tip_'+id).html("商品数量超过库存！");
    	        $('#tip_'+id).show();
    	        ok = false;
    		}
    	});
    	
    	if(ok){
    		$('#CartForm').submit();
        }
	}else{
		alert('请选择商品')
    }
}


</script>
	
<?php }else{;?>
<!--空购物车-->
<div class="gouwuche_box">
    <div class="gouwuche_box_top">我的购物车</div>
    <div class="nogoods" >
      <div class="nogoods_top">
        <img src="images/nogoods.png"/>
        <span>您的购物车空空的～<a href="<?php echo site_url('Home');?>">快去易货吧</a></span>
      </div>
    </div>
</div>
<?php }; ?>
  