<div class="foot_detail_c clearfix">
        <p class="foot_detail_p">
            <span><a href="<?php echo site_url('corporation/home_page');?>">首页</a></span>
            <span>&gt;</span>
            <span><a href="javascript:;" class="foot_pCurrent"><?php echo $content_info['title']?>
</a></span>
        </p>
    <!--左边  开始-->
  
    <div class="foot_detail_l">
    	<div class="foot_leftTop" style="font-size:18px;"><?php echo $content_info['title']?></div>
        <div class="foot_leftCon">
        	<ul>
        		<?php foreach ( $content_list as $v ) {?>
                <li>
                	<a href="<?php echo site_url('corporation/description/'.$v['id']);?>" <?php echo $v['id'] == $content_id ? 'class="foot_leftCurrent"':''?> ><?php echo $v['title']?></a>
                </li>
                <?php }?>
               
        	</ul>
        </div>
    </div>
    <!--左边 结束-->
    <!--右边 结束-->
    <div class="foot_detail_r">
    	<div class="foot_rightTop"><?php echo $content_info['title'];?></div>
        <div class="foot_rightCon">
 
        
        <p><strong><?php  echo  preg_replace('/src="/','src="'.IMAGE_URL,$content_info['content']);?>
        </strong></p> 
        	
		</div>

    </div>
    <!--右边 结束-->
    </div>