<style type="text/css">
  .container {background: #f6f6f6;}
  .activities_neirong_xia {margin-right: 17px;}
  .my_activities_xia dd a {text-align: right;padding-right: 17px;}
  .my_activities_top li { height: 90px;padding: 15px;border-bottom: none;background: url(images/circle_data_bg.png) no-repeat; background-size: 100% 100%; }
  .activities_nei_li_xia p span {color: #333;}
  .activities_nei_li_top i {width: 60px;height: 60px;border-radius: 4px;overflow: hidden;}
  .activities_nei_li_top {height: 100%;}
  .activities_nei_li {padding: 0;}
  .activities_nei_li_xia {height: 60px;padding-top: 10px;}
  .more_til {right: 15px;position: static;}
  .circle_data_list ul li a input {font-size: 22px;color: #F0F0F0;border: none;margin-top: 10px; width:35px; background:none;}
  .bianhongse{ right:32px;}
  .circle_data_list {margin-top: 5px;}
  .circle_data_list ul li a em {vertical-align: inherit;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>部落详情</span>
</div>
<?php }?>
<!-- 部落资料 -->
<div>
    <ul class="my_activities_top">
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="javascript:;"><i><img src="<?php echo IMAGE_URL.$tribe["logo"];?>" onerror="this.src='images/default_img_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <h2><?php echo $tribe["name"];?></h2>
                    <p><span><?php echo "创建于".substr($tribe["created_at"],0,10);?></span></p>
                    </a>
                </div>
            </div>
        </div>
    </li>
</ul>
</div>
<!-- 简介 -->
<div class="circle_data_introduction" hidden>
    <p class="circle_data_introduction_title">简介</p>
    <p class="identity_zhong_p"><?php echo $tribe["content"];?></p>
</div>


<!-- 功能简介 列表 -->
<div class="circle_data_list">
  <ul>
  	  <?php if(strpos($power,",/Tribe/Modifydata,") !== false ){;?>
      <li><a href="<?php echo site_url("tribe/Modifydata");?>"><i class="icon-bulaziliaobianji" style='color: #FEAC1F;'></i><span class="circle_data_left circle_data_left_box">部落资料编辑</span><em class="icon-get_into"></em></a></li>
      <?php };?>
      <?php if(strpos($power,",/Tribe/apply_list,") !== false ){;?>
      <li style="position:relative"><a href="<?php echo site_url("tribe/apply_list");?>"><i class="icon-jiarushenqingshenhe" style='color: #06C97C;'></i><span class="circle_data_left circle_data_left_box">加入申请审核</span> <?php echo !empty($count_unaudited_tribe_num)?"<span class='bianhongse'>".(($count_unaudited_tribe_num > 99)? "99+" : $count_unaudited_tribe_num )."</span>" : ""?> <em class="icon-get_into"></em></a></li>
  	  <?php };?>
  	  <?php if($is_host){;?>
      <li><a href="<?php echo site_url('tribe/manage_auth')."/".$tribe['id']; ?>"> <i class="icon-shezhiguanliyuan" style='color: #0190FF;'></i><span class="circle_data_left circle_data_left_box">设置管理员</span><span style="color: #999999;font-size: 15px;"><?php echo isset($manager_num)?count($manager_num):'';?>人</span><em class="icon-get_into"></em></a></li>
      <?php };?>
  </ul>
</div>
<div class="circle_data_list">
  <ul>
  	  <?php if(strpos($power,",/Tribe/Activity_management_view,") !== false ){;?>
      <li><a href="<?php echo site_url("tribe/Activity_management_view");?>"><i class="icon-huodong2" style='color: #FF7906;'></i><span class="circle_data_left circle_data_left_box">活动管理</span><em class="icon-get_into"></em></a></li>
      <?php };?>
      <?php if(strpos($power,",/Tribe/tribe_announcements_view,") !== false ){;?>
      <li><a href="<?php echo site_url("tribe/tribe_announcements_view");?>"><i class="icon-gonggaoguanli" style='color:#EB531A;'></i><span class="circle_data_left circle_data_left_box">公告管理</span><em class="icon-get_into"></em></a></li>
      <?php };?>
      <?php if(strpos($power,",/Tribe/topic_manage_view,") !== false ){;?>
      <li><a href="<?php echo site_url("tribe/topic_manage_view");?>"><i class="icon-quanziguanli" style='color: #3586F6;'></i><span class="circle_data_left circle_data_left_box">圈子管理</span><em class="icon-get_into"></em></a></li>
  	  <?php };?>
  </ul>
</div>
<div class="circle_data_list">
  <ul>
     <?php if(strpos($power,",/Tribe/apply_list,") !== false ){;?>
      <li><a href="javascript:void(0);" class="member_add_audit"><i class="icon-chengyuanjiaruxushenhe" style='color: #00BAD0;'></i><span class="circle_data_left circle_data_left_box">成员加入需审核</span><input type="checkbox" name="on_off" value="1" class="<?php echo ($tribe["staff_status"]?"icon-kaiguan publish_inform_active":"icon-kaiguan icon-kaiguan1");?>" onclick="member_add_audit(this,<?php echo $tribe["staff_status"];?>);"></a></li>
        <?php };?>
  </ul>
</div>

      <!--身份升级结束-->
<script>
(function($){
  $.fn.moreText = function(options){
    var defaults = {
      maxLength:100,
      mainCell:".identity_zhong_p",
      openBtn:'展开',
      closeBtn:'收起'
    }
    return this.each(function() {
      var _this = $(this);
      
      var opts = $.extend({},defaults,options);
      var maxLength = opts.maxLength;
      var TextBox = $(opts.mainCell,_this);
      var openBtn = opts.openBtn;
      var closeBtn = opts.closeBtn;
      
      var countText = TextBox.html();
      var newHtml = '';
      if(countText.length > maxLength){
        newHtml = countText.substring(0,maxLength)+'...<span class="more_til">'+openBtn+'<i class="icon-xiala1"></i></span>';
      }else{
        newHtml = countText;
      }
      TextBox.html(newHtml);
      TextBox.on("click",".more_til",function(){
        if($(this).text()==openBtn){
          TextBox.html(countText+' <span class="more_til">'+closeBtn+'<i class="icon-04"></i></span>');
        }else{
          TextBox.html(newHtml);
        }
      })
    })
  }
})(jQuery);
$(function(){
  $(".circle_data_introduction").moreText({
    maxLength: 100, //默认最大显示字数，超过...
    mainCell: '.identity_zhong_p' //文字容器
  });
})

// 成员加入需审核
function member_add_audit(obj,staff_status){

  var audit = staff_status?0:1;
	$(obj).removeAttr("onclick");
	$.post("<?php echo site_url("tribe/ajax_set_staff_status");?>",{'staff_status':audit},function(data){
		if(data.status == '00'){
			var status = 1;
			if(staff_status){
				status = 0;
			  }
			$(obj).toggleClass('icon-kaiguan1').toggleClass('publish_inform_active');
			$(obj).attr("onclick",'member_add_audit(this,'+status+')');
		}else{
			$(obj).attr("onclick",'member_add_audit(this,'+staff_status+')');
			$(".black_feds").text(data.Message).show();
			setTimeout("prompt();", 2000);
		}
	},"json");
}


</script>  
        
                                                                               
