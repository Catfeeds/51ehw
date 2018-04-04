
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
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="names_set">
        
            <p class="shezhis">帐号编辑</p>
            <!-- 资料修改 -->
            <ul class="edits_ul">
                <li class="edits">姓名：</li>
                <li>联系电话：</li>
                <li>账号状态：</li>
                <li>设置权限：</li>
                <li class="edits">备注：</li>
            </ul>
            <ul class="edit_text">
            <form action="<?php echo site_url('corporate/myshop/user_save/'.$dt['id']) ?>" method="post" id="form">
                <input name="id" value="<?php echo $dt["id"];?>" hidden>
                <li><?php echo $dt['real_name']?$dt['real_name']:$dt['nick_name']; ?></li>
                <li class="shuzi"><?php echo $dt['mobile']; ?></li>
                <div class="edit_select">
                <!-- 下拉 -->
                
                    <div class="qiyong">
                        <select class="selecteds" name="status">
                              <option selected value ="<?php echo $dt["status"]?>">
                              <?php switch($dt["status"]){
                                  case "0":
                                      echo "待邀请";
                                      break;
                                  case "1":
                                      echo "邀请中";
                                      break;
                                  case "2":
                                      echo "在职权限";
                                      break;
                                  case "3":
                                      echo "冻结权限";
                                      break;
                              }?>
                              </option>
                              <?php if($dt['status']==3){;?>
                              <option value ="2">解冻权限</option>
                              <?php }else{;?>
                              <option value ="3">冻结权限</option>        
                              <?php };?>                      
                        </select>
                    </div> 
                <!-- end -->
                </div>
                <div class="edit_select">
                    <div class="qiyong">
                        <select class="selecteds" name="role_id">
                         <?php foreach($role_list as $v){;?>
                              <option <?php echo $dt['role_id']==$v["id"]?"selected":"";?> value ="<?php echo $v["id"];?>"><?php echo $v["name"];?></option>
                         <?php };?>
                        </select>
                    </div> 
                </div>
                <textarea name="remark"><?php echo $dt['remark'];?></textarea>
                <input type="hidden" id="id" value="<?php echo $dt['id'] ?>">
<!--                 <a href="javascript:;" id="nobind"><h4>解除绑定</h4></a> -->
                <a href="javascript:;" onclick="save();"><h4 style="background:#fe4101;">保存</h4></a>
             </form>
            </ul>
            <!-- end -->
        </div>
        
    </div>

<script>

    //保存
    function save(){
        $('#form').submit();
    }
    
</script>

