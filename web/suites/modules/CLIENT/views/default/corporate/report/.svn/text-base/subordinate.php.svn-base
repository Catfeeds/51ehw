<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li class="tCurrent"><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<!--内容开始-->
    <div class="Box manage_new_Box clearfix">
    	<div class="cmLeft manage_new_cmLeft">
          <div class="downTittle manage_new_downTittle menu_manage_downTittle">下线分成</div>
            <div class="cmLeft_down">
            	<ul>
                	<li class="houtai_zijin_current"><a href="<?php echo site_url("corporate/report/subordinate") ?>">下线列表</a></li>
                    <li><a href="<?php echo site_url("corporate/report/divided_into") ?>">分成明细</a></li>
                </ul>
            </div>
        </div>
        <!---->
          <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
        
            <div class="cmRight_tittle">下线列表</div>
            <div class="kehu_kehuguanli1_con01 clearfix">
            	<div class="kehu_kehuguanli1_con01_left">
                	<ul>
                        <li>搜索类型：</li>
                        <li>关键字：</li>
                        <li>最后登录时间：</li>
                    </ul>
                </div>
                <div class="kehu_kehuguanli1_con01_right">
                <form action ="<?php echo site_url('corporate/report/subordinate'); ?>" method="get" id="subform">
                	<ul>
                    	<li>
                        	<span class="sel_01 tuikuanchaxun_sel">
                            <span class="sel_02">
                        	<select  class="zijin1_1_select" name="product_score" id="select" >
                            	<option value="" <?php echo isset($select_id)&&$select_id==null?"selected":"" ?>>请选择</option>
                                <option value="1" <?php echo isset($select_id)&&$select_id==1?"selected":"" ?>>用户ID</option>
                                <option value="2" <?php echo isset($select_id)&&$select_id==2?"selected":"" ?>>商家名称</option>
                                <option value="3" <?php echo isset($select_id)&&$select_id==3?"selected":"" ?>>登陆账号</option>
                            </select>
                            </span>
                            </span>
                        </li>
                           <li>
                           <input class="kehu_kehuguanli1_input" type="text" placeholder="请输入关键词"name="order_sn" id="search_input"
                            value="<?php
                                 if(isset($customer_id)&&$customer_id!=null) echo $customer_id;
                                 elseif(isset($corporation_name)&&$corporation_name!=null) echo $corporation_name;
                                 elseif(isset($name)&&$name!=null) echo $name;
                            ?>"
                           >
                           </li>

                        <li>
                        	<input type="text" value="<?php echo !empty($start_time)?$start_time:''; ?>" class="zijin1_1_con01_input01" name="start_time" onClick="WdatePicker()" readonly>
                            <span>至</span>
                            <label><input type="text" value="<?php echo !empty($end_time)?$end_time:''; ?>" class="zijin1_1_con01_input01" name="end_time" onClick="WdatePicker()" readonly></label>
                        </li>
                    </ul>
                <!--  
                    <div class="dagou2"><a href="javascript:void(0)" class="<?php //echo isset($is) ? $is : 0?"dagou1":"dagou1 active1" ?>"><input type="hidden" name="is_notrebate" value="<?php // echo isset($is)?$is:0 ?>"></a>是否显示没有分成的商家</div>
                    -->
                    <div class="buy_btn1"><a href="javascript:void(0)" id="select_input">查询</a></div>
                    <div class="buy_btn1"><a href="<?php echo site_url('Corporate/report/subordinate')?>" id="reset">重置</a></div>
                </form>
                </div>
            </div>
            <br><br>
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con pingjia_01_height">
              <div class="dingdanguanli_01_top03">
                   <div class="kehuguanli_con01">
                    <table width="910" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
                    	<tr class="tr1 manage_b_tr1">
                        <th width="108px">用户ID</th>
                        <th width="295px">商家名称</th>
                        <th width="108px">关系</th>
                        <th width="130px">登录账号</th>
                        <th width="134px">分成总额</th>
                        <th width="130px">登录时间</th>
                        <th width="134px">注册时间</th>
                    </tr>
                    <?php $total_rebate = 0; if(isset($rebate)&&count($rebate)>0):?>
                    
                    <?php foreach($rebate as $key => $r): ?>
                    <?php $total_rebate += $r['rebate'];?>
                    <tr>    
                        <th width="108px"><?php echo $r['customer_id'] ?></th>
                        <th width="295px"><?php echo $r['corporation_name'] ?></th>
                        <th width="108px"><?php echo $r['relationship'] == 1 ? '下线' : '下下线' ;?></th>
                        <th width="130px"><?php echo $r['name'] ?></th>
                        <th width="134px"><?php echo $r['rebate'] ?></th>
                        <th width="130px"><?php echo explode(' ',$r['last_login_at'])[0] ?><br/><?php echo explode(' ',$r['last_login_at'])[1] ?></th>
                        <th width="134px"><?php echo explode(' ',$r['registry_at'])[0] ?><br/><?php echo explode(' ',$r['registry_at'])[1] ?></th>
                     </tr> 
                     <?php endforeach; ?>
                     <?php endif; ?>
                       
                    </table>
                </div>
                  
              </div>
              <div class="fu_1">
              
            <div class="showpage showpage_right ">
            <?php
                //分页
                echo $pagination 
             ?>
			</div>
                </div>
            <div class="fu_2" >
            	<div class="fu_ner">
                	<h5>可分成金额（总）：<samp><?php echo $row['total_rebate']; ?></samp></h5>
                </div>
            </div>
             </div>
       
            </div>
         </div>
 <script src="jquery-1.11.3.js"></script> 
<script type="text/javascript">
     $(function(){
    	 select();
     	 $(".dagou1").on("click",function(){
           var index = $(this).index();
           $(this).toggleClass("active1");
           if($(this).attr("class")=='dagou1')
           {               
        	    $("input[name=is_notrebate]").val(1);
           }else
           {
                $("input[name=is_notrebate]").val(0);
           }
         });
         
         $('#select').blur(function(){
        	 select();
         });
         
         // 按钮切换
         $(".need a").on("click", function() {
		   var index = $(this).index();
		   $(this).addClass("tab1").siblings().removeClass("tab1");
		 });

// 		 $("#reset").on("click",function(){
// 		   document.getElementById("subform").reset();
// 	     });

	     $("#select_input").on("click",function(){
		     
		     var select = $("#select").val();
		     var input = $("#search_input").val();
		     var start_time = $("input[name=start_time]").val();
		     var end_time = $("input[name=end_time]").val();
		     var is = $("input[name=is_notrebate]").val();
		     
	    	 if(select&&input!="")
		     {
	    		  $("#subform").submit();
		     }
	    	 else if(select&&input=="")
	    	 {	    		  
	    		  alert("请输入关键词");
			 }
	    	 else if(!select&&input!="")
	    	 {
	    		 alert("请选择查询类型");
			 }
	    	 else if(!select&&input=="")
			 {
	    		 $("#subform").submit();
		     }
		 });
    })
     
     function select(){
 	    if($('#select').val()==1||$('#select').val()=='')
 	 	    $('#search_input').attr('name','customer_id');
  	    if($('#select').val()==2)
	 	    $('#search_input').attr('name','corporation_name');
	    if($('#select').val()==3)
 	        $('#search_input').attr('name','name');
     }

     
   </script> 