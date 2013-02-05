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
					  <li class="active"><a href="#">Home</a></li>
					  <li class="active"><a href="<?php echo $base?>index.php/dnsapi/domain">域名列表</a></li>
					</ul>
				</div>
			</div>
		</div>
		
	<!-- subdomain-list and type A -->
		<div class="container">
				<div>
					<div class="form-horizontal form-horizontal-small"   action="<?php echo $base;?>index.php/dnsapi/addA" >
						<legend>
							<span class="legend"><?php echo $_GET["domain"];?></span>
						</legend>
							<div>	
								<div class="control-group">
									<input  type="text" id="subDomain"name="subDomain"  placeholder="二级域名" class="span2"  />
									<select  type="text" name="value"  placeholder="ip地址" class="span2" id="ipvalue" >
									</select>
									<input type="hidden" name="domainId" value="<?php echo $_GET["domainid"] ?>"/>
									<input type="hidden" name="recordType" value="A"/>
									<input type="hidden" name="ttl" value="600"/>
									<input type="hidden" name="domain" value="<?php echo $_GET["domain"];?>" />
									<select name="recordLine" style="width:80px;" id="recordLine">
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
									<button id="formSubmit"  class="btn btn-primary help-inline" data-loading-text="请求中...">添加</button>
								</div>
							</div>
					</div>
				</div>
		</div>
		<div class="container">
			<div class="domain-box">
					<div class="row-fluid list-header">	
					  <div class="span2">域名</div>
					  <div class="span2">线路</div>
					  <div class="span2">ip地址</div>
					  <div class="span2">切换状态</div>
					  <div class="span2">操作</div>
					</div>
			<?php
				$count = count($monitorList);
				for($i=0;$i<$count;$i++){
			?>
					<div class="row-fluid show-grid click-change">
					  <div class="span2">
							<?php echo $monitorList[$i]["sub_domain"] ?>
					  </div>
					  <div class="span2"><?php echo $monitorList[$i]["record_line"] ?></div>
					  <div class="span2"><?php echo $monitorList[$i]["ip"] ?></div>
					  <div class="span2"><?php echo $monitorList[$i]["bak_ip"]=="auto"?"智能切换":$monitorList[$i]["bak_ip"]; ?></div>
					  <div class="span2">
						<a href="#<?php echo $monitorList[$i]["monitor_id"]."add"?>" role="button" class="btn btn-primary" data-toggle="modal">自定义故障处理</a>
						<!-- Modal -->
						<div id="<?php echo $monitorList[$i]["monitor_id"]."add"?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						  </div>
						  <div class="modal-body">
								<div>
									<form class="form-horizontal form-horizontal-small"  method="post" action="<?php echo $base;?>index.php/dnsapi/test" >
										<legend>
											<span class="legend">自定义切换模式</span>
										</legend>
											<div>
												<div class="control-group">
													<label class="control-label" for="bak_ip">输入节点备用IP</label>
													<div class="controls">
														<input  type="text" name="bak_ip" id="<?php echo $monitorList[$i]["monitor_id"]?>" placeholder="备用IP" />
													</div>
												</div>
											</div>
									</form>
								</div>
						  </div>
						  <div class="modal-footer">
							<button class="btn " data-dismiss="modal" aria-hidden="true" id="closeBtn">Close</button>
							<button class="btn toAuto primary" data-dismiss="modal"  address="<?php echo $monitorList[$i]["monitor_id"]?>" domain="<?php echo $monitorList[$i]["domain"] ?>"  >切换至auto模式</button>						
							<button class="btn btn-primary saveChanges" data-dismiss="modal"  address="<?php echo $monitorList[$i]["monitor_id"]?>" domain="<?php echo $monitorList[$i]["domain"] ?>" >Save changes</button>
						  </div>
						</div>
					  </div>
					</div>
			<?php 
				}
			?>
			</div>
		</div>
		<input type="hidden" id="baseUrl" value="<?php echo $base;?>" />
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
		/* Bootstrap Javascript Call code */
		$(".js-edit-on").tooltip({
			placement:'left',
			title:'呵呵',
		});	
		
		$("#recordLine").tooltip({
			placement:'top',
			title:'线路类型',
		});	
		
		
		$("#subDomain").tooltip({
			placement:'top',
			title:'exmple:test',
		});	
		
		$('#formSubmit').click( function (){
			$("#formSubmit").button("loading");
			subDomain = $("#subDomain").attr("value");
			recordLine = $("#recordLine").attr("value");
			_value = $("#ipvalue").attr("value");
			$.get("<?php echo $base;?>index.php/dnsapi/addA?domainId=<?php echo $_GET["domainid"];?>&recordType=A&ttl=600&domain=<?php echo $_GET["domain"]?>&recordLine="+recordLine+"&subDomain="+subDomain+"&value="+_value,{},function(_data){
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
	</script>
	<script language="JavaScript">
			/*function change(look){
				var change = look.id;
				var obj = document.getElementById(change);
				var a = obj.getElementsByTagName("form");
				if(a.length > 0){
				}else{
					document.getElementById(change).innerHTML = '<form><input class="span-2"type="text"/><button class="btn btn-primary help-inline">保存</span><button class="btn btn-primary help-inline">取消</button></form>';
				}
		}*/
		$(document).ready(function(){
			$(".saveChanges").click(function(){
				_address = $(this).attr("address");
				_domain = $(this).attr("domain");
				_domain = "www."+_domain;
				_ip = $("#"+_address).attr("value");
				$.get("<?php echo  $base?>index.php/dnsapi/Monitor_Modify?monitorId="+_address+"&port=80&monitorInterval=180&host="+_domain+"&monitorType=http&monitorPath=/&points=ctc,cuc,cmc&bakIp="+_ip+"&smsNotice=me,share&emailNotice=me,share&lessNotice=yes",{},function(data){
					if(data = 1){
						alert("修改成功");
						location.reload();
					}else{
						alert("修改失败");
					}
				},"json");
			});
			
			$(".toAuto").click(function(){
				_address = $(this).attr("address");
				_domain = $(this).attr("domain");
				_domain = "www."+_domain;
				$.get("<?php echo  $base?>index.php/dnsapi/Monitor_Modify?monitorId="+_address+"&port=80&monitorInterval=180&host="+_domain+"&monitorType=http&monitorPath=/&points=ctc,cuc,cmc&bakIp=auto&smsNotice=me,share&emailNotice=me,share&lessNotice=yes",{},function(data){
					if(data = 1){
						alert("修改成功");
						location.reload();
					}else{
						alert("修改失败");
					}
				},"json");
			});
		});
	</script>
	<script>
$(document).ready(function(){
	function getThing(){
		$.post($("#baseUrl").attr('value')+'index.php/check/NodeIP',
			function(data){
			var result = jQuery.parseJSON(data);
			$("#ipvalue").html('');
			for(i=0;i < result.length;i++){
				//$("#NodeIP").append(result[i]['NodeIP']);
				$("#ipvalue").append('<option value="'+result[i]['NodeIP']+'">'+result[i]['NodeIP']+'</option>');
			}
		});
	}getThing();
});
	</script>
  </body>
</html>