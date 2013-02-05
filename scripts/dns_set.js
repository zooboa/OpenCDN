$(document).ready(function(){

	$("#username").keydown(function (event) {
		if (13 == event.keyCode) {
			$("#password").focus();
		}
	});

	$("#password").keydown(function (event) {
		if (13 == event.keyCode) {
			$("#password_again").focus();
		}
	});
	$("#password_again").keydown(function (event) {
		if (13 == event.keyCode) {
			login_handler();
		}
	});
	$("#login").click(function(){
		login_handler();
	});	
});
function login_handler() {
	$.post($("#baseUrl").attr('value')+'index.php/dns_set/check', 
		$("#submit").serialize(),
		function(odata){
			if (odata.result == 0){
				alert(odata.error);
			} else {
				alert(odata.error);
				window.location.href = $("#baseUrl").attr('value') + 'index.php/node';
			}
		},
	"json");
}