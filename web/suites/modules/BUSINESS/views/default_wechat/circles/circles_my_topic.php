<?php
$mac_type = $this->session->userdata("mac_type");
if(!$mac_type){?>
<style>
.dynamic{
padding-top:0px;	
}
.circle_zhong {padding-top: 0;border-top: 10px solid #eeeeee;}
.xuanz{
	transform:rotate(90deg);
-ms-transform:rotate(90deg); 	/* IE 9 */
-moz-transform:rotate(90deg); 	/* Firefox */
-webkit-transform:rotate(180deg); /* Safari 和 Chrome */
-o-transform:rotate(90deg); 	/* Opera */ 
display: inline-block;
}
</style>
<?php }?>
<!--  <link rel="stylesheet" type="text/css" href="css/animate.css"> -->
 <link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
 <script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
 
   <!--圈子内容-->
  <div class="container">
     <div class="dynamic">
		<ul>
            <li>
                <a href="javascript:;" id="suos3">
                	<p class="icon-topic_of_conversatio"></p>
                	<h1>发布话题</h1>
               </a>
            </li>
            <li>
                <a href="<?php echo site_url('Circles/My_Message/?tribe_id='.$tribe_id)?>">
                	<p class="icon-history"></p>
                	<h1>历史消息</h1>
               </a>
            </li>
		</ul>
	</div>
  
     <div class="circle_zhong" style="margin-top:0">
        <ul class="circle_zhong_ul" id="list">
         
          
          
          
          
         
        </ul>
     </div>  
  </div>
  
  
  <!--通用删除评论-->     
    
     <div class="delete_pinglun" id="con" hidden >
        <div class="delete_nei">
          <ul>
              <li class="delete_nei_hui">
              <a href="javascript:void(0);">确定删除该话题？</a>
              </li>
              <li class="delete_nei_h">
              <a href="javascript:void(0);" onclick="Del_Comment()" id="del_btn">删除</a>
             </li>
             <li class="delete_nei_b cancels">
              <a href="javascript:void(0);" onclick="comment_hide();">取消</a>
            </li>
          </ul>
        </div>
     </div>   
  
	<div class="delete_pinglun" id="conn" hidden>
        <div class="delete_nei">
          <ul>
              <li class="delete_nei_t">
              <a href="<?php echo site_url('Circles/Add_Topic/1/?tribe_id='.$tribe_id)?>">发文字</a>
              </li>
              <li class="delete_nei_z">
              
               <a href="<?php echo site_url('Circles/Add_Topic/?tribe_id='.$tribe_id)?>">发图文</a>

             </li>
             <li class="delete_nei_b cancels">
              <a href="javascript:void(0);" onclick="comment_hide();">取消</a>
            </li>
          </ul>
        </div>
     </div>  

<script src="js/amazeui.js"></script>
<!--超出字显示查看更多-->
<script> 
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


	


<!--点击置顶变颜色-->

$(function(){
  $(".icon-not_top").click(function(){
    $(this).eq($(this).index()).toggleClass("current_page_item");

  })

  $('#suos3').click(function(event)
  {
        event.stopImmediatePropagation();//取消事件冒泡；
        $('#conn').show();
    	$('#con').hide();
    	
    	
    });
    $(".delete_pinglun").bind("click",function(){
    	$('#conn').hide();
    })
})

function comment_hide()
{ 
	$('#conn').hide();
  	$('#con').hide();
}
	var page = 1;//默认加载页数
    var tribe_id = <?php echo $tribe_id?>
	//下拉加载数据
	dropload = $('.circle_zhong').dropload({
		scrollArea : window,
	    loadDownFn : function(me){
    	    //加载菜单一的数据
    		$.ajax({ 
    		    url:'<?php echo site_url('Circles/Topic_List/1')?>',
    		    type:'get',
    		    dataType:'json',
    		    data:{'tribe_id':'<?php echo $tribe_id?>','page':page},
    		    success:function(data)
    		    {
    		    	
		     		if( data.list.length > 0 )  
		     		{  
        		   	   
		     			
        		    	for( var i=0; i<data.list.length;i++ )
   	 			        {
       	 			        
    		    		    var html = '';
        		            html+='<li id="topic_'+data.list[i]['id']+'">'
        		            html+='<div class="circle_zhong_ul_li">'
    		            	html+='<div class="circle_zhong_ul_top">' 
		            		html+='<div class="circle_zhong_ul_xia">'
	            			html+='<a href="javascript:;">'
            				html+='<div class="circle_zhong_dd">'
        					html+='<h2><span class="circle_zhong_hi"></span><samp class="circle_zhong_hr">'+data.list[i]['created_at']+'</samp></h2>'
    						if( data.list[i]['sort'] == 1 )
       	 			        {
           	 			        
           	 					html += '<span class="zhidingd">已置顶</span>';
       	 			        }
    						

							html+='</div>'
							html+='</a>'
							html+='</div>'
							html+='</div>'
							html+='<div class="circle_zhong_ul_neirong" id="box_'+data.list[i]['id']+'">'
							html+= '<a href="<?php echo site_url('Circles/Topic_Detaile')?>/'+data.list[i]['id']+'/?tribe_id='+tribe_id+'"><p>'+data.list[i]['content']+'</p></a>';
       						html+='</div>'
							html+='</div>' 
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
								
							html+='<dl class="circle_zhong_dl">'
							var dianzan_class = '';
       						
       						if(  data.list[i]['my_upvote'] != 0 )
       						{ 
       							
       							dianzan_class = 'icon-already_praised1 bounceIn';
       						}
       						
// 							html+='<dd><span><i class="icon-not_praise '+dianzan_class+' " id="dianzan_'+data.list[i]['id']+'" onclick="upvote('+data.list[i]['id']+')"><span class="zan_num">'+data.list[i]['upvote_num']+'</span></i></span></dd>'

							html += '<dd><span><i class="icon-not_praise '+dianzan_class+' " id="dianzan_'+data.list[i]['id']+'" onclick="upvote('+data.list[i]['id']+')"><span class="zan_num">';
       						if(data.list[i]['upvote_num'] == 0 || data.list[i]['upvote_num'] == "0"){
       							html += '赞';
           						}else{
           							html += data.list[i]['upvote_num'];
               						}
       						html += '</span></i></span></dd>';

//							html+='<dd><a href="<?php echo site_url('Circles/Topic_Detaile')?>/'+data.list[i]['id']+'/?tribe_id='+tribe_id+'"><span><i class="icon-comment1"></i>'+data.list[i]['comment_num']+'</span></a></dd>'
							html += '<dd><a href="<?php echo site_url('Circles/Topic_Detaile')?>/'+data.list[i]['id']+'/?tribe_id='+tribe_id+'"><span><i class="icon-comment1" style="vertical-align: text-bottom;"></i>';
       						if(data.list[i]['comment_num'] == 0 || data.list[i]['comment_num'] == "0"){
       							html += '评论';
           						}else{
           							html += data.list[i]['comment_num'];
               						}
       						html += '</span></a></dd>';
       					    var cus_id = <?php echo $this->session->userdata("user_id"); ?>;
          					 if(data.list[i]['customer_id'] == cus_id){
           						html+='<dd><a href="javascript:Show_Delete('+data.list[i]['id']+')"><span><i class="icon-delete"></i>删除</span></a></dd>'
           						 }	
							<?php if( $role ){?>
							
							html+='<dd><a href="javascript:Top('+data.list[i]['id']+');"><span>';
							if(data.list[i]['sort'] == 1){
								html+= '<i class="icon-not_top xuanz"></i>';
								}else{
									html+= '<i class="icon-not_top"></i>';
									}
							html+= '</span></a></dd>';
							<?php } ?>
							html+='</dl>'
							html += '<div class="dianzan_name diannan_'+data.list[i]['id']+'"';
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
		                            	  html += '<span id="upvote_'+data.list[i]['id']+'_'+data.list[i]['upvote_info'][j]['customer_id']+'">'+(data.list[i]['upvote_info'][j]['real_name'] ? data.list[i]['upvote_info'][j]['real_name'] : data.list[i]['upvote_info'][j]['member_name'])+'</span><span class="douhao" style="display:none">,</span>';
		                                  }else{
		                                	  html += '<span id="upvote_'+data.list[i]['id']+'_'+data.list[i]['upvote_info'][j]['customer_id']+'">'+(data.list[i]['upvote_info'][j]['real_name']?data.list[i]['upvote_info'][j]['real_name']:data.list[i]['upvote_info'][j]['member_name'])+'</span><span class="douhao">,</span>';
		                                      }
		                              }
		                         
		             			  }
		                    html += '</div>';
							html+='</li>'

							$('#list').append(html); 
       						show(data.list[i]['id']); 
        				}
        				
       	 			    page++;
    				    me.resetload();
                        $.getScript("js/amazeui.js");
                        
    			    }else{
    				    
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

	 //点赞
    function upvote( id )
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
			data:{'tribe_id':<?php echo $tribe_id?>,'obj_id':id},
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
			 	$('#dianzan_'+id).attr("onclick",'upvote('+id+')');
		 	},
		 	error:function()
		 	{
		 		$('#dianzan_'+id).attr("onclick",'upvote('+id+')');
		 	}
		})
	  }
	  
    function Show_Delete(id)
    { 
    	topic_id = id;
    	
    	$('#conn').hide();
      	$('#con').show();
      	
    }

    function Del_Comment()
    { 
    	$('#conn').hide();
      	$('#con').hide();
    	
		$.ajax({ 
			url:'<?php echo site_url('Circles/Delete_Topic');?>/'+topic_id,
			type:'get',
			data:{'tribe_id':<?php echo $tribe_id?>},
			dataType:'json',
			success:function(data)
			{

				$(".black_feds").text( data.message ).show();
				setTimeout("prompt();", 2000);
				
				if(data.status)
				{ 
					$('#topic_'+topic_id).remove();
				}
				
				
				
			},
			error:function()
			{
				$(".black_feds").text( '服务器异常，请稍后再试' ).show();
				setTimeout("prompt();", 2000);
			}
		})
    	
    	
    }

    function Top( id )
    { 
    	$.ajax({ 
			url:'<?php echo site_url('Circles/Upadte_Topic');?>/'+id,
			type:'get',
			data:{'tribe_id':<?php echo $tribe_id?>},
			dataType:'json',
			success:function(data)
			{

				$(".black_feds").text( data.message ).show();
				setTimeout("prompt();", 2000);
				
				if(data.status)
				{ 
					setTimeout("location.reload()", 500);
				}
				
			},
			error:function()
			{
				$(".black_feds").text( '服务器异常，请稍后再试' ).show();
				setTimeout("prompt();", 2000);
			}
		})
    }
    
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
		
</script>