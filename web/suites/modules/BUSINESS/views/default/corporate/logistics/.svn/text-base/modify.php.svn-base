<html>
<head>
<meta charset="UTF-8">
<script src="js/jquery.min.js"></script>
<script  src="js/drag.js"></script>
<script src="js/city_arr.js"></script>
<script  src="js/city_func.js"></script>
<script >
// 是否在数组内
function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}
</script>
<!--拼团样式-->
<style>
.table1.manage_b_table1 th { font-size: 14px;}
table th{border: 1px solid #ccc; border-top:none !important}
.table1.manage_b_table1 th{ height:45px; }
.search_1.manage_c_search_1 ul li{ margin: 0 9px 0 0;}
.search_1.manage_c_search_1 ul{width: 807px !important;}
.dingdan4_3_btn01{margin-left:10px;}
.tr1.manage_b_tr1{ background:#f5f5f5; text-align:center; height:45px;}
.tr1.manage_b_tr1 th{font-weight:bold;}
.cmRight_con.manage_fenlei_cmRight_con .select1 ul{ margin-bottom:10px;}
 .dianpu_left{ width:90px;}
.dianpu_01_con01{ margin-left:30px}
.yufei{ margin-left:0}
.yufei ul{ margin-left:0; width:743px; margin:5px 0 10px 0}
.yufei ul li{ margin-left:34px;}
</style>
</head>
<body>
 <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
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
  
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <div class="cmLeft manage_new_cmLeft">

            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down">
            	<ul>
                	<li><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                    <!--<li><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li><a href="<?php echo site_url('corporate/myshop/user') ?>" >账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>--> 
                    <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale_code') ?>" >实体消费二维码</a></li>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/logistics/management') ?>" >物流管理</a></li>
                </ul>
            </div>
        </div>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">修改模版</div>
  <div class="dianpu_01_con01 clearfix">
                <div class="dianpu_left">
                	<ul>
                    	<li>模版名称:</li>
                        <li>计价方式:</li>
                    </ul>
                </div>
                <div class="dianpu_01_right dropdown basicInformation_right">
                	<ul>
                    	<li><input class="dianpu_01_input" type="text" name="contact_name" placeholder="请输入模版名称"></li>
                        <li>按件数</li>
                    </ul>
                </div> 
                 <div class="dianpu_left">
                	<ul>
                        <li>联系人 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right" style="margin-top:9px;">
                   <p class="yanse-l">除指定地区外，其余地区的运费采用“默认运费”</p>
					 <div class="yufei">
                            <ul class="sub_1">
                              <li>
                              <samp>默认运费：</samp><input id="" type="text" name="default_item"class="" value="" ><samp>件内,</samp>
                                    <input id="" type="text" name="default_freight"class="" value=""><samp>元，每增加</samp>
                                     <input id="" type="text" name="add_item"class="" value=""><samp>件，增加运费</samp>
                                      <input id="" type="text" name="add_freight"class="" value=""><samp>元</samp>
                                    </li>
                            </ul>
                           </div>
                           
                	<ul class="added">
                    
                    <table width="743" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="qiehuan">
                    <tbody>
                    <tr class="tr1 manage_b_tr1">
                        <th width="318px">运送到</th>
                        <th width="90px">首件/个</th>
                        <th width="90px">运费/元</th>
                        <th width="90px">续件/个</th>
                        <th width="90px">运费/元</th>
                        <th width="90px">操作</th>
                    </tr>
                    <li style="overflow:hidden;">
                    <tr class="qiehuan">
                        <th width="318px" style="text-align:left; position:relative"><textarea rows=1 cols=40  onfocus="window.activeobj=this;this.clock=setInterval(function(){activeobj.style.height=activeobj.scrollHeight+'px';},100);"id="btn_jobArea" type="button" placeholder="未添加地区" value="未添加地区" onclick="jobAreaSelect()"></textarea><span class="yansec" onClick="jobAreaSelect()">编辑</span></th>
                        <th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th>
                        <th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th>
                        <th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th>
                        <th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th>
                        <th width="90px"><a href="javascript:void(0);" style="color:#fca543; width:84px; text-decoration:underline">删除</a></th>
                     </tr>
                     </li>
                 </tbody></table>
                    </ul>   
                     <div class="zhiding">为指定地区设置运费</div>
                     <div class="zhiding1"><a >保存并返回</a><a  style="background:#dddddd;"onclick="submit();">取消</a></div>
                </div>
       		</div>
		</div>
       </div>
       
       
       <div id="maskLayer" style="display:none">
<iframe id="maskLayer_iframe" frameBorder=0 scrolling=no style="filter:alpha(opacity=50)"></iframe>
<div id="alphadiv" style="filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5"></div>

	<div id="drag">
	<div class="dingdan4_3_tanchuang_top">请选择地区<i  class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i> </div>
		<div id="drag_con"></div><!-- drag_con end -->
        <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn02" style="margin-left:190px; margin-right:5px;"><a href="javascript:void(0);"  style=""id="sure" onclick="jobArea.confirm()">确定</a></div>    
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick="hiding()">取消</a></div>
             
      </div>
	</div>
</div><!-- maskLayer end -->
</div>
<!-- alpha div end -->
<div id="sublist" style="display:none"></div>

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
</body>
</html>
<script>
  $('#shangchu').click(function(){
     $("#management").hide()
  });
  
   $('#shangchu1').click(function(){
	 $("#management1").hide()
  });
  
   $('#shangchu2').click(function(){
	 $("#management2").hide()
  });
  
   $('.icon-guanbi').click(function(){
	 $("#maskLayer").hide()
  });
   $('.dingdan4_3_btn01').click(function(){
	 $("#maskLayer").hide()
  });
</script>
<script>
        $('.zhiding').click(function(){
            loading();
        });
        function loading(){
            for(var i=0; i<1; i++) {
                /*加载3条数据*/
                $('#qiehuan').append('<tr class="qiehuan"><th width="318px" style="text-align:left; position:relative"><textarea rows=1 cols=40  onfocus="window.activeobj=this;this.clock=setInterval(function(){activeobj.style.height=activeobj.scrollHeight+"px";},100);"id="btn_jobArea" type="button" placeholder="未添加地区" value="未添加地区" onclick="jobAreaSelect()"></textarea></br><span class="yansec" onClick="jobAreaSelect()">编辑</span></th><th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th><th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th><th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th><th width="90px"><input id="" type="text" name="default_item"class="added-input" value="" ></th><th width="90px"><a href="javascript:void(0);" style="color:#fca543; width:84px; text-decoration:underline">删除</a></th></tr>');
            }    
        }
</script>
