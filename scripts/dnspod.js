$(document).ready(function(){
	query_domain();
	
	$("#dnspod_domain").keydown(function (event) {
		if (13==event.keyCode) {
			append_domain();
		}
	});
	$("#buttonAppendDomain").click(function () {
		append_domain();
	});
	
});

function query_domain() {
	$.post(basePath+"index.php/dnspod/query_dnspod_domain",
		{},
		function (odata){
			if ("0"==odata.code) {
				alert(odata.message);
				return ;
			}
			var list = $("#dnspod_domain_list");
			list.empty();
			list.append("<div class='row-fluid list-header'><div class='span5'>域名</div> <div class='span4'>状态</div><div class='span2'>操作</div></div>");
						
			var length = odata.length;
			if (length==0) {
				list.append("<div class='row-fluid show-grid click-change'><div class='span13' style='color:red;'>DNSPod 未加入域名</div></div>");
				return ;
			}
			
			for (i=0;i<length;i++) {
				var data_column="<div class='row-fluid show-grid click-change'>";
				data_column+="<div class='span5'>"+odata[i].domain_name+"</div>";
				if (1==odata[i].status) {
					data_column+="<div class='span4' title='已生效，DNS记录解析已生效'>已生效</div>";
					data_column+="<div class='span3'><a href='"+basePath+"index.php/subdomain/index/"+odata[i].domain_id+"' role='button' class='btn btn-primary' >记录</a>&nbsp;";
					data_column+="<a href='javascript:remove_domain("+odata[i].domain_id+",\""+odata[i].domain_name+"\");' role='button' class='btn btn-primary' >删除</a></div></div>";
				} else {
					data_column+="<div class='span4' title='未生效，DNS记录解析未生效'>未生效</div>";
					data_column+="<div class='span3'><a href='javascript:;' role='button' class='btn' disabled='false' >记录</a>&nbsp;";
					data_column+="<a href='javascript:remove_domain("+odata[i].domain_id+",\""+odata[i].domain_name+"\");' role='button' class='btn btn-primary' >删除</a></div></div>";
				}				
				
				list.append(data_column);
			}
		},
	"json");
}
setInterval(function(){query_domain();},5000);
function append_domain() {

	var dnspod_domain = $("#dnspod_domain").val();
	if (''==dnspod_domain.trim()) {
		alert("域名不可为空");
		return ;
	}

	$.post(basePath+"index.php/dnspod/append_dnspod_domain",
		{dnspod_domain:dnspod_domain},
		function (odata){
			if ("0"==odata.code) {
				alert(odata.message);
			} else {
				query_domain();
				$("#dnspod_domain").val("");
			}
		},
	"json");
}

function remove_domain(dnspod_domainid,dnspod_domain) {
	if(confirm("删除域名（"+dnspod_domain+"）同时会将该域名下所有记录删除，确定要删除吗?")) {
		if (''==dnspod_domainid) {
			alert("域名不可为空");
			return ;
		}
		$.post(basePath+"index.php/dnspod/remove_dnspod_domain",
			{dnspod_domainid:dnspod_domainid},
			function (odata){
				if ("0"==odata.code) {
					alert(odata.message);
				} else {
					query_domain();
				}
			},
		"json");
	}
}