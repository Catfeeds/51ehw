<style type="text/css">
    .container {background:#f6f6f6;}
	.tribe_recommend {margin-top: 0;}
    .result_em p {font-size: 13px;color: #666666;}
    .result_em {width: 70%;}
</style>

<?php
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
<!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:history.back()" class="icon-right"></a><span><?php echo $title;?></span>
</div>
<?php }?>
<!-- 选择部落 -->

<?php if( $list ):?>
    <div class="tribe_recommend">
        <div class="tribe_recommend_list">
        <ul>
            <?php foreach ($list as $val) { ?>
                <a href="<?php echo site_url('Credit/Choose_guarantee/'.$val['id']) ?>">
                
                    <li class="clearfix">
                        <i class="tribe_recommend_img"><img src="<?php echo IMAGE_URL.$val['logo']?>" onerror="this.src='images/default_img_s.jpg'"></i>
                        <em class="result_em">
                            <p class="pt10">
                              <span class="tribe_recommend_name"><?php echo $val['name']?></span><span class="tribe_recommend_num">会员数: <?php echo $val['total']?></span>
                            </p>
                            <div class="tribe_recommend_text"><?php echo $val['content']?></div>
                        </em>
                    </li>
                
                </a>
            <?php } ?>
        </ul>
        </div>
    </div>
<?php else:?>


<div style="line-height:50px; font-size:15px;"><center>暂无可选部落</center></div>


<?php endif;?>






