<?php if( isset( $error ) ){?>

<script type="text/javascript">


$(".black_feds").text('<?php echo $error['message']?>').show();
setTimeout("prompt();", 2000);


<?php if( isset( $error['redirect_url'] ) ){?>
	window.setTimeout("window.location.href='<?php echo $error['redirect_url']?>'", 1000);   
	
<?php }?>

</script>
<?php }else{?>

<style type="text/css">
	.container {background: #ECECEC;}
	.vote_situation ul li{width:50%}
</style>

<!-- 投票 -->
<div class="vote">
	<!-- banner 图 -->
	<div><img src="<?php echo IMAGE_URL.$VoteOptionInfo['banner']?>" alt=""></div>	
	<div class="vote_box">
      <!-- 标题 -->
      <div class="vote_title"><span></span></div>
      <!-- 投票情况 -->
      <div class="vote_situation">
      	<ul>
      	    <li><span>累计投票</span><em><?php echo $VoteOptionInfo['staff_num']?></em></li>
      	    <li><span>访问次数</span><em><?php echo $VoteOptionInfo['visits']?></em></li>
      	</ul>
      </div>
      <!-- 时间 -->
      <div class="vote_time"><em class="icon-time"></em>开始时间：<span><?php echo $VoteOptionInfo['start_time']?></span></div>	
      <div class="vote_time"><em class="icon-time"></em>截止时间：<span><?php echo $VoteOptionInfo['end_time']?></span></div>	
    </div>
    <!-- 投票规则 -->
    <div class="vote_rule"><em class="icon-cuowu"></em><span><?php echo $VoteOptionInfo['rule'] ? $VoteOptionInfo['rule'] : '暂无描述'?></span></div>
    <!-- 投票简介 -->
    <div class="vote_account">
    	<div class="vote_account_head"><em class="icon-form"></em>投票简介：<em class="icon-xiala icon-fold vote_xiala_icon"></em></div>
    	<div class="vote_account_text_box" style="display: none;">
    		<div class="vote_account_text"><span><?php echo $VoteOptionInfo['abstract']?></span></div>
    	    <div class="vote_account_text_all"><span>查看全文</span></div>
    	</div>
    </div>
</div>	

<!-- 项目详情 -->
<div class="vote_detail">
	<div class="vote_detail_box">
		<div class="vote_detail_item_name"><span><?php echo $VoteOptionInfo['id']?>.<?php echo $VoteOptionInfo['option_title']?></span></div>
		<?php if( $VoteOptionInfo['vote_type'] ) {?>
	    <div class="vote_detail_item_img"><img src="<?php echo IMAGE_URL.$VoteOptionInfo['option_img']?>" alt=""></div>
	    <?php }?>
	    <input onclick="vote_sub(this,<?php echo $VoteOptionInfo['id']?>)" type="button" value="<?php echo $VoteOptionInfo['is_vote'] ? '投票' :'已投票'?>" <?php echo !$VoteOptionInfo['is_vote'] ? 'style="background: #ECECEC;"' :''?> >
	    <div class="vote_detail_item_num" <?php echo !$VoteOptionInfo['result'] ? 'hidden' : ''?>><span id="staff_option_<?php echo $VoteOptionInfo['id']?>"><?php echo $VoteOptionInfo['staff_num']?>票</span></div>
	</div>
</div>

<?php if( $VoteOptionInfo['introduce'] ) {?>
<!-- 项目介绍 -->
<div class="vote_detail_introduce">
	<div class="vote_detail_introduce_box">
		<div class="vote_detail_introduce_head"><span>项目介绍</span></div>
	    <div class="vote_detail_introduce_text">
		  <?php echo $VoteOptionInfo['introduce'] ?>
	   </div>
	</div>
</div>
<?php }?>




<!-- 返回首页 -->
<a href="<?php echo site_url('Activity/Tribe_vote/Detaile/'.$VoteOptionInfo['vote_id'])?>" class="vote_back_index">返回首页</a>
<!-- 当前排名 -->
<a href="<?php echo site_url('Activity/Tribe_vote/Detaile/'.$VoteOptionInfo['vote_id'].'/1')?>" class="vote_ranking">当前排名</a>
<!-- 投票规则 -->
<a href="javascript:void(0);" class="vote_rule_get">投票规则</a>


<?php $this->load->view('tribe/tribe_vote/vote_sub')?>

<script type="text/javascript">
    // 点击简介
    $('.vote_account_head').on('click',function(){
    	$(this).children('.vote_xiala_icon').toggleClass('icon-xiala');
    	$('.vote_account_text_box').toggleClass('display_block');
    })
	$('.vote_account_text_all').on('click',function(){
		$(this).hide();
		$('.vote_account_text span').addClass('vote_account_text_active');
	})
	
	var staff_num = <?php echo $VoteOptionInfo['staff_num']?>;
	
	function vote_sub(obj,id)
    { 
		votestaff_sub(obj,id,staff_num,'<?php echo site_url('Activity/Tribe_vote/VoteSub/'.$VoteOptionInfo['id'])?>');
    }


    
</script>
<?php }?>