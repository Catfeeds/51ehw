<style type="text/css">
  .container {background: #f6f6f6;}
  .my_activities_top li {border-bottom: 1px solid #d4d4d4;}
  .activities_nei_li_top i img {border-radius: 5px;}
  .activities_nei_li_xia h2 span {font-size: 12px;color: #999999;padding-left: 10px;margin-right: 0;}
  .activities_nei_li_xia p span {display: block;overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis;color:#333333;}
</style>

<!-- 搜索框 -->
<p class="tribe_add_apply_search">
  <a href="javascript:void(0);">
    <i class="icon-sousuo"></i>
    <input type="text" name="search_index" value="" placeholder="搜索您认识的人" required="">
  </a>
</p>


<div>
  <ul class="my_activities_top">
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="javascript:;"><i><img src="images/tmp_logo.jpg" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <h2>马云<span>阿里巴巴</span></h2>
                    <p><span>我有很多资源可以共享给你们</span></p>
                    </a>
                </div>
                <div class="tribe_add_apply_status"><span style="background:#dddddd;">待审核</span></div>
            </div>
           
        </div>
    </li>
    <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="javascript:;"><i><img src="images/tmp_logo.jpg" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="javascript:;">
                    <h2>马云<span></span></h2>
                    <p><span>想结识优秀的企业家</span></p>
                    </a>
                </div>
                <div class="tribe_add_apply_status"><span>已添加</span></div>
            </div>
           
        </div>
    </li>
</ul>
</div>








<script type="text/javascript">
  $(".tribe_add_apply_search").on("click",function(){
    $(".tribe_add_apply_search a input").focus();
  })
</script>