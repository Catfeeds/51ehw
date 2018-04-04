<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>

<style>
.cmRight_con.manage_a_cmRight_con {
	height:450px;
	margin: 10px 0 0 0;
}
.gerenzhongxin_01_con{ width:932px;margin:0;}

#cate_1 {
	width: 924px;
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
	background-color: #fca643;
	cursor: pointer;
	color: #fff;
}

.categoryItemClick {
	width: 215px;
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
.needs_publish_fenlie {margin-left: 30px;margin-top: 20px;}
.needs_publish_fenlie_icon {color: #E54A4F;}
.needs_details_next {width: 915px;height: 60px;background: #F9E6BD;border: 1px solid #FBAB55;margin-left: 25px;line-height: 60px;}
.needs_details_next p {margin-left: 20px;}
.needs_details_next p span {color: #C3482C;display: inline-block;padding-left: 15px;}


.webuploader-pick { 
    /* top: -35px; 
    left: 200px;*/
    background: #62BB10;
    width: 140px;
 } 

.webuploader-container { 
    position: static; 
}
.parentFileBox>.fileBoxUl>li>.diyCancel,
.parentFileBox>.diyButton{text-align: left; margin-left: 35px; } 
 #fileBox_WU_FILE_0{height: 150px;width:170px!important;float:left!important;margin-right: 6px;margin-left: 35px;padding:0px}
 #fileBox_WU_FILE_1{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_2{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 #fileBox_WU_FILE_3{height: 150px;width:170px!important;float:left!important;margin-right: 6px;padding:0px}
 .cmRight_con.manage_a_cmRight_con ul li{ float:left!important;}
 .diyUploadHover{ width:170px!important;padding:0px!important; }
 .fileBoxUl li{ width:170px!important; float: left;}
.parentFileBox>.fileBoxUl>li:hover { -moz-box-shadow:none; -webkit-box-shadow: none; box-shadow:none; }
.procurement-text7{display:block!important;}
#cke_explain{width:698px!important; float: right;margin-right: 40px;position: relative;top: -30px;}
.need-text5 {width: 274px;border: 1px solid #C8C8C8;outline: none;-webkit-appearance: none;border-radius: 0;background: #fff;color: #CACACA;padding-left: 10px;background: url("images/needs_right_icon.png") no-repeat scroll right center transparent;}
.procurement-time02 {padding-left: 0px;}
.needs_publish_tijiao {width: 170px;height: 40px;background: #6DC310;margin-top: 25px;margin-left: 160px;color: #fff;border: 1px solid #6DC310; border-radius: 3px;display: block;line-height: 40px;text-align: center; }
.bainse{margin-right:229px; margin-top:11px; color:#C3482C; float:right;}
#demo .parentFileBox {width: 590px!important;}
</style>



<!--内容开始-->
   
    <div class="Box manage_new_Box clearfix">
         <div class="kehu_Left">
    		<ul class="kehu_Left_ul">
    			<li class="kehu_title"><a>个人中心</a></li>
    			<li><a
    				href="<?php echo site_url('member/info')?>">个人信息</a></li>
    			<li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
    			<li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li>
    			<li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
               <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
    		</ul>
    		<ul>
    			<li class="kehu_title"><a>订单中心 </a></li>
    			<li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
    			<li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
    			<li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
    		</ul>
    		<ul>
    			<li class="kehu_title"><a>客户中心</a></li>
    			<li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
    			<li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
    			<!--<li><a href="javascript:;">分红结算</a></li>-->
    		</ul>
    		<ul>
    			<li class="kehu_title"><a>客户服务</a></li>
    			<li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
    			<!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
    			<!--<li><a href="javascript:;">在线客服</a></li>-->
    			<!-- <li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
    		</ul>
    		
    	</div>
        <!---->
       <form method="post" action="<?php echo site_url('demand/add_demand');?>">     
            <div class="cmRight1 manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
                    <div class="huankuan_rTop"><?php echo $status?'修改需求信息':'发布需求信息';?></div>
                       
                       <div class="gerenzhongxin_01_con clearfix">
                   <div class="needs_publish_fenlie">
                   	  <span class="needs_publish_fenlie_icon">*</span><span>分类：</span>
                   </div>
        		   <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">
        
        			<div id="cate_1">
                        <div id="selectCategoryDiv1" class="selectCategoryDiv" style="height: 420px;margin-left: 4px;">
                            <div class="category-search">
                                <i><img src="images/search.png" width="17" height="17"></i> <input type="text" placeholder="输入名称" onkeyup="searchItem(this,1)">
                            </div>
                            <div class="categorySet">
                                <?php foreach($categorys as $cates){?>
                                <div id="<?php echo $cates['id']?>" class="categoryItem" onclick="getCategory('<?php echo $cates["id"]?>',1,event,'<?php echo $cates["name"]?>')">
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

        
        		   <div class="needs_details_next">
        			<p>
        				您当前选择的是：<span id='cate_list'><!-- 显示当前选择 --><?php echo $status?$detail['name']:"请至少选择一个分类";?></span>
        				<!-- 识别是否选择分类所用 -->
        				<input type="hidden" name="cate_id" value="<?php echo $status?$detail['cate_id']:"";?>">
        			</p>
        		    </div>
        		</div>
        
        
        	<div class="need"><!-- 需求产品 -->
                   <ul>
                       <li> <div class="title-nav_l"><span><span class="xinghao" style="color:#E1454F!important;">*</span>标题：</span></div><input placeholder="" type="text" value="<?php echo $status?$detail['title']:"";?>" name="title" class="need-text3"><span class="procurement-time" ></span></li>
                       <li> <div class="title-nav_l"><span><span class="xinghao" style="color:#E1454F!important;">*</span>数量：</span></div><input type="text" value="<?php echo $status?$detail['p_count']:"";?>" name="number" class="need-text4"><span class="procurement-time" ></span></li>
                       <li> <div class="title-nav_l"><span><span class="xinghao" style="color:#E1454F!important;">*</span>单位：</span></div>
                       
                  <select  class="need-text5" id="unit">
                    <option value="">请选择</option>
                    <option value="千克" <?php if($status){echo $detail['unit']=='千克'?'selected':"";} ?>>千克</option>
                    <option value="斤"   <?php if($status){echo $detail['unit']=='斤'?'selected':"";} ?>>斤</option>
                    <option value="件" <?php if($status){echo $detail['unit']=='件'?'selected':"";} ?>>件</option>
                    <option value="吨"   <?php if($status){echo $detail['unit']=='吨'?'selected':"";} ?>>吨</option>
                    <option value="包" <?php if($status){echo $detail['unit']=='包'?'selected':"";} ?>>包</option>
                    <option value="份"   <?php if($status){echo $detail['unit']=='份'?'selected':"";} ?>>份</option>
                    <option value="箱" <?php if($status){echo $detail['unit']=='箱'?'selected':"";} ?>>箱</option>
                    <option value="栋" <?php if($status){echo $detail['unit']=='栋'?'selected':"";} ?>>栋</option>
                    <option value="套" <?php if($status){echo $detail['unit']=='套'?'selected':"";} ?>>套</option>
                  </select>
                    
                  <span class="procurement-time  procurement-time02" ></span></li>
                       <li> <div class="title-nav_l"><span><span class="xinghao" style="color:#E1454F!important;">*</span>需求总价：</span></div><input type="text" value="<?php echo $status?$detail['min_vip_price']:"";?>" name="price_min" class="need-text6"><span class="need-line">-</span><input type="text" value="<?php echo $status?$detail['max_vip_price']:"";?>" name="price_max" class="need-text7"><span class="procurement-time" ></span>货豆</li>
                       <li> <div class="title-nav_l"><span>图片/图纸/文档：</span></div><samp class="bainse">只能上传图片、txt文档和pdf文档格式的附件</samp></li>
                       </ul>
                        <!-- 选择上传按钮 -->
                        <div id="demo">
                            <div id="as">

                            </div>
                        </div>
                      
<!--                         <li> -->
                    <?php if($status && $detail['img_path']){?>
                    <label style="margin-left: 40px;"><span class="red">*</span>已有商品图片：</label>
                    <div class="new_edit_box clearfix">
                    <div style="margin-left: 40px;">
                        <?php foreach($img as $k=>$v){?>
                        <div style="float:left;" class="parentFileBox" id="<?php echo 'img_'.$k;?>">
                            <ul class="fileBoxUl">
                            <li id="fileBox" class="diyUploadHover" style="border: none; width:170px!important; float:left!important;">
                            <div class="viewThumb"> <img src="<?php echo IMAGE_URL.$v;?>"> </div>  
                            <div class="diyCancel" onclick="del_img(this,'<?php echo $k;?>','<?php echo $v;?>')"></div>
                            <div class="diySuccess"></div>
                            <div class="diyFileName"></div>
                            </li>  
                            </ul>
                        </div>
                        <?php };?>
                    </div>
                    <?php };?>
                    </div>




                    <div class="procurement"><!-- 采购需求 -->
                        <div>  
                        <ul>
                        <li><div class="title-nav_l"><span class="shijjj">需求描述：</span></div><textarea class="procurement-text7" name="explain"><?php echo $status?$detail['p_content']:"";?></textarea></li>                                                                                                       
                        <li style="overflow:hidden;"><div class="title-nav_l"><span class="xinghao" style="color:#E1454F!important;">*</span><span class="shijjj">报价截止时间：</span></div> <input type="text" name="effectdate" value="<?php echo $status?$detail['effectdate']:"";?>" class="laydate-icon"  id="lxdb_2" onClick="WdatePicker()" readonly><span class="procurement-time" id="procurement-time"></span></li>
                        <li><div class="title-nav_l"><span class="xinghao" style="color:#E1454F!important;">*</span><span class="shijjj">期望收货时间：</span></div><input type="text" value="<?php echo $status?$detail['receiptdate']:"";?>" class="laydate-icon"  id="lxdb_2"name="receiptdate" onClick="WdatePicker()" readonly><span class="procurement-time" ></span></li>
                        <li><div class="title-nav_l" style="margin-top: -10px;"><span class="shijjj">报价要求：</span></div><input type="checkbox" <?php  if($status){echo $detail['needtax']?'checked':"";};?> name="needtax" value="0" /><span class="shijjj" style="padding-left: 8px;">需要报含稅价</span> </li>
                        <li><div class="title-nav_l"><span class="xinghao" style="color:#E1454F!important;">*</span><span class="shijjj">期望价格：</span></div><input type="text" name="m_price" value="<?php echo $status?$detail['m_price']:"";?>" class="procurement-text3"><span class="procurement-time" style="color:#000000!important;padding-right: 40px;" >货豆／件</span><input type="checkbox" <?php  if($status){echo $detail['price_demand']==1?'checked':"";};?> name="price_demand" value="1" /><span class="shijjj" style="padding-left: 8px;">价格详议</span></li>
                         <li> <div class="title-nav_l"><span class="xinghao" style="color:#E1454F!important;">*</span><span class="shijjj">省市区</span></div>                      
                               <span id="consignee_arae" style="margin-left:0" >
                                <?php 
                                $data['province_selected'] = $status?$detail['province_id']:"";
                                $data['city_selected'] = $status?$detail['city_id']:"";
                                $data['district_selected'] = $status?$detail['district_id']:"";
                                ?>
                                <?php $this->load->view('widget/district_select',$data); ?>
                                </span><span class="procurement-time"></span>
                         </li>                       
                        <li><div class="title-nav_l"><span class="xinghao" style="color:#E1454F!important;">*</span><span class="shijjj">详细地址：</span></div><input type="text" value="<?php echo $status?$detail['shippingaddress']:"";?>" name="address" class="procurement-text4"><span class="procurement-time" ></span></li>
                        <li><span class="needs_publish_tijiao" id="tijiao" onclick="sub()">提交</span></li>
                        </ul>
                        </div>
                    </div>
                </div>
                </div></form>
               </div>

     



    <script type="text/javascript" src="js/jedate/jedate.js"></script>
    <script src="js/ckeditor/ckeditor.js"></script>
    <script src="js/ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="js/dropzone/dropzone.min.js"></script>

    <script type="text/javascript">
     $(function(){
     	 $(".dagou").on("click",function(){
          var index = $(this).index();
           $(this).toggleClass("active");
         })
    
         // 按钮切换
         $(".need a").on("click", function() {
    	   var index = $(this).index();
    	   $(this).addClass("tab1").siblings().removeClass("tab1");
    	   })
     })
     
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
						str = str+'<div id="'+result[i]["id"]+'" class="categoryItem" onclick=getCategory('+result[i]["id"]+','+(level+1)+',event,&apos;'+escape(result[i]["name"])+'&apos;)>'+
							'<span>'+result[i]["name"]+'</span>';
						if(result[i]["attr_set_id"] ==0)
						{
							str = str+'<div class="fa fa-angle-right hasSubCategory"></div>';
						}
							str = str+'</div>';
					}
					
				
				str = str+'</div></div></div>';
				$('#cate_'+level).after(str);
				$("#cate_list").text(unescape(name));
			}else
			{
				$("#cate_list").text(unescape(name));
			}


			$("input[name=cate_id]").val(id);
			
		} );
		}
	}



    //分类搜索
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
	url:'<?php echo site_url("member/demand/upload_file") ?>',
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
	"filebrowserImageUploadUrl": "<?php echo site_url("member/demand/editor_upload") ?>"
});
</script>


