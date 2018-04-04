    

    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 11;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">投诉维权</div>
        	<form action="<?php echo site_url('member/complain/save');?>" method="post" id="myform" enctype="multipart/form-data">
            <div class="kehufuwu_00_con">
            	<h4>请填写以下内容：</h4>
           		<div class="kehufuwu_con_left ">
                	<ul>
                    	<li><label>投诉账号：<span class="kehufuwu_00_input"><?php echo $customer['name'];?></span>
                    	<input type="hidden"  name="username" value="<?php echo $customer['name'];?>" >
                    	</label></li>
                        <li><label>联系电话：<input type="text" name="contact" class="kehufuwu_00_input" value="" ></label></li>
                        <li><label>联系邮箱：<input type="text" name="email" class="kehufuwu_00_input" value="<?php echo $customer['email'];?>" ></label></li>
                        <li>
                        <label>投诉事由：

                        <label><input type="radio" name="complain_reason" value="1" class="kehufuwu_00_radio" >质量问题</label>
                        <label><input type="radio" name="complain_reason" value="2" class="kehufuwu_00_radio" >快递问题</label>
                        <label><input type="radio" name="complain_reason" value="3" class="kehufuwu_00_radio" >其他</label>
                        <input type="text" name="complain_reason_other" class="kehufuwu_00_input02" value="" ></label></li>
                        <li class="textareali">
                        	<label>事件描述：<textarea name="complain_desc" class="kehufuwu_00_textarea" cols="10" rows="10" placeholder="Your Message"></textarea></label>
                        </li>
                        <li>相关图片：<input class="control-label" name="file[]" type="file"></li>
                        
                    </ul>
                </div>
                <div class="kehufuwu_00_btn02"><a onclick="checkform()" >确定投诉</a></div>
                
                
            </div>
            </form>
            
        </div>



    </div>
    <script type="text/javascript">
function checkform()
{

	if(check())
	{
		$("#myform").submit();
	}
}

function check()
{
	var check = true;
	var contact = $("input[name=contact]");
	var email = $("input[name=email]");
	var desc = $("textarea[name=complain_desc]");
	var reason = $(':radio[name="complain_reason"]:checked');
	var reason_other = $("input[name=complain_reason_other]");

	if(contact.val()=='')
	{
		check = false;
		alert('联系方式不能为空。');
		contact.focus();
		return false;
	}

	if(email.val()=='')
	{
		check = false;
		alert('联系邮箱不能为空。');
		email.focus();
		return false;
	}


	if(reason.val()==3 && reason_other.val()=="")
	{
		alert('请填写其他投诉事由。');
		reason_other.focus();
		return false;
	}

	if(desc.val()=='')
	{
		check = false;
		alert('描述不能为空。');
		desc.focus();
		return false;
	}

	return check;
}

</script>



