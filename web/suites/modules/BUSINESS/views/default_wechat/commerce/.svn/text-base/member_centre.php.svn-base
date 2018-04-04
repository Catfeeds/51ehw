<!-- 会员中心 -->
<div class="member_centre">
  <div class="member_centre_text">
    <p>新会员入会所需提供的资料具体包括：</p>
    <p>①企业营业执照副本的复印件，加盖公司公章；</p>
    <p>②本人身份证复印件和联系人身份证复印件；</p>
    <p>③本人的个人简历一份；</p>
    <p>④公司简介一份；</p>
    <p>⑤本人的1寸照片2张及1张电子版生活照片；</p>
    <p>⑥填写完整入会申请表。</p>
    <p><span>备注：</span>请在入会登记表中承诺人和入会人签名需用手写体签字。</p>
  </div>  
  <form action="<?php echo site_url("Commerce/index/{$label_id}"); ?>" method="post" enctype="multipart/form-data" id="form1" onsubmit ='return false;'>
  <!-- 填写资料 -->
  <div class="member_centre_means">
    <!-- 姓名 -->
    <div class="member_centre_input"><span>姓名</span><p><input type="text"   name='m_name' maxlength="15"  placeholder="请输入姓名"></p></div>
    <!-- 性别 -->
    <div class="member_centre_input"><span>性别</span><p class="member_centre_select"><select name='sex' ><option>性别</option><option value='1' >男</option><option value='2'>女</option></select><em class="icon-xiala"></em></p></div>
    <!-- 身份证号 -->
    <div class="member_centre_input"><span>身份证号</span><p><input onkeyup="value=value.replace(/[\W]/g,'')" type="tel" name="card_id" maxlength="18" placeholder="请输入身份证号"></p></div>
    <!-- 出生年月 -->
    <div class="member_centre_input"><span>出生年月</span>
       <p class="member_centre_select margin_right5"><select name="sel1" id="sel1" ><option value="year">年份</option></select><em class="icon-xiala"></em></p>
       <p class="member_centre_select"><select name="sel2" id="sel2"  ><option value="month" >月份</option></select><em class="icon-xiala"></em></p>
    </div>
    <!-- 工作职务 -->
    <div class="member_centre_input"><span>工作职务</span><p><input type="text"  name="duty" maxlength="12" placeholder="请输入工作职务"></p></div>

    <!-- 籍贯 -->
    <div class="member_centre_input"><span>籍贯</span>
        <?php
          $data ['other_type'] = true;
          $data ['province_selected'] = 0;
          $data ['city_selected'] = 0;?>
        <?php $this->load->view('widget/district_select',$data); ?>
    </div>
    <!-- 民族 -->
    <div class="member_centre_input"><span>民族</span><p><input type="text"  name="nation" maxlength="10" placeholder="请输入民族"></p></div>
    <!-- 文化程度 -->
    <div class="member_centre_input"><span>文化程度</span><p class="member_centre_select"><select name="education"> <option>文化程度</option><option>博士</option><option>研究生</option><option>本科</option><option>大专</option><option>高中</option><option>初中</option><option>小学</option></select><em class="icon-xiala"></em></p></div>
    <!-- 政治面貌 -->
    <div class="member_centre_input"><span>政治面貌</span><p class="member_centre_select"><select name="political_status"><option>政治面貌</option><option>中共党员</option><option>团员</option><option>群众</option></select><em class="icon-xiala"></em></p></div>
    <!-- 社会职务 -->
    <div class="member_centre_input"><span>社会职务</span><p><input type="text" name ='social_duty' maxlength="12" placeholder="请输入社会职务"></p></div>
    <!-- 个人简介 -->
    <div class="member_centre_input"><span>个人简介</span><p class="member_centre_textarea"><textarea id ='resume' name="resume" maxlength="100" placeholder="文字介绍"></textarea></p></div>
    <!-- 单位名称 -->
    <div class="member_centre_input"><span>单位名称</span><p><input type="text"  name="company" maxlength="20" placeholder="请输入单位名称"></p></div>
    <!-- 联系地址 -->
    <div class="member_centre_input"><span>联系地址</span><p><input type="text" name="address" maxlength="30" placeholder="请输入联系地址"></p></div>
    <!-- 手机 -->
    <div class="member_centre_input"><span>手机</span><p><input type="tel" onkeyup="this.value=this.value.replace(/\D/g,'')" name="phone" maxlength="11" placeholder="请输入手机号码"></p></div>
    <!-- E-mail -->                   
    <div class="member_centre_input"><span>E-mail</span><p><input type="text" name="email" maxlength="20" placeholder="请输入E-mail"></p></div>
    <!-- 入会岗位 -->
    <div class="member_centre_input"><span>入会岗位</span><p class="member_centre_select">
        <select name="m_duty">
            <option>入会岗位</option>
            <option>执行副会长</option>
            <option>副会长</option>
            <option>常务理事</option>
            <option>理事</option>
        </select>
    <em class="icon-xiala"></em>
    </p>
    </div>
    <!-- 企业情况 -->
    <div class="member_centre_input"><span>企业情况</span><p class="member_centre_textarea"><textarea id = 'comany_detail' name="comany_detail" maxlength="100" placeholder="成立时间/注册时间/职工人数/现有资产/经营范围..."></textarea></p></div>
  </div>

  <!-- 提交 -->  <!-- 资料全部填完后改变按钮的背景颜色  background-color: #FECF0A;border: 1px solid #FECF0A; -->
  <div class="member_centre_button"><a href="javascript:void(0);" onclick="submits();">提交</a></div>
</form>

</div>


<script type='text/javascript' src='js/jquery.form.js'></script>
<script src="js/verification.js"></script>
<script type="text/javascript">

