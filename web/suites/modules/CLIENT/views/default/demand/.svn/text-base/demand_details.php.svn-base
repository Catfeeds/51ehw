<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->

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

<div class="content_company clearfix">
      <!-- 需求详情导航 开始 -->
    <div class="needs_details_nav">
       <a href="<?php echo site_url("home");?>">首页 > </a>
       <a href="<?php echo site_url('member/demand/demand_list');?>">列表需求 > </a>
       <a href="javascript:void(0);" class="needs_details_nav_active">需求详情</a>
    </div>
    <!-- 需求详情导航 结束 -->

     <!-- 需求详情头部 开始 -->
     <div class="needs_details_header">
        <div class="needs_details_title"><?php echo $detail['title'];?></div>
        <div class="needs_details_text01">期望价格：<span class="needs_details_num"><?php echo $detail['m_price'];?></span> 货豆/<?php echo $detail['unit'];?>&nbsp;&nbsp;  
        <?php switch($detail['tax_freight']){
		        case 0:
		     ?>       
		        (不含税 不含运费)
		     <?php      break;
	            case 2:
	         ?>
	           (含运费)
	         <?php      break;
                case 3:
             ?>
                (含税)
             <?php      break;
                case 4:
             ?>
                (含税 含运费)
             <?php 
                    break;
		    }?>
        </div>
        <div class="needs_details_text02">
          <span>需求数量：<span><?php echo $detail['p_count'];?><?php echo $detail['unit'];?></span></span>
          <span class="needs_details_dizhi">收货地：<span><?php echo $detail['province'].$detail['city'].$detail['district'];?></span></span>
          <?php if($detail['img_path']){?>
          <form action="<?php echo site_url('member/demand/download');?>" method='post' id="download" hidden>
			    <input type="hidden" name="file_name" value="<?php echo $detail['img_path'];?>">
		  </form>
          <span class="needs_details_tupian">图片/文档：<span><a href="javascript:download()" class="needs_details_xiazai">下载附件</a></span></span>
          <?php };?>
        </div>
        <div class="needs_details_text03">
          <span>截止日期：<span><?php echo $detail['effectdate'];?></span></span>
          <span class="needs_details_day" style="padding-left: 72px;">期望收货日期：<span><?php echo $detail['receiptdate'];?></span></span>
        </div>  
        <!-- 我要换 -->
       <div class="needs_details_huan">
          <a href="javascript:barter(<?php echo $detail['id']?>);" class="needs_details_text_huan"><span>我要换</span></a>
       </div>

     </div><!-- 需求详情头部 结束 -->


    <!-- 需求描述 开始 -->
    <div>
         <div class="needs_list_publish_title">
            <em></em><span>需求描述:</span>
        </div>

<!--         <div class="needs_details_main01"> -->
<!--           <a href="javascript:void(0);"> -->
<!--              <img src="images/needs_details01.png" alt=""><br> -->
<!--              <span>当清晨的第一缕阳光照在这片肥沃的葡萄园上，辛勤的劳作者们便开始葡萄的采摘工作，也只有当露珠还挂在枝头，大地刚开始苏醒的适合；才能保证每一颗葡萄都是最合适作为葡萄酒的原材料。</span> -->
<!--           </a> -->
        <?php echo $detail['p_content'];?>
    </div>
       

        
       <!-- 猜你喜欢 -->
       <div class="needs_list_youlove" hidden>
            <div class="needs_list_publish_title">
              <em></em><span>猜你喜欢:</span>
           </div>
           <div class="needs_list_youlove_main">
               <ul>
                   <li><a href="javascript:void(0);"><img src="images/needs_love01.png" alt="">
                     <span>尊荣外景特惠套餐High Fashion 定制造…</span>
                    </a>
                    <span class="needs_list_jiage">易货价:<span>50,000.00</span>货豆</span>  
                   </li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love02.png" alt=""><span>
                      那片森林 咥水果 精品A套餐 绿色食品
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>298.00</span>货豆</span></li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love03.png" alt=""><span>
                      西安冠杰广告媒体 21城电梯广告
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>8,000.00</span>货豆</span></li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love04.png" alt=""><span>
                       杭州深林小座品牌餐厅
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>68.00</span>货豆</span></li>
               </ul>
           </div>
        </div> 
      

    </div><!-- 需求描述 结束 -->    
 
 </div>






    <!-- 弹窗 -->
