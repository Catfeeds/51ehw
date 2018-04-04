
<div class="ui-bd w980">
    <div class="ui-crumb">你所在的位置：
        <a href="#">个人中心</a> ＞

        <span>客户资料详情</span>
    </div>
    <div class="fn-clear m-top10">
        <!--中心导航 S-->
        <?php $this->load->view('customer/leftmenu');?>
        <!--中心导航 e-->
        <!--中心内容 S-->
        <div class="ui-main-right fn-right">
            <div class="ui-member-title">
                <h3>客户资料详情</h3>
            </div>
            <div class="ui-member-box">
                <div class="ui-data-box">
                    <div class="ui-data-list">
                        <div class="ui-data-title">客户资料</div>
                        <ul class="ui-data-info">
							<?php if($user){?>
                            <li>
                                用户帐号：<span><?php echo $user["name"]?></span>
                            </li>
                            <li>
                                联系方式：<span><?php echo $user["email"]?></span>
                            </li>
                            <li>
                                登录次数：<span><?php echo $user["login_count"]?>次</span>
                            </li>
                            <li>
                                消费次数：<span><?php echo $user["salecount"]?>次</span>
                            </li>
							<?php }?>
                        </ul>
                    </div>
                    <div class="ui-data-list">
                        <div class="ui-data-title">客户资料</div>
						
                        <ul class="ui-data-info">
                            <li>
                                酒类消费：<span class="ui-data-price">¥<?php $wine =0;if($saledata){ foreach($saledata as $s){if($s["cat_id"] == 418 || $s["cat_id"] == 422 || $s["cat_id"] == 423 || $s["cat_id"] == 424){ $wine=$s["qty"]*$s["price"];}}} echo $wine;?></span>
                            </li>
                            <li>
                                补品消费：<span class="ui-data-price">¥<?php $tonic =0; if($saledata){ foreach($saledata as $s){ if($s["cat_id"] == 419){ $tonic=$s["qty"]*$s["price"];}}} echo $tonic;?></span>
                            </li>
                            <li>
                                消费总和：<span class="ui-data-price">¥<?php echo $wine+$tonic?></span>
                            </li>
                            <li>
                                一个月消费：<span class="ui-data-price">¥<?php $month =0;if($saledata_month){ foreach($saledata_month as $s){  $month=$month+$s["qty"]*$s["price"];}} echo $month;?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="ui-data-list ui-data-list-none">
                        <div class="ui-data-title">客户资料</div>
                        <ul class="ui-data-info">
                            <li>
                                下级客户：<span><?php echo $user["childcount"]?></span>
                            </li>
                            <li>
                                下级消费总额：<span class="ui-data-price">¥<?php $child =0;if($childdata){ foreach($childdata as $s){  $child=$child+$s["qty"]*$s["price"];}} echo $child;?></span>
                            </li>
                            <li>
                                一个月消费总额：<span class="ui-data-price">¥<?php $childmonth =0;if($childdata){ foreach($childdata_month as $s){  $childmonth=$childmonth+$s["qty"]*$s["price"];}} echo $childmonth;?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ui-data-query">
					<form name="detailsearch" method="post" action="<?php echo site_url('customer/customerdatadetail/'.$level."/".$id)?>">
                    <div class="ui-data-box-title m-top10 ">该客户订单详情</div>
                    <div class="ui-form-width m-top10 fn-clear">
                        <span>下单时间：</span>
                        <select name="">
                            <option>三个月以内</option>
                        </select>
                        <span class="ui-margin-left">订单状态</span>
                        <select name="">
                            <option value="9">已完成</option>
							<option value="6">已发货</option>
							<option value="12">退货</option>
					
                        </select>
                        <span class="ui-margin-left">商品名称</span>
                        <input type="text" class="text"/>
                        <span class="ui-margin-left"></span>
                        <input type="submit" name="btnSelect" value="查 询" class="ui-button-inquiry">
                    </div>
					</form>
                    <!--订单宝贝 当有2个宝贝或以上，默认只显示一个，需点详情查看更多 S-->
                    <div class="ui-order-t-box m-top10 fn-clear">
						<?php if($order){
							$order_sn = "";
							foreach($order as $key=>$o)
							{
								if($order_sn == "" || $order_sn != $o["order_sn"])
								{
									 $order_sn = $o["order_sn"];
						?>
						<?php if($key != 0){?>
								</tbody>
                            </table>
                        </div>
						<?php }?>
                        <div class="order-delivery-item">
                            <div class="ui-order-top fn-clear">
                                订单号：<?php echo $o["order_sn"]?>
                            </div>
                            <table class="order-delivery-table">
                                <tbody>
								<?php }?>
                                    <tr>
                                        <td class="cell-order-goods">
                                            <div class="order-goods fn-clear">
                                                <div class="order-goods-thumb">
                                                    <img src="<?php echo IMAGE_URL.'uploads/'.$o['goods_thumb'];?>" alt="#"></div>
                                                <div class="order-goods-info">
													<span class="order-goods-name">
                                                        <a target="_blank" href="#" title="#"><?php echo $o["name"]?></a></span>
                                                    <span class="order-goods-price"><?php echo $o["price"]?>元</span>
                                                </div>
                                                <div class="order-goods-amount">x <?php echo $o["quantity"]?></div>
                                            </div>

                                        </td>
                                        <td rowspan="2"><?php echo $o["total_product_price"]?>元</td>
                                        <td rowspan="2">已收货</td>
                                        <td class="cell-order-actions" rowspan="2"><?php echo $o["place_at"]?></td>
                                    </tr>
                                    <?php }}else{?>
									<p>暂无订单记录！</p>
									<?php }?>
								
                        <?php if(count($order)>0){?>
						</tbody>
                            </table>
                        </div>
						<?php }?>

                    </div>
                    <!--订单宝贝 当有2个宝贝或以上，默认只显示一个，需点详情查看更多 E-->
                    <div class="ui-page m-top10">
                        <?php echo $pagination;?>
                    </div>
                </div>
            </div>

        </div>
        <!--中心内容 E-->

    </div>

</div>
