<?php foreach ($filter as $k=>$v):?>
<dl class="ui-cat-species">
	<ul>
    <li class="js_toggle">
    <dt class="ui-cat-nav-1 ui-cat-bj" style="height: 73px;">
    <h3 style="height: 28px; line-height:28px;"><a href="<?php echo site_url('goods/lists?cate='.$v["id"]);?>"><?php echo $v['name'];?></a><s class="menuIcon"></s></h3>
       <span>
       <?php if(isset($v[1])):?>
       <?php foreach ($v[1][$v[1]["cate_id"]] as $ak=>$av):?>
           <a href="<?php echo site_url('goods/lists?cate='.$v["id"]."&a_".$v[1]["cate_id"]."=".$av["sign_id"] );?>" target="_blank"><?php echo $av["sign_name"];?></a>
       <?php endforeach;?>
       <?php endif;?>    
       </span>
    </dt>
    <!--子菜单弹出层 S-->
	<?php if(isset($v[1])):?>
	<dd class="menu-in" style="display:none;">
        <ul class="ui-cat-sub fn-clear">
       	<?php  foreach ($v[1][$v[1]["cate_id"]] as $ak=>$av):?>
       		<li>
                <h4>
                    <a href="<?php echo site_url('goods/lists?cate='.$v["id"]."&a_".$v[1]["cate_id"]."=".$av["sign_id"] );?>" target="_blank"><?php echo $av["sign_name"];?></a>
                </h4>
                <p class="ui-sub">
                <?php if(isset($v[2])):?>
                <?php foreach ($v[2][$v[2]["cate_id"]] as $aak=>$aav):?>
					<?php if($v[2]["parent_cate_id"]==0):

					?>
                    <a href="<?php echo site_url('goods/lists?cate='.$v["id"]."&a_".$v[1]["cate_id"]."=".$av["sign_id"]."&a_".$aav["cate_id"]."=".$aav["sign_id"]);?>" target="_blank"><?php echo $aav["sign_name"]?></a>
					<?php else:?>
						<?php if($av["sign_id"] == $aav["parent_id"]){?>
						<a href="<?php echo site_url('goods/lists?cate='.$v["id"]."&a_".$v[1]["cate_id"]."=".$av["sign_id"]."&a_".$aav["cate_id"]."=".$aav["sign_id"]);?>" target="_blank"><?php echo $aav["sign_name"]?></a>
						<?php }?>
					<?php endif;?>
                <?php endforeach;?>    
                <?php endif;?>
                </p>
            </li>
       	<?php endforeach;?>
		 </ul>
    </dd>
    <?php endif;?> 

    </li>
    </ul>
    <!--子菜单弹出层 E-->
</dl>
<?php endforeach;?>