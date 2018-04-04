 <?php //print_r($skuinfo);exit;?>
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
				<?php if(count($gallery)>0){
					//print_r($gallery);
				    if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){ ?>
				        <img jqimg="<?php echo 'http://www.test51ehw.com/uploads/C/'.$gallery[0]["file"]?>" src="<?php echo 'http://www.test51ehw.com/uploads/C/'.$gallery[0]["file"]//base_url($gallery[0]["image_name"]."_670".$gallery[0]["file_ext"])?>" />
				 <?php   }else{?>
					<img jqimg="<?php echo IMAGE_URL.$gallery[0]["file"]?>" src="<?php echo IMAGE_URL.$gallery[0]["file"]//base_url($gallery[0]["image_name"]."_670".$gallery[0]["file_ext"])?>" />
				<?php  } }?>

			</span> </div>
            <!--缩图开始-->
            <div class="spec-scroll clearfix"> <a class="pn-icon prev"></a> <a class="pn-icon next"></a>
                <div class="items clearfix">
                    <ul>
					<?php foreach ($gallery as $image){?>
                         <?php   if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){ ?>
								<img bimg="<?php echo 'http://www.test51ehw.com/uploads/C/'.$image['file'];?>" src="<?php echo  'http://www.test51ehw.com/uploads/C/'.$image['file'];//base_url($image["image_name"]."_670".$image["file_ext"]);?>" onmousemove="preview(this);" >
						  <?php }else{ ?>
						      <img bimg="<?php echo IMAGE_URL.$image['file'];?>" src="<?php echo IMAGE_URL.$image['file'];//base_url($image["image_name"]."_670".$image["file_ext"]);?>" onmousemove="preview(this);" >
						  <?php  }?>

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
			<input type="hidden" name="product_id" value="<?php echo $details['id'];?>">
			<input type="hidden" name="payment_id" value="2">
            <div class="ml136_box">

            	<p id="product_price">
				<?php if ($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")) {?>
				<span class="ogrinal_price" style="text-decoration:none;">特价：   <span><?php echo number_format($details['special_price'], 2);?> 货豆</del></span></span>
				<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span><del><?php echo number_format($details['vip_price'], 2);?> 货豆</del></span></span>
				<?php }else{;?>
				<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span><?php echo number_format($details['vip_price'], 2);?> 货豆</span></span>
				<?php };?>
                <!-- 最多限制出现三个价格对比 start -->
               <?php if($details['market_price']): ?>
                参考价：<?php echo $details['market_price'];?><br/>
                <?php endif; ?>
            </div>
            <div class="ml136_fenlei">
            	<div id="sku"></div>
                <dl id="quantity">
                    <?php if($details['stock']>0){?>
                	<dt>购物数量：</dt>
                    <dd>
                    	<span class="shuliang">
							 <a href="javascript:jQuery.reduce('#item_num');" class="jian num_oper num_min">－</a>
							 <input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1"  onkeyup="jQuery.modify('#item_num');"/>

							 <a href="javascript:jQuery.add('#item_num')" class="jia num_oper num_plus">+</a>
							 <input id="item_amount" type="hidden" value="<?php echo $details['stock'];?>"/>

                        </span>
                        <b class="caution_tips" id="item-error" style="display:none;"></b>
                    </dd>
                    <?php };?>
                </dl>

                <dl>
                	<dt>支付方式：</dt>
                    <dd>
                    	<ul class="ml136_fl01" id="pay_mode">
							<?php
							$pay_modeflag = 0;
							if($details['vip_price'] > 0){
								$pay_modeflag = 1?>
                        	<li class="ml136_current"><a>易货价</a></li>
							<?php }?>
							<?php /*if($details['m_price'] > 0){ ?>
                            <li <?php if($pay_modeflag==0){?>class="ml136_current"<?php }?>><a>零售价</a></li>
							<?php }*/?>

                        </ul>
                    </dd>
                </dl>
				<input type="hidden" name="payflag" value="<?php if($details['vip_price'] > 0){echo 1;}else{ echo 2;} ?>">
                <input type="hidden" id="val_id" value=0>

            </div>
            <!--<p class="zongjia">总价：<span  id="total_price"> <?php //echo $details['vip_price'] == 0 ? number_format($details['m_price'],2):number_format($details['vip_price'], 2);?> 货豆</p>-->
            <p class="zongjia">
            	<span class="zongjia_tit">总价：</span>
                <span  id="total_price"> 

                <?php 
                if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") ){
                    echo number_format($details['special_price'], 2);
                }else{ 
                    echo number_format($details['vip_price'], 2);
                };
                ?>货豆</span>
                <br/>

                <span class="zongjia_tit" >库存：</span>
                <span  id="stock" style="margin-left:45px"><?php echo $details['stock'];?></span> 
                <br/>
               <span class="zongjia_tit" >运费：</span>
                <span  id="freight" style="margin-left:45px"><?php echo $details['logistics_id'] ? $details['fitst_freight'] : '免运费'?></span>
            
            </p>
           
            <div class="ml136_btn">
                <?php if($details['is_on_sale'] != 1 || $details['is_delete']==1){;?>
                <div class="gouwuche" id="gouwuche" style="background:#cc3333"><a href="javascript:void(0)" >此商品已下架</a></div>
                <?php }else if($details['stock']>0){?>
            	<div class="gouwuche" id="gouwuche"><a onclick="javascript:add_to_cart(<?php echo $details['id'];?>,this)" >加入购物车</a></div>
                <div class="goumai" id="goumai"><a onclick="javascript:buy(<?php echo $details['id'];?>)">立即购买</a></div><br>
                <p><!-- 累计评价：  --><?php //echo $all?>   <a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $details['id'];?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>
                <?php }else{?>
                <div class="gouwuche" id="gouwuche" style="background:#cc3333"><a href="javascript:void(0)" >此商品暂时缺货</a></div>
                <p><!-- 累计评价：  --><?php //echo $all?>   <a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $details['id'];?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>
                <?php };?>
            </div>
        </div>
        <!--商品信息 结束-->
        <!--店铺信息 开始-->
        <div class="fl ml37 d_logo" id="qq">
            
            <a href="<?php echo !empty($introduction)?site_url("corporate/information/index/1/".$corp_id):site_url("home/GoToShop/".$corp_id);?>"><img src="<?php echo $corp_logo != null ?IMAGE_URL.$corp_logo:"images/m_logo.jpg"?>" class="d_logo_img"  alt=""/></a>
            <!--<p class="d_logo_p"><?php //echo $corp_name?></p>-->
          <div class="ml137_line"></div>
          <div class="ml137_line_top">
             <ul>
             <?php foreach ($recommend as $v):?>
               <li><a href="<?php echo site_url('corporate/resource/detail').'/'.$v['id'].'/'.$corp_id;?>"><img src="<?php echo IMAGE_URL.$v['logo']?>"/> </a></li>
             <?php endforeach;?>
