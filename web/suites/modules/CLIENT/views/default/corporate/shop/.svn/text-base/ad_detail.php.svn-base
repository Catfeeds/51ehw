
    <!--分类头部 开始 -->
     <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li ><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
             <li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li ><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li class="tCurrent"><a href="<?php echo site_url('corporate/myshop/get_shop');?>">我的店铺</a></li>
    	</ul>
    </div>
    <!--分类头部 结束 -->
    <div class="Box manage_new_Box clearfix">
        <?php $this->load->view('corporate/shop/Left_nav');?>
        <div class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
            <div class="cmRight_tittle">轮播图设置</div>
            <div class="dianpu_03_top">
                  <!-- <div class="dianpu_03_btn">
                      <ul>
                          <li><a href="javascript:void(0)">添加</a></li>
                          <li style="margin-right:0"><a href="#"> 批量删除</a></li>
                      </ul>
                  </div>
                  <div class="dianpu_03_p01"><p>最多可以添加8个版块的内容, 已添加 1 个</p></div>
                  <div class="dianpu_03_p01"><p>轮播图内容</p></div>  -->  
            </div>
            <div class="dianopu_03_con">
            <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con manage_c_cmRight_con menu_manage_cmRight_con bankuai_manage_cmRight_con dianpu_02_padding">
					
                    <div class="select1">
                        <ul>
                            <li><a href="javascript:;<?php //echo site_url('corporate/myshop/add_ad') ?>" onclick="add();" >添加</a></li>
                            <li style="margin-right:0"><a href="javascript:void(0)" onclick="submit();"> 批量删除</a></li>
                        </ul>
                    </div>
                    <div class="dianpu_02_con">
                    <form action="<?php echo site_url('corporate/myshop/batch_del') ?>" method="post" name="form" id="form">
				 	<table width="910" mix-height="300" border="1" cellpadding="0" cellspacing="0" class="table1 manage_b_table1" id="table">
                    	<tr class="tr1 manage_b_tr1" >
                            <th width="34px"><input  type="checkbox" id="SelectAll"  onclick="if(this.checked==true) { checkAll(); } else { clearAll(); }"></th>
                            <th width="150px">轮播图片</th>
                            <th width="370px">链接地址</th>
                            <th width="124px">排序</th>
                            <th width="182px">操作</th>
                    	</tr>
                    	<?php 
				 	      if(isset($ad) && count($ad)>0):
				 	      foreach ($ad as $k => $ad):
				 	    ?>
                    	<tr>
                            <th width="34px"><input  id="subcheck" type="checkbox" name="checkbox[]" value="<?php echo isset($ad['ad_id'])&&$ad['ad_id']>0?$ad['ad_id']:''; ?>" onclick = "javascript:setSelectAll()"></th>
                            <th width="150px"><img src="<?php echo isset($ad['img_url'])?IMAGE_URL.$ad['img_url']:''; ?>" class="lunbo_img" alt="" style="width:100px;height:70px;"/></th>
                            <th width="370px"><?php echo $ad['url'] ?></th>
                            <th width="124px"><input type="text" value="<?php echo $ad['sort_order'] ?>" class="th1 manage_b_th1" readonly></th>
                            <th width="182px">
                            	<a href="<?php echo site_url('corporate/myshop/edit_ad/'.$ad['ad_id']) ?>" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="javascript:void(0)" style="color:#fca543; text-decoration:underline" onclick = "javascript:deleted(this)">删除<input type="hidden" value="<?php echo isset($ad['img_url'])?$ad['img_url']:''; ?>"></a>
                            </th>
                    	</tr>
                    	<?php endforeach; ?>
                    	<?php else:?>
                    	<tr>
                            <th width="34px"></th>
                            <th width="198px"><img src="" class="lunbo_img" alt=""/></th>
                            <th width="370px">暂无广告</th>
                            <th width="124px"></th>
                            <th width="182px">

                            </th>
                    	</tr>
                    	<?php endif; ?>
                    	</form>
                    	<!-- <tr>
                            <th width="34px"><input type="checkbox" name="checkbox"></th>
                            <th width="198px"><img src="images/b11.jpg" class="lunbo_img" alt=""/></th>
                            <th width="370px">http://www.51ehw.com/index.html</th>
                            <th width="124px"><input type="text" value="2" class="th1 manage_b_th1"></th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>
                    	<tr>
                            <th width="34px"><input type="checkbox" name="checkbox"></th>
                            <th width="198px"><img src="images/b11.jpg" class="lunbo_img" alt=""/></th>
                            <th width="370px">http://www.51ehw.com/index.html</th>
                            <th width="124px"><input type="text" value="3" class="th1 manage_b_th1"></th>
                            <th width="182px">
                                <a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>
                                <a href="#" style="color:#fca543; text-decoration:underline">删除</a>
                            </th>
                    	</tr>-->
                    </table>
                    <!-- <div class="baocun_btn menu_manage_baocun_btn bankuai_manage_baocun_btn dianpu_02_margin"><a href="javascript:void(0)">保存</a></div>-->
             </div>
             
                    
                    
       </div>
       </div>
                    
          </div>          
                    
       </div>

