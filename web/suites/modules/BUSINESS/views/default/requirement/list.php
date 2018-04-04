
    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<li class="gongying_liCurrent"><a href="javascript:;">更多需求信息</a></li>
                        <li><a href="<?php echo site_url('supply') ?>">更多供应信息</a></li>
                    </ul>
                </div>
                <div class="gongying_menu_right">
                	<div class="right_list right_scroll_top">
                    	<div class="scroll_title">新闻热点</div>
                        <ul class="scroll_infoList">
                            <?php if(isset($notice) && count($notice)>0){ ?>
                            <?php foreach ($notice as $nn){ ?>
                                <li><a href="<?php echo site_url('notice/detail/'.$nn['id']) ?>"><?php echo $nn['title'] ?></a></li>
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
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home") ?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url('requirement/more_require') ?>">更多需求信息</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
            	<!--左边头部 开始-->
            	<div class="gongying_conLeft_top">
                	<div class="gongying_conLeft_con">
                	<form action="<?php echo site_url('requirement/more_require') ?>" name="form" id="form" method="get">
                    	<!--分类下拉框-->
                        <span class="gongying_select">
                        	<span class="gongying_select_bg"></span>
                            <select class="gongying_conLeft_select01" name="assort" id="cate">
                                <option value="">全部分类</option>
                               
                                <?php if(count($res)): ?>
                                <?php foreach ($res as$r): ?>
                                 <option value="<?php echo $r['id'] ?>" <?php echo isset($assorts)&&$assorts==$r['id']?'selected':'' ?>><?php echo $r['cate_name'] ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </span>
                        <!--搜索-->
                        <span class="gongying_search">
                        <span class="gongying_search_bg"></span>
                        <input class="gongying_conLeft_search" type="text" placeholder="在该分类下搜索" value="<?php echo isset($keyword)?$keyword:'' ?>" name="search_name" id="sear">
                        <a href="javascript:;" class="gongying_search_btn" id="search">搜索</a>
                        </span>
                    </div>
                    </form>
                </div>
                <!--左边头部 结束-->
                <!--左边内容 开始-->
                <div class="gongying_conLeft_con01">
                	<span class="gongying_span80">分类</span>
                    <span class="gongying_span124">店铺</span>
                    <span class="gongying_span110">
                    	<select class="gongying_span_select" onchange="javascript:grade()" id="grade">
                        	<option value="">商家级别</option>
                            <option value="">全部</option>
                            <option value="1" <?php echo isset($stu)&&$stu==1?'selected':'' ?>>易货店会员</option>
                            <option value="2" <?php echo isset($stu)&&$stu==2?'selected':'' ?>>旗舰店会员</option>
                            <option value="3" <?php echo isset($stu)&&$stu==3?'selected':'' ?>>专卖店会员</option>
                        </select>
                    </span>
                	<span class="gongying_span450">需求描述</span>
                    <span class="gongying_span90">
                    	<select class="gongying_span_select" onchange="javascript:time()" id="time">
                        	<option value="">发布时间</option>
                            <option value="">全部</option>
                            <option value="4" <?php echo isset($times)&&$times==4?'selected':'' ?>>今天</option>
                            <option value="5" <?php echo isset($times)&&$times==5?'selected':'' ?>>三天内</option>
                            <option value="6" <?php echo isset($times)&&$times==6?'selected':'' ?>>一周内</option>
                            <option value="7" <?php echo isset($times)&&$times==7?'selected':'' ?>>一月内</option>
                        </select>
                    </span>
                </div>
                <!--左边搜索结果列表 开始-->
                <div class="gongying_conLeft_con02">
                	<ul>
                	<?php if(isset($list) && count($list)>0): ?>
                	<?php foreach ($list as $key => $ls): ?>
                	     <li <?php if(is_int($key/2)){echo 'class="gongying_conLeft_li"';}else{echo '';} ?>>
                        	<span class="gongying_span80 liSpan_80" style="width:70px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $ls['cate_name'] ?></span>
                            <span class="gongying_span124 liSpan_124" style="width:110px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $ls['corporation_name'] ?></span>
                            <span class="gongying_span110 liSpan_110" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php if($ls['grade']==1){echo '易货店会员';}elseif($ls['grade']==3){echo '专卖店会员';}elseif($ls['grade']==2){echo '旗舰店会员';}  ?></span>
                            <span class="gongying_span450 liSpan_450" style="width:450px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $ls['p_content'] ?></span>
                            <span class="gongying_span100 liSpan_90" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php /*if(strtotime($ls['create_at'])<=strtotime(date('Y-m-d 23:59:59'))){echo '今天';}*/echo date('Y-m-d',strtotime($ls['create_at'])) ?></span>
                         </li>
                	<?php endforeach; ?>
                	<?php else: ?>
                	
                	<?php endif; ?>
                    <!-- 	<li>
                        	<span class="gongying_span80 liSpan_80">酒类</span>
                            <span class="gongying_span124 liSpan_124">51啤酒品类专营店</span>
                            <span class="gongying_span110 liSpan_110">易货店会员</span>
                            <span class="gongying_span450 liSpan_450">急需200箱西凤酒、50箱百威、50箱珠江</span>
                            <span class="gongying_span100 liSpan_90">1小时前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">身体护肤</span>
                            <span class="gongying_span124 liSpan_124">纯天然呆</span>
                            <span class="gongying_span110 liSpan_110">旗舰店会员</span>
                            <span class="gongying_span450 liSpan_450">需求可悠然（KUYURA）美肌沐浴露（欣怡幽香）550ml（资生堂旗…</span>
                            <span class="gongying_span100 liSpan_90">10分钟前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">酒类</span>
                            <span class="gongying_span124 liSpan_124">51啤酒品类专营店</span>
                            <span class="gongying_span110 liSpan_110">易货店会员</span>
                            <span class="gongying_span450 liSpan_450">急需200箱西凤酒、50箱百威、50箱珠江</span>
                            <span class="gongying_span100 liSpan_90">1小时前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">身体护肤</span>
                            <span class="gongying_span124 liSpan_124">纯天然呆</span>
                            <span class="gongying_span110 liSpan_110">旗舰店会员</span>
                            <span class="gongying_span450 liSpan_450">需求可悠然（KUYURA）美肌沐浴露（欣怡幽香）550ml（资生堂旗…</span>
                            <span class="gongying_span100 liSpan_90">10分钟前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">酒类</span>
                            <span class="gongying_span124 liSpan_124">51啤酒品类专营店</span>
                            <span class="gongying_span110 liSpan_110">易货店会员</span>
                            <span class="gongying_span450 liSpan_450">急需200箱西凤酒、50箱百威、50箱珠江</span>
                            <span class="gongying_span100 liSpan_90">1小时前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">身体护肤</span>
                            <span class="gongying_span124 liSpan_124">纯天然呆</span>
                            <span class="gongying_span110 liSpan_110">旗舰店会员</span>
                            <span class="gongying_span450 liSpan_450">需求可悠然（KUYURA）美肌沐浴露（欣怡幽香）550ml（资生堂旗…</span>
                            <span class="gongying_span100 liSpan_90">10分钟前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>
                        <li>
                        	<span class="gongying_span80 liSpan_80">身体护肤</span>
                            <span class="gongying_span124 liSpan_124">纯天然呆</span>
                            <span class="gongying_span110 liSpan_110">旗舰店会员</span>
                            <span class="gongying_span450 liSpan_450">需求可悠然（KUYURA）美肌沐浴露（欣怡幽香）550ml（资生堂旗…</span>
                            <span class="gongying_span100 liSpan_90">10分钟前</span>
                        </li>
                        <li class="gongying_conLeft_li">
                        	<span class="gongying_span80 liSpan_80">食品类</span>
                            <span class="gongying_span124 liSpan_124">中国雾霾健康食品</span>
                            <span class="gongying_span110 liSpan_110">专卖店会员</span>
                            <span class="gongying_span450 liSpan_450">求购意大利进口 Ferrero Rocher费列罗榛果威化巧克力80份…</span>
                            <span class="gongying_span100 liSpan_90">2小时前</span>
                        </li>-->
                    </ul>
                </div>
                <!--左边搜索结果列表 结束-->
                <!--左边分页 结束-->
                <div class="gongying_conLeft_con03">
                	<div class="gongying_fenye">
                	   <p>显示 <?php if(isset($list) && count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                	<?php echo $pagination;?>
                    	<!-- <span class="gongying_fenye_front"><a href="">首页</a></span>
                    	<span class="gongying_fenye_last"><a href="">上一页</a></span>
                        <span><a href="">1</a></span>
                        <span class="gongying_fenye_xuanzhong"><a href="">2</a></span>
                        <span><a href="">3</a></span>
                        <span class="gongying_fenye_next"><a href="">下一页</a></span>
                        <span class="gongying_fenye_end"><a href="">尾页</a></span>-->
                    </div>
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

    <script>
    function time(){
        var time = $("#time").val();
        var grade = $("#grade").val();
        //alert(val);
        //if(val !=''){
         document.location = 'index.php/requirement/more_require/?&status='+grade+'&time='+time+'&search_name='+$('#sear').val()+'&assort='+$('#cate').val();
        //}
    }
    function grade(){
        var grade = $("#grade").val();
        var time = $("#time").val();
        //alert(val);
        //if(val !=''){
         document.location = 'index.php/requirement/more_require/?&status='+grade+'&time='+time+'&search_name='+$('#sear').val()+'&assort='+$('#cate').val();
        //}
    }
    $(function(){
        $('#search').click(function(){
            $('#form').submit();
        });
    });
    </script>
	