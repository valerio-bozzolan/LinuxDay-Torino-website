#!/bin/sh
# Vagrant provision: bootstrap

# Exit immediately if a command exits with a non-zero status
set -e

WELCOME=http://localhost:8080
PROJECT=/vagrant
WWW="$PROJECT"
DB_NAME=ldto
DB_PREFIX=ldto_
BOZ_PHP=/usr/share/boz-php-another-php-framework

# Very scaring
DB_USER=ldto
DB_PASSWORD=ldto

apt-get update
apt-get install --yes mariadb-server     \
                      php                \
                      php-mysql          \
                      php-mbstring       \
                      php-xml            \
                      apache2            \
                      libapache2-mod-php \
                      gettext            \
                      libmarkdown-php    \
                      libjs-jquery       \
                      libjs-leaflet      \
                      bzr

if [ ! -e "$BOZ_PHP" ]; then
	bzr branch --quiet lp:boz-php-another-php-framework "$BOZ_PHP"
else
	bzr pull --quiet --directory="$BOZ_PHP" lp:boz-php-another-php-framework
fi
chmod --recursive 750           "$BOZ_PHP"
chown --recursive root:www-data "$BOZ_PHP"

#if [ ! -h "$WWW" ]; then
#	rm --recursive                     "$WWW"
#	ln --symbolic --verbose "$PROJECT" "$WWW"
#fi

cp "$PROJECT/htaccess.txt" "$WWW/.htaccess"

mysql <<EOF
DROP DATABASE IF EXISTS \`$DB_NAME\`;
CREATE DATABASE \`$DB_NAME\`;
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@localhost IDENTIFIED BY '$DB_PASSWORD';
FLUSH PRIVILEGES;
EOF

cat "$PROJECT/database-schema.sql" | mysql --user=$DB_USER --password=$DB_PASSWORD "$DB_NAME"

cat > "$WWW/load.php" <<EOF
<?php
\$database = '$DB_NAME';
\$username = '$DB_USER';
\$password = '$DB_PASSWORD';
\$location = 'localhost';
\$prefix   = '$DB_PREFIX';
define('DEBUG', true);
define('ABSPATH', __DIR__);
define('ROOT', '');
define('DB_TIMEZONE', 'Europe/Rome');
define('CONTACT_EMAIL', 'asd@asd.asd');
define('CONTACT_PHONE', '555-555-555');
require '$BOZ_PHP/load.php';
EOF

cat > /etc/apache2/sites-enabled/000-default.conf <<EOF
<VirtualHost *:80>
	ServerName  ldto
	ServerAlias localhost 127.0.0.1

	php_admin_flag  display_errors         1
	php_admin_flag  display_startup_errors 1
	php_admin_flag  html_errors            1
	php_admin_value error_reporting       -1

	LogLevel info

	DocumentRoot $WWW

	<Directory $PROJECT>
		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
EOF

# Patch for php-libmarkdown
# https://bugs.debian.org/cgi-bin/bugreport.cgi?bug=877513
sed --in-place "s/function Markdown_Parser/function __construct/" /usr/share/php/markdown.php

a2enmod --quiet rewrite

# GNU Gettext workflow
cd  "$WWW"
php "$WWW"/l10n/localize.php .
cd -
#/GNU Gettext workflow

service apache2 restart

# add an admin user
"$WWW"/cli/add-user.php --uid=admin --role=admin --pwd=admin

echo "End provision: $WELCOME"
echo "Login:         $WELCOME/2016/login.php"
echo
echo "Admin uid:     admin"
echo "      pwd:     admin"
