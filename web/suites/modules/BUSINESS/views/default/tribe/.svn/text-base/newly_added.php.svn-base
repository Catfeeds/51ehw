
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="js/chosen.jquery.js"></script>

<div class="Box member_Box clearfix">
	<?php  $this->load->view('tribe/left_nav');?>
	<!-- <div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>义工委</a></li>
			<li ><a href="<?php //echo site_url('tribe/lists')?>">部落息</a></li>
			<li ><a href="<?php //echo site_url('tribe/products')?>">部落推荐商品</a></li>
			<li class="kehu_current"><a href="<?php //echo site_url('tribe/members')?>">部落成员</a></li>
		</ul>
		
	</div> -->
	<div class="huankuan_cmRight">
		<div class="huankuan_tribe">部落成员</div>
		   <div class="tribe_nei">
             <ul>
              
               <li class="tribe_nei_lix">
                  <span>企业名称：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入您的企业名称" value="<?php echo isset($tribe_info['corporation_name'])? $tribe_info['corporation_name']:'';?>" name="corp_name">
               </li>
                <li class="tribe_nei_lix">
                  <span>姓名：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入您的姓名" value="<?php echo isset($tribe_info['member_name'])? $tribe_info['member_name']:'';?>" name="user_name"  onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" onpaste="value=value.replace(/[^\u4E00-\u9FA5]/g,'')"  oncontextmenu="value=value.replace(/[^\u4E00-\u9FA5]/g,'')">
               </li>
                <li class="tribe_nei_lix">
                  <span>职位：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入您的职位" value="<?php echo isset($tribe_info['duties'])? $tribe_info['duties']:'';?>" name="duties">
               </li>
                <li class="tribe_nei_lis"> 
                  <span>所在地区：</span>
                  <select class="tribe_nei_inputz" id="province_" name="province"> 
                    <?php if(isset($tribe_info['provice'])){
                        foreach($region as $key => $province): ?>
                        <option value="<?php echo $province['region_name']; ?>" <?php if($province['region_name']==$tribe_info['provice']){echo 'selected';}?> ><?php echo $province['region_name']; ?></option>
                        <?php  endforeach; ?>
                    <?php }else{?>
                    <option value="">省份</option> 
                        <?php 
                         foreach ($region as  $key =>$val){ ?>
                        <option value="<?php echo $val['region_name']; ?>" ><?php echo $val['region_name']; ?></option>
                         <?php }
                    }?>
                 </select> 
                 <select class="tribe_nei_inputz" id="city_" name="city"> 
                  <?php if($tribe_info['city']){ 
                          foreach ($city_info as  $key =>$val){ ?>
                          <option value="<?php echo $tribe_info['city'];?>"<?php if($val['region_name']==$tribe_info['city']){ echo 'selected';}?> ><?php echo $val['region_name']?></option> 
                    <?php  } ?>
                 <?php  }?>
                 </select> 
               </li>
                <!--  <li class="tribe_nei_lix">
                  <span>经营范围：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="如”服装、饮食等”" value="<?php // echo isset($tribe_info['scope'])? $tribe_info['scope']:'';?>" name="scope">
               </li>-->
                <li class="tribe_nei_lix">
                  <span>所属行业：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="如”钢铁业、饮食业等”" value="<?php echo isset($tribe_info['industry'])? $tribe_info['industry']:'';?>" name="industry">
               </li>
                <li class="tribe_nei_lix">
                  <span>自有商品描述：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="例：酒水、食品、企业服务、全品类等" value="<?php echo isset($tribe_info['own_goods'])? $tribe_info['own_goods']:'';?>" name="own_goods">
               </li>
                <li class="tribe_nei_lix">
                  <span>置换意向：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="例：酒水、食品、企业服务、全品类等" value="<?php echo isset($tribe_info['replacement_intention'])? $tribe_info['replacement_intention']:'';?>" name="replacement_intention">
               </li>
               <li class="tribe_nei_lis">
                  <span>部落名称：</span>
                  <input type="hidden" value="<?php echo $tribe_list['id'] ?>" id="tribe_id" name="tribe_id">
                  <span> <?php echo $tribe_list['name']; ?></span>
