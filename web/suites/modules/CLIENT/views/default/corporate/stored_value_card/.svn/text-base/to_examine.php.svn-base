  <script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
   	<?php //储蓄卡头部菜单导航  
        $data['head_menu'] = 3;
        $this->load->view('corporate/stored_value_card/head',$data);
    ?>
    <!--左边-->
<div class="Box manage_new_Box clearfix">
        <div class="cmLeft manage_new_cmLeft">
            <div class="downTittle manage_new_downTittle menu_manage_downTittle">我是承兑商</div>
            <div class="cmLeft_down cmLeft_downww">
            	<ul>
            		  <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>">全部</a></li>
                      <li class="houtai_zijin_current"><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/1')?>">未审核</a></li>
                	  <li ><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/2')?>">已审核</a></li>
                      <li><a href="<?php echo site_url('Corporate/Savings_card/Convert_List/3')?>">已拒绝</a></li>
                </ul>
            </div>
        </div>
       <!--左边结束--> 
       <!--右边-->  
         <div class="stored_top">
            <div class="stored_top_sh">线上储值卡申请审核</div>
            <div class="stored_ch">
               <ul class="stored_ch_ul">
                 <li><span>申请方用户ID：</span><?php echo $detaile['customer_id']?></li>
                 <li><span>申请方用户名：</span><?php echo $detaile['name']?></li>
                 <li><span>申请方企业名：</span><?php echo $detaile['corporation_name']?></li>
                 <li><span>申请额度：</span><?php echo $detaile['card_amount']?></li>
                 <li><span>有效期：</span><?php echo $detaile['start_time']?> 至 <?php echo $detaile['end_time']?></li>
                 <li class="stored_ch_ul_lo"><span>申请资料：</span>
                 <?php if( $detaile['images'] ) {?>
                     <div class="stored_ch_ul_fi">
                     <?php foreach ( $detaile['images'] as $v ){ //images/shenhe.jpg?>
                         <p><a target="_blank" href='<?php echo IMAGE_URL.$v?>'><img src="<?php echo IMAGE_URL.$v?>" onerror="this.src='images/shenhe.jpg'" /></a></p>
                     <?php }?>
                         
                     </div>
                 <?php }else{?>
                 
                 	<p><img src="images/shenhe.jpg"/></p>
                 	
                 <?php }?>
                 </li>
               </ul>
               
          
               
               <div class="stored_ch_bottom">
                 <a href="javascript:;" class="stored_ch_left" onclick="sub_window(1)">通过</a>
                 <a href="javascript:;" class="stored_ch_zhong" onclick="sub_window(2)">不通过</a>
                 <a href="<?php echo site_url('Corporate/Savings_card/Convert_List')?>" class="stored_ch_rigth">返回</a>
               </div>
               
            </div>  
            
            
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang" hidden>
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">温馨提示</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id="sub_message">请选择活动</p>
      </div>
      <div class="dingdan4_3_tanchuang_btn">
          <div style="width: 400px;overflow: hidden;margin: 0px auto;">
              <div class="dingdan4_3_btn02"><a href="javascript:void(0);" id="sub_apply" onclick="$('.dingdan4_3_tanchuang').hide()">确定</a> </div>  
              <div class="dingdan4_3_btn01" style="background:#ccc;margin-left:100px;">  <a href="javascript:void(0);" onclick="$('.dingdan4_3_tanchuang').hide()">取消</a></div>     
          </div>
      </div>
  </div>
</div>
            
            
            
         </div>
       <!--右边结束-->    
         </div>



     


<script>
var status = 1;

function sub_window( choose_status )
{ 
	status = choose_status;
	
	if( choose_status == 1 )
	{ 
		$('#sub_message').text('确定通过审核吗？');
		
	}else{ 
		
		$('#sub_message').text('确定不通过审核吗？');
	}
	
	$('#dingdan4_3_tanchuang').show();
}

$('#sub_apply').bind('click',function(){ 

	$.ajax({ 
		url:'<?php echo site_url('Corporate/Savings_card/Convert_Apply_Card/')?>',
		data:{'status':status,'id':<?php echo $detaile['id']?>},
		type:'get',
		dataType:'json',
		success:function(data)
		{
			alert(data.message);
			
			if( data.status  )
			{ 
				window.setTimeout("window.location.href='<?php echo site_url('Corporate/Savings_card/Convert_List') ?>'", 1000);   
			}

		},
		error:function()
		{
			alert('服务器异常，请稍后再试');
		}
		
	})
}) 
</script>

	