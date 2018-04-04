  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
    <?php //储蓄卡头部菜单导航  
            $data['head_menu'] = 2;
            $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">我是销售商</div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul>
                    <li><a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>">查看线上储值卡</a></li>
                	<li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/Apply_View');?>">申请储值卡</a></li>
                </ul>
            </div>
        </div>
       <!--左边结束-->  
       
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">申请储值卡</div>
            <div class="stored_chong">
                <form action="<?php echo site_url('Corporate/Savings_card/Add_Apply_Card');?>" method="post" enctype="multipart/form-data" id="form1">
                   <ul class="stored_chong_ul">
                     <li><span>储值卡名称：</span><input type="text" class="n" name="card_name" value="" placeholder="请输入储值卡名称"><samp class="stored_chong_ul_samp"></samp></li>
                     <li><span>承兑商：</span><a href="javascript:;" class="stored_chong_ul_a" id="buluo">选择承兑商<i hidden>[更改]</i></a><samp class="stored_chong_ul_samp"></samp></li>
                     <li><span>申请授权额：</span><input type="text" class="n" name="card_amount" value="" placeholder="请输入授权额" onkeyup="if(isNaN(value))execCommand('undo')" ><samp class="stored_chong_ul_samp"></samp></li>
                     <li><span>开始日期：</span><input type="text" value="" class="" name="start_time" onclick="WdatePicker()" readonly placeholder="请输入储值卡生效日期"><samp class="stored_chong_ul_samp"></samp>
                     <li><span>结束日期：</span><input type="text" value="" class="" name="end_time" onclick="WdatePicker()" readonly placeholder="请输入储值卡失效日期"><samp class="stored_chong_ul_samp"></samp></li>
                 	 <input type="hidden" name="corporation_id" value="">
    			  	 <input type="hidden" name="add_img" value="">
                   </ul>
                
             <div class="stored_chong_xia" hidden>
               <span class="stored_chong_xia_s">上传合同、协议</span>
               <div class="stored_chong_xia_z">               
               <p><input type="file" onchange="previewImg(this,'#thubm')"> 上传图片</p>
	            <h2><img src="" id="thubm"><span id="xianshudwfn" hidden><i class="icon-cha"></i></span></h2>
                </div>
             </div>  
               
              
               
               
                <div class="release_pictures">
                <span class="stored_chong_xia_s">上传合同、协议</span>
          <div class="img-box full">
            <section class=" img-section">
                <div class="z_photo upimg-div clear" >
                         <section class="z_file z_file_lo" id='test'>
                            <!--<img src="img/a11.png" class="add-img">-->
                             <span class=" add-img">上传图片</span><br/><span id="img_message"  hidden style="color:red;font-size:13px;" >请上传图片</span>
                            <input runat="server" type="file" name="file[]" id="file_0" class="file" value="" onchange="upload_img('file_0')" multiple/>
                        
                         </section>
                         <aside class="mask works-mask">
                <div class="mask-content">
                    <p class="del-p ">您确定要删除选中的图片吗？</p>
                    <p class="check-p"><span class="del-com wsdel-ok" flag="">确定</span><span class="wsdel-no">取消</span></p>
                </div>
            </aside>
                 </div>
             </section>
       </div>
            
       </div>
        </form>
               
               <div class="stored_chong_bottom">
                 <a href="javascript:;" class="stored_chong_left" onclick='apply_sub()'>提交</a>
                 <a href="<?php echo site_url('Corporate/Savings_card/Sales_List')?>" class="stored_chong_rigth">取消</a>
               </div>
               
            </div>  
            
            
            
            <div class="tribal_goods" id="tribal_goods" style="display: none;">
        <div class="tribal_goods_top">
        <h1>申请储值卡</h1>
         <div class="tribal_goods_zhong">
            <ul>
              <li><span>服务商账号：</span><input type="text" class="n" name="search_name" value="" placeholder="请输入服务商账号"><a class="tribal_goods_a" href="javascript:;" onclick="search_corp()">查找</a></li>
              <p style="margin-left: 110px;color: red; font-size: 13px" id="search_message"hidden>服务商不存在</p>
              <li class="customer_corp_info" hidden><span>用户名：</span><samp id="info_name">51易货网</samp></li>
              <li class="customer_corp_info" hidden><span>昵称：</span><samp id="info_nick_name">二哈</samp></li>
              <li class="customer_corp_info" hidden><span>手机号：</span><samp id="info_mobile" >138-0013-8000</samp></li>
              <li class="customer_corp_info" hidden><span>企业名：</span><samp id="info_corporation_name" >51易货网</samp></li>
			  
            </ul>
         
         </div>
        <div class="tribal_goods_xia" style="margin-bottom: 20px;">
            <a href="javascript:;" class="huisr" >取消</a>
            <a href="javascript:;" onclick="choose_sub()" class="lamseh">确定</a>
        </div>
        </div>
    </div>

            
            
            
         </div>
       <!--右边结束-->    
         </div>



     


