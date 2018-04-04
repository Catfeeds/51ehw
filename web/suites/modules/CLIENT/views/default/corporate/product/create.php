
<div class="top2 manage_fenlei_top2">
	<ul>
		<li><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
		<li class="tCurrent"><a
			href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
		<li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
	</ul>
</div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">商品管理</div>
		<div class="cmLeft_down">
			<ul>
				<li class="houtai_zijin_current"><a href="<?php echo site_url("corporate/product/create");?>">发布商品</a></li>
				<li><a href="<?php echo site_url('corporate/product/get_list');?>">全部商品(<?php echo isset($all_count)?$all_count:'' ?>)</a></li>
				<li><a href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">销售中(<?php echo isset($sale)?$sale:'' ?>)</a></li>
				<li><a href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a></li>
				<li><a href="<?php $type = 'not'; echo site_url('corporate/product/get_list/0/'.$type) ?>">已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
				<li><a href="<?php echo site_url('corporate/section/get_list');?>">分类管理</a></li>
			</ul>
		</div>
	</div>
	<script language="javascript" type="text/javascript"
		src="<?php echo base_url()?>js/calendar.php"></script>
	<script language="javascript" type="text/javascript"
		src="<?php echo base_url()?>js/jquery.js"></script>
	<script language="JavaScript"> var base_url = '<?php echo base_url()?>'; </script>
	<script language="javascript" type="text/javascript"
		src="<?php echo base_url()?>js/admin.js"></script>

	<script>
        function RemoveDiv($eventSrc) {
            //给事件源所在的div加上高亮效果，并移除其它兄弟项的高亮效果
            $eventSrc.siblings().removeClass("categoryItemClick");
            $eventSrc.addClass("categoryItemClick");
            //找到要删除的对象
            var $currentSelectCategoryDiv = $eventSrc.parent().parent();
            var $currentSelectCategoryDivId = $currentSelectCategoryDiv.attr("id");
            var $currentSelectCategoryDivIdNum = $currentSelectCategoryDivId.substring($currentSelectCategoryDivId.lastIndexOf('v') + 1); //截取出数字num
            var $allSelectCategoryDiv = $("div[id^=selectCategoryDiv]");
            for (var i = 0; i < $allSelectCategoryDiv.length; i++) {
                var $thisSelectCategoryDivId = $allSelectCategoryDiv[i].id;
                var $thisSelectCategoryDivIdNum = $thisSelectCategoryDivId.substring($thisSelectCategoryDivId.lastIndexOf('v') + 1);
                if ($thisSelectCategoryDivIdNum > $currentSelectCategoryDivIdNum) {
                    $("#selectCategoryDiv" + $thisSelectCategoryDivIdNum + "").remove();
                }
            }
            //找到已经记录的类目，将其后面的，包括自己删除
            var $allSelectedCategory = $(".hasSelectedCategoryDiv span span");
            if ($allSelectedCategory.length > 0) {
                for (var i = 0; i < $allSelectedCategory.length; i++) {

                    if ($allSelectedCategory[i].id >= $currentSelectCategoryDivIdNum) {
                        $(".hasSelectedCategoryDiv span[id=" + $allSelectedCategory[i].id + "]").remove();
                    }
                }
            }
            return $currentSelectCategoryDivIdNum; //返回当前div的ID的num，用于定位当前div，方便删除后面的div
        }
        function ClickNoSubCategory(event) {
            if (event instanceof jQuery == false) {
                event = event ? event : window.event;
                var eventSrc = event.srcElement ? event.srcElement : event.target;
                var $eventSrc = $(eventSrc);
                if ($eventSrc.attr("class") == "hasSubCategory" || $eventSrc[0].tagName == 'SPAN') {
                    $eventSrc = $eventSrc.parent();
                }
            } else {
                $eventSrc = event;
            }
            $currentSelectCategoryDivIdNum = RemoveDiv($eventSrc);

            //点击某一个非父类目（终节点）类目项之后，将其categoryId和categoryName记录在类样式名为hasSelectedCategoryDiv的div中
            var $selectedCategory = $("<span id=" + $currentSelectCategoryDivIdNum + " cID=" + $eventSrc.attr("id") + ">" + $eventSrc.text() + "</span>");
            $(".hasSelectedCategoryDiv #selectedCategoryName").append($selectedCategory);
            //点击非父类目（终节点）的项之后将“已选好类目，进入下一步”按钮显示

            $("#nextPage").removeClass("disabled");
            $("#nextPage").attr("disabled", false);
        }
        function CreateSelectCatgoryDiv(w, h, num) {
            var $selectCategoryDiv = $("<div id='selectCategoryDiv" + num + "' class='selectCategoryDiv'></div>");
            $selectCategoryDiv.css("width", w + "px");
            $selectCategoryDiv.css("height", h + "px");
            $selectCategoryDiv.append('<div class="category-search"><i class="icon-search-tabao"></i><input type="text" placeholder="输入名称"></div>')
            return $selectCategoryDiv;
        }
        function GetProductCategoryData(categoryData) {
            //定义一个容器，来装生成的根类目数据
            var $categorySet = $("<div id='categorySet' class='categorySet'></div>");
            //暂且认为parentID为0的数据项是根数据项
            for (var i = 0; i < categoryData.length; i++) {
                if (categoryData[i].IsParent == true) {//  给有子目录的项加一个小三角标记
                    var $rootCategory = $("<div id='" + categoryData[i].ID + "' class='categoryItem' onclick='ClickHasSubCategory(event)'><span>" + categoryData[i].Name + "</span><div class='hasSubCategory'></div></div>");
                } else {
                    var $rootCategory = $("<div id='" + categoryData[i].ID + "' class='categoryItem' onclick='ClickNoSubCategory(event)'><span>" + categoryData[i].Name + "</span></div>");
                }
                $categorySet.append($rootCategory);
            }
            return $categorySet;
        }
        //页面上弹出层选择类目的方法
        var $currentSelectCategoryDivIdNum;
        function ClickHasSubCategory(event) {
            if (event instanceof jQuery == false) {
                event = event ? event : window.event;
                var eventSrc = event.srcElement ? event.srcElement : event.target;
                var $eventSrc = $(eventSrc);
                if ($eventSrc.attr("class") == "hasSubCategory" || $eventSrc[0].tagName == 'SPAN') {
                    $eventSrc = $eventSrc.parent();
                }
            } else {
                $eventSrc = event;
            }
            var $currentCategoryID = $eventSrc.attr("id");
            $currentSelectCategoryDivIdNum = RemoveDiv($eventSrc);
            //根据触发获取子类目事件的id请求parentID为该id的类目数据
            $.ajax({
                url: "../../Category/Categories",
                type: "get",
                async: false,
                data: { "categoryID": $currentCategoryID },
                success: function (res) {
                    if (res != null) {
                        var jsonRes = JSON.parse(res);
                        var $categoryDiv = CreateSelectCatgoryDiv(240, 300, (parseInt($currentSelectCategoryDivIdNum) + 1));
                        $("#categoryDivContainer").append($categoryDiv);
                        var $data = GetProductCategoryData(jsonRes);
                        $categoryDiv.append($data);
                        //点击某一个父类目之后，将其categoryName记录在类样式名为hasSelectedCategoryDiv的div中
                        var $selectedCategory = $("<span id=" + $currentSelectCategoryDivIdNum + " cID=" + $eventSrc.attr("id") + ">" + $eventSrc.text() + "&gt&gt</span>");
                        $(".hasSelectedCategoryDiv #selectedCategoryName").append($selectedCategory);
                        //$(".cate-path").append($selectedCategory);
                        //点击有子类目的项之后将“已选好类目，进入下一步”按钮隐藏
                        $("#nextPage").addClass("disabled");
                        $("#nextPage").attr("disabled", true);
                    }
                },
                error: function () {
                }
            });
        }
        function nextPage() {
            var cText = "";
            var cid = "";
            $("#selectedCategoryName span").each(function () {
                cText += $(this).text().trim();
                cid += $(this).attr("cid") + ",";

            })
            cText = cText.replace(/\n/g, "").replace(/\s/g, "");
            //cText = encodeURIComponent(cText);
            cid = cid.substring(0, cid.length - 1);
            location.href = "NewAddProduct?cText=" + cText + "&cid=" + cid;
        }

    </script>
	<!-- step 所需的css,js-->
	<link href="js/fuelux/css/fuelux.css" rel="stylesheet">
	<link href="js/fuelux/css/fuelux-responsive.min.css" rel="stylesheet">

