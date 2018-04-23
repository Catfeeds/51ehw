<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>接口测试页面</title>
<script type="text/javascript" src="../../../js/jquery-1.8.2.min.js"></script>
<style>
 li {list-style-type:none;}
</style>
</head>

<h2>接口测试页面</h2>

统一调用方式:
<table border="1" width="500px">
  <tr>
    <th>参数</th>
    <th>说明</th>
  </tr>
  <tr>
    <td>app_id</td>
    <td>商户号(接口方提供)</td>
  </tr>
  <tr>
    <td>app_key</td>
    <td>商户key值(接口方提供),(接口如果需要才传递)</td>
  </tr>
  <tr>
    <td>key</td>
    <td>调用需要登录状态下的接口必须传key(用户登录后返回的key值)</td>
  </tr>
  
</table>

<br/>

统一返回格式:
<table border="1" width="500px">
  <tr>
    <th>参数</th>
    <th>说明</th>
  </tr>
  <tr>
    <td>status</td>
    <td>状态码：具体根据每个接口而不同</td>
  </tr>
  <tr>
    <td>message</td>
    <td>返回信息：服务端会返回该参数，用于说明</td>
  </tr>
  <tr>
    <td>data</td>
    <td>返回数据(如果有返回数据就存在)</td>
  </tr>
</table>

<br/>

统一状态码
<table border="1" width="500px">
  <tr>
    <th>参数</th>
    <th>说明</th>
  </tr>
  <tr>
    <td>0</td>
    <td>调用成功</td>
  </tr>
  <tr>
    <td>-98</td>
    <td>缺少用户登录key值</td>
  </tr>
  
  <tr>
    <td>-99</td>
    <td>登录key值错误，或已过期重新登录</td>
  </tr>
  <tr>
    <td>-253</td>
    <td>调用接口缺少参数</td>
  </tr>
  <tr>
    <td>-254</td>
    <td>验证商户(调用方信息)失败</td>
  </tr>
  <tr>
    <td>-255</td>
    <td>请正确传递商户信息(调用方信息)进行验证</td>
  </tr>
</table>

<br/>

<select id="select_api">
    <option value="1">登录接口测试</option>
    <option value="2">注册接口测试</option>
    <option value="3">修改密码接口测试</option>
    <option value="4">忘记密码接口测试</option>
    <option value="5">修改个人信息接口测试</option>
    <option value="6">获取个人信息接口测试</option>
<!--     <option value="7">微信登录没有绑定手机号码绑定(未完成)-接口测试</option> -->
    <option value="8">验证用户名是否存在-接口测试</option>
<!--     <option value="9">微信openid登录-接口测试</option> -->
    <option value="10">退出登录-接口测试</option>
    <option value="11">发布广告扣除提货权-接口测试</option>
    <option value="12">获取商家信息-接口测试</option>
    <option value="13">用户的提货权转入与支出-接口测试</option>
    <option value="14">设置支付密码-接口测试</option>
    <option value="15">商家注册-接口测试</option>
    <option value="16">获取用户兑换排行-接口测试</option>
    <option value="17">获取商户兑出排行-接口测试</option>
    <option value="18">商家信息修改-接口测试</option>
    <option value="19">验证用户支付密码-接口测试</option>
    <option value="20">用户消费信息-接口测试</option>
    <option value="21">获取动态短信验证码-接口测试</option>
    <option value="22">检测验证码-接口测试</option>
</select><br/><br/>

<!-- 登录测试 -->
<div id="login" class="view">
<h3>登录</h3>
    <form action="<?php echo site_url('api_other/user/login')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户名：<input type="text" name="username"><br/><br/>
        密码：&nbsp;&nbsp;&nbsp;<input type="password" name="password"><br/><br/>
        <input type="submit" value="提交">
    </form>
</div>

<!-- 注册测试 -->
<div id="register" class="view" hidden>
    <h3>注册   --调用方式：post</h3>
    <form action="<?php echo site_url('api_other/user/register')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/> 
        手机号码：<input type="text" name="name" id="mobile"><br/><br/>
        昵称：&nbsp;&nbsp;&nbsp;<input type="text" name="nick_name"><br/><br/>
        密码：&nbsp;&nbsp;&nbsp;<input type="password" name="password"><br/><br/>
        短信验证码：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_vertify"><a href="javascript:vertify_mobile()">点击获取验证码</a>
        (调用的参数)： mobile:手机号, app_id:商户号(接口方提供) <br/><br/>
        短信验证key值：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_key"><br/>
        <input type="submit" value="注册">
    </form>
