<script type="text/javascript">
<!--
$(document).ready(function(){
	//app();
})
function app(){
	    $.ajax({
	        url:"<?php echo site_url("customer/app") ?>",
	        success:function(){

		     },
		});
}
//-->

window.alert = function(str)  
    {  
     $('.dingdan4_3_tanchuang').hide();
     var shield = document.createElement("DIV");  
     shield.id = "shield";  
     shield.style.position = "fixed";  
     shield.style.left = "0px";  
     shield.style.top = "0px";  
//      shield.style.width = "100%";  
     shield.style.height = document.body.scrollHeight+"px";  
     //弹出对话框时的背景颜色  
     shield.style.background = "#000000";  
     shield.style.textAlign = "center";  
     shield.style.zIndex = "25";  
     //背景透明 IE有效  
     //shield.style.filter = "alpha(opacity=0)"; 
	  var alertFram_1 = document.createElement("DIV");   
     var alertFram = document.createElement("DIV"); 
	 alertFram_1.id="alertFram_1"; 
     alertFram_1.style.position = "fixed";
	 alertFram_1.style.width = "100%";  
     alertFram_1.style.height = "100%";  
     alertFram_1.style.background = "rgba(0,0,0,0.5)";   
	 alertFram_1.style.zIndex = "99999";  
	 alertFram_1.style.top = "0";       
     alertFram.id="alertFram";
     alertFram.style.position = "fixed";  
     alertFram.style.left = "50%";  
     alertFram.style.top = "50%";  
     alertFram.style.marginLeft = "-200px";  
     alertFram.style.marginTop = "-100px";  
     alertFram.style.width = "400px";  
     alertFram.style.height = "200px";  
     alertFram.style.background = "#fff";  
     alertFram.style.textAlign = "center";  
     alertFram.style.lineHeight = "200px";  
     alertFram.style.zIndex = "999999";  
	  strHtml = "<div>\n";  
     strHtml = "<ul style=\"list-style:none;margin:0px;padding:0px;width:100%\">\n";  
     /*strHtml += " <li style=\"background:#DD828D;text-align:left;padding-left:20px;font-size:14px;font-weight:bold;height:25px;line-height:25px;border:1px solid #F9CADE;\">[自定义提示]</li>\n";*/  
     strHtml += " <li style=\"background:#fff;text-align:center;font-size:16px;height:135px;line-height:150px;color:#555555;font-weight:bold\">"+str+"</li>\n";  
     strHtml += " <li style=\"background:#fe4101;width:300px;text-align:center;font-weight:bold;height:40px;line-height:40px;margin:0px auto\"><input style=\"width:300px;background:none;line-height:40px;border:none;color:#fff;font-size:16px; cursor:pointer\" type=\"button\" value=\"确 定\" onclick=\"doOk()\" /></li>\n";  
     strHtml += "</ul>\n";  
	 strHtml += "</div>\n";  
     alertFram.innerHTML = strHtml;  
     document.body.appendChild(alertFram);  
	 document.body.appendChild(alertFram_1);  
     document.body.appendChild(shield);  

     this.doOk = function(){  
         alertFram_1.style.display = "none"; 
		 alertFram.style.display = "none";  
         shield.style.display = "none";  
     }  
     alertFram.focus();  
     document.body.onselectstart = function(){return false;};  
    }  

</script>


