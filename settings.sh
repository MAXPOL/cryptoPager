#!/bin/bash

passworddb="1"

yum install epel-release nano wget httpd mariadb mariadb-server yum-utils -y

yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm

yum-config-manager ––enable remi–php71

yum install php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysql –y

systemctl start mariadb && systemctl enable mariadb

systemctl start httpd && systemctl enable httpd

mysql_secure_installation <<EOF

y
$passworddb
$passworddb
y
n
y
y
EOF

mysql -u root -p1 -e "CREATE USER 'user'@'%' IDENTIFIED BY '1';"

mysql -u root -p1 -e "GRANT ALL PRIVILEGES ON *.* TO 'user'@'%';"

mysql -u root -p1 -e "FLUSH PRIVILEGES;"

firewall-cmd --permanent --zone=public --add-port=80/tcp --add-port=3306/tcp

firewall-cmd --reload
