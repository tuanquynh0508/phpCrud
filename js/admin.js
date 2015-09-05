$('.btnDelete').click(function(event){
	if(!confirm('Bạn có muốn xóa không?')) {
		event.preventDefault();
	}
});

$('.btnSearch').click(function(){
	$('#frmSearch').submit();
});