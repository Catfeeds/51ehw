
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>
<style>
#sub{
  margin-left:10px;
  margin-right: 20px !important;
}

</style>
<?php if(count($role_list) < 2){?>
<style>
 #none{
  margin-top: 230px;
}
 #pag{
  margin-top: 230px;
}
</style>
<?php }?>
<div class="Box member_Box clearfix">
 <?php  $this->load->view('tribe/left_nav');?>

  <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
    <div class="cmRight_tittle">角色权限列表</div>
    <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
         <form  action="<?php echo site_url('tribe/members') ?>"  method="get" id="form_search">
        <div class="members_b">
             <!-- 
                <input  type="text" class="members_in" name="search_name" value="<?php echo isset($search_name)?$search_name:'' ?>" placeholder="请输入搜索关键字 (用户ID、族员名称、用户ID 或 用户名)" style="width:400px;">
                <a href="javascript:;" onclick="submit();" id="sub" >查询</a>
               -->
              <a href="<?php echo site_url("Tribe/adminRoleSet");?>">新增角色</a>
        </div>
                <div class="select2">
                <div class="nice_top">
<!--          <div class="nice-select1" name="nice-select">
                   <input name="times" id="times" type="text" placeholder="显示全部时间" value="<?php echo isset($times)?$times:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">显示全部</li>
                          <li data-value="2">近7天内</li>
                          <li data-value="3">近一个月内</li>
                          <li data-value="4">3个月内</li>
                          <li data-value="5">半年内</li>
                          <li data-value="6">1年内</li>
                        </ul>
             </div> -->
                 </div>
              <div class="haudong_top">   
        <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1">
        <tbody>
          <tr class="tr3 tribal_role_permission_list manage_b_tr1">
            <th width="152px">ID</th>
            <th width="200px">角色</th>
            <th width="250px">时间</th>
            <th width="180px">操作</th>
          </tr>
          
          <?php if(count($role_list) > 0 ){
              foreach ($role_list as $key =>$val){ 
                  ?>
                  <tr class="tr3 tribal_role_permission_list">
                  <th width="152px"><?php echo $val['id'];?></th>
                  <th width="200px"><?php echo $val['name'];?></th>
                  <th width="250px"><?php echo $val['created_at'];?></th>
                  <th width="180px"><a href="<?php echo site_url("Tribe/adminRoleSet").'/'.$val['id'];?>">编辑</a><a href="javascript:del(<?php echo $val['id'];?>);">删除</a></th>
                  </tr>
              
          <?php          
            }
          }?>
          
        </table>
                     </div>     
                    

                                        
      </div>
    </div>
     </form>
  </div>



</div>

<script>  
function del(id){
	  $.ajax({
	    url:'<?php echo site_url('Tribe/ajax_del_role');?>',
	    type:'post',
	        dataType:"json",
	        data:{id:id},
	            success:function(data){
	           		 alert(data.Message);
	           		 if(data.status == 0 || data.status =="0"){
	               		 setTimeout(function(){
							window.location.reload();
	                   		 },2000);
	               		 }
	            },
	          error:function(){
	        	  alert("网络错误");
	            }
	    });
	}
function submit(){
  $('#form_search').submit();
}
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
