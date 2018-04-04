<style>
.data_oth li{ border-bottom:none;}
</style>
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
        	<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box clearfix">
        <?php  $this->load->view('corporate/shop/Left_nav');?>
        <div class="names_set" style="margin-left: 0;width: 969px;float: right;">
            <p class="shezhis">账户设置</p>
            <a class="zhanghu_add" href="javascript:void(0)"><h1 style="margin-left:20px;">添加账户</h1></a>
            <a href="<?php echo site_url('corporate/myshop/invitation_list') ?>" ><h1>邀请账户</h1></a>
            <a href="javascript:del();" ><h1>删除</h1></a>
            
            <div class="data_set" style="width: auto;">
                <ul class="data_names">
                	<li style="width:51px;"><input type="checkbox" onclick="if(this.checked==true) { checkAll(); } else { clearAll(); }"></li>
                    <li>真实姓名</li>
                    <li>昵称</li>
                    <li>联系电话</li>
                    <li>角色</li>
                    <li style="width:70px;">状态</li>
                    <li style="width:208px;">添加日期</li>
                    <li style="width:100px;">备注</li>
                    <li style="border-right:none; width:70px;">操作</li>
                </ul>
                <ul class="data_names data_inter" style=" border:none; display:none; border-bottom:1px solid #fea33b;">
                	<li style="width:51px; border-right:none;"></li>
                    <li style="border-right:none;"></li>
                    <li class="name_others" style="border-right:none;">
                   
                    </li>
                    <li style="border-right:none;"></li>
                    <li style="border-right:none;"></li>
                    <li style="width:70px; border-right:none;"></li>
                    <li style="width:70px; border-right:none;"></li>
                    <li style=" width:208px;border-right:none;"></li>
                    <li style="border-right:none; width:100px;"></li>
                </ul>
                
                
                 <!-- 弹框 -->
                    <div class="alert_bg" hidden>
                        <div class="alert" >
                        <form >
                            <h5>添加账户<a href="javascript:close();"  ><span style="color:#fff;">x</span></a></h5>
                            <div class="alert_er">
                                <ul>
                                  <li><span>按手机搜索</span><input input="text" placeholder="请输入对方手机号码" value="" name="mobile"></li>
                                  <li>
                                     <span>权限选择</span>
                                     <select class="alert_er_input" id="role_id" name="role_id">
                                     <?php foreach($role_list as $v){;?>
                                     <option value="<?php echo $v["id"];?>"><?php echo $v["name"];?></option>
                                     <?php };?>
                                     </select>
                                  </li> 
                                </ul>
                                <a href="javascript:;" id="add"><h4>增加</h4></a>
                            </div>
                        </form>
                        </div>
                    
                    </div>
                    <!-- end -->
                
                
                <form  id="form">
                <input type="hidden" name="freeze" value="2" id="freeze">
                <?php $id = $this->session->userdata("user_id");?>
                <?php if(isset($list) && count($list)>0){; ?>
                
                    <?php foreach ($list as $key => $ls){; ?>
                        <!-- 禁止操作自己账户 -->
                        <?php if($id == $ls["customer_id"]){;?>
                        <ul <?php if($key%2>0){echo 'class="data_names data_inter"';}else {echo 'class="data_names data_oth"';} ?>>
                        	<li style="width:51px;"></li>
                            <li><?php echo $ls['nick_name']?$ls['nick_name']:$ls['c_name']; ?></li>
                            <li class="name_others"><?php echo $ls['real_name']?$ls['real_name']:$ls['c_name']; ?></li>
                            <li><?php echo $ls['mobile'] ?></li>
                            <li>
                            <?php echo $ls["role_name"];?>
                           	</li>
                            <li style="width:70px;">
        					<?php 
                                switch ($ls["status"]){
                                    case "0":
                                        echo "待邀请";
                                        break;
                                    case "1":
                                        echo "邀请中";
                                        break;
                                    case "2":
                                        echo "在职";
                                        break;
                                    case "3":
                                        echo "冻结";
                                        break;
                                }
        					?>
                            </li>
                            <li style="width:208px;"><?php echo $ls["created_at"]?></li>
                            <li style="width:100px;"><?php echo $ls["remark"];?></li>
                            <li style=" border-right:none; width:70px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"></li>
                        </ul>
                        <?php }else{;?>
                        <!-- 其他员工 -->
                        <ul <?php if($key%2>0){echo 'class="data_names data_inter"';}else {echo 'class="data_names data_oth"';} ?>>
                        	<li style="width:51px;"><input type="checkbox" name="id[]" value="<?php echo $ls['id'] ?>"></li>
                            <li><?php echo $ls['nick_name']?$ls['nick_name']:$ls['c_name']; ?></li>
                            <li class="name_others"><?php echo $ls['real_name']?$ls['real_name']:$ls['c_name']; ?></li>
                            <li><?php echo $ls['mobile'] ?></li>
                            <li>
                            <?php echo $ls["role_name"];?>
                           	</li>
                            <li style="width:70px;">
        					<?php 
                                switch ($ls["status"]){
                                    case "0":
                                        echo "待邀请";
                                        break;
                                    case "1":
                                        echo "邀请中";
                                        break;
                                    case "2":
                                        echo "在职";
                                        break;
                                    case "3":
                                        echo "冻结";
                                        break;
                                }
        					?>
                            </li>
                            <li style="width:208px;"><?php echo $ls["created_at"]?></li>
                            <li style="width:100px;"><?php echo $ls["remark"];?></li>
                            <li style=" border-right:none; width:70px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><a href="<?php echo site_url('corporate/myshop/user_edit/'.$ls['id']) ?>">编辑</a></li>
                        </ul>
                        <?php };?>
                    <?php }; ?>
                    
                <?php }else{; ?>
                </form>
                <div class="result_null" style="margin-top:20px;">暂无用户</div>
                <?php }; ?>

                
            </div>
            <!-- page -->
                <div class="pingjia_showpage page_set pageRight">
                     <?php echo isset($pagination)&&($pagination!=null)?$pagination:""; ?>
                </div>
                <!-- end -->
        </div>
    </div>






