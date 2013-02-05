$(document).ready(function(){
	$("#saveChanges").click(function(){
		monitor_get_para();
		$("#Modal_Monitor").modal("toggle");
	});
});

function	start_modify_monitor(record_id,host,monitor_interval,bak_ip,monitor_id){
	var domain_id = $("#dnspod_domainId").val();
	if (''==domain_id.trim()) {
		alert("域名编号不可为空");
		return ;
	}
	
	var dnspod_domain = $("#dnspod_domain").val();
	if(''==dnspod_domain.trim()){
		alert("域名不能为空");
		return;
	}
	
	if (''==record_id.trim()){
		alert("记录编号不可为空");
		return;
	}
	
	if(''==host.trim()){
		alert("host头不能为空");
		return;
	}
	
	if ( null==monitor_interval){
		monitor_interval = monitor_interval == null?180:monitor_interval;
		bak_ip = bak_ip==null?'auto':bak_ip;
		$.post(basePath+"index.php/subdomain/start_modify_monitor",{dnspod_domain:dnspod_domain,domain_id:domain_id,record_id:record_id,monitor_interval:monitor_interval,bak_ip:bak_ip,host:host},function(Rdata){
		
				/*
				$("#"+record_id).attr("class","icon-pause");
				$("#"+record_id).attr("href","javascript:remove_dnspod_monitor(\""+record_id+"\",\""+Rdata.monitor_id+"\",\""+host+"\")");	
				*/
			
				
				if(Rdata.message=="监控已经存在"){
					$.post(basePath+"index.php/subdomain/get_monitor_list_latestone",{record_id:record_id},function(Tdata){
						alert(Tdata.message);
					},"json");
				}else{
					alert(Rdata.message);
				}
				
				query_record();
				reset_from();
			
		},"json");
	}else{
		$.post(basePath+"index.php/subdomain/start_modify_monitor",{dnspod_domain:dnspod_domain,domain_id:domain_id,record_id:record_id,monitor_interval:monitor_interval,bak_ip:bak_ip,host:host,monitor_id:monitor_id},function(Rdata){
			alert(Rdata.message);
			
				/*
				$("#"+record_id).attr("class","icon-pause");
				$("#"+record_id).attr("href","javascript:remove_dnspod_monitor(\""+record_id+"\",\""+Rdata.monitor_id+"\",\""+host+"\")");	
				*/
				query_record();
				
		},"json");
	}
}

function	remove_dnspod_monitor(record_id,monitor_id,host){

		if (''==record_id.trim()){
			alert("记录编号不可为空");
			return;
		}
	
		if(''==monitor_id.trim()){
			alert("监控ID不能为空");
			return;
		}
		
		if(''==host.trim()){
		alert("host头不能为空");
		return;
		}
		
		$.post(basePath+"index.php/subdomain/remove_dnspod_monitor",{record_id:record_id,monitor_id:monitor_id},function(Rdata){
			alert(Rdata.message);
			if(Rdata.d_status ==0){
				/*
				$("#"+record_id).attr("class","icon-play");
				$("#"+record_id).attr("href","javascript:start_modify_monitor(\""+record_id+"\",\""+host+"\")");
				*/
				query_record();
			}
		},"json");
		
		
}

function monitor_set_can(record_id,monitor_id,host){
	$("#monitor_id_can").val(monitor_id);
	$("#host_can").val(host);
	$("#record_id_can").val(record_id);
	$("#Modal_Monitor").modal('toggle');
}

function monitor_get_para(){
	var monitor_interval =  $("#monitor_interval").val();
	var bak_ip = $("#back_ip_list").attr("mark")==1?$("#back_ip_list").val():$("#bak_ip").val();
	var host = $("#host_can").val();
	var monitor_id = $("#monitor_id_can").val();
	var record_id = $("#record_id_can").val();
	start_modify_monitor(record_id,host,monitor_interval,bak_ip,monitor_id);
}

function reset_power_icon(){
		$(".icon-play").tooltip({
					placement:'right',
					title:'点击开启D监控',
				});	
		$(".icon-pause").tooltip({
			placement:'right',
			title:'点击关闭D监控',
			});	
			
		$(".icon-wrench").tooltip({
			placement:'right',
			title:'配置D监控',
		});
		
		$(".icon-info-sign").tooltip({
			placement:'right',
			title:'未开启D监控',
		});
}

function check_bak_ip(){
	var bak_ip = $("#bak_ip").val()
	if(bak_ip =="back_ip"){
		$("#back_ip_list").show();
		$("#back_ip_list").attr("mark","1");
	}else{
		$("#back_ip_list").hide();
		$("#back_ip_list").attr("mark","0");
	}
}