<style type="text/css">
   .container {background:#f6f6f6;}
   .page {padding-top: 50px;}
   .register-num {width: 62%;}
   .register-button {background: #FECF0A !important; color: #262626 !important; font-size: 18px !important;}
   .register-button {margin: 30px auto 20px auto;}
    input[type=checkbox]{border: 0!important;background:rgba(0,0,0,0);}
</style>
<?php if($mac_type){ ?>
<!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:history.back()" class="icon-right"></a><span>担保申请</span>
</div>
<?php }?>
<?php if( !empty($status ) ) :?>

<!-- 选择担保人 -->

<?php if( $list ){?>
<?php $this->load->view('message_ok');?>

<div id="index" >
    <div class="tribe-choice">
    	<!-- 列表 商品 -->
    	<div class="tribe-choice">
    		<ul id="tribe-choice-list">
    		<?php foreach ($list as $v):?>
        		<?php if( $v['total_guarantee_money'] < $v['guarantee_from_ceiling'] && $v['customer_id'] != $my_customer_id):?>
                    <li id="<?php echo 'customer_'.$v['customer_id']?>">
        				<div class="tribe-choice-header">
        					<input type="checkbox" name="check_customer" value="<?php echo $v['customer_id']?>"class="icon-roundcheckfill icon-round tribe_choose-icon">
        					<ul>
        						<li class="tribe-choice-tu"><a href="javascript:void(0);"><img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/member_defult.png'" height="70" width="70" alt=""></a></li>
        						<li class="tribe-choice-test"><span class="fn-16"><?php echo $v['member_name']?><i><?php echo $v['role_name']?></i></span>
        							<span class="choice_bondsman_three"><?php echo $v['corporation_name']?></span></li>
        						<li class="choice_bondsman_money"><span class="fn-18"><?php echo !empty($v['guarantee_ceiling']) && $v['guarantee_ceiling'] > 0 ? $v['guarantee_ceiling']/10000 : 0 ?>万</span><span
        							class="fn-15">担保金额</span></li>
        					</ul>
        				</div>
        			</li>
    			<?php endif;?>
			<?php endforeach;?>
    		</ul>
    	</div>
    </div>
<?php }?>

<div style="height:60px;opacity: 0;"></div>

<!-- 底部结算 -->
    <div class="tribe-choice-count-nav container-center">
        <span class="pt05">担保申请额：0万</span><a id="sub" href="javascript:void(0);"
    		class="tribe-go-count">提交申请</a>
    </div>
</div>
<script type="text/javascript">
$(function(){ 
	
    var ceiling = '<?php echo $ceiling?>';
    document.getElementById('sub').addEventListener('click',ajax_submit);

     // 点击某一个input
    $("#tribe-choice-list li input").click(function(){
    	//计算
        if( !calculate() )
        {
       	    $(this).attr('checked',false); 
            return; 
        }
        
        if(this.checked){
           $(this).removeClass('icon-round');   
           $(this).addClass('cf');   

       }else{     
           $(this).addClass('icon-round');   
           $(this).removeClass('cf');   
        }    

        
    })
         
    function calculate()
    {
        var total = 0;
      	$("#tribe-choice-list li input:checked").each(function(){ 
           	 
            var _price = $(this).next('ul').children('li').eq(2).find('span').eq(0).text();
            _price = _price.substring(0,_price.length-1);
            total += parseFloat(_price);
            
       	}) 

       	 if( total*10000 > ceiling)
       	 {
        		$(".black_feds").text("超出可申请担保额度").show();
                setTimeout("prompt();", 2000);   
                return false;
       	 }
         document.getElementById('sub').previousElementSibling.innerText='担保申请额：'+total+'万提货权';

         return true;
    }
    
    function ajax_submit()
    { 
    	check=[];
    	var obj = document.getElementsByName('check_customer');

        for( var i=0; i<obj.length; i++)
        {   
            if( obj[i].checked  )
            {
            	check.push( obj[i].value );
            }
        }

        if( check == 0 )
        {
        	$(".black_feds").text("请选择担保人").show();
            setTimeout("prompt();", 2000);   
            return;
        }

        $.ajax({ 
            url:'<?php echo site_url('Credit/Request_Guarantee')?>',
            type:'post',
            dataType:'json',
            data:{'check_customer':check,'tribe_id':'<?php echo $tribe_id?>'},

            beforeSend:function()
            { 
            	document.getElementById('sub').style.background='#ccc';
	        	document.getElementById('sub').text='申请中....';
	        	document.getElementById('sub').removeEventListener("click", ajax_submit);
            },
            success:function(data)
            {
                if(data.status == 1)
                {
                	//设置成功提示页面
    	        	var message_view = document.getElementById('message_view');
    	            var location = "window.location = '<?php echo site_url('customer/fortune')?>'";
    	            <?php 
    	            		$mac_type = $this->session->userdata("mac_type");
    	            		if(isset($mac_type) && $mac_type =='APP' ){ ?>
    	            		location = "window.location = '<?php echo site_url('Tribe/Members_List').'/'.$tribe_id?>'";
    	            <?php }?>  		    	            
    	            document.getElementById('index').style.display="none";
    	            message_view.style.display="block";
    	            message_view.children[1].innerHTML='您的担保申请已提交';
    	            message_view.children[2].innerHTML='客服会在24小时内与您联系！';
    	            message_view.children[3].children[0].setAttribute('onclick',location);
    	            return;
                    
                }else if( data.status == 6)
                {
                    
                	var thisNode=document.getElementById("customer_"+data.customer_id);
                	thisNode.parentNode.removeChild(thisNode);
                	
                }

                $(".black_feds").text(data.message).show();
                setTimeout("prompt();", 3000);
                
                document.getElementById('sub').addEventListener('click',ajax_submit);
	            document.getElementById('sub').style.background='#FECF0A';
	            document.getElementById('sub').text='提交申请';
               
            },
            error:function()
            {
            	$(".black_feds").text("申请失败,请稍后再试").show();
	            setTimeout("prompt();", 3000);
            	document.getElementById('sub').addEventListener('click',ajax_submit);
	            document.getElementById('sub').style.background='#FECF0A';
	            document.getElementById('sub').text='提交申请';
            }
        })
    }
})


</script>


<?php else:?>
<script type="text/javascript">

    var error_messgae = "<?php echo $message?>";
    alert(error_messgae);
    history.back();
             
    </script>

<?php endif;?>
