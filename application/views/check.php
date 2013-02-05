<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>Open CDN 节点信息</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo $base;?>css/global.css" type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo $base;?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen">
	<script src="<?php echo $base?>scripts/jquery-1.8.0.min.js"></script>
	<script src="<?php echo $base;?>scripts/check.js"></script>
    <script src="<?php echo $base?>bootstrap/js/bootstrap.min.js"></script>
</head>
  <body>
	<div>
		<div class=".container">
			<div class="navbar">
				<div class="navbar-inner">
				<a class="brand" href="#">OpenCDN</a>
					<ul class="nav">
					  <li class="active"><a href="<?php echo $base;?>index.php/node">CDN节点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/domain">站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/dnspod">DNSPod站点管理</a></li>
					  <li><a href="<?php echo $base;?>index.php/revise">修改密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/dns_set">修改DNSPod密码</a></li>
					  <li><a href="<?php echo $base;?>index.php/out">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<!-- Manage Index -->
	<div class="tabbable"style="margin-left:100px;">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#server" data-toggle="tab">状态概览</a></li>
			<li class=""><a href="#network"  data-toggle="tab">网络信息</a></li>
			<li class=""><a href="#system"  data-toggle="tab">系统信息</a></li>
			<!--<li class=""><a href="#hardware"  data-toggle="tab">硬件信息</a></li>-->
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="server">
				<table class="table" style="width:600px">
					<thead>
						<tr>
							<th colspan="2">状态概览</th>
							<th colspan="1">

							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width:100px"id="NodeIP"><?php echo $logsResult[0]['NodeIP']?></td>
							<td style="width:60px;"id="Status"></td>
							<!--<td style="width:100px">
								<div>
									<div class="btn-group" >					
										<button class="btn btn-small active"  data-toggle="button" title="自动启动">						
											<i class="icon-check"></i>					
										</button>					
										<button class="btn btn-small"  title="启动"  style="display: none; ">		
											<i class="icon-play"></i>					
										</button>					
										<button class="btn btn-small"  title="停止" >			
											<i class="icon-stop"></i>				
										</button>											
									</div>				
								</div>
							</td>-->
						</tr>
						<tr>
							<td>内存使用:</td>
							<td><span  id="Mem_used"class="label label-success"><?php echo $logsResult[0]['Mem_used']?></span></td>
						</tr>
						<tr>
							<td style="width:200px;">CPU使用率如下</td>
							<td></td>
							<tr>
								<td>已使用：</td>
								<td><span  id="cpu"class="label label-success"><?php echo $logsResult[0]['cpu']?></span></td>
							</tr>
							<tr>
								<td>剩余使用：</td>
								<td><span  id="cpu_free"class="label label-success"><?php echo $logsResult[0]['cpu_free']?></span></td>
							</tr>
						</tr>
						<tr>
							<td>交换空间：</td>
							<td></td>
							<tr>
								<td>总大小：</td>
								<td><span  id="Swap_total"class="label label-success"><?php echo $logsResult[0]['Swap_total']?></span></td>
							</tr>
							<tr>
								<td>已使用：</td>
								<td><span  id="Swap_used"class="label label-success"><?php echo $logsResult[0]['Swap_used']?></span></td>
							</tr>
							<tr>
								<td>剩余使用：</td>
								<td><span  id="Swap_free"class="label label-success"><?php echo $logsResult[0]['Swap_free']?></span></td>
							</tr>
						</tr>
						<tr>
							<th>存储空间：</th>
							<th class="td-right"style="width:100px;">挂载点</th>
							<th class="td-right"style="width:100px;">总大小</th>
							<th class="td-right"style="width:100px;">已使用</th>
							<th class="td-right"style="width:200px;">剩余可用</th>
							<th class="td-right"style="width:100px;">使用率</th>
						</tr>
						<tr>
							<th></th>
							<th class="td-right"style="width:100px;">/</th>
							<th class="td-right"style="width:100px;"><span  id="Disk_total"class="label label-success"><?php echo $logsResult[0]['Disk_total']?></span></th>
							<th class="td-right"style="width:100px;"><span  id="Disk_used"class="label label-success"><?php echo $logsResult[0]['Disk_used']?></span></th>
							<th class="td-right"style="width:200px;"><span  id="Disk_free"class="label label-success"><?php echo $logsResult[0]['Disk_free']?></span></th>
							<th class="td-right"style="width:100px;"><span  id="Disk_per"class="label label-success"><?php echo $logsResult[0]['Disk_per']?></span></th>
						</tr>
						<tr>
							<th>缓存空间：</th>
							<th class="td-right"style="width:100px;">挂载点</th>
							<th class="td-right"style="width:100px;">总大小</th>
							<th class="td-right"style="width:100px;">已使用</th>
							<th class="td-right"style="width:100px;">剩余可用</th>
							<th class="td-right"style="width:100px;">使用率</th>
						</tr>
						<tr>
							<th></th>
							<th class="td-right"style="width:100px;">/home/cache</th>
							<th class="td-right"style="width:100px;"><span  id="Mem_total"class="label label-success"><?php echo $logsResult[0]['Mem_total']?></span></th>
							<th class="td-right"style="width:100px;"><span  id="Mem_used"class="label label-success"><?php echo $logsResult[0]['Mem_used']?></span></th>
							<th class="td-right"style="width:200px;"><span  id="Mem_free"class="label label-success"><?php echo $logsResult[0]['Mem_free']?></span></th>
							<th class="td-right"style="width:100px;"><span  id="Mem_per"class="label label-success"><?php echo $logsResult[0]['Mem_per']?></span></th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="tab-pane"  id="network">
				<table class="table" style="width:600px">
					<thead>
						<tr>
							<th colspan="2">网络信息</th>
						</tr>
					</thead>
					<tbody>
						<tr class="ng-scope">
							<td class="ng-binding">网络接口1：</td>
							<td>
								<table class="table table-condensed table-borderless table-layout" style="width:400px">
									<tbody>
										<tr>
											<td>状态：</td>
											<td><span class="label label-success"id="eth0"><?php echo $logsResult[0]['eth0'];?></span></td>
										</tr>
										<tr>
											<td>IP:</td>
											<td id="IP0"><?php if($logsResult[0]['IP0'] == null){echo "暂无";}else{echo $logsResult[0]['IP0'];}?></td>
										</tr>
										<tr>
											<td>子网掩码:</td>
											<td id="Netmask0"></td>
										</tr>
										<tr>
											<td>流量信息：</td>
											<td>
												<div class="well" style="width:260px;padding:3px 10px;margin-top:3px;">
													<table class="table table-condensed table-borderless table-layout" style="width:240px;">
														<tbody><tr>
															<th style="width:40px"></th>
															<th class="td-right" style="width:200px">累计流量</th>
															<th class="td-right" style="width:200px">实时速率</th>
														</tr>
														<tr>
															<td style="width:200px">发送：</td>
															<td class="td-right"style="width:500px;"id="send_all_rate0"><?php if($logsResult[0]['send_all_rate0'] == null){echo "暂无";}else{echo $logsResult[0]['send_all_rate0'];}?></td>
															<td class="td-right"style="width:500px;"id="send_rate0"><?php if($logsResult[0]['send_rate0'] == null){echo "暂无";}else{echo $logsResult[0]['send_rate0'];}?></td>
														</tr>
														<tr>
															<td style="width:200px">接收：</td>
															<td class="td-right"style="width:500px;"id="recv_all_rate0"><?php if($logsResult[0]['recv_all_rate0'] == null){echo "暂无";}else{echo $logsResult[0]['recv_all_rate0'];}?></td>
															<td class="td-right"style="width:500px;"id="recv_rate0"><?php if($logsResult[0]['recv_rate0'] == null){echo "暂无";}else{echo $logsResult[0]['recv_rate0'];}?></td>
														</tr>
													</tbody></table>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr class="ng-scope">
							<td class="ng-binding">网络接口2：</td>
							<td>
								<table class="table table-condensed table-borderless table-layout" style="width:400px">
									<tbody>
										<tr>
											<td>状态：</td>
											<td><span class="label label-success"id="eth1"><?php echo $logsResult[0]['eth1']?></span></td>
										</tr>
										<tr>
											<td>IP:</td>
											<td id="IP1"><?php if($logsResult[0]['IP1'] == null){echo "暂无";}else{echo $logsResult[0]['IP1'];}?></td>
										</tr>
										<tr>
											<td>子网掩码:</td>
											<td id="Netmask1"></td>
										</tr>
										<tr>
											<td>流量信息：</td>
											<td>
												<div class="well" style="width:260px;padding:3px 10px;margin-top:3px;">
													<table class="table table-condensed table-borderless table-layout" style="width:240px;">
														<tbody><tr>
															<th style="width:40px"></th>
															<th class="td-right" style="width:200px">累计流量</th>
															<th class="td-right" style="width:200px">实时速率</th>
														</tr>
														<tr>
															<td style="width:200px">发送：</td>
															<td class="td-right"style="width:500px;"id="send_all_rate1"><?php if($logsResult[0]['send_all_rate1'] == null){echo "暂无";}else{echo $logsResult[0]['send_all_rate1'];}?></td>
															<td class="td-right"style="width:500px;"id="send_rate1"><?php if($logsResult[0]['send_rate1'] == null){echo "暂无";}else{echo $logsResult[0]['send_rate1'];}?></td>
														</tr>
														<tr>
															<td style="width:200px">接收：</td>
															<td class="td-right"style="width:500px;"id="recv_all_rate1"><?php if($logsResult[0]['recv_all_rate1'] == null){echo "暂无";}else{echo $logsResult[0]['recv_all_rate1'];}?></td>
															<td class="td-right"style="width:500px;"id="recv_rate1"><?php if($logsResult[0]['recv_rate1'] == null){echo "暂无";}else{echo $logsResult[0]['recv_rate1'];}?></td>
														</tr>
													</tbody></table>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<div class="tab-pane"  id="system">
			<table class="table" style="width:600px">
						<thead>
							<tr>
								<th colspan="2">系统信息</th>
							</tr>
							<tbody>
								<tr>
									<td style="width:100px;">虚拟平台：</td>
									<td><?php echo $logsResult[0]['Kernel_release']?></td>
								</tr>
								<tr>
									<td style="width:100px;">CPU版本：</td>
									<td><?php echo $logsResult[0]['Frequency']?></td>
								</tr>
								<tr>
									<td style="width:100px;">系统类型：</td>
									<td><?php echo $logsResult[0]['System_release']?></td>
								</tr>
							</tbody>
						</thead>
			</table>
		</div>
		<!--<div class="tab-pane"  id="hardware">
			<table class="table" style="width:600px">
						<thead>
							<tr>
								<th colspan="2">硬件信息</th>
							</tr>
							<tbody>
								<tr>
									<td style="width:100px;">CPU个数：</td>
									<td>dfd</td>
								</tr>
								<tr>
									<td style="width:100px;">CPU核心：</td>
									<td>dfd</td>
								</tr>
								<tr>
									<td style="width:100px;">内存大小：</td>
									<td>dfd</td>
								</tr>
							</tbody>
						</thead>
			</table>
		</div>-->
		</div>
	</div>
	
	<div id="footer relative">
		<div class="form-actions" style="margin-bottom:0px;">
			<div class="pull-right">
				Powered by <a href="http://www.OpenCdn.org/" target="_blank">OpenCdn & HDUISA</a>
			</div>
		</div>
	</div>
	<!-- Fix:Please Uncomment this line when release
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	-->
	<input type="hidden" id="baseUrl" value="<?php echo $base;?>" />
	<input type="hidden" id="check_ip" value="<?php echo $logsResult[0]['NodeIP'];?>" />
  </body>
</html> 