<script>

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
	$("#buluo").click(function() 
	{
	   $('#search_message').hide();
	   $("#tribal_goods").css("display","block")
	   })

   $(".huisr").click(function() {
	   $("#tribal_goods").css("display","none")
   })

//搜索承兑方。  
function search_corp()
{ 
    var customer_name  = $('input[name=search_name]').val();
    $('input[name=corporation_id]').val('');
    $('#search_message').hide();
    
	$.post("<?php echo site_url('Corporate/Search/Customer_Corp_Info')?>", { "customer_name": customer_name },
       function(data)
       {

    	   if( data.info )
    	   {
    		  $('#info_name').text(data.info.name);
    		  $('#info_nick_name').text(data.info.nick_name);
    		  $('#info_mobile').text(data.info.mobile);
    		  $('#info_corporation_name').text(data.info.corporation_name);
			  $('input[name=corporation_id]').val(data.info.id);
    		  $('.customer_corp_info').show();
    		  
    		 }else{ 
    		   
    		   $('.customer_corp_info').hide();
    		   $('#search_message').show();
    	   }
	   
  	 }, "json");
}

//选择承兑方
function choose_sub()
{ 
	var corp_id = $('input[name=corporation_id]').val();
	
	if( corp_id )
	{ 
		var corp_name = $('#info_corporation_name').text();
		$('#buluo').html(corp_name+'<i>[更改]</i>');
	}

	$('#tribal_goods').hide();
}

function apply_sub()
{ 
	$('form').submit();
}

$('#form1').submit(function(){
	
	$('.stored_chong_ul_samp').text('');
	var card_name = $('input[name=card_name]').val();
	var start_time = $('input[name=start_time]').val();
	var end_time = $('input[name=end_time]').val();
	var card_amount = $('input[name=card_amount]').val();
	var corp_id = $('input[name=corporation_id]').val();
	var is_ok = true;
	
	if( !card_name )
	{ 
		$('input[name=card_name]').next('samp').css('color','red').text('请填写储值卡名称');
		is_ok = false;
	}
	
	if( !start_time )
	{ 
		$('input[name=start_time]').next('samp').css('color','red').text('请选择开始日期');
		is_ok = false;
	}
	
	if( end_time <= start_time )
	{ 
		$('input[name=end_time]').next('samp').css('color','red').text('结束日期须大于开始日期');
		is_ok = false;
	}
	
	if( !end_time )
	{ 
		$('input[name=end_time]').next('samp').css('color','red').text('请选择结束日期');
		is_ok = false;
	}
	
	if( !card_amount )
	{ 
		$('input[name=card_amount]').next('samp').css('color','red').text('请填写申请授权额');
		is_ok = false;
	}

	if( !corp_id )
	{
		$('#buluo').next('samp').css('color','red').css('margin-left','224px').text('请选择承兑商');
		is_ok = false;
	}

	if( !$('input[name=add_img]').val() )
	{ 
		$('#img_message').show();
		is_ok = false;
	}
	
	if( !is_ok )
		return false;

	
    $.ajax({
        url: '<?php echo site_url('Corporate/Savings_card/Add_Apply_Card');?>',
        type: 'POST',
        cache: false,
        dataType:'json',
        data: new FormData( $('#form1')[0] ),
        processData: false,
        contentType: false,
//         data:{'card_name':card_name,'start_time':start_time,'end_time':end_time,'card_amount':card_amount,'corp_id':corp_id},
        data: new FormData( $('#form1')[0] ),
    	beforeSend:function()
        { 
            $('.stored_chong_left').text('提交申请中.....');
            $('.stored_chong_left').css('background','#dddddd');
            $('.stored_chong_left').removeAttr('onclick');
        },
    	complete:function()
    	{ 
    		$('.stored_chong_left').text('提交');
            $('.stored_chong_left').css('background','#72c312');
            $('.stored_chong_left').attr('onclick','apply_sub()');
    	}
    	
    }).done(function(data) 
    {
    	alert(data.message);
    	
    	if( data.status )
    	{ 
    		window.setTimeout("window.location.href='<?php echo site_url('Corporate/Savings_card/Sales_List')?>'", 1000);   
    		
    	}

    }).fail(function(res) 
    {	
    	alert('服务器异常，请稍后再试。');
    	
    });

   	return false;
});

</script>

<script>

