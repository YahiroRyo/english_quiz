#!/bin/bash

main() {
    {
        echo "IAM_ROLE: $IAM_ROLE"
        echo "APP_KEY: $APP_KEY"
        echo "CHAT_GPT_TOKEN: $CHAT_GPT_TOKEN"
        echo "LOG_CHANNEL: $LOG_CHANNEL"
        echo "LOG_LEVEL: $LOG_LEVEL"
        echo "DB_CONNECTION: $DB_CONNECTION"
        echo "DB_PORT: $DB_PORT"
        echo "DB_HOST: $DB_HOST"
        echo "DB_DATABASE: $DB_DATABASE"
        echo "DB_USER_NAME: $DB_USER_NAME"
        echo "DB_PASSWORD: $DB_PASSWORD"
        echo "AWS_URL: $AWS_URL"
        echo "AWS_BUCKET: $AWS_BUCKET"
        echo "AWS_USE_PATH_STYLE_ENDPOINT: $AWS_USE_PATH_STYLE_ENDPOINT"
        echo "AWS_SPEECH_FILES_BUCKET: $AWS_SPEECH_FILES_BUCKET"
        echo "AWS_SPEECH_FILES_URL: $AWS_SPEECH_FILES_URL"
        echo "MYSQL_ATTR_SSL_CA: $MYSQL_ATTR_SSL_CA"
        echo "SESSION_DRIVER: $SESSION_DRIVER"
        echo "CACHE_DRIVER: $CACHE_DRIVER"
        echo "QUEUE_CONNECTION: $QUEUE_CONNECTION"
        echo "QUEUE_DIRVER: $QUEUE_DIRVER"
    } >> ./config/config.yml
}

main
