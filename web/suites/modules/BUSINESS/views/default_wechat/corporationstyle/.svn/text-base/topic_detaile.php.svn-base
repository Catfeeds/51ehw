<script type="text/javascript" src="js/format_time.js"></script><!-- 时间函数 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->
<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->

<style>
.circle_zhong{padding-top:0px;}
.circle_zhong_ul li {border-bottom: 0;}
.hot_circle_study_top {}
.hot_circle_study_gun {white-space: normal;width: 23.5rem;font-size: inherit;}
.hot_circle_study_gun li {margin-right: 0px;float: left;overflow: hidden;margin-bottom: 5px;}
.hot_circle_study_gun li:nth-child(3n+1){ margin-right: 0.5rem;}
.hot_circle_study_gun li:nth-child(3n+2){ margin-right: 0.5rem;}
.hot_circle_study_gun li:nth-child(3n){ padding-left: 0;}
.circle_zhong_dl {margin-top: 1px;}
</style>

   <!--圈子内容-->

<div class="container">
     <div class="circle_zhong">
        <ul class="circle_zhong_ul">
         <li>
            <div class="circle_zhong_ul_li">
              <div class="circle_zhong_ul_top"> 
                  <a href=""><i><img src="<?php echo $topic_detaile['wechat_avatar'];?>" onerror="this.src='images/member_defult.png'"></i></a>
                  <div class="circle_zhong_ul_xia">
                  <a href="">
                  <div class="circle_zhong_dd">
                   <h2><span><?php echo $topic_detaile['real_name'] ? $topic_detaile['real_name'] : $topic_detaile['member_name']?></span><samp>企业</samp></h2>
                   <!--<span class="zhidingd">已顶置</span>-->
                  </div>
                   <p>
                   <span id="create_time"></span>
                   </p>
                   </a>
                   </div>
               </div>
               <div class="circle_zhong_ul_neirong" id="box">
                <p><?php echo $topic_detaile['content']?></p>
               </div>
            </div>  
            <?php if( $topic_detaile['images'] ){ 
                
                
                $img = explode(';', trim($topic_detaile['images'],';') );
               
                if( count($img) > 0 ){
                ?>
            <div  class="hot_circle_study_top <?php echo count($img) <= 1 ? 'hot_circle_study_qian' : ''?>">
              <ul data-am-widget="gallery" class="hot_circle_study_gun" data-am-gallery="{ pureview: true }">
              <?php foreach ( $img as $v ):?>
               <li>
                <a href="<?php echo IMAGE_URL.$v?>">
                 <img src="<?php echo IMAGE_URL.$v?>">
             	</a> 
               </li>
               <?php endforeach;?>
               
             </ul>  
          </div>  
          <?php } } ?> 
             <dl class="circle_zhong_dl">
              <dd><span><i id="dianzan_<?php echo $topic_detaile['id']?>"class="icon-not_praise <?php //echo $topic_detaile['my_upvote'] ? 'icon-already_praised1 bounceIn' : ''?>" onclick="upvote(<?php echo $topic_detaile['id']?>)" ><span class="zan_num"><?php echo $topic_detaile['upvote_num']? $topic_detaile['upvote_num']:"赞" ?></span></i></span></dd>
              <dd><a href="<?php //echo site_url('Circles/Comment/'.$topic_detaile['id'].'/?tribe_id='.$tribe_id)?>"><span><i class="icon-comment1" style="vertical-align: text-bottom;"></i><span  class="comment_num" ><?php echo $topic_detaile['comment_num']? $topic_detaile['comment_num']:"评论"?></span></span></a></dd>
               <dd><a href="<?php //echo site_url('Circles/Complaints/'.$topic_detaile['id'].'?tribe_id='.$tribe_id)?>"><span><i class="icon-jubao"></i>举报</span></a></dd>
               <?php if( isset($topic_detaile['corp_id']) && $topic_detaile['corp_id'] ){
                   if($this->session->userdata("user_id") == $topic_detaile['customer_id'] ){
                   ?>
              		<dd><a href="javascript:Delete_Topic(<?php echo $topic_detaile['id'];?>);"><span><i class="icon-delete"></i>删除</span></a></dd>
              <?php }
                }?>
             </dl>
             <div class="dianzan_name" <?php //if(count($topic_detaile['upvote_num']) <= 0){ echo "style='display:none;'";}?>>
             <i class="icon-not_praise icon-already_praised1 circles_dianzan"></i>
             <?php if(count($topic_detaile['upvote_info']) > 0){
                    foreach ($topic_detaile['upvote_info'] as $key =>$val){
                        if($key == count($topic_detaile['upvote_info'])-1){ ?>
                              <span id="upvote_<?php echo $val['customer_id'];?>"><?php echo $val['real_name'] ? $val['real_name'] : $val['member_name'];?></span><span class="douhao" style="display:none">,</span>
              <?php       }else{ ?>
                              <span id="upvote_<?php echo $val['customer_id'];?>"><?php echo $val['real_name'] ? $val['real_name'] : $val['member_name'];?></span><span class="douhao">,</span>
              <?php      }
                        ?>
             <?php }
             }?>
             </div>
          </li>
        </ul>
     </div>  
     
     <div class="detailed_comments">
       <div class="detailed_comments_top" hidden>
         评论 <span class="comment_num"><?php echo $topic_detaile['comment_num']?></span>
       </div>
     <ul class="detailed_comments_ul">
        <i class="icon-pinglun1" style="position: absolute;left: 7%;font-size: 14px;color: #69719e;top: 15px;"></i>
           
     </ul>
     </div>
     
  </div>
  
  <!--评论-->
  <div class="enter_comments">
      <div class="enter_comments_nei">
      <div class="enter_comments_nei_li" id="yanse">
		
			<span class="s_con"><a href=""><input  type="text" class="content" id="searc4" placeholder="请输入评论"  ></a><i class="clear" id="cls4"></i></span>
		
	</div>