<!--                   <select class="tribe_nei_input" id="tribe_id" name="tribe_id" value="0" dir="rtl"> -->
<!--                          <option value="0">请选择部落</option> -->
<!--                          <option value="1">广州秦商会</option> -->
<!--                  </select> -->
               </li>
               <li class="tribe_nei_lis">
                  <span>部落职务：</span>
                
                     <select class="tribe_nei_input" id="tribe_role_id" name="tribe_role_id"  value="2" dir="rtl">
                     <option value="0">请选择部落职务</option>
                     
                     <?php 
                     if(count($role_info) > 0){
                         foreach ($role_info as $key =>$val){
                             if(isset($tribe_info) && $tribe_info['tribe_role_id']){
                                 if($tribe_info['tribe_role_id'] == $val['id']){?>
                                     <option value="<?php echo $val['id'];?>" selected><?php echo $val['role_name']?></option>
                                    <?php   }else{ ?>
                                   	 <option value="<?php echo $val['id'];?>"><?php echo $val['role_name']?></option>
                          		 <?php } 
                             }else{?>
                               <option value="<?php echo $val['id'];?>"><?php echo $val['role_name']?></option>
                           	<?php }?>
                                               
                      <?php } 
                     }?>
                                      </select>
                 
               </li>
              <li class="tribe_nei_lix">
                  <span>手机号：</span>
                  <?php if(isset($tribe_info['mobile'])){ ?>
                       <span> <?php echo $tribe_info['mobile']; ?></span>
                       <input class="tribe_nei_inputx" input="text" placeholder="请输入您的手机号" value="<?php echo $tribe_info['mobile'];?>" name="mobile" hidden>
                  <?php }else{ ?>
                      <input class="tribe_nei_inputx" input="text" placeholder="请输入您的手机号" value="" name="mobile">
                   <?php }?>
                  
               </li>
                <li class="tribe_nei_lix">
                  <span>希望贡献额度：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($tribe_info['hope_offer'])? $tribe_info['hope_offer']:'';?>" name="hope_offer">
               </li>
                <li class="tribe_nei_lix">
                  <span>易呗上限：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($credit)? $credit:'';?>" name="credit"><span style="margin-left: 20px;color:red;">提示：已注册用户才能设置易呗上限</span>
               </li>
               <li class="tribe_nei_lix">
                  <span>单笔担保额度：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($tribe_info['guarantee_ceiling'])? $tribe_info['guarantee_ceiling']:'';?>" name="guarantee_ceiling">
               </li>
               <li class="tribe_nei_lix">
                  <span>被担保额度：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($tribe_info['guarantee_to_ceiling'])? $tribe_info['guarantee_to_ceiling']:'';?>" name="guarantee_to_ceiling">
               </li>
                <li class="tribe_nei_lix">
                  <span>担保额度：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($tribe_info['guarantee_from_ceiling'])? $tribe_info['guarantee_from_ceiling']:'';?>" name="guarantee_from_ceiling">
               </li>
                <li class="tribe_nei_lix">
                  <span>剩余担保额度：</span>
                  <input class="tribe_nei_inputx" input="text" placeholder="请输入额度" value="<?php echo isset($tribe_info['remain_guarantee_price'])? $tribe_info['remain_guarantee_price']:'';?>" name="remain_guarantee_price">
               </li>
            
               <?php if($show){ ?>
                   <li class="tribe_nei_lis">
                  <span>审核：</span>
                  <select class="tribe_nei_input" id="status" name="status" dir="rtl">
                  <?php if(isset($tribe_info['status'])){
                      switch($tribe_info['status']){
                          case 1: ?>
                           <option value="1" selected>待审核</option>
                           <option value="2">通过</option>
                           <option value="3">不通过</option>
                         <?php      break;
                          case 2:?>
                           <option value="1">待审核</option>
                           <option value="2" selected>通过</option>
                           <option value="3">不通过</option>
                         <?php    break;
                          case 3:?>
                          <option value="1">待审核</option>
                           <option value="2">通过</option>
                           <option value="3" selected>不通过</option>
                            <?php    break;    
                      }
                  }else{?>
                     	 <option value="1">待审核</option>
                         <option value="2">通过</option>
                         <option value="3">不通过</option>
                  <?php }?>
                         
                 </select>
               	 </li>
               <?php  }?>
                 <li class="tribe_nei_lix">
                  
                       <span style="float: left; padding-left: 5px;">显示族员手机号码:</span>
                       <?php if(isset($tribe_info['show_mobile']) && $tribe_info['show_mobile'] == 1):?>
                       <input style="float: left; margin-left:-20px;" type="checkbox" id="see_status" class="aui-switch" <?php echo isset($tribe_info['show_mobile']) ? "checked" :"";?> >
                     <?php else:?>
                         <input style="float: left; margin-left:-20px;" type="checkbox" id="see_status" class="aui-switch"  >
                     <?php endif;?>
                </li>
             </ul>
           
           </div>
           <script type="text/javascript">
            var is_phone = '';

            if($("input[type='checkbox']").is(':checked')){
              is_phone = 1;
            }else{
              is_phone = 2;
            }

             $("#see_status").click(function(){
               
                if($("input[type='checkbox']").is(':checked')){
                  is_phone = 1;
                }else{
                  is_phone = 2;
                }
             });
           </script>
		<div class="gerenzhongixn_01_btn">

			<div class="gerenzhongxin_01_btn01" style="margin-left:-73px;">
				<a href="javascript:;" onclick="submit();">保存</a>
			</div>
		</div>

	</div>



