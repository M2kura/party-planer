#!/bin/bash
docker compose exec backend php artisan db:wipe --force
