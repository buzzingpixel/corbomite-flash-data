@echo off

docker-compose up -d
docker exec -it --user root --workdir /app php-corbomite-flash-data bash -c "php %*"
