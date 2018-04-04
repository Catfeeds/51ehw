
    <!--内容 开始-->
    <div class="gouwuche_box clearfix">
    	<div class="gouwuche_box_top">常见问题</div>
        <div class="kehufuwu_01_con">
        	<h4>
            <?php foreach ($lists as $k=>$v):?>

             <p><a href="<?php echo site_url('member/faq/detail/'.$v['id']);?>" target="_blank"><?php echo $v['title'];?></a></p>

           <?php endforeach;?>
           </h4>
        </div>
    </div>
   	<!--内容 结束-->


    

