 
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
</style>
<?php }?>
<div class="Box member_Box clearfix">
	<?php  $this->load->view('tribe/left_nav');?>
	<div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">部落成员</div>
		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			   <form  action="<?php echo site_url('tribe/members') ?>"  method="get" id="form_search">
			  <div class="members_b">
              <input  type="text" class="members_in" name="search_name" value="<?php echo isset($search_name)?$search_name:'' ?>" placeholder="请输入搜索关键字 (用户昵称、企业名称)">
              <input  type="text" class="members_in" name="search_id" value="<?php echo isset($search_id)?$search_id:'' ?>" placeholder="精确搜索用户ID" style="width:115px;">
              <input  type="text" class="members_in" name="search_mobile" value="<?php echo isset($search_mobile)?$search_mobile:'' ?>" placeholder="精确搜索用户手机号" style="width:138px;">
              <a href="javascript:;" onclick="submit();" id="sub" >查询</a>
              <a href="<?php echo site_url("Tribe/add_member");?>">新增</a>
              </div>
                <div class="select2">
                <div class="nice_top">
				 <div class="nice-select1" name="nice-select">
                   <input name="times" id="times" type="text" placeholder="显示全部时间" value="<?php echo isset($times)?$times:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">显示全部</li>
                          <li data-value="2">近7天内</li>
                          <li data-value="3">近一个月内</li>
                          <li data-value="4">3个月内</li>
                          <li data-value="5">半年内</li>
                          <li data-value="6">1年内</li>
                        </ul>
                      </div>
                      
                      <div class="nice-select1" name="nice-select">
                   <input name="status" id="status" type="text" placeholder="审核状态" value="<?php echo isset($status)?$status:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">全部</li>
                          <li data-value="2">未审核</li>
                          <li data-value="3">审核通过</li>
                          <li data-value="4">审核不通过</li>
                        </ul>
                      </div>
                       <div class="nice-select1" name="nice-select">
                   <input name="re_status" id="re_status" type="text" placeholder="注册状态" value="<?php echo isset($re_status)?$re_status:'' ?>" readonly dir="rtl">
                        <ul>
                          <li data-value="1">显示全部</li>
                          <li data-value="2">已注册</li>
                          <li data-value="3">未注册</li>
                        </ul>
                      </div> 
                       
                       <div class="nice-select1" name="nice-select">
                   		<input type="text" placeholder="选择手机号显示"  readonly dir="rtl">
                        <ul>
                          <li   class="show_mobile" onclick="see_status(1);">显示</li>
                          <li   class="show_mobile" onclick="see_status(2);">隐藏</li>
                        </ul>
                       
                      </div> 
                       
                 </div>
              <div class="haudong_top">   
				<table width="2300" border="1" cellpadding="0" cellspacing="0" class="table2 manage_b_table1">
				  
                    <tbody><tr class="tr3 manage_b_tr1">
