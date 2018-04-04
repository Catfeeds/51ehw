<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
  <!--分成汇总查询开始-->
  
  <div class="content">
  <form action="<?php echo site_url("Agent/home/rebate_detail") ?>" method="get" id="check_form">
    <div class="content_tou">
    
      <h5>分成明细查询</h5>
      <ul class="content_tou_n">
      
        <li>
          <div class="form_rzhu zhu12"> <span class="tiao1">地区:</span>
          <input type="text" class="biaod" id="" value="<?php echo $app["app_name"] ?>" readonly>

          </div>
          <div class="form_rzhu zhu6"> <span class="tiao1">分成时间段:</span>
         <input placeholder="请输入日期" name="start_time" class="zijin1_1_con01_input01" value="<?php echo isset($start_time)?$start_time:"" ?>" onClick="WdatePicker()" readonly><span>一</span>
            
            <input placeholder="请输入日期" name="end_time" class="zijin1_1_con01_input01" value="<?php echo isset($end_time)?$end_time:"" ?>" onClick="WdatePicker()" readonly>
            <span style="color:red;" id="dayerr"></span>
          </div>
          
        </li>

          <li>
          <div class="form_rzhu zhu10"> <span class="tiao1">查询:</span>
          <select name="select" id="select" class="theme" onchange="change_name()">
               <option value="" >默认</option>
               <option value="1" <?php echo isset($select)&&$select==1?"selected":""?>>订单号</option>
               <option value="2" <?php echo isset($select)&&$select==2?"selected":""?>>商家名称</option>
          </select>
            <span> <input type="text" class="biaod" id="change" name="<?php if(isset($select)&&$select==1) echo "order_sn";else if(isset($select)&&$select==2) echo "corporation_name";?>" placeholder ="" value="<?php if(isset($select)&&$select==1) echo $order_sn;else if(isset($select)&&$select==2) echo $corporation_name;?>"></span>
            <span style="color:red;" id="error"></span>
          </div>
        </li>
      </ul>
      
      <div class="chaxun1"> <span class="tiao4"><a onclick="form_submit();">查询</a></span> </div>
    </div>

    
      <div class="content_bo2">
      <!--<h5>51易货网用户角色</h5> -->
       <div class="content_bon"> 
      <div class="form_rzhu zhu7"> <span class="tiao1">排序:</span>
            <select name="theme" id="desc" class="theme" onchange="desc_submit();">
              <option value="rebate_big" <?php echo isset($desc)&&$desc=="rebate_big"?"selected":"" ?>>分成金额(大-小)</option>
              <option value="rebate_small" <?php echo isset($desc)&&$desc=="rebate_small"?"selected":"" ?>>分成金额(小-大)</option>
              <option value="time_big" <?php echo isset($desc)&&$desc=="time_big"?"selected":"" ?>>分成时间(大-小)</option>
              <option value="time_small" <?php echo isset($desc)&&$desc=="time_small"?"selected":"" ?>>分成时间(小-大)</option>
            </select>
          </div>

          <small><input type="button" class="u-btn2" value="导出EXCL" onclick="javascript:getXlsFromTbl('table',null);"></small>
          </div>
          </div>
      </form>    
      <div class="haudong">     
    <table width="2000" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1">
        <tbody>
          <tr class="manage_b_table2">
            <th width="80">订单号</th>
            <th width="150px">商家名称</th>
            <th width="100px">时间</th>
            <th width="100px">分成类别</th>
            <th width="100px">成交金额</th>
            <th width="100px">可分成金额</th>
            <th width="100px">上线会员名称</th>
            <th width="100px">上线分成</th>
             <th width="100px">合伙人名称</th>
            <th width="100px">合伙人分成</th>
            <!-- <th width="100px">城市子公司名称</th>
            <th width="100px">城市子公司分成</th>
            <th width="100px">51易货分成</th>-->
          </tr>
          <?php 
          if(count($list)>0):
            foreach ($list as $l):
          ?>
          <tr class="manage_b_table3">
            <th width="80"><?php echo $l["order_sn"] ?></th>
            <th width="150px"><?php echo $l["corporation_name"] ?></th>
            <th width="100px"><?php echo $l["creat"]?></th>
            <th width="100px"><?php if($l["rebate_type"]==2) echo "销售分成"; elseif($l["rebate_type"]==1) echo "会员分成" ?></th>
            <th width="100px"><?php echo $l["total_price"] ?></th>
            <th width="100px"><?php echo $l["total"] ?></th>
            <th width="100px"><?php echo $l["parent"] ?></th>
            <th width="100px"><?php echo $l["rebate_1"] ?></th>
             <th width="100px"><?php echo $l["nick_name"] ?></th>
            <th width="100px"><?php echo $l["rebate"] ?></th>
            <!-- <th width="100px">西安分公司</th>
            <th width="100px">675</th>
            <th width="100px">675</th>-->
          </tr>
          <?php 
            endforeach;
          endif;
          ?>
          <!--
          <tr class="manage_b_table3">
            <th width="80">2365</th>
            <th width="150px">冠杰文化</th>
            <th width="100px">2016-04-20 12:00:00</th>
            <th width="100px">销售手续费</th>
            <th width="100px">50,000.00</th>
            <th width="100px">2,500.00</th>
            <th width="100px">凡拓文化</th>
            <th width="100px">250</th>
             <th width="100px">启源文化</th>
            <th width="100px">900</th>
            <th width="100px">西安分公司</th>
            <th width="100px">675</th>
            <th width="100px">675</th>
          </tr>-->
           
        </tbody>
      </table>
      </div>
    </div>

  
  <!--分成汇总查询结束-->

