<style type="text/css">
	.container {background: #fff!important;}
	._citys { width: 100%; display: inline-block;background: #fff;position: relative; }
._citys span { display:none; color: #56b4f8; height: 15px; width: 15px; line-height: 15px; text-align: center; border-radius: 3px; position: absolute; right: 10px; top: 10px; border: 1px solid #56b4f8; cursor: pointer; }
._citys0 { width: 100%; height: 34px; display: inline-block; border-bottom: 2px solid #56b4f8; padding: 0; margin: 0; }
._citys0 li { display: inline-block; line-height: 34px; font-size: 15px; color: #888; width: 80px; text-align: center; cursor: pointer; }
.citySel { background-color: #56b4f8; color: #fff !important; }
._citys1 { width: 100%; display: inline-block; padding: 10px 0; }
._citys1 a { width: 30%; height: 35px; display: inline-block; background-color: #f5f5f5; color: #666; margin-left: 2.5%; margin-top: 3px; line-height: 35px; text-align: center; cursor: pointer; font-size: 13px; overflow: hidden; }
._citys1 a:hover { color: #fff; background-color: #56b4f8; }
.AreaS { background-color: #56b4f8 !important; color: #fff !important; }
#city{ width:70%;border:1px solid #fff; background:none; outline:none;float: right;text-align: right;padding-top: 0px; }
#PoPy{ width:100% !important; left:0px !important;}

.webuploader-pick { 
    /* top: -35px; 
    left: 200px;*/
    background: #62BB10;
    width: 140px;
 } 

.webuploader-container { 
    position: static; 
}
.parentFileBox>.fileBoxUl>li>.diyCancel,
.parentFileBox>.diyButton{text-align: left; margin-left: 35px; } 
 #fileBox_WU_FILE_0{height: 150px;width:170px!important;float:left!important;margin-right: 6px;margin-left: 35px;padding:0px}
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
.needs-offer-button-text {float: right;}
	.parentFileBox {display: block;margin-bottom: 0px;text-align: center;margin:44px auto;}
	.parentFileBox li {display: inline-block;float: left;width: 190px;border-bottom: none!important;}
	.diyButton {display: inline-block;}
	.fileBoxUl{width: 190px;margin: 0px auto;}
	.fujian{ position: absolute; left: 10px;}
	.needs-offer-button-text{ position: absolute; right: 10px;}
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
  .h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
  .h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
  .forget-password {width: 265px;margin: 30px auto;text-align: center;}
  .password-text span {line-height: 30px;font-size: 16px;color: #333;}
  .password-text textarea { border: 1px solid #ddd; height: 60px; width: 90%;resize: none;outline: none;padding: 5px;}
  .password-button {height: 40px;width: 100%;background-color: #FECF0A;text-align: center;margin-top: 17px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}
  .no-mima {float: right;margin-top: 25px;color: #000000;}
  #textbeen {font-size:18px}
    @media screen and (max-width:320px) {
      .h5-forget {width: 270px!important;margin-left: -135px!important;}
      .password-button {width: 90%!important;}
      .no-mima {margin-right: 16px;}
      .publish-needs-button02 {width: 63%!important;}
}
 .needs_fenlei {float: right;color: #666666;font-size: 12px;}
 select {appearance:none;-moz-appearance:none;-webkit-appearance:none;border: none;outline: none;background: #fff;}
 /*.icon-right {margin-top: 0!important;}*/
</style>
<!-- <div class="commodity_h50"></div> -->
 <div class="offer_details">
 	<?php //加载选择分类页面
        $info['classify']  = $classify;
        $this->load->view('client/select', $info);
	?>
	<!-- 内容 -->
	<form id="form">
	<div class="publish-needs-main">
		<ul class="offer-details-main-ul02 border-none">
		    <li><span>需求标题：</span><input type="text" value="<?php echo $reqlist['title'];  ?>" id="title" class="publish-needs-input-title"></li>
		    <li><span>数量：<span style="opacity: 0;">测测</span></span><input type="text" id="p_count" value="<?php echo $reqlist['p_count'];  ?>" class="publish-needs-input"></li>
		    <li><a onclick="select()" href="javascript:void(0);"><span>分类：<span style="opacity: 0;">测测</span></span><span class="needs_fenlei"><?php echo $reqlist['cate']; ?><i class="icon-right"></i></span></a></li>
		    <li hidden><input id="fenleis" value="<?php echo $reqlist['cate_id'];?>" ></li>
		    <li><span>期望单价：</span><input type="text" id="m_price" value="<?php echo $reqlist['m_price'];  ?>" class="publish-needs-input1" placeholder="价格"><span style="color: #666;">货豆/</span>
		    <form class="publish-needs-form">
            <select id="unit"  name="cars" style="color: #666;font-size: 13px;height:20px;">
            <option>请选择单位</option>
            <?php $select_array = array("千克","斤","件","吨","包","份","箱","栋","套");           
            	foreach ($select_array as $key => $value) {
            		if($value == $reqlist['unit']){
            			echo '<option value="'.$value.'"  selected>'.$value.'</option>';	 
            	}else{
						echo '<option value="'.$value.'" >'.$value.'</option>';	 	
				}		
            }?>
            </select>
            <form></li>
		   <!--   <li><span>交货期(天)：<span style="opacity: 0;">测</span></span><input type="text"  value="" class="publish-needs-input"></li>-->
		    
		     <li><span>报价截止时间：</span>
		                <span class="income_total_time">
		                    <span class="icon-right fn-right" style="padding-top: 2px;color: #666;"></span>
							<input onclick="WdatePicker()" id="effectdate" name="start" value="<?php echo $reqlist['effectdate'];?>" placeholder="请选择时间" readonly="" class="publish-needs-time">

						</span>
			</li>
		     <li><span>期望收货日期：
		                </span><span class="income_total_time">
		                    <span class="icon-right fn-right" style="padding-top: 2px;color: #666;"></span>		
							<input onclick="WdatePicker()" id="receiptdate" name="end" value="<?php echo $reqlist['receiptdate'];?>" placeholder="请选择时间" readonly="" class="publish-needs-time">
						</span>
			</li>
		     <li class="needs-offer-qita"><span>报价须含:</span>
				<a href="javascript:changeval(1);"><i id="freights" class="<?php if($reqlist['freight'] ==0 ){?>icon-round<?php }else{?> icon-roundcheck needs-offer-qita-active<?php }?>"></i>含运费</a>
				<a href="javascript:changeval(2);"><i id="taxs" class="<?php if($reqlist['needtax'] ==0 ){?>icon-round<?php }else{?> icon-roundcheck needs-offer-qita-active<?php }?>"></i>含税</a>
				<input type="hidden" value="<?php if($reqlist['freight'] ==0 ){?>0<?php }else{?> 1<?php }?>" id="freight">
				<input type="hidden" value="<?php if($reqlist['needtax'] ==0 ){?>0<?php }else{?> 1<?php }?>" id="tax">
		    </li>
		    <li><span>收货地址:</span>
		              <span class="icon-right fn-right" style="padding-top: 2px;color: #666;"></span>
		              <input type="button" id="city" value="<?php echo $address?>">
		               <input type="button" id="province_id" value="<?php echo $reqlist['province_id']?>" hidden>
		                <input type="button" id="city_id" value="<?php echo $reqlist['city_id']?>" hidden>
		                 <input type="button" id="district_id" value="<?php echo $reqlist['district_id']?>" hidden>
		              		
		    </li>
		    <li><input type="text" value="<?php echo $reqlist['shippingaddress']?>" id="shippingaddress" class="publish-needs-address" placeholder="详细地址" style='width: 100%;'></li>
		    
		    
		    
		    
		    <li><span>产品图片:<span style="opacity: 0;">测试</span></span>
		         <span>
		           <span class="icon-right fn-right" style="padding-top: 2px;color: #666;"></span>
                   <input type="file" value="" id='file' name="file"  onchange="preImg(this.id,'imgPre');" style='display:none;'>
                   <!-- <span onclick="file.click();" class="publish-needs-button02">请添加图片</span> -->
                   <input type="button" onclick="file.click();"   style="width: 69%;" class="publish-needs-button02" value="选择上传图片">
                 </span>
            </li>
            <?php if($reqlist['img_path']){?>
                <li  class="ball-header-status-li"><img src="<?php echo base_url()."uploads/B/".$reqlist['img_path']?>"  alt="" class="ball-header-status" id="imgPre" width="175">
               <!--  <a onclick="unlickimg();"  href="javascript:void(0);" style=" color: #fd0332;text-decoration: underline;  display: block; margin-left: 41%;margin-top: 5px;">删除图片</a> -->
             <?php }else{?>
            <li hidden class="ball-header-status-li"><img src=""  alt="" class="ball-header-status" id="imgPre" width="175">
            <?php }?>
            </li>
            
		</ul>
	</div>

	<div class="maintenance-label-bt" style="margin-bottom: 20px;">
      <a href="javascript:sub();" class="maintenance-label-confirm custom_button">确定发布</a>
    </div>

	</form>
 	<!-- 弹窗 -->
    	<div class="maintenance-label-popup success" hidden>
      	<div class="color-bg"></div>
        	<div class="h5-forget" id="forgetsuccess" >
            <div class="h5-lose" id="success">
              <img src="images/51h5-lose.png" id="close_img" height="34" width="34">
            </div>
          <div class="forget-password">
            <div class="password-text">
             <span id="success-text">您的需求已提交成功，请等待审核</span>	
            </div>
            <a href="<?php echo site_url('member/requirement/addrequirements');?>" class = "password-button">去发布需求</a> <a href='<?php echo site_url('member/requirement/my_req');?>' class = "password-button">查看我的需求</a>
          </div>
        </div>
        </div>
 </div>	
 
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
<script type="text/javascript">
$("#city").click(function (e) {
	SelCity(this,e);
});
</script>

<script type="text/javascript">
$(".publish-needs-button02").on("click",function(){
$(".ball-header-status-li").css("display","block");
})

$(".needs-offer-qita a").on("click",function(){
  $(this).addClass("on").siblings().removeClass("on");
  $(this).find("i").toggleClass('icon-round');
  $(this).find("i").toggleClass('needs-offer-qita-active');
  })
  
 $(".needs-offer-button").on("click",function(){
$(".ball-header-status-li").css("display","block");
})

$(".needs-offer-qita a").on("click",function(){
  $(this).addClass("on").siblings().removeClass("on");
  $(this).find("i").toggleClass('icon-round');
  $(this).find("i").toggleClass('needs-offer-qita-active');
  })

$('#been').on('click',function(){
	$(".been").css("display","none");
})  
$('#success').on('click',function(){
	$(".success").css("display","none");
}) 
function  select(){
	$("#box").find("#gaine1").siblings().remove();
	$("#box").find("#gaine1").show();
	$("#box").show();
	$("#form").hide();
}
</script>
 <script type="text/javascript">
function sub(){
	var title = document.getElementById("title").value;
	var cateid = document.getElementById("fenleis").value;
	var p_count = document.getElementById("p_count").value;
	var m_price = document.getElementById("m_price").value;
	var unit = document.getElementById("unit").value;
	var receiptdate = document.getElementById("receiptdate").value;
	var effectdate = document.getElementById("effectdate").value;
	var province_id;
	var city_id;
	var district_id;
	if($('#province_id').val() !=null && $('#province_id').val() != '' ){
		province_id = $('#province_id').val();
		}else{
			if(document.getElementById("hcity") !=undefined ){
				province_id = $("#hcity").attr('data-id');
				}
			}
	if($('#city_id').val() !=null  && $('#city_id').val() != ''){
		city_id = $('#province_id').val();
		}else{
			if(document.getElementById("hproper") !=undefined){
				city_id = $("#hproper").attr('data-id');
				}
			}
	if($('#district_id').val() !=null && $('#district_id').val() != ''){
		district_id = $('#province_id').val();
		}else{
			if(document.getElementById("harea") !=undefined){
				district_id = $("#harea").attr('data-id');
				}
			}
	
	var freight = document.getElementById("freight").value;
	var tax = document.getElementById("tax").value;
	var shippingaddress = document.getElementById("shippingaddress").value;
	
	var state = true; 
	if(freight ==1){
		if(tax ==1){
			//含税费和运费
			tax_freight = 3;
			}else{
				//含运费不含税费
				tax_freight = 1;
				}
		}else{
			if(tax ==1){
				//含税费和不含运费
				tax_freight = 2;
				}else{
					//不含运费不含税费
					tax_freight = 0;
					}
			}


	if(!title ){
	    $(".black_feds").text("请填写标题！").show();
		setTimeout("prompt();", 2000);
     	return;
         }
	if(!cateid){
		 $(".black_feds").text("请至少选择一个分类！").show();
			setTimeout("prompt();", 2000);
	     	return;
		}
	
	if(isNaN(p_count) || p_count<=0){
		 $(".black_feds").text("请填写正确的数量！").show();
			setTimeout("prompt();", 2000);
	     	return;
		}
	if(!m_price){
    	$(".black_feds").text("请填写单价！").show();
		setTimeout("prompt();", 2000);
     	return;
        }
	if(!unit){
    	$(".black_feds").text("请选择单位！").show();
		setTimeout("prompt();", 2000);
     	return;
        }

    if(effectdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
    	$(".black_feds").text("请选择截止日期！").show();
		setTimeout("prompt();", 2000);
     	return;
        }else{
        	if(Date.parse( effectdate )<=Date.parse(new Date("<?php echo date('Y-m-d')?>"))){
        		$(".black_feds").text("报价截止时间最少1天").show();
        		setTimeout("prompt();", 2000);
             	return;
            }
       }
    if(receiptdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
    	$(".black_feds").text("请选择收货日期！").show();
		setTimeout("prompt();", 2000);
     	return;
    }else{
    	if(Date.parse( receiptdate )<=Date.parse( effectdate )){
    		$(".black_feds").text("收货日期不能小于截止时间！").show();
    		setTimeout("prompt();", 2000);
         	return;
        }
    }
    if(isNaN(m_price) || m_price<=0){
    	$(".black_feds").text('请填写期望价格').show();
		setTimeout("prompt();", 2000);
		return;
        }
    //district_id不作判断 有可能没区 如海南-昌江
    if(province_id && city_id ){}else{
    	$(".black_feds").text('请选择省市区').show();
		setTimeout("prompt();", 2000);
		return;
        }
    if(!shippingaddress){
    	$(".black_feds").text('请填写正确的地址').show();
		setTimeout("prompt();", 2000);
		return;
        }


    
	$.ajaxFileUpload
    (
        {
        	url:'<?php echo site_url('member/requirement/images_upload')?>', //用于文件上传的服务器端请求地址 等待后台处理
            type: 'post',
            secureuri: false, //一般设置为false
            fileElementId: 'file', //文件上传空间的id属性  <input type="file" id="file" name="file" />
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
            	var img_path =data.img_path;
			<?php //if(!$reqlist['img_path']){ ?>
// 			    if(img_path == '' || img_path == undefined){
// 			    	$(".black_feds").text("请上传产品图片!").show();
//     				setTimeout("prompt();", 2000);
//     	    		return;
// 				    }
			<?php // }?>
			
                $.ajax({
                	url:'<?php echo site_url("member/requirement/updaterequirement") ?>',
        		    dataType:'json',
        		    async: false,
        		    type:'get',
        		    data:{ id:<?php echo $reqlist['id']?>,title:title,cateid:cateid,freight:freight,tax:tax,
            		    p_count:p_count,m_price:m_price,unit:unit,receiptdate:receiptdate,effectdate:effectdate,
        		    	province_id:province_id,city_id:city_id,district_id:district_id,shippingaddress:shippingaddress,
        		    	img_path:img_path      
        		    },
        		    success:function(data){
        		    		 if(data['Result']){
        		    			 $("#forgetsuccess").css("height","190");
        		    			 $(".success").css("display","block");
        				    	}else{
       				    		    $(".black_feds").text("发布失败，请重试!").show();
        							setTimeout("prompt();", 2000);
        				    		return;
        					    }
        			    },
        			error:function(){
        				$(".black_feds").text("网络错误，请重试!").show();
						setTimeout("prompt();", 2000);
			    		return;
        				}   
                    });
	                
            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
//            	 alert('上传图片失败');
            	var img_path= null;
                $.ajax({
                	url:'<?php echo site_url("member/requirement/updaterequirement") ?>',
        		    dataType:'json',
        		    type:'get',
        		    data:{ id:<?php echo $reqlist['id']?>,title:title,cateid:cateid,freight:freight,tax:tax,
            		    p_count:p_count,m_price:m_price,unit:unit,receiptdate:receiptdate,effectdate:effectdate,
        		    	province_id:province_id,city_id:city_id,district_id:district_id,shippingaddress:shippingaddress,
        		    	img_path:img_path      
        		    },
        		    success:function(data){
        		    		 if(data['Result']){
        		    			 $("#forgetsuccess").css("height","190");
        		    			 $(".success").css("display","block");
        				    	}else{
       				    		    $(".black_feds").text("发布失败，请重试!").show();
        							setTimeout("prompt();", 2000);
        				    		return;
        					    }
        			    },
        			error:function(){
        				$(".black_feds").text("网络错误，请重试!").show();
						setTimeout("prompt();", 2000);
			    		return;
        				}   
                    });
            }
        }
    )
	
}  

function unlickimg(){
	$.ajax({
		url:'<?php echo site_url("member/requirement/unlickimg") ?>',
		 dataType:'json',
		 async: false,
		 type:'post',
		 data:{id:<?php echo $reqlist['id']?>,file:'<?php echo  $reqlist['img_path']; ?>'},
		 success:function(data){
			 if(data['Result']){
				 if(data['status']){
						$(".black_feds").text("删除图片成功！").show();
						setTimeout("prompt();", 2000);
					 	setTimeout(function(){
							 window.location.reload();
							}, 1000);
					 }else{
						 console.log("该图片不存在");
						 }
				 }
			 },
		 error:function(){
			 console.log("删除旧图片失败");
			 }
		});
}
function changeval(v){
	if(v == 1){
		var freight = document.getElementById("freight");
		if(freight.value ==1){
			freight.value = 0;
			$('#freights').removeClass("icon-roundcheck");
			$('#freights').removeClass("needs-offer-qita-active");
			$('#freights').addClass("icon-round");
		}else{
			freight.value = 1;
			$('#freights').removeClass("icon-round");
			$('#freights').addClass("icon-roundcheck");
			$('#freights').addClass("needs-offer-qita-active");
			}
		}
	if(v == 2){
		var tax = document.getElementById("tax");
		if(tax.value ==1){
			tax.value = 0;
			$('#taxs').removeClass("icon-roundcheck");
			$('#taxs').removeClass("needs-offer-qita-active");
			$('#taxs').addClass("icon-round");
			}else{
				tax.value = 1;
				$('#taxs').removeClass("icon-round");
				$('#taxs').addClass("icon-roundcheck");
				$('#taxs').addClass("needs-offer-qita-active");
				}
	}
	
} 

function preImg(sourceId, targetId) {  
    if (typeof FileReader === 'undefined') {  
        alert('Your browser does not support FileReader...');  
        return;  
    }  
    var reader = new FileReader();  
  
    reader.onload = function(e) {  
        var img = document.getElementById(targetId);  
        img.src = this.result;
        
    }  
    reader.readAsDataURL(document.getElementById(sourceId).files[0]);  
}

</script>  




