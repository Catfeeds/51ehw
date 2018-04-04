<style type="text/css">
  .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
  .h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
  .h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
  .forget-password {width: 265px;margin: 30px auto;text-align: center;}
  .password-text span {line-height: 30px;font-size: 16px;color: #333;}
  .password-text textarea { border: 1px solid #ddd; height: 60px; width: 90%;resize: none;outline: none;padding: 5px;}
  .password-button {height: 40px;width: 100%;background-color: #FECF0A;text-align: center;margin-top: 20px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}
  .no-mima {float: right;margin-top: 25px;color: #000000;}
    @media screen and (max-width:320px) {
      .h5-forget {width: 270px!important;margin-left: -135px!important;}
      .password-button {width: 90%!important;}
      .no-mima {margin-right: 16px;}
    }
  .fenleitext{
	float: left;
    display: inline-block;
  	    margin-top: 6px;
  }
  .choice-label-box{
  	padding: 3px 20px;
    font-size: 14px;
    overflow: hidden;
  }
  .choice-fenlei{
	float: left;
  }  
</style>
<!-- 我的需求 -->
<div class="my-needs">
    <!-- 标签 -->
    <div class="needs-list-label">
    	<span>标签:</span>
    	<span class="icon-shanchu2 needs-list-shanchu"></span>
    	<?php if(count($Dictionary)>0){?>
    	    <i class="offer-details-label" ><?php echo $Dictionary['name'];?></i>
    	    
    	<?php }else{?>
    	<span class="choice-label-no">暂无选择</span>
    	<?php } ?>
    	
    	               
    </div>
	<!-- 内容 -->
	<div class="choice-label">
	   <!-- 选择行业 -->
	   <div class="choice-label-hangye">
     <span class="fn-left choice-label-title2">选择行业</span>
	   <div class="model-select-box">
        <?php if(count($Dictionary)>0){?>
    	    <a href="<?php echo site_url('member/requirement/chioces')?>" class="model-select-text" data-value=""><?php echo $Dictionary['name'];?></a>
    	<?php }else{?>
    	 <a href="<?php echo site_url('member/requirement/chioces')?>" class="model-select-text" data-value="">请选择行业</a>
    	<?php } ?>
      </div>
	   </div>

	   <div class="choice-label-hangye">
	      	<p class="fenleitext">选择分类</p>
			
        	<div class="choice-fenlei">
        
            <div class="choice-label-box border-none" >
             <div class="model-select-box">
              <div class="model-select-text fn-13 fenlei01" id="fl1" data-value="">请选择</div>
                <ul class="model-select-option choice-fenlei01">
                <?php foreach($toplevel as $k =>$v){ ?>
                    <li data-option="<?php echo $v['cateid'];?>" level="<?php echo $v['level']; ?>"><?php echo $v['name']; ?></li>
                <?php }?>
               </ul>
              </div>
             </div>
            
         
             </div>
			<input style="clear:both;" hidden>
	   </div>
	   <!-- 选择品牌 -->
	 <div class="brandbox">  
    
     </div>
	 <!-- 规格标签 -->
     <div class="choice-label-hangye border-none" >
     <span class="fn-left choice-label-title2">规格标签</span>
     <span class="maintenance-label-guige" id="standard"></span>
     <span class="icon-roundadd label-roundadd-icon"></span>
     <span class="icon-jianshao label-jianshao-icon"></span>
     </div>
    </div>
    <div class="maintenance-label-bt">
      <span>添加精确的标签会更加方便商家搜到您的需求喔</span>
      <a href="javascript:sub();" class="maintenance-label-confirm">添加完成</a>
    </div>
      <!-- 弹窗 -->
    <div class="maintenance-label-popup" hidden>
      <div class="color-bg"></div>
    <div class="h5-forget" id="skips_bullet" >
        <div class="h5-lose">
          <img src="images/51h5-lose.png" id="close_img" height="34" width="34">
        </div>
      <div class="forget-password">
        <div class="password-text">
          <!-- <input type="text" value="" placeholder="请输入规格内容，如“500ML"> -->
          <textarea placeholder="请输入规格内容，如“500ML"></textarea>
        </div>
        <a href="javascript:void(0);" class="password-button">确认添加</a>
      </div>
    </div>
    </div>


<script type="text/javascript">
//规格弹窗
$(".label-roundadd-icon").on("click",function(){
    $(".maintenance-label-popup").css("display","block");
  })
  $(".h5-lose").on("click",function(){
    $(".maintenance-label-popup").css("display","none");
  })
  $(".password-button").on("click",function(){
     var v= $("textarea").val(); 
   if (v=="") {
       
   } else{
    $(".maintenance-label-popup").css("display","none");
    $(".label-jianshao-icon").css("display","block");
    $(".label-roundadd-icon").css("display","none");
    $(".maintenance-label-guige").css("display","block");
    $(".maintenance-label-guige").html($("textarea").val());
    if(document.getElementById("guige") == undefined){
        $('.choice-label-no').remove();
      	 $(".needs-list-label").append('<i class="offer-details-label" id="guige">'+$("textarea").val()+'<i>');
           }else{
               $('#guige').text($("textarea").val());
               }
    $("textarea").val("");
   };
  })
  $(".label-jianshao-icon").on("click",function(){
    $(".label-jianshao-icon").css("display","none");
    $(".label-roundadd-icon").css("display","block");
    $(".maintenance-label-guige").css("display","none");
    $('#guige').remove();
    $('#standard').html("");
  })

  //使用事件委托
  $(".choice-fenlei").on("click",".fenlei01",function() {
     $(this).parent().children().siblings('ul').css("display","block");
  })

  $(".choice-fenlei").on("click",".model-select-option li",function() {
     $(this).parent().css("display","none");
     $(this).parent().siblings('div.model-select-text').text($(this).text()).attr('data-value', $(this).attr('data-option'));
     getbrandsorce($(this).attr('data-option'));
	 var id = $(this).attr('data-option');
	 var l = $(this).attr('level');
	 getsorce(id,l);
		
    //判断限制标签重复生成
	var  parentid = $(this).parent().siblings('div.model-select-text').attr('id');
	if(parentid == 'fl1' ){
		if(document.getElementById("fli1")  == undefined){
			 $('.needs-list-label').children('.choice-label-no').remove();
			 $(".needs-list-label").append('<i class="offer-details-label" id="fli1">'+$(this).text()+'<i>');
			}else{
				 $('#fli1').text($(this).text());
				 $('#fli1').nextAll().remove();
				}
		}
	if(parentid == 'fl2' ){
		if(document.getElementById("fli2")  == undefined){
			 $(".needs-list-label").append('<i class="offer-details-label" id="fli2">'+$(this).text()+'<i>');
			}else{
				 $('#fli2').text($(this).text());
				 $('#fli2').nextAll().remove();
				}
		}
	if(parentid == 'fl3' ){
		if(document.getElementById("fli3")  == undefined){
			 $(".needs-list-label").append('<i class="offer-details-label" id="fli3">'+$(this).text()+'<i>');
			}else{
				 $('#fli3').text($(this).text());
				 $('#fli3').nextAll().remove();
				}
		}
	if(parentid == 'fl4' ){
		if(document.getElementById("fli4")  == undefined){
			 $(".needs-list-label").append('<i class="offer-details-label" id="fli4">'+$(this).text()+'<i>');
			}else{
				 $('#fli4').text($(this).text());
				 $('#fli4').nextAll().remove();
				}
		}
	if(parentid == 'fl5' ){
		if(document.getElementById("fli5")  == undefined){
			 $(".needs-list-label").append('<i class="offer-details-label" id="fli5">'+$(this).text()+'<i>');
			}else{
				 $('#fli5').text($(this).text());
				 $('#fli5').nextAll().remove();
				}
		}
	    
  })



   // 点击清空
   $(".needs-list-shanchu").on("click",function(){
     $("i").remove(".offer-details-label");
     $.ajax({
  		url:'<?php echo site_url("member/requirement/delcondition") ?>',
  	    dataType:'json',
  	    type:'get',
  	    success:function(data){
  		    if(data['Result']){
  		    	window.location.reload();
  			    }else{
  			    	console.log("您没选择行业标签！");
  			    	window.location.reload();
  				    }
  		    },
  		error:function(){
  			console.log("网络错误或没选择标签，请重试！");
  				}
  		});
   })
  function getsorce(id,l){
	     $.ajax({
				url:'<?php echo site_url("member/requirement/ajax_getnextlevel")?>',
			    dataType:'json',
			    type:'get',
			    data:{id:id,l:l},
			    success:function(data){
				    //分类返回空数组，即已经选择分类到最下级层或在一级分类中就已经没有下级分类了
			    	 if(data['parentlevel']){
				    	 //当返回数据中没有下级分类，通过返回的parentlevel来判断
				    	 var ids = data['parentlevel'];
				    	 $('#fl'+ids).parents('.border-none').nextAll().remove();
				    }else{
					    var n = Number(data[0]["parentlevel"])+Number(1);	
						var flid = 	'fl'+n;
						//append生成新的下级分类选择
					    if(document.getElementById(flid) == null){

					    	if(data[0]['cateid']){
		    			    	 var text = '';
		    			    	 var lv = n;
		    			    	 len = data.length;
		    			    	 var str = '';
		    			    	 for(var i=0;i<len;i++){
		    			    		 str += '<li data-option="'+data[i]["cateid"]+'" level="'+lv+'">'+data[i]["name"]+'</li>'
		    		    		        }
		    			    	 	 $('.model-select-option li').parents('.choice-fenlei').append(
		    			    		       '<div class="choice-label-box border-none" >'
		    			    		       + '<div class="model-select-box">'
		    			    		       +'<div class="model-select-text fn-13 fenlei01" data-value="" id="fl'+lv+'">请选择</div>'+
		    			    		        '<ul class="model-select-option">'+str+'</ul>'
		    			    		       +'</div></div>');
		    				    }else{
		    				    	console.log("没有该分类！");
		    					    }
						    }else{
						    	
							    //重新选择分类，将当前下级分类删除
							    //一级分类
							    if(data[0]["parentlevel"] == 1){
							    	$('#fl1').parents('.border-none').nextAll().remove();
							    	var lv = 2;
							    	//重新选择一级分类后，重置二级分类
							    	len = data.length;
			    			    	 var str = '';
			    			    	 for(var i=0;i<len;i++){
			    			    		 str += '<li data-option="'+data[i]["cateid"]+'" level="'+lv+'">'+data[i]["name"]+'</li>'
			    		    		        }
			    			    	 $('.model-select-option li').parents('.choice-fenlei').append(
			    			    		       '<div class="choice-label-box border-none" >'
			    			    		       + '<div class="model-select-box">'
			    			    		       +'<div class="model-select-text fn-13 fenlei01" data-value="" id="fl'+lv+'">请选择</div>'+
			    			    		        '<ul class="model-select-option">'+str+'</ul>'
			    			    		       +'</div></div>');
								    }else{
									    //二级分类或其他
									    var levs =data[0]["parentlevel"]; 
									    flid = 	'fl'+levs;
									    var n = Number(data[0]["parentlevel"])+Number(1);	
									    //清除当前分类的所有下级分类
								    	$('#'+flid).parents('.border-none').nextAll().remove();
								    	var text = '';
				    			    	var lv = n;
				    			    	 len = data.length;
				    			    	 var str = '';
				    			    	 for(var i=0;i<len;i++){
				    			    		 str += '<li data-option="'+data[i]["cateid"]+'" level="'+lv+'">'+data[i]["name"]+'</li>'
				    		    		        }
			    		    		     //选择新的父级后，重置下级分类
				    			    	 $('.model-select-option li').parents('.choice-fenlei').append(
				    			    		       '<div class="choice-label-box border-none" >'
				    			    		       + '<div class="model-select-box">'
				    			    		       +'<div class="model-select-text fn-13 fenlei01" data-value="" id="fl'+lv+'">请选择</div>'+
				    			    		        '<ul class="model-select-option">'+str+'</ul>'
				    			    		       +'</div></div>');
									    }
						    	  
							    }	 
	    		    	 
				    	 }
				    },
				error:function(){
					console.log("网络错误！");
						}
				});
	  }

  function sub(){
	  //获取分类ID
	  var fl5 = $('#fl5').attr("data-value");
	  var fl4 = $('#fl4').attr("data-value");
	  var fl3 = $('#fl3').attr("data-value");
	  var fl2 = $('#fl2').attr("data-value");
	  var fl1 = $('#fl1').attr("data-value");
	  if(fl5 ==undefined || fl5==''){
		  if(fl4 ==undefined || fl4==''){
			  if(fl3 ==undefined || fl3==''){
				  if(fl2 ==undefined || fl2==''){
					  var id = fl1;
				 	 }else{
					 		var id = fl2;
					 	 }
			  	}else{
			  		var id = fl3;
				  	}
		 	 }else{
			 		var id = fl4;
			 	 }
		  }else{
			  var id = fl5;
			  }
// 	  if(id ==undefined || id ==''){
// 		  alert('请选择分类');
// 		  return;
// 		  }
	  var brand = $('#brand_id').attr("data-value");
	  var standard = $('#standard').html();
	  if(standard  ==undefined){
		  standard =null;
		  }
	  if(brand ==undefined){
		  brand =null;
		  }
	  $.ajax({
		  url:'<?php echo site_url("member/requirement/add_Conditionssession")?>',
		    dataType:'json',
		    type:'get',
		    data:{id:id,brand_id:brand,standard:standard},
		    success:function(data){
		    	window.location.href="<?php echo site_url('member/requirement/search')?>";
			    },
		    error:function(){
				alert("网络错误！");
					}
		  });
	  
	  }
  function getbrandsorce(id){
	  $.ajax({
			url:'<?php echo site_url("member/requirement/ajax_getbrand")?>',
		    dataType:'json',
		    type:'get',
		    data:{id:id},
		    success:function(data){
		    	     $('.brandbox').children().remove(); 
		    	    if(data[0]['brand_id']){
		    	    	//选择新的父级后，重置下级分类
				    	 len = data.length;
				    	 var str = '';
				    	 for(var i=0;i<len;i++){
				    		 str += '<li data-option="'+data[i]["brand_id"]+'">'+data[i]["brand_name"]+'</li>'
			    		        }
				    	 $('.brandbox').append(
				    			   '<div class="choice-label-hangye border-none" >'
				    			   +'<span class="fn-left choice-label-title2" >选择品牌</span>'
				    		       + '<div class="model-select-box">'
				    		       +'<div class="model-select-text fenlei-brand fenlei04" id="brand_id" data-value="">请选择品牌</div>'+
				    		        '<ul class="model-select-option choice-fenlei04">'+str+'</ul>'
				    		       +'</div></div>'
						    	 );
			    	    }
			    },
		    error:function(){
				console.log("网络错误！");
					}
	 	 });	
	  }
//选择品牌
  $(".brandbox").on("click","div.fenlei04",function() {
	  $(this).parent().children().siblings('ul').css("display","block");
   })
   $(".brandbox").on("click",".model-select-option li",function() {
     $(this).parent().css("display","none");
     $(this).parent().siblings('div.model-select-text').text($(this).text()).attr('data-value', $(this).attr('data-option'));
     if(document.getElementById("brandname") == undefined){
    	 $(".needs-list-label").append('<i class="offer-details-label" id="brandname">'+$(this).text()+'<i>');
         }else{
             $('#brandname').text($(this).text());
             }
    

     })
</script>

