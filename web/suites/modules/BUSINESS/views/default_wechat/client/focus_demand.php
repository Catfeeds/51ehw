
<style>
.search-header{
  background-color: #fff;
    height: 50px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    line-height: 50px;}
</style>
<!--  <link rel="stylesheet" href="layui/css/layui.css">
<script type="text/javascript" src="layui/layui.js"></script> -->

  <div class="container">
       <div class="search-header">
         <a href="javascript:history.back()" target="_self" class="icon-right" style="color: #333333; -webkit-transform: rotate(180deg);  font-size: 19px; float: left; margin-left: 10px;  margin-top: 18px;"></a>
             <span style="font-size:18px;color:#333333;display:block; float:left;width: calc(100% - 73px); text-align:center;text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">定制我关注的需求</span>
             <span style="float:right;font-size:15px;color:#333333; margin-right:10px; "><a href="<?php echo site_url("Member/requirement/index")?>">跳过<a></span>
        </div>
  <div class="focus_demand_top">
    <span class="icon-sousuo"></span>
   <script type="text/javascript">

      // 搜索回调
    //   function search_demand(data){
    //     if(data.code == 1){
    //         $(".focus_demand_zhong_ul li").remove();
    //          var container_label = $(".container").data("label_container");
    //         // console.log(first_data);
    //         $.each(data.label, function(i,n){

    //          if($.inArray(n['id'], customer_label_id)  >= 0 || $.inArray(n['id'], container_label) >= 0){
    //              $(".focus_demand_zhong_ul").append('<li item="'+n['id']+'" onclick="label_dianji(this)" class="51ehw_classify_cate focus_dj" 51ehw_item_no="'+n['id']+'"><a href="javascript:void(0);"><span>'+n['name']+'</span></a> </li>');
    //          }else{
    //                $(".focus_demand_zhong_ul").append('<li item="'+n['id']+'" onclick="label_dianji(this)" class="51ehw_classify_cate " 51ehw_item_no="'+n['id']+'"><a href="javascript:void(0);"><span>'+n['name']+'</span></a> </li>');
    //          }
    //        }); 
    //     }else{
          
    //         $(".follow_bottom_ul li").remove();
    //     }
    //   }

    //    (function(){

    //    $.post(
       // "<?php //echo site_url('member/demand/label_query');?>",
    //    {label_name: ''},
    //   search_demand,
    //    'json'
    //   );

    // }()); 
   </script>

   
    <input type="text" oninput="search_label(this)" class="focus_demand_top_input" id="follow_input_keyword_ehw" name="keyword" value="" placeholder="搜索您想找的标签" required=""> 

  

    <script type="text/javascript">
        var customer_label_id = new Array();
        <?php foreach($customer_label_id as $val):?>
          customer_label_id.push('<?php echo $val;?>');
        <?php endforeach;?>
         // 搜索

         

         //  $("#follow_input_keyword_ehw").bind('input propertychange', function(){
         //   var label_name = $("#follow_input_keyword_ehw").val();
         //   $(".focus_demand_zhong_ul li").remove();
         //   $.post(
         //     "<?php //echo site_url('member/demand/label_query');?>",
         //     {label_name: label_name},
         //    search_demand,
         //     'json'
         //   );
         // });
        
        var label = new Array();
       function label_dianji(e)
       {
        $(e).toggleClass("focus_dj"); 
        var labelid =  $(e).attr("item");
        var index = $.inArray(labelid,label);
            if(index >=0){
              label.splice(index,1);
            }else{
              label.push(labelid);
            }
            // console.log(label);
        $(".container").data("label_container", label);
        // console.log($(".container").data("label_container"));
       } 
    </script>  
  </div>

  <div class="focus_demand_zhong">
   <ul class="focus_demand_zhong_ul">
       <!-- <li><span>服务市场</span></li>
       <li><span>DIY配件</span></li> -->
       <!-- $customer_label_id -->
       <?php //var_dump($customer_label_id);?>
          <?php if($label){
                  foreach ($label as $key => $val){?>
                       <li item ="<?php echo $val['id'];?>" class="51ehw_classify_cate <?php if(in_array($val['id'],$customer_label_id)) echo 'focus_dj' ?>" 51ehw_item_no="<?php echo $val['id']; ?>"><a href="javascript:void(0);"><span><?php echo $val['name'];?></span></a></li>
           <?php }  }?>  

   </ul>
   </div>

   <a href="javascript:void(0)" class="circle_publish_jia">保存修改</a>
  </div> 
