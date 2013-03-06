$(document).ready(function(){
	query_domain();
	
	$("#domain_name").keydown(function (event) {
		if (13==event.keyCode) {
			append_domain();
		}
	});
	$("#domain_append").click(function () {
		append_domain();
	});
});

function query_domain() {

	$.post(basePath+'index.php/domain_user/query',{},
		function(data){
			var listObj = $("#domain_list");
			listObj.empty();
			
			
			var head_column="<div class='row-fluid list-header'>";
			head_column+="<div class='span3'>域名</div>";
			head_column+="<div class='span2'>源站IP</div>";
			head_column+="<div class='span2'>CNAME</div>";
			head_column+="<div class='span2'>状态</div>";
			head_column+="<div class='span3'>操作</div></div>";
			listObj.append(head_column);
			
			if (0==data.length) {
				listObj.append("<div class='row-fluid show-grid' style='color:red;text-align:center;'>还未加入域名</div>");
				return; 
			}
			
			for(i=0;i<data.length;i++) {
				var list_data="<div class='row-fluid show-grid click-change'>";
				list_data+="<div class='span3'>"+data[i].domain_name+"</div>";
				list_data+="<div class='span2'>"+data[i].domain_ip+"</div>";
				list_data+="<div class='span2'>"+data[i].CNAME+"</div>";
				if (1 == data[i].speed) {
					list_data+="<div class='span2'>加速中</div>";
				} else {
					list_data+="<div class='span2'style='color:grey;'>未加速</div>";
				}
				list_data+="<div class='span3'>";
			//报表功能暂未实现
			//	list_data+="<a href='javascript:;' role='button' class='btn btn-primary' >报表</a> ";
				list_data+="<a href='"+basePath+"index.php/cache/index/"+data[i].id+"' role='button' class='btn btn-primary' >设置</a> ";
				list_data+="<a href='javascript:remove_domain("+data[i].id+",\""+data[i].domain_name+"\");' role='button' class='btn btn-primary' >删除</a> ";
				if (0 == data[i].remove_url){
				list_data+="<a href='javascript:remove_url("+data[i].id+",\""+data[i].domain_name+"\");' role='button' id="+data[i].id+" class='btn btn-primary' >一键清除缓存</a> ";
				}else if(1 == data[i].remove_url){
				list_data+="<span role='button' class='btn btn-primary' >清除中</span> ";	
				}else{
					list_data+="<a href='javascript:remove_url("+data[i].id+",\""+data[i].domain_name+"\");' role='button' id="+data[i].id+" class='btn btn-primary' >暂无缓存</a> ";
				}

				list_data+="</div></div>";
				listObj.append(list_data);
			}
		},
	'json');
}
query_domain();
setInterval(function(){query_domain();},5000);
//	query_domain();
//setInterval(function(){query_domain();},5000);
function append_domain() {

	var domain_name = $("#domain_name").val();
	if (domain_name=="") {
		alert("域名不可以为空");
		return;
	}
	$.post(basePath+'index.php/domain_user/append', 
		{domain_name:domain_name},
		function(data){
			if (data.result == 0) {
				alert(data.error);
			} else {
				alert(data.error);
				query_domain();
				reset_from();
			}
		},
	'json');

		
	
}

function remove_domain(domain_id,domainName) {
	if(confirm("确认删除（"+domainName+"）吗？")) {
		if (""==domain_id) {
			alert('域名编号不可为空');
			return;
		}
		$.post(basePath+'index.php/domain_user/delete',
			{domain_id:domain_id},
			function(data){
				if (data.result == 0) {
					alert(data.error);
				} else {
					query_domain();
				}
			},
		'json');
	}
}
function remove_url(domain_id,domainName){
		$("#"+domain_id).text('');
		$("#"+domain_id).append("清除中");
		$.get(basePath+'index.php/remove_user',{domainName:domainName});
		/*$.post(basePath+'index.php/domain/remove_url',
			{domainName:domainName},
			function(data){
				if (data.result == 0) {
					alert(data.error);
					$("#"+domain_id).text('');
					$("#"+domain_id).append("一键清除缓存");
				} else if(data.result == 1){
					alert(data.error);
					$("#"+domain_id).text('');
					$("#"+domain_id).append("一键清除缓存");
				}else{
					alert("清除失败");
					$("#"+domain_id).text('');
					$("#"+domain_id).append("一键清除缓存");
				}
			},
		'json');*/
}
function reset_from() {
	$("#domain_id").val("");
	$("#domain_name").val("");
	$("#node_ip").val("");
	$("#recordLine").val("");
}