<!--       <a href="#">发布</a> -->
      </div>
</div>

<!--通用删除评论-->     
     <div class="delete_pinglun" id="con" hidden>
        <div class="delete_nei">
          <ul>
              <li class="delete_nei_hui">
              <a href="javascript:void(0);">删除我的评论</a>
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


<script src="js/amazeui.js"></script>
<script type="text/javascript">
document.getElementById("searc4").addEventListener("keyup",function(){
	$(".content").css("width","calc(100% - 34px)");
	$(".content").css("border-radius","8px 0 0 8px")
	if(this.value.length>0)
	{
		document.getElementById("cls4").style.visibility="visible";
		document.getElementById("cls4").onclick=function()
		{
			document.getElementById("searc4").value="";
			document.getElementById("cls4").style.visibility="hidden";
			$(".content").css("width","100%")
			$(".content").css("border-radius","8px 8px 8px 8px")
		}
	}else
	{
		document.getElementById("cls4").style.visibility="hidden";
		$(".content").css("width","100%")
		$(".content").css("border-radius","8px 8px 8px 8px")
	}
});


function getDateDiff(dateTimes){
	dateTime = dateTimes.replace(/-/g,"/");
	var minute = 1000 * 60;
	var hour = minute * 60;
	var day = hour * 24;
	var halfamonth = day * 15;
	var month = day * 30;
	var thistime = new Date(dateTime);
	var now = new Date().getTime();
	var diffValue = now - thistime;
	var monthC =diffValue/month;
// 	var weekC =diffValue/(7*day);
	var dayC =diffValue/day;
	var hourC =diffValue/hour;
	var minC =diffValue/minute;
	if(monthC>=1){
		if(monthC >=12){
			result = dateTimes;
			}else{
				result = dateTimes.substring(5);
				}
	}else if(dayC>=1){
		 result= dateTimes.substring(5);
	}else if(hourC>=1){
		 result= parseInt(hourC) +"小时前";
	}else if(minC>=1){
		 result= parseInt(minC) +"分钟前";
	}else{
		 result="1分钟内";
	}
	return result;
}
</script>
<!--超出字显示查看更多-->