<!--                <li><a href="#"><img src="images/qis1.jpg"/> </a></li> -->
             </ul>
          
          </div>
            <div class="ml137_contact">
               <a>	<img src="images/ml_contact22.png" width="20" height="20" alt=""/>联系客服</a>
            </div>
          <div class="ml137_btn01"><a href="<?php echo site_url("home/GoToShop/".$corp_id)?>">进入店铺</a></div>
          <div class="ml137_btn02"><a href="javascript:void(0)" onclick=corporation(<?php echo $corp_id;?>)>收藏店铺</a></div>
          <!--推荐语展示 只放3个 每个的字数限制在28个以内-->
          <!-- tab 切换 开始 -->
          <?php //if(!empty($recommend)){;?>
          <!--<div id="tFocus">
            <div id="tFocusBtn">
                <a href="javascript:void(0);" id="tFocus-leftbtn">上一张</a>
                <div id="tFocus-btn">
                    <ul class="clearfix">
                        
                        <?php //foreach($recommend as $k => $v):?>
                        <?php //if($k==0){;?>
                        <li class="active"><img src="<?php //echo IMAGE_URL.$v['logo'];?>" width="40" /></li>
                        <?php //}//else{;?>
                        <li ><img src="<?php //echo IMAGE_URL.$v['logo'];?>" width="40" /></li>
                        <?php //if(count($recommend)==2){;?>
                        <li style="display:none"><img src="<?php //echo IMAGE_URL.$v['logo'];?>" width="40" /></li>
                        <?php //};?>
                        <?php //};?>
                        <?php //endforeach;?>
<!--                         <li><img src="images/706-13111Q1234X03.jpg" width="40" /></li> -->
                    <!--</ul>
                </div>
                <a href="javascript:void(0);" id="tFocus-rightbtn">下一张</a>
            </div>
            
            <div class="prev" id="prev"></div>
            <div class="next" id="next"></div>
            <ul id="tFocus-pic">
            <!-- 会员背书 -->
            <?php //foreach($recommend as   $v):?>
                <!--<li>
                    <?php //foreach($v['recommend_language'] as $val):?>
                    <div class="recite_p clearfix"><span>*</span><p><a><?php //echo $val;?></a></p></div>
                    <?php //endforeach;?>
                </li>
            <?php //endforeach;?>
            <?php //if(count($recommend)==2){;?>
                <li style="display:none"></li>
            <?php //};?>
