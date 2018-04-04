
<!--全局开始-->
<div id="warp"> 
  <!--头部开始-->
  <div class="header">
    <div class="tou">
      <div class="header_tou"><!--登录开始-->
        <h4><a href="#">51易货网合伙人管理平台</a></h4>
        <div class="header_tou_r">
        <?php if($this->session->userdata("agent_in")): ?>
          <div class="header_tou_r1" id="header_tou_r1">
             <!--<ul>
              <li><a href="#" id="head_li">查询管理</a>
                <dl>
                  <dd><a href="#">分成汇总查询</a></dd>
                  <dd><a href="#">分成明细查询</a></dd>
                  <dd><a href="#">分成明细查询</a></dd>
                  <dd><a href="#">分成明细查询</a></dd>
                  <dd><a href="#">分成明细查询</a></dd>
                </dl>
              </li>
            </ul>-->
            <ul class="animenu_nav">
		<li>
		  <a >查询管理</a>
		  <ul class="animenu_nav_child">
			<li><a href="<?php echo site_url("Agent/home/agent_rebate") ?>">分成汇总查询</a></li>
			<li><a href="<?php echo site_url("Agent/home/rebate_detail") ?>">分成明细查询</a></li>
            
		  </ul>
		</li>     
	  </ul>
          </div>
        <?php endif;?>
          <div class="header_tou_r2">
            <div class="header_n">
            <?php if(!$this->session->userdata("agent_in")): ?>
             <p>你好，<a href="<?php echo site_url("Agent/home/login") ?>">请登录</a> </p>
            <?php else:?>
             <p><?php echo $this->session->userdata("nick_name") ?></p>
             <p><a href="<?php echo site_url("Agent/home/loginout"); ?>">退出</a></p>
            <?php endif; ?>
             </div>
            <small class="icon-touxiang"></small>
          </div>
        </div>
     </div>
     </div>
    <!--登录结束--> 
  </div>
  <!--头部结束--> 
