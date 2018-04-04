<style>
table th{ line-height:normal;border:1px solid #dddddd; padding:10px 0; font-size:12px !important; }
.table1_1{ height:35px !important; background:#f6f6f6 !important;}
.search_2.manage_c_search_2{     margin: 3px 0;}
.cmRight_con.manage_c_cmRight_con table, .cmRight_con.manage_c_cmRight_con table a, .cmRight_con.manage_c_cmRight_con table p{ font-size:12px;}
.cmRight_con.manage_b_cmRight_con a{ font-size:13px;}
.huaznjj{ padding:0 15px; color:#dddddd !important;}
.cmRight_con.manage_a_cmRight_con ul li{ width:auto !important;margin: 0 0px 0 0;}
.cmRight_con.manage_c_cmRight_con .search_0{ height:50px; }
.search_1.manage_c_search_1{margin: 10px 0;}
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
		<div class="cmRight_tittle">部落优惠商品</div>
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1">
						<ul>
							<li style="margin-right: 0px" ><a href="<?php echo site_url('corporate/tribe_product');?>" class="<?php echo $status==0?"xcurrent":'';?>">全部(<?php echo $all;?>)</a><span class="huaznjj">|</span></li>
							<li><a href="<?php echo site_url('corporate/tribe_product/index/0/1');?>" class="<?php echo $status==1?"xcurrent":'';?>">销售中(<?php echo $sales;?>)</a><span class="huaznjj">|</span></li>
							<li><a href="<?php echo site_url('corporate/tribe_product/index/0/2');?>" class="<?php echo $status==2?"xcurrent":'';?>">待发布(<?php echo $wait;?>)</a><span class="huaznjj">|</span></li>
							<li><a href="<?php echo site_url('corporate/tribe_product/index/0/3');?>" class="<?php echo $status==3?"xcurrent":'';?>">已售罄(<?php echo $out;?>)</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="select1">
				<ul>
					<li><a href="javascript:;" id="buluo" onclick="buluo();">修改优惠部落</a></li>
				</ul>
                <div class="search_2 manage_fenlei_search_2 manage_c_search_2">
							<div>
								<input type="text" class="search2_con manage_fenlei_search2_con" name="keywork" value="<?php echo !$status?$keywork:"";;?>"  placeholder="搜索商品">
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:;" onclick="location.href='<?php echo site_url("Corporate/tribe_product").'/index/';?>'+$('input[name=keywork]').val();">店内搜索</a>
							</div>
					</div>
				<table width="910" height="35" border="1" cellpadding="0"
					cellspacing="0" class="table1_1">
					<tr class="tr1 manageC_tr">
						<th width="300px" style="text-align: left"><input type="checkbox" style="margin-right: 68px; margin-left: 15px" onclick="selectAll('goods',this)" id="selectAllgoods">商品名称</th>
						<th width="100px">分类</th>
						<th width="102px">价格(货豆)</th>
						<th width="124px">可享优惠的部落</th>
						<th width="58px">状态</th>
						<th width="124px">部落内销售数</th>
						<th width="122px">操作</th>
					</tr>
				</table>
				<?php if($product){;?>
				<?php foreach ($product as $v){;?>
                <table class="table_border">
                	<tr class="tr1">
                		<td colspan="9" style="text-align: left;background:#fff6eb;border:1px solid #dddddd;">
            		        <input type="checkbox" name="goods[]" id="<?php echo "goods_".$v['product_id'];?>" style="margin-right: 68px; margin-left: 15px" value="<?php echo $v['product_id'];?>" onclick="Radio('goods')">商品ID：<?php echo $v['product_id'];?>
                			<span style="margin-left: 40px">商品编码：<?php echo $v['productnum'];?></span>
                            <span style="margin-left: 40px">上架时间：<?php echo $v['on_sale_at'];?></span>
                		</td>
                    </tr>
                    <tr class="tr1">
                    	<th width="300px" style="text-align: left">
                        	<div class="tImg" style="float:none; display:inline-block;vertical-align:middle;">
                    			<img alt="<?php echo $v['name'];?>" src="<?php echo $v['goods_thumb'] ? IMAGE_URL.$v['goods_thumb']:'images/m_logo.jpg';?>" >
                    		</div>
                    		<p style="width: 146px;word-wrap: break-word; word-break: normal; line-height:normal; vertical-align:middle; "><?php echo $v['name'];?></p>
                		</th>
                    	<th width="100px"><?php echo $v['cat_name'];?></th>
                    	<th width="102px"><span>部落价</span><br><span style="font-weight:bold"><?php echo $v['tribe_price'];?></span></th>
                    	<th width="124px"><?php echo $v['tribe_name'];?></th>
                    	<th width="58px">
                    	<a href="javascript:void(0)" style="color: #fca543; text-decoration: underline" id="">
                    	<?php switch ($v['is_on_sale']){
                    	    case 0:
                    	        echo "下架";
                    	        break;
                    	    case 1:
                    	        echo "上架";
                    	        break;
                    	    case 2:
                    	        echo "审核中";
                    	        break;
                	        case 3:
                	            echo "待上架";
                	            break;
                	        case 4:
                	            echo "审核失败";
                	            break;
                    	}?>
                    	</a></th>
                    	<th width="124px"><p style="color:#999999;"><?php echo $v['tribe_sales'];?></p></th>
                		<th width="122px"><a class="bijibuluo" href="javascript:;" onclick="buluo(<?php echo $v['product_id'];?>,'<?php echo "-".$v["tribe_id"]."-";?>');">编辑优惠范围</a></th>
                	</tr>
                </table>
                <?php };?>
                <?php }else{;?>  
                <div class="result_null" style="margin-top:10px;">暂无内容，请点击上面添加按钮来添加产品</div>
                <?php };?>
				<div class="jilu jilu2">
                    <p>显示 <?php echo $start;?> 到 <?php echo $end;?> 条数据，共 <?php echo $totalcount; ?> 条数据</p>
				</div>
				<div class="showpage">
					<?php echo $pagination;?>
				</div>
			</div>
		</div>
	</div>
</div>



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


    <div class="tribal_goods" id="tribal_goods" style="display:none;">
        <div class="tribal_goods_top">
        <h1>选择可享受优惠的部落</h1>
        <div class="tribal_goods_zhong">
        <ul class="tribal_goods_zhong_li">
            <h2><input type="checkbox" onclick="selectAll('tribe',this);" id="selectAlltribe"/><span>所有部落</span></h2>
            <?php foreach ($mytribe as $v){?>
            <li><input name="tribe[]" type="checkbox" value="<?php echo $v['id'];?>" onclick="Radio('tribe');" /><span><?php echo $v["name"];?></span></li>
            <?php };?>
        </ul>
        </div>
        <div class="tribal_goods_xia">
            <a href="javascript:;" class="huisr" onclick="huisr();">取消</a>
            <a href="javascript:;" onclick="sure();" class="lamseh">确定</a>
        </div>
        </div>
    </div>

<script>
//全选
function selectAll(type,obj)
{
	var flag = $(obj).is(':checked');
	$("input[name='"+type+"[]']").each(function () {
		 $(this).prop("checked",flag);
    });
}
// ----------------------------------------------------

//单选
function Radio(type){
	var flag = true;//默认全部选中
    $("input[name='"+type+"[]']").each(function () {
    	 if(!$(this).is(":checked")){
    		 flag = false;
    		 return ;
    	 }
    });
	$("#selectAll"+type).prop("checked",flag);
}

//----------------------------------------------------

//修改优惠部落
function buluo(priductid,tribe_id) {
   if(priductid){
	   var flag = true;//默认全部选中
	   $("#goods_"+priductid).prop("checked",true);
	   $("input[name='tribe[]']").each(function(){
		   if(tribe_id.match("-"+$(this).val()+"-")){
	   	   		$(this).prop("checked",true);
		   }else{
			   flag = false;
		   }
	   });
	   $("#selectAlltribe").prop("checked",flag);
   }
   $('body').css("overflow","hidden")
   $("#tribal_goods").css("display","block");
}

// ----------------------------------------------------

//隐藏部落选择
function huisr() {
   $("#tribal_goods").css("display","none");
   $('body').css("overflow","scroll");

	$("input[name='goods[]']").each(function () {
		 $(this).prop("checked",false);
	});

    //取消选择
	$("#selectAllgoods").prop("checked",false);
	$("#selectAlltribe").prop("checked",false);
	$("input[name='goods[]']").prop("checked",false);
	$("input[name='tribe[]']").prop("checked",false);

}

// ----------------------------------------------------

//确定修改优惠部落
function sure(){

	var tribeid = new Array();
	var productid = new Array();

	var i = 0;
	$("input[name='tribe[]']").each(function () {
		if($(this).is(":checked")){
			tribeid[i] = $(this).val(); 
			i++;
	   	}
    });

    if(!tribeid[0]){
    	huisr();//隐藏单窗口
    	alert('请选择修改的部落');return;
    }

    var i = 0;
    $("input[name='goods[]']").each(function () {
		if($(this).is(":checked")){
			productid[i] = $(this).val(); 
			i++;
	   	}
    });

    if(!productid[0]){
    	huisr();//隐藏单窗口
    	alert('请选择被修改的商品');return;
    }
    
    //执行修改
    $.post("<?php echo site_url('Corporate/tribe_product/Modify_tribal_goods');?>",{productid:productid,tribeid:tribeid},function(data){
    	huisr();//隐藏单窗口
        switch(data['status']){
     	   case 1:case 2:case 3:
      		  alert(data['errormessage']);
     	      break;
     	   case 4:
     	      alert("修改失败");
      	      break;
        }
        location.reload();
    },'json');


}

// ---------------------------------------------------





</script>


