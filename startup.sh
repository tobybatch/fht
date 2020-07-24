#!/bin/bash

function waitForDB() {
  # Parse sql connection data
  # todo: port is not used atm
  DB_TYPE=$(awk -F '[/:@]' '{print $1}' <<< $DATABASE_URL)
  DB_USER=$(awk -F '[/:@]' '{print $4}' <<< $DATABASE_URL)
  DB_PASS=$(awk -F '[/:@]' '{print $5}' <<< $DATABASE_URL)
  DB_HOST=$(awk -F '[/:@]' '{print $6}' <<< $DATABASE_URL)
  DB_BASE=$(awk -F '[/?]'  '{print $4}' <<< $DATABASE_URL)

  # If we use mysql wait until its online
  if [[ $DB_TYPE == "mysql" ]]; then
      echo "Using Mysql DB, $DATABASE_URL"
      echo "Wait for db connection ..."
      echo "mysql:host=$DB_HOST;dbname=$DB_BASE\", \"$DB_USER\", \"$DB_PASS\""
      until php -r "new PDO(\"mysql:host=$DB_HOST;dbname=$DB_BASE\", \"$DB_USER\", \"$DB_PASS\");" &> /dev/null; do
          sleep 3
      done
      echo "Connection established"
  else
      echo "Using non mysql DB"
  fi
}

function handleStartup() {
  # first start?
  if ! [ -e /opt/bfv/installed ]; then 
    touch /opt/bfv/.env
    echo "first run - install symfony"
    /opt/bfv/bin/console -n doctrine:schema:create
    echo $bfv > /opt/bfv/installed
  fi
  echo "bfv2 ready"
}

waitForDB
handleStartup
/opt/bfv/bin/console cache:clear --env=$APP_ENV
exec php-fpm
exit