<!--                 <li> -->
<!--                     <div class="recite_p clearfix"><span>*</span><p><a>4是中国百强户外媒体供应商、西安电梯广告平面运</a></p></div> -->
<!--                     <div class="recite_p clearfix"><span>*</span><p><a>4广告是中国百强户外媒体供应商、西安电梯广告平面运</a></p></div> -->
<!--                     <div class="recite_p clearfix"><span>*</span><p><a>4是中国百强户外媒体供应商、西安电梯广告平面运</a></p></div> -->
<!--                 </li> -->
            <!--</ul>
        
        </div><!-- tab bd切换 结束 -->
        <?php //};?>
        </div>
        <!--店铺信息 结束-->
        <!--移入店铺显示出店铺名称-->
       <div class="popup">
         <ul class="popup_nei">
           <h4><?php echo $corp_name;?></h4>
           <li><span>供应等级：</span><keyword>
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
           </keygen></li>
           <li><span>交易勋章：</span><keyword>
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
           </keygen></li>
           <li>
             <p>店铺管理人：<span><?php echo $contact_name;?></span></p>
             <p>联系电话：<span><?php echo substr($contact_mobile,0,4).'****'.substr($contact_mobile,-3);?></span></p>
             <p>所在地：<span><?php echo $corporation_area;?></span></p>
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
                        	<a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/846"><img src="http://c.test51ehw.com/uploads/C/uploads/photos/2016/04/07/1327_20160407111025.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/846">爱玛 运动 山地 自行车 AM6900-A 黑红色、黑灰色、白蓝色</a></p>
                            <p style="color:#fe4101">M3,000.00</p>
                        </li>
                        <li>
                        	<a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/403"><img src="http://c.test51ehw.com/uploads/C/uploads/photos/2016/04/07/1324_20160407161520.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/403">【酒店住宿】西安喜来登大酒店 行政间住宿券 含双早</a></p>
                            <p style="color:#fe4101">M3,300.00</p>
                        </li>
                        
                        <li style="border-bottom:none">
                        	<a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/295"><img src="http://c.test51ehw.com/uploads/C/uploads/product/295/20151224163515_270.jpg" width="175" height="175" alt=""/></a>
                            <p><a href="http://c.test51ehw.com/index.php/_CLIENT/Goods/detail/295">青花瓷30年陈酿248ml*2</a></p>
                            <p style="color:#fe4101">M488.00</p>
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
                  	<!-- <li class="product_btn" >
                    	<a onClick="selectTag('tagContent1',this)" href="javascript:void(0)" >评价<span>(<?php echo $all;?>)</span></a>
                    </li> -->
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
                  <div class="tagContent selectTag" id="tagContent0">
                  	<ul class="ml139_xinxi clearfix">
                  	<?php 
                        $res = array();
                        foreach($product_attr_values as $item) {
                            if(! isset($res[$item['attr_id']])) $res[$item['attr_id']] = $item;
                            else $res[$item['attr_id']]['attr_value'] .= ',' . $item['attr_value'];
                        }
                        
                        $product_attr_values = array_values($res);
                  	
                  	?>
                    	<li><?php foreach($product_attr_values as $v):	 ?>
                <?php if($v['attr_type']!='related' && $v['attr_type']!='sku'):?><li><?php echo $v['attr_name']?>：<a style="color:#000000 "href="javascript:;" title="<?php echo $v['attr_value']?>"><?php echo $v['attr_value']?></a></li><?php endif;?>
            <?php endforeach; ?>
                    </ul>
                    <div class="ml139_goods">
                    	<?php //echo $details['desc'];
                  	     if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){
                  	          echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.'http://www.test51ehw.com/uploads/C/',$details['desc']);
                  	     }else{ 
                    	       echo preg_replace('/src="http:\/\/www.51ehw.com\/uploads\/B\/|src="http:\/\/www.51ehw.com\//','src="'.IMAGE_URL,$details['desc']);
                    	 }?>
                	 </div>
                  </div>
                  <div class="tagContent" id="tagContent1">
                  		<div class="pingjia_top">
                        	<div class="pingjia_01">
                            	<p class="pingjia_score">
                            		<span><?php echo ($all?round(($good/$all)*100):0).'%';?></span>
                                </p>
                                <p>好评度</p>
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
                                	<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(1,'<?php echo $id;?>')">全部<span id="all">(<?php echo $all;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(2,'<?php echo $id;?>')">好评<span id="good">(<?php echo $good;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(3,'<?php echo $id;?>')">中评<span id="in">(<?php echo $in;?>)</span></a></li>
                                    <li><a herf="javascript.void(0)" onclick="goods_comment(4,'<?php echo $id;?>')">差评<span id="bad">(<?php echo $bad;?>)</span></a></li>
                                </ul>
                            </div>
                            <!-- 评论框1开始  -->
                            <?php if(isset($comments['0']['id'])):?>
                            <div class="pingjia_con_con clearfix" id="comment">
                            <?php foreach ($comments as $k => $v):?>

                            	<div class="con_01 xiugai_01">
                                	<div class="con_01_1 xiugai_01_1">
                                    	<p>评论心得</p>
                                    </div>
                                    <div class="con_01_2 xiugai_01_2">
                                    	<p><?php echo $v['content'];?></p>
                                        <span><?php echo $v['create_at'];?></span>
                                        <ul class="zan" style="display: none">
                                            <li><a>回复<span style="color:#72c312; padding:0">（0）</span></a></li>
                                            <li><a>赞<span style="color:#72c312; padding:0">（0）</span></a></li>
                                        </ul>
                                    </div>
                                    <!--商家回复 start-->
                                    <?php if(!empty($v['reply_content'])){?>
                                    <p class="comment_back">商家回复：<span><?php echo $v['reply_content']?></span></p>
                                    <?php };?>
                                    <!--商家回复 end-->
                                </div>
                                <div class="con_02 xiugai_02">
                                	<div class="con_02_1 xiugai_02_1">
                                    	<p>满意度</p>
                                    </div>
                                    <div class="con_02_2 xiugai_02_2">
                                          <ul>
                                          <?php
                                          switch ($v['product_score']){
                                              case 1:
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                                              break;
                                              case 2:
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                                              break;
                                              case 3:
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                                              break;
                                              case 4:
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star02.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                                              break;
                                              case 5:
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a>';
                                                echo '<a><img src="images/pingjia_star01.png" width="21" height="21" alt=""/ style="margin-right:0"></a>';
                                              break;
                                          }
                                          ?>
                                          </ul>
                                     </div>
                                </div>
                                <div class="con_03 xiugai_03">
                                	<div class="con_03_1 xiugai_03_1">
                                    	<p>评论者</p>
                                    </div>
                                    <div class="con_03_2 xiugai_03_2">
                                    	<p><?php echo $v['name'][0];?>***<?php echo substr($v['name'],-1);?></p>
										<span><?php echo substr($v['place_at'],0,16)?> 购买</span>
                                    </div>
                                </div>

                            <?php endforeach;?>
                            </div>
                            <?php endif;?>
                            <!-- 评论框1结束 -->

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
                      <div class="message_r"> 时间：<span><?php echo substr($v['created_at'],0,11);?></span> <span><?php echo substr($v['created_at'],11);?></span>
                      </div>
                        </li>
                      <?php }?>
                      </ul>
                  <?php }else{;?>
                  <p class="yanse-n">暂无留言</p>
                  <?php };?>
                  <div class="message_1" style="width:968px;"><a style=" float:none; margin:0px auto;" href="javascript:void(0);" onClick="show()">发表留言</a></div>
                   </div>
                   
                     <div class="tagContent" id="tagContent3"> 
                   <div id="allmap" class="allmap"></div>
                     </div>
                   

                </div>
                
            

            </div>
            <!--商品介绍、评价 结束-->
        </div>
    </div>
    <!--商品介绍、评价、热销 结束-->

