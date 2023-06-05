#!/bin/bash

main() {
    {
        echo "APP_KEY: $APP_KEY"
        echo "CHAT_GPT_TOKEN: $CHAT_GPT_TOKEN"
        echo "LOG_CHANNEL: $LOG_CHANNEL"
        echo "DB_CONNECTION: $DB_CONNECTION"
        echo "DB_PORT: $DB_PORT"
        echo "DB_HOST: $DB_HOST"
        echo "DB_DATABASE: $DB_DATABASE"
        echo "DB_USER_NAME: $DB_USER_NAME"
        echo "DB_PASSWORD: $DB_PASSWORD"
        echo "AWS_DEFAULT_REGION: $AWS_DEFAULT_REGION"
        echo "AWS_BUCKET: $AWS_BUCKET"
        echo "AWS_USE_PATH_STYLE_ENDPOINT: $AWS_USE_PATH_STYLE_ENDPOINT"
        echo "MYSQL_ATTR_SSL_CA: $MYSQL_ATTR_SSL_CA"
        echo "SESSION_DRIVER: $SESSION_DRIVER"
        echo "CACHE_DRIVER: $CACHE_DRIVER"
    } >> ./config/config.yml
}

main