<input type="hidden" id="search_type"  value="<?php echo !empty($search_type)?$search_type:0;?>">
<div class="headtop" id="top">
	<div class="eh_toolbar clearfix">
		<div class="fl">
			<ul class="eh_toolbar_node">
				<li><a href="<?php echo site_url("home");?>">首页</a></li>
				<li class="line">|</li>
			   <?php 
			  
			   if (!$this->session->userdata('user_in')){  ?>
			<!--未登录状态 开始-->
				<li>您好，<span><a href="<?php echo site_url('customer/login')?>">请登录</a></span>&nbsp;&nbsp;&nbsp;<span><a
						href="<?php echo site_url('customer/registration')?>">免费注册</a></span></li>
				<!--未登录状态 结束-->
                                <?php }else{?>
			<!--登录状态 开始-->
				<li>您好，<span><a href="<?php echo site_url('member/info') ?>"><?php echo $this->session->userdata('user_name');?> </a></span><span><a
						href="<?php echo site_url("customer/logout");?>">退出</a></span></li>
				<!--登录状态 结束-->
                                    <?php }?>

            </ul>
		</div>
		<div class="fr">
			<ul class="sf-menu" id="sf-menu">
				<?php if($this->session->userdata("is_staff")){;?>
                <li><a href="<?php echo site_url("member/info");?>">个人中心</a></li>
				<li class="line">|</li>
				<li><a href="javascript:corpList(0);">管理企业</a></li>
				<?php }else if( $this->session->userdata('corporation_id') > 0 && ( $this->session->userdata('approval_status')== 2 ) ){?>
				<li><a href="<?php echo site_url("member/info");?>">个人中心</a></li>
				<li class="line">|</li>
				<li><a href="<?php echo site_url("corporate/info");?>">企业中心</a></li>
				<li class="line">|</li>
				<li><a href="<?php echo site_url('corporate/advertisement') ?>" target="_blank">广告系统</a></li>
				<?php }else{?>
				<li><a href="<?php echo site_url("member/info");?>">个人中心</a></li>
				<li class="line">|</li>
				<li><a href="<?php echo site_url("customer/is_authenticate");?>">绑定企业</a>
				</li>
				<?php }?>
                <li class="line">|</li>
				<li><a href="<?php echo site_url("member/fav");?>">收藏夹</a></li>
				<li class="line">|</li>
				<li><a href="<?php echo site_url('member/complain') ?>">客户服务</a></li>
				
				<!--<li>
                    <i class="icon-pad"></i>
                    <a href="">手机导航</a>
                </li>-->
			</ul>
		</div>
	</div>
