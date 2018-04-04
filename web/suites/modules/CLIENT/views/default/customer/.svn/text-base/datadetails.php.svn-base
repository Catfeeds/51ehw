    
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>


    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 10;
            $this->load->view('customer/leftmenu',$data);
         ?>
        
         <div class="huankuan_cmRight clearfix">
        <!--<form name="customersearch" method="post" action="<?php echo site_url('customer/customerdata/'.$level."/".$fid);?>">
        	<div class="huankuan_rTop">我的客户</div>
            <div class="kehu_rCon04 clearfix">
            	<label class="kehu_rCon04_lable">客户注册日期：
                	<div class="kehu_rCon04_inp">
                        <input type="text" class="kehu_rCon04_input2" name="begindate" value="<?php echo $begindate;?>" onClick="WdatePicker()" readonly>
                        <span>&nbsp;&nbsp;至 </span>
                        <input  type="text" class="kehu_rCon04_input3" name="enddate" value="<?php echo $enddate?>" onClick="WdatePicker()" readonly>
                    </div>
                </label>
                <label class="kehu_rCon04_lable">客户会员账号:   <input class="kehu_rCon04_input" name="username" type="text" value="<?php echo $username?>"></label>
                <label class="kehu_rCon04_lable">客户联系电话：  <input class="kehu_rCon04_input" name="phone" type="text" value="<?php echo $phone;?>"></label>
                <div class="kehu_rCon04_btn"><a id="sub">申请结算</a></div>           
            </div>
        </form>-->
            
            <div class="kehu_wode_con">
            	<div class="kehu_wode_con01">
                	<ul>
                    	<li style="width:81px">序号</li>
                        <li>会员账号</li>
                        <li>会员ID</li>
                        <li>注册日期</li>
                        <li>登录次数</li>
                        <li>消费金额</li>
                        <!-- <li>分红金额</li>-->
                        <!-- <li>是否有客户</li>-->
                        <!-- <li style="width:81px; border-right:0">操作</li>-->
                    </ul>
                </div>
                <div class="kehu_wode_con01 kehu_wode_con02">
                	<ul>
                	<?php if($user && count($user>0)){ 
					?>
                    	<li style="width:81px"><?php echo $user["id"];?></li>
                        <li><?php echo $user["name"];?></li>
                        <li><?php echo $user["id"];?></li>
                        <li><?php  $datetime=strtotime($user["registry_at"]); if($datetime>0){echo date('Y-m-d',abs(strtotime($user["registry_at"])));}else{echo '待定';};?></li>
                        <li><?php echo $user["login_count"]?></li>
                        <li>￥ <?php echo $user["credit"]==null? "0.00":  $user["credit"];?></li>
                        <!-- <li>￥ <?php //echo $user["rebate"]==null?"0.00":$user["rebate"];?> </li>-->
                        <!-- <li><?php  ?></li>-->
                        <!-- <li style="width:81px; border-right:0"><a href="<?php //echo site_url('customer/customerDataDetail/'.$level.'/'.$c["id"])?>" class="btn btn-custom btn-xs">查看</a></li>-->
                        <?php }else{?>
                        <center>暂无下级记录</center>
                        <?php }?>
                    </ul>
                </div>
            </div>
           <!-- <div class="pingjia_jilu" style="margin-left:30px">
                    	<p>显示  到   条数据，共  条数据</p>
                    </div>
                    <div class="pingjia_showpage" style="margin-right:30px">
                    	
                    	
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
                            
                    </div>-->
        </div>
    </div>


<script>
   $('#sub').click(function(){
	    $('form').submit();
	   });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>

