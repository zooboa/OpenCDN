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
		
		<div class="navbar navbar-static-top">
			  <div class="navbar-inner">
						<span class="brand">OpenCdn</span>
						<ul class="nav">
							<li class=""><a href="<?php echo $base."index.php/show/index" ?>">首页</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/func" ?>">功能特性</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/userguide" ?>">使用手册</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/version" ?>">版本历史</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/demo" ?>">在线演示</a></li>
							<li class="active"><a href="<?php echo $base."index.php/show/discuss" ?>">交流社区</a></li>
						</ul>
						<form class="navbar-search pull-left" action="">
							<input type="text" class="search-query span2" placeholder="Search">
						</form>
			  </div>
		</div>
		
		<div class="container">
			<div class="hero-unit">
			  <h1>Heading</h1>
			  <p>Tagline</p>
			  <p>
				<a class="btn btn-primary btn-large">
				  Learn more
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
	<!-- Fix:Please Uncomment this line when release
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	-->
	<script src="<?php echo $base?>/scripts/jquery-latest.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script language="JavaScript">
	</script>
  </body>
</html>