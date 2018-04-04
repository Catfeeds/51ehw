<style>
.arrival_guide_top_ul li p{color: #666666 !important;}
</style>
<!--入驻首页 -->
<div class="home_page">
	<div class="home_page_sh">
		<!--导航开始-->
		<div class="home_page_top">
			<ul class="home_page_top_ul">
				<li><a href="<?php echo site_url('Corporation/home_page');?>">首页</a></li>
				<li class="home"><a
					href="<?php echo site_url('Corporation/arrival_guide');?>">入驻指南</a></li>
			</ul>
		</div>
		<!--导航结束-->

	</div>
	<!--入驻指南开始-->
	<div class="arrival_guide">
		<div class="arrival_guide_top">
			<h5 class="arrival_guide_top_h5">入驻须知</h5>
			<ul class="arrival_guide_top_ul">
				<li>
                    <h6>一、要求与须知：</h6>
                    <p>第一条：须为合法登记的企业用户，并且能够提供51易货网入驻要求的所有相关文件，不接受个体工商户；</p>
                    <p>第二条：企业提供的在售商品易货额不少于10万 ；</p>
                    <p>第三条：51易货网可在申请入驻及后续经营阶段根据商户销售的商品要求商户提供其他资质；</p>
                </li>
                <li>
                    <p>第四条：商家必须如实提供资料和信息；</p>
                    <p>请务必确保您申请入驻及后续经营阶段提供的相关资质和信息的真实性（若您提供的相关资质（包括但不限于营业执照、销售许可证、授权书）为第三方提供的，请务必先行核实文件的真实有效性），一旦发现资质或信息虚假的，您的公司将被列入非诚信客户名单，51易货网将不再与您进行合作；</p>
                    <p>（二） 商家应如实提供其店铺运营的主体及相关信息，包括但不限于代理运营商、实际店铺经营主体、被授权人等信息；</p>
                </li>
                <li>
                   <p>第五条：若提供的申请材料缺少，会退回给您重新填写提交，建议您事先准备齐全资料，一次性通过审核；</p>
                   <p>第六条：以下提供的资料如是复印件请加盖开店公司公章（鲜章）；</p>
                </li>
                <li>
                    <h6>二、企业资质材料：</h6>
                    <p>（一）营业执照：需确保未在企业经营异常名录中且所售商品在营业执照经营范围内；</p>
                    <p>（二）税务登记证：非三证合一情况下需提供，须同时有国地税章；</p>
                    <p>（三）组织机构代码证：非三证合一情况下需提供；</p>
                    <p>（四）法人身份证正反面：需提供公司法人身份证正反面；</p>
                </li>
                <li>
                   <p>（五）委托授权书（模板）</p>
                   <p>1.开店公司名称需要完整；</p>
                   <p>2.授权企业名称与营业执照名称一致；</p>
                   <p>3.授权有效期不得少于一年；</p>
                   <p>4.授权人与被授权人需同时签字并加盖开店公司公章（鲜章）；</p>
                </li>
                <li>
                   <h6>三、其他经营资质：</h6>
                   <p>（一）销售授权书：如非自由品牌的商品售卖，请提供正规的品牌方提供的品牌授权证书；</p>
                   <p>（二）质检、检疫、检验报告：凡是食品、药品、保健品、化妆品等类型的商品，均需提供正规部门部门的检验报告、生产许可证、销售授权书(代理/经销授权证明)等相关资质；</p>
                </li>
			</ul>
              
              <?php if( $content_list ) { ?>
             <ul class="arrival_guide_di">
             	<?php foreach ( $content_list as $v ){ ?>
               <li><a href="<?php echo site_url('Corporation/description/'.$v['id'])?>"><?php echo $v['title']?></a></li>
                <?php }?>
             </ul>
             <?php }?>
             <div class="arrival_guide_a">
				<a href="<?php echo site_url("Corporation/shop_choose");?>">已阅读入驻须知</a>
			</div>
		</div>
	</div>
	<!--入驻指南结束-->
</div>