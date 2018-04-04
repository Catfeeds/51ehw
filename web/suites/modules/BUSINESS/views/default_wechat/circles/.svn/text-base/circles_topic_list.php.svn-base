<style>
.tribe_shop_footer ul li{width:25%}
.hot_circle_study_top {margin-left:0;}
.hot_circle_study_gun {white-space: normal;width:auto;font-size: inherit;}
.hot_circle_study_gun li {margin-right: 0px;width: 3.16rem;height: 3.16rem;}
.hot_circle_study_gun li:nth-child(3n+1){margin-left: 0.13rem; margin-right: 0.13rem;}
.hot_circle_study_gun li:nth-child(3n+2){ margin-right: 0.13rem;}
.hot_circle_study_gun li:nth-child(3n){margin-right: 0.13rem;}
.circle_zhong_dl {margin-top: 1px;}
.hot_circle_study_qian li{ width: 50% !important;}
.head_top{ width:auto;}
.circle_zhong_ul_xia h2{ display: initial; width:100%}
  .circle_zhong_ul_xia h2 span {
    display: inline-block;
    float: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 40%;
    padding-right: 10px;
    margin-right: 0;
}
.circle_zhong_ul_xia h2 samp {
    display: inline-block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 60%;
}
  .quanzi_tribal_name {float: right;margin-right: 0!important;text-align: center;width:auto !important; max-width:30%;padding:0 5px; border-radius:2px;overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis; color:#aaaaaa; border:1px solid #aaaaaa; display:block; }
.circle_zhong_ul_xia p span{ margin-right:5px;}
/*.circle_zhong_ul {opacity: 0;}*/
</style>
<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/format_time.js"></script><!-- 时间函数 -->

<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<div class="head_top">
   <div class="head_top_nei">
      <a href="javascript:history.back()" class=""><span class="icon-back"></span></a>
	<div class="search_circh" id="yanse">
		
	</div>
        
    </div>
    </div>
   <!--圈子内容-->
  <div class="container" >
    
     
     <div class="circle_zhong" style="margin-bottom:50px; margin-top:0; padding-top:0">
        <ul class="circle_zhong_ul" id="list">
        
        
        </ul> 
                                                                               
     </div>  
     
  </div>

  <!-- 该圈子还没有话题 -->
  <div class="circles_no" hidden>
    <span class="icon-huati"></span>
    <span>没有话题快去发布第一个话题吧</span>
  </div>

  
  
  
  <!-- 底部导航 -->
     



<script src="js/LUploader.js"></script>

<script type="text/javascript">
 
// window.onload = function(){

//    $('.circle_zhong_ul').css('opacity','1');
//    // alert('fdf');
//     }  

$(function () { 
	  var isPageHide = false; 
	  window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
	  }); 
	  window.addEventListener('pagehide', function () { 
	    isPageHide = true; 
	  }); 
})


<!--超出字显示查看更多-->

function show(id){ 
var box = document.getElementById("box_"+id); 
var text = box.innerHTML; 
var newBox = document.createElement("div"); 
var btn = document.createElement("a"); 
newBox.innerHTML = text.substring(0,150); 
btn.innerHTML = text.length > 150 ? "展开" : ""; 
btn.href = "javascript:;"; 
btn.onclick = function(){ 
if (btn.innerHTML == "展开"){ 
btn.innerHTML = "收起"; 
newBox.innerHTML = text; 
}else{ 
btn.innerHTML = "展开"; 
newBox.innerHTML = text.substring(0,150); 
} 
} 
box.innerHTML = ""; 
box.appendChild(newBox); 
box.appendChild(btn); 
} 

</script>
<!--点赞-->

