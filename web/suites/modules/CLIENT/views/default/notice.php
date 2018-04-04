<style>
.gengduogonggao_comRight_input{ width: 165px;margin-left: 0px;float: left;}
.gengduogonggao_search_btn{float: right;width: 60px; margin-top:0px;}
.gonggaoimg_left{ float:left; width:190px;height:201px;   margin-top: 20px;padding:5px}
.gonggaoimg_left img{ width:100%;height:92%;}
.gengduogonggao_con01 {float:left; margin-left: 10px; width: 660px;}
.clear{clear:both;}
.gongying_conLeft_con03{ border:none;}
</style>
    <!--头部导航条 开始-->  
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<!--<li><a href="">更多需求信息</a></li>-->
                        <li class="gongying_liCurrent"><a href="javascript:;">更多公告</a></li>
                    </ul>
                </div>
                <div class="gongying_menu_right">
                	<div class="right_list right_scroll_top">
                    	<div class="scroll_title">新闻热点</div>
                        <ul class="scroll_infoList">
                        <?php if(isset($todaynotice) && count($todaynotice)>0): ?>
                            <?php foreach ($todaynotice as $tn): ?>
                                <li>
                                <a href="<?php echo site_url('notice'); ?>"><?php echo $tn['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <li>
                                <a href="javascritp:;">暂无公告！</a>
                                </li>
                            <?php endif; ?>
                        	<!-- <li><a href="">51易货网即将上线，敬请期待！</a></li>-->
                            <li><a href="javascript:;">【公告】谨防假冒客服诈骗</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--头部导航条 结束-->
    
    <!--内容 开始-->
    <div class="gongying_con">
    	<p class="gongying_weizhi"><a href="<?php echo site_url("Home");?>">首页</a>&nbsp;&nbsp;&nbsp; > &nbsp;&nbsp; &nbsp;<!--<a href="javascript:;">-->公告列表<!--</a>-->
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
            	<div class="gengduogonggao_top">更多公告</div>
                <div class="gengduogonggao_con">
                	<!--内容01 开始-->
                	<?php if(isset($list)&&count($list)>0): ?>
					<?php   foreach($list as $key=>$l){?>
					<div class="gonggaoimg_left">
					    <?php if($l['title_img'] == 'images/default_img_s.jpg'){ ?>
					        <img alt="<?php echo $l['title']?>" src="<?php echo IMAGE_URL.'uploads/content/'.$l['title_img']?>">
					   <?php }else{?>
                    	  <img alt="<?php echo $l['title']?>" src="<?php echo IMAGE_URL.$l['title_img']?>"> 
                    	 <?php }?>
                	</div>
                	<div class="gengduogonggao_con01">
                    	<h1>
                        	<a href="<?php echo site_url('notice/detail/'.$l['id']); ?>">
                                <!-- <img src="images/gengduogonggao_zhiding.png" width="28" height="16" alt=""/>-->
                                <!-- 2015互联网安全志愿者大会在杭州召开-->
                                <?php echo $l['title'] ?>
                                <span class="gengduogonggao_span" ><?php echo $l['release_time'] ?></span>
                            </a>
                        </h1>
                        <div class="gengduogonggao_p" style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 4;overflow: hidden;width:660px;max-height:90px;">
                                <em style="opacity: 0;">空符</em><?php echo isset($l['content'])?str_replace('img','img style="display:none;"',str_replace('</p>','',str_replace('<p>','',str_replace('&nbsp;','',str_replace('<br />','',str_replace('</br>','',$l['content'])))))):'' ?>
                        </div>
                        <p><a href="<?php echo site_url('notice/detail/'.$l['id']); ?>"  ><span href="javascript:;" class="gengduogonggao_jiantou"> 详情 > </span></a></p>
                   </div>
                   <div class="clear"></div>
				   <?php }?>
				   <?php else: ?>
				   <div class="gengduogonggao_con01">
                    	<h1>
                        	<a href="javascript:;">
                               
                                <!-- 2015互联网安全志愿者大会在杭州召开-->
                                
                                <span class="gengduogonggao_span">暂无公告</span>
                            </a>
                        </h1>
                   </div>
				   <?php endif; ?>
                   <!--内容01 结束-->
                </div>
                <!--左边分页 结束-->
                <div class="gongying_conLeft_con03">
                	<div class="gongying_fenye">
                	<?php echo $pagination ?>
                    </div>
                </div>
                <!--左边分页 结束-->
                
            </div>
            <div class="gongying_conRight">
            	<div class="gonggao_conRight_top">
                	搜索公告
                	<!--<span class="gonggao_gengduo"><a href="">更多</a></span>-->
                </div>
                <div class="gengduogonggao_conRight_con">
                	<!--<span><a href="">产品公告</a></span>
                    <span><a href="">新闻公告</a></span>-->
                    <div class="gengduogonggao_conRight_search">
                    <form action="<?php echo site_url('notice'); ?>" metnod="get" id="form">
                    	<input type="text" value="<?php echo isset($search)?$search:'' ?>" class="gengduogonggao_comRight_input" name="key">
                        <a href="javascript:;" class="gengduogonggao_search_btn" id="search">搜索</a>
                    </form>
                    </div>
                  <!--<div class="gengduogonggao_conRight_down">
                      <h4>重点公告</h4>
                      <ul>
                        <?php if(isset($list)&&count($list)>0): ?>
					    <?php foreach($list as $key=>$l){?>
					       <?php if($l['n_flag']==1): ?>
					           <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href=""><?php echo $l['title'] ?></a></li>
					       <?php endif; ?>
					    <?php }?>
	                       <?php else: ?>
					           <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">暂无重点广告</a></li>
					    <?php endif;?>
                       	   <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">2015互联网安全志愿者大会在杭州召开</a></li>
                          <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">51易货新年返乡列车报名火爆</a></li>
                          <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">天猫国际跨境O2O体验中心落户天津</a></li>
                          <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">51易货启动城市合伙人计划</a></li>
                          <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">51易货集团CEO张勇：B2B的春天正在到来</a></li>
                          <li><span><img src="images/gengduogonggao_conRight_li.png" width="8" height="8" alt=""/></span><a href="">天猫与IFA达成战略合作 前沿消费电子新品</a></li>
                      </ul>
                 </div>-->
             </div>
          </div>
    	</div>
	</div>
    <!--内容 结束-->

<script type="text/javascript">
<!--
$(function(){
	$('#search').on('click',function(){
		$('#form').submit();
	});
});
//-->
</script>
