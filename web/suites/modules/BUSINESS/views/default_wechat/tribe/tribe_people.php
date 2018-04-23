<style type="text/css">
    body {font-family: . PingFang-SC-Light;}
    .container {background: #f6f6f6;}
    .recommend {margin-bottom: 0;padding-bottom: 0;}
    .page {padding-bottom: 0;}
    .search-header {background-color: #1A1A1A;height: 50px;width: 100%;position: fixed;top: 0;left: 0;z-index: 999;}
    .essay_classify_main {margin: 0px;margin-top: -55px;margin-bottom: 60px;}
    .essay_active a {color: #fed602 !important;border-bottom: 1px solid #fed602;}
    .sousuo_text {position: absolute;right: 2%;color: #fff;font-size: 15px;top: 18px;}
    .tribe_span_bg01 {position: absolute;height: 100%;width: 90%;left: 5%;top: 0;background: rgba(0, 0, 0, 0.3);border-radius: 4px;}
    .tribe_span_bg02 {position: absolute;height: 100%;width: 90%;left: 5%;top: 0;background: rgba(0, 0, 0, 0.5);border-radius: 4px;}
    .tribe_people_head {background: #fff;border-bottom: 1px solid #ddd;position: relative;}
    /*.tribe_people_my {background: none;}*/
    .zhankai_icon {float: right;font-size: 18px;transform: rotate(0deg);-wek-transform: rotate(0deg);}
    .display-block {display: none !important;}
    .span_rotate {transform: rotate(90deg);-wek-transform: rotate(90deg);}
    .tribe_people_guarantee {border-left: 1px solid #ddd;border-right: 1px solid #ddd;width: 25% !important;padding-top: 0;margin-top: 5px;}
    .tribe_people_my li {border-radius: 0;width: 45px;/*height: 50px;*/border-radius: 4px;}
    .tribe_people_name {padding-top: 0;margin-top: 5px;/*width:65% !important;*/ padding-left:10px;width: calc(100% - 133px) !important;}
    .tribe_people_dianpu {width: 10% !important;}
    .tribe_people_dianpu a {width: 25px;border: 1px solid #999;padding: 2px 5px;border-radius: 4px;float: right;margin-top: 5px;margin-right: -14px;}
    .tribe_people_img_ball {position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.3);border-radius: 4px;}
    .tribe_people_size {-webkit-line-clamp:inherit;}
    .tribe_people_size i{ display:inline-block;}
    .qiyemain{ display:inline-block; float:left;overflow: hidden;text-overflow: ellipsis; white-space: nowrap; max-width:65%;}
    .qiyemain_rig{display:inline-block; float:left;overflow: hidden;text-overflow: ellipsis; white-space: nowrap; max-width:35%;}
    .tribe_people_show li {display: none;}
    .tribe_people_show li:nth-child(1) {display: block;}
    .tribe_people_show li:nth-child(2) {display: block;}
    .tribe_people_show li:nth-child(3) {display: block;}
    .tribe_people_dianpu {display: block !important;}
    .tribe_yaoqing {color: #333;font-size: 13px;background: #FECF0A;padding: 6px 0;margin-top: 8px;}
    .tribe_people_my li img {width: 45px !important;height: 45px !important;}
    .send_ok_text {position: absolute;color: #ff0000;left: 1px;width: 100%;top: 40px;}
    .blur {
        filter: url(blur.svg#blur); /* FireFox, Chrome, Opera */
        -webkit-filter: blur(1px); /* Chrome, Opera */
        -moz-filter: blur(1px);
        -ms-filter: blur(1px);
        filter: blur(1px);
        filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=10, MakeShadow=false); /* IE6~IE9 */
    }
    .tribe_yaoqing {top: 0px;}
    .biaoshi1 {font-size: 12px;color: #55acc9;border: 1px solid #55acc9;border-radius: 5px;padding: 2px;margin-left: 2px; box-sizing:border-box}
    .biaoshi2 {font-size: 12px;color: #ffca00;border: 1px solid #ffca00;border-radius: 5px;padding: 2px;margin-left: 2px;}
    .tribe_people_list{ background:#fff}
    .fn-16 .dn_io{ display:inline-block; float:left;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;max-width:50%; margin-top:1px;}
    .tribe_people_credit{ width:88px !important; float:right !important;}
    .tribe_zuyuan{ padding-left:0}
    .tribe_people_my li span{ width:100%; float:left}
    .cart_num1 {position: absolute;right: 20%;top: 5px;width: auto;min-width: 14px;}
    .tribe_shop_footer ul li {width: 20%;}
</style>

<!-- 部落搜索 -->
<div class="search-header">
    <a href="javascript:history.back()" target="_self" class="icon-right"
       style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
    <!-- 搜索框 -->
    <form action="<?php echo site_url('Tribe/Members_List/' . $tribe_id) ?>" method="get">
        <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
            <p style="background-color: #fff;width:70%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;">
                <a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
                <input type="text" class="search_input" name="search_index"
                       value="<?php echo !empty($_GET['search_index']) ? $_GET['search_index'] : '' ?>"
                       placeholder="搜索会员" required=""
                       style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;">
                <!-- <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a> -->
            </p>
            <!--  <span class="sousuo_text"><a href="<?php //echo site_url('Tribe/Members_List/'.$tribe_id);?>">取消</a></span> -->
            
            <?php 
            if(!empty($label_id) && $label_id == 1 || !empty($label_id) && $label_id == 2){
                
            }else{?>
                <a href="<?php echo site_url('Tribe/Tribe_Ranking/' . $tribe_id); ?>"><span class="sousuo_text"
                                                                                        style="text-align: center;font-size: 12px;top:13px;"><span
                        class="icon-ranking_list_off" style="display: block;font-size: 14px;"></span>排行榜</span></a>
            <?php }?>
            
        </div>
    </form>
</div>
<div style="height:50px;"></div>
<!-- 内容开始 -->

<div class="tribe_people">
    <?php if (empty($_GET['search_index'])): ?>
        <!-- 我 -->
        <p class="tribe_people_head">我的 <a href="<?php echo  site_url("Tribe/manageTribe/{$tribe_id}");?>" class="tuichu_icon"><em class="icon-guanli"></em></a></p>
        <ul class="tribe_people_show">
            <li style=" margin-bottom:8px;">
                <ul class="tribe_people_my">
                    <li>
                        <a href="<?php echo $my_info['customer_id'] ? site_url("tribe_info/my?tribe_id=$tribe_id") : 'javascript:;';//echo site_url('Tribe/Members_Info/'.$tribe_id.'/'.$val['id']);?>">
                         
                                <img   src="<?php echo $my_info['brief_avatar'] ? IMAGE_URL . $my_info['brief_avatar'] : $my_info['wechat_avatar']; ?>"
                                    alt="" onerror="this.src='images/member_defult.png'">

                        </a>

                        <?php if (!empty($my_info['corp_id']) && $my_info['approval_status'] == 2 && $my_info['corp_status'] == 1) : ?>
                            <i class="icon-enterprise enterprise-icon"></i>
                        <?php endif; ?>

                    </li>

                    <a href="<?php echo $my_info['customer_id'] ? site_url("tribe_info/my?tribe_id=$tribe_id") : 'javascript:;';//echo site_url('Tribe/Members_Info/'.$tribe_id.'/'.$val['id']);?>">
                        <li class="tribe_people_name" style="word-wrap:break-word">
                            <span class="fn-16"><i class="dn_io"><?php echo !empty($my_info['real_name']) ? $my_info['real_name'] : $my_info['member_name']; ?></i>
                                <?php if($my_info['is_host'] == 1):?>
                                    <em class="biaoshi1"><i class="icon-shenfen"></i><?php echo '部落首领 '; ?></em>
                                <?php else:?>
                                    <?php if(isset($my_info['m_name'])):?>
                                        <em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i><?php echo  $my_info['m_name']; ?></em>
                                    <?php endif;?>
                                <?php endif;?>
                                 
                            </span>

                            <span class="tribe_people_size1 tribe_zuyuan"
                                  style='padding-top: 8px;'><?php //echo $my_info['role_name']?> <i class="qiyemain"><?php echo $my_info['corporation_name'] ?></i><i class="qiyemain_rig"><?php echo !empty($my_info['duties']) ? ',' . $my_info['duties'] : '' ?></i></span>
                        </li>

                        <li class="tribe_people_credit">
                            <a href="<?php echo site_url('Tribe_social/invite/' . $my_info['tribe_id']); ?>"><i
                                    class="tribe_yaoqing custom_button">邀请好友</i></a>
                        </li>
                    </a>
                </ul>

                <div class="tribe_people_list">
                    <a href="<?php echo site_url("Tribe_social/Customer_Album") . '/' . $my_info['customer_id'].'/'.$tribe_id; ?>">个人形象</a>
                    <a href="<?php echo site_url("Corporation_style/User_Topic/{$my_info['customer_id']}"); ?>">企业形象</a>
                    <a href="<?php echo !empty($my_info['corp_id']) ? site_url('home/GetShopGoods/' . $my_info['corp_id']) : 'javascript:message(2)'; ?>">我的店铺</a>
                </div>
            </li>
        </ul>

    <?php endif; ?>
    <?php if (!empty($list)) { ?>
        <?php foreach ($list as $k => $v) { ?>
            <!-- 义工委 -->
            <div>
                <p class="tribe_people_head"><?php echo $v['role_name'] ?>
                    (<?php echo !empty($v['total']) ? $v['total'] : 0 ?>)
                    <span
                        class="icon-right zhankai_icon <?php echo ($v['id'] == 5 || $v['id'] == '') ? 'span_rotate' : '' ?>"></span>
                </p>
                <ul class="tribe_people_show role_id_<?php echo $v['id'] ?>">
                    <?php foreach ($v['list'] as $val) { ?>
                        <li>
                            <ul class="tribe_people_my">

                                <!-- <span class="tribe_span_bg02"></span> -->

                                <?php if (!empty($val['corp_id']) && $val['approval_status'] == 2 && $val['corp_status'] == 1) : ?>
                                    <i class="icon-enterprise enterprise-icon" style="left: 10px;z-index: 9;top: 5px;"></i>

                                <?php endif; ?>
                                </li>

                                <a href="<?php echo $val['customer_id'] ? site_url('Tribe_social/Customer_Info/' . $val['customer_id'] . '?tribe_id=' . $val['tribe_id'] . '&ts_id=' . $val['id']) : site_url('Tribe_social/Staff_info/' . $val['id']); ?>">
                                    <li>
                                    <?php if(!empty($val['corp_id'] ) && $val['approval_status'] == 2 && $val['corp_status'] == 1 ){ ?>
                                             <img  src="<?php echo $val['brief_avatar'] ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'">
                                        <?php }else{ 
                                              ?>
                                             <em class="tribe_people_img_ball"></em>
                                             <img  src="<?php echo $val['brief_avatar'] ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'">
                                        <?php }?>

                                    <li class="tribe_people_name" style="word-wrap:break-word">
                                        <span
                                            <?php ?>
                                            class="fn-16"><i class="dn_io"><?php echo !empty($val['real_name']) ? $val['real_name'] : $val['member_name'] ?></i>
                                            <!-- 部落首领 -->
                                            <?php if($val['is_host'] == 1):?>
                                            
                                                <em class="biaoshi1"><i class="icon-shenfen"></i><?php echo '部落首领 '; ?></em>
                                            <?php else:?>
                                                <?php if(isset($val['m_name'])):?>
                                                <em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i><?php echo  $val['m_name'];?></em> 
                                                <?php endif;?>
                                                 
                                            <?php endif;?>
                                             
                                            <!-- 管理员 -->
                                             <!--  <?php if($val['tribe_manager_id'] != 0):?>
                                                 <em class="biaoshi2"><i class="icon-shenfen"></i>管理员</em> 
                                              <?php endif;?>
                                            -->
                                            </span>
                                        <span class="tribe_people_size1 tribe_zuyuan"
                                              style='padding-top: 8px;'><?php //echo $val['role_name']?><i class="qiyemain"><?php echo $val['corporation_name'] ?></i><i class="qiyemain_rig"><?php echo !empty($val['duties']) ? ',' . $val['duties'] : '' ?></i></span>
                                    </li>
                                    <!-- <li class="tribe_people_guarantee">
                           <a href="<?php echo 'javascript:;';//echo site_url('Tribe/My_Info/'.$tribe_id.'/'.$val['id'])?>">
                             <span class="fn-14"><?php echo $val['remain_guarantee_price'] / 10000 ?>提货权</span>
                             <span class="tribe_edu">可担保额</span>
                           </a>
                       </li> -->
                                    <!-- <li class="tribe_people_credit">
                           <span class="fn-14"><?php echo $val['credit'] / 10000 ?>提货权</span>
                           <span class="tribe_edu">获得授信</span>
                           <a href="javascript:void(0);">店铺</a>
                       </li> -->
                                    <li class="tribe_people_credit">
                                        <?php if (empty($val['customer_id'])) : ?>
                                            <?php if (!empty($_COOKIE['invite_wx_Customer_' . $val['id']]) && !empty($_COOKIE['invite_dx_Customer_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送邀请</em>
                                            <?php } else if (!empty($_COOKIE['invite_wx_Customer_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送微信邀请</em>
                                            <?php } elseif (!empty($_COOKIE['invite_dx_Customer_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送短信邀请</em>
                                            <?php } ?>

                                            <?php if (empty($_COOKIE['invite_wx_Customer_' . $val['id']]) || empty($_COOKIE['invite_dx_Customer_' . $val['id']])) { ?>
                                                <a href=" javascript:void(0);    <?php //echo site_url('Tribe/Invite_View/Customer/'.$tribe_id.'/'.$val['id'])?>"><i
                                                        class="tribe_yaoqing custom_button" flag='1'
                                                        ts_id='<?php echo $val['id'] ?>'>邀请回家</i></a>
                                            <?php } else { ?>
                                                <a href=" javascript:void(0);"><i class="tribe_yaoqing"
                                                                                  style="background-color: #ccc">邀请回家</i></a>
                                            <?php } ?>


                                        <?php elseif (empty($val['corp_id']) || $val['approval_status'] != 2 || $val['corp_status'] != 1) : ?>

                                            <?php if (!empty($_COOKIE['invite_wx_Corp_' . $val['id']]) && !empty($_COOKIE['invite_dx_Corp_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送邀请</em>
                                            <?php } elseif (!empty($_COOKIE['invite_wx_Corp_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送微信邀请</em>
                                            <?php } elseif (!empty($_COOKIE['invite_dx_Corp_' . $val['id']])) { ?>
                                                <em class="send_ok_text">已发送短信邀请</em>
                                            <?php } ?>

                                            <?php if (empty($_COOKIE['invite_wx_Corp_' . $val['id']]) || empty($_COOKIE['invite_dx_Corp_' . $val['id']])) { ?>
                                                <a href=" javascript:void(0);    <?php //echo site_url('Tribe/Invite_View/Corp/'.$tribe_id.'/'.$val['id'])?>"><i
                                                        class="tribe_yaoqing custom_button" flag='2'
                                                        ts_id='<?php echo $val['id'] ?>'>邀请·分享互助</i></a>
                                            <?php } else { ?>
                                                <a href=" javascript:void(0); "><i class="tribe_yaoqing"
                                                                                   style="background-color: #ccc">邀请·分享互助</i></a>
                                            <?php } ?>


                                        <?php elseif (!empty($val['corp_id']) && $val['approval_status'] == 2 && $val['corp_status'] == 1): ?>
                                            <a href="<?php echo site_url('home/GetShopGoods/' . $val['corp_id']); ?>"><i
                                                    class="tribe_yaoqing"
                                                    style="background: #b4d465!important;">串串门</i></a>
                                        <?php endif; ?>

                                    </li>
                                    <?php if (!empty($val['corp_id'])) { ?>
                                        <!--  <li class="tribe_people_dianpu">
                           <a href="<?php echo site_url('home/GetShopGoods/' . $val['corp_id']); ?>">店铺</a>
                       </li> -->
                                    <?php } ?>
                                </a>
                            </ul>
                            <div class="tribe_people_list">
                                <a href="<?php echo $val['customer_id'] ? site_url("Tribe_social/Customer_Album/{$val['customer_id']}/{$tribe_id}") : site_url("Tribe_social/staff_album").'/'.$val['id']; ?>">认识TA</a>
                                <a href="<?php echo $val['customer_id'] ? site_url("Corporation_style/User_Topic/{$val['customer_id']}") : 'javascript:message(3)'; ?>">了解TA的产品</a>
                                <?php if(!empty($val['customer_id']) && $val['customer_id'] == $this->session->userdata('user_id')){?>
                                     <a href="javascript:message(4)">聊两句</a>
                                <?php }else{ ?>
                                    <a href="<?php echo !empty($val['customer_id']) ? site_url("Webim/Control/chat/{$tribe_id}/{$val['customer_id']}") : 'javascript:message(3)'; ?>">聊两句</a>
                                <?php }?>
                                <!--  <a href="<?php // echo !empty($val['customer_id']) ? 'javascript:Is_Exists_Comment(' . $val['customer_id'] . ')' : 'javascript:message(3)'; ?>">聊两句</a>-->
                                
                            </div>

                        </li>

                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    <?php } ?>
</div>


<!-- 弹窗   -->
<div class="clans_ball">
    <div class="clans_ball_box">
        <ul>
            <li><a href="javascript:void(0);"><img src="images/duanxin.png" alt=""
                                                   style="height: 40px;width: 40px;"><span>短信邀请</span></a></li>
            <?php
            $mac_type = $this->session->userdata("mac_type");
            if (!$mac_type) {
                ?>
                <li><a href="javascript:void(0);"><img src="images/weixin.png" alt=""><span>微信好友</span></a></li>
            <?php } ?>

        </ul>
        <div class="clans_ball_box_btn"><span>取消</span></div>
    </div>
</div>
 <!-- 弹窗 -->

 <div class="tuichu_ball" hidden>
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="tuichu_ball_title"><span>提示</span></div>
         <div class="tuichu_ball_text"><span>是否退出部落？</span></div>
         <div class="tuichu_ball_button">
           <a href="javascript:cane(0);">取消</a>
           <a id = 'tuichu_sub' href="javascript:quit_sub(0);">确定</a>
         </div>      
      </div>
   </div>
 </div> 

<!-- 底部导航 -->
<div class="container-center tribe_shop_footer" >
    <ul>
                    
            <li class="footer-icon01"><a href="<?php echo site_url('Tribe/home/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-shouye_"></span>首页</a></li>
            <li class="footer-icon02"><a href="<?php echo site_url('Tribe/shop/'.$tribe_id.'/'.$label_id)?>" class=""><span class="icon-shangcheng_"></span>商城</a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Circles/index/'.$label_id.'?tribe_id='.$tribe_id)?>" class=""><span class="icon-quanzi_"></span>圈子</a></li>
            <li class="footer-icon03" style="position: relative;"><a href="<?php echo site_url('Webim/Control/chatList/'.$tribe_id)?>" class=""><span class="icon-xiaoxi2"></span>消息<em class="cart_num1" id ='huanxin_chatNum' hidden>0</em></a></li>
            <li class="footer-icon03"><a href="<?php echo site_url('Tribe/Members_List/'.$tribe_id.'/'.$label_id)?>" class="cf tribe_shop_footer_active"><span class="icon-zuyuan_ cf tribe_shop_footer_active"></span>族员</a></li>
    </ul>
</div>

<?php 
$user_id = $this->session->userdata("user_id");
if($user_id){?>
<script>
$.ajax({
    url:'<?php echo site_url("Webim/Control/getNotReadCount/{$tribe_id}")?>',
    type:'post',
    dataType:'json',
    data:{},
    success:function(data)
    {
      console.log("获取未读消息成功");
      var MsgCount = data.MsgCount;
      if(MsgCount > 0){
        if(MsgCount >= 99){
            MsgCount = '99+';   
        }
        $("#huanxin_chatNum").html(MsgCount);
        $("#huanxin_chatNum").show();
      }
        
    },
    error:function()
    {
        console.log("获取未读消息失败");
    }
})
</script>
<?php }?>
<script type="text/javascript">
    $('.tribe_yaoqing').on('click', function () {

        var type = $(this).attr('flag');
        var ts_id = $(this).attr('ts_id');
        if (!type) {
            return;
        }

        $('.clans_ball').show();
        $('.clans_ball_box ul li').eq(0).show();
        $('.clans_ball_box ul li').eq(1).show();
        if (type == 1) {
            type = 'Customer';
            var url = '<?php echo site_url('Tribe/Invite_View/Customer/' . $tribe_id)?>/' + ts_id;
        } else {
            type = 'Corp';
            var url = '<?php echo site_url('Tribe/Invite_View/Corp/' . $tribe_id)?>/' + ts_id;
        }
        $('.clans_ball_box ul li').eq(0).children('a').attr('id', "sendID" + ts_id);
        $('.clans_ball_box ul li').eq(0).children('a').attr('href', "javascript:ajax_submit('" + type + "'," + ts_id + ");");
        $('.clans_ball_box ul li').eq(1).children('a').attr('href', url + '/1');
        var dx_status = getCookie(ts_id, 'dx');
        var wx_status = getCookie(ts_id, 'wx');
        if (dx_status) {
            $('.clans_ball_box ul li').eq(0).hide();
        }
        if (wx_status) {
            $('.clans_ball_box ul li').eq(1).hide();
        }
    })

    $('.clans_ball').on('click', function () {
        $('.clans_ball').hide()
    })
    
    
    function caution() {
        $(".black_feds").text("3天内不可重复邀请").show();
        setTimeout("prompt();", 2000);
    }

    function getCookie(ts_id, type) {
        var Customer = false;
        var Corp = false;
        var Cookie_Customer = 'invite_' + type + '_Customer_' + ts_id;
        var arr, reg = new RegExp("(^| )" + Cookie_Customer + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg)) {
            Customer = true;
        }
        var Cookie_Corp = 'invite_' + type + '_Corp_' + ts_id;
        var Carr, Creg = new RegExp("(^| )" + Cookie_Corp + "=([^;]*)(;|$)");
        if (Carr = document.cookie.match(Creg)) {
            Corp = true;
        }
        if (Corp || Customer) {
            return true;
        }
    }

    function ajax_submit(flag, ts_id) {
        var type = flag;
        var tribe_id = '<?php echo $tribe_id?>';
        var tribe_staff = ts_id;

        if (type && tribe_id && tribe_staff) {
            $.ajax({
                url: '<?php echo site_url('Tribe/Invite')?>',
                type: 'post',
                dataType: 'json',
                data: {'type': type, 'tribe_id': tribe_id, 'tribe_staff': tribe_staff},
                beforeSend: function () {
                    $(".black_feds").text("短信发送中....").show();
//                  document.getElementById('sub').style.background='#ccc';
//                  document.getElementById('sub').text='短信发送中....';
                    $('.clans_ball_box ul li').eq(0).children('a').attr('href', "");
                },
                success: function (data) {

                    $(".black_feds").text(data.message).show();
                    setTimeout("prompt();", 2000);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2200);

                },
                error: function () {
                    $(".black_feds").text("发送失败,请稍后再试").show();
                    setTimeout("prompt();", 2000);
                    $('.clans_ball_box ul li').eq(0).children('a').attr('href', "javascript:ajax_submit('" + type + "'," + tribe_staff + ");");
                    return;
                }
            })
        } else {

            $(".black_feds").text("参数错误").show();
            setTimeout("prompt();", 2000);
            return false;
        }
    }
</script>


<script type="text/javascript">
    // 点击头部导航
    $(".essay_preview_nav ul li").on("click", function () {
        $(this).addClass('essay_active').siblings().removeClass('essay_active');
    })


    //族员的全部显示。
    $('.role_id_5 li').show();
    $('.role_id_0 li').show();


    $(".tribe_people_head").on("click", function () {
        // $(this).siblings('ul').toggleClass('display-block');
        $(this).children('span').toggleClass('span_rotate');

        if ($(this).children('span').hasClass('span_rotate')) {
            $(this).siblings('.tribe_people_show').children('li:gt(2)').show();
        } else {
            $(this).siblings('.tribe_people_show').children('li:gt(2)').hide();
        }


    })

    function message(status) {
        var message = '此功能正在测试，敬请期待';

        if (status == 1) {
            message = '该族员未登录，暂时不能对他评价';

        } else if (status == 2) {
            message = '您还没有开店，请联系客服协助 400-0029-777';
        } else if (status == 3) {
            message = '该族员未登录';
        } else if(status == 4){
            message = '不能和自己聊天';
            }

        $(".black_feds").text(message).show();
        setTimeout("prompt();", 2000);
    }

    function Is_Exists_Comment(customer_id) {
        $.post("<?php echo site_url('Tribe_social/Is_Exists_Comment')?>", {"to_customer_id": customer_id},
            function (data, status) {
                if (data.status) {
                    window.location.href = '<?php echo site_url('Tribe_social/comment')?>/' + customer_id
                } else {
                    message(4);
                }

            },
            "json");
    }

    $(function () {
        var isPageHide = false;
        window.addEventListener('pageshow', function () {
            if (isPageHide) {
                window.location.reload();
            }
        });
        window.addEventListener('pagehide', function () {
            isPageHide = true;
        });
    });

        // 秦商会
<?php if($label_id == 2){ ?>
   function  change_color(){
      $('.tribe_yaoqing').css('color', '#fff'); 
   }
   change_color();
<?php }?>

</script>

</div>
