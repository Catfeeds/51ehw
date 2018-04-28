<script type='text/javascript' src='js/jquery.form.js'></script>
<style type="text/css">
 .container {background: #F6F6F6;}
 .icon_ball_box {position: fixed;top: 0;left: 0;background: rgba(0,0,0,0.5);width: 100%;height: 100%!important;z-index: 99;display: table;}
 .icon_ball_box_span {display: table-cell;vertical-align: middle;color: #fff;font-size: 15px;}
 .dropload-load .loading {border: 2px solid #fff!important;height: 25px!important;width: 25px!important;border-bottom-color: transparent!important;}
 .add-img {border: 1px solid #DDDDDD;text-align: center;}
 .add-img em {display: block;font-size: 0.8rem;padding-top: 0.5rem;}
 .add-img i {display: block;font-size: 13px;padding-top: 0.1rem;}
 .z_photo {padding: 0.25rem 0.375rem 0.375rem 0.375rem;background: #fff;}
 .img-box .upimg-div .z_file {margin-top: 0;}
 .img-box {padding-bottom: 0;border-bottom: 1px solid #ddd;}
 .introduction_xia {height: 45px;line-height: 45px;background-color:#ffd600; color:#333333;margin: 35px auto;}

  .z_photo{font-size: 0;white-space: nowrap; overflow-x: scroll;}
  .z_file_lo{float: none;display: inline-block;}
</style>

<form action="<?php site_url("Easyshop/order/save_complain");?>" method="post" enctype="multipart/form-data" id="form1" >
<!-- 投诉 -->
<div class="complaint">
  <input type="hidden" name="order_id" value="<?php echo $order_id?>">
  <div class="complaint_head"><span>请填写以下内容</span></div>
  <!-- 联系电话 -->
  <div class="complaint_input">
     <p><span>联系电话 : </span><input type="number" name='moblie' value=""></p>
  </div>
  <!-- 联系邮箱 :  -->
  <div class="complaint_input">
     <p><span>联系邮箱 : </span><input type="text" name='email' value=""></p>
  </div>
  <!-- 投诉事由 :  -->
  <div class="complaint_reasons">
    <span>投诉事由 : </span>
    <a href="javascript:void(0);"><em class='icon-choose complaint_reasons_active'></em><span>质量问题</span></a>
    <a href="javascript:void(0);"><em class=''></em><span>快递问题</span></a>
    <a href="javascript:void(0);" class="complaint_other"><em class=''></em><span>其他</span><input type="text" name='complain_other'></a>
  </div>
  <input type="hidden" name="complain_reason" value='1'>
  <!-- 请输入投诉内容（1000字以内） -->
  <div class="complaint_text"><textarea placeholder="请输入投诉内容（1000字以内）" maxlength="1000" name='complain_desc'></textarea></div>

  <!-- 请上传相关照片作为证据： -->
  <div class="complaint_evidence">
    <div class="complaint_evidence_head"><span>请上传相关照片作为证据：</span></div>
  </div>  
  <!-- 上传图片 -->
  <div>
    <div class="img-box full">
            <section class=" img-section">
                <div class="z_photo upimg-div clear">
                         <section class="z_file z_file_lo" id="test">
                            <span class="add-img">
                              <em class="icon-xiangji"></em>
                              <i>添加照片</i>
                            </span>
                            <input runat="server" type="file" name="file[]" id="file_0" class="file" value="" onchange="upload_img('file_0')" multiple="">
                         </section>
                 </div>
             </section>
        </div>
            <aside class="mask works-mask">
                <div class="mask-content">
                    <p class="del-p ">您确定要删除作品图片吗？</p>
                    <p class="check-p"><span class="del-com wsdel-ok" flag="">确定</span><span class="wsdel-no">取消</span></p>
                </div>
            </aside>
  </div>

  <div class="complaint_ok"><button type="button" onclick="sub()">确定投诉</button></div>
  <input type="hidden" name='add_img' value="">

</div>
</form>
<script type='text/javascript' src='js/exif.js'></script>
<script type="text/javascript">
  $('.complaint_reasons a').on('click',function(){
     $(this).children('em').addClass('icon-choose');
     $(this).siblings('a').children('em').removeClass('icon-choose');
     $(this).children('em').addClass('complaint_reasons_active');
     $(this).siblings('a').children('em').removeClass('complaint_reasons_active');
     var index = $(this).index();
     $('input[name=complain_reason]').val(index);
  })
</script>
<script type="text/javascript">
  var delParent;
var defaults = {
  fileType         : ["JPG",'jpg',"png","PNG","jpeg","JEPG"],   // 上传文件的类型
  fileSize         : 1024 * 1024 * 3                  // 上传文件的大小 10M
};


var upload_data = false;//默认没有选择过图片
var Orientation = null;
//图片数组
var imgarr=[];

function upload_img(id)
{   
    upload_data = true;
    var obj = $('#'+id);
    var file = document.getElementById(id);
    
    var file_n = parseInt(id.split('_')[1])+1;
    $('#'+id).hide();
    
    var imgContainer = $(obj).parents(".z_photo"); //存放图片的父亲元素
    var fileList = file.files; //获取的图片文件
    console.log(fileList);
    
    var input = $(obj).parent();//文本框的父亲元素
    var imgArr = [];
    //遍历得到的图片文件
    var numUp = imgContainer.find(".up-section").length;

    var totalNum = numUp + fileList.length;  //总的数量
    if(fileList.length > 9 || totalNum > 9 ){
      alert("上传图片数目不可以超过9个，请重新选择");  //一次选择上传超过5个 或者是已经上传和这次上传的到的总数也不可以超过5个
    }
    else if(numUp < 9){
      compressImg(fileList);//压缩
      fileList = validateUp(fileList);
      
      for(var i = 0;i<fileList.length;i++){
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
    }
    html = '<input type="file" name="file[]" id="file_'+file_n+'" class="file" value="" onchange="upload_img(\'file_'+file_n+'\')" multiple="multiple" />'
    $('#test').append(html);

    
    setTimeout(function(){
         $(".up-section").removeClass("loading");
       $(".up-img1").removeClass("up-opcity");
     },300);
     numUp = imgContainer.find(".up-section").length;
     
    if(numUp >= 9){
      $(obj).parent().hide();
    
    }
}

function compressImg(files){
  //获取所选图片的列表对象
     var fileimg=files; 
  //查看已经选择的图片数量
     var arrnum=imgarr.length;
  //获取所有图片的数量
     var num=arrnum+fileimg.length;
  //循环取出本次选择的图片
    for(var i =0;i<fileimg.length;i++){    
      /*图片转Base64 核心代码*/  
      var file = fileimg[i];  

      EXIF.getData(file, function() {  
        Orientation = EXIF.getTag(this, 'Orientation');
      })
     
      //这里我们判断下类型如果不是图片就返回中断上传，也可以continue直接过滤掉该文件
      if (!/image\/\w+/.test(file.type)) {  
         alert("请确保文件为图像类型");  
             return false;  
         } 
      //创建一个文件读取的工具类
        var reader = new FileReader();  
        //这里利用了闭包的特性，来保留文件名
        (function(x,y){
              reader.onload = function (e) {
              //将读取到图片流直接拼接起来
              //var str='<li class="weui-uploader__file " style="background-image:url('+this.result+')"><span class="remove" style="color:red">X</span></li>';
              //塞到页面节点里                    
              //$("#uploaderFiles").append(str);
              //调用压缩文件的方法，具体实现逻辑见下面
              render(this.result,x,y);
              }  

         })(file.name,file.size) 
         //告诉文件读取工具类读取那个文件
        reader.readAsDataURL(file);  
      }
      console.log(imgarr);
}
//设置压缩图片的最大高度
var MAX_HEIGHT = 1000;
function render(src,picname,size) {
  
// 创建一个 Image 对象
var image = new Image();
  // 绑定 load 事件处理器，加载完成后执行
  image.onload = function() {
   // 获取 canvas DOM 对象
   var canvas = document.createElement("canvas");
   var width =  image.width;
   do{
     image.width = image.width*0.9;
     }while(image.width > 800)

   var ratio = image.width/width;   
   image.height = image.height*ratio;
      
   // 获取 canvas的 2d 画布对象,
   var ctx = canvas.getContext("2d");
   // canvas清屏，并设置为上面宽高
   ctx.clearRect(0, 0, canvas.width, canvas.height);
   if(Orientation && Orientation != 1){
       switch(Orientation){
           case 6:     // 旋转90度
               canvas.width = image.height;    
               canvas.height = image.width;    
               ctx.rotate(Math.PI / 2);
               // (0,-imgHeight) 从旋转原理图那里获得的起始点
               ctx.drawImage(this, 0, -image.height, image.width, image.height);
               break;
           case 3:     // 旋转180度
               ctx.rotate(Math.PI);    
               ctx.drawImage(this, -image.width, -image.height, image.width, image.height);
               break;
           case 8:     // 旋转-90度
               canvas.width = image.height;    
               canvas.height = image.width;    
               ctx.rotate(3 * Math.PI / 2);    
               ctx.drawImage(this, -image.width, 0, image.width, image.height);
               break;
       }
   }else{
     // 重置canvas宽高
     canvas.width = image.width;
     canvas.height = image.height;
    // 将图像绘制到canvas上
     ctx.drawImage(image, 0, 0, image.width, image.height);
     }
   // !!! 注意，image 没有加入到 dom之中
   //document.getElementById('img').src = canvas.toDataURL("image/png");
   var blob = canvas.toDataURL("image/jpeg");

//    var that = this;
   // 默认按比例压缩
//    var w = that.width,
//     h = that.height,
//     scale = w / h;
//     w = obj.width || w;
//     h = obj.height || (w / scale);
//    var quality = 0.7;  // 默认图片质量为0.7
//    var ctx = canvas.getContext('2d');
   // 创建属性节点
//    var anw = document.createAttribute("width");
//    anw.nodeValue = w;
//    var anh = document.createAttribute("height");
//    anh.nodeValue = h;
//    canvas.setAttributeNode(anw);
//    canvas.setAttributeNode(anh); 
//    ctx.drawImage(that, 0, 0, w, h);
   // 图像质量
//    if(obj.quality && obj.quality <= 1 && obj.quality > 0){
//     quality = obj.quality;
//    }
   // quality值越小，所绘制出的图像越模糊
//    var blob = canvas.toDataURL("image/jpeg", quality);
   //将转换结果放在要上传的图片数组里
   imgarr.push({"pic":blob,"pic_name":picname,"pic_sign":picname+size});
  };
  
   image.src = src;
};


function validateUp(files){
  
  var arrFiles = [];//替换的文件数组
  for(var i = 0, file; file = files[i]; i++){
    
    //获取文件上传的后缀名
    var newStr = file.name.split("").reverse().join("");
    if(newStr.split(".")[0] != null){
        var type = newStr.split(".")[0].split("").reverse().join("");
        console.log(type+"===type===");
        if(jQuery.inArray(type, defaults.fileType) > -1){
          arrFiles.push(file);  
          // 类型符合，可以上传
//          if (file.size >= defaults.fileSize) {
//            imgarr=[];
//            alert('您这个"'+ file.name +'"文件大小过大');  
//          } else {
//            // 在这里需要判断当前所有文件中
//            arrFiles.push(file);  
//          }
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
//      delParent = $(this).parent();
//    alert($(this).attr('flag'));
    
});
  
$(".wsdel-ok").click(function(){
  
  $(".works-mask").hide();
  var file_name =  $(this).attr('flag');
  console.log(file_name);
  console.log(imgarr);
  alert(file_name);
  var html_id = file_name.replace('.',"");
  $('#'+html_id).remove(); //emove();
  var Cts = $('input[name=add_img]').val();
  var rep = file_name+",";
  $('input[name=add_img]').val( ( $('input[name=add_img]').val() ).replace(rep,"") );

  
});

$(".wsdel-no").click(function(){
  $(".works-mask").hide();
});




var JM = function(){
    //设置rem单位
    var html = document.documentElement;
    html.style.width = 100+"%";
    html.style.height = 100+"%";
    html.style.overflowX = "hidden";
    function xX(){
        var screenW = html.clientWidth;
        html.style.fontSize = 0.1 * screenW + "px";
    }
    window.onresize = function(){
        xX();
    };
    xX();
}(); 

function sub(){

    var moblie = $('input[name=moblie]').val();
    var email = $('input[name=email]').val();
    var complain_desc = $('textarea[name=complain_desc]').val();
    var complain_reason = $('input[name=complain_reason]').val();
    var complain_other = $('input[name=complain_other]').val();

    if(!moblie)
    {
      $(".black_feds").text('请填写联系电话').show();
      setTimeout("prompt();", 2000);
      return false;      
    }
    else if(complain_reason==3 && !complain_other)
    {
      $(".black_feds").text('请填写投诉事由').show();
      setTimeout("prompt();", 2000);
      return false;       
    }
    else if(!email)
    {
      $(".black_feds").text('请填写联系邮箱').show();
      setTimeout("prompt();", 2000);
      return false;       
    }
    else if(!complain_desc)
    {
      $(".black_feds").text('请填写投诉内容').show();
      setTimeout("prompt();", 2000);
      return false;       
    }
    else if(!upload_data){
      $(".black_feds").text('请选择图片').show();
      setTimeout("prompt();", 2000);
      return false;
    }

  $("#test").empty();
  $(".introduction_xia").css("background-color",'#e4d270');
  $(".introduction_xia").html("提交中");
  
   var progress = $(".progress"); 
   var progress_box = $('.icon_ball_box');
   var progress_bar = $(".progress-bar");
   var percent = $('.percent');

   var tribe_id = "<?php echo $tribe_id?>";
   var order_id = "<?php echo $order_id?>";

  $('#form1').ajaxSubmit({
      url: '<?php echo site_url("Easyshop/order/save_complain")?>',
      type: 'POST',
      //cache: false,
      //data: new FormData( $('#form1')[0] ),
        //processData: false,
        //contentType: false,
      dataType:  'json', //数据格式为json 
      data:{"file":imgarr},
      beforeSend: function() { //开始上传 
        progress.show();
        progress_box.show();
        var percentVal = '0%';
        progress_bar.width(percentVal);
        percent.html(percentVal);
      },
      uploadProgress: function(event, position, total, percentComplete) { 
        var percentVal = percentComplete + '%'; //获得进度 
        progress_bar.width(percentVal); //上传进度条宽度变宽 
        percent.html(percentVal); //显示上传进度百分比 
      },
      success: function(data) {console.log(data);return false;
        if( data.status == 0)
          { 
            $(".black_feds").text('提交成功').show();
            setTimeout("prompt();", 2000);
            setTimeout(function(){
                window.location.href = "<?php echo site_url('Easyshop/order/detail')?>"+'/'+tribe_id+'/'+order_id;
                }, 2200);
            
          }else{ 
            $(".introduction_xia").css("background-color",'#ffd600');
            $(".introduction_xia").html("确定投诉");
            
            $(".black_feds").text('提交失败，请重试').show();
            setTimeout("prompt();", 2000);
            setTimeout(function(){
              progress_box.hide();
                }, 2000);
          }
        },
        error:function(xhr){ //上传失败 
        $(".introduction_xia").css("background-color",'#ffd600');
        $(".introduction_xia").html("确定投诉");
        
        $(".black_feds").text('提交失败，请重试').show();
        setTimeout("prompt();", 2000);
        setTimeout(function(){
          progress_box.hide();
            }, 2000);
        }
  });
   return false;
}
</script>
