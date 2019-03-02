FROM php:5.6-cli
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ git zip unzip
#RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo intl pdo_mysql mysqli

# Set the working directory to /app
WORKDIR /typingtarzan

# Copy the current directory contents into the container at /app
COPY ./typingtarzan .

RUN php installer

# hide root warning for composer and
# install dependencies for cakephp project
RUN export COMPOSER_ALLOW_SUPERUSER=1 && php composer.phar install

# launch processes
COPY ./start.sh /
ENTRYPOINT sh "/start.sh"
