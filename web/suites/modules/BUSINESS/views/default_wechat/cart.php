<style>
  .input_class {border: 1px solid #cccccc;width: 18px;height: 18px;border-radius: 50%;position: absolute;left: 0;top: 50px;}
  .input_but_class{ font-size: 18px;color: #fe4101;border: none!important;}
  .input_shop_class {border: 1px solid #cccccc;width: 18px;height: 18px;border-radius: 50%;position: absolute;left: 0;top: 12px;}

</style>

<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
  </div>
<?php $count_cart = count($product); ?>
<!-- 判断是否有商品 -->
<?php if ($count_cart === 0){;?>
    <div class="tips-none">
    	<em class="icon-gouwuche"></em>
    	<p>购物车内暂无商品</p>
    	<a href="<?php echo site_url('Home');?>" class="red-but custom_button">随便看看</a>
    </div>
<?php }else{;?>

    <div class="page clearfix">
        <div class="order_cart">
            <form id="CartForm" action="<?php echo site_url("order") ?>" method="post"  style="padding-bottom: 50px;">           
                <?php foreach ($product as $corporationid => $item){; ?>
                <!--店铺01 开始-->
                 <ul>
                	<li>
                		<input type="checkbox" class="input_shop_class"   onclick="selectCorp(this,<?php echo $corporationid; ?>)" id="<?php echo "corp_".$corporationid; ?>">
                		<span style="margin-left: 25px; line-height: 30px;"><span class="icon-shop" style="margin-right: 5px;"></span> <?php echo $item['corporation_name'] ?></span>
                	</li>
                </ul>
                <!--店铺信息 结束-->
                <ul class="order-list">
                    <?php foreach ($item["product"] as $items){;?>
                    <li style="<?php echo $items['status'] ===0 || $items['status']==2? 'background-color:#EEE9E9;' :'' ?>">
                    
                        <?php if($items["status"]){;?> 
                            <input class="input_class <?php echo "item_".$items['corporation_id'];?>" name='item[]' type="checkbox"   onclick="selectthis(this,<?php echo $items['corporation_id'] ?>)" value="<?php echo $items['rowid'];?>">
                            <input type="hidden"  value="<?php echo $items['id'];?>"><!-- 商品id_skuid : 1550_2 -->
                        <?php };?>
                    
                    
                        <a class="link" href="<?php echo $items['status']?  site_url('Goods/detail/'.$items['id']) : 'javascript:;'  ?>">
                            <span class="goods_img"><img src="<?php echo IMAGE_URL.$items['options']['goods_img'];?>" alt="<?php echo $items['name'];?>" onerror="this.src='images/default_img_b.jpg'"></span>
                        </a>
                        
                    	<div class="order_info">
                            <a href="<?php echo site_url('goods/detail/'.$items['product_id']); ?>"  style="margin: 0;"><h2><?php echo $items['name'];?></h2></a>
                    		
                    		<!-- sku -->
                    		<?php if($items['sku']){;?>
                    		<?php $sku = explode("；",$items['sku']);?>
                        	<p >
                            	<?php foreach($sku as $v){;?>
                            	<span><?php echo $v;?></span>
                            	<?php };?>
                        	</p>
                        	<?php };?>
                        	<!-- sku结束 -->
                        	
                        	<!-- 数量控制 -->
                            <p class="mm01_font2" id="on_sale_<?php echo $items['id']?>">	
                                <?php if($items["status"] == 1){;?> 
                         		<a class="gouwuche_jian" href="javascript:void(0);" onclick="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>','-')">－</a>
                        		<input type="text" class="gouwuche_input" id="<?php echo "item_num_".$items["product_id"]."_".$items["sku_id"]?>"  value="<?php echo $items['qty'];?>"  onkeyup="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>')" >
                        		<a class="gouwuche_jia" href="javascript:void(0);"  onclick="quantity(this,'<?php echo $items['product_id'];?>','<?php echo $items['sku_id'];?>','+')">+</a>
                        		<input type="hidden" id ="<?php echo "stock_".$items["id"];?>" value="<?php echo $items['stock'];?>" ><!-- 库存 -->
                                <?php }else{;?>
                                <span id="no_stock" style="color:red"><?php if($items['status']===0){echo "(商品失效)";}elseif($items['status'] == 2){echo "已售罄";}?></span>
                                <?php };?>
                            </p>
                            <!-- 商品单价 -->
                            <p class="order_price" id="<?php echo "unit_price_".$items["product_id"]."_".$items["sku_id"]?>"><?php echo number_format($items['price'],2,'.','');?></p><p class="order_price">&nbsp;货豆</p>
                    	</div>
                    
                        <em class="remove_goods">X</em>
                        <p class="delete_from_order">
                        	<a href="javascript:void(0);" onclick="remove_fav(this,'<?php echo $items["product_id"]; ?>');"><em class="icon-favorfill"></em>添加收藏</a>
                            <a href="javascript:void(0);" onclick="deleteSelect('<?php echo $items['rowid']; ?>','<?php echo $items['id'];?>')"><em>X</em> 删除</a>
                    	</p>
                    </li>
                    <?php };?>
                </ul>
                <?php };?>
            </form>
        </div>
    </div>
    <div class="footer02" style="position: fixed; bottom: 50px; left: 0px; width: 100%;">
    	<ul>
    		<li style="float: left; width: 70%; background-color: #000000; height: 40px; color: #fff; line-height: 40px; text-align: center; font-size: 15px;">
    			<div class="price-sum">
    				<p class="f16" id="price_total" style="line-height: 42px;">
    					<span>0</span>件总计: 0.00 货豆<span style="margin-left: 5px;"></span>
    				</p>
    			</div>
    		</li>
    		<li class="custom_button" style="float: right; width: 30%; background-color: #fe4101; height: 40px; color: #fff; line-height: 40px; text-align: center; font-size: 15px;">
    			<a href="javascript:submitform();" style="color: #fff;">去结算</a>
    		</li>
    	</ul>
    </div>
    
    <script type="text/javascript" src="js/Public.js"></script><!-- js公共类 -->  
    <script type="text/javascript">
    $(document).ready(function(){
    	//按删除按钮显示收藏、删除按钮
        $(".remove_goods").on("touchstart",function(e){
            var parent = e.target.parentNode;
            $(".delete_from_order").animate({right:'-204px'},"fast");
            $(parent).find(".delete_from_order").animate({right:'0px'},"fast");
            $(".bg1").show();
            $(".bg1").on("touchstart",function(){
                $(".bg1").hide();
                $(".delete_from_order").animate({right:'-204px'},"fast");
            });
        })
    });

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
                    $('#item_num_'+pid+'_'+sku_id).val(max)
                    $(".black_feds").text("最多只能购买"+max+"个").show();
                    setTimeout("prompt();", 700);
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
            $(".black_feds").text(content).show();
            setTimeout("prompt();", 700);
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
    function selectCorp(obj,id)
    {
    	$("input[type='checkbox']").not($(obj)).prop("checked",false).removeClass("input_but_class icon-roundcheckfill");
    	var flag = $(obj).is(':checked');
        if(flag){
        	$(obj).addClass("input_but_class icon-roundcheckfill");
        	$(".item_"+id).prop("checked",true).addClass("input_but_class icon-roundcheckfill");
        }else{
        	$(obj).removeClass("input_but_class icon-roundcheckfill");
        	$(".item_"+id).prop("checked",false).removeClass("input_but_class icon-roundcheckfill");
        }

    	total();
    }


    //商品选择 corp_id:店铺id
    function selectthis(obj,corp_id){
    	var flag = $(obj).is(':checked');
        if(flag){
        	$(obj).addClass("input_but_class icon-roundcheckfill");
        }else{
        	$(obj).removeClass("input_but_class icon-roundcheckfill");
        }
    	
    	//处理是否需要选中店铺---start
    	var corp_product = $(".item_"+corp_id).size();
    	var corp_choose_product = $(".item_"+corp_id+":checked").size();

        if( corp_choose_product == corp_product && $('#corp_'+corp_id).prop('checked') == false)
    	{
    		$('#corp_'+corp_id).prop('checked', true).addClass("input_but_class icon-roundcheckfill");
    	}else{
    		$('#corp_'+corp_id).prop('checked', false).removeClass("input_but_class icon-roundcheckfill");
    	}
    	//处理是否需要选中店铺---end

    	total();
    }


    //合计 pid:商品id
    function total(pid,sku_id){
    	//订单合计
    	var total = "0.00";//商品总金额
    	var total_num = "0";//商品总数
    	var obj_all = $('input[name="item[]"]:checked');
    	$(obj_all).each(function(){
    	    var product_sku = $(this).next().val();
        	var num = $('#item_num_'+product_sku).val();//数量
        	var unit_price = $("#unit_price_"+product_sku).text();
        	total = total*1+(num*unit_price);
        	total_num = total_num*1+num*1;
    	});

    	total = formatCurrency(total);//商品总额

    	$('#price_total').html("<span>"+total_num+"</span >件总计: <span id='total_m'>"+total+"</span> 货豆");

    }


    //删除购物车 rowid:ci购物车id,ids:商品id
    function deleteSelect(rowid,ids)
    { 

    	if(confirm('确定移除所选商品？'))
    	{
    		var rowids = new Array();
    		var pid = new Array();
			rowids[0] = rowid;
			pid[0] = ids;


            if(rowids[0] && pid[0]){
                $.post("<?php echo site_url('Cart/ajax_delete');?>",{rowid:rowids,pid:pid},function (data){
                    location.reload();
                })
        	}else{
        	    alert('请选择要删除的商品');
        	}
    	}
    }

    //移入收藏夹 product_id:商品id
    function remove_fav(obj,product_id){
        if(!isNaN(product_id)){
            $.post("<?php echo site_url('Member/fav/ajax_add');?>",{pid:product_id},function (data){
        		switch(data["status"]){
        		  case 0:
        			  window.location.href=account_url+"customer/login";
        			  break;
        		  case 1:case 3:case 5:
        			  window.location.reload();
        			  break;
        		  case 2:
        			  $(obj).html('<em class="icon-favorfill"></em>添加收藏');
        			  break;
        		  case 4:
        			  $(obj).html('<em class="icon-favorfill"></em>取消收藏');
        			  break;
        		}
            },"json")
        }else{
        	location.reload();
        }

    }

    //提交订单
    function submitform(){
    	if($('input[name="item[]"]').is(':checked')){
    		var ok = true;
        	$('input[name="item[]"]:checked').each(function(){
        		
        		var id = $(this).next().val();
        	    if(parseInt($('#item_num_'+id).val())>parseInt($('#stock_'+id).val())){
        	        alert('商品数量超过库存！')
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

<?php };?>

