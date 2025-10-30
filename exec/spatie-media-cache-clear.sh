#!/usr/bin/env bash

./vendor/bin/sail php artisan optimize:clear

./vendor/bin/sail php artisan media-library:clear