<!--通用操作 弹窗start-->
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
<input type="text" value="1" id="status_" hidden>
<!--通用操作 弹窗end-->
<script type="text/javascript">

function show(){ 
	<?php if(!$this->session->userdata('user_in')):
	 $url = site_url($_SERVER['PATH_INFO']);
     $this->session->set_userdata("redirect",$url);?>
		 
		window.location.href="<?php echo site_url("Customer/login");?>";
	<?php else:?>
	$('.dingdan4_3_tanchuang').show();
    <?php endif;?>
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



 <script type="text/javascript">
jQuery.extend( {
    min : 1,
    reg : function(x) {
        jQuery('#item-error').html("");
        jQuery('#item-error').hide();
        return new RegExp("^[1-9]\\d*$").test(x);
    },
    amount : function(obj, mode) {
        var x = jQuery(obj).val();
        if (this.reg(parseInt(x))) {
            if (mode) {
                x++;
            } else {
                x--;
            }
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>请输入正确的数量！");
            jQuery('#item-error').show();
            jQuery(obj).val(1);
            jQuery(obj).focus();
        }
        return x;
    },
    reduce : function(obj) {
        var x = this.amount(obj, false);
        
        if (parseInt(x) >= this.min) {
            jQuery(obj).val(x);
            <?php if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") && empty($skuinfo['skuinfo']) && empty($skuinfo['skulist']) && empty($skuinfo['skuitem'])){?>//判断是否特价商品
			$("#total_price").text((special_price * x).toFixed(2)+" 货豆");
			<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
			$("#total_price").text((sku_special_offer * x).toFixed(2)+" 货豆");
			<?php }else{?>
			$("#total_price").text((curr_price * x).toFixed(2)+" 货豆");
			<?php };?>
			count_freight(parseInt(x));
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>商品数量最少为" + this.min
                    + "！");
            jQuery('#item-error').show();
            jQuery(obj).val(1);
            jQuery(obj).focus();
        }
    },
    add : function(obj) {
        var x = this.amount(obj, true);//获取所选的数量
        var max = jQuery('#item_amount').val();//获取库存数量
        if (parseInt(x) <= parseInt(max)) {
            jQuery(obj).val(x);
            <?php if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") && empty($skuinfo['skuinfo']) && empty($skuinfo['skulist']) && empty($skuinfo['skuitem'])){?>//判断是否特价商品
			$("#total_price").text((special_price * x).toFixed(2)+" 货豆");
			<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
			$("#total_price").text((sku_special_offer * x).toFixed(2)+" 货豆");
			<?php }else{?>
			$("#total_price").text((curr_price * x).toFixed(2)+" 货豆");
			<?php };?>
			count_freight(parseInt(x));
        } else {
            jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");
            jQuery('#item-error').show();
            jQuery(obj).val(max == 0 ? 1 : max);
            jQuery(obj).focus();
        }
    },
    modify : function(obj) {
        var x = jQuery(obj).val();
       
        jQuery(obj).val(x.replace(/\D|^0/g,''));     
        var max = jQuery('#item_amount').val();
        if (!this.reg(parseInt(x))) {
//                jQuery(obj).val(1);
            jQuery(obj).focus();
            jQuery('#item-error').html("<i class=\"ico\"></i>请输入正确的数量！");
            jQuery('#item-error').show();
            return;
        }
        var intx = parseInt(x);
        var intmax = parseInt(max);
        if (intx < this.min) {
            jQuery('#item-error').html("<i class=\"ico\"></i>商品数量最少为" + this.min
                    + "！");
            jQuery('#item-error').show();
            jQuery(obj).val(this.min);
            jQuery(obj).focus();
			return;
        } else if (intx > intmax) {
            jQuery('#item-error').html("<i class=\"ico\"></i>您所填写的商品数量超过库存！");
            jQuery('#item-error').show();
            jQuery(obj).val(max == 0 ? 1 : max);
            jQuery(obj).focus();
			return;
        }
        <?php if($details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") && empty($skuinfo['skuinfo']) && empty($skuinfo['skulist']) && empty($skuinfo['skuitem'])){?>//判断是否特价商品
		$("#total_price").text((special_price * $(obj).val()).toFixed(2)+" 货豆");
		<?php }elseif(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem']) && $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s")){?>
		$("#total_price").text((sku_special_offer *$(obj).val()).toFixed(2)+" 货豆");
		<?php }else{?>
		$("#total_price").text((curr_price * $(obj).val()).toFixed(2)+" 货豆");
		<?php };?>
		count_freight(parseInt(x));
    }
});




