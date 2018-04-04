 <?php 
 //4=>模板1 5=>模板2  6=>模板3

 ?>
    <div class="index_new_floor_one">
    	<ul>
    	    <li style="border-bottom: 1px solid #dadada;">
    	    	<div class="index_floor_list_01">
    	    		<ul>
    	    	<?php 
        switch($list[0]['temp_id']){
            case 4:
            foreach ($list as $key => $val){
            if($val['position'] == 1){ ?>
                <li>
                    <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
           <?php  }
           if($val['position'] == 2){ ?>
                  	<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
               </li>
          <?php  }
           if($val['position'] == 3){ ?>
    	       <li><a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a></li>
    	  <?php  }
           if($val['position'] == 4){ ?>
    		   <li class="index_floor_list_right">
    	    	   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	  <?php }
    	    if($val['position'] == 5){ ?>
    		       <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	    	</li>
	    	 </ul>
	       </div>
	    </li>
	    <li style="border-bottom: 1px solid #dadada;">
	    	<div class="index_floor_list_02">
	    		<ul>
    	  <?php }
    	    if($val['position'] == 6){ ?>
    		  	<li>
                   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	  <?php }
    	  if($val['position'] == 7){ ?>
	      		   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
                </li>
    	  <?php } 
    	  if($val['position'] == 8){ ?>
	      		 <li>
    	    		<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>   
    	  <?php } 
    	  if($val['position'] == 9){ ?>
	      		   <div class="index_floor_list02_center">
    	    		    <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	  <?php } 
    	  if($val['position'] == 10){ ?>
	      				<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	    	   </div>
    	    	</li>   
    	  <?php }
    	  if($val['position'] == 11){ ?>
	      		 <li><a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a></li>
    	  <?php } 				
    	   if($val['position'] == 12){ ?>
                  	</ul>
    	    	</div>	
    	    </li>
    	</ul>
    </div>	
     <!-- 楼层广告 -->
     <div class="index_floor_guang">
    	<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    </div>
  <?php }    
    } 
  break;
  case 5:
      foreach ($list as $key => $val){
          if($val['position'] == 1){ ?>
              <li>
                  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
          <?php  }
             if($val['position'] == 2){ ?>
                  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
             </li>
          <?php  }
             if($val['position'] == 3){ ?>
      	     <li><a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a></li>
      	  <?php  }
             if($val['position'] == 4){ ?>
      		  <li class="index_floor_list_right">
        		 <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php }
      	    if($val['position'] == 5){ ?>
      		     <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
        	  </li> 
        	</ul>
        </div>
      </li>
      <li style="border-bottom: 1px solid #dadada;">
        <div class="index_floor_list_02">
        	<ul>	  
      	  <?php }
      	    if($val['position'] == 6){ ?>
      		   <li>
                   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php }
      	  if($val['position'] == 7){ ?>
          		  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
               </li>
      	  <?php } 
      	  if($val['position'] == 8){ ?>
          	  <li>
        		  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php } 
      	  if($val['position'] == 9){ ?>
          		  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
        	 </li>
      	  <?php } 
      	  if($val['position'] == 10){ ?>
          	 <li><a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a></li>
      	  <?php }
      	   if($val['position'] == 11){ ?>
                	</ul>
    	    	</div>	
    	    </li>
    	</ul>
    </div>
     <!-- 楼层广告 -->
    <div class="index_floor_guang">
    	<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    </div>
    <?php }   	   
    } 
    break;
  case 6:
      foreach ($list as $key => $val){
          if($val['position'] == 1){ ?>
               <li>
                  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
          <?php  }
          if($val['position'] == 2){ ?>
                   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
              </li> 
          <?php  }
          if($val['position'] == 3){ ?>
          	  <li><a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a></li>
      	  <?php  }
          if($val['position'] == 4){ ?>
          	  <li class="index_floor_list_right">
    	    	  <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php }
      	  if($val['position'] == 5){ ?>
          		   <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	     </li> 
    	   </ul>
    	</div>
     </li>
     <li style="border-bottom: 1px solid #dadada;">
    	<div class="index_floor_list_03">
    	    <ul>
      	  <?php }
      	  if($val['position'] == 6){ ?>
          	 <li>
                 <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php }
      	  if($val['position'] == 7){ ?>
      	      	 <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
            </li>	   
      	  <?php } 
      	  if($val['position'] == 8){ ?>
      	    <li>
    	        <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>    
      	  <?php } 
      	  if($val['position'] == 9){ ?>
                <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	    </li>  	    
      	  <?php } 
      	  if($val['position'] == 10){ ?>
      	    <li>
    	       <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
      	  <?php }
      	  if($val['position'] == 11){ ?>
                <a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	   </li>      	  
      	  <?php } 				
      	   if($val['position'] == 12){ ?>
                 	</ul>
        	    	</div>	
        	    </li>
        	</ul>
        </div> 
        <!-- 楼层广告 -->
    	<div class="index_floor_guang">
    		<a href="<?php echo $val['link_path'];?>"><img src="<?php echo $val['img_path'];?>" alt="<?php echo $val['desc'];?>"></a>
    	</div>
 	<?php } 
    } 
 break;
    } ?>



  <script type="text/javascript">


  window.onload = function() { 
	  var height_louceng = $(".index_floor_list_01").height();
	    $(".index_floor_list_01 li").css("height",height_louceng);
	    $(".index_floor_list_02 li").css("height",height_louceng);
	    $(".index_floor_list_03 li").css("height",height_louceng);
	  }; 
  
 
  </script>


