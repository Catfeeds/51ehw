$(document).ready(function(){
	m_prod_catalog();
	liho();
wjlihover();
limore();

});

function m_prod_catalog(){
	var self = "";
	var self_top = "";
	var pos_nav_offsetTop = "";
	$(".navlist li").hover(
		function(){
			self = $(this);
			self.addClass("hover").children("div").slideDown();
			//slideDown
		},
		function(){
			self = $(this);
			self.children("div").hide();
			//slideUp
			self.removeClass("hover");
		}
	);
};


function liho(){
	var self = "";
	$(".joblist2 i").click(
		function(){
			$(".joblist2 li").removeClass("hover");
			self = $(this);
			self.parents(".joblist2 li").addClass("hover");
			//slideDown
		}
	);
};function wjlihover(){
	var self = "";
	$(".lihover li").hover(
		function(){
			self = $(this);
			self.addClass("hover");
		},
		function(){
			self = $(this);
			self.removeClass("hover");
		}
	);
};

function limore(){
	var self = "";
	$(".a_morebank").click(
		function(){
			self = $(this);
			$("#caslist").addClass("caslisthover");
			self.addClass("a_morebankno");
			//slideDown
		}
	);
};

$(function(){ 
var _tab = $('.cas_de a');//获取选项卡导航
var _box = $('.casbox_de');//获取内容切换区
var _index;//索引值
_tab.click(function(){
if(!$(this).hasClass("hover")){ 
$(this).addClass("hover");
_box.show();
}
else{
$(this).removeClass("hover");
_box.hide();
} 
});//为第一个导航添加当前状态样式
});