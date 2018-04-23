<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>

<style type="text/css">
  .search_1.manage_c_search_1 a {margin: 0 20px 0 0;}
  .needs_nav_active {color: #FAAD60!important;}
  .no_pass {color: #B62724!important;}
  .dingdan4_3_tanchuang_top2_text {text-align: left;margin-left: 155px;}
  .select_ul_fg{ float:none !important}
</style>


  <div class="Box manage_new_Box clearfix">
     <div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>个人中心</a></li>
			<li><a
				href="<?php echo site_url('member/info')?>">个人信息</a></li>
			<li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
			<!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
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
			<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
			<li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
			<!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
			<!--<li><a href="javascript:;">在线客服</a></li>-->
			<!-- <li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
		</ul>
		<ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li class="kehu_current"><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		</ul>
	</div>
        <!---->
   
        
               
       


       <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="huankuan_rTop">全部需求</div>
	
		<div
			class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con">
			<div class="search_0">
				<div class="search0_0">
					<div class="search_1 manage_c_search_1" id="needs_my_nav">
							<a id="all"  href="<?php echo site_url('member/demand/index/0');?>">全部(<?php echo $all;?>)</a>
                            <a id="behind" href="<?php echo site_url('member/demand/index/1');?>">待审核(<?php echo $wait;?>)</a>

                            <a id="pass" href="<?php echo site_url('member/demand/index/2');?>">上架(<?php echo $pass;?>)</a>
                            <a id="no" href="<?php echo site_url('member/demand/index/3');?>">未通过(<?php echo $fail;?>)</a>
                            <a id="off" href="<?php echo site_url('member/demand/index/4');?>">下架(<?php echo $fall;?>)</a>
                            <a id="delete" href="<?php echo site_url('member/demand/index/5');?>">删除(<?php echo $del;?>)</a>	
					</div>
					<div class="search_2 manage_fenlei_search_2 manage_c_search_2">
					
							<div>
								<input type="text" class="search2_con manage_fenlei_search2_con" name="keyword" value="<?php echo $keyword;?>">
							</div>
							<div class="search2_btn manage_fenlei_search2_btn">
								<a href="javascript:search();" >店内搜索</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="select1">
				<ul class="select_ul_fg">
					<li><a href="<?php echo site_url("member/demand/add_list");?>">添加</a></li>
				</ul>
				<?php if($total_rows>0){?>
				<table width="910" height="34" border="1" cellpadding="0"
					cellspacing="0" class="table1_1">
					<tr class="tr1 manageC_tr">
						<th width="254px" style="text-align: left"><span
							style="margin-right: 68px; margin-left: 15px"
							></span>商品名称</th>
						<th width="140px">所属行业</th>
						<th width="150px">需求总价</th>
						<th width="76px">需求数量</th>
						<th width="94px">状态</th>
						<th width="180px">操作</th>
						<th width="78px">备注</th>
					</tr>
				</table>

			        <?php foreach ($list as $v){?>
			        <table class="table_border">
                        <tbody>
                            <tr class="tr1">
                                <td colspan="9" style="text-align: left; background: #ffe3c4; border: 1px solid #fea33b;"><span  style="margin-right: 68px; margin-left: 15px" ></span>需求ID : <?php echo $v['id'];?>
                                    <span style="margin-left: 40px">地区：<?php echo $v['shippingaddress'];?></span><span style="margin-left: 40px">发布时间：<?php echo $v["create_at"]?></span>
                            	</td>
                            </tr>
                            <tr class="tr1">
                            	<th width="265px"><?php echo $v['title'];?></th>
                                <th width="140px"><?php echo $v['name'];?></th>
                                <th width="140px" >
                                <?php 
                                $total = $v['p_count']*$v['m_price'];
                                echo $total ;?>
                                </th>				
                                <th width="76px"><?php echo $v['p_count'];?></th>
                                <th width="94px" class="no_pass">
                                <?php 
                                switch($v['ispublish']){
                                    case 1:
                                        echo "待审核";
                                        break;
                                    case 2:
                                        if($v['is_putaway'] == 0){
                                            echo "下架";
                                        }else{
                                            echo "上架";
                                        }
                                        break;
                                    case 3:
                                        echo "不通过";
                                        break;
                                    case 5:
                                        echo "已删除";
                                        break; 
                                }
                                ?>
                                </th>
                                <th width="180px">
                                <?php if($v['ispublish'] !=5){?>
                                
                                <?php if($v['ispublish'] == 3 ){;?>
                                    <a id="edit_650" href="<?php echo site_url('member/demand/add_list').'?id='.$v['id'];?>" style="font-size: 13px;text-decoration: underline;padding-right: 5px;" >编辑</a>
                                <?php }; ?>
                                  
                                <?php if($v['ispublish'] !=1){?>
                                    <a href="javascript:operation(<?php echo $v['id']?>,<?php echo $v['ispublish'];?>,
                                    <?php if($v['ispublish']==2){
                                        switch($v['is_putaway']){
                                            case 0:
                                                echo 1;//如果是下架状态，则上架
                                                break;
                                            case 1:
                                                echo 0;//如果是上架状态，则下架
                                                break;
                                        }
                                        //99 不是审核通过状态
                                    }else{ echo 99; }?>);"  style="font-size: 13px;text-decoration: underline;padding-right: 5px;">
                                        <?php 

                                        switch($v['ispublish']){
                                           case 2:
                                               if($v['is_putaway'] == 0){
                                                if(strtotime($v['effectdate']) > strtotime("now")){
                                                  echo "上架";
                                                }
                                                   
                                               }else{
                                                   echo "下架";
                                               }
                                               break;
                                           case 3:
                                               echo "申请审核";
                                               break;
                                        }
                                        ?>
                                    </a>
                                <?php }?>
                                <a href="<?php echo site_url("member/demand/demand_details/".$v['id']);?>"  target="_blank" style="font-size:13px;;text-decoration: underline;padding-right: 5px;">预览</a>
                                <a href="javascript:operation(<?php echo $v['id']?>,5);" style="font-size:13px;;color: #fca543; text-decoration: underline;padding-right: 2px;" class="tanchuang02">删除</a>
                                <?php };?>
                                </th>
                                <th width="77px" ><a href="javascript:void(0);" class="tanchuang01"><span style="display: inline-block;line-height: 20px;"><?php echo $v['remark'];?></span></a></th>
                            </tr>
                        </tbody>
					</table>
					<?php };?>
                    <?php }else{?>
			        <div class="result_null" style="margin-top:10px; ">暂无相关需求</div>
				    <?php };?>
        
			  <div class="jilu">
                      <p>共 <?php echo $total_rows;?> 条数据</p>
                    	  </div>
                    <div class="showpage">
                    	<?php echo $page;?>
                    </div>
			</div>
		</div>   
	</div>



   
    </div>
                    
</div>


<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang01" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2 dingdan4_3_tanchuang_top2_text">
          <p >未通过原因</p>
          <p>1.填写产品名称不清晰 </p>
          <p>2.未能明确需求产品的数量和规格，与实际的规格不符</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" id="" style="background:#72c312;margin-left: 275px;"><a onclick="hiding()">返回</a></div>
          <!-- <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sure">确定</a></div>      -->  
      </div>
  </div>
</div>
<script type="text/javascript">
  // 返回
  function hiding(){
    $("#dingdan4_3_tanchuang01").hide();
  }
  
</script>
<!--通用操作 弹窗end-->

<!--通用操作 弹窗start-->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang02" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'>确定要把该需求删除吗？</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div class="dingdan4_3_btn01" style="background:#ccc;"><a onclick=cancel()>取消</a></div>
          <div class="dingdan4_3_btn02"><a href="<?php echo site_url("member/demand/change/".$status.'/5').'?keyword='.$keyword;?>" id="sure">确定</a></div>       
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->

<script type="text/javascript">
     $(function(){
 	    switch(<?php echo $status;?>){
            case 0:
                $("#all").addClass("needs_nav_active");
      	        break;
            case 1:behind
                $("#behind").addClass("needs_nav_active");
      	        break;
            case 2:
            	$("#pass").addClass("needs_nav_active");
      	        break;
            case 3:
            	$("#no").addClass("needs_nav_active");
      	        break;
            case 4:
            	$("#off").addClass("needs_nav_active");
      	        break;
            case 5:
            	$("#delete").addClass("needs_nav_active");
      	        break;
 	    }
     })

                                	   

    // $(".tanchuang01").on("click",function(){
    //    $("#dingdan4_3_tanchuang01").css("display","block");
    // })
    
    //取消弹窗
    function cancel(){
    	$("#dingdan4_3_tanchuang02").hide();
    }
</script>

<script type="text/javascript">
    //操作
    function operation(id,state,isonline){
	    switch(state){
		    case 2:
			    if(isonline ==0){
			    	$("#prompt").text('确定下架吗？');
			    	isonline = 0;
				    }else{
				    	$("#prompt").text('确定上架吗？');
				    	isonline = 1;
					    }
		    	state = 2;
			    break;
		    case 3:
		    	state = 1;
		    	isonline = 99;
		    	$("#prompt").text('确定重新审核吗？');
			    break;
		    case 5:
		    	state = 5;
		    	isonline = 99;
		    	$("#prompt").text('确定要把该需求删除吗？');
			    break;	    
	    }
	   $("#sure").attr('href',"<?php echo site_url("member/demand/change/".$status);?>"+'/'+id+'/'+state+'?isonline='+isonline+'&keyword='+"<?php echo $keyword;?>");
       $("#dingdan4_3_tanchuang02").css("display","block");
    }

    //搜索
    function search(){
    	keyword = $("input[name=keyword]").val();
        if(!keyword){
            alert('请输入关键词');
            return ;    
        }
        window.location.href="<?php echo site_url('member/demand/index').'/'.$status;?>"+'?keyword='+keyword;;
        }
</script>




   









