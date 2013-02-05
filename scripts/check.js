$(document).ready(function(){
	/*function getThing(){
		$.post($("#baseUrl").attr('value')+'index.php/check/get_thing',
			function(data){
			var result = jQuery.parseJSON(data);
			$("#Status").html('');
			$("#eth0").html('');
			for(i=0;i < result.length;i++){
				//$("#NodeIP").append(result[i]['NodeIP']);
				if(result[i]['Status'] == 'on'){
				$("#Status").append('<span class="label label-success">运行中</span>');
				}else{
				$("#Status").append('<span class="label label-success">关闭中</span>');
				}
				if(result[i]['eth0'] == 'yes'){
				$("#eth0").append('<span class="label label-success">运行中</span>');
				}else{
				$("#eth0").append('<span class="label label-success">关闭中</span>');
				}
				if(result[i]['eth1'] == 'yes'){
				$("#eth1").append('<span class="label label-success">运行中</span>');
				}else{
				$("#eth1").append('<span class="label label-success">关闭中</span>');
				}
			}
		});
	}
	getThing();*/
	setInterval(function(){
	var cache = $("#check_ip").attr('value');
		$.post($("#baseUrl").attr('value')+'index.php/check/get_thing',{name:cache},
			function(data){
			var result = jQuery.parseJSON(data);
			$("#NodeIP").html('');
			$("#Status").html('');
			$("#CPU_cores").html('');
			$("#cpu").html('');
			$("#Mem_used").html('');
			$("#cpu_free").html('');
			$("#Swap_total").html('');
			$("#Swap_used").html('');
			$("#Swap_free").html('');
			$("#Disk_used").html('');
			$("#Disk_free").html('');
			$("#Disk_per").html('');
			$("#Disk_total").html('');
			$("#Mem_total").html('');
			$("#Mem_per").html('');
			//$("#Mem_used").html('');
			$("#Mem_free").html('');
			$("#IP1").html('');
			$("#IP0").html('');
			$("#Netmask1").html('');
			$("#send_all_rate0").html('');
			$("#recv_all_rate0").html('');
			$("#send_rate0").html('');
			$("#recv_rate0").html('');
			$("#send_all_rate1").html('');
			$("#recv_all_rate1").html('');
			$("#send_rate1").html('');
			$("#recv_rate1").html('');
			$("#Netmask0").html('');
			for(i=0;i < result.length;i++){
				$("#NodeIP").append(result[i]['NodeIP']);
				$("#Mem_used").append(result[i]['Mem_used']);
				$("#CPU_cores").append(result[i]['CPU_cores']);
				$("#cpu_free").append(result[i]['cpu_free']);
				$("#Swap_total").append(result[i]['Swap_total']);
				$("#Swap_used").append(result[i]['Swap_used']);
				$("#Swap_free").append(result[i]['Swap_free']);
				$("#Disk_used").append(result[i]['Disk_used']);
				$("#Disk_free").append(result[i]['Disk_free']);
				$("#Disk_per").append(result[i]['Disk_per']);
				$("#Disk_total").append(result[i]['Disk_total']);
				$("#Mem_total").append(result[i]['Mem_total']);
				$("#Mem_per").append(result[i]['Mem_per']);
				//$("#Mem_used").append(result[i]['Mem_used']);
				$("#Mem_free").append(result[i]['Mem_free']);
				$("#send_rate0").append(result[i]['send_rate0']);
				$("#recv_rate0").append(result[i]['recv_rate0']);
				$("#send_all_rate0").append(result[i]['send_all_rate0']);
				$("#recv_all_rate0").append(result[i]['recv_all_rate0']);
				$("#send_rate1").append(result[i]['send_rate1']);
				$("#recv_rate1").append(result[i]['recv_rate1']);
				$("#send_all_rate1").append(result[i]['send_all_rate1']);
				$("#recv_all_rate1").append(result[i]['recv_all_rate1']);
				$("#IP0").append(result[i]['IP0']);
				$("#IP1").append(result[i]['IP1']);
				$("#Netmask1").append(result[i]['Netmask1']);
				$("#Netmask0").append(result[i]['Netmask0']);
				$("#cpu").append(result[i]['cpu']);
				if(result[i]['Status'] == 'on'){
				$("#Status").append('<span class="label label-success">运行中</span>');
				}else{
				$("#Status").append('<span class="label label-success">关闭中</span>');
				}
				if(result[i]['eth0'] != 'yes'){
					$("#send_all_rate0").append("暂无");
					$("#send_rate0").append("暂无");
					$("#IP0").append("暂无");
					$("#Netmask0").append("暂无");
					$("#recv_all_rate0").append("暂无");
					$("#recv_rate0").append("暂无");
				}
				if(result[i]['eth1'] != 'yes'){
					$("#send_all_rate1").append("暂无");
					$("#send_rate1").append("暂无");
					$("#IP1").append("暂无");
					$("#Netmask1").append("暂无");
					$("#recv_all_rate1").append("暂无");
					$("#recv_rate1").append("暂无");
				}
			}
		});
	},1000);
	//setTimeout(getBoard();,1000);
});
