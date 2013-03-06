###主控端安装手册

###LAMP环境配置

**本文档以 Centos 6.x 86_64 为蓝本** 本文档约定 所有命令以#打头

	#yum -y install httpd mysql-server php php-cli php-mbstring php-pdo php-mysql php-common

	#rpm -ivh ocdn-console-{version}.rpm

	检查Selinux状态

	#sestatus
	
	如果输出不为 SELinux status:    disabled .可以昨时先关闭 .命令如下：

	#setenforce 0

	永久关闭方法：

	#vim  /etc/sysconfig/selinux  把SELINUX=disabled 并重启系统

	#启动Mysql 并设置密码

	#service mysqld start  设置密码:# 

