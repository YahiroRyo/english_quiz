#!/bin/bash

main() {
    composer install
    php artisan storage:link
    chmod 777 -R *
}

main
