<section id="content" role="main">
    <div class="container">
        <div class="row" id="consignee_from">
            <div class="col-sm-6 md-margin">
               <label class="form-label">收货人姓名<span class="required">*</span></label>
               <input class="form-control input-sm" id="consignee_addressName" name="consignee" maxlength="20" onblur="check_addressName()" type="text" placeholder="" value="<?php echo $address['consignee'] ?>">

                <label class="form-label">所在地区<span class="required">*</span></label>
                <p><span id="consignee_arae">
                <?php 
                $data['province_selected'] = $address['province_id'];
                $data['city_selected'] = $address['city_id'];
                $data['district_selected'] = $address['district_id'];
                ?>
                <?php $this->load->view('widget/district_select',$data); ?>
                </span></p>

                <label class="form-label">邮政编码<span class="required">*</span></label>
                <input class="form-control input-sm" type="text" placeholder="" id="consignee_postcode" onblur="check_postcode()" name="postcode" value="<?php echo $address['postcode'] ?>">

                 <label class="form-label">详细地址<span class="required">*</span></label>
                 <input class="form-control input-sm" type="text" placeholder="" id="consignee_address" name="address" onblur="check_address()" value="<?php echo $address['address'] ?>">

                 <label class="form-label">手机号码<span class="required">*</span></label>
                 <input class="form-control input-sm" type="text" placeholder="" id="consignee_message" onblur="check_message()" name="mobile" value="<?php echo $address['mobile'] ?>">

                 <label class="form-label">固定电话<span class="required"></span></label>
                 <input class="form-control input-sm" type="text" placeholder="" id="consignee_phone"  onblur="check_phone()" name="phone" value="<?php echo $address['phone'] ?>">

                 <label class="form-label">电子邮箱<span class="required"></span></label>
                 <input class="form-control input-sm" type="text" placeholder="" id="consignee_email" onblur="check_email()" name="email" value="<?php echo $address['email'] ?>">

                <div class="xs-margin"></div>
                <input type="submit" class="btn btn-custom btn-lg min-width" value="保存收货地址" onclick="save_consignee(this);">
                
                    
            </div>
        </div>
    </div>
</section>
