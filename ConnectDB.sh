#!/bin/bash

# Read .env values
DB_HOST=$(grep -oP '^DB_HOST=\K.*' .env)
DB_PORT=$(grep -oP '^DB_PORT=\K.*' .env)
DB_DATABASE=$(grep -oP '^DB_DATABASE=\K.*' .env)
DB_USERNAME=$(grep -oP '^DB_USERNAME=\K.*' .env)
DB_PASSWORD=$(grep -oP '^DB_PASSWORD=\K.*' .env)

# Connect to the MySQL database and run a query (replace 'your_table' with the actual table name)
mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT * FROM your_table LIMIT 10;"
