$(document).ready(function(){

	$("#username").keydown(function (event) {
		if (13 == event.keyCode) {
			$("#password").focus();
		}
	});

	$("#password").keydown(function (event) {
		if (13 == event.keyCode) {
			login_handler();
		}
	});

	$("#login").click(function(){
		login_handler();
	});	
});
function login_handler() {
	$.post($("#baseUrl").attr('value')+'index.php/login/check', 
		$("#submit").serialize(),
		function(odata){
			if (odata.result == 0){
				alert(odata.error);
			} else if(odata.result == 2){
				window.location.href = $("#baseUrl").attr('value') + 'index.php/domain';
			}else{
				window.location.href = $("#baseUrl").attr('value') + 'index.php/domain_user';			
			}
		},
	"json");
}