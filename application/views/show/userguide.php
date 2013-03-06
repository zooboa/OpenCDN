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
							<li class="active"><a href="<?php echo $base."index.php/show/userguide" ?>">使用手册</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/version" ?>">版本历史</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/demo" ?>">在线演示</a></li>
							<li class=""><a href="<?php echo $base."index.php/show/discuss" ?>">交流社区</a></li>
						</ul>
						<form class="navbar-search pull-left" action="">
							<input type="text" class="search-query span2" placeholder="Search">
						</form>
			  </div>
		</div>
		
		<div class="container" style="margin-top:20px;">
			<h4>使用手册：</h4>
			<div>
				<legend>
					<span class="legend">1、安装需求</span>
				</legend>
				<p>
					OpenCDN的Beta版目前在Centos5.4 32位下测试通过。内存大小：不低于512M内存。
				</p>
			</div>
			<div>
				<legend>
					<span class="legend">2、安装步骤</span>
				</legend>
				<p>
					使用 SSH 连接工具，如 PuTTY、XShell、SecureCRT 等，连接到您的 Linux 服务器。
					执行以下命令开始安装：
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