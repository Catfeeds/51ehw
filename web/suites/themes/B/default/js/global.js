function formsearch(){
	if($('#search_product').val() != "" ){
		document.search_form.submit();
		return true;
	}else{
//		alert('请填写搜索关键字，谢谢！');
		return false;
	}
}