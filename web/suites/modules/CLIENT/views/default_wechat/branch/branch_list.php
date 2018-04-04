<div class="page clearfix">
    <div class="member_box">
        <ul class="member_head_list clearfix" >
        <?php foreach ($branch as $key =>$val){?>
         <li><a href="<?php echo site_url("Corporate/branch/branch_order").'/'.$val['id'];?>"></span>
         <span class="fn-right red"><em class="icon-right c9"></em></span><?php echo $val['branch_name'];?></a></li>
         <?php }?>
        </ul>
    </div>
</div>

