<div style="height: 50px;"></div>	
<div class="client_commodity_block_not">
        	<span class="icon-dingdanyiwancheng1 client_block_icon"></span>
        	<span class="client_block_not_text">
        	<?php switch ($status){
        	    case "1":
        	        echo "恭喜你，核销成功！";
        	        break;
        	    case "2":
        	        echo "抱歉，此券核销失败！";
        	        break;
        	    case "3":
        	        echo "抱歉，您没有权限对该券进行核销！";
        	        break;
        	}?>
        	</span>
</div>