//运费计算
function count_freight(num){ 
	var is_freight = '<?php echo $details['logistics_id']?>';

	if( is_freight ){
		
    	var default_freight = "<?php echo $details['fitst_freight']?>";//默认价格 10
    	var default_item = "<?php echo $details['fitst_number']?>";//默认数量是多少 1
    	var add_item  = "<?php echo $details['overflow_number']?>";//每增加多少件 3
    	var add_freight = "<?php echo $details['overflow_freight']?>";//每增加X件+多少钱 10

    	if(num > default_item ){ 
    		var num = num - default_item;
    	    var num_a = num/add_item;
    	    if(isInteger(num_a) ){ //如果是整型 
    		    var freight = parseInt(num_a)*parseFloat(add_freight)+parseFloat(default_freight);
    		}else{ 
    			if(num_a < 1){
    				var freight = parseFloat(default_freight)+ parseFloat(add_freight);
    		    }else{ 
    		    	var freight = ( parseInt(num_a)*parseFloat(add_freight) ) + parseFloat(add_freight)+parseFloat(default_freight);
    			}
    		}
    		// js浮点数计算问题
    	    freight = freight.toFixed(2);
    	    
    	    if(isInteger(freight) ){ 
    		    $('#freight').text(freight+'.00');
    	    }else{ 
    		   $('#freight').text(freight);
    	    }
    	    
    	    
        }else{ 
        	$('#freight').text(default_freight);
        }
    }

}
//是否正整数
function isInteger(number){
return number > 0 && String(number).split('.')[1] == undefined
}

