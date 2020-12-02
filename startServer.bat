
@echo off
echo 'Starting server at port 8080 with WEBROOT is root directory'
cd "./"
php -S 127.0.0.1:8080 -t WEBROOT