<script>
//提交表单
function sub(){
	$(".procurement-time").text("");
	$("#tijiao").attr("onclick","");
	var state = true;
	var oEditor = CKEDITOR.instances.explain; //oEditor.getData() 
	var explain = oEditor.getData();
	var title = $('input[name=title]').val();//*
	var number = $('input[name=number]').val();//*
    var unit = $("#unit").val();
	var price_min = $('input[name=price_min]').val();//*
	var price_max = $('input[name=price_max]').val();//*
	var receiptdate = $('input[name=receiptdate]').val();//*
	var effectdate = $('input[name=effectdate]').val();
	var needtax = $('input[name=needtax]:checked').val();
	var m_price = $('input[name=m_price]').val();
	var address = $('input[name=address]').val();//*
	var price_demand = $('input[name=price_demand]:checked').val();
	var cate_id = $('input[name=cate_id]').val();
    var status = <?php echo $status;?>;
    var id = <?php echo $status?$detail['id']:0;?>;

    var province_id = $('select[name=province_id]').val();
    var city_id = $('select[name=city_id]').val();
    var district_id = $('select[name=district_id]').val();

        if(!title){
        	$('input[name=title]').next().text('请填写标题');
        	state = false;
            }

        if(isNaN(number) || number<=0){
        	$('input[name=number]').next().text('请填写正确的数量');
        	state = false;
            }
         if(!cate_id){
        	 $("#cate_list").text('请至少选择一个分类');
        	 state = false;
         }

        if(!unit){
        	$("#unit").next().text('请选择');
        	state = false;
            }
        
        if(price_min.length > 0 && price_max.length > 0){
        if(!isNaN(price_min) && !isNaN(price_max)){
            if(parseInt(price_min)>parseInt(price_max) || parseInt(price_min)<=0){
            	$('input[name=price_max]').next().text('请填写正确的区间价格');
            	state = false;
        	}
         }else{
        	$('input[name=price_max]').next().text('请填写正确的区间价格');
        	state = false;
         }
        }else{
        	$('input[name=price_max]').next().text('请填写区间价格');
        	state = false;
        }

        if(effectdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
        	$('input[name=effectdate]').next().text('请选择截止日期');
        	state = false;
            }else{
            	if(Date.parse( effectdate )<=Date.parse(new Date("<?php echo date('Y-m-d')?>"))){
            		$('input[name=effectdate]').next().text('最少1天');
            		state = false;
                	}else{
                    	var day = (Date.parse( effectdate )-Date.parse(new Date("<?php echo date('Y-m-d')?>")))/86400000;
                    	$('input[name=effectdate]').next().text(+day+'天后');
                }
       }



        if(receiptdate.search(/^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/)==-1){
        	$("input[name=receiptdate]").next().text('请选择收货日期');
        	state = false;
        }else{
        	if(Date.parse( receiptdate )<=Date.parse(new Date("<?php echo date('Y-m-d')?>"))){
        		$("input[name=receiptdate]").next().text('最少1天');
        		state = false;
            }else{
            	var day = (Date.parse( receiptdate )-Date.parse(new Date("<?php echo date('Y-m-d')?>")))/86400000;
            	$("input[name=receiptdate]").next().text(+day+'天后');
            }
        }

        if(isNaN(m_price) || m_price<=0){
        	$('input[name=m_price]').next().text('请填写期望价格');
        	state = false;
            }


        if(province_id && city_id && district_id){}else{
        	
        	$("#consignee_arae").next().text('请选择省市区');
            state = false;
            }
        if(address.search(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/)){
        	$('input[name=address]').next().text('请填写正确的地址');
        	state = false;
            }
    if(state){
    	$.post("<?php echo site_url("member/demand/add_demand") ?>",
    		  {explain:explain,title:title,number:number,unit:unit,price_min:price_min,
    		   price_max:price_max,receiptdate:receiptdate,
    		   effectdate:effectdate,needtax:needtax,
    		   m_price:m_price,
    		   address:address,
    		   price_demand:price_demand,
    		   cate_id:cate_id,status:status,id:id,
    		   province_id:province_id,city_id:city_id,
    		   district_id,district_id},
    		   function (data){
    			   
    			    if(!isNaN(data) && data>0){ 
    				    alert('成功');
    				    window.location="<?php echo site_url('member/demand') ?>"
    				    }else{
    				    	alert('失败');
    				    	window.location.reload();
    					    }
    			   });
    }else{
    	$("#tijiao").attr("onclick","sub()");
        }



}

//删除图片
function del_img(obj,key,val){
	id="<?php echo $status?$detail['id']:0;?>"
    $.post("<?php echo site_url('member/demand/del_img');?>",{key:key,val:val,id:id},function(data){
        data = jQuery.parseJSON(data)
    	switch(data['status']){
    	case 'non_exist':
        	alert('需求不存在');
        	break;
    	case 'ok':
    		$('#img_'+key).remove();
        	alert('删除成功');
        	break;
    	case 'fail':
        	alert('删除失败');
        	break;
    	}
    });
}
</script>


<script type="text/javascript">
    jeDate({
		dateCell:"#start_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
	
	jeDate({
		dateCell:"#end_at",
		format:"YYYY-MM-DD hh:mm:ss",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"2014-09-19 00:00:00",
		okfun:function(val){//alert(val)
			}
	})
</script>

