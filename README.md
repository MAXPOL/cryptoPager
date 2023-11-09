# pager-openssl-bash-php

Need execute task for learn work with openssl library  in linux command line (bash) and with php programming language. 

Goal to create service for one-sided create message in system and send id and password for view message on site.

Administartor use bash script for create messege. Id save in easy(open) view, password saved in hash view and message save in crypto view.

User use site, on site enter id and password, if data correct, site shows the desired message.

For work project need basic programm: opeenssl, httpd, php, maridb, nano.

For work project need additional programm: HeidiSQL(or equivalent), web-browser

You need create DB:

DB name: data

Table name: secret

Columns: id (int, AI, key); pass(varchar(50)); msg(text)

Settings system:

yum install epel-release nano wget httpd mariadb mariadb-server yum-utils -y

sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm

sudo yum-config-manager ––enable remi–php71

yum install php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysql –y

systemctl start maridb && systemctl enable mariadb

systemctl start httpd && systemctl enable httpd

mysql_secure_installation | ENTER – y -1 -1 y -n -y -y 

mysql -u root -p1

CREATE USER ‘user’@’%’ IDENTIFIED BY ‘1’;

GRANT ALL PRIVILEGES ON *.* TO ‘user’@’%’;

FLUSH PRIVILEGES;

exit

firewall-cmd --permanent --zone=public --add-port=80/tcp --add-port=3306/tcp

firewall-cmd --reload

mkdir /scripts && touch add.sh && chmod +x add.sh && chmod 0777 add.sh
