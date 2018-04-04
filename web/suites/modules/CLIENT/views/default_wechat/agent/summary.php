<link rel="stylesheet" type="text/css" href="agent/fonts/fonts2/fonts.css">
<link rel="stylesheet" type="text/css" href="agent/fonts/fonts2/iconfont.css">
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>

<?php 
$mycorproation = 0;
$qualified = 0;
$mycorproation = count($mecorporate);
$rebate = 0;
$rebate_month=0;
$li = "";
foreach($mecorporate as $key => $m)
{
    if($m["status"]==1&&$m["approval_status"]==2)
    {
        $qualified++;
    }
}

foreach ($count_rebate as $key => $c)
{
    $rebate = $rebate + $c["rebate"];
}

if(count($list)>0)
{
    foreach ($list as $key => $l)
    {
         $li .= "<li>".
            "<p><span>". $l["corporation_name"] ."</span><span class='income_explain_list_num1'>+". $l["rebate"] ."</span></p>".
            "<p><span>". explode(" ",$l["creat"])[0]."</span>&nbsp;&nbsp;<span>". explode(" ",$l["creat"])[1] ."</span></p>".
         "</li>";
    }
}
if(count($count_rebate_month)>0)
{
    foreach ($count_rebate_month as $key => $l)
    {
        $rebate_month = $rebate_month + $l["rebate"];
    }
}

?>

	 <div class="container" style="background-color:#e8e8e8">
        <div class="header" name="top">
            <p class="title">51易货合伙人</p>
            <a href="<?php echo site_url('Agent/home/loginout')?>" target="_self" class="icon-exit-door"></a> 
        </div><!--header end-->
        <div class="income_nav">
        	<ul>
        	    <li class="income_nav_active zongji">总计</li><span>｜</span>
        	    <li class="shouru">收入明细</li>
        	</ul>
        </div>
        <div class="income_tab">
            <ul class="income_tab_ul">
                <li class="income_total">
                <form action="<?php echo site_url("Agent/home/agent_rebate") ?>" method="get" id="form_sub">
					<p>
						<span class="income_total_time">
						    <!-- <input type="date" id="input" name="start" value="<?php echo isset($start)?$start:"开始时间"?>" id="start" placeholder="开始时间"> -->
							<input onClick="WdatePicker()" id="start" name="start" value="<?php echo isset($start)?$start:"开始时间" ?>" placeholder="开始时间" readonly>
						</span>
						<span class="income_total_text">到</span>
						<span class="income_total_time">
							<!-- <input type="date" name="end" id="input02" value="<?php //echo isset($end)?$end:"结束时间"?>" id="end" placeholder="结束时间"> -->
							<input onClick="WdatePicker()" id="end" name="end" value="<?php echo isset($end)?$end:"结束时间" ?>" placeholder="结束时间" readonly>
						</span>
						<span class="income_total_search"><a onclick="form_submit();">搜索</a></span>
					</p>
					<div>
                      <ul class="income_total_list1">
                        <li>推荐商家</li><span>｜</span>
                        <li>合格商家</li><span>｜</span>
                        <li>商家帮我赚</li>
                      </ul>
                      <ul class="income_total_list2">
                          <li><?php echo $mycorproation; ?></li>
                          <li><?php echo $qualified; ?></li>
                          <li class="income_total_list2_num3"><?php echo number_format($rebate,2); ?></li>
                      </ul>
                    </div>
                    <span style="color:red;font-size:16px" id="dayerr"></span>
                </form>
                </li>
                <li class="income_explain">
                    <div class="income_explain_nav">
                        <a class="icon-shangyige " style="color: #878787" onclick="change_month('left')" id="left"></a> 
                        <span ><span id="year"><?php echo date('Y') ?></span>年<span id="month"><?php echo date('m')?></span>月</span>
                        <a class="icon-guanbi01 " onclick="" id="right"></a> 
                        
                    </div>
                    <?php if($rebate_month>0):?>
                    <div class="income_explain_money">
                        商家帮我赚：<span id="cor_rebated"><?php echo number_format($rebate_month,2); ?></span>
                    </div>
                    <?php else:?>
                    <div class="income_explain_main">
                        <!-- 暂没有商家帮我赚到钱的时候显示 -->
                        <div class="income_explain_nomoney" >
                              <img src="<?php echo THEMEURL.'images/income_explain_money.png'?>" height="125" width="125">
                            <span>暂没有商家帮我赚到钱</span>
                    </div>
                    <?php endif;?>
                        <div class="income_explain_list">
                            <ul id="rebate_list">
                           <?php echo $li; ?>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <ul id="load" style="display:none"><h5 class="jiazai" style="display:block;text-align:center;line-height:20px;color:#c3c3c3">加载中...</h5> </ul>
        <input id="page" value="2" type="hidden">
        <script type="text/javascript">
         $(function(){
            $(".income_nav ul li").on("click",function(){
               var index = $(this).index();
               $(this).addClass("income_nav_active").siblings().removeClass("income_nav_active");
               // $(".income_tab_ul li").eq(index).show().siblings().hide();
            })
          
         
         })
         $(function(){
            $(".zongji").on("click",function(){
                $(".income_explain").addClass("active3");
                $(".income_total").addClass("active2"); 
                $(".income_total").removeClass("active3");            
            })
         })

        $(function(){
            $(".shouru").on("click",function(){
                $(".income_explain").addClass("active2");
                $(".income_total").addClass("active3")
                 // $(".income_total").removeClass("active3"); 
                $(".income_explain").removeClass("active3");            
            })
         })

        </script>	



    </div><!--container end-->

</body>
</html>

<script>

$(function () {
	 
    $("input[name=start]").click(function(){
 		$("#dayerr").hide();
 	});
 	$("input[name=end]").click(function(){
 		$("#dayerr").hide();
 	});
});

