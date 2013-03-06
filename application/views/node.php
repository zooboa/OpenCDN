<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>OpenCDN 节点管理</title>
    <!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
  </head>
  <body>
	<div>
		<div>
			<div class="navbar">
				<div class="navbar-inner">
					<a class="brand" href="#">OpenCDN</a>
					<ul class="nav">
					  <li class="active"><a href="javascript:;">CDN节点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/domain">站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/dnspod">DNSPod站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/dns_set">修改DNSPod密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/out">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		
	<!-- subdomain-list and type A -->
		<div class="container">
			<div class="control-group">
				<form id="ipadd">
					<input  type="text" id="NodeIP"name="NodeIP"  placeholder="ip地址" class="span2"style="margin:2px 0 0 0;"  />
					<button id="formSubmit"  class="btn btn-primary help-inline" data-loading-text="请求中...">添加</button>
				</form>
			</div>
			<div class="domain-box">
				<div class="row-fluid list-header">	
					<div class="span3">节点名称</div>
					<div class="span3">IP地址</div>
					<div class="span3">状态</div>
					<div class="span3">操作</div>
				</div>
				<div class="row-fluid show-grid click-change"id="list">
				</div>
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
	<input type="hidden" id="baseUrl" value="<?php echo $base;?>" />
	<!-- Fix:Please Uncomment this line when release
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	-->
	<script src="<?php echo $base?>/scripts/jquery-latest.js"></script>
	<script src="<?php echo $base?>/bootstrap/js/bootstrap.min.js"></script>
	<script language="JavaScript">
		/* Bootstrap Javascript Call code */
		function list(){
			var tell = 0;
			$.post($("#baseUrl").attr('value')+'index.php/node/list_ip',
				function(date){
					var result = jQuery.parseJSON(date);
					$("#list").html('');
					for( var i = 0;i<result.length;i++){
						if(result[i]['Status'] == 'on'){
							$("#list").append('<div class="row-fluid show-grid click-change"><div class="span3">节点'+(i+1)+'</div><div class="span3">'+result[i]["NodeIP"]+'</div><div class="span3">联机</div><div class="span3"><span id="'+result[i]["NodeIP"]+'" onmousedown="turn(this);" role="button" class="btn btn-primary" >详情</span><span id="'+result[i]["NodeIP"]+'" onmousedown="del(this);"role="button" class="btn btn-primary" >删除</a></div></div>');
						}else{
							$("#list").append('<div class="row-fluid show-grid click-change"><div class="span3">节点'+(i+1)+'</div><div class="span3">'+result[i]["NodeIP"]+'</div><div class="span3">断线</div><div class="span3"><span role="button" class="btn btn-primary">暂无</span><span id="'+result[i]["NodeIP"]+'" onmousedown="del(this);"role="button" class="btn btn-primary" >删除</a></div></div>');
						}
					}
				});
		tell = 1;
		}
		list();
		setInterval(function(){list();},5000);
		function turn(message)
		{
			var turn = message.id;
			window.location.href = $("#baseUrl").attr('value') + 'index.php/check/index/'+turn;
		}
		function del(message)
		{
			//var tell = 0;
			var del = message.id;
			$.post($("#baseUrl").attr('value')+'index.php/node/delect',{del_id:del},
				function(data){
				var result = jQuery.parseJSON(data);
				if(result['error'] == 1){
				list();
				alert(result['return']);
				}else{
					alert(result['return']);
				}
			});
		}
		$('#formSubmit').click( function (){
			$("#formSubmit").button("loading");
			NodeIP = $("#NodeIP").attr("value");
			$.post($("#baseUrl").attr('value')+'index.php/node/add',$("#ipadd").serialize(),function(_data){
				if(_data.status =="1"){
					$('#formSubmit').attr("data-content","添加成功");
					$('#formSubmit').popover("show");
					setTimeout(function(){
						$('#formSubmit').popover("hide");
						$('#formSubmit').button("reset");
						location.reload();
					},1500);
				}else if(_data.status == 0){
					alert("检测到非法字符,请重试.");
					$('#formSubmit').button("reset");
				}else{
					$('#formSubmit').attr("data-content","添加失败,请检查输入,ip不可相同");
					$('#formSubmit').popover("show");
					setTimeout(function(){
						$('#formSubmit').popover("hide");
						$('#formSubmit').button("reset");
					},1500);
				}
			},'json');
			return false;
		});
	</script>
  </body>
</html>