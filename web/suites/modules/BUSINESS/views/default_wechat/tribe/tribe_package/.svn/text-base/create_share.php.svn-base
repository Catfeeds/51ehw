
<style type="text/css">
.tribe_my_share {margin: 0;padding-top: 0;}
.tribal_share_details_prize {position: relative;padding: 10px 0px;border-bottom: 1px solid #ddd;}
.tribe_choice_icon {position: absolute;right: -5px;top: 50%;width: 18px;height: 18px;border: 1px solid #999999;background-color: #fff;border-radius: 100%;margin-top: -9px;}
.icon-choose {color: #fed602;font-size: 18px;border: 0!important;}
.tribe_my_share_list {border-radius: 0;padding-bottom: 15px;}
.tribal_share_details_prize {margin-top: auto;}
.new_package_details {margin: 15px 0;}
textarea {-webkit-appearance: none;}
</style>
<!-- 创建分享 -->
<div class="tribe_my_share">
    <div class="tribe_my_share_list">
        <div class="tribal_share_details">
           <!-- 标题 -->
           <div class="new_package_share_title">
             <span>标题</span>
             <div><p><input type="text" id="title" maxlength="20" placeholder="请填写合适标题" value=""><em><i>0</i>/20</em></p></div>
           </div>
           <!-- 描述 -->
           <div class="tribal_share_details_title tribe_build_share_describe"><span>描述</span><p><textarea id="desc" maxlength="50" placeholder="请填写合适描述"></textarea><em><i>0</i>/50</em></p></div>
        </div>
        <!-- 样本图片 -->
        <div class="tribal_share_details_prize" style="margin-top: 15px;">
           <img src="images/Group_packgage.jpg" alt="">
        </div>
        <!-- 选择发送的产品 -->
        <div class="tribal_share_details_choice"><a href="javascript:showPackage();">可发放货包(<?php echo count($packages);?>)<span id="select">未选择<i class="icon-right"></i></span></a></div>
        
        <div class="package_list" style="display:none;">
            <!-- 奖品 -->
        	<?php foreach ($packages as $key =>$val){ ?>
        	 <!-- 新货包样式 -->
        	 <a href="javascript:void(0)" onclick="select_packeage(<?php echo $val['id'];?>);" >
               <div class="new_package_details">
                <div class="new_package_details_left">
                   <p><?php echo $val['name'];?></p>
                   <p><?php echo $val['desc'];?></p>
                   <p><?php echo  $val['grant_start_at'].' - '.$val['grant_end_at']?></p>
                </div>
                <div class="new_package_details_right"><span>免费</span></div>
               </div>
            </a>  
        	<?php } ?>
        </div>
        
        <div class="hid_box" style="display:none;">
        
         	<div class="new_package_details">
                <div class="new_package_details_left">
                   <p id="package_name"></p>
                   <p id="package_desc"></p>
                   <p id="times"></p>
                </div>
                <div class="new_package_details_right"><span>免费</span></div>
            </div>
        <!-- 发放数量 -->
        <div class="tribal_share_details_choice tribal_share_details_num"><a href="javascript:void(0);">可发数量 <div class="tribal_share_details_num_input"><input type="text"  id="numbers"  value="" placeholder="" disabled></div><i>个</i></a></div>
        <!-- 已领货包 (可修改) -->
        <div class="tribal_share_details_choice tribal_share_details_num"><a href="javascript:void(0);">发放数量 <div class="tribal_share_details_num_input"><input type="text"  id="sub_numbers"  value="" placeholder=""></div><i>个</i></a></div>
         <!-- 已选部落 -->
         <div class="tribe_share_invite" style="margin-top: 20px;">
            <span>已选部落</span>
            <p><input name="Fruit"  id="Fruit" disabled checked type="checkbox" value=""/><span id="tribe_name">山西会馆</span></p>
         </div>
       </div>  
    </div>   
    <div style="height:50px;"></div>
    <!-- 保存并分享 -->
    <a href="javascript:void(0);"  onclick="sub()"; class="new_package_details_save">保存</a>


</div>
<script>
function  showPackage(){
	 $(".package_list").show();
	 $(".hid_box").hide();
}

var max_num = 0;
var tribe_package_id = 0;
function select_packeage(id){
	$(".package_list").hide();
	$("#select").html('已选择<i class="icon-right"></i>');
	 $.post("<?php echo site_url("Activity/Tribe_package/ajax_get_Package");?>",{tribe_package_id:id},function(data){
			 max_num = parseInt(data.Package['surplus_num']);
			 tribe_package_id =parseInt(data.Package['id']);
			 var tribe_id = data.Package['tribe_id']
			 var tribe_name = data.Package['tribe_name']
			 var package_name =data.Package['name']
			 var package_desc =data.Package['desc']
			 $("#title").val(package_name);
			 $("#desc").val(package_desc);
			 $("#numbers").val(max_num);	
			 $("#Fruit").val(tribe_id);	
			 $("#package_name").html(package_name);	
			 $("#package_desc").html(package_desc);	
			 $(".new_package_share_title div p em i").text(package_name.length);
			 $(".tribe_build_share_describe p em i").text(package_desc.length);
			 
			 $("#tribe_name").html(tribe_name);	
			 $("#times").html(data.Package['grant_start_at']+' - '+data.Package['grant_end_at']);	
			 $(".hid_box").show();
		 },"json");
}

function sub(){
	var  package_id = tribe_package_id;
	var title = $("#title").val();
	var desc = $("#desc").val();
	var numbers =  parseInt($("#sub_numbers").val());

	var parten = /^\s*$/ ; 
	
	if(!title || title.length == 0 || title == '' || parten.test(title)){
		$(".black_feds").text('标题不能为空！').show();
		setTimeout("prompt();", 2000);
		return;
		}
	if(!desc || desc.length == 0 || desc == '' || parten.test(desc)){
		$(".black_feds").text('内容不能为空！').show();
		setTimeout("prompt();", 2000);
		return;
		}
	if(!numbers){
		$(".black_feds").text('发放货包数量不能为空！').show();
		setTimeout("prompt();", 2000);
		return;
		}
	
	if(numbers > max_num){
		$(".black_feds").text("发放货包数量不能大于"+max_num+'个').show();
		setTimeout("prompt();", 2000);
		return;
		}
	
	if(!package_id){
		$(".black_feds").text("请选择货包！").show();
		setTimeout("prompt();", 2000);
		return;
		}
	$.post("<?php echo site_url("Activity/Tribe_package/ajax_create_share_package");?>",{"tribe_package_id":package_id,number:numbers,title:title,desc:desc},function(data){
		if(data.status == 3){
			$(".black_feds").text('保存成功！').show();
			setTimeout("prompt();", 2000);
			window.location.href="<?php echo site_url("Activity/Tribe_package/share_list");?>";
			}else{
				$(".black_feds").text(data.Message).show();
				setTimeout("prompt();", 2000);
				return;
				}
		},'json');
	
}


</script>


<script language="javascript">

//检测输入内容字数的变化
$("#title").on("input propertychange",function() {
	var t = 0 + $(this).val().length;
	$(".new_package_share_title div p em i").text(t);
	if (t<0) {
		$(".new_package_share_title div p em i").text(0);
	};
})
$("#desc").on("input propertychange",function() {
	var t = 0 + $(this).val().length;
	$(".tribe_build_share_describe p em i").text(t);
	if (t<0) {
		$(".tribe_build_share_describe p em i").text(0);
	};
})






window.onload = function () {
// alert("1");
var u = navigator.userAgent;
if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
// alert("安卓手机");

} else if (u.indexOf('iPhone') > -1) {//苹果手机
// alert("苹果手机");
  $(".tribe_build_share_title p input").css("height","100%");
  $(".tribal_share_details_num_input").css("margin-top","-5px");
} else if (u.indexOf('Windows Phone') > -1) {//winphone手机
// alert("winphone手机");
}
}
</script>



