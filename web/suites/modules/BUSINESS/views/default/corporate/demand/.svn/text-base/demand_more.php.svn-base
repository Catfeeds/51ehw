    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<li class="gongying_liCurrent"><a href="<?php echo site_url('corporate/demand/demand_more');?>">更多需求信息</a></li>
                        <li><a href="<?php echo site_url('goods/search/0') ?>">更多供应信息</a></li>
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
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home") ?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url('corporate/demand/demand_more') ?>">更多需求信息</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft1">
            	<!--左边头部 开始-->
            	<div class="gongying_conLeft_top">
                	<div class="gongying_conLeft_con">
                	<!--  <form action="<?php echo site_url('requirement/more_require') ?>" name="form" id="form" method="get"> -->
                    	<!--分类下拉框-->
                        <span class="gongying_select">
                        	<span class="gongying_select_bg"></span>
                            <select class="gongying_conLeft_select01" name="assort" id="cate" onchange="category()">
                                <option value="">全部分类</option>
                                <?php foreach ($categorys as $v){?>
                                <option value="<?php echo $v['id'];?>" <?php echo isset($cate_id)&&$cate_id==$v["id"]?"selected":"" ?>><?php echo $v['name']?></option>
                                <?php };?>
                            </select>
                        </span>
                        <!--搜索-->
                        <span class="gongying_search">
                        <span class="gongying_search_bg"></span>
                        <input class="gongying_conLeft_search" type="text" placeholder="在该分类下搜索" value="<?php echo isset($keyword)?$keyword:'' ?>" name="search_name" id="sear">
                        <a href="javascript:void(0);" class="gongying_search_btn" id="search" onclick=category();>搜索</a>
                        </span>
                    </div>
                    <!-- </form>  -->
                </div>
                <!--左边头部 结束-->
                <!--左边内容 开始-->
                <!--左边搜索结果列表 开始-->
             <div class="list">
		<ul>
		<?php foreach ($requirement as $v){?>
		    <li class="list-one">
		        <div class="list-one-right">		      
		         <h4><?php echo $v['p_name']?></h4>
		           <p class="p1"><span class="right-text1">期望单价：<span class="right-text2"><?php echo $v['min_vip_price']?>-<?php echo $v['max_vip_price']?>货豆</span></span> <span class="right-text3">数量：<span class="right-text4"><?php echo $v['p_count']?>件</span></span></p>
		           <p class="p2"><span class="right-text5">收货地：<span class="right-text6"><?php echo $v['shippingaddress'];?></span></span> <span class="right-text7">发布时间：<span class="right-text8"><?php echo $v['create_at'];?></span></span></p>
		           <!-- <p class="right-text9">补充说明：</p>
		           <p class="right-text10">需要1950年－2010年期间的产自法国诺儿山庄的卡斯特干红葡萄酒，一级的生产。需要1950年－2010年期间的产自法国诺儿山庄的卡斯特干红葡萄酒，一级的生产 -->
		           <a href="<?php echo site_url('corporate/demand/demand_details').'/'.$v['id'];?>" class="right-text11">详情></a></p>	    
		        </div>
		    </li>
		<?php };?>
		</ul>
        
        <div class="gongying_conLeft_con03" style="display:none;">
                	<div class="gongying_fenye">
                	   <p>没有你想要搜索的企业</p>
                    </div>
                </div>
    <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">        
                <div class="showpage showpage_right">
                <?php echo $page;?>
				</div>
	</div>
     </div>               <!--左边搜索结果列表 结束-->
                <!--左边分页 结束-->
            
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
<!--             	<div class="gongying_conRight_con"> -->
<!--                     <div class="gongying_conRight_top">猜您喜欢</div> -->
<!--                     <div class="gongying_conRight_list02"> -->
<!--                         <ul> -->
<!--                         	<li> -->
<!--                        	    	<a class="list02_left" href="#"><img src="images/as1.jpg" alt=""/></a> -->
<!--                             </li> -->
<!--                             <li> -->
<!--                        	    	<a class="list02_left" href="#"><img src="images/as1.jpg"alt=""/></a> -->
<!--                             </li> -->
<!--                             <li> -->
<!--                        	    	<a class="list02_left" href="#"><img src="images/as1.jpg"alt=""/></a> -->
<!--                             </li> -->
<!--                         </ul> -->
<!--                     </div> -->
<!--                 </div> -->
                <!--右边列表02 结束-->
            </div>
        </div>
	</div>
    <!--内容 结束-->


    <script type="text/javascript">
    //选择分类
    function category(){
        var search_val = encodeURI($('input[name=search_name]').val());
        var cate_id = $('#cate').val();
        if(cate_id){
            document.location="<?php echo site_url('corporate/demand/cate_search/');?>"+'/'+cate_id+'/'+search_val
        }else{
        	document.location="<?php echo site_url('corporate/demand/demand_more');?>"+'/'+search_val;
            }
        }
    </script>
	