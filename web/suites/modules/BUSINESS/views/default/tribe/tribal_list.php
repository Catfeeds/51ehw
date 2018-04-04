<script type="text/javascript" src="js/chosen.jquery.js"></script>
<script type="text/javascript" src="js/fm.tagator.jquery.js"></script><!-- 标签插件 -->

<style>
    .stored_chong_xia_z {
        background: #fff;
        margin-right: 15px;
    }

    .stored_chong_xia_z h2 {
        height: 100%;
    }

    .stored_chong_top h5 {
        margin-top: 0;
        font-size: 12px;
        color: #999999;
        font-weight: normal
    }

    .stored_chong_yichu span {
        height: 20px;
        line-height: 20px;
		width:50%;
		padding-left:0
    }
	.stored_chong_shangchu{ padding:0 !important}
    .tagator_element{ width: auto !important; min-width: 125px;}
   .kuandu{max-width: 688px;}

   .biaoqianj{border: 1px solid #ddd;}
   .tagator_element.options-hidden .tagator_options {
    display: none;
}
.editors_ding_i{font-size: 12px; color: red; margin-top: 8px;}
</style>
<script>
//联动地区
function region_change(){
	var parent_id = $("#province_").val();
	$.post('<?php echo site_url("region_change/select_children");?>',{parent_id:parent_id},function(data){
		var city = '<?php echo $tribe['city']; ?>';
		var html = '';
		for(j = 0,len=data.length; j < len; j++) {
			html += '<option value="'+data[j]["region_id"]+'" '+(data[j]['region_name'] == city?"selected":null)+'>'+data[j]["region_name"]+'</option>';
		}
		$("#city_").html(html);
	},"json");
}
</script>

<div class="Box member_Box clearfix">
    <?php $this->load->view('tribe/left_nav'); ?>
    <!--编辑部落-->
    <div class="editors_zuida">
        <div class="editors_top">部落信息</div>
        <!--部落编辑开始-->
        <div class="editors_warp">
            <!--部落基本信息-->
            <form id=form1>
            <div class="editors_nei">
                <div class="editors_ding">部落基本信息<span class="editors_span" onclick="editors_span1();" id="editinginformation"><i class="icon-bianji" ></i>编辑</span></div>
                <ul class="editors_ding_ul">
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落名称：</span>
                        </div>
                        <div class="editors_ding_right">
                            <span class="editors_right_span"><?php echo isset($tribe['name']) ? $tribe['name'] : ''; ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">所属行业：</span>
                        </div>
                        <div class="editors_ding_right">
                            <input class="editors_right_input inputinfo" type="text" name="industry" readonly disabled="true" style="border:none" value="<?php echo isset($tribe['industry']) ? $tribe['industry'] : ''; ?>">
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                        	<span class="editors_mingc">所属地区：</span>
                        </div>
                        <div class="editors_ding_right">
                            <select class="editors_select inputinfo" id="province_" name="province" readonly disabled="true" onchange=region_change();>
                            	<?php foreach ($provinces as $v){;?>
                            	<option value="<?php echo $v["region_id"]; ?>" <?php echo ($v["region_name"] == $tribe['provice']?"selected":null); ?>><?php echo $v["region_name"]; ?></option>
                                	<?php if($v["region_name"] == $tribe['provice']){?>
                                	<script>
                                		region_change();
                                	</script>
                                	<?php };?>
                            	<?php };?>
                            </select>
                        	<select class="editors_select inputinfo" id="city_" name="city"  readonly disabled="true">
                            	<option value="<?php echo $tribe['city']; ?>"><?php echo $tribe['city']; ?></option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落首领：</span>
                        </div>
                        <div class="editors_ding_right">
                            <span class="editors_right_span"><?php echo isset($tribe['mobile']) ? $tribe['mobile'] : ''; ?></span>
                        </div>
                    </li>

					<?php foreach ($list as $k => $v){;?>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc"><?php echo $v["name"];?>：</span>
                        </div>
                        <div class="editors_ding_right kuandu">
                            <div  class="biaoqianj">
                                <input class="input_Tagator inputinfo" readonly disabled="true" id="<?php echo "inputTagator".$k;?>" name="<?php echo "manager".$v["id"];?>" value="<?php echo $v["mobile"];?>" >
                            </div>
                            <p class="editors_ding_i" hidden>没有搜索结果</p>
                        	<p class="editors_ding_p">可添加多个管理员 现有<?php echo $v["name"];?><span class="rolenum"><?php echo $v["mobile"]?count(explode(",",$v["mobile"])):0;?></span>个</p>
                        </div>
                    </li>
                    <?php };?>
                   
                   
                     <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落简介：</span>
                        </div>
                        <div class="editors_ding_right">
                            <input class="editors_right_input inputinfo" type="text" readonly disabled="true" name="content"  style="border:none" readonly value="<?php echo isset($tribe['content']) ? $tribe['content'] : ''; ?>">
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落正式族员：</span>
                        </div>
                        <div class="editors_ding_right">
                            <span class="editors_right_span"><?php echo $formal_staff; ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">录入族员：</span>
                        </div>
                        <div class="editors_ding_right">
                            <span class="editors_right_span"><?php echo $all_staff; ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">创建时间：</span>
                        </div>
                        <div class="editors_ding_right">
                            <span class="editors_right_span"><?php echo isset($tribe['created_at']) ? $tribe['created_at'] : ''; ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">族员审核：</span>
                        </div>
                       
                        <div class="editors_ding_right">
                        	<input type="checkbox"  id="see_status"  name="see_status"  readonly  disabled="true" class="auiswitch inputinfo" <?php echo ($tribe['staff_status'] == 1) ? 'checked' : '' ;?> >
                        </div>
                    </li>
                </ul>
                <button class="editors_ding_but" id="button1"  style="display: none" onclick="ajaxform1();return false;" > 保存</button>
            </div>
            </form>
 
 		
            <!--上传图片-->
            <form id=form2>
            <div class="editors_nei">
            	<div class="editors_ding">部落基本信息<span class="editors_span" onclick="editors_span2();" id="editingimg"><i class="icon-bianji"></i>编辑</span></div>
                <ul class="editors_ding_ul">
                    <li>
                    	<div class="editors_ding_left">
                            <span class="editors_mingc">部落头像：</span>
                        </div>
                        <div class="editors_ding_right">
                            <div class="stored_chong_xia_z stored_wu">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png" width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="logo" name="logo" disabled onchange="previewImg(this,'#logo_img')">
                                        <div class="stored_chong_yichu">
                                            <span onclick="logo.click();" style="width:65%;">重新上传</span>
                                            <span class="stored_chong_shangchu" style="width:35%;" onclick="del_img('#logo','#logo_img');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2" ><img src="<?php echo !empty($tribe["logo"])?IMAGE_URL.$tribe["logo"]:'images/tongming1.png'; ?>" id="logo_img"></h2>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落背景图：</span>
                        </div>
                        <div class="editors_ding_right">
                            <div class="stored_chong_xia_z stored_wu1">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png" width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="shop_img" name="shop_img" disabled onchange="previewImg(this,'#shopimg')">
                                        <div class="stored_chong_yichu">
                                            <span onclick="shop_img.click();">重新上传</span>
                                            <span class="stored_chong_shangchu" onclick="del_img('#shop_img','#shopimg');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2" ><img src="<?php echo !empty($tribe["shop_img"])?IMAGE_URL.$tribe['shop_img']:'images/tongming1.png';?>" id="shopimg" ></h2>
                            </div>
                        </div>
                        <input name="shopflag"  id="shopimgflag" hidden><!-- 识别图片是否被更改 -->
                    </li>
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落banner图：</span>
                        </div>
                        <div class="editors_ding_right">
                            <div class="stored_chong_xia_z stored_wu1">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png" width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="banner1" name="banner1"  disabled onchange="previewImg(this,'#banner1_img')" value="">
                                        <div class="stored_chong_yichu">
                                            <span onclick="banner1.click();">重新上传</span>
                                            <span class="stored_chong_shangchu" onclick="del_img('#banner1','#banner1_img');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2"><img src="<?php echo !empty($tribe['bg_img'][0])? IMAGE_URL . $tribe['bg_img'][0] : 'images/tongming1.png'; ?>" id="banner1_img"  ></h2>
                            </div>
                
                            <div class="stored_chong_xia_z stored_wu1">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png"/ width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="banner2" name="banner2" disabled onchange="previewImg(this,'#banner2_img')">
                                        <div class="stored_chong_yichu">
                                            <span onclick="banner2.click();">重新上传</span>
                                            <span class="stored_chong_shangchu" onclick="del_img('#banner2','#banner2_img');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2"><img src="<?php echo !empty($tribe['bg_img'][1])? IMAGE_URL . $tribe['bg_img'][1] : 'images/tongming1.png'; ?>" id="banner2_img" ></h2>
                            </div>
                
                            <div class="stored_chong_xia_z stored_wu1">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png"/ width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="banner3" name="banner3" disabled onchange="previewImg(this,'#banner3_img')">
                                        <div class="stored_chong_yichu">
                                            <span onclick="banner3.click();">重新上传</span>
                                            <span class="stored_chong_shangchu" onclick="del_img('#banner3','#banner3_img');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2"><img src="<?php echo !empty($tribe['bg_img'][2])? IMAGE_URL . $tribe['bg_img'][2] : 'images/tongming1.png'; ?>" id="banner3_img" ></h2>
                            </div>
                        </div>
                        <input name="bgflag"  id="bgflag" hidden><!-- 识别图片是否被更改 -->
                    </li>
                
                    <li>
                        <div class="editors_ding_left">
                            <span class="editors_mingc">部落简介定制图：</span>
                        </div>
                        <div class="editors_ding_right">
                            <div class="stored_chong_xia_z stored_wu1" style="height:340px">
                                <div class="stored_chong_top">
                                    <div class="stored_chong_top_lo">
                                        <p class="shangchuan"><img src="images/schaun.png"/ width="25" height="25"></p>
                                        <input class="inputimg" type="file" id="content_img" name="content_img"  disabled onchange="previewImg(this,'#contentimg')">
                                        <div class="stored_chong_yichu">
                                            <span onclick="content_img.click();">重新上传</span>
                                            <span class="stored_chong_shangchu" onclick="del_img('#content_img','#contentimg');">删除</span>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="stored_chong_h2"><img src="<?php echo !empty($tribe['content_img'])? IMAGE_URL . $tribe['content_img'] : 'images/tongming1.png'; ?>" id="contentimg" ></h2>
                            </div>
                        </div>
                        <input name="contentflag"  id="contentimgflag" hidden><!-- 识别图片是否被更改 -->
                    </li>
                </ul>
                <button class="editors_ding_but" id="button2" style="display:none"  onclick="ajax_submit_img();return false">保存</button>
            </div>
        </div>
        </form>
        <!--部落编辑结束-->

    </div>
</div>



<div id="prompt" class="dingdan4_3_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'>是否要保存</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick='$("#promptsure").removeAttr("onclick");$("#prompt").hide();'>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="promptsure">确定</a></div>       
      </div>
  </div>
</div>


<script>
// ------------------------------------部落资料-----------------------------------------------
var is_host = "<?php echo $is_host;?>";

//标签插件初始化
<?php foreach ($list as $k => $v){;?>
var inputTagator = '<?php echo "#inputTagator".$k;?>';
if ($(inputTagator).data('tagator') === undefined) {
    $(inputTagator).tagator({
        autocomplete: [],
    });
}
<?php };?>



//默认禁止编辑设置权限（初始化标签后执行）
$(".tagator_input").attr("readonly","readonly");
$(".tagator_tag_remove").hide();//标签删除按钮隐藏


//筛选没被设置权限的族员
function free(){
	tagator = new Array();//未被设置权限的族员
    var tribe_staff = <?php echo json_encode($tribe_staff);?>; 
    var mobiles = '';
    //已被选中的族员
	$(".input_Tagator").each(function(i){
		mobile = $(this).val();
		if(mobile){
			mobiles += mobile+",";
		}
	});
	//循环筛选出未被选中的族员
	if(tribe_staff.length > 0){
		for(i=0; i<tribe_staff.length; i++){
			if(!mobiles.match(tribe_staff[i]['mobile'])){
				tagator.push(tribe_staff[i]['mobile']);
			};
		}
	}

	$(".input_Tagator").each(function(i){
	 	$(this).data('tagator').settings.autocomplete = tagator;
	});
	
};
free();



//监听角色修改情况，并统计角色人员数量
$('.input_Tagator').change(function() {
	  var num = 0;
	  var staff = $(this).val();
	  if(staff){
    	  staff = staff.split(",");
    	  num = staff.length; 
	  }

	  $(this).parents(".editors_ding_right").children(".editors_ding_p").children(".rolenum").text(num);
});


//监听基本资料是不是被修改了
$(".inputinfo").change(function(){
	$("#editinginformation").attr('onclick','prompt("ajaxform1()")');
});



//添加标签自定义函数（fm.tagator.jquery.js）
function DddTagFree(){
	free();
}

//逗号添加标签自定义函数（fm.tagator.jquery.js）
function commaFree(){
	//遇到逗号不执行
	return false;
};

//搜索自定义函数（fm.tagator.jquery.js）
function searchTag(input,isresult){
	if(isresult){
		input.parents(".editors_ding_right").children(".editors_ding_i").hide();
	}else{
		input.parents(".editors_ding_right").children(".editors_ding_i").show();
	}
};



//编辑部落基本信息1
function editors_span1(){
    $("#button1").toggle();
    if($("#button1").is(":hidden")){
        //禁止标签
    	$(".tagator_input").attr("readonly","readonly");
    	$(".tagator_tag_remove").hide();//标签删除按钮隐藏
        $(".editors_right_input").css("border","none").css("text-indent","initial"); 
        $(".inputinfo").attr("disabled","true").attr("readonly","readonly");//禁止所有操作
    }else{
    	//解除标签操作
    	if(is_host){
        	$(".tagator_input").removeAttr("readonly");
        	$(".tagator_tag_remove").show();//标签删除按钮显示
    	}
        $(".editors_right_input").css("border","").css("text-indent","");  
        $(".inputinfo").removeAttr("disabled").removeAttr("readonly");//解除所有操作
    }
}

//提交资料表单1
function ajaxform1(){
	$.ajax({
		type:'post',
		dataType:'json',
		url:"<?php echo site_url("tribe/ajax_update_tribe");?>",
		data:$("#form1").serialize(),
		success:function(data){
			alert(data.Message);
			if(data["status"] == 2){
				console.log(11);
				$("#editinginformation").attr('onclick','editors_span1()');
				editors_span1(); 
			}
		},
		error:function(res){
			console.log(res);
		}
	});
}


// ------------------------------------部落图片-----------------------------------------------
//非编辑状态下隐藏图片中的icon
$(".inputimg").prev().hide();//隐藏图片中的icon

//编辑部落基本信息2
function editors_span2(){
    $("#button2").toggle();
    if($("#button2").is(":hidden")){
    	$(".inputimg").attr("disabled","false");//将input元素设置为readonly   
    	$(".stored_chong_yichu").hide();//隐藏图片操作
    	$(".inputimg").prev().hide();//显示图片中的icon
    }else{
    	$(".inputimg").removeAttr("disabled");//将input元素readonly移除 
    	$(".inputimg").prev().show();//显示图片中的icon
    }
}

//图片上传预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        img = new Image();       
        reader.onload = function (e) {
            if(input.files[0].size>40307200){//图片大于300kb则压缩
                img.src = e.target.result;
                img.onload=function(){
                    $(obj).attr('src', compress(img));
                }
            }else{
                $(obj).attr('src', e.target.result);
            }

            //特效
            $(input).next().show();//显示图片操作
            $(input).prev().hide();//隐藏图片中的icon

            //标识图片被修改过
            if(obj == "#banner1_img" || obj == "#banner2_img" || obj == "#banner3_img"){
				$("#bgflag").val(1);
            }else{
				$(obj+'flag').val(1);
            }

        }
        reader.readAsDataURL(input.files[0]);
        return 1;
    }  
}


