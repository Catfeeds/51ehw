<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="css/reset.css" rel="stylesheet" type="text/css"> 注释-->
<link href="css/theme/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/theme/style.css" rel="stylesheet" type="text/css">
<link href="css/theme/style_v2.css" rel="stylesheet" type="text/css">
<title>51易货网</title>
</head>

<body>


    <div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
                <!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
                <li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
                <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>订单中心 </a></li>
                <li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
                <li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
                <li class="kehu_current"><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户中心</a></li>
                <li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
                <!--<li><a href="javascript:;">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
            	<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
                <!--<li><a href="javascript:;">在线客服</a></li>-->
                <!--<li><a href="<?php echo site_url('member/mmember/return_repair')?>">返修退换货</a></li>-->
            </ul>
            <ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
        </div>

		<div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">我的评价</div>
        	<?php if($status === "one_comment"):?>
            <div class="huankuan_rCon01"></div>
            <?php else:?>
            <div class="huankuan_rCon01">
            	<ul>
                	<li <?php if(!$status) echo 'class="huankuan_rCon01_current"'?>><a href="<?php echo site_url('member/my_comment/get_list')?>">全部（<?php echo isset($all_comment_num)?$all_comment_num:''?>）</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php if($status == 'already') echo 'class="huankuan_rCon01_current"'?>><a href="<?php echo site_url('member/my_comment/get_list/already')?>">已评价（<?php echo isset($yes_comment_num)?$yes_comment_num:''?>）</a></li>
                    <li class="huankuan_line"></li>
                    <li <?php if($status == 'not') echo 'class="huankuan_rCon01_current"'?>><a href="<?php echo site_url('member/my_comment/get_list/not')?>">未评价（<?php echo isset($no_comment_num)?$no_comment_num:''?>）</a></li>
                </ul>
            </div>
            <?php endif;?>
            
            <!--内容-->
            
		  <div class="dingdanzhongxin_pingjia_con">
          	 <?php if(count($list) > 0):?>
          	     <?php foreach ($list as $k => $v):?>
              		 <div class="dingdanzhongxin_pingjia_con01">
                        <div class="dingdanzhongxin_pingjia_con01_top">
                            <ul>
                                <li>商品信息</li>
                                <li style="border-right:0; width:158px">操作 </li>
                            </ul>
                        </div>
                        <!---->
                        <div class="dingdanzhongxin_pingjia_con01_down" id="<?php echo 'comment_'.$k?>">
                            <ul>
                                <li class="dingdanzhongxin_pingjia_con01_down_li">
                                <samp>
                                <img src="<?php echo IMAGE_URL.$v['goods_thumb']?>" width="67" alt=""/>
                                </samp>
                                <span><?php echo $v['name'];?></span>
                                <span style="color:#aaa">购买时间：<?php echo $v['place_at']?></span>
                                </li>
                                <?php if(!$v['comments_id']):?>    
                                    <li class = 'ok_on' style="border-right:0; padding:0; height:100px; line-height:100px; width:158px"><a class="comment_btn" onclick="comment('<?php echo $k;?>','<?php echo $v['id']?>')">点击评价</a></li>
                                <?php else :?>
                                    <li class = 'ok_on' style="border-right:0;padding:0; height:100px; line-height:100px; width:158px">已评价</li>
                                <?php endif;?>
                            </ul>
                        </div>
                     </div>
                 <?php endforeach;?>
              <?php else:?>
                    <center style="color:#eb5252; border:1px solid #ccc; padding:20px 0; font-size:14px;">暂无评论记录</center>
              <?php endif;?>
            
              <!--点击点击评价出现下面评价框内容
              <div class="dingdanzhongxin_pingjia_fabiao clearfix " style="display:block">
                <div class="dingdanzhongxin_pingjia_fabiao01 clearfix">
                    <div class="fabiao01_left"><span>*</span>评价 ：</div>
                    <ul>
                        <li><a href="#"><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a></li>
                        <li><a href="#"><img src="images/pingjia_star01.png" width="21" height="21" alt=""/></a></li>
                        <li><a href="#"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>
                        <li><a href="#"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>
                        <li><a href="#"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>
                    </ul>
                </div>
                
                <div class="dingdanzhongxin_pingjia_fabiao01 clearfix">
                    <div class="fabiao01_left"><span>*</span>心得 ：</div>
                    <textarea cols="10" rows="10" class="fabiao01_textarea"></textarea>
                </div>
                <div class="fabiao01_btn"><a href="#">发表评论</a></div>
                <div class="fabiao_niming"><label><input type="checkbox" class="fabiao01_input" value="" >匿名</label></div>
              </div>
              -->
            </div>
            <!--评价框内容结束-->
            <!--分页内容-->
            <?php if($status === "one_comment"):?>
            
            <?php else:?>
            <div class="pingjia_jilu" style="margin-left:30px">
                    	<p>显示 <?php if(count($list) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
            </div>
                    <div class="pingjia_showpage">
                    	<?php echo $page;?>
                    	<!--  
                    	<a href="#" class="lPage">上一页</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a class="cpage">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <span>…</span>
                        <a href="#" class="lPage">下一页</a>
                        -->
                    </div>
            <?php endif;?>
            
      </div>

   </div>



    </div>
    <script>
    function comment(k,id)
    {
 	    $('.dingdanzhongxin_pingjia_fabiao').remove();
    	html = '<div class="dingdanzhongxin_pingjia_fabiao clearfix " style="display:block">'
        html += '<div class="dingdanzhongxin_pingjia_fabiao01 clearfix">'
        html += '<div class="fabiao01_left"><span>*</span>评价 ：</div>'
        html += '<ul id = "a">'
        	html += '<li><a id="mark1"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>'
            html += '<input type="hidden" name="mark" value="">'
        	html += '<li><a id="mark2"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>'
        	html += '<li><a id="mark3"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>'
        	html += '<li><a id="mark4"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>'
        	html += '<li><a id="mark5"><img src="images/pingjia_star02.png" width="21" height="21" alt=""/></a></li>'
            html += '</ul>'
        html += '</div>'
        html += '<div id="v_mark" style="overflow: hidden;">'
    	html += '<span style="float:left;margin-left:79px; margin-top:10px;color:red;"></span>'
        html += '</div>'
    	html += '<div class="dingdanzhongxin_pingjia_fabiao01 clearfix">'
    	html += '<div class="fabiao01_left"><span>*</span>心得 ：</div>'
    	html += '<textarea cols="10" rows="10" class="fabiao01_textarea"></textarea>'
    	html += '</div>'
		html += '<div id="v_commect">'
    	html += '<span style="float:left;margin-left:79px; margin-top:10px;color:red;"></span>'
        html += '</div>'
        html +='</br></br>'
        html += '<div class="fabiao01_btn"><a>发表评论</a></div>'
//     	html += '<div class="fabiao_niming"><label><input type="checkbox" class="fabiao01_input" value="" >匿名</label></div>'
    	html += '</div>'
       $('#comment_'+k).after(html);
       //html.insertAfter($('#comment_1'));

        $('.fabiao01_btn').click(function(){ 
            var mark = $('input[type=hidden][name=mark]').val();
            var comment = $('.fabiao01_textarea').val();
            if( mark ==''){ 
                $('#v_mark span').text('请选择评价星级');
            }else if( comment ==''){ 
                $('#v_mark span').text('');
            	$('#v_commect span').text('请输入评价内容');
            }else{
                $(this).text('发表中...');
                $(this).css('color','#FFFFFF');
                $(this).unbind( "click" );
            
                var orderitem_id = id;
                var url = "<?php echo site_url('member/my_comment/increase_comment')?>"
                var user_id = "<?php echo $this->session->userdata['user_id'];?>"
                    $.ajax({ 
                	    url:url,
                	    type:'post',
                	    data:{id:id,comment:comment,mark:mark, user_id:user_id },
                	    dataType:'json',
                	    success:function (data){
                	    	  if(data){ 
              	    		    
                	    		  $('.dingdanzhongxin_pingjia_fabiao').remove();
                	    		  window.location.reload();
                  	    		 // $('#comment_'+k+' ul').children(".ok_on").text('已评价');
                        	  }
                	    	  
                    	    },
                	    error:function(){alert('操作失败')}
                    })
                }
            })
            
        $('#mark1').click(function(){ 
            $('input[type=hidden][name=mark]').val(1);
            $('#mark1 img').attr('src','images/pingjia_star01.png');
            $('#mark2 img').attr('src','images/pingjia_star02.png');
            $('#mark3 img').attr('src','images/pingjia_star02.png');
            $('#mark4 img').attr('src','images/pingjia_star02.png');
            $('#mark5 img').attr('src','images/pingjia_star02.png');
            })
        $('#mark2').click(function(){ 
            $('input[type=hidden][name=mark]').val(2);
            $('#mark1 img').attr('src','images/pingjia_star01.png');
            $('#mark2 img').attr('src','images/pingjia_star01.png');
            $('#mark3 img').attr('src','images/pingjia_star02.png');
            $('#mark4 img').attr('src','images/pingjia_star02.png');
            $('#mark5 img').attr('src','images/pingjia_star02.png');
            })
         $('#mark3').click(function(){ 
            $('input[type=hidden][name=mark]').val(3);
            $('#mark1 img').attr('src','images/pingjia_star01.png');
            $('#mark2 img').attr('src','images/pingjia_star01.png');
            $('#mark3 img').attr('src','images/pingjia_star01.png');
            $('#mark4 img').attr('src','images/pingjia_star02.png');
            $('#mark5 img').attr('src','images/pingjia_star02.png');
            })
          $('#mark4').click(function(){ 
            $('input[type=hidden][name=mark]').val(4);
            $('#mark1 img').attr('src','images/pingjia_star01.png');
            $('#mark2 img').attr('src','images/pingjia_star01.png');
            $('#mark3 img').attr('src','images/pingjia_star01.png');
            $('#mark4 img').attr('src','images/pingjia_star01.png');
            $('#mark5 img').attr('src','images/pingjia_star02.png');
            })
          $('#mark5').click(function(){ 
            $('input[type=hidden][name=mark]').val(5);
            $('#mark1 img').attr('src','images/pingjia_star01.png');
            $('#mark2 img').attr('src','images/pingjia_star01.png');
            $('#mark3 img').attr('src','images/pingjia_star01.png');
            $('#mark4 img').attr('src','images/pingjia_star01.png');
            $('#mark5 img').attr('src','images/pingjia_star01.png');
            })
    }
    
    </script>
</body>
</html>