</div>
<!--headtop end-->
<div class="eh_header">
 	<div class="eh-header-con clearfix">
		<a href="<?php echo site_url("home");?>" class="logo_set" title="51易货网"> <img 
			alt="51易货网" src="images/eh_logo.jpg">
		</a> <a class="banner_set" title="51易货网"
			href="http://www.51ehw.com/index.php/home/GoToShop/157"> <img
			src="images/eh_t_01.jpg" alt="51易货网" width="230" height="60">
		</a>
		<div class="fenzhan_p">
  <div class="fenzhan_w" >
    <div class="fenzhan">
      <h2>
      	<span class="icon-coordinate"> </span>
         <span><?php echo $this->session->userdata("app_info")["app_name"] ?></span>

        <a class="sel" href="javascript:void(0);">[更换]</a>
      </h2>
      <div class="con_w">
        <div class="con_bg"></div>
        <div class="con_fz">
          <div class="set" style="display:block !important;"> 当前站点：<b><?php echo $this->session->userdata("app_info")["app_name"] ?></b> <span class="mark"></span> <a class="del" style="display:none"  href="javascript:delSiteCity();">删除</a> <a id="defaultSetId" class="setDefault" href="javascript:void(0);">[设为默认城市]</a> </div>
          <div class="set_w">
            <div class="sets"> 请先登录，再做设置！ </div>
          </div>
          <div class="hot">
            
          </div>
          <div class="search1">
            <input type="text" value="请输入城市名"  class="text fl" onclick="value = '';" id="c_text" />
            <input type="submit" value="搜索" class="sub fl" onclick="return searchCity(this.form);" />
            <ul class="show fl">
              <li class="on" id="py">按拼音展示</li>
            </ul>
          </div>
          <div class="tips_w">
            <div class="tips"> 非常抱歉，该城市暂无体验店！ </div>
          </div>
          <div class="pinyin">
            <div class="hd"> <a href="javascript:void(0);">A</a><a href="javascript:void(0);">B</a><a href="javascript:void(0);">C</a><a href="javascript:void(0);">D</a><a href="javascript:void(0);">E</a><a href="javascript:void(0);">F</a><a href="javascript:void(0);">G</a><a href="javascript:void(0);">H</a><a href="javascript:void(0);">J</a><a href="javascript:void(0);">K</a><a href="javascript:void(0);">L</a><a href="javascript:void(0);">M</a><a href="javascript:void(0);">N</a><a href="javascript:void(0);">P</a><a href="javascript:void(0);">Q</a><a href="javascript:void(0);">R</a><a href="javascript:void(0);">S</a><a href="javascript:void(0);">T</a><a href="javascript:void(0);">W</a><a href="javascript:void(0);">X</a><a href="javascript:void(0);">Y</a><a href="javascript:void(0);">Z</a> </div>
            <div class="bd">
            <div class="bd_w">
            <?php
            $app_info = $this->session->userdata("app");
            $juge = "";
            if(count($app_info)>0):
                foreach ($app_info as $key => $a) :
                   $letter = $a["letter"] ;
                    if($letter==$a["letter"] && $juge != $a["letter"]):
                    ?>
                    <ul>
                        <li class="t"><i><?php echo $a["letter"] ?></i></li>
                        <li>
                    <?php
                        foreach ($app_info as $k =>$b):
                        if($letter == $b["letter"]):
                    ?>
                         <a href="<?php echo site_url("home/set_memcached")."?url=".urlencode($b["site_url"])?>"><?php echo $b["app_name"]?></a>
                    <?php
                        $juge = $b["letter"];
                        endif;
                        endforeach;

                    ?>
                    </li>
                    </ul>
                    <?php
                    elseif($letter!=$a['letter']):
                        $letter=$a['letter'];
                    endif;
                //echo $juge;
                endforeach;
            endif;
            ?>
            </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
		<form name="search_form" action="<?php echo site_url('search');?>"
			method="post" onsubmit="return formsearch()">
			<div class="eh_search_cn">
				<div id="search_bd" class="search_bd">
					<ul>
						<li <?php if(!isset($search_type)):?>class="selected"<?php endif;?>>商品</li>
						<!-- <li <?php //if(isset($search_type)&& $search_type == 2):?>class="selected"<?php //endif;?>>需求</li>  -->
						<li <?php if(isset($search_type)&& $search_type == 3):?>class="selected"<?php endif;?>>企业</li>
					</ul>
				</div>

				<div id="search_hd" class="search_hd">
					<div class="search_bg"></div>
					<input type="text" id="search_product" class="search_input" name="" value="<?php echo isset($keyword)?$keyword:"";?>">
						<?php echo !isset($keyword)?'<span class="s1 pholder"><i class="icon-find"></i>搜商品</span>':''?>
						<?php //echo !isset($keyword)?'<span class="s2 pholder"><i class="icon-find"></i>搜商家需求</span>':''?>
						<?php echo !isset($keyword)?'<span class="s3 pholder"><i class="icon-find"></i>搜商家企业</span>':''?>

					<button id="submit" class="btn_search" value="搜索">搜索</button>
				</div>
			</div>
		</form>
          <div class="eh_myorder_r">
		<div class="eh_myorder">
			<a href="<?php echo site_url("member/order");?>" class="eh_head_btn"><i
				class="icon-preview"></i>我的订单</a>
		</div>
		<div class="eh_cart" style="display:block">
			<em id="cart_count"><?php 
			$cartcount = 0;
			foreach($this->cart->contents() as $items){
			    $cartcount = $cartcount + $items['qty'];
			}
			echo $cartcount;
			?></em>
			<a href="<?php echo site_url("cart");?>" class="eh_head_btn"
				id="head_cart_bt"><i class="icon-cart"></i>购物车</a>
            <?php if (count($this->cart->contents()) > 0){?>
            <div class="eh_cart_list" style="display: none">
             <p style="width: 402px; height: 15px; position: absolute; top: -16px;left: -1px;"></p>
				<label>最新加入的商品：</label>
				<ul>
				<?php foreach($this->cart->contents() as $items): ?>
                    <li class="clearfix">
						<div class="fl">
							<img src="<?php echo IMAGE_URL.$items['options']['goods_img'];?>"
								alt="">
							<div class="title">
								<a href="<?php echo site_url('goods/detail/'.$items['id']);?>"
									target="_blank">
									<h1><?php echo $items['name'];?></h1>
								</a>
								<!--<p><span>土豪金</span><span>5L</span></p>-->
							</div>
						</div>
						<div class="fr">
							<div class="con">
								<span class="price"><?php echo $items['price'][0] =='.' ? '0'.$items['price'] :$items['price']?>货豆</span><span
									class="number"><i>x</i><span><?php echo $items['qty'];?></span></span></span>
							</div>
							<div class="btn">
								<a
									onclick="ajax_del_cart(this,'<?php echo $items['rowid']; ?>','cartpage_<?php echo $items["id"]?>','<?php echo isset($items['cid'])?$items['cid']:"" ?>')">删除</a>
							</div>
						</div>
					</li>
				<?php endforeach; ?>

                    <div class="eh_balance clearfix">
						<p>
							<span id="count_two">共<?php echo count($this->cart->contents());?>件商品</span>共计
							<span>￥<span id="count_three"><?php echo $this->cart->total(); ?></span></span>
						</p>
						<a href="<?php echo site_url('cart')?>">去购物车</a>
					</div>
				</ul>
			</div>
		    <?php }?>

        </div>
       </div>
	</div>
