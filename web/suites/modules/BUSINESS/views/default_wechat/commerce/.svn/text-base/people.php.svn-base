<style type="text/css">
  body {font-family:.PingFang-SC-Light;}
  .container {background:#fff;}
  .recommend {margin-bottom: 0;padding-bottom: 0;}
  .page {padding-bottom: 0;}
  .search-header {background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;z-index: 999;}
  .essay_classify_main {margin: 0px;margin-top: -55px;margin-bottom: 60px;}
  .essay_active a {color: #fed602!important;border-bottom: 1px solid #fed602;}
  .sousuo_text {position: absolute;right: 2%;color: #fff;font-size: 15px;top: 18px;}
  .tribe_span_bg01 {position: absolute;height: 100%;width: 90%;left: 5%;top: 0;background: rgba(0,0,0,0.3);border-radius: 4px;}
  .tribe_span_bg02 {position: absolute;height: 100%;width: 90%;left: 5%;top: 0;background: rgba(0,0,0,0.5);border-radius: 4px;}
  .tribe_people_head {background: #e7e7e7;border-bottom: 1px solid #ddd;}
  /*.tribe_people_my {background: none;}*/
  .zhankai_icon {float: right;font-size: 18px;transform: rotate(0deg);-wek-transform: rotate(0deg);}
  .display-block {display: none!important;}
  .span_rotate {transform: rotate(90deg);-wek-transform: rotate(90deg);}
  .tribe_people_guarantee {border-left: 1px solid #ddd;border-right: 1px solid #ddd;width: 25%!important;padding-top: 0;margin-top: 5px;}
  .tribe_people_my li {border-radius:0;}
  .tribe_people_name {padding-top: 0;margin-top: 5px;margin-right: 10px;width: 50%!important;}
  .tribe_people_dianpu {width: 10%!important;}
  .tribe_people_dianpu a {width: 25px;border: 1px solid #999;padding: 2px 5px;border-radius: 4px;float: right;margin-top: 5px;margin-right: -14px;}
  .tribe_people_size {-webkit-line-clamp: 1;}
  .tribe_people_show li {display: none;}
  .tribe_people_show li:nth-child(1) {display: block;}
  .tribe_people_show li:nth-child(2) {display: block;}
  .tribe_people_show li:nth-child(3) {display: block;}
  .tribe_people_dianpu {display: block!important;}
  .tribe_yaoqing  {color: #333;font-size: 15px;background: #FECF0A;padding: 6px 0;margin-top: 8px;width: 120%;left: -10px;}
  .tribe_people_my li img {width: 50px!important;height: 50px!important;}
  .send_ok_text { position: absolute;left: -72px;top: 18px;color: #ff0000;}
  .prominent_commerce_box {border-top:none;}
  .prominent_commerce_box ul li {border-bottom: none;margin-bottom: 0;}
  .prominent_commerce_box li a i {width: 70px;height: 70px;margin-top: 5px;margin-left: 10px;}
  .biaoshi1 {font-size: 12px;color: #55acc9;border: 1px solid #55acc9;border-radius: 5px;padding: 2px;margin-left: 2px;}
  .biaoshi2 {font-size: 12px;color: #ffca00;border: 1px solid #ffca00;border-radius: 5px;padding: 2px;margin-left: 2px;}
</style>


<!--  <div style="height:50px;"></div>-->



<?php if( $tribe_list ){?>

<!-- 图片 -->
<?php if( count( $tribe_list) > 1 ) {?>
<div class="commerce_people_head01">
  <ul> 
      <?php foreach ( $tribe_list as $v ){?>
      <li>
       <!--<a href="<?php echo site_url('Commerce/People/'.$label_id.'/'.$v['id'])?>">-->
      <a href ="javascript:change_tribe(<?php echo $v['id'];?>);">
      <img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></a>
      </li>
      <?php }?>
  </ul>
</div>
<?php }else{?>

<div class="recommended_tribe prominent_commerce_box">
    <ul class="recommended_tribe_top" id="commerce_choice_input">
        <?php foreach ( $tribe_list as $v ){?>
        <li>
                <a href="<?php echo site_url('Commerce/People/'.$label_id.'/'.$v['id'])?>"> 
                <i><img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></i> 
                <div class="recommended_tribe_rigth">
                <div class="tribal_index_zhiding"><h2><?php echo $v['name']?></h2></div>
                <div class="tribe_tuijian_box">
                <p><?php echo $v['content']?></p>
                </div>
                </div>
            </a>
        </li>
        <?php }?>
    </ul>
</div>
<?php }?>


<!-- 内容开始 -->
<div class="tribe_people">
  <!-- 我 -->
     <p class="tribe_people_head">我的</p>
     <ul class="tribe_people_show">
         <li>
          <ul class="tribe_people_my">
            <li><a href="<?php  echo  $my_info['customer_id'] ? site_url('Tribe_social/Customer_Info/'.$my_info['customer_id'].'?tribe_id='.$my_info['tribe_id'].'&ts_id='.$my_info['id']) : 'javascript:;';//echo site_url('Tribe/Members_Info/'.$tribe_id.'/'.$val['id']);?>"><img src="<?php echo $my_info['brief_avatar'] ? IMAGE_URL.$my_info['brief_avatar'] : $my_info['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'"></a>
            
              <?php if( !empty($my_info['corp_id']) && $my_info['approval_status'] == 2 && $my_info['corp_status'] == 1 ) :?>
                        <i class="icon-enterprise enterprise-icon"></i>
                    <?php endif;?>
            
            </li>
            
            <a href="<?php  echo  $my_info['customer_id'] ? site_url('Tribe_social/Customer_Info/'.$my_info['customer_id'].'?tribe_id='.$my_info['tribe_id'].'&ts_id='.$my_info['id']) : 'javascript:;';//echo site_url('Tribe/Members_Info/'.$tribe_id.'/'.$val['id']);?>">
                    <li class="tribe_people_name" style="word-wrap:break-word">
                       <span class="fn-16"><?php echo !empty($my_info['real_name']) ? $my_info['real_name'] : $my_info['member_name'];?>
                          <?php if($my_info['is_host'] == 1):?>
                                    <em class="biaoshi1"><i class="icon-shenfen"></i><?php echo '部落首领 '; ?></em>
                                <?php else:?>
                                    <?php if(isset($my_info['m_name'])):?>
                                        <em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i><?php echo  $my_info['m_name']; ?></em>
                                    <?php endif;?>
                                <?php endif;?>
                       </span>

                       <span class="tribe_people_size tribe_zuyuan" style='padding-top: 8px;'><i><?php //echo $my_info['role_name']?></i> <?php echo $my_info['corporation_name']?><?php echo !empty( $my_info['duties'] ) ? ','.$my_info['duties'] : ''?></span>
                    </li>
                  
                   <li class="tribe_people_credit">
                       <a href="<?php echo site_url('Tribe_social/invite/'.$my_info['tribe_id']);?>"><i class="tribe_yaoqing custom_button">邀请好友</i></a>
                   </li>
               </a>
          </ul> 
          
          <div class="tribe_people_list">
            <a href="<?php echo site_url("Tribe_social/Customer_Album").'/'.$my_info['customer_id'].'/'.$tribe_id;?>">个人形象</a>
            <a href="<?php echo site_url("Corporation_style/User_Topic/{$my_info['customer_id']}");?>">企业形象</a>
            <a href="<?php echo !empty( $my_info['corp_id'] ) ? site_url('home/GetShopGoods/'.$my_info['corp_id']) : 'javascript:message(5)';?>">我的店铺</a>
          </div>
         </li>
     </ul> 
    
     <?php if( !empty($list) ){?>
         <?php foreach ($list as $k => $v){?>
         <!-- 义工委 -->
         <div>
           <p class="tribe_people_head"><?php echo $v['role_name']?> (<?php echo !empty($v['total']) ? $v['total'] : 0 ?>)
               <span class="icon-right zhankai_icon <?php  echo ( $v['id'] == 5  || $v['id'] == '' )? 'span_rotate' : ''?>"></span>
           </p>
           <ul class="tribe_people_show role_id_<?php echo $v['id']?>">
           <?php foreach ($v['list'] as $val){?>
               <li>
                   <ul class="tribe_people_my">
                       

                       
                       <!-- <span class="tribe_span_bg02"></span> -->
                       
                       <?php if( !empty($val['corp_id'] ) && $val['approval_status'] == 2 && $val['corp_status'] == 1 ) :?>
                           <i class="icon-enterprise enterprise-icon"></i>
                       <?php endif;?>
                       </li>
                       
                       <a href="<?php  echo  $val['customer_id'] ? site_url('Tribe_social/Customer_Info/'.$val['customer_id'].'?tribe_id='.$val['tribe_id'].'&ts_id='.$val['id']) : site_url('Tribe_social/Staff_info/'.$val['id']);?>">
                       <li><img src="<?php echo $val['brief_avatar'] ? IMAGE_URL.$val['brief_avatar'] : $val['wechat_avatar'];?>" alt="" onerror="this.src='images/member_defult.png'">
                       <li class="tribe_people_name" style="word-wrap:break-word">
                           <span class="fn-16"><?php echo !empty( $val['real_name'] ) ? $val['real_name'] : $val['member_name']?>
        
                            <!-- 部落首领 -->
                            <?php if($val['is_host'] == 1):?>
                                <em class="biaoshi1"><i class="icon-shenfen"></i><?php echo '部落首领 '; ?></em>
                            <?php else:?>
                                <?php if(isset($val['m_name'])):?>
                                <em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i><?php echo  $val['m_name'];?></em> 
                                <?php endif;?>
                                 
                            <?php endif;?>
                           </span>
                           <span class="tribe_people_size tribe_zuyuan" style='padding-top: 8px;'><i><?php //echo $val['role_name']?></i> <?php echo $val['corporation_name']?><?php echo !empty( $val['duties'] ) ? ','.$val['duties'] : ''?></span>
                       </li>
                       <!-- <li class="tribe_people_guarantee">
                           <a href="<?php echo 'javascript:;';//echo site_url('Tribe/My_Info/'.$tribe_id.'/'.$val['id'])?>">
                             <span class="fn-14"><?php echo $val['remain_guarantee_price'] / 10000 ?>万货豆</span>
                             <span class="tribe_edu">可担保额</span>
                           </a>
                       </li> -->
                       <!-- <li class="tribe_people_credit">
                           <span class="fn-14"><?php echo $val['credit'] / 10000 ?>万货豆</span>
                           <span class="tribe_edu">获得授信</span>
                           <a href="javascript:void(0);">店铺</a>
                       </li> -->
                       <li class="tribe_people_credit">
                       <?php if( empty($val['customer_id']) ) :?>
                           <?php if( !empty( $_COOKIE['invite_wx_Customer_'.$val['id']] ) && !empty( $_COOKIE['invite_dx_Customer_'.$val['id']] ) ){?>
                               <em class="send_ok_text">已发送邀请</em>
                           <?php }else if(!empty( $_COOKIE['invite_wx_Customer_'.$val['id']] )){?>
                               <em class="send_ok_text" style="left: -96px;">已发送微信邀请</em>
                           <?php }elseif(!empty( $_COOKIE['invite_dx_Customer_'.$val['id']] )){ ?>
                                 <em class="send_ok_text" style="left: -96px;">已发送短信邀请</em>
                           <?php }?>
                           
                           <?php if( empty( $_COOKIE['invite_wx_Customer_'.$val['id']] ) || empty( $_COOKIE['invite_dx_Customer_'.$val['id']] ) ){ ?>
                               <a href=" javascript:void(0);    <?php //echo site_url('Tribe/Invite_View/Customer/'.$tribe_id.'/'.$val['id'])?>"><i class="tribe_yaoqing custom_button" flag='1' ts_id='<?php echo $val['id']?>'>邀请回家</i></a>
                           <?php }else{?>
                               <a href=" javascript:void(0);"><i class="tribe_yaoqing custom_button" style="background-color: #ccc">邀请回家</i></a>
                           <?php }?>
                           
                           
                       <?php elseif( empty($val['corp_id']) || $val['approval_status'] != 2 || $val['corp_status'] != 1 ) :?>
                       
                           <?php if( !empty( $_COOKIE['invite_wx_Corp_'.$val['id']] )  && !empty( $_COOKIE['invite_dx_Corp_'.$val['id']] ) ){?>
                               <em class="send_ok_text">已发送邀请</em>
                           <?php }elseif(!empty( $_COOKIE['invite_wx_Corp_'.$val['id']] ) ){ ?>
                               <em class="send_ok_text" style="left: -96px;">已发送微信邀请</em>
                           <?php }elseif(!empty( $_COOKIE['invite_dx_Corp_'.$val['id']] )){ ?>
                                <em class="send_ok_text" style="left: -96px;">已发送短信邀请</em>
                            <?php }?>
                           
                           <?php if( empty( $_COOKIE['invite_wx_Corp_'.$val['id']] ) || empty( $_COOKIE['invite_dx_Corp_'.$val['id']] ) ){ ?>
                               <a href=" javascript:void(0);    <?php //echo site_url('Tribe/Invite_View/Corp/'.$tribe_id.'/'.$val['id'])?>"><i class="tribe_yaoqing custom_button" flag='2' ts_id='<?php echo $val['id']?>'>邀请·分享互助</i></a>
                           <?php }else{  ?>
                               <a href=" javascript:void(0); "><i class="tribe_yaoqing custom_button" style="background-color: #ccc">邀请·分享互助</i></a>
                           <?php }?>
                           
                           
                       <?php elseif( !empty($val['corp_id']) && $val['approval_status'] == 2 && $val['corp_status'] == 1 ):?>
                             <a href="<?php echo site_url('home/GetShopGoods/'.$val['corp_id']);?>"><i class="tribe_yaoqing" style="background: #b4d465!important;">串串门</i></a>
                       <?php endif;?>
                        
                       </li>
                        <?php if (!empty($val['corp_id']) ) {?>
                       <!--  <li class="tribe_people_dianpu">
                           <a href="<?php echo site_url('home/GetShopGoods/'.$val['corp_id']);?>">店铺</a>
                       </li> -->
                       <?php }?>
                       </a>
                   </ul>
                   <div class="tribe_people_list">
                     <a href="<?php echo $val['customer_id'] ? site_url("Tribe_social/Customer_Album/{$val['customer_id']}/{$tribe_id}"):'javascript:message(2)';?>">认识TA</a>
                     <a href="<?php echo  $val['customer_id'] ? site_url("Corporation_style/User_Topic/{$val['customer_id']}"):'javascript:message(2)';?>">了解TA的产品</a>
                     <?php if(!empty($val['customer_id']) && $val['customer_id'] == $this->session->userdata('user_id')){?>
                         <a href="javascript:message(4)">聊两句</a>
                     <?php }else{ ?>
                        <a href="<?php echo !empty($val['customer_id']) ? site_url("Webim/Control/chat/{$tribe_id}/{$val['customer_id']}") : 'javascript:message(3)'; ?>">聊两句</a>
                     <?php }?>
                     
                     <!-- <a href="<?php // echo !empty($val['customer_id'] ) ?  'javascript:Is_Exists_Comment('.$val['customer_id'].')': 'javascript:message(1)';?>">聊两句</a> -->
                  </div>
               </li>
              
           <?php }?>
           </ul>
       </div>
        <?php }?>
    <?php }?>
</div>



<!-- 弹窗   -->
  <div class="clans_ball">
      <div class="clans_ball_box">
         <ul>
             <li><a href="javascript:void(0);"><img src="images/duanxin.png" alt="" style="height: 40px;width: 40px;"><span>短信邀请</span></a></li>
            <?php 
            $mac_type = $this->session->userdata("mac_type");
            if(!$mac_type){?>
                <li><a href="javascript:void(0);"><img src="images/weixin.png" alt=""><span>微信好友</span></a></li>
            <?php  }?>
             
         </ul>
         <div class="clans_ball_box_btn"><span>取消</span></div>
      </div>
  </div>



<script type="text/javascript">
function  change_tribe(tribe_id){
	var label_id = <?php echo $label_id;?>;
	  $.ajax({ 
          url:'<?php echo site_url('Commerce/ajax_People')?>',
          type:'post',
          dataType:'json',
          data:{"label_id":label_id,'tribe_id':tribe_id},
          success:function(data)
          {
        	  $(".tribe_people").empty();
        	  var result = '';
        	  var site_url = '<?php echo site_url(); ?>'
              var img_url =  '<?php echo IMAGE_URL; ?>'; 
        	  var member_defult_url =  "this.src='images/member_defult.png'"; 
        	  result += '<p class="tribe_people_head">我的</p>'; 
        	  result += '<ul class="tribe_people_show">';
        	  result += '<li>';
        	  result += '<ul class="tribe_people_my">';
        	  result += '<li>';
        	  result += '<a href="';
			  if(data.my_info.customer_id){
				  result += site_url+'/Tribe_social/Customer_Info/'+data.my_info.customer_id+'?tribe_id='+data.my_info.tribe_id+'&ts_id='+data.my_info.id;
				  }else{
					  result += 'javascript:void(0);';
			  		  }
        	  result += '">';
        	  result += '<img src="';
        	  if(data.my_info.brief_avatar){
        		  result += img_url+data.my_info.brief_avatar;
            	  }else{
            		  result += data.my_info.wechat_avatar;
                	  }
        	  result += '" alt="" onerror="'+member_defult_url+'">';
        	  result += '</a>';
        	  if(data.my_info.corp_id && data.my_info.approval_status == 2 && data.my_info.corp_status == 1){
        		  result += '<i class="icon-enterprise enterprise-icon"></i>';
            	  }
        	  result += '</li>';
        	  result += '<a href="';
        	  if(data.my_info.customer_id){
				  result += site_url+'/Tribe_social/Customer_Info/'+data.my_info.customer_id+'?tribe_id='+data.my_info.tribe_id+'&ts_id='+data.my_info.id;
				  }else{
					  result += 'javascript:void(0);';
			  		  }
        	  result += '">';
        	  result += '<li class="tribe_people_name" style="word-wrap:break-word">';
        	  result += '<span class="fn-16">';
        	  if(data.my_info.real_name){
        		  result += data.my_info.real_name;
            	  }else{
            		  result += data.my_info.member_name;
                	  }
        	  if(data.my_info.is_host == 1){
        		  result += '<em class="biaoshi1"><i class="icon-shenfen"></i>部落首领</em>';
            	  }else{
                	  if(data.my_info.m_name){
                		  result += '<em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i>'+data.my_info.m_name+'</em>';
                    	  }
                	  }
        	  result += '</span>';
        	  result += '<span class="tribe_people_size tribe_zuyuan" style="padding-top: 8px;"><i></i>';
        	 
        	  if(data.my_info.corporation_name != null){
        		  result += data.my_info.corporation_name;
            	  }
        	  if(data.my_info.duties != null){
        		  result += ','+data.my_info.duties;
            	  }
        	  result += '</span>';
        	  result += '</li>';
        	  result += '<li class="tribe_people_credit">';
        	  result += '<a href="';
        	  result += site_url+'/Tribe_social/invite/'+data.my_info.tribe_id;
        	  result += '"><i class="tribe_yaoqing custom_button">邀请好友</i></a>';
        	  result += '</li>';
        	  result += '</a>';
        	  result += '</ul> ';
        	  result += '<div class="tribe_people_list">';
        	  result += '<a href="'+site_url+'/Tribe_social/Customer_Album/'+data.my_info.customer_id+'/'+data.my_info.tribe_id+'">个人形象</a>';
        	  result += '<a href="'+site_url+'/Corporation_style/User_Topic/'+data.my_info.customer_id+'">企业形象</a>';

              if(data.my_info.corp_id){
            	  result +=  '<a href="'+site_url+'/Home/GetShopGoods/'+data.my_info.corp_id+'">我的店铺</a>';
                  }else{
                	  result +=  '<a href="javascript:message(5)">我的店铺</a>';
                      }
        	  result += '</div>';
        	  result += '</li>';
        	  result += '</ul> ';
        	  
			 if(data.list.length>0){

				for(var i=0;i<data.list.length;i++){
					  result += '<div>';
					  result += '<p class="tribe_people_head">'+data.list[i]['role_name'];
					  if(data.list[i]['total']){
						  result += '('+data.list[i]['total']+')';
						  }else{
							  result += '0';
							  }
					  result += '<span class="icon-right zhankai_icon';
					  if(data.list[i]['id'] == 5 || data.list[i]['id'] == '' ||  !data.list[i]['id']){
						  result += ' span_rotate';
						  }
					  result += '"></span>';
				      result += ' </p>';
				      result += '<ul class="tribe_people_show role_id_'+data.list[i]['id']+'">';

				      for(var j=0;j<data.list[i]['list'].length;j++){
				    	  result += '<li>';
				    	  result += '<ul class="tribe_people_my">';
				    	  if(data.list[i]['list'][j]['corp_id'] && data.list[i]['list'][j]['approval_status'] == 2 && data.list[i]['list'][j]['approval_status'] == 1){
				    		  result += '<i class="icon-enterprise enterprise-icon"></i>';
					    	  }
				    	  result += ' <a href="';
				    	  if(data.list[i]['list'][j]['customer_id']){
				    		  result += site_url+'/Tribe_social/Customer_Info/'+data.list[i]['list'][j]['customer_id']+'?tribe_id='+data.list[i]['list'][j]['tribe_id']+'&ts_id='+data.list[i]['list'][j]['id'];
					    	  }else{
					    		  result += site_url+'/Tribe_social/Staff_info/'+data.list[i]['list'][j]['id'];
						    	  }
				    	  result += '">';
				    	  result += '<li><img src="';

				    	  if(data.list[i]['list'][j]['brief_avatar']){
			        		  result += img_url+data.list[i]['list'][j]['brief_avatar'];
			            	  }else{
			            		  result += data.list[i]['list'][j]['wechat_avatar'];
			                	  }
				    	 
						  result += '" alt="" onerror="'+member_defult_url+'">';
						  result += '</li>';
						  
						  result += '<li class="tribe_people_name" style="word-wrap:break-word">';
						  result += '<span class="fn-16">';
						  if(data.list[i]['list'][j]['real_name']){
							  result += data.list[i]['list'][j]['real_name'];
							  }else{
								  result += data.list[i]['list'][j]['member_name'];
								  }
	                      if(data.list[i]['list'][j]['is_host'] == 1){
	                    	  result += ' <em class="biaoshi1"><i class="icon-shenfen"></i>部落首领 </em>';
		                     }else{
		                    	 if(data.list[i]['list'][j]['m_name'] ){
		                    		 result += ' <em class="biaoshi1" style=" color:#FFCA00; border:1px solid #FFCA00"><i class="icon-shenfen"></i>'+data.list[i]['list'][j]['m_name'] +'</em>';
			                    	 }
			                     }
	                      result += '</span>';
	                      result += '<span class="tribe_people_size tribe_zuyuan" style="padding-top: 8px;"><i></i>';
						  if(data.list[i]['list'][j]['corporation_name']){
							  result += data.list[i]['list'][j]['corporation_name'];
							  }	
	                      if(data.list[i]['list'][j]['duties']){
	                    	  result += ','+data.list[i]['list'][j]['duties'];
		                      }    
	                      result += '</span>';
	                      result += '</li>';

	                      
	                      result += '<li class="tribe_people_credit">';
						 if(!data.list[i]['list'][j]['customer_id'] || data.list[i]['list'][j]['customer_id'] == ''){
							  var dx_status = getTypeCookie(data.list[i]['list'][j]['id'],'dx','Customer');
						      var wx_status = getTypeCookie(data.list[i]['list'][j]['id'],'wx','Customer');
						      if(dx_status && wx_status){
						    	  result += '<em class="send_ok_text">已发送邀请</em>';
							      }else{
									if(wx_status){
										 result += '<em class="send_ok_text" style="left: -96px;">已发送微信邀请</em>';
										}
									if(dx_status){
										 result += '<em class="send_ok_text" style="left: -96px;">已发送短信邀请</em>';
										}

									if(!wx_status || !wx_status){
										 result += '<a href=" javascript:void(0);"><i class="tribe_yaoqing custom_button" flag="1" ts_id='+data.list[i]['list'][j]['id']+'>邀请回家</i></a>'; 
										}else{
											 result += '<a href=" javascript:void(0);"><i class="tribe_yaoqing custom_button" style="background-color: #ccc">邀请回家</i></a>';
											}
								      }
							 }
						 else if(!data.list[i]['list'][j]['corp_id'] || data.list[i]['list'][j]['approval_status'] != 2  || data.list[i]['list'][j]['corp_status'] != 1 ){
								  var dx_status = getTypeCookie(data.list[i]['list'][j]['id'],'dx','Corp');
							      var wx_status = getTypeCookie(data.list[i]['list'][j]['id'],'wx','Corp');
							      if(dx_status && wx_status){
							    	  result += '<em class="send_ok_text">已发送邀请</em>';
								      }else{
								    	  if(wx_status){
												 result += '<em class="send_ok_text" style="left: -96px;">已发送微信邀请</em>';
												}
											if(dx_status){
												 result += '<em class="send_ok_text" style="left: -96px;">已发送短信邀请</em>';
												}
											if(!wx_status || !wx_status){
												 result += '<a href=" javascript:void(0);"><i class="tribe_yaoqing custom_button" flag="2" ts_id='+data.list[i]['list'][j]['approval_status']+'>邀请·分享互助</i></a>';
												}else{
													 result += '<a href=" javascript:void(0); "><i class="tribe_yaoqing custom_button" style="background-color: #ccc">邀请·分享互助</i></a>'; 
													}
									      }
								 
							}
						 else if(data.list[i]['list'][j]['corp_id'] && data.list[i]['list'][j]['approval_status'] == 2  && data.list[i]['list'][j]['corp_status'] == 1){
								result += '<a href="'+site_url+'Home/GetShopGoods/'+data.list[i]['list'][j]['corp_id']+'"><i class="tribe_yaoqing" style="background: #b4d465!important;">串串门</i></a>';
								}
						result += '</li>'; 
						result += '</a>';
						result += '</ul>';
						result += '<div class="tribe_people_list">';

						if(data.list[i]['list'][j]['customer_id']){
							result += '<a href="'+site_url+'/Tribe_social/Customer_Album/'+data.list[i]['list'][j]['customer_id']+'/'+tribe_id+'">认识TA</a>';
							result += '<a href="'+site_url+'/Corporation_style/User_Topic/'+data.list[i]['list'][j]['customer_id']+'">了解TA的产品</a>';

							var user_id = '<?php echo  $this->session->userdata('user_id');?>';
							if(user_id == data.list[i]['list'][j]['customer_id']){
								result += '<a href="javascript:message(4)">聊两句</a>';
								}else{
									result += '<a href="'+site_url+'/Webim/Control/chat/'+tribe_id+'/'+data.list[i]['list'][j]['customer_id']+'">聊两句</a>';
									}
							}else{
								result += '<a href="javascript:message(2)">认识TA</a>';
								result += '<a href="javascript:message(2)">了解TA的产品</a>';
								result += '<a href="javascript:message(3)">聊两句</a>';
								}
					  result += '</div>';
					  result += '</li>';
					}
				  result += '</ul>';
				  result += ' </div>'; 

				
				}
				result += ' </div>'; 
			}
			  $(".tribe_people").append(result);
			  $(".tribe_people_head").on("click",function(){
			      // $(this).siblings('ul').toggleClass('display-block');
			      $(this).children('span').toggleClass('span_rotate');

			      if($(this).children('span').hasClass('span_rotate'))
			      {
			        $(this).siblings('.tribe_people_show').children('li:gt(2)').show();
			      }else{
			        $(this).siblings('.tribe_people_show').children('li:gt(2)').hide();
			      }
			  })

            $('.tribe_yaoqing').on('click',function(){
                 var type = $(this).attr('flag');
                   var ts_id = $(this).attr('ts_id');
                   if( !type )
                   { 
                       return;
                   }
                       
                   $('.clans_ball').show();
                   $('.clans_ball_box ul li').eq(0).show();
                   $('.clans_ball_box ul li').eq(1).show();
                   if( type == 1)
                   { 
                     type = 'Customer';
                       var url = '<?php echo site_url('Tribe/Invite_View/Customer/'.$tribe_id)?>/'+ts_id;
                   }else{ 
                     type = 'Corp';
                       var url = '<?php echo site_url('Tribe/Invite_View/Corp/'.$tribe_id)?>/'+ts_id;
                   }
                   $('.clans_ball_box ul li').eq(0).children('a').attr('id',"sendID"+ts_id);
                   $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('"+type+"',"+ts_id+");");
                   $('.clans_ball_box ul li').eq(1).children('a').attr('href',url+'/1');
                   var dx_status = getCookie(ts_id,'dx');
                   var wx_status = getCookie(ts_id,'wx');
                   if(dx_status){
                   $('.clans_ball_box ul li').eq(0).hide();
                   }
                 if(wx_status){
                   $('.clans_ball_box ul li').eq(1).hide();
                   }
               })
               
          },
          error:function()
          {
            $(".black_feds").text("网络错误！").show();
              setTimeout("prompt();", 2000);  
              $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('"+type+"',"+tribe_staff+");"); 
              return;
          }
        });  
}



   $('.commerce_people_head01 ul li').on('click',function(){
     $(this).children('a').css({
       width: '70',
       height: '70'
     });
     $(this).children('a').removeClass('commerce_head_em');
     $(this).siblings('li').children('a').addClass('commerce_head_em');
   })


   $('.tribe_yaoqing').on('click',function(){

     var type = $(this).attr('flag');
       var ts_id = $(this).attr('ts_id');
       if( !type )
       { 
           return;
       }
           
       $('.clans_ball').show();
       $('.clans_ball_box ul li').eq(0).show();
       $('.clans_ball_box ul li').eq(1).show();
       if( type == 1)
       { 
         type = 'Customer';
           var url = '<?php echo site_url('Tribe/Invite_View/Customer/'.$tribe_id)?>/'+ts_id;
       }else{ 
         type = 'Corp';
           var url = '<?php echo site_url('Tribe/Invite_View/Corp/'.$tribe_id)?>/'+ts_id;
       }
       $('.clans_ball_box ul li').eq(0).children('a').attr('id',"sendID"+ts_id);
       $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('"+type+"',"+ts_id+");");
       $('.clans_ball_box ul li').eq(1).children('a').attr('href',url+'/1');
       var dx_status = getCookie(ts_id,'dx');
       var wx_status = getCookie(ts_id,'wx');
       if(dx_status){
       $('.clans_ball_box ul li').eq(0).hide();
       }
     if(wx_status){
       $('.clans_ball_box ul li').eq(1).hide();
       }
   })
     
   $('.clans_ball').on('click',function(){ 
     $('.clans_ball').hide()
   })
   
   function caution(){
     $(".black_feds").text("3天内不可重复邀请").show();
    setTimeout("prompt();", 2000);
     }
   function getCookie(ts_id,type){
      var Customer = false;
      var Corp = false;
      var Cookie_Customer ='invite_'+type+'_Customer_'+ts_id;
    var arr,reg= new RegExp("(^| )"+Cookie_Customer+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg)){
      Customer = true;
    }
    var  Cookie_Corp = 'invite_'+type+'_Corp_'+ts_id;
    var Carr,Creg= new RegExp("(^| )"+Cookie_Corp+"=([^;]*)(;|$)");
    if(Carr=document.cookie.match(Creg)){
      Corp =  true;
      }
    if(Corp || Customer){
      return true;
      }
  }


   function getTypeCookie(ts_id,type,parms){
	    var Cookie_Customer ='invite_'+type+'_'+parms+'_'+ts_id;
	    var arr,reg= new RegExp("(^| )"+Cookie_Customer+"=([^;]*)(;|$)");
	    if(arr=document.cookie.match(reg)){
	     return true;
	    }else{
	    	  return false;
		    }
	  }
   function ajax_submit(flag,ts_id)
   {
    var type = flag;
    var tribe_id = '<?php echo $tribe_id?>';
    var tribe_staff = ts_id;
   
    if( type && tribe_id && tribe_staff )
    { 
        $.ajax({ 
          url:'<?php echo site_url('Tribe/Invite')?>',
          type:'post',
          dataType:'json',
          data:{'type':type,'tribe_id':tribe_id,'tribe_staff':tribe_staff},
          beforeSend:function()
               { 
            $(".black_feds").text("短信发送中....").show();
//                  document.getElementById('sub').style.background='#ccc';
//                document.getElementById('sub').text='短信发送中....';
            $('.clans_ball_box ul li').eq(0).children('a').attr('href',"");
               },
          success:function(data)
          {

            $(".black_feds").text(data.message).show();
              setTimeout("prompt();", 2000);
              setTimeout(function(){
                  window.location.reload();
                  }, 2200);
          
        },
          error:function()
          {
            $(".black_feds").text("发送失败,请稍后再试").show();
              setTimeout("prompt();", 2000);  
              $('.clans_ball_box ul li').eq(0).children('a').attr('href',"javascript:ajax_submit('"+type+"',"+tribe_staff+");"); 
              return;
          }
        })  
    }else{
      
      $(".black_feds").text("参数错误").show();
           setTimeout("prompt();", 2000);   
           return false;
    }
   }
</script>




<script type="text/javascript">
var footer_nva_length = $(".tribe_shop_footer ul li").length;
$(".tribe_shop_footer ul li").css("width",(100/footer_nva_length)+"%"); 

  // 点击头部导航
  $(".essay_preview_nav ul li").on("click",function(){
    $(this).addClass('essay_active').siblings().removeClass('essay_active');
  })
  
  
  //族员的全部显示。
  $('.role_id_5 li').show();
  $('.role_id_0 li').show();
  

  $(".tribe_people_head").on("click",function(){
      // $(this).siblings('ul').toggleClass('display-block');
      $(this).children('span').toggleClass('span_rotate');

      if($(this).children('span').hasClass('span_rotate'))
      {
        $(this).siblings('.tribe_people_show').children('li:gt(2)').show();
      }else{
        $(this).siblings('.tribe_people_show').children('li:gt(2)').hide();
      }



  })
  
 function message(status)
 { 
    var message = '此功能正在测试，敬请期待';
    
    if( status == 1)
    { 
      message = '该族员未登录，暂时不能对他评价';
      
    }else if ( status == 2 )
    { 
      message = '该族员未登录';
    }else if (status == 3)
    { 
      message = '该族员未登录';
    }else if (status == 4)
    { 
        message = '不能和自己聊天';
    }else if (status == 5)
    { 
      message = '您还没有开店，请联系客服协助 400-0029-777';
    }
    
    $(".black_feds").text(message).show();
    setTimeout("prompt();", 2000); 
 }

function Is_Exists_Comment( customer_id )
{
    $.post("<?php echo site_url('Tribe_social/Is_Exists_Comment')?>", { "to_customer_id": customer_id },
        function(data,status)
        {
            if( data.status )
            { 
                window.location.href = '<?php echo site_url('Tribe_social/comment')?>/'+customer_id
            }else{ 
            	$(".black_feds").text("您已经评价过了").show();
                setTimeout("prompt();", 2000); 
				return false;
                
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
})

</script>


<?php }else{?>

    <!-- 您还未加入商会，请加入后查看人脉关系。 -->
<div class="commerce_people_not"><span>您还未加入商会，请加入后查看人脉关系。</span></div>


    
<?php }?>

  </div>
