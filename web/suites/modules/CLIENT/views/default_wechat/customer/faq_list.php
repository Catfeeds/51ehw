<div class="container">
    <div class="header" name="top">
        <a href="javascript:history.back()" target="_self" class="icon-back"></a>
        <p class="title">帮助中心</p>
    </div>
	<!--header end-->
<div class="page clearfix">

	<div class="wx-help">
		<ul class="itemList">
                    <?php foreach ($lists as $k=>$v):?>
                    	<li><a
				href="<?php echo site_url('member/faq/detail/'.$v['id']);?>"
				target="_blank"><?php echo $v['title'];?></a></li>
                    <?php endforeach;?>
                </ul>

	</div>
	<!--wx-help end-->


</div>
<!--page end-->


