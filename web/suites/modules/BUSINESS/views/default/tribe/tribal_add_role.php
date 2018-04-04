
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>

<?php if(count($List) < 2){?>
<style>
 #none{
	margin-top: 230px;
}
 #pag{
	margin-top: 230px;
}
 .shu_list {float: left;} 
 .shu_list th {display: block;border-right: none;border-top: none;}
 .table2.manage_b_table1 {border:none;}
 .table2.manage_b_table1 th {box-sizing: border-box;line-height: 40px;}
 .shu_box tbody tr:last-child th {border-right: 1px solid #fea33b;}
 .shu_box tbody tr th:nth-child(1) {border-top: 1px solid #fea33b;}
 .shu_list02 th {display: inline-block;border-bottom: none;border-right: none;}
 .shu_list02 th:last-child {border-right: 1px solid #fea33b;}

</style>
<?php }?>

<div class="Box member_Box clearfix">
	<?php  $this->load->view('tribe/left_nav');?>

	<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">新增角色</div>
		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
       <div class="select2">
        <div class="tribal_add_role"><span>角色名称：</span><input type="text" value="<?php if(isset($detail)){ echo $detail['name']; }?>" name="module_name" placeholder="请填写角色名称"></div>
        <div class="haudong_top1">   
		<table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1" hidden>
        <tbody>
          <tr class="tr3 tribal_add_role_list">
        
<!--             <th width="100px"><input type="checkbox" value="" class="change" name="staff" >族员管理</th> -->
<!--             <th width="100px"><input type="checkbox" value="" class="change" name="product" >商品管理</th> -->
<!--             <th width="100px"><input type="checkbox" value="" class="change" name="activity" >活动管理</th> -->
<!--             <th width="100px"><input type="checkbox" value="" class="change" name="notice" >公告管理</th> -->
<!--             <th width="100px"><input type="checkbox" value="" class="change" name="circle" >圈子管理</th> -->
          </tr>
<!--           <tr class="tr3 tribal_add_role_list"> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_staff" disabled>加入部落审核</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_product" disabled>部落商品上架</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_activity" disabled>新增活动</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_notice" disabled>新增公告</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_circle" disabled>置顶话题</th> -->
<!--           </tr> -->
<!--           <tr class="tr3 tribal_add_role_list"> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_staff" disabled>删除族员</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_product" disabled>部落商品下架</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_activity" disabled>活动审核</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_notice" disabled>删除公告</th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_circle" disabled>删除话题</th> -->
<!--           </tr> -->
<!--           <tr class="tr3 tribal_add_role_list"> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_product" disabled>商品排序</th> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_circle" disabled>圈子管理</th> -->
<!--           </tr> -->
<!--           <tr class="tr3 tribal_add_role_list"> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"></th> -->
<!--             <th width="100px"><input type="checkbox" value="" name="_circle" disabled>查看举报信息</th> -->
<!--           </tr> -->
        </table>

        <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1">
        	<tbody>
        		<tr class="tr3 tribal_add_role_list shu_list02">
           <?php if(count($role) > 0){
              foreach ($role as $key =>$val){ 
             ?>
              <th><input type="checkbox" value="" class="change"   <?php if(isset($detail) && is_numeric(strpos($detail['module_id'], $val['id']))){ echo 'checked'; }?>   name="<?php echo $val['id'];?>" ><?php echo $val['module_name']; ?></th>
          <?php       
              }
          }?>
          </tr>
        	</tbody>
        </table>
        <table width="910" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1 shu_box">
        <tbody>
		<?php foreach ($role as $key =>$val){ 
		    foreach ($role_child as $key1 =>$val1){
		        if($val['id'] ==  $key1){
		            ?>
		             <tr class="tr3 tribal_add_role_list shu_list">
		             <?php for($i=0;$i < $child_num;$i++){
		                  if(isset($val1[$i]['module_name']) && !empty($val1[$i]['module_name'])){?>
		                       <th><input type="checkbox" value=""  name="_<?php echo $val['id'];?>" <?php if(isset($detail) && is_numeric(strpos($detail['module_id'], $val['id']))){ echo 'checked'; }?>  disabled><?php echo $val1[$i]['module_name']?></th>
		                 <?php  }else{?>
		                      <th></th>
		              <?php }     
		               
		              }?>
		            </tr>
		<?php   }
	        } 
		}?>	
         
        </tbody></table>








        </div>     
         <div class="tribal_add_role_save"><button id="save">保存</button></div>
			</div>
		</div>
		
	</div>



</div>
<script type="text/javascript">
	var length = $(".shu_list").length;
	$('.shu_list th').css("width",(910/length));
	var length = $(".shu_list02 th").length;
	$('.shu_list02 th').css("width",(910/length));
</script>





<script>
$(".change").click(function(){
	var obj = $(this).attr("name")
	var isChecked = $(this).prop("checked");
	if(isChecked){
		$(this).prop("checked", isChecked);
		$("input[name='_"+obj+"']").prop("checked", isChecked);
		}else{
			$(this).prop("checked", isChecked);
			$("input[name='_"+obj+"']").prop("checked", isChecked);
			}
});
$("#save").click(function(){
	var role_str = '';	
	 <?php if(count($role) > 0){
            foreach ($role as $key =>$val){ 
           ?>
           var role_<?php echo $val['id']?> = $("input[name='<?php echo $val['id']?>']").prop("checked");
           if(role_<?php echo $val['id']?>){
          	 role_str += '<?php echo $val['id']?>,';
               }
  <?php 
      }
    }?>
	if(role_str == ''){
		 alert("请选择新增角色的权限");
		 return;
		}
	var name  =$("input[name='module_name']").val();
	if(name == ""){ 
		alert("请填写角色的名称");
	    return;
		}
	
	$.ajax({
		<?php if(isset($detail)){ ?>
		 url:'<?php echo site_url('Tribe/ajax_update_role');?>',
		<?php }else{ ?>
		 url:'<?php echo site_url('Tribe/ajax_save_role');?>',
		<?php }?>
	        type:'post',
	        dataType:"json",
	        data:{
	        	<?php if(isset($detail)){ ?>
	        	 module_str:role_str,name:name,id:<?php echo $detail['id']?>
	        	<?php }else{ ?>
		        module_str:role_str,name:name
		        <?php }?>
		        },
	        success:function(data){
		        if(data.status == 0 || data.status == "0"){
		        	 alert(data.Message);
		        	 setTimeout(function(){
						window.location.href = '<?php echo site_url("Tribe/adminRoleList");?>';
			        	 },1500);
			        }else{
			        	 alert(data.Message);
			        	  }
		        },
	        error:function(){
	        	 alert("网络错误");
		        }
		});
});

</script>
