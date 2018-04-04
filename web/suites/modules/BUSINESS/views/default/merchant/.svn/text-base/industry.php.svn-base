<?php 

//  判断用户是否登录
if (! $this->session->userdata('user_in')) {
    redirect('customer/login');
    exit();
}
?>

<script type="text/javascript" src="js/select2.js"></script>
<link rel="stylesheet" type="text/css" href="css/theme/select2.css">
<!--选择行业-->

     <div class="home_page">
        <div class="type_xuanz">
           <div class="type_xuanz_top">
               <ul class="step-case" id="step"> 
                    <li class="s-cur"><a href="javascript:;"><span>① 店铺类型/类目选择</span><b class="b-l"></b></a></li>
                    <li class="s-cur-next"><a href="javascript:;"><span>② 填写公司信息</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li><a href="javascript:;"><span>③ 上传资质</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li><a href="javascript:;"><span>④ 等待审核</span><b class="b-1"></b><b class="b-2"></b></a></li>
                    <li><a href="javascript:;"><span>⑤ 网上缴费、店铺上线</span><b class="b-1"></b><b class="b-2"></b><b class="b-r"></b></a></li> 
                </ul>
         </div>
         <div class="type_xuanz_zhong">店铺类型</div>
    
         <ul class="type_xuanz_wei">
          
         <?php foreach ( $cash_corp_info as $k=>$v ){?>
           
               <li item="<?php echo $k?>" onclick="hide_error(this)"  class="<?php echo  isset( $corporation_info['grade'] ) && $corporation_info['grade']  == $k ? 'active' : ''?>">
                 <div class="type_xuanz_wei_left"><img src="images/huangguan_<?php echo $k?>.png"/></div>
                 <div class="type_xuanz_wei_right">
                   <p><?php echo $v['name']?></p>
                   <h5><?php echo $v['cash'] / 10000?>万</h5>
                 </div>
                 <div class="yin_tubiao"></div>
               </li>
        <?php } ?>    
 
        </ul> 
         <script type="text/javascript">
           function hide_error(e)
           { 
              $("#span1").hide();
           }
         </script>
         <div class="type_xuanz_di">
           <ul class="type_xuanz_di_top">
           		 
                <!-- <li>会员/商家权益</li>-->
                 <li>会员服务内容</li>
                 <?php foreach ( $cash_corp_info as $k=>$v ){?>
                 <li><span><img src="images/huangguan_<?php echo $k?>.png"/></span><?php echo $v['name']?></li>
              
                 <?php }?>
           </ul>   
          
          <ul class="type_xuanz_di_bottom">
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>易货手续费</dd>
                     <dd>3%</dd>
                     <dd>4%</dd>
                     <dd>5%</dd>
                  </dl>
               </li>
                <li>
                  <dl class="type_xuanz_dl">
                     <dd>店铺模版定制</dd>
                     <dd>定制2套</dd>
                     <dd>定制1套</dd>
                     <dd>默认店铺模板</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>店铺模版更新</dd>
                     <dd>更新2次</dd>
                     <dd>更新1次</dd>
                     <dd>－</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>专属运营专员服务</dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                  </dl>
               </li>
                <li>
                  <dl class="type_xuanz_dl">
                     <dd>平台客服服务</dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>撮合交易服务</dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd>－</dd>
                    <dd>数据匹配</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>产品图拍摄</dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd>－</dd>
                    <dd>5款</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>培训指导</dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                     <dd><span class="icon-zhengque"></span></dd>
                  </dl>
               </li>
                <li>
                  <dl class="type_xuanz_dl">
                     <dd>专业美工设计服务-详情页制作</dd>
                     <dd>20款</dd>
                     <dd>10款</dd>
                     <dd>5款</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>专业美工设计服务-产品图</dd>
                     <dd>100张</dd>
                     <dd>50张</dd>
                     <dd>25张</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>专业美工设计服务-平台广告图</dd>
                     <dd>50张</dd>
                     <dd>30张</dd>
                     <dd>20张</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>营销推广服务-微信公众号精品推荐</dd>
                     <dd>5次</dd>
                     <dd>1次</dd>
                     <dd>1次</dd>
                  </dl>
               </li>
                <li>
                  <dl class="type_xuanz_dl">
                     <dd>营销推广服务-微信公众号会员风采报道</dd>
                     <dd>3次</dd>
                     <dd>1次</dd>
                     <dd>1次</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>营销推广服务-自有自媒体报道</dd>
                     <dd>3次</dd>
                     <dd>1次</dd>
                     <dd>1次</dd>
                  </dl>
               </li>
               <li>
                  <dl class="type_xuanz_dl">
                     <dd>营销推广服务-第三方联合推荐</dd>
                     <dd>1次</dd>
                     <dd>－</dd>
                     <dd>1次</dd>
                  </dl>
               </li>
          </ul>
         </div>
         
         <div class="type_xuanz_hanye">店铺选择行业</div>
          <div class="type_xuanz_input">
              <select   class="type_xuanz_input_rt " id="unit" name="Industrial_Info">
                    <option value="0">请选择您要添加的行业</option>
                    <?php if(isset($cor_ind) && count($cor_ind)>0): ?>
                      <?php foreach($cor_ind as $val):?>
                        <?php if( isset( $corporation_info['Industrial_Info'] ) &&  $val['id'] == $corporation_info['Industrial_Info'] ):?>
                        <option  value="<?php echo $val['id'] ?>" selected = "selected" ><?php echo $val['name'];?></option>
                      <?php else:?>
                        <option  value="<?php echo $val['id'] ?>"><?php echo $val['name'];?></option>
                      <?php endif;?>
                      <?php endforeach;?>
                  <?php endif;?>
              </select>
          </div>
          <div class="type_xuanz_xia">
             <a onclick="next()" href="javascript:;">下一步, 填写公司信息</a>
          </div>
        </div>
<script>
  var grade = '';
  grade = $(".active").attr("item");
  $(".type_xuanz_wei li").click(function(){
    $(this).toggleClass("active");
    $(this).siblings().removeClass("active");
    grade = $(".active").attr("item");
})
var Industrial_Info = '';

 

function next()
{
	
  //获取行业ID。
  var Industrial_Info = $('#unit').find("option:selected").val();
 
  if(!grade)
  {
      alert('请选择店铺类型');
      return false;
      
  }else if(!Industrial_Info || Industrial_Info == 0 ){
    
    alert("请选择行业");
	return false;
	
  }else{
	  
      window.location.href="<?php echo site_url("Corporation/information");?>/"+Industrial_Info+'/'+grade;
  }
}

$(".type_xuanz_input_rt ").change(function(){

  if($(".type_xuanz_input_rt ").val()){
    $("#span2").remove();
  }
});

</script>       