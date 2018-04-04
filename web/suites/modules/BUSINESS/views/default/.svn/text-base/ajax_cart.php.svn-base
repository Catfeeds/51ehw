<ul class="fn-clear">
                                        <?php 
										$count = 0;
										if(count($this->cart->contents()) > 0){
										foreach($this->cart->contents() as $items): ?>
                                            <li>
                                                <a href="<?php echo site_url('goods/detail/'.$items['id']);?>" class="prod-info">
                                                    <img src="<?php echo IMAGE_URL.'uploads/'.$items['options']['goods_img']; ?>" width="45" height="78" alt="">
                                                    <span class="name"><?php echo $items['name'];?></span>
                                                    <span class="price"><strong>¥ <?php echo $items['price']; ?></strong> × <em><?php echo $items['qty']; ?></em></span>
                                                </a>
                                                <p>
                                                <span>
                                                <input class="qty" name="rowid" value="<?php echo $items['rowid']; ?>" type="hidden">
                                                </span>
                                                </p>
                                                <a onclick="removecart('<?php echo $items['id']; ?>',this);" title="删除"><i class="clip">删除</i></a>
                                            </li>
                                            <?php 
											$count++;
											endforeach; 
										}
										else{?>
										<li>购物车暂无产品，请选择购物！</li>
										<?php }?>
                                        </ul>
                                        <div class="shopcart-sum">
                                            <a href="<?php echo site_url('cart');?>" class="btn-viewcart">查看购物车</a>
                                            <p>共<em><?php echo $this->cart->total_items();?></em>件商品<br>总计： ¥<strong><?php echo round($this->cart->total(),2); ?></strong></p>
                                        </div>