<!--弹窗-->
<div class="danchuang">
    <div class="dc_con">
    	<div class="dc_top">
        	<select class="sle">
               <option style="width:200px">1</option>
               <option style="width:200px">2</option>
               <option style="width:200px">3</option>
               <option style="width:200px">4</option>
               <option style="width:200px">5</option>
              </select>
              <h1 style="float:right">标题</h1>
              
              <p style="margin-top:50px">示图</p>
        </div>
        <div class="dc_img"></div>
        <div class="dc_btn">
        	<div class="dc_btn_01"><a href="#">保存</a></div>
            <div class="dc_btn_02"><a href="#">关闭</a></div>
        </div>
    </div>
</div>

 <script language=javascript>
 
 function selectAll(){  
	    if ($("#SelectAll").attr("checked")) {  
	        $("input[name = 'checkbox']").attr("checked", true);  
	    } else {  
	        $("input[name = 'checkbox']").attr("checked", false);  
	    }  
	}  
	//子复选框的事件  
	function setSelectAll(){  
	    //当没有选中某个子复选框时，SelectAll取消选中  
	    if (!$("#subcheck").checked) {  
	        $("#SelectAll").attr("checked", false);  
	    }  
	    var chsub = $("input[type='checkbox'][name='checkbox']").length; //获取subcheck的个数  
	    var checkedsub = $("input[type='checkbox'][name='checkbox']:checked").length; //获取选中的subcheck的个数  
	    if (checkedsub == chsub) {  
	        $("#SelectAll").attr("checked", true);  
	    }  
	} 

  function add(){
	  var tr = '';
	  var tr = '<tr>'+
          '<th width="34px"><input type="checkbox" name="checkbox"></th>'+
          '<th width="198px"><img src="" class="lunbo_img" alt=""/></th>'+
          '<th width="370px"><input type="text" name="url" value=""></th>'+
          '<th width="124px"><input type="text" name="sort_order" value="" class="th1 manage_b_th1"></th>'+
          '<th width="182px">'+
          	//'<a href="#" style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>'+
            //'<a href="#" style="color:#fca543; text-decoration:underline">删除</a>'+
              '<a href="javascript:void(0)" onclick="save_add(this);" style="color:#fca543; text-decoration:underline">保存</a>'+
          '</th>'+
          '</tr>';
      //alert(tr);
	  $('#table').append(tr);
  }

  function save_add(o){

	   var url = $(o).parent().prev().prev().children().val();
	   var sort_order = $(o).parent().prev().children().val();
	   var edit_url = "<?php echo site_url('corporate/myshop/edit_ad/'); ?>";
	   $.ajax({
		    url:"<?php echo site_url('corporate/myshop/save_ad') ?>",
	        type:"post",
	        data:{url:url,sort_order},
	        beforeSend:function(){
	            $(o).html("保存中..."); 
		    },
		    success:function(data){
		        if(!isNaN(data)){
		            $(o).html("保存成功");
		            setTimeout(function(){$(o).html("保存");},500);
		            var edit = '<a href='+edit_url+'/'+data+' style="color:#aeaeae; margin-right:40px; text-decoration:underline">编辑</a>';
		            var del ='<a href="javascript:void(0)" style="color:#fca543; text-decoration:underline" onclick = "javascript:deleted(this)">删除<input type="hidden" value=""></a>';
		            
		            $(o).parent().prev().prev().prev().prev().children().val(data);
		            $(o).parent().prev().prev().children().remove();
		            $(o).parent().prev().prev().html(url);
		            $(o).parent().prev().children().attr("readonly");
		            $(o).parent().append(edit+del);
		            $(o).remove();
			    }else{
			    	$(o).html("保存失败");
		            setTimeout(function(){$(o).html("保存");},500);
				}
			}
	   });
	   
  }

  function deleted(o){
	  var img_url = $(o).children().val();
	  var id = $(o).parent().prev().prev().prev().prev().children().val();

	  $.ajax({
		  url:'<?php echo site_url('corporate/myshop/deleted') ?>',  
		  type:'post',
		  data:{img_url:img_url,id:id,},
		  success:function(data){
			    if(data == 1){
			    	$(o).parent().parent().remove();
			    	var rows = document.getElementById("table").rows.length; 
				  	if(rows <= 1){
				  	      var tr = '';
					  	  var tr = '<tr>'+
    					            '<th width="34px"></th>'+
    					            '<th width="198px"></th>'+
    					            '<th width="370px">暂无广告</th>'+
    					            '<th width="124px"></th>'+
    					            '<th width="182px">'+
    					           '</tr>';
				           $('#table').append(tr);
					}  
				}
	      },
      });
  }

  function submit(){
	    $('#form').submit();
  }

//全选
  function checkAll() {
  	var el = document.getElementsByTagName('input');
  	var len = el.length;
  	for(var i=0; i<len; i++) {
  	if((el[i].type=="checkbox")) {
  	el[i].checked = true;
  	}
  	}
  } 

  function clearAll() {
  	var el = document.getElementsByTagName('input');
  	var len = el.length;
  	for(var i=0; i<len; i++) {
  	if((el[i].type=="checkbox")) {
  	el[i].checked = false;
  	}
  	}
  } 
  
  </script>
  


