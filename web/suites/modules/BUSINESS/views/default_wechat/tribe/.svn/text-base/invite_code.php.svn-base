<style>
.container{ background:#FFD000}
</style>
  <div class="container">
     <div class="invitation_ho">
       <div class="invitation_nei">
         <h2><i class="icon-erweimayaoqing"></i>二维码邀请</h2> 
          <div id ='code'  class="invitation_nei_li" style="text-align: center;">
<!--           <img src="images/yaoqing.jpg"/> -->
          </div>
         <?php if($authority == 1){?>
              <p>面对面扫二维码进部落，该二维码<span>60</span>秒刷新一次</p>
         <?php }else{?>
             <p>面对面扫二维码进部落</p>
         <?php }?>
          
       </div>
     </div>
  </div>  
  
<script type="text/javascript" src="js/qrcode.js"></script>
<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>


<script>
function make_code(){
	$.post("<?php echo site_url("tribe/Create_Invite_Code");?>",{tribe_id:<?php echo $tribe_id;?>},function(data){
		if(data.url_short){
			var str = data.url_short;
			$("#code").html('');
			$("#code").qrcode({
			    render : "canvas",   //设置渲染方式,table和canvas【推荐canvas】
			    text : str,          //扫描二维码后显示的内容(如果是网址将跳向该链接网址)
			    width : "200",       //二维码的宽度
			    height : "200",      //二维码的高度
			    background : "#fff", //二维码的后景色
			    foreground : "#000", //二维码的前景色
			    src:'',
			});
			}else{
				alert("网络错误");
				window.location.reload();
				}
		},"json");
}
make_code();
<?php if($authority == 1){?>
setInterval(function(){
	make_code();
},60000);
<?php }?>
</script>