
    <!--头部导航条 开始-->
    <div class="gongying_navbar">
    	<div class="gongying_navcon">
        	<div class="gongying_menu">
            	
            </div>
        </div>
    </div>
    <!--头部导航条 结束-->
    
    <!--内容 开始-->
    <div class="gongying_con">
    	<p class="gongying_weizhi"><a href="<?php echo site_url("home")?>">首页</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="<?php echo site_url("member/info")?>">个人中心</a>&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp; &nbsp;<a href="javascript:;">常见问题</a></p>
        <!--清除浮动-->
        <div class="clearfix">
        	<div class="gongying_conLeft">
			  <h1><?php echo isset($detail['title'])?$detail['title']:'' ?></h1>

                <div class="gonggao_con">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detail['content'] ?></p>

                </div>
          </div>
            <div class="gongying_conRight">
            	
            </div>
        </div>
	</div>
    <!--内容 结束-->

