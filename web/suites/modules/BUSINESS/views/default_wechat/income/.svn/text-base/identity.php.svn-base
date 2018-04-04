<style>
.container {
	background: #f4f4f4;
	height: auto;
}
</style>
<!--身份升级开始-->
<?php if( $identity_list ){?>
<div class="identity_da" style="padding-top: 0">
	<ul class="identity_top">
		<?php foreach ( $identity_list as $v ){?>
		<li>
			<div class="identity_top_sh">
				<div class="identity_top_left"><?php echo $v['identity_name']?></div>
				
				<?php if ( $identity_info['level'] <= $v['level'] ) {?>
				
    				<div class="identity_top_right" <?php echo $v['identity_id'] == $identity_info['identity_id'] ? 'style="background:#fff;"' : ''?> >
    			
    					<?php if( $v['identity_id'] == $identity_info['identity_id'] ) {?>
    					
    						<a href="javascript:;" style="color: red">已开通</a>
    						
    					<?php }else{?>
    					
    						<a href="<?php echo site_url('Income/Apply/'.$v['identity_id'])?>">点击升级</a>
    						
    					<?php }?>
    				</div>
    				
				<?php }?>
			</div>
			<div class="identity_zhong">
				<h5>简介：</h5>
				<p class="identity_zhong_p"><?php echo $v['intro']?></p>
			</div>
			<?php if( $v['rebaterate_description'] ){
			    $description = json_decode($v['rebaterate_description'],true);
			    
			    if( !is_array( $description ) )
			    { 
			        $description = array();
			    }
			        
		    ?>
			<dl class="identity_dl">
				<?php foreach ( $description as $val ) {?>
				<dd>
					<a href="javascript:void(0);"><p class="identity_dl_left"><?php echo $val['name']?></p>
						<p class="identity_dl_right"><?php echo is_numeric( $val['rebaterate'] ) ? $val['rebaterate'].'%' : $val['rebaterate']?></p></a>
				</dd>
				<?php }?>
			</dl>
			<?php }?>
		</li>
		<?php }?>
	</ul>
</div>

<?php }?>
<!--身份升级结束-->
<script>
(function($){
	$.fn.moreText = function(options){
		var defaults = {
			maxLength:45,
			mainCell:".identity_zhong_p",
			openBtn:'展开',
			closeBtn:'收起'
		}
		return this.each(function() {
			var _this = $(this);
			
			var opts = $.extend({},defaults,options);
			var maxLength = opts.maxLength;
			var TextBox = $(opts.mainCell,_this);
			var openBtn = opts.openBtn;
			var closeBtn = opts.closeBtn;
			
			var countText = TextBox.html();
			var newHtml = '';
			if(countText.length > maxLength){
				newHtml = countText.substring(0,maxLength)+'...<span class="more_til">'+openBtn+'<i class="icon-xiala1"></i></span>';
			}else{
				newHtml = countText;
			}
			TextBox.html(newHtml);
			TextBox.on("click",".more_til",function(){
				if($(this).text()==openBtn){
					TextBox.html(countText+' <span class="more_til">'+closeBtn+'<i class="icon-04"></i></span>');
				}else{
					TextBox.html(newHtml);
				}
			})
		})
	}
})(jQuery);
$(function(){
	$(".identity_top li").moreText({
		maxLength: 45, //默认最大显示字数，超过...
		mainCell: '.identity_zhong_p' //文字容器
	});
})
</script>