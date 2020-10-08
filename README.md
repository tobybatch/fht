    docker run \
        -d \
        --rm \
        --name bfv_sql \
        -p3106:3306 \
        -v mysql:/var/lib/mysql \
        -e MYSQL_DATABASE=bfv \
        -e MYSQL_USER=bfv \
        -e MYSQL_PASSWORD=bfv \
        -e MYSQL_ROOT_PASSWORD=bfv \
        mysql:8

    ./bin/console doctrine:schema:create
    ./bin/console doctrine:fixtures:load
