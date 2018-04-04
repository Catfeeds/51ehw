<style type="text/css">
</style>

<!-- 创建分享 -->
<div class="tribe_my_share">
    <div class="tribe_my_share_list">
        <div class="tribal_share_details">
           <!-- 标题 -->
           <div class="new_package_share_title">
             <span>标题</span>
             <div><p><input type="text" id="title" maxlength="20" placeholder="" value="<?php echo $detail['title'];?>"><em><i>0</i>/20</em></p></div>
           </div>
           <!-- 描述 -->
           <div class="tribal_share_details_title tribe_build_share_describe"><span>描述</span><p><textarea id="desc"  maxlength="50" placeholder=""><?php echo $detail['desc'];?></textarea><em><i>0</i>/50</em></p></div>
        </div>
         <div class="tribal_share_details_prize">
           <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span><?php echo $detail['tribe_package_name'];?></span>
                        <span><?php echo $detail['tribe_package_desc'];?></span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至<?php echo $detail['valid_date']?></p>
        	</div>
        </div>
          <!-- 发放数量 -->
        <div class="tribal_share_details_choice tribal_share_details_num"><a href="javascript:void(0);">发放数量 <div class="tribal_share_details_num_input"><input type="text" value="<?php echo $detail['quanity'];?>" disabled="false" placeholder=""></div><i>个</i></a></div>
         <!-- 邀请好友加入您的部落 -->
         <div class="tribe_share_invite" style="margin-top: 10px;">
            <span>邀请好友加入您的部落</span>
            <p><input name="Fruit" type="checkbox" value="<?php echo $tribe_info['id'];?>" disabled="disabled" checked=''/><?php echo $tribe_info['name'];?></p>
         </div>
    </div>   
    <!-- 保存并分享 -->
    <a href="javascript:sub();" class="new_package_details_save">保存</a>

</div>

<script>
function sub(){
	var title = $("#title").val();
	var desc = $("#desc").val();

	if(!title){
		$(".black_feds").text('标题不能为空！').show();
		setTimeout("prompt();", 2000);
		return;
		}
	if(!desc){
		$(".black_feds").text('内容不能为空！').show();
		setTimeout("prompt();", 2000);
		return;
		}
	$.post("<?php echo site_url("Activity/Tribe_package/save");?>",{share_id:<?php echo $detail['id'];?>,title:title,desc:desc},function(data){
		if(data.status == 2){
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

var length_title = $('#title').val().length;
$(".new_package_share_title p em i").text(length_title);  
var length_desc = $('#desc').val().length;
$(".tribe_build_share_describe p em i").text(length_desc);

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



</script>