<style type="text/css"> 
  .container {background: #F6F6F6;}
  .edit_tribe_sh {margin-bottom: 0;}
  .edit_tribe_sh_l {line-height: 50px !important;height: 50px !important;}
  .edit_tribe_sh_ul_top .icon-right {padding-left: 0;}
  .box_d{
	overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis;padding: 0 12px;text-align: right;box-sizing: border-box;box-flex: 1;-webkit-box-flex: 1;-moz-box-flex: 1;-ms-flex: 1;width: 100%;display: block
    }
  .members_off {color: #FFD700;font-size: 17px;padding-right: 5px;vertical-align: text-bottom;}
</style>

<!-- 个人资料 -->
<form>
    <div class="personal_information">
        <ul class="edit_tribe_sh">
            <li class="edit_tribe_sh_l">
                <a href="#">
                    <input class="edit_tribe_sh_input" type="file" name="file" onchange="previewImg(this,'#thubm1')"> 
                    <div class="edit_tribe_sh_ul_top">
                        <span class="edit_tribe_sh_ul_top_left">头像</span>
                        <div class="edit_tribe_sh_ul_zhong">
                            <div class="edit_tribe_sh_ul_zhong_left">
                                <span class="edit_span_top"><img src="<?php echo $avatar?$avatar:"images/member_defult.png";?>" id="thubm1" onerror="this.src='images/default_img_logo.jpg'"></span>
                            </div>
                        </div>
                        
                    </div>
                </a>
            </li>
        </ul>
      <div class="personal_information_list">
        <ul>
            <li><a href="javascript:void(0);"><span>昵称</span><input name="nick_name" value="<?php echo $nick_name;?>" onchange="ajax_up_info();" placeholder="请填写昵称"></a></li>
            <li><a href="javascript:void(0);"><span>真实姓名</span><input name="real_name" value="<?php echo $real_name;?>" onchange="ajax_up_info();" placeholder="请填写真实姓名"  <?php echo $customer_info["idcard"]?'disabled="disabled"':null;?>></a></li>
            <li><a href="javascript:void(0);"><span class='personal_information_sexual'>性别</span><select name="sex" onchange="ajax_up_info();"><?php if($sex==null){;?><option value="" <?php echo $sex==null?"selected":null;?>>请选择</option><?php };?><option value="1" <?php echo $sex==1?"selected":null;?>>男</option><option value="0" <?php echo $sex=="0"?"selected":null;?>>女</option></select></a></li>
            <li><a href="javascript:void(0);"><span>手机号码</span><span><?php echo $mobile;?></span></a></li>
            <li><a href="javascript:void(0);"><span>职位</span><input name="job" value="<?php echo $job;?>" onchange="ajax_up_info();" placeholder="请填写职业"></a></li>
            <li><a href="<?php echo site_url('Tribe_social/Edit_Info/2')?>"><span class="clans_data_name">亮点</span><div class="box_d"><span style="color: #999;"><?php echo trim( $customer_info['merit'], '/');?></span></div> <em class="icon-right"></em></a></li>
        	<li><a href="<?php echo site_url('Tribe_social/Edit_Info/1')?>"><span class="clans_data_name">简介</span><div class="box_d"><span style="color: #999;"><?php echo $customer_info['brief'];?></span></div> <em class="icon-right"></em></a></li>
        </ul>
      </div>
    
      <!-- 社会身份 -->
      <div class="personal_information_status">
        <p><span class="icon-members_on members_off"></span>社会身份 <a href="<?php echo site_url("Tribe_social/Identity");?>">添加</a></p>
        <ul>
    	<?php foreach($corp_list as $v){?>
            <li>
              <a href="<?php echo site_url("Tribe_social/Edit_Identity/{$v['id']}");?>">
                <div class="society_status_left">
                <?php if($v["type"] == 1){;?>
                <span class="icon-building_"></span>
                <?php }else if($v["type"] == 2){;?>
                <span class="icon-building_1"></span>
                <?php }else if($v["type"] == 3){;?>
                <span class="icon-hammer"></span>
                <?php };?>
                </div>
                <div class="society_status_right"><span><?php echo $v["organization_name"];?></span><span><?php echo $v["organizationl_duties"];?></span></div>
                <em class="icon-right"></em>
              </a>
            </li>
        <?php };?>
        </ul>
      </div>
    </div>
</form>
<script type="text/javascript">
$(function () {   
    var isPageHide = false;   
    window.addEventListener('pageshow', function () {   
        if (isPageHide) {   
          window.location.reload();   
        }   
    });   
    window.addEventListener('pagehide', function () {   
    	isPageHide = true;   
    });   
})   

//图片上传预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        img = new Image();       
        reader.onload = function (e) {
            $(input).parents(".icon-zhaopianshangchuan").css("color","#fff").css("background","rgba(0,0,0,0.4)");
      		$(".yijji").css("color","#fff");
        }
        reader.readAsDataURL(input.files[0]);
        background_img();
        return 1;
    }  
}




/**
 * ajax修改用户信息
 */
function ajax_up_info(){
    $.ajax({
        url : "<?php echo site_url("Member/info/ajax_up_info");?>",
        type : "post",
        cache : false,
	    data: new FormData($('form')[0]),
	    processData: false,
	    contentType: false,
	    dataType:"json"
    }).done(function(res) {
        $(".black_feds").text(res.msg).show();
		setTimeout("prompt();", 2000);   
		if(res.status != '00'){
			setTimeout(function(){
				window.location.reload();
				}, 2300);   
			} 
	}).fail(function(res) {
		$(".black_feds").text('更新失败').show();
		setTimeout("prompt();", 2000); 
	});
}

//修改头像
function background_img()
{ 
        $.ajax({
            url: '<?php echo site_url('Tribe_social/Upload_Avatar');?>',
            type: 'POST',
            cache: false,
            dataType:'json',
            data: new FormData( $('form')[0] ),
            processData: false,
            contentType: false,
            
        }).done(function(data) {
        	if( data.status ){
            	$('#thubm1').attr('src',data.data);
        		$(".black_feds").text('更换成功').show();
        		setTimeout("prompt();", 800); 
        		return;
        	}

        	$(".black_feds").text('更换失败').show();
    		setTimeout("prompt();", 800); 
           	return false;
           	
        	
        }).fail(function(res) 
        {
        	$(".black_feds").text('网络异常，请稍后再试').show();
    		setTimeout("prompt();", 2000); 
           	return false;
        	
        });
        
}

<?php if(!empty($customer_info_Ts)){ ?>
var show_mobile = '';
var staff_id = "<?php echo $customer_info_Ts['staff_id']?>";
var customer_id = "<?php echo $this->session->userdata('user_id');?>";
var url = '<?php echo site_url('Tribe/update_show_mobile');?>';
	$("input[type='checkbox']").click(function(){
		if($(".aui-switch:checked").length > 0){
			show_mobile = 1;
			$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
				console.log(res);
			});
		}else{
			show_mobile = 2;
			$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
				console.log(res);
			});
		}
	
	});
<?php }?>
</script>