<script>
    $(".zhanghu_add").click(function(){$(".alert_bg").show();})
    $(".alert").children("h5").children().children().click(function(){$(".alert_bg").hide();})
</script>


<script type="text/javascript">


//全选
function checkAll() {
	var el = document.getElementsByTagName('input');
	var len = el.length;
	for(var i=0; i<len; i++) {
	if((el[i].type=="checkbox")) {
	el[i].checked = true;
	}
	}
} 
//反选
function clearAll() {
	var el = document.getElementsByTagName('input');
	var len = el.length;
	for(var i=0; i<len; i++) {
	if((el[i].type=="checkbox")) {
	el[i].checked = false;
	}
	}
} 


//添加
$('#add').click(function(){
	var mobile = $("input[name=mobile]").val();
	var role_id = $("#role_id").val();
    $.post("<?php echo site_url('corporate/myshop/user_add') ?>",{mobile:mobile,role_id:role_id},function(data){
        switch(data['status']){
        case "success":
        	alert("添加成功");
        	location.reload(); 
            break;
        case "fail":
        	alert("添加失败");
        	location.reload();   
            break;
        case "exist":
        	alert("已经存在此员工");
            break;
        case "error":
        	location.reload();//非法操作
            break;
        case "not_user":
        	alert("请填写有效的手机号码");
            break;
        case "error_mobile":
            alert("请填写正确的手机号码");
            break;
        case "crop_exist":
            alert("此用户是商家");
            break;
        default:
            location.reload();
            break;
        }
    },"json");
});

//关闭添加窗口
function close(){
	$(".alert_bg").hide();
}


//删除 
function del(){
	var id = new Array();
	$('input[name="id[]"]:checked').each(function (i){
	    id[i] = $(this).val();
	});
    if(id[0]){
        $.post('<?php echo site_url('corporate/myshop/nobind') ?>',{id:id},function (data){
            location.reload();
         })
    }else{
        alert("请选择要删除的员工");
    }
}

</script>