</div>
<!--eh_header end-->

<!-- 弹框 -->
<?php $is_staff = $this->session->userdata("is_staff");?>
<?php if($is_staff){;?>
<?php $corp_list = $this->session->userdata("corp_list");$i=0;?>
<div class="alert_bg_header" hidden>
    <div class="alert_header" >
        <span class="cha">x</span>
        <h5>请选择店铺<a href="javascript:close();"  ></a></h5>  
        <div class="alert_er_header">
            <ul id="corp_box">
                <?php foreach($corp_list as $k=>$v){;?>
                <?php if($i==0){;?>
                <li class="alert_er_dianj">
                <?php if($v["status"]==3){;?>
                <del><a href="javascript:void(0);"><?php echo $v["corporation_name"];?></a></del>
                <?php }else{;?>
                <a href="javascript:void(0);"><?php echo $v["corporation_name"];?></a>
                <?php };?>
                </li>
                <input type="hidden" value="<?php echo $v["id"];?>">
                <input type="hidden" value="<?php echo $v["status"];?>" >
                <?php $i++;?>
                <?php }else{;?>
                <li>
                <?php if($v["status"]==3){;?>
                <del><a href="javascript:void(0);"><?php echo $v["corporation_name"];?></a></del>
                <?php }else{;?>
                <a href="javascript:void(0);"><?php echo $v["corporation_name"];?></a>
                <?php };?>
                </li>
                <input type="hidden" value="<?php echo $v["id"];?>" >
                <input type="hidden" value="<?php echo $v["status"];?>" >
                <?php };?>
                <?php };?>
            </ul>
            <a href="javascript:SureCorp();"><h4>确认</h4></a>
        </div>
    </div>
</div>
<?php };?>
<!-- end -->

