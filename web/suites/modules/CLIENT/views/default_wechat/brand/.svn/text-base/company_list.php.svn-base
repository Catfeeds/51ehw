<script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
<!--header end-->
        <div class="page clearfix">
            <div class="search-container">
                <div class="search-box active">
                    <form>     
                        <input type="text" class="search-input" id="search_app" onkeyup="searchApp(this)" placeholder="搜索品牌" value="">
                        <span class="icon-roundclosefill" style="display: none;"></span>
                        <div class="consel fn-right"><!--<a onclick="">取消</a>--><a href="#" style="display: none;">搜索</a></div>
                        <span class="icon-search"></span>
                    </form>
                </div>
            </div><!--search-container end-->
            
            <div class="brand-container">
                <div class="brand-top">
                    <ul>
						<?php
						foreach($recommend as $a):?>
                        <li><a href="<?php echo site_url("home/redirectOther/".$a["id"]);?>"><img src="<?php if(isset($a['site_logo'])){ echo IMAGE_URL.'images/'.$a['site_logo'];}else { echo "images/default_img_logo.jpg";}?>" alt="<?php echo $a["app_name"]?>"></a>
						</li>
						<?php endforeach;?>
                        
                    </ul>
                </div>
                <div class="brand" id="brand">
                 <?php foreach($apps as $a):?>
                  <div class="brand-box clearfix">
                      <a href="<?php echo site_url("home/redirectOther/".$a["id"]);?>">
                          <img  src="<?php if(isset($a['site_logo'])){ echo IMAGE_URL.'images/'.$a['site_logo'];}else { echo "images/default_img_logo.jpg";}?>" alt="" style="display: inline-block;">
                         <span name="app_name"><?php echo $a["app_name"]?></span>
                          <!--<span><em class="icon-hot fn-30"></em></span>-->
                      </a>
                 </div>
				 <?php endforeach;?>
                </div>
            </div><!--brand-container end-->
           <script>
				function searchApp(obj)
				{
					var val = $.trim($(obj).val());
					
					if( val != "" )
					{
						$('#brand').find("span").each(function(){
							//alert($(this).html().indexOf(val));
							if($(this).html().indexOf(val)>-1){
								//alert($(this).html());
								$(this).parent().parent("div").show();
							}else
							{
								$(this).parent().parent("div").hide();
							}
						});
					}else
					{
						$('#brand').find("span").each(function(){
							$(this).parent().parent("div").show();
						});
					}

				}
		   </script>
            
 