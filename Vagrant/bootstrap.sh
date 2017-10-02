#!/bin/sh
# Vagrant provision: bootstrap

# Exit immediately if a command exits with a non-zero status
set -e

PROJECT=/vagrant
WWW=/var/www
DB_NAME=ldto
DB_PREFIX=
BOZ_PHP=/usr/share/boz-php-another-php-framework

# Very scaring
DB_USER=root
DB_PASSWORD=

# Very scaring
export DEBIAN_FRONTEND=noninteractive

apt-get update
apt-get install -y mariadb-server  \
                php                \
                php-mysql          \
                apache2            \
                libapache2-mod-php \
                php-php-gettext    \
                libmarkdown-php    \
                libjs-jquery       \
                libjs-leaflet      \
		bzr

a2enmod rewrite

service apache2 restart

if [ ! -e "$BOZ_PHP" ]; then
	bzr branch lp:boz-php-another-php-framework "$BOZ_PHP"
	chmod -R 750                                "$BOZ_PHP"
	chown -R root:www-data                      "$BOZ_PHP"
fi

if [ ! -h "$WWW" ]; then
	rm -R             "$WWW"
	ln -vs "$PROJECT" "$WWW"
fi

cp   "$PROJECT/htaccess.txt" "$WWW/.htaccess"

echo "DROP DATABASE IF EXISTS \`$DB_NAME\`;" | mysql
echo "CREATE DATABASE \`$DB_NAME\`;"         | mysql
cat  "$PROJECT/database-schema.sql"          | mysql "$DB_NAME"

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

echo "End provision."