$(window).scroll(function () {
	
    if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
        ajax_page();
    }
});

        
function form_submit(){
	 var start = $("input[name=start]").val();
	 var end = $("input[name=end]").val();
	 var sub = true;
	 if(start==""){
		 sub = false;
		 alert("开始时间不能为空");
     }else if(end==""){
		 sub = false;
		 alert("结束时间不能为空");
     }else if(start>end){
		 sub = false;
		 alert("开始日期不能大于结束日期");
     }else{
    	     sub = true;
     }
     if(sub){
    	 $("#form_sub").submit();
     } 
}

function ajax_page(){
	
    var page = $("#page").val();
    var start_time = $("#year").html()+"-"+$("#month").html()+"-01 00:00:00";
    var end_time = $("#year").html()+"-"+$("#month").html()+"-31 23:59:59";
    
	$.ajax({
	    url:"<?php echo site_url("Agent/home/ajax_page") ?>",
	    type:"get",
	    data:{page:page,start_time:start_time,end_time:end_time},
	    beforeSubmit:function(){
	       $("#load").show(); 
		},
		success:function(data){
		    var data = jQuery.parseJSON(data);
		    var html = "";
		    
		    for(var i = 0;i<data["list"].length;i++){
		        html = html +"<li>"+
	            "<p><span>"+ data["list"][i]["corporation_name"] +"</span><span class='income_explain_list_num1'>+"+ data["list"][i]["rebate"] +"</span></p>"+
	            "<p><span>"+ data["list"][i]["creat"].split(" ")[0] +"</span>&nbsp;&nbsp;<span>"+ data["list"][i]["creat"].split(" ")[1] +"</span></p>"+
	         "</li>";
			}
			
			$("#rebate_list").append(html);
			$("#page").val(data["page"]);
			$("#load").hide(); 
		},
		error:function(){
		    
		},
    });
}

function change_month(obj){

    var date = new Date();
	var year = $("#year").html();
	var month = $("#month").html();
		
    if(obj=="left")
    {
    	if(year>=date.getFullYear()&&month>(date.getMonth()+1))
    	{
    		$("#right").attr("onclick","");
    		$("#right").attr("style","");
    	}
    	else
        {
    		$("#right").attr("onclick","change_month('right')");
    		$("#right").attr("style","color:#878787");
        }
        if(month==1)
        {
        	year = year - 1;
        	month = 12;
        	$("#year").html(year)
        	$("#month").html(month);
        }
        else
        {
        	if(month<11)
            {
                month = "0" + (month*1 - 1);
            }
            else
            {
                month--;
            }
            $("#month").html(month);
        }
    }
    if(obj=="right")
    {
    	if(year>=date.getFullYear()&&(month*1+1)>=(date.getMonth()+1))
    	{
    		$("#right").attr("onclick","");
    		$("#right").attr("style","");
    	}
    	else
        {
    		$("#right").attr("onclick","change_month('right')");
    		$("#right").attr("style","color:#878787");
        }
    	if(month==12){
    		year = year*1 + 1;
        	month = '01';
        	$("#year").html(year)
        	$("#month").html(month);
        }
    	else
        {   
            if(month<9)
            {
                month = "0" + (month*1 + 1);
            }
            else
            {
                month++;
            }
            $("#month").html(month);
        }
    }
    
    check_month(year,month);
}

function check_month(year,month){
    var start_time = year+"-"+month+"-01 00:00:00";
    var end_time = year+"-"+month+"-31 23:59:59";
    $("#page").val(1);
    var page = $("#page").val();
	$.ajax({
		url:"<?php echo site_url("Agent/home/ajax_page") ?>",
		type:"get",
		data:{start_time:start_time,end_time:end_time,page:page},
		beforeSubmit:function(){
			$("#load").show(); 
		},
		success:function(data){
			var data = jQuery.parseJSON(data);
		    var html = "";
		    var rebate_total = 0;
		    
		    rebate_total = data["rebate_month"];
		    if(data["list"].length>0)
		    {
    		    for(var i = 0;i<data["list"].length;i++){
    			   
    		        html = html +"<li>"+
    	            "<p><span>"+ data["list"][i]["corporation_name"] +"</span><span class='income_explain_list_num1'>+"+ data["list"][i]["rebate"] +"</span></p>"+
    	            "<p><span>"+ data["list"][i]["creat"].split(" ")[0] +"</span>&nbsp;&nbsp;<span>"+ data["list"][i]["creat"].split(" ")[1] +"</span></p>"+
    	         "</li>";
    			}
    		    $("#cor_rebated").html(rebate_total);
    		    $("#cor_rebated").parent().show();
    		    $(".income_explain_nomoney").hide();
		    }
		    else
		    {
// 			    html = html +"<div class='income_explain_main'><div class='income_explain_nomoney' >"+
//                     "<img src='../../../images/income_explain_money.png' height='125' width='125'>"+
//                     "<span>暂没有商家帮我赚到钱</span></div>";
			    $("#cor_rebated").parent().hide();
    		    $(".income_explain_nomoney").show();
			}
			$("#rebate_list").html(html);			
			$("#page").val(data["page"]);
			$("#load").hide(); 
		},
		error:function(){
		    
		},

	});
}

function getXlsFromTbl(inTblId, inWindow) {      
	try {  
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
	    var curTbl = tblDocument.getElementById(inTbl);      
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
	var fileName = "leo_zhang" + "_" + curYear + curMonth + curDate + "_"+ curHour + curMinute + curSecond + ".csv";     // alert(fileName);      
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
	xlsWin.document.execCommand('Saveas', true, inName);      
	xlsWin.close();  
} 
</script>