<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<style>

 .webuploader-pick { 
     top: -35px; 
    left: 200px;
 } 

.webuploader-container { 
    position: static; 
}
.parentFileBox>.fileBoxUl>li{ background-color: #fff;}
.parentFileBox{ width:980px!important;}
.parentFileBox>.fileBoxUl>li>.diyCancel, .parentFileBox>.fileBoxUl>li>.diySuccess{left: 180px;}
.parentFileBox>.diyButton{text-align: left; margin-left: 35px;} 
 #fileBox_WU_FILE_0{height: 150px;width:175px!important;float:left!important;margin-right: 6px;}
 #fileBox_WU_FILE_1{height: 150px;width:175px!important;float:left!important;margin-right: 6px;}
 #fileBox_WU_FILE_2{height: 150px;width:175px!important;float:left!important;margin-right: 6px;}
 #fileBox_WU_FILE_3{height: 150px;width:175px!important;float:left!important;margin-right: 6px;}
 .cmRight_con.manage_a_cmRight_con ul li{ float:left!important;}
 .diyUploadHover{ width:170px!important;}
.parentFileBox>.fileBoxUl>li:hover { -moz-box-shadow:none; -webkit-box-shadow: none; box-shadow:none; }
.procurement-text7{display:block!important;}
#cke_explain{width:698px!important; float: right;margin-right: 40px;position: relative;top: -30px;}
.parentFileBox>.fileBoxUl>li>.viewThumb{ width:190px!important;}
.viewThumb img{ padding:25px 0 0 25px;}

</style>
<div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <!--  -->
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<!--内容开始-->
    <form action="<?php echo site_url("corporate/demand/add_demand") ?>" method="post" id='demand_info'><!-- 表单开始 -->
    <div class="Box manage_new_Box clearfix">
     <div class="cmLeft manage_new_cmLeft">
             <!--<div class="manage_logo cmLeft_top"> 
			<img src="<?php //echo $corporation['img_url']?site_url($corporation['img_url']):'images/m_logo.jpg'; ?>" alt="">
		</div>-->
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">供需管理</div>
            <div class="cmLeft_down">
            	<ul>
                <li  class="houtai_zijin_current"><a href="<?php echo site_url("corporate/demand/demand_release") ?>">发布需求</a></li>
				<li><a href="<?php echo site_url("corporate/demand/get_list") ?>">供应信息</a></li>
                <li><a href="<?php echo site_url("corporate/demand/get_requirement") ?>">需求信息</a></li>
                </ul>
            </div>
        </div>
        <!---->
    <div class="cmRight1 manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">供应信息</div>
                <div class="demand">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con">
                 <div class="publish">
		<div class="title"><!-- 标题 -->
		    <div class="title-nav">1.标题</div>	
			<h5>
            <div class="title-nav_l"><span class="xinghao">*</span><span class="title-text">标题：</span></div>
           <input type="text" value="" placeholder="请填写标题" name="title" class="input-text"><span class="procurement-time" ></span>
           </h5>
			<h5> <div class="title-nav_l"><span class="xinghao">*</span><span class="title-text">分类：</span></div><span class="diannao-text" style=" display:none"><a href="javascript:void(0);"  id='class_name' ></a></span><a href="javascript:void(0);" onClick="show()"class="genxin-text">选择分类</a></h5>
		    <input type='hidden' name='product_class' ><span class="procurement-time" ></span>
		</div>
	<div class="need"><!-- 需求产品 -->
		<div class="title-nav">2.需求产品</div>
		<h5><span style="margin-right:80px;">现货/加工:</span>
                   <input type="radio"  checked="checked" name="type" value="1" />现货/标准品
                   <input type="radio" name="type" value="2" />加工/定制品 
        </h5>
           <ul>
               <li> <div class="title-nav_l"><span><span class="xinghao">*</span>产品名称：</span></div><input placeholder="请填写产品名称" type="text" value="" name="product_name" class="need-text3"><span class="procurement-time" ></span></li>
               <li> <div class="title-nav_l"><span><span class="xinghao">*</span>数量：</span></div><input type="text" value="" name="number" class="need-text4"><span class="procurement-time" ></span></li>
               <li> <div class="title-nav_l"><span><span class="xinghao">*</span>单位：</span></div><input type="text" value="" name="kg" placeholder="例子：千克" class="need-text5"><span class="procurement-time" ></span></li>
               <li> <div class="title-nav_l"><span><span class="xinghao">*</span>价格区间：</span></div><input type="text" value="" name="price_min" class="need-text6"><span class="need-line">-</span><input type="text" value="" name="price_max" class="need-text7"><span class="procurement-time" ></span></li>
               <li> <div class="title-nav_l"><span>产品描述：</span></div><input type="text" value="" placeholder="填写规格说明，报价更精确" name="describe" class="need-text8"></li>
               <li> <div class="title-nav_l"><span>图片/图纸/文档：</span></div></li>
                <!-- 选择上传按钮 -->
                <div id="demo">
                    <div id="as">
                    </div>
                </div>
              

                
           </ul>
	</div>
	<div class="procurement"><!-- 采购需求 -->
		<div class="title-nav">3.采购需求</div>
		<div>  
		   <ul>                                                                                                       
			<li><div class="title-nav_l"><span class="xinghao">*</span><span class="shijjj">报价截止时间：</span></div> <input type="text" name="receiptdate" value="" class="laydate-icon"  id="lxdb_2" onClick="WdatePicker()" readonly><span class="procurement-time" id="procurement-time"></span></li>
			<li><div class="title-nav_l"><span class="xinghao">*</span><span class="shijjj">期望收货时间：</span></div><input type="text" value="" class="laydate-icon"  id="lxdb_2"name="effectdate" onClick="WdatePicker()" readonly><span class="procurement-time" ></span></li>
			<li><div class="title-nav_l"><span class="shijjj">报价要求：</span></div><input type="checkbox" name="price_demand" value="0" /><span class="shijjj" />需要报含稅价</span> </li>
			<li><div class="title-nav_l"><span class="xinghao">*</span><span class="shijjj">收货地：</span></div><input type="text" name="address" value="" class="procurement-text3"><span class="procurement-time" ></span></li>
			<li><div class="title-nav_l"><span class="shijjj">补充说明：</span></div><textarea class="procurement-text7" name="explain"></textarea></li>
			<li><div class="title-nav_l"><span class="xinghao">*</span><span class="shijjj">联系人：</span></div><input type="text" value="" name="contacts" class="procurement-text4"><span class="procurement-time" ></span></li>
			<li><div class="title-nav_l"><span class="xinghao">*</span><span class="shijjj">电话：</span></div><input type="text" value="" name="mobile" class="procurement-text5"><span class="procurement-time" ></span></li>
			<li><div class="title-nav_l"><span class="shijjj">备注：</span></div><textarea id='remarks' placeholder="请在这里输入您的备注" name="remarks" class="procurement-text6"></textarea></li>
			</ul>

		</div>
	</div>
   </div>
                    
                </div>
        </div>
        </div>
        
        
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style=" display:none;">
            <div class="cmRight_tittle">供应信息</div>
                <div class="demand">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con">
                 <div class="result_null" style=" width:910px; margin:10px auto;">暂无内容</div>
                </div>
        </div>
        </div>
        
        
     </div>
     
</form><!-- 表单结束 -->

<!-- 弹窗 -->
<div class="dingdan4_3_tanchuang" style=" display:none;">
  <div class="dingdan4_4_tanchuang_con">
    <div class="dingdan4_4_tanchuang_top">商品分类</div>
    <div class="dingdan4_4_tanchuang_top2">
      <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">

		
		    <div id="cate_1">
                
                        <div id="selectCategoryDiv1" class="selectCategoryDiv"
                            style="height: 420px;margin-left: 4px;">
                            <div class="category-search">
                                <i><img src="images/search.png" width="17" height="17"></i> <input
                                    type="text" placeholder="输入名称" onkeyup="searchItem(this,1)">
                            </div>
                            <div class="categorySet">

                                <?php foreach($categorys as $cates){?>
                                <div id="<?php echo $cates['id']?>"
                                    class="categoryItem"
                                    onclick="getCategory('<?php echo $cates["id"]?>',1,event,'<?php echo $cates["name"]?>')">
                                    <span><?php echo $cates['name']?></span>
                                    <?php if($cates["attr_set_id"] == 0){?>
                                    <div class="fa fa-angle-right hasSubCategory">></div>
                                    <?php }?>
                                  </div>
                                 <?php }?>
                            </div>
                        </div>
                  
            </div>
        

          </div>
        </div>
      </div>
    </div>
    <div class="dingdan4_4_tanchuang_btn">
      <div class="dingdan4_4_btn01" style="background:#ccc;"><a href="<?php echo site_url('corporate/demand/get_list');?>">取消</a></div>
      <div class="dingdan4_4_btn02"><a href="javascript:void(0);" id='tijiao'>确认</a></div>
    </div>
  </div>
</div>    

	<style>
.selectCategoryDiv {
	position: relative; width:370px;
	float: left; margin:0 10px;
	background: #FFF;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	/*border-left: 1px solid #e1e1e1;
	border-right: 1px solid #e1e1e1;
	border-bottom: 1px solid #e1e1e1;
	box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.04);*/
    margin-right: 6px;
}

