<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script>
<!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script>
<!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script>
<!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script>
<!--轮播图-->
<script type="text/javascript" src="js/superslide.2.1.js"></script>
<!--banner图片切换-->
<script>
//顶部菜单
//站点菜单
    (function($){
        $(document).ready(function(){
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script> 


<?php $this->load->view('navigation_bar');?>

<!-------banner图片开始---------->
<div class="painting_banner1">
	<div class="bd">
		<ul>
			<li _src="url(images/banner2.jpg)"></li>
		</ul>
	</div>
</div>
<div class="beverage_top">

	<div class="housing_header2 clearfix">
		<div class="mr_frbox2">
			<div class="screening">
				<div class="screening_top" id="list">
					<h4>
						<a href="javascript:;">书画筛选</a>
					</h4>
					<ul class="screening_ul">
                       <li><sub>价格:</sub><em class="em3"> 
    					   <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 1 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/1?'.$canshu.'price=1#list')?>">5000以下</a></span>
    					   <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 2 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/1?'.$canshu.'price=2#list')?>">5000-20000</a></span>
    					   <span class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 3 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/1?'.$canshu.'price=3#list')?>">20000-40000</a></span>
    					   <span  class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 4 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/1?'.$canshu.'price=4#list')?>">40000-60000</a></span>
    					   <span  class="number_1 <?php echo isset($_GET['price']) && $_GET['price'] == 5 ? 'fangzi' :''?>"><a href="<?php echo site_url('goods/zhuanti/1?'.$canshu.'price=5#list')?>">60000以上</a></span>
					   </em>
					   </li>
					   <?php foreach ($classify as $v):?>
    					   <?php if($v['attr_type'] == 'radio' || $v['attr_type'] == 'checkbox'):?>
    					   <li><sub><?php echo $v['attr_name']?>:</sub><em class="em3 limit_" id="em3"/>
    						    
        						<?php foreach ($v['option_values'] as $val):?>
        						    <span  class="number_2 <?php echo isset($_GET[$v['id']]) && $_GET[$v['id']] == "$val" ? 'fangzi' :'';?> "><a href="<?php echo site_url('goods/zhuanti/1/?'.$canshu.$v['id'].'='.$val.'&#list')?>"><?php echo $val;?></a></span> 
        						<?php endforeach;?>
        						
    						</em>
    					   </li>
    					   <?php endif;?>
					   <?php endforeach;?>
					</ul>
					<div class="screening_xia">
						<span>更多查找条件:</span>


						<div id="search" class="search_1">
							<input name="searchword" id="btn" type="text" class="btn"
								placeholder="请输入关键词"> <strong><a href="javascript:search()"></a></strong>
						</div>
					</div>
				</div>
			</div>
			<div class="condition">
			<samp>已选条件:</samp> 
           <?php if(isset($attr_get) && $attr_get && count($attr_get) > 0):?>
               <?php foreach ($attr_get as $k=>$v):?>
                   <div class="tips-box-r">
				<div class="tips-content"><?php echo $v?><small id="chai"><a
						href="<?php echo site_url('goods/zhuanti/1/'.$k.'/?'.$canshu.'#list')?>">x</a></small>
				</div>
				<span></span>
			</div>
               <?php endforeach;?>
           
           <?php else:?>
             
             <div class="tips_wu" style="display: block">
				<div class="tips-content">暂无选择任何条件!</div>
				<span></span>
			</div> 
           <?php endif;?>
         </div>
		</div>
	</div>


	<!-------左右切换轮播开始---------->
	<div class="mr_frbox">
		<img class="mr_frBtnL prev" src="images/mfrL.jpg" width="28"
			height="46"> <img class="mr_frBtnR next" src="images/mfrR.jpg"
			width="28" height="46">
		<div class="mr_frUl">
			<div class="tempWrap">
				<ul>
					<li><span><img src="images/_11.jpg" /></span>
						<div class="inner_n">
							<h6>作者：赵振川</h6>
							<p><a href="javascript:;" title="1944年生于西安，祖籍河北省束鹿县。国家一级美术师，中国美协理事，中国美协国画艺委会委员，多年来担任国内大型画展评委。黄胄美术基金会常务理事。陕西省第四届文联副主席，陕西省美协名誉主席，陕西长安画派艺术研究院院长，陕西省政协委员。任北京大学艺术学院高研班导师,中国人民大学客座教授，西安美术学院客座教授，西北大学客座教授,国务院授予突出贡献专家。">1944年生于西安，祖籍河北省束鹿县。国家一级美术师，中国美协理事，中国美协国画艺委会委员，多年来担任国内大型画展评委。黄胄美术基金会常务理事。陕西省第四届文联副主席，陕西省美协名誉主席，陕...</a></p>
                            <p><a href="javascript:;" title=" 陕西省“德艺双馨文艺工作者”。陕西省委、省政府授予“第二届陕西文艺大奖艺术成就奖”。作品先后入选第四、七、九、十、十一届全国美展，经常参加当代中国山水画提名展、综合性画展、国际水墨画交流展等国内外大型邀请展，作品被中外美术馆,博物馆及个人大量收藏。出版个人画集多种。">陕西省委、省政府授予“第二届陕西文艺大奖艺术成就奖”。作品先后入选第四、七、九、十、十一届全国美展，经常参加当代中国山水画提名展、综合性画展、国际水墨画交流展等国内外大型邀请展，作品被中外...</a></p>
						</div></li>
					<li><span><img src="images/_01.jpg" /></span>
						<div class="inner_n">
							<h6>作者：刘文西</h6>
							<p><a href="javascript:;" title=" 1933年生于浙江省嵊州市长乐镇水竹村，1950年在上海进入陶行知先生创办的“育才学校”学习美术，1953年入浙江美术学院，受潘天寿等先生教导，1958年毕业后到西安美院工作至今。">1933年生于浙江省嵊州市长乐镇水竹村，1950年在上海进入陶行知先生创办的“育才学校”学习美术，1953年入浙江美术学院，受潘天寿等先生教导，1958年毕业后到西安美院工作至今。</a></p>
                            <p><a href="javascript:;" title=" 第七届、第八届全国人大代表，全国有突出贡献专家。第六届全国文联委员，全国第四、第五、第六、第七次文代会代表，全国美协第一届中国画艺委会委员、历届全国美展评委会委员。中国美术家协会顾问，原中国美术家协会副主席，黄土画派艺术研究院院长，中国当代画派联谊会主席，
       陕西省美术家协会名誉主席，西安美术学院名誉院长，教授、博士研究生导师，获国家第一批名师称号，第五套人民币毛泽东画像创作者，《中国才子》画报艺术顾问；陕西国画院名誉院长，延安市副市长，北京唐风美术馆高级艺术顾问等职。享受政府特殊津贴。                      
       数十年来发表作品千余幅，出版个人作品集十余本，获国家级奖七次。中国美术馆收藏有《祖孙四代》、《知心话》、《毛主席身边啦家常》等二十五件作品。不断的艰辛创作，李瑞环同志鼓励他说：“你在三十余年美术生涯中，希望继续朝着自己选择的艺术道路走下去，为人民创造出更多的好作品。”他以大量动人的作品、独创的面貌和风采以西安美院为主体的有实力的画家，在中国画坛上创立了“黄土画派”。数年来，他在国内外发表作品数千幅，出版画册十余件，中国美术馆收藏作品25件，获国家级奖9件。教学工作、社会活动、深入生活、创作实践，构成了刘文西全部生活的紧张节奏。">第七届、第八届全国人大代表，全国有突出贡献专家。第六届全国文联委员，全国第四、第五、第六、第七次文代会代表，全国美协第一届中国画艺委会委员、历届全国美展评委会委员。中国美术家协会顾问，原...
                             
							</a>
                            </p>
						</div></li>
					<li><span><img src="images/_03.jpg" /></span>
						<div class="inner_n">
							<h6>作者：王家春</h6>
							<p><a href="javascript:;" title="哲学研究生,文化艺术学者，画家，香港福慧慈善基金会大陆顾问，现任西安美术学院党委书记。业余时间潜心理论研究和书画创作,曾出版多部著作。他的“哲理中国画”系列因其清新隽永、意味悠长，深受大家喜爱，被多家媒体连载。">哲学研究生,文化艺术学者，画家，香港福慧慈善基金会大陆顾问，现任西安美术学院党委书记。业余时间潜心理论研究和书画创作,曾出版多部著作。他的“哲理中国画”系列因其清新隽永、意味悠长，深受大家...</a></p>
                            <p><a href="javascript:;" title="现为陕西省美术家协会会员,陕西省政协委员,西北大学兼职教授，是著名“哲理中国画”画家。">现为陕西省美术家协会会员,陕西省政协委员,西北大学兼职教授，是著名“哲理中国画”画家。</a> </p>
						</div></li>
					<li><span><img src="images/_05.jpg" /></span>
						<div class="inner_n">
							<h6>作者：王西京</h6>
							<p><a href="javascript:;" title="1946年8月生于陕西西安，现任陕西美术家协会主席、西安中国画院院长、中国美术家协会理事、西安美术家协会主席、中国美协中国画艺委会委员、中国画学会副会长、陕西省文联副主席、西安建筑科技大学艺术学院名誉院长、教授，兼任中国艺术研究院教授、西北大学、云南大学、西安美术学院教授，第十二届全国政协委员，第九届、第十届全国人大代表，一级美术师，被国务院授予“国家级有突出贡献专家”，荣获“中国时代先锋人物”、“第四届中国改革十大最具影响力新锐人物”、“陕西省红旗人物”、“陕西省行业领军人物”、“陕西省优秀共产党专家”、“劳动模范”等光荣称号">1946年8月生于陕西西安，现任陕西美术家协会主席、西安中国画院院长、中国美术家协会理事、西安美术家协会主席、中国美协中国画艺委会委员、中国画学会副会长、陕西省文联副主席、西安建筑科技大学...</a></p>
                            <p><a href="javascript:;" title="王西京在2000年荣获日本政府“国际阿卡得密奖”和“教育文化勋章”；2002年荣获汉城国际书画大展“国际贡献奖”和“中华人民共和国奥林匹克运动”特奥金质奖；2003年获日、中、韩“国际美术节大展”金奖和“中国北京国际美术节”特等奖；2005年获“法国国际美术沙龙展”特别奖，是我国在海内外享有盛誉的艺术家。">王西京在2000年荣获日本政府“国际阿卡得密奖”和“教育文化勋章”；2002年荣获汉城国际书画大展“国际贡献奖”和“中华人民共和国奥林匹克运动”特奥金质奖；2003年获日、中、韩“国际美术节大展”金奖和...</a>
							</p>
							
						</div></li>
					<li><span><img src="images/_07.jpg" /></span>
						<div class="inner_n">
							<h6>作者：王有政</h6>
							<p><a href="javascript:;" title="王有政，1941年生于山西万荣，1964年毕业于西安美术学院附中，1969年毕业于西安美术学院国画系人物画专业。现为中国美术家协会会员、陕西省美协常务理事，国家一级美术师、享受国务院特殊津贴专家陕西国画院创作研究室主任。">王有政，1941年生于山西万荣，1964年毕业于西安美术学院附中，1969年毕业于西安美术学院国画系人物画专业。现为中国美术家协会会员、陕西省美协常务理事，国家一级美术师、享受国务院特殊津贴专...</a></p>
                           <p><a href="javascript:;" title="1979年作品《悄悄话》获第五届全国美展二等奖，1984年作品《捏扁食》获第六届全国美展铜奖、作品《翠翠莉莉和姣姣》获第六届全国美展优秀作品奖，1989年作品《倦旅图》获第七届全国美展铜奖，1994年作品《母亲我心中的佛》获第八届全国美展优秀作品奖，1999年作品《读》获第九届全国美展铜奖。">1979年作品《悄悄话》获第五届全国美展二等奖，1984年作品《捏扁食》获第六届全国美展铜奖、作品《翠翠莉莉和姣姣》获第六届全国美展优秀作品奖，1989年作品《倦旅图》获第七届全国美展铜奖，1994...</a>
						</div></li>
					<li><span><img src="images/_09.jpg" /></span>
						<div class="inner_n">
							<h6>作者：杨佳焕</h6>
							<p><a href="javascript:;" title="陕西咸阳人。陕西师范大学美术学院国画系副教授，硕士研究生导师。中国美术家协会陕西分会会员。中国民主同盟会盟员。1981年考入西安美院附中。1985年毕业，同年考入西安美术学院国画系人物班。并获艺术学学士学位。2004年《邓小平肖像》纪念邓小平诞辰一百周年获银奖。《东方红》（毛泽东肖像）在建国五十五周年展获一等奖。《杨佳焕画集》出版发行。2006年《东方红》﹙毛泽东肖像﹚应邀参加纪念毛泽东《讲话》发表64周年全国名人名家书画邀请展。2008年12月出版发行《杨佳焕花鸟、人物精品集》台历(陕西旅游出版社)。2010年5月《大吉和谐》赴台湾大叶大学书画交流并展出。2010年6月《邓小平》（肖像）赴香港书画交流并展出。2010年9月陕西人民美术出版社出版发行《杨佳焕画集》（人物），《新长安画谱》（人物卷）、《新长安画谱》（花鸟卷）。在《文艺研究》《西北大学学报》《西安晚报》等国家级权威，核心期刊及报刊上发表作品和学术论文一百五十余幅（篇）。2012年7月《西安晚报》——（水墨中国）栏目连续三期（杨佳焕人物画）专版介绍。2012年中国文联出版社发行《杨佳焕》（古典人物画精选）台历。2012年8月赴澳大利亚进行书画学术交流。2013年8月27日《中国集邮报》（韦国清）邮票创作谈及图片。2013年9月2日">陕西咸阳人。陕西师范大学美术学院国画系副教授，硕士研究生导师。中国美术家协会陕西分会会员。中国民主同盟会盟员。1981年考入西安美院附中。1985年毕业，同年考入西安美术学院国画系人物班。并获...</a></p>
							<p><a href="javascript:;" title="纪念韦国清诞生一百周年《韦国清》邮票，首日封，由中国邮政集团总公司发行。2013年《集邮》杂志第九期刊登（韦国清）邮票创作谈及图片。2013年9月15日《西安晚报》（水墨中国）专版刊登（韦国清）邮票创作谈及图片。2013年10月15日纪念习仲勋诞生一百周年《习仲勋》邮票首日封、邮戳由中国邮政集团总公司发行。2013年11月3日《华西都市报》专版介绍。2013年11月10日《西安晚报》（水墨中国）专版刊登（习仲勋）邮票创作谈及图片。">纪念韦国清诞生一百周年《韦国清》邮票，首日封，由中国邮政集团总公司发行。2013年《集邮》杂志第九期刊登（韦国清）邮票创作谈及图片。2013年9月15日《西安晚报》（水墨中国）专版刊登（韦国清）邮...</a>
						   </p>
						</div></li>
				</ul>
			</div>
		</div>
	</div>
	<!-------左右切换轮播结束---------->

	<!-------楼层切换开始---------->
	<div class="lc_floor">

		<div id="f1">
			<div class="lc_floor_con ">
				<!--               <div class="lc_more"> -->
				<!--                 <keyword><span><img src="images/shuhau.png"/></span><source>标题</source></keyword><span class="lc_more_r"><a href="#">更多</a></span> -->
				<!--              </div>  -->
				<div class="eh_floor_con_nei">
					<ul>
              <?php foreach ($goods_list as $val):?>
                <li>
							<h5>
								<a href="<?php echo site_url('goods/detail/'.$val['id'])?>"><img
									src="<?php echo IMAGE_URL.$val['goods_thumb']?>" /></a>
							</h5>
							<div class="nei_x">
								<h6>
									<a href="<?php echo site_url('goods/detail/'.$val['id'])?>"><?php echo $val['name']?></a>
								</h6>
								<p class="nei_x1"><?php echo $val['corporation_name']?></p>
								<p class="nei_x2">
									<strong>易货价：</strong><span>M  <?php echo $val['vip_price']?></span>
								</p>
							</div>
						</li>
              <?php endforeach;?>
                 
              </ul>



					<div style="width: 1200px; overflow: hidden;">
						<div class="pingjia_jilu" style="margin-left: 30px">
							<p>显示 <?php if(count($goods_list) > 0) echo ($cu_page -1)*$per_page + 1; else echo '0';?> 到 <?php if($cu_page*$per_page > $total) echo $total; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total?> 条数据</p>
						</div>
						<div class="pingjia_showpage" style="margin-right: 30px">
                    	<?php echo $page;?>
                    	 
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-------楼层切换结束---------->
</div>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript">
<!-------左右切换轮播---------->
$(".mr_frbox").slide({
	titCell:"",
	mainCell:".mr_frUl ul",
	autoPage:true,
	effect:"leftLoop",
	autoPlay:true,
	vis:4
});
</script>

<!--tab_s艺术家切换-->
<script type="text/javascript">jQuery(".tab_s").slide({delayTime:0 });</script>

<!----banner图片轮播------>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".painting_banner1 .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});

</script>
<script>
  $("#chai").click(function(){
		$('.tips-box-r').show();
		$('.tips_wu').hide();
		});
    function search(){ 
    	window.location = "<?php echo site_url('goods/zhuanti/1/?'.$canshu.'s=/')?>"+$('#btn').val();
        $('#btn').val();
    }
	
	
</script>

<!--展示人物简介每行截取多少字-->
<!--<script>
$(document).ready(function(){
//限制字符个数
$(".inner_n p").each(function(){
var maxwidth=93;
if($(this).text().length>maxwidth){
$(this).text($(this).text().substring(0,maxwidth));
$(this).html($(this).html()+"...");
}
});
});
</script>-->




<script type="text/javascript">
$(function(){ 

	$('.limit_').each(function(){
        $leng = $(this).children('span').length;
        
    if($leng>11){
        if($(this).children('span').hasClass('fangzi')){
            $(this).children('span').show();
            $(this).parent().append('<em class="em5"><input type="button" value="收起" class="" id="em4"><i class="icon-xiangshangjiantou"></i></em> ');
        }else{
            $(this).parent().append('<em class="em5"><input type="button" value="更多" class="" id="em4"><i class="icon-select"></i></em> ');
            for(var i = 0;i<$leng;i++){
                $(this).children('span').eq(i+11).hide();
            }
        }
    }
   })

    $('.em5').click(function(){
    	
    	if($(this).children('input').val() =='更多'){
    	    $(this).children('input').val('收起');
    	    $(this).children('i').removeClass().addClass("icon-xiangshangjiantou");
    	    $(this).prev().children('span').show();
    	}else{
    	    $leng = $(this).prev().children('span').length;
    	    if($leng>11){
    	        for(var i = 0;i<$leng;i++){
    	            $(this).prev().children('span').eq(i+11).hide();
    	        }
    	    }
    	    $(this).children('i').removeClass().addClass("icon-select");
    	    $(this).children('input').val('更多');
        }
    })
})

		
		

		
</script>



