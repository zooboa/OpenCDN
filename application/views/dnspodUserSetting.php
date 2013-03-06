<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>CDN管理平台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script>var basePath="<?php echo $base;?>";</script>
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script>
	$(document).ready(function(){
		$("#DNSPodUser").keydown(function (event) {
			if (13==event.keyCode) {
				$("#DNSPodPass").focus();
			}
		});
		$("#DNSPodPass").keydown(function (event) {
			if (13==event.keyCode) {
				setting_dnspod_handler();
			}
		});
		$("#button_login").click(function () {
			setting_dnspod_handler();
		});
	});
	function setting_dnspod_handler() {
		var dnspod_user = $("#DNSPodUser").val();
		if (""==dnspod_user.trim()) {
			alert("DNSPod帐号不可以为空");
			return ;
		}
		
		var dnspod_pass = $("#DNSPodPass").val();
		if (""==dnspod_pass) {
			alert("DNSPod密码不可以为空");
			return ;
		}
		
		$.post(basePath+"index.php/dnspod/setting_dnspod_user", 
			{dnspod_user:dnspod_user, dnspod_pass:dnspod_pass},
			function (data) {
				if (0==data.code) {
					alert(data.message);
				} else {
					location.href=basePath+'index.php/dnspod';
				}
			}, 
		"json");
	}
	</script>
</head>
	<body>
		<div>
			<div class=".container">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?php echo $base?>">OpenCdn</a>
						<ul class="nav">
						  <li><a href="<?php echo $base;?>index.php/node">CDN节点管理</a></li>
						  <li><a href="<?php echo $base;?>index.php/domain">站点管理</a></li>
						  <li class="active"><a href="javascript:;">DNSPod帐号设置</a></li>
						</ul>
					</div>
				</div>
			</div>
		<!-- Login Dnspod Bar -->
		<div class="form-horizontal form-horizontal-small">
			<div class="alert">DnsPod帐号设置，<span style="padding:0 0 0 20px;">如：用户名:demo@ocdn.me 密码:ocdn.me</span></div>
			<div>
				<div class="control-group">
					<label class="control-label" for="username">DNSPod帐号</label>
					<div class="controls">
						<input type="text" name="DNSPodUser" id="DNSPodUser" placeholder="DNSPod帐号" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">DNSPod密码</label>
					<div class="controls">
						<input type="password" name="DNSPodPass" id="DNSPodPass" placeholder="DNSPod密码" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button id="button_login" class="btn btn-primary">
							<i class="icon-user icon-white"></i>
							<span>确定</span>
						</button>
						<!--<span class="help-inline" style="padding-left:20px">
							<a href="#" onclick="return false">忘记密码？</a>
						</span>-->
					</div>
				</div>
			</div>
		</div>
		
		<div id="footer">
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
				</div>
			</div>
		</div>
	</body>
</html>