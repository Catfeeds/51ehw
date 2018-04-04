
    <div class="page clearfix">

	<div class="group_form_list">
		<ul>
			<li style="margin-bottom: 30px;">
			    <label>分享二维码</label>
			    
			    <?php //if($this->session->userdata('is_active') == 1):?>
			    <?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
			         <img id="invite" src="<?php echo base_url().'uploads/C/uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$this->session->userdata['user_id'].".png"?>" alt="" width="300">
			    <?php }else{?>
			    	 <img id="invite" src="<?php echo IMAGE_URL.'uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$this->session->userdata['user_id'].".png"?>" alt="" width="300">
				<?php }?>
				<p class="text-center">
					<em></em>让朋友扫一扫二维码，将主页分享给TA
				</p>
				    <a id="genbutton" class="gray-but" style="background-color:#fea33b" onclick="make_generateBarcode(<?php echo $this->session->userdata['user_id']; ?>);">生成二维码</a>
				    <script>
				         function make_generateBarcode(userid){
					         var userid = userid;
					         var year = <?php echo $year?>;
					         var month = <?php echo $month?>;
					         var day = <?php echo $day?>;
					         var base_url = "<?php echo IMAGE_URL; ?>";
				        	   $.ajax({
				        		    url:"<?php echo site_url('customer/generateBarcode') ?>/"+userid,
				        		    type:"get",
				        		    <?php if(base_url() == 'http://www.test51ehw.com/'){ ?>
				        		    success:function(data){
				        		        $('#invite').attr('src',base_url+'uploads/C/uploads/userinfo/'+year+'/'+month+'/'+day+'/'+userid+'.png');
				        		        $('#genbutton').remove();
					        		}
				        		    <?php }else{?>
				        		    success:function(data){
				        		        $('#invite').attr('src',base_url+'/uploads/userinfo/'+year+'/'+month+'/'+day+'/'+userid+'.png');
				        		        $('#genbutton').remove();
					        		}
				        		    <?php }?>
				        		   
					           });
					     }
			         
				    </script>
				<?php if(!file_exists(UPLOAD_PATH.'uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$this->session->userdata['user_id'].".png")&&$this->session->userdata['user_id']!=null) :?>
				<?php endif; ?>    
            </li>
		</ul>

	</div>
	<!--group_form_list end-->

</div>
<!--page end-->


