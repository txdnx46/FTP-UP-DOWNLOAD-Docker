FROM php:7.4-apache

RUN docker-php-ext-install mysqli
# ถ้าไม่มีตัวนี้ อาจเกิด erorr นี้ได้ Uncaught Error: Class "mysqli" not found

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80
