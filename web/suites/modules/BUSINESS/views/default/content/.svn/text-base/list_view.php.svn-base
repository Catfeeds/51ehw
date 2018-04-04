<section id="content" role="main">
            <div class="breadcrumb-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb">
                                <li><a href="<?php echo site_url("home");?>" title="Home">首页</a></li>
                                <!-- <li><a href="blog.html" title="Blog">资讯列表</a></li> -->
                                <li class="active"><?php echo $section['section_name'];?></li>
                            </ul>
                        </div><!-- End .col-md-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .breadcrumb-container -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 articles-container">
                        <?php foreach ($contents as $content):?>
                        <article class="article" style="margin-bottom: 0;">
                            <!--<div id="post-id-20" class="article-media-container carousel slide" data-ride="carousel" data-interval="6000">
                                <!-- Wrapper for slides -- >
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <a href="single.html"><img src="images/blog/post1.jpg" class="img-responsive" alt="Slider 1"></a>
                                    </div><!-- End .item -- >

                                    <div class="item">
                                        <a href="single.html"><img src="images/blog/post2.jpg" class="img-responsive" alt="Slider 2"></a>
                                    </div><!-- End .item -- >

                                    <div class="item">
                                        <a href="single.html"><img src="images/blog/post3.jpg" class="img-responsive" alt="Slider 3"></a>
                                    </div><!-- End .item -- >
                                </div><!-- End .carousel-inner -- >

                                <!-- Controls -- >
                                <a class="left carousel-control" href="#post-id-20" role="button" data-slide="prev">Prev</a>
                                <a class="right carousel-control" href="#post-id-20" role="button" data-slide="next">Next</a>
                            </div><!-- End .article-media-container -->

                            <h2><a href="single.html"><?php echo $content['title'];?></a></h2>
                            <p><?php echo $content['content'];?></p>

                            <div class="article-meta-container clearfix">
                                <a href="<?php echo site_url('content/detail/'.$content['id']);?>" class="readmore" role="button">阅读全文</a>
                                <div class="article-meta-wrapper">
                                    <span class="article-meta">作者： <a title="<?php echo $content['author'];?>"><?php echo $content['author'];?></a></span>
                                    <span class="article-meta"><a href="<?php echo site_url("content/get_list/".$content['section_id']);?>" title="<?php echo $content['section_name'];?>"><?php echo $content['section_name'];?></a></span>
                                    

                                </div><!-- End .article-meta-wrapper -->
                            </div><!-- End .artcile-meta-container -->
                            <hr>
                        </article><!-- End .article -->
                        
						<?php endforeach;
						if (count($contents) == 0) {
							?>
							<article class="article">
                            <h2>本栏目尚未有新闻哟。</h2>
							</article>
							<?php
						}
						?>
                        

                        <div class="pagination-container clearfix">
                            <?php //echo $pagination;?>
                        </div><!-- End pagination-container -->
                         <div class="md-margin2x visible-sm visible-xs"></div><!-- space -->
                    </div><!-- End .col-md-12 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="lg-margin2x"></div><!-- space -->

        </section><!-- End #content -->