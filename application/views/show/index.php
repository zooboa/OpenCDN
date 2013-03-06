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
							<li class="active"><a href="<?php echo $base."index.php/show/index" ?>">首页</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/func" ?>">功能特性</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/userguide" ?>">使用手册</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/version" ?>">版本历史</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/demo" ?>">在线演示</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/discuss" ?>">交流社区</a></li>
						</ul>
						<form class="navbar-search pull-left" action="">
							<input type="text" class="search-query span2" placeholder="Search">
						</form>
			  </div>
		</div>
		
		<div class="container" style="margin-top:12px;">
			<div class="hero-unit">
			  <h1>OpenCDN<small>快速打造你的<span style="color:green;">私有CDN</span></small></h1>
			  <p>
				<div>
					<h4>提供整套工具</h4>
					<p>
						帮私有CDN建设者提供便捷的工具，实时自助开设CDN
					</p>
				</div>
				<div>
					<h4>降低技术门槛</h4>
					<p>
						无需任何技术门槛，点击鼠标即可架设高可用CDN系统
					</p>
				</div>
				<div>
					<h4>统一管控</h4>
					<p>
						管理平台对每一个节点的状态进行监测与统一管理
					</p>
				</div>
				<div>
					<h4>预制模板</h4>
					<p>
						我们预制了多套常用缓存规则，支持多种复杂的缓存场景
					</p>
				</div>
			  </p>
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