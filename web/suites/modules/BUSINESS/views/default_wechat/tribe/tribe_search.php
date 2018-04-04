<style type="text/css">
	.recommend {margin-bottom: 0;padding-bottom: 0;}
	.page {padding-bottom: 0;}
  .sousuo_text {position: absolute;right: 2%;color: #fff;font-size: 15px;top: 18px;}
  .result_em {width: 70%;}
</style>

<!-- 部落搜索 -->
<div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;">
    <a href="<?php echo site_url("tribe");?>" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   <form method="get" action="<?php echo site_url("Tribe/tribe_search");?>" id="form1" >
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:75%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;"><a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
          <input type="text" class="search_input" name="keywords" value="<?php echo $keywords;?>" placeholder="搜索部落" required="" style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;">
          <!-- <a href="javascript:void(0);" onclick="$('.search_input').val(' ').focus();" style="position: fixed;top: 20px;"><img src="images/search_close.png" height="15" width="15" alt=""></a> --></p> 
          <span class="sousuo_text" onclick='$("#form1").submit();'>搜索</span>      
        </div>
   </form>
</div>
<div style="height:50px;"></div>
<?php if(count($mymemories)>0 && !$list){?>
<div class="page clearfix">
    <div class="recommend tribe_search_recommend">
        <h5 style="font-size:15px;color: #333;">搜索历史 
        <span><a href="javascript:void(0);" target="_self" class="icon-shanchu tribe_search_shanchu" onclick="del_memories(this);"></a></span>
        </h5> 
        <ul id="memories">
            <?php foreach($mymemories as $v) {; ?> 
            <li><a href="javascript:void(0);" onclick="$('input[name=keywords]').val('<?php echo $v["keyword"];?>');$('#form1').submit();"><?php echo $v["keyword"];?></a></li>
            <?php }; ?>
        </ul>
    </div> 
</div><!--搜索 end-->
<?php };?>

<!-- 搜索结果 -->
 <div class="tribe_recommend_list">
    <ul>
       
        <?php foreach ($list as $v) { ?>
        <a href="<?php echo site_url("tribe/tribe_detail/".$v['id']);?>">
          <li class="clearfix">
            <i class="tribe_recommend_img"><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/default_img_s.jpg'"></i>
            <em class="result_em">
                <p class="pt10">
                  <span class="tribe_recommend_name"><?php echo $v["name"];?></span><span class="tribe_recommend_num">会员数: <?php echo $v["total"];?>人</span>
                </p>
                <div class="tribe_recommend_text"><?php echo $v["content"];?></div>
            </em>
          </li>
          </a>
        <?php } ?>
    </ul>
</div>

<script>
//清空历史记录；
function del_memories(obj){
	$.post("<?php echo site_url("Tribe/del_memories");?>",function(data){
	    switch(data["status"]){
    	    case 1://成功
        	    $("#memories").empty();
        	    $(obj).remove();
    		    break;
    	    case 2://没登录
        	    window.location.href="<?php echo site_url("Customer/login");?>";
        	    break;
    	    default:
        	    window.location.reload();
        	    break;
	    }
	},"json");
}
</script>