.category-search {
	background: #fff;
	/*box-shadow: 0 2px 2px rgba(0, 0, 0, .1);*/
    position: relative; margin-bottom:10px;
	
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
    width:368px;
    height: 30px;
    border: 1px solid #e1e1e1;
}

.categorySet {
	overflow-x: hidden;
	overflow-y: auto;
	height:390px;
    border: 1px solid #e1e1e1;
}

.categoryItem {
	width: 330px;
	height: 30px;
	line-height: 30px;
    text-align: left;
    font-size: 14px;
	padding:0 20px;

}

.categoryItem:hover {
	width: 370px;
	height: 30px;
	line-height: 30px;
	background-color: #fca643;
	cursor: pointer;
	color: #fff;
}

.categoryItemClick {
	width:370px;
	height: 30px;
	line-height: 30px;
	background-color: #fca643;
	cursor: pointer;
	color: #fff;
}

.categoryItem span {
	display: inline-block;
	margin-left: 10px;
	white-space: nowrap;
	max-width: 200px;
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

<script src="js/ckeditor/ckeditor.js"></script>
		<script src="js/ckeditor/adapters/jquery.js"></script>
		<script type="text/javascript" src="js/dropzone/dropzone.min.js"></script>
</style>

    <script type="text/javascript">
     $(function(){
     	 $(".dagou").on("click",function(){
          var index = $(this).index();
           $(this).toggleClass("active");
         })
         //$(".genxin-text").on("click",function(){
         	//$(".dingdan4_3_tanchuang").css("display","block");
         //})
         // 按钮切换
         $(".need a").on("click", function() {
		   var index = $(this).index();
		   $(this).addClass("tab1").siblings().removeClass("tab1");
	})
     })
	 
	 
	 function show(){ 
	$('.dingdan4_3_tanchuang').show();
}
   </script> 
   
 <script>
	var navTxtArray = new Array();
	var navIDArray = new Array();
	function getCategory(id,level,event,name)
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
		//alert(navTxtArray.length);

		for(var i=level;i<navIDArray.length;i++)
		{
			//alert(navTxtArray[i]+"88888");
			//alert(navIDArray[i]+"^^^^^");
			navTxtArray.splice(i,1);
			navIDArray.splice(i,1);
		}

		//alert(navTxtArray);
		var s = "";
		$('#navigation').find('li').remove();
		for(var i=0;i<navTxtArray.length;i++)
		{
			$('#navigation').append('<li>'+navTxtArray[i]+'</li>');
		}



		//处理数据
		if(level<=4)
		{
			
			for(var i=level+1;i<=4;i++)
			{
				$('#cate_'+i).remove();
			}
		
		$.post('<?php echo site_url('corporate/product/getChildCategory')?>',{"id":id},function(data){
			
			for(var i=level+1;i<=4;i++)
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
						str = str+'<div id="'+result[i]["id"]+'" class="categoryItem" onclick=productclass('+result[i]["id"]+',"'+result[i]['name']+'")>'+
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
				$('.diannao-text').show();
			}else
			{
				productclass(id,name);
				//$('#nextpage').removeClass("btn-faile")
				$("#nextpage").addClass("btn-success");
				$("#nextpage").attr("onclick","nextPage();");
				$('.diannao-text').show();
				  
			}
			
		} );
		}
	}


	function nextPage() {

          //alert("dddd");
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
	</script>

<script type="text/javascript">
/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/
$('#as').diyUpload({
	url:'<?php echo site_url("corporate/demand/upload_file") ?>',
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	},
	buttonText : '选择文件',
	chunked:true,
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:3,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});


