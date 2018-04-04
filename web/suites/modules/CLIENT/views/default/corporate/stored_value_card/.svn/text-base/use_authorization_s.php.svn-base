  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
   <div class="toubu_ding">
    	<ul>
    		<li><a href="#">我是承兑商</a></li>
            <li><a href="#">我是销售商</a></li>
            <li class="hui_yanse"><a href="#">我是购买方</a></li>
    	</ul>
    </div>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
           <div class="downTittle manage_new_downTittle menu_manage_downTittle">我是购买方</div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul> 
                    <li ><a href="#">我的线上储值卡</a></li>
                	<li class="houtai_zijin_current"><a href="#">使用授权管理</a></li>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">使用授权</div>
            <div class="stored_chongg">
               <ul class="stored_chong_ull">
                 <li><span>用户名：</span>铲屎官</li>
                 <li><span>手机号：</span><a href="javascript:;" class="stored_chong_ul_a" id="buluo">请选择</a></li>
                 <li><span>昵称：</span>二哈</li>
                 <li><span>线上储值卡名称：</span>丽枫酒店线上储值卡1</li>
                 <li><span>线上储值卡期限：</span>2016-11-01至2017-11-01</li>
                 <li><span>储值卡余额：</span>6000货豆</li>
                 <li class="stored_chong_ull_li"><span>授权金额：</span><input type="text" class="n" name="search_name" value="" placeholder="请输入授权金额"></li>
                 <li class="stored_chong_ull_li"><span>申请有效期：</span><input type="text" value="" class="stored_input" name="grant_start_at" onclick="WdatePicker()" readonly><samp class="stored_input_samp">至</samp><input type="text" value="" class="stored_input" name="grant_end_at" onclick="WdatePicker()" readonly></li>
               </ul>
          
               
               <div class="stored_chong_bottom">
                 <a href="#" class="stored_chong_left">确认授权</a>
                 <a href="#" class="stored_chong_rigth1">返回</a>
               </div>
               
            </div>  
            
            
            
            <div class="tribal_goods" id="tribal_goods" style="display: none;">
        <div class="tribal_goods_top" style="width:400px; height:180px; margin-left:-200px; margin-top:-90px;">
        <h1>搜索账号<i class="huisr" onclick="huisr();" style="font-size:26px; text-align:right; float:right; margin-right:8px; cursor:pointer; margin-top:-3px; font-weight:normal">x</i></h1>
         <div class="tribal_goods_zhong">
            <ul style="width:330px;">
               <li><span style="text-align:left">按手机搜索</span></li>
              <li><input type="text" class="n" name="search_name" value="" style="border:1px solid #fe4a00;"><a class="tribal_goods_a" href="#">搜索</a></li>
            </ul>
         </div>
        </div>
    </div>

            
            
            
         </div>
       <!--右边结束-->    
         </div>



     


<script>

//上传图片预览
function previewImg(input,obj) {
    if(input.files && input.files[0]) {
        var reader = new FileReader(),
            img = new Image();       
        reader.onload = function (e) {
            if(input.files[0].size>307200){//图片大于300kb则压缩
                img.src = e.target.result;
                img.onload=function(){
                    $(obj).attr('src', compress(img));
						$("#thubm").css("width","120");
						$("#thubm").css("height","120");
                }
            }else{
                $(obj).attr('src', e.target.result);
				$("#thubm").css("width","120");
				$("#thubm").css("height","120");
				
            }
        }
        reader.readAsDataURL(input.files[0]);
        return 1;
    }  
}


//压缩图片函数
function compress(img) {
    var initSize = img.src.length;
    var width = img.width;
    var height = img.height;
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
    var ratio;
    if ((ratio = width * height / 4000000)>1) {
        ratio = Math.sqrt(ratio);
        width /= ratio;
        height /= ratio;
    }else {
        ratio = 1;
    }
    canvas.width = width;
    canvas.height = height;
    //铺底色
    ctx.fillStyle = "#fff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0, width, height);
    //进行最小压缩
    var ndata = canvas.toDataURL("image/jpeg", 0.1);
    console.log(ndata.length)
    canvas.width = canvas.height = 0;
    return ndata;
}




$(document).ready(function() {
    	$('#thubm').hover(
			function(){
				$('#xianshudwfn').show();
			},
			function(){
				$('#xianshudwfn').hover(function(){},function(){
					$('#xianshudwfn').hide();
				})
			}
		);
	});
		
	 $(".icon-cha").click(function (){
		 $('#xianshudwfn').hide();
		 $('#thubm').hide();
		 })
	
	
	
	<!--点击弹窗-->
	$("#buluo").click(function() {
	   $("#tribal_goods").css("display","block")
	   })

   $(".huisr").click(function() {
	   $("#tribal_goods").css("display","none")
	   })

		
</script>

	