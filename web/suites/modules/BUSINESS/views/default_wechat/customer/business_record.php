
  <div class="container" style="background-color:#e8e8e8">
     <div class="business_record_nav">
          <ul>
              <li class="business_record_nav01 business_record_active">货豆</li><span>｜</span>
              <li class="business_record_nav02">现金</li><span>｜</span>
              <li class="business_record_nav03">授信额度</li>
          </ul>
     </div>
     
     <!-- M卷 -->
     <div class="business_record_list">
          <?php if(count($m_log) > 0 ):?>
          <ul class="business_record_list_01" style="display: block;">
              <?php foreach ($m_log as $v):?> 
                  <li>
                    <p><span><?php echo $v['remark']?></span><span class="business_record_list_num1"><?php echo $v['type'] == 1 ? '+'.$v['amount'] : '-'.$v['amount']?></span></p>
                    
                    <?php if ( $v['id_event'] == 62 ):?>
                        <p>来源：<span><?php echo $v['name']?></span></p>
                    <?php endif;?>

                    <?php if(!empty($v['order_no']) ):?>
                        <p>单号：<span><?php echo $v['order_no']?></span></p>
                    <?php endif;?>
                    
                    <?php //if ( $v['id_event'] == 60 ):?>
                      <!--   <p>收款方：<span><?php //echo $v['corporation_name']?></span></p> -->
                    <?php // endif;?>
                    
                    <!-- 时间 -->
                    <p><span><?php echo $v['created_at']?></span>&nbsp;&nbsp;</p>
                    
                   
                      
                  </li>
              <?php endforeach;?>
          </ul>
          <?php endif;?>
          <!-- M卷结束 -->
          
          <!-- 现金 -->
          <?php if( count($cash_log) > 0 ):?>
          <ul class="business_record_list_02">
              <?php foreach ($cash_log as $v):?>
              <li>
                <p><span><?php echo $v['remark']?></span><span class="business_record_list_num1"><?php echo $v['type'] == 1 ? '+'.$v['cash'] : '-'.$v['cash']?></span></p>
                <p><span><?php echo $v['created_at']?></span>&nbsp;&nbsp;</p>
               <?php if(!empty($v['charge_no']) ):?>
                    <p>单号：<span><?php echo $v['charge_no']?></span></p>
                <?php endif;?>
              </li>
              <?php endforeach;?>
         </ul>
          <?php endif;?>
          <!-- 现金 -->
          
          <!-- 授信开始 -->
          <?php if( count($credit_log) > 0 ):?>
          <ul class="business_record_list_03">
              <?php foreach ($credit_log as $v):?>
                  <li>
                    <p><span><?php echo $v['remark']?></span><span class="business_record_list_num1"><?php echo $v['type'] == 1 ? '+'.$v['credit'] : '-'.$v['credit']?></span></p>
                    <p><span><?php echo $v['created_at']?></span></p>
                  </li>
              <?php endforeach;?>
          </ul>
          <?php endif;?>
          <!-- 授信结束 -->
    </div>
    <ul id="load" style="background-color:#FFFFFF"><h5 class="jiazai" style="display:none;text-align:center;line-height:20px;color:#c3c3c3">加载中...</h5> </ul>
  </div>
  <input type="hidden" value="1" id="status">
  
  <input type="hidden" value="2" id="limit_1">
  <input type="hidden" value="2" id="limit_2">
  <input type="hidden" value="2" id="limit_3">
  <input type="hidden" id="panduan" value="1">
  
  <script type="text/javascript">
		    
  $(window).scroll(function () {
		if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
		    var status = $('#status').val();
		    if(status == 1){
			    var limit = $('#limit_1').val();
			}else if(status == 2){
			    var limit = $('#limit_2').val();
			}else{
			    var limit = $('#limit_3').val();
			}
			
			if(!$('.business_record_list_0'+status).children('#ok_'+status).html()){ 
				if($('#panduan').val()==1){
			    	$('#panduan').val(0);
			    	onsearch(limit);	    	
			    }	
			}
		}
	    
	});


