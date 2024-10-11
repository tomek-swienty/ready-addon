FROM php:8.0
RUN apt-get update \
  && apt-get install -y postgresql postgresql-contrib \
  && apt-get install sudo \
  && apt-get install -y libpq-dev \
  && docker-php-ext-install pgsql \
  && docker-php-ext-install pdo pdo_pgsql \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
  
  
ENTRYPOINT ["tail"]
CMD ["-f","/dev/null"]