<!--点击弹出弹窗-->
<script>
$(function()
{
    // 	window.scrollTo(0,100)
    $('#suos3').click(function(event){
        event.stopImmediatePropagation();//取消事件冒泡；
    	$('.delete_nei_z').show();
    $('.delete_pinglun').show();
    });
    $(".delete_pinglun").bind("click",function(){
        $('.delete_pinglun').hide();
    	$('.delete_nei_z').hide();
    })

    var cus_id = <?php echo $this->session->userdata("user_id"); ?>;
    var page = 1;//默认加载页数
    var tribe_id = '';
	//下拉加载数据
	dropload = $('.circle_zhong').dropload({
		scrollArea : window,
	    loadDownFn : function(me){
    	    //加载菜单一的数据
    		$.ajax({ 
    		    url:'<?php echo site_url('Tribe/Topic_List')?>',
    		    type:'get',
    		    dataType:'json',
    		    data:{'tribe_id':tribe_id,'page':page,'not_sort':true},
    		    success:function(data)
    		    {
    		    	
		     		if( data.list.length > 0 )  
		     		{  
        		   
		     			
        		    	for( var i=0; i<data.list.length;i++ )
   	 			        {
       	 			        
        		    		var html = '';
        		    		var tribe_id = data.list[i]['tribe_id'];
        		    		html += '<li id="topic_'+data.list[i]['id']+'">';
       	 			    	html += '<div class="circle_zhong_ul_li">';
       	 			    	html += '<div class="circle_zhong_ul_top"> ';
       	 			    	html += '<a href="<?php echo site_url('Tribe_social/Customer_Info')?>/'+data.list[i]['customer_id']+'?tribe_id='+tribe_id+'">';
							if(data.list[i]['brief_avatar']){
								html += '<i><img src="<?php echo IMAGE_URL?>'+data.list[i]['brief_avatar']+'" onerror="this.src=\'images/member_defult.png\'"></i>';
								}else{
								html += '<i><img src="'+data.list[i]['wechat_avatar']+'" onerror="this.src=\'images/member_defult.png\'"></i>';
									}
							html += '</a>';
       	 			  		html += '<div class="circle_zhong_ul_xia">';
           	 			  	if( data.list[i]['corp_id'] )
       	 					{
               	 			  	html += '<a style="max-width:70%" href="<?php echo site_url('Home/GetShopGoods')?>/'+data.list[i]['corp_id']+'">';
           	 					}else{
               	 					html += '<a href="javascript:void(0);" style="max-width:70%">';
               	 					}
       	 					html += '<div class="circle_zhong_dd">';
       	 					html += '<h2><span>'+(data.list[i]['real_name'] ? data.list[i]['real_name'] : data.list[i]['member_name'])+'</span>'
       	 					if( data.list[i]['corp_id'] )
       	 					{
       	 						html += '<samp>'+data.list[i]['corporation_name']+'</samp>'
       	 					}
       	 					html += '</h2>';
//            	 				if( page == 1 && i == 0 && data.list[i]['sort'] == 1 )
//        	 			        {
//            	 				html += '<span class="zhidingd">已置顶</span>';
//        	 			        }
       	 					

       						html += '</div>';
       						html += '<p><span>'+getDateDiff(data.list[i]['created_at'])+'</span>';
							if(data.list[i]['corp_id']){
								html +='<span class="quanzi_shop"><em class="icon-shop2"></em>店铺</span></p>';
								}else{
									html +='</p>';
									}
       						html += '</a>';
							html += '<a href="'+base_url+'/Circles/index/?tribe_id='+tribe_id+'" class="quanzi_tribal_name">'+data.tribe_list[tribe_id]['name']+'</a>';
       						html += '</div>';
       						html += '</div>';
       						html += '<div class="circle_zhong_ul_neirong" id="box_'+data.list[i]['id']+'">';
       						html += '<a href="<?php echo site_url('Circles/Topic_Detaile')?>/'+data.list[i]['id']+'/?tribe_id='+tribe_id+'"><p>'+data.list[i]['content']+'</p></a>';
       						html += '</div>';
       						html += '</div>';
       						
       						
       						if( data.list[i]['images'] )
       						{
       							data.list[i]['images'] = data.list[i]['images'].trim(';', 'right')
       							var img = data.list[i]['images'].split(';');
								if( img.length > 1 )
								{
       								html += '<div  class="hot_circle_study_top">';
								}else{ 
									html += '<div  class=" hot_circle_study_top hot_circle_study_qian">';
								}
								
       							html += '<ul data-am-widget="gallery" class="hot_circle_study_gun" data-am-gallery="{ pureview: true}">';
       							for(var j = 0 ; j < img.length; j++)
       							{
           							html += '<li>';
           							html += '<a href="<?php echo IMAGE_URL?>'+img[j]+'">';
           							html += '<img src="<?php echo IMAGE_URL?>'+img[j]+'">';
           							html += '</a>';
           							html += '</li>';
       							}
       							html += '</ul>';
       							html += '</div>';
       						}
       						html += '<dl class="circle_zhong_dl">';
       						var dianzan_class = '';
       						
       						if(  data.list[i]['my_upvote'] != 0 )
       						{ 
       							dianzan_class = 'icon-already_praised1 bounceIn';
       						}
       						html += '<dd><span><i class="icon-not_praise '+dianzan_class+' " id="dianzan_'+data.list[i]['id']+'" onclick="upvote('+data.list[i]['id']+','+tribe_id+')"><span class="zan_num">';
       						if(data.list[i]['upvote_num'] == 0 || data.list[i]['upvote_num'] == "0"){
       							html += '赞';
           						}else{
           							html += data.list[i]['upvote_num'];
               						}
       						html += '</span></i></span></dd>';
       						html += '<dd><a href="<?php echo site_url('Circles/Topic_Detaile')?>/'+data.list[i]['id']+'/?tribe_id='+tribe_id+'"><span><i class="icon-comment1" style="vertical-align: text-bottom;"></i>';
       						if(data.list[i]['comment_num'] == 0 || data.list[i]['comment_num'] == "0"){
       							html += '评论';
           						}else{
           							html += data.list[i]['comment_num'];
               						}
       						html += '</span></a></dd>';

							if( data.list[i]['corp_id'] )
							{
       							// html += '<dd><a href="<?php echo site_url('Home/GetShopGoods')?>/'+data.list[i]['corp_id']+'"><span><i class="icon-shop2"></i></span></a></dd>';
                   
							}
							 html += '<dd><a href="<?php echo site_url('Circles/Complaints')?>/'+data.list[i]['id']+'?tribe_id='+tribe_id+'"><span><i class="icon-jubao"></i>举报</span></a></dd>';
       						// html += '<dd><a href="<?php echo site_url('Circles/Complaints')?>/'+data.list[i]['id']+'?tribe_id='+tribe_id+'"><span><i class="icon-report1"></i></span></a></dd>';
				 if(data.list[i]['customer_id'] == cus_id){
					 html += '<dd><a href=javascript:Del_Comment('+data.list[i]['id']+','+tribe_id+')><span><i class="icon-delete"></i>删除</span></a></dd>';
					 }	
       						html += '</dl>';
       				html += '<div class="dianzan_name  diannan_'+data.list[i]['id']+'"';
          			if(data.list[i]['upvote_info'].length <= 0){
           				html += 'style="display:none"';
           				html += '>';
           				html += '<i class="icon-not_praise icon-already_praised1 circles_dianzan">';
                        html += '</i>';
         			  }else{
          				  html += '>';
         				  html += '<i class="icon-not_praise icon-already_praised1 circles_dianzan">';
                          html += '</i>';
                          for(var j = 0; j<data.list[i]['upvote_info'].length;j++){
                              if(j == data.list[i]['upvote_info'].length-1){
                            	  html += '<span id="upvote_'+data.list[i]['id']+'_'+data.list[i]['upvote_info'][j]['customer_id']+'">'+(data.list[i]['upvote_info'][j]['real_name'] ? data.list[i]['upvote_info'][j]['real_name'] :data.list[i]['upvote_info'][j]['member_name'])+'</span><span class="douhao" style="display:none">,</span>';
                                  }else{
                                	  html += '<span id="upvote_'+data.list[i]['id']+'_'+data.list[i]['upvote_info'][j]['customer_id']+'">'+(data.list[i]['upvote_info'][j]['real_name'] ? data.list[i]['upvote_info'][j]['real_name'] :data.list[i]['upvote_info'][j]['member_name'])+'</span><span class="douhao">,</span>';
                                      }
                              }
                         
             			  }
                    html += '</div>';

       			  
       						html += '</li>';
       						$('#list').append(html); 
       						show(data.list[i]['id']); 
        		            
        				}
       	 			    page++;
    				    
    				    
    	                me.resetload();
                        $.getScript("js/amazeui.js");
    			    }else{
    				    
    				    if( page == 1 )
    				    { 
    				    	$('.dropload-down').hide();
    				    	$('.circles_no').show();
    				    }
    				    
    				    
    			    	//锁定
    	                me.lock();
    	                // 无数据
    	                me.noData();
    	                me.resetload();
    			    }
    			},
    		    error:function()
    		    {
        		    
        		    //锁定
	                me.lock();
	                // 无数据
	                me.noData();
	                me.resetload();
    		    },
    		})
    	}
	});
	
});

