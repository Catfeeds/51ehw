<style type="text/css">
   .container {background:#f6f6f6;}
   .page {padding-top: 5px;}
   .register-num {width: 62%;}
   .register-button { color: #262626 !important; font-size: 18px !important;}
   .register-button {margin: 30px auto 20px auto;}
</style>
<?php $this->load->view('message_ok');?>

<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
<!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:history.back()" class="icon-right"></a><span>授信申请</span>
</div>
<?php }?>


<!-- 易呗额度 -->
<div class="page" id="page">
    <div class="tribe_limit">
        <ul>
          <li>申请提货权
            <input type="text" id="m_credit" name="m_credit" placeholder="请输入金额" class="tribe_limit_input" onkeyup="value=value.replace(/[^\-?\d.]/g,'')" value="">
            <span></span>
          </li>
        </ul>
      </div>
    <!-- 登录 -->
    <div class="register-button">
    	<a class="tribe_limit_tijiao" id="sub">提交</a>
    </div>
</div>

<script type="text/javascript">

$( function (){ 

	document.getElementById('sub').addEventListener('click',ajax_submit);
	
    
    function ajax_submit(){ 

    	
    	var m_credit = document.getElementById('m_credit').value;

    	if( !m_credit || m_credit <= 0 )
    	{
            $(".black_feds").text("请输入正确的数值").show();
            setTimeout("prompt();", 2000);

    	}else{
        	  
    		$.ajax({ 
    	        url:"<?php echo site_url('Credit/Apply_Credit')?>",
    	        type:'post',
    	        dataType:'json',
    	        data:{ m_credit:m_credit },
    	        beforeSend:function(){     
//     		    	$("#pay_").css('background-color','#ccc');
    	        	document.getElementById('sub').style.background='#ccc';
    	        	document.getElementById('sub').text='申请中....';
    	        	document.getElementById('sub').removeEventListener("click", ajax_submit);

    		    },
    	        success:function(data)
    	        {
        	        if( data.status == 1 )
        	        {
        	        	//设置成功提示页面
        	        	var message_view = document.getElementById('message_view');
        	            var location = "window.location = '<?php echo site_url('customer/fortune')?>'";
        	            <?php 
        	            		$mac_type = $this->session->userdata("mac_type");
        	            		if(isset($mac_type) && $mac_type =='APP' ){ ?>
        	            		location = "window.location = '<?php echo site_url('Tribe/Members_List').'/'.$tribe_id?>'";
        	            <?php }?>  	
        	            document.getElementById('page').style.display="none";
        	            message_view.style.display="block";
        	            message_view.children[1].innerHTML='您的授信申请已提交';
        	            message_view.children[2].innerHTML='客服会在24小时内与您联系！';
        	            message_view.children[3].children[0].setAttribute('onclick',location);
        	            return;
        	            
        	        }else{

        	        	$(".black_feds").text(data.message).show();
        	            setTimeout("prompt();", 2000);
        	            document.getElementById('sub').addEventListener('click',ajax_submit);
        	            document.getElementById('sub').style.background='#FECF0A';
        	            document.getElementById('sub').text='提交';
        	        }
    	        	
    	        },
    	        error:function()
    	        {
    	        	$(".black_feds").text("申请失败,请稍后再试").show();
    	            setTimeout("prompt();", 2000);
    	            document.getElementById('sub').addEventListener('click',ajax_submit);
    	            document.getElementById('sub').style.background='#FECF0A';
    	            document.getElementById('sub').text='提交';
    	            
    	            
    	        },

        	})
        }
    }

})
</script>