<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/style_v2.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">

<style>
.webuploader-container { position:static;left: 0; top: 0; }
.webuploader-pick { position: relative; display: inline-block; cursor: pointer; background: #72c312; padding: 0px 0px; color: #fff; text-align: center; border-radius: 3px; overflow: hidden; }
.webuploader-pick-hover { background: #72c312; }
.webuploader-pick-disable { opacity: 0.6; pointer-events: none; }
.diyButton{ width:180px!important;}
.webuploader-container div{ width:126px !important; height:34px !important; line-height:34px;/*position:absolute; display:block;*/}
.result_null{ width:910px; margin:0px auto;}

.parentFileBox>.fileBoxUl>li>.diyCancel,
.parentFileBox>.diyButton{text-align: left; margin-left: 35px; } 
 #fileBox_WU_FILE_0{height: 150px;width:170px!important;float:left!important;margin-right: 6px;margin-left: 0px;padding:0px}
 #fileBox_WU_FILE_1{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_2{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_3{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 .cmRight_con.manage_a_cmRight_con ul li{ float:left!important;}
 .diyUploadHover{ width:170px!important;padding:0px!important; }
 .fileBoxUl li{ width:170px!important; float: left;}
.parentFileBox>.fileBoxUl>li:hover { -moz-box-shadow:none; -webkit-box-shadow: none; box-shadow:none; }
.procurement-text7{display:block!important;}
#cke_explain{width:698px!important; float: right;margin-right: 40px;position: relative;top: -30px;}
.need-text5 {width: 274px;border: 1px solid #C8C8C8;outline: none;-webkit-appearance: none;border-radius: 0;background: #fff;color: #CACACA;padding-left: 10px;background: url("images/needs_right_icon.png") no-repeat scroll right center transparent;}
.procurement-time02 {padding-left: 0px;}
.needs_publish_tijiao {width: 170px;height: 40px;background: #6DC310;margin-top: 25px;margin-left: 160px;color: #fff;border: 1px solid #6DC310; border-radius: 3px;display: block;line-height: 40px;text-align: center; }
.bainse{margin-right:229px; margin-top:11px; color:#C3482C; float:right;}
#demo .parentFileBox {width: 590px!important;}
</style>
</head>
<body>
 <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
<!--     		<li><a href="">首页</a></li> -->
<!--     		<li><a href="">商品管理</a></li> -->
<!--     		<li><a href="">订单管理</a></li> -->
<!--     		<li><a href="">客户管理</a></li> -->
<!--     		<li ><a href="">评价管理</a></li> -->
<!--     		<li class="tCurrent"><a href="">店铺管理</a></li> -->
    		<li ><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
            <li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <form method="post" action="<?php echo site_url('corporate/information/edit');?>" id="form">
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                    <!--<li><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>-->
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>" >账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>--> 
                    <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale_code') ?>" >实体消费二维码</a></li>
                </ul>
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">公司介绍</div>
           
          <div class="dianpu_01_con01 clearfix" id="recite_add">
               <div class="dianpu_ls">
            	<div class="dianpu_left">
                	<ul>
                    	<li>公司名称:</li>
                        <li>公司图标:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    	<li><span style="height:43px; line-height:43px; display:block; overflow:hidden;"><?php echo $corporation['corporation_name']?></span></li>
                        <li id="img" ><img id="logo_img" src="<?php echo IMAGE_URL.$corporation['img_url']?>" width="150" height="150" alt=""/></li>
                    </ul>
                    <!-- 上传图片按钮 -->
                </div>
              </div>
              <div class="dianpu_zhong">
                 <div class="dianpu_zhong_l"><samp>＊</samp>公司简介：</div>
                 <div class="dianpu_zhong_r"><textarea  placeholder="(必填，不少于100字，不多于500字)" name="description"  class="procureme"><?php echo htmlentities($corporation['description']);?></textarea><br><span id="company_" class="recite_tip"></span></div>
                <span class='state1' id="description_"></span>
              </div>
              
              <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li><samp>＊</samp>公司图片 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <li id="img" ><img id='picture_img' src="<?php foreach ($image as $v){if($v['type']=='picture'){echo $v['image_name'];}}?>" width="250" height="154" alt=""/></li>
                    </ul>
<!--                     <p class="dianpu_01_p01">图片大小不能超过274KB,尺寸为 390x240，图片格式支持 .jpeg / .jpg / .png / .gif </p><span id='picture_' class="recite_tip"></span> -->
                    
                </div>
                </div>
                 <div class="dianpu_zhong">
<!--                  <div class="dianpu_zhong_l">个人介绍：</div> -->
<!--                  <div class="dianpu_zhong_r"><textarea placeholder="(必填，不少于100字，不多于500字)" name="personal" class="procureme"></textarea><span id="personal" class="recite_tip"></span></div> -->
              </div>
                <?php $number=0;foreach($image as $v){if($v['type']=='ce'){$number++;}}?>
                <div class="dianpu_ls">
                <div class="dianpu_left">
                	<ul>
                    	<li>企业实力展示 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
<!--                     <p class="dianpu_01_p01">图片大小不能超过128KB,尺寸为 260x186，图片格式支持 .jpeg / .jpg / .png / .gif </p> -->
                </div>
                <input type="text" value="<?php echo $number;?>" id="number" hidden>
                    <?php if($number>0){?>
                    <div class="new_edit_box clearfix">
                    <div style="margin-left:144px;">
                        <?php foreach ($image as $val){;?>
                        <?php if($val['type']=='ce'){?>
                        <div style="float:left;" class="parentFileBox" id="<?php echo $val['type'].'_'.$val['id']?>">
                            <ul class="fileBoxUl">
                            <li id="fileBox" class="diyUploadHover" style="border: none; width:170px!important; float:left!important;">
                            <div class="viewThumb"> <img src="<?php echo $val['image_name'];?>"> </div>  
                            </li>  
                            </ul>
                        </div>
                        <?php };?>
                        <?php };?>
                    </div>
                    </div>
                    <?php };?>

                
                </div>
                
                <div class="dianpu_ls dianpu_ls1">
                <div class="dianpu_left">
                	<ul>
                    	<li>领导关怀 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul style="margin-right:-47px;">
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_1' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==1){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p>              </li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_2' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==2){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p></li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_3' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==3){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p></li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative"><img id='solicitude_4' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==4){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p></li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_5' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==5){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p></li>
                        <li class="tj_t1 hover_it"id="img" style="position: relative" ><img id='solicitude_6' src="<?php foreach ($image as $v){if($v['type']=='solicitude' && $v['number']==6){echo $v['image_name'];}}?>" width="200" height="165" alt=""/><p></p></li>
                    </ul>
                    <p class="dianpu_01_p01">图片大小不能超过107KB,尺寸为 250x174，图片格式支持 .jpeg / .jpg / .png / .gif  <span style="color:#c23126; font-size:14px;">最多可以上传6张</span> </p>
                  
                </div>
                </div>
                 <div>
                     <div class="dianpu_di"> 
                        <a href="<?php echo site_url('corporate/information/edit_view');?>" class="dianpu_recite_btn">编辑</a>
                    	<!-- <a onclick=sub(1); class="dianpu_recite_btn" style="width:150px">隐藏公司介绍</a>  -->
                    </div>
              </div> 
              </div>
              
              </div>
              </div>
              </form>
</body>

<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" style="display:none" id="danchuang">
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
</html>
