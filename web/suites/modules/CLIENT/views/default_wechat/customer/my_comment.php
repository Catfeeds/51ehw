
<style type="text/css">
#star {
	position: relative;
	width: 600px;
	margin: 20px auto;
	height: 24px;
}

#star ul, #star span {
	float: left;
	display: inline;
	height: 19px;
	line-height: 19px;
}

#star ul {
	margin: 0 10px;
}

#star li {
	float: left;
	width: 24px;
	cursor: pointer;
	text-indent: -9999px;
	background: url(images/star.png) no-repeat;
}

#star li.on {
	background-position: 0 -28px;
}
</style>

<script type="text/javascript"> 

function stars(){

	var oStar = document.getElementById("star");

	var aLi = oStar.getElementsByTagName("li");

	var oUl = oStar.getElementsByTagName("ul")[0];

	var oSpan = oStar.getElementsByTagName("span")[1];

	var oP = oStar.getElementsByTagName("p")[0];

	var i = iScore = iStar = 0;

	var aMsg = [

				"很不满意|差得太离谱，与卖家描述的严重不符，非常不满",

				"不满意|部分有破损，与卖家描述的不符，不满意",

				"一般|质量一般，没有卖家描述的那么好",

				"满意|质量不错，与卖家描述的基本一致，还是挺满意的",

				"非常满意|质量非常好，与卖家描述的完全一致，非常满意"

				]

	

	for (i = 1; i <= aLi.length; i++){

		aLi[i - 1].index = i;
		
		//鼠标移过显示分数

		aLi[i - 1].onmouseover = function (){

			fnPoint(this.index);

			//浮动层显示

// 			oP.style.display = "block";

// 			//计算浮动层位置

// 			oP.style.left = oUl.offsetLeft + this.index * this.offsetWidth - 104 + "px";

// 			//匹配浮动层文字内容

// 			oP.innerHTML = "<em><b>" + this.index + "</b> 分 " + aMsg[this.index - 1].match(/(.+)\|/)[1] + "</em>" + aMsg[this.index - 1].match(/\|(.+)/)[1]

		};

		//鼠标离开后恢复上次评分

		aLi[i - 1].onmouseout = function (){

			fnPoint();

			//关闭浮动层

// 			oP.style.display = "none"

		};

		//点击后进行评分处理

		aLi[i - 1].onclick = function (){

			iStar = this.index;

// 			oP.style.display = "none";

// 			oSpan.innerHTML = "<strong>" + (this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")"

		}

	}

	//评分处理

	function fnPoint(iArg){

		//分数赋值
		iScore = iArg || iStar;
		for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";	
	}
};

</script>

<div class="page clearfix">
    <div class="order_detail">
        <!--商品列表 start-->
        <?php foreach ($list as $v):?>
         <section id="<?php echo 'product_'.$v['id'];?>">
            <div class="good_list clearfix">
                <div class="fn-left relative">
                    <a href="<?php echo site_url('goods/detail/'.$v['product_id'])?>"><img src="<?php echo IMAGE_URL.$v['goods_thumb'];?>" width="62" height="83"></a>
                </div>
                <div class="notice_box">
                    <p class="fn-14"><?php echo $v['product_name']?></p>
                    <p class="c9">数量：<?php echo $v['quantity']?></p>
                    <p class="fn-14">
                        <span class="red-font">￥<?php echo $v['price']?> </span>
                    </p> 
                </div>
            </div>
            <div class="order_list_handle" style="border-top:1px solid #f2f2f2;">
            <?php if(!$v['comments_id']):?>    
                                 <span><a href="javascript:void(0);" onclick=comment('<?php echo $v['id']?>') class="order_list_cancel">点击评价</a></span>
            <?php else :?>
                <span><a href="javascript:void(0);"  class="order_list_cancel">已评价</a></span>
            <?php endif;?>
                   
                </div>
        </section>
        <!--商品列表 end-->
        <?php endforeach;?>
    </div>
    <!--order_detail end-->
</div>
<!--page end-->

<script type="text/javascript">

/**
 * 根据商品显示评价
 * $id_product 商品id
 */
 function comment(id_product){
	 $('.comment').remove();
	 var html = '';
	 html += '<section class="comment">';
	 html += '<div id="star">';
	 html += '<span>对产品的评价</span>';
	 html += '<ul>';
	 html += '<li class="on"><a href="javascript:;">1</a></li>';
	 html += '<li class="on"><a href="javascript:;">2</a></li>';
	 html += '<li class="on"><a href="javascript:;">3</a></li>';
	 html += '<li class="on"><a href="javascript:;">4</a></li>';
	 html += '<li class="on"><a href="javascript:;">5</a></li>';
	 html += '</ul>';
	 html += '</div>';
	 html += '<div class="incomment">';
	 html += '<p class="fn-14">输入评论</p><span id="input_comment"></span>';
	 html += '<textarea  name="comment" class="incomment_tax" style="width:100%; height:80px; border:1px solid #ccc; margin-top:5px;"></textarea>';
	 html += '<a href="javascript:void(0);" onclick=sub("'+id_product+'"); class="pay-style pay-weixin">提交</a>';
	 html += '</div>';
	 html += '</section>';
	 $('#product_'+id_product).after(html);
	 stars();
 }

/**
 * ajax 提交评价
 */
function sub($id_product){
    var ok_comment = false;
    var comment = $('textarea').val();//评价内容
    var mark = $('.on').length;
    if(comment.length == 0 || comment.match(/^\s+$/g)){
        alert('请输入评价内容');
        return;
    }else{
        $('#input_comment').text('');
        ok_comment=true
    }
 
    if(ok_comment){
        var orderitem_id = $id_product;
        var url = "<?php echo site_url('member/my_comment/increase_comment')?>"
        var user_id = "<?php echo $this->session->userdata['user_id'];?>"
        $.ajax({ 
            url:url,
            type:'post',
            data:{ id : $id_product , comment : comment , mark : mark , user_id:user_id },
            dataType:'json',
            success:function (data){
                if(data){
                    $('.comment').remove();
                    window.location.reload();
                }
            },
            error:function(){
                alert('操作失败')
            }
        })
    }
}

</script>

