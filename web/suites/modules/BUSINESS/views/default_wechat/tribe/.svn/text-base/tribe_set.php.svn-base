<style type="text/css">
    .container {background: #F6F6F6;}
	.my_activities_top li {height: 90px;padding: 15px;border-bottom: none;background: url(images/circle_data_bg.png) no-repeat;background-size: 100% 100%;}
	.activities_nei_li {padding: 0;}
	.activities_nei_li_top {height: 100%;}
	.activities_nei_li_top a {display: inline-block;}
	.activities_nei_li_top i {width: 60px;height: 60px;border-radius: 4px;overflow: hidden;}
	.activities_nei_li_xia {height: 60px;padding-top: 10px;}
	.activities_nei_li_xia a {width: 100%;}
	.activities_nei_li_xia p {color: #a7a7a7;font-size: 13px;}
	.activities_nei_li_xia p span {color: #999;}
	.edit_tribe_sh {margin-bottom: 0;}
	.tribe_jianjie_text {padding-bottom: 40px;}
	.more_til {left: 15px;bottom: 10px;color: #9B9B9B;}
	.more_til i {padding-left: 2px;}
</style>


<!-- 设置 -->
<div>
    <ul class="my_activities_top">
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="javascript:void(0);"><i><img src="<?php echo IMAGE_URL.$tribe['logo'];?>" onerror="this.src='images/default_img_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <h2><?php echo  $tribe['name'];?></h2>
                    <p><span><?php echo  substr($tribe['created_at'],0,16);?></span></p>
                    </a>
                </div>
            </div>
        </div>
    </li>
</ul>
</div>
<div>
	<ul class="edit_tribe_sh">
            <li style="height: auto;">
              <a href="javascript:void(0);">
                <div class="edit_tribe_sh_ul_top">
                  <span class="edit_tribe_sh_ul_top_left">部落简介</span>
                   <div class="edit_tribe_sh_ul_zhong"></div>
                   </div>
              </a>
              <div class="tribe_jianjie_text"><span style="margin-left: 0;color:#4A4A4A;" class="identity_zhong_p"><?php echo $tribe['content'];?></span></div>  
            </li>
        </ul>
</div>

<div class="circle_data_list">
  <ul>
  <?php if($staff_info['is_host'] != 0 || $staff_info['tribe_manager_id'] != 0){?>
       <li><a href="<?php echo site_url("Tribe/managingtribes/{$tribe['id']}")?>"><span class="circle_data_left circle_data_left_box">部落管理</span><em class="icon-get_into"></em></a></li>
  <?php }?>
  	 <li style="margin-top: 10px;"><a href="javascript:quit(0);"><span class="circle_data_left circle_data_left_box">退出部落</span></a></li>
  </ul>
</div>

 <!-- 弹窗 -->
 <div class="tuichu_ball" hidden>
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>是否退出部落？</span></div>
         <div class="tuichu_ball_button">
           <a href="javascript:cane(0);">取消</a>
           <a id = 'tuichu_sub' href="javascript:quit_sub(0);">确定</a>
         </div>      
      </div>
   </div>
 </div> 





<script type="text/javascript">
   
  function quit(){
	$("#tuichu_sub").attr("href","javascript:quit_sub(0);");
	$('.tuichu_ball').show();
  }

  function cane(){
     $('.tuichu_ball').hide();
  }    

	(function($){
  $.fn.moreText = function(options){
    var defaults = {
      maxLength:50,
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
        newHtml = countText.substring(0,maxLength)+'...<span class="more_til">'+openBtn+'<i class="icon-unfold"></i></span>';
      }else{
        newHtml = countText;
      }
      TextBox.html(newHtml);
      TextBox.on("click",".more_til",function(){
        if($(this).text()==openBtn){
          TextBox.html(countText+' <span class="more_til">'+closeBtn+'<i class="icon-fold"></i></span>');
        }else{
          TextBox.html(newHtml);
        }
      })
    })
  }
})(jQuery);
$(function(){
  $(".tribe_jianjie_text").moreText({
    maxLength: 50, //默认最大显示字数，超过...
    mainCell: '.identity_zhong_p' //文字容器
  });
})
    function quit_sub(){
        <?php if($staff_info['is_host'] && $member_count == 1){?>
                $.ajax({
                    url: '<?php echo site_url('Tribe/del_tribe')?>',
                    type: 'post',
                    dataType: 'json',
                    data: {'tribe_id': <?php echo $tribe_id;?>},
                    success: function (data) {
                        $('.tuichu_ball').hide();
                        $(".black_feds").text(data.Msg).show();
                        setTimeout("prompt();", 2000);
                        if(data.Type ==3){
                            setTimeout(function (){
                                window.location.href = '<?php echo site_url('Tribe');?>';
                                }, 2200);
                            }
                        },
                    error:function (data) {
                        $('.tuichu_ball').hide();
                      $(".black_feds").text("网络错误，请重试").show();
                      setTimeout("prompt();", 2000);
                      return false;
                        }
                 })
        <?php }else{?>
            $.ajax({
                url: '<?php echo site_url('Tribe/quit_tribe')?>',
                type: 'post',
                dataType: 'json',
                data: {'tribe_id': <?php echo $tribe_id;?>},
                success: function (data) {
                    $('.tuichu_ball').hide();
                    $(".black_feds").text(data.Msg).show();
                    setTimeout("prompt();", 2000);
                    if(data.Type !=3){
                        setTimeout(function (){
                            window.location.href = '<?php echo site_url('Tribe');?>';
                            }, 2200);
                        }
                    },
                error:function (data) {
                    $('.tuichu_ball').hide();
                  $(".black_feds").text("网络错误，请重试").show();
                  setTimeout("prompt();", 2000);
                  return false;
                    }
             })
        <?php }?>


        
        
        }
</script>