</div>

<!-- 修改密码测试 -->
<div id="update_pwd" class="view" hidden>
    <h3>修改密码</h3>
    <form action="<?php echo site_url('api_other/user/update_password')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        旧密码：&nbsp;&nbsp;&nbsp;<input type="text" name="password"><br/><br/>
        新密码：&nbsp;&nbsp;&nbsp;<input type="password" name="new_password"><br/><br/>
        用户登录key：&nbsp;&nbsp;&nbsp;<input type="text" name="key"><br/><br/>
        <input type="submit" value="修改">
    </form>
</div>

<!-- 忘记密码测试 -->
<div id="forget_password" class="view" hidden>
    <h3>忘记密码</h3>
    <form action="<?php echo site_url('api_other/user/forget_password')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户(手机号)：<input type="text" name="name" ><br/><br/>
        短信验证码：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_vertify"><a href="javascript:vertify_mobile(1)">点击获取验证码</a>
        (调用的参数)： mobile:手机号, app_id:商户号(接口方提供), status = 1
        <br/><br/>
        输入新密码：<input id="pass1" name="password" class="phone_hao" value="" type="password"><br/><br/>
        输入新确认密码：<input id="pass1" name="new_password" class="phone_hao" value="" type="password"><br/><br/>
        短信验证key值：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_key"><br/><br/>
        <input type="submit" value="下一步">
    </form>
</div>


<!-- 修改用户信息测试 -->
<div id="info_edit" class="view" hidden>
    <h3>修改个人信息</h3>
    <form action="<?php echo site_url('api_other/user/update_user')?>" method="post">
      <ul>
            <li>商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/></li>
		    <li>昵称：<input class="gerenzhongxin_01_con_input" name="nick_name" value="123456" placeholder="请输入昵称" type="text"></li>
			<li>性别：<label class="gerenzhongxin_01_lable"><input class="gerenzhongxin_01_radio" name="sex" value="0" checked="" type="radio">女</label> <label class="gerenzhongxin_01_lable"><input class="gerenzhongxin_01_radio" name="sex" value="1" type="radio">男</label></li>
			<li>职业：<input name="job" class="gerenzhongxin_01_con_input" placeholder="请输入您的职业" value="" type="text"></li>
			<li>电子邮件：<input id="consignee_email" onblur="check_email()" name="email" value="" class="gerenzhongxin_01_con_input" placeholder="请输入您邮箱" type="text"></li>
			<li><span>*</span>真实姓名：<input class="gerenzhongxin_01_con_input" name="real_name" value="" placeholder="请输入真实姓名" type="text"></li>
			<li>固定电话：<input id="consignee_message" onblur="check_message()" name="phone" value="" class="gerenzhongxin_01_con_input" placeholder="请输入固定电话号码" type="text"></li>
	        <li>用户登录key：&nbsp;&nbsp;&nbsp;<input type="text" name="key"></li>
	  </ul>
        <input type="submit" value="修改资料">
    </form>
</div>



<!-- 获取用户信息测试 -->
<div id="user_detaile" class="view" hidden>
    <h3>获取个人信息</h3>
    <form action="<?php echo site_url('api_other/user/user_detaile')?>" method="post">
         商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
         用户登录key：&nbsp;&nbsp;&nbsp;<input type="text" name="key"><br/><br/>
        <input type="submit" value="登录状态下点击获取信息">
    </form>
</div>


<div id="binding_mobile" class="view" hidden>
    <h3>微信登录没有绑定手机号码绑定</h3>
    <form action="<?php echo site_url('api_other/user/binding_mobile')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        手机号码(用户名)：<input type="text" name="name"><br/><br/>
        登录密码：<input type="text" name="name"><br/><br/>
        支付密码(用户名)：<input type="text" name="name"><br/><br/>
        短信验证码：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_vertify"><a href="javascript:vertify_mobile(1)">点击获取验证码</a><br/><br/>
        <input type="submit" value="绑定">
    </form>
</div>


<!-- 验证用户是否存在测试 -->
<div id="verify_name" class="view" hidden>
    <h3>验证用户名是否存在</h3>
    <form action="<?php echo site_url('api_other/user/check_name')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        手机号码(用户名)：<input type="text" name="name"><br/><br/>
        <input type="submit" value="验证">
    </form>
