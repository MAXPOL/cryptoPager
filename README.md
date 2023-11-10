# cryptoPager (openssl-bash-php)

add.sh-pager(bash part, writer)

index.php-pager(php part, viewer)

Need execute task for learn work with openssl library  in linux command line (bash) and with php programming language. 

Goal to create service for one-sided create message in system and send id and password for view message on site.

Administartor use bash script for create messege. Id save in easy(open) view, password saved in hash view and message save in crypto view.

User use site, on site enter id and password, if data correct, site shows the desired message.

For work project need basic programm: opeenssl, httpd, php, maridb, nano.

For work project need additional programm: HeidiSQL(or equivalent), web-browser

You need create DB: DB name: data : Table name: secret : Columns: id (int, AI, key) or (varhar(50) if you want make id as hash; pass(varchar(50)); msg(text)

Approximate view of a database with data (with hash as id)

![alt text](https://bppk.info/pictures/dbcryptoexample.png)


Settings system: settings.sh



###add.sh need be in /scripts/

###index.php need be in /var/www/html/
