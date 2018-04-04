  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
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
       <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                	<li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <!--<li><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>
                    <li><a href="<?php //echo site_url('corporate/myshop/ad_admin') ?>">广告管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>" >账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >实体消费二维码</a></li>
                    <li class="houtai_zijin_current"><a href="#" >门店管理</a></li>
                    <li><a href="#" > 销售报表</a></li>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">门店详情</div>
            <div class="stored_ch">
               <ul class="stored_ch_ul">
                 <li><span>分店名：</span><input type="text" class="n" name="search_name" value="丽枫酒店海珠店"></li>
                 <li><span>分店地址：</span><input type="text" class="n" name="search_name" value="广东省广州市海珠区江南大道中富力天域中心32楼3211室"></li>
                 <li><span>分店负责人：</span><input type="text" class="n" name="search_name" value="二哈"></li>
                 <li><span>负责人电话：</span><input type="text" class="n" name="search_name" value="138 0013 8000"></li>                
                 <li class="stored_ch_ul_lol"><span>二维码：</span><p><img src="images/logo-weixin-erweima.png"/></p></li>
               </ul>
               
          
               
               <div class="stored_ch_bottom">
                 <a href="#" class="stored_ch_left">保存</a>
                 <a href="#" class="stored_ch_rigth">返回</a>
               </div>
               
            </div>  
            
            
            
            <div class="tribal_goods" id="tribal_goods" style="display: none;">
        <div class="tribal_goods_top">
        <h1>申请储值卡</h1>
         <div class="tribal_goods_zhong">
            <ul>
              <li><span>服务商账号：</span><input type="text" class="n" name="search_name" value="" placeholder="请输入服务商账号"><a class="tribal_goods_a" href="#">查找</a></li>
              <li><span>用户名：</span><samp>51易货网</samp></li>
              <li><span>昵称：</span><samp>二哈</samp></li>
              <li><span>手机号：</span><samp>138-0013-8000</samp></li>
              <li><span>企业名：</span><samp>51易货网</samp></li>

            </ul>
         
         </div>
        <div class="tribal_goods_xia">
            <a href="javascript:;" class="huisr" onclick="huisr();">取消</a>
            <a href="javascript:;" onclick="sure();" class="lamseh">确定</a>
        </div>
        </div>
    </div>

            
            
            
         </div>
       <!--右边结束-->    
         </div>



     


<script>

//上传图片预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader(),
            img = new Image();       
        reader.onload = function (e) {
            if(input.files[0].size>307200){//图片大于300kb则压缩
                img.src = e.target.result;
                img.onload=function(){
                    $(obj).attr('src', compress(img));
						$("#thubm").css("width","120");
						$("#thubm").css("height","120");
                }
            }else{
                $(obj).attr('src', e.target.result);
				$("#thubm").css("width","120");
				$("#thubm").css("height","120");
				
            }
        }
        reader.readAsDataURL(input.files[0]);
        return 1;
    }  
}


//压缩图片函数
function compress(img) {
    var initSize = img.src.length;
    var width = img.width;
    var height = img.height;
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
    var ratio;
    if ((ratio = width * height / 4000000)>1) {
        ratio = Math.sqrt(ratio);
        width /= ratio;
        height /= ratio;
    }else {
        ratio = 1;
    }
    canvas.width = width;
    canvas.height = height;
    //铺底色
    ctx.fillStyle = "#fff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0, width, height);
    //进行最小压缩
    var ndata = canvas.toDataURL("image/jpeg", 0.1);
    console.log(ndata.length)
    canvas.width = canvas.height = 0;
    return ndata;
}




$(document).ready(function() {
    	$('#thubm').hover(
			function(){
				$('#xianshudwfn').show();
			},
			function(){
				$('#xianshudwfn').hover(function(){},function(){
					$('#xianshudwfn').hide();
				})
			}
		);
	});
		
	 $(".icon-cha").click(function (){
		 $('#xianshudwfn').hide();
		 $('#thubm').hide();
		 })
	
	
	
	<!--点击弹窗-->
	$("#buluo").click(function() {
	   $("#tribal_goods").css("display","block")
	   })

   $(".huisr").click(function() {
	   $("#tribal_goods").css("display","none")
	   })

		
</script>

	