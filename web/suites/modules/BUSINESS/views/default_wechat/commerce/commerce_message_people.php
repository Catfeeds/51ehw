<style type="text/css">
   .container {background: #fff;}
</style>


<!-- 商会通知—接收人列表 -->
<div class="commerce_index" id="SendeeList" hidden>
	<div class="commerce_message_people">
        <div class="commerce_message_people_nav">
            <ul>
                <li class="commerce_message_more" onclick="commerce_message_more();"><input type="checkbox" value="" id="checkall"><span>全部选择</span></li>
                <li class="commerce_message_nav"><input type="checkbox" value="" ><span>按照组织架构选择</span></li>
            </ul>
        </div>
        <!-- 列表 -->
        <div class="commerce_message_list">
        <ul id="MemberList">
        	<?php $array = array();foreach($staff_list as $v){;?>
        	<?php 
        	$name = ($v["real_name"]?$v["real_name"]:$v["member_name"]);
        	//形成组织架构的数据
        	$array[$v["tribe_role_id"]]["role_name"] = $v["role_name"]?$v["role_name"]:"部落成员";
            $array[$v["tribe_role_id"]]["name"][$v["id"]] = $v["real_name"]?$v["real_name"]:$v["member_name"];
            
            //判断是否选中
            $isexist = false;
            if($info){
                $isexist = (strpos(",".$info["sendee_id"].",",",".$v["id"].",")) !== false?true:false;
            }
            ?>
            <li class="commerce_nav_list" onclick="commerce_nav_list(this,1)">
            	<a href="javascript:void(0);" class="<?php echo $isexist?"commerce_message_people_active":false;?>">
                	<input type="checkbox" name="sendee_id[]" id="<?php echo "MemberList_".$v["id"];?>" class="<?php echo "staff_".$v["id"];?>" value="<?php echo $v["id"];?>" <?php echo $isexist?"checked":false;?>>
            		<span class="commerce_yuan"><?php echo mb_substr($name,0,1);?></span><span class="commerce_notice_name" style="letter-spacing: 0;"><?php echo $name;?></span>
        		</a>
    		</li>
            <?php };?>
        </ul>
        </div>
        
        <!-- 按照组织架构选择 -->
        <div class="commerce_message_organization_choice" style="display: none;" >
        	<?php foreach ($array as $role_id => $value){?>
        	<div class="commerce_message_organization">
            	<div class="commerce_organization_head" onclick="commerce_organization_head(this);"><a href="javascript:void(0);" ><em></em><input type="checkbox" value=""><span class="" style="letter-spacing: 0;"><?php echo $value["role_name"];?></span></a></div>
                <div class="commerce_organization_box">
                <ul class="organization">
                	<?php foreach($value["name"] as $staff_id => $name){?>
                  	<li class="commerce_nav_list" onclick="commerce_nav_list(this,2)">
                  		<a href="javascript:void(0);" >
                  		<em></em><input type="checkbox" name="sendee_id[]" class="<?php echo "staff_".$staff_id;?>" value="<?php echo $staff_id;?>" id="<?php echo "organization_".$staff_id;?>" >
                  		<span style="letter-spacing: 0;"><?php echo $name;?></span>
                  		</a>
              		</li>
                	<?php };?>
                </ul>
                </div>  
            </div>
            <?php };?>
        </div>
        
        <!-- 
        
        <div class="commerce_message_organization_choice" style="display: none;" >
        	<?php foreach ($array as $role_id => $value){?>
        	<div class="commerce_message_organization">
            	<div class="commerce_organization_head" onclick="commerce_organization_head(this);"><a href="javascript:void(0);" ><em></em><input type="checkbox" value=""><span class="" style="letter-spacing: 0;"><?php echo $value["role_name"];?></span></a></div>
                <div class="commerce_organization_box">
                <ul class="organization">
                	<?php foreach($value["name"] as $staff_id => $name){?>
                  	<li class="commerce_nav_list" onclick="commerce_nav_list(this,2)">
                  		<a href="javascript:void(0);" class="<?php echo $isexist?"commerce_message_people_active":false;?>">
                  		<em></em><input type="checkbox" name="sendee_id[]" class="<?php echo "staff_".$staff_id;?>" value="<?php echo $staff_id;?>" id="<?php echo "organization_".$staff_id;?>" <?php echo $isexist?"checked":false;?>>
                  		<span style="letter-spacing: 0;"><?php echo $name;?></span>
                  		</a>
              		</li>
                	<?php };?>
                </ul>
                </div>  
            </div>
            <?php };?>
        </div>
         -->

         <!-- 确认发布 -->
         <div class="commerce_message_footer">
           <a href="javascript:void(0);" id="Determine" onclick="toggles();">确认发布（已选0人）</a>
         </div>
   </div>
</div>




<script type="text/javascript">
//点击选择联系人 
function commerce_nav_list(obj,type){
    $(obj).children('a').toggleClass('commerce_message_people_active');
    //表单选中or取消选中
    if($(obj).children('a').hasClass('commerce_message_people_active') == true){
//     	$(obj).children('a').children('input').prop("checked",true);
    	var sendee_id = $(obj).children('a').children('input').val();
    	$(".staff_"+sendee_id).prop("checked",true);
    }else{
//     	$(obj).children('a').children('input').prop("checked",false);
    	var sendee_id = $(obj).children('a').children('input').val();
    	$(".staff_"+sendee_id).prop("checked",false);
    }


    //判断是否全选角色
	if(type == 2){
		var flag = true;//默认角色全选中
		$(obj).parent().each(function(i){
			$(this).children().children().children('input').each(function(){
				if(!$(this).is(':checked')){
					flag = false;
				}
			});
		});
		if(flag){
			$(obj).parents('.commerce_organization_box').prev().children('a').addClass('commerce_message_people_active');
		}else{
			$(obj).parents('.commerce_organization_box').prev().children('a').removeClass('commerce_message_people_active');
		}
    }
    
    SelectedNumber();//选中人数
}

// 点击全选联系人
function commerce_message_more(status){    
	if(!status){
    	$('.commerce_message_more').toggleClass('commerce_message_people_active');
	}
    if($('.commerce_message_more').hasClass('commerce_message_people_active')==true || status){
        $(".commerce_nav_list a").addClass('commerce_message_people_active'); 
        $(".commerce_organization_head a").addClass('commerce_message_people_active'); 
        $(".commerce_organization_box ul li a").addClass('commerce_message_people_active'); 
        $("#checkall").prop("checked",true);
    }else{ 
        $(".commerce_nav_list a").removeClass('commerce_message_people_active'); 
        $(".commerce_organization_head a").removeClass('commerce_message_people_active'); 
        $(".commerce_organization_box ul li a").removeClass('commerce_message_people_active'); 
        $("#checkall").prop("checked",false);
    } 

	//表单全选or反选
    $('input[name="sendee_id[]"]').each(function(){
    	if($('.commerce_message_more').hasClass('commerce_message_people_active')==true || status){
			$(this).prop("checked",true);
    	}else{
    		$(this).prop("checked",false);
    	}
    });
    SelectedNumber();//选中人数
}

//点击选择角色
function commerce_organization_head(obj){
    $(obj).children('a').toggleClass('commerce_message_people_active');
    if($(obj).children('a').hasClass('commerce_message_people_active')==true){
  		$(obj).siblings('.commerce_organization_box').children('ul').find('a').addClass('commerce_message_people_active').children('input').each(function(){
			$(".staff_"+$(this).val()).prop("checked",true);
  		});
    }else{ 
  		$(obj).siblings('.commerce_organization_box').children('ul').find('a').removeClass('commerce_message_people_active').children('input').each(function(){
  			$(".staff_"+$(this).val()).prop("checked",false);
  		});
	}
    SelectedNumber();//选中人数
}


// 按照组织架构选择
$(".commerce_message_nav").click(function(){ 
	//判断是否全选
	var is_checkall = $("#checkall").is(":checked");
	if(is_checkall){
		commerce_message_more(true);
	}
    $('.commerce_message_organization_choice').toggle();
    $('.commerce_message_list').toggle();
    $('.commerce_message_nav').toggleClass('commerce_message_people_active');
    
    if($('.commerce_message_nav').hasClass('commerce_message_people_active')==true){
        $("#MemberList").children().children().removeClass('commerce_message_people_active');
        $("#MemberList").children().children().children("input").each(function(i){  
            var id = $(this).val();
            if($(this).is(":checked")){
            	$("#organization_"+id).parent().addClass('commerce_message_people_active');
				$("#organization_"+id).prop("checked",true);
				
            }else{
            	$("#organization_"+id).parent().removeClass('commerce_message_people_active');
				$("#organization_"+id).prop("checked",false);
            }
        	$(this).prop("checked",false);
        });

        //循环判断是否全选角色
        $(".organization").each(function(){
            var flag = true;
        	$(this).children().children().children("input").each(function(){
        		if(!$(this).is(":checked")){
        			flag = false;
                }
			});
			if(flag){
				$(this).parent().prev().children("a").addClass('commerce_message_people_active');
			}
        });
        
    }else{ 
        $(".commerce_organization_head a").removeClass('commerce_message_people_active'); 
        $(".organization").each(function(){
        	$(this).children().children().children("input").each(function(){
        		var id = $(this).val();
        		if($(this).is(":checked")){
                	$("#MemberList_"+id).parent().addClass('commerce_message_people_active');
    				$("#MemberList_"+id).prop("checked",true);
    				
                }else{
                	$("#MemberList_"+id).parent().removeClass('commerce_message_people_active');
    				$("#MemberList_"+id).prop("checked",false);
                }
    		});
			$(this).children().children().removeClass('commerce_message_people_active');
			$(this).children().children().children("input").prop("checked",false);
        });
    } 
    SelectedNumber();//选中人数
});

//选中人数
function SelectedNumber(){
	var count = '<?php echo count($staff_list)?>';//总人数
	var total = 0;
	var arr = new Array();

    $('input[name="sendee_id[]"]').each(function(){
        var sendee_id = $(this).val();
    	if($(this).is(":checked") && $.inArray(sendee_id,arr) == -1 ){
    		arr.push(sendee_id);
    		total++;
    	}
    });
    
    if(total == count){
    	$('.commerce_message_more').addClass('commerce_message_people_active');
    	$("#checkall").prop("checked",true);
    }else{
    	$('.commerce_message_more').removeClass('commerce_message_people_active');
    	$("#checkall").prop("checked",false);
    }
    
   	$("#Determine").text('确认发布（已选'+total+'人）');
}
SelectedNumber();


</script>