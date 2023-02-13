FROM php:7-fpm

RUN apt-get update && apt-get upgrade -y

# PDO Mysql
############################################
RUN docker-php-ext-install pdo pdo_mysql

# sendmail config
############################################
RUN apt-get install -y ssmtp mailutils

# root is the person who gets all mail for userids < 1000
RUN echo "root=labalette.antoine@gmail.com" >> /etc/ssmtp/ssmtp.conf

# Here is the gmail configuration (or change it to your private smtp server)
RUN echo "mailhub=smtp.gmail.com:465" >> /etc/ssmtp/ssmtp.conf
RUN echo "FromLineOverride=YES" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthUser=labalette.antoine@gmail.com" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthPass=lynnuqfxidklnscs" >> /etc/ssmtp/ssmtp.conf

RUN echo "UseTLS=YES" >> /etc/ssmtp/ssmtp.conf

# Set up php sendmail config
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini

# Choose initial configuration
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini