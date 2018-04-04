<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>编辑部落资料</span>
</div>
<?php }?>
<style type="text/css">
  .container {background: #f6f6f6;}
</style>
<form>
    <div class="tribe_edit_industry">
        <textarea placeholder="请填写部落简介" name="content" maxlength=""><?php echo $tribe["content"];?></textarea>
    </div>
    <a href="javascript:void(0)" class="circle_publish_jia custom_button" onclick="ajax_submit(4);">保存</a>
</form>
<input type="text"  value="<?php echo $tribe["content"];?>" style="display:none" id="text_content">
<script>

/**
 * ajax修改部落信息
 */
function ajax_submit(type){
	var content = $("#text_content").val();;
	var str = $("textarea").val();
	if(str.length && content != str){
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
            }else{
            	document.location.reload(true);
            }    
    	}).fail(function(res) {
    		document.location.reload(true);
    	});
	}else{
		window.history.back();
	}
}
</script>


