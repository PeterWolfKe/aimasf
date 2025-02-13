#!/bin/bash

# Read .env values
DB_HOST=$(grep -oP '^DB_HOST=\K.*' .env)
DB_PORT=$(grep -oP '^DB_PORT=\K.*' .env)
DB_DATABASE=$(grep -oP '^DB_DATABASE=\K.*' .env)
DB_USERNAME=$(grep -oP '^DB_USERNAME=\K.*' .env)
DB_PASSWORD=$(grep -oP '^DB_PASSWORD=\K.*' .env)

mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE"
