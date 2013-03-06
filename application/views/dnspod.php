<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>OpenCDN DnsPod站点管理</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script>var basePath="<?php echo $base;?>";</script>
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base?>scripts/dnspod.js"></script>
  </head>
  <body>
	<div>
		<div class=".container">
			<div class="navbar">
				<div class="navbar-inner">
					<a class="brand" href="#">OpenCDN</a>
					<ul class="nav">
					  <li><a href="<?php echo $base;?>index.php/node">CDN节点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/domain">站点管理</a></li>
					  <li class="active"><a href="javascript:;">DNSPod站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/dns_set">修改DNSPod密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/out">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="form-horizontal form-horizontal-small">
				<div>	
					<div class="control-group">
						<input  type="text" id="dnspod_domain"  placeholder="填写一级域名，不带www" class="span3"  />
						<input type="button" id="buttonAppendDomain" class="btn btn-primary help-inline" value="添加"  />
					</div>
				</div>
			</div>
		</div>
		<!-- domain-list -->
		<div class="container">
			<div id="dnspod_domain_list" class="domain-box">
					<!--
					<div class="row-fluid list-header">	
					  <div class="span8">域名</div>
					  <div class="span4">状态</div>
					  <div class="span4">操作</div>
					</div>

					<div class="row-fluid show-grid click-change"></div>-->
			</div>
		</div>
	</div>
	<script language="JavaScript">
		
	</script>
  </body>
</html>