<script>
    $(function(){

    	var search_type = $('#search_type').val();
    	if(search_type === '0'){
    		$('#search_bd li').eq(0).addClass('selected').siblings().removeClass('selected');
    		$("#search_product").attr("name","product");
        	}else if(search_type === '2'){
        		$('#search_bd li').eq(1).addClass('selected').siblings().removeClass('selected');
//         		$("#search_product").attr("name","need");//需求
        		$("#search_product").attr("name","enterprise");
            	}else if(search_type === '3'){
            		$('#search_bd li').eq(2).addClass('selected').siblings().removeClass('selected');
            		$("#search_product").attr("name","enterprise");
                	}



        //头部搜索切换
        $('#search_hd .search_input').on('input propertychange',function(){
            var val = $(this).val();
            if(val.length > 0){
                $('#search_hd .pholder').hide(0);
            }else{
                var index = $('#search_bd li.selected').index();
                $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            }
        })
        $('#search_bd li').click(function(){
            
            var index = $(this).index();

            switch(index){
            case 0:
            	$("#search_product").attr("name","product");
                break;
            case 1:
//             	$("#search_product").attr("name","need");//需求
            	$("#search_product").attr("name","enterprise");
                break;
            case 2:
            	$("#search_product").attr("name","enterprise");
                break;
            }
            $('#search_hd .pholder').eq(index).show().siblings('.pholder').hide(0);
            $(this).addClass('selected').siblings().removeClass('selected');
            $('#search_hd .search_input').val('');
        });
    })

	/*$(document).ready(function() {
    	$('.eh_cart').hover(
			function(){
				$('.eh_cart_list').show();
			},
			function(){
				$('.eh_cart_list').hover(function(){},function(){
					$('.eh_cart_list').hide();
				})
			}
		);
	});*/
     
	 
	 <!--购物车移上显示下拉-->
  $(document).ready(function(){
  $(".eh_head_btn").mouseover(function(){
   /* $(this).next("div").slideDown(300);*/
   $(this).next("div").show();
   
  });
  $(".eh_cart").mouseleave(function(){
   /* $(this).children("div").slideUp(300);*/
    $(this).children("div").hide();
  });
});



</script>
<script>
//ajax无刷新删除购物车商品
function ajax_del_cart(o,rid,id,cid){
	aja_delete(rid,cid);
// 	var count = $("#cart_count").html()-1;
// 	var totals = $("#count_three").html();
// 	var total = $(o).parent().prev('div').children('span').html();
// 	var quary = $(o).parent().prev('div').children('span').children("span").html();
// 	$("#count_two").html("共"+count+"件商品");
// 	$("#count_three").html(totals-(total*quary));
// 	$(o).parent().parent().parent().remove();
}

</script>


<!-- 分站点城市加入 wdd add start 0224 -->
<script>
var userName ='';
var email ='';
var loginName ='';
var userId='';
var defaultCity='';//用户设置的默认城市拼音
var defaultCityName='广州';//当前进入分站点城市名称
var defaultCityPy='guangzhou';//当前进入分站点城市拼音
var statusCity='1';
var user_name='';
if( userName != null && userName != "")
{
	user_name=userName;
}

else if( email != null &&email!="")
{
	user_name=email;
}
else if(loginName!= null&&loginName!="")
{
	user_name=loginName;
}