//删除图片
function del_img(input,img){
	input_html = $(input).prop("outerHTML");
	$(input).replaceWith(input_html);//清除input值
	$(input).next().hide();//隐藏图片操作
	$(input).prev().show();//显示图片中的icon
	$(img).attr("src","images/tongming1.png");//替换图片
}


//监听资料图片是不是被修改了
$(".inputimg").change(function(){
	$("#editingimg").attr('onclick','prompt("ajax_submit_img()")');
});

//提交资料表单2
function ajax_submit_img() {
    if (!$("#logo").val() && $('#logo_img').attr('src') == 'images/tongming1.png' ) {
        alert('部落头像为必上传项');return;
    }

    $.ajax({
        url : "<?php echo site_url("tribe/AjaxUpdateTribe");?>",
        type : "post",
        cache : false,
	    data: new FormData($('#form2')[0]),
	    processData: false,
	    contentType: false,
	    dataType:"json"
    }).done(function(res) {
        if(res["status"] == "03"){
        	$("#editingimg").attr('onclick','editors_span2()');
        	editors_span2(); 
        }
    	alert(res.Message); 
    	
	}).fail(function(res) {
		console.log(res);
	});

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
    if ((ratio = width * height / 4000000) > 1) {
        ratio = Math.sqrt(ratio);
        width /= ratio;
        height /= ratio;
    } else {
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
</script>

<script>
//温馨提示弹窗
function prompt(method){
	$("#promptsure").attr("onclick",method);
	$("#prompt").show();
}
</script>

