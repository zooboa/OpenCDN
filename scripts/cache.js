$(document).ready(function(){
	queryLocation();

	$("#cache_add").click(function(){
		insertLocation();
	});

	$("#all_cache").click(function () {
		if(!$("#all_cache").attr('checked')) {
			$("#all_cache_out").removeAttr("checked");
		}
		cacheAll();
	});
	
	$("#all_cache_out").click(function () {
		cacheAll();
	});
	
	$("#normal_cache").click(function () {
		cacheChange();
	});
	$("#index_cache").click(function () {
		cacheChange();
	});
	$("#htm_cache").click(function () {
		cacheChange();
	});
	$("#all_re").click(function () {
		if(!$("#all_cache").attr('checked')) {
			$("#normal_cache").removeAttr("checked");
			$("#index_cache").removeAttr("checked");
			$("#htm_cache").removeAttr("checked");
		}
		cacheChange();
	});
	
});

function queryLocation() {

	$.post(basePath+'index.php/cache/query',
		{domain_id:$("#domain_id").val()},
		function(data){
			var listObj = $("#cache_list");
			listObj.empty();
			for(i=0;i<data.length;i++) {
				showHtml = "<tr class='cache_home'>";
				showHtml += '<td><li class="tableli">'+data[i].memo+'</li></td>';
				showHtml += '<td><li class="tableli">'+data[i].tips+'</li></td>';
				if ('Y'==data[i].enable) {
					showHtml += '<td><li class="tableli li2">缓存</li></td>';
				} else {
					showHtml += '<td>不缓存</td>';
				}
				showHtml += "<td><a href=\"javascript:removeLocation("+data[i].locf_id+",'"+data[i].memo+"');\">删除</a></td></tr>";
				//showHtml += "<td><a href=\"javascript:alert('ssss');\">删除</a></td></tr>";
				listObj.append(showHtml);
			}
		},
	'json');
}

function insertLocation() {

	var domainid = $("#domain_id").val();
	if (domainid=="") {
		alert("域名编号不可以为空");
		return;
	}
	
	var proxy_cache = $("#proxy_cache").val();
	if (proxy_cache=="") {
		alert("请选择匹配方式");
		return;
	}
	
	var cacahe_select = $("#cacahe_select").val();
	if (cacahe_select=="") {
		alert("请输入匹配方式对应的值");
		return;
	}
	
	var tell_cache = $("#tell_cache").val();
	if (tell_cache=="") {
		alert("请选择缓存方式");
		return;
	}
	
	var cache_time = $("#cache_time").val();
	if (tell_cache=="Y" && cache_time=="") {
		alert("缓存时间不可为空");
		return;
	}
	if (tell_cache=="N") {
		cache_time="0";
	}
		
	var args = {
		domain_id:domainid,
		proxy_cache:proxy_cache,
		cacahe_select:cacahe_select,
		tell_cache:tell_cache,
		cache_time:cache_time
	}

	checkreset(0);
		
	$.post(basePath+'index.php/cache/append', args,
		function(data){
			if (data.result=='0') {
				alert(data.error);
			} else {
				queryLocation();
				resetform();
			}
		},
	'json');
}

function removeLocation(locf_id,type) {
	if(confirm("确认删除 “"+type+"” 缓存资源类型吗？")) {
		if (""==locf_id) {
			alert('编号不可为空');
			return;
		}
		$.post(basePath+'index.php/cache/delect',
			{locf_id:locf_id,domain_name:$("#domain_name").val()},
			function(data){
				if (data.result=='1') {
					queryLocation();
					checkreset(0);
				}
			},
		'json');
	}
}

function cacheAll() {

	var allcache = "0";
	var allcacheout = "0";
	
	if($("#all_cache_out").attr('checked')) {
		allcacheout = "1";
		allcache = "1";
		$("#all_cache").attr('checked',true);
	} else {
		allcacheout="0";
	}
	
	if($("#all_cache").attr('checked')) {
		allcache="1";
	} else {
		allcache = "0";
		allcacheout = "0";
		$("#all_cache_out").removeAttr("checked");
	}
	//alert("allcache="+allcache+"   allcacheout="+allcacheout);
	var args = {
		allcache:allcache,
		allcacheout:allcacheout,
		domain_id:$("#domain_id").val()
	}
	$.post(basePath+'index.php/cache/cacheAll',args,
		function(data){
			if (data.result=='1') {
				queryLocation();
				checkreset(2);
			}
		},
	'json');
}

function cacheChange() {

	var all_re = "0";
	var normal_cache = "0";
	var index_cache = "0";
	var htm_cache = "0";
	
	if($("#normal_cache").attr('checked')) {
		normal_cache="1";
		all_re = "1";
		$("#all_re").attr('checked',true);
	} else {
		normal_cache = "0";
	}
	
	if($("#index_cache").attr('checked')) {
		index_cache="1";
		all_re = "1";
		$("#all_re").attr('checked',true);
	} else {
		index_cache = "0";
	}
	
	if($("#htm_cache").attr('checked')) {
		htm_cache="1";
		all_re = "1";
		$("#all_re").attr('checked',true);
	} else {
		htm_cache = "0";
	}
	
	if($("#all_re").attr('checked')) {
		all_re="1";
	} else {
		all_re = "0";
		normal_cache = "0";
		$("#normal_cache").removeAttr("checked");
		index_cache = "0";
		$("#index_cache").removeAttr("checked");
		htm_cache = "0";
		$("#htm_cache").removeAttr("checked");
	}
	//alert("all_re="+all_re+"   normal_cache="+normal_cache+"   index_cache="+index_cache+"   htm_cache="+htm_cache);
	var args = {
		all_re:all_re,
		htm_cache:htm_cache,
		index_cache:index_cache,
		normal_cache:normal_cache,
		domain_id:$("#domain_id").val()
	}
	$.post(basePath+'index.php/cache/change',args,
		function(data){
			if (data.result=='1') {
				queryLocation();
				checkreset(1);
			}
		},
	'json');
}

function checkreset(type) {
	if(0==type||1==type) {
		$("#all_cache").removeAttr("checked");
		$("#all_cache_out").removeAttr("checked");
	}
	if(0==type||2==type) {
		$("#normal_cache").removeAttr("checked");
		$("#index_cache").removeAttr("checked");
		$("#htm_cache").removeAttr("checked");
		$("#all_re").removeAttr("checked");
	}
}
function resetform() {
	$('#proxy_cache').val('');
	$('#cacahe_select').val('');
	$('#cache_time').val('');
	$('#tell_cache').val('');
}