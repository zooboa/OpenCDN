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
					  <li class="active"><a href="<?php echo $base;?>index.php">Home</a></li>
					  <li class="active"><a href="<?php echo $base;?>index.php/node">节点列表</a></li>
					  <li class="active"><a href="<?php echo $base;?>/index.php/dnsapi/judge_dnspod_login">域名列表</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="container">
				<div>
					<div class="form-horizontal form-horizontal-small" >
						<legend>
							<span class="legend">Tip：修改域名的Dns服务器至Dnspod</span>
						</legend>
							<div>	
								<div class="control-group">
									<input  type="text" id="formDomain" name="domain"  placeholder="填写一级域名，不带www" class="span3"  />
									<button id="formSubmit"  class="btn btn-primary help-inline" data-loading-text="请求中...">添加</button>
								</div>
							</div>
					</div>
				</div>
		</div>
		<!-- domain-list -->
		<div class="container">
			<div class="domain-box">
					<div class="row-fluid list-header">	
					  <div class="span4">域名</div>
					  <div class="span4">操作</div>
					</div>
					<?php 
						$count = count($domain);
						for($i=0;$i<$count;$i++){
					?>
					<div class="row-fluid show-grid click-change">
					  <div class="span4"><a href="<?php echo $base."index.php/dnsapi/subdomain?domain=".$domain[$i]["domain"]."&domainid=".$domain[$i]["domainid"]?>"><?php echo $domain[$i]["domain"]?></a></div>
					  <div class="span4">
						<?php 
								if($domain[$i]["status"]==0){ 
						?>
							<a href="<?php echo $base."index.php/dnsapi/Domain_Create?newDomain=".$domain[$i]["domain"] ?>">Dns解析未修改</a>
						<?php 
								}else{
						?>
							状态正常
						<?php
							}
						?>
					  </div>
					  <div class="span4">
						<a href="<?php echo $base."index.php/cache/index/".$domain[$i]["id"]?>">缓存配置</a>
					  </div>
					</div>
					<?php 
						}
					?>
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
		$(".js-edit-on").tooltip({
			placement:'left',
			title:'点击修改备注',
		});	
		
		$('#formSubmit').click( function (){
			$("#formSubmit").button("loading");
			_domain = $("#formDomain").attr("value");
			$.get("<?php echo $base;?>index.php/dnsapi/toLocal",{domain:_domain},function(_data){
				if(_data.status =="1"){
					$("#formSubmit").attr("data-content","添加成功");
					$('#formSubmit').popover("show");
					setTimeout(function(){
						$('#formSubmit').popover("hide");
						$("#formSubmit").button("reset");
						location.reload();
					},1500);
				}else{
					$("#formSubmit").attr("data-content","添加失败,请检查输入");
					$('#formSubmit').popover("show");
					setTimeout(function(){
						$('#formSubmit').popover("hide");
						$("#formSubmit").button("reset");
					},1500);
				}
			},'json');
			return false;
		});
			
		$('#formSubmit').popover({
			placement:"right",
			title:"tip",
			trigger:"manual",
			delay:{
				show:200,
				hide:100,
			},
		});
		function click(look){
			alert();
		}
		
		
	</script>
  </body>
</html>