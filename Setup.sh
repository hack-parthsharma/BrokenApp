#!/bin/bash
cp -r BrokenApp /var/www/html/

apt-get install -y apache2 php libapache2-mod-php php-gd mariadb-server php-mysql php-xml php-curl php-mbstring

a2enmod rewrite
a2enmod auth_digest

cat << EOT >> /etc/apache2/apache2.conf

<Directory "/var/www/html/BrokenApp/0-Protected">
  AllowOverride All
  Options Indexes FollowSymLinks
  Order allow,deny
  Allow from all
</Directory>

<Directory "/var/www/html/BrokenApp/1-BasicAuth">
  AllowOverride All
  Options Indexes FollowSymLinks
  Order allow,deny
  Allow from all
</Directory>

<Directory "/var/www/html/BrokenApp/2-DigestAuth">
  AllowOverride All
  Options Indexes FollowSymLinks
  Order allow,deny
  Allow from all
</Directory>

EOT

mysql -u root << eof
ALTER USER 'root'@'localhost' IDENTIFIED BY 'BrokenApp';
flush privileges;
exit;
eof

sed -i '/error_reporting =/c\error_reporting = E_ALL' /etc/php/*/apache2/php.ini
sed -i '/display_errors =/c\display_errors = On' /etc/php/*/apache2/php.ini
sed -i '/allow_url_fopen =/c\allow_url_fopen = On' /etc/php/*/apache2/php.ini
sed -i '/allow_url_include =/c\allow_url_include = On' /etc/php/*/apache2/php.ini

chmod -R 755 /var/www/html/BrokenApp
chmod 777 /var/www/html/BrokenApp/4-CSRF
chmod 777 /var/www/html/BrokenApp/8-FileUpload/uploads
chmod 777 /var/log/apache2/access.log

service mysql restart
service apache2 restart

php Setup.php
