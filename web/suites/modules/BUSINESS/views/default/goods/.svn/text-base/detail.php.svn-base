<!--<link href="css/style_v2.css" rel="stylesheet" type="text/css">-->
	<style type="text/css">
    body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
	#allmap {height: 500px;width:100%;overflow: hidden;}
	#result {width:100%;font-size:12px;}
	dl,dt,dd,ul,li{
		margin:0;
		padding:0;
		list-style:none;
	}
	dt,.zongjia_tit{
		font-size:14px;
		font-family:"微软雅黑";
		font-weight:bold;
		margin:5px 0;
		line-height:30px;
		color:#000;
	}
	dd{
		padding:5px 0 0 5px;
	}
	
	#total_price{margin-left:45px;}
	</style>
   <script type="text/javascript" src="js/jquery.jqzoom.js"></script>
    <script type="text/javascript" src="js/base.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=8VUp1IbWAlMzjt4GoC5kuaf7"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
	<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
    <script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
    <script type="text/javascript" name="baidu-tc-cerfication" data-appid="8142189" src="http://apps.bdimg.com/cloudaapi/lightapp.js"></script>
<style>
.active{ background-image:none;}
</style>
<!--右侧轮播-->
<?php $this->load->view('navigation_bar');?>


<!--列表页、详细导航 结束-->
    <!--路径 开始-->
    <div class="w">
        <div class="nav-path">
           <span><a href="<?php echo site_url("goods/search/".$cate['id']);?>">所属分类：<?php echo $cate['name'];?></a></span>
        </div>
    </div>
    <!--路径 结束-->

   <!--商品详细内容 开始-->
    <div class="w clearfix">
        <!--放大镜 开始-->
        <div class="fl">
            <div id="preview" class="spec-preview">
			<span class="jqzoom">
				<?php if(count($gallery)>0){?>
					<img jqimg="<?php echo IMAGE_URL.$gallery[0]["file"]?>" src="<?php echo IMAGE_URL.$gallery[0]["file"];?>" />
				<?php }?>
			</span> 
			</div>
            <!--缩图开始-->
            <div class="spec-scroll clearfix"> <a class="pn-icon prev"></a> <a class="pn-icon next"></a>
                <div class="items clearfix">
                    <ul>
					<?php foreach ($gallery as $image){?>
                        <li><img bimg="<?php echo IMAGE_URL.$image['file'];?>" src="<?php echo IMAGE_URL.$image['file'];//base_url($image["image_name"]."_670".$image["file_ext"]);?>" onmousemove="preview(this);" ></li>
                    <?php }?>
                    </ul>
                </div>
            </div>
            <!--缩图结束-->
        </div>
        <!--放大镜 结束-->
        <!--商品信息 开始-->
        <div class="fl ml36">
            <h3><?php echo $details['name'];?></h3>
            <p><?php echo $details['short_desc'];?></p>
            <div class="ml136_box">
            	<p id="product_price">
				<?php if ($is_special) {?>
    				<span class="ogrinal_price" style="text-decoration:none;">特价：<span><?php echo number_format($details['special_price'], 2);?></del></span></span><br/>
    				<span class="ogrinal_price" style="text-decoration:none;">易货价：<span><del><?php echo number_format($details['vip_price'], 2);?></del></span></span>
				<?php }else if($tribeVIP){;?>
				    <span class="ogrinal_price" style="text-decoration:none;">部落价：<span style="color:red;font-weight: bold;"><?php echo number_format($details['tribe_price'], 2);?></del></span></span><br/>
				    <?php if($details['cat_id'] != 104164){;?><!-- 共享服务分类104164 -->
				    <span class="ogrinal_price" style="text-decoration:none;">易货价：<span><del><?php echo number_format($details['vip_price'], 2);?></del></span></span>
				    <?php };?>
				<?php }else{;?>
				    <span class="ogrinal_price" style="text-decoration:none;">易货价：<span><?php echo number_format($details['vip_price'], 2);?></span></span>
				<?php };?>
                <!-- 最多限制出现三个价格对比 start -->
               <?php if($details['market_price']){;?>
                参考价：<?php echo $details['market_price'];?><br/>
                <?php };?>
            </div>
            <div class="ml136_fenlei">
            
                <!-- sku处理 -->
            	<div id="sku">
            	<?php  if($details['is_delete']==0 && $attr_sku && $skuinfo){
            	         $i=0;//默认选择第一个
                         $html = "";
                         foreach($attr_sku as $val){
                             $html .= "<div>";
                             $html .= '<lable class="item sku_item"><font><font>'.$val['attr_name'].'： </font></font></lable>';
                             $html .= '<ul class="add_cart_size_list">';
                             foreach($val["sku_name"] as $k=>$v){
                                 if($i==0){
                                     $html .= '<input type="hidden" name="sku[]" value="'.$k.'" >';//选中的sku
                                 }
                                 $html .= '<li '.($i==0?"class='active'":"").' onclick="selectSKU(this,\''.$k.'\')">';
                                 $html .= '<font><font>'.$v.'</font></font>';
                                 $html .= '</li>';
                                 $i++;
                             }
                             $html .= '</ul>';
                             $html .= '</div>';
                             $i=0;
                         }
                         echo $html;
                 };?>
            	</div>
            	<!-- sku处理结束 -->
            	
                <dl id="quantity">
                    <?php if($details['stock']>0){?>
                	<dt>购物数量：</dt>
                    <dd>
                    	<span class="shuliang">
                            <a href="javascript:void(0);" onclick="reduce();" class="jian num_oper num_min">－</a>
                            <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1"  onkeyup="modify();"/>
                            <a href="javascript:void(0);" onclick="add();" class="jia num_oper num_plus">+</a>
                        </span>
                        <b class="caution_tips" id="item-error" style="display:none;"></b>
                    </dd>
                    <?php };?>
                </dl>

                <dl>
                    <dt>支付方式：</dt>
                    <dd>
                    	<ul class="ml136_fl01" id="pay_mode">
                		<?php if ($is_special) {?>
        				<li class="ml136_current"><a>特价</a></li>
        				<?php }else if($tribeVIP){;?>
    	                <li class="ml136_current"><a>部落价</a></li>
    				    <?php }else{;?>
    				    <li class="ml136_current"><a>易货价</a></li>
    				    <?php };?>
                        </ul>
                    </dd>
                </dl>
            </div>
            
            <p class="zongjia">
            	<span class="zongjia_tit">总价：</span>
                <span  id="total_price"> 
                <?php 
                if($is_special){//特价
                    echo number_format($details['special_price'], 2)."";
                }else if($tribeVIP){//部落价
                    echo number_format($details['tribe_price'], 2)."";
                }else{ //易货价
                    echo number_format($details['vip_price'], 2)."";
                };
                ?>
                </span>
                <br/>
                <span <?php echo $details['cat_id'] == 104164?"hidden":null; ?>><!-- 共享服务分类104164 -->
                    <span class="zongjia_tit">库存：</span>
                    <span  id="stock" style="margin-left:45px"  ><?php echo $details['stock'];?></span> 
                </span>
                <br/>
                <?php if(!$details["is_freight"]){;?>
                <span  <?php echo $details['cat_id'] == 104164?"hidden":null; ?>> <!-- 共享服务分类104164 -->
                    <span class="zongjia_tit" >运费：</span>
                    <span  id="freight" style="margin-left:45px"><?php echo "免运费";?></span>
                </span>
                <?php };?>
            </p>
           
            <div class="ml136_btn" id="operating">
            <?php if($details['is_on_sale'] != 1 || $details['is_delete']==1){;?>
                <div class="gouwuche"  style="background:#cc3333"><a href="javascript:void(0)" >此商品已下架</a></div>
            <?php }else if($details['stock']>0){?>
                <?php if(!$code){?><!-- 如果预览则不显示加入购物车操作 -->
            	<div class="gouwuche" ><a onclick="javascript:add_to_cart(<?php echo $id;?>,0,1)" >加入购物车</a></div>
                <div class="goumai" ><a onclick="javascript:add_to_cart(<?php echo $id;?>,0,2)">立即购买</a></div><br>
                <p>累计评价：<?php echo $all;?><a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $id;?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>
                <?php }; ?>
            <?php }else{?>
                <div class="gouwuche"  style="background:#cc3333"><a href="javascript:void(0)" >此商品暂时缺货</a></div>
                <p>累计评价：<?php echo $all;?><a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $id;?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>
            <?php };?>
            </div>
        </div>
        <!--商品信息 结束-->
        
        <!--店铺信息 开始-->
        <div class="fl ml37 d_logo" id="qq" style="display:none;">    
            <a href="<?php echo !empty($introduction)?site_url("corporate/information/index/1/".$corporation["id"]):site_url("home/GoToShop/".$corporation["id"]);?>"><img src="<?php echo $corporation["img_url"] != null ?IMAGE_URL.$corporation["img_url"]:"images/m_logo.jpg"?>" class="d_logo_img"  alt=""/></a>
            <div class="ml137_line"></div>
            <div class="ml137_line_top">
                <ul>
                <?php foreach ($recommend as $v):?>
                    <li><a href="<?php echo site_url('corporate/resource/detail').'/'.$v['id'].'/'.$corporation["id"];?>"><img src="<?php echo IMAGE_URL.$v['logo']?>"/> </a></li>
                <?php endforeach;?>
                </ul>
            </div>
            <div class="ml137_contact">
               <a><img src="images/ml_contact22.png" width="20" height="20" alt=""/>联系客服</a>
            </div>
            
            <div class="ml137_btn01"><a href="<?php echo site_url("home/GoToShop/{$corporation['id']}");?>">进入店铺</a></div>
            <div class="ml137_btn02"><a href="javascript:void(0)" onclick=collection_corp(<?php echo $corporation["id"];?>)>收藏店铺</a></div>


        </div>
        <!--店铺信息 结束-->
        
        <!--移入店铺显示出店铺名称-->
        <div class="popup">
        <ul class="popup_nei">
            <h4><?php echo $corporation["corporation_name"];?></h4>
            <li><span>供应等级：</span>
               <keyword>
               <?php 
               if($corp_amount['total_price']<500){
                   echo '<em><img src="images/huan1.png"/></em>';
               }else if($corp_amount['total_price'] >=500 && $corp_amount['total_price']<5000){
                   for($i=0;$i<2;$i++){
                       echo '<em><img src="images/huan1.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=5000 && $corp_amount['total_price']<20000){
                   for($i=0;$i<3;$i++){
                       echo '<em><img src="images/huan1.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=20000 && $corp_amount['total_price']<50000){
                   for($i=0;$i<4;$i++){
                       echo '<em><img src="images/huan1.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=50000 && $corp_amount['total_price']<100000){
                   for($i=0;$i<5;$i++){
                       echo '<em><img src="images/huan1.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=100000 && $corp_amount['total_price']<200000){
                       echo '<em><img src="images/zhuan.png"/></em>';
               }else if($corp_amount['total_price'] >=200000 && $corp_amount['total_price']<500000){
                   for($i=0;$i<2;$i++){
                       echo '<em><img src="images/zhuan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=500000 && $corp_amount['total_price']<1200000){
                   for($i=0;$i<3;$i++){
                       echo '<em><img src="images/zhuan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=1200000 && $corp_amount['total_price']<3000000){
                   for($i=0;$i<4;$i++){
                       echo '<em><img src="images/zhuan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=3000000 && $corp_amount['total_price']<8000000){
                   for($i=0;$i<5;$i++){
                       echo '<em><img src="images/huan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=8000000 && $corp_amount['total_price']<20000000){
                       echo '<em><img src="images/huan.png"/></em>';
               }else if($corp_amount['total_price'] >=20000000 && $corp_amount['total_price']<50000000){
                   for($i=0;$i<2;$i++){
                           echo '<em><img src="images/huan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=50000000 && $corp_amount['total_price']<150000000){
                   for($i=0;$i<3;$i++){
                           echo '<em><img src="images/huan.png"/></em>';
                   }
               }else if($corp_amount['total_price'] >=150000000 && $corp_amount['total_price']<500000000){
                   for($i=0;$i<4;$i++){
                           echo '<em><img src="images/huan.png"/></em>';
                   }
               }else if($corp_amount['total_price']>500000000){
                   for($i=0;$i<5;$i++){
                           echo '<em><img src="images/huan.png"/></em>';
                   }
               }
               ?>
               </keygen>
            </li>
           
            <li><span>交易勋章：</span>
               <keyword>
               <?php 
               if($month_amount['total_price']<10000){
                   echo '<em><img src="images/xuz.png"/></em>';
               }else if($month_amount['total_price'] >=10000 && $month_amount['total_price']<50000){
                   for($i=0;$i<2;$i++){
                       echo '<em><img src="images/xuz.png"/></em>';
                   }
               }else if($month_amount['total_price'] >=50000 && $month_amount['total_price']<200000){
                   for($i=0;$i<3;$i++){
                       echo '<em><img src="images/xuz.png"/></em>';
                   }
               }else if($month_amount['total_price'] >=200000 && $month_amount['total_price']<500000){
                   for($i=0;$i<4;$i++){
                       echo '<em><img src="images/xuz.png"/></em>';
                   }
               }else if($month_amount['total_price'] >=500000 ){
                   for($i=0;$i<5;$i++){
                       echo '<em><img src="images/xuz.png"/></em>';
                   }
               }
               ?>
               </keygen>
            </li>
           
            <li>
                <p>店铺管理人：<span><?php echo $corporation["corporation_name"];?></span></p>
                <p>联系电话：<span><?php echo substr($corporation['contact_mobile'],0,4).'****'.substr($corporation['contact_mobile'],-3);?></span></p>
                <p>所在地：<span><?php echo $corporation["address"];?></span></p>
            </li>
        </ul>
    </div>

    </div>
    <!--商品详细内容 结束-->

    <!--商品介绍、评价、热销 开始-->
    <div class="w clearfix">
        <div class="">
           <!--热销商品 开始-->
            <div class="fl ml138">
           	  <div class="ml138_top">热销产品</div>
                <div class="ml138_pic">
                	<ul>
                        <li>
                        	<a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/3116"><img src="http://images.51ehw.com/B/uploads/photos/2017/07/28/7034_20170728100022.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://www.51ehw.com/goods/detail/2265">冠普一体机 电脑</a></p>
                            <p style="color:#fea33b">M4100.00</p>
                        </li>
                        <li>
                        	<a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/1611"><img src="http://images.51ehw.com/B/uploads/photos/2017/04/17/3791_20170417153551.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/2272">法兰西尔干红葡萄酒 红酒</a></p>
                            <p style="color:#fea33b">M520.00</p>
                        </li>
                        
                        <li style="border-bottom:none">
                        	<a href="http://www.51ehw.com/index.php/_BUSINESS/Goods/detail/3041"><img src="http://images.51ehw.com/B/uploads/photos/2017/07/04/7034_20170704141956.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://www.51ehw.com/goods/detail/2342">鲜花饼 牡丹鲜花饼 五块/六块 盒装</a></p>
                            <p style="color:#fea33b">M25.00</p>
                        </li>
                    </ul>
                </div>
          </div>
            <!--热销商品 结束-->
    
            
            <!--商品介绍、评价 开始-->
            <div class="fl ">
                <div class="ml139 clearfix">
                    <ul id="tags">
                     	<li class="product_btn selectTag">
                        	<a onClick="selectTag('tagContent0',this)" href="javascript:void(0)">商品介绍<span></span></a>
                        </li>
                      	<li class="product_btn" >
                        	<a onClick="selectTag('tagContent1',this)" href="javascript:void(0)" >评价<span>(<?php echo $all;?>)</span></a>
                        </li>
                        <li class="product_btn">
                        	<a onClick="selectTag('tagContent2',this)" href="javascript:void(0)" >留言咨询(<?php echo count($advisory);?>)<span></span></a>
                        </li>
                        <?php if($details['latitude'] && $details['longitude']){;?>
                        <li class="product_btn">
                        	<a onClick="selectTag('tagContent3',this)" href="javascript:void(0)" >位置<span></span></a>
                        </li>
                        <?php };?>
                    </ul>
                </div>
            
                <div id="tagContent">
                    <!-- 商品介绍 -->
                    <div class="tagContent selectTag" id="tagContent0">
                        <!-- 属性 -->
                        <ul class="ml139_xinxi clearfix">
                    	<?php foreach($product_attr_values as $v){;?>
                            <?php if($v['attr_type']!='related' && $v['attr_type']!='sku'){;?>
                                <li><?php echo $v['attr_name']?>：<a style="color:#000000 "href="javascript:;" title="<?php echo $v['attr_value']?>"><?php echo $v['attr_value']?></a></li>
                            <?php };?>
                        <?php };?>
                        </ul>
                        <!-- 详情 -->
                        <div class="ml139_goods">
                        	<?php echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.IMAGE_URL,$details['desc']);?>
                        </div>
                    </div>
                    
                    <!-- 评价  -->
                    <div class="tagContent" id="tagContent1">
                        <div class="pingjia_top">
                        	<div class="pingjia_01">
                            	<p class="pingjia_score"><span><?php echo ($all?round(($good/$all)*100):0).'%';?></span></p><p>好评度</p>
                            </div>
                            <div class="pingjia_02">
                            	<ul>
                                	<li>
                                    	<span>好评（<?php echo ($all?round(($good/$all)*100):0).'%';?>）</span>
                                        <div class="bar">
                                        	<div class="bar_01"></div>
                                            <div class="bar_02" style="width:<?php echo ($all?round(($good/$all)*100):0).'%';?>"></div>
                                        </div>
                                    </li>
                                    <li>
                                    	<span>中评（<?php echo ($all?round(($in/$all)*100):0).'%';?>）</span>
                                        <div class="bar">
                                        	<div class="bar_01"></div>
                                            <div class="bar_02" style="width:<?php echo ($all?round(($in/$all)*100):0).'%';?>"></div>
                                        </div>
                                    </li>
                                    <li>
                                    	<span>差评（<?php echo ($all?round(($bad/$all)*100):0).'%';?>）</span>
                                        <div class="bar">
                                        	<div class="bar_01"></div>
                                            <div class="bar_02" style="width:<?php echo ($all?round(($bad/$all)*100):0).'%';?>"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="pingjia_03">
                            	<p>您可对已购商品进行评价</p>
                                <div class="pingjia_btn"><a href="<?php echo site_url('member/my_comment/get_list');?>" >发表评价</a></div>
                            </div>
                        </div>
                    
                        <div class="pingjia_con">
                        	<div class="pingjia_con_btn">
                            	<ul id='opt_comment'>
                                	<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(this,0)">全部<span id="all">(<?php echo $all;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(this,1)">好评<span id="good">(<?php echo $good;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(this,2)">中评<span id="in">(<?php echo $in;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(this,3)">差评<span id="bad">(<?php echo $bad;?>)</span></a></li>
                                </ul>
                            </div>
                            
                            <div class="pingjia_con_con clearfix" id="comment">
                            <!-- 评论内容  -->
                            </div>

                    
                        </div>
                    </div>
                  
                    <div class="tagContent tagContent-nei" id="tagContent2"> 
                        <?php if(!empty($advisory)){;?>
                        <ul class="message">
                            <?php foreach ($advisory as $v){;?>
                            <li>
                                <div class="message_l">
                                    <p class="message_l_01"><span class="message_l_03">昵称：<?php echo $v['nick_name']?></span><span class="message_l_04"><?php echo $v['created_content']?></span></p> 
                                    <p class="message_l_02"><span class="message_l_03">商家回复：</span><span class="message_l_05"><?php echo $v['replay_content']?></span> 
                                </div>
                                <div class="message_r"> 时间：<span><?php echo substr($v['created_at'],0,11);?></span> <span><?php echo substr($v['created_at'],11);?></span></div>
                            </li>
                            <?php }?>
                        </ul>
                        <?php }else{;?>
                        <p class="yanse-n">暂无留言</p>
                        <?php };?>
                        <div class="message_1" style="width:968px;"><a style=" float:none; margin:0px auto;" href="javascript:void(0);" onClick="show()">发表留言</a></div>
                    </div>
                   
                    <div class="tagContent" id="tagContent3"><div id="allmap" class="allmap"></div></div>
                </div>
            </div>
            <!--商品介绍、评价 结束-->
        </div>
    </div>
    <!--商品介绍、评价、热销 结束-->

<!--留言弹窗 -->
<div class="dingdan4_3_tanchuang" style=" display:none;">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">发布留言</div>
      <div class="dingdan4_3_tanchuang_top2">
        <ul>
         <li>
            <div class="company3 zhu1">
              <span class="tiao1">昵称：</span>
              <span  class="biaod" ><?php echo $this->session->userdata('user_name');?></span>
            </div>
            </li>
             <li>
         <div class="company3 zhu2"> 
         <span class="tiao1">留言：</span>
             <textarea  class="text"name="" cols="" rows=""  id="content" placeholder=" " style="outline: none"></textarea>
            </div>
            </li>
            </ul>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=$('.dingdan4_3_tanchuang').hide();>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">提交</a></div>       
      </div>
  </div>
</div>


<script type="text/javascript" src="js/ShoppingCart.js"></script>
<!--通用操作 弹窗end-->
<script type="text/javascript">
function show(){ 
	$('.dingdan4_3_tanchuang').show();
}

function selectTag(showContent,selfObj){
	// 操作标签
	var tag = $('#tags');
	var $Obj=$(selfObj.parentNode);

	//操作内容
	for(i=0; j=document.getElementById("tagContent"+i); i++){
		j.style.display = "none";
	}
	$("#"+showContent).css("display","block");
// 	document.getElementById(showContent).style.display = "block";
	$Obj.siblings().removeClass('selectTag');
	$Obj.addClass('selectTag');

}
</script>

    
    
<!--移入店铺显示出店铺名称-->
<script>
$("#qq").mouseover(function(){
$(".popup").show();

});

$("#qq").mouseout(function(){
$(".popup").hide();
});

$(".popup").mouseover(function(){
$(".popup").show();
});

$(".popup").mouseout(function(){
$(".popup").hide();
});
</script>
<!--移入店铺显示出店铺名称结束-->


<script>
$(function(){
	goods_comment();//评价内容
	
	//判断是否符合条件才执行
	<?php  if($details['is_delete']==0 && $attr_sku && $skuinfo){ ?>
	skuinfo = JSON.parse('<?php echo json_encode($skuinfo);?>');//SKU信息集合
	process();
	<?php };?>
});

//验证item_num，返回数量 mode模式：'-'减法，'+'减法，默认加入购物车
function check_item_num(mode){
    var status = true;//默认成功
    var x=$("#item_num").val();//加入购物车数量
    var max = parseInt($('#stock').text());//获取库存数量
    var is_num = new RegExp("^[1-9]\\d*$").test(x);//验证数据类型
    if(is_num){
        if(mode=='-'){
        	x--;
            if(x <= 0){
                var content = "商品数量最少为1!"; 
                var status = false;
            }else{
            	jQuery("#item_num").val(x);
            }
        }else if(mode=='+'){
            x++;
            if(max < x){
                var content = "数量不能超过库存!"; 
                var status = false;
            }else{
            	jQuery("#item_num").val(x);
            }
        }else{
        	if(max < x){
                var content = "购买数量不能超过库存!"; 
                var status = false;
            }
        }

    }else{
    	var content = "请输入正确的数量!"; 
    	var status = false;
    }
    if(status){
        jQuery('#item-error').html("");
        jQuery('#item-error').hide();
        return x;
    }else{
        jQuery('#item-error').html("<i class=\"ico\"></i>"+content);
        jQuery('#item-error').show();
        jQuery("#item_num").focus();
        return false;
    }
}


//加入购物车，pid商品id，sku_id，type:1加入购物车2立即购买
function add_to_cart(pid,sku_id,type)
{
	var qty = check_item_num();//验证item_num
	if(qty){
		add_cart(pid,qty,sku_id,type);
	}
}

//数量减法
function reduce(){
	x = check_item_num("-");//验证item_num
    if (x) {
		<?php  if($details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>

    }
}

//数量加法
function add(){
	x = check_item_num("+");//验证item_num
    if (x) {
		<?php  if($details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>
    }
}

//输入item_num
function modify(){
	//验证item_num
	x = check_item_num();
	if(x){
		<?php  if($details['is_delete']==0 && $attr_sku && $skuinfo){ ?>//sku结算
		process();
		<?php }else{?>//普通商品结算
		settlement();
		<?php };?>
	}
}


//普通商品结算
function settlement(){

	<?php if ($is_special) {?>//特价
	    var price = "<?php echo $details['special_price'];?>";
	<?php }else if($tribeVIP){;?>//部落价
	    var price = "<?php echo $details['tribe_price'];?>";
	<?php }else{;?>//易货价
	    var price = "<?php echo $details['vip_price'];?>";
	<?php };?>
	//验证item_num,数据不正确则默认1
	var item_num = check_item_num();
	if(!item_num){
	    var item_num = 1;
	}
	var total_price = price*item_num;//总价
	$("#total_price").html(formatCurrency(total_price)+"");//总价显示

}

</script>





<!-- sku操作开始 -->
<script>

//选择sku
function selectSKU(obj,attr_sku){
	$(obj).parent().find("li").removeClass();
	$(obj).addClass("active");
	$(obj).parent().find("input[name='sku[]']").val(attr_sku);
	process();
}


//sku处理
function process(){
	//拼接选中的sku集合
    var sku_val = "";
	$("input[name='sku[]']").each(function () {
        if(!sku_val){
            sku_val = $(this).val();
        }else{
        	sku_val += ":"+$(this).val();
        }
    });

    //循环匹配sku组合信息
	var html = "";
    jQuery.each(skuinfo, function(sku_id, val) {
        if(val["sku"]==sku_val){

        	//是否特价
			<?php if ($is_special) {?>
    		    html += '<span class="ogrinal_price" style="text-decoration:none;">特价：<span style="color:red;font-weight: bold;">'+val['info']['special_price']+'</del></span></span><br>';
    		    html += '<span class="ogrinal_price" style="text-decoration:none;">易货价：<span><del>'+val['info']['vip_price']+'</del></span></span>';
    		    var price = val['info']['special_price'];//单价
			<?php }else if($tribeVIP){;?>
    		    html += '<span class="ogrinal_price" style="text-decoration:none;">部落价：<span style="color:red;font-weight: bold;">'+val['info']['tribe_price']+'</del></span></span><br>';
    		    <?php if($details['cat_id'] != 104164){;?>//共享服务分类104164
    		    html += '<span class="ogrinal_price" style="text-decoration:none;">易货价：<span><del>'+val['info']['vip_price']+'</del></span></span>';
    		    <?php };?>
    		    var price = val['info']['tribe_price'];//单价
			<?php }else{;?>
			    html +='<span class="ogrinal_price" style="text-decoration:none;">易货价：<span>'+val['info']['vip_price']+'</span></span>';
			    var price = val['info']['vip_price'];//单价
			<?php };?>
			<?php if($details["market_price"]){ ?>
			 html +='参考价：<?php echo $details["market_price"];?><br/>';
			<?php }?>
			$("#product_price").html(html);//价格显示
			
			//验证item_num,数据不正确则默认1
			var item_num = check_item_num();
			if(!item_num){
			    var item_num = 1;
			}
			
			var total_price = price*item_num;//总价
			var stock = val['info']['stock'];//库存
			$("#total_price").html(formatCurrency(total_price)+"");//总价显示
			$("#stock").html(stock);//库存显示

			
        	//判断是否上架
			<?php if($details['is_on_sale'] != 1 || $details['is_delete']==1){;?>
		        html = '<div class="gouwuche"  style="background:#cc3333"><a href="javascript:void(0)" >此商品已下架</a></div>';
		        $("#operating").html(html);//此商品暂时缺货
            <?php }else{;?>
                if(val['info']['stock']>0){//判断库存
                	<?php if(!$code){?>//如果预览则不显示加入购物车操作
    				html = '<div class="gouwuche" ><a onclick="javascript:add_to_cart(<?php echo $details['id'];?>,'+sku_id+',1)" >加入购物车</a></div>';
    				html += '<div class="goumai" ><a onclick="javascript:add_to_cart(<?php echo $details['id'];?>,'+sku_id+',2)">立即购买</a></div><br>';
                    html += '<p>累计评价：<?php echo $all;?><a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $id;?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>';
                    $("#operating").html(html);//加入购物车操作显示
                    <?php };?>
                    $("#quantity").show();//数量操作显示
                }else{
                	html = '<div class="gouwuche"  style="background:#cc3333"><a href="javascript:void(0)" >此商品暂时缺货</a></div><p>累计评价：<?php echo $all;?><a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $id;?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>';
                    $("#quantity").hide();//数量操作隐藏
                    $("#operating").html(html);//此商品暂时缺货
                }
            <?php };?>
            
            return false;
        }
    }); 

}
</script>
<!-- sku操作接结束 -->
 
 
<script>

//收藏店铺
function collection_corp(corporation_id){
		$.ajax({
		      url: '<?php echo site_url("member/fav/store_corporation");?>',
		      type: 'POST',
		      data:{'pid':corporation_id},
		      dataType: 'html',
		      success: function(data){
					alert(data);
			    }
	    });
}

//发表留言
$('#sure').click(function(){
    var content = $('#content').val();
    var id = <?php echo $id;?>;
    $.post("<?php echo site_url('goods/add_advisory');?>",{content:content,id:id},function(data){
        switch(data['status']){
            case 0:
            	window.location.href='<?php echo site_url("customer/login");?>';
                break;
            case 1:
            	alert('请填写留言内容');
                break;
            case 2:
                alert('留言成功，等待审核中');
                $('.dingdan4_3_tanchuang').hide();
                $('#content').val("");
                break;
            case 4:
                alert('留言失败。');
                location.reload();
                break;
        }
    },"json");
});

</script>


<script>
    //ajax 查询评价内容，status:0全部1好评2中评3差评
    function goods_comment(obj,status){
        //特效
        if(obj){
        	$(".pingjia_current").removeClass("pingjia_current");
            $(obj).addClass("pingjia_current");
        }
        if(!status){
        	var status = 0;
        }
        var productid = "<?php echo $id;?>";//商品id
        $.post("<?php echo site_url('goods/comments');?>",{status:status,productid:productid},function(data){
     	    var html = '';
     	    if(data.length > 0 ){
            	for(var $i=0;$i<data.length;$i++){
            		html +='<div class="con_01 xiugai_01">';
                    html +='<div class="con_01_1 xiugai_01_1"><p>评论心得</p></div>';
                    html +='<div class="con_01_2 xiugai_01_2"><p>'+data[$i]['content']+'</p><span>'+data[$i]['create_at']+'</span><ul class="zan" style="display: none"><li><a>回复<span style="color:#72c312; padding:0">（0）</span></a></li><li><a>赞<span style="color:#72c312; padding:0">（0）</span></a></li></ul></div>';
                    if(data[$i]['reply_content']){
                    html +='<p class="comment_back">商家回复：<span>'+data[$i]['reply_content']+'</span></p>';
                    }
                    html +='</div>';
                    html +='<div class="con_02 xiugai_02">';
                    html +='<div class="con_02_1 xiugai_02_1"><p>满意度</p></div>';
                    html +='<div class="con_02_2 xiugai_02_2">';
                    html +='<ul>';
                              if(data[$i]['product_score']==1){
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                              }else if(data[$i]['product_score']==2){
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                              }else if(data[$i]['product_score']==3){
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                              }else if(data[$i]['product_score']==4){
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                              }else if(data[$i]['product_score']==5){
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                	  html +='<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                              }
                    html +='</ul>';
                    html +='</div>';
                    html +='</div>';
                    html +='<div class="con_03 xiugai_03">';
                    html +='<div class="con_03_1 xiugai_03_1"><p>评论者</p></div>';
                    html +='<div class="con_03_2 xiugai_03_2"><p>'+data[$i]['customer_name']+'***'+data[$i]['customer_name']+'</p><span>'+data[$i]['created_at']+'购买</span></div>';
                    html +='</div>';

                	}
            	$("#comment").html(html);
     	    }else {
     	    	$('#comment').empty();
         	    }
            },"json");
        }

</script>


<script type="text/javascript">
var longitude = "<?php echo !empty($details['longitude'])?$details['longitude']:null;?>";
var latitude = "<?php echo !empty($details['latitude'])?$details['latitude']:null;?>";
if(longitude && latitude){
	// 百度地图API功能
    var map = new BMap.Map('allmap');
    var poi = new BMap.Point(longitude,latitude);
    map.centerAndZoom(poi, 16);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
                    '地址：'+"<?php echo $details['address'];?>"+'<br/>' +
                  '</div>';

    //创建检索信息窗口对象
    var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
			width  : 50,             //宽度
			height : 40,              //高度
			panel  : "panel",         //检索结果面板
			enableAutoPan : true,     //自动平移
			searchTypes   :[
				BMAPLIB_TAB_SEARCH,   //周边检索
				BMAPLIB_TAB_TO_HERE,  //到这里去
				BMAPLIB_TAB_FROM_HERE //从这里出发
			]
		});
    var marker = new BMap.Marker(poi); //创建marker对象
    marker.enableDragging(); //marker可拖拽
    marker.addEventListener("click", function(e){
	    searchInfoWindow.open(marker);
    })
    map.panBy(494,250);
    map.addOverlay(marker); //在地图中添加marker
}
</script>

<script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript" src="js/recite_script.js"></script>   
<script type="text/javascript">addLoadEvent(Focus());</script>