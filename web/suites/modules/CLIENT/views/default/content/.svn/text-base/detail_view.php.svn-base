<section id="content" role="main">
            
            <div class="breadcrumb-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb">
                                <li><a href="<?php echo site_url("home");?>" title="Home">首页</a></li>
                                <li class="active"><?php echo $contents['section_name'];?></li>
                            </ul>
                        </div><!-- End .col-md-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .breadcrumb-container -->

            <div class="container">
                <div class="row">
                    <!-- <div class="col-md-7 single-portfolio-media-container padding-right-xlg">
                        <div class="carousel-container valign-nav bigger-nav">
                            <div class="owl-carousel single-portfolio-slider">
                                <img src="images/portfolio/item7.jpg" alt="Gallery 1">
                                <img src="images/portfolio/item1.jpg" alt="Gallery 2">
                                <img src="images/portfolio/item6.jpg" alt="Gallery 3">
                                <img src="images/portfolio/item5.jpg" alt="Gallery 4">
                            </div><!-- End .single-portfolio-slider -- >

                            <div class="slider-thumb-nav-container">
                                <div class="owl-carousel slider-thumb-nav">
                                    <img src="images/portfolio/item7.jpg" alt="Gallery 1">
                                    <img src="images/portfolio/item1.jpg" alt="Gallery 2">
                                    <img src="images/portfolio/item6.jpg" alt="Gallery 3">
                                    <img src="images/portfolio/item5.jpg" alt="Gallery 4">
                                </div><!-- End .single-portfolio-slider -- >
                            </div><!-- End .slider-thumb-nav-container -- >
                        </div><!-- End .carousel-container -- >
                    </div><!-- End .col-md-7 -- >

                    <div class="md-margin visible-sm visible-xs clearfix"></div><!-- space -->

                    <div class="col-md-12">
                        <h2 style="margin-bottom: 0;display: inline-block;word-wrap:break-word; word-break:normal;"><?php echo $contents['title'];?></h2>
                        <div style="margin-left: 10px;display: inline-block"><span class="like-icon"></span>126</div>
                        <hr style="margin-bottom: 0; margin-top: 10px;">
                        <p style="word-wrap:break-word; word-break:normal;"><?php echo $contents['content'];?></p>
                        <hr style="margin-bottom: 10px; margin-top: 0;">
                        <ul class="xs-margin">
                            <li><span>发布日期:</span><?php echo $contents['release_time'];?></li>
                            <li><span>所属栏目:</span><a href="<?php echo site_url("content/get_list/".$contents['section_id']);?>" title="<?php echo $contents['section_name'];?>"><?php echo $contents['section_name'];?></a></li>
                            
                        </ul>

                        <ul class="social-links color2 clearfix">
                            <li><a href="#" class="social-icon icon-facebook" title="Facebook"></a></li>
                            <li><a href="#" class="social-icon icon-twitter" title="Twitter"></a></li>
                            <li><a href="#" class="social-icon icon-linkedin" title="Linkedin"></a></li>
                            <li><a href="#" class="social-icon icon-email" title="Email"></a></li>
                            <li><a href="#" class="social-icon icon-googleplus" title="Google +"></a></li>
                        </ul>


                    </div><!-- End .col-md-5 -->
                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
            
            <div class="lg-margin2x"></div><!-- space -->

        </section><!-- End #content -->
        <script>
        var iswechat = (window.navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == ‘micromessenger‘);
        var cloc = location.href.replace(/^#/, "").replace(/[^\/]*\.[^\/*]+$/, "");
        var mainTitle = "",
            mainDesc = "",
            mainURL = cloc,
            mainImgUrl = cloc + "images/wechat_icon.jpg";

        document.addEventListener(‘WeixinJSBridgeReady‘, function onBridgeReady() {
            iswechat = true;
            WeixinJSBridge.call(‘hideToolbar‘);
            onBridgeReady1();
        });

        function onBridgeReady1() {
            //转发朋友圈
            WeixinJSBridge.on("menu:share:timeline", function (e) {
                var data = {
                    img_url: mainImgUrl,
                    img_width: "120",
                    img_height: "120",
                    link: <?php echo $this->uri->uri_string()."/".$this->session->userdata('user_id');?>,
                    //desc这个属性要加上，虽然不会显示，但是不加暂时会导致无法转发至朋友圈，
                    desc: mainDesc,
                    title: mainTitle
                };
                WeixinJSBridge.invoke("shareTimeline", data, function (res) {
                    WeixinJSBridge.log(res.err_msg)
                });
            });
            //同步到微博
            WeixinJSBridge.on("menu:share:weibo", function () {
                WeixinJSBridge.invoke("shareWeibo", {
                    "content": mainDesc,
                    "url": mainURL
                }, function (res) {
                    WeixinJSBridge.log(res.err_msg);
                });
            });
            //分享给朋友
            WeixinJSBridge.on(‘menu:share:appmessage‘, function (argv) {
                WeixinJSBridge.invoke("sendAppMessage", {
                    img_url: mainImgUrl,
                    img_width: "120",
                    img_height: "120",
                    link: mainURL,
                    desc: mainDesc,
                    title: mainTitle
                }, function (res) {
                    WeixinJSBridge.log(res.err_msg)
                });
            });
        };
        </script>