<style>
.cmRight_con.manage_a_cmRight_con {
	height: 580px;
}

#cate_1 {
	width: 920px;
	margin: 0px auto;
}

.selectCategoryDiv {
	position: relative;
	float: left;
	background: #FFF;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	/*border-left: 1px solid #e1e1e1;
	border-right: 1px solid #e1e1e1;
	border-bottom: 1px solid #e1e1e1;
	box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.04);*/
	margin: 5px 7px;
}

.category-search {
	background: #fff;
	/*box-shadow: 0 2px 2px rgba(0, 0, 0, .1);*/
	position: relative;
}

.category-search i {
	position: absolute;
	top: 8px;
	left: 8px;
}

.category-search input {
	margin-bottom: 0;
	padding-top: 0;
	padding-bottom: 0;
	text-indent: 30px;
	width: 215px;
	height: 30px;
	border: 1px solid #e1e1e1;
}

.categorySet {
	overflow-x: hidden;
	overflow-y: auto;
	height: 390px;
	border: 1px solid #e1e1e1;
	margin-top: 5px;
}

.categoryItem {
	width: 215px;
	height: 30px;
	line-height: 30px;
	text-align: left;
	font-size: 14px;
}

.categoryItem:hover {
	width: 215px;
	height: 30px;
	line-height: 30px;
	background-color: #fe4101;
	cursor: pointer;
	color: #fff;
}