</div>


<!-- 微信登录 -->
<!-- <div id="wechat_login" class="view" hidden> -->
<!--     <h3>根据微信openid获取用户信息</h3> -->
<!--    <form action="<?php // echo site_url('api_other/user/wechat_login')?>" method="post"> -->
<!--         商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/> -->
<!--         微信openid：<input type="text" name="openid"><br/><br/> -->
<!--         <input type="submit" value="登录"> -->
<!--     </form> -->
<!-- </div> -->


<!-- 退出登录测试 -->
<div id="logout" class="view" hidden>
<h3>退出登录</h3>
    <form action="<?php echo site_url('api_other/user/logout')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户登录key：<input type="text" name="key"><br/><br/>
        <input type="submit" value="提交">
    </form>
</div>



<!-- 发布广告 -->
<div id="purchase" class="view" hidden>
    <h3>发布广告扣除提货权</h3>
    <h3>说明：平台方需提供给接口方->平台方在易货网中的用户ID,以及店铺ID做为平台方收入账户</h3><br />
    <form action="<?php echo site_url('api_other/user/purchase')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户登录key：<input type="text" name="key"><br/><br/>
        用户(商家)支付密码：<input type="text" name="pay_password"><br/><br/>
        订单编号(唯一)：<input type="text" name="order_sn"><br/><br/>
        订单金额：<input type="text" name="total_price" value=""><br/><br/>
        <input type="submit" value="提交">
    </form>
</div>

<!-- 获取商家信息 -->
<div id="corporation_info" class="view" hidden>
    <h3>获取商家信息</h3>
    <form action="<?php echo site_url('api_other/user/corporation_info')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        店铺ID：<input type="text" name="corporation_id"><br/><br/>
       <input type="submit" value="提交">
    </form>
</div>

<!-- 用户获得平台赠送的提货权 -->
<div id="give_m" class="view" hidden>
    <h3>用户的提货权转入与支出</h3>
    <form action="<?php echo site_url('api_other/user/give_voucher')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        商户key(接口方提供)：<input type="text" name="app_key" value=""><br/><br/>
        支出方用户ID <input type="text" name="expend_customer_id" value=""><br/><br/>
        支出方支付密码：<input type="text" name="pay_password" value=""><br/><br/>
        收入方用户ID：<input type="text" name="to_customer_id"><br/><br/>
        提货权数量：<input type="text" name="M_voucher"><br/><br/>
       <input type="submit" value="提交">
    </form>
</div>

<!-- 设置支付密码 -->
<div id="set_pay_password" class="view" hidden>
    <h3>设置支付密码</h3>
    <form action="<?php echo site_url('api_other/user/set_pay_password')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户登录key：<input type="text" name="key" value=""><br/><br/>
        用户绑定的手机号码:<input type="text" name="mobile" value=""><br/><br/>
        新支付密码：<input type="text" name="pay_password" value=""><br/><br/>
        短信验证码：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_vertify"><a href="javascript:vertify_mobile(2)">点击获取验证码</a>
        (调用的参数)： mobile:手机号, app_id:商户号(接口方提供), status = 2<br/><br/>
        短信验证key值：&nbsp;&nbsp;&nbsp;<input type="text" name="mobile_key"><br/><br/>
       <input type="submit" value="提交">
    </form>
</div>