<div class="dingdan4_3_tanchuang " id="dingdan4_3_tanchuang02" style=" display:none;">
  <div class="dingdan4_4_tanchuang_con" style="margin:-349px 0 0 -480px">
    <div class="dingdan4_4_tanchuang_top">我要换货<a href="javascript:cancel();" class="icon-guanbi" style="float:right;margin-top: 22px;margin-right: 25px;font-size: 20px;color:#999;"></a></div>
    <div class="dingdan4_4_tanchuang_top2">
      <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">
            <div id="cate_1">
                <div class="needs_tanchuang">需求产品： <span><?php echo $detail['title'];?></span></div><br>
                <div class="needs_tanchuang">需求数量： <span><?php echo $detail['p_count'];?>件</span></div><br>
                <div class="needs_tanchuang">需求总价： <span><?php echo $detail['min_vip_price'];?>～<?php echo $detail['max_vip_price'];?>货豆</span></div><br>
                <div class="needs_tanchuang">收货地区： <span><?php echo $detail['province'].$detail['city'].$detail['district'];?></span></div><br>
                <form action="<?php echo site_url('member/demand/barter');?>" method="post" id="barter">
                    <div class="needs_tanchuang">联系方式： <input type="text" name="contactuser" > </div><br>
                    <div class="needs_tanchuang"><em style="opacity: 0;">测试</em>备注:  <textarea style="height:200px;width:430px;border: 1px solid #A2A2A2;outline: none;" name="remark"></textarea> </div>  
                    <input type="hidden" name="requirement_id" value="<?php echo $detail['id'];?>">
                </form>
                <div class="needs_tanchuang_dianhua">
                   <div class="needs_tanchuang_dianhua_text01">联系平台即有客服急速为您匹配换货商</div>
                   <div class="needs_tanchuang_dianhua_text02">客服电话：<span class="needs_tanchuang_dianhua_text03">400-0029-777</span></div>
                </div>


            </div>
       
          </div>
        </div>
           <div class="dingdan4_4_tanchuang_btn">
      <div class="dingdan4_4_btn01" style="background:#ccc;margin-left: 339px;"><a href="javascript:cancel()">取消</a></div>
      <div class="dingdan4_4_btn02"><a href="javascript:barter_sure();" id='tijiao'>确认</a></div>
      <input type="hidden" value="1" id="unbarter"><!-- 防止多次提交 -->
    </div>
      </div>
    </div>

<!--<script src="js/jquery.min.js"></script>-->
<script>
    $pages = $(".pages").children().children("a");
    $pages.mouseover(function(){
       $(this).children().css("background","#ffedd9");
    }).mouseout(function(){
       $(this).children().css("background","#fff");
    })
    $link = $(".footer_link").children("ul").children();
    $link.mouseover(function(){
       $data = $(this).children().html();
        $(this).children().html("<u>"+$data+"</ul>");
    }).mouseout(function(){
         $(this).children().html($data);
    })
</script>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>

<!-- 鼠标触摸发布需求 -->
<script>
$(function () {
    var navLi=$(".needs_list_publish_tu .needs_list01");
    navLi.mouseover(function () {
        $(this).find(".needs_list_button").css("display","block"); 
        $(this).find(".needs_list_text").css("margin-top","35px")
    })
    navLi.mouseleave(function(){
        $(this).find(".needs_list_button").css("display","none");  
        $(this).find(".needs_list_text").css("margin-top","63px;")
    })
})
</script>

<script type="text/javascript">
    // 需求列表 tab切换
    $(".needs_list_header_left a").on("click", function() {
        var index = $(this).index();
        $(this).addClass("header_left_active").siblings().removeClass("header_left_active");
    })

    // 页数切换
      $(".needs_list_table_num a").on("click", function() {
        var index = $(this).index();
        $(this).addClass("needs_list_table_num_active").siblings().removeClass("needs_list_table_num_active");
    })
    $(".needs_list_main_header a").on("click", function() {
        var index = $(this).index();
        $(this).addClass("needs_list_main_active").siblings().removeClass("needs_list_main_active");
    })

</script>

<script type="text/javascript">
//下载附件
function download(){
	$("#download").submit();
}

//换货弹窗
function barter(id){
	url = 'member/demand/demand_detail/'+id;
	//判断登录
	$.post("<?php echo site_url('member/demand/check_login');?>",{url:url},function(data){
		if(data){
		    $("#dingdan4_3_tanchuang02").css("display","block");
			}else{
				window.location.href="<?php echo site_url('customer/login');?>";
				}
		});
    }

//添加换货信息
function barter_sure(){
	id = "<?php echo $detail['id']; ?>";
	remark = $("textarea[name=remark]").val();
	contactuser = $("input[name=contactuser]").val();
	
	url = 'member/demand/demand_detail/'+id;
	if($("#unbarter").val()=='1'){
		$("#unbarter").val(0);
    	$.post("<?php echo site_url('member/demand/check_login');?>",{url:url},function(data){
        	//判断登录
    	    if(data){
    			if(contactuser.search(/^1[34578]\d{9}$/)==-1){
    				if(contactuser.search(/^([0-9]{3,4}-)?[0-9]{7,8}$/)==-1){
    		        	alert('请输入正确的联系方式');
    		        	$("#unbarter").val(1);//防止多次提交
    		            return false;
    		            }
    		    }else{
        		    $.post("<?php echo site_url('member/demand/barter');?>",{remark:remark,contactuser:contactuser,requirement_id:id},function(data){
        		        alert(data);
        		        cancel();
        		        })
    		    }
    		}else{
    			window.location.href="<?php echo site_url('customer/login');?>";
    			}
    	}); 
	}
}
//取消
function cancel(){
	$("#unbarter").val(1);//防止多次提交
	$("#dingdan4_3_tanchuang02").hide();
}
</script>




