FROM alpine:3.12 AS git
WORKDIR /opt/kimai
RUN apk add --no-cache git && \
    git clone --depth 1 https://github.com/tobybatch/fht.git /opt/bfv && \
    rm -r tests || true

FROM composer:1.9 AS composer
RUN mkdir /opt/bfv && \
    composer require --working-dir=/opt/bfv hirak/prestissimo

FROM php:7.4.7-fpm-alpine3.12 AS fpm-alpine-php-ext-base
RUN apk add --no-cache \
    # build-tools
    autoconf \
    dpkg \
    dpkg-dev \
    file \
    g++ \
    gcc \
    libatomic \
    libc-dev \
    libgomp \
    libmagic \
    m4 \
    make \
    mpc1 \
    mpfr4 \
    musl-dev \
    perl \
    re2c \
    # gd
    freetype-dev \
    libpng-dev \
    # icu
    icu-dev \
    # zip
    libzip-dev \
    # xsl
    libxslt-dev

FROM fpm-alpine-php-ext-base AS php-ext-gd
RUN docker-php-ext-configure gd --with-freetype && \
    docker-php-ext-install -j$(nproc) gd

# php extension intl : 15.26s
FROM fpm-alpine-php-ext-base AS php-ext-intl
RUN docker-php-ext-install -j$(nproc) intl

# php extension pdo_mysql : 6.14s
FROM fpm-alpine-php-ext-base AS php-ext-pdo_mysql
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# php extension zip : 8.18s
FROM fpm-alpine-php-ext-base AS php-ext-zip
RUN docker-php-ext-install -j$(nproc) zip

# php extension xsl : ?.?? s
FROM fpm-alpine-php-ext-base AS php-ext-xsl
RUN docker-php-ext-install -j$(nproc) xsl

FROM php:7.4.7-fpm-alpine3.12 AS fpm-alpine-base
RUN apk add --no-cache \
        bash \
        freetype \
        haveged \
        icu \
        libldap \
        libpng \
        libzip \
        libxslt-dev && \
    touch /use_fpm

EXPOSE 9000

FROM fpm-alpine-base AS base
LABEL maintainer="tobias@neontribe.co.uk"
ARG TZ=Europe/London
ENV TZ=${TZ}
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone && \
    # make composer home dir
    mkdir /composer  && \
    chown -R www-data:www-data /composer
# copy startup script
COPY startup.sh /startup.sh

# copy composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=composer --chown=www-data:www-data /opt/bfv/vendor /opt/bfv/vendor

# copy php extensions

# PHP extension xsl
COPY --from=php-ext-xsl /usr/local/etc/php/conf.d/docker-php-ext-xsl.ini /usr/local/etc/php/conf.d/docker-php-ext-xsl.ini
COPY --from=php-ext-xsl /usr/local/lib/php/extensions/no-debug-non-zts-20190902/xsl.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/xsl.so
# PHP extension pdo_mysql
COPY --from=php-ext-pdo_mysql /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini
COPY --from=php-ext-pdo_mysql /usr/local/lib/php/extensions/no-debug-non-zts-20190902/pdo_mysql.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/pdo_mysql.so
# PHP extension zip
COPY --from=php-ext-zip /usr/local/etc/php/conf.d/docker-php-ext-zip.ini /usr/local/etc/php/conf.d/docker-php-ext-zip.ini
COPY --from=php-ext-zip /usr/local/lib/php/extensions/no-debug-non-zts-20190902/zip.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/zip.so
# PHP extension gd
COPY --from=php-ext-gd /usr/local/etc/php/conf.d/docker-php-ext-gd.ini /usr/local/etc/php/conf.d/docker-php-ext-gd.ini
COPY --from=php-ext-gd /usr/local/lib/php/extensions/no-debug-non-zts-20190902/gd.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/gd.so
# PHP extension intl
COPY --from=php-ext-intl /usr/local/etc/php/conf.d/docker-php-ext-intl.ini /usr/local/etc/php/conf.d/docker-php-ext-intl.ini
COPY --from=php-ext-intl /usr/local/lib/php/extensions/no-debug-non-zts-20190902/intl.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/intl.so

ENV DATABASE_URL=sqlite:///%kernel.project_dir%/var/data/bfv.sqlite
ENV APP_SECRET=change_this_to_something_unique
# The default container name for nginx is nginx
ENV TRUSTED_PROXIES=nginx,localhost,127.0.0.1
ENV TRUSTED_HOSTS=nginx,localhost,127.0.0.1

VOLUME [ "/opt/bfv" ]
ENTRYPOINT /startup.sh



###########################
# final build
###########################
FROM base AS prod
# copy bfv production source
COPY --from=git --chown=www-data:www-data /opt/bfv /opt/bfv
COPY monolog-prod.yaml /opt/bfv/config/packages/prod/monolog.yaml
WORKDIR /opt/bfv
RUN apk add --no-cache nodejs npm
RUN npm install yarn
RUN node_modules/.bin/yarn install
RUN \
    echo APP_ENV=prod > /opt/bfv/.env && \
    composer install --working-dir=/opt/bfv --no-dev --optimize-autoloader && \
    composer require symfony/dotenv && \
    mkdir -p /opt/bfv/var/cache && \
    composer clearcache && \
    chown -R www-data:www-data /opt/bfv && \
    cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

ENV APP_ENV=prod




