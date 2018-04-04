<div class="toubu_ding">
    <ul>
    	<li <?php echo !empty( $head_menu ) && $head_menu == 1 ? "class='hui_yanse'" : ''?> ><a href="<?php echo site_url('Corporate/Savings_card/My_List')?>">我是购买方</a></li>
    	<?php if( $this->session->userdata ('corporation_id') ){?>
        
            <li <?php echo !empty( $head_menu ) && $head_menu == 2 ? "class='hui_yanse'" : ''?> ><a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">我是销售商</a></li>
            <li <?php echo !empty( $head_menu ) && $head_menu == 3 ? "class='hui_yanse'" : ''?> ><a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>">我是承兑商</a></li>
               
        <?php } ?>
    </ul>
</div>