<!--点赞-->
<script>

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
		data:{'obj_id':id},
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
			 		var span_id = 'upvote_'+cus_id;
			 		$("#"+span_id).prev("span").remove();
					if(zan_num >= 1){
						$("#"+span_id).next("span").remove();
						}
					$("#"+span_id).remove();
					var html = $(".dianzan_name").html();
					if(zan_num == 0 || zan_num == "0" ){
						$(".dianzan_name").hide();
						}
			 	}else{
			 		zan_num +=1;
			 		$(".dianzan_name").show();
			 		var html = $(".dianzan_name").html();
			 		if(zan_num == 1 || html.length == "1" ){
			 			html += '<span id="upvote_'+cus_id+'"><?php echo $real_name ? $real_name : $member_name?></span>';
				 		}else{
				 			html += '<span class="douhao" >,</span><span id="upvote_'+cus_id+'"><?php echo $real_name ? $real_name : $member_name?></span>';
					 		}
			 		$(".dianzan_name").html(html);
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
function Delete_Topic(id,tribe_id)
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
				setTimeout(function(){
					window.location.href =	'<?php echo site_url("Circles")?>';
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
function Del_Comment()
{ 
	$.ajax({ 
		url:'<?php echo site_url('Circles/Delete_Comment');?>/'+com_id,
		type:'get',
		data:{'tribe_id':1},
		dataType:'json',
		success:function(data)
		{

			$(".black_feds").text( data.message ).show();
			setTimeout("prompt();", 2000);
			
			if(data.status)
			{ 
				$('#comment_'+com_id).remove();
				$('.comment_num').text( parseInt( $('.comment_num').eq(0).text() )-1 );
			}
			
		},
		error:function(){}
	})
}

function Show_Delete(id)
{ 
	com_id = id;
	
	$('#con').show();
}
</script>
<!--点击弹出弹窗-->
<script>

$(function()
{
    $('#create_time').text(getDateDiff('<?php echo $topic_detaile['created_at']?>') );
    	
    $('.detailed_comments_r').click(function(event)
    {
        event.stopImmediatePropagation();//取消事件冒泡；
    $('.delete_pinglun').show();
    });
    $(".delete_pinglun").bind("click",function(){
        $('.delete_pinglun').hide();
    })
});


    var page = 1;//默认加载页数
	//下拉加载数据
	dropload = $('.detailed_comments').dropload({
		scrollArea : window,
	    loadDownFn : function(me){
    	    //加载菜单一的数据
    		$.ajax({ 
    		    url:'<?php echo site_url('Circles/Topic_Comment/'.$topic_detaile['id'])?>',
    		    type:'get',
    		    dataType:'json',
    		    data:{'tribe_id':tribe_id,'page':page},
    		    success:function(data)
    		    {
    		    	
		     		if( data.list.length > 0 )  
		     		{  
        		   		for( var i=0; i<data.list.length;i++ )
   	 			        {
        		   			var message = '';
        		   			var parent_id = data.list[i]['parent_id'] == 0 ? data.list[i]['id'] : data.list[i]['parent_id'];
        		   			var a_url = '<?php echo site_url('Circles/Comment')?>/'+data.list[i]['obj_id']+'/?tribe_id='+tribe_id+'&to_name='+data.list[i]['member_name']+'&parent_id='+parent_id+'&to_customer_id='+data.list[i]['customer_id'];

        		   			if( <?php echo $customer_id?> == data.list[i]['customer_id'] )
        		   			{ 
            		   			a_url = 'javascript:Show_Delete('+data.list[i]['id']+')';
        		   			}
        		   			
					    	if( data.list[i]['to_customer_id'] )
						    { 
							    message = '回复'+data.list[i]['to_member_name']+'：';
							    
						    }
							    
        		    		var html = '';
        		    		    html+='<li id="comment_'+data.list[i]['id']+'">';
        		    		    html+='<div class="detailed_comments_ul_nei">'
    		    		    	html+='<a href="<?php //echo site_url('Tribe/Members_Info/'.$tribe_id)?>/'+data.list[i]['ts_id']+'"><i class=""><img src="'+data.list[i]['wechat_avatar']+'" onerror="this.src=\'images/member_defult.png\'"></i></a>'
		    		    		html+='<div class="detailed_comments_r">'
	    		    			html+='<a href="'+a_url+'">'
    		    				html+='<h2><span>'+(data.list[i]['real_name']?data.list[i]['real_name']:data.list[i]['member_name'])+'</span>';

    		    				if(data.list[i]['corp_id'])
    		    				{
    		    					html+='<samp>'+data.list[i]['corporation_name']+'</samp>';
    		    				}
    		    				html+='</h2>';
							    html+='<span class="circles_pinlun_time">';
								var result = getDateDiff(data.list[i]['created_at']);
								html+= result;
							    html+= '</span>';
    		    				html+='<h3>'+message+data.list[i]['content']+'</h3>';
	    						
    							html+='</a>';
        		                html+='</div>';
    		            	    html+='</div>';
		            		    html+='</li>';
			            		    
       							$('.detailed_comments_ul').append(html); 
//        						show(data.list[i]['id']); 
        		            
        				}
       	 			    page++;
    				    
    				    
    	                me.resetload();
                        
    			    }else{

    			    	if( page == 1 )
    				    { 
    				    	$('.dropload-down').hide();
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
	

</script>