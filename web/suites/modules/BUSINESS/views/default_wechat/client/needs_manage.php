<style type="text/css">
	body {background: #EEEEEE!important;}
	.container {background: #EEEEEE!important;}
	ul,li {list-style: none;}
	.needs_manage {padding: 0px 10px 0px 10px;font-size: 15px;background: #fff!important;}
	.needs_manage ul li {padding: 10px 0;border-bottom: 1px solid #ddd;}
	
</style>
<!-- <div class="commodity_h50"></div> -->
 <div class="needs_manage">
 	<ul>
 	   <li>
 	    <a href="<?php echo site_url("member/requirement/my_req");?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"></span>
	    <span class="fn-right"><em class="icon-right c9"></em></span>我的需求</a>
	</li>
	<li>
	   <a href="<?php echo site_url("member/requirement/offers");?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"></span>
	   <span class="fn-right"><em class="icon-right c9"></em></span>我的报价</a>
	</li>
	<li>
	   <a href="<?php echo site_url("member/requirement/addrequirements");?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"></span>
	   <span class="fn-right"><em class="icon-right c9"></em></span>发布需求</a>
	</li>
 	</ul>
 </div>
<script type="text/javascript">
 $('.needs_manage ul li').click(function(){
	 var href = $(this).children('a').attr('href');
	 window.location.href = href;
	 
	 });
</script>