var selectsku = new Array(); //选中的SKU
var skulist = new Array();//PRODUCT原来的SKU
var curr_stock = '<?php echo number_format($details['stock']);?>';
var curr_price = '<?php echo $details['vip_price'] == 0 ? 0/*$details['m_price']*/:$details['vip_price'];?>';
var special_price = '<?php echo $details['special_price'] ;?>';


function selectSKU(obj,attr_id,sku_id,sku_name)
{
	$(obj).addClass("active").siblings().removeClass();
	for(var i=0;i<skulist.length;i++)
	{
		if(attr_id == skulist[i])
		{
			selectsku[i] = attr_id+"-"+sku_id;
		}
		
	}

	setInfo();
	if(curr_stock<=0){
	    $("#sku_"+sku_name).attr("class","active");
	}
}

var str="";
var skuprice = new Array();

    <?php
    //判断是否sku商品
    if(!empty($skuinfo['skuinfo']) && !empty($skuinfo['skulist']) && !empty($skuinfo['skuitem'])){
        $sku_info = $skuinfo["skuinfo"];
        $sku_list = $skuinfo["skulist"];
        $sku_item = $skuinfo["skuitem"];
    ?>

    //循环1开始
    <?php  foreach($sku_list as $key=>$list){ ?>
    skuprice[<?php echo $key;?>] = ['<?php echo $list["sku_key"]?>',<?php echo $list["store"];?>,<?php echo $list["price"];?>,<?php echo $list["m_price"];?>,<?php echo $list["mix_m_price"];?>,<?php echo $list["mix_rmb_price"];?>,<?php echo $list["val_id"];?>,<?php echo $list["special_offer"];?>];
    <?php };?>//循环1结束
    
    //循环2开始
    <?php
		foreach ($skuinfo["skuitem"] as $k => $v){
		    foreach ($skuinfo["skuinfo"] as $s){
		        if($s["sku_id"]==$v["sku_id"]&&$s["attr_id"]==$v["attr_id"]&&$s["sku_name"]==$s["sku_name"])
		        {
		            $skuinfo["skuitem"][$k]["stock"] = $s["stock"];
		        }
		    }
		}
    ?>//循环2结束

    //循环3开始
    <?php 
		$items = "";
		$k = 0;
		foreach($sku_item as $v){
	?>
	<?php 
		  if($items != $v["attr_id"]){//判断1开始
			$k = 0;
			if($items !=""){//判断2开始
	?>
			   str = str+'</ul></div>';
    <?php
                };//判断2结束
        		$items = $v["attr_id"];
    ?>
		 skulist.push('<?php echo $v["attr_id"]?>');//属性id追加数组
		 str = str+'<lable class="item sku_item"><?php echo $v["attr_name"]?>: </lable>'+'<div>'+ '<ul class="add_cart_size_list">';
		 
    		  <?php if($k==0){?>//判断3开始
    				selectsku.push('<?php echo $v["attr_id"]."-".$v["sku_id"]?>');
    		  <?php }?>//判断3结束

		  <?php }?>//判断1结束
				 str = str+'<li id="sku_<?php echo $v["sku_name"] ?>" <?php if($k==0){echo 'class="active"';}?> onclick="selectSKU(this,\'<?php echo $v["attr_id"]?>\',\'<?php echo $v["sku_id"];?>\',\'<?php echo $v['sku_name'] ?>\')"><?php echo $v['sku_name']?></li>';

	<?php 
	$k++;
    };
    ?>//循环3结束

        
    <?php 
	 if(count($sku_item)>0)
	 {?>
		  str = str + '</ul></div>';
	 <?php } ?>

	$('#sku').html(str);
	setInfo();

<?php }?>



