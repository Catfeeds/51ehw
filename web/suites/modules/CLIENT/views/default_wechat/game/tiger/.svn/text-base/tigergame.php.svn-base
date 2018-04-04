
<!DOCTYPE html>
<html>
<head>
<base href="<?php echo THEMEURL; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=640">
<!--<meta content="width=640, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />-->
<title>活动2</title>
<link href="game/tiger/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="game/tiger/js/jquery-1.8.3.min.js"></script>
</head>


<body>
    <div style="height:1px;overflow:hidden;">
		<img src="images/share.png" />
	</div>
	<div class="wrapper">
	    <div class="ui-share-box" id="share" style="display:none" onclick="javascript:$('#share').hide()">
	        <div class="ui-share-img"><img src="images/game_share.png" alt=""></div>
	    </div>
		<div class="upper_container">
			<!-- For Activity / Banners-->
			<div class="activity game">
				<div id="star">
					<div class="game_wrapper">
							<ul>
								<li><img src="game/tiger/images/game-v8-button.png" width="109" height="181" id="part1"></li>
								<li><img src="game/tiger/images/game-v8-button.png" width="109" height="181" id="part2"></li>
								<li><img src="game/tiger/images/game-v8-button.png" width="109" height="181" id="part3"></li>	
							</ul>
					</div>
				</div>
			</div>
			<!-- For Activity / Banners-->
		</div>

		<div class="lower_container silver">
			<div id="errormsg" style="display:none" class="ui-game-info"></div>
	
					<div class="items">
                        
                       
                        
							<div class="extra_large_btn orange_xl">
							
								<div class="texts" id="play_bt"><a onclick="playgame()">开始游戏</a></div>
								 
							</div>
							
					</div>
			
			
		</div>
		

	</div>
</body>
</html>
<script>
var gamenum  = '<?php echo $gamenum?>';
var page = 4;
function playgame()
{
	$('#part1').attr("src","game/tiger/images/game-v8-button.png");
	$('#part2').attr("src","game/tiger/images/game-v8-button.png");
	$('#part3').attr("src","game/tiger/images/game-v8-button.png");
	page = 1;
	var nums = gamenum.split(",");
	
	var a = setInterval(function(){
		if(page <4)
		{
			if(page>1)
			{
				$('#part'+(page-1)).attr("src","game/tiger/images/p"+nums[page-2]+".png");
			}
			$('#part'+page).attr("src","game/tiger/images/pic"+nums[page-1]+".gif");
			page++;
		}else
		{
			clearInterval(a);
		}
	},900);
	
}

	


	
</script>