//待删除
//     [].slice.call(document.querySelectorAll('input[data-LUploader]')).forEach(function(el) {
        
//         new LUploader(el, {
//             url: 'http://www.qdfuns.com/',//post请求地址
//             multiple: false,//是否一次上传多个文件 默认false
//             maxsize: 102400,//忽略压缩操作的文件体积上限 默认100kb
//             accept: 'image/*',//可上传的图片类型
//             quality: 0.1,//压缩比 默认0.1  范围0.1-1.0 越小压缩率越大
//             showsize:false//是否显示原始文件大小 默认false
//         });
//     });


function Del_Comment(id,tribe_id)
{ 
		$.ajax({ 
			url:'<?php echo site_url('Circles/Delete_Topic');?>/'+id,
			type:'get',
			data:{'tribe_id':tribe_id},
			dataType:'json',
			success:function(data)
			{

				$(".black_feds").text( data.message ).show();
				setTimeout("prompt();", 2000);
				
				if(data.status)
				{ 
					$('#topic_'+id).remove();

					setTimeout(function(){
						window.location.reload();	
						}, 2300);
				}
				
				
				
			},
			error:function()
			{
				$(".black_feds").text( '服务器异常，请稍后再试' ).show();
				setTimeout("prompt();", 2000);
			}
		})
    	
    	
}