<!--                         <th width="60px">勾选</th> -->
                        <th width="80px">用户ID</th>
                        <th width="110px">手机号</th>
                        <th width="140px">用户昵称</th>
                        <th width="140px">企业名称</th>
                        <th width="80px">职位</th>
                        <th width="100px">部落名称</th>
                        <th width="140px">族员名称</th>
                        <th width="140px">部落职务</th>
                        <th width="80px">会员</th>
                        <th width="140px">易呗上限</th>
                        <th width="140px">担保额度</th>
                        <th width="140px">单笔担保额度</th>
                        <th width="140px">被担保额度</th>
                        <th width="140px">剩余担保额度</th>
                        <th width="60px">状态</th>
                        <th width="80px">短信</th>
                        <th width="140px">录入时间</th>
                        <th width="90px">审核状态</th>
                        <th width="60px">操作</th>
                    </tr>
                    <?php if(isset($List) && count($List) >0){ 
                            foreach ($List as $key => $val){?>
                     <tr>
<!--                         <th width="60px"><input type="checkbox"></th> -->
                        <th width="80px"><?php echo $val['user_id'];?></th>
                        <th width="110px"><?php echo $val['mobile'];?></th>
                        <th width="140px"><?php echo $val['name'];?></th>
                        <th width="140px"><?php echo $val['corporation_name'];?></th>
                         <th width="80px"><?php echo $val['duties'];?></th>
                        <th width="100px"><?php echo $val['tribe_name'];?></th>
                        <th width="140px"><?php echo $val['member_name'];?></th>
                        <?php if(!$val['tribe_role_id']){?>
                            <th width="140px"><?php echo '部落成员';?></th>
                        <?php }else{?>
                            <th width="140px"><?php echo $val['role_name'];?></th>
                        <?php }?>
                        <th width="80px">
                        <?php if($val['crop_id']){ echo '企业会员'; }else{ echo '个人会员'; }?>
                        </th>
                        <th width="140px"><?php echo $val['credit_ceiling'];?></th>
                        <th width="140px"><?php echo $val['guarantee_from_ceiling'];?></th>
                        <th width="140px"><?php echo $val['guarantee_ceiling'];?></th>
                        <th width="140px"><?php echo $val['guarantee_to_ceiling'];?></th>
                        <th width="140px"><?php echo $val['remain_guarantee_price'];?></th>
                        <th width="60px">
                        	<?php if($val['customer_id'] == NULL){echo '未注册';}else{echo '已注册';}?>
                        </th>
                        <th width="80px">
                        <?php if($val['user_id']){ 
                            if($val['crop_id']){ ?>
                                <input type="button" value="邀请" onclick="" disabled >
                            <?php }else{?>
                                 <input type="button" value="邀请" onclick="_send_Msg('Corp',<?php echo $val['tribe_id'];?>,<?php echo $val['id'];?>);"  >
                           <?php }?>
                        <?php }else{ ?>
                            <input type="button" value="邀请" onclick="_send_Msg('Customer',<?php echo $val['tribe_id'];?>,<?php echo $val['id'];?>);"  >
                        <?php }?>
                       
                        </th>
                        <th width="140px"><?php echo $val['created_at'];?></th>
                        <th width="90px">
                        <?php switch ($val['status']){
                            case '1':
                                echo '待审核';
                                break;
                            case '2':
                                echo '通过';
                                break;
                            case '3':
                                echo '不通过';
                                break;
                        }?>
                       </th>
                        <th width="60px"><a href="<?php echo site_url("Tribe/edit_members").'?id='. $val['id'];?>" style="color:#fca543; text-decoration:underline">编辑</a></th>
                    </tr>
                    <?php } }?>
                   
                          </tbody></table>
                     </div>     
                    
				<div class="jilu jilu2" id="none">
					<!-- <p>显示 <?php  echo ($page - 1)*$pagesize + 1;?> 到 <?php echo $page*$pagesize;?> 条数据，共 <?php echo $totalcount;?> 条数据</p>-->
					<p>显示 <?php
    // echo ($page - 1)*$pagesize + 1;
    if ($totalcount <= 0) {
        echo '0';
    } else {
        echo ($page - 1) * $pagesize + 1;
    }
    ?> 到 <?php
    // echo $page*$pagesize;
    if ($totalcount < $page * $pagesize) {
        echo $totalcount;
    } else {
        echo $page * $pagesize;
    }
    ?> 条数据，共 <?php
    echo $totalcount;
    ?> 条数据</p>
				</div>
				<div class="showpage" style="margin-right:30px;" id="pag">
				<?php echo $pagination;?>
                    	                </div>
                                        
			</div>
		</div>
		 </form>
	</div>



</div>

<script>	

function see_status(show_mobile){
	$.post("<?php echo site_url("Tribe/ajax_update_show_mobile");?>",{show_mobile:show_mobile},function(data){
		if(data.status){
			console.log("修改成功");
		}else{
			console.log("修改失败");
		}
	},"json");
}

function _send_Msg(type,tribe_id,tribe_staff){
	$.ajax({
		url:'<?php echo site_url('Tribe/Invite');?>',
		type:'post',
        async: false,      //ajax同步  
        dataType:"json",
        data:{
        	type:type,tribe_id:tribe_id,tribe_staff:tribe_staff
            },
            success:function(data){
		        alert(data.message);
		        },
	        error:function(){
		        }
		});
}
<?php $this->load->helper("ps");?>
function submit(){

  <?php if(!CheckTribePower("/Tribe/apply_list")):?>
     history.back();
     alert('对不起你暂无权限');
  <?php endif;?>

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
	if(!$(this).hasClass("show_mobile")){
		$('#form_search').submit();
	}
});
$(document).click(function(){
	$('[name="nice-select"] ul').hide();
	
});
</script>
