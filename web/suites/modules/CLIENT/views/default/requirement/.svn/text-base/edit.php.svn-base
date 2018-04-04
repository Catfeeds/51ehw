
    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	<div class="gongying_menu_left">
                	<ul>
                    	<!--<li><a href="">更多需求信息</a></li>-->
                        <li class="gongying_liCurrent"><a href="javascript:;">发布需求信息</a></li>
                    </ul>
                </div>
                <div class="gongying_menu_right">
                	<div class="right_list right_scroll_top">
                    	<div class="scroll_title">新闻热点</div>
                        <ul class="scroll_infoList">
                            <?php if(isset($notice) && count($notice)>0): ?>
                            <?php foreach ($notice as $n): ?>
                                <li>
                                <a href="<?php echo site_url('notice'); ?>"><?php echo $n['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <li>
                                <a href="javascritp:;">暂无公告！</a>
                                </li>
                            <?php endif; ?>
                        	<!-- <li><a href="">51易货网即将上线，敬请期待！</a></li>
                            <li><a href="">【公告】谨防假冒客服诈骗</a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--头部导航条 结束-->
    
    <!--内容 开始-->
    <div class="gongying_con">
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home");?>">首页</a>&nbsp;&nbsp;&nbsp; > &nbsp;&nbsp; &nbsp;<a href="javascript:;">发布需求信息</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
            	<div class="fabuxuqiu_title clearfix">
                	<div class="fabuxuqiu_con01_left">
                    	<span class="fabuxuqiu_span01">企业名称 :</span>
                    </div>
                 	<div class="fabuxuqiu_con01_right">
                    	<span class="fabuxuqiu_span02"><?php echo $corporation['corporation_name'] ?></span>
                    </div>
                </div>
                <div class="fabuxuqiu_con">
                <form name="form1" method="post" action="<?php echo site_url('requirement/pubrequire')?>"  id="form1">
                	<!--内容01 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <span class="fabuxuqiu_con01_span01">*</span>
                            <span class="fabuxuqiu_span01">分类 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <!--<div class="req_select01">
                            	<span class="req_select01_bg">请输入产品类别</span>
                                    <select class="fabuxuqiu_con01_select">
                                        <option>请输入产品类别</option>
                                        <option value="1">实体类</option>
                                        <option value="2">生活服务类</option>
                                        <option value="3">其他</option>
                                    </select>
                            </div>-->
                            
                            <!--分类下拉框-->
                        <span class="req_select01">
                        	<span class="req_select01_bg"></span>
                            <select class="fabuxuqiu_con01_select" name="cate_id" id="cate_id" onclick="cate();">
                                <option value="">请输入产品类别</option>
                                <?php if(count($cate)): ?>
                                <?php foreach ($cate as $c): ?>
                                <option value="<?php echo $c['id'] ?>"><?php echo $c['cate_name'] ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                        </span>
                         <div style="display:none;float:left;margin:0 auto;width:150px;line-height:32px;font-size:11px;text-align:center;color:red" id="cate"></div>  
                        </div>
                        
                        <!--右边内容 结束-->
                    </div>
                    <!--内容01 结束-->
                     
                    <!--内容02 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <span class="fabuxuqiu_con01_span01">*</span>
                            <span class="fabuxuqiu_span01">需求产品 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <input type="text" class="fabuxuqiu_con01_input" placeholder="请输入您需求的产品名称，不得超过20个中文字" name="p_name" id="p_name" onclick="javascript:pname()">
                        <div style="display:none;float:right;margin:0 auto;width:150px;line-height:32px;font-size:11px;text-align:center;color:red" id="p_na"></div>
                        </div>
                        
                        <!--右边内容 结束-->
                    </div>
                    <!--内容02 结束-->
                    
                    <!--内容03 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <!--<span class="fabuxuqiu_con01_span01">*</span>-->
                            <span class="fabuxuqiu_span01">需求数量 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <input type="text" class="fabuxuqiu_con01_input" placeholder="请输入您需要的数量" value="" name="p_count">
                        </div>
                        <!--右边内容 结束-->
                    </div>
                    <!--内容03 结束-->
                     
                    <!--内容04 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <!--<span class="fabuxuqiu_con01_span01">*</span>-->
                            <span class="fabuxuqiu_span01">目标单价 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <input type="text" class="fabuxuqiu_con01_input02" placeholder="请输入单价，不填代表面议" value="" name="vip_price">
                            <i class="req_m">货豆</i>
                        </div>
                        <!--右边内容 结束-->
                    </div>
                    <!--内容04 结束-->
                    
                    <!--内容05 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <!--<span class="fabuxuqiu_con01_span01">*</span>-->
                            <span class="fabuxuqiu_span01">需求描述 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <textarea class="fabuxuqiu_con01_textarea" rows="10" name="p_content" placeholder="请输入您的需求描述"></textarea>
                        </div>
                        <!--右边内容 结束-->
                    </div>
                    <!--内容05 结束-->
                    
                    <!--内容06 开始-->
                	<div class="fabuxuqiu_con01 clearfix">
                    	<!--左边内容 开始-->
                    	<div class="fabuxuqiu_con01_left">
                            <!--<span class="fabuxuqiu_con01_span01">*</span>-->
                            <span class="fabuxuqiu_span01">验证码 :</span>
                        </div>
                        <!--左边内容 结束-->
                        
                        <!--右边内容 开始-->
                        <div class="fabuxuqiu_con01_right">
                            <!--示例-->
                            <input type="text" class="fabuxuqiu_con01_input03" placeholder="请输入验证码" id="Verifier" onclick="javascript:vers()">
                            <div style="display: none;" id="verif"></div>
                            <div class="fabuxuqiu_yanzhengma"><img src="<?php echo site_url('requirement/yzm_img') ?>" width="90" height="30" alt="" id="captcha" onclick="change();"/></div>
                            <span class="fabuxuqiu_huanyizhang"><a href="javascript:;" onclick="change();">看不清 , 换一张 !</a></span>
                            <div style="display:none;float:right;margin:0 auto;width:150px;line-height:32px;font-size:11px;text-align:center;color:red" id="ver" ></div>
                        </div>
                        <!--右边内容 结束-->
                    </div>
                    <!--内容06 结束-->
                    
                    <!--提交审核按钮 开始-->
                    <div class="tijiaoshenhe_btn"><a href="javascript:;" id="submit" onclick="submit();">提交审核</a></div>
                    <!--提交审核按钮 结束-->
                    
                </div>
                </form>
            </div>
            <!--<div class="gongying_conRight">
            	
          </div>-->
    	</div>
	</div>
    <!--内容 结束-->


<script>


function submit(){
	
	if($('#cate_id').val()==''){
	    $('#cate_id').css('border','1px solid red');
	    $('#cate').html('请选择产品分类!');
	    $('#cate').show();
	}else if($('#p_name').val()==''){
		
		 $('#p_name').css('border','1px solid red');
		 $('#p_na').html('请输入产品需求!');
		 $('#p_na').show();
	}else if($('#Verifier').val()==''){
		$('#Verifier').css('border','1px solid red');
		$('#ver').html('请输入验证码!');
		$('#ver').show();
	}else if($('#Verifier').val()!=''){
	    var ver = $('#Verifier').val();
	    $.ajax({
	        url:"<?php echo site_url('requirement/checkyzm') ?>",
            type:"post",
            data:{ver:ver},
            success:function(data){
                if(data==1){
                	$('#form1').submit();
                }else{
                	$('#Verifier').css('border','1px solid red');
            		$('#ver').html('验证码错误!');
            		$('#ver').show();
                }
            }
		});
	}

	
}

function cate(){
	$('#cate_id').css('border','0');
    $('#cate').html('');
    $('#cate').hide();
}
function pname(){

	$('#p_name').css('border','1px solid #FEA33B');
    $('#p_na').html('');
    $('#p_na').hide();
}
function vers(){

	$('#Verifier').css('border','1px solid #FEA33B;');
    $('#ver').html('');
    $('#ver').hide();
}

function change(){
    document.getElementById('captcha').src="<?php echo site_url('requirement/yzm_img/?') ?>"+Math.random();
} 

</script>