//点赞
function upvote( id,tribe_id )
{ 
    if($('>span','#dianzan_'+id).text() == "赞"){
    	var zan_num = 0;
        }else{
        	var zan_num=parseInt( $('>span','#dianzan_'+id).text() );
            }
	var cus_id = <?php echo $this->session->userdata("user_id"); ?>;
	$.ajax
	({ 
		url:'<?php echo site_url('Circles/Add_Upvote')?>',
		type:'get',
		data:{'tribe_id':tribe_id,'obj_id':id},
		dataType:'json',
		beforeSend:function(){     
        	$('#dianzan_'+id).removeAttr("onclick");
	    },
	 	success:function(data) 
	 	{
		 	if(data.status == 1)
		 	{ 
			 	if(data.data.type == 1)
			 	{
			 		zan_num -=1;
			 		var span_id = 'upvote_'+id+'_'+cus_id;
			 		$("#"+span_id).prev("span").remove();
					if(zan_num >= 1){
						$("#"+span_id).next("span").remove();
						}
					$("#"+span_id).remove();
					var html = $(".diannan_"+id).html();
					if(zan_num == 0 || zan_num == "0" ){
						$(".diannan_"+id).hide();
						}
					
			 	}else{
			 		zan_num +=1;
					$(".diannan_"+id).show();
			 		var html = $(".diannan_"+id).html();
			 		if(zan_num == 1 || html.length == "1" ){
			 			html += '<span id="upvote_'+id+'_'+cus_id+'"><?php echo $real_name ?  $real_name : $member_name?></span>';
				 		}else{
				 			html += '<span class="douhao" >,</span><span id="upvote_'+id+'_'+cus_id+'"><?php echo $real_name ?  $real_name : $member_name?></span>';
					 		}
			 		$(".diannan_"+id).html(html);
					
			 	}
					
			 	$('>span','#dianzan_'+id).text( zan_num );
			 	
		 	}else{ 
			 	
		 	}
		 	$('#dianzan_'+id).toggleClass("icon-already_praised1");
			$('#dianzan_'+id).toggleClass("bounceIn");/*bounceIn*/
		 	$('#dianzan_'+id).attr("onclick",'upvote('+id+','+tribe_id+')');
	 	},
	 	error:function()
	 	{
	 		$('#dianzan_'+id).attr("onclick",'upvote('+id+','+tribe_id+')');
	 	}
	})
  }
  
    
$('#btni').on('click',function(event)
{ 
	
    var evt = event || window.event;  
    //IE用cancelBubble=true来阻止而FF下需要用stopPropagation方法  
	evt.stopPropagation ? evt.stopPropagation() : (evt.cancelBubble=true);  
           
});  

	
	String.prototype.trim = function (char, type) {
		  if (char) {
		    if (type == 'left') {
		      return this.replace(new RegExp('^\\'+char+'+', 'g'), '');
		    } else if (type == 'right') {
		      return this.replace(new RegExp('\\'+char+'+$', 'g'), '');
		    }
		    return this.replace(new RegExp('^\\'+char+'+|\\'+char+'+$', 'g'), '');
		  }
		  return this.replace(/^\s+|\s+$/g, '');
		};

    //点赞
    
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
</script>
<!-- <script src="js/amazeui.js" async="async" ></script> -->
