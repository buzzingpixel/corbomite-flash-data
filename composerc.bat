@echo off

docker exec -it --user root --workdir /app php-corbomite-flash-data bash -c "composer %*"
