
<?php $this->load->view('_header') ?>
<base href="<?php echo THEMEURL; ?>" />
 <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script language="JavaScript"> var base_url = '<?php echo THEMEURL;?>'; </script>
<script type="text/javascript" src="js/ShoppingCart.js"></script>
<script type="text/javascript" src="js/effects-20090707.js"></script>



<div class="ui-bd w980">
            <div class="ui-shop-cart">
                <div class="ui-crumb">你所在的位置：
                    <span>我的购物车</span>
                </div>
                <div class="ui-cart-bd m-top10">
                    <dl class="ui-cart-goods">
                        <dt class="fn-clear">
                            <span class="col col1">商品</span>
                            <span class="col col2">单价</span>
                            <span class="col col3">数量</span>
                            <span class="col col4">小计</span>
                        </dt>
						<?php foreach($this->cart->contents() as $items): ?>
                        <dd class="item fn-clear">
                            <div class="ui-goods-pic">
                                <a href="#" target="_blank"><img alt="" src="images/img/img_3.gif"/></a>
                            </div>
                            <div class="goods-info">
                                <div class="goods-count fn-clear">
                                    <span class="col col1">
                                            <a href="#" target="_blank">
                                                诗杯客乐品酒家系列香槟杯4510029
                                            </a>
                                    </span>
                                    <span class="col col2">99元</span>
                                    <span class="col col3">
                                          <div class="change-goods-num clearfix changeGoodsNum">
                                              <a href="#none" onclick="changeBar('-','<?php echo $items['id']; ?>',this)" class="goodsNumMinus">
                                                  <span class="icon-common icon-common-negative"></span>
                                              </a>

											  <input name="rowid" value="<?php echo $items['rowid']; ?>" type="hidden">
                                              <input name="qty" name="txtChange<?php echo $items['id']; ?>" maxlength="4" style="width: 30px;" onkeydown="if(event.which == 13) this.blur(); " value="<?php echo $items['qty']; ?>"  onblur="changeProductCount('<?php echo $items['id']; ?>',this);" tyep="text" class="ui-goods-num">
											  <input name="hidChange[<?php echo $items['id']; ?>]" value="<?php echo $items['qty']; ?>" type="hidden">

                                              <a href="#none" onclick="changeBar('+','<?php echo $items['id']; ?>',this)" class="goodsNumPlus">
                                                  <span class="icon-common icon-common-add"></span>
                                              </a>
                                          </div>
                                    </span>
                                    <span class="col col4"><em><?php echo $items['price']; ?>元</em></span>
                                </div>
                                <ul>
                                    <li class="fn-right">
                                        <a href="#" onclick="removeProduct('<?php echo $items['id']; ?>',this)" class="close" title="删除"></a>
                                    </li>
                                    <li>订单编号：2134900439</li>
                                </ul>
                            </div>
                        </dd>
						<?php endforeach; ?>
                       
                    </dl>
                    <div class="ui-cart-count fn-clear">
                        <div class="ui-cart-total fn-right">
                            <p class="ui-cart-price">总计：<span><strong><?php echo $this->cart->total(); ?></strong>元</span></p>
                        </div>
                    </div>
                    <div class="ui-cart-btn fn-clear">
                        <a href="#" class="ui-shop-to but buy-dakelight">继续购物</a>
                        <a href="#" class="ui-shop-checkout but buy-dakelight">去结账</a>
                    </div>
                </div>

            </div>
        </div>

<?php $this->load->view('_footer') ?>