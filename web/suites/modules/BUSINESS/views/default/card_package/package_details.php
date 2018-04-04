<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<style>
.need-text5 {
    width: 262px;
    float: left;
    border: 1px solid #C8C8C8;
    outline: none;
    -webkit-appearance: none;
    border-radius: 0;
    background: #fff;
    background: url(images/needs_right_icon.png) no-repeat scroll right center transparent;
    text-indent: 0.5em;
	margin-right:20px;
	color:#555555;
}
.dianpu_01_right ul li{ line-height:35px; overflow:hidden; height:35px;}
.dianpu_left ul li{ height:35px; line-height:35px;}
.condition{ margin-top:5px;}
.tips-box-r{ margin-bottom:10px;}
.dianpu_zhong{ margin-bottom:15px; margin-top:0px; line-height:35px;}
.dianpu_left ul li{ line-height:35px;}
.procureme{ width:710px;}

.daxiao{ width:240px; height:110px;border: 1px solid #C8C8C8; margin-bottom:20px}
.daxiao img{object-fit: contain;width: 100%;height: 100%;}
.daxiao1{ width:210px; height:240px;border: 1px solid #C8C8C8; margin-bottom:20px}
.daxiao1 img{object-fit: contain;width: 100%;height: 100%;}
.dianpu_01_con01{ margin-left:30px;}
.tr1.manage_b_tr1{ height:48px;}
.table1.manage_b_table1 th{ height:48px !important;}
.manage_b_table1 th{ height:48px;}
table th{border: 1px solid #ccc;}
</style>
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
        <li class="tCurrent"><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
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
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">活动管理</div>
		<div class="cmLeft_down"> 
			<ul>
				<li><a href="<?php echo site_url("corporate/activity/get_list");?>">拼团活动</a></li>
                <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/card_package');?>">货包活动</a></li>
				
			</ul>
		</div>
	</div>
	<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">货包详情</div>
          <div class="dianpu_01_con01 clearfix" id="recite_add">
               <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>货包名称:</li>
                        <li>指定商品/品类:</li>
                        <li>商品ID:</li>
                        <li>折扣/满减/现场礼包:</li>
                        <li>发放数量:</li> 
                        <li>发放日期:</li>
                        <li>有效日期:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                   <li class="dingwe"><?php echo $package['name'];?></li>
                     <li><?php echo $package['specified_type']==1?"商品":"品类";?></li>
                     <li><div class="condition">
               <?php foreach ($selected as $v){;?>
               <div class="tips-box-r">
				<div class="tips-content"><?php echo $v['id'];?>
				</div>
				<span></span>
			   </div>
			   <?php };?>

              </div></li>
              <li><?php if($package['discount_type']==1){echo "折扣：".$package['discount'].'折';}else if($package['discount_type']==2){echo "满减：".'满'.$package['overtop_price'].'减'.$package['deduction_price'];}else{echo "现场礼包";};?></li>
              <li><?php echo $package['give_type']==1?'赠送全部用户':"领完即止（共有".($package['number']+$receivetotal)."份货包）"?></li>
              <li><?php echo $package['grant_start_at']; ?><span style="margin:0 10px; color:#cccccc">－</span><?php echo $package['grant_end_at']; ?></li>
              <li><?php echo $package['coupon_start_at']; ?><span style="margin:0 10px;color:#cccccc">－</span><?php echo $package['coupon_end_at']; ?></li>
                    </ul>
                </div>
              </div>
              <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l">详细说明：</div>
                 <div class="dianpu_zhong_r" style="width:755px; overflow:hidden; line-height:25px;"><?php echo $package['describe']; ?></div>
              </div>
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>优惠券展示图:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<div class="daxiao"><img src="<?php echo IMAGE_URL.$package['coupon_image']; ?>"/></div>
                </div>
                </div>
                
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>详情页广告图 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                   <div class="daxiao1"><img src="<?php echo IMAGE_URL.$package['ad_image']; ?>"/></div>
                </div>
                </div>
                <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>其他属性:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                   <li class="dingwe"><span><?php echo $package['donation']==1?"可转赠其他用户":"禁止转赠"; ?></span></li>
                    </ul>
                </div>
              </div>
                 <div>
                  <div class="tongji">
                   <ul>
                    <li>统计信息:</li>
                   </ul>
                  <div class="tonhji-nei"><span>已领取：<?php echo $receivetotal;?></span><?php if($package["give_type"]==2){?><span>剩余未领取：<?php echo $number["not_number"];?></span><?php };?><span>已使用：<?php echo $use;?></span></div>
                  </div>
                  
              </div> 
              </div>
              
             <div class="tongji-di">
               <div class="tongji-di-nei">
               <div class="shouquan">
                <span>授权发放货包用户：</span>
                <input class="kehu_kehuguanli1_input" type="text" placeholder="请输入用户手机号"  id="mobile" >
                <a onclick="authorize();">授权</a>
               </div>
               <div class="shouquan-nei">
               <h6>已授权用户列表</h6>
               <table width="907" border="1" cellpadding="0" cellspacing="0" class=" manage_b_table1">
				  
                    <tbody>
                    <tr class="tr1 manage_b_tr1">
                        <th width="227px">用户名</th>
                        <th width="340px">手机号码</th>
                        <th width="340px">操作</th>
                    </tr>
                    <?php if($accredit){?>
                    <?php foreach ($accredit as $v){?>
                     <tr> 
                        <th width="227px"><?php echo $v["name"];?></th>
                        <th width="340px"><?php echo $v["mobile"];?></th>
                       <th width="340px"><a onclick="cancel(this,'<?php echo $v['p_id']?>','<?php echo $v['customer_id']?>')"  style="color:#fca543; text-decoration:underline">取消授权</a></th>
                     </tr> 
                    <?php };?>
                    <?php };?>
                    </tbody>
                </table>
               
               </div>
                <?php if(!$accredit){?>
                 <div class="result_null" style="margin-top:10px; color:#fca543;">暂无授权用户</div>
                <?php };?>
               
               </div>
             </div> 
              </div>
              
</div>
<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang"style="display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'></p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div style="width: 300px;overflow: hidden;margin: 0px auto;">
              <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a> </div>  
              <div class="dingdan4_3_btn01" style="background:#ccc;">  <a id="re_message" href="javascript:void(0);" onclick="$('.dingdan4_3_tanchuang').hide()">取消</a></div>     
          </div>
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

<script type="text/javascript">

//取消授权
function cancel(obj,pid,customerid){
	$.post("<?php echo site_url("corporate/card_package/up_authorize");?>",{pid:pid,customerid:customerid},function(data){
		  switch(data['status']){
		    case "1":
			    alert("操作失败");
			    window.location.reload();
			    break;
		    case "2":
		    	$(obj).parent().parent("tr").remove();
			    break;
		  }
		},'json');
}

//添加授权
function authorize(){
	var id = "<?php echo $package['id'];?>";
	var mobile = $("#mobile").val();
	var verify = /^1[34578]{1}\d{9}$/;
	if(verify.test(mobile)){
		$.post("<?php echo site_url('corporate/card_package/authorize');?>",{mobile:mobile,id:id},function(data){
			   switch(data['status']){
			       case "1":
			    	   alert("请填写正确的手机号！");
				       break;
			       case "2":
				       alert("用户不存在");
				       break;
			       case "3":
				       alert("此用户已经授权");
				       break;
			       case "4":
				       alert("授权成功");
				       window.location.reload();
				       break;
			       case "5":
				       alert("授权失败");
				       window.location.reload();
				       break;
			       case "6":
				       alert("数据错误");
				       window.location.reload();
				       break;
			   }
			},'json');
	}else{
		alert("请填写正确的手机号！");
	}
	
}

</script>

