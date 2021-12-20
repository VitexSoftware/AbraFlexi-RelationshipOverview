FROM debian:latest
MAINTAINER Vítězslav Dvořák <info@vitexsoftware.cz>
ENV DEBIAN_FRONTEND=noninteractive

RUN apt update
RUN apt-get update && apt-get install -my wget gnupg lsb-release

RUN echo "deb http://repo.vitexsoftware.com $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/vitexsoftware.list
RUN wget -O /etc/apt/trusted.gpg.d/vitexsoftware.gpg http://repo.vitexsoftware.com/keyring.gpg
RUN apt update
RUN apt-get -y upgrade
RUN apt -y install apache2 libapache2-mod-php php-pear php-curl php-mbstring curl composer php-intl php-gettext locales-all unzip ssmtp abraflexi-relationship
    
COPY debian/conf/mail.ini   /etc/php/7.0/conf.d/mail.ini
COPY debian/conf/ssmtp.conf /etc/ssmtp/ssmtp.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
EXPOSE 80
CMD ["/usr/sbin/apachectl","-DFOREGROUND"]