var delParent;
var defaults = {
	fileType         : ["JPG",'jpg',"png","PNG","jpeg","JEPG"],   // 上传文件的类型
	fileSize         : 1024 * 1024 * 3                  // 上传文件的大小 10M
};


function upload_img(id)
{		
	
		var obj = $('#'+id);
		var file = document.getElementById(id);
		var file_n = parseInt(id.split('_')[1])+1;
		$('#'+id).hide();
		
		var imgContainer = $(obj).parents(".z_photo"); //存放图片的父亲元素
		var fileList = file.files; //获取的图片文件
		
		var input = $(obj).parent();//文本框的父亲元素
		var imgArr = [];
		//遍历得到的图片文件
		var numUp = imgContainer.find(".up-section").length;
		
		var totalNum = numUp + fileList.length;  //总的数量
		
		$('#img_message').hide();
		fileList = validateUp(fileList);
			
		for(var i = 0;i<fileList.length;i++)
		{
			console.log(fileList[i]['name']);
			
		 var imgUrl = window.URL.createObjectURL(fileList[i]);
		     imgArr.push(imgUrl);
		 var flag = fileList[i]['name']+fileList[i]['size'];
		     Add(flag);
		     flag = flag.replace('.',"");
	 	 
		 var $section = $("<section class='up-section z_file_lo loading' id="+flag+">");
		 
		     imgContainer.prepend($section);
		 var $span = $("<span class='up-span'>");
		     $span.appendTo($section);

				//点击弹出删除图片
	     var $img0 = $("<div class='close-upimg' flag="+fileList[i]['name']+fileList[i]['size']+"></div>").on("click",function(event){
			    event.preventDefault();
				event.stopPropagation();
				$(".works-mask").show();
				delParent = $(obj).parent();
			    $('.del-com').attr('flag',$(this).attr('flag') );
			});   
			$img0.attr("src","img/a7.png").appendTo($section);

	     var $img = $("<img class='up-img1 up-opcity '>");
	         $img.attr("src",imgArr[i]);
	         $img.appendTo($section);
	     var $p = $("<p class='img-name-p'>");
	         $p.html(fileList[i].name).appendTo($section);
	     var $input = $("<input id='taglocation' name='taglocation' value='' type='hidden'>");
	         $input.appendTo($section);
	     var $input2 = $("<input id='tags' name='tags' value='' type='hidden'/>");
	         $input2.appendTo($section);
	         
	      
	   }
		
		html = '<input type="file" name="file[]" id="file_'+file_n+'" class="file" value="" onchange="upload_img(\'file_'+file_n+'\')" multiple="multiple" />'
 		$('#test').append(html);

 		
		setTimeout(function(){
         $(".up-section").removeClass("loading");
		 	 $(".up-img1").removeClass("up-opcity");
		 },300);
		 numUp = imgContainer.find(".up-section").length;
		 
		if(numUp >= 9){
			//$(obj).parent().hide();
		
		}
}


function validateUp(files){
	
	var arrFiles = [];//替换的文件数组
	for(var i = 0, file; file = files[i]; i++){
		
		//获取文件上传的后缀名
		var newStr = file.name.split("").reverse().join("");
		if(newStr.split(".")[0] != null){
				var type = newStr.split(".")[0].split("").reverse().join("");
				console.log(type+"===type===");
				if(jQuery.inArray(type, defaults.fileType) > -1){
					// 类型符合，可以上传
					if (file.size >= defaults.fileSize) {
						alert('您这个"'+ file.name +'"文件大小过大');	
					} else {
						// 在这里需要判断当前所有文件中
						arrFiles.push(file);	
					}
				}else{
					alert('您这个"'+ file.name +'"上传类型不符合');	
				}
			}else{
				alert('您这个"'+ file.name +'"没有类型, 无法识别');	
			}
	}
	
	
	return arrFiles;
}


function Add( file_name )
{ 
	var Cts = $('input[name=add_img]').val();
	
    $('input[name=add_img]').val( Cts+file_name+"," );

	
}

$(".z_photo").delegate(".close-upimg","click",function(){
 	  $(".works-mask").show();
//  	  delParent = $(this).parent();
// 	  alert($(this).attr('flag'));
	  
});
	
$(".wsdel-ok").click(function(){
	
	$(".works-mask").hide();
	var file_name =  $(this).attr('flag');
	var html_id = file_name.replace('.',"");
	
	$(document.getElementById(html_id)).remove();
// 	$('#1*1png7701').remove(); //emove();
	var Cts = $('input[name=add_img]').val();
	var rep = file_name+",";
	$('input[name=add_img]').val( ( $('input[name=add_img]').val() ).replace(rep,"") );

	
});

$(".wsdel-no").click(function(){
	$(".works-mask").hide();
});



</script>	