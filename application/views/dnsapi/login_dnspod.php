<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>CDN管理平台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
</head>
	<body>
		<div>
			<div class=".container">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?php echo $base?>">OpenCdn</a>
						<ul class="nav">
							<li class="active">
								<a href="<?php echo $base?>">Home</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<!-- Login Dnspod Bar -->
		<div>
			<form class="form-horizontal form-horizontal-small"id="submit" method="post" action="<?php echo $base;?>index.php/dnsapi/login_dnspod">
				<legend>
					<span class="legend">登录DnsPod</span>
				</legend>
					<div class="alert">请在此输入DnsPod上的账户名和密码，以便我们调用DnsPod上的Api<span style="padding:0 0 0 20px;">用户名:demo@ocdn.me 密码:ocdn.me</span></div>
					<div class="alert alert-info">请在此操作前，确保你的Dns服务器地址已在Dnspod</div>
					<div>
						<div class="control-group">
							<label class="control-label" for="username">用户邮箱</label>
							<div class="controls">
								<input  type="text" name="username" id="username" placeholder="用户邮箱" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password">密码</label>
							<div class="controls">
								<input  type="password" name="password" id="password" placeholder="密码" />
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button id="login" class="btn btn-primary">
									<i class="icon-user icon-white"></i>
									<span>登录</span>
								</button>
								<!--<span class="help-inline" style="padding-left:20px">
									<a href="#" onclick="return false">忘记密码？</a>
								</span>-->
							</div>
						</div>
					</div>
			</form>
		</div>
		
		<div id="footer">
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
				</div>
			</div>
		</div>
	</div>
		<script src="<?php echo $base?>scripts/jquery-latest.js"></script>
		<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
		<input type="hidden" id="baseUrl" value="<?php echo $base;?>" />	
	</body>
</html>