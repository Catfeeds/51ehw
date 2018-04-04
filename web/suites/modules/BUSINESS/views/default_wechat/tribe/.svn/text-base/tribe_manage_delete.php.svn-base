<style type="text/css">
  .container {background: #F6F6F6;}
.guanliyuan_xuanze ul li {line-height: 55px;}
</style>
<!-- 部落管理删除 -->
<?php //var_dump($list);?>
<div class="tribe_manage_delete">

   <div class="tribe_manage_delete_box">
     <ul>
         <?php if(isset($list)):?>
         <?php foreach($list as $val):?>
            <?php if($val['is_host'] != 1):?>
         <li >
          <a href="javascript:void(0);">
            <div class="tribe_manage_delete_img"><img src="<?php echo $val['brief_avatar'] ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];?>" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_delete_name" ><span><?php echo !empty($val['real_name']) ? $val['real_name'] : $val['member_name']; ?><em><i class="icon-shenfen"></i>
           <?php echo $val['m_name'];?>


            </em></span><span><?php echo !empty($val['corporation_name']) ? $val['corporation_name']: ''; ?> <?php echo !empty($val['duties']) ? $val['duties']: ''; ?></span>
                 
            </div>  
            <div  class="tribe_manage_delete_status" item="<?php echo $val['m_id']; ?>"><em class="icon-shanchu2" staff_id="<?php echo $val['id'];?>" onclick="shanchu(this);"></em></div>
          </a>
         </li>
        <?php endif;?>
         <?php endforeach;?>
         <?php else:?>
            <li style="text-align: center;">
               
                 暂无管理员，请前往新增管理员。
              
            </li> 
         <?php endif;?>

     <!--     <li>
          <a href="javascript:void(0);">
            <div class="tribe_manage_delete_img"><img src="images/default_img_logo.jpg" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_delete_name"><span>马云联盟<em><i class="icon-shenfen"></i>管理员</em></span><span>阿里星人集团</span></div>  
            <div class="tribe_manage_delete_status"><em class="icon-shanchu2"></em></div>
          </a>
         </li>
         <li>
          <a href="javascript:void(0);">
            <div class="tribe_manage_delete_img"><img src="images/default_img_logo.jpg" alt="" onerror="this.src='images/default_img_logo.jpg'"></div>
            <div class="tribe_manage_delete_name"><span>马云联盟<em style="border: 1px solid #55ACC9;color: #55ACC9;"><i class="icon-shenfen"></i>创建者</em></span><span>阿里星人集团</span></div>  
            <div class="tribe_manage_delete_status"><em class="icon-shanchu2"></em></div>
          </a>
         </li> -->
     </ul>
   </div> 

   <!-- 删除弹窗 -->
   <div class="tuichu_ball shanchu_ball" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>确认删除吗？</span></div>
         <div class="tuichu_ball_button">
           <a id="tuichu_sub" href="javascript:void(0);" >确定</a>
           <a href="javascript:void(0);" class="tribe_ball_cancel">取消</a>
         </div>      
      </div>
   </div>
 </div>

 <!-- 选择管理员弹窗 -->
<!--  <div class="tuichu_ball xuanze_ball" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="xuanze_ball_title"><span>管理员选择</span><em class="icon-close close_ball"></em></div>
         <div class="guanliyuan_xuanze">
            <ul>
                <li><span><i>管理员</i><em class="icon-quanxian1"></em></span><input type="radio" class="icon-gouxuan"></li>
                <li><span><i>服务员</i><em class="icon-quanxian1"></em></span><input type="radio" class=""></li>
                <li><span><i>酋长</i><em class="icon-quanxian1"></em></span><input type="radio" class=""></li>
            </ul>
         </div>  
         <div class="guanliyuan_xuanze_a"><a href="javascript:void(0);">选择</a></div>   
      </div>
   </div>
 </div> -->

  <!-- 选择管理员弹窗 -->
 <div class="tuichu_ball xuanze_ball" style="display: none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="xuanze_ball_title"><span>管理员选择</span><em class="icon-close close_ball"></em></div>
         <div class="guanliyuan_xuanze">
            <ul>
              <?php foreach($role_list as $key => $val):?>

                <?php if($key == 0):?>
                  <li item="<?php echo $val['id'];?>" module_id = "<?php echo $val['module_id'];?>">
                    <span><i><?php echo $val['name'];?></i><em remark="<?php echo $val['remark']; ?>" class="icon-quanxian1"></em></span>
                      <input type="radio"  value="" class="icon-gouxuan">
                  </li>
                <?php else:?>

                <li item="<?php echo $val['id'];?>" module_id = "<?php echo $val['module_id'];?>">
                  <span><i><?php echo $val['name'];?></i><em remark="<?php echo $val['remark']; ?>" class="icon-quanxian1"></em></span>
                    <input type="radio"  value="">
                </li>
              <?php endif;?>
                <!-- <li><span><i>服务员</i><em class="icon-quanxian1"></em></span><input type="radio" class=""></li>
                <li><span><i>酋长</i><em class="icon-quanxian1"></em></span><input type="radio" class=""></li> -->
              <?php endforeach;?>
            </ul>
         </div>  
         <div class="guanliyuan_xuanze_a"><a href="javascript:void(0);">选择</a></div>   
      </div>
   </div>
 </div>

  <!-- 权限弹窗 -->
 <div class="tuichu_ball quanli_ball manage_auth" style="display:none;">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="xuanze_ball_title" style="background:#fff;border-bottom: 1px solid #ddd;"><span>酋长权限</span><em class="icon-close close_ball01" style="color:#000000;"></em></div>
         <div class="quanli_ball_text">
            <span>   </span>
         </div>  
      </div>
   </div>
 </div>

<script type="text/javascript">


  $(".guanliyuan_xuanze_a").click(function(){

    // 获取管理员角色
    var role_id = $(this).prev().find('.icon-gouxuan').parent('li').attr("item");
    // console.log(role_id);
    if(role_id){
      location.href='<?php echo site_url("tribe/manage_auth")."/".$tribe['id']."/1";?>'+'?role='+role_id;
    }
  });
</script>
  <!-- 创建部落 -->
  <a href="javascript:void(0);<?php //echo site_url("tribe/manage_auth")."/".$tribe['id']."/1";?>" class="circle_publish_jia custom_button">新增管理员</a>

</div>

<script type="text/javascript">

  $('.circle_publish_jia').on('click',function(){
     
    
    $(".xuanze_ball").show();

  })

  // 显示删除弹框
  var manage_id = '';
  var staff_id = '';
  function shanchu(e) {
      $('.shanchu_ball').show();
      
      staff_id = $(e).attr("staff_id");
      // console.log(staff_id);
      // return false;
      var isRun=true;
      
      var type = 'delete';
      var tribe_id = "<?php echo $tribe['id'];?>";
      var customer_id = "<?php echo $this->session->userdata('user_id');?>";
      var create_customer = "<?php echo $create_customer;?>";
      $("#tuichu_sub").on("click",function(){
         // staff_id = $(".tribe_manage_delete_status").parent().parent().attr("staff_id");
         // console.log(staff_id);
       
         // 权限校验
         // <?php //if($tribe['is_host'] != 1){ ?>
         //   $(".black_feds").text("您不是部落首领不能添加管理员").show();
         //   setTimeout("prompt();location.reload();", 1000);
         //   return false;
         

         // 防止多提点击提交
         if(!isRun){
           
            return false;
         }

         $.post(
            '<?php echo site_url('tribe/update_manage');?>',
            {staff_id:staff_id,type:type,tribe_id:tribe_id},
            function(data){
                 isRun=false;
               // console.log(data);
               if(data.code == 1){
                  $(".black_feds").text("删除成功").show();
                  setTimeout("prompt();location.reload();", 500); 
               }else{
                  $(".black_feds").text("删除失败").show();
                  setTimeout("prompt();location.reload();", 500); 
               }
             
            }
            ,'json'
         );

      });
      
  }

  // 点击取消
  $(".tribe_ball_cancel").on('click',function(){
     $('.shanchu_ball').hide();
  })


  

   // 关闭弹窗
   $(".close_ball").on("click",function(){
      $(".xuanze_ball").hide();
   })
   $(".close_ball01").on("click",function(){
      $(".quanli_ball").hide();
   })

   $(".guanliyuan_xuanze ul li").on("click",function(){
      $(this).children('input').addClass('icon-gouxuan');
      $(this).siblings('li').children('input').removeClass('icon-gouxuan');
   })
   // 权限弹窗
   $(".guanliyuan_xuanze ul li em").on("click",function(){
      $(".quanli_ball").show();
      // var module_id = $(this).parent('span').parent('li').attr('module_id');
      var manage_name = $(this).prev().text();
      $(".manage_auth").find(".xuanze_ball_title").find("span").text(manage_name+"权限");
      var remark = $(this).attr("remark");
      // console.log(remark);
      $(".manage_auth").find(".quanli_ball_text").find("span").html(remark);
      // $.post(
      //   "<?php //echo site_url('tribe/ajax_manager_auth');?>",
      //   {id:module_id},
      //   function(data){
      //     if(data.status == 1){
      //       var html = '';
      //       $.each(data.data,function(i,n){

      //         html += n['module_name']+',';
      //       });

      //       html = html.substr(0, html.length - 1); 
      //       
      //     }
      //   },
      //    'json'
      // );
     
   })

</script>



