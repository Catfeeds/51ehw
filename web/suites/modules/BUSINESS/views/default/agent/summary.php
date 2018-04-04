<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
  <!--分成汇总查询开始-->
  <div class="content">
    <div class="content_tou">
      <h5>分成汇总查询</h5>
      <form action="<?php echo site_url("Agent/home/agent_rebate") ?>" method="get" id="check_form" >
      <ul class="content_tou_n">
        <li>
          <div class="form_rzhu zhu12"> <span class="tiao1">地区:</span>
            <input type="text" class="biaod" id="" value="<?php echo $app["app_name"] ?>" readonly>
          </div>
          <div class="form_rzhu zhu6"> <span class="tiao1">分成时间段:</span>
         <input placeholder="请输入日期" name="start_time" class="zijin1_1_con01_input01" value="<?php echo isset($start_time)?$start_time:"" ?>" onClick="WdatePicker()" readonly><span>一</span>
            <!--<input placeholder="请输入日期" class="zijin1_1_con01_input01" onClick="laydate({istime: true, format: 'YYYY-MM-DD '})">-->
            <input placeholder="请输入日期" name="end_time" class="zijin1_1_con01_input01" value="<?php echo isset($end_time)?$end_time:"" ?>" onClick="WdatePicker()" readonly>
            <span style="color:red;" id="dayerr"></span>
          </div>
        </li>
        <li>
          <div class="form_rzhu zhu7"> <span class="tiao1">分成类别:</span>
          <select name="type" id="type" class="theme">
           <option value="">全部</option>
          <option value="1" <?php echo isset($type)&&$type==1?"selected":"" ?>>会员会费</option>
          <option value="2" <?php echo isset($type)&&$type==2?"selected":"" ?>>销售手续费</option>
            </select>
          </div>
          <div class="form_rzhu zhu11"> 
          <!--<keyword>  <input type="checkbox" name="price_demand" value="0">按子公司汇总 </keyword>
          <keyword><input type="checkbox" name="price_demand" value="0">按合伙人汇总</keyword>
          <keyword><input type="checkbox" name="price_demand" value="0">按商家汇总</keyword>-->
         </div>
        </li>
      </ul>
      
      <div class="chaxun"> <span class="tiao3"><a onclick="form_submit();">查询</a></span> </div>
    </div>
    <div class="content_bo">
     <div class="content_bo1">
      <div class="content_bo2">
      <h5>51易货用户角色按子公司查询</h5> 
       <div class="content_bon"> 
       
      <div class="form_rzhu zhu7"> <span class="tiao1">排序:</span>
      
            <select name="theme" id="desc" class="theme" onchange="desc_submit();">
              <option value="rebate_big" <?php echo isset($desc)&&$desc=="rebate_big"?"selected":"" ?>>分成金额(大-小)</option>
              <option value="rebate_small" <?php echo isset($desc)&&$desc=="rebate_small"?"selected":"" ?>>分成金额(小-大)</option>
              <!-- <option value="time_big" <?php echo isset($desc)&&$desc=="time_big"?"selected":"" ?>>分成时间(大-小)</option>
              <option value="time_small" <?php echo isset($desc)&&$desc=="time_small"?"selected":"" ?>>分成时间(小-大)</option> -->
            </select>
     
          </div>
          <small><input id="" class="u-btn2" type="button" value="导出EXCL" onclick="javascript:getXlsFromTbl('table',null);"/></small>
       </form>  
          </div>
          </div>
          <div class="haudong">
    <table width="1200" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="table">
        <tbody>
          <tr class="manage_b_table2">
            <th width="100">商家名称</th>
            <th width="100px">分成类别</th>
            <th width="100px">提供分成总金额</th>
            <th width="100px">上线会员名称</th>
            <th width="100px">上线会员分成</th>
            <th width="100px">合伙人名称</th>
            <th width="100px">合伙人分成</th>
          </tr>
          <?php $sub_total = "";$sub_rebate_1="";$sub_rebate=""; if(count($list)>0):?>
          <?php foreach($list as $key => $v):?>
           <tr class="<?php echo $key%2==0?"manage_b_table3":"manage_b_table2" ?>">
            <th width="100px"><?php echo $v["corporation_name"] ?></th>
            <th width="100px"> <?php if($v["rebate_type"]==2) echo "销售分成"; elseif($v["rebate_type"]==1) echo "会员分成" ?></th>
            <th width="100px"><?php echo $v["total"]; ?></th>
            <th width="100px"><?php echo $v["parent"]; ?></th>
            <th width="100px"><?php echo $v["rebate_1"]; ?></th>
            <th width="100px"><?php echo $v["nick_name"]; ?></th>
            <th width="100px"><?php echo $v["rebate"]; ?></th>
          </tr>
          <?php $sub_total += $v["total"];$sub_rebate += $v["rebate"];$sub_rebate_1 += $v["rebate_1"];  ?>
          <?php endforeach;?>
          <?php endif;?>
          <!-- <tr class="manage_b_table2">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>
            <tr class="manage_b_table3">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>
           <tr class="manage_b_table2">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>
            <tr class="manage_b_table3">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>
           <tr class="manage_b_table2">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>
            <tr class="manage_b_table3">
            <th width="100px">西安子公司</th>
            <th width="100px"> 销售分成</th>
            <th width="100px">54,268,795,464.98</th>
            <th width="100px">8,971,924.14</th>
            <th width="100px">8,971,924.14</th>
          </tr>-->
          <tr class="manage_b_table2">
            <th width="100px">合计</th>
            <th width="100px"></th>
            <th width="100px"><?php echo $sub_total!=null?$sub_total:0?></th>
            <th width="100px"></th>            
            <th width="100px"><?php echo $sub_rebate_1!=null?$sub_rebate_1:0?></th>
            <th width="100px"></th>
            <th width="100px"><?php echo $sub_rebate!=null?$sub_rebate:0?></th>
          </tr>
        </tbody>
      </table>
      </div>
      
      
    </div>
    </div>
  </div>
  <!--分成汇总查询结束-->
