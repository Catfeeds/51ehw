<?php if( isset( $error ) ){?>

<script type="text/javascript">


$(".black_feds").text('<?php echo $error['message']?>').show();
setTimeout("prompt();", 2000);


<?php if( isset( $error['redirect_url'] ) ){?>
	window.setTimeout("window.location.href='<?php echo $error['redirect_url']?>'", 1000);   
	
<?php }?>

</script>
<?php }else{?>

<link rel="stylesheet" href="css/dropload.css"><!-- 下拉插件 -->
<script type="text/javascript" src="js/dropload.min.js"></script><!-- 下拉插件 -->


<style type="text/css">
	.container {background: #ECECEC;}
</style>

<!-- 投票 -->
<div class="vote">
	<!-- banner 图 -->
	<div><img src="<?php echo IMAGE_URL.$vote_info['banner']?>" alt=""></div>	
	<div class="vote_box">
      <!-- 标题 -->
      <div class="vote_title"><span><?php echo $vote_info['title']?></span></div>
      <!-- 投票情况 -->
      <div class="vote_situation">
      	<ul>
      	    <li><span>参与项目</span><em><?php echo $project_num;?></em></li>
      	    <li><span>累计投票</span><em><?php echo $staff_num;?></em></li>
      	    <li><span>访问次数</span><em><?php echo $vote_info['visits']?></em></li>
      	</ul>
      </div>
      <!-- 时间 -->
      <div class="vote_time"><em class="icon-time"></em>开始时间：<span><?php echo $vote_info['start_time']?></span></div>	
      <div class="vote_time"><em class="icon-time"></em>截止时间：<span><?php echo $vote_info['end_time']?></span></div>	
    </div>
    <!-- 投票规则 -->
    <div class="vote_rule"><em class="icon-cuowu"></em><span><?php echo $vote_info['rule'] ? $vote_info['rule'] : '暂无描述'?></span></div>
    <!-- 投票简介 -->
    <div class="vote_account">
    	<div class="vote_account_head"><em class="icon-form"></em>投票简介：<em class="icon-xiala icon-fold vote_xiala_icon"></em></div>
    	<div class="vote_account_text_box" style="display: none;">
    		<div class="vote_account_text"><span><?php echo $vote_info['abstract']?></span></div>
    	    <div class="vote_account_text_all"><span>查看全文</span></div>
    	</div>
    </div>
</div>	

<!-- 搜索项目 -->
<div class="vote_search">
	<div class="vote_search_box">
		<input type="text" placeholder="请输入项目编号或名称" name='search'>
	</div>
	<input type="submit" value="搜索" class="vote_search_button" onclick="menu(this)">
</div>

<!-- 项目列表 -->
<div id='vote_loading'>

    <div class="vote_item">
    	<ul id="option_list">
    	    
    	</ul>
	</div>
    
    <!-- 项目排名情况 -->
    <div class="vote_ranking_box" hidden>
      <table>
        <tr>
          <th>排名</th>
          <th>项目名称</th>
          <th>票数</th>
        </tr>
       
      </table>
    </div>
</div>
<!-- 当前排名 -->
<a href="javascript:;" class="vote_ranking" onclick="menu(this)"><?php echo empty( $type ) ? '当前排名' : '返回首页'?></a>
<!-- 投票规则 -->
<a href="javascript:void(0);" class="vote_rule_get">投票规则</a>

<?php $this->load->view('tribe/tribe_vote/vote_sub'); ?>


<script type="text/javascript">

	var vote_menu = '<?php echo !empty( $type ) ? 2 : 1 ?>';
	var page = 1;//默认加载页数
	var is_show_staff = <?php echo $vote_info['result']?>;

	function vote_sub(obj,id,staff_num)
    { 
		votestaff_sub(obj,id,staff_num,'<?php echo site_url('Activity/Tribe_vote/VoteSub/')?>/'+id);
    }
	
    // 点击简介
    $('.vote_account_head').on('click',function(){
    	$(this).children('.vote_xiala_icon').toggleClass('icon-xiala');
    	$('.vote_account_text_box').toggleClass('display_block');
    })
	$('.vote_account_text_all').on('click',function(){
		$(this).hide();
		$('.vote_account_text span').addClass('vote_account_text_active');
	})
	
	if( vote_menu  == 1  ) 
	{ 
		$('.vote_item').show();
		$('.vote_ranking_box').hide();
		
	}else if( vote_menu == 2 )
	{ 
		$('.vote_item').hide();
		$('.vote_ranking_box').show();
	}
	
	function menu(obj)
	{

    	if( !$('span').hasClass('loading') )
        { 
        	if( $(obj).text() == '当前排名' ) 
        	{ 
        		vote_menu = 2;
    			$('.vote_item').hide();
    			$('.vote_ranking_box').show();
    			$(obj).text('返回首页');
    			
        	}else if( $(obj).text() == '返回首页')
        	{ 
        		vote_menu = 1;
        		$('.vote_item').show();
    			$('.vote_ranking_box').hide();
    			$(obj).text('当前排名');
    			
        	}
    
        	$('.vote_ranking_box table tr:gt(0)').remove();
        	$('#option_list').empty();
        	
    		page = 1;
            // 解锁
            dropload.unlock();
            dropload.noData(false);
            // 重置
            dropload.resetload();
        }

	}
 
    //下拉加载数据
    dropload = $('#vote_loading').dropload({
    	scrollArea : window,
        loadDownFn : function(me){
    	    //加载菜单一的数据
    		$.ajax({ 
        		url: '<?php echo site_url('Activity/Tribe_vote/OptionList/'.$vote_info['id'])?>/'+vote_menu,
        		type:'get',
    		    dataType:'json',
    		    data:{'page':page,'search_name':$('input[name=search]').val(),'vote_type':<?php echo $vote_info['vote_time'] ?>},
    		    beforeSend:function (XMLHttpRequest) {
    		        
    	        	XMLHttpRequest.setRequestHeader("request_type","ajax");
    	        	
    	        },
    		    success:function(data)
    		    {
    		    	if( data.message )
    			    { 
    			    	$(".black_feds").text(data.message).show();
    		    		setTimeout("prompt();", 1000);
    			    }
    			    
        		    if( data.redirect_url )
        		    { 
            		    window.setTimeout("window.location.href='"+data.redirect_url+"'", 1000);  
        		    }
        		    
    		    	if( data.data.list.length > 0 )
    	    	    {    		 
      		    	    var list = data.data.list;
      		    	    limit = data.data.limit;
      		    	    
      		    	    $(data.data.type == 1 ? '#option_list' : '.vote_ranking_box table').append(list_html(list)); 
    
       	 			    page++;
    				    me.resetload();
    				    
    			    }else{
    				    
    			    	//锁定
    	                me.lock();
    	                // 无数据
    	                me.noData();
    	                me.resetload();
    			    }
    	    	},
    		    error:function(){
        		    
        		    //锁定
                    me.lock();
                    // 无数据
                    me.noData();
                    me.resetload();
    		    },
    		    
    		})
    
    	}
    });


function list_html(list)
{ 
	var html = '';
	var image_url = '<?php echo IMAGE_URL?>';
	if( vote_menu == 1 )
	{ 
		for( var i =0 ;i<list.length;i++)
 	    { 
			html+='<li><a href="<?php echo site_url('Activity/Tribe_vote/OptionDetaile')?>/'+list[i]['id']+'">';
    	    html+='<div class="vote_item_name"><span>'+list[i].id+'.'+list[i].option_title+'</span></div>';
    	    <?php if( $vote_info['vote_type'] ){?>
    	    	html+='<div class="vote_item_img"><img src="'+image_url+list[i].option_img+'" alt=""></div>';
    	    <?php }?>
    	    html+='</a>';
    	    
    	    html+='<div>';
    	    if( list[i].is_vote )
    	    { 
    	    	html+='<input type="submit" onclick="vote_sub(this,'+list[i].id+','+list[i].votes_num+')" class="vote_get" value="投票">';
    	    }else{ 
	    	    html+='<input type="submit" value="已投票" style="background: #ECECEC"; class="vote_get">';
    	    }
    	    
    	    html+='<div class="vote_item_num" '+(!is_show_staff ? 'hidden' : '')+'><span id=staff_option_'+list[i].id+'>'+list[i].votes_num+'票</span></div>';
    	    html+='</div></li>';
 	    }
 	    
	}else{ 

		
		var rank = (page > 1 ? page-1 : 0)*limit;
		
		for( var i = 0 ;i<list.length;i++)
 	    { 
	 	    html+='<tr>';
			html+='<td>第'+list[i].position+'名</td>';
			html+='<td>'+list[i].option_title+'</td>';
			html+='<td>'+ (is_show_staff ? list[i].votes_num : '投票后显示结果')+'</td>';
			html+='</tr>';
			
 	    }

	}

	return html;
}

</script>

<?php }?>