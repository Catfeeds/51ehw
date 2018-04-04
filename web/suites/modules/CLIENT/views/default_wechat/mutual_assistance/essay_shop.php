<style type="text/css">
   .essay_shop { position: relative;width: 100%;height: 100%; }
   .essay_shop img {height: 100%;width: 100%;}
   .essay_shop_but {position: absolute;bottom: 4%;width: 40%;left: 30%;}
   @media screen and (min-width:640px) and (max-width:1200px){
   	.essay_shop_but {position: fixed;bottom:0px;width: 250px;left: 50%;margin-left: -125px;}
   }
</style>

<div class="essay_shop">
	<img src="images/essay_shop.png" alt="">
	<a href="javascript:void(purchase_shop());" class="essay_shop_but">
		<img src="images/pay_but.png">
	</a>
</div>

<script>
function purchase_shop()
{
	 window.location.href="<#pay_shop#>";
}
</script>