<!--全局结束-->
</body>
</html>

<script>

  $(document).ready(function(){
     change_name();
     $("input[name=start_time]").click(function(){
 		$("#dayerr").hide();
 	});
 	$("input[name=end_time]").click(function(){
 		$("#dayerr").hide();
 	});
 	$("#change").click(function(){
 		$("#error").hide();
 	});
  })
 
 /*$("#select").blur(function(){
	    change_name();
 });*/
 
/*!function(){
	laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
	laydate({elem: '#demo'});//绑定元素
}();*/



function desc_submit(){
	 var val = $("#desc").val();
	 var start_time = $("input[name=start_time]").val();
	 var end_time = $("input[name=end_time]").val();
	 
     document.location = "<?php echo site_url("Agent/home/rebate_detail"); ?>?start_time="+start_time+"&end_time="+end_time+"&theme="+val;
}

function change_name(){
	var select = $("#select").val();
	
	if(select == 1){		
	    $("#change").attr("name","order_sn");
	}
	
	if(select == 2){		
		$("#change").attr("name","corporation_name");
		
	}
}
function form_submit(){
	var select = $("#select").val();		
	var key = $("#change").val();
	var start = $("input[name=start_time]").val();
	var end = $("input[name=end_time]").val();
    var sub = true;
    
    if(select!=''&&key==''){
 	   sub=false;
  	   $("#error").html("请填写关键字");
       $("#error").show();
    }else if(start==""){
		 sub = false;
		 $("#dayerr").html("开始日期不能为空");
	     $("#dayerr").show();
     }else if(end==""){
		 sub = false;
		 $("#dayerr").html("结束日期不能为空");
	     $("#dayerr").show();
     }else if(start>end){
		 sub = false;
		 $("#dayerr").html("开始日期不能大于结束日期");
	     $("#dayerr").show();
     }else{
 	     sub = true;
     }
     if(sub){
	    $("#check_form").submit();
     }
}

function getXlsFromTbl(inTblId, inWindow) {    
	var start = $("input[name=start_time]").val();
	var end = $("input[name=end_time]").val();  
	window.location.href="<?php echo site_url("Agent/home/excel")?>/"+start+"/"+end+"/?type=1";
		    /*$.ajax({
		        url:"<?php echo site_url("Agent/home/excel") ?>",
		        type:"get",
		        success:function(){

			    }
			});*/

	}
  </script>