//sku商品执行
function setInfo()
{
	var item = "";
	var html = "";
	var but_button ="";
	
	for(var i=0;i<selectsku.length;i++)
	{
		item = item+selectsku[i]+"_";
		
	}
	for(var i=0;i<skuprice.length;i++)
	{
// 		alert(skuprice[i][0]+"_");
// 		alert(item);
		if(skuprice[i][0]+"_" == item)
		{
			//库存判断
			if(skuprice[i][1] <= 0){
				$("#quantity").empty();
				$('#total_price').html((skuprice[i][3]).toFixed(2)+" 货豆");
				$("#gouwuche").html('<div class="gouwuche" id="gouwuche" style="background: #cc3333;"><a href="javascript:void(0)" >此商品暂时缺货</a></div>');
				$("#goumai").remove();
				}else{
					html += '<dt>购物数量：</dt><dd><span class="shuliang"><a href=javascript:jQuery.reduce("#item_num"); class="jian num_oper num_min">－</a>';
					html += '<input name="item_num" id="item_num" class="new-input" type="text" maxlength="6" value="1"  oninput="jQuery.modify(&apos;#item_num&apos;)";/>';
					html += '<a href=javascript:jQuery.add("#item_num") class="jia num_oper num_plus">+</a>';
					html += '<input id="item_amount" type="hidden" value="'+skuprice[i][1]+'"/></span>';
					html += '</span><b class="caution_tips" id="item-error" style="display:none;"></b></dd>';
					$("#quantity").html(html);
					$('#total_price').html((skuprice[i][3]*$('#item_num').val()).toFixed(2)+" 货豆");

					but_button += '<div class="gouwuche" id="gouwuche"><a onclick="javascript:add_to_cart(<?php echo $details['id'];?>,this)" >加入购物车</a></div>';
	                but_button += '<div class="goumai" id="goumai"><a onclick="javascript:buy(<?php echo $details['id'];?>)">立即购买</a></div><br>';
	                but_button += '<p >';
	                //but_button += '累计评价： <?php //echo $all?>';   
	                but_button += '<a style="text-decoration:underline; color:#fe4101; margin-left:70px"　href="javascript:void(0)" onclick = "add_to_fav(<?php echo $details['id'];?>)" id="fav"><?php echo $fav?'取消收藏':'收藏商品';?></a></p>';
					$(".ml136_btn").html(but_button);
					}
			
			var html_price = "";
			<?php if( $details['special_price_start_at'] <= date("Y-m-d H:i:s") && $details['special_price_end_at'] >= date("Y-m-d H:i:s") ):?>
                html_price += '<span class="ogrinal_price" style="text-decoration:none;">特价：   <span>'+(skuprice[i][7]).toFixed(2)+" 货豆"+'</del></span></span>';
                html_price += '<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span><del>'+(skuprice[i][3]).toFixed(2)+'货豆</del></span></span>';
                    <?php if($details['market_price']):?>
                        html_price += '<span class="ogrinal_price" style="text-decoration:none;">参考价：   <span><?php echo $details['market_price'];?></del></span></span>';
        			<?php endif;?>
    			$("#product_price").html(html_price);
                $('#total_price').html((skuprice[i][7]).toFixed(2)+" 货豆");

            <?php elseif($details['market_price']):?>
                html_price += '<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span>'+(skuprice[i][3]).toFixed(2)+'货豆</del></span></span>';
    			html_price += '<span class="ogrinal_price" style="text-decoration:none;">参考价：   <span><?php echo $details['market_price'];?></span></span>';
			    $("#product_price").html(html_price);
            <?php else:?>
                html_price += '<span class="ogrinal_price" style="text-decoration:none;">易货价：   <span>'+(skuprice[i][3]).toFixed(2)+'货豆</span></span>';
                $("#product_price").html(html_price);
            <?php endif; ?>

            
			$("#product_stock").html(skuprice[i][1]);
			$('#val_id').val(skuprice[i][6]);
			$('#item_amount').val(skuprice[i][1]);
			$("#stock").text( skuprice[i][1]);
			curr_stock = skuprice[i][1];
			curr_price = skuprice[i][3];
			
			sku_special_offer = skuprice[i][7];
			break;
			
		}
	}
}

//加入购物车
function add_to_cart(pid,obj)
{
	var x = $("#item_num").val();//加入购物车数量
	if(x==""){//如果空默认为1个
		x = 1;
		$("#item_num").val(1);
		}
	var max = $('#item_amount').val();//获取库存数量

	txtC=$('input[name="item_num"]');
	qty = parseInt(txtC.val());
	sku_id = 0;
	
	if($('#val_id').val() != 0){
		sku_id = $('#val_id').val();
	}
	//alert(sku_id);
	add_cart(pid,qty,sku_id);
}

function add_to_fav(pid)
{
	<?php if(!$this->session->userdata('user_in')):
		 $url = site_url($_SERVER['PATH_INFO']);
	     $this->session->set_userdata("redirect",$url);?>
		 
		window.location.href="<?php echo site_url("Customer/login");?>";
	<?php else:?>
	$.ajax({
	      url: "<?php echo site_url('member/fav/ajax_add');?>",
	      type: 'POST',
	      data:{'pid':pid},
	      dataType: 'html',
	      success: function(data){
				switch (data){
				case 'add_fail':
					alert('收藏失败');
					break;
				case 'add_ok':
					$('#fav').text('取消收藏');
					break;
				case 'del_ok':
					$('#fav').text('收藏商品');
					break;
				case 'del_fail':
					alert('取消失败');
					break;
				}
	      	}
	    });
    <?php endif;?>
}