<!-- 商家注册 -->
<div id="corp_register" class="view" hidden>
    <h3>商家注册</h3>
    <form action="<?php echo site_url('api_other/user/corporation_register')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        手机号码(用户名)：<input type="text" name="name" value=""> :如果用户已经注册过商家将无法注册<br/><br/>
        密码：<input type="password" name="password" value="">   :如果用户存在->普通用户->该密码将覆盖之前的密码。<br/><br/> 
       
        企业名称:<input type="text" name="corporation_name" value=""><br/><br/>
        --------------------------------------------<br/>
        企业地址：<select name="province_id"  class="province_id"><option value="1" >省份</option></select> <select name="city_id" class="city_id" ><option value="2" >城市</option></select> <select name="district_id" class="district_id" ><option value="3">县/区</option></select><br/><br/>
        <input type="text" name="address" value="" placeholder="具体街道位置"><br/><br/>
        调用地址(测试)：http://test51ehw.9-leaf.com/api_other/user/show_region
        <br/><br/>
        获取省
        无需传参
        <br/><br/>
        获取市
        参数：parent_id = 省份的region_id, status = 1;
        <br/><br/>
        获取县区
        参数: parent_id = 市的region_id,  status = 2;
        <br/>--------------------------------------------
         <br/><br/>
        
        企业行业：<select class="corporation_ind_info" name="industry"><option value="">行业</option></select> <br/><br/>
        企业性质：<select class="corporation_type" name="nature"><option value="">性质</option></select> <br/><br/>
        获取企业行业&&企业性质<br/><br/>
        获取行业 -参数 ： status = 1;<br/><br/>
        获取性质 -参数 ： status = 2;<br/><br/>
        调用方式：http://test51ehw.9-leaf.com/api_other/user/corporation_ind_info<br/>
        --------------------------------------------
        <br/><br/>
        企业法人：<input type="text" name="legal_person" value=""><br/><br/>
        身份证号：<input type="text" name="idcard" value=""><br/><br/>
        工商注册号：<input type="text" name="company_registration" value=""><br/><br/>
        企业邮编：<input type="text" name="postcode" value=""><br/><br/>
        企业邮箱：<input type="text" name="email" value=""><br/><br/>
        店铺图标：<input type="text" name="img_url" placeholder="http://图片链接"><br/><br/>
        店铺管理员：<input type="text" name="contact_name" value=""><br/><br/>
        店铺联系方式：<input type="text" name="contact_mobile" value=""><br/><br/>
        营业执照：<input type="text" name="bus_licence_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;"><br/><br/>
        法人身份证复印件（正反面）：<input type="text" name="idcard_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;"><br/><br/>
        法人授权委托书：<input type="text" name="proxy_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;"><br/><br/>
       <input type="submit" value="提交">
    </form>
</div>


<!-- 商家信息修改 -->
<div id="corp_update" class="view" hidden>
    <h3>商家信息修改</h3>
    <form action="<?php echo site_url('api_other/user/corp_update')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        用户登录key：<input type="text" name="key" value=""><br/><br/>
       
        --------------------------------------------<br/>
        企业地址：<select name="province_id"  class="province_id"><option value="1" >省份</option></select> <select name="city_id" class="city_id" ><option value="2" >城市</option></select> <select name="district_id" class="district_id" ><option value="3">县/区</option></select><br/><br/>
        <input type="text" name="address" value="" placeholder="具体街道位置"><br/><br/>
        调用地址(测试)：http://test51ehw.9-leaf.com/api_other/user/show_region
        <br/><br/>
        获取省
        无需传参
        <br/><br/>
        获取市
        参数：parent_id = 省份的region_id, status = 1;
        <br/><br/>
        获取县区
        参数: parent_id = 市的region_id,  status = 2;
        <br/>--------------------------------------------
         <br/><br/>
        
        企业行业：<select class="corporation_ind_info" name="industry"><option value="">行业</option></select> <br/><br/>
        企业性质：<select class="corporation_type" name="nature"><option value="">性质</option></select> <br/><br/>
        获取企业行业&&企业性质<br/><br/>
        获取行业 -参数 ： status = 1;<br/><br/>
        获取性质 -参数 ： status = 2;<br/><br/>
        调用方式：http://test51ehw.9-leaf.com/api_other/user/corporation_ind_info<br/>
        --------------------------------------------
        <br/><br/>
        企业邮编：<input type="text" name="postcode" value=""><br/><br/>
        企业邮箱：<input type="text" name="email" value=""><br/><br/>
        店铺图标：<input type="text" name="img_url" placeholder="http://图片链接">空则不修改<br/><br/>
        店铺管理员：<input type="text" name="contact_name" value=""><br/><br/>
        店铺联系方式：<input type="text" name="contact_mobile" value=""><br/><br/>
        营业执照：<input type="text" name="bus_licence_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;">空则不修改<br/><br/>
        法人身份证复印件（正反面）：<input type="text" name="idcard_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;">空则不修改<br/><br/>
        法人授权委托书：<input type="text" name="proxy_img" value="" placeholder="http://图片链接 多张用分号分隔" style="width: 200px;">空则不修改<br/><br/>
       <input type="submit" value="提交">
    </form>
</div>


<!-- 获取用户兑换排行 -->
<div id="user_convert_list" class="view" hidden>
    <h3>获取用户兑换排行</h3>
    <form action="<?php echo site_url('api_other/user/user_convert_list')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        参数：&nbsp;&nbsp;&nbsp;<input type="text" name="status"> 参数status 1=月，2=周，空=累计<br/><br/>
        页数：<input type="text" name="page"> 不传默认1页<br/><br/>
        条数：<input tyoe="text" name="limit"> 不传默认显示10条<br/><br/>
       <input type="submit" value="提交">
    </form>
