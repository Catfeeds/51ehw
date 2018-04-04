<div class="eh_footer_box">
    <div class="eh_footer">
       <!-- <div class="eh_footer_banner">
            <img src="images/eh_footer_banner.jpg" alt="">
        </div>-->
        <?php
		if(file_exists(FCPATH.UPLOAD_PATH."uploads/siteinfo/_footer".$this->session->userdata('app_info')["id"].".html"))
		{
			include(FCPATH.UPLOAD_PATH."uploads/siteinfo/_footer".$this->session->userdata('app_info')['id'].".html");

		}else{
			include(FCPATH.UPLOAD_PATH."uploads/siteinfo/_footer.html");
		}
		?>
        <div class="eh_footer_copyright">
            <p><a href="http://www.miitbeian.gov.cn/">陕ICP备16001036号-1</a></p>
           <p><script type="text/javascript" src="http://wljg.snaic.gov.cn/scripts/businessLicense.js?id=fc643eb0a26e11e68a886c92bf251155 "></script>
</p> 
        </div>
        <div class="eh_footer_authentication">
           
        </div>
    </div>
</div>