$(function(){

	$(".set").hide();
	$(".set .setDefault").hide();
	//当前登录用户已设置为默认城市，则对应的当前城市位置显示为已设为默认城市
	if(statusCity!=null && statusCity=="0"){
		if(defaultCityPy==null || defaultCityPy.length==0){
			$("#cityIndex").attr("href","/");//设置首页菜单的url
		}else{
			$("#cityIndex").attr("href","/"+defaultCity+"/");//设置首页菜单的url
		}
	}else if(statusCity!=null && statusCity=="1"){
		if(defaultCity==null || defaultCity.length==0){//如果登录用户没有设置默认城市
			if(defaultCityPy!=null && defaultCityPy.length>0){//如果登录用户选择了城市，首页地址显示对应的城市的链接
				$("#cityIndex").attr("href","/"+defaultCityPy+"/");//设置首页菜单的url
			}else{
				$("#cityIndex").attr("href","/");//设置首页菜单的url
			}
		}else{
			if(defaultCityPy!=null && defaultCityPy.length>0){//如果登录用户选择了城市，首页地址显示对应的城市的链接
				$("#cityIndex").attr("href","/"+defaultCityPy+"/");//设置首页菜单的url
			}else{
				$("#cityIndex").attr("href","/"+defaultCity+"/");//设置首页菜单的url
			}
		}

	}else{
		if(defaultCityPy!=null && defaultCityPy.length>0){//如果未登录用户选择了城市，首页地址显示对应的城市的链接
			$("#cityIndex").attr("href","/"+defaultCityPy+"/");
		}else{
			$("#cityIndex").attr("href","/");
		}
	}
	var scName='广州';

	//地区对应城市描述信息加载
	var scityNames=document.getElementsByName("scityName");
	var html="";
	for(var i=0;i<scityNames.length;i++){
		  var descr=scityNames[i].value;
		  html+="<ul>";
		  html+="<li><b>"+descr.split(':')[0]+"：</b></li><li class='c_list'>";
		  var descr2=descr.split(':')[1];
		  var descr3=descr2.split(",");
		  for(var j=0;j<descr3.length;j++){
			  var cityname=descr3[j].split('_')[0];
			  var phonetic=descr3[j].split('_')[1];
			  html+="<a href='http://www.51ehw.com"+ phonetic +"/' >";
			  if(j==descr3.length-1){
				  html+=cityname+"</a>";
			  }else{
			  	  html+=cityname+"</a>";
			  }

		  }
		  html+="</li></ul>";
	}
	$("#daqu_w").append(html);

	$(".fenzhan .sel").hover(function(){
			$(this).addClass("sel_on");
			$(".con_w").show();
		},function(){
			$(this).removeClass("sel_on");
			$(".con_w").hide();
		});
	$(".con_w").hover(
		function(){
		$(".fenzhan .sel").addClass("sel_on");
		$(".con_w").show();
		},function(){
			$(".fenzhan .sel").removeClass("sel_on");
			$(".con_w").hide();
		});
	 $("#py").click(function(){
		 $("#dq").removeClass("on");
	 	 $(this).addClass("on");
		  $(".daqu").hide();
		 $(".pinyin").show();
		 })	;
	 $("#dq").click(function(){
		 $("#py").removeClass("on");
		 $(this).addClass("on");
		 $(".pinyin").hide();
		 $(".daqu").show();
		 })	;
		 $(".pinyin .hd a").mouseover(function(){
			 var ai = $(this).index();
			 var bi = $(".bd_w").find("ul").eq(ai);
			 var wh = $(".bd_w").position().top;
			 var k =  bi.position().top;
			 var bd = $(".bd_w");
			 var bds =bd.scrollTop();
             var t = k - wh + bds;
			 $(".bd_w").animate({scrollTop:t},50);
			 })

			$("#c_text").blur(function(){
				var cv = $(this).val();
				if(cv == ''){
					$(this).val('请输入城市名');
				}
			});
			$("#c_text").focus(function(){
				$(this).val('');
			});


	})
	function setSiteCity(pinyin){
		if( user_name==null || user_name=='' || 'undefined'==user_name){
			$(".set_w").show();
		}else{
			if(pinyin!=null && pinyin.length>0){
				$.ajax({
						type:"post",
						url: "/user/changeCityName.htm",
						data: {"phonetic": pinyin,"iid":userId}
				});
				$(".set .mark").html('已设为默认城市').show();
				$(".set .del").show();
				$(".set .del").attr("href","javascript:delSiteCity('"+pinyin+"');");
				$(".set .setDefault").hide();
				$("#cityIndex").attr("href","/"+pinyin+"/");
			}
		}
	}
	function delSiteCity(pinyin){
		$.ajax({
			type:"post",
			url: "/user/changeCityName.htm",
			data: {"phonetic": '',"iid":userId}
		});
		$(".set .setDefault").show().html('[设为默认城市]');
		$(".set .setDefault").attr("href","javascript:setSiteCity('"+pinyin+"');");
		$(".set .mark").hide();
		$(".set .del").hide();
		$("#cityIndex").attr("href","/"+pinyin+"/");
	}
	function searchCity(){
		var key=$("#c_text").val();
		if(key=="请输入城市名"||key==""){
			key = '';
			$("#c_text").val("");
		}
		else
		{
    		$.ajax({
    				type:"get",
    				url: "<?php echo site_url("customer/search_app") ?>",
    				asycn:false,
    				data: {"cityName": key},
    				dataType:"json",
    				success:function(data){
    				   if (data.success) {
							window.location.href= data.app.site_url;
    				   }
    				   else{
    					   $(".tips_w").show();
    				   }
    	    		}
    		});
		}
	}

	//管理企业列表
	function corpList(){
		$.ajax({
			url:'<?php echo site_url("Corporate/info/corp_update");?>',
			dataType:'json',
// 			async:false, 
			type:'get',
			data:{},
			success:function(data){
				 if(data.corplist.length>0){
					 result = '';
					 for(var i=0;i<data.corplist.length;i++){
						 if(i == 0){
							 result += '<li class="alert_er_dianj">';
							 if(data.corplist[i]['status'] == 3){
								 result += '<del><a href="javascript:void(0);">'+data.corplist[i]['corporation_name']+'</a></del>';
								 }else{
									 result += '<a href="javascript:void(0);">'+data.corplist[i]['corporation_name']+'</a>';
									 }
							 result += '</li>';
							 result += '<input type="hidden" value="'+data.corplist[i]['id']+'">';
							 result += '<input type="hidden" value="'+data.corplist[i]['status']+'" >';
							 }else{
								 result += '<li>'; 
								 if(data.corplist[i]['status'] == 3){
									 result += '<del><a href="javascript:void(0);">'+data.corplist[i]['corporation_name']+'</a></del>';
									 }else{
										 result += '<a href="javascript:void(0);">'+data.corplist[i]['corporation_name']+'</a>';
										 }
								 result += '</li>';
								 result += '<input type="hidden" value="'+data.corplist[i]['id']+'">';
								 result += '<input type="hidden" value="'+data.corplist[i]['status']+'" >';  
								 }
						 }
					 $('#corp_box').html(result);
					 /*点击切换*/
					 $(".alert_er_header li").on("click",function(){
					 	  $(this).addClass("alert_er_dianj").siblings().removeClass("alert_er_dianj");	  
					 	  })
				 	 $(".alert_bg_header").show();
					 }
				},
			error:function(data){}
			});

	}


	//切换店铺
	function SureCorp(){
        var corp_id = $(".alert_er_dianj").next().val();//店铺id
        var status = $(".alert_er_dianj").next().next().val();//状态
      
        //隐藏弹窗
      	 $(".alert_bg_header").hide();
    	 $('body').css({ 
                 "overflow-x":"auto",
                 "overflow-y":"auto"        
            });
         
//         if(status == 3){
//         	alert("你的权限可能被冻结，请联系店主！");return;
//         }
        $.post("<?php echo site_url("Corporate/info/corp_change");?>",{corp_id:corp_id},function(data){
            switch(data['status']){
                case 1:
                	window.location.href = "<?php echo site_url("Corporate/info");?>";
                    break;
                case 2:
                    alert("你的权限可能被冻结，请联系店主！");
                    setTimeout(function(){
                    	location.reload();
                        },3000);
                    break;
                default:
                	location.reload();
                    break;
            }
        },"json");
	}


</script>

<script>
/*点击显示禁止body滚动*/
$("").on("click",function(){
	 $(".alert_bg_header").show();
	 $('body').css({ 
             "overflow-x":"hidden",
             "overflow-y":"hidden"       
         })
	})
/*点击关闭禁止body滚动恢复*/	
$(".cha").on("click",function(){
	 $(".alert_bg_header").hide();
	 $('body').css({ 
             "overflow-x":"auto",
             "overflow-y":"auto"        
        });
	})
/*点击切换*/
$(".alert_er_header li").on("click",function(){
	  $(this).addClass("alert_er_dianj").siblings().removeClass("alert_er_dianj");	  
	  })
</script>