</div>

<script>	
$("#province_").on("change", function(e) {
	 var s = '';
    if($('select[name="province"]').val() !=''){
        $.post('<?php echo site_url('tribe/ajax_get_city_by_name')?>',
           {
            provice_name:$('select[name="province"]').val()
            },
        function (data) {
            if(data){
                for(var i=0;i<data.length;i++){
                    s+='<option value='+data[i]["region_name"]+'>'+data[i]["region_name"]+'</option>';
                }
                $('#city_').html(s);
             }
        },'json');
    }else{
    	$('#city_').html(s);
        }
})


function submit(){
	
	if($('input[name="corp_name"]').val()==''){
		 alert("请输入您的企业名称");return;
		 }
	 if($('input[name="user_name"]').val()==''){
		 alert("请输入您的姓名");return;
		 }
	 // if($('input[name="duties"]').val()==''){
		//  alert("请输入您的职务");return;
		//  }
	 if($('select[name="province"]').val()=='' ||  $('select[name="city"]').val()=='' ){
		 alert("请输入您的省份城市");return;
		 }
	 if($('input[name="scope"]').val()==''  ){
		 alert("请输入您的经营范围 ");return;
		 }
	 if($('select[name="tribe_id"]').val()== 0 ){
		 alert("请选择部落");return;
		 }
// 	 if($('select[name="tribe_role_id"]').val()== 0 ){
// 		 alert("请选择部落职务");return;
// 		 }
	 // if($('input[name="mobile"]').val()== ''){
		//  alert("请输入您的手机号");return;
		//  }

  var reg_mobile = /^0{0,1}(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[0-9])[0-9]{8}$/;
	 // 手机号码
 	if(!reg_mobile.test($('input[name="mobile"]').val())){
		 alert("请输入正确的手机号");return;
 	 	}
 	
    var corp_name = $('input[name="corp_name"]').val();
    var user_name = $('input[name="user_name"]').val();
    var duties = $('input[name="duties"]').val();
    var province = $('select[name="province"]').val();
    var city = $('select[name="city"]').val();
    var scope = $('input[name="scope"]').val();
    var tribe_id = $('input[name="tribe_id"]').val();
    var tribe_role_id = $('select[name="tribe_role_id"]').val();
    var mobile = $('input[name="mobile"]').val();
    var hope_offer = $('input[name="hope_offer"]').val();
    var credit = $('input[name="credit"]').val();
    var guarantee_ceiling = $('input[name="guarantee_ceiling"]').val();
    var guarantee_to_ceiling = $('input[name="guarantee_to_ceiling"]').val();
    var guarantee_from_ceiling = $('input[name="guarantee_from_ceiling"]').val();
    var remain_guarantee_price = $('input[name="remain_guarantee_price"]').val();
    var industry = $('input[name="industry"]').val();
    var own_goods = $('input[name="own_goods"]').val();
    var replacement_intention = $('input[name="replacement_intention"]').val();

    <?php if($check_mobile){ ?>
    var type= false;
    $.ajax({
		 url:'<?php echo site_url('Tribe/ajax_check_mobile');?>',
		 type:'post',
		 async: false,      //ajax同步  
		 data:{mobile:mobile,tribe_id:tribe_id,type:4},
		 dataType:"json",
		 success:function(data){
			 if(data.Result == true){ 
				 alert("该手机号已绑定部落成员了！");
				 return;
				 }else{
					 type= true;
					 var status = $('select[name="status"]').val();
					 }
			        },
		 error:function(data){
			
			 }		        
		});
    <?php  }else{ ?>
    var type= true;
    var status = $('select[name="status"]').val();
    <?php }?>
    
	if(type){
       <?php if(!$check_mobile){//更新 ?>
         
    	   $.ajax({
    			 url:'<?php echo site_url('Tribe/ajax_update_members');?>',
    		        type:'post',
    		        async: false,      //ajax同步  
    		        dataType:"json",
    		        data:{corp_name:corp_name,user_name:user_name,duties:duties,province:province,status:status,id:<?php echo $tribe_info['id']?>,
    		        	city:city,scope:scope,tribe_id:tribe_id,tribe_role_id:tribe_role_id,mobile:mobile,hope_offer:hope_offer,tribe_id:<?php echo $tribe_list['id']?>,
    		        	credit:credit,guarantee_ceiling:guarantee_ceiling,guarantee_to_ceiling:guarantee_to_ceiling,guarantee_from_ceiling:guarantee_from_ceiling,
    		        	remain_guarantee_price:remain_guarantee_price,industry:industry,own_goods:own_goods,replacement_intention:replacement_intention,is_phone:is_phone
    			        },
    		        success:function(data){
        		        // if(data.status == true){
      		        	 //  	 alert("更新信息成功！");
            		    //     }
                     alert("更新信息成功！");
    			        },
    		        error:function(){
    			        }
    			});
       <?php }else{?>

        var member_type = '';
        if(is_phone == 2){
           member_type = 'prepare'; // 预录入部落成员
        }
       
		$.ajax({
			 url:'<?php echo site_url('Tribe/ajax_add_members');?>',
		        type:'post',
		        async: false,      //ajax同步  
		        dataType:"json",
		        data:{corp_name:corp_name,user_name:user_name,duties:duties,province:province,
		        	city:city,scope:scope,tribe_id:tribe_id,tribe_role_id:tribe_role_id,mobile:mobile,hope_offer:hope_offer,
		        	credit:credit,guarantee_ceiling:guarantee_ceiling,guarantee_to_ceiling:guarantee_to_ceiling,guarantee_from_ceiling:guarantee_from_ceiling,
		        	remain_guarantee_price:remain_guarantee_price,industry:industry,own_goods:own_goods,replacement_intention:replacement_intention,is_phone:is_phone,member_type:member_type
			        },
		        success:function(data){
			        if(data.status == true){
			        	 alert("录入成功！");
				        }else{
				        	  alert("录入失败！");
				        	  }
			        },
		        error:function(){
			        }
			});
		<?php }?>
	}
	
}

</script>
