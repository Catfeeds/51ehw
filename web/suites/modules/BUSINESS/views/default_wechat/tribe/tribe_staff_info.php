<style type="text/css">
  .container {background: #f6f6f6;}
  .activities_nei_li_top i {width: 60px;height: 60px;margin-right: 15px;margin-left: 0;border-radius: 5px;border: 1px solid #ddd;overflow: hidden;}
  .activities_nei_li_top {height: 60px;}
  .my_activities_top li {border-bottom: none;}
  .activities_nei_li_xia p span {color: #333;}
  .activities_nei_li_xia h2 {font-size: 15px;color: #333;}
  .activities_nei_li_xia {margin-top: 7px;}
  .activities_nei_li {border-bottom: 1px solid #ddd;padding: 10px 15px;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>族员信息</span>
</div>
<?php }?>
<ul class="my_activities_top">
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="javascript:;"><i><img src="<?php echo IMAGE_URL.$staff_info["wechat_avatar"];?>" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <!-- 性别 女图标 icon-nv 颜色 #ec6e9e  -->
                    <h2><?php echo $staff_info["real_name"]?$staff_info["real_name"]:$staff_info["name"];?>
                    <?php if($staff_info["sex"] == 1){;?>
                    <em class="icon-nan name_xingbie" style="color: #55acde;"></em>
                    <?php }else{;?>
                    <em class="icon-nv name_xingbie" style="color: #ec6e9e;"></em>
                    <?php };?>
                    </h2>
                    <p><span>昵称：<?php echo $staff_info["nick_name"];?></span></p>
                    </a>
                </div>
            </div>
           
        </div>
    </li>
</ul>

<div class="circle_add_apply_list">
 <ul>
    <li><span>手机</span><span><?php echo $staff_info["mobile"];?></span></li>
    <li><span>职业</span><span><?php echo $staff_info["job"];?></span></li>
    <li><span>企业</span><span><?php echo $staff_info["corp_name"];?></span></li>
 </ul>    
</div>

<?php if($staff_info["status"] == 1){?>
<div class="circle_add_apply_footer" id="apply_footer">
    <ul>
        <li><a href="javascript:void(0);" onclick="audit(3)";>拒绝</a></li>
        <li><a href="javascript:void(0);" onclick="audit(2)";>同意</a></li>
    </ul>
</div>

<script>
function audit(status){
    var staff_id = "<?php echo $staff_info["id"];?>";
    $.post("<?php echo site_url("tribe/Ajax_audit");?>",{staff_id:staff_id,status:status},function(data){
    	if(data["status"] == 2){
    	    if(status == 2){
    	    	$(".black_feds").text('已添加').show();
    	    }else{
    	    	$(".black_feds").text('已拒绝').show();
    	    }
    	    $("#apply_footer").remove();
    	}else{
    		$(".black_feds").text('网络异常').show();
    	}
    	setTimeout("prompt();", 600); return;
    },"json");
}

</script>
<?php };?>