function submits(){
	var real_name = $('input[name="m_name"]').val();
	if(!real_name || real_name == ''){
		$(".black_feds").text("请输入正确的姓名").show();
		setTimeout("prompt();", 2000);
		return false;
		}else if(!isChinaName(real_name) ){
			$(".black_feds").text("请输入正确的姓名").show();
			setTimeout("prompt();", 2000);
			return false;
			}

	var sex = $('select[name="sex"]').val();
	if(!sex || sex == '' || sex == '性别' ){
		$(".black_feds").text("请选择性别").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	
	var card_id = $('input[name="card_id"]').val();
    if(!card_id || card_id == ''){
    	$(".black_feds").text("请输入正确的身份证").show();
		setTimeout("prompt();", 2000);
		return false;
        }else if(!isCardNo(card_id) ){
        	$(".black_feds").text("请输入正确的身份证").show();
    		setTimeout("prompt();", 2000);
    		return false;
        }
	
	var year = $("#sel1").val();
	if(year == 'year'){
		$(".black_feds").text("请选择年份").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var month = $("#sel2").val();
	if(month == 'month'){
		$(".black_feds").text("请选择月份").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var duty = $('input[name="duty"]').val();
	if(!duty){
		$(".black_feds").text("请输入工作职务").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var province_id = $("#province_id").val();
	if(province_id == -1){
		$(".black_feds").text("请选择籍贯").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var city_id = $("#city_id").val();
	if(city_id == -11 || !city_id){
		$(".black_feds").text("请选择城市").show();
		setTimeout("prompt();", 2000);
		return false;
		}

	var nation = $('input[name="nation"]').val();
	if(!nation){
		$(".black_feds").text("请输入民族").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	
	var education = $('select[name="education"]').val();
	if(!education || education == '文化程度' ){
		$(".black_feds").text("请选择文化程度").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	
	var political_status = $('select[name="political_status"]').val();
	if(!political_status || political_status == '政治面貌' ){
		$(".black_feds").text("请选择政治面貌").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	
	var social_duty = $('input[name="social_duty"]').val();
	if(!social_duty ){
		$(".black_feds").text("请输入社会职务").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var resume = $('#resume').val();
	if(!resume ){
		$(".black_feds").text("请输入个人简介").show();
		setTimeout("prompt();", 2000);
		return false;
		}

	var company = $('input[name="company"]').val();
	if(!company){
		$(".black_feds").text("请输入单位名称").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var address = $('input[name="address"]').val();
	if(!address){
		$(".black_feds").text("请输入联系地址").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var phone = $('input[name="phone"]').val();
	if(!phone || !checkMobile(phone)){
		$(".black_feds").text("请输入正确的手机号").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var email = $('input[name="email"]').val();
	if(!email){
		$(".black_feds").text("请输入邮箱").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var m_duty = $('select[name="m_duty"]').val();
	if(!m_duty ||  m_duty== '入会岗位'){
		$(".black_feds").text("请输入入会岗位").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	var comany_detail = $('#comany_detail').val();
	if(!comany_detail ){
		$(".black_feds").text("请输入企业情况").show();
		setTimeout("prompt();", 2000);
		return false;
		}
	
	$('#form1').ajaxSubmit({
  	    url: '<?php echo site_url("Commerce/ajax_PostUser");?>',
    	type: 'POST',
    	cache: false,
    	processData: false,
      	dataType:  'json', //数据格式为json 
      	data:{"app_label_id":<?php echo $label_id;?>},
  		success: function(data) {
  			if( data.status)
  	    	{ 
  	    		$(".black_feds").text(data.Msg).show();
  	    		setTimeout("prompt();", 2000);
  	    		setTimeout(function(){
					window.location.href = '<?php echo site_url("Commerce/index/{$label_id}")?>';
  	  	    		}, 2000);
  	        	return false;
  	    	}else{ 
  	    		$(".black_feds").text('提交失败，请重试').show();
  	    		setTimeout("prompt();", 2000);
  	    		return false;
  	    	}
  	  	},
  	  	error:function(xhr){ //上传失败 
  	 		$(".black_feds").text('网络错误，提交失败').show();
  	 		setTimeout("prompt();", 2000);
  	  	}
        });
}



    //生成日期
   function creatDate()
   {
     //生成1900年-2100年
     for(var i = 2018; i >= 1950; i--)
     {
       //创建select项
       var option = document.createElement('option');
       option.setAttribute('value',i);
       option.innerHTML = i;
       sel1.appendChild(option);
     }
     //生成1月-12月
     for(var i = 1; i <=12; i++){
       var option1 = document.createElement('option');
       option1.setAttribute('value',i);
       option1.innerHTML = i;
       sel2.appendChild(option1);
     }
     //生成1日—31日
     for(var i = 1; i <=31; i++){
       var option2 = document.createElement('option');
       option2.setAttribute('value',i);
       option2.innerHTML = i;
     }
   }
   creatDate();
   //保存某年某月的天数
   var days;
   //年份点击 绑定函数
   sel1.onclick = function()
   {
     //月份显示默认值
     sel2.options[0].selected = true;
   }
   //月份点击 绑定函数
   sel2.onclick = function()
   {
     //计算天数的显示范围
     //如果是2月
     if(sel2.value == 2)
     {
       //判断闰年
       if((sel1.value % 4 === 0 && sel1.value % 100 !== 0) || sel1.value % 400 === 0)
       {
         days = 29;
       }
       else
       {
         days = 28;
       }
       //判断小月
     }else if(sel2.value == 4 || sel2.value == 6 ||sel2.value == 9 ||sel2.value == 11){
       days = 30;
     }else{
       days = 31;
     }
   }


</script>