//滚动分页查询
  function onsearch(limit){
      var page = 15;
      var status = $('#status').val();
      
      $.ajax({
          url:"<?php echo site_url('log/ajax_transaction_list') ?>",
          type:"post",
          dataType:'json',
          data:{limit:limit,page:page,status:status},
          beforeSend:function(){
//           	$('#load').children('h5').html("加载中...");
          	$('#load').children('h5').show();
          },
          success:function(data){
            limit++;
              if( data.log.length>0){
                  var html = '';

                  if(status == 1){ 
                   	  for(var i=0;i< data.log.length;i++){
                      	  var form_or_to = data.log[i]['type'] == 1 ? '+' : '-';
                      	  
                		      html += '<li><p><span>'+data.log[i]['remark']+'</span><span class="business_record_list_num1">'+form_or_to+data.log[i]['amount']+'</span></p><p><span>'+data.log[i]['created_at']+'</span>&nbsp;&nbsp;</p>'
                            
                            if( data.log[i]['order_no'] )
                                html += '<p>单号：<span>'+data.log[i]['order_no']+'</span></p>'
                            
                            
//                             if ( data.log[i]['id_event'] == 60 )
//                           	  html += '<p>收款方：<span>'+data.log[i]['corporation_name']+'</span></p>'
                            
                            
                            if ( data.log[i]['id_event'] == 62 )
                                html +='<p>来源：<span>'+data.log[i]['name']+'</span></p>'
                            
                              
                           html+= '</li>';
                      }
                   
                  }else if(status == 2){ 
                   	  for(var i=0;i< data.log.length;i++){
                          var form_or_to = data.log[i]['type'] == 1 ? '+' : '-';
                      	  html += '<li><p><span>'+data.log[i]['remark']+'</span><span class="business_record_list_num1">'+form_or_to+data.log[i]['cash']+'</span></p>  <p><span>'+data.log[i]['created_at']+'</span>&nbsp;&nbsp;</p>'

                          if( data.log[i]['charge_no'] )
                          html += '<p>单号：<span>'+data.log[i]['charge_no']+'</span></p></li>'
                      }
                  }else{
                      
                   	  for(var i=0;i< data.log.length;i++){
                     	   var form_or_to = data.log[i]['type'] == 1 ? '+' : '-';
                           html += '<li><p><span>'+data.log[i]['remark']+'</span><span class="business_record_list_num1">'+form_or_to+data.log[i]['credit']+'</span></p><p><span>'+data.log[i]['created_at']+'</span></p> </li>';
                      } 
                  }
               
                  setTimeout(function(){
                  	$('#panduan').val(1);
                  	$('#load').children('h5').hide();
                  	$('#limit_'+status).val(limit);
                  	$('.business_record_list_0'+status).append(html);
                  },500);
                  
              }else{
              	html ='<li class=" clearfix" style="text-align:center;" id="ok_'+status+'">全部加载完毕</li>';
              	setTimeout(function(){
                  	
                  	$('#load').children('h5').hide();
                  	$('.business_record_list_0'+status).append(html);
                  },500);
              }
          },
          error:function(){
          	$('#panduan').val(1);
          	$('#load').children('h5').html("加载失败！");
          	$('#load').children('h5').show();
          },
      });
      
  }
	
  $(function(){
    $(".business_record_nav ul li").on("click",function(){
      var index = $(this).index();
      $(this).addClass("business_record_active").siblings().removeClass("business_record_active");
    })
  })
  $(function(){
    $(".business_record_nav01").on("click",function(){
      $(".business_record_list_01").show()
      $(".business_record_list_02").hide();
      $(".business_record_list_03").hide();
      $('#status').val(1);
      $('#panduan').val(1);
    })

    $(".business_record_nav02").on("click",function(){
      $(".business_record_list_01").hide()
      $(".business_record_list_02").show();
      $(".business_record_list_03").hide();
      $('#status').val(2);
      $('#panduan').val(1);
    })

      $(".business_record_nav03").on("click",function(){
      $(".business_record_list_01").hide()
      $(".business_record_list_02").hide();
      $(".business_record_list_03").show();
      $('#status').val(3);
      $('#panduan').val(1);
    })
  })
  </script>
