<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>OpenCdn管理平台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $base;?>scripts/register.js"></script>
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
							<li class="active">
								<a href="<?php echo $base?>index.php/register">注册</a>
							</li>
							<!--<li>
								<a href="#">Link</a>
							</li>
							<li>
								<a href="#">Link</a>
							</li>-->
						</ul>
					</div>
				</div>
			</div>
		<!-- Login Bar -->
		<div>
			<form class="form-horizontal form-horizontal-small"id="submit_t">
				<!--<legend>
					<span class="legend">登录</span>
				</legend>-->
					<div class="alert">用户注册</div>
					<div>
						<div class="control-group">
							<label class="control-label" for="username_t">用户名</label>
							<div class="controls">
								<input  type="text" name="username_t" id="username_t" placeholder="用户名" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password_t">密码</label>
							<div class="controls">
								<input  type="password" name="password_t" id="password_t" placeholder="密码" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password_again_t">再次输入密码</label>
							<div class="controls">
								<input  type="password" name="password_again_t" id="password_again_t" placeholder="再次输入密码" />
							</div>
						</div>
						<!--<div class="control-group">
							<label class="control-label" for="Verification">验证码</label>
							<div class="controls">
								<input  type="text" name="Verdivcation" id="Verification" placeholder="验证码" />
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<img  src="<?php echo $base?>extern/captcha.php" />
							</div>
						</div>-->
						<div class="control-group">
							<div class="controls">
								<div id="login_t" class="btn btn-primary">
									<i class="icon-user icon-white"></i>
									<span>注册</span>
								</div>
								<!--<span class="help-inline" style="padding-left:20px">
									<a href="#" onclick="return false">忘记密码？</a>
								</span>-->
							</div>
						</div>
					</div>
			</form>
		</div>
		<!--<div id="footer">
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
				</div>
			</div>
		</div>-->
	</div>
		<input type="hidden" id="baseUrl" value="<?php echo $base;?>" />	
	</body>
</html>