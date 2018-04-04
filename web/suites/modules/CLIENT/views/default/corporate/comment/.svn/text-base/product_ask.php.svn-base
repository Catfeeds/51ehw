    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>       
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<!--内容开始-->
    <div class="Box manage_new_Box clearfix">
     <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">咨询评价</div>
            <div class="cmLeft_down">
            	<ul>
                    <li><a href="<?php echo site_url('corporate/comment/get_list').'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!isset($search['product_score'])?$search['product_score']:'').'&reply='.(!isset($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>">全部评价(<?php echo $allcount ?>)</a></li>
                    <li <?php echo isset($types) && $types == 1?'class="houtai_zijin_current"':''; ?>><a href="<?php $type=1; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!isset($search['product_score'])?$search['product_score']:'').'&reply='.(!isset($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="not2">未回复(<?php echo $noreplycount ?>)</a></li>
                    <li <?php echo isset($types) && $types == 2?'class="houtai_zijin_current"':''; ?>><a href="<?php $type=2; echo site_url('corporate/comment/get_list/'.$type).'?product_name='.(!empty($search['product_name'])?$search['product_name']:'').'&product_id='.(!empty($search['product_id'])?$search['product_id']:'').'&start_time='.(!empty($search['start_time'])?$search['start_time']:'').'&end_time='.(!empty($search['end_time'])?$search['end_time']:'').'&content='.(!empty($search['content'])?$search['content']:'').'&username='.(!empty($search['username'])?$search['username']:'').'&product_score='.(!isset($search['product_score'])?$search['product_score']:'').'&reply='.(!isset($search['reply'])?$search['reply']:'').'&order_sn='.(!empty($search['order_sn'])?$search['order_sn']:''); ?>" id="have2">已回复(<?php echo $replycount ?>)</a></li>
                    <li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/comment/product_ask');?>">商品咨询(<?php echo $askcount;?>)</a></li>

                </ul>
            </div>
        </div>
        <!---->
    <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">商品咨询</div>
                <div class="demand">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con">
                 <ul class="demand_1">
                 <?php foreach ($demand as $v){;?>
                   <li>
                      <div class="demand_2">
                      <!-- <keyword><strong class="qi">企业ID：</strong><strong class="qi1"><?php echo $v['corporation_id']?></strong></keyword> -->
                      <keyword><strong class="qi">联系人：</strong><strong class="qi1"><?php echo $v['nick_name']?></strong></keyword>
                      <keyword><strong class="qi">联系电话：</strong><strong class="qi1"><?php echo $v['name']?></strong></keyword>
                      <!-- <keyword><strong class="qi">联系QQ：</strong><strong class="qi1"><?php echo $v['qq_account']?></strong></keyword> -->
                   </div>
                   <div class="demand_3">
                      <sub><img src="<?php echo IMAGE_URL.$v['goods_thumb'];?>"></sub>
                       <div class="demand_3_r">
                         <p><?php echo $v['name'];?></p>
                         <p>时间： <samp><?php echo $v['created_at']?></samp></p>
                       </div>
                   </div>
                     <div class="pingjia_11_huifu">
                          <h6>问题：<?php echo $v['created_content'];?></h5>
                          <?php if(!isset($v['replay_content'])){?>
                          <samp class="pingjia_11_huifu_l">回复：</samp><input type="text" class="pingjia_11_huifu_input" name="reply_content" id=<?php echo 'content_'.$v['id'];?> value="">
                          <div class="pingjia_11_huifu_btn"><a href="javascript:void(0)" onclick="reply(<?php echo $v['id']?>)">回复</a></div>
                          <?php }else{;?>
                          <p><samp class="pingjia_11_huifu_l">回复：</samp> <span class="pingjia_11_huifu_r"><?php echo $v['replay_content'];?></span></p>
                          <?php };?>
                      </div>
                   </li>
                 <?php };?>
  
                 </ul>
                    <div class="showpage showpage_right">
                    <?php echo $page;?>
                    </div>
                </div>
        </div>
        </div>
        
        
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style=" display:none;">
            <div class="cmRight_tittle">商品咨询</div>
                <div class="demand"> 
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con kehuguanli_cmRight_con">
                 <div class="result_null" style=" width:910px; margin:10px auto;">暂无内容</div>
                </div>
        </div>
        </div>
        
        
     </div>
     <script>
     //ajax回复
     function reply(advisory_id){
         var content = $('#content_'+advisory_id).val();
         if(content){
             $.post("<?php echo site_url('corporate/demand/add_reply');?>",{content:content,advisory_id:advisory_id},function(data){
            	 window.location.reload();
                 });
             }else{
           	  alert('请输入回复内容');
             }
     }
     </script>
    
    