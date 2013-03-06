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
	<script src="<?php echo $base?>scripts/subdomain.js"></script>
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
					  <li class="active"><a href="<?php echo $base;?>index.php/dnspod">DNSPod站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/dns_set">修改DNSPod密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/out">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		
	<!-- subdomain-list and type A -->
		<div class="container">
				<div>
					<div class="form-horizontal form-horizontal-small"  action="<?php echo $base;?>index.php/dnsapi/addA" >
						<legend>
							<span class="legend"><?php echo $domain[0]["domain_name"];?></span>
						</legend>
						<div>	
							<div class="control-group">
								<input type="hidden" id="dnspodsub_id"/>
								<input type="hidden" id="ttl" value="600"/>
								<input type="hidden" id="recordType" value="A"/>
								<input type="hidden" id="dnspod_domain" value="<?php echo $domain[0]["domain_name"];?>" />
								<input type="hidden" id="dnspod_domainId" value="<?php echo $domain[0]["domain_id"]; ?>"/>
								<input type="text" id="subDomain" name="subDomain"  placeholder="二级域名" class="span2"  />
								<input type="text" id="domainIP" name="domainIP"  placeholder="源站IP" class="span2"  />
								<select class="span2" id="iplist" title="选择节点IP" >
								<?php for($i=0;$i<count($nodeip);$i++) { ?>
									<option value="<?php echo $nodeip[$i]["NodeIP"]; ?>"><?php echo $nodeip[$i]["NodeIP"]; ?></option>
								<? } ?>
								</select>
								<select name="recordLine" style="width:80px;" id="recordLine" title="选择线路" >
									<option selected="默认">默认</option>
									<option value="电信">电信</option>
									<option value="联通">联通</option>
									<option value="教育网">教育网</option>
									<option value="移动">移动</option>
									<option value="铁通">铁通</option>
									<option value="国内">国内</option>
									<option value="国外">国外</option>
									<option value="搜索引擎">搜索引擎</option>
									<option value="百度">百度</option>
									<option value="Google">Google</option>
									<option value="有道">有道</option>
									<option value="必应">必应</option>
									<option value="搜搜">搜搜</option>
									<option value="搜狗">搜狗</option>
									<option value="360搜索">360搜索</option>
								</select>
								<button id="button_edit_record"  class="btn btn-primary help-inline" data-loading-text="请求中...">确认</button>
								<button id="button_edit_record_reset"  class="btn help-inline" onclick="reset_from()" >重置</button>
							</div>
						</div>
					</div>
				</div>
		</div>
		<div class="container">
			<div id="subdomain_list" class="domain-box"></div>
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