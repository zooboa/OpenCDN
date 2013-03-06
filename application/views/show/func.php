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
							<li class="active"><a href="<?php echo $base."index.php/show/func" ?>">功能特性</a></li>
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
		
		<div class="container" style="margin-top:20px;">
			<div class="alert alert-info">本平台是针对专门提供CDN服务的公司或对多节点CDN有需求的企业，提供一套便捷的CDN管理平台，可对每一个节点的状态进行监测与统一管理，同时我们预制了多套常用缓存规则，支持多种复杂的CDN缓存场景。
			</div>
			<div style="margin-left:200px;">
				<img src="<?php echo $base."images/CDNstruct.png" ; ?>" style="width:480px;height:360px;"/>
			</div>
			<div>
				<legend>
					<span class="legend">CDN缓存加速</span>
				</legend>
				<p>		通过nginx缓存加速模块对网站性能优化，结合DnsPod综合采用多线路智能调度、故障监测、页面优化、页面缓存等技术，能够进一步提升网站访问速度，降低故障率，从而整体提升网站的用户体验。
				</p>
			</div>
			
			<div>
				<legend>
					<span class="legend">多节点分流，自动故障监测，提高性能与整体可用性</span>
				</legend>
				<p>CDN的节点将承载大部分的访客流量，并通过负载均衡算法将流量分配到各个节点中，当某个节点出现故障时，其内在的调度机制能在3秒钟内将故障节点的流量牵引至当前可用节点，完全不影响访客的请求。即使源网站因故障导致中断，由于CDN节点对页面及静态资源均作了缓存，监测端不会认为网站故障，同时也不影响用户的正常访问。
				</p>
			</div>
			
			<div>
				<legend>
					<span class="legend">集中管控，集中编制策略</span>
				</legend>
				<p>
					对于加入CDN管理平台的节点，将由管控中心对其进行统一的状态监测与缓存策略控制，新的缓存规则配置通过一键即可使所有节点生效
				</p>
			</div>
			
			<div style="margin-bottom:100px;">
				<legend>
					<span class="legend">访问数据收集与分析</span>
				</legend>
				<p>
					将各个CDN节点上的日志进行汇总收集/分析，能够获取到所有用户详细的访问行为，同时对所有的非法访问行为进行均记录在案。
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