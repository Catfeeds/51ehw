
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
<style>
#sub{
  margin-left:10px;
  margin-right: 20px !important;
}
</style>
<?php if(count($List) < 2){?>
<style>
 #none{
  margin-top: 230px;
}
 #pag{
  margin-top: 230px;
}
#list {position: absolute;border: 1px solid #fea33b;width: 278px;top: 24px;background: #fff;z-index: 99;border-top: none;height: 300px;overflow-y: scroll;overflow-x: hidden;}
#list li {float: none;text-align: center;border-bottom: 1px solid #fea33b;width: 278px;overflow: hidden;padding: 5px 0;cursor: pointer;}
#list li:last-child {border-bottom: none;}
#list li:hover {background: #ffe3c5;}
#zuyuan {display: none;}
#zuyuan ::-webkit-scrollbar {width: 0;}

#list_juese {position: absolute;border: 1px solid #fea33b;width: 278px;top: 24px;background: #fff;z-index: 99;border-top: none;height: 300px;overflow-y: scroll;overflow-x: hidden;}
#list_juese li {float: none;text-align: center;border-bottom: 1px solid #fea33b;width: 278px;overflow: hidden;padding: 5px 0;cursor: pointer;}
#list_juese li:last-child {border-bottom: none;}
#list_juese li:hover {background: #ffe3c5;}
#zuyuan_juese {display: none;}
#zuyuan_juese ::-webkit-scrollbar {width: 0;}

.nice-select1 input {text-indent: 10px;width: 255px;}
</style>
<?php }?>
<div class="Box member_Box clearfix">
  <?php  $this->load->view('tribe/left_nav');?>

  <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
    <div class="cmRight_tittle"><?php if(isset($staff_access)){ echo '编辑管理员';}else{echo '新增管理员';}?></div>
    <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
                <div class="select2" style="margin-left: 80px;">
               
                <div class="nice_top" style="margin-bottom: 166px;">
         <div class="tribal_add_manager"><span>族员：</span>
           <div style="position: relative;float: left;">
             <div class="nice-select1" name="nice-select" style="width: 278px;">
               <div id="form"><form class="filterform" action="#"><input class="filterinput" type="text" value="<?php if(isset($staff_access)){ echo  $staff_access['member_name'];}?>"  <?php if(isset($staff_access)){echo  'disabled';}?> ></form></div>
           </div>
           <?php if(!isset($staff_access)){ ?>
               <div id="zuyuan">
                   <ul id="list"> 
                   		<?php if(count($tribe_staff_list) >0 ){
                   		    foreach ($tribe_staff_list as $key =>$val){ ?>
                   		        	<li data-value="<?php echo $val['id']?>"><a><?php echo $val['member_name']?></a></li>
                   		<?php 
                   		    }
                   		}?>
                      
                   </ul>   
          	   </div>  
           <?php }?>
           </div>
          </div>

         <div class="tribal_add_manager"><span>角色：</span>
           <div style="position: relative;float: left;">
             <div class="nice-select1" name="nice-select" style="width: 278px;">
               <div id="form_juese"><form class="filterform" action="#"><input class="filterinput_juese" type="text" value="<?php if(isset($staff_access)){ echo $staff_access['role_name'];}?>"></form></div>
           </div>
           <div id="zuyuan_juese">
           <ul id="list_juese"> 
                <?php if(count($role_list) >0 ){
           		    foreach ($role_list as $key =>$val){ ?>
           		        	<li data-value="<?php echo $val['id']?>"><a><?php echo $val['name']?></a></li>
           		<?php 
           		    }
           		}?>
           </ul>   
           </div>  
           </div>


          </div>
          <input type="hidden" id ="staff_set" value="<?php if(isset($staff_access)){echo $staff_access['id'];}?>">	
          <input type="hidden" id ="role_set" value="<?php if(isset($staff_access)){echo $staff_access['tribe_role_access_id'];}?>">	
         
          <div class="tribal_add_role"><span style="padding-left: 15px;">备注：</span><input id="remark" type="text" value="<?php if(isset($staff_access)){echo $staff_access['remark'];}?>" ></div>
          <div class="tribal_add_role_save" style="margin-left: 154px;"><button id="save">保存</button></div>
                 </div>
   
                    
   
                                        
      </div>
    </div>
  </div>



</div>


