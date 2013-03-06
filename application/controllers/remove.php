<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Remove_user extends CI_Controller {
	public function index(){
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$data['base'] = $this->config->item('base_url');
		$result= Array();
		$domainName = $_GET['domainName'];
		//$domainName = "abc.com";
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->db->query("UPDATE domain set remove_url = 1 where domain_name = '".$domainName."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		if(!preg_match('/^[a-zA-Z0-9\-]+(.)+$/',$domainName) || strlen($domainName) > 25)
		{
			/*$result['result'] = 1;
			$result['error'] = '参数错误';
			echo json_encode($result);*/
			$this->db->query("UPDATE domain set remove_url = 0 where domain_name = '".$domainName."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			exit();
		}
				//bug:对于不同用户的权限隔离
//              $domainName = "cmcc.secon.me";
				$domainName_again = $domainName;
                $domainName = str_replace(".","_",$domainName);
        //      $filepath = "/home/wwwroot/node_cache/1.txt";
                $filepath = '/home/wwwroot/node_cache/'.$domainName.'_url.txt';
                if (file_exists($filepath)) {
                $file = fopen('/home/wwwroot/node_cache/'.$domainName.'_url.txt',"r");
                while(!feof($file)){
				$curl = curl_init();
				// 设置你需要抓取的URL
				curl_setopt($curl, CURLOPT_URL, fgets($file));
				// 设置header
				curl_setopt($curl, CURLOPT_HEADER, 1);
				// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				// 运行cURL，请求网页
				$data = curl_exec($curl);
				// 关闭URL请求
				curl_close($curl);
				fclose($file);
				$this->db->query("UPDATE domain set remove_url= 0  where domain_name = '".$domainName_again."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
				/*$result['result'] = 0;
				$result['error'] = '清除成功';
				echo json_encode($result);*/
			}
		}else{
		//	fclose($filename);
			/*$result['result'] = 0;
			$result['error'] = '缓存暂不用清理';
			echo json_encode($result);*/
			$this->db->query("UPDATE domain set remove_url= 0  where domain_name = '".$domainName_again."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			}
	}
}
