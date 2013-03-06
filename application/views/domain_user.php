<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>OpenCDN 站点管理</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script>var basePath = "<?php echo $base?>";</script>
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $base;?>scripts/domain_user.js"></script>
  </head>
  <body>
	<div>
		<div>
			<div class="navbar">
				<div class="navbar-inner">
					<a class="brand" href="#">OpenCDN</a>
					<ul class="nav">
						  <li class="active"><a href="javascript:;">站点管理</a></li>
						  <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
						  <li><a href="<?php echo $base;?>index.php/out">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		
	<!-- subdomain-list and type A -->
		<div class="container">
			<div class="form-horizontal form-horizontal-small"  action="<?php echo $base;?>index.php/dnsapi/addA" >
				<div class="control-group">
					<input  type="hidden" id="domain_id" />
					<input  type="text" id="domain_name" name="domain_name" placeholder="域名" style="margin:2px 0 0 0;" />
					<button id="domain_append" class="btn btn-primary help-inline" data-loading-text="请求中...">确认</button>
					<button id="button_edit_record_reset"  class="btn help-inline" onclick="reset_from()" >重置</button>
				</div>
			</div>
			<div id="domain_list" class="domain-box"></div>
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
	<!-- Fix:Please Uncomment this line when release
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	-->
  </body>
</html>