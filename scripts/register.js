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
	$("#username_t").keydown(function (event) {
		if (13 == event.keyCode) {
			$("#password_t").focus();
		}
	});
	$("#password_again_t").keydown(function (event) {
		if (13 == event.keyCode) {
			login_handler_t();
		}
	});
	$("#password_t").keydown(function (event) {
		if (13 == event.keyCode) {
			$("#password_again_t").focus();
		}
	});

	$("#login_t").click(function(){
		login_handler_t();
	});	
});
function login_handler() {
	$.post($("#baseUrl").attr('value')+'index.php/register/check', 
		$("#submit").serialize(),
		function(odata){
			if (odata.result == 0){
				alert(odata.error);
			} else {
				alert(odata.error);
				window.location.href = $("#baseUrl").attr('value') + 'index.php/dns_set';
			}
		},
	"json");
}
function login_handler_t() {
	$.post($("#baseUrl").attr('value')+'index.php/register/check_t', 
		$("#submit_t").serialize(),
		function(odata){
			if (odata.result == 0){
				alert(odata.error);
			} else {
				alert(odata.error);
				window.location.href = $("#baseUrl").attr('value') + 'index.php/domain_user';
			}
		},
	"json");
}