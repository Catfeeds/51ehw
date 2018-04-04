<script>

 <?php
//     if(file_exists(FCPATH.UPLOAD_PATH."uploads/data/category_".$this->session->userdata('app_info')["id"].".php"))
//     {
//         include( FCPATH.UPLOAD_PATH."uploads/data/category_".$this->session->userdata('app_info')["id"].".php");
//     }else
//     {
//         $json_string = file_get_contents(base_url("data/".SUITE."/category.json"));
//         echo "var viewModel = ".$json_string;
    
//     }
    $json_string = file_get_contents(FCPATH.UPLOAD_PATH."uploads/data/category_".$this->session->userdata('app_info')["id"].".json");
 ?>
     var viewModel = <?php  echo $json_string;?>;
</script>
 <script>
$(document).ready(function(){
    //类目菜单
    ko.applyBindings(viewModel);
});
</script>

<!--导航 开始-->
    <div class="eh_navbar clearfix">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:void(0)">全部商品分类<b class="icon-select"></b></a></h2>
                    </div>
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}">
                                <a  class="icon-hover"href="javascript:void(0)" data-bind="text:$data.title"><h3>
                                    <span></span><span class="macth_xvh3_a"></span>
                                </h3></a>
                                <b class="icon-select"></b>
                                <div data-bind="attr:{'id':$data.id}" class="macth_popover">
                                     <div class="macth_popover-content">
                                        <ul class="macth_content_ul" data-bind="foreach:$data.content">
                                            <li class="macth_nav_li">
                                                <a class="macth_xvnav_li_alist" href="javascript:void(0)" data-bind="text:$data.title"></a>
                                                <ul class="macth_xvnav_li_ul" data-bind="foreach:$data.content">
                                                    <li>
                                                        <a href="text:$data.url" data-bind="attr:{'href':'<?php echo site_url('goods/search');?>/'+$data.id},'text':$data.title"></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--右侧广吿图-->
                                    <!--<div class="macth_cat-right">
                                        <a href="" target="_blank">
                                            <img src="images/rightbanner.jpg" style="margin-top: 6px">
                                        </a>
                                    </div>-->
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li class="macth_liactive"><a href="<?php echo site_url('home')?>">首页</a></li>
                    <!--  
                    <li><a href="<?php echo site_url('goods/zhuanti/3');?>">广告</a></li>
                    <li><a href="<?php echo site_url('goods/zhuanti/2');?>">餐饮</a></li>
                    <li><a href="<?php echo site_url('goods/zhuanti/1');?>">书画</a></li>
                    <li><a href="<?php echo site_url('goods/zhuanti/4');?>">房屋</a></li>
                    <li><a href="<?php echo site_url('goods/zhuanti/hotel');?>">酒店</a></li>
                    -->

                </ul>
                <!--中间导航 end-->
                <div class="macth_xv_login">
                <!-- 公告暂时屏蔽 -->

                    <div class="macth_xvlogin_list scroll_top">
                        <div class="scroll_title">新闻热点</div>
                        <ul class="infoList">
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

                            <!-- <li>
                                <a href="">51易货网内测阶段，欢迎关注！</a>
                            </li>
                            <li>
                                <a href="">51易货网即将上线，敬请期待！</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--导航 结束-->