<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>Welcome OpenCdn</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
  </head>
  <body>
	<div>
		<div class=".container">
			<div class="navbar">
				<div class="navbar-inner">
				<a class="brand" href="#">OpenCdn</a>
					<ul class="nav">
					  <li class="active"><a href="#">Home</a></li>
					</ul>
				</div>
			</div>
		</div>
		

		<!-- back -->
		<div class="hero-unit">
		  <h1><?php  echo $msg?></h1>
		  <p>
			<a class="btn btn-primary btn-large" href="javascript:history.go(-1);">
			  点此返回上一页
			</a>
		  </p>
		</div>
		
		<div id="footer">
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Fix:Please Uncomment this line when release
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	-->
	<script src="<?php echo $base?>/scripts/jquery-latest.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>