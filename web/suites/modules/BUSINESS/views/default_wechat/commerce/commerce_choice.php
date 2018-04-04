
<style type="text/css">
 .commerce_choice_icon {display: none;}
</style>

<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<!-- 选择商会 -->
<?php if( $tribe_list ){?>
<div class="commerce_index"> 
	
       <!-- 选择商会 -->
       <div class="recommended_tribe prominent_commerce_box">
         <ul class="recommended_tribe_top" id="commerce_choice_input">
         <?php foreach ( $tribe_list as $v ){?>
            <li onclick="sort_list(this)">
            <label>
                <div class="commerce_choice_icon">
                	<input type="radio" name="choose_tribe" class="icon-roundcheckfill icon-round" value="<?php echo $v['id']?>">
                </div>
                
                <a href="<?php echo site_url($modules.'?tribe_id='.$v['id'])?>">
                    <i><img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></i> 
                    <div class="recommended_tribe_rigth">
                        <div class="tribal_index_zhiding"><h2><?php echo $v['name']?></h2></div>
                        <div class="tribe_tuijian_box">
                        	<p><?php echo $v['content']?></p>
                        </div>
                    </div>
                </a></label>
            </li>
          <?php }?>
           
        </ul>
       </div>

      <!-- 底部 -->
<!--       <div class="commerce_choice_footer"> -->
<!--         <ul> -->
<!--              <li> -->
<!--                <div class="commerce_choice_select_all"> -->
<!--                  <input type="checkbox" class="select_all_input icon-roundcheckfill icon-round"> -->
<!--                  <span>全选</span> -->
<!--                </div> -->
<!--              </li> -->
<!--              <li> -->
<!--                <a href="javascript:void(0);" id="sub">选择</a> -->
<!--              </li> -->
<!--          </ul>  -->
<!--       </div> -->


</div>
<?php }else{?>
	<span><center style="margin-top:20px;">暂无可选商会</center></span>
<?php }?>
<script type="text/javascript">

//点击选择联系人 
function sort_list(obj)
{
      
    $(obj).find('input').toggleClass('icon-round');
    $(".select_all_input").addClass('icon-round');

    if( $(obj).find('input').is(':checked') )
    { 
    	 $(obj).find('input').prop("checked",false);
    }else{ 
    	 $(obj).find('input').prop("checked",true);
    }

   
}
  // 点击全选联系人
$(".commerce_choice_select_all").click(function(){    
        
    $('.select_all_input').toggleClass('icon-round');
    
    if($('.select_all_input').hasClass('icon-round')==true)
    {
        
    	$(".commerce_choice_icon input").addClass('icon-round'); 
    	$('input[name="choose_tribe"]').prop("checked",false);
    	
    }else{ 
        
    	$('input[name="choose_tribe"]').prop("checked",true);
    	$(".commerce_choice_icon input").removeClass('icon-round'); 
    } 

});

  
   
$('#sub').click(function(){
    var choose_tribe_id = [];
	$('input[type="checkbox"]:checked').each(function(e){ 
		choose_tribe_id.push($(this).val());
	}); 
	
	alert(encodeURIComponent(choose_tribe_id));
// 	 var b = new Base64();  
//      var str = b.encode();  
//      alert(str);  
})
   
</script>