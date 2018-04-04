
    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<!--<li><a href="">更多需求信息</a></li>-->
                        <li class="gongying_liCurrent"><a href="javascript:;">新闻热点</a></li>
                    </ul>
                </div>
                <div class="gongying_menu_right">
                	<div class="macth_xvlogin_list scroll_top right_list right_scroll_top ">
                    	<div class="scroll_title">新闻热点</div>
                        <ul class="infoList"">
                            <?php if(isset($new_notice) && count($new_notice)>0){ ?>
                            <?php foreach ($new_notice as $nn){ ?>
                                <li><a href="<?php echo site_url('notice') ?>"><?php echo $nn['title'] ?></a></li>
                            <?php }}else{?>
                                <li><a href="javascript:;">暂无公告！</a></li>
                            <?php } ?>
                        	<!-- <li><a href="">51易货网即将上线，敬请期待！</a></li>
                            <li><a href="">【公告】谨防假冒客服诈骗</a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--头部导航条 结束-->
    
    <!--内容 开始-->
    <div class="gongying_con">
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home");?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url('notice') ?>">公告列表</a>&nbsp;&nbsp; &nbsp;>&nbsp;&nbsp; &nbsp;<a href="javascript:;">公告详情</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
			  <h1><?php echo isset($detail['title'])?$detail['title']:'' ?></h1>
              <p>来源：<?php //echo isset($detail['corporation_name'])?$detail['corporation_name']:'' ?>  &nbsp;&nbsp;&nbsp;&nbsp;  <?php echo isset($detail['release_time'])?$detail['release_time']:'' ?></p>
                <div class="gonggao_con">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo isset($detail['content'])?preg_replace('/src="http:\/\/www.51ehw.com\/|src="http:\/\/xian.51ehw.com\/|src="/','src="'.IMAGE_URL,$detail['content']):"" ?></p>
           	    	<!-- <img src="images/gonggao_pic01.jpg" alt=""/> 
                    <p>结合国家“十三·五”规划关于化解过生产能的任务目标，以及对国家国内市场供需矛盾的深入了解和丰富经验，我们越来越强烈的树立起一种责任感和使命感，希望将更多的机会，更大的发展，以及便利的渠道，多元化的方式展现出来，形成良好、高效的贸易流动。</p>
                    <p>以此为目的，通过对经济形式的深刻把握，立足于互联网思维新思想新技术的发展变革，延伸，开拓出适用于大经济圈、全球化贸易体系的“互联网+库存”模式的“贸易生态圈”，为企业打开封闭市场，带来无限的可能。</p>-->
                </div>
          </div>
            <div class="gongying_conRight">
            	<div class="gonggao_conRight_top">
                	最新公告
                	<span class="gonggao_gengduo"><a href="<?php echo site_url('notice') ?>">更多</a></span>
                </div>
                <div class="gonggao_conRight_con">
                	<ul>
                	    <?php if(isset($new_notice) && count($new_notice)>0){ ?>
                        <?php foreach ($new_notice as $nn){ ?>
                            <li ><a href="<?php echo site_url('notice/detail/'.$nn['id']); ?>" ><span style="width:200px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;float:left;"><?php echo $nn['title'] ?></span><span><?php echo date('Y-m-d',strtotime($nn['release_time'])) ?></span></a></li>
                        <?php }}else{?>
                            <li><a href="">暂无最新公告<span></span></a></li>
                        <?php }?>
                    	<!-- <li><a href="">易货的春天即将到来！<span>16.01.01</span></a></li>
                        <li><a href="">创新易货<span>16.01.01</span></a></li>
                        <li><a href="">年货节，十大会场无节操放价！<span>16.01.01</span></a></li>
                        <li><a href="">千万订单亿元采购，名企采购等你<span>16.01.01</span></a></li>
                        <li><a href="">2016中小企业广告需求调研<span>16.01.01</span></a></li>
                        <li><a href="">营销明星风云榜，有你才够味儿！<span>16.01.01</span></a></li>
                        <li><a href="">实力商家，续费有礼！<span>16.01.01</span></a></li>
                        <li><a href="">加入实力商家 接单接到手软！<span>16.01.01</span></a></li>
                        <li><a href="">中小企业需不需要做品牌？<span>16.01.01</span></a></li>
                        <li><a href="">易货的春天即将到来！<span>16.01.01</span></a></li>
                        <li><a href="">创新易货<span>16.01.01</span></a></li>
                        <li><a href="">年货节，十大会场无节操放价！<span>16.01.01</span></a></li>
                        <li><a href="">千万订单亿元采购，名企采购等你<span>16.01.01</span></a></li>
                        <li><a href="">2016中小企业广告需求调研<span>16.01.01</span></a></li>
                        <li><a href="">营销明星风云榜，有你才够味儿！<span>16.01.01</span></a></li>
                        <li><a href="">实力商家，续费有礼！<span>16.01.01</span></a></li>
                        <li><a href="">加入实力商家 接单接到手软！<span>16.01.01</span></a></li>
                        <li><a href="">中小企业需不需要做品牌？<span>16.01.01</span></a></li>-->
                    </ul>
                </div>
            </div>
        </div>
	</div>
    <!--内容 结束-->

