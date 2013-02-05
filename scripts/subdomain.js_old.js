$(document).ready(function(){
	query_record();
	
	$("#button_edit_record").click(function () {
		append_modify_record();
	});
	
	$("#back_ip_list").hide();
});

function query_record() {
	$.post(basePath+"index.php/subdomain/query_dnspod_subdomain",
		{dnspod_domainId:$("#dnspod_domainId").val()},
		function (odata){
			if ("0" == odata.code){
				alert(odata.message);
				return ;
			}
			
			var list = $("#subdomain_list");
			list.empty();
			
			var head_column="<div class='row-fluid list-header'>";
			head_column+="<div class='span1'>域名</div>";
			head_column+="<div class='span2'>源站IP</div>";
			head_column+="<div class='span2'>节点IP</div>";
			head_column+="<div class='span1'>线路</div>";
			head_column+="<div class='span2'>宕机备用</div>";
			head_column+="<div class='span1'>监控间隔</div>";
			head_column+="<div class='span3'>操作</div></div>";
			list.append(head_column);
			
			var length = odata.length;
			if (length==0) {
				list.append("<div class='row-fluid show-grid click-change'><div class='span13' style='color:red;'>DNSPod 未加入A类型的记录</div></div>");
				return ;
			}

			for (i=0;i<length;i++) {
				var data_column="<div class='row-fluid show-grid click-change'>";
				data_column+="<div class='span1'>"+odata[i].sub_domain+"</div>";
				data_column+="<div class='span2'>"+odata[i].domain_ip+"</div>";
				data_column+="<div class='span2'>"+odata[i].node_ip+"</div>";
				data_column+="<div class='span1'>"+odata[i].record_line+"</div>";
				data_column+="<div class='span2'>"+odata[i].bak_ip+"</div>";
				data_column+="<div class='span1'>"+odata[i].monitor_interval+"</div>";

				
				data_column+="<div class='span3'><a role='button' class='btn btn-primary' href='javascript:setting_record";
				data_column+="("+odata[i].record_id+",\""+odata[i].sub_domain+"\",\""+odata[i].node_ip+"\",\""+odata[i].record_line+"\",\""+odata[i].domain_ip+"\");'>编辑</a>&nbsp;";
				
				data_column+="<a role='button' class='btn btn-primary' href='"+basePath+"index.php/cache/index/"+odata[i].id+"'>设置</a>&nbsp;";
				data_column+="<a role='button' class='btn btn-primary' href='javascript:remove_record("+odata[i].record_id+",\""+odata[i].sub_domain+"\");'>删除</a>&nbsp";
				
				//D监控工具栏
				if(odata[i].d_status==0){
					data_column+="<a class='icon-info-sign'></a>&nbsp";
					data_column+="<a class='' id=\""+odata[i].record_id+"\"  href='javascript:start_modify_monitor(\""+odata[i].record_id+"\",\""+odata[i].sub_domain+"\");' ></a></div></div>";
				}else{
					data_column+="<a class='icon-wrench' href='javascript:monitor_set_can(\""+odata[i].record_id+"\",\""+odata[i].monitor_id+"\",\""+odata[i].sub_domain+"\");'></a>&nbsp";
					data_column+="<a class='' id=\""+odata[i].record_id+"\"  href='javascript:remove_dnspod_monitor(\""+odata[i].record_id+"\",\""+odata[i].monitor_id+"\",\""+odata[i].sub_domain+"\");' ></a></div></div>";
				}
				
				
				
				list.append(data_column);
				
				//开关信息设置
				if(odata[i].d_status == 0){
					$('#'+odata[i].record_id).addClass("icon-play");
				}else{
					$('#'+odata[i].record_id).addClass("icon-pause");
				}
			}
				//Bootstrap Tooltip
				reset_power_icon();
				
		},
	"json");
}

function append_modify_record () {
	var domain_name = $("#dnspod_domain").val();
	if (''==domain_name.trim()) {
		alert("域名名称不可为空");
		return ;
	}
	var domain_id = $("#dnspod_domainId").val();
	if (''==domain_id.trim()) {
		alert("域名编号不可为空");
		return ;
	}
	var sub_domain = $("#subDomain").val();
	if (''==sub_domain.trim()) {
		alert("二级不可为空");
		return ;
	}
	var domain_ip = $("#domainIP").val();
	if (''==domain_ip.trim()) {
		alert("源站IP地址不可以为空");
		return ;
	}
	var value = $("#iplist").val();
	if (''==value.trim()) {
		alert("请选择节点IP");
		return ;
	}
	var record_line = $("#recordLine").val();
	if (''==record_line.trim()) {
		alert("线路不可为空");
		return ;
	}
	
	var record_id = $("#dnspodsub_id").val();
	if (""==record_id) {
		$.post(basePath+"index.php/subdomain/append_dnspod_subdomain",
			{domain_id:domain_id,sub_domain:sub_domain,value:value,record_line:record_line,record_type:"A",domain_ip:domain_ip,domain_name:domain_name},
			function (odata){
				if ("0"==odata.code) {
					alert(odata.message);
				} else {
					start_modify_monitor(odata.record_id,odata.host);
				}
			},
		"json");
	} else {
		$.post(basePath+"index.php/subdomain/modify_dnspod_subdomain",
			{domain_id:domain_id,record_id:record_id,sub_domain:sub_domain,value:value,record_line:record_line,record_type:"A",domain_ip:domain_ip},
			function (odata){
				if ("0"==odata.code) {
					alert(odata.message);
				} else {
					query_record();
					reset_from();
				}
			},
		"json");
	}
}

function remove_record(record_id,dnspod_domain) {
	if(confirm("删除后本记录在DNSPod不再有效，确认删除吗？")) {
		var domain_id = $("#dnspod_domainId").val();
		if (''==domain_id) {
			alert("域名编号不可为空");
			return ;
		}
		if (''==record_id) {
			alert("记录编号不可为空");
			return ;
		}
		$.post(basePath+"index.php/subdomain/remove_dnspod_subdomain",
			{domain_id:domain_id,record_id:record_id},
			function (odata){
				if ("0"==odata.code) {
					alert(odata.message);
				} else {
					query_record();
				}
			},
		"json");
	}
}

function setting_record(dnspodsub_id,subdomain,nodeip,line,domain_ip) {
	$("#dnspodsub_id").val(dnspodsub_id);
	$("#subDomain").val(subdomain);
	$("#iplist").val(nodeip);
	$("#recordLine").val(line);
	$("#domainIP").val(domain_ip);
}

function reset_from() {
	$("#dnspodsub_id").val("");
	$("#subDomain").val("");
	$("#iplist").val("");
	$("#recordLine").val("");
	$("#domainIP").val("");
}
