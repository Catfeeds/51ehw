<?php
header("Content-type: text/html; charset=utf-8");
$CI = get_instance();
$CI->load->model('region_mdl', 'region');
$provinces   = $CI->region->provinces();
$province_selected = isset($province_selected)?$province_selected:"";
$citys = $CI->region->children_of(isset($province_selected)?$province_selected:"");
?>
<script  language="JavaScript">
<!--

<?php if(isset($province_selected)):?>
var province_selected = <?php echo (int)$province_selected?>;
<?php else:?>
var province_selected = 0;
<?php endif?>

<?php if(isset($city_selected)):?>
var city_selected = <?php echo (int)$city_selected?>;
<?php else:?>
var city_selected = 0;
<?php endif?>

<?php if(isset($district_selected)):?>
var district_selected = <?php echo (int)$district_selected?>;
<?php else:?>
var district_selected = 0;
<?php endif?>

$(document).ready(function() {

  var change_city = function(){
	$.ajax({
	  url: '<?php echo site_url('order_att/select_children/')?>',
	  type: 'GET',
	  dataType: 'html',
	  data:{id:$('#province_id').val()},
	  success: function(data){
		city_json = eval('('+data+')');
		var city = document.getElementById('city_id');
		city.options.length = 0;
		city.options[0] = new Option('城市', '');
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
	  url: '<?php echo site_url('order_att/select_children/parent_id')?>'+'/'+$('#city_id').val(),
	  type: 'GET',
	  dataType: 'html',
	  data:{id:$('#city_id').val()},
	  success: function(data){
        district_json = eval('('+data+')');
		var district = document.getElementById('district_id');
		district.options.length = 0;
		district.options[0] = new Option('县/区', '');
		for(var i=0; i<district_json.length; i++){
            var len = district.length;
			district.options[len] = new Option(district_json[i].region_name, district_json[i].region_id);
			if (district.options[len].value == district_selected){
				district.options[len].selected = true;
			}
		}
		var province = $("#province_id").find("option:selected").text();
		var city = $("#city_id").find("option:selected").text();
		var district = $("#district_id").find("option:selected").text();
		var address = $("input[name=address]").val();
		//地图显示
		if(province=='省份' || city=='城市' || address==''){
		    $("#baidu_api").hide();
			}else{
				$("#baidu_api").show();
        		if(district=='县/区'){
        			$("#baidu_api").attr("href","http://api.map.baidu.com/geocoder?address="+province+city+address+"&output=html&src=yourCompanyName|yourAppName");
        			}else{
        				$("#baidu_api").attr("href","http://api.map.baidu.com/geocoder?address="+province+city+district+address+"&output=html&src=yourCompanyName|yourAppName");
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
<select name="province_id" id="province_id" class="regsiter_03_select03 dropdown_select02 select02Edit" >
    <option value="" >省份</option>
	<?php foreach($provinces as $key => $province): ?>
	<option value="<?php echo $province['region_id']; ?>" <?php if($province['region_id']==$province_selected){echo 'selected';}?> ><?php echo $province['region_name']; ?></option>
	<?php endforeach; ?>

</select>

<select name="city_id" id="city_id"  class="regsiter_03_select03 dropdown_select02 select02Edit" >

</select>

<select name="district_id" id="district_id" class="regsiter_04_select04 dropdown_select02 select02Edit" >
    <option value=""></option>
</select>