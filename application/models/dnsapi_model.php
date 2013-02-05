<?php

class Dnsapi_model extends CI_Model {

    function __construct()
    {	
		@session_start();
		header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
	
	//登入管理，将用户名和密码存入Session
	function set_Session($login_email,$login_password){
		$_SESSION["login_email"] = $login_email;
		$_SESSION["login_password"] = $login_password;
	}
		/* 销毁session */
	function destroy_Session(){
		session_destroy();
	}
	
	//调用api
	function api_call($api, $data) {
		if ($api == '' || !is_array($data)) {
			show_error('内部错误：参数错误');
		}
		
		$api = 'https://dnsapi.cn/' . $api;
		$data = array_merge($data, array('login_email' => $_SESSION['login_email'], 'login_password' => $_SESSION['login_password'], 'format' => 'json', 'lang' => 'cn', 'error_on_empty' => 'no'));
		
		$result = $this->post_data($api, $data);
		if (!$result) {
			show_error('内部错误：调用失败');
		}
		
		$results = @json_decode($result, 1);
		if (!is_array($results)) {
			show_error('内部错误：返回错误');
		}
		
		if ($results['status']['code'] != 1) {
			//show_error($results['status']['message']);
			//return false;
		}
		
		return $results;
	}
	
	//发送post包，与dnspod api进行数据交互。调用curl方法。
	function post_data($url, $data) {
		if ($url == '' || !is_array($data)) {
			return false;
		}
		
		$ch = @curl_init();
		if (!$ch) {
			show_error('内部错误：服务器不支持CURL');
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_USERAGENT, 'DNSPod API PHP Web Client/0.1');
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	
}
?>