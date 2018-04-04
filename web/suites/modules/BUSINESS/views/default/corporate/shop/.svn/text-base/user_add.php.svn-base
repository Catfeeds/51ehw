
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
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">店铺管理</div>
            <div class="cmLeft_down down_other">
            	<ul>
                	<li ><a href="<?php echo site_url('corporate/myshop/get_shop') ?>">基本信息</a></li>
                	<li><a href="<?php echo site_url('corporate/information') ?>" >公司介绍</a></li>
                    <!--<li ><a href="<?php //echo site_url('corporate/myshop/menu_list') ?>">菜单管理</a></li>
                    <li ><a href="<?php //echo site_url('corporate/myshop/ad_admin') ?>">广告管理</a></li>-->
                    <li><a href="<?php echo site_url('corporate/myshop/renovate') ?>" target="_blank">店铺装修</a></li>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/myshop/user') ?>">账户管理</a></li>
                    <!-- <li><a href="<?php //echo site_url('corporate/myshop/role') ?>">角色管理</a></li>-->
                     <li><a href="<?php echo site_url('corporate/resource/resource_list') ?>" >会员背书</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale') ?>" >实体消费</a></li>
                    <li><a href="<?php echo site_url('corporate/sale/shop_sale_code') ?>" >实体消费二维码</a></li>
                </ul>
            </div>
        </div>
        <div class="names_set">
            <p class="shezhis">账户设置</p>
            <a class="zhanghu_add" href="javascript:void(0)"><h1 style="margin-left:20px;">添加账户</h1></a>
            <a href="<?php echo site_url('corporate/myshop/invitation_list') ?>" ><h1>邀请账户</h1></a>
            <div class="data_set">
                <ul class="data_names">
                    <li class="users_name">真实姓名</li>
                    <li class="name_others search_name">昵称</li>
                    <li class="set_phone search_phone">联系电话</li>
                    <li class="set_phone search_phone">即将授予权限</li>
                    <li class="operation" style="border-right:none; width:100px;">操作</li>
                </ul>
                <ul class="data_names data_inter" style="border:none; display:none;border-bottom:1px solid #fea33b;">
                    <li class="users_name" style="border:none;"></li>
                    <li class="name_others search_name" style="border:none;">
                    <!-- 弹框 -->
                    
                    <!-- end -->
                    </li>
                    <li class="set_phone search_phone" style="border:none;"></li>
                    <!-- <li class="operation" style="border:none;"><a href=""><p></p></a></li>-->
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
                
                <?php if(isset($list) && count($list)>0){; ?>
                <?php foreach ($list as $u){;?>
                <ul class="data_names data_oth">
                    <li class="users_name"><?php echo $u['real_name']?$u['real_name']:$u["c_name"]; ?></li>
                    <li class="name_others search_name"><?php echo $u['nick_name']?$u['nick_name']:$u["c_name"]; ?></li>
                    <li class="set_phone search_phone"><?php echo $u['mobile']; ?></li>
                    <li class="set_phone search_phone"><?php echo $u["role_name"];?></li>
                    <li class="operation" style="border-right:none; width:100px;"><a onclick="invitation(this,<?php echo $u['id'] ?>);" ><p>发送邀请</p></a></li>
                </ul>
                <?php }; ?>
                <?php }else{;?>
                <ul class="data_names data_inter" style="border-top: 1px solid #fea33b; margin-top:20px;">
                <div style=" font-size:14px; color:#eb5252; text-align:center; line-height:50px;">暂无用户或该用户已被其它商家聘请</div>
                </ul>
                <?php }; ?>
                
                <!-- page -->
                <div class="pingjia_showpage page_set">
                    <!-- <a href="#" class="lPage">上一页</a>
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a class="cpage">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">7</a>
                    <a href="#">8</a>
                    <span>…</span>
                    <a href="#" class="lPage">下一页</a>-->
                </div>
                <!-- end -->
            </div>
        </div>
    </div>

<!--弹窗-->
<div class="danchuang" id="dialog">
    <div class="dc_con">
    	<div class="dc_top">
        	<select class="sle">
               <option style="width:200px">1</option>
               <option style="width:200px">2</option>
               <option style="width:200px">3</option>
               <option style="width:200px">4</option>
               <option style="width:200px">5</option>
              </select>
              <h1 style="float:right">标题</h1>
              
              <p style="margin-top:50px">示图</p>
        </div>
        <div class="dc_img"></div>
        <div class="dc_btn">
        	<div class="dc_btn_01"><a href="#">保存</a></div>
            <div class="dc_btn_02"><a href="#">关闭</a></div>
        </div>
    </div>
</div>


<script>
    $(".zhanghu_add").click(function(){$(".alert_bg").show();})
    $(".alert").children("h5").children().children().click(function(){$(".alert_bg").hide();})
    
    //关闭添加窗口
    function close(){
    	$(".alert_bg").hide();
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

    function invitation(obj,id){
        $.ajax({
            url:"<?php echo site_url('corporate/myshop/invitation') ?>",
            type:"post",
            data:{id:id},
            beforeSend:function(){
                $(obj).children('p').html("正在邀请...");
            },
            success:function(data){
                if(data==1){
                	$(obj).children('p').html("发送成功");
                	$(obj).children('p').css('background-color','#9F9B97');
                	$(obj).removeAttr('onclick');
                }else{
                	$(obj).children('p').html("发送失败");
                	setTimeout(function(){
                		$(obj).children('p').html("发送邀请");
                    },3000);
                }
            },
            error:function(){
                
            }
        });
    }
    
</script>

