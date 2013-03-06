<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Domain_user extends CI_Controller {
	public function index() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		$data = Array();
		$domain = Array();
		$data['base'] = $this->config->item('base_url');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 0){
			exit('Access Denied');
		}else{
			//bug下2句的含义
			/*$nodeip = $this->db->query("SELECT NodeIP from node_info IN (SELECT )")->result_array();
			$data["nodeip"] = $nodeip;*/
			$this->load->view('domain_user',$data);
		}
	}
	public function salt(){
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');		
		$length = 6;
		$mode = '0';
		switch ($mode) 
		{
			case '1':
			$str = '1234567890';
			break;
			case '2':
			$str = 'abcdefghijklmnopqrstuvwxyz';
			break;
			case '3':
			$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
			default:
			$str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		}
		$pass = '';
		$l = strlen($str)-1;
		$num=0;
		for($i = 0;$i < $length;$i ++){
			$num = rand(0, $l);
			$a=$str[$num];
			$pass =$pass.$a;
		}
		return $pass;
	}
	public function query() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$data = Array();
		$domain = Array();
		$look = Array();
		$look_again = Array();
		$data['base'] = $this->config->item('base_url');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 0){
			exit('Access Denied');
		}
		$look = $this->db->query("select domain_name from domain where user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		//ECHO $look[0]['domain_name'];
		for($i = 0;$i < count($look);$i++){
		$look_again[$i] = gethostbyname($look[$i]['domain_name']);
		$this->db->select('NodeIP')->from('node_info')->where('NodeIP', $look_again[$i]);
		$query = $this->db->get();
			if ($query->num_rows() != 0)
			{
				$speed = 1;
			}else{
				$speed = 0;
			}
			//$speed = 1;
			$this->db->query("update domain set speed = '".$speed."' where domain_name='".$look[$i]['domain_name']."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		}
		$data = $this->db->query("select * from domain where category='O' and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		echo json_encode($data);
	}
	
	public function append() {
		//echo $pass;
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');		
		$domain_name = $_POST['domain_name'];
		//$domain_name = "ddd.com";
		if(!preg_match('/^[a-zA-Z0-9\-]+(.)+$/',$domain_name) || strlen($domain_name) > 25)
		{
			$result['result'] = 0;
			$result['error'] = '参数错误';
			echo json_encode($result);
			exit();
		}
		if ("" == $domain_name) {
			$result['result'] = 0;
			$result['error'] = '域名名称不可以为空';
			echo json_encode($result);
			exit();
		}
		$node_ip = '';
		$record_line ='';
		$domain_ip = gethostbyname($domain_name);
		if (""==$domain_ip) {
			$result['result'] = 0;
			$result['error'] = '未取到该域名的IP地址';
			echo json_encode($result);
			exit();
		}
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 0){
			exit('Access Denied');
		}	
		$this->db->query("select 1 from domain where domain_name='".$domain_name."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		if($this->db->affected_rows() > 0) {
			$result['result'] = 0;
			$result['error'] = '该域名已经加入';
			echo json_encode($result);
			exit();
		}
		/*$this->db->select('NodeIP')->from('node_info')->where('NodeIP', $domain_ip);
		$query = $this->db->get();
		if ($query->num_rows() != 0)
		{
			$speed = 1;
		}else{
			$speed = 0;
		}*/
		/*switch_pass:
		$length = 6;
		$mode = '0';
		switch ($mode) 
		{
			case '1':
			$str = '1234567890';
			break;
			case '2':
			$str = 'abcdefghijklmnopqrstuvwxyz';
			break;
			case '3':
			$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
			default:
			$str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		}
		$pass = '';
		$l = strlen($str)-1;
		$num=0;
		for($i = 0;$i < $length;$i ++){
			$num = rand(0, $l);
			$a=$str[$num];
			$pass =$pass.$a;
		}*/
		$check_tell = 1;
		while ($check_tell == 1) {
			$pass = $this->salt();
			$this->db->select('CNAME')->from('domain')->where('CNAME',$pass);
			$switch_pass = $this->db->get();
			if($switch_pass->num_rows() > 0) {
				$check_tell = 1;
			}else{
				$check_tell = 0;
			}
		}
		$pass = $pass.".x.ocdn.me";
		$this->db->query("insert into domain(domain_id,record_id,domain_name,parent_id,domain_ip,node_ip,status,category,record_line,remove_url,CNAME,user_mail) values ('','','".$domain_name."',0,'".$domain_ip."','".$node_ip."',1,'O','".$record_line."',0,'".$pass."','{$this->session->userdata('cdn_Name')}')");
		if($this->db->affected_rows() == 0) {
			$result['result'] = 0;
			$result['error'] = '添加失败';
			echo json_encode($result);
		} else {
			
			$result['result'] = 1;
			$result['error'] = '添加成功';
			echo json_encode($result);
			
			$Domain = $this->db->query("select id from domain where domain_name='".$domain_name."' and category='O' and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
			if($this->db->affected_rows() > 0) {
				$this->load->model("Filewrite_model","filewrite");
				$this->filewrite->cache_all($Domain[0]['id'],1,1);
				}
			}
		//}
	}
	
	public function delete(){
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 0){
			exit('Access Denied');
		}
		$domain_id = $_POST['domain_id'];
		if (""==$domain_id) {
			$result['result'] = 0;
			$result['error'] = '域名编号不可以为空';
			echo json_encode($result);
			exit;
		}
		if (!preg_match('/^[0-9]+$/',$domain_id) || strlen($domain_id) > 10) {
			$result['result'] = 0;
			$result['error'] = '非法输入';
			echo json_encode($result);
			exit;
		}
		
		$Domain = $this->db->query("select * from domain where id='".$domain_id."' and category='O' and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() == 0) {
			$data['result'] = 1;
			echo json_encode($data);
			exit;
		}
		$DomainName = $Domain[0]['domain_name'];
		
		$this->db->query("delete from domain where id=".$domain_id." and category='O' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		if($this->db->affected_rows() == 0) {
			$result['result'] = 0;
			$result['error'] = '删除失败';
			echo json_encode($result);
		}else{
			$data['result'] = 1;
			echo json_encode($data);
			
			$this->db->query("SELECT 1 FROM domain WHERE `domain_name`='".$DomainName."' and category='O' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			if($this->db->affected_rows() == 0) {
				$this->load->model("Filewrite_model","filewrite");
				$this->filewrite->delete_file($DomainName);
				
				$this->db->query("DELETE FROM `domain_conf_loc_conf` WHERE `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$DomainName."') and user_mail = '{$this->session->userdata('cdn_Name')}'");
				$this->db->query("DELETE FROM `domain_conf_loc` WHERE `domain_name`='".$DomainName."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
				
			}
		}
	}
	public function remove_url(){
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		$result= Array();
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();		
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 0){
			exit('Access Denied');
		}	
		$domainName = $_POST['domainName'];
		//bug对于缓存的权限隔离
		if(!preg_match('/^[a-zA-Z0-9\-]+(.)+$/',$domainName) || strlen($domainName) > 25)
		{
			$result['result'] = 1;
			$result['error'] = '参数错误';
			echo json_encode($result);
			exit();
		}
//                $domainName = "cmcc.secon.me";
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
			$result['result'] = 0;
			$result['error'] = '清除成功';
			echo json_encode($result);
			}
		}else{
		//	fclose($filename);
			$result['result'] = 0;
			$result['error'] = '缓存暂不用清理';
			echo json_encode($result);			
		}
	}
}
