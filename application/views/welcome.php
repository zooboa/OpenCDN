<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>OpenCdn管理平台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $base;?>scripts/welcome.js"></script>
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
								<a href="<?php echo $base?>index.php/revise">修改密码</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<!-- Index Page -->
		<div>
			<div class="hero-unit">
				<h1>OpenCdn</h1>
					<p>WelCome</p>
				<p>
					<a class="btn btn-primary btn-large"href="<?php echo $base?>index.php/register">
						注册
					</a>
					<a class="btn btn-primary btn-large"href="<?php echo $base?>index.php/login">
						登入
					</a>
				</p>
			</div>
		</div>
		<div id="footer">
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>