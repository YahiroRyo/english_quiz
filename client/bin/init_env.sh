#!/bin/bash

main() {
    {
        echo "NEXT_PUBLIC_API_URL: $NEXT_PUBLIC_API_URL"
        echo "NEXT_PUBLIC_SSG_API_URL: $NEXT_PUBLIC_SSG_API_URL"
    } >> ./.env
}

main