<script type="text/javascript">
  $("#form").on("click",function(){
    $("#zuyuan").show();
    $("#zuyuan_juese").hide();
  })
  $("#zuyuan ul li").on("click",function(){
    $("#zuyuan").hide();
    $("#staff_set").val($(this).attr("data-value"));
    $(".filterinput").val($(this).text());
  })

  $("#form_juese").on("click",function(){
    $("#zuyuan_juese").show();
    $("#zuyuan").hide();
  })
  $("#zuyuan_juese ul li").on("click",function(){
    $("#zuyuan_juese").hide();
    $("#role_set").val($(this).attr("data-value"));
    $(".filterinput_juese").val($(this).text());
  })




  $("body").on("click",function(){
    $("#zuyuan").hide();
    $("#zuyuan_juese").hide();
  })

   $("#save").on("click",function(){

	   <?php if(isset($staff_access)){//编辑?>
		   var staff_set = $("#staff_set").val();
	       var role_set = $("#role_set").val();
	       if(!role_set){
	           alert("请选择角色！");
	           return;
	       }
	       var remark = $("#remark").val();
	       $.ajax({
	           url:'<?php echo site_url('Tribe/ajax_update_staff_role');?>',
	           type:'post',
	           dataType:"json",
	           data:{
	               staff_id:staff_set,role_id:role_set,remark:remark
	           },
	           success:function(data){
	               if(data.status == 0 || data.status == '0' ){
	                   alert("保存成功！");
	                   setTimeout(function(){
	                       window.location.href='<?php echo site_url("Tribe/adminList");?>';
	                   },2000);
	               }else{
	                   alert("保存失败！");
	               }
	           },
	           error:function(){
	               alert("网络错误");
	           }
	       });
	       
	   <?php }else{ ?>
	       var staff_set = $("#staff_set").val();
	       var role_set = $("#role_set").val();
	       if(!staff_set){
	           alert("请选择族员！");
	           return;
	       }
	       if(!role_set){
	           alert("请选择角色！");
	           return;
	       }
	       var remark = $("#remark").val();
	       $.ajax({
	           url:'<?php echo site_url('Tribe/ajax_save_staff_role');?>',
	           type:'post',
	           dataType:"json",
	           data:{
	               staff_id:staff_set,role_id:role_set,remark:remark
	           },
	           success:function(data){
	               if(data.status == 0 || data.status == '0' ){
	                   alert("保存成功！");
	                   setTimeout(function(){
	                       window.location.href='<?php echo site_url("Tribe/adminList");?>';
	                   },2000);
	               }else{
	                   alert("保存失败！");
	               }
	           },
	           error:function(){
	               alert("网络错误");
	           }
	       });
	   <?php }?>
			
   });
</script>



<script> 
(function ($) {
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };
  function filterList(header, list) { 
  // var form = $("<form>").attr({"class":"filterform","action":"#"}),
  // input = $("<input>").attr({"class":"filterinput","type":"text"});
  // $(form).append(input).appendTo(header);
  $('.filterinput')
      .change( function () {
        var filter = $(this).val();
        if(filter) {
      $matches = $(list).find('a:Contains(' + filter + ')').parent();
      $('li', list).not($matches).slideUp();
      $matches.slideDown();
        } else {
          $(list).find("li").slideDown();
        }
        return false;
      })
    .keyup( function () {
        $(this).change();
    });
  }
  $(function () {
    filterList($("#form"), $("#list"));
  });
}(jQuery));
</script> 

<script>  
$('[name="nice-select"]').click(function(e){
  $('[name="nice-select"]').find('ul').hide();
  $(this).find('ul').show();
  e.stopPropagation();
});
$('[name="nice-select"] li').hover(function(e){
  $(this).toggleClass('on');
  e.stopPropagation();
});
$('[name="nice-select"] li').click(function(e){
  var val = $(this).text();
  var dataVal = $(this).attr("data-value");
  $(this).addClass('bg-color').siblings().removeClass('bg-color');
   /*$(this).addClass("on").siblings("on").removeClass("on");*/
  $(this).parents('[name="nice-select"]').find('input').val(val);
  $('[name="nice-select"] ul').hide();
  e.stopPropagation();
  $('#form_search').submit();
});
$(document).click(function(){
  $('[name="nice-select"] ul').hide();
  
});
</script>
