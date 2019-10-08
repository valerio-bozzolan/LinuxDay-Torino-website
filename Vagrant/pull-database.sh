#!/bin/bash

# exit in case of any error
set -e

FILE=/vagrant/documentation/database/database-schema.sql

# exporting schema and one-row per data
sudo mysqldump --extended-insert=FALSE ldto > "$FILE"

# stripping e-mail addresses
sed "s/'[a-z\.\-]*@[a-z\.\-]*'/NULL/g" -i "$FILE"

# stripping passwords (now are SHA1 salted)
sed "s/'[a-f0-9]\{40\}'/NULL/g" -i "$FILE"