function buy(pid)
{
	if(!$("#item_num").val()){
		$("#item_num").val(1);
		}
	
	txtC=$('input[name="item_num"]');
	qty = parseInt(txtC.val());
	sku_id = $('#val_id').val();
//     alert(sku_id);
	window.location.href="<?php echo site_url('cart/add');?>/" + pid + "/" + qty+"/"+sku_id;
}
</script>

<script>
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdMini": "1",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "2",
            "bdSize": "24"
        },
        "share": {}
    };
    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>
<script>
    //ajax 查询评价
    function goods_comment($status,$shop_id){
        var all = $("#all").text();
        var good = $("#good").text();
        var in_comment = $("#in").text();
        var bad = $("#bad").text();
    	var show = '';
    	switch($status){
    	case 1:
            show +='<ul >';
            show +='<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(1,'+$shop_id+')">全部<span id="all">'+all+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(2,'+$shop_id+')">好评<span id="good">'+good+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(3,'+$shop_id+')">中评<span id="in">'+in_comment+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(4,'+$shop_id+')">差评<span id="bad">'+bad+'</span></a></li>';
            show +='</ul>';
        break;
    	case 2:
            show +='<ul >';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(1,'+$shop_id+')">全部<span id="all">'+all+'</span></a></li>';
            show +='<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(2,'+$shop_id+')">好评<span id="good">'+good+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(3,'+$shop_id+')">中评<span id="in">'+in_comment+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(4,'+$shop_id+')">差评<span id="bad">'+bad+'</span></a></li>';
            show +='</ul>';
        break;
    	case 3:
            show +='<ul >';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(1,'+$shop_id+')">全部<span id="all">'+all+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(2,'+$shop_id+')">好评<span id="good">'+good+'</span></a></li>';
            show +='<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(3,'+$shop_id+')">中评<span id="in">'+in_comment+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(4,'+$shop_id+')">差评<span id="bad">'+bad+'</span></a></li>';
            show +='</ul>';
        break;
    	case 4:
            show +='<ul >';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(1,'+$shop_id+')">全部<span id="all">'+all+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(2,'+$shop_id+')">好评<span id="good">'+good+'</span></a></li>';
            show +='<li><a herf="javascript.void(0)" onclick="goods_comment(3,'+$shop_id+')">中评<span id="in">'+in_comment+'</span></a></li>';
            show +='<li class="pingjia_current"><a herf="javascript.void(0)" onclick="goods_comment(4,'+$shop_id+')">差评<span id="bad">'+bad+'</span></a></li>';
            show +='</ul>';
        break;
    	}
        $('#opt_comment').html(show);

        $.post("<?php echo site_url('goods/comments');?>",{status:$status,shop_id:$shop_id},function(data){

        	var data = JSON.parse(data);
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
                    html +='<div class="con_03_2 xiugai_03_2"><p>'+data[$i]['name'][0]+'***'+data[$i]['name'].substr(-1)+'</p><span>'+data[$i]['place_at'].substr(0,16)+'购买</span></div>';
                    html +='</div>';

                	}
            	$('#comment').empty();
            	$("#comment").html(html);
     	    }else {
     	    	$('#comment').empty();
         	    }

            });
        }

    //ajax发表留言
    $('#sure').click(function(){
        var status = $("#status_").val();
        var content = $('#content').val();
        var id = <?php echo $id;?>;
        if(status=='1'){
        	$("#status_").val(0);
            $.post("<?php echo site_url('goods/add_advisory');?>",{content:content,id:id},function(data){
            	data = jQuery.parseJSON(data);
                switch(data['status']){
                    case '1':
                    	alert('非法操作');
                    	location.reload();
                        break;
                    case '2':
                    	alert('请填写留言内容');
                    	$("#status_").val(1);
                        break;
                    case '3':
                        alert('留言成功，等待审核中');
                        $('.dingdan4_3_tanchuang').hide();
                        $("#status_").val(1);
                        break;
                    case '4':
                        alert('留言失败。');
                        location.reload();
                        break;
                }
                
                
                });
        }
    });
</script>
<script>
/**
 * 收藏店铺
 */
function corporation($corporation_id){
	<?php if(!$this->session->userdata('user_in')):
		 $url = site_url($_SERVER['PATH_INFO']);
	     $this->session->set_userdata("redirect",$url);?>
		 
		window.location.href="<?php echo site_url("Customer/login");?>";
	<?php else:?>
	$.ajax({
	      url: "<?php echo site_url('member/fav/store_corporation');?>",
	      type: 'POST',
	      data:{'pid':$corporation_id},
	      dataType: 'html',
	      success: function(data){
				alert(data);
	      	}
	    });
    <?php endif;?>
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
<?php //print_r($skuinfo["skuitem"]);exit;?>
<script type="text/javascript">addLoadEvent(Focus());</script>