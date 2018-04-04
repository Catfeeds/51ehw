
    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<li><a href="<?php echo site_url('requirement/more_require') ?>">更多需求信息</a></li>
                        <li class="gongying_liCurrent"><a href="<?php echo site_url('supply') ?>">更多供应信息</a></li>
                    </ul>
                </div>
                <div class="gongying_menu_right">
                	<div class="right_list right_scroll_top">
                    	<div class="scroll_title">新闻热点</div>
                        <ul class="scroll_infoList">
                        	<li><a href="">51易货网即将上线，敬请期待！</a></li>
                            <li><a href="">【公告】谨防假冒客服诈骗</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--头部导航条 结束-->
    
    <!--内容 开始-->
    <div class="gongying_con">
    	<p class="gongying_weizhi"><a href="<?php site_url("home")?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url('supply') ?>">更多供应信息</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
            	<!--左边头部 开始-->
            	<div class="gongying_conLeft_top">
                	<div class="gongying_conLeft_con">
                    	<!--分类下拉框-->
                        <span class="gongying_select">
                        	<span class="gongying_select_bg"></span>
                            <select class="gongying_conLeft_select01">
                                <option>全部分类</option>
                                <option>1</option>
                                <option>1</option>
                            </select>
                        </span>
                        <!--搜索-->
                        <span class="gongying_search">
                        <span class="gongying_search_bg"></span>
                        <input class="gongying_conLeft_search" type="text" value="在该分类下搜索">
                        <a href="" class="gongying_search_btn">搜索</a>
                        </span>
                    </div>
                </div>
                <!--左边头部 结束-->
                <!--左边内容 开始-->
                <div class="gongying_conLeft_con01">
                	<span class="gongying_span80">分类</span>
                    <span class="gongying_span124">店铺</span>
                    <span class="gongying_span110">
                    	<select class="gongying_span_select">
                        	<option>商家级别</option>
                            <option>全部</option>
                            <option>易货店会员</option>
                            <option>旗舰店会员</option>
                            <option>专卖店会员</option>
                        </select>
                    </span>
                	<span class="gongying_span450">商品名称</span>
                    <span class="gongying_span90">
                    	<select class="gongying_span_select">
                        	<option>发布时间</option>
                            <option>全部</option>
                            <option>今天</option>
                            <option>三天内</option>
                            <option>一周内</option>
                            <option>一月内</option>
                        </select>
                    </span>
                </div>
                <!--左边搜索结果列表 开始-->
                <div class="gongying_conLeft_con02">
                	<ul>
						<?php foreach($list as $key=>$detail){?>
                    	<li <?php if($key%2 >0){ echo 'class="gongying_conLeft_li"';}?>>
                        	<span class="gongying_span80 liSpan_80" style="width:70px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $detail["cate_name"]?></span>
                            <span class="gongying_span124 liSpan_124" style="width:110px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $detail["corp_name"]?></span>
                            <span class="gongying_span110 liSpan_110" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php if($detail["grade"]==1){echo "易货店会员";}else if($detail["grade"]==2){echo "专卖店会员";}else if($detail["grade"]==3){echo "旗舰店会员";}?></span>
                            <span class="gongying_span450 liSpan_450" style="width:450px;;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $detail["name"]?></span>
                            <span class="gongying_span100 liSpan_90" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo  date('Y-m-d',strtotime($detail["on_sale_at"]))//$detail["on_sale_at"]?></span>
                        </li>
						<?php }?>
                        
                    </ul>
                </div>
                <!--左边搜索结果列表 结束-->
                <!--左边分页 结束-->
                <div class="gongying_conLeft_con03">
					<p>显示 <?php if(count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                	<?php echo $page;?>
                </div>
                <!--左边分页 结束-->
                <!--左边内容 结束-->
            </div>
            <div class="gongying_conRight">
            	<!--右边列表01 开始-->
            	<!--<div class="gongying_conRight_con">
                    <div class="gongying_conRight_top">产品推荐</div>
                    <div class="gongying_conRight_list01">
                        <ul>
                            <li><a href="">欧时纳 秋冬季新款萌趣少女手提包斜挎包</a></li>
                            <li><a href="">豆鼓眼 帆布双肩电脑背包14寸电脑包旅行包书包</a></li>
                            <li><a href="">欧时纳 秋冬季新款萌趣少女手提包斜挎包</a></li>
                            <li><a href="">欧时纳 秋冬季新款萌趣少女手提包斜挎包</a></li>
                            <li><a href="">豆鼓眼 帆布双肩电脑背包14寸电脑包旅行包书包</a></li>
                        </ul>
                    </div>
                </div>-->
                <!--右边列表01 结束-->
                <!--右边列表02 开始-->
            	<div class="gongying_conRight_con">
                    <div class="gongying_conRight_top">猜您喜欢</div>
                    <div class="gongying_conRight_list02">
                        <ul>
                        	<li>
                       	    	<a class="list02_left" href="http://www.51ehw.com/index.php/home/GoToShop/42"><img src="images/logo2.png" width="89" height="90" alt=""/></a>
                                <p class="list02_right">
                                <a href="http://www.51ehw.com/index.php/home/GoToShop/42">冠杰文化</a><br>
                                <!--<a class="list02_a" href="http://www.51ehw.com/index.php/home/GoToShop/42">7系全新旗舰 7 MARK II！</a>-->
                                </p>
                            </li>
                            <li>
                       	    	<a class="list02_left" href="http://www.51ehw.com/index.php/home/GoToShop/42"><img src="images/logo2.png" width="89" height="90" alt=""/></a>
                                <p class="list02_right">
                                <a href="http://www.51ehw.com/index.php/home/GoToShop/42">冠杰文化</a><br>
                                <!--<a class="list02_a" href="http://www.51ehw.com/index.php/home/GoToShop/42">7系全新旗舰 7 MARK II！</a>-->
                                </p>
                            </li>
                            <li>
                       	    	<a class="list02_left" href="http://www.51ehw.com/index.php/home/GoToShop/42"><img src="images/logo2.png" width="89" height="90" alt=""/></a>
                                <p class="list02_right">
                                <a href="http://www.51ehw.com/index.php/home/GoToShop/42">冠杰文化</a><br>
                                <!--<a class="list02_a" href="http://www.51ehw.com/index.php/home/GoToShop/42">7系全新旗舰 7 MARK II！</a>-->
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--右边列表02 结束-->
            </div>
        </div>
	</div>
    <!--内容 结束-->

