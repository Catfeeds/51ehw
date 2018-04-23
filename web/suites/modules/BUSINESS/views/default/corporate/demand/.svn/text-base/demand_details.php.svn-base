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
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home") ?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url('corporate/demand/demand_more');?>">更多需求信息</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft1">
            	<!--左边头部 开始-->
                <!--左边头部 结束-->
                <!--左边内容 开始-->
                <!--左边搜索结果列表 开始-->
             <div class="result">
		<div class="biaoti">
			<h4><span class="line_1">标题</span></h4>
			<ul>
			    <li><span class="biaoti-text1 text-head">标题：<span class="biaoti-text2"><?php echo $details['title']?></span></span></li>
			    <li><span class="biaoti-text3">分类：<span class="biaoti-text4"><?php echo $details['name']?></span></span></li>
			</ul>
		</div>
		<div class="xuqiu">
			<h4><span class="line_1">需求产品</span></h4>
			<ul>
			    <li><span class="biaoti-text1 text-head">现货/加工：<span class="xuqiu-text1">现货/标准品</span></span></li>
			    <li><span class="biaoti-text1">产品名称：<span class="xuqiu-text2"><?php echo $details['p_name']?></span></span></li>
			    <li><span class="biaoti-text1">数量：<span class="xuqiu-text3"><?php echo $details['p_count']?></span></span></li>
			    <li><span class="biaoti-text1">单位：<span class="xuqiu-text4"><?php echo $details['unit']?></span></span></li>
			    <li><span class="biaoti-text1">价格区间：<span class="xuqiu-text5"><?php echo $details['min_vip_price']?>-<?php echo $details['max_vip_price']?>提货权</span></span></li>
			    <li><span class="biaoti-text1">产品描述：<span class="xuqiu-text6"><?php echo $details['p_content']?></span></span></li>
			    <?php if(!empty($details['img_path'])){?>
			    <li><span class="biaoti-text1">图片/图纸/文档：
			    <a href="javascript:void(0);" onclick="downloads()" class="xuqiu-fujian">点击下载附件</a></span></li>
			    <form action="<?php echo site_url('corporate/demand/download');?>" method='post' id="download">
			    <input type="hidden" name="file_name" value="<?php echo $details['img_path'];?>">
			    </form>
			    <?php };?>
			</ul>
		</div>
		<div class="caigou">
			<h4><span class="line_1">采购要求</span></h4>
			<ul>
			    <li><span class="biaoti-text1 text-head">报价截止时间：<span class="caigou-text1"><?php echo $details['effectdate']?></span></span></li>
			    <li><span class="biaoti-text1">期望收货日期：<span class="caigou-text2"> <?php echo $details['receiptdate']?></span></span></li>
			    <li><span class="biaoti-text1">报价要求：<span class="caigou-text3"><?php echo $details['receiptdate']==0?"需要报含税价":"不含税价"?></span></span></li>
			    <li><span class="biaoti-text1">收货地：<span class="caigou-text4"><?php echo $details['shippingaddress'];?></span></span></li>
			    <li><span class="biaoti-text1">补充说明：<span class="caigou-text5"><?php echo $details['requireremark']?></span></span></li>
			    <!-- <li><span class="biaoti-text1">联系人：<span class="caigou-text6"><?php //echo $details['contactuser']?><?php //$corporation_id = $this->session->userdata('corporation_id');$corporation_status = $this->session->userdata('corporation_status');if(isset($corporation_id) && $corporation_status == 1){echo $details['contactuser'];};?></span></span></li>
			    <li><span class="biaoti-text1">电话：<span class="caigou-text7"><?php //$corporation_id = $this->session->userdata('corporation_id');$corporation_status = $this->session->userdata('corporation_status');if(isset($corporation_id) && $corporation_status == 1){echo $details['contactphone'];};?></span></span></li> -->
			</ul>
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
<!--             	<div class="gongying_conRight_con1"> -->
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
    function downloads(){
        $('#download').submit();
        }
    </script>


	