#!/bin/bash
#
# This script is executed by "/etc/init.d/mariadb" on every (re)start.
#
# Changes to this file will be preserved when updating the Debian package.
#
# NOTE: This file is read only by the traditional SysV init script, not systemd.
#

source /usr/share/mysql/debian-start.inc.sh

# Read default/mysql first and then default/mariadb just like the init.d file does
if [ -f /etc/default/mysql ]; then
  . /etc/default/mysql
fi

if [ -f /etc/default/mariadb ]; then
  . /etc/default/mariadb
fi

MYSQL="/usr/bin/mysql --defaults-file=/etc/mysql/debian.cnf"
MYADMIN="/usr/bin/mysqladmin --defaults-file=/etc/mysql/debian.cnf"
# Don't run full mysql_upgrade on every server restart, use --version-check to do it only once
MYUPGRADE="/usr/bin/mysql_upgrade --defaults-extra-file=/etc/mysql/debian.cnf --version-check"
MYCHECK="/usr/bin/mysqlcheck --defaults-file=/etc/mysql/debian.cnf"
MYCHECK_SUBJECT="WARNING: mysqlcheck has found corrupt tables"
MYCHECK_PARAMS="--all-databases --fast --silent"
MYCHECK_RCPT="${MYCHECK_RCPT:-root}"

## Checking for corrupt, not cleanly closed (only for MyISAM and Aria engines) and upgrade needing tables.

# The following commands should be run when the server is up but in background
# where they do not block the server start and in one shell instance so that
# they run sequentially. They are supposed not to echo anything to stdout.
# If you want to disable the check for crashed tables comment
# "check_for_crashed_tables" out.
# (There may be no output to stdout inside the background process!)

# Need to ignore SIGHUP, as otherwise a SIGHUP can sometimes abort the upgrade
# process in the middle.
trap "" SIGHUP
(
  upgrade_system_tables_if_necessary;
  check_root_accounts;
  check_for_crashed_tables;
) >&2 &

exit 0