.categoryItemClick {
	width: 215px;
	height: 30px;
	line-height: 30px;
	background-color: #fe4101;
	cursor: pointer;
	color: #fff;
}

.categoryItem span {
	display: inline-block;
	margin-left: 10px;
	white-space: nowrap;
	max-width: 177px;
	text-overflow: ellipsis;
	overflow: hidden;
}

.hasSubCategory {
	float: right;
	margin-right: 20px;
	font-size: 12px;
	height: 30px;
	line-height: 30px;
}
#search{
    margin: 0px;
    padding: 0px;
    overflow: auto;
	
}
</style>

	<div class="cmRight manage_new_cmRight  manage_a_cmRight">
		<div class="cmRight_tittle">发布产品</div>


		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">

			<div class="dingdan_kehuguanli_top">
				<div class="search_2 manage_fenlei_search_2">
					<div>
						<input type="text" class="search2_con manage_fenlei_search2_con"
							placeholder="输入分类名称" name="cate_name">
					</div>
					<div class="search2_btn manage_fenlei_search2_btn">
						<a href="javascript:search_cate()">查看路径</a>
					</div>
				</div>
			</div>
			<div id="cate_1">
				<div id="search"></div>
				<div id="selectCategoryDiv1" class="selectCategoryDiv"
					style="height: 420px;">
					<div class="category-search">
						<i><img src="images/search.png" width="17" height="17"></i> <input
							type="text" placeholder="输入名称" onkeyup="searchItem(this,1)">
					</div>
					<div class="categorySet">
						<?php foreach($categorys as $cates){?>
						<div id="<?php echo $cates['id']?>" class="categoryItem"
							onclick="getCategory('<?php echo $cates["id"]?>',1,event)">
							<span><?php echo $cates['name']?></span>
								<?php if($cates["attr_set_id"] == 0){?>
							<div class="fa fa-angle-right hasSubCategory"></div>
								<?php }?>
						</div>
								<?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="next">
			<p>
				您当前选择的是：<span id='cate_list'><!-- 显示当前选择 --></span>
			</p>
			<button type="button" class="btn btn-faile nextBut" id="nextpage">下一步</button>
			<!--不能点击时加class"disabled"并不能点击状态即可-->
		</div>
	</div>
	
	<script src="js/ckeditor/ckeditor.js"></script>
	<script src="js/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="js/dropzone/dropzone.min.js"></script>
	<script>
	var navTxtArray = new Array();
	var navIDArray = new Array();
	function getCategory(id,level,event)
	{
		//去掉样式
		if (event instanceof jQuery == false) {
			event = event ? event : window.event;
            var eventSrc = event.srcElement ? event.srcElement : event.target;
            var $eventSrc = $(eventSrc);
            if ($eventSrc.attr("class") == "hasSubCategory" || $eventSrc[0].tagName == 'SPAN') {
                $eventSrc = $eventSrc.parent();
            }
         } else {
                $eventSrc = event;
         }
        
		$eventSrc.siblings().removeClass("categoryItemClick");
        $eventSrc.addClass("categoryItemClick");

		navTxtArray[level-1] = $.trim($eventSrc.text());
		navIDArray[level-1] = $eventSrc.attr("id");
		
		for(var i=level;i<navIDArray.length;i++)
		{
			navTxtArray.splice(i,1);
			navIDArray.splice(i,1);
		}

		var s = "";
		$('#navigation').find('li').remove();
		for(var i=0;i<navTxtArray.length;i++)
		{
			$('#navigation').append('<li>'+navTxtArray[i]+'</li>');
		}
		
		//处理数据
		if(level<=5)
		{
			for(var i=level+1;i<=5;i++)
			{
				$('#cate_'+i).remove();
			}

    		$.post('<?php echo site_url('corporate/product/getChildCategory')?>',{"id":id},function(data){
    
    			for(var i=level+1;i<=5;i++)
    			{
    				$('#cate_'+i).remove();
    			}
    			if(data.length>2)
    			{
    
    				var result = JSON.parse(data);
    				var str = '<div  id="cate_'+(level+1)+'"><div id="selectCategoryDiv1" class="selectCategoryDiv" style="height: 420px;"><div class="category-search"><i class="icon-search-tabao  fa fa-search"></i><input type="text" placeholder="输入名称"  onkeyup="searchItem(this,'+(level+1)+')"></div>'+
    					'<div class="categorySet" >';
    					for(var i=0;i<result.length;i++)
    					{
    						str = str+'<div id="'+result[i]["id"]+'" class="categoryItem" onclick="getCategory('+result[i]["id"]+','+(level+1)+',event)">'+
    							'<span>'+result[i]["name"]+'</span>';
    						if(result[i]["attr_set_id"] ==0)
    						{
    							str = str+'<div class="fa fa-angle-right hasSubCategory"></div>';
    						}
    							str = str+'</div>';
    					}
    					
    				str = str+'</div></div></div>';
    				$('#cate_'+level).after(str);
    				$('#nextpage').removeAttr("onclick");
    				$("#nextpage").addClass("btn-faile");
    				$("#nextpage").removeClass("btn-success");
    			}else
    			{
    				$("#nextpage").addClass("btn-success");
    				$("#nextpage").attr("onclick","nextPage();");
    			}
    		} );
		}

		//显示当前选择
		var $elements = $('.categoryItemClick');
		var len = $elements.length;
		var html = '';
	 	for(var i=0;i<len;i++){
		 	if(i==0){
		 		html+=$(".categoryItemClick span").eq(i).html();
		 	}else{
		 		html+=('>'+$(".categoryItemClick span").eq(i).html());
		 	}
	 	}
	 	$("#cate_list").html(html);
	 	
	}

	function nextPage() {
            location.href = "<?php echo site_url('corporate/product/edit')?>/0/" + navIDArray[navIDArray.length-1];
	}


	function searchItem(obj,item)
	{
		var val = $.trim($(obj).val());
		
		if( val != "" )
		{
			$('#cate_'+item).find("span").each(function(){
				if($(this).html().indexOf(val)>-1){
					$(this).parent("div").show();
				}else
				{
					$(this).parent("div").hide();
				}
			});
		}else
		{
			$('#cate_'+item).find("span").each(function(){
				$(this).parent("div").show();
			});
		}
	}

	function search_cate(){
		
	    var name = $("input[name=cate_name]").val();
	    
	    $.post("<?php echo site_url("corporate/product/getChildCatename") ?>",{cate_name:name},function(data){
		    data = jQuery.parseJSON(data);
		    if(data!=''){
			    $("#search").css("height","100px");
		    }else{
			    $("#search").css("height","0px");
		    }
		    var html = "";
	        for(var i = 0; i<data.list.length; i++){
		        html = html+'<div class="cate_nei">';
		        for(var j = 0; j<data.list[i].length; j++){
			        html = html+'<span '+(j==(parseInt(data.list[i].length)-1)?'class="cate_nei2"':'class="cate_nei1"')+'>'+data.list[i][j].name+'</span>'+(j==(parseInt(data.list[i].length)-1)?'':'>');
			    }
			    html = html+'</div>';
		    }
	       $("#search").html(html); 
		});
	}

	</script>
	</div>