</div>


<!-- 获取商家兑出排行 -->
<div id="corporation_sell_list" class="view" hidden>
    <h3>获取商家兑出排行</h3>
    <form action="<?php echo site_url('api_other/user/corporation_sell_list')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        参数：&nbsp;&nbsp;&nbsp;<input type="text" name="status"> 参数status 1=月，2=周，空=累计<br/><br/>
        页数：<input type="text" name="page"> 不传默认1页<br/><br/>
        条数：<input tyoe="text" name="limit"> 不传默认显示10条<br/><br/>
       <input type="submit" value="提交">
    </form>
</div>


<!-- 验证用户支付密码 -->
<div id="verify_pay_password" class="view" hidden>
    <h3>验证用户支付密码</h3>
    <form action="<?php echo site_url('api_other/user/verify_pay_password')?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        登录key:<input type="text" name="key"> <br/><br/>
        支付密码:<input type="text" name="pay_password"><br/><br/>
       <input type="submit" value="提交">
    </form>
</div>


<!-- 用户消费信息 -->
<div id="convert_info" class="view" hidden>
    <h3>用户消费信息</h3>
    <form action="<?php echo site_url('api_other/user/convert_info');?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        返回条数:<input type="text" name="limit"> 不传默认10条<br/><br/>
       <input type="submit" value="登陆">
    </form>
</div>

<!-- 获取短信验证码 -->
<div id="obtain_code" class="view" hidden>
    <h3>获取短信验证码</h3>
    <form action="<?php echo site_url('api_other/user/ajax_send');?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        验证事件状态:<input type="text" name="status" value="6"><br/><br/>
        手机号码:<input type="text" name="mobile"><br/><br/>
       <input type="submit" value="获取">
    </form>
</div>

<!-- 检测验证码 -->
<div id="verify_code" class="view" hidden>
    <h3>用户消费信息</h3>
    <form action="<?php echo site_url('api_other/user/verify_code');?>" method="post">
        商户号(接口方提供)：<input type="text" name="app_id" value="ehw0000001xx"><br/><br/>
        验证码：<input type="text" name="code"><br/><br/>
        验证码key值：<input type="text" name="code_key" ><br/><br/>
        手机号码：<input type="text" name="mobile"><br/><br/>
        验证事件状态:<input type="text" name="status" value="6"><br/><br/>
       <input type="submit" value="验证">
    </form>
</div>
<body>

<script type="text/javascript">
$("#select_api").change(function () {  
     $('.view').hide();
	 var choose = $(this).find("option:selected").val();  
	 
	 switch(choose){ 
	 
    	 case '1':
    		 $('#login').show();
    		 break;
    	 case '2':
    		 $('#register').show();
    		 break;
    	 case '3':
    		 $('#update_pwd').show();
    		 break;
    	 case '4':
    		 $('#forget_password').show();
    		 break;
    	 case '5':
    		 $('#info_edit').show();
    		 break;
    	 case '6':
    		 $('#user_detaile').show();
    		 break;
    	 case '7':
    		 $('#binding_mobile').show();
    		 break;
    	 case '8':
    		 $('#verify_name').show();
    		 break;
    	 case '9':
    		 $('#wechat_login').show();
    		 break;
    	 case '10':
    		 $('#logout').show();
    		 break;
    	 case '11':
    		 $('#purchase').show();
    		 break;
    	 case '12':
    		 $('#corporation_info').show();
    		 break;
    	 case '13':
    		 $('#give_m').show();
    		 break;
    	 case '14':
    		 $('#set_pay_password').show();
    		 break;
    	 case '15':
    		 select_corp();
    		 select_province();
    		 $('#corp_register').show();
    		 break;
    	 case '16':
    		 $('#user_convert_list').show();
    		 break;
    	 case '17':
    		 $('#corporation_sell_list').show();
    		 break;
    	 case '18':
    		 select_corp();
    		 select_province();
    		 $('#corp_update').show();
    		 break;
    	 case '19':
    		 $('#verify_pay_password').show();
    		 break;
    	 case '20':
        	 $('#convert_info').show();
        	 break;
    	 case '21':
        	 $('#obtain_code').show();
        	 break;
    	 case '22':
        	 $('#verify_code').show();
        	 break;
	 }
}); 

