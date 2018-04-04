<style type="text/css">
  .container {background: #f6f6f6;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>编辑部落资料</span>
</div>
<?php }?>
<form>
<div class="tribe_edit_industry">
    <ul>
    <li>
        <a href="javascript:void(0);">
            <span>所属行业</span>
            <div class="tribe_edit_industry_select"><input name="industry" value="<?php echo $tribe["industry"];?>"></div>
        </a>
    </li>
    </ul>
</div>
<!-- 保存 -->
<a href="javascript:void(0)" onclick="ajax_submit()" class="circle_publish_jia custom_button">保存</a>
</form>
<script>

/**
 * ajax修改部落信息
 */
function ajax_submit(){
	var industry = $("input[name=industry]").val();
	var myindustry = "<?php echo $tribe["industry"];?>";
	if(!industry){
		$(".black_feds").text('请填写所属行业').show();
		setTimeout("prompt();", 600); return;
	}
    if(myindustry != industry){
        $.ajax({
            url : "<?php echo site_url("tribe/update");?>",
            type : "post",
            cache : false,
    	    data: new FormData($('form')[0]),
    	    processData: false,
    	    contentType: false,
    	    dataType:"json"
        }).done(function(res) {
            if(res["status"] == 1){
            	history.back();
            }    
    	}).fail(function(res) {
    		document.location.reload(true);
    	});
    }else{
    	history.back();
    }

}

</script>


