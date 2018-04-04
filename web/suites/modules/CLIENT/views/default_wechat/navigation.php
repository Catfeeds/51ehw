
<?php switch ($title){
	//项目介绍
	case "项目介绍":{?>
<div class="page clearfix">
	<img src="<?php echo THEMEURL.$navigation_img?>" alt="项目介绍">
</div>
<?php
        break;
           }
	//常见问题
    case "常见问题":{?>
<div class="page clearfix">
	<img src="<?php echo THEMEURL.$navigation_img?>" alt="常见问题">
</div>
<?php
        break;
       }
	//如何加入
    case "如何加入":{?>
<div class="page clearfix">
	<img src="<?php echo THEMEURL.$navigation_img?>" alt="如何加入">
</div>
<?php
        break;
       }
	//商务合作
    case "商务合作":{?>
<div class="page clearfix">
	<img src="<?php echo THEMEURL.$navigation_img?>" alt="商务合作">
	<div class="cooperate_text">
		<span>商务合作，请填写以下信息，并保证所填信息真实有效，工作人员会在6-7个工作日内联系您，亦可拨打400客服电话了解详情</span>
    </div>
    <div class="cooperate_main">
        <form action="<?php echo site_url('navigation/cooperate_save')?>" method='post' name="form12" id="cooperate_save">
        	<ul>
        		<li>企业名称<input type="text" id="cor_name" name="corporation_name" value=""></li>
        		<li>申请人<input type="text" id="rename" name="applicant_name" value=""></li>
        		<li>联系方式<input type="text" id="mobile" name="mobile" value=""></li>
        		<li>企业性质
                	<!-- <div class="select_span" id="text_show" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">企业性质</div> -->
                	<select id="nature_id" name="nature_id" parsley-trigger="change" onchange="updateSpan();" class="select_span" required>
                		<option class="nature_option" value="0">请选择企业性质</option><!-- css 样式写在这个页面下边，顺手的话麻烦顺便搬去你们的css文件里 -->
                		<?php foreach ($cor_type as $k=>$v):?>
                		<option class="nature_option" value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                		<?php endforeach;?>
                		
                	</select>
                </li>
        		<li>申请人职务<input type="text" id="customer_post" name="applicant_duty" value=""></li>
        		<li class="cooperate_input"><span style="display: -webkit-inline-box;padding-top: 30px;">希望合作的方向</span>
            		<textarea id="cooperate_direction" name="coo_direction" style="height:80px;width:56%;border: 1px solid #A2A2A2;outline: none;border-radius:2px;resize: none;float: right;margin-right: 9.33%;"></textarea>
        		</li>
        	</ul>
        	<input type="hidden" id="type_name" name="type_name" value="<?php echo $type_name?$type_name:"h5";?>">
			<a onclick="save_sub()">
				<div class="register-button" style="background: #fe4101 !important; color: #fff;">确定</div>
			</a>
		</form>
    </div>
</div>

<script>
// 进入页面监测提示信息
$(function(){
	var err = "<?php echo $err?$err:0;?>";
	if(err == 1){
		$(".black_feds").text("您的信息已提交成功，工作人员将会在6-7个工作日内联系您").show();
		setTimeout("prompt();", 2000);
	}else if(err == 2){
		$(".black_feds").text("网络错误，提交失败").show();
		setTimeout("prompt();", 2000);
	}else if(err == 3){
		$(".black_feds").text("已提交成功，请勿重复操作").show();
		setTimeout("prompt();", 3000);
	}else if(err == 4){
		$(".black_feds").text("递交的数据不完整或网络错误").show();
		setTimeout("prompt();", 2000);
	}
	else if(err == 5){
		$(".black_feds").text("您已经提交过该信息了").show();
		setTimeout("prompt();", 2000);
	}
})

function save_sub(){
    var sub = true;
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
    var mobile = $("#mobile").val();
    
    if($("#cooperate_direction").val()==""){
		$(".black_feds").text("请输入希望合作的方向").show();
		setTimeout("prompt();", 2000);
	    sub = false;
		return false;
	}else if($("#cooperate_direction").val().length>512){
		$(".black_feds").text("希望合作的方向字数超过限制").show();
		setTimeout("prompt();", 2000);
	    sub = false;
		return false;
	}

    if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
	    sub = false;
		return;
	}
    
	if($("#nature_id option:selected").val()=="0"){
		$(".black_feds").text("请选择企业性质").show();
		setTimeout("prompt();", 2000);
	    sub = false;
		return false;
	}
	
    $("input").each(function(){
    	if($(this).val()==""){
        	$show_text = $(this).parent().text();
    		$(".black_feds").text("请输入"+$show_text).show();
    		setTimeout("prompt();", 2000);
    	    sub = false;
    		return false;
    	}
    });
    
	if(sub){
	    $("#cooperate_save").submit();
	}
}
// select选择事件
function updateSpan(){
	$("#text_show").html($("#nature_id option:selected").text());
}
</script>

<style type="text/css">
#nature_id {outline: none;}
.select_span {
	border: 1px solid #A2A2A2;
	background-color: #fff;
	width: 56%;
	float: right;
	height: 25px;
	line-height: 25px;
	margin-right: 9.33%;
	text-align:center;
	border-radius:2px;	
}
</style>
<?php
        break;
       }
   //常见问题
   case "精英头条":{?>
   
<style type="text/css">
	.my-needs-li-title {width: 100%;}
	.my-needs-li-time {font-size:12px;color:#999999;}
.my-needs-main {
   padding: 5px 0 0 0;
}
</style>
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<!-- 头部导航 -->
<div class="elite_headline_nav">
	<ul>
	  <li class="my-needs-nav-active-li"><a href="javascript:void(0);">资讯列表</a></li>
	  <li><a href="javascript:void(0);">项目介绍</a></li>
	  <li><a href="javascript:void(0);">如何赚钱</a></li>
	</ul>
</div>
<div style="height: 45px;"></div>
<!-- 列表内容 -->
<div class="my-needs-main" id="main">
	<ul class="list">
   </ul>
   	<ul hidden>
   		<div class="page clearfix">
		<img src="<?php echo THEMEURL.$navigation_project_img?>" alt="项目介绍">
	</div>
   	</ul>
   	<ul hidden>
   		<div class="page clearfix">
		<img src="<?php echo THEMEURL.$navigation_money_img?>" alt="项目介绍">
	</div>
   	</ul>
   	     
</div>
<script type="text/javascript">
	var nav_length = $(".elite_headline_nav ul li").length;
	$(".elite_headline_nav ul li").css("width",(100 / nav_length)+ "%");
    
    $(".elite_headline_nav ul li").on("click",function(){
		var index = $(this).index();
		$(this).find("a").addClass("my-needs-nav-active").parent().siblings().find("a").removeClass("my-needs-nav-active");
		$(".my-needs-main ul").eq(index).show().siblings().hide();
		$(this).addClass('my-needs-nav-active-li').siblings().removeClass('my-needs-nav-active-li');
	})
     //下拉加载数据
     var page = 1;
     dropload = $('#main').dropload({
 		scrollArea : window,
 		loadDownFn : function(me){
 			 $.post("<?php echo site_url("Navigation/ajax_elite");?>",{page:page},function(data){ 
 	 			 if(data.list.length > 0){
  	 				 var result= '';
					 var errorimg = "this.src='images/default_img_s.jpg'";
					 for(var i=0;i<data.list.length;i++){
						 var img = "<?php echo base_url().'uploads/C/'?>"+data.list[i]['title_img'];
						 result += '<li>';
						 result += '<a href="<?php echo site_url('Navigation/elite_detail');?>/'+data.list[i]['id']+'">';
						 result += '<div class="my_needs_goods_img"><img src="'+img+'" onerror="'+errorimg+'" alt=""></div>';
						 result += '<div class="my_needs_goods_main">';
						 result += '<span class="my-needs-li-title">'+data.list[i]['title']+'</span>';
						 result += '<span class="my-needs-li-time">'+data.list[i]['create_time']+'</span>';
						 result += '</div>';
						 result += '</a>';
						 result += '</li>';
						 }
					 $('#main').find('.list').append(result);
					 page++;
		             me.resetload();
		             var width_div = $(".my_needs_goods_img").width();
		             $(".my_needs_goods_img").height(width_div);
 	 	 			 }else{
 	 	 	 			// 锁定
  	 	                me.lock();
  	 	                // 无数据
  	 	                me.noData();
  	 	                me.resetload();
 	 	 	 			 }
 	 			 },"json");
 			}
 		});
     
</script>
<?php
    break;
   }
//默认
    default:{?>
<div class="page clearfix">
</div>
<?php
        break;
        }
	}?>