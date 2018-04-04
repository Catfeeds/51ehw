// ====================================
// hp_v3 首页内容处理
// 修改时间:2013-11-26
// ====================================
(function($) {
	// --------------------------------
	YM.namespace('YM.page.hp');
	// --------------------------------
	YM.page.hp.is950 = $('body').hasClass('s950');
	YM.page.hp.init = function() {
		this.loadImageFirst();
		this.updateLinkSourceId();
		this.initContentExecute();
	};
	YM.page.hp.loadImageFirst = function() {
		// 首屏2张大焦提前加载
		$('#bigFocusSlider li:first img[original], #bigFocusSlider li:eq(1) img[original]').each(function() {
			var imgElm = $(this);
			YM.debug('首屏图片加载', imgElm.attr('original'));
			imgElm.attr('src', imgElm.attr('original')).removeAttr('original');
		});
		// 首屏剩余大焦延迟加载
		setTimeout(function() {
			$('#bigFocusSlider img[original]').each(function() {
				$(this).bindYMUI('LoadRealImage', {srcAttr:'original'});
			});
		}, 5000);
	};
	YM.page.hp.imgDelayLoad = function() {
		$('.e-imageload').bindYMUI('DelayLoadImage', { preloadHeight:100, eventClass:'e-imageload' });
	};
	YM.page.hp.initContentExecute = function() {
		$('.mod-shangou, .mod-women').addClass('e-imageload');
		// 顶部大焦广告切换
		$('#bigFocusSlider').addClass('e-imageload').bindYMUI('SlideBox', { direction:'top', delay:8, duration:0.8, animate:'fade', callback:function() { YM.page.hp.imgDelayLoad(); } });
		// 推荐商品Tab切换
		$('.mod-hotgoods').addClass('e-imageload').bindYMUI('SlideBox', { direction:'top', unitheight:320, items:'.goodslist', index:'hottabs', autoslide:false, callback:function() { YM.page.hp.imgDelayLoad(); } });
		// 高端精选广告切换处理
		if (!this.is950) {
			$('#specialSlider').addClass('e-imageload').bindYMUI('SlideBox');
		}
		// 公告区内容处理
		$('#noticeSlider').addClass('e-imageload').bindYMUI('SlideByPage',{ pagesize:1, items:'ul', unitwidth:200, autoslide:true, delay:6, callback:function(elms) { elms.bindYMUI('LoadChildImage'); } });
		$('#notices h3 span').bindYMUI('SwitchTabs', { action:'mouseover', child:'#notices ul' });
		$('.notice-change').click(function(){
			$(this).parent().parent().toggleClass('mod-notice-on');
		});
		// 品鉴和他们说的分页内容切换处理
		$('.mod-winetasting ul li, .mod-theysay .saylists dl').addClass('e-childload');
		$('.mod-winetasting').bindYMUI('SlideByPage', { pagesize:3, items:'ul', unitwidth:317, duration:0.6, callback:function(elms) { elms.bindYMUI('LoadChildImage'); } });
		$('.mod-theysay').bindYMUI('SlideByPage', { direction:'top', pagesize:2, items:'.saylists', unitheight:150, callback:function(elms) { elms.bindYMUI('LoadChildImage'); } });		
		$('.minipage .btn-prev').hover(function() {
			if (!$(this).hasClass('disabled')) $(this).addClass('btn-prev-hover');
		}, function() {
			$(this).removeClass('btn-prev-hover');
		});	
		$('.minipage .btn-next').hover(function() {
			if (!$(this).hasClass('disabled')) $(this).addClass('btn-next-hover');
		}, function() {
			$(this).removeClass('btn-next-hover');
		});
		// 频道内容处理
		$('.channel').each(function() {
			$(this).find('.channel-brands, .channel-slider, .channel-rightad, .goodslist').addClass('e-imageload');
			if ($(this).find('.channel-slider .slide-items li').size()>1) {
				$(this).find('.channel-slider').bindYMUI('SlideBox', { duration:0.8, autoslide:false });
			}
			// 右侧排行榜处理
			if (!this.is950) {
				//销量排行Tab切换
				$('.tit-tab span').bindYMUI('SwitchTabs', { action:'mouseover', child:'#tab-toplist ul', tabClass:'hover', childClass:'hover' });
				$(this).find('.channel-topboard li.on').addClass('e-imageload');
				if ($(this).hasClass('channel-wine')) {
					$(this).find('.tab-toplist li:gt(1)').addClass('item');
				} else {
					$(this).find('.channel-topboard li:gt(0)').removeClass('on');
					$(this).find('.channel-topboard li').addClass('item');
				}
				var items = $(this).find('.channel-topboard li.item');
				items.addClass('e-childload');
				items.mouseenter(function() {
					items.removeClass('on');
					$(this).addClass('on').bindYMUI('LoadChildImage');
				});
			}
		//	if ($.browser.isIE6) $(this).find('.goodslist li').bindYMUI('ElementHover', {hoverClass:'hover'});
		});
		$('.goodslist li').each(function() {
			if ($(this).find('dd.slogan').text().trim()=='') $(this).find('dd.slogan').remove();
			if ($(this).find('ins.zhe').size()>0) {
				var minprice = $(this).find('.minprice strong').text(), maxprice = $(this).find('.maxprice del').text().replace('¥', '');
				if (minprice>0 && maxprice>0) {
					var discount = (minprice * 10 / maxprice).toFixed(1);
					if (discount != '10.0')	{
						$(this).find('ins.zhe').html('<strong>'+ discount +'<\/strong>折').removeAttr('class');
					} else {
						$(this).find('ins.zhe').remove();
					}
				} else {
					$(this).find('ins.zhe').remove();
				}
			}
		});
		// 倒计时处理
		$('.e-countdown, .prod-countdown').bindYMUI('CountDown');
		// 图片延迟加载
		$(document).bindYMUI('ImageDelayLoad');
		//回顶部处理
		$('#floatTop').bindYMUI('FloatBottomTool', { minWidth:1220, mainWidth:1350, floatBottom:365 });
		//品牌墙
		if($('#brandWall').size()>0){
			$('#brandWall').addClass('e-imageload');
    		$('#brandWall dd a').each(function(){
    			$(this).hover(function(){
    				var $text = $(this).find('img').attr('alt');
    				var $span ='<span>' + $text + '</span>';
    				$(this).append($span).css('position','relative');
    			},function(){
    				$(this).css('position','');
    				$(this).find('span').remove();
    			})
    		});
	    };
	};
	// --------------------------------
	$.fn.updateLinkSourceId = function(srcId) {
		var updateLink = function(elm, index) {
			elm.each(function() {
				var link = $(this).attr('href') || '';
				if (link=='' || link=='#' || link.indexOf('#')>0) return;
				$(this).attr('href', link +'#'+ srcId + index);
			});
		};
		this.children().each(function(i) {
			var index = i + 1;
			if ($(this).tagName()=='a') {
				updateLink($(this), index);
			} else {
				updateLink($(this).find('a'), index);
			}
		});
	};
	// 给内容链接添加相应的跟踪代码
	YM.page.hp.updateLinkSourceId = function() {
		var d = new Date().getTime();
		$('#bigFocusSlider ul.slide-items').updateLinkSourceId('banner');
		$('#noticeSlider ul.slide-items').updateLinkSourceId('ad');
		$('#specialSlider ul.slide-items').updateLinkSourceId('wine');
		$('.channel').each(function(i) {
			var index = i + 1;
			$(this).find('.channel-header ul').updateLinkSourceId('z'+index+'cate');
			$(this).find('.channel-brands ul').updateLinkSourceId('z'+index+'brand');
			$(this).find('.channel-slider ul.slide-items').updateLinkSourceId('z'+index+'ad');
			$(this).find('.channel-rightad').updateLinkSourceId('z'+index+'wine');
			$(this).find('.goodslist ul').updateLinkSourceId('z'+index+'good');
			$(this).find('.channel-topboard ul').updateLinkSourceId('z'+index+'top');
		});
		$('.mod-women .bd ul').updateLinkSourceId('ladyad');
		$('.mod-hotgoods .goodslist ul').updateLinkSourceId('hotgood');
		$('.mod-winetasting .bd ul').updateLinkSourceId('tasting');
		$('.mod-theysay .saylists ul').updateLinkSourceId('saygood');
	};
	// --------------------------------
	YM.page.hp.init();
	// --------------------------------
})(jQuery);