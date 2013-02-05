<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Cache extends CI_Controller {
	
	public function index($domainId) {
		#$domainId = 8;
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		if("" == $domainId){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if(!preg_match('/^[0-9]+$/',$domainId) || strlen($domainId) > 10)
		{
			echo "参数错误";
			exit();
		}
		//bug:all
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$this->db->query("SELECT * FROM domain WHERE id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'");
		if($this->db->affected_rows()  == 0) {
			echo "页面不存在";
			exit();
		}
		$data['check'] = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		$data['domain'] = $this->db->query("SELECT * FROM domain WHERE id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		$this->load->view('cache', $data);
	}

	public function append() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');		
		$domainId = $_POST['domain_id'];
		if(""==$domainId){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if(!preg_match('/^[0-9]+$/',$domainId) || strlen($domainId) > 10)
		{
			$result['result'] = 0;
			$result['error'] = '参数错误';
			echo json_encode($result);
			exit();
		}
		$this->load->database();
		$domain = $this->db->query("select * from domain where id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() <= 0) {
			$result['result'] = 0;
			$result['error'] = '无';
			echo json_encode($result);
			exit();
		}

		$proxy_cache = $_POST['proxy_cache'];
		$cacahe_select = $_POST['cacahe_select'];
		$tell_cache = $_POST['tell_cache'];
		$cache_time = $_POST['cache_time'];
		
		//$proxy_cache = '文件类型';
		//$cacahe_select = 'jsp|php|asp';
		//$tell_cache = 'Y';
		//$cache_time = '3';
			
		if ($proxy_cache=="") {
			$result['result']=0;
			$result['error']="添加失败";
			echo  json_encode($result);
			exit();
		}

		if ($cacahe_select=="") {
			$result['result']=0;
			$result['error']="请选择匹配方式";
			echo  json_encode($result);
			exit();
		}
		
		if ($tell_cache=="") {
			$result['result']=0;
			$result['error']="请选择缓存方式";
			echo  json_encode($result);
			exit();
		}
		
		if ($tell_cache=="Y" && $cache_time=="") {
			$result['result']=0;
			$result['error']="缓存时间不可为空";
			echo  json_encode($result);
			exit();
		}
		
		$path = '';
		if($proxy_cache == '文件类型')
		{
			$path = '~ \.('.$cacahe_select.')$';
			$loc_type = 'extension';
		}
		if($proxy_cache == '目录'){
			$path = $cacahe_select;
			$loc_type = 'directory';
		}
				
		if ("0"==$domain[0]["parent_id"]) {
			$domainname = $domain[0]["domain_name"];
		} else {
			$domainname = $domain[0]["sub_domain"].".".$domain[0]["domain_name"];
		}
		
		$domainIP = $domain[0]['domain_ip'];
	
		$this->db->query("SELECT 1 FROM domain_conf_loc WHERE tips='".$cacahe_select."' AND `domain_name`='".$domainname."'");
		if($this->db->affected_rows() > 0) {
			$result['result'] = 0;
			$result['error'] = '匹配方式的值已存在';
			echo  json_encode($result);
			exit();
		}
		
		$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips) values ('".$domainname."','".$path."','".$tell_cache."','".$proxy_cache."','".$cacahe_select."')");
		if($this->db->affected_rows() <= 0) {
			$result['result'] = 0;
			$result['error'] = '处理失败';
			echo  json_encode($result);
			exit();
		}
				
		$DomainConfLoc = $this->db->query("select locf_id from domain_conf_loc where domain_name='".$domainname."' and tips='".$cacahe_select."'")->result_array();
		if($this->db->affected_rows() > 0) {
			$LocfId = $DomainConfLoc[0]['locf_id'];
		}
		
		if ($tell_cache=="Y") {
			$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
			$this->db->query("update domain_conf_loc_conf set loc_value='".$cache_time."d;' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='expires'");
			
			//$this->db->query("update domain_conf_loc_conf set loc_value='{\r\n		proxy_pass	http://".$domainIP.";\r\n		break;\r\n		}' where loc_key='if (!-f \$request_filename)'");
		}
		
		$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort from loc_type_item where type_id=(select loctype_id from loc_type where type_name='".$loc_type."') order by item_sort asc");
		$this->db->query("update domain_conf_loc_conf set loc_value='http://".$domainIP.";' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='proxy_pass'");
		
		if($this->db->affected_rows() <= 0) {
			$result['result'] = 0;
			$result['error'] = '处理失败';
			echo  json_encode($result);
		} else {
			$result['result'] = 1;
			echo json_encode($result);
			
			$this->load->model("Filewrite_model","filewrite");
			$this->filewrite->write_file($domainId);
		}
		
	}
	
	public function delect() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
	
		$locfid = $_POST['locf_id'];
		$domainname = $_POST['domain_name'];
		if(""==$locfid || ""==$domainname ){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		$this->load->database();
		$this->db->query("SELECT `domain_name` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."' AND `locf_id`=".$locfid);
		if($this->db->affected_rows() <= 0) {
			$result['result'] = 0;
			echo json_encode($result);
		}
		
		$this->db->query("delete from domain_conf_loc_conf where conf_loc_id=".$locfid);
		$this->db->query("delete from domain_conf_loc where domain_name='".$domainname."' and locf_id=".$locfid);
		
		if($this->db->affected_rows() <= 0) {
			$result['result'] = 0;
			echo json_encode($result);
		} else {
			$result['result'] = 1;
			echo json_encode($result);
			
			$domain = $this->db->query("SELECT id FROM domain WHERE domain_name='".$domainname."' and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
			
			$this->load->model("Filewrite_model","filewrite");
			$this->filewrite->write_file($domain[0]['id']);
		}
	}
	
	public function query() {
		
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
	
		$domainId = $_POST['domain_id'];
		//$domainId = 6;
		if(""==$domainId){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		$this->load->database();
		$domain = $this->db->query("SELECT * FROM `domain` WHERE `id`=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() <= 0) {
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
			
		if ("0"==$domain[0]["parent_id"]) {
			$domainname = $domain[0]["domain_name"];
		} else {
			$domainname = $domain[0]["sub_domain"].".".$domain[0]["domain_name"];
		}
				
		$list = $this->db->query("select * from domain_conf_loc where domain_name='".$domainname."' order by locf_id asc")->result_array();
		echo json_encode($list);
	}
	
	public function cacheAll() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
	
		//$domainId = 6;
		//$allcache = 1;
		//$allcacheout = 0;
		
		$domainId = $_POST['domain_id'];
		$allcache = $_POST['allcache'];
		$allcacheout = $_POST['allcacheout'];

		if(""==$domainId){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		$this->load->model("Filewrite_model","filewrite");
		$result = $this->filewrite->cache_all($domainId,$allcache,$allcacheout);
		
		echo json_encode(array("result"=>$result));
		
	}
	
	public function change() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
	
		$domainId = $_POST['domain_id'];
		$all_re = $_POST['all_re'];
		$normal_cache = $_POST['normal_cache'];
		$index_cache = $_POST['index_cache'];
		$htm_cache = $_POST['htm_cache'];

		if(""==$domainId){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		$this->load->model("Filewrite_model","filewrite");
		$result = $this->filewrite->cache_change($domainId,$all_re,$normal_cache,$index_cache,$htm_cache);
		
		echo json_encode(array("result"=>$result));
	
	}

}