//编辑器
CKEDITOR.replace('explain', {
	width:800, 
	height:100,
	"filebrowserImageUploadUrl": "<?php echo site_url("corporate/demand/editor_upload") ?>"
});
</script>

<script>
function productclass(id,name){
	$('#class_name').html(name);
	$('input[name=product_class]').val(id);
	$('.dingdan4_3_tanchuang').hide();
}
//提交表单
$('#tijiao').click(function(){
	$('.procurement-time').text('');
	var oEditor = CKEDITOR.instances.explain; //oEditor.getData() 
	var explain = oEditor.getData();
	var title = $('input[name=title]').val();//*
	var product_name = $('input[name=product_name]').val();//*
	var number = $('input[name=number]').val();//*
	var kg = $('input[name=kg]').val();//*
	var price_min = $('input[name=price_min]').val();//*
	var price_max = $('input[name=price_max]').val();//*
	var describe = $('input[name=describe]').val();
	var receiptdate = $('input[name=receiptdate]').val();//*
	var effectdate = $('input[name=effectdate]').val();
	var address = $('input[name=address]').val();//*
	var mobile = $('input[name=mobile]').val();//*
	var remarks = $('#remarks').val();
	var price_demand = $('input[name=price_demand]:checked').val();
	var type = $('input[name=type]:checked').val();
	var product_class = $('input[name=product_class]').val();
	var contacts = $('input[name=contacts]').val();

        if(!title){
        	$('input[name=title]').next().text('请填写标题');
            return false;
            }
	
         if(!product_class){
        	 $('input[name=product_class]').next().text('请选择分类');
             return false;
         }

         
        if(!product_name){
        	$('input[name=product_name]').next().text('请填写商品名称');
            return false;
            }
        if(isNaN(number) || number<=0){
        	$('input[name=number]').next().text('请填写正确的数量');
            return false;
            }

        if(kg.length<=0){

                	$('input[name=kg]').next().text('请填写正确的重量');
                    return false;

            }
        if(price_min.length > 0 && price_max.length > 0){
        if(!isNaN(price_min) && !isNaN(price_max)){
            if(parseInt(price_min)>parseInt(price_max) || parseInt(price_min)<=0){
            	$('input[name=price_max]').next().text('请填写正确的区间价格');
         	   return false;
        	}
         }else{
        	$('input[name=price_max]').next().text('请填写正确的区间价格');
            return false;
         }
        }else{
        	$('input[name=price_max]').next().text('请填写区间价格');
            return false;
        }
        
        if(receiptdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
        	$('#procurement-time').text('请选择截止日期');
            return false;
            }else{
            	if(Date.parse( receiptdate )<=Date.parse(new Date("<?php echo date('Y-m-d')?>"))){
            		$('#procurement-time').text('最少1天');
                    return false;
                	}else{
                    	var day = (Date.parse( receiptdate )-Date.parse(new Date("<?php echo date('Y-m-d')?>")))/86400000;
                		$('#procurement-time').text(+day+'天后');
                    	}
                }
        if(effectdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
            if(effectdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
            	$('input[name=effectdate]').next().text('请选择期望日期');
                return false;
                }else{
                	if(Date.parse( effectdate )<=Date.parse(new Date("<?php echo date('Y-m-d')?>"))){
                		$('input[name=effectdate]').next().text('最少1天');
                        return false;
                    	}else{
                        	var day = (Date.parse( effectdate )-Date.parse(new Date("<?php echo date('Y-m-d')?>")))/86400000;
                        	$('input[name=effectdate]').next().text(+day+'天后');
                        	}
                    }
        }
        
        if(address.search(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/)){
        	$('input[name=address]').next().text('请填写正确的地址');
            return false;
            }

        if(contacts.search(/^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/)==-1){
        	$('input[name=contacts]').next().text('请输入真实姓名').removeClass('state1').addClass('state3');
            return false;
        }

        if(mobile.search(/^1\d{10}$|^(0\d{2,3}-?|\(0\d{2,3}\))?[1-9]\d{4,7}(-\d{1,8})?$/)){
        	$('input[name=mobile]').next().text('请填写手机或者固定电话').removeClass('state1').addClass('state3');
     	    return false;
            }



	$.post("<?php echo site_url("corporate/demand/add_demand") ?>",{explain:explain,title:title,
		   product_name:product_name,number:number,kg:kg,price_min:price_min,
		   price_max:price_max,describe:describe,receiptdate:receiptdate,
		   effectdate:effectdate,address:address,contacts:contacts,mobile:mobile,
		   remarks:remarks,price_demand:price_demand,type:type,product_class:product_class},function (data){
			    if(!isNaN(data) && data>0){ 
				    alert('发布成功');
				    window.location="<?php echo site_url('corporate/demand/get_requirement') ?>"
				    }else{
				        alert('发布失败');
					    }
			   });
		



});

</script>