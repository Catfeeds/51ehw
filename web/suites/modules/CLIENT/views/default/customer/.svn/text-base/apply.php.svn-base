<script type="text/javascript" src="js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="js/diyUpload.js"></script>
<script type="text/javascript" src="js/Validform.js"></script>

    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 14;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight">
        	<div class="huankuan_rTop">返修/退换货</div>
            <div class="kehufuwu_04_top2"><h4>申请售后</h4></div>
            
            <?php if(isset($order)):?>
            <?php foreach ($order as $k=>$v):?>
            <!--右边按钮-->
            <div class="kehufuwu_03_btn"><a href="javascript:;">联系客服</a></div>
            <!--表格内容-->
            <div class="kehufuwu_03_con">
            	<table width="910" height="200" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1 kehufuwu_03_table">
                    	<tr class="tr1 manage_b_tr1">
                            <th width="122px">订单编号</th>
                            <th width="450px">订单商品</th>
                            <th width="154px">下单时间</th>
                    	</tr>
                    	
                    	<tr class="kehufuwu_03_table_tr">
                    	    <span id="quantity" style="display: none"><?php echo $v['quantity']?></span>
                            <th><a href="<?php echo site_url('member/order/detail').'/'.$v['id'];?>"><?php echo $v['order_sn'];?></a></th>
                            <th class="kehufuwu_03_table_th03 kehufuwu_03_table_th03_1">
                       	    <img src="<?php echo $v['file'];?>" width="88" alt=""/>
                            <p class="kehufuwu_03_p03 kehufuwu_03_p03_1"><?php echo $v['product_name']?></p>
                            </th>
                            <th class="kehufuwu_03_th05_span">
                            	<span><?php echo substr($v['place_at'],0,11)?></span><br>
                            	<span><?php echo substr($v['place_at'],11)?></span>
                            </th>
                    	</tr>
                    </table>
            </div>
            <?php endforeach;?>
            <?php else:?>
            <center>暂无订单</center>
            <?php endif;?>
            
            <div class="kehufuwu_05_con01 clearfix">
              <ul>
                  <li>服务类型 :</li>
                  <li class="kehufuwu_05_li_current1"><a>[退货]</a></li>
                  <li><a>换货</a></li>
                  <li><a>维修</a></li>
              </ul>
            </div>
            <form action="<?php echo site_url("member/return_repair/save");?>" method="POST" enctype="multipart/form-data">
            <div class="kehufuwu_04_con clearfix">
            <div class="kehufuwu_05_con clearfix">
                <ul>
                	<li><label class="kehufueu_05_lable"><em style="color:red">*</em>退货数量：<input class="kehufuwu_05_input" onkeyup="this.value=this.value.replace(/\D/g,'')"    name='quantity' type="text" /></label></li>
                    <li><em style="color:red">*</em>问题描述：<textarea name="problem" class="kehufuwu_05_textare" rows="10" cols="10"></textarea></li>
                    <li>图片信息：
                    	<div id="box">
						  <div id="test"></div>
					    </div>
                        <p>为了帮助我们更好的解决问题，请您上传图片</p>
                        <p>最多可上传5张图片，每张图片大小不超过5M，支持bmp,gif,jpg,png,jpeg格式文件</p>
                    </li>
                    <li><label><em style="color:red">*</em>买家姓名：<input name="name" type="text" class="kehufuwu_05_input" value=""></label></li>
                    <li><label><em style="color:red">*</em>手机号码：<input name="phone" type="text" class="kehufuwu_05_input" value=""></label></li>
                    <li><label><em style="color:red">*</em>取货地址：<input name="address" type="text" class="kehufuwu_05_input" value=""></label></li>
                </ul> 
            </div>
            <div class="kehufuwu_05_tijiao_btn"><a  href="javascript:void(0)" onclick="sub()" >提交</a></div>
            </form>
            </div>
            
        </div>



    </div>

    <script>
      $("input[type=file").click(function(){
  	    alert($("input[type=file").val());
          });
    
       function sub(){//提交数据
           if(check()){
               $('form').submit();
               }
           };

       function check(){
//      	    var val = $('input[name=quantity]').val();
//        	    var number = $('#quantity').text();
//        	    var quantity = $("input[name=quantity]");
//        	    var problem = $("textarea[name=problem]");
//           	var name = $("input[name=name]");
//            	var phone = $("input[name=phone]");
//            	var address = $("input[name=address]");
//            	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
           	
//        	    if(quantity.val()==''){
//           	     alert("退货数量不能空");
//           	     return false;
//        	   	    }
//        	    if(val>number){
//        	   	    alert("退货数量不能超过订单数量");
//        	   	    return false;
//        	   	    }
//           	if(problem.val()==''){
//           	     alert("描述不能空");
//             	 return false;
//         	   	}

//            	if(name.val()==''){
//         	     alert("姓名不能空");
//         	     return false;
//       	   	    }

//        	    if(phone.val()==''){
//           	     alert("手机不能空");
//             	 return false;
//        	    }
       	    
//           	if(!myreg.test(phone.val())) 
//          	{ 
//          	    alert('请输入有效的手机号码！'); 
//          	    return false; 
//          	}

//            	if(address.val()==''){
//         	     alert("地址不能空");
//         	     return false;
//       	   	    }
  	   	    return check;
       }
    </script>
   <script type="text/javascript">

    /*
    
    * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
    
    * 其他参数同WebUploader
    
    */
    
    
    $('#test').diyUpload({
    	url:'<?php echo site_url('member/return_repair/file_upload');?>',
    	type:'post',
    	success:function( data ) {
    		console.info( data );
    	},
    	error:function( err ) {
    		console.info( err );	
    	}
    });  

    </script>   





    







