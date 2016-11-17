#! /bin/bash

OF=$2/my-backup-$(date +%Y%m%d).tgz

tar -czfv $OF $1
