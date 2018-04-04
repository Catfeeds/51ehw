<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<link rel="stylesheet" type="text/css" href="css/theme/style_v2.css">
</head>
<body>
 <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">评价管理</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
        </ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box renzheng_Box clearfix ">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight" style="text-align: left">
            <div class="cmRight_tittle">会员背书</div>
            <form action="" method="post" name="form" id="form1">
            <div class="dianpu_01_con01 clearfix">
            <input type="hidden" name="id" value="">
            	<div class="dianpu_left">
                	<ul>
                    	<li>推荐单位名称 :</li>
                        <li>推荐单位图标 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                    	<li><?php echo $detail['recommend_company'];?></li>
                        <li id="img" ><img src="<?php echo IMAGE_URL.$detail['logo'];?>" width="150" height="150" alt=""/></li>
                    </ul>
                </div>
                <!---->
                <div class="dianpu_left">
                	<ul>
                    	<li>推荐单位证明书 :</li>
                    </ul>
                </div>
                <div class="dianpu_01_right">
                	<ul>
                        <li id="img" ><img src="<?php echo IMAGE_URL.$detail['certificate'];?>" width="150" height="150" alt=""/></li>
                    </ul>
                </div>
                <!---->
                
                <div class="dianpu_left">
                	<ul>
                	<?php $i=0;?>
                	<?php foreach ($recommend_content as $k => $v):?>
                	<?php if(!empty($v)){?>
                        <li>推荐语 :</li>
                    <?php };?>
                    <?php endforeach;?>
                    </ul>
                </div>
                <div class="dianpu_01_right dropdown basicInformation_right">
                	<ul>
                	<?php foreach ($recommend_content as $v):?>
                        <li><?php echo $v;?></li>
                    <?php endforeach;?>
                    </ul>
                    <!--按钮操作-->
                    <div>
                    	<!--进入会员背书详情（ 审核通过 ）时，只有新建和隐藏的按钮-->
                    	<a href="<?php echo site_url('corporate/resource/resource_list') ?>" class="dianpu_recite_btn">新建</a>
                    	<?php switch ($detail['approve_status']){
                    	    case 0:
                    	        break;
                    	    case 1:
                    	        echo '<a href="'.site_url('corporate/resource/edit').'/'.$detail['id'].'" class="dianpu_recite_btn_grey">隐藏</a>';
                    	        break;
                    	    case 2:
                    	        break;
                    	    case 3:
                    	        echo '<a href="'.site_url('corporate/resource/open').'/'.$detail['id'].'" class="dianpu_recite_btn_grey">重新打开</a>';
                    	        break;
                    	}?>

                        <!--进入会员背书详情（ 审核中 或者 审核失败 或者 隐藏 ）时，只有新建的按钮-->
                    	<!--<a class="dianpu_recite_btn">新建</a>-->
                    </div>
                </div>
       		</div><!--内容01 结束-->
       		</form>
			<!--内容01 开始-->
              <div class="cmRight_tittle"  style="margin:50px 0 30px 0;">提交纪录</div>
              <table width="910" height="34" border="0" cellpadding="0" cellspacing="0" class="recite_tab">
                  <tr class="tr1" >
                      <th width="150px">推荐单位</th>
                      <th width="150px">上传时间</th>
                      <th width="120px">背书状态</th>
                      <th width="150px">审核时间</th>
                      <th width="200px">审核意见</th>
                      <th width="80px">详情</th>
                  </tr>
              
              </table>
              <?php foreach ($log as $k => $v):?>	
              <table width="910" height="50" border="0" cellpadding="0" cellspacing="0" class="recite_tab2">
                  <tr>
                      <th width="150px"><?php echo $v['recommend_company'];?></th>
                      <th width="150px"><?php echo $v['updated_at'];?></th>
                      <th width="120px" class="recite_state">
                      <?php switch($v['approve_status']){
                          case 0:
                              echo "审核中";
                              break;
                          case 1:
                              echo "审核通过";
                              break;
                          case 2:
                              echo "审核失败";
                              break;
                          case 3:
                              echo "隐藏";
                              break;
                      }?></th>
                      <th width="150px"><?php echo $v['approve_date'];?></th>
                      <th width="200px"><?php echo $v['proposal'];?></th>
                      <th width="80px">
                         <a href="<?php echo site_url('corporate/resource/detail').'/'.$v['id'];?>" style="color:#fca543; text-decoration:underline">详情</a> 
                      </th> 
                  </tr>
              </table>
			  <?php endforeach;?>
                 </div>
                </div>
              
              <!--无结果时候显示-->
              <!--<div class="result_null">暂无内容</div>-->

</body>
</html>
