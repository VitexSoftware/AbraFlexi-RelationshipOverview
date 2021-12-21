FROM debian:latest
MAINTAINER Vítězslav Dvořák <info@vitexsoftware.cz>
ENV DEBIAN_FRONTEND=noninteractive
ENV APACHE_DOCUMENT_ROOT /usr/share/abraflexi-relationship
ENV CURRENT=7.4

RUN apt update
RUN apt-get update && apt-get install -my wget gnupg lsb-release

RUN echo "deb http://repo.vitexsoftware.cz $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/vitexsoftware.list
RUN echo "deb http://repo.vitexsoftware.com $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/vitexsoftware.list
RUN wget -O /etc/apt/trusted.gpg.d/vitexsoftware.gpg http://repo.vitexsoftware.com/keyring.gpg
RUN apt update
RUN apt-get -y upgrade
RUN apt -y install apache2 libapache2-mod-php php-pear php-curl php-mbstring curl composer php-intl locales-all unzip ssmtp abraflexi-relationship
RUN a2dissite 000-default
RUN a2enconf abraflexi-relationship

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


RUN sudo cp /etc/php/${CURRENT}/apache2/php.ini /etc/php/${CURRENT}/apache2/php.ini.bak
RUN sudo cp /usr/lib/php/${CURRENT}/php.ini-development /etc/php/${CURRENT}/apache2/php.ini

RUN sudo cp /etc/php/${CURRENT}/cli/php.ini /etc/php/${CURRENT}/cli/php.ini.bak
RUN sudo cp /usr/lib/php/${CURRENT}/php.ini-development /etc/php/${CURRENT}/cli/php.ini

    
COPY debian/conf/mail.ini   /etc/php/${CURRENT}/conf.d/mail.ini
COPY debian/conf/ssmtp.conf /etc/ssmtp/ssmtp.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
EXPOSE 80
CMD ["/usr/sbin/apachectl","-DFOREGROUND"]
