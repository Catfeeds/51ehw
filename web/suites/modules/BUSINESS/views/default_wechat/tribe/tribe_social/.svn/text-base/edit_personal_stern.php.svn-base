<style type="text/css">
  .container {background:#f6f6f6;}
  .tribal_avatar_bottom {margin-top: 100px;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>完善资料</span>
</div>
<?php }?>
<!-- 个人亮点 -->

<div class="clans_personal_stern">
  <div class="clans_stern_list">
  	<?php 
  	
  	//处理亮点数据。
  	if( $customer_info['merit'] )
  	{
  	    $merit = explode('/', trim( $customer_info['merit'],'/' ) );
  	     
  	}
  	
  	if( !empty( $merit ) ){?>
      	<?php foreach ( $merit as $v ){?>
        	<span><?php echo $v?></span>
        <?php }?>
    <?php }?>
    <input type="text" value="" placeholder="添加亮点" name="new_merit">
   
  </div>
  <div class="clans_stern_list_text"><span>还可以添加<i><?php echo 3 - ( !empty($merit) ? count($merit) : 0 )?></i>个亮点</span></div>
  
  <div class="clans_personal_stern_tishi">
    <p>示例：</p>
    <p>专注智能硬件领域  专攻欧美市场  产业互联网专家</p>
  </div>  

  <div class="tribal_avatar_bottom">
   <ul class="tribal_avatar_bottom_ul">
     <li><a class="tribal_avatar_top_a" href="javascript:save_sub()">保存</a></li>
   </ul>
</div>



</div>

<script type="text/javascript">


$('input').on('keydown', function(e) {
    var key = e.which || e.keyCode;

    if ( key == 8 && $('input').val()== '') {
    	$('.clans_stern_list span:last').remove();

    	$('.clans_stern_list_text span').find('i').text( 3 - $('.clans_stern_list span').length );
    };
  
 });


function save_sub()
{ 
	var new_merit = $('input[name=new_merit]').val();
	var i = 0;
	var text = '';
	$('.clans_stern_list span').each(function(){ 

		i++;
		text += $(this).text()+'/';
		
	});

	if( new_merit )
	{
		text += new_merit+'/';
		i++;
	}
	console.log(i);
	console.log(text);
	
	if( i == 0 )
	{ 
		$(".black_feds").text('亮点不能为空').show();
		setTimeout("prompt();", 2000); 
		
	}else if ( i > 3 )
	{ 
		$(".black_feds").text('个人亮点不能超过3个').show();
		setTimeout("prompt();", 2000); 
		
	}else { 
		
		$.ajax({ 
			url:'<?php echo site_url('Tribe_social/Update_Customer_Info')?>',
			type:'post',
			dataType:'json',
			data:{merit:text},
			success:function(data)
			{
			    if( data.status == 1 && new_merit)
			    { 
			    	$('input[name=new_merit]').before("<span>"+new_merit+"</spabn>");
			    	$('input[name=new_merit]').val('');
			    	var num = parseInt( $('.clans_stern_list_text span').find('i').text() ) - 1;

			    	$('.clans_stern_list_text span').find('i').text(num);
			    }
				$(".black_feds").text(data.message).show();
				setTimeout("prompt();", 2000); 
				
				 
		       	return false;
			},
			error:function()
			{
				$(".black_feds").text('网络异常，请稍后再试').show();
				setTimeout("prompt();", 2000); 
		       	return false;
			}
		})

	}



	
}
</script>