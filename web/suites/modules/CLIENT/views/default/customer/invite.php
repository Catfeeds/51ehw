    

    <div class="Box member_Box clearfix">
        <?php //个人中心左侧菜单  
            $data['left_menu'] = 9;
            $this->load->view('customer/leftmenu',$data);
         ?>
        
        <div class="huankuan_cmRight clearfix">
        	<div class="huankuan_rTop">邀请客户</div>
            
            <div class="kehu_yaoqing_con01 clearfix">
           	  <h4>一、手机直接扫二维码即可。</h4>
              
              <?php if(!file_exists('./'.UPLOAD_PATH.'uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$this->session->userdata['user_id'].".png")&&$this->session->userdata['user_id']!=null) :?>
				    <div class="yaoqing_img" style="height:215px"><img id="invite" src="images/m_logo.jpg" width="172" height="172" alt=""/>
				    <a id="genbutton" class="yaoqing_btn01"  onclick="make_generateBarcode(<?php echo $this->session->userdata['user_id']; ?>);">生成二维码</a>
			  <?php else: ?>
	 		  		<div class="yaoqing_img"><img id="invite" src="<?php echo IMAGE_URL.'uploads/userinfo/'.$year.'/'.$month.'/'.$day.'/'.$this->session->userdata['user_id'].".png"?>" width="172" height="172" alt=""/>
			  <?php endif; ?>
				    <script>
				         function make_generateBarcode(userid){
					         var userid = userid;
					         var base_url = "<?php echo IMAGE_URL; ?>";
					         var year = "<?php echo $year;?>";
					         var month = "<?php echo $month;?>";
					         var day = "<?php echo $day;?>";
				        	   $.ajax({
				        		    url:"<?php echo site_url('customer/generateBarcode') ?>/"+userid,
				        		    type:"get",
				        		    success:function(data){
				        		        $('#invite').attr('src',base_url+'/uploads/userinfo/'+year+'/'+month+'/'+day+'/'+userid+'.png');
				        		        $('#genbutton').remove();
				        		        $('.yaoqing_img').attr("style","");
					        		}
					           });
					     }
			         
				    </script> 
			  </div> 
              <h4>二、复制以下链接通过MSN、QQ或论坛等方式发送给您的朋友</h4>
              <div class="yaoqing_input">
              	<input type="text" class="yaoqing_input02" id="link" value="<?php echo site_url('customer/registration/'.$this->session->userdata('user_id'));?>">
              	<div class="yaoqing_btn01"><a id="copy">复制推广连接</a></div>
              </div>
              
          </div>
          <p class="yaoqing_p">如果点击"复制链接"按钮没有反应，请全选链接"ctrl+c"复制此链接</p>
          <!-- JiaThis Button BEGIN -->
          <div style="margin:20px 0 0 30px;">

          <div class="jiathis_style">
          <span class="jiathis_txt">分享到：</span>
          <a class="jiathis_button_qzone">QQ空间</a>
          <a class="jiathis_button_tsina">新浪微博</a>
          <a class="jiathis_button_tqq">腾讯微博</a>
          <!-- <a class="jiathis_button_weixin">微信</a>-->
          <a class="jiathis_button_douban">豆瓣</a>
          <a class="jiathis_button_renren">人人网</a>
          <a class="jiathis_button_tieba">百度贴吧</a>
          <a class="jiathis_button_cqq">QQ好友</a>
          
          <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
          
          </div>
          
          </div>
          <script type="text/javascript" >
          var jiathis_config={
              summary:"",
              shortUrl:false,
              hideMore:true,
              url:"<?php echo site_url('customer/registration/'.$this->session->userdata('user_id'));?>"
          }
          </script>
          <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
          <!-- JiaThis Button END -->
            </div>
           

    </div>
    
    <script>
 $("#copy").click(function(){  
//             var text = $("#link").val();
	        var text = document.getElementById("link"); 
            copyToClipboard(text);  
            alert("成功到剪贴板");  
        }); 


function copyToClipboard(txt) {

	    txt.select();
	    document.execCommand("Copy");
	    /*if (window.clipboardData) {
	        window.clipboardData.clearData();
	        window.clipboardData.setData("Text", txt);
	        alert("已经成功复制到剪帖板上！");
	    } else if (navigator.userAgent.indexOf("Opera") != -1) {
	        window.location = txt;
	    } else if (window.netscape) {
		    alert(111);
	        try {
	            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
	        } catch (e) {
	            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
	        }
	        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
	        alert(clip);
	        if (!clip) return;
	        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
	        if (!trans) return;
	        trans.addDataFlavor('text/unicode');
	        var str = new Object();
	        var len = new Object();
	        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
	        var copytext = txt;
	        str.data = copytext;
	        trans.setTransferData("text/unicode", str, copytext.length * 2);
	        var clipid = Components.interfaces.nsIClipboard;
	        if (!clip) return false;
	        clip.setData(trans, null, clipid.kGlobalClipboard);
	        alert("已经成功复制到剪帖板上！");
	    }*/
	}
</script>