<script type="text/javascript">
   //标签搜索
   function search_label(obj)
    {
        var val = $.trim($(obj).val());
        
        if( val != "" )
        {
            $('ul.focus_demand_zhong_ul').find("li").each(function(){
                if($(this).html().toLowerCase().indexOf(val.toLowerCase())>-1)
                {
                    $(this).show();
                }else
                {
                    $(this).hide();
                }
            });
        }else
        {
          $('ul.focus_demand_zhong_ul').find("li").show();
        }
    }
</script>

<script>
$(document).ready(function(){
    // 获取子分类
    var ehw_item_no = $("51ehw_classify_cate focus_dj").attr('51ehw_item_no');
    

  
    function choose(id,title){
      window.location.href = '<?php echo site_url("Member/requirement/spring_board?cate=")?>'+id+'&search_index='+title;
    }  
    



    function  renascence(id,type,name){
      var search_id = id; 
      var title = name;
      var _title = "'"+name+"'";
      var num = parseInt(type)+1;
      var box_id = 'gaine'+num;
      $.post("<?php echo site_url("Member/requirement/ajax_getlevel");?>",{id:id,type:type},function(data){
        if(data.level.length > 0){
          var result =  '';
          for(var i=0;i<data.level.length;i++){
            var id = data.level[i]['id'];
            var level = data.level[i]['level'];
            var name = "'"+data.level[i]['name']+"'";
            result += '<li class="51ehw_classify_cate" 51ehw_item_no="'+id+','+level+','+name+'"><a href="javascript:;"><span>'+data.level[i]['name']+'</span></a></li>';
            }
         
            $(".focus_demand_zhong_ul li").remove();
            $(".focus_demand_zhong_ul").append(result);
            $("#box").find('.needs_search_list').hide();
            $("#"+box_id).show();
            //滑动
          $('html, body').animate({scrollTop:0}, 'slow');
          }else{
  //          $(".black_feds").text("没有有更多的下级分类了").show();
  //            setTimeout("prompt();", 2000);
  //            return;
            choose(search_id,title);
            }
      
      },"json");
      }

        //定义一个存放标签改动的数组
        
        $(".focus_demand_zhong_ul  li").on('click',function(){
          var labelid =  $(this).attr("item");
          var index = $.inArray(labelid,label);
          if(index >=0){
            label.splice(index,1);
            }else{
              label.push(labelid);
              }
          // console.log(label);
            
        });

      $(".circle_publish_jia").click(function(){
        // var item_no = $(".focus_dj");
        // // console.log(item_no);
        // var item = new Array();
        // $.each(item_no, function(i){
        //   item.push($(this).attr("item"));
        // });
        // // console.log(item);
        if(label.length < 1){
          $(".black_feds").text("更新成功").show();
          setTimeout(function(){
            window.location.href="<?php echo site_url('Member/requirement');?>";
          },1000);
          return false;
        } 

        item = JSON.stringify(label);
        // console.log(item);
        // 请求数据
        $.post(
          "<?php echo site_url('member/demand/add_customer_label'); ?>",
          {label_id:item},
          function(res){
            // console.log(res);
        },'json');
        // return false;
        $("div[class='focus_demand_zhong']").removeData("first");
       
        // alert('保存成功');
        //一般直接写在一个js文件中
        $(".black_feds").text("更新成功").show();
        setTimeout("prompt();", 2000);
        setTimeout(function(){
          window.location.href="<?php echo site_url('Member/requirement');?>";
        },1000);
        
      });

      

      $(".focus_demand_zhong_ul li").click(function(){
        // console.log(123);
        $(this).toggleClass("focus_dj");
      });
});
 
</script>

