#!/bin/bash

main() {
    {
        echo "DB_PORT: $DB_PORT"
        echo "DB_HOST: $DB_HOST"
        echo "DB_DATABASE: $DB_DATABASE"
        echo "DB_USER_NAME: $DB_USER_NAME"
        echo "DB_PASSWORD: $DB_PASSWORD"
        echo "MYSQL_ATTR_SSL_CA: $MYSQL_ATTR_SSL_CA"
    } >> ./config/config.yml
}

main