function vertify_mobile(status,type){
	if(!status)
	    status = '';

    if(status == 1){ //忘记密码
        var mobile = $('#forget_password').find('input[name=name]').val();
    }else if( status == 2){ 
        
    	//设置支付密码
    	var mobile = $('#set_pay_password').find('input[name=mobile]').val();
    	
    	if(!mobile){
        	alert('请输入手机号');
        	return;
    	}
        
        }else{
             
            //注册
        	var mobile = $('#register').find('input[name=name]').val() ? $('#register').find('input[name=name]').val() : $('#corp_register').find('input[name=name]').val()
        	
        	if(!mobile){
            	alert('请输入手机号');
            	return;
        	}
    }
    
    $.ajax({
	    url: '<?php echo site_url('/api_other/user/ajax_send')?>',
	    type: 'POST',
	    data:{'mobile':mobile,'app_id':'ehw0000001xx','status':status},
	    dataType: 'json',
	    success: function(data){

		    if(!status){ 
			    
		    	if(data.status == 0){
    			    alert('发送成功');
        	        $('#register').find('input[name=mobile_key]').val(data.key);
        	        
    		    }
    		    
			}else if(status == 1){

    		    if(data.status == 0){
    			    alert('发送成功');
        	        $('#forget_password').find('input[name=mobile_key]').val(data.key);
    		    }
			}else if(status == 2){ 

				if(data.status == 0){
    			    alert('发送成功');
        	        $('#set_pay_password').find('input[name=mobile_key]').val(data.key);
        	        
    		    }
			}
	    }
	});
}

//获取行业 && 性质
function select_corp(){ 
	
	$.ajax({
	    url: '<?php echo site_url('/api_other/user/corporation_ind_info')?>',
	    type: 'POST',
	    data:{'app_id':'ehw0000001xx'},
	    dataType: 'json',
	    success: function(data){

	    	//行业
	    	var select_industry = data['data']['corporation_ind_info'];
		    //性质
		    var select_nature = data['data']['corporation_type'];

		    
	        for(var i =0 ; i<select_industry.length; i++){ 
		        
	            $('.corporation_ind_info').append('<option value='+select_industry[i].id+'>'+select_industry[i].name+'</option>');
			}

		    //性质
	        for(var i =0 ; i<select_nature.length; i++){ 
		        
	            $('.corporation_type').append('<option value='+select_nature[i].id+'>'+select_nature[i].name+'</option>');
			}
	    }
	});
}

//获取省份
function select_province( parent_id,status ){ 
	
	$.ajax({
	    url: '<?php echo site_url('/api_other/user/show_region')?>',
	    type: 'POST',
	    data:{'app_id':'ehw0000001xx','status':status,'parent_id':parent_id},
	    dataType: 'json',
	    success: function(data){

	    	switch( status ){
    	    	case 1: //市
    	    		$('.city_id').append('<option>城市</option>');
    	    		$('.district_id').append('<option>县/区</option>');
    	    	    select_id = '.city_id';
  	    		    break;
    	    	case 2: //县区
    	    		$('.district_id').append('<option>县/区</option>');
    	    	    select_id = '.district_id';
    	    	    break;

        	    default:
    		    	select_id = '.province_id';
        	        break;
	    	}

	    	for(var i =0 ; i<data['data'].length; i++){ 
  		    	
	            $(select_id).append('<option value='+data['data'][i].region_id+'>'+data['data'][i].region_name+'</option>');
			}
			
	    }
	});
}



$('.province_id').change(function(){
	var parent_id = $(this).find("option:selected").val(); 
	$('.district_id').empty();
	$('.city_id').empty();
	select_province(parent_id,1);
	
 });

$('.city_id').change(function(){
	var parent_id = $(this).find("option:selected").val(); 
	$('.district_id').empty();
	select_province(parent_id,2);
	
 });

function test_login(){ 
	$.ajax({
		    url: 'http://test51ehw.9-leaf.com/index.php/api_other/user/redirect_index',
		    type: 'POST',
		    data:{'app_id':'ehw0000001xx','key':'942c767ad00a41651945dcf734526d9f'},
		    dataType: 'jsonp',
		    success: function(data){

		    	if(data['status'] == 0){ 
		    		window.location = "http://test51ehw.9-leaf.com/index.php/";
			    }

		    }
		});
}
</script>