</div>
<!--全局结束-->
</body>
</html>

<!--<script src="js/My97DatePicker/laydate.js"></script>
<script src="js/My97DatePicker/lyz.calendar.min.js"></script>
<script src="js/My97DatePicker/f.js"></script>-->
<!--<script src="js/My97DatePicker/WdatePicker.js"></script>-->
<script>

  /*$().tip("#header_tou_r1 li","#header_tou_r1 li dl");*/
  
 	/*(function(){
		  animenuNav    = document.querySelector('.animenu__nav '),
		  hasClass = function( elem, className ) {
			return new RegExp( ' ' + className + ' ' ).test( ' ' + elem.className + ' ' );
		  },
		  animenuToggleNav =  function (){        
		  }
	})()*/
	
/*!function(){
	laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
	laydate({elem: '#demo'});//绑定元素
}();*/


 $(function () {
	 
     $("input[name=start_time]").click(function(){
  		$("#dayerr").hide();
  	});
  	$("input[name=end_time]").click(function(){
  		$("#dayerr").hide();
  	});
    });

 function desc_submit(){
	 var val = $("#desc").val();
	 var start_time = $("input[name=start_time]").val();
	 var end_time = $("input[name=end_time]").val();
	 var type = $("#type").val();
     document.location = "<?php echo site_url("Agent/home/agent_rebate"); ?>?start_time="+start_time+"&end_time="+end_time+"&type="+type+"&theme="+val;
 }

 function form_submit(){
	 var start = $("input[name=start_time]").val();
	 var end = $("input[name=end_time]").val();
	 var sub = true;
	 
	 if(start==""){
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

 var idTmr = "";
 function killExcelProcess(appExcel_){
 appExcel_.Quit();
 appExcel_ = null;
 idTmr = window.setInterval("Cleanup();",1);
 } 

/* function exportToExcel(tableid,notitleandsearch){
	   try{
		   clipboardData.setData('Text','');
		   var appExcel = new ActiveXObject("Excel.Application");

		   killExcelProcess(appExcel);
		   appExcel.workbooks.add; 

		   if (notitleandsearch==null||notitleandsearch==false){
			   var elTable = document.getElementById('div_title');
			   var oRangeRef = document.body.createTextRange();
			   oRangeRef.moveToElementText(elTable);
			   oRangeRef.execCommand( "Copy" );
			   appExcel.ActiveSheet.Cells(1,7).select();
			   appExcel.ActiveSheet.Paste();

			   clipboardData.setData('Text','');
			   appExcel.ActiveSheet.Cells(2,1).select();
			   appExcel.ActiveSheet.Paste();
		   }

		   var elTable1 = document.getElementById(tableid);
		   var oRangeRef1 = document.body.createTextRange();
		   oRangeRef1.moveToElementText(elTable1);
		   oRangeRef1.execCommand( "Copy" );

		   appExcel.WorkSheets(1).Activate;
		   if (notitleandsearch==null||notitleandsearch==false){
			   appExcel.ActiveSheet.Cells(7,1).select();
		   }else{
			   appExcel.ActiveSheet.Cells(1,1).select();
		   }
		   appExcel.WorkSheets(1).Activate;
		   appExcel.ActiveSheet.Paste();
		   appExcel.Visible = true;
		   		   
		    
	   }catch(e){
		    alert("请确认是否安装excel");
		    return false;
	   } 
	   clipboardData.setData('text',''); 
 }*/

 function getXlsFromTbl(inTblId, inWindow) {
	var start = $("input[name=start_time]").val();
	var end = $("input[name=end_time]").val();
	window.location.href="<?php echo site_url("Agent/home/excel")?>/"+start+"/"+end;
	    /*$.ajax({
	        url:"<?php echo site_url("Agent/home/excel") ?>",
	        type:"get",
	        success:function(){

		    }
		});*/

}
		/*try { 
			 
		    var allStr = "";        
		    var curStr = "";  
		    //alert("getXlsFromTbl");  
		
	        if (inTblId != null && inTblId != "" && inTblId != "null")
	        {            
	    	   curStr = getTblData(inTblId, inWindow);  
	    	       
	        }  
	        if (curStr != null) 
	        {               
	    	   allStr += curStr; 
	    	}
	    	else 
	    	{  
	           alert("你要导出的表不存在！"); 
	           return;       
	         }  
		     var fileName = getExcelFileName();
	  	     doFileExport(fileName, allStr);     
	  	}  
		catch(e) {  
		       alert("导出发生异常:" + e.name + "->" + e.description + "!");  
		} 
	}  
	function getTblData(inTbl, inWindow) {
		    var rows = 0;  
		    //alert("getTblData is " + inWindow);      var tblDocument = document;  
		
		    if (!!inWindow && inWindow != "") 
		    {          
	    	    if (!document.all(inWindow)) 
	    	    {              
	    		    return null;          
	    		}          
	    		else 
	    		{  
	    	        tblDocument = eval(inWindow).document;          
	    	    }      
		    }  
		    var curTbl = document.getElementById(inTbl);      
		    var outStr = ""; 
		    
		    if (curTbl != null) 
		    {  
		        for (var j = 0; j < curTbl.rows.length; j++) 
		        {              
	               //alert("j is " + j);  
			       for (var i = 0; i < curTbl.rows[j].cells.length; i++) 
			       {                  //alert("i is " + i);  
				        if (i == 0 && rows > 0) 
				        {                      
			                outStr += " \t";                      
			                rows -= 1;                 
			            }  
				        outStr += curTbl.rows[j].cells[i].innerText + "\t";                  
				        if (curTbl.rows[j].cells[i].colSpan > 1) 
				        {  
				            for (var k = 0; k < curTbl.rows[j].cells[i].colSpan - 1; k++) 
				            {                          
		                         outStr += " \t";                      
		                    }                  
		                 }  
				         if (i == 0) 
				         {  
				              if (rows == 0 && curTbl.rows[j].cells[i].rowSpan > 1) 
				              {                          
		                          rows = curTbl.rows[j].cells[i].rowSpan - 1;                      
		                      }                  
		                 }              
		           }  
				   outStr += "\r\n";          
				}      
		     }      
		     else 
		     {  
				  outStr = null;  
				  alert(inTbl + "不存在!");      
			 }  
			return outStr;  
	}  
	function getExcelFileName() 
	{      
		var d = new Date();  

		var curYear = d.getYear();  
		var curMonth = "" + (d.getMonth() + 1);      
		var curDate = "" + d.getDate();      
		var curHour = "" + d.getHours();     
		var curMinute = "" + d.getMinutes();      
		var curSecond = "" + d.getSeconds();      
		if (curMonth.length == 1) 
		{  
			curMonth = "0" + curMonth;      
		}  
		if (curDate.length == 1) 
		{          
			curDate = "0" + curDate;      
		}  
		if (curHour.length == 1) 
		{  
			curHour = "0" + curHour;      
		}  
		if (curMinute.length == 1) 
		{  
			curMinute = "0" + curMinute;      
		}  
		if (curSecond.length == 1) 
		{  
			curSecond = "0" + curSecond;      
		}  
			//var fileName = "leo_zhang" + "_" + curYear + curMonth + curDate + "_"        //   + curHour + curMinute + curSecond + ".xlsx";  
		var fileName = "rebate" + "_" + curYear + curMonth + curDate + "_"+ curHour + curMinute + curSecond + ".xlsx";     // alert(fileName); 
		    
		return fileName;  
	}  
	function doFileExport(inName, inStr) 
	{      
		var xlsWin = null;  
		
		if (!!document.all("glbHideFrm")) 
		{          
			xlsWin = glbHideFrm;      
		}      
		else 
		{  
			var width = 6;          
			var height = 4;  
			var openPara = "left=" + (window.screen.width / 2 - width / 2) + ",top=" + (window.screen.height / 2 - height / 2)  
				           + ",scrollbars=no,width=" + width + ",height=" + height;  
				       
			xlsWin = window.open("", "_blank", openPara);    
			 
		}  
	    
		xlsWin.document.write(inStr);  
		xlsWin.document.close();  
		xlsWin.document.execCommand('SaveAs','',inName);    
		xlsWin.close();  
	} */
  </script>
