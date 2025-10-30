#!/bin/bash

if [ ! -f "./vendor/bin/sail" ]; then
  echo "Laravel Sail not found. Please run 'composer install' first."
  exit 1
fi

./vendor/bin/sail up -d
