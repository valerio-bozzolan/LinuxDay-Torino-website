#!/bin/sh
# Vagrant provision: bootstrap

# Exit immediately if a command exits with a non-zero status
set -e

PORT_APACHE=8080
PORT_NGINX=8008
DOMAIN=localhost
WELCOME_APACHE=http://$DOMAIN:$PORT_APACHE
WELCOME_NGINX=http://$DOMAIN:$PORT_NGINX
PROJECT=/vagrant
WWW="$PROJECT"
DB_NAME=ldto
DB_PREFIX=ldto_
SUCKLESS_PHP=$PROJECT/includes/suckless-php
SUCKLESS_PHP_REPO=https://github.com/valerio-bozzolan/suckless-php.git

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
                      git

if [ ! -e "$SUCKLESS_PHP" ]; then
	git clone "$SUCKLESS_PHP_REPO" "$SUCKLESS_PHP"
else
	git -C "$SUCKLESS_PHP" pull
fi

echo "create an empty database"
mysql <<EOF
DROP DATABASE IF EXISTS \`$DB_NAME\`;
CREATE DATABASE \`$DB_NAME\`;
EOF

echo "create a file with database credentials"
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
define('REQUIRE_LOAD_POST', ABSPATH . '/includes/load-post.php' );
require '$SUCKLESS_PHP/load.php';
EOF

echo "grant database permissions"
mysql <<EOF
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@localhost IDENTIFIED BY '$DB_PASSWORD';
FLUSH PRIVILEGES;
EOF

echo "populate the database"
"$PROJECT"/cli/populate.php

# TODO: WHAT THE FUCK - error: Table 'ldto.ldto_user' doesn't exist
echo "add an admin user or update its password"
"$WWW"/cli/add-user.php --uid=admin --role=admin --pwd=admin --force

echo "disable the default apache site"
a2dissite --quiet 000-default

echo "copy apache configuration for ldto site"
ln --symbolic --force "$PROJECT/Vagrant/apache.conf" /etc/apache2/sites-available/ldto.conf

echo "patch for php-libmarkdown"
# https://bugs.debian.org/cgi-bin/bugreport.cgi?bug=877513
sed --in-place "s/function Markdown_Parser/function __construct/" /usr/share/php/markdown.php

# enable apache mod_rewrite
a2enmod --quiet rewrite

# enable ldto apache site
a2ensite --quiet ldto

echo "GNU Gettext workflow"
cd  "$WWW"
php "$WWW"/l10n/localize.php .
cd -
#/GNU Gettext workflow

echo "restart apache"
systemctl restart apache2

##############################################
# now as surplus we add an nginx environment #
##############################################

# avoid nginx to be started just after installation
systemctl mask nginx

# install nginx and it's php binary
apt-get install --yes \
	nginx-light \
	php-fpm

# remove the default site that listens to :80
rm --force /etc/nginx/sites-enabled/default

# allow nginx to be started and start it
systemctl unmask nginx

# copy nginx configuration
ln --symbolic --force "$PROJECT/Vagrant/nginx.conf" /etc/nginx/sites-available/ldto.conf

# enable the website
ln --symbolic --force ../sites-available/ldto.conf /etc/nginx/sites-enabled/ldto.conf

# start nginx
systemctl start nginx

echo "End provision: $WELCOME_APACHE (apache2)"
echo "               $WELCOME_NGINX (nginx)"
echo "Login:         $WELCOME_APACHE/2016/login.php (apache)"
echo "               $WELCOME_NGINX/2016/login.php (nginx)"
echo
echo "Admin uid:     admin"
echo "      pwd:     admin"
