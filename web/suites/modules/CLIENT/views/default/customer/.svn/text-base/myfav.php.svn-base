<style>
.dingdan4_3_tanchuang_top2 ul { margin-top:0px;}
.dingdan4_3_tanchuang_top2 ul li{ margin-bottom:8px;}
.dingdan4_3_tanchuang_top2 a{ color:#666; text-decoration:none;}
.shuliang input { width: 72px;height: 34px; border: 1px solid #9a9a9a; text-align: center;float: left; margin: 0 8px;}
.shuliang{display: table; float:left}
.dingdan4_3_btn01{ margin-left:110px;}
.dingdan4_3_btn03{ background:#fea33b;idth: 115px; height: 34px;border-radius: 2px;text-align: center;float: left;margin-left: 36px;margin-top: 13px;}
.ml136_fenlei{ position:relative}
#quantity{ height:36px; line-height:36px;}
</style>

    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 7;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">我的收藏</div>
            <div class="huankuan_rCon01">
            	<ul>
                	<li class="huankuan_rCon01_current"><a id="collect_shop">收藏商品</a></li>
                    <li class="huankuan_line"></li>
                    <li><a id="collect_shops">收藏的店铺</a></li>
                </ul>
            </div>
            <!--内容-->
            <div class="wodeshoucang_01_con clearfix">
            <!--商品收藏内容切换-->
            <div class="shoucang_shangpin" style="display:block">
            	<ul>
            	<?php if(count($lists)>0):?>
            	<?php foreach ($lists as $k=>$v):?>
            	<a href="<?php echo site_url("goods/detail/".$v['product_id']);?>">
                	<li <?php echo $k!=0&&$k%5==4 ?"style='margin-right:0'":"" ?>>
               	    <div class="collection_img"><img src="<?php echo $v['goods_thumb']?IMAGE_URL.$v['goods_thumb']:'shoucang_bg.png';?>" width="172"  alt=""/></div> 
                    <p class="shoucang_dianpu_p"><?php echo $v['product_name'];?></p>
                    <p style="margin:18px 0 20px 0; color:#555">¥<?php echo $v['price'];?></p>
                    <p class="shelf" style="margin:18px 0 20px 0; display:none;"><span class="icon-kulian"></span>商品下架了</p>
<!--                     <span>(20人)评价</span> -->
                    <div class="wodeshoucang_btn clearfix">
                    <div class="wodeshoucang_btn01"><a onclick="add_to_cart(<?php echo $v['product_id'];?>,<?php echo $v['id'];?>)" >加入购物车</a></div>
                     <div class="wodeshoucang_btn01" hidden><a>进入店铺</a></div>
                    <div class="wodeshoucang_btn01" style="margin-right:0"><a href="<?php echo site_url('member/fav/delete/'.$v['product_id']);?>">取消收藏</a></div>
                    </div>
                    </li> 
                </a>
                <?php endforeach;?>
                <?php else: ?>
                <div class="result_null">暂无收藏内容</div>
                <?php endif;?>
                

                </ul>
            </div>
            
            <!--收藏店铺内容切换-->
            <div class="shoucang_dianpu" style="display:none">
            	<ul>
            	<?php if(count($corporation)>0): ?>
            	<?php foreach ($corporation as $k=>$v):?>
            	    <a href="<?php echo site_url("home/GoToShop/".$v['id']);?>">
                	<li <?php echo $k!=0&&$k%5==4 ?"style='margin-right:0'":"" ?>>
                    <div class="collection_img"><img src="<?php echo IMAGE_URL.substr($v['img_url'],2)?>" width="172" height="215" alt=""/></div>
                    <p class="shoucang_dianpu_p"><?php echo $v['corporation_name']?></p>
                    <!--<p>关注时间：<?php //echo substr($v['created_at'],0,11)?></p>-->
                   <!--<div class="shoucang_dianpu_btn01"><a href="<?php //echo site_url("home/GoToShop/".$v['id'])?>">进入店铺</a>--><!--</div>-->
                    <div class="wodeshoucang_btn clearfix">
                    <div class="wodeshoucang_btn01"><a href="<?php echo site_url("home/GoToShop/".$v['id'])?>">进入店铺</a></div>
                    <div class="wodeshoucang_btn01" style="margin-right:0"><a onclick="del_shop(this,<?php echo $v['fid'] ?>)">取消收藏</a></div>
                    </div>
                    </li>
                    </a>
                 <?php endforeach;?>
                 <?php else: ?>
                 <div class="result_null">暂无收藏内容</div>
                 <?php endif;?>
                </ul>
            </div>
            </div>
            
      </div>



    </div>
    
    
      <div class="dingdan4_3_tanchuang" id="sure1" style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top"><i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
      <div class="dingdan4_3_tanchuang_top2">
     <div class="ml136_fenlei">
            	<div id="sku"></div>
                <dl id="quantity">
                	<dt>购物数量：</dt>
                    <dd>
                    	<span class="shuliang">
							 <a href="javascript:jQuery.reduce('#item_num');" class="jian num_oper num_min">－</a>
							 <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1"  onkeyup="jQuery.modify('#item_num');"/>
							 <a href="javascript:jQuery.add('#item_num')" class="jia num_oper num_plus">+</a>
							 <input id="item_amount" type="hidden" value=""/>
                        </span>  
                       
                        <b class="caution_tips" id="item-error" style="display:none;"></b>
                    </dd> 
                 
                </dl>   
                
				<input type="hidden" name="payflag" value="">
                <input type="hidden" id="val_id" value=0>
              <span  id="" style="position:absolute; left:270px; bottom:3px;">(库存5555)</span> 
            </div>
            </div>
          
     <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick="hiding()">取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:_delects(103)" id="sure">添加收藏</a></div>
          <div class="dingdan4_3_btn03"><a href="javascript:_delects(103)" id="sure">加入购物车</a></div>       
      </div>
  </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<!--移上显示加入收藏和进入店铺-->
<script>
$('.shoucang_shangpin li').hover(function(){
    //你要显示的层，div放到li里面。默认css属性是隐藏
    $(this).find('.wodeshoucang_btn').show();
},function(){
    //你要显示的列表形式
     $(this).find('.wodeshoucang_btn').hide();
});

$('.shoucang_dianpu li').hover(function(){
    //你要显示的层，div放到li里面。默认css属性是隐藏
    $(this).find('.wodeshoucang_btn').show();
},function(){
    //你要显示的列表形式
     $(this).find('.wodeshoucang_btn').hide();
});
</script>
<script src="js/ShoppingCart.js"></script>

    <script>
	function del_fav(id)
	{
		$.ajax({
		      url: base_url+'/member/fav/ajax_delete',
		      type: 'POST',
		      data:{'id':id},
		      dataType: 'html',
		      success: function(data){ 
// 					alert(data);
		    	  
		      	}
		    });
	}
	function add_to_cart(pid,id)
	{
		add_cart(pid,1);

// 		window.location.reload();
		
	}

	//加入购物车
	function add_cart(goodsid,qty)
	{
		$.ajax({
	      url: base_url+'/cart/ajax_add',
	      type: 'POST',
	      data:{'pid':goodsid,'qty':qty},
	      dataType: 'html',
	      success: function(data){ 
				alert(data);
				window.location.reload();
	      	}
	    });
//		alert(base_url);
	}

	//取消店铺收藏
	function del_shop(o,id){
	    $.ajax({
	        url: "<?php echo site_url('member/fav/del_store_corporation/') ?>"+"/"+id,
	    	type:"GET",
	    	dataType:"json",
	    	success:function(data){
	    	    if(data==1){
	    	        $(o).parent().parent().parent().remove();
		    	}
		    },
		    error:function(){

			}
		});
	}

	$("#collect_shops").click(function(){
	    $(".shoucang_dianpu").css("display","block");
	    $(".shoucang_shangpin").css('display','none'); 
	    $("#collect_shop").parent().removeClass();
	    $("#collect_shops").parent().addClass("huankuan_rCon01_current");
		});
	$("#collect_shop").click(function(){
	    $(".shoucang_dianpu").css("display","none");
	    $(".shoucang_shangpin").css('display','block');
	    $("#collect_shops").parent().removeClass();
	    $("#collect_shop").parent().addClass("huankuan_rCon01_current"); 
		});
    </script>


        <script type="text/javascript">
jQuery.extend( {
    min : 1,
    reg : function(x) {
        jQuery('#item-error').html("");
        jQuery('#item-error').hide();
        return new RegExp("^[1-9]\\d*$").test(x);
    },
    amount : function(obj, mode) {
        var x = jQuery(obj).val();
        if (this.reg(parseInt(x))) {
            if (mode) {
                x++;
            } else {
                x--;
            }
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>请输入正确的数量！");
            jQuery('#item-error').show();
            jQuery(obj).val(1);
            jQuery(obj).focus();
        }
        return x;
    },
    reduce : function(obj) {
        var x = this.amount(obj, false);
        
        if (parseInt(x) >= this.min) {
            jQuery(obj).val(x);
            			$("#total_price").text((curr_price * x).toFixed(2)+" 货豆");
						count_freight(parseInt(x));
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>商品数量最少为" + this.min
                    + "！");
            jQuery('#item-error').show();
            jQuery(obj).val(1);
            jQuery(obj).focus();
        }
    },
    add : function(obj) {
        var x = this.amount(obj, true);//获取所选的数量
        var max = jQuery('#item_amount').val();//获取库存数量
        if (parseInt(x) <= parseInt(max)) {
            jQuery(obj).val(x);
            			$("#total_price").text((curr_price * x).toFixed(2)+" 货豆");
						count_freight(parseInt(x));
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");
            jQuery('#item-error').show();
            jQuery(obj).val(max == 0 ? 1 : max);
            jQuery(obj).focus();
        }
    },
    modify : function(obj) {
        var x = jQuery(obj).val();
       
        jQuery(obj).val(x.replace(/\D|^0/g,''));     
        var max = jQuery('#item_amount').val();
        if (!this.reg(parseInt(x))) {
//                jQuery(obj).val(1);
            jQuery(obj).focus();
            jQuery('#item-error').html("<i class=\"ico\"></i>请输入正确的数量！");
            jQuery('#item-error').show();
            return;
        }
        var intx = parseInt(x);
        var intmax = parseInt(max);
        if (intx < this.min) {
            jQuery('#item-error').html("<i class=\"ico\"></i>商品数量最少为" + this.min
                    + "！");
            jQuery('#item-error').show();
            jQuery(obj).val(this.min);
            jQuery(obj).focus();
			return;
        } else if (intx > intmax) {
            jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");
            jQuery('#item-error').show();
            jQuery(obj).val(max == 0 ? 1 : max);
            jQuery(obj).focus();
			return;
        }
        		$("#total_price").text((curr_price * $(obj).val()).toFixed(2)+" 货豆");
				count_freight(parseInt(x));
    }
});




//运费计算
function count_freight(num){ 
	var is_freight = "";

	if( is_freight ){
    	var default_freight = "";//默认价格 10
    	var default_item = "";//默认数量是多少 1
    	var add_item  = "";//每增加多少件 3
    	var add_freight = "";//每增加X件+多少钱 10

    	if(num > default_item ){ 
    		var num = num - default_item;
    	    var num_a = num/add_item;
    	    if(isInteger(num_a) ){ //如果是整型 
    		    var freight = parseInt(num_a)*parseFloat(add_freight)+parseFloat(default_freight);
    		}else{ 
    			if(num_a < 1){
    				var freight = parseFloat(default_freight)+ parseFloat(add_freight);
    		    }else{ 
    		    	var freight = ( parseInt(num_a)*parseFloat(add_freight) ) + parseFloat(add_freight)+parseFloat(default_freight);
    			}
    			
    		}
    
    	    if(isInteger(freight) ){ 
    		    $('#freight').text(freight+'.00');
    	    }else{ 
    		   $('#freight').text(freight);
    	    }
    	    
    	    
        }else{ 
        	$('#freight').text(default_freight);
        }
    }

}
//是否正整数
function isInteger(number){
return number > 0 && String(number).split('.')[1] == undefined
}

var selectsku = new Array(); //选中的SKU
var skulist = new Array();//PRODUCT原来的SKU
var curr_stock = '1,260';
var curr_price = '260.00';
var special_price = '0.00';


function selectSKU(obj,attr_id,sku_id,sku_name)
{
	$(obj).addClass("active").siblings().removeClass();
	for(var i=0;i<skulist.length;i++)
	{
		if(attr_id == skulist[i])
		{
			selectsku[i] = attr_id+"-"+sku_id;
		}
		
	}

	setInfo();
	if(curr_stock<=0){
	    $("#sku_"+sku_name).attr("class","active");
	}
}

var str="";
var skuprice = new Array();

    
    //循环1开始
        skuprice[0] = ['3012-0_3013-0_3014-13_3015-6',400,0.00,260.00,0.00,0.00,688,0.00];
        skuprice[1] = ['3012-12_3013-0_3014-13_3015-6',500,0.00,260.00,0.00,0.00,689,0.00];
        skuprice[2] = ['3012-23_3013-0_3014-13_3015-6',360,0.00,260.00,0.00,0.00,690,0.00];
    //循环1结束
    
    //循环2开始
    //循环2结束

    //循环3开始
    			 skulist.push('3012');//属性id追加数组
		 str = str+'<lable class="item sku_item">颜色分类: </lable>'+'<div>'+ '<ul class="add_cart_size_list">';
		 
    		  //判断3开始
    				selectsku.push('3012-0');
    		  //判断3结束

		  //判断1结束
				 str = str+'<li id="sku_土豪金" class="active" onclick="selectSKU(this,\'3012\',\'0\',\'土豪金\')">土豪金</li>';

		//判断1结束
				 str = str+'<li id="sku_粉红色"  onclick="selectSKU(this,\'3012\',\'12\',\'粉红色\')">粉红色</li>';

		//判断1结束
				 str = str+'<li id="sku_黑色"  onclick="selectSKU(this,\'3012\',\'23\',\'黑色\')">黑色</li>';

					   str = str+'</ul></div>';
    		 skulist.push('3013');//属性id追加数组
		 str = str+'<lable class="item sku_item">套餐类型: </lable>'+'<div>'+ '<ul class="add_cart_size_list">';
		 
    		  //判断3开始
    				selectsku.push('3013-0');
    		  //判断3结束

		  //判断1结束
				 str = str+'<li id="sku_官方标配" class="active" onclick="selectSKU(this,\'3013\',\'0\',\'官方标配\')">官方标配</li>';

					   str = str+'</ul></div>';
    		 skulist.push('3014');//属性id追加数组
		 str = str+'<lable class="item sku_item">机身内存: </lable>'+'<div>'+ '<ul class="add_cart_size_list">';
		 
    		  //判断3开始
    				selectsku.push('3014-13');
    		  //判断3结束

		  //判断1结束
				 str = str+'<li id="sku_无" class="active" onclick="selectSKU(this,\'3014\',\'13\',\'无\')">无</li>';

					   str = str+'</ul></div>';
    		 skulist.push('3015');//属性id追加数组
		 str = str+'<lable class="item sku_item">版本类型: </lable>'+'<div>'+ '<ul class="add_cart_size_list">';
		 
    		  //判断3开始
    				selectsku.push('3015-6');
    		  //判断3结束

		  //判断1结束
				 str = str+'<li id="sku_中国大陆" class="active" onclick="selectSKU(this,\'3015\',\'6\',\'中国大陆\')">中国大陆</li>';

	//循环3结束

        
    		  str = str + '</ul></div>';
	 
	$('#sku').html(str);
	setInfo();




//sku商品执行
function setInfo()
{
	var item = "";
	var html = "";
	var but_button ="";
	
	for(var i=0;i<selectsku.length;i++)
	{
		item = item+selectsku[i]+"_";
		
	}
	for(var i=0;i<skuprice.length;i++)
	{
// 		alert(skuprice[i][0]+"_");
// 		alert(item);
		if(skuprice[i][0]+"_" == item)
		{
			//库存判断
			if(skuprice[i][1] <= 0){
				$("#quantity").empty();
				$('#total_price').html((skuprice[i][3]).toFixed(2)+" 货豆");
				$("#gouwuche").html('<div class="gouwuche" id="gouwuche" style="background: #cc3333;"><a href="javascript:void(0)" >此商品暂时缺货</a></div>');
				$("#goumai").remove();
				}else{
					html += '<dt>购物数量：</dt><dd><span class="shuliang"><a href=javascript:jQuery.reduce("#item_num"); class="jian num_oper num_min">－</a>';
					html += '<input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1"  oninput="jQuery.modify(&apos;#item_num&apos;)";/>';
					html += '<a href=javascript:jQuery.add("#item_num") class="jia num_oper num_plus">+</a>';
					html += '<input id="item_amount" type="hidden" value="'+skuprice[i][1]+'"/></span>';
					html += '</span><b class="caution_tips" id="item-error" style="display:none;"></b></dd>';
					$("#quantity").html(html);
					$('#total_price').html((skuprice[i][3]*$('#item_num').val()).toFixed(2)+" 货豆");

					but_button += '<div class="gouwuche" id="gouwuche"><a onclick="javascript:add_to_cart(1768,this)" >加入购物车</a></div>';
	                but_button += '<div class="goumai" id="goumai"><a onclick="javascript:buy(1768)">立即购买</a></div><br>';
	                but_button += '<p >累计评价： 0   <a style="text-decoration:underline; color:#fea33b; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(1768)" id="fav">收藏商品</a></p>';
					$(".ml136_btn").html(but_button);
					}
			
			var html_price = "";
			                html_price += '<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span>'+(skuprice[i][3]).toFixed(2)+'货豆</span></span>';
                $("#product_price").html(html_price);
            
            
			$("#product_stock").html(skuprice[i][1]);
			$('#val_id').val(skuprice[i][6]);
			$('#item_amount').val(skuprice[i][1]);
			$("#stock").text( skuprice[i][1]);
			curr_stock = skuprice[i][1];
			curr_price = skuprice[i][3];
			
			sku_special_offer = skuprice[i][7];
			break;
			
		}
	}
}

//加入购物车
function add_to_cart(pid,obj)
{
	var x = $("#item_num").val();//加入购物车数量
	if(x==""){//如果空默认为1个
		x = 1;
		$("#item_num").val(1);
		}
	var max = $('#item_amount').val();//获取库存数量
//     if (parseInt(x) <= parseInt(max)) {
//         jQuery(obj).val(x);
        // 		$("#total_price").text((curr_price * x).toFixed(2)+" 货豆");
		//     } else {
//         jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");
//         jQuery('#item-error').show();
//         jQuery(obj).val(max == 0 ? 1 : max);
//         jQuery(obj).focus();
//         return;
//     }
	txtC=$('input[name="item_num"]');
	qty = parseInt(txtC.val());
	sku_id = 0;
	
	if($('#val_id').val() != 0){
		sku_id = $('#val_id').val();
	}
	//alert(sku_id);
	add_cart(pid,qty,sku_id);
}

function add_to_fav(pid)
{
		alert('您还未登录，请先登录。');
	}

function buy(pid)
{
	if(!$("#item_num").val()){
		$("#item_num").val(1);
		}
	
	txtC=$('input[name="item_num"]');
	qty = parseInt(txtC.val());
	sku_id = $('#val_id').val();
//     alert(sku_id);
	window.location.href="http://www.51ehw.com/cart/add/" + pid + "/" + qty+"/"+sku_id;
}
</script>
    