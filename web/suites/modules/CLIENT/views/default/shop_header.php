<div class="headtop" id="top">
   <div class="eh_toolbar clearfix">
        <div class="fl">
            <ul class="eh_toolbar_node">
               <li><a href="<?php echo site_url("home");?>">首页</a></li>
               <li class="line">|</li>
			   <?php if (!$this->session->userdata('user_in')){  ?>
			<!--未登录状态 开始-->
			<li>您好，<span><a href="<?php echo site_url('customer/login')?>">请登录</a></span>&nbsp;&nbsp;&nbsp;<span><a
					href="<?php echo site_url('customer/registration')?>">免费注册</a></span></li>
			<!--未登录状态 结束-->
                                <?php }else{?>
			<!--登录状态 开始-->
			<li>您好，<span><a href="<?php echo site_url('member/info') ?>"><?php echo $this->session->userdata('user_name');?> </a></span><span><a
					href="<?php echo site_url("customer/logout");?>">退出</a></span></li>
			<!--登录状态 结束-->
                                    <?php }?>

            </ul>
        </div>
        <div class="fr">
            <ul class="sf-menu" id="sf-menu" >

				<?php if($this->session->userdata('corporation_id') > 0 && ($this->session->userdata('corporation_status')==1) ){?>
				<li>
					<a href="<?php echo site_url("member/info");?>">个人中心</a>
				</li>
				<li class="line">|</li>
				<li>
					<a href="<?php echo site_url("corporate/info");?>">企业中心</a>
				</li>
				<li class="line">|</li>
				<li><a href="<?php echo site_url('corporate/advertisement') ?>" target="_blank">广告系统</a></li>
				<?php }else{?>
				<li><a href="<?php echo site_url("member/info");?>">个人中心</a></li>
				<li class="line">|</li>
				<li>
					<a href="<?php echo site_url("customer/is_authenticate");?>">绑定企业</a>
				</li>
				<?php }?>
                <li class="line">|</li>
                <li>
                    <a href="<?php echo site_url("member/fav");?>">收藏夹</a>
                </li>
                <li class="line">|</li>
                <li>
                    <a href="<?php echo site_url('member/complain') ?>">客户服务</a>
                </li>
                <!--<li>
                    <i class="icon-pad"></i>
                    <a href="">手机导航</a>
                </li>-->
             </ul>
        </div>
    </div>
</div><!--headtop end-->
<div class="store_head">
      <div class="store_head_con">
        	<a href="<?php echo site_url("home");?>" class="logo_set" title="51易货网"><img alt="51易货网" src="images/eh_logo.jpg"></a>       
        	<span class="store_head_span"><?php echo $corporation['corporation_name'];?></span>
        	<a target="_blank" href="<?php echo "http://api.map.baidu.com/geocoder?address=".$corporation['province'].$corporation['city'].($corporation['district']?$corporation['district']:"").$corporation['address']."&output=html&src=yourCompanyName|yourAppName";?>"><span class="icon-coordinate" style="margin-left: 5px;color: #fea33b;"> </span></a>
<!--         	<span>旗舰店会员</span> -->
        	<div class="store_head_search clearfix">
                <div class="store_head_search01">
               <form name="search_form" action="<?php echo site_url('search');?>"
			method="post" >
                    <input class="store_head_input" name="product" type="text" placeholder="搜索内容">
                    <a href="javascript:sub()" class="search_total_station">搜全站</a>
                </form>
                </div>
<!--                 <div class="store_head_search02"><a href="">搜本店</a></div> -->
            </div>
      </div>
    </div>
    <script>
function sub(){ 
	$('form').submit();
}

</script>