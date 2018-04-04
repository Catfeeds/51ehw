
<script language="javascript" type="text/javascript"
	src="js/My97DatePicker/WdatePicker.js"></script>
<div class="Box member_Box clearfix">
		<?php //个人中心左侧菜单  
            $data['left_menu'] = 1;
            $this->load->view('customer/leftmenu',$data);
         ?>


	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">个人信息</div>
		<div class="kehufuwu_04_top2">
			<h4>修改个人信息</h4>
		</div>
		<div class="gerenzhongxin_01_con clearfix">
			<form action="<?php echo site_url('member/info/info_save')?>"
				id="order_save" method="post">
				<div class="gerenzhongxin_01_con_left">
					<ul>
					    <li>昵称：</li>
						<li>性别：</li>
						<li>生日：</li>
						<li>职业：</li>
						<li>电子邮件：</li>
						<li>真实姓名：</li>
						<li>固定电话：</li>
						<!-- <li><span> </span>手机号码：</li>-->
					</ul>
				</div>

				<div class="gerenzhongxin_01_con_right">
					<ul>
					    <li><input type="text" class="gerenzhongxin_01_con_input"
							name="nick_name" value="<?php echo $customer['nick_name']?>"
							placeholder="请输入昵称"></li>
						<li><label class="gerenzhongxin_01_lable"><input type="radio"
								class="gerenzhongxin_01_radio" name="sex" value="0"
								<?php echo ((int)$customer['sex'])===0?'checked':'';?>>女</label> <label
							class="gerenzhongxin_01_lable"><input type="radio"
								class="gerenzhongxin_01_radio" name="sex" value="1"
								<?php echo $customer['sex']==1?'checked':'';?>>男</label></li>
						<li><input type="text" name="birthday"
							class="gerenzhongxin_01_con_input" placeholder="生日日期"
							value="<?php echo substr($customer['birthday'],0,10);?>"
							onClick="WdatePicker()"></li>
						<li><input type="text" name="job"
							class="gerenzhongxin_01_con_input" placeholder="请输入您的职业"
							value="<?php echo $customer['job'];?>"></li>
						<li><input type="text" id="consignee_email" onblur="check_email()"
							name="email" value="<?php echo $customer['email'] ?>"
							class="gerenzhongxin_01_con_input" placeholder="请输入您邮箱"></li>
						<li><input type="text" class="gerenzhongxin_01_con_input"
							name="real_name" value="<?php echo $customer['real_name']?>"
							placeholder="请输入真实姓名"></li>
						<li><input type="text" id="consignee_message" onblur="check_message()"
							name="phone" value="<?php echo $customer['phone'] ?>"
							class="gerenzhongxin_01_con_input" placeholder="请输入固定电话号码"></li>
						<li>
						<?php //echo $customer['mobile'] ?>
						<!-- <input type="text" id="consignee_phone"
							onblur="check_phone()" name="mobile"
							value=""
							class="gerenzhongxin_01_con_input" placeholder="请输入手机号码">--></li>
					</ul>
					<!--                     <input class="gerenzhongxin_01_xiugai_btn" name="btnSubmit" value="保存"  id="btnSubmit" type="submit"> -->
					<div class="gerenzhongxin_01_xiugai_btn">
						<a id="sub">保存</a>
					</div>
				</div>

			</form>
		</div>

	</div>


</div>
<script>


    $("#sub").click(
    	    function(){
    	    	if(check())
    	    	{
    	    		$("form").submit();
    	    	}
        	 });

    function check(){
   	    var real_name = $("input[name=real_name]");
	    var job = $("input[name=job]");
	    var email = $("input[name=email]");
	    var phone = $("input[name=phone]");
	    var mobile = $("input[name=mobile]");
	    var birthday = $("input[name=birthday]").val();
	    //var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //验证邮箱的正则表达式
	   // var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; //手机正则表达式
	  // var regexp=  /(\d{2,5}-\d{7,8}(-\d{1,})?)|(13\d{9})|(159\d{8})/;//固定电话正则表达式
	   // var reg_date =/((^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(10|12|0?[13578])([-\/\._])(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(11|0?[469])([-\/\._])(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(0?2)([-\/\._])(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)([-\/\._])(0?2)([-\/\._])(29)$)|(^([3579][26]00)([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][0][48])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][0][48])([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][2468][048])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][2468][048])([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][13579][26])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][13579][26])([-\/\._])(0?2)([-\/\._])(29)$))/ig ;
		 
    	
//     	if(email.val()){
//         	if(!reg.test(email.val()))
//         	    {
//         	        alert("邮箱格式不对");
//         	        return false;
//         	    }
//     	}

//     	if(!reg_date.test(birthday))
//      	{
//      	    alert('请填写有效的生日！');
//      	    return false;
//      	}
//     	if(phone.val()){
//         	if(!regexp.test(phone.val()))
//         	{
//      		   alert ("电话号码不正确，请输入形如 区号+电话号码 的数字，如0901-2100222或010-11111111！");
//      		   return false;
//         	}
//     	}
//         if( !real_name.val() ){
//             alert(222);
//             alert("请填写真实姓名");
//             return false;
//             }else if(!real_name.val().match(/^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/)){
//             	alert("请填写正确的真实姓名");
//                 return false;
//             }
//         if(job.val() !== ''){
//              if(!job.val().match(/^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/)){
//                 	alert("职业不能乱填");
//                     return false;
//               }
//          }



    	return check;
        }
    </script>





