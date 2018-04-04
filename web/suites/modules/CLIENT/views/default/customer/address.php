
    

    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 4;
            $this->load->view('customer/leftmenu',$data);
         ?>

		<div class="huankuan_cmRight">
        	<div class="huankuan_rTop">收货地址</div>
			<div class="gerenzhongxin_04_con01">
            	<div class="gerenzhongxin_04_btn01"><a href="<?php echo site_url('member/address/add');?>">新建收货地址</a></div>
                <span>您已创建<?php echo $total_rows;?>&nbsp个收货地址，最多可创建20个</span>
            </div>
            <div class="gerenzhongxin_04_con02">
            	<h4>默认地址</h4>
                	<?php if(count($address) > 0):?>
                    	<?php foreach ($address as $k=>$v):?>
                        <div class="gerenzhongxin_04_con02_1 clearfix">
                        	<p>收货人：<?php echo $v['consignee'];?></p>
                            <p>所在地区：<?php echo $v['address_for_name'];?></p>
                            <p>地址： <?php echo $v['address'];?></p>
                            <p>手机：<?php echo $v['mobile'];?></p>
                            <p>固定电话：<?php echo $v['phone'];?></p>
                            <p>电子邮箱：<?php echo $v['email'];?></p>
                            <?php if( $v['is_default'] == '0'):?>
                                <div class="gernzhongxin_04_con02_btn"><a href="javascript:void(0)" onclick="set_default(<?php echo $v['id']?>)">设为默认</a></div>
                            <?php endif;?>
                            <div class="gernzhongxin_04_con02_btn"><a href="<?php echo site_url('member/address/edit/'.$v['id'])?>">编辑</a></div>
                            <div class="gernzhongxin_04_con02_btn gerenzhongxin_04_con02_btn02"><a href="<?php echo site_url('member/address/del/'.$v['id']);?>">删除</a></div>
                        </div>
                        <?php endforeach;?> 
                   <?php endif;?>
            </div>
            <div class="pingjia_jilu" style="margin-left:30px">
                    	<p>显示 <?php if(count($address) > 0) echo ($cu_page -1)*$per_page + 1; else echo'0';?> 到  <?php if($cu_page*$per_page > $total_rows) echo $total_rows; else echo $cu_page*$per_page; ?> 条数据，共 <?php echo $total_rows?> 条数据</p>
                    </div>
                    <div class="pingjia_showpage">
                    	<?php echo $page;?>
                    	<!--  
                    	<a href="#" class="lPage">上一页</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a class="cpage">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <span>…</span>
                        <a href="#" class="lPage">下一页</a>
                        -->
                    </div>
        </div>



    </div>
    

<script type="text/javascript">
function set_default(id){ 
	var url = "<?php echo site_url('member/address/set_default')?>"
	$.ajax({ 
	    url:url,
	    type:'post',
	    data:{id:id},
	    dataType:'json',
	    success:function(data){
		    if(data){ 
		          alert('设置成功');
		    	  window.location.reload();
		    }
		    }
		})
}
</script>

