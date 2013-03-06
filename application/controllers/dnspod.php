<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class DnsPod extends CI_Controller {
	
	public function index() {
		session_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
	
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$users = $this->db->query("select dnspod_user,dnspod_pass from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() == 0) {
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}

		if (null==$users[0]['dnspod_user']||""==$users[0]['dnspod_user']||
			null==$users[0]['dnspod_pass']||""==$users[0]['dnspod_pass']) {
			//echo "未设置dnspod用户";
			$this->load->view('dns_set', $data);
		} else {
			$this->load->model("Dnsapi_model","dnspodapi");
			$this->dnspodapi->set_Session($users[0]['dnspod_user'], $users[0]['dnspod_pass']);
			$this->load->view('dnspod', $data);
		}
	}
	
	/*function setting_dnspod_user () {
	
		session_start();
	
		$this->load->library("session");
		$this->load->helper("url");
		$this->load->helper("security");
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$dnspod_user = $_POST["dnspod_user"];
		//$dnspod_user = "zcoson@qq.com";
		if(""==trim($dnspod_user)){
			$odata["code"] = 0;
			$odata["message"] = "DNSPod帐号不可以为空";
			echo json_encode($odata);
			exit;
		}
		
		$dnspod_pass = $_POST["dnspod_pass"];
		//$dnspod_pass = "dmicsdnspod";
		if(""==trim($dnspod_pass)){
			$odata["code"] = 0;
			$odata["message"] = "DNSPod密码不可以为空";
			echo json_encode($odata);
			exit;
		}

		$ch = @curl_init();
		if (!$ch) {
			$odata["code"] = 0;
			$odata["message"] = "服务器不支持CURL";
			echo json_encode($odata);
			exit;
		}

		$this->load->model("Dnsapi_model","dnspodapi");
		$this->dnspodapi->set_Session($dnspod_user, $dnspod_pass);
		$response = $this->dnspodapi->api_call("User.Detail", array());		
		if (!$response || 1!=$response["status"]["code"]) {
			$odata["code"] = 0;
			$odata["message"] = "DNSPod用户名或密码错误";
			echo json_encode($odata);
			exit;
		}
		
		$this->load->database();
		$this->db->query("update users set dnspod_user='".$dnspod_user."',dnspod_pass='".$dnspod_pass."' where user_id=1");
		if($this->db->affected_rows() == 0) {
			$odata["code"] = 0;
			$odata["message"] = "设置DNSPod帐号失败";
			echo json_encode($odata);
		} else {
			$odata["code"] = 1;
			echo json_encode($odata);
		}
	}*/
	
	function query_dnspod_domain() {
		session_start();
	
		$this->load->library("session");
		$this->load->helper("url");
		$this->load->helper("security");
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');	
		$this->load->model("Dnsapi_model","dnspodapi");
		$response = $this->dnspodapi->api_call("Domain.list", array());
		if (!$response || 1!=$response["status"]["code"]) {
			$odata["code"] = 0;
			$odata["message"] = "取DNSPod域名列表失败,请检查DNSPod帐号是否正确！";
			echo json_encode($odata);
			exit;
		}

		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		foreach ($response['domains'] as $id => $domain) {
			$this->db->query("select 1 from domain where `domain_name`='".$domain['name']."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			if (0==$this->db->affected_rows()) {
				$this->db->query("insert into domain (`record_id`,`domain_id`,`domain_name`,`sub_domain`,parent_id,domain_ip,node_ip,status,category,`record_line`,user_mail) values ('','".$domain['id']."','".$domain['name']."','',0,'','',".($domain['ext_status']==''?1:0).",'D','','{$this->session->userdata('cdn_Name')}')");
			}
		}
		$list = $this->db->query("select * from domain where category='D' and parent_id=0 and user_mail = '{$this->session->userdata('cdn_Name')}' order by domain_id asc")->result_array();
		echo json_encode($list);
	}
	
	function append_dnspod_domain() {
		session_start();
	
		$this->load->library("session");
		$this->load->helper("url");
		$this->load->helper("security");
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');	
		$dnspod_domain = $_POST["dnspod_domain"];
		//$dnspod_domain="ergtser.com";
		if(""==trim($dnspod_domain)){
			$odata["code"] = 0;
			$odata["message"] = "域名不可以为空";
			echo json_encode($odata);
			exit;
		}
		
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		//bug:域名被别人加入呢？
		$this->db->query("select * from domain where domain_name='".$dnspod_domain."'");
		if($this->db->affected_rows() > 0) {
			$odata["code"] = 0;
			$odata["message"] = "域名已存在";
			echo json_encode($odata);
			exit;
		}
		
		$this->load->model("Dnsapi_model","dnspodapi");
		$response = $this->dnspodapi->api_call("Domain.Create", array('domain' => $dnspod_domain));
		if (!$response || 1!=$response["status"]["code"]) {
			$odata["code"] = 0;
			$odata["message"] = $response["status"]["message"];
			echo json_encode($odata);
			exit;
		}
		
		$odata["code"] = 1;
		echo json_encode($odata);

	}
	
	function remove_dnspod_domain() {
		session_start();
	
		$this->load->library("session");
		$this->load->helper("url");
		$this->load->helper("security");
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');	
		$dnspod_domainid = $_POST["dnspod_domainid"];
		//$dnspod_domainid = "2652129";
		if(""==trim($dnspod_domainid)){
			$odata["code"] = 0;
			$odata["message"] = "域名编号不可以为空";
			echo json_encode($odata);
			exit;
		}
		
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->db->query("delete from domain where domain_id='".$dnspod_domainid."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		if($this->db->affected_rows() == 0) {
			$odata["code"] = 0;
			$odata["message"] = "移除域名失败";
			echo json_encode($odata);
			exit;
		}

		$this->load->model("Dnsapi_model","dnspodapi");
		$response = $this->dnspodapi->api_call("Domain.Remove", array('domain_id' => $dnspod_domainid));
		if (!$response || 1!=$response["status"]["code"]) {
			$odata["code"] = 0;
			$odata["message"] = "移除域名失败,请检查DNSPod帐号是否正确！";
			echo json_encode($odata);
			exit;
		}

		$odata["code"] = 1;
		echo json_encode($odata);
	}
	
}
