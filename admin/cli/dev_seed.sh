#!/bin/bash
docker compose exec backend php artisan migrate --force
docker compose exec backend php artisan db:seed --force
