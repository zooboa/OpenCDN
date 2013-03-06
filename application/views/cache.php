<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>CDN管理平台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>css/cache.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script>var basePath = "<?php echo $base?>";</script>
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $base;?>scripts/cache.js"></script>
</head>
	<body>
		<div>
			<div class=".container">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="#">OpenCDN</a>
						<ul class="nav">
							<?php if("0"==$domain[0]['parent_id'] and "1" == $check[0]['tell']) { ?>
							<li><a href="<?php echo $base;?>index.php/node">CDN节点管理</a></li>
							<li class="active"><a href="<?php echo $base;?>index.php/domain">站点管理</a></li>
							<li><a href="<?php echo $base;?>index.php/dnspod">DNSPod站点管理</a></li>
					  		<li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
					  		<li><a href="<?php echo $base;?>index.php/dns_set">改DNSPod密码</a></li>
					  		<li><a href="<?php echo $base;?>index.php/out">退出</a></li>
							<?php } else { ?>
							<li><a href="<?php echo $base;?>index.php/domain_user">站点管理</a></li>
						    <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
						    <li><a href="<?php echo $base;?>index.php/dns_set">修改DNSPod密码</a></li>
					  		<li><a href="<?php echo $base;?>index.php/out">退出</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		<!-- Index Page -->
		<div>
				
			<div class="demo">
				
				<?php if(count($domain) > 0) { ?>
				<legend>
					<span class="legend">
					<?php if("0"==$domain[0]['parent_id']) { ?>
						<a href='<?php echo $base; ?>index.php/domain'><?php echo $domain[0]['domain_name']; ?> 缓存配置</a>
						<input type="hidden" id="domain_name" value="<?php echo $domain[0]['domain_name']; ?>" />
					<?php } else { ?>
						<a href='<?php echo $base; ?>index.php/subdomain/index/<?php echo $domain[0]['parent_id']; ?>'><?php echo $domain[0]['sub_domain'].".".$domain[0]['domain_name']; ?> 缓存配置</a>
						<input type="hidden" id="domain_name" value="<?php echo $domain[0]['sub_domain'].".".$domain[0]['domain_name']; ?>" />
					<?php } ?>
					<input type="hidden" id="domain_id" value="<?php echo $domain[0]['id']; ?>" />
					</span>
				</legend>
				<?php } ?>
				<form id="submit">
					<div class="control-group"style="margin:0 0 10px 0;">
						<!--<label class="control-label" for="username">匹配方式</label>-->
						<div class="controls">
						<div>
							<span class="cache_home">匹配方式</span>
							<select id="proxy_cache">
								<option value="目录">目录</option>
								<option value="文件类型">文件类型</option>
							</select>
							<input  type="text" name="cacahe_select" id="cacahe_select" placeholder="目录:/xxx 文件类型:jsp|php|asp" />
							<br />
							<span class="cache_home">缓存方式</span>
							<select id="tell_cache">
								<option value="Y">缓存</option>
								<option value="N">不缓存</option>
							</select>
							<input  type="text" name="cache_time" id="cache_time" placeholder="缓存时间以天为单位"/>
						</div>
							<div id="login" class="btn btn-primary">
								<i class="icon-user icon-white"></i>
							<span class="button" id="cache_add">添加</span>
							</div>
							<br /><br /><br />
							<p class="cache_home">缓存配置选项</p>
							<div class="cache_index"style="margin:0 0 10px 0;">
							<p class="cache_home">默认方案</p>
								<input type="checkbox" id="all_cache" class="tell_one" />&nbsp;&nbsp;<span class="cache_home">全站缓存(必选)</span>
								<!--<span class="cache_home">全站缓存</span>-->
								<input type="checkbox" id="all_cache_out" class="tell_one" />&nbsp;&nbsp;<span class="cache_home">排除动态脚本(可选)</span>
							</div>
							<div class="cache_index">
							<p class="cache_home">方案二</p>
								<input type="checkbox" value="1" id="all_re" class="all_re"/>&nbsp;&nbsp;<span class="cache_home">全站回源(必选)</span>
								<input type="checkbox" value="1" id="normal_cache" class="normal_cache"/>&nbsp;&nbsp;<span class="cache_home">常用扩展缓存(可选)</span>
								<input type="checkbox" value="1" id="index_cache" class="index_cache"/>&nbsp;&nbsp;<span class="cache_home">首页/目录缓存(可选)</span>
								<input type="checkbox" value="1" id="htm_cache" class="htm_cache"/>&nbsp;&nbsp;<span class="cache_home">htm缓存(可选)</span>
							</div>
						</div>
					</div>
				</form>
				<br />
				<table class="table" style="width:600px">
					<thead>
						<tr>
							<th colspan="2">配置信息</th>
							<th colspan="1"></th>
						</tr>
					</thead>
					<tr>
						<td class="cache_home" width="221">配置方式</td>
						<td class="cache_home" width="222">缓存资源类型</td>
						<td class="cache_home" width="109">缓存方式</td>
						<td class="cache_home" width="68">操作</td>
					</tr>
					<tbody id="cache_list"></tbody>
				</table>
				
			</div>
		
			
		</div>
		<div id="footer relative">
			<?php if(count($domain) > 0) { ?>
			<input type="hidden" id="domain_id" value="<?php echo $domain[0]['id']; ?>" />
			<?php } ?>
			<div class="form-actions" style="margin-bottom:0px;">
				<div class="pull-right">
					Powered by <a href="http://www.cdnmate.org/" target="_blank">CDNmate & HDUISA</a>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>