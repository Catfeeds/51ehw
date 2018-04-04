<?php
header ( "Content-type: text/html; charset=utf-8" );
$CI = get_instance ();
$CI->load->model ( 'region_mdl', 'region' );
$provinces = $CI->region->provinces ();
$citys = $CI->region->children_of ( $province_selected );
?>
<script language="JavaScript">
<!--

<?php if(isset($province_selected)):?>
var province_selected = <?php echo (int)$province_selected?>;
<?php else:?>
var province_selected = 0;

<?php endif;?>
<?php if(isset($city_selected)):?>
var city_selected = <?php echo (int)$city_selected?>;
<?php else:?>
var city_selected = 0;
<?php
endif;?>
<?php if(isset($district_selected)):?>
var district_selected = <?php echo (int)$district_selected?>;
<?php else:?>
var district_selected = 0;
<?php
endif;?>
$(document).ready(function() {

  var change_city = function(){
	$.ajax({
	  url: '<?php echo site_url('order_att/select_children/')?>'+'?id='+$('#province_id').val(),
	  type: 'GET',
	  dataType: 'html',
	  success: function(data){
		city_json = eval('('+data+')');
		var city = document.getElementById('city_id');
		city.options.length = 0;
		city.options[0] = new Option('城市', '-11');
		for(var i=0; i<city_json.length; i++){
            var len = city.length;
			city.options[len] = new Option(city_json[i].region_name, city_json[i].region_id); 
			if (city.options[len].value == city_selected){
				city.options[len].selected = true;
			}
		}
		change_district();//重置地区
	  }
	});
  }

  change_city();//初始化城市

  $('#province_id').change(function(){
     change_city();
  });


  var change_district = function(){
	$.ajax({
	  url: '<?php echo site_url('order_att/select_children/')?>'+'?id='+$('#city_id').val(),
	  type: 'GET',
	  dataType: 'html',
	  success: function(data){
        district_json = eval('('+data+')');
		var district = document.getElementById('district_id');
		district.options.length = 0;
		district.options[0] = new Option('县/区', '-22');
		for(var i=0; i<district_json.length; i++){
            var len = district.length;
			district.options[len] = new Option(district_json[i].region_name, district_json[i].region_id); 
			if (district.options[len].value == district_selected){
				district.options[len].selected = true;
			}
		}
	  }
	});
  }

  $('#city_id').change(function(){
     change_district();
  });
  


});

//-->
</script>
<?php  if(!isset($other_type)){?>
<li class="form-group"><label>地址</label>
	<p class="select_container"> <select id="province_id" name="province_id" parsley-trigger="change" required>

			<option value="-1">省份</option>
	<?php foreach($provinces as $key => $province): ?>
	<option value="<?php echo $province['region_id']; ?>"
				<?php if($province['region_id']==$province_selected){echo 'selected';}?>><?php echo $province['region_name']; ?></option>
	<?php endforeach; ?>
                            </select>
	</p></li>

<li class="form-group"><label></label>
	<p class="select_container"><select name="city_id" id="city_id" parsley-trigger="change"  required>
		</select>
	</p></li>
<li class="form-group"><label></label>
	<p class="select_container"><select name="district_id" id="district_id" parsley-trigger="change" required>
		</select>
	</p></li>

<?php }else{?>
    <!-- 会员中心 -->
    <p class="member_centre_select margin_right5"> 
      <select id="province_id" name="province_id" parsley-trigger="change" required>
			<option value="-1">省份</option>
	        <?php foreach($provinces as $key => $province): ?>
	        <option value="<?php echo $province['region_id']; ?>"
				<?php if($province['region_id']==$province_selected){echo 'selected';}?>><?php echo $province['region_name']; ?></option>
	  <?php endforeach; ?>
      </select><em class="icon-xiala"></em>
	</p>
    <p class="member_centre_select"><select name="city_id" id="city_id" parsley-trigger="change"  required></select><em class="icon-xiala"></em></p>
<?php	}?>









