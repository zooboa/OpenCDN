<?php

class Filewrite_model extends CI_Model {

    function __construct() {	
		$this->load->library('session');
		header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
	
	public function cache_all($domainId, $allcache, $allcacheout) {//demo:id,1,1
		$this->load->library('session');
		if (""==$domainId || ""==$allcache || ""==$allcacheout) {
			return false;
		}
	
		$this->load->database();
		$domain = $this->db->query("select * from domain where id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() == 0) {
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		if ("0"==$domain[0]["parent_id"]) {
			$domainname = $domain[0]["domain_name"];
		} else {
			$domainname = $domain[0]["sub_domain"].".".$domain[0]["domain_name"];
		}
		
		$domainIP = $domain[0]['domain_ip'];
		
		if ($allcache=='1') {
				
			$this->db->query("DELETE FROM `domain_conf_loc_conf` WHERE `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and user_mail = '{$this->session->userdata('cdn_Name')}'");
			$this->db->query("DELETE FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			
			// 处理全站缓存（根目录）
			//bug
			$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,loc_type.enable,loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name = 'cache_all'");
			
			$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='cache_all') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
			if($this->db->affected_rows() > 0) {
				$LocfId = $DomainConfLoc[0]['locf_id'];
			}
			
			$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
			$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_all') order by item_sort asc");

			if($allcacheout=='1'){
			
				// 处理全站缓存（js|css）
				$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,loc_type.enable,loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='ext_jscss'");
				
				$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='ext_jscss') and '{$this->session->userdata('cdn_Name')}'")->result_array();
				if($this->db->affected_rows() > 0) {
					$LocfId = $DomainConfLoc[0]['locf_id'];
				}
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort from loc_type_item,'{$this->session->userdata('cdn_Name')}' where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort from loc_type_item,'{$this->session->userdata('cdn_Name')}' where type_id=(select loctype_id from loc_type where type_name='ext_jscss') order by item_sort asc");
				$this->db->query("update domain_conf_loc_conf set loc_value='{\r\n			proxy_pass	http://".$domainIP.";\r\n			break;\r\n		}' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='if (!-f \$request_filename)' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			
				// 处理全站缓存（动态脚本）
				$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,'N',loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='dynamic_script'");
				
				$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='dynamic_script') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
				if($this->db->affected_rows() > 0) {
					$LocfId = $DomainConfLoc[0]['locf_id'];
				}
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='dynamic_script') order by item_sort asc");
			}
		}
		
		$this->db->query("update domain_conf_loc_conf set loc_value='http://".$domainIP.";' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='proxy_pass' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		
		if($this->db->affected_rows() == 0) {
			return 0;
		} else {
			$this->write_file($domainId);
			return 1;
		}
			
	}
	
	public function cache_change($domainId, $all_re, $normal_cache, $index_cache, $htm_cache) {
		$this->load->library('session');
		if (""==$domainId || ""==$all_re || ""==$normal_cache || ""==$index_cache || ""==$htm_cache) {
			return false;
		}
	
		$this->load->database();
		$domain = $this->db->query("select * from domain where id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() <= 0) {
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		
		if ("0"==$domain[0]["parent_id"]) {
			$domainname = $domain[0]["domain_name"];
		} else {
			$domainname = $domain[0]["sub_domain"].".".$domain[0]["domain_name"];
		}
		
		$domainIP = $domain[0]['domain_ip'];
		
		if ($all_re=='1') {
		
			$this->db->query("DELETE FROM `domain_conf_loc_conf` WHERE `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and user_mail = '{$this->session->userdata('cdn_Name')}'");
			$this->db->query("DELETE FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		
			// 处理全站缓存（根目录）
			$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,'N',loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='cache_all'");
			
			$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='cache_all') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
			if($this->db->affected_rows() > 0) {
				$LocfId = $DomainConfLoc[0]['locf_id'];
			}
			$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_all') order by item_sort asc");
			
			// 常用扩展缓存
			if($normal_cache=='1'){
				$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,loc_type.enable,loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='ext_frequently'");
				$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='ext_frequently') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
				if($this->db->affected_rows() > 0) {
					$LocfId = $DomainConfLoc[0]['locf_id'];
				}
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='ext_frequently') order by item_sort asc");
				$this->db->query("update domain_conf_loc_conf set loc_value='{\r\n			proxy_pass	http://".$domainIP.";\r\n			break;\r\n		}' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='if (!-f \$request_filename)' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			}
			
			// 首页/目录缓存
			if($index_cache=='1'){
				$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,loc_type.enable,loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='dir_=/'");
				$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='dir_=/') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
				if($this->db->affected_rows() > 0) {
					$LocfId = $DomainConfLoc[0]['locf_id'];
				}
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='dir_=/') order by item_sort asc");
				$this->db->query("update domain_conf_loc_conf set loc_value='{\r\n			proxy_pass	http://".$domainIP.";\r\n			break;\r\n		}' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='if (!-f \$request_filename)' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			}
			
			// htm缓存
			if($htm_cache=='1'){
				$this->db->query("insert into domain_conf_loc(domain_name,path,`enable`,memo,tips,user_mail) select '".$domainname."',exts,loc_type.enable,loc_type.mome,exts_tips,'{$this->session->userdata('cdn_Name')}' from loc_type where type_name='ext_htm'");
				$DomainConfLoc = $this->db->query("SELECT locf_id FROM domain_conf_loc WHERE domain_name='".$domainname."' AND tips=(SELECT exts_tips FROM loc_type WHERE type_name='ext_htm') and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
				if($this->db->affected_rows() > 0) {
					$LocfId = $DomainConfLoc[0]['locf_id'];
				}
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='cache_one') order by item_sort asc");
				$this->db->query("INSERT INTO domain_conf_loc_conf(conf_loc_id,loc_key,loc_value,memo,domain_conf_loc_conf.enable,sort,user_mail) SELECT ".$LocfId.",item_key,item_value,item_memo,item_enable,item_sort,'{$this->session->userdata('cdn_Name')}' from loc_type_item where type_id=(select loctype_id from loc_type where type_name='ext_htm') order by item_sort asc");
				$this->db->query("update domain_conf_loc_conf set loc_value='{\r\n			proxy_pass	http://".$domainIP.";\r\n			break;\r\n		}' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='if (!-f \$request_filename)' and user_mail = '{$this->session->userdata('cdn_Name')}'");
			}
		}

		$this->db->query("update domain_conf_loc_conf set loc_value='http://".$domainIP.";' where `conf_loc_id` IN (SELECT `locf_id` FROM `domain_conf_loc` WHERE `domain_name`='".$domainname."') and loc_key='proxy_pass' and user_mail = '{$this->session->userdata('cdn_Name')}'");
		
		if($this->db->affected_rows() == 0) {
			return 0;
		} else {
			$this->write_file($domainId);
			return 1;
		}
	}
	
	public function write_file($domainId) {
		$this->load->library('session');
		$this->load->database();
		$Domain = $this->db->query("select * from domain where id=".$domainId." and user_mail = '{$this->session->userdata('cdn_Name')}'")->result_array();
		if($this->db->affected_rows() > 0) {
		
			if ('0'==$Domain[0]['parent_id']) {
				$DomainName = $Domain[0]['domain_name'];
				$DomainName_ = $Domain[0]['domain_name'];
			} else {
				$DomainName_ = $Domain[0]['sub_domain'].".".$Domain[0]['domain_name'];
				if ('@'==$Domain[0]['sub_domain']) {
					$DomainName = $Domain[0]['domain_name'];
				} else {
					$DomainName = $Domain[0]['sub_domain'].".".$Domain[0]['domain_name'];
				}
			}
			
			$content = "server {\n";
			$content .= "\tlisten 80;\n";
			$content .= "\tserver_name ".$DomainName.";\n";
			$content .= "\tgzip on;\n";
			$content .= "\tif (-d \$request_filename) {\n";
			$content .= "\t\trewrite ^/(.*)([^/])$ \$scheme://\$host/$1$2/ permanent;\n";
			$content .= "\t}\n";
						
			$DomainLoc = $this->db->query("select locf_id,path from domain_conf_loc where domain_name='".$DomainName_."' and user_mail = '{$this->session->userdata('cdn_Name')}' order by locf_id asc")->result_array();

			for($i=0;$i<count($DomainLoc);$i++) {
			
				$content .= "\tlocation ".$DomainLoc[$i]['path']." {\n";
				
				$DomainLocitem = $this->db->query("SELECT loc_key,loc_value FROM domain_conf_loc_conf WHERE conf_loc_id=".$DomainLoc[$i]['locf_id']." and user_mail = '{$this->session->userdata('cdn_Name')}' order by sort asc")->result_array();
				
				for($k=0;$k<count($DomainLocitem);$k++) {
					//if ('if (!-f $request_filename)' == $DomainLocitem[$k]['loc_key'].strstr($email, '@')) {
					//	$content .= "\t\t".$DomainLocitem[$k]['loc_key']." ".$DomainLocitem[$k]['loc_value']."\n";
					//} else {
					//	$content .= "\t\t".$DomainLocitem[$k]['loc_key']."\t".$DomainLocitem[$k]['loc_value']."\n";
					//}
					
					if (strstr($DomainLocitem[$k]['loc_key'], 'if (')) {
						$content .= "\t\t".$DomainLocitem[$k]['loc_key']." ".$DomainLocitem[$k]['loc_value']."\n";
					} else {
						$content .= "\t\t".$DomainLocitem[$k]['loc_key']."\t".$DomainLocitem[$k]['loc_value']."\n";
					}
				}
				
				$content .= "\t}\n";
			}
							
			$content .= "\tlocation ~ /purge(/.*) {\n";
			$content .= "\t\tallow all;\n";
			$content .= "\t\tproxy_cache_purge cache_one \$host$1\$is_args\$args;\n";
			$content .= "\t\terror_page 405 =200 /purge$1;\n";
			$content .= "\t}\n";
			$content .= "}\n";

			$filePath = "/home/wwwroot/conf_rsync/vhost/".str_replace(".","_",$DomainName).".conf";
			//$filePath = "D:/".str_replace(".","_",$DomainName).".conf";
			if (!file_exists($filePath)) {
				touch($filePath);
			}
			
			$file = fopen($filePath, "w+");
			fwrite($file, $content);
			fclose($file);
		}
		
	}
	
	public function delete_file($DomainName) {
		$this->load->library('session');
		if (""==$DomainName) {
			return 0;
		}
	
		$filePath = "/home/wwwroot/conf_rsync/vhost/".str_replace(".","_",$DomainName).".conf";
		//$filePath = "D:/".str_replace(".","_",$DomainName).".conf";
		if (file_exists($filePath)) {
			unlink($filePath);
		}
	}
	
}
?>