<style type="text/css">
  .container {background: #F6F6F6;}
</style>
<!-- 新增管理员 -->
<div class="tribe_manage_add">
   
   <div class="tribe_manage_add_box">
     <ul>
      <?php if(count($list)):?>
      <?php foreach($list as $val):?>
        <?php if($val['is_host'] != 1):?>
         <li staff_id="<?php echo $val['id'];?>">
          <a href="javascript:void(0);">
            <div class="tribe_manage_add_img"><img src="<?php echo $val['brief_avatar'] ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];?>" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_add_name"><span><?php echo !empty($val['real_name']) ? $val['real_name'] : $val['member_name']; ?></span><span><?php echo !empty($val['corporation_name']) ? $val['corporation_name']: ''; ?>  <?php echo !empty($val['duties']) ? $val['duties']: ''; ?></span></div> 
            <div class="tribe_manage_add_status"><input type="checkbox" class=""></div>
          </a>
         </li>
       <?php endif;?>
       <?php endforeach;?>
        <?php else:?>

           <li style="text-align: center;">
                暂无合适的族员可添加为管理员。
             
           </li> 
        <?php endif;?>
       <!--   <li>
          <a href="javascript:void(0);">
            <div class="tribe_manage_add_img"><img src="images/default_img_logo.jpg" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_add_name"><span>马云联盟</span><span>阿里星人集团</span></div> 
            <div class="tribe_manage_add_status"><input type="checkbox" class=""></div>
          </a>
         </li>
         <li>
          
          <a href="javascript:void(0);">
            <div class="tribe_manage_add_img"><img src="images/default_img_logo.jpg" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_add_name"><span>马云联盟</span><span>阿里星人集团</span></div> 
            <div class="tribe_manage_add_status"><input type="checkbox" class=""></div>
          </a>
         </li> -->
     </ul>
   </div> 

  <div class="tribe_preson_show_footer" style="display: block;">
  <ul>
      <li><a href="javascript:void(0);" class="footer_photo_edit_cancel tribe_ball_cancel">取消</a></li>
      <li><a href="javascript:void(0);" class="footer_photo_edit_delete"  id = "sub" onclick="ajax_submit()">确认</a></li>
  </ul>
</div>

</div>

<script type="text/javascript">
   $(".tribe_manage_add_box ul li a").on("click",function(){
     $(this).children('.tribe_manage_add_status').find('input').toggleClass('icon-selected');
     $(this).children('.tribe_manage_add_status').find('input').toggleClass('tribe_manage_active');
     $('.tribe_preson_show_footer').show();
   })
   $('.tribe_ball_cancel').on('click',function(){
      $(".tribe_manage_add_box ul li a").children('.tribe_manage_add_status').find('input').removeClass('tribe_manage_active');
      $(".tribe_manage_add_box ul li a").children('.tribe_manage_add_status').find('input').removeClass('icon-selected');
      window.location.href = "<?php echo site_url("tribe/manage_auth")."/".$tribe['id'];?>";
   })


   var staff_id = []
   // 添加管理员
   var customer_id = "<?php echo $this->session->userdata('user_id');?>";
   var create_customer = "<?php echo $create_customer;?>";
   function ajax_submit()
   {

      // 权限校验
      <?php if($tribe['is_host'] != 1){ ?>
        $(".black_feds").text("您不是部落首领不能添加管理员").show();
        setTimeout("prompt();location.reload();", 1000);
        return false;
      <?php  } ?>

      // 获取staff_id
      staff_id = [];
      var tribe_id = "<?php echo $tribe['id'];?>";
      var type = 'add';
      var manage_id = "<?php echo $role_id;?>";
      $(".icon-selected").each(function(){
          
        var tmp_id = $(this).parent().parent().parent().attr("staff_id");
        staff_id.push(tmp_id);
      });

      // console.log(staff_id);
      // return false;
      if(staff_id.length){
          var data = JSON.stringify(staff_id);
          
                $.ajax({ 
                  url:'<?php echo site_url('Tribe/update_manage')?>',
                  type:'post',
                  dataType:'json',
                  data:{'staff_id':data,'tribe_id':tribe_id,'type':type,'manage_id':manage_id},
                  beforeSend:function()
                      { 
                        // 防止重复提交
                        $("#sub").attr('onclick', '');
                   
                      },
                  success:function(data)
                  {
        
                      if(data.code == 1){
                        // console.log(data.msg);
                        $(".black_feds").text("添加成功").show();
                        setTimeout("prompt();", 500);
                        window.location.href = "<?php echo site_url("tribe/manage_auth")."/".$tribe['id'];?>"; 
                      }else{
                        $(".black_feds").text("添加失败").show();
                        setTimeout("prompt();location.reload();", 500);
                      }
                       
                },
                  error:function()
                  {
                    
                    $(".black_feds").text("发送失败,请稍后再试").show();
                      setTimeout("prompt();", 1000);   
                      return;
                  }
                });   
            
      }else{
         $(".black_feds").text("请选择管理员").show();
                      setTimeout("prompt();", 1000); 
      }

   